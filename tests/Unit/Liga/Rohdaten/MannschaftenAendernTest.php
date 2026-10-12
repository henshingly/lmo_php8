<?php

namespace Lmo\Tests\Unit\Liga\Rohdaten;

use Lmo\Liga\LigaDatei;
use Lmo\Liga\Rohdaten\Liga;
use Lmo\Liga\Rohdaten\Partie;
use PHPUnit\Framework\TestCase;

/**
 * Mannschaften anlegen und aus der Liga nehmen (Rohdaten\Liga::neueMannschaft() und
 * entferneMannschaft()), wie es der Adminbereich braucht.
 */
class MannschaftenAendernTest extends TestCase
{
    /** Fuenf Mannschaften, zwei Partien je Spieltag */
    private const LIGA = [
        '[Options]', 'Teams=5', 'Rounds=2', 'Matches=2', 'favTeam=3', 'selTeam=5', 'kurve1=3', 'kurve2=4',
        '[Teams]', '1=Alpha', '2=Beta', '3=Gamma', '4=Delta', '5=Epsilon',
        '[Team3]', 'NOT=Notiz Gamma',
        '[Team4]', 'SP=2', 'TOR1=-1', 'STDA=3', 'Farbe=blau',
        '[Round1]', 'TA1=1', 'TB1=3', 'GA1=2', 'GB1=0', 'TA2=4', 'TB2=5', 'GA2=1', 'GB2=1', 'NT2=Notiz', 'TI2=1',
        '[Round2]', 'TA1=5', 'TB1=4', 'GA1=-1', 'GB1=-1', 'TA2=3', 'TB2=2', 'GA2=0', 'GB2=3',
    ];

    private static function liga(): Liga
    {
        return Liga::ausEintraegen(LigaDatei::zerlege(self::LIGA));
    }

    public function testNeueMannschaftKommtHintenDazu(): void
    {
        $liga = self::liga();

        $nr = $liga->neueMannschaft('Neue Mannschaft');

        self::assertSame(6, $nr);
        self::assertSame('6', $liga->optionen['Teams']);
        self::assertSame('Neue Mannschaft', $liga->mannschaften[6]->anzeigename());
        self::assertSame([], $liga->mannschaften[6]->werte);
        self::assertCount(2, $liga->spieltage[1]->partien, 'der Spielplan bleibt');
    }

    public function testEntfernteMannschaftVerliertIhrePartien(): void
    {
        $liga = self::liga();

        $liga->entferneMannschaft(3);

        // Spieltag 1: Alpha - Gamma faellt weg, Delta - Epsilon rueckt auf und heisst jetzt 3 - 4
        $erste = $liga->spieltage[1]->partien[1];
        self::assertSame(['3', '4'], [$erste->heim, $erste->gast]);
        self::assertSame(['GA' => '1', 'GB' => '1', 'NT' => 'Notiz', 'TI' => '1'], $erste->spiele[1], 'mit allem, was zum Spiel gehoert');
        self::assertEquals(Partie::leer(), $liga->spieltage[1]->partien[2], 'hinten ein leerer Platz');
        // Spieltag 2: Epsilon - Delta bleibt vorn, Gamma - Beta faellt weg
        self::assertSame(['4', '3'], [$liga->spieltage[2]->partien[1]->heim, $liga->spieltage[2]->partien[1]->gast]);
        self::assertEquals(Partie::leer(), $liga->spieltage[2]->partien[2]);
    }

    public function testMannschaftenDahinterRueckenMitAllemAuf(): void
    {
        $liga = self::liga();

        $liga->entferneMannschaft(3);

        self::assertSame('4', $liga->optionen['Teams']);
        self::assertSame([1, 2, 3, 4], array_keys($liga->mannschaften));
        self::assertSame(['Alpha', 'Beta', 'Delta', 'Epsilon'], array_map(static fn ($m) => $m->anzeigename(), array_values($liga->mannschaften)));
        self::assertSame(['SP' => '2', 'TOR1' => '-1', 'STDA' => '3', 'Farbe' => 'blau'], $liga->mannschaften[3]->werte, 'Strafen, Torkorrektur und Unbekanntes wandern mit');
    }

    public function testAuswahlenFolgenDenNeuenNummern(): void
    {
        $liga = self::liga();

        $liga->entferneMannschaft(3);

        self::assertSame('0', $liga->optionen['favTeam'], 'die Lieblingsmannschaft gibt es nicht mehr');
        self::assertSame('4', $liga->optionen['selTeam'], 'Epsilon hat jetzt die 4');
        self::assertSame(['3', '0'], [$liga->optionen['kurve1'], $liga->optionen['kurve2']], 'die zweite Mannschaft der Fieberkurve rueckt an die erste Stelle');
    }

    public function testLetzteMannschaftEntfernen(): void
    {
        $liga = self::liga();

        $liga->entferneMannschaft(5);

        self::assertSame([1, 2, 3, 4], array_keys($liga->mannschaften));
        self::assertSame(['1', '3'], [$liga->spieltage[1]->partien[1]->heim, $liga->spieltage[1]->partien[1]->gast], 'die Nummern davor bleiben');
        self::assertEquals(Partie::leer(), $liga->spieltage[1]->partien[2]);
        self::assertSame(['3', '2'], [$liga->spieltage[2]->partien[1]->heim, $liga->spieltage[2]->partien[1]->gast], 'rueckt auf');
        self::assertSame('0', $liga->optionen['selTeam']);
    }

    public function testNummerDieEsNichtGibtAendertNichts(): void
    {
        $liga = self::liga();
        $vorher = $liga->alsText();

        $liga->entferneMannschaft(0);
        $liga->entferneMannschaft(6);

        self::assertSame($vorher, $liga->alsText());
    }

    public function testPlatzDerNichtInDerDateiStehtBleibtFrei(): void
    {
        $liga = Liga::ausEintraegen(LigaDatei::zerlege(['[Options]', 'Teams=5', 'Rounds=1', 'Matches=3', '[Round1]', 'TA1=1', 'TB1=2', 'TA3=4', 'TB3=5']));

        $liga->entferneMannschaft(1);

        self::assertSame([2, 3], array_keys($liga->spieltage[1]->partien), 'der fehlende zweite Platz rueckt mit auf den ersten');
        self::assertSame(['3', '4'], [$liga->spieltage[1]->partien[2]->heim, $liga->spieltage[1]->partien[2]->gast]);
        self::assertEquals(Partie::leer(), $liga->spieltage[1]->partien[3]);
    }

    public function testLeererPlatz(): void
    {
        $leer = Partie::leer();

        self::assertSame(['0', '0'], [$leer->heim, $leer->gast]);
        self::assertSame(['-1', '-1', ''], [$leer->spiele[1]['GA'], $leer->spiele[1]['GB'], $leer->spiele[1]['AT']]);
    }
}
