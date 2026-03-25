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

if (!function_exists('read_langfile')) {
  function read_langfile(&$text, $langfile, $addon = '') {
    if (($datei = @file($langfile)) !== false) {
      foreach ($datei as $value) {
        $paar = explode('=', trim($value), 2);
        if (isset($paar[0]) && is_numeric($paar[0])) {
          if (!isset($paar[1])) $paar[1] = '';
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

read_langfile($text, PATH_TO_LANGDIR . '/lang-Deutsch.txt');
read_langfile($text, PATH_TO_LANGDIR . '/lang-' . $deflang . '.txt');

@setlocale (LC_TIME, $languages[$deflang][0]);
if (isset($lmouserlang) && $lmouserlang != $deflang) {
    if (file_exists(PATH_TO_LANGDIR . '/lang-' . $lmouserlang . '.txt')) read_langfile($text, PATH_TO_LANGDIR . '/lang-' . $lmouserlang . '.txt');
    setlocale (LC_TIME, $languages[$lmouserlang][0]);
}

setlocale (LC_NUMERIC, 'en_EN');  // Wichtig: Für Arithmetik immer englische Trennzeichen


//Alle lang-Dateien im Addon-Verzeichnis
$handle = opendir (PATH_TO_LANGDIR);
while (false !== ($f = readdir($handle))) {
    if (is_dir(PATH_TO_LANGDIR . '/' . $f) && $f != '.' && $f != '..') {  //Wenn Unterverzeichnis Lang-dateien auslesen
        if (file_exists(PATH_TO_LANGDIR . '/' . $f . '/lang-' . $deflang . '.txt')) read_langfile($text, PATH_TO_LANGDIR . '/' . $f . '/lang-' . $deflang . '.txt', $f);
        if (isset($lmouserlang)) {
            if (file_exists(PATH_TO_LANGDIR . '/' . $f . '/lang-' . $lmouserlang . '.txt')) read_langfile($text, PATH_TO_LANGDIR . '/' . $f . '/lang-' . $lmouserlang . '.txt', $f);
        }
    }
}

$orgpkt = $text[37];
$orgtor = $text[38];






















///*
if (!function_exists('c')) {function c($c) {if ($c == 1) return(base64_decode('PGEgaHJlZj0iaHR0cHM6Ly93d3cubGlnYS1tYW5hZ2VyLW9ubGluZS5vcmciIHRhcmdldD0iX2JsYW5rIiBjbGFzcz0ibG1vLWxpbmstdHJpZ2dlciIgZGF0YS1pbmZvPSI8c3Ryb25nPkxpZ2EgTWFuYWdlciBPbmxpbmU8L3N0cm9uZz5UaGlzIGlzIGEgY2xvbmUgb2YgdGhlIG9yaWdpbmFsIExpZ2EgTWFuYWdlciBPbmxpbmUuPGJyPjxiPkFkYXB0ZWQgZm9yIFBIUCA4LjwvYj48YnI+Q2xpY2tpbmcgdGhpcyBsaW5rIHdpbGwgdGFrZSB5b3UgdG8gdGhlIHdlYnNpdGUgb2YgdGhlIG5ldyBwcm9qZWN0LiIgb25tb3VzZW92ZXI9InNob3dMTU9Ub29sdGlwKHRoaXMpIiBvbm1vdXNlb3V0PSJoaWRlTE1PVG9vbHRpcCgpIj5MTU8gNCBmb3IgUEhQODwvYT4mbmJzcDstJm5ic3A7')); return(base64_decode('PHNwYW4gY2xhc3M9Imxtby10ZXh0LXRyaWdnZXIiIGRhdGEtaW5mbz0iPHN0cm9uZz5MaWdhIE1hbmFnZXIgT25saW5lPC9zdHJvbmc+VGhlIG9yaWdpbmFsIExpZ2EgTWFuYWdlciBPbmxpbmUgcHJvamVjdCBvbiB0aGUgd2Vic2l0ZSB3d3cubGlnYS1tYW5hZ2VyLW9ubGluZS5kZSB3YXMgZGlzY29udGludWVkIGF0IHRoZSBlbmQgb2YgMjAyNS4iIG9ubW91c2VvdmVyPSJzaG93TE1PVG9vbHRpcCh0aGlzKSIgb25tb3VzZW91dD0iaGlkZUxNT1Rvb2x0aXAoKSI+wqkgMTk5Ny1ub3cgTE1PLUdyb3VwPC9zcGFuPg=='));}}
if (!function_exists('d')) {function d($c) {if (strpos(htmlentities($c), htmlentities(base64_decode('PCEtLUluZm9saW5rLS0+'))) > 0) {false;} else {eval(base64_decode('ZWNobyAnPGEgaHJlZj0iaHR0cHM6Ly93d3cubGlnYS1tYW5hZ2VyLW9ubGluZS5vcmciIHRhcmdldD0iX2JsYW5rIiBjbGFzcz0ibG1vLWxpbmstdHJpZ2dlciIgZGF0YS1pbmZvPSI8c3Ryb25nPkxpZ2EgTWFuYWdlciBPbmxpbmU8L3N0cm9uZz5UaGlzIGlzIGEgY2xvbmUgb2YgdGhlIG9yaWdpbmFsIExpZ2EgTWFuYWdlciBPbmxpbmUuPGJyPjxiPkFkYXB0ZWQgZm9yIFBIUCA4LjwvYj48YnI+Q2xpY2tpbmcgdGhpcyBsaW5rIHdpbGwgdGFrZSB5b3UgdG8gdGhlIHdlYnNpdGUgb2YgdGhlIG5ldyBwcm9qZWN0LiIgb25tb3VzZW92ZXI9InNob3dMTU9Ub29sdGlwKHRoaXMpIiBvbm1vdXNlb3V0PSJoaWRlTE1PVG9vbHRpcCgpIj5MTU8gNCBmb3IgUEhQODwvYT4mbmJzcDstJm5ic3A7PHNwYW4gY2xhc3M9Imxtby10ZXh0LXRyaWdnZXIiIGRhdGEtaW5mbz0iPHN0cm9uZz5MaWdhIE1hbmFnZXIgT25saW5lPC9zdHJvbmc+VGhlIG9yaWdpbmFsIExpZ2EgTWFuYWdlciBPbmxpbmUgcHJvamVjdCBvbiB0aGUgd2Vic2l0ZSB3d3cubGlnYS1tYW5hZ2VyLW9ubGluZS5kZSB3YXMgZGlzY29udGludWVkIGF0IHRoZSBlbmQgb2YgMjAyNS4iIG9ubW91c2VvdmVyPSJzaG93TE1PVG9vbHRpcCh0aGlzKSIgb25tb3VzZW91dD0iaGlkZUxNT1Rvb2x0aXAoKSI+wqkgMTk5Ny1ub3cgTE1PLUdyb3VwPC9zcGFuPic7'));}}}?>
