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
  
  
if ($file != "") {
  $addp = $_SERVER['PHP_SELF']."?action=program&amp;file=".$file."&amp;selteam=";
  $addr = $_SERVER['PHP_SELF']."?action=results&amp;file=".$file."&amp;st=";
  $breite = 10;
  if ($spez == 1) {
    $breite = $breite+2;
  }
  if ($datm == 1) {
    $breite = $breite+1;
  }
  $anzsp = $anzteams;
  for($i = 0; $i < $st; $i++) {
    $anzsp = $anzsp/2;
  }
  if (($klfin == 1) && ($st == $anzst)) {
    $anzsp = $anzsp+1;
  }
  function gewinn ($gst, $gsp, $gmod, $m1, $m2) {
    $erg = 0;
    if ($gmod == 1) {
      if ($m1[0] > $m2[0]) {
        $erg = 1;
      } elseif($m1[0] < $m2[0]) {
        $erg = 2;
      }
    } elseif($gmod == 2) {
      if (($m1[0]+$m1[1]) > ($m2[0]+$m2[1])) {
        $erg = 1;
      } elseif(($m1[0]+$m1[1]) < ($m2[0]+$m2[1])) {
        $erg = 2;
      } else {
        if ($m2[0] > $m1[1]) {
          $erg = 2;
        } elseif($m2[0] < $m1[1]) {
          $erg = 1;
        }
      }
    } else {
      $erg1 = 0;
      $erg2 = 0;
      for($k = 0; $k < $gmod; $k++) {
        if (($m1[$k] != "_") && ($m2[$k] != "_")) {
          if ($m1[$k] > $m2[$k]) {
            $erg1++;
          } elseif($m1[$k] < $m2[$k]) {
            $erg2++;
          }
        }
      }
      if ($erg1 > ($gmod/2)) {
        $erg = 1;
      } elseif($erg2 > ($gmod/2)) {
        $erg = 2;
      }
    }
    return $erg;
  }?>

<table class="lmoMiddle" cellspacing="0" cellpadding="0" border="0">
  <tr>
    <td align="center"><?include(PATH_TO_LMO."/lmo-spieltagsmenu.php");?></td>
  </tr>
  <tr>
    <td align="center">
      <table class="lmoInner" cellspacing="0" cellpadding="0" border="0">
        <tr><?
  if ($st == $anzst) {
    $j = $text[374];
  } elseif($st == $anzst-1) {
    $j = $text[373];
  } elseif($st == $anzst-2) {
    $j = $text[372];
  } elseif($st == $anzst-3) {
    $j = $text[371];
  } else {
    $j = $st.". ".$text[370];
  }?>
          <th colspan="<?=$breite; ?>" align="left"><? 
  echo $j;
  if ($dats == 1) {
    if ($datum1[$st-1] != "") {
      echo " ".$text[3]." ".$datum1[$st-1];
    }
    if ($datum2[$st-1] != "") {
      echo " ".$text[4]." ".$datum2[$st-1];
    }
  }?>
          </th>
        </tr><?
  $datsort = $mterm[$st-1];
  asort($datsort);
  reset($datsort);
  while (list ($key, $val) = each ($datsort)) {
    $i = $key;
    if (($teama[$st-1][$i] > 0) && ($teamb[$st-1][$i] > 0)) {
      for($n = 0; $n < $modus[$st-1]; $n++) {
        if(($klfin==1) && ($st==$anzst)){ ?>
        <tr>
          <th class="nobr" colspan="<?=$breite; ?>"><? if($i==1){echo "&nbsp;<br>";} echo $text[419+$i]; ?></th>
        </tr><? 
        }?>
        <tr><? 
        if($datm==1){
          if($mterm[$st-1][$i][$n]>0){
            $dum1=strftime($datf, $mterm[$st-1][$i][$n]);
          } else {
            $dum1="";
          }?>
          <td class="nobr"><?=$dum1; ?></td><? 
        }?>
          <td class="nobr" width="2">&nbsp;</td><?
        if ($n == 0) {
          $m1 = array($goala[$st-1][$i][0], $goala[$st-1][$i][1], $goala[$st-1][$i][2], $goala[$st-1][$i][3], $goala[$st-1][$i][4], $goala[$st-1][$i][5], $goala[$st-1][$i][6]);
          $m2 = array($goalb[$st-1][$i][0], $goalb[$st-1][$i][1], $goalb[$st-1][$i][2], $goalb[$st-1][$i][3], $goalb[$st-1][$i][4], $goalb[$st-1][$i][5], $goalb[$st-1][$i][6]);
          $m = gewinn($st-1, $i, $modus[$st-1], $m1, $m2);
          if ($m == 1) {
            echo "<td class=\"lmoTurnierSieger nobr\" align='right'>";
          } elseif ($m==2) {
            echo "<td class=\"lmoTurnierVerlierer nobr\" align='right'>";
          } else {
            echo "<td class='nobr' align='right'>";
          }
          if ($plan==1) {
            echo "<a href=\"".$addp.$teama[$st-1][$i]."\" title=\"".$text[269]."\">";
          }
          if (($favteam > 0) && ($favteam == $teama[$st-1][$i])) {
            echo "<strong>";
          }
          echo $teams[$teama[$st-1][$i]];
          if (($favteam > 0) && ($favteam == $teama[$st-1][$i])) {
            echo "</strong>";
          }
          if ($plan==1) {
            echo "</a>";
          }
          echo "&nbsp;".getSmallImage($teams[$teama[$st-1][$i]])."&nbsp;";
          echo "</td>";?>
          <td class="nobr" align="center" width="10">-</td><?
          if ($m == 2) {
            echo "<td align='left' class=\"lmoTurnierSieger nobr\">";
          } elseif($m==1) {
            echo "<td align='left' class=\"lmoTurnierVerlierer nobr\">";
          } else {
            echo "<td align='left' class='nobr'>";
          }
          echo "&nbsp;".getSmallImage($teams[$teamb[$st-1][$i]])."&nbsp;";
          if ($plan==1) {
            echo "<a href=\"".$addp.$teamb[$st-1][$i]."\" title=\"".$text[269]."\">";
          }
          if (($favteam > 0) && ($favteam == $teamb[$st-1][$i])) {
            echo "<strong>";
          }
          echo $teams[$teamb[$st-1][$i]];
          if (($favteam > 0) && ($favteam == $teamb[$st-1][$i])) {
            echo "</strong>";
          }
          if ($plan==1) {
            echo "</a>";
          }?>
          </td><?
        } else { ?>
          <td class="nobr" colspan="3">&nbsp;</td><? 
        }?>
          <td class="nobr" width="2">&nbsp;</td>
          <td class="nobr" align="right"><?=applyFactor($goala[$st-1][$i][$n],$goalfaktor); ?></td>
          <td class="nobr" align="center" width="8">:</td>
          <td class="nobr" align="left"><?=applyFactor($goalb[$st-1][$i][$n],$goalfaktor);?></td>
          <td class="nobr" width="2">&nbsp;</td>
          <td class="nobr"><?=$mspez[$st-1][$i][$n]; ?></td>
          <td class="nobr" width="2">&nbsp;</td>
          <td class="nobr"><?
        /** Mannschaftsicons finden
         */
        $lmo_teamaicon="";
        $lmo_teambicon="";
        if($urlb==1 || $mnote[$st-1][$i][$n]!=""){
          $lmo_teamaicon=getSmallImage($teams[$teama[$st-1][$i]]);
          $lmo_teambicon=getSmallImage($teams[$teamb[$st-1][$i]]);
        }
        /** Spielbericht verlinken
         */
        if($urlb==1){
          if($mberi[$st-1][$i][$n]!=""){
            $lmo_spielbericht=$lmo_teamaicon."<strong>".$teams[$teama[$st-1][$i]]."</strong> - ".$lmo_teambicon."<strong>".$teams[$teamb[$st-1][$i]]."</strong><br><br>";
            echo " <a href='".$mberi[$st-1][$i][$n]."'  target='_blank' title='".$text[270]."'><img src='".URL_TO_IMGDIR."/lmo-st1.gif' width='10' height='12' border='0' alt=''><span class='popup'>".$lmo_spielbericht.nl2br($text[270])."</span></a>";
          }else{
            echo "&nbsp;&nbsp;&nbsp;";
          }
        }
        /** Notizen anzeigen
         *
         */
        if ($mnote[$st-1][$i][$n]!="") {
     
          $lmo_spielnotiz=$lmo_teamaicon."<strong>".$teams[$teama[$st-1][$i]]."</strong> - ".$lmo_teambicon."<strong>".$teams[$teamb[$st-1][$i]]."</strong> ".$goala[$st-1][$i][$n].":".$goalb[$st-1][$i][$n];
          //Allgemeine Notiz
          
          $lmo_spielnotiz.="\n\n<strong>".$text[22].":</strong> ".$mnote[$st-1][$i][$n];
          
          echo " <a href='#' onclick=\"alert('".mysql_escape_string(htmlentities(strip_tags($lmo_spielnotiz)))."');window.focus();return false;\"><span class='popup'>".nl2br($lmo_spielnotiz)."</span><img src='".URL_TO_IMGDIR."/lmo-st2.gif' width='10' height='12' border='0' alt=''></a>";
          $lmo_spielnotiz="";
        } else {
          echo "&nbsp;";
        }?>
          </td>
        </tr><? 
      }
      if(($modus[$st-1]>1) && ($i<=$anzsp-1)){ ?>
        <tr>
          <td class="nobr" colspan="<?=$breite; ?>">&nbsp;</td>
        </tr><? 
      }
    }
  }?>

      </table>
    </td>
  </tr>
  <tr>
    <td>
      <table width="100%" cellspacing="0" cellpadding="0" border="0">
        <tr><?  
   $st0 = $st-1;
   if ($st > 1) {?>
          <td align="left">&nbsp;<a href="<?=$addr.$st0?>" title="<?=$text[6]?>"><?=$text[5]?> <?=$text[6]?></a>&nbsp;</td><?
   }
   $st0 = $st+1;
   if ($st < $anzst) {?>
          <td align="right">&nbsp;<a href="<?=$addr.$st0?>" title="<?=$text[8]?>"><?=$text[8]?> <?=$text[7]?></a>&nbsp;</td><?
   }?>
        </tr>
      </table>
    </td>
  </tr>
</table><? 
} ?>