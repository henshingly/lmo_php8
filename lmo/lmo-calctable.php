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
 * @var \Lmo\Liga\LigaDaten $ligaDaten Daten der geladenen Liga (lmo-ligadaten.php)
 * @var array<int|string, mixed> $text Sprachtexte
 * @var string $file Ligadatei relativ zum Ligenordner, leer wenn keine geladen ist
 * @var string $action gewaehlte Seite (Aufrufparameter)
 * @var array<int|string, mixed> $array leeres Array als Vorlage fuer array_pad()
 *
 * Weitere Variablen des einbindenden Codes:
 * @var array<int|string, mixed> $tab1
 *
 * Werden auch in dieser Datei gesetzt, aber nicht auf jedem Weg (koennen von aussen kommen):
 * @var mixed $endtab
 */


if ($file != "") {
  if (!isset($tabtype)) {
    $tabtype = 0;
  }
  if (!isset($newtabtype)) {
    $newtabtype = 0;
  }
  $spiele = array_pad($array, $ligaDaten->anzteams+1, "0");
  $siege = array_pad($array, $ligaDaten->anzteams+1, "0");
  $unent = array_pad($array, $ligaDaten->anzteams+1, "0");
  $nieder = array_pad($array, $ligaDaten->anzteams+1, "0");
  $punkte = array_pad($array, $ligaDaten->anzteams+1, "0");
  $negativ = array_pad($array, $ligaDaten->anzteams+1, "0");
  $etore = array_pad($array, $ligaDaten->anzteams+1, "0");
  $atore = array_pad($array, $ligaDaten->anzteams+1, "0");
  $dtore = array_pad($array, $ligaDaten->anzteams+1, "0");
  $maxs0 = array_pad($array, $ligaDaten->anzteams+1, "&nbsp;");
  $maxs1 = array_pad($array, $ligaDaten->anzteams+1, "0");
  $maxs2 = array_pad($array, $ligaDaten->anzteams+1, "0");
  $maxn0 = array_pad($array, $ligaDaten->anzteams+1, "&nbsp;");
  $maxn1 = array_pad($array, $ligaDaten->anzteams+1, "0");
  $maxn2 = array_pad($array, $ligaDaten->anzteams+1, "0");
  $ser1 = array_pad($array, $ligaDaten->anzteams+1, "0");
  $ser2 = array_pad($array, $ligaDaten->anzteams+1, "0");
  $ser3 = array_pad($array, $ligaDaten->anzteams+1, "0");
  $ser4 = array_pad($array, $ligaDaten->anzteams+1, "0");

  // letzter Spieltag mit einem Ergebnis: Strafen "ab Spieltag X" zaehlen erst, wenn X erreicht ist
  // (die Standardtabelle rechnet bis $endtab = $anzst, auch wenn die Saison noch nicht so weit ist)
  $calc_lastst = 0;
  for ($j = 0; $j < $ligaDaten->anzst; $j++) {
    for ($i = 0; $i < $ligaDaten->anzsp; $i++) {
      if ($ligaDaten->goala[$j][$i] != "_" && $ligaDaten->goalb[$j][$i] != "_") {
        $calc_lastst = $j+1;
        break;
      }
    }
  }

  $tab0 = array();
  $stt = 0;
  $hoy = 0;
  for ($a = 1; $a <= $ligaDaten->anzteams; $a++) {
    if ($tabtype == 3 || $newtabtype == 3) {
      $hoy = (int)($ligaDaten->anzst/2);
    }
    if ($tabtype == 4 || $newtabtype == 4) {
      $endtab = (int)($ligaDaten->anzst/2);
    }
    for ($j = $hoy; $j < $endtab; $j++) {
      for ($i = 0; $i < $ligaDaten->anzsp; $i++) {
        if ($tabtype == 3 || $newtabtype == 3) {
          $hoy = (int)($ligaDaten->anzst/2);
        }
        if ($tabtype == 4 || $newtabtype == 4) {
          $endtab = (int)($ligaDaten->anzst/2);
        }
        if (($ligaDaten->goala[$j][$i] != "_") && ($ligaDaten->goalb[$j][$i] != "_") && ((($tabtype == 0 or $tabtype == 3 or $tabtype == 4) && (($a == $ligaDaten->teama[$j][$i]) || ($a == $ligaDaten->teamb[$j][$i]))) || (($tabtype == 1) && ($a == $ligaDaten->teama[$j][$i])) || (($tabtype == 2) && ($a == $ligaDaten->teamb[$j][$i])))) {
          if ($stt < $j+1) {
            $stt = $j+1;
          }
          $p0s = $ligaDaten->pns;
          $p0u = $ligaDaten->pnu;
          $p0n = $ligaDaten->pnn;
          if ($ligaDaten->spez == 1) {
            if ($ligaDaten->mspez[$j][$i] == $text[0]) {
              $p0s = $ligaDaten->pxs;
              $p0u = $ligaDaten->pxu;
              $p0n = $ligaDaten->pxn;
            }
            if ($ligaDaten->mspez[$j][$i] == $text[1]) {
              $p0s = $ligaDaten->pps;
              $p0u = $ligaDaten->ppu;
              $p0n = $ligaDaten->ppn;
            }
          }
          $spiele[$a]++;
          if (($a == $ligaDaten->teama[$j][$i]) || (($a == $ligaDaten->teamb[$j][$i]) && ($ligaDaten->msieg[$j][$i] == 3))) {
            $etore[$a] = $etore[$a]+$ligaDaten->goala[$j][$i];
            $atore[$a] = $atore[$a]+$ligaDaten->goalb[$j][$i];
            if ($ligaDaten->msieg[$j][$i] == 1) {
              $siege[$a] = $siege[$a]+1;
              $punkte[$a] = $punkte[$a]+$p0s;
              if ($ligaDaten->minus == 2) {
                $negativ[$a] = $negativ[$a]+$p0n;
              }
              $ser1[$a]++;
              $ser2[$a]++;
              $ser3[$a] = 0;
              $ser4[$a] = 0;
              if (($ligaDaten->goala[$j][$i]-$ligaDaten->goalb[$j][$i]) > ($maxs1[$a]-$maxs2[$a]) || ((($ligaDaten->goala[$j][$i]-$ligaDaten->goalb[$j][$i]) == ($maxs1[$a]-$maxs2[$a])) && ($ligaDaten->goala[$j][$i] > $maxs1[$a]))) {
                $maxs1[$a] = $ligaDaten->goala[$j][$i];
                $maxs2[$a] = $ligaDaten->goalb[$j][$i];
                $maxs0[$a] = applyFactor($ligaDaten->goala[$j][$i], $ligaDaten->goalfaktor).":".applyFactor($ligaDaten->goalb[$j][$i], $ligaDaten->goalfaktor)." ".$text[72]." ".$ligaDaten->teams[$ligaDaten->teamb[$j][$i]]." ".$text[73];
              } elseif ((($ligaDaten->goala[$j][$i]-$ligaDaten->goalb[$j][$i]) == ($maxs1[$a]-$maxs2[$a])) && ($ligaDaten->goala[$j][$i] == $maxs1[$a])) {
                $maxs0[$a] = $maxs0[$a]."<br>".applyFactor($ligaDaten->goala[$j][$i], $ligaDaten->goalfaktor).":".applyFactor($ligaDaten->goalb[$j][$i], $ligaDaten->goalfaktor)." ".$text[72]." ".$ligaDaten->teams[$ligaDaten->teamb[$j][$i]]." ".$text[73];
              }
            } elseif ($ligaDaten->msieg[$j][$i] == 2) {
              $nieder[$a] = $nieder[$a]+1;
              $punkte[$a] = $punkte[$a]+$p0n;
              if ($ligaDaten->minus == 2) {
                $negativ[$a] = $negativ[$a]+$p0s;
              }
              $ser3[$a]++;
              $ser4[$a]++;
              $ser1[$a] = 0;
              $ser2[$a] = 0;
              if (($ligaDaten->goala[$j][$i]-$ligaDaten->goalb[$j][$i]) < ($maxn1[$a]-$maxn2[$a]) || ((($ligaDaten->goala[$j][$i]-$ligaDaten->goalb[$j][$i]) == ($maxn1[$a]-$maxn2[$a])) && ($ligaDaten->goala[$j][$i] < $maxn1[$a]))) {
                $maxn1[$a] = $ligaDaten->goala[$j][$i];
                $maxn2[$a] = $ligaDaten->goalb[$j][$i];
                $maxn0[$a] = applyFactor($ligaDaten->goala[$j][$i], $ligaDaten->goalfaktor).":".applyFactor($ligaDaten->goalb[$j][$i], $ligaDaten->goalfaktor)." ".$text[72]." ".$ligaDaten->teams[$ligaDaten->teamb[$j][$i]]." ".$text[73];
              } elseif ((($ligaDaten->goala[$j][$i]-$ligaDaten->goalb[$j][$i]) == ($maxn1[$a]-$maxn2[$a])) && ($ligaDaten->goala[$j][$i] == $maxn1[$a])) {
                $maxn0[$a] = $maxn0[$a]."<br>".applyFactor($ligaDaten->goala[$j][$i], $ligaDaten->goalfaktor).":".applyFactor($ligaDaten->goalb[$j][$i], $ligaDaten->goalfaktor)." ".$text[72]." ".$ligaDaten->teams[$ligaDaten->teamb[$j][$i]]." ".$text[73];
              }
            } elseif ($ligaDaten->msieg[$j][$i] == 0 || $ligaDaten->msieg[$j][$i] == 3) {
              // 3 = beidseitiges Ergebnis: gilt fuer beide Teams aus Sicht der Heimmannschaft
              if ($ligaDaten->goala[$j][$i] > $ligaDaten->goalb[$j][$i]) {
                $siege[$a] = $siege[$a]+1;
                $punkte[$a] = $punkte[$a]+$p0s;
                if ($ligaDaten->minus == 2) {
                  $negativ[$a] = $negativ[$a]+$p0n;
                }
                $ser1[$a]++;
                $ser2[$a]++;
                $ser3[$a] = 0;
                $ser4[$a] = 0;
                if (($ligaDaten->goala[$j][$i]-$ligaDaten->goalb[$j][$i]) > ($maxs1[$a]-$maxs2[$a]) || ((($ligaDaten->goala[$j][$i]-$ligaDaten->goalb[$j][$i]) == ($maxs1[$a]-$maxs2[$a])) && ($ligaDaten->goala[$j][$i] > $maxs1[$a]))) {
                  $maxs1[$a] = $ligaDaten->goala[$j][$i];
                  $maxs2[$a] = $ligaDaten->goalb[$j][$i];
                  $maxs0[$a] = applyFactor($ligaDaten->goala[$j][$i], $ligaDaten->goalfaktor).":".applyFactor($ligaDaten->goalb[$j][$i], $ligaDaten->goalfaktor)." ".$text[72]." ".$ligaDaten->teams[$ligaDaten->teamb[$j][$i]]." ".$text[73];
                } elseif ((($ligaDaten->goala[$j][$i]-$ligaDaten->goalb[$j][$i]) == ($maxs1[$a]-$maxs2[$a])) && ($ligaDaten->goala[$j][$i] == $maxs1[$a])) {
                  $maxs0[$a] = $maxs0[$a]."<br>".applyFactor($ligaDaten->goala[$j][$i], $ligaDaten->goalfaktor).":".applyFactor($ligaDaten->goalb[$j][$i], $ligaDaten->goalfaktor)." ".$text[72]." ".$ligaDaten->teams[$ligaDaten->teamb[$j][$i]]." ".$text[73];
                }
              } elseif ($ligaDaten->goala[$j][$i] < $ligaDaten->goalb[$j][$i]) {
                $nieder[$a] = $nieder[$a]+1;
                $punkte[$a] = $punkte[$a]+$p0n;
                if ($ligaDaten->minus == 2) {
                  $negativ[$a] = $negativ[$a]+$p0s;
                }
                $ser3[$a]++;
                $ser4[$a]++;
                $ser1[$a] = 0;
                $ser2[$a] = 0;
                if (($ligaDaten->goala[$j][$i]-$ligaDaten->goalb[$j][$i]) < ($maxn1[$a]-$maxn2[$a]) || ((($ligaDaten->goala[$j][$i]-$ligaDaten->goalb[$j][$i]) == ($maxn1[$a]-$maxn2[$a])) && ($ligaDaten->goala[$j][$i] < $maxn1[$a]))) {
                  $maxn1[$a] = $ligaDaten->goala[$j][$i];
                  $maxn2[$a] = $ligaDaten->goalb[$j][$i];
                  $maxn0[$a] = applyFactor($ligaDaten->goala[$j][$i], $ligaDaten->goalfaktor).":".applyFactor($ligaDaten->goalb[$j][$i], $ligaDaten->goalfaktor)." ".$text[72]." ".$ligaDaten->teams[$ligaDaten->teamb[$j][$i]]." ".$text[73];
                } elseif ((($ligaDaten->goala[$j][$i]-$ligaDaten->goalb[$j][$i]) == ($maxn1[$a]-$maxn2[$a])) && ($ligaDaten->goala[$j][$i] == $maxn1[$a])) {
                  $maxn0[$a] = $maxn0[$a]."<br>".applyFactor($ligaDaten->goala[$j][$i], $ligaDaten->goalfaktor).":".applyFactor($ligaDaten->goalb[$j][$i], $ligaDaten->goalfaktor)." ".$text[72]." ".$ligaDaten->teams[$ligaDaten->teamb[$j][$i]]." ".$text[73];
                }
              } elseif ($ligaDaten->goala[$j][$i] == $ligaDaten->goalb[$j][$i]) {
                $unent[$a] = $unent[$a]+1;
                $punkte[$a] = $punkte[$a]+$p0u;
                if ($ligaDaten->minus == 2) {
                  $negativ[$a] = $negativ[$a]+$p0u;
                }
                $ser1[$a] = 0;
                $ser2[$a]++;
                $ser3[$a] = 0;
                $ser4[$a]++;
              }
            }
          }
          if (($a == $ligaDaten->teamb[$j][$i]) && ($ligaDaten->msieg[$j][$i] != 3)) {
            $etore[$a] = $etore[$a]+$ligaDaten->goalb[$j][$i];
            $atore[$a] = $atore[$a]+$ligaDaten->goala[$j][$i];
            if ($ligaDaten->msieg[$j][$i] == 2) {
              $siege[$a] = $siege[$a]+1;
              $punkte[$a] = $punkte[$a]+$p0s;
              if ($ligaDaten->minus == 2) {
                $negativ[$a] = $negativ[$a]+$p0n;
              }
              $ser1[$a]++;
              $ser2[$a]++;
              $ser3[$a] = 0;
              $ser4[$a] = 0;
              if (($ligaDaten->goalb[$j][$i]-$ligaDaten->goala[$j][$i]) > ($maxs1[$a]-$maxs2[$a]) || ((($ligaDaten->goalb[$j][$i]-$ligaDaten->goala[$j][$i]) == ($maxs1[$a]-$maxs2[$a])) && ($ligaDaten->goalb[$j][$i] > $maxs1[$a]))) {
                $maxs1[$a] = $ligaDaten->goalb[$j][$i];
                $maxs2[$a] = $ligaDaten->goala[$j][$i];
                $maxs0[$a] = applyFactor($ligaDaten->goalb[$j][$i], $ligaDaten->goalfaktor).":".applyFactor($ligaDaten->goala[$j][$i], $ligaDaten->goalfaktor)." ".$text[72]." ".$ligaDaten->teams[$ligaDaten->teama[$j][$i]]." ".$text[74];
              } elseif ((($ligaDaten->goalb[$j][$i]-$ligaDaten->goala[$j][$i]) == ($maxs1[$a]-$maxs2[$a])) && ($ligaDaten->goalb[$j][$i] == $maxs1[$a])) {
                $maxs0[$a] = $maxs0[$a]."<br>".applyFactor($ligaDaten->goalb[$j][$i], $ligaDaten->goalfaktor).":".applyFactor($ligaDaten->goala[$j][$i], $ligaDaten->goalfaktor)." ".$text[72]." ".$ligaDaten->teams[$ligaDaten->teama[$j][$i]]." ".$text[74];
              }
            } elseif ($ligaDaten->msieg[$j][$i] == 1) {
              $nieder[$a] = $nieder[$a]+1;
              $punkte[$a] = $punkte[$a]+$p0n;
              if ($ligaDaten->minus == 2) {
                $negativ[$a] = $negativ[$a]+$p0s;
              }
              $ser3[$a]++;
              $ser4[$a]++;
              $ser1[$a] = 0;
              $ser2[$a] = 0;
              if (($ligaDaten->goalb[$j][$i]-$ligaDaten->goala[$j][$i]) < ($maxn1[$a]-$maxn2[$a]) || ((($ligaDaten->goalb[$j][$i]-$ligaDaten->goala[$j][$i]) == ($maxn1[$a]-$maxn2[$a])) && ($ligaDaten->goalb[$j][$i] < $maxn1[$a]))) {
                $maxn1[$a] = $ligaDaten->goalb[$j][$i];
                $maxn2[$a] = $ligaDaten->goala[$j][$i];
                $maxn0[$a] = applyFactor($ligaDaten->goalb[$j][$i], $ligaDaten->goalfaktor).":".applyFactor($ligaDaten->goala[$j][$i], $ligaDaten->goalfaktor)." ".$text[72]." ".$ligaDaten->teams[$ligaDaten->teama[$j][$i]]." ".$text[74];
              } elseif ((($ligaDaten->goalb[$j][$i]-$ligaDaten->goala[$j][$i]) == ($maxn1[$a]-$maxn2[$a])) && ($ligaDaten->goalb[$j][$i] == $maxn1[$a])) {
                $maxn0[$a] = $maxn0[$a]."<br>".applyFactor($ligaDaten->goalb[$j][$i], $ligaDaten->goalfaktor).":".applyFactor($ligaDaten->goala[$j][$i], $ligaDaten->goalfaktor)." ".$text[72]." ".$ligaDaten->teams[$ligaDaten->teama[$j][$i]]." ".$text[74];
              }
            } elseif ($ligaDaten->msieg[$j][$i] == 0) {
              if ($ligaDaten->goala[$j][$i] < $ligaDaten->goalb[$j][$i]) {
                $siege[$a] = $siege[$a]+1;
                $punkte[$a] = $punkte[$a]+$p0s;
                if ($ligaDaten->minus == 2) {
                  $negativ[$a] = $negativ[$a]+$p0n;
                }
                $ser1[$a]++;
                $ser2[$a]++;
                $ser3[$a] = 0;
                $ser4[$a] = 0;
                if (($ligaDaten->goalb[$j][$i]-$ligaDaten->goala[$j][$i]) > ($maxs1[$a]-$maxs2[$a]) || ((($ligaDaten->goalb[$j][$i]-$ligaDaten->goala[$j][$i]) == ($maxs1[$a]-$maxs2[$a])) && ($ligaDaten->goalb[$j][$i] > $maxs1[$a]))) {
                  $maxs1[$a] = $ligaDaten->goalb[$j][$i];
                  $maxs2[$a] = $ligaDaten->goala[$j][$i];
                  $maxs0[$a] = applyFactor($ligaDaten->goalb[$j][$i], $ligaDaten->goalfaktor).":".applyFactor($ligaDaten->goala[$j][$i], $ligaDaten->goalfaktor)." ".$text[72]." ".$ligaDaten->teams[$ligaDaten->teama[$j][$i]]." ".$text[74];
                } elseif ((($ligaDaten->goalb[$j][$i]-$ligaDaten->goala[$j][$i]) == ($maxs1[$a]-$maxs2[$a])) && ($ligaDaten->goalb[$j][$i] == $maxs1[$a])) {
                  $maxs0[$a] = $maxs0[$a]."<br>".applyFactor($ligaDaten->goalb[$j][$i], $ligaDaten->goalfaktor).":".applyFactor($ligaDaten->goala[$j][$i], $ligaDaten->goalfaktor)." ".$text[72]." ".$ligaDaten->teams[$ligaDaten->teama[$j][$i]]." ".$text[74];
                }
              } elseif ($ligaDaten->goala[$j][$i] > $ligaDaten->goalb[$j][$i]) {
                $nieder[$a] = $nieder[$a]+1;
                $punkte[$a] = $punkte[$a]+$p0n;
                if ($ligaDaten->minus == 2) {
                  $negativ[$a] = $negativ[$a]+$p0s;
                }
                $ser3[$a]++;
                $ser4[$a]++;
                $ser1[$a] = 0;
                $ser2[$a] = 0;
                if (($ligaDaten->goalb[$j][$i]-$ligaDaten->goala[$j][$i]) < ($maxn1[$a]-$maxn2[$a]) || ((($ligaDaten->goalb[$j][$i]-$ligaDaten->goala[$j][$i]) == ($maxn1[$a]-$maxn2[$a])) && ($ligaDaten->goalb[$j][$i] < $maxn1[$a]))) {
                  $maxn1[$a] = $ligaDaten->goalb[$j][$i];
                  $maxn2[$a] = $ligaDaten->goala[$j][$i];
                  $maxn0[$a] = applyFactor($ligaDaten->goalb[$j][$i], $ligaDaten->goalfaktor).":".applyFactor($ligaDaten->goala[$j][$i], $ligaDaten->goalfaktor)." ".$text[72]." ".$ligaDaten->teams[$ligaDaten->teama[$j][$i]]." ".$text[74];
                } elseif ((($ligaDaten->goalb[$j][$i]-$ligaDaten->goala[$j][$i]) == ($maxn1[$a]-$maxn2[$a])) && ($ligaDaten->goalb[$j][$i] == $maxn1[$a])) {
                  $maxn0[$a] = $maxn0[$a]."<br>".applyFactor($ligaDaten->goalb[$j][$i], $ligaDaten->goalfaktor).":".applyFactor($ligaDaten->goala[$j][$i], $ligaDaten->goalfaktor)." ".$text[72]." ".$ligaDaten->teams[$ligaDaten->teama[$j][$i]]." ".$text[74];
                }
              } elseif ($ligaDaten->goala[$j][$i] == $ligaDaten->goalb[$j][$i]) {
                $unent[$a] = $unent[$a]+1;
                $punkte[$a] = $punkte[$a]+$p0u;
                if ($ligaDaten->minus == 2) {
                  $negativ[$a] = $negativ[$a]+$p0u;
                }
                $ser1[$a] = 0;
                $ser2[$a]++;
                $ser3[$a] = 0;
                $ser4[$a]++;
              }
            }
          }
        }
      }
    }
    if (min($endtab, $calc_lastst) >= $ligaDaten->strafdat[$a] && ($tabtype == 0 or ($tabtype == 3 && $ligaDaten->strafdat[$a] > ($hoy = (int)($ligaDaten->anzst/2))) or ($tabtype == 4 && $ligaDaten->strafdat[$a] <= ($endtab = (int)($ligaDaten->anzst/2))))) {
                                                  // Hack-Straftore
      $etore[$a] = $etore[$a]-$ligaDaten->torkorrektur1[$a]; // Hack-Straftore
      $atore[$a] = $atore[$a]-$ligaDaten->torkorrektur2[$a]; // Hack-Straftore
    }
    $dtore[$a] = $etore[$a]-$atore[$a];
    if (min($endtab, $calc_lastst) >= $ligaDaten->strafdat[$a] && ($tabtype == 0 or ($tabtype == 3 && $ligaDaten->strafdat[$a] > ($hoy = (int)($ligaDaten->anzst/2))) or ($tabtype == 4 && $ligaDaten->strafdat[$a] <= ($endtab = (int)($ligaDaten->anzst/2))))) {
                                                  // Hack-Straftore
      $punkte[$a] = $punkte[$a]-$ligaDaten->strafp[$a];
      if ($ligaDaten->minus == 2) {
        $negativ[$a] = $negativ[$a]-$ligaDaten->strafm[$a];
      }
    }                                             // Hack-Straftore
    if ($ligaDaten->kegel == 0) {
      array_push($tab0, (50000000+$punkte[$a]).(50000000-$negativ[$a]).(50000000+$dtore[$a]).(50000000+$etore[$a]).(50000000+$a));
    } else {
      array_push($tab0, (50000000+$punkte[$a]).(50000000-$negativ[$a]).(50000000+$etore[$a]).(50000000+$dtore[$a]).(50000000+$a));
    }
  }
  rsort($tab0, SORT_STRING);
  if ($ligaDaten->direkt == 1) {
    $cba = 1;
    for ($abc = 1; $abc < $ligaDaten->anzteams; $abc++) {
      // Gleichstand = gleicher Punkte- und Minuspunkteblock (je 8 Stellen). Vorher substr(..., 7, 9):
      // nur die letzte Ziffer der Punkte, 59 und 49 Punkte galten als gleich.
      $x1 = substr($tab0[$abc-1], 0, 16);
      $x2 = substr($tab0[$abc], 0, 16);
      if ($x1 == $x2) {
        $cba++;
      }
      if (($x1 != $x2) || (($abc == $ligaDaten->anzteams-1) && ($x1 == $x2))) {
        if ($cba > 1) {
          $subteams = "";
          for ($b = 1; $b <= $cba; $b++) {
            if ($b > 1) {
              $subteams = $subteams.".";
            }
            if (($abc == $ligaDaten->anzteams-1) && ($x1 == $x2)) {
              $subteams = $subteams.intval(substr($tab0[$abc-$b+1], -7));
            } else {
              $subteams = $subteams.intval(substr($tab0[$abc-$b], -7));
            }
          }
          $anzcnt = 0;
          require(PATH_TO_LMO."/lmo-calctable1.php");
          if ($anzcnt > 0) {
            for ($b = 1; $b <= count($tab1); $b++) {
              for ($f = 0; $f < count($tab0); $f++) {
                if (intval(substr($tab0[$f], -7)) == intval(substr($tab1[$b-1], -7))) {
                  // Rang als genau ein Zeichen an Stelle 16 (erste Ziffer der Tordifferenz). Ab Rang 10
                  // folgen die Zeichen hinter "9" (":", ";", ...), die als String richtig dahinter sortieren.
                  // Vorher ueberschrieb ein zweistelliger Rang die letzte Ziffer der Minuspunkte.
                  $tab0[$f] = substr($tab0[$f], 0, 16).chr(ord('0') + $b).substr($tab0[$f], 17);
                }
              }
            }
          }
        }
        $cba = 1;
      }
    }
    rsort($tab0, SORT_STRING);
  }
  if ($action == "admin") {
    $tab2 = $tab0;
  }
  if ($ligaDaten->hands == 1 && $tabtype==0) {
    if (empty($tabdat) || $action == "admin") {
      $handb = $ligaDaten->stx-1;
    } else {
      $handb = $endtab-1;
    }
    if ($ligaDaten->handp[$handb] != 0) {
      for ($ih = 0; $ih < $ligaDaten->anzteams; $ih++) {
        $handd = intval(substr($ligaDaten->handp[$handb], $ih * 2, 2));
        if ($handd < 10) {
          $handd = "0".$handd;
        }
        $tab0[$ih] = $handd.substr($tab0[$ih], 2);
      }
      sort($tab0, SORT_STRING);

    }
  }
  //print_r($tab0);
}
?>