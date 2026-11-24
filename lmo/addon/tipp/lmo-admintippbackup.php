<?php

/** Liga Manager Online 4
  *
  * https://www.liga-manager-online.org/lmo/
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
require_once(PATH_TO_ADDONDIR . '/tipp/lmo-tippbackup.php');

function lmo_tipp_bt($key, $default)
{
    global $text;

    return isset($text['tipp'][$key]) && $text['tipp'][$key] !== '' ? $text['tipp'][$key] : $default;
}

/** Fehlercode einer Sicherungsfunktion in einen Text umsetzen. */
function lmo_tipp_bt_error($res)
{
    $detail = isset($res['detail']) && $res['detail'] !== '' ? ' (' . $res['detail'] . ')' : '';
    switch ($res['error']) {
        case 'zip':
            return lmo_tipp_bt(329, 'The PHP extension "Zip" (ZipArchive) is missing on this server.');
        case 'dir':
            return lmo_tipp_bt(330, 'The backup directory config/tipp/backup/ is not writable.');
        case 'src':
            return lmo_tipp_bt(382, 'The tip directory is invalid or does not exist.');
        case 'lock':
            return lmo_tipp_bt(374, 'A backup or restore is already running. Please try again later.');
        case 'invalid':
            return lmo_tipp_bt(376, 'The file is not a valid prediction game backup.');
        case 'corrupt':
            return lmo_tipp_bt(377, 'The backup is damaged (checksum mismatch).') . $detail;
        case 'forbidden':
            return lmo_tipp_bt(378, 'The backup contains disallowed files.') . $detail;
        case 'size':
            return lmo_tipp_bt(379, 'The backup is too large.');
        case 'safety':
            return lmo_tipp_bt(380, 'The safety copy of the current state could not be created.');
        case 'write':
            return lmo_tipp_bt(381, 'Writing failed.') . $detail;
        default:
            return lmo_tipp_bt(328, 'The backup could not be created.') . $detail;
    }
}

$backup_msgs = [];   // [Text, Fehler?]
$backup_restore_view = '';
$act = ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['sb_action']) && is_string($_POST['sb_action'])) ? $_POST['sb_action'] : '';
if ($act !== '') {
    if (!lmo_tipp_backup_token_ok(isset($_POST['sb_token']) ? $_POST['sb_token'] : '')) {
        $backup_msgs[] = ['Invalid token. Please reload the page.', true];
    } elseif ($act === 'create') {
        $res = lmo_tipp_backup_create('sicherung');
        if ($res['ok']) {
            lmo_tipp_backup_log('create', $res['name']);
            $backup_msgs[] = [str_replace(['[name]', '[n]'], [$res['name'], $res['files']], lmo_tipp_bt(327, 'Backup created: [name] ([n] files)')), false];
        } else {
            $backup_msgs[] = [lmo_tipp_bt_error($res), true];
        }
    } elseif ($act === 'delete') {
        $n = isset($_POST['sb_name']) ? $_POST['sb_name'] : '';
        if (lmo_tipp_backup_delete($n)) {
            lmo_tipp_backup_log('delete', $n);
            $backup_msgs[] = [lmo_tipp_bt(331, 'Backup deleted.'), false];
        } else {
            $backup_msgs[] = [lmo_tipp_bt(328, 'The backup could not be created.'), true];
        }
    } elseif ($act === 'settings') {
        if (lmo_tipp_backup_settings_save(isset($_POST['sb_auto']), isset($_POST['sb_keep']) ? $_POST['sb_keep'] : 0, isset($_POST['sb_logdays']) ? $_POST['sb_logdays'] : 0)) {
            lmo_tipp_backup_log('settings', '', 'auto=' . (isset($_POST['sb_auto']) ? 1 : 0) . ' keep=' . (int)($_POST['sb_keep'] ?? 0) . ' logdays=' . (int)($_POST['sb_logdays'] ?? 0));
            lmo_tipp_backup_prune();
            $backup_msgs[] = [lmo_tipp_bt(343, 'Settings saved.'), false];
        } else {
            $backup_msgs[] = [lmo_tipp_bt_error(['error' => 'dir']), true];
        }
    } elseif ($act === 'clearlog') {
        if (lmo_tipp_backup_log_clear()) {
            lmo_tipp_backup_log('log-deleted');
            $backup_msgs[] = [lmo_tipp_bt(394, 'Log deleted.'), false];
        } else {
            $backup_msgs[] = [lmo_tipp_bt_error(['error' => 'dir']), true];
        }
    } elseif ($act === 'upload') {
        $f = isset($_FILES['sb_file']) ? $_FILES['sb_file'] : null;
        if (!$f || !isset($f['error']) || $f['error'] !== UPLOAD_ERR_OK || !is_uploaded_file($f['tmp_name']) || strtolower(substr((string)$f['name'], -4)) !== '.zip') {
            $backup_msgs[] = [str_replace('[reason]', lmo_tipp_bt(376, 'The file is not a valid prediction game backup.'), lmo_tipp_bt(348, 'Upload failed: [reason]')), true];
        } else {
            $res = lmo_tipp_backup_import($f['tmp_name']);
            if ($res['ok']) {
                lmo_tipp_backup_log('upload', $res['name'], (string)$f['name']);
                $backup_msgs[] = [lmo_tipp_bt(347, 'Backup uploaded.'), false];
            } else {
                $backup_msgs[] = [str_replace('[reason]', lmo_tipp_bt_error($res), lmo_tipp_bt(348, 'Upload failed: [reason]')), true];
            }
        }
    } elseif ($act === 'restore') {
        $n = isset($_POST['sb_name']) ? $_POST['sb_name'] : '';
        $parts = [
            'tippordner' => isset($_POST['sb_p_tippordner']),
            'tipperdatei' => isset($_POST['sb_p_tipperdatei']),
            'punkteregeln' => isset($_POST['sb_p_punkteregeln']),
        ];
        $word = lmo_tipp_bt(368, 'RESTORE');
        $confirmed = isset($_POST['sb_confirm']) && is_string($_POST['sb_confirm']) && mb_strtoupper(trim($_POST['sb_confirm'])) === mb_strtoupper($word);
        if (!lmo_tipp_backup_valid_name($n)) {
            $backup_msgs[] = [lmo_tipp_bt_error(['error' => 'invalid']), true];
        } elseif (!$parts['tippordner'] && !$parts['tipperdatei'] && !$parts['punkteregeln']) {
            $backup_msgs[] = [lmo_tipp_bt(373, 'Please select at least one item.'), true];
            $backup_restore_view = $n;
        } elseif (!$confirmed) {
            $backup_msgs[] = [lmo_tipp_bt(369, 'The confirmation does not match.'), true];
            $backup_restore_view = $n;
        } else {
            $res = lmo_tipp_backup_restore($n, $parts, isset($_POST['sb_mode']) && $_POST['sb_mode'] === 'exact');
            if ($res['ok']) {
                $backup_msgs[] = [str_replace(['[written]', '[deleted]', '[name]'], [$res['written'], $res['deleted'], $res['safety']], lmo_tipp_bt(370, 'Restore completed: [written] files written, [deleted] deleted. The previous state was saved as: [name]')), false];
            } else {
                $msg = str_replace('[reason]', lmo_tipp_bt_error($res), lmo_tipp_bt(371, 'The restore was aborted: [reason]'));
                if (!empty($res['safety'])) {
                    $msg .= ' ' . str_replace('[name]', $res['safety'], lmo_tipp_bt(383, 'Safety copy: [name]'));
                }
                $backup_msgs[] = [$msg, true];
            }
        }
    }
} elseif (isset($_GET['sb_restore']) && is_string($_GET['sb_restore']) && lmo_tipp_backup_valid_name($_GET['sb_restore'])) {
    $backup_restore_view = $_GET['sb_restore'];
}
$backup_token = lmo_tipp_backup_token();
$backup_set = lmo_tipp_backup_settings();
$backup_self = $_SERVER['PHP_SELF'] . '?action=admin&amp;todo=tippbackup';
$backup_types = [
    'sicherung' => lmo_tipp_bt(335, 'Manual'),
    'auto' => lmo_tipp_bt(336, 'Automatic (before evaluation)'),
    'vorher' => lmo_tipp_bt(337, 'Before restore'),
];

include(PATH_TO_ADDONDIR . '/tipp/lmo-admintippmenu.php');

// ---------------- Wiederherstellen: Bestätigungsseite ----------------
if ($backup_restore_view !== '') {
    $rv_info = lmo_tipp_backup_inspect(lmo_tipp_backup_dir() . '/' . $backup_restore_view);
    $rv_paths = lmo_tipp_backup_paths();
    ?>
<table class="lmoMiddle" width="99%" cellspacing="0" cellpadding="0" border="0">
  <tr>
    <td class="lmoCaption" colspan="2"><?php echo lmo_tipp_bt(353, 'Restore backup'); ?></td>
  </tr><?php
    foreach ($backup_msgs as $m) {?>
  <tr><td colspan="2"><?php echo getMessage(htmlspecialchars($m[0]), $m[1]); ?></td></tr><?php
    }
    if (!$rv_info['ok']) {?>
  <tr><td colspan="2"><?php echo getMessage(htmlspecialchars(lmo_tipp_bt_error($rv_info)), true); ?></td></tr>
  <tr><td colspan="2"><a href="<?php echo $backup_self; ?>"><?php echo lmo_tipp_bt(313, 'Back'); ?></a></td></tr><?php
    } else {
        $mf = $rv_info['manifest'];
        $cnt = isset($mf['counts']) && is_array($mf['counts']) ? $mf['counts'] : [];
        $rv_parts = [
            'tippordner' => isset($_POST['sb_p_tippordner']) || $_SERVER['REQUEST_METHOD'] !== 'POST',
            'tipperdatei' => isset($_POST['sb_p_tipperdatei']) || $_SERVER['REQUEST_METHOD'] !== 'POST',
            'punkteregeln' => isset($_POST['sb_p_punkteregeln']) || $_SERVER['REQUEST_METHOD'] !== 'POST',
        ];
        $rv_exact = isset($_POST['sb_mode']) && $_POST['sb_mode'] === 'exact';
        $rv_all = ['tippordner' => true, 'tipperdatei' => true, 'punkteregeln' => true];
        $rv_plan_merge = lmo_tipp_backup_plan($mf, $rv_all, false);
        $rv_plan_exact = lmo_tipp_backup_plan($mf, $rv_all, true);
        $rv_ptext = lmo_tipp_bt(365, 'Preview: [new] new files, [changed] will be overwritten, [same] unchanged, [del] will be deleted.');?>
  <tr>
    <td><?php echo lmo_tipp_bt(354, 'Created'); ?></td>
    <td><?php echo date('d.m.Y H:i:s', (int)$mf['created']); ?> &ndash; <?php echo htmlspecialchars($backup_restore_view); ?></td>
  </tr>
  <tr>
    <td><?php echo lmo_tipp_bt(355, 'Tip directory in the backup'); ?></td>
    <td><code><?php echo htmlspecialchars((string)($mf['dirtipp'] ?? '')); ?></code></td>
  </tr>
  <tr>
    <td><?php echo lmo_tipp_bt(356, 'Current tip directory'); ?></td>
    <td><code><?php echo htmlspecialchars($rv_paths['dirtipp']); ?></code></td>
  </tr><?php
        if ((string)($mf['dirtipp'] ?? '') !== $rv_paths['dirtipp']) {?>
  <tr><td colspan="2"><?php echo getMessage(htmlspecialchars(lmo_tipp_bt(357, 'Attention: the tip directory of the backup differs from the current one. The data is written to the current directory.')), true); ?></td></tr><?php
        }?>
  <tr>
    <td colspan="2">
      <form action="<?php echo $backup_self; ?>&amp;sb_restore=<?php echo rawurlencode($backup_restore_view); ?>" method="post">
        <input type="hidden" name="sb_action" value="restore">
        <input type="hidden" name="sb_token" value="<?php echo htmlspecialchars($backup_token); ?>">
        <input type="hidden" name="sb_name" value="<?php echo htmlspecialchars($backup_restore_view); ?>">
        <p><strong><?php echo lmo_tipp_bt(358, 'What should be restored?'); ?></strong></p>
        <label><input type="checkbox" name="sb_p_tippordner" value="1"<?php echo $rv_parts['tippordner'] ? ' checked' : ''; ?><?php echo empty($cnt['tippordner']) ? ' disabled' : ''; ?>> <?php echo lmo_tipp_bt(359, 'Tip folder (tips, evaluations, insight, club ranking)'); ?> (<?php echo (int)($cnt['tippordner'] ?? 0); ?>)</label><br>
        <label><input type="checkbox" name="sb_p_tipperdatei" value="1"<?php echo $rv_parts['tipperdatei'] ? ' checked' : ''; ?><?php echo empty($cnt['tipperdatei']) ? ' disabled' : ''; ?>> <?php echo lmo_tipp_bt(360, 'Tipper file (access data of the tippers)'); ?></label><br>
        <label><input type="checkbox" name="sb_p_punkteregeln" value="1"<?php echo $rv_parts['punkteregeln'] ? ' checked' : ''; ?><?php echo empty($cnt['punkteregeln']) ? ' disabled' : ''; ?>> <?php echo lmo_tipp_bt(361, 'Scoring rules (cfg.txt of the prediction game)'); ?></label>
        <p><strong><?php echo lmo_tipp_bt(362, 'Restore mode'); ?></strong></p>
        <label><input type="radio" name="sb_mode" value="merge"<?php echo $rv_exact ? '' : ' checked'; ?>> <?php echo lmo_tipp_bt(363, 'Add and overwrite (recommended): existing files that are not in the backup are kept.'); ?></label><br>
        <small><?php echo str_replace(['[new]', '[changed]', '[same]', '[del]'], [$rv_plan_merge['new'], $rv_plan_merge['changed'], $rv_plan_merge['same'], $rv_plan_merge['delete']], $rv_ptext); ?></small><br>
        <label><input type="radio" name="sb_mode" value="exact"<?php echo $rv_exact ? ' checked' : ''; ?>> <?php echo lmo_tipp_bt(364, 'Exactly as in the backup: files in the tip folder that are not in the backup are deleted.'); ?></label><br>
        <small><?php echo str_replace(['[new]', '[changed]', '[same]', '[del]'], [$rv_plan_exact['new'], $rv_plan_exact['changed'], $rv_plan_exact['same'], $rv_plan_exact['delete']], $rv_ptext); ?></small>
        <p><?php echo htmlspecialchars(lmo_tipp_bt(366, 'Before restoring, a backup of the current state is created automatically. If that fails, nothing is changed.')); ?></p>
        <p><?php echo str_replace('[word]', '<strong>' . htmlspecialchars(lmo_tipp_bt(368, 'RESTORE')) . '</strong>', lmo_tipp_bt(367, 'To confirm, please type the word [word]:')); ?>
          <input type="text" name="sb_confirm" size="16" autocomplete="off"></p>
        <input class="lmo-formular-button" type="submit" value="<?php echo htmlspecialchars(lmo_tipp_bt(338, 'Restore')); ?>">
        <a href="<?php echo $backup_self; ?>"><?php echo lmo_tipp_bt(372, 'Cancel'); ?></a>
      </form>
    </td>
  </tr><?php
    }?>
</table><?php
    return;
}
?>
<table class="lmoMiddle" width="99%" cellspacing="0" cellpadding="0" border="0">
  <tr>
    <td class="lmoCaption" colspan="6"><?php echo lmo_tipp_bt(318, 'Backup manager'); ?></td>
  </tr>
  <tr>
    <td colspan="6"><?php echo lmo_tipp_bt(319, 'Saves the tip folder (tips, evaluations, insight, club ranking) and the file with the tipper data as a ZIP file. The backups can be downloaded here.'); ?></td>
  </tr><?php
foreach ($backup_msgs as $m) {?>
  <tr>
    <td colspan="6"><?php echo getMessage(htmlspecialchars($m[0]), $m[1]); ?></td>
  </tr><?php
}?>
  <tr>
    <td colspan="6" align="center">
      <form action="<?php echo $backup_self; ?>" method="post">
        <input type="hidden" name="sb_action" value="create">
        <input type="hidden" name="sb_token" value="<?php echo htmlspecialchars($backup_token); ?>">
        <input class="lmo-formular-button" type="submit" value="<?php echo htmlspecialchars(lmo_tipp_bt(320, 'Create backup')); ?>">
      </form>
    </td>
  </tr>
  <tr>
    <td colspan="6"><small><?php echo lmo_tipp_bt(333, 'Note: the backups contain the tipper data (access data, e-mail addresses). Keep downloaded files confidential.'); ?></small></td>
  </tr>
  <tr>
    <td class="lmoCaption" colspan="6"><?php echo lmo_tipp_bt(339, 'Settings'); ?></td>
  </tr>
  <tr>
    <td colspan="6">
      <form action="<?php echo $backup_self; ?>" method="post">
        <input type="hidden" name="sb_action" value="settings">
        <input type="hidden" name="sb_token" value="<?php echo htmlspecialchars($backup_token); ?>">
        <label><input type="checkbox" name="sb_auto" value="1"<?php echo $backup_set['auto'] ? ' checked' : ''; ?>> <?php echo lmo_tipp_bt(340, 'Create a backup automatically before every evaluation in the admin area'); ?></label><br>
        <label><?php echo lmo_tipp_bt(341, 'Keep automatic backups (number, 0 = keep all):'); ?> <input type="number" name="sb_keep" min="0" max="1000" size="4" value="<?php echo (int)$backup_set['keep']; ?>" style="width:5em"></label>
        <br><label><?php echo lmo_tipp_bt(391, 'Delete log entries after (days, 0 = never):'); ?> <input type="number" name="sb_logdays" min="0" max="3650" value="<?php echo (int)$backup_set['logdays']; ?>" style="width:5em"></label>
        <input class="lmo-formular-button" type="submit" value="<?php echo htmlspecialchars(lmo_tipp_bt(342, 'Save settings')); ?>">
      </form>
    </td>
  </tr>
  <tr>
    <td class="lmoCaption" colspan="6"><?php echo lmo_tipp_bt(344, 'Upload backup'); ?></td>
  </tr>
  <tr>
    <td colspan="6">
      <form action="<?php echo $backup_self; ?>" method="post" enctype="multipart/form-data">
        <input type="hidden" name="sb_action" value="upload">
        <input type="hidden" name="sb_token" value="<?php echo htmlspecialchars($backup_token); ?>">
        <input type="file" name="sb_file" accept=".zip,application/zip">
        <input class="lmo-formular-button" type="submit" value="<?php echo htmlspecialchars(lmo_tipp_bt(346, 'Upload')); ?>">
        <br><small><?php echo lmo_tipp_bt(345, 'Only ZIP files created with this backup manager. The file is checked completely before it is accepted.'); ?></small>
      </form>
    </td>
  </tr>
  <tr>
    <td class="lmoCaption" colspan="6"><?php echo lmo_tipp_bt(321, 'Existing backups'); ?></td>
  </tr><?php
$backup_list = lmo_tipp_backup_list();
if (!$backup_list) {?>
  <tr><td colspan="6"><?php echo lmo_tipp_bt(322, 'No backups yet.'); ?></td></tr><?php
} else {?>
  <tr>
    <th align="left"><?php echo lmo_tipp_bt(323, 'Date'); ?></th>
    <th align="left"><?php echo lmo_tipp_bt(334, 'Type'); ?></th>
    <th align="right"><?php echo lmo_tipp_bt(352, 'Files'); ?></th>
    <th align="right"><?php echo lmo_tipp_bt(324, 'Size'); ?></th>
    <th align="left" colspan="2">&nbsp;</th>
  </tr><?php
    foreach ($backup_list as $backup_b) {?>
  <tr>
    <td><?php echo date('d.m.Y H:i:s', $backup_b['time']); ?></td>
    <td><?php echo htmlspecialchars($backup_types[$backup_b['type']]); ?></td>
    <td align="right"><?php echo $backup_b['files'] >= 0 ? $backup_b['files'] : '?'; ?></td>
    <td align="right"><?php echo lmo_tipp_backup_size($backup_b['size']); ?></td>
    <td><a href="<?php echo URL_TO_ADDONDIR . '/tipp/lmo-tippbackupdl.php?file=' . rawurlencode($backup_b['name']) . '&amp;t=' . rawurlencode($backup_token); ?>"><?php echo lmo_tipp_bt(325, 'Download'); ?></a>
      | <a href="<?php echo $backup_self . '&amp;sb_restore=' . rawurlencode($backup_b['name']); ?>"><?php echo lmo_tipp_bt(338, 'Restore'); ?></a></td>
    <td>
      <form action="<?php echo $backup_self; ?>" method="post" onsubmit="return confirm(<?php echo htmlspecialchars(json_encode(lmo_tipp_bt(332, 'Really delete this backup?')), ENT_QUOTES); ?>);">
        <input type="hidden" name="sb_action" value="delete">
        <input type="hidden" name="sb_name" value="<?php echo htmlspecialchars($backup_b['name']); ?>">
        <input type="hidden" name="sb_token" value="<?php echo htmlspecialchars($backup_token); ?>">
        <input class="lmo-formular-button" type="submit" value="<?php echo htmlspecialchars(lmo_tipp_bt(326, 'Delete')); ?>">
      </form>
    </td>
  </tr><?php
    }
}
lmo_tipp_backup_log_prune();
$backup_log = lmo_tipp_backup_log_read(20);?>
  <tr>
    <td class="lmoCaption" colspan="6"><?php echo lmo_tipp_bt(349, 'Log'); ?></td>
  </tr><?php
if (!$backup_log) {?>
  <tr><td colspan="6"><?php echo lmo_tipp_bt(315, 'No entries yet.'); ?></td></tr><?php
} else {?>
  <tr>
    <th align="left"><?php echo lmo_tipp_bt(323, 'Date'); ?></th>
    <th align="left">Admin</th>
    <th align="left"><?php echo lmo_tipp_bt(350, 'Action'); ?></th>
    <th align="left" colspan="3"><?php echo lmo_tipp_bt(351, 'File'); ?></th>
  </tr><?php
    foreach ($backup_log as $l) {?>
  <tr>
    <td><?php echo htmlspecialchars($l[0]); ?></td>
    <td><?php echo htmlspecialchars($l[1]); ?></td>
    <td><?php echo htmlspecialchars($l[2]); ?></td>
    <td colspan="3"><small><?php echo htmlspecialchars($l[3] . ($l[4] !== '' ? ' (' . $l[4] . ')' : '')); ?></small></td>
  </tr><?php
    }?>
  <tr>
    <td colspan="6" align="right">
      <form action="<?php echo $backup_self; ?>" method="post" onsubmit="return confirm(<?php echo htmlspecialchars(json_encode(lmo_tipp_bt(393, 'Really delete the whole log?')), ENT_QUOTES); ?>);">
        <input type="hidden" name="sb_action" value="clearlog">
        <input type="hidden" name="sb_token" value="<?php echo htmlspecialchars($backup_token); ?>">
        <input class="lmo-formular-button" type="submit" value="<?php echo htmlspecialchars(lmo_tipp_bt(392, 'Delete log')); ?>">
      </form>
    </td>
  </tr><?php
}?>
</table>
