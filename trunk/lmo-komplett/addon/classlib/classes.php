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

//Team
require(PATH_TO_ADDONDIR."/classlib/classes/team.class.php");

//Spieltag
require(PATH_TO_ADDONDIR."/classlib/classes/spieltag.class.php");

//Partie
require(PATH_TO_ADDONDIR."/classlib/classes/partie.class.php");

//Sektion (Ligafile Inhalt)
require(PATH_TO_ADDONDIR."/classlib/classes/sektion.class.php");

//optionsSektion (Ligafile Optionen)
require(PATH_TO_ADDONDIR."/classlib/classes/optionsSektion.class.php");

//Liga
require(PATH_TO_ADDONDIR."/classlib/classes/liga.class.php");



?>