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
require(PATH_TO_ADDONDIR."/tipp/lmo-tipptest.php");
if($action=="tipp"){
  if(!isset($_SESSION['lmotipperok'])){$_SESSION['lmotipperok']=0;}
  if(!isset($_SESSION['lmotippername'])){$_SESSION['lmotippername']="";}
  if(!isset($_SESSION['lmotipperpass'])){$_SESSION['lmotipperpass']="";}
  if(!isset($_SESSION['lmotipperverein'])){$_SESSION['lmotipperverein']="";}
  if($_SESSION["lmotipperok"]<1 && $_SESSION["lmotipperok"]>-4){
    $xtippername2="";
    if(isset($xtippername) && isset($xtipperpass)){
      $_SESSION['lmotippername']=$xtippername;
      $_SESSION['lmotipperpass']=$xtipperpass;
      $pswfile=PATH_TO_ADDONDIR."/tipp/".$tipp_tippauthtxt;
      if (($tippers=file($pswfile))===FALSE) $tippers = array();
      $_SESSION["lmotipperok"]=-2;
      foreach($tippers as $tipper){
        if ($_SESSION["lmotipperok"]==-2) {
          $fileinfo = explode('|',trim($tipper));
          if($_SESSION['lmotippername']==$fileinfo[0]){ // Nick gefunden
            $_SESSION["lmotipperok"]=-1;
            if($lmotipperpass==$fileinfo[1]){ // Passwort richtig
              $lmotipperverein=$fileinfo[5];
              $_SESSION["lmotipperok"]=$fileinfo[2];
              if($_SESSION["lmotipperok"]==5){
                //echo $_SESSION["lmotipperok"];
                //array_shift($tipper);
              }
            }
          }
        }
      }
    }
  }
  if($_SESSION["lmotipperok"]==-5){ // Passwort-Anforderung
    require(PATH_TO_ADDONDIR."/tipp/lmo-tippemailpass.php");
  }
  if($_SESSION["lmotipperok"]<1 && $_SESSION["lmotipperok"]>-4){
    $addw=$_SERVER['PHP_SELF']."?action=tipp&amp;todo=wert&amp;file=";
    $adda=$_SERVER['PHP_SELF']."?action=tipp&amp;todo=";

    if(($todo=="wert" && $all!=1) || $todo=="fieber" || $todo=="edit"){require(PATH_TO_LMO."/lmo-openfilename.php");}
    elseif($todo=="einsicht"){require(PATH_TO_LMO."/lmo-openfilest.php");}
    elseif($todo=="tabelle"){require_once(PATH_TO_LMO."/lmo-openfile.php");}
    elseif($todo=="wert" && $all==1){}

include(PATH_TO_ADDONDIR."/tipp/lmo-tippmenu.php");?>
 
<table class="lmoMiddle" cellspacing="0" cellpadding="0" border="0">
  <tr>
    <td colspan="3" align="center"><h1><? echo $text['tipp'][0]." "; if(isset($titel)){echo $titel;} ?></h1></td>
  </tr>

  <tr>
    <td colspan="3" align="center"><? 
    if($todo=="wert"){require(PATH_TO_ADDONDIR."/tipp/lmo-tippwert.php");}
    elseif($todo=="fieber"){require(PATH_TO_ADDONDIR."/tipp/lmo-tippfieber.php");}
    elseif($todo=="einsicht"){require(PATH_TO_ADDONDIR."/tipp/lmo-tippeinsicht.php");}
    elseif($todo=="tabelle"){require(PATH_TO_ADDONDIR."/tipp/lmo-tipptabelle.php");}
    elseif($todo=="info"){require(PATH_TO_LMO."/lmo-showinfo.php");}
    else{?>
      <form name="lmotippedit" action="<? echo $_SERVER['PHP_SELF']; ?>" method="post">
        <input type="hidden" name="action" value="tipp">  
        <input type="hidden" name="file" value="<?=$file?>">  
        <table class="lmoInner" width="100%" cellspacing="0" cellpadding="0" border="0">
          <caption><? echo $text['tipp'][158]; ?></caption>
          <tr>
            <th colspan="2"><? echo $text['tipp'][44]; ?></th>
          </tr><? 
      // Benutzer nicht gefunden
      if($_SESSION["lmotipperok"]==-2){?> 
          <tr>
            <td class="error" align="right" colspan="3"><? echo $text['tipp'][43]; ?></td>
          </tr><? 
      }
      // Benutzer nicht freigeschaltet
      if(isset($xtippersub) & $_SESSION["lmotipperok"]=="" && !isset($emailbody)){?> 
          <tr>
            <td class="error" align="right" colspan="3"><? echo $text['tipp'][148]; ?></td>
          </tr><? 
      }?>
          <tr>
            <td align="right"><acronym title="<? echo $text[307] ?>"><? echo " ".$text['tipp'][23]; ?></acronym></td>
            <td align="left"><input class="lmo-formular-input" type="text" name="xtippername" size="16" maxlength="32" value="<? echo $_SESSION['lmotippername']; ?>"></td>
          </tr><?
      // Passwort falsch 
      if($_SESSION["lmotipperok"]==-1){ $xtippername2=$lmotippername;  ?> 
          <tr>
            <td class="error" align="right" colspan="3"><? echo $text['tipp'][42]; ?></td>
          </tr><? 
      }?>
          <tr>
            <td align="right"><acronym title="<? echo $text[309] ?>"><? echo " ".$text[308]; ?></acronym></td>
            <td align="left"><input class="lmo-formular-input" type="password" name="xtipperpass" size="16" maxlength="32" value="<? echo $_SESSION['lmotipperpass']; ?>"></td>
          </tr>
          <tr>
            <td class="lmost5">&nbsp;</td>
            <td align="left"><input class="lmo-formular-button" title="<? echo $text[311] ?>" type="submit" name="xtippersub" value="<? echo $text['tipp'][12]; ?>"></td>
          </tr>
        </table>
      </form>
    </td>
  </tr>
  <tr>
    <td>
      <table class="lmoInner" width="100%" cellspacing="0" cellpadding="0" border="0">
        <tr>
          <th colspan="3"><? echo $text['tipp'][45]; ?></td>
        </tr>
        <tr>
          <td align="right" colspan="2"><? echo $text['tipp'][46]; ?></td>
          <td align="left">
            <form name="lmotippedit" action="<? echo $_SERVER['PHP_SELF']; ?>" method="post">
              <input type="hidden" name="action" value="tipp">
              <input type="hidden" name="todo" value="newtipper">
              <acronym title="<? echo $text['tipp'][11] ?>"><input class="lmo-formular-button" type="submit" name="xtippersub" value="<? echo $text['tipp'][11]; ?>" ></acronym>
            </form>
          </td>
        </tr>
      </table>
    </td>
  </tr>
  <tr>
    <td>
      <table class="lmoInner" width="100%" cellspacing="0" cellpadding="0" border="0">
        <tr>
          <th colspan="3"><? echo $text['tipp'][4]; ?></td>
        </tr>
        <tr>
          <td colspan="3" align="left">
            <ul><?
            $ftype=".l98"; 
            require(PATH_TO_ADDONDIR."/tipp/lmo-tippnewdir.php");
            $dummy =  explode("|",$tt1);
            $ftest2 = explode("|",$tt0);
            if(isset($dummy) && isset($ftest2)){
              for($u=0;$u<count($dummy);$u++){
                if($dummy[$u]!="" && $ftest2[$u]!=""){
                  $dummy[$u]=substr($dummy[$u],0,-4);
                  $auswertfile=PATH_TO_ADDONDIR."/tipp/".$tipp_dirtipp."auswert/".$dummy[$u].".aus";?>
              <li class="lmoadminli"><a href="<? echo $addw.$dirliga.$dummy[$u].".l98"; ?>"><? echo $ftest2[$u];if(file_exists($auswertfile)){echo "<br><small>".$text['tipp'][83].": ".date("d.m.Y H:i",filemtime($auswertfile))."</small>";}echo "</a>"; ?></li><?
                }
              }
            }
            if($tipp_gesamt==1 && $u>2){
              $auswertfile=PATH_TO_ADDONDIR."/tipp/".$tipp_dirtipp."auswert/gesamt.aus";?>
              <li class="lmoadminli"><a href="<? echo $addw."&amp;all=1" ?>"><strong><? echo $text['tipp'][25];if(file_exists($auswertfile)){echo "<br><small>".$text['tipp'][83].": ".date("d.m.Y H:i",filemtime($auswertfile))."</small>";}?> </strong></a></li><?
            }
            $auswertfile="";?>
            </ul>
          </td>
        </tr>
      </table>
    </td>
  </tr>
  <tr>
    <td>
      <form name="lmotippedit" action="<? echo $_SERVER['PHP_SELF']; ?>" method="post">
        <input type="hidden" name="action" value="tipp">
        <input type="hidden" name="todo" value="getpass">
        <table class="lmoInner" width="100%" cellspacing="0" cellpadding="0" border="0">
          <tr>
            <th colspan="3"><? echo $text['tipp'][74]; ?></td>
          </tr><?  
            // Benutzer nicht gefunden
            if($_SESSION["lmotipperok"]==-3){ ?> 
          <tr>
            <td align="right" colspan="3"><? echo $text['tipp'][43]; ?></td>
          </tr><? 
            }?>
          <tr>
            <td align="right"><? echo " ".$text['tipp'][23]." ".$text['tipp'][218]." ".$text['tipp'][219]; ?></td>
            <td align="left"><acronym title="<? echo $text[307] ?>"><input class="lmo-formular-input" type="text" name="xtippername2" size="16" maxlength="32" value="<? echo $xtippername2; ?>"></acronym>
          </tr>
          <tr>
            <td align="right"><? echo $text['tipp'][75]; ?></td>
            <td align="left"><acronym title="<? echo $text['tipp'][76] ?>"><input class="lmo-formular-button" type="submit" name="xtippersub" value="<? echo $text['tipp'][76]; ?>" ></acronym></td>
          </tr>
        </table>
      </form>
    </td>
  </tr>
  </tr><? 
  }
  //require(PATH_TO_ADDONDIR."/tipp/lmo-tippfusszeile.php"); ?>
</table><?
  }
}?>