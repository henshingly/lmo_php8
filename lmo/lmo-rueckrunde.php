<?php
require_once(__DIR__.'/init.php');
require_once(PATH_TO_ADDONDIR."/classlib/ini.php");
// nur aus dem Admin-Bereich (lmo-adminedit.php) und angemeldet: ein direkter Aufruf
// lmo-rueckrunde.php?file=... schrieb die Liga sonst ohne Anmeldung neu
require_once(PATH_TO_LMO."/lmo-admintest.php");

if (isset($file) && $file != "" && ($_SESSION['lmouserok'] == 2 || $_SESSION['lmouserok'] == 1))
{
  $liga = new liga();
  if ($liga->loadFile(PATH_TO_LMO.'/'.$dirliga.$file))
  {
    // nur speichern, wenn ein Rueckrundenspielplan erstellt wurde (gerade Anzahl Spieltage)
    if (completeSchedule($liga))
    {
      $liga->writeFile(PATH_TO_LMO.'/'.$dirliga.$file);
      echo getMessage($text[3002]);
    }
  }
}

function completeSchedule($liga)
{
  global $text;
  $rounds = $liga->options->keyValues["Rounds"];

  if ($rounds % 2 == 0)
  {
    //$gamesPerDay = $liga->options->keyValues['Matches']; // $gamesPerDay is not needed here
    $daysPerRound = $rounds/2;

    for ($i = 0; $i < $rounds/2; $i++)
    {
      if (isset($liga->spieltage[$i + $daysPerRound]))
      {
        $liga->spieltage[$i + $daysPerRound]->partien = array();
      }
      else
      {
        $spieltag = new spieltag($i + $daysPerRound + 1, "", "");
        $liga->addSpieltag($spieltag);
      }

      foreach($liga->spieltage[$i]->partien AS $p)
      {
        $partie = new partie($p->spNr, NULL, NULL, $p->gast, $p->heim, -1, -1, NULL, NULL);
        $liga->spieltage[$i + $daysPerRound]->addPartie($partie);
      }
    }
    return true;
  }
  echo getMessage($text[3001], true);
  return false;
}
?>