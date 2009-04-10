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
  if (!isset($tabtype)) {
    $tabtype = 0;
  }
  if (!isset($newtabtype)) {
    $newtabtype = 0;
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
  $maxs0 = array_pad($array, $anzteams+1, "&nbsp;");
  $maxs1 = array_pad($array, $anzteams+1, "0");
  $maxs2 = array_pad($array, $anzteams+1, "0");
  $maxn0 = array_pad($array, $anzteams+1, "&nbsp;");
  $maxn1 = array_pad($array, $anzteams+1, "0");
  $maxn2 = array_pad($array, $anzteams+1, "0");
  $ser1 = array_pad($array, $anzteams+1, "0");
  $ser2 = array_pad($array, $anzteams+1, "0");
  $ser3 = array_pad($array, $anzteams+1, "0");
  $ser4 = array_pad($array, $anzteams+1, "0");
   
  $tab0 = array();
  $stt = 0;
  $hoy = 0;
  for ($a = 1; $a <= $anzteams; $a++) {
    if ($tabtype == 3 || $newtabtype == 3) {
      $hoy = ($anzst/2);
    }
    if ($tabtype == 4 || $newtabtype == 4) {
      $endtab = ($anzst/2);
    }
    for ($j = $hoy; $j < $endtab; $j++) {
      for ($i = 0; $i < $anzsp; $i++) {
        if ($tabtype == 3 || $newtabtype == 3) {
          $hoy = ($anzst/2);
        }
        if ($tabtype == 4 || $newtabtype == 4) {
          $endtab = ($anzst/2);
        }
        if (($goala[$j][$i] != "_") && ($goalb[$j][$i] != "_") && ((($tabtype == 0 or $tabtype == 3 or $tabtype == 4) && (($a == $teama[$j][$i]) || ($a == $teamb[$j][$i]))) || (($tabtype == 1) && ($a == $teama[$j][$i])) || (($tabtype == 2) && ($a == $teamb[$j][$i])))) {
          if ($stt < $j+1) {
            $stt = $j+1;
          }
          $p0s = $pns;
          $p0u = $pnu;
          $p0n = $pnn;
          if ($spez == 1) {
            if ($mspez[$j][$i] == $text[0]) {
              $p0s = $pxs;
              $p0u = $pxu;
              $p0n = $pxn;
            }
            if ($mspez[$j][$i] == $text[1]) {
              $p0s = $pps;
              $p0u = $ppu;
              $p0n = $ppn;
            }
          }
          $spiele[$a]++;
          if (($a == $teama[$j][$i]) || (($a == $teamb[$j][$i]) && ($msieg[$j][$i] == 3))) {
            $etore[$a] = $etore[$a]+$goala[$j][$i];
            $atore[$a] = $atore[$a]+$goalb[$j][$i];
            if ($msieg[$j][$i] == 1) {
              $siege[$a] = $siege[$a]+1;
              $punkte[$a] = $punkte[$a]+$p0s;
              if ($minus == 2) {
                $negativ[$a] = $negativ[$a]+$p0n;
              }
              $ser1[$a]++;
              $ser2[$a]++;
              $ser3[$a] = 0;
              $ser4[$a] = 0;
              if (($goala[$j][$i]-$goalb[$j][$i]) > ($maxs1[$a]-$maxs2[$a]) || ((($goala[$j][$i]-$goalb[$j][$i]) == ($maxs1[$a]-$maxs2[$a])) && ($goala[$j][$i] > $maxs1[$a]))) {
                $maxs1[$a] = $goala[$j][$i];
                $maxs2[$a] = $goalb[$j][$i];
                $maxs0[$a] = applyFactor($goala[$j][$i], $goalfaktor).":".applyFactor($goalb[$j][$i], $goalfaktor)." ".$text[72]." ".$teams[$teamb[$j][$i]]." ".$text[73];
              } elseif ((($goala[$j][$i]-$goalb[$j][$i]) == ($maxs1[$a]-$maxs2[$a])) && ($goala[$j][$i] == $maxs1[$a])) {
                $maxs0[$a] = $maxs0[$a]."<br>".applyFactor($goala[$j][$i], $goalfaktor).":".applyFactor($goalb[$j][$i], $goalfaktor)." ".$text[72]." ".$teams[$teamb[$j][$i]]." ".$text[73];
              }
            } elseif ($msieg[$j][$i] == 2) {
              $nieder[$a] = $nieder[$a]+1;
              $punkte[$a] = $punkte[$a]+$p0n;
              if ($minus == 2) {
                $negativ[$a] = $negativ[$a]+$p0s;
              }
              $ser3[$a]++;
              $ser4[$a]++;
              $ser1[$a] = 0;
              $ser2[$a] = 0;
              if (($goala[$j][$i]-$goalb[$j][$i]) < ($maxn1[$a]-$maxn2[$a]) || ((($goala[$j][$i]-$goalb[$j][$i]) == ($maxn1[$a]-$maxn2[$a])) && ($goala[$j][$i] < $maxn1[$a]))) {
                $maxn1[$a] = $goala[$j][$i];
                $maxn2[$a] = $goalb[$j][$i];
                $maxn0[$a] = applyFactor($goala[$j][$i], $goalfaktor).":".applyFactor($goalb[$j][$i], $goalfaktor)." ".$text[72]." ".$teams[$teamb[$j][$i]]." ".$text[73];
              } elseif ((($goala[$j][$i]-$goalb[$j][$i]) == ($maxn1[$a]-$maxn2[$a])) && ($goala[$j][$i] == $maxn1[$a])) {
                $maxn0[$a] = $maxn0[$a]."<br>".applyFactor($goala[$j][$i], $goalfaktor).":".applyFactor($goalb[$j][$i], $goalfaktor)." ".$text[72]." ".$teams[$teamb[$j][$i]]." ".$text[73];
              }
            } elseif ($msieg[$j][$i] == 0) {
              if ($goala[$j][$i] > $goalb[$j][$i]) {
                $siege[$a] = $siege[$a]+1;
                $punkte[$a] = $punkte[$a]+$p0s;
                if ($minus == 2) {
                  $negativ[$a] = $negativ[$a]+$p0n;
                }
                $ser1[$a]++;
                $ser2[$a]++;
                $ser3[$a] = 0;
                $ser4[$a] = 0;
                if (($goala[$j][$i]-$goalb[$j][$i]) > ($maxs1[$a]-$maxs2[$a]) || ((($goala[$j][$i]-$goalb[$j][$i]) == ($maxs1[$a]-$maxs2[$a])) && ($goala[$j][$i] > $maxs1[$a]))) {
                  $maxs1[$a] = $goala[$j][$i];
                  $maxs2[$a] = $goalb[$j][$i];
                  $maxs0[$a] = applyFactor($goala[$j][$i], $goalfaktor).":".applyFactor($goalb[$j][$i], $goalfaktor)." ".$text[72]." ".$teams[$teamb[$j][$i]]." ".$text[73];
                } elseif ((($goala[$j][$i]-$goalb[$j][$i]) == ($maxs1[$a]-$maxs2[$a])) && ($goala[$j][$i] == $maxs1[$a])) {
                  $maxs0[$a] = $maxs0[$a]."<br>".applyFactor($goala[$j][$i], $goalfaktor).":".applyFactor($goalb[$j][$i], $goalfaktor)." ".$text[72]." ".$teams[$teamb[$j][$i]]." ".$text[73];
                }
              } elseif ($goala[$j][$i] < $goalb[$j][$i]) {
                $nieder[$a] = $nieder[$a]+1;
                $punkte[$a] = $punkte[$a]+$p0n;
                if ($minus == 2) {
                  $negativ[$a] = $negativ[$a]+$p0s;
                }
                $ser3[$a]++;
                $ser4[$a]++;
                $ser1[$a] = 0;
                $ser2[$a] = 0;
                if (($goala[$j][$i]-$goalb[$j][$i]) < ($maxn1[$a]-$maxn2[$a]) || ((($goala[$j][$i]-$goalb[$j][$i]) == ($maxn1[$a]-$maxn2[$a])) && ($goala[$j][$i] < $maxn1[$a]))) {
                  $maxn1[$a] = $goala[$j][$i];
                  $maxn2[$a] = $goalb[$j][$i];
                  $maxn0[$a] = applyFactor($goala[$j][$i], $goalfaktor).":".applyFactor($goalb[$j][$i], $goalfaktor)." ".$text[72]." ".$teams[$teamb[$j][$i]]." ".$text[73];
                } elseif ((($goala[$j][$i]-$goalb[$j][$i]) == ($maxn1[$a]-$maxn2[$a])) && ($goala[$j][$i] == $maxn1[$a])) {
                  $maxn0[$a] = $maxn0[$a]."<br>".applyFactor($goala[$j][$i], $goalfaktor).":".applyFactor($goalb[$j][$i], $goalfaktor)." ".$text[72]." ".$teams[$teamb[$j][$i]]." ".$text[73];
                }
              } elseif ($goala[$j][$i] == $goalb[$j][$i]) {
                $unent[$a] = $unent[$a]+1;
                $punkte[$a] = $punkte[$a]+$p0u;
                if ($minus == 2) {
                  $negativ[$a] = $negativ[$a]+$p0u;
                }
                $ser1[$a] = 0;
                $ser2[$a]++;
                $ser3[$a] = 0;
                $ser4[$a]++;
              }
            }
          }
          if (($a == $teamb[$j][$i]) && ($msieg[$j][$i] != 3)) {
            $etore[$a] = $etore[$a]+$goalb[$j][$i];
            $atore[$a] = $atore[$a]+$goala[$j][$i];
            if ($msieg[$j][$i] == 2) {
              $siege[$a] = $siege[$a]+1;
              $punkte[$a] = $punkte[$a]+$p0s;
              if ($minus == 2) {
                $negativ[$a] = $negativ[$a]+$p0n;
              }
              $ser1[$a]++;
              $ser2[$a]++;
              $ser3[$a] = 0;
              $ser4[$a] = 0;
              if (($goalb[$j][$i]-$goala[$j][$i]) > ($maxs1[$a]-$maxs2[$a]) || ((($goalb[$j][$i]-$goala[$j][$i]) == ($maxs1[$a]-$maxs2[$a])) && ($goalb[$j][$i] > $maxs1[$a]))) {
                $maxs1[$a] = $goalb[$j][$i];
                $maxs2[$a] = $goala[$j][$i];
                $maxs0[$a] = applyFactor($goalb[$j][$i], $goalfaktor).":".applyFactor($goala[$j][$i], $goalfaktor)." ".$text[72]." ".$teams[$teama[$j][$i]]." ".$text[74];
              } elseif ((($goalb[$j][$i]-$goala[$j][$i]) == ($maxs1[$a]-$maxs2[$a])) && ($goalb[$j][$i] == $maxs1[$a])) {
                $maxs0[$a] = $maxs0[$a]."<br>".applyFactor($goalb[$j][$i], $goalfaktor).":".applyFactor($goala[$j][$i], $goalfaktor)." ".$text[72]." ".$teams[$teama[$j][$i]]." ".$text[74];
              }
            } elseif ($msieg[$j][$i] == 1) {
              $nieder[$a] = $nieder[$a]+1;
              $punkte[$a] = $punkte[$a]+$p0n;
              if ($minus == 2) {
                $negativ[$a] = $negativ[$a]+$p0s;
              }
              $ser3[$a]++;
              $ser4[$a]++;
              $ser1[$a] = 0;
              $ser2[$a] = 0;
              if (($goalb[$j][$i]-$goala[$j][$i]) < ($maxn1[$a]-$maxn2[$a]) || ((($goalb[$j][$i]-$goala[$j][$i]) == ($maxn1[$a]-$maxn2[$a])) && ($goalb[$j][$i] < $maxn1[$a]))) {
                $maxn1[$a] = $goalb[$j][$i];
                $maxn2[$a] = $goala[$j][$i];
                $maxn0[$a] = applyFactor($goalb[$j][$i], $goalfaktor).":".applyFactor($goala[$j][$i], $goalfaktor)." ".$text[72]." ".$teams[$teama[$j][$i]]." ".$text[74];
              } elseif ((($goalb[$j][$i]-$goala[$j][$i]) == ($maxn1[$a]-$maxn2[$a])) && ($goalb[$j][$i] == $maxn1[$a])) {
                $maxn0[$a] = $maxn0[$a]."<br>".applyFactor($goalb[$j][$i], $goalfaktor).":".applyFactor($goala[$j][$i], $goalfaktor)." ".$text[72]." ".$teams[$teama[$j][$i]]." ".$text[74];
              }
            } elseif ($msieg[$j][$i] == 0) {
              if ($goala[$j][$i] < $goalb[$j][$i]) {
                $siege[$a] = $siege[$a]+1;
                $punkte[$a] = $punkte[$a]+$p0s;
                if ($minus == 2) {
                  $negativ[$a] = $negativ[$a]+$p0n;
                }
                $ser1[$a]++;
                $ser2[$a]++;
                $ser3[$a] = 0;
                $ser4[$a] = 0;
                if (($goalb[$j][$i]-$goala[$j][$i]) > ($maxs1[$a]-$maxs2[$a]) || ((($goalb[$j][$i]-$goala[$j][$i]) == ($maxs1[$a]-$maxs2[$a])) && ($goalb[$j][$i] > $maxs1[$a]))) {
                  $maxs1[$a] = $goalb[$j][$i];
                  $maxs2[$a] = $goala[$j][$i];
                  $maxs0[$a] = applyFactor($goalb[$j][$i], $goalfaktor).":".applyFactor($goala[$j][$i], $goalfaktor)." ".$text[72]." ".$teams[$teama[$j][$i]]." ".$text[74];
                } elseif ((($goalb[$j][$i]-$goala[$j][$i]) == ($maxs1[$a]-$maxs2[$a])) && ($goalb[$j][$i] == $maxs1[$a])) {
                  $maxs0[$a] = $maxs0[$a]."<br>".applyFactor($goalb[$j][$i], $goalfaktor).":".applyFactor($goala[$j][$i], $goalfaktor)." ".$text[72]." ".$teams[$teama[$j][$i]]." ".$text[74];
                }
              } elseif ($goala[$j][$i] > $goalb[$j][$i]) {
                $nieder[$a] = $nieder[$a]+1;
                $punkte[$a] = $punkte[$a]+$p0n;
                if ($minus == 2) {
                  $negativ[$a] = $negativ[$a]+$p0s;
                }
                $ser3[$a]++;
                $ser4[$a]++;
                $ser1[$a] = 0;
                $ser2[$a] = 0;
                if (($goalb[$j][$i]-$goala[$j][$i]) < ($maxn1[$a]-$maxn2[$a]) || ((($goalb[$j][$i]-$goala[$j][$i]) == ($maxn1[$a]-$maxn2[$a])) && ($goalb[$j][$i] < $maxn1[$a]))) {
                  $maxn1[$a] = $goalb[$j][$i];
                  $maxn2[$a] = $goala[$j][$i];
                  $maxn0[$a] = applyFactor($goalb[$j][$i], $goalfaktor).":".applyFactor($goala[$j][$i], $goalfaktor)." ".$text[72]." ".$teams[$teama[$j][$i]]." ".$text[74];
                } elseif ((($goalb[$j][$i]-$goala[$j][$i]) == ($maxn1[$a]-$maxn2[$a])) && ($goalb[$j][$i] == $maxn1[$a])) {
                  $maxn0[$a] = $maxn0[$a]."<br>".applyFactor($goalb[$j][$i], $goalfaktor).":".applyFactor($goala[$j][$i], $goalfaktor)." ".$text[72]." ".$teams[$teama[$j][$i]]." ".$text[74];
                }
              } elseif ($goala[$j][$i] == $goalb[$j][$i]) {
                $unent[$a] = $unent[$a]+1;
                $punkte[$a] = $punkte[$a]+$p0u;
                if ($minus == 2) {
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
    if ($endtab >= $strafdat[$a] && ($tabtype == 0 or ($tabtype == 3 && $strafdat[$a] > ($hoy = ($anzst/2))) or ($tabtype == 4 && $strafdat[$a] <= ($endtab = ($anzst/2))))) {
      // Hack-Straftore
      $etore[$a] = $etore[$a]-$torkorrektur1[$a]; // Hack-Straftore
      $atore[$a] = $atore[$a]-$torkorrektur2[$a]; // Hack-Straftore
    }
    $dtore[$a] = $etore[$a]-$atore[$a];
    if ($endtab >= $strafdat[$a] && ($tabtype == 0 or ($tabtype == 3 && $strafdat[$a] > ($hoy = ($anzst/2))) or ($tabtype == 4 && $strafdat[$a] <= ($endtab = ($anzst/2))))) {
      // Hack-Straftore
      $punkte[$a] = $punkte[$a]-$strafp[$a];
      if ($minus == 2) {
        $negativ[$a] = $negativ[$a]-$strafm[$a];
      }
    } // Hack-Straftore
    if ($kegel == 0) {
      array_push($tab0, (50000000+$punkte[$a]).(50000000-$negativ[$a]).(50000000+$dtore[$a]).(50000000+$etore[$a]).(50000000+$a));
    } else {
      array_push($tab0, (50000000+$punkte[$a]).(50000000-$negativ[$a]).(50000000+$etore[$a]).(50000000+$dtore[$a]).(50000000+$a));
    }
  }
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
          require(PATH_TO_LMO."/lmo-calctable1.php");
          if ($anzcnt > 0) {
            for ($b = 1; $b <= count($tab1); $b++) {
              for($f = 0; $f < count($tab0); $f++) {
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
  if ($action == "admin") {
    $tab2 = $tab0;
  }
  if ($hands == 1 && $tabtype==0) {
    if (empty($tabdat) || $action == "admin") {
      $handb = $stx-1;
    } else {
      $handb = $endtab-1;
    }
    if ($handp[$handb] != 0) {
      for ($ih = 0; $ih < $anzteams; $ih++) {
        $handd = intval(substr($handp[$handb], $ih * 2, 2));
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