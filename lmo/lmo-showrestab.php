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
 * @var \Lmo\Liga\Rohdaten\Liga $lmo_liga Rohdaten der geladenen Liga (lmo-openfile.php)
 * @var array<int|string, mixed> $text Sprachtexte
 * @var int|string $st gewaehlter Spieltag
 * @var string $action gewaehlte Seite (Aufrufparameter)
 * @var array<int|string, mixed> $array leeres Array als Vorlage fuer array_pad()
 *
 * Einstellungen:
 * @var int|string $tabonres Einstellung aus cfg.txt
 *
 * Weitere Variablen des einbindenden Codes:
 * @var mixed $atore
 * @var mixed $dtore
 * @var mixed $etore
 * @var mixed $negativ
 * @var mixed $nieder
 * @var mixed $punkte
 * @var mixed $siege
 * @var mixed $spiele
 * @var array<int|string, mixed> $tab0
 * @var mixed $tabdat
 * @var mixed $unent
 *
 * Werden auch in dieser Datei gesetzt, aber nicht auf jedem Weg (koennen von aussen kommen):
 * @var mixed $endtab
 */


if (isset($file) && $file != "") {
  $tabtype=isset($_GET['tabtype'])?$_GET['tabtype']:0;
  $newtabtype=0;
  if (!empty($_GET['st'])) { $endtab = $st;}
  // Ursprünglichen Wert sichern: die Tabellenberechnung konnte $endtab bei Hin-/Rückrunden-Tabellen (tabtype 3/4) intern ueberschreiben, daher
  // reicht ein einfaches $endtab--/$endtab++ nicht aus, um ihn nach dem require() wieder zuverlaessig herzustellen.
  $endtab_original = $endtab;
  $addp = $_SERVER['PHP_SELF']."?action=program&amp;file=".$file."&amp;selteam=";
  $addr = $_SERVER['PHP_SELF']."?action=$action&amp;tabtype=$tabtype&amp;file=".$file."&amp;st=";
  // Einstellungen der Liga mit Vorgabewerten (Lmo\Liga\Einstellungen)
  $lmo_einstellungen = $lmo_liga->einstellungen();
  $lmo_anzteams = $lmo_einstellungen->mannschaften();
  $breite = 10;
  if ($lmo_einstellungen->mitVerlaengerung()) {
    $breite = $breite+2;
  }
  // hat der Spieltag ein Spiel, das gegen beide gewertet ist? Dann braucht die Ergebnisliste vier Spalten mehr
  $lmo_gegen_beide = false;
  foreach ($lmo_liga->spiele((int)$st) as $lmo_spiel) {
    if ($lmo_spiel->wertung == 3) {
      $lmo_gegen_beide = true;
    }
  }
  if ($lmo_gegen_beide) {
    $breite = $breite+4;
  }
  if ($lmo_einstellungen->mitAnstosszeit()) {
    $breite = $breite+1;
  }
  // Die Tabellen zum Anzeigen (Lmo\Liga\Tabelle). Fuehrt die Liga ein Handicap, gilt in der Gesamttabelle
  // dessen Reihenfolge: die des aktuellen Spieltags, bei einer Tabelle "bis Spieltag X" die von X.
  $lmo_tab_art = (int)$tabtype;
  $lmo_tab_reihenfolge = static function (\Lmo\Liga\Tabelle $lmo_t) use ($lmo_liga, $lmo_einstellungen, $lmo_tab_art, $tabdat): array {
    if (!$lmo_einstellungen->mitHandicap() || $lmo_tab_art != 0) {
      return $lmo_t->reihenfolge;
    }
    $lmo_runde = empty($tabdat) ? $lmo_einstellungen->aktuellerSpieltag() : $lmo_t->bis;
    return $lmo_t->reihenfolgeNachHandicap(isset($lmo_liga->spieltage[$lmo_runde]) ? ($lmo_liga->spieltage[$lmo_runde]->werte['HS'] ?? '0') : '0');
  };
  // Platz je Mannschaft am Spieltag davor, fuer die Pfeile
  if ($endtab_original > 1) {
    $platz1 = array_pad($array, $lmo_anzteams+1, "");
    foreach ($lmo_tab_reihenfolge(\Lmo\Liga\Tabelle::fuerAnsicht($lmo_liga, $lmo_tab_art, (int)$endtab_original - 1)) as $x => $lmo_nr) {
      $platz1[$lmo_nr] = $x+1;
    }
  }
  // Heim- und Auswaertsbilanz neben der Tabelle; bei Hin- oder Rueckrundentabelle auf diese Haelfte beschraenkt
  if ($tabonres == 2) {
    $newtabtype = $tabtype;
    $lmo_tab_heim = \Lmo\Liga\Tabelle::fuerAnsicht($lmo_liga, \Lmo\Liga\Tabelle::HEIM, (int)$endtab_original, $lmo_tab_art);
    $lmo_tab_auswaerts = \Lmo\Liga\Tabelle::fuerAnsicht($lmo_liga, \Lmo\Liga\Tabelle::AUSWAERTS, (int)$endtab_original, $lmo_tab_art);
  }
  $lmo_tabelle = \Lmo\Liga\Tabelle::fuerAnsicht($lmo_liga, $lmo_tab_art, (int)$endtab_original);
  $lmo_tab_plaetze = $lmo_tab_reihenfolge($lmo_tabelle);
  $platz0 = array_pad($array, $lmo_anzteams+1, "");
  foreach ($lmo_tab_plaetze as $x => $lmo_nr) {
    $platz0[$lmo_nr] = $x+1;
  }
  $endtab = $endtab_original;
  if ($tabdat == "") {
    $addt1 = $_SERVER['PHP_SELF']."?action=$action&amp;file=".$file."&amp;endtab=".$endtab."&amp;st=".$st."&amp;tabtype=";
  } else {
    $addt1 = $_SERVER['PHP_SELF']."?action=$action&amp;file=".$file."&amp;endtab=".$endtab."&amp;st=".$st."&amp;tabtype=";
  }
  $addt2 = $_SERVER['PHP_SELF']."?action=$action&amp;file=".$file."&amp;tabtype=".$tabtype."&amp;st=".$st."&amp;endtab=";

?>

<table class="lmoMiddle" cellspacing="0" cellpadding="0" border="0"><?php

  /** Spieltagsauswahl*/?>
  <tr>
    <td align="center"><?php  include(PATH_TO_LMO."/lmo-spieltagsmenu.php")?></td>
  </tr><?php

  /** Ergebnisse*/
  if ($tabonres >= 1 || $action=="results") {?>
  <tr>
    <td align="center"><?php  include(PATH_TO_LMO."/lmo-showresults.php")?></td>
  </tr><?php
  }

  /** Vor und Zurück-Pfeile*/?>
  <tr>
    <td>
      <table width="100%" cellspacing="0" cellpadding="0" border="0">
        <tr><?php
   $st0 = $st-1;
   if ($st > 1) {?>
          <td align="left">&nbsp;<a href="<?php echo $addr.$st0?>" title="<?php echo $text[6]?>"><?php echo $text[5]?> <?php echo $text[6]?></a>&nbsp;</td><?php
   }
   $st0 = $st+1;
   if ($st < $lmo_einstellungen->spieltage()) {?>
          <td align="right">&nbsp;<a href="<?php echo $addr.$st0?>" title="<?php echo $text[8]?>"><?php echo $text[8]?> <?php echo $text[7]?></a>&nbsp;</td><?php
   }?>
        </tr>
      </table>
    </td>
  </tr><?php

  /** Tabelle*/
  if ($tabonres >= 1 || $action=="table") {?>
  <tr>
    <td align="center"><?php  include(PATH_TO_LMO."/lmo-showtable.php")?></td>
  </tr><?php
  }?>

</table><?php
}?>