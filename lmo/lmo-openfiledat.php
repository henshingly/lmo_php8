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
 * @var string $file Ligadatei relativ zum Ligenordner, leer wenn keine geladen ist
 * @var int|string|null $st gewaehlter Spieltag
 * @var string $dirliga Ligenordner relativ zum LMO (Konfiguration)
 * @var string $defdateformat Datumsformat in date()-Schreibweise (Konfiguration)
 * @var array<int|string, mixed> $array leeres Array als Vorlage fuer array_pad()
 *
 * Weitere Variablen des einbindenden Codes:
 * @var array<int|string, mixed> $me
 */

// $ligaDaten bereitstellen (auch wenn dieser Lader innerhalb einer Funktion laeuft)
require(PATH_TO_LMO . '/lmo-ligadaten.php');
  
  
if ($file != "") {
  if (substr($file, -4) == ".l98") {
    $stand=date($defdateformat,filemtime(PATH_TO_LMO.'/'.$dirliga.$file));
    // Abschnitte, Schluessel und Werte der Datei (Lmo\Liga\LigaDatei)
    $lmo_eintraege=\Lmo\Liga\LigaDatei::lies(PATH_TO_LMO.'/'.$dirliga.$file);
    $lmo_hat_options = false;
    foreach ($lmo_eintraege as list($sekt, $schl, $wert)) {
      if ($sekt == "Options") {
        $lmo_hat_options = true;
        if ($schl == "Actual" && !isset($st)) {
          $st = $wert;
        }
      }
    }
    // dieser Lader liest nur Name, Typ und Groesse der Liga und den Spielplan eines Spieltags
    $ligaDaten->setzeOptionen($lmo_eintraege, array('Name', 'goalfaktor', 'Type', 'Teams', 'Rounds', 'Matches', 'Actual', 'KlFin'));
    // ohne Angabe ist es eine Liga (nur wenn die Datei ueberhaupt Options enthaelt, wie bisher)
    if ($lmo_hat_options && !isset($ligaDaten->lmtype)) {
      $ligaDaten->lmtype = 0;
    }
    // Name, Datumsanzeige und Groesse des Spielplans, soweit die Datei sie nicht nennt
    $ligaDaten->ergaenzeGrunddaten();
    $ligaDaten->teams = array_pad($array, $ligaDaten->anzteams+2, "");
    if ($ligaDaten->lmtype == 0) {
      $ligaDaten->datum1 = array_pad($array, 116, "");
      $ligaDaten->datum2 = array_pad($array, 116, "");
      $ligaDaten->teama = array_pad($array, 116, "");
      $ligaDaten->teamb = array_pad($array, 116, "");
      $ligaDaten->mterm = array_pad($array, 116, "");
      for ($i = 0; $i < 116; $i++) {
        $ligaDaten->teama[$i] = array_pad(array("0"), 40, "0");
        $ligaDaten->teamb[$i] = array_pad(array("0"), 40, "0");
        $ligaDaten->mterm[$i] = array_pad(array("0"), 40, "0");
      }
    } else {
      $ligaDaten->datum1 = array_pad($array, 7, "");
      $ligaDaten->datum2 = array_pad($array, 7, "");
      $ligaDaten->modus = array_pad(array("1"), 7, "1");
      $ligaDaten->teama = array_pad($array, 7, "");
      $ligaDaten->teamb = array_pad($array, 7, "");
      $ligaDaten->mterm = array_pad($array, 7, "");
      for ($i = 0; $i < 7; $i++) {
        $ligaDaten->teama[$i] = array_pad(array("0"), 64, "0");
        $ligaDaten->teamb[$i] = array_pad(array("0"), 64, "0");
        $ligaDaten->mterm[$i] = array_pad($array, 64, "");
        for ($j = 0; $j < 64; $j++) {
          $ligaDaten->mterm[$i][$j] = array_pad(array("0"), 7, "0");
        }
      }
    }
    $ligaDaten->teams[0] = "___";
    // $dum: Abschnitt, Schluessel, Wert
    foreach ($lmo_eintraege as $dum) {
      if ($dum[0] == "Teams") {
        $ligaDaten->teams[$dum[1]] = stripslashes($dum[2]);
      }
      $op1 = substr($dum[0], 0, 4);
      $op2 = substr($dum[0], 0, 5);
      $op3 = intval(substr($dum[0], 5))-1;
      $op4 = intval(substr($dum[1], 2))-1;
      $op5 = substr($dum[0], 4);
      $op6 = intval(substr($dum[1], 2, -1))-1;
      $op7 = intval(substr($dum[1], -1))-1;
      $op8 = substr($dum[1], 0, 2);
      if ($op3 == $st-1) {
        ////////////////////////////////////////////////// nur der benötigte Spieltag wird eingelesen
        if (($op2 == "Round") && ($dum[1] == "D1")) {
          $ligaDaten->datum1[$op3] = $dum[2];
        }
        if (isset($ligaDaten->datum1[$op3])) {
          if ($ligaDaten->datum1[$op3] != "") {
            $dummy = strtotime(substr($ligaDaten->datum1[$op3], 0, 2)." ".$me[intval(substr($ligaDaten->datum1[$op3], 3, 2))]." ".substr($ligaDaten->datum1[$op3], 6, 4));
            if ($dummy > -1) {
              $ligaDaten->datum1[$op3] = date("d.m.Y", $dummy);
            } else {
              $ligaDaten->datum1[$op3] = "";
            }
          }
        }
        if (($op2 == "Round") && ($dum[1] == "D2")) {
          $ligaDaten->datum2[$op3] = $dum[2];
        }
        if (isset($ligaDaten->datum2[$op3])) {
          if ($ligaDaten->datum2[$op3] != "") {
            $dummy = strtotime(substr($ligaDaten->datum2[$op3], 0, 2)." ".$me[intval(substr($ligaDaten->datum2[$op3], 3, 2))]." ".substr($ligaDaten->datum2[$op3], 6, 4));
            if ($dummy > -1) {
              $ligaDaten->datum2[$op3] = date("d.m.Y", $dummy);
            } else {
              $ligaDaten->datum2[$op3] = "";
            }
          }
        }
        if (($op2 == "Round") && ($op8 == "TA")) {
          $ligaDaten->teama[$op3][$op4] = $dum[2];
        }
        if (($op2 == "Round") && ($op8 == "TB")) {
          $ligaDaten->teamb[$op3][$op4] = $dum[2];
        }
        if ($ligaDaten->lmtype == 0) {
          if (($op2 == "Round") && ($op8 == "AT")) {
            $ligaDaten->mterm[$op3][$op4] = $dum[2];
          }
        } else {
          if (($op2 == "Round") && ($dum[1] == "MO")) {
            $ligaDaten->modus[$op3] = $dum[2];
          }
          if (($op2 == "Round") && ($op8 == "AT")) {
            $ligaDaten->mterm[$op3][$op6][$op7] = $dum[2];
          }
        }
      }
    }
  }
}

?>