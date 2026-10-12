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

/**
 * Diese Datei wird eingebunden und erwartet:
 *
 * @var \Lmo\Liga\Einstellungen $lmo_einstellungen Einstellungen der Liga (lmo-tipptabelle.php)
 * @var int $lmo_tipp_mannschaften Anzahl der Mannschaften
 * @var int $lmo_tipp_spieltage Anzahl der Spieltage
 * @var int $lmo_tipp_partien Partien je Spieltag
 * @var array<int, array<int, \Lmo\Liga\Spiel>> $lmo_tipp_spiele Spiele wie die Tipps: [Spieltag-1][Partie-1]
 * @var string $file Ligadatei relativ zum Ligenordner, leer wenn keine geladen ist
 * @var array<int|string, mixed> $array leeres Array als Vorlage fuer array_pad()
 *
 * Weitere Variablen des einbindenden Codes:
 * @var array<int|string, mixed> $btip
 * @var array<int|string, mixed> $goaltippa
 * @var array<int|string, mixed> $goaltippb
 * @var mixed $subteams
 * @var mixed $tabtype
 *
 * Werden auch in dieser Datei gesetzt, aber nicht auf jedem Weg (koennen von aussen kommen):
 * @var mixed $anzcnt
 * @var mixed $endtab
 */
  
  
if (($file != "") && ($subteams != "")) {
  $subteam = explode('.', $subteams);
  $spiele1 = array_pad($array, $lmo_tipp_mannschaften+1, 0);
  $siege1 = array_pad($array, $lmo_tipp_mannschaften+1, 0);
  $unent1 = array_pad($array, $lmo_tipp_mannschaften+1, 0);
  $nieder1 = array_pad($array, $lmo_tipp_mannschaften+1, 0);
  $punkte1 = array_pad($array, $lmo_tipp_mannschaften+1, 0);
  $negativ1 = array_pad($array, $lmo_tipp_mannschaften+1, 0);
  $etore1 = array_pad($array, $lmo_tipp_mannschaften+1, 0);
  $atore1 = array_pad($array, $lmo_tipp_mannschaften+1, 0);
  $dtore1 = array_pad($array, $lmo_tipp_mannschaften+1, 0);
  $quote1 = array_pad($array, $lmo_tipp_mannschaften+1, 0);
  $mcalc = array_pad($array, 116, "");
  $hoy = 0;
  for ($i = 0; $i < 116; $i++) {
    $mcalc[$i] = array_pad($array, 40, "0");
  }
  $tab1 = array("");
  for ($a = 1; $a <= $lmo_tipp_mannschaften; $a++) {
    if ($tabtype == 3) {
      $hoy = (int)($lmo_tipp_spieltage/2);
    }
    if ($tabtype == 4) {
      $endtab = (int)($lmo_tipp_spieltage/2);
    }
    for ($j = $hoy; $j < $endtab; $j++) {
      for ($i = 0; $i < $lmo_tipp_partien; $i++) {
        if ($btip[$j][$i] == false) {
          $b = 0;
          for ($c = 0; $c < count($subteam); $c++) {
            if ($subteam[$c] == $lmo_tipp_spiele[$j][$i]->heim) {
              $b++;
            } elseif ($subteam[$c] == $lmo_tipp_spiele[$j][$i]->gast) {
              $b++;
            }
          }
          if (($b == 2) && ($mcalc[$j][$i] < 2) && ($goaltippa[$j][$i] != "_") && ($goaltippb[$j][$i] != "_") && ((($tabtype == 0 or $tabtype == 3 or $tabtype == 4) && (($a == $lmo_tipp_spiele[$j][$i]->heim) || ($a == $lmo_tipp_spiele[$j][$i]->gast))) || (($tabtype == 1) && ($a == $lmo_tipp_spiele[$j][$i]->heim)) || (($tabtype == 2) && ($a == $lmo_tipp_spiele[$j][$i]->gast)))) {
            $mcalc[$j][$i] = $mcalc[$j][$i]+1;
            $anzcnt++;
            $p0s = $lmo_einstellungen->punkteFuerSieg();
            $p0u = $lmo_einstellungen->punkteFuerUnentschieden();
            $p0n = $lmo_einstellungen->punkteFuerNiederlage();
            $spiele1[$a] = $spiele1[$a]+1;
            if ($a == $lmo_tipp_spiele[$j][$i]->heim) {
              $etore1[$a] = $etore1[$a]+$goaltippa[$j][$i];
              $atore1[$a] = $atore1[$a]+$goaltippb[$j][$i];
              if ($goaltippa[$j][$i] > $goaltippb[$j][$i]) {
                $siege1[$a] = $siege1[$a]+1;
                $punkte1[$a] = $punkte1[$a]+$p0s;
                if ($lmo_einstellungen->mitMinuspunkten()) {
                  $negativ1[$a] = $negativ1[$a]+$p0n;
                }
              } elseif ($goaltippa[$j][$i] < $goaltippb[$j][$i]) {
                $nieder1[$a] = $nieder1[$a]+1;
                $punkte1[$a] = $punkte1[$a]+$p0n;
                if ($lmo_einstellungen->mitMinuspunkten()) {
                  $negativ1[$a] = $negativ1[$a]+$p0s;
                }
              } elseif ($goaltippa[$j][$i] == $goaltippb[$j][$i]) {
                $unent1[$a] = $unent1[$a]+1;
                $punkte1[$a] = $punkte1[$a]+$p0u;
                if ($lmo_einstellungen->mitMinuspunkten()) {
                  $negativ1[$a] = $negativ1[$a]+$p0u;
                }
              }
            }
            if ($a == $lmo_tipp_spiele[$j][$i]->gast) {
              $etore1[$a] = $etore1[$a]+$goaltippb[$j][$i];
              $atore1[$a] = $atore1[$a]+$goaltippa[$j][$i];
              if ($goaltippa[$j][$i] < $goaltippb[$j][$i]) {
                $siege1[$a] = $siege1[$a]+1;
                $punkte1[$a] = $punkte1[$a]+$p0s;
                if ($lmo_einstellungen->mitMinuspunkten()) {
                  $negativ1[$a] = $negativ1[$a]+$p0n;
                }
              } elseif ($goaltippa[$j][$i] > $goaltippb[$j][$i]) {
                $nieder1[$a] = $nieder1[$a]+1;
                $punkte1[$a] = $punkte1[$a]+$p0n;
                if ($lmo_einstellungen->mitMinuspunkten()) {
                  $negativ1[$a] = $negativ1[$a]+$p0s;
                }
              } elseif ($goaltippa[$j][$i] == $goaltippb[$j][$i]) {
                $unent1[$a] = $unent1[$a]+1;
                $punkte1[$a] = $punkte1[$a]+$p0u;
                if ($lmo_einstellungen->mitMinuspunkten()) {
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
        if (!$lmo_einstellungen->istKegelliga()) {
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