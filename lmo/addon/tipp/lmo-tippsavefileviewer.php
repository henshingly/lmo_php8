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
  
  
require_once(PATH_TO_ADDONDIR."/tipp/lmo-tipptest.php");
if ($tippfile != "") {
  //if(decoct(fileperms($tippfile))!=100777){chmod ($tippfile, 0777);}
  if (substr($tippfile, -4) == ".tip") {
    $daten = array("");
    if (file_exists($tippfile)) {
      $datei = fopen($tippfile, "rb");
      while ($datei && !feof($datei)) {
        $zeile = fgets($datei, 1000);
        $zeile = trim($zeile);
        if ($zeile != "") {
          array_push($daten, $zeile);
        }
      }
      fclose($datei);
    }
     
    $datei = fopen($tippfile, "wb");
    if (!$datei) {
      echo getMessage($text[283],TRUE);
      exit;
    } elseif($start1 == 0) {
      echo getMessage($text['tipp'][41]);
    }
    flock($datei, 2);
     
    $stsave = array_pad($array, 116, "0");
    $round = 0;
    for($l = 0; $l < count($daten); $l++) {
      if (substr($daten[$l], 0, 6) == "[Round") {
        fputs($datei, $daten[$l]."\n");
        $round = substr($daten[$l], 6, -1);
        $jksave = 0;
        $stsave[$round] = 1;
        for($k = $start1; $k <= $i; $k++) {
          if ($round == $spieltag[$k]) {
            // getippte dazu schreiben
            if ($jksave == 0) {
              if ($jksp[$k] > 0) {
                fputs($datei, "@".$jksp[$k]."@\n");
                $jksave = 1;
              } elseif(substr($daten[$l+1], 0, 1) == "@") {
                $l++;
                fputs($datei, $daten[$l]."\n");
                $jksave = 1;
              }
            }
            if ($tippa[$k] == "_") {
              fputs($datei, "GA".$spiel[$k]."=-1\n");
            } elseif($tippa[$k] == "") {
              fputs($datei, "GA".$spiel[$k]."=-1\n");
            } else {
              fputs($datei, "GA".$spiel[$k]."=".$tippa[$k]."\n");
            }
            if ($tippb[$k] == "_") {
              fputs($datei, "GB".$spiel[$k]."=-1\n");
            } elseif($tippb[$k] == "") {
              fputs($datei, "GB".$spiel[$k]."=-1\n");
            } else {
              fputs($datei, "GB".$spiel[$k]."=".$tippb[$k]."\n");
            }
          }
        }
        if ($k == ($i+1) && $jksave == 0 && substr($daten[$l+1], 0, 1) == "@") {
          // Joker von nicht getippten Spieltag zurückschreiben
          $l++;
          fputs($datei, $daten[$l]."\n");
          $jksave = 1;
        }
      } elseif($daten[$l] != "" && substr($daten[$l], 0, 1) != "@") {
        for($k = $start1; $k <= $i; $k++) {
          $sp = substr($daten[$l], 2, strpos($daten[$l], "=")-2);
          if ($sp == $spiel[$k] && $round == $spieltag[$k]) {
            break; // nicht zurückschreiben
          }
        }
        if ($k == ($i+1)) {
          fputs($datei, $daten[$l]."\n");
        }
      }
    }
     
    for($k = $start1; $k <= $i; $k++) {
      if ($spieltag[$k] > 0 && $stsave[$spieltag[$k]] == 0) {
        // vorher nicht getippte st dazu schreiben
        if ($k == $start1 || $spieltag[$k] != $spieltag[$k-1]) {
          fputs($datei, "[Round".$spieltag[$k]."]\n");
          if ($jksp[$k] > 0) {
            fputs($datei, "@".$jksp[$k]."@\n");
          }
        }
        if ($tippa[$k] == "_") {
          fputs($datei, "GA".$spiel[$k]."=-1\n");
        } elseif($tippa[$k] == "") {
          fputs($datei, "GA".$spiel[$k]."=-1\n");
        } else {
          fputs($datei, "GA".$spiel[$k]."=".$tippa[$k]."\n");
        }
        if ($tippb[$k] == "_") {
          fputs($datei, "GB".$spiel[$k]."=-1\n");
        } elseif($tippb[$k] == "") {
          fputs($datei, "GB".$spiel[$k]."=-1\n");
        } else {
          fputs($datei, "GB".$spiel[$k]."=".$tippb[$k]."\n");
        }
      }
    }
     
    flock($datei, 3);
    fclose($datei);
  }
   
  clearstatcache();
}

?>