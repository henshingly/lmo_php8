<?php

namespace Lmo\Tests\Unit\Tipp;

use Lmo\Tipp\AnstehendesSpiel;
use PHPUnit\Framework\TestCase;

/**
 * Das Tippspiel sammelt fuer die Tippuebersicht und die Erinnerungsmail die anstehenden Spiele
 * mehrerer Ligen. Die Ligadateien liest es komplett als Lmo\Liga\Rohdaten\Liga und greift je Spiel
 * auf dessen eigene Werte zu. Heraus kommt je Spiel ein Lmo\Tipp\AnstehendesSpiel.
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
        /** @var list<AnstehendesSpiel> $spiele */
        $spiele = $werte['lmo_spiele'];

        self::assertSame(2, $werte['anzspiele']);
        self::assertCount(2, $spiele);
        self::assertContainsOnlyInstancesOf(AnstehendesSpiel::class, $spiele);
        self::assertSame(['tippliga', 'tippliga'], $werte['liga']);
        self::assertSame(['1', '1'], $werte['spieltag']);
        self::assertSame(['1', '2'], $werte['spiel']);
        [$erstes, $zweites] = $spiele;
        // was die Anzeige von der Liga wissen muss, traegt jedes Spiel
        self::assertSame(['Tippliga', '0', 2], [$erstes->titel, $erstes->typ, $erstes->runden]);
        self::assertSame(['0', '1', '0', '1', '1'], [$erstes->ohneUnentschieden, $erstes->mitSpieltagsdatum, $erstes->mitAnstosszeit, $erstes->mitSpielbericht, $erstes->torfaktor]);
        self::assertNull($erstes->mitZusatz, 'die Liga nennt Spez nicht');
        self::assertSame(['01.03.2025', '02.03.2025', 1], [$zweites->ersterTag, $zweites->letzterTag, $zweites->spieleJePaarung]);
        // ein "|" im Namen oder in der Notiz gehoert zum Wert; frueher endete der Wert dort
        self::assertSame(['Alpha', '<strong>B | C</strong>'], [$erstes->heim, $erstes->gast], 'Lieblingsmannschaft ist hervorgehoben');
        self::assertSame(['Gamma', 'Alpha'], [$zweites->heim, $zweites->gast]);
        // jedes Spiel hat seine eigene Notiz; frueher galt die des vorigen Spiels weiter, wenn eine fehlte
        self::assertSame(['Abbruch | Nebel', ''], [$erstes->notiz, $zweites->notiz]);
        self::assertSame(['&nbsp;', '&nbsp;'], [$erstes->zusatz, $zweites->zusatz]);
        self::assertSame(['2', '1', 0], [$erstes->toreHeim, $erstes->toreGast, $erstes->wertung]);
        self::assertSame(['_', '_'], [$zweites->toreHeim, $zweites->toreGast]);
        self::assertSame(['1740826800', '1740834000'], [$erstes->anstoss, $zweites->anstoss]);
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
        /** @var list<AnstehendesSpiel> $spiele */
        $spiele = $werte['lmo_spiele'];

        self::assertSame(2, $werte['anzspiele']);
        self::assertCount(2, $spiele);
        self::assertSame(['tippliga', 'tippliga'], $werte['liga']);
        self::assertSame(['1', '1'], $werte['spieltag']);
        self::assertSame(['1', '2'], $werte['spiel']);
        self::assertSame(['Tippliga', '0', 2, 1], [$spiele[0]->titel, $spiele[0]->typ, $spiele[0]->runden, $spiele[0]->spieleJePaarung]);
        self::assertSame(['Alpha', 'B | C'], [$spiele[0]->heim, $spiele[0]->gast]);
        self::assertSame(['Gamma', 'Alpha'], [$spiele[1]->heim, $spiele[1]->gast]);
        self::assertSame([date('d.m.Y H:i', 1740826800), date('d.m.Y H:i', 1740834000)], $werte['zeit']);
    }
}
