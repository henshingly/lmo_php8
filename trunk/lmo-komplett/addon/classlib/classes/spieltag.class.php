<?
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
?>