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

require_once(PATH_TO_LMO . '/lmo-admintest.php');
isset($_POST['save']) ? $save = $_POST['save'] : $save = 0;
isset($_REQUEST['show']) ? $show = $_REQUEST['show'] : $show = 0;

// ---- E-Mail-Versand (SMTP): nur Voll-Admin -------------------------------------------------
require_once(PATH_TO_LMO . '/lmo-smtp.php');
lmo_smtp_lang();
$smtp_isadmin = (isset($_SESSION['lmouserok']) && $_SESSION['lmouserok'] == 2);
$smtp_form = lmo_smtp_load();   // Werte für die Anzeige
$smtp_msg = '';                 // Meldungen (HTML) für den Block
$smtp_test_html = '';           // Ergebnis der Testmail
if (empty($_SESSION['lmo_csrf_smtp'])) {
    $_SESSION['lmo_csrf_smtp'] = bin2hex(random_bytes(16));
}
if ($smtp_isadmin && $save == 1 && $show == 0 && isset($_POST['smtp_mode'])) {
    $smtp_token_ok = isset($_POST['smtp_token']) && hash_equals($_SESSION['lmo_csrf_smtp'], (string) $_POST['smtp_token']);
    if (!$smtp_token_ok) {
        $smtp_msg .= getMessage($text['smtp'][25], true);
        $smtp_test_html = '';
        if (isset($_POST['smtp_test'])) {
            $smtp_test_html = getMessage($text['smtp'][25], true);
        }
    } else {
        $smtp_in = array(
            'mode' => $_POST['smtp_mode'],
            'host' => isset($_POST['smtp_host']) ? $_POST['smtp_host'] : '',
            'port' => isset($_POST['smtp_port']) ? $_POST['smtp_port'] : 587,
            'secure' => isset($_POST['smtp_secure']) ? $_POST['smtp_secure'] : '',
            'username' => isset($_POST['smtp_username']) ? $_POST['smtp_username'] : '',
            'from' => isset($_POST['smtp_from']) ? $_POST['smtp_from'] : '',
            'password' => isset($_POST['smtp_password']) ? $_POST['smtp_password'] : '',
        );
        list($smtp_new, $smtp_err) = lmo_smtp_sanitize($smtp_in);
        $smtp_clear = !empty($_POST['smtp_clearpw']);
        $smtp_errtext = array('host' => 20, 'port' => 21, 'from' => 22, 'password' => 26);
        if (isset($_POST['smtp_test'])) {
            // Testmail: nichts speichern, mit den eingegebenen Werten senden
            $save = 0;
            if (count($smtp_err) > 0) {
                foreach ($smtp_err as $e) {
                    $smtp_test_html .= getMessage($text['smtp'][$smtp_errtext[$e]], true);
                }
            } elseif ($aadr == '' || !filter_var($aadr, FILTER_VALIDATE_EMAIL)) {
                $smtp_test_html = getMessage($text['smtp'][27], true);
            } else {
                if ($smtp_new['password'] === '' && !$smtp_clear) {
                    $smtp_new['password'] = $smtp_form['password']; // gespeichertes Passwort verwenden
                }
                if ($smtp_new['mode'] !== 'smtp') {
                    $smtp_new['mode'] = 'smtp';                     // der Test prüft immer den SMTP-Weg
                }
                list($smtp_ok, $smtp_res) = lmo_smtp_test($smtp_new, $aadr);
                $smtp_test_html = $smtp_ok
                    ? getMessage($text['smtp'][17] . ' ' . htmlspecialchars($aadr) . ' (' . htmlspecialchars($smtp_res) . ').')
                    : getMessage($text['smtp'][18] . ' ' . htmlspecialchars($smtp_res), true);
            }
            $smtp_new['password'] = '';
            $smtp_form = array_merge($smtp_form, $smtp_new);
        } elseif (count($smtp_err) > 0) {
            // Eingabefehler: SMTP nicht speichern, Formular mit den Eingaben wieder anzeigen
            foreach ($smtp_err as $e) {
                $smtp_msg .= getMessage($text['smtp'][$smtp_errtext[$e]], true);
            }
            $smtp_new['password'] = '';
            $smtp_form = array_merge($smtp_form, $smtp_new);
        } elseif (lmo_smtp_save($smtp_new, $smtp_new['password'], $smtp_clear)) {
            $smtp_msg .= getMessage($text['smtp'][28]);
            $smtp_form = lmo_smtp_load(true);
        } else {
            $smtp_msg .= getMessage($text['smtp'][23], true);
        }
    }
}
// ---------------------------------------------------------------------------------------------

if ($save == 1) {
    switch ($show) {
        case 0:
            $dirliga = trim($_POST['xdirliga']);
            if ($dirliga == '') {
                $dirliga = './';
            }
            $dirliga = str_replace('\\', '/', $dirliga);        // (Falschen) Backslash -> Slash
            if (substr($dirliga, -1) != '/') $dirliga .= '/';   // Slash ergänzen falls nicht vorhanden
            $ArchivDir = $dirliga . 'archiv/';

            $deflang = isset($_POST['xdeflang']) ? trim($_POST['xdeflang']) : $deflang;

            //Zeitformat kontrollieren
            $deftime = isset($_POST['xdeftime']) ? $_POST['xdeftime'] : '15:30';
            $datum_tmp = explode(':', $deftime);
            $deftime = date('H:i', mktime($datum_tmp[0], $datum_tmp[1]));

            if (!empty($_POST['xdefdateselect'])) {
                $defdateformat = isset($_POST['xdefdateformat']) ? $_POST['xdefdateformat'] : $defdateformat;
            }
            else {
                $defdateformat = isset($_POST['xdefdateformat2']) ? $_POST['xdefdateformat2'] : $defdateformat;
            }
            $timezone = isset($_POST['xtimezone']) ? $_POST['xtimezone'] : '';
            $aadr = isset($_POST['xadr']) ? $_POST['xadr'] : '';

            $liga_sort = isset($_POST['xliga_sort']) ? $_POST['xliga_sort'] : 'liga_name';
            $liga_sort_direction = isset($_POST['xliga_sort_direction']) ? $_POST['xliga_sort_direction'] : 'asc';

        break;
        case 1:
            $tabpkt = isset($_POST['xtabpkt']) ? trim($_POST['xtabpkt']) : $tabpkt;
            $tabonres = isset($_POST['xtabonres']) ? trim($_POST['xtabonres']) : $tabonres;
        break;
        case 2:
            $backlink = isset($_POST['xbacklink']) ? 1 : 0;
            $archivlink = isset($_POST['xarchivlink']) ? 1 : 0;
            $calctime = isset($_POST['xcalctime']) ? 1 : 0;
            $einsavehtml = isset($_POST['xeinsavehtml']) ? 1 : 0;
            $einsprachwahl = isset($_POST['xeinsprachwahl']) ? 1 : 0;
            $einspieler = isset($_POST['xeinspieler']) ? 1 : 0;
            $eintippspiel = isset($_POST['xeintippspiel']) ? 1 : 0;
            $einspielfrei = isset($_POST['xeinspielfrei']) ? 1 : 0;
            $einzutore = isset($_POST['xeinzutore']) ? 1 : 0;
            $einzutoretab = isset($_POST['xeinzutoretab']) ? 1 : 0;
            //$einhinrueck = isset($_POST['xeinhinrueck']) ? 1 : 0;
            $einzustats = isset($_POST['xeinzustats']) ? 1 : 0;
        break;
    }
    require(PATH_TO_LMO . '/lmo-savecfg.php');
    require(PATH_TO_LMO . '/init.php');
}?>
      <table width="100%" class="lmoSubmenu" cellspacing="0" cellpadding="0" border="0">
        <tr>
          <td align="center"><?php echo $text[319]; ?></td>
          <td align="center"><a href="<?php echo $addr_addons; ?>" onclick="return chklmolink();" title="<?php echo $text[498]; ?>"><?php echo $text[497]; ?></a></td>
          <td align="center"><a href="<?php echo $addr_design; ?>" onclick="return chklmolink();" title="<?php echo $text[422]; ?>"><?php echo $text[421]; ?></a></td>
          <td align="center"><a href="<?php echo $addr_user; ?>" onclick="return chklmolink();" title="<?php echo $text[318]; ?>"><?php echo $text[317]; ?></a></td>
        </tr>
      </table>
      <table class="lmoMiddle" cellspacing="0" cellpadding="0" border="0" >
        <tr>
          <td align="center" colspan="2"><h1><?php echo $text[225]; ?></h1></td>
        </tr>
        <tr>
          <td valign="top">
            <table class="lmoMenu" cellspacing="0" cellpadding="0" border="0">
              <tr><td align="right"><?php if ($show == 0) {echo $text[99]; ?><?php } else {?> <a href="<?php echo $_SERVER['PHP_SELF'] . '?action=admin&amp;todo=options&amp;show=0'; ?>"><?php echo $text[99]; ?></a><?php }?></td></tr>
              <tr><td align="right"><?php if ($show == 1) {echo $text[226]; ?><?php } else {?> <a href="<?php echo $_SERVER['PHP_SELF'] . '?action=admin&amp;todo=options&amp;show=1'; ?>"><?php echo $text[226]; ?></a><?php }?></td></tr>
              <tr><td align="right"><?php if ($show == 2) {echo $text[250]; ?><?php } else {?> <a href="<?php echo $_SERVER['PHP_SELF'] . '?action=admin&amp;todo=options&amp;show=2'; ?>"><?php echo $text[250]; ?></a><?php }?></td></tr>
            </table>
          </td>
          <td align="left" valign="top">
            <form name="lmoedit" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" onSubmit="return chklmopass()">
              <input type="hidden" name="action" value="admin">
              <input type="hidden" name="todo" value="options">
              <input type="hidden" name="save" value="1">
              <input type="hidden" name="file" value="<?php echo $file; ?>">
              <input type="hidden" name="show" value="<?php echo $show; ?>">
              <table class="lmoInner" cellspacing="0" cellpadding="0" border="0">
<?php
if ($show == 0) {?>
                <tr>
                  <td class="nobr" align="right"><acronym title="<?php echo $text[506]; ?>"><?php echo $text[505]; ?></acronym></td>
                  <td class="nobr" colspan="4">
                    <select class="lmo-formular-input" name="xdeflang" onchange="dolmoedit()">
<?php
    foreach (glob(PATH_TO_LANGDIR . '/lang-*.txt') as $filepath) {
        if (preg_match('/lang-(.+)\.txt$/', $filepath, $lang)) { ?>
        <option<?php if ($lang[1] == $deflang) echo ' selected'; ?>><?php echo $lang[1]; ?></option>
<?php
        }
    } ?>
                    </select>&nbsp;<?php echo '<img src="' . URL_TO_IMGDIR . '/' . $deflang . '.svg" height="16">'; ?></td>
                </tr>
<?php
    if (version_compare(PHP_VERSION, '5.1.0') >= 0) { ?>
                <tr>
                  <td class="nobr" align="right"><acronym title="<?php echo $text[575]; ?>"><?php echo $text[574]; ?></acronym></td>
                  <td class="nobr" colspan="4">
                    <select class="lmo-formular-input" name="xtimezone" onchange="dolmoedit()">
<?php
        $timezones = get_timezones();
        foreach ($timezones as $continent => $zones) {?>
                      <optgroup label="<?php echo $continent; ?>">
<?php
            foreach ($zones as $zone_value => $zone_name) {?>
                        <option value="<?php echo $zone_value; ?>"<?php if ($zone_value == $timezone) echo ' selected'; ?>><?php echo $zone_name; ?></option>
<?php
            }?>
                      </optgroup>
<?php
        }?>
                    </select>
                  </td>
                </tr>
<?php
    }?>
                <tr>
                  <td class="nobr" align="right"><acronym title="<?php echo $text[222]; ?>"><?php echo $text[221]; ?></acronym></td>
                  <td class="nobr" colspan="4"><input class="lmo-formular-input" type="text" name="xdirliga" size="20" maxlength="80" value="<?php echo $dirliga; ?>" onChange="dolmoedit()"></td>
                </tr>
                <tr>
                  <td class="nobr" align="right"><acronym title="<?php echo $text[240]; ?>"><?php echo $text[239]; ?></acronym></td>
                  <td class="nobr" colspan="4"><input class="lmo-formular-input" type="text" name="xdeftime" size="5" maxlength="5" value="<?php echo $deftime; ?>" onChange="dolmoedit()"></td>
                </tr>
                <tr>
                  <td class="nobr" rowspan="2" align="right"><acronym title="<?php echo $text[256]; ?>"><?php echo $text[257]; ?></acronym>&nbsp;</td>
                  <td class="nobr" align="left">
                    <input type="radio" name="xdefdateselect" value="1" checked>
                    <select class="lmo-formular-input" name="xdefdateformat" onChange="dolmoedit();document.getElementsByName('xdefdateselect')[0].checked=true;">
<?php
    $dummf = array('d.m. H:i', 'd.m.Y H:i', 'D., d.m. H:i', 'l, d.m. H:i', 'D., d.m.Y H:i', 'l, d.m.Y H:i'); ?>
                      <option value="">__</option>
<?php
    for ($y = 0; $y < count($dummf); $y++) {?>
                      <option value="<?php echo $dummf[$y]; ?>"<?php if ($defdateformat == $dummf[$y]) {echo ' selected';}?>><?php echo strtr(date($dummf[$y], time()), $trans_lang); ?></option>
<?php
    }?>
                    </select>
                  </td>
                </tr>
                <tr>
                  <td class="nobr" align="left">
                    <input type="radio" name="xdefdateselect" value=""<?php if (!in_array($defdateformat,$dummf)) echo ' checked'; ?>>
                    <input type="text" class="lmo-formular-input" name="xdefdateformat2" onChange="dolmoedit();document.getElementsByName('xdefdateselect')[1].checked=true;" value="<?php echo $defdateformat?>">
                    <a href="https://www.php.net/manual/de/datetime.format.php">
                      <span class="popup">
                        <strong><?php echo $text[545]; ?></strong><br>
                        D = <?php echo strtr(date('D', time()), $trans_lang); ?><br>
                        l = <?php echo strtr(date('l', time()), $trans_lang); ?><br>
                        <strong><?php echo $text[546]; ?></strong><br>
                        d = <?php echo strtr(date('d', time()), $trans_lang); ?><br>
                        j = <?php echo strtr(date('j', time()), $trans_lang); ?><br>
                        <strong><?php echo $text[547]; ?></strong><br>
                        m = <?php echo strtr(date('n', time()), $trans_lang); ?><br>
                        M = <?php echo strtr(date('M', time()), $trans_lang); ?><br>
                        F = <?php echo strtr(date('F', time()), $trans_lang); ?><br>
                        <strong><?php echo $text[548]; ?></strong><br>
                        y = <?php echo strtr(date('y', time()), $trans_lang); ?><br>
                        Y = <?php echo strtr(date('Y', time()), $trans_lang); ?><br>
                        <strong><?php echo $text[549]; ?></strong><br>
                        H = <?php echo strtr(date('H', time()), $trans_lang); ?><br>
                        i = <?php echo strtr(date('i', time()), $trans_lang); ?><br>
                        A = <?php echo strtr(date('A', time()), $trans_lang); ?><br>
                      </span>
                    ?</a>
                  </td>
                </tr>
                <tr>
                  <td class="nobr" align="right"><acronym title="<?php echo $text[344]; ?>"><?php echo $text[343]; ?></acronym></td>
                 <td class="nobr" colspan="4"><input class="lmo-formular-input" type="text" name="xadr" size="40" maxlength="128" value="<?php echo $aadr; ?>" onChange="dolmoedit()"></td>
                </tr>
<?php
    if ($smtp_isadmin) {
        $smtp_h = function ($v) { return htmlspecialchars((string) $v, ENT_QUOTES, 'UTF-8'); };
        $smtp_on = ($smtp_form['mode'] === 'smtp');
        $smtp_style = $smtp_on ? '' : ' style="display:none"';?>
                <tr>
                  <td class="nobr" align="right"><?php echo $text['smtp'][0]; ?></td>
                  <td class="nobr" colspan="4">
                    <input type="hidden" name="smtp_token" value="<?php echo $smtp_h($_SESSION['lmo_csrf_smtp']); ?>">
                    <label><input type="radio" name="smtp_mode" value="mail"<?php if (!$smtp_on) echo ' checked'; ?> onclick="lmoSmtpToggle();dolmoedit()"> <?php echo $text['smtp'][2]; ?></label>&nbsp;&nbsp;
                    <label><input type="radio" name="smtp_mode" value="smtp"<?php if ($smtp_on) echo ' checked'; ?> onclick="lmoSmtpToggle();dolmoedit()"> <?php echo $text['smtp'][3]; ?></label>
                  </td>
                </tr>
<?php
        if ($smtp_msg != '' || !lmo_is_https()) {?>
                <tr>
                  <td></td>
                  <td colspan="4"><?php echo $smtp_msg; if (!lmo_is_https()) {?><div class="error"><?php echo $text['smtp'][19]; ?></div><?php }?></td>
                </tr>
<?php
        }?>
                <tr class="smtp-row"<?php echo $smtp_style; ?>>
                  <td class="nobr" align="right"><?php echo $text['smtp'][4]; ?></td>
                  <td class="nobr" colspan="4"><input class="lmo-formular-input" type="text" name="smtp_host" size="40" maxlength="255" value="<?php echo $smtp_h($smtp_form['host']); ?>" onChange="dolmoedit()" autocomplete="off"></td>
                </tr>
                <tr class="smtp-row"<?php echo $smtp_style; ?>>
                  <td class="nobr" align="right"><?php echo $text['smtp'][5]; ?></td>
                  <td class="nobr" colspan="4"><input class="lmo-formular-input" type="text" name="smtp_port" size="5" maxlength="5" value="<?php echo (int) $smtp_form['port']; ?>" onChange="dolmoedit()"></td>
                </tr>
                <tr class="smtp-row"<?php echo $smtp_style; ?>>
                  <td class="nobr" align="right"><?php echo $text['smtp'][6]; ?></td>
                  <td class="nobr" colspan="4">
                    <select class="lmo-formular-input" name="smtp_secure" onChange="dolmoedit()">
                      <option value="tls"<?php if ($smtp_form['secure'] === 'tls') echo ' selected'; ?>><?php echo $text['smtp'][8]; ?></option>
                      <option value="ssl"<?php if ($smtp_form['secure'] === 'ssl') echo ' selected'; ?>><?php echo $text['smtp'][9]; ?></option>
                      <option value=""<?php if ($smtp_form['secure'] === '') echo ' selected'; ?>><?php echo $text['smtp'][7]; ?></option>
                    </select>
                  </td>
                </tr>
                <tr class="smtp-row"<?php echo $smtp_style; ?>>
                  <td class="nobr" align="right"><?php echo $text['smtp'][10]; ?></td>
                  <td class="nobr" colspan="4"><input class="lmo-formular-input" type="text" name="smtp_username" size="40" maxlength="255" value="<?php echo $smtp_h($smtp_form['username']); ?>" onChange="dolmoedit()" autocomplete="off"></td>
                </tr>
                <tr class="smtp-row"<?php echo $smtp_style; ?>>
                  <td class="nobr" align="right"><acronym title="<?php echo $smtp_h($text['smtp'][29]); ?>"><?php echo $text['smtp'][11]; ?></acronym></td>
                  <td class="nobr" colspan="4"><input class="lmo-formular-input" type="password" name="smtp_password" size="40" maxlength="255" value="" onChange="dolmoedit()" autocomplete="new-password"></td>
                </tr>
<?php
        if ($smtp_form['password_error']) {?>
                <tr class="smtp-row"<?php echo $smtp_style; ?>>
                  <td></td>
                  <td colspan="4"><div class="error"><?php echo $text['smtp'][24]; ?></div></td>
                </tr>
<?php
        } elseif ($smtp_form['password_set']) {?>
                <tr class="smtp-row"<?php echo $smtp_style; ?>>
                  <td></td>
                  <td class="nobr" colspan="4"><small><?php echo $text['smtp'][14]; ?></small><br>
                    <label><input type="checkbox" name="smtp_clearpw" value="1" onclick="dolmoedit()"> <?php echo $text['smtp'][15]; ?></label></td>
                </tr>
<?php
        }?>
                <tr class="smtp-row"<?php echo $smtp_style; ?>>
                  <td class="nobr" align="right"><acronym title="<?php echo $smtp_h($text['smtp'][13]); ?>"><?php echo $text['smtp'][12]; ?></acronym></td>
                  <td class="nobr" colspan="4"><input class="lmo-formular-input" type="text" name="smtp_from" size="40" maxlength="128" value="<?php echo $smtp_h($smtp_form['from']); ?>" onChange="dolmoedit()"></td>
                </tr>
                <tr class="smtp-row"<?php echo $smtp_style; ?>>
                  <td></td>
                  <td colspan="4"><input type="button" class="lmo-formular-button" value="<?php echo $smtp_h($text['smtp'][16]); ?>" onclick="lmoSmtpTest()">
                    <span id="smtp-test-target"><?php if ($smtp_test_html != '') echo '<span id="smtp-test-result">' . $smtp_test_html . '</span>'; ?></span>
                    <script type="text/javascript">
                    function lmoSmtpToggle() {
                      var on = document.getElementsByName('smtp_mode')[1].checked;
                      var rows = document.getElementsByTagName('tr');
                      for (var i = 0; i < rows.length; i++) {
                        if (rows[i].className === 'smtp-row') { rows[i].style.display = on ? '' : 'none'; }
                      }
                    }
                    function lmoSmtpTest() {
                      var f = document.forms['lmoedit'], t = document.getElementById('smtp-test-target');
                      if (!window.fetch || !window.FormData) { return; }
                      var fd = new FormData(f);
                      fd.set('smtp_test', '1');
                      fd.set('smtp_mode', 'smtp');
                      t.textContent = <?php echo json_encode($text['smtp'][30]); ?>;
                      fetch(f.getAttribute('action'), {method: 'POST', body: fd, credentials: 'same-origin'})
                        .then(function (r) { return r.text(); })
                        .then(function (html) {
                          var d = new DOMParser().parseFromString(html, 'text/html');
                          var el = d.getElementById('smtp-test-result');
                          if (el) { t.innerHTML = el.innerHTML; } else { t.textContent = 'Error'; }
                        })
                        .catch(function (e) { t.textContent = 'Error: ' + e; });
                    }
                    </script>
                  </td>
                </tr>
<?php
    }?>
                <tr>
                  <td class="nobr" align="right" rowspan="2"><acronym title="<?php echo $text[532]; ?>"><?php echo $text[533]; ?></acronym></td>
                  <td class="nobr" colspan="2" rowspan="2">
                    <select class="lmo-formular-input" name="xliga_sort" onChange="dolmoedit()">
                      <option value="liga_name"<?php if ($liga_sort == 'liga_name') echo ' selected'; ?>><?php echo $text[529]; ?></option>
                      <option value="file_date"<?php if ($liga_sort == 'file_date') echo ' selected'; ?>><?php echo $text[530]; ?></option>
                      <option value="file_name"<?php if ($liga_sort == 'file_name') echo ' selected'; ?>><?php echo $text[531]; ?></option>
                    </select>
                  </td>
                  <td class="nobr" colspan="2"><input type="radio" name="xliga_sort_direction" onClick="dolmoedit()" value="asc"<?php if ($liga_sort_direction=='asc') echo ' checked'; ?>> <?php echo $text[527]; ?></td>
                </tr>
                <tr>
                  <td class="nobr" colspan="2"><input type="radio" name="xliga_sort_direction" onClick="dolmoedit()" value="desc"<?php if ($liga_sort_direction=='desc') echo ' checked'; ?>><?php echo $text[528]; ?></td>
                </tr><?php
} elseif ($show == 1) {?>
                <tr>
                  <td class="nobr" align="right"><acronym title="<?php echo $text[228]; ?>"><?php echo $text[227]; ?></acronym></td>
                  <td class="nobr" colspan="4">
                    <select class="lmo-formular-input" name="xtabpkt" onChange="dolmoedit()">
                      <option value="0"<?php if ($tabpkt == 0) {echo ' selected';}?>><?php echo $text[229]; ?></option>
                      <option value="1"<?php if ($tabpkt == 1) {echo ' selected';}?>><?php echo $text[230]; ?></option>
                    </select>
                  </td>
                </tr>
                <tr>
                  <td class="nobr" align="right"><acronym title="<?php echo $text[232]; ?>"><?php echo $text[231]; ?></acronym></td>
                  <td class="nobr" colspan="4">
                    <select class="lmo-formular-input" name="xtabonres" onChange="dolmoedit()">
                      <option value="0"<?php if ($tabonres == 0) {echo ' selected';}?>><?php echo $text[233]; ?></option>
                      <option value="1"<?php if ($tabonres == 1) {echo ' selected';}?>><?php echo $text[234]; ?></option>
                      <option value="2"<?php if ($tabonres == 2) {echo ' selected';}?>><?php echo $text[235]; ?></option>
                    </select>
                  </td>
                </tr>
<?php
} elseif ($show == 2) {?>
                <tr>
                  <td class="nobr" align="right"><acronym title="<?php echo $text[390]; ?>"><?php echo $text[389]; ?></acronym></td>
                  <td class="nobr"><input type="checkbox" class="lmo-formular-input" name="xbacklink" onChange="dolmoedit()"<?php if ($backlink == 1) {echo ' checked';}?>></td>
                  <td class="nobr" width="15%">&nbsp;</td>
                  <td class="nobr" align="right"><input type="checkbox" class="lmo-formular-input" name="xarchivlink" onChange="dolmoedit()"<?php if ($archivlink == 1) {echo ' checked';}?>></td>
                  <td class="nobr"><acronym title="<?php echo $text[510]; ?>"><?php echo $text[509]; ?></acronym></td>
                </tr>
                <tr>
                  <td class="nobr" align="right"><acronym title="<?php echo $text[473]; ?>"><?php echo $text[472]; ?></acronym></td>
                  <td class="nobr"><input type="checkbox" class="lmo-formular-input" name="xcalctime" onChange="dolmoedit()"<?php if ($calctime == 1) {echo ' checked';}?>></td>
                  <td>&nbsp;</td>
                  <td class="nobr" align="right"><input type="checkbox" class="lmo-formular-input" name="xeinsavehtml" onChange="dolmoedit()"<?php if ($einsavehtml == 1) {echo ' checked';}?>></td>
                  <td class="nobr"><acronym title="<?php echo $text[484]; ?>"><?php echo $text[483]; ?></acronym></td>
                </tr>
                <tr>
                  <td class="nobr" align="right"><acronym title="<?php echo $text[486]; ?>"><?php echo $text[485]; ?></acronym></td>
                  <td class="nobr"><input type="checkbox" class="lmo-formular-input" name="xeinspieler" onChange="dolmoedit()"<?php if ($einspieler == 1) {echo ' checked';}?>></td>
                  <td>&nbsp;</td>
                  <td class="nobr" align="right"><input type="checkbox" class="lmo-formular-input" name="xeinzustats" onChange="dolmoedit()"<?php if ($einzustats == 1) {echo ' checked';}?>></td>
                  <td class="nobr"><acronym title="<?php echo $text[496]; ?>"><?php echo $text[495]; ?></acronym></td>
                </tr>
                <tr>
                  <td class="nobr" align="right"><acronym title="<?php echo $text[535]; ?>"><?php echo $text[534]; ?></acronym></td>
                  <td class="nobr"><input type="checkbox" class="lmo-formular-input" name="xeinspielfrei" onChange="dolmoedit()"<?php if ($einspielfrei == 1) {echo ' checked';}?>></td>
                  <td>&nbsp;</td>
                  <td class="nobr" align="right"><input type="checkbox" class="lmo-formular-input" name="xeintippspiel" onChange="dolmoedit()"<?php if ($eintippspiel == 1) {echo ' checked';}?>></td>
                  <td class="nobr"><acronym title="<?php echo $text[488]; ?>"><?php echo $text[487]; ?></acronym></td>
                </tr>
                <tr>
                  <td colspan="3">&nbsp;</td>
                  <td class="nobr" align="right"><input type="checkbox" class="lmo-formular-input" name="xeinsprachwahl" onChange="dolmoedit()"<?php if ($einsprachwahl == 1) {echo ' checked';}?>></td>
                  <td class="nobr"><acronym title="<?php echo $text[520]; ?>"><?php echo $text[519]; ?></acronym></td>
                </tr>
                <tr>
                  <td class="nobr" rowspan="2" align="right"><acronym title="<?php echo $text[490]; ?>"><?php echo $text[489]; ?></acronym></td>
                  <td class="nobr" colspan="4"><input type="checkbox" class="lmo-formular-input" name="xeinzutoretab" onChange="dolmoedit()"<?php if ($einzutoretab == 1) {echo ' checked';}?>>&nbsp;<?php echo $text[491]; ?></td>
                </tr>
                <tr>
                  <td class="nobr" colspan="4"><input type="checkbox" class="lmo-formular-input" name="xeinzutore" onChange="dolmoedit()"<?php if ($einzutore == 1) {echo ' checked';}?>>&nbsp;<?php echo $text[492]; ?></td>
                </tr>
<?php
}?>
                <tr>
                  <td class="nobr" colspan="6" align="center">
                    <input title="<?php echo $text[114]; ?>" class="lmo-formular-button" type="submit" name="best" value="<?php echo $text[188]; ?>">
                  </td>
                </tr>
              </table>
            </form>
          </td>
        </tr>
      </table>
