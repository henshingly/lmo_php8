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
 *
 * Werden auch in dieser Datei gesetzt, aber nicht auf jedem Weg (koennen von aussen kommen):
 * @var mixed $dumn1
 * @var mixed $dumn2
 */

if ($file != '') {
    $addp = $_SERVER['PHP_SELF'] . '?action=program&amp;file=' . $file . '&amp;selteam=';
    $addr = $_SERVER['PHP_SELF'] . '?action=results&amp;file=' . $file . '&amp;st=';
    // Einstellungen der Liga mit Vorgabewerten (Lmo\Liga\Einstellungen) und alle Mannschaften nach Nummer
    $lmo_einstellungen = $lmo_liga->einstellungen();
    $lmo_anzteams = $lmo_einstellungen->mannschaften();
    $lmo_runden = $lmo_einstellungen->spieltage();
    $lmo_mannschaften = iterator_to_array($lmo_liga->alleMannschaften());
    $lmo_selteam = !empty($_GET['selteam']) ? $_GET['selteam'] : $lmo_einstellungen->vorgewaehlteMannschaft();?>

<table class="lmoMiddle" cellspacing="0" cellpadding="0" border="0">
  <tr>
    <td valign="top" align="center">
      <table class="lmoMenu" cellspacing="0" cellpadding="0" border="0"><?php
    for ($i = 1; $i <= floor($lmo_anzteams / 2); $i++) { ?>
        <tr>
          <td align="right">
            <acronym title="<?php echo $text[23] . ' ' . $lmo_mannschaften[$i]->anzeigename(); ?>">
<?php
        if ($i != $lmo_selteam) { ?>
              <a href="<?php echo $addp . $i; ?>" ><?php echo $lmo_mannschaften[$i]->kurzname(); ?></a>
<?php
        } else {
            echo $lmo_mannschaften[$i]->kurzname();
        } ?>
            </acronym>
          </td>
          <td>&nbsp;<?php echo HTML_smallTeamIcon($file, $lmo_mannschaften[$i]->anzeigename(), ' alt=""'); ?>&nbsp;</td>
        </tr>
<?php
    } ?>
      </table>
    </td>
    <td valign="top" align="center">
      <table class="lmoInner" cellspacing="0" cellpadding="0" border="0">
<?php
    if ($lmo_selteam == 0) { ?>
        <tr>
          <td align="center" class="lmost5">&nbsp;<br><?php echo $text[24]; ?><br>&nbsp;</td>
        </tr>
<?php
    } else {
        // $j: Runde ab 0
        for ($j = 0; $j < $lmo_runden; $j++) {
            // die Paarungen der Runde zum Anzeigen (Lmo\Liga\Paarung)
            foreach ($lmo_liga->paarungen($j + 1) as $lmo_paarung) {
                // steht eine Mannschaft noch nicht fest, heisst sie "___"
                $lmo_heim = $lmo_paarung->heim > 0 ? $lmo_paarung->heimMannschaft()->anzeigename() : '___';
                $lmo_gast = $lmo_paarung->gast > 0 ? $lmo_paarung->gastMannschaft()->anzeigename() : '___';
                $lmo_heim_url = $lmo_paarung->heimMannschaft()->werte['URL'] ?? '';
                $lmo_gast_url = $lmo_paarung->gastMannschaft()->werte['URL'] ?? '';
                if (($lmo_selteam == $lmo_paarung->heim) || ($lmo_selteam == $lmo_paarung->gast)) { ?>
        <tr>
<?php
                    if ($j == $lmo_runden-1) {
                        $l = $text[364];
                    } elseif ($j == $lmo_runden - 2) {
                        $l = $text[362];
                    } elseif ($j == $lmo_runden - 3) {
                        $l = $text[360];
                    } elseif ($j == $lmo_runden - 4) {
                        $l = $text[358];
                    } else {
                        $l = $j + 1;
                    }?>
          <th align="right">&nbsp;<a href="<?php echo $addr.($j + 1); ?>" title="<?php echo $text[377]; ?>"><?php echo $l; ?></a>&nbsp;</th>
<?php
                    // wer die Paarung gewonnen hat: 1 = Heim, 2 = Gast
                    $m = $lmo_paarung->sieger();
                    if ($m == 1) { ?>
          <td class="lmoTurnierSieger nobr" align="right"><?php
                    } elseif ($m == 2) { ?>
          <td class="lmoTurnierVerlierer nobr" align="right"><?php
                    } else { ?>
          <td class="nobr" align="right"><?php
                    }
                    if ($lmo_selteam == $lmo_paarung->heim) {
                        echo '<strong>';
                    }
                    echo $lmo_heim;
                    if ($lmo_selteam == $lmo_paarung->heim) {
                        echo '</strong>';
                    }
                    echo '&nbsp;' . HTML_smallTeamIcon($file, $lmo_heim,' alt=""');
                    if (($lmo_heim_url != '') && $lmo_einstellungen->mitMannschaftslinks()) {
                        echo ' <a href="' . $lmo_heim_url . '" target="_blank" title="' . $text[46] . '"><img border="0" width="11" src="' . URL_TO_IMGDIR . '/url.png" alt="' . $text[564] . '" title="' . $text[46] . '"></a>';
                    } ?></td>
          <td class="lmost5" align="center" width="10">-</td>
<?php
                    if ($m == 2) { ?>
          <td class="lmoTurnierSieger nobr"><?php
                    } elseif ($m == 1) { ?>
          <td align="left" class="lmoTurnierVerlierer nobr"><?php
                    } else { ?>
          <td align="left" class="nobr"><?php
                    }
                    echo HTML_smallTeamIcon($file, $lmo_gast, ' alt=""') . '&nbsp;';
                    if ($lmo_selteam == $lmo_paarung->gast) {
                        echo '<strong>';
                    }
                    echo $lmo_gast;
                    if ($lmo_selteam == $lmo_paarung->gast) {
                        echo '</strong>';
                    }
                    if (($lmo_gast_url != '') && $lmo_einstellungen->mitMannschaftslinks()) {
                        echo '<a href="' . $lmo_gast_url . '" target="_blank" title="' . $text[46] . '"><img border="0" width="11" src="' . URL_TO_IMGDIR . '/url.png" alt="' . $text[564] . '" title="' . $text[46] . '"></a>';
                    } ?></td>
<?php
                    // die Spiele der Paarung (Lmo\Liga\Spiel); $n: Spiel ab 0
                    foreach ($lmo_paarung->spiele as $n => $lmo_spiel) {
                        if ($lmo_einstellungen->mitAnstosszeit()) {
                            if ($lmo_spiel->anstoss !== null) {  // ohne Anstoss keine Anzeige
                                $dt = new DateTime();
                                $dt->setTimeStamp($lmo_spiel->anstoss);
                                $dumn1 = '<acronym title="' . $dt->format($lmo_einstellungen->datumsformat($defdateformat)) . '">';
                                $dumn2 = '</acronym>';
                            } else {
                                $dumn1 = '';
                                $dumn2 = '';
                            }
                        }
                        if ($n == 0) {
                            echo '          <td width="2">&nbsp;</td>';
                        } else {
                            echo '          <td width="8">|&nbsp;&nbsp;</td>';
                        }?>
          <td class="nobr"><?php echo $dumn1;?><?php echo $lmo_spiel->toreHeimText($lmo_einstellungen->torfaktor()); ?>&nbsp;:&nbsp;<?php echo $lmo_spiel->toreGastText($lmo_einstellungen->torfaktor()); ?><?php echo $lmo_spiel->zusatzText($text[0], $text[1]); ?><?php echo $dumn2; ?><?php
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
                                // Header für Spielbericht
                                $lmo_spielbericht_html = '<strong>' . $lmo_heim . $lmo_teamaicon . ' - ' . $lmo_teambicon . $lmo_gast . '</strong>' . nl2br($text[270]);

                                // Link mit Mouseover-Funktion und data-info Attribut
                                echo '<span onmouseover="showLMOTooltip(this)" onmouseout="hideLMOTooltip()" data-info="' . htmlspecialchars($lmo_spielbericht_html) . '" class="tooltip-trigger"><a href="' . $lmo_spiel->bericht . '" target="_blank"><img src="' . URL_TO_IMGDIR . '/lmo-st1.svg" height="15" class="svg-no-style" border="0" alt=""></a></span>&nbsp;';
                            } else {
                                echo '&nbsp;';
                            }
                        }
                        /** Notizen anzeigen **/
                        if ($lmo_spiel->notiz != '') {
                            //Zentrierte Kopfzeile für Notizen
                            $lmo_spielnotiz = '<strong>' . $lmo_heim . $lmo_teamaicon . ' - ' . $lmo_teambicon . $lmo_gast . '&nbsp;&nbsp;' . $lmo_spiel->toreHeimText($lmo_einstellungen->torfaktor()) . ':' . $lmo_spiel->toreGastText($lmo_einstellungen->torfaktor()) . '</strong>';
                            //Allgemeine Notiz
                            $lmo_spielnotiz .= '<br><strong>' . $text[22] . ':</strong> ' . $lmo_spiel->notiz;

                            //Ausgabe als neutrales Element (kein Link)
                            echo '&nbsp;<span onmouseover="showLMOTooltip(this)" onmouseout="hideLMOTooltip()" data-info="' . htmlspecialchars(nl2br($lmo_spielnotiz)) . '" class="tooltip-trigger"><img src="' . URL_TO_IMGDIR . '/lmo-st2.svg" height="15" class="svg-no-style" border="0" alt=""></span>';
                            $lmo_spielnotiz = '';
                        } else {
                            echo '&nbsp;';
                        }?></td>
<?php
                    }?>
        </tr><?php
                }
            }
        }
    }?>
      </table>
    </td>
    <td valign="top" align="center">
      <table class="lmoMenu" cellspacing="0" cellpadding="0" border="0"><?php
    for ($i = ceil($lmo_anzteams / 2) + 1; $i <= $lmo_anzteams; $i++) { ?>
        <tr>
          <td>&nbsp;<?php echo HTML_smallTeamIcon($file, $lmo_mannschaften[$i]->anzeigename(), ' alt=""'); ?></td>
          <td align="left">
            <acronym title="<?php echo $text[23] . ' ' . $lmo_mannschaften[$i]->anzeigename(); ?>">
<?php
        if ($i != $lmo_selteam) { ?>
            <a href="<?php echo $addp . $i; ?>"><?php echo $lmo_mannschaften[$i]->kurzname(); ?></a>
<?php
        } else {
            echo $lmo_mannschaften[$i]->kurzname();
        }?></acronym>
          </td>
        </tr><?php
    }?>
      </table>
    </td>
  </tr>
</table>
<?php
}
?>