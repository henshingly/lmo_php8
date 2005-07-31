<?php
$startzeit=zeitberechnung("1",-$multi_cfgarray['anzahl_tage_minus']);
$endzeit=zeitberechnung("2",$multi_cfgarray['anzahl_tage_plus']);
// Durchlaufe sooft Ligen vorhanden sind
for($i=1; $i<=$anzahl_ligen; $i++) {
  $akt_liga=new liga();
  // Ligenfile vorhanden?
  if ($akt_liga->loadFile(PATH_TO_LMO.'/'.$dirliga.$fav_liga[$i]) == TRUE) {
    $template->setCurrentBlock("Liga");                                   // Äusserer Block für die Liga
    $template->setVariable("Anfangsdatum",date($multi_cfgarray['datumsformat'],zeitberechnung("2",-$multi_cfgarray['anzahl_tage_minus'])));  // Relevante Daten setzen
    $template->setVariable("Enddatum",date($multi_cfgarray['datumsformat'],zeitberechnung("2",$multi_cfgarray['anzahl_tage_plus'])));  // Relevante Daten setzen
    // Sortiert nach Datum Tim's
    $sortedGames = gamesSorted($akt_liga,false);
    foreach ($sortedGames as $game) {
      $myPartie = &$game['partie'];
      $mySpieltag = &$game['spieltag'];
      $template->setCurrentBlock("Inhalt");
      // Passend in das Zeitraster?
      if (($myPartie->zeit <= $endzeit) && ($myPartie->zeit >= $startzeit)) {
        require(PATH_TO_ADDONDIR."/viewer/viewer_spiel.inc.php");
      }
    }
    $template->setVariable("VERSION",VIEWER_VERSION);
    $template->parse("Liga");
  } else  {
    echo getMessage($text['viewer'][49].".$fav_liga[$i].".$text['viewer'][50],TRUE); // Ligenfile vorhanden? Frage beantwortet
  }
}
?>
