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

$cfgfile = PATH_TO_CONFIGDIR . '/cfg.txt';      // Konfigurationsdatei
if (!isset($cfgarray))
    $cfgarray = array();
if (file_exists($cfgfile)) {
    $main_cfgarray = parse_ini_file($cfgfile);  // in Array lesen
    $cfgarray += $main_cfgarray;
    extract ($cfgarray);                        // Variablen erstellen
} else {
    die($text['viewer'][55] . ': ' . $cfgfile . ' ' . $text['viewer'][56]);
    //Fehlerhandling hier rein
}

// Zeitzone setzen
// Reihenfolge: 1. in der Konfiguration eingestellte Zeitzone, 2. Zeitzone des Servers
// (php.ini bzw. System), 3. Europe/Berlin. Ungültige Namen werden verworfen.
$timezone = isset($timezone) ? trim((string) $timezone) : '';
if ($timezone === '' || !in_array($timezone, timezone_identifiers_list(), true)) {
    $timezone = date_default_timezone_get();
    if (!in_array($timezone, timezone_identifiers_list(), true)) {
        // z. B. 'System/Localtime' oder 'UTC'-Alias ohne Eintrag: Name aus Kürzel ableiten
        $timezone = timezone_name_from_abbr(date('T')) ?: 'Europe/Berlin';
    }
}
date_default_timezone_set($timezone);

include(PATH_TO_LMO . '/lmo-updateoptions.php');
$handle = opendir (PATH_TO_CONFIGDIR);
while (false !== ($f = readdir($handle))) {
    if (is_dir(PATH_TO_CONFIGDIR . '/' . $f) && $f != '.' && $f != '..') {
        $addon_cfgfile = PATH_TO_CONFIGDIR . '/' . $f . '/cfg.txt';                     // Konfigurationsdatei
        if (file_exists($addon_cfgfile)) {
            $addon_cfgarray = parse_ini_file($addon_cfgfile, false, INI_SCANNER_RAW);   // in Array lesen
            $cfgarray[$f] = $addon_cfgarray;
            extract($addon_cfgarray, EXTR_PREFIX_ALL, $f);                              // Variablen (mit Prefix) erstellen
        }
    }
}
closedir($handle);

// ---------------------------------------------------------------------------
// Tipper-Datei (Benutzerdaten des Tippspiels)
// Die Datei wird als PHP-Datei mit Schutzzeile geführt (PHP-Exit-Zeile am Dateianfang),
// damit sie auch ohne funktionierende .htaccess nicht im Browser lesbar ist.
// ---------------------------------------------------------------------------
if (!defined('LMO_TIPPAUTH_GUARD')) {
    define('LMO_TIPPAUTH_GUARD', '<?php exit; ?>');
}

/**
 * Liefert die Zeilen der Tipper-Datei ohne die PHP-Schutzzeile
 * (wie file(), also mit Zeilenumbrüchen).
 */
if (!function_exists('lmo_tipper_lines')) {
    function lmo_tipper_lines($pswfile)
    {
        $lines = is_file($pswfile) ? file($pswfile) : false;
        if ($lines === false) {
            return array();
        }
        return array_values(array_filter($lines, function ($line) {
            return strpos(ltrim($line), '<?php') !== 0;
        }));
    }
}

/**
 * Einmalige Umstellung einer bestehenden Installation:
 * addon/tipp/lmo-tippauth.txt  ->  addon/tipp/lmo-tipperauth.php (mit Schutzzeile)
 * und Anpassung von config/tipp/cfg.txt.
 * Fall 1: cfg.txt verweist noch auf die alte .txt-Datei.
 * Fall 2: cfg.txt verweist schon auf lmo-tipperauth.php, die Datei fehlt aber
 *         noch und die alte lmo-tippauth.txt liegt noch auf dem Server.
 */
if (isset($tipp_tippauthtxt)) {
    $lmo_new_name = 'lmo-tipperauth.php';
    $lmo_new_auth = PATH_TO_ADDONDIR . '/tipp/' . $lmo_new_name;
    $lmo_tipp_cfg = PATH_TO_CONFIGDIR . '/tipp/cfg.txt';
    $lmo_old_auth = '';
    $lmo_fix_cfg = false;
    if (strtolower(substr($tipp_tippauthtxt, -4)) === '.txt') {
        $lmo_old_auth = PATH_TO_ADDONDIR . '/tipp/' . $tipp_tippauthtxt;
        $lmo_fix_cfg = true;
    } elseif ($tipp_tippauthtxt === $lmo_new_name) {
        $lmo_old_auth = PATH_TO_ADDONDIR . '/tipp/lmo-tippauth.txt';
    }
    if ($lmo_old_auth !== '' && count(lmo_tipper_lines($lmo_new_auth)) == 0 && is_file($lmo_old_auth) && (!$lmo_fix_cfg || is_file($lmo_tipp_cfg))) {
        $lmo_data = LMO_TIPPAUTH_GUARD . "\n" . implode('', lmo_tipper_lines($lmo_old_auth));
        $lmo_ok = (file_put_contents($lmo_new_auth, $lmo_data, LOCK_EX) === strlen($lmo_data)) && (file_get_contents($lmo_new_auth) === $lmo_data);
        if ($lmo_ok && $lmo_fix_cfg) {
            $lmo_cfg = file_get_contents($lmo_tipp_cfg);
            $lmo_cfg_new = preg_replace('/^tippauthtxt=.*$/m', 'tippauthtxt=' . $lmo_new_name, (string) $lmo_cfg, 1, $lmo_cnt);
            $lmo_ok = $lmo_cfg !== false && $lmo_cnt === 1 && file_put_contents($lmo_tipp_cfg, $lmo_cfg_new, LOCK_EX) !== false;
        }
        if ($lmo_ok) {
            $tipp_tippauthtxt = $lmo_new_name;
            if (isset($cfgarray['tipp']['tippauthtxt'])) {
                $cfgarray['tipp']['tippauthtxt'] = $lmo_new_name;
            }
            @unlink($lmo_old_auth);   // Klartext-Datei entfernen
        } else {
            @unlink($lmo_new_auth);   // Umstellung unvollständig: nichts halb Fertiges zurücklassen
        }
    }
    unset($lmo_old_auth, $lmo_new_name, $lmo_new_auth, $lmo_tipp_cfg, $lmo_data, $lmo_cfg, $lmo_cfg_new, $lmo_cnt, $lmo_ok, $lmo_fix_cfg);
}
?>