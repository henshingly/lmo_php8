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

require_once(PATH_TO_LMO . '/lmo-admintest.php');
$addi = URL_TO_LMO . '/lmo-admindownload.php?action=admin&amp;todo=download&amp;down=';
if ($ftype != '') {
    $verz = opendir(substr($dirliga, 0, -1));
    $dummy = array('');
    while ($files = readdir($verz)) {
        if (strtolower(substr($files, -4)) == $ftype) {
            array_push($dummy, $files);
        }
    }
    closedir($verz);
    array_shift($dummy);
    sort($dummy);
    $i = 0;
    $j = 0;
?>
                  <ul>
<?php
    for ($k = 0; $k < count($dummy); $k++) {
        $files = $dummy[$k];
        if ($_SESSION['lmouserok'] == 2) {
            $ftest = 1;
        }
        elseif ($_SESSION['lmouserok'] == 1) {
            $ftest = 0;
            $ftest1 = explode(',', $_SESSION['lmouserfile']);
            if (isset($ftest1)) {
                for ($u = 0; $u < count($ftest1); $u++) {
                    if ($ftest1[$u] . '.l98' == $files) {
                        $ftest = 1;
                    }
                }
            }
        }
        if ($ftest == 1) {
            // Abschnitt [Options] der Ligadatei (Lmo\Liga\LigaDatei)
            $t0 = \Lmo\Liga\LigaDatei::liesAbschnitt($dirliga . $files, 'Options')['Name'] ?? '';
            $i++;
            if ($t0 == '') {
                $j++;
                $t0 = $text[223] . ' ' . $j;
            }?>
                    <li><a href="<?php echo $addi . ($k + 1); ?>"><?php echo $t0; ?></a></li>
<?php
        }
    }
    if ($i == 0) {?>
                    <li>[<?php echo $text[223]; ?>]</li>
<?php
    }
    elseif (($i > 1) && ($_SESSION['lmouserok'] == 2)) {?>
                    <li><a href="<?php echo $addi; ?>-1"><strong><?php echo $text[402]; ?></strong></a></li>
<?php
    }?>
                  </ul><?php
}
