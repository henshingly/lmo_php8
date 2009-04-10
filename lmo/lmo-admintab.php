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
  * $Id$
  */


require_once(PATH_TO_LMO."/lmo-admintest.php");
if ($file != "") {

  require_once(PATH_TO_LMO."/lmo-openfile.php");
  $breite = 16;
  if ($hidr != 1) {
    $breite = $breite-1;
  }
  if ($minus == 2) {
    $dummy = " colspan=\"3\" align=\"center\"";
    $breite = $breite+2;
  } else {
    $dummy = " align=\"right\"";
  }
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
  $breite = 16;
  if ($spez == 1) {
    $breite = $breite+2;
  }
  include(PATH_TO_LMO."/lmo-adminsubnavi.php");?>

<table class="lmoMiddle" cellspacing="0" cellpadding="0" border="0">
  <tr>
    <td align="center"><h1><?=$titel?></h1></td>
  </tr>
  <tr>
    <td align="center"><?include (PATH_TO_LMO."/lmo-spieltagsmenu.php");?></td>
  </tr>
  <tr>
    <td align="center">
      <form name="lmoedit" action="<?=$_SERVER['PHP_SELF'];?>" method="post" onSubmit="return chklmopas2(<?=$anzteams;?>)">
        <input type="hidden" name="action" value="admin">
        <input type="hidden" name="todo" value="tabs">
        <input type="hidden" name="save" value="1">
        <input type="hidden" name="file" value="<?=$file;?>">
        <input type="hidden" name="st" value="<?=$st;?>">
        <table class="lmoInner" cellspacing="0" cellpadding="0" border="0">
          <tr>
            <th align="left" colspan="4"><?=$st.". ".$text[2];?></th>
            <th align="left" width="2">&nbsp;</th>
            <th align="right"><?=$text[33];?></th>
            <th align="right"><?=$text[34];?></th><?
  if($hidr!=1){ ?>
            <th align="right"><?=$text[35];?></th><?
  }?>
            <th align="right"><?=$text[36];?></th><?
  if($tabpkt==0){ ?>
            <th>&nbsp;</th>
            <th <?=$dummy?>><?=$text[37]?></th><?
  }?>
            <th align="left" width="2">&nbsp;</th>
            <th align="left" colspan="3" align="center"><?=$text[38];?></th>
            <th align="right"><?=$text[39];?></th><?
  if($tabpkt==1){ ?>
            <th>&nbsp;</th>
            <th <?=$dummy?>><?=$text[37]?></th><?
  }?>
          </tr><?
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
          <tr>
            <td align="right">
              <select title="<?=$text[414] ?>" class="lmo-formular-input" name="xplatz<?=$x;?>" onChange="dolmoedi2(<?=$anzteams;?>,'xplatz<?=$x;?>')"><?
    for($y=1;$y<=$anzteams;$y++){?>
                <option value="<?=$y?>" <?if($y==$handt[$x]){echo " selected";}?>><?=$y?></option>
                <?
    }?>
              </select>
            </td>
            <td class="nobr"><?=$dummy.$teams[$i].$dumm2;?></td>
            <td>&nbsp;</td>
            <td><?
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
        $lmo_tabellennotiz.="\n\n<strong>".$text[22].":</strong> ".$teamn[$i];
      }?>
        <a href='#' onclick="alert('<?=mysql_escape_string(htmlentities(strip_tags($lmo_tabellennotiz)))?>');window.focus();return false;"><img src='<?=URL_TO_IMGDIR."/lmo-st2.gif"?>' width='10' height='12' border='0' alt=''><span class='popup'><?=nl2br($lmo_tabellennotiz)?></span></a><?
      $lmo_tabellennotiz="";
    } else {
      echo "&nbsp;";
    }?>
            </td>
            <td>&nbsp;</td>
            <td align="right"><?=$dummy.$spiele[$i].$dumm2;?></td>
            <td align="right"><?=$dummy.$siege[$i].$dumm2;?></td><?
    if($hidr!=1){ ?>
            <td align="right"><?=$dummy.$unent[$i].$dumm2;?></td><?
    }?>
            <td align="right"><?=$dummy.$nieder[$i].$dumm2;?></td><?
    if ($tabpkt == 0) {?>
            <td width="2">&nbsp;</td>
            <td align="right"><strong><?=applyFactor($punkte[$i],$pointsfaktor)?></strong></td><?
      if ($minus == 2) {?>
            <td align="center" width="4"><strong>:</strong></td>
            <td><strong><?=applyFactor($negativ[$i],$pointsfaktor)?></strong></td><?
      }
    }?>
            <td>&nbsp;</td>
            <td align="right"><?=$dummy.applyFactor($etore[$i],$goalfaktor).$dumm2; ?></td>
            <td align="center" width="4"><?=$dummy; ?>:<?=$dumm2; ?></td>
            <td><?=$dummy.applyFactor($atore[$i],$goalfaktor).$dumm2; ?></td>
            <td align="right"><?=$dummy.applyFactor($dtore[$i],$goalfaktor).$dumm2; ?></td><?
    if($tabpkt==1){?>
            <td width="2">&nbsp;</td>
            <td align="right"><strong><?=applyFactor($punkte[$i],$pointsfaktor)?></strong></td><?
      if($minus==2){?>
            <td align="center" width="4"><strong>:</strong></td>
            <td><strong><?=applyFactor($negativ[$i],$pointsfaktor)?></strong></td><?
      }
    }?>
          </tr><?
  }?>
          <tr>
            <th align="right" colspan="<?=$breite;?>" align="center">
              <input title="<?=$text[114] ?>" class="lmo-formular-button" type="submit" name="best" value="<?=$text[415];?>">
            </td>
          </tr>
        </table>
      </form>
    </td>
  </tr>
</table><?
}?>