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

require_once(PATH_TO_LMO . '/lmo-admintest.php');
if ($_SESSION['lmouserok'] != 2) {
    die('No permission');
}
require_once(PATH_TO_ADDONDIR . '/tipp/lmo-tippnachtrag.php');

function lmo_tipp_t($key, $default)
{
    global $text;

    return isset($text['tipp'][$key]) && $text['tipp'][$key] !== '' ? $text['tipp'][$key] : $default;
}

$nachtrag_file = isset($_GET['nfile']) && is_string($_GET['nfile']) ? $_GET['nfile'] : '';

// Ligen mit Tippdateien ermitteln
$nachtrag_ligen = [];
$nachtrag_dir = PATH_TO_ADDONDIR . '/tipp/' . $tipp_dirtipp;
if (is_dir($nachtrag_dir)) {
    foreach (scandir($nachtrag_dir) as $nachtrag_f) {
        if (strtolower(substr($nachtrag_f, -4)) === '.tip' && strrpos($nachtrag_f, '_') !== false) {
            $nachtrag_ligen[substr($nachtrag_f, 0, strrpos($nachtrag_f, '_')) . '.l98'] = true;
        }
    }
}
$nachtrag_ligen = array_keys($nachtrag_ligen);
natcasesort($nachtrag_ligen);

include(PATH_TO_ADDONDIR . '/tipp/lmo-admintippmenu.php');
?>
<table class="lmoMiddle" width="99%" cellspacing="0" cellpadding="0" border="0">
  <tr>
    <td class="lmoCaption" colspan="2"><?php echo lmo_tipp_t(306, 'Enter tips retroactively'); ?></td>
  </tr>
  <tr>
    <td colspan="2"><?php echo lmo_tipp_t(312, 'As full administrator you can enter or change tips for a tipper after the matches have started. The time limit is lifted for you only. Every change is logged. Afterwards run the evaluation again.'); ?></td>
  </tr>
  <tr>
    <td><?php echo lmo_tipp_t(307, 'Choose league'); ?></td>
    <td>
      <form name="nachtragform" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="get">
        <input type="hidden" name="action" value="admin">
        <input type="hidden" name="todo" value="tippnachtrag">
        <select name="nfile" onchange="this.form.submit()">
          <option value="">-</option><?php
foreach ($nachtrag_ligen as $nachtrag_l) {
    echo '<option value="' . htmlspecialchars($nachtrag_l) . '"' . ($nachtrag_l === $nachtrag_file ? ' selected' : '') . '>' . htmlspecialchars($nachtrag_l) . '</option>';
}?>
        </select>
        <noscript><input type="submit" value="OK"></noscript>
      </form>
    </td>
  </tr><?php
if ($nachtrag_file !== '' && in_array($nachtrag_file, $nachtrag_ligen, true)) {
    $nachtrag_nicks = lmo_tipp_nachtrag_nicks($nachtrag_file); ?>
  <tr>
    <th align="left"><?php echo lmo_tipp_t(308, 'Tipper (nick)'); ?></th>
    <th align="left">&nbsp;</th>
  </tr><?php
    if (!$nachtrag_nicks) {?>
  <tr><td colspan="2"><?php echo lmo_tipp_t(310, 'No tippers for this league.'); ?></td></tr><?php
    }
    foreach ($nachtrag_nicks as $nachtrag_n) {
        if (!lmo_tipp_nachtrag_valid($nachtrag_file, $nachtrag_n)) {
            continue;
        }?>
  <tr>
    <td><?php echo htmlspecialchars($nachtrag_n); ?></td>
    <td><a href="<?php echo URL_TO_LMO . '/lmo.php?action=tipp&amp;todo=edit&amp;file=' . rawurlencode($nachtrag_file) . '&amp;asnick=' . rawurlencode($nachtrag_n); ?>"><?php echo lmo_tipp_t(309, 'Edit tips'); ?></a></td>
  </tr><?php
    }
}?>
</table>
<?php
// Protokoll der Nachtraege (neueste zuerst, maximal 200)
$nachtrag_log = [];
$nachtrag_logfile = PATH_TO_LMO . '/config/tipp/nachtrag.php';
if (is_file($nachtrag_logfile)) {
    foreach (file($nachtrag_logfile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $nachtrag_line) {
        if (strpos($nachtrag_line, '|') !== false) {
            $nachtrag_log[] = explode('|', $nachtrag_line);
        }
    }
    $nachtrag_log = array_slice(array_reverse($nachtrag_log), 0, 200);
}
?>
<table class="lmoMiddle" width="99%" cellspacing="0" cellpadding="0" border="0">
  <tr>
    <td class="lmoCaption" colspan="5"><?php echo lmo_tipp_t(314, 'Log of retroactive entries'); ?></td>
  </tr><?php
if (!$nachtrag_log) {?>
  <tr><td colspan="5"><?php echo lmo_tipp_t(315, 'No entries yet.'); ?></td></tr><?php
} else {?>
  <tr>
    <th align="left"><?php echo lmo_tipp_t(316, 'Date'); ?></th>
    <th align="left">Admin</th>
    <th align="left"><?php echo lmo_tipp_t(308, 'Tipper (nick)'); ?></th>
    <th align="left"><?php echo lmo_tipp_t(307, 'League'); ?></th>
    <th align="left"><?php echo lmo_tipp_t(317, 'Round'); ?></th>
  </tr><?php
    foreach ($nachtrag_log as $nachtrag_r) {
        $nachtrag_r = array_pad($nachtrag_r, 5, '');?>
  <tr>
    <td><?php echo htmlspecialchars($nachtrag_r[0]); ?></td>
    <td><?php echo htmlspecialchars($nachtrag_r[1]); ?></td>
    <td><?php echo htmlspecialchars($nachtrag_r[2]); ?></td>
    <td><?php echo htmlspecialchars($nachtrag_r[3]); ?></td>
    <td><?php echo htmlspecialchars($nachtrag_r[4]); ?></td>
  </tr><?php
    }
}?>
</table>
