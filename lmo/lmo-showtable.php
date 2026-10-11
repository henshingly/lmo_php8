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
  *
  */
if (!defined('PATH_TO_LMO')) {
    exit;  // kein Direktaufruf: diese Datei wird nur ueber LMO eingebunden
}

/**
 * Diese Datei wird eingebunden und erwartet:
 *
 * @var \Lmo\Liga\Rohdaten\Liga $lmo_liga Rohdaten der geladenen Liga (lmo-openfile.php)
 * @var string $file Ligadatei relativ zum Ligenordner, leer wenn keine geladen ist
 * @var array<int|string, mixed> $text Sprachtexte
 * @var string $diroutput Ordner fuer erzeugte Dateien (Konfiguration)
 * @var string $addt1 Link zur Tabelle, es fehlt nur die Tabellenart
 * @var int|string $tabtype Tabellenart: 0 gesamt, 1 heim, 2 auswaerts, 3 Hinrunde, 4 Rueckrunde
 * @var int|string $tabonres Einstellung tabonres (Konfiguration)
 * @var int|string $tabpkt Punktespalte: 0 in der Mitte, 1 am rechten Rand (Konfiguration)
 * @var string $tabdat Stand der Tabelle als Text
 * @var int|string $endtab Spieltag, bis zu dem die Tabelle gerechnet ist
 * @var int|string $einzutoretab Torstatistik unter der Tabelle (Konfiguration)
 * @var int|float|string $gzutore Tore der ganzen Saison (lmo-zustat.php)
 * @var int|float|string $gdstore Tore je Spiel der ganzen Saison (lmo-zustat.php)
 * @var \Lmo\Liga\Tabelle $lmo_tabelle die Tabelle (lmo-showrestab.php)
 * @var list<int> $lmo_tab_plaetze Nummern der Mannschaften vom ersten zum letzten Platz (lmo-showrestab.php)
 * @var \Lmo\Liga\Tabelle $lmo_tab_heim Heimbilanz, nur bei tabonres=2 (lmo-showrestab.php)
 * @var \Lmo\Liga\Tabelle $lmo_tab_auswaerts Auswaertsbilanz, nur bei tabonres=2 (lmo-showrestab.php)
 * @var array<int|string, mixed> $platz0 Platz je Mannschaft (lmo-showrestab.php)
 * @var array<int|string, mixed> $platz1 Platz je Mannschaft am Spieltag davor (lmo-showrestab.php)
 */

// Einstellungen der Liga mit Vorgabewerten (Lmo\Liga\Einstellungen)
$lmo_einstellungen = $lmo_liga->einstellungen();
if ($lmo_einstellungen->mitMinuspunkten()) {
    $dummy = ' colspan="3" align="center"';
} else {
    $dummy = ' align="right"';
}
$breite = 11;
if ($lmo_einstellungen->mitMinuspunkten()) {
    $breite = $breite+2;
}
if ($tabonres == 2) {
    $gesamtbreite = 3 * $breite + 11;
} else {
    $gesamtbreite = $breite + 11;
}
?>

<table class="lmoInner" cellspacing="0" cellpadding="0" border="0">
  <caption><?php
if ($lmo_einstellungen->mitHinRueckrundentabelle() || $lmo_einstellungen->mitHeimAuswaertstabelle()) {
    if ($tabtype != 0) { ?><a href="<?php echo $addt1 . '0' ?>" title="<?php echo $text[27]; ?>"><?php echo $text[16]; ?></a><?php } else {echo $text[16];} ?>&nbsp;<?php
    if ($tabonres != 2 && $lmo_einstellungen->mitHeimAuswaertstabelle()) {
        if ($tabtype != 1) { ?><a href="<?php echo $addt1 . '1'; ?>" title="<?php echo $text[28]; ?>"><?php echo $text[41]; ?></a><?php } else {echo $text[41];} ?>&nbsp;<?php
        if ($tabtype != 2) { ?><a href="<?php echo $addt1 . '2'; ?>" title="<?php echo $text[29]; ?>"><?php echo $text[42]; ?></a><?php } else {echo $text[42];} ?>&nbsp;<?php
    }
    if ($lmo_einstellungen->mitHinRueckrundentabelle()) {
        if ($tabtype != 4) { ?><a href="<?php echo $addt1 . '4'; ?>" title="<?php echo $text[4003]; ?>"><?php echo $text[4003]; ?></a><?php } else {echo $text[4003];} ?>&nbsp;<?php
        if ($tabtype != 3) { ?><a href="<?php echo $addt1 . '3'; ?>" title="<?php echo $text[4002]; ?>"><?php echo $text[4002]; ?></a><?php } else {echo $text[4002];}
    }
} ?>
  </caption><?php
/** Inklusive Heim & Auswärts **/
if ($tabonres == 2) { ?>
  <tr>
    <th style="text-align:left" colspan="7"><?php echo $tabdat; ?>&nbsp;</th>
    <th colspan="<?php echo $breite; ?>">&nbsp;</th>
    <th style="width:2px;">&nbsp;</th>
    <th style="text-align:left" colspan="<?php echo $breite; ?>"><?php echo $text[41]; ?></th>
    <th style="width:2px;">&nbsp;</th>
    <th style="text-align:left" colspan="<?php echo $breite; ?>"><?php echo $text[42]; ?></th>
  </tr>
<?php
} ?>
  <tr>
    <th style="text-align:left" colspan="7"><?php if ($tabonres!=2) {echo $tabdat;} ?>&nbsp;</th>
    <th style="text-align:center"><acronym title="<?php echo $text[63]; ?>"><?php echo $text[33]; ?></acronym></th>
    <th style="text-align:center"><acronym title="<?php echo $text[199]; ?>"><?php echo $text[34]; ?></acronym></th>
<?php
if (!$lmo_einstellungen->ohneUnentschieden()) { ?>
    <th style="text-align:right"><acronym title="<?php echo $text[200]; ?>"><?php echo $text[35]; ?></acronym></th>
<?php
} ?>
    <th style="text-align:enter"><acronym title="<?php echo $text[201]; ?>"><?php echo $text[36]; ?></acronym></th>
<?php
if ($tabpkt == 0) { ?>
    <th style="width:2px;">&nbsp;</th>
    <th <?php echo $dummy; ?>><?php echo $text[37]; ?></th>
<?php
} ?>
    <th style="width:2px;">&nbsp;</th>
    <th style="text-align:center" colspan="3"><?php echo $text[38]; ?></th>
    <th style="text-align:right"><?php echo $text[39]; ?></th>
<?php
if ($tabpkt == 1) { ?>
    <th style="width:2px;">&nbsp;</th>
    <th <?php echo $dummy; ?>><?php echo $text[37]; ?></th>
<?php
}
if ($tabonres == 2) { ?>
    <th style="width:2px;">&nbsp;</th>
    <th style="text-align:right"><acronym title="<?php echo $text[63]; ?>"><?php echo $text[33]; ?></acronym></th>
    <th style="text-align:right"><acronym title="<?php echo $text[199]; ?>"><?php echo $text[34]; ?></acronym></th>
<?php
    if (!$lmo_einstellungen->ohneUnentschieden()) { ?>
    <th style="text-align:right"><acronym title="<?php echo $text[200]; ?>"><?php echo $text[35]; ?></acronym></th>
<?php
    } ?>
    <th style="text-align:right"><acronym title="<?php echo $text[201]; ?>"><?php echo $text[36]; ?></acronym></th>
<?php
    if ($tabpkt == 0) { ?>
    <th style="width:2px;">&nbsp;</th>
    <th <?php echo $dummy; ?>><?php echo $text[37]; ?></th>
<?php
    } ?>
    <th style="width:2px;">&nbsp;</th>
    <th colspan="3" align="center"><?php echo $text[38]; ?></th>
    <th style="text-align:right"><?php echo $text[39]; ?></th>
<?php
    if ($tabpkt == 1) { ?>
    <th style="width:2px;">&nbsp;</th>
    <th <?php echo $dummy; ?>><?php echo $text[37]; ?></th>
<?php
    } ?>
    <th style="width:2px;">&nbsp;</th>
    <th style="text-align:right"><acronym title="<?php echo $text[63]; ?>"><?php echo $text[33]; ?></acronym></th>
    <th style="text-align:right"><acronym title="<?php echo $text[199]; ?>"><?php echo $text[34]; ?></acronym></th>
<?php
    if (!$lmo_einstellungen->ohneUnentschieden()) { ?>
    <th style="text-align:right"><acronym title="<?php echo $text[200]; ?>"><?php echo $text[35]; ?></acronym></th>
<?php
    } ?>
    <th style="text-align:right"><acronym title="<?php echo $text[201]; ?>"><?php echo $text[36]; ?></acronym></th>
<?php
    if ($tabpkt == 0) { ?>
    <th style="width:2px;">&nbsp;</th>
    <th <?php echo $dummy; ?>><?php echo $text[37]?></th>
<?php
    } ?>
    <th style="width:2px;">&nbsp;</th>
    <th colspan="3" align="center"><?php echo $text[38]; ?></th>
    <th style="text-align:right"><?php echo $text[39]; ?></th>
<?php
    if ($tabpkt == 1) { ?>
    <th style="width:2px;">&nbsp;</th>
    <th <?php echo $dummy; ?>><?php echo $text[37]; ?></th>
<?php
    }
} ?>
  </tr>
<?php
$j = 1;
for ($x = 1; $x <= $lmo_einstellungen->mannschaften(); $x++) {
    // Mannschaft auf diesem Platz und ihre Zeile (Lmo\Liga\Tabellenzeile)
    $i = $lmo_tab_plaetze[$x - 1];
    $lmo_zeile = $lmo_tabelle->zeilen[$i];
    // die Mannschaft dieser Zeile mit ihren Strafen, Torkorrekturen, ihrer Notiz und Homepage
    $lmo_mannschaft = $lmo_liga->mannschaften[$i] ?? new \Lmo\Liga\Rohdaten\Mannschaft();
    $lmo_name = $lmo_mannschaft->anzeigename();
    $lmo_strafp = $lmo_mannschaft->werte['SP'] ?? '0';
    $lmo_strafm = $lmo_mannschaft->werte['SM'] ?? '0';
    $lmo_tor1 = $lmo_mannschaft->werte['TOR1'] ?? '0';
    $lmo_tor2 = $lmo_mannschaft->werte['TOR2'] ?? '0';
    $lmo_strafdat = $lmo_mannschaft->werte['STDA'] ?? '0';
    $lmo_notiz = $lmo_mannschaft->werte['NOT'] ?? '';
    $lmo_url = $lmo_mannschaft->werte['URL'] ?? '';
    if ($i == $lmo_einstellungen->lieblingsmannschaft()) {
        $dummy = '<strong>';
        $dumm2 = '</strong>';
    } else {
        $dummy = '';
        $dumm2 = '';
    }
    $lmo_tabelle_class = 'nobr';
    if ($tabtype == 0) {
        if (($x == 1) && $lmo_einstellungen->mitMeister()) {
            $lmo_tabelle_class = 'lmoTabelleMeister nobr';
            $j = 2;
        }
        if (($x >= $j) && ($x < $j+$lmo_einstellungen->plaetzeChampionsLeague()) && ($lmo_einstellungen->plaetzeChampionsLeague() > 0)) {
            $lmo_tabelle_class = 'lmoTabelleCleague nobr';
        }
        if (($x >= $j+$lmo_einstellungen->plaetzeChampionsLeague()) && ($x < $j+$lmo_einstellungen->plaetzeChampionsLeague()+$lmo_einstellungen->plaetzeClQualifikation()) && ($lmo_einstellungen->plaetzeClQualifikation() > 0)) {
            $lmo_tabelle_class = 'lmoTabelleCleaguequali nobr';
        }
        if (($x >= $j+$lmo_einstellungen->plaetzeChampionsLeague()+$lmo_einstellungen->plaetzeClQualifikation()) && ($x < $j+$lmo_einstellungen->plaetzeChampionsLeague()+$lmo_einstellungen->plaetzeClQualifikation()+$lmo_einstellungen->plaetzeUefaCup()) && ($lmo_einstellungen->plaetzeUefaCup() > 0)) {
        $lmo_tabelle_class = 'lmoTabelleUefa nobr';
        }
        if (($x <= $lmo_einstellungen->mannschaften()-$lmo_einstellungen->plaetzeAbstieg()) && ($x > $lmo_einstellungen->mannschaften()-$lmo_einstellungen->plaetzeAbstieg()-$lmo_einstellungen->plaetzeRelegation()) && ($lmo_einstellungen->plaetzeRelegation() > 0)) {
            $lmo_tabelle_class = 'lmoTabelleRelegation nobr';
        }
        if (($x <= $lmo_einstellungen->mannschaften()) && ($x > $lmo_einstellungen->mannschaften()-$lmo_einstellungen->plaetzeAbstieg()) && ($lmo_einstellungen->plaetzeAbstieg() > 0)) {
            $lmo_tabelle_class = 'lmoTabelleAbsteiger nobr';
        }
    } ?>
  <tr>
    <td class="<?php echo $lmo_tabelle_class; ?>" align="right"><?php echo $dummy . $x . $dumm2; ?></td>
<?php
    $y = 0;
    if ($endtab > 1 && isset($platz0[$i])) {
        if ($platz0[$i] < $platz1[$i]) {
            $y = 1;
        } elseif ($platz0[$i] > $platz1[$i]) {
            $y = 2;
        }
    } ?>
    <td class="<?php echo $lmo_tabelle_class; ?>"><img src='<?php echo URL_TO_IMGDIR . '/lmo-tab' . $y . '.gif'; ?>' width="9" height="9" border="0" alt=""></td>
    <td class="<?php echo $lmo_tabelle_class; ?>" align="center"><?php echo HTML_smallTeamIcon($file, $lmo_name, ' alt=""'); ?></td>
    <td class="<?php echo $lmo_tabelle_class; ?>" align="left"><?php
    echo $dummy . $lmo_name . $dumm2;
    if (($lmo_url != '') && $lmo_einstellungen->mitMannschaftslinks()) { ?>
        <a href="<?php echo $lmo_url; ?>" target="_blank"><img border="0" title="<?php echo $text[46]; ?>" width="11" src="<?php echo URL_TO_IMGDIR . '/url.png'; ?>" alt="<?php echo $text[564]?>"></a><?php
    } ?></td>
    <td class="<?php echo $lmo_tabelle_class; ?>" style="width:2px;">&nbsp;</td>
    <td class="<?php echo $lmo_tabelle_class; ?>"><?php

    if ($lmo_notiz != '' || $lmo_strafp != 0 || $lmo_strafm != 0 || $lmo_tor1 != 0 || $lmo_tor2 != 0) {
        /** Notizen anzeigen
        *
        * Achtung: Da beim Speichern Strafpunkte/-tore positiv sind und Bonuspunkte negativ (altes System des LMO)
        * muss mit -1 multipliziert werden, um die Punkte/Tore richtig anzuzeigen
        */

        $lmo_tabellennotiz = ' <strong>' . HTML_smallTeamIcon($file, $lmo_name, ' alt=""') . $lmo_name . '</strong>';
        //Straf-/Bonuspunkte
        if ($lmo_strafp != 0 || $lmo_strafm != 0) {

            $lmo_tabellennotiz .= '<strong>' . $text[128] . ':</strong>';
            //Punkte
            $lmo_tabellennotiz .= $lmo_strafp < 0 ? '+' . ((-1) * applyFactor($lmo_strafp, $lmo_einstellungen->punktfaktor())) : ((-1) * applyFactor($lmo_strafp, $lmo_einstellungen->punktfaktor()));
            //Minuspunkte
            if ($lmo_einstellungen->mitMinuspunkten()) {
                $lmo_tabellennotiz .= ':' . ($lmo_strafm < 0 ? '+' . ((-1) * applyFactor($lmo_strafm, $lmo_einstellungen->punktfaktor())) : ((-1) * applyFactor($lmo_strafm, $lmo_einstellungen->punktfaktor())));
            }
            //Ab Spieltag
            if ($lmo_strafdat != 0)
                $lmo_tabellennotiz .= '<br>' . $text[524] . '&nbsp;' . $text[2] . '&nbsp;' . $lmo_strafdat . '<br>';
        }
        //Straf-/Bonustore
        if ($lmo_tor1 != 0 || $lmo_tor2 != 0) {
            $lmo_tabellennotiz .= '<br>';
            $lmo_tabellennotiz .= '<strong>' . $text[522] . ':</strong>';
            //Tore
            $lmo_tabellennotiz .= $lmo_tor1 < 0 ? '+' . ((-1) * applyFactor($lmo_tor1, $lmo_einstellungen->torfaktor())) . ':' : ((-1) * applyFactor($lmo_tor1, $lmo_einstellungen->torfaktor())) . ':';
            //Gegentore
            $lmo_tabellennotiz .= $lmo_tor2 < 0 ? '+' . ((-1) * applyFactor($lmo_tor2, $lmo_einstellungen->torfaktor())) : ((-1) * applyFactor($lmo_tor2, $lmo_einstellungen->torfaktor()));
            //Ab Spieltag
            if ($lmo_strafdat != 0)
                $lmo_tabellennotiz .= '<br>' . $text[524] . '&nbsp;' . $text[2] . '&nbsp;' . $lmo_strafdat . '<br>';
        }
        //Teamnotizen
        if ($lmo_notiz != '') {
            $lmo_tabellennotiz .= '<br>';
            $lmo_tabellennotiz .= '<strong>' . $text[22] . ':</strong>' . $lmo_notiz;
        }
        //Ausgabe als neutrales Element (kein Link)
        echo '<span onmouseover="showLMOTooltip(this)" onmouseout="hideLMOTooltip()" data-info="' . htmlspecialchars(nl2br($lmo_tabellennotiz)) . '" class="tooltip-trigger"><img src="' . URL_TO_IMGDIR . '/lmo-st2.svg" height="15" class="svg-no-style" alt=""></span>';
        $lmo_tabellennotiz = '';
    } else {
        echo '&nbsp;';
    } ?></td>
    <td class="<?php echo $lmo_tabelle_class; ?>" style="width:2px;">&nbsp;</td>
    <td class="<?php echo $lmo_tabelle_class; ?>" align="right"><?php echo $dummy . $lmo_zeile->spiele . $dumm2; ?></td>
    <td class="<?php echo $lmo_tabelle_class; ?>" align="right"><?php echo $dummy . $lmo_zeile->siege . $dumm2; ?></td>
<?php
    if (!$lmo_einstellungen->ohneUnentschieden()) { ?>
    <td class="<?php echo $lmo_tabelle_class; ?>" align="right"><?php echo $dummy . $lmo_zeile->unentschieden . $dumm2; ?></td>
<?php
    } ?>
    <td class="<?php echo $lmo_tabelle_class; ?>" align="right"><?php echo $dummy . $lmo_zeile->niederlagen . $dumm2; ?></td>
<?php
    if ($tabpkt == 0) { ?>
    <td class="<?php echo $lmo_tabelle_class; ?>" style="width:2px;">&nbsp;</td>
    <td class="<?php echo $lmo_tabelle_class; ?>" align="right"><strong><?php echo applyFactor($lmo_zeile->punkte, $lmo_einstellungen->punktfaktor())?></strong></td>
<?php
        if ($lmo_einstellungen->mitMinuspunkten()) { ?>
    <td class="<?php echo $lmo_tabelle_class?>" align="center" style="width:4px;"><strong>:</strong></td>
    <td class="<?php echo $lmo_tabelle_class?>"><strong><?php echo applyFactor($lmo_zeile->minuspunkte, $lmo_einstellungen->punktfaktor())?></strong></td>
<?php
        }
    } ?>
    <td class="<?php echo $lmo_tabelle_class; ?>" style="width:2px;">&nbsp;</td>
    <td class="<?php echo $lmo_tabelle_class; ?>" align="right"><?php echo $dummy . applyFactor($lmo_zeile->tore, $lmo_einstellungen->torfaktor()) . $dumm2; ?></td>
    <td class="<?php echo $lmo_tabelle_class; ?>" align="center" style="width:4px;"><?php echo $dummy; ?>:<?php echo $dumm2; ?></td>
    <td class="<?php echo $lmo_tabelle_class; ?>"><?php echo $dummy . applyFactor($lmo_zeile->gegentore, $lmo_einstellungen->torfaktor()) . $dumm2; ?></td>
    <td class="<?php echo $lmo_tabelle_class; ?>" align="right"><?php echo $dummy . applyFactor($lmo_zeile->tordifferenz(), $lmo_einstellungen->torfaktor()) . $dumm2; ?></td>
<?php
    if ($tabpkt == 1) { ?>
    <td class="<?php echo $lmo_tabelle_class; ?>" style="width:2px;">&nbsp;</td>
    <td class="<?php echo $lmo_tabelle_class; ?>" align="right"><strong><?php echo applyFactor($lmo_zeile->punkte, $lmo_einstellungen->punktfaktor())?></strong></td>
<?php
        if ($lmo_einstellungen->mitMinuspunkten()) { ?>
    <td class="<?php echo $lmo_tabelle_class; ?>" align="center" style="width:4px;"><strong>:</strong></td>
    <td class="<?php echo $lmo_tabelle_class; ?>"><strong><?php echo applyFactor($lmo_zeile->minuspunkte, $lmo_einstellungen->punktfaktor())?></strong></td>
<?php
        }
    }
    if ($tabonres == 2) {
        $lmo_tabelle_class = 'lmoTabelleHeimbilanz'; ?>
    <td class="<?php echo $lmo_tabelle_class; ?>" style="width:2px;">&nbsp;</td>
    <td class="<?php echo $lmo_tabelle_class; ?>" align="right"><?php echo $dummy . $lmo_tab_heim->zeilen[$i]->spiele . $dumm2; ?></td>
    <td class="<?php echo $lmo_tabelle_class; ?>" align="right"><?php echo $dummy . $lmo_tab_heim->zeilen[$i]->siege . $dumm2; ?></td>
    <td class="<?php echo $lmo_tabelle_class; ?>" align="right"><?php echo $dummy . $lmo_tab_heim->zeilen[$i]->unentschieden . $dumm2; ?></td>
    <td class="<?php echo $lmo_tabelle_class; ?>" align="right"><?php echo $dummy . $lmo_tab_heim->zeilen[$i]->niederlagen . $dumm2; ?></td>
<?php
        if ($tabpkt == 0) { ?>
    <td class="<?php echo $lmo_tabelle_class; ?>" style="width:2px;">&nbsp;</td>
    <td class="<?php echo $lmo_tabelle_class; ?>" align="right"><strong><?php echo applyFactor($lmo_tab_heim->zeilen[$i]->punkte, $lmo_einstellungen->punktfaktor())?></strong></td>
<?php
            if ($lmo_einstellungen->mitMinuspunkten()) { ?>
    <td class="<?php echo $lmo_tabelle_class; ?>" align="center" style="width:4px;"><strong>:</strong></td>
    <td class="<?php echo $lmo_tabelle_class; ?>"><strong><?php echo applyFactor($lmo_tab_heim->zeilen[$i]->minuspunkte, $lmo_einstellungen->punktfaktor())?></strong></td>
<?php
            }
        } ?>
    <td class="<?php echo $lmo_tabelle_class; ?>" style="width:2px;">&nbsp;</td>
    <td class="<?php echo $lmo_tabelle_class; ?>" align="right"><?php echo $dummy . applyFactor($lmo_tab_heim->zeilen[$i]->tore, $lmo_einstellungen->torfaktor()) . $dumm2; ?></td>
    <td class="<?php echo $lmo_tabelle_class; ?>" align="center" style="width:4px;"><?php echo $dummy; ?>:<?php echo $dumm2; ?></td>
    <td class="<?php echo $lmo_tabelle_class; ?>"><?php echo $dummy . applyFactor($lmo_tab_heim->zeilen[$i]->gegentore, $lmo_einstellungen->torfaktor()) . $dumm2; ?></td>
    <td class="<?php echo $lmo_tabelle_class; ?>" align="right"><?php echo $dummy . applyFactor($lmo_tab_heim->zeilen[$i]->tordifferenz(), $lmo_einstellungen->torfaktor()) . $dumm2; ?></td>
<?php
        if ($tabpkt == 1) { ?>
    <td class="<?php echo $lmo_tabelle_class; ?>" style="width:2px;">&nbsp;</td>
    <td class="<?php echo $lmo_tabelle_class; ?>" align="right"><strong><?php echo applyFactor($lmo_tab_heim->zeilen[$i]->punkte, $lmo_einstellungen->punktfaktor())?></strong></td>
<?php
            if ($lmo_einstellungen->mitMinuspunkten()) { ?>
    <td class="<?php echo $lmo_tabelle_class; ?>" align="center" style="width:4px;"><strong>:</strong></td>
    <td class="<?php echo $lmo_tabelle_class; ?>"><strong><?php echo applyFactor($lmo_tab_heim->zeilen[$i]->minuspunkte, $lmo_einstellungen->punktfaktor())?></strong></td>
<?php
            }
        }
        $lmo_tabelle_class = 'lmoTabelleGastbilanz'; ?>
    <td class="<?php echo $lmo_tabelle_class; ?>" style="width:2px;">&nbsp;</td>
    <td class="<?php echo $lmo_tabelle_class; ?>" align="right"><?php echo $dummy . $lmo_tab_auswaerts->zeilen[$i]->spiele . $dumm2; ?></td>
    <td class="<?php echo $lmo_tabelle_class; ?>" align="right"><?php echo $dummy . $lmo_tab_auswaerts->zeilen[$i]->siege . $dumm2; ?></td>
    <td class="<?php echo $lmo_tabelle_class; ?>" align="right"><?php echo $dummy . $lmo_tab_auswaerts->zeilen[$i]->unentschieden . $dumm2; ?></td>
    <td class="<?php echo $lmo_tabelle_class; ?>" align="right"><?php echo $dummy . $lmo_tab_auswaerts->zeilen[$i]->niederlagen . $dumm2; ?></td>
<?php
        if ($tabpkt == 0) { ?>
    <td class="<?php echo $lmo_tabelle_class; ?>" style="width:2px;">&nbsp;</td>
    <td class="<?php echo $lmo_tabelle_class; ?>" align="right"><strong><?php echo applyFactor($lmo_tab_auswaerts->zeilen[$i]->punkte, $lmo_einstellungen->punktfaktor())?></strong></td>
<?php
            if ($lmo_einstellungen->mitMinuspunkten()) { ?>
    <td class="<?php echo $lmo_tabelle_class; ?>" align="center" style="width:4px;"><strong>:</strong></td>
    <td class="<?php echo $lmo_tabelle_class; ?>"><strong><?php echo applyFactor($lmo_tab_auswaerts->zeilen[$i]->minuspunkte, $lmo_einstellungen->punktfaktor())?></strong></td>
<?php
            }
        } ?>
    <td class="<?php echo $lmo_tabelle_class; ?>" style="width:2px;">&nbsp;</td>
    <td class="<?php echo $lmo_tabelle_class; ?>" align="right"><?php echo $dummy . applyFactor($lmo_tab_auswaerts->zeilen[$i]->tore, $lmo_einstellungen->torfaktor()) . $dumm2; ?></td>
    <td class="<?php echo $lmo_tabelle_class; ?>" align="center" style="width:4px;"><?php echo $dummy; ?>:<?php echo $dumm2; ?></td>
    <td class="<?php echo $lmo_tabelle_class; ?>"><?php echo $dummy . applyFactor($lmo_tab_auswaerts->zeilen[$i]->gegentore, $lmo_einstellungen->torfaktor()) . $dumm2; ?></td>
    <td class="<?php echo $lmo_tabelle_class; ?>" align="right"><?php echo $dummy . applyFactor($lmo_tab_auswaerts->zeilen[$i]->tordifferenz(), $lmo_einstellungen->torfaktor()) . $dumm2; ?></td>
<?php
        if ($tabpkt == 1) { ?>
    <td class="<?php echo $lmo_tabelle_class; ?>" style="width:2px;">&nbsp;</td>
    <td class="<?php echo $lmo_tabelle_class; ?>" align="right"><strong><?php echo applyFactor($lmo_tab_auswaerts->zeilen[$i]->punkte, $lmo_einstellungen->punktfaktor())?></strong></td>
<?php
            if ($lmo_einstellungen->mitMinuspunkten()) { ?>
    <td class="<?php echo $lmo_tabelle_class; ?>" align="center" style="width:4px;"><strong>:</strong></td>
    <td class="<?php echo $lmo_tabelle_class; ?>"><strong><?php echo applyFactor($lmo_tab_auswaerts->zeilen[$i]->minuspunkte, $lmo_einstellungen->punktfaktor())?></strong></td>
<?php
            }
        }
    }  /*tabonres == 2*/
?>
  </tr>
<?php
}/*for*/
?>
  <tr>
    <td class="lmoFooter" align="center" colspan="<?php echo $gesamtbreite; ?>">&nbsp;<?php
if ($einzutoretab == 1) {
    $zustat_file = str_replace('.l98', '.l98.php',  basename($file));
    $zustat_dir = basename($diroutput);
    if (file_exists(PATH_TO_LMO . '/' . $zustat_dir . '/' . $zustat_file)) {
        require(PATH_TO_LMO . '/' . $zustat_dir . '/' . $zustat_file);
        echo $text[4000] . $text[38] . ': ' . applyFactor($gzutore, $lmo_einstellungen->torfaktor()) . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . ' ' . $text[38] . '&nbsp;' . $text[4001] . ': ' . applyFactor($gdstore, $lmo_einstellungen->torfaktor());
    }
} ?></td>
  </tr>
</table>
