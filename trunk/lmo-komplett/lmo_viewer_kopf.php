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
//= http://www.schohentengen.de/Website/plink/index.php?showcat=11         =//
//= http://www.schohentengen.de/Interaktiv/Diskussion/                     =//
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
//= LMO_VIEWER_KOPF.PHP                                                     =//
//= schreibt den Tabellenkopf, das Design usw.                             =//
//= an den Ausgaben kann ge„ndert werden. An HTML und PHP Befehlen NICHT!  =//
//////////////////////////////////////////////////////////////////////////////

if (isset($multi) && strpos($multi,"http:")===FALSE) {
	require($multi);
	} else {
		require("std.multi.inc.php");
	}

require($url.$configfile);
$akt_date_ts=time();
$date_anfang_ts=$akt_date_ts-(24*60*60*$anz_tage_minus);    // Anzeige ab wann?
$date_ende_ts=$akt_date_ts+(60*60*24*$anz_tage_plus);       // Anzeige bis wann?
echo $design;
?>
<div align="center"><center>
<table><tr><th colspan='9' class='lmomain0'>Spiele vom
<?
 echo date(" d.m.Y",$date_anfang_ts)." - ".date("d.m.Y",$date_ende_ts) ?></th></tr>
