<?php
$template->setVariable("Spieltageminus",$multi_cfgarray['anzahl_spieltage_zurueck']);
$template->setVariable("Spieltageplus",$multi_cfgarray['anzahl_spieltage_vor']);
// Durchlaufe sooft Ligen vorhanden sind
for($i=1; $i<=$anzahl_ligen; $i++) {
  $akt_liga=new liga();
  // Ligenfile vorhanden?
  if ($akt_liga->loadFile(PATH_TO_LMO.'/'.$dirliga.$fav_liga[$i]) == TRUE) {
    $template->setCurrentBlock("Liga");                                   // Äusserer Block für die Liga
    //$template->setVariable("Liganame",$akt_liga->name);																							//Ausgabe Liganame
    $rounds=$akt_liga->options->keyValues['Rounds'];
    $aktueller_spieltag=$akt_liga->options->keyValues['Actual'];
    $star=$aktueller_spieltag-($multi_cfgarray['anzahl_spieltage_zurueck']);
    $end=$aktueller_spieltag+$multi_cfgarray['anzahl_spieltage_vor'];

    $ende="";
    if ($end > $rounds) {
      $ende=$rounds;
    }else{
      $ende=$end;
    }
    $start="";
    if ($star< 1) {
      $start=1;
    }else{
      $start=$star;
    }

    $template->setVariable("Anfangsspieltag",$start);                     												//Ausgabe Spieltag
    $template->setVariable("Endespieltag",$ende);                      														//Ausgabe Spieltag
    for ($spieltag=$start; $spieltag<=$ende; $spieltag++) {
      $akt_spieltag=$akt_liga->spieltagForNumber($spieltag);
      $template->setCurrentBlock("Inhalt");  																									//Ausgabe Inhalt Beginn
      foreach ($akt_spieltag->partien as $myPartie) {
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
