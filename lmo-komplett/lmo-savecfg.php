<?
// 
// LigaManager Online 3.02b
// Copyright (C) 1997-2002 by Frank Hollwitz
// webmaster@hollwitz.de / http://php.hollwitz.de
// 
// LigaManager Online
// Edited by: Rene Marth
// 28.08.2003
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
  $ok=true;
  $datei = fopen($cfgfile,"wb");
  if ($datei) {
    flock($datei,LOCK_EX);
    foreach($cfgarray as $cfgname => $cfgvalue) {
      if (is_array($cfgvalue)) {                         // Addonvariablen
        $addon_datei = fopen(PATH_TO_CONFIGDIR.'/'.$cfgname.'/cfg.txt',"wb");  //Addondatei
        if ($addon_datei) {
          $ok=flock($datei,LOCK_EX) && $ok;
          foreach($cfgvalue as $addon_cfgname => $addon_cfgvalue) {
            //echo "<pre>".$addon_datei.":".$addon_cfgname."=".${$cfgname."_".$addon_cfgname}."</pre>";
            $ok=fwrite($addon_datei, $addon_cfgname."=".${$cfgname."_".$addon_cfgname}."\n") && $ok;
          }
          flock($addon_datei,LOCK_UN);
          fclose($addon_datei);
          clearstatcache();
        }
      }else{                                             // Hauptkonfiguration
        $ok=fwrite($datei, "$cfgname=${$cfgname}\n") && $ok;
      }
    }
    flock($datei,LOCK_UN);
    fclose($datei);
    clearstatcache();
  }else{
    $ok=false;
  }
  if ($ok) {
    echo getMessage($text[138]);
  } else {
    echo getMessage($text[283],TRUE);
  }
}
?>