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
  
  
require_once(PATH_TO_ADDONDIR."/tipp/lmo-tipptest.php");
if (($action == "tipp") && ($todo == "daten")) {
  
  isset($_POST['newpage'])?                $newpage=trim($_POST['newpage']):                      $newpage=0;
  isset($_POST['xtippervorname'])?         $xtippervorname=trim($_POST['xtippervorname']):        $xtippervorname="";
  isset($_POST['xtippernachname'])?        $xtippernachname=trim($_POST['xtippernachname']):      $xtippernachname="";
  isset($_POST['xtipperemail'])?           $xtipperemail=trim($_POST['xtipperemail']):            $xtipperemail="";
  isset($_POST['xtipperstrasse'])?         $xtipperstrasse=trim($_POST['xtipperstrasse']):        $xtipperstrasse="";
  isset($_POST['xtipperplz'])?             $xtipperplz=trim($_POST['xtipperplz']):                $xtipperplz="";
  isset($_POST['xtipperort'])?             $xtipperort=trim($_POST['xtipperort']):                $xtipperort="";
  isset($_POST['xtippervereinradio'])?     $xtippervereinradio=trim($_POST['xtippervereinradio']):$xtippervereinradio=0;
  isset($_POST['xtippervereinalt'])?       $xtippervereinalt=trim($_POST['xtippervereinalt']):    $xtippervereinalt="";
  isset($_POST['xtippervereinneu'])?       $xtippervereinneu=trim($_POST['xtippervereinneu']):    $xtippervereinneu="";
  isset($_POST['xtipperligen'])?           $xtipperligen=$_POST['xtipperligen']:                  $xtipperligen="";
  if ($tipp_freischaltcode==1) {
    isset($_POST['xtipperemail2'])?        $xtipperemail2=trim($_POST['xtipperemail2']):          $xtipperemail2="";
  } else {
    $xtipperemail2=$xtipperemail;
  }
  
  $users = array("");
  $pswfile = PATH_TO_ADDONDIR."/tipp/".$tipp_tippauthtxt;
  if ($datei = fopen($pswfile, "rb")) {
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
  }
  $tipp_tipper_gefunden = 0;
  $xtippernick="";
  for($i = 1; $i < count($users) && $tipp_tipper_gefunden == 0; $i++) {
    $tipp_tipper_daten = split("[|]", $users[$i]);
    if ($lmotippername == $tipp_tipper_daten[0]) {
      // Nick gefunden
      $tipp_tipper_gefunden = 1;
      $xtippernick=$tipp_tipper_daten[0];
      $save = $i;
    }
  }
  if ($tipp_tipper_gefunden == 0) {
    exit;
  }

  if ($newpage != 1) {
    if ($tipp_tipper_daten[5] == "") {
      $xtippervereinradio = 0;
    } else {
      $xtippervereinradio = 1;
      $xtippervereinalt = $tipp_tipper_daten[5];
    }
  }
  if ($newpage == 1) {
    if ($tipp_realname != 0) {
      if ($xtippervorname == "") {
        $newpage = 0;
        echo '<p class="error"><img src="'.URL_TO_IMGDIR.'/wrong.gif" border="0" width="12" height="12" alt=""> '.$text['tipp'][66]."</p>";
      }
      if ($xtippernachname == "") {
        $newpage = 0;
        echo '<p class="error"><img src="'.URL_TO_IMGDIR.'/wrong.gif" border="0" width="12" height="12" alt=""> '.$text['tipp'][67]."</p>";
      }
      if (strpos($xtippernachname, " ") != false || strpos($xtippervorname, " ") > -1) {
        $newpage = 0;
        echo '<p class="error"><img src="'.URL_TO_IMGDIR.'/wrong.gif" border="0" width="12" height="12" alt=""> '.$text['tipp'][109]."</p>";
      }
    }
    if ($tipp_adresse == 1) {
      if ($xtipperstrasse == "") {
        $newpage = 0;
        echo '<p class="error"><img src="'.URL_TO_IMGDIR.'/wrong.gif" border="0" width="12" height="12" alt=""> '.$text['tipp'][129]."</p>";
      }
      if ($xtipperplz == "") {
        $newpage = 0;
        echo '<p class="error"><img src="'.URL_TO_IMGDIR.'/wrong.gif" border="0" width="12" height="12" alt=""> '.$text['tipp'][130]."</p>";
      }
      if ($xtipperort == "") {
        $newpage = 0;
        echo '<p class="error"><img src="'.URL_TO_IMGDIR.'/wrong.gif" border="0" width="12" height="12" alt=""> '.$text['tipp'][131]."</p>";
      }
    }
    if ($xtipperemail=="" || strpos($xtipperemail, " ")>0 || strpos($xtipperemail, "@")<1 || $xtipperemail!= $xtipperemail2) {
      $newpage = 0;
      echo '<p class="error"><img src="'.URL_TO_IMGDIR.'/wrong.gif" border="0" width="12" height="12" alt=""> '.$text['tipp'][68]."</p>";
    }
    if ($xtippervereinradio == 1) {
      if ($xtippervereinalt == "") {
        $newpage = 0;
        echo '<p class="error"><img src="'.URL_TO_IMGDIR.'/wrong.gif" border="0" width="12" height="12" alt=""> '.$text['tipp'][71]."</p>";
      } else {
        require(PATH_TO_ADDONDIR."/tipp/lmo-tippcheckteam.php");
      }
    }
    if ($xtippervereinradio == 2) {
      $xtippervereinneu = trim($xtippervereinneu);
      if ($xtippervereinneu == "") {
        $newpage = 0;
        echo '<p class="error"><img src="'.URL_TO_IMGDIR.'/wrong.gif" border="0" width="12" height="12" alt=""> '.$text['tipp'][72]."</p>";
      } else {
        require(PATH_TO_ADDONDIR."/tipp/lmo-tippcheckteam.php");
      }
    }
    $xtipperpass=$tipp_tipper_daten[1];
    if ($tipp_freischaltcode!=1 && $xtipperemail!=$tipp_tipper_daten[4]) {
      $tipp_tipper_daten[1]=substr(md5(uniqid(rand())),0,rand(8,16));
      $xtipperpass=$tipp_tipper_daten[1];
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
    $users[$save] = $tipp_tipper_daten[0]."|".$tipp_tipper_daten[1]."|".$tipp_tipper_daten[2]."|";
    if ($tipp_realname != -1) {
      $users[$save] = $users[$save].$xtippervorname." ".$xtippernachname;
    }
    $users[$save] = $users[$save]."|".$xtipperemail."|".$lmotipperverein;
    if ($tipp_adresse == 1) {
      $users[$save] .= "|".$xtipperstrasse."|".$xtipperplz."|".$xtipperort;
    } else {
      $users[$save] .= "|".$tipp_tipper_daten[6]."|".$tipp_tipper_daten[7]."|".$tipp_tipper_daten[8];
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
    /**Freischaltcode versenden*/
    if ($tipp_freischaltcode!=1 && $xtipperemail!=$tipp_tipper_daten[4]) {
      include(PATH_TO_ADDONDIR."/tipp/lmo-admintippfreischaltung.php");
    }
    
  } // end ($newpage==1)
?>
<table class="lmoInner" width="100%" cellspacing="0" cellpadding="0" border="0">
  <caption><?=$lmotippername;if($lmotipperverein!=""){echo " - ".$lmotipperverein;} ?></caption>
  <tr>
    <th align="center"><?=$text['tipp'][106];if($tipp_tipperimteam>=0){echo " / ".$text['tipp'][2];} ?></th>
  </tr><?
  if($newpage!=1){ ?>
  <tr>
    <td align="center">
      <form name="lmotippedit" action="<?=$_SERVER['PHP_SELF']; ?>" method="post">
        <input type="hidden" name="action" value="tipp">
        <input type="hidden" name="todo" value="daten">
        <input type="hidden" name="newpage" value="1">
        <table class="lmoInner" cellspacing="0" cellpadding="0" border="0"><?
    if($tipp_realname!=0){ ?>
          <tr>
            <td width="20">&nbsp;</td>
            <td class="nobr" align="right"><?=" ".$text['tipp'][14]; ?> &nbsp;</td>
            <td class="nobr" align="left"><input class="lmo-formular-input" type="text" name="xtippervorname" size="25" maxlength="32" value="<?=substr($tipp_tipper_daten[3],0,strpos($tipp_tipper_daten[3]," ")); ?>"> &nbsp;</td>
          </tr>
          <tr>
            <td width="20">&nbsp;</td>
            <td class="nobr" align="right"><?=" ".$text['tipp'][15]; ?> &nbsp;</td>
            <td class="nobr" align="left"><input class="lmo-formular-input" type="text" name="xtippernachname" size="25" maxlength="32" value="<?=substr($tipp_tipper_daten[3],strpos($tipp_tipper_daten[3]," ")+1); ?>"> &nbsp;</td>
          </tr>
<?  }
    if($tipp_adresse==1){ ?>
          <tr>
            <td width="20">&nbsp;</td>
            <td class="nobr" align="right"><?=" ".$text['tipp'][126]; ?> &nbsp;</td>
            <td class="nobr" align="left"><input class="lmo-formular-input" type="text" name="xtipperstrasse" size="25" maxlength="32" value="<?=$tipp_tipper_daten[6]; ?>"> &nbsp;</td>
          </tr>
          <tr>
            <td width="20">&nbsp;</td>
            <td class="nobr" align="right"><?=" ".$text['tipp'][127]; ?> &nbsp;</td>
            <td class="nobr" align="left"><input class="lmo-formular-input" type="text" name="xtipperplz" size="7" maxlength="5" value="<?=$tipp_tipper_daten[7]; ?>"> &nbsp;</td>
          </tr>
          <tr>
            <td width="20">&nbsp;</td>
            <td class="nobr" align="right"><?=" ".$text['tipp'][128]; ?> &nbsp;</td>
            <td class="nobr" align="left"><input class="lmo-formular-input" type="text" name="xtipperort" size="25" maxlength="32" value="<?=$tipp_tipper_daten[8]; ?>"> &nbsp;</td>
          </tr>
<?  } ?>
          <tr>
            <td width="20">&nbsp;</td>
            <td class="nobr" align="right"><?=" ".$text['tipp'][16]; ?> &nbsp;</td>
            <td class="nobr" align="left"><input class="lmo-formular-input" type="text" name="xtipperemail" size="25" maxlength="64" value="<?=$tipp_tipper_daten[4]; ?>"> &nbsp;</td>
          </tr><?
    if ($tipp_freischaltcode==1) {?>
          <tr>
            <td width="20">&nbsp;</td>
            <td align="right"><acronym title="<?=$text['tipp'][300]?>"><?=" ".$text['tipp'][16]." ".$text['tipp'][19]; ?></acronym></td>
            <td align="left"><input class="lmo-formular-input" type="text" name="xtipperemail2" size="25" maxlength="64" value="<?=$tipp_tipper_daten[4]; ?>"></td>
          </tr><?
    } ?>
          <tr>
            <th align="left" colspan="3"><?=$text['tipp'][207]; ?></th>
          </tr>
          <tr>
            <td width="20">&nbsp;</td>
            <td>&nbsp;</td>
            <td class="nobr" align="left">
            <input type="checkbox" name="xnews" value="1" <?if($tipp_tipper_daten[9]!=-1){echo "checked";} ?>><?=$text['tipp'][206] ?><br>
            <input type="checkbox" name="xremind" value="1" <?if($tipp_tipper_daten[10]!=-1){echo "checked";} ?>><?=$text['tipp'][167] ?>
            </td>
          </tr><?  
    if($tipp_tipperimteam>=0){ ?>
          <tr>
            <th align="left" colspan="3"><?=$text['tipp'][47]; ?></th>
          </tr>
          <tr>
            <td width="20">&nbsp;</td>
            <td class="nobr" colspan="2" align="left"><input type="radio" name="xtippervereinradio" value="0" <?if($xtippervereinradio==0){echo "checked";} ?>> <?=$text['tipp'][50]; ?></td>
          </tr>
          <tr>
            <td width="20">&nbsp;</td>
            <td class="nobr" align="left"><input type="radio" name="xtippervereinradio" value="1" <?if($xtippervereinradio==1){echo "checked";} ?>> <?=$text['tipp'][48]; ?> &nbsp;</td>
            <td class="nobr" align="left">
              <select name="xtippervereinalt" onChange="xtippervereinradio[1].checked=true">
      <?
      echo "<option value='' "; if($xtippervereinalt==""){echo "selected";} echo ">".$text['tipp'][51]."</option>";
      require(PATH_TO_ADDONDIR."/tipp/lmo-tippnewteams.php");
      ?>
              </select>
            </td>
          </tr>
          <tr>
            <td width="20">&nbsp;</td>
            <td class="nobr" align="left"><input type="radio" name="xtippervereinradio" value="2" <?if($xtippervereinradio==2){echo "checked";} ?>><?=$text['tipp'][49]; ?></td>
            <td class="nobr" align="left"><input class="lmo-formular-input" type="text" name="xtippervereinneu" size="25" maxlength="32" value="<?=$xtippervereinneu; ?>" onFocus="xtippervereinradio[2].checked=true"></td>
          </tr><?
    }
    if($tipp_tipper_gefunden==1){ ?>
          <tr>
            <td class="lmost4" colspan="3" align="right">
              <input class="lmo-formular-button" type="submit" name="xtippersub" value="<?=$text[329]; ?>">
            </td>
          </tr>
          <tr>
            <td class="error" colspan="3" align="left"><?="<strong>".$text['tipp'][82]."</strong> ".$text['tipp'][137]; ?></td>
          </tr>
<?  } ?>
        </table>
      </form>
    </td>
  </tr><?
  } else { /* Anmeldung erfolgreich */?>
  <tr>
    <td class="message" align="center"><img src="<?=URL_TO_IMGDIR?>/right.gif" border="0" width="12" height="12" alt="">  <?=$text['tipp'][121]; ?></td>
  </tr>
  <tr>
    <td class="lmoFooter" align="right"><a href="<?=$_SERVER['PHP_SELF']."?action=tipp&amp;todo=" ?>"><?=$text[5]." ".$text['tipp'][1]; ?></a></td>
  </tr><?
  }?>
</table><?
} 
$file=""; ?>