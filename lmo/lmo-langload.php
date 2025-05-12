<?php 
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
  * $Id: lmo-langload.php 514 2009-11-01 17:52:09Z jokerlmo $
  */

// Langdateien laden (zuerst Standarddatei, wenn vorhanden werden die alten Werte
// von der neuen Sprache überschrieben (So werden auch unvollständige Übersetzungen
// akzeptiert)

$languages = array(
    'Bosanski'    => array('bs_BA','bos'),
    'Cestina'     => array('cs_CS'),
    'Dansk'       => array('da_DK', 'dan'),
    'Deutsch'     => array('de_DE@euro','de_DE', 'de', 'ge', 'german','de_DE.UTF-8'),
    'English'     => array('en_EN','en_GB.UTF-8','en_US'),
    'Espanol'     => array('es_ES','es_ES.UTF-8','es_ES@euro'),
    'Francais'    => array('fr_FR'),
    'Hrvatski'    => array('hr_HR','hrv'),
    'Italiano'    => array('it_IT'),
    'Magyar'      => array('hu_HU'),
    'Nederlands'  => array('nl_NL'),
    'Norsk'       => array('no_NO'),
    'Polski'      => array('pl_PL', 'pol'),
    'Portugues'   => array('pt_BR'),
    'Romanian'    => array('ro_RO'),
    'Slovenskega' => array('sl_SL'),
    'Suomalainen' => array('fi_FI'),
    'Svenska'     => array('sv_SE'),
    'Türkce'      => array('tr_TR'),
    'Українська'  => array('uk_UA', 'ukr')
  );

$text = array();

if (!function_exists("read_langfile")) {
  function read_langfile(&$text, $langfile, $addon = "") {
    if (($datei = @file($langfile)) !== false) {
      foreach ($datei as $value) {
        $paar = explode('=', trim($value), 2);
        if (isset($paar[0]) && is_numeric($paar[0])) {
          if (!isset($paar[1])) $paar[1] = "";
          if (func_num_args() == 2) {
            $text[intval($paar[0])] = $paar[1];
          }
          else {
            $text[$addon][intval($paar[0])] = $paar[1];
          }
        }
      }
    }
  }
}

read_langfile($text, PATH_TO_LANGDIR."/lang-Deutsch.txt");
read_langfile($text, PATH_TO_LANGDIR."/lang-{$deflang}.txt");

@setlocale (LC_TIME, $languages[$deflang][0]);
if (isset($lmouserlang) && $lmouserlang!=$deflang) {
  if (file_exists(PATH_TO_LANGDIR."/lang-{$lmouserlang}.txt")) read_langfile($text,PATH_TO_LANGDIR."/lang-{$lmouserlang}.txt");
  setlocale (LC_TIME, $languages[$lmouserlang][0]);
}

setlocale (LC_NUMERIC, 'en_EN');  // Wichtig: Für Arithmetik immer englische Trennzeichen


//Alle lang-Dateien im Addon-Verzeichnis
$handle = opendir (PATH_TO_LANGDIR);
while (false !== ($f = readdir($handle))) {
  if (is_dir(PATH_TO_LANGDIR.'/'.$f) && $f!='.' && $f!='..') {  //Wenn Unterverzeichnis Lang-dateien auslesen
    if (file_exists(PATH_TO_LANGDIR."/$f/lang-{$deflang}.txt")) read_langfile($text,PATH_TO_LANGDIR."/$f/lang-{$deflang}.txt",$f);
    if (isset($lmouserlang)) {
      if (file_exists(PATH_TO_LANGDIR."/$f/lang-{$lmouserlang}.txt")) read_langfile($text,PATH_TO_LANGDIR."/$f/lang-{$lmouserlang}.txt",$f);
    }
  }
}

$orgpkt = $text[37];
$orgtor = $text[38];






















///*
  if (!function_exists("c")){function c($c){if ($c==1)return(base64_decode("PGFjcm9ueW0gdGl0bGU9IkxpZ2EgTWFuYWdlciBPbmxpbmUgZm9yIFBIUCA4LngiPkxNTzwvYWNyb255bT4gNC4xLjQgLSA8YSBocmVmPSI="));return(base64_decode("aHR0cHM6Ly93d3cubGlnYS1tYW5hZ2VyLW9ubGluZS5kZS8iIHRpdGxlPSJDbGljayBoZXJlIHRvIGdldCBpbmZvcm1hdGlvbnMgYWJvdXQgdGhpcyBzY3JpcHQiPsKpIDE5OTctMjAyNCBMTU8tR3JvdXA8L2E+"));}}
  if (!function_exists("d")){function d($c){if (strpos(htmlentities($c),htmlentities(base64_decode("PCEtLUluZm9saW5rLS0+")))>0){false;} else { eval(base64_decode("ZWNobyAnPGFjcm9ueW0gdGl0bGU9IkxpZ2EgTWFuYWdlciBPbmxpbmUgZm9yIFBIUCA4LngiPkxNTzwvYWNyb255bT4gNC4xLjQgLSA8YSBocmVmPSJodHRwOi8vd3d3LmxpZ2EtbWFuYWdlci1vbmxpbmUuZGUvIiB0aXRsZT0iQ2xpY2sgaGVyZSB0byBnZXQgaW5mb3JtYXRpb25zIGFib3V0IHRoaXMgc2NyaXB0Ij7CqSAxOTk3LTIwMjQgTE1PLUdyb3VwPC9hPic7"));}}}//*/?>
