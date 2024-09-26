<?PHP
/**
 * LMO Class Library Version (01/2004)
 *
 * Die LMO Class Library (classlib) bildet ein Ligadatei (.l98) des LMO
 * in Form eines Objektbaums ab und ermöglicht so die Entwicklung von
 * objektorientierten Erweiterung in Form von sog. Addons für den Liga Manager Online.
 *
 * @author    Tim Schumacher <webobjects@gmx.net>
 *
 * @package   classLib
*/

//Team
require_once(PATH_TO_ADDONDIR."/classlib/classes/team.class.php");

//Spieltag
require_once(PATH_TO_ADDONDIR."/classlib/classes/spieltag.class.php");

//Partie
require_once(PATH_TO_ADDONDIR."/classlib/classes/partie.class.php");

//Sektion (Ligafile Inhalt)
require_once(PATH_TO_ADDONDIR."/classlib/classes/sektion.class.php");

//optionsSektion (Ligafile Optionen)
require_once(PATH_TO_ADDONDIR."/classlib/classes/optionsSektion.class.php");

//Liga
require_once(PATH_TO_ADDONDIR."/classlib/classes/liga.class.php");

require_once(PATH_TO_ADDONDIR."/classlib/classes/ligaFussball.class.php");
require_once(PATH_TO_ADDONDIR."/classlib/classes/ligaHandball.class.php");

//Statistiken
require_once(PATH_TO_ADDONDIR."/classlib/classes/stats.class.php");

?>