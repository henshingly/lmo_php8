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
if($_SESSION['lmouserok']==2){
  $lmo_auth_file=PATH_TO_LMO."/lmo-auth.txt";
  
  $datei = fopen($lmo_auth_file,"wb");
  if ($datei) {
    flock($datei,LOCK_EX);
    foreach($lmo_admin_data as $lmo_admin) {
      if (count($lmo_admin)>1) fputs($datei,implode("|",$lmo_admin)."\n");
    }
    flock($datei,LOCK_UN);
    echo "<p class='message'>".$text[138]."</p>";
  }else{
      echo "<p class='error'>".$text[283]."</p>";
  }
}
?>