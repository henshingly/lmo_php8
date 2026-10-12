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
 * @var \Lmo\Liga\Rohdaten\Liga $lmo_liga Rohdaten der geladenen Liga (lmo-openfile.php)
 * @var \Lmo\Liga\Einstellungen $lmo_einstellungen Einstellungen der Liga (lmo-tipptabelle.php)
 * @var int $lmo_tipp_mannschaften Anzahl der Mannschaften
 * @var int $lmo_tipp_spieltage Anzahl der Spieltage
 * @var int $lmo_tipp_partien Partien je Spieltag
 * @var array<int, array<int, \Lmo\Liga\Spiel>> $lmo_tipp_spiele Spiele wie die Tipps: [Spieltag-1][Partie-1]
 * @var array<int, array{string, string}> $lmo_tipp_tage erster und letzter Tag je Spieltag (TT.MM.JJJJ), Index Spieltag-1
 * @var string $file Ligadatei relativ zum Ligenordner, leer wenn keine geladen ist
 * @var array<int|string, mixed> $array leeres Array als Vorlage fuer array_pad()
 *
 * Einstellungen:
 * @var int|string $tipp_einsichterst Einstellung aus tipp/cfg.txt
 *
 * Weitere Variablen des einbindenden Codes:
 * @var mixed $anztipper
 * @var array<int|string, mixed> $goaltippa
 * @var array<int|string, mixed> $goaltippb
 * @var mixed $m
 * @var array<int|string, mixed> $tab1
 *
 * Werden auch in dieser Datei gesetzt, aber nicht auf jedem Weg (koennen von aussen kommen):
 * @var array<int|string, mixed> $atore
 * @var array<int|string, mixed> $btip
 * @var mixed $endtab
 * @var array<int|string, mixed> $etore
 * @var array<int|string, mixed> $negativ
 * @var array<int|string, mixed> $nieder
 * @var array<int|string, mixed> $punkte
 * @var array<int|string, mixed> $siege
 * @var array<int|string, mixed> $spiele
 * @var array<int|string, mixed> $tab0
 * @var mixed $tabtype
 * @var array<int|string, mixed> $unent
 */
  
  
if ($file != "") {
  if ($m == 0) {
    if (!isset($tabtype)) {
      $tabtype = 0;
    }
    $spiele = array_pad($array, $lmo_tipp_mannschaften+1, "0");
    $siege = array_pad($array, $lmo_tipp_mannschaften+1, "0");
    $unent = array_pad($array, $lmo_tipp_mannschaften+1, "0");
    $nieder = array_pad($array, $lmo_tipp_mannschaften+1, "0");
    $punkte = array_pad($array, $lmo_tipp_mannschaften+1, "0");
    $negativ = array_pad($array, $lmo_tipp_mannschaften+1, "0");
    $etore = array_pad($array, $lmo_tipp_mannschaften+1, "0");
    $atore = array_pad($array, $lmo_tipp_mannschaften+1, "0");
    $dtore = array_pad($array, $lmo_tipp_mannschaften+1, "0");
    $quote = array_pad($array, $lmo_tipp_mannschaften+1, "0");
    $tab0 = array("");
    $btip = array_pad($array, $lmo_tipp_spieltage+1, "");
    for ($i = 0; $i < $lmo_tipp_spieltage; $i++) {
      $btip[$i] = array_pad(array("false"), $lmo_tipp_partien+1, "false");
    }
  }
  $stt = 0;
  $hoy = 0;
  for ($a = 1; $a <= $lmo_tipp_mannschaften; $a++) {
    if ($tabtype == 3) {
      $hoy = (int)($lmo_tipp_spieltage/2);
    }
    if ($tabtype == 4) {
      $endtab = (int)($lmo_tipp_spieltage/2);
    }
    for ($j = $hoy; $j < $endtab; $j++) {
      for ($i = 0; $i < $lmo_tipp_partien; $i++) {
        if ($m == 0 && $a == 1) {
          // nur beim ersten Tipper berechnen, ob das Spiel in die Tipp-Tabelle einfließen darf
          if ($tipp_einsichterst == 1) {
            $plus = 0;
            $btip[$j][$i] = tippaenderbar((int)$lmo_tipp_spiele[$j][$i]->anstoss, $lmo_tipp_tage[$j][0], $lmo_tipp_tage[$j][1]);
          }
          elseif ($tipp_einsichterst == 2) {
            if ($lmo_tipp_spiele[$j][$i]->istGespielt()) {
              $btip[$j][$i] = false;
            } else {
              $btip[$j][$i] = true;
            }
          } else {
            // Tipps immer anzeigen
            $btip[$j][$i] = false;
          }
          if ($lmo_tipp_spiele[$j][$i]->ohneTippwertung) {
            // nicht in der Wertung
            $btip[$j][$i] = true;
          }
        }
        if ($btip[$j][$i] == false) {
          if ($tabtype == 3) {
            $hoy = (int)($lmo_tipp_spieltage/2);
          }
          if ($tabtype == 4) {
            $endtab = (int)($lmo_tipp_spieltage/2);
          }
          if (($goaltippa[$j][$i] != "_") && ($goaltippb[$j][$i] != "_") && ((($tabtype == 0 or $tabtype == 3 or $tabtype == 4) && (($a == $lmo_tipp_spiele[$j][$i]->heim) || ($a == $lmo_tipp_spiele[$j][$i]->gast))) || (($tabtype == 1) && ($a == $lmo_tipp_spiele[$j][$i]->heim)) || (($tabtype == 2) && ($a == $lmo_tipp_spiele[$j][$i]->gast)))) {
            if ($stt < $j+1) {
              $stt = $j+1;
            }
            $p0s = $lmo_einstellungen->punkteFuerSieg();
            $p0u = $lmo_einstellungen->punkteFuerUnentschieden();
            $p0n = $lmo_einstellungen->punkteFuerNiederlage();
            $spiele[$a] = $spiele[$a]+1;
            if ($a == $lmo_tipp_spiele[$j][$i]->heim) {
              $etore[$a] = $etore[$a]+$goaltippa[$j][$i];
              $atore[$a] = $atore[$a]+$goaltippb[$j][$i];
              if ($goaltippa[$j][$i] > $goaltippb[$j][$i]) {
                $siege[$a] = $siege[$a]+1;
                $punkte[$a] = $punkte[$a]+$p0s;
                if ($lmo_einstellungen->mitMinuspunkten()) {
                  $negativ[$a] = $negativ[$a]+$p0n;
                }
              } elseif ($goaltippa[$j][$i] < $goaltippb[$j][$i]) {
                $nieder[$a] = $nieder[$a]+1;
                $punkte[$a] = $punkte[$a]+$p0n;
                if ($lmo_einstellungen->mitMinuspunkten()) {
                  $negativ[$a] = $negativ[$a]+$p0s;
                }
              } elseif ($goaltippa[$j][$i] == $goaltippb[$j][$i]) {
                $unent[$a] = $unent[$a]+1;
                $punkte[$a] = $punkte[$a]+$p0u;
                if ($lmo_einstellungen->mitMinuspunkten()) {
                  $negativ[$a] = $negativ[$a]+$p0u;
                }
              }
            }
            if ($a == $lmo_tipp_spiele[$j][$i]->gast) {
              $etore[$a] = $etore[$a]+$goaltippb[$j][$i];
              $atore[$a] = $atore[$a]+$goaltippa[$j][$i];
              if ($goaltippa[$j][$i] < $goaltippb[$j][$i]) {
                $siege[$a] = $siege[$a]+1;
                $punkte[$a] = $punkte[$a]+$p0s;
                if ($lmo_einstellungen->mitMinuspunkten()) {
                  $negativ[$a] = $negativ[$a]+$p0n;
                }
              }
              elseif ($goaltippa[$j][$i] > $goaltippb[$j][$i]) {
                $nieder[$a] = $nieder[$a]+1;
                $punkte[$a] = $punkte[$a]+$p0n;
                if ($lmo_einstellungen->mitMinuspunkten()) {
                  $negativ[$a] = $negativ[$a]+$p0s;
                }
              }
              elseif ($goaltippa[$j][$i] == $goaltippb[$j][$i]) {
                $unent[$a] = $unent[$a]+1;
                $punkte[$a] = $punkte[$a]+$p0u;
                if ($lmo_einstellungen->mitMinuspunkten()) {
                  $negativ[$a] = $negativ[$a]+$p0u;
                }
              }
            }
          }
          // ende if (($goaltippa[$j][$i]!="_") && ($goaltippb[$j][$i]!="_") &&
        }
        // ende if ($btip[$j][$i]==false)
      }
      // ende for ($i=0;$i<$anzsp;$i++)
    }
    // ende for ($j=$hoy;$j<$endtab;$j++)
    if (($tabtype == 0 or $tabtype == 3 or $tabtype == 4) && $m==0) {
      $punkte[$a] = $punkte[$a]-(int)($lmo_liga->mannschaften[$a]->werte['SP'] ?? 0);
      if ($lmo_einstellungen->mitMinuspunkten()) {
        $negativ[$a] = $negativ[$a]-(int)($lmo_liga->mannschaften[$a]->werte['SM'] ?? 0);
      }
    }
    if ($m == ($anztipper-1)) {
      $dtore[$a] = $etore[$a]-$atore[$a];
      $quote[$a] = 0;
      if ($spiele[$a] != 0) {
        $quote[$a] = number_format($punkte[$a]/$spiele[$a], 2, ".", ",");
      }
      $quote[$a] *= 100;
      if (!$lmo_einstellungen->istKegelliga()) {
        array_push($tab0, (50000000+$quote[$a]).(50000000+$punkte[$a]).(50000000-$negativ[$a]).(50000000+$dtore[$a]).(50000000+$etore[$a]).(50000000+$a));
      } else {
        array_push($tab0, (50000000+$quote[$a]).(50000000+$punkte[$a]).(50000000-$negativ[$a]).(50000000+$etore[$a]).(50000000+$dtore[$a]).(50000000+$a));
      }
    }
  }
  // ende for ($a=1;$a<=$anzteams;$a++)
  if ($m == ($anztipper-1)) {
    array_shift($tab0);
    rsort($tab0, SORT_STRING);
    if ($lmo_einstellungen->mitDirektemVergleich()) {
      $cba = 1;
      for ($abc = 1; $abc < $lmo_tipp_mannschaften; $abc++) {
        $x1 = substr($tab0[$abc-1], 7, 9);
        $x2 = substr($tab0[$abc], 7, 9);
        if ($x1 == $x2) {
          $cba++;
        }
        if (($x1 != $x2) || (($abc == $lmo_tipp_mannschaften-1) && ($x1 == $x2))) {
          if ($cba > 1) {
            $subteams = "";
            for ($b = 1; $b <= $cba; $b++) {
              if ($b > 1) {
                $subteams = $subteams.".";
              }
              if (($abc == $lmo_tipp_mannschaften-1) && ($x1 == $x2)) {
                $subteams = $subteams.intval(substr($tab0[$abc-$b+1], -7));
              } else {
                $subteams = $subteams.intval(substr($tab0[$abc-$b], -7));
              }
            }
            $anzcnt = 0;
            require(PATH_TO_ADDONDIR."/tipp/lmo-tippcalctable1.php");
            if ($anzcnt > 0) {
              for ($b = 1; $b <= count($tab1); $b++) {
                for ($f = 0; $f < count($tab0); $f++) {
                  if (intval(substr($tab0[$f], -7)) == intval(substr($tab1[$b-1], -7))) {
                    $tab0[$f] = substr($tab0[$f], 0, 17-strlen($b)).$b.substr($tab0[$f], 17);
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
    // ende if ($direkt==1)
  }
  // ende if ($m==($anztipper-1))
}
// ende if ($file!="")

?>