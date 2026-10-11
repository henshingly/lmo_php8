<?php

// Laedt eine Ligadatei aus diesem Ordner mit einem der Lader des LMO, ohne den Rest zu starten.
// Der einbindende Test setzt $testLader (z. B. 'lmo-openfilename.php') und $file.

/**
 * @var string $testLader
 * @var string $file
 */
define('PATH_TO_LMO', dirname(__DIR__, 4) . '/lmo');

if (!function_exists('check_hilfsadmin')) {
    function check_hilfsadmin(string $datei): bool
    {
        return true;
    }
}

// Ligenordner relativ zum LMO, wie in der Konfiguration
$dirliga = '../tests/Unit/Liga/fixtures/';
$defdateformat = 'd.m.Y H:i';
$text = array_fill(0, 600, '');
$array = [];
// lmo-openfiledat.php liest den Spielplan eines Spieltags, den der Aufrufer waehlt
// und rechnet das Spieltagsdatum mit den englischen Monatsnamen des Aufrufers um
if ($testLader === 'lmo-openfiledat.php') {
    $st = 1;
    $me = ['0', 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
}
// die Lader oeffnen die Datei teils relativ zum Arbeitsverzeichnis
chdir(PATH_TO_LMO);

require PATH_TO_LMO . '/' . $testLader;
