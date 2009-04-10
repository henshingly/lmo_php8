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
  * $Id$
  */
  
  
require_once(PATH_TO_LMO."/lmo-admintest.php");
if($_SESSION['lmouserok']==2){
  $lmo_auth_file=PATH_TO_CONFIGDIR."/lmo-auth.php";
  
  $datei = fopen($lmo_auth_file,"wb");
  if ($datei) {
    flock($datei,LOCK_EX);
    fwrite($datei,"<?php exit(); ?>\n");
    foreach($lmo_admin_data as $lmo_admin) {
      if (count($lmo_admin)>1) fputs($datei,implode("|",$lmo_admin)."\n");
    }
    flock($datei,LOCK_UN);
    echo getMessage($text[138]);
  }else{
      echo getMessage($text[283],TRUE);
  }
}
?>