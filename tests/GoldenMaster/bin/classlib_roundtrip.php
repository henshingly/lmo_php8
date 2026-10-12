<?php
/**
 * Kindprozess: prueft, ob die classlib eine Ligadatei unveraendert durchreicht.
 *
 * Je Liga: erst speichert LMO selbst die Datei (lmo-openfile.php + lmo-saveliga.php wie beim
 * Speichern im Admin), damit sie im Format der Oberflaeche vorliegt. Dann laedt die classlib sie
 * (liga::loadFile) und speichert sie unter neuem Namen (liga::writeFile). Verglichen werden alle
 * Schluessel beider Dateien.
 *
 * Aufruf: php classlib_roundtrip.php <Instanzpfad> <Ligadatei relativ zu ligen/> [...]
 * Ausgabe: JSON Ligadatei => {"verloren": {...}, "neu": {...}, "geaendert": {Schluessel: [vorher, nachher]}}
 */
$gm_instance = $argv[1];
$gm_leagues = array_slice($argv, 2);
chdir($gm_instance);
if (getenv('GOLDEN_COVERAGE_DIR')) {
    require __DIR__ . '/coverage_prepend.php';
}

$_GET = [];
$_POST = [];
$_COOKIE = [];
$_REQUEST = [];
$_SERVER['REQUEST_METHOD'] = 'GET';
$_SERVER['HTTP_HOST'] = 'lmo.test';
$_SERVER['SCRIPT_NAME'] = '/lmo/lmoadmin.php';
$_SERVER['PHP_SELF'] = '/lmo/lmoadmin.php';
$_SERVER['SCRIPT_FILENAME'] = $gm_instance . '/lmoadmin.php';
$_SERVER['QUERY_STRING'] = '';
$_SERVER['REMOTE_ADDR'] = '127.0.0.1';

define('LMO_AUTH', 1);
require $gm_instance . '/init.php';
$_SESSION['lmouserok'] = 2;  // Hauptadmin, sonst speichert lmo-saveliga.php nicht

/** @return array<string,string> "Abschnitt:Schluessel" => Wert */
function gm_keys(string $path): array
{
    $keys = [];
    $section = '';
    foreach (file($path) as $line) {
        $line = rtrim($line, "\r\n");
        if (preg_match('/^\[(.+)\]$/', $line, $m)) {
            $section = $m[1];
        } elseif (preg_match('/^([^=]+)=(.*)$/', $line, $m)) {
            $keys[$section . ':' . $m[1]] = trim($m[2]);
        }
    }
    return $keys;
}

$gm_results = [];
foreach ($gm_leagues as $gm_league) {
    // 1. LMO speichert die Liga im eigenen Format
    $file = $gm_league;
    $action = 'admin';
    $array = array();
    $ftype = '.l98';
    ob_start();
    require PATH_TO_LMO . '/lmo-openfile.php';
    require PATH_TO_LMO . '/lmo-saveliga.php';
    ob_end_clean();
    $gm_source = PATH_TO_LMO . '/' . $dirliga . $gm_league;

    // 2. classlib laedt und speichert sie
    $gm_target = substr($gm_source, 0, -4) . '.classlib.l98';
    $gm_liga = new liga();
    $gm_liga->loadFile($gm_source);
    ob_start();
    $gm_liga->writeFile($gm_target);
    ob_end_clean();

    $gm_before = gm_keys($gm_source);
    $gm_after = gm_keys($gm_target);
    unlink($gm_target);
    $gm_changed = [];
    foreach (array_intersect_key($gm_before, $gm_after) as $gm_key => $gm_value) {
        if ($gm_value !== $gm_after[$gm_key]) {
            $gm_changed[$gm_key] = [$gm_value, $gm_after[$gm_key]];
        }
    }
    $gm_results[$gm_league] = [
        'verloren' => array_diff_key($gm_before, $gm_after),
        'neu' => array_diff_key($gm_after, $gm_before),
        'geaendert' => $gm_changed,
    ];
}
echo json_encode($gm_results, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
