<?php

namespace Lmo\Tests\Unit\Install;

use PHPUnit\Framework\TestCase;

/**
 * lmo-version.php: installierte Version laut Composer, neueste Version laut Packagist.
 */
class LmoVersionTest extends TestCase
{
    private string $cache;

    public static function setUpBeforeClass(): void
    {
        require_once dirname(__DIR__, 3) . '/lmo/lmo-version.php';
    }

    protected function setUp(): void
    {
        $this->cache = sys_get_temp_dir() . '/lmo-update-' . getmypid() . '-' . bin2hex(random_bytes(3)) . '.json';
    }

    protected function tearDown(): void
    {
        if (is_file($this->cache)) {
            unlink($this->cache);
        }
    }

    /** @return array<string, array{?string, string}> */
    public static function prettyVersions(): array
    {
        return [
            'Tag mit v' => ['v4.2.1', '4.2.1'],
            'Tag ohne v' => ['4.3.0', '4.3.0'],
            'Vorabversion' => ['4.3.0-beta1', '4.3.0-beta1'],
            'Branch' => ['dev-master', 'dev'],
            'Branch-Alias' => ['4.2.x-dev', 'dev'],
            'Checkout ohne Tag' => ['1.0.0+no-version-set', 'dev'],
            'unbekannt' => [null, 'dev'],
        ];
    }

    /** @dataProvider prettyVersions */
    public function testNormalizeVersion(?string $pretty, string $expected): void
    {
        self::assertSame($expected, lmo_normalize_version($pretty));
    }

    /** Im Repo selbst ist kein Tag installiert: Die Anzeige haengt dann nicht vom Branch ab. */
    public function testInstalledVersionInTheRepoIsDev(): void
    {
        self::assertSame('dev', lmo_installed_version());
    }

    public function testLatestReleaseReadsThePackagistList(): void
    {
        $latest = lmo_latest_release(self::packagist());

        self::assertSame([
            'version' => '4.3.0',
            'time' => '2026-11-01',
            'php' => '>=8.1',
            'changelog' => 'https://github.com/tombrain/lmo_php8/blob/v4.3.0/changelog.md',
        ], $latest);
    }

    public function testLatestReleaseOfAnUnknownPackageIsNull(): void
    {
        self::assertNull(lmo_latest_release(['packages' => []]));
        self::assertNull(lmo_latest_release(null));
    }

    public function testIsNewer(): void
    {
        self::assertTrue(lmo_is_newer('4.10.0', '4.9.0'), 'Zahlen vergleichen, nicht Zeichen');
        self::assertFalse(lmo_is_newer('4.2.1', '4.2.1'));
        self::assertFalse(lmo_is_newer('4.2.0', '4.2.1'));
        self::assertFalse(lmo_is_newer('4.3.0', 'dev'), 'ein Entwicklungsstand gilt nie als veraltet');
        self::assertFalse(lmo_is_newer(null, '4.2.1'));
    }

    public function testUpdateInfoAsksOnceADay(): void
    {
        $calls = 0;
        $fetch = static function (string $url) use (&$calls) {
            $calls++;
            self::assertSame('https://repo.packagist.org/p2/lmo/lmo_php8.json', $url);

            return json_encode(self::packagist());
        };

        $first = lmo_update_info($this->cache, false, 86400, $fetch, 1000);
        $second = lmo_update_info($this->cache, false, 86400, $fetch, 1000 + 86399);
        self::assertSame('4.3.0', $first['version']);
        self::assertSame($first, $second);
        self::assertSame(1, $calls);

        lmo_update_info($this->cache, false, 86400, $fetch, 1000 + 86400);
        self::assertSame(2, $calls, 'nach einem Tag neu fragen');

        lmo_update_info($this->cache, true, 86400, $fetch, 1000 + 86401);
        self::assertSame(3, $calls, 'die Update-Seite fragt immer frisch');
    }

    public function testUpdateInfoRemembersFailuresToo(): void
    {
        $calls = 0;
        $offline = static function () use (&$calls) {
            $calls++;

            return false;
        };

        self::assertNull(lmo_update_info($this->cache, false, 86400, $offline, 1000));
        self::assertNull(lmo_update_info($this->cache, false, 86400, $offline, 2000));
        self::assertSame(1, $calls, 'ein nicht erreichbarer Server darf nicht jede Admin-Seite bremsen');
    }

    public function testUpdateInfoKeepsTheLastKnownReleaseWhenOffline(): void
    {
        lmo_update_info($this->cache, false, 86400, static fn () => json_encode(self::packagist()), 1000);

        $latest = lmo_update_info($this->cache, true, 86400, static fn () => false, 2000);

        self::assertSame('4.3.0', $latest['version']);
    }

    /**
     * Verkuerzte Liste wie von Packagist: neueste Version zuerst, danach nur die Unterschiede.
     *
     * @return array<string, mixed>
     */
    private static function packagist(): array
    {
        return ['minified' => 'composer/2.0', 'packages' => ['lmo/lmo_php8' => [
            [
                'name' => 'lmo/lmo_php8',
                'version' => 'v4.4.0-beta1',
                'time' => '2026-12-01T10:00:00+00:00',
                'require' => ['php' => '>=8.1'],
                'source' => ['type' => 'git', 'url' => 'https://github.com/tombrain/lmo_php8.git', 'reference' => 'abc'],
            ],
            ['version' => 'v4.3.0', 'time' => '2026-11-01T10:00:00+00:00'],
            ['version' => 'v4.2.2', 'time' => '2026-10-20T10:00:00+00:00', 'require' => ['php' => '>=8.0']],
            ['version' => 'v4.10.0-RC1', 'time' => '2026-10-01T10:00:00+00:00', 'source' => '__unset'],
        ]]];
    }
}
