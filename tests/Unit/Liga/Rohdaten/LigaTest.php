<?php

namespace Lmo\Tests\Unit\Liga\Rohdaten;

use Lmo\Liga\LigaDatei;
use Lmo\Liga\Normalform;
use Lmo\Liga\Rohdaten\Liga;
use Lmo\Tests\GoldenMaster\Support\LeagueFactory;
use PHPUnit\Framework\TestCase;

/**
 * Rohdaten\Liga haelt den Inhalt einer Ligadatei, wie er in der Datei steht, und schreibt ihn
 * unveraendert wieder.
 */
class LigaTest extends TestCase
{
    private const LIGA = <<<'L98'
[Options]
Title=Liga Manager Online 4
Name=Kreisliga [Nord]
Type=0
Teams=3
Eigener=bleibt erhalten

[News]
NC=1
N0=Meldung | mit Strich

[Teams]
1=Alpha
2=Beta
3=Gamma

[Teamm]
2=Beta M

[Teamk]
1=ALP

[Team1]
SP=2
URL=http://alpha.example
Sonder=x

[Round1]
D1=23.08.2024
D2=24.08.2024
HS=030102
TA1=1
TB1=2
GA1=2
GB1=-2
ET1=3
SP1=2
NT1=Abbruch [Nebel] = Wertung
AT1=1724437800
Foo1=unbekannt
TA2=3
TB2=1
GA2=-1
GB2=

[Round2]
D1=
TA1=2
TB1=3

[Eigenes]
Foo=Bar
L98;

    private const POKAL = <<<'L98'
[Options]
Name=Pokal
Type=1
Teams=4

[News]

[Teams]
1=A
2=B
3=C
4=D

[Teamm]

[Teamk]

[Round1]
D1=01.03.2025
MO=2
TA1=1
TB1=2
GA11=1
GB11=0
SP11=2
GA12=-1
GB12=-1
TA10=3
TB10=4
GA101=4
GB101=3
L98;

    /** @return list<array{string, string, string}> */
    private static function eintraege(string $text): array
    {
        return LigaDatei::zerlege(explode("\n", $text));
    }

    public function testLiesEineLiga(): void
    {
        $liga = Liga::ausEintraegen(self::eintraege(self::LIGA));

        self::assertFalse($liga->istPokal());
        self::assertSame('Kreisliga [Nord]', $liga->optionen['Name']);
        self::assertSame('bleibt erhalten', $liga->optionen['Eigener'], 'unbekannte Einstellung');
        self::assertSame(['NC' => '1', 'N0' => 'Meldung | mit Strich'], $liga->news);

        self::assertSame([1, 2, 3], array_keys($liga->mannschaften));
        $alpha = $liga->mannschaften[1];
        self::assertSame(['Alpha', 'ALP', null], [$alpha->name, $alpha->kurz, $alpha->mittel], 'nichts wird abgeleitet');
        self::assertSame(['SP' => '2', 'URL' => 'http://alpha.example', 'Sonder' => 'x'], $alpha->werte);
        self::assertSame('Beta M', $liga->mannschaften[2]->mittel);
        self::assertSame([], $liga->mannschaften[3]->werte);

        self::assertSame([1, 2], array_keys($liga->spieltage));
        $erster = $liga->spieltage[1];
        self::assertSame(['D1' => '23.08.2024', 'D2' => '24.08.2024', 'HS' => '030102'], $erster->werte);
        self::assertSame([1, 2], array_keys($erster->partien), 'so viele Partien, wie in der Datei stehen');
        $partie = $erster->partien[1];
        self::assertSame(['1', '2'], [$partie->heim, $partie->gast]);
        self::assertSame(
            [1 => ['GA' => '2', 'GB' => '-2', 'ET' => '3', 'SP' => '2', 'NT' => 'Abbruch [Nebel] = Wertung', 'AT' => '1724437800', 'Foo' => 'unbekannt']],
            $partie->spiele,
            'Werte unveraendert: -2 bleibt -2, der Zusatz bleibt eine Zahl'
        );
        self::assertSame([1 => ['GA' => '-1', 'GB' => '']], $erster->partien[2]->spiele);
        self::assertSame(['D1' => ''], $liga->spieltage[2]->werte);
        self::assertSame([], $liga->spieltage[2]->partien[1]->spiele);

        self::assertSame([['Eigenes', [['Foo', 'Bar']]]], $liga->weitereAbschnitte);
    }

    public function testLiesEinenPokal(): void
    {
        $pokal = Liga::ausEintraegen(self::eintraege(self::POKAL));

        self::assertTrue($pokal->istPokal());
        $runde = $pokal->spieltage[1];
        self::assertSame(['D1' => '01.03.2025', 'MO' => '2'], $runde->werte);
        self::assertSame([1, 10], array_keys($runde->partien));
        self::assertSame(['1', '2'], [$runde->partien[1]->heim, $runde->partien[1]->gast]);
        self::assertSame(
            [1 => ['GA' => '1', 'GB' => '0', 'SP' => '2'], 2 => ['GA' => '-1', 'GB' => '-1']],
            $runde->partien[1]->spiele,
            'Hin- und Rueckspiel'
        );
        self::assertSame([1 => ['GA' => '4', 'GB' => '3']], $runde->partien[10]->spiele, 'GA101 = Paarung 10, Spiel 1');
    }

    /** @return array<string, array{string}> */
    public static function dateien(): array
    {
        return ['Liga' => [self::LIGA], 'Pokal' => [self::POKAL]];
    }

    /**
     * Laden und Speichern sind ein Paar: der Text der Datei kommt Zeichen fuer Zeichen wieder heraus.
     *
     * @dataProvider dateien
     */
    public function testGeladenUndGespeichertErgibtDieselbeDatei(string $text): void
    {
        self::assertSame($text . "\n", Liga::ausEintraegen(self::eintraege($text))->alsText());
    }

    public function testEineNeueLigaIstLeerUndLaesstSichSpeichern(): void
    {
        $liga = new Liga();

        self::assertFalse($liga->istPokal());
        self::assertSame("[Options]\n\n[News]\n\n[Teams]\n\n[Teamm]\n\n[Teamk]\n", $liga->alsText());
        self::assertEquals($liga, Liga::ausEintraegen(self::eintraege($liga->alsText())));
    }

    public function testEineVonHandAufgebauteLigaWirdGespeichertUndWiederGleichGelesen(): void
    {
        $liga = new Liga();
        $liga->optionen = ['Name' => 'Neue Liga', 'Type' => '0', 'Teams' => '2'];
        $liga->mannschaft(1)->name = 'Alpha';
        $liga->mannschaft(2)->name = 'Beta';
        $liga->mannschaft(2)->werte['NOT'] = 'Aufsteiger';
        $partie = $liga->spieltag(1)->partien[1] = new \Lmo\Liga\Rohdaten\Partie();
        $partie->heim = '1';
        $partie->gast = '2';
        $partie->spiele[1] = ['GA' => '3', 'GB' => '1'];
        $liga->spieltag(1)->werte['D1'] = '07.09.2024';

        $text = $liga->alsText();

        self::assertSame(
            "[Options]\nName=Neue Liga\nType=0\nTeams=2\n\n[News]\n\n[Teams]\n1=Alpha\n2=Beta\n\n[Teamm]\n\n[Teamk]\n\n"
            . "[Team2]\nNOT=Aufsteiger\n\n[Round1]\nD1=07.09.2024\nTA1=1\nTB1=2\nGA1=3\nGB1=1\n",
            $text
        );
        self::assertEquals($liga, Liga::ausEintraegen(self::eintraege($text)));
    }

    public function testSchreibenUndLesenEinerDatei(): void
    {
        $pfad = sys_get_temp_dir() . '/lmo-rohdaten-' . getmypid() . '-' . bin2hex(random_bytes(3)) . '.l98';
        $liga = Liga::ausEintraegen(self::eintraege(self::LIGA));
        try {
            self::assertTrue($liga->schreibe($pfad));
            self::assertSame(self::LIGA . "\n", file_get_contents($pfad));
            self::assertEquals($liga, Liga::lies($pfad));
        } finally {
            @unlink($pfad);
        }
        self::assertFalse($liga->schreibe(sys_get_temp_dir() . '/gibt-es-nicht-' . getmypid() . '/liga.l98'));
        self::assertEquals(new Liga(), Liga::lies($pfad), 'eine fehlende Datei ergibt eine leere Liga');
    }

    public function testWasSichKeinerPartieZuordnenLaesstBleibtBeimSpieltag(): void
    {
        $liga = Liga::ausEintraegen(self::eintraege("[Options]\nType=1\n[Round1]\nGA1=2\nGA01=3\nXY=7\nTA0=1"));

        self::assertSame(['GA1' => '2', 'GA01' => '3', 'XY' => '7', 'TA0' => '1'], $liga->spieltage[1]->werte, 'im Pokal fehlt bei GA1 das Spiel');
        self::assertSame([], $liga->spieltage[1]->partien);
        self::assertSame("[Round1]\nGA1=2\nGA01=3\nXY=7\nTA0=1\n", substr($liga->alsText(), -33));
    }

    /**
     * Alle Ligadateien des Repos und die erzeugten Testligen, jeweils so, wie der LMO sie speichert.
     *
     * @return iterable<string, array{string}>
     */
    public static function vomLmoGespeicherteLigen(): iterable
    {
        $lmo = dirname(__DIR__, 4) . '/lmo';
        $erzeugt = sys_get_temp_dir() . '/lmo-rohdaten-ligen-' . getmypid();
        if (!is_dir($erzeugt)) {
            mkdir($erzeugt);
            LeagueFactory::writeAll($lmo, $erzeugt);
        }
        $dateien = array_merge(
            glob($lmo . '/ligen/*.l98') ?: [],
            glob($lmo . '/ligen/*/*.l98') ?: [],
            glob(dirname($lmo) . '/docker/demo/ligen/*.l98') ?: [],
            glob($erzeugt . '/*.l98') ?: []
        );
        foreach ($dateien as $pfad) {
            // wie lmo-saveliga.php: gelesen und in der vollstaendigen Form wieder geschrieben
            $liga = Liga::lies($pfad);
            yield basename(dirname($pfad)) . '/' . basename($pfad) => [
                Normalform::von($liga, 'Liga Manager Online 4', $liga->einstellungen()->aktuellerSpieltag(), 'd.m.Y H:i')->alsText(),
            ];
        }
    }

    /**
     * @dataProvider vomLmoGespeicherteLigen
     */
    public function testVomLmoGespeicherteDateiBleibtZeichengleich(string $text): void
    {
        self::assertGreaterThan(100, strlen($text));
        self::assertSame($text, Liga::ausEintraegen(self::eintraege($text))->alsText());
    }

    /**
     * Auch von Hand geschriebene Dateien (andere Reihenfolge, fehlende Abschnitte) verlieren nichts:
     * dieselben Schluessel und Werte je Abschnitt.
     */
    public function testVonHandGeschriebeneDateiVerliertNichts(): void
    {
        $lmo = dirname(__DIR__, 4) . '/lmo';
        $dateien = array_merge(glob($lmo . '/ligen/*.l98') ?: [], glob($lmo . '/ligen/*/*.l98') ?: [], glob(dirname(__DIR__) . '/fixtures/*.l98') ?: []);
        self::assertNotEmpty($dateien);
        foreach ($dateien as $pfad) {
            $vorher = LigaDatei::lies($pfad);
            $nachher = self::eintraege(Liga::ausEintraegen($vorher)->alsText());
            $sortiert = static function (array $eintraege): array {
                usort($eintraege, static fn (array $a, array $b): int => $a <=> $b);

                return $eintraege;
            };
            self::assertSame($sortiert($vorher), $sortiert($nachher), basename($pfad));
        }
    }

    public function testZeilenVorDemErstenAbschnittWerdenNichtUebernommen(): void
    {
        $liga = Liga::ausEintraegen(self::eintraege("vorab=1\n[Options]\nName=Liga"));

        self::assertSame(['Name' => 'Liga'], $liga->optionen);
        self::assertSame([], $liga->weitereAbschnitte);
        self::assertStringNotContainsString('vorab', $liga->alsText());
    }

    public function testMannschaftsnameZumAnzeigen(): void
    {
        $liga = Liga::ausEintraegen(LigaDatei::zerlege(['[Teams]', "1=O\\'Neill", '2=B | C', '[Teamk]', '3=XYZ']));

        self::assertSame("O'Neill", $liga->mannschaften[1]->anzeigename(), 'ohne die Schraegstriche der Datei');
        self::assertSame('', $liga->mannschaften[3]->anzeigename(), 'nur ein Kurzname');
        // dasselbe ueber die Nummer, wie sie in einer Partie steht
        self::assertSame("O'Neill", $liga->mannschaftsname(1));
        self::assertSame('B | C', $liga->mannschaftsname('2'), 'die Nummer steht in einer Partie als Text');
        self::assertSame('', $liga->mannschaftsname(3), 'nur ein Kurzname');
        self::assertSame('', $liga->mannschaftsname(9));
        self::assertSame('', $liga->mannschaftsname('0'));
        self::assertSame("O\\'Neill", $liga->mannschaften[1]->name, 'die Rohdaten bleiben, wie sie sind');
        self::assertCount(3, $liga->mannschaften, 'nachfragen legt nichts an');
    }

    public function testKurzUndMittelnameZumAnzeigen(): void
    {
        $liga = Liga::ausEintraegen(LigaDatei::zerlege(['[Teams]', '1=SV Werder/Bremen II', '2=Eintracht Frankfurt', '3=VfL', '[Teamm]', '2=SGE', '[Teamk]', '1=SVW']));

        self::assertSame(['SVW', 'Bremen'], [$liga->mannschaften[1]->kurzname(), $liga->mannschaften[1]->mittelname()], 'laengstes Wort, bei gleicher Laenge das letzte; "/" trennt');
        self::assertSame(['Eintr', 'SGE'], [$liga->mannschaften[2]->kurzname(), $liga->mannschaften[2]->mittelname()], 'die ersten 5 Zeichen');
        self::assertSame(['VfL', 'VfL'], [$liga->mannschaften[3]->kurzname(), $liga->mannschaften[3]->mittelname()]);
        self::assertNull($liga->mannschaften[3]->kurz, 'die Rohdaten bleiben, wie sie sind');
        self::assertSame(['', ''], [(new \Lmo\Liga\Rohdaten\Mannschaft())->kurzname(), (new \Lmo\Liga\Rohdaten\Mannschaft())->mittelname()]);
    }

    public function testSpieltagNenntErstenUndLetztenTagAlsZeit(): void
    {
        $liga = Liga::ausEintraegen(LigaDatei::zerlege(['[Round1]', 'D1=1.9.2024', 'D2=31.02.2025', '[Round2]', 'D2=02.09.2024', '[Round3]', 'D1=bald']));

        self::assertSame(mktime(0, 0, 0, 9, 1, 2024), $liga->spieltage[1]->ersterTag());
        self::assertNull($liga->spieltage[1]->letzterTag(), 'den Tag gibt es nicht');
        self::assertNull($liga->spieltage[2]->ersterTag(), 'steht nicht in der Datei');
        self::assertSame(mktime(0, 0, 0, 9, 2, 2024), $liga->spieltage[2]->letzterTag());
        self::assertNull($liga->spieltage[3]->ersterTag());
        self::assertSame('1.9.2024', $liga->spieltage[1]->werte['D1'], 'die Rohdaten bleiben, wie sie sind');
        // zum Anzeigen immer TT.MM.JJJJ, sonst leer
        self::assertSame(['01.09.2024', ''], [$liga->spieltage[1]->ersterTagText(), $liga->spieltage[1]->letzterTagText()]);
        self::assertSame(['', '02.09.2024'], [$liga->spieltage[2]->ersterTagText(), $liga->spieltage[2]->letzterTagText()]);
    }

    public function testEinstellungenAendernDieRohdatenNicht(): void
    {
        $liga = new Liga();
        $vorher = $liga->alsText();

        self::assertSame(18, $liga->einstellungen()->wert('Teams'));
        self::assertSame([], $liga->optionen);
        self::assertSame($vorher, $liga->alsText());
    }
}
