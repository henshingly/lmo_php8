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
//= LMO_VIEWER_FUNC.PHP                                                    =//
//= Funktionen fr den LMO_VIEWER                                          =//
//= wird bei Updates st„ndig erweitert                                     =//
//////////////////////////////////////////////////////////////////////////////

function zeitberechnung($modus,$wert)  {
	// Gibt verschiedene Werte je nach $Modus zurck:
	// 1 = Tag + $wert (Tage) um 0:00 Uhr als Zeitstempel
    // wird st„ndig nach Bedarf erweitert
	switch($modus) {
		case "1":
			return mktime(0,0,0,date("m"), date("d")+$wert ,date("Y"));	// Gibt heutigen Tag um 0:00 Uhr als Zeitstempel zurck
	    break;
    case "2":
      return mktime(23,59,0,date("m"), date("d")+$wert ,date("Y"));    // Gibt heutigen Tag + $wert (Tage) um 23:59 Uhr als Zeitstempel zurück
      break; 
	  default:
	    return false;
  }
}