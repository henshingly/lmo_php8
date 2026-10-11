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
if (!defined('PATH_TO_LMO')) {
    exit;  // kein Direktaufruf: diese Datei wird nur ueber LMO eingebunden
}


/**
 * Diese Datei wird eingebunden und erwartet:
 *
 * @var \Lmo\Liga\LigaDaten $ligaDaten Daten der geladenen Liga (lmo-openfile.php)
 * @var string $file Ligadatei relativ zum Ligenordner, leer wenn keine geladen ist
 * @var array<int|string, mixed> $text Sprachtexte
 */
if (($file!="") && ($ligaDaten->kreuz==1)){
  $addc=$_SERVER['PHP_SELF']."?action=cross&amp;file=".$file."&amp;croteam=";
  $addr=$_SERVER['PHP_SELF']."?action=results&amp;file=".$file."&amp;st=";
  $croteam=!empty($_GET['croteam'])?$_GET['croteam']:0;
?>
<table class="lmoMiddle" cellspacing="0" cellpadding="0" border="0">
<tr>
<td class="lmoKreuz">
<table class="lmoInner" cellspacing="0" cellpadding="0" border="0">

<?php
for ($i = 0; $i <= ($ligaDaten->anzteams+1); $i++) {
  for ($j = 0; $j <= ($ligaDaten->anzteams+1); $j++) {
    $dummy = "";
    if ($j == 0) {
      echo "<tr>";
    }
    if ($j == 0){
      echo "<th align='right'>";
    } elseif ($j == ($ligaDaten->anzteams+1)) {
      echo "<th align='left'>";
    } elseif ($i == 0 || $i == ($ligaDaten->anzteams+1)){
      echo "<th align='center'>";
    } elseif ($croteam != 0 && ($j == $croteam || $i == $croteam)) {
      echo "<td align='center' class='lmoBackMarkierung'>";
    } elseif ($j == $i) {
      echo "<td class='lmoLeer'>";
    } else {
      echo "<td align='center'>";
    }

    if (($j == 0) && ($i > 0) && ($i <= $ligaDaten->anzteams)) {
      if (($croteam != 0) && (($j == $croteam) || ($i == $croteam))) {
        echo $ligaDaten->teams[$i];
      } else {
        echo "<a href=\"".$addc.$i."\" title=\"".$text[26]."\">".$ligaDaten->teams[$i]."</a>";
      }
    }
    if ($i == 0 && $j > 0 && $j <= $ligaDaten->anzteams) {
      echo "<a href=\"".$addc.$j."\" title=\"".$ligaDaten->teams[$j].": ".$text[26]."\">"."".$ligaDaten->teamk[$j].""."</a>";
    }
    if ($j == $ligaDaten->anzteams+1 && $i > 0 && $i <= $ligaDaten->anzteams || $i == $ligaDaten->anzteams+1 && $j > 0 && $j <= $ligaDaten->anzteams) {
      $ligaDaten->teams[$j] = str_replace( "'", "´", $ligaDaten->teams[$j] ); //an attribute value literal can occur in an attribute specification list only after a VI delimiter because Team names with an apostrophe inside
      echo "<acronym title='".$ligaDaten->teams[$j]."'>";
      echo HTML_smallTeamIcon($file,$ligaDaten->teams[$j]," alt='{$ligaDaten->teamk[$j]}'");
      echo "</acronym>";
      
    }
    if ($j == $ligaDaten->anzteams+1 && $i > 0 && $i <= $ligaDaten->anzteams) {
      $ligaDaten->teams[$i] = str_replace( "'", "´", $ligaDaten->teams[$i] ); //an attribute value literal can occur in an attribute specification list only after a VI delimiter because Team names with an apostrophe inside
      echo "<acronym title='".$ligaDaten->teams[$i]."'>";
      echo HTML_smallTeamIcon($file,$ligaDaten->teams[$i]," alt='{$ligaDaten->teamk[$i]}'");
      echo "</acronym>";
    }

    if (($i > 0) && ($i <= $ligaDaten->anzteams) && ($j > 0) && ($j <= $ligaDaten->anzteams) && ($j != $i)) {
      $l = 0;
      for ($b = 0; $b < $ligaDaten->anzst; $b++) {
        for ($a = 0; $a < $ligaDaten->anzsp; $a++) {
          if (($i == $ligaDaten->teama[$b][$a]) && ($j == $ligaDaten->teamb[$b][$a])) {
            if (($ligaDaten->mnote[$b][$a] != "") || ($ligaDaten->msieg[$b][$a] > 0)) {
              if ($ligaDaten->msieg[$b][$a] == 1) {
                $dummy = $dummy."&#10;&#10;".$text[219].":&#10;".$ligaDaten->teams[$ligaDaten->teama[$b][$a]]." ".$text[211];
              }
              if ($ligaDaten->msieg[$b][$a] == 2) {
                $dummy = $dummy."&#10;&#10;".$text[219].":&#10;".$ligaDaten->teams[$ligaDaten->teamb[$b][$a]]." ".$text[211];
              }
              if ($ligaDaten->msieg[$b][$a] == 3) {
                $dummy = $dummy."&#10;&#10;".$text[219].":&#10;".$text[212];
              }
              if ($ligaDaten->mnote[$b][$a] != "") {
                $dummy = $dummy."&#10;&#10;".$text[22].":&#10;".$ligaDaten->mnote[$b][$a];
              }
            } else {
              $dummy = "";
            }
            if ($l > 0) {
              echo "<br>";
            }
            if ($ligaDaten->mterm[$b][$a] > 0) {
              $lmo_kreuz_longtime = ", ".date("D. d.m.Y H:i", $ligaDaten->mterm[$b][$a]);
              $lmo_kreuz_shorttime = date("d.m.", $ligaDaten->mterm[$b][$a]);
            } else {
              $lmo_kreuz_longtime = "";
              $lmo_kreuz_shorttime = "";
            }
            echo "<a href=\"".$addr.($b+1)."\" title=\"".$ligaDaten->teams[$i]." - ".$ligaDaten->teams[$j]." &#10;(".($b+1).". ".$text[2].$lmo_kreuz_longtime.$dummy.")\">";
            if ($ligaDaten->goala[$b][$a]=="_" && $lmo_kreuz_shorttime!="") {
              echo $lmo_kreuz_shorttime;
            } else {
              if ($ligaDaten->goala[$b][$a]!="_") echo "<strong>";
              echo applyFactor($ligaDaten->goala[$b][$a],$ligaDaten->goalfaktor).":".applyFactor($ligaDaten->goalb[$b][$a],$ligaDaten->goalfaktor);
              if ($ligaDaten->goala[$b][$a]!="_") echo "</strong>";
            }
            if ($ligaDaten->spez == 1) {
              echo " ".$ligaDaten->mspez[$b][$a];
            }
            if (($ligaDaten->mnote[$b][$a] != "") || ($ligaDaten->msieg[$b][$a] > 0)) {
              echo " !";
            }
            echo "</a>";
            $l++;
          }
        }
      }
    }
    if ($j==$i) echo "&nbsp;";
    if ($i == 0 || $i == ($ligaDaten->anzteams+1) || $j == 0 || $j == ($ligaDaten->anzteams+1)) {
      echo "</th>\n";
    } else {
      echo "</td>\n";
    }
    if ($j == ($ligaDaten->anzteams+1)) {
      echo "</tr>\n";
    }
  }
  }?>
</table>
</td>
</tr>
</table><?php
}?>