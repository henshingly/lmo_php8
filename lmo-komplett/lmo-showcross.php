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


if(($file!="") && ($kreuz==1)){
  $addc=$_SERVER['PHP_SELF']."?action=cross&amp;file=".$file."&amp;croteam=";
  $addr=$_SERVER['PHP_SELF']."?action=results&amp;file=".$file."&amp;st=";
  $croteam=!empty($_GET['croteam'])?$_GET['croteam']:0;
?>
<table class="lmoMiddle" cellspacing="0" cellpadding="0" border="0">
<tr>
<td class="lmoKreuz">
<table class="lmoInner" cellspacing="0" cellpadding="0" border="0">

<?
for($i = 0; $i <= ($anzteams+1); $i++) {
  for($j = 0; $j <= ($anzteams+1); $j++) {
    $dummy = "";
    if ($j == 0) {
      echo "<tr>";
    }
    if ($j == 0){
      echo "<th align='right'>";
    } elseif ($j == ($anzteams+1)) {
      echo "<th align='left'>";
    } elseif($i == 0 || $i == ($anzteams+1)){
      echo "<th align='center'>";
    } elseif($croteam != 0 && ($j == $croteam || $i == $croteam)) {
      echo "<td align='center' class='lmoBackMarkierung'>";
    } elseif($j == $i) {
      echo "<td class='lmoLeer'>";
    } else {
      echo "<td align='center'>";
    }

    if (($j == 0) && ($i > 0) && ($i <= $anzteams)) {
      if (($croteam != 0) && (($j == $croteam) || ($i == $croteam))) {
        echo $teams[$i];
      } else {
        echo "<a href=\"".$addc.$i."\" title=\"".$text[26]."\">".$teams[$i]."</a>";
      }
    }
    if ($i == 0 && $j > 0 && $j <= $anzteams) {
      echo "<a href=\"".$addc.$j."\" title=\"".$teams[$j].": ".$text[26]."\">"."".$teamk[$j].""."</a>";
    }
    if ($j == $anzteams+1 && $i > 0 && $i <= $anzteams || $i == $anzteams+1 && $j > 0 && $j <= $anzteams) {
      echo "<acronym title='".$teams[$j]."'>";
      echo getSmallImage($teams[$j],$teamk[$j]);
      echo "</acronym>";
    }
    if ($j == $anzteams+1 && $i > 0 && $i <= $anzteams) {
      echo "<acronym title='".$teams[$i]."'>";
      echo getSmallImage($teams[$i],$teamk[$i]);
      echo "</acronym>";
    }

    if (($i > 0) && ($i <= $anzteams) && ($j > 0) && ($j <= $anzteams) && ($j != $i)) {
      $l = 0;
      for($b = 0; $b < $anzst; $b++) {
        for($a = 0; $a < $anzsp; $a++) {
          if (($i == $teama[$b][$a]) && ($j == $teamb[$b][$a])) {
            if (($mnote[$b][$a] != "") || ($msieg[$b][$a] > 0)) {
              if ($msieg[$b][$a] == 1) {
                $dummy = $dummy."&#10;&#10;".$text[219].":&#10;".$teams[$teama[$b][$a]]." ".$text[211];
              }
              if ($msieg[$b][$a] == 2) {
                $dummy = $dummy."&#10;&#10;".$text[219].":&#10;".$teams[$teamb[$b][$a]]." ".$text[211];
              }
              if ($msieg[$b][$a] == 3) {
                $dummy = $dummy."&#10;&#10;".$text[219].":&#10;".$text[212];
              }
              if ($mnote[$b][$a] != "") {
                $dummy = $dummy."&#10;&#10;".$text[22].":&#10;".$mnote[$b][$a];
              }
            } else {
              $dummy = "";
            }
            if ($l > 0) {
              echo "<br>";
            }
            if ($mterm[$b][$a] > 0) {
              $lmo_kreuz_longtime = ", ".strftime("%a. %d.%m.%Y %H:%M", $mterm[$b][$a]);
              $lmo_kreuz_shorttime = strftime("%d.%m.", $mterm[$b][$a]);
            } else {
              $lmo_kreuz_longtime = "";
              $lmo_kreuz_shorttime = "";
            }
            echo "<a href=\"".$addr.($b+1)."\" title=\"".$teams[$i]." - ".$teams[$j]." &#10;(".($b+1).". ".$text[2].$lmo_kreuz_longtime.$dummy.")\">";
            if ($goala[$b][$a]=="_" && $lmo_kreuz_shorttime!="") {
              echo $lmo_kreuz_shorttime;
            } else {
              if ($goala[$b][$a]!="_") echo "<strong>";
              echo applyFactor($goala[$b][$a],$goalfaktor).":".applyFactor($goalb[$b][$a],$goalfaktor);
              if ($goala[$b][$a]!="_") echo "</strong>";
            }
            if ($spez == 1) {
              echo " ".$mspez[$b][$a];
            }
            if (($mnote[$b][$a] != "") || ($msieg[$b][$a] > 0)) {
              echo " !";
            }
            echo "</a>";
            $l++;
          }
        }
      }
    }
    if ($j==$i) echo "&nbsp;";
    if ($i == 0 || $i == ($anzteams+1) || $j == 0 || $j == ($anzteams+1)) {
      echo "</th>\n";
    } else {
      echo "</td>\n";
    }
    if ($j == ($anzteams+1)) {
      echo "</tr>\n";
    }
  }
  }?>
</table>
</td>
</tr>
</table><? 
}?>