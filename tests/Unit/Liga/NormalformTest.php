<?php

namespace Lmo\Tests\Unit\Liga;

use Lmo\Liga\LigaDatei;
use Lmo\Liga\Normalform;
use Lmo\Liga\Rohdaten\Liga;
use PHPUnit\Framework\TestCase;

/**
 * Normalform ergaenzt die Rohdaten zu der vollstaendigen Datei, die der LMO schreibt. Dass dabei
 * dieselbe Datei entsteht wie frueher, halten die Golden-Master-Tests des Adminbereichs fest.
 */
class NormalformTest extends TestCase
{
    /** @param list<string> $zeilen */
    private static function liga(array $zeilen): Liga
    {
        return Liga::ausEintraegen(LigaDatei::zerlege($zeilen));
    }

    /** @return array<string, array{string}> */
    public static function ligadateien(): array
    {
        $wurzel = dirname(__DIR__, 3);
        $dateien = array_merge(
            glob($wurzel . '/lmo/ligen/{*,*/*}.l98', GLOB_BRACE) ?: [],
            glob($wurzel . '/docker/demo/ligen/*.l98') ?: [],
            glob(__DIR__ . '/fixtures/*.l98') ?: [],
            glob(dirname(__DIR__) . '/Tipp/fixtures/*.l98') ?: []
        );
        $faelle = [];
        foreach ($dateien as $datei) {
            $faelle[substr($datei, strlen($wurzel) + 1)] = [$datei];
        }
        // die Testligen der Golden-Master-Tests: Wertungen, Verlaengerung, Handicap, Strafen, Kegeln ...
        $golden = sys_get_temp_dir() . '/lmo-normalform-' . getmypid();
        \Lmo\Tests\GoldenMaster\Support\LeagueFactory::writeAll($wurzel . '/lmo', $golden);
        foreach (glob($golden . '/*.l98') ?: [] as $datei) {
            $faelle['golden/' . basename($datei)] = [$datei];
        }

        return $faelle;
    }

    /** @dataProvider ligadateien */
    public function testNormalformBleibtNormalform(string $pfad): void
    {
        $normal = Normalform::von(Liga::lies($pfad), 'LMO Test', 3, 'd.m.Y');

        self::assertSame($normal->alsText(), Normalform::von($normal, 'LMO Test', 3, 'd.m.Y')->alsText());
    }

    public function testLeereLigaBekommtAllesWasDerLmoSchreibt(): void
    {
        $normal = Normalform::von(self::liga(['[Options]', 'Teams=4', 'Rounds=1', 'Matches=2', '[Teams]', '1=FC O\\\'Neill Nord']), 'LMO', 1, 'd.m.Y');

        self::assertSame('LMO', $normal->optionen['Title']);
        self::assertSame('', $normal->optionen['Name']);
        self::assertSame('', $normal->optionen['namePkt'], 'auch leere Einstellungen stehen in der Datei');
        self::assertSame('d.m.Y', $normal->optionen['DatF']);
        self::assertArrayNotHasKey('KlFin', $normal->optionen, 'Einstellung eines Pokals');
        self::assertCount(4, $normal->mannschaften);
        self::assertSame(["FC O'Neill Nord", "O'Neill", 'FC O\''], [$normal->mannschaften[1]->name, $normal->mannschaften[1]->mittel, $normal->mannschaften[1]->kurz]);
        self::assertSame(['SP' => '0', 'TOR1' => '0', 'TOR2' => '0', 'STDA' => '0', 'URL' => '', 'NOT' => ''], $normal->mannschaften[2]->werte);
        self::assertCount(1, $normal->spieltage);
        self::assertSame(['D1' => '', 'D2' => ''], $normal->spieltage[1]->werte);
        self::assertCount(2, $normal->spieltage[1]->partien);
        self::assertSame(['0', '0'], [$normal->spieltage[1]->partien[2]->heim, $normal->spieltage[1]->partien[2]->gast]);
        self::assertSame([1 => ['GA' => '-1', 'GB' => '-1', 'NT' => '', 'BE' => '', 'TI' => '', 'AT' => '0']], $normal->spieltage[1]->partien[2]->spiele);
    }

    public function testWertungAmGruenenTisch(): void
    {
        $normal = Normalform::von(self::liga(['[Options]', 'Teams=4', 'Rounds=1', 'Matches=2', '[Round1]',
            'TA1=1', 'TB1=2', 'GA1=-2', 'GB1=0', 'TA2=3', 'TB2=4', 'GA2=2', 'GB2=1', 'ET2=3']), 'LMO', 1, 'd.m.Y');

        $erstes = $normal->spieltage[1]->partien[1]->spiele[1];
        $zweites = $normal->spieltage[1]->partien[2]->spiele[1];
        self::assertSame(['-2', '0'], [$erstes['GA'], $erstes['GB']]);
        self::assertArrayNotHasKey('ET', $erstes);
        self::assertSame(['2', '1', '3'], [$zweites['GA'], $zweites['GB'], $zweites['ET']]);
    }

    public function testWasNichtMehrZurLigaGehoertFaelltWeg(): void
    {
        $normal = Normalform::von(self::liga(['[Options]', 'Teams=2', 'Rounds=1', 'Matches=1', '[Teams]', '1=A', '2=B', '3=C',
            '[Team3]', 'NOT=weg', '[Round1]', 'TA1=1', 'TB1=2', 'TA2=3', 'TB2=1', '[Round2]', 'TA1=2', 'TB1=1']), 'LMO', 1, 'd.m.Y');

        self::assertSame([1, 2], array_keys($normal->mannschaften));
        self::assertSame([1], array_keys($normal->spieltage));
        self::assertSame([1], array_keys($normal->spieltage[1]->partien));
    }

    public function testUnbekanntesBleibtErhalten(): void
    {
        $normal = Normalform::von(self::liga(['[Options]', 'Teams=2', 'Rounds=1', 'Matches=1', 'Eigenes=ja', '[Team1]', 'Farbe=blau',
            '[Round1]', 'Wetter=Regen', 'TA1=1', 'TB1=2', 'GA1=1', 'GB1=0', 'ZU1=500', '[Zusatz]', 'x=y']), 'LMO', 1, 'd.m.Y');

        self::assertSame('ja', $normal->optionen['Eigenes']);
        self::assertSame('blau', $normal->mannschaften[1]->werte['Farbe']);
        self::assertSame('Regen', $normal->spieltage[1]->werte['Wetter']);
        self::assertSame('500', $normal->spieltage[1]->partien[1]->spiele[1]['ZU']);
        self::assertSame([['Zusatz', [['x', 'y']]]], $normal->weitereAbschnitte);
        self::assertStringContainsString("ZU1=500\n", $normal->alsText());
    }

    public function testPokalMitHinUndRueckspiel(): void
    {
        $normal = Normalform::von(self::liga(['[Options]', 'Type=1', 'Teams=4', 'KlFin=1', '[Round1]', 'MO=2', 'TA1=1', 'TB1=2',
            'GA11=2', 'GB11=-2', 'SP11=2', 'GA12=', 'GA13=5']), 'LMO', 1, 'd.m.Y');

        self::assertArrayNotHasKey('Rounds', $normal->optionen, 'Einstellung einer Liga');
        self::assertSame([1, 2], array_keys($normal->spieltage));
        self::assertSame('2', $normal->spieltage[1]->werte['MO']);
        self::assertCount(2, $normal->spieltage[1]->partien);
        $paarung = $normal->spieltage[1]->partien[1];
        self::assertSame([1, 2], array_keys($paarung->spiele), 'das dritte Spiel gibt es bei MO=2 nicht');
        self::assertSame(['2', '-2', '2'], [$paarung->spiele[1]['GA'], $paarung->spiele[1]['GB'], $paarung->spiele[1]['SP']], 'im Pokal bleibt -2 stehen');
        self::assertSame('-1', $paarung->spiele[2]['GA'], 'leer heisst nicht gespielt');
        self::assertCount(2, $normal->spieltage[2]->partien, 'Finale und Spiel um Platz 3');
        self::assertSame('1', $normal->spieltage[2]->werte['MO']);
    }
}
