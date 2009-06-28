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
  * $Id$
  */
 
require(dirname(__FILE__).'/../../init.php');
require_once(PATH_TO_ADDONDIR."/viewer/ini.php");
 
// Load the cache-counter-file for viewers simple cache mechanism
$viewer_cache_counter_filename = PATH_TO_LMO.'/'.$diroutput.'/viewer_'.$multi.'_count.txt';
$viewer_cache_counter = 0; //counter for cache hits
if (!file_exists($viewer_cache_counter_filename)) {
  touch($viewer_cache_counter_filename);
}
$viewer_cache_counter_file = fopen($viewer_cache_counter_filename, "rb");
$viewer_cache_counter = intval(trim(fgets($viewer_cache_counter_file)));
fclose($viewer_cache_counter_file);
 
 
if (!isset($cfgarray))$cfgarray = array();
   
$multi1 = PATH_TO_CONFIGDIR.'/viewer/'.$multi.'.view';

if (file_exists($multi1)) {
  // in Array lesen
  $multi_cfgarray = parse_ini_file($multi1);
  // in Array lesen & mit Hauptscript zusammenlegen
  $multi_cfgarray += $main_cfgarray;
  // Variablen erstellen
  extract ($multi_cfgarray);
} else {
  die("Konfigurationsdatei: $multi1 nicht gefunden!");
}

$multi_cfgarray['cache_refresh'] = isset($multi_cfgarray['cache_refresh'])?$multi_cfgarray['cache_refresh']:0;

if ($viewer_cache_counter == 0 || $viewer_cache_counter > $multi_cfgarray['cache_refresh']) {
  //not cached or cache limit reached->generate new view
   
  $i = 1;
  $output = "";
  $fav_liga[] = array();
   $fav_team[][] = array();
  while (isset($multi_cfgarray['liga'.$i])) {
    $fav_liga[$i] = $multi_cfgarray['liga'.$i];
    $ii = 1;
    //all teams if no fav teams selected
    if (!isset($multi_cfgarray[$multi_cfgarray['liga'.$i].'_'.$ii])) {
      $all_teams = TRUE;
    }
    while (isset($multi_cfgarray[$multi_cfgarray['liga'.$i].'_'.$ii])) {
      $fav_team[$i][$ii] = $multi_cfgarray[$multi_cfgarray['liga'.$i].'_'.$ii];
      $ii++;
    }
    $i++;
  }
  $anzahl_ligen = --$i;
   
   
   
  $template_file = $multi_cfgarray['template'];
  $template = new HTML_Template_IT(PATH_TO_TEMPLATEDIR.'/viewer' ); // Template Object
  $template->loadTemplatefile($template_file.'.tpl.php');
  // Template laden
   
  if (isset($multi_cfgarray['titelzeile'])) {
    $template->setVariable("Titelzeile", $multi_cfgarray['titelzeile']);
  }
   
  if ($multi_cfgarray['modus'] == 2) {
    include(PATH_TO_ADDONDIR."/viewer/viewer_spieltag.php");
  } else {
    include(PATH_TO_ADDONDIR."/viewer/viewer_datum.php");
  }
   
  $viewer_output = $template->get();
   
  //save cache file
  if ($viewer_cache_file = fopen(PATH_TO_LMO.'/'.$diroutput.'/viewer_'.$multi.'.txt', "wb")) {
    fwrite($viewer_cache_file, $viewer_output);
    fclose($viewer_cache_file);
  }
  //reset cache counter
  $viewer_cache_counter_file = fopen(PATH_TO_LMO.'/'.$diroutput.'/viewer_'.$multi.'_count.txt', "wb");
  fwrite($viewer_cache_counter_file, "1");
  fclose($viewer_cache_counter_file);
   
  echo $viewer_output;
   
} else {
  //get cache
   
  if ($viewer_cache_file = fopen(PATH_TO_LMO.'/'.$diroutput.'/viewer_'.$multi.'.txt', "rb")) {
    fpassthru($viewer_cache_file);
    fclose($viewer_cache_file);
  }
  //increment cache counter
   
  $viewer_cache_counter_file = fopen(PATH_TO_LMO.'/'.$diroutput.'/viewer_'.$multi.'_count.txt', "wb");
  fwrite($viewer_cache_counter_file, ++$viewer_cache_counter);
  fclose($viewer_cache_counter_file);
}
   
   
?>
