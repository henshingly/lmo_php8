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


isset($_POST['newpage'])?                $newpage=trim($_POST['newpage']):                      $newpage=0;
isset($_POST['xtippernick'])?            $xtippernick=trim($_POST['xtippernick']):              $xtippernick="";
isset($_POST['xtippervorname'])?         $xtippervorname=trim($_POST['xtippervorname']):        $xtippervorname="";
isset($_POST['xtippernachname'])?        $xtippernachname=trim($_POST['xtippernachname']):      $xtippernachname="";
isset($_POST['xtipperemail'])?           $xtipperemail=trim($_POST['xtipperemail']):            $xtipperemail="";
isset($_POST['xtipperstrasse'])?         $xtipperstrasse=trim($_POST['xtipperstrasse']):        $xtipperstrasse="";
isset($_POST['xtipperplz'])?             $xtipperplz=trim($_POST['xtipperplz']):                $xtipperplz="";
isset($_POST['xtipperort'])?             $xtipperort=trim($_POST['xtipperort']):                $xtipperort="";
isset($_POST['xtippervereinradio'])?     $xtippervereinradio=trim($_POST['xtippervereinradio']):$xtippervereinradio=0;
isset($_POST['xtippervereinalt'])?       $xtippervereinalt=trim($_POST['xtippervereinalt']):    $xtippervereinalt="";
isset($_POST['xtippervereinneu'])?       $xtippervereinneu=trim($_POST['xtippervereinneu']):    $xtippervereinneu="";
isset($_POST['xtipperpass'])?            $xtipperpass=trim($_POST['xtipperpass']):              $xtipperpass="";
isset($_POST['xtipperpassw'])?           $xtipperpassw=trim($_POST['xtipperpassw']):            $xtipperpassw="";
isset($_POST['xtipperligen'])?           $xtipperligen=$_POST['xtipperligen']:                  $xtipperligen="";


if ($newpage==1) {
  $users = array("");
  $userf = array("");
  $pswfile=PATH_TO_ADDONDIR."/tipp/".$tipp_tippauthtxt;
  $datei = fopen($pswfile,"rb");
  while (!feof($datei)) {
    $zeile = fgets($datei,1000);
    $zeile=trim(chop($zeile));
    if ($zeile!="") {
      if ($zeile!="") {
        array_push($users,$zeile);
      }
      $dummb1 = split("[|]",$zeile);
      if (strtolower($dummb1[0])==strtolower($xtippernick)) {
        $newpage=0;
        // Nick schon vorhanden
        echo "<p class='error'>".$text['tipp'][24]."</p><br>";
      }
      if (strtolower($dummb1[4])==strtolower($xtipperemail)) {
        $newpage=0;
        // Email schon vorhanden
        echo "<p class='error'>".$text['tipp'][201]."</p><br>";
      }
    }
  }
  fclose($datei);
}

if ($newpage==1) {
  if ($xtippernick=="") {
    $newpage=0;
    echo "<p class='error'>".$text['tipp'][112]."</p><br>";
  }
  if (preg_match('/[\W|_]/',$xtippernick)!=0) {
    $newpage=0;
    echo "<p class='error'>".$text['tipp'][109]."</p><br>";
  }
  if ($tipp_realname!=0) {
    $xtippervorname=trim($xtippervorname);
    if ($xtippervorname=="") {
      $newpage=0;
      echo "<p class='error'>".$text['tipp'][66]."</p><br>";
    }
    $xtippernachname=trim($xtippernachname);
    if ($xtippernachname=="") {
      $newpage=0;
      echo "<p class='error'>".$text['tipp'][67]."</p><br>";
    }
    if (strpos($xtippernachname, " ")!=false || strpos($xtippervorname, " ")>-1) {
      $newpage=0;
      echo "<p class='error'>".$text['tipp'][109]."</p><br>";
    }
  }
  if ($tipp_adresse==1) {
    $xtipperstrasse=trim($xtipperstrasse);
    if ($xtipperstrasse=="") {
      $newpage=0;
      echo "<p class='error'>".$text['tipp'][129]."</p><br>";
    }
    $xtipperplz=intval(trim($xtipperplz));
    if ($xtipperplz=="") {
      $newpage=0;
      echo "<p class='error'>".$text['tipp'][130]."</p><br>";
    }
    $xtipperort=trim($xtipperort);
    if ($xtipperort=="") {
      $newpage=0;
      echo "<p class='error'>".$text['tipp'][131]."</p><br>";
    }
  }
  $xtipperemail=trim($xtipperemail);
  if ($xtipperemail=="" || strpos($xtipperemail, " ")>0 || strpos($xtipperemail, "@")<1) {
    $newpage=0;
    echo "<p class='error'>".$text['tipp'][68]."</p><br>";
  }
  $xtipperpass=trim($xtipperpass);
  if ($xtipperpass=="") {
    $newpage=0;
    echo "<p class='error'>".$text['tipp'][69]."</p><br>";
  } else if (strlen($xtipperpass)<3) {
    $newpage=0;
    echo "<p class='error'>".$text['tipp'][73]."</p><br>";
  }
  $xtipperpassw=trim($xtipperpassw);
  if ($xtipperpassw!=$xtipperpass) {
    $newpage=0;
    echo "<p class='error'>".$text['tipp'][70]."</p><br>";
  }
  if ($xtippervereinradio==1) {
    $xtippervereinalt=trim($xtippervereinalt);
    if ($xtippervereinalt=="") {
      $newpage=0;
      echo "<p class='error'>".$text['tipp'][71]."</p><br>";
    } else {
      require(PATH_TO_ADDONDIR."/tipp/lmo-tippcheckteam.php");
    }
  }
  if ($xtippervereinradio==2) {
    $xtippervereinneu=trim($xtippervereinneu);
    if ($xtippervereinneu=="") {
      $newpage=0;
      echo "<p class='error'>".$text['tipp'][72]."</p><br>";
    } else {
      require(PATH_TO_ADDONDIR."/tipp/lmo-tippcheckteam.php");
    }
  }
}

if ($newpage==1) {
  $userf1="";
  
  if ($xtippervereinradio==1) {
    $lmotipperverein=$xtippervereinalt;
  } else if ($xtippervereinradio==2) {
    $lmotipperverein=$xtippervereinneu;
  } else {
    $lmotipperverein="";
  }
  
  $zeile=$xtippernick."|".$xtipperpass."|";
  if ($tipp_freischaltung==0) {
    $zeile.="5|";
  } else {
    $zeile.="|";
  }
  if ($tipp_realname!=-1) {
    $zeile.=$xtippervorname." ".$xtippernachname;
  }
  $zeile.="|".$xtipperemail."|".$lmotipperverein;
  if ($tipp_adresse==1) {
    $zeile.="|$xtipperstrasse|$xtipperplz|$xtipperort";
  } else {
    $zeile.="|||";
  }
  $zeile.="|1|1|EOL";
  array_push($users,$zeile);
  
  if ($xtipperligen!="") {
    foreach($xtipperligen as $key => $value){
      $tippfile=PATH_TO_ADDONDIR."/tipp/".$tipp_dirtipp.$value."_".$xtippernick.".tip";
      $st=-1;
      // keine Tipps schreiben
      require(PATH_TO_ADDONDIR."/tipp/lmo-tippsavefile.php");
      // Tipp-Datei erstellen
      $auswertdatei = fopen(PATH_TO_ADDONDIR."/tipp/".$tipp_dirtipp."auswert/".$value.".aus","ab");
      flock($auswertdatei,2);
      fputs($auswertdatei,"\n[".$xtippernick."]\n");
      fputs($auswertdatei,"Team=".$lmotipperverein."\n");
      fputs($auswertdatei,"Name=".$xtippervorname." ".$xtippernachname."\n");
      flock($auswertdatei,3);
      fclose($auswertdatei);
    }
  }
  $save=-1;
  require(PATH_TO_ADDONDIR."/tipp/lmo-tippsaveauth.php");
  $auswertdatei = fopen(PATH_TO_ADDONDIR."/tipp/".$tipp_dirtipp."auswert/gesamt.aus","ab");
  flock($auswertdatei,2);
  fputs($auswertdatei,"\n[".$xtippernick."]\n");
  fputs($auswertdatei,"Team=".$lmotipperverein."\n");
  fputs($auswertdatei,"Name=".$xtippervorname." ".$xtippernachname."\n");
  flock($auswertdatei,3);
  fclose($auswertdatei);
}
// end ($newpage==1)

?>
<table class="lmomaina" cellspacing="0" cellpadding="0" border="0">
  <tr>
    <td class="lmomain0" colspan="3" align="center"><?=$text['tipp'][0]; ?></td>
  </tr><?
if($newpage!=1){ ?>
  <tr>
    <td class="lmomain1" colspan="3" align="center">
      <form name="lmotippedit" action="<?=$_SERVER['PHP_SELF']; ?>" method="post">
        <input type="hidden" name="action" value="tipp">
        <input type="hidden" name="todo" value="newtipper">
        <input type="hidden" name="newpage" value="<?=(1); ?>">
        <table class="lmosta" width="100%" cellspacing="0" cellpadding="0" border="0">
          <tr>
            <td align="center" class="lmost1"><?=$text['tipp'][13]; ?></td>
          </tr>
          <tr>
            <td align="center" class="lmost3">
              <table width="100%" class="lmostb" cellspacing="0" cellpadding="0" border="0">
                <tr>
                  <td class="lmost5" width="20">&nbsp;</td>
                  <td class="lmost5" align="right"><?=" ".$text['tipp'][23]; ?></td>
                  <td class="lmost5"><input class="lmoadminein" type="text" name="xtippernick" size="25" maxlength="32" value="<?=$xtippernick; ?>"></td>
                </tr><?
  if($tipp_realname!=-1){ ?>
                <tr>
                  <td class="lmost5" width="20">&nbsp;</td>
                  <td class="lmost5" align="right"><?=" ".$text['tipp'][14]; ?></td>
                  <td class="lmost5"><input class="lmoadminein" type="text" name="xtippervorname" size="25" maxlength="32" value="<?=$xtippervorname; ?>"></td>
                </tr>
                <tr>
                  <td class="lmost5" width="20">&nbsp;</td>
                  <td class="lmost5" align="right"><?=" ".$text['tipp'][15]; ?></td>
                  <td class="lmost5"><input class="lmoadminein" type="text" name="xtippernachname" size="25" maxlength="32" value="<?=$xtippernachname; ?>"></td>
                </tr><?
  }
  if($tipp_adresse==1){ ?>
                <tr>
                  <td class="lmost5" width="20">&nbsp;</td>
                  <td class="lmost5" align="right"><?=" ".$text['tipp'][126]; ?></td>
                  <td class="lmost5"><input class="lmoadminein" type="text" name="xtipperstrasse" size="25" maxlength="32" value="<?=$xtipperstrasse; ?>"></td>
                </tr>
                <tr>
                  <td class="lmost5" width="20">&nbsp;</td>
                  <td class="lmost5" align="right"><?=" ".$text['tipp'][127]; ?></td>
                  <td class="lmost5"><input class="lmoadminein" type="text" name="xtipperplz" size="7" maxlength="5" value="<?=$xtipperplz; ?>"></td>
                </tr>
                <tr>
                  <td class="lmost5" width="20">&nbsp;</td>
                  <td class="lmost5" align="right"><?=" ".$text['tipp'][128]; ?></td>
                  <td class="lmost5"><input class="lmoadminein" type="text" name="xtipperort" size="25" maxlength="32" value="<?=$xtipperort; ?>"></td>
                </tr><?
  } ?>
                <tr>
                  <td class="lmost5" width="20">&nbsp;</td>
                  <td class="lmost5" align="right"><?=" ".$text['tipp'][16]; ?></td>
                  <td class="lmost5"><input class="lmoadminein" type="text" name="xtipperemail" size="25" maxlength="64" value="<?=$xtipperemail; ?>"></td>
                </tr>
                <tr>
                  <td class="lmost5" width="20">&nbsp;</td>
                  <td class="lmost5" align="right"><?=" ".$text[308]; ?></td>
                  <td class="lmost5"><input class="lmoadminein" type="password" name="xtipperpass" size="25" maxlength="32" value="<?=$xtipperpass; ?>"></td>
                </tr>
                <tr>
                  <td class="lmost5" width="20">&nbsp;</td>
                  <td class="lmost5" align="right"><?=" ".$text[308]." ".$text['tipp'][19]; ?></td>
                  <td class="lmost5"><input class="lmoadminein" type="password" name="xtipperpassw" size="25" maxlength="32" value="<?=$xtipperpassw; ?>"></td>
                </tr><?
  if($tipp_tipperimteam>=0){ ?>
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
                      <option value="" <?if($xtippervereinalt==""){echo "selected";}?>><?=$text['tipp'][51]?></option><?
                      require(PATH_TO_ADDONDIR."/tipp/lmo-tippnewteams.php");?>
                    </select>
                  </td>
                </tr>
                <tr>
                  <td class="lmost5" width="20">&nbsp;</td>
                  <td class="lmost5"><input type="radio" name="xtippervereinradio" value="2" <?if($xtippervereinradio==2){echo "checked";} ?>><?=$text['tipp'][49]; ?></td>
                  <td class="lmost5"><input class="lmoadminein" type="text" name="xtippervereinneu" size="25" maxlength="32" value="<?=$xtippervereinneu; ?>" onFocus="xtippervereinradio[2].checked=true"></td>
                </tr><?
  } ?>
                <tr>
                  <td class="lmost4" align="left" colspan="3"><?=$text['tipp'][18]; ?></td>
                </tr>
                <tr>
                  <td class="lmost5" width="20">&nbsp;</td>
                  <td class="lmost5" colspan="2"><?$ftype=".l98"; require(PATH_TO_ADDONDIR."/tipp/lmo-tippnewdir.php"); ?></td>
                </tr>
                <tr>
                  <td class="lmost4" colspan="2"><a href="<?=$_SERVER['PHP_SELF']."?action=tipp"; ?>" title="<?=$text['tipp'][110]; ?>"><?="&lt;&lt; ".$text['tipp'][110]; ?></a></td>
                  <td class="lmost4"><input class="lmoadminbut" type="submit" name="xtippersub" value="<?=$text['tipp'][11]; ?>"></td>
                </tr>
              </table>
            </td>
          </tr>
        </table>
      </form>
    </td>
  </tr>
<?
 $_SESSION["lmotipperok"]=0;
}
if($newpage==1){ // Anmeldung erfolgreich
  $lmotippername=$xtippernick;
  $_SESSION["lmotipperpass"]="";
  $_SESSION["lmotipperok"]=5;
?>
  <tr>
    <td class="lmomain1" colspan="3" align="center">
      <table class="lmosta" width="100%" cellspacing="0" cellpadding="0" border="0">
        <tr>
          <td align="center" class="lmost1"><?=$text['tipp'][13]; ?></td>
        </tr>
        <tr>
          <td align="center" class="lmost3">
            <table width="100%" class="lmostb" cellspacing="0" cellpadding="0" border="0">
              <tr>
                <td class="lmost5" align="center">  <?=$text['tipp'][20]; ?></td>
              </tr>
              <tr>
                <td class="lmost4" align="right"><a href="<?=$_SERVER['PHP_SELF']; ?>?action=tipp&amp;todo=logout&amp;">=> <?=$text['tipp'][21]; ?></a></td>
              </tr>
            </table>
          </td>
        </tr>
      </table>
    </td>
  </tr><?
} 
clearstatcache();?>
</table>