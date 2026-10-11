<?php

namespace Lmo\Tests\Unit\Liga;

use Lmo\Liga\Einstellungen;
use Lmo\Liga\LigaDatei;
use Lmo\Liga\LigaDaten;
use Lmo\Liga\Rohdaten\Liga;
use PHPUnit\Framework\TestCase;

/**
 * Einstellungen liefert die Werte aus [Options] mit ihren Vorgabewerten, ohne die Rohdaten zu aendern.
 */
class EinstellungenTest extends TestCase
{
    /** @param list<string> $zeilen */
    private static function liga(array $zeilen): Liga
    {
        return Liga::ausEintraegen(LigaDatei::zerlege(array_merge(['[Options]'], $zeilen)));
    }

    public function testEineLeereLigaHatDieVorgabewerte(): void
    {
        $liga = new Liga();
        $e = $liga->einstellungen();

        self::assertFalse($e->istPokal());
        self::assertSame('', $e->wert('Name'));
        self::assertSame(0, $e->wert('Type'));
        self::assertSame(18, $e->wert('Teams'));
        self::assertSame(9.0, $e->wert('Matches'));
        self::assertSame(34.0, $e->wert('Rounds'));
        self::assertSame([3, 1, 0], [$e->wert('PointsForWin'), $e->wert('PointsForDraw'), $e->wert('PointsForLost')]);
        self::assertSame(1, $e->wert('goalfaktor'));
        self::assertNull($e->wert('Spez'));
        self::assertNull($e->wert('DatF'), 'dann gilt das Format der Installation');
        self::assertNull($e->wert('KlFin'), 'gibt es nur im Pokal');
        self::assertSame([], $liga->optionen, 'die Rohdaten bleiben unveraendert');
    }

    public function testWerteAusDerDateiGehenVor(): void
    {
        $e = self::liga(["Name=O\\'Neill-Liga", 'Teams=4', 'Rounds=3', 'PointsForWin=2', 'goalfaktor=', 'Eigener=x'])->einstellungen();

        self::assertSame("O'Neill-Liga", $e->wert('Name'), 'der Name steht mit Schraegstrichen in der Datei');
        self::assertSame('4', $e->wert('Teams'));
        self::assertSame(2.0, $e->wert('Matches'), 'aus der Anzahl der Mannschaften');
        self::assertSame('3', $e->wert('Rounds'));
        self::assertSame('2', $e->wert('PointsForWin'));
        self::assertSame(1, $e->wert('goalfaktor'), 'ein leerer Faktor zaehlt als fehlend');
        self::assertSame('x', $e->wert('Eigener'), 'ein unbekannter Schluessel kommt, wie er in der Datei steht');
        self::assertNull($e->wert('GibtEsNicht'));
    }

    public function testPokal(): void
    {
        $e = self::liga(['Type=1', 'Teams=8', 'Rounds=99', 'PointsForWin=2', 'KlFin=1'])->einstellungen();

        self::assertTrue($e->istPokal());
        self::assertSame(4.0, $e->wert('Matches'));
        self::assertSame(3, $e->wert('Rounds'), 'Viertelfinale bis Finale, was auch immer in der Datei steht');
        self::assertSame('1', $e->wert('KlFin'));
        self::assertSame([0, 0], [$e->wert('playdown'), $e->wert('playoffmode')]);
        self::assertNull($e->wert('PointsForWin'), 'gibt es nur in der Liga');
        self::assertSame([1, 0], [$e->wert('Spez'), $e->wert('HandS')], 'im Pokal fest');
        self::assertSame(16, self::liga(['Type=1'])->einstellungen()->wert('Teams'));
    }

    public function testFieberkurveFuehrtEineEinzelneMannschaftAlsErste(): void
    {
        self::assertSame(['5', 0], self::kurve(['kurve2=5']));
        self::assertSame(['5', 0], self::kurve(['kurve1=5', 'kurve2=5']));
        self::assertSame(['2', '5'], self::kurve(['kurve1=2', 'kurve2=5']));
        self::assertSame([0, 0], self::kurve([]));
    }

    /**
     * @param list<string> $zeilen
     * @return array{int|float|string|null, int|float|string|null}
     */
    private static function kurve(array $zeilen): array
    {
        $e = self::liga($zeilen)->einstellungen();

        return [$e->wert('kurve1'), $e->wert('kurve2')];
    }

    public function testUnlesbareAnzahlDerMannschaftenBrichtNichtAb(): void
    {
        $e = self::liga(['Teams=viele', 'Matches=0'])->einstellungen();

        self::assertSame('0', $e->wert('Matches'));
        self::assertSame(0.0, $e->wert('Rounds'));
    }

    public function testAlleNenntJedenBekanntenSchluessel(): void
    {
        $alle = self::liga(['Teams=4'])->einstellungen()->alle();

        self::assertSame(Einstellungen::schluessel(), array_keys($alle));
        self::assertSame('4', $alle['Teams']);
        self::assertContains('PointsForWin', Einstellungen::schluessel());
    }

    /** @return array<string, array{string, string}> Methode => [Schluessel, Typ] */
    private static function methoden(): array
    {
        return [
            'name' => ['Name', 'string'],
            'programmversion' => ['Title', 'string'],
            'mannschaften' => ['Teams', 'int'],
            'spieltage' => ['Rounds', 'int'],
            'partienJeSpieltag' => ['Matches', 'int'],
            'aktuellerSpieltag' => ['Actual', 'int'],
            'lieblingsmannschaft' => ['favTeam', 'int'],
            'vorgewaehlteMannschaft' => ['selTeam', 'int'],
            'punkteFuerSieg' => ['PointsForWin', 'int'],
            'punkteFuerUnentschieden' => ['PointsForDraw', 'int'],
            'punkteFuerNiederlage' => ['PointsForLost', 'int'],
            'punkteFuerSiegNachVerlaengerung' => ['XtraS', 'int'],
            'punkteFuerUnentschiedenNachVerlaengerung' => ['XtraU', 'int'],
            'punkteFuerNiederlageNachVerlaengerung' => ['XtraV', 'int'],
            'punkteFuerSiegImElfmeterschiessen' => ['SpezS', 'int'],
            'punkteFuerUnentschiedenImElfmeterschiessen' => ['SpezU', 'int'],
            'punkteFuerNiederlageImElfmeterschiessen' => ['SpezV', 'int'],
            'mitVerlaengerung' => ['Spez', 'bool'],
            'mitDirektemVergleich' => ['Direct', 'bool'],
            'mitHandicap' => ['HandS', 'bool'],
            'istKegelliga' => ['Kegel', 'bool'],
            'ohneUnentschieden' => ['HideDraw', 'bool'],
            'laufendeTabelle' => ['OnRun', 'int'],
            'mitMeister' => ['Champ', 'bool'],
            'plaetzeChampionsLeague' => ['CL', 'int'],
            'plaetzeClQualifikation' => ['CK', 'int'],
            'plaetzeUefaCup' => ['UC', 'int'],
            'plaetzeRelegation' => ['AR', 'int'],
            'plaetzeAbstieg' => ['AB', 'int'],
            'bezeichnungPunkte' => ['namePkt', 'string'],
            'bezeichnungTore' => ['nameTor', 'string'],
            'mitHinRueckrundentabelle' => ['tableHinRueck', 'bool'],
            'mitHeimAuswaertstabelle' => ['tableHeimAusw', 'bool'],
            'fieberkurveErste' => ['kurve1', 'int'],
            'fieberkurveZweite' => ['kurve2', 'int'],
            'mitSpielUmPlatz3' => ['KlFin', 'bool'],
            'mitPlaydown' => ['playdown', 'bool'],
            'playoffModus' => ['playoffmode', 'int'],
            'torfaktor' => ['goalfaktor', 'int'],
            'punktfaktor' => ['pointsfaktor', 'int'],
            'sortiertNachAnstoss' => ['enableGameSort', 'bool'],
            'mitKalender' => ['DatC', 'bool'],
            'mitSpieltagsdatum' => ['DatS', 'bool'],
            'mitAnstosszeit' => ['DatM', 'bool'],
            'mitMannschaftslinks' => ['urlT', 'bool'],
            'mitSpielberichten' => ['urlB', 'bool'],
            'mitSpielplan' => ['Plan', 'bool'],
            'mitErgebnissen' => ['Ergebnis', 'bool'],
            'mitToren' => ['mittore', 'bool'],
            'mitNewsticker' => ['ticker', 'bool'],
            'mitFieberkurve' => ['Graph', 'bool'],
            'mitKreuztabelle' => ['Kreuz', 'bool'],
            'mitTabelle' => ['Tabelle', 'bool'],
            'mitLigastatistik' => ['Ligastats', 'bool'],
        ];
    }

    public function testJedeEinstellungHatEineMethodeMitFestemTyp(): void
    {
        $ohneEigene = ['Type' => 'istPokal()', 'MinusPoints' => 'mitMinuspunkten()', 'DatF' => 'datumsformat()'];
        $schluessel = array_merge(array_column(self::methoden(), 0), array_keys($ohneEigene));
        sort($schluessel);
        $alle = Einstellungen::schluessel();
        sort($alle);
        self::assertSame($alle, $schluessel);

        foreach (self::methoden() as $methode => [, $typ]) {
            $rueckgabe = (new \ReflectionMethod(Einstellungen::class, $methode))->getReturnType();
            self::assertInstanceOf(\ReflectionNamedType::class, $rueckgabe);
            self::assertSame($typ, $rueckgabe->getName(), $methode);
        }
    }

    /**
     * Die Methoden liefern denselben Wert wie wert(), nur mit festem Typ.
     *
     * @dataProvider ligadateien
     */
    public function testMethodenStimmenMitWertUeberein(string $pfad): void
    {
        $e = Liga::lies($pfad)->einstellungen();

        foreach (self::methoden() as $methode => [$schluessel, $typ]) {
            $wert = $e->wert($schluessel);
            $erwartet = $typ === 'bool' ? $wert == 1 : ($typ === 'int' ? (int) $wert : (string) $wert);
            self::assertSame($erwartet, $e->$methode(), $methode);
        }
        self::assertSame($e->wert('MinusPoints') == 2, $e->mitMinuspunkten());
        self::assertSame($e->wert('DatF') ?? 'd.m.Y', $e->datumsformat('d.m.Y'));
    }

    public function testTypenAnEinemBeispiel(): void
    {
        $liga = self::liga(['Name=Kreisliga', 'Teams=4', 'Spez=1', 'urlB=0', 'goalfaktor=10', 'MinusPoints=2', 'DatF=d.m.', 'PointsForWin=viel', 'Kreuz=ja']);
        $e = $liga->einstellungen();

        self::assertSame('Kreisliga', $e->name());
        self::assertSame([4, 2, 6], [$e->mannschaften(), $e->partienJeSpieltag(), $e->spieltage()]);
        self::assertTrue($e->mitVerlaengerung());
        self::assertFalse($e->mitSpielberichten());
        self::assertTrue($e->mitSpielplan(), 'Vorgabewert');
        self::assertSame(10, $e->torfaktor());
        self::assertTrue($e->mitMinuspunkten());
        self::assertSame('d.m.', $e->datumsformat('d.m.Y'));
        self::assertSame('d.m.Y', (new Liga())->einstellungen()->datumsformat('d.m.Y'), 'ohne Angabe das Format der Installation');
        // unlesbare Angaben: eine Zahl ist 0, ein Schalter ist nur bei 1 an
        self::assertSame(0, $e->punkteFuerSieg());
        self::assertFalse($e->mitKreuztabelle());
        // im Pokal gibt es die Einstellungen der Liga nicht
        $pokal = self::liga(['Type=1', 'PointsForWin=3', 'KlFin=1'])->einstellungen();
        self::assertSame([0, true, true], [$pokal->punkteFuerSieg(), $pokal->mitSpielUmPlatz3(), $pokal->mitVerlaengerung()]);
        self::assertFalse($e->mitSpielUmPlatz3());
    }

    /** @return array<string, array{string}> */
    public static function ligadateien(): array
    {
        $wurzel = dirname(__DIR__, 3);
        $dateien = array_merge(
            glob($wurzel . '/lmo/ligen/{*,*/*}.l98', GLOB_BRACE) ?: [],
            glob($wurzel . '/docker/demo/ligen/*.l98') ?: [],
            glob(__DIR__ . '/fixtures/*.l98') ?: []
        );
        $faelle = [];
        foreach ($dateien as $pfad) {
            $faelle[basename(dirname($pfad)) . '/' . basename($pfad)] = [$pfad];
        }

        return $faelle;
    }

    /**
     * Solange die alten Seiten ueber LigaDaten arbeiten, muessen beide dasselbe liefern: jede
     * Einstellung, die LigaDaten nach dem Laden in einem Feld haelt, hat hier denselben Wert.
     *
     * @dataProvider ligadateien
     */
    public function testStimmtMitLigaDatenUeberein(string $pfad): void
    {
        $eintraege = LigaDatei::lies($pfad);
        $bruecke = new LigaDaten();
        $bruecke->setzeStartwerte();
        $bruecke->lies($eintraege, 'FORMAT DER INSTALLATION', 'n.V.', 'i.E.');
        $einstellungen = Liga::ausEintraegen($eintraege)->einstellungen();

        /** @var array<string, array{string, string, mixed}> $tabelle */
        $tabelle = (new \ReflectionClassConstant(LigaDaten::class, 'OPTIONEN'))->getValue();
        self::assertSame(array_keys($tabelle), Einstellungen::schluessel());
        foreach ($tabelle as $schluessel => [$feld]) {
            $erwartet = $bruecke->$feld;
            if ($schluessel === 'DatF' && $erwartet === 'FORMAT DER INSTALLATION') {
                $erwartet = null;
            }
            self::assertSame($erwartet, $einstellungen->wert($schluessel), $schluessel);
        }
    }
}
