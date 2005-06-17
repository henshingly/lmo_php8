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
  
  
if (empty($all)) {
  $all = 0;
} else {
  $all = 1;
}
if ($all == 1) {
  $auswertfile = PATH_TO_ADDONDIR."/tipp/".$tipp_dirtipp."auswert/gesamt.aus";
} else {
  $auswertfile = PATH_TO_ADDONDIR."/tipp/".$tipp_dirtipp."auswert/".substr($file, 0, -4).".aus";
}
if (!file_exists($auswertfile)) {
  echo getMessage($text['tipp'][17],TRUE);
  $anztipper = 0;
} else {
  $datei = fopen($auswertfile, "rb");
  $anztipper = 0;
  $eigpos = -1;
  $anzst1 = $anzst;
   
  if ($datei != false) {
    $tippdaten = array();
    $sekt = "";
    while (!feof($datei)) {
      $zeile = fgets($datei, 1000);
      $zeile = chop($zeile);
      $zeile = trim($zeile);
      if ((substr($zeile, 0, 1) == "[") && (substr($zeile, -1) == "]")) {
        $sekt = trim(substr($zeile, 1, -1));
        if ($zeile != "[Options]") {
          array_push($tippdaten, $sekt."|||EOL");
          $anztipper++;
        }
      } elseif((strpos($zeile, "=") != false) && (substr($zeile, 0, 1) != ";")) {
        $schl = trim(substr($zeile, 0, strpos($zeile, "=")));
        $wert = trim(substr($zeile, strpos($zeile, "=")+1));
        if ($schl == "AnzLigen") {
          $endtab = $wert;
          $anzst1 = $wert;
        } // nur fuer die Gesamtwertung
        elseif($sekt != "Options") {
          array_push($tippdaten, $sekt."|".$schl."|".$wert."|EOL");
        }
      }
    }
    fclose($datei);
  }
   
  $tippernick = array_pad($array, $anztipper+1, "");
  $tippername = array_pad($array, $anztipper+1, "");
  $tipperemail = array_pad($array, $anztipper+1, "");
  $tipperteam = array_pad($array, $anztipper+1, "");
  if ($tipp_showstsiege == 1) {
    $stsiege = array_pad($array, $anztipper+1, "");
  }
  $spielegetipptgesamt = array_pad($array, $anztipper+1, "0");
  $quotegesamt = array_pad($array, $anztipper+1, "0");
  $tipppunktegesamt = array_pad($array, $anztipper+1, "0");
   
  if ($tipp_showzus == 1) {
    $punkte1gesamt = array_pad($array, $anztipper+1, "");
    $punkte2gesamt = array_pad($array, $anztipper+1, "");
    $punkte3gesamt = array_pad($array, $anztipper+1, "");
    $punkte4gesamt = array_pad($array, $anztipper+1, "");
    $punkte5gesamt = array_pad($array, $anztipper+1, "");
    $punkte6gesamt = array_pad($array, $anztipper+1, "");
  }
   
  $spielegetippt = array_pad($array, $anztipper+1, "0");
  $tipppunkte = array_pad($array, $anztipper+1, "");
  if ($tipp_showzus == 1) {
    $punkte1 = array_pad($array, $anztipper+1, "");
    $punkte2 = array_pad($array, $anztipper+1, "");
    $punkte3 = array_pad($array, $anztipper+1, "");
    $punkte4 = array_pad($array, $anztipper+1, "");
    $punkte5 = array_pad($array, $anztipper+1, "");
    $punkte6 = array_pad($array, $anztipper+1, "");
  }
  for($i = 0; $i < $anztipper; $i++) {
    $spielegetippt[$i] = array_pad(array("0"), $anzst1+1, "0");
    $tipppunkte[$i] = array_pad(array("0"), $anzst1+1, "0");
    if ($tipp_showzus == 1) {
      $punkte1[$i] = array_pad(array(""), $anzst1+1, "");
      $punkte2[$i] = array_pad(array(""), $anzst1+1, "");
      $punkte3[$i] = array_pad(array(""), $anzst1+1, "");
      $punkte4[$i] = array_pad(array(""), $anzst1+1, "");
      $punkte5[$i] = array_pad(array(""), $anzst1+1, "");
      $punkte6[$i] = array_pad(array(""), $anzst1+1, "");
    }
  }
  $t = 0;
   
  if ($endtab < 1) {
    $endtab = $anzst1;
  }
  for($i = 1; $i <= count($tippdaten); $i++) {
    $dum = explode('|', $tippdaten[$i-1]);
    $op1 = $dum[0];
    // Nick
    $op3 = substr($dum[1], 2)-1;
    // Spieltagsnummer
    $op4 = substr($dum[1], 0, 2);
    // TP
    if ($tippernick[$t] != $op1) {
      if ($tippernick[$t] != "") {
        $t++;
      }
      $tippernick[$t] = $op1;
      if ($op1 == $_SESSION['lmotippername'] && $op1 != "") {
        $eigpos = $t;
      }
    }
    if ($dum[1] == "Team") {
      $tipperteam[$t] = $dum[2];
    } elseif($dum[1] == "Name") {
      $tippername[$t] = $dum[2];
    } elseif($dum[1] == "Email") {
      $tipperemail[$t] = $dum[2];
    } elseif(($stwertmodus == "nur" && ($tabdat == "" || $op3 == $endtab-1)) || ($stwertmodus == "bis" && $op3 < $endtab)) {
      if ($op4 == "SG") {
        $spielegetippt[$t][$op3] = $dum[2];
      } elseif($op4 == "TP") {
        $tipppunkte[$t][$op3] = $dum[2];
      } elseif($tipp_showzus == 1) {
        if ($op4 == "P1") {
          $punkte1[$t][$op3] = $dum[2];
        } elseif($op4 == "P2") {
          $punkte2[$t][$op3] = $dum[2];
        } elseif($op4 == "P3") {
          $punkte3[$t][$op3] = $dum[2];
        } elseif($op4 == "P4") {
          $punkte4[$t][$op3] = $dum[2];
        } elseif($op4 == "P5") {
          $punkte5[$t][$op3] = $dum[2];
        } elseif($op4 == "P6") {
          $punkte6[$t][$op3] = $dum[2];
        }
      }
    }
  }
   
  if ($tipp_showstsiege == 1 && $anztipper > 0) {
    // Spieltagssieger ermitteln
    $tab = array_pad($array, $endtab, "");
    $a = 0;
    for($i = 0; $i < $endtab && isset($tipppunkte[$a][$i]); $i++) {
      $tab[$i] = array();
      for($a = 0; $a < $anztipper; $a++) {
        $tt = 50000000+$tipppunkte[$a][$i];
        for($k = 1; $k <= 3; $k++) {
          if ($k == 1) {
            $tipp_krit = $tipp_krit1;
          } elseif($k == 2) {
            $tipp_krit = $tipp_krit2;
          } elseif($k == 3) {
            $tipp_krit = $tipp_krit3;
          }
          if ($tipp_krit == -1) {
            $tt .= 50000000;
          } elseif($tipp_krit == 0) {
            $tt .= (50000000-$spielegetippt[$a][$i]);
          } elseif($tipp_krit == 1) {
            $tt .= (50000000+$spielegetippt[$a][$i]);
          } elseif($tipp_showzus == 1) {
            if ($tipp_krit == 2) {
              $tt .= (50000000+$punkte1[$a][$i]);
            } elseif($tipp_krit == 3) {
              $tt .= (50000000+$punkte2[$a][$i]);
            } elseif($tipp_krit == 4) {
              $tt .= (50000000+$punkte3[$a][$i]);
            } elseif($tipp_krit == 5) {
              $tt .= (50000000+$punkte6[$a][$i]);
            }
          }
        }
        $tt .= (50000000+$a);
        array_push($tab[$i], $tt);
      }
      rsort($tab[$i], SORT_STRING);
      $laeng = strlen($tab[$i][0]);
      for($a = 0; $a < $anztipper; $a++) {
        $x = intval(substr($tab[$i][$a], -7));
        if ($tipppunkte[$x][$i] <= 0) {
          break;
        }
        $stsiege[$x]++;
        $poswechs = 1;
        for($k = 0; $k <= $laeng-24; $k += 8) {
          if (!isset($tab[$i][$a+1]) || intval(substr($tab[$i][$a], $k+1, 7)) != intval(substr($tab[$i][$a+1], $k+1, 7))) {
            break;
          }
          if ($k == $laeng-24) {
            $poswechs = 0;
          }
        }
        if ($poswechs == 1) {
          break;
        }
      }
    }
  }
   
   
  $tab0 = array();
  for($a = 0; $a < $anztipper; $a++) {
    $spielegetipptgesamt[$a] = array_sum($spielegetippt[$a]);
    $tipppunktegesamt[$a] = array_sum($tipppunkte[$a]);
    if ($tipp_showzus == 1) {
      $punkte1gesamt[$a] = array_sum($punkte1[$a]);
      $punkte2gesamt[$a] = array_sum($punkte2[$a]);
      $punkte3gesamt[$a] = array_sum($punkte3[$a]);
      $punkte4gesamt[$a] = array_sum($punkte4[$a]);
      $punkte5gesamt[$a] = array_sum($punkte5[$a]);
      $punkte6gesamt[$a] = array_sum($punkte6[$a]);
    }
     
    if ($tipppunktegesamt[$a] == "") {
      $tipppunktegesamt[$a] = 0;
    }
    if ($spielegetipptgesamt[$a] == "") {
      $spielegetipptgesamt[$a] = 0;
    }
     
    if ($quotegesamt[$a] == "") {
      $quotegesamt[$a] = 0;
    }
    if ($spielegetipptgesamt[$a] != 0) {
      if ($tipp_tippmodus == 1) {
        $quotegesamt[$a] = number_format($tipppunktegesamt[$a]/$spielegetipptgesamt[$a], 2, ".", ",");
      }
      if ($tipp_tippmodus == 0) {
        $quotegesamt[$a] = number_format($tipppunktegesamt[$a]/$spielegetipptgesamt[$a] * 100, 2, ".", ",");
      }
      $quotegesamt[$a] *= 100;
    }
     
    $tt = "";
    if ($gewicht == "relativ") {
      $tt .= (50000000+$quotegesamt[$a]);
    } elseif($gewicht == "spiele") {
      $tt .= (50000000+$spielegetipptgesamt[$a]);
    }
    $tt .= (50000000+$tipppunktegesamt[$a]);
    for($k = 1; $k <= 3; $k++) {
      if ($k == 1) {
        $tipp_krit = $tipp_krit1;
      } elseif($k == 2) {
        $tipp_krit = $tipp_krit2;
      } elseif($k == 3) {
        $tipp_krit = $tipp_krit3;
      }
      if ($tipp_krit == 0) {
        $tt .= (50000000+$quotegesamt[$a]);
      } elseif($tipp_krit == 1) {
        $tt .= (50000000+$spielegetipptgesamt[$a]);
      } elseif($tipp_krit == 6) {
        if ($tipp_showstsiege == 1) {
          $tt .= (50000000+$stsiege[$a]);
        }
      } elseif($tipp_showzus == 1) {
        if ($tipp_krit == 2) {
          $tt .= (50000000+$punkte1gesamt[$a]);
        } elseif($tipp_krit == 3) {
          $tt .= (50000000+$punkte2gesamt[$a]);
        } elseif($tipp_krit == 4) {
          $tt .= (50000000+$punkte3gesamt[$a]);
        } elseif($tipp_krit == 5) {
          $tt .= (50000000+$punkte6gesamt[$a]);
        }
      }
    }
    $tt .= ((50000000-$a).(50000000+$a));
    array_push($tab0, $tt);
  }
  rsort($tab0, SORT_STRING);
}

?>