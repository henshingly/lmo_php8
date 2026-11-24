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

/**
 * Download einer Tippspiel-Sicherung (nur Voll-Admin, mit Token).
 * Aufruf: lmo-tippbackupdl.php?file=<Sicherungsname>&t=<Token>
 */

require_once(__DIR__ . '/../../init.php');
require_once(__DIR__ . '/lmo-tippbackup.php');

$name = isset($_GET['file']) ? $_GET['file'] : '';
$token = isset($_GET['t']) ? $_GET['t'] : '';
if (!isset($_SESSION['lmouserok']) || $_SESSION['lmouserok'] != 2 || !lmo_tipp_backup_token_ok($token) || !lmo_tipp_backup_valid_name($name)) {
    http_response_code(403);
    exit('No permission');
}
$path = lmo_tipp_backup_dir() . '/' . $name;
if (!is_file($path)) {
    http_response_code(404);
    exit('Not found');
}
lmo_tipp_backup_log('download', $name);
while (ob_get_level() > 0) {
    ob_end_clean();
}
header('Content-Type: application/zip');
header('Content-Disposition: attachment; filename="' . $name . '"');
header('Content-Length: ' . filesize($path));
header('Cache-Control: private, no-store');
header('X-Content-Type-Options: nosniff');
readfile($path);
exit;
