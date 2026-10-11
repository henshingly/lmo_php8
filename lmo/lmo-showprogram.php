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
 * @var string $defdateformat Datumsformat in date()-Schreibweise (Konfiguration)
 */

if ($file != '') {
    $addp = $_SERVER['PHP_SELF'] . '?action=program&amp;file=' . $file . '&amp;selteam=';
    $addr = $_SERVER['PHP_SELF'] . '?action=results&amp;file=' . $file . '&amp;st=';
    // Einstellungen der Liga mit Vorgabewerten (Lmo\Liga\Einstellungen)
    $lmo_einstellungen = $lmo_liga->einstellungen();
    $lmo_selteam = !empty($_GET['selteam']) ? $_GET['selteam'] : $lmo_einstellungen->vorgewaehlteMannschaft();
?>

<table class="lmoMiddle" cellspacing="0" cellpadding="0" border="0">
  <tr>
    <td valign="top" align="center">
      <table class="lmoMenu" cellspacing="0" cellpadding="0" border="0">
<?php
    foreach ($lmo_liga->alleMannschaften() as $i => $lmo_mannschaft) { ?>
        <tr>
          <td align="right">
            <acronym title="<?php echo $text[23] . '&nbsp;' . $lmo_mannschaft->anzeigename(); ?>"><?php
        if ($i != $lmo_selteam) { ?><a href="<?php echo $addp . $i?>"><?php echo $lmo_mannschaft->kurzname(); ?></a><?php
        } else {
            echo $lmo_mannschaft->kurzname();
        } ?></acronym>
          </td>
          <td>&nbsp;<?php echo HTML_smallTeamIcon($file, $lmo_mannschaft->anzeigename(), ' alt=""'); ?></td>
        </tr>
<?php
    } ?>
      </table>
    </td>
    <td valign="top" align="center">
      <table class="lmoInner" cellspacing="0" cellpadding="0" border="0">
<?php
    if ($lmo_selteam == 0) {
        echo '        <tr><td align="center">&nbsp;<br>' . $text[24] . '<br>&nbsp;</td></tr>';
    } else {
        // alle Spiele der Liga zum Anzeigen (Lmo\Liga\Spiel)
        foreach ($lmo_liga->alleSpiele() as $lmo_spiel) {
            // $j und $i wie bisher: Spieltag und Partie ab 0 (eingebundene Addons rechnen damit)
            $j = $lmo_spiel->spieltag - 1;
            $i = $lmo_spiel->partie - 1;
            if (($lmo_selteam == $lmo_spiel->heim) || ($lmo_selteam == $lmo_spiel->gast)) {
                // steht eine Mannschaft noch nicht fest, heisst sie "___"
                $lmo_heim = $lmo_spiel->heimName('___');
                $lmo_gast = $lmo_spiel->gastName('___');
                $lmo_zusatz = $lmo_spiel->zusatzText($text[0], $text[1]);
?>
        <tr>
          <th style="text-align:right">&nbsp;<a href="<?php echo $addr . ($j + 1); ?>" title="<?php echo $text[25]; ?>"><?php echo $j + 1; ?></a>&nbsp;</th>
<?php
                if ($lmo_einstellungen->mitAnstosszeit()) {
                    if ($lmo_spiel->anstoss !== null) {
                        $dt = new DateTime();
                        $dt->setTimeStamp($lmo_spiel->anstoss);
                        $dum1 = $dt->format($lmo_einstellungen->datumsformat($defdateformat));
                    } else {
                        $dum1 = '';
                    }
?>
          <td style="width:2px;">&nbsp;</td>
          <td class="nobr"><?php echo $dum1; ?></td>
<?php
                } ?>
          <td style="width:2px;">&nbsp;</td>
          <td class="nobr" align="right"><?php
                if ($lmo_selteam == $lmo_spiel->heim) {
                    echo '<strong>';
                }
                echo $lmo_heim;
                if ($lmo_selteam == $lmo_spiel->heim) {
                    echo '</strong>';
                }
                echo '&nbsp;' . HTML_smallTeamIcon($file, $lmo_heim, ' alt=""'); ?></td>
          <td align="center" style="width:10px;">-</td>
          <td class="nobr" align="left"><?php
                echo HTML_smallTeamIcon($file, $lmo_gast, ' alt=""') . '&nbsp;';
                if ($lmo_selteam == $lmo_spiel->gast) {
                    echo '<strong>';
                }
                echo $lmo_gast;
                if ($lmo_selteam == $lmo_spiel->gast) {
                    echo '</strong>';
                } ?></td>
          <td style="width:2px;">&nbsp;</td>
          <td align="right"><?php echo $lmo_spiel->toreHeimText($lmo_einstellungen->torfaktor()); ?></td>
          <td align="center" style="width:8px;">:</td>
          <td align="left"><?php echo $lmo_spiel->toreGastText($lmo_einstellungen->torfaktor()); ?></td>
<?php
                if ($lmo_einstellungen->mitVerlaengerung()) { ?>
          <td style="width:2px;">&nbsp;</td>
          <td align="left"><?php echo $lmo_zusatz; ?></td>
<?php
                } ?>
          <td style="width:2px;">&nbsp;</td>
          <td class="nobr"><?php
                /** Mannschaftsicons finden */
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
                        echo '<span onmouseover="showLMOTooltip(this)" onmouseout="hideLMOTooltip()" data-info="' . htmlspecialchars($lmo_spielbericht_html) . '" class="tooltip-trigger"><img src="' . URL_TO_IMGDIR . '/lmo-st1.svg" height="15" class="svg-no-style" alt=""></span>&nbsp;';
                    } else {
                        echo '&nbsp;';
                    }
                }
                /** Notizen anzeigen **/
                if ($lmo_spiel->notiz != '' || $lmo_spiel->wertung > 0) {
                    //Grüner Tisch: Beidseitiges Ergebnis vorbereiten
                    $lmo_notiz_both = ($lmo_spiel->wertung == 3) ? ' / ' . $lmo_spiel->toreGastText($lmo_einstellungen->torfaktor()) . ':' . $lmo_spiel->toreHeimText($lmo_einstellungen->torfaktor()) : '';
                    //Alles in EIN Tag packen, damit das CSS es als EINE zentrierte Zeile erkennt
                    $lmo_spielnotiz = '<strong>' . $lmo_heim . $lmo_teamaicon . ' - ' . $lmo_teambicon . $lmo_gast . '&nbsp;&nbsp;' . $lmo_spiel->toreHeimText($lmo_einstellungen->torfaktor()) . ':' . $lmo_spiel->toreGastText($lmo_einstellungen->torfaktor()) . $lmo_notiz_both . '</strong>';
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
                        $lmo_spielnotiz .= '<strong>' . $text[22] . ':</strong>' . $lmo_spiel->notiz . '<br>';
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
        </tr>
<?php
            }
        }
    } ?>
      </table>
    </td>
  </tr>
</table>
<?php
}
// Teamplan ADDON BEGIN
if (file_exists(PATH_TO_ADDONDIR . '/pdf/lmo-showprogram.inc.php'))
    include(PATH_TO_ADDONDIR . '/pdf/lmo-showprogram.inc.php');
// Teamplan ADDON END
?>