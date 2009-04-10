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
  
  
$auswertfile=PATH_TO_ADDONDIR."/tipp/".$tipp_dirtipp."auswert/".substr($file, 0, -4).".aus";
if (!file_exists($auswertfile)) {
  echo getMessage($text['tipp'][17],TRUE);
} else {
  $datei = fopen($auswertfile,"rb");
  $anztipper=0;
  
  if ($datei!=false) {
    $tippdaten=array();
    $sekt="";
    while (!feof($datei)) {
      $zeile = fgets($datei,1000);
      $zeile=trim($zeile);
      if ((substr($zeile,0,1)=="[") && (substr($zeile,-1)=="]")) {
        $sekt=trim(substr($zeile,1,-1));
        $anztipper++;
      } else if ((strpos($zeile,"=")!=false) && (substr($zeile,0,1)!=";")) {
        $schl=trim(substr($zeile,0,strpos($zeile,"=")));
        $wert=trim(substr($zeile,strpos($zeile,"=")+1));
        array_push($tippdaten,$sekt."|".$schl."|".$wert."|EOL");
      }
    }
    fclose($datei);
  }
  
  $tippernick = array_pad($array,$anztipper+1,"");
  
  $tipppunkte = array_pad($array,$anztipper+1,"");
  $spielegetippt = array_pad($array,$anztipper+1,"");
  if ($tipp_showzus==1) {
    $punkte1 = array_pad($array,$anztipper+1,"");
    $punkte2 = array_pad($array,$anztipper+1,"");
    $punkte3 = array_pad($array,$anztipper+1,"");
    $punkte6 = array_pad($array,$anztipper+1,"");
  }
  if ($kurvenmodus==2 || $kurvenmodus==3) {
    $platz = array_pad($array,$anztipper+1,"");
  }
  if ($kurvenmodus>2) {
    $platz1 = array_pad($array,$anztipper+1,"");
    $tipppunktegesamt = array_pad($array,$anztipper+1,"");
    $spielegetipptgesamt = array_pad($array,$anztipper+1,"");
    if ($tipp_showzus==1) {
      $punkte1gesamt = array_pad($array,$anztipper+1,"");
      $punkte2gesamt = array_pad($array,$anztipper+1,"");
      $punkte3gesamt = array_pad($array,$anztipper+1,"");
      $punkte6gesamt = array_pad($array,$anztipper+1,"");
    }
  }
  for ($i=0; $i<$anztipper; $i++) {
    $tipppunkte[$i] = array_pad(array(""),$anzst+1,"");
    $spielegetippt[$i] = array_pad(array(""),$anzst+1,"");
    if ($tipp_showzus==1) {
      $punkte1[$i] = array_pad(array(""),$anzst+1,"");
      $punkte2[$i] = array_pad(array(""),$anzst+1,"");
      $punkte3[$i] = array_pad(array(""),$anzst+1,"");
      $punkte6[$i] = array_pad(array(""),$anzst+1,"");
    }
    if ($kurvenmodus==2 || $kurvenmodus==3) {
      $platz[$i] = array_pad(array(""),$anzst+1,"");
    }
    if ($kurvenmodus>2) {
      $platz1[$i] = array_pad(array(""),$anzst+1,"");
      $tipppunktegesamt[$i] = array_pad(array(""),$anzst+1,"");
      $spielegetipptgesamt[$i] = array_pad(array(""),$anzst+1,"");
      if ($tipp_showzus==1) {
        $punkte1gesamt[$i] = array_pad(array(""),$anzst+1,"");
        $punkte2gesamt[$i] = array_pad(array(""),$anzst+1,"");
        $punkte3gesamt[$i] = array_pad(array(""),$anzst+1,"");
        $punkte6gesamt[$i] = array_pad(array(""),$anzst+1,"");
      }
    }
  }
  if ($kurvenmodus==2 || $kurvenmodus==3) {
    $taba = array_pad($array,$anzst+1,"");
  }
  if ($kurvenmodus>2) {
    $tabb = array_pad($array,$anzst+1,"");
  }
  
  if ($kurvenmodus>1) {
    for ($i=0; $i<$anzst; $i++) {
      if ($kurvenmodus==2 || $kurvenmodus==3) {
        $taba[$i] = array("");
      }
      if ($kurvenmodus>2) {
        $tabb[$i] = array("");
      }
    }
  }
  
  $t=0;
  if ($endtab<1) {
    $endtab=$anzst;
  }
  for ($i=1; $i<=count($tippdaten); $i++) {
    $dum=explode('|',$tippdaten[$i-1]);
    $op1=$dum[0];
    // Nick
    $op3=substr($dum[1],2)-1;
    // Spieltagsnummer
    $op4=substr($dum[1],0,2);
    // TP
    if ($tippernick[$t]!=$op1) {
      if ($tippernick[$t]!="") {
        $t++;
      }
      $tippernick[$t]=$op1;
      if ($stat1==-1 && $_SESSION['lmotippername']==$tippernick[$t]) {
        $stat1=$t;
      }
    }
    if ($op4=="TP") {
      $tipppunkte[$t][$op3]=$dum[2];
      if ($kurvenmodus>2) {
        $tipppunktegesamt[$t][$op3]=$dum[2];
      }
    } else if ($op4=="SG") {
      $spielegetippt[$t][$op3]=$dum[2];
      if ($kurvenmodus>2) {
        $spielegetipptgesamt[$t][$op3]=$dum[2];
      }
    } else if ($tipp_showzus==1) {
      if ($op4=="P1") {
        $punkte1[$t][$op3]=$dum[2];
        if ($kurvenmodus>2) {
          $punkte1gesamt[$t][$op3]=$dum[2];
        }
      } else if ($op4=="P2") {
        $punkte2[$t][$op3]=$dum[2];
        if ($kurvenmodus>2) {
          $punkte2gesamt[$t][$op3]=$dum[2];
        }
      } else if ($op4=="P3") {
        $punkte3[$t][$op3]=$dum[2];
        if ($kurvenmodus>2) {
          $punkte3gesamt[$t][$op3]=$dum[2];
        }
      } else if ($op4=="P6") {
        $punkte6[$t][$op3]=$dum[2];
        if ($kurvenmodus>2) {
          $punkte6gesamt[$t][$op3]=$dum[2];
        }
      }
    }
  }
  
  if ($kurvenmodus>1 && $tipp_showstsiege==1 && ($tipp_krit1==6 || $tipp_krit2==6 || $tipp_krit3==6)) {
    // Spieltagssieger ermitteln
    $stsiege = array_pad($array,$anztipper+1,"");
    if ($kurvenmodus>2) {
      $stsiegegesamt = array_pad($array,$anztipper+1,"");
    }
    for ($a=0; $a<$anztipper; $a++) {
      $stsiege[$a] = array_pad(array(""),$anzst+1,"");
      if ($kurvenmodus>2) {
        $stsiegegesamt[$a] = array_pad(array(""),$anzst+1,"");
      }
    }
    $tab = array_pad($array,$endtab,"");
    for ($i=0; $i<$anzst; $i++) {
      $tab[$i] = array("");
      for ($a=0; $a<$anztipper; $a++) {
        $tt=50000000+$tipppunkte[$a][$i];
        for ($k=1; $k<=3; $k++) {
          if ($k==1) {
            $tipp_krit=$tipp_krit1;
          } else if ($k==2) {
            $tipp_krit=$tipp_krit2;
          } else if ($k==3) {
            $tipp_krit=$tipp_krit3;
          }
          if ($tipp_krit==-1) {
            $tt.=50000000;
          } else if ($tipp_krit==0) {
            $tt.=(50000000-$spielegetippt[$a][$i]);
          } else if ($tipp_krit==1) {
            $tt.=(50000000+$spielegetippt[$a][$i]);
          } else if ($tipp_showzus==1) {
            if ($tipp_krit==2) {
              $tt.=(50000000+$punkte1[$a][$i]);
            } else if ($tipp_krit==3) {
              $tt.=(50000000+$punkte2[$a][$i]);
            } else if ($tipp_krit==4) {
              $tt.=(50000000+$punkte3[$a][$i]);
            } else if ($tipp_krit==5) {
              $tt.=(50000000+$punkte6[$a][$i]);
            }
          }
        }
        $tt.=(50000000+$a);
        array_push($tab[$i],$tt);
      }
      array_shift($tab[$i]);
      rsort($tab[$i],SORT_STRING);
      if ($anztipper>0) {
        $laeng=strlen($tab[$i][0]);
      }
      for ($a=0; $a<$anztipper; $a++) {
        $x=intval(substr($tab[$i][$a],-7));
        if ($tipppunkte[$x][$i]<=0) {
          break;
        }
        $stsiege[$x][$i]++;
        $poswechs=1;
        for ($k=0; $k<=$laeng-24; $k+=8) {
          if (intval(substr($tab[$i][$a],$k+1,7))!=intval(substr($tab[$i][$a+1],$k+1,7))) {
            break;
          }
          if ($k==$laeng-24) {
            $poswechs=0;
          }
        }
        if ($poswechs==1) {
          break;
        }
      }
    }
  }
  
  
  if ($kurvenmodus>1 && $anztipper>0) {
    for ($jyz=0; $jyz<$anzst; $jyz++) {
      for ($a=0; $a<$anztipper; $a++) {
        if ($kurvenmodus<4) {
          $tt=50000000+$tipppunkte[$a][$jyz];
          for ($k=1; $k<=3; $k++) {
            if ($k==1) {
              $tipp_krit=$tipp_krit1;
            } else if ($k==2) {
              $tipp_krit=$tipp_krit2;
            } else if ($k==3) {
              $tipp_krit=$tipp_krit3;
            }
            if ($tipp_krit==-1) {
              $tt.=50000000;
            } else if ($tipp_krit==0) {
              $tt.=(50000000-$spielegetippt[$a][$jyz]);
            } else if ($tipp_krit==1) {
              $tt.=(50000000+$spielegetippt[$a][$jyz]);
            } else if ($tipp_krit==6) {
              if ($tipp_showstsiege==1) {
                $tt.=(50000000+$stsiege[$a][$jyz]);
              }
            } else if ($tipp_showzus==1) {
              if ($tipp_krit==2) {
                $tt.=(50000000+$punkte1[$a][$jyz]);
              } else if ($tipp_krit==3) {
                $tt.=(50000000+$punkte2[$a][$jyz]);
              } else if ($tipp_krit==4) {
                $tt.=(50000000+$punkte3[$a][$jyz]);
              } else if ($tipp_krit==5) {
                $tt.=(50000000+$punkte6[$a][$jyz]);
              }
            }
          }
          $tt.=(50000000+$a);
          array_push($taba[$jyz],$tt);
        }
        if ($kurvenmodus>2) {
          if ($jyz>0) {
            $tipppunktegesamt[$a][$jyz]+=$tipppunktegesamt[$a][$jyz-1];
            if ($tipp_showzus==1) {
              $punkte1gesamt[$a][$jyz]+=$punkte1gesamt[$a][$jyz-1];
              $punkte2gesamt[$a][$jyz]+=$punkte2gesamt[$a][$jyz-1];
              $punkte3gesamt[$a][$jyz]+=$punkte3gesamt[$a][$jyz-1];
              $punkte6gesamt[$a][$jyz]+=$punkte6gesamt[$a][$jyz-1];
            }
            if ($kurvenmodus>1 && $tipp_showstsiege==1 && ($tipp_krit1==6 || $tipp_krit2==6 || $tipp_krit3==6)) {
              $stsiegegesamt[$a][$jyz]+=$stsiegegesamt[$a][$jyz-1];
            }
            $spielegetipptgesamt[$a][$jyz]+=$spielegetipptgesamt[$a][$jyz-1];
          }
          $tt=50000000+$tipppunktegesamt[$a][$jyz];
          for ($k=1; $k<=3; $k++) {
            if ($k==1) {
              $tipp_krit=$tipp_krit1;
            } else if ($k==2) {
              $tipp_krit=$tipp_krit2;
            } else if ($k==3) {
              $tipp_krit=$tipp_krit3;
            }
            if ($tipp_krit==-1) {
              $tt.=50000000;
            } else if ($tipp_krit==0) {
              $tt.=(50000000-$spielegetipptgesamt[$a][$jyz]);
            } else if ($tipp_krit==1) {
              $tt.=(50000000+$spielegetipptgesamt[$a][$jyz]);
            } else if ($tipp_krit==6) {
              if ($tipp_showstsiege==1) {
                $tt.=(50000000+$stsiegegesamt[$a][$jyz]);
              }
            } else if ($tipp_showzus==1) {
              if ($tipp_krit==2) {
                $tt.=(50000000+$punkte1gesamt[$a][$jyz]);
              } else if ($tipp_krit==3) {
                $tt.=(50000000+$punkte2gesamt[$a][$jyz]);
              } else if ($tipp_krit==4) {
                $tt.=(50000000+$punkte3gesamt[$a][$jyz]);
              } else if ($tipp_krit==5) {
                $tt.=(50000000+$punkte6gesamt[$a][$jyz]);
              }
            }
          }
          $tt.=(50000000+$a);
          array_push($tabb[$jyz],$tt);
        }
      }
      if ($kurvenmodus<4) {
        array_shift($taba[$jyz]);
        rsort($taba[$jyz],SORT_STRING);
        $laeng1=strlen($taba[$jyz][0]);
      }
      
      if ($kurvenmodus>2) {
        array_shift($tabb[$jyz]);
        rsort($tabb[$jyz],SORT_STRING);
        $laeng2=strlen($tabb[$jyz][0]);
      }
      
      for ($x=0; $x<$anztipper; $x++) {
        if ($kurvenmodus<4) {
          $x3=intval(substr($taba[$jyz][$x],-7));
          $y=$x;
          if ($spielegetippt[$x3][$jyz]>0) {
            for (;
            $y>0;
            $y--) {
              $poswechs=1;
              for ($k=0; $k<=$laeng1-24; $k+=8) {
                if (intval(substr($taba[$jyz][$y],$k+1,7))!=intval(substr($taba[$jyz][$y-1],$k+1,7))) {
                  break;
                }
                if ($k==$laeng1-24) {
                  $poswechs=0;
                }
              }
              if ($poswechs==1) {
                break;
              }
            }
            $platz[$x3][$jyz]=$y+1;
          }
        }
        
        if ($kurvenmodus>2) {
          $x3=intval(substr($tabb[$jyz][$x],-7));
          $y=$x;
          if ($spielegetippt[$x3][$jyz]>0) {
            for (;
            $y>0;
            $y--) {
              $poswechs=1;
              for ($k=0; $k<=$laeng2-24; $k+=8) {
                if (intval(substr($tabb[$jyz][$y],$k+1,7))!=intval(substr($tabb[$jyz][$y-1],$k+1,7))) {
                  break;
                }
                if ($k==$laeng2-24) {
                  $poswechs=0;
                }
              }
              if ($poswechs==1) {
                break;
              }
            }
            $platz1[$x3][$jyz]=$y+1;
          }
        }
      }
    }
  }
}


?>