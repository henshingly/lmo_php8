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
  
  
if (file_exists($einsichtfile)) {
  $datei = fopen($einsichtfile, "rb");
  if ($datei != false) {
    $tippdaten = array("");
    $sekt = "";
    while (!feof($datei)) {
      $zeile = fgets($datei, 1000);
      $zeile = chop($zeile);
      $zeile = trim($zeile);
      if ((substr($zeile, 0, 1) == "[") && (substr($zeile, -1) == "]")) {
        $sekt = trim(substr($zeile, 1, -1));
        if ($zeile != "[Options]") {
          array_push($tippdaten, $sekt."|||EOL");
        }
      } elseif((strpos($zeile, "=") != false) && (substr($zeile, 0, 1) != ";")) {
        $schl = trim(substr($zeile, 0, strpos($zeile, "=")));
        $wert = trim(substr($zeile, strpos($zeile, "=")+1));
        array_push($tippdaten, $sekt."|".$schl."|".$wert."|EOL");
      }
    }
    fclose($datei);
  }
  array_shift($tippdaten);
   
  for($l = 1; $l <= count($tippdaten); $l++) {
    $dum = explode('|', $tippdaten[$l-1]);
    $op4 = substr($dum[1], 0, 2);
    if ($op4 == "GA") {
      $tippa0 = $dum[2];
    }
    if ($op4 == "GB") {
      $tippb0 = $dum[2];
      $spiel0 = substr($dum[1], 2);
       
      for($k = $start2; $k <= $i; $k++) {
        if ($spiel0 == $spiel[$k]) {
          if ($tippa0 > 0) {
            $toregesa[$k] += $tippa0;
          }
          if ($tippb0 >= 0) {
            $toregesb[$k] += $tippb0;
            $anzgetippt[$k]++;
          }
           
          if ($tippb0 < $tippa0) {
            $tendenz1[$k]++;
          } elseif($tippb0 > $tippa0) {
            $tendenz2[$k]++;
          } elseif($tippa0 >= 0 && $tippb0 >= 0) {
            $tendenz0[$k]++;
          }
        }
      }
    }
  }
  clearstatcache();
}
?>