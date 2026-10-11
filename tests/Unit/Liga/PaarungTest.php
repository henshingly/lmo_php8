<?php

namespace Lmo\Tests\Unit\Liga;

use Lmo\Liga\LigaDatei;
use Lmo\Liga\Paarung;
use Lmo\Liga\Rohdaten\Liga;
use Lmo\Liga\Spiel;
use PHPUnit\Framework\TestCase;

/**
 * Paarung fasst die Spiele zweier Mannschaften in einer Runde zusammen und weiss, wer weiterkommt.
 */
class PaarungTest extends TestCase
{
    /** @param list<string> $runde Zeilen des Abschnitts [Round1] */
    private static function pokal(array $runde, int $mannschaften = 8): Liga
    {
        return Liga::ausEintraegen(LigaDatei::zerlege(array_merge(
            ['[Options]', 'Type=1', 'Teams=' . $mannschaften, '[Teams]', "1=O\\'Neill", '2=Blau', '3=Gelb', '[Team2]', 'URL=http://blau.example', '[Round1]'],
            $runde
        )));
    }

    /** @param list<string> $runde */
    private static function sieger(array $runde): int
    {
        return Paarung::ausRohdaten(self::pokal($runde), 1, 1)->sieger();
    }

    public function testPaarungTraegtMannschaftenUndSpiele(): void
    {
        $liga = self::pokal(['MO=2', 'TA2=1', 'TB2=2', 'GA21=3', 'GB21=1', 'AT21=1742135400', 'NT22=Rueckspiel']);

        $paarung = Paarung::ausRohdaten($liga, 1, 2);

        self::assertSame([1, 2, 1, 2], [$paarung->runde, $paarung->nr, $paarung->heim, $paarung->gast]);
        self::assertSame(["O'Neill", 'Blau'], [$paarung->heimMannschaft()->anzeigename(), $paarung->gastMannschaft()->anzeigename()]);
        self::assertSame('http://blau.example', $paarung->gastMannschaft()->werte['URL']);
        self::assertCount(2, $paarung->spiele, 'Hin- und Rueckspiel nach dem Modus der Runde');
        self::assertContainsOnlyInstancesOf(Spiel::class, $paarung->spiele);
        self::assertSame([3, 1, 1742135400], [$paarung->spiele[0]->toreHeim, $paarung->spiele[0]->toreGast, $paarung->spiele[0]->anstoss]);
        self::assertSame([null, 'Rueckspiel', 2], [$paarung->spiele[1]->toreHeim, $paarung->spiele[1]->notiz, $paarung->spiele[1]->nr]);
    }

    public function testEinePaarungDieEsNichtGibt(): void
    {
        $paarung = Paarung::ausRohdaten(self::pokal(['MO=2']), 1, 4);

        self::assertSame([0, 0], [$paarung->heim, $paarung->gast]);
        self::assertSame('', $paarung->heimMannschaft()->anzeigename(), 'eine leere Mannschaft, damit man weiterfragen kann');
        self::assertCount(2, $paarung->spiele, 'als nicht gespielte Spiele');
        self::assertSame(0, $paarung->sieger());
        self::assertSame(0, Paarung::ausRohdaten(new Liga(), 3, 3)->sieger());
    }

    public function testSpieleJePaarung(): void
    {
        self::assertSame(1, Paarung::spieleJePaarung(self::pokal([]), 1), 'ohne Modus ein Spiel');
        self::assertSame(3, Paarung::spieleJePaarung(self::pokal(['MO=3']), 1));
        self::assertSame(1, Paarung::spieleJePaarung(self::pokal(['MO=3']), 2), 'eine Runde ohne Abschnitt');
        self::assertSame(1, Paarung::spieleJePaarung(self::pokal(['MO=x']), 1));
        $liga = Liga::ausEintraegen(LigaDatei::zerlege(['[Round1]', 'MO=2', 'TA1=1']));
        self::assertSame(1, Paarung::spieleJePaarung($liga, 1), 'in der Liga immer eines');
        self::assertCount(1, Paarung::ausRohdaten($liga, 1, 1)->spiele);
    }

    public function testSiegerBeiEinemSpiel(): void
    {
        self::assertSame(1, self::sieger(['TA1=1', 'TB1=2', 'GA11=2', 'GB11=1']));
        self::assertSame(2, self::sieger(['TA1=1', 'TB1=2', 'GA11=0', 'GB11=1']));
        self::assertSame(0, self::sieger(['TA1=1', 'TB1=2', 'GA11=1', 'GB11=1']), 'unentschieden');
        self::assertSame(0, self::sieger(['TA1=1', 'TB1=2', 'GA11=-1', 'GB11=-1']), 'nicht gespielt');
        self::assertSame(0, self::sieger(['TA1=1', 'TB1=2']));
    }

    public function testSiegerBeiHinUndRueckspiel(): void
    {
        $paarung = ['MO=2', 'TA1=1', 'TB1=2'];

        self::assertSame(0, self::sieger(array_merge($paarung, ['GA11=3', 'GB11=0', 'GA12=-1', 'GB12=-1'])), 'erst nach dem Rueckspiel');
        self::assertSame(1, self::sieger(array_merge($paarung, ['GA11=3', 'GB11=0', 'GA12=0', 'GB12=2'])), 'mehr Tore in beiden Spielen zusammen');
        self::assertSame(2, self::sieger(array_merge($paarung, ['GA11=1', 'GB11=2', 'GA12=1', 'GB12=1'])));
        self::assertSame(2, self::sieger(array_merge($paarung, ['GA11=2', 'GB11=1', 'GA12=1', 'GB12=2'])), 'bei Gleichstand entscheidet das Rueckspiel');
        self::assertSame(1, self::sieger(array_merge($paarung, ['GA11=1', 'GB11=2', 'GA12=2', 'GB12=1'])));
        self::assertSame(0, self::sieger(array_merge($paarung, ['GA11=1', 'GB11=1', 'GA12=2', 'GB12=2'])), 'auch das Rueckspiel unentschieden');
        self::assertSame(0, self::sieger(array_merge($paarung, ['GA12=2', 'GB12=1'])), 'ohne Hinspiel keine Entscheidung');
    }

    public function testSiegerBeiMehrerenSpielen(): void
    {
        $paarung = ['MO=3', 'TA1=1', 'TB1=2'];

        self::assertSame(0, self::sieger(array_merge($paarung, ['GA11=1', 'GB11=0'])), 'ein Sieg von dreien reicht nicht');
        self::assertSame(1, self::sieger(array_merge($paarung, ['GA11=1', 'GB11=0', 'GA12=2', 'GB12=1'])), 'mehr als die Haelfte der Spiele');
        self::assertSame(2, self::sieger(array_merge($paarung, ['GA11=1', 'GB11=0', 'GA12=0', 'GB12=1', 'GA13=0', 'GB13=3'])));
        self::assertSame(0, self::sieger(array_merge($paarung, ['GA11=1', 'GB11=0', 'GA12=0', 'GB12=1', 'GA13=1', 'GB13=1'])));
    }

    public function testPaarungenEinerRundeZumDurchlaufen(): void
    {
        // Paarung 2 steht vor Paarung 1, Paarung 3 und 4 fehlen
        $liga = self::pokal(['MO=2', 'TA2=3', 'TB2=1', 'TA1=1', 'TB1=2', 'GA11=1', 'GB11=0', 'GA12=1', 'GB12=0']);

        $paarungen = iterator_to_array($liga->paarungen(1), false);

        self::assertContainsOnlyInstancesOf(Paarung::class, $paarungen);
        self::assertSame([[1, 1, 2], [2, 3, 1], [3, 0, 0], [4, 0, 0]], array_map(static fn (Paarung $p): array => [$p->nr, $p->heim, $p->gast], $paarungen));
        self::assertSame([1, 0], [$paarungen[0]->sieger(), $paarungen[1]->sieger()]);
        self::assertCount(2, $paarungen[3]->spiele);
        self::assertCount(2, iterator_to_array($liga->paarungen(2), false), 'Halbfinale');
        self::assertCount(0, iterator_to_array($liga->paarungen(9), false), 'eine Runde, die es nicht gibt');
        self::assertSame([1], array_keys($liga->spieltage), 'durchlaufen legt nichts an');
    }
}
