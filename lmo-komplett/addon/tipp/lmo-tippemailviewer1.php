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
  
  
if ($tippfile == "") {
  exit;
}
if (substr($tippfile, -4) != ".tip") {
  exit;
}
$tippdaten = array();
$sekt = "";
$datei = fopen($tippfile, "rb");
if ($datei == false) {
  exit;
}
while (!feof($datei)) {
  $zeile = fgets($datei, 1000);
  $zeile = trim($zeile);
  if ((substr($zeile, 0, 1) == "[") && (substr($zeile, -1) == "]")) {
    $sekt = trim(substr($zeile, 1, -1));
  } elseif((strpos($zeile, "=") != false) && (substr($zeile, 0, 1) != ";")) {
    $schl = trim(substr($zeile, 0, strpos($zeile, "=")));
    $wert = trim(substr($zeile, strpos($zeile, "=")+1));
    array_push($tippdaten, $sekt."|".$schl."|".$wert."|EOL");
  }
}
fclose($datei);
for($ii = 1; $ii <= count($tippdaten); $ii++) {
  $dum = explode('|', $tippdaten[$ii-1]);
  $op2 = substr($dum[0], 0, 5);
  $op8 = substr($dum[1], 0, 2);
  if (($op2 == "Round") && ($op8 == "GA")) {
    $spieltag0 = substr($dum[0], 5);
    $spiel0 = substr($dum[1], 2);
    if ($dum[2] != "" && $dum[2] != "-1") {
      for($j = 0; $j < $anzspiele; $j++) {
        if ($liga[$j] == $liga[$i] && $spieltag[$j] == $spieltag0 && $spiel[$j] == $spiel0) {
          $goaltipp[$j] = 1;
        }
      }
    }
  }
}
clearstatcache();

?>