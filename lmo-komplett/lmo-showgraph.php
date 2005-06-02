<?
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
  
  
if(($file!="") && ($kurve==1)){
  $addp=$_SERVER['PHP_SELF']."?action=graph&amp;file=".$file."&amp;stat1=";
  $show_stat1=isset($_GET['stat1'])?$_GET['stat1']:$stat1;
  $show_stat2=isset($_GET['stat2'])?$_GET['stat2']:$stat2;
  if ($show_stat1==0 && $show_stat2!=0 || $show_stat1==$show_stat2) {
    $show_stat1=$show_stat2;
    $show_stat2=0;
  }
?>

<table class="lmoMiddle" cellspacing="0" cellpadding="0" border="0">
  <tr>
    <td valign="top" align="center">
      <table class="lmoMenu" cellspacing="0" cellpadding="0" border="0"><?
  for ($i=1; $i<=$anzteams; $i++) {?>
        <tr>
          <td align="right">
            <acronym title="<?=$text[134]." ".$teams[$i]?>"><?
    if($i!=$show_stat1){?>
            <a href="<?=$addp.$i?>" ><?=$teamk[$i]?></a><?
    } else {
      echo $teamk[$i];
    }
          ?></acronym>
          </td>          
          <td>&nbsp;<?=getSmallImage($teams[$i]);?>&nbsp;</td>
        </tr><?
  }?>
      </table>
    </td>
    <td valign="top" align="center">
      <table class="lmoInner" cellspacing="0" cellpadding="0" border="0"><?
  if($show_stat1==0){?>
        <tr>
          <th><h2><?=$text[24]?></h2></th>
        </tr><?
  } else {
    $tabtype=0;
    require(PATH_TO_LMO."/lmo-calcgraph.php");
    $dummy=URL_TO_LMO."/lmo-paintgraph.php?pganz=";
    if($show_stat2>0){$dummy=$dummy."2";}else{$dummy=$dummy."1";}
    $dummy=$dummy."&amp;pgteam1=".rawurlencode($teams[$show_stat1]);
    if($show_stat2>0){$dummy=$dummy."&pgteam2=".rawurlencode($teams[$show_stat2]);}
    $dummy=$dummy."&amp;pgteams=".$anzteams;
    $dummy=$dummy."&amp;pgst=".$anzst;
    $dummy=$dummy."&amp;pgch=".$champ;
    $dummy=$dummy."&amp;pgcl=".$anzcl;
    $dummy=$dummy."&amp;pgck=".$anzck;
    $dummy=$dummy."&amp;pguc=".$anzuc;
    $dummy=$dummy."&amp;pgar=".$anzar;
    $dummy=$dummy."&amp;pgab=".$anzab;
    $dummy=$dummy."&amp;pgplatz1=";
    for($j=0;$j<$anzst;$j++){$dummy=$dummy.$platz[$show_stat1][$j].",";}
    $dummy=$dummy."0";
    if($show_stat2>0){
      $dummy=$dummy."&amp;pgplatz2=";
      for($j=0;$j<$anzst;$j++){$dummy=$dummy.$platz[$show_stat2][$j].",";}
      $dummy=$dummy."0";
      }?>
        <tr>
          <td align="center"><img src="<? echo $dummy; ?>" border="0" alt="<?=$text[133]?>"></td>
        </tr>
<? } ?>

  </table></td>
    <td valign="top" align="center">
      <table class="lmoMenu" cellspacing="0" cellpadding="0" border="0"><?
  for ($i=1; $i<=$anzteams; $i++) {?>
        <tr>
          <td>&nbsp;<?=getSmallImage($teams[$i]);?>&nbsp;</td>
          <td align="right">
            <acronym title="<?=$text[134]." ".$teams[$i]?>"><?
    if($i!=$show_stat2){?>
            <a href="<?=$addp.$show_stat1."&amp;stat2=".$i?>" ><?=$teamk[$i]?></a><?
    } else {
      echo $teamk[$i];
    }
          ?></acronym>
          </td>          
        </tr><?
  }?>
      </table>
    </td>
  </tr>
</table>

<? } ?>