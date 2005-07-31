<?php
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