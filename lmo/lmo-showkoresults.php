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
  *
  */


if ($file != "") {
  $addp = $_SERVER['PHP_SELF']."?action=program&amp;file=".$file."&amp;selteam=";
  $addr = $_SERVER['PHP_SELF']."?action=results&amp;file=".$file."&amp;st=";
  $breite = 10;
  if ($spez==1) {
    $breite = $breite+2;
  }
  if ($datm==1) {
    $breite = $breite+1;
  }
  $anzsp = $anzteams;
  for ($i = 0; $i < $st; $i++) {
    $anzsp = $anzsp/2;
  }
  if (($klfin==1) && ($st==$anzst)) {
    $anzsp = $anzsp+1;
  }?>

<table class="lmoMiddle" cellspacing="0" cellpadding="0" border="0">
  <tr>
    <td align="center"><?php include(PATH_TO_LMO."/lmo-spieltagsmenu.php");?></td>
  </tr>
  <tr>
    <td align="center">
      <table class="lmoInner" cellspacing="0" cellpadding="0" border="0">
        <tr>
<?php
  if ($st==$anzst) {
    $j = $text[374];
  } elseif ($st==$anzst-1) {
    $j = $text[373];
  } elseif ($st==$anzst-2) {
    $j = $text[372];
  } elseif ($st==$anzst-3) {
    $j = $text[371];
  } else {
    $j = $st.". ".$text[370];
  }
?>
          <th colspan="<?php echo $breite; ?>" align="left"><?php echo $j;
  if ($dats==1) {
    if ($datum1[$st-1] != "") {
      echo " ".$text[3]." ".$datum1[$st-1];
    }
    if ($datum2[$st-1] != "") {
      echo " ".$text[4]." ".$datum2[$st-1];
    }
  }?>
</th>
        </tr>
<?php
  $datsort = $mterm[$st-1];
  asort($datsort);
  reset($datsort);
  //while (list ($key, $val) = each ($datsort)) { //Deprecated: The each() function ...
  foreach($datsort as $key => $val) {
    $i = $key;
    if (($teama[$st-1][$i] > 0) && ($teamb[$st-1][$i] > 0)) {
      for ($n = 0; $n < $modus[$st-1]; $n++) {
        if (($klfin==1) && ($st==$anzst)){ ?>
        <tr>
          <th class="nobr" colspan="<?php echo $breite; ?>"><?php if ($i==1){echo "&nbsp;<br>";} echo $text[419+$i]; ?></th>
        </tr><?php        }?>
        <tr>
<?php
        if ($datm==1){
          if ($mterm[$st-1][$i][$n]>0){
            //$dum1 = date($datf, $mterm[$st-1][$i][$n]);
            $dum1 = strtr(date($datf, $mterm[$st-1][$i][$n]), $trans_lang);
          } else {
            $dum1="";
          }?>
          <td class="nobr"><?php echo $dum1; ?></td>
<?php
        }
?>
          <td class="nobr" width="2">&nbsp;</td>
<?php
        if ($playoffmode == 1 || $playoffmode == 2) { // Modus 2-2-1 or 2-2-1-1-1
          if ($n==0 || $n==1 || $n==4 || $n==6) {
            $m1 = array($goala[$st-1][$i][0], $goala[$st-1][$i][1], $goala[$st-1][$i][2], $goala[$st-1][$i][3], $goala[$st-1][$i][4], $goala[$st-1][$i][5], $goala[$st-1][$i][6]);
            $m2 = array($goalb[$st-1][$i][0], $goalb[$st-1][$i][1], $goalb[$st-1][$i][2], $goalb[$st-1][$i][3], $goalb[$st-1][$i][4], $goalb[$st-1][$i][5], $goalb[$st-1][$i][6]);
            $m = gewinn($st-1, $i, $modus[$st-1], $m1, $m2);
            if ($m==1) {
              echo "          <td class=\"lmoTurnierSieger nobr\" align='right'>";
            } /*elseif ($m==2) {
              echo "          <td class=\"lmoTurnierVerlierer nobr\" align='right'>"; // Verliere nicht rot einfärben
            }*/ else {
              echo "          <td class='nobr' align='right'>";
            }
            if ($plan==1) {
              echo "<a href=\"".$addp.$teama[$st-1][$i]."\" title=\"".$text[269]."\">";
            }
            if (($favteam > 0) && ($favteam==$teama[$st-1][$i])) {
              echo "<strong>";
            }
            echo $teams[$teama[$st-1][$i]];
            if (($favteam > 0) && ($favteam==$teama[$st-1][$i])) {
              echo "</strong>";
            }
            if ($plan==1) {
              echo "</a>";
            }
            echo "&nbsp;".HTML_smallTeamIcon($file,$teams[$teama[$st-1][$i]]," alt=''")."&nbsp;";
            echo "</td>\n";
?>
          <td class="nobr" align="center" width="10">-</td>
<?php
            if ($m==2) {
              echo "          <td class=\"lmoTurnierSieger nobr\" align=\"left\">";
            } /*elseif ($m==1) {
              echo "          <td class=\"lmoTurnierVerlierer nobr\" align=\"left\">"; // Verliere nicht rot einfärben
            }*/ else {
              echo "          <td class=\"nobr\" align=\"left\">";
            }
            echo "&nbsp;".HTML_smallTeamIcon($file,$teams[$teamb[$st-1][$i]]," alt=''")."&nbsp;";
            if ($plan==1) {
              echo "<a href=\"".$addp.$teamb[$st-1][$i]."\" title=\"".$text[269]."\">";
            }
            if (($favteam > 0) && ($favteam==$teamb[$st-1][$i])) {
              echo "<strong>";
            }
            echo $teams[$teamb[$st-1][$i]];
            if (($favteam > 0) && ($favteam==$teamb[$st-1][$i])) {
              echo "</strong>";
            }
            if ($plan==1) {
              echo "</a>";
            }?></td>
          <td class="nobr" width="2">&nbsp;</td>
          <td class="nobr" align="right"><?php echo applyFactor($goala[$st-1][$i][$n],$goalfaktor); ?></td>
          <td class="nobr" align="center" width="8">:</td>
          <td class="nobr" align="left"><?php echo applyFactor($goalb[$st-1][$i][$n],$goalfaktor);?></td>
<?php
          } else {
            if ($m==2) {
              echo "          <td class=\"lmoTurnierSieger nobr\" align='right'>";
            } /*elseif ($m==1) {
              echo "          <td class=\"lmoTurnierVerlierer nobr\" align='right'>"; // Verliere nicht rot einfärben
            }*/ else {
              echo "          <td class='nobr' align='right'>";
            }
            if ($plan==1) {
              echo "<a href=\"".$addp.$teamb[$st-1][$i]."\" title=\"".$text[269]."\">";
            }
            if (($favteam > 0) && ($favteam==$teamb[$st-1][$i])) {
              echo "<strong>";
            }
            echo $teams[$teamb[$st-1][$i]];
            if (($favteam > 0) && ($favteam==$teamb[$st-1][$i])) {
              echo "</strong>";
            }
            if ($plan==1) {
              echo "</a>";
            }
            echo "&nbsp;".HTML_smallTeamIcon($file,$teams[$teamb[$st-1][$i]]," alt=''")."&nbsp;";
            echo "</td>\n";
?>
          <td class="nobr" align="center" width="10">-</td>
<?php
            if ($m==1) {
              echo "          <td class=\"lmoTurnierSieger nobr\" align=\"left\">";
            } /*elseif ($m==2) {
              echo "          <td class=\"lmoTurnierVerlierer nobr\" align=\"left\">"; // Verliere nicht rot einfärben
            }*/ else {
              echo "          <td class=\"nobr\" align=\"left\">";
            }
            echo "&nbsp;".HTML_smallTeamIcon($file,$teams[$teama[$st-1][$i]]," alt=''")."&nbsp;";
            if ($plan==1) {
              echo "<a href=\"".$addp.$teama[$st-1][$i]."\" title=\"".$text[269]."\">";
            }
            if (($favteam > 0) && ($favteam==$teama[$st-1][$i])) {
              echo "<strong>";
            }
            echo $teams[$teama[$st-1][$i]];
            if (($favteam > 0) && ($favteam==$teama[$st-1][$i])) {
              echo "</strong>";
            }
            if ($plan==1) {
              echo "</a>";
            }?></td>
          <td class="nobr" width="2">&nbsp;</td>
          <td class="nobr" align="right"><?php echo applyFactor($goalb[$st-1][$i][$n],$goalfaktor); ?></td>
          <td class="nobr" align="center" width="8">:</td>
          <td class="nobr" align="left"><?php echo applyFactor($goala[$st-1][$i][$n],$goalfaktor);?></td>
<?php
          }
        }
        if ($playoffmode == 3) { // Modus 2-3-2
          if ($n==0 || $n==1 || $n==5 || $n==6) {
            $m1 = array($goala[$st-1][$i][0], $goala[$st-1][$i][1], $goala[$st-1][$i][2], $goala[$st-1][$i][3], $goala[$st-1][$i][4], $goala[$st-1][$i][5], $goala[$st-1][$i][6]);
            $m2 = array($goalb[$st-1][$i][0], $goalb[$st-1][$i][1], $goalb[$st-1][$i][2], $goalb[$st-1][$i][3], $goalb[$st-1][$i][4], $goalb[$st-1][$i][5], $goalb[$st-1][$i][6]);
            $m = gewinn($st-1, $i, $modus[$st-1], $m1, $m2);
            if ($m==1) {
              echo "          <td class=\"lmoTurnierSieger nobr\" align='right'>";
            } /*elseif ($m==2) {
              echo "          <td class=\"lmoTurnierVerlierer nobr\" align='right'>"; // Verliere nicht rot einfärben
            }*/ else {
              echo "          <td class='nobr' align='right'>";
            }
            if ($plan==1) {
              echo "<a href=\"".$addp.$teama[$st-1][$i]."\" title=\"".$text[269]."\">";
            }
            if (($favteam > 0) && ($favteam==$teama[$st-1][$i])) {
              echo "<strong>";
            }
            echo $teams[$teama[$st-1][$i]];
            if (($favteam > 0) && ($favteam==$teama[$st-1][$i])) {
              echo "</strong>";
            }
            if ($plan==1) {
              echo "</a>";
            }
            echo "&nbsp;".HTML_smallTeamIcon($file,$teams[$teama[$st-1][$i]]," alt=''")."&nbsp;";
            echo "</td>\n";
?>
          <td class="nobr" align="center" width="10">-</td>
<?php
            if ($m==2) {
              echo "          <td class=\"lmoTurnierSieger nobr\" align=\"left\">";
            } /*elseif ($m==1) {
              echo "          <td class=\"lmoTurnierVerlierer nobr\" align=\"left\">"; // Verliere nicht rot einfärben
            }*/ else {
              echo "          <td class=\"nobr\" align=\"left\">";
            }
            echo "&nbsp;".HTML_smallTeamIcon($file,$teams[$teamb[$st-1][$i]]," alt=''")."&nbsp;";
            if ($plan==1) {
              echo "<a href=\"".$addp.$teamb[$st-1][$i]."\" title=\"".$text[269]."\">";
            }
            if (($favteam > 0) && ($favteam==$teamb[$st-1][$i])) {
              echo "<strong>";
            }
            echo $teams[$teamb[$st-1][$i]];
            if (($favteam > 0) && ($favteam==$teamb[$st-1][$i])) {
              echo "</strong>";
            }
            if ($plan==1) {
              echo "</a>";
            }?></td>
          <td class="nobr" width="2">&nbsp;</td>
          <td class="nobr" align="right"><?php echo applyFactor($goala[$st-1][$i][$n],$goalfaktor); ?></td>
          <td class="nobr" align="center" width="8">:</td>
          <td class="nobr" align="left"><?php echo applyFactor($goalb[$st-1][$i][$n],$goalfaktor);?></td>
<?php
          } else {
            if ($m==2) {
              echo "          <td class=\"lmoTurnierSieger nobr\" align='right'>";
            } /*elseif ($m==1) {
              echo "          <td class=\"lmoTurnierVerlierer nobr\" align='right'>"; // Verliere nicht rot einfärben
            }*/ else {
              echo "          <td class='nobr' align='right'>";
            }
            if ($plan==1) {
              echo "<a href=\"".$addp.$teamb[$st-1][$i]."\" title=\"".$text[269]."\">";
            }
            if (($favteam > 0) && ($favteam==$teamb[$st-1][$i])) {
              echo "<strong>";
            }
            echo $teams[$teamb[$st-1][$i]];
            if (($favteam > 0) && ($favteam==$teamb[$st-1][$i])) {
              echo "</strong>";
            }
            if ($plan==1) {
              echo "</a>";
            }
            echo "&nbsp;".HTML_smallTeamIcon($file,$teams[$teamb[$st-1][$i]]," alt=''")."&nbsp;";
            echo "</td>\n";
?>
          <td class="nobr" align="center" width="10">-</td>
<?php
            if ($m==1) {
              echo "          <td class=\"lmoTurnierSieger nobr\" align=\"left\">";
            } /*elseif ($m==2) {
              echo "          <td class=\"lmoTurnierVerlierer nobr\" align=\"left\">"; // Verliere nicht rot einfärben
            }*/ else {
              echo "          <td class=\"nobr\" align=\"left\">";
            }
            echo "&nbsp;".HTML_smallTeamIcon($file,$teams[$teama[$st-1][$i]]," alt=''")."&nbsp;";
            if ($plan==1) {
              echo "<a href=\"".$addp.$teama[$st-1][$i]."\" title=\"".$text[269]."\">";
            }
            if (($favteam > 0) && ($favteam==$teama[$st-1][$i])) {
              echo "<strong>";
            }
            echo $teams[$teama[$st-1][$i]];
            if (($favteam > 0) && ($favteam==$teama[$st-1][$i])) {
              echo "</strong>";
            }
            if ($plan==1) {
              echo "</a>";
            }?></td>
          <td class="nobr" width="2">&nbsp;</td>
          <td class="nobr" align="right"><?php echo applyFactor($goalb[$st-1][$i][$n],$goalfaktor); ?></td>
          <td class="nobr" align="center" width="8">:</td>
          <td class="nobr" align="left"><?php echo applyFactor($goala[$st-1][$i][$n],$goalfaktor);?></td>
<?php
          }
        }
        if ($playoffmode < 1) { // now Modus = everything else ($playoffmode == 0; and KO-League without $playoffmode Option like old Champions-League Finalrounds)
          if ($n % 2 == 0) {
            $m1 = array($goala[$st-1][$i][0], $goala[$st-1][$i][1], $goala[$st-1][$i][2], $goala[$st-1][$i][3], $goala[$st-1][$i][4], $goala[$st-1][$i][5], $goala[$st-1][$i][6]);
            $m2 = array($goalb[$st-1][$i][0], $goalb[$st-1][$i][1], $goalb[$st-1][$i][2], $goalb[$st-1][$i][3], $goalb[$st-1][$i][4], $goalb[$st-1][$i][5], $goalb[$st-1][$i][6]);
            $m = gewinn($st-1, $i, $modus[$st-1], $m1, $m2);
            if ($m==1) {
              echo "          <td class=\"lmoTurnierSieger nobr\" align='right'>";
            } /*elseif ($m==2) {
              echo "          <td class=\"lmoTurnierVerlierer nobr\" align='right'>"; // Verliere nicht rot einfärben
            }*/ else {
              echo "          <td class='nobr' align='right'>";
            }
            if ($plan==1) {
              echo "<a href=\"".$addp.$teama[$st-1][$i]."\" title=\"".$text[269]."\">";
            }
            if (($favteam > 0) && ($favteam==$teama[$st-1][$i])) {
              echo "<strong>";
            }
            echo $teams[$teama[$st-1][$i]];
            if (($favteam > 0) && ($favteam==$teama[$st-1][$i])) {
              echo "</strong>";
            }
            if ($plan==1) {
              echo "</a>";
            }
            echo "&nbsp;".HTML_smallTeamIcon($file,$teams[$teama[$st-1][$i]]," alt=''")."&nbsp;";
            echo "</td>\n";
?>
          <td class="nobr" align="center" width="10">-</td>
<?php
            if ($m==2) {
              echo "          <td class=\"lmoTurnierSieger nobr\" align=\"left\">";
            } /*elseif ($m==1) {
              echo "          <td class=\"lmoTurnierVerlierer nobr\" align=\"left\">"; // Verliere nicht rot einfärben
            }*/ else {
              echo "          <td class=\"nobr\" align=\"left\">";
            }
            echo "&nbsp;".HTML_smallTeamIcon($file,$teams[$teamb[$st-1][$i]]," alt=''")."&nbsp;";
            if ($plan==1) {
              echo "<a href=\"".$addp.$teamb[$st-1][$i]."\" title=\"".$text[269]."\">";
            }
            if (($favteam > 0) && ($favteam==$teamb[$st-1][$i])) {
              echo "<strong>";
            }
            echo $teams[$teamb[$st-1][$i]];
            if (($favteam > 0) && ($favteam==$teamb[$st-1][$i])) {
              echo "</strong>";
            }
            if ($plan==1) {
              echo "</a>";
            }?></td>
          <td class="nobr" width="2">&nbsp;</td>
          <td class="nobr" align="right"><?php echo applyFactor($goala[$st-1][$i][$n],$goalfaktor); ?></td>
          <td class="nobr" align="center" width="8">:</td>
          <td class="nobr" align="left"><?php echo applyFactor($goalb[$st-1][$i][$n],$goalfaktor);?></td>
<?php
          } else {
            if ($m==2) {
              echo "          <td class=\"lmoTurnierSieger nobr\" align='right'>";
            } /*elseif ($m==1) {
              echo "          <td class=\"lmoTurnierVerlierer nobr\" align='right'>"; // Verliere nicht rot einfärben
            }*/ else {
              echo "          <td class='nobr' align='right'>";
            }
            if ($plan==1) {
              echo "<a href=\"".$addp.$teamb[$st-1][$i]."\" title=\"".$text[269]."\">";
            }
            if (($favteam > 0) && ($favteam==$teamb[$st-1][$i])) {
              echo "<strong>";
            }
            echo $teams[$teamb[$st-1][$i]];
            if (($favteam > 0) && ($favteam==$teamb[$st-1][$i])) {
              echo "</strong>";
            }
            if ($plan==1) {
              echo "</a>";
            }
            echo "&nbsp;".HTML_smallTeamIcon($file,$teams[$teamb[$st-1][$i]]," alt=''")."&nbsp;";
            echo "</td>\n";
?>
          <td class="nobr" align="center" width="10">-</td>
<?php
            if ($m==1) {
              echo "          <td class=\"lmoTurnierSieger nobr\" align=\"left\">";
            } /*elseif ($m==2) {
              echo "          <td class=\"lmoTurnierVerlierer nobr\" align=\"left\">"; // Verliere nicht rot einfärben
            }*/ else {
              echo "          <td class=\"nobr\" align=\"left\">";
            }
            echo "&nbsp;".HTML_smallTeamIcon($file,$teams[$teama[$st-1][$i]]," alt=''")."&nbsp;";
            if ($plan==1) {
              echo "<a href=\"".$addp.$teama[$st-1][$i]."\" title=\"".$text[269]."\">";
            }
            if (($favteam > 0) && ($favteam==$teama[$st-1][$i])) {
              echo "<strong>";
            }
            echo $teams[$teama[$st-1][$i]];
            if (($favteam > 0) && ($favteam==$teama[$st-1][$i])) {
              echo "</strong>";
            }
            if ($plan==1) {
              echo "</a>";
            }?></td>
          <td class="nobr" width="2">&nbsp;</td>
          <td class="nobr" align="right"><?php echo applyFactor($goalb[$st-1][$i][$n],$goalfaktor); ?></td>
          <td class="nobr" align="center" width="8">:</td>
          <td class="nobr" align="left"><?php echo applyFactor($goala[$st-1][$i][$n],$goalfaktor);?></td>
<?php
          }
        }
?>
          <td class="nobr" width="2">&nbsp;</td>
          <td class="nobr"><?php echo $mspez[$st-1][$i][$n]; ?></td>
          <td class="nobr" width="2">&nbsp;</td>
          <td class="nobr"><?php
        /** Mannschaftsicons finden
         */
        $lmo_teamaicon="";
        $lmo_teambicon="";
        if ($urlb==1 || $mnote[$st-1][$i][$n]!=""){
          $lmo_teamaicon=HTML_smallTeamIcon($file,$teams[$teama[$st-1][$i]]," alt=''");
          $lmo_teambicon=HTML_smallTeamIcon($file,$teams[$teamb[$st-1][$i]]," alt=''");
        }
        /** Spielbericht verlinken
         */
        if ($urlb==1){
          if ($mberi[$st-1][$i][$n]!=""){
            $lmo_spielbericht=$lmo_teamaicon."<strong>".$teams[$teama[$st-1][$i]]."</strong> - ".$lmo_teambicon."<strong>".$teams[$teamb[$st-1][$i]]."</strong><br><br>";
            echo " <a href='".$mberi[$st-1][$i][$n]."'  target='_blank' title='".$text[270]."'><img src='".URL_TO_IMGDIR."/lmo-st1.svg' height='15' border='0' alt=''><span class='popup'>".$lmo_spielbericht.nl2br($text[270])."</span></a>";
          } else {
            echo "&nbsp;&nbsp;&nbsp;";
          }
        }
        /** Notizen anzeigen
         *
         */
        if ($mnote[$st-1][$i][$n]!="") {

          $lmo_spielnotiz=$lmo_teamaicon."<strong>".$teams[$teama[$st-1][$i]]."</strong> - ".$lmo_teambicon."<strong>".$teams[$teamb[$st-1][$i]]."</strong> ".applyFactor($goala[$st-1][$i][$n],$goalfaktor).":".applyFactor($goalb[$st-1][$i][$n],$goalfaktor);
          //Allgemeine Notiz

          $lmo_spielnotiz.="\n\n<strong>".$text[22].":</strong>\n".$mnote[$st-1][$i][$n];

          echo " <a href='#' onclick=\"alert('".addcslashes('',htmlentities(strip_tags($lmo_spielnotiz)))."');window.focus();return false;\"><span class='popup'>".nl2br($lmo_spielnotiz)."</span><img src='".URL_TO_IMGDIR."/lmo-st2.svg' height='15' border='0' alt=''></a>";
          $lmo_spielnotiz="";
        } else {
          echo "&nbsp;";
        }?></td>
        </tr>
<?php
      }
      if (($modus[$st-1]>1) && ($i<=$anzsp-1)){ ?>
        <tr>
          <td class="nobr" colspan="<?php echo $breite; ?>">&nbsp;</td>
        </tr>
<?php
      }
    }
  }?>
      </table>
    </td>
  </tr>
  <tr>
    <td>
      <table width="100%" cellspacing="0" cellpadding="0" border="0">
        <tr><?php
   $st0 = $st-1;
   if ($st > 1) {?>
          <td align="left">&nbsp;<a href="<?php echo $addr.$st0?>" title="<?php echo $text[6]?>"><?php echo $text[5]?> <?php echo $text[6]?></a>&nbsp;</td><?php
   }
   $st0 = $st+1;
   if ($st < $anzst) {?>
          <td align="right">&nbsp;<a href="<?php echo $addr.$st0?>" title="<?php echo $text[8]?>"><?php echo $text[8]?> <?php echo $text[7]?></a>&nbsp;</td><?php
   }?>
        </tr>
      </table>
    </td>
  </tr>
</table><?php
}
