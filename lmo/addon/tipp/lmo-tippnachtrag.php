<?php

/** Liga Manager Online 4
  *
  * http://lmo.sourceforge.net/
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
 * Tipps nachtragen: Der Voll-Admin kann fuer einen Tipper Tipps auch nach Spielbeginn eintragen.
 * Hilfsfunktionen fuer lmo-tippstart.php, lmo-tippedit.php und lmo-admintippnachtrag.php
 */

/** Pfad der .tip-Datei eines Tippers fuer eine Liga (ohne Pruefung). */
function lmo_tipp_nachtrag_tippfile($file, $nick)
{
    global $tipp_dirtipp;

    return PATH_TO_ADDONDIR . '/tipp/' . $tipp_dirtipp . substr($file, 0, -4) . '_' . $nick . '.tip';
}

/** Prueft Liga-Dateiname und Nick und ob der Tipper fuer diese Liga eine Tippdatei hat. */
function lmo_tipp_nachtrag_valid($file, $nick)
{
    if (!is_string($file) || !is_string($nick) || $file === '' || $nick === '') {
        return false;
    }
    if (strtolower(substr($file, -4)) !== '.l98' || strpos($file, '..') !== false || preg_match('/[\x00-\x1f\\\\]/', $file)) {
        return false;
    }
    if (strpos($nick, '..') !== false || preg_match('/[\x00-\x1f\/\\\\:*?"<>|]/', $nick)) {
        return false;
    }

    return is_file(lmo_tipp_nachtrag_tippfile($file, $nick));
}

/** Nicks aller Tipper, die fuer die Liga eine Tippdatei haben (sortiert). */
function lmo_tipp_nachtrag_nicks($file)
{
    global $tipp_dirtipp;

    $nicks = [];
    $liga = strtolower(substr($file, 0, -4));
    $dir = PATH_TO_ADDONDIR . '/tipp/' . $tipp_dirtipp;
    if (!is_dir($dir)) {
        return $nicks;
    }
    foreach (scandir($dir) as $f) {
        if (strtolower(substr($f, -4)) === '.tip' && strrpos($f, '_') !== false && strtolower(substr($f, 0, strrpos($f, '_'))) === $liga) {
            $nicks[] = substr(substr($f, strrpos($f, '_') + 1), 0, -4);
        }
    }
    natcasesort($nicks);

    return array_values($nicks);
}

/** Protokolliert einen Nachtrag in config/tipp/nachtrag.php (mit Schutzzeile, nicht per Browser lesbar). */
function lmo_tipp_nachtrag_log($file, $nick, $st)
{
    $logfile = PATH_TO_LMO . '/config/tipp/nachtrag.php';
    $admin = isset($_SESSION['lmousername']) ? str_replace(["\r", "\n", '|'], ' ', $_SESSION['lmousername']) : '';
    $line = date('Y-m-d H:i:s') . '|' . $admin . '|' . str_replace(["\r", "\n", '|'], ' ', $nick) . '|' . $file . '|' . (int)$st . "\n";
    $head = '';
    if (!is_file($logfile)) {
        $head = "<?php exit(); ?>\n";
    }
    @file_put_contents($logfile, $head . $line, FILE_APPEND | LOCK_EX);
}
