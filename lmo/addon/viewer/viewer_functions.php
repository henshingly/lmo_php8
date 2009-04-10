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
  * $Id$
  */
  
function getBigImage($team,$alternative_text='') {
  $team=str_replace("/","",$team);
  if (!file_exists(PATH_TO_IMGDIR."/teams/big/".$team.".gif")) {
    $team=preg_replace("/[^a-zA-Z0-9]/",'',$team);
  }
  if (!file_exists(PATH_TO_IMGDIR."/teams/big/".$team.".gif")) {
    return $alternative_text;
  } else {
    $imgdata=getimagesize(PATH_TO_IMGDIR."/teams/big/".$team.".gif");
    return ("<img border='0' src='".URL_TO_IMGDIR."/teams/big/".rawurlencode($team).".gif' {$imgdata[3]} alt='$alternative_text'> ");
  }
}

function zeitberechnung($modus,$wert)  {
// Gibt verschiedene Werte je nach $Modus zur?ck:
// 1 = Tag + $wert (Tage) um 0:00 Uhr als Zeitstempel
// 2 = Tag + $wert (Tage) um 23:59 Uhr als Zeitstempel

  switch($modus) {
    case "1":
      return mktime(0,0,0,date("m"),date("d")+$wert ,date("Y"));
      // Gibt heutigen Tag + $wert (Tage) um 0:00 Uhr als Zeitstempel zurück
      break;

      case "2":
        return mktime(23,59,0,date("m"), date("d")+$wert,date("Y"));
        // Gibt heutigen Tag + $wert (Tage) um 23:59 Uhr als Zeitstempel zurück
        break;

      default:
        return false;
  }   // switch
}

?>