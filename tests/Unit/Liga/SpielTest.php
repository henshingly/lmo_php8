<?php

namespace Lmo\Tests\Unit\Liga;

use Lmo\Liga\LigaDatei;
use Lmo\Liga\LigaDaten;
use Lmo\Liga\Rohdaten\Liga;
use Lmo\Liga\Spiel;
use PHPUnit\Framework\TestCase;

/**
 * Spiel leitet aus den Rohdaten ab, was die Seiten von einer Partie zeigen, mit festen Typen.
 */
class SpielTest extends TestCase
{
    /** @param list<string> $zeilen */
    private static function liga(array $zeilen): Liga
    {
        return Liga::ausEintraegen(LigaDatei::zerlege($zeilen));
    }

    public function testSpielEinerLiga(): void
    {
        $liga = self::liga(['[Options]', 'Spez=1', '[Round2]', 'TA3=4', 'TB3=7', 'GA3=2', 'GB3=1', 'SP3=2', 'NT3=Notiz | mit Strich',
            'BE3=http://bericht.example', 'TI3=1', 'AT3=1724437800']);

        $spiel = Spiel::ausRohdaten($liga, 2, 3);

        self::assertSame([2, 3, 1], [$spiel->spieltag, $spiel->partie, $spiel->nr]);
        self::assertTrue($spiel->hatMannschaften());
        self::assertTrue($spiel->istGespielt());
        self::assertSame([4, 7], [$spiel->heim, $spiel->gast]);
        self::assertSame([2, 1, 0], [$spiel->toreHeim, $spiel->toreGast, $spiel->wertung]);
        self::assertSame(['2', '1'], [$spiel->toreHeimText(), $spiel->toreGastText()]);
        self::assertSame(2, $spiel->zusatz);
        self::assertSame('n.V.', $spiel->zusatzText('n.V.', 'i.E.'));
        self::assertSame(['Notiz | mit Strich', 'http://bericht.example', true, 1724437800], [$spiel->notiz, $spiel->bericht, $spiel->ohneTippwertung, $spiel->anstoss]);
    }

    public function testEinePartieDieEsNichtGibtIstEinNichtAngesetztesSpiel(): void
    {
        $spiel = Spiel::ausRohdaten(new Liga(), 5, 9);

        self::assertFalse($spiel->hatMannschaften());
        self::assertFalse($spiel->istGespielt());
        self::assertSame([0, 0, null, null, 0], [$spiel->heim, $spiel->gast, $spiel->toreHeim, $spiel->toreGast, $spiel->wertung]);
        self::assertSame(['_', '_'], [$spiel->toreHeimText(), $spiel->toreGastText()]);
        self::assertNull($spiel->zusatz);
        self::assertSame('', $spiel->zusatzText('n.V.', 'i.E.'));
        self::assertSame(['', '', false, 0], [$spiel->notiz, $spiel->bericht, $spiel->ohneTippwertung, $spiel->anstoss]);
    }

    public function testToreUndWertungAmGruenenTisch(): void
    {
        $liga = self::liga(['[Round1]', 'TA1=1', 'GA1=-1', 'GB1=', 'TA2=1', 'GA2=-2', 'GB2=3', 'TA3=1', 'GA3=0', 'GB3=-2', 'TA4=1', 'GA4=1', 'GB4=1', 'ET4=3',
            'TA5=1', 'GA5=viele', 'GB5=2']);

        self::assertSame([null, null, 0], self::tore($liga, 1), 'nicht gespielt: -1 oder in der Datei leer');
        self::assertSame([0, 3, 1], self::tore($liga, 2), 'Wertung fuer Heim');
        self::assertSame([0, 0, 2], self::tore($liga, 3), 'Wertung fuer Gast');
        self::assertSame([1, 1, 3], self::tore($liga, 4), 'Wertung gegen beide');
        self::assertSame([null, 2, 0], self::tore($liga, 5), 'eine unlesbare Angabe zaehlt als nicht gespielt');
        self::assertFalse(Spiel::ausRohdaten($liga, 1, 5)->istGespielt());
    }

    /** @return array{int|null, int|null, int} */
    private static function tore(Liga $liga, int $partie): array
    {
        $spiel = Spiel::ausRohdaten($liga, 1, $partie);

        return [$spiel->toreHeim, $spiel->toreGast, $spiel->wertung];
    }

    public function testToreAlsAnzeigetextMitTorfaktor(): void
    {
        $spiel = Spiel::ausRohdaten(self::liga(['[Round1]', 'TA1=1', 'GA1=250', 'GB1=0', 'TA2=1', 'GA2=25', 'GB2=-1']), 1, 1);

        self::assertSame(['250', '0'], [$spiel->toreHeimText(), $spiel->toreGastText()]);
        self::assertSame(['25', '0'], [$spiel->toreHeimText(10), $spiel->toreGastText(10)]);
        self::assertSame('2.5', $spiel->toreHeimText(100));
        self::assertSame('250', $spiel->toreHeimText(0), 'ein Faktor 0 zaehlt nicht');
        self::assertSame('_', Spiel::ausRohdaten(self::liga(['[Round1]', 'TA2=1', 'GB2=-1']), 1, 2)->toreGastText(10));
    }

    public function testAnstoss(): void
    {
        $liga = self::liga(['[Round1]', 'TA1=1', 'AT1=1724437800', 'TA2=1', 'AT2=0', 'TA3=1', 'AT3=', 'TA4=1']);

        self::assertSame(1724437800, Spiel::ausRohdaten($liga, 1, 1)->anstoss);
        self::assertSame(0, Spiel::ausRohdaten($liga, 1, 2)->anstoss, 'so schreibt der LMO "kein Anstoss"');
        self::assertNull(Spiel::ausRohdaten($liga, 1, 3)->anstoss, 'in der Datei leer');
        self::assertSame(0, Spiel::ausRohdaten($liga, 1, 4)->anstoss, 'steht nicht in der Datei');
    }

    public function testZusatzNurWennDieLigaIhnFuehrt(): void
    {
        $zeilen = ['[Round1]', 'TA1=1', 'SP1=1', 'TA2=2', 'SP2=0', 'TA3=3'];

        self::assertNull(Spiel::ausRohdaten(self::liga($zeilen), 1, 1)->zusatz, 'Liga ohne Spez');
        $mit = self::liga(array_merge(['[Options]', 'Spez=1'], $zeilen));
        self::assertSame('i.E.', Spiel::ausRohdaten($mit, 1, 1)->zusatzText('n.V.', 'i.E.'));
        self::assertSame('&nbsp;', Spiel::ausRohdaten($mit, 1, 2)->zusatzText('n.V.', 'i.E.'), 'ausdruecklich kein Zusatz');
        self::assertSame('', Spiel::ausRohdaten($mit, 1, 3)->zusatzText('n.V.', 'i.E.'), 'steht nicht in der Datei');
    }

    public function testSpieleEinerPaarungImPokal(): void
    {
        $liga = self::liga(['[Options]', 'Type=1', '[Round1]', 'MO=2', 'TA3=5', 'TB3=6', 'GA31=1', 'GB31=-2', 'SP31=0', 'AT31=100',
            'GA32=2', 'GB32=2', 'SP32=1', 'NT32=Rueckspiel', 'ET32=3']);

        $hin = Spiel::ausRohdaten($liga, 1, 3, 1);
        $rueck = Spiel::ausRohdaten($liga, 1, 3, 2);

        self::assertSame([5, 6, 5, 6], [$hin->heim, $hin->gast, $rueck->heim, $rueck->gast]);
        self::assertSame([1, -2, 0], [$hin->toreHeim, $hin->toreGast, $hin->wertung], 'im Pokal gibt es keine Wertung am gruenen Tisch');
        self::assertSame(['&nbsp;', 100], [$hin->zusatzText('n.V.', 'i.E.'), $hin->anstoss]);
        self::assertSame([2, 2, 0, 'i.E.', 'Rueckspiel'], [$rueck->toreHeim, $rueck->toreGast, $rueck->wertung, $rueck->zusatzText('n.V.', 'i.E.'), $rueck->notiz]);
        self::assertNull(Spiel::ausRohdaten($liga, 1, 3, 3)->toreHeim, 'ein drittes Spiel gibt es nicht');
    }

    public function testAlleMannschaftenSindVollstaendigUndSortiert(): void
    {
        // in der Datei steht Mannschaft 3 vor 1, und Mannschaft 2 fehlt
        $liga = self::liga(['[Options]', 'Teams=4', '[Teams]', '3=Gamma', '1=Alpha', '9=Zuviel']);

        $namen = [];
        foreach ($liga->alleMannschaften() as $nr => $mannschaft) {
            $namen[$nr] = $mannschaft->anzeigename();
        }

        self::assertSame([1 => 'Alpha', 2 => '', 3 => 'Gamma', 4 => ''], $namen);
        self::assertSame([3, 1, 9], array_keys($liga->mannschaften), 'die Rohdaten bleiben, wie sie sind');
    }

    public function testSpieleEinesSpieltagsDerLiga(): void
    {
        // Partie 2 steht vor Partie 1, Partie 3 fehlt
        $liga = self::liga(['[Options]', 'Teams=6', 'Rounds=2', '[Round2]', 'TA2=3', 'TB2=4', 'TA1=1', 'TB1=2', 'GA1=5']);

        $spiele = iterator_to_array($liga->spiele(2), false);

        self::assertContainsOnlyInstancesOf(Spiel::class, $spiele);
        self::assertSame([[2, 1, 1, 1], [2, 2, 1, 3], [2, 3, 1, 0]], array_map(
            static fn (Spiel $s): array => [$s->spieltag, $s->partie, $s->nr, $s->heim],
            $spiele
        ));
        self::assertSame(5, $spiele[0]->toreHeim);
        self::assertCount(3, iterator_to_array($liga->spiele(1), false), 'ein Spieltag ohne Abschnitt: nicht angesetzte Spiele');
        self::assertCount(6, iterator_to_array($liga->alleSpiele(), false), 'zwei Spieltage mit je drei Partien');
        self::assertSame([2], array_keys($liga->spieltage), 'durchlaufen legt nichts an');
    }

    public function testSpieleImPokalNachModusUndRunde(): void
    {
        $liga = self::liga(['[Options]', 'Type=1', 'Teams=8', 'KlFin=1', '[Round1]', 'MO=2', 'TA1=1', 'TB1=2', 'GA12=3', '[Round3]', 'MO=1']);
        $e = $liga->einstellungen();

        self::assertSame(
            [4, 2, 2, 0],
            [$e->partienImSpieltag(1), $e->partienImSpieltag(2), $e->partienImSpieltag(3), $e->partienImSpieltag(4)],
            'Viertelfinale, Halbfinale, Finale mit Spiel um Platz 3'
        );
        $runde1 = iterator_to_array($liga->spiele(1), false);
        self::assertCount(8, $runde1, 'vier Paarungen mit Hin- und Rueckspiel');
        self::assertSame([[1, 1], [1, 2], [2, 1], [2, 2]], array_map(static fn (Spiel $s): array => [$s->partie, $s->nr], array_slice($runde1, 0, 4)));
        self::assertSame(3, $runde1[1]->toreHeim);
        self::assertCount(2, iterator_to_array($liga->spiele(2), false), 'ohne Modus ein Spiel je Paarung');
        self::assertCount(12, iterator_to_array($liga->alleSpiele(), false));
    }

    public function testPaarungenBeiVierundzwanzigMannschaften(): void
    {
        $e = self::liga(['[Options]', 'Type=1', 'Teams=24'])->einstellungen();

        self::assertSame([8, 8, 4, 2, 1], array_map([$e, 'partienImSpieltag'], [1, 2, 3, 4, 5]));
        self::assertSame(9, self::liga(['[Options]', 'Teams=18'])->einstellungen()->partienImSpieltag(7), 'in der Liga jeder Spieltag gleich');
    }

    /** @return array<string, array{string}> */
    public static function ligadateien(): array
    {
        return EinstellungenTest::ligadateien();
    }

    /**
     * Tore, wie LigaDaten sie haelt ("_" und -1 fuer nicht gespielt), als ?int.
     *
     * @param mixed $tore
     */
    private static function toreDerBruecke($tore): ?int
    {
        return $tore === '_' || $tore === -1 || $tore === null || !is_numeric($tore) ? null : (int) $tore;
    }

    /**
     * Solange die alten Seiten ueber LigaDaten arbeiten, muessen beide dasselbe liefern: fuer jede
     * Partie der Datei und fuer einige, die es nicht gibt.
     *
     * @dataProvider ligadateien
     */
    public function testStimmtMitLigaDatenUeberein(string $pfad): void
    {
        $eintraege = LigaDatei::lies($pfad);
        $bruecke = new LigaDaten();
        $bruecke->setzeStartwerte();
        $bruecke->lies($eintraege, 'd.m.Y', 'n.V.', 'i.E.');
        $liga = Liga::ausEintraegen($eintraege);
        $pokal = $liga->istPokal();

        $geprueft = 0;
        foreach (array_keys($bruecke->teama ?? []) as $s) {
            foreach ([0, 1, 2, 8, 30] as $p) {
                if (!isset($bruecke->teama[$s][$p])) {
                    continue;
                }
                $wo = basename($pfad) . ' Spieltag ' . ($s + 1) . ' Partie ' . ($p + 1);
                foreach ($pokal ? [0, 1, 2] : [null] as $n) {
                    $spiel = Spiel::ausRohdaten($liga, $s + 1, $p + 1, ($n ?? 0) + 1);
                    $aus = static fn (?array $feld) => $n === null ? ($feld[$s][$p] ?? null) : ($feld[$s][$p][$n] ?? null);

                    self::assertSame((int) $bruecke->teama[$s][$p], $spiel->heim, $wo);
                    self::assertSame((int) $bruecke->teamb[$s][$p], $spiel->gast, $wo);
                    self::assertSame(self::toreDerBruecke($aus($bruecke->goala)), $spiel->toreHeim, $wo);
                    self::assertSame(self::toreDerBruecke($aus($bruecke->goalb)), $spiel->toreGast, $wo);
                    self::assertSame($aus($bruecke->mspez), $spiel->zusatzText('n.V.', 'i.E.'), $wo);
                    self::assertSame($aus($bruecke->mnote), $spiel->notiz, $wo);
                    self::assertSame($aus($bruecke->mberi), $spiel->bericht, $wo);
                    self::assertSame($aus($bruecke->mtipp) == 1, $spiel->ohneTippwertung, $wo);
                    $anstoss = $aus($bruecke->mterm);
                    self::assertSame(is_numeric($anstoss) ? (int) $anstoss : null, $spiel->anstoss, $wo);
                    if (!$pokal) {
                        self::assertSame((int) $bruecke->msieg[$s][$p], $spiel->wertung, $wo);
                    }
                    $geprueft++;
                }
            }
        }
        self::assertGreaterThan(0, $geprueft);

        // Namen der Mannschaften zum Anzeigen
        foreach ($liga->alleMannschaften() as $nr => $mannschaft) {
            self::assertSame((string) $bruecke->teams[$nr], $mannschaft->anzeigename(), "Mannschaft $nr");
            self::assertSame((string) $bruecke->teamk[$nr], $mannschaft->kurzname(), "Kurzname $nr");
            self::assertSame((string) $bruecke->teamm[$nr], $mannschaft->mittelname(), "Mittelname $nr");
        }
    }
}
