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
$dumma = array();
$pswfile = PATH_TO_ADDONDIR."/tipp/".$tipp_tippauthtxt;
if ($datei = fopen($pswfile, "rb")) {
  while (!feof($datei)) {
    $zeile = fgets($datei, 1000);
    $zeile = chop($zeile);
    if ($zeile != "") {
      array_push($dumma, $zeile);
    }
  }
  fclose($datei);
}
 
sort($dumma, SORT_STRING);
for($i = 0; $i < count($dumma); $i++) {
  $dummb = explode("|", $dumma[$i]);
  echo "<option value=\"".$dummb[0]."\" ";
  echo ">".$dummb[0]." (".$dummb[3]." - ".$dummb[4].")"."</option>";
}

?>