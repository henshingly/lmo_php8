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
    // Mannschaftsnamen und der Spielplan des gewaehlten Spieltags
    $ligaDaten->liesSpielplan($lmo_eintraege, $st - 1);
  }
}

?>