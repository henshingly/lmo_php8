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
  
  
require(PATH_TO_ADDONDIR."/tipp/lmo-tipptest.php");
$xtippername=isset($_REQUEST['xtippername'])?$_REQUEST['xtippername']:'';
$xtipperpass=isset($_REQUEST['xtipperpass'])?$_REQUEST['xtipperpass']:'';

if ($action == "tipp") {
  if (!isset($_SESSION['lmotipperok'])) {
    $_SESSION['lmotipperok'] = 0;
  }
  if (!isset($_SESSION['lmotippername'])) {
    $_SESSION['lmotippername'] = "";
  }
  if (!isset($_SESSION['lmotipperpass'])) {
    $_SESSION['lmotipperpass'] = "";
  }
  if (!isset($_SESSION['lmotipperverein'])) {
    $_SESSION['lmotipperverein'] = "";
  }
  if ($_SESSION["lmotipperok"] < 1 && $_SESSION["lmotipperok"] > -4) {
    $xtippername2 = "";
    if (!empty($xtippername) && !empty($xtipperpass)) {
      $_SESSION['lmotippername'] = $xtippername;
      $_SESSION['lmotipperpass'] = $xtipperpass;
      $pswfile = PATH_TO_ADDONDIR."/tipp/".$tipp_tippauthtxt;
      if (($tippers = file($pswfile)) === FALSE) $tippers = array();
      $_SESSION["lmotipperok"] = -2;
      foreach($tippers as $tipper) {
        if ($_SESSION["lmotipperok"] == -2) {
          $fileinfo = explode('|', trim($tipper));
          if ($_SESSION['lmotippername'] == $fileinfo[0]) {
            // Nick gefunden
            $_SESSION["lmotipperok"] = -1;
            if ($_SESSION["lmotipperpass"] == $fileinfo[1]) {
              // Passwort richtig
              $lmotippername=$_SESSION['lmotippername'];
              $lmotipperverein = $fileinfo[5];
              $_SESSION["lmotipperok"] = $fileinfo[2];
              if ($_SESSION["lmotipperok"] == 5) {
                //echo $_SESSION["lmotipperok"];
                //array_shift($tipper);
              }
            }
          }
        }
      }
    }
  }
  if ($_SESSION["lmotipperok"] == -5) {
    // Passwort-Anforderung
    require(PATH_TO_ADDONDIR."/tipp/lmo-tippemailpass.php");
  }
  if ($_SESSION["lmotipperok"] < 1 && $_SESSION["lmotipperok"] > -4) {
    $addw = $_SERVER['PHP_SELF']."?action=tipp&amp;todo=wert&amp;file=";
    $adda = $_SERVER['PHP_SELF']."?action=tipp&amp;todo=";
     
    if (($todo == "wert" && $all != 1) || $todo == "fieber" || $todo == "edit") {
      require(PATH_TO_LMO."/lmo-openfilename.php");
    } elseif($todo == "einsicht") {
      $lmo_only_st=true;
      require(PATH_TO_LMO."/lmo-openfile.php");
    } elseif($todo == "tabelle") {
      require_once(PATH_TO_LMO."/lmo-openfile.php");
    } elseif($todo == "wert" && $all == 1) {
    }
     
    include(PATH_TO_ADDONDIR."/tipp/lmo-tippmenu.php");
?>
 
<div class="container">
  <div class="row p-1">
    <div class="col"><h1><?php echo $text['tipp'][0]." "; if(isset($titel)){echo $titel;} ?></h1></div>
  </div>
  <div class="row p-1">
    <div class="col"><?php    if($todo=="wert"){require(PATH_TO_ADDONDIR."/tipp/lmo-tippwert.php");}
    elseif($todo=="fieber"){require(PATH_TO_ADDONDIR."/tipp/lmo-tippfieber.php");}
    elseif($todo=="einsicht"){require(PATH_TO_ADDONDIR."/tipp/lmo-tippeinsicht.php");}
    elseif($todo=="tabelle"){require(PATH_TO_ADDONDIR."/tipp/lmo-tipptabelle.php");}
    elseif($todo=="info"){require(PATH_TO_LMO."/lmo-showinfo.php");}
    else{?>
      <form name="lmotippedit" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <input type="hidden" name="action" value="tipp">  
        <input type="hidden" name="file" value="<?php echo $file?>">  
        <div class="container">
          <caption><?php echo $text['tipp'][158]; ?></caption>
          <div class="row p-1">
            <div class="col"><?php echo $text['tipp'][44]; ?></div>
          </div><?php      // Benutzer nicht gefunden
      if($_SESSION["lmotipperok"]==-2){?> 
          <div class="row p-1">
            <div class="col"><?php echo getMessage($text['tipp'][43],TRUE); ?></div>
          </div><?php      }
      // Benutzer nicht freigeschaltet
      if(isset($xtippersub) & $_SESSION["lmotipperok"]=="" && !isset($emailbody)){?> 
          <div class="row p-1">
            <div class="col"><?php echo getMessage($text['tipp'][148],TRUE); ?></div>
          </div><?php      }?>
          <div class="row p-1">
            <div class="col-3 text-end"><?php echo " ".$text['tipp'][23]; ?></div>
            <div class="col-3"><input class="form-control" type="text" name="xtippername" size="16" maxlength="32" value="<?php echo $_SESSION['lmotippername']; ?>"></div>
          </div><?php 
      // Passwort falsch 
      if($_SESSION["lmotipperok"]==-1){ $xtippername2=$_SESSION["lmotippername"];  ?> 
          <div class="row p-1">
            <div class="col"><?php echo getMessage($text['tipp'][42],TRUE); ?></div>
          </div><?php      }?>
          <div class="row p-1">
            <div class="col-3 text-end"><?php echo " ".$text[308]; ?></div>
            <div class="col-3"><input class="form-control" type="password" name="xtipperpass" size="16" maxlength="32" value="<?php echo $_SESSION['lmotipperpass']; ?>"></div>
          </div>
          <div class="row p-1">
            <div class="col-3 offset-3"><input class="btn btn-sm btn-secondary" title="<?php echo $text[311] ?>" type="submit" name="xtippersub" value="<?php echo $text['tipp'][12]; ?>"></div>
          </div>
        </div>
      </form>
    </div>
  </div>
  <div class="row p-1">
    <div class="col">
      <div class="container">
        <div class="row p-1">
          <div class="col-3"><?php echo $text['tipp'][45]; ?></div>
          <div class="col-3">
            <form name="lmotippedit" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
              <input type="hidden" name="action" value="tipp">
              <input type="hidden" name="todo" value="newtipper">
              <input class="btn btn-sm btn-primary" type="submit" name="xtippersub" value="<?php echo $text['tipp'][11]; ?>" >
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="row p-1">
    <div class="col"><?php echo $text['tipp'][4]; ?></div>
  </div>
  <div class="row p-1">
    <div class="col-auto">
      <ul class="nav nav-pills"><?php 
        $ftype=".l98"; 
        require(PATH_TO_ADDONDIR."/tipp/lmo-tippnewdir.php");
        $dummy =  explode("|",$tt1);
        $ftest2 = explode("|",$tt0);
        if(isset($dummy) && isset($ftest2)){
          for($u=0;$u<count($dummy);$u++){
            if($dummy[$u]!="" && $ftest2[$u]!=""){
              $dummy[$u]=substr($dummy[$u],0,-4);
              $auswertfile=PATH_TO_ADDONDIR."/tipp/".$tipp_dirtipp."auswert/".$dummy[$u].".aus";
              if ($tipp_nurgesamt==0) {?>
        <li class="nav-item"><a href="<?php echo $addw.$dummy[$u].".l98"; ?>"><?php echo $ftest2[$u];?></a><?php if(file_exists($auswertfile)){echo "<br><small>".$text['tipp'][83].": ".datefmt_format($fmt,filemtime($auswertfile))."</small>";}?></li><?php 
              }
            }
          }
        }
        if($tipp_gesamt==1 && ($u>2 || $tipp_nurgesamt==1 && $u==2)){
          $auswertfile=PATH_TO_ADDONDIR."/tipp/".$tipp_dirtipp."auswert/gesamt.aus";?>
        <li class="nav-item"><a href="<?php echo $addw."&amp;all=1" ?>"><strong><?php echo $text['tipp'][25];?></strong></a><?php if(file_exists($auswertfile)){echo "<br><small>".$text['tipp'][83].": ".datefmt_format($fmt,filemtime($auswertfile))."</small>";}?></li><?php 
        }
        $auswertfile="";?>
      </ul>
    </div>
  </div>
  <div class="row p-1">
    <div class="col">
      <form name="lmotippedit" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <input type="hidden" name="action" value="tipp">
        <input type="hidden" name="todo" value="getpass">
        <div class="container">
          <div class="row p-1">
            <div class="col"><?php echo $text['tipp'][74]; ?></div>
          </div><?php   
            // Benutzer nicht gefunden
            if($_SESSION["lmotipperok"]==-3){ ?> 
          <div class="row p-1">
            <div class="col"><?php echo $text['tipp'][43]; ?></div>
          </div><?php            
            }?>
          <div class="row p-1">
            <div class="col-3 text-start"><?php echo " ".$text['tipp'][23]." ".$text['tipp'][218]." ".$text['tipp'][219]; ?></div>
            <div class="col-3"><input class="form-control" type="text" name="xtippername2" size="16" maxlength="32" value="<?php echo $xtippername2; ?>"></div>
          </div>
          <div class="row p-1">
            <div class="col-3 text-start"><?php echo $text['tipp'][75]; ?></div>
            <div class="col-3"><input class="btn btn-sm btn-secondary" type="submit" name="xtippersub" value="<?php echo $text['tipp'][76]; ?>" ></div>
          </div>
        </div>
      </form>
    </div>
  </div>
</div><?php 
  }
 }
}?>