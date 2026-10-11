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
 * @var \Lmo\Liga\LigaDaten $ligaDaten Daten der geladenen Liga (lmo-openfile.php)
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
 * @var array<int|string, mixed> $tab0 sortierte Tabelle (lmo-calctable.php)
 * @var array<int|string, mixed> $platz1 Platz je Mannschaft am Spieltag davor (lmo-calctable.php)
 * @var array<int|string, mixed> $spiele Tabellenspalte je Mannschaft (lmo-calctable.php)
 * @var array<int|string, mixed> $siege Tabellenspalte je Mannschaft (lmo-calctable.php)
 * @var array<int|string, mixed> $unent Tabellenspalte je Mannschaft (lmo-calctable.php)
 * @var array<int|string, mixed> $nieder Tabellenspalte je Mannschaft (lmo-calctable.php)
 * @var array<int|string, mixed> $punkte Tabellenspalte je Mannschaft (lmo-calctable.php)
 * @var array<int|string, mixed> $negativ Tabellenspalte je Mannschaft (lmo-calctable.php)
 * @var array<int|string, mixed> $etore Tabellenspalte je Mannschaft (lmo-calctable.php)
 * @var array<int|string, mixed> $atore Tabellenspalte je Mannschaft (lmo-calctable.php)
 * @var array<int|string, mixed> $dtore Tabellenspalte je Mannschaft (lmo-calctable.php)
 * @var array<int|string, mixed> $hspiele Tabellenspalte je Mannschaft (lmo-calctable.php)
 * @var array<int|string, mixed> $hsiege Tabellenspalte je Mannschaft (lmo-calctable.php)
 * @var array<int|string, mixed> $hunent Tabellenspalte je Mannschaft (lmo-calctable.php)
 * @var array<int|string, mixed> $hnieder Tabellenspalte je Mannschaft (lmo-calctable.php)
 * @var array<int|string, mixed> $hpunkte Tabellenspalte je Mannschaft (lmo-calctable.php)
 * @var array<int|string, mixed> $hnegativ Tabellenspalte je Mannschaft (lmo-calctable.php)
 * @var array<int|string, mixed> $hetore Tabellenspalte je Mannschaft (lmo-calctable.php)
 * @var array<int|string, mixed> $hatore Tabellenspalte je Mannschaft (lmo-calctable.php)
 * @var array<int|string, mixed> $hdtore Tabellenspalte je Mannschaft (lmo-calctable.php)
 * @var array<int|string, mixed> $aspiele Tabellenspalte je Mannschaft (lmo-calctable.php)
 * @var array<int|string, mixed> $asiege Tabellenspalte je Mannschaft (lmo-calctable.php)
 * @var array<int|string, mixed> $aunent Tabellenspalte je Mannschaft (lmo-calctable.php)
 * @var array<int|string, mixed> $anieder Tabellenspalte je Mannschaft (lmo-calctable.php)
 * @var array<int|string, mixed> $apunkte Tabellenspalte je Mannschaft (lmo-calctable.php)
 * @var array<int|string, mixed> $anegativ Tabellenspalte je Mannschaft (lmo-calctable.php)
 * @var array<int|string, mixed> $aetore Tabellenspalte je Mannschaft (lmo-calctable.php)
 * @var array<int|string, mixed> $aatore Tabellenspalte je Mannschaft (lmo-calctable.php)
 * @var array<int|string, mixed> $adtore Tabellenspalte je Mannschaft (lmo-calctable.php)
 */

if ($ligaDaten->minus == 2) {
    $dummy = ' colspan="3" align="center"';
} else {
    $dummy = ' align="right"';
}
$breite = 11;
if ($ligaDaten->minus == 2) {
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
if ($ligaDaten->einhinrueck == 1 || $ligaDaten->einheimausw == 1) {
    if ($tabtype != 0) { ?><a href="<?php echo $addt1 . '0' ?>" title="<?php echo $text[27]; ?>"><?php echo $text[16]; ?></a><?php } else {echo $text[16];} ?>&nbsp;<?php
    if ($tabonres != 2 && $ligaDaten->einheimausw==1) {
        if ($tabtype != 1) { ?><a href="<?php echo $addt1 . '1'; ?>" title="<?php echo $text[28]; ?>"><?php echo $text[41]; ?></a><?php } else {echo $text[41];} ?>&nbsp;<?php
        if ($tabtype != 2) { ?><a href="<?php echo $addt1 . '2'; ?>" title="<?php echo $text[29]; ?>"><?php echo $text[42]; ?></a><?php } else {echo $text[42];} ?>&nbsp;<?php
    }
    if ($ligaDaten->einhinrueck == 1) {
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
if ($ligaDaten->hidr != 1) { ?>
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
    if ($ligaDaten->hidr != 1) { ?>
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
    if ($ligaDaten->hidr != 1) { ?>
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
for ($x = 1; $x <= $ligaDaten->anzteams; $x++) {
    $i = intval(substr($tab0[$x - 1], 34));
    if ($i == $ligaDaten->favteam) {
        $dummy = '<strong>';
        $dumm2 = '</strong>';
    } else {
        $dummy = '';
        $dumm2 = '';
    }
    $lmo_tabelle_class = 'nobr';
    if ($tabtype == 0) {
        if (($x == 1) && ($ligaDaten->champ != 0)) {
            $lmo_tabelle_class = 'lmoTabelleMeister nobr';
            $j = 2;
        }
        if (($x >= $j) && ($x < $j+$ligaDaten->anzcl) && ($ligaDaten->anzcl > 0)) {
            $lmo_tabelle_class = 'lmoTabelleCleague nobr';
        }
        if (($x >= $j+$ligaDaten->anzcl) && ($x < $j+$ligaDaten->anzcl+$ligaDaten->anzck) && ($ligaDaten->anzck > 0)) {
            $lmo_tabelle_class = 'lmoTabelleCleaguequali nobr';
        }
        if (($x >= $j+$ligaDaten->anzcl+$ligaDaten->anzck) && ($x < $j+$ligaDaten->anzcl+$ligaDaten->anzck+$ligaDaten->anzuc) && ($ligaDaten->anzuc > 0)) {
        $lmo_tabelle_class = 'lmoTabelleUefa nobr';
        }
        if (($x <= $ligaDaten->anzteams-$ligaDaten->anzab) && ($x > $ligaDaten->anzteams-$ligaDaten->anzab-$ligaDaten->anzar) && ($ligaDaten->anzar > 0)) {
            $lmo_tabelle_class = 'lmoTabelleRelegation nobr';
        }
        if (($x <= $ligaDaten->anzteams) && ($x > $ligaDaten->anzteams-$ligaDaten->anzab) && ($ligaDaten->anzab > 0)) {
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
    <td class="<?php echo $lmo_tabelle_class; ?>" align="center"><?php echo HTML_smallTeamIcon($file, $ligaDaten->teams[$i], ' alt=""'); ?></td>
    <td class="<?php echo $lmo_tabelle_class; ?>" align="left"><?php
    echo $dummy . $ligaDaten->teams[$i] . $dumm2;
    if (($ligaDaten->teamu[$i] != '') && ($ligaDaten->urlt == 1)) { ?>
        <a href="<?php echo $ligaDaten->teamu[$i]; ?>" target="_blank"><img border="0" title="<?php echo $text[46]; ?>" width="11" src="<?php echo URL_TO_IMGDIR . '/url.png'; ?>" alt="<?php echo $text[564]?>"></a><?php
    } ?></td>
    <td class="<?php echo $lmo_tabelle_class; ?>" style="width:2px;">&nbsp;</td>
    <td class="<?php echo $lmo_tabelle_class; ?>"><?php

    if ($ligaDaten->teamn[$i] != '' || $ligaDaten->strafp[$i] != 0 || $ligaDaten->strafm[$i] != 0 || $ligaDaten->torkorrektur1[$i] != 0 || $ligaDaten->torkorrektur2[$i] != 0) {
        /** Notizen anzeigen
        *
        * Achtung: Da beim Speichern Strafpunkte/-tore positiv sind und Bonuspunkte negativ (altes System des LMO)
        * muss mit -1 multipliziert werden, um die Punkte/Tore richtig anzuzeigen
        */

        $lmo_tabellennotiz = ' <strong>' . HTML_smallTeamIcon($file, $ligaDaten->teams[$i], ' alt=""') . $ligaDaten->teams[$i] . '</strong>';
        //Straf-/Bonuspunkte
        if ($ligaDaten->strafp[$i] != 0 || $ligaDaten->strafm[$i] != 0) {

            $lmo_tabellennotiz .= '<strong>' . $text[128] . ':</strong>';
            //Punkte
            $lmo_tabellennotiz .= $ligaDaten->strafp[$i] < 0 ? '+' . ((-1) * applyFactor($ligaDaten->strafp[$i], $ligaDaten->pointsfaktor)) : ((-1) * applyFactor($ligaDaten->strafp[$i], $ligaDaten->pointsfaktor));
            //Minuspunkte
            if ($ligaDaten->minus == 2) {
                $lmo_tabellennotiz .= ':' . ($ligaDaten->strafm[$i] < 0 ? '+' . ((-1) * applyFactor($ligaDaten->strafm[$i], $ligaDaten->pointsfaktor)) : ((-1) * applyFactor($ligaDaten->strafm[$i], $ligaDaten->pointsfaktor)));
            }
            //Ab Spieltag
            if ($ligaDaten->strafdat[$i] != 0)
                $lmo_tabellennotiz .= '<br>' . $text[524] . '&nbsp;' . $text[2] . '&nbsp;' . $ligaDaten->strafdat[$i] . '<br>';
        }
        //Straf-/Bonustore
        if ($ligaDaten->torkorrektur1[$i] != 0 || $ligaDaten->torkorrektur2[$i] != 0) {
            $lmo_tabellennotiz .= '<br>';
            $lmo_tabellennotiz .= '<strong>' . $text[522] . ':</strong>';
            //Tore
            $lmo_tabellennotiz .= $ligaDaten->torkorrektur1[$i] < 0 ? '+' . ((-1) * applyFactor($ligaDaten->torkorrektur1[$i], $ligaDaten->goalfaktor)) . ':' : ((-1) * applyFactor($ligaDaten->torkorrektur1[$i], $ligaDaten->goalfaktor)) . ':';
            //Gegentore
            $lmo_tabellennotiz .= $ligaDaten->torkorrektur2[$i] < 0 ? '+' . ((-1) * applyFactor($ligaDaten->torkorrektur2[$i], $ligaDaten->goalfaktor)) : ((-1) * applyFactor($ligaDaten->torkorrektur2[$i], $ligaDaten->goalfaktor));
            //Ab Spieltag
            if ($ligaDaten->strafdat[$i] != 0)
                $lmo_tabellennotiz .= '<br>' . $text[524] . '&nbsp;' . $text[2] . '&nbsp;' . $ligaDaten->strafdat[$i] . '<br>';
        }
        //Teamnotizen
        if ($ligaDaten->teamn[$i] != '') {
            $lmo_tabellennotiz .= '<br>';
            $lmo_tabellennotiz .= '<strong>' . $text[22] . ':</strong>' . $ligaDaten->teamn[$i];
        }
        //Ausgabe als neutrales Element (kein Link)
        echo '<span onmouseover="showLMOTooltip(this)" onmouseout="hideLMOTooltip()" data-info="' . htmlspecialchars(nl2br($lmo_tabellennotiz)) . '" class="tooltip-trigger"><img src="' . URL_TO_IMGDIR . '/lmo-st2.svg" height="15" class="svg-no-style" alt=""></span>';
        $lmo_tabellennotiz = '';
    } else {
        echo '&nbsp;';
    } ?></td>
    <td class="<?php echo $lmo_tabelle_class; ?>" style="width:2px;">&nbsp;</td>
    <td class="<?php echo $lmo_tabelle_class; ?>" align="right"><?php echo $dummy . $spiele[$i] . $dumm2; ?></td>
    <td class="<?php echo $lmo_tabelle_class; ?>" align="right"><?php echo $dummy . $siege[$i] . $dumm2; ?></td>
<?php
    if ($ligaDaten->hidr != 1) { ?>
    <td class="<?php echo $lmo_tabelle_class; ?>" align="right"><?php echo $dummy . $unent[$i] . $dumm2; ?></td>
<?php
    } ?>
    <td class="<?php echo $lmo_tabelle_class; ?>" align="right"><?php echo $dummy . $nieder[$i] . $dumm2; ?></td>
<?php
    if ($tabpkt == 0) { ?>
    <td class="<?php echo $lmo_tabelle_class; ?>" style="width:2px;">&nbsp;</td>
    <td class="<?php echo $lmo_tabelle_class; ?>" align="right"><strong><?php echo applyFactor($punkte[$i], $ligaDaten->pointsfaktor)?></strong></td>
<?php
        if ($ligaDaten->minus == 2) { ?>
    <td class="<?php echo $lmo_tabelle_class?>" align="center" style="width:4px;"><strong>:</strong></td>
    <td class="<?php echo $lmo_tabelle_class?>"><strong><?php echo applyFactor($negativ[$i], $ligaDaten->pointsfaktor)?></strong></td>
<?php
        }
    } ?>
    <td class="<?php echo $lmo_tabelle_class; ?>" style="width:2px;">&nbsp;</td>
    <td class="<?php echo $lmo_tabelle_class; ?>" align="right"><?php echo $dummy . applyFactor($etore[$i], $ligaDaten->goalfaktor) . $dumm2; ?></td>
    <td class="<?php echo $lmo_tabelle_class; ?>" align="center" style="width:4px;"><?php echo $dummy; ?>:<?php echo $dumm2; ?></td>
    <td class="<?php echo $lmo_tabelle_class; ?>"><?php echo $dummy . applyFactor($atore[$i], $ligaDaten->goalfaktor) . $dumm2; ?></td>
    <td class="<?php echo $lmo_tabelle_class; ?>" align="right"><?php echo $dummy . applyFactor($dtore[$i], $ligaDaten->goalfaktor) . $dumm2; ?></td>
<?php
    if ($tabpkt == 1) { ?>
    <td class="<?php echo $lmo_tabelle_class; ?>" style="width:2px;">&nbsp;</td>
    <td class="<?php echo $lmo_tabelle_class; ?>" align="right"><strong><?php echo applyFactor($punkte[$i], $ligaDaten->pointsfaktor)?></strong></td>
<?php
        if ($ligaDaten->minus == 2) { ?>
    <td class="<?php echo $lmo_tabelle_class; ?>" align="center" style="width:4px;"><strong>:</strong></td>
    <td class="<?php echo $lmo_tabelle_class; ?>"><strong><?php echo applyFactor($negativ[$i], $ligaDaten->pointsfaktor)?></strong></td>
<?php
        }
    }
    if ($tabonres == 2) {
        $lmo_tabelle_class = 'lmoTabelleHeimbilanz'; ?>
    <td class="<?php echo $lmo_tabelle_class; ?>" style="width:2px;">&nbsp;</td>
    <td class="<?php echo $lmo_tabelle_class; ?>" align="right"><?php echo $dummy . $hspiele[$i] . $dumm2; ?></td>
    <td class="<?php echo $lmo_tabelle_class; ?>" align="right"><?php echo $dummy . $hsiege[$i] . $dumm2; ?></td>
    <td class="<?php echo $lmo_tabelle_class; ?>" align="right"><?php echo $dummy . $hunent[$i] . $dumm2; ?></td>
    <td class="<?php echo $lmo_tabelle_class; ?>" align="right"><?php echo $dummy . $hnieder[$i] . $dumm2; ?></td>
<?php
        if ($tabpkt == 0) { ?>
    <td class="<?php echo $lmo_tabelle_class; ?>" style="width:2px;">&nbsp;</td>
    <td class="<?php echo $lmo_tabelle_class; ?>" align="right"><strong><?php echo applyFactor($hpunkte[$i], $ligaDaten->pointsfaktor)?></strong></td>
<?php
            if ($ligaDaten->minus == 2) { ?>
    <td class="<?php echo $lmo_tabelle_class; ?>" align="center" style="width:4px;"><strong>:</strong></td>
    <td class="<?php echo $lmo_tabelle_class; ?>"><strong><?php echo applyFactor($hnegativ[$i], $ligaDaten->pointsfaktor)?></strong></td>
<?php
            }
        } ?>
    <td class="<?php echo $lmo_tabelle_class; ?>" style="width:2px;">&nbsp;</td>
    <td class="<?php echo $lmo_tabelle_class; ?>" align="right"><?php echo $dummy . applyFactor($hetore[$i], $ligaDaten->goalfaktor) . $dumm2; ?></td>
    <td class="<?php echo $lmo_tabelle_class; ?>" align="center" style="width:4px;"><?php echo $dummy; ?>:<?php echo $dumm2; ?></td>
    <td class="<?php echo $lmo_tabelle_class; ?>"><?php echo $dummy . applyFactor($hatore[$i], $ligaDaten->goalfaktor) . $dumm2; ?></td>
    <td class="<?php echo $lmo_tabelle_class; ?>" align="right"><?php echo $dummy . applyFactor($hdtore[$i], $ligaDaten->goalfaktor) . $dumm2; ?></td>
<?php
        if ($tabpkt == 1) { ?>
    <td class="<?php echo $lmo_tabelle_class; ?>" style="width:2px;">&nbsp;</td>
    <td class="<?php echo $lmo_tabelle_class; ?>" align="right"><strong><?php echo applyFactor($hpunkte[$i], $ligaDaten->pointsfaktor)?></strong></td>
<?php
            if ($ligaDaten->minus == 2) { ?>
    <td class="<?php echo $lmo_tabelle_class; ?>" align="center" style="width:4px;"><strong>:</strong></td>
    <td class="<?php echo $lmo_tabelle_class; ?>"><strong><?php echo applyFactor($hnegativ[$i], $ligaDaten->pointsfaktor)?></strong></td>
<?php
            }
        }
        $lmo_tabelle_class = 'lmoTabelleGastbilanz'; ?>
    <td class="<?php echo $lmo_tabelle_class; ?>" style="width:2px;">&nbsp;</td>
    <td class="<?php echo $lmo_tabelle_class; ?>" align="right"><?php echo $dummy . $aspiele[$i] . $dumm2; ?></td>
    <td class="<?php echo $lmo_tabelle_class; ?>" align="right"><?php echo $dummy . $asiege[$i] . $dumm2; ?></td>
    <td class="<?php echo $lmo_tabelle_class; ?>" align="right"><?php echo $dummy . $aunent[$i] . $dumm2; ?></td>
    <td class="<?php echo $lmo_tabelle_class; ?>" align="right"><?php echo $dummy . $anieder[$i] . $dumm2; ?></td>
<?php
        if ($tabpkt == 0) { ?>
    <td class="<?php echo $lmo_tabelle_class; ?>" style="width:2px;">&nbsp;</td>
    <td class="<?php echo $lmo_tabelle_class; ?>" align="right"><strong><?php echo applyFactor($apunkte[$i], $ligaDaten->pointsfaktor)?></strong></td>
<?php
            if ($ligaDaten->minus == 2) { ?>
    <td class="<?php echo $lmo_tabelle_class; ?>" align="center" style="width:4px;"><strong>:</strong></td>
    <td class="<?php echo $lmo_tabelle_class; ?>"><strong><?php echo applyFactor($anegativ[$i], $ligaDaten->pointsfaktor)?></strong></td>
<?php
            }
        } ?>
    <td class="<?php echo $lmo_tabelle_class; ?>" style="width:2px;">&nbsp;</td>
    <td class="<?php echo $lmo_tabelle_class; ?>" align="right"><?php echo $dummy . applyFactor($aetore[$i], $ligaDaten->goalfaktor) . $dumm2; ?></td>
    <td class="<?php echo $lmo_tabelle_class; ?>" align="center" style="width:4px;"><?php echo $dummy; ?>:<?php echo $dumm2; ?></td>
    <td class="<?php echo $lmo_tabelle_class; ?>"><?php echo $dummy . applyFactor($aatore[$i], $ligaDaten->goalfaktor) . $dumm2; ?></td>
    <td class="<?php echo $lmo_tabelle_class; ?>" align="right"><?php echo $dummy . applyFactor($adtore[$i], $ligaDaten->goalfaktor) . $dumm2; ?></td>
<?php
        if ($tabpkt == 1) { ?>
    <td class="<?php echo $lmo_tabelle_class; ?>" style="width:2px;">&nbsp;</td>
    <td class="<?php echo $lmo_tabelle_class; ?>" align="right"><strong><?php echo applyFactor($apunkte[$i], $ligaDaten->pointsfaktor)?></strong></td>
<?php
            if ($ligaDaten->minus == 2) { ?>
    <td class="<?php echo $lmo_tabelle_class; ?>" align="center" style="width:4px;"><strong>:</strong></td>
    <td class="<?php echo $lmo_tabelle_class; ?>"><strong><?php echo applyFactor($anegativ[$i], $ligaDaten->pointsfaktor)?></strong></td>
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
        echo $text[4000] . $text[38] . ': ' . applyFactor($gzutore, $ligaDaten->goalfaktor) . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . ' ' . $text[38] . '&nbsp;' . $text[4001] . ': ' . applyFactor($gdstore, $ligaDaten->goalfaktor);
    }
} ?></td>
  </tr>
</table>
