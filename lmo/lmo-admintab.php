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
  * $Id$
  */


require_once(PATH_TO_LMO."/lmo-admintest.php");
if ($file != "") {

  require_once(PATH_TO_LMO."/lmo-openfile.php");
  $endtab = $st;
  $tabdat = "";
  require(PATH_TO_LMO."/lmo-calctable.php");
  $platz0 = array("");
  $platz0 = array_pad($array, $anzteams+1, "");
  for($x = 0; $x < $anzteams; $x++) {
    $x3 = intval(substr($tab2[$x], 34));
    $platz0[$x3] = $x+1;
  }
  $addt2 = $_SERVER['PHP_SELF']."?action=table&amp;file=".$file."&amp;tabtype=".$tabtype."&amp;endtab=";
  if (!isset($save)) {
    $save = 0;
  }
  if ($save == 1) {
    $xa = "";
    $xb = "";
    $xc = 0;
    for($i = 1; $i <= $anzteams; $i++) {
      if ($i < 10) {
        $xa = $xa."0";
      }
      $xa = $xa.$i;
      $xb = $xb.sprintf("%02s",trim($_POST["xplatz".$i]));
      if ($i == trim($_POST["xplatz".$i])) {
        $xc++;
      }
    }
    if ($xc == $anzteams) {
      $handp[$st-1] = 0;
    } else {
      $handp[$st-1] = $xb;
    }
    require(PATH_TO_LMO."/lmo-savefile.php");
  }

  $handt = array_pad($array, $anzteams+2, "");
  for($i = 0; $i < $anzteams; $i++) {
    if ($handp[$st-1] != 0) {
      $handt[$i+1] = intval(substr($handp[$st-1], $i * 2, 2));
    } else {
      $handt[$i+1] = $i+1;
    }
  }
  $addr = $_SERVER['PHP_SELF']."?action=admin&amp;todo=edit&amp;file=".$file."&amp;st=";
  $addb = $_SERVER['PHP_SELF']."?action=admin&amp;todo=tabs&amp;file=".$file."&amp;st=";
  
  include(PATH_TO_LMO."/lmo-adminsubnavi.php");?>

<div class="container">
  <div class="row p-3">
    <div class="col"><h1><?php echo $titel?></h1></div>
  </div>
  <div class="row">
    <div class="col"><?php include (PATH_TO_LMO."/lmo-spieltagsmenu.php");?></div>
  </div>
  <div class="row">
    <div class="col">
      <form name="lmoedit" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
        <input type="hidden" name="action" value="admin">
        <input type="hidden" name="todo" value="tabs">
        <input type="hidden" name="save" value="1">
        <input type="hidden" name="file" value="<?php echo $file;?>">
        <input type="hidden" name="st" value="<?php echo $st;?>">
        <div class="container">
          <div class="row pb-3">
            <div class="col-4 text-start"><strong><?php echo $st.". ".$text[2];?></strong></div>
            <div class="col-1"><strong><?php echo $text[33];?></strong></div>
            <div class="col-1"><strong><?php echo $text[34];?></strong></div><?php 
  if($hidr!=1){ ?>
            <div class="col-1"><strong><?php echo $text[35];?></strong></div><?php 
  }?>
            <div class="col-1"><strong><?php echo $text[36];?></strong></div><?php 
  if($tabpkt==0){ ?>
            <div class="col-1"><strong><?php echo $text[37]?></strong></div><?php 
  }?>
            <div class="col-1"><strong><?php echo $text[38];?></strong></div>
            <div class="col-1"><strong><?php echo $text[39];?></strong></div><?php 
  if($tabpkt==1){ ?>
            <div class="col-1"><strong><?php echo $text[37]?></strong></div><?php 
  }?>
          </div><?php 
  $j = 1;
  for($x = 1; $x <= $anzteams; $x++) {
    $i = intval(substr($tab2[$x-1], 34));
    if ($i == $favteam) {
      $dummy = "<strong>";
      $dumm2 = "</strong>";
    } else {
      $dummy = "";
      $dumm2 = "";
    }?>
          <div class="row pb-1">
            <div class="col-1 text-end">
              <select title="<?php echo $text[414] ?>" class="custom-control" style="width: 2rem;" name="xplatz<?php echo $x;?>"><?php 
    for($y=1;$y<=$anzteams;$y++){?>
                <option value="<?php echo $y?>" <?php if($y==$handt[$x]){echo " selected";}?>><?php echo $y?></option>
                <?php 
    }?>
              </select>
            </div>
            <div class="col-3 text-start"><?php echo $dummy.$teams[$i].$dumm2;?><?php 
    if ($teamn[$i]!="" || $strafp[$i]!=0 || $strafm[$i]!=0 || $torkorrektur1[$i]!=0 || $torkorrektur2[$i]!=0) {
	   $lmo_tabellennotiz ="";

      /** Notizen anzeigen
       *
       * Achtung: Da beim Speichern Strafpunkte/-tore positiv sind und Bonuspunkte negativ (altes System des LMO)
       * muss mit -1 multipliziert werden, um die Punkte/Tore richtig anzuzeigen
       */

      //Straf-/Bonuspunkte
      if ($strafp[$i]!=0 || $strafm[$i]!=0) {
        $lmo_tabellennotiz.="\n".$text[128].": ";
        //strongunkte
        $lmo_tabellennotiz.=$strafp[$i]<0?"+".((-1)*applyFactor($strafp[$i],$pointsfaktor)):((-1)*applyFactor($strafp[$i],$pointsfaktor));
        //Minuspunkte
        if ($minus==2) {
          $lmo_tabellennotiz.=":".($strafm[$i]<0?"+".((-1)*applyFactor($strafm[$i],$pointsfaktor)):((-1)*applyFactor($strafm[$i],$pointsfaktor)));
        }
        //Ab ST
        if ($strafdat[$i]!=0) $lmo_tabellennotiz.=" ({$text[524]} {$text[145]} {$strafdat[$i]})";
      }
      //Straf-/Bonustore
      if ($torkorrektur1[$i]!=0 || $torkorrektur2[$i]!=0) {
        $lmo_tabellennotiz.="\n".$text[522].": ";
        //Tore
        $lmo_tabellennotiz.=$torkorrektur1[$i]<0?"+".((-1)*applyFactor($torkorrektur1[$i],$goalfaktor)).":":((-1)*applyFactor($torkorrektur1[$i],$goalfaktor)).":";
        //Gegentore
        $lmo_tabellennotiz.=$torkorrektur2[$i]<0?"+".((-1)*applyFactor($torkorrektur2[$i],$goalfaktor)):((-1)*applyFactor($torkorrektur2[$i],$goalfaktor));
        //Ab ST
        if ($strafdat[$i]!=0) $lmo_tabellennotiz.=" ({$text[524]} {$text[145]} {$strafdat[$i]})";
      }
      //Teamnotizen
      if ($teamn[$i]!="") {
        $lmo_tabellennotiz.="\n".$text[22].":\n".$teamn[$i];
      }
      echo "<a data-bs-toggle='tooltip' data-bs-placement='right' data-bs-html='true' title='".$lmo_tabellennotiz."'> <i class='bi bi-info-square text-info' style='font-size: 1.3rem;'></i></a>";
      $lmo_tabellennotiz="";
    } ?>
            </div>
            <div class="col-1"><?php echo $dummy.$spiele[$i].$dumm2;?></div>
            <div class="col-1"><?php echo $dummy.$siege[$i].$dumm2;?></div><?php 
    if($hidr!=1){ ?>
            <div class="col-1"><?php echo $dummy.$unent[$i].$dumm2;?></div><?php 
    }?>
            <div class="col-1"><?php echo $dummy.$nieder[$i].$dumm2;?></div><?php 
    if ($tabpkt == 0) {?>
            <div class="col-1"><strong><?php echo applyFactor($punkte[$i],$pointsfaktor)?></strong></div><?php 
      if ($minus == 2) {?>
            <div class="col-1"><strong>:</strong></div>
            <div class="col-1"><strong><?php echo applyFactor($negativ[$i],$pointsfaktor)?></strong></div><?php 
      }
    }?>
            <div class="col-1"><?php echo $dummy.applyFactor($etore[$i],$goalfaktor).$dumm2; ?>:<?php echo $dummy.applyFactor($atore[$i],$goalfaktor).$dumm2; ?></div>
            <div class="col-1"><?php echo $dummy.applyFactor($dtore[$i],$goalfaktor).$dumm2; ?></div><?php 
    if($tabpkt==1){?>
            <div class="col-1"><strong><?php echo applyFactor($punkte[$i],$pointsfaktor)?><?php 
      if($minus==2){?>
            :<?php echo applyFactor($negativ[$i],$pointsfaktor)?><?php
      }?>
      </strong></div><?php 
    }?>
          </div><?php 
  }?>
          <div class="row p-3">
            <div class="col-1">
              <input title="<?php echo $text[114] ?>" class="btn btn-primary btn-sm" type="submit" name="best" value="<?php echo $text[415];?>">
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</div><?php
} ?>