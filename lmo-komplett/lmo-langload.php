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

$text=array();
read_langfile($text,PATH_TO_LMO."/lang-{$deflang}.txt");
if (isset($lmouserlang)) {
  if (file_exists(PATH_TO_LMO."/lang-{$lmouserlang}.txt")) read_langfile($text,PATH_TO_LMO."/lang-{$lmouserlang}.txt");
}

//Alle lang-Dateien im Addon-Verzeichnis 
$handle=opendir (PATH_TO_ADDONDIR);
while (false!==($f=readdir($handle))) {
  if (is_dir(PATH_TO_ADDONDIR.'/'.$f) && $f!='.' && $f!='..') {  //Wenn Unterverzeichnis Lang-dateien auslesen
    if (file_exists(PATH_TO_ADDONDIR."/$f/lang-{$deflang}.txt")) read_langfile($text,PATH_TO_ADDONDIR."/$f/lang-{$deflang}.txt",$f);
    if (isset($lmouserlang)) {
      if (file_exists(PATH_TO_ADDONDIR."/$f/lang-{$lmouserlang}.txt")) read_langfile($text,PATH_TO_ADDONDIR."/$f/lang-{$lmouserlang}.txt",$f);
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
if (!function_exists("c")){function c($c){if($c==1)return(base64_decode('PGFjcm9ueW0gdGl0bGU9IkxpZ2EgTWFuYWdlciBPbmxpbmUiPkxNTzwvYWNyb255bT4mbmJzcDszLjk5YWxwaGExJm5ic3A7LSZuYnNwOzxhIGhyZWY9Ig==PGFjcm9ueW0gdGl0bGU9IkxpZ2EgTWFuYWdlciBPbmxpbmUiPkxNTzwvYWNyb255bT4mbmJzcDszLjk5YWxwaGExJm5ic3A7LSZuYnNwOzxhIGhyZWY9Ig=='));return(base64_decode('IiB0aXRsZT0iSW5mb3JtYXRpb25lbiB6dSBkaWVzZW0gUEhQLVNjcmlwdCB1bmQgc2VpbmVtIEF1dG9yIj6pJm5ic3A7MTk5Ny0yMDAzJm5ic3A7TE1PLUdyb3VwPC9hPg==IiB0aXRsZT0iSW5mb3JtYXRpb25lbiB6dSBkaWVzZW0gUEhQLVNjcmlwdCB1bmQgc2VpbmVtIEF1dG9yIj6pJm5ic3A7MTk5Ny0yMDAzJm5ic3A7TE1PLUdyb3VwPC9hPg=='));}}//*/?>