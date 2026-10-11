<?php

namespace Lmo\Tests\Unit\Install;

use PHPUnit\Framework\TestCase;

/**
 * Der LMO-Ordner liegt im Webserver: Ordner, die nur per include gelesen werden,
 * muessen ihre .htaccess mitbringen. (vendor/ sperrt lmo-install, siehe InstallerTest.)
 */
class WebProtectionTest extends TestCase
{
    /** @return array<string, array{string}> */
    public static function protectedDirs(): array
    {
        return [
            'config' => ['config'],
            'includes' => ['includes'],
            'ligen' => ['ligen'],
        ];
    }

    /** @dataProvider protectedDirs */
    public function testDirectoryDeniesWebAccess(string $dir): void
    {
        $file = dirname(__DIR__, 3) . '/lmo/' . $dir . '/.htaccess';

        self::assertFileExists($file);
        self::assertMatchesRegularExpression('/^\s*(deny from all|require all denied)\s*$/mi', file_get_contents($file));
    }

    /** Die Abhaengigkeiten liegen neben lmo/, nicht darin. */
    public function testDependenciesAreInstalledOutsideTheLmoDir(): void
    {
        $composer = json_decode(file_get_contents(dirname(__DIR__, 3) . '/composer.json'), true);

        self::assertArrayNotHasKey('vendor-dir', $composer['config']);
    }
}
