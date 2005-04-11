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
  
  
if ($lmtype != 0) {
  $anzsp = $anzteams;
  for($i = 0; $i < $st; $i++) {
    $anzsp = $anzsp/2;
  }
  if (($klfin == 1) && ($st == $anzst)) {
    $anzsp = $anzsp+1;
  }
}

$einsichtfile = PATH_TO_ADDONDIR."/tipp/".$tipp_dirtipp."einsicht/".substr($file, 0, -4)."_".$st.".ein";
if (!file_exists($einsichtfile)) {
  echo getMessage($text['tipp'][17],TRUE);
} else {
  $datei = fopen($einsichtfile, "rb");
  $anztipper = 0;
  if ($datei != false) {
    $tippdaten = array();
    $sekt = "";
    while (!feof($datei)) {
      $zeile = fgets($datei, 10000);
      $zeile = trim($zeile);
      if ((substr($zeile, 0, 1) == "@") && (substr($zeile, -1) == "@")) {
        $jkwert = trim(substr($zeile, 1, -1));
      } elseif((substr($zeile, 0, 1) == "[") && (substr($zeile, -1) == "]")) {
        $sekt = trim(substr($zeile, 1, -1));
        $jkwert = -1;
        if ($zeile != "[Options]") {
          array_push($tippdaten, $sekt."|||EOL");
          $anztipper++;
        }
      } elseif((strpos($zeile, "=") != false) && (substr($zeile, 0, 1) != ";")) {
        $schl = trim(substr($zeile, 0, strpos($zeile, "=")));
        $wert = trim(substr($zeile, strpos($zeile, "=")+1));
        if (!isset($jkwert)) {
          $jkwert = -1;
        }
        array_push($tippdaten, $sekt."|".$schl."|".$wert."|".$jkwert."|EOL");
      }
    }
    fclose($datei);
  }
   
  $tippernick = array_pad($array, $anztipper+1, "");
  $jksp2 = array_pad($array, $anztipper+1, "");
  $tippa = array_pad($array, $anztipper+1, "");
  $tippb = array_pad($array, $anztipper+1, "");
  for($i = 0; $i < $anztipper; $i++) {
    if ($lmtype != 0) {
      $tippa[$i] = array_pad($array, $anzsp+1, "");
      $tippb[$i] = array_pad($array, $anzsp+1, "");
      for($n = 0; $n < $anzsp; $n++) {
        $tippa[$i][$n] = array_pad(array("_"), 7, "_");
        $tippb[$i][$n] = array_pad(array("_"), 7, "_");
      }
    } else {
      $tippa[$i] = array_pad(array("_"), $anzsp+1, "_");
      $tippb[$i] = array_pad(array("_"), $anzsp+1, "_");
    }
  }
   
  if ($lmtype == 0) {
    $tendenz1 = array_pad(array("0"), $anzsp+1, "0");
    $tendenz0 = array_pad(array("0"), $anzsp+1, "0");
    $tendenz2 = array_pad(array("0"), $anzsp+1, "0");
    $toregesa = array_pad(array("0"), $anzsp+1, "0");
    $toregesb = array_pad(array("0"), $anzsp+1, "0");
    $anzgetippt = array_pad(array("0"), $anzsp+1, "0");
    $btip = array_pad(array("false"), $anzsp+1, "0");
  } else {
    $tendenz1 = array_pad($array, $anzsp+1, "");
    $tendenz0 = array_pad($array, $anzsp+1, "");
    $tendenz2 = array_pad($array, $anzsp+1, "");
    $toregesa = array_pad($array, $anzsp+1, "");
    $toregesb = array_pad($array, $anzsp+1, "");
    $anzgetippt = array_pad($array, $anzsp+1, "");
    $btip = array_pad($array, $anzsp+1, "");
    for($i = 0; $i < $anzsp; $i++) {
      $tendenz1[$i] = array_pad(array("0"), $modus[$st-1]+1, "0");
      $tendenz0[$i] = array_pad(array("0"), $modus[$st-1]+1, "0");
      $tendenz2[$i] = array_pad(array("0"), $modus[$st-1]+1, "0");
      $toregesa[$i] = array_pad(array("0"), $modus[$st-1]+1, "0");
      $toregesb[$i] = array_pad(array("0"), $modus[$st-1]+1, "0");
      $anzgetippt[$i] = array_pad(array("0"), $modus[$st-1]+1, "0");
      $btip[$i] = array_pad(array("false"), $modus[$st-1]+1, "false");
    }
  }
   
  $t = 0;
  if ($endtab < 1) {
    $endtab = $anzst;
  }
  for($i = 1; $i <= count($tippdaten); $i++) {
    $dum = explode('|', $tippdaten[$i-1]);
    $op1 = $dum[0];
    // Nick
    $op3 = substr($dum[1], 2)-1;
    // Spieltagsnummer
    $op4 = substr($dum[1], 0, 2);
    // TP
    $op6 = substr($dum[1], 2, -1)-1;
    $op7 = substr($dum[1], -1)-1;
    $op8 = $dum[3];
    if ($tippernick[$t] != $op1) {
      if ($tippernick[$t] != "") {
        $t++;
      }
      $tippernick[$t] = $op1;
    }
    $jksp2[$t] = $op8;
    if ($op4 == "GA") {
      if ($lmtype != 0) {
        $tippa[$t][$op6][$op7] = $dum[2];
        if ($dum[2] > 0) {
          $toregesa[$op6][$op7] += $dum[2];
        }
      } else {
        $tippa[$t][$op3] = $dum[2];
        if ($dum[2] > 0) {
          $toregesa[$op3] += $dum[2];
        }
      }
    }
    if ($op4 == "GB") {
      if ($lmtype != 0) {
        $tippb[$t][$op6][$op7] = $dum[2];
        if ($dum[2] >= 0) {
          $toregesb[$op6][$op7] += $dum[2];
          $anzgetippt[$op6][$op7]++;
        }
         
        if ($tippb[$t][$op6][$op7] < $tippa[$t][$op6][$op7]) {
          $tendenz1[$op6][$op7]++;
        } elseif($tippb[$t][$op6][$op7] > $tippa[$t][$op6][$op7]) {
          $tendenz2[$op6][$op7]++;
        } elseif($tippa[$t][$op6][$op7] >= 0 && $tippb[$t][$op6][$op7] >= 0) {
          $tendenz0[$op6][$op7]++;
        }
      } else {
        $tippb[$t][$op3] = $dum[2];
        if ($dum[2] >= 0) {
          $toregesb[$op3] += $dum[2];
          $anzgetippt[$op3]++;
        }
         
        if ($tippb[$t][$op3] < $tippa[$t][$op3]) {
          $tendenz1[$op3]++;
        } elseif($tippb[$t][$op3] > $tippa[$t][$op3]) {
          $tendenz2[$op3]++;
        } elseif($tippa[$t][$op3] >= 0 && $tippb[$t][$op3] >= 0) {
          $tendenz0[$op3]++;
        }
      }
    }
  }
   
  if ($todo = "einsicht") {
    $tab0 = array();
    for($a = 0; $a < $anztipper; $a++) {
      array_push($tab0, strtolower($tippernick[$a]).(50000000+$a));
    }
    sort($tab0, SORT_STRING);
  }
  clearstatcache();
}
 ?>