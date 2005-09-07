<?
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
  
  
require_once(dirname(__FILE__).'/../../init.php');
define('LMO_TIPPAUTH', 1);
if (!isset($_SESSION["lmouserok"])) {
  $_SESSION["lmouserok"] = 0;
}
if (!isset($_SESSION["lmousername"])) {
  $_SESSION["lmousername"] = "";
}
if (!isset($_SESSION["lmouserpass"])) {
  $_SESSION["lmouserpass"] = "";
}
if (!isset($_SESSION["lmouserfile"])) {
  $_SESSION["lmouserfile"] = "";
}
 
$todo=                isset($_REQUEST['todo'])               ?$_REQUEST['todo']                :'';
$liga=                isset($_REQUEST['liga'])               ?$_REQUEST['liga']                :'';
$file=                isset($_REQUEST['file'])               ?$_REQUEST['file']                :'';
$wert=                isset($_REQUEST['wert'])               ?$_REQUEST['wert']                :'';
$all=                 isset($_REQUEST['all'])                ?($_REQUEST['all']=="yes"?1:'')   :'';
$viewermode=          isset($_REQUEST['viewermode'])         ?1                                :0;
$teamintern=          isset($_REQUEST['teamintern'])         ?$_REQUEST['teamintern']          :'';
$endtab=              isset($_REQUEST['endtab'])             ?$_REQUEST['endtab']              :0;
if (!isset($tipp_tippeinsicht)) {
  $tipp_tippeinsicht=   isset($_REQUEST['tipp_tippeinsicht'])  ?$_REQUEST['tipp_tippeinsicht']   :1;
}
if (!isset($tipp_jokertippmulti)) {
  $tipp_jokertippmulti= isset($_REQUEST['tipp_jokertippmulti'])?$_REQUEST['tipp_jokertippmulti'] :2;
}

if ($todo == "logout") {
  $_SESSION["lmotipperok"] = 0;
  $lmotipperpass = "";
  $_SESSION['lmotipperverein'] = "";
}
if ($todo == "newtipper") {
  $_SESSION["lmotipperok"] = -4;
}
if ($todo == "getpass") {
  $_SESSION["lmotipperok"] = -5;
}
$action = "tipp";
require(PATH_TO_ADDONDIR."/tipp/lmo-tippauth.php");
if ($_SESSION["lmotipperok"] > 0) {
  require(PATH_TO_ADDONDIR."/tipp/lmo-tippmain.php");
}
if ($_SESSION["lmotipperok"] == -4) {
  require(PATH_TO_ADDONDIR."/tipp/lmo-tippernew.php");
}

?>