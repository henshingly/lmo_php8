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
   * An jedem Tisch sitzen sich 2 Spieler gegenüber.<br>
   * Jeder Tisch hat eine Heimrecht- und eine Auswärtsseite.<br>
   * <u>Beispiel mit 4 Tischen und 8 Sitzplätzen:</u><br>
   * Die Plätze werden in der Reihenfolge 0-7 vergeben.<br>
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
   * Die Positionsnummer von X ist immer der höchste auftretende Index.<br>
   * <u>Format der Kreuztabelle:</u><br>
   * Der erste Index des Arrays (Zeilen) greift auf den Spieltag zu, der zweite
   * Index bestimmt den Spieler mit Heimrecht. Der Wert an der Stelle des Arrays entspricht der
   * Spaltennummer (=Spielernummer) des gegnerischen Spielers, dieser spielt auswärts. Wenn
   * kein Spiel eingetragen ist, ist der Wert -1 (Array-Initilialisierung mit -1).<br>
   */



require_once(PATH_TO_LMO."/lmo-admintest.php");

/** änderungen:
 * a) 1. Index verdoppelt, entspricht jetzt den Spieltagen statt Spieler-Nummer.
 * b) Indizes beginnen bei 0 statt 1.
 * c) Kreuztabellen-Initialiserung komplett mit '-1' statt Hauptdiagonale mit '0'
 */
 
/*
 * dummy wird true, wenn der virtuelle Spieler "Spielfrei"
 * bei einer ungeraden Spielerzahl hinzugefügt wird.
 * Falls es einen Dummy gibt, hat dieser die Spielernummer
 * des Spieler auf dem festen Platz ($anzteams - 1).
 */
$dummy = false;

// Anzahl der Spieler
$anzteams = $xteams;
if (($xteams%2) == 1) {
  $anzteams++;
  $dummy = true; 
}
 
$plan = array_pad($array, 80, "");
for($i = 0; $i < 40; $i++) {
  $plan[$i] = array_pad($array, 40, "");
  for($j = 0; $j < 40; $j++) {
    $plan[$i][$j] = "-1";
  }
}

// Selbsterklärend
$spieltageHinrunde = $anzteams - 1;
$spieltage = ($anzteams - 1) * 2;

// Hat der feste Platz zu Beginn Heimrecht? Dieses Recht wechselt an jedem Spieltag, der Tisch wird gedreht.
$festerPlatzIsHome = true;

// Spieler X, Sitzbelegung durch Spieler aendert sich nicht
$spielerNrFesterPlatz = $anzteams - 1;

// Tischpartner von Spieler X
$spielerNrGegenueberFesterPlatz = 0;

/* Hauptschleife, läuft sequentiell über die Spieltage der Hinrunde.
 * Die Rückrunde wird sofort gespiegelt mit geschrieben.
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
    // Rückrunde
    $plan[$spieltag+$spieltageHinrunde][$spielerNrFesterPlatz] = $spielerNrGegenueberFesterPlatz;
  }

  /**
   * 2. Abschnitt: Alle weiteren Paarungen
   */
  $beweglicheSpieler = $anzteams - 1;
  $zielSitzGerade = 2;
  $zielSitzUngerade = $beweglicheSpieler - $zielSitzGerade;
  $zielSitzGeradeVerschoben = ($zielSitzGerade + $spieltag) % $beweglicheSpieler;
  $zielSitzUngeradeVerschoben = ($zielSitzUngerade + $spieltag) % $beweglicheSpieler;

  /**
   * Innere Schleife, läuft über alle Paarungen EINES Spieltages.
   */
  while ($zielSitzGerade < $beweglicheSpieler) {
    // Hinrunde
    $plan[$spieltag][$zielSitzGeradeVerschoben] = $zielSitzUngeradeVerschoben;
    // Rückrunde
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
 * Abbildungstabelle, die eine bijektive Abbildung zwischen ursprünglicher
 * und neuer Spielernummer beinhaltet.
 * Die alte Spielernummer 0 bis $anzteams-1 ist der Zugriffsindex,
 * die neue Spielernummer ist der Wert an der Indexstelle.
 * Die neue Spielernummer ist bereits um +1 erhöht,
 * da der LMO Indizes von 1 bis $anzteams erwartet.
 */
$abbildungsarray = range(1,$anzteams);
// Fisher-Yates Shuffle
for ($i = count($abbildungsarray); --$i; $i > 0) {
  $j = @mt_rand(0, $i+1);
  $temp = $abbildungsarray[$i];
  $abbildungsarray[$i] = $abbildungsarray[$j];
  $abbildungsarray[$j] = $temp;
}

/**
 * Schleife, die die Textfelder des LMO-Spielplans schreibt.
 */
for($spieltag = 0; $spieltag < $spieltage; $spieltag++) {
  $spielnr = 0;
  for($heim = 0; $heim < $anzteams; $heim++) {
    $ausw = $plan[$spieltag][$heim];
    if ($ausw > -1) {
      $heim_abbild = $abbildungsarray[$heim];
      $ausw_abbild = $abbildungsarray[$ausw];
      // Dummyspieler "Spielfrei" drinnen ja/nein?
      // Berücksichtige hier Indexverschiebung +1 zwischen meinen Spielernummern und LMO
      if (!$dummy || ($heim_abbild!=$spielerNrFesterPlatz+1 && $ausw_abbild!=$spielerNrFesterPlatz+1)) {
        $yteama[$spieltag][$spielnr] = $heim_abbild;
        $yteamb[$spieltag][$spielnr] = $ausw_abbild;
        //echo "Spieltag: $spieltag, Spiel: $spielnr|| Paar: $heim_abbild vs. $ausw_abbild.<br>";
        $spielnr++;
      }
    }
  }
}
?>