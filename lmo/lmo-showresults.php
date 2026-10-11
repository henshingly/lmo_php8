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
 * @var int|string $st gewaehlter Spieltag
 * @var string $addp Link zum Spielplan einer Mannschaft, es fehlt nur die Nummer
 * @var int|string $breite Anzahl der Tabellenspalten
 * @var string $defdateformat Datumsformat in date()-Schreibweise (Konfiguration)
 * @var string $diroutput Ordner fuer erzeugte Dateien (Konfiguration)
 * @var int|string $einzutore Torstatistik unter den Ergebnissen (Konfiguration)
 * @var int|string $einspielfrei Einstellung einspielfrei (Konfiguration)
 * @var array<int|string, mixed> $zutore Tore je Spieltag (lmo-zustat.php)
 * @var array<int|string, mixed> $dstore Tore je Spiel je Spieltag (lmo-zustat.php)
 */

// Einstellungen der Liga mit Vorgabewerten (Lmo\Liga\Einstellungen) und der gewaehlte Spieltag
$lmo_einstellungen = $lmo_liga->einstellungen();
$lmo_spieltag = $lmo_liga->spieltage[(int)$st] ?? new \Lmo\Liga\Rohdaten\Spieltag();
$lmo_favteam = $lmo_einstellungen->lieblingsmannschaft();
?>
<table class="lmoInner" cellspacing="0" cellpadding="0" border="0">
  <tr>
    <th colspan="<?php echo $breite; ?>" align="left"><?php
echo $st . '. ' . $text[2];
if ($lmo_einstellungen->mitSpieltagsdatum()) {
    if ($lmo_spieltag->ersterTagText() != '') {
        echo ' ' . $text[3] . ' ' . $lmo_spieltag->ersterTagText();
    }
    if ($lmo_spieltag->letzterTagText() != '') {
        echo ' ' . $text[4] . ' ' . $lmo_spieltag->letzterTagText();
    }
}?></th>
  </tr>
<?php
// die Spiele des Spieltags zum Anzeigen (Lmo\Liga\Spiel); mit eingeschalteter Sortierung nach Anstoss
$lmo_spiele = iterator_to_array($lmo_liga->spiele((int)$st), false);
if ($lmo_einstellungen->sortiertNachAnstoss()) {
    // Spiele ohne Anstoss stehen vorn; gleiche Zeiten bleiben in der Reihenfolge der Partien
    usort($lmo_spiele, static fn (\Lmo\Liga\Spiel $a, \Lmo\Liga\Spiel $b): int => ($a->anstoss ?? 0) <=> ($b->anstoss ?? 0));
}
$spielfreia = array();
$spielfreib = array();

foreach ($lmo_spiele as $lmo_spiel) {
    // $i wie bisher: Partie ab 0 (eingebundene Addons rechnen damit)
    $i = $lmo_spiel->partie - 1;
    if (($lmo_spiel->heim > 0) && ($lmo_spiel->gast > 0)) {
        $lmo_heim = $lmo_spiel->heimMannschaft()->anzeigename();
        $lmo_gast = $lmo_spiel->gastMannschaft()->anzeigename();
        $lmo_tore_heim = $lmo_spiel->toreHeimText($lmo_einstellungen->torfaktor());
        $lmo_tore_gast = $lmo_spiel->toreGastText($lmo_einstellungen->torfaktor());
        $lmo_zusatz = $lmo_spiel->zusatzText($text[0], $text[1]); ?>
  <tr><?php
        if ($lmo_einstellungen->mitAnstosszeit()) {
            if ($lmo_spiel->anstoss !== null) {
                $dt = new DateTime();
                $dt->setTimeStamp($lmo_spiel->anstoss);
                $dum1 = $dt->format($lmo_einstellungen->datumsformat($defdateformat));
            } else {
                $dum1 = '';
            }?>
    <td class="nobr"><?php echo $dum1; ?></td>
<?php
        }
        /* Spielfrei-Hack-Beginn1*/
    	$spielfreia[$i] = $lmo_spiel->heim;
    	$spielfreib[$i] = $lmo_spiel->gast;
        /* Spielfrei-Hack-Ende1*/
?>
    <td width="2">&nbsp;</td>
    <td class="nobr" align="right"><?php
        if ($lmo_einstellungen->mitSpielplan()) {
            echo '<a href="' . $addp . $lmo_spiel->heim . '" title="' . $text[269] . '">';
        }
        if (($lmo_favteam > 0) && ($lmo_favteam == $lmo_spiel->heim)) {
            echo '<strong>';
        }
        echo $lmo_heim;
        if (($lmo_favteam > 0) && ($lmo_favteam == $lmo_spiel->heim)) {
            echo '</strong>';
        }
        if ($lmo_einstellungen->mitSpielplan()) {
            echo '</a>';
        }
        echo '&nbsp;' . HTML_smallTeamIcon($file, $lmo_heim, ' alt=""'); ?></td>
    <td align="center" width="10">-</td>
    <td class="nobr" align="left"><?php
        echo HTML_smallTeamIcon($file, $lmo_gast, ' alt=""') . '&nbsp;';
        if ($lmo_einstellungen->mitSpielplan()) {
            echo '<a href="' . $addp . $lmo_spiel->gast . '" title="' . $text[269] . '">';
        }
        if (($lmo_favteam > 0) && ($lmo_favteam == $lmo_spiel->gast)) {
            echo '<strong>';
        }
        echo $lmo_gast;
        if (($lmo_favteam > 0) && ($lmo_favteam == $lmo_spiel->gast)) {
            echo '</strong>';
        }
        if ($lmo_einstellungen->mitSpielplan()) {
            echo '</a>';
        } ?></td>
    <td width="2">&nbsp;</td>
    <td align="right"><?php echo $lmo_tore_heim; ?></td>
    <td align="center" width="8">:</td>
    <td align="left"><?php echo $lmo_tore_gast; ?></td>
<?php
        if ($lmo_einstellungen->mitVerlaengerung()) { ?>
    <td width="2">&nbsp;</td>
    <td><?php echo $lmo_zusatz; ?></td>
<?php
        }
        if ($lmo_spiel->wertung == 3) { ?>
    <td align="center" width="2">/</td>
    <td align="right"><?php echo $lmo_tore_gast; ?></td>
    <td align="center" width="8">:</td>
    <td align="left"><?php echo $lmo_tore_heim; ?></td>
<?php
        }?>
    <td width="2">&nbsp;</td>
    <td class="nobr"><?php
        /** Mannschaftsicons finden **/
        $lmo_teamaicon = '';
        $lmo_teambicon = '';
        if ($lmo_einstellungen->mitSpielberichten() || $lmo_spiel->notiz != '' || $lmo_spiel->wertung > 0) {
            $lmo_teamaicon = HTML_smallTeamIcon($file, $lmo_heim, ' alt=""');
            $lmo_teambicon = HTML_smallTeamIcon($file, $lmo_gast, ' alt=""');
        }
        /** Spielbericht verlinken **/
        if ($lmo_einstellungen->mitSpielberichten()) {
            if ($lmo_spiel->bericht != '') {
                //Spielbericht Inhalt
                $lmo_spielbericht_html = '<strong>' . $lmo_heim . $lmo_teamaicon . ' - ' . $lmo_teambicon . $lmo_gast . '</strong>' . nl2br($text[270]);
                // Link mit Mouseover-Funktion und data-info Attribut
                echo '<span onmouseover="showLMOTooltip(this)" onmouseout="hideLMOTooltip()" data-info="' . htmlspecialchars($lmo_spielbericht_html) . '" class="tooltip-trigger"><a href="' . $lmo_spiel->bericht . '" target="_blank"><img src="' . URL_TO_IMGDIR . '/lmo-st1.svg" height="15" class="svg-no-style" border="0" alt=""></a></span>&nbsp;';
            } else {
                echo '&nbsp;';
            }
        }
        /** Notizen anzeigen **/
        if ($lmo_spiel->notiz != '' || $lmo_spiel->wertung > 0) {
            //Grüner Tisch: Beidseitiges Ergebnis vorbereiten
            $lmo_notiz_both = ($lmo_spiel->wertung == 3) ? ' / ' . $lmo_tore_gast . ':' . $lmo_tore_heim : '';
            //Alles in EIN Tag packen, damit das CSS es als EINE zentrierte Zeile erkennt
            $lmo_spielnotiz = '<strong>' . $lmo_heim . $lmo_teamaicon . ' - ' . $lmo_teambicon . $lmo_gast . '&nbsp;&nbsp;' . $lmo_tore_heim . ':' . $lmo_tore_gast . $lmo_notiz_both . '</strong>';
            if ($lmo_einstellungen->mitVerlaengerung()) {
                $lmo_spielnotiz .= '&nbsp;' . $lmo_zusatz . '<br>';
            }
            //Grüner Tisch: Heimteam siegt
            if ($lmo_spiel->wertung == 1) {
                $lmo_spielnotiz .= '<strong>' . $text[219] . ':</strong>' . $lmo_heim . '&nbsp;' . $text[211] . '<br>';
            }
            //Grüner Tisch: Gastteam siegt
            if ($lmo_spiel->wertung == 2) {
                $lmo_spielnotiz .= '<strong>' . $text[219] . ':</strong>' . $lmo_gast . '&nbsp;' . $text[211] . '<br>';
            }
            //Grüner Tisch: Beidseitiges Ergebnis
            if ($lmo_spiel->wertung == 3) {
                $lmo_spielnotiz .= '<strong>' . $text[219] . ':</strong>' . $text[212] . '<br>';
            }
            //Allgemeine Notiz
            if ($lmo_spiel->notiz != '') {
                $lmo_spielnotiz .= '<strong>' . $text[22] . ':</strong>' . $lmo_spiel->notiz;
            }
            //Ausgabe als neutrales Element (kein Link)
            echo '<span onmouseover="showLMOTooltip(this)" onmouseout="hideLMOTooltip()" data-info="' . htmlspecialchars(nl2br($lmo_spielnotiz)) . '" class="tooltip-trigger"><img src="' . URL_TO_IMGDIR . '/lmo-st2.svg" height="15" class="svg-no-style" alt=""></span>';

            $lmo_spielnotiz = '';
        }

        /** bisherige Ergebnisse (AddOn Team Vergleich) */
        if (file_exists(PATH_TO_ADDONDIR . '/stats/lmo-showprogram.inc.php')) {
            echo '&nbsp;';
            include(PATH_TO_ADDONDIR . '/stats/lmo-showprogram.inc.php');
        } ?></td>

  </tr><?php
    }
}

if ($einzutore == 1) { ?>
  <tr>
    <td class="lmoFooter" align="center" width="100%" colspan="<?php echo $breite; ?>">&nbsp;<?php
    $zustat_file = str_replace('.l98', '.l98.php',  basename($file));
    $zustat_dir = basename($diroutput);
    if (file_exists(PATH_TO_LMO . '/' . $zustat_dir . '/' . $zustat_file)) {
        require(PATH_TO_LMO . '/' . $zustat_dir . '/' . $zustat_file);
        echo $text[38] . ': ' . applyFactor($zutore[$st], $lmo_einstellungen->torfaktor()) . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . ' ' . $text[38] . $text[4001] . ': ' . applyFactor($dstore[$st], $lmo_einstellungen->torfaktor());
    }?></td>
  </tr>
<?php
}

if ($einspielfrei == 1) { ?>
  <tr>
    <td align="center" width="100%" colspan="<?php echo $breite; ?>"><?php

    $spielfreic = array_merge($spielfreia, $spielfreib);
    $hoy5 = 1;
    foreach ($lmo_liga->alleMannschaften() as $hoy8 => $lmo_mannschaft) {
        if (!in_array($hoy8, $spielfreic)) {
            if ($hoy5 == 1) {
                echo $text[4004] . ': ';
            }
            $hoy5++;

            if ($lmo_einstellungen->mitSpielplan()) {
                echo '<a href="' . $addp . $hoy8 . '" title="' . $text[269] . '">';
            }
            if (($lmo_favteam > 0) && ($lmo_favteam == $hoy8)) {
                echo '<strong>';
            }
            echo $lmo_mannschaft->anzeigename();
            if (($lmo_favteam > 0) && ($lmo_favteam == $hoy8)) {
                echo '</strong>';
            }
            if ($lmo_einstellungen->mitSpielplan()) {
                echo '</a>';
            }
            echo '&nbsp;' . HTML_smallTeamIcon($file, $lmo_mannschaft->anzeigename(), ' alt=""');
        }
    } ?></td>
  </tr>
<?php
}?>
</table>
