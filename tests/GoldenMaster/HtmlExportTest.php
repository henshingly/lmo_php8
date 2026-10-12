<?php

namespace Lmo\Tests\GoldenMaster;

use Lmo\Tests\GoldenMaster\Support\AssertsSnapshots;
use Lmo\Tests\GoldenMaster\Support\Fixture;
use PHPUnit\Framework\TestCase;

/**
 * HTML-Ausgabe zum Drucken (einsavehtml=1): Beim Anzeigen von Ergebnissen oder Tabelle einer Liga
 * schreibt der LMO zwei Dateien in den Ausgabeordner, <liga>-st.html (Spieltag und Tabelle,
 * lmo-savehtml.php) und <liga>-sp.html (Spielplan, lmo-savehtml1.php). Die Seiten-Snapshots zeigen
 * nur den Link darauf; hier wird der Inhalt der Dateien festgehalten.
 */
final class HtmlExportTest extends TestCase
{
    use AssertsSnapshots;

    /** @return array<string, array{string, string}> Name => [Ligadatei, Aufrufparameter] */
    public static function aufrufe(): array
    {
        return [
            'basic_tabelle' => ['golden/basic.l98', 'action=table'],
            'basic_spieltag3' => ['golden/basic.l98', 'action=results&st=3'],
            'wertung_spieltag2' => ['golden/wertung.l98', 'action=results&st=2'],
            'special_tabelle' => ['golden/special.l98', 'action=table'],
            'penalties_spieltag9' => ['golden/penalties.l98', 'action=table&st=9'],
            'minus2_direct_tabelle' => ['golden/minus2_direct.l98', 'action=table'],
            'kegel_tabelle' => ['golden/kegel.l98', 'action=table'],
            'bundesliga_spieltag26' => ['1l_2024-25.l98', 'action=results&st=26'],
            'bundesliga_letzter_spieltag' => ['1l_2024-25.l98', 'action=results&st=34'],
        ];
    }

    /**
     * @dataProvider aufrufe
     */
    public function testGeschriebeneDateienSindUnveraendert(string $liga, string $parameter): void
    {
        $client = Fixture::anonymousClient();
        $ausgabe = $client->instance()->path() . '/output/' . basename($liga);
        foreach (['-st.html', '-sp.html'] as $endung) {
            if (is_file($ausgabe . $endung)) {
                unlink($ausgabe . $endung);
            }
        }

        $seite = $client->get('lmo.php', 'file=' . $liga . '&' . $parameter);

        self::assertStringNotContainsString('STDERR', $seite, 'PHP-Meldungen beim Erzeugen');
        $text = '';
        foreach (['-st.html', '-sp.html'] as $endung) {
            $text .= '=== ' . basename($liga) . $endung . " ===\n"
                . (is_file($ausgabe . $endung) ? str_replace("\r\n", "\n", (string) file_get_contents($ausgabe . $endung)) : '(nicht geschrieben)') . "\n";
        }
        $this->assertMatchesSnapshot('html-export', (string) $this->dataName(), $text);
    }
}
