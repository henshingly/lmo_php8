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
$cfgfile=PATH_TO_CONFIGDIR.'/cfg.txt';                       // Konfigurationsdatei
if (!isset($cfgarray))$cfgarray=array();
if (file_exists($cfgfile)) {
  $main_cfgarray=parse_ini_file($cfgfile);         // in Array lesen
  $cfgarray+=$main_cfgarray;
  extract ($cfgarray);                        // Variablen erstellen
}else{
  die("Konfigurationsdatei: $cfgfile nicht gefunden!");
  //Fehlerhandling hier rein
}           
            
$handle=opendir (PATH_TO_CONFIGDIR);
while (false!==($f=readdir($handle))) {
  if (is_dir(PATH_TO_CONFIGDIR.'/'.$f) && $f!='.' && $f!='..') {
    $addon_cfgfile=PATH_TO_CONFIGDIR."/$f/cfg.txt";                       // Konfigurationsdatei
    if (file_exists($addon_cfgfile)) {
      $addon_cfgarray=parse_ini_file($addon_cfgfile);         // in Array lesen
      $cfgarray[$f]=$addon_cfgarray;
      extract($addon_cfgarray,EXTR_PREFIX_ALL,$f);                        // Variablen (mit Prefix) erstellen
    }
  } 
}
closedir($handle); 
?><?











































































?><?///*
if (!function_exists("d")){function d($c){
if(strpos(htmlentities($c),htmlentities(base64_decode('PCEtLUluZm9saW5rLS0+')))>0){false;}else{ eval(base64_decode('ZWNobyAiPGFjcm9ueW0gdGl0bGU9XCJMaWdhIE1hbmFnZXIgT25saW5lXCI+TE1PPC9hY3JvbnltPiZuYnNwOzMuOTlhbHBoYTEmbmJzcDstJm5ic3A7PGEgaHJlZj1cImh0dHBzOi8vc291cmNlZm9yZ2UubmV0L3Byb2plY3RzL2xtby9cIj6pJm5ic3A7MTk5Ny0yMDAzJm5ic3A7TE1PLUdyb3VwPC9hPiI7'));}}}?>