<?php

namespace Lmo\Tests\Unit\Liga;

use Lmo\Liga\LigaDatei;
use Lmo\Liga\Rohdaten\Liga;
use Lmo\Liga\Tabelle;
use PHPUnit\Framework\TestCase;

/**
 * Tabelle rechnet die Tabelle einer Liga aus den Spielen der Rohdaten. Dass sie fuer alle Testligen
 * dasselbe liefert wie die bisherige Rechnung, belegt CalculationTest ueber lmo-calctable.php; hier
 * stehen kleine Faelle zum Nachrechnen.
 */
class TabelleTest extends TestCase
{
    /** Vier Mannschaften, zwei gespielte Spieltage. */
    private const SPIELE = [
        '[Round1]', 'TA1=1', 'TB1=2', 'GA1=2', 'GB1=0', 'TA2=3', 'TB2=4', 'GA2=1', 'GB2=1',
        '[Round2]', 'TA1=2', 'TB1=3', 'GA1=3', 'GB1=1', 'TA2=4', 'TB2=1', 'GA2=0', 'GB2=2',
        '[Round3]', 'TA1=1', 'TB1=3', 'GA1=-1', 'GB1=-1',
    ];

    /**
     * @param list<string> $optionen
     * @param list<string> $weitere
     * @param list<string>|null $spiele
     */
    private static function liga(array $optionen = [], array $weitere = [], ?array $spiele = null): Liga
    {
        return Liga::ausEintraegen(LigaDatei::zerlege(array_merge(['[Options]', 'Teams=4'], $optionen, $weitere, $spiele ?? self::SPIELE)));
    }

    /** @return array{int, int, int, int, int, int, int} Spiele, Siege, Unentschieden, Niederlagen, Punkte, Tore, Gegentore */
    private static function bilanz(Tabelle $tabelle, int $nr): array
    {
        $z = $tabelle->zeilen[$nr];

        return [$z->spiele, $z->siege, $z->unentschieden, $z->niederlagen, $z->punkte, $z->tore, $z->gegentore];
    }

    public function testGesamttabelle(): void
    {
        $tabelle = Tabelle::berechne(self::liga());

        self::assertSame([2, 2, 0, 0, 6, 4, 0], self::bilanz($tabelle, 1));
        self::assertSame([2, 1, 0, 1, 3, 3, 3], self::bilanz($tabelle, 2));
        self::assertSame([2, 0, 1, 1, 1, 2, 4], self::bilanz($tabelle, 3));
        self::assertSame([2, 0, 1, 1, 1, 1, 3], self::bilanz($tabelle, 4));
        self::assertSame([1, 2, 3, 4], $tabelle->reihenfolge, 'bei gleicher Differenz entscheiden die erzielten Tore');
        self::assertSame(2, $tabelle->letzterGewerteterSpieltag, 'Spieltag 3 ist nicht gespielt');
        self::assertSame(0, $tabelle->zeilen[3]->tordifferenz() + 2);
        self::assertSame([], $tabelle->direkteVergleiche);
    }

    public function testEineLeereLigaHatLeereZeilen(): void
    {
        $tabelle = Tabelle::berechne(new Liga());

        self::assertCount(18, $tabelle->zeilen, 'ohne Angabe 18 Mannschaften');
        self::assertSame([0, 0, 0, 0, 0, 0, 0], self::bilanz($tabelle, 18));
        self::assertSame(range(18, 1), $tabelle->reihenfolge, 'ohne Spiele die hoehere Nummer zuerst, wie bisher');
        self::assertSame(0, $tabelle->letzterGewerteterSpieltag);
    }

    public function testHeimUndAuswaertstabelle(): void
    {
        $heim = Tabelle::berechne(self::liga(), Tabelle::HEIM);
        $auswaerts = Tabelle::berechne(self::liga(), Tabelle::AUSWAERTS);

        self::assertSame([1, 1, 0, 0, 3, 2, 0], self::bilanz($heim, 1));
        self::assertSame([1, 1, 0, 0, 3, 3, 1], self::bilanz($heim, 2));
        self::assertSame([1, 0, 0, 1, 0, 0, 2], self::bilanz($heim, 4));
        self::assertSame([2, 1, 3, 4], $heim->reihenfolge);
        self::assertSame([1, 1, 0, 0, 3, 2, 0], self::bilanz($auswaerts, 1));
        self::assertSame([1, 0, 0, 1, 0, 0, 2], self::bilanz($auswaerts, 2));
        self::assertSame([1, 0, 1, 0, 1, 1, 1], self::bilanz($auswaerts, 4));
    }

    public function testBisZuEinemSpieltagUndAbEinemSpieltag(): void
    {
        $bisEins = Tabelle::berechne(self::liga(), Tabelle::GESAMT, 1, 1);
        $abZwei = Tabelle::berechne(self::liga(), Tabelle::GESAMT, 2);

        self::assertSame([1, 4, 3, 2], $bisEins->reihenfolge, 'bei voelligem Gleichstand die hoehere Nummer zuerst');
        self::assertSame(1, $bisEins->letzterGewerteterSpieltag);
        self::assertSame([1, 1, 0, 0, 3, 2, 0], self::bilanz($abZwei, 1));
        self::assertSame([1, 0, 0, 1, 0, 1, 3], self::bilanz($abZwei, 3));
    }

    public function testAnsichtenDesLmoKennenDieSaisonhaelften(): void
    {
        // vier Mannschaften: sechs Spieltage, die Saisonhaelfte liegt nach Spieltag 3
        $liga = self::liga();

        $rueck = Tabelle::fuerAnsicht($liga, Tabelle::RUECKRUNDE, 6);
        $hin = Tabelle::fuerAnsicht($liga, Tabelle::HINRUNDE, 6);
        $heimHin = Tabelle::fuerAnsicht($liga, Tabelle::HEIM, 5, Tabelle::HINRUNDE);
        $gesamt = Tabelle::fuerAnsicht($liga, Tabelle::GESAMT, 1);

        self::assertSame([4, 6], [$rueck->von, $rueck->bis]);
        self::assertSame(0, $rueck->zeilen[1]->spiele, 'in der Rueckrunde ist noch nichts gespielt');
        self::assertSame([1, 3], [$hin->von, $hin->bis], 'die Hinrunde endet an der Saisonhaelfte, was auch immer angegeben ist');
        self::assertSame([2, 6], [$hin->zeilen[1]->spiele, $hin->zeilen[1]->punkte]);
        self::assertSame([1, 3], [$heimHin->von, $heimHin->bis]);
        self::assertSame([1, 3], [$heimHin->zeilen[1]->spiele, $heimHin->zeilen[1]->punkte], 'nur das Heimspiel');
        self::assertSame([1, 1, 1], [$gesamt->von, $gesamt->bis, $gesamt->zeilen[1]->spiele]);
    }

    public function testPlatzUndHandicapReihenfolge(): void
    {
        $tabelle = Tabelle::berechne(self::liga());

        self::assertSame([1, 2, 3, 4], $tabelle->reihenfolge);
        self::assertSame([2, 4, null], [$tabelle->platz(2), $tabelle->platz(4), $tabelle->platz(9)]);
        // der Erste der Tabelle wird auf Platz 3 gefuehrt, der Zweite auf 1, der Dritte auf 2, der Vierte auf 4
        self::assertSame([2, 3, 1, 4], $tabelle->reihenfolgeNachHandicap('03010204'));
        self::assertSame([1, 2, 3, 4], $tabelle->reihenfolgeNachHandicap('0'), 'ohne Angabe die Reihenfolge der Tabelle');
        self::assertSame([1, 2, 3, 4], $tabelle->reihenfolgeNachHandicap(''));
        self::assertSame([1, 2, 3, 4], $tabelle->reihenfolge, 'die Tabelle selbst bleibt, wie sie ist');
    }

    public function testSerienUndHoechsterSieg(): void
    {
        $tabelle = Tabelle::berechne(self::liga());
        $erste = $tabelle->zeilen[1];
        $zweite = $tabelle->zeilen[2];

        self::assertSame([2, 2, 0, 0], [$erste->serieSiege, $erste->serieUngeschlagen, $erste->serieNiederlagen, $erste->serieSieglos]);
        self::assertSame([1, 1, 0, 0], [$zweite->serieSiege, $zweite->serieUngeschlagen, $zweite->serieNiederlagen, $zweite->serieSieglos], 'nach der Niederlage ein Sieg');
        self::assertSame([0, 0, 1, 2], [$tabelle->zeilen[4]->serieSiege, $tabelle->zeilen[4]->serieUngeschlagen, $tabelle->zeilen[4]->serieNiederlagen, $tabelle->zeilen[4]->serieSieglos]);

        // zweimal 2:0 gewonnen, einmal daheim, einmal auswaerts
        self::assertSame([2, 0], [$erste->hoechsterSieg->tore, $erste->hoechsterSieg->gegentore]);
        self::assertCount(2, $erste->hoechsterSieg->spiele);
        self::assertSame([[1, true], [2, false]], array_map(static fn (array $e): array => [$e[0]->spieltag, $e[1]], $erste->hoechsterSieg->spiele));
        self::assertSame([], $erste->hoechsteNiederlage->spiele);
        self::assertSame([0, 2, 1], [$zweite->hoechsteNiederlage->tore, $zweite->hoechsteNiederlage->gegentore, count($zweite->hoechsteNiederlage->spiele)]);
    }

    public function testHoechsterSiegAlsText(): void
    {
        $namen = ['[Teams]', '1=Eins', '2=Zwei', '3=Drei', '4=Vier'];
        $erste = Tabelle::berechne(self::liga([], $namen))->zeilen[1];

        self::assertSame('2:0 gegen Zwei (H)<br>2:0 gegen Vier (A)', $erste->hoechsterSieg->alsText(1, 'gegen', '(H)', '(A)'));
        self::assertSame('0.2:0 gegen Zwei (H)<br>0.2:0 gegen Vier (A)', $erste->hoechsterSieg->alsText(10, 'gegen', '(H)', '(A)'), 'mit Torfaktor');
        self::assertSame('&nbsp;', $erste->hoechsteNiederlage->alsText(1, 'gegen', '(H)', '(A)'), 'ohne Niederlage');

        // ein 0:0 am gruenen Tisch als erster Sieg: davor bleibt wie bisher eine leere Zeile
        $wertung = Tabelle::berechne(self::liga([], $namen, ['[Round1]', 'TA1=1', 'TB1=2', 'GA1=-2', 'GB1=0']))->zeilen[1];
        self::assertSame('&nbsp;<br>0:0 gegen Zwei (H)', $wertung->hoechsterSieg->alsText(1, 'gegen', '(H)', '(A)'));
    }

    public function testPunkteDerLigaUndMinuspunkte(): void
    {
        $tabelle = Tabelle::berechne(self::liga(['PointsForWin=2', 'PointsForDraw=1', 'MinusPoints=2']));

        self::assertSame([4, 0], [$tabelle->zeilen[1]->punkte, $tabelle->zeilen[1]->minuspunkte]);
        self::assertSame([2, 2], [$tabelle->zeilen[2]->punkte, $tabelle->zeilen[2]->minuspunkte]);
        self::assertSame([1, 3], [$tabelle->zeilen[3]->punkte, $tabelle->zeilen[3]->minuspunkte]);
        self::assertSame(0, Tabelle::berechne(self::liga())->zeilen[3]->minuspunkte, 'ohne Minuspunkte bleiben sie 0');
    }

    public function testEigenePunkteNachVerlaengerungUndImElfmeterschiessen(): void
    {
        $optionen = ['Spez=1', 'XtraS=2', 'XtraV=1', 'SpezS=5', 'SpezV=4'];
        $spiele = ['[Round1]', 'TA1=1', 'TB1=2', 'GA1=2', 'GB1=1', 'SP1=2', 'TA2=3', 'TB2=4', 'GA2=4', 'GB2=3', 'SP2=1'];

        $tabelle = Tabelle::berechne(self::liga($optionen, [], $spiele));

        self::assertSame([2, 1], [$tabelle->zeilen[1]->punkte, $tabelle->zeilen[2]->punkte], 'nach Verlaengerung');
        self::assertSame([5, 4], [$tabelle->zeilen[3]->punkte, $tabelle->zeilen[4]->punkte], 'im Elfmeterschiessen');
        $ohne = Tabelle::berechne(self::liga(['XtraS=2'], [], $spiele));
        self::assertSame(3, $ohne->zeilen[1]->punkte, 'fuehrt die Liga keine Verlaengerung, gelten die normalen Punkte');
    }

    public function testWertungAmGruenenTisch(): void
    {
        // Spiel 1 fuer Heim gewertet, Spiel 2 fuer Gast, Spiel 3 gegen beide (0:3 aus Sicht der Heimmannschaft)
        $spiele = ['[Round1]', 'TA1=1', 'TB1=2', 'GA1=-2', 'GB1=0', 'TA2=3', 'TB2=4', 'GA2=5', 'GB2=-2',
            '[Round2]', 'TA1=1', 'TB1=3', 'GA1=0', 'GB1=3', 'ET1=3'];

        $tabelle = Tabelle::berechne(self::liga([], [], $spiele));

        self::assertSame([2, 1, 0, 1, 3, 0, 3], self::bilanz($tabelle, 1), 'Sieg am gruenen Tisch, dann Niederlage 0:3');
        self::assertSame([1, 0, 0, 1, 0, 0, 0], self::bilanz($tabelle, 2));
        self::assertSame([2, 0, 0, 2, 0, 5, 3], self::bilanz($tabelle, 3), 'trotz 5:0 verloren; beim Spiel gegen beide zaehlt auch fuer den Gast 0:3');
        self::assertSame([1, 1, 0, 0, 3, 0, 5], self::bilanz($tabelle, 4));
        self::assertTrue($tabelle->zeilen[1]->hoechsterSieg->beginntLeer, 'ein 0:0 am gruenen Tisch als erster Sieg');
    }

    public function testStrafenAbIhremStichtag(): void
    {
        $strafe = ['[Team1]', 'SP=2', 'TOR1=1', 'TOR2=-1', 'STDA=2'];

        self::assertSame([2, 2, 0, 0, 4, 3, 1], self::bilanz(Tabelle::berechne(self::liga([], $strafe)), 1), 'zwei Punkte und ein Tor weniger, ein Gegentor mehr');
        self::assertSame(3, Tabelle::berechne(self::liga([], $strafe), Tabelle::GESAMT, 1, 1)->zeilen[1]->punkte, 'vor dem Stichtag noch nicht');
        self::assertSame(3, Tabelle::berechne(self::liga([], $strafe), Tabelle::HEIM)->zeilen[1]->punkte, 'in der Heimtabelle nie');
        // Saisonhaelfte bei 6 Spieltagen: 3. Der Stichtag 2 liegt in der Hinrunde.
        self::assertSame(4, Tabelle::berechne(self::liga([], $strafe), Tabelle::HINRUNDE, 1, 3)->zeilen[1]->punkte);
        self::assertSame(0, Tabelle::berechne(self::liga([], $strafe), Tabelle::RUECKRUNDE, 4, 6)->zeilen[1]->punkte, 'in der Rueckrunde zaehlt sie nicht');
        // die Saison ist erst bei Spieltag 2: ein Stichtag 3 greift noch nicht, auch wenn bis zum Ende gerechnet wird
        self::assertSame(6, Tabelle::berechne(self::liga([], ['[Team1]', 'SP=2', 'STDA=3']))->zeilen[1]->punkte);
    }

    public function testKegelligaSortiertNachTorenVorDerDifferenz(): void
    {
        $spiele = ['[Round1]', 'TA1=1', 'TB1=2', 'GA1=5', 'GB1=4', 'TA2=3', 'TB2=4', 'GA2=3', 'GB2=0'];

        self::assertSame([3, 1, 2, 4], Tabelle::berechne(self::liga([], [], $spiele))->reihenfolge, 'bessere Differenz');
        self::assertSame([1, 3, 2, 4], Tabelle::berechne(self::liga(['Kegel=1'], [], $spiele))->reihenfolge, 'mehr Tore');
    }

    public function testDirekterVergleich(): void
    {
        // Mannschaft 1, 2 und 4 haben je 3 Punkte; 2 hat die beste Tordifferenz, hat aber gegen 1 verloren
        $spiele = ['[Round1]', 'TA1=1', 'TB1=2', 'GA1=1', 'GB1=0', '[Round2]', 'TA1=2', 'TB1=3', 'GA1=5', 'GB1=0', 'TA2=4', 'TB2=1', 'GA2=1', 'GB2=0'];

        $ohne = Tabelle::berechne(self::liga([], [], $spiele));
        $mit = Tabelle::berechne(self::liga(['Direct=1'], [], $spiele));

        self::assertSame([2, 4, 1, 3], $ohne->reihenfolge, 'nach Tordifferenz');
        self::assertSame([4, 1, 2, 3], $mit->reihenfolge, 'nach den Spielen gegeneinander: 4 schlug 1, 1 schlug 2');
        self::assertCount(1, $mit->direkteVergleiche);
        $vergleich = $mit->direkteVergleiche[0];
        self::assertSame([1, 4, 2], $vergleich['mannschaften'], 'vom letzten zum ersten der Gruppe vor dem Vergleich');
        self::assertSame(4, $vergleich['wertungen'], 'zwei Spiele, je zwei Mannschaften');
        self::assertSame([4, 1, 2], $vergleich['reihenfolge']);
        self::assertSame([2, 3, 1, 1], [$vergleich['zeilen'][1]->spiele, $vergleich['zeilen'][1]->punkte, $vergleich['zeilen'][1]->tore, $vergleich['zeilen'][1]->gegentore]);
        self::assertSame(3, $mit->zeilen[2]->punkte, 'die Gesamtbilanz bleibt, wie sie ist');
    }

    public function testDirekterVergleichOhneSpieleGegeneinanderAendertNichts(): void
    {
        $spiele = ['[Round1]', 'TA1=1', 'TB1=2', 'GA1=1', 'GB1=0', 'TA2=3', 'TB2=4', 'GA2=3', 'GB2=0'];

        $tabelle = Tabelle::berechne(self::liga(['Direct=1'], [], $spiele));

        self::assertSame([3, 1, 2, 4], $tabelle->reihenfolge);
        self::assertSame([0, 0], array_column($tabelle->direkteVergleiche, 'wertungen'), 'zwei Gruppen, keine hat gegeneinander gespielt');
    }
}
