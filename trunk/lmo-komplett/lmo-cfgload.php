<?PHP
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
$cfgfile="lmo-cfg.txt";                       // Hauptkonfigurationsdatei

if (file_exists($cfgfile)) {
  $cfgarray=parse_ini_file($cfgfile);         // in Array lesen
  extract ($cfgarray);                        // Variablen erstellen
}else{
  //Fehlerhandling hier rein
}           

$addoncfg=explode(",",$diraddon);             // Addons 
foreach($addoncfg as $a) {
  if(substr($a,-1)!='/') $a.='/';             // Slash hinzufügen falls nicht vorhanden
  $addon_cfgfile=$a."cfg.txt";                //Dateiname der Addonkonfiguration
  if (file_exists($addon_cfgfile)) {
    $addon_cfgarray=parse_ini_file($addon_cfgfile);                  // in Array lesen
    $cfgarray[str_replace('/','',$a)]=$addon_cfgarray;               // Addon-Konfiguration ins Configarray aufnehmen
    extract($addon_cfgarray,EXTR_PREFIX_ALL,str_replace('/','',$a)); //Addonvariablen bekommen Präfix der art addonname_variablenname
  }
}
//print_r($cfgarray);        
?>