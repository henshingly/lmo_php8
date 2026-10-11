<?php

namespace Lmo\Tests\Unit\Install;

use Lmo\Install\Installer;
use PHPUnit\Framework\TestCase;

/**
 * Baut ein kleines Projekt nach: vendor/lmo/lmo_php8/lmo als Paket, public/lmo als Ziel.
 */
class InstallerTest extends TestCase
{
    private string $project;
    private string $source;
    private string $target;

    protected function setUp(): void
    {
        $this->project = str_replace('\\', '/', sys_get_temp_dir()) . '/lmo-install-' . getmypid() . '-' . bin2hex(random_bytes(3));
        $this->source = $this->project . '/vendor/lmo/lmo_php8/lmo';
        $this->target = $this->project . '/public/lmo';
        $this->write($this->project . '/vendor/autoload.php', "<?php return 'geladen';\n");
        foreach ([
            'init.php' => '<?php // v1',
            'lmo.php' => '<?php // v1',
            '.htaccess' => 'paket',
            'addon/tipp/lmo-tipp.php' => '<?php // v1',
            'addon/tipp/tipps/.dummy' => '',
            'config/.htaccess' => 'Deny from all',
            'ligen/beispiel.l98' => 'paket',
            'vendor/pear/pear.php' => '<?php',
        ] as $file => $content) {
            $this->write($this->source . '/' . $file, $content);
        }
    }

    protected function tearDown(): void
    {
        self::removeTree($this->project);
    }

    public function testCopiesLmoIntoEmptyTarget(): void
    {
        $stats = $this->installer()->install($this->target);

        self::assertFileEquals($this->source . '/init.php', $this->target . '/init.php');
        self::assertFileExists($this->target . '/addon/tipp/lmo-tipp.php');
        self::assertFileExists($this->target . '/ligen/beispiel.l98');
        self::assertSame(['copied' => 7, 'kept' => 0, 'removed' => 0], $stats);
    }

    public function testDependenciesStayOutsideTheWebDir(): void
    {
        $this->installer()->install($this->target);

        self::assertFileDoesNotExist($this->target . '/vendor/pear/pear.php');
        self::assertStringContainsString('Require all denied', file_get_contents($this->target . '/vendor/.htaccess'));
        self::assertStringContainsString("__DIR__ . '/../../../vendor/autoload.php'", file_get_contents($this->target . '/vendor/autoload.php'));
        self::assertSame('geladen', require $this->target . '/vendor/autoload.php');
    }

    public function testUpdateOverwritesCodeButKeepsUserData(): void
    {
        $this->installer()->install($this->target);
        $this->write($this->target . '/ligen/beispiel.l98', 'vom nutzer geaendert');
        $this->write($this->target . '/ligen/eigene.l98', 'eigene liga');
        $this->write($this->target . '/config/cfg.txt', 'einstellungen');
        $this->write($this->target . '/.htaccess', 'angepasst');
        $this->write($this->source . '/init.php', '<?php // v2');
        $this->write($this->source . '/ligen/neu.l98', 'neu im paket');

        $stats = $this->installer()->install($this->target);

        self::assertSame('<?php // v2', file_get_contents($this->target . '/init.php'));
        self::assertSame('vom nutzer geaendert', file_get_contents($this->target . '/ligen/beispiel.l98'));
        self::assertSame('eigene liga', file_get_contents($this->target . '/ligen/eigene.l98'));
        self::assertSame('einstellungen', file_get_contents($this->target . '/config/cfg.txt'));
        self::assertSame('angepasst', file_get_contents($this->target . '/.htaccess'));
        self::assertSame('neu im paket', file_get_contents($this->target . '/ligen/neu.l98'));
        self::assertSame(4, $stats['kept']);
    }

    public function testUpdateRemovesCodeThatLeftThePackage(): void
    {
        $this->installer()->install($this->target);
        $this->write($this->target . '/eigene-seite.php', '<?php // vom nutzer');
        unlink($this->source . '/addon/tipp/lmo-tipp.php');
        unlink($this->source . '/ligen/beispiel.l98');

        $stats = $this->installer()->install($this->target);

        self::assertFileDoesNotExist($this->target . '/addon/tipp/lmo-tipp.php');
        self::assertFileExists($this->target . '/eigene-seite.php', 'nur selbst kopierte Dateien entfernen');
        self::assertFileExists($this->target . '/ligen/beispiel.l98', 'Daten nie entfernen');
        self::assertFileExists($this->target . '/addon/tipp/tipps/.dummy');
        self::assertSame(1, $stats['removed']);
    }

    public function testRefusesForeignNonEmptyTarget(): void
    {
        $this->write($this->project . '/public/index.html', 'andere seite');

        $this->expectException(\RuntimeException::class);
        $this->installer()->install($this->project . '/public');
    }

    public function testRefusesTargetInsidePackage(): void
    {
        $this->expectException(\RuntimeException::class);
        $this->installer()->install($this->source . '/output');
    }

    public function testRegistersScriptsWithoutTouchingTheRest(): void
    {
        $file = $this->project . '/composer.json';
        $this->write($file, '{"require": {"lmo/lmo_php8": "^4.2"}, "require-dev": {}, "scripts": {"post-update-cmd": "echo fertig", "test": "phpunit"}}');

        self::assertTrue(Installer::registerScripts($file, 'public/lmo'));

        $raw = file_get_contents($file);
        $data = json_decode($raw, true);
        self::assertSame(['lmo-install public/lmo'], $data['scripts']['post-install-cmd']);
        self::assertSame(['echo fertig', 'lmo-install public/lmo'], $data['scripts']['post-update-cmd']);
        self::assertSame('phpunit', $data['scripts']['test']);
        self::assertStringContainsString('"require-dev": {}', $raw, 'leere Objekte duerfen nicht zu [] werden');
        self::assertSame('public/lmo', Installer::registeredTarget($file));
    }

    public function testRegisteringAgainChangesOnlyTheTarget(): void
    {
        $file = $this->project . '/composer.json';
        $this->write($file, '{}');
        Installer::registerScripts($file, 'public/lmo');

        self::assertFalse(Installer::registerScripts($file, 'public/lmo'));
        self::assertTrue(Installer::registerScripts($file, 'web/liga manager'));

        $data = json_decode(file_get_contents($file), true);
        self::assertSame(['lmo-install "web/liga manager"'], $data['scripts']['post-update-cmd']);
        self::assertSame('web/liga manager', Installer::registeredTarget($file));
    }

    public function testRunInstallsAndRemembersTheTarget(): void
    {
        $this->write($this->project . '/composer.json', '{}');
        $out = fopen('php://memory', 'w+');

        self::assertSame(0, $this->runCommand(['public/lmo'], $out));
        $this->write($this->source . '/init.php', '<?php // v2');
        // so ruft Composer den Abgleich nach einem Update auf: mit dem gemerkten Ziel
        self::assertSame(0, $this->runCommand([Installer::registeredTarget($this->project . '/composer.json')], $out));
        // und ohne Argument findet der Befehl das Ziel selbst
        self::assertSame(0, $this->runCommand([], $out));

        self::assertSame('<?php // v2', file_get_contents($this->target . '/init.php'));
        rewind($out);
        self::assertStringContainsString('composer.json', stream_get_contents($out));
    }

    public function testRunWithoutTargetInstallsIntoLmoDir(): void
    {
        $this->write($this->project . '/composer.json', '{}');
        $out = fopen('php://memory', 'w+');

        self::assertSame(0, $this->runCommand([], $out));

        self::assertFileExists($this->project . '/lmo/init.php');
        self::assertSame('lmo', Installer::registeredTarget($this->project . '/composer.json'));
        self::assertSame('geladen', require $this->project . '/lmo/vendor/autoload.php');
    }

    public function testRunWithUnknownOptionExplainsUsage(): void
    {
        $out = fopen('php://memory', 'w+');

        self::assertSame(1, $this->runCommand(['--help'], $out));

        rewind($out);
        self::assertStringContainsString('lmo-install [', stream_get_contents($out));
        self::assertDirectoryDoesNotExist($this->project . '/lmo');
    }

    /** Mit dem LMO direkt im Projektordner liegt vendor/ oft im Webserver-Ordner. */
    public function testProtectsTheProjectVendorDir(): void
    {
        $this->installer()->install($this->target);
        self::assertStringContainsString('Require all denied', file_get_contents($this->project . '/vendor/.htaccess'));

        $this->write($this->project . '/vendor/.htaccess', 'eigene regel');
        $this->installer()->install($this->target);
        self::assertSame('eigene regel', file_get_contents($this->project . '/vendor/.htaccess'));
    }

    public function testRunReportsErrorsInsteadOfThrowing(): void
    {
        $this->write($this->project . '/public/index.html', 'andere seite');
        $out = fopen('php://memory', 'w+');

        self::assertSame(1, $this->runCommand(['public'], $out));
        self::assertFileDoesNotExist($this->project . '/public/init.php');
    }

    /** Das Paket muss alles mitbringen, was der Befehl braucht. */
    public function testPackageShipsTheCommand(): void
    {
        $root = dirname(__DIR__, 3);
        $composer = json_decode(file_get_contents($root . '/composer.json'), true);

        self::assertSame(['bin/lmo-install'], $composer['bin']);
        self::assertFileExists($root . '/bin/lmo-install');
        foreach (Installer::KEEP as $keep) {
            self::assertFileExists($root . '/lmo/' . $keep);
        }
    }

    private function installer(): Installer
    {
        return new Installer($this->source, $this->project . '/vendor');
    }

    /**
     * @param string[] $args
     * @param resource $out
     */
    private function runCommand(array $args, $out): int
    {
        return Installer::run($args, $this->source, $this->project . '/vendor', $this->project, $out);
    }

    private function write(string $file, string $content): void
    {
        if (!is_dir(dirname($file))) {
            mkdir(dirname($file), 0777, true);
        }
        file_put_contents($file, $content);
    }

    private static function removeTree(string $dir): void
    {
        foreach (array_diff(scandir($dir), ['.', '..']) as $name) {
            $path = $dir . '/' . $name;
            is_dir($path) ? self::removeTree($path) : unlink($path);
        }
        rmdir($dir);
    }
}
