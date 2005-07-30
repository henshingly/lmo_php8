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
  
  
require_once(PATH_TO_LMO."/lmo-admintest.php");
if (isset($todo) && $todo != "edit") {
  $file = $liga.".l98";
}
require_once(PATH_TO_ADDONDIR."/tipp/lmo-tippcalcpkt.php");
$dummd = array();
$dumme = array("");
$pswfile = PATH_TO_ADDONDIR."/tipp/".$tipp_tippauthtxt;
 
$dummd = file($pswfile);
 
$auswertfile = PATH_TO_ADDONDIR."/tipp/".$tipp_dirtipp."auswert/".$liga.".aus";
$datenalt = array("");
$nick = "";
 
if ($st >= 0 && file_exists($auswertfile)) {
  $datei = fopen($auswertfile, "rb");
  while (!feof($datei)) {
    $zeile = fgets($datei, 1000);
    $zeile = trim($zeile);
    if ($zeile != "") {
      if ((substr($zeile, 0, 1) == "[") && (substr($zeile, -1) == "]")) {
        $nick = substr($zeile, 1, -1);
        if (!file_exists(PATH_TO_ADDONDIR."/tipp/".$tipp_dirtipp.$liga."_".$nick.".tip")) {
          $nick = "";
        }
      }
      if ($nick != "") {
        array_push($datenalt, $zeile);
      }
    }
  }
  fclose($datei);
}
 
$auswertdatei = fopen($auswertfile, "wb");
if (!$auswertdatei) {
  echo getMessage($text['tipp'][29]." ".$auswertdatei.$text[283],TRUE);
  exit;
}
flock($auswertdatei, 2);
 
if (file_exists(PATH_TO_LMO.'/'.$dirliga.$file)) {
  echo getMessage($text['tipp'][0].': '.$text['tipp'][29]." <var>".$liga."</var> ".$text['tipp'][65]);
  if ($todo != "edit") {
    if ($st != 0) {
      $lmo_only_st=true;
    }
      require(PATH_TO_LMO."/lmo-openfile.php");
  }
  $verz = opendir(PATH_TO_ADDONDIR."/tipp/".$tipp_dirtipp);
  $dummy = array();
  while ($verz && $files = readdir($verz)) {
    if (strtolower(substr($files, 0, strrpos($files, "_"))) == strtolower($liga) && strtolower(substr($files, -4)) == ".tip") {
      array_push($dummy, $files);
    }
  }
  closedir($verz);
   
  $anztipperliga = count($dummy);
   
  if (!isset($start)) {
    $start = 1;
  }
  if (!isset($ende)) {
    $ende = $anztipperliga;
  }
   
  if ($lmtype != 0) {
    $tipp_wertverein = 0;
  }
  if ($tipp_wertverein == 1) {
    $vpunkte = array_pad($array, $anzteams+1, "");
    $vspiele = array_pad($array, $anzteams+1, "");
    for($i = 1; $i <= $anzteams; $i++) {
      $vpunkte[$i] = array_pad(array("0"), $anzst+1, "0");
      $vspiele[$i] = array_pad(array("0"), $anzst+1, "0");
    }
  }
   
  for($l = 0; $l < $anztipperliga; $l++) {
    // durchlaufe alle Tipper
    $tippernick1 = substr($dummy[$l], strrpos($dummy[$l], "_")+1, -4);
    if ($l >= $start-1 && $l <= $ende-1) {
      $tippfile = PATH_TO_ADDONDIR."/tipp/".$tipp_dirtipp.$dummy[$l];
      if (file_exists($tippfile)) {
        $gef = 0;
        for($g = 0; $g < count($dummd) && $gef == 0; $g++) {
          //Tipper tippt diese Liga
          $dumme = explode('|', $dummd[$g]);
          if ($tippernick1 == $dumme[0]) {
            fputs($auswertdatei, "\n[".$dumme[0]."]\n");
            fputs($auswertdatei, "Team=".$dumme[5]."\n");
            if ($tipp_showname == 1) {
              fputs($auswertdatei, "Name=".$dumme[3]."\n");
            }
            if ($tipp_showemail == 1) {
              fputs($auswertdatei, "Email=".$dumme[4]."\n");
            }
            $gef = 1;
          }
        }
        if ($gef == 1) {
          if ($st == 0) {
            require(PATH_TO_ADDONDIR."/tipp/lmo-tippopenfileall.php");
          } else {
            require(PATH_TO_ADDONDIR."/tipp/lmo-tippopenfile.php");
          }
           
          $st1 = $st;
          for($st0 = 0; $st0 < $anzst; $st0++) {
            if ($st > 0) {
              $st0 = $anzst;
            } else {
              $st1 = $st0+1;
            }
             
            $spielegetippt = 0;
            $tp = 0;
            if ($tipp_showzus == 1) {
              if ($tipp_tippmodus == 1) {
                $punkte1 = 0;
                $punkte2 = 0;
                $punkte3 = 0;
                $punkte4 = 0;
              }
              $punkte5 = 0;
              $punkte6 = 0;
            }
             
            for($i = 0; $i < $anzsp; $i++) {
              if ($lmtype == 0) {
                if ($tipp_jokertipp == 1 && (($st == 0 && $jksp[$st0] == $i+1) || $jksp == $i+1)) {
                  $jkspfaktor = $tipp_jokertippmulti;
                } else {
                  $jkspfaktor = 1;
                }
                $punktespiel = -1;
                if ($st == 0) {
                  if ($goaltippa[$st0][$i] != "_" && $goala[$st0][$i] != "_") {
                    $punktespiel = tipppunkte($goaltippa[$st0][$i], $goaltippb[$st0][$i], $goala[$st0][$i], $goalb[$st0][$i], $msieg[$st0][$i], $mspez[$st0][$i], $text[0], $text[1], $jkspfaktor, $mtipp[$st0][$i]);
                  }
                } elseif($goaltippa[$i] != "_" && $goala[$st-1][$i] != "_" && $goala[$st-1][$i] > -1) {
                  $punktespiel = tipppunkte($goaltippa[$i], $goaltippb[$i], $goala[$st-1][$i], $goalb[$st-1][$i], $msieg[$st-1][$i], $mspez[$st-1][$i], $text[0], $text[1], $jkspfaktor, $mtipp[$st-1][$i]);
                }
                if ($punktespiel > -1) {
                  $spielegetippt++;
                }
                if ($punktespiel > 0) {
                  $tp += $punktespiel;
                }
                if ($tipp_wertverein == 1) {
                  if ($punktespiel > 0) {
                    $vpunkte[$teama[$st1-1][$i]][$st1] += $punktespiel;
                    $vpunkte[$teamb[$st1-1][$i]][$st1] += $punktespiel;
                  }
                  if ($punktespiel > -1) {
                    $vspiele[$teama[$st1-1][$i]][$st1]++;
                    $vspiele[$teamb[$st1-1][$i]][$st1]++;
                  }
                }
              } else {
                if ($st==0) {
                  $modus[$st-1]=0;
                }
                for($n = 0; $n < $modus[$st-1]; $n++) {
                  if ($tipp_jokertipp == 1 && (($st == 0 && $jksp[$st0] == ($i+1).($n+1)) || $jksp == ($i+1).($n+1))) {
                    $jkspfaktor = $tipp_jokertippmulti;
                  } else {
                    $jkspfaktor = 1;
                  }
                  $punktespiel = -1;
                  if ($st == 0) {
                    if ($goaltippa[$st0][$i][$n] != "_" && $goala[$st0][$i][$n] != "_") {
                      $punktespiel = tipppunkte($goaltippa[$st0][$i][$n], $goaltippb[$st0][$i][$n], $goala[$st0][$i][$n], $goalb[$st0][$i][$n], 0, $mspez[$st0][$i][$n], $text[0], $text[1], $jkspfaktor, $mtipp[$st0][$i][$n]);
                    }
                  } elseif($goaltippa[$i][$n] != "_" && $goala[$st-1][$i][$n] != "_" && $goala[$st-1][$i][$n] > -1 ) {
                    $punktespiel = tipppunkte($goaltippa[$i][$n], $goaltippb[$i][$n], $goala[$st-1][$i][$n], $goalb[$st-1][$i][$n], 0, $mspez[$st-1][$i][$n], $text[0], $text[1], $jkspfaktor, $mtipp[$st-1][$i][$n]);
                  }
                  if ($punktespiel > -1) {
                    $spielegetippt++;
                  }
                  if ($punktespiel > 0) {
                    $tp += $punktespiel;
                  }
                }
              } // ende else
            } // ende for($i=1;$j<=$anzsp;$i++)
            if ($spielegetippt > 0) {
              fputs($auswertdatei, "SG".$st1."=".$spielegetippt."\n");
            }
            if ($tipp_showzus == 1) {
              if ($tipp_tippmodus == 1) {
                if ($punkte1 > 0) {
                  fputs($auswertdatei, "P1".$st1."=".$punkte1."\n");
                }
                if ($punkte2 > 0) {
                  fputs($auswertdatei, "P2".$st1."=".$punkte2."\n");
                }
                if ($punkte3 > 0) {
                  fputs($auswertdatei, "P3".$st1."=".$punkte3."\n");
                }
                if ($punkte4 > 0) {
                  fputs($auswertdatei, "P4".$st1."=".$punkte4."\n");
                }
              }
              if ($punkte5 > 0) {
                fputs($auswertdatei, "P5".$st1."=".$punkte5."\n");
              }
              if ($punkte6 > 0) {
                fputs($auswertdatei, "P6".$st1."=".$punkte6."\n");
              }
            }
            if ($tp > 0) {
              fputs($auswertdatei, "TP".$st1."=".$tp."\n");
            }
          } // ende for($st0=1;$st0<$anzst;$st0++)
           
          //if(!isset($dat)){$dat=0;}
          //if($dat>=count($datenalt)){$dat=0;}
          if ($st > 0) {
            $dat = 0;
            while ($tippernick1 != substr($datenalt[$dat], 1, -1) && $dat < (count($datenalt)-1)) {
              $dat++;
            }
            $nick = substr($datenalt[$dat], 1, -1);
            if ($nick == $tippernick1) {
              $dat++;
              while ($dat < count($datenalt) && $nick == $tippernick1) {
                //////////// nur die unveränderten Spieltage werden zurückgeschrieben
                if ((substr($datenalt[$dat], 0, 1) == "[") && (substr($datenalt[$dat], -1) == "]")) {
                  $nick = substr($datenalt[$dat], 1, -1);
                } else {
                  if (substr($datenalt[$dat], 2, strpos($datenalt[$dat], "=")-2) != $st && substr($datenalt[$dat], 0, 4) != "Team" && substr($datenalt[$dat], 0, 4) != "Name" && substr($datenalt[$dat], 0, 5) != "Email") {
                    fputs($auswertdatei, $datenalt[$dat]."\n");
                  }
                  //$dat++;
                }
                $dat++;
              }
            }
          } // ende if($st>0)
          if ($tipp_wertverein == 1) {
            $tipp_wertvereinfile = PATH_TO_ADDONDIR."/tipp/".$tipp_dirtipp."auswert/vereine/".$liga."_".$tippernick1.".ver";
            $datenalt1 = array("");
            $verein = "";
             
            if ($st > 0 && file_exists($tipp_wertvereinfile)) {
              $datei = fopen($tipp_wertvereinfile, "rb");
              if ($datei){
                while (!feof($datei)) {
                  $zeile = fgets($datei, 1000);
                  $zeile = trim(chop($zeile));
                  if ($zeile != "") {
                    if ((substr($zeile, 0, 1) == "[") && (substr($zeile, -1) == "]")) {
                      $verein = substr($zeile, 1, -1);
                    }
                    if ($verein != "") {
                      array_push($datenalt1, $zeile);
                    }
                  }
                }
                fclose($datei);
              }
            }
            $tipp_wertvereindatei = fopen($tipp_wertvereinfile, "wb");
            if ($tipp_wertvereindatei) {
              flock($tipp_wertvereindatei, 2);
               
              for($i = 1; $i <= $anzteams; $i++) {
                fputs($tipp_wertvereindatei, "[".$i."]"."\n");
                $anzst1 = $anzst;
                for($j = 1; $j <= $anzst1; $j++) {
                  if ($st > 0) {
                    $j = $st;
                    $anzst1 = $st;
                    $dat = 0;
                    //if(!isset($dat)){$dat=0;}
                    //if($dat>=count($datenalt1)){$dat=0;}
                    while ($datenalt1[$dat] != "[".$i."]" && $dat < (count($datenalt1)-1)) {
                      $dat++;
                    }
                    $verein = substr($datenalt1[$dat], 1, -1);
                    if ($verein == $i) {
                      $dat++;
                      while ($dat < count($datenalt1) && $verein == $i) {
                        if ((substr($datenalt1[$dat], 0, 1) == "[") && (substr($datenalt1[$dat], -1) == "]")) {
                          $verein = substr($datenalt1[$dat], 1, -1);
                        } else {
                          if (substr($datenalt1[$dat], 2, strpos($datenalt1[$dat], "=")-2) != $st) {
                            fputs($tipp_wertvereindatei, $datenalt1[$dat]."\n");
                          }
                          $dat++;
                        }
                      }
                    }
                  }
                  if ($vpunkte[$i][$j] > 0) {
                    fputs($tipp_wertvereindatei, "TP".$j."=".$vpunkte[$i][$j]."\n");
                    $vpunkte[$i][$j] = 0;
                  }
                  if ($vspiele[$i][$j] > 0) {
                    fputs($tipp_wertvereindatei, "SG".$j."=".$vspiele[$i][$j]."\n");
                    $vspiele[$i][$j] = 0;
                  }
                }
              }
              flock($tipp_wertvereindatei, 3);
              fclose($tipp_wertvereindatei);
            }
          }
        } // ende if($gef==1)
      } // ende if(file_exists($tippfile))
    } // ende if($l>=$start-1 && $l<=$ende-1)
    else
      {
      // nicht ausgewertete Tipper zurück schreiben
      $nick = "";
      for($i = 0; $i < count($datenalt); $i++) {
        $zeile = $datenalt[$i];
        if ($zeile != "") {
          if ((substr($zeile, 0, 1) == "[") && (substr($zeile, -1) == "]")) {
            $nick = substr($zeile, 1, -1);
          }
          if ($nick == $tippernick1) {
            fputs($auswertdatei, $datenalt[$i]."\n");
          }
        }
      } // ende for($i=0;$i<count($datenalt);$i++)
    } // ende else
  } // ende for($l=0;$l<$anztipperliga;$l++)
  flock($auswertdatei, 3);
  fclose($auswertdatei);
} // ende if(file_exists($file))
 
clearstatcache();
if (isset($todo) && $todo != "edit") {
  $file = "";
}

?>