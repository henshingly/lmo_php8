<?
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
  }else{
    $tabdat=$endtab.". ".$text[2];
    $ste=$endtab;
  }?>
<table class="lmomaina" cellspacing="0" cellpadding="0" border="0">
  <tr>
    <td class="lmomain0" colspan="3" align="center"><? echo $titel; ?></td>
  </tr><? 
  if(($nticker==1) && ($file!="")){ ?>
  <tr>
    <td class="lmomain1" colspan="3" align="center"><?include("lmo-newsticker.php");?></td>
  </tr><? 
  }?>
  <tr>
    <td class="lmomain1"><?
  if ($einspieler==1) { 
    if(!isset($mittore)){$mittore=0;}
  } 
  //Normale Ligen
  if($lmtype==0){
    if($datc==1){
      if($action!='cal'){echo "<a href='{$addm}cal&amp;st={$st}' title='{$text[141]}'>{$text[140]}</a>";}else{echo $text[140];}
      echo '&nbsp;&nbsp;';
    }
    if($tabonres==0){
      if($action!='results'){echo "<a href='{$addm}results&amp;st={$ste}' title='{$text[11]}'>{$text[10]}</a>";}else{echo $text[10];}
      echo "&nbsp;&nbsp;";
      if($action!="table"){echo "<a href='{$addm}table' title='{$text[17]}'>{$text[16]}</a>";}else{echo $text[16];}
    }else{
      if($action!="results"){echo "<a href='{$addm}results' title='{$text[104]}'>{$text[10]}/{$text[16]}</a>";}else{echo "{$text[10]}/{$text[16]}";}
    }
    echo "&nbsp;&nbsp;";
    if($kreuz==1){
      if($action!="cross"){echo "<a href='{$addm}cross\" title='{$text[15]}'>{$text[14]}</a>";}else{echo $text[14];}
      echo "&nbsp;&nbsp;";
      }
    if($action!="program"){echo "<a href='{$addm}program\" title='{$text[13]}'>{$text[12]}</a>";}else{echo $text[12];}
    echo "&nbsp;&nbsp;";
    if($kurve==1){
      if($action!="graph"){echo "<a href='{$addm}graph&amp;stat1={$stat1}&amp;stat2={$stat2}' title='{$text[134]}'>{$text[133]}</a>";}else{echo $text[133];}
      echo "&nbsp;&nbsp;";
      }
    if($action!="stats"){echo "<a href='{$addm}stats&amp;stat1={$stat1}&amp;stat2={$stat2}' title='{$text[19]}'>{$text[18]}</a>";}else{echo $text[18];}
    if ($einspieler==1) {
	    include("lmo-statloadconfig.php");
	    echo "&nbsp;&nbsp;";
	    if($action!="spieler" && $mittore==1) {echo "<a href='{$addm}spieler' title='{$text[3012]}'>{$ligalink}</a>";}else{if($mittore==1)echo $ligalink;}
	  }
  // Pokalligen
  }else{
    if($datc==1){
      if($action!="cal"){echo "<a href='{$addm}cal&amp;st={$st}' title='{$text[141]}'>{$text[140]}</a>";}else{echo $text[140];}
      echo "&nbsp;&nbsp;";
    }
    if($action!="results"){echo "<a href='{$addm}results' title='{$text[367]}'>{$text[10]}</a>";}else{echo $text[10];}
    echo "&nbsp;&nbsp;";
    if($action!="program"){echo "<a href='{$addm}program' title='{$text[13]}'>{$text[12]}</a>";}else{echo $text[12];}
    }?>
    </td>
    <td class="lmomain1" width="8">&nbsp;</td>
    <td class="lmomain1" align="right"><?
    if($action!="info"){echo "<a href='{$addm}info' title='{$text[21]}'>{$text[20]}</a>";}else{echo $text[20];}?>
    </td>
  </tr>
  <tr>
    <td class="lmomain1" colspan="3" align="center"><?
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
  if($action=="info"){require("lmo-showinfo.php");}?>
    </td>
  </tr>
  <tr>
    <td class="lmomain2" colspan="3" align="center"><? 
  if ($einsavehtml==1) { ?>
	    <table width="100%" cellspacing="0" cellpadding="0" border="0">
        <tr><? 
    if($lmtype==0 || $druck==1){include("lmo-savehtml.php");}?> 
	        <td class="lmomain1" align="center"><? 
    if($lmtype==0 and $druck==1){echo "<a href='$diroutput".basename($file)."-st.html' target='_blank' title='{$text[477]}'>{$text[478]}</a>&nbsp;";}?>
          </td>  
          <td class="lmomain1" align="center"><? 
    if($lmtype==0 and $druck==1){echo "<a href='$diroutput".basename($file)."-sp.html' target='_blank' title='{$text[479]}'>{$text[480]}</a>&nbsp;";}?>
          </td>
        </tr>
      </table><? 
  }?>
    </td>
  </tr>
  <tr>
    <td class="lmomain2" colspan="3" align="right">
      <table width="100%" cellspacing="0" cellpadding="0" border="0">
        <tr>
          <td class="lmomain1" valign="bottom"><?
  if ($eintippspiel==1) {
    if($tippspiel==1 && ($immeralle==1 || strpos($ligenzutippen, substr($file,strrpos($file,"//")+1,-4))>-1)){
      echo "<a href='{$_SERVER['PHP_SELF']}?action=tipp&amp;file={$file}&amp;todo=edit'>{$text[5]} {$text[2094]}</a>&nbsp;&nbsp;&nbsp;<br>";
    }
  }else{
    echo "&nbsp;<br>";
  }
  if($backlink==1){
    echo "<a href='{$_SERVER['PHP_SELF']}' title='{$text[392]}'>{$text[391]}</a>&nbsp;&nbsp;&nbsp;";
  }else{
    echo "&nbsp;";
  }?>
          </td>
          <td class="lmomain2" align="right"><?="{$text[406]}: $stand"?><br><? 
  if($calctime==1){
    echo $text[471].": ".number_format((getmicrotime()-$startzeit),4,".",",")." sek.<br>";
  } 
  echo "{$text[54]} - {$text[55]}<br>{$text[4005]}";?>
          </td>
        </tr>
	    </table>
    </td>
  </tr>
</table><? 
}?>