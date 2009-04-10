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
  if ((substr($zeile, 0, 1) == "@") && (substr($zeile, -1) == "@")) {
    $jkwert = trim(substr($zeile, 1, -1));
  } elseif((substr($zeile, 0, 1) == "[") && (substr($zeile, -1) == "]")) {
    $sekt = trim(substr($zeile, 1, -1));
    $jkwert = "";
  } elseif((strpos($zeile, "=") != false) && (substr($zeile, 0, 1) != ";")) {
    $schl = trim(substr($zeile, 0, strpos($zeile, "=")));
    $wert = trim(substr($zeile, strpos($zeile, "=")+1));
    array_push($tippdaten, $sekt."|".$schl."|".$wert."|".$jkwert."|EOL");
  }
}
fclose($datei);

 
if ($lmtype == 0) {
  $jksp = array_pad($array, 116, "");
  $goaltippa = array_pad($array, 116, "");
  $goaltippb = array_pad($array, 116, "");
  for($i = 0; $i < 116; $i++) {
    $goaltippa[$i] = array_pad(array("_"), 40, "_");
    $goaltippb[$i] = array_pad(array("_"), 40, "_");
  }
} else {
  $jksp = array_pad($array, 7, "");
  $goaltippa = array_pad($array, 7, "");
  $goaltippb = array_pad($array, 7, "");
  for($i = 0; $i < 7; $i++) {
    $goaltippa[$i] = array_pad(array(""), 64, "");
    $goaltippb[$i] = array_pad(array(""), 64, "");
    for($j = 0; $j < 64; $j++) {
      $goaltippa[$i][$j] = array_pad(array("_"), 7, "_");
      $goaltippb[$i][$j] = array_pad(array("_"), 7, "_");
    }
  }
}
 
 
for($i = 1; $i <= count($tippdaten); $i++) {
  $dum = explode('|', $tippdaten[$i-1]);
  $op2 = substr($dum[0], 0, 5);
  $op3 = substr($dum[0], 5)-1;
  $op4 = substr($dum[1], 2)-1;
  $op6 = substr($dum[1], 2, -1)-1;
  $op7 = substr($dum[1], -1)-1;
  $op8 = substr($dum[1], 0, 2);
  $jksp[$op3] = $dum[3];
  if ($lmtype == 0) {
    if (($op2 == "Round") && ($op8 == "GA")) {
      $goaltippa[$op3][$op4] = $dum[2];
      if ($goaltippa[$op3][$op4] == "") {
        $goaltippa[$op3][$op4] = -1;
      }
      if ($goaltippa[$op3][$op4] == "-1") {
        $goaltippa[$op3][$op4] = "_";
      }
    }
    if (($op2 == "Round") && ($op8 == "GB")) {
      $goaltippb[$op3][$op4] = $dum[2];
      if ($goaltippb[$op3][$op4] == "") {
        $goaltippb[$op3][$op4] = -1;
      }
      if ($goaltippb[$op3][$op4] == "-1") {
        $goaltippb[$op3][$op4] = "_";
      }
    }
  } else {
    if (($op2 == "Round") && ($op8 == "GA")) {
      $goaltippa[$op3][$op6][$op7] = $dum[2];
      if ($goaltippa[$op3][$op6][$op7] == "") {
        $goaltippa[$op3][$op6][$op7] = -1;
      }
      if ($goaltippa[$op3][$op6][$op7] == "-1") {
        $goaltippa[$op3][$op6][$op7] = "_";
      }
    }
    if (($op2 == "Round") && ($op8 == "GB")) {
      $goaltippb[$op3][$op6][$op7] = $dum[2];
      if ($goaltippb[$op3][$op6][$op7] == "") {
        $goaltippb[$op3][$op6][$op7] = -1;
      }
      if ($goaltippb[$op3][$op6][$op7] == "-1") {
        $goaltippb[$op3][$op6][$op7] = "_";
      }
    }
  }
}
clearstatcache();

?>