<?
//////////////////////////////////////////////////////////////////////////////
//= LMO-VIEWER 															   =//
//= Zur Anzeige der n„chsten X Spiele aus dem                              =//
//= Liga-Manager Online von Frank Hollwitz                                 =//
//= http://www.hollwitz.de												   =//
//= Copyright: 2002 Bernd Feser                                            =//
//= Download:                                                              =//
//= http://www.schohentengen.de/Website/plink/index.php?showcat=11         =//
//= Supportforum:														   =//
//= http://www.schohentengen.de/Interaktiv/Diskussion/index.php?showkat=3  =//
//==========================================================================//
//= Copyright und sonstiges bla bla spare ich mir. Erstens will ich nix    =//
//= dafr, ausserdem ist das Script (noch) alles andere als perfekt.       =//
//= Des weiteren erspare ich mir manchen Žrger :-)						   =//
//= Nur so viel. Ich wrde einfach gerne wissen, wo das Script im Einsatz  =//
//= ist. Also schickt mir doch bitte ne Mail wenn ihr es einsetzt und wo.  =//
//= Vorteil: Ich schau mir das an und kann dann evtl. Verbesserungen       =//
//= vornehmen. Eine Mail ist doch nicht zuviel verlangt oder?              =//
//==========================================================================//
//= Diese Datei:                                                           =//
//= LMO_VIEWER.PHP                                                         =//
//= Diese Datei aufrufen, an der Stelle, an der die Auflistung erfolgen    =//
//= soll. Die Seite muss die Endung ".php" haben.                          =//
//= Gesteuert wird die Ausgabe von der CONFIG_LMO_VIEWER.PHP			   =//
//= und der lmo_viewer_dat.inc.php										   =//
//= Normalerweise mssen und sollen nur dise beiden Dateien 			   =//
//= ver„ndert resp. angepasst werden.									   =//
//////////////////////////////////////////////////////////////////////////////
require_once(dirname(__FILE__).'/../../init.php');
require_once(PATH_TO_ADDONDIR."/viewer/lmo_viewer_func.php");
$template=isset($_GET['template'])?$_GET['template']:"";
$template_hauptteil=file_exists(PATH_TO_TEMPLATEDIR.'/viewer/'.$template."-haupt.tpl.php")?new LBTemplate('viewer/'.$template."-haupt.tpl.php"):new LBTemplate("viewer/standard-haupt.tpl.php");

$akt_date_ts = time();  // Aktuelle Zeit im Unix-Zeitstempel-Format (UZF)
$date_anfang_ts = zeitberechnung("1", -$viewer_tage_minus);  // Anzeige ab wann?
$date_ende_ts = zeitberechnung("1", $viewer_tage_plus);  // Anzeige bis wann?
$akt_heute = zeitberechnung("1", "0");
$akt_morgen = zeitberechnung("1", "1");

//Überschrift
$output_ueberschrift=$text['viewer'][4]." ".date(" d.m.Y",$date_anfang_ts)." - ".date("d.m.Y",$date_ende_ts);

//Styles
$output_style_gesamt="";
$output_style_gesamt.=isset($viewer_hintergrund) && $viewer_hintergrund!=""?"background-color:".$viewer_hintergrund."; ":"";
$output_style_gesamt.=isset($viewer_schriftart) && $viewer_schriftart!=""?"font-family:".$viewer_schriftart."; ":"";
$output_style_gesamt.=isset($viewer_rand) && $viewer_rand!=""?"border:".$viewer_rand."; ":"";

$output_style_liga="";
$output_style_liga.=isset($viewer_ligenueberschrift_hintergrund) && $viewer_ligenueberschrift_hintergrund!=""?"background-color:".$viewer_ligenueberschrift_hintergrund."; ":"";
$output_style_liga.=isset($viewer_ligenueberschrift_schriftfarbe) && $viewer_ligenueberschrift_schriftfarbe!=""?"color:".$viewer_ligenueberschrift_schriftfarbe."; ":"";

$output_style_spiel="";
$output_style_spiel.=isset($viewer_schriftfarbe) && $viewer_schriftfarbe!=""?"color:".$viewer_schriftfarbe."; ":"";
$output_style_spiel.=isset($viewer_schriftgroesse) && $viewer_schriftgroesse!=""?"font-size:".$viewer_schriftgroesse."; ":"";


$multi=isset($_GET['multi']) && strpos($_GET['multi'],"/")===FALSE? PATH_TO_ADDONDIR."/viewer/".$_GET['multi']:PATH_TO_ADDONDIR."/viewer/std.multi.inc.php";
require($multi);
setlocale(LC_ALL, "de_DE");
require(PATH_TO_ADDONDIR."/viewer/".$viewer_configfile);
//include (PATH_TO_ADDONDIR."/viewer/".$viewer_kopffile);
$dateien=file(PATH_TO_ADDONDIR."/viewer/".$viewer_datenfile);
$eintraege=count($dateien);
if (isset($check) && $check==1) {
	echo "Einträge->".$eintraege."<br>";
	for ($i=0; $i<$eintraege; $i++) {
		echo $i."->".$dateien[$i]."<br>";
	}
}
$template_hauptteil->replace("Liga","");
for ($ix=0; $ix<$eintraege; $ix++) {
  $datei=$dateien[$ix];
  $dat = explode(";", $dateien[$ix]);
  $f = trim(PATH_TO_LMO."/".$dat[0]);
  if (file_exists($f)) $filearray = file($f); else die("Datei $f nicht gefunden");  // Datei komplett einlesen
  $template_liga=file_exists(PATH_TO_TEMPLATEDIR.'/viewer/'.$template."-liga.tpl.php")?new LBTemplate('viewer/'.$template."-liga.tpl.php"):new LBTemplate("viewer/standard-liga.tpl.php"); 
 
  require(PATH_TO_ADDONDIR."/viewer/".$viewer_anzeigenfile);
  
  $template_hauptteil->add("Liga",$template_liga);
}
$template_hauptteil->replace("Ueberschrift", $output_ueberschrift);
$template_hauptteil->replace("Hauptstyle", $output_style_gesamt);
$template_hauptteil->replace("Ligastyle", $output_style_liga);
$template_hauptteil->replace("Spielstyle", $output_style_spiel);
$template_hauptteil->show();
//include (PATH_TO_ADDONDIR."/viewer/".$viewer_fussfile);
?>