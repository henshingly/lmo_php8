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
require_once("lmo-admintest.php");
function getmicrotime(){
  list($usec, $sec) = explode(" ",microtime());
  return ((float)$usec + (float)$sec);
  }
$startzeit = getmicrotime();
if($action=="admin"){
  $me=array("0","January","February","March","April","May","June","July","August","September","October","November","December");
  $adda=$PHP_SELF."?action=admin&amp;todo=";
  $addx="lmo-start.php?file=";
  if(!isset($st)){$sty=0;}else{$sty=$st;}
  if(!isset($newpage)){$newpage=0;}
  if(!isset($file)){$file="";}
  include("lmo-admincheckjsscript.php");
?>
<table class="lmomaina" cellspacing="0" cellpadding="0" border="0">
  <tr>
    <td class="lmomain0" colspan="3" align="center">
      <? echo "{$text[77]} {$text[54]}"; ?>
    </td>
  </tr>
  <tr>
    <td class="lmomain1"><?
if($lmouserok==2){
  if($todo!="new"){echo "<a href='{$adda}new&amp;newpage={$newpage}' onclick='return chklmolink(this.href);' title='{$text[79]}'>{$text[78]}</a>";}else{echo $text[78];}
  echo "&nbsp;";
  if($todo!="open"){echo "<a href='{$adda}open' onclick='return chklmolink(this.href);' title='{$text[81]}'>{$text[80]}</a>";}else{echo $text[80];}
  echo "&nbsp;";
  if($todo!="delete"){echo "<a href='{$adda}delete' onclick='return chklmolink(this.href);' title='{$text[83]}'>{$text[82]}</a>";}else{echo $text[82];}
  echo "&nbsp;";
  if($file!=""){
    if(($todo!="edit") && ($todo!="tabs")){echo "<a href='{$adda}edit&amp;file={$file}' onclick='return chklmolink(this.href);' title='{$text[91]}'>{$text[90]}</a>";}else{echo $text[90];}
    echo "&nbsp;";
    }
  if($todo!="upload"){echo "<a href='{$adda}upload' onclick='return chklmolink(this.href);' title='{$text[85]}'>{$text[84]}</a>";}else{echo $text[84];}
  echo "&nbsp;";
  if($todo!="download"){echo "<a href='{$adda}download' onclick='return chklmolink(this.href);' title='{$text[315]}'>{$text[314]}</a>";}else{echo $text[314];}
  if($file!="" && $einspieler==1){
    echo "&nbsp;";
    require("lmo-openfile.php");
    if($todo!="statistik"){echo "<a href='{$adda}statistik&amp;file={$file}' onclick='return chklmolink(this.href);' title='{$text[3001]}'>{$text[3000]}</a>";}else{echo $text[3000];}echo "&nbsp;";  
  } 
  echo "&nbsp;";
  if(($todo!="options") && ($todo!="user") && ($todo!="design")){echo "<a href='{$adda}options' onclick='return chklmolink(this.href);' title='{$text[87]}'>{$text[86]}</a>";}else{echo $text[86];}
  echo "&nbsp;";
  if(($todo!="tipp") && ($todo!="tippemail") && ($todo!="tippuser") && ($todo!="tippuseredit") && ($todo!="tippoptions")){echo "<a href='{$adda}tipp' onclick='return chklmolink(this.href);' title='{$text[2057]}'>{$text[2000]}</a>";}else{echo $text[2000];}
  }
elseif($lmouserok==1){
  if($todo!="open"){echo "<a href='{$adda}open' onclick='return chklmolink(this.href);' title='{$text[81]}'>{$text[80]}</a>";}else{echo $text[80];}
  echo "&nbsp;";
  if($file!=""){
    if(($todo!="edit") && ($todo!="tabs")){echo "<a href='{$adda}edit&amp;file={$file}' onclick='return chklmolink(this.href);' title='{$text[91]}'>{$text[90]}</a>";}else{echo $text[90];}
    echo "&nbsp;";
    }
  if($todo!="download"){echo "<a href='{$adda}download' onclick='return chklmolink(this.href);' title='{$text[315]}'>{$text[314]}</a>";}else{echo $text[314];}
  if($file!="" && $einspieler==1){
    echo "&nbsp;";
    require("lmo-openfile.php");
    if($todo!="statistik"){echo "<a href='{$adda}statistik&amp;file={$file}' onclick='return chklmolink(this.href);' title='{$text[3001]}'>{$text[3000]}</a>";}else{echo $text[3000];}echo "&nbsp;";  
    } 
  }?>
    </td>
    <td class="lmomain1" width="8">&nbsp;</td>
    <td class="lmomain1" align="right"><?
  echo "<a href='{$adda}logout' onclick='return chklmolink(this.href);' title='{$text[89]}'>{$text[88]}</a>";
  echo "&nbsp;";
  if($lmouserok==2){echo "<a href='lmohelp1.htm' target='_blank' title='{$text[313]}'>{$text[312]}</a>";}else{echo "<a href='lmohelp2.htm' target='_blank' title='{$text[313]}'>{$text[312]}</a>";}?>
     </td>
  </tr>
  <tr>
    <td class="lmomain1" colspan="3" align="center"><?
  if($lmouserok==2){
    $addr_options=$PHP_SELF."?action=admin&amp;todo=options";
    $addr_addons=$PHP_SELF."?action=admin&amp;todo=addons";
    $addr_design=$PHP_SELF."?action=admin&amp;todo=design";
    $addr_user=$PHP_SELF."?action=admin&amp;todo=user";
    
    if($todo=="new"){require("lmo-adminnew.php");}
    elseif($todo=="open"){require("lmo-adminopen.php");}
    elseif($todo=="delete"){require("lmo-admindelete.php");}
    elseif($todo=="edit"){
      if($sty==-1){require("lmo-adminbasic.php");}
      elseif($sty==-2){require("lmo-adminteams.php");}
      elseif($sty==-3){require("lmo-adminanz.php");}
      else{require("lmo-adminedit.php");}
    }
    elseif($todo=="tabs"){require("lmo-admintab.php");}
    elseif($todo=="upload"){require("lmo-adminupload.php");}
    elseif($todo=="download"){require("lmo-admindown.php");}
    elseif($todo=="options"){require("lmo-adminoptions.php");}
    elseif($todo=="user"){require("lmo-adminuser.php");}
    elseif($todo=="addons"){require("lmo-adminaddon.php");}
    elseif($todo=="design"){require("lmo-admindesign.php");}
    elseif($todo=="statistik"){include("lmo-statadmin.php");}
    elseif($todo=="tipp"){require("lmo-admintipp.php");}
    elseif($todo=="tippemail"){require("lmo-admintippemail.php");}
    elseif($todo=="tippuser"){require("lmo-admintippuser.php");}
    elseif($todo=="tippuseredit"){require("lmo-admintippuseredit.php");}
    elseif($todo=="tippoptions"){require("lmo-admintippoptions.php");}
    elseif($todo==""){require("lmo-adminpad.php");}
  }
  elseif($lmouserok==1){
    if($todo=="open"){require("lmo-adminopen.php");}
    elseif($todo=="edit"){
      if($sty==-1){require("lmo-adminbasic.php");}
      else{require("lmo-adminedit.php");}
    }
    elseif($todo=="tabs"){require("lmo-admintab.php");}
    elseif($todo=="download"){require("lmo-admindown.php");}
    elseif($todo==""){require("lmo-adminpad.php");}
    elseif($todo=="statistik"){include("lmo-statadmin.php");}
  }?>
    </td>
  </tr>
  <tr>
    <td class="lmomain1" colspan="3" align="right"><? 
  if($file!=""){echo "<a href='{$addx}{$file}' target='_blank' title='{$text[116]}'>{$text[115]}</a>";} ?>
    </td>
  </tr>
  <tr>
    <td class="lmomain2" colspan="3" align="right"><? echo $text[471].": ".number_format((getmicrotime()-$startzeit),4,".",",")." sek."; ?></td>
  </tr>
</table><? 
}?>