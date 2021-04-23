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
  
  
if ($file != "") {
  $addp = $_SERVER['PHP_SELF']."?action=program&amp;file=".$file."&amp;selteam=";
  $addr = $_SERVER['PHP_SELF']."?action=results&amp;file=".$file."&amp;st=";
  $selteam=!empty($_GET['selteam'])?$_GET['selteam']:$selteam;?>

<table class="lmoMiddle" cellspacing="0" cellpadding="0" border="0">
  <tr>
    <td valign="top" align="center">
      <table class="lmoMenu" cellspacing="0" cellpadding="0" border="0"><?php 
  for($i = 1; $i <= floor($anzteams/2); $i++) {?>
        <tr>
          <td align="right">
            <acronym title="<?php echo $text[23]." ".$teams[$i]?>">
            	<?php
    if($i!=$selteam){?>
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
  if ($selteam == 0) {
    echo "<tr><td align=\"center\" class=\"lmost5\">&nbsp;<br>".$text[24]."<br>&nbsp;</td></tr>";
  } else {
    for($j = 0; $j < $anzst; $j++) {
      for($i = 0; $i < (($anzteams/2)+1); $i++) {
        if (($selteam == $teama[$j][$i]) || ($selteam == $teamb[$j][$i])) {?>
        <tr><?php 
          if ($j == $anzst-1) {
            $l = $text[364];
          } elseif($j == $anzst-2) {
            $l = $text[362];
          } elseif($j == $anzst-3) {
            $l = $text[360];
          } elseif($j == $anzst-4) {
            $l = $text[358];
          } else {
            $l = $j+1;
          }?>
          <th align="right">&nbsp;<a href="<?php echo $addr.($j+1); ?>" title="<?php echo $text[377]; ?>"><?php echo $l; ?></a>&nbsp;</th><?php 
          $m1 = array($goala[$j][$i][0], $goala[$j][$i][1], $goala[$j][$i][2], $goala[$j][$i][3], $goala[$j][$i][4], $goala[$j][$i][5], $goala[$j][$i][6]);
          $m2 = array($goalb[$j][$i][0], $goalb[$j][$i][1], $goalb[$j][$i][2], $goalb[$j][$i][3], $goalb[$j][$i][4], $goalb[$j][$i][5], $goalb[$j][$i][6]);
          $m = gewinn($j, $i, $modus[$j], $m1, $m2);
          if ($m == 1) {
            echo "<td class=\"lmoTurnierSieger nobr\" align=\"right\">";
          } elseif ($m==2) {
            echo "<td class=\"lmoTurnierVerlierer nobr\" align=\"right\">";
          } else {
            echo "<td class=\"nobr\" align=\"right\">";
          }
          if ($selteam == $teama[$j][$i]) {
            echo "<strong>";
          }
          echo $teams[$teama[$j][$i]];
          if ($selteam == $teama[$j][$i]) {
            echo "</strong>";
          }
          echo "&nbsp;".HTML_smallTeamIcon($file,$teams[$teama[$j][$i]]," alt=''");
          if (($teamu[$teama[$j][$i]] != "") && ($urlt == 1)) {
            echo " <a href=\"".$teamu[$teama[$j][$i]]."\" target=\"_blank\" title=\"".$text[46]."\"><img border='0' width='11' src='".URL_TO_IMGDIR."/url.png' alt='".$text[564]."' title=\"".$text[46]."\"></a>";
          }
          echo " </td>";?>
          <td class="lmost5" align="center" width="10">-</td><?php 
          if ($m == 2) {
            echo "<td class=\"lmoTurnierSieger nobr\">";
          } elseif($m==1) {
            echo "<td align='left' class=\"lmoTurnierVerlierer nobr\">";
          } else {
            echo "<td class=\"nobr\" align=\"left\">";
          }
          echo HTML_smallTeamIcon($file,$teams[$teamb[$j][$i]]," alt=''")."&nbsp;";
          if ($selteam == $teamb[$j][$i]) {
            echo "<strong>";
          }
          echo $teams[$teamb[$j][$i]];
          if ($selteam == $teamb[$j][$i]) {
            echo "</strong>";
          }
          if (($teamu[$teamb[$j][$i]] != "") && ($urlt == 1)) {
            echo " <a href=\"".$teamu[$teamb[$j][$i]]."\" target=\"_blank\" title=\"".$text[46]."\"><img border='0' width='11' src='".URL_TO_IMGDIR."/url.png' alt='".$text[564]."' title=\"".$text[46]."\"></a>";
          }
          echo " </td>";
          for($n = 0; $n < $modus[$j]; $n++) {
            if ($datm == 1) {
              if ($mterm[$j][$i][$n] > 0) {
                $dumn1 = "<acronym title=\"".strftime($datf, $mterm[$j][$i][$n])."\">";
                $dumn2 = "</acronym>";
              } else {
                $dumn1 = "";
                $dumn2 = "";
              }
            }
            if ($n == 0) {
              echo "<td width=\"2\">&nbsp;</td>";
            } else {
              echo "<td width=\"8\">|</td>";
            }?>
          <td class="nobr"><?php echo $dumn1;?><?php echo applyFactor($goala[$j][$i][$n],$goalfaktor); ?>&nbsp;:&nbsp;<?php echo applyFactor($goalb[$j][$i][$n],$goalfaktor); ?><?php echo $mspez[$j][$i][$n]; ?><?php echo $dumn2; ?><?php 
           /** Mannschaftsicons finden
             */
            $lmo_teamaicon="";
            $lmo_teambicon="";
            if($urlb==1 || $mnote[$j][$i][$n]!=""){
              $lmo_teamaicon=HTML_smallTeamIcon($file,$teams[$teama[$j][$i]]," alt=''");
              $lmo_teambicon=HTML_smallTeamIcon($file,$teams[$teamb[$j][$i]]," alt=''");
            }
            /** Spielbericht verlinken
             */
            if($urlb==1){
              if($mberi[$j][$i][$n]!=""){
                $lmo_spielbericht=$lmo_teamaicon."<strong>".$teams[$teama[$j][$i]]."</strong> - ".$lmo_teambicon."<strong>".$teams[$teamb[$j][$i]]."</strong><br><br>";
                echo " <a href='".$mberi[$j][$i][$n]."'  target='_blank'><img src='".URL_TO_IMGDIR."/lmo-st1.gif' width='10' height='12' border='0' alt=''><span class='popup'>".$lmo_spielbericht.nl2br($text[270])."</span></a> ";
              }else{
                echo "&nbsp;&nbsp;&nbsp;";
              }
            }
            /** Notizen anzeigen
             *
             */
            if ($mnote[$j][$i][$n]!="") {
         
              $lmo_spielnotiz=$lmo_teamaicon."<strong>".$teams[$teama[$j][$i]]."</strong> - ".$lmo_teambicon."<strong>".$teams[$teamb[$j][$i]]."</strong> ".applyFactor($goala[$j][$i][$n],$goalfaktor).":".applyFactor($goalb[$j][$i][$n],$goalfaktor);
              //Allgemeine Notiz
              
              $lmo_spielnotiz.="\n\n<strong>".$text[22].":</strong>\n".$mnote[$j][$i][$n];
              
              echo "<a href='#' onclick=\"alert('".addcslashes('',htmlentities(strip_tags($lmo_spielnotiz)))."');window.focus();return false;\"><span class='popup'>".nl2br($lmo_spielnotiz)."</span><img src='".URL_TO_IMGDIR."/lmo-st2.gif' width='10' height='12' border='0' alt=''></a>";
              $lmo_spielnotiz="";
            } else {
              echo "&nbsp;";
            }?>
          </td><?php          }?>
        </tr><?php        }
      }
    }
  }?>
      </table>
    </td>
    <td valign="top" align="center">
      <table class="lmoMenu" cellspacing="0" cellpadding="0" border="0"><?php 
  for($i = ceil($anzteams/2)+1; $i <= $anzteams; $i++) {?>
        <tr>
          <td>&nbsp;<?php echo HTML_smallTeamIcon($file,$teams[$i]," alt=''"); ?></td>
          <td align="left">
            <acronym title="<?php echo $text[23]." ".$teams[$i]?>">
            	<?php
    if($i!=$selteam){?>
            <a href="<?php echo $addp.$i?>"><?php echo $teamk[$i]?></a>
            <?php
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
</table><?php 
}?>
