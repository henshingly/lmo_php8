<?
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

?>