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
 * Platz jeder Mannschaft nach jedem Spieltag, fuer die Fieberkurve. Gerechnet wird je Spieltag die
 * Gesamttabelle bis dorthin (Lmo\Liga\Tabelle), also mit denselben Regeln wie die Tabellenseite.
 *
 * Diese Datei wird eingebunden und erwartet:
 *
 * @var \Lmo\Liga\Rohdaten\Liga $lmo_liga Rohdaten der geladenen Liga (lmo-openfile.php)
 * @var string $file Ligadatei relativ zum Ligenordner, leer wenn keine geladen ist
 *
 * Ergebnis: $platz[Nummer der Mannschaft][Spieltag ab 0] = Platz, 0 = an dem Spieltag wurde nicht gespielt
 */


if ($file!="") {
  $lmo_graph_e = $lmo_liga->einstellungen();
  $lmo_graph_anzteams = $lmo_graph_e->mannschaften();
  $lmo_graph_anzst = $lmo_graph_e->spieltage();
  $platz = array();
  for ($i=0; $i<=$lmo_graph_anzteams; $i++) {
    $platz[$i] = array_fill(0, $lmo_graph_anzst+1, "");
  }
  for ($jyz=0; $jyz<$lmo_graph_anzst; $jyz++) {
    // hat an diesem Spieltag eine Mannschaft der Liga gespielt?
    $sttest=false;
    foreach ($lmo_liga->spiele($jyz+1) as $lmo_spiel) {
      if ($lmo_spiel->istGespielt() && (($lmo_spiel->heim >= 1 && $lmo_spiel->heim <= $lmo_graph_anzteams) || ($lmo_spiel->gast >= 1 && $lmo_spiel->gast <= $lmo_graph_anzteams))) {
        $sttest=true;
        break;
      }
    }
    // Tabelle bis zu diesem Spieltag; fuehrt die Liga ein Handicap, gilt dessen Reihenfolge
    $lmo_graph_tabelle = \Lmo\Liga\Tabelle::fuerAnsicht($lmo_liga, \Lmo\Liga\Tabelle::GESAMT, $jyz+1);
    $lmo_graph_plaetze = $lmo_graph_tabelle->reihenfolge;
    if ($lmo_graph_e->mitHandicap() && isset($lmo_liga->spieltage[$jyz+1])) {
      $lmo_graph_plaetze = $lmo_graph_tabelle->reihenfolgeNachHandicap($lmo_liga->spieltage[$jyz+1]->werte['HS'] ?? '0');
    }
    foreach ($lmo_graph_plaetze as $x => $lmo_nr) {
      $platz[$lmo_nr][$jyz] = $sttest ? $x+1 : 0;
    }
  }
}
?>