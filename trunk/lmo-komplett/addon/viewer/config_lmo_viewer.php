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
//= Copyright: Das ver„ndern des Copyrights ist strikt untersagt!          =//
//= ALLE Angabe mssen unver„ndert stehen bleiben.                         =//
//= ----------------------------------------------						   =//
//= Ich wrde gerne wissen, wo das Script im Einsatz                       =//
//= ist. Also schickt mir doch bitte ne Mail wenn ihr es einsetzt und wo.  =//
//= Vorteil: Ich schau mir das an und kann dann evtl. Verbesserungen       =//
//= vornehmen. Eine Mail ist doch nicht zuviel verlangt oder?              =//
//==========================================================================//
//= Diese Datei:                                                           =//
//= CONFIG_LMO_VIEWER.PHP                                                  =//
//= Steuerungsdatei fr den LMO_VIEWER                                     =//
//= in den Kommentaren ist aufgelistet was eingegeben werden muss          =//
//////////////////////////////////////////////////////////////////////////////

isset($_GET['stylefile'])?$design=$_GET['stylefile']:$design='lmo-style.css';          			// Design angeben

$PM="Bernd Feser";															  //*************************************************//
$PV="V1.161";																  //  NICHT VERŽNDERN!                               //
$PN="LMO-Viewer";                                                             //  COPYRIGHTANGABEN!                              //
$FO="http://www.hollwitz.de/forum/";  //  SIEHE KOPFTEXT DIESER DATEI                    //
$DL="http://www.hollwitz.de/forum/";         //                                                 //
$PL="bfeser@feser.de";                                                        //*************************************************//


$design='<link rel=stylesheet type="text/css" href="'.URL_TO_LMO.'/'.$viewer_designfile.'">';
switch($viewer_datumsformat) {
	case 0: $dat_format="%d.%m.%Y";break;
	case 1:	$dat_format="%d.%m.%y";break;
	case 2:	$dat_format="%d.%b.%Y";break;
	case 3:	$dat_format="%d.%b.%y";break;
	case 4:	$dat_format="%d. %B %Y";break;
	case 5:	$dat_format="%a. %d.%m.%Y";break;
	case 6:	$dat_format="%a. %d.%m.%y";break;
	case 7:	$dat_format="%a. %d.%b. %Y";break;
	case 8:	$dat_format="%a. %d.%B Y%";break;
	case 9:	$dat_format="%a. %d.%m.%y";break;
	case 10:$dat_format="%A, %d.%m.%y";break;
	case 11:$dat_format="%A, %d.%b.%Y";break;
	case 12:$dat_format="%A, %d. %B %Y";break;
	default:$dat_format="%d.%m.%y";break;
}

$uhr_format="";
if ($viewer_uhrformat==1) {$uhr_format="  %H:%M";}
if ($viewer_uhrformat==2) {$uhr_format="  %H:%M ".$text['viewer'][5];}

?>