<?PHP
// 
// LigaManager Online 3.02b
// Copyright (C) 1997-2002 by Frank Hollwitz
// webmaster@hollwitz.de / http://php.hollwitz.de
// 
// LigaManager Online
// Edited by: Rene Marth
// 29.08.2003
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

// Langdateien laden (zuerst Standarddatei, wenn vorhanden werden die alten Werte 
// von der neuen Sprache überschrieben (So werden auch unvollständige Übersetzungen 
// akzeptiert)

$text=array();
$text+=read_langfile(PATH_TO_LMO."/lang.txt");
if (isset($lmouserlang)) {
  if (file_exists(PATH_TO_LMO."/lang-{$lmouserlang}.txt")) $text+=read_langfile(PATH_TO_LMO."/lang-{$lmouserlang}.txt");
}

//Alle lang-Dateien im Addon-Verzeichnis 
$handle=opendir (PATH_TO_ADDON_DIR);     //Addonverzeichnis auslesen
while (false!==($f=readdir($handle))) {
  if (is_dir(PATH_TO_ADDON_DIR.'/'.$f) && $f!='.' && $f!='..') {   //Wenn Unterverzeichnis Lang-dateien auslesen
    if (file_exists(PATH_TO_ADDON_DIR."/$f/lang.txt")) $text[$f]=read_langfile(PATH_TO_ADDON_DIR."/$f/lang.txt");
    if (isset($lmouserlang)) {
      if (file_exists(PATH_TO_ADDON_DIR."/$f/lang-{$lmouserlang}.txt")) $text[$f]+=read_langfile(PATH_TO_ADDON_DIR."/$f/lang-{$lmouserlang}.txt");
    }
  }
}

function read_langfile($langfile) {
  $ret=array();
	if (($datei=@file($langfile))!==FALSE) {
    foreach ($datei as $value) {
      $paar=explode('=',trim($value),2);
      if (isset($paar[0]) && is_numeric($paar[0])) {
        if (!isset($paar[1])) $paar[1]="";
          $ret[intval($paar[0])]=$paar[1];
	    }
    }
	}
  return $ret;
}
$orgpkt=$text[37];
$orgtor=$text[38];
?>