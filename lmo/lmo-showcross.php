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
  */


if(($file!="") && ($kreuz==1)){
  $addc=$_SERVER['PHP_SELF']."?action=cross&amp;file=".$file."&amp;croteam=";
  $addr=$_SERVER['PHP_SELF']."?action=results&amp;file=".$file."&amp;st=";
  $croteam=!empty($_GET['croteam'])?$_GET['croteam']:$favteam;
?>
      <div class="container">

<?php
for($i = 0; $i <= ($anzteams); $i++) {
  echo "<div class='row pt-3'>";
  for($j = 0; $j <= ($anzteams); $j++) {
    $dummy = "";
    if ($j == 0) {
      echo "<div class='col-cross text-center'>";
    } elseif($j == $i) {
      echo "<div class='col-cross bg'>";
    } else {
      echo "<div class='col-cross text-center'>";
    }

    if (($j == 0) && ($i > 0) && ($i <= $anzteams)) {
      if (($croteam != 0) && (($j == $croteam) || ($i == $croteam))) {
        echo "<a href=\"".$addc.$i."\" title='".$teams[$j]."'>";
        echo HTML_smallTeamIcon($file,$teams[$i],"width='24'"," alt='$teamk[$i]'");
        echo "</a>";
      } else {
        echo "<a href=\"".$addc.$i."\" title='".$teams[$i]."'>";
        echo HTML_smallTeamIcon($file,$teams[$i],"width='24'"," alt='$teamk[$i]'");
        echo "</a>";
      }
    }
    if ($i == 0 && $j > 0 && $j <= $anzteams) {
      echo "<a href=\"".$addc.$j."\" title='".$teams[$j]."'>";
      echo HTML_smallTeamIcon($file,$teams[$j],"width='24'"," alt='$teamk[$j]'");
      echo "</a>";
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
              echo "<br />";
            }
            if ($mterm[$b][$a] > 0) {
              $lmo_kreuz_longtime = ", ".date("D. d.m.Y H:i", $mterm[$b][$a]);
              $lmo_kreuz_shorttime = date("d.m.", $mterm[$b][$a]);
            } else {
              $lmo_kreuz_longtime = "";
              $lmo_kreuz_shorttime = "";
            }
            echo "<a href=\"".$addr.($b+1)."\" title=\"".$teams[$i]." - ".$teams[$j]." &#10;(".($b+1).". ".$text[2].$lmo_kreuz_longtime.$dummy.")\">";
            if ($goala[$b][$a]=="_" && $lmo_kreuz_shorttime!="") {
               echo "<small>$lmo_kreuz_shorttime</small>";
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
    if ($i == 0 || $i == ($anzteams) || $j == 0 || $j == ($anzteams)) {
      echo "</div>\n";
    } else {
      echo "</div>\n";
    }
    if ($j == ($anzteams+1)) {
      echo "</div>\n";
    }
  }
  echo "</div>\n";
  }?>
      </div><?php 
}?>