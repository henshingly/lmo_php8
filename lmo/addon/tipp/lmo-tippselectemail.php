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
$dumma = array();
$pswfile = PATH_TO_ADDONDIR . '/tipp/' . $tipp_tippauthtxt;

$dumma = [];

if (file_exists($pswfile)) {
    $dumma = file($pswfile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
}

sort($dumma, SORT_STRING);

foreach ($dumma as $line) {

    // PHP-Zeile überspringen
    if (str_starts_with(trim($line), '<?php')) {
        continue;
    }

    $dummb = explode('|', $line);

    if (count($dummb) < 2) {
        continue; // ungültige Zeile
    }

    $nick = $dummb[0] ?? '';
    $name = $dummb[3] ?? '';
    $email = $dummb[4] ?? '';

    echo '<option value="' . $nick . '">';
    echo $nick . ' (' . $name.' - ' . $email . ')';
    echo '</option>';
}
?>