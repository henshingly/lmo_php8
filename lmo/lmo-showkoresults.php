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
 * @var string $defdateformat Datumsformat in date()-Schreibweise (Konfiguration)
 * @var array<int|string, mixed> $text Sprachtexte
 * @var string $file Ligadatei relativ zum Ligenordner, leer wenn keine geladen ist
 * @var int|string $st gewaehlter Spieltag
 *
 * Werden auch in dieser Datei gesetzt, aber nicht auf jedem Weg (koennen von aussen kommen):
 * @var mixed $m
 */

if ($file != '') {
    $addp = $_SERVER['PHP_SELF'] . '?action=program&amp;file=' . $file . '&amp;selteam=';
    $addr = $_SERVER['PHP_SELF'] . '?action=results&amp;file=' . $file . '&amp;st=';
    // Einstellungen der Liga mit Vorgabewerten (Lmo\Liga\Einstellungen) und die gewaehlte Runde
    $lmo_einstellungen = $lmo_liga->einstellungen();
    $lmo_runden = $lmo_einstellungen->spieltage();
    $lmo_favteam = $lmo_einstellungen->lieblingsmannschaft();
    $lmo_playoff = $lmo_einstellungen->playoffModus();
    $lmo_spieltag = $lmo_liga->spieltage[(int)$st] ?? new \Lmo\Liga\Rohdaten\Spieltag();
    $breite = 10;
    if ($lmo_einstellungen->mitVerlaengerung()) {
        $breite = $breite + 2;
    }
    if ($lmo_einstellungen->mitAnstosszeit()) {
    $breite = $breite + 1;
    }
    // Paarungen dieser Runde, gerechnet wie bisher
    $lmo_anzsp = $lmo_einstellungen->mannschaften();
    for ($i = 0; $i < $st; $i++) {
        $lmo_anzsp = $lmo_anzsp / 2;
    }
    if ($lmo_einstellungen->mitSpielUmPlatz3() && ($st == $lmo_runden)) {
        $lmo_anzsp = $lmo_anzsp + 1;
    }?>
<table class="lmoMiddle" cellspacing="0" cellpadding="0" border="0">
  <tr>
    <td align="center"><?php include(PATH_TO_LMO . '/lmo-spieltagsmenu.php'); ?></td>
  </tr>
  <tr>
    <td align="center">
      <table class="lmoInner" cellspacing="0" cellpadding="0" border="0">
        <tr>
<?php
    if ($st == $lmo_runden) {
        $j = $text[374];
    } elseif ($st == $lmo_runden - 1) {
        $j = $text[373];
    } elseif ($st == $lmo_runden - 2) {
        $j = $text[372];
    } elseif ($st == $lmo_runden - 3) {
        $j = $text[371];
    } else {
        $j = $st . '. ' . $text[370];
    }
?>
          <th colspan="<?php echo $breite; ?>" align="left"><?php echo $j;
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
    // die Paarungen der Runde zum Anzeigen (Lmo\Liga\Paarung), sortiert nach den Anstosszeiten ihrer Spiele:
    // erst nach dem ersten Spiel, bei Gleichheit nach dem zweiten usw.; sonst in der Reihenfolge der Paarungen
    $lmo_zeiten = static fn (\Lmo\Liga\Paarung $lmo_p): array => array_map(static fn (\Lmo\Liga\Spiel $lmo_s): int => $lmo_s->anstoss ?? 0, $lmo_p->spiele);
    $lmo_paarungen = iterator_to_array($lmo_liga->paarungen((int)$st), false);
    usort($lmo_paarungen, static fn (\Lmo\Liga\Paarung $a, \Lmo\Liga\Paarung $b): int => $lmo_zeiten($a) <=> $lmo_zeiten($b));
    foreach ($lmo_paarungen as $lmo_paarung) {
        // $i und $n wie bisher: Paarung und Spiel ab 0 (eingebundene Addons rechnen damit)
        $i = $lmo_paarung->nr - 1;
        $lmo_heim = $lmo_paarung->heimMannschaft()->anzeigename();
        $lmo_gast = $lmo_paarung->gastMannschaft()->anzeigename();
        if (($lmo_paarung->heim > 0) && ($lmo_paarung->gast > 0)) {
            foreach ($lmo_paarung->spiele as $n => $lmo_spiel) {
                if ($lmo_einstellungen->mitSpielUmPlatz3() && ($st == $lmo_runden)) { ?>
        <tr>
          <th class="nobr" colspan="<?php echo $breite; ?>"><?php if ($i == 1) {echo '&nbsp;<br>';} echo $text[419 + $i]; ?></th>
        </tr><?php
                }?>
        <tr>
<?php
                if ($lmo_einstellungen->mitAnstosszeit()) {
                    if ($lmo_spiel->anstoss !== null) {  // ohne Anstoss keine Anzeige
                        $dt = new DateTime();
                        $dt->setTimeStamp($lmo_spiel->anstoss);
                        $dum1 = $dt->format($lmo_einstellungen->datumsformat($defdateformat));
                    } else {
                        $dum1 = '';
                    }?>
          <td class="nobr"><?php echo $dum1; ?></td>
<?php
                }
?>
          <td class="nobr" width="2">&nbsp;</td>
<?php
                if ($lmo_playoff == 1 || $lmo_playoff == 2) { // Modus 2-2-1 or 2-2-1-1-1
                    if ($n == 0 || $n == 1 || $n == 4 || $n == 6) {
                        $m = $lmo_paarung->sieger();  // 1 = Heim, 2 = Gast
                        if ($m == 1) {
                            echo '          <td class="lmoTurnierSieger nobr" align="right">';
                        } /*elseif ($m == 2) {
                            echo '          <td class="lmoTurnierVerlierer nobr" align="right">'; // Verlierer nicht rot einfärben
                        }*/ else {
                            echo '          <td class="nobr" align="right">';
                        }
                        if ($lmo_einstellungen->mitSpielplan()) {
                            echo '<a href="' . $addp . $lmo_paarung->heim . '" title="' . $text[269] . '">';
                        }
                        if (($lmo_favteam > 0) && ($lmo_favteam == $lmo_paarung->heim)) {
                            echo '<strong>';
                        }
                        echo $lmo_heim;
                        if (($lmo_favteam > 0) && ($lmo_favteam == $lmo_paarung->heim)) {
                            echo '</strong>';
                        }
                        if ($lmo_einstellungen->mitSpielplan()) {
                            echo '</a>';
                        }
                        echo '&nbsp;' . HTML_smallTeamIcon($file, $lmo_heim , ' alt=""') . '&nbsp;'; ?></td>
          <td class="nobr" align="center" width="10">-</td>
<?php
                        if ($m == 2) {
                            echo '          <td class="lmoTurnierSieger nobr" align="left">';
                        } /*elseif ($m == 1) {
                            echo '          <td class="lmoTurnierVerlierer nobr" align="left">'; // Verlierer nicht rot einfärben
                        }*/ else {
                            echo '          <td class="nobr" align="left">';
                        }
                        echo '&nbsp;' . HTML_smallTeamIcon($file, $lmo_gast, ' alt=""') . '&nbsp;';
                        if ($lmo_einstellungen->mitSpielplan()) {
                            echo '<a href="' . $addp . $lmo_paarung->gast . '" title="' . $text[269] . '">';
                        }
                        if (($lmo_favteam > 0) && ($lmo_favteam == $lmo_paarung->gast)) {
                            echo '<strong>';
                        }
                        echo $lmo_gast;
                        if (($lmo_favteam > 0) && ($lmo_favteam == $lmo_paarung->gast)) {
                            echo '</strong>';
                        }
                        if ($lmo_einstellungen->mitSpielplan()) {
                            echo '</a>';
                        }?></td>
          <td class="nobr" width="2">&nbsp;</td>
          <td class="nobr" align="right"><?php echo $lmo_spiel->toreHeimText($lmo_einstellungen->torfaktor()); ?></td>
          <td class="nobr" align="center" width="8">:</td>
          <td class="nobr" align="left"><?php echo $lmo_spiel->toreGastText($lmo_einstellungen->torfaktor()); ?></td>
<?php
                    } else {
                        if ($m == 2) {
                            echo '          <td class="lmoTurnierSieger nobr" align="right">';
                        } /*elseif ($m == 1) {
                            echo '          <td class="lmoTurnierVerlierer nobr" align="right">'; // Verlierer nicht rot einfärben
                        }*/ else {
                            echo '          <td class="nobr" align="right">';
                        }
                        if ($lmo_einstellungen->mitSpielplan()) {
                            echo '<a href="' . $addp . $lmo_paarung->gast . '" title="' . $text[269] . '">';
                        }
                        if (($lmo_favteam > 0) && ($lmo_favteam == $lmo_paarung->gast)) {
                            echo '<strong>';
                        }
                        echo $lmo_gast;
                        if (($lmo_favteam > 0) && ($lmo_favteam == $lmo_paarung->gast)) {
                            echo '</strong>';
                        }
                        if ($lmo_einstellungen->mitSpielplan()) {
                            echo '</a>';
                        }
                        echo '&nbsp;' . HTML_smallTeamIcon($file, $lmo_gast, ' alt=""') . '&nbsp;'; ?></td>

          <td class="nobr" align="center" width="10">-</td>
<?php
                        if ($m == 1) {
                            echo '          <td class="lmoTurnierSieger nobr" align="left">';
                        } /*elseif ($m == 2) {
                            echo '          <td class="lmoTurnierVerlierer nobr" align="left">'; // Verlierer nicht rot einfärben
                        }*/ else {
                            echo '          <td class="nobr" align="left">';
                        }
                        echo '&nbsp;' . HTML_smallTeamIcon($file, $lmo_heim, ' alt=""') . '&nbsp;';
                        if ($lmo_einstellungen->mitSpielplan()) {
                            echo '<a href="' . $addp . $lmo_paarung->heim . '" title="' . $text[269] . '">';
                        }
                        if (($lmo_favteam > 0) && ($lmo_favteam == $lmo_paarung->heim)) {
                            echo '<strong>';
                        }
                        echo $lmo_heim;
                        if (($lmo_favteam > 0) && ($lmo_favteam == $lmo_paarung->heim)) {
                            echo '</strong>';
                        }
                        if ($lmo_einstellungen->mitSpielplan()) {
                            echo '</a>';
                        }?></td>
          <td class="nobr" width="2">&nbsp;</td>
          <td class="nobr" align="right"><?php echo $lmo_spiel->toreGastText($lmo_einstellungen->torfaktor()); ?></td>
          <td class="nobr" align="center" width="8">:</td>
          <td class="nobr" align="left"><?php echo $lmo_spiel->toreHeimText($lmo_einstellungen->torfaktor()); ?></td>
<?php
                    }
                }
                if ($lmo_playoff == 3) { // Modus 2-3-2
                    if ($n == 0 || $n == 1 || $n == 5 || $n == 6) {
                        $m = $lmo_paarung->sieger();  // 1 = Heim, 2 = Gast
                        if ($m == 1) {
                            echo '          <td class="lmoTurnierSieger nobr" align="right">';
                        } /*elseif ($m == 2) {
                            echo '          <td class="lmoTurnierVerlierer nobr" align="right">'; // Verlierer nicht rot einfärben
                        }*/ else {
                            echo '          <td class="nobr" align="right">';
                        }
                        if ($lmo_einstellungen->mitSpielplan()) {
                            echo '<a href="' . $addp . $lmo_paarung->heim . '" title="' . $text[269] . '">';
                        }
                        if (($lmo_favteam > 0) && ($lmo_favteam == $lmo_paarung->heim)) {
                            echo '<strong>';
                        }
                        echo $lmo_heim;
                        if (($lmo_favteam > 0) && ($lmo_favteam == $lmo_paarung->heim)) {
                            echo '</strong>';
                        }
                        if ($lmo_einstellungen->mitSpielplan()) {
                            echo '</a>';
                        }
                        echo '&nbsp;' . HTML_smallTeamIcon($file, $lmo_heim, ' alt=""') . '&nbsp;'; ?></td>
          <td class="nobr" align="center" width="10">-</td>
<?php
                        if ($m == 2) {
                            echo '          <td class="lmoTurnierSieger nobr" align="left">';
                        } /*elseif ($m == 1) {
                            echo '          <td class="lmoTurnierVerlierer nobr" align="left">'; // Verlierer nicht rot einfärben
                        }*/ else {
                            echo '          <td class="nobr" align="left">';
                        }
                        echo '&nbsp;' . HTML_smallTeamIcon($file, $lmo_gast, ' alt=""') . '&nbsp;';
                        if ($lmo_einstellungen->mitSpielplan()) {
                            echo '<a href="' . $addp . $lmo_paarung->gast . '" title="' . $text[269] . '">';
                        }
                        if (($lmo_favteam > 0) && ($lmo_favteam == $lmo_paarung->gast)) {
                            echo '<strong>';
                        }
                        echo $lmo_gast;
                        if (($lmo_favteam > 0) && ($lmo_favteam == $lmo_paarung->gast)) {
                            echo '</strong>';
                        }
                        if ($lmo_einstellungen->mitSpielplan()) {
                            echo '</a>';
                        }?></td>
          <td class="nobr" width="2">&nbsp;</td>
          <td class="nobr" align="right"><?php echo $lmo_spiel->toreHeimText($lmo_einstellungen->torfaktor()); ?></td>
            <td class="nobr" align="center" width="8">:</td>
                <td class="nobr" align="left"><?php echo $lmo_spiel->toreGastText($lmo_einstellungen->torfaktor()); ?></td>
<?php
                    } else {
                        if ($m == 2) {
                            echo '          <td class="lmoTurnierSieger nobr" align="right">';
                        } /*elseif ($m == 1) {
                            echo '          <td class="lmoTurnierVerlierer nobr" align="right">'; // Verlierer nicht rot einfärben
                        }*/ else {
                            echo '          <td class="nobr" align="right">';
                        }
                        if ($lmo_einstellungen->mitSpielplan()) {
                            echo '<a href="' . $addp . $lmo_paarung->gast . '" title="' . $text[269] . '">';
                        }
                        if (($lmo_favteam > 0) && ($lmo_favteam == $lmo_paarung->gast)) {
                            echo '<strong>';
                        }
                        echo $lmo_gast;
                        if (($lmo_favteam > 0) && ($lmo_favteam == $lmo_paarung->gast)) {
                            echo '</strong>';
                        }
                        if ($lmo_einstellungen->mitSpielplan()) {
                            echo '</a>';
                        }
                        echo '&nbsp;' . HTML_smallTeamIcon($file, $lmo_gast, ' alt=""') . '&nbsp;'; ?></td>
          <td class="nobr" align="center" width="10">-</td>
<?php
                        if ($m == 1) {
                            echo '          <td class="lmoTurnierSieger nobr" align="left">';
                        } /*elseif ($m == 2) {
                            echo '          <td class="lmoTurnierVerlierer nobr" align="left">'; // Verlierer nicht rot einfärben
                        }*/ else {
                            echo '          <td class="nobr" align="left">';
                        }
                        echo '&nbsp;' . HTML_smallTeamIcon($file, $lmo_heim, ' alt=""') . '&nbsp;';
                        if ($lmo_einstellungen->mitSpielplan()) {
                            echo '<a href="' . $addp . $lmo_paarung->heim . '" title="' . $text[269] . '">';
                        }
                        if (($lmo_favteam > 0) && ($lmo_favteam == $lmo_paarung->heim)) {
                            echo '<strong>';
                        }
                        echo $lmo_heim;
                        if (($lmo_favteam > 0) && ($lmo_favteam == $lmo_paarung->heim)) {
                            echo '</strong>';
                        }
                        if ($lmo_einstellungen->mitSpielplan()) {
                            echo '</a>';
                        }?></td>
          <td class="nobr" width="2">&nbsp;</td>
          <td class="nobr" align="right"><?php echo $lmo_spiel->toreGastText($lmo_einstellungen->torfaktor()); ?></td>
          <td class="nobr" align="center" width="8">:</td>
          <td class="nobr" align="left"><?php echo $lmo_spiel->toreHeimText($lmo_einstellungen->torfaktor()); ?></td>
<?php
                    }
                }
                if ($lmo_playoff < 1) { // now Modus = everything else ($playoffmode == 0; and KO-League without $playoffmode Option like old Champions-League Finalrounds)
                    if ($n % 2 == 0) {
                        $m = $lmo_paarung->sieger();  // 1 = Heim, 2 = Gast
                        if ($m == 1) {
                            echo '          <td class="lmoTurnierSieger nobr" align="right">';
                        } /*elseif ($m == 2) {
                            echo '          <td class="lmoTurnierVerlierer nobr" align="right">'; // Verlierer nicht rot einfärben
                        }*/ else {
                            echo '          <td class="nobr" align="right">';
                        }
                        if ($lmo_einstellungen->mitSpielplan()) {
                            echo '<a href="' . $addp . $lmo_paarung->heim . '" title="' . $text[269] . '">';
                        }
                        if (($lmo_favteam > 0) && ($lmo_favteam == $lmo_paarung->heim)) {
                            echo '<strong>';
                        }
                        echo $lmo_heim;
                        if (($lmo_favteam > 0) && ($lmo_favteam == $lmo_paarung->heim)) {
                            echo '</strong>';
                        }
                        if ($lmo_einstellungen->mitSpielplan()) {
                            echo '</a>';
                        }
                        echo '&nbsp;' . HTML_smallTeamIcon($file, $lmo_heim, ' alt=""') . '&nbsp;'; ?></td>
          <td class="nobr" align="center" width="10">-</td>
<?php
                        if ($m == 2) {
                            echo '          <td class="lmoTurnierSieger nobr" align="left">';
                        } /*elseif ($m == 1) {
                            echo '          <td class="lmoTurnierVerlierer nobr" align="left">'; // Verlierer nicht rot einfärben
                        }*/ else {
                            echo '          <td class="nobr" align="left">';
                        }
                        echo '&nbsp;' . HTML_smallTeamIcon($file, $lmo_gast, ' alt=""') . '&nbsp;';
                        if ($lmo_einstellungen->mitSpielplan()) {
                            echo '<a href="' . $addp . $lmo_paarung->gast . '" title="' . $text[269] . '">';
                        }
                        if (($lmo_favteam > 0) && ($lmo_favteam == $lmo_paarung->gast)) {
                            echo '<strong>';
                        }
                        echo $lmo_gast;
                        if (($lmo_favteam > 0) && ($lmo_favteam == $lmo_paarung->gast)) {
                            echo '</strong>';
                        }
                        if ($lmo_einstellungen->mitSpielplan()) {
                            echo '</a>';
                        }?></td>
          <td class="nobr" width="2">&nbsp;</td>
          <td class="nobr" align="right"><?php echo $lmo_spiel->toreHeimText($lmo_einstellungen->torfaktor()); ?></td>
          <td class="nobr" align="center" width="8">:</td>
          <td class="nobr" align="left"><?php echo $lmo_spiel->toreGastText($lmo_einstellungen->torfaktor()); ?></td>
<?php
                    } else {
                        if ($m == 2) {
                            echo '          <td class="lmoTurnierSieger nobr" align="right">';
                        } /*elseif ($m == 1) {
                            echo '          <td class="lmoTurnierVerlierer nobr" align="right">'; // Verlierer nicht rot einfärben
                        }*/ else {
                            echo '          <td class="nobr" align="right">';
                        }
                        if ($lmo_einstellungen->mitSpielplan()) {
                            echo '<a href="' . $addp . $lmo_paarung->gast . '" title="' . $text[269] . '">';
                        }
                        if (($lmo_favteam > 0) && ($lmo_favteam == $lmo_paarung->gast)) {
                            echo '<strong>';
                        }
                        echo $lmo_gast;
                        if (($lmo_favteam > 0) && ($lmo_favteam == $lmo_paarung->gast)) {
                            echo '</strong>';
                        }
                        if ($lmo_einstellungen->mitSpielplan()) {
                            echo '</a>';
                        }
                        echo '&nbsp;' . HTML_smallTeamIcon($file, $lmo_gast, ' alt=""') . '&nbsp;'; ?></td>
          <td class="nobr" align="center" width="10">-</td>
<?php
                        if ($m == 1) {
                            echo '          <td class="lmoTurnierSieger nobr" align="left">';
                        } /*elseif ($m == 2) {
                            echo '          <td class="lmoTurnierVerlierer nobr" align="left">'; // Verlierer nicht rot einfärben
                        }*/ else {
                            echo '          <td class="nobr" align="left">';
                        }
                        echo '&nbsp;' . HTML_smallTeamIcon($file, $lmo_heim, ' alt=""') . '&nbsp;';
                        if ($lmo_einstellungen->mitSpielplan()) {
                            echo '<a href="' . $addp . $lmo_paarung->heim . '" title="' . $text[269] . '">';
                        }
                        if (($lmo_favteam > 0) && ($lmo_favteam == $lmo_paarung->heim)) {
                            echo '<strong>';
                        }
                        echo $lmo_heim;
                        if (($lmo_favteam > 0) && ($lmo_favteam == $lmo_paarung->heim)) {
                            echo '</strong>';
                        }
                        if ($lmo_einstellungen->mitSpielplan()) {
                            echo '</a>';
                        }?></td>
          <td class="nobr" width="2">&nbsp;</td>
          <td class="nobr" align="right"><?php echo $lmo_spiel->toreGastText($lmo_einstellungen->torfaktor()); ?></td>
          <td class="nobr" align="center" width="8">:</td>
          <td class="nobr" align="left"><?php echo $lmo_spiel->toreHeimText($lmo_einstellungen->torfaktor()); ?></td>
<?php
                    }
                }
?>
          <td class="nobr" width="2">&nbsp;</td>
          <td class="nobr"><?php echo $lmo_spiel->zusatzText($text[0], $text[1]); ?></td>
          <td class="nobr" width="2">&nbsp;</td>
          <td class="nobr"><?php

                /** Mannschaftsicons finden **/
                $lmo_teamaicon = '';
                $lmo_teambicon = '';
                if ($lmo_einstellungen->mitSpielberichten() || $lmo_spiel->notiz != '') {
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
                /** Stats Addon */
                if (file_exists(PATH_TO_ADDONDIR . '/stats/lmo-showkoresults.inc.php')) include (PATH_TO_ADDONDIR . '/stats/lmo-showkoresults.inc.php');

                /** Notizen anzeigen **/
                if ($lmo_spiel->notiz != '') {
                    //Zentrierte Kopfzeile für Notizen
                    $lmo_spielnotiz = '<strong>' . $lmo_heim . $lmo_teamaicon . ' - ' . $lmo_teambicon . $lmo_gast . '&nbsp;&nbsp;' . $lmo_spiel->toreHeimText($lmo_einstellungen->torfaktor()) . ':' . $lmo_spiel->toreGastText($lmo_einstellungen->torfaktor()) . '</strong>';
                    //Allgemeine Notiz
                    $lmo_spielnotiz .= '<br><strong>' . $text[22] . ':</strong> ' . $lmo_spiel->notiz;

                    //Ausgabe als neutrales Element (kein Link)
                    echo '<span onmouseover="showLMOTooltip(this)" onmouseout="hideLMOTooltip()" data-info="' . htmlspecialchars(nl2br($lmo_spielnotiz)) . '" class="tooltip-trigger"><img src="' . URL_TO_IMGDIR . '/lmo-st2.svg" height="15" class="svg-no-style" border="0" alt=""></span>';
                    $lmo_spielnotiz = '';
                } else {
                    echo '&nbsp;';
                }?></td>

        </tr>
<?php
            }  // END -> for ($n = 0; $n < $modus[$st - 1]; $n++)
            if ((count($lmo_paarung->spiele) > 1) && ($i <= $lmo_anzsp - 1)) { ?>
        <tr>
          <td class="nobr" colspan="<?php echo $breite; ?>">&nbsp;</td>
        </tr>
<?php
            }
        }
    }?>
      </table>
    </td>
  </tr>
  <tr>
    <td>
      <table width="100%" cellspacing="0" cellpadding="0" border="0">
        <tr><?php
   $st0 = $st - 1;
   if ($st > 1) {?>
          <td align="left">&nbsp;<a href="<?php echo $addr . $st0; ?>" title="<?php echo $text[6]; ?>"><?php echo $text[5]; ?>&nbsp;<?php echo $text[6]; ?></a>&nbsp;</td>
<?php
   }
   $st0 = $st + 1;
   if ($st < $lmo_runden) {?>
          <td align="right">&nbsp;<a href="<?php echo $addr . $st0; ?>" title="<?php echo $text[8]; ?>"><?php echo $text[8]; ?>&nbsp;<?php echo $text[7]; ?></a>&nbsp;</td>
<?php
   }?>
        </tr>
      </table>
    </td>
  </tr>
</table>
<?php
}
?>