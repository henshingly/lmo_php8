<?
require_once(dirname(__FILE__).'/../../init.php');

$template =            isset($_GET['template'])? $_GET['template']    :"";
$viewer_tage_minus=    isset($_GET['minus'])   ? $_GET['minus']       :$viewer_tage_minus;
$viewer_tage_plus=     isset($_GET['plus'])    ? $_GET['plus']        :$viewer_tage_plus;
$viewer_ueberschrift=  isset($_GET['title'])   ? $_GET['title']       :$text['viewer'][4];

$template_hauptteil = file_exists(PATH_TO_TEMPLATEDIR.'/viewer/'.$template."-haupt.tpl.php")?new LBTemplate('viewer/'.$template."-haupt.tpl.php"):new LBTemplate("viewer/standard-haupt.tpl.php");
 
$akt_date_ts = time();  // Aktuelle Zeit im Unix-Zeitstempel-Format (UZF)
$date_anfang_ts = zeitberechnung("1", -$viewer_tage_minus); // Anzeige ab wann?
$date_ende_ts = zeitberechnung("2", $viewer_tage_plus); // Anzeige bis wann?
$akt_heute = zeitberechnung("1", "0");
$akt_morgen = zeitberechnung("2", "1");
 
//Überschrift
$output_ueberschrift = $text['viewer'][4]." ".date(" d.m.Y", $date_anfang_ts)." - ".date("d.m.Y", $date_ende_ts);
 
//Styles
$output_style_gesamt = "";
$output_style_gesamt .= isset($viewer_hintergrund) && $viewer_hintergrund != ""?"background-color:".$viewer_hintergrund."; ":"";
$output_style_gesamt .= isset($viewer_schriftart) && $viewer_schriftart != ""?"font-family:".$viewer_schriftart."; ":"";
$output_style_gesamt .= isset($viewer_rand) && $viewer_rand != ""?"border:".$viewer_rand."; ":"";
 
$output_style_liga = "";
$output_style_liga .= isset($viewer_ligenueberschrift_hintergrund) && $viewer_ligenueberschrift_hintergrund != ""?"background-color:".$viewer_ligenueberschrift_hintergrund."; ":"";
$output_style_liga .= isset($viewer_ligenueberschrift_schriftfarbe) && $viewer_ligenueberschrift_schriftfarbe != ""?"color:".$viewer_ligenueberschrift_schriftfarbe."; ":"";
 
$output_style_spiel = "";
$output_style_spiel .= isset($viewer_schriftfarbe) && $viewer_schriftfarbe != ""?"color:".$viewer_schriftfarbe."; ":"";
$output_style_spiel .= isset($viewer_schriftgroesse) && $viewer_schriftgroesse != ""?"font-size:".$viewer_schriftgroesse."; ":"";
 
 
$multi = isset($_GET['multi']) && strpos($_GET['multi'], "/") === FALSE? PATH_TO_ADDONDIR."/viewer/".$_GET['multi']:PATH_TO_ADDONDIR."/viewer/std.multi.inc.php";
require($multi);
setlocale(LC_ALL, "de_DE");
require(PATH_TO_ADDONDIR."/viewer/".$viewer_configfile);
//include (PATH_TO_ADDONDIR."/viewer/".$viewer_kopffile);
$dateien = file(PATH_TO_ADDONDIR."/viewer/".$viewer_datenfile);
$eintraege = count($dateien);
if (isset($check) && $check == 1) {
  echo "Einträge->".$eintraege."<br>";
  for ($i = 0; $i < $eintraege; $i++) {
    echo $i."->".$dateien[$i]."<br>";
  }
}
$template_hauptteil->replace("Liga", "");
for ($ix = 0; $ix < $eintraege; $ix++) {
  $datei = $dateien[$ix];
  $dat = explode(";", $dateien[$ix]);
  $f = trim(PATH_TO_LMO."/".$dat[0]);
  if (file_exists($f)) $filearray = file($f);
    else die("Datei $f nicht gefunden");
  // Datei komplett einlesen
  $template_liga = file_exists(PATH_TO_TEMPLATEDIR.'/viewer/'.$template."-liga.tpl.php")?new LBTemplate('viewer/'.$template."-liga.tpl.php"):new LBTemplate("viewer/standard-liga.tpl.php");
   
  require(PATH_TO_ADDONDIR."/viewer/".$viewer_anzeigenfile);
   
  $template_hauptteil->add("Liga", $template_liga);
}
$template_hauptteil->replace("Ueberschrift", $output_ueberschrift);
$template_hauptteil->replace("Hauptstyle", $output_style_gesamt);
$template_hauptteil->replace("Ligastyle", $output_style_liga);
$template_hauptteil->replace("Spielstyle", $output_style_spiel);
$template_hauptteil->show();

//include (PATH_TO_ADDONDIR."/viewer/".$viewer_fussfile);

function zeitberechnung($modus,$wert)  {
	// Gibt verschiedene Werte je nach $Modus zur ck:
	// 1 = Tag + $wert (Tage) um 0:00 Uhr als Zeitstempel
    // wird st&bdquo;ndig nach Bedarf erweitert
	switch($modus) {
		case "1":
			return mktime(0,0,0,date("m"), date("d")+$wert ,date("Y"));	// Gibt heutigen Tag um 0:00 Uhr als Zeitstempel zur ck
	    break;
    case "2":
      return mktime(23,59,0,date("m"), date("d")+$wert ,date("Y"));    // Gibt heutigen Tag + $wert (Tage) um 23:59 Uhr als Zeitstempel zurück
      break; 
	  default:
	    return false;
  }
}
?>