<?php

namespace Lmo\Tests\Unit\Install;

use PHPUnit\Framework\TestCase;

/**
 * lmo/version.json liefert dem LMO zur Laufzeit Lizenz und PHP-Mindestversion (lmo-functions.php).
 * Die Version selbst steht nirgends in einer Datei: Sie kommt aus dem Git-Tag des Pakets.
 */
class VersionFileTest extends TestCase
{
    public function testVersionFileAgreesWithComposerJson(): void
    {
        $version = self::json('lmo/version.json');
        $composer = self::json('composer.json');

        self::assertSame($composer['require']['php'], $version['require']['php']);
        self::assertSame($composer['license'], $version['license']);
    }

    public function testVersionIsNotMaintainedByHand(): void
    {
        self::assertArrayNotHasKey('version', self::json('lmo/version.json'));
        self::assertArrayNotHasKey('version', self::json('composer.json'), 'die Version kommt bei Composer aus dem Git-Tag');
    }

    public function testThereIsOnlyOneComposerJson(): void
    {
        self::assertFileDoesNotExist(dirname(__DIR__, 3) . '/lmo/composer.json');
    }

    /** Die Seiten fuer Besucher duerfen keine fremden Server abfragen. */
    public function testOnlyTheAdminAreaAsksForUpdates(): void
    {
        $root = dirname(__DIR__, 3) . '/lmo';

        self::assertStringNotContainsString('lmo_update_info(', file_get_contents($root . '/lmo-functions.php'));
        self::assertStringNotContainsString('check_version.json', file_get_contents($root . '/lmo-functions.php'));
        self::assertStringContainsString('lmo_update_info(', file_get_contents($root . '/lmo-adminmain.php'));
    }

    /** @return array<string, mixed> */
    private static function json(string $file): array
    {
        return json_decode(file_get_contents(dirname(__DIR__, 3) . '/' . $file), true, 8, JSON_THROW_ON_ERROR);
    }
}
