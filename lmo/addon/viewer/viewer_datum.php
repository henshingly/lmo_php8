<?php
/* Liga Manager Online 4
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
  
$startzeit = zeitberechnung("1", -$multi_cfgarray['anzahl_tage_minus']);
$endzeit = zeitberechnung("2", $multi_cfgarray['anzahl_tage_plus']);
// Durchlaufe sooft Ligen vorhanden sind
for ($i = 1; $i <= $anzahl_ligen; $i ++) {
    $liga = new liga();
    // Ligenfile vorhanden?
        if ($liga->loadFile(PATH_TO_LMO . '/' . $dirliga . $fav_liga[$i]) == true) {
        $template->setCurrentBlock("Liga");                                   // Äusserer Block für die Liga
        $template->setVariable("Anfangsdatum", date($multi_cfgarray['datumsformat'], zeitberechnung("2", -$multi_cfgarray['anzahl_tage_minus'])));  // Relevante Daten setzen
        $template->setVariable("Enddatum", date($multi_cfgarray['datumsformat'], zeitberechnung("2", $multi_cfgarray['anzahl_tage_plus'])));  // Relevante Daten setzen
        //Anfang Ergebnisse verlinken
        $template->setVariable("ErgebnisLink",URL_TO_LMO . '/lmo.php?file=' . $fav_liga[$i] . "&amp;action=results");
        $template->setVariable("Liganame", $liga->name);
        $template->setVariable("Ligadatum", $liga->ligaDatumAsString());
    
        //all teams
        if ($all_teams) {
            $team_count = count($liga->teams);
            for ($x = 0; $x < $team_count; $x ++) {
            $fav_team[$i][] = $x;
            }
        }
    
        // Sortiert nach Datum Tim's
        $sortedGames = $liga -> gamesSorted(false);
        foreach ($sortedGames as $game) {
            $partie = &$game['partie'];
            $mySpieltag = &$game['spieltag'];
            $template->setCurrentBlock("Inhalt");
            // Passend in das Zeitraster?
            if (($partie->zeit <= $endzeit) && ($partie->zeit >= $startzeit)) {
                require(PATH_TO_ADDONDIR . "/viewer/viewer_spiel.inc.php");
            }
        }
        $template->setVariable("VERSION" ,VIEWER_VERSION);
        $template->parse("Liga");
    } else  {
        echo getMessage($text['viewer'][49] . " . $fav_liga[$i] . " . $text['viewer'][50], true); // Ligenfile vorhanden? Frage beantwortet
    }
}
?>
