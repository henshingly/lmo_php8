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
 * @var array<int|string, mixed> $text Sprachtexte
 * @var string $dirliga Ligenordner relativ zum LMO (Konfiguration)
 * @var string $defdateformat Datumsformat in date()-Schreibweise (Konfiguration)
 *
 * Werden auch in dieser Datei gesetzt, aber nicht auf jedem Weg (koennen von aussen kommen):
 * @var mixed $op3
 */

// $ligaDaten bereitstellen (auch wenn dieser Lader innerhalb einer Funktion laeuft)
require(PATH_TO_LMO . '/lmo-ligadaten.php');

$ligaDaten->setzeStartwerte();
$ligastats1=1;
if (!empty($file) && file_exists(PATH_TO_LMO.'/'.$dirliga.$file) && check_hilfsadmin($file)){
  if (substr($file,-4)==".l98"){
    $array=array();
    $datei = file(PATH_TO_LMO.'/'.$dirliga.$file);
    if ($datei) {
      $stand=date($defdateformat,filemtime(PATH_TO_LMO.'/'.$dirliga.$file));
      $ligaDaten->lmtype=0;
      // Abschnitte, Schluessel und Werte der Datei (Lmo\Liga\LigaDatei)
      $lmo_eintraege=\Lmo\Liga\LigaDatei::zerlege($datei);
      // $st und $stats gehoeren nicht zur Liga: gewaehlter Spieltag (auch Aufrufparameter), Statistik-Schalter
      foreach ($lmo_eintraege as list($sekt, $schl, $wert)) {
        if ($sekt=="Options" && $schl=="Actual" && !isset($st)){ $st=$wert;}
        if ($sekt=="Options" && $schl=="stats"){ $stats=$wert;}
      }
      if (!isset($st)){                         $st=1;}
      if (!isset($stats)){                      $stats=0;}
      // Options mit Vorgabewerten, News, Mannschaften, Spieltage und Partien (Lmo\Liga\LigaDaten)
      $ligaDaten->lies($lmo_eintraege,$defdateformat,$text[0],$text[1]);
      unset($lmo_eintraege);
      if ($ligaDaten->lmtype==0){
        // eigene Bezeichnung fuer Punkte/Tore gilt auch fuer die Sprachtexte, sonst umgekehrt
        if ($ligaDaten->namepkt!=""){                      $text[37]=$ligaDaten->namepkt;}
        else {                                  $ligaDaten->namepkt=$text[37];}
        if ($ligaDaten->nametor!=""){                      $text[38]=$ligaDaten->nametor;}
        else {                                  $ligaDaten->nametor=$text[38];}
      }
    } else {
      echo getMessage($text[224],true);
    }
  }
} else {
  // Datei existiert nicht, ist kein gültiges Ligaformat oder keine Berechtigung (check_hilfsadmin): $file zurücksetzen, damit die
  // aufrufenden Skripte (z.B. lmo-showmain2.php) korrekt in den "kein File gewählt"-Zustand fallen, statt mit undefinierten
  // Variablen ($st, $anzst, $ligastats, $spez, $msieg, ...) fortzufahren.
  if (!empty($file)) {
    echo getMessage($text[224],true);
  }
  $file = '';
}
?>