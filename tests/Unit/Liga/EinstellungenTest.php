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
