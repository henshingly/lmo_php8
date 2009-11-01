<?php
/**
 * Class PokalRunde
 * Bildet die komplette Runde eines KO Tuniers / Playoff oder Ähnlichem ab.
 *
 * @author Markus Dörfling <markus@doerfling.net>
 * @version $Id$
 * @package classlib
 */

class pokalRunde {
  /**
   * Nummer der Runde
   * @var integer
   * @access privat
   */
  var $roundNumber;

  /**
   *  Modus 0->Tabelle / 1-> KO / 2->KO mir Rückspiel / 3->best of 3 / 5->best of 5 / 7->best of 7
   * @var integer
   * @access private
   */
  var $mode= 0;

  /**
   * Begin der Runde (Datum) als Unix Timestamp,
   * @var integer
   * @access privat
   */
  var $begin= 0;

  /**
   * Ende der Runde (Datum) als Unix Timestamp,
   * @var string
   * @access privat
   */
  var $end= 0;

  /**
   * Partien dieser Runde
   * @var array of partien objects
   * @access privat
   */
  var $partien = array();

  /**
   * Spieltage dieser Runde
   * @var array of spieltag objects
   * @access privat
   */
  var $spieltage = array();

  /**
   * Konstruktor der Klasse PokalRunde, setz die wichtigsten Parameter der Runde
   *
   * @access public
   * @param integer roundNumber Nummer der Runde
   * @param integer mode Spielmodus
   * @param interger begin Begin der Runde als Unix Timestamp
   * @param interger end Ende der Runde als Unix Timestamp
   * @param array spieltage Spieltage (objecte) dieser Runde
   * @return void
   */
  function pokalRunde($roundNumber,$mode,$begin=0,$end=0,$spieltage=null) {
    $this->roundNumber = $roundNumber;
    $this->setMode($mode);
    $this->setBegin($begin);
    $this->setEnd($end);
    if (!is_null($spieltage) ) $this->addSpieltage($spieltage);
  }

  /**
   * Gibt die Nummer der Runde zurück
   *
   * @access public
   * @return integer Modus dér Runde
   */
  function getRoundNumber() {
    return $this->roundNumber;
  }

  /**
   * Setzt den Modus dieser Runde zurück
   *
   * @access public
   * @param integer value Modus der Runde
   * @return void
   */
  function setMode($value) {
    $this->mode = $value;
  }

  /**
   * Gibt den aktuellen Modus dieser Runde zurück
   *
   * @access public
   * @return integer Modus dér Runde
   */
  function getMode() {
    return $this->mode;
  }

  /**
   * Setzt das Datum an dem diese Runde beginnt als Unix Timestamp
   *
   * @access public
   * @param integer value Begin der Runde als Unix Timestamp
   * @return void
   */
  function setBegin($value) {
    $this->begin = $value;
  }

  /**
   * Gibt den Timestamp der Rundenbegins zurück, wenn format angegeben ist wird
   * das Datum im angegeben Format zurückgegeben
   *
   * @access public
   * @param string format der Datumsausgabe
   * @see strftime()
   * @return mixed Datum des Rundenbegins
   */
  function getBegin($format="") {
    if ($this->end != 0 ) {
      if ($format == "") return $this->begin;
      else return strftime($format,$this->begin);
    } else return false;
  }

  /**
   * Setzt das Datum an dem diese Runde Endet als Unixtimestamp
   *
   * @access public
   * @param integer value Ende der Runde als Unix Timestamp
   * @return void
   */
  function setEnd($value) {
    $this->end = $value;
  }

  /**
   * Gibt den Timestamp der Rundenendes zurück, wenn format angegeben ist wird
   * das Datum im angegeben Format zurückgegeben
   *
   * @access public
   * @param string format der Datumsausgabe
   * @see strftime()
   * @return mixed Ende dér Runde
   */
  function getEnd($format="") {
    if ($this->end != 0 ) {
      if ($format == "") return $this->end;
      else return strftime($format,$this->end);
    } else return false;
  }

  /**
   * Fügt Referenzen auf Partien dieser Runde hinzu
   *
   * @access public
   * @param array/object value Objecte der partien
   * @return void
   */
  function addPartien(&$value) {
    if (is_array($value) ) {
      foreach ($value as $partie) {
        if (is_a($partie,"partie") ) $this->partien[$partie->spNr] = &$partie;
      }
    } elseif (is_a($value,"partie") ) {
      $this->partien[$value->spNr] = &$value;
    }
  }

  /**
   * Gibt Partien dieser Runde zurück, ist $Number ="" wird das komplette Array übergeben
   *
   * @access public
   * @param integer Nummer der Partie
   * @return object Partie
   */
  function getPartien($number="") {
    if ($number == "" ) return $this->partien;
    elseif (!array_key_exists($number,$this->partien[$number]) ) return false;
    else return $this->partien[$number];
  }

  /**
   * Fügt Referenzen auf die Spieltage (und die Partien dieses Spieltags) dieser Runde hinzu
   *
   * @access public
   * @param array/object value Objecte der Spieltage
   * @return void
   */
  function addSpieltage(&$value) {
    if (is_array($value) ) {
      foreach ($value as $spieltag) {
        if (is_a($spieltag,"spieltag") ) {
          $this->spieltage[$spieltag->nr] = $spieltag;
          $this->addPartien($spieltag->partien);
        }
      }
    } elseif (is_a($value,"spieltag") ) {
      $this->spieltage[$value->nr] = $value;
      $this->addPartien($value->partien);
    }
  }

  /**
   * Gibt Spieltage dieser Runde zurück, ist $Number ="" wird das komplette Array übergeben
   *
   * @access public
   * @param integer Nummer des Spieltags
   * @return object Spieltag
   */
  function getSpieltage($number="") {
    if ($number == "" ) return $this->spieltage;
    elseif (!array_key_exists($number,$this->spieltage[$number]) ) return false;
    else return $this->spieltage[$number];
  }

  /**
   * Gibt die Anzahl der Spieltage dieser Pokal Runde zurück
   *
   * @access public
   * @return interger Anzahl der Spieltage
   */
  function spieltageCount() {
    return count($this->spieltage);
  }

  /**
   *
   * @access public
   * @return array Gegner der Partien
   */
  function getGegner() {
    $spieltag = reset($this->spieltage);
    $gegner = array();
    foreach ( $spieltag->partien as $partie) {
      $gegner[]["teamA"] = $partie->heim;
      $gegner[]["teamB"] = $partie->gast;
    }
    return $gegner;
  }

  /**
   *
   * @param team $teamA
   * @param team $teamB
   * @return array partien
   */
  function getPartienForTeams(&$teamA,&$teamB) {
    $result = array();
    foreach ($this->partien as $partie ) {
      if ( $partie->heim == $teamA || $partie->gast == $teamA ) {
        if ( $teamB == "" || $partie->heim == $teamB || $partie->gast == $teamB )
        $result[] = $partie;
      }
    }
    return $result;
  }


}
?>