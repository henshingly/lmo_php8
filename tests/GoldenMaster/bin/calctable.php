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
 * Test-Hilfsdatei (frueher lmo/lmo-calctable.php); das Programm selbst benutzt sie nicht mehr.
 * CalculationTest, ClasslibParityTest, MiniAddonTest und die RealData-Tests halten die Tabelle in dieser Form fest.
 *
 * Rechnet die Tabelle und stellt sie in den Variablen bereit, mit denen die Seiten des LMO frueher gearbeitet haben.
 * Die Rechnung selbst macht Lmo\Liga\Tabelle; diese Datei uebersetzt nur.
 *
 * Diese Datei wird eingebunden und erwartet:
 *
 * @var \Lmo\Liga\Rohdaten\Liga $lmo_liga Rohdaten der geladenen Liga (lmo-openfile.php)
 * @var array<int|string, mixed> $text Sprachtexte
 * @var string $file Ligadatei relativ zum Ligenordner, leer wenn keine geladen ist
 * @var string $action gewaehlte Seite (Aufrufparameter)
 * @var int|string $endtab Spieltag, bis zu dem gerechnet wird; fuer die Hinrundentabelle wird er hier auf die Saisonhaelfte gesetzt
 *
 * Wird gelesen, wenn gesetzt:
 * @var int|string $tabtype 0 = gesamt, 1 = heim, 2 = auswaerts, 3 = Rueckrunde, 4 = Hinrunde
 * @var int|string $newtabtype 3 bzw. 4 schraenken eine Heim- oder Auswaertstabelle auf die Rueck- bzw. Hinrunde ein
 * @var string $tabdat Bezeichnung des Spieltags, wenn nicht bis zum letzten gerechnet wird
 *
 * Ergebnis, je Mannschaft unter ihrer Nummer: $spiele, $siege, $unent, $nieder, $punkte, $negativ,
 * $etore, $atore, $dtore, die Serien $ser1 bis $ser4, hoechster Sieg ($maxs0 als Text, $maxs1:$maxs2)
 * und hoechste Niederlage ($maxn0, $maxn1:$maxn2). $tab0 ist die Reihenfolge als sortierbare
 * Zeichenketten (die letzten 7 Stellen sind die Nummer der Mannschaft), $stt der letzte gewertete Spieltag.
 */


if ($file != "") {
  if (!isset($tabtype)) {
    $tabtype = 0;
  }
  if (!isset($newtabtype)) {
    $newtabtype = 0;
  }
  $lmo_tab_liga = $lmo_liga;
  $lmo_tab_e = $lmo_tab_liga->einstellungen();
  $lmo_tab_anzteams = $lmo_tab_e->mannschaften();
  $lmo_tab_faktor = $lmo_tab_e->torfaktor();

  // Rueckrunde beginnt nach der Saisonhaelfte, Hinrunde endet dort (Tabelle::fuerAnsicht())
  $lmo_tabelle = \Lmo\Liga\Tabelle::fuerAnsicht($lmo_tab_liga, (int)$tabtype, (int)$endtab, (int)$newtabtype);
  $hoy = $lmo_tabelle->von - 1;
  if ($tabtype == 4 || $newtabtype == 4) {
    $endtab = $lmo_tabelle->bis;
  }

  $spiele = $siege = $unent = $nieder = $punkte = $negativ = $etore = $atore = $dtore = array_fill(0, $lmo_tab_anzteams + 1, 0);
  $maxs1 = $maxs2 = $maxn1 = $maxn2 = $ser1 = $ser2 = $ser3 = $ser4 = array_fill(0, $lmo_tab_anzteams + 1, 0);
  $maxs0 = $maxn0 = array_fill(0, $lmo_tab_anzteams + 1, "&nbsp;");
  // Sortierschluessel wie bisher: je 8 Stellen fuer Punkte, Minuspunkte, Tordifferenz und Tore (Kegelliga: Tore, Tordifferenz)
  $lmo_tab_schluessel = static function (\Lmo\Liga\Tabellenzeile $lmo_z) use ($lmo_tab_e): string {
    return $lmo_tab_e->istKegelliga()
      ? (50000000+$lmo_z->punkte).(50000000-$lmo_z->minuspunkte).(50000000+$lmo_z->tore).(50000000+$lmo_z->tordifferenz())
      : (50000000+$lmo_z->punkte).(50000000-$lmo_z->minuspunkte).(50000000+$lmo_z->tordifferenz()).(50000000+$lmo_z->tore);
  };

  $stt = $lmo_tabelle->letzterGewerteterSpieltag;
  $tab0 = array();
  foreach ($lmo_tabelle->zeilen as $a => $lmo_zeile) {
    $spiele[$a] = $lmo_zeile->spiele;
    $siege[$a] = $lmo_zeile->siege;
    $unent[$a] = $lmo_zeile->unentschieden;
    $nieder[$a] = $lmo_zeile->niederlagen;
    $punkte[$a] = $lmo_zeile->punkte;
    $negativ[$a] = $lmo_zeile->minuspunkte;
    $etore[$a] = $lmo_zeile->tore;
    $atore[$a] = $lmo_zeile->gegentore;
    $dtore[$a] = $lmo_zeile->tordifferenz();
    $ser1[$a] = $lmo_zeile->serieSiege;
    $ser2[$a] = $lmo_zeile->serieUngeschlagen;
    $ser3[$a] = $lmo_zeile->serieNiederlagen;
    $ser4[$a] = $lmo_zeile->serieSieglos;
    $maxs1[$a] = $lmo_zeile->hoechsterSieg->tore;
    $maxs2[$a] = $lmo_zeile->hoechsterSieg->gegentore;
    $maxs0[$a] = $lmo_zeile->hoechsterSieg->alsText($lmo_tab_faktor, $text[72], $text[73], $text[74]);
    $maxn1[$a] = $lmo_zeile->hoechsteNiederlage->tore;
    $maxn2[$a] = $lmo_zeile->hoechsteNiederlage->gegentore;
    $maxn0[$a] = $lmo_zeile->hoechsteNiederlage->alsText($lmo_tab_faktor, $text[72], $text[73], $text[74]);
    $tab0[] = $lmo_tab_schluessel($lmo_zeile).(50000000+$a);
  }
  rsort($tab0, SORT_STRING);

  // direkter Vergleich: je Gruppe punktgleicher Mannschaften die Tabelle ihrer Spiele gegeneinander ($tab1).
  // Ihr Rang kommt als ein Zeichen an Stelle 16 des Sortierschluessels (erste Ziffer der Tordifferenz);
  // ab Rang 10 folgen die Zeichen hinter "9" (":", ";", ...), die als Zeichenkette richtig dahinter sortieren.
  foreach ($lmo_tabelle->direkteVergleiche as $lmo_vergleich) {
    $subteams = implode(".", $lmo_vergleich['mannschaften']);
    $anzcnt = $lmo_vergleich['wertungen'];
    $tab1 = array();
    foreach ($lmo_vergleich['zeilen'] as $a => $lmo_zeile) {
      $tab1[$a] = $lmo_tab_schluessel($lmo_zeile).(50000000+array_search($a, $lmo_vergleich['mannschaften'])).(50000000+$a);
    }
    ksort($tab1);
    $tab1 = array_values($tab1);
    sort($tab1, SORT_STRING);
    if ($anzcnt > 0) {
      for ($b = 1; $b <= count($tab1); $b++) {
        for ($f = 0; $f < count($tab0); $f++) {
          if (intval(substr($tab0[$f], -7)) == intval(substr($tab1[$b-1], -7))) {
            $tab0[$f] = substr($tab0[$f], 0, 16).chr(ord('0') + $b).substr($tab0[$f], 17);
          }
        }
      }
    }
  }
  if ($lmo_tabelle->direkteVergleiche !== array()) {
    rsort($tab0, SORT_STRING);
  }
  if ($action == "admin") {
    $tab2 = $tab0;
  }
  if ($lmo_tab_e->mitHandicap() && $tabtype==0) {
    if (empty($tabdat) || $action == "admin") {
      $handb = $lmo_tab_e->aktuellerSpieltag()-1;
    } else {
      $handb = $endtab-1;
    }
    // Tabellenkorrektur des Spieltags (HS): je Platz zwei Ziffern
    $lmo_tab_korrektur = $lmo_tab_liga->spieltage[$handb + 1]->werte['HS'] ?? '0';
    if ($lmo_tab_korrektur != 0) {
      for ($ih = 0; $ih < $lmo_tab_anzteams; $ih++) {
        $handd = intval(substr($lmo_tab_korrektur, $ih * 2, 2));
        if ($handd < 10) {
          $handd = "0".$handd;
        }
        $tab0[$ih] = $handd.substr($tab0[$ih], 2);
      }
      sort($tab0, SORT_STRING);

    }
  }
  //print_r($tab0);
}
?>