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
$debug=1;                                                                     //Bei lokalem Einsatz auf 1 setzen.

$url="/html/tmp/LMO-Komplett/lmo/";	// absoluter pfad zum lmo_viewer (MIT / am Ende)!
																// Wenn Du ihn nicht weisst, versuchs mit dem "http://...."-Pfad
$url1="http://localhost/tmp/LMO-Komplett/lmo";					//http://www.usw-Pfad zum lmo-viewer
$anz_tage_plus=7;						// Anz. Tage NACH aktuellem Datum die angezeigt werden sollen
$anz_tage_minus=7;						// Anz. Tage VOR aktuellem Datum die angezeigt werden sollen
$kurz=0;								// Anzeige lange Namen = 0, kurze Namen = 1
$heute=1;								//heutigen Tag hervorheben?
$f_class_normal="lmost5";               // Tabellenklasse normal
$f_class_ausz="lmotab5";					// Hervorhebungsklasse
//$lokalanzeige="german_Germany";  		// ISO-L„ndercode (fr Windows-Server) deutsche Ausgabe der Tage
$lokalanzeige='de_DE';  				// ISO-L„ndercode (fr unix/Linux-Server) deutsche Ausgabe der Tage
										// kommt auf das Betriebssystem des Webservers an.
$tabellenlink=4;						// zur Tabelle verlinken? 1=ja, 0=nein, 2= nur wenn Ergebnis vorhanden
										// 3= mit Datum verlinken 4 = ja UND mit Datum verlinken
$tabellenlink_neuesfenster=0;           // Tabelle im neuen Fenster? 1=ja, 0=nein
$tabellenbild="tabelle.gif";
$homepages_newwindow=1;					// Vereinshomepages in neuem Fenster? 1=ja, 0=Standardeinstellung des Frames
$homepages=1;							// Vereinshomepages verlinken? 1=ja, 0=nein;
$spieltagflag=1;						// Spieltag anzeigen 1=ja, 0=nein;
$spieltag_txt="Spieltag ";              		// Text fr Spieltag
$notizflag=1;
$notizbild="lmo-st2.gif";
$datumflag=1;							// Anstoázeit als Tabellenzeile=0; als Spalte=1;
$spielberichte=1;						// Spielberichte verlinken? 1=ja, 0=nein
$neuesfenster=1;                        // Spielberichte in neuem Fenster anzeigen 1=ja, 0=nein;
$spielberichtsbild="lmo-st1.gif";       // Spielberichts_Icon
$tore_anzeigen=2;						// 0 = Nie, 1=immer, 2=nur wenn Ergebnis vorhanden
$zeichen_kein_tor="_";					// Zeichen, das in der Torspalte angezeigt wird, wenn noch kein Ergebnis existiert.
$spez="*";								// Spezialzeichen, welches nicht in den Mannschaftsnamen auftauchen darf
$datumsformat=6;						// 0= 01.10.2002
										// 1= 01.10.02
										// 2= 01.Okt.2002
										// 3= 01.Okt.02
										// 4= 01. Oktober 2002
										// 5= Die. 01.10.2002
										// 6= Die. 01.10.02
										// 7= Die. 01.Okt. 2002
										// 8= Die. 01. Oktober 2002
                                    	// 9= Dienstag, 01.10.2002
										// 10= Dienstag, 01.10.02
										// 11= Dienstag, 01.Okt.2002
										// 12= Dienstag, 01. Oktober 2002
$uhrformat=1;							// 0= keine Uhrzeit,
										// 1= 17:25,
                                        // 2= 17:25 Uhr
//============ unterhalb nichts mehr „ndern ======================= //


















isset($_GET['stylefile'])?$design=$_GET['stylefile']:$design='lmo-style.css';          			// Design angeben
$datenfile=$datendatei;    // Datei mit den Liga-Filenamen, die angezeigt werden sollen.
										// ACHTUNG UNBEDINGT README lesen fr den Aufbau dieser Datei!!!!
										// Das Datenfile enth„lt die Dateinamen derjenigen Ligen und die Indexe der Mannschaften
										// die in die šbersicht aufgenommen werden sollen









$PM="Bernd Feser";															  //*************************************************//
$PV="V1.161";																  //  NICHT VERŽNDERN!                               //
$PN="LMO-Viewer";                                                             //  COPYRIGHTANGABEN!                              //
$FO="http://www.hollwitz.de/forum/";  //  SIEHE KOPFTEXT DIESER DATEI                    //
$DL="http://www.hollwitz.de/forum/";         //                                                 //
$PL="bfeser@feser.de";                                                        //*************************************************//

if ($debug=="1") {
	$url="";
	$url1="";
}
$spberanf='<a href=';
$spberende='target=_self><img border="0" src="'.$url1.$spielberichtsbild.'" alt="Spielbericht anzeigen" width="16" height="16"></a>';
$spberende2='target="_blank"><img border="0" src="'.$url1.$spielberichtsbild.'" alt="Spielbericht in neuem Fenster anzeigen" width="16" height="16"></a>';
$notizanf='<img border="0" src="'.$url1.$notizbild.'" alt=';
$notizende='" width="16" height="16"></a>';

$design='<link rel=stylesheet type="text/css" href="'.$url1.$designfile.'">';
switch($datumsformat) {
	case 0:
		$dat_format="%d.%m.%Y";
		break;
	case 1:
		$dat_format="%d.%m.%y";
		break;
	case 2:
		$dat_format="%d.%b.%Y";
		break;
	case 3:
		$dat_format="%d.%b.%y";
		break;
	case 4:
		$dat_format="%d. %B %Y";
		break;
	case 5:
		$dat_format="%a. %d.%m.%Y";
		break;
	case 6:
		$dat_format="%a. %d.%m.%y";
		break;
	case 7:
		$dat_format="%a. %d.%b. %Y";
		break;
	case 8:
		$dat_format="%a. %d.%B Y%";
		break;
	case 9:
		$dat_format="%a. %d.%m.%y";
		break;
	case 10:
		$dat_format="%A, %d.%m.%y";
		break;
	case 11:
		$dat_format="%A, %d.%b.%Y";
		break;
	case 12:
		$dat_format="%A, %d. %B %Y";
		break;
	default:
		$dat_format="%d.%m.%y";
		break;
}

$uhr_format="";
if ($uhrformat==1) {$uhr_format="  %H:%M";}
if ($uhrformat==2) {$uhr_format="  %H:%M Uhr";}

?>