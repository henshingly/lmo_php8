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
 * @var \Lmo\Liga\LigaDaten $ligaDaten Daten der geladenen Liga (lmo-ligadaten.php); nur nach dem Speichern im Adminbereich
 * @var \Lmo\Liga\Rohdaten\Liga|null $lmo_liga Rohdaten der geladenen Liga (lmo-openfile.php)
 * @var array<int|string, mixed> $text Sprachtexte
 * @var string $file Ligadatei relativ zum Ligenordner, leer wenn keine geladen ist
 * @var int|string $st gewaehlter Spieltag
 * @var string $dirliga Ligenordner relativ zum LMO (Konfiguration)
 * @var array<int|string, mixed> $array leeres Array als Vorlage fuer array_pad()
 *
 * Einstellungen:
 * @var int|string $tipp_dirtipp Einstellung aus tipp/cfg.txt
 * @var int|string $tipp_jokertipp Einstellung aus tipp/cfg.txt
 * @var int|string $tipp_jokertippmulti Einstellung aus tipp/cfg.txt
 * @var int|string $tipp_showemail Einstellung aus tipp/cfg.txt
 * @var int|string $tipp_showname Einstellung aus tipp/cfg.txt
 * @var int|string $tipp_showzus Einstellung aus tipp/cfg.txt
 * @var int|string $tipp_tippauthtxt Einstellung aus tipp/cfg.txt
 * @var int|string $tipp_tippmodus Einstellung aus tipp/cfg.txt
 *
 * Weitere Variablen des einbindenden Codes:
 * @var array<int|string, mixed> $goaltippa
 * @var array<int|string, mixed> $goaltippb
 * @var array<int|string, mixed> $jksp
 * @var mixed $liga
 *
 * Werden auch in dieser Datei gesetzt, aber nicht auf jedem Weg (koennen von aussen kommen):
 * @var mixed $punkte1
 * @var mixed $punkte2
 * @var mixed $punkte3
 * @var mixed $punkte4
 * @var mixed $punkte5
 * @var mixed $punkte6
 * @var mixed $tipp_wertverein
 * @var array<int|string, mixed> $vpunkte
 * @var array<int|string, mixed> $vspiele
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
  echo getMessage($text['tipp'][29]." ".$auswertdatei.$text[283],true);
  exit;
}
flock($auswertdatei, 2);
 
if (file_exists(PATH_TO_LMO.'/'.$dirliga.$file)) {
  echo getMessage($text['tipp'][0].': '.$text['tipp'][29]." <var>".$liga."</var> ".$text['tipp'][65]);
  if ($todo != "edit") {
    require(PATH_TO_LMO."/lmo-openfile.php");
  } else {
    // nach dem Speichern im Adminbereich: der gerade eingegebene Stand, nicht der beim Oeffnen der Seite gelesene
    $lmo_liga = $ligaDaten->alsRohdaten($text[54], $ligaDaten->stx, $text[0], $text[1]);
  }
  // auch die Tipp-Lader (lmo-tippopenfile.php, lmo-tippopenfileall.php) arbeiten auf $lmo_liga
  $lmo_liga = $lmo_liga ?? new \Lmo\Liga\Rohdaten\Liga();
  $lmo_wert_liga = $lmo_liga;
  // Einstellungen der Liga; die Spieltage aus Sicht des Tippspiels (Lmo\Tipp\Tipprunde) je Nummer
  $lmo_wert_einstellungen = $lmo_wert_liga->einstellungen();
  $lmo_wert_pokal = $lmo_wert_einstellungen->istPokal();
  $lmo_wert_spieltage = $lmo_wert_einstellungen->spieltage();
  $lmo_wert_mannschaften = $lmo_wert_einstellungen->mannschaften();
  $lmo_wert_runden = array();
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
   
  if ($lmo_wert_pokal) {
    $tipp_wertverein = 0;
  }
  if ($tipp_wertverein == 1) {
    $vpunkte = array_pad($array, $lmo_wert_mannschaften+1, "");
    $vspiele = array_pad($array, $lmo_wert_mannschaften+1, "");
    for ($i = 1; $i <= $lmo_wert_mannschaften; $i++) {
      $vpunkte[$i] = array_pad(array("0"), $lmo_wert_spieltage+1, "0");
      $vspiele[$i] = array_pad(array("0"), $lmo_wert_spieltage+1, "0");
    }
  }
   
  for ($l = 0; $l < $anztipperliga; $l++) {
    // durchlaufe alle Tipper
    $tippernick1 = substr($dummy[$l], strrpos($dummy[$l], "_")+1, -4);
    if ($l >= $start-1 && $l <= $ende-1) {
      $tippfile = PATH_TO_ADDONDIR."/tipp/".$tipp_dirtipp.$dummy[$l];
      if (file_exists($tippfile)) {
        $gef = 0;
        for ($g = 0; $g < count($dummd) && $gef == 0; $g++) {
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
          for ($st0 = 0; $st0 < $lmo_wert_spieltage; $st0++) {
            if ($st > 0) {
              $st0 = $lmo_wert_spieltage;
            } else {
              $st1 = $st0+1;
            }
            // der ausgewertete Spieltag $st1: Paarung $i+1 hat den Index $i, ihr Spiel $n+1 den Index $n
            $lmo_wert_runden[$st1] ??= \Lmo\Tipp\Tipprunde::fuer($lmo_wert_liga, (int)$st1);
            $lmo_wert_runde = $lmo_wert_runden[$st1];
            // im Pokal zaehlt nur die Auswertung einer einzelnen Runde ($st > 0)
            $lmo_wert_modus = $st == 0 ? 0 : $lmo_wert_runde->spieleJePaarung;
             
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
             
            for ($i = 0; $i < $lmo_wert_runde->plaetze; $i++) {
              if (!$lmo_wert_pokal) {
                $lmo_wert_spiel = $lmo_wert_runde->paarungen[$i]->spiele[0];
                if ($tipp_jokertipp == 1 && (($st == 0 && $jksp[$st0] == $i+1) || $jksp == $i+1)) {
                  $jkspfaktor = $tipp_jokertippmulti;
                } else {
                  $jkspfaktor = 1;
                }
                $punktespiel = -1;
                if ($st == 0) {
                  if ($goaltippa[$st0][$i] != "_" && $lmo_wert_spiel->toreHeim !== null) {
                    $punktespiel = tipppunkte($goaltippa[$st0][$i], $goaltippb[$st0][$i], $lmo_wert_spiel->toreHeimText(), $lmo_wert_spiel->toreGastText(), $lmo_wert_spiel->wertung, $lmo_wert_spiel->zusatzText($text[0], $text[1]), $text[0], $text[1], $jkspfaktor, (int)$lmo_wert_spiel->ohneTippwertung);
                  }
                } elseif ($goaltippa[$i] != "_" && $lmo_wert_spiel->toreHeim !== null && $lmo_wert_spiel->toreHeim > -1) {
                  $punktespiel = tipppunkte($goaltippa[$i], $goaltippb[$i], $lmo_wert_spiel->toreHeimText(), $lmo_wert_spiel->toreGastText(), $lmo_wert_spiel->wertung, $lmo_wert_spiel->zusatzText($text[0], $text[1]), $text[0], $text[1], $jkspfaktor, (int)$lmo_wert_spiel->ohneTippwertung);
                }
                if ($punktespiel > -1) {
                  $spielegetippt++;
                }
                if ($punktespiel > 0) {
                  $tp += $punktespiel;
                }
                if ($tipp_wertverein == 1) {
                  if ($punktespiel > 0) {
                    $vpunkte[$lmo_wert_spiel->heim][$st1] += $punktespiel;
                    $vpunkte[$lmo_wert_spiel->gast][$st1] += $punktespiel;
                  }
                  if ($punktespiel > -1) {
                    $vspiele[$lmo_wert_spiel->heim][$st1]++;
                    $vspiele[$lmo_wert_spiel->gast][$st1]++;
                  }
                }
              } else {
                for ($n = 0; $n < $lmo_wert_modus; $n++) {
                  $lmo_wert_spiel = $lmo_wert_runde->paarungen[$i]->spiele[$n];
                  if ($tipp_jokertipp == 1 && (($st == 0 && $jksp[$st0] == ($i+1).($n+1)) || $jksp == ($i+1).($n+1))) {
                    $jkspfaktor = $tipp_jokertippmulti;
                  } else {
                    $jkspfaktor = 1;
                  }
                  $punktespiel = -1;
                  if ($st == 0) {
                    if ($goaltippa[$st0][$i][$n] != "_" && $lmo_wert_spiel->toreHeim !== null) {
                      $punktespiel = tipppunkte($goaltippa[$st0][$i][$n], $goaltippb[$st0][$i][$n], $lmo_wert_spiel->toreHeimText(), $lmo_wert_spiel->toreGastText(), 0, $lmo_wert_spiel->zusatzText($text[0], $text[1]), $text[0], $text[1], $jkspfaktor, (int)$lmo_wert_spiel->ohneTippwertung);
                    }
                  } elseif ($goaltippa[$i][$n] != "_" && $lmo_wert_spiel->toreHeim !== null && $lmo_wert_spiel->toreHeim > -1) {
                    $punktespiel = tipppunkte($goaltippa[$i][$n], $goaltippb[$i][$n], $lmo_wert_spiel->toreHeimText(), $lmo_wert_spiel->toreGastText(), 0, $lmo_wert_spiel->zusatzText($text[0], $text[1]), $text[0], $text[1], $jkspfaktor, (int)$lmo_wert_spiel->ohneTippwertung);
                  }
                  if ($punktespiel > -1) {
                    $spielegetippt++;
                  }
                  if ($punktespiel > 0) {
                    $tp += $punktespiel;
                  }
                }
              } // ende else
            } // ende for ($i=1;$j<=$anzsp;$i++)
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
          } // ende for ($st0=1;$st0<$anzst;$st0++)
           
          //if (!isset($dat)){$dat=0;}
          //if ($dat>=count($datenalt)){$dat=0;}
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
          } // ende if ($st>0)
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
               
              for ($i = 1; $i <= $lmo_wert_mannschaften; $i++) {
                fputs($tipp_wertvereindatei, "[".$i."]"."\n");
                $anzst1 = $lmo_wert_spieltage;
                for ($j = 1; $j <= $anzst1; $j++) {
                  if ($st > 0) {
                    $j = $st;
                    $anzst1 = $st;
                    $dat = 0;
                    //if (!isset($dat)){$dat=0;}
                    //if ($dat>=count($datenalt1)){$dat=0;}
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
        } // ende if ($gef==1)
      } // ende if (file_exists($tippfile))
    } // ende if ($l>=$start-1 && $l<=$ende-1)
    else
      {
      // nicht ausgewertete Tipper zurück schreiben
      $nick = "";
      for ($i = 0; $i < count($datenalt); $i++) {
        $zeile = $datenalt[$i];
        if ($zeile != "") {
          if ((substr($zeile, 0, 1) == "[") && (substr($zeile, -1) == "]")) {
            $nick = substr($zeile, 1, -1);
          }
          if ($nick == $tippernick1) {
            fputs($auswertdatei, $datenalt[$i]."\n");
          }
        }
      } // ende for ($i=0;$i<count($datenalt);$i++)
    } // ende else
  } // ende for ($l=0;$l<$anztipperliga;$l++)
  flock($auswertdatei, 3);
  fclose($auswertdatei);
} // ende if (file_exists($file))
 
clearstatcache();
if (isset($todo) && $todo != "edit") {
  $file = "";
}

?>