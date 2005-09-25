<?
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
  
  /**
   * @version 1.0 2005-09-22
   * @author Sebastian Janke, s.janke@tu-bs.de
   * @return Die fertige Kreuztabelle.
   *
   * Schreibt die Kreuztabelle der Begegnungen (Format s.u.).<br>
   * Das Vergabesystem arbeitet mit einem Tischemodell.<br>
   * An jedem Tisch sitzen sich 2 Spieler gegen&uuml;ber.<br>
   * Jeder Tisch hat eine Heimrecht- und eine Ausw&auml;rtsseite.<br>
   * <u>Beispiel mit 4 Tischen und 8 Sitzpl&auml;tzen:</u><br>
   * Die Pl&auml;tze werden in der Reihenfolge 0-7 vergeben.<br>
   * 7 1 2 3<br>
   * X o-o-o\<br>
   * T/T l T|<br>
   * o-o-o-o/<br>
   * 0 6 5 4<br>
   * <u>Legende:</u><br>
   * T = Tisch (Heimrecht oben)<br>
   * l = Tisch (Heimrecht unten)<br>
   * X = Spieler mit dem festen Sitzplatz<br>
   * o = Spieler, der gegen den Uhrzeigersinn rotieren muss.<br>
   * - | / \ = Rotationswege der beweglichen Spieler.<br>
   * <br>
   * Zu Beginn eines neues Spieltages rutschen alle Spieler ohne festen Sitzplatz (0-6) jeweils einen Platz gegen den
   * Uhrzeigersin weiter.<br>
   * <br>
   * Die Positionsnummer von X ist immer der h&ouml;chste auftretende Index.<br>
   * <u>Format der Kreuztabelle:</u><br>
   * Der erste Index des Arrays (Zeilen) greift auf den Spieltag zu, der zweite
   * Index bestimmt den Spieler mit Heimrecht. Der Wert an der Stelle des Arrays entspricht der
   * Spaltennummer (=Spielernummer) des gegnerischen Spielers, dieser spielt ausw&auml;rts. Wenn
   * kein Spiel eingetragen ist, ist der Wert -1 (Array-Initilialisierung mit -1).<br>
   */



require_once(PATH_TO_LMO."/lmo-admintest.php");

/** &Auml;nderungen:
 * a) 1. Index verdoppelt, entspricht jetzt den Spieltagen statt Spieler-Nummer.
 * b) Indizes beginnen bei 0 statt 1.
 * c) Kreuztabellen-Initialiserung komplett mit '-1' statt Hauptdiagonale mit '0'
 */
$plan = array_pad($array, 80, "");
for($i = 0; $i < 40; $i++) {
  $plan[$i] = array_pad($array, 40, "");
  for($j = 0; $j < 40; $j++) {
    $plan[$i][$j] = "-1";
  }
}
$j = $xteams;
if (($xteams%2) == 1) {
  $j++;
}

// Selbsterkl&auml;rend
$spieltageHinrunde = $j - 1;
$spieltage = ($j - 1) * 2;

// Hat der feste Platz zu Beginn Heimrecht? Dieses Recht wechselt an jedem Spieltag, der Tisch wird gedreht.
$festerPlatzIsHome = true;

// Spieler X, Sitzbelegung durch Spieler aendert sich nicht
$spielerNrFesterPlatz = $j - 1;

// Tischpartner von Spieler X
$spielerNrGegenueberFesterPlatz = 0;

/* Hauptschleife, l&auml;uft sequentiell &uuml;ber die Spieltage der Hinrunde.
 * Die R&uuml;ckrunde wird sofort gespiegelt mit geschrieben.
 */
for ($spieltag = 0; $spieltag < $spieltageHinrunde; $spieltag++) {

  /**
   * 1. Abschnitt: Paarung des Spielers auf dem festen Sitzplatz
   */
  $spielerNrGegenueberFesterPlatz = $spieltag;
  if ($festerPlatzIsHome) {
    // Hinrunde
    $plan[$spieltag][$spielerNrFesterPlatz] = $spielerNrGegenueberFesterPlatz;
    // Rueckrunde
    $plan[$spieltag+$spieltageHinrunde][$spielerNrGegenueberFesterPlatz] = $spielerNrFesterPlatz;
  } 
  else {
    // Hinrunde
    $plan[$spieltag][$spielerNrGegenueberFesterPlatz] = $spielerNrFesterPlatz;
    // R&uuml;ckrunde
    $plan[$spieltag+$spieltageHinrunde][$spielerNrFesterPlatz] = $spielerNrGegenueberFesterPlatz;
  }
  
  /**
   * 2. Abschnitt: Alle weiteren Paarungen
   */
  $beweglicheSpieler = $j - 1;
  $zielSitzGerade = 2;
  $zielSitzUngerade = $beweglicheSpieler - $zielSitzGerade;
  $zielSitzGeradeVerschoben = ($zielSitzGerade + $spieltag) % $beweglicheSpieler;
  $zielSitzUngeradeVerschoben = ($zielSitzUngerade + $spieltag) % $beweglicheSpieler;
  
  /**
   * Innere Schleife, l&auml;uft &uuml;ber alle Paarungen EINES Spieltages.
   */
  while ($zielSitzGerade < $beweglicheSpieler) {
    // Hinrunde
    $plan[$spieltag][$zielSitzGeradeVerschoben] = $zielSitzUngeradeVerschoben;
    // R&uuml;ckrunde
    $plan[$spieltag+$spieltageHinrunde][$zielSitzUngeradeVerschoben] = $zielSitzGeradeVerschoben;
    
    // Weiterrutschen der beweglichen Spieler
    $zielSitzGerade += 2;
    $zielSitzUngerade -= 2;
    $zielSitzGeradeVerschoben = ($zielSitzGerade + $spieltag) % $beweglicheSpieler;
    $zielSitzUngeradeVerschoben = ($zielSitzUngerade + $spieltag) % $beweglicheSpieler;
  }
  // 1. Tisch (mit festem Spieler) drehen, Heimrecht wechselt
  $festerPlatzIsHome = !$festerPlatzIsHome;
}

/**
 * Schleife, die die Textfelder des LMO-Spielplans schreibt.
 */
for($spieltag = 0; $spieltag < $spieltage; $spieltag++) {
  $spielnr = 0;
  for($heim = 0; $heim < $j; $heim++) {
    // Anpassung der Spielernummer noetig, meine beginnen bei 0, LMO-Nummern bei 1. Deswegen +1!
    if ($plan[$spieltag][$heim] > -1) {
      $yteama[$spieltag][$spielnr] = $heim+1;
      $yteamb[$spieltag][$spielnr] = $plan[$spieltag][$heim]+1;
      $spielnr++;
    }
  }
}
?>