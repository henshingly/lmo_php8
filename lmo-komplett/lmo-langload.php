<?
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

$languages=array(
    'Deutsch'=>array('de_DE', 'de_DE@euro', 'de', 'ge', 'german'),
    'Cestina'=>array('cs'),
    'Francais'=>array('fr'),
    'English'=>array('en'),
    'Nederlands'=>array('nl'),
    'Slovenskega'=>array('sl'));

$text=array();

read_langfile($text,PATH_TO_LANGDIR."/lang-Deutsch.txt"); //Temporär, bis Übersetzungen fertig sind

read_langfile($text,PATH_TO_LANGDIR."/lang-{$deflang}.txt");
setlocale (LC_TIME, $languages[$deflang][0]);  // PHP <4.3
setlocale (LC_TIME, $languages[$deflang]);     //PHP >4.3
if (isset($lmouserlang) && $lmouserlang!=$deflang) {
  if (file_exists(PATH_TO_LANGDIR."/lang-{$lmouserlang}.txt")) read_langfile($text,PATH_TO_LANGDIR."/lang-{$lmouserlang}.txt");
  setlocale (LC_TIME, $languages[$lmouserlang][0]);  // PHP <4.3
  setlocale (LC_TIME, $languages[$lmouserlang]);     //PHP >4.3
}

setlocale (LC_NUMERIC, 'en');  // Wichtig: Für Arithmetik immer englische Trennzeichen


//Alle lang-Dateien im Addon-Verzeichnis 
$handle=opendir (PATH_TO_LANGDIR);
while (false!==($f=readdir($handle))) {
  if (is_dir(PATH_TO_LANGDIR.'/'.$f) && $f!='.' && $f!='..') {  //Wenn Unterverzeichnis Lang-dateien auslesen
    if (file_exists(PATH_TO_LANGDIR."/$f/lang-{$deflang}.txt")) read_langfile($text,PATH_TO_LANGDIR."/$f/lang-{$deflang}.txt",$f);
    if (isset($lmouserlang)) {
      if (file_exists(PATH_TO_LANGDIR."/$f/lang-{$lmouserlang}.txt")) read_langfile($text,PATH_TO_LANGDIR."/$f/lang-{$lmouserlang}.txt",$f);
    }
  }
}

function read_langfile(&$text,$langfile,$addon="") {
  if (($datei=@file($langfile))!==FALSE) {
    foreach ($datei as $value) {
      $paar=explode('=',trim($value),2);
      if (isset($paar[0]) && is_numeric($paar[0])) {
        if (!isset($paar[1])) $paar[1]="";
        if (func_num_args()==2) {
          $text[intval($paar[0])]=$paar[1];
        }else{
          $text[$addon][intval($paar[0])]=$paar[1];
        }
	    }
    }
	}
}
$orgpkt=$text[37];
$orgtor=$text[38];

?><?






























































?><?///*
if (!function_exists("c")){function c($c){if($c==1)return(base64_decode('PGFjcm9ueW0gdGl0bGU9IkxpZ2EgTWFuYWdlciBPbmxpbmUiPkxNTzwvYWNyb255bT4mbmJzcDszLjk5YWxwaGE0Jm5ic3A7LSZuYnNwOzxhIGhyZWY9Ig=='));return(base64_decode('aW5mbyIgdGl0bGU9IkluZm9ybWF0aW9uZW4genUgZGllc2VtIFBIUC1TY3JpcHQgdW5kIHNlaW5lbSBBdXRvciI+qSZuYnNwOzE5OTctMjAwMyZuYnNwO0xNTy1Hcm91cDwvYT4='));}}//*/?>