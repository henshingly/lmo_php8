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
 * @var string $file Ligadatei relativ zum Ligenordner, leer wenn keine geladen ist
 * @var int|string $st gewaehlter Spieltag
 * @var string $dirliga Ligenordner relativ zum LMO (Konfiguration)
 * @var string $diroutput Ordner fuer erzeugte Dateien (Konfiguration)
 *
 * Einstellungen:
 * @var int|string $einzustats Einstellung aus cfg.txt
 * @var int|string $einzutore Einstellung aus cfg.txt
 * @var int|string $einzutoretab Einstellung aus cfg.txt
 */


require_once(PATH_TO_LMO."/lmo-admintest.php");
if (($_SESSION['lmouserok']==2)||($_SESSION['lmouserok']==1)) {
  if ($file!="") {
    if (substr($file,-4)==".l98") {
      /*if ($einsavehtml==1) {
        include(PATH_TO_LMO."/lmo-savehtml.php");
        include(PATH_TO_LMO."/lmo-savehtml1.php");
      }*/
      if ($einzutore==1 || $einzutoretab==1 || $einzustats==1) {
        include(PATH_TO_LMO."/lmo-zustat.php");
      }

      $datei = fopen(PATH_TO_LMO.'/'.$dirliga.$file,"wb");

      if ($datei) {
        echo getMessage($text[138]);
        flock($datei,LOCK_EX);
        // Abschnitte, Schluessel und Werte der ganzen Datei: Lmo\Liga\LigaDaten
        $lmo_abschnitte = $ligaDaten->abschnitteZumSpeichern($text[54], $st>0 ? $st : $ligaDaten->stx, $text[0], $text[1]);
        foreach ($lmo_abschnitte as $lmo_nr => list($lmo_abschnitt, $lmo_zeilen)) {
          fputs($datei,($lmo_nr>0 ? "\n" : "")."[".$lmo_abschnitt."]\n");
          foreach ($lmo_zeilen as list($lmo_schl, $lmo_wert)) {
            fputs($datei,$lmo_schl."=".$lmo_wert."\n");
          }
        }
        unset($lmo_abschnitte, $lmo_nr, $lmo_abschnitt, $lmo_zeilen, $lmo_schl, $lmo_wert);
        flock($datei,LOCK_UN);
        if (file_exists(PATH_TO_LMO.'/'.$diroutput.'/viewer_'.substr($file,0,-4).'_count.txt')) {
          unlink(PATH_TO_LMO.'/'.$diroutput.'/viewer_'.substr($file,0,-4).'_count.txt');
        }
        fclose($datei);
      }
      else {
        echo getMessage($text[283],true);
      }
      clearstatcache();
    }
  }
}

?>