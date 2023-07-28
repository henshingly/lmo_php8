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
  
  
require_once(PATH_TO_ADDONDIR."/tipp/lmo-tipptest.php");

$action=isset($_REQUEST['action'])?$_REQUEST['action']:'';
$todo=isset($_REQUEST['todo'])?$_REQUEST['todo']:'';
$file=isset($_REQUEST['file'])?$_REQUEST['file']:'';


if ($action == "tipp") {
  if ($file != "") {
    $addm = $_SERVER['PHP_SELF']."?file=".$file."&amp;action=";
  }
  if ($_SESSION["lmotipperok"] == 5) {
    if (($todo == "edit" && $viewermode != 1) || $todo == "einsicht") {
      $lmo_only_st=true;
      require(PATH_TO_LMO."/lmo-openfile.php");
    } elseif($todo == "tabelle") {
      require_once(PATH_TO_LMO."/lmo-openfile.php");
    } elseif(($todo == "wert" && $all != 1) || $todo == "fieber") {
      require(PATH_TO_LMO."/lmo-openfilename.php");
    } elseif($todo == "wert" && $all == 1) {
    }
  }
  $me = array("0", "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
  $adda = $_SERVER['PHP_SELF']."?action=tipp&amp;todo=";
  //if(!isset($st)){$st=$stx;}else{$sty=$st;}
  if (!isset($newpage)) {
    $newpage = 0;
  }
  if (!isset($file)) {
    $file = "";
  }
  if (!isset($tippfile)) {
    $tippfile = "";
  }
  if (!isset($tipp_tipptabelle1)) {
    $tipp_tipptabelle1 = 1;
  }
  include(PATH_TO_ADDONDIR."/tipp/lmo-tippmenu.php");
  ?>
  
<div class="container">
  <div class="row">
    <div class="col d-flex justify-content-center"><h1><?php echo $text['tipp'][0]." ";if(isset($titel)){echo $titel;} ?></h1></div>
  </div>
  <div class="row">
    <div class="col"><?php 
  if ($_SESSION["lmotipperok"] == 5) {
    if ($file != "" && $viewermode != 1) {
      $tippfile = PATH_TO_ADDONDIR."/tipp/".$tipp_dirtipp.substr($file, 0, -4)."_".$_SESSION['lmotippername'].".tip";
    }
    if ($viewermode == 1) {
      require(PATH_TO_ADDONDIR."/tipp/lmo-tippviewer.php");
    } else {
      switch ($todo) {
        case "edit":       require(PATH_TO_ADDONDIR."/tipp/lmo-tippedit.php");break;
        case "einsicht":   require(PATH_TO_ADDONDIR."/tipp/lmo-tippeinsicht.php");break;
        case "tabelle":    require(PATH_TO_ADDONDIR."/tipp/lmo-tipptabelle.php");break;
        case "fieber":     require(PATH_TO_ADDONDIR."/tipp/lmo-tippfieber.php");break;
        case "wert":       require(PATH_TO_ADDONDIR."/tipp/lmo-tippwert.php");break;
        case "daten":      require(PATH_TO_ADDONDIR."/tipp/lmo-tippdaten.php");break;
        case "newligen":   require(PATH_TO_ADDONDIR."/tipp/lmo-tippnewligen.php");break;
        case "delligen":   require(PATH_TO_ADDONDIR."/tipp/lmo-tippdelligen.php");break;
        case "pwchange":   require(PATH_TO_ADDONDIR."/tipp/lmo-tipppwchange.php");break;
        case "delaccount": require(PATH_TO_ADDONDIR."/tipp/lmo-tippdelaccount.php");break;
        case "info":       require(PATH_TO_LMO."/lmo-showinfo.php");break;
        default:           require(PATH_TO_ADDONDIR."/tipp/lmo-tipppad.php");break;
      }
    }
  }
  ?>
    </div>
  </div>
</div>
<?php 
}?>