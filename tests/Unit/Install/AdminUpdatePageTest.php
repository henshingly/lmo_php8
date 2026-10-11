<?php

namespace Lmo\Tests\Unit\Install;

use PHPUnit\Framework\TestCase;

/**
 * Die Update-Seite im Admin-Bereich (lmo-adminupdate.php) bei einer neueren Version:
 * Der LMO wird per Composer aktualisiert, nicht mehr per Download.
 */
class AdminUpdatePageTest extends TestCase
{
    /**
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function testNewVersionPointsToComposerInsteadOfADownload(): void
    {
        $html = self::render('4.2.1', '4.3.0');

        self::assertStringContainsString('<code>composer update</code>', $html);
        self::assertStringContainsString('LMO v.4.3.0', $html);
        self::assertStringNotContainsString('Download', $html);
        self::assertStringNotContainsString('.zip', $html);
        self::assertStringContainsString('href="https://example.org/changelog"', $html);
    }

    /**
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function testDevelopmentCheckoutIsNeverOutdated(): void
    {
        self::assertStringNotContainsString('composer update', self::render('dev', '4.3.0'));
    }

    /**
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function testCurrentVersionShowsNoUpdateHint(): void
    {
        $html = self::render('4.2.1', '4.2.1');

        self::assertStringNotContainsString('composer update', $html);
        self::assertStringContainsString('text596', $html);
    }

    private static function render(string $lmo_version, string $new_lmo_version): string
    {
        $lmo = dirname(__DIR__, 3) . '/lmo';
        define('PATH_TO_LMO', $lmo);
        define('LMO_AUTH', 1);
        require_once $lmo . '/lmo-version.php';
        $_SERVER['PHP_SELF'] = '/lmo/lmoadmin.php';
        $action = 'admin';
        $todo = 'update';
        $text = [];
        foreach ([20, 80, 314, 590, 591, 592, 593, 594, 595, 596, 597, 598, 599, 600, 601, 602, 603, 604, 605] as $nr) {
            $text[$nr] = 'text' . $nr;
        }
        $text[314] = 'Download';
        $new_lmo_version_require_php = '>=8.0';
        $new_lmo_version_changelog = 'https://example.org/changelog';
        $new_lmo_version_time = '2026-11-01';
        $lmo_license = 'GPL-2.0-only';

        ob_start();
        require $lmo . '/lmo-adminupdate.php';

        return ob_get_clean();
    }
}
