<?PHP
/**
 * Liga
 *
 * Bildet das gesammte LigaFile als Objekt ab
 *
 * @package   classLib
 * @version  $Id: liga.class.php 569 2010-09-15 19:53:15Z jokerlmo $
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
  var $teams = array();

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
  var $partien = array();

  /**
   * Spieltage der Liga,
   * @var array of Spieltag Objects
   * @access public
   */
  var $spieltage = array();

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
   * @access private
   */
  var $sections = array();

  /**
   * Konstruktor
   *
   * @param string $name
   * @param string $kurz
   * @return liga
   */
  function __construct($name="",$kurz="") {
    $this->name = $name;
    $this->kurz = $kurz;
  }

  /**
   * factory
   * die Funktion sucht den Parameter LigaType im Ligafile und gibt passend hierzu ein
   * Object der Klassen liga oder einer der Kindklassen zurück
   *
   * @author markus Doerfling <markus@doerfling.net>
   * @since 2.8 RC2
   * @param file string Pfad zur Ligadatei (*.l98)
   * @return object ein object passend zum Ligafile
   */
  function &factory($file) {
    if (file_exists($file) ) {
      $ligaFile = file($file);
      foreach ($ligaFile as $configLine) {
        if (preg_match("/^LigaType=([^\n]+)/",$configLine,$ligaType) ) {
          break;
        }
      }
      $ligaType[1] .= "Liga";
      if (class_exists($ligaType[1]) ) {
        return new $ligaType[1]();
      } else {
        return new liga();
      }
    } else return false;
  }

  /**
   * Gibt die Anzahl der teilnehmenden Mannschaften zurück
   *
   * @access public
   * @return integer Anzahl der Teilnehmenden Mannschaften
   */
  function teamCount() {
    return count($this->teams);
  }

  /**
   * Fügt ein Teamobjekt zur Liga hinzu
   *
   * @access private
   * @param object neuesTeam Object des neuen Teams
   */
  function addTeam(&$neuesTeam) {
    $this->teams[] = $neuesTeam; // Das muss so sein
  }

  /**
   * Gibt die Referenz auf das Teamobjekt zu einem Teamnamen zurück
   *
   * @access public
   * @param string teamName Name des gesuchten Teams
   * @return object das gesuchte Team als Object
   */
  function &teamForName($teamName) {
    $count = $this->teamCount();
    $i = 0;
    $found=-1;
    $selectedTeam = null;
    while (($i<$count) && ($found != 0)) {
      $found = strcmp($this->teams[$i]->name,$teamName);
      //     $found = $this->teams[$i]->name == $teamName?0:-1;
      $i++;
    }
    if ($found==0) {
      return $this->teams[$i-1];
    }
    return $selectedTeam;
  }

  /**
   * Gibt die Referenz auf das Teamobjekt zu einer Teamnummer zurück
   *
   * @access public
   * @param integer teamNumber Nummer des gesuchten Teams
   * @return object
   */
  function &teamForNumber($teamNumber) {
    $result = null;
    if(isset($teamNumber) && $teamNumber > 0 && $teamNumber <= $this->teamCount()) {
      $result = $this->teams[$teamNumber-1];
    }
    return $result;
  }

  /**
   * Gibt ein Array mit Strings zurück, in dem sämtliche Mannschaftsnamen enthalten sind
   *
   * @access public
   * @return array Alle Namen der Teilnehmenden Mannschaften
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
   * @access public
   * @return integer Anzahl der Partien
   */
  function partienCount() {
    return count($this->partien);
  }

  /**
   * Fügt eine Partie zur Liga hinzu
   *
   * @access private
   * @param object neuePartie Partie die hinzugefügt werden soll
   * @return void
   */
  function addPartie(&$neuePartie) {
    $this->partien[] = $neuePartie;
  }

  /**
   * Gibt die Referenz auf das Partieobjekt zu einer Nummer zurück
   *
   * @access public
   * @param integer number Nummer der gesuchten Partie
   * @return object gesuchte Partie oder null wenn partie nicht gefunden wurde
   */
  function &partieForNumber($number) {
    $result = null;
    // Bugfix 13.10.04    if(isset($number) && $nNumber > 0 && $number <= $this->partienCount())
    if(isset($number) && $number > 0 && $number <= $this->partienCount()) {
      $result = $this->partien[$number-1];
    }
    return $result;
  }

  /**
   * Gibt die Referenz auf das Partieobjekt zurück, an der die Mannschaften
   * aufeinandertreffen
   *
   * @access public
   * @deprecated
   * @see liga::allPartieForTeams
   * @param object heim TeamObject der Heimmannschaft
   * @param object gast TeamObject der Gastmannschaft
   * @return object die gesuchte Partie als Object, wenn die Partie nicht gefunden wurde null
   */
  function &partieForTeams(&$heim,&$gast) {
    $partie = $this->allPartieForTeams($heim,$gast,false);
    return $partie[0];
  }

  /**
   * Gibt ein Array von Referenzen auf die Partieobjekte zurück, an denen die Mannschaften
   * aufeinandertreffen - wenn der dritte Parameter both gesetzt ist, werden Partien
   * a vs b UND b vs a zurückgegeben

   * @access public
   * @param object Object der Heimmannschaft
   * @param object Object der Gastmannschaft
   * @param boolean Wenn true werden auch Rückspiele zurückgegeben
   * @return array Alle gesuchten Partien (Objecte)
   */
  function &allPartieForTeams(&$heim,&$gast,$both=FALSE) {
    $result = array();
    foreach ($this->partien as $aPartie) {
      if ( ($aPartie->heim == $heim && $aPartie->gast == $gast) || ($both && $aPartie->heim == $gast && $aPartie->gast == $heim)) {
        $result[] = $aPartie;
      }
    }
    if (empty($result[0]) ) {
      return null;
    } else {
      return $result;
    }
  }

  /**
   * Gibt die Referenz auf das Partieobjekt zurück, an der die Mannschaften
   * mit den anzugebenen Namen aufeinandertreffen
   *
   * @access public
   * @param string heimName Name der gesuchten Heimmannschaft
   * @param string gastName Name der gesuchten Gastmannschaft
   * @return object Object der gesuchten Partie
   */
  function &partieForTeamNames($heimName,$gastName) {
    $heimName = strtolower($heimName);
    $gastName = strtolower($gastName);
    $result = Null;
    foreach ($this->partien as $aPartie) {
      if ((strtolower($aPartie->heim->name) == $heimName ) && (strtolower($aPartie->gast->name) == $gastName)) {
        $result = $aPartie;
        break;
      }
    }
    return $result;
  }

  /**
   * Gibt ein multidim Array zurück, das die sortierten partien enthält,
   * Aufbau array[0..n](
   * 			'date' [timestamp des Spieldatums]
   * 		'spTag' [integer],
   * 			'spieltag' [Object spieltag]
   * 		'partie' [Object partie] )
   *
   * @access public
   * @param boolean roundSort gibr an ob nach Spieltag sortiert werden soll
   * @param string sortDir Sortier Richtung
   * @param object team
   * @return Array
   */
  function gamesSorted($roundSort=true,$sortDir=SORT_ASC,&$team=null) {
    $games = array();
    foreach ($this->spieltage as $spieltag) {
      foreach ($spieltag->partien as $partie) {
        if ($partie->heim == $team || $partie->gast == $team || is_null($team) ) {
          $sort_1[] = $partie->zeit;
          $sort_2[] = $spieltag->nr;
          $games[]= array('date' => $partie->zeit,
                          'spTag' => $spieltag->nr,
                          'spieltag' => $spieltag,
                          'partie' => $partie,
          );
        }
      }
    }
    if($roundSort) {
      array_multisort($sort_2,$sortDir, $sort_1,$sortDir, $games);
    } else {
      array_multisort($sort_1,$sortDir,$games);
    }
    return $games;
  }

  /**
   * Gibt ein multidim Array zurück, das die sortierten partien einer bestimmten mannschaft enthält,
   * Aufbau array[0..n](
   * 		'spieltag' [Object spieltag]
   * 		'partie' [Object partie] )
   *
   * @access public
   * @return Array
   */

  function gamesSortedForTeam ($team=null,$roundSort=true,$sortDir=SORT_ASC) {
    if(!is_a($team,"team") ) { // Wurde nix angegeben wird das fav. Team verwendet
      $team = $this->teamForNumber($this->options->keyValues['favTeam']);
    }
    return $this->gamesSorted($roundSort,$sortDir,$team);
  }

  /**
   * Fügt einen Spieltag zur Liga hinzu
   *
   * @access private
   * @param object Object des neuen Spieltags
   * @return void
   */
  function addSpieltag(&$neuerSpieltag) {
    $this->spieltage[] = $neuerSpieltag;
  }

  /**
   * Gibt die Anzahl der Spieltage der Liga zurück
   *
   * @access public
   * @return interger Anzahl der Spieltage
   */
  function spieltageCount() {
    return count($this->spieltage);
  }

  /**
   * Gibt die Referenz des Spieltags mit der angegebenen Nummer zurück
   *
   * @access public
   * @param integer spTagNr gesuchter Spieltag
   * @return object Spieltag der Nummer
   */
  function &SpieltagForNumber($spTagNr) {
    $count = $this->spielTageCount();
    if ($spTagNr > $count) {
      $spTagNr=$count;
    }
    $i = -1;
    $found=-1;
    $selectedTag = null;
    while (($i<$count) && ($found<>0)) {
      $i++;
      if (isset($this->spieltage[$i])) {
      $found = strcmp($this->spieltage[$i]->nr,$spTagNr);
    }
    }
    if ($found==0) {
      return $this->spieltage[$i];
    }
    return null;
  }

  /**
   * Gibt die Referenz des aktuellen Spieltags zurück
   *
   * @access public
   * @return object aktueller Spieltag
   */
  function &aktuellerSpieltag() {
    $result = null;
    if (array_key_exists('Actual',$this->options->keyValues)) {
      $aktSpTagNr =  $this->options->keyValues['Actual'];
      if (isset($aktSpTagNr) && ($aktSpTagNr >= 0) && isset($this->spieltage[$aktSpTagNr]) ) {
        $result = $this->spieltage[$aktSpTagNr];
      }
    }
    return $result;
  }

  /**
   * Gibt Partienen HTML Formatiert direkt aus
   *
   * @access public
   * @return void
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
   * Gibt Details des Spieltages HTML Formatiert direkt aus
   *
   * @access public
   * @return void
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
   *
   * @access public
   * @see strftime()
   * @param string dateFormat gewünschtes Ausgabeformat (siehe strftime() )
   * @return String
   */
  function ligaDatumAsString ($dateFormat=null) {
    $dateFormat = !is_null($dateFormat)?$dateFormat:$this->options->keyValues['DatF'];
    return strftime ( $dateFormat , $this->ligaDatum);
  }

  /**
   * Prüft ob die Option exestiert und gibt diese zurück
   *
   * Prüft ob die Option exestiert und wenn ja wird diese Option zurückgegeben
   * und aus dem Array gelöscht
   *
   * @access public
   * @param string key gewünschte Option
   * @param array array array mit den Optionen
   * @return string
   */
  function getIniData($key,&$array,$partie=null) {
    $result= "";
    if (is_array($array) ) {
      if (!is_null($partie) && array_key_exists($key,$array[$partie]) ) {
        $result = $array[$partie][$key];
        unset ($array[$partie][$key]); // löschen da jetzt bekannt
      } elseif (array_key_exists($key,$array)) {
        $result = $array[$key];
        unset ($array[$key]); // löschen da jetzt bekannt
      }
    }
    return $result;
  }


  /**
   * Lädt das angegebene LigaFile und erstellt den Objektbaum
   *
   * @access public
   * @param string fileName Pfad zum Ligafile (*.l98)
   * @return Boolean
   */
  function loadFile($fileName='') {
    $iniData = array();
    if(file_exists($fileName) && !empty($fileName) && !is_dir($fileName) ) {
      $this->ligaDatum = filemtime($fileName);
      // ligaFile in einen kompletten String einlesen
      $ligaFile = implode("",file($fileName) );
      // sectionen suchen und die einzelnen Sectionen in Array $sections speichern
      preg_match_all("/^\[([^\]]+)+\][^\[]+/m",$ligaFile,$sections,PREG_PATTERN_ORDER);
      for ($y=0;$y<count($sections[0]);$y++) {
        // Parameter und werte trennen
        preg_match_all("/^([^=\[]+)=(.*)/m",$sections[0][$y],$parameter,PREG_PATTERN_ORDER);
        for ($i=0, $partieNumber=0; $i<count($parameter[0]);$i++) {
          if (strpos(strtolower($sections[1][$y]),"round") === false || preg_match("/^D[12]$|^MO$/",trim($parameter[1][$i]) ) ) {
            // andere Section oder SpieltagParameter
            $iniData[$sections[1][$y]][trim($parameter[1][$i])] = trim($parameter[2][$i]);
          } else {
            // Partie Filtern
            preg_match("/([a-zA-Z]+)([\d]+)/",trim($parameter[1][$i]),$infoPerPartie);
            // $infoPerPartie -> 0 kompletter treffer / 1 Art des Parameters ( GA/GB ... ) / 2 Nummer der Partie
            if ($infoPerPartie[1] == "TA" ) {
              $partieNumber++;
              $gameNumber= 0;
            }
            if (preg_match("/^T[AB]$/",$infoPerPartie[1]) ) {
              $iniData[$sections[1][$y]][$partieNumber][$infoPerPartie[1]] = trim($parameter[2][$i]);
            } else {
              if ( $infoPerPartie[1] == "GA" ) {
                $gameNumber++;
                $iniData[$sections[1][$y]][$partieNumber][$gameNumber]["SpNr"] = $infoPerPartie[2];
              }
              $iniData[$sections[1][$y]][$partieNumber][$gameNumber][$infoPerPartie[1]] = trim($parameter[2][$i]);
            }
          }
        }
      }
      // Infos aus dem lim File holen (BEGIN)
      $limFile = PATH_TO_ADDONDIR.'/limporter/imports/'.basename($fileName,".l98").'.lim';
      if (file_exists($limFile)) {
        $limDATA = implode("",file($limFile) );
        // sectionen suchen und die einzelnen Sectionen in Array $sections speichern
        preg_match_all("/^\[([^\]]+)+\][^\[]+/m",$limDATA,$sections,PREG_PATTERN_ORDER);
        for ($y=0;$y<count($sections[0]);$y++) {
          // Parameter und werte trennen
          preg_match_all("/^([^=\[]+)=(.*)/m",$sections[0][$y],$parameter,PREG_PATTERN_ORDER);
          for ($i=0; $i<count($parameter[0]);$i++)
          $iniData[$sections[1][$y]][trim($parameter[1][$i])] = trim($parameter[2][$i]);
        }
      } // Infos aus dem lim File holen (ENDE)

      $tCounter = 1;
      foreach($iniData["Teams"] as $key=>$value) {
        if(isset($iniData["Team".$tCounter]) && $iniData["Team".$tCounter]!="" ) {
          $teamKurz = $iniData["Teamk"][$key];
          $teamMittel = isset($iniData['Teamm'][$key])?$iniData['Teamm'][$key]:'';
          $team = new team($value,$teamKurz,$key,$teamMittel);
          $teamDetails = $iniData["Team".$tCounter];
          foreach ($teamDetails as $detailsKey=>$detailsValue) {
            if(isset($detailsKey) && $detailsKey!="") {
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
      if ( isset($_GET['clibd']) && $_GET['clibd']==1 ) {
        echo "<pre>classlib ".CLASSLIB_VERSION_NR.
        " loadFile($fileName) call from File ".$_SERVER['PHP_SELF']."<pre>";
      }
      // Partien einlesen
      $rCounter = 1;
      while (!empty($iniData["Round".$rCounter]) ) {
        $roundSektion = "Round".$rCounter;
        $startDate = preg_split("/\./",$this->getIniData("D1",$iniData[$roundSektion]));
        $endDate = preg_split("/\./",$this->getIniData("D2",$iniData[$roundSektion]));
        if (count($startDate)!=3 or checkDate($startDate[1],$startDate[0],$startDate[2])==FALSE) {
          $startTime=null;
        } else {
          $startTime=mktime(0,0,0,(int)$startDate[1],(int)$startDate[0],(int)$startDate[2]);
        }

        if (count($endDate) <> 3 or checkDate($endDate[1],$endDate[0],$endDate[2])==FALSE) {
          $endTime=null;
        } else {
          $endTime= mktime(0,0,0,(int)$endDate[1],(int)$endDate[0],(int)$endDate[2]);
        }

        $spieltag = new spieltag($rCounter,$startTime,$endTime);
        // Modus des Spieltags
        $spieltag->setModus($this->getIniData("MO",$iniData[$roundSektion]) );
        // foreach (array_keys($iniData[$roundSektion]) as $pCounter) {
        for ($pCounter=1; isset($iniData[$roundSektion][$pCounter]["TA"]); $pCounter++) {
          // if (!empty($iniData[$roundSektion][$pCounter]["TA"]) ) {
          $heimTeam = &$this->teamForNumber($this->getIniData("TA",$iniData[$roundSektion],$pCounter));
          $gastTeam = &$this->teamForNumber($this->getIniData("TB",$iniData[$roundSektion],$pCounter));
          $partienNumber = 0;
          do { // if ($spieltag->getModus() < 1 )
            $theim = $this->getIniData("GA",$iniData[$roundSektion][$pCounter],++$partienNumber);
            $tgast = $this->getIniData("GB",$iniData[$roundSektion][$pCounter],$partienNumber);
            $notiz = $this->getIniData("NT",$iniData[$roundSektion][$pCounter],$partienNumber);
            $zeit = $this->getIniData("AT",$iniData[$roundSektion][$pCounter],$partienNumber);

            if ( !$spielNr = $this->getIniData("SpNr",$iniData[$roundSektion][$pCounter],$partienNumber) ) {
              $spielNr = strval($pCounter).strval($partienNumber);
            }

            if ( $partienNumber % 2) {
              $partie = new partie($spielNr,$zeit,$notiz,$heimTeam,$gastTeam,$theim,$tgast);
            } else {
              $partie = new partie($spielNr,$zeit,$notiz,$gastTeam,$heimTeam,$theim,$tgast);
            }

            // Spielbericht
            $partie->setreportUrl($this->getIniData("BE",$iniData[$roundSektion][$pCounter],$partienNumber));
            // Spielende ( normal / n.V. / n.E ... )
            $partie->setSpielEnde($this->getIniData("SP",$iniData[$roundSektion][$pCounter],$partienNumber) );
            // Alle Anderen bisher unbekannten Parameter
            $partie->setParameter($iniData[$roundSektion][$pCounter][$partienNumber]);
            $this->addPartie($partie);  // Partien werden zusätzlich zu der Liga hinzugefügt
            $spieltag->addPartie($partie);
          } while ($partienNumber<$spieltag->getModus() );
        }
        $this->addSpieltag($spieltag);
        unset($iniData[$roundSektion]); // weg damit weil bekannt
        $rCounter++;
      }
      // Options einlesen erst zum schluss um teams,rounds zu setzen
      $optionDetails = $iniData["Options"];
      $options = new optionsSektion($this,$optionDetails);

      // Liganame setzen
      if(isset( $optionDetails["Name"]) && $optionDetails["Name"]!="") {
        if ($this->name == "") {
          $this->name = $optionDetails["Name"];
        } else {
          $optionDetails["Name"]=$this->name;
        }
      }
      foreach ($optionDetails as $detailsKey=>$detailsValue) {
        if(isset($detailsKey) && $detailsKey!="") {
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
   * if there is a need for any update functionality for special addons, you should define them
   * inside of the function updateAddons() located in update_addons.php file.
   *
   * @access public
   * @param string fileName Pfad zum ligafile
   * @param integer message
   * @param integer deleteEmptyRounds
   * @return boolean Ergebniss des Speicherns
   */
  function writeFile($fileName="",$message=0,$deleteEmptyRounds=0) {

    //if there is a need for any update functionality for special addons,
    //you should define them inside of the function updateAddons() located
    //in update_addons.php file.
    include PATH_TO_ADDONDIR.'/classlib/update_addons.php';
    $iniData = array(); // Inhalt des LigaFiles
    $aktSpTag = 1;
    $maxSp = 0;
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
    $this->options->keyValues['Title'] = "<acronym title='Liga Manager Online ".CLASSLIB_VERSION."'>LMO</acronym>";
    $this->options->keyValues['Matches'] = $maxSp;
    $this->options->keyValues['Actual'] = isset($aktSpTag)?$aktSpTag:1;
    foreach($this->options->keyValues as $key=>$value) {
      $iniData['Options'][$key] = $value;
    }

    foreach($this->teams as $team) {
      $iniData['Teams'][$team->nr] = $team->name;
      $iniData['Teamk'][$team->nr] = $team->kurz;
      // Sektion Mittellange Teamnamen nur anlegen wenn vorhanden
      if (isset($team->mittel)) {
        $iniData['Teamm'][$team->nr] = $team->mittel;
      }

      // Team Optionen schreiben (z.B. Strafen)
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
    for ($roundCount=1; $roundCount <= $this->spieltageCount(); $roundCount++ ) {
      $spieltag = $this->spieltage[$roundCount-1];
      if ($spieltag->partienCount() > 0 or $deleteEmptyRounds==0) {
        $iniData['Round'.$roundCount]['D1']=$spieltag->vonString();
        $iniData['Round'.$roundCount]['D2']=$spieltag->bisString();
        $iniData['Round'.$roundCount]['MO']=$spieltag->getModus();
        for ($teamCounter=1, $pCounter= 0; $pCounter<$spieltag->partienCount(); $teamCounter++) {
          $partienCounter = 0;
          $iniData['Round'.$roundCount]['TA'.$teamCounter]=$spieltag->partien[$pCounter]->heim->nr;
          $iniData['Round'.$roundCount]['TB'.$teamCounter]=$spieltag->partien[$pCounter]->gast->nr;
          do {
            if ($spieltag->getModus() > 0 ) $partienNumber = strval($teamCounter).strval(++$partienCounter);
            else $partienNumber = $teamCounter;
            $iniData['Round'.$roundCount]['GA'.$partienNumber]=$spieltag->partien[$pCounter]->hTore;
            $iniData['Round'.$roundCount]['GB'.$partienNumber]=$spieltag->partien[$pCounter]->gTore;
            $iniData['Round'.$roundCount]['SP'.$partienNumber]=$spieltag->partien[$pCounter]->getSpielEnde();
            $iniData['Round'.$roundCount]['AT'.$partienNumber]=$spieltag->partien[$pCounter]->zeit;
            $iniData['Round'.$roundCount]['NT'.$partienNumber]=$spieltag->partien[$pCounter]->notiz;
            $iniData['Round'.$roundCount]['BE'.$partienNumber]=$spieltag->partien[$pCounter]->reportUrl;
            foreach ($spieltag->partien[$pCounter]->getParameter() as $otherKey => $otherParameter) {
              $iniData['Round'.$roundCount][$otherKey.$partienNumber]=$otherParameter;
            }
            if ( $pCounter > 10000 ) {
              die("Script Fehler");
            }
          } while (is_object($spieltag->partien[++$pCounter]) && $partienCounter < $spieltag->getModus() );
        }
      }
    }

    // fileContent schreiben
    $datei = @fopen($fileName,"w");
    if (!$datei) {
      echo "<font color=\"#ff0000\">Kann File zum Schreiben nicht öffnen (Schreibrechte?) CLASS liga function writeFile()</font>";
      return false;
    } elseif ($datei && $message==1) {
      echo "<font color=\"#008800\">Writing File $fileName (".$datei.")</font>";
    }
    flock($datei,LOCK_EX);
    foreach($iniData as $sek=>$keys) {
      fputs($datei,"[$sek]\n");
      foreach($keys as $key=>$val) {
        fputs($datei,"$key=$val\n");
      }
      fputs($datei,"\n");
    }
    flock($datei,LOCK_UN);
    fclose($datei);
    // start the update function
    updateAddons($fileName);
    return true;
  }

  /**
   * Zeigt den Inhalt des Ligafiles an
   *
   * Wird nur zum debuggen verwendet.
   *
   * @access private
   * @param boolean htmlContent
   */
  function fileContent($htmlContent=FALSE) {
    $lf = ($htmlContent==FALSE)?'\n':'<BR>';
    // Key "Matches" bestimmen
    foreach ($this->spieltage as $spieltag) {
      if ($spieltag->partienCount() > $this->options->keyValues['Matches']) {
        $this->options->keyValues['Matches'] = $spieltag->partienCount();
      }
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
        $x= $partie->spNr;
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
   * Strafen
   *
   * Wird von calcTable verwende
   *
   * <BR>SP Straf-/Bonuspunkte links
   * <BR>SM Straf-/Bonuspunkte rechts (nur wenn es Minuspunkte gibt)
   * <BR>TOR1 Straf-/Bonustore links
   * <BR>TOR2 Straf-/Bonustore rechts
   * <BR>STDA ab wann zählt Strafe/Bonus
   *
   * @author Tim Schumacher <webobjects@gmx.net>
   * @package classLib
   * @access privat
   */
  function strafen(&$team,$spTag) {
    $stda = isset($team["team"]->keyValues["STDA"])? $team["team"]->keyValues["STDA"]: 0;
    if ($stda==$spTag || ($stda==0 && $spTag==1)) {
      $team["pPkt"]-= isset($team["team"]->keyValues["SP"])? $team["team"]->keyValues["SP"]:0;
      $team["pTor"]-= isset($team["team"]->keyValues["TOR1"])? $team["team"]->keyValues["TOR1"]:0;
      $team["mTor"]-= isset($team["team"]->keyValues["TOR2"])? abs($team["team"]->keyValues["TOR2"]):0;
      if ($this->options->keyValues['MinusPoints'] == 2 && isset($team["team"]->keyValues["SM"]) ) {
        $team["mPkt"] -= $team["team"]->keyValues["SM"];
      }
    }
  }

  /**
   * Berechnet den Tabellenstand für einen Spieltag
   *
   * Berechnet den Tabellenstand für einen Spieltag und gibt
   * ein mehrdimensionales Array zurück:
   *    mit n = anzahlTeams - 1;
   *    $myArray[0..n]["pos"]        Tabellenposition
   *    $myArray[0..n]["team"]       Referenz auf Team
   *    $myArray[0..n]["spiele"]     gespielte Partien
   *    $myArray[0..n]["s"]          Anzahl Spiege
   *    $myArray[0..n]["u"]          Anzahl Unendschieden
   *    $myArray[0..n]["n"]          Anzahl Niederlagen
   *    $myArray[0..n]["pTor"]       Erzielte Tore
   *    $myArray[0..n]["mTor"]       Erzielte Gegentore
   *    $myArray[0..n]["dTor"]       Tordifferenz
   *    $myArray[0..n]["pPkt"]       Pluspunkte
   *    $myArray[0..n]["mPkt"]       Minuspunkte
   *    $myArray[0..n]["possp"]      Position an dem $key Spieltag
   *
   * @access public
   * @param integer spTag Spieltag für den die Tabelle berechnet werden soll.
   * @param string tableArt Art der Tabelle "all","heim","gast","hin","rueck"
   * @param boolean possp wenn true wird für jeden Spieltag die Position bestimmt (Statistik)
   * @return array Tabelle des Angegebenen Spieltages
   */
  function calcTable($spTag=1,$tableArt="all",$possp=false) {

    $actual = $this->options->keyValues['Actual'];
    $spTag = ($spTag<1)?$actual:$spTag;
    $spTagCount = 1;

    foreach ($this->teams as $team) {
      $tableArray[] = array ("pos"=>-1,
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
      "possp"=> array());
    }
    foreach ($this->spieltage as $spieltag) {
      if ($spieltag->getModus() > 0 ) {
        continue;
      }
      if($tableArt=="hin" && ($spieltag->nr > ($this->spieltageCount()/2) )) {
        if($spTagCount<$spTag) {
          $spTagCount++;
        } else {
          break;
        }
        continue;
      } elseif($tableArt=="rueck" && ($spieltag->nr <= $this->spieltageCount()/2 )) {
        if($spTagCount<$spTag) {
          $spTagCount++;
        } else {
          break;
        }
        continue;
      }
      foreach ($spieltag->partien as $partie) {
        $heimCount = -1;
        $gastCount = -1;
        $count=0;
        if ( $partie->spielEnde == 2 ) { // Nach Verlängerung
          $pointsForWin = $this->options->keyValues['XtraS'];
          $pointsForDraw = $this->options->keyValues['XtraU'];
          $pointsForLost = $this->options->keyValues['XtraV'];
        } elseif ( $partie->spielEnde == 1 ) { // Nach Elfmetersch. oder nach Penalty
          $pointsForWin = $this->options->keyValues['SpezS'];
          $pointsForDraw = $this->options->keyValues['SpezU'];
          $pointsForLost = $this->options->keyValues['SpezV'];
        } else { // normales Spielende
          $pointsForWin = $this->options->keyValues['PointsForWin'];
          $pointsForDraw = $this->options->keyValues['PointsForDraw'];
          $pointsForLost = $this->options->keyValues['PointsForLost'];
        }
        for ($count=0;$count<count($tableArray) && ($heimCount==-1 || $gastCount==-1);$count++) { // Teams der Partie finden
          if ($tableArray[$count]["team"]===$partie->heim) {
            $heimCount=$count;
          }
          if ($tableArray[$count]["team"]===$partie->gast) {
            $gastCount=$count;
          }
          }
        // Strafen berücksichtigen
        if ($heimCount!=-1) {
          $this->strafen($tableArray[$heimCount],$spTagCount);
        }
        if ($gastCount!=-1) {
          $this->strafen($tableArray[$gastCount],$spTagCount);
        }

        if ($partie->hTore>-1) {
          // Tore für Heim hinzufügen
          $tableArray[$heimCount]["pTor"] += $tableArt!="gast"? $partie->hTore:0;
          $tableArray[$gastCount]["mTor"] += $tableArt!="heim"? $partie->hTore:0;
        }
        if ($partie->gTore>-1) {
          // Tore für Gast hinzufügen
          $tableArray[$gastCount]["pTor"] += $tableArt!="heim"? $partie->gTore:0;
          $tableArray[$heimCount]["mTor"] += $tableArt!="gast"? $partie->gTore:0;
        }
        if ($partie->hTore>-1 && $partie->gTore>-1) { // Ein normales Ergebnis?
          if ($partie->gTore == $partie->hTore) { // Unendschieden
            if ($tableArt != "gast") {
              $tableArray[$heimCount]["pPkt"] += $pointsForDraw;
              $tableArray[$heimCount]["mPkt"] += $pointsForDraw;
              $tableArray[$heimCount]["u"] ++;
              $tableArray[$heimCount]["spiele"] ++;
            }
            if ($tableArt != "heim") {
              $tableArray[$gastCount]["pPkt"] += $pointsForDraw;
              $tableArray[$gastCount]["mPkt"] += $pointsForDraw;
              $tableArray[$gastCount]["u"] ++;
              $tableArray[$gastCount]["spiele"] ++;
            }
          }
          elseif ($partie->gTore > $partie->hTore) { // Gast hat gewonnen
            if ($tableArt != "gast") {
              $tableArray[$heimCount]["mPkt"] += $pointsForWin;
              $tableArray[$heimCount]["pPkt"] += $pointsForLost;
              $tableArray[$heimCount]["n"] ++;
              $tableArray[$heimCount]["spiele"] ++;
            }
            if ($tableArt != "heim") {
              $tableArray[$gastCount]["pPkt"] += $pointsForWin;
              $tableArray[$gastCount]["mPkt"] += $pointsForLost;
              $tableArray[$gastCount]["s"] ++;
              $tableArray[$gastCount]["spiele"] ++;
            }
          }
          elseif ($partie->gTore < $partie->hTore) { // Heim hat gewonnen
            if ($tableArt != "gast") {
              $tableArray[$heimCount]["pPkt"] += $pointsForWin;
              $tableArray[$heimCount]["mPkt"] += $pointsForLost;
              $tableArray[$heimCount]["s"] ++;
              $tableArray[$heimCount]["spiele"] ++;
            }
            if ($tableArt != "heim") {
              $tableArray[$gastCount]["mPkt"] += $pointsForWin;
              $tableArray[$gastCount]["pPkt"] += $pointsForLost;
              $tableArray[$gastCount]["n"] ++;
              $tableArray[$gastCount]["spiele"] ++;
            }
          }
          else { // nur während der Entwicklung
            echo "Fehler in Punkteermittlung (Normales Ergebnis)";
            echo $partie->showDetailsHTML();
          }
        }
        else if ($partie->hTore==-2) { // O:0 Tore Heim gewinnt
          if ($tableArt != "gast") {
            $tableArray[$heimCount]["pPkt"] += $pointsForWin;
            $tableArray[$heimCount]["mPkt"] += $pointsForLost;
            $tableArray[$heimCount]["s"] ++;
            $tableArray[$heimCount]["spiele"] ++;
          }
          if ($tableArt != "heim") {
            $tableArray[$gastCount]["mPkt"] += $pointsForWin;
            $tableArray[$gastCount]["pPkt"] += $pointsForLost;
            $tableArray[$gastCount]["n"] ++;
            $tableArray[$gastCount]["spiele"] ++;
          }
        }
        else if ($partie->gTore==-2) { // O:0 Tore Gast gewinnt
          if ($tableArt != "gast") {
            $tableArray[$heimCount]["mPkt"] += $pointsForWin;
            $tableArray[$heimCount]["pPkt"] += $pointsForLost;
            $tableArray[$heimCount]["n"] ++;
            $tableArray[$heimCount]["spiele"] ++;
          }
          if ($tableArt != "heim") {
            $tableArray[$gastCount]["pPkt"] += $pointsForWin;
            $tableArray[$gastCount]["mPkt"] += $pointsForLost;
            $tableArray[$gastCount]["s"] ++;
            $tableArray[$gastCount]["spiele"] ++;
          }
        }
      } // foreach Partien
      //Zusätzliche Berechnung der Position für den jeweiligen Spieltag (Statisktik)
      if($possp == TRUE) {
        for ($i=0;$i<count($tableArray);$i++) { // Tordiff.
          $tableArray[$i]["dTor"]=$tableArray[$i]["pTor"]-$tableArray[$i]["mTor"];
        }
        $tableArray = $this->sortTable($tableArray);
        for ($i=0; $i<count($tableArray) ; $i++) {
          $tableArray[$i]["possp"][$spTagCount-1] = $tableArray[$i]["pos"];
        }
      }
      if($spTagCount<$spTag) {
        $spTagCount++;
      } else {
        break;
      }
    } // foreach Spieltage

    for ($i=0;$i<count($tableArray);$i++) { // Tordiff.
      $tableArray[$i]["dTor"]=$tableArray[$i]["pTor"]-$tableArray[$i]["mTor"];
    }
    return $this->sortTable($tableArray);
  }

  /**
   * Sortiert die errechnete Tabelle und gibt diese als Array zurück
   * Reihenfolge :
   * ->keyValues['Kegel'] = 0 -> PlusPunkte - NegativPunkte - Tor Differenz - erziehlte Tore - Gegentore
   * ->keyValues['Kegel'] = 1 -> Pluspunkte - NegativPunkte - erziehlte Tore - Tor Differenz
   *
   * @access protected
   * @param array tableArray Die zu sortierende Tabelle
   * @return array
   */
  function sortTable($tableArray) {
      foreach($tableArray as $table) {
        $sort_pPkt[] = $table["pPkt"];
        $sort_mPkt[] = $this->options->keyValues['MinusPoints'] == 2?$table["mPkt"]: 0;
        $sort_pTor[] = $table["pTor"];
        $sort_mTor[] = $table["mTor"];
        $sort_dTor[] = $table["dTor"];
      }
    // ASC = auf-, DESC = absteigend
    if ( $this->options->keyValues['Kegel']==1 ) { // Sortierung Punkte,erzielte Tore
      array_multisort($sort_pPkt,SORT_DESC ,$sort_mPkt,SORT_ASC ,$sort_pTor,SORT_DESC ,$sort_dtor,SORT_DESC ,$tableArray,SORT_DESC);
    } else {// Sortierung PlusPkt,Tordiff
      array_multisort($sort_pPkt,SORT_DESC, $sort_mPkt,SORT_ASC, $sort_dTor,SORT_DESC, $sort_pTor,SORT_DESC, $sort_mTor,SORT_ASC, $tableArray,SORT_DESC);
    }
    // BEGIN Direkter Vergleich
    if($this->options->keyValues['Direct']==1) {
      $subteams = array();
      $pPkt = 0;
      $nPkt = 0;
      for ($abc = 0; $abc < count($tableArray); $abc++) {
        if($pPkt == $tableArray[$abc]["pPkt"] && $nPkt == $tableArray[$abc]["nPkt"]) {
          $subteams[$tableArray[$abc]["team"]->nr] = $tableArray[$abc]["team"];
        } else {
          if(count($subteams)>1) {
            $tmp_table = $this->calcTableforTeams($subteams);
            $tmp_tablearray = $tableArray;
            $nextpos = $abc - count($tmp_table) ;
            for ($b = 0; $b < count($tmp_table); $b++) {
              for($f = $nextpos; $f < $abc; $f++) {
                if($tmp_tablearray[$f]["team"]===$tmp_table[$b]["team"]) {
                  $tableArray[$nextpos+$b] = $tmp_tablearray[$f];
                }
              }
            }
          } // END if(count($subteams)>1)
          $subteams = array();
          $pPkt = $tableArray[$abc]["pPkt"];
          $nPkt = $tableArray[$abc]["nPkt"];
          $subteams[$tableArray[$abc]["team"]->nr] = $tableArray[$abc]["team"];
        }
      } // END for ($abc = 0; $abc < count($tableArray); $abc++)
    } // END Direkter Vergleich
    for ($i= 0;$i<count($tableArray);$i++) { // Position setzen
      $tableArray[$i]["pos"]=$i+1;
    }
    return $tableArray;
  }

  /**
   * Errechnet eine Tabelle für den Direkten vergleich von mehreren Mannschaften
   *
   * @access protected
   * @param array subteams Alle Teams die Miteinander verglichen werden sollen
   * @return array
   */
  function calcTableforTeams($subteams) {
    $spTagCount = 1;
    foreach ($subteams as $team) {
      $tableArray[] = array ("pos"=>-1,
                             "team"=>$team,
                             "spiele"=> 0,
                             "pTor"=> 0,
                             "mTor"=> 0,
                             "dTor"=> 0,
                             "pPkt"=> 0,
                             "mPkt"=> 0);
    }
    foreach ($this->spieltage as $spieltag) {
      foreach ($spieltag->partien as $partie) {
        if ( $partie->spielEnde == 2 ) { // Nach Verlängerung
          $pointsForWin = $this->options->keyValues['XtraS'];
          $pointsForDraw = $this->options->keyValues['XtraU'];
          $pointsForLost = $this->options->keyValues['XtraV'];
        } elseif ( $partie->spielEnde == 1 ) { // Nach Elfmetersch. oder nach Penalty
          $pointsForWin = $this->options->keyValues['SpezS'];
          $pointsForDraw = $this->options->keyValues['SpezU'];
          $pointsForLost = $this->options->keyValues['SpezV'];
        } else { // normales Spielende
          $pointsForWin = $this->options->keyValues['PointsForWin'];
          $pointsForDraw = $this->options->keyValues['PointsForDraw'];
          $pointsForLost = $this->options->keyValues['PointsForLost'];
        }
        $heimCount = -1;
        $gastCount = -1;
        for ($count=0;$count<count($tableArray) && ($heimCount==-1 || $gastCount==-1);$count++) { // Teams der Partie finden
          if ($tableArray[$count]["team"]===$partie->heim) $heimCount=$count;
          if ($tableArray[$count]["team"]===$partie->gast) $gastCount=$count;
        }
        if($heimCount==-1 OR $gastCount==-1) continue;
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
        if ($partie->hTore>-1 && $partie->gTore>-1) { // Ein normales Ergebnis?
          $tableArray[$heimCount]["spiele"] ++;
          $tableArray[$gastCount]["spiele"] ++;
          if ($partie->gTore == $partie->hTore) { // Unendschieden
            $tableArray[$heimCount]["pPkt"] += $pointsForDraw;
            $tableArray[$heimCount]["mPkt"] += $pointsForDraw;
            $tableArray[$gastCount]["pPkt"] += $pointsForDraw;
            $tableArray[$gastCount]["mPkt"] += $pointsForDraw;
          } elseif ($partie->gTore > $partie->hTore) { // Gast hat gewonnen
            $tableArray[$heimCount]["mPkt"] += $pointsForWin;
            $tableArray[$gastCount]["pPkt"] += $pointsForWin;
            $tableArray[$heimCount]["pPkt"] += $pointsForLost;
            $tableArray[$gastCount]["mPkt"] += $pointsForLost;
          } elseif ($partie->gTore < $partie->hTore) { // Heim hat gewonnen
            $tableArray[$heimCount]["pPkt"] += $pointsForWin;
            $tableArray[$gastCount]["mPkt"] += $pointsForWin;
            $tableArray[$heimCount]["mPkt"] += $pointsForLost;
            $tableArray[$gastCount]["pPkt"] += $pointsForLost;
          } else { // nur während der Entwicklung
            echo "Fehler in Punkteermittlung (Normales Ergebnis)";
            echo $partie->showDetailsHTML();
          }
        } elseif ($partie->hTore==-2) { // O:0 Tore Heim gewinnt
          $tableArray[$heimCount]["pPkt"] += $pointsForWin;
          $tableArray[$gastCount]["mPkt"] += $pointsForWin;
          $tableArray[$heimCount]["mPkt"] += $pointsForLost;
          $tableArray[$gastCount]["pPkt"] += $pointsForLost;
        } elseif ($partie->gTore==-2) { // O:0 Tore Gast gewinnt
          $tableArray[$heimCount]["mPkt"] += $pointsForWin;
          $tableArray[$gastCount]["pPkt"] += $pointsForWin;
          $tableArray[$heimCount]["mPkt"] += $pointsForLost;
          $tableArray[$gastCount]["pPkt"] += $pointsForLost;
        }
      } // foreach Partien
    } // foreach Spieltage
    for ($i=0;$i<count($tableArray);$i++) { // Tordiff.
      $tableArray[$i]["dTor"]=$tableArray[$i]["pTor"]-$tableArray[$i]["mTor"];
    }
    return $this->sortDirectTable($tableArray);
  }

  /**
   * Sortiert die errechnete Tabelle bei Direktem Vergleich und gibt diese als Array zurück
   * Ist seperat da bei vielen Ligen die Sortierung bei Direktem Vergleich
   * von der Sortierung der Kompletten Tabelle abweicht
   *
   * @access protected
   * @param array $tableArray Die zu sortierende Tabelle
   * @return array
   */
  function sortDirectTable($tableArray) {
    return liga::sortTable($tableArray);
  }

} // End Class Liga

?>
