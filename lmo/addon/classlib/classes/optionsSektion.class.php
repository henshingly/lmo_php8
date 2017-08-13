<?php 
/**
 * OptionSektion
 *
 * Sektionen eines LigFiles in dem die Optionen angegeben sind [Options]
 *
 * @package   classLib
 * @access public
 * @version $Id: optionsSektion.class.php 538 2010-02-07 15:14:43Z jokerlmo $
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
    "Title"=>"Liga Manager Online 4",
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
    "PointsForWin"=>3,
    "PointsForDraw"=>1,
    "PointsForLost"=>0,
    "Spez"=> 0,
    "HideDraw"=>0,
    "OnRun"=>0,
    "MinusPoints"=>1,
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
    "urlB"=>1,
    "Graph"=>1,
    "Kreuz"=>1,
    "Tabelle"=>1,
    "Ligastats"=>1,
    "Plan"=>1,
    "Ergebnis"=>1,
    "mittore"=>1,
    "favTeam"=>0,
    "selTeam"=>0,
    "kurve1"=>0,
    "kurve2"=>0,
    "tableHinRueck"=>1,
    "tableHeimAusw"=>1,
    "ticker"=>0,
    "stats"=>0,		// Neu ab 2.5
  );


  /**
   * Konstruktor
   *
   * @param liga $aLiga
   * @param array $optionDetails
   * @return optionsSektion
   */
  function __construct($aLiga="",$optionDetails="") {
    $this->name = "Options";
    if (is_array($optionDetails)) {
      foreach ($optionDetails as $key=>$values) {
        $this->keyValues[$key] = $values;
      }
    }
    // Wenn eine Liga angegeben wird, werden entsprechende Keys gleich initialisiert
    if(get_class($aLiga)=="liga") {
      if(isset($aLiga->name) and $aLiga->name != "") {
        $this->keyValues['Name'] = $aLiga->name;
      }
      if(isset($aLiga->aktSpTag) and $aLiga->aktSpTag != "") {
        $this->keyValues['Actual'] = $aLiga->aktSpTag;
      }
      $this->keyValues['Teams'] = $aLiga->teamCount();
      $this->keyValues['Rounds'] = $aLiga->spieltageCount();
      // Key "Matches" bestimmen
      foreach ($aLiga->spieltage as $spieltag) {
        if ($spieltag->partienCount() > $this->keyValues['Matches']) {
          $this->keyValues['Matches'] = $spieltag->partienCount();
        }
      }
    }
  }

} // End CLASS Options

?>
