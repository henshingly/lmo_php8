<?php
/**
 * Kindprozess: laedt eine Liga wie lmo-start.php/lmo-showmain2.php und fuehrt
 * lmo-calctable.php fuer alle Ansichten aus. Ausgabe: JSON auf stdout.
 * Aufruf: php calc.php <Instanzpfad> <Ligadatei relativ zu ligen/> [alle]
 * Mit "alle" wird jeder Spieltag gerechnet, sonst eine feste Auswahl (Golden Master).
 *
 * Bewusst ohne Funktionen und Klassen: lmo-calctable.php arbeitet mit dem
 * globalen Scope und muss genau so aufgerufen werden wie im Original.
 * Eigene Variablen tragen das Praefix $gm_, damit sie nicht mit dem Altcode kollidieren.
 */
$gm_instance = $argv[1];
$gm_league = $argv[2];
$gm_allRounds = ($argv[3] ?? '') === 'alle';
chdir($gm_instance);
if (getenv('GOLDEN_COVERAGE_DIR')) {
    require __DIR__ . '/coverage_prepend.php';
}

$_GET = ['file' => $gm_league];
$_POST = [];
$_COOKIE = [];
$_REQUEST = $_GET;
$_SERVER['REQUEST_METHOD'] = 'GET';
$_SERVER['HTTP_HOST'] = 'lmo.test';
$_SERVER['SCRIPT_NAME'] = '/lmo/lmo.php';
$_SERVER['PHP_SELF'] = '/lmo/lmo.php';
$_SERVER['SCRIPT_FILENAME'] = $gm_instance . '/lmo.php';
$_SERVER['QUERY_STRING'] = 'file=' . $gm_league;
$_SERVER['REMOTE_ADDR'] = '127.0.0.1';

require $gm_instance . '/init.php';

// wie lmo-start.php
$array = array();
$ftype = '.l98';
$subdir = '';
$action = 'table';
require PATH_TO_LMO . '/lmo-openfile.php';

$gm_columns = ['spiele', 'siege', 'unent', 'nieder', 'punkte', 'negativ', 'etore', 'atore', 'dtore',
    'maxs0', 'maxs1', 'maxs2', 'maxn0', 'maxn1', 'maxn2', 'ser1', 'ser2', 'ser3', 'ser4'];
$gm_scalars = ['stt', 'hoy', 'anzcnt', 'subteams'];

// Spieltage der geladenen Liga (Rohdaten aus lmo-openfile.php)
$gm_anzst = isset($lmo_liga) ? $lmo_liga->einstellungen()->spieltage() : 0;
$gm_endtabs = $gm_allRounds
    ? range($gm_anzst, 1)
    : array_values(array_unique([$gm_anzst, max(1, $gm_anzst - 1), max(1, intdiv($gm_anzst, 2)), min(3, $gm_anzst), 1]));
// [tabtype, newtabtype, action]: Gesamt, Heim, Auswaerts, Hin-, Rueckrunde und die
// Kombinationen, die lmo-showrestab.php bei tabonres=2 erzeugt, plus Admin-Ansicht
$gm_combos = [
    [0, 0, 'table'], [1, 0, 'table'], [2, 0, 'table'], [3, 0, 'table'], [4, 0, 'table'],
    [1, 3, 'table'], [1, 4, 'table'], [2, 3, 'table'], [2, 4, 'table'],
    [0, 0, 'admin'],
];

/** Numerische Strings wie "0" (array_pad im Original) und Zahlen gleich behandeln. */
$gm_canon = function ($value) use (&$gm_canon) {
    if (is_array($value)) {
        return array_map($gm_canon, $value);
    }
    if (is_string($value) && is_numeric($value)) {
        return $value + 0;
    }
    return $value;
};

$gm_results = [];
foreach ($gm_combos as $gm_combo) {
    foreach ($gm_endtabs as $gm_end) {
        $tabtype = $gm_combo[0];
        $newtabtype = $gm_combo[1];
        $action = $gm_combo[2];
        $endtab = $gm_end;
        $tabdat = ($gm_end == $gm_anzst) ? '' : $gm_end . '. ' . $text[2];

        // keine Ergebnisse des vorigen Durchlaufs durchsickern lassen
        unset($tab0, $tab1, $tab2, $anzcnt, $stt, $hoy, $subteams);
        foreach ($gm_columns as $gm_name) {
            unset($$gm_name);
        }

        $gm_entry = [];
        try {
            require PATH_TO_LMO . '/lmo-calctable.php';
        } catch (\Throwable $gm_error) {
            $gm_entry['error'] = get_class($gm_error) . ': ' . $gm_error->getMessage();
        }

        $gm_entry['tab0'] = isset($tab0) ? $tab0 : null;
        $gm_entry['tab1'] = isset($tab1) ? $tab1 : null;
        $gm_entry['tab2'] = isset($tab2) ? $tab2 : null;
        $gm_entry['endtab'] = $endtab;
        foreach ($gm_scalars as $gm_name) {
            $gm_entry[$gm_name] = isset($$gm_name) ? $gm_canon($$gm_name) : null;
        }
        foreach ($gm_columns as $gm_name) {
            $gm_entry[$gm_name] = isset($$gm_name) ? $gm_canon($$gm_name) : null;
        }

        $gm_label = sprintf('tabtype=%d newtabtype=%d action=%s endtab=%d', $gm_combo[0], $gm_combo[1], $gm_combo[2], $gm_end);
        $gm_results[$gm_label] = $gm_entry;
    }
}

echo json_encode($gm_results, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRESERVE_ZERO_FRACTION | JSON_PARTIAL_OUTPUT_ON_ERROR);
