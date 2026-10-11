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
 * @var string $file Ligadatei relativ zum Ligenordner, leer wenn keine geladen ist
 *
 * Weitere Variablen des einbindenden Codes:
 * @var array<int|string, mixed> $dateien
 * @var mixed $liga
 * @var mixed $lnr
 * @var mixed $now
 * @var mixed $spiel
 * @var mixed $spieltag
 * @var mixed $then
 * @var mixed $zeit
 *
 * Werden auch in dieser Datei gesetzt, aber nicht auf jedem Weg (koennen von aussen kommen):
 * @var mixed $anzspiele
 * @var mixed $datum10
 * @var mixed $datum20
 * @var mixed $modus0
 * @var mixed $teama0
 * @var mixed $teamb0
 * @var mixed $tipp
 * @var mixed $titel0
 */
  
  
if ($file != "") {
  $liga0 = substr($dateien[$lnr], 0, -4);
  $lmtype0 = 0;
  if (substr($file, -4) == ".l98") {
    // die ganze Liga als Rohdaten (Lmo\Liga\Rohdaten\Liga) und ihre Einstellungen mit Vorgabewerten
    $lmo_liga = \Lmo\Liga\Rohdaten\Liga::lies($file);
    $lmo_einstellungen = $lmo_liga->einstellungen();
    $lmo_pokal = $lmo_liga->istPokal();
    $titel0 = $lmo_einstellungen->wert('Name');
    $lmtype0 = $lmo_einstellungen->wert('Type');
    clearstatcache();

    $anzst0 = strlen(decbin((int)$lmo_einstellungen->wert('Teams')-1));
    foreach ($lmo_liga->spieltage as $lmo_spieltag_nr => $lmo_spieltag) {
      $spieltag0 = (string)$lmo_spieltag_nr;
      // Datum des Spieltags, wie es in der Datei steht
      $datum10 = $lmo_spieltag->werte['D1'] ?? '';
      $datum20 = $lmo_spieltag->werte['D2'] ?? '';
      // Spiele je Paarung: in der Liga eines, im Pokal nach dem Modus der Runde
      $modus0 = $lmo_pokal ? ($lmo_spieltag->werte['MO'] ?? '1') : 1;
      foreach ($lmo_spieltag->partien as $lmo_partie_nr => $lmo_partie) {
        foreach ($lmo_partie->spiele as $lmo_spiel_nr => $lmo_werte) {
          // jedes Spiel mit seinen eigenen Werten; ohne Anstosszeile (AT) ist es keines
          if (!isset($lmo_werte['AT'])) {
            continue;
          }
          $teama0 = $lmo_partie->heim ?? 0;
          $teamb0 = $lmo_partie->gast ?? 0;
          $tipp = $lmo_werte['TI'] ?? 0;
          $zeit0 = zeit($lmo_werte['AT'], $datum10, $datum20);
          if ($zeit0 > $now && $zeit0 < $then && $teama0 > 0 && $tipp <> 1) {
            // Nummer des Spiels wie im Schluessel der Datei: Partie, im Pokal gefolgt vom Spiel der Paarung
            $spiel0 = $lmo_pokal ? $lmo_partie_nr.$lmo_spiel_nr : (string)$lmo_partie_nr;

            $lmo_spiel = new \Lmo\Tipp\AnstehendesSpiel();
            $lmo_spiel->titel = $titel0;
            $lmo_spiel->typ = $lmtype0;
            $lmo_spiel->runden = $anzst0;
            $lmo_spiel->spieleJePaarung = $modus0;
            $lmo_spiel->heim = $lmo_liga->mannschaftsname($teama0);
            $lmo_spiel->gast = $teamb0 > 0 ? $lmo_liga->mannschaftsname($teamb0) : '___';
            $lmo_spiele[] = $lmo_spiel;
            array_push($liga, $liga0);
            array_push($spieltag, $spieltag0);
            array_push($spiel, $spiel0);
            array_push($zeit, date("d.m.Y H:i", $zeit0));
            $anzspiele++;
          }
        }
      }
    }
  }
}
clearstatcache();

?>