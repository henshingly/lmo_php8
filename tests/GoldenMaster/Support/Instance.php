<?php

namespace Lmo\Tests\GoldenMaster\Support;

use RuntimeException;

/**
 * Isolierte, lauffaehige LMO-Installation in einem Temp-Verzeichnis.
 *
 * Kopiert <Quelle>/lmo, legt die Konfiguration an, die sonst der Installer
 * schreibt, und fixiert alles, was die Ausgabe zeitabhaengig machen wuerde.
 * Dadurch laufen die Tests ohne Webserver und ohne Installationsschritt, und
 * die Quelle (Originalstand oder Refactoring-Stand) bleibt unveraendert.
 */
final class Instance
{
    /** 2025-01-01 12:00:00 UTC: fester Zeitstempel fuer alle Ligadateien ("Stand"-Anzeige) */
    public const FIXED_MTIME = 1735732800;

    /** feste URL, damit erzeugte Links in allen Laeufen gleich sind */
    public const URL = 'http://lmo.test/lmo';

    /** Verzeichnisse der Quelle, die nicht in die Testinstanz kopiert werden */
    private const SKIP = ['tests', '.git', 'output'];

    private string $path;

    private function __construct(string $path)
    {
        $this->path = $path;
    }

    public static function create(string $sourceRoot): self
    {
        $path = self::copySource($sourceRoot);

        // Fertig eingerichtete Installation: Standardkonfiguration + Standardkonto admin/lmo +
        // init-parameters.php. Neuer Stand: Vorlagen in config-default/; der unveraenderte Original-
        // stand (Aufzeichnen der Snapshots) hat sie noch in install/config/ inkl. lmo-auth.php.
        $defaults = is_dir($path . '/config-default') ? $path . '/config-default' : $path . '/install/config';
        if (is_dir($defaults)) {
            self::mergeTree($defaults, $path . '/config');
        }
        if (!is_file($path . '/config/lmo-auth.php')) {
            // gleicher Inhalt wie install/config/lmo-auth.php im Original
            file_put_contents($path . '/config/lmo-auth.php', "<?php exit(); ?>\nadmin|lmo|2|||");
        }
        $cfg = $path . '/config/cfg.txt';
        if (!is_file($cfg)) {
            throw new RuntimeException("config/cfg.txt fehlt auch nach dem Zusammenfuehren mit $defaults.");
        }
        // Abgleich mit config-default/ gilt als erledigt; sonst legte die erste Anfrage den
        // Marker an und jedes Protokoll enthielte diese Dateiaenderung.
        if (is_file($path . '/lmo-setup.php')) {
            if (!function_exists('lmo_defaults_stamp')) {
                require_once $path . '/lmo-setup.php';
            }
            file_put_contents($path . '/config/.defaults-stamp', lmo_defaults_stamp($path . '/config-default'));
        }
        $text = file_get_contents($cfg);
        // Berechnungszeit ("Seite in 0.0123 Sek.") wuerde jede Ausgabe veraendern.
        $text = preg_replace('/^calctime=.*$/m', 'calctime=0', $text);
        file_put_contents($cfg, $text);

        file_put_contents(
            $path . '/config/init-parameters.php',
            "<?php\n\$lmo_dateipfad='" . $path . "';\n\$lmo_url='" . self::URL . "';\n?>"
        );

        // Was frueher der Installer anlegte bzw. als schreibbar pruefte (install/install.php, Liste 777/666):
        // ohne addon/tipp/lmo-tippauth.txt bricht z. B. die Tippspiel-Benutzerverwaltung mit einem Fatal Error ab.
        foreach (['addon/tipp/tipps', 'addon/tipp/tipps/auswert', 'addon/tipp/tipps/einsicht',
            'addon/tipp/tipps/auswert/vereine', 'addon/spieler/stats', 'config/viewer'] as $dir) {
            if (!is_dir($path . '/' . $dir)) {
                mkdir($path . '/' . $dir, 0777, true);
            }
        }
        if (!is_file($path . '/addon/tipp/lmo-tippauth.txt')) {
            file_put_contents($path . '/addon/tipp/lmo-tippauth.txt', '');
        }

        foreach (['output', 'ligen/archiv', '.sessions'] as $dir) {
            if (!is_dir($path . '/' . $dir)) {
                mkdir($path . '/' . $dir, 0777, true);
            }
        }

        $instance = new self($path);
        $instance->freezeLeagueTimes();
        return $instance;
    }

    /**
     * Frisch hochgeladener Stand ohne jede Einrichtung: keine Konfiguration, kein Admin-Konto,
     * keine init-parameters.php. Fuer die Tests der automatischen Ersteinrichtung (lmo-setup.php).
     */
    public static function createUninstalled(string $sourceRoot): self
    {
        $path = self::copySource($sourceRoot);
        mkdir($path . '/.sessions', 0777, true); // nur fuer den Test-Harness (session.save_path)
        return new self($path);
    }

    private static function copySource(string $sourceRoot): string
    {
        $source = rtrim($sourceRoot, '/') . '/lmo';
        if (!is_file($source . '/init.php')) {
            throw new RuntimeException(
                "Keine LMO-Quelle gefunden unter $source (erwartet <Quelle>/lmo/init.php). " .
                'LMO_SOURCE pruefen.'
            );
        }

        $path = sys_get_temp_dir() . '/lmo-golden-' . getmypid() . '-' . bin2hex(random_bytes(3));
        self::copyTree($source, $path, true);
        self::linkVendor(rtrim($sourceRoot, '/') . '/vendor', $path . '/vendor');

        // Laufzeitdateien einer lokalen Installation (z. B. aus dem Web-Container) nicht uebernehmen:
        // Jede Instanz startet mit der Standardkonfiguration und dem Standardkonto admin/lmo.
        self::removeRuntimeFiles($path);
        return $path;
    }

    public function path(): string
    {
        return $this->path;
    }

    public function ligenDir(): string
    {
        return $this->path . '/ligen';
    }

    public function sessionDir(): string
    {
        return $this->path . '/.sessions';
    }

    /** Hier legt bin/sendmail.php die Mails ab, die LMO in dieser Instanz verschickt. */
    public function mailDir(): string
    {
        return $this->path . '/.mails';
    }

    /** Nach dem Anlegen weiterer Ligen aufrufen (Datum "Stand" und Sortierung nach Dateidatum). */
    public function freezeLeagueTimes(): void
    {
        $it = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($this->ligenDir(), \FilesystemIterator::SKIP_DOTS)
        );
        foreach ($it as $file) {
            if ($file->isFile()) {
                touch($file->getPathname(), self::FIXED_MTIME);
            }
        }
    }

    public function destroy(): void
    {
        if (is_dir($this->path)) {
            self::removeTree($this->path);
        }
    }

    private static function removeRuntimeFiles(string $path): void
    {
        $files = [$path . '/config/lmo-auth.php', $path . '/config/init-parameters.php',
            $path . '/config/.defaults-stamp', $path . '/addon/tipp/lmo-tippauth.txt'];
        $files = array_merge($files, glob($path . '/config/cfg.txt') ?: [], glob($path . '/config/*/cfg.txt') ?: []);
        foreach ($files as $file) {
            if (is_file($file)) {
                unlink($file);
            }
        }
    }

    /**
     * Die Composer-Abhaengigkeiten liegen neben lmo/ (bei Nutzern legt lmo-install den Verweis
     * vendor/autoload.php an). Nur der Originalstand bringt noch ein eigenes lmo/vendor mit.
     */
    private static function linkVendor(string $vendor, string $link): void
    {
        if (file_exists($link) || !is_file($vendor . '/autoload.php') || @symlink($vendor, $link)) {
            return;
        }
        mkdir($link);
        file_put_contents($link . '/autoload.php', '<?php return require ' . var_export($vendor . '/autoload.php', true) . ";\n");
    }

    private static function copyTree(string $from, string $to, bool $topLevel = false): void
    {
        mkdir($to, 0777, true);
        foreach (scandir($from) as $name) {
            if ($name === '.' || $name === '..') {
                continue;
            }
            if ($topLevel && in_array($name, self::SKIP, true)) {
                continue;
            }
            $src = $from . '/' . $name;
            $dst = $to . '/' . $name;
            // Composer-Abhaengigkeiten (inkl. PHPUnit) nur verlinken: wird nie beschrieben,
            // und das Kopieren je Testinstanz waere teuer.
            if ($topLevel && $name === 'vendor' && @symlink($src, $dst)) {
                continue;
            }
            if (is_dir($src)) {
                self::copyTree($src, $dst);
            } else {
                copy($src, $dst);
            }
        }
    }

    /** Kopiert Dateien aus $from nach $to, ohne vorhandene zu ueberschreiben. */
    private static function mergeTree(string $from, string $to): void
    {
        if (!is_dir($to)) {
            mkdir($to, 0777, true);
        }
        foreach (scandir($from) as $name) {
            if ($name === '.' || $name === '..') {
                continue;
            }
            $src = $from . '/' . $name;
            $dst = $to . '/' . $name;
            if (is_dir($src)) {
                self::mergeTree($src, $dst);
            } elseif (!file_exists($dst)) {
                copy($src, $dst);
            }
        }
    }

    private static function removeTree(string $dir): void
    {
        foreach (scandir($dir) as $name) {
            if ($name === '.' || $name === '..') {
                continue;
            }
            $p = $dir . '/' . $name;
            is_dir($p) && !is_link($p) ? self::removeTree($p) : @unlink($p);
        }
        @rmdir($dir);
    }
}
