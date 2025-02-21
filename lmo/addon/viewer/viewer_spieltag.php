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
  *
  */

$template->setVariable('Spieltageminus', $multi_cfgarray['anzahl_spieltage_zurueck']);
$template->setVariable('Spieltageplus', $multi_cfgarray['anzahl_spieltage_vor']);
// Durchlaufe so oft Ligen vorhanden sind
for ($i = 1; $i <= $anzahl_ligen; $i++) {
    $liga = new liga();
    // Ligenfile vorhanden?
    if ($liga->loadFile(PATH_TO_LMO . '/' . $dirliga . $fav_liga[$i]) == true) {
        $template->setCurrentBlock('Liga');  // Äusserer Block für die Liga
        $rounds = $liga->options->keyValues['Rounds'];
        $aktueller_spieltag = $liga->options->keyValues['Actual'];
        $star = $aktueller_spieltag - ($multi_cfgarray['anzahl_spieltage_zurueck']);
        $end = $aktueller_spieltag + $multi_cfgarray['anzahl_spieltage_vor'];
        $ende = '';
        if ($end > $rounds) {
            $ende = $rounds;
        }
        else {
            $ende = $end;
        }
        $start = '';
        if ($star < 1) {
            $start = 1;
        }
        else {
            $start = $star;
        }

        $template->setVariable('Anfangsspieltag', $start);  //Ausgabe Spieltag
        $template->setVariable('Endespieltag', $ende);  //Ausgabe Spieltag

        //all teams
        if ($all_teams == false) {
        }
        else {
            $team_count = count($liga->teams);
            for ($x = 0; $x < $team_count; $x++) {
                $fav_team[$i][] = $x;
            }
        }
        //Anfang Ergebnisse verlinken
        $template->setVariable('ErgebnisLink', URL_TO_LMO . '/lmo.php?file=' . $fav_liga[$i] . '&amp;action=results');
        $template->setVariable('Liganame', $liga->name);
        $template->setVariable('Ligadatum', $liga->ligaDatumAsString());
        for ($spieltag = $start; $spieltag <= $ende; $spieltag++) {
            $template->setCurrentBlock('Spieltag');
            //Anfang Spieltag verlinken
            $spieltag_link = URL_TO_LMO . '/lmo.php?file=' . $fav_liga[$i] . '&amp;action=results&amp;st=' . $spieltag;
            $template->setVariable('AktSpieltag', $spieltag);
            $template->setVariable('AktSpieltagLink', $spieltag_link);
            $akt_spieltag = $liga->spieltagForNumber($spieltag);
            if ($liga->options->keyValues['enableGameSort'] == '1') {
                //Spieltagssortierung ist aktiv
                $partien = $akt_spieltag->getPartien('datum');
            }
            else {
                $partien = $akt_spieltag->getPartien();
            }

            $template->setCurrentBlock('Inhalt');  //Ausgabe Inhalt Beginn
            foreach ($partien as $partie) {
                require(PATH_TO_ADDONDIR . '/viewer/viewer_spiel.inc.php');
            }
            $template->parse('Spieltag');
        }
        $template->setVariable('VERSION', VIEWER_VERSION);
        $template->parse('Liga');
    }
    else  {
        echo getMessage($text['viewer'][49] . ' . $fav_liga[$i] . ' . $text['viewer'][50], true); // Ligenfile vorhanden? Frage beantwortet
    }
}
?>
