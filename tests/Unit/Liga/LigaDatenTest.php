<?php

namespace Lmo\Tests\Unit\Liga;

use Lmo\Liga\LigaDaten;
use PHPUnit\Framework\TestCase;

/**
 * LigaDaten buendelt die Werte, die lmo-openfile.php aus einer Ligadatei liest.
 */
class LigaDatenTest extends TestCase
{
    public function testFelderAreTheNamesOfTheOldVariables(): void
    {
        $felder = LigaDaten::felder();

        foreach (['titel', 'lmtype', 'anzteams', 'anzst', 'pns', 'teams', 'teamk', 'goala', 'goalb', 'mterm', 'playoffmode'] as $name) {
            self::assertContains($name, $felder);
        }
        self::assertSame($felder, array_unique($felder));
        // kommen (auch) aus dem Seitenaufruf und gehoeren nicht zur Datei
        self::assertNotContains('st', $felder);
        self::assertNotContains('file', $felder);
    }

    public function testNothingIsSetBeforeAFileIsLoaded(): void
    {
        self::assertSame([], array_filter(get_object_vars(new LigaDaten()), static fn ($value): bool => $value !== null));
    }

    /**
     * Laedt eine echte Ligadatei mit dem unveraenderten Lader und prueft, dass Variable und
     * Eigenschaft dieselbe Stelle sind.
     *
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function testLoaderBindsTheOldVariablesToTheObject(): void
    {
        require __DIR__ . '/fixtures/load.php';
        /**
         * Der Lader legt seine Variablen hier im Test an:
         *
         * @var LigaDaten $ligaDaten
         * @var string $titel
         * @var mixed $anzteams
         * @var array<int|string, string> $teams
         * @var array<int, array<int, mixed>> $goala
         * @var mixed $klfin
         */
        self::assertInstanceOf(LigaDaten::class, $ligaDaten);
        self::assertSame('1. Bundesliga 2024/25', $titel);
        self::assertSame($titel, $ligaDaten->titel);
        self::assertSame('18', $ligaDaten->anzteams);
        self::assertSame($teams, $ligaDaten->teams);
        self::assertSame($goala, $ligaDaten->goala);
        self::assertCount(20, $ligaDaten->teams, '18 Mannschaften, Platzhalter 0 und ein Leerfeld');

        // Aendern ueber das Objekt wirkt auf die alte Variable ...
        $ligaDaten->titel = 'Neuer Name';
        $ligaDaten->teams[1] = 'Umbenannt';
        self::assertSame('Neuer Name', $titel);
        self::assertSame('Umbenannt', $teams[1]);

        // ... und umgekehrt, auch wenn alter Code ein ganzes Array neu zuweist
        $anzteams = 4;
        $goala = [[1, 2]];
        self::assertSame(4, $ligaDaten->anzteams);
        self::assertSame([[1, 2]], $ligaDaten->goala);

        // nur fuer Pokal belegt: bleibt fuer eine Liga leer, ohne dass isset() sich aendert
        self::assertNull($ligaDaten->klfin);
        self::assertFalse(isset($klfin));
    }

    public function testVorgabewerteEinerLiga(): void
    {
        $liga = new LigaDaten();
        $liga->setzeStartwerte();

        $liga->ergaenzeVorgabewerte('d.m.Y H:i');

        self::assertSame(18, $liga->anzteams);
        self::assertSame(9.0, $liga->anzsp, 'halb so viele Partien wie Mannschaften');
        self::assertSame(34.0, $liga->anzst, 'jeder gegen jeden, Hin- und Rueckrunde');
        self::assertSame([3, 1, 0], [$liga->pns, $liga->pnu, $liga->pnn]);
        self::assertSame([1, 1, 2, 2, 0, 3], [$liga->champ, $liga->anzcl, $liga->anzck, $liga->anzuc, $liga->anzar, $liga->anzab]);
        self::assertSame('d.m.Y H:i', $liga->datf);
        self::assertSame('k.A.', $liga->lmvers);
        self::assertSame([1, 0, 0], [$liga->dats, $liga->datm, $liga->datc], 'datc steht schon durch die Startwerte auf 0');
        self::assertSame([1, 1], [$liga->goalfaktor, $liga->pointsfaktor]);
        self::assertSame(['', ''], [$liga->namepkt, $liga->nametor]);
        // nur fuer Pokal
        self::assertNull($liga->klfin);
        self::assertNull($liga->spez);
    }

    public function testVorgabewerteLassenWerteAusDerDateiStehen(): void
    {
        $liga = new LigaDaten();
        $liga->setzeStartwerte();
        $liga->anzteams = '4';
        $liga->pns = '2';
        $liga->titel = 'Kreisliga';
        $liga->goalfaktor = '';
        $liga->anzab = '0';

        $liga->ergaenzeVorgabewerte('d.m.Y');

        self::assertSame('4', $liga->anzteams);
        self::assertSame(2.0, $liga->anzsp);
        self::assertSame(6.0, $liga->anzst);
        self::assertSame('2', $liga->pns);
        self::assertSame('Kreisliga', $liga->titel);
        self::assertSame(1, $liga->goalfaktor, 'ein leerer Faktor zaehlt als fehlend');
        self::assertSame('0', $liga->anzab, '0 ist ein Wert, kein fehlender');
    }

    public function testVorgabewerteEinesPokals(): void
    {
        $pokal = new LigaDaten();
        $pokal->setzeStartwerte();
        $pokal->lmtype = '1';
        $pokal->anzsp = '99';
        $pokal->anzst = '99';

        $pokal->ergaenzeVorgabewerte('d.m.Y');

        self::assertSame(16, $pokal->anzteams);
        self::assertSame(8.0, $pokal->anzsp, 'wird im Pokal immer berechnet');
        self::assertSame(4, $pokal->anzst, '16 Mannschaften: Achtelfinale bis Finale');
        self::assertSame([1, 0], [$pokal->spez, $pokal->hands]);
        self::assertSame([0, 0, 0], [$pokal->klfin, $pokal->playdown, $pokal->playoffmode]);
        // nur fuer Liga
        self::assertNull($pokal->pns);
        self::assertNull($pokal->tabelle);
    }

    /** @return array<string, array{int|string|null, int|string|null, int|string, int|string}> */
    public static function fieberkurven(): array
    {
        return [
            'nichts gewaehlt' => [null, null, 0, 0],
            'zwei verschiedene' => ['3', '5', '3', '5'],
            'zweimal dieselbe' => ['3', '3', '3', 0],
            'nur die zweite' => ['0', '5', '5', 0],
            'nur die erste' => ['3', null, '3', 0],
        ];
    }

    /**
     * @dataProvider fieberkurven
     * @param int|string|null $stat1
     * @param int|string|null $stat2
     * @param int|string $erwartet1
     * @param int|string $erwartet2
     */
    public function testVorgabewerteOrdnenDieFieberkurve($stat1, $stat2, $erwartet1, $erwartet2): void
    {
        $liga = new LigaDaten();
        $liga->setzeStartwerte();
        $liga->stat1 = $stat1;
        $liga->stat2 = $stat2;

        $liga->ergaenzeVorgabewerte('d.m.Y');

        self::assertSame([$erwartet1, $erwartet2], [$liga->stat1, $liga->stat2]);
    }

    public function testStartwerteSetzenNurWasNichtUebrigBleibenDarf(): void
    {
        $liga = new LigaDaten();
        $liga->titel = 'vorige Liga';
        $liga->lmtype = '1';
        $liga->anzteams = '8';

        $liga->setzeStartwerte();

        self::assertSame('', $liga->titel);
        self::assertSame(0, $liga->lmtype);
        self::assertSame('8', $liga->anzteams, 'bleibt, bis die Datei oder die Vorgabewerte es setzen');
    }

    /** @return array<string, array{string}> */
    public static function kleineLader(): array
    {
        return ['lmo-openfilename.php' => ['lmo-openfilename.php'], 'lmo-openfiledat.php' => ['lmo-openfiledat.php']];
    }

    /**
     * Die beiden abgespeckten Lader (Tippspiel, Benutzerverwaltung) lesen nur wenige Schluessel.
     * Fehlt die Anzahl der Spieltage, ergibt sie sich wie im Hauptlader aus der Anzahl der Mannschaften.
     *
     * @dataProvider kleineLader
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function testKleinerLaderErgaenztFehlendeSpieltage(string $testLader): void
    {
        $file = 'ohne-rounds.l98';
        require __DIR__ . '/fixtures/load-with.php';
        /** @var LigaDaten $ligaDaten */
        self::assertSame('Ohne Spieltage', $ligaDaten->titel);
        self::assertSame('4', $ligaDaten->anzteams);
        self::assertSame(2.0, $ligaDaten->anzsp);
        self::assertSame(6.0, $ligaDaten->anzst);
        self::assertSame(1, $ligaDaten->stx);
        self::assertSame('k.A.', $ligaDaten->lmvers);
    }

    /**
     * @dataProvider kleineLader
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function testKleinerLaderBerechnetDenPokal(string $testLader): void
    {
        $file = 'pokal.l98';
        require __DIR__ . '/fixtures/load-with.php';
        /** @var LigaDaten $ligaDaten */
        self::assertSame('Kleiner Pokal', $ligaDaten->titel);
        self::assertSame(4.0, $ligaDaten->anzsp);
        self::assertSame(3, $ligaDaten->anzst, '8 Mannschaften: Viertelfinale bis Finale');
    }

    /**
     * @dataProvider kleineLader
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function testKleinerLaderOhneOptionsNimmtDieVorgaben(string $testLader): void
    {
        $file = 'ohne-options.l98';
        require __DIR__ . '/fixtures/load-with.php';
        /** @var LigaDaten $ligaDaten */
        self::assertSame('No Name', $ligaDaten->titel);
        self::assertSame(18, $ligaDaten->anzteams);
        self::assertSame(34.0, $ligaDaten->anzst);
    }

    /**
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function testOpenfiledatLiestDenSpielplan(): void
    {
        $testLader = 'lmo-openfiledat.php';
        $file = 'ohne-rounds.l98';
        require __DIR__ . '/fixtures/load-with.php';
        /** @var LigaDaten $ligaDaten */
        self::assertSame('A', $ligaDaten->teams[1]);
        self::assertSame('1', $ligaDaten->teama[0][0]);
        self::assertSame('2', $ligaDaten->teamb[0][0]);
        self::assertSame('1724421600', $ligaDaten->mterm[0][0]);
        self::assertSame([1, 0], [$ligaDaten->dats, $ligaDaten->datm]);
    }

    public function testSetzeOptionOrdnetSchluesselDenFeldernZu(): void
    {
        $liga = new LigaDaten();
        $liga->setzeStartwerte();

        $liga->setzeOption('Title', 'Liga Manager Online 4');
        $liga->setzeOption('Name', "O\\'Neill-Liga");
        $liga->setzeOption('Teams', '4');
        $liga->setzeOption('PointsForWin', '2');
        $liga->setzeOption('DatF', 'd.m.Y');
        $liga->setzeOption('gibtEsNicht', 'x');

        self::assertSame('Liga Manager Online 4', $liga->lmvers);
        self::assertSame("O'Neill-Liga", $liga->titel, 'der Name steht mit Schraegstrichen in der Datei');
        self::assertSame('4', $liga->anzteams);
        self::assertSame('2', $liga->pns);
        self::assertSame('d.m.Y', $liga->datf);
    }

    public function testSetzeOptionUebergehtSchluesselDesAnderenTyps(): void
    {
        $liga = new LigaDaten();
        $liga->setzeStartwerte();
        $liga->setzeOption('Type', '0');
        $liga->setzeOption('KlFin', '1');
        $liga->setzeOption('Rounds', '6');
        self::assertNull($liga->klfin, 'Spiel um Platz 3 gibt es nur im Pokal');
        self::assertSame('6', $liga->anzst);

        $pokal = new LigaDaten();
        $pokal->setzeStartwerte();
        $pokal->setzeOption('Type', '1');
        $pokal->setzeOption('KlFin', '1');
        $pokal->setzeOption('Rounds', '6');
        $pokal->setzeOption('PointsForWin', '2');
        self::assertSame('1', $pokal->klfin);
        self::assertNull($pokal->anzst, 'die Zahl der Runden wird im Pokal berechnet');
        self::assertNull($pokal->pns);
    }

    /** Die Reihenfolge in der Datei zaehlt: vor "Type" gilt die Datei als Liga. */
    public function testSetzeOptionRichtetSichNachDemBisherGelesenenTyp(): void
    {
        $pokal = new LigaDaten();
        $pokal->setzeStartwerte();
        $pokal->setzeOption('Rounds', '6');
        $pokal->setzeOption('Type', '1');

        self::assertSame('6', $pokal->anzst);
    }

    public function testSetzeOptionLaesstWerteAusDemSeitenaufrufStehen(): void
    {
        $liga = new LigaDaten();
        $liga->setzeStartwerte();
        $liga->selteam = '7';
        $liga->stat1 = '3';

        $liga->setzeOption('selTeam', '1');
        $liga->setzeOption('kurve1', '5');
        $liga->setzeOption('kurve2', '6');
        $liga->setzeOption('favTeam', '2');

        self::assertSame('7', $liga->selteam);
        self::assertSame('3', $liga->stat1);
        self::assertSame('6', $liga->stat2, 'war noch nicht gewaehlt');
        self::assertSame('2', $liga->favteam);
    }

    /**
     * @param list<array{string, string}> $zeilen
     * @return string[]
     */
    private static function schluessel(array $zeilen): array
    {
        return array_column($zeilen, 0);
    }

    public function testOptionenEinerLigaZumSpeichern(): void
    {
        $liga = new LigaDaten();
        $liga->setzeStartwerte();
        $liga->setzeOption('Title', 'alter LMO');
        $liga->setzeOption('Name', 'Kreisliga');
        $liga->setzeOption('Teams', '4');
        $liga->ergaenzeVorgabewerte('d.m.Y');

        $zeilen = $liga->optionenZumSpeichern('Liga Manager Online 4', 3);

        self::assertSame([
            'Title', 'Name', 'Type', 'Teams', 'goalfaktor', 'pointsfaktor', 'enableGameSort', 'Rounds', 'Matches', 'Actual',
            'Kegel', 'HandS', 'PointsForWin', 'PointsForDraw', 'PointsForLost', 'Spez', 'HideDraw', 'OnRun',
            'MinusPoints', 'Direct', 'Champ', 'CL', 'CK', 'UC', 'AR', 'AB', 'namePkt', 'nameTor', 'tableHinRueck', 'tableHeimAusw',
            'DatC', 'DatS', 'DatM', 'DatF', 'urlT', 'urlB', 'Plan', 'Ergebnis', 'mittore', 'favTeam', 'selTeam', 'ticker',
            'Graph', 'Kreuz', 'Tabelle', 'Ligastats', 'kurve1', 'kurve2',
        ], self::schluessel($zeilen));
        $werte = array_column($zeilen, 1, 0);
        self::assertSame('Liga Manager Online 4', $werte['Title'], 'der Name des Programms, nicht die gelesene Version');
        self::assertSame('Kreisliga', $werte['Name']);
        self::assertSame('3', $werte['Actual']);
        self::assertSame('6', $werte['Rounds'], 'berechnete Kommazahl ohne Nachkommastellen');
        self::assertSame('2', $werte['Matches']);
        self::assertSame('', $werte['Direct'], 'ohne Vorgabewert: leer');
    }

    public function testPunkteFuerVerlaengerungStehenNurMitSpezInDerDatei(): void
    {
        $liga = new LigaDaten();
        $liga->setzeStartwerte();
        $liga->ergaenzeVorgabewerte('d.m.Y');
        self::assertNotContains('XtraS', self::schluessel($liga->optionenZumSpeichern('LMO', 1)));

        $liga->spez = '1';
        $schluessel = self::schluessel($liga->optionenZumSpeichern('LMO', 1));

        self::assertSame(
            ['Spez', 'HideDraw', 'OnRun', 'XtraS', 'XtraU', 'XtraV', 'SpezS', 'SpezU', 'SpezV', 'MinusPoints'],
            array_slice($schluessel, array_search('Spez', $schluessel, true), 10)
        );
    }

    public function testEigeneBezeichnungenStehenNurGesetztInDerDatei(): void
    {
        $liga = new LigaDaten();
        $liga->setzeStartwerte();
        $liga->ergaenzeVorgabewerte('d.m.Y');
        $liga->namepkt = null;
        $liga->nametor = 'Koerbe';

        $werte = array_column($liga->optionenZumSpeichern('LMO', 1), 1, 0);

        self::assertArrayNotHasKey('namePkt', $werte);
        self::assertSame('Koerbe', $werte['nameTor']);
    }

    public function testOptionenEinesPokalsZumSpeichern(): void
    {
        $pokal = new LigaDaten();
        $pokal->setzeStartwerte();
        $pokal->setzeOption('Type', '1');
        $pokal->setzeOption('Teams', '8');
        $pokal->setzeOption('KlFin', '1');
        $pokal->ergaenzeVorgabewerte('d.m.Y');

        $zeilen = $pokal->optionenZumSpeichern('LMO', 2);

        self::assertSame([
            'Title', 'Name', 'Type', 'Teams', 'goalfaktor', 'pointsfaktor', 'enableGameSort', 'Actual',
            'KlFin', 'playdown', 'playoffmode',
            'DatC', 'DatS', 'DatM', 'DatF', 'urlT', 'urlB', 'Plan', 'Ergebnis', 'mittore', 'favTeam', 'selTeam', 'ticker',
        ], self::schluessel($zeilen));
        self::assertSame('1', array_column($zeilen, 1, 0)['KlFin']);
    }

    /** Was gespeichert wird, liest setzeOption() wieder genauso ein. */
    public function testGespeicherteOptionenWerdenWiederGleichGelesen(): void
    {
        $liga = new LigaDaten();
        $liga->setzeStartwerte();
        foreach (['Name' => 'Bezirksliga', 'Teams' => '6', 'Spez' => '1', 'XtraS' => '2', 'PointsForWin' => '2', 'AB' => '1', 'DatF' => 'd.m.'] as $schluessel => $wert) {
            $liga->setzeOption($schluessel, $wert);
        }
        $liga->ergaenzeVorgabewerte('d.m.Y');
        $zeilen = $liga->optionenZumSpeichern('LMO', $liga->stx);

        $wieder = new LigaDaten();
        $wieder->setzeStartwerte();
        foreach ($zeilen as [$schluessel, $wert]) {
            $wieder->setzeOption($schluessel, $wert);
        }
        $wieder->ergaenzeVorgabewerte('d.m.Y');

        self::assertSame($zeilen, $wieder->optionenZumSpeichern('LMO', $wieder->stx));
    }

    private static function ligaMitDreiMannschaften(): LigaDaten
    {
        $liga = new LigaDaten();
        $liga->setzeStartwerte();
        $liga->setzeOption('Teams', '3');
        $liga->ergaenzeVorgabewerte('d.m.Y');
        $liga->bereiteMannschaftenVor();

        return $liga;
    }

    public function testMannschaftenBekommenFelderInVollerGroesse(): void
    {
        $liga = self::ligaMitDreiMannschaften();

        self::assertSame(['___', '', '', '', ''], $liga->teams, 'Platz 0, drei Mannschaften, ein Platz dahinter');
        self::assertSame(['___', '', '', '', ''], $liga->teamk);
        self::assertSame(['', '', '', '', ''], $liga->teamu);
        self::assertCount(116, $liga->strafp);
        self::assertSame(['0'], array_values(array_unique($liga->strafp)));
        self::assertCount(116, $liga->strafdat);
    }

    public function testImPokalBleibenStrafenUnberuehrt(): void
    {
        $pokal = new LigaDaten();
        $pokal->setzeStartwerte();
        $pokal->setzeOption('Type', '1');
        $pokal->setzeOption('Teams', '4');
        $pokal->ergaenzeVorgabewerte('d.m.Y');

        $pokal->bereiteMannschaftenVor();
        $pokal->setzeMannschaftswert('Team1', 'SP', '3');
        $pokal->setzeMannschaftswert('Team1', 'URL', 'http://a.example');

        self::assertCount(6, $pokal->teams);
        self::assertNull($pokal->strafp);
        self::assertSame('http://a.example', $pokal->teamu[1]);
    }

    public function testMannschaftswerteAusDerDatei(): void
    {
        $liga = self::ligaMitDreiMannschaften();

        $liga->setzeMannschaftswert('Teams', '1', "FC M\'gladbach");
        $liga->setzeMannschaftswert('Teamk', '1', 'FCM');
        $liga->setzeMannschaftswert('Team1', 'SP', '-3');
        $liga->setzeMannschaftswert('Team1', 'STDA', '5');
        $liga->setzeMannschaftswert('Team1', 'NOT', 'Notiz');
        $liga->setzeMannschaftswert('Team1', 'XY', 'unbekannter Schluessel');
        $liga->setzeMannschaftswert('Round1', 'SP', '2');
        $liga->setzeMannschaftswert('Options', 'Teams', '99');

        self::assertSame("FC M'gladbach", $liga->teams[1]);
        self::assertSame('FCM', $liga->teamk[1]);
        self::assertSame('-3', $liga->strafp[1]);
        self::assertSame('5', $liga->strafdat[1]);
        self::assertSame('Notiz', $liga->teamn[1]);
        self::assertSame('0', $liga->strafp[2]);
        self::assertSame('3', $liga->anzteams);
    }

    /** @return array<string, array{string, string, string}> */
    public static function mannschaftsnamen(): array
    {
        return [
            'laengstes Wort' => ['Hamburger SV', 'Hamburger', 'Hambu'],
            'gleich lang: das letzte' => ['Rot Weiss Essen', 'Essen', 'Rot W'],
            'hoechstens 12 Zeichen' => ['Unterhachinger SpVgg', 'Unterhaching', 'Unter'],
            'Schraegstrich trennt' => ['SG Wattenscheid/Bochum', 'Wattenscheid', 'SG Wa'],
            'ein kurzes Wort' => ['VfL', 'VfL', 'VfL'],
            'ohne Namen' => ['', '', ''],
        ];
    }

    /** @dataProvider mannschaftsnamen */
    public function testFehlendeKurzUndMittelnamenWerdenAbgeleitet(string $name, string $mittel, string $kurz): void
    {
        $liga = self::ligaMitDreiMannschaften();
        $liga->setzeMannschaftswert('Teams', '2', $name);

        $liga->ergaenzeMannschaftsnamen();

        self::assertSame($mittel, $liga->teamm[2]);
        self::assertSame($kurz, $liga->teamk[2]);
    }

    public function testVorhandeneKurzUndMittelnamenBleiben(): void
    {
        $liga = self::ligaMitDreiMannschaften();
        $liga->setzeMannschaftswert('Teams', '1', 'TSG 1899 Hoffenheim');
        $liga->setzeMannschaftswert('Teamm', '1', 'Hoffenheim');
        $liga->setzeMannschaftswert('Teamk', '1', 'TSG');

        $liga->ergaenzeMannschaftsnamen();

        self::assertSame('Hoffenheim', $liga->teamm[1]);
        self::assertSame('TSG', $liga->teamk[1]);
        self::assertSame('___', $liga->teamm[0]);
    }

    public function testMannschaftenZumSpeichern(): void
    {
        $liga = self::ligaMitDreiMannschaften();
        $liga->setzeMannschaftswert('Teams', '1', 'Alpha');
        $liga->setzeMannschaftswert('Team1', 'SP', '2');
        $liga->setzeMannschaftswert('Team1', 'SM', '1');
        $liga->setzeMannschaftswert('Team1', 'URL', 'http://alpha.example');

        $abschnitte = $liga->mannschaftenZumSpeichern();

        self::assertSame(['Teams', 'Teamm', 'Teamk', 'Team1', 'Team2', 'Team3'], array_column($abschnitte, 0));
        self::assertSame([['1', 'Alpha'], ['2', ''], ['3', '']], $abschnitte[0][1]);
        self::assertSame(
            [['SP', '2'], ['TOR1', '0'], ['TOR2', '0'], ['STDA', '0'], ['URL', 'http://alpha.example'], ['NOT', '']],
            $abschnitte[3][1],
            'ohne Minuspunkte steht SM nicht in der Datei'
        );

        $liga->minus = '2';
        self::assertSame(['SP', 'SM', 'TOR1', 'TOR2', 'STDA', 'URL', 'NOT'], array_column($liga->mannschaftenZumSpeichern()[3][1], 0));
    }

    public function testMannschaftenEinesPokalsZumSpeichern(): void
    {
        $pokal = new LigaDaten();
        $pokal->setzeStartwerte();
        $pokal->setzeOption('Type', '1');
        $pokal->setzeOption('Teams', '2');
        $pokal->ergaenzeVorgabewerte('d.m.Y');
        $pokal->bereiteMannschaftenVor();

        self::assertSame([['URL', ''], ['NOT', '']], $pokal->mannschaftenZumSpeichern()[3][1]);
    }

    private static function ligaMitSpieltagen(string $spez = '1'): LigaDaten
    {
        $liga = self::ligaMitDreiMannschaften();
        $liga->spez = $spez;
        $liga->bereiteSpieltageVor();

        return $liga;
    }

    private static function pokalMitRunden(): LigaDaten
    {
        $pokal = new LigaDaten();
        $pokal->setzeStartwerte();
        $pokal->setzeOption('Type', '1');
        $pokal->setzeOption('Teams', '4');
        $pokal->ergaenzeVorgabewerte('d.m.Y');
        $pokal->bereiteSpieltageVor();

        return $pokal;
    }

    public function testSpieltageEinerLigaInVollerGroesse(): void
    {
        $liga = self::ligaMitSpieltagen();

        self::assertCount(116, $liga->teama);
        self::assertCount(40, $liga->teama[115]);
        self::assertSame('0', $liga->teama[0][0]);
        self::assertSame('_', $liga->goala[115][39], 'nicht gespielt');
        self::assertSame('', $liga->mnote[0][0]);
        self::assertSame('0', $liga->msieg[0][0]);
        self::assertSame('0', $liga->mterm[0][0]);
        self::assertSame('', $liga->datum1[0]);
        self::assertSame('0', $liga->handp[0]);
        self::assertNull($liga->modus, 'nur im Pokal');
    }

    public function testRundenEinesPokalsInVollerGroesse(): void
    {
        $pokal = self::pokalMitRunden();

        self::assertCount(7, $pokal->teama);
        self::assertCount(64, $pokal->teama[6]);
        self::assertSame('0', $pokal->teama[0][0]);
        self::assertSame(['_', '_', '_', '_', '_', '_', '_'], $pokal->goala[6][63], 'sieben Spiele je Paarung');
        self::assertSame('0', $pokal->mterm[0][0][0]);
        self::assertSame('1', $pokal->modus[0]);
        self::assertNull($pokal->msieg, 'Wertung am gruenen Tisch gibt es nur in der Liga');
        self::assertNull($pokal->handp);
    }

    public function testSpieltagsIndex(): void
    {
        self::assertSame(0, LigaDaten::spieltagsIndex('Round1'));
        self::assertSame(33, LigaDaten::spieltagsIndex('Round34'));
        self::assertSame(-1, LigaDaten::spieltagsIndex('Options'));
        self::assertSame(-1, LigaDaten::spieltagsIndex('Teams'));
    }

    /** @return array<string, array{string, int|string}> */
    public static function tore(): array
    {
        return ['gespielt' => ['3', '3'], 'nicht gespielt' => ['-1', '_'], 'leer' => ['', -1], 'null Tore' => ['0', '0']];
    }

    /**
     * @dataProvider tore
     * @param int|string $anzeige
     */
    public function testToreWerdenFuerDieAnzeigeUmgerechnet(string $datei, $anzeige): void
    {
        $liga = self::ligaMitSpieltagen();
        $liga->setzeSpieltagswert('Round2', 'GA3', $datei, 'n.V.', 'i.E.');
        self::assertSame($anzeige, $liga->goala[1][2]);
        self::assertSame('0', $liga->msieg[1][2]);

        $pokal = self::pokalMitRunden();
        $pokal->setzeSpieltagswert('Round2', 'GB31', $datei, 'n.V.', 'i.E.');
        self::assertSame($anzeige, $pokal->goalb[1][2][0], 'Paarung 3, Spiel 1');
    }

    public function testWertungAmGruenenTisch(): void
    {
        $liga = self::ligaMitSpieltagen();

        $liga->setzeSpieltagswert('Round1', 'GA1', '-2', 'n.V.', 'i.E.');
        $liga->setzeSpieltagswert('Round1', 'GB2', '-2', 'n.V.', 'i.E.');
        $liga->setzeSpieltagswert('Round1', 'ET3', '3', 'n.V.', 'i.E.');
        $liga->setzeSpieltagswert('Round1', 'ET4', '2', 'n.V.', 'i.E.');

        self::assertSame(['0', 1], [$liga->goala[0][0], $liga->msieg[0][0]], 'Heim gewinnt am gruenen Tisch');
        self::assertSame(['0', 2], [$liga->goalb[0][1], $liga->msieg[0][1]], 'Gast gewinnt am gruenen Tisch');
        self::assertSame(3, $liga->msieg[0][2], 'beide verlieren');
        self::assertSame('0', $liga->msieg[0][3]);

        // im Pokal gibt es keine Wertung: -2 bleibt stehen
        $pokal = self::pokalMitRunden();
        $pokal->setzeSpieltagswert('Round1', 'GA11', '-2', 'n.V.', 'i.E.');
        self::assertSame('-2', $pokal->goala[0][0][0]);
        self::assertNull($pokal->msieg);
    }

    /** @return array<string, array{string, string}> */
    public static function zusaetze(): array
    {
        return ['ohne' => ['0', '&nbsp;'], 'nach Verlaengerung' => ['2', 'n.V.'], 'im Elfmeterschiessen' => ['1', 'i.E.'], 'unbekannt' => ['5', '5'], 'leer' => ['', '']];
    }

    /** @dataProvider zusaetze */
    public function testZusatzWirdZumAnzeigetext(string $datei, string $anzeige): void
    {
        $liga = self::ligaMitSpieltagen('1');
        $liga->setzeSpieltagswert('Round1', 'SP1', $datei, 'n.V.', 'i.E.');
        self::assertSame($anzeige, $liga->mspez[0][0]);

        $ohne = self::ligaMitSpieltagen('0');
        $ohne->setzeSpieltagswert('Round1', 'SP1', $datei, 'n.V.', 'i.E.');
        self::assertSame('', $ohne->mspez[0][0], 'in der Liga nur mit Spez=1');

        $pokal = self::pokalMitRunden();
        $pokal->setzeSpieltagswert('Round1', 'SP12', $datei, 'n.V.', 'i.E.');
        self::assertSame($anzeige, $pokal->mspez[0][0][1], 'im Pokal immer');
    }

    public function testSpieltagUndPartieEinerLiga(): void
    {
        $liga = self::ligaMitSpieltagen();
        foreach (['HS' => '030102', 'D1' => '23.08.2024', 'D2' => '24.08.2024', 'TA2' => '3', 'TB2' => '1',
            'NT2' => 'Notiz', 'BE2' => 'bericht', 'TI2' => 'tipp', 'AT2' => '1724437800', 'MO' => '2', 'XY2' => 'unbekannt'] as $schluessel => $wert) {
            $liga->setzeSpieltagswert('Round3', $schluessel, $wert, 'n.V.', 'i.E.');
        }

        self::assertSame(['030102', '23.08.2024', '24.08.2024'], [$liga->handp[2], $liga->datum1[2], $liga->datum2[2]]);
        self::assertSame(['3', '1'], [$liga->teama[2][1], $liga->teamb[2][1]]);
        self::assertSame(['Notiz', 'bericht', 'tipp', '1724437800'], [$liga->mnote[2][1], $liga->mberi[2][1], $liga->mtipp[2][1], $liga->mterm[2][1]]);
        self::assertNull($liga->modus, 'MO gibt es nur im Pokal');
    }

    public function testRundeUndSpielEinesPokals(): void
    {
        $pokal = self::pokalMitRunden();
        foreach (['MO' => '2', 'D1' => '01.03.2025', 'TA2' => '3', 'TB2' => '4', 'NT21' => 'Hinspiel', 'NT22' => 'Rueckspiel',
            'AT22' => '1740826800'] as $schluessel => $wert) {
            $pokal->setzeSpieltagswert('Round1', $schluessel, $wert, 'n.V.', 'i.E.');
        }

        self::assertSame('2', $pokal->modus[0]);
        self::assertSame('01.03.2025', $pokal->datum1[0]);
        self::assertSame(['3', '4'], [$pokal->teama[0][1], $pokal->teamb[0][1]]);
        self::assertSame(['Hinspiel', 'Rueckspiel'], [$pokal->mnote[0][1][0], $pokal->mnote[0][1][1]]);
        self::assertSame('1740826800', $pokal->mterm[0][1][1]);
    }

    /** Eigenheit des alten Laders, auf die sich niemand verlassen sollte, die aber erhalten bleibt. */
    public function testJedeZeileBelegtDasHandicapIhresSpieltags(): void
    {
        $liga = self::ligaMitSpieltagen();

        $liga->setzeSpieltagswert('Options', 'Name', 'Liga', 'n.V.', 'i.E.');
        $liga->setzeSpieltagswert('Round120', 'TA1', '1', 'n.V.', 'i.E.');

        self::assertSame('0', $liga->handp[-1]);
        self::assertSame('0', $liga->handp[119]);
        self::assertSame('1', $liga->teama[119][0], 'Spieltage hinter den 116 Plaetzen werden angelegt');
    }

    /** @return array<string, array{string, string}> */
    public static function spieltagsdaten(): array
    {
        return [
            'schon richtig' => ['23.08.2024', '23.08.2024'],
            'ohne fuehrende Nullen' => ['7.9.2024', '07.09.2024'],
            'kein Kalendertag' => ['30.02.2024', ''],
            'Text' => ['ab.cd.efgh', ''],
            'unvollstaendig' => ['23.08.', ''],
            'leer' => ['', ''],
        ];
    }

    /** @dataProvider spieltagsdaten */
    public function testSpieltagsdatumWirdBereinigt(string $datei, string $bereinigt): void
    {
        $liga = self::ligaMitSpieltagen();
        $liga->setzeSpieltagswert('Round2', 'D1', $datei, 'n.V.', 'i.E.');
        $liga->setzeSpieltagswert('Round2', 'D2', $datei, 'n.V.', 'i.E.');
        $liga->setzeSpieltagswert('Round1', 'D1', '1.1.2025', 'n.V.', 'i.E.');

        $liga->bereinigeSpieltagsdatum(1);

        self::assertSame([$bereinigt, $bereinigt], [$liga->datum1[1], $liga->datum2[1]]);
        self::assertSame('1.1.2025', $liga->datum1[0], 'nur der genannte Spieltag');
    }

    public function testNewszeilen(): void
    {
        $liga = new LigaDaten();
        $liga->setzeStartwerte();
        $liga->nlines = ['alt'];
        $liga->bereiteNewsVor();
        $liga->setzeNewszeile('News', 'NC', '2');
        $liga->setzeNewszeile('News', 'N0', 'Erste \\"Meldung\\"');
        $liga->setzeNewszeile('Options', 'N1', 'gehoert nicht dazu');
        self::assertSame(['alt', 'Erste "Meldung"'], $liga->nlines, 'ohne Newsticker wird nur angehaengt');

        $liga->nticker = '1';
        $liga->bereiteNewsVor();
        $liga->setzeNewszeile('News', 'N0', 'Neu');
        self::assertSame(['Neu'], $liga->nlines, 'mit Newsticker beginnen die Zeilen leer');
    }
}
