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


if($file!=""){
  $addp=$_SERVER['PHP_SELF']."?action=program&amp;file=".$file."&amp;selteam=";
  $addr=$_SERVER['PHP_SELF']."?action=results&amp;file=".$file."&amp;st=";
  $selteam=!empty($_GET['selteam'])?$_GET['selteam']:$selteam;
?>

<table class="lmoMiddle" cellspacing="0" cellpadding="0" border="0">
  <tr>
    <td valign="top" align="center">
      <table class="lmoMenu" cellspacing="0" cellpadding="0" border="0"><?php
  for ($i=1; $i<=$anzteams; $i++) {?>
        <tr>
          <td align="right">
            <acronym title="<?php echo $text[23]." ".$teams[$i]?>"><?php
    if($i!=$selteam){?>
            <a href="<?php echo $addp.$i?>" ><?php echo $teamk[$i]?></a><?php
    } else {
      echo $teamk[$i];
    }
          ?></acronym>
          </td>
          <td>&nbsp;<?php echo HTML_smallTeamIcon($file,$teams[$i]," alt=''"); ?></td>
        </tr><?php
  }?>
      </table>
    </td>
    <td valign="top" align="center">
      <table class="lmoInner" cellspacing="0" cellpadding="0" border="0"><?php
  if ($selteam == 0) {
    echo "<tr><td align=\"center\">&nbsp;<br />".$text[24]."<br />&nbsp;</td></tr>";
  } else {
    for($j=0;$j<$anzst;$j++){
      for($i=0;$i<$anzsp;$i++){
        if(($selteam==$teama[$j][$i]) || ($selteam==$teamb[$j][$i])){
?>
        <tr>
          <th align="right">&nbsp;<a href="<?php echo $addr.($j+1); ?>" title="<?php echo $text[25]; ?>"><?php echo $j+1; ?></a>&nbsp;</th>
<?php        if($datm==1){
            if($mterm[$j][$i]>0){
              $dum1=strftime($datf, $mterm[$j][$i]);
            }else{
              $dum1="";
            }
?>
          <td style="width:2px;">&nbsp;</td>
          <td class="nobr"><?php echo $dum1; ?></td>
<?php        } ?>
          <td style="width:2px;">&nbsp;</td>
          <td class="nobr" align="right"><?php
          if ($selteam==$teama[$j][$i]){
            echo "<strong>";
          }
          echo $teams[$teama[$j][$i]];
          if ($selteam==$teama[$j][$i]){
            echo "</strong>";
          }
            echo "&nbsp;".HTML_smallTeamIcon($file,$teams[$teama[$j][$i]]," alt=''");
?>        </td>
          <td align="center" style="width:10px;">-</td>
          <td class="nobr" align="left"><?php
           echo HTML_smallTeamIcon($file,$teams[$teamb[$j][$i]]," alt=''")."&nbsp;";
          if ($selteam==$teamb[$j][$i]){
            echo "<strong>";
          }
          echo $teams[$teamb[$j][$i]];
          if ($selteam==$teamb[$j][$i]){
            echo "</strong>";
          }
?>        </td>
          <td style="width:2px;">&nbsp;</td>
          <td align="right"><?php echo applyFactor($goala[$j][$i],$goalfaktor); ?></td>
          <td align="center" style="width:8px;">:</td>
          <td align="left"><?php echo applyFactor($goalb[$j][$i],$goalfaktor); ?></td>
<?php
          if($spez==1){ ?>
          <td style="width:2px;">&nbsp;</td>
          <td align="left"><?php echo $mspez[$j][$i]; ?></td>
<?php        }
?>
          <td style="width:2px;">&nbsp;</td>
          <td class="nobr"><?php
/** Mannschaftsicons finden */
          $lmo_teamaicon="";
          $lmo_teambicon="";
          if($urlb==1 || $mnote[$j][$i]!="" || $msieg[$j][$i]>0){
            $lmo_teamaicon=HTML_smallTeamIcon($file,$teams[$teama[$j][$i]]," alt=''");
            $lmo_teambicon=HTML_smallTeamIcon($file,$teams[$teamb[$j][$i]]," alt=''");
          }

/** Spielbericht verlinken */
          if($urlb==1){
            if($mberi[$j][$i]!=""){
              $lmo_spielbericht=$lmo_teamaicon."<strong>".$teams[$teama[$j][$i]]."</strong> - ".$lmo_teambicon."<strong>".$teams[$teamb[$j][$i]]."</strong><br><br>";
              echo "<a href='".$mberi[$j][$i]."'  target='_blank' title='".$text[270]."'><img src='".URL_TO_IMGDIR."/lmo-st1.gif' width='10' height='12' border='0' alt=''><span class='popup'>".$lmo_spielbericht.nl2br($text[270])."</span></a>";
            }else{
              echo "&nbsp;";
            }
          }
/** Notizen anzeigen */
          if ($mnote[$j][$i]!="" || $msieg[$j][$i]>0) {
            $lmo_spielnotiz=$lmo_teamaicon."<strong>".$teams[$teama[$j][$i]]."</strong> - ".$lmo_teambicon."<strong>".$teams[$teamb[$j][$i]]."</strong> ".applyFactor($goala[$j][$i],$goalfaktor).":".applyFactor($goalb[$j][$i],$goalfaktor);
            //Beidseitiges Ergebnis
            if ($msieg[$j][$i]==3) {
              $lmo_spielnotiz.=" / ".applyFactor($goalb[$j][$i],$goalfaktor).":".applyFactor($goala[$j][$i],$goalfaktor);
            }
            if ($spez==1) {
              $lmo_spielnotiz.=" ".$mspez[$j][$i];
            }
//Grüner Tisch: Heimteam siegt
            if ($msieg[$j][$i]==1) {
              $lmo_spielnotiz.="\n\n<strong>".$text[219].":</strong> ".$teams[$teama[$j][$i]]." ".$text[211];
            }
//Grüner Tisch: Gastteam siegt
            if ($msieg[$j][$i]==2) {
              $lmo_spielnotiz.="\n\n<strong>".$text[219].":</strong> ".addslashes($teams[$teamb[$j][$i]]." ".$text[211]);
            }
//Beidseitiges Ergebnis
            if ($msieg[$j][$i]==3) {
              $lmo_spielnotiz.="\n\n<strong>".$text[219].":</strong> ".addslashes($text[212]);
            }
//Allgemeine Notiz
            if ($mnote[$j][$i]!="") {
              $lmo_spielnotiz.="\n\n<strong>".$text[22].":</strong> ".$mnote[$j][$i];
            }
            echo "<a href='#' onclick=\"alert('".mysql_escape_string(htmlentities(strip_tags($lmo_spielnotiz)))."');window.focus();return false;\"><span class='popup'>".nl2br($lmo_spielnotiz)."</span><img src='".URL_TO_IMGDIR."/lmo-st2.gif' width='10' height='12' border='0' alt=''></a>";
            $lmo_spielnotiz="";
          } else {
            echo "&nbsp;";
          }
          ?></td>
          </tr>
<?php     }
      }
    }
  }?>
      </table>
    </td>
  </tr>
</table><?php
}?>