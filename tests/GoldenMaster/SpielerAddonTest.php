<?php

namespace Lmo\Tests\GoldenMaster;

use Lmo\Tests\GoldenMaster\Support\AdminClient;
use Lmo\Tests\GoldenMaster\Support\Fixture;
use PHPUnit\Framework\TestCase;

/**
 * Addon "spieler" (Spielerstatistik): Der Admin legt Spieler und Spalten an und traegt Werte ein
 * (lmo-statadmin.php, gespeichert in addon/spieler/stats/<liga>.stat), die Ligaseite zeigt sie
 * unter action=spieler (lmo-statshow.php).
 *
 * Die Tests bauen aufeinander auf und laufen in dieser Reihenfolge auf einer eigenen Testinstanz.
 */
final class SpielerAddonTest extends TestCase
{
    private const LIGA = 'golden/basic.l98';

    private static AdminClient $client;

    public static function setUpBeforeClass(): void
    {
        self::$client = Fixture::loggedInClient();

        // Spielerstatistik fuer die Liga einschalten (Option "mittore")
        $path = self::$client->instance()->ligenDir() . '/' . self::LIGA;
        $content = str_replace("\r\n", "\n", (string)file_get_contents($path));
        $content = preg_replace('/^mittore=.*$/m', 'mittore=1', $content, 1, $count);
        if ($count === 0) {
            $content = preg_replace('/^\[Options\]\n/m', "[Options]\nmittore=1\n", $content, 1);
        }
        file_put_contents($path, $content);
    }

    /** Aufruf der Spielerstatistik im Admin-Bereich, optional mit einer Aktion. */
    private static function admin(array $params = [], ?AdminClient $client = null): string
    {
        return ($client ?? self::$client)->post('lmoadmin.php', '', ['action' => 'admin', 'todo' => 'edit', 'file' => self::LIGA, 'st' => '-4'] + $params);
    }

    private static function statFile(?AdminClient $client = null): string
    {
        return ($client ?? self::$client)->instance()->path() . '/addon/spieler/stats/basic.stat';
    }

    /** @return string[][] Zeilen der Statistikdatei, Spalten an "#" getrennt */
    private static function rows(): array
    {
        $lines = array_filter(explode("\n", str_replace("\r", '', (string)file_get_contents(self::statFile()))), static fn (string $line): bool => $line !== '');
        return array_map(static fn (string $line): array => explode('#', $line), array_values($lines));
    }

    /** @return array<string,string[]> Spielername => Werte der uebrigen Spalten (ohne Kopf- und Formelzeile) */
    private static function players(int $headerRows = 1): array
    {
        $players = [];
        foreach (array_slice(self::rows(), $headerRows) as $row) {
            $players[$row[0]] = array_slice($row, 1);
        }
        return $players;
    }

    /** Traegt Werte ein; Zeilennummern wie in der Datei. @param array<string,array<int,string|int>> $values Spieler => Spalte => Wert */
    private static function update(array $values, int $headerRows = 1, array $more = []): string
    {
        $post = ['option' => 'statupdate'] + $more;
        foreach (array_keys(self::players($headerRows)) as $line => $name) {
            foreach ($values[$name] ?? [] as $column => $value) {
                $post["data$line|$column"] = (string)$value;
            }
        }
        return self::admin($post);
    }

    private static function publicPage(string $query = ''): string
    {
        return self::$client->get('lmo.php', 'file=' . self::LIGA . '&action=spieler' . $query);
    }

    /** Druckansicht, direkt aufgerufen. */
    private static function printPage(string $query): string
    {
        return self::$client->get('addon/spieler/lmo-statprint.php', $query);
    }

    /** @return string[] Spielernamen in der Reihenfolge der Seite */
    private static function namesOnPage(string $html): array
    {
        preg_match_all('/\b(Müller|Ahrens|Zander)\b/u', $html, $m);
        return array_values(array_unique($m[1]));
    }

    public function testAdminPageCreatesEmptyStatistics(): void
    {
        self::assertFileDoesNotExist(self::statFile());

        $html = self::admin();

        self::assertStringNotContainsString('STDERR', $html, 'PHP-Meldungen');
        self::assertSame([['Name']], self::rows());
    }

    public function testAdminAddsPlayersAndColumns(): void
    {
        $html = self::admin(['option' => 'addplayer', 'wert' => 'Müller'])
            . self::admin(['option' => 'addplayer', 'wert' => 'Ahrens'])
            . self::admin(['option' => 'addcolumn', 'wert' => 'Tore', 'type' => '0'])
            . self::admin(['option' => 'addcolumn', 'wert' => 'Spiele', 'type' => '0']);

        self::assertStringNotContainsString('STDERR', $html, 'PHP-Meldungen');
        self::assertSame(['Name', 'Tore', 'Spiele'], self::rows()[0]);
        $players = self::players();
        ksort($players);
        self::assertSame(['Ahrens' => ['0', '0'], 'Müller' => ['0', '0']], $players);
    }

    public function testAdminEntersValues(): void
    {
        $html = self::update(['Müller' => [1 => 5, 2 => 10], 'Ahrens' => [1 => 3, 2 => 4]]);

        self::assertStringNotContainsString('STDERR', $html, 'PHP-Meldungen');
        $players = self::players();
        self::assertSame(['5', '10'], $players['Müller']);
        self::assertSame(['3', '4'], $players['Ahrens']);
    }

    public function testPublicPageShowsStatisticsSortedByColumn(): void
    {
        $html = self::publicPage();
        self::assertStringNotContainsString('STDERR', $html, 'PHP-Meldungen');
        self::assertStringContainsString('Müller', $html);
        self::assertStringContainsString('Ahrens', $html);

        // nach Toren (Spalte 1) in beiden Richtungen
        $one = self::namesOnPage(self::publicPage('&sort=1&direction=1'));
        $two = self::namesOnPage(self::publicPage('&sort=1&direction=0'));
        self::assertEqualsCanonicalizing(['Müller', 'Ahrens'], $one);
        self::assertSame(array_reverse($one), $two, 'umgekehrte Richtung dreht die Reihenfolge');
    }

    public static function oddParameters(): array
    {
        return [
            'unbekannte Spalte' => ['&sort=99'],
            'Spalte ist keine Zahl' => ['&sort=abc'],
            'Seitenanfang ist keine Zahl' => ['&begin=abc'],
            'Seitenanfang hinter dem Ende' => ['&begin=500'],
            'Richtung ist keine Zahl' => ['&direction=abc'],
            'unbekannte Mannschaft' => ['&team=Niemand'],
        ];
    }

    /** @dataProvider oddParameters */
    public function testPublicPageToleratesOddParameters(string $query): void
    {
        $html = self::publicPage($query);

        self::assertStringNotContainsString('STDERR', $html, 'PHP-Meldungen');
        self::assertStringContainsString('lmoFooter', $html, 'Seite wird vollstaendig ausgegeben');
    }

    /** @dataProvider oddParameters */
    public function testPrintPageToleratesOddParameters(string $query): void
    {
        $html = self::printPage('file=' . self::LIGA . $query);

        self::assertStringNotContainsString('STDERR', $html, 'PHP-Meldungen');
        self::assertStringContainsString('</html>', $html, 'Seite wird vollstaendig ausgegeben');
    }

    public function testParametersAreNotReflectedIntoThePage(): void
    {
        $attack = '&sort=' . urlencode('1"><script>alert(1)</script>') . '&direction=' . urlencode('1"><script>alert(2)</script>')
            . '&begin=' . urlencode('0"><script>alert(3)</script>') . '&team=' . urlencode('"><script>alert(4)</script>');

        $html = self::publicPage($attack) . self::printPage('file=' . self::LIGA . $attack);

        self::assertStringNotContainsString('<script>alert(', $html);
    }

    public function testPrintPageShowsStatistics(): void
    {
        $html = self::printPage('file=' . self::LIGA . '&sort=1&direction=1');

        self::assertStringNotContainsString('STDERR', $html, 'PHP-Meldungen');
        self::assertSame(['Müller', 'Ahrens'], self::namesOnPage($html), 'absteigend nach Toren');
    }

    public function testPrintPageWithoutStatistics(): void
    {
        $html = self::printPage('file=golden/gibtesnicht.l98');

        self::assertStringNotContainsString('STDERR', $html, 'PHP-Meldungen');
    }

    public function testFormulaColumnIsCalculated(): void
    {
        $html = self::admin(['option' => 'addcolumn', 'wert' => 'Quote', 'type' => 'F'])
            . self::admin(['option' => 'addplayer', 'wert' => 'Zander']);
        $html .= self::update([], 2, ['formel_str3' => 'Tore/Spiele']);

        self::assertStringNotContainsString('STDERR', $html, 'PHP-Meldungen');
        self::assertSame(['Name', 'Tore', 'Spiele', 'Quote*_*-*'], self::rows()[0]);
        $players = self::players(2);
        self::assertEquals(0.5, $players['Müller'][2]);
        self::assertEquals(0.75, $players['Ahrens'][2]);
        // Zander hat 0 Spiele: Division durch 0 ergibt 0, kein Abbruch
        self::assertEquals(0, $players['Zander'][2]);
    }

    public function testFormulaWithOtherTextIsNotExecuted(): void
    {
        $marker = self::$client->instance()->path() . '/addon/spieler/stats/eingeschleust.txt';

        $html = self::update([], 2, ['formel_str3' => "file_put_contents('$marker', 'x')"]);

        self::assertFileDoesNotExist($marker, 'Formel darf keinen PHP-Code ausfuehren');
        self::assertStringNotContainsString('STDERR', $html, 'PHP-Meldungen');
        self::assertNotEquals(0.5, self::players(2)['Müller'][2], 'ungueltige Formel liefert keinen Zahlenwert');
    }

    public function testIncompleteFormulaDoesNotBreakThePage(): void
    {
        $html = self::update([], 2, ['formel_str3' => 'Tore/']);

        self::assertStringNotContainsString('STDERR', $html, 'PHP-Meldungen');
        self::assertStringContainsString('formel_str3', $html, 'Formular wird weiter angezeigt');
        self::assertCount(3, self::players(2), 'Spieler bleiben erhalten');
    }

    public function testAdminDeletesPlayerAndColumn(): void
    {
        self::update([], 2, ['formel_str3' => 'Tore/Spiele']);
        $line = array_search('Zander', array_keys(self::players(2)), true);

        $html = self::admin(['option' => 'delplayer', 'wert' => (string)$line])
            . self::admin(['option' => 'delcolumn', 'wert' => '3']);

        self::assertStringNotContainsString('STDERR', $html, 'PHP-Meldungen');
        self::assertSame(['Name', 'Tore', 'Spiele'], self::rows()[0]);
        $players = self::players();
        ksort($players);
        self::assertSame(['Ahrens' => ['3', '4'], 'Müller' => ['5', '10']], $players);
    }

    public function testDeletingUnknownColumnChangesNothing(): void
    {
        $before = self::rows();

        $html = self::admin(['option' => 'delcolumn', 'wert' => '9']);

        self::assertStringNotContainsString('STDERR', $html, 'PHP-Meldungen');
        self::assertSame($before, self::rows());
    }

    public function testStatisticsCannotBeChangedWithoutLogin(): void
    {
        $anonymous = Fixture::anonymousClient();

        self::admin(['option' => 'addplayer', 'wert' => 'Eindringling'], $anonymous);

        self::assertFileDoesNotExist(self::statFile($anonymous), 'ohne Anmeldung wird keine Statistik angelegt');
    }
}
