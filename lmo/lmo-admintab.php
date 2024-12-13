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
  *
  */


require_once(PATH_TO_LMO."/lmo-admintest.php");
if ($file != "") {

  require_once(PATH_TO_LMO."/lmo-openfile.php");
  $breite = 16;
  if ($hidr != 1) {
    $breite = $breite-1;
  }
  if ($minus == 2) {
    $dummy = "colspan=\"3\" style=\"text-align:center\"";
    $breite = $breite+2;
  } else {
    $dummy = "style=\"text-align:right\"";
  }
  $endtab = $st;
  $tabdat = "";
  require(PATH_TO_LMO."/lmo-calctable.php");
  $platz0 = array("");
  $platz0 = array_pad($array, $anzteams+1, "");
  for ($x = 0; $x < $anzteams; $x++) {
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
    for ($i = 1; $i <= $anzteams; $i++) {
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
  for ($i = 0; $i < $anzteams; $i++) {
    if ($handp[$st-1] != 0) {
      $handt[$i+1] = intval(substr($handp[$st-1], $i * 2, 2));
    } else {
      $handt[$i+1] = $i+1;
    }
  }
  $addr = $_SERVER['PHP_SELF']."?action=admin&amp;todo=edit&amp;file=".$file."&amp;st=";
  $addb = $_SERVER['PHP_SELF']."?action=admin&amp;todo=tabs&amp;file=".$file."&amp;st=";
  $breite = 16;
  if ($spez == 1) {
    $breite = $breite+2;
  }
  include(PATH_TO_LMO."/lmo-adminsubnavi.php");?>

<table class="lmoMiddle" cellspacing="0" cellpadding="0" border="0">
  <tr>
    <td align="center"><h1><?php echo $titel?></h1></td>
  </tr>
  <tr>
    <td align="center"><?php include (PATH_TO_LMO."/lmo-spieltagsmenu.php");?></td>
  </tr>
  <tr>
    <td align="center">
      <form name="lmoedit" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post" onSubmit="return chklmopas2(<?php echo $anzteams;?>)">
        <input type="hidden" name="action" value="admin">
        <input type="hidden" name="todo" value="tabs">
        <input type="hidden" name="save" value="1">
        <input type="hidden" name="file" value="<?php echo $file;?>">
        <input type="hidden" name="st" value="<?php echo $st;?>">
        <table class="lmoInner" cellspacing="0" cellpadding="0" border="0">
          <tr>
            <th style="text-align:left" colspan="4"><?php echo $st.". ".$text[2];?></th>
            <th style="text-align:left" width="2">&nbsp;</th>
            <th style="text-align:center"><acronym title="<?php echo $text[63];?>"><?php echo $text[33];?></acronym></th>
            <th style="text-align:center"><acronym title="<?php echo $text[199];?>"><?php echo $text[34];?></acronym></th><?php
  if ($hidr!=1) {?>
            <th style="text-align:center"><acronym title="<?php echo $text[200];?>"><?php echo $text[35];?></acronym></th><?php
  }?>
            <th style="text-align:center"><acronym title="<?php echo $text[201];?>"><?php echo $text[36];?></acronym></th><?php
  if ($tabpkt==0) {?>
            <th>&nbsp;</th>
            <th <?php echo $dummy?>><?php echo $text[37]?></th><?php
  }?>
            <th style="text-align:"left" width="2">&nbsp;</th>
            <th style="text-align:"left" colspan="3" align="center"><?php echo $text[38];?></th>
            <th align="right"><?php echo $text[39];?></th><?php
  if ($tabpkt==1) {?>
            <th>&nbsp;</th>
            <th <?php echo $dummy?>><?php echo $text[37]?></th><?php
  }?>
          </tr><?php
  $j = 1;
  for ($x = 1; $x <= $anzteams; $x++) {
    $i = intval(substr($tab2[$x-1], 34));
    if ($i == $favteam) {
      $dummy = "<strong>";
      $dumm2 = "</strong>";
    } else {
      $dummy = "";
      $dumm2 = "";
    }?>
          <tr>
            <td align="right">
              <select title="<?php echo $text[414] ?>" class="lmo-formular-input" name="xplatz<?php echo $x;?>" onChange="dolmoedi2(<?php echo $anzteams;?>,'xplatz<?php echo $x;?>')"><?php
    for ($y=1;$y<=$anzteams;$y++) {?>
                <option value="<?php echo $y?>" <?php if ($y==$handt[$x]) {echo " selected";}?>><?php echo $y?></option>
                <?php
    }?>
              </select>
            </td>
            <td class="nobr"><?php echo $dummy.$teams[$i].$dumm2;?></td>
            <td>&nbsp;</td>
            <td><?php
    if ($teamn[$i]!="" || $strafp[$i]!=0 || $strafm[$i]!=0 || $torkorrektur1[$i]!=0 || $torkorrektur2[$i]!=0) {
      $lmo_tabellennotiz=getSmallImage($teams[$i]);

      /** Notizen anzeigen
       *
       * Achtung: Da beim Speichern Strafpunkte/-tore positiv sind und Bonuspunkte negativ (altes System des LMO)
       * muss mit -1 multipliziert werden, um die Punkte/Tore richtig anzuzeigen
       */

      $lmo_tabellennotiz.=" <strong>".$teams[$i]."</strong>";
      //Straf-/Bonuspunkte
      if ($strafp[$i]!=0 || $strafm[$i]!=0) {
        $lmo_tabellennotiz.="\n\n<strong>".$text[128].":</strong> ";
        //Punkte
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
        $lmo_tabellennotiz.="\n<strong>".$text[522].":</strong> ";
        //Tore
        $lmo_tabellennotiz.=$torkorrektur1[$i]<0?"+".((-1)*applyFactor($torkorrektur1[$i],$goalfaktor)).":":((-1)*applyFactor($torkorrektur1[$i],$goalfaktor)).":";
        //Gegentore
        $lmo_tabellennotiz.=$torkorrektur2[$i]<0?"+".((-1)*applyFactor($torkorrektur2[$i],$goalfaktor)):((-1)*applyFactor($torkorrektur2[$i],$goalfaktor));
        //Ab ST
        if ($strafdat[$i]!=0) $lmo_tabellennotiz.=" ({$text[524]} {$text[145]} {$strafdat[$i]})";
      }
      //Teamnotizen
      if ($teamn[$i]!="") {
        $lmo_tabellennotiz.="\n\n<strong>".$text[22].":</strong>\n".$teamn[$i];
      }?>
        <a href='#' onclick="alert('<?php echo addcslashes('',htmlentities(strip_tags($lmo_tabellennotiz)))?>');window.focus();return FALSE;"><img src='<?php echo URL_TO_IMGDIR."/lmo-st2.svg"?>' height='15' border='0' alt=''><span class='popup'><?php echo nl2br($lmo_tabellennotiz)?></span></a><?php
      $lmo_tabellennotiz="";
    } else {
      echo "&nbsp;";
    }?>
            </td>
            <td>&nbsp;</td>
            <td align="right"><?php echo $dummy.$spiele[$i].$dumm2;?></td>
            <td align="right"><?php echo $dummy.$siege[$i].$dumm2;?></td><?php
    if ($hidr!=1) {?>
            <td align="right"><?php echo $dummy.$unent[$i].$dumm2;?></td><?php
    }?>
            <td align="right"><?php echo $dummy.$nieder[$i].$dumm2;?></td><?php
    if ($tabpkt == 0) {?>
            <td width="2">&nbsp;</td>
            <td align="right"><strong><?php echo applyFactor($punkte[$i],$pointsfaktor)?></strong></td><?php
      if ($minus == 2) {?>
            <td align="center" width="4"><strong>:</strong></td>
            <td><strong><?php echo applyFactor($negativ[$i],$pointsfaktor)?></strong></td><?php
      }
    }?>
            <td>&nbsp;</td>
            <td align="right"><?php echo $dummy.applyFactor($etore[$i],$goalfaktor).$dumm2; ?></td>
            <td align="center" width="4"><?php echo $dummy; ?>:<?php echo $dumm2; ?></td>
            <td><?php echo $dummy.applyFactor($atore[$i],$goalfaktor).$dumm2; ?></td>
            <td align="right"><?php echo $dummy.applyFactor($dtore[$i],$goalfaktor).$dumm2; ?></td><?php
    if ($tabpkt==1) {?>
            <td width="2">&nbsp;</td>
            <td align="right"><strong><?php echo applyFactor($punkte[$i],$pointsfaktor)?></strong></td><?php
      if ($minus==2) {?>
            <td align="center" width="4"><strong>:</strong></td>
            <td><strong><?php echo applyFactor($negativ[$i],$pointsfaktor)?></strong></td><?php
      }
    }?>
          </tr><?php
  }?>
          <tr>
            <th style="text-align:center" colspan="<?php echo $breite;?>">
              <input title="<?php echo $text[114] ?>" class="lmo-formular-button" type="submit" name="best" value="<?php echo $text[415];?>">
            </td>
          </tr>
        </table>
      </form>
    </td>
  </tr>
</table><?php
}?>
