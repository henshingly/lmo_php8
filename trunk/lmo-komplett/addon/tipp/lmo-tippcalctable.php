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
  if ($m == 0) {
    if (!isset($tabtype)) {
      $tabtype = 0;
    }
    $spiele = array_pad($array, $anzteams+1, "0");
    $siege = array_pad($array, $anzteams+1, "0");
    $unent = array_pad($array, $anzteams+1, "0");
    $nieder = array_pad($array, $anzteams+1, "0");
    $punkte = array_pad($array, $anzteams+1, "0");
    $negativ = array_pad($array, $anzteams+1, "0");
    $etore = array_pad($array, $anzteams+1, "0");
    $atore = array_pad($array, $anzteams+1, "0");
    $dtore = array_pad($array, $anzteams+1, "0");
    $quote = array_pad($array, $anzteams+1, "0");
    $tab0 = array("");
    $btip = array_pad($array, $anzst+1, "");
    for ($i = 0; $i < $anzst; $i++) {
      $btip[$i] = array_pad(array("false"), $anzsp+1, "false");
    }
  }
  $stt = 0;
  $hoy = 0;
  for ($a = 1; $a <= $anzteams; $a++) {
    if ($tabtype == 3) {
      $hoy = ($anzst/2);
    }
    if ($tabtype == 4) {
      $endtab = ($anzst/2);
    }
    for ($j = $hoy; $j < $endtab; $j++) {
      for ($i = 0; $i < $anzsp; $i++) {
        if ($m == 0 && $a == 1) {
          // nur beim ersten Tipper berechnen, ob das Spiel in die Tipp-Tabelle einfließen darf
          if ($tipp_einsichterst == 1) {
            $plus = 0;
            $btip[$j][$i] = tippaenderbar($mterm[$j][$i], $datum1[$j], $datum2[$j]);
          }
          else if ($tipp_einsichterst == 2) {
            if ($goala[$j][$i] != "_" && $goalb[$j][$i] != "_") {
              $btip[$j][$i] = false;
            } else {
              $btip[$j][$i] = true;
            }
          } else {
            // Tipps immer anzeigen
            $btip[$j][$i] = false;
          }
          if ($mtipp[$j][$i] == 1) {
            // nicht in der Wertung
            $btip[$j][$i] = true;
          }
        }
        if ($btip[$j][$i] == false) {
          if ($tabtype == 3) {
            $hoy = ($anzst/2);
          }
          if ($tabtype == 4) {
            $endtab = ($anzst/2);
          }
          if (($goaltippa[$j][$i] != "_") && ($goaltippb[$j][$i] != "_") && ((($tabtype == 0 or $tabtype == 3 or $tabtype == 4) && (($a == $teama[$j][$i]) || ($a == $teamb[$j][$i]))) || (($tabtype == 1) && ($a == $teama[$j][$i])) || (($tabtype == 2) && ($a == $teamb[$j][$i])))) {
            if ($stt < $j+1) {
              $stt = $j+1;
            }
            $p0s = $pns;
            $p0u = $pnu;
            $p0n = $pnn;
            $spiele[$a] = $spiele[$a]+1;
            if ($a == $teama[$j][$i]) {
              $etore[$a] = $etore[$a]+$goaltippa[$j][$i];
              $atore[$a] = $atore[$a]+$goaltippb[$j][$i];
              if ($goaltippa[$j][$i] > $goaltippb[$j][$i]) {
                $siege[$a] = $siege[$a]+1;
                $punkte[$a] = $punkte[$a]+$p0s;
                if ($minus == 2) {
                  $negativ[$a] = $negativ[$a]+$p0n;
                }
              } elseif ($goaltippa[$j][$i] < $goaltippb[$j][$i]) {
                $nieder[$a] = $nieder[$a]+1;
                $punkte[$a] = $punkte[$a]+$p0n;
                if ($minus == 2) {
                  $negativ[$a] = $negativ[$a]+$p0s;
                }
              } elseif ($goaltippa[$j][$i] == $goaltippb[$j][$i]) {
                $unent[$a] = $unent[$a]+1;
                $punkte[$a] = $punkte[$a]+$p0u;
                if ($minus == 2) {
                  $negativ[$a] = $negativ[$a]+$p0u;
                }
              }
            }
            if ($a == $teamb[$j][$i]) {
              $etore[$a] = $etore[$a]+$goaltippb[$j][$i];
              $atore[$a] = $atore[$a]+$goaltippa[$j][$i];
              if ($goaltippa[$j][$i] < $goaltippb[$j][$i]) {
                $siege[$a] = $siege[$a]+1;
                $punkte[$a] = $punkte[$a]+$p0s;
                if ($minus == 2) {
                  $negativ[$a] = $negativ[$a]+$p0n;
                }
              }
              else if ($goaltippa[$j][$i] > $goaltippb[$j][$i]) {
                $nieder[$a] = $nieder[$a]+1;
                $punkte[$a] = $punkte[$a]+$p0n;
                if ($minus == 2) {
                  $negativ[$a] = $negativ[$a]+$p0s;
                }
              }
              else if ($goaltippa[$j][$i] == $goaltippb[$j][$i]) {
                $unent[$a] = $unent[$a]+1;
                $punkte[$a] = $punkte[$a]+$p0u;
                if ($minus == 2) {
                  $negativ[$a] = $negativ[$a]+$p0u;
                }
              }
            }
          }
          // ende if (($goaltippa[$j][$i]!="_") && ($goaltippb[$j][$i]!="_") &&
        }
        // ende if($btip[$j][$i]==false)
      }
      // ende for($i=0;$i<$anzsp;$i++)
    }
    // ende for($j=$hoy;$j<$endtab;$j++)
    if (($tabtype == 0 or $tabtype == 3 or $tabtype == 4) && $m==0) {
      $punkte[$a] = $punkte[$a]-$strafp[$a];
      if ($minus == 2) {
        $negativ[$a] = $negativ[$a]-$strafm[$a];
      }
    }
    if ($m == ($anztipper-1)) {
      $dtore[$a] = $etore[$a]-$atore[$a];
      $quote[$a] = 0;
      if ($spiele[$a] != 0) {
        $quote[$a] = number_format($punkte[$a]/$spiele[$a], 2, ".", ",");
      }
      $quote[$a] *= 100;
      if ($kegel == 0) {
        array_push($tab0, (50000000+$quote[$a]).(50000000+$punkte[$a]).(50000000-$negativ[$a]).(50000000+$dtore[$a]).(50000000+$etore[$a]).(50000000+$a));
      } else {
        array_push($tab0, (50000000+$quote[$a]).(50000000+$punkte[$a]).(50000000-$negativ[$a]).(50000000+$etore[$a]).(50000000+$dtore[$a]).(50000000+$a));
      }
    }
  }
  // ende for($a=1;$a<=$anzteams;$a++)
  if ($m == ($anztipper-1)) {
    array_shift($tab0);
    rsort($tab0, SORT_STRING);
    if ($direkt == 1) {
      $cba = 1;
      for ($abc = 1; $abc < $anzteams; $abc++) {
        $x1 = substr($tab0[$abc-1], 7, 9);
        $x2 = substr($tab0[$abc], 7, 9);
        if ($x1 == $x2) {
          $cba++;
        }
        if (($x1 != $x2) || (($abc == $anzteams-1) && ($x1 == $x2))) {
          if ($cba > 1) {
            $subteams = "";
            for ($b = 1; $b <= $cba; $b++) {
              if ($b > 1) {
                $subteams = $subteams.".";
              }
              if (($abc == $anzteams-1) && ($x1 == $x2)) {
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
    // ende if($direkt==1)
  }
  // ende if($m==($anztipper-1))
}
// ende if($file!="")

?>