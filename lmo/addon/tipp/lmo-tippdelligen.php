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
if (($action == "tipp") && ($todo == "delligen")) {
  if ($newpage == 1) {
    if ($xtipperligen != "") {
      foreach($xtipperligen as $key => $value) {
        $tippfile = PATH_TO_ADDONDIR."/tipp/".$tipp_dirtipp.$value."_".$_SESSION['lmotippername'].".tip";
        if (file_exists($tippfile)) {
          @unlink($tippfile); // Tipps löschen
        }
      }
    }
  } // end ($newpage==1)
?>
<div class="container">
  <div class="row">
    <div class="col offset-4"><?php echo $text['tipp'][266]; ?></div>
  </div>
  <div class="row">
    <div class="col offset-4"><?php if($newpage!=1){?>
      <form name="lmotippedit" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="form-inline">
        <input type="hidden" name="action" value="tipp">
        <input type="hidden" name="todo" value="delligen">
        <input type="hidden" name="newpage" value="1"><?php 
    $ftype=".l98"; 
    require(PATH_TO_ADDONDIR."/tipp/lmo-tippnewdir.php");
    if($i>0){ ?>
        <input class="btn btn-sm btn-primary" type="submit" name="xtippersub" value="<?php echo $text['tipp'][268]; ?>"><?php 
    }?>
      </form><?php
  }?>
    </div>
  </div>
  <div class="row">
    <div clas="col offset-4"><?php echo getMessage('<strong>'.$text['tipp'][82].'</strong> '.$text['tipp'][267],TRUE); ?></div>
  </div><?php 
  if($newpage==1){ /* Abbestellen erfolgreich */?>
  <div class="row">
    <div class="col"><?php echo getMessage($text['tipp'][269]); ?></div>
  </div><?php  }
  if($newpage==1 || $i==0){ /* zurück zur Übersicht */?>
  <div class="row">
    <div class="col"><a href="<?php echo $_SERVER['PHP_SELF']."?action=tipp&amp;todo=" ?>"><?php echo $text[5]." ".$text['tipp'][1]; ?></a></div>
  </div><?php   } ?>
</div><?php } 
$file=""; 
?>