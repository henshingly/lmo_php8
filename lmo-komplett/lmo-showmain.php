<?PHP
// 
// LigaManager Online 3.02b
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
function getmicrotime(){
  list($usec, $sec) = explode(" ",microtime());
  return ((float)$usec + (float)$sec);
  }
$startzeit = getmicrotime();
if(($file!="") && ($action!="")){
  $addm=$PHP_SELF."?file=".$file."&amp;action=";
  if(!isset($endtab)){
    $endtab=$anzst;
    $ste=$st;
    $tabdat="";
    }
  else{
    $tabdat=$endtab.". ".$text[2];
    $ste=$endtab;
    }
?>

<table class="lmomaina" cellspacing="0" cellpadding="0" border="0">
  <tr><td class="lmomain0" colspan="3" align="center"><nobr><?PHP echo $titel; ?></nobr></td></tr>

<?PHP if(($nticker==1) && ($file!="")){ ?>
<script language="JavaScript">
<!--
var msg1="";
<?PHP
  for($i=0;$i<count($nlines);$i++){
?>
  msg1=msg1+"<?PHP echo $nlines[$i]; ?> +++ ";
<?PHP } ?>
  var laenge=msg1.length;
  var timerID = null;
  var timerRunning = false;
  var id,pause=0,position=0;
  function marquee(){
    var i,k,msg=msg1;
    k=(52/msg.length)+1;
    for(i=0;i<=k;i++) msg+=""+msg;
    document.marqueeform.marquee.value=msg.substring(position,position+120);
    if(position++==laenge) position=0;
    id=setTimeout("marquee()",1000/10);
    }
  function action(){
    if(!pause) {
      clearTimeout(id);
      pause=1;
      }
    else{
      marquee();
      pause=0;
    }
  }
  document.write("<tr><td class=\"lmomain1\" colspan=\"3\" align=\"center\"><nobr><FORM NAME=\"marqueeform\"><INPUT class=\"lmotickerein\" TYPE=\"TEXT\" NAME=\"marquee\" SIZE=\"52\" readonly></FORM></nobr></td></tr>");
  document.close();
  marquee();
-->
</script>
<?PHP } ?>

  <tr>
    <td class="lmomain1"><nobr>

<?PHP

  if ($einspieler==1) { 
  if(!isset($mittore)){$mittore=0;}
  } 
  if($lmtype==0){
    if($datc==1){
      if($action!="cal"){echo "<a href=\"".$addm."cal&amp;st=".$st."\" title=\"".$text[141]."\">".$text[140]."</a>";}else{echo $text[140];}
      echo "&nbsp;&nbsp;";
      }
    if($tabonres==0){
      if($action!="results"){echo "<a href=\"".$addm."results&amp;st=".$ste."\" title=\"".$text[11]."\">".$text[10]."</a>";}else{echo $text[10];}
      echo "&nbsp;&nbsp;";
      if($action!="table"){echo "<a href=\"".$addm."table\" title=\"".$text[17]."\">".$text[16]."</a>";}else{echo $text[16];}
      }
    else{
      if($action!="results"){echo "<a href=\"".$addm."results\" title=\"".$text[104]."\">".$text[10]."/".$text[16]."</a>";}else{echo $text[10]."/".$text[16];}
      }
    echo "&nbsp;&nbsp;";
    if($kreuz==1){
      if($action!="cross"){echo "<a href=\"".$addm."cross\" title=\"".$text[15]."\">".$text[14]."</a>";}else{echo $text[14];}
      echo "&nbsp;&nbsp;";
      }
    if($action!="program"){echo "<a href=\"".$addm."program\" title=\"".$text[13]."\">".$text[12]."</a>";}else{echo $text[12];}
    echo "&nbsp;&nbsp;";
    if($kurve==1){
      if($action!="graph"){echo "<a href=\"".$addm."graph&amp;stat1=".$stat1."&amp;stat2=".$stat2."\" title=\"".$text[134]."\">".$text[133]."</a>";}else{echo $text[133];}
      echo "&nbsp;&nbsp;";
      }
    if($action!="stats"){echo "<a href=\"".$addm."stats&amp;stat1=".$stat1."&amp;stat2=".$stat2."\" title=\"".$text[19]."\">".$text[18]."</a>";}else{echo $text[18];}
    if ($einspieler==1) {
	include("lmo-statloadconfig.php");
	echo "&nbsp;&nbsp;";
	if($action!="spieler" && $mittore==1) {echo "<a href=\"".$addm."spieler\" title=\"".$text[3012]."\">".$ligalink."</a> ";}else{if($mittore==1)echo $ligalink." ";}
	}
    }
  else{
    if($datc==1){
      if($action!="cal"){echo "<a href=\"".$addm."cal&amp;st=".$st."\" title=\"".$text[141]."\">".$text[140]."</a>";}else{echo $text[140];}
      echo "&nbsp;&nbsp;";
      }
    if($action!="results"){echo "<a href=\"".$addm."results\" title=\"".$text[367]."\">".$text[10]."</a>";}else{echo $text[10];}
    echo "&nbsp;&nbsp;";
    if($action!="program"){echo "<a href=\"".$addm."program\" title=\"".$text[13]."\">".$text[12]."</a>";}else{echo $text[12];}
    }
?>

    </nobr></td>
    <td class="lmomain1" width="8">&nbsp;</td>
    <td class="lmomain1" align="right"><nobr>

<?PHP
  if($action!="info"){echo "<a href=\"".$addm."info\" title=\"".$text[21]."\">".$text[20]."</a>";}else{echo $text[20];}
?>
      
    </nobr></td>
  </tr><tr>
    <td class="lmomain1" colspan="3" align="center">

<?PHP
  $druck=0;
  if($lmtype==0){
    if($action=="cal"){if($datc==1){require("lmo-showcal.php");}}
    if($tabonres==0){
      if($action=="results"){require("lmo-showresults.php");if(file_exists("lmo-savehtml.php")){$druck=1;}}
      if($action=="table"){require("lmo-showtable.php");}
      }
    else{
      if($action=="results"){require("lmo-showrestab.php");}
      }
    if($kreuz==1){
      if($action=="cross"){require("lmo-showcross.php");}
      }
    if($action=="program"){require("lmo-showprogram.php");}
    if($kurve==1){
      if($action=="graph"){require("lmo-showgraph.php");}
      }
    if($action=="stats"){require("lmo-showstats.php");}
    if ($einspieler==1) {
	if($action=="spieler" && $mittore==1){require("lmo-statshow.php");}
    }
	}
  else{
    if($action=="cal"){if($datc==1){require("lmo-showkocal.php");}}
    if($action=="results"){require("lmo-showkoresults.php");}
    if($action=="program"){require("lmo-showkoprogram.php");}
    if ($einspieler==1) {
	if($action=="spieler" && $mittore==1){require("lmo-statshow.php");}
    }
	}
  if($action=="info"){require("lmo-showinfo.php");}
?>

    </td>
  </tr>
  <tr><td class="lmomain2" colspan="3" align="center">
    <?PHP if ($einsavehtml==1) { ?>
	<table width="100%" cellspacing="0" cellpadding="0" border="0"><tr>
	  <? if($lmtype==0 || $druck==1){include("lmo-savehtml.php");}?> 
	  <td class="lmomain1" align="center"><?PHP if($lmtype==0 and $druck==1){echo "<a href=\"".$wmldir.basename($file)."-st.html"."\" target=\"_blank\" title=\"".$text[477]."\">".$text[478]."</a>&nbsp;";}?></td>  
      <td class="lmomain1" align="center"><?PHP if($lmtype==0 and $druck==1){echo "<a href=\"".$wmldir.basename($file)."-sp.html"."\" target=\"_blank\" title=\"".$text[479]."\">".$text[480]."</a>&nbsp;";}?></td>
	</tr></table>
	<?PHP } ?>
  </td></tr>
  <tr><td class="lmomain2" colspan="3" align="right">
    <table width="100%" cellspacing="0" cellpadding="0" border="0"><tr>
      <td class="lmomain1" valign="bottom">
<?PHP
 if ($eintippspiel==1) {
 if($tippspiel==1 && ($immeralle==1 || strpos($ligenzutippen, substr($file,strrpos($file,"//")+1,-4))>-1)){echo "<a href=\"".$PHP_SELF."?action=tipp&amp;file=".$file."&amp;todo=edit\">".$text[5]." ".$text[2094]."</a>&nbsp;&nbsp;&nbsp;<br>";
   }
 }  
 else{
   echo "&nbsp;<br>";
   }
 if($backlink==1){echo "<a href=\"".$PHP_SELF."\" title=\"".$text[392]."\">".$text[391]."</a>&nbsp;&nbsp;&nbsp;";
   }
 else{
   echo "&nbsp;";
   } 
?>
</td>
      <td class="lmomain2" align="right"><nobr><?PHP echo $text[406].": ".$stand; ?><br><?PHP if($calctime==1){echo $text[471].": ".number_format((getmicrotime()-$startzeit),4,".",",")." sek.<br>";} ?><?PHP echo $text[54]; ?> - <?PHP echo $text[55]; echo "<br>".$text[4005];?></nobr></td>
    </tr>
	</table>
  </td></tr>
</table>

<?PHP } ?>
