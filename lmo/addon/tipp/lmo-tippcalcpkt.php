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
  
  
function tipppunkte($gta0, $gtb0, $ga0, $gb0, $msieg, $msp, $text0, $text1, $jkspfaktor0, $mtipp) {
  // wieviel Punkte gibts für den Tipp
   
  global $tipp_tippmodus;
  global $tipp_entscheidungnv;
  global $tipp_entscheidungie;
  global $tipp_rergebnis;
  global $tipp_rtendenzdiff;
  global $tipp_rtendenz;
  global $tipp_rtor;
  global $tipp_rtendenztor;
  global $tipp_rtendenzremis;
  global $tipp_rremis;
  global $tipp_gtpunkte;
  global $tipp_showzus;
   
  if ($tipp_showzus == 1) {
    if ($tipp_tippmodus == 1) {
      global $punkte1;
      global $punkte2;
      global $punkte3;
      global $punkte4;
    }
    global $punkte5;
    global $punkte6;
  }
   
  if ($mtipp == 1) {
    $punktespiel = -2;
  } // Spiel nicht werten
  elseif($tipp_tippmodus == 1) {
    // Ergebnis-Tippmodus
    if ($msieg == 0) {
      if ($msp == $text0 && $tipp_entscheidungnv == 1) {
        if ($gtb0 == $gta0) {
          if ($tipp_rtendenzremis == 1) {
            $punktespiel = $tipp_rtendenz;
            if ($tipp_showzus == 1) {
              $punkte3++;
            }
          } else {
            $punktespiel = $tipp_rtendenzdiff;
            if ($tipp_showzus == 1) {
              $punkte2++;
            }
          }
        } else {
          $punktespiel = 0;
        }
      } elseif($msp == $text1 && $tipp_entscheidungie == 1) {
        if ($gtb0 == $gta0) {
          if ($tipp_rtendenzremis == 1) {
            $punktespiel = $tipp_rtendenz;
            if ($tipp_showzus == 1) {
              $punkte3++;
            }
          } else {
            $punktespiel = $tipp_rtendenzdiff;
            if ($tipp_showzus == 1) {
              $punkte2++;
            }
          }
        } else {
          $punktespiel = 0;
        }
      } elseif($gta0 == $ga0 && $gtb0 == $gb0) {
        $punktespiel = $tipp_rergebnis;
        if ($tipp_showzus == 1) {
          $punkte1++;
        }
      } elseif($ga0 == $gb0 && $gta0 == $gtb0 && $tipp_rtendenzremis == 1) {
        // richtiger 0-Tipp
        $punktespiel = $tipp_rtendenz;
        if ($tipp_showzus == 1) {
          $punkte3++;
        }
      } elseif($gtb0-$gta0 == $gb0-$ga0) {
        $punktespiel = $tipp_rtendenzdiff;
        if ($tipp_showzus == 1) {
          $punkte2++;
        }
      } // richtige Tendenz und Tordiff
      elseif(($gtb0 > $gta0 && $gb0 > $ga0) || ($gtb0 < $gta0 && $gb0 < $ga0)) {
        $punktespiel = $tipp_rtendenz;
        if ($tipp_showzus == 1) {
          $punkte3++;
        }
        if ($tipp_rtendenztor == 1 && ($gta0 == $ga0 || $gtb0 == $gb0)) {
          $punktespiel += $tipp_rtor;
          if ($tipp_showzus == 1) {
            $punkte4++;
          }
        }
      } elseif($gta0 == $ga0 || $gtb0 == $gb0) {
        $punktespiel = $tipp_rtor;
        if ($tipp_showzus == 1) {
          $punkte4++;
        }
      } else {
        $punktespiel = 0;
      }
    } elseif($tipp_gtpunkte == 2 && ($msieg == 1 || $msieg == 2 || $msieg == 3)) {
      // GT-Entscheidung nicht werten
      $punktespiel = -1;
    } elseif($msieg == 1) {
      // GT-Entscheidung
      if ($gtb0-$gta0 < 0) {
        if ($tipp_gtpunkte == 1) {
          $punktespiel = $tipp_rtendenz;
          if ($tipp_showzus == 1) {
            $punkte3++;
          }
        } else {
          $punktespiel = $tipp_rtendenzdiff;
          if ($tipp_showzus == 1) {
            $punkte2++;
          }
        }
      } else {
        $punktespiel = 0;
      }
    } elseif($msieg == 2) {
      // GT-Entscheidung
      if ($gtb0-$gta0 > 0) {
        if ($tipp_gtpunkte == 1) {
          $punktespiel = $tipp_rtendenz;
          if ($tipp_showzus == 1) {
            $punkte3++;
          }
        } else {
          $punktespiel = $tipp_rtendenzdiff;
          if ($tipp_showzus == 1) {
            $punkte2++;
          }
        }
      } else {
        $punktespiel = 0;
      }
    } elseif($msieg == 3) {
      // GT-Entscheidung beidseitiges Erg.
      if ($gtb0-$gta0 == 0) {
        if ($tipp_gtpunkte == 1) {
          $punktespiel = $tipp_rtendenz;
          if ($tipp_showzus == 1) {
            $punkte3++;
          }
        } else {
          $punktespiel = $tipp_rtendenzdiff;
          if ($tipp_showzus == 1) {
            $punkte2++;
          }
        }
      } else {
        $punktespiel = 0;
      }
    } else {
      $punktespiel = -1;
    } // Ergebnis noch nicht eingetragen
  } elseif($tipp_tippmodus == 0) {
    // Tendenz-Tippmodus
    if ($msieg == 0) {
      if ($msp == $text0 && $tipp_entscheidungnv == 1) {
        if ($gtb0 == $gta0) {
          $punktespiel = 1;
        } else {
          $punktespiel = 0;
        }
      } elseif($msp == $text1 && $tipp_entscheidungie == 1) {
        if ($gtb0 == $gta0) {
          $punktespiel = 1;
        } else {
          $punktespiel = 0;
        }
      } elseif(($gtb0 > $gta0 && $gb0 > $ga0) || ($gtb0 < $gta0 && $gb0 < $ga0) || ($gtb0 == $gta0 && $gb0 == $ga0)) {
        $punktespiel = 1;
      } else {
        $punktespiel = 0;
      }
    } elseif($tipp_gtpunkte == 2 && ($msieg == 1 || $msieg == 2 || $msieg == 3)) {
      // GT-Entscheidung nicht werten
      $punktespiel = -1;
    } elseif($msieg == 1) {
      // GT-Entscheidung
      if ($gtb0-$gta0 < 0) {
        $punktespiel = 1;
      } else {
        $punktespiel = 0;
      }
    } elseif($msieg == 2) {
      // GT-Entscheidung
      if ($gtb0-$gta0 > 0) {
        $punktespiel = 1;
      } else {
        $punktespiel = 0;
      }
    } elseif($msieg == 3) {
      // GT-Entscheidung beidseitiges Erg.
      if ($gtb0-$gta0 == 0) {
        $punktespiel = 1;
      } else {
        $punktespiel = 0;
      }
    } else {
      $punktespiel = -1;
    }
  }
  if ($tipp_rremis > 0 && $punktespiel > 0 && $gtb0 == $gta0 && $gb0 == $ga0) {
    $punktespiel += $tipp_rremis;
    if ($tipp_showzus == 1) {
      $punkte5++;
    }
  }
  if ($jkspfaktor0 > 1 && $punktespiel > 0) {
    if ($tipp_showzus == 1) {
      $punkte6 += $punktespiel * $jkspfaktor0-$punktespiel;
    }
    $punktespiel *= $jkspfaktor0;
  }
   
  //  echo $gta0.$gtb0.$ga0.$gb0."->".$punktespiel."<br>";
  return $punktespiel;
}

?>