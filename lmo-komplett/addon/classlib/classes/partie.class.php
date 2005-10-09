<?
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
    else { // Unentschieden
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
  * Gibt das SpielDatum als formatierten String zurück. "d.m.Y" = Standard
  *
  * @access public
  * @param string leer Ausgabe, falls kein Datum vorhanden
  * @param string format Datumsformat in date()-Notation Standard = d.m.Y
  * @return string
  */
  function datumString($leer='',$format="d.m.Y") {
    $str = ($this->zeit<1)?$leer:date($format,$this->zeit);
    return $str;
  }

  /**
  * Gibt die Anfangszeit als formatierten String zurück "Stunden:Minuten" = Standard
  *
  * @access public
  * @param string leer Ausgabe, falls keine Zeit vorhanden
  * @param string format Zeitformat in date()-Notation Standard = H:i
  * @return string
  */

  function zeitString($leer='',$format="H:i") {
    $str = ($this->zeit<1)?$leer:date($format,$this->zeit);
    return $str;
  }

  /**
  * Gibt für eine Partie aus, ob Verlängerung oder 11/7-Meterschießen
  *
  * @access public
  * @param array text Referenz auf Sprachvariablen
  * @param string leer Ausgabe, falls keine n.V./i.E vorhanden
  * @return string
  */

  function spielEndeString(&$text,$leer = "") {
    if ($this->spielEnde == 0) {
      $str = $leer;
    } elseif ($this->spielEnde == 1) {
      $str = $text[1];
    } elseif ($this->spielEnde == 2) {
      $str = $text[0];
    } else {
      $str = $this->spielEnde;
    }
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
?>