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
  
if (isset($file) && $file != "") {
  $tabtype=isset($_GET['tabtype'])?$_GET['tabtype']:0;
  $newtabtype=0;
  if(!empty($_GET['st'])) { $endtab = $st;}
  $addp = $_SERVER['PHP_SELF']."?action=program&amp;file=".$file."&amp;selteam=";
  $addr = $_SERVER['PHP_SELF']."?action=$action&amp;tabtype=$tabtype&amp;file=".$file."&amp;st=";
  $breite = 12;
  if ($spez == 1) {
    $breite = $breite+2;
  }
  if (in_array(3,$msieg[$st-1])) {
    $breite = $breite+4;
  }
  if ($datm == 1) {
    $breite = $breite+1;
  }
  if ($endtab > 1) {
    $endtab--;
    require(PATH_TO_LMO."/lmo-calctable.php");
    $platz1 = array("");
    $platz1 = array_pad($array, $anzteams+1, "");
    for($x = 0; $x < $anzteams; $x++) {
      $platz1[intval(substr($tab0[$x], 34))] = $x+1;
    }
    $endtab++;
  }
  if ($tabonres == 2) {
    $newtabtype = $tabtype;
    $tabtype = 1;
    require(PATH_TO_LMO."/lmo-calctable.php");
    $hplatz = array("");
    $hplatz = array_pad($array, $anzteams+1, "");
    for($x = 0; $x < $anzteams; $x++) {
      $hplatz[intval(substr($tab0[$x], 34))] = $x+1;
    }
    $hspiele = $spiele;
    $hsiege = $siege;
    $hunent = $unent;
    $hnieder = $nieder;
    $hpunkte = $punkte;
    $hnegativ = $negativ;
    $hetore = $etore;
    $hatore = $atore;
    $hdtore = $dtore;
    $tabtype = 2;
    require(PATH_TO_LMO."/lmo-calctable.php");
    $aplatz = array("");
    $aplatz = array_pad($array, $anzteams+1, "");
    for($x = 0; $x < $anzteams; $x++) {
      $aplatz[intval(substr($tab0[$x], 34))] = $x+1;
    }
    $aspiele = $spiele;
    $asiege = $siege;
    $aunent = $unent;
    $anieder = $nieder;
    $apunkte = $punkte;
    $anegativ = $negativ;
    $aetore = $etore;
    $aatore = $atore;
    $adtore = $dtore;
    $tabtype=$newtabtype;
  }
  require(PATH_TO_LMO."/lmo-calctable.php");
  $platz0 = array("");
  $platz0 = array_pad($array, $anzteams+1, "");
  for($x = 0; $x < $anzteams; $x++) {
    $platz0[intval(substr($tab0[$x], 34))] = $x+1;
  }
  if ($tabdat == "") {
    $addt1 = $_SERVER['PHP_SELF']."?action=$action&amp;file=".$file."&amp;endtab=".$endtab."&amp;st=".$st."&amp;tabtype=";
  } else {
    $addt1 = $_SERVER['PHP_SELF']."?action=$action&amp;file=".$file."&amp;endtab=".$endtab."&amp;st=".$st."&amp;tabtype=";
  }
  $addt2 = $_SERVER['PHP_SELF']."?action=$action&amp;file=".$file."&amp;tabtype=".$tabtype."&amp;st=".$st."&amp;endtab=";

?>

<div class="container">
  <div class="row">
    <div class="col text-center"><?php include(PATH_TO_LMO."/lmo-spieltagsmenu.php")?></div>
  </div><?php
  
  /** Ergebnisse*/
  if ($tabonres >= 1 || $action=="results") {?>
  <div class="row">
    <div class="col"><?php include(PATH_TO_LMO."/lmo-showresults.php")?></div>
  </div><?php
  }
  
  /** Vor und Zur?ck-Pfeile*/?>
  <div class="row">
    <div class="col">
      <div class="container-fluid">
        <div class="row"><?php  
   $st0 = $st-1;
   if ($st > 1) {?>
          <div class="col-6 text-start">&nbsp;<a href="<?php echo $addr.$st0?>" title="<?php echo $text[6]?>"><?php echo $text[5]?> <?php echo $text[6]?></a>&nbsp;</div><?php
   } else {?>
          <div class="col-6 text-start"></div><?php
   }
   $st0 = $st+1;
   if ($st < $anzst) {?>
          <div class="col-6 text-end">&nbsp;<a href="<?php echo $addr.$st0?>" title="<?php echo $text[8]?>"><?php echo $text[8]?> <?php echo $text[7]?></a>&nbsp;</div><?php
   } else {?>
          <div class="col-6 text-end"></div><?php
   }?>
        </div>
      </div>
    </div>
  </div><?php
  
  /** Tabelle*/
  if ($tabonres >= 1 || $action=="table") {?>
  <div class="row">
    <div class="col"><?php include(PATH_TO_LMO."/lmo-showtable.php")?></div>
  </div><?php
  }?>

</div><?php
}?>