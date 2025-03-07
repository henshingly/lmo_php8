<?php
/**
 * Spieltag
 *
 * Repräsentiert einen Spieltag
 * <BR>Eine Liga hat mehrere Spieltage.
 * <BR>An einem Spieltag finden mehrere Partien statt.
 *
 * @package   classLib
 * @access public
 * @version $Id: spieltag.class.php 514 2009-11-01 17:52:09Z jokerlmo $
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
    * modus als integer,
    * 0 => Liga , jeder gegen jeden
    * 1 => pokal , KO Tunier
    *
    * @var integer
    * @access privat
    */
    var $modus= 0;

    /**
    * Partien des Spieltages,
    * @var array of partien objects
    * @access public
    */
    var $partien;

    /**
    * Konstruktor
    *
    * @param integer $new_nr
    * @param string $new_von
    * @param string $new_bis
    * @param array $partien
    * @return spieltag
    */
    function __construct($new_nr, $new_von, $new_bis, $partien = array()) {
        $this->nr = $new_nr;
        $this->von = $new_von;
        $this->bis = $new_bis;
        $this->partien = $partien;
    }

    /**
    * Gibt Partien eines Spieltag zurück, Optional: Sortierung
    *
    * datum
    *
    * Mögliche weitere Sortierungen:
    * heimname (nicht implementiert)
    * gastname (nicht implementiert)
    * heimtore (nicht implementiert)
    * gasttore (nicht implementiert)
    * summetore (nicht implementiert)
    *
    * @since 2.8
    * @access public
    * @param string Sortierung
    * @return array Partien
    */
    function getPartien($sorted = '', $sort_dir = 'ASC') {
        $result = array();
        switch ($sorted) {
            case 'datum':
                foreach ($this->partien as $partie) {
                    $result[(int)$partie->zeit + $partie->spNr] = $partie;
                }
                if ($sort_dir == 'ASC') {
                    ksort($result, SORT_NUMERIC);
                }
                else {
                    krsort($result, SORT_NUMERIC);
                }
                $result = array_values($result);
            break;
            default:
                $result = $this->partien;
            break;
        }
    return $result;
  }

    /**
    * Setzt den Modus des Spieltags
    *  0 = Liga / 1 = Pokal-KoTunier
    *
    * @since 2.7
    * @access public
    * @parameter integer Modus des Spieltags
    */
    function setModus($value) {
        $this->modus = $value;
    }

    /**
    * Gibt den Modus des Spieltags zurück
    *  0 = Liga / 1 = Pokal-KoTunier
    *
    * @since 2.7
    * @access public
    * @return integer Modus des Spieltags
    */
    function getModus() {
        return $this->modus;
    }

    /**
    * Gibt Partie der angegebener Nummer zurück
    *
    * @access public
    * @param integer Partienummer
    * @return object Die Partie
    */
    function &partieForNumber($number) {
        $result = null;
        // Bugfix 13.10.04    if (isset($number) && $nNumber > 0 && $number <= $this->partienCount())
        if (isset($number) && $number > 0 && $number <= $this->partienCount()) {
            $result = $this->partien[$number - 1];
        }
        return $result;
    }

    /**
    * Gibt Partie der angegebener Teamnummern zurück
    *
    * @access public
    * @param integer Heimmannschaftsnummer integer Gastmannschaftsnummer
    * @return object Die Partie
    */
    function &partieForTeams($heimNr, $gastNr) {
        $count = $this->partienCount();
        $i = -1;
        $found = -1;
        $selectedTag = null;
        while (($i < $count) && ($found <> 0)) {
            $i++;
            if (isset($this->partien[$i]) && ($this->partien[$i]->heim->nr = $heimNr) && ($this->partien[$i]->gast->nr = $gastNr)) {
                $found = 0;
            }
        }
        if ($found == 0) {
            return $this->partien[$i];
        }
        else {
            return null;
        }
    }

    /**
    * Gibt Partie der angegebener Teamnamen zurück
    *
    * @access public
    * @param string Heimmannschaftsname string Gastmannschaftsname
    * @return object Die Partie
    */
    function &partieForTeamNames($heimName, $gastName) {
        $result = null;
        foreach ($this->partien as $aPartie) {
            if (($aPartie->heim->name == $heimName ) && ($aPartie->gast->name == $gastName)) {
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
    * @param objekt Partie
    * @return bool Partie wurde gelöscht true / false
    */
    function removePartie(&$rmvPartie) {
        $result = false;
        reset($this->partien);
        $partienArray = $this->partien;
        $index = 0;
        foreach ($this->partien as $aPartie) {
            if ($rmvPartie == $aPartie) {
                unset($partienArray[$index]);
                $partienArray = array_values($partienArray); // Index neu erstellen
                $result = true;
                break;
            }
            else {
                next($partienArray);
                $index++;
            }
        }
        if (isset($partienArray)) {
            $this->partien = &$partienArray;
        }
        else {
            $this->partien = null;
        }
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
    * @param Object die Partie
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
        echo "\n" . $this->nr . '. Spieltag ('.$this->vonBisString() . ")\n";
        foreach ($this->partien as $partie) {
            echo $partie->showDetails() . "\n";
        }
    }

    /**
    * Debugfunktion.
    *
    * @access private
    */
    function showDetailsHTML() {
        echo '<BR>' . $this->nr . '. Spieltag (' . $this->vonBisString() . ')';
        foreach ($this->partien as $partie) {
          echo '<BR>' . $partie->showDetailsHTML();
        }
    }

    /**
    * Gibt den Zeitrahmen aus, an dem der Spieltag ausgetragen wird
    *
    * Sind das vonDatum und das bisDatum gesetzt wird zB. 10.10.2003 - 19.10.2003 zurückgegeben
    * <BR> Ist eines der beiden nicht gesetzt, wird nur das Datum zurückgeben ohne Verbinder
    * <BR> zB. ist das vonDatum nicht gesetzt wird nur das bisDatum ausgegeben 19.10.2003 ohne Bindestrich
    *
    * @access public
    * @return string
    */
    function vonBisString() {
        $von = '';
        $bis = '';
        if ($this->von != '') {
            $von = date('d.m.Y', $this->von);
        }
        if ($this->bis != '') {
            $bis = date('d.m.Y', $this->bis);
        }

        if ($von != '' && $bis != '') {
            return $von . ' - ' . $bis;
        }
        return $von . $bis;
    }

    /**
    * Gibt das vonDatum, an dem der Spieltag ausgetragen wird
    *
    * @access public
    * @return string
    */
    function vonString() {
        $von = '';
        if ($this->von != '') {
            $von = date('d.m.Y', $this->von);
        }
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
        if ($this->bis != '') {
            $bis = date('d.m.Y', $this->bis);
        }
        return $bis;
    }

} // END class spieltag
?>
