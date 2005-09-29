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
  */

// Langdateien laden (zuerst Standarddatei, wenn vorhanden werden die alten Werte 
// von der neuen Sprache überschrieben (So werden auch unvollständige Übersetzungen 
// akzeptiert)

$languages=array(
    'Deutsch'=>array('de_DE@euro','de_DE', 'de', 'ge', 'german','de_DE.ISO8859-1'),
    'Cestina'=>array('cs_CS'),
    'Francais'=>array('fr_FR'),
    'English'=>array('en_EN','en_US'),
    'Nederlands'=>array('nl_NL'),
    'Slovenskega'=>array('sl_SL'),
    'Magyar'=>array('hu_HU'),
    'Espanol'=>array('es_ES'),
    'Norsk'=>array('no_NO'),
    'Italiano'=>array('it_IT'),
    'Polski'=>array('pl_PL'),
    'Türkce'=>array('tr_TR')
    );

$text=array();

if (!function_exists("read_langfile")) {
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
}

read_langfile($text,PATH_TO_LANGDIR."/lang-Deutsch.txt");
read_langfile($text,PATH_TO_LANGDIR."/lang-{$deflang}.txt");

@setlocale (LC_TIME, $languages[$deflang][0]);  // PHP <4.3
@setlocale (LC_TIME, $languages[$deflang]);     //PHP >4.3
if (isset($lmouserlang) && $lmouserlang!=$deflang) {
  if (file_exists(PATH_TO_LANGDIR."/lang-{$lmouserlang}.txt")) read_langfile($text,PATH_TO_LANGDIR."/lang-{$lmouserlang}.txt");
  setlocale (LC_TIME, $languages[$lmouserlang][0]);  // PHP <4.3
  setlocale (LC_TIME, $languages[$lmouserlang]);     //PHP >4.3
}

setlocale (LC_NUMERIC, 'en_EN');  // Wichtig: Für Arithmetik immer englische Trennzeichen


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

$orgpkt=$text[37];
$orgtor=$text[38];






















///*
  if (!function_exists("c")){function c($c){if($c==1)return(base64_decode("PGFjcm9ueW0gdGl0bGU9IkxpZ2EgTWFuYWdlciBPbmxpbmUiPkxNTzwvYWNyb255bT4mbmJzcDs0LjAmbmJzcDstJm5ic3A7PGEgaHJlZj0i"));return(base64_decode("aHR0cDovL3d3dy5saWdhLW1hbmFnZXItb25saW5lLmRlLyIgdGl0bGU9IkNsaWNrIGhlcmUgdG8gZ2V0IGluZm9ybWF0aW9ucyBhYm91dCB0aGlzIHNjcmlwdCI+qSZuYnNwOzE5OTctMjAwNSZuYnNwO0xNTy1Hcm91cDwvYT4="));}}
  if (!function_exists("d")){function d($c){if(strpos(htmlentities($c),htmlentities(base64_decode("PCEtLUluZm9saW5rLS0+")))>0){false;}else{ eval(base64_decode("ZWNobyAnPGFjcm9ueW0gdGl0bGU9IkxpZ2EgTWFuYWdlciBPbmxpbmUiPkxNTzwvYWNyb255bT4mbmJzcDs0LjAmbmJzcDstJm5ic3A7PGEgaHJlZj0iaHR0cDovL3d3dy5saWdhLW1hbmFnZXItb25saW5lLmRlLyIgdGl0bGU9IkNsaWNrIGhlcmUgdG8gZ2V0IGluZm9ybWF0aW9ucyBhYm91dCB0aGlzIHNjcmlwdCI+qSZuYnNwOzE5OTctMjAwNSZuYnNwO0xNTy1Hcm91cDwvYT4nOw=="));}}}//*/?>