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
require_once(PATH_TO_ADDONDIR."/tipp/lmo-tipptest.php");

if($action=="tipp"){
  if($file!=""){$addm=$_SERVER['PHP_SELF']."?file=".$file."&amp;action=";}
  if($_SESSION["lmotipperok"]==5){
  if(($todo=="edit" && $file!="viewer") || $todo=="einsicht"){require(PATH_TO_LMO."/lmo-openfilest.php");}
  elseif($todo=="tabelle"){require_once(PATH_TO_LMO."/lmo-openfile.php");}
  elseif(($todo=="wert" && $all!=1) || $todo=="fieber"){require(PATH_TO_LMO."/lmo-openfilename.php");}
  elseif($todo=="wert" && $all==1){}
  }
$me=array("0","January","February","March","April","May","June","July","August","September","October","November","December");
$adda=$_SERVER['PHP_SELF']."?action=tipp&amp;todo=";
$addx="lmo-tippstart.php?file=";
//if(!isset($st)){$st=$stx;}else{$sty=$st;}
if(!isset($newpage)){$newpage=0;}
if(!isset($file)){$file="";}
if(!isset($tippfile)){$tippfile="";}
if(!isset($tipp_tipptabelle1)){$tipp_tipptabelle1=1;}
?>

<?PHP if($tipp_tippmodus==1 && $todo=="edit"){ ?>
<script language="JavaScript">
<!---
<?PHP if($tipp_pfeiltipp==1){ ?>
img0 = new Image();
img0.src = "<?=PATH_TO_IMGDIR?>/img/lmo-admin0.gif";
img1 = new Image();
img1.src = "<?=PATH_TO_IMGDIR?>/img/lmo-admin1.gif";
img2 = new Image();
img2.src = "<?=PATH_TO_IMGDIR?>/img/lmo-admin2.gif";
img3 = new Image();
img3.src = "<?=PATH_TO_IMGDIR?>/img/lmo-admin3.gif";
function lmoimg(x,y){
  document.getElementsByName("ximg"+x)[0].src = y.src;
  }
<?PHP } ?>
function lmotorclk(x,y,z){
  if(document.all && !window.opera){
    if(z==38){lmotorauf(x,y,1);}
    if(z==40){lmotorauf(x,y,-1);}
    }
  }

function lmotorauf(x,y,z){
  if(x=="a"){xx="b";}
  if(x=="b"){xx="a";}
  var a=document.getElementsByName("xtipp"+x+y)[0].value;
  if(a==""){a="-1";}
  if(a=="_"){a="-1";}
  var aa=document.getElementsByName("xtipp"+xx+y)[0].value;
  if(aa==""){aa="-1";}
  if(aa=="_"){aa="-1";}
  var ab=aa;
  if(isNaN(a)==true){a=0;}else{a=parseInt(a);}
  if((z==1) && (a<9999)){a++;}
  if((z==-1) && (a>-1)){a--;}
  if((a>-1) && (aa<0)){aa=0;}
  if((a<0) && (aa>-1)){aa=-1;}
  if(a==-1){a="";}
  document.getElementsByName("xtipp"+x+y)[0].value=a;
  if(ab!=aa){
    if(aa==-1){aa="";}
    document.getElementsByName("xtipp"+xx+y)[0].value=aa;
    }  
  }
// --->
</script>
<?PHP } ?>

<table class="lmomaina" cellspacing="0" cellpadding="0" border="0">
  <tr>
    <td class="lmomain0" colspan="3" align="center"><nobr><?PHP echo $text['tipp'][0]." ";if(isset($titel)){echo $titel;} ?></nobr>
    </td>
  </tr><tr>
    <td class="lmomain1"><nobr>

<?PHP
    if($todo!=""){echo "<a href=\"".$_SERVER['PHP_SELF']."?action=tipp\" title=\"".$text['tipp'][53]."\">".$text['tipp'][52]."</a>";}
    else{echo $text['tipp'][52];}
    echo "&nbsp;&nbsp;";
    if($file=="viewer"){
      echo $text['tipp'][9]."&nbsp;&nbsp;";
      }
    elseif($file!=""){
      if($tipp_sttipp!=-1){
        if($todo!="edit"){echo "<a href=\"".$adda."edit&amp;file=".$file."&amp;st=".$st."\" title=\"".$text['tipp'][9]."\">".$text['tipp'][9]."</a>";}
        else{echo $text['tipp'][9];}
        echo "&nbsp;&nbsp;";
        }
      if($tipp_tippeinsicht==1){
        if($todo!="einsicht"){echo "<a href=\"".$adda."einsicht&amp;file=".$file."&amp;st=".$st."\" title=\"".$text['tipp'][157]."\">".$text['tipp'][157]."</a>";}
        else{echo $text['tipp'][157];}
        echo "&nbsp;&nbsp;";
        }
      if($lmtype==0 && $tipp_tipptabelle1==1){
        if($todo!="tabelle"){echo "<a href=\"".$adda."tabelle&amp;file=".$file."\" title=\"".$text['tipp'][173]."\">".$text['tipp'][172]."</a>";}
        else{echo $text['tipp'][172];}
        echo "&nbsp;&nbsp;";
        }
      if($tipp_tippfieber==1){
        if($todo!="fieber"){echo "<a href=\"".$adda."fieber&amp;file=".$file."\" title=\"".$text[134]."\">".$text[133]."</a>";}
        else{echo $text[133];}
        echo "&nbsp;&nbsp;";
        }
      if($todo!="wert" || $all==1){echo "<a href=\"".$adda."wert&amp;file=".$file."&amp;endtab=".$endtab."&amp;wertung=einzel\" title=\"".$text['tipp'][54]."\">".$text['tipp'][54]."</a>";}
      else{echo $text['tipp'][54];}
      echo "&nbsp;&nbsp;";
      }
/*
    if($tipp_gesamt==1){
      if($todo!="wert" || $all!=1){echo "<a href=\"".$adda."wert&amp;file=".$file."&amp;wertung=einzel&amp;all=1\" title=\"".$text['tipp'][56]."\">".$text['tipp'][56]."</a>";}
      else{echo $text['tipp'][56];}
      }
    echo "&nbsp;&nbsp;";
*/
?>
    </nobr></td>
    <td class="lmomain1" width="8">&nbsp;</td>
    <td class="lmomain1" align="right"><nobr>
<?PHP
    if($tipp_regeln==1){
      echo "<a href=\"".$tipp_regelnlink."\">".$text['tipp'][185]."</a>";
      echo "&nbsp;&nbsp;";
      }
    echo "<a href=\"".$adda."logout\">".$text[88]."</a>";
    echo "&nbsp;&nbsp;";
    if($todo!="info"){echo "<a href=\"".$adda."info&amp;file=".$file."\" title=\"".$text[21]."\">".$text[20]."</a>";}else{echo $text[20];}
    echo "&nbsp;";
?>
      
    </nobr></td>
  </tr><tr>
    <td class="lmomain1" colspan="3" align="center">

<?PHP
if($_SESSION["lmotipperok"]==5){
  if($file!="" && $file!="viewer"){$tippfile=PATH_TO_ADDONDIR."/tipp/".$tipp_dirtipp.substr($file,strrpos($file,"/")+1,-4)."_".$lmotippername.".tip";}
  
  if($file=="viewer"){require(PATH_TO_ADDONDIR."/tipp/lmo-tippviewer.php");}
  elseif($todo=="edit"){require(PATH_TO_ADDONDIR."/tipp/lmo-tippedit.php");}
  elseif($todo=="einsicht"){require(PATH_TO_ADDONDIR."/tipp/lmo-tippeinsicht.php");}
  elseif($todo=="tabelle"){require(PATH_TO_ADDONDIR."/tipp/lmo-tipptabelle.php");}
  elseif($todo=="fieber"){require(PATH_TO_ADDONDIR."/tipp/lmo-tippfieber.php");}
  elseif($todo=="wert"){require(PATH_TO_ADDONDIR."/tipp/lmo-tippwert.php");}
  elseif($todo=="daten"){require(PATH_TO_ADDONDIR."/tipp/lmo-tippdaten.php");}
  elseif($todo=="newligen"){require(PATH_TO_ADDONDIR."/tipp/lmo-tippnewligen.php");}
  elseif($todo=="delligen"){require(PATH_TO_ADDONDIR."/tipp/lmo-tippdelligen.php");}
  elseif($todo=="pwchange"){require(PATH_TO_ADDONDIR."/tipp/lmo-tipppwchange.php");}
  elseif($todo=="delaccount"){require(PATH_TO_ADDONDIR."/tipp/lmo-tippdelaccount.php");}
  elseif($todo=="info"){require(PATH_TO_LMO."/lmo-showinfo.php");}
  else{require(PATH_TO_ADDONDIR."/tipp/lmo-tipppad.php");}
  }
?>
    </td>
  </tr>
<?PHP require(PATH_TO_ADDONDIR."/tipp/lmo-tippfusszeile.php"); ?>
</table>

<?PHP } ?>