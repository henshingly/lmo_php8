<?php

namespace Lmo\Install;

/**
 * Richtet den LMO aus dem Composer-Paket in einem Ordner des Webservers ein und gleicht ihn
 * nach jedem Update ab (bin/lmo-install).
 *
 * Programmdateien werden ueberschrieben. In den Ordnern aus KEEP liegen die Daten des Nutzers:
 * dort werden nur fehlende Dateien angelegt, nie welche ueberschrieben oder geloescht.
 */
class Installer
{
    /** Datenordner und vom Nutzer anpassbare Dateien, relativ zum LMO-Ordner */
    public const KEEP = ['.htaccess', 'config', 'ligen', 'output', 'addon/tipp/tipps', 'addon/spieler/stats'];

    /** Liste der zuletzt kopierten Programmdateien: damit verschwinden Dateien, die es im Paket nicht mehr gibt */
    public const MANIFEST = 'config/.install-manifest';

    public const SCRIPT = 'lmo-install';

    /** Zielordner, wenn keiner angegeben und keiner gemerkt ist (relativ zum Projektordner) */
    public const DEFAULT_TARGET = 'lmo';

    private const DENY = "<IfModule mod_authz_core.c>\n  Require all denied\n</IfModule>\n"
        . "<IfModule !mod_authz_core.c>\n  Deny from all\n</IfModule>\n";
    private const EVENTS = ['post-install-cmd', 'post-update-cmd'];

    private string $source;
    private string $vendorDir;

    /**
     * @param string $source    Ordner lmo/ des Pakets
     * @param string $vendorDir Composer-Ordner des Projekts (enthaelt autoload.php)
     */
    public function __construct(string $source, string $vendorDir)
    {
        $this->source = self::normalize($source);
        $this->vendorDir = self::normalize($vendorDir);
        if (!is_file($this->source . '/init.php')) {
            throw new \RuntimeException('LMO-Dateien nicht gefunden: ' . $this->source);
        }
    }

    /**
     * @return array{copied: int, kept: int, removed: int}
     */
    public function install(string $target): array
    {
        $target = self::normalize($target);
        if ($target === $this->source || strpos($target . '/', $this->source . '/') === 0) {
            throw new \RuntimeException('Der Zielordner darf nicht im Paket selbst liegen: ' . $target);
        }
        if (is_dir($target) && !is_file($target . '/init.php') && count(scandir($target)) > 2) {
            throw new \RuntimeException('Der Zielordner ist nicht leer und enthaelt keinen LMO: ' . $target);
        }

        $stats = ['copied' => 0, 'kept' => 0, 'removed' => 0];
        $code = [];
        foreach ($this->sourceFiles() as $file) {
            $from = $this->source . '/' . $file;
            $to = $target . '/' . $file;
            $keep = self::isKept($file);
            if ($keep && file_exists($to)) {
                $stats['kept']++;
                continue;
            }
            if (!is_dir(dirname($to)) && !mkdir(dirname($to), 0777, true) && !is_dir(dirname($to))) {
                throw new \RuntimeException('Ordner kann nicht angelegt werden: ' . dirname($to));
            }
            if (!copy($from, $to)) {
                throw new \RuntimeException('Datei kann nicht geschrieben werden: ' . $to);
            }
            $stats['copied']++;
            if (!$keep) {
                $code[] = $file;
            }
        }

        $stats['removed'] = $this->removeObsolete($target, $code);
        $this->writeAutoloadStub($target);
        file_put_contents($target . '/' . self::MANIFEST, implode("\n", $code) . "\n");

        return $stats;
    }

    /**
     * Traegt den Abgleich in die composer.json des Projekts ein, damit er nach
     * "composer install" und "composer update" von selbst laeuft.
     *
     * @return bool true, wenn die Datei geaendert wurde
     */
    public static function registerScripts(string $composerJson, string $target): bool
    {
        $data = json_decode((string) file_get_contents($composerJson));
        if (!$data instanceof \stdClass) {
            throw new \RuntimeException('composer.json ist nicht lesbar: ' . $composerJson);
        }
        $target = str_replace('\\', '/', $target);
        $command = self::SCRIPT . ' ' . (strpos($target, ' ') === false ? $target : '"' . $target . '"');

        if (!isset($data->scripts) || !$data->scripts instanceof \stdClass) {
            $data->scripts = new \stdClass();
        }
        $changed = false;
        foreach (self::EVENTS as $event) {
            $old = isset($data->scripts->$event) ? (array) $data->scripts->$event : [];
            $new = array_values(array_filter($old, static fn($entry) => self::targetOf($entry) === null));
            $new[] = $command;
            if ($new !== $old) {
                $data->scripts->$event = $new;
                $changed = true;
            }
        }
        if ($changed) {
            $flags = JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE;
            file_put_contents($composerJson, json_encode($data, $flags) . "\n");
        }

        return $changed;
    }

    /** Zielordner aus einem frueheren Lauf, oder null */
    public static function registeredTarget(string $composerJson): ?string
    {
        $data = is_file($composerJson) ? json_decode((string) file_get_contents($composerJson), true) : null;
        foreach (self::EVENTS as $event) {
            foreach ((array) ($data['scripts'][$event] ?? []) as $entry) {
                if (($target = self::targetOf($entry)) !== null) {
                    return $target;
                }
            }
        }

        return null;
    }

    /**
     * Aufruf von der Kommandozeile und als Composer-Skript.
     *
     * @param string[] $args       Argumente ohne den Skriptnamen
     * @param string   $projectDir Ordner mit der composer.json des Nutzers
     * @param resource $out
     */
    public static function run(array $args, string $source, string $vendorDir, string $projectDir, $out): int
    {
        $composerJson = $projectDir . '/composer.json';
        $target = $args[0] ?? self::registeredTarget($composerJson) ?? self::DEFAULT_TARGET;
        if ($target === '' || $target[0] === '-') {
            fwrite($out, "Aufruf / usage: lmo-install [Zielordner / target dir]\n"
                . 'Ohne Angabe / default: ' . self::DEFAULT_TARGET . "\n");

            return 1;
        }

        try {
            $absolute = self::isAbsolute($target) ? $target : $projectDir . '/' . $target;
            $stats = (new self($source, $vendorDir))->install($absolute);
            fwrite($out, sprintf(
                "LMO -> %s: %d Dateien kopiert, %d eigene behalten, %d veraltete entfernt.\n",
                $target,
                $stats['copied'],
                $stats['kept'],
                $stats['removed']
            ));
            // im Repo des LMO selbst (Entwicklung) nichts eintragen
            $ownRepo = self::normalize($projectDir) === dirname(self::normalize($source));
            if (!$ownRepo && is_file($composerJson) && self::registerScripts($composerJson, $target)) {
                fwrite($out, "composer.json: Abgleich nach 'composer install' und 'composer update' eingetragen.\n");
            }
        } catch (\RuntimeException $e) {
            fwrite($out, 'lmo-install: ' . $e->getMessage() . "\n");

            return 1;
        }

        return 0;
    }

    /** @return string[] alle Dateien des Pakets, relativ zum LMO-Ordner, ohne dessen vendor/ */
    private function sourceFiles(): array
    {
        $files = [];
        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($this->source, \FilesystemIterator::SKIP_DOTS)
        );
        foreach ($iterator as $file) {
            $relative = substr(str_replace('\\', '/', $file->getPathname()), strlen($this->source) + 1);
            if ($file->isFile() && strpos($relative, 'vendor/') !== 0) {
                $files[] = $relative;
            }
        }
        sort($files);

        return $files;
    }

    /** @param string[] $code */
    private function removeObsolete(string $target, array $code): int
    {
        $manifest = $target . '/' . self::MANIFEST;
        if (!is_file($manifest)) {
            return 0;
        }
        $removed = 0;
        $old = file($manifest, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) ?: [];
        foreach (array_diff($old, $code) as $file) {
            $path = $target . '/' . $file;
            // nur, was wirklich unter dem Zielordner liegt und keine Daten des Nutzers enthaelt
            if (strpos($file, '..') !== false || self::isKept($file) || !is_file($path)) {
                continue;
            }
            unlink($path);
            @rmdir(dirname($path));
            $removed++;
        }

        return $removed;
    }

    /**
     * init.php laedt vendor/autoload.php aus dem LMO-Ordner. Die Abhaengigkeiten selbst bleiben
     * ausserhalb des Webservers; hier liegt nur der Verweis dorthin.
     */
    private function writeAutoloadStub(string $target): void
    {
        $dir = $target . '/vendor';
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }
        $relative = self::relativePath(self::normalize($dir), $this->vendorDir);
        $path = $relative === null
            ? var_export($this->vendorDir . '/autoload.php', true)
            : "__DIR__ . '/" . $relative . "/autoload.php'";
        file_put_contents(
            $dir . '/autoload.php',
            "<?php\n// Von lmo-install erzeugt: verweist auf die Composer-Abhaengigkeiten des Projekts.\n"
            . 'return require ' . $path . ";\n"
        );
        file_put_contents($dir . '/.htaccess', self::DENY);
        // Liegt der LMO direkt im Projektordner, ist dieser oft selbst der Webserver-Ordner:
        // dann waeren auch die Abhaengigkeiten von aussen erreichbar.
        if (!file_exists($this->vendorDir . '/.htaccess')) {
            @file_put_contents($this->vendorDir . '/.htaccess', self::DENY);
        }
    }

    private static function isKept(string $file): bool
    {
        foreach (self::KEEP as $keep) {
            if ($file === $keep || strpos($file, $keep . '/') === 0) {
                return true;
            }
        }

        return false;
    }

    /** @param mixed $entry Eintrag aus "scripts" */
    private static function targetOf($entry): ?string
    {
        if (!is_string($entry) || !preg_match('/^' . self::SCRIPT . '\s+(.+)$/', trim($entry), $match)) {
            return null;
        }

        return trim($match[1], '"');
    }

    private static function isAbsolute(string $path): bool
    {
        return (bool) preg_match('#^([a-zA-Z]:)?[/\\\\]#', $path);
    }

    /** Absoluter Pfad mit "/", ohne "." und ".."; der Ordner muss noch nicht existieren */
    private static function normalize(string $path): string
    {
        $path = str_replace('\\', '/', $path);
        if (!self::isAbsolute($path)) {
            $path = str_replace('\\', '/', (string) getcwd()) . '/' . $path;
        }
        $root = preg_match('#^([a-zA-Z]:)?/#', $path, $match) ? $match[0] : '';
        $parts = [];
        foreach (explode('/', substr($path, strlen($root))) as $part) {
            if ($part === '..') {
                array_pop($parts);
            } elseif ($part !== '' && $part !== '.') {
                $parts[] = $part;
            }
        }
        $path = $root . implode('/', $parts);
        $real = realpath($path);

        return $real === false ? $path : str_replace('\\', '/', $real);
    }

    /** Weg von $from nach $to, oder null bei verschiedenen Laufwerken */
    private static function relativePath(string $from, string $to): ?string
    {
        $from = explode('/', $from);
        $to = explode('/', $to);
        if (strcasecmp($from[0], $to[0]) !== 0) {
            return null;
        }
        while ($from && $to && $from[0] === $to[0]) {
            array_shift($from);
            array_shift($to);
        }

        return implode('/', array_merge(array_fill(0, count($from), '..'), $to));
    }
}
