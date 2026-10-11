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

if ($file != '') {
    $addp = $_SERVER['PHP_SELF'] . '?action=program&amp;file=' . $file . '&amp;selteam=';
    $addr = $_SERVER['PHP_SELF'] . '?action=results&amp;file=' . $file . '&amp;st=';
    $ligaDaten->selteam =! empty($_GET['selteam']) ? $_GET['selteam'] : $ligaDaten->selteam;?>

<table class="lmoMiddle" cellspacing="0" cellpadding="0" border="0">
  <tr>
    <td valign="top" align="center">
      <table class="lmoMenu" cellspacing="0" cellpadding="0" border="0"><?php
    for ($i = 1; $i <= floor($ligaDaten->anzteams / 2); $i++) { ?>
        <tr>
          <td align="right">
            <acronym title="<?php echo $text[23] . ' ' . $ligaDaten->teams[$i]; ?>">
<?php
        if ($i != $ligaDaten->selteam) { ?>
              <a href="<?php echo $addp . $i; ?>" ><?php echo $ligaDaten->teamk[$i]; ?></a>
<?php
        } else {
            echo $ligaDaten->teamk[$i];
        } ?>
            </acronym>
          </td>
          <td>&nbsp;<?php echo HTML_smallTeamIcon($file, $ligaDaten->teams[$i], ' alt=""'); ?>&nbsp;</td>
        </tr>
<?php
    } ?>
      </table>
    </td>
    <td valign="top" align="center">
      <table class="lmoInner" cellspacing="0" cellpadding="0" border="0">
<?php
    if ($ligaDaten->selteam == 0) { ?>
        <tr>
          <td align="center" class="lmost5">&nbsp;<br><?php echo $text[24]; ?><br>&nbsp;</td>
        </tr>
<?php
    } else {
        for ($j = 0; $j < $ligaDaten->anzst; $j++) {
            for ($i = 0; $i < (($ligaDaten->anzteams / 2) + 1); $i++) {
                if (($ligaDaten->selteam == $ligaDaten->teama[$j][$i]) || ($ligaDaten->selteam == $ligaDaten->teamb[$j][$i])) { ?>
        <tr>
<?php
                    if ($j == $ligaDaten->anzst-1) {
                        $l = $text[364];
                    } elseif ($j == $ligaDaten->anzst - 2) {
                        $l = $text[362];
                    } elseif ($j == $ligaDaten->anzst - 3) {
                        $l = $text[360];
                    } elseif ($j == $ligaDaten->anzst - 4) {
                        $l = $text[358];
                    } else {
                        $l = $j + 1;
                    }?>
          <th align="right">&nbsp;<a href="<?php echo $addr.($j + 1); ?>" title="<?php echo $text[377]; ?>"><?php echo $l; ?></a>&nbsp;</th>
<?php
                    $m1 = array($ligaDaten->goala[$j][$i][0], $ligaDaten->goala[$j][$i][1], $ligaDaten->goala[$j][$i][2], $ligaDaten->goala[$j][$i][3], $ligaDaten->goala[$j][$i][4], $ligaDaten->goala[$j][$i][5], $ligaDaten->goala[$j][$i][6]);
                    $m2 = array($ligaDaten->goalb[$j][$i][0], $ligaDaten->goalb[$j][$i][1], $ligaDaten->goalb[$j][$i][2], $ligaDaten->goalb[$j][$i][3], $ligaDaten->goalb[$j][$i][4], $ligaDaten->goalb[$j][$i][5], $ligaDaten->goalb[$j][$i][6]);
                    $m = gewinn($j, $i, $ligaDaten->modus[$j], $m1, $m2);
                    if ($m == 1) { ?>
          <td class="lmoTurnierSieger nobr" align="right"><?php
                    } elseif ($m == 2) { ?>
          <td class="lmoTurnierVerlierer nobr" align="right"><?php
                    } else { ?>
          <td class="nobr" align="right"><?php
                    }
                    if ($ligaDaten->selteam == $ligaDaten->teama[$j][$i]) {
                        echo '<strong>';
                    }
                    echo $ligaDaten->teams[$ligaDaten->teama[$j][$i]];
                    if ($ligaDaten->selteam == $ligaDaten->teama[$j][$i]) {
                        echo '</strong>';
                    }
                    echo '&nbsp;' . HTML_smallTeamIcon($file, $ligaDaten->teams[$ligaDaten->teama[$j][$i]],' alt=""');
                    if (($ligaDaten->teamu[$ligaDaten->teama[$j][$i]] != '') && ($ligaDaten->urlt == 1)) {
                        echo ' <a href="' . $ligaDaten->teamu[$ligaDaten->teama[$j][$i]] . '" target="_blank" title="' . $text[46] . '"><img border="0" width="11" src="' . URL_TO_IMGDIR . '/url.png" alt="' . $text[564] . '" title="' . $text[46] . '"></a>';
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
                    echo HTML_smallTeamIcon($file, $ligaDaten->teams[$ligaDaten->teamb[$j][$i]], ' alt=""') . '&nbsp;';
                    if ($ligaDaten->selteam == $ligaDaten->teamb[$j][$i]) {
                        echo '<strong>';
                    }
                    echo $ligaDaten->teams[$ligaDaten->teamb[$j][$i]];
                    if ($ligaDaten->selteam == $ligaDaten->teamb[$j][$i]) {
                        echo '</strong>';
                    }
                    if (($ligaDaten->teamu[$ligaDaten->teamb[$j][$i]] != '') && ($ligaDaten->urlt == 1)) {
                        echo '<a href="' . $ligaDaten->teamu[$ligaDaten->teamb[$j][$i]] . '" target="_blank" title="' . $text[46] . '"><img border="0" width="11" src="' . URL_TO_IMGDIR . '/url.png" alt="' . $text[564] . '" title="' . $text[46] . '"></a>';
                    } ?></td>
<?php
                    for ($n = 0; $n < $ligaDaten->modus[$j]; $n++) {
                        if ($ligaDaten->datm == 1) {
                            if(is_numeric($ligaDaten->mterm[$j][$i][$n])) {
                                $dt = new DateTime();
                                $dt->setTimeStamp((int)$ligaDaten->mterm[$j][$i][$n]);
                                $dumn1 = '<acronym title="' . $dt->format($ligaDaten->datf) . '">';
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
          <td class="nobr"><?php echo $dumn1;?><?php echo applyFactor($ligaDaten->goala[$j][$i][$n], $ligaDaten->goalfaktor); ?>&nbsp;:&nbsp;<?php echo applyFactor($ligaDaten->goalb[$j][$i][$n], $ligaDaten->goalfaktor); ?><?php echo $ligaDaten->mspez[$j][$i][$n]; ?><?php echo $dumn2; ?><?php
                        /** Mannschaftsicons finden **/
                        $lmo_teamaicon = '';
                        $lmo_teambicon = '';
                        if ($ligaDaten->urlb == 1 || $ligaDaten->mnote[$j][$i][$n] != '') {
                            $lmo_teamaicon = HTML_smallTeamIcon($file, $ligaDaten->teams[$ligaDaten->teama[$j][$i]], ' alt=""');
                            $lmo_teambicon = HTML_smallTeamIcon($file, $ligaDaten->teams[$ligaDaten->teamb[$j][$i]], ' alt=""');
                        }
                        /** Spielbericht verlinken **/
                        if ($ligaDaten->urlb == 1) {
                            if ($ligaDaten->mberi[$j][$i][$n] != '') {
                                // Header für Spielbericht
                                $lmo_spielbericht_html = '<strong>' . $ligaDaten->teams[$ligaDaten->teama[$j][$i]] . $lmo_teamaicon . ' - ' . $lmo_teambicon . $ligaDaten->teams[$ligaDaten->teamb[$j][$i]] . '</strong>' . nl2br($text[270]);

                                // Link mit Mouseover-Funktion und data-info Attribut
                                echo '<span onmouseover="showLMOTooltip(this)" onmouseout="hideLMOTooltip()" data-info="' . htmlspecialchars($lmo_spielbericht_html) . '" class="tooltip-trigger"><a href="' . $ligaDaten->mberi[$j][$i][$n] . '" target="_blank"><img src="' . URL_TO_IMGDIR . '/lmo-st1.svg" height="15" class="svg-no-style" border="0" alt=""></a></span>&nbsp;';
                            } else {
                                echo '&nbsp;';
                            }
                        }
                        /** Notizen anzeigen **/
                        if ($ligaDaten->mnote[$j][$i][$n] != '') {
                            //Zentrierte Kopfzeile für Notizen
                            $lmo_spielnotiz = '<strong>' . $ligaDaten->teams[$ligaDaten->teama[$j][$i]] . $lmo_teamaicon . ' - ' . $lmo_teambicon . $ligaDaten->teams[$ligaDaten->teamb[$j][$i]] . '&nbsp;&nbsp;' . applyFactor($ligaDaten->goala[$j][$i][$n], $ligaDaten->goalfaktor) . ':' . applyFactor($ligaDaten->goalb[$j][$i][$n], $ligaDaten->goalfaktor) . '</strong>';
                            //Allgemeine Notiz
                            $lmo_spielnotiz .= '<br><strong>' . $text[22] . ':</strong> ' . $ligaDaten->mnote[$j][$i][$n];

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
    for ($i = ceil($ligaDaten->anzteams / 2) + 1; $i <= $ligaDaten->anzteams; $i++) { ?>
        <tr>
          <td>&nbsp;<?php echo HTML_smallTeamIcon($file, $ligaDaten->teams[$i], ' alt=""'); ?></td>
          <td align="left">
            <acronym title="<?php echo $text[23] . ' ' . $ligaDaten->teams[$i]; ?>">
<?php
        if ($i != $ligaDaten->selteam) { ?>
            <a href="<?php echo $addp . $i; ?>"><?php echo $ligaDaten->teamk[$i]; ?></a>
<?php
        } else {
            echo $ligaDaten->teamk[$i];
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