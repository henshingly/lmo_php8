<?php

// Bindet einen der beiden Lader ein, mit denen das Tippspiel die Spiele mehrerer Ligen sammelt
// (lmo-tippopenfileviewer.php, lmo-tippemailviewer.php), ohne den Rest des LMO zu starten.
// Der einbindende Test setzt $testLader; zurueck kommt, was der Lader gesammelt hat.

/**
 * @var string $testLader
 */
define('PATH_TO_LMO', dirname(__DIR__, 4) . '/lmo');
define('PATH_TO_ADDONDIR', PATH_TO_LMO . '/addon');

if (!function_exists('zeit')) {
    /**
     * @param mixed $mterm0
     * @param mixed $datum1
     * @param mixed $datum2
     */
    function zeit($mterm0, $datum1, $datum2): int
    {
        return (int) $mterm0;
    }
}

$text = array_fill(0, 600, '');
$array = [];
$deftime = '15:30';
$tipp_tippohne = 0;
$tipp_jokertipp = 0;
$dateien = ['tippliga.l98'];
$lnr = $liganr = 0;
$now = 1;
$then = PHP_INT_MAX;
$liga = $spieltag = $spiel = $zeit = $tippa = $tippb = $jksp = $tipp_jokertippaktiv = [];
$anzspiele = 0;

require PATH_TO_LMO . '/lmo-ligadaten.php';
// das Tippspiel sammelt in den Feldern der Liga Listen ueber mehrere Ligen, anders als ihr Typ es vorsieht
/** @var mixed $ligaDaten */
$ligaDaten->teams = array_pad($array, 65, '');
$ligaDaten->teams[0] = '___';
foreach (['titel', 'lmtype', 'anzst', 'hidr', 'dats', 'datm', 'modus', 'datum1', 'datum2', 'teama', 'teamb', 'goala', 'goalb',
    'goalfaktor', 'mspez', 'mtipp', 'mnote', 'urlb', 'mberi', 'msieg', 'mterm'] as $feld) {
    $ligaDaten->$feld = [];
}

// Ligenordner relativ zum LMO, wie in der Konfiguration
$dirliga = '../tests/Unit/Tipp/fixtures/';
chdir(PATH_TO_LMO);
if ($testLader === 'lmo-tippopenfileviewer.php') {
    $file = 'tippliga.l98';
    $tippfile = __DIR__ . '/tippliga_tester.tip';
} else {
    $file = $dirliga . 'tippliga.l98';
}

require PATH_TO_ADDONDIR . '/tipp/' . $testLader;

return compact('ligaDaten', 'liga', 'spieltag', 'spiel', 'zeit', 'tippa', 'tippb', 'anzspiele');
