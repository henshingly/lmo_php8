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
  * $Id$
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
      <table class="lmoMenu" cellspacing="0" cellpadding="0" border="0"><?php
  for ($i=1; $i<=$anzteams; $i++) {?>
        <tr>
          <td align="right">
            <acronym title="<?php echo $text[134]." ".$teams[$i]?>">
            	<?php
    if($i!=$show_stat1){?>
            <a href="<?php echo $addp.$i?>" ><?php echo $teamk[$i]?></a>
            <?php
    } else {
      echo $teamk[$i];
    }
          ?></acronym>
          </td>
          <td>&nbsp;<?php echo HTML_smallTeamIcon($file,$teams[$i]," alt=''"); ?>&nbsp;</td>
        </tr><?php
  }?>
      </table>
    </td>
    <td valign="top" align="center">
      <table class="lmoInner" cellspacing="0" cellpadding="0" border="0"><?php
  if($show_stat1==0){?>
        <tr>
          <td>&nbsp;<br /><?php echo $text[24]?><br />&nbsp;</td>
        </tr><?php
  } else {
    $tabtype=0;
    require(PATH_TO_LMO."/lmo-calcgraph.php");
    $dummy=URL_TO_LMO."/lmo-paintgraph.php?pganz=";
    if($show_stat2>0){$dummy=$dummy."2";}else{$dummy=$dummy."1";}
    $dummy=$dummy."&amp;pgteam1=".rawurlencode($teams[$show_stat1]);
    if($show_stat2>0){$dummy=$dummy."&amp;pgteam2=".rawurlencode($teams[$show_stat2]);}
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
          <td align="center"><img src="<? echo $dummy; ?>" border="0" alt="<?=$text[133]?>" /></td>
        </tr>
<?php } ?>

  </table></td>
    <td valign="top" align="center">
      <table class="lmoMenu" cellspacing="0" cellpadding="0" border="0"><?php
  for ($i=1; $i<=$anzteams; $i++) {?>
        <tr>
          <td>&nbsp;<?php echo HTML_smallTeamIcon($file,$teams[$i]," alt=''"); ?>&nbsp;</td>
          <td align="right">
            <acronym title="<?php echo $text[134]." ".$teams[$i]?>"><?php
    if($i!=$show_stat2){?>
            <a href="<?php echo $addp.$show_stat1."&amp;stat2=".$i?>" ><?php echo $teamk[$i]?></a><?php
    } else {
      echo $teamk[$i];
    }
          ?></acronym>
          </td>
        </tr><?php
  }?>
      </table>
    </td>
  </tr>
</table>

<?php } ?>