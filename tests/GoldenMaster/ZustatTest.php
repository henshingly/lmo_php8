<?php

namespace Lmo\Tests\GoldenMaster;

use Lmo\Tests\GoldenMaster\Support\AssertsSnapshots;
use Lmo\Tests\GoldenMaster\Support\Fixture;
use Lmo\Tests\GoldenMaster\Support\Transcript;
use PHPUnit\Framework\TestCase;

/**
 * Die Statistikdatei einer Liga (lmo-zustat.php schreibt output/<liga>.l98.php): Sie entsteht bei
 * jedem Speichern im Adminbereich aus dem gerade gespeicherten Stand. Die uebrigen Tests halten
 * nur ihre Groesse fest; hier steht ihr Inhalt.
 */
final class ZustatTest extends TestCase
{
    use AssertsSnapshots;

    /** @return array<string, array{string}> */
    public static function ligen(): array
    {
        return [
            'basic' => ['basic'],
            'wertung' => ['wertung'],   // Wertungen am gruenen Tisch
            'kegel' => ['kegel'],
            'special' => ['special'],
        ];
    }

    /** @dataProvider ligen */
    public function testStatistikdateiNachDemSpeichern(string $liga): void
    {
        $c = Fixture::loggedInClient();
        $datei = $c->instance()->path() . '/output/' . $liga . '.l98.php';
        $t = new Transcript();

        // Spieltag 1 unveraendert speichern
        $c->submitForm('lmoadmin.php', 'action=admin&todo=edit&file=golden/' . $liga . '.l98&st=1', 'xgoala0');
        $t->add('nach dem Speichern von Spieltag 1', is_file($datei) ? (string) file_get_contents($datei) : '(nicht geschrieben)', '');

        // ein Ergebnis aendern: die Datei folgt dem neuen Stand, nicht dem beim Oeffnen gelesenen
        $c->submitForm('lmoadmin.php', 'action=admin&todo=edit&file=golden/' . $liga . '.l98&st=1', 'xgoala0', [
            'xgoala0' => '9', 'xgoalb0' => '0',
        ]);
        $t->add('nach einem 9:0 im ersten Spiel', is_file($datei) ? (string) file_get_contents($datei) : '(nicht geschrieben)', '');

        $this->assertMatchesSnapshot('zustat', $liga, $t->text());
    }
}
