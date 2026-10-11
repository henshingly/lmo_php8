<?php

namespace Lmo\Tests\Unit\Liga;

use Lmo\Liga\LigaDatei;
use PHPUnit\Framework\TestCase;

/**
 * LigaDatei liest das Format .l98: Abschnitte, Schluessel, Werte - ohne deren Bedeutung zu kennen.
 */
class LigaDateiTest extends TestCase
{
    public function testAbschnitteSchluesselUndWerte(): void
    {
        $eintraege = LigaDatei::zerlege(["[Options]\n", "Name=Kreisliga\n", "Teams=4\n", "\n", "[Round1]\n", "TA1=3\n"]);

        self::assertSame([
            ['Options', 'Name', 'Kreisliga'],
            ['Options', 'Teams', '4'],
            ['Round1', 'TA1', '3'],
        ], $eintraege);
    }

    public function testEckigeKlammernUndGleichheitszeichenGehoerenZumWert(): void
    {
        $eintraege = LigaDatei::zerlege([
            '[Options]',
            'Name=Liga [Nord]',
            '[Teams]',
            '1=FC [A] Stadt',
            '[Round1]',
            'NT1=Abbruch [Nebel], Wertung = 2:1',
            '[kein Abschnitt]=doch ein Schluessel',
        ]);

        self::assertSame([
            ['Options', 'Name', 'Liga [Nord]'],
            ['Teams', '1', 'FC [A] Stadt'],
            ['Round1', 'NT1', 'Abbruch [Nebel], Wertung = 2:1'],
            ['Round1', '[kein Abschnitt]', 'doch ein Schluessel'],
        ], $eintraege);
    }

    public function testLeerraumZeilenendenUndKommentare(): void
    {
        $eintraege = LigaDatei::zerlege([
            "  [ Options ]  \r\n",
            "  Name  =  Mit Leerraum  \r\n",
            ";Kommentar=wird uebergangen\r\n",
            "Zeile ohne Gleichheitszeichen\r\n",
            "leer=\r\n",
            "=ohne Schluessel\r\n",
        ]);

        self::assertSame([
            ['Options', 'Name', 'Mit Leerraum'],
            ['Options', 'leer', ''],
            ['Options', '', 'ohne Schluessel'],
        ], $eintraege);
    }

    public function testZeilenVorDemErstenAbschnittHabenKeinenAbschnitt(): void
    {
        self::assertSame([['', 'vorab', '1'], ['A', 'x', '2']], LigaDatei::zerlege(['vorab=1', '[A]', 'x=2']));
    }

    public function testLiesEineDatei(): void
    {
        $eintraege = LigaDatei::lies(__DIR__ . '/fixtures/pokal.l98');

        self::assertSame([['Options', 'Name', 'Kleiner Pokal'], ['Options', 'Type', '1'], ['Options', 'Teams', '8']], $eintraege);
        self::assertSame([], LigaDatei::lies(__DIR__ . '/fixtures/gibt-es-nicht.l98'));
        self::assertSame([], LigaDatei::lies(__DIR__ . '/fixtures'));
    }

    public function testAbschnitteFassenZusammen(): void
    {
        $abschnitte = LigaDatei::abschnitte(LigaDatei::zerlege(['[A]', 'x=1', 'y=2', '[B]', 'z=3', '[A]', 'x=4']));

        self::assertSame([
            ['A', ['x', 'y'], ['1', '2']],
            ['B', ['z'], ['3']],
            ['A', ['x'], ['4']],
        ], $abschnitte);
        self::assertSame([], LigaDatei::abschnitte([]));
    }
}
