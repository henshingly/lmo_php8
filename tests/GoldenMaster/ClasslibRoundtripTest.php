<?php

namespace Lmo\Tests\GoldenMaster;

use Lmo\Tests\GoldenMaster\Support\Fixture;
use Lmo\Tests\GoldenMaster\Support\Matrix;
use PHPUnit\Framework\TestCase;

/**
 * Die classlib muss jedes Feld erhalten, das die Oberflaeche speichert: Jede Liga wird erst von
 * LMO selbst gespeichert (lmo-savefile.php), dann mit liga::loadFile() geladen und mit
 * liga::writeFile() gespeichert. Kein Schluessel darf verloren gehen oder sich aendern.
 *
 * Gearbeitet wird auf Kopien in ligen/roundtrip/, die anderen Tests sehen die Ligen unveraendert.
 */
final class ClasslibRoundtripTest extends TestCase
{
    private const DIR = 'roundtrip';
    private const PREFIX = 'rt-';

    /** Pokal (KO-Modus): Halbfinale mit Hin- und Rueckspiel, Finale; Format bringt LMO selbst in Ordnung */
    private const POKAL = <<<'L98'
[Options]
Title=Liga Manager Online 4
Name=Pokal
Type=1
Teams=4
Rounds=2
Matches=2
Actual=2
KlFin=0
DatF=d.m.Y H:i

[Teams]
1=Rot
2=Blau
3=Gruen
4=Gelb

[Teamk]
1=ROT
2=BLA
3=GRU
4=GEL

[Round1]
D1=01.10.2024
D2=08.10.2024
MO=2
TA1=1
TB1=2
GA11=2
GB11=1
SP11=0
NT11=Hinspiel
BE11=
TI11=
AT11=1727802000
GA12=1
GB12=1
SP12=0
NT12=
BE12=
TI12=
AT12=1728406800
TA2=3
TB2=4
GA21=0
GB21=0
SP21=0
NT21=
BE21=
TI21=
AT21=1727802000
GA22=1
GB22=2
SP22=2
NT22=n.V.
BE22=http://bericht.example
TI22=
AT22=1728406800

[Round2]
D1=15.10.2024
D2=15.10.2024
MO=1
TA1=1
TB1=4
GA11=3
GB11=1
SP11=0
NT11=Finale
BE11=
TI11=
AT11=1729011600

L98;

    /** @var array<string,array|null> Ligadatei => verlorene, neue und geaenderte Schluessel */
    private static array $results = [];

    public static function setUpBeforeClass(): void
    {
        $ligen = Fixture::get()->app()->ligenDir();
        @mkdir($ligen . '/' . self::DIR);
        $files = [];
        foreach (array_keys(self::leagues()) as $league) {
            // eigener Dateiname: LMO benennt Ausgabedateien (Torstatistik, HTML-Export) nur nach dem
            // Dateinamen ohne Ordner, gleichnamige Ligen wuerden die der anderen Tests ueberschreiben
            $copy = self::DIR . '/' . self::PREFIX . basename($league);
            if ($league === 'pokal') {
                $copy = self::DIR . '/' . self::PREFIX . 'pokal.l98';
                file_put_contents($ligen . '/' . $copy, self::POKAL);
            } else {
                copy($ligen . '/' . $league, $ligen . '/' . $copy);
            }
            $files[$league] = $copy;
        }
        $output = Fixture::get()->runner()->classlibRoundtrip(array_values($files));
        self::assertStringNotContainsString('<!--', $output, 'PHP-Meldungen oder Abbruch: ' . $output);
        $byCopy = json_decode($output, true) ?? [];
        foreach ($files as $league => $copy) {
            self::$results[$league] = $byCopy[$copy] ?? null;
        }
    }

    public static function tearDownAfterClass(): void
    {
        $dir = Fixture::get()->app()->ligenDir() . '/' . self::DIR;
        // Ligadateien und die beim Speichern erzeugten Ausgabedateien (output/rt-...)
        $files = array_merge(glob($dir . '/*') ?: [], glob(Fixture::get()->app()->path() . '/output/' . self::PREFIX . '*') ?: []);
        foreach ($files as $file) {
            unlink($file);
        }
        if (is_dir($dir)) {
            rmdir($dir);
        }
    }

    public static function leagues(): array
    {
        $cases = [];
        foreach (array_keys(Matrix::leagues(Fixture::sourceRoot())) as $file) {
            $cases[$file] = [$file];
        }
        $cases['pokal'] = ['pokal'];
        return $cases;
    }

    /** @dataProvider leagues */
    public function testClasslibKeepsEveryFieldOfTheLeagueFile(string $league): void
    {
        $result = self::$results[$league];
        self::assertNotNull($result, 'kein Ergebnis');

        self::assertSame([], $result['verloren'], 'Schluessel gehen verloren');
        self::assertSame([], $result['geaendert'], 'Werte aendern sich');
    }
}
