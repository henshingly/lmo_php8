<?PHP
/**
 * LMO Class Library Version (01/2004)
 *
 * Die LMO Class Library (classlib) bildet ein Ligadatei (.l98) des LMO
 * in Form eines Objektbaums ab und ermöglicht so die Entwicklung von
 * objektorientierten Erweiterung in Form von sog. Addons für den Liga Manager Online.
 *
 * <br>Änderungen:
 * <br> 20.07.04 2.0 Start
 * <br> 22.07.04 2.1 Pdf Class hinzugefügt.
 * <br> 23.07.04 2.1 Bugfix in methode $liga->writeFile teamdetails gingen verloren
 * <br> 31.07.04     relative Pfadangabe in class.ezpdf.php ersetzt
 * <br> 01.08.04 2.2 Spielbericht (reportURL) zur class Partie hinzugefügt
 * <br>              Beim Einlesen der Runden wird jetzt der Pokalmodus berücksichtigt
 * <br> 20.09.04 2.3 Class iniFile function getIniFile
 * <br>              Beim Auslesen einer URL, die keyValues enthält
 * <br>              fehlten die Gleichheitszeichen
 * <br> 22.09.04 2.3 Pokalmodus in loadLiga implementiert
 * <br> 22.11.04 2.4 Mal wieder keyValue gefunden und in keyValues geändert
 * <br>              classes.php Ist der aktuelle Spieltag nicht gesetzt wird $aktSpTag = 1
 * <br> 02.12.04 2.5 writeFile / loadFile geändert
 * <br>              Das komplette File wird zunächst in ein array geladen und zwischengespeichert.
 * <br>              Beim Speichern wird dieses zunächst mit den Werten der Objekte abgeglichen und
 * <br>              dann im Anschluss komplett ins file geschrieben. Dadurch gehen keine Informationen verloren
 * <br>              Auch Erweiterungen des LigaFiles (z.B, zusätzliche Sektionen wie beim MittellangTeamName
 * <br>              Addon werden erkannt und geschrieben.
 * <br> 20.12.04 2.6 neue Fktion gamesSorted hinzugefügt (Sortierung der Partien)
 * <br> 14.01.05 2.6 SP1 Klasse Partie function valuateGame() Ermittelt die Wertung einer Partie (beta Status)
 * <br> 16.02.05 2.7 Klasse Partie fkt. gToreString() und hToreString() überarbeitet. Bei greenTable wird 0 bzw. 0*
 *									 zurückgegeben.
 * <br> 10.04.05 2.7 (Dank an Gowi) update Funktionen für addons implementiert
 * @author    Tim Schumacher <webobjects@gmx.net>
 * @version   2.7
 * @package   classLib
*/
//
// LMO Class Library Version (01/2004)
// Copyright (C) 2004 by Tim Schumacher
// webobjects@gmx.net /
//
// This program is free software; you can redistribute it and/or
// modify it under the terms of the GNU General Public License as
// published by the Free Software Foundation; either version 2 of
// the License, or (at your option) any later version.
//
// This program is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
// General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with this program; if not, write to the Free Software
// Foundation, Inc., 675 Mass Ave, Cambridge, MA 02139, USA.

/**
 * Team
 *
 * Mannschaft (Team), die an einer Liga teilnimmt
 *
 * @package   classLib
*/

class team {
/**
 * Name der Mannschaft
 * @var string
 *
*/
  var $name;
/**
 * Kurzbezeichnung (max.5 Zeichen)
 * @var string
 *
*/
  var $kurz;
/**
 * Mittellanger Teamname
 * @var string
 *
*/
  var $mittel;
/**
 * Nummer der Mannschaft, entspricht der Nr aus dem Ligafile
 * @var integer
 *
*/
  var $nr;
/**
 * KeyValue Paare, die in der Team Sektion angegeben wurden.
 *
 * Beispiel:
 * In einem LigaFile existiert in der Sektion [Team2] der Eintrag URL=http://www.hsv.de
 * Um die URL des Teams anzusprechen schreibt man: $url = $myTeam->keyValues['URL'];
 *
 * @var array
*/
  var $keyValues;

  function team($name="",$kurz="",$nr="") {
    $this->name = $name;
    $this->kurz = $kurz;
//    $this->mittel = null; Wird noch nicht verwendet da MittellangeNamen noch nicht zu standard gehören
    $this->nr = $nr;
    $this->keyValues = array("SP"=>0,"SM"=>0,"TOR1"=>0,"TOR2"=>0,"STDA"=>0,"URL"=>"","NOT"=>"");
  }

/**
 * Fügt ein neues KeyValue Paar hinzu
 *
 * @access private
*/
  function addKeyValue ($new_key,$new_value) {
    $this->keyValues[$new_key]=$new_value;
  }
/**
 * Gibt value zu einem Key zurück
 *
 * @access private
*/
  function valueForKey($new_key) {
    return $this->keyValues[$new_key];
  }
} // class team


/**
 * Partie
 *
 * Partie, die in einer Liga gespielt wird
 *
 * @package   classLib
*/

class partie {
/**
 * Nummer der Partie,
 * @var integer
 * @access public
*/
  var $spNr;
//  var $n_SpNr;
/**
 * Datum der Partie,
 * @var date
 * @access public
*/
  var $zeit;
/**
 * Notiz zur Partie,
 * @var string
 * @access public
*/
  var $notiz;
/**
 * Heimmannschaft der Partie,
 * @var array Team Objekt
 * @access public
*/
  var $heim;
/**
 * Gastmannschaft der Partie,
 * @var array Team Objekt
 * @access public
*/
  var $gast;
/**
 * Heimtore der Partie,
 * @var integer
 * @access public
*/
  var $hTore;
/**
 * Gasttore der Partie,
 * @var integer
 * @access public
*/
  var $gTore;
/**
 * Heimpkte der Partie,
 * @var integer
 * @access private
*/
  var $hPunkte;
/**
 * Gastpkte der Partie,
 * @var integer
 * @access private
*/
  var $gPunkte;

/**
 * URL zum Spielbericht der Partie
 * @var string
 * @access public
*/
  var $reportUrl;

/**
 * Spielende
 * Neu ab 2.2 Spielende
 * 0 = reguläres Ende
 * 2 = Verlängerung
 * 1 = 11-Meter-Schießen
 * @var integer
 * @access public
*/
  var $spielEnde;

  function partie($n_spNr,$n_time,$n_notiz,
           &$n_heim,&$n_gast,$n_htore,
           $n_gtore,$n_hpunkte,$n_gpunkte) {
    $this->spNr = $n_spNr;
    $this->zeit = $n_time;
    $this->notiz = $n_notiz;
    $this->heim = &$n_heim;
    $this->gast = &$n_gast;
    $this->hTore = $n_htore;
    $this->gTore = $n_gtore;
    $this->hPunkte = $n_hpunkte;
    $this->gPunkte = $n_gpunkte;
    $this->reportUrl = NULL;
    $this->spielEnde = NULL;
  }


/**
* Gibt Tore der Heimmanschaft für die Bildschirmausgabe zurück.
*
* Die Ausgabe von negativen Werten wird zur Bildschirmausgabe unterdrückt.
* So werden negative Ergebnisse bzw Ergebnisse von Partien die noch nicht
* stattfanden durch den Parameterwert für $leer angezeigt.
* @access public
* @param  string $leer Der Rückgabewert wenn Ergebnis vorhanden ist
* @return string
*/
  function hToreString($leer="_") {
  	if ($this->hTore == -1) $str = $leer;
  	elseif ($this->hTore == -2) $str = "0*"; // Markieren als greenTable
  	elseif ($this->gTore == -2) $str = "0"; // Wenn Gast der Sieg zugesprochen wurde O Tore für Heim anzeigen
    else $str = $this->hTore;
    return $str;
  }

/**
* Gibt Tore der Gastmannschaft für die Bildschirmausgabe zurück.
*
* Die Ausgabe von negativen Werten wird zur Bildschirmausgabe unterdrückt.
* So werden negative Ergebnisse bzw Ergebnisse von Partien die noch nicht
* stattfanden durch den Parameterwert für $leer angezeigt.
* @access public
* @param  string $leer Der Rückgabewert wenn kein Ergebnis vorhanden ist
* @return string
*/
  function gToreString($leer = "_") {
  	if ($this->gTore == -1) $str = $leer;
  	elseif ($this->gTore == -2) $str = "0*"; // Markieren als greenTable
  	elseif ($this->hTore == -2) $str = "0"; // Wenn Heim der Sieg zugesprochen wurde O Tore für Gast anzeigen
    else $str = $this->gTore;
    return $str;
  }

/**
* Ermittelt die Wertung der Partie
*
* Result Value
* -1: no result
* 0	: draw
* 1 : home wins
* 2 : away wins
*
* @access public
* @param
* @return integer
*/
  function valuateGame() {
  	$result = -1;
  	if ($this->hTore > -1 and $this->gTore > -1) { // ok there is a result
			if ($this->hTore > $this->gTore) { // home wins
				$result = 1;
			}
			elseif ($this->hTore < $this->gTore) { // away wins
				$result = 2;
			}
			else { // Unendschieden
				$result = 0;
			}
		}
		elseif($this->hTore == -2) { // green Table home wins
			$result = 1;
		}
		elseif($this->gTore == -2) {// green Table away wins
			$result = 2; // Bugfix 14.2.05 $result = 1
		}

    return $result;
  }


/**
* Gibt das SpielDatum als formatierten String zurück. ("d.m.Y")
*
* @access public
* @return string
*/
function datumString($leer='') {
        $str = ($this->zeit<1)?$leer:date("d.m.Y",$this->zeit);
    return $str;
  }

/**
* Gibt die Anwurfzeit als formatierten String zurück ("Stunden:Minuten").
*
* @access public
* @return string
*/

   function zeitString($leer='') {
        $str = ($this->zeit<1)?$leer:date("H:i",$this->zeit);
    return $str;
  }

/**
* Debugfunktion.
*
* @access private
*/
  function showDetails() {
    echo $this->heim->name." - ".$this->gast->name;
    echo " Anpfiff: ".$this->zeitString()."Uhr";
    echo " Ergebnis:".$this->hTore." - ".$this->gTore."\n";
  }

/**
* Debugfunktion.
*
* @access private
*/
  function showDetailsHTML() {
    echo "<BR>".$this->heim->name." - ".$this->gast->name;
    echo " Anpfiff: ".$this->zeitString()."Uhr";
    echo " Ergebnis:".$this->hTore." - ".$this->gTore;
  }

}

/**
* Spieltag
*
* Repräsentiert einen Spieltag
* <BR>Eine Liga hat mehrere Spieltage.
* <BR>An einem Spieltag finden mehrere Partien statt.
*
* @package   classLib
* @access public
*/

class spieltag {

/**
 * Spieltagsnummer,
 * @var integer
 * @access public
*/
  var $nr;
/**
 * vonDatum als string,
 * @var string
 * @access public
*/
  var $von;
/**
 * bisDatum als string,
 * @var string
 * @access public
*/
  var $bis;
/**
 * Partien des Spieltages,
 * @var array of spieltag objects
 * @access public
*/
  var $partien;

  function spieltag($new_nr,$new_von,$new_bis,$partien=array()) {
    $this->nr = $new_nr;
    $this->von = $new_von;
    $this->bis = $new_bis;
    $this->partien = $partien;
  }

/**
* Gibt Partie der angegebener Nummer zurück
*
* @access public
* @parameter integer Partienummer
* @return object Die Partie
*/
  function &partieForNumber($number) {
    $result = null;
// Bugfix 13.10.04    if(isset($number) and $nNumber > 0 and $number <= $this->partienCount())
    if(isset($number) and $number > 0 and $number <= $this->partienCount())
      $result = $this->partien[$number-1];
    return $result;
  }

/**
* Gibt Partie der angegebener Teamnummern zurück
*
* @access public
* @parameter integer Heimmannschaftsnummer integer Gastmannschaftsnummer
* @return object Die Partie
*/
  function &partieForTeams($heimNr,$gastNr) {
    $count = $this->partienCount();
    $i = -1;
    $found=-1;
    $selectedTag = null;
    while (($i<$count) and ($found<>0)):
      $i++;
      if (isset($this->partien[$i]) and ($this->partien[$i]->heim->nr = $heimNr) and ($this->partien[$i]->gast->nr = $gastNr))
        $found = 0;

    endwhile;
    if ($found==0) return $this->partien[$i];
    else return null;
  }

/**
* Gibt Partie der angegebener Teamnamen zurück
*
* @access public
* @parameter string Heimmannschaftsname string Gastmannschaftsname
* @return object Die Partie
*/
    function &partieForTeamNames($heimName,$gastName) {
        $result = Null;
        foreach ($this->partien as $aPartie) {
            if (($aPartie->heim->name == $heimName ) and ($aPartie->gast->name == $gastName)) {
              $result = $aPartie;
              break;
            }
        }
        return $result;
  }


/**
* Löscht Partie
*
* @access public
* @parameter objekt Partie
* @return bool Partie wurde gelöscht TRUE / FALSE
*/
  function removePartie(&$rmvPartie) {
    $result = False;
    reset($this->partien);
    $partienArray = $this->partien;
    $index = 0;
    foreach ($this->partien as $aPartie) {
      if ($rmvPartie == $aPartie) {
        unset($partienArray[$index]);
        $partienArray=array_values($partienArray); // Index neu erstellen
        $result = True;
        break;
      }
      else {
        next($partienArray);
        $index++;
      }
    }
    if(isset($partienArray)) {
      $this->partien = &$partienArray;
    }
    else
      $this->partien = null;

  return $result;
  }


/**
* Anzahl der Partien des Spieltages
*
* @access public
* @return integer Partieanzahl
*/
  function partienCount() {
    return count($this->partien);
  }

/**
* Fügt Partie zum Spieltage hinzu
*
* @access public
* @parameter Object die Partie
*/
  function addPartie(&$neuePartie) {
    $this->partien[] = $neuePartie; // &$ Das muss so sein
  }

/**
* Debugfunktion.
*
* @access private
*/
  function showDetails() {
    echo "\n".$this->nr.". Spieltag (".$this->vonBisString().")\n";
    foreach ($this->partien as $partie) {
      echo $partie->showDetails()."\n";
    }
  }

/**
* Debugfunktion.
*
* @access private
*/
  function showDetailsHTML() {
    echo "<BR>".$this->nr.". Spieltag (".$this->vonBisString().")";
    foreach ($this->partien as $partie) {
      echo "<BR>".$partie->showDetailsHTML();
    }
  }

/**
* Gibt den Zeitrahmen aus, an dem der Spieltag ausgetragen wird
*
* Sind das vonDatum und das bisDatum gesetzt wird zB. 10.10.2003 - 19.10.2003 zurückgegeben
* <BR> Ist eines der beiden nicht gesetzt, wird nur das Datum zurückgeben ohne Verbinder
* <BR> zB. ist das vonDatum nicht gesetzt wird nur das bisDatum ausgegeben 19.10.2003 ohne Bindestrich
* @access public
* @return string
*/
  function vonBisString() {
    $von = "";
    $bis = "";
    if ($this->von!='')
      $von = date("d.m.Y",$this->von);
    if ($this->bis!='')
      $bis = date("d.m.Y",$this->bis);

    if ($von!='' and $bis!='')
      return $von." - ".$bis;
    return $von.$bis;
  }

/**
* Gibt das vonDatum, an dem der Spieltag ausgetragen wird
*
* @access public
* @return string
*/
  function vonString() {
    $von = "";
    if ($this->von!='')
      $von = date("d.m.Y",$this->von);
    return $von;
  }

/**
* Gibt das bisDatum, an dem der Spieltag ausgetragen wird
*
* @access public
* @return string
*/
  function bisString() {
    $bis = '';
    if ($this->bis!='')
      $bis = date("d.m.Y",$this->bis);
    return $bis;

  }

} // END class spieltag

/**
 * Sektion
 *
 * Sektionen eines LigFiles zB. [Round1]
 *
 * @package   classLib
 * @access  public
*/

class sektion {
  var $keyValues;
  var $name;

  function sektion($new_name) {
    $this->name = $new_name;
    $this->keyValues = array();
  }

  function sektionName() {
    return "[".$this->name."]";
  }

  function setKeyValue ($new_key,$new_value) {
    $this->keyValues[$new_key]=$new_value;
  }

  function addKeyValue ($new_key,$new_value) {
    $this->keyValues[$new_key]=$new_value;
  }

  function valueForKey($key) {
    return $this->keyValues[$key];
  }

  function HTMLoutput() {
    echo"<BR>".$this->sektionName();
    foreach ($this->keyValues as $key=>$value) {
      echo"<BR>$key = $value";
    }
  }
}

/**
 * OptionSektion
 *
 * Sektionen eines LigFiles in dem die Optionen angegeben sind [Options]
 *
 * @package   classLib
 * @access public
 *
*/

class optionsSektion extends sektion {
/**
 * Nummer der Liga,
 * @var array Liga objekt
*/
  var $aLiga;
/**
 * Mit diesen Optionen wird ein neus Ligafile erzeugt
 * @var array of predefined keyValues
 * @access private
*/
  var $keyValues =  array (
        "Title"=>"Limporter LMO Addon",
        "Name"=>"Liga Name",
        "Type"=>0,
        "Teams"=>0,
        "vonTab"=>0,
        "bisTab"=>0,
        "Rounds"=>0,
        "Matches"=>0,
        "Actual"=>0,
        "Kegel"=>0,
        "HandS"=>0,
        "PointsForWin"=>2,
        "PointsForDraw"=>1,
        "PointsForLost"=>0,
        "Spez"=>0,
        "HideDraw"=>0,
        "OnRun"=>0,
        "MinusPoints"=>2,
        "Direct"=>0,
        "Champ"=>1,
        "CL"=>0,
        "CK"=>0,
        "UC"=>0,
        "AR"=>0,
        "AB"=>2,
        "namePkt"=>"Pkt.",
        "nameTor"=>"Tore",
        "DatC"=>1,
        "DatS"=>1,
        "DatM"=>1,
        "DatF"=>"%a.%d.%m. %H:%M",
        "urlT"=>1,
        "urlB"=>0,
        "Graph"=>1,
        "Kreuz"=>1,
        "favTeam"=>0,
        "selTeam"=>0,
        "kurve1"=>0,
        "kurve2"=>0,
        "ticker"=>0,
        "stats"=>0,		// Neu ab 2.5
        );


  function optionsSektion($aLiga="",$optionDetails="") {
    $this->name = "Options";
    if ($optionDetails <> "") {
            foreach ($optionDetails as $key=>$values) {
                $this->keyValues[$key] = $values;
            }
    }
    // Wenn eine Liga angegeben wird, werden entsprechende Keys gleich initialisiert
    if(get_class($aLiga)=="liga") {
      if(isset($aLiga->name) and $aLiga->name != "") $this->keyValues['Name'] = $aLiga->name;
      if(isset($aLiga->aktSpTag) and $aLiga->aktSpTag != "") $this->keyValues['Actual'] = $aLiga->aktSpTag;
      $this->keyValues['Teams'] = $aLiga->teamCount();
      $this->keyValues['Rounds'] = $aLiga->spieltageCount();
      // Key "Matches" bestimmen
      foreach ($aLiga->spieltage as $spieltag) {
        if ($spieltag->partienCount() > $this->keyValues['Matches'])
          $this->keyValues['Matches'] = $spieltag->partienCount();
      }
    }
  }

} // End CLASS Options


/**
 * Liga
 *
 * Bildet das gesammte LigaFile als Objekt ab
 *
 * @package   classLib
*/

class liga {
/**
 * Nummer der Liga,
 * @var integer
 * @access private
*/
  var $nr;
/**
 * @var integer
 * @access private
*/
  var $count;
/**
 * Mannschaften der Liga,
 * @var array of Team Objects
 * @access public
*/
  var $teams;
/**
 * Name der Liga,
 * @var string
 * @access public
*/
  var $name;
/**
 * Kurzbezeichnung der Liga,
 * @var string
 * @access public
*/
  var $kurz;
/**
 * @access private
*/
  var $aktSpTag;
/**
 * Partien der Liga,
 * @var array of Partien Objects
 * @access public
*/
  var $partien;
/**
 * Spieltage der Liga,
 * @var array of Spieltag Objects
 * @access public
*/
  var $spieltage;
/**
 * Vollständiger Pfad und Dateiname der Liga
 * @var string
 * @access public
*/
  var $fileName;

/**
 * Timestamp des FileDatum
 * @var datetime
 * @access public
*/
  var $ligaDatum;
/**
 * Inhalt des LigaFiles fileContent[Sektion][key] = value
 * @var array
 * @access privat
*/
  var $sections;

   function liga($name="",$kurz="") {
    $this->name = $name;
    $this->kurz = $kurz;
    $this->spieltage = array();
    $this->partien = array();
    $this->teams = array();
    $this->fileName = '';
    $this->ligaDatum = '';
    $this->sections = array();  // neu ab 2.5  Speichert den Inhalt unbekannter Sektionen im Array,
    														// damit keine Daten verloren gehen.
  }

/**
 * Gibt die Anzahl der teilnehmenden Mannschaften zurück
 *
*/
  function teamCount() {
    return count($this->teams);
  }

/**
 * Fügt ein Teamobjekt zur Liga hinzu
 * @access private
*/
  function addTeam(&$neuesTeam) {
    $this->teams[] = $neuesTeam; // Das muss so sein
  }

/**
 * Gibt die Referenz auf das Teamobjekt zu einem Teamnamen zurück
 *
*/
  function &teamForName($teamName) {
    $count = $this->teamCount();
    $i = 0;
    $found=-1;
    $selectedTeam = null;
    while (($i<$count) and ($found != 0)):
      $found = strcmp($this->teams[$i]->name,$teamName);
 //     $found = $this->teams[$i]->name == $teamName?0:-1;
      $i++;
    endwhile;
    if ($found==0) return $this->teams[$i-1];
    return null;
  }

/**
 * Gibt die Referenz auf das Teamobjekt zu einer Teamnummer zurück
 *
*/
  function &teamForNumber($teamNumber) {
    $result = null;
    if(isset($teamNumber) and $teamNumber > 0 and $teamNumber <= $this->teamCount())
      $result = $this->teams[$teamNumber-1];
    return $result;
  }

/**
 * Gibt ein Array mit Strings zurück, in dem sämtliche Mannschaftsnamen enthalten sind
 *
*/
  function teamNames() {
    $teamArray = array();
    foreach((array)$this->teams as $team) {
      $teamArray[] = (string)$team->name;
    }
    return $teamArray;
  }

/**
 * Gibt die Anzahl der Partien der gesamten Liga
 *
*/
  function partienCount() {
    return count($this->partien);
  }

/**
 * Fügt eine Partie zur Liga hinzu
 *
 * @access private
*/
  function addPartie(&$neuePartie) {
    $this->partien[] = $neuePartie;
  }
/**
 * Gibt die Referenz auf das Partieobjekt zu einer Nummer zurück
 *
*/
  function &partieForNumber($number) {
    $result = null;
// Bugfix 13.10.04    if(isset($number) and $nNumber > 0 and $number <= $this->partienCount())
    if(isset($number) and $number > 0 and $number <= $this->partienCount())
      $result = $this->partien[$number-1];
    return $result;
  }

/**
 * Gibt die Referenz auf das Partieobjekt zurück, an der die Mannschaften
 * aufeinandertreffen
*/
    function &partieForTeams(&$heim,&$gast) {
        $result = Null;
        foreach ($this->partien as $aPartie) {
            if (($aPartie->heim == $heim ) and ($aPartie->gast == $gast)) {
          $result = $aPartie;
          break;
            }
        }
        return $result;
  }

/**
 * Gibt die Referenz auf das Partieobjekt zurück, an der die Mannschaften
 * mit den anzugebenen Namen aufeinandertreffen
*/
    function &partieForTeamNames($heimName,$gastName) {
    		$heimName = strtolower($heimName);
    		$gastName = strtolower($gastName);
        $result = Null;
        foreach ($this->partien as $aPartie) {
            if ((strtolower($aPartie->heim->name) == $heimName )
            and (strtolower($aPartie->gast->name) == $gastName)) {
              $result = $aPartie;
              break;
            }
        }
        return $result;
  }

/**
 * Fügt einen Spieltag zur Liga hinzu
 *
 * @access private
 *
*/
  function addSpieltag(&$neuerSpieltag) {
    $this->spieltage[] = $neuerSpieltag;
  }

/**
 * Gibt die Anzahl der Spieltage der Liga zurück
 *
 * @access public
 * @return interger Anzahl der Spieltage
 *
*/
  function spieltageCount() {
    return count($this->spieltage);
  }

/**
 * Gibt die Referenz des Spieltags mit der angegebenen Nummer zurück
 *
 * @access public
 * @return object Spieltag der Nummer
*/
  function &SpieltagForNumber($spTagNr) {
    $count = $this->spielTageCount();
    if ($spTagNr > $count) {$spTagNr=$count;}
    $i = -1;
    $found=-1;
    $selectedTag = null;
    while (($i<$count) and ($found<>0)):
      $i++;
      if (isset($this->spieltage[$i]))
        $found = strcmp($this->spieltage[$i]->nr,$spTagNr);

    endwhile;
    if ($found==0) return $this->spieltage[$i];
    else return null;
  }

/**
 * Gibt die Referenz des aktuellen Spieltags zurück
 *
 * @access public
 * @return object Spieltag der Nummer
*/
  function &aktuellerSpieltag() {
    $result = null;
    if (array_key_exists('Actual',$this->options->keyValues)) {
      $aktSpTagNr =  $this->options->keyValues['Actual'];
      if (isset($aktSpTagNr) and ($aktSpTagNr >= 0) and isset($this->spieltage[$aktSpTagNr]) ) {
        $result = $this->spieltage[$aktSpTagNr];
      }
    }
    return $result;
  }

/**
 * Gibt Partienen HTML Formatiert aus
 *
 * @access public
 * @return string
*/
  function showPartienHTML() {
    echo "<BR>Liga = $this->name";
    foreach ($this->partien as $partie) {
      $partie->showDetailsHTML();
    }
  }

/**
 * DEBUGGING: Gibt Details des Spieltages aus
 *
 * @access public
 * @return string
*/

  function showDetails() {
    echo "LigaName = $this->name\n";
    foreach ($this->spieltage as $spTag) {
      $spTag->showDetails();
    }
  }

/**
 * Gibt Details des Spieltages HTML Formatiert aus
 *
 * @access public
 * @return string
*/

  function showDetailsHTML() {
    echo "<BR>Liga = $this->name";
    foreach ($this->spieltage as $spTag) {
      $spTag->showDetailsHTML();
    }
  }

/**
 * Gibt das FileDatum als String zurück. Wird keine Formatierung angegeben,
 * wird die Standardformatierung aus den Ligaoptionen verwendet
 * @access public
 * @return String
*/
  function ligaDatumAsString ($dateFormat=null) {
    $dateFormat = isset($dateFormat)?$dateFormat:$this->options->keyValues['DatF'];
    $dateString = strftime ( $dateFormat , $this->ligaDatum);
  return $dateString;
  }

/**
 * Lädt das angegebene LigaFile und erstellt den Objektbaum
 *
 * @access public
 * @return Boolean
*/
  function loadFile($fileName='') {
    $sekt='';
    $status = False;
    $iniData = array();
    if(file_exists($fileName) and $fileName <> '') {
          $stand = date("d.m.Y H:i",filemtime($fileName));
          $datei = fopen($fileName,"rb");

      while (!feof($datei)) {
        $zeile = fgets($datei,1000);
        $zeile = chop($zeile);
        $zeile = trim($zeile);
        if((substr($zeile,0,1)=="[") && (substr($zeile,-1)=="]")){
          $sekt=trim(substr($zeile,1,-1));
          }
        elseif((strpos($zeile,"=")!=false) && (substr($zeile,0,1)!=";")){
          $schl = trim(substr($zeile,0,strpos($zeile,"=")));
          $wert = trim(substr($zeile,strpos($zeile,"=")+1));
          $iniData[$sekt][$schl] = $wert;
        }
      }
      fclose($datei);

      // Infos aus dem lim File holen (BEGIN)
      $path_parts = pathinfo($fileName);
			$basename = isset($path_parts['basename'])?$path_parts['basename']:'';
			$dirname = isset($path_parts['dirname'])?$path_parts['dirname']:'';
      $name = substr($basename,0,strlen($basename)-4);
      $limFile = PATH_TO_ADDONDIR.'/limporter/imports/'.$name.'.lim';
      if (file_exists($limFile)) {
          $datei = fopen($limFile,"rb");
          while (!feof($datei)) {
            $zeile = fgets($datei,1000);
            $zeile = chop($zeile);
            $zeile = trim($zeile);
            if((substr($zeile,0,1)=="[") && (substr($zeile,-1)=="]")){
              $sekt = trim(substr($zeile,1,-1));
              }
            elseif((strpos($zeile,"=")!=false) && (substr($zeile,0,1)!=";")){
              $schl = trim(substr($zeile,0,strpos($zeile,"=")));
              $wert = trim(substr($zeile,strpos($zeile,"=")+1));
              $iniData[$sekt][$schl] = $wert;
            }
          }
          fclose($datei);
      }
      // Infos aus dem lim File holen (ENDE)

      $tCounter = 1;
      foreach($iniData["Teams"] as $key=>$value) {
        if(isset($iniData["Team".$tCounter]) and $iniData["Team".$tCounter]!="" ) {
          $teamName = $value;
          $teamKurz = $iniData["Teamk"][$key];
          $team = new team($teamName,$teamKurz,$key);
					$team->mittel = isset($iniData['Teamm'][$key])?$iniData['Teamm'][$key]:'';
          $teamDetails = $iniData["Team".$tCounter];
          foreach ($teamDetails as $detailsKey=>$detailsValue) {
            if(isset($detailsKey) and $detailsKey!="") {
              $team->keyValues[$detailsKey]=$detailsValue;
            }
          }
          $this->addTeam($team);
      		unset($iniData["Team".$tCounter]); // weg damit weil bekannt
          $tCounter++;
        }
      }
      unset($iniData["Teams"]); // weg damit weil bekannt
      unset($iniData["Teamk"]); // weg damit weil bekannt
			unset($iniData["Teamm"]); // weg damit weil bekannt
      if ( isset($_GET['clibd']) and $_GET['clibd']==1 ) {
        echo "<pre>classlib ".CLASSLIB_VERSION_NR.
        " loadFile($fileName) call from File ".$_SERVER['PHP_SELF']."<pre>";
      }
      // Partien einlesen
      $rCounter = 1;
      while (isset($iniData["Round".$rCounter]) and $iniData["Round".$rCounter]!="" ) {
        $pCounter = 1;
        $roundSektion = "Round".$rCounter;
        $startDateString = getIniData("D1",$iniData[$roundSektion]);//$iniData[$roundSektion]["D1"];
        $endDateString = getIniData("D2",$iniData[$roundSektion]);//$iniData[$roundSektion]["D2"];
        // Neu ab Version 2.2
        $pokalModus = getIniData("MO",$iniData[$roundSektion]);
//        echo "<BR>$roundSektion startDateString=$startDateString pokalModus=".$pokalModus;
        $startDate = preg_split("/\./",$startDateString);
        $endDate = preg_split("/\./",$endDateString);
        if (count($startDate) <> 3 or checkDate($startDate[1],$startDate[0],$startDate[2])==FALSE)
          $startTime=null;
        else
          $startTime=mktime(0,0,0,(int)$startDate[1],(int)$startDate[0],(int)$startDate[2]);

        if (count($endDate) <> 3 or checkDate($endDate[1],$endDate[0],$endDate[2])==FALSE)
          $endTime=null;
        else
          $endTime= mktime(0,0,0,(int)$endDate[1],(int)$endDate[0],(int)$endDate[2]);

        $spieltag = new spieltag($rCounter,$startTime,$endTime);

        while (isset($iniData[$roundSektion]["TA".$pCounter])
        	and $iniData[$roundSektion]["TA".$pCounter]!="" ) {
          $heim =  getIniData("TA".$pCounter,$iniData[$roundSektion]);
          $gast =  getIniData("TB".$pCounter,$iniData[$roundSektion]);
          $heimTeam = &$this->teamForNumber($heim);
          $gastTeam = &$this->teamForNumber($gast);

          $ppc = 0; // pokalpartien
          if ($pokalModus<>0)
             $ppc = 1;

          do {
            $ppcStr = ($ppc <> 0)?$ppc:'';
            $theim =  getIniData("GA".$pCounter.$ppcStr,$iniData[$roundSektion]);
            $tgast =  getIniData("GB".$pCounter.$ppcStr,$iniData[$roundSektion]);
            $notiz =  getIniData("NT".$pCounter.$ppcStr,$iniData[$roundSektion]);
            $zeit =   getIniData("AT".$pCounter.$ppcStr,$iniData[$roundSektion]);
            $reportUrl = getIniData("BE".$pCounter.$ppcStr,$iniData[$roundSektion]);
            // Neu ab 2.2 Spielende
            $spEnde = getIniData("SP".$pCounter.$ppcStr,$iniData[$roundSektion],0);

            if (isset($heimTeam) and isset($gastTeam)) {
              $partie = new partie($pCounter,$zeit,$notiz,$heimTeam,$gastTeam,$theim,$tgast,"","");
              $partie->reportUrl = $reportUrl;
              $partie->spielEnde = $spEnde;
              $this->addPartie($partie);  // Partien werden zusätzlich zu der Liga hinzugefügt
              $spieltag->addPartie($partie);
            }
            $pCounter++;
            $ppc++;
          } while ($ppc < $pokalModus);

        }
    		$this->addSpieltag($spieltag);
    		unset($iniData[$roundSektion]); // weg damit weil bekannt
        $rCounter++;
      }

      // Options einlesen erst zum schluss um teams,rounds zu setzen

      $optionDetails = $iniData["Options"];
      $options = new optionsSektion($this,$optionDetails);

      // Liganame setzen
      if(isset( $optionDetails["Name"]) and $optionDetails["Name"]!="") {
        if ($this->name == "")
          $this->name = $optionDetails["Name"];
        else
          $optionDetails["Name"]=$this->name;
       }
      foreach ($optionDetails as $detailsKey=>$detailsValue) {
        if(isset($detailsKey) and $detailsKey!="") {
          $options->keyValues[$detailsKey]=$detailsValue;
        }
      }
      $this->options=&$options;
      unset($iniData["Options"]); // weg damit weil bekannt
			$this->sections = $iniData; // unbekannte Sectionen speichern
			$this->fileName = $fileName;
			$this->ligaDatum = filemtime($fileName);
      $status= True;
    }
  return $status;
  }

/**
 * schreibt das LigaFile
 *
 * @access public
 * @return Boolean
*/
  function writeFile($fileName="",$message=0,$deleteEmptyRounds=0) {
/*
		if there is a need for any update functionality for special addons,
		you should define them inside of the function updateAddons() located
		in update_addons.php file.
*/
		include 'update_addons.php';
		$iniData = array(); // Inhalt des LigaFiles
    $aktSpTag = 1;
    $maxSp = 0;
    if ($this->options->keyValues['Type']==1){
      echo "<font color=\"#ff0000\"><b>classlib Addon</b> Pokalturniere können noch nicht gespeichert werden</font>";
      exit;
    }
    $datei = fopen($fileName,"w");
    if (!$datei) {
      echo "<font color=\"#ff0000\">Kann File zum Schreiben nicht öffnen (Schreibrechte?) CLASS liga function writeFile()</font>";
      exit;
    }else if ($datei and $message==1){
      echo "<font color=\"#008800\">Writing File $fileName (".$datei.")</font>";
    }
    flock($datei,2);

    // Key "Matches" bestimmen
    foreach ($this->spieltage as $spieltag) {
      if ($spieltag->partienCount() > $maxSp) {
        $maxSp = $spieltag->partienCount();
    }
      // aktuellen Spieltag bestimmen
      foreach ($spieltag->partien as $partie) {
        if($partie->hTore + $partie->gTore > -1) { // aktueller Spieltag muss min. ein Ergebnis enthalten
            $aktSpTag = $spieltag->nr;
        }

      }
    }
  // aktualisierte Optionen setzen <acronym title="Liga Manager Online">LMO</acronym>
    $this->options->keyValues['Title'] =
       "<acronym title='Liga Manager Online'>LMO</acronym> classlib ".CLASSLIB_VERSION;
    $this->options->keyValues['Matches'] = $maxSp;
    $this->options->keyValues['Actual'] = isset($aktSpTag)?$aktSpTag:1;

    foreach($this->options->keyValues as $key=>$value) {
			$iniData['Options'][$key] = $value;
    }

    foreach($this->teams as $team) {
			$iniData['Teams'][$team->nr] = $team->name;
			$iniData['Teamk'][$team->nr] = $team->kurz;
			// Sektion Mittellange Teamnamen nur anlegen wenn vorhanden
			if (isset($team->mittel) )
				$iniData['Teamm'][$team->nr] = $team->mittel;

      foreach ($team->keyValues as $key=>$value) {
				$iniData['Team'.$team->nr][$key] = $value;
      }
    }

		// Jetzt die unbekannten Sectionen einfügen
		foreach ($this->sections as $section=>$keys) {
      foreach ($keys as $key=>$val) {
				$iniData[$section][$key] = $val;
      }
		}

		// Jetzt die Spieltage schreiben
    $roundCount = 0;
    foreach($this->spieltage as $spieltag) {
      if ($spieltag->partienCount() > 0 or $deleteEmptyRounds==1) {
        $roundCount++;
        $iniData['Round'.$roundCount]['D1']=$spieltag->vonString();
        $iniData['Round'.$roundCount]['D2']=$spieltag->bisString();
        $x=1;
        foreach ($spieltag->partien as $partie) {
        	$iniData['Round'.$roundCount]['TA'.$x]=$partie->heim->nr;
        	$iniData['Round'.$roundCount]['TB'.$x]=$partie->gast->nr;
        	$iniData['Round'.$roundCount]['GA'.$x]=$partie->hTore;
        	$iniData['Round'.$roundCount]['GB'.$x]=$partie->gTore;
        	$iniData['Round'.$roundCount]['AT'.$x]=$partie->zeit;
        	$iniData['Round'.$roundCount]['NT'.$x]=$partie->notiz;
        	$iniData['Round'.$roundCount]['BE'.$x]=$partie->reportUrl;
          $x++;
        }
      }
    }

// fileContent schreiben
   	foreach($iniData as $sek=>$keys) {
       fputs($datei,"[$sek]\n");
       foreach($keys as $key=>$val) {
        fputs($datei,"$key=$val\n");
        }
       fputs($datei,"\n");
		}
    flock($datei,3);
    fclose($datei);
		// start the update function
		updateAddons($fileName);
  }
/**
 * Zeigt den Inhalt des Ligafiles an
 *
 * Wird nur zum debuggen verwendet.
 *
 * @access private
 *
*/
  function fileContent($htmlContent=FALSE) {
    $lf = ($htmlContent==FALSE)?'\n':'<BR>';
    // Key "Matches" bestimmen
    foreach ($this->spieltage as $spieltag) {
      if ($spieltag->partienCount() > $this->options->keyValues['Matches'])
        $this->options->keyValues['Matches'] = $spieltag->partienCount();
    }
    echo $lf."[Options]";
    foreach($this->options->keyValues as $key=>$value) {
      echo $lf."$key=$value";
    }
    echo $lf."[Teams]";
    foreach($this->teams as $team) {
      echo $lf.$team->nr."=".$team->name;
    }
    echo $lf."[Teamk]";
    foreach($this->teams as $team) {
      echo $lf.$team->nr."=".$team->kurz;
    }
    foreach($this->teams as $team) {
      echo $lf."[Team".$team->nr."]";
      foreach ($team->keyValues as $key=>$value) {
        echo $lf."$key=$value";
      }
    }
		// unbekannte Sektionen ausgeben
    foreach($this->sections as $section) {
      echo $lf."[$section]";
      foreach ($section as $key=>$value) {
        echo $lf."$key=$value";
      }
    }

    $roundCount = 1;
    foreach($this->spieltage as $spieltag) {
      echo $lf."[Round".$roundCount."]";
      echo $lf."D1=".$spieltag->vonString();
      echo $lf."D2=".$spieltag->bisString();
      $x=1;
      foreach ($spieltag->partien as $partie) {
        echo $lf."TA".$x."=".$partie->heim->nr;
        echo $lf."TB".$x."=".$partie->gast->nr;
        echo $lf."GA".$x."=".$partie->hTore;
        echo $lf."GB".$x."=".$partie->gTore;
        echo $lf."AT".$x."=".$partie->zeit;
        echo $lf."NT".$x."=".$partie->notiz;
        $x++;
      }
      $roundCount++;
    }
  }
/**
 * Berechnet den Tabellenstand für einen Spieltag
 *
 * Berechnet den Tabellenstand für einen Spieltag und gibt
 * ein mehrdimensionales Array zurück:
 *    <BR>mit n = anzahlTeams - 1;
 *    <BR>$myArray[0..n]["pos"]        Tabellenposition
 *    <BR>$myArray[0..n]["team"]       Referenz auf Team
 *    <BR>$myArray[0..n]["spiele"]     gespielte Partien
 *    <BR>$myArray[0..n]["s"]          Anzahl Spiege
 *    <BR>$myArray[0..n]["u"]          Anzahl Unendschieden
 *    <BR>$myArray[0..n]["n"]          Anzahl Niederlagen
 *    <BR>$myArray[0..n]["pTor"]       Erzielte Tore
 *    <BR>$myArray[0..n]["mTor"]       Erzielte Gegentore
 *    <BR>$myArray[0..n]["dTor"]       Tordifferenz
 *    <BR>$myArray[0..n]["pPkt"]       Pluspunkte
 *    <BR>$myArray[0..n]["mPkt"]       Minuspunkte
 */
function calcTable($spTag=1) {

  $actual = $this->options->keyValues['Actual'];
  $pointsForWin = $this->options->keyValues['PointsForWin'];
  $pointsForDraw = $this->options->keyValues['PointsForDraw'];
  $pointsForLost = $this->options->keyValues['PointsForLost'];
  $minusPkte = $pointsForLost<>0 ? TRUE:FALSE;
//  $minusPkte = $this->options->keyValues['MinusPoints']==1 ? TRUE:FALSE;

  // Wiegen die erzielten Tore mehr als die Tordiff.? (nur bei Ligen)
  $kegel = isset($this->options->keyValues['Kegel'])?$this->options->keyValues['Kegel']:0;
  $spTag = ($spTag<1)?$actual:$spTag;
  $spTagCount = 1;

  foreach ($this->teams as $team) {
    $sp = 0;
    $sm = 0;
    $tor1 = 0;
    $tor2 = 0;
    $tableArray[] = array (
      "pos"=>-1,
      "team"=>$team,
      "spiele"=> 0,
      "s"=> 0,
      "u"=> 0,
      "n"=> 0,
      "pTor"=> 0,
      "mTor"=> 0,
      "dTor"=> 0,
      "pPkt"=> 0,
      "mPkt"=> 0,
      "ser1"=> 0, // neu in 2.5
      "ser2"=> 0, // neu in 2.5
      "ser3"=> 0  // neu in 2.5
      );
  }
  foreach ($this->spieltage as $spieltag) {
    foreach ($spieltag->partien as $partie) {
      $heimCount = -1;
      $gastCount = -1;
      $count=0;
      foreach ($tableArray as $table) { // Teams der Partie finden
        if ($table["team"]===$partie->heim) $heimCount=$count;
        if ($table["team"]===$partie->gast) $gastCount=$count;
        if ($heimCount>-1 and $gastCount>-1) break;
        $count++;
      }
      // Strafen berücksichtigen
      strafen($tableArray[$heimCount],$spTagCount,$minusPkte);
      strafen($tableArray[$gastCount],$spTagCount,$minusPkte);

      if ($partie->hTore>-1) {
        // Tore für Heim hinzufügen
        $tableArray[$heimCount]["pTor"] += $partie->hTore;
        $tableArray[$gastCount]["mTor"] += $partie->hTore;
      }
      if ($partie->gTore>-1) {
        // Tore für Gast hinzufügen
        $tableArray[$gastCount]["pTor"] += $partie->gTore;
        $tableArray[$heimCount]["mTor"] += $partie->gTore;
      }
      if ($partie->hTore>-1 and $partie->gTore>-1) { // Ein normales Ergebnis?
         // Tordifferenz
//        $tableArray[$heimCount]["dTor"] += $partie->hTore-$partie->gTore;
//        $tableArray[$gastCount]["dTor"] += $partie->gTore-$partie->hTore;

          if ($partie->gTore == $partie->hTore) { // Unendschieden
              $tableArray[$heimCount]["pPkt"] += $pointsForDraw;
              $tableArray[$heimCount]["mPkt"] += $pointsForDraw;
              $tableArray[$gastCount]["pPkt"] += $pointsForDraw;
              $tableArray[$gastCount]["mPkt"] += $pointsForDraw;
              $tableArray[$heimCount]["u"] ++;
              $tableArray[$gastCount]["u"] ++;
              $tableArray[$heimCount]["spiele"] ++;
              $tableArray[$gastCount]["spiele"] ++;
              // Unendschieden neu in 2.5
              $tableArray[$heimCount]["ser1"] ++;
              $tableArray[$gastCount]["ser2"] ++;
              $tableArray[$heimCount]["ser2"] ++;
              $tableArray[$gastCount]["ser1"] ++;
              $tableArray[$heimCount]["ser3"] ++;
              $tableArray[$gastCount]["ser3"] ++;
          }
          elseif ($partie->gTore > $partie->hTore) { // Gast hat gewonnen
              $tableArray[$heimCount]["mPkt"] += $pointsForWin;
              $tableArray[$gastCount]["pPkt"] += $pointsForWin;
              $tableArray[$heimCount]["n"] ++;
              $tableArray[$gastCount]["s"] ++;
              $tableArray[$heimCount]["spiele"] ++;
              $tableArray[$gastCount]["spiele"] ++;
              // Gast hat gewonnen  neu in 2.5
              $tableArray[$heimCount]["ser1"] =0;
              $tableArray[$gastCount]["ser1"] ++;
              $tableArray[$gastCount]["ser2"] =0;
              $tableArray[$heimCount]["ser2"] ++;
              $tableArray[$heimCount]["ser3"] =0;
              $tableArray[$gastCount]["ser3"] =0;
          }
          elseif ($partie->gTore < $partie->hTore) { // Heim hat gewonnen
              $tableArray[$heimCount]["pPkt"] += $pointsForWin;
              $tableArray[$gastCount]["mPkt"] += $pointsForWin;
              $tableArray[$heimCount]["s"] ++;
              $tableArray[$gastCount]["n"] ++;
              $tableArray[$heimCount]["spiele"] ++;
              $tableArray[$gastCount]["spiele"] ++;
              // Heim hat gewonnen neu in 2.5
              $tableArray[$heimCount]["ser1"] ++;
              $tableArray[$gastCount]["ser1"] =0;
              $tableArray[$gastCount]["ser2"] ++;
              $tableArray[$heimCount]["ser2"] =0;
              $tableArray[$heimCount]["ser3"] =0;
              $tableArray[$gastCount]["ser3"] =0;
          }
          else { // nur während der Entwicklung
              echo "Fehler in Punkteermittlung (Normales Ergebnis)";
            echo $partie->showDetailsHTML();
            }
      }
      else if ($partie->hTore==-2) { // O:0 Tore Heim gewinnt
                $tableArray[$heimCount]["pPkt"] += $pointsForWin;
                $tableArray[$gastCount]["mPkt"] += $pointsForWin;
                $tableArray[$heimCount]["s"] ++;
                $tableArray[$gastCount]["n"] ++;
                $tableArray[$heimCount]["spiele"] ++;
                $tableArray[$gastCount]["spiele"] ++;
                // Heim hat gewonnen neu in 2.5
                $tableArray[$heimCount]["ser1"] ++;
                $tableArray[$gastCount]["ser1"] =0;
                $tableArray[$gastCount]["ser2"] ++;
                $tableArray[$heimCount]["ser2"] =0;
                $tableArray[$heimCount]["ser3"] =0;
                $tableArray[$gastCount]["ser3"] =0;
      }
      else if ($partie->gTore==-2) { // O:0 Tore Gast gewinnt
                $tableArray[$heimCount]["mPkt"] += $pointsForWin;
                $tableArray[$gastCount]["pPkt"] += $pointsForWin;
                $tableArray[$heimCount]["n"] ++;
                $tableArray[$gastCount]["s"] ++;
                $tableArray[$heimCount]["spiele"] ++;
                $tableArray[$gastCount]["spiele"] ++;
                // Gast hat gewonnen  neu in 2.5
                $tableArray[$heimCount]["ser1"] =0;
                $tableArray[$gastCount]["ser1"] ++;
                $tableArray[$gastCount]["ser2"] =0;
                $tableArray[$heimCount]["ser2"] ++;
                $tableArray[$heimCount]["ser3"] =0;
                $tableArray[$gastCount]["ser3"] =0;
      }
    } // foreach Partien
    if($spTagCount<$spTag) $spTagCount++; else break;
  } // foreach Spieltage

  $i=0;
  while ($i<count($tableArray)) { // Tordiff.
    $tableArray[$i]["dTor"]=$tableArray[$i]["pTor"]-$tableArray[$i]["mTor"];
    $i++;
  }

    // ASC = auf-, DESC = absteigend
  if ($kegel==1) { // Sortierung PlusPkt,erzielte Tore
        foreach($tableArray as $table) {
            $sort_1[] = $table["pPkt"];
            $sort_2[] = $table["pTor"];
        }
        array_multisort($sort_1, SORT_DESC,
                        $sort_2, SORT_DESC,$tableArray);
  }
  else { // Sortierung PlusPkt,Tordiff
        foreach($tableArray as $table) {
            $sort_1[] = $table["pPkt"];
            $sort_2[] = $table["dTor"];
            $sort_3[] = $table["pTor"];
            $sort_4[] = $table["mTor"];
        }
        array_multisort($sort_1, SORT_DESC, $sort_2, SORT_DESC,
                                 $sort_3, SORT_DESC,$sort_4, SORT_ASC,$tableArray);
  }

//  $tableArray=array_values($tableArray);// Index neu erstellen
  $i=0;
  while ($i<count($tableArray)) {// Position setzen
    $tableArray[$i]["pos"]=$i+1;
    $i++;
  }
  // Hier fehlt noch die Prüfung  wie bei Pkt und Torgleichen Teams
  // verfahren werden soll (Direkter Vergleich etc)
  return $tableArray;
}

} // End Class Liga

?>