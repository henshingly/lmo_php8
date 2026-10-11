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
 * @var int|string $st gewaehlter Spieltag
 */

if ($file != '') {
    $addp = $_SERVER['PHP_SELF'] . '?action=program&amp;file=' . $file . '&amp;selteam=';
    $addr = $_SERVER['PHP_SELF'] . '?action=results&amp;file=' . $file . '&amp;st=';
    $ligaDaten->selteam =! empty($_GET['selteam']) ? $_GET['selteam'] : $ligaDaten->selteam;
?>

<table class="lmoMiddle" cellspacing="0" cellpadding="0" border="0">
  <tr>
    <td valign="top" align="center">
      <table class="lmoMenu" cellspacing="0" cellpadding="0" border="0">
<?php
    for ($i = 1; $i <= $ligaDaten->anzteams; $i++) { ?>
        <tr>
          <td align="right">
            <acronym title="<?php echo $text[23] . '&nbsp;' . $ligaDaten->teams[$i]; ?>"><?php
        if ($i != $ligaDaten->selteam) { ?><a href="<?php echo $addp . $i?>"><?php echo $ligaDaten->teamk[$i]; ?></a><?php
        } else {
            echo $ligaDaten->teamk[$i];
        } ?></acronym>
          </td>
          <td>&nbsp;<?php echo HTML_smallTeamIcon($file, $ligaDaten->teams[$i], ' alt=""'); ?></td>
        </tr>
<?php
    } ?>
      </table>
    </td>
    <td valign="top" align="center">
      <table class="lmoInner" cellspacing="0" cellpadding="0" border="0">
<?php
    if ($ligaDaten->selteam == 0) {
        echo '        <tr><td align="center">&nbsp;<br>' . $text[24] . '<br>&nbsp;</td></tr>';
    } else {
        for ($j = 0; $j < $ligaDaten->anzst; $j++) {
            for ($i = 0; $i < $ligaDaten->anzsp; $i++) {
                if (($ligaDaten->selteam == $ligaDaten->teama[$j][$i]) || ($ligaDaten->selteam == $ligaDaten->teamb[$j][$i])) {
?>
        <tr>
          <th style="text-align:right">&nbsp;<a href="<?php echo $addr . ($j + 1); ?>" title="<?php echo $text[25]; ?>"><?php echo $j + 1; ?></a>&nbsp;</th>
<?php
                    if ($ligaDaten->datm == 1) {
                        if(is_numeric($ligaDaten->mterm[$j][$i])) {
                            $dt = new DateTime();
                            $dt->setTimeStamp((int)$ligaDaten->mterm[$j][$i]);
                            $dum1 = $dt->format($ligaDaten->datf);
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
                    if ($ligaDaten->selteam == $ligaDaten->teama[$j][$i]) {
                        echo '<strong>';
                    }
                    echo $ligaDaten->teams[$ligaDaten->teama[$j][$i]];
                    if ($ligaDaten->selteam == $ligaDaten->teama[$j][$i]) {
                        echo '</strong>';
                    }
                    echo '&nbsp;' . HTML_smallTeamIcon($file, $ligaDaten->teams[$ligaDaten->teama[$j][$i]], ' alt=""'); ?></td>
          <td align="center" style="width:10px;">-</td>
          <td class="nobr" align="left"><?php
                    echo HTML_smallTeamIcon($file, $ligaDaten->teams[$ligaDaten->teamb[$j][$i]], ' alt=""') . '&nbsp;';
                    if ($ligaDaten->selteam == $ligaDaten->teamb[$j][$i]) {
                        echo '<strong>';
                    }
                    echo $ligaDaten->teams[$ligaDaten->teamb[$j][$i]];
                    if ($ligaDaten->selteam == $ligaDaten->teamb[$j][$i]) {
                        echo '</strong>';
                    } ?></td>
          <td style="width:2px;">&nbsp;</td>
          <td align="right"><?php echo applyFactor($ligaDaten->goala[$j][$i], $ligaDaten->goalfaktor); ?></td>
          <td align="center" style="width:8px;">:</td>
          <td align="left"><?php echo applyFactor($ligaDaten->goalb[$j][$i], $ligaDaten->goalfaktor); ?></td>
<?php
                    if ($ligaDaten->spez == 1) { ?>
          <td style="width:2px;">&nbsp;</td>
          <td align="left"><?php echo $ligaDaten->mspez[$j][$i]; ?></td>
<?php
                    } ?>
          <td style="width:2px;">&nbsp;</td>
          <td class="nobr"><?php
                    /** Mannschaftsicons finden */
                    $lmo_teamaicon = '';
                    $lmo_teambicon = '';
                    if ($ligaDaten->urlb == 1 || $ligaDaten->mnote[$j][$i] != '' || $ligaDaten->msieg[$j][$i] > 0) {
                        $lmo_teamaicon = HTML_smallTeamIcon($file, $ligaDaten->teams[$ligaDaten->teama[$j][$i]], ' alt=""');
                        $lmo_teambicon = HTML_smallTeamIcon($file, $ligaDaten->teams[$ligaDaten->teamb[$j][$i]], ' alt=""');
                    }
                    /** Spielbericht verlinken **/
                    if ($ligaDaten->urlb == 1) {
                        if ($ligaDaten->mberi[$j][$i] != '') {
                            //Spielbericht Inhalt
                            $lmo_spielbericht_html = '<strong>' . $ligaDaten->teams[$ligaDaten->teama[$j][$i]] . $lmo_teamaicon . ' - ' . $lmo_teambicon . $ligaDaten->teams[$ligaDaten->teamb[$j][$i]] . '</strong>' . nl2br($text[270]);
                            // Link mit Mouseover-Funktion und data-info Attribut
                            echo '<span onmouseover="showLMOTooltip(this)" onmouseout="hideLMOTooltip()" data-info="' . htmlspecialchars($lmo_spielbericht_html) . '" class="tooltip-trigger"><img src="' . URL_TO_IMGDIR . '/lmo-st1.svg" height="15" class="svg-no-style" alt=""></span>&nbsp;';
                        } else {
                            echo '&nbsp;';
                        }
                    }
                    /** Notizen anzeigen **/
                    if ($ligaDaten->mnote[$j][$i] != '' || $ligaDaten->msieg[$j][$i] > 0) {
                        //Grüner Tisch: Beidseitiges Ergebnis vorbereiten
                        $lmo_notiz_both = ($ligaDaten->msieg[$st - 1][$i] == 3) ? ' / ' . applyFactor($ligaDaten->goalb[$st - 1][$i], $ligaDaten->goalfaktor) . ':' . applyFactor($ligaDaten->goala[$st - 1][$i], $ligaDaten->goalfaktor) : '';
                        //Alles in EIN Tag packen, damit das CSS es als EINE zentrierte Zeile erkennt
                        $lmo_spielnotiz = '<strong>' . $ligaDaten->teams[$ligaDaten->teama[$j][$i]] . $lmo_teamaicon . ' - ' . $lmo_teambicon . $ligaDaten->teams[$ligaDaten->teamb[$j][$i]] . '&nbsp;&nbsp;' . applyFactor($ligaDaten->goala[$j][$i], $ligaDaten->goalfaktor) . ':' . applyFactor($ligaDaten->goalb[$j][$i], $ligaDaten->goalfaktor) . $lmo_notiz_both . '</strong>';
                        if ($ligaDaten->spez == 1) {
                            $lmo_spielnotiz .= '&nbsp;' . $ligaDaten->mspez[$j][$i] . '<br>';
                        }
                        //Grüner Tisch: Heimteam siegt
                        if ($ligaDaten->msieg[$j][$i] == 1) {
                            $lmo_spielnotiz .= '<strong>' . $text[219] . ':</strong>' . $ligaDaten->teams[$ligaDaten->teama[$j][$i]] . '&nbsp;' . $text[211] . '<br>';
                        }
                        //Grüner Tisch: Gastteam siegt
                        if ($ligaDaten->msieg[$j][$i] == 2) {
                            $lmo_spielnotiz .= '<strong>' . $text[219] . ':</strong>' . $ligaDaten->teams[$ligaDaten->teamb[$j][$i]] . '&nbsp;' . $text[211] . '<br>';
                        }
                        //Grüner Tisch: Beidseitiges Ergebnis
                        if ($ligaDaten->msieg[$j][$i] == 3) {
                            $lmo_spielnotiz .= '<strong>' . $text[219] . ':</strong>' . $text[212] . '<br>';
                        }
                        //Allgemeine Notiz
                        if ($ligaDaten->mnote[$j][$i] != '') {
                            $lmo_spielnotiz .= '<strong>' . $text[22] . ':</strong>' . $ligaDaten->mnote[$j][$i] . '<br>';
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