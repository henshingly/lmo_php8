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
  
  
if (($file!="") && ($subteams!="")) {
  if (!isset($tabtype)) {
    $tabtype = 0;
  }
  if (!isset($newtabtype)) {
    $newtabtype = 0;
  }
  $subteam = explode('.',$subteams);
  $spiele1 = array_pad($array,$anzteams+1,"0");
  $siege1 = array_pad($array,$anzteams+1,"0");
  $unent1 = array_pad($array,$anzteams+1,"0");
  $nieder1 = array_pad($array,$anzteams+1,"0");
  $punkte1 = array_pad($array,$anzteams+1,"0");
  $negativ1 = array_pad($array,$anzteams+1,"0");
  $etore1 = array_pad($array,$anzteams+1,"0");
  $atore1 = array_pad($array,$anzteams+1,"0");
  $dtore1 = array_pad($array,$anzteams+1,"0");
  $mcalc = array_pad($array,116,"");
  $hoy=0;
  for ($i=0; $i<116; $i++) {
    $mcalc[$i] = array_pad($array,40,"0");
  }
  $tab1 = array();
  for ($a=1; $a<=$anzteams; $a++) {
    if ($tabtype == 3 || $newtabtype == 3) {
      $hoy = ($anzst/2);
    }
    if ($tabtype == 4 || $newtabtype == 4) {
      $endtab = ($anzst/2);
    }
    for ($j=$hoy; $j<$endtab; $j++) {
      for ($i=0; $i<$anzsp; $i++) {
        $b=0;
        for ($c=0; $c<count($subteam); $c++) {
          if ($subteam[$c]==$teama[$j][$i]) {
            $b++;
          } else if ($subteam[$c]==$teamb[$j][$i]) {
            $b++;
          }
        }
        if (($b==2) && ($mcalc[$j][$i]<2) && ($goala[$j][$i]!="_") && ($goalb[$j][$i]!="_") && ((($tabtype==0 or $tabtype==3 or $tabtype==4) && (($a==$teama[$j][$i]) || ($a==$teamb[$j][$i]))) || (($tabtype==1) && ($a==$teama[$j][$i])) || (($tabtype==2) && ($a==$teamb[$j][$i])))) {
          $mcalc[$j][$i]=$mcalc[$j][$i]+1;
          $anzcnt++;
          $p0s=$pns;
          $p0u=$pnu;
          $p0n=$pnn;
          if ($spez==1) {
            if ($mspez[$j][$i]==$text[0]) {
              $p0s=$pxs;
              $p0u=$pxu;
              $p0n=$pxn;
            }
            if ($mspez[$j][$i]==$text[1]) {
              $p0s=$pps;
              $p0u=$ppu;
              $p0n=$ppn;
            }
          }
          $spiele1[$a]++;
          if (($a==$teama[$j][$i]) || (($a==$teamb[$j][$i]) && ($msieg[$j][$i]==3))) {
            $etore1[$a]=$etore1[$a]+$goala[$j][$i];
            $atore1[$a]=$atore1[$a]+$goalb[$j][$i];
            if ($msieg[$j][$i]==1) {
              $siege1[$a]=$siege1[$a]+1;
              $punkte1[$a]=$punkte1[$a]+$p0s;
              if ($minus==2) {
                $negativ1[$a]=$negativ1[$a]+$p0n;
              }
            } else if ($msieg[$j][$i]==2) {
              $nieder1[$a]=$nieder1[$a]+1;
              $punkte1[$a]=$punkte1[$a]+$p0n;
              if ($minus==2) {
                $negativ1[$a]=$negativ1[$a]+$p0s;
              }
            } else if ($msieg[$j][$i]==0) {
              if ($goala[$j][$i]>$goalb[$j][$i]) {
                $siege1[$a]=$siege1[$a]+1;
                $punkte1[$a]=$punkte1[$a]+$p0s;
                if ($minus==2) {
                  $negativ1[$a]=$negativ1[$a]+$p0n;
                }
              } else if ($goala[$j][$i]<$goalb[$j][$i]) {
                $nieder1[$a]=$nieder1[$a]+1;
                $punkte1[$a]=$punkte1[$a]+$p0n;
                if ($minus==2) {
                  $negativ1[$a]=$negativ1[$a]+$p0s;
                }
              } else if ($goala[$j][$i]==$goalb[$j][$i]) {
                $unent1[$a]=$unent1[$a]+1;
                $punkte1[$a]=$punkte1[$a]+$p0u;
                if ($minus==2) {
                  $negativ1[$a]=$negativ1[$a]+$p0u;
                }
              }
            }
          }
          if (($a==$teamb[$j][$i]) && ($msieg[$j][$i]!=3)) {
            $etore1[$a]=$etore1[$a]+$goalb[$j][$i];
            $atore1[$a]=$atore1[$a]+$goala[$j][$i];
            if ($msieg[$j][$i]==2) {
              $siege1[$a]=$siege1[$a]+1;
              $punkte1[$a]=$punkte1[$a]+$p0s;
              if ($minus==2) {
                $negativ1[$a]=$negativ1[$a]+$p0n;
              }
            } else if ($msieg[$j][$i]==1) {
              $nieder1[$a]=$nieder1[$a]+1;
              $punkte1[$a]=$punkte1[$a]+$p0n;
              if ($minus==2) {
                $negativ1[$a]=$negativ1[$a]+$p0s;
              }
            } else if ($msieg[$j][$i]==0) {
              if ($goala[$j][$i]<$goalb[$j][$i]) {
                $siege1[$a]=$siege1[$a]+1;
                $punkte1[$a]=$punkte1[$a]+$p0s;
                if ($minus==2) {
                  $negativ1[$a]=$negativ1[$a]+$p0n;
                }
              } else if ($goala[$j][$i]>$goalb[$j][$i]) {
                $nieder1[$a]=$nieder1[$a]+1;
                $punkte1[$a]=$punkte1[$a]+$p0n;
                if ($minus==2) {
                  $negativ1[$a]=$negativ1[$a]+$p0s;
                }
              } else if ($goala[$j][$i]==$goalb[$j][$i]) {
                $unent1[$a]=$unent1[$a]+1;
                $punkte1[$a]=$punkte1[$a]+$p0u;
                if ($minus==2) {
                  $negativ1[$a]=$negativ1[$a]+$p0u;
                }
              }
            }
          }
        }
      }
    }
    $dtore1[$a]=$etore1[$a]-$atore1[$a];
    for ($c=0; $c<count($subteam); $c++) {
      if ($subteam[$c]==$a) {
        if ($kegel==0) {
          array_push($tab1,(50000000+$punkte1[$a]).(50000000-$negativ1[$a]).(50000000+$dtore1[$a]).(50000000+$etore1[$a]).(50000000+$c).(50000000+$a));
        } else {
          array_push($tab1,(50000000+$punkte1[$a]).(50000000-$negativ1[$a]).(50000000+$etore1[$a]).(50000000+$dtore1[$a]).(50000000+$c).(50000000+$a));
        }
      }
    }
  }
  sort($tab1,SORT_STRING);
}
?>