<?PHP
// 
// LigaManager Online 3.02b
// Copyright (C) 1997-2002 by Frank Hollwitz
// webmaster@hollwitz.de / http://php.hollwitz.de
// 
// This program is free software; you can redistribute it and/or
// modify it under the terms of the GNU General Public License as
// published by the Free Software Foundation; either version 2 of
// the License, or (at your option) any later version.
// 
// This program is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
// General Public License for more details.
// 
// You should have received a copy of the GNU General Public License
// along with this program; if not, write to the Free Software
// Foundation, Inc., 675 Mass Ave, Cambridge, MA 02139, USA.
// 
require_once(PATH_TO_LMO."/lmo-admintest.php");

$lmo_auth_file=PATH_TO_LMO."/lmo-auth.txt";
$lmo_admin_data = array();
$datei = fopen($lmo_auth_file,"rb");
if ($datei) {
  while ($data=fgetcsv($datei,10000,'|')) {
    if (count($data)>1) $lmo_admin_data[]=$data;   //[0]=Name, [1]=Passwort, [2]=Rang, [3]=Ligen
  }
  fclose($datei);
}else{
  echo "<font color=\"#ff0000\">".$text[283]."</font>";
  exit;
}

?>