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
$addi = $_SERVER['PHP_SELF']."?action=admin&amp;todo=edit&amp;file=";
if ($ftype != "") {
  $verz = opendir(substr(PATH_TO_LMO."/".$dirliga, 0, -1));
  $dummy = array();
  while ($files = readdir($verz)) {
    if (strtolower(substr($files, -4)) == $ftype) {
      $dummy[] = $files;
    }
  }
  closedir($verz);
  sort($dummy);
  $i = 0;
  $j = 0;
  for($k = 0; $k < count($dummy); $k++) {
    $files = $dummy[$k];
    $sekt = "";
    $t0 = "";
    $t1 = "";
    $t2 = "";
    $t3 = "";
    $t4 = "0";
    $datei = fopen($dirliga.$files, "rb");
    while (!feof($datei)) {
      $zeile = fgets($datei, 5000);
      $zeile = trim($zeile);
      if ((substr($zeile, 0, 1) == "[") && (substr($zeile, -1) == "]")) {
        $sekt = substr($zeile, 1, -1);
      } elseif((strpos($zeile, "=") != false) && (substr($zeile, 0, 1) != ";") && ($sekt == "Options")) {
        $schl = substr($zeile, 0, strpos($zeile, "="));
        $wert = substr($zeile, strpos($zeile, "=")+1);
        if ($schl == "Name") {
          $t0 = $wert;
        }
        if ($schl == "Teams") {
          $t1 = $wert;
        }
        if ($schl == "Rounds") {
          $t2 = $wert;
        }
        if ($schl == "Matches") {
          $t3 = $wert;
        }
        if ($schl == "Type") {
          $t4 = $wert;
        }
      }
      if (!empty($t0) && !empty($t1) && !empty($t2) && !empty($t3) && !empty($t4)) {
        break;
      }
    }
    fclose($datei);
    if (($t1 == $xteams) && ($t2 == $xanzst) && ($t3 == $xanzsp) && ($t4 == $xtype)) {
      $i++;
      if ($t0 == "") {
        $j++;
        $t0 = $text[507].$j;
      }
      echo "<input type='radio' name='xprogram' value='".PATH_TO_LMO."/".$dirliga.$files."'";
      if ($xprogram == PATH_TO_LMO."/".$dirliga.$files) {
        echo " checked";
      }
      echo " onChange=\"dolmoedit()\">".$t0."<br>";
    }
  }
  if ($i == 0) {
    echo "[".$text[224]."]<br>";
  }
}

?>