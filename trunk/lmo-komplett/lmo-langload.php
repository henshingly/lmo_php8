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
$langfiles=array("lang.txt","lang-{$lmouserlang}.txt");

$addonlang=explode(",",$diraddon);             // Addons 
foreach($addonlang as $a) {
  if(substr($a,-1)!='/') $a.='/';             // Slash hinzufügen falls nicht vorhanden
  $addon_langfile=$a."lang.txt";                //Dateiname der Addonlangdatei
  if (file_exists($addon_langfile)) $langfiles[]=$addon_langfile;        // Standardlangdatei des Addons
  $addon_newlangfile=$a."lang-{$lmouserlang}.txt";
  if (file_exists($addon_newlangfile)) $langfiles[]=$addon_newlangfile;  // Andere Langdatei laden
}

$text=array();
for ($i=0;$i<count($langfiles);$i++) {
	if ($datei = @file($langfiles[$i])) {
		($dir=dirname($langfiles[$i]))!="."?$praefix=$dir."_":$praefix="";     // Präfix für Addon-langdateien
    foreach ($datei as $value) {
      $paar=explode('=',trim($value),2);
      if (isset($paar[0]) && is_numeric($paar[0])) {
        if (!isset($paar[1])) $paar[1]="";
        ${$praefix."text"}[intval($paar[0])]=$paar[1];
	    }
	  }
  }
}
$orgpkt=$text[37];
$orgtor=$text[38];
?>