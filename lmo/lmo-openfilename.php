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
 * @var string $dirliga Ligenordner relativ zum LMO (Konfiguration)
 * @var string $defdateformat Datumsformat in date()-Schreibweise (Konfiguration)
 */

// $ligaDaten bereitstellen (auch wenn dieser Lader innerhalb einer Funktion laeuft)
require(PATH_TO_LMO . '/lmo-ligadaten.php');
  
  
if ($file != "") {
  if (substr($file, -4) == ".l98") {
    $daten = array("");
    $sekt = "";
     
    $datei = file(PATH_TO_LMO.'/'.$dirliga.'/'.basename($file));
    if ($datei) {
      $stand=date($defdateformat,filemtime(PATH_TO_LMO.'/'.$dirliga.'/'.basename($file)));
      $ligaDaten->lmtype=0;
      for ($tt=0;$tt<count($datei);$tt++) {
        $zeile=&$datei[$tt];
        $zeile = trim($zeile);
        if ((substr($zeile, 0, 1) == "[") && (substr($zeile, -1) == "]")) {
          $sekt = trim(substr($zeile, 1, -1));
        } elseif ((str_contains($zeile, '=')) && (substr($zeile, 0, 1) != ';')) {
        //elseif ((strpos($zeile, "=") != false) && (substr($zeile, 0, 1) != ";")) {
          $schl = trim(substr($zeile, 0, strpos($zeile, "=")));
          $wert = trim(substr($zeile, strpos($zeile, "=")+1));
          if ($sekt == "Options") {
            if ($schl == "Title") {
              $ligaDaten->lmvers = $wert;
            }
            if ($schl == "Name") {
              $ligaDaten->titel = stripslashes($wert);
            }
            if ($schl == "Type") {
              $ligaDaten->lmtype = stripslashes($wert);
            }
            if (!isset($ligaDaten->lmtype)) {
              $ligaDaten->lmtype = 0;
            }
            if ($schl == "Teams") {
              $ligaDaten->anzteams = $wert;
            }
            if ($ligaDaten->lmtype == 0) {
              if ($schl == "Rounds") {
                $ligaDaten->anzst = $wert;
              }
            }
            if (!isset($st)) {
              if ($schl == "Actual") {
                $st = $wert;
              }
            }
            if ($schl == "Actual") {
              $ligaDaten->stx = $wert;
            }
          }
          $daten[]="$sekt|$schl|$wert|EOL";
        }
      }
    }
    if (!isset($st)) {
      $st = 1;
    }
    array_shift($daten);
    // Name, Version, aktueller Spieltag und Groesse des Spielplans, soweit die Datei sie nicht nennt
    $ligaDaten->ergaenzeGrunddaten();
  }
}

?>