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
require_once(PATH_TO_LMO."/lmo-admintest.php");
function getmicrotime(){
  list($usec, $sec) = explode(" ",microtime());
  return ((float)$usec + (float)$sec);
}
$startzeit = getmicrotime();
if($action=="admin"){
  $me=array("0","January","February","March","April","May","June","July","August","September","October","November","December");
  $adda=$_SERVER['PHP_SELF']."?action=admin&amp;todo=";
  if(!isset($st)){$sty=0;}else{$sty=$st;}
  if(!isset($newpage)){$newpage=0;}
  $file=isset($_REQUEST['file'])?$_REQUEST['file']:"";
  include_once(PATH_TO_LMO."/lmo-adminjavascript.php");

?>
<table class="lmoMain" cellspacing="0" cellpadding="0" border="0">
  <tr>
    <td align="center"><h1><?=$text[77]." ".$text[54];?></h1></td>
    <td class="lmoFooter" align="right"><?
  $handle=opendir (PATH_TO_LANGDIR);
    while (false!==($f=readdir($handle))) {
      if (preg_match("/^lang-?(.*)?\.txt$/",$f,$lang)>0) {
        if ($lang[1]=="") $lang[1]=$text[505];
        if ($lang[1]!=$lmouserlang) {
          echo "<a href='{$_SERVER['PHP_SELF']}?lmouserlang={$lang[1]}&amp;action={$action}&amp;todo={$todo}&amp;file={$file}' title='{$lang[1]}'>";
          $imgfile=URL_TO_IMGDIR.'/'.$lang[1].".gif";
          
          if (!@fopen($imgfile,"rb")) {
            echo $lang[1];
          }else{
            $c=@getimagesize($imgfile);
            echo "<img src='{$imgfile}' border='1' title='{$lang[1]}' {$c[3]} alt='{$lang[1]}'>";
          }
          echo "</a> ";
        }
      } 
    }
    closedir($handle);?>
    </td>
  </tr>
  <tr>
    <td class="lmoMenu" align="left"><?
require_once(PATH_TO_LMO."/lmo-openfile.php");
if($_SESSION['lmouserok']==2){
  if($todo!="new"){echo "<a href='{$adda}new&amp;newpage={$newpage}' onclick='return chklmolink(this.href);' title='{$text[79]}'>{$text[78]}</a>";}else{echo $text[78];}
  echo "&nbsp;";
  
/* Importfunktion Anfang
  if($todo!="import"){echo "<a href='{$adda}import&amp;imppage=".$newpage."' onclick='return chklmolink(this.href);' title=\""."Eine neue Liga aus einem Spielplan importieren"."\">"."Import"."</a>";}else{echo "Import";}
  echo "&nbsp;";
// Importfunktion Ende*/
  
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
    if($todo!="statistik"){echo "<a href='{$adda}statistik&amp;file={$file}' onclick='return chklmolink(this.href);' title='{$text['spieler'][1]}'>{$text['spieler'][18]}</a>";}else{echo $text['spieler'][18];}echo "&nbsp;";  
  } 
  echo "&nbsp;";
  if(($todo!="options") && ($todo!="addons") && ($todo!="user") && ($todo!="design")){echo "<a href='{$adda}options' onclick='return chklmolink(this.href);' title='{$text[87]}'>{$text[86]}</a>";}else{echo $text[86];}
  echo "&nbsp;";
  if(($todo!="tipp") && ($todo!="tippemail") && ($todo!="tippuser") && ($todo!="tippuseredit") && ($todo!="tippoptions")){echo "<a href='{$adda}tipp' onclick='return chklmolink(this.href);' title='{$text['tipp'][57]}'>{$text['tipp'][0]}</a>";}else{echo $text['tipp'][0];}
  }
elseif($_SESSION['lmouserok']==1){
  if($todo!="open"){echo "<a href='{$adda}open' onclick='return chklmolink(this.href);' title='{$text[81]}'>{$text[80]}</a>";}else{echo $text[80];}
  echo "&nbsp;";
  if($file!=""){
    if(($todo!="edit") && ($todo!="tabs")){echo "<a href='{$adda}edit&amp;file={$file}' onclick='return chklmolink(this.href);' title='{$text[91]}'>{$text[90]}</a>";}else{echo $text[90];}
    echo "&nbsp;";
    }
  if($todo!="download"){echo "<a href='{$adda}download' onclick='return chklmolink(this.href);' title='{$text[315]}'>{$text[314]}</a>";}else{echo $text[314];}
  if($file!="" && $einspieler==1){
    echo "&nbsp;";
    require_once(PATH_TO_LMO."/lmo-openfile.php");
    if($todo!="statistik"){echo "<a href='{$adda}statistik&amp;file={$file}' onclick='return chklmolink(this.href);' title='{$text['spieler'][1]}'>{$text['spieler'][18]}</a>";}else{echo $text['spieler'][18];}echo "&nbsp;";  
    } 
  }?>
    </td>
    <td class="lmoMenu" align="right"><?
  echo "<a href='{$adda}logout' onclick='return chklmolink(this.href);' title='{$text[89]}'>{$text[88]}</a>";
  echo "&nbsp;";
  if($_SESSION['lmouserok']==2){echo "<a href='lmohelp1.htm' target='_blank' title='{$text[313]}'>{$text[312]}</a>";}else{echo "<a href='lmohelp2.htm' target='_blank' title='{$text[313]}'>{$text[312]}</a>";}?>
     </td>
  </tr>
  <tr>
    <td colspan="2" align="center"><?
  if($_SESSION['lmouserok']==2){
    $addr_options=$_SERVER['PHP_SELF']."?action=admin&amp;todo=options";
    $addr_addons=$_SERVER['PHP_SELF']."?action=admin&amp;todo=addons";
    $addr_design=$_SERVER['PHP_SELF']."?action=admin&amp;todo=design";
    $addr_user=$_SERVER['PHP_SELF']."?action=admin&amp;todo=user";
    /*Tippspiel-Addon*/
    $tipp_addr_auswertung = $_SERVER['PHP_SELF']."?action=admin&amp;todo=tipp";
    $tipp_addr_email = $_SERVER['PHP_SELF']."?action=admin&amp;todo=tippemail";
    $tipp_addr_user=$_SERVER['PHP_SELF']."?action=admin&amp;todo=tippuser";
    $tipp_addr_optionen = $_SERVER['PHP_SELF']."?action=admin&amp;todo=tippoptions";
    /*Tippspiel-Addon*/
    if($todo=="new"){require(PATH_TO_LMO."/lmo-adminnew.php");}
    elseif($todo=="open"){require(PATH_TO_LMO."/lmo-adminopen.php");}
    elseif($todo=="delete"){require(PATH_TO_LMO."/lmo-admindelete.php");}
    elseif($todo=="edit"){
      if($sty==-1){require(PATH_TO_LMO."/lmo-adminbasic.php");}
      elseif($sty==-2){require(PATH_TO_LMO."/lmo-adminteams.php");}
      elseif($sty==-3){require(PATH_TO_LMO."/lmo-adminanz.php");}
      else{require(PATH_TO_LMO."/lmo-adminedit.php");}
    }
    elseif($todo=="tabs"){require(PATH_TO_LMO."/lmo-admintab.php");}
    elseif($todo=="upload"){require(PATH_TO_LMO."/lmo-adminupload.php");}
    elseif($todo=="download"){require(PATH_TO_LMO."/lmo-admindown.php");}
    elseif($todo=="options"){require(PATH_TO_LMO."/lmo-adminoptions.php");}
    elseif($todo=="user"){require(PATH_TO_LMO."/lmo-adminuser.php");}
    elseif($todo=="addons"){require(PATH_TO_LMO."/lmo-adminaddon.php");}
    elseif($todo=="design"){require(PATH_TO_LMO."/lmo-admindesign.php");}
    elseif($todo=="statistik"){include(PATH_TO_ADDONDIR."/spieler/lmo-statadmin.php");}
    elseif($todo=="tipp"){require(PATH_TO_ADDONDIR."/tipp/lmo-admintipp.php");}
    elseif($todo=="tippemail"){require(PATH_TO_ADDONDIR."/tipp/lmo-admintippemail.php");}
    elseif($todo=="tippuser"){require(PATH_TO_ADDONDIR."/tipp/lmo-admintippuser.php");}
    elseif($todo=="tippuseredit"){require(PATH_TO_ADDONDIR."/tipp/lmo-admintippuseredit.php");}
    elseif($todo=="tippoptions"){require(PATH_TO_ADDONDIR."/tipp/lmo-admintippoptions.php");}
    elseif($todo==""){require(PATH_TO_LMO."/lmo-adminpad.php");}
    
// Importer Start
  	elseif($todo=="import"){require(PATH_TO_ADDONDIR."/limporter/lmo-adminimport.php");}
// Importer Ende
    
  }
  elseif($_SESSION['lmouserok']==1){
    if($todo=="open"){require(PATH_TO_LMO."/lmo-adminopen.php");}
    elseif($todo=="edit"){
      if($sty==-1){require(PATH_TO_LMO."/lmo-adminbasic.php");}
      else{require(PATH_TO_LMO."/lmo-adminedit.php");}
    }
    elseif($todo=="tabs"){require(PATH_TO_LMO."/lmo-admintab.php");}
    elseif($todo=="download"){require(PATH_TO_LMO."/lmo-admindown.php");}
    elseif($todo==""){require(PATH_TO_LMO."/lmo-adminpad.php");}
    elseif($todo=="statistik"){include(PATH_TO_ADDONDIR."/spieler/lmo-statadmin.php");}
    
  }?>
    </td>
  </tr><?
  if($file!=""){?>
  <tr>
    <td class="lmoFooter" colspan="2" align="right">
      <a href="<?=URL_TO_LMO."/lmo.php?file=".$file;?>" target="_blank" title="<?=$text[116]?>"><?=$text[115]?></a>
    </td>
  </tr><?
  }?>
  <tr>
    <td class="lmoFooter" colspan="2" align="right"><? echo $text[471].": ".number_format((getmicrotime()-$startzeit),4,".",",")." sek."; ?></td>
  </tr>
</table><? 
}?>