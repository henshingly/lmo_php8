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
require_once(PATH_TO_LMO."/lmo-admintest.php");
if($action=="admin" && $todo=="tippuseredit" && $nick!=""){
  if(!isset($xtippervereinalt)){$xtippervereinalt="";}
  if(!isset($xtippervereinneu)){$xtippervereinneu="";}
  if(!isset($xtipperligen)){$xtipperligen="";}
  $users = array("");
  $pswfile=PATH_TO_ADDONDIR."/tipp/".$tipp_tippauthtxt;
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
    $tipp_tipperdaten = split("[|]",$users[$i]);
    if($nick==$tipp_tipperdaten[0]){ // Nick gefunden
      $gef=1;
      $save=$i;
      }
    }
  if($gef==0){exit;}
  
  if($newpage!=1){
    if($tipp_tipperdaten[5]==""){
      $xtippervereinradio=0;
      }
    else{
      $xtippervereinradio=1;
      $xtippervereinalt=$tipp_tipperdaten[5];
      }
  }
  if($newpage==1){
    $tipp_tipperdaten[0]=$nick;
    $tipp_tipperdaten[1]=trim($xtipperpass);
    $tipp_tipperdaten[3]=isset($_POST['xtippervorname'])?   trim($_POST['xtippervorname']):      "";
    $tipp_tipperdaten[3].=isset($_POST['xtippernachname'])? " ".trim($_POST['xtippernachname']): "";

    if(substr_count($tipp_tipperdaten[3], " ")>1){
      $newpage=0;
      echo "<p class='error'>".$text['tipp'][109]."</p>";
    }
 
    $tipp_tipperdaten[4]=isset($_POST['xtipperemail'])?                                         trim($_POST['xtipperemail']):        "";
    $tipp_tipperdaten[6]=isset($_POST['xtipperstrasse'])?                                       trim($_POST['xtipperstrasse']):      "";
    $tipp_tipperdaten[7]=isset($_POST['xtipperplz']) && is_numeric($_POST['xtipperplz'])?       intval(trim($_POST['xtipperplz'])):  "";
    $tipp_tipperdaten[8]=isset($_POST['xtipperort'])?                                           trim($_POST['xtipperort']):          "";
    
    $xtippervereinradio=isset ($_POST['xtippervereinradio'])?                                   $_POST['xtippervereinradio']:        0;
    
    if($xtippervereinradio==1){
      $xtippervereinalt=trim($xtippervereinalt);
      if($xtippervereinalt==""){
        $newpage=0;
        echo "<p class='error'>".$text['tipp'][71]."</p>";
      }else{require(PATH_TO_ADDONDIR."/tipp/lmo-tippcheckteam.php");}
    }
    if($xtippervereinradio==2){
      $xtippervereinneu=trim($xtippervereinneu);
      if($xtippervereinneu==""){
        $newpage=0;
        echo "<p class='error'>".$text['tipp'][72]."</p>";
      }else{require(PATH_TO_ADDONDIR."/tipp/lmo-tippcheckteam.php");}
    }
  }

  if($newpage==1){
    if($xtippervereinradio==1){$team=$xtippervereinalt;}
    elseif($xtippervereinradio==2){$team=$xtippervereinneu;}
    else{$team="";}
    
    if($xtippervereinradio>0){
      $xtippervereinradio=1;
      $xtippervereinalt=$team;
      $xtippervereinneu="";
    }
    $tipp_tipperdaten[2]=isset($xfrei) && $xfrei==1?        5:       "";
    $tipp_tipperdaten[9]=isset($xnews) && $xnews==1?        1:       -1;
    $tipp_tipperdaten[10]=isset($xremind) && $xremind==1?   1:       -1;
    
    $users[$save]=$tipp_tipperdaten[0]."|".$tipp_tipperdaten[1]."|".$tipp_tipperdaten[2]."|".$tipp_tipperdaten[3]."|".$tipp_tipperdaten[4]."|";
    $users[$save].=$team."|".$tipp_tipperdaten[6]."|".$tipp_tipperdaten[7]."|".$tipp_tipperdaten[8]."|";
    $users[$save].="|".$tipp_tipperdaten[9]."|".$tipp_tipperdaten[10]."|EOL";

    require(PATH_TO_ADDONDIR."/tipp/lmo-tippsaveauth.php");

    $verz=opendir(PATH_TO_ADDONDIR."/tipp/".$tipp_dirtipp);
    while($files=readdir($verz)){
      if(substr($files,strrpos($files,"_")+1,-4)==$nick && strtolower(substr($files,-4))==".tip"){
        $delete=1;
        if($xtipperligen!=""){
          foreach($xtipperligen as $key => $value){
            $tippfile=$value."_".$nick.".tip";
            if($tippfile==$files){
              $delete=0;
              }
            }
          }
        if($delete==1){@unlink(PATH_TO_ADDONDIR."/tipp/".$tipp_dirtipp.$files);} // Abonnement beenden
      	}
      }
    closedir($verz);

    if($xtipperligen!=""){
      foreach($xtipperligen as $key => $value){
        $verz=opendir(PATH_TO_ADDONDIR."/tipp/".$tipp_dirtipp);
        while($files=readdir($verz)){
          $create=1;
          if(substr($files,strrpos($files,"_")+1,-4)==$nick && substr($files,0,strrpos($files,"_"))==$value && strtolower(substr($files,-4))==".tip"){
            $create=0; // bereits abonniert
            break;
            }
          }
        closedir($verz);
        if($create==1){
          $tippfile=PATH_TO_ADDONDIR."/tipp/".$tipp_dirtipp.$value."_".$nick.".tip";
          $st=-1;require(PATH_TO_ADDONDIR."/tipp/lmo-tippsavefile.php"); // Tipp-Datei erstellen
          $auswertdatei = fopen(PATH_TO_ADDONDIR."/tipp/".$tipp_dirtipp."auswert/".$value.".aus","ab");
          flock($auswertdatei,2);
          fputs($auswertdatei,"\n[".$nick."]\n");
          fputs($auswertdatei,"Team=".$tipp_tipperdaten[5]."\n");
          fputs($auswertdatei,"Name=".$tipp_tipperdaten[3]."\n");
          flock($auswertdatei,3);
          fclose($auswertdatei);
          }
        }
      }
    } // end ($newpage==1)
?>
  <table class="lmosta" width="100%" cellspacing="0" cellpadding="0" border="0">
  <tr><td align="center" class="lmost1"><?PHP echo $text['tipp'][106]; ?></td></tr>
  <tr><td align="center" class="lmost3">
  <table class="lmostb" cellspacing="0" cellpadding="0" border="0">
  <form name="lmotippedit" action="<?PHP echo $_SERVER['PHP_SELF']; ?>" method="post">
  
  <input type="hidden" name="action" value="admin">
  <input type="hidden" name="todo" value="tippuseredit">
  <input type="hidden" name="nick" value="<?PHP echo $nick; ?>">
  <input type="hidden" name="newpage" value="1">
    <tr>
      <td class="lmost5" width="20">&nbsp;</td>
      <td class="lmost5" align="right"><?PHP echo " ".$text['tipp'][23]; ?></td>
      <td class="lmost5"><?PHP echo "<b>".$tipp_tipperdaten[0]."</b>"; ?></td>
    </tr>
    <tr>
      <td class="lmost5" width="20">&nbsp;</td>
      <td class="lmost5" align="right"><?PHP echo " ".$text[323]; ?></td>
      <td class="lmost5"><input class="lmoadminein" type="text" name="xtipperpass" size="25" maxlength="100" value="<?PHP echo $tipp_tipperdaten[1]; ?>"></td>
    </tr>
    <tr>
      <td class="lmost5" width="20">&nbsp;</td>
      <td class="lmost5" align="right"><?PHP echo " ".$text['tipp'][14]; ?></td>
      <td class="lmost5"><input class="lmoadminein" type="text" name="xtippervorname" size="25" maxlength="32" value="<?PHP echo substr($tipp_tipperdaten[3],0,strpos($tipp_tipperdaten[3]," ")); ?>"></td>
    </tr>
    <tr>
      <td class="lmost5" width="20">&nbsp;</td>
      <td class="lmost5" align="right"><?PHP echo " ".$text['tipp'][15]; ?></td>
      <td class="lmost5"><input class="lmoadminein" type="text" name="xtippernachname" size="25" maxlength="32" value="<?PHP echo substr($tipp_tipperdaten[3],strpos($tipp_tipperdaten[3]," ")+1); ?>"></td>
    </tr>
    <tr>
      <td class="lmost5" width="20">&nbsp;</td>
      <td class="lmost5" align="right"><?PHP echo " ".$text['tipp'][126]; ?></td>
      <td class="lmost5"><input class="lmoadminein" type="text" name="xtipperstrasse" size="25" maxlength="32" value="<?PHP echo $tipp_tipperdaten[6]; ?>"></td>
    </tr>
    <tr>
      <td class="lmost5" width="20">&nbsp;</td>
      <td class="lmost5" align="right"><?PHP echo " ".$text['tipp'][127]; ?></td>
      <td class="lmost5"><input class="lmoadminein" type="text" name="xtipperplz" size="7" maxlength="5" value="<?PHP echo $tipp_tipperdaten[7]; ?>"></td>
    </tr>
    <tr>
      <td class="lmost5" width="20">&nbsp;</td>
      <td class="lmost5" align="right"><?PHP echo " ".$text['tipp'][128]; ?></td>
      <td class="lmost5"><input class="lmoadminein" type="text" name="xtipperort" size="25" maxlength="32" value="<?PHP echo $tipp_tipperdaten[8]; ?>"></td>
    </tr>
    <tr>
      <td class="lmost5" width="20">&nbsp;</td>
      <td class="lmost5" align="right"><?PHP echo " ".$text['tipp'][16]; ?></td>
      <td class="lmost5"><input class="lmoadminein" type="text" name="xtipperemail" size="25" maxlength="64" value="<?PHP echo $tipp_tipperdaten[4]; ?>"></td>
    </tr>
    <tr>
      <td class="lmost5" colspan="2">&nbsp;</td>
      <td class="lmost5"><input type="checkbox" name="xfrei" value="1" <?PHP if($tipp_tipperdaten[2]==5){echo "checked";} ?>><?PHP echo $text['tipp'][147] ?></td>
    </tr>
    <tr>
      <td class="lmost4" align="left" colspan="3"><?PHP echo $text['tipp'][165]; ?></td>
    </tr>
    <tr>
      <td class="lmost5" width="20">&nbsp;</td>
      <td class="lmost5">&nbsp;</td>
      <td class="lmost5">
      <input type="checkbox" name="xnews" value="1" <?PHP if(isset($tipp_tipperdaten[9]) && $tipp_tipperdaten[9]!=-1){echo "checked";} ?>><?PHP echo $text['tipp'][206] ?><br>
      <input type="checkbox" name="xremind" value="1" <?PHP if(isset($tipp_tipperdaten[10]) && $tipp_tipperdaten[10]!=-1){echo "checked";} ?>><?PHP echo $text['tipp'][167] ?>
      </td>
    </tr>
<?PHP if($tipp_tipperimteam>=0){ ?>
    <tr>
      <td class="lmost4" align="left" colspan="3"><?PHP echo $text['tipp'][27]; ?></td>
    </tr>
    <tr>
      <td class="lmost5" width="20">&nbsp;</td>
      <td class="lmost5" colspan="2"><input type="radio" name="xtippervereinradio" value="0" id="0" <?PHP if($xtippervereinradio==0){echo "checked";} ?>><label for="0"><?PHP echo $text['tipp'][50]; ?></label></td>
    </tr>
    <tr>
      <td class="lmost5" width="20">&nbsp;</td>
      <td class="lmost5"><input type="radio" name="xtippervereinradio" value="1" id="1" <?PHP if($xtippervereinradio==1){echo "checked";} ?>><label for="1"><?PHP echo $text['tipp'][48]; ?></label></td>
      <td class="lmost5"><select name="xtippervereinalt" onChange="xtippervereinradio[1].checked=true">
      <?PHP
        echo "<option value=\"\" "; if($xtippervereinalt==""){echo "selected";} echo ">".$text['tipp'][51]."</option>";
        require(PATH_TO_ADDONDIR."/tipp/lmo-tippnewteams.php");
      ?>
      </select></td>
    </tr>
    <tr>
      <td class="lmost5" width="20">&nbsp;</td>
      <td class="lmost5"><input type="radio" name="xtippervereinradio" value="2" id="2" <?PHP if($xtippervereinradio==2){echo "checked";} ?>><label for="2"><?PHP echo $text['tipp'][49]; ?></label></td>
      <td class="lmost5"><input class="lmoadminein" type="text" name="xtippervereinneu" size="25" maxlength="32" value="<?PHP echo $xtippervereinneu; ?>" onFocus="xtippervereinradio[2].checked=true"></td>
    </tr>
<?PHP } ?>
    <tr>
      <td class="lmost4" align="left" colspan="3"><?PHP echo $text['tipp'][273]; ?></td>
    </tr>
    <tr>
      <td class="lmost5" width="20">&nbsp;</td>
      <td class="lmost5" colspan="2">
<?PHP $ftype=".l98"; require(PATH_TO_ADDONDIR."/tipp/lmo-tippnewdir.php"); ?>
      </td>
    </tr>
    <tr>
      <td class="lmost4" colspan="3" align="right">
      <input class="lmoadminbut" type="submit" name="xtippersub" value="<?PHP echo $text[329]; ?>">
      </td>
    </tr>
    <tr>
      <td class="lmost5" colspan="3" align="right"><?PHP echo "<strong>".$text['tipp'][82]."</strong> ".$text['tipp'][137]; ?>
      </td>
    </tr>
  </form>

  </table></td></tr>
  <tr>
    <td><table width="100%" cellspacing="0" cellpadding="0" border="0"><tr>
<?PHP 
  $adda=$_SERVER['PHP_SELF']."?action=admin&amp;todo=tipp";
  $addo=$_SERVER['PHP_SELF']."?action=admin&amp;todo=tippoptions";
  $addu=$_SERVER['PHP_SELF']."?action=admin&amp;todo=tippuser";
  $adde=$_SERVER['PHP_SELF']."?action=admin&amp;todo=tippemail";
  echo "<td class=\"lmost2\" align=\"center\"><a href='$adda' onclick=\"return chklmolink(this.href);\" title=\"".$text['tipp'][63]."\">".$text['tipp'][63]."</a></td>";
  echo "<td class=\"lmost2\" align=\"center\"><a href='$adde' onclick=\"return chklmolink(this.href);\" title=\"".$text['tipp'][165]."\">".$text['tipp'][165]."</a></td>";
  echo "<td class=\"lmost2\" align=\"center\"><a href='$addu' onclick=\"return chklmolink(this.href);\" title=\"".$text['tipp'][114]."\">".$text['tipp'][114]."</a></td>";
  echo "<td class=\"lmost2\" align=\"center\"><a href='$addo' onclick=\"return chklmolink(this.href);\" title=\"".$text['tipp'][55]."\">".$text[86]."</a></td>";
?>
    </tr></table></td>
  </tr>
  </table>

<?PHP } $file=""; ?>