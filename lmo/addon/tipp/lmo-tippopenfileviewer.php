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
 * @var list<\Lmo\Tipp\AnstehendesSpiel> $lmo_spiele anstehende Spiele aller Ligen (wird hier ergaenzt)
 * @var array<int|string, mixed> $text Sprachtexte
 * @var string $file Ligadatei relativ zum Ligenordner, leer wenn keine geladen ist
 * @var string $dirliga Ligenordner relativ zum LMO (Konfiguration)
 * @var string $tippfile Tippdatei des Tippspiels
 *
 * Einstellungen:
 * @var int|string $deftime Einstellung aus cfg.txt
 * @var int|string $tipp_jokertipp Einstellung aus tipp/cfg.txt
 * @var int|string $tipp_tippohne Einstellung aus tipp/cfg.txt
 *
 * Weitere Variablen des einbindenden Codes:
 * @var array<int|string, mixed> $dateien
 * @var mixed $liga
 * @var mixed $liganr
 * @var mixed $now
 * @var mixed $spiel
 * @var mixed $spieltag
 * @var mixed $then
 *
 * Werden auch in dieser Datei gesetzt, aber nicht auf jedem Weg (koennen von aussen kommen):
 * @var mixed $anzspiele
 * @var mixed $datm0
 * @var mixed $dats0
 * @var mixed $datum10
 * @var mixed $datum20
 * @var mixed $dummy1
 * @var mixed $dummy2
 * @var mixed $goala0
 * @var mixed $goalb0
 * @var mixed $goalfaktor0
 * @var mixed $hidr0
 * @var array<int|string, mixed> $jksp
 * @var mixed $mberi0
 * @var mixed $mnote0
 * @var mixed $modus0
 * @var mixed $rb
 * @var mixed $teama0
 * @var mixed $teamb0
 * @var array<int|string, mixed> $tipp_jokertippaktiv
 * @var array<int|string, mixed> $tippa
 * @var mixed $tippa0
 * @var array<int|string, mixed> $tippb
 * @var mixed $titel0
 * @var mixed $urlb0
 */



if ($file != "") {

  $me = array("0", "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
  $liga0 = substr($dateien[$liganr], 0, -4);
  $lmtype0 = 0;
  if (substr($tippfile, -4) != ".tip") {
    exit;
  }
  if (substr($file, -4) == ".l98") {
    // die ganze Liga als Rohdaten (Lmo\Liga\Rohdaten\Liga) und ihre Einstellungen mit Vorgabewerten
    $lmo_liga = \Lmo\Liga\Rohdaten\Liga::lies(PATH_TO_LMO.'/'.$dirliga.basename($file));
    $lmo_einstellungen = $lmo_liga->einstellungen();
    $lmo_pokal = $lmo_liga->istPokal();
    $titel0 = $lmo_einstellungen->wert('Name');
    $lmtype0 = $lmo_einstellungen->wert('Type');
    $goalfaktor0 = $lmo_einstellungen->wert('goalfaktor');
    $urlb0 = $lmo_einstellungen->wert('urlB');
    $hidr0 = $lmo_einstellungen->wert('HideDraw') ?? 0;
    $dats0 = $lmo_einstellungen->wert('DatS');
    $datm0 = $lmo_einstellungen->wert('DatM');
    $lmo_favteam = $lmo_einstellungen->wert('favTeam');
    clearstatcache();

    $tippdaten = array();
    $sekt = "";
    $jkwert = "";
    $datei = fopen($tippfile, "rb");
    if ($datei == false) {
      exit;
    }
    while (!feof($datei)) {
      $zeile = fgets($datei, 1000);
      $zeile = chop($zeile);
      $zeile = trim($zeile);
      if ((substr($zeile, 0, 1) == "@") && (substr($zeile, -1) == "@")) {
        $jkwert = trim(substr($zeile, 1, -1));
      } elseif ((substr($zeile, 0, 1) == "[") && (substr($zeile, -1) == "]")) {
        $sekt = trim(substr($zeile, 1, -1));
      } elseif ((str_contains($zeile, '=')) && (substr($zeile, 0, 1) != ';')) {
      //elseif ((strpos($zeile, "=") != false) && (substr($zeile, 0, 1) != ";")) {
        $schl = trim(substr($zeile, 0, strpos($zeile, "=")));
        $wert = trim(substr($zeile, strpos($zeile, "=")+1));
        array_push($tippdaten, $sekt."|".$schl."|".$wert."|".$jkwert."|EOL");
      }
    }
    fclose($datei);

    $anzst0 = strlen(decbin((int)$lmo_einstellungen->wert('Teams')-1));
    foreach ($lmo_liga->spieltage as $lmo_spieltag_nr => $lmo_spieltag) {
      $spieltag0 = (string)$lmo_spieltag_nr;
      // Datum des Spieltags in der Form TT.MM.JJJJ und als Zeit; ein Datum, das es nicht gibt, zaehlt als leer
      $datum10 = $datum20 = "";
      $dummy1 = $dummy2 = "";
      foreach (array('D1', 'D2') as $lmo_schl) {
        $lmo_zeit = $lmo_schl == 'D1' ? $lmo_spieltag->ersterTag() : $lmo_spieltag->letzterTag();
        if ($lmo_zeit !== null) {
          if ($lmo_schl == 'D1') {
            $datum10 = date("d.m.Y", $lmo_zeit);
          } else {
            $datum20 = date("d.m.Y", $lmo_zeit);
          }
          if ($tipp_tippohne == 1 && $deftime > 0) {
            $lmo_zeit = $lmo_zeit+substr($deftime, 0, 2) * 60 * 60+substr($deftime, 3, 2) * 60;
          }
          if ($lmo_schl == 'D1') {
            $dummy1 = $lmo_zeit;
          } else {
            $dummy2 = $lmo_zeit;
          }
        }
      }
      // Spiele je Paarung: in der Liga eines, im Pokal nach dem Modus der Runde
      $modus0 = $lmo_pokal ? ($lmo_spieltag->werte['MO'] ?? '1') : 1;
      foreach ($lmo_spieltag->partien as $lmo_partie_nr => $lmo_partie) {
        foreach ($lmo_partie->spiele as $lmo_spiel_nr => $lmo_werte) {
          // jedes Spiel mit seinen eigenen Werten; ohne Mannschaft oder ohne Anstosszeile (AT) ist es keines
          if (!($lmo_partie->heim > 0) || !isset($lmo_werte['AT'])) {
            continue;
          }
          $teama0 = $lmo_partie->heim;
          $teamb0 = $lmo_partie->gast ?? 0;
          $goala0 = $lmo_werte['GA'] ?? '';
          $goalb0 = $lmo_werte['GB'] ?? '';
          $mspez0 = $lmo_werte['SP'] ?? 0;
          $msieg0 = (!$lmo_pokal && ($lmo_werte['ET'] ?? '') == 3) ? 3 : 0;
          $mnote0 = addslashes($lmo_werte['NT'] ?? '');
          $mberi0 = addslashes($lmo_werte['BE'] ?? '');
          $mtipp0 = $lmo_werte['TI'] ?? 0;
          $mterm0 = $lmo_werte['AT'];
          $btip = false;
          if ($mterm0 > 0) {
            if ($now <= $mterm0 && $then > $mterm0) {
              $btip = true;
            }
          } elseif ($dummy1 > 0) {
            if ($now <= $dummy1 && $then > $dummy1) {
              $btip = true;
            }
          } elseif ($dummy2 > 0) {
            if ($now <= $dummy2 && $then > $dummy2) {
              $btip = true;
            }
          }
          if ($btip == true) {
            // Nummer des Spiels wie im Schluessel der Datei: Partie, im Pokal gefolgt vom Spiel der Paarung
            $spiel0 = $lmo_pokal ? $lmo_partie_nr.$lmo_spiel_nr : (string)$lmo_partie_nr;

            // Name zum Anzeigen; die Lieblingsmannschaft der Liga ist hervorgehoben
            $lmo_namen = array();
            foreach (array($teama0, $teamb0) as $lmo_nr) {
              $lmo_name = $lmo_nr > 0 ? $lmo_liga->mannschaftsname($lmo_nr) : '___';
              $lmo_namen[] = $lmo_favteam == $lmo_nr ? "<strong>".$lmo_name."</strong>" : $lmo_name;
            }
            if ($goala0 == "") {
              $goala0 = -1;
            }
            if ($goala0 == "-1") {
              $goala0 = "_";
            }
            if ($goala0 == "-2") {
              $msieg0 = 1;
              $goala0 = 0;
            }
            if ($goalb0 == "") {
              $goalb0 = -1;
            }
            if ($goalb0 == "-1") {
              $goalb0 = "_";
            }
            if ($goalb0 == "-2") {
              $msieg0 = 2;
              $goalb0 = 0;
            }
            if ($mspez0 == 0) {
              $mspez0 = "&nbsp;";
            }
            if ($mspez0 == 2) {
              $mspez0 = $text[0];
            }
            if ($mspez0 == 1) {
              $mspez0 = $text[1];
            }

            $lmo_spiel = new \Lmo\Tipp\AnstehendesSpiel();
            $lmo_spiel->titel = $titel0;
            $lmo_spiel->typ = $lmtype0;
            $lmo_spiel->runden = $anzst0;
            $lmo_spiel->ohneUnentschieden = $hidr0;
            $lmo_spiel->mitSpieltagsdatum = $dats0;
            $lmo_spiel->mitAnstosszeit = $datm0;
            $lmo_spiel->mitSpielbericht = $urlb0;
            $lmo_spiel->mitZusatz = $lmo_einstellungen->wert('Spez');
            $lmo_spiel->torfaktor = $goalfaktor0;
            $lmo_spiel->spieleJePaarung = $modus0;
            $lmo_spiel->ersterTag = $datum10;
            $lmo_spiel->letzterTag = $datum20;
            $lmo_spiel->heim = $lmo_namen[0];
            $lmo_spiel->gast = $lmo_namen[1];
            $lmo_spiel->toreHeim = $goala0;
            $lmo_spiel->toreGast = $goalb0;
            $lmo_spiel->zusatz = $mspez0;
            $lmo_spiel->wertung = $msieg0;
            $lmo_spiel->notiz = $mnote0;
            $lmo_spiel->bericht = $mberi0;
            $lmo_spiel->ohneTippwertung = $mtipp0;
            $lmo_spiel->anstoss = $mterm0;
            $lmo_spiele[] = $lmo_spiel;
            array_push($liga, $liga0);
            array_push($spieltag, $spieltag0);
            array_push($spiel, $spiel0);
            array_push($tippa, "");
            array_push($tippb, "");
            array_push($jksp, "");
            array_push($tipp_jokertippaktiv, "0");
            $anzspiele++;
            for ($j = 1; $j <= count($tippdaten); $j++) {
              $dum1 = explode('|', $tippdaten[$j-1]);
              $op8 = substr($dum1[1], 0, 2);
              if ($op8 == "GA") {
                $tippa0 = $dum1[2];
              } elseif ($op8 == "GB") {
                $tippb0 = $dum1[2];

                $spieltag0t = substr($dum1[0], 5);
                $spiel0t = substr($dum1[1], 2);
                if ($spieltag0t == $spieltag0 && $spiel0t == $spiel0) {
                  if ($tippa0 == "") {
                    $tippa0 = -1;
                  }
                  if ($tippa0 == "-1") {
                    $tippa0 = "_";
                  }
                  if ($tippb0 == "") {
                    $tippb0 = -1;
                  }
                  if ($tippb0 == "-1") {
                    $tippb0 = "_";
                  }
                  $tippa[$anzspiele-1] = $tippa0;
                  $tippb[$anzspiele-1] = $tippb0;
                  if ($tipp_jokertipp == 1) {
                    if ($dum1[3] == $spiel0t) {
                      $jksp[$anzspiele-1] = $spiel0t;
                    } else {
                      $jksp[$anzspiele-1] = 0;
                    }

                    if ($dum1[3] > 0) {
                      // Anstoss des Jokerspiels in diesem Spieltag
                      foreach ($lmo_spieltag->partien as $lmo_jk_partie_nr => $lmo_jk_partie) {
                        foreach ($lmo_jk_partie->spiele as $lmo_jk_spiel_nr => $lmo_jk_werte) {
                          $lmo_jk_spiel = $lmo_pokal ? $lmo_jk_partie_nr.$lmo_jk_spiel_nr : (string)$lmo_jk_partie_nr;
                          if (isset($lmo_jk_werte['AT']) && $lmo_jk_spiel == $dum1[3]) {
                            $tipp_jokertippaktiv[$anzspiele-1] = zeit($lmo_jk_werte['AT'], $datum10, $datum20);
                            break 2;
                          }
                        }
                      }
                    }
                  }
                  break;
                }
              }
            }
          }
        }
      }
    }
  }
}
clearstatcache();
?>