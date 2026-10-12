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
 * @var \Lmo\Liga\LigaDaten $ligaDaten Daten der geladenen Liga (lmo-ligadaten.php)
 * @var \Lmo\Liga\Rohdaten\Liga $lmo_liga Rohdaten der geladenen Liga (lmo-openfile.php)
 * @var \Lmo\Liga\Einstellungen $lmo_einstellungen Einstellungen der Liga (lmo-tippedit.php)
 * @var list<\Lmo\Liga\Paarung> $lmo_tipp_paarungen Paarungen der Runde, Index wie die Tipps (lmo-tippedit.php)
 * @var string $defdateformat Datumsformat in date()-Schreibweise (Konfiguration)
 * @var array<int|string, mixed> $text Sprachtexte
 * @var string $file Ligadatei relativ zum Ligenordner, leer wenn keine geladen ist
 * @var int|string $st gewaehlter Spieltag
 *
 * Einstellungen:
 * @var int|string $tipp_einsichterst Einstellung aus tipp/cfg.txt
 * @var int|string $tipp_jokertipp Einstellung aus tipp/cfg.txt
 * @var int|string $tipp_jokertippmulti Einstellung aus tipp/cfg.txt
 * @var int|string $tipp_pfeiltipp Einstellung aus tipp/cfg.txt
 * @var int|string $tipp_showdurchschntipp Einstellung aus tipp/cfg.txt
 * @var int|string $tipp_showtendenzabs Einstellung aus tipp/cfg.txt
 * @var int|string $tipp_showtendenzpro Einstellung aus tipp/cfg.txt
 * @var int|string $tipp_tippmodus Einstellung aus tipp/cfg.txt
 *
 * Weitere Variablen des einbindenden Codes:
 * @var array<int|string, mixed> $btip
 * @var mixed $i
 * @var mixed $jksp
 * @var mixed $tipp_jokertippaktiv
 * @var mixed $trans_lang
 *
 * Werden auch in dieser Datei gesetzt, aber nicht auf jedem Weg (koennen von aussen kommen):
 * @var array<int|string, mixed> $goaltippa
 * @var array<int|string, mixed> $goaltippb
 * @var mixed $punktespieltag
 */
// die Paarung dieser Zeile (Lmo\Liga\Paarung) aus lmo-tippedit.php, mit ihren Mannschaften
$lmo_paarung = $lmo_tipp_paarungen[$i];
$lmo_heim = $lmo_paarung->heimMannschaft()->anzeigename();
$lmo_gast = $lmo_paarung->gastMannschaft()->anzeigename();
$lmo_favteam = $lmo_einstellungen->lieblingsmannschaft();
$lmo_faktor = $lmo_einstellungen->torfaktor();
// in der Liga hat die Paarung genau ein Spiel (Lmo\Liga\Spiel)
$lmo_spiel = $lmo_paarung->spiele[0];
  ?>

          <tr>
<?php
if ($tipp_einsichterst == 2) {
    if ($lmo_spiel->toreHeim !== null && $lmo_spiel->toreGast !== null) {
        $btip1 = false;
    } else {
        $btip1 = true;
    }
} else {
    $btip1 = false;
}

if ($lmo_einstellungen->mitAnstosszeit()) {
    if ($lmo_spiel->anstoss !== null) {
        $dum1 = strtr(date($lmo_einstellungen->datumsformat($defdateformat), $lmo_spiel->anstoss), $trans_lang);
    } else {
        $dum1 = '';
    } ?>
            <td class="nobr" align="left"><?php echo $dum1; ?></td>
<?php
}
?>
            <td>&nbsp;</td>
            <td class="nobr" align="right"><?php
if (($lmo_favteam > 0) && ($lmo_favteam == $lmo_paarung->heim)) {
    echo '<strong>';
}
echo $lmo_heim;
if (($lmo_favteam > 0) && ($lmo_favteam == $lmo_paarung->heim)) {
    echo '</strong>';
} ?></td>
            <td align="center" width="10">-</td>
            <td class="nobr" align="left"><?php
if (($lmo_favteam> 0 ) && ($lmo_favteam == $lmo_paarung->gast)) {
    echo '<strong>';
}
echo $lmo_gast;
if (($lmo_favteam > 0) && ($lmo_favteam == $lmo_paarung->gast)) {
    echo '</strong>';
}

if ($goaltippa[$i] == '_') {
    $goaltippa[$i] = '';
}
if ($goaltippb[$i] == '_') {
    $goaltippb[$i] = '';
}
if ($goaltippa[$i] == '-1') {
    $goaltippa[$i] = '';
}
if ($goaltippb[$i] == '-1') {
    $goaltippb[$i] = '';
} ?></td>
            <td>&nbsp;</td>
<?php
if ($tipp_showtendenzabs == 1) { ?>
            <td align="center" class="nobr"><?php
    if ($btip1 == false) {
        if (!isset($tendenz1[$i])) {
            $tendenz1[$i] = 0;
        }
        if (!isset($tendenz0[$i])) {
            $tendenz0[$i] = 0;
        }
        if (!isset($tendenz2[$i])) {
            $tendenz2[$i] = 0;
        }
        echo $tendenz1[$i] . '-' . $tendenz0[$i] . '-' . $tendenz2[$i];
    } ?></td>
            <td>&nbsp;</td>
<?php
}
if ($tipp_showtendenzpro == 1) { ?>
            <td align="center" class="nobr"><?php
    if ($btip1 == false) {
        if (!isset($anzgetippt[$i])) {
            $anzgetippt[$i] = 0;
        }
        if ($anzgetippt[$i] > 0) {
            if (!isset($tendenz1[$i])) {
                $tendenz1[$i] = 0;
            }
            if (!isset($tendenz0[$i])) {
                $tendenz0[$i] = 0;
            }
            if (!isset($tendenz2[$i])) {
                $tendenz2[$i] = 0;
            }
            echo number_format(($tendenz1[$i] / $anzgetippt[$i] * 100), 0, '.', ',') . '%-' . number_format(($tendenz0[$i] / $anzgetippt[$i] * 100), 0, '.', ',') . '%-' . number_format(($tendenz2[$i] / $anzgetippt[$i] * 100), 0, '.', ',') . '%';
        } else {
            echo '&nbsp;';
        }
    } ?></td>
            <td>&nbsp;</td>
<?php
}
if ($btip[$i] == true) {
    $savebutton = 1;
}

/**ERGEBNISMODUS*/
if ($tipp_tippmodus == 1) {
    if ($tipp_showdurchschntipp == 1) { ?>
            <td align="center" class="nobr"><?php
        if ($btip1 == false) {
            if (!isset($anzgetippt[$i])) {
                $anzgetippt[$i] = 0;
            }
            if ($anzgetippt[$i] > 0) {
                if (!isset($toregesa[$i])) {
                    $toregesa[$i] = 0;
                }
                if (!isset($toregesb[$i])) {
                    $toregesb[$i] = 0;
                }
                if ($toregesa[$i] < 10 && $toregesb[$i] < 10) {
                    $nachkomma = 1;
                } else {
                    $nachkomma=0;
                }
                echo number_format((applyFactor($toregesa[$i], $lmo_faktor) / $anzgetippt[$i]), $nachkomma, '.', ',') . ':' . number_format((applyFactor($toregesb[$i], $lmo_faktor) / $anzgetippt[$i]), $nachkomma, '.', ',');
            } else {
                echo '&nbsp;';
            }
        } ?></td>
            <td>&nbsp;</td>
<?php
    }
    if ($btip[$i] == true) { ?>
            <td align="right">
              <input class="lmo-formular-input" type="text" name="xtippa<?php echo $i; ?>" size="2" maxlength="4" value="<?php echo $goaltippa[$i]; ?>" onKeyDown="lmotorclk('a','<?php echo $i; ?>',event.keyCode)">
            </td>
<?php
        if ($tipp_pfeiltipp == 1) { ?>
            <td align="center">
              <table cellpadding="0" cellspacing="0" border="0">
                <tr>
                  <td>
                    <script type="text/javascript">document.write('<a href="#" onclick="lmotorauf(\'a\',\'<?php echo $i; ?>\',1);return false;" title="<?php echo $text['tipp'][243]; ?>" onMouseOver="lmoimg(\'<?php echo $i; ?>a\',img1)" onMouseOut="lmoimg(\'<?php echo $i; ?>a\',img0)"><img src="<?php echo URL_TO_IMGDIR?>/lmo-admin0.gif" name="ximg<?php echo $i; ?>a" width="7" height="7" border="0"><\/a>')</script>
                  </td>
                </tr>
                <tr>
                  <td>
                    <script type="text/javascript">document.write('<a href="#" onclick="lmotorauf(\'a\',\'<?php echo $i; ?>\',-1);return false;" title="<?php echo $text['tipp'][243]; ?>" onMouseOver="lmoimg(\'<?php echo $i; ?>b\',img3)" onMouseOut="lmoimg(\'<?php echo $i; ?>b\',img2)"><img src="<?php echo URL_TO_IMGDIR?>/lmo-admin2.gif" name="ximg<?php echo $i; ?>b" width="7" height="7" border="0"><\/a>')</script>
                  </td>
                </tr>
              </table>
            </td>
<?php
        }
    } else {
        if ($tipp_pfeiltipp == 1) { ?>
            <td>&nbsp;</td>
<?php
        } ?>
            <td align="right"><?php echo $goaltippa[$i]; ?></td>
<?php
    } ?>
            <td align="center">:</td>
<?php
    if ($btip[$i] == true) { ?>
            <td align="right">
              <input class="lmo-formular-input" type="text" name="xtippb<?php echo $i; ?>" size="2" maxlength="4" value="<?php echo $goaltippb[$i]; ?>" onKeyDown="lmotorclk('b','<?php echo $i; ?>',event.keyCode)">
            </td>
<?php
        if ($tipp_pfeiltipp == 1) { ?>
            <td align="center">
              <table cellpadding="0" cellspacing="0" border="0">
                <tr>
                  <td>
                    <script type="text/javascript">document.write('<a href="#" onclick="lmotorauf(\'b\',\'<?php echo $i; ?>\',1);return false;" title="<?php echo $text['tipp'][244]; ?>" onMouseOver="lmoimg(\'<?php echo $i; ?>f\',img1)" onMouseOut="lmoimg(\'<?php echo $i; ?>f\',img0)"><img src="<?php echo URL_TO_IMGDIR?>/lmo-admin0.gif" name="ximg<?php echo $i; ?>f" width="7" height="7" border="0"><\/a>')</script>
                  </td>
                </tr>
                <tr>
                  <td>
                    <script type="text/javascript">document.write('<a href="#" onclick="lmotorauf(\'b\',\'<?php echo $i; ?>\',-1);return false;" title="<?php echo $text['tipp'][244]; ?>" onMouseOver="lmoimg(\'<?php echo $i; ?>d\',img3)" onMouseOut="lmoimg(\'<?php echo $i; ?>d\',img2)"><img src="<?php echo URL_TO_IMGDIR?>/lmo-admin2.gif" name="ximg<?php echo $i; ?>d" width="7" height="7" border="0"><\/a>')</script>
                  </td>
                </tr>
              </table>
            </td>
<?php
        }
    } else { ?>
            <td align="left"><?php echo $goaltippb[$i]; ?></td>
<?php
        if ($tipp_pfeiltipp == 1) { ?>
            <td>&nbsp;</td>
<?php
        }
    }
} /* ende ($tipp_tippmodus == 1) */

/** TENEDENZMODUS **/
if ($tipp_tippmodus == 0) {
    $tipp=-1;
    if ($goaltippa[$i] == '' || $goaltippb[$i] == '') {
        $tipp = -1;
    } elseif ($goaltippa[$i] > $goaltippb[$i]) {
        $tipp = 1;
    } elseif ($goaltippa[$i] == $goaltippb[$i]) {
        $tipp = 0;
    } elseif ($goaltippa[$i] < $goaltippb[$i]) {
        $tipp = 2;
    } ?>
            <td align="center">
              <input type="radio" name="xtipp<?php echo $i; ?>" value="1"<?php if ($tipp == 1) {echo ' checked';} if ($btip[$i] == false) {echo ' disabled';} ?>>
            </td>
<?php
    if (!$lmo_einstellungen->ohneUnentschieden()) { ?>
            <td align="center">
              <input type="radio" name="xtipp<?php echo $i; ?>" value="3"<?php if ($tipp == 0) {echo ' checked';} if ($btip[$i] == false) {echo ' disabled';} ?>>
            </td>
<?php
    } ?>
            <td align="center">
              <input type="radio" name="xtipp<?php echo $i; ?>" value="2"<?php if ($tipp == 2) {echo ' checked';} if ($btip[$i] == false) {echo ' disabled';} ?>>
            </td>
<?php
} /* ende ($tipp_tippmodus == 0) */

/** BEIDE **/
if ($tipp_jokertipp == 1) { ?>
            <td align="center"><input type="radio" name="xjokerspiel" value="<?php echo $i + 1; ?>"<?php if ($jksp == $i + 1) {echo ' checked';} if ($btip[$i] == false) {echo ' disabled';} elseif ($tipp_jokertippaktiv==false) {echo ' disabled';} ?>></td>
<?php
} ?>
            <td class="lmoBackMarkierung" align="right"><?php echo $lmo_spiel->toreHeimText($lmo_faktor); ?></td>
            <td class="lmoBackMarkierung" align="center">:</td>
            <td class="lmoBackMarkierung" align="left"><?php echo $lmo_spiel->toreGastText($lmo_faktor); ?></td>
<?php
if ($lmo_einstellungen->mitVerlaengerung()) { ?>
            <td class="lmoBackMarkierung">&nbsp;</td>
            <td class="lmoBackMarkierung" align="left"><?php echo $lmo_spiel->zusatzText($text[0], $text[1]); ?></td>
<?php
} ?>
            <td width="2">&nbsp;</td>
            <td class="nobr" align="right">
              <strong><?php
if ($tipp_jokertipp == 1 && $jksp == $i + 1) {
    $jkspfaktor = $tipp_jokertippmulti;
} else {
    $jkspfaktor = 1;
}
$punktespiel = -1;
if ($goaltippa[$i] != '' && $goaltippb[$i] != '' && $lmo_spiel->toreHeim !== null && $lmo_spiel->toreGast !== null) {
    $punktespiel = tipppunkte($goaltippa[$i], $goaltippb[$i], $lmo_spiel->toreHeimText(), $lmo_spiel->toreGastText(), $lmo_spiel->wertung, $lmo_spiel->zusatzText($text[0], $text[1]), $text[0], $text[1], $jkspfaktor, (int)$lmo_spiel->ohneTippwertung);
}
if ($punktespiel == -1) {
    echo '-';
} elseif ($punktespiel == -2) {
    echo $text['tipp'][230];
    $nw = 1;
} else {
    if ($tipp_tippmodus == 1) {
        echo $punktespiel;
    } else {
        if ($punktespiel > 0) {
            echo '<img src="' . URL_TO_IMGDIR . '/right.svg" height="20" border="0" alt="&#9786;">';
            if ($punktespiel > 1) {
                echo '+' . ($punktespiel - 1);
            }
        } else {
            echo '<img src="' . URL_TO_IMGDIR . '/wrong.scg" height="20" border="0" alt="&#9785;">';
        }
    }
}
if ($punktespiel > 0) {
    $punktespieltag += $punktespiel;
} ?></strong>
            </td>
            <td class="nobr" align="left"><?php
/** Mannschaftsicons finden **/
$lmo_teamaicon = '';
$lmo_teambicon = '';
if ($lmo_einstellungen->mitSpielberichten() || $lmo_spiel->notiz != '' || $lmo_spiel->wertung > 0) {
    $lmo_teamaicon=HTML_smallTeamIcon($file, $lmo_heim, ' alt=""') . ' ' ;
    $lmo_teambicon=HTML_smallTeamIcon($file, $lmo_gast, ' alt=""') . ' ' ;
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
if ($lmo_spiel->notiz != '' || $lmo_spiel->wertung > 0 || (int)$lmo_spiel->ohneTippwertung > 0) {
    //Grüner Tisch: Beidseitiges Ergebnis vorbereiten
    $lmo_notiz_both = ($lmo_spiel->wertung == 3) ? ' / ' . $lmo_spiel->toreGastText($lmo_faktor) . ':' . $lmo_spiel->toreHeimText($lmo_faktor) : '';
    //Alles in EIN Tag packen, damit das CSS es als EINE zentrierte Zeile erkennt
    $lmo_spielnotiz = '<strong>' . $lmo_heim . $lmo_teamaicon . ' - ' . $lmo_teambicon . $lmo_gast . '&nbsp;&nbsp;' . $lmo_spiel->toreHeimText($lmo_faktor) . ':' . $lmo_spiel->toreGastText($lmo_faktor) . $lmo_notiz_both . '</strong>';
    if ($lmo_einstellungen->mitVerlaengerung()) {
        $lmo_spielnotiz .= '&nbsp;' . $lmo_spiel->zusatzText($text[0], $text[1]) . '<br>';
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
        $lmo_spielnotiz .= '<br><strong>' . $text[22] . ':</strong>' . $lmo_spiel->notiz . '<br>';
    }
    //Notiz zum Tippspiel
    if ((int)$lmo_spiel->ohneTippwertung == 1) {
        $lmo_spielnotiz .= '<br><strong>' . $text[487] . '</strong>' . $text['tipp'][231];
    }
    //Ausgabe als neutrales Element (kein Link)
    echo '<span onmouseover="showLMOTooltip(this)" onmouseout="hideLMOTooltip()" data-info="' . htmlspecialchars(nl2br($lmo_spielnotiz)) . '" class="tooltip-trigger"><img src="' . URL_TO_IMGDIR . '/lmo-st2.svg" height="15" class="svg-no-style" alt=""></span>';
    $lmo_spielnotiz = '';
} else {
    echo '&nbsp;';
}
?></td>
          </tr>