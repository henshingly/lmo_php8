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

  $me = array("0", "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
  $liga0 = substr($dateien[$liganr], 0, -4);
  $lmtype0 = 0;
  if (substr($tippfile, -4) != ".tip") {
    exit;
  }
  if (substr($file, -4) == ".l98") {
    $mspez0 = 0;
    $daten = array();
    $sekt = "";
    if ($datei = fopen(PATH_TO_LMO.'/'.$dirliga.basename($file), "rb")) {
      while (!feof($datei)) {
        $zeile = fgets($datei, 1000);
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
            if ($schl == "goalfaktor") {
              $goalfaktor0 = $wert;
            }
            if ($schl == "urlB") {
              $urlb0 = $wert;
            }
            if ($schl == "Type") {
              $lmtype0 = stripslashes($wert);
            }
            if ($schl == "Teams") {
              $anzteams = $wert;
            }
            if ($lmtype0 == 0) {
              if ($schl == "HideDraw") {
                $hidr0 = $wert;
              }
            }
            if ($schl == "DatS") {
              $dats0 = $wert;
            }
            if ($schl == "DatM") {
              $datm0 = $wert;
            }
            if ($schl == "favTeam") {
              $favteam = $wert;
            }
          }
          array_push($daten, $sekt."|".$schl."|".$wert."|EOL");
        }
      }
      fclose($datei);
    }
    clearstatcache();
     
    $tippdaten = array();
    $sekt = "";
    $jkwert = "";
    $datei = fopen($tippfile, "rb");
    if ($datei == false) {
      exit;
    }
    while (!feof($datei)) {
      $zeile = fgets($datei, 1000);
      $zeile = chop($zeile);
      $zeile = trim($zeile);
      if ((substr($zeile, 0, 1) == "@") && (substr($zeile, -1) == "@")) {
        $jkwert = trim(substr($zeile, 1, -1));
      } elseif((substr($zeile, 0, 1) == "[") && (substr($zeile, -1) == "]")) {
        $sekt = trim(substr($zeile, 1, -1));
      } elseif((strpos($zeile, "=") != false) && (substr($zeile, 0, 1) != ";")) {
        $schl = trim(substr($zeile, 0, strpos($zeile, "=")));
        $wert = trim(substr($zeile, strpos($zeile, "=")+1));
        array_push($tippdaten, $sekt."|".$schl."|".$wert."|".$jkwert."|EOL");
      }
    }
    fclose($datei);
     
    if (!isset($favteam)) {
      $favteam = 0;
    }
    if (!isset($titel)) {
      $titel = "No Name";
    }
    if ($lmtype0 != 0) {
      if (!isset($anzteams)) {
        $anzteams = 16;
      }
    }
    $anzst0 = strlen(decbin($anzteams-1));
    if (!isset($dats)) {
      $dats = 1;
    }
    if (!isset($datm)) {
      $datm = 0;
    }
    for($i = 1; $i <= count($daten); $i++) {
      $dum = explode('|', $daten[$i-1]);
      if ($dum[0] == "Teams") {
        $teams[$dum[1]] = stripslashes($dum[2]);
      }
      $op2 = substr($dum[0], 0, 5);
      if ($op2 == "Round") {
        $spieltag0 = substr($dum[0], 5);
        $op8 = substr($dum[1], 0, 2);
        if ($dum[1] == "D1") {
          $rb = $i+2; // Anfang des st merken
          $dummy1 = "";
          if ($dum[2] != "") {
            $dummy1 = strtotime(substr($dum[2], 0, 2)." ".$me[intval(substr($dum[2], 3, 2))]." ".substr($dum[2], 6, 4));
            if ($tipp_tippohne == 1 && $deftime > 0) {
              $dummy1 = $dummy1+substr($deftime, 0, 2) * 60 * 60+substr($deftime, 3, 2) * 60;
            }
            if ($dummy1 > -1) {
              $dum[2] = strftime("%d.%m.%Y", $dummy1);
            } else {
              $dum[2] = "";
            }
          }
          $datum10 = $dum[2];
        } elseif($dum[1] == "D2") {
          $dummy2 = "";
          if ($dum[2] != "") {
            $dummy2 = strtotime(substr($dum[2], 0, 2)." ".$me[intval(substr($dum[2], 3, 2))]." ".substr($dum[2], 6, 4));
            if ($tipp_tippohne == 1 && $deftime > 0) {
              $dummy2 = $dummy2+substr($deftime, 0, 2) * 60 * 60+substr($deftime, 3, 2) * 60;
            }
            if ($dummy2 > -1) {
              $dum[2] = strftime("%d.%m.%Y", $dummy2);
            } else {
              $dum[2] = "";
            }
          }
          $datum20 = $dum[2];
        } elseif($dum[1] == "MO" && $lmtype0 != 0) {
          $modus0 = $dum[2];
        } elseif($op8 == "TA") {
          $teama0 = $dum[2];
        } elseif($op8 == "TB") {
          $teamb0 = $dum[2];
        } elseif($op8 == "GA") {
          $goala0 = $dum[2];
        } elseif($op8 == "GB") {
          $goalb0 = $dum[2];
        } elseif($op8 == "SP") {
          $mspez0 = $dum[2];
        } elseif($op8 == "ET" && $lmtype0 == 0 && $dum[2] == 3) {
          $msieg0 = 3;
        } elseif($op8 == "NT") {
          $mnote0 = addslashes($dum[2]);
        } elseif($op8 == "BE") {
          $mberi0 = addslashes($dum[2]);
        } elseif($op8 == "TI") {
          $mtipp0 = $dum[2];
        } elseif($op8 == "AT" && $teama0 > 0) {
          $btip = false;
          if ($dum[2] > 0) {
            if ($now <= $dum[2] && $then > $dum[2]) {
              $btip = true;
            }
          } elseif($dummy1 > 0) {
            if ($now <= $dummy1 && $then > $dummy1) {
              $btip = true;
            }
          } elseif($dummy2 > 0) {
            if ($now <= $dummy2 && $then > $dummy2) {
              $btip = true;
            }
          }
          if ($btip == true) {
            $spiel0 = substr($dum[1], 2);
            $mterm0 = $dum[2];
            if ($lmtype0 == 0) {
              $modus0 = 1;
            }
            if (!isset($mspez0)) {
              $mspez0 = "";
            }
            if (!isset($msieg0)) {
              $msieg0 = 0;
            }
             
            array_push($liga, $liga0);
            array_push($titel, $titel0);
            array_push($lmtype, $lmtype0);
            array_push($anzst, $anzst0);
            array_push($hidr, $hidr0);
            array_push($dats, $dats0);
            array_push($datm, $datm0);
            array_push($spieltag, $spieltag0);
            array_push($modus, $modus0);
            array_push($datum1, $datum10);
            array_push($datum2, $datum20);
            array_push($spiel, $spiel0);
            array_push($urlb, $urlb0);
            array_push($goalfaktor, $goalfaktor0);
            if ($favteam == $teama0) {
              $teama0 = "<strong>".$teams[$teama0]."</strong>";
            } else {
              $teama0 = $teams[$teama0];
            }
            array_push($teama, $teama0);
            if ($favteam == $teamb0) {
              $teamb0 = "<strong>".$teams[$teamb0]."</strong>";
            } else {
              $teamb0 = $teams[$teamb0];
            }
            array_push($teamb, $teamb0);
            if ($goala0 == "") {
              $goala0 = -1;
            }
            if ($goala0 == "-1") {
              $goala0 = "_";
            }
            if ($goala0 == "-2") {
              $msieg0 = 1;
              $goala0 = 0;
            }
            array_push($goala, $goala0);
            if ($goalb0 == "") {
              $goalb0 = -1;
            }
            if ($goalb0 == "-1") {
              $goalb0 = "_";
            }
            if ($goalb0 == "-2") {
              $msieg0 = 2;
              $goalb0 = 0;
            }
            array_push($goalb, $goalb0);
            if ($mspez0 == 0) {
              $mspez0 = "&nbsp;";
            }
            if ($mspez0 == 2) {
              $mspez0 = $text[0];
            }
            if ($mspez0 == 1) {
              $mspez0 = $text[1];
            }
            array_push($mspez, $mspez0);
            $mspez0 = 0;
            if (!isset($mtipp0)) {
              $mtipp0 = 0;
            }
            array_push($mtipp, $mtipp0);
            array_push($mnote, $mnote0);
            array_push($mberi, $mberi0);
            array_push($msieg, $msieg0);
            $msieg0 = 0;
            array_push($mterm, $mterm0);
            array_push($tippa, "");
            array_push($tippb, "");
            array_push($jksp, "");
            array_push($tipp_jokertippaktiv, "0");
            $anzspiele++;
            for($j = 1; $j <= count($tippdaten); $j++) {
              $dum1 = explode('|', $tippdaten[$j-1]);
              $op8 = substr($dum1[1], 0, 2);
              if ($op8 == "GA") {
                $tippa0 = $dum1[2];
              } elseif($op8 == "GB") {
                $tippb0 = $dum1[2];
                 
                $spieltag0t = substr($dum1[0], 5);
                $spiel0t = substr($dum1[1], 2);
                if ($spieltag0t == $spieltag0 && $spiel0t == $spiel0) {
                  if ($tippa0 == "") {
                    $tippa0 = -1;
                  }
                  if ($tippa0 == "-1") {
                    $tippa0 = "_";
                  }
                  if ($tippb0 == "") {
                    $tippb0 = -1;
                  }
                  if ($tippb0 == "-1") {
                    $tippb0 = "_";
                  }
                  $tippa[$anzspiele-1] = $tippa0;
                  $tippb[$anzspiele-1] = $tippb0;
                  if ($tipp_jokertipp == 1) {
                    if ($dum1[3] == $spiel0t) {
                      $jksp[$anzspiele-1] = $spiel0t;
                    } else {
                      $jksp[$anzspiele-1] = 0;
                    }
                     
                    if ($dum1[3] > 0) {
                      for($k = $rb; $k <= count($daten); $k++) {
                        $dum2 = explode('|', $daten[$k-1]);
                        $op8 = substr($dum2[1], 0, 2);
                        if ($op8 == "AT") {
                          $spiel0 = substr($dum2[1], 2);
                          if ($spiel0 == $dum1[3]) {
                            $tipp_jokertippaktiv[$anzspiele-1] = zeit($dum2[2], $datum10, $datum20);
                            break;
                          }
                        }
                      }
                    }
                  }
                  break;
                }
              }
            }
          }
        }
      }
    }
  }
}
clearstatcache();
?>