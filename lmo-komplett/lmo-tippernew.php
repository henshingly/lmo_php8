<?PHP
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
require_once("lmo-tipptest.php");

  if(!isset($newpage)){$newpage=0;}
  if(!isset($xtippernick)){$xtippernick="";}
  if(!isset($xtippervorname)){$xtippervorname="";}
  if(!isset($xtippernachname)){$xtippernachname="";}
  if(!isset($xtipperemail)){$xtipperemail="";}
  if(!isset($xtipperstrasse)){$xtipperstrasse="";}
  if(!isset($xtipperplz)){$xtipperplz="";}
  if(!isset($xtipperort)){$xtipperort="";}
  if(!isset($xtippervereinradio)){$xtippervereinradio=0;}
  if(!isset($xtippervereinalt)){$xtippervereinalt="";}
  if(!isset($xtippervereinneu)){$xtippervereinneu="";}
  if(!isset($xtipperpass)){$xtipperpass="";}
  if(!isset($xtipperpassw)){$xtipperpassw="";}
  if(!isset($xtipperligen)){$xtipperligen="";}

  if($newpage==1){
    $users = array("");
    $userf = array("");
    $pswfile=$tippauthtxt;
    $datei = fopen($pswfile,"rb");
    while (!feof($datei)) {
      $zeile = fgets($datei,1000);
      $zeile=trim(chop($zeile));
      if($zeile!=""){
        if($zeile!=""){array_push($users,$zeile);}
	$dummb1 = split("[|]",$zeile);
        if(strtolower($dummb1[0])==strtolower($xtippernick)){
          $newpage=0;   // Nick schon vorhanden
          echo "<font color=red>".$text[524]."</font><br>";
          }
        if(strtolower($dummb1[4])==strtolower($xtipperemail)){
          $newpage=0;   // Email schon vorhanden
          echo "<font color=red>".$text[701]."</font><br>";
          }
        }
      }
    fclose($datei);
    }

  if($newpage==1){
    $xtippernick=trim($xtippernick);
    if($xtippernick==""){
      $newpage=0;
      echo "<font color=red>".$text[612]."</font><br>";
      }
    if(strpos($xtippernick, "-")>-1 || strpos($xtippernick, "_")>-1 || strpos($xtippernick, "/")>-1 || strpos($xtippernick, ".")>-1  || strpos($xtippernick, ",")>-1 || strpos($xtippernick, "\\")>-1){
      $newpage=0;
      echo "<font color=red>".$text[609]."</font><br>";
      }
    if($realname!=-1){
      $xtippervorname=trim($xtippervorname);
      if($xtippervorname==""){
        $newpage=0;
        echo "<font color=red>".$text[566]."</font><br>";
        }
      $xtippernachname=trim($xtippernachname);
      if($xtippernachname==""){
        $newpage=0;
        echo "<font color=red>".$text[567]."</font><br>";
        }
      if(strpos($xtippernachname, " ")!=false || strpos($xtippervorname, " ")>-1){
        $newpage=0;
        echo "<font color=red>".$text[609]."</font><br>";
        }
      }
    if(strpos($xtippernick, " ")>-1){
      $newpage=0;
      echo "<font color=red>".$text[609]."</font><br>";
      }
    if($adresse==1){
      $xtipperstrasse=trim($xtipperstrasse);
      if($xtipperstrasse==""){
        $newpage=0;
        echo "<font color=red>".$text[629]."</font><br>";
        }
      $xtipperplz=intval(trim($xtipperplz));
      if($xtipperplz==""){
        $newpage=0;
        echo "<font color=red>".$text[630]."</font><br>";
        }
      $xtipperort=trim($xtipperort);
      if($xtipperort==""){
        $newpage=0;
        echo "<font color=red>".$text[631]."</font><br>";
        }
      }
    $xtipperemail=trim($xtipperemail);
    if($xtipperemail=="" || strpos($xtipperemail, " ")>-1 || strpos($xtipperemail, "@")<1){
      $newpage=0;
      echo "<font color=red>".$text[568]."</font><br>";
      }
    $xtipperpass=trim($xtipperpass);
    if($xtipperpass==""){
      $newpage=0;
      echo "<font color=red>".$text[569]."</font><br>";
      }
    elseif(strlen($xtipperpass)<3){
      $newpage=0;
      echo "<font color=red>".$text[573]."</font><br>";
      }
    $xtipperpassw=trim($xtipperpassw);
    if($xtipperpassw!=$xtipperpass){
      $newpage=0;
      echo "<font color=red>".$text[570]."</font><br>";
      }
    if($xtippervereinradio==1){
      $xtippervereinalt=trim($xtippervereinalt);
      if($xtippervereinalt==""){
        $newpage=0;
        echo "<font color=red>".$text[571]."</font><br>";
        }
      else{require("lmo-tippcheckteam.php");}
      }
    if($xtippervereinradio==2){
      $xtippervereinneu=trim($xtippervereinneu);
      if($xtippervereinneu==""){
        $newpage=0;
        echo "<font color=red>".$text[572]."</font><br>";
        }
      else{require("lmo-tippcheckteam.php");}
      }
    }

  if($newpage==1){
    $userf1="";
    
    if($xtippervereinradio==1){ $lmotipperverein=$xtippervereinalt; }
    elseif($xtippervereinradio==2) {$lmotipperverein=$xtippervereinneu;}
    else {$lmotipperverein="";}
    
    $zeile=$xtippernick."|".$xtipperpass."|";
    if($freischaltung==0){$zeile.="5|";}else{$zeile.="|";}
    if($realname!=-1){$zeile.=$xtippervorname." ".$xtippernachname;}
    $zeile.="|".$xtipperemail."|".$lmotipperverein;
    if($adresse==1){$zeile.="|$xtipperstrasse|$xtipperplz|$xtipperort";}else{$zeile.="|||";}
    $zeile.="|1|1|EOL";
    array_push($users,$zeile);
  
    if($xtipperligen!=""){
      foreach($xtipperligen as $key => $value){
        $tippfile=$dirtipp.$value."_".$xtippernick.".tip";
        $st=-1; // keine Tipps schreiben
        require("lmo-tippsavefile.php"); // Tipp-Datei erstellen
        $auswertdatei = fopen($dirtipp."auswert/".$value.".aus","ab");
        flock($auswertdatei,2);
        fputs($auswertdatei,"\n[".$xtippernick."]\n");
        fputs($auswertdatei,"Team=".$lmotipperverein."\n");
        fputs($auswertdatei,"Name=".$xtippervorname." ".$xtippernachname."\n");
        flock($auswertdatei,3);
        fclose($auswertdatei);
        }
      }
    $save=-1;
    require("lmo-tippsaveauth.php");
    $auswertdatei = fopen($dirtipp."auswert/gesamt.aus","ab");
    flock($auswertdatei,2);
    fputs($auswertdatei,"\n[".$xtippernick."]\n");
    fputs($auswertdatei,"Team=".$lmotipperverein."\n");
    fputs($auswertdatei,"Name=".$xtippervorname." ".$xtippernachname."\n");
    flock($auswertdatei,3);
    fclose($auswertdatei);
    } // end ($newpage==1)
?>
<table class="lmomaina" cellspacing="0" cellpadding="0" border="0">
  <tr>
    <td class="lmomain0" colspan="3" align="center"><nobr>
      <?PHP echo $text[500]; ?>
    </nobr></td>
  </tr>

<?PHP if($newpage!=1){ ?>
  <tr>
    <td class="lmomain1" colspan="3" align="center">
  <form name="lmotippedit" action="<?PHP echo $PHP_SELF; ?>" method="post">
  
  <input type="hidden" name="action" value="tipp">
  <input type="hidden" name="todo" value="newtipper">
  <input type="hidden" name="newpage" value="<?PHP echo (1); ?>">
  <table class="lmosta" width="100%" cellspacing="0" cellpadding="0" border="0"><tr><td align="center" class="lmost1">
  <?PHP echo $text[513]; ?>
  </td></tr><tr><td align="center" class="lmost3">
  <table width="100%" class="lmostb" cellspacing="0" cellpadding="0" border="0">
    <tr>
      <td class="lmost5" width="20">&nbsp;</td>
      <td class="lmost5" align="right"><acronym><?PHP echo " ".$text[523]; ?></acronym></td>
      <td class="lmost5"><acronym><input class="lmoadminein" type="text" name="xtippernick" size="25" maxlength="32" value="<?PHP echo $xtippernick; ?>"></acronym></td>
    </tr>
<?PHP if($realname!=-1){ ?>
    <tr>
      <td class="lmost5" width="20">&nbsp;</td>
      <td class="lmost5" align="right"><acronym><?PHP echo " ".$text[514]; ?></acronym></td>
      <td class="lmost5"><acronym><input class="lmoadminein" type="text" name="xtippervorname" size="25" maxlength="32" value="<?PHP echo $xtippervorname; ?>"></acronym></td>
    </tr>
    <tr>
      <td class="lmost5" width="20">&nbsp;</td>
      <td class="lmost5" align="right"><acronym><?PHP echo " ".$text[515]; ?></acronym></td>
      <td class="lmost5"><acronym><input class="lmoadminein" type="text" name="xtippernachname" size="25" maxlength="32" value="<?PHP echo $xtippernachname; ?>"></acronym></td>
    </tr>
<?PHP } ?>
<?PHP if($adresse==1){ ?>
    <tr>
      <td class="lmost5" width="20">&nbsp;</td>
      <td class="lmost5" align="right"><acronym><?PHP echo " ".$text[626]; ?></acronym></td>
      <td class="lmost5"><acronym><input class="lmoadminein" type="text" name="xtipperstrasse" size="25" maxlength="32" value="<?PHP echo $xtipperstrasse; ?>"></acronym></td>
    </tr>
    <tr>
      <td class="lmost5" width="20">&nbsp;</td>
      <td class="lmost5" align="right"><acronym><?PHP echo " ".$text[627]; ?></acronym></td>
      <td class="lmost5"><acronym><input class="lmoadminein" type="text" name="xtipperplz" size="7" maxlength="5" value="<?PHP echo $xtipperplz; ?>"></acronym></td>
    </tr>
    <tr>
      <td class="lmost5" width="20">&nbsp;</td>
      <td class="lmost5" align="right"><acronym><?PHP echo " ".$text[628]; ?></acronym></td>
      <td class="lmost5"><acronym><input class="lmoadminein" type="text" name="xtipperort" size="25" maxlength="32" value="<?PHP echo $xtipperort; ?>"></acronym></td>
    </tr>
<?PHP } ?>
    <tr>
      <td class="lmost5" width="20">&nbsp;</td>
      <td class="lmost5" align="right"><acronym><?PHP echo " ".$text[516]; ?></acronym></td>
      <td class="lmost5"><acronym><input class="lmoadminein" type="text" name="xtipperemail" size="25" maxlength="64" value="<?PHP echo $xtipperemail; ?>"></acronym></td>
    </tr>
    <tr>
      <td class="lmost5" width="20">&nbsp;</td>
      <td class="lmost5" align="right"><acronym><?PHP echo " ".$text[308]; ?></acronym></td>
      <td class="lmost5"><acronym><input class="lmoadminein" type="password" name="xtipperpass" size="25" maxlength="32" value="<?PHP echo $xtipperpass; ?>"></acronym></td>
    </tr>
    <tr>
      <td class="lmost5" width="20">&nbsp;</td>
      <td class="lmost5" align="right"><acronym><?PHP echo " ".$text[308]." ".$text[519]; ?></acronym></td>
      <td class="lmost5"><acronym><input class="lmoadminein" type="password" name="xtipperpassw" size="25" maxlength="32" value="<?PHP echo $xtipperpassw; ?>"></acronym></td>
    </tr>
<?PHP if($tipperimteam>=0){ ?>
    <tr>
      <td class="lmost4" align="left" colspan="3"><?PHP echo $text[547]; ?></td>
    </tr>
    <tr>
      <td class="lmost5" width="20">&nbsp;</td>
      <td class="lmost5" colspan="2"><acronym><input type="radio" name="xtippervereinradio" value="0" id="0" <?PHP if($xtippervereinradio==0){echo "checked";} ?>><label for="0"><?PHP echo $text[550]; ?></label></acronym></td>
    </tr>
    <tr>
      <td class="lmost5" width="20">&nbsp;</td>
      <td class="lmost5"><acronym><input type="radio" name="xtippervereinradio" value="1" id="1" <?PHP if($xtippervereinradio==1){echo "checked";} ?>><label for="1"><?PHP echo $text[548]; ?></label></acronym></td>
      <td class="lmost5"><acronym><select name="xtippervereinalt" onChange="xtippervereinradio[1].checked=true">
      <?PHP
        echo "<option value=\"\" "; if($xtippervereinalt==""){echo "selected";} echo ">".$text[551]."</option>";
        require("lmo-tippnewteams.php");
      ?>
      </select></acronym></td>
    </tr>
    <tr>
      <td class="lmost5" width="20">&nbsp;</td>
      <td class="lmost5"><acronym><input type="radio" name="xtippervereinradio" value="2" id="2" <?PHP if($xtippervereinradio==2){echo "checked";} ?>><label for="2"><?PHP echo $text[549]; ?></label></acronym></td>
      <td class="lmost5"><acronym><input class="lmoadminein" type="text" name="xtippervereinneu" size="25" maxlength="32" value="<?PHP echo $xtippervereinneu; ?>" onFocus="xtippervereinradio[2].checked=true"></acronym></td>
    </tr>
<?PHP } ?>
    <tr>
      <td class="lmost4" align="left" colspan="3"><?PHP echo $text[518]; ?></td>
    </tr>
    <tr>
      <td class="lmost5" width="20">&nbsp;</td>
      <td class="lmost5" colspan="2">
      <?PHP $ftype=".l98"; require("lmo-tippnewdir.php"); ?></td>
    </tr>
    <tr>
      <td class="lmost4" colspan="2"><a href="<?PHP echo $PHP_SELF."?action=tipp"; ?>" title="<?PHP echo $text[610]; ?>"><?PHP echo "&lt;&lt; ".$text[610]; ?></a></td>
      <td class="lmost4"><acronym><input class="lmoadminbut" type="submit" name="xtippersub" value="<?PHP echo $text[511]; ?>"></acronym></td>
    </tr>
  </table>
   </td></tr></table>
  </form>
<?PHP
  $HTTP_SESSION_VARS["lmotipperok"]=0;
  }
?>
<?PHP if($newpage==1){ // Anmeldung erfolgreich
  $lmotippername=$xtippernick;
  $HTTP_SESSION_VARS["lmotipperpass"]="";
  $HTTP_SESSION_VARS["lmotipperok"]=5;
?>
  <tr>
    <td class="lmomain1" colspan="3" align="center">

  <table class="lmosta" width="100%" cellspacing="0" cellpadding="0" border="0">
  <tr><td align="center" class="lmost1">
  <?PHP echo $text[513]; ?>
  </td></tr><tr><td align="center" class="lmost3">
  <table width="100%" class="lmostb" cellspacing="0" cellpadding="0" border="0">
   <tr>
      <td class="lmost5" align="center">  <?PHP echo $text[520]; ?></td>
      </td></tr><tr>
      <td class="lmost4" align="right"><a href="<?PHP echo $PHP_SELF; ?>?action=tipp&amp;todo=logout&amp;">=> <?PHP echo $text[521]; ?></a></td>
    </tr>
  </table>
   </td></tr></table>
<?PHP 
 } 
clearstatcache();
?>
</table>
