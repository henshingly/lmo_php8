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

$trans_lang = array(
                    'Monday' => $text['date'][0],
                    'Tuesday' => $text['date'][1],
                    'Wednesday' => $text['date'][2],
                    'Thursday' => $text['date'][3],
                    'Friday' => $text['date'][4],
                    'Saturday' => $text['date'][5],
                    'Sunday' => $text['date'][6],
                    'Mon' => $text['date'][7],
                    'Tue' => $text['date'][8],
                    'Wed' => $text['date'][9],
                    'Thu' => $text['date'][10],
                    'Fri' => $text['date'][11],
                    'Sat' => $text['date'][12],
                    'Sun' => $text['date'][13],
                    'January' => $text['date'][14],
                    'February' => $text['date'][15],
                    'March' => $text['date'][16],
                    'April' => $text['date'][17],
                    'May' => $text['date'][18],
                    'June' => $text['date'][19],
                    'July' => $text['date'][20],
                    'August' => $text['date'][21],
                    'September' => $text['date'][22],
                    'October' => $text['date'][23],
                    'November' => $text['date'][24],
                    'December' => $text['date'][25],
                    'Jan' => $text['date'][26],
                    'Feb' => $text['date'][27],
                    'Mar' => $text['date'][28],
                    'Apr' => $text['date'][29],
                    'May' => $text['date'][30],
                    'Jun' => $text['date'][31],
                    'Jul' => $text['date'][32],
                    'Aug' => $text['date'][33],
                    'Sep' => $text['date'][34],
                    'Oct' => $text['date'][35],
                    'Nov' => $text['date'][36],
                    'Dec' => $text['date'][37]
                );

function check_hilfsadmin($datei) {
    $hilfsadmin_berechtigung = false;
    if (isset($_SESSION['lmouserok']) && $_SESSION['lmouserok'] == 1) {
        $hilfsadmin_ligen = explode(',', $_SESSION['lmouserfile']);
        if (isset($hilfsadmin_ligen)) {
            foreach ($hilfsadmin_ligen as $hilfsadmin_liga) {
                if ($hilfsadmin_liga . '.l98' == basename($datei)) {
                    $hilfsadmin_berechtigung = true;
                }
            }
        }
    }
    else {
        $hilfsadmin_berechtigung = true;
    }
    return $hilfsadmin_berechtigung;
}


function applyFactor ($value, $factor) {
    if (is_numeric($value) && $value != 0) {
        return ($value / $factor);
    }
    return $value;
}

function magicQuotesRemove(&$array) {
    //if (!get_magic_quotes_gpc())
    //return;
    foreach($array as $key => $elem) {
        if (is_array($elem))
            magicQuotesRemove($elem);
        else
            $array[$key] = stripslashes($elem);
    }
}

function get_dir($verz) {
    $ret = array();
    if (substr($verz, -1) != '/') $verz .= '/';

    $handle = opendir(PATH_TO_LMO . '/' . $verz);
    if ($handle) {
        while ($file = readdir ($handle)) {
            if ($file != '.' && $file != '..') {
                if (is_dir(PATH_TO_LMO . '/' . $verz . $file)) {
                    $ret[] = $file;
                }
            }
        }
        closedir($handle);
    }
    return $ret;
}

function filterZero($a) {
    return (!empty($a));
}


/**
 * Returns HTML imgage code for a small team icon
 *
 * @param        string     $team       Long name of the team
 * @param        string     $alternative_text      If image not found return this instead
 * @return       string     HTML image-Code for the small team icon
 */
//Umstellung Classlib kann später mal weg
function getSmallImage($team, $alternative_text = '') {
    $team = str_replace('/', '', $team);
    if (!file_exists(PATH_TO_IMGDIR . '/teams/small/' . $team . '.gif')) {
        $team = preg_replace('/[^a-zA-Z0-9]/', '', $team);
    }
    if (!file_exists(PATH_TO_IMGDIR . '/teams/small/' . $team . '.gif')) {
        return $alternative_text;
    }
    else {
        $imgdata = getimagesize(PATH_TO_IMGDIR . '/teams/small/' . $team . '.gif');
        return ('<img border="0" src="' . URL_TO_IMGDIR . '/teams/small/' . rawurlencode($team) . '.gif" {$imgdata[3]} alt=""> ');
    }
}

/**
 * Returns a formatted (error) Message
 *
 * @param        string     $message       Message to return
 * @param        bool       $error         Default false, Is this an error message?
 * @return       string     Formatted (error) message
 */
function getMessage($message, $error = false) {
    if ($error) {
        return '<p class="error"><img src="' . URL_TO_IMGDIR . '/wrong.svg" border="0" width="20" alt=""> ' . $message . '</p>';
    }
    else {
        return '<p class="message"><img src="' . URL_TO_IMGDIR . '/right.svg" border="0" width="20" alt=""> ' . $message . '</p>';
    }
}

/**
 * Returns which team is the winner on a
 *
 * @param        string     $gst
 * @param        string     $gsp
 * @param        string     $gmod   modus (0->regular / 1-> KO / 2->KO with 2 games / 3->best of 3 / 5->best of 5 / 7->best of 7)
 * @param        array      $m1     results of home team
 * @param        array      $m2     results of away team
 * @return       int        $erg    winner(home / away)
 */
function gewinn ($gst, $gsp, $gmod, $m1, $m2) {
    $erg = 0;
    if ($gmod == 1) {
        if ($m1[0] > $m2[0]) {
            $erg = 1;
        }
        elseif ($m1[0] < $m2[0]) {
            $erg = 2;
        }
    }
    elseif ($gmod == 2) {
        if ($m1[1] != '_') {
            if (($m1[0] + $m1[1]) > ($m2[0] + $m2[1])) {
                $erg = 1;
            }
            elseif (($m1[0] + $m1[1]) < ($m2[0] + $m2[1])) {
                $erg = 2;
            }
            else {
                if ($m2[1] > $m1[1]) {
                    $erg = 2;
                }
                elseif ($m2[1] < $m1[1]) {
                    $erg = 1;
                }
            }
        }
    }
    else {
        $erg1 = 0;
        $erg2 = 0;
        for ($k = 0; $k < $gmod; $k++) {
            if (($m1[$k] != '_') && ($m2[$k] != '_')) {
                if ($m1[$k] > $m2[$k]) {
                    $erg1++;
                }
                elseif ($m1[$k] < $m2[$k]) {
                    $erg2++;
                }
            }
        }
        if ($erg1 > ($gmod / 2)) {
            $erg = 1;
        }
        elseif ($erg2 > ($gmod / 2)) {
            $erg = 2;
        }
    }
    return $erg;
}

function getLangSelector() {
    $output_sprachauswahl = '';
    $border = '0';

    $handle = opendir (PATH_TO_LANGDIR);
    while (false !== ($f = readdir($handle))) {
        if (preg_match('/^lang-?(.*)?\.txt$/', $f,$lang) > 0) {
            if ($lang[1] == '') return '';
            if ($lang[1] != $_SESSION['lmouserlang']) {
                $border = '1mm';
                $imgfile = URL_TO_IMGDIR . '/' . $lang[1] . '.svg';
                $output_sprachauswahl .= "      <a href='{$_SERVER['PHP_SELF']}?" . htmlentities(preg_replace("/&?lmouserlang=.+?\b/", "", $_SERVER['QUERY_STRING'])) . "&amp;lmouserlang={$lang[1]}' title='{$lang[1]}'><img src='{$imgfile}' height='16' style='margin-right:$border' title='{$lang[1]}' alt='{$lang[1]}'></a>\n";
            }
            else {
                $imgfile = URL_TO_IMGDIR . '/' . $lang[1] . '.selected.svg';
                $output_sprachauswahl .= "      <img src='{$imgfile}' height='16' border='$border' title='{$lang[1]}' alt='{$lang[1]}'>\n";
            }
        }
        $border = '0';
    }
    closedir($handle);
    if (isset($_SESSION['lmouserok']) && $_SESSION['lmouserok'] == 2) {
        $output_sprachauswahl .= '      &nbsp;<a href="' . URL_TO_LMO . '/lang/translate.php"> » ' . $GLOBALS['text'][573] . '</a>';
    }
    return $output_sprachauswahl;
}

function get_timezones() {
    //load avail timezones
    if (function_exists('timezone_identifiers_list')) {
        $zones = array_reverse(timezone_identifiers_list());

        foreach ($zones as $zone) {
            $zone = explode('/', $zone); // 0 => Continent, 1 => City

            // Only use "friendly" continent names
            if ($zone[0] == 'Africa' ||
                $zone[0] == 'America' ||
                $zone[0] == 'Antarctica' ||
                $zone[0] == 'Arctic' ||
                $zone[0] == 'Asia' ||
                $zone[0] == 'Atlantic' ||
                $zone[0] == 'Australia' ||
                $zone[0] == 'Europe' ||
                $zone[0] == 'Indian' ||
                $zone[0] == 'Pacific')
            {
                if (isset($zone[1]) != '') {
                    $locations[$zone[0]][$zone[0] . '/' . $zone[1]] = str_replace('_', ' ', $zone[1]); // Creates array(DateTimeZone => 'Friendly name')
                }
            }
        }
    }
    else {
        return array();
    }
    return array_reverse($locations);
}

/**
 * Replace function is_a()
 *
 * @category    PHP
 * @package     PHP_Compat
 * @license     LGPL - http://www.gnu.org/licenses/lgpl.html
 * @copyright   2004-2007 Aidan Lister <aidan@php.net>, Arpad Ray <arpad@php.net>
 * @link        http://php.net/function.is_a
 * @author      Aidan Lister <aidan@php.net>
 * @version     $Revision$
 * @since       PHP 4.2.0
 * @require     PHP 4.0.0 (user_error) (is_subclass_of)
 */
function php_compat_is_a($object, $class) {
    if (!is_object($object)) {
        return false;
    }
    if (strtolower(get_class($object)) == strtolower($class)) {
        return true;
    }
    else {
        return is_subclass_of($object, $class);
    }
}

// Define
if (!function_exists('is_a')) {
    function is_a($object, $class) {
        return php_compat_is_a($object, $class);
    }
}

// Redirect browser using the header function
function redirect($location) {
    header('Location: ' . $location);
}


// URL mit PHP auf Existenz überprüfen
// Funktion deklarieren
function url_check($url) { 
    $url_objects = @get_headers($url); 
    return is_array($url_objects) ? preg_match('/^HTTP\\/\\d+\\.\\d+\\s+2\\d\\d\\s+.*$/', $url_objects[0]) : false; 
};

$string_json = file_get_contents(PATH_TO_LMO . '/composer.json', false);
$json_a = json_decode($string_json, true, 4);
$lmo_version = $json_a['version'];
$lmo_license = $json_a['license'];
$lmo_version_search = array('<', '>', '=');
$min_php_version = str_replace($lmo_version_search, '', $json_a['require']['php']);
$updatefilecheck_URL = $json_a['extra']['check'];

// UpdateURL prüfen
if (url_check($json_a['extra']['check'])){
    $LMO_UPDATE = file_get_contents($json_a['extra']['check'], false);
    $json_update = json_decode($LMO_UPDATE, true, 4);
    $new_lmo_version = $json_update['stable']['current'];
    $new_lmo_version_link = $json_update['stable']['download'];
    $new_lmo_version_changelog = $json_update['stable']['changelog'];
    $new_lmo_version_announcement = $json_update['stable']['announcement'];
    $new_lmo_version_time = $json_update['stable']['time'];
    $new_lmo_version_require_php = $json_update['stable']['require']['php'];
}
else {
    // UpdateURL ist nicht erreichbar
    $new_lmo_version = $json_a['version'];
    $new_lmo_version_link = '';
};
?>
