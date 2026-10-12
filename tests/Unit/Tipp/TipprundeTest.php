<?php

namespace Lmo\Tests\Unit\Tipp;

use Lmo\Liga\LigaDatei;
use Lmo\Liga\Paarung;
use Lmo\Liga\Rohdaten\Liga;
use Lmo\Tipp\Tipprunde;
use PHPUnit\Framework\TestCase;

/**
 * Tipprunde stellt einen Spieltag so bereit, wie Tippabgabe und Einsicht ihn brauchen: die
 * Paarungen unter denselben Nummern wie die Tipps.
 */
class TipprundeTest extends TestCase
{
    /** @param list<string> $zeilen */
    private static function liga(array $zeilen): Liga
    {
        return Liga::ausEintraegen(LigaDatei::zerlege($zeilen));
    }

    public function testSpieltagEinerLiga(): void
    {
        $liga = self::liga(['[Options]', 'Teams=4', '[Teams]', '1=Alpha', '2=Beta', '[Round2]', 'D1=1.9.2024', 'D2=31.02.2025',
            'TA2=1', 'TB2=2', 'GA2=3', 'GB2=1', 'AT2=1725201000']);

        $runde = Tipprunde::fuer($liga, 2);

        self::assertSame([2, false, 6, 1, 2], [$runde->nr, $runde->pokal, $runde->runden, $runde->spieleJePaarung, $runde->plaetze]);
        self::assertSame(['01.09.2024', ''], [$runde->ersterTag, $runde->letzterTag], 'TT.MM.JJJJ; ein Tag, den es nicht gibt, ist leer');
        self::assertCount(2, $runde->paarungen, 'auch die Paarung, die in der Datei fehlt');
        self::assertContainsOnlyInstancesOf(Paarung::class, $runde->paarungen);
        // Index ab 0: die Tippdatei fuehrt Paarung 2 als GA2, die Seiten als $i = 1
        self::assertSame([0, 0], [$runde->paarungen[0]->heim, $runde->paarungen[0]->gast]);
        self::assertSame(['Alpha', 'Beta'], [$runde->paarungen[1]->heimMannschaft()->anzeigename(), $runde->paarungen[1]->gastMannschaft()->anzeigename()]);
        self::assertSame([3, 1, 1725201000], [$runde->paarungen[1]->spiele[0]->toreHeim, $runde->paarungen[1]->spiele[0]->toreGast, $runde->paarungen[1]->spiele[0]->anstoss]);
    }

    public function testRundeImPokal(): void
    {
        $liga = self::liga(['[Options]', 'Type=1', 'Teams=8', 'KlFin=1', '[Round1]', 'MO=2', 'TA3=5', 'TB3=6', 'GA32=2', '[Round3]', 'MO=1']);

        $erste = Tipprunde::fuer($liga, 1);
        $finale = Tipprunde::fuer($liga, 3);

        self::assertTrue($erste->pokal);
        self::assertSame([3, 2], [$erste->runden, $erste->spieleJePaarung]);
        self::assertEquals(4, $erste->plaetze, 'acht Mannschaften: vier Paarungen');
        self::assertCount(4, $erste->paarungen);
        self::assertCount(2, $erste->paarungen[2]->spiele, 'Hin- und Rueckspiel');
        self::assertSame([5, 6, 2], [$erste->paarungen[2]->heim, $erste->paarungen[2]->gast, $erste->paarungen[2]->spiele[1]->toreHeim]);
        self::assertEquals(2, $finale->plaetze, 'Finale und Spiel um Platz 3');
        self::assertCount(2, $finale->paarungen);
    }

    public function testKeineZweierpotenzZaehltWieBisher(): void
    {
        $runde = Tipprunde::fuer(self::liga(['[Options]', 'Type=1', 'Teams=6']), 2);

        self::assertSame(1.5, $runde->plaetze);
        self::assertCount(2, $runde->paarungen, 'bis zur naechsten ganzen Zahl');
    }

    public function testEineRundeDieEsNichtGibt(): void
    {
        $runde = Tipprunde::fuer(new Liga(), 99);

        self::assertSame([99, false, '', ''], [$runde->nr, $runde->pokal, $runde->ersterTag, $runde->letzterTag]);
        self::assertCount(9, $runde->paarungen, 'ohne Angabe 18 Mannschaften, neun Partien');
        self::assertSame(0, $runde->paarungen[8]->heim);
    }
}
