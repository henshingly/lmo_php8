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
 * Speichert die Liga aus den Rohdaten: Die Seiten des Adminbereichs tragen ihre Aenderungen in
 * $lmo_liga ein und binden diese Datei ein.
 *
 * Diese Datei wird eingebunden und erwartet:
 *
 * @var \Lmo\Liga\Rohdaten\Liga $lmo_liga Rohdaten der Liga mit den Aenderungen der Seite; danach die
 *                                        vollstaendige Form, wie sie in der Datei steht (Lmo\Liga\Normalform)
 * @var array<int|string, mixed> $text Sprachtexte
 * @var string $file Ligadatei relativ zum Ligenordner, leer wenn keine geladen ist
 * @var int|string $st gewaehlter Spieltag
 * @var string $dirliga Ligenordner relativ zum LMO (Konfiguration)
 * @var string $diroutput Ordner fuer erzeugte Dateien (Konfiguration)
 * @var string $defdateformat Datumsformat in date()-Schreibweise (Konfiguration)
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
      // alles, was der LMO in die Datei schreibt; als aktueller Spieltag gilt der gewaehlte
      $lmo_liga = \Lmo\Liga\Normalform::von($lmo_liga, $text[54], $st>0 ? $st : $lmo_liga->einstellungen()->aktuellerSpieltag(), $defdateformat);
      if ($einzutore==1 || $einzutoretab==1 || $einzustats==1) {
        include(PATH_TO_LMO."/lmo-zustat.php");
      }
      $datei = fopen(PATH_TO_LMO.'/'.$dirliga.$file,"wb");
      if ($datei) {
        echo getMessage($text[138]);
        flock($datei,LOCK_EX);
        fputs($datei,$lmo_liga->alsText());
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
