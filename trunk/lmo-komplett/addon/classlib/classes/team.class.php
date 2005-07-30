<?
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

  function team($name="",$kurz="",$nr="",$mittel="") {
    $this->name = $name;
    $this->kurz = $kurz;
    $this->mittel = $mittel; 
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
?>