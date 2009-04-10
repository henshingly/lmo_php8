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
  * $id$
  */
  
  
require_once(PATH_TO_LMO."/lmo-admintest.php");

$lmo_auth_file=PATH_TO_CONFIGDIR."/lmo-auth.php";
$lmo_admin_data = array();
$datei = fopen($lmo_auth_file,"rb");
if ($datei) {
  while ($data=fgetcsv($datei,10000,'|')) {
    if (count($data)>1) $lmo_admin_data[]=$data;   //[0]=Name, [1]=Passwort, [2]=Rang, [3]=Ligen, [4]=Erweiterter Hilfsadmin
  }
  fclose($datei);
}else{
  echo getMessage($text[283],TRUE);
  exit;
}

?>