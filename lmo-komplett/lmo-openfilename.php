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
  
  
if ($file != "") {
  if (substr($file, -4) == ".l98") {
    $daten = array("");
    $sekt = "";
     
    $datei = file(PATH_TO_LMO.'/'.$dirliga.'/'.basename($file));
    if ($datei) {
      $stand=strftime($defdateformat,filemtime(PATH_TO_LMO.'/'.$dirliga.'/'.basename($file)));
      $lmtype=0;
      for($tt=0;$tt<count($datei);$tt++) {
        $zeile=&$datei[$tt];
        $zeile = trim($zeile);
        if ((substr($zeile, 0, 1) == "[") && (substr($zeile, -1) == "]")) {
          $sekt = trim(substr($zeile, 1, -1));
        } elseif((strpos($zeile, "=") != false) && (substr($zeile, 0, 1) != ";")) {
          $schl = trim(substr($zeile, 0, strpos($zeile, "=")));
          $wert = trim(substr($zeile, strpos($zeile, "=")+1));
          if ($sekt == "Options") {
            if ($schl == "Title") {
              $lmvers = $wert;
            }
            if ($schl == "Name") {
              $titel = stripslashes($wert);
            }
            if ($schl == "Type") {
              $lmtype = stripslashes($wert);
            }
            if (!isset($lmtype)) {
              $lmtype = 0;
            }
            if ($schl == "Teams") {
              $anzteams = $wert;
            }
            if ($lmtype == 0) {
              if ($schl == "Rounds") {
                $anzst = $wert;
              }
            }
            if (!isset($st)) {
              if ($schl == "Actual") {
                $st = $wert;
              }
            }
            if ($schl == "Actual") {
              $stx = $wert;
            }
          }
          $daten[]="$sekt|$schl|$wert|EOL";
        }
      }
    }
    if (!isset($st)) {
      $st = 1;
    }
    if (!isset($stx)) {
      $stx = 1;
    }
    array_shift($daten);
    if (!isset($lmvers)) {
      $lmvers = "k.A.";
    }
    if (!isset($titel)) {
      $titel = "No Name";
    }
    if ($lmtype == 0) {
      if (!isset($anzst)) {
        $anzst = floor($anzteams * ($anzteams-1)/$anzsp);
      }
    } else {
      if (!isset($anzteams)) {
        $anzteams = 16;
      }
      $anzsp = floor($anzteams/2);
      $anzst = strlen(decbin($anzteams-1));
    }
  }
}

?>