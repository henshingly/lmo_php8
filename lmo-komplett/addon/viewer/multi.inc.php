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
//= multi.inc.php                                                          =//
//= Um das Script mehrfach, mit anderen Parametern aufzurufen,             =//
//= wird diese Datei ben”tigt.                                             =//
//= Jede Datei, die Žnderungen gegenber den parallel laufenden Scripts    =//
//= ben”tigt wird mit einem Prefix versehen.                               =//
//= NUR ŽNDERN WENN DAS SCRIPT IM MULTI_MODUS BETRIEBEN WERDEN SOLL!!!     =//
//////////////////////////////////////////////////////////////////////////////

$prefix="";                                        // Hier ein beliebiges Prefix angeben z.B. "pa1-"
$viewer_configfile=$prefix."config_lmo_viewer.php";       // Hier jeweils bei UNVERŽNDERTEN DATEIEN das
$viewer_anzeigenfile=$prefix."lmo_viewer_anzeigen.php";	   // 'prefix.' ENTFERNEN. Selbstredend muss die
$viewer_kopffile=$prefix."lmo_viewer_kopf.php";			   // enstprechende Datei dann auch mit dem
$viewer_fussfile=$prefix."lmo_viewer_fuss.php";		   // prefix benannt werden. im o.g. Beispiel also:
$viewer_designfile=$prefix."lmo-style.css";			   // 'pa1-lmo-style.css'
$viewer_datenfile=$prefix."lmo_viewer_dat.inc.php";
// Ich hoffe das ist einigermassen klargeworden! ansonsten fragt im Forum an oder auch bei BerndH,
// info@salzland-info.de fr ihn habe ich dieses Feature implementiert. Er betreibt das
// ganze in diesem Modus.
// Beim Aufruf des Viewers wird dann dieses File als Parameter mitgegeben und zwar mittels
// http://domain.tld/lmo/lmo-viewer?multi=multi.inc.php
// Damit diejenigen, die dieses Feature nicht brauchen (so wie ich ;-))  ) sich damit nicht rumschlagen mssen,
// wird, wenn dieser Parameter NICHT mitgegeben wird, die Standardconfiguration aufgerufen.
?>
