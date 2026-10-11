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

if (!isset($ligaDaten->playoffmode)) $ligaDaten->playoffmode = '0';
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

    if (!isset($ligaDaten->nlines)) {
        $ligaDaten->nlines = array();
    }

    require_once(PATH_TO_LMO . '/lmo-openfile.php');
    // Spieltag, den es in der Liga nicht gibt (z.B. st=-2 als Hilfsadmin ohne Recht auf die
    // Mannschaftsverwaltung): stattdessen den aktuellen Spieltag bearbeiten
    if ($st < 1 || $st > $ligaDaten->anzst) {
        $st = ($ligaDaten->stx >= 1 && $ligaDaten->stx <= $ligaDaten->anzst) ? $ligaDaten->stx : 1;
    }
    if (!isset($save)) {
        $save = 0;
    }
    if ($save == 1) {
        $me = array('0', 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
        if ($_SESSION['lmouserok'] == 2) {
            $ligaDaten->datum1[$st - 1] = isset($_POST['xdatum1']) ? trim($_POST['xdatum1']) : '';
            if ($ligaDaten->datum1[$st - 1] != '') {
                $datum = explode('.', $ligaDaten->datum1[$st - 1]);
                $dummy = strtotime($datum[0] . ' ' . $me[intval($datum[1])] . ' ' . $datum[2]);
                if ($dummy > -1) {
                    $ligaDaten->datum1[$st - 1] = date('d.m.Y', $dummy);
                } else {
                    $ligaDaten->datum1[$st - 1] = '';
                }
            }
            $ligaDaten->datum2[$st - 1] = isset($_POST['xdatum2']) ? trim($_POST['xdatum2']) : '';
            if ($ligaDaten->datum2[$st - 1] != '') {
                $datum = explode('.', $ligaDaten->datum2[$st - 1]);
                $dummy = strtotime($datum[0] . ' ' . $me[intval($datum[1])] . ' ' . $datum[2]);
                if ($dummy > -1) {
                    $ligaDaten->datum2[$st - 1] = date('d.m.Y', $dummy);
                } else {
                    $ligaDaten->datum2[$st - 1] = '';
                }
            }
        }
        if ($ligaDaten->hands == 1) {
            for ($i = $st - 1; $i < $ligaDaten->anzst; $i++) {
                $ligaDaten->handp[$i] = 0;
            }
        }
        if ($ligaDaten->lmtype != 0) {
            $anzsp2 = $ligaDaten->anzteams;
            for ($i = 0; $i < $st; $i++) {
                if ($ligaDaten->anzteams == 24) {
                    switch ($i) {
                        case 0:
                        case 1:
                            $anzsp2 = 16;
                        break;
                        case 2:
                            $anzsp2 = 8;
                        break;
                        case 3:
                            $anzsp2 = 4;
                        break;
                        case 4:
                            $anzsp2 = 2;
                        break;
                        case 5:
                            $anzsp2 = 1;
                        break;
                    }
                }
                $anzsp2 = $anzsp2 / 2;
            }
            if (($ligaDaten->klfin == 1) && ($st == $ligaDaten->anzst)) {
                $anzsp2 = $anzsp2 + 1;
            }
        } else {
            $anzsp2 = $ligaDaten->anzsp;
        }
        for ($i = 0; $i < $anzsp2; $i++) {
            if ($ligaDaten->lmtype == 0) {
                $dum1 = isset($_POST['xatdat' . $i]) ? trim($_POST['xatdat' . $i]) : '';
                $dum2 = isset($_POST['xattim' . $i]) ? trim($_POST['xattim' . $i]) : '';
                if ($dum1 != '') {
                    if ($dum2 == '') {
                        $dum2 = $deftime;
                    }
                    $datu1 = explode('.', $dum1);
                    $datu2 = explode(':', $dum2);
                    $dt = DateTime::createFromFormat('d.m.Y H:i', $dum1 . ' ' . $dum2);
                    $dt !== false ? $ligaDaten->mterm[$st - 1][$i] = $dt->getTimestamp() : $ligaDaten->mterm[$st - 1][$i] = '';
                } else {
                    $ligaDaten->mterm[$st - 1][$i] = '';
                }
            } else {
                for ($n = 0; $n < $ligaDaten->modus[$st - 1]; $n++) {
                    $dum1 = isset($_POST['xatdat' . $i . $n]) ? trim($_POST['xatdat' . $i . $n]) : '';
                    $dum2 = isset($_POST['xattim' . $i . $n]) ? trim($_POST['xattim' . $i . $n]) : '';
                    if ($dum1 != '') {
                        if ($dum2 == '') {
                            $dum2 = $deftime;
                        }
                        $datu1 = explode('.', $dum1);
                        $datu2 = explode(':', $dum2);
                        $dt = DateTime::createFromFormat('d.m.Y H:i', $dum1 . ' ' . $dum2);
                        $dt !== false ? $ligaDaten->mterm[$st - 1][$i][$n] = $dt->getTimestamp() : $ligaDaten->mterm[$st - 1][$i][$n] = '';
                    } else {
                        $ligaDaten->mterm[$st - 1][$i][$n] = '';
                    }
                }
            }
            if ($_SESSION['lmouserok'] == 2 || $_SESSION['lmouserokerweitert'] == 1) {
                $ligaDaten->teama[$st - 1][$i] = isset($_POST['xteama' . $i]) ? $_POST['xteama' . $i] : '';
                $ligaDaten->teamb[$st - 1][$i] = isset($_POST['xteamb' . $i]) ? $_POST['xteamb' . $i] : '';
            }
            if ($ligaDaten->lmtype == 0) {
                $ligaDaten->goala[$st - 1][$i] = isset($_POST['xgoala' . $i]) ? trim($_POST['xgoala' . $i]) : '';
                if ($ligaDaten->goala[$st - 1][$i] == '' || $ligaDaten->goala[$st - 1][$i] == '_') {
                    $ligaDaten->goala[$st - 1][$i] = -1;
                } elseif (strtoupper($ligaDaten->goala[$st - 1][$i]) == 'X') {
                    $ligaDaten->goala[$st - 1][$i] = 0;
                    $ligaDaten->msieg[$st - 1][$i] = 1;
                } else {
                    $ligaDaten->goala[$st - 1][$i] = intval(trim($ligaDaten->goala[$st - 1][$i]));
                    if ($ligaDaten->goala[$st - 1][$i] == '') {
                        $ligaDaten->goala[$st - 1][$i] = '0';
                    }
                }
                $ligaDaten->goalb[$st - 1][$i] = isset($_POST['xgoalb' . $i]) ? trim($_POST['xgoalb' . $i]) : '';
                if ($ligaDaten->goalb[$st - 1][$i] == '' || $ligaDaten->goalb[$st - 1][$i] == '_') {
                    $ligaDaten->goalb[$st - 1][$i] = -1;
                } elseif (strtoupper($ligaDaten->goalb[$st - 1][$i]) == 'X') {
                    $ligaDaten->goalb[$st - 1][$i] = 0;
                    $ligaDaten->msieg[$st - 1][$i] = 2;
                } else {
                    $ligaDaten->goalb[$st - 1][$i] = intval(trim($ligaDaten->goalb[$st - 1][$i]));
                    if ($ligaDaten->goalb[$st - 1][$i] == '') {
                        $ligaDaten->goalb[$st - 1][$i] = '0';
                    }
                }
                $ligaDaten->msieg[$st - 1][$i] = $_POST['xmsieg' . $i];
                if ($ligaDaten->spez == 1) {
                    $ligaDaten->mspez[$st - 1][$i] = $_POST['xmspez' . $i];
                }
                $ligaDaten->mnote[$st - 1][$i] = trim($_POST['xmnote' . $i]);
                $ligaDaten->mberi[$st - 1][$i] = trim($_POST['xmberi' . $i]);
                if ($_SESSION['lmouserok'] == 2 && $ftest0 == 1) {
                    $ligaDaten->mtipp[$st - 1][$i] = trim($_POST['xmtipp' . $i]);
                }
                if (($st < $ligaDaten->anzst) && ($ligaDaten->favteam > 0) && ($ligaDaten->stat1 == $ligaDaten->favteam)) {
                    for ($y = 0; $y < $ligaDaten->anzsp; $y++) {
                        if ($ligaDaten->teama[$st][$y] == $ligaDaten->favteam) {
                            $ligaDaten->stat2 = $ligaDaten->teamb[$st][$y];
                        }
                        if ($ligaDaten->teamb[$st][$y] == $ligaDaten->favteam) {
                            $ligaDaten->stat2 = $ligaDaten->teama[$st][$y];
                        }
                    }
                }
            } else {
                for ($n = 0; $n < $ligaDaten->modus[$st - 1]; $n++) {
                    $ligaDaten->goala[$st - 1][$i][$n] = trim($_POST['xgoala' . $i . $n]);
                    if ($ligaDaten->goala[$st - 1][$i][$n] == '') {
                        $ligaDaten->goala[$st - 1][$i][$n] = -1;
                    } elseif ($ligaDaten->goala[$st - 1][$i][$n] == '_') {
                        $ligaDaten->goala[$st - 1][$i][$n] = -1;
                    } else {
                        $ligaDaten->goala[$st - 1][$i][$n] = intval(trim($ligaDaten->goala[$st - 1][$i][$n]));
                        if ($ligaDaten->goala[$st - 1][$i][$n] == '') {
                            $ligaDaten->goala[$st - 1][$i][$n] = '0';
                        }
                    }
                    $ligaDaten->goalb[$st - 1][$i][$n] = trim($_POST['xgoalb' . $i . $n]);
                    if ($ligaDaten->goalb[$st - 1][$i][$n] == '') {
                        $ligaDaten->goalb[$st - 1][$i][$n] = -1;
                    } elseif ($ligaDaten->goalb[$st - 1][$i][$n] == '_') {
                        $ligaDaten->goalb[$st - 1][$i][$n] = -1;
                    } else {
                        $ligaDaten->goalb[$st - 1][$i][$n] = intval(trim($ligaDaten->goalb[$st - 1][$i][$n]));
                        if ($ligaDaten->goalb[$st - 1][$i][$n] == '') {
                            $ligaDaten->goalb[$st - 1][$i][$n] = '0';
                        }
                    }
                    $ligaDaten->mspez[$st - 1][$i][$n] = $_POST['xmspez' . $i . $n];
                    $ligaDaten->mnote[$st - 1][$i][$n] = trim($_POST['xmnote' . $i . $n]);
                    $ligaDaten->mberi[$st - 1][$i][$n] = trim($_POST['xmberi' . $i . $n]);
                    if ($_SESSION['lmouserok'] == 2 && $ftest0 == 1) {
                        $ligaDaten->mtipp[$st - 1][$i][$n] = trim($_POST['xmtipp' . $i . $n]);
                    }
                }
                if (($st < $ligaDaten->anzst) && ($ligaDaten->favteam > 0) && ($ligaDaten->stat1 == $ligaDaten->favteam)) {
                    for ($y = 0; $y < $ligaDaten->anzsp; $y++) {
                        if ($ligaDaten->teama[$st][$y] == $ligaDaten->favteam) {
                            $ligaDaten->stat2 = $ligaDaten->teamb[$st][$y];
                        }
                        if ($ligaDaten->teamb[$st][$y] == $ligaDaten->favteam) {
                            $ligaDaten->stat2 = $ligaDaten->teama[$st][$y];
                        }
                    }
                }
            }
        }

        /*Spieltagsdatum (falls nicht angegeben) aus Spieldaten extrahieren*/
        function array_values_recursive($ary)
        {
            $lst = array();
            foreach(array_keys($ary) as $k) {
                $v = $ary[$k];
                if (is_scalar($v)) {
                    $lst[] = $v;
                } elseif (is_array($v)) {
                    $lst = array_merge( $lst, array_values_recursive($v));
                }
            }
            return $lst;
        }

        $lmo_spieltermine = array_filter(array_values_recursive($ligaDaten->mterm[$st - 1]), 'filterZero');
        if (!empty($lmo_spieltermine)) {
            if (empty($ligaDaten->datum1[$st - 1])) {
                $ligaDaten->datum1[$st - 1] = date('d.m.Y', min($lmo_spieltermine));
            }
            if (empty($ligaDaten->datum2[$st - 1])) {
                $ligaDaten->datum2[$st - 1] = date('d.m.Y', max($lmo_spieltermine));
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
        $stz = trim($_POST['xstx']);
        if ($stz != 0) {
            $ligaDaten->stx = $stz;
        } else {
            $ligaDaten->stx = $st;
        }
        $stz = $st;
        $st = $ligaDaten->stx;
        $ligaDaten->nticker = trim($_POST['xnticker']);
        $ligaDaten->nlines = explode('\n', $_POST['xnlines']);
        if (count($ligaDaten->nlines) > 0) {
            for ($z = count($ligaDaten->nlines) - 1; $z >= 0; $z--) {
                $y = array_pop($ligaDaten->nlines);
                if ($y != '') {
                    array_unshift($ligaDaten->nlines, $y);
                }
            }
        }
        require(PATH_TO_LMO . '/lmo-savefile.php');
        $st = $stz;
    }

    // Rückrunden-Hack
    if ($save == 990) require_once(PATH_TO_LMO . '/lmo-rueckrunde.php');

        if ($ligaDaten->lmtype != 0) {
        $teamt = array_pad(array('0'), 129, '0');
        if ($st > 1) {
            for ($i = 0; $i < ($st - 1); $i++) {
                if (!isset($ligaDaten->goalb[$i]) || !is_array($ligaDaten->goalb[$i])) {
                    continue;
                }
                $maxMatches = count($ligaDaten->goalb[$i]);
                for ($j = 0; $j < $maxMatches; $j++) {
                    if (!isset($ligaDaten->goalb[$i][$j]) || !isset($ligaDaten->goala[$i][$j]) || !isset($ligaDaten->teama[$i][$j]) || !isset($ligaDaten->teamb[$i][$j])) {
                        continue;
                    }
                    $m1 = $ligaDaten->goala[$i][$j];
                    $m2 = $ligaDaten->goalb[$i][$j];
                    $m = gewinn($i, $j, $ligaDaten->modus[$i], $m1, $m2);

                    if ($m == 1) {
                        $teamt[$ligaDaten->teamb[$i][$j]] = 1;
                    } elseif ($m == 2) {
                        $teamt[$ligaDaten->teama[$i][$j]] = 1;
                    }
                    if (($ligaDaten->klfin == 1) && ($i == $st - 2)) {
                        if ($m == 1) {
                            $teamt[$ligaDaten->teamb[$i][$j]] = 2;
                        } elseif ($m == 2) {
                            $teamt[$ligaDaten->teama[$i][$j]] = 2;
                        }
                    }
                }
            }
        }
    }
    $addr = $_SERVER['PHP_SELF'] . '?action=admin&amp;todo=edit&amp;file=' . $file . '&amp;st=';
    $addb = $_SERVER['PHP_SELF'] . '?action=admin&amp;todo=tabs&amp;file=' . $file . '&amp;st=';
    $breite = 18 - $ligaDaten->lmtype;
    if ($ligaDaten->spez == 1) {
        $breite = $breite + 1 + (-1) * (0 - $ligaDaten->lmtype);
    }

    include(PATH_TO_LMO . '/lmo-adminsubnavi.php'); ?>
      <table class="lmoMiddle" cellspacing="0" cellpadding="0" border="0">
        <tr>
          <td align="center"><h1><?php echo $ligaDaten->titel; ?></h1></td>
        </tr>
        <tr>
          <td align="center">
<?php
    include (PATH_TO_LMO . '/lmo-spieltagsmenu.php');
    if ($ligaDaten->lmtype == 0) { ?>
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
    if ($ligaDaten->datum1[$st - 1] != '') {
        $datum = explode('.', $ligaDaten->datum1[$st - 1]);
        $dum1 = $me[intval($datum[1])] . ' ' . $datum[2];
    } else {
        $dum1 = '';
    }
    if ($ligaDaten->datum2[$st - 1] != '') {
        $datum = explode('.', $ligaDaten->datum2[$st - 1]);
        $dum2 = $me[intval($datum[1])] . ' ' . $datum[2];
    } else {
        $dum2 = '';
    }
    if ($_SESSION['lmouserok'] == 2 || $_SESSION['lmouserokerweitert'] == 1) { ?>

                    <acronym title="<?php echo $text[105]; ?>"> <?php echo $text[3]; ?></acronym> <input class="lmo-formular-input" type="text" name="xdatum1" tabindex="01" size="10" maxlength="10" value="<?php echo $ligaDaten->datum1[$st - 1]; ?>" onChange="dolmoedit()"> <script type="text/javascript">document.write('<a href="#" onclick="opencal(\'xdatum1\',\'<?php echo $dum1; ?>\')" title="<?php echo $text[139]; ?>" onMouseOver="lmoimg(\'d1\',img5)" onMouseOut="lmoimg(\'d1\',img4)"><img src="<?php echo URL_TO_IMGDIR; ?>/lmo-admin4.gif" name="ximgd1" width="12" height="11" border="0"></a>');</script>
                    <acronym title="<?php echo $text[106]; ?>"> <?php echo $text[4]; ?></acronym> <input class="lmo-formular-input" type="text" name="xdatum2" tabindex="02" size="10" maxlength="10" value="<?php echo $ligaDaten->datum2[$st - 1]; ?>" onChange="dolmoedit()"> <script type="text/javascript">document.write('<a href="#" onclick="opencal(\'xdatum2\',\'<?php echo $dum2; ?>\')" title="<?php echo $text[139]; ?>" onMouseOver="lmoimg(\'d2\',img5)" onMouseOut="lmoimg(\'d2\',img4)"><img src="<?php echo URL_TO_IMGDIR; ?>/lmo-admin4.gif" name="ximgd2" width="12" height="11" border="0"></a>');</script>
<?php
    }?>
                  </th>
<?php
    if ($ligaDaten->goalfaktor > 0 && $ligaDaten->goalfaktor != 1) { ?>
                  <th style="text-align:center" class="nobr" colspan="<?php echo $breite - 13; ?>"><?php if ($ligaDaten->goalfaktor > 0 && $ligaDaten->goalfaktor != 1) {echo '(' . $text[553 + log10($ligaDaten->goalfaktor)] . ')';}?></th>
<?php
    } else { ?>
                  <th colspan="<?php echo $breite - 13; ?>">&nbsp;</th>
<?php
    }
    if ($ligaDaten->lmtype == 0) { ?>
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
    if ($ligaDaten->lmtype != 0) {
        $ligaDaten->anzsp = $ligaDaten->anzteams;
        for ($i = 0; $i < $st; $i++) {
            if ($ligaDaten->anzteams == 24) {
                switch ($i) {
                    case 0:
                    case 1:
                        $ligaDaten->anzsp = 16;
                    break;
                    case 2:
                        $ligaDaten->anzsp = 8 ;
                    break;
                    case 3:
                        $ligaDaten->anzsp = 4;
                    break;
                    case 4:
                        $ligaDaten->anzsp = 2;
                    break;
                    case 5:
                        $ligaDaten->anzsp = 1;
                    break;
                }
            }
            $ligaDaten->anzsp = $ligaDaten->anzsp / 2;
        }
        if (($ligaDaten->klfin == 1) && ($st == $ligaDaten->anzst)) {
            $ligaDaten->anzsp = $ligaDaten->anzsp + 1;
        }
    }
    for ($i = 0; $i < $ligaDaten->anzsp; $i++) {
        if ($ligaDaten->lmtype == 0) { ?>
                <tr>
<?php
            if (isset($ligaDaten->mterm[$st - 1][$i]) && filterZero($ligaDaten->mterm[$st - 1][$i])) {
                $dt = new DateTime();
                $dt->setTimestamp((int)$ligaDaten->mterm[$st - 1][$i]);
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
                for ($y = 0; $y <= $ligaDaten->anzteams; $y++) { ?>
                      <option value="<?php echo $y; ?>"<?php if ($y == $ligaDaten->teama[$st - 1][$i]) {echo ' selected';}?>><?php echo $ligaDaten->teams[$y]; ?></option>
<?php
                }?>
                    </select>
<?php
            } else {
                echo $ligaDaten->teams[$ligaDaten->teama[$st - 1][$i]];
            }?>
                  </td>
                  <td align="center" width="10">-</td>
                  <td class="nobr">
<?php
            if ($_SESSION['lmouserok'] == 2 || $_SESSION['lmouserokerweitert'] == 1) { ?>
                    <select class="lmo-formular-input" name="xteamb<?php echo $i; ?>" onChange="dolmoedit()" title="<?php echo $text[108]; ?>" tabindex="<?php echo $i; ?>06">
<?php
                for ($y = 0; $y <= $ligaDaten->anzteams; $y++) { ?>
                      <option value="<?php echo $y; ?>"<?php if ($y == $ligaDaten->teamb[$st - 1][$i]) {echo ' selected';}?>><?php echo $ligaDaten->teams[$y]; ?></option>
<?php
                }?>
                    </select>
<?php
            } else {
                echo $ligaDaten->teams[$ligaDaten->teamb[$st - 1][$i]];
            }
            if ($ligaDaten->goala[$st - 1][$i] == '-1') {
                $ligaDaten->goala[$st - 1][$i] = '_';
            }
            if ($ligaDaten->goalb[$st - 1][$i] == '-1') {
                $ligaDaten->goalb[$st - 1][$i] = '_';
            }?>
                  </td>
                  <td width="2">&nbsp;</td>
                  <td class="lmoBackMarkierung" align="right"><input title="<?php echo $text[109]; ?>" class="lmo-formular-input" type="text" name="xgoala<?php echo $i; ?>" tabindex="<?php echo $i; ?>07" size="2" maxlength="4" value="<?php echo $ligaDaten->goala[$st - 1][$i]; ?>" onChange="lmotorgte('a','<?php echo $i; ?>')" onKeyDown="lmotorclk('a','<?php echo $i; ?>',event.keyCode)"></td>
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
                  <td class="lmoBackMarkierung" align="right"><input title="<?php echo $text[110]; ?>" class="lmo-formular-input" type="text" name="xgoalb<?php echo $i; ?>" tabindex="<?php echo $i; ?>08" size="2" maxlength="4" value="<?php echo $ligaDaten->goalb[$st - 1][$i]; ?>" onChange="lmotorgte('b','<?php echo $i; ?>')" onKeyDown="lmotorclk('b','<?php echo $i; ?>',event.keyCode)"></td>
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
            if ($ligaDaten->spez == 1) { ?>
                  <td width="2">&nbsp;</td>
                  <td>
                    <select class="lmo-formular-input" name="xmspez<?php echo $i; ?>" onChange="dolmoedit()" tabindex="<?php echo $i; ?>09" >
                      <option<?php if ($ligaDaten->mspez[$st - 1][$i] == '&nbsp;') {echo ' selected';}?>>_</option>
                      <option<?php if ($ligaDaten->mspez[$st - 1][$i] == $text[0]) {echo ' selected';}?>><?php echo $text[0]; ?></option>
                      <option<?php if ($ligaDaten->mspez[$st - 1][$i] == $text[1]) {echo ' selected';}?>><?php echo $text[1]; ?></option>
                    </select>
                  </td>
<?php
            }?>
                  <td width="2">&nbsp;</td>
                  <td align="center">
                    <select id="gT<?php echo $i; ?>" class="lmo-formular-input" name="xmsieg<?php echo $i; ?>" onChange="dolmoedit()" tabindex="<?php echo $i; ?>10" >
                      <option value="0"<?php if ($ligaDaten->msieg[$st - 1][$i] == 0) {echo ' selected';}?>>_</option>
                      <option value="1"<?php if ($ligaDaten->msieg[$st - 1][$i] == 1) {echo ' selected';}?>><?php echo $text[214]; ?></option>
                      <option value="2"<?php if ($ligaDaten->msieg[$st - 1][$i] == 2) {echo ' selected';}?>><?php echo $text[215]; ?></option>
                      <option value="3"<?php if ($ligaDaten->msieg[$st - 1][$i] == 3) {echo ' selected';}?>><?php echo $text[216]; ?></option>
                    </select>
<?php
            if ($ligaDaten->msieg[$st - 1][$i] == 0) { ?>
                    <script type="text/javascript">document.getElementById('gT<?php echo $i; ?>').style.display='none';document.write('<a href="#" onClick="this.style.display=\'none\';document.getElementById(\'gT<?php echo $i; ?>\').style.display=\'inline\';return false;">+</a>');</script>
<?php
            }?>
                  </td>
                  <td align="center">
                    <input id="n<?php echo $i; ?>" class="lmo-formular-input" type="text" name="xmnote<?php echo $i; ?>" tabindex="<?php echo $i; ?>11" size="16" maxlength="255" value="<?php echo htmlentities($ligaDaten->mnote[$st - 1][$i]); ?>" onChange="dolmoedit()">
<?php
            if (trim($ligaDaten->mnote[$st - 1][$i]) == '') { ?>
                    <script type="text/javascript">document.getElementById('n<?php echo $i; ?>').style.display='none';document.write('<a href="#" onClick="this.style.display=\'none\';document.getElementById(\'n<?php echo $i; ?>\').style.display=\'inline\';return false;">+</a>');</script>
<?php
            }?>
                  </td>
                  <td align="center"><input id="s<?php echo $i; ?>" class="lmo-formular-input" type="text" name="xmberi<?php echo $i; ?>" tabindex="<?php echo $i; ?>12" size="16" maxlength="255" value="<?php echo htmlentities($ligaDaten->mberi[$st - 1][$i]); ?>" onChange="dolmoedit()">
<?php
            if (trim($ligaDaten->mberi[$st - 1][$i]) == '') { ?>
                    <script type="text/javascript">document.getElementById('s<?php echo $i; ?>').style.display='none';document.write('<a href="#" onClick="this.style.display=\'none\';document.getElementById(\'s<?php echo $i; ?>\').style.display=\'inline\';return false;">+</a>');</script>
<?php
            }?>
                  </td>
<?php
            /*Tippspiel-Addon*/
            if ($_SESSION['lmouserok'] == 2 && $ftest0 == 1) { ?>
                  <td>
                    <select class="lmo-formular-input" name="xmtipp<?php echo $i; ?>" onChange="dolmoedit()" tabindex="<?php echo $i; ?>13" >
                      <option value="0"<?php if ($ligaDaten->mtipp[$st - 1][$i] < 1) {echo ' selected';}?>>_</option>
                      <option value="1"<?php if ($ligaDaten->mtipp[$st - 1][$i] == 1) {echo ' selected';}?>><?php echo $text['tipp'][199]; ?></option>
                    </select>
                  </td>
<?php
            }?>
                </tr>
<?php
        } else {
            /*Pokalmodus*/
            for ($n = 0; $n < $ligaDaten->modus[$st - 1]; $n++) {
                if (($ligaDaten->klfin == 1) && ($st == $ligaDaten->anzst)) { ?>
                <tr>
                  <td class="nobr" colspan=<?php echo $breite; ?>><?php if ($i == 1) {echo '&nbsp;<br>';} echo $text[419 + $i]; ?></td>
                </tr>
<?php
                }?>
                <tr>
<?php
                if (isset($ligaDaten->mterm[$st - 1][$i][$n]) && filterZero($ligaDaten->mterm[$st - 1][$i][$n])) {
                  $dt = new DateTime();
                  $dt->setTimestamp((int)$ligaDaten->mterm[$st - 1][$i][$n]);
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

                        if (($ligaDaten->klfin == 1) && ($st == $ligaDaten->anzst) && ($i == 1)) {
                            echo '<option value="0"';
                            if ($ligaDaten->teama[$st - 1][$i] == 0) {
                                echo ' selected';
                            }
                            echo '>' . $ligaDaten->teams[0] . '</option>';
                            for ($y = 1; $y <= $ligaDaten->anzteams; $y++) {
                                if (($ligaDaten->playdown == 0 && $teamt[$y] == 2) || $ligaDaten->playdown == 1) {
                                    echo '<option value="' . $y . '"';
                                    if ($y == $ligaDaten->teama[$st - 1][$i]) {
                                        echo ' selected';
                                    }
                                    echo '>' . $ligaDaten->teams[$y] . '</option>';
                                }
                            }
                        } else {
                            for ($y = 0; $y <= $ligaDaten->anzteams; $y++) {
                                if (($ligaDaten->playdown == 0 && $teamt[$y] == 0) || $ligaDaten->playdown == 1) {
                                    echo '<option value="' . $y . '"';
                                    if ($y == $ligaDaten->teama[$st - 1][$i]) {
                                        echo ' selected';
                                    }
                                    echo '>' . $ligaDaten->teams[$y] . '</option>';
                                }
                            }
                        }
?>
                    </select>
<?php
                    } else {
                        echo $ligaDaten->teams[$ligaDaten->teama[$st - 1][$i]];
                    }
?>
                  </td>
                  <td align="center" width="10">-</td>
                  <td class="nobr">
<?php
                    if ($_SESSION['lmouserok'] == 2 || $_SESSION['lmouserokerweitert'] == 1) { ?>
                    <select class="lmo-formular-input" name="xteamb<?php echo $i; ?>" onChange="dolmoedit()" title="<?php echo $text[108]; ?>" tabindex="<?php echo $i . $n; ?>06">
<?php
                        if (($ligaDaten->klfin == 1) && ($st == $ligaDaten->anzst) && ($i == 1)) {
                            echo '<option value="0"';
                            if ($ligaDaten->teamb[$st - 1][$i] == 0) {
                                echo ' selected';
                            }
                            echo '>' . $ligaDaten->teams[0] . '</option>';
                            for ($y = 1; $y <= $ligaDaten->anzteams; $y++) {
                                if (($ligaDaten->playdown == 0 && $teamt[$y] == 2) || $ligaDaten->playdown == 1) {
                                    echo '<option value="' . $y . '"';
                                    if ($y == $ligaDaten->teamb[$st - 1][$i]) {
                                        echo ' selected';
                                    }
                                    echo '>' . $ligaDaten->teams[$y] . '</option>';
                                }
                            }
                        } else {
                            for ($y = 0; $y <= $ligaDaten->anzteams; $y++) {
                                if (($ligaDaten->playdown == 0 && $teamt[$y] == 0) || $ligaDaten->playdown == 1) {
                                    echo '<option value="' . $y . '"';
                                    if ($y == $ligaDaten->teamb[$st - 1][$i]) {
                                        echo ' selected';
                                    }
                                    echo '>' . $ligaDaten->teams[$y] . '</option>';
                                }
                            }
                        }
?>
                    </select>
<?php
                    } else {
                        echo $ligaDaten->teams[$ligaDaten->teamb[$st - 1][$i]];
                    }
?>
                  </td>
<?php
                } else {
                    if ($ligaDaten->playoffmode == 1 || $ligaDaten->playoffmode == 2) { // Modus 2-2-1 or 2-2-1-1-1
                        if ($n == 1 || $n == 4 || $n == 6) {
?>
                  <td class="nobr" align="right"><?php echo $ligaDaten->teams[$ligaDaten->teama[$st - 1][$i]]; ?></td>
                  <td align="center" width="10">-</td>
                  <td class="nobr"><?php echo $ligaDaten->teams[$ligaDaten->teamb[$st - 1][$i]]; ?></td>
<?php
                        } else {
?>
                  <td class="nobr" align="right"><?php echo $ligaDaten->teams[$ligaDaten->teamb[$st - 1][$i]]; ?></td>
                  <td align="center" width="10">-</td>
                  <td class="nobr"><?php echo $ligaDaten->teams[$ligaDaten->teama[$st - 1][$i]]; ?></td>
<?php
                        }
                    }
                    if ($ligaDaten->playoffmode == 3) { // Modus 2-3-2
                        if ($n == 1 || $n == 5 || $n == 6) {
?>
                  <td class="nobr" align="right"><?php echo $ligaDaten->teams[$ligaDaten->teama[$st - 1][$i]]; ?></td>
                  <td align="center" width="10">-</td>
                  <td class="nobr"><?php echo $ligaDaten->teams[$ligaDaten->teamb[$st - 1][$i]]; ?></td>
<?php
                        } else {
?>
                  <td class="nobr" align="right"><?php echo $ligaDaten->teams[$ligaDaten->teamb[$st - 1][$i]]; ?></td>
                  <td align="center" width="10">-</td>
                  <td class="nobr"><?php echo $ligaDaten->teams[$ligaDaten->teama[$st - 1][$i]]; ?></td>
<?php
                        }
                    }
                    if ($ligaDaten->playoffmode < 1) { // now Modus = everything else ($playoffmode == 0; and KO-League without $playoffmode Option like old Champions-League Finalrounds)
                        if ($n % 2 == 0) {
?>
                  <td class="nobr" align="right"><?php echo $ligaDaten->teams[$ligaDaten->teama[$st - 1][$i]]; ?></td>
                  <td align="center" width="10">-</td>
                  <td class="nobr"><?php echo $ligaDaten->teams[$ligaDaten->teamb[$st - 1][$i]]; ?></td>
<?php
                        } else {
?>
                  <td class="nobr" align="right"><?php echo $ligaDaten->teams[$ligaDaten->teamb[$st - 1][$i]]; ?></td>
                  <td align="center" width="10">-</td>
                  <td class="nobr"><?php echo $ligaDaten->teams[$ligaDaten->teama[$st - 1][$i]]; ?></td>
<?php
                        }
                    }
                }
                if ($ligaDaten->goala[$st - 1][$i][$n] == '-1') {
                    $ligaDaten->goala[$st - 1][$i][$n] = '_';
                }
                if ($ligaDaten->goalb[$st - 1][$i][$n] == '-1') {
                    $ligaDaten->goalb[$st - 1][$i][$n] = '_';
                }
                if ($ligaDaten->playoffmode == 1 || $ligaDaten->playoffmode == 2) { // Modus 2-2-1 or 2-2-1-1-1
                    if ($n == 0 || $n == 1 || $n == 4 || $n == 6) {
?>
                  <td width="2">&nbsp;</td>
                  <td class="lmoBackMarkierung" align="right"><input title="<?php echo $text[109]; ?>" class="lmo-formular-input" type="text" name="xgoala<?php echo $i . $n; ?>" tabindex="<?php echo $i . $n; ?>07" size="4" maxlength="4" value="<?php echo $ligaDaten->goala[$st - 1][$i][$n]; ?>" onChange="lmotorgte('a','<?php echo $i . $n; ?>')" onKeyDown="lmotorclk('a','<?php echo $i . $n; ?>',event.keyCode)"></td>
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
                  <td class="lmoBackMarkierung" align="right"><input title="<?php echo $text[110]; ?>" class="lmo-formular-input" type="text" name="xgoalb<?php echo $i . $n; ?>" tabindex="<?php echo $i . $n; ?>08" size="4" maxlength="4" value="<?php echo $ligaDaten->goalb[$st - 1][$i][$n]; ?>" onChange="lmotorgte('b','<?php echo $i . $n; ?>')" onKeyDown="lmotorclk('b','<?php echo $i . $n; ?>',event.keyCode)"></td>
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
                  <td class="lmoBackMarkierung" align="right"><input title="<?php echo $text[110]; ?>" class="lmo-formular-input" type="text" name="xgoalb<?php echo $i . $n; ?>" tabindex="<?php echo $i . $n; ?>07" size="4" maxlength="4" value="<?php echo $ligaDaten->goalb[$st - 1][$i][$n]; ?>" onChange="lmotorgte('b','<?php echo $i . $n; ?>')" onKeyDown="lmotorclk('b','<?php echo $i . $n; ?>',event.keyCode)"></td>
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
                  <td class="lmoBackMarkierung" align="right"><input title="<?php echo $text[109]; ?>" class="lmo-formular-input" type="text" name="xgoala<?php echo $i . $n; ?>" tabindex="<?php echo $i . $n; ?>08" size="4" maxlength="4" value="<?php echo $ligaDaten->goala[$st - 1][$i][$n]; ?>" onChange="lmotorgte('a','<?php echo $i . $n; ?>')" onKeyDown="lmotorclk('a','<?php echo $i . $n; ?>',event.keyCode)"></td>
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
                if ($ligaDaten->playoffmode == 3) { // Modus 2-3-2
                    if ($n == 0 || $n == 1 || $n == 5 || $n == 6) {
?>
                  <td width="2">&nbsp;</td>
                  <td class="lmoBackMarkierung" align="right"><input title="<?php echo $text[109]; ?>" class="lmo-formular-input" type="text" name="xgoala<?php echo $i . $n; ?>" tabindex="<?php echo $i . $n; ?>07" size="4" maxlength="4" value="<?php echo $ligaDaten->goala[$st - 1][$i][$n]; ?>" onChange="lmotorgte('a','<?php echo $i . $n; ?>')" onKeyDown="lmotorclk('a','<?php echo $i . $n; ?>',event.keyCode)"></td>
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
                  <td class="lmoBackMarkierung" align="right"><input title="<?php echo $text[110]; ?>" class="lmo-formular-input" type="text" name="xgoalb<?php echo $i . $n; ?>" tabindex="<?php echo $i . $n; ?>08" size="4" maxlength="4" value="<?php echo $ligaDaten->goalb[$st - 1][$i][$n]; ?>" onChange="lmotorgte('b','<?php echo $i . $n; ?>')" onKeyDown="lmotorclk('b','<?php echo $i . $n; ?>',event.keyCode)"></td>
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
                  <td class="lmoBackMarkierung" align="right"><input title="<?php echo $text[110]; ?>" class="lmo-formular-input" type="text" name="xgoalb<?php echo $i . $n; ?>" tabindex="<?php echo $i . $n; ?>07" size="4" maxlength="4" value="<?php echo $ligaDaten->goalb[$st - 1][$i][$n]; ?>" onChange="lmotorgte('b','<?php echo $i . $n; ?>')" onKeyDown="lmotorclk('b','<?php echo $i . $n; ?>',event.keyCode)"></td>
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
                  <td class="lmoBackMarkierung" align="right"><input title="<?php echo $text[109]; ?>" class="lmo-formular-input" type="text" name="xgoala<?php echo $i . $n; ?>" tabindex="<?php echo $i . $n; ?>08" size="4" maxlength="4" value="<?php echo $ligaDaten->goala[$st - 1][$i][$n]; ?>" onChange="lmotorgte('a','<?php echo $i . $n; ?>')" onKeyDown="lmotorclk('a','<?php echo $i . $n; ?>',event.keyCode)"></td>
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
                if ($ligaDaten->playoffmode < 1) { // now Modus = everything else ($playoffmode == 0; and KO-League without $playoffmode Option like old Champions-League Finalrounds)
                    if ($n % 2 == 0) {
?>
                  <td width="2">&nbsp;</td>
                  <td class="lmoBackMarkierung" align="right"><input title="<?php echo $text[109]; ?>" class="lmo-formular-input" type="text" name="xgoala<?php echo $i . $n; ?>" tabindex="<?php echo $i . $n; ?>07" size="4" maxlength="4" value="<?php echo $ligaDaten->goala[$st - 1][$i][$n]; ?>" onChange="lmotorgte('a','<?php echo $i . $n; ?>')" onKeyDown="lmotorclk('a','<?php echo $i . $n; ?>',event.keyCode)"></td>
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
                  <td class="lmoBackMarkierung" align="right"><input title="<?php echo $text[110]; ?>" class="lmo-formular-input" type="text" name="xgoalb<?php echo $i . $n; ?>" tabindex="<?php echo $i . $n; ?>08" size="4" maxlength="4" value="<?php echo $ligaDaten->goalb[$st - 1][$i][$n]; ?>" onChange="lmotorgte('b','<?php echo $i . $n; ?>')" onKeyDown="lmotorclk('b','<?php echo $i . $n; ?>',event.keyCode)"></td>
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
                  <td class="lmoBackMarkierung" align="right"><input title="<?php echo $text[110]; ?>" class="lmo-formular-input" type="text" name="xgoalb<?php echo $i . $n; ?>" tabindex="<?php echo $i . $n; ?>07" size="4" maxlength="4" value="<?php echo $ligaDaten->goalb[$st - 1][$i][$n]; ?>" onChange="lmotorgte('b','<?php echo $i . $n; ?>')" onKeyDown="lmotorclk('b','<?php echo $i . $n; ?>',event.keyCode)"></td>
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
                  <td class="lmoBackMarkierung" align="right"><input title="<?php echo $text[109]; ?>" class="lmo-formular-input" type="text" name="xgoala<?php echo $i . $n; ?>" tabindex="<?php echo $i . $n; ?>08" size="4" maxlength="4" value="<?php echo $ligaDaten->goala[$st - 1][$i][$n]; ?>" onChange="lmotorgte('a','<?php echo $i . $n; ?>')" onKeyDown="lmotorclk('a','<?php echo $i . $n; ?>',event.keyCode)"></td>
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
                      <option<?php if ($ligaDaten->mspez[$st - 1][$i][$n] == "&nbsp;") {echo ' selected';}?>>_</option>
                      <option<?php if ($ligaDaten->mspez[$st - 1][$i][$n] == $text[0]) {echo ' selected';}?>><?php echo $text[0]; ?></option>
                      <option<?php if ($ligaDaten->mspez[$st - 1][$i][$n] == $text[1]) {echo ' selected';}?>><?php echo $text[1]; ?></option>
                    </select>
                  </td>
                  <td width="2">&nbsp;</td>
                  <td><input class="lmo-formular-input" type="text" name="xmnote<?php echo $i . $n; ?>" tabindex="<?php echo $i . $n; ?>10" size="16" value="<?php echo htmlentities($ligaDaten->mnote[$st - 1][$i][$n]); ?>" onChange="dolmoedit()"></td>
                  <td><input class="lmo-formular-input" type="text" name="xmberi<?php echo $i . $n; ?>" tabindex="<?php echo $i . $n; ?>11" size="16" value="<?php echo htmlentities($ligaDaten->mberi[$st - 1][$i][$n]); ?>" onChange="dolmoedit()"></td>
<?php
                /**Tippspiuel-Addon*/
                if ($_SESSION['lmouserok'] == 2 && $ftest0 == 1) { ?>
                  <td>
                    <select class="lmo-formular-input" name="xmtipp<?php echo $i . $n; ?>" onChange="dolmoedit()" title="<?php echo $text['tipp'][57]; ?>" tabindex="<?php echo $i . $n; ?>12">
                      <option value="0"<?php if ($ligaDaten->mtipp[$st - 1][$i][$n] < 1) {echo ' selected';}?>>_</option>
                      <option value="1"<?php if ($ligaDaten->mtipp[$st - 1][$i][$n] == 1) {echo ' selected';}?>><?php echo $text['tipp'][199]; ?></option>
                    </select>
                  </td>
<?php
                }?>
                </tr>
<?php
            }
            if (($ligaDaten->modus[$st - 1] > 1) && ($i < $ligaDaten->anzsp - 1)) { ?>
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
    for ($y = 0; $y <= $ligaDaten->anzst; $y++) {
        echo '<option value="' . $y . '"';
        if ($save == 1) {
            if ($y == 0) {
                echo '>' . $text[403] . '</option>';
            } else {
                if ($y == $ligaDaten->stx) {
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
                      <option value="1"<?php if ($ligaDaten->nticker == 1) {echo ' selected';}?>><?php echo $text[181]; ?></option>
                      <option value="0"<?php if ($ligaDaten->nticker == 0) {echo ' selected';}?>><?php echo $text[182]; ?></option>
                    </select>
                  </td>
                </tr>
                <tr>
                  <td colspan="<?php echo $breite; ?>" align="center">
                    <acronym title="<?php echo $text[210]; ?>"><?php echo $text[999]; ?>: </acronym><textarea tabindex="<?php echo $i; ?>015" class="lmo-formular-input" name="xnlines" cols="50" rows="4" onChange="dolmoedit()"><?php if (count($ligaDaten->nlines) > 0) {foreach($ligaDaten->nlines as $y) {echo $y . "\n";}} ?></textarea>
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
