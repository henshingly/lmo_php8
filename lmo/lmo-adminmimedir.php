<?
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
  
  
require_once(PATH_TO_LMO."/lmo-admintest.php");
$addi = URL_TO_LMO."/lmo-adminmimesend.php?action=admin&amp;todo=email&amp;down=";
if ($ftype != "") {
  $verz = opendir(substr($dirliga, 0, -1));
  $dummy = array("");
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
  echo"<ul>";
  for($k = 0; $k < count($dummy); $k++) {
    $files = $dummy[$k];
    if ($_SESSION['lmouserok'] == 2) {
      $ftest = 1;
    } elseif($_SESSION['lmouserok'] == 1) {
      $ftest = 0;
      $ftest1 = explode(',', $_SESSION['lmouserfile']);
      if (isset($ftest1)) {
        for($u = 0; $u < count($ftest1); $u++) {
          if ($ftest1[$u].".l98" == $files) {
            $ftest = 1;
          }
        }
      }
    }
    if ($ftest == 1) {
      $sekt = "";
      $t0 = "";
      $datei = fopen($dirliga.$files, "rb");
      while (!feof($datei)) {
        $zeile = fgets($datei, 1000);
        $zeile = chop($zeile);
        $zeile = trim($zeile);
        if ((substr($zeile, 0, 1) == "[") && (substr($zeile, -1) == "]")) {
          $sekt = substr($zeile, 1, -1);
        } elseif((strpos($zeile, "=") != false) && (substr($zeile, 0, 1) != ";") && ($sekt == "Options")) {
          $schl = substr($zeile, 0, strpos($zeile, "="));
          $wert = substr($zeile, strpos($zeile, "=")+1);
          if ($schl == "Name") {
            $t0 = $wert;
            break;
          }
        }
      }
      fclose($datei);
      $i++;
      if ($t0 == "") {
        $j++;
        $t0 = $text[507]." $j";
      }
      echo "<li><a target='lmoelm' href='{$addi}".($k+1)."' onclick='emllmolink(this.href,\"{$aadr}\");return false;'>{$t0}</a></li>";
    }
  }
  if ($i == 0) {
    echo "<li>[{$text[223]}]</li>";
  } elseif(($i > 1) && ($_SESSION['lmouserok'] == 2)) {
    echo "<li><a target='lmoelm' href='{$addi}-1' onclick='emllmolink(this.href,\"{$aadr}\");return false;'><strong>{$text[401]}</strong></a></li>";
  }
  echo"</ul>";
}

?>