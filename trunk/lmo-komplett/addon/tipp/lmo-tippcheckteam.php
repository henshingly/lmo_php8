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
  
  
$dumma = array("");
$team = array("");
$pswfile = PATH_TO_ADDONDIR."/tipp/".$tipp_tippauthtxt;
$datei = fopen($pswfile, "rb");
while ($datei && !feof($datei)) {
  $zeile = fgets($datei, 1000);
  $zeile = chop($zeile);
  if ($zeile != "") {
    array_push($dumma, $zeile);
  }
}
fclose($datei);
$v = 0; // Teamnummer
array_shift($dumma);
 
$tipperteam = array_pad($array, count($dumma)+1, "");
 
for($i = 0; $i < count($dumma); $i++) {
  $dummb1 = explode('|', $dumma[$i]);
  if ($dummb1[5] != "") {
    $gef = 0;
    for($j = 0; $j < $v && $gef == 0; $j++) {
      if ($team[$j] == $dummb1[5]) {
        // Team schonmal gefunden
        $tipperteam[$j]++;
        $gef = 1;
      }
    }
    if ($gef == 0) {
      $team[$v] = $dummb1[5];
      $tipperteam[$v]++;
      $v++;
    }
  }
}
 
$gef = 0;
for($j = 0; $j < $v && $gef == 0; $j++) {
  if ($xtippervereinradio == 1) {
    if ($xtippervereinalt == $team[$j]) {
      $gef = 1;
      if ($tipperteam[$j] >= $tipp_tipperimteam && $tipp_tipperimteam != 0) {
        // max. Tipperanzahl schon erreicht
        $newpage = 0;
        echo getMessage($text['tipp'][142],TRUE);
      }
    }
  }
  if ($xtippervereinradio == 2) {
    if ($xtippervereinneu == $team[$j]) {
      // Team existiert bereits
      $gef = 1;
      $newpage = 0;
      echo getMessage($text['tipp'][143],TRUE);
    }
  }
}

?>