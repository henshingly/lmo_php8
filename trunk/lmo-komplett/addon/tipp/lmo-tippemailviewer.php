<?PHP
// 
// LigaManager Online 3.02
// Copyright (C) 1997-2002 by Frank Hollwitz
// webmaster@hollwitz.de / http://php.hollwitz.de
// 
// Tippspiel-AddOn 1.20
// Copyright (C) 2002 by Frank Albrecht
// fkalbrecht@web.de
// 
// This program is free software; you can redistribute it and/or
// modify it under the terms of the GNU General Public License as
// published by the Free Software Foundation; either version 2 of
// the License, or (at your option) any later version.
// 
// This program is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
// General Public License for more details.
// 
// You should have received a copy of the GNU General Public License
// along with this program; if not, write to the Free Software
// Foundation, Inc., 675 Mass Ave, Cambridge, MA 02139, USA.
// 
if ($file != "") {
  $liga0 = substr($dateien[$lnr], 0, -4);
  $lmtype0 = 0;
  if (substr($file, -4) == ".l98") {
    $daten = array("");
    $sekt = "";
    $datei = fopen($file, "rb");
    if ($datei) {
      while (!feof($datei)) {
        $zeile = fgets($datei, 1000);
        $zeile = chop($zeile);
        $zeile = trim($zeile);
        if ((substr($zeile, 0, 1) == "[") && (substr($zeile, -1) == "]")) {
          $sekt = trim(substr($zeile, 1, -1));
        } elseif((strpos($zeile, "=") != false) && (substr($zeile, 0, 1) != ";")) {
          $schl = trim(substr($zeile, 0, strpos($zeile, "=")));
          $wert = trim(substr($zeile, strpos($zeile, "=")+1));
          if ($sekt == "Options") {
            if ($schl == "Name") {
              $titel0 = stripslashes($wert);
            }
            if ($schl == "Type") {
              $lmtype0 = stripslashes($wert);
            }
            if ($schl == "Teams") {
              $anzteams = $wert;
            }
          }
          array_push($daten, $sekt."|".$schl."|".$wert."|EOL");
        }
      }
      fclose($datei);
    }
    array_shift($daten);
    clearstatcache();
     
    if (!isset($titel)) {
      $titel = "No Name";
    }
    if ($lmtype0 != 0) {
      if (!isset($anzteams)) {
        $anzteams = 16;
      }
    }
    $anzst0 = strlen(decbin($anzteams-1));
    for($i = 1; $i <= count($daten); $i++) {
      $dum = split("[|]", $daten[$i-1]);
      if ($dum[0] == "Teams") {
        $teams[$dum[1]] = stripslashes($dum[2]);
      }
      $op2 = substr($dum[0], 0, 5);
      if ($op2 == "Round") {
        $spieltag0 = substr($dum[0], 5);
        $op8 = substr($dum[1], 0, 2);
        if ($dum[1] == "D1") {
          $datum10 = $dum[2];
        } elseif($dum[1] == "D2") {
          $datum20 = $dum[2];
        } elseif($dum[1] == "MO" && $lmtype0 != 0) {
          $modus0 = $dum[2];
        } elseif($op8 == "TA") {
          $teama0 = $dum[2];
        } elseif($op8 == "TB") {
          $teamb0 = $dum[2];
        } elseif($op8 == "AT") {
          $zeit0 = zeit($dum[2], $datum10, $datum20);
          if ($zeit0 > $now && $zeit0 < $then && $teama0 > 0) {
            $spiel0 = substr($dum[1], 2);
            if ($lmtype0 == 0) {
              $modus0 = 1;
            }
             
            array_push($liga, $liga0);
            array_push($titel, $titel0);
            array_push($lmtype, $lmtype0);
            array_push($anzst, $anzst0);
            array_push($spieltag, $spieltag0);
            array_push($modus, $modus0);
            array_push($spiel, $spiel0);
            array_push($teama, $teams[$teama0]);
            array_push($teamb, $teams[$teamb0]);
            array_push($zeit, strftime("%A, %d.%m.%Y %R", $zeit0));
            $anzspiele++;
          }
        }
      }
    }
  }
}
clearstatcache();

?>