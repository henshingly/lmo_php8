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
  
  
if ($file!="") {
  $spiele = array_pad($array,$anzteams+1,"0");
  $siege = array_pad($array,$anzteams+1,"0");
  $unent = array_pad($array,$anzteams+1,"0");
  $nieder = array_pad($array,$anzteams+1,"0");
  $punkte = array_pad($array,$anzteams+1,"0");
  $negativ = array_pad($array,$anzteams+1,"0");
  $etore = array_pad($array,$anzteams+1,"0");
  $atore = array_pad($array,$anzteams+1,"0");
  $dtore = array_pad($array,$anzteams+1,"0");
  $taba = array_pad($array,$anzst+1,"");
  for ($i=0; $i<$anzst; $i++) {
    $taba[$i] = array("");
  }
  $platz = array_pad($array,$anzteams+1,"");
  for ($i=0; $i<$anzteams; $i++) {
    $platz[$i] = array("");
    $platz[$i] = array_pad($array,$anzst+1,"");
  }
  for ($jyz=0; $jyz<$anzst; $jyz++) {
    $sttest=false;
    $endtab=$jyz+1;
    for ($a=1; $a<=$anzteams; $a++) {
      for ($i=0; $i<$anzsp; $i++) {
        if (($goala[$jyz][$i]!="_") && ($goalb[$jyz][$i]!="_") && ((($tabtype==0) && (($a==$teama[$jyz][$i]) || ($a==$teamb[$jyz][$i]))) || (($tabtype==1) && ($a==$teama[$jyz][$i])) || (($tabtype==2) && ($a==$teamb[$jyz][$i])))) {
          $sttest=true;
          $p0s=$pns;
          $p0u=$pnu;
          $p0n=$pnn;
          if ($spez==1) {
            if ($mspez[$jyz][$i]==$text[0]) {
              $p0s=$pxs;
              $p0u=$pxu;
              $p0n=$pxn;
            }
            if ($mspez[$jyz][$i]==$text[1]) {
              $p0s=$pps;
              $p0u=$ppu;
              $p0n=$ppn;
            }
          }
          $spiele[$a]=$spiele[$a]+1;
          if (($a==$teama[$jyz][$i]) || (($a==$teamb[$jyz][$i]) && ($msieg[$jyz][$i]==3))) {
            $etore[$a]=$etore[$a]+$goala[$jyz][$i];
            $atore[$a]=$atore[$a]+$goalb[$jyz][$i];
            if ($msieg[$jyz][$i]==1) {
              $siege[$a]=$siege[$a]+1;
              $punkte[$a]=$punkte[$a]+$p0s;
              if ($minus==2) {
                $negativ[$a]=$negativ[$a]+$p0n;
              }
            } else if ($msieg[$jyz][$i]==2) {
              $nieder[$a]=$nieder[$a]+1;
              $punkte[$a]=$punkte[$a]+$p0n;
              if ($minus==2) {
                $negativ[$a]=$negativ[$a]+$p0s;
              }
            } else {
              if ($goala[$jyz][$i]>$goalb[$jyz][$i]) {
                $siege[$a]=$siege[$a]+1;
                $punkte[$a]=$punkte[$a]+$p0s;
                if ($minus==2) {
                  $negativ[$a]=$negativ[$a]+$p0n;
                }
              } else if ($goala[$jyz][$i]<$goalb[$jyz][$i]) {
                $nieder[$a]=$nieder[$a]+1;
                $punkte[$a]=$punkte[$a]+$p0n;
                if ($minus==2) {
                  $negativ[$a]=$negativ[$a]+$p0s;
                }
              } else if ($goala[$jyz][$i]==$goalb[$jyz][$i]) {
                $unent[$a]=$unent[$a]+1;
                $punkte[$a]=$punkte[$a]+$p0u;
                if ($minus==2) {
                  $negativ[$a]=$negativ[$a]+$p0u;
                }
              }
            }
          }
          if (($a==$teamb[$jyz][$i]) && ($msieg[$jyz][$i]!=3)) {
            $etore[$a]=$etore[$a]+$goalb[$jyz][$i];
            $atore[$a]=$atore[$a]+$goala[$jyz][$i];
            if ($msieg[$jyz][$i]==2) {
              $siege[$a]=$siege[$a]+1;
              $punkte[$a]=$punkte[$a]+$p0s;
              if ($minus==2) {
                $negativ[$a]=$negativ[$a]+$p0n;
              }
            } else if ($msieg[$jyz][$i]==1) {
              $nieder[$a]=$nieder[$a]+1;
              $punkte[$a]=$punkte[$a]+$p0n;
              if ($minus==2) {
                $negativ[$a]=$negativ[$a]+$p0s;
              }
            } else if ($msieg[$jyz][$i]==0) {
              if ($goala[$jyz][$i]<$goalb[$jyz][$i]) {
                $siege[$a]=$siege[$a]+1;
                $punkte[$a]=$punkte[$a]+$p0s;
                if ($minus==2) {
                  $negativ[$a]=$negativ[$a]+$p0n;
                }
              } else if ($goala[$jyz][$i]>$goalb[$jyz][$i]) {
                $nieder[$a]=$nieder[$a]+1;
                $punkte[$a]=$punkte[$a]+$p0n;
                if ($minus==2) {
                  $negativ[$a]=$negativ[$a]+$p0s;
                }
              } else if ($goala[$jyz][$i]==$goalb[$jyz][$i]) {
                $unent[$a]=$unent[$a]+1;
                $punkte[$a]=$punkte[$a]+$p0u;
                if ($minus==2) {
                  $negativ[$a]=$negativ[$a]+$p0u;
                }
              }
            }
          }
        }
      }
    }
    
    for ($a=1; $a<=$anzteams; $a++) {
      if ($endtab==$strafdat[$a]) {        // Hack-Straftore
        $etore[$a]=$etore[$a]-$torkorrektur1[$a];        // Hack-Straftore
        $atore[$a]=$atore[$a]-$torkorrektur2[$a];        // Hack-Straftore
      }      // Hack-Straftore
      $dtore[$a]=$etore[$a]-$atore[$a];
      if ($endtab>=$strafdat[$a]) {        // Hack-Straftore
        $punkte[$a]=$punkte[$a]-$strafp[$a];
        if ($minus==2) {
          $negativ[$a]=$negativ[$a]-$strafm[$a];
        }
      }      // Hack-Straftore
      if ($kegel==0) {
        array_push($taba[$jyz],(50000000+$punkte[$a]).(50000000-$negativ[$a]).(50000000+$dtore[$a]).(50000000+$etore[$a]).(50000000+$a));
      } else {
        array_push($taba[$jyz],(50000000+$punkte[$a]).(50000000-$negativ[$a]).(50000000+$etore[$a]).(50000000+$dtore[$a]).(50000000+$a));
      }
      if ($endtab>=$strafdat[$a]) {        // Hack-Straftore
        $punkte[$a]=$punkte[$a]+$strafp[$a];
        if ($minus==2) {
          $negativ[$a]=$negativ[$a]+$strafm[$a];
        }
      }      // Hack-Straftore
    }
    array_shift($taba[$jyz]);
    rsort($taba[$jyz],SORT_STRING);
    if ($direkt==1) {
      $cba=1;
      for ($abc=1; $abc<$anzteams; $abc++) {
        $x1=substr($taba[$jyz][$abc-1],7,9);
        $x2=substr($taba[$jyz][$abc],7,9);
        if ($x1==$x2) {
          $cba++;
        }
        if (($x1!=$x2) || (($abc==$anzteams-1) && ($x1==$x2))) {
          if ($cba>1) {
            $def=0;
            $subteams="";
            for ($b=1; $b<=$cba; $b++) {
              $x3=intval(substr($taba[$jyz][$abc-$b+1],34));
              $x4=intval(substr($taba[$jyz][$abc-$b],34));
              if ($b>1) {
                $subteams=$subteams.".";
              }
              if (($abc==$anzteams-1) && ($x1==$x2)) {
                $subteams=$subteams.$x3;
                if (($x3==$stat1) || ($x3==$stat2)) {
                  $def++;
                }
              } else {
                $subteams=$subteams.$x4;
                if (($x4==$stat1) || ($x4==$stat2)) {
                  $def++;
                }
              }
            }
            $anzcnt=0;
            if ($def>0) {
              require(PATH_TO_LMO."/lmo-calctable1.php");
              if ($anzcnt>0) {
                for ($b=1; $b<=count($tab1); $b++) {
                  for ($f=0; $f<count($taba[$jyz]); $f++) {
                    $x3=intval(substr($taba[$jyz][$f],-7));
                    $x4=intval(substr($tab1[$b-1],-7));
                    if ($x3==$x4) {
                      $taba[$jyz][$f]=substr($taba[$jyz][$f],0,17-strlen($b)).$b.substr($taba[$jyz][$f],17);
                    }
                  }
                }
              }
            }
          }
          $cba=1;
        }
      }
      rsort($taba[$jyz],SORT_STRING);
    }
    if ($hands==1) {
      if ($handp[$endtab-1]!=0) {
        for ($ih=0; $ih<$anzteams; $ih++) {
          $handd=intval(substr($handp[$endtab-1],$ih*2,2));
          if ($handd<10) {
            $handd="0".$handd;
          }
          $taba[$jyz][$ih]=$handd.substr($taba[$jyz][$ih],2);
        }
        sort($taba[$jyz],SORT_STRING);
      }
    }
    if ($sttest==true) {
      for ($x=0; $x<$anzteams; $x++) {
        $x3=intval(substr($taba[$jyz][$x],34));
        $platz[$x3][$jyz]=$x+1;
      }
    } else {
      for ($x=0; $x<$anzteams; $x++) {
        $x3=intval(substr($taba[$jyz][$x],34));
        $platz[$x3][$jyz]=0;
      }
    }
  }
}


?>