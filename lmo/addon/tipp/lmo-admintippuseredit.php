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
    <div class="container">
      <div class="row">
        <div class="col d-flex justify-content-center"><?php echo $text['tipp'][114]?></div>
      </div>
      <div class="row">
        <div class="col">
          <a href='<?php echo $_SERVER['PHP_SELF']?>?action=admin&amp;todo=tippuser'><?php echo $text[5]." ".$text['tipp'][111]." ".$text['tipp'][53]?></a>
        </div>
      </div>
    </div><?php 
  } else {
?>

<form name="lmotippedit" action="<?php echo  $_SERVER['PHP_SELF']; ?>" method="post" onSubmit="if (this.nick.value=='') {alert ('<?php echo $text['tipp'][112]?>');this.nick.focus();return false;}">
  <input type="hidden" name="action" value="admin">
  <input type="hidden" name="todo" value="tippuseredit">
  <input type="hidden" name="newpage" value="<?php echo $save == count($users)?'1':'0'?>">
  <div class="container">
    <div class="row">
      <div class="col"><h1><?php      if ($save == count($users)) {
        echo $text['tipp'][136];
      }else {
      	echo $text['tipp'][106];
      } ?></h1></div>
    </div>
    <div class="row">
      <div class="col-2 text-end"><?php echo $text['tipp'][23]; ?></div>
      <div class="col-3 text-start"><?php
      if ($save == count($users)) {?>
        <input class="form-control" type="text" name="nick" value="<?php echo  $nick; ?>"><?php 
      }else{?>
        <input type="hidden" name="nick" value="<?php echo  $nick; ?>"><strong><?php echo $tipp_tipperdaten[0]?></strong><?php 
      }?>
       </div>
     </div>
     <div class="row">
       <div class="col-2 text-end"><?php
       if ($save == count($users)) {?>
         <?php echo $text[323]; ?><?php 
       } else {?>
         <?php echo $text[323]; ?><?php 
       }?>
       </div>
       <div class="col-3"><?php
       if ($save == count($users)) {?>
         <input class="form-control" type="text" name="xtipperpass" value="<?php  include(PATH_TO_LMO."/lmo-adminuserpass.php");?>"><?php 
       }else{?>
         <input class="form-control" type="password" name="xtipperpass" size="25" maxlength="100" value=""><?php 
       }?>
       </div>
     </div>
     <div class="row">
       <div class="col-2 text-end"><?php echo $text['tipp'][14]; ?></div>
       <div class="col-3"><input class="form-control" type="text" name="xtippervorname" size="25" maxlength="32" value="<?php echo  substr($tipp_tipperdaten[3],0,strpos($tipp_tipperdaten[3]," ")); ?>"></div>
     </div>
     <div class="row">
       <div class="col-2 text-end"><?php echo $text['tipp'][15]; ?></div>
       <div class="col-3"><input class="form-control" type="text" name="xtippernachname" size="25" maxlength="32" value="<?php echo  substr($tipp_tipperdaten[3],strpos($tipp_tipperdaten[3]," ")+1); ?>"></div>
     </div>
     <div class="row">
       <div class="col-2 text-end"><?php echo $text['tipp'][126]; ?></div>
       <div class="col-3"><input class="form-control" type="text" name="xtipperstrasse" size="25" maxlength="32" value="<?php echo  $tipp_tipperdaten[6]; ?>"></div>
     </div>
     <div class="row">
       <div class="col-2 text-end"><?php echo $text['tipp'][127]; ?></div>
       <div class="col-3"><input class="form-control" type="text" name="xtipperplz" size="7" maxlength="5" value="<?php echo  $tipp_tipperdaten[7]; ?>"></div>
     </div>
     <div class="row">
       <div class="col-2 text-end"><?php echo $text['tipp'][128]; ?></div>
       <div class="col-3"><input class="form-control" type="text" name="xtipperort" size="25" maxlength="32" value="<?php echo  $tipp_tipperdaten[8]; ?>"></div>
     </div>
     <div class="row">
       <div class="col-2 text-end"><?php echo $text['tipp'][16]; ?></div>
       <div class="col-3"><input class="form-control" type="text" name="xtipperemail" size="25" maxlength="64" value="<?php echo  $tipp_tipperdaten[4]; ?>"></div>
     </div>
     <div class="row">
       <div class="col-3 offset-2 text-start"><input type="checkbox" class="form-check-input" name="xfrei" <?php if($tipp_tipperdaten[2]==5){echo "checked";} ?>>&nbsp;<?php echo  $text['tipp'][147] ?></div>
      </div>
      <div class="row">
        <div class="col-4"><strong><?php echo  $text['tipp'][165]; ?></strong></div>
      </div>
      <div class="row">
        <div class="col-3 offset-2 text-start"><input type="checkbox" class="form-check-input" name="xnews" <?php if(isset($tipp_tipperdaten[9]) && $tipp_tipperdaten[9]!=-1){echo "checked";} ?>>&nbsp;<?php echo  $text['tipp'][206] ?></div>
      </div>
      <div class="row">
        <div class="col-3 offset-2 text-start"><input type="checkbox" class="form-check-input" name="xremind" <?php if(isset($tipp_tipperdaten[10]) && $tipp_tipperdaten[10]!=-1){echo "checked";} ?>>&nbsp;<?php echo  $text['tipp'][167] ?></div>
      </div>
<?php if($tipp_tipperimteam>=0){ ?>
       <div class="row">
         <div class="col-4 offset-3"><strong><?php echo  $text['tipp'][27]; ?></strong></div>
       </div>
       <div class="row">
         <div class="col-4"><input type="radio" class="form-check-input" name="xtippervereinradio" value="0" id="0" <?php if($xtippervereinradio==0){echo "checked";} ?>><?php echo  $text['tipp'][50]; ?></div>
       </div>
       <div class="row">
         <div class="col-2 text-end"><input type="radio" class="form-check-input" name="xtippervereinradio" value="1" id="1" <?php if($xtippervereinradio==1){echo "checked";} ?>><?php echo  $text['tipp'][48]; ?></div>
         <div class="col-5">
           <select name="xtippervereinalt" onChange="xtippervereinradio[1].checked=true"><?php 
           echo "<option value=\"\" "; if($xtippervereinalt==""){echo "selected";} echo ">".$text['tipp'][51]."</option>";
             require(PATH_TO_ADDONDIR."/tipp/lmo-tippnewteams.php");?>
           </select>
         </div>
       </div>
       <div class="row">
         <div class="col-2 text-end"><input type="radio" class="form-check-input" name="xtippervereinradio" value="2" id="2" <?php if($xtippervereinradio==2){echo "checked";} ?>><?php echo  $text['tipp'][49]; ?></div>
         <div class="col-5"><input class="form-control" type="text" name="xtippervereinneu" size="25" maxlength="32" value="<?php echo  $xtippervereinneu; ?>" onFocus="xtippervereinradio[2].checked=true"></div>
       </div><?php  }?>
       <div class="row">
         <div class="col-4"><strong><?php echo  $text['tipp'][273]; ?></strong></div>
       </div>
       <div class="row">
         <div class="col-3 offset-2 text-start"><?php              $ftype=".l98";
           require(PATH_TO_ADDONDIR."/tipp/lmo-tippnewdir.php");?>
         </div>
       </div>
       <div class="row">
         <div class="col offset-2 text-start">
           <a class="btn btn-secondary" href='<?php echo $_SERVER['PHP_SELF']."?action=admin&amp;todo=tippuser"?>'><?php echo $text[544]?></a>
           <input class="btn btn-success" type="submit" name="xtippersub" value="<?php echo  $text[329]; ?>">
         </div>
       </div>
       <div class="row">
         <div class="col text-start"><?php echo  "<strong>".$text['tipp'][82]."</strong> ".$text['tipp'][137]; ?></div>
       </div>
     </div>
   </form><?php 
  }
}
$file="";?>