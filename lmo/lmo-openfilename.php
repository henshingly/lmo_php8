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
    $datei = file(PATH_TO_LMO.'/'.$dirliga.'/'.basename($file));
    if ($datei) {
      $stand=date($defdateformat,filemtime(PATH_TO_LMO.'/'.$dirliga.'/'.basename($file)));
      $ligaDaten->lmtype=0;
      // Abschnitte, Schluessel und Werte der Datei (Lmo\Liga\LigaDatei)
      $lmo_eintraege=\Lmo\Liga\LigaDatei::zerlege($datei);
      foreach ($lmo_eintraege as list($sekt, $schl, $wert)) {
        if ($sekt == "Options" && $schl == "Actual" && !isset($st)) {
          $st = $wert;
        }
      }
      // dieser Lader liest nur Name, Version, Typ und Groesse der Liga
      $ligaDaten->setzeOptionen($lmo_eintraege, array('Title', 'Name', 'Type', 'Teams', 'Rounds', 'Actual'));
      unset($lmo_eintraege);
    }
    if (!isset($st)) {
      $st = 1;
    }
    // Name, Version, aktueller Spieltag und Groesse des Spielplans, soweit die Datei sie nicht nennt
    $ligaDaten->ergaenzeGrunddaten();
  }
}

?>