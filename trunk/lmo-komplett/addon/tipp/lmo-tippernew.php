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


isset($_POST['newpage'])?                $newpage=trim($_POST['newpage']):                      $newpage=0;
isset($_REQUEST['xtippernick'])?         $xtippernick=trim($_REQUEST['xtippernick']):           $xtippernick="";
isset($_POST['xtippervorname'])?         $xtippervorname=trim($_POST['xtippervorname']):        $xtippervorname="";
isset($_POST['xtippernachname'])?        $xtippernachname=trim($_POST['xtippernachname']):      $xtippernachname="";
isset($_POST['xtipperemail'])?           $xtipperemail=trim($_POST['xtipperemail']):            $xtipperemail="";
isset($_POST['xtipperstrasse'])?         $xtipperstrasse=trim($_POST['xtipperstrasse']):        $xtipperstrasse="";
isset($_POST['xtipperplz'])?             $xtipperplz=trim($_POST['xtipperplz']):                $xtipperplz="";
isset($_POST['xtipperort'])?             $xtipperort=trim($_POST['xtipperort']):                $xtipperort="";
isset($_POST['xtippervereinradio'])?     $xtippervereinradio=trim($_POST['xtippervereinradio']):$xtippervereinradio=0;
isset($_POST['xtippervereinalt'])?       $xtippervereinalt=trim($_POST['xtippervereinalt']):    $xtippervereinalt="";
isset($_POST['xtippervereinneu'])?       $xtippervereinneu=trim($_POST['xtippervereinneu']):    $xtippervereinneu="";
isset($_REQUEST['xtipperpass'])?         $xtipperpass=trim($_REQUEST['xtipperpass']):           $xtipperpass="";
isset($_POST['xtipperpassw'])?           $xtipperpassw=trim($_POST['xtipperpassw']):            $xtipperpassw="";
isset($_POST['xtipperligen'])?           $xtipperligen=$_POST['xtipperligen']:                  $xtipperligen="";
if ($tipp_freischaltcode==1) {
  isset($_POST['xtipperemail2'])?        $xtipperemail2=trim($_POST['xtipperemail2']):          $xtipperemail2="";
} else {
  $xtipperemail2=$xtipperemail;
}

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
      $dummb1 = explode('|',$zeile);
      if (strtolower($dummb1[0])==strtolower($xtippernick)) {
        $newpage=0;
        // Nick schon vorhanden
        echo getMessage($text['tipp'][24],TRUE);
      }
      if (strtolower($dummb1[4])==strtolower($xtipperemail)) {
        $newpage=0;
        // Email schon vorhanden
        echo getMessage($text['tipp'][201],TRUE);
      }
    }
  }
  fclose($datei);
}

if ($newpage==1) {
  if ($xtippernick=="") {
    $newpage=0;
    echo getMessage($text['tipp'][112],TRUE);
  }
  if (preg_match('/[\W|_]/',$xtippernick)!=0) {
    $newpage=0;
    echo getMessage($text['tipp'][109],TRUE);
  }
  if ($tipp_realname!=0) {
    if ($xtippervorname=="") {
      $newpage=0;
      echo getMessage($text['tipp'][66],TRUE);
    }
    if ($xtippernachname=="") {
      $newpage=0;
      echo getMessage($text['tipp'][67],TRUE);
    }
    if (strpos($xtippernachname, " ")!=false || strpos($xtippervorname, " ")>-1) {
      $newpage=0;
      echo getMessage($text['tipp'][109],TRUE);
    }
  }
  if ($tipp_adresse==1) {
    if ($xtipperstrasse=="") {
      $newpage=0;
      echo getMessage($text['tipp'][129],TRUE);
    }
    if ($xtipperplz=="") {
      $newpage=0;
      echo getMessage($text['tipp'][130],TRUE);
    }
    if ($xtipperort=="") {
      $newpage=0;
      echo getMessage($text['tipp'][131],TRUE);
    }
  }
  if ($xtipperemail=="" || strpos($xtipperemail, " ")>0 || strpos($xtipperemail, "@")<1 || $xtipperemail!= $xtipperemail2) {
    $newpage=0;
    echo getMessage($text['tipp'][68],TRUE);
  }
  
  if ($tipp_freischaltcode!=1) {
    if ($xtipperpass=="") {
      $newpage=0;
      echo getMessage($text['tipp'][69],TRUE);
    } else if (strlen($xtipperpass)<3) {
      $newpage=0;
      echo getMessage($text['tipp'][73],TRUE);
    }
    if ($xtipperpassw!=$xtipperpass) {
      $newpage=0;
      echo getMessage($text['tipp'][70],TRUE);
    }
  } else {
    $xtipperpass=substr(md5(uniqid(rand())),0,rand(8,16));
  }
  
  if ($xtippervereinradio==1) {
    if ($xtippervereinalt=="") {
      $newpage=0;
      echo getMessage($text['tipp'][71],TRUE);
    } else {
      require(PATH_TO_ADDONDIR."/tipp/lmo-tippcheckteam.php");
    }
  }
  if ($xtippervereinradio==2) {
    if ($xtippervereinneu=="") {
      $newpage=0;
      echo getMessage($text['tipp'][72],TRUE);
    } else {
      require(PATH_TO_ADDONDIR."/tipp/lmo-tippcheckteam.php");
    }
  }
}

if ($newpage==1) {
  $userf1="";
  
  if ($xtippervereinradio==1) {
    $_SESSION['lmotipperverein']=$xtippervereinalt;
  } else if ($xtippervereinradio==2) {
    $_SESSION['lmotipperverein']=$xtippervereinneu;
  } else {
    $_SESSION['lmotipperverein']="";
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
  $zeile.="|".$xtipperemail."|".$_SESSION['lmotipperverein'];
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
      fputs($auswertdatei,"Team=".$_SESSION['lmotipperverein']."\n");
      fputs($auswertdatei,"Name=".$xtippervorname." ".$xtippernachname."\n");
      flock($auswertdatei,3);
      fclose($auswertdatei);
    }
  }
  $save=-1;
  require(PATH_TO_ADDONDIR."/tipp/lmo-tippsaveauth.php");
  if ($auswertdatei = fopen(PATH_TO_ADDONDIR."/tipp/".$tipp_dirtipp."auswert/gesamt.aus","ab")) {
    flock($auswertdatei,2);
    fputs($auswertdatei,"\n[".$xtippernick."]\n");
    fputs($auswertdatei,"Team=".$_SESSION['lmotipperverein']."\n");
    fputs($auswertdatei,"Name=".$xtippervorname." ".$xtippernachname."\n");
    flock($auswertdatei,3);
    fclose($auswertdatei);
  }
  /**Freischaltcode versenden*/
  if ($tipp_freischaltcode==1) {
    include(PATH_TO_ADDONDIR."/tipp/lmo-admintippfreischaltung.php");
  }
  if ($tipp_mailbeianmeldung==1) {
    include(PATH_TO_ADDONDIR."/tipp/lmo-admintippbenachrichtigung.php");
  }
}
// end ($newpage==1)

?>
<table class="lmoMiddle" cellspacing="0" cellpadding="0" border="0"><?
if($newpage!=1){ ?>
  <tr>
    <td colspan="3" align="center">
      <form name="lmotippedit" action="<?=$_SERVER['PHP_SELF']; ?>" method="post">
        <input type="hidden" name="action" value="tipp">
        <input type="hidden" name="todo" value="newtipper">
        <input type="hidden" name="newpage" value="<?=(1); ?>">
        <table class="lmoInner" cellspacing="0" cellpadding="0" border="0">
          <caption><?=$text['tipp'][13]; ?></caption>
          <tr>
            <td width="20">&nbsp;</td>
            <td align="right"><?=" ".$text['tipp'][23]; ?></td>
            <td align="left"><input class="lmo-formular-input" type="text" name="xtippernick" size="25" maxlength="32" value="<?=$xtippernick; ?>"></td>
          </tr><?
  if($tipp_realname!=0){ ?>
          <tr>
            <td width="20">&nbsp;</td>
            <td align="right"><?=" ".$text['tipp'][14]; ?></td>
            <td align="left"><input class="lmo-formular-input" type="text" name="xtippervorname" size="25" maxlength="32" value="<?=$xtippervorname; ?>"></td>
          </tr>
          <tr>
            <td width="20">&nbsp;</td>
            <td align="right"><?=" ".$text['tipp'][15]; ?></td>
            <td align="left"><input class="lmo-formular-input" type="text" name="xtippernachname" size="25" maxlength="32" value="<?=$xtippernachname; ?>"></td>
          </tr><?
  }
  if($tipp_adresse==1){ ?>
          <tr>
            <td width="20">&nbsp;</td>
            <td align="right"><?=" ".$text['tipp'][126]; ?></td>
            <td align="left"><input class="lmo-formular-input" type="text" name="xtipperstrasse" size="25" maxlength="32" value="<?=$xtipperstrasse; ?>"></td>
          </tr>
          <tr>
            <td width="20">&nbsp;</td>
            <td align="right"><?=" ".$text['tipp'][127]; ?></td>
            <td align="left"><input class="lmo-formular-input" type="text" name="xtipperplz" size="7" maxlength="5" value="<?=$xtipperplz; ?>"></td>
          </tr>
          <tr>
            <td width="20">&nbsp;</td>
            <td align="right"><?=" ".$text['tipp'][128]; ?></td>
            <td align="left"><input class="lmo-formular-input" type="text" name="xtipperort" size="25" maxlength="32" value="<?=$xtipperort; ?>"></td>
          </tr><?
  } ?>
          <tr>
            <td width="20">&nbsp;</td>
            <td align="right"><?=" ".$text['tipp'][16]; ?></td>
            <td align="left"><input class="lmo-formular-input" type="text" name="xtipperemail" size="25" maxlength="64" value="<?=$xtipperemail; ?>"></td>
          </tr><?
  if ($tipp_freischaltcode==1) {?>
          <tr>
            <td width="20">&nbsp;</td>
            <td align="right"><acronym title="<?=$text['tipp'][300]?>"><?=" ".$text['tipp'][16]." ".$text['tipp'][19]; ?></acronym></td>
            <td align="left"><input class="lmo-formular-input" type="text" name="xtipperemail2" size="25" maxlength="64" value="<?=$xtipperemail2; ?>"></td>
          </tr><?
  } else{ ?>
          <tr>
            <td width="20">&nbsp;</td>
            <td align="right"><?=" ".$text[308]; ?></td>
            <td align="left"><input class="lmo-formular-input" type="password" name="xtipperpass" size="25" maxlength="32" value="<?=$xtipperpass; ?>"></td>
          </tr>
          <tr>
            <td width="20">&nbsp;</td>
            <td align="right"><?=" ".$text[308]." ".$text['tipp'][19]; ?></td>
            <td align="left"><input class="lmo-formular-input" type="password" name="xtipperpassw" size="25" maxlength="32" value="<?=$xtipperpassw; ?>"></td>
          </tr><?
  }
  if($tipp_tipperimteam>=0){ ?>
          <tr>
            <th align="left" colspan="3"><?=$text['tipp'][47]; ?></th>
          </tr>
          <tr>
            <td width="20">&nbsp;</td>
            <td colspan="2" align="left"><input type="radio" name="xtippervereinradio" value="0" <?if($xtippervereinradio==0){echo "checked";} ?>><?=$text['tipp'][50]; ?></td>
          </tr>
          <tr>
            <td width="20">&nbsp;</td>
            <td align="left"><input type="radio" name="xtippervereinradio" value="1" <?if($xtippervereinradio==1){echo "checked";} ?>><?=$text['tipp'][48]; ?></td>
            <td align="left">
              <select name="xtippervereinalt" onChange="xtippervereinradio[1].checked=true">
                <option value="" <?if($xtippervereinalt==""){echo "selected";}?>><?=$text['tipp'][51]?></option><?
                require(PATH_TO_ADDONDIR."/tipp/lmo-tippnewteams.php");?>
              </select>
            </td>
          </tr>
          <tr>
            <td width="20">&nbsp;</td>
            <td align="left"><input type="radio" name="xtippervereinradio" value="2" <?if($xtippervereinradio==2){echo "checked";} ?>><?=$text['tipp'][49]; ?></td>
            <td align="left"><input class="lmo-formular-input" type="text" name="xtippervereinneu" size="25" maxlength="32" value="<?=$xtippervereinneu; ?>" onFocus="xtippervereinradio[2].checked=true"></td>
          </tr><?
  } ?>
          <tr>
            <th align="left" colspan="3"><?=$text['tipp'][18]; ?></th>
          </tr>
          <tr>
            <td width="20">&nbsp;</td>
            <td colspan="2" align="left"><?$ftype=".l98"; require(PATH_TO_ADDONDIR."/tipp/lmo-tippnewdir.php"); ?></td>
          </tr>
          <tr>      
            <td align="center" colspan="3"><input class="lmo-formular-button" type="submit" name="xtippersub" value="<?=$text['tipp'][11]; ?>"></td>
          </tr>
          <tr>
            <td align="left" class="lmoFooter" colspan="3"><a href="<?=$_SERVER['PHP_SELF']."?action=tipp"; ?>" title="<?=$text['tipp'][110]; ?>">« <?=$text['tipp'][110]; ?></a></td>
          </tr>
        </table>
      </form>
    </td>
  </tr>
<?
//$_SESSION["lmotipperok"] = 0; 
}
if($newpage==1){ // Anmeldung erfolgreich
  $_SESSION['lmotippername']=$xtippernick;
  $_SESSION["lmotipperpass"]="";
  $_SESSION["lmotipperok"]=5;
?>
  <tr>
    <td align="center">
      <table width="100%" class="lmoInner" cellspacing="0" cellpadding="0" border="0">
        <caption><?=$text['tipp'][13]; ?></caption>
        <tr>
          <td align="center"><?php echo getMessage($text['tipp'][20]); ?></td>
        </tr>
        <tr>
          <td class="lmoFooter" align="right"><a href="<?=$_SERVER['PHP_SELF']; ?>?action=tipp&amp;todo=logout&amp;">« <?=$text['tipp'][21]; ?></a></td>
        </tr>
      </table>
    </td>
  </tr><?
} 
$_SESSION["lmotipperok"] = 0; 
clearstatcache();?>
</table>