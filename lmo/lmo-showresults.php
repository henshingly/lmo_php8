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

?>
<table class="lmoInner" cellspacing="0" cellpadding="0" border="0">
  <tr>
    <th colspan="<?php echo $breite; ?>" align="left"><?php
echo $st . '. ' . $text[2];
if ($dats == 1) {
    if ($datum1[$st - 1] != '') {
        echo ' ' . $text[3] . ' ' . $datum1[$st - 1];
    }
    if ($datum2[$st - 1] != '') {
        echo ' ' . $text[4] . ' ' . $datum2[$st - 1];
    }
}?></th>
  </tr>
<?php
// Wenn Spieltermine angegeben und Sortierung eingeschaltet, dann nach Datum sortieren
$datsort = $mterm[$st - 1];
if ($enablegamesort == '1' && filterZero($mterm[$st - 1])) {
    $datsort = $mterm[$st - 1];
    asort($datsort);
    reset($datsort);
}
$spielfreia = array();
$spielfreib = array();

foreach($datsort as $key => $val) {
    $i = $key;
    if (($teama[$st - 1][$i] > 0) && ($teamb[$st - 1][$i] > 0)) { ?>
  <tr><?php
        if ($datm == 1) {
            if(is_numeric($mterm[$st - 1][$i])) {
                $dt = new DateTime();
                $dt->setTimeStamp($mterm[$st - 1][$i]);
                $dum1 = $dt->format($datf);
            } else {
                $dum1 = '';
            }?>
    <td class="nobr"><?php echo $dum1; ?></td>
<?php
        }
        /* Spielfrei-Hack-Beginn1*/
    	$spielfreia[$i] = $teama[$st - 1][$i];
    	$spielfreib[$i] = $teamb[$st - 1][$i];
        /* Spielfrei-Hack-Ende1*/
?>
    <td width="2">&nbsp;</td>
    <td class="nobr" align="right"><?php
        if ($plan == "1") {
            echo '<a href="' . $addp . $teama[$st - 1][$i] . '" title="' . $text[269] . '">';
        }
        if (($favteam > 0) && ($favteam == $teama[$st - 1][$i])) {
            echo '<strong>';
        }
        echo $teams[$teama[$st - 1][$i]];
        if (($favteam > 0) && ($favteam == $teama[$st - 1][$i])) {
            echo '</strong>';
        }
        if ($plan == "1") {
            echo '</a>';
        }
        echo '&nbsp;' . HTML_smallTeamIcon($file, $teams[$teama[$st - 1][$i]], ' alt=""'); ?></td>
    <td align="center" width="10">-</td>
    <td class="nobr" align="left"><?php
        echo HTML_smallTeamIcon($file, $teams[$teamb[$st - 1][$i]], ' alt=""') . '&nbsp;';
        if ($plan == '1') {
            echo '<a href="' . $addp . $teamb[$st - 1][$i] . '" title="' . $text[269] . '">';
        }
        if (($favteam > 0) && ($favteam == $teamb[$st - 1][$i])) {
            echo '<strong>';
        }
        echo $teams[$teamb[$st - 1][$i]];
        if (($favteam > 0) && ($favteam == $teamb[$st - 1][$i])) {
            echo '</strong>';
        }
        if ($plan == '1') {
            echo '</a>';
        } ?></td>
    <td width="2">&nbsp;</td>
    <td align="right"><?php echo applyFactor($goala[$st - 1][$i], $goalfaktor); ?></td>
    <td align="center" width="8">:</td>
    <td align="left"><?php echo applyFactor($goalb[$st - 1][$i], $goalfaktor); ?></td>
<?php
        if ($spez == 1) { ?>
    <td width="2">&nbsp;</td>
    <td><?php echo $mspez[$st - 1][$i]; ?></td>
<?php
        }
        if ($msieg[$st - 1][$i] == 3) { ?>
    <td align="center" width="2">/</td>
    <td align="right"><?php echo applyFactor($goalb[$st - 1][$i], $goalfaktor); ?></td>
    <td align="center" width="8">:</td>
    <td align="left"><?php echo applyFactor($goala[$st - 1][$i], $goalfaktor); ?></td>
<?php
        }?>
    <td width="2">&nbsp;</td>
    <td class="nobr"><?php
        /** Mannschaftsicons finden **/
        $lmo_teamaicon = '';
        $lmo_teambicon = '';
        if ($urlb == 1 || $mnote[$st - 1][$i] != '' || $msieg[$st - 1][$i] > 0) {
            $lmo_teamaicon = HTML_smallTeamIcon($file, $teams[$teama[$st - 1][$i]], ' alt=""');
            $lmo_teambicon = HTML_smallTeamIcon($file, $teams[$teamb[$st - 1][$i]], ' alt=""');
        }
        /** Spielbericht verlinken **/
        if ($urlb == 1) {
            if ($mberi[$st - 1][$i] != '') {
                //Spielbericht Inhalt
                $lmo_spielbericht_html = '<strong>' . $teams[$teama[$st - 1][$i]] . $lmo_teamaicon . ' - ' . $lmo_teambicon . $teams[$teamb[$st - 1][$i]] . '</strong>' . nl2br($text[270]);
                // Link mit Mouseover-Funktion und data-info Attribut
                echo '<span onmouseover="showLMOTooltip(this)" onmouseout="hideLMOTooltip()" data-info="' . htmlspecialchars($lmo_spielbericht_html) . '" class="tooltip-trigger"><a href="' . $mberi[$st - 1][$i] . '" target="_blank"><img src="' . URL_TO_IMGDIR . '/lmo-st1.svg" height="15" class="svg-no-style" border="0" alt=""></a></span>&nbsp;';
            } else {
                echo '&nbsp;';
            }
        }
        /** Notizen anzeigen **/
        if ($mnote[$st - 1][$i] != '' || $msieg[$st - 1][$i] > 0) {
            //Grüner Tisch: Beidseitiges Ergebnis vorbereiten
            $lmo_notiz_both = ($msieg[$st - 1][$i] == 3) ? ' / ' . applyFactor($goalb[$st - 1][$i], $goalfaktor) . ':' . applyFactor($goala[$st - 1][$i], $goalfaktor) : '';
            //Alles in EIN Tag packen, damit das CSS es als EINE zentrierte Zeile erkennt
            $lmo_spielnotiz = '<strong>' . $teams[$teama[$st - 1][$i]] . $lmo_teamaicon . ' - ' . $lmo_teambicon . $teams[$teamb[$st - 1][$i]] . '&nbsp;&nbsp;' . applyFactor($goala[$st - 1][$i], $goalfaktor) . ':' . applyFactor($goalb[$st - 1][$i], $goalfaktor) . $lmo_notiz_both . '</strong>';
            if ($spez == 1) {
                $lmo_spielnotiz .= '&nbsp;' . $mspez[$st - 1][$i] . '<br>';
            }
            //Grüner Tisch: Heimteam siegt
            if ($msieg[$st - 1][$i] == 1) {
                $lmo_spielnotiz .= '<strong>' . $text[219] . ':</strong>' . $teams[$teama[$st - 1][$i]] . '&nbsp;' . $text[211] . '<br>';
            }
            //Grüner Tisch: Gastteam siegt
            if ($msieg[$st - 1][$i] == 2) {
                $lmo_spielnotiz .= '<strong>' . $text[219] . ':</strong>' . $teams[$teamb[$st - 1][$i]] . '&nbsp;' . $text[211] . '<br>';
            }
            //Grüner Tisch: Beidseitiges Ergebnis
            if ($msieg[$st - 1][$i] == 3) {
                $lmo_spielnotiz .= '<strong>' . $text[219] . ':</strong>' . $text[212] . '<br>';
            }
            //Allgemeine Notiz
            if ($mnote[$st - 1][$i] != '') {
                $lmo_spielnotiz .= '<strong>' . $text[22] . ':</strong>' . $mnote[$st - 1][$i];
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
        echo $text[38] . ': ' . applyFactor($zutore[$st], $goalfaktor) . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . ' ' . $text[38] . $text[4001] . ': ' . applyFactor($dstore[$st], $goalfaktor);
    }?></td>
  </tr>
<?php
}

if ($einspielfrei == 1) { ?>
  <tr>
    <td align="center" width="100%" colspan="<?php echo $breite; ?>"><?php

    $spielfreic = array_merge($spielfreia, $spielfreib);
    $hoy5 = 1;
    for ($hoy8 = 1; $hoy8 < $anzteams+1; $hoy8++) {
        if (!in_array($hoy8, $spielfreic)) {
            if ($hoy5 == 1) {
                echo $text[4004] . ': ';
            }
            $hoy5++;

            if ($plan == '1') {
                echo '<a href="' . $addp . $hoy8 . '" title="' . $text[269] . '">';
            }
            if (($favteam > 0) && ($favteam == $hoy8)) {
                echo '<strong>';
            }
            echo $teams[$hoy8];
            if (($favteam > 0) && ($favteam == $hoy8)) {
                echo '</strong>';
            }
            if ($plan == '1') {
                echo '</a>';
            }
            echo '&nbsp;' . HTML_smallTeamIcon($file, $teams[$hoy8], ' alt=""');
        }
    } ?></td>
  </tr>
<?php
}?>
</table>
