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
if (isset($_REQUEST["action"]) && $_REQUEST["action"] != "tipp") {
  $addm=$_SERVER['PHP_SELF']."?file=".$file."&amp;action=";
  if($file!=""){
    require(PATH_TO_LMO."/lmo-openfile.php");
    if(!isset($endtab)){
      $endtab=$anzst;
      $ste=$st;
      $tabdat="";
    }else{
      $tabdat=$endtab.". ".$text[2];
      $ste=$endtab;
    }
    if ($action=="") {
      if($onrun==0){
        $action="results";
      }else{
        $action="table";
      }
    }
  }
  ?>
  <table class="lmomaina" cellspacing="0" cellpadding="0" border="0">
    <tr>
      <td class="lmomain0" colspan="2" align="center"><?$file==""?print($text[53]):print($titel); ?></td>
      <td class="lmomain2" align="right"><?
  $handle=opendir ('.');
  while (false!==($f=readdir($handle))) {
    if (preg_match("/^lang-?(.*)?\.txt$/",$f,$lang)>0) {
      if ($lang[1]=="") $lang[1]=$text[505];?>
          <a href="<?="{$_SERVER['PHP_SELF']}?lmouserlang={$lang[1]}&amp;action={$action}&amp;file={$file}&amp;archiv={$archiv}"?>" title="<?=$lang[1];?>"
          ><?
      $lang[1]==""?$imgfile='img/'.$text[505].".gif":$imgfile='img/'.$lang[1].".gif";
      if (!file_exists($imgfile)) {
        echo $lang[1];
      }else{
        $c=@getimagesize($imgfile);
        echo "<img src='{$imgfile}' border='1' title='{$lang[1]}' {$c[3]} alt='{$lang[1]}'>";
      }
        ?></a><?
    } 
  }
  closedir($handle);?>
      </td>
    </tr><pre><? 
  if($file!="" && $nticker==1){ 
    //print_r(get_defined_vars());;
    ?>
    <tr>
      <td class="lmomain1" colspan="3" align="center"><?include(PATH_TO_LMO."/lmo-newsticker.php");?></td>
    </tr><? 
  }
  if ($file!="") {?>  
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
        if($action!="cross"){echo "<a href='{$addm}cross' title='{$text[15]}'>{$text[14]}</a>";}else{echo $text[14];}
        echo "&nbsp;&nbsp;";
      }
      if($action!="program"){echo "<a href='{$addm}program' title='{$text[13]}'>{$text[12]}</a>";}else{echo $text[12];}
      echo "&nbsp;&nbsp;";
      if($kurve==1){
        if($action!="graph"){echo "<a href='{$addm}graph&amp;stat1={$stat1}&amp;stat2={$stat2}' title='{$text[134]}'>{$text[133]}</a>";}else{echo $text[133];}
        echo "&nbsp;&nbsp;";
      }
      if($action!="stats"){echo "<a href='{$addm}stats&amp;stat1={$stat1}&amp;stat2={$stat2}' title='{$text[19]}'>{$text[18]}</a>";}else{echo $text[18];}
      if ($einspieler==1) {
  	    include(PATH_TO_LMO."/lmo-statloadconfig.php");
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
    </tr><?
  }?>
    <tr>
      <td class="lmomain1" colspan="3" align="center"><?
  if ($file!="") {
    $druck=0;
    if($lmtype==0){
      if($action=="cal"){if($datc==1){require(PATH_TO_LMO."/lmo-showcal.php");}}
      if($tabonres==0){
        if($action=="results"){require(PATH_TO_LMO."/lmo-showresults.php");if(file_exists("lmo-savehtml.php")){$druck=1;}}
        if($action=="table"){require(PATH_TO_LMO."/lmo-showtable.php");}
      }else{
        if($action=="results"){require(PATH_TO_LMO."/lmo-showrestab.php");}
      }
      if($kreuz==1){
        if($action=="cross"){require(PATH_TO_LMO."/lmo-showcross.php");}
      }
      if($action=="program"){require(PATH_TO_LMO."/lmo-showprogram.php");}
      if($kurve==1){
        if($action=="graph"){require(PATH_TO_LMO."/lmo-showgraph.php");}
      }
      if($action=="stats"){require(PATH_TO_LMO."/lmo-showstats.php");}
      if ($einspieler==1) {
  	   if($action=="spieler" && $mittore==1){require(PATH_TO_LMO."/lmo-statshow.php");}
      }
    }else{
      if($action=="cal"){if($datc==1){require(PATH_TO_LMO."/lmo-showkocal.php");}}
      if($action=="results"){require(PATH_TO_LMO."/lmo-showkoresults.php");}
      if($action=="program"){require(PATH_TO_LMO."/lmo-showkoprogram.php");}
      if ($einspieler==1) {
  	    if($action=="spieler" && $mittore==1){require(PATH_TO_LMO."/lmo-statshow.php");}
      }
  	}
    if($action=="info"){require(PATH_TO_LMO."/lmo-showinfo.php");}
  }else{
    require(PATH_TO_LMO."/lmo-showdir.php");
  }?>
      </td>
    </tr><?
  if ($file!="") {?>
    <tr>
      <td class="lmomain2" colspan="3" align="center"><? 
    if ($einsavehtml==1) { ?>
  	    <table width="100%" cellspacing="0" cellpadding="0" border="0">
          <tr><? 
      if($lmtype==0 || $druck==1){include(PATH_TO_LMO."/lmo-savehtml.php");}?> 
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
        echo "<a href='{$_SERVER['PHP_SELF']}?action=tipp&amp;file={$file}'>{$text[5]} {$text[2094]}</a>&nbsp;&nbsp;&nbsp;<br>";
      }
    }else{
      echo "&nbsp;<br>";
    }
    if($backlink==1){
      echo "<a href='{$_SERVER['PHP_SELF']}' title='{$text[392]}'>{$text[391]}</a>&nbsp;&nbsp;&nbsp;";
    }else{
      echo "&nbsp;";
    }
    
    ?>
            </td>
            <td class="lmomain2" align="right"><?if ($file!="") echo "{$text[406]}: $stand"?><br><? 
    if($calctime==1){
      echo $text[471].": ".number_format((getmicrotime()-$startzeit),4,".",",")." sek.<br>";
    } 
    echo "{$text[54]} - <a href='{$addm}info' title='{$text[21]}'>{$text[55]}</a>";?>
            </td>
          </tr>
  	    </table>
      </td>
    </tr><?
  }else{?>
    <tr>
      <td class="lmomain2" colspan="3" align="right">
        <table width="100%" cellspacing="0" cellpadding="0" border="0">
          <tr>
            <td class="lmomain1" valign="bottom"><?
    if($archivlink==1){
      if (isset($archiv)){
        echo "<a href=\"".$_SERVER["PHP_SELF"]."\">{$text[391]}</a><br>";
      }
      if (!isset($archiv) || $archiv!="dir"){
        echo "<a href=\"".$_SERVER["PHP_SELF"]."?archiv=dir\">{$text[508]}</a><br>";
      }
    }
    if ($eintippspiel==1) {
      if($tippspiel==1 && ($immeralle==1 || strpos($ligenzutippen, substr($file,strrpos($file,"//")+1,-4))>-1)){
        echo "<a href='{$_SERVER['PHP_SELF']}?action=tipp&amp;file={$file}'>{$text[5]} {$text[2094]}</a>&nbsp;&nbsp;&nbsp;";
      }
    }?>
            </td>
            <td class="lmomain2" align="right"><?
    if($calctime==1){
      echo $text[471].": ".number_format((getmicrotime()-$startzeit),4,".",",")." sek.<br>";
    } 
    echo "{$text[54]} - <a href='{$addm}info' title='{$text[21]}'>{$text[55]}</a>";?>
            </td>
          </tr>
  	    </table>
      </td>
    </tr><?
  }?> 
  </table><?
}else{
  define('LMO_TIPPAUTH', 1);
  require(PATH_TO_LMO."/lmo-tippstart.php");
}