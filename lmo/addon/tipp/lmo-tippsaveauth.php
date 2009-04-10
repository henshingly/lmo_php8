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


if ($action == "tipp") {
  require_once(PATH_TO_ADDONDIR."/tipp/lmo-tipptest.php");
} elseif($action == "admin") {
  require_once(PATH_TO_LMO."/lmo-admintest.php");
}

$datei = fopen($pswfile, "wb");
if (!$datei) {
  echo getMessage($text[283],TRUE);
  exit;
} else {
  echo getMessage($text[138]);
}
flock($datei, LOCK_EX);
for($i = 1; $i < count($users); $i++) {
  fputs($datei, trim($users[$i])."\n");
}
flock($datei, LOCK_UN);
fclose($datei);
clearstatcache();

?>