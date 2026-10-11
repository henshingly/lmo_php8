<?php

namespace Lmo\Tests\Unit\Liga;

use Lmo\Liga\LigaDatei;
use Lmo\Liga\LigaDaten;
use Lmo\Liga\Rohdaten\Liga;
use Lmo\Liga\Spiel;
use PHPUnit\Framework\TestCase;

/**
 * Spiel leitet aus den Rohdaten ab, was die Seiten von einer Partie zeigen.
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
        self::assertSame(['4', '7'], [$spiel->heim, $spiel->gast]);
        self::assertSame(['2', '1', 0], [$spiel->toreHeim, $spiel->toreGast, $spiel->wertung]);
        self::assertSame('2', $spiel->zusatz);
        self::assertSame('n.V.', $spiel->zusatzText('n.V.', 'i.E.'));
        self::assertSame(['Notiz | mit Strich', 'http://bericht.example', '1', '1724437800'], [$spiel->notiz, $spiel->bericht, $spiel->tipp, $spiel->anstoss]);
    }

    public function testEinePartieDieEsNichtGibtIstEinNichtAngesetztesSpiel(): void
    {
        $spiel = Spiel::ausRohdaten(new Liga(), 5, 9);

        self::assertFalse($spiel->hatMannschaften());
        self::assertSame(['0', '0', '_', '_', 0], [$spiel->heim, $spiel->gast, $spiel->toreHeim, $spiel->toreGast, $spiel->wertung]);
        self::assertNull($spiel->zusatz);
        self::assertSame('', $spiel->zusatzText('n.V.', 'i.E.'));
        self::assertSame(['', '', '', '0'], [$spiel->notiz, $spiel->bericht, $spiel->tipp, $spiel->anstoss]);
    }

    public function testToreUndWertungAmGruenenTisch(): void
    {
        $liga = self::liga(['[Round1]', 'TA1=1', 'GA1=-1', 'GB1=', 'TA2=1', 'GA2=-2', 'GB2=3', 'TA3=1', 'GA3=0', 'GB3=-2', 'TA4=1', 'GA4=1', 'GB4=1', 'ET4=3']);

        self::assertSame(['_', -1, 0], self::tore($liga, 1), 'nicht gespielt / in der Datei leer');
        self::assertSame(['0', '3', 1], self::tore($liga, 2), 'Wertung fuer Heim');
        self::assertSame(['0', '0', 2], self::tore($liga, 3), 'Wertung fuer Gast');
        self::assertSame(['1', '1', 3], self::tore($liga, 4), 'Wertung gegen beide');
    }

    /** @return array{int|string, int|string, int} */
    private static function tore(Liga $liga, int $partie): array
    {
        $spiel = Spiel::ausRohdaten($liga, 1, $partie);

        return [$spiel->toreHeim, $spiel->toreGast, $spiel->wertung];
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

        self::assertSame(['5', '6', '5', '6'], [$hin->heim, $hin->gast, $rueck->heim, $rueck->gast]);
        self::assertSame(['1', '-2', 0], [$hin->toreHeim, $hin->toreGast, $hin->wertung], 'im Pokal gibt es keine Wertung am gruenen Tisch');
        self::assertSame(['&nbsp;', '100'], [$hin->zusatzText('n.V.', 'i.E.'), $hin->anstoss]);
        self::assertSame(['2', '2', 0, 'i.E.', 'Rueckspiel'], [$rueck->toreHeim, $rueck->toreGast, $rueck->wertung, $rueck->zusatzText('n.V.', 'i.E.'), $rueck->notiz]);
        self::assertSame('_', Spiel::ausRohdaten($liga, 1, 3, 3)->toreHeim, 'ein drittes Spiel gibt es nicht');
    }

    /** @return array<string, array{string}> */
    public static function ligadateien(): array
    {
        return EinstellungenTest::ligadateien();
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

                    self::assertSame((string) $bruecke->teama[$s][$p], $spiel->heim, $wo);
                    self::assertSame((string) $bruecke->teamb[$s][$p], $spiel->gast, $wo);
                    self::assertSame($aus($bruecke->goala), $spiel->toreHeim, $wo);
                    self::assertSame($aus($bruecke->goalb), $spiel->toreGast, $wo);
                    self::assertSame($aus($bruecke->mspez), $spiel->zusatzText('n.V.', 'i.E.'), $wo);
                    self::assertSame($aus($bruecke->mnote), $spiel->notiz, $wo);
                    self::assertSame($aus($bruecke->mberi), $spiel->bericht, $wo);
                    self::assertSame($aus($bruecke->mtipp), $spiel->tipp, $wo);
                    self::assertSame((string) $aus($bruecke->mterm), $spiel->anstoss, $wo);
                    if (!$pokal) {
                        self::assertSame((int) $bruecke->msieg[$s][$p], $spiel->wertung, $wo);
                    }
                    $geprueft++;
                }
            }
        }
        self::assertGreaterThan(0, $geprueft);

        // Namen der Mannschaften zum Anzeigen
        for ($nr = 1; $nr <= $bruecke->anzteams; $nr++) {
            $mannschaft = $liga->mannschaften[$nr] ?? new \Lmo\Liga\Rohdaten\Mannschaft();
            self::assertSame((string) $bruecke->teams[$nr], $mannschaft->anzeigename(), "Mannschaft $nr");
            self::assertSame((string) $bruecke->teamk[$nr], $mannschaft->kurzname(), "Kurzname $nr");
            self::assertSame((string) $bruecke->teamm[$nr], $mannschaft->mittelname(), "Mittelname $nr");
        }
    }
}
