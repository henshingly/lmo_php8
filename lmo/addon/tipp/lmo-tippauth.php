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
  */

require(PATH_TO_ADDONDIR . '/tipp/lmo-tipptest.php');
$xtippername = isset($_REQUEST['xtippername']) ? $_REQUEST['xtippername'] : '';
$xtipperpass = isset($_REQUEST['xtipperpass']) ? $_REQUEST['xtipperpass'] : '';

if ($action == 'tipp') {
    if (!isset($_SESSION['lmotipperok'])) {
        $_SESSION['lmotipperok'] = 0;
    }
    if (!isset($_SESSION['lmotippername'])) {
        $_SESSION['lmotippername'] = '';
    }
    if (!isset($_SESSION['lmotipperpass'])) {
        $_SESSION['lmotipperpass'] = '';
    }
    if (!isset($_SESSION['lmotipperverein'])) {
        $_SESSION['lmotipperverein'] = '';
    }

    if ($_SESSION['lmotipperok'] < 1 && $_SESSION['lmotipperok'] > -4) {
        if (!empty($xtippername) && !empty($xtipperpass)) {
            $_SESSION['lmotippername'] = $xtippername;
            $_SESSION['lmotipperpass'] = $xtipperpass;
            $pswfile = PATH_TO_ADDONDIR . '/tipp/' . $tipp_tippauthtxt;

            if (file_exists($pswfile)) {
                $tippers = file($pswfile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
                $updated = false;
                $_SESSION['lmotipperok'] = -2; // Standard: Nicht gefunden

                foreach($tippers as $index => $line) {
                    if (strpos($line, '<?php') !== false) continue; // Schutzzeile überspringen

                    $fileinfo = explode('|', trim($line));
                    if (count($fileinfo) < 2) continue;

                    $storedUser = $fileinfo[0];
                    $storedHash = $fileinfo[1];

                    if ($_SESSION['lmotippername'] === $storedUser) {
                        // NUTZUNG DER NEUEN ZENTRALEN FUNKTION
                        $auth = checkAndUpgradePassword($_SESSION['lmotipperpass'], $storedHash);

                        if ($auth['success']) {
                            // Login erfolgreich
                            $lmotippername = $_SESSION['lmotippername'];
                            $lmotipperverein = isset($fileinfo[5]) ? $fileinfo[5] : '';
                            $_SESSION['lmotipperok'] = $fileinfo[2];

                            // Falls die Funktion meldet, dass ein Upgrade nötig ist (Klartext -> Hash)
                            if ($auth['needsUpgrade']) {
                                $fileinfo[1] = $auth['newHash'];
                                $tippers[$index] = implode('|', $fileinfo);
                                $updated = true;
                            }
                        } else {
                            $_SESSION['lmotipperok'] = -1; // Passwort falsch
                        }
                        break; 
                    }
                }

                if ($updated) {
                    file_put_contents($pswfile, implode(PHP_EOL, $tippers) . PHP_EOL, LOCK_EX);
                }
            }
        }
    }

    if ($_SESSION['lmotipperok'] == -5) {
        require(PATH_TO_ADDONDIR . '/tipp/lmo-tippemailpass.php');
    }

    if ($_SESSION['lmotipperok'] < 1 && $_SESSION['lmotipperok'] > -4) {
        $addw = $_SERVER['PHP_SELF'] . '?action=tipp&amp;todo=wert&amp;file=';
        $adda = $_SERVER['PHP_SELF'] . '?action=tipp&amp;todo=';

        if (($todo == 'wert' && $all != 1) || $todo == 'fieber' || $todo == 'edit') {
            require(PATH_TO_LMO . '/lmo-openfilename.php');
        } elseif ($todo == 'einsicht') {
            $lmo_only_st=true;
            require(PATH_TO_LMO . '/lmo-openfile.php');
        } elseif ($todo == 'tabelle') {
            require_once(PATH_TO_LMO . '/lmo-openfile.php');
        }

        include(PATH_TO_ADDONDIR . '/tipp/lmo-tippmenu.php');
?>
 <table class="lmoMiddle" cellspacing="0" cellpadding="0" border="0">
  <tr>
    <td colspan="3" align="center"><h1><?php echo $text['tipp'][0] . '&nbsp;'; if (isset($titel)) {echo $titel;} ?></h1></td>
  </tr>
  <tr>
    <td colspan="3" align="center"><?php
        if ($todo == 'wert') {require(PATH_TO_ADDONDIR . '/tipp/lmo-tippwert.php');}
        elseif ($todo == 'fieber') {require(PATH_TO_ADDONDIR . '/tipp/lmo-tippfieber.php');}
        elseif ($todo == 'einsicht') {require(PATH_TO_ADDONDIR . '/tipp/lmo-tippeinsicht.php');}
        elseif ($todo == 'tabelle') {require(PATH_TO_ADDONDIR . '/tipp/lmo-tipptabelle.php');}
        elseif ($todo == 'info') {require(PATH_TO_LMO . '/lmo-showinfo.php');}
        else { ?>
      <form name="lmotippedit" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <input type="hidden" name="action" value="tipp">
        <input type="hidden" name="file" value="<?php echo $file; ?>">
        <table class="lmoInner" width="99%">
          <caption><?php echo $text['tipp'][158]; ?></caption>
          <tr>
            <th colspan="2"><?php echo $text['tipp'][44]; ?></th>
          </tr>
<?php
            if ($_SESSION['lmotipperok'] == -2) { ?>
          <tr>
            <td align="right" colspan="3"><?php echo getMessage($text['tipp'][43],true); ?></td>
          </tr>
<?php
            }
            if (isset($xtippersub) && $_SESSION['lmotipperok'] == '' && !isset($emailbody)) { ?>
          <tr>
            <td align="right" colspan="3"><?php echo getMessage($text['tipp'][148],true); ?></td>
          </tr>
<?php
            } ?>
          <tr>
            <td align="right"><acronym title="<?php echo $text[307]; ?>"><?php echo '&nbsp;' . $text['tipp'][23]; ?></acronym></td>
            <td align="left"><input class="lmo-formular-input" type="text" name="xtippername" size="16" maxlength="32" value="<?php echo $_SESSION['lmotippername']; ?>"></td>
          </tr>
<?php
            if ($_SESSION['lmotipperok'] == -1) {
                $xtippername2 = $_SESSION['lmotippername']; ?>
          <tr>
            <td align="right" colspan="3"><?php echo getMessage($text['tipp'][42],true); ?></td>
          </tr>
<?php
            } ?>
          <tr>
            <td align="right"><acronym title="<?php echo $text[309]; ?>"><?php echo '&nbsp;' . $text[308]; ?></acronym></td>
            <td align="left"><input class="lmo-formular-input" type="password" name="xtipperpass" size="16" maxlength="32" value="<?php echo $_SESSION['lmotipperpass']; ?>"></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left"><input class="lmo-formular-button" title="<?php echo $text[311]; ?>" type="submit" name="xtippersub" value="<?php echo $text['tipp'][12]; ?>"></td>
          </tr>
        </table>
      </form>
    </td>
  </tr>
  <tr>
    <td>
      <table class="lmoInner" width="99%">
        <tr>
          <th colspan="3"><?php echo $text['tipp'][45]; ?></th>
        </tr>
        <tr>
          <td align="right" colspan="2"><?php echo $text['tipp'][46]; ?></td>
          <td align="left">
            <form name="lmotippedit" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
              <input type="hidden" name="action" value="tipp">
              <input type="hidden" name="todo" value="newtipper">
              <input class="lmo-formular-button" type="submit" name="xtippersub" value="<?php echo $text['tipp'][11]; ?>">
            </form>
          </td>
        </tr>
      </table>
    </td>
  </tr>
  <tr>
    <td>
      <table class="lmoInner" width="99%">
        <tr>
          <th colspan="3"><?php echo $text['tipp'][4]; ?></th>
        </tr>
        <tr>
          <td colspan="3" align="left">
            <ul><?php
            $ftype='.l98';
            require(PATH_TO_ADDONDIR . '/tipp/lmo-tippnewdir.php');
            $dummy =  explode('|', $tt1);
            $ftest2 = explode('|', $tt0);
            if (isset($dummy) && isset($ftest2)) {
                for ($u = 0; $u < count($dummy); $u++) {
                    if ($dummy[$u] != '' && $ftest2[$u] != '') {
                        $dummy[$u] = substr($dummy[$u], 0, -4);
                        $auswertfile = PATH_TO_ADDONDIR . '/tipp/' . $tipp_dirtipp . 'auswert/' . $dummy[$u] . '.aus';
                        if ($tipp_nurgesamt == 0) { ?>
              <li class="lmoadminli"><a href="<?php echo $addw . $dummy[$u] . '.l98'; ?>"><?php echo $ftest2[$u]; ?></a><?php if (file_exists($auswertfile)) {echo '<br><small>' . $text['tipp'][83] . ': ' . date('d.m.Y H:i', filemtime($auswertfile)) . '</small>';} ?></li>
<?php
                        }
                    }
                }
            }
            if ($tipp_gesamt == 1 && ($u > 2 || $tipp_nurgesamt == 1 && $u == 2)) {
                $auswertfile = PATH_TO_ADDONDIR . '/tipp/' . $tipp_dirtipp . 'auswert/gesamt.aus'; ?>
              <li class="lmoadminli"><a href="<?php echo $addw . '&amp;all=1' ?>"><strong><?php echo $text['tipp'][25]; ?></strong></a><?php if (file_exists($auswertfile)) {echo '<br><small>' . $text['tipp'][83] . ': ' . date('d.m.Y H:i', filemtime($auswertfile)) . '</small>';} ?></li>
<?php
            } ?>
            </ul>
          </td>
        </tr>
      </table>
    </td>
  </tr>
  <tr>
    <td>
      <form name="lmotippedit" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <input type="hidden" name="action" value="tipp">
        <input type="hidden" name="todo" value="getpass">
        <table class="lmoInner" width="99%">
          <tr>
            <th colspan="3"><?php echo $text['tipp'][74]; ?></th>
          </tr>
<?php
            if ($_SESSION['lmotipperok'] == -3) { ?>
          <tr>
            <td align="right" colspan="3"><?php echo getMessage($text['tipp'][43],true); ?></td>
          </tr>
<?php
            } ?>
          <tr>
            <td align="right"><acronym title="<?php echo $text[307]; ?>"><?php echo '&nbsp;' . $text['tipp'][23] . '&nbsp;' . $text['tipp'][218] . '&nbsp;' . $text['tipp'][219]; ?></acronym></td>
            <td align="left"><input class="lmo-formular-input" type="text" name="xtippername2" size="16" maxlength="32" value="<?php echo (isset($xtippername2) ? $xtippername2 : ''); ?>"></td>
          </tr>
          <tr>
            <td align="right"><?php echo $text['tipp'][75]; ?></td>
            <td align="left"><input class="lmo-formular-button" type="submit" name="xtippersub" value="<?php echo $text['tipp'][76]; ?>"></td>
          </tr>
        </table>
      </form>
    </td>
  </tr>
<?php
        } ?>
</table>
<?php
    }
}
?>