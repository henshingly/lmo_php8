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
                array_shift($tipper);
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
    elseif($todo=="wert" && $all==1){}?>
<table class="lmomaina" cellspacing="0" cellpadding="0" border="0">
  <tr>
    <td class="lmomain0" colspan="3" align="center"><? echo $text['tipp'][0]." "; if(isset($titel)){echo $titel;} ?></td>
  </tr>
  <tr>
    <td class="lmomain1"><?
    if(isset($todo) && $todo!="logout"){echo "<a href=\"".$_SERVER['PHP_SELF']."?action=tipp\" title=\"".$text['tipp'][53]."\">".$text['tipp'][52]."</a>";}
    else{echo $text['tipp'][52];}
    echo "&nbsp;&nbsp;";
    if(isset($file) && $file!="" && $file!="viewer"){
      if($tipp_tippeinsicht==1){
        if($todo!="einsicht"){echo "<a href=\"".$adda."einsicht&amp;file=".$file."\" title=\"".$text['tipp'][157]."\">".$text['tipp'][157]."</a>";}
        else{echo $text['tipp'][157];}
        echo "&nbsp;&nbsp;";
        }
      if($lmtype==0 && $tipp_tipptabelle1==1 && $tipp_tipptabelle==1){
        if($todo!="tabelle"){echo "<a href=\"".$adda."tabelle&amp;file=".$file."&amp;endtab=".$endtab."&amp;nick=\" title=\"".$text['tipp'][184]."\">".$text['tipp'][172]."</a>";}
        else{echo $text['tipp'][172];}
        echo "&nbsp;&nbsp;";
        }
      if($tipp_tippfieber==1){
        if($todo!="fieber"){echo "<a href=\"".$adda."fieber&amp;file=".$file."\" title=\"".$text[134]."\">".$text[133]."</a>";}
        else{echo $text[133];}
        echo "&nbsp;&nbsp;";
        }
      if($todo!="wert" || $all==1){echo "<a href=\"".$adda."wert&amp;file=".$file."\" title=\"".$text['tipp'][54]."\">".$text['tipp'][54]."</a>";}
      else{echo $text['tipp'][54];}
      echo "&nbsp;&nbsp;";
      }
/*    if($tipp_gesamt==1){
      if($todo!="wert" || $all!=1){echo "<a href=\"".$adda."wert&amp;file=".$file."&amp;all=1\" title=\"".$text['tipp'][56]."\">".$text['tipp'][56]."</a>";}
      else{echo $text['tipp'][56];}
      }
*/    echo "&nbsp;&nbsp;";?>
    </td>
    <td class="lmomain1" width="8">&nbsp;</td>
    <td class="lmomain1" align="right"><?
    if($tipp_regeln==1){?>
        <a href='<?=$tipp_regelnlink?>' target='regeln' onclick='window.open(this.href,"regeln","resizable=yes");return false;'><?=$text['tipp'][185]?></a>&nbsp;&nbsp;<?
    }
    if(isset($todo) && $todo!="logout"){echo "<a href=\"".$_SERVER['PHP_SELF']."?action=tipp\" title=\"".$text['tipp'][159]."\">".$text['tipp'][159]."</a>";}
    else{echo $text['tipp'][159];}
    echo "&nbsp;&nbsp;";
    if($todo!="info"){echo "<a href=\"".$adda."info&amp;file=".$file."\" title=\"".$text[21]."\">".$text[20]."</a>";}else{echo $text[20];}
    echo "&nbsp;";?>
    </td>
  </tr>
  <tr>
    <td class="lmomain1" colspan="3" align="center"><? 
    if($todo=="wert"){require(PATH_TO_ADDONDIR."/tipp/lmo-tippwert.php");}
    elseif($todo=="fieber"){require(PATH_TO_ADDONDIR."/tipp/lmo-tippfieber.php");}
    elseif($todo=="einsicht"){require(PATH_TO_ADDONDIR."/tipp/lmo-tippeinsicht.php");}
    elseif($todo=="tabelle"){require(PATH_TO_ADDONDIR."/tipp/lmo-tipptabelle.php");}
    elseif($todo=="info"){require(PATH_TO_LMO."/lmo-showinfo.php");}
    else{?>
      <form name="lmotippedit" action="<? echo $_SERVER['PHP_SELF']; ?>" method="post">
        <input type="hidden" name="action" value="tipp">  
        <table width="100%" cellspacing="0" cellpadding="0" border="0">
          <tr>
            <td align="center" colspan="2" class="lmost1"><? echo $text['tipp'][158]; ?></td>
          </tr>
          <tr>
            <td class="lmost4" colspan="2"><? echo $text['tipp'][44]; ?></td>
          </tr><? 
      // Benutzer nicht gefunden
      if($_SESSION["lmotipperok"]==-2){?> 
          <tr>
            <td class="lmost5"  align="right" colspan="3"><span style="color:red"><? echo $text['tipp'][43]; ?></span></td>
          </tr><? 
      }
      // Benutzer nicht freigeschaltet
      if(isset($xtippersub) & $_SESSION["lmotipperok"]=="" && !isset($emailbody)){?> 
          <tr>
            <td class="lmost5"  align="right" colspan="3"><span style="color:red"><? echo $text['tipp'][148]; ?></span></td>
          </tr><? 
      }?>
          <tr>
            <td class="lmost5" align="right"><acronym title="<? echo $text[307] ?>"><? echo " ".$text['tipp'][23]; ?></acronym></td>
            <td class="lmost5" align="left"><acronym title="<? echo $text[307] ?>"><input class="lmoadminein" type="text" name="xtippername" size="16" maxlength="32" value="<? echo $_SESSION['lmotippername']; ?>"></acronym>
          </tr><?
      // Passwort falsch 
      if($_SESSION["lmotipperok"]==-1){ $xtippername2=$lmotippername;  ?> 
          <tr>
            <td class="lmost5" align="right" colspan="3"><span style="color:red"><? echo $text['tipp'][42]; ?></span></td>
          </tr><? 
      }?>
          <tr>
            <td class="lmost5" align="right"><acronym title="<? echo $text[309] ?>"><? echo " ".$text[308]; ?></acronym></td>
            <td class="lmost5" align="left"><acronym title="<? echo $text[309] ?>"><input class="lmoadminein" type="password" name="xtipperpass" size="16" maxlength="32" value="<? echo $_SESSION['lmotipperpass']; ?>"></acronym>
          </tr>
          <tr>
            <td class="lmost5">&nbsp;</td>
            <td class="lmost5" align="left"><acronym title="<? echo $text[311] ?>"><input class="lmoadminbut" type="submit" name="xtippersub" value="<? echo $text['tipp'][12]; ?>"></acronym></td>
          </tr>
        </table>
      </form>
    </td>
  </tr>
  <tr>
    <td class="lmost4" colspan="3"><? echo $text['tipp'][45]; ?></td>
  </tr>
  <tr>
    <td class="lmost5" align="right" colspan="2"><? echo $text['tipp'][46]; ?></td>
    <td class="lmost5" align="left">
      <form name="lmotippedit" action="<? echo $_SERVER['PHP_SELF']; ?>" method="post">
        <input type="hidden" name="action" value="tipp">
        <input type="hidden" name="todo" value="newtipper">
        <acronym title="<? echo $text['tipp'][11] ?>"><input class="lmoadminbut" type="submit" name="xtippersub" value="<? echo $text['tipp'][11]; ?>" ></acronym>
      </form>
    </td>
  </tr>
  <tr>
    <td class="lmost4" colspan="3"><? echo $text['tipp'][4]; ?></td>
  </tr>
  <tr>
    <td class="lmost5" colspan="3" align="left">
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
  <tr>
    <td class="lmost4" colspan="3"><? echo $text['tipp'][74]; ?></td>
  </tr><?  
      // Benutzer nicht gefunden
      if($_SESSION["lmotipperok"]==-3){ ?> 
  <tr>
    <td class="lmost5" align="right" colspan="3"><span style="color:red"><? echo $text['tipp'][43]; ?></span></td>
  </tr><? 
      }?>
  <tr>
    <td colspan="3" class="lmost3" align="left">
      <form name="lmotippedit" action="<? echo $_SERVER['PHP_SELF']; ?>" method="post">
        <input type="hidden" name="action" value="tipp">
        <input type="hidden" name="todo" value="getpass">
        <table width="100%" cellspacing="0" cellpadding="0" border="0">
          <tr>
            <td class="lmost5" align="right"><? echo " ".$text['tipp'][23]." ".$text['tipp'][218]." ".$text['tipp'][219]; ?></td>
            <td class="lmost5" align="left"><acronym title="<? echo $text[307] ?>"><input class="lmoadminein" type="text" name="xtippername2" size="16" maxlength="32" value="<? echo $xtippername2; ?>"></acronym>
          </tr>
          <tr>
            <td class="lmost5" align="right"><? echo $text['tipp'][75]; ?></td>
            <td class="lmost5" align="left"><acronym title="<? echo $text['tipp'][76] ?>"><input class="lmoadminbut" type="submit" name="xtippersub" value="<? echo $text['tipp'][76]; ?>" ></acronym></td>
          </tr>
        </table>
      </form>
    </td>
  </tr><? 
  }
  require(PATH_TO_ADDONDIR."/tipp/lmo-tippfusszeile.php"); ?>
</table><?
  }
}?>