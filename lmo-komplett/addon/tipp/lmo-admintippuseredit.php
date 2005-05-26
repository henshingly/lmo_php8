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

$edit=false;
if (isset($_POST['nick'])) {
  //Edited
  $nick=trim($_POST['nick']);
} elseif (isset($_GET['nick'])) {
  //toEdit
  $edit=true;
  $nick=trim($_GET['nick']);
} else {
  $nick='';
}

$xtipperpass          = isset($_POST['xtipperpass']) ? trim($_POST['xtipperpass']) :'' ;
$xtippervorname       = isset($_POST['xtippervorname'])    ? $_POST['xtippervorname']    : '';
$xtippernachname      = isset($_POST['xtippernachname'])   ? $_POST['xtippernachname']   : '';
$xtipperstrasse       = isset($_POST['xtipperstrasse'])    ? $_POST['xtipperstrasse']    : '';
$xtipperplz           = isset($_POST['xtipperplz'])       ? $_POST['xtipperplz']       : '';
$xtipperort           = isset($_POST['xtipperort'])        ? $_POST['xtipperort']        : '';
$xtipperemail         = isset($_POST['xtipperemail'])      ? $_POST['xtipperemail']      : '';
$xfrei                = isset($_POST['xfrei'])             ? '5'             : '';
$xnews                = isset($_POST['xnews'])             ? '1'             : '-1';
$xremind              = isset($_POST['xremind'])           ? '1'             : '-1';
$xtippervereinradio   = isset($_POST['xtippervereinradio'])? $_POST['xtippervereinradio']: '';
$xtippervereinalt     = isset($_POST['xtippervereinalt'])  ? $_POST['xtippervereinalt']  : '';
$xtippervereinneu     = isset($_POST['xtippervereinneu'])  ? $_POST['xtippervereinneu']  : '';
$xtippersub           = isset($_POST['xtippersub'])        ? $_POST['xtippersub']        : '';
$xtipperligen         = isset($_POST['xtipperligen'])      ? $_POST['xtipperligen']      : array();

$newpage=	      isset($_REQUEST['newpage'])        ? $_REQUEST['newpage']        : 0;
$save=	        isset($_REQUEST['save'])           ? $_REQUEST['save']           : 0;
$action=	      isset($_REQUEST['action'])         ? $_REQUEST['action']         : '';
$todo=	        isset($_REQUEST['todo'])           ? $_REQUEST['todo']           : '';

require_once(PATH_TO_LMO."/lmo-admintest.php");
if($action=="admin" && $todo=="tippuseredit" && ($nick!="" || $save==-1)){
  include(PATH_TO_ADDONDIR."/tipp/lmo-admintippmenu.php");

  $pswfile=PATH_TO_ADDONDIR."/tipp/".$tipp_tippauthtxt;

  $users = file($pswfile);
  array_unshift($users,'');

  if ($save != -1) {
    $gef=0;
    for($i=1;$i<count($users) && $gef==0;$i++){
      $tipp_tipperdaten = explode('|',$users[$i]);
      // Änderung & Nick gefunden
      if($nick==$tipp_tipperdaten[0] && $newpage == 0){ 
        $gef=1;
        $save=$i;
        if (!$edit) $newpage=1;
      } elseif($nick==$tipp_tipperdaten[0] && $newpage == 1){ 
        $newpage = 0;
        echo getMessage($text['tipp'][24],TRUE);
      }
    }
    if($gef==0){
      $save=$i;
    }
    
  } else {
    //New User

    $tipp_tipperdaten=array_pad(array(),10,'');
    $save = count($users);
    $tipp_tipperdaten[2]='5';
    $tipp_tipperdaten[9]='1';
    $tipp_tipperdaten[10]='1';
  }
  
  
  
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
    $tipp_tipperdaten[1]=trim($xtipperpass)!=''?$xtipperpass:$tipp_tipperdaten[1];
    $tipp_tipperdaten[3]=$xtippervorname;
    $tipp_tipperdaten[3].=" ".$xtippernachname;


    if(substr_count($tipp_tipperdaten[3], " ")>1){
      $newpage=0;
      echo getMessage($text['tipp'][109],TRUE);
    }

    $tipp_tipperdaten[4]=$xtipperemail;
    $tipp_tipperdaten[6]=$xtipperstrasse;
    $tipp_tipperdaten[7]=$xtipperplz;
    $tipp_tipperdaten[8]=$xtipperort;

    if($xtippervereinradio=='1'){
      $xtippervereinalt=trim($xtippervereinalt);
      if($xtippervereinalt==""){
        $newpage=0;
        echo getMessage($text['tipp'][71],TRUE);
      }else{
        require(PATH_TO_ADDONDIR."/tipp/lmo-tippcheckteam.php");
      }
    }
    if($xtippervereinradio=='2'){
      $xtippervereinneu=trim($xtippervereinneu);
      if($xtippervereinneu==""){
        $newpage=0;
        echo getMessage($text['tipp'][72],TRUE);
      }else{
        require(PATH_TO_ADDONDIR."/tipp/lmo-tippcheckteam.php");
      }
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
    $tipp_tipperdaten[2]=$xfrei;
    $tipp_tipperdaten[9]=$xnews;
    $tipp_tipperdaten[10]=$xremind;

    $users[$save]=$tipp_tipperdaten[0]."|".$tipp_tipperdaten[1]."|".$tipp_tipperdaten[2]."|".$tipp_tipperdaten[3]."|".$tipp_tipperdaten[4]."|";
    $users[$save].=$team."|".$tipp_tipperdaten[6]."|".$tipp_tipperdaten[7]."|".$tipp_tipperdaten[8];
    $users[$save].="|".$tipp_tipperdaten[9]."|".$tipp_tipperdaten[10]."|EOL";

    require(PATH_TO_ADDONDIR."/tipp/lmo-tippsaveauth.php");

    $verz=opendir(PATH_TO_ADDONDIR."/tipp/".$tipp_dirtipp);
    while($files=readdir($verz)){
      if(substr($files,strrpos($files,"_")+1,-4)==$nick && strtolower(substr($files,-4))==".tip"){
        $delete=1;
        if(!empty($xtipperligen)){
          foreach($xtipperligen as $key => $value){
            $tippfile=$value."_".$nick.".tip";
            if($tippfile==$files){
              $delete=0;
            }
          }
        }
        if($delete==1){
          unlink(PATH_TO_ADDONDIR."/tipp/".$tipp_dirtipp.$files);
        } // Abonnement beenden
      }
    }
    closedir($verz);

    if(!empty($xtipperligen)){
      foreach($xtipperligen as $key => $value){
        $verz=opendir(PATH_TO_ADDONDIR."/tipp/".$tipp_dirtipp);
        while($files=readdir($verz)){
          $create=1;
          //if(substr($files,0,-4)==$nick && substr($files,0,strrpos($files,"_"))==$value && strtolower(substr($files,-4))==".tip"){
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
          flock($auswertdatei,LOCK_EX);
          fputs($auswertdatei,"\n[".$nick."]\n");
          fputs($auswertdatei,"Team=".$tipp_tipperdaten[5]."\n");
          fputs($auswertdatei,"Name=".$tipp_tipperdaten[3]."\n");
          flock($auswertdatei,LOCK_UN);
          fclose($auswertdatei);
        }
      }
    }?>
    <table class="lmoMiddle" cellspacing="0" cellpadding="0" border="0" width="50%">
      <tr>
        <th class="lmoMenu"><?=$text['tipp'][114]?></th>
      </tr>
      <tr>
        <td align="center">
          <a href='<?=$_SERVER['PHP_SELF']?>?action=admin&amp;todo=tippuser'><?=$text[5]." ".$text['tipp'][111]." ".$text['tipp'][53]?></a>
        </td>
      </tr>
    </table><?
  } else {
?>

  <table class="lmoMiddle" cellspacing="0" cellpadding="0" border="0">
    <tr>
      <td align="center"><h1><? 
      if ($save == count($users)) {
        echo $text['tipp'][136];
      }else {
      	echo $text['tipp'][106];
      } ?></h1></td>
    </tr>
    <tr>
      <td align="center">
        <form name="lmotippedit" action="<?= $_SERVER['PHP_SELF']; ?>" method="post" onSubmit="if (this.nick.value=='') {alert ('<?=$text['tipp'][112]?>');this.nick.focus();return false;}">
          <input type="hidden" name="action" value="admin">
          <input type="hidden" name="todo" value="tippuseredit">
          <input type="hidden" name="newpage" value="<?=$save == count($users)?'1':'0'?>">
          <table class="lmoInner" cellspacing="0" cellpadding="0" border="0">
            <tr>
              <td align="right">&nbsp;<?=$text['tipp'][23]; ?></td>
              <td align="left"><? 
            if ($save == count($users)) {?>
                <input class="lmo-formular-input" type="text" name="nick" value="<?= $nick; ?>"><?
            }else{?>
                <input type="hidden" name="nick" value="<?= $nick; ?>"><strong><?=$tipp_tipperdaten[0]?></strong><?
            }?>
              </td>
            </tr>
            <tr>
              <td align="right">&nbsp;<? 
            if ($save == count($users)) {?>
              <?=$text[323]; ?><?
            } else {?>
              <acronym title="<?=$text['tipp'][304]?>"><?=$text[323]; ?></acronym><?
            }?>
              </td>
              <td align="left"><? 
            if ($save == count($users)) {?>
                <input class="lmo-formular-input" type="text" name="xtipperpass" value="<? include(PATH_TO_LMO."/lmo-adminuserpass.php");?>"><?
            }else{?>
                <input class="lmo-formular-input" type="password" name="xtipperpass" size="25" maxlength="100" value=""><?
            }?>
              </td>
            </tr>
            <tr>
              <td align="right">&nbsp;<?=$text['tipp'][14]; ?></td>
              <td align="left"><input class="lmo-formular-input" type="text" name="xtippervorname" size="25" maxlength="32" value="<?= substr($tipp_tipperdaten[3],0,strpos($tipp_tipperdaten[3]," ")); ?>"></td>
            </tr>
            <tr>
              <td align="right">&nbsp;<?=$text['tipp'][15]; ?></td>
              <td align="left"><input class="lmo-formular-input" type="text" name="xtippernachname" size="25" maxlength="32" value="<?= substr($tipp_tipperdaten[3],strpos($tipp_tipperdaten[3]," ")+1); ?>"></td>
            </tr>
            <tr>
              <td align="right">&nbsp;<?=$text['tipp'][126]; ?></td>
              <td align="left"><input class="lmo-formular-input" type="text" name="xtipperstrasse" size="25" maxlength="32" value="<?= $tipp_tipperdaten[6]; ?>"></td>
            </tr>
            <tr>
              <td align="right">&nbsp;<?=$text['tipp'][127]; ?></td>
              <td align="left"><input class="lmo-formular-input" type="text" name="xtipperplz" size="7" maxlength="5" value="<?= $tipp_tipperdaten[7]; ?>"></td>
            </tr>
            <tr>
              <td align="right">&nbsp;<?=$text['tipp'][128]; ?></td>
              <td align="left"><input class="lmo-formular-input" type="text" name="xtipperort" size="25" maxlength="32" value="<?= $tipp_tipperdaten[8]; ?>"></td>
            </tr>
            <tr>
              <td align="right">&nbsp;<?=$text['tipp'][16]; ?></td>
              <td align="left"><input class="lmo-formular-input" type="text" name="xtipperemail" size="25" maxlength="64" value="<?= $tipp_tipperdaten[4]; ?>"></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td align="left"><input type="checkbox" name="xfrei" <? if($tipp_tipperdaten[2]==5){echo "checked";} ?>><?= $text['tipp'][147] ?></td>
            </tr>
            <tr>
              <th align="left" colspan="2"><?= $text['tipp'][165]; ?></th>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td align="left">
                <input type="checkbox" name="xnews" <? if(isset($tipp_tipperdaten[9]) && $tipp_tipperdaten[9]!=-1){echo "checked";} ?>><?= $text['tipp'][206] ?>
              </td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td align="left">
                <input type="checkbox" name="xremind" <? if(isset($tipp_tipperdaten[10]) && $tipp_tipperdaten[10]!=-1){echo "checked";} ?>><?= $text['tipp'][167] ?>
              </td>
            </tr>
<? if($tipp_tipperimteam>=0){ ?>
            <tr>
              <th align="left" colspan="2"><?= $text['tipp'][27]; ?></th>
            </tr>
            <tr>
              <td align="left" colspan="2"><input type="radio" name="xtippervereinradio" value="0" id="0" <? if($xtippervereinradio==0){echo "checked";} ?>><?= $text['tipp'][50]; ?></td>
            </tr>
            <tr>
              <td align="left"><input type="radio" name="xtippervereinradio" value="1" id="1" <? if($xtippervereinradio==1){echo "checked";} ?>><?= $text['tipp'][48]; ?></td>
              <td align="left">
                <select name="xtippervereinalt" onChange="xtippervereinradio[1].checked=true"><?
                echo "<option value=\"\" "; if($xtippervereinalt==""){echo "selected";} echo ">".$text['tipp'][51]."</option>";
                  require(PATH_TO_ADDONDIR."/tipp/lmo-tippnewteams.php");?>
                </select>
              </td>
            </tr>
            <tr>
              <td align="left"><input type="radio" name="xtippervereinradio" value="2" id="2" <? if($xtippervereinradio==2){echo "checked";} ?>><?= $text['tipp'][49]; ?></td>
              <td align="left"><input class="lmo-formular-input" type="text" name="xtippervereinneu" size="25" maxlength="32" value="<?= $xtippervereinneu; ?>" onFocus="xtippervereinradio[2].checked=true"></td>
            </tr><? 
  }?>
            <tr>
              <th align="left" colspan="2"><?= $text['tipp'][273]; ?></th>
            </tr>
            <tr>
              <td class="lmost5" ><? 
              $ftype=".l98";
                require(PATH_TO_ADDONDIR."/tipp/lmo-tippnewdir.php");?>
              </td>
            </tr>
            <tr>
              <td align="left">
                <a href='<?=$_SERVER['PHP_SELF']."?action=admin&amp;todo=tippuser&amp;del=".$tipp_tipperdaten[0];?>' onClick="return confirm('<?=$text[499]?>');"><img src="<?=URL_TO_IMGDIR?>/delete.gif" border="0" width="11" height="13" alt="<?=$text[82]?>"></a>
                &nbsp;&nbsp;<a href='<?=$_SERVER['PHP_SELF']."?action=admin&amp;todo=tippuser"?>'><?=$text[544]?></a>
              </td>
              <td align="right">
                
                <input class="lmo-formular-button" type="submit" name="xtippersub" value="<?= $text[329]; ?>">
              </td>
            </tr>
            <tr>
              <td class="lmoFooter" colspan="2" align="right"><?= "<strong>".$text['tipp'][82]."</strong> ".$text['tipp'][137]; ?></td>
            </tr>
          </table>
        </form>
      </td>
    </tr>
  </table><?
  }
}
$file="";?>