<?php

namespace Lmo\Tests\Unit\Liga\Rohdaten;

use Lmo\Liga\Normalform;
use Lmo\Liga\Rohdaten\Liga;
use Lmo\Liga\Rohdaten\Mannschaft;
use Lmo\Liga\Rohdaten\Partie;
use Lmo\Liga\Rohdaten\Spieltag;
use Lmo\Liga\Spiel;
use PHPUnit\Framework\TestCase;

/**
 * Die benannten Methoden zum Aendern der Rohdaten: Sie kennen die Schluessel und Sonderwerte der
 * Ligadatei (-1 nicht gespielt, -2 Wertung am gruenen Tisch, "_" kein Zusatz), die Seiten nicht.
 */
class WerteAendernTest extends TestCase
{
    public function testErgebnisEinesSpiels(): void
    {
        $partie = new Partie();

        $partie->setzeMannschaften(3, 7);
        $partie->setzeErgebnis(2, 1, 0);

        self::assertSame(['3', '7'], [$partie->heim, $partie->gast]);
        self::assertSame(['GA' => '2', 'GB' => '1'], $partie->spiele[1]);
    }

    public function testNichtGespielt(): void
    {
        $partie = new Partie();

        $partie->setzeErgebnis(null, null, 0);

        self::assertSame(['GA' => '-1', 'GB' => '-1'], $partie->spiele[1]);
    }

    /** @return array<string, array{int, array<string, string>}> */
    public static function wertungen(): array
    {
        return [
            'fuer Heim' => [1, ['GA' => '-2', 'GB' => '1']],
            'fuer Gast' => [2, ['GA' => '4', 'GB' => '-2']],
            'gegen beide' => [3, ['GA' => '4', 'GB' => '1', 'ET' => '3']],
            'keine' => [0, ['GA' => '4', 'GB' => '1']],
        ];
    }

    /**
     * @dataProvider wertungen
     * @param array<string, string> $erwartet
     */
    public function testWertungAmGruenenTisch(int $wertung, array $erwartet): void
    {
        $partie = new Partie();
        $partie->spiele[1] = ['GA' => '0', 'GB' => '0', 'ET' => '3'];

        $partie->setzeErgebnis(4, 1, $wertung);

        self::assertSame($erwartet, $partie->spiele[1], 'eine fruehere Wertung gegen beide bleibt nur bei 3 stehen');
    }

    public function testWertungKommtBeimLesenWiederHeraus(): void
    {
        $liga = new Liga();
        $liga->setzeEinstellung('Teams', 4);
        $partie = $liga->spieltag(1)->partie(1);
        $partie->setzeMannschaften(1, 2);
        $partie->setzeErgebnis(4, 1, 2);

        $spiel = Spiel::ausRohdaten($liga, 1, 1);

        self::assertSame([4, 0, 2], [$spiel->toreHeim, $spiel->toreGast, $spiel->wertung], 'fuer den Gast gewertet: dessen Tore stehen als -2 in der Datei');
    }

    public function testImPokalBleibtDieWertungUnberuehrt(): void
    {
        $partie = new Partie();
        $partie->spiele[2] = ['ET' => 'x'];

        $partie->setzeErgebnis(1, null, null, 2);

        self::assertSame(['ET' => 'x', 'GA' => '1', 'GB' => '-1'], $partie->spiele[2]);
        self::assertArrayNotHasKey(1, $partie->spiele, 'nur das genannte Spiel der Paarung');
    }

    public function testZusatz(): void
    {
        $partie = new Partie();

        $partie->setzeZusatz(2);
        self::assertSame('2', $partie->spiele[1]['SP']);
        $partie->setzeZusatz(1);
        self::assertSame('1', $partie->spiele[1]['SP']);
        $partie->setzeZusatz(0);
        self::assertSame('_', $partie->spiele[1]['SP'], 'ausdruecklich kein Zusatz');
        $partie->setzeZusatz(null);
        self::assertArrayNotHasKey('SP', $partie->spiele[1], 'keine Angabe');
    }

    public function testKeinZusatzStehtAlsNullInDerDatei(): void
    {
        $liga = new Liga();
        $liga->optionen = ['Teams' => '2', 'Rounds' => '1', 'Matches' => '1', 'Spez' => '1'];
        $liga->spieltag(1)->partie(1)->setzeZusatz(0);

        $normal = Normalform::von($liga, 'LMO', 1, 'd.m.Y');

        self::assertSame('0', $normal->spieltage[1]->partien[1]->spiele[1]['SP']);
    }

    public function testAnstossNotizBerichtUndTipp(): void
    {
        $partie = new Partie();

        $partie->setzeAnstoss(1742135400);
        $partie->setzeNotiz('Notiz');
        $partie->setzeBericht('http://example.org');
        $partie->setzeOhneTippwertung(true);
        $partie->setzeAnstoss(null, 2);
        $partie->setzeOhneTippwertung(false, 2);

        self::assertSame(['AT' => '1742135400', 'NT' => 'Notiz', 'BE' => 'http://example.org', 'TI' => '1'], $partie->spiele[1]);
        self::assertSame(['AT' => '', 'TI' => '0'], $partie->spiele[2]);
    }

    public function testSpieltag(): void
    {
        $spieltag = new Spieltag();

        $spieltag->setzeErstenTag('15.03.2025');
        $spieltag->setzeLetztenTag('');
        $spieltag->setzeTabellenkorrektur('020103');
        $spieltag->setzeSpieleJePaarung(2);

        self::assertSame(['D1' => '15.03.2025', 'D2' => '', 'HS' => '020103', 'MO' => '2'], $spieltag->werte);
        self::assertSame('15.03.2025', $spieltag->ersterTagText());
        $spieltag->setzeTabellenkorrektur('');
        self::assertSame('0', $spieltag->werte['HS'], 'leer heisst keine Korrektur');
    }

    public function testPartieWirdAngelegt(): void
    {
        $spieltag = new Spieltag();

        $partie = $spieltag->partie(3);

        self::assertSame($partie, $spieltag->partie(3));
        self::assertSame([3], array_keys($spieltag->partien));
    }

    public function testMannschaft(): void
    {
        $mannschaft = new Mannschaft();
        $mannschaft->werte = ['Farbe' => 'blau'];

        $mannschaft->setzeUrl('http://example.org');
        $mannschaft->setzeNotiz('Aufsteiger');
        $mannschaft->setzeStrafpunkte(3);
        $mannschaft->setzeStrafminuspunkte(-1);
        $mannschaft->setzeTorkorrektur(-2, 4);
        $mannschaft->setzeStrafeAbSpieltag(5);

        self::assertSame(
            ['Farbe' => 'blau', 'URL' => 'http://example.org', 'NOT' => 'Aufsteiger', 'SP' => '3', 'SM' => '-1', 'TOR1' => '-2', 'TOR2' => '4', 'STDA' => '5'],
            $mannschaft->werte
        );
    }

    public function testEinstellung(): void
    {
        $liga = new Liga();

        $liga->setzeEinstellung('Rounds', 34);
        $liga->setzeEinstellung('Name', 'Kreisliga');

        self::assertSame(['Rounds' => '34', 'Name' => 'Kreisliga'], $liga->optionen);
        self::assertSame(34, $liga->einstellungen()->spieltage());
    }

    public function testUnbekannteEinstellungIstEinFehler(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        (new Liga())->setzeEinstellung('Runds', 34);
    }

    public function testNews(): void
    {
        $liga = new Liga();
        $liga->news = ['NC' => '3', 'N0' => 'alt', 'N1' => 'alt', 'N2' => 'alt'];

        $liga->setzeNews(['Erste', 'Zweite']);
        self::assertSame(['NC' => '2', 'N0' => 'Erste', 'N1' => 'Zweite'], $liga->news);

        $liga->setzeNews([]);
        self::assertSame(['NC' => '0'], $liga->news);
    }
}
