<?php

namespace Lmo\Tests\Unit\Classlib;

final class PartieTest extends ClasslibTestCase
{
    private static function partie($hTore, $gTore, $zeit = ''): \partie
    {
        $heim = new \team('Heim', 'HEI', 1);
        $gast = new \team('Gast', 'GAS', 2);
        return new \partie(1, $zeit, 'Notiz', $heim, $gast, $hTore, $gTore);
    }

    public function testConstructor(): void
    {
        $partie = self::partie(2, 1, 1724437800);

        self::assertSame(1, $partie->spNr);
        self::assertSame(1724437800, $partie->zeit);
        self::assertSame('Notiz', $partie->notiz);
        self::assertSame('Heim', $partie->heim->name);
        self::assertSame('Gast', $partie->gast->name);
        self::assertSame(0, $partie->getSpielEnde());
        self::assertNull($partie->getreportUrl(null));
    }

    /** @dataProvider toreStrings */
    public function testToreStrings($hTore, $gTore, $heim, $gast): void
    {
        $partie = self::partie($hTore, $gTore);

        self::assertEquals($heim, $partie->hToreString());
        self::assertEquals($gast, $partie->gToreString());
    }

    public static function toreStrings(): array
    {
        return [
            'Ergebnis' => [3, 1, 3, 1],
            'nicht gespielt' => [-1, -1, '_', '_'],
            'Heim am gruenen Tisch' => [-2, 0, '0*', '0'],
            'Gast am gruenen Tisch' => [0, -2, '0', '0*'],
            'Werte aus der Ligadatei sind Strings' => ['2', '0', 2, 0],
        ];
    }

    public function testToreStringsWithPlaceholderAndFactor(): void
    {
        self::assertSame('-', self::partie(-1, -1)->hToreString('-'));
        self::assertSame('-', self::partie(-1, -1)->gToreString('-'));

        $partie = self::partie(30, 15);
        self::assertEquals(3, $partie->hToreString('_', 10));
        self::assertEquals(1.5, $partie->gToreString('_', 10));
    }

    /** @dataProvider wertungen */
    public function testValuateGame($hTore, $gTore, int $expected): void
    {
        self::assertSame($expected, self::partie($hTore, $gTore)->valuateGame());
    }

    public static function wertungen(): array
    {
        return [
            'Heimsieg' => [2, 1, 1],
            'Auswaertssieg' => [0, 3, 2],
            'Unentschieden' => [1, 1, 0],
            'torloses Unentschieden' => [0, 0, 0],
            'nicht gespielt' => [-1, -1, -1],
            'nur ein Ergebnis' => [2, -1, -1],
            'Heim am gruenen Tisch' => [-2, 0, 1],
            'Gast am gruenen Tisch' => [0, -2, 2],
        ];
    }

    public function testDatumUndZeitString(): void
    {
        $partie = self::partie(0, 0, mktime(15, 30, 0, 8, 23, 2024));

        self::assertSame('23.08.2024', $partie->datumString());
        self::assertSame('2024-08-23', $partie->datumString('', 'Y-m-d'));
        self::assertSame('15:30', $partie->zeitString());
        self::assertSame('15.30 Uhr', $partie->zeitString('', 'H.i \U\h\r'));
    }

    public function testDatumUndZeitStringAusLigadatei(): void
    {
        $partie = self::partie(0, 0, (string)mktime(18, 0, 0, 1, 2, 2025));

        self::assertSame('02.01.2025', $partie->datumString());
        self::assertSame('18:00', $partie->zeitString());
    }

    public function testDatumUndZeitStringOhneAnstoss(): void
    {
        $partie = self::partie(0, 0, '');

        self::assertSame('', $partie->datumString());
        self::assertSame('offen', $partie->datumString('offen'));
        self::assertSame('--:--', $partie->zeitString('--:--'));

        // so schreibt der LMO "kein Anstoss"; frueher kam dafuer der 01.01.1970
        $ohne = self::partie(0, 0, '0');
        self::assertSame(['', '', 'offen'], [$ohne->datumString(), $ohne->zeitString(), $ohne->datumString('offen')]);
    }

    public function testSpielEnde(): void
    {
        $text = ['n.V.', 'i.E.'];
        $partie = self::partie(2, 1);

        self::assertSame('', $partie->spielEndeString($text));
        self::assertSame('regulaer', $partie->spielEndeString($text, 'regulaer'));

        $partie->setSpielEnde(2);
        self::assertSame(2, $partie->getSpielEnde());
        self::assertSame('n.V.', $partie->spielEndeString($text));

        $partie->setSpielEnde(1);
        self::assertSame('i.E.', $partie->spielEndeString($text));

        $partie->setSpielEnde(7);
        self::assertSame(7, $partie->spielEndeString($text));
    }

    public function testSetSpielEndeIgnoresNonNumbers(): void
    {
        $partie = self::partie(2, 1);
        $partie->setSpielEnde(2);
        $partie->setSpielEnde('abc');

        self::assertSame(2, $partie->getSpielEnde());
    }

    public function testParameter(): void
    {
        $partie = self::partie(2, 1);
        $partie->setParameter('1:0', 'HZ');
        $partie->setParameter(['TI' => 'Tor 90.', 'HZ' => '2:0']);

        self::assertSame('2:0', $partie->getParameter('HZ'));
        self::assertSame('Tor 90.', $partie->getParameter('TI'));
        self::assertNull($partie->getParameter('fehlt'));
        self::assertSame(['HZ' => '2:0', 'TI' => 'Tor 90.'], $partie->getParameter());
    }

    public function testReportUrl(): void
    {
        $partie = self::partie(2, 1);

        $partie->setreportUrl('www.bericht.example/1');
        self::assertSame('www.bericht.example/1', $partie->getreportUrl(null));
        self::assertSame('<a href="http://www.bericht.example/1" target="_blank" >', $partie->getreportUrl());

        $partie->setreportUrl('https://bericht.example/2');
        self::assertSame('<a href="https://bericht.example/2" target="_self" class="x">', $partie->getreportUrl('_self', 'class="x"'));
    }

    public function testShowDetails(): void
    {
        $partie = self::partie(2, 1, mktime(15, 30, 0, 8, 23, 2024));

        $this->expectOutputString("Heim - Gast Anpfiff: 15:30Uhr Ergebnis:2 - 1\n<br>Heim - Gast Anpfiff: 15:30Uhr Ergebnis:2 - 1");
        $partie->showDetails();
        $partie->showDetailsHTML();
    }
}
