<?
// 
// LigaManager Online 3.02
// Copyright (C) 1997-2002 by Frank Hollwitz
// webmaster@hollwitz.de / http://php.hollwitz.de
// 
// Tippspiel-AddOn 1.20
// Copyright (C) 2002 by Frank Albrecht
// fkalbrecht@web.de
// 
// This program is free software; you can redistribute it and/or
// modify it under the terms of the GNU General Public License as
// published by the Free Software Foundation; either version 2 of
// the License, or (at your option) any later version.
// 
// This program is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
// General Public License for more details.
// 
// You should have received a copy of the GNU General Public License
// along with this program; if not, write to the Free Software
// Foundation, Inc., 675 Mass Ave, Cambridge, MA 02139, USA.
// 
require_once(PATH_TO_ADDONDIR."/tipp/lmo-tipptest.php");
if (($action == "tipp") && ($todo == "daten")) {
  if (!isset($xtippervereinalt)) {
    $xtippervereinalt = "";
  }
  if (!isset($xtippervereinneu)) {
    $xtippervereinneu = "";
  }
  $users = array("");
  $pswfile = PATH_TO_ADDONDIR."/tipp/".$tipp_tippauthtxt;
  $datei = fopen($pswfile, "rb");
  while (!feof($datei)) {
    $zeile = fgets($datei, 1000);
    $zeile = trim(chop($zeile));
    if ($zeile != "") {
      if ($zeile != "") {
        array_push($users, $zeile);
      }
    }
  }
  fclose($datei);
  $gef = 0;
  for($i = 1; $i < count($users) && $gef == 0; $i++) {
    $dummb = split("[|]", $users[$i]);
    if ($lmotippername == $dummb[0]) {
      // Nick gefunden
      $gef = 1;
      $save = $i;
    }
  }
  if ($gef == 0) {
    exit;
  }
   
  if ($newpage != 1) {
    if ($dummb[5] == "") {
      $xtippervereinradio = 0;
    } else {
      $xtippervereinradio = 1;
      $xtippervereinalt = $dummb[5];
    }
  }
  if ($newpage == 1) {
    if ($tipp_realname != -1) {
      $xtippervorname = trim($xtippervorname);
      if ($xtippervorname == "") {
        $newpage = 0;
        echo "<p class='error'>".$text['tipp'][66]."</p><br>";
      }
      $xtippernachname = trim($xtippernachname);
      if ($xtippernachname == "") {
        $newpage = 0;
        echo "<p class='error'>".$text['tipp'][67]."</p><br>";
      }
      if (strpos($xtippernachname, " ") != false || strpos($xtippervorname, " ") > -1) {
        $newpage = 0;
        echo "<p class='error'>".$text['tipp'][109]."</p><br>";
      }
    }
    if ($tipp_adresse == 1) {
      $xtipperstrasse = trim($xtipperstrasse);
      if ($xtipperstrasse == "") {
        $newpage = 0;
        echo "<p class='error'>".$text['tipp'][129]."</p><br>";
      }
      $xtipperplz = intval(trim($xtipperplz));
      if ($xtipperplz == "") {
        $newpage = 0;
        echo "<p class='error'>".$text['tipp'][130]."</p><br>";
      }
      $xtipperort = trim($xtipperort);
      if ($xtipperort == "") {
        $newpage = 0;
        echo "<p class='error'>".$text['tipp'][131]."</p><br>";
      }
    }
    $xtipperemail = trim($xtipperemail);
    if ($xtipperemail == "" || strpos($xtipperemail, " ") > -1 || strpos($xtipperemail, "@") < 1) {
      $newpage = 0;
      echo "<p class='error'>".$text['tipp'][68]."</p><br>";
    }
    if ($xtippervereinradio == 1) {
      $xtippervereinalt = trim($xtippervereinalt);
      if ($xtippervereinalt == "") {
        $newpage = 0;
        echo "<p class='error'>".$text['tipp'][71]."</p><br>";
      } else {
        require(PATH_TO_ADDONDIR."/tipp/lmo-tippcheckteam.php");
      }
    }
    if ($xtippervereinradio == 2) {
      $xtippervereinneu = trim($xtippervereinneu);
      if ($xtippervereinneu == "") {
        $newpage = 0;
        echo "<p class='error'>".$text['tipp'][72]."</p><br>";
      } else {
        require(PATH_TO_ADDONDIR."/tipp/lmo-tippcheckteam.php");
      }
    }
  }
   
  if ($newpage == 1) {
    if ($xtippervereinradio == 1) {
      $lmotipperverein = $xtippervereinalt;
    } elseif($xtippervereinradio == 2) {
      $lmotipperverein = $xtippervereinneu;
    } else {
      $lmotipperverein = "";
    }
    $users[$save] = $dummb[0]."|".$dummb[1]."|".$dummb[2]."|";
    if ($tipp_realname != -1) {
      $users[$save] = $users[$save].$xtippervorname." ".$xtippernachname;
    }
    $users[$save] = $users[$save]."|".$xtipperemail."|".$lmotipperverein;
    if ($tipp_adresse == 1) {
      $users[$save] .= "|".$xtipperstrasse."|".$xtipperplz."|".$xtipperort;
    } else {
      $users[$save] .= "|".$dummb[6]."|".$dummb[7]."|".$dummb[8];
    }
    $users[$save] .= "|";
    if (trim($_POST["xnews"]) == 1) {
      $users[$save] .= "1";
    } else {
      $users[$save] .= "-1";
    }
    $users[$save] .= "|";
    if (trim($_POST["xremind"]) == 1) {
      $users[$save] .= "1";
    } else {
      $users[$save] .= "-1";
    }
    $users[$save] .= "|EOL";
    require(PATH_TO_ADDONDIR."/tipp/lmo-tippsaveauth.php");
  } // end ($newpage==1)
?>
<table class="lmoMiddle" width="100%" cellspacing="0" cellpadding="0" border="0">
  <tr>
    <td align="center" class="active">
      <?=$lmotippername;if($lmotipperverein!=""){echo " - ".$lmotipperverein;} ?>
    </td>
  </tr>
  <tr><td align="center" class="active"><?=$text['tipp'][106];if($tipp_tipperimteam>=0){echo " / ".$text['tipp'][2];} ?></td></tr>
  <tr>
    <td align="center">
      <form name="lmotippedit" action="<?=$_SERVER['PHP_SELF']; ?>" method="post">
        <input type="hidden" name="action" value="tipp">
        <input type="hidden" name="todo" value="daten">
        <input type="hidden" name="newpage" value="1">
        <table class="lmoInner" cellspacing="0" cellpadding="0" border="0">
<?if($newpage!=1){ 
    if($tipp_realname!=-1){ ?>
          <tr>
            <td class="lmost5" width="20">&nbsp;</td>
            <td class="lmost5" align="right"><acronym><?=" ".$text['tipp'][14]; ?></acronym></td>
            <td class="lmost5"><acronym><input class="lmo-formular-input" type="text" name="xtippervorname" size="25" maxlength="32" value="<?=substr($dummb[3],0,strpos($dummb[3]," ")); ?>"></acronym></td>
          </tr>
          <tr>
            <td class="lmost5" width="20">&nbsp;</td>
            <td class="lmost5" align="right"><acronym><?=" ".$text['tipp'][15]; ?></acronym></td>
            <td class="lmost5"><acronym><input class="lmo-formular-input" type="text" name="xtippernachname" size="25" maxlength="32" value="<?=substr($dummb[3],strpos($dummb[3]," ")+1); ?>"></acronym></td>
          </tr>
<?   }
     if($tipp_adresse==1){ ?>
          <tr>
            <td class="lmost5" width="20">&nbsp;</td>
            <td class="lmost5" align="right"><acronym><?=" ".$text['tipp'][126]; ?></acronym></td>
            <td class="lmost5"><acronym><input class="lmo-formular-input" type="text" name="xtipperstrasse" size="25" maxlength="32" value="<?=$dummb[6]; ?>"></acronym></td>
          </tr>
          <tr>
            <td class="lmost5" width="20">&nbsp;</td>
            <td class="lmost5" align="right"><acronym><?=" ".$text['tipp'][127]; ?></acronym></td>
            <td class="lmost5"><acronym><input class="lmo-formular-input" type="text" name="xtipperplz" size="7" maxlength="5" value="<?=$dummb[7]; ?>"></acronym></td>
          </tr>
          <tr>
            <td class="lmost5" width="20">&nbsp;</td>
            <td class="lmost5" align="right"><acronym><?=" ".$text['tipp'][128]; ?></acronym></td>
            <td class="lmost5"><acronym><input class="lmo-formular-input" type="text" name="xtipperort" size="25" maxlength="32" value="<?=$dummb[8]; ?>"></acronym></td>
          </tr>
<?   } ?>
          <tr>
            <td class="lmost5" width="20">&nbsp;</td>
            <td class="lmost5" align="right"><acronym><?=" ".$text['tipp'][16]; ?></acronym></td>
            <td class="lmost5"><acronym><input class="lmo-formular-input" type="text" name="xtipperemail" size="25" maxlength="64" value="<?=$dummb[4]; ?>"></acronym></td>
          </tr>
          <tr>
            <td class="lmost4" align="left" colspan="3"><?=$text['tipp'][207]; ?></td>
          </tr>
          <tr>
            <td class="lmost5" width="20">&nbsp;</td>
            <td class="lmost5">&nbsp;</td>
            <td class="lmost5">
            <input type="checkbox" name="xnews" value="1" <?if($dummb[9]!=-1){echo "checked";} ?>><?=$text['tipp'][206] ?><br>
            <input type="checkbox" name="xremind" value="1" <?if($dummb[10]!=-1){echo "checked";} ?>><?=$text['tipp'][167] ?>
            </td>
          </tr>
<?   if($tipp_tipperimteam>=0){ ?>
          <tr>
            <td class="lmost4" align="left" colspan="3"><?=$text['tipp'][47]; ?></td>
          </tr>
          <tr>
            <td class="lmost5" width="20">&nbsp;</td>
            <td class="lmost5" colspan="2"><input type="radio" name="xtippervereinradio" value="0" <?if($xtippervereinradio==0){echo "checked";} ?>><?=$text['tipp'][50]; ?></td>
          </tr>
          <tr>
            <td class="lmost5" width="20">&nbsp;</td>
            <td class="lmost5"><input type="radio" name="xtippervereinradio" value="1" <?if($xtippervereinradio==1){echo "checked";} ?>><?=$text['tipp'][48]; ?></td>
            <td class="lmost5">
              <select name="xtippervereinalt" onChange="xtippervereinradio[1].checked=true">
      <?
        echo "<option value='' "; if($xtippervereinalt==""){echo "selected";} echo ">".$text['tipp'][51]."</option>";
        require(PATH_TO_ADDONDIR."/tipp/lmo-tippnewteams.php");
      ?>
              </select>
            </td>
          </tr>
          <tr>
            <td class="lmost5" width="20">&nbsp;</td>
            <td class="lmost5"><input type="radio" name="xtippervereinradio" value="2" <?if($xtippervereinradio==2){echo "checked";} ?>><?=$text['tipp'][49]; ?></td>
            <td class="lmost5"><input class="lmo-formular-input" type="text" name="xtippervereinneu" size="25" maxlength="32" value="<?=$xtippervereinneu; ?>" onFocus="xtippervereinradio[2].checked=true"></td>
          </tr>
<?}?>
<?if($gef==1){ ?>
          <tr>
            <td class="lmost4" colspan="3" align="right">
              <input class="lmo-formular-button" type="submit" name="xtippersub" value="<?=$text[329]; ?>">
            </td>
          </tr>
          <tr>
            <td class="lmost5" colspan="3" align="right"><?="<strong>".$text['tipp'][82]."</strong> ".$text['tipp'][137]; ?>
            </td>
          </tr>
<?} ?>
        </table>
      </form>
    </td>
  </tr>
<?} ?>
<?if($newpage==1){ // Anmeldung erfolgreich 
?>
   <tr>
      <td class="lmost5" align="center">  <?=$text['tipp'][121]; ?></td>
   </tr>
   <tr>
      <td class="lmost4" align="right"><a href="<?=$_SERVER['PHP_SELF']."?action=tipp&amp;todo=" ?>"><?=$text[5]." ".$text['tipp'][1]; ?></a></td>
   </tr>
<?} ?>

</table>
<?
} 
$file=""; ?>