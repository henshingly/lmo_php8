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
if (!defined('PATH_TO_LMO')) {
    exit;  // kein Direktaufruf: diese Datei wird nur ueber LMO eingebunden
}
  
  
if (($file != "") && ($subteams != "")) {
  $subteam = explode('.', $subteams);
  $spiele1 = array_pad($array, $ligaDaten->anzteams+1, "");
  $siege1 = array_pad($array, $ligaDaten->anzteams+1, "");
  $unent1 = array_pad($array, $ligaDaten->anzteams+1, "");
  $nieder1 = array_pad($array, $ligaDaten->anzteams+1, "");
  $punkte1 = array_pad($array, $ligaDaten->anzteams+1, "");
  $negativ1 = array_pad($array, $ligaDaten->anzteams+1, "");
  $etore1 = array_pad($array, $ligaDaten->anzteams+1, "");
  $atore1 = array_pad($array, $ligaDaten->anzteams+1, "");
  $dtore1 = array_pad($array, $ligaDaten->anzteams+1, "");
  $quote1 = array_pad($array, $ligaDaten->anzteams+1, "");
  $mcalc = array_pad($array, 116, "");
  $hoy = 0;
  for ($i = 0; $i < 116; $i++) {
    $mcalc[$i] = array_pad($array, 40, "0");
  }
  $tab1 = array("");
  for ($a = 1; $a <= $ligaDaten->anzteams; $a++) {
    if ($tabtype == 3) {
      $hoy = (int)($ligaDaten->anzst/2);
    }
    if ($tabtype == 4) {
      $endtab = (int)($ligaDaten->anzst/2);
    }
    for ($j = $hoy; $j < $endtab; $j++) {
      for ($i = 0; $i < $ligaDaten->anzsp; $i++) {
        if ($btip[$j][$i] == false) {
          $b = 0;
          for ($c = 0; $c < count($subteam); $c++) {
            if ($subteam[$c] == $ligaDaten->teama[$j][$i]) {
              $b++;
            } elseif ($subteam[$c] == $ligaDaten->teamb[$j][$i]) {
              $b++;
            }
          }
          if (($b == 2) && ($mcalc[$j][$i] < 2) && ($goaltippa[$j][$i] != "_") && ($goaltippb[$j][$i] != "_") && ((($tabtype == 0 or $tabtype == 3 or $tabtype == 4) && (($a == $ligaDaten->teama[$j][$i]) || ($a == $ligaDaten->teamb[$j][$i]))) || (($tabtype == 1) && ($a == $ligaDaten->teama[$j][$i])) || (($tabtype == 2) && ($a == $ligaDaten->teamb[$j][$i])))) {
            $mcalc[$j][$i] = $mcalc[$j][$i]+1;
            $anzcnt++;
            $p0s = $ligaDaten->pns;
            $p0u = $ligaDaten->pnu;
            $p0n = $ligaDaten->pnn;
            $spiele1[$a] = $spiele1[$a]+1;
            if ($a == $ligaDaten->teama[$j][$i]) {
              $etore1[$a] = $etore1[$a]+$goaltippa[$j][$i];
              $atore1[$a] = $atore1[$a]+$goaltippb[$j][$i];
              if ($goaltippa[$j][$i] > $goaltippb[$j][$i]) {
                $siege1[$a] = $siege1[$a]+1;
                $punkte1[$a] = $punkte1[$a]+$p0s;
                if ($ligaDaten->minus == 2) {
                  $negativ1[$a] = $negativ1[$a]+$p0n;
                }
              } elseif ($goaltippa[$j][$i] < $goaltippb[$j][$i]) {
                $nieder1[$a] = $nieder1[$a]+1;
                $punkte1[$a] = $punkte1[$a]+$p0n;
                if ($ligaDaten->minus == 2) {
                  $negativ1[$a] = $negativ1[$a]+$p0s;
                }
              } elseif ($goaltippa[$j][$i] == $goaltippb[$j][$i]) {
                $unent1[$a] = $unent1[$a]+1;
                $punkte1[$a] = $punkte1[$a]+$p0u;
                if ($ligaDaten->minus == 2) {
                  $negativ1[$a] = $negativ1[$a]+$p0u;
                }
              }
            }
            if ($a == $ligaDaten->teamb[$j][$i]) {
              $etore1[$a] = $etore1[$a]+$goaltippb[$j][$i];
              $atore1[$a] = $atore1[$a]+$goaltippa[$j][$i];
              if ($goaltippa[$j][$i] < $goaltippb[$j][$i]) {
                $siege1[$a] = $siege1[$a]+1;
                $punkte1[$a] = $punkte1[$a]+$p0s;
                if ($ligaDaten->minus == 2) {
                  $negativ1[$a] = $negativ1[$a]+$p0n;
                }
              } elseif ($goaltippa[$j][$i] > $goaltippb[$j][$i]) {
                $nieder1[$a] = $nieder1[$a]+1;
                $punkte1[$a] = $punkte1[$a]+$p0n;
                if ($ligaDaten->minus == 2) {
                  $negativ1[$a] = $negativ1[$a]+$p0s;
                }
              } elseif ($goaltippa[$j][$i] == $goaltippb[$j][$i]) {
                $unent1[$a] = $unent1[$a]+1;
                $punkte1[$a] = $punkte1[$a]+$p0u;
                if ($ligaDaten->minus == 2) {
                  $negativ1[$a] = $negativ1[$a]+$p0u;
                }
              }
            }
          }
        }
      }
    }
    $dtore1[$a] = $etore1[$a]-$atore1[$a];
    $quote1[$a] = 0;
    if ($spiele1[$a] != 0) {
      $quote1[$a] = number_format($punkte1[$a]/$spiele1[$a], 2, ".", ",");
    }
    $quote1[$a] *= 100;
    for ($c = 0; $c < count($subteam); $c++) {
      if ($subteam[$c] == $a) {
        if ($ligaDaten->kegel == 0) {
          array_push($tab1, (50000000+$quote1[$a]).(50000000+$punkte1[$a]).(50000000-$negativ1[$a]).(50000000+$dtore1[$a]).(50000000+$etore1[$a]).(50000000+$c).(50000000+$a));
        } else {
          array_push($tab1, (50000000+$quote1[$a]).(50000000+$punkte1[$a]).(50000000-$negativ1[$a]).(50000000+$etore1[$a]).(50000000+$dtore1[$a]).(50000000+$c).(50000000+$a));
        }
      }
    }
  }
  array_shift($tab1);
  sort($tab1, SORT_STRING);
}

?>