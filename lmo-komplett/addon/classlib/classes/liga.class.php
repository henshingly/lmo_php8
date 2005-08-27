<?PHP
/**
 * Liga
 *
 * Bildet das gesammte LigaFile als Objekt ab
 *
 * @package   classLib
 * @version  $Id$
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
  var $teams;
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
  var $partien;
/**
 * Spieltage der Liga,
 * @var array of Spieltag Objects
 * @access public
*/
  var $spieltage;
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
  var $sections;

   function liga($name="",$kurz="") {
    $this->name = $name;
    $this->kurz = $kurz;
    $this->spieltage = array();
    $this->partien = array();
    $this->teams = array();
    $this->fileName = '';
    $this->ligaDatum = '';
    $this->sections = array();  // neu ab 2.5  Speichert den Inhalt unbekannter Sektionen im Array,
    														// damit keine Daten verloren gehen.
  }

/**
 * Gibt die Anzahl der teilnehmenden Mannschaften zurück
 *
*/
  function teamCount() {
    return count($this->teams);
  }

/**
 * Fügt ein Teamobjekt zur Liga hinzu
 * @access private
*/
  function addTeam(&$neuesTeam) {
    $this->teams[] = $neuesTeam; // Das muss so sein
  }

/**
 * Gibt die Referenz auf das Teamobjekt zu einem Teamnamen zurück
 *
*/
  function &teamForName($teamName) {
    $count = $this->teamCount();
    $i = 0;
    $found=-1;
    $selectedTeam = null;
    while (($i<$count) and ($found != 0)):
      $found = strcmp($this->teams[$i]->name,$teamName);
 //     $found = $this->teams[$i]->name == $teamName?0:-1;
      $i++;
    endwhile;
    if ($found==0) return $this->teams[$i-1];
    return null;
  }

/**
 * Gibt die Referenz auf das Teamobjekt zu einer Teamnummer zurück
 *
*/
  function &teamForNumber($teamNumber) {
    $result = null;
    if(isset($teamNumber) and $teamNumber > 0 and $teamNumber <= $this->teamCount())
      $result = $this->teams[$teamNumber-1];
    return $result;
  }

/**
 * Gibt ein Array mit Strings zurück, in dem sämtliche Mannschaftsnamen enthalten sind
 *
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
*/
  function partienCount() {
    return count($this->partien);
  }

/**
 * Fügt eine Partie zur Liga hinzu
 *
 * @access private
*/
  function addPartie(&$neuePartie) {
    $this->partien[] = $neuePartie;
  }
/**
 * Gibt die Referenz auf das Partieobjekt zu einer Nummer zurück
 *
*/
  function &partieForNumber($number) {
    $result = null;
// Bugfix 13.10.04    if(isset($number) and $nNumber > 0 and $number <= $this->partienCount())
    if(isset($number) and $number > 0 and $number <= $this->partienCount())
      $result = $this->partien[$number-1];
    return $result;
  }

/**
 * Gibt die Referenz auf das Partieobjekt zurück, an der die Mannschaften
 * aufeinandertreffen
*/
    function &partieForTeams(&$heim,&$gast) {
        $result = Null;
        foreach ($this->partien as $aPartie) {
            if (($aPartie->heim == $heim ) and ($aPartie->gast == $gast)) {
          $result = $aPartie;
          break;
            }
        }
        return $result;
  }

/**
 * Gibt ein Array von Referenzen auf die Partieobjekte zurück, an denen die Mannschaften
 * aufeinandertreffen - wenn der dritte Parameter both gesetzt ist, werden Partien
 * a vs b UND b vs a zurückgegeben
*/
  function &allPartieForTeams(&$heim,&$gast,$both=FALSE) {
    $result = array();
    foreach ($this->partien as $aPartie) {
      if ( ($aPartie->heim == $heim && $aPartie->gast == $gast) || ($both && $aPartie->heim == $gast && $aPartie->gast == $heim)) {
        $result[] = $aPartie;
      }
    }
    return $result;
  }
  
/**
 * Gibt die Referenz auf das Partieobjekt zurück, an der die Mannschaften
 * mit den anzugebenen Namen aufeinandertreffen
*/
    function &partieForTeamNames($heimName,$gastName) {
    		$heimName = strtolower($heimName);
    		$gastName = strtolower($gastName);
        $result = Null;
        foreach ($this->partien as $aPartie) {
            if ((strtolower($aPartie->heim->name) == $heimName )
            and (strtolower($aPartie->gast->name) == $gastName)) {
              $result = $aPartie;
              break;
            }
        }
        return $result;
  }

/**
 * Fügt einen Spieltag zur Liga hinzu
 *
 * @access private
 *
*/
  function addSpieltag(&$neuerSpieltag) {
    $this->spieltage[] = $neuerSpieltag;
  }

/**
 * Gibt die Anzahl der Spieltage der Liga zurück
 *
 * @access public
 * @return interger Anzahl der Spieltage
 *
*/
  function spieltageCount() {
    return count($this->spieltage);
  }

/**
 * Gibt die Referenz des Spieltags mit der angegebenen Nummer zurück
 *
 * @access public
 * @return object Spieltag der Nummer
*/
  function &SpieltagForNumber($spTagNr) {
    $count = $this->spielTageCount();
    if ($spTagNr > $count) {$spTagNr=$count;}
    $i = -1;
    $found=-1;
    $selectedTag = null;
    while (($i<$count) and ($found<>0)):
      $i++;
      if (isset($this->spieltage[$i]))
        $found = strcmp($this->spieltage[$i]->nr,$spTagNr);

    endwhile;
    if ($found==0) return $this->spieltage[$i];
    else return null;
  }

/**
 * Gibt die Referenz des aktuellen Spieltags zurück
 *
 * @access public
 * @return object Spieltag der Nummer
*/
  function &aktuellerSpieltag() {
    $result = null;
    if (array_key_exists('Actual',$this->options->keyValues)) {
      $aktSpTagNr =  $this->options->keyValues['Actual'];
      if (isset($aktSpTagNr) and ($aktSpTagNr >= 0) and isset($this->spieltage[$aktSpTagNr]) ) {
        $result = $this->spieltage[$aktSpTagNr];
      }
    }
    return $result;
  }

/**
 * Gibt Partienen HTML Formatiert aus
 *
 * @access public
 * @return string
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
 * Gibt Details des Spieltages HTML Formatiert aus
 *
 * @access public
 * @return string
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
 * @access public
 * @return String
*/
  function ligaDatumAsString ($dateFormat=null) {
    $dateFormat = isset($dateFormat)?$dateFormat:$this->options->keyValues['DatF'];
    $dateString = strftime ( $dateFormat , $this->ligaDatum);
  return $dateString;
  }

/**
 * Lädt das angegebene LigaFile und erstellt den Objektbaum
 *
 * @access public
 * @return Boolean
*/
  function loadFile($fileName='') {
    $sekt='';
    $status = False;
    $iniData = array();
    if(file_exists($fileName) and $fileName <> '') {
          $stand = date("d.m.Y H:i",filemtime($fileName));
          $datei = fopen($fileName,"rb");

      while (!feof($datei)) {
        $zeile = fgets($datei,1000);
        $zeile = trim($zeile);
        if((substr($zeile,0,1)=="[") && (substr($zeile,-1)=="]")){
          $sekt=trim(substr($zeile,1,-1));
          }
        elseif((strpos($zeile,"=")!=false) && (substr($zeile,0,1)!=";")){
          $schl = trim(substr($zeile,0,strpos($zeile,"=")));
          $wert = trim(substr($zeile,strpos($zeile,"=")+1));
          $iniData[$sekt][$schl] = $wert;
        }
      }
      fclose($datei);

      // Infos aus dem lim File holen (BEGIN)
      $path_parts = pathinfo($fileName);
			$basename = isset($path_parts['basename'])?$path_parts['basename']:'';
			$dirname = isset($path_parts['dirname'])?$path_parts['dirname']:'';
      $name = substr($basename,0,strlen($basename)-4);
      $limFile = PATH_TO_ADDONDIR.'/limporter/imports/'.$name.'.lim';
      if (file_exists($limFile)) {
          $datei = fopen($limFile,"rb");
          while (!feof($datei)) {
            $zeile = fgets($datei,1000);
            $zeile = trim($zeile);
            if((substr($zeile,0,1)=="[") && (substr($zeile,-1)=="]")){
              $sekt = trim(substr($zeile,1,-1));
              }
            elseif((strpos($zeile,"=")!=false) && (substr($zeile,0,1)!=";")){
              $schl = trim(substr($zeile,0,strpos($zeile,"=")));
              $wert = trim(substr($zeile,strpos($zeile,"=")+1));
              $iniData[$sekt][$schl] = $wert;
            }
          }
          fclose($datei);
      }
      // Infos aus dem lim File holen (ENDE)

      $tCounter = 1;
      foreach($iniData["Teams"] as $key=>$value) {
        if(isset($iniData["Team".$tCounter]) and $iniData["Team".$tCounter]!="" ) {
          $teamName = $value;
          $teamKurz = $iniData["Teamk"][$key];
          $teamMittel = isset($iniData['Teamm'][$key])?$iniData['Teamm'][$key]:'';
          $team = new team($teamName,$teamKurz,$key,$teamMittel);
          $teamDetails = $iniData["Team".$tCounter];
          foreach ($teamDetails as $detailsKey=>$detailsValue) {
            if(isset($detailsKey) and $detailsKey!="") {
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
      if ( isset($_GET['clibd']) and $_GET['clibd']==1 ) {
        echo "<pre>classlib ".CLASSLIB_VERSION_NR.
        " loadFile($fileName) call from File ".$_SERVER['PHP_SELF']."<pre>";
      }
      // Partien einlesen
      $rCounter = 1;
      while (isset($iniData["Round".$rCounter]) and $iniData["Round".$rCounter]!="" ) {
        $pCounter = 1;
        $roundSektion = "Round".$rCounter;
        $startDateString = getIniData("D1",$iniData[$roundSektion]);//$iniData[$roundSektion]["D1"];
        $endDateString = getIniData("D2",$iniData[$roundSektion]);//$iniData[$roundSektion]["D2"];
        // Neu ab Version 2.2
        $pokalModus = getIniData("MO",$iniData[$roundSektion]);
//        echo "<BR>$roundSektion startDateString=$startDateString pokalModus=".$pokalModus;
        $startDate = preg_split("/\./",$startDateString);
        $endDate = preg_split("/\./",$endDateString);
        if (count($startDate) <> 3 or checkDate($startDate[1],$startDate[0],$startDate[2])==FALSE)
          $startTime=null;
        else
          $startTime=mktime(0,0,0,(int)$startDate[1],(int)$startDate[0],(int)$startDate[2]);

        if (count($endDate) <> 3 or checkDate($endDate[1],$endDate[0],$endDate[2])==FALSE)
          $endTime=null;
        else
          $endTime= mktime(0,0,0,(int)$endDate[1],(int)$endDate[0],(int)$endDate[2]);

        $spieltag = new spieltag($rCounter,$startTime,$endTime);

        while (isset($iniData[$roundSektion]["TA".$pCounter])
        	and $iniData[$roundSektion]["TA".$pCounter]!="" ) {
          $heim =  getIniData("TA".$pCounter,$iniData[$roundSektion]);
          $gast =  getIniData("TB".$pCounter,$iniData[$roundSektion]);
          $heimTeam = &$this->teamForNumber($heim);
          $gastTeam = &$this->teamForNumber($gast);

          $ppc = 0; // pokalpartien
          if ($pokalModus<>0)
             $ppc = 1;

          do {
            $ppcStr = ($ppc <> 0)?$ppc:'';
            $theim =  getIniData("GA".$pCounter.$ppcStr,$iniData[$roundSektion]);
            $tgast =  getIniData("GB".$pCounter.$ppcStr,$iniData[$roundSektion]);
            $notiz =  getIniData("NT".$pCounter.$ppcStr,$iniData[$roundSektion]);
            $zeit =   getIniData("AT".$pCounter.$ppcStr,$iniData[$roundSektion]);
            $reportUrl = getIniData("BE".$pCounter.$ppcStr,$iniData[$roundSektion]);
            // Neu ab 2.2 Spielende
            $spEnde = getIniData("SP".$pCounter.$ppcStr,$iniData[$roundSektion],0);

            if (isset($heimTeam) and isset($gastTeam)) {
              $partie = new partie($pCounter,$zeit,$notiz,$heimTeam,$gastTeam,$theim,$tgast,"","");
              $partie->reportUrl = $reportUrl;
              $partie->spielEnde = $spEnde;
              $this->addPartie($partie);  // Partien werden zusätzlich zu der Liga hinzugefügt
              $spieltag->addPartie($partie);
            }
            $pCounter++;
            $ppc++;
          } while ($ppc < $pokalModus);

        }
    		$this->addSpieltag($spieltag);
    		unset($iniData[$roundSektion]); // weg damit weil bekannt
        $rCounter++;
      }

      // Options einlesen erst zum schluss um teams,rounds zu setzen

      $optionDetails = $iniData["Options"];
      $options = new optionsSektion($this,$optionDetails);

      // Liganame setzen
      if(isset( $optionDetails["Name"]) and $optionDetails["Name"]!="") {
        if ($this->name == "")
          $this->name = $optionDetails["Name"];
        else
          $optionDetails["Name"]=$this->name;
       }
      foreach ($optionDetails as $detailsKey=>$detailsValue) {
        if(isset($detailsKey) and $detailsKey!="") {
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
 * @access public
*/
  function writeFile($fileName="",$message=0,$deleteEmptyRounds=0) {
/*
		if there is a need for any update functionality for special addons,
		you should define them inside of the function updateAddons() located
		in update_addons.php file.
*/
		include PATH_TO_ADDONDIR.'/classlib/update_addons.php';
		$iniData = array(); // Inhalt des LigaFiles
    $aktSpTag = 1;
    $maxSp = 0;
    if ($this->options->keyValues['Type']==1){
      echo "<font color=\"#ff0000\"><b>classlib Addon</b> Pokalturniere können noch nicht gespeichert werden</font>";
      exit;
    }
    $datei = fopen($fileName,"w");
    if (!$datei) {
      echo "<font color=\"#ff0000\">Kann File zum Schreiben nicht öffnen (Schreibrechte?) CLASS liga function writeFile()</font>";
      exit;
    }else if ($datei and $message==1){
      echo "<font color=\"#008800\">Writing File $fileName (".$datei.")</font>";
    }
    flock($datei,LOCK_EX);

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
    $this->options->keyValues['Title'] =
       "<acronym title='Liga Manager Online ".CLASSLIB_VERSION."'>LMO</acronym>";
    $this->options->keyValues['Matches'] = $maxSp;
    $this->options->keyValues['Actual'] = isset($aktSpTag)?$aktSpTag:1;

    foreach($this->options->keyValues as $key=>$value) {
			$iniData['Options'][$key] = $value;
    }

    foreach($this->teams as $team) {
			$iniData['Teams'][$team->nr] = $team->name;
			$iniData['Teamk'][$team->nr] = $team->kurz;
			// Sektion Mittellange Teamnamen nur anlegen wenn vorhanden
			if (isset($team->mittel) )
				$iniData['Teamm'][$team->nr] = $team->mittel;

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
    $roundCount = 0;
    foreach($this->spieltage as $spieltag) {
      if ($spieltag->partienCount() > 0 or $deleteEmptyRounds==1) {
        $roundCount++;
        $iniData['Round'.$roundCount]['D1']=$spieltag->vonString();
        $iniData['Round'.$roundCount]['D2']=$spieltag->bisString();
        $x=1;
        foreach ($spieltag->partien as $partie) {
        	$iniData['Round'.$roundCount]['TA'.$x]=$partie->heim->nr;
        	$iniData['Round'.$roundCount]['TB'.$x]=$partie->gast->nr;
        	$iniData['Round'.$roundCount]['GA'.$x]=$partie->hTore;
        	$iniData['Round'.$roundCount]['GB'.$x]=$partie->gTore;
        	$iniData['Round'.$roundCount]['AT'.$x]=$partie->zeit;
        	$iniData['Round'.$roundCount]['NT'.$x]=$partie->notiz;
        	$iniData['Round'.$roundCount]['BE'.$x]=$partie->reportUrl;
          $x++;
        }
      }
    }

// fileContent schreiben
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
  }
/**
 * Zeigt den Inhalt des Ligafiles an
 *
 * Wird nur zum debuggen verwendet.
 *
 * @access private
 *
*/
  function fileContent($htmlContent=FALSE) {
    $lf = ($htmlContent==FALSE)?'\n':'<BR>';
    // Key "Matches" bestimmen
    foreach ($this->spieltage as $spieltag) {
      if ($spieltag->partienCount() > $this->options->keyValues['Matches'])
        $this->options->keyValues['Matches'] = $spieltag->partienCount();
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
 * Berechnet den Tabellenstand für einen Spieltag
 *
 * Berechnet den Tabellenstand für einen Spieltag und gibt
 * ein mehrdimensionales Array zurück:
 *    <BR>mit n = anzahlTeams - 1;
 *    <BR>$myArray[0..n]["pos"]        Tabellenposition
 *    <BR>$myArray[0..n]["team"]       Referenz auf Team
 *    <BR>$myArray[0..n]["spiele"]     gespielte Partien
 *    <BR>$myArray[0..n]["s"]          Anzahl Spiege
 *    <BR>$myArray[0..n]["u"]          Anzahl Unendschieden
 *    <BR>$myArray[0..n]["n"]          Anzahl Niederlagen
 *    <BR>$myArray[0..n]["pTor"]       Erzielte Tore
 *    <BR>$myArray[0..n]["mTor"]       Erzielte Gegentore
 *    <BR>$myArray[0..n]["dTor"]       Tordifferenz
 *    <BR>$myArray[0..n]["pPkt"]       Pluspunkte
 *    <BR>$myArray[0..n]["mPkt"]       Minuspunkte
 */
function calcTable($spTag=1) {

  $actual = $this->options->keyValues['Actual'];
  $pointsForWin = $this->options->keyValues['PointsForWin'];
  $pointsForDraw = $this->options->keyValues['PointsForDraw'];
  $pointsForLost = $this->options->keyValues['PointsForLost'];
  $minusPkte = $pointsForLost<>0 ? TRUE:FALSE;
//  $minusPkte = $this->options->keyValues['MinusPoints']==1 ? TRUE:FALSE;

  // Wiegen die erzielten Tore mehr als die Tordiff.? (nur bei Ligen)
  $kegel = isset($this->options->keyValues['Kegel'])?$this->options->keyValues['Kegel']:0;
  $spTag = ($spTag<1)?$actual:$spTag;
  $spTagCount = 1;

  foreach ($this->teams as $team) {
    $sp = 0;
    $sm = 0;
    $tor1 = 0;
    $tor2 = 0;
    $tableArray[] = array (
      "pos"=>-1,
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
      "ser1"=> 0, // neu in 2.5
      "ser2"=> 0, // neu in 2.5
      "ser3"=> 0  // neu in 2.5
      );
  }
  foreach ($this->spieltage as $spieltag) {
    foreach ($spieltag->partien as $partie) {
      $heimCount = -1;
      $gastCount = -1;
      $count=0;
      foreach ($tableArray as $table) { // Teams der Partie finden
        if ($table["team"]===$partie->heim) $heimCount=$count;
        if ($table["team"]===$partie->gast) $gastCount=$count;
        if ($heimCount>-1 and $gastCount>-1) break;
        $count++;
      }
      // Strafen berücksichtigen
      strafen($tableArray[$heimCount],$spTagCount,$minusPkte);
      strafen($tableArray[$gastCount],$spTagCount,$minusPkte);

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
      if ($partie->hTore>-1 and $partie->gTore>-1) { // Ein normales Ergebnis?
         // Tordifferenz
//        $tableArray[$heimCount]["dTor"] += $partie->hTore-$partie->gTore;
//        $tableArray[$gastCount]["dTor"] += $partie->gTore-$partie->hTore;

          if ($partie->gTore == $partie->hTore) { // Unendschieden
              $tableArray[$heimCount]["pPkt"] += $pointsForDraw;
              $tableArray[$heimCount]["mPkt"] += $pointsForDraw;
              $tableArray[$gastCount]["pPkt"] += $pointsForDraw;
              $tableArray[$gastCount]["mPkt"] += $pointsForDraw;
              $tableArray[$heimCount]["u"] ++;
              $tableArray[$gastCount]["u"] ++;
              $tableArray[$heimCount]["spiele"] ++;
              $tableArray[$gastCount]["spiele"] ++;
              // Unendschieden neu in 2.5
              $tableArray[$heimCount]["ser1"] ++;
              $tableArray[$gastCount]["ser2"] ++;
              $tableArray[$heimCount]["ser2"] ++;
              $tableArray[$gastCount]["ser1"] ++;
              $tableArray[$heimCount]["ser3"] ++;
              $tableArray[$gastCount]["ser3"] ++;
          }
          elseif ($partie->gTore > $partie->hTore) { // Gast hat gewonnen
              $tableArray[$heimCount]["mPkt"] += $pointsForWin;
              $tableArray[$gastCount]["pPkt"] += $pointsForWin;
              $tableArray[$heimCount]["n"] ++;
              $tableArray[$gastCount]["s"] ++;
              $tableArray[$heimCount]["spiele"] ++;
              $tableArray[$gastCount]["spiele"] ++;
              // Gast hat gewonnen  neu in 2.5
              $tableArray[$heimCount]["ser1"] =0;
              $tableArray[$gastCount]["ser1"] ++;
              $tableArray[$gastCount]["ser2"] =0;
              $tableArray[$heimCount]["ser2"] ++;
              $tableArray[$heimCount]["ser3"] =0;
              $tableArray[$gastCount]["ser3"] =0;
          }
          elseif ($partie->gTore < $partie->hTore) { // Heim hat gewonnen
              $tableArray[$heimCount]["pPkt"] += $pointsForWin;
              $tableArray[$gastCount]["mPkt"] += $pointsForWin;
              $tableArray[$heimCount]["s"] ++;
              $tableArray[$gastCount]["n"] ++;
              $tableArray[$heimCount]["spiele"] ++;
              $tableArray[$gastCount]["spiele"] ++;
              // Heim hat gewonnen neu in 2.5
              $tableArray[$heimCount]["ser1"] ++;
              $tableArray[$gastCount]["ser1"] =0;
              $tableArray[$gastCount]["ser2"] ++;
              $tableArray[$heimCount]["ser2"] =0;
              $tableArray[$heimCount]["ser3"] =0;
              $tableArray[$gastCount]["ser3"] =0;
          }
          else { // nur während der Entwicklung
              echo "Fehler in Punkteermittlung (Normales Ergebnis)";
            echo $partie->showDetailsHTML();
            }
      }
      else if ($partie->hTore==-2) { // O:0 Tore Heim gewinnt
                $tableArray[$heimCount]["pPkt"] += $pointsForWin;
                $tableArray[$gastCount]["mPkt"] += $pointsForWin;
                $tableArray[$heimCount]["s"] ++;
                $tableArray[$gastCount]["n"] ++;
                $tableArray[$heimCount]["spiele"] ++;
                $tableArray[$gastCount]["spiele"] ++;
                // Heim hat gewonnen neu in 2.5
                $tableArray[$heimCount]["ser1"] ++;
                $tableArray[$gastCount]["ser1"] =0;
                $tableArray[$gastCount]["ser2"] ++;
                $tableArray[$heimCount]["ser2"] =0;
                $tableArray[$heimCount]["ser3"] =0;
                $tableArray[$gastCount]["ser3"] =0;
      }
      else if ($partie->gTore==-2) { // O:0 Tore Gast gewinnt
                $tableArray[$heimCount]["mPkt"] += $pointsForWin;
                $tableArray[$gastCount]["pPkt"] += $pointsForWin;
                $tableArray[$heimCount]["n"] ++;
                $tableArray[$gastCount]["s"] ++;
                $tableArray[$heimCount]["spiele"] ++;
                $tableArray[$gastCount]["spiele"] ++;
                // Gast hat gewonnen  neu in 2.5
                $tableArray[$heimCount]["ser1"] =0;
                $tableArray[$gastCount]["ser1"] ++;
                $tableArray[$gastCount]["ser2"] =0;
                $tableArray[$heimCount]["ser2"] ++;
                $tableArray[$heimCount]["ser3"] =0;
                $tableArray[$gastCount]["ser3"] =0;
      }
    } // foreach Partien
    if($spTagCount<$spTag) $spTagCount++; else break;
  } // foreach Spieltage

  $i=0;
  while ($i<count($tableArray)) { // Tordiff.
    $tableArray[$i]["dTor"]=$tableArray[$i]["pTor"]-$tableArray[$i]["mTor"];
    $i++;
  }

    // ASC = auf-, DESC = absteigend
  if ($kegel==1) { // Sortierung PlusPkt,erzielte Tore
        foreach($tableArray as $table) {
            $sort_1[] = $table["pPkt"];
            $sort_2[] = $table["pTor"];
        }
        array_multisort($sort_1, SORT_DESC,
                        $sort_2, SORT_DESC,$tableArray);
  }
  else { // Sortierung PlusPkt,Tordiff
        foreach($tableArray as $table) {
            $sort_1[] = $table["pPkt"];
            $sort_2[] = $table["dTor"];
            $sort_3[] = $table["pTor"];
            $sort_4[] = $table["mTor"];
        }
        array_multisort($sort_1, SORT_DESC, $sort_2, SORT_DESC,
                                 $sort_3, SORT_DESC,$sort_4, SORT_ASC,$tableArray);
  }

//  $tableArray=array_values($tableArray);// Index neu erstellen
  $i=0;
  while ($i<count($tableArray)) {// Position setzen
    $tableArray[$i]["pos"]=$i+1;
    $i++;
  }
  // Hier fehlt noch die Prüfung  wie bei Pkt und Torgleichen Teams
  // verfahren werden soll (Direkter Vergleich etc)
  return $tableArray;
}

} // End Class Liga

?>