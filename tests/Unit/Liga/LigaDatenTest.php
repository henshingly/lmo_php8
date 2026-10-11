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
}
