<?php

/** Liga Manager Online 4
  *
  * https://www.liga-manager-online.org/lmo/
  *
  * This program is free software; you can redistribute it and/or
  * modify it under the terms of the GNU General Public License as
  * published by the Free Software Foundation; either version 2 of
  * the License, or (at your option) any later version.
  *
  * This program is distributed in the hope that it will be useful,
  * but WITHOUT ANY WARRANTY; without even the implied warranty of
  * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
  * General Public License for more details.
  *
  * REMOVING OR CHANGING THE COPYRIGHT NOTICES IS NOT ALLOWED!
  *
  */

/**
 * Sicherungsmanager für das Tippspiel: Hilfsfunktionen.
 *
 * Gesichert werden
 *  - der Tippordner (Tipps, Auswertungen, Einsichten, Vereinswertung); der Pfad kommt aus der cfg.txt
 *    des Tippspiels ($tipp_dirtipp) und ist nicht immer addon/tipp/tipps/,
 *  - die Tipperdatei (Zugangsdaten, $tipp_tippauthtxt),
 *  - die Punkteregeln (config/tipp/cfg.txt).
 * Die ZIP-Dateien liegen in config/tipp/backup/. Jede Sicherung enthält eine manifest.json mit
 * Prüfsummen; vor dem Wiederherstellen wird sie vollständig geprüft.
 *
 * Verwendet von lmo-admintippbackup.php (Verwaltung), lmo-tippbackupdl.php (Download)
 * und lmo-admintipp.php (automatische Sicherung vor der Auswertung).
 */

if (!defined('LMO_TIPP_BACKUP_MAX_BYTES')) {
    define('LMO_TIPP_BACKUP_MAX_BYTES', 314572800);   // max. entpackte Gesamtgröße (300 MB)
    define('LMO_TIPP_BACKUP_MAX_FILES', 50000);       // max. Anzahl Dateien in einer Sicherung
    define('LMO_TIPP_BACKUP_EXT', 'tip,aus,ein,ver'); // Dateitypen, die im Tippordner wiederhergestellt werden
}

/** Sprachtext des Tippspiels mit englischem Ersatz. */
function lmo_tipp_backup_t($key, $default)
{
    global $text;

    return isset($text['tipp'][$key]) && $text['tipp'][$key] !== '' ? $text['tipp'][$key] : $default;
}

/** Verzeichnis der Sicherungen (liegt im geschützten config-Ordner). */
function lmo_tipp_backup_dir()
{
    return PATH_TO_CONFIGDIR . '/tipp/backup';
}

/** Legt das Sicherungsverzeichnis samt Zugriffsschutz an. */
function lmo_tipp_backup_prepare()
{
    $dir = lmo_tipp_backup_dir();
    if (!is_dir($dir) && !@mkdir($dir, 0775, true) && !is_dir($dir)) {
        return false;
    }
    if (!is_file($dir . '/.htaccess')) {
        @file_put_contents($dir . '/.htaccess', "Require all denied\nDeny from all\n");
    }
    if (!is_file($dir . '/index.html')) {
        @file_put_contents($dir . '/index.html', '');
    }

    return is_writable($dir);
}

/** Pfade laut Konfiguration des Tippspiels. */
function lmo_tipp_backup_paths()
{
    global $tipp_dirtipp, $tipp_tippauthtxt;

    return [
        'dirtipp' => (string)$tipp_dirtipp,
        'tippdir' => rtrim(PATH_TO_ADDONDIR . '/tipp/' . $tipp_dirtipp, '/\\'),
        'authname' => basename((string)$tipp_tippauthtxt),
        'tipperfile' => PATH_TO_ADDONDIR . '/tipp/' . $tipp_tippauthtxt,
        'cfgfile' => PATH_TO_CONFIGDIR . '/tipp/cfg.txt',
    ];
}

/** Prüft, ob das Tippverzeichnis existiert und kein Systemordner ist (nie LMO-Hauptordner oder Eltern davon). */
function lmo_tipp_backup_tippdir_ok($tippdir)
{
    $real = realpath($tippdir);
    if ($real === false || !is_dir($real)) {
        return false;
    }
    $real = rtrim(str_replace('\\', '/', $real), '/') . '/';
    foreach ([PATH_TO_LMO, PATH_TO_ADDONDIR, PATH_TO_CONFIGDIR, lmo_tipp_backup_dir(), PATH_TO_ADDONDIR . '/tipp'] as $protected) {
        $p = realpath($protected);
        if ($p === false) {
            continue;
        }
        $p = rtrim(str_replace('\\', '/', $p), '/') . '/';
        if (strpos($p, $real) === 0) {   // Tippverzeichnis ist der geschützte Ordner oder ein Elternordner davon
            return false;
        }
    }

    return true;
}

/** Sicherungstypen: sicherung (manuell), auto (vor Auswertung), vorher (vor Wiederherstellung). */
function lmo_tipp_backup_valid_name($name)
{
    return is_string($name) && preg_match('/^tippspiel-(sicherung|auto|vorher)_\d{4}-\d{2}-\d{2}_\d{6}_[a-f0-9]{8}\.zip$/', $name) === 1;
}

function lmo_tipp_backup_type($name)
{
    return preg_match('/^tippspiel-(sicherung|auto|vorher)_/', $name, $m) ? $m[1] : 'sicherung';
}

/** Einstellungen (Datei im Sicherungsordner). */
function lmo_tipp_backup_settings()
{
    $set = ['auto' => 1, 'keep' => 10, 'logdays' => 0];
    $file = lmo_tipp_backup_dir() . '/einstellungen.php';
    if (is_file($file)) {
        $lines = file($file, FILE_IGNORE_NEW_LINES);
        $data = json_decode(isset($lines[1]) ? $lines[1] : '', true);
        if (is_array($data)) {
            if (isset($data['auto'])) {
                $set['auto'] = (int)(bool)$data['auto'];
            }
            if (isset($data['keep'])) {
                $set['keep'] = max(0, min(1000, (int)$data['keep']));
            }
            if (isset($data['logdays'])) {
                $set['logdays'] = max(0, min(3650, (int)$data['logdays']));
            }
        }
    }

    return $set;
}

function lmo_tipp_backup_settings_save($auto, $keep, $logdays = 0)
{
    if (!lmo_tipp_backup_prepare()) {
        return false;
    }
    $data = ['auto' => (int)(bool)$auto, 'keep' => max(0, min(1000, (int)$keep)), 'logdays' => max(0, min(3650, (int)$logdays))];

    return @file_put_contents(lmo_tipp_backup_dir() . '/einstellungen.php', "<?php exit; ?>\n" . json_encode($data) . "\n", LOCK_EX) !== false;
}

/** Protokoll (neueste zuerst). */
function lmo_tipp_backup_log($action, $file = '', $info = '')
{
    if (!lmo_tipp_backup_prepare()) {
        return;
    }
    $admin = isset($_SESSION['lmousername']) ? $_SESSION['lmousername'] : '';
    $line = date('Y-m-d H:i:s') . '|' . str_replace(['|', "\r", "\n"], ' ', $admin) . '|' . $action . '|' . $file . '|' . str_replace(['|', "\r", "\n"], ' ', $info) . "\n";
    lmo_tipp_backup_log_prune();
    $log = lmo_tipp_backup_dir() . '/protokoll.php';
    if (!is_file($log)) {
        $line = "<?php exit; ?>\n" . $line;
    }
    @file_put_contents($log, $line, FILE_APPEND | LOCK_EX);
}

/** Entfernt Protokolleinträge, die älter als die eingestellte Anzahl Tage sind (0 = nichts löschen). @return int Anzahl */
function lmo_tipp_backup_log_prune()
{
    $days = lmo_tipp_backup_settings()['logdays'];
    $log = lmo_tipp_backup_dir() . '/protokoll.php';
    if ($days < 1 || !is_file($log)) {
        return 0;
    }
    $limit = date('Y-m-d H:i:s', time() - $days * 86400);
    $lines = file($log, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $keep = [];
    $removed = 0;
    foreach ($lines as $line) {
        if (strpos($line, '|') !== false && substr($line, 0, 19) < $limit) {
            $removed++;
        } else {
            $keep[] = $line;
        }
    }
    if ($removed > 0) {
        @file_put_contents($log, implode("\n", $keep) . "\n", LOCK_EX);
    }

    return $removed;
}

/** Löscht das gesamte Protokoll (nur die Schutzzeile bleibt). */
function lmo_tipp_backup_log_clear()
{
    if (!lmo_tipp_backup_prepare()) {
        return false;
    }

    return @file_put_contents(lmo_tipp_backup_dir() . '/protokoll.php', "<?php exit; ?>\n", LOCK_EX) !== false;
}

function lmo_tipp_backup_log_read($max = 20)
{
    $out = [];
    $log = lmo_tipp_backup_dir() . '/protokoll.php';
    if (is_file($log)) {
        foreach (file($log, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
            if (strpos($line, '|') !== false) {
                $out[] = explode('|', $line) + [0 => '', 1 => '', 2 => '', 3 => '', 4 => ''];
            }
        }
        $out = array_slice(array_reverse($out), 0, $max);
    }

    return $out;
}

/** Sperre gegen gleichzeitige Sicherungen/Wiederherstellungen. */
function lmo_tipp_backup_lock()
{
    if (!lmo_tipp_backup_prepare()) {
        return false;
    }
    $h = @fopen(lmo_tipp_backup_dir() . '/.lock', 'c');
    if (!$h) {
        return false;
    }
    if (!flock($h, LOCK_EX | LOCK_NB)) {
        fclose($h);

        return false;
    }

    return $h;
}

function lmo_tipp_backup_unlock($h)
{
    if ($h) {
        flock($h, LOCK_UN);
        fclose($h);
    }
}

/** Liste der vorhandenen Sicherungen, neueste zuerst. */
function lmo_tipp_backup_list()
{
    $out = [];
    $dir = lmo_tipp_backup_dir();
    if (is_dir($dir)) {
        foreach (scandir($dir) as $f) {
            if (lmo_tipp_backup_valid_name($f) && is_file($dir . '/' . $f)) {
                $out[] = ['name' => $f, 'type' => lmo_tipp_backup_type($f), 'time' => (int)filemtime($dir . '/' . $f), 'size' => (int)filesize($dir . '/' . $f), 'files' => lmo_tipp_backup_filecount($dir . '/' . $f)];
            }
        }
    }
    usort($out, static function ($a, $b) {
        return $b['time'] <=> $a['time'] ?: strcmp($b['name'], $a['name']);
    });

    return $out;
}

/** Anzahl der gesicherten Dateien laut Manifest (ohne vollständige Prüfung); -1 wenn unlesbar. */
function lmo_tipp_backup_filecount($path)
{
    $zip = new ZipArchive();
    if (!class_exists('ZipArchive') || $zip->open($path, ZipArchive::RDONLY) !== true) {
        return -1;
    }
    $st = $zip->statName('manifest.json');
    $n = -1;
    if ($st && $st['size'] < 20000000) {
        $m = json_decode((string)$zip->getFromName('manifest.json'), true);
        if (is_array($m) && isset($m['files']) && is_array($m['files'])) {
            $n = count($m['files']);
        }
    }
    $zip->close();

    return $n;
}

/** Menschenlesbare Dateigröße. */
function lmo_tipp_backup_size($bytes)
{
    if ($bytes >= 1048576) {
        return number_format($bytes / 1048576, 1, ',', '.') . ' MB';
    }

    return number_format(max(1, $bytes) / 1024, 1, ',', '.') . ' KB';
}

/** Ist ein Pfad im ZIP zulässig (keine Verzeichniswechsel, keine absoluten Pfade)? */
function lmo_tipp_backup_name_ok($n)
{
    if ($n === '' || strlen($n) > 250 || $n[0] === '/' || strpos($n, '\\') !== false || preg_match('/[\x00-\x1f:*?"<>|]/', $n)) {
        return false;
    }
    foreach (explode('/', $n) as $p) {
        if ($p === '' || $p === '.' || $p === '..') {
            return false;
        }
    }

    return true;
}

function lmo_tipp_backup_ext_ok($rel)
{
    return in_array(strtolower(pathinfo($rel, PATHINFO_EXTENSION)), explode(',', LMO_TIPP_BACKUP_EXT), true);
}

/** Alle Dateien eines Ordners (relativ, mit /), ohne den Sicherungsordner. */
function lmo_tipp_backup_scan($dir)
{
    $out = [];
    $base = realpath($dir);
    if ($base === false) {
        return $out;
    }
    $skip = realpath(lmo_tipp_backup_dir());
    $it = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($base, FilesystemIterator::SKIP_DOTS), RecursiveIteratorIterator::LEAVES_ONLY);
    foreach ($it as $file) {
        if (!$file->isFile() || $file->isLink()) {
            continue;
        }
        if ($skip !== false && strpos($file->getPathname(), $skip . DIRECTORY_SEPARATOR) === 0) {
            continue;
        }
        $out[str_replace('\\', '/', substr($file->getPathname(), strlen($base) + 1))] = $file->getPathname();
    }

    return $out;
}

/**
 * Erstellt eine Sicherung.
 * @param string $type sicherung|auto|vorher
 * @param bool $haveLock true, wenn der Aufrufer die Sperre schon hält
 * @return array ['ok'=>bool, 'name'=>string, 'files'=>int, 'error'=>string]
 */
function lmo_tipp_backup_create($type = 'sicherung', $haveLock = false)
{
    if (!class_exists('ZipArchive')) {
        return ['ok' => false, 'error' => 'zip'];
    }
    if (!lmo_tipp_backup_prepare()) {
        return ['ok' => false, 'error' => 'dir'];
    }
    $p = lmo_tipp_backup_paths();
    if (!lmo_tipp_backup_tippdir_ok($p['tippdir'])) {
        return ['ok' => false, 'error' => 'src'];
    }
    $lock = $haveLock ? true : lmo_tipp_backup_lock();
    if (!$lock) {
        return ['ok' => false, 'error' => 'lock'];
    }
    $type = in_array($type, ['sicherung', 'auto', 'vorher'], true) ? $type : 'sicherung';
    $name = 'tippspiel-' . $type . '_' . date('Y-m-d_His') . '_' . bin2hex(random_bytes(4)) . '.zip';
    $path = lmo_tipp_backup_dir() . '/' . $name;
    $zip = new ZipArchive();
    if ($zip->open($path, ZipArchive::CREATE | ZipArchive::EXCL) !== true) {
        if (!$haveLock) {
            lmo_tipp_backup_unlock($lock);
        }

        return ['ok' => false, 'error' => 'open'];
    }
    $files = [];
    $counts = ['tippordner' => 0, 'tipperdatei' => 0, 'punkteregeln' => 0];
    foreach (lmo_tipp_backup_scan($p['tippdir']) as $rel => $abs) {
        $files['tippordner/' . $rel] = hash_file('sha256', $abs);
        $zip->addFile($abs, 'tippordner/' . $rel);
        $counts['tippordner']++;
    }
    if (is_file($p['tipperfile'])) {
        $files['tipperdatei/' . $p['authname']] = hash_file('sha256', $p['tipperfile']);
        $zip->addFile($p['tipperfile'], 'tipperdatei/' . $p['authname']);
        $counts['tipperdatei']++;
    }
    if (is_file($p['cfgfile'])) {
        $files['punkteregeln/cfg.txt'] = hash_file('sha256', $p['cfgfile']);
        $zip->addFile($p['cfgfile'], 'punkteregeln/cfg.txt');
        $counts['punkteregeln']++;
    }
    $manifest = [
        'format' => 1,
        'created' => time(),
        'type' => $type,
        'admin' => isset($_SESSION['lmousername']) ? (string)$_SESSION['lmousername'] : '',
        'dirtipp' => $p['dirtipp'],
        'authname' => $p['authname'],
        'counts' => $counts,
        'files' => $files,
    ];
    $zip->addFromString('manifest.json', json_encode($manifest, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
    $typeLabels = ['sicherung' => lmo_tipp_backup_t(335, 'Manual'), 'auto' => lmo_tipp_backup_t(336, 'Automatic (before evaluation)'), 'vorher' => lmo_tipp_backup_t(337, 'Before restore')];
    $zip->addFromString('info.txt', lmo_tipp_backup_t(385, 'LMO prediction game backup') . "\n"
        . lmo_tipp_backup_t(354, 'Created') . ': ' . date('Y-m-d H:i:s') . "\n"
        . lmo_tipp_backup_t(334, 'Type') . ': ' . $typeLabels[$type] . "\n"
        . lmo_tipp_backup_t(390, 'Tip directory') . ': ' . $p['dirtipp'] . "\n"
        . lmo_tipp_backup_t(352, 'Files') . ': ' . count($files) . "\n"
        . 'tippordner/   = ' . lmo_tipp_backup_t(386, 'contents of the tip folder (tips, evaluations, insight, club ranking)') . "\n"
        . 'tipperdatei/  = ' . lmo_tipp_backup_t(387, 'file with the tipper data (contains access data, keep confidential!)') . "\n"
        . 'punkteregeln/ = ' . lmo_tipp_backup_t(388, 'cfg.txt of the prediction game (scoring rules and options)') . "\n"
        . 'manifest.json = ' . lmo_tipp_backup_t(389, 'checksums of all files (verified when restoring)') . "\n");
    $closed = $zip->close();
    if (!$haveLock) {
        lmo_tipp_backup_unlock($lock);
    }
    if (!$closed || !is_file($path)) {
        @unlink($path);

        return ['ok' => false, 'error' => 'write'];
    }
    @chmod($path, 0664);

    return ['ok' => true, 'name' => $name, 'files' => count($files)];
}

/** Löscht eine Sicherung. */
function lmo_tipp_backup_delete($name)
{
    if (!lmo_tipp_backup_valid_name($name)) {
        return false;
    }
    $path = lmo_tipp_backup_dir() . '/' . $name;

    return is_file($path) && @unlink($path);
}

/** Behält nur die neuesten N automatischen Sicherungen (auto + vorher); manuelle Sicherungen bleiben immer. */
function lmo_tipp_backup_prune()
{
    $keep = lmo_tipp_backup_settings()['keep'];
    if ($keep < 1) {
        return 0;
    }
    $n = 0;
    $i = 0;
    foreach (lmo_tipp_backup_list() as $b) {
        if ($b['type'] === 'sicherung') {
            continue;
        }
        if (++$i > $keep && lmo_tipp_backup_delete($b['name'])) {
            $n++;
            lmo_tipp_backup_log('prune', $b['name']);
        }
    }

    return $n;
}

/** Automatische Sicherung vor der Auswertung (höchstens einmal je Anfrage, nur wenn aktiviert). */
function lmo_tipp_backup_auto()
{
    static $done = false;
    if ($done) {
        return null;
    }
    $done = true;
    if (!class_exists('ZipArchive') || !lmo_tipp_backup_settings()['auto']) {
        return null;
    }
    $res = lmo_tipp_backup_create('auto');
    lmo_tipp_backup_log($res['ok'] ? 'auto' : 'auto-fehler', $res['ok'] ? $res['name'] : '', $res['ok'] ? '' : $res['error']);
    if ($res['ok']) {
        lmo_tipp_backup_prune();
    }

    return $res;
}

/**
 * Prüft eine Sicherung vollständig (Aufbau, Dateinamen, Größen, Prüfsummen, Inhalt von PHP-/Textdateien).
 * @return array ['ok'=>bool, 'error'=>string, 'manifest'=>array]
 */
function lmo_tipp_backup_inspect($path)
{
    $fail = static function ($code, $detail = '') {
        return ['ok' => false, 'error' => $code, 'detail' => $detail];
    };
    if (!class_exists('ZipArchive')) {
        return $fail('zip');
    }
    $zip = new ZipArchive();
    if (!is_file($path) || $zip->open($path, ZipArchive::RDONLY) !== true) {
        return $fail('invalid');
    }
    $numFiles = $zip->numFiles;
    if ($numFiles < 2 || $numFiles > LMO_TIPP_BACKUP_MAX_FILES) {
        $zip->close();

        return $fail($numFiles > LMO_TIPP_BACKUP_MAX_FILES ? 'size' : 'invalid');
    }
    $total = 0;
    $entries = [];
    $manifestIdx = -1;
    for ($i = 0; $i < $zip->numFiles; $i++) {
        $st = $zip->statIndex($i);
        if ($st === false) {
            $zip->close();

            return $fail('invalid');
        }
        $n = $st['name'];
        if (substr($n, -1) === '/') {
            continue; // Verzeichniseintrag
        }
        if (!lmo_tipp_backup_name_ok($n)) {
            $zip->close();

            return $fail('forbidden', $n);
        }
        $total += (int)$st['size'];
        if ($total > LMO_TIPP_BACKUP_MAX_BYTES) {
            $zip->close();

            return $fail('size');
        }
        if ($n === 'manifest.json') {
            $manifestIdx = $i;
            if ($st['size'] > 20000000) {
                $zip->close();

                return $fail('size');
            }
        } elseif ($n !== 'info.txt') {
            if (!preg_match('#^(tippordner/.+|tipperdatei/[A-Za-z0-9._-]+\.php|punkteregeln/cfg\.txt)$#', $n)) {
                $zip->close();

                return $fail('forbidden', $n);
            }
            $entries[$n] = (int)$st['size'];
        }
    }
    if ($manifestIdx < 0) {
        $zip->close();

        return $fail('invalid');
    }
    $m = json_decode((string)$zip->getFromIndex($manifestIdx), true);
    if (!is_array($m) || ($m['format'] ?? 0) !== 1 || !isset($m['files']) || !is_array($m['files'])) {
        $zip->close();

        return $fail('invalid');
    }
    $mf = $m['files'];
    ksort($mf);
    $en = $entries;
    ksort($en);
    if (array_keys($mf) !== array_keys($en)) {
        $zip->close();

        return $fail('corrupt');
    }
    $guard = defined('LMO_TIPPAUTH_GUARD') ? LMO_TIPPAUTH_GUARD : '<?php exit; ?>';
    $authCount = 0;
    foreach ($entries as $n => $size) {
        $stream = $zip->getStream($n);
        if (!$stream) {
            $zip->close();

            return $fail('corrupt', $n);
        }
        $ctx = hash_init('sha256');
        $isCode = strpos($n, 'tipperdatei/') === 0 || $n === 'punkteregeln/cfg.txt';
        $buf = '';
        while (!feof($stream)) {
            $chunk = fread($stream, 65536);
            if ($chunk === false) {
                break;
            }
            hash_update($ctx, $chunk);
            if ($isCode) {
                $buf .= $chunk;
            }
        }
        fclose($stream);
        if (!hash_equals((string)$mf[$n], hash_final($ctx))) {
            $zip->close();

            return $fail('corrupt', $n);
        }
        if ($isCode) {
            if (strpos($n, 'tipperdatei/') === 0) {
                $authCount++;
                $nl = strpos($buf, "\n");
                $first = $nl === false ? $buf : substr($buf, 0, $nl);
                $rest = $nl === false ? '' : substr($buf, $nl + 1);
                if (trim($first) !== $guard || strpos($rest, '<?') !== false || strpos($rest, '?>') !== false) {
                    $zip->close();

                    return $fail('forbidden', $n);
                }
            } elseif (strpos($buf, '<?') !== false || strlen($buf) > 200000) {
                $zip->close();

                return $fail('forbidden', $n);
            }
        }
    }
    $zip->close();
    if ($authCount > 1) {
        return $fail('forbidden');
    }

    return ['ok' => true, 'error' => '', 'manifest' => $m];
}

/** Zielpfad einer Datei aus der Sicherung im aktuellen System (null = nicht wiederherstellen). */
function lmo_tipp_backup_target($entry, $p, $parts)
{
    if (strpos($entry, 'tippordner/') === 0) {
        $rel = substr($entry, 11);

        return !empty($parts['tippordner']) && lmo_tipp_backup_ext_ok($rel) ? $p['tippdir'] . '/' . $rel : null;
    }
    if (strpos($entry, 'tipperdatei/') === 0) {
        return !empty($parts['tipperdatei']) ? $p['tipperfile'] : null;
    }
    if ($entry === 'punkteregeln/cfg.txt') {
        return !empty($parts['punkteregeln']) ? $p['cfgfile'] : null;
    }

    return null;
}

/**
 * Vorschau einer Wiederherstellung (ohne etwas zu verändern).
 * @return array ['new','changed','same','delete','skipped']
 */
function lmo_tipp_backup_plan($manifest, $parts, $exact)
{
    $p = lmo_tipp_backup_paths();
    $plan = ['new' => 0, 'changed' => 0, 'same' => 0, 'delete' => 0, 'skipped' => 0];
    $keep = [];
    foreach ($manifest['files'] as $entry => $hash) {
        $target = lmo_tipp_backup_target($entry, $p, $parts);
        if ($target === null) {
            if (strpos($entry, 'tippordner/') === 0 && !empty($parts['tippordner'])) {
                $plan['skipped']++;
            }
            continue;
        }
        if (strpos($entry, 'tippordner/') === 0) {
            $keep[substr($entry, 11)] = true;
        }
        if (!is_file($target)) {
            $plan['new']++;
        } elseif (hash_equals($hash, (string)hash_file('sha256', $target))) {
            $plan['same']++;
        } else {
            $plan['changed']++;
        }
    }
    if ($exact && !empty($parts['tippordner'])) {
        foreach (lmo_tipp_backup_scan($p['tippdir']) as $rel => $abs) {
            if (lmo_tipp_backup_ext_ok($rel) && !isset($keep[$rel])) {
                $plan['delete']++;
            }
        }
    }

    return $plan;
}

/**
 * Stellt eine Sicherung wieder her. Vorher: vollständige Prüfung und automatische Sicherung des aktuellen Zustands.
 * Zweistufig: erst alle Dateien neben das Ziel schreiben und prüfen, dann umbenennen. Bei einem Fehler in
 * der ersten Stufe bleibt der aktuelle Stand unverändert.
 * @return array ['ok'=>bool, 'error'=>string, 'written'=>int, 'deleted'=>int, 'skipped'=>int, 'safety'=>string]
 */
function lmo_tipp_backup_restore($name, $parts, $exact)
{
    if (!lmo_tipp_backup_valid_name($name)) {
        return ['ok' => false, 'error' => 'invalid'];
    }
    $path = lmo_tipp_backup_dir() . '/' . $name;
    $info = lmo_tipp_backup_inspect($path);
    if (!$info['ok']) {
        return $info;
    }
    $p = lmo_tipp_backup_paths();
    if (!empty($parts['tippordner']) && !lmo_tipp_backup_tippdir_ok($p['tippdir'])) {
        return ['ok' => false, 'error' => 'src'];
    }
    $lock = lmo_tipp_backup_lock();
    if (!$lock) {
        return ['ok' => false, 'error' => 'lock'];
    }
    $safety = lmo_tipp_backup_create('vorher', true);
    if (!$safety['ok']) {
        lmo_tipp_backup_unlock($lock);

        return ['ok' => false, 'error' => 'safety'];
    }
    lmo_tipp_backup_log('vorher', $safety['name'], $name);

    $zip = new ZipArchive();
    $zip->open($path, ZipArchive::RDONLY);
    $staged = [];   // [temp => target]
    $keep = [];
    $skipped = 0;
    $fail = static function ($detail) use (&$staged, $zip, $lock, $safety) {
        foreach ($staged as $tmp => $target) {
            @unlink($tmp);
        }
        $zip->close();
        lmo_tipp_backup_unlock($lock);

        return ['ok' => false, 'error' => 'write', 'detail' => $detail, 'safety' => $safety['name']];
    };
    // Stufe 1: schreiben und prüfen
    foreach ($info['manifest']['files'] as $entry => $hash) {
        $target = lmo_tipp_backup_target($entry, $p, $parts);
        if ($target === null) {
            if (strpos($entry, 'tippordner/') === 0 && !empty($parts['tippordner'])) {
                $skipped++;
            }
            continue;
        }
        if (strpos($entry, 'tippordner/') === 0) {
            $keep[substr($entry, 11)] = true;
        }
        if (is_file($target) && hash_equals($hash, (string)hash_file('sha256', $target))) {
            continue;   // unverändert, nicht neu schreiben
        }
        $dir = dirname($target);
        if (!is_dir($dir) && !@mkdir($dir, 0777, true) && !is_dir($dir)) {
            return $fail($entry);
        }
        $tmp = $target . '.tmp-' . bin2hex(random_bytes(4));
        $in = $zip->getStream($entry);
        $out = $in ? @fopen($tmp, 'wb') : false;
        if (!$in || !$out) {
            if ($in) {
                fclose($in);
            }

            return $fail($entry);
        }
        $staged[$tmp] = $target;
        $ctx = hash_init('sha256');
        while (!feof($in)) {
            $chunk = fread($in, 65536);
            if ($chunk === false || $chunk === '') {
                break;
            }
            hash_update($ctx, $chunk);
            if (fwrite($out, $chunk) === false) {
                fclose($in);
                fclose($out);

                return $fail($entry);
            }
        }
        fclose($in);
        fclose($out);
        if (!hash_equals($hash, hash_final($ctx))) {
            return $fail($entry);
        }
    }
    // Stufe 2: an Ort und Stelle bringen
    $written = 0;
    foreach ($staged as $tmp => $target) {
        if (!@rename($tmp, $target)) {
            if (@copy($tmp, $target)) {
                @unlink($tmp);
            } else {
                @unlink($tmp);
                unset($staged[$tmp]);
                $zip->close();
                lmo_tipp_backup_unlock($lock);

                return ['ok' => false, 'error' => 'write', 'detail' => basename($target), 'safety' => $safety['name']];
            }
        }
        @chmod($target, 0666);
        unset($staged[$tmp]);
        $written++;
    }
    $zip->close();
    // Exakter Modus: Dateien entfernen, die nicht in der Sicherung stehen
    $deleted = 0;
    if ($exact && !empty($parts['tippordner'])) {
        foreach (lmo_tipp_backup_scan($p['tippdir']) as $rel => $abs) {
            if (lmo_tipp_backup_ext_ok($rel) && !isset($keep[$rel]) && @unlink($abs)) {
                $deleted++;
            }
        }
    }
    lmo_tipp_backup_log('restore', $name, $written . ' geschrieben, ' . $deleted . ' gelöscht');
    lmo_tipp_backup_unlock($lock);
    lmo_tipp_backup_prune();

    return ['ok' => true, 'error' => '', 'written' => $written, 'deleted' => $deleted, 'skipped' => $skipped, 'safety' => $safety['name']];
}

/**
 * Übernimmt eine hochgeladene ZIP-Datei als Sicherung (nur nach erfolgreicher Prüfung).
 * @return array ['ok'=>bool, 'error'=>string, 'name'=>string]
 */
function lmo_tipp_backup_import($tmpfile)
{
    if (!lmo_tipp_backup_prepare()) {
        return ['ok' => false, 'error' => 'dir'];
    }
    $info = lmo_tipp_backup_inspect($tmpfile);
    if (!$info['ok']) {
        return $info;
    }
    $created = (int)($info['manifest']['created'] ?? time());
    $name = 'tippspiel-sicherung_' . date('Y-m-d_His', $created) . '_' . bin2hex(random_bytes(4)) . '.zip';
    $dest = lmo_tipp_backup_dir() . '/' . $name;
    if (!@move_uploaded_file($tmpfile, $dest)) {
        return ['ok' => false, 'error' => 'write'];
    }
    @chmod($dest, 0664);
    @touch($dest, $created);

    return ['ok' => true, 'error' => '', 'name' => $name];
}

/** CSRF-Token für Sicherungsaktionen (Sitzung). */
function lmo_tipp_backup_token()
{
    if (empty($_SESSION['lmo_tipp_adm_token'])) {
        $_SESSION['lmo_tipp_adm_token'] = bin2hex(random_bytes(16));
    }

    return $_SESSION['lmo_tipp_adm_token'];
}

function lmo_tipp_backup_token_ok($t)
{
    return is_string($t) && isset($_SESSION['lmo_tipp_adm_token']) && hash_equals($_SESSION['lmo_tipp_adm_token'], $t);
}
