<?php

namespace Lmo\Tests\Unit\Tipp;

use PHPUnit\Framework\TestCase;

/**
 * Das Tippspiel sammelt fuer die Tippuebersicht und die Erinnerungsmail die anstehenden Spiele
 * mehrerer Ligen. Die Ligadateien liest es dabei ueber Lmo\Liga\LigaDatei.
 */
class TippLigaLaderTest extends TestCase
{
    /**
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function testTippuebersichtSammeltSpieleUndTipps(): void
    {
        $testLader = 'lmo-tippopenfileviewer.php';
        $werte = require __DIR__ . '/fixtures/lade.php';
        $ligaDaten = $werte['ligaDaten'];

        self::assertSame(2, $werte['anzspiele']);
        self::assertSame(['tippliga', 'tippliga'], $werte['liga']);
        self::assertSame(['Tippliga', 'Tippliga'], $ligaDaten->titel);
        self::assertSame(['1', '1'], $werte['spieltag']);
        self::assertSame(['1', '2'], $werte['spiel']);
        self::assertSame(['01.03.2025', '01.03.2025'], $ligaDaten->datum1);
        // ein "|" im Namen oder in der Notiz gehoert zum Wert; frueher endete der Wert dort
        self::assertSame(['Alpha', 'Gamma'], $ligaDaten->teama);
        self::assertSame(['<strong>B | C</strong>', 'Alpha'], $ligaDaten->teamb, 'Lieblingsmannschaft ist hervorgehoben');
        self::assertSame('Abbruch | Nebel', $ligaDaten->mnote[0]);
        self::assertSame(['2', '_'], $ligaDaten->goala);
        self::assertSame(['1', '_'], $ligaDaten->goalb);
        self::assertSame(['1740826800', '1740834000'], $ligaDaten->mterm);
        self::assertSame(['3', '_'], $werte['tippa']);
        self::assertSame(['1', '_'], $werte['tippb']);
    }

    /**
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function testErinnerungsmailSammeltSpiele(): void
    {
        $testLader = 'lmo-tippemailviewer.php';
        $werte = require __DIR__ . '/fixtures/lade.php';
        $ligaDaten = $werte['ligaDaten'];

        self::assertSame(2, $werte['anzspiele']);
        self::assertSame(['tippliga', 'tippliga'], $werte['liga']);
        self::assertSame(['Tippliga', 'Tippliga'], $ligaDaten->titel);
        self::assertSame(['1', '1'], $werte['spieltag']);
        self::assertSame(['1', '2'], $werte['spiel']);
        self::assertSame(['Alpha', 'Gamma'], $ligaDaten->teama);
        self::assertSame(['B | C', 'Alpha'], $ligaDaten->teamb);
        self::assertSame([date('d.m.Y H:i', 1740826800), date('d.m.Y H:i', 1740834000)], $werte['zeit']);
    }
}
