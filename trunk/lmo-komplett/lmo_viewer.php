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
if (isset($HTTP_GET_VARS['multi']) && strpos($HTTP_GET_VARS['multi'],"http:")===FALSE) {
	$multi=$HTTP_GET_VARS['multi'];
} else {
	$multi="std.multi.inc.php";
}
require($multi);

require($configfile);
require($url.$anzeigenfile);
include ($url.$kopffile);
$dateien=file($url.$datenfile);
$eintraege=count($dateien);
if (isset($check) && $check==1) {
	echo "Einträge->".$eintraege."<br>";
	for ($i=0; $i<$eintraege; $i++) {
		echo $i."->".$dateien[$i]."<br>";
	}
}

if (!isset($version) || $version!="lang") {
	for ($i=0; $i<=$eintraege; $i++) {
		if (chop($dateien[$i])=="***") { break; }
		lmo_view($dateien[$i],"",$multi);
	}
}
if (isset($version) && $version=="lang") {
	for ($i=0; $i<=$eintraege; $i++) {
		if (chop($dateien[$i])=="***") { break; }
		$spiele[$i]=lmo_view($dateien[$i],"lang",$multi)."<br>";

	}

}



include ($url.$fussfile);
?>
