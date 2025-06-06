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

session_start();
require(__DIR__ . '/init.php');
$action = isset($_GET['action']) ? $_GET['action'] : '';
$todo = isset($_GET['todo']) ? $_GET['todo'] : '';
$down = isset($_GET['down']) ? $_GET['down'] : 0;
if (($action == 'admin') && ($todo == 'download') && (($_SESSION['lmouserok'] == 1) || ($_SESSION['lmouserok'] == 2))) {
    if ($down > 0) {
        $ftype = '.l98';
        $verz = opendir(substr($dirliga, 0, -1));
        $dummy = array();
        while ($files = readdir($verz)) {
            if (strtolower(substr($files, -4)) == $ftype) {
                array_push($dummy, $files);
            }
        }
        closedir($verz);
        sort($dummy);
        if ($dummy[(int) $down - 1] != '' && check_hilfsadmin($dummy[(int) $down - 1])) {
            header('Content-Type: text/x-lmo4');
            header('Content-Disposition: attachment; filename="' . $dummy[$down - 1] . '"');
            readfile(sprintf('%s/%s', $dirliga, $dummy[$down - 1]));
        }
    }
    elseif ($down == -1) {
        $ftype = '.l98';
        $verz = opendir(substr($dirliga, 0, -1));
        $dummy = array();
        while ($files = readdir($verz)) {
            if (strtolower(substr($files, -4)) == $ftype) {
                array_push($dummy, $files);
            }
        }
        closedir($verz);
        sort($dummy);
        if (count($dummy) > 0) {
            $zipfile = new zipArchive;
            $zip = $zipfile->open('ligen.zip', ZipArchive::CREATE);
            for ($i = 0; $i < count($dummy); $i++) {
                if (check_hilfsadmin($dummy[$i])) {
                    $zipfile->addFile(PATH_TO_LMO . '/' . $dirliga . $dummy[$i], $dummy[$i]);
                }
            }
            $zipfile->close();
            header('Content-Type: application/zip');
            header('Content-Disposition: attachment; filename="ligen.zip"');
            readfile('ligen.zip');
            unlink('ligen.zip');
        }
    }
}
?>