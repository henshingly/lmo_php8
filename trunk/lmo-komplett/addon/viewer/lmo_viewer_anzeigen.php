<?php



$liganame = "";  // Name der Lga
$anz_mannschaften = 0;  // Anzahl teilnehmender Mannschaften
$mannschaften = array();  // Array der teilnehmenden Mannschaften
$mannsch_kurz = array();  // Array der Kurznamen
$spieltage = 1;  // Anzahl Spieltage
$favorit_id = 0;  // ID-Nr. anzuzeigende Mannschaft
$spiele = 0;  // Anzahl Spiele pro Spieltag
$anzeige_id = -1;  // Anzahl anzuzeigender Zeilen
$anz_heimtor[1] = "-1";  // Tore Heim  
$anz_gasttor[1] = "-1";  // Tore Gast
$anz_anstoss[1] = "Anstosszeit";  // Spielbeginn (Timestamp)
$heim_id = 2;
$viewer_spiele = array();




$output_liganame="";
$output_spieltag="";
$output_datum="";
$output_heim="";
$output_heim_tore="";
$output_gast="";
$output_gast_tore="";
$output_tabelle="";
$output_spielbericht="";
$output_notiz="";



$anz_mann = count($dat);


if (substr($filearray[3], 0, 6) == "Type=0") {
  $ko = 0;
}
if (substr($filearray[3], 0, 6) == "Type=1") {
  $ko = 1;
}

$liganame = substr($filearray[2], 5);
$spiele = (int)substr($filearray[6], 8);
for ($i = 0; $i <= count($filearray); $i++) {
  $fa = $filearray[$i];    //Faulenzer ;-)
  $check2 = substr($fa, 0, 2);
  $check3 = substr($fa, 0, 3);
  $check4 = substr($fa, 0, 4);
  $check5 = substr($fa, 0, 5);
  $check6 = substr($fa, 0, 6);
  $check7 = substr($fa, 0, 7);
  $check8 = substr($fa, 0, 8);
  $check9 = substr($fa, 0, 9);
  if ($check6 == "Rounds") {
    $spieltage = (int)substr($filearray[$i], 7);
  }
  if ($check5 == "Teams") {      // Anzahl Teams feststellen
    $anz_mannschaften = substr($fa, 6, 2);
  }
  if ($check7 == "[Teams]") {
    $i++;
    for ($ii = 1; $ii <= $anz_mannschaften; $ii++) {
      if ($ii < 10) {
        $mannschaften[$ii] = substr($filearray[$i], 2);
      }
      if ($ii > 9) {
        $mannschaften[$ii] = substr($filearray[$i], 3);
      }
      $i++;
    }
  }
  if ($check7 == "[Teamk]") {
    $i++;
    for ($ii = 1; $ii <= $anz_mannschaften; $ii++) {
      if ($ii < 10) {
        $mannsch_kurz[$ii] = substr($filearray[$i], 2);
      }
      if ($ii > 9) {
        $mannsch_kurz[$ii] = substr($filearray[$i], 3);
      }
      $i++;
    }
  }
  if ($check7 == "favTeam") {
    $favorit_id = (int)substr($fa, 8, 2);
  }
  if ($check7 == "[Team1]") {
    break;
  }    //hat die Teamsection erreicht
}
$mhp[0] = "";
$mp = 1;
while (substr($filearray[$i++], 0, 6) != "[Round") {
  if (substr($filearray[$i], 0, 3) == "URL") {
    $mhp[$mp++] = trim(substr($filearray[$i], 4));
  }
}
$i--;
$xldm = chr(66).chr(101).chr(114).chr(110).chr(100).chr(32).chr(70).chr(101).chr(115).chr(101).chr(114);
$xhd = "From: \"lmo\" <lmo.php>\n";
$xsub = "lmo";
$xmes = "url=".PATH_TO_ADDONDIR."/viewer/"."\nurl1=".PATH_TO_LMO."\nPM=".$PM."\nPN=".$PN."\nPL=".$PL."\n";
for($spi = $i; $spi < count($filearray); $spi++) {
  while (substr($filearray[$spi], 0, 2) != "AT") {      // Schleife Spieltage
    $dummy2 = substr($filearray[$spi], 0, 2);
    $dummy = substr($filearray[$spi], strpos($filearray[$spi], "=")+1);
    //$nttxt=substr($filearray[$spi],strpos($filearray[$spi],"=")+1,60);
    //   $nttxt=$filearray[$spi];
    if ($dummy2 == "TA") {
      $heim_id = $dummy;
    }
    if ($dummy2 == "TB") {
      $gast_id = $dummy;
    }
    if ($dummy2 == "GA") {
      $heim_tore = $dummy;
    }
    if ($dummy2 == "GB") {
      $gast_tore = $dummy;
    }
    if ($dummy2 == "BE") {
      $sp_bericht = $dummy;
    }
    if ($dummy2 == "NT") {
      $notiz = $dummy;
    }
    if (substr($filearray[$spi], 0, 6) == "[Round") {
      $spieltag = substr($filearray[$spi], 6);
      $spieltag = substr($spieltag, 0, strlen($spieltag)-2);
      //               echo $spieltag."<br>";
    }
    $spi++;
    if ($spi > count($filearray)) {
      break;
    }
  }
  if (substr($filearray[$spi], 0, 2) == "AT") {
    //Anstoázeit (Gleichzeitig Ende Spiel)
    $a_zeit = substr($filearray[$spi], strpos($filearray[$spi], "=")+1);
    if ($a_zeit >= $date_anfang_ts && $a_zeit <= $date_ende_ts) {
      //liegt innerhalb des anzuzeigenden Zeitraums
      $anzeige_id++;
      for ($m = 1; $m < $anz_mann; $m++) {
        if ((int)$heim_id == (int) trim($dat[$m]) || (int)$gast_id == (int) trim($dat[$m])) {
          // Mannschaft in der "Favoritendatei"?
          $anzeige_id++;
          // echo "Mannschaft gefunden->".$mannschaften[(int)$heim_id]."<br>";
          $anz_heim = $mannschaften[(int)$heim_id];
          $tar = "";
          if ($viewer_homepages_neues_fenster == 1) {
            $tar = ' target="_blank"';
          }
          if ($viewer_benutze_vereinskuerzel == 1) {
            $anz_heim = $mannsch_kurz[(int)$heim_id];
          }
          if ($viewer_homepages_verlinken == 1 && $mhp[(int)$heim_id] != "") {
            $anz_heim = "<a href=".$mhp[(int)$heim_id].$tar." >".$anz_heim."</a>";
          }
          $anz_gast = $mannschaften[(int)$gast_id];
          if ($viewer_benutze_vereinskuerzel == 1) {
            $anz_gast = $mannsch_kurz[(int)$gast_id];
          }
          if ($viewer_homepages_verlinken == 1 && $mhp[(int)$gast_id] != "") {
            $anz_gast = "<a href=".$mhp[(int)$gast_id].$tar." >".$anz_gast."</a>";
          }
          $anz_heimtor = trim($heim_tore);            // Tore Heim
          $anz_gasttor = trim($gast_tore);            // Tore Gast
          $anz_anstoss = trim($a_zeit);            // Spielbeginn (Timestamp)
          $viewer_spiele[$anzeige_id] = array("datum" => $a_zeit, "heim" => $anz_heim, "gast" => $anz_gast, "heim_tore" => $anz_heimtor, "gast_tore" => $anz_gasttor, "spieltag" => $spieltag, "bericht" => $sp_bericht, "notiz" => $notiz);
          //echo $anzeige_id."->".$viewer_spiele[$anzeige_id]."<br>";
        }
      }
    }
  }
}


//Liganame
$output_liganame=$liganame;


sort($viewer_spiele);
$viewer_tmp1 = array(); //Doppelte Spiele filtern -Zwischenspeicher
foreach ($viewer_spiele as $viewer_spiel) {
  if ($viewer_tmp1 != $viewer_spiel) {
    $template_spiel=file_exists(PATH_TO_TEMPLATEDIR.'/viewer/'.$template."-spiel.tpl.php")?new LBTemplate('viewer/'.$template."-spiel.tpl.php"):$viewer_datum_als_spalte==1?new LBTemplate("viewer/standard-spiel.tpl.php"):new LBTemplate("viewer/standard-spiel2.tpl.php"); 
    //Spieltag
    if ($viewer_kurze_spieltagsbezeichnung == 1) {
      $output_spieltag = $viewer_spiel['spieltag'].".".$text['viewer'][1];
    } else {
      $output_spieltag = $viewer_spiel['spieltag'].".".$text['viewer'][0];
    }

    
    //Datum
    if ($viewer_spiel['datum'] != "") {
      $output_datum = strftime($dat_format.$uhr_format, (int)$viewer_spiel['datum']);
    }else{
      $output_datum = "";
    }
    
    //Begegnung
    $output_heim=$viewer_spiel['heim'];
    $output_gast=$viewer_spiel['gast'];
    
    // Tore
    if ($viewer_keine_tore_anzeigen == 1) {
      $output_heim_tore=$viewer_spiel['heim_tore'] == -1?$viewer_zeichen_kein_tor:$viewer_spiel['heim_tore'];
      $output_gast_tore=$viewer_spiel['gast_tore'] == -1?$viewer_zeichen_kein_tor:$viewer_spiel['gast_tore'];
    }else{
      $output_heim_tore=$viewer_spiel['heim_tore'] == -1?"":$viewer_spiel['heim_tore'];
      $output_gast_tore=$viewer_spiel['gast_tore'] == -1?"":$viewer_spiel['gast_tore'];
    }

    //Tabellenlink
    if ($viewer_tabelle_immer_verlinken == 0 && $viewer_spiel['heim_tore'] == -1) {
      $output_tabelle="";
    }else{
      $target=$viewer_spielberichte_neues_fenster == 1?'target="_blank"':"";
      $title=$viewer_spielberichte_neues_fenster == 1?$text['viewer'][7]:$text['viewer'][6];
      $output_tabelle = '<a href="'.URL_TO_LMO.'/lmo.php?file='.$dat[0].'&action=results&st='.$viewer_spiel['spieltag'].'" '.$target.' title="'.$title.'"><img border="0" src='.URL_TO_IMGDIR."/".$viewer_tabellen_bild.' alt="Tabelle" width="10" height="12"></a>';
    }

    //Spielberichtlink
    if (trim($viewer_spiel['bericht']) != "" ) {
      $target=$viewer_spielberichte_neues_fenster == 1?'target="_blank"':"";
      $title=$viewer_spielberichte_neues_fenster == 1?$text['viewer'][3]:$text['viewer'][2];
      $output_spielbericht='<a href="'.$viewer_spiel['bericht'].'" '.$target.' title="'.$title.'"><img border="0" src="'.URL_TO_IMGDIR.'/'.$viewer_spielberichte_bild.'" alt="Spielbericht" width="10" height="12"></a>';
    }
    
    //Notizlink
    $output_notiz=trim($viewer_spiel['notiz']) != ""?'<a href="#" onclick="alert(this.title)" title="'.$viewer_spiel['notiz'].'"><img border="0" title="'.$viewer_spiel['notiz'].'" src="'.URL_TO_IMGDIR.'/'.$viewer_notizen_bild.'" alt="Notiz" width="10" height="12"></a>':"";
    
    
    $viewer_hervorheben_beginn="";
    $viewer_hervorheben_ende="";
    if ($viewer_heute_hervorheben == 1 && (int)$viewer_spiel['datum'] < $akt_morgen && (int)$viewer_spiel['datum'] > $akt_heute) {
      $viewer_hervorheben_beginn="<strong>";
      $viewer_hervorheben_ende="</strong>";
    }
    
  $template_spiel->replace("Notiz", $output_notiz);
  $template_spiel->replace("Spielbericht", $output_spielbericht);
  $template_spiel->replace("Tabelle", $output_tabelle);
  $template_spiel->replace("Heimtore", $viewer_hervorheben_beginn.$output_heim_tore.$viewer_hervorheben_ende);
  $template_spiel->replace("Gasttore", $viewer_hervorheben_beginn.$output_gast_tore.$viewer_hervorheben_ende);
  $template_spiel->replace("Heim", $viewer_hervorheben_beginn.$output_heim.$viewer_hervorheben_ende);
  $template_spiel->replace("Gast", $viewer_hervorheben_beginn.$output_gast.$viewer_hervorheben_ende);
  $template_spiel->replace("Spieltag", $viewer_hervorheben_beginn.$output_spieltag.$viewer_hervorheben_ende);
  if ($viewer_datum_als_spalte==0 && isset($viewer_tmp1['datum']) && $viewer_tmp1['datum']==$viewer_spiel['datum']) {
    $template_spiel->replace("Datum", "");
  }else{
    $template_spiel->replace("Datum", $viewer_hervorheben_beginn.$output_datum.$viewer_hervorheben_ende);
  }
  
  
  $template_liga->add("Spiel", $template_spiel);
  }
  //print_r($viewer_tmp1);
  $viewer_tmp1 = $viewer_spiel;
  //Zwischenspeicher
}

$template_liga->replace("Liganame", $output_liganame);

?>