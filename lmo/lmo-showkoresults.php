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
 * @var int|string $st gewaehlter Spieltag
 *
 * Werden auch in dieser Datei gesetzt, aber nicht auf jedem Weg (koennen von aussen kommen):
 * @var mixed $m
 */

if ($file != '') {
    $addp = $_SERVER['PHP_SELF'] . '?action=program&amp;file=' . $file . '&amp;selteam=';
    $addr = $_SERVER['PHP_SELF'] . '?action=results&amp;file=' . $file . '&amp;st=';
    $breite = 10;
    if ($ligaDaten->spez == 1) {
        $breite = $breite + 2;
    }
    if ($ligaDaten->datm == 1) {
    $breite = $breite + 1;
    }
    $ligaDaten->anzsp = $ligaDaten->anzteams;
    for ($i = 0; $i < $st; $i++) {
        $ligaDaten->anzsp = $ligaDaten->anzsp / 2;
    }
    if (($ligaDaten->klfin == 1) && ($st == $ligaDaten->anzst)) {
        $ligaDaten->anzsp = $ligaDaten->anzsp + 1;
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
    if ($st == $ligaDaten->anzst) {
        $j = $text[374];
    } elseif ($st == $ligaDaten->anzst - 1) {
        $j = $text[373];
    } elseif ($st == $ligaDaten->anzst - 2) {
        $j = $text[372];
    } elseif ($st == $ligaDaten->anzst - 3) {
        $j = $text[371];
    } else {
        $j = $st . '. ' . $text[370];
    }
?>
          <th colspan="<?php echo $breite; ?>" align="left"><?php echo $j;
    if ($ligaDaten->dats == 1) {
        if ($ligaDaten->datum1[$st - 1] != '') {
            echo ' ' . $text[3] . ' ' . $ligaDaten->datum1[$st - 1];
        }
        if ($ligaDaten->datum2[$st - 1] != '') {
            echo ' ' . $text[4] . ' ' . $ligaDaten->datum2[$st - 1];
        }
    }?></th>
        </tr>
<?php
    $datsort = $ligaDaten->mterm[$st - 1];
    asort($datsort);
    reset($datsort);
    foreach($datsort as $key => $val) {
        $i = $key;
        if (($ligaDaten->teama[$st - 1][$i] > 0) && ($ligaDaten->teamb[$st - 1][$i] > 0)) {
            for ($n = 0; $n < $ligaDaten->modus[$st - 1]; $n++) {
                if (($ligaDaten->klfin == 1) && ($st == $ligaDaten->anzst)) { ?>
        <tr>
          <th class="nobr" colspan="<?php echo $breite; ?>"><?php if ($i == 1) {echo '&nbsp;<br>';} echo $text[419 + $i]; ?></th>
        </tr><?php
                }?>
        <tr>
<?php
                if ($ligaDaten->datm == 1) {
                    if(is_numeric($ligaDaten->mterm[$st - 1][$i][$n])) {
                        $dt = new DateTime();
                        $dt->setTimeStamp((int)$ligaDaten->mterm[$st - 1][$i][$n]);
                        $dum1 = $dt->format($ligaDaten->datf);
                    } else {
                        $dum1 = '';
                    }?>
          <td class="nobr"><?php echo $dum1; ?></td>
<?php
                }
?>
          <td class="nobr" width="2">&nbsp;</td>
<?php
                if ($ligaDaten->playoffmode == 1 || $ligaDaten->playoffmode == 2) { // Modus 2-2-1 or 2-2-1-1-1
                    if ($n == 0 || $n == 1 || $n == 4 || $n == 6) {
                        $m1 = array($ligaDaten->goala[$st - 1][$i][0], $ligaDaten->goala[$st - 1][$i][1], $ligaDaten->goala[$st - 1][$i][2], $ligaDaten->goala[$st - 1][$i][3], $ligaDaten->goala[$st - 1][$i][4], $ligaDaten->goala[$st - 1][$i][5], $ligaDaten->goala[$st - 1][$i][6]);
                        $m2 = array($ligaDaten->goalb[$st - 1][$i][0], $ligaDaten->goalb[$st - 1][$i][1], $ligaDaten->goalb[$st - 1][$i][2], $ligaDaten->goalb[$st - 1][$i][3], $ligaDaten->goalb[$st - 1][$i][4], $ligaDaten->goalb[$st - 1][$i][5], $ligaDaten->goalb[$st - 1][$i][6]);
                        $m = gewinn($st - 1, $i, $ligaDaten->modus[$st - 1], $m1, $m2);
                        if ($m == 1) {
                            echo '          <td class="lmoTurnierSieger nobr" align="right">';
                        } /*elseif ($m == 2) {
                            echo '          <td class="lmoTurnierVerlierer nobr" align="right">'; // Verlierer nicht rot einfärben
                        }*/ else {
                            echo '          <td class="nobr" align="right">';
                        }
                        if ($ligaDaten->plan == 1) {
                            echo '<a href="' . $addp . $ligaDaten->teama[$st - 1][$i] . '" title="' . $text[269] . '">';
                        }
                        if (($ligaDaten->favteam > 0) && ($ligaDaten->favteam == $ligaDaten->teama[$st - 1][$i])) {
                            echo '<strong>';
                        }
                        echo $ligaDaten->teams[$ligaDaten->teama[$st - 1][$i]];
                        if (($ligaDaten->favteam > 0) && ($ligaDaten->favteam == $ligaDaten->teama[$st - 1][$i])) {
                            echo '</strong>';
                        }
                        if ($ligaDaten->plan == 1) {
                            echo '</a>';
                        }
                        echo '&nbsp;' . HTML_smallTeamIcon($file, $ligaDaten->teams[$ligaDaten->teama[$st - 1][$i]] , ' alt=""') . '&nbsp;'; ?></td>
          <td class="nobr" align="center" width="10">-</td>
<?php
                        if ($m == 2) {
                            echo '          <td class="lmoTurnierSieger nobr" align="left">';
                        } /*elseif ($m == 1) {
                            echo '          <td class="lmoTurnierVerlierer nobr" align="left">'; // Verlierer nicht rot einfärben
                        }*/ else {
                            echo '          <td class="nobr" align="left">';
                        }
                        echo '&nbsp;' . HTML_smallTeamIcon($file, $ligaDaten->teams[$ligaDaten->teamb[$st - 1][$i]], ' alt=""') . '&nbsp;';
                        if ($ligaDaten->plan == 1) {
                            echo '<a href="' . $addp . $ligaDaten->teamb[$st - 1][$i] . '" title="' . $text[269] . '">';
                        }
                        if (($ligaDaten->favteam > 0) && ($ligaDaten->favteam == $ligaDaten->teamb[$st - 1][$i])) {
                            echo '<strong>';
                        }
                        echo $ligaDaten->teams[$ligaDaten->teamb[$st - 1][$i]];
                        if (($ligaDaten->favteam > 0) && ($ligaDaten->favteam == $ligaDaten->teamb[$st - 1][$i])) {
                            echo '</strong>';
                        }
                        if ($ligaDaten->plan == 1) {
                            echo '</a>';
                        }?></td>
          <td class="nobr" width="2">&nbsp;</td>
          <td class="nobr" align="right"><?php echo applyFactor($ligaDaten->goala[$st - 1][$i][$n], $ligaDaten->goalfaktor); ?></td>
          <td class="nobr" align="center" width="8">:</td>
          <td class="nobr" align="left"><?php echo applyFactor($ligaDaten->goalb[$st - 1][$i][$n], $ligaDaten->goalfaktor); ?></td>
<?php
                    } else {
                        if ($m == 2) {
                            echo '          <td class="lmoTurnierSieger nobr" align="right">';
                        } /*elseif ($m == 1) {
                            echo '          <td class="lmoTurnierVerlierer nobr" align="right">'; // Verlierer nicht rot einfärben
                        }*/ else {
                            echo '          <td class="nobr" align="right">';
                        }
                        if ($ligaDaten->plan == 1) {
                            echo '<a href="' . $addp . $ligaDaten->teamb[$st - 1][$i] . '" title="' . $text[269] . '">';
                        }
                        if (($ligaDaten->favteam > 0) && ($ligaDaten->favteam == $ligaDaten->teamb[$st - 1][$i])) {
                            echo '<strong>';
                        }
                        echo $ligaDaten->teams[$ligaDaten->teamb[$st - 1][$i]];
                        if (($ligaDaten->favteam > 0) && ($ligaDaten->favteam == $ligaDaten->teamb[$st - 1][$i])) {
                            echo '</strong>';
                        }
                        if ($ligaDaten->plan == 1) {
                            echo '</a>';
                        }
                        echo '&nbsp;' . HTML_smallTeamIcon($file, $ligaDaten->teams[$ligaDaten->teamb[$st - 1][$i]], ' alt=""') . '&nbsp;'; ?></td>

          <td class="nobr" align="center" width="10">-</td>
<?php
                        if ($m == 1) {
                            echo '          <td class="lmoTurnierSieger nobr" align="left">';
                        } /*elseif ($m == 2) {
                            echo '          <td class="lmoTurnierVerlierer nobr" align="left">'; // Verlierer nicht rot einfärben
                        }*/ else {
                            echo '          <td class="nobr" align="left">';
                        }
                        echo '&nbsp;' . HTML_smallTeamIcon($file, $ligaDaten->teams[$ligaDaten->teama[$st - 1][$i]], ' alt=""') . '&nbsp;';
                        if ($ligaDaten->plan == 1) {
                            echo '<a href="' . $addp . $ligaDaten->teama[$st - 1][$i] . '" title="' . $text[269] . '">';
                        }
                        if (($ligaDaten->favteam > 0) && ($ligaDaten->favteam == $ligaDaten->teama[$st - 1][$i])) {
                            echo '<strong>';
                        }
                        echo $ligaDaten->teams[$ligaDaten->teama[$st - 1][$i]];
                        if (($ligaDaten->favteam > 0) && ($ligaDaten->favteam == $ligaDaten->teama[$st - 1][$i])) {
                            echo '</strong>';
                        }
                        if ($ligaDaten->plan == 1) {
                            echo '</a>';
                        }?></td>
          <td class="nobr" width="2">&nbsp;</td>
          <td class="nobr" align="right"><?php echo applyFactor($ligaDaten->goalb[$st - 1][$i][$n], $ligaDaten->goalfaktor); ?></td>
          <td class="nobr" align="center" width="8">:</td>
          <td class="nobr" align="left"><?php echo applyFactor($ligaDaten->goala[$st - 1][$i][$n], $ligaDaten->goalfaktor); ?></td>
<?php
                    }
                }
                if ($ligaDaten->playoffmode == 3) { // Modus 2-3-2
                    if ($n == 0 || $n == 1 || $n == 5 || $n == 6) {
                        $m1 = array($ligaDaten->goala[$st - 1][$i][0], $ligaDaten->goala[$st - 1][$i][1], $ligaDaten->goala[$st - 1][$i][2], $ligaDaten->goala[$st - 1][$i][3], $ligaDaten->goala[$st - 1][$i][4], $ligaDaten->goala[$st - 1][$i][5], $ligaDaten->goala[$st - 1][$i][6]);
                        $m2 = array($ligaDaten->goalb[$st - 1][$i][0], $ligaDaten->goalb[$st - 1][$i][1], $ligaDaten->goalb[$st - 1][$i][2], $ligaDaten->goalb[$st - 1][$i][3], $ligaDaten->goalb[$st - 1][$i][4], $ligaDaten->goalb[$st - 1][$i][5], $ligaDaten->goalb[$st - 1][$i][6]);
                        $m = gewinn($st - 1, $i, $ligaDaten->modus[$st - 1], $m1, $m2);
                        if ($m == 1) {
                            echo '          <td class="lmoTurnierSieger nobr" align="right">';
                        } /*elseif ($m == 2) {
                            echo '          <td class="lmoTurnierVerlierer nobr" align="right">'; // Verlierer nicht rot einfärben
                        }*/ else {
                            echo '          <td class="nobr" align="right">';
                        }
                        if ($ligaDaten->plan == 1) {
                            echo '<a href="' . $addp . $ligaDaten->teama[$st - 1][$i] . '" title="' . $text[269] . '">';
                        }
                        if (($ligaDaten->favteam > 0) && ($ligaDaten->favteam == $ligaDaten->teama[$st - 1][$i])) {
                            echo '<strong>';
                        }
                        echo $ligaDaten->teams[$ligaDaten->teama[$st - 1][$i]];
                        if (($ligaDaten->favteam > 0) && ($ligaDaten->favteam == $ligaDaten->teama[$st - 1][$i])) {
                            echo '</strong>';
                        }
                        if ($ligaDaten->plan == 1) {
                            echo '</a>';
                        }
                        echo '&nbsp;' . HTML_smallTeamIcon($file, $ligaDaten->teams[$ligaDaten->teama[$st - 1][$i]], ' alt=""') . '&nbsp;'; ?></td>
          <td class="nobr" align="center" width="10">-</td>
<?php
                        if ($m == 2) {
                            echo '          <td class="lmoTurnierSieger nobr" align="left">';
                        } /*elseif ($m == 1) {
                            echo '          <td class="lmoTurnierVerlierer nobr" align="left">'; // Verlierer nicht rot einfärben
                        }*/ else {
                            echo '          <td class="nobr" align="left">';
                        }
                        echo '&nbsp;' . HTML_smallTeamIcon($file, $ligaDaten->teams[$ligaDaten->teamb[$st - 1][$i]], ' alt=""') . '&nbsp;';
                        if ($ligaDaten->plan == 1) {
                            echo '<a href="' . $addp . $ligaDaten->teamb[$st - 1][$i] . '" title="' . $text[269] . '">';
                        }
                        if (($ligaDaten->favteam > 0) && ($ligaDaten->favteam == $ligaDaten->teamb[$st - 1][$i])) {
                            echo '<strong>';
                        }
                        echo $ligaDaten->teams[$ligaDaten->teamb[$st - 1][$i]];
                        if (($ligaDaten->favteam > 0) && ($ligaDaten->favteam == $ligaDaten->teamb[$st - 1][$i])) {
                            echo '</strong>';
                        }
                        if ($ligaDaten->plan == 1) {
                            echo '</a>';
                        }?></td>
          <td class="nobr" width="2">&nbsp;</td>
          <td class="nobr" align="right"><?php echo applyFactor($ligaDaten->goala[$st - 1][$i][$n], $ligaDaten->goalfaktor); ?></td>
            <td class="nobr" align="center" width="8">:</td>
                <td class="nobr" align="left"><?php echo applyFactor($ligaDaten->goalb[$st - 1][$i][$n], $ligaDaten->goalfaktor); ?></td>
<?php
                    } else {
                        if ($m == 2) {
                            echo '          <td class="lmoTurnierSieger nobr" align="right">';
                        } /*elseif ($m == 1) {
                            echo '          <td class="lmoTurnierVerlierer nobr" align="right">'; // Verlierer nicht rot einfärben
                        }*/ else {
                            echo '          <td class="nobr" align="right">';
                        }
                        if ($ligaDaten->plan == 1) {
                            echo '<a href="' . $addp . $ligaDaten->teamb[$st - 1][$i] . '" title="' . $text[269] . '">';
                        }
                        if (($ligaDaten->favteam > 0) && ($ligaDaten->favteam == $ligaDaten->teamb[$st - 1][$i])) {
                            echo '<strong>';
                        }
                        echo $ligaDaten->teams[$ligaDaten->teamb[$st - 1][$i]];
                        if (($ligaDaten->favteam > 0) && ($ligaDaten->favteam == $ligaDaten->teamb[$st - 1][$i])) {
                            echo '</strong>';
                        }
                        if ($ligaDaten->plan == 1) {
                            echo '</a>';
                        }
                        echo '&nbsp;' . HTML_smallTeamIcon($file, $ligaDaten->teams[$ligaDaten->teamb[$st - 1][$i]], ' alt=""') . '&nbsp;'; ?></td>
          <td class="nobr" align="center" width="10">-</td>
<?php
                        if ($m == 1) {
                            echo '          <td class="lmoTurnierSieger nobr" align="left">';
                        } /*elseif ($m == 2) {
                            echo '          <td class="lmoTurnierVerlierer nobr" align="left">'; // Verlierer nicht rot einfärben
                        }*/ else {
                            echo '          <td class="nobr" align="left">';
                        }
                        echo '&nbsp;' . HTML_smallTeamIcon($file, $ligaDaten->teams[$ligaDaten->teama[$st - 1][$i]], ' alt=""') . '&nbsp;';
                        if ($ligaDaten->plan == 1) {
                            echo '<a href="' . $addp . $ligaDaten->teama[$st - 1][$i] . '" title="' . $text[269] . '">';
                        }
                        if (($ligaDaten->favteam > 0) && ($ligaDaten->favteam == $ligaDaten->teama[$st - 1][$i])) {
                            echo '<strong>';
                        }
                        echo $ligaDaten->teams[$ligaDaten->teama[$st - 1][$i]];
                        if (($ligaDaten->favteam > 0) && ($ligaDaten->favteam == $ligaDaten->teama[$st - 1][$i])) {
                            echo '</strong>';
                        }
                        if ($ligaDaten->plan == 1) {
                            echo '</a>';
                        }?></td>
          <td class="nobr" width="2">&nbsp;</td>
          <td class="nobr" align="right"><?php echo applyFactor($ligaDaten->goalb[$st - 1][$i][$n], $ligaDaten->goalfaktor); ?></td>
          <td class="nobr" align="center" width="8">:</td>
          <td class="nobr" align="left"><?php echo applyFactor($ligaDaten->goala[$st - 1][$i][$n], $ligaDaten->goalfaktor); ?></td>
<?php
                    }
                }
                if ($ligaDaten->playoffmode < 1) { // now Modus = everything else ($playoffmode == 0; and KO-League without $playoffmode Option like old Champions-League Finalrounds)
                    if ($n % 2 == 0) {
                        $m1 = array($ligaDaten->goala[$st - 1][$i][0], $ligaDaten->goala[$st - 1][$i][1], $ligaDaten->goala[$st - 1][$i][2], $ligaDaten->goala[$st - 1][$i][3], $ligaDaten->goala[$st - 1][$i][4], $ligaDaten->goala[$st - 1][$i][5], $ligaDaten->goala[$st - 1][$i][6]);
                        $m2 = array($ligaDaten->goalb[$st - 1][$i][0], $ligaDaten->goalb[$st - 1][$i][1], $ligaDaten->goalb[$st - 1][$i][2], $ligaDaten->goalb[$st - 1][$i][3], $ligaDaten->goalb[$st - 1][$i][4], $ligaDaten->goalb[$st - 1][$i][5], $ligaDaten->goalb[$st - 1][$i][6]);
                        $m = gewinn($st - 1, $i, $ligaDaten->modus[$st - 1], $m1, $m2);
                        if ($m == 1) {
                            echo '          <td class="lmoTurnierSieger nobr" align="right">';
                        } /*elseif ($m == 2) {
                            echo '          <td class="lmoTurnierVerlierer nobr" align="right">'; // Verlierer nicht rot einfärben
                        }*/ else {
                            echo '          <td class="nobr" align="right">';
                        }
                        if ($ligaDaten->plan == 1) {
                            echo '<a href="' . $addp . $ligaDaten->teama[$st - 1][$i] . '" title="' . $text[269] . '">';
                        }
                        if (($ligaDaten->favteam > 0) && ($ligaDaten->favteam == $ligaDaten->teama[$st - 1][$i])) {
                            echo '<strong>';
                        }
                        echo $ligaDaten->teams[$ligaDaten->teama[$st - 1][$i]];
                        if (($ligaDaten->favteam > 0) && ($ligaDaten->favteam == $ligaDaten->teama[$st - 1][$i])) {
                            echo '</strong>';
                        }
                        if ($ligaDaten->plan == 1) {
                            echo '</a>';
                        }
                        echo '&nbsp;' . HTML_smallTeamIcon($file, $ligaDaten->teams[$ligaDaten->teama[$st - 1][$i]], ' alt=""') . '&nbsp;'; ?></td>
          <td class="nobr" align="center" width="10">-</td>
<?php
                        if ($m == 2) {
                            echo '          <td class="lmoTurnierSieger nobr" align="left">';
                        } /*elseif ($m == 1) {
                            echo '          <td class="lmoTurnierVerlierer nobr" align="left">'; // Verlierer nicht rot einfärben
                        }*/ else {
                            echo '          <td class="nobr" align="left">';
                        }
                        echo '&nbsp;' . HTML_smallTeamIcon($file, $ligaDaten->teams[$ligaDaten->teamb[$st - 1][$i]], ' alt=""') . '&nbsp;';
                        if ($ligaDaten->plan == 1) {
                            echo '<a href="' . $addp . $ligaDaten->teamb[$st - 1][$i] . '" title="' . $text[269] . '">';
                        }
                        if (($ligaDaten->favteam > 0) && ($ligaDaten->favteam == $ligaDaten->teamb[$st - 1][$i])) {
                            echo '<strong>';
                        }
                        echo $ligaDaten->teams[$ligaDaten->teamb[$st - 1][$i]];
                        if (($ligaDaten->favteam > 0) && ($ligaDaten->favteam == $ligaDaten->teamb[$st - 1][$i])) {
                            echo '</strong>';
                        }
                        if ($ligaDaten->plan == 1) {
                            echo '</a>';
                        }?></td>
          <td class="nobr" width="2">&nbsp;</td>
          <td class="nobr" align="right"><?php echo applyFactor($ligaDaten->goala[$st - 1][$i][$n], $ligaDaten->goalfaktor); ?></td>
          <td class="nobr" align="center" width="8">:</td>
          <td class="nobr" align="left"><?php echo applyFactor($ligaDaten->goalb[$st - 1][$i][$n], $ligaDaten->goalfaktor); ?></td>
<?php
                    } else {
                        if ($m == 2) {
                            echo '          <td class="lmoTurnierSieger nobr" align="right">';
                        } /*elseif ($m == 1) {
                            echo '          <td class="lmoTurnierVerlierer nobr" align="right">'; // Verlierer nicht rot einfärben
                        }*/ else {
                            echo '          <td class="nobr" align="right">';
                        }
                        if ($ligaDaten->plan == 1) {
                            echo '<a href="' . $addp . $ligaDaten->teamb[$st - 1][$i] . '" title="' . $text[269] . '">';
                        }
                        if (($ligaDaten->favteam > 0) && ($ligaDaten->favteam == $ligaDaten->teamb[$st - 1][$i])) {
                            echo '<strong>';
                        }
                        echo $ligaDaten->teams[$ligaDaten->teamb[$st - 1][$i]];
                        if (($ligaDaten->favteam > 0) && ($ligaDaten->favteam == $ligaDaten->teamb[$st - 1][$i])) {
                            echo '</strong>';
                        }
                        if ($ligaDaten->plan == 1) {
                            echo '</a>';
                        }
                        echo '&nbsp;' . HTML_smallTeamIcon($file, $ligaDaten->teams[$ligaDaten->teamb[$st - 1][$i]], ' alt=""') . '&nbsp;'; ?></td>
          <td class="nobr" align="center" width="10">-</td>
<?php
                        if ($m == 1) {
                            echo '          <td class="lmoTurnierSieger nobr" align="left">';
                        } /*elseif ($m == 2) {
                            echo '          <td class="lmoTurnierVerlierer nobr" align="left">'; // Verlierer nicht rot einfärben
                        }*/ else {
                            echo '          <td class="nobr" align="left">';
                        }
                        echo '&nbsp;' . HTML_smallTeamIcon($file, $ligaDaten->teams[$ligaDaten->teama[$st - 1][$i]], ' alt=""') . '&nbsp;';
                        if ($ligaDaten->plan == 1) {
                            echo '<a href="' . $addp . $ligaDaten->teama[$st - 1][$i] . '" title="' . $text[269] . '">';
                        }
                        if (($ligaDaten->favteam > 0) && ($ligaDaten->favteam == $ligaDaten->teama[$st - 1][$i])) {
                            echo '<strong>';
                        }
                        echo $ligaDaten->teams[$ligaDaten->teama[$st - 1][$i]];
                        if (($ligaDaten->favteam > 0) && ($ligaDaten->favteam == $ligaDaten->teama[$st - 1][$i])) {
                            echo '</strong>';
                        }
                        if ($ligaDaten->plan == 1) {
                            echo '</a>';
                        }?></td>
          <td class="nobr" width="2">&nbsp;</td>
          <td class="nobr" align="right"><?php echo applyFactor($ligaDaten->goalb[$st - 1][$i][$n], $ligaDaten->goalfaktor); ?></td>
          <td class="nobr" align="center" width="8">:</td>
          <td class="nobr" align="left"><?php echo applyFactor($ligaDaten->goala[$st - 1][$i][$n], $ligaDaten->goalfaktor); ?></td>
<?php
                    }
                }
?>
          <td class="nobr" width="2">&nbsp;</td>
          <td class="nobr"><?php echo $ligaDaten->mspez[$st - 1][$i][$n]; ?></td>
          <td class="nobr" width="2">&nbsp;</td>
          <td class="nobr"><?php

                /** Mannschaftsicons finden **/
                $lmo_teamaicon = '';
                $lmo_teambicon = '';
                if ($ligaDaten->urlb == 1 || $ligaDaten->mnote[$st - 1][$i][$n] != '') {
                    $lmo_teamaicon = HTML_smallTeamIcon($file, $ligaDaten->teams[$ligaDaten->teama[$st - 1][$i]], ' alt=""');
                    $lmo_teambicon = HTML_smallTeamIcon($file, $ligaDaten->teams[$ligaDaten->teamb[$st - 1][$i]], ' alt=""');
                }
                /** Spielbericht verlinken **/
                if ($ligaDaten->urlb == 1) {
                    if ($ligaDaten->mberi[$st - 1][$i][$n] != '') {
                        //Spielbericht Inhalt
                        $lmo_spielbericht_html = '<strong>' . $ligaDaten->teams[$ligaDaten->teama[$st - 1][$i]] . $lmo_teamaicon . ' - ' . $lmo_teambicon . $ligaDaten->teams[$ligaDaten->teamb[$st - 1][$i]] . '</strong>' . nl2br($text[270]);
                        // Link mit Mouseover-Funktion und data-info Attribut
                        echo '<span onmouseover="showLMOTooltip(this)" onmouseout="hideLMOTooltip()" data-info="' . htmlspecialchars($lmo_spielbericht_html) . '" class="tooltip-trigger"><a href="' . $ligaDaten->mberi[$st - 1][$i][$n] . '" target="_blank"><img src="' . URL_TO_IMGDIR . '/lmo-st1.svg" height="15" class="svg-no-style" border="0" alt=""></a></span>&nbsp;';
                    } else {
                        echo '&nbsp;';
                    }
                }
                /** Stats Addon */
                if (file_exists(PATH_TO_ADDONDIR . '/stats/lmo-showkoresults.inc.php')) include (PATH_TO_ADDONDIR . '/stats/lmo-showkoresults.inc.php');

                /** Notizen anzeigen **/
                if ($ligaDaten->mnote[$st - 1][$i][$n] != '') {
                    //Zentrierte Kopfzeile für Notizen
                    $lmo_spielnotiz = '<strong>' . $ligaDaten->teams[$ligaDaten->teama[$st - 1][$i]] . $lmo_teamaicon . ' - ' . $lmo_teambicon . $ligaDaten->teams[$ligaDaten->teamb[$st - 1][$i]] . '&nbsp;&nbsp;' . applyFactor($ligaDaten->goala[$st - 1][$i][$n], $ligaDaten->goalfaktor) . ':' . applyFactor($ligaDaten->goalb[$st - 1][$i][$n], $ligaDaten->goalfaktor) . '</strong>';
                    //Allgemeine Notiz
                    $lmo_spielnotiz .= '<br><strong>' . $text[22] . ':</strong> ' . $ligaDaten->mnote[$st - 1][$i][$n];

                    //Ausgabe als neutrales Element (kein Link)
                    echo '<span onmouseover="showLMOTooltip(this)" onmouseout="hideLMOTooltip()" data-info="' . htmlspecialchars(nl2br($lmo_spielnotiz)) . '" class="tooltip-trigger"><img src="' . URL_TO_IMGDIR . '/lmo-st2.svg" height="15" class="svg-no-style" border="0" alt=""></span>';
                    $lmo_spielnotiz = '';
                } else {
                    echo '&nbsp;';
                }?></td>

        </tr>
<?php
            }  // END -> for ($n = 0; $n < $modus[$st - 1]; $n++)
            if (($ligaDaten->modus[$st - 1] > 1) && ($i <= $ligaDaten->anzsp - 1)) { ?>
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
   if ($st < $ligaDaten->anzst) {?>
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