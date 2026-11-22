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

require_once(__DIR__ . '/../../init.php');
define('LMO_TIPPAUTH', 1);
if (!isset($_SESSION['lmouserok'])) {
    $_SESSION['lmouserok'] = 0;
}
if (!isset($_SESSION['lmousername'])) {
    $_SESSION['lmousername'] = '';
}
if (!isset($_SESSION['lmouserpass'])) {
    $_SESSION['lmouserpass'] = '';
}
if (!isset($_SESSION['lmouserfile'])) {
    $_SESSION['lmouserfile'] = '';
}

$todo = isset($_REQUEST['todo']) ? $_REQUEST['todo'] : '';
$liga = isset($_REQUEST['liga']) ? $_REQUEST['liga'] : '';
$file = isset($_REQUEST['file']) ? $_REQUEST['file'] : '';
$wert = isset($_REQUEST['wert']) ? $_REQUEST['wert'] : '';
$all = isset($_REQUEST['all']) ? ($_REQUEST['all'] == 'yes' ? 1 : '') : '';
$viewermode = isset($_REQUEST['viewermode']) ? 1 : 0;
$teamintern = isset($_REQUEST['teamintern']) ? $_REQUEST['teamintern'] : '';
$endtab = isset($_REQUEST['endtab']) ? $_REQUEST['endtab'] : 0;
if (!isset($tipp_tippeinsicht)) {
    $tipp_tippeinsicht = isset($_REQUEST['tipp_tippeinsicht']) ? $_REQUEST['tipp_tippeinsicht'] : 1;
}
if (!isset($tipp_jokertippmulti)) {
    $tipp_jokertippmulti = isset($_REQUEST['tipp_jokertippmulti']) ? $_REQUEST['tipp_jokertippmulti'] : 2;
}

if ($todo == 'logout') {
    $_SESSION['lmotipperok'] = 0;
    $lmotipperpass = '';
    $_SESSION['lmotipperverein'] = '';
}
if ($todo == 'newtipper') {
    $_SESSION['lmotipperok'] = -4;
}
if ($todo == 'getpass') {
    $_SESSION['lmotipperok'] = -5;
}
// Admin-Nachtrag: Der Voll-Admin traegt Tipps fuer einen Tipper ein (Zeitsperre aufgehoben).
// Dazu wird fuer genau diese Anfrage die Tipper-Anmeldung simuliert und danach wieder zurueckgesetzt.
$tipp_adminq = '';
$tipp_adminnick = '';
if ($todo == 'edit' && $_SESSION['lmouserok'] == 2 && isset($_REQUEST['asnick']) && is_string($_REQUEST['asnick'])) {
    require_once(PATH_TO_ADDONDIR . '/tipp/lmo-tippnachtrag.php');
    if (!isset($_SESSION['lmo_tipp_adm_token'])) {
        $_SESSION['lmo_tipp_adm_token'] = bin2hex(random_bytes(16));
    }
    $tipp_admin_post = ($_SERVER['REQUEST_METHOD'] === 'POST');
    $tipp_admin_token_ok = !$tipp_admin_post || (isset($_POST['asv']) && is_string($_POST['asv']) && hash_equals($_SESSION['lmo_tipp_adm_token'], $_POST['asv']));
    if ($tipp_admin_token_ok && lmo_tipp_nachtrag_valid($file, $_REQUEST['asnick'])) {
        define('LMO_TIPP_ADMINEDIT', true);
        $tipp_adminnick = $_REQUEST['asnick'];
        $tipp_adminq = '&amp;asnick=' . rawurlencode($tipp_adminnick);
        $tipp_admin_orig = [];
        foreach (['lmotipperok', 'lmotippername', 'lmotipperpass', 'lmotipperverein'] as $tipp_admin_k) {
            $tipp_admin_orig[$tipp_admin_k] = isset($_SESSION[$tipp_admin_k]) ? $_SESSION[$tipp_admin_k] : null;
        }
        $_SESSION['lmotipperok'] = 5;
        $_SESSION['lmotippername'] = $tipp_adminnick;
        $_SESSION['lmotipperpass'] = '';
        $_SESSION['lmotipperverein'] = '';
        register_shutdown_function(function () use ($tipp_admin_orig) {
            foreach ($tipp_admin_orig as $k => $v) {
                if ($v === null) {
                    unset($_SESSION[$k]);
                } else {
                    $_SESSION[$k] = $v;
                }
            }
        });
    }
}
$action = 'tipp';
require(PATH_TO_ADDONDIR . '/tipp/lmo-tippauth.php');
if ($_SESSION['lmotipperok'] > 0) {
    require(PATH_TO_ADDONDIR . '/tipp/lmo-tippmain.php');
}
if ($_SESSION['lmotipperok'] == -4) {
    require(PATH_TO_ADDONDIR . '/tipp/lmo-tippernew.php');
}
