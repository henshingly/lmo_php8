<?php

// Laedt lmo/ligen/1l_2024-25.l98 mit lmo-openfile.php, ohne den Rest des LMO zu starten.
// Wird von LigaDatenTest eingebunden; die Variablen des Laders landen im Test.

define('PATH_TO_LMO', dirname(__DIR__, 4) . '/lmo');

if (!function_exists('check_hilfsadmin')) {
    function check_hilfsadmin(string $datei): bool
    {
        return true;
    }
}

$dirliga = 'ligen/';
$file = '1l_2024-25.l98';
$defdateformat = 'd.m.Y H:i';
$text = array_fill(0, 600, '');

require PATH_TO_LMO . '/lmo-openfile.php';
