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
if(($action=="tipp") && ($todo=="daten")){
  if(!isset($xtippervereinalt)){$xtippervereinalt="";}
  if(!isset($xtippervereinneu)){$xtippervereinneu="";}
  $users = array("");
  $pswfile=$tippauthtxt;
  $datei = fopen($pswfile,"rb");
  while (!feof($datei)) {
    $zeile = fgets($datei,1000);
    $zeile=trim(chop($zeile));
    if($zeile!=""){
      if($zeile!=""){array_push($users,$zeile);}
      }
    }
  fclose($datei);
  $gef=0;
  for($i=1;$i<count($users) && $gef==0;$i++){
    $dummb = split("[|]",$users[$i]);
    if($lmotippername==$dummb[0]){ // Nick gefunden
      $gef=1;
      $save=$i;
      }
    }
  if($gef==0){exit;}
  
  if($newpage!=1){
    if($dummb[5]==""){
      $xtippervereinradio=0;
      }
    else{
      $xtippervereinradio=1;
      $xtippervereinalt=$dummb[5];
      }
  }
  if($newpage==1){
    if($realname!=-1){
      $xtippervorname=trim($xtippervorname);
      if($xtippervorname==""){
        $newpage=0;
        echo "<font color=red>".$text[2066]."</font><br>";
        }
      $xtippernachname=trim($xtippernachname);
      if($xtippernachname==""){
        $newpage=0;
        echo "<font color=red>".$text[2067]."</font><br>";
        }
      if(strpos($xtippernachname, " ")!=false || strpos($xtippervorname, " ")>-1){
        $newpage=0;
        echo "<font color=red>".$text[2109]."</font><br>";
        }
      }
    if($adresse==1){
      $xtipperstrasse=trim($xtipperstrasse);
      if($xtipperstrasse==""){
        $newpage=0;
        echo "<font color=red>".$text[2129]."</font><br>";
        }
      $xtipperplz=intval(trim($xtipperplz));
      if($xtipperplz==""){
        $newpage=0;
        echo "<font color=red>".$text[2130]."</font><br>";
        }
      $xtipperort=trim($xtipperort);
      if($xtipperort==""){
        $newpage=0;
        echo "<font color=red>".$text[2131]."</font><br>";
        }
      }
    $xtipperemail=trim($xtipperemail);
    if($xtipperemail=="" || strpos($xtipperemail, " ")>-1 || strpos($xtipperemail, "@")<1){
      $newpage=0;
      echo "<font color=red>".$text[2068]."</font><br>";
      }
    if($xtippervereinradio==1){
      $xtippervereinalt=trim($xtippervereinalt);
      if($xtippervereinalt==""){
        $newpage=0;
        echo "<font color=red>".$text[2071]."</font><br>";
        }
      else{require("lmo-tippcheckteam.php");}
      }
    if($xtippervereinradio==2){
      $xtippervereinneu=trim($xtippervereinneu);
      if($xtippervereinneu==""){
        $newpage=0;
        echo "<font color=red>".$text[2072]."</font><br>";
        }
      else{require("lmo-tippcheckteam.php");}
      }
    }

  if($newpage==1){
    if($xtippervereinradio==1){ $lmotipperverein=$xtippervereinalt; }
    elseif($xtippervereinradio==2) {$lmotipperverein=$xtippervereinneu;}
    else {$lmotipperverein="";}
    $users[$save]=$dummb[0]."|".$dummb[1]."|".$dummb[2]."|";
    if($realname!=-1){$users[$save]=$users[$save].$xtippervorname." ".$xtippernachname;}
    $users[$save]=$users[$save]."|".$xtipperemail."|".$lmotipperverein;
    if($adresse==1){$users[$save].="|".$xtipperstrasse."|".$xtipperplz."|".$xtipperort;}
    else{$users[$save].="|".$dummb[6]."|".$dummb[7]."|".$dummb[8];}
    $users[$save].="|";
    if(trim($_POST["xnews"])==1){$users[$save].="1";}
    else{$users[$save].="-1";}
    $users[$save].="|";
    if(trim($_POST["xremind"])==1){$users[$save].="1";}
    else{$users[$save].="-1";}
    $users[$save].="|EOL";
    require("lmo-tippsaveauth.php");
    } // end ($newpage==1)
?>
  <table class="lmosta" width="100%" cellspacing="0" cellpadding="0" border="0">
  <tr><td align="center" class="lmost1">
    <font color=black><?PHP echo $lmotippername;if($lmotipperverein!=""){echo " - ".$lmotipperverein;} ?></font>
  </td></tr>
  <tr><td align="center" class="lmost1"><?PHP echo $text[2106];if($tipperimteam>=0){echo " / ".$text[2002];} ?></td></tr>
  <tr><td align="center" class="lmost3">
  <table class="lmostb" cellspacing="0" cellpadding="0" border="0">
<?PHP if($newpage!=1){ ?>
  <form name="lmotippedit" action="<?PHP echo $PHP_SELF; ?>" method="post">
  
  <input type="hidden" name="action" value="tipp">
  <input type="hidden" name="todo" value="daten">
  <input type="hidden" name="newpage" value="1">
<?PHP if($realname!=-1){ ?>
    <tr>
      <td class="lmost5" width="20">&nbsp;</td>
      <td class="lmost5" align="right"><acronym><?PHP echo " ".$text[2014]; ?></acronym></td>
      <td class="lmost5"><acronym><input class="lmoadminein" type="text" name="xtippervorname" size="25" maxlength="32" value="<?PHP echo substr($dummb[3],0,strpos($dummb[3]," ")); ?>"></acronym></td>
    </tr>
    <tr>
      <td class="lmost5" width="20">&nbsp;</td>
      <td class="lmost5" align="right"><acronym><?PHP echo " ".$text[2015]; ?></acronym></td>
      <td class="lmost5"><acronym><input class="lmoadminein" type="text" name="xtippernachname" size="25" maxlength="32" value="<?PHP echo substr($dummb[3],strpos($dummb[3]," ")+1); ?>"></acronym></td>
    </tr>
<?PHP } ?>
<?PHP if($adresse==1){ ?>
    <tr>
      <td class="lmost5" width="20">&nbsp;</td>
      <td class="lmost5" align="right"><acronym><?PHP echo " ".$text[2126]; ?></acronym></td>
      <td class="lmost5"><acronym><input class="lmoadminein" type="text" name="xtipperstrasse" size="25" maxlength="32" value="<?PHP echo $dummb[6]; ?>"></acronym></td>
    </tr>
    <tr>
      <td class="lmost5" width="20">&nbsp;</td>
      <td class="lmost5" align="right"><acronym><?PHP echo " ".$text[2127]; ?></acronym></td>
      <td class="lmost5"><acronym><input class="lmoadminein" type="text" name="xtipperplz" size="7" maxlength="5" value="<?PHP echo $dummb[7]; ?>"></acronym></td>
    </tr>
    <tr>
      <td class="lmost5" width="20">&nbsp;</td>
      <td class="lmost5" align="right"><acronym><?PHP echo " ".$text[2128]; ?></acronym></td>
      <td class="lmost5"><acronym><input class="lmoadminein" type="text" name="xtipperort" size="25" maxlength="32" value="<?PHP echo $dummb[8]; ?>"></acronym></td>
    </tr>
<?PHP } ?>
    <tr>
      <td class="lmost5" width="20">&nbsp;</td>
      <td class="lmost5" align="right"><acronym><?PHP echo " ".$text[2016]; ?></acronym></td>
      <td class="lmost5"><acronym><input class="lmoadminein" type="text" name="xtipperemail" size="25" maxlength="64" value="<?PHP echo $dummb[4]; ?>"></acronym></td>
    </tr>
    <tr>
      <td class="lmost4" align="left" colspan="3"><?PHP echo $text[2207]; ?></td>
    </tr>
    <tr>
      <td class="lmost5" width="20">&nbsp;</td>
      <td class="lmost5">&nbsp;</td>
      <td class="lmost5">
      <input type="checkbox" name="xnews" value="1" <?PHP if($dummb[9]!=-1){echo "checked";} ?>><?PHP echo $text[2206] ?><br>
      <input type="checkbox" name="xremind" value="1" <?PHP if($dummb[10]!=-1){echo "checked";} ?>><?PHP echo $text[2167] ?>
      </td>
    </tr>
<?PHP if($tipperimteam>=0){ ?>
    <tr>
      <td class="lmost4" align="left" colspan="3"><?PHP echo $text[2047]; ?></td>
    </tr>
    <tr>
      <td class="lmost5" width="20">&nbsp;</td>
      <td class="lmost5" colspan="2"><acronym><input type="radio" name="xtippervereinradio" value="0" id="0" <?PHP if($xtippervereinradio==0){echo "checked";} ?>><label for="0"><?PHP echo $text[2050]; ?></label></acronym></td>
    </tr>
    <tr>
      <td class="lmost5" width="20">&nbsp;</td>
      <td class="lmost5"><acronym><input type="radio" name="xtippervereinradio" value="1" id="1" <?PHP if($xtippervereinradio==1){echo "checked";} ?>><label for="1"><?PHP echo $text[2048]; ?></label></acronym></td>
      <td class="lmost5"><acronym><select name="xtippervereinalt" onChange="xtippervereinradio[1].checked=true">
      <?PHP
        echo "<option value=\"\" "; if($xtippervereinalt==""){echo "selected";} echo ">".$text[2051]."</option>";
        require("lmo-tippnewteams.php");
      ?>
      </select></acronym></td>
    </tr>
    <tr>
      <td class="lmost5" width="20">&nbsp;</td>
      <td class="lmost5"><acronym><input type="radio" name="xtippervereinradio" value="2" id="2" <?PHP if($xtippervereinradio==2){echo "checked";} ?>><label for="2"><?PHP echo $text[2049]; ?></label></acronym></td>
      <td class="lmost5"><acronym><input class="lmoadminein" type="text" name="xtippervereinneu" size="25" maxlength="32" value="<?PHP echo $xtippervereinneu; ?>" onFocus="xtippervereinradio[2].checked=true"></acronym></td>
    </tr>
<?PHP } ?>
<?PHP if($i!=0){ ?>
    <tr>
      <td class="lmost4" colspan="3" align="right">
      <acronym><input class="lmoadminbut" type="submit" name="xtippersub" value="<?PHP echo $text[329]; ?>"></acronym>
      </td>
    </tr>
    <tr>
      <td class="lmost5" colspan="3" align="right"><?PHP echo "<strong>".$text[2082]."</strong> ".$text[2137]; ?>
      </td>
    </tr>
<?PHP } ?>
  </form>
<?PHP } ?>
<?PHP if($newpage==1){ // Anmeldung erfolgreich ?>
   <tr>
      <td class="lmost5" align="center">  <?PHP echo $text[2121]; ?></td>
   </tr>
   <tr>
      <td class="lmost4" align="right"><a href="<?PHP echo $PHP_SELF."?action=tipp&amp;todo=&amp;PHPSESSID=".$PHPSESSID ?>"><?PHP echo $text[5]." ".$text[2001]; ?></a></td>
   </tr>
<?PHP } ?>

  </table>
  </td></tr></table>

<?PHP } $file=""; ?>