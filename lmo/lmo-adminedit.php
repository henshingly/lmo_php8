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
 * @var int|string|null $st gewaehlter Spieltag
 *
 * Einstellungen:
 * @var int|string $deftime Einstellung aus cfg.txt
 * @var int|string $tipp_aktauswert Einstellung aus tipp/cfg.txt
 * @var int|string $tipp_aktauswertges Einstellung aus tipp/cfg.txt
 * @var int|string $tipp_immeralle Einstellung aus tipp/cfg.txt
 * @var int|string $tipp_ligenzutippen Einstellung aus tipp/cfg.txt
 *
 * Werden auch in dieser Datei gesetzt, aber nicht auf jedem Weg (koennen von aussen kommen):
 * @var array<int|string, mixed> $me
 * @var array<int|string, mixed> $teamt
 */

require_once(PATH_TO_LMO . '/lmo-admintest.php');
if ($file != '') {
    $save = isset($_POST['save']) ? $_POST['save'] : 0;
    $tabdat = '_';
    $ftest0 = 1;
    $liga = basename(substr($file, 0, -4));

    if ($tipp_immeralle == 0) {
        $ftest0 = 0;
        $ftest1 = '';
        $ftest1 = explode(',', $tipp_ligenzutippen);
        if (isset($ftest1)) {
            for ($u = 0; $u < count($ftest1); $u++) {
                if ($ftest1[$u] == $liga) {
                    $ftest0 = 1;
                }
            }
        }
    }

    require_once(PATH_TO_LMO . '/lmo-openfile.php');
    $lmo_einstellungen = $lmo_liga->einstellungen();
    $lmo_pokal = $lmo_einstellungen->istPokal();
    $lmo_spieltage = $lmo_einstellungen->spieltage();
    // Spieltag, den es in der Liga nicht gibt (z.B. st=-2 als Hilfsadmin ohne Recht auf die
    // Mannschaftsverwaltung): stattdessen den aktuellen Spieltag bearbeiten
    if ($st < 1 || $st > $lmo_spieltage) {
        $st = ($lmo_einstellungen->aktuellerSpieltag() >= 1 && $lmo_einstellungen->aktuellerSpieltag() <= $lmo_spieltage) ? $lmo_einstellungen->aktuellerSpieltag() : 1;
    }
    if (!isset($save)) {
        $save = 0;
    }
    $me = array('0', 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
    if ($save == 1) {
        // Die Eingaben kommen in die Rohdaten des Spieltags (Lmo\Liga\Rohdaten\Spieltag, Partie);
        // lmo-saveliga.php schreibt sie.
        $lmo_spieltag = $lmo_liga->spieltag((int)$st);
        if ($_SESSION['lmouserok'] == 2) {
            foreach (array('xdatum1', 'xdatum2') as $lmo_feld) {
                $lmo_datum = isset($_POST[$lmo_feld]) ? trim($_POST[$lmo_feld]) : '';
                if ($lmo_datum != '') {
                    $datum = explode('.', $lmo_datum);
                    $dummy = strtotime($datum[0] . ' ' . $me[intval($datum[1])] . ' ' . $datum[2]);
                    if ($dummy > -1) {
                        $lmo_datum = date('d.m.Y', $dummy);
                    } else {
                        $lmo_datum = '';
                    }
                }
                if ($lmo_feld == 'xdatum1') {
                    $lmo_spieltag->setzeErstenTag($lmo_datum);
                } else {
                    $lmo_spieltag->setzeLetztenTag($lmo_datum);
                }
            }
        }
        // neue Ergebnisse: die Tabellenkorrektur gilt ab diesem Spieltag nicht mehr
        if ($lmo_einstellungen->mitHandicap()) {
            for ($i = (int)$st; $i <= $lmo_spieltage; $i++) {
                $lmo_liga->spieltag($i)->setzeTabellenkorrektur('0');
            }
        }
        // Anstoss aus Datum und Uhrzeit des Formulars: Zeitstempel, null ohne oder mit unlesbarem Datum
        $lmo_anstoss = static function (string $lmo_nr) use ($deftime): ?int {
            $dum1 = isset($_POST['xatdat' . $lmo_nr]) ? trim($_POST['xatdat' . $lmo_nr]) : '';
            $dum2 = isset($_POST['xattim' . $lmo_nr]) ? trim($_POST['xattim' . $lmo_nr]) : '';
            if ($dum1 == '') {
                return null;
            }
            if ($dum2 == '') {
                $dum2 = $deftime;
            }
            $dt = DateTime::createFromFormat('d.m.Y H:i', $dum1 . ' ' . $dum2);

            return $dt !== false ? $dt->getTimestamp() : null;
        };
        // Tore aus dem Formular: leer und "_" heissen nicht gespielt (null), "X" (nur Liga) 0, sonst die Zahl
        $lmo_tore = static function (string $lmo_feld, bool $lmo_mitX): ?int {
            $lmo_wert = isset($_POST[$lmo_feld]) ? trim($_POST[$lmo_feld]) : '';
            if ($lmo_wert == '' || $lmo_wert == '_') {
                return null;
            }
            if ($lmo_mitX && strtoupper($lmo_wert) == 'X') {
                return 0;
            }

            return intval($lmo_wert);
        };
        // Zusatz aus dem Formular: "_" (kein Zusatz, 0) und die beiden Anzeigetexte (2 = n.V., 1 = i.E.); alles andere: keine Angabe
        $lmo_zusatz = static function (string $lmo_wert) use ($text): ?int {
            if ($lmo_wert == '_') {
                return 0;
            }
            if ($lmo_wert == $text[0]) {
                return 2;
            }

            return $lmo_wert == $text[1] ? 1 : null;
        };
        $lmo_partien = $lmo_einstellungen->partienImSpieltag((int)$st);
        $lmo_modus = \Lmo\Liga\Paarung::spieleJePaarung($lmo_liga, (int)$st);
        $lmo_termine = array();
        for ($i = 0; $i < $lmo_partien; $i++) {
            $lmo_partie = $lmo_spieltag->partie($i + 1);
            if ($_SESSION['lmouserok'] == 2 || $_SESSION['lmouserokerweitert'] == 1) {
                $lmo_partie->setzeMannschaften((int)($_POST['xteama' . $i] ?? 0), (int)($_POST['xteamb' . $i] ?? 0));
            }
            if (!$lmo_pokal) {
                $lmo_zeit = $lmo_anstoss((string)$i);
                $lmo_partie->setzeAnstoss($lmo_zeit);
                // mit Wertung am gruenen Tisch (0 = keine, 1 = fuer Heim, 2 = fuer Gast, 3 = gegen beide)
                $lmo_partie->setzeErgebnis($lmo_tore('xgoala' . $i, true), $lmo_tore('xgoalb' . $i, true), (int)$_POST['xmsieg' . $i]);
                if ($lmo_einstellungen->mitVerlaengerung()) {
                    $lmo_partie->setzeZusatz($lmo_zusatz((string)$_POST['xmspez' . $i]));
                }
                $lmo_partie->setzeNotiz(trim($_POST['xmnote' . $i]));
                $lmo_partie->setzeBericht(trim($_POST['xmberi' . $i]));
                if ($_SESSION['lmouserok'] == 2 && $ftest0 == 1) {
                    $lmo_partie->setzeOhneTippwertung(trim($_POST['xmtipp' . $i]) == 1);
                }
                $lmo_termine[] = (int)$lmo_zeit;
            } else {
                for ($n = 0; $n < $lmo_modus; $n++) {
                    $lmo_zeit = $lmo_anstoss($i . $n);
                    $lmo_partie->setzeAnstoss($lmo_zeit, $n + 1);
                    $lmo_partie->setzeErgebnis($lmo_tore('xgoala' . $i . $n, false), $lmo_tore('xgoalb' . $i . $n, false), null, $n + 1);
                    $lmo_partie->setzeZusatz($lmo_zusatz((string)$_POST['xmspez' . $i . $n]), $n + 1);
                    $lmo_partie->setzeNotiz(trim($_POST['xmnote' . $i . $n]), $n + 1);
                    $lmo_partie->setzeBericht(trim($_POST['xmberi' . $i . $n]), $n + 1);
                    if ($_SESSION['lmouserok'] == 2 && $ftest0 == 1) {
                        $lmo_partie->setzeOhneTippwertung(trim($_POST['xmtipp' . $i . $n]) == 1, $n + 1);
                    }
                    $lmo_termine[] = (int)$lmo_zeit;
                }
            }
        }
        // Fieberkurve: fuehrt die erste Kurve die Lieblingsmannschaft, zeigt die zweite deren naechsten Gegner
        $lmo_lieblingsmannschaft = $lmo_einstellungen->lieblingsmannschaft();
        if ($st < $lmo_spieltage && $lmo_lieblingsmannschaft > 0 && $lmo_einstellungen->fieberkurveErste() == $lmo_lieblingsmannschaft) {
            for ($y = 1; $y <= $lmo_einstellungen->partienJeSpieltag(); $y++) {
                $lmo_naechste = $lmo_liga->spieltage[(int)$st + 1]->partien[$y] ?? null;
                if ($lmo_naechste !== null && (int)$lmo_naechste->heim == $lmo_lieblingsmannschaft) {
                    $lmo_liga->setzeEinstellung('kurve2', (string)$lmo_naechste->gast);
                }
                if ($lmo_naechste !== null && (int)$lmo_naechste->gast == $lmo_lieblingsmannschaft) {
                    $lmo_liga->setzeEinstellung('kurve2', (string)$lmo_naechste->heim);
                }
            }
        }

        /*Spieltagsdatum (falls nicht angegeben) aus Spieldaten extrahieren*/
        $lmo_spieltermine = array_filter($lmo_termine, 'filterZero');
        if (!empty($lmo_spieltermine)) {
            if (empty($lmo_spieltag->werte['D1'])) {
                $lmo_spieltag->setzeErstenTag(date('d.m.Y', min($lmo_spieltermine)));
            }
            if (empty($lmo_spieltag->werte['D2'])) {
                $lmo_spieltag->setzeLetztenTag(date('d.m.Y', max($lmo_spieltermine)));
            }
        }

        // Tippspiel-Addon
        if ($ftest0 == 1) {
            // Liga darf getippt werden
            if ($tipp_aktauswert == 1) {
                require(PATH_TO_ADDONDIR . '/tipp/lmo-tippsavewert.php');
            }
            if ($tipp_aktauswertges == 1) {
                require(PATH_TO_ADDONDIR . '/tipp/lmo-tippsavewertgesamt.php');
            }
        }
        // Tippspiel-Addon
        // aktueller Spieltag: der im Formular gewaehlte, sonst der bearbeitete
        $stz = trim($_POST['xstx']);
        $lmo_liga->setzeEinstellung('Actual', $stz != 0 ? $stz : (string)$st);
        $lmo_liga->setzeEinstellung('ticker', trim($_POST['xnticker']));
        // die Newszeilen ohne die leeren
        $lmo_liga->setzeNews(array_values(array_filter(explode('\n', $_POST['xnlines']), static fn (string $y): bool => $y != '')));
        // lmo-saveliga.php schreibt den gewaehlten Spieltag als aktuellen
        $stz = $st;
        $st = $lmo_liga->optionen['Actual'];
        require(PATH_TO_LMO . '/lmo-saveliga.php');
        $st = $stz;
    }

    // Rückrunden-Hack
    if ($save == 990) require_once(PATH_TO_LMO . '/lmo-rueckrunde.php');

    // der Stand nach dem Speichern: Einstellungen, Spieltag und seine Paarungen (Lmo\Liga\Paarung) zum Anzeigen
    $lmo_einstellungen = $lmo_liga->einstellungen();
    $lmo_spieltage = $lmo_einstellungen->spieltage();
    $lmo_mannschaften = $lmo_einstellungen->mannschaften();
    $lmo_partien = $lmo_einstellungen->partienImSpieltag((int)$st);
    $lmo_modus = \Lmo\Liga\Paarung::spieleJePaarung($lmo_liga, (int)$st);
    $lmo_playdown = $lmo_einstellungen->wert('playdown');
    $lmo_playoffmodus = $lmo_einstellungen->playoffModus();
    $lmo_datum1 = $lmo_liga->spieltage[(int)$st]->werte['D1'] ?? '';
    $lmo_datum2 = $lmo_liga->spieltage[(int)$st]->werte['D2'] ?? '';
    // Namen der Mannschaften fuer die Auswahllisten, davor "___" fuer keine
    $lmo_namen = array_fill(0, $lmo_mannschaften + 2, '');
    $lmo_namen[0] = '___';
    foreach ($lmo_liga->alleMannschaften() as $lmo_nr => $lmo_mannschaft) {
        $lmo_namen[$lmo_nr] = $lmo_mannschaft->anzeigename();
    }
    $lmo_newszeilen = array();
    foreach ($lmo_liga->news as $lmo_schluessel => $lmo_wert) {
        if ($lmo_schluessel != 'NC') {
            $lmo_newszeilen[] = stripslashes($lmo_wert);
        }
    }
    if ($lmo_pokal) {
        // wer in den Runden davor ausgeschieden ist (1); mit Spiel um Platz 3 die Verlierer der Runde davor (2)
        $teamt = array_pad(array('0'), 129, '0');
        for ($i = 1; $i < $st; $i++) {
            foreach ($lmo_liga->paarungen($i) as $lmo_paarung) {
                $m = $lmo_paarung->sieger();
                if ($m == 0) {
                    continue;
                }
                $lmo_verlierer = $m == 1 ? $lmo_paarung->gast : $lmo_paarung->heim;
                $teamt[$lmo_verlierer] = ($lmo_einstellungen->mitSpielUmPlatz3() && $i == $st - 1) ? 2 : 1;
            }
        }
    }
    $addr = $_SERVER['PHP_SELF'] . '?action=admin&amp;todo=edit&amp;file=' . $file . '&amp;st=';
    $addb = $_SERVER['PHP_SELF'] . '?action=admin&amp;todo=tabs&amp;file=' . $file . '&amp;st=';
    $breite = 18 - ($lmo_pokal ? 1 : 0);
    if ($lmo_einstellungen->mitVerlaengerung()) {
        $breite = $breite + 1 + ($lmo_pokal ? 1 : 0);
    }

    include(PATH_TO_LMO . '/lmo-adminsubnavi.php'); ?>
      <table class="lmoMiddle" cellspacing="0" cellpadding="0" border="0">
        <tr>
          <td align="center"><h1><?php echo $lmo_einstellungen->name(); ?></h1></td>
        </tr>
        <tr>
          <td align="center">
<?php
    include (PATH_TO_LMO . '/lmo-spieltagsmenu.php');
    if (!$lmo_pokal) { ?>
            <form  name="lmoedit_second_half" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
              <input type="hidden" name="action" value="admin">
              <input type="hidden" name="todo" value="edit">
              <input type="hidden" name="save" value="990">
              <input type="hidden" name="file" value="<?php echo $file; ?>">
              <input type="hidden" name="st" value="<?php echo $st; ?>">
              <input type="submit" name="rueckrundeButton" class="lmo-formular-button" value="<?php echo $text[3000]; ?>">
            </form>
<?php
    }
?>
          </td>
        </tr>
        <tr>
          <td align="center">
            <form name="lmoedit" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" onSubmit="return chklmopass()">
              <input type="hidden" name="action" value="admin">
              <input type="hidden" name="todo" value="edit">
              <input type="hidden" name="save" value="1">
              <input type="hidden" name="file" value="<?php echo $file; ?>">
              <input type="hidden" name="st" value="<?php echo $st; ?>">
              <table class="lmoInner" cellspacing="0" cellpadding="0" border="0">
                <tr>
                  <th class="nobr" style="text-align:left" colspan="<?php echo $breite - 10; ?>">
<?php
    echo '                    ' . $st .  '. ' . $text[2];
    if ($lmo_datum1 != '') {
        $datum = explode('.', $lmo_datum1);
        $dum1 = $me[intval($datum[1])] . ' ' . $datum[2];
    } else {
        $dum1 = '';
    }
    if ($lmo_datum2 != '') {
        $datum = explode('.', $lmo_datum2);
        $dum2 = $me[intval($datum[1])] . ' ' . $datum[2];
    } else {
        $dum2 = '';
    }
    if ($_SESSION['lmouserok'] == 2 || $_SESSION['lmouserokerweitert'] == 1) { ?>

                    <acronym title="<?php echo $text[105]; ?>"> <?php echo $text[3]; ?></acronym> <input class="lmo-formular-input" type="text" name="xdatum1" tabindex="01" size="10" maxlength="10" value="<?php echo $lmo_datum1; ?>" onChange="dolmoedit()"> <script type="text/javascript">document.write('<a href="#" onclick="opencal(\'xdatum1\',\'<?php echo $dum1; ?>\')" title="<?php echo $text[139]; ?>" onMouseOver="lmoimg(\'d1\',img5)" onMouseOut="lmoimg(\'d1\',img4)"><img src="<?php echo URL_TO_IMGDIR; ?>/lmo-admin4.gif" name="ximgd1" width="12" height="11" border="0"></a>');</script>
                    <acronym title="<?php echo $text[106]; ?>"> <?php echo $text[4]; ?></acronym> <input class="lmo-formular-input" type="text" name="xdatum2" tabindex="02" size="10" maxlength="10" value="<?php echo $lmo_datum2; ?>" onChange="dolmoedit()"> <script type="text/javascript">document.write('<a href="#" onclick="opencal(\'xdatum2\',\'<?php echo $dum2; ?>\')" title="<?php echo $text[139]; ?>" onMouseOver="lmoimg(\'d2\',img5)" onMouseOut="lmoimg(\'d2\',img4)"><img src="<?php echo URL_TO_IMGDIR; ?>/lmo-admin4.gif" name="ximgd2" width="12" height="11" border="0"></a>');</script>
<?php
    }?>
                  </th>
<?php
    if ($lmo_einstellungen->torfaktor() > 0 && $lmo_einstellungen->torfaktor() != 1) { ?>
                  <th style="text-align:center" class="nobr" colspan="<?php echo $breite - 13; ?>"><?php if ($lmo_einstellungen->torfaktor() > 0 && $lmo_einstellungen->torfaktor() != 1) {echo '(' . $text[553 + log10($lmo_einstellungen->torfaktor())] . ')';}?></th>
<?php
    } else { ?>
                  <th colspan="<?php echo $breite - 13; ?>">&nbsp;</th>
<?php
    }
    if (!$lmo_pokal) { ?>
                  <th style="text-align:center" class="nobr"><acronym title="<?php echo $text[213]; ?>"><img src="<?php echo URL_TO_IMGDIR; ?>/paragraph.svg" height="20" alt="<?php echo $text[217]; ?>"></acronym></th>
<?php
    }?>
                  <th style="text-align:center" class="nobr"><acronym title="<?php echo $text[112]; ?>"><img src="<?php echo URL_TO_IMGDIR; ?>/notiz.svg" height="20" alt="<?php echo $text[218]; ?>"></acronym></th>
                  <th style="text-align:center" class="nobr"><acronym title="<?php echo $text[263]; ?>"><img src="<?php echo URL_TO_IMGDIR; ?>/spielbericht.svg" height="20" alt="<?php echo $text[262]; ?>"></acronym></th>
<?php
    if ($_SESSION['lmouserok'] == 2 && $ftest0 == 1) { ?>
                  <th style="text-align:center" class="nobr"><acronym title="<?php echo $text['tipp'][57]; ?>"><?php echo $text['tipp'][57]; ?></acronym></th>
<?php
    }?>
                </tr>
<?php
    for ($i = 0; $i < $lmo_partien; $i++) {
        // die Paarung mit ihren Spielen; in der Liga genau eines
        $lmo_paarung = \Lmo\Liga\Paarung::ausRohdaten($lmo_liga, (int)$st, $i + 1);
        $lmo_spiel = $lmo_paarung->spiele[0];
        $lmo_tore_heim = $lmo_spiel->toreHeimText();
        $lmo_tore_gast = $lmo_spiel->toreGastText();
        $lmo_zusatz = $lmo_spiel->zusatzText($text[0], $text[1]);
        if (!$lmo_pokal) { ?>
                <tr>
<?php
            if (isset($lmo_spiel->anstoss) && filterZero($lmo_spiel->anstoss)) {
                $dt = new DateTime();
                $dt->setTimestamp((int)$lmo_spiel->anstoss);
                $dum1 = $dt->format('d.m.Y');
                $dum2 = $dt->format('H:i');
                $dum3 = $me[intval($dt->format('m'))] . ' ' . $dt->format('Y');
            } else {
                $dum1 = $dum2 = $dum3 = '';
            }?>
                  <td class="nobr"><input title="<?php echo $text[122]; ?>" class="lmo-formular-input" type="text" name="xatdat<?php echo $i; ?>" tabindex="<?php echo $i; ?>03" size="10" maxlength="10" value="<?php echo $dum1; ?>" onChange="dolmoedit()" ondblclick="fillAll(this);"><script type="text/javascript">document.write('<a href="#" onclick="opencal(\'xatdat<?php echo $i; ?>\',\'<?php echo $dum3; ?>\')" title="<?php echo $text[139]; ?>" onMouseOver="lmoimg(\'<?php echo $i; ?>c\',img5)" onMouseOut="lmoimg(\'<?php echo $i; ?>c\',img4)"><img src="<?php echo URL_TO_IMGDIR; ?>/lmo-admin4.gif" name="ximg<?php echo $i; ?>c" width="12" height="11" border="0"><\/a>');</script></td>
                  <td><input title="<?php echo $text[123]; ?>" class="lmo-formular-input" type="text" name="xattim<?php echo $i; ?>" tabindex="<?php echo $i; ?>04" size="5" maxlength="5" value="<?php echo $dum2; ?>" onChange="dolmoedit()" ondblclick="fillAll(this);"></td>
                  <td width="2">&nbsp;</td>
                 <td class="nobr" align="right">
<?php
            if ($_SESSION['lmouserok'] == 2 || $_SESSION['lmouserokerweitert'] == 1) { ?>
                    <select class="lmo-formular-input" name="xteama<?php echo $i; ?>" onChange="dolmoedit()" tabindex="<?php echo $i; ?>05">
<?php
                for ($y = 0; $y <= $lmo_mannschaften; $y++) { ?>
                      <option value="<?php echo $y; ?>"<?php if ($y == $lmo_paarung->heim) {echo ' selected';}?>><?php echo $lmo_namen[$y]; ?></option>
<?php
                }?>
                    </select>
<?php
            } else {
                echo $lmo_namen[$lmo_paarung->heim];
            }?>
                  </td>
                  <td align="center" width="10">-</td>
                  <td class="nobr">
<?php
            if ($_SESSION['lmouserok'] == 2 || $_SESSION['lmouserokerweitert'] == 1) { ?>
                    <select class="lmo-formular-input" name="xteamb<?php echo $i; ?>" onChange="dolmoedit()" title="<?php echo $text[108]; ?>" tabindex="<?php echo $i; ?>06">
<?php
                for ($y = 0; $y <= $lmo_mannschaften; $y++) { ?>
                      <option value="<?php echo $y; ?>"<?php if ($y == $lmo_paarung->gast) {echo ' selected';}?>><?php echo $lmo_namen[$y]; ?></option>
<?php
                }?>
                    </select>
<?php
            } else {
                echo $lmo_namen[$lmo_paarung->gast];
            }
            if ($lmo_tore_heim == '-1') {
                $lmo_tore_heim = '_';
            }
            if ($lmo_tore_gast == '-1') {
                $lmo_tore_gast = '_';
            }?>
                  </td>
                  <td width="2">&nbsp;</td>
                  <td class="lmoBackMarkierung" align="right"><input title="<?php echo $text[109]; ?>" class="lmo-formular-input" type="text" name="xgoala<?php echo $i; ?>" tabindex="<?php echo $i; ?>07" size="2" maxlength="4" value="<?php echo $lmo_tore_heim; ?>" onChange="lmotorgte('a','<?php echo $i; ?>')" onKeyDown="lmotorclk('a','<?php echo $i; ?>',event.keyCode)"></td>
                  <td class="lmoBackMarkierung nobr" align="center">
                    <table cellpadding="0" cellspacing="0" border="0">
                      <tr>
                        <td><script type="text/javascript">document.write('<a href="#" onclick="lmotorauf(\'a\',\'<?php echo $i; ?>\',1);return false;" title="<?php echo $text[120]; ?>" onMouseOver="lmoimg(\'<?php echo $i; ?>a\',img1)" onMouseOut="lmoimg(\'<?php echo $i; ?>a\',img0)"><img src="<?php echo URL_TO_IMGDIR; ?>/lmo-admin0.gif" name="ximg<?php echo $i; ?>a" width="7" height="7" border="0"><\/a>')</script></td>
                      </tr>
                      <tr>
                        <td><script type="text/javascript">document.write('<a href="#" onclick="lmotorauf(\'a\',\'<?php echo $i; ?>\',-1);return false;" title="<?php echo $text[120]; ?>" onMouseOver="lmoimg(\'<?php echo $i; ?>b\',img3)" onMouseOut="lmoimg(\'<?php echo $i; ?>b\',img2)"><img src="<?php echo URL_TO_IMGDIR; ?>/lmo-admin2.gif" name="ximg<?php echo $i; ?>b" width="7" height="7" border="0"><\/a>')</script></td>
                      </tr>
                    </table>
                  </td>
                  <td class="lmoBackMarkierung" align="center" width="8">:</td>
                  <td class="lmoBackMarkierung" align="right"><input title="<?php echo $text[110]; ?>" class="lmo-formular-input" type="text" name="xgoalb<?php echo $i; ?>" tabindex="<?php echo $i; ?>08" size="2" maxlength="4" value="<?php echo $lmo_tore_gast; ?>" onChange="lmotorgte('b','<?php echo $i; ?>')" onKeyDown="lmotorclk('b','<?php echo $i; ?>',event.keyCode)"></td>
                  <td class="lmoBackMarkierung" align="center">
                    <table cellpadding="0" cellspacing="0" border="0">
                      <tr>
                        <td valign="bottom"><script type="text/javascript">document.write('<a href="#" onclick="lmotorauf(\'b\',\'<?php echo $i; ?>\',1);return false;" title="<?php echo $text[121]; ?>" onMouseOver="lmoimg(\'<?php echo $i; ?>f\',img1)" onMouseOut="lmoimg(\'<?php echo $i; ?>f\',img0)"><img src="<?php echo URL_TO_IMGDIR; ?>/lmo-admin0.gif" name="ximg<?php echo $i; ?>f" width="7" height="7" border="0"><\/a>')</script></td>
                      </tr>
                      <tr>
                        <td valign="top"><script type="text/javascript">document.write('<a href="#" onclick="lmotorauf(\'b\',\'<?php echo $i; ?>\',-1);return false;" title="<?php echo $text[121]; ?>" onMouseOver="lmoimg(\'<?php echo $i; ?>d\',img3)" onMouseOut="lmoimg(\'<?php echo $i; ?>d\',img2)"><img src="<?php echo URL_TO_IMGDIR; ?>/lmo-admin2.gif" name="ximg<?php echo $i; ?>d" width="7" height="7" border="0"><\/a>')</script></td>
                      </tr>
                    </table>
                  </td>
<?php
            if ($lmo_einstellungen->mitVerlaengerung()) { ?>
                  <td width="2">&nbsp;</td>
                  <td>
                    <select class="lmo-formular-input" name="xmspez<?php echo $i; ?>" onChange="dolmoedit()" tabindex="<?php echo $i; ?>09" >
                      <option<?php if ($lmo_zusatz == '&nbsp;') {echo ' selected';}?>>_</option>
                      <option<?php if ($lmo_zusatz == $text[0]) {echo ' selected';}?>><?php echo $text[0]; ?></option>
                      <option<?php if ($lmo_zusatz == $text[1]) {echo ' selected';}?>><?php echo $text[1]; ?></option>
                    </select>
                  </td>
<?php
            }?>
                  <td width="2">&nbsp;</td>
                  <td align="center">
                    <select id="gT<?php echo $i; ?>" class="lmo-formular-input" name="xmsieg<?php echo $i; ?>" onChange="dolmoedit()" tabindex="<?php echo $i; ?>10" >
                      <option value="0"<?php if ($lmo_spiel->wertung == 0) {echo ' selected';}?>>_</option>
                      <option value="1"<?php if ($lmo_spiel->wertung == 1) {echo ' selected';}?>><?php echo $text[214]; ?></option>
                      <option value="2"<?php if ($lmo_spiel->wertung == 2) {echo ' selected';}?>><?php echo $text[215]; ?></option>
                      <option value="3"<?php if ($lmo_spiel->wertung == 3) {echo ' selected';}?>><?php echo $text[216]; ?></option>
                    </select>
<?php
            if ($lmo_spiel->wertung == 0) { ?>
                    <script type="text/javascript">document.getElementById('gT<?php echo $i; ?>').style.display='none';document.write('<a href="#" onClick="this.style.display=\'none\';document.getElementById(\'gT<?php echo $i; ?>\').style.display=\'inline\';return false;">+</a>');</script>
<?php
            }?>
                  </td>
                  <td align="center">
                    <input id="n<?php echo $i; ?>" class="lmo-formular-input" type="text" name="xmnote<?php echo $i; ?>" tabindex="<?php echo $i; ?>11" size="16" maxlength="255" value="<?php echo htmlentities($lmo_spiel->notiz); ?>" onChange="dolmoedit()">
<?php
            if (trim($lmo_spiel->notiz) == '') { ?>
                    <script type="text/javascript">document.getElementById('n<?php echo $i; ?>').style.display='none';document.write('<a href="#" onClick="this.style.display=\'none\';document.getElementById(\'n<?php echo $i; ?>\').style.display=\'inline\';return false;">+</a>');</script>
<?php
            }?>
                  </td>
                  <td align="center"><input id="s<?php echo $i; ?>" class="lmo-formular-input" type="text" name="xmberi<?php echo $i; ?>" tabindex="<?php echo $i; ?>12" size="16" maxlength="255" value="<?php echo htmlentities($lmo_spiel->bericht); ?>" onChange="dolmoedit()">
<?php
            if (trim($lmo_spiel->bericht) == '') { ?>
                    <script type="text/javascript">document.getElementById('s<?php echo $i; ?>').style.display='none';document.write('<a href="#" onClick="this.style.display=\'none\';document.getElementById(\'s<?php echo $i; ?>\').style.display=\'inline\';return false;">+</a>');</script>
<?php
            }?>
                  </td>
<?php
            /*Tippspiel-Addon*/
            if ($_SESSION['lmouserok'] == 2 && $ftest0 == 1) { ?>
                  <td>
                    <select class="lmo-formular-input" name="xmtipp<?php echo $i; ?>" onChange="dolmoedit()" tabindex="<?php echo $i; ?>13" >
                      <option value="0"<?php if ((int)$lmo_spiel->ohneTippwertung < 1) {echo ' selected';}?>>_</option>
                      <option value="1"<?php if ((int)$lmo_spiel->ohneTippwertung == 1) {echo ' selected';}?>><?php echo $text['tipp'][199]; ?></option>
                    </select>
                  </td>
<?php
            }?>
                </tr>
<?php
        } else {
            /*Pokalmodus*/
            for ($n = 0; $n < $lmo_modus; $n++) {
                $lmo_spiel = $lmo_paarung->spiele[$n];
                $lmo_tore_heim = $lmo_spiel->toreHeimText();
                $lmo_tore_gast = $lmo_spiel->toreGastText();
                $lmo_zusatz = $lmo_spiel->zusatzText($text[0], $text[1]);
                if ($lmo_einstellungen->mitSpielUmPlatz3() && ($st == $lmo_spieltage)) { ?>
                <tr>
                  <td class="nobr" colspan=<?php echo $breite; ?>><?php if ($i == 1) {echo '&nbsp;<br>';} echo $text[419 + $i]; ?></td>
                </tr>
<?php
                }?>
                <tr>
<?php
                if (isset($lmo_spiel->anstoss) && filterZero($lmo_spiel->anstoss)) {
                  $dt = new DateTime();
                  $dt->setTimestamp((int)$lmo_spiel->anstoss);
                  $dum1 = $dt->format('d.m.Y');
                  $dum2 = $dt->format('H:i');
                  $dum3 = $me[intval($dt->format('m'))] . ' ' . $dt->format('Y');
                } else {
                  $dum1 = $dum2 = $dum3 = '';
                }?>
                  <td class="nobr"><input title="<?php echo $text[122]; ?>" class="lmo-formular-input" type="text" name="xatdat<?php echo $i . $n; ?>" tabindex="<?php echo $i . $n; ?>03" size="10" maxlength="10" value="<?php echo $dum1; ?>" onChange="dolmoedit()"><script type="text/javascript">document.write('<a href="#" onclick="opencal(\'xatdat<?php echo $i . $n; ?>\',\'<?php echo $dum3; ?>\')" title="<?php echo $text[139]; ?>" onMouseOver="lmoimg(\'<?php echo $i . $n; ?>c\',img5)" onMouseOut="lmoimg(\'<?php echo $i . $n; ?>c\',img4)"><img src="<?php echo URL_TO_IMGDIR; ?>/lmo-admin4.gif" name="ximg<?php echo $i . $n; ?>c" width="12" height="11" border="0"><\/a>');</script></td>
                  <td><input title="<?php echo $text[123]; ?>" class="lmo-formular-input" type="text" name="xattim<?php echo $i . $n; ?>" tabindex="<?php echo $i . $n; ?>04" size="5" maxlength="5" value="<?php echo $dum2; ?>" onChange="dolmoedit()"></td>
                  <td width="2">&nbsp;</td>
<?php
                if ($n == 0) { ?>
                  <td class="nobr" align="right">
<?php
                    if ($_SESSION['lmouserok'] == 2 || $_SESSION['lmouserokerweitert'] == 1) { ?>
                    <select class="lmo-formular-input" name="xteama<?php echo $i; ?>" onChange="dolmoedit()" title="<?php echo $text[107]; ?>" tabindex="<?php echo $i . $n; ?>05">
<?php

                        if ($lmo_einstellungen->mitSpielUmPlatz3() && ($st == $lmo_spieltage) && ($i == 1)) {
                            echo '<option value="0"';
                            if ($lmo_paarung->heim == 0) {
                                echo ' selected';
                            }
                            echo '>' . $lmo_namen[0] . '</option>';
                            for ($y = 1; $y <= $lmo_mannschaften; $y++) {
                                if (($lmo_playdown == 0 && $teamt[$y] == 2) || $lmo_playdown == 1) {
                                    echo '<option value="' . $y . '"';
                                    if ($y == $lmo_paarung->heim) {
                                        echo ' selected';
                                    }
                                    echo '>' . $lmo_namen[$y] . '</option>';
                                }
                            }
                        } else {
                            for ($y = 0; $y <= $lmo_mannschaften; $y++) {
                                if (($lmo_playdown == 0 && $teamt[$y] == 0) || $lmo_playdown == 1) {
                                    echo '<option value="' . $y . '"';
                                    if ($y == $lmo_paarung->heim) {
                                        echo ' selected';
                                    }
                                    echo '>' . $lmo_namen[$y] . '</option>';
                                }
                            }
                        }
?>
                    </select>
<?php
                    } else {
                        echo $lmo_namen[$lmo_paarung->heim];
                    }
?>
                  </td>
                  <td align="center" width="10">-</td>
                  <td class="nobr">
<?php
                    if ($_SESSION['lmouserok'] == 2 || $_SESSION['lmouserokerweitert'] == 1) { ?>
                    <select class="lmo-formular-input" name="xteamb<?php echo $i; ?>" onChange="dolmoedit()" title="<?php echo $text[108]; ?>" tabindex="<?php echo $i . $n; ?>06">
<?php
                        if ($lmo_einstellungen->mitSpielUmPlatz3() && ($st == $lmo_spieltage) && ($i == 1)) {
                            echo '<option value="0"';
                            if ($lmo_paarung->gast == 0) {
                                echo ' selected';
                            }
                            echo '>' . $lmo_namen[0] . '</option>';
                            for ($y = 1; $y <= $lmo_mannschaften; $y++) {
                                if (($lmo_playdown == 0 && $teamt[$y] == 2) || $lmo_playdown == 1) {
                                    echo '<option value="' . $y . '"';
                                    if ($y == $lmo_paarung->gast) {
                                        echo ' selected';
                                    }
                                    echo '>' . $lmo_namen[$y] . '</option>';
                                }
                            }
                        } else {
                            for ($y = 0; $y <= $lmo_mannschaften; $y++) {
                                if (($lmo_playdown == 0 && $teamt[$y] == 0) || $lmo_playdown == 1) {
                                    echo '<option value="' . $y . '"';
                                    if ($y == $lmo_paarung->gast) {
                                        echo ' selected';
                                    }
                                    echo '>' . $lmo_namen[$y] . '</option>';
                                }
                            }
                        }
?>
                    </select>
<?php
                    } else {
                        echo $lmo_namen[$lmo_paarung->gast];
                    }
?>
                  </td>
<?php
                } else {
                    if ($lmo_playoffmodus == 1 || $lmo_playoffmodus == 2) { // Modus 2-2-1 or 2-2-1-1-1
                        if ($n == 1 || $n == 4 || $n == 6) {
?>
                  <td class="nobr" align="right"><?php echo $lmo_namen[$lmo_paarung->heim]; ?></td>
                  <td align="center" width="10">-</td>
                  <td class="nobr"><?php echo $lmo_namen[$lmo_paarung->gast]; ?></td>
<?php
                        } else {
?>
                  <td class="nobr" align="right"><?php echo $lmo_namen[$lmo_paarung->gast]; ?></td>
                  <td align="center" width="10">-</td>
                  <td class="nobr"><?php echo $lmo_namen[$lmo_paarung->heim]; ?></td>
<?php
                        }
                    }
                    if ($lmo_playoffmodus == 3) { // Modus 2-3-2
                        if ($n == 1 || $n == 5 || $n == 6) {
?>
                  <td class="nobr" align="right"><?php echo $lmo_namen[$lmo_paarung->heim]; ?></td>
                  <td align="center" width="10">-</td>
                  <td class="nobr"><?php echo $lmo_namen[$lmo_paarung->gast]; ?></td>
<?php
                        } else {
?>
                  <td class="nobr" align="right"><?php echo $lmo_namen[$lmo_paarung->gast]; ?></td>
                  <td align="center" width="10">-</td>
                  <td class="nobr"><?php echo $lmo_namen[$lmo_paarung->heim]; ?></td>
<?php
                        }
                    }
                    if ($lmo_playoffmodus < 1) { // now Modus = everything else ($playoffmode == 0; and KO-League without $playoffmode Option like old Champions-League Finalrounds)
                        if ($n % 2 == 0) {
?>
                  <td class="nobr" align="right"><?php echo $lmo_namen[$lmo_paarung->heim]; ?></td>
                  <td align="center" width="10">-</td>
                  <td class="nobr"><?php echo $lmo_namen[$lmo_paarung->gast]; ?></td>
<?php
                        } else {
?>
                  <td class="nobr" align="right"><?php echo $lmo_namen[$lmo_paarung->gast]; ?></td>
                  <td align="center" width="10">-</td>
                  <td class="nobr"><?php echo $lmo_namen[$lmo_paarung->heim]; ?></td>
<?php
                        }
                    }
                }
                if ($lmo_tore_heim == '-1') {
                    $lmo_tore_heim = '_';
                }
                if ($lmo_tore_gast == '-1') {
                    $lmo_tore_gast = '_';
                }
                if ($lmo_playoffmodus == 1 || $lmo_playoffmodus == 2) { // Modus 2-2-1 or 2-2-1-1-1
                    if ($n == 0 || $n == 1 || $n == 4 || $n == 6) {
?>
                  <td width="2">&nbsp;</td>
                  <td class="lmoBackMarkierung" align="right"><input title="<?php echo $text[109]; ?>" class="lmo-formular-input" type="text" name="xgoala<?php echo $i . $n; ?>" tabindex="<?php echo $i . $n; ?>07" size="4" maxlength="4" value="<?php echo $lmo_tore_heim; ?>" onChange="lmotorgte('a','<?php echo $i . $n; ?>')" onKeyDown="lmotorclk('a','<?php echo $i . $n; ?>',event.keyCode)"></td>
                  <td class="lmoBackMarkierung" align="center">
                    <table cellpadding="0" cellspacing="0" border="0">
                      <tr>
                        <td><script type="text/javascript">document.write('<a href="#" onclick="lmotorauf(\'a\',\'<?php echo $i . $n; ?>\',1);return false;" title="<?php echo $text[120]; ?>" onMouseOver="lmoimg(\'<?php echo $i . $n; ?>a\',img1)" onMouseOut="lmoimg(\'<?php echo $i . $n; ?>a\',img0)"><img src="<?php echo URL_TO_IMGDIR; ?>/lmo-admin0.gif" name="ximg<?php echo $i . $n; ?>a" width="7" height="7" border="0"><\/a>')</script></td>
                      </tr>
                      <tr>
                        <td><script type="text/javascript">document.write('<a href="#" onclick="lmotorauf(\'a\',\'<?php echo $i . $n; ?>\',-1);return false;" title="<?php echo $text[120]; ?>" onMouseOver="lmoimg(\'<?php echo $i . $n; ?>b\',img3)" onMouseOut="lmoimg(\'<?php echo $i . $n; ?>b\',img2)"><img src="<?php echo URL_TO_IMGDIR; ?>/lmo-admin2.gif" name="ximg<?php echo $i . $n; ?>b" width="7" height="7" border="0"><\/a>')</script></td>
                      </tr>
                    </table>
                  </td>
                  <td class="lmoBackMarkierung" align="center" width="8">:</td>
                  <td class="lmoBackMarkierung" align="right"><input title="<?php echo $text[110]; ?>" class="lmo-formular-input" type="text" name="xgoalb<?php echo $i . $n; ?>" tabindex="<?php echo $i . $n; ?>08" size="4" maxlength="4" value="<?php echo $lmo_tore_gast; ?>" onChange="lmotorgte('b','<?php echo $i . $n; ?>')" onKeyDown="lmotorclk('b','<?php echo $i . $n; ?>',event.keyCode)"></td>
                  <td class="lmoBackMarkierung" align="center">
                    <table cellpadding="0" cellspacing="0" border="0">
                      <tr>
                        <td><script type="text/javascript">document.write('<a href="#" onclick="lmotorauf(\'b\',\'<?php echo $i . $n; ?>\',1);return false;" title="<?php echo $text[121]; ?>" onMouseOver="lmoimg(\'<?php echo $i . $n; ?>f\',img1)" onMouseOut="lmoimg(\'<?php echo $i . $n; ?>f\',img0)"><img src="<?php echo URL_TO_IMGDIR; ?>/lmo-admin0.gif" name="ximg<?php echo $i . $n; ?>f" width="7" height="7" border="0"><\/a>')</script></td>
                      </tr>
                      <tr>
                        <td><script type="text/javascript">document.write('<a href="#" onclick="lmotorauf(\'b\',\'<?php echo $i . $n; ?>\',-1);return false;" title="<?php echo $text[121]; ?>" onMouseOver="lmoimg(\'<?php echo $i . $n; ?>d\',img3)" onMouseOut="lmoimg(\'<?php echo $i . $n; ?>d\',img2)"><img src="<?php echo URL_TO_IMGDIR; ?>/lmo-admin2.gif" name="ximg<?php echo $i . $n; ?>d" width="7" height="7" border="0"><\/a>')</script></td>
                      </tr>
                    </table>
                  </td>
<?php
                    } else {
?>
                  <td width="2">&nbsp;</td>
                  <td class="lmoBackMarkierung" align="right"><input title="<?php echo $text[110]; ?>" class="lmo-formular-input" type="text" name="xgoalb<?php echo $i . $n; ?>" tabindex="<?php echo $i . $n; ?>07" size="4" maxlength="4" value="<?php echo $lmo_tore_gast; ?>" onChange="lmotorgte('b','<?php echo $i . $n; ?>')" onKeyDown="lmotorclk('b','<?php echo $i . $n; ?>',event.keyCode)"></td>
                  <td class="lmoBackMarkierung" align="center">
                    <table cellpadding="0" cellspacing="0" border="0">
                      <tr>
                        <td><script type="text/javascript">document.write('<a href="#" onclick="lmotorauf(\'b\',\'<?php echo $i . $n; ?>\',1);return false;" title="<?php echo $text[121]; ?>" onMouseOver="lmoimg(\'<?php echo $i . $n; ?>f\',img1)" onMouseOut="lmoimg(\'<?php echo $i . $n; ?>f\',img0)"><img src="<?php echo URL_TO_IMGDIR; ?>/lmo-admin0.gif" name="ximg<?php echo $i . $n; ?>f" width="7" height="7" border="0"><\/a>')</script></td>
                      </tr>
                      <tr>
                        <td><script type="text/javascript">document.write('<a href="#" onclick="lmotorauf(\'b\',\'<?php echo $i . $n; ?>\',-1);return false;" title="<?php echo $text[121]; ?>" onMouseOver="lmoimg(\'<?php echo $i . $n; ?>d\',img3)" onMouseOut="lmoimg(\'<?php echo $i . $n; ?>d\',img2)"><img src="<?php echo URL_TO_IMGDIR; ?>/lmo-admin2.gif" name="ximg<?php echo $i . $n; ?>d" width="7" height="7" border="0"><\/a>')</script></td>
                      </tr>
                    </table>
                  </td>
                  <td class="lmoBackMarkierung" align="center" width="8">:</td>
                  <td class="lmoBackMarkierung" align="right"><input title="<?php echo $text[109]; ?>" class="lmo-formular-input" type="text" name="xgoala<?php echo $i . $n; ?>" tabindex="<?php echo $i . $n; ?>08" size="4" maxlength="4" value="<?php echo $lmo_tore_heim; ?>" onChange="lmotorgte('a','<?php echo $i . $n; ?>')" onKeyDown="lmotorclk('a','<?php echo $i . $n; ?>',event.keyCode)"></td>
                  <td class="lmoBackMarkierung" align="center">
                    <table cellpadding="0" cellspacing="0" border="0">
                      <tr>
                        <td><script type="text/javascript">document.write('<a href="#" onclick="lmotorauf(\'a\',\'<?php echo $i . $n; ?>\',1);return false;" title="<?php echo $text[120]; ?>" onMouseOver="lmoimg(\'<?php echo $i . $n; ?>a\',img1)" onMouseOut="lmoimg(\'<?php echo $i . $n; ?>a\',img0)"><img src="<?php echo URL_TO_IMGDIR; ?>/lmo-admin0.gif" name="ximg<?php echo $i . $n; ?>a" width="7" height="7" border="0"><\/a>')</script></td>
                      </tr>
                      <tr>
                        <td><script type="text/javascript">document.write('<a href="#" onclick="lmotorauf(\'a\',\'<?php echo $i . $n; ?>\',-1);return false;" title="<?php echo $text[120]; ?>" onMouseOver="lmoimg(\'<?php echo $i . $n; ?>b\',img3)" onMouseOut="lmoimg(\'<?php echo $i . $n; ?>b\',img2)"><img src="<?php echo URL_TO_IMGDIR; ?>/lmo-admin2.gif" name="ximg<?php echo $i . $n; ?>b" width="7" height="7" border="0"><\/a>')</script></td>
                      </tr>
                    </table>
                  </td>
<?php
                    }
                }
                if ($lmo_playoffmodus == 3) { // Modus 2-3-2
                    if ($n == 0 || $n == 1 || $n == 5 || $n == 6) {
?>
                  <td width="2">&nbsp;</td>
                  <td class="lmoBackMarkierung" align="right"><input title="<?php echo $text[109]; ?>" class="lmo-formular-input" type="text" name="xgoala<?php echo $i . $n; ?>" tabindex="<?php echo $i . $n; ?>07" size="4" maxlength="4" value="<?php echo $lmo_tore_heim; ?>" onChange="lmotorgte('a','<?php echo $i . $n; ?>')" onKeyDown="lmotorclk('a','<?php echo $i . $n; ?>',event.keyCode)"></td>
                  <td class="lmoBackMarkierung" align="center">
                    <table cellpadding="0" cellspacing="0" border="0">
                      <tr>
                        <td><script type="text/javascript">document.write('<a href="#" onclick="lmotorauf(\'a\',\'<?php echo $i . $n; ?>\',1);return false;" title="<?php echo $text[120]; ?>" onMouseOver="lmoimg(\'<?php echo $i . $n; ?>a\',img1)" onMouseOut="lmoimg(\'<?php echo $i . $n; ?>a\',img0)"><img src="<?php echo URL_TO_IMGDIR; ?>/lmo-admin0.gif" name="ximg<?php echo $i . $n; ?>a" width="7" height="7" border="0"><\/a>')</script></td>
                      </tr>
                      <tr>
                        <td><script type="text/javascript">document.write('<a href="#" onclick="lmotorauf(\'a\',\'<?php echo $i . $n; ?>\',-1);return false;" title="<?php echo $text[120]; ?>" onMouseOver="lmoimg(\'<?php echo $i . $n; ?>b\',img3)" onMouseOut="lmoimg(\'<?php echo $i . $n; ?>b\',img2)"><img src="<?php echo URL_TO_IMGDIR; ?>/lmo-admin2.gif" name="ximg<?php echo $i . $n; ?>b" width="7" height="7" border="0"><\/a>')</script></td>
                      </tr>
                    </table>
                  </td>
                  <td class="lmoBackMarkierung" align="center" width="8">:</td>
                  <td class="lmoBackMarkierung" align="right"><input title="<?php echo $text[110]; ?>" class="lmo-formular-input" type="text" name="xgoalb<?php echo $i . $n; ?>" tabindex="<?php echo $i . $n; ?>08" size="4" maxlength="4" value="<?php echo $lmo_tore_gast; ?>" onChange="lmotorgte('b','<?php echo $i . $n; ?>')" onKeyDown="lmotorclk('b','<?php echo $i . $n; ?>',event.keyCode)"></td>
                  <td class="lmoBackMarkierung" align="center">
                    <table cellpadding="0" cellspacing="0" border="0">
                      <tr>
                        <td><script type="text/javascript">document.write('<a href="#" onclick="lmotorauf(\'b\',\'<?php echo $i . $n; ?>\',1);return false;" title="<?php echo $text[121]; ?>" onMouseOver="lmoimg(\'<?php echo $i . $n; ?>f\',img1)" onMouseOut="lmoimg(\'<?php echo $i . $n; ?>f\',img0)"><img src="<?php echo URL_TO_IMGDIR; ?>/lmo-admin0.gif" name="ximg<?php echo $i . $n; ?>f" width="7" height="7" border="0"><\/a>')</script></td>
                      </tr>
                      <tr>
                        <td><script type="text/javascript">document.write('<a href="#" onclick="lmotorauf(\'b\',\'<?php echo $i . $n; ?>\',-1);return false;" title="<?php echo $text[121]; ?>" onMouseOver="lmoimg(\'<?php echo $i . $n; ?>d\',img3)" onMouseOut="lmoimg(\'<?php echo $i . $n; ?>d\',img2)"><img src="<?php echo URL_TO_IMGDIR; ?>/lmo-admin2.gif" name="ximg<?php echo $i . $n; ?>d" width="7" height="7" border="0"><\/a>')</script></td>
                      </tr>
                    </table>
                  </td>
<?php
                    } else {
?>
                  <td width="2">&nbsp;</td>
                  <td class="lmoBackMarkierung" align="right"><input title="<?php echo $text[110]; ?>" class="lmo-formular-input" type="text" name="xgoalb<?php echo $i . $n; ?>" tabindex="<?php echo $i . $n; ?>07" size="4" maxlength="4" value="<?php echo $lmo_tore_gast; ?>" onChange="lmotorgte('b','<?php echo $i . $n; ?>')" onKeyDown="lmotorclk('b','<?php echo $i . $n; ?>',event.keyCode)"></td>
                  <td class="lmoBackMarkierung" align="center">
                    <table cellpadding="0" cellspacing="0" border="0">
                      <tr>
                        <td><script type="text/javascript">document.write('<a href="#" onclick="lmotorauf(\'b\',\'<?php echo $i . $n; ?>\',1);return false;" title="<?php echo $text[121]; ?>" onMouseOver="lmoimg(\'<?php echo $i . $n; ?>f\',img1)" onMouseOut="lmoimg(\'<?php echo $i . $n; ?>f\',img0)"><img src="<?php echo URL_TO_IMGDIR; ?>/lmo-admin0.gif" name="ximg<?php echo $i . $n; ?>f" width="7" height="7" border="0"><\/a>')</script></td>
                      </tr>
                      <tr>
                        <td><script type="text/javascript">document.write('<a href="#" onclick="lmotorauf(\'b\',\'<?php echo $i . $n; ?>\',-1);return false;" title="<?php echo $text[121]; ?>" onMouseOver="lmoimg(\'<?php echo $i . $n; ?>d\',img3)" onMouseOut="lmoimg(\'<?php echo $i . $n; ?>d\',img2)"><img src="<?php echo URL_TO_IMGDIR; ?>/lmo-admin2.gif" name="ximg<?php echo $i . $n; ?>d" width="7" height="7" border="0"><\/a>')</script></td>
                      </tr>
                    </table>
                  </td>
                  <td class="lmoBackMarkierung" align="center" width="8">:</td>
                  <td class="lmoBackMarkierung" align="right"><input title="<?php echo $text[109]; ?>" class="lmo-formular-input" type="text" name="xgoala<?php echo $i . $n; ?>" tabindex="<?php echo $i . $n; ?>08" size="4" maxlength="4" value="<?php echo $lmo_tore_heim; ?>" onChange="lmotorgte('a','<?php echo $i . $n; ?>')" onKeyDown="lmotorclk('a','<?php echo $i . $n; ?>',event.keyCode)"></td>
                  <td class="lmoBackMarkierung" align="center">
                    <table cellpadding="0" cellspacing="0" border="0">
                      <tr>
                        <td><script type="text/javascript">document.write('<a href="#" onclick="lmotorauf(\'a\',\'<?php echo $i . $n; ?>\',1);return false;" title="<?php echo $text[120]; ?>" onMouseOver="lmoimg(\'<?php echo $i . $n; ?>a\',img1)" onMouseOut="lmoimg(\'<?php echo $i . $n; ?>a\',img0)"><img src="<?php echo URL_TO_IMGDIR; ?>/lmo-admin0.gif" name="ximg<?php echo $i . $n; ?>a" width="7" height="7" border="0"><\/a>')</script></td>
                      </tr>
                      <tr>
                        <td><script type="text/javascript">document.write('<a href="#" onclick="lmotorauf(\'a\',\'<?php echo $i . $n; ?>\',-1);return false;" title="<?php echo $text[120]; ?>" onMouseOver="lmoimg(\'<?php echo $i . $n; ?>b\',img3)" onMouseOut="lmoimg(\'<?php echo $i . $n; ?>b\',img2)"><img src="<?php echo URL_TO_IMGDIR; ?>/lmo-admin2.gif" name="ximg<?php echo $i . $n; ?>b" width="7" height="7" border="0"><\/a>')</script></td>
                      </tr>
                    </table>
                  </td>
<?php
                    }
                }
                if ($lmo_playoffmodus < 1) { // now Modus = everything else ($playoffmode == 0; and KO-League without $playoffmode Option like old Champions-League Finalrounds)
                    if ($n % 2 == 0) {
?>
                  <td width="2">&nbsp;</td>
                  <td class="lmoBackMarkierung" align="right"><input title="<?php echo $text[109]; ?>" class="lmo-formular-input" type="text" name="xgoala<?php echo $i . $n; ?>" tabindex="<?php echo $i . $n; ?>07" size="4" maxlength="4" value="<?php echo $lmo_tore_heim; ?>" onChange="lmotorgte('a','<?php echo $i . $n; ?>')" onKeyDown="lmotorclk('a','<?php echo $i . $n; ?>',event.keyCode)"></td>
                  <td class="lmoBackMarkierung" align="center">
                    <table cellpadding="0" cellspacing="0" border="0">
                      <tr>
                        <td><script type="text/javascript">document.write('<a href="#" onclick="lmotorauf(\'a\',\'<?php echo $i . $n; ?>\',1);return false;" title="<?php echo $text[120]; ?>" onMouseOver="lmoimg(\'<?php echo $i . $n; ?>a\',img1)" onMouseOut="lmoimg(\'<?php echo $i . $n; ?>a\',img0)"><img src="<?php echo URL_TO_IMGDIR; ?>/lmo-admin0.gif" name="ximg<?php echo $i . $n; ?>a" width="7" height="7" border="0"><\/a>')</script></td>
                      </tr>
                      <tr>
                        <td><script type="text/javascript">document.write('<a href="#" onclick="lmotorauf(\'a\',\'<?php echo $i . $n; ?>\',-1);return false;" title="<?php echo $text[120]; ?>" onMouseOver="lmoimg(\'<?php echo $i . $n; ?>b\',img3)" onMouseOut="lmoimg(\'<?php echo $i . $n; ?>b\',img2)"><img src="<?php echo URL_TO_IMGDIR; ?>/lmo-admin2.gif" name="ximg<?php echo $i . $n; ?>b" width="7" height="7" border="0"><\/a>')</script></td>
                      </tr>
                    </table>
                  </td>
                  <td class="lmoBackMarkierung" align="center" width="8">:</td>
                  <td class="lmoBackMarkierung" align="right"><input title="<?php echo $text[110]; ?>" class="lmo-formular-input" type="text" name="xgoalb<?php echo $i . $n; ?>" tabindex="<?php echo $i . $n; ?>08" size="4" maxlength="4" value="<?php echo $lmo_tore_gast; ?>" onChange="lmotorgte('b','<?php echo $i . $n; ?>')" onKeyDown="lmotorclk('b','<?php echo $i . $n; ?>',event.keyCode)"></td>
                  <td class="lmoBackMarkierung" align="center">
                    <table cellpadding="0" cellspacing="0" border="0">
                      <tr>
                        <td><script type="text/javascript">document.write('<a href="#" onclick="lmotorauf(\'b\',\'<?php echo $i . $n; ?>\',1);return false;" title="<?php echo $text[121]; ?>" onMouseOver="lmoimg(\'<?php echo $i . $n; ?>f\',img1)" onMouseOut="lmoimg(\'<?php echo $i . $n; ?>f\',img0)"><img src="<?php echo URL_TO_IMGDIR; ?>/lmo-admin0.gif" name="ximg<?php echo $i . $n; ?>f" width="7" height="7" border="0"><\/a>')</script></td>
                      </tr>
                      <tr>
                        <td><script type="text/javascript">document.write('<a href="#" onclick="lmotorauf(\'b\',\'<?php echo $i . $n; ?>\',-1);return false;" title="<?php echo $text[121]; ?>" onMouseOver="lmoimg(\'<?php echo $i . $n; ?>d\',img3)" onMouseOut="lmoimg(\'<?php echo $i . $n; ?>d\',img2)"><img src="<?php echo URL_TO_IMGDIR; ?>/lmo-admin2.gif" name="ximg<?php echo $i . $n; ?>d" width="7" height="7" border="0"><\/a>')</script></td>
                      </tr>
                    </table>
                  </td>
<?php
                    } else {
?>
                  <td width="2">&nbsp;</td>
                  <td class="lmoBackMarkierung" align="right"><input title="<?php echo $text[110]; ?>" class="lmo-formular-input" type="text" name="xgoalb<?php echo $i . $n; ?>" tabindex="<?php echo $i . $n; ?>07" size="4" maxlength="4" value="<?php echo $lmo_tore_gast; ?>" onChange="lmotorgte('b','<?php echo $i . $n; ?>')" onKeyDown="lmotorclk('b','<?php echo $i . $n; ?>',event.keyCode)"></td>
                  <td class="lmoBackMarkierung" align="center">
                    <table cellpadding="0" cellspacing="0" border="0">
                      <tr>
                        <td><script type="text/javascript">document.write('<a href="#" onclick="lmotorauf(\'b\',\'<?php echo $i . $n; ?>\',1);return false;" title="<?php echo $text[121]; ?>" onMouseOver="lmoimg(\'<?php echo $i . $n; ?>f\',img1)" onMouseOut="lmoimg(\'<?php echo $i . $n; ?>f\',img0)"><img src="<?php echo URL_TO_IMGDIR; ?>/lmo-admin0.gif" name="ximg<?php echo $i . $n; ?>f" width="7" height="7" border="0"><\/a>')</script></td>
                      </tr>
                      <tr>
                        <td><script type="text/javascript">document.write('<a href="#" onclick="lmotorauf(\'b\',\'<?php echo $i . $n; ?>\',-1);return false;" title="<?php echo $text[121]; ?>" onMouseOver="lmoimg(\'<?php echo $i . $n; ?>d\',img3)" onMouseOut="lmoimg(\'<?php echo $i . $n; ?>d\',img2)"><img src="<?php echo URL_TO_IMGDIR; ?>/lmo-admin2.gif" name="ximg<?php echo $i . $n; ?>d" width="7" height="7" border="0"><\/a>')</script></td>
                      </tr>
                    </table>
                  </td>
                  <td class="lmoBackMarkierung" align="center" width="8">:</td>
                  <td class="lmoBackMarkierung" align="right"><input title="<?php echo $text[109]; ?>" class="lmo-formular-input" type="text" name="xgoala<?php echo $i . $n; ?>" tabindex="<?php echo $i . $n; ?>08" size="4" maxlength="4" value="<?php echo $lmo_tore_heim; ?>" onChange="lmotorgte('a','<?php echo $i . $n; ?>')" onKeyDown="lmotorclk('a','<?php echo $i . $n; ?>',event.keyCode)"></td>
                  <td class="lmoBackMarkierung" align="center">
                    <table cellpadding="0" cellspacing="0" border="0">
                      <tr>
                        <td><script type="text/javascript">document.write('<a href="#" onclick="lmotorauf(\'a\',\'<?php echo $i . $n; ?>\',1);return false;" title="<?php echo $text[120]; ?>" onMouseOver="lmoimg(\'<?php echo $i . $n; ?>a\',img1)" onMouseOut="lmoimg(\'<?php echo $i . $n; ?>a\',img0)"><img src="<?php echo URL_TO_IMGDIR; ?>/lmo-admin0.gif" name="ximg<?php echo $i . $n; ?>a" width="7" height="7" border="0"><\/a>')</script></td>
                      </tr>
                      <tr>
                        <td><script type="text/javascript">document.write('<a href="#" onclick="lmotorauf(\'a\',\'<?php echo $i . $n; ?>\',-1);return false;" title="<?php echo $text[120]; ?>" onMouseOver="lmoimg(\'<?php echo $i . $n; ?>b\',img3)" onMouseOut="lmoimg(\'<?php echo $i . $n; ?>b\',img2)"><img src="<?php echo URL_TO_IMGDIR; ?>/lmo-admin2.gif" name="ximg<?php echo $i . $n; ?>b" width="7" height="7" border="0"><\/a>')</script></td>
                      </tr>
                    </table>
                  </td>
<?php
                    }
                }
?>
                  <td class="lmoBackMarkierung" width="2">&nbsp;</td>
                  <td class="lmoBackMarkierung">
                    <select class="lmo-formular-input" name="xmspez<?php echo $i . $n; ?>" onChange="dolmoedit()" title="<?php echo $text[111]; ?>" tabindex="<?php echo $i . $n; ?>09">
                      <option<?php if ($lmo_zusatz == "&nbsp;") {echo ' selected';}?>>_</option>
                      <option<?php if ($lmo_zusatz == $text[0]) {echo ' selected';}?>><?php echo $text[0]; ?></option>
                      <option<?php if ($lmo_zusatz == $text[1]) {echo ' selected';}?>><?php echo $text[1]; ?></option>
                    </select>
                  </td>
                  <td width="2">&nbsp;</td>
                  <td><input class="lmo-formular-input" type="text" name="xmnote<?php echo $i . $n; ?>" tabindex="<?php echo $i . $n; ?>10" size="16" value="<?php echo htmlentities($lmo_spiel->notiz); ?>" onChange="dolmoedit()"></td>
                  <td><input class="lmo-formular-input" type="text" name="xmberi<?php echo $i . $n; ?>" tabindex="<?php echo $i . $n; ?>11" size="16" value="<?php echo htmlentities($lmo_spiel->bericht); ?>" onChange="dolmoedit()"></td>
<?php
                /**Tippspiuel-Addon*/
                if ($_SESSION['lmouserok'] == 2 && $ftest0 == 1) { ?>
                  <td>
                    <select class="lmo-formular-input" name="xmtipp<?php echo $i . $n; ?>" onChange="dolmoedit()" title="<?php echo $text['tipp'][57]; ?>" tabindex="<?php echo $i . $n; ?>12">
                      <option value="0"<?php if ((int)$lmo_spiel->ohneTippwertung < 1) {echo ' selected';}?>>_</option>
                      <option value="1"<?php if ((int)$lmo_spiel->ohneTippwertung == 1) {echo ' selected';}?>><?php echo $text['tipp'][199]; ?></option>
                    </select>
                  </td>
<?php
                }?>
                </tr>
<?php
            }
            if (($lmo_modus > 1) && ($i < $lmo_partien - 1)) { ?>
                <tr>
                  <td colspan="<?php echo $breite; ?>">&nbsp;</td>
                </tr>
<?php
            }
        }
    }?>
                <tr>
                  <th class="nobr" colspan="<?php echo $breite; ?>" align="center"><?php echo $text[206]; ?></th>
                </tr>
                <tr>
                  <td class="nobr" colspan="<?php echo $breite; ?>" align="center">
                    <acronym title="<?php echo $text[192]; ?>"><?php echo $text[191]; ?></acronym>
                    <select class="lmo-formular-input" name="xstx" onChange="dolmoedit()" tabindex="<?php echo $i; ?>013">
<?php
    for ($y = 0; $y <= $lmo_spieltage; $y++) {
        echo '<option value="' . $y . '"';
        if ($save == 1) {
            if ($y == 0) {
                echo '>' . $text[403] . '</option>';
            } else {
                if ($y == $lmo_einstellungen->aktuellerSpieltag()) {
                    echo ' selected';
                }
                echo '>' . $y . '. ' . $text[2] . '</option>';
            }
        } else {
            if ($y == 0) {
                echo ' selected>' . $text[403] . '</option>';
            } else {
                echo '>' . $y . '. ' . $text[2] . '</option>';
            }
        }
    }
    ?>
                    </select>
                  </td>
                </tr>
                <tr>
                  <td colspan="<?php echo $breite; ?>" align="center">
                    <acronym title="<?php echo $text[208]; ?>"><?php echo $text[207]; ?></acronym>
                    <select tabindex="<?php echo $i; ?>014" class="lmo-formular-input" name="xnticker" onChange="dolmoedit()">
                      <option value="1"<?php if ($lmo_einstellungen->wert('ticker') == 1) {echo ' selected';}?>><?php echo $text[181]; ?></option>
                      <option value="0"<?php if ($lmo_einstellungen->wert('ticker') == 0) {echo ' selected';}?>><?php echo $text[182]; ?></option>
                    </select>
                  </td>
                </tr>
                <tr>
                  <td colspan="<?php echo $breite; ?>" align="center">
                    <acronym title="<?php echo $text[210]; ?>"><?php echo $text[999]; ?>: </acronym><textarea tabindex="<?php echo $i; ?>015" class="lmo-formular-input" name="xnlines" cols="50" rows="4" onChange="dolmoedit()"><?php if (count($lmo_newszeilen) > 0) {foreach($lmo_newszeilen as $y) {echo $y . "\n";}} ?></textarea>
                  </td>
                </tr>
                <tr>
                  <th style="text-align:center" colspan="<?php echo $breite; ?>" align="center">
                    <input title="<?php echo $text[114]; ?>" tabindex="<?php echo $i; ?>016" class="lmo-formular-button" type="submit" name="best" value="<?php echo $text[103]; ?>">
                  </th>
                </tr>
              </table>
            </form>
          </td>
        </tr>
      </table><?php
}
?>
