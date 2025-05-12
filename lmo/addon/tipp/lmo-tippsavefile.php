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
  
  
if ($todo == "tippuseredit") {
  require_once(PATH_TO_LMO."/lmo-admintest.php");
} else {
  require_once(PATH_TO_ADDONDIR."/tipp/lmo-tipptest.php");
}
 
if ($tippfile != "") {
  //if (decoct(fileperms($tippfile))!=100777){chmod ($tippfile, 0777);}
  if (substr($tippfile, -4) == ".tip") {
    $daten = array("");
    if ($st > 0 && file_exists($tippfile)) {
      $datei = fopen($tippfile, "rb");
      while ($datei && !feof($datei)) {
        $zeile = fgets($datei, 1000);
        $zeile = trim(chop($zeile));
        if ($zeile != "") {
          array_push($daten, $zeile);
        }
      }
      fclose($datei);
    }
     
    $datei = fopen($tippfile, "wb");
    if (!$datei) {
      echo getMessage($text[283],true);
      exit;
    } elseif ($todo != "newtipper" && $todo != "newligen" && $todo != "tippuseredit") {
      if (!isset($jkspanticheat)) {
        $jkspanticheat = false;
      }
      if ($jkspanticheat == false) {
        echo getMessage($text['tipp'][41]);
      } else {
        echo getMessage($text['tipp'][41]." ".$text['tipp'][292]);
      }
    }
    flock($datei, 2);
     
    $round = 0;
    for ($i = 0; $i < count($daten); $i++) {
      if ((substr($daten[$i], 0, 1) == "[") && (substr($daten[$i], -1) == "]")) {
        $round = substr($daten[$i], 6, -1);
      }
      if ($round != $st) {
        //////////// nur die unveränderten Spieltage werden zurückgeschrieben
        fputs($datei, $daten[$i]."\n");
      }
    }
     
    if ($st > 0) {
      // am Ende getippten Spieltag dazu schreiben
      fputs($datei, "\n[Round".$st."]\n");
      if ($tipp_jokertipp == 1) {
        fputs($datei, "@".$jksp."@\n");
      }
      if ($lmtype != 0) {
        $anzsp = $anzteams;
        for ($i = 0; $i < $st; $i++) {
          $anzsp = $anzsp/2;
        }
        if (($klfin == 1) && ($st == $anzst)) {
          $anzsp = $anzsp+1;
        }
      }
      for ($j = 1; $j <= $anzsp; $j++) {
        if ($lmtype == 0) {
          if ($goaltippa[$j-1] == "_") {
            fputs($datei, "GA".$j."=-1\n");
          } elseif ($goaltippa[$j-1] == "") {
            fputs($datei, "GA".$j."=-1\n");
          } else {
            fputs($datei, "GA".$j."=".$goaltippa[$j-1]."\n");
          }
          if ($goaltippb[$j-1] == "_") {
            fputs($datei, "GB".$j."=-1\n");
          } elseif ($goaltippb[$j-1] == "") {
            fputs($datei, "GB".$j."=-1\n");
          } else {
            fputs($datei, "GB".$j."=".$goaltippb[$j-1]."\n");
          }
        } else {
          for ($n = 1; $n <= $modus[$st-1]; $n++) {
            if ($goaltippa[$j-1][$n-1] == "_") {
              fputs($datei, "GA".$j.$n."=-1\n");
            } elseif ($goaltippa[$j-1][$n-1] == "") {
              fputs($datei, "GA".$j.$n."=-1\n");
            } else {
              fputs($datei, "GA".$j.$n."=".$goaltippa[$j-1][$n-1]."\n");
            }
            if ($goaltippb[$j-1][$n-1] == "_") {
              fputs($datei, "GB".$j.$n."=-1\n");
            } elseif ($goaltippb[$j-1][$n-1] == "") {
              fputs($datei, "GB".$j.$n."=-1\n");
            } else {
              fputs($datei, "GB".$j.$n."=".$goaltippb[$j-1][$n-1]."\n");
            }
          }
        }
      }
    } // am Ende getippten Spieltag dazu schreiben
    flock($datei, 3);
    fclose($datei);
  }
   
  clearstatcache();
}

?>