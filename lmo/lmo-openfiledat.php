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
 * @var array<int|string, mixed> $text Sprachtexte
 */

// $ligaDaten bereitstellen (auch wenn dieser Lader innerhalb einer Funktion laeuft)
require(PATH_TO_LMO . '/lmo-ligadaten.php');
  
  
if ($file != "") {
  if (substr($file, -4) == ".l98") {
    $lmo_pfad=PATH_TO_LMO.'/'.$dirliga.$file;
    $stand=date($defdateformat,filemtime($lmo_pfad));
    // die ganze Liga: Options mit Vorgabewerten, News, Mannschaften, Spieltage und Partien (Lmo\Liga\LigaDaten)
    $lmo_eintraege=\Lmo\Liga\LigaDatei::lies($lmo_pfad);
    foreach ($lmo_eintraege as list($sekt, $schl, $wert)) {
      if ($sekt == "Options" && $schl == "Actual" && !isset($st)) {
        $st = $wert;
      }
    }
    if (!isset($st)) {
      $st = 1;
    }
    $ligaDaten->setzeStartwerte();
    $ligaDaten->lies($lmo_eintraege,$defdateformat,$text[0],$text[1]);
    // das Datum des gewaehlten Spieltags in der Form TT.MM.JJJJ
    $ligaDaten->bereinigeSpieltagsdatum((int)$st-1);
    unset($lmo_eintraege,$lmo_pfad);
  }
}

?>