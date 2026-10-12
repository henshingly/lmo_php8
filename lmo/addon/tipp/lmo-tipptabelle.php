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
 * @var array<int|string, mixed> $text Sprachtexte
 * @var string $file Ligadatei relativ zum Ligenordner, leer wenn keine geladen ist
 * @var int|string $st gewaehlter Spieltag
 * @var array<int|string, mixed> $array leeres Array als Vorlage fuer array_pad()
 *
 * Einstellungen:
 * @var int|string $tabpkt Einstellung aus cfg.txt
 * @var int|string $tipp_dirtipp Einstellung aus tipp/cfg.txt
 * @var int|string $tipp_einsichterst Einstellung aus tipp/cfg.txt
 * @var int|string $tipp_tippmodus Einstellung aus tipp/cfg.txt
 * @var int|string $tipp_tipptabelle Einstellung aus tipp/cfg.txt
 * @var int|string $tipp_tipptabelle1 Einstellung aus tipp/cfg.txt
 * @var int|string $tipp_wertverein Einstellung aus tipp/cfg.txt
 *
 * Weitere Variablen des einbindenden Codes:
 * @var array<int|string, mixed> $atore
 * @var array<int|string, mixed> $dtore
 * @var array<int|string, mixed> $etore
 * @var array<int|string, mixed> $negativ
 * @var array<int|string, mixed> $nieder
 * @var array<int|string, mixed> $punkte
 * @var array<int|string, mixed> $siege
 * @var array<int|string, mixed> $spiele
 * @var array<int|string, mixed> $spielegetippt
 * @var array<int|string, mixed> $tab0
 * @var array<int|string, mixed> $tipppunktegesamt
 * @var array<int|string, mixed> $unent
 *
 * Werden auch in dieser Datei gesetzt, aber nicht auf jedem Weg (koennen von aussen kommen):
 * @var mixed $addr
 * @var mixed $addt
 * @var mixed $endtab
 * @var mixed $nick
 * @var array<int|string, mixed> $platz1
 * @var array<int|string, mixed> $quote
 * @var mixed $tabdat
 * @var mixed $tabtype
 */


if ($file != '' && $tipp_tipptabelle1 == 1) {
    // Einstellungen und Spiele der Liga aus den Rohdaten; die Spiele unter denselben Indizes wie die
    // Tipps: $lmo_tipp_spiele[Spieltag-1][Partie-1], dazu je Spieltag der erste und letzte Tag
    $lmo_einstellungen = $lmo_liga->einstellungen();
    $lmo_tipp_mannschaften = $lmo_einstellungen->mannschaften();
    $lmo_tipp_spieltage = $lmo_einstellungen->spieltage();
    $lmo_tipp_partien = $lmo_einstellungen->partienJeSpieltag();
    // Vereine der Wertung nach Vereinen; lmo-tippcalcwertverein.php zaehlt sie aus seiner Datei
    $lmo_tipp_vereine = $lmo_tipp_mannschaften;
    $lmo_tipp_spiele = array();
    $lmo_tipp_tage = array();
    // auch ein gewaehlter Spieltag hinter dem letzten, hoechstens so viele, wie die Tipps fassen
    for ($j = 0; $j < min(max($lmo_tipp_spieltage, (int)$st), 116); $j++) {
        $lmo_tipp_spieltag = $lmo_liga->spieltage[$j + 1] ?? new \Lmo\Liga\Rohdaten\Spieltag();
        $lmo_tipp_tage[$j] = array($lmo_tipp_spieltag->ersterTagText(), $lmo_tipp_spieltag->letzterTagText());
        for ($i = 0; $i < $lmo_tipp_partien; $i++) {
            $lmo_tipp_spiele[$j][$i] = \Lmo\Liga\Spiel::ausRohdaten($lmo_liga, $j + 1, $i + 1);
        }
    }
    $endtab = $st;
    if ($endtab == 0) {
        $endtab = $lmo_tipp_spieltage;
        $tabdat = '';
    } else {
        $tabdat = $endtab . '. ' . $text[2];
    }
    if (!isset($tabtype)) {
        $tabtype = 0;
    }
    if (!isset($nick)) {
        $nick = $_SESSION['lmotippername'];
    }
    if ($tipp_einsichterst == 1) {
        require_once(PATH_TO_ADDONDIR . '/tipp/lmo-tippaenderbar.php');
    }
    if ($file != '') {
        if ($nick != '') {
            $m = 0;
            $tippfile = PATH_TO_ADDONDIR . '/tipp/' . $tipp_dirtipp . substr($file, 0, -4) . '_' . $nick . '.tip';
            require(PATH_TO_ADDONDIR . '/tipp/lmo-tippopenfileall.php');
            $anztipper = 1;
            if (($endtab > 1) && ($tabtype == 0) && ($tabdat != '')) {
                $endtab--;
                require(PATH_TO_ADDONDIR . '/tipp/lmo-tippcalctable.php');
                $endtab++;
                $platz1 = array('');
                $platz1 = array_pad($array, $lmo_tipp_mannschaften + 1, '');
                for ($x = 0; $x < $lmo_tipp_mannschaften; $x++) {
                    $x3 = intval(substr($tab0[$x], 42));
                    $platz1[$x3] = $x + 1;
                }
            }
            require(PATH_TO_ADDONDIR . '/tipp/lmo-tippcalctable.php');
        } elseif ($tipp_tipptabelle == 1) {
            // alle Tipper
            $tabdat = '';
            $verz = opendir(PATH_TO_ADDONDIR . '/tipp/' . $tipp_dirtipp);
            $dummy = array();
            $liga = substr($file, 0, -4);
            if ($verz !== false) {
                while ($files = readdir($verz)) {
                    if (strtolower(substr($files, 0, strrpos($files, '_'))) == strtolower($liga) && strtolower(substr($files, -4)) == '.tip') {
                        array_push($dummy, $files);
                    }
                }
                closedir($verz);
            }
            $anztipper = count($dummy);
            for ($m = 0; $m < $anztipper; $m++) {
                $nick = substr(substr($dummy[$m], strrpos($dummy[$m], '_') + 1), 0, -4);
                //echo $nick;
                $tippfile = PATH_TO_ADDONDIR . '/tipp/' . $tipp_dirtipp . $liga . '_' . $nick . '.tip';
                require(PATH_TO_ADDONDIR . '/tipp/lmo-tippopenfileall.php');
                require(PATH_TO_ADDONDIR . '/tipp/lmo-tippcalctable.php');
            }
            $nick = '';
            //Keine Tipper
            if ($m == 0) {
                echo getMessage($text['tipp'][17], true);
            }
        }
    }
    $platz0 = array('');
    $platz0 = array_pad($array, $lmo_tipp_mannschaften + 1, '');
    for ($x = 0; $x < $lmo_tipp_mannschaften; $x++) {
        $x3 = intval(substr($tab0[$x], 42));
        $platz0[$x3] = $x + 1;
    }
    if ($tabdat == '') {
        $addt1 = $_SERVER['PHP_SELF'] . '?action=tipp&amp;todo=tabelle&amp;file=' . $file . '&ampnick=' . $nick . '&amp;tabtype=';
    } else {
        $addt1 = $_SERVER['PHP_SELF'] . '?action=tipp&amp;todo=tabelle&amp;file=' . $file . '&amp;endtab=' . $endtab . '&amp;nick=' . $nick . '&amp;tabtype=';
    }
    $addr = $_SERVER['PHP_SELF'] . '?action=tipp&amp;todo=tabelle&amp;file=' . $file . '&amp;tabtype=' . $tabtype . '&amp;nick=' . $nick . '&amp;st=';
    $addt = $_SERVER['PHP_SELF'] . '?action=tipp&amp;todo=tabelle&amp;file=' . $file . '&amp;endtab=&amp;nick=';
    if ($lmo_einstellungen->mitMinuspunkten()) {
        $dummy = ' colspan="3" align="center"';
    } else {
        $dummy = ' align="right"';
    } ?>
<table class="lmoInner" cellspacing='0' cellpadding='0' border='0'>
<?php
    if ($nick != '') { ?>
  <caption><?php if ($_SESSION['lmotipperok'] == 5) {echo $_SESSION['lmotippername'];if ($_SESSION['lmotipperverein'] != '') {echo ' - ' . $_SESSION['lmotipperverein'];}} else {echo $text['tipp'][158];} ?></caption>
<?php
        $hoy1 = 1;
        //  if ($tabtype == 3) {$hoy1 = ($anzst / 2 + 1);}
        if ($tabtype!=3 && $tabtype!=4) { ?>
  <tr>
    <td align="center"><?php include(PATH_TO_LMO . '/lmo-spieltagsmenu.php'); ?></td>
  </tr>
<?php
        }
    } /* ende if ($nick != '') */
?>
  <tr>
    <th class="nobr" align="center"><?php if ($nick == $_SESSION['lmotippername'] && $nick != '') {echo $text['tipp'][173];} elseif ($nick != '') {echo $text['tipp'][181] . ' ' . $nick;} else {echo $text['tipp'][184];} ?></th>
  </tr>
  <tr>
    <td align="center">
      <table class="lmoInner" cellspacing='0' cellpadding='0' border='0'><?php
    if ($nick != '') { ?>
        <caption><?php
        if ($tabtype != '0') { ?><a href="<?php echo $addt1 . '0'?>" title="<?php echo $text[27]; ?>"><?php echo $text[16]; ?></a><?php } else {echo $text[16];} ?>&nbsp;<?php
        if ($tabtype != '1') { ?><a href="<?php echo $addt1 . '1'?>" title="<?php echo $text[28]; ?>"><?php echo $text[41]; ?></a><?php } else {echo $text[41];} ?>&nbsp;<?php
        if ($tabtype != '2') { ?><a href="<?php echo $addt1 . '2'?>" title="<?php echo $text[29]; ?>"><?php echo $text[42]; ?></a><?php } else {echo $text[42];} ?>&nbsp;<?php
        if ($lmo_einstellungen->mitHinRueckrundentabelle()) {
            if ($tabtype != '4') { ?><a href="<?php echo $addt1 . '4'?>" title="<?php echo $text[4003]; ?>"><?php echo $text[4003]; ?></a><?php } else {echo $text[4003];} ?>&nbsp;<?php
            if ($tabtype != '3') { ?><a href="<?php echo $addt1 . '3'?>" title="<?php echo $text[4002]; ?>"><?php echo $text[4002]; ?></a><?php } else {echo $text[4002];}
        } ?></caption>
<?php
    } /* ende if ($nick != '')*/
?>
        <tr>
          <th align="left" colspan="6"> <?php echo $tabdat; ?>&nbsp;</th>
          <th>&nbsp;</th>
          <th class="nobr" align="right"> <?php echo $text[33]; ?>&nbsp;</th>
          <th class="nobr" align="right"> <?php echo $text[34]; ?>&nbsp;</th><?php
    if (!$lmo_einstellungen->ohneUnentschieden()) { ?>
          <th class="nobr" align="right"> <?php echo $text[35]; ?>&nbsp;</th><?php
    } ?>
          <th class="nobr" align="right"> <?php echo $text[36]; ?>&nbsp;</th><?php
    if ($tabpkt == 0) { ?>
          <th>&nbsp;</th>
          <th class="nobr" <?php echo $dummy; ?>> <?php echo $text[37]; ?>&nbsp;</th><?php
    }
    if ($tipp_tippmodus == 1) { ?>
          <th>&nbsp;</th>
          <th class="nobr" colspan='3' align="center"> <?php echo $text[38]; ?> </th>
          <th class="nobr" align="right"> <?php echo $text[39]; ?> </th><?php
    }
    if ($tabpkt == 1) { ?>
          <th>&nbsp;</th>
          <th class="nobr" <?php echo $dummy; ?>><?php echo $text[37]; ?> </th><?php
    } ?>
          <th class="nobr" align="right"><?php echo $text[37] . '/' . $text[33]; ?></th>
        </tr><?php
    $j = 1;
   for ($x = 1; $x <= $lmo_tipp_mannschaften; $x++) {
        $i = intval(substr($tab0[$x - 1], 42));
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
            if (($x >= $j) && ($x < $j + $lmo_einstellungen->plaetzeChampionsLeague()) && ($lmo_einstellungen->plaetzeChampionsLeague() > 0)) {
                $lmo_tabelle_class = 'lmoTabelleCleague nobr';
            }
            if (($x >= $j + $lmo_einstellungen->plaetzeChampionsLeague()) && ($x < $j + $lmo_einstellungen->plaetzeChampionsLeague() + $lmo_einstellungen->plaetzeClQualifikation()) && ($lmo_einstellungen->plaetzeClQualifikation() > 0)) {
                $lmo_tabelle_class = 'lmoTabelleCleaguequali nobr';
            }
            if (($x >= $j + $lmo_einstellungen->plaetzeChampionsLeague() + $lmo_einstellungen->plaetzeClQualifikation()) && ($x < $j + $lmo_einstellungen->plaetzeChampionsLeague() + $lmo_einstellungen->plaetzeClQualifikation() + $lmo_einstellungen->plaetzeUefaCup()) && ($lmo_einstellungen->plaetzeUefaCup() > 0)) {
                $lmo_tabelle_class = 'lmoTabelleUefa nobr';
            }
            if (($x <= $lmo_tipp_mannschaften) && ($x > $lmo_tipp_mannschaften - $lmo_einstellungen->plaetzeAbstieg()) && ($lmo_einstellungen->plaetzeAbstieg() > 0)) {
                $lmo_tabelle_class = 'lmoTabelleAbsteiger nobr';
            }
            if (($x <= $lmo_tipp_mannschaften - $lmo_einstellungen->plaetzeAbstieg()) && ($x > $lmo_tipp_mannschaften - $lmo_einstellungen->plaetzeAbstieg() - $lmo_einstellungen->plaetzeRelegation()) && ($lmo_einstellungen->plaetzeRelegation() > 0)) {
                $lmo_tabelle_class = 'lmoTabelleRelegation nobr';
            }
        } ?>
        <tr>
          <td class="<?php echo $lmo_tabelle_class; ?> nobr" align="right"> <?php echo $dummy . $x . $dumm2; ?> </td>
<?php
        $y = 0;
        if (($endtab > 1) && ($tabtype == 0) && ($tabdat != '')) {
            if ($platz0[$i] < $platz1[$i]) {
                $y = 1;
            } elseif ($platz0[$i] > $platz1[$i]) {
                $y = 2;
            }
        }
        if ($tabdat != '') {
            echo           '<td class="' . $lmo_tabelle_class . '"';
            if ($tabtype == 0) {
                echo '><img src="' . URL_TO_IMGDIR . '/lmo-tab' . $y . '.gif" width="9" height="9" border="0" alt="">';
            } else {
                echo ' width="2">&nbsp;';
            }
            echo '</td>';
        } else {
            echo '          <td class="' . $lmo_tabelle_class . '">&nbsp;</td>';
        } ?>
          <td class="<?php echo $lmo_tabelle_class; ?>" align="center"><?php echo HTML_smallTeamIcon($file, $lmo_name, ' alt=""'); ?>&nbsp;</td>
          <td class="<?php echo $lmo_tabelle_class; ?> nobr" align="left"> <?php
        echo $dummy . $lmo_name . $dumm2;
        if (($lmo_url != '') && $lmo_einstellungen->mitMannschaftslinks()) {
            echo ' <a href="' . $lmo_url . '" target="_blank" title="' . $text[46] . '"><img border="0" width="11" src="' . URL_TO_IMGDIR . '/url.png" alt="' . $text[564] . '" title="' . $text[46] . '"></a> ';
        } ?></td>
          <td class="<?php echo $lmo_tabelle_class; ?>">&nbsp;</td>
          <td class="<?php echo $lmo_tabelle_class; ?>" align="center"><?php
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
            echo '
          <span onmouseover="showLMOTooltip(this)" onmouseout="hideLMOTooltip()" data-info="' . htmlspecialchars(nl2br($lmo_tabellennotiz)) . '" class="tooltip-trigger"><img src="' . URL_TO_IMGDIR . '/lmo-st2.svg" height="15" class="svg-no-style" alt=""></span>';
            $lmo_tabellennotiz = '';
        } else {
            echo '&nbsp;';
        } ?>
          </td>
          <td class="<?php echo $lmo_tabelle_class; ?>" width='2'>&nbsp;</td>
          <td class="<?php echo $lmo_tabelle_class; ?>" align="right"> <?php echo $dummy . $spiele[$i] . $dumm2; ?> &nbsp;</td>
          <td class="<?php echo $lmo_tabelle_class; ?>" align="right"> <?php echo $dummy . $siege[$i] . $dumm2; ?> &nbsp;</td><?php
        if (!$lmo_einstellungen->ohneUnentschieden()) { ?>
          <td class="<?php echo $lmo_tabelle_class; ?>" align="right"> <?php echo $dummy . $unent[$i] . $dumm2; ?> &nbsp;</td><?php
        } ?>
          <td class="<?php echo $lmo_tabelle_class; ?>" align="right"> <?php echo $dummy . $nieder[$i] . $dumm2; ?> &nbsp;</td><?php
        if ($tabpkt == 0) {
            echo '          <td class="' . $lmo_tabelle_class . '" width="2">&nbsp;</td><td class="' . $lmo_tabelle_class . '" align="right">' . applyFactor($punkte[$i], $lmo_einstellungen->punktfaktor()) . '</td>';
            if ($lmo_einstellungen->mitMinuspunkten()) {
                echo '          <td class="' . $lmo_tabelle_class . '" align="center" width="4">:</td>';
                echo '          <td class="' . $lmo_tabelle_class . '">' . applyFactor($negativ[$i], $lmo_einstellungen->punktfaktor()) . '</td>';
            }
        }
        if ($tipp_tippmodus == 1) { ?>
          <td class="<?php echo $lmo_tabelle_class; ?>" width='2'>&nbsp;</td>
          <td class="<?php echo $lmo_tabelle_class; ?>" align="right"><?php echo $dummy . applyFactor($etore[$i], $lmo_einstellungen->torfaktor()) . $dumm2; ?></td>
          <td class="<?php echo $lmo_tabelle_class; ?>" align="center" width='4'><?php echo $dummy; ?>:<?php echo $dumm2; ?></td>
          <td class="<?php echo $lmo_tabelle_class; ?>"><?php echo $dummy . applyFactor($atore[$i], $lmo_einstellungen->torfaktor()) . $dumm2; ?></td>
          <td class="<?php echo $lmo_tabelle_class; ?>" align="right"><?php echo $dummy . applyFactor($dtore[$i], $lmo_einstellungen->torfaktor()) . $dumm2; ?></td>
<?php
        }
        if ($tabpkt == 1) {
            echo '          <td class="' . $lmo_tabelle_class . '" width="2">&nbsp;</td><td class="' . $lmo_tabelle_class . '" align="right">' . applyFactor($punkte[$i], $lmo_einstellungen->punktfaktor()) . '</td>';
            if ($lmo_einstellungen->mitMinuspunkten()) {
                echo '          <td class="' . $lmo_tabelle_class . '" align="center" width="4">:</td>';
                echo '          <td class="' . $lmo_tabelle_class . '">' . applyFactor($negativ[$i], $lmo_einstellungen->punktfaktor()) . '</td>';
            }
        } ?>
          <td class="<?php echo $lmo_tabelle_class; ?>" align="right"><strong><?php echo $dummy . number_format($quote[$i] / 100, 2, '.', ',') . $dumm2; ?></strong></td>
        </tr>
<?php
    } ?>
      </table>
    </td>
  </tr>
</table>
<?php
}
if ($tabdat != '') { ?>
      <table width="100%" cellspacing='0' cellpadding='0' border='0'>
        <tr>
<?php
   $st0 = $st - 1;
    if ($st > 1) { ?>
          <td align="left">&nbsp;<a href="<?php echo $addr . $st0; ?>" title="<?php echo $text[6]; ?>"><?php echo $text[5]; ?> <?php echo $text[6]; ?></a>&nbsp;</td>
<?php
    }
    $st0 = $st + 1;
    if ($st < $lmo_tipp_spieltage) { ?>
          <td align="right">&nbsp;<a href="<?php echo $addr . $st0; ?>" title="<?php echo $text[8]; ?>"><?php echo $text[8]; ?> <?php echo $text[7]; ?></a>&nbsp;</td>
<?php
    } ?>
        </tr>
      </table>
<?php
}
if ($tipp_wertverein == 1 && $tabtype == 0) { ?>
<p>&nbsp;</p>
<table class="lmoInner" cellspacing='0' cellpadding='0' border='0'>
  <tr>
    <th align="center"><?php echo $text['tipp'][261]; ?></th>
  </tr>
<?php
    $st = $endtab;
    if ($nick != '') {
        $m=0;
        $auswertfile = PATH_TO_ADDONDIR . '/tipp/' . $tipp_dirtipp . 'auswert/vereine/' . substr($file, 0, - 4) . '_' . $nick . '.ver';
        if (($endtab > 1) && ($tabtype == 0) && ($tabdat != '')) {
            $endtab--;
            require(PATH_TO_ADDONDIR . '/tipp/lmo-tippcalcwertverein.php');

            $platz1 = array('');
            $platz1 = array_pad($array, $lmo_tipp_vereine + 1, '');
            for ($x = 0; $x < $lmo_tipp_vereine; $x++) {
                $x3 = intval(substr($tab0[$x], 25));
                $platz1[$x3] = $x + 1;
            }
            $endtab++;
        }
        require(PATH_TO_ADDONDIR . '/tipp/lmo-tippcalcwertverein.php');
    } elseif ($tipp_tipptabelle == 1) {      // alle Tipper
        $tabdat = '';
        $verz = opendir(PATH_TO_ADDONDIR . '/tipp/' . $tipp_dirtipp . 'auswert/vereine/');
        $dummy = array();
        $liga = substr($file, 0, -4);
        if ($verz !== false) {
            while ($files = readdir($verz)) {
                if (strtolower(substr($files, 0, strrpos($files, '_'))) == strtolower($liga) && strtolower(substr($files, - 4)) == '.ver') {
                    array_push($dummy, $files);
                }
            }
            closedir($verz);
        }
        $anztipper = count($dummy);
        for ($m = 0; $m < $anztipper; $m++) {
            $nick = substr(substr($dummy[$m], strrpos($dummy[$m], '_') + 1), 0, -4);
            $auswertfile = PATH_TO_ADDONDIR . '/tipp/' . $tipp_dirtipp . 'auswert/vereine/' . substr($file, 0, - 4) . '_' . $nick . '.ver';
            require(PATH_TO_ADDONDIR . '/tipp/lmo-tippcalcwertverein.php');
        }
        $nick = '';
    }

    $platz0 = array('');
    $platz0 = array_pad($array, $lmo_tipp_vereine+1, '');
    for ($x = 0; $x < $lmo_tipp_vereine; $x++) {
        $x3 = intval(substr($tab0[$x], 25));
        $platz0[$x3] = $x + 1;
    } ?>
  <tr>
    <td align="center">
      <table class="lmoInner" cellspacing='0' cellpadding='0' border='0'>
        <tr>
          <th colspan='3'><?php $dummy = ' align="right"';echo $tabdat; ?></th>
          <th width='2'>&nbsp;</th>
          <th class="nobr" <?php echo $dummy; ?>><?php echo $text[33]; /* Spiele getippt*/ ?></th>
          <th width='2'>&nbsp;</th>
          <th class="nobr" <?php echo $dummy; ?>><?php if ($tipp_tippmodus == 1) {echo $text[37];} else {echo $text['tipp'][122];} ?></th>
          <th width='2'>&nbsp;</th>
          <th class="nobr" <?php echo $dummy; ?>><strong><?php if ($tipp_tippmodus == 1) {echo $text[37] . '/' . $text[33];} else {echo $text['tipp'][123] . '%';} ?></strong></th>
        </tr>
<?php
    $j = 1;
    $spv = -1;
    $ppv = -1;
    for ($x = 1; $x <= $lmo_tipp_vereine; $x++) {
        if (!isset($team)) break;
        $i = intval(substr($tab0[$x - 1], 25));
        if ($team[$i] == $lmo_einstellungen->lieblingsmannschaft()) {
            // favteam
            $dummy = '<strong>';
            $dumm2 = '</strong>';
        } else {
            $dummy = '';
            $dumm2 = '';
        }
        $lmo_tabelle_class = 'nobr'; ?>
        <tr>
          <td class="<?php echo $lmo_tabelle_class; ?>" align="right"><?php echo $dummy . $x . $dumm2; ?>&nbsp;</td>
<?php
        $y = 0;
        if (($endtab > 1) && ($tabdat != '') && $tipppunktegesamt[intval(substr($tab0[0], 25))] > 0) {
            if ($platz0[$i] < $platz1[$i]) {
                $y = 1;
            } elseif ($platz0[$i] > $platz1[$i]) {
                $y = 2;
            }
        }
        if ($tabdat != '') {
            echo '          <td class="' . $lmo_tabelle_class . '"';
            echo '><img src="' . URL_TO_IMGDIR . '/lmo-tab' . $y . '.gif" width="9" height="9" border="0" alt="">&nbsp;';
            echo '</td>';
        } else {
            echo '<td class="' . $lmo_tabelle_class . '">&nbsp;</td>';
        } ?>
          <td class="<?php echo $lmo_tabelle_class; ?>" align="left"><?php echo $dummy . ($lmo_liga->mannschaften[$team[$i]] ?? new \Lmo\Liga\Rohdaten\Mannschaft())->anzeigename() . $dumm2; ?></td>
          <td class="<?php echo $lmo_tabelle_class; ?>">&nbsp;</td>
          <td class="<?php echo $lmo_tabelle_class; ?>" align="right"><?php echo $dummy . $spielegetippt[$i] . $dumm2; ?></td>
          <td class="<?php echo $lmo_tabelle_class; ?>">&nbsp;</td>
          <td class="<?php echo $lmo_tabelle_class; ?>" align="right"><?php echo $dummy . $tipppunktegesamt[$i] . $dumm2; ?></td>
<?php
        $quote = 0;
        if ($spielegetippt[$i] != 0) {
            if ($tipp_tippmodus == 1) {
                $quote = number_format($tipppunktegesamt[$i] / $spielegetippt[$i], 2, '.', ',');
            }
            if ($tipp_tippmodus == 0) {
                $quote = number_format($tipppunktegesamt[$i] / $spielegetippt[$i] * 100, 2, '.', ',');
            }
        } ?>
          <td class="<?php echo $lmo_tabelle_class; ?>" width='2'>&nbsp;</td>
          <td class="<?php echo $lmo_tabelle_class; ?>" align="right"><?php echo $dummy; ?><strong><?php echo $quote; ?></strong><?php echo $dumm2; ?></td>
<?php
        $spv = $spielegetippt[$i]; // merken
        $ppv = $tipppunktegesamt[$i]; ?>
        </tr>
<?php
    } /* ende for ($x = 1; $x <= $anzteams; $x++)*/?>
      </table>
    </td>
  </tr>
  <tr>
    <td class="lmoFooter" align="center"><?php
    if ($nick != $_SESSION['lmotippername'] && $_SESSION['lmotippername'] != '') {
        echo '<a href="' . $addt . $_SESSION['lmotippername'] . '" title="' . $text['tipp'][173] . '">' . $text['tipp'][182] . '</a>';
    }
    echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
    if ($nick != '' && $tipp_tipptabelle == 1) {
        echo '<a href="' . $addt . '" title="' . $text['tipp'][184] . '">' . $text['tipp'][183] . '</a>';
    } ?>
    </td>
  </tr>
</table>
<?php
}
?>