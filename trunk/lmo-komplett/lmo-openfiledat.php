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
  
  
if ($file != "") {
  if (substr($file, -4) == ".l98") {
    $daten = array();
    $sekt = "";
    $stand = strftime($defdateformat, filemtime($dirliga.$file));
    $datei = fopen($dirliga.$file, "rb");
    while ($datei && !feof($datei)) {
      $zeile = fgets($datei, 10000);
      $zeile = trim($zeile);
      if ((substr($zeile, 0, 1) == "[") && (substr($zeile, -1) == "]")) {
        $sekt = trim(substr($zeile, 1, -1));
      } elseif((strpos($zeile, "=") != false) && (substr($zeile, 0, 1) != ";")) {
        $schl = trim(substr($zeile, 0, strpos($zeile, "=")));
        $wert = trim(substr($zeile, strpos($zeile, "=")+1));
        if ($sekt == "Options") {
          if ($schl == "Name") {
            $titel = stripslashes($wert);
          }
          if ($schl == "goalfaktor") {
            $goalfaktor = $wert;
          }
          if ($schl == "Type") {
            $lmtype = stripslashes($wert);
          }
          if (!isset($lmtype)) {
            $lmtype = 0;
          }
          if ($schl == "Teams") {
            $anzteams = $wert;
          }
          if ($lmtype == 0) {
            if ($schl == "Rounds") {
              $anzst = $wert;
            }
            if ($schl == "Matches") {
              $anzsp = $wert;
            }
          }
          if (!isset($st)) {
            if ($schl == "Actual") {
              $st = $wert;
            }
          }
          if ($schl == "Actual") {
            $stx = $wert;
          }
          if ($lmtype == 0) {
          } else {
            if ($schl == "KlFin") {
              $klfin = $wert;
            }
          }
        }
        array_push($daten, $sekt."|".$schl."|".$wert."|EOL");
      }
    }
    fclose($datei);
    if (!isset($titel)) {
      $titel = "No Name";
    }
    if ($lmtype == 0) {
      if (!isset($anzteams)) {
        $anzteams = 18;
      }
      if (!isset($anzsp)) {
        $anzsp = floor($anzteams/2);
      }
      if (!isset($anzst)) {
        $anzst = floor($anzteams * ($anzteams-1)/$anzsp);
      }
    } else {
      if (!isset($anzteams)) {
        $anzteams = 16;
      }
      $anzsp = floor($anzteams/2);
      $anzst = strlen(decbin($anzteams-1));
    }
    if (!isset($dats)) {
      $dats = 1;
    }
    if (!isset($datm)) {
      $datm = 0;
    }
    if (!isset($datc)) {
      if ((isset($dats)) || (isset($datm))) {
        $datc = 1;
      } else {
        $datc = 0;
      }
    }
    if ((!isset($dats)) || (!isset($datm))) {
      $datc = 0;
    }
    $teams = array_pad($array, $anzteams+2, "");
    if ($lmtype == 0) {
      $datum1 = array_pad($array, 116, "");
      $datum2 = array_pad($array, 116, "");
      $teama = array_pad($array, 116, "");
      $teamb = array_pad($array, 116, "");
      $mterm = array_pad($array, 116, "");
      for($i = 0; $i < 116; $i++) {
        $teama[$i] = array_pad(array("0"), 40, "0");
        $teamb[$i] = array_pad(array("0"), 40, "0");
        $mterm[$i] = array_pad(array("0"), 40, "0");
      }
    } else {
      $datum1 = array_pad($array, 7, "");
      $datum2 = array_pad($array, 7, "");
      $modus = array_pad(array("1"), 7, "1");
      $teama = array_pad($array, 7, "");
      $teamb = array_pad($array, 7, "");
      $mterm = array_pad($array, 7, "");
      for($i = 0; $i < 7; $i++) {
        $teama[$i] = array_pad(array("0"), 64, "0");
        $teamb[$i] = array_pad(array("0"), 64, "0");
        $mterm[$i] = array_pad($array, 64, "");
        for($j = 0; $j < 64; $j++) {
          $mterm[$i][$j] = array_pad(array("0"), 7, "0");
        }
      }
    }
    $teams[0] = "___";
    for($i = 1; $i <= count($daten); $i++) {
      $dum = explode('|', $daten[$i-1]);
      if ($dum[0] == "Teams") {
        $teams[$dum[1]] = stripslashes($dum[2]);
      }
      $op1 = substr($dum[0], 0, 4);
      $op2 = substr($dum[0], 0, 5);
      $op3 = substr($dum[0], 5)-1;
      $op4 = substr($dum[1], 2)-1;
      $op5 = substr($dum[0], 4);
      $op6 = substr($dum[1], 2, -1)-1;
      $op7 = substr($dum[1], -1)-1;
      $op8 = substr($dum[1], 0, 2);
      if ($op3 == $st-1) {
        ////////////////////////////////////////////////// nur der benötigte Spieltag wird eingelesen
        if (($op2 == "Round") && ($dum[1] == "D1")) {
          $datum1[$op3] = $dum[2];
        }
        if (isset($datum1[$op3])) {
          if ($datum1[$op3] != "") {
            $dummy = strtotime(substr($datum1[$op3], 0, 2)." ".$me[intval(substr($datum1[$op3], 3, 2))]." ".substr($datum1[$op3], 6, 4));
            if ($dummy > -1) {
              $datum1[$op3] = strftime("%d.%m.%Y", $dummy);
            } else {
              $datum1[$op3] = "";
            }
          }
        }
        if (($op2 == "Round") && ($dum[1] == "D2")) {
          $datum2[$op3] = $dum[2];
        }
        if (isset($datum2[$op3])) {
          if ($datum2[$op3] != "") {
            $dummy = strtotime(substr($datum2[$op3], 0, 2)." ".$me[intval(substr($datum2[$op3], 3, 2))]." ".substr($datum2[$op3], 6, 4));
            if ($dummy > -1) {
              $datum2[$op3] = strftime("%d.%m.%Y", $dummy);
            } else {
              $datum2[$op3] = "";
            }
          }
        }
        if (($op2 == "Round") && ($op8 == "TA")) {
          $teama[$op3][$op4] = $dum[2];
        }
        if (($op2 == "Round") && ($op8 == "TB")) {
          $teamb[$op3][$op4] = $dum[2];
        }
        if ($lmtype == 0) {
          if (($op2 == "Round") && ($op8 == "AT")) {
            $mterm[$op3][$op4] = $dum[2];
          }
        } else {
          if (($op2 == "Round") && ($dum[1] == "MO")) {
            $modus[$op3] = $dum[2];
          }
          if (($op2 == "Round") && ($op8 == "AT")) {
            $mterm[$op3][$op6][$op7] = $dum[2];
          }
        }
      }
    }
  }
}

?>