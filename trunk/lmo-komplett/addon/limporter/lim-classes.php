<?PHP
//
// Limporter Class Library Version 1.5 (01/2004)
// Copyright (C) 2003 by Tim Schumacher
// timme@uni.de /
//
// This program is free software; you can redistribute it and/or
// modify it under the terms of the GNU General Public License as
// published by the Free Software Foundation; either version 2 of
// the License, or (at your option) any later version.
//
// This program is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
// General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with this program; if not, write to the Free Software
// Foundation, Inc., 675 Mass Ave, Cambridge, MA 02139, USA.
//



//
// Class team
//
// Limporter Class Library
// Copyright (C) 2003 by Tim Schumacher
// timme@uni.de /

class team {
	var $name;
	var $kurz;
	var $nr;
	var $keyValues;

	function team($name="",$kurz="",$nr="") {
		$this->name = $name;
		$this->kurz = $kurz;
		$this->nr = $nr;
		$this->keyValues = array("SP"=>0,"SM"=>0,"TOR1"=>0,"TOR2"=>0,"STDA"=>0,"URL"=>"","NOT"=>"");
	}

	function addKeyValue ($new_key,$new_value) {
		$this->keyValues[$new_key]=$new_value;
	}

	function valueForKey($new_key) {
		return $this->keyValues[$new_key];
	}
} // class team


//
// Class partie
//
// Limporter Class Library
// Copyright (C) 2003 by Tim Schumacher
// timme@uni.de /

class partie {
	var $n_SpNr,$zeit,$notiz,$heim,$gast,$hTore,$gTore,$hPunkte,$gPunkte;


	function partie($n_spNr,$n_time,$n_notiz,&$n_heim,&$n_gast,$n_htore,$n_gtore,$n_hpunkte,$n_gpunkte) {
		$this->spNr = $n_spNr;
		$this->zeit = $n_time;
		$this->notiz = $n_notiz;
		$this->heim = &$n_heim;
		$this->gast = &$n_gast;
		$this->hTore = $n_htore;
		$this->gTore = $n_gtore;
		$this->hPunkte = $n_hpunkte;
		$this->gPunkte = $n_gpunkte;
	}

	function datumString() {
		$datum = "";
		if ($this->zeit!='')
			$datum = date("d.m.Y",$this->zeit);
		return $datum;
	}

	function zeitString() {
		$zeit = "";
		if ($this->zeit!='')
			$zeit = date("H:i",$this->zeit);
		return $zeit;
	}

	function showDetails() {
		echo $this->heim->name." - ".$this->gast->name;
		echo " Anpfiff: ".$this->zeitString()."Uhr";
		echo " Ergebnis:".$this->hTore." - ".$this->gTore."\n";
	}

	function showDetailsHTML() {
		echo "<BR>".$this->heim->name." - ".$this->gast->name;
		echo " Anpfiff: ".$this->zeitString()."Uhr";
		echo " Ergebnis:".$this->hTore." - ".$this->gTore;
	}

} // class partie

//
// Class spieltag
//
// Limporter Class Library
// Copyright (C) 2003 by Tim Schumacher
// timme@uni.de /

class spieltag {

	var $nr;
	var $von;
	var $bis;
	var $partien;

	function spieltag($new_nr,$new_von,$new_bis,$partien=array()) {
		$this->nr = $new_nr;
		$this->von = $new_von;
		$this->bis = $new_bis;
		$this->partien = $partien;
	}

	function &partieForNumber($number) {
		$result = null;
		if(isset($number) and $nNumber > 0 and $number <= $this->partienCount())
			$result = $this->partien[$number-1];
		return $result;
	}

	function &partieForTeams($heimNr,$gastNr) {
		$count = $this->partienCount();
//		echo "<BR>partieForTeams $heimNr,$gastNr";
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


	function partienCount() {
		return count($this->partien);
	}

	function addPartie(&$neuePartie) {
		$this->partien[] = $neuePartie; // &$ Das muss so sein
	}

	function showDetails() {
		echo "\n".$this->nr.". Spieltag (".$this->vonBisString().")\n";
		foreach ($this->partien as $partie) {
			echo $partie->showDetails()."\n";
		}
	}

	function showDetailsHTML() {
		echo "<BR>".$this->nr.". Spieltag (".$this->vonBisString().")";
		foreach ($this->partien as $partie) {
			echo "<BR>".$partie->showDetailsHTML();
		}
	}

	function vonBisString() {
		$von = "";
		$bis = "";
		if ($this->von!='')
			$von = date("d.m.Y",$this->von);
		if ($this->bis!='')
			$bis = date("d.m.Y",$this->bis);

		if ($von!="" and $bis!="")
			return $von." bis ".$bis;
		return $von.$bis;
	}

	function vonString() {
		$von = "";
		if ($this->von!='')
			$von = date("d.m.Y",$this->von);
		return $von;
	}

	function bisString() {
		$bis = '';
		if ($this->bis!='')
			$bis = date("d.m.Y",$this->bis);
		return $bis;

	}

} // END class spieltag

//
// Class liga
//
// Limporter Class Library
// Copyright (C) 2003 by Tim Schumacher
// timme@uni.de /

class liga {
	var $count;
	var $teams;
	var $name;
	var $kurz;
	var $aktSpTag;
	var $partien;
	var $spieltage;
	var $fileName;

 	function liga($name="",$kurz="") {
		$this->name = $name;
		$this->kurz = $kurz;
		$this->spieltage = array();
		$this->partien = array();
		$this->teams = array();
	}

	function teamCount() {
		return count($this->teams);
	}

	function addTeam(&$neuesTeam) {
		$this->teams[] = $neuesTeam; // Das muss so sein
	}

	function &teamForName($teamName) {
		$count = $this->teamCount();
		$i = -1;
		$found=-1;
		$selectedTeam = null;
		while (($i<$count) and ($found<>0)):
			$i++;
			$found = strcmp($this->teams[$i]->name,$teamName);
		endwhile;
		if ($found==0) return $this->teams[$i];
		else return null;
	}

	function &teamForNumber($teamNumber) {
		$result = null;
		if(isset($teamNumber) and $teamNumber > 0 and $teamNumber <= $this->teamCount())
			$result = $this->teams[$teamNumber-1];
		return $result;
	}

	function teamNames() {
		$teamArray = array();
		foreach((array)$this->teams as $team) {
			$teamArray[] = (string)$team->name;
		}
		return $teamArray;
	}

	function partienCount() {
		return count($this->partien);
	}

	function addPartie(&$neuePartie) {
		$this->partien[] = $neuePartie;
	}

	function &partieForNumber($number) {
		$result = null;
		if(isset($number) and $nNumber > 0 and $number <= $this->partienCount())
			$result = $this->partien[$number-1];
		return $result;
	}

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


	function addSpieltag(&$neuerSpieltag) {
		$this->spieltage[] = $neuerSpieltag;
	}

	function spieltageCount() {
		return count($this->spieltage);
	}

	function &SpieltagForNumber($spTagNr) {
		$count = $this->spielTageCount();
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

	function showPartienHTML() {
		echo "<BR>Liga = $this->name";
		foreach ($this->partien as $partie) {
			$partie->showDetailsHTML();
		}
	}


	function showDetails() {
		echo "LigaName = $this->name\n";
		foreach ($this->spieltage as $spTag) {
			$spTag->showDetails();
		}
	}

	function showDetailsHTML() {
		echo "<BR>Liga = $this->name";
		foreach ($this->spieltage as $spTag) {
			$spTag->showDetailsHTML();
		}
	}



	function loadFile($fileName="") {
    $sekt="";
		$status = False;
		if($fileName != "") {
      $stand=date("d.m.Y H:i",filemtime($fileName));
      $datei = fopen($fileName,"rb");

      while (!feof($datei)) {
        $zeile = fgets($datei,1000);
        $zeile = chop($zeile);
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


      $tCounter = 1;
      foreach($iniData["Teams"] as $key=>$value) {
        if(isset($iniData["Team".$tCounter]) and $iniData["Team".$tCounter]!="" ) {
          $teamName = $value;
          $teamKurz = $iniData["Teamk"][$key];
          $team = new team($teamName,$teamKurz,$key);
          $teamDetails = $iniData["Team".$tCounter];
          foreach ($teamDetails as $detailsKey=>$detailsValue) {
            if(isset($detailsKey) and $detailsKey!="") {
              $team->addKeyValue($detailsKey,$detailsValue);
            }
          }
          $this->addTeam($team);
          $tCounter++;
        }
      }
      // Partien einlesen
      $rCounter = 1;
      while (isset($iniData["Round".$rCounter]) and $iniData["Round".$rCounter]!="" ) {

        $pCounter = 1;
        $roundSektion = "Round".$rCounter;
        $startDateString = getIniData("D1".$pCounter,$iniData[$roundSektion]);//$iniData[$roundSektion]["D1"];
        $endDateString = getIniData("D2".$pCounter,$iniData[$roundSektion]);//$iniData[$roundSektion]["D2"];
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

        while (isset($iniData[$roundSektion]["TA".$pCounter]) and $iniData[$roundSektion]["TA".$pCounter]!="" ) {
          $heim =  getIniData("TA".$pCounter,$iniData[$roundSektion]);//$iniData[$roundSektion]["TA".$pCounter];
          $gast =  getIniData("TB".$pCounter,$iniData[$roundSektion]);//  $iniData[$roundSektion]["TB".$pCounter];
          $heimTeam = &$this->teamForNumber($heim);
          $gastTeam = &$this->teamForNumber($gast);
          $theim =  getIniData("GA".$pCounter,$iniData[$roundSektion]);//  $iniData[$roundSektion]["GA".$pCounter];
          $tgast =  getIniData("GB".$pCounter,$iniData[$roundSektion]);//  $iniData[$roundSektion]["GB".$pCounter];
          $notiz =  getIniData("NT".$pCounter,$iniData[$roundSektion]);//  $iniData[$roundSektion]["NT".$pCounter];
					$zeit =   getIniData("AT".$pCounter,$iniData[$roundSektion]);//$iniData[$roundSektion]["AT".$pCounter];;
/*
          $heim =  $iniData[$roundSektion]["TA".$pCounter];
          $gast =  $iniData[$roundSektion]["TB".$pCounter];
          $heimTeam = &$this->teamForNumber($heim);
          $gastTeam = &$this->teamForNumber($gast);
          $theim =  $iniData[$roundSektion]["GA".$pCounter];
          $tgast =  $iniData[$roundSektion]["GB".$pCounter];
          $notiz =  $iniData[$roundSektion]["NT".$pCounter];
					$zeit = $iniData[$roundSektion]["AT".$pCounter];;
      //    $be =     $ini->getIniFile($roundSektion,"BE".$pCounter,"");
      //    $ti =     $ini->getIniFile($roundSektion,"TI".$pCounter,"");
*/
          if (isset($heimTeam) and isset($gastTeam)) {
//					  echo "<BR>Partie zu Spieltag $spieltag->nr hinzugefügt";
            $partie =new partie($pCounter,$zeit,$notiz,&$heimTeam,&$gastTeam,$theim,$tgast,"","") ;
						$this->addPartie($partie);  // Partien werden zusätzlich zu der Liga hinzugefügt
            $spieltag->addPartie($partie);
          }
//          else echo "kein Team gefunden";
          $pCounter++;

        }
				$this->addSpieltag($spieltag);
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
          $options->keyValue[$detailsKey]=$detailsValue;
        }
      }
      $this->options=&$options;
      $status= True;
  	}

  return $status;
	}

	function writeFile($fileName="",$message=0,$deleteEmptyRounds=0) {
  	$datei = fopen($fileName,"w");
		if (!$datei) {
    	echo "<font color=\"#ff0000\">Kann File zum Schreiben nicht öffnen (Schreibrechte?) CLASS liga function writeFile()</font>";
    	exit;
		}else if ($datei and $message==1){
   		echo "<font color=\"#008800\">Writing File $fileName (".$datei.")</font>";
		}
    flock($datei,2);

    // Key "Matches" bestimmen
    foreach ($this->spieltage as $spieltag) {
      if ($spieltag->partienCount() > $this->options->keyValues['Matches'])
        $this->options->setKeyValue['Matches'] = $spieltag->partienCount();
    }

		fputs($datei,"[Options]\n");
		foreach($this->options->keyValues as $key=>$value) {
			fputs($datei,"$key=$value\n");
		}
		fputs($datei,"\n[Teams]\n");
		foreach($this->teams as $team) {
			fputs($datei,$team->nr."=".$team->name."\n");
		}
		fputs($datei,"\n[Teamk]\n");
		foreach($this->teams as $team) {
			fputs($datei,$team->nr."=".$team->kurz."\n");
		}
		foreach($this->teams as $team) {
			fputs($datei,"\n[Team".$team->nr."]\n");
			foreach ($team->keyValues as $key=>$value) {
				fputs($datei,"$key=$value\n");
			}
		}
		$roundCount = 0;
	  foreach($this->spieltage as $spieltag) {
	  	if ($spieltag->partienCount() > 0 or $deleteEmptyRounds==1) {
        $roundCount++;
        fputs($datei,"\n[Round".$roundCount."]\n");
        fputs($datei,"D1=".$spieltag->vonString()."\n");
        fputs($datei,"D2=".$spieltag->bisString()."\n");
        $x=1;
//        echo"<BR>".$roundCount.".Spieltag (".$spieltag->partienCount().") Partien gespeichert";
        foreach ($spieltag->partien as $partie) {
          fputs($datei,"TA".$x."=".$partie->heim->nr."\n");
          fputs($datei,"TB".$x."=".$partie->gast->nr."\n");
          fputs($datei,"GA".$x."=".$partie->hTore."\n");
          fputs($datei,"GB".$x."=".$partie->gTore."\n");
          fputs($datei,"AT".$x."=".$partie->zeit."\n");
          fputs($datei,"NT".$x."=".$partie->notiz."\n");
          $x++;
        }

			}
//    	$roundCount++;
    }
		flock($datei,3);
    fclose($datei);
	}

  // Nur fuer die Onlinedemo Ligafile wird im Textfeld angezeigt
	function fileContent() {
    // Key "Matches" bestimmen
    foreach ($this->spieltage as $spieltag) {
      if ($spieltag->partienCount() > $this->options->keyValues['Matches'])
        $this->options->setKeyValue['Matches'] = $spieltag->partienCount();
    }

		echo"[Options]\n";
		foreach($this->options->keyValues as $key=>$value) {
			echo"$key=$value\n";
		}
		echo"\n[Teams]\n";
		foreach($this->teams as $team) {
			echo$team->nr."=".$team->name."\n";
		}
		echo"\n[Teamk]\n";
		foreach($this->teams as $team) {
			echo$team->nr."=".$team->kurz."\n";
		}
		foreach($this->teams as $team) {
			echo"\n[Team".$team->nr."]\n";
			foreach ($team->keyValues as $key=>$value) {
				echo"$key=$value\n";
			}
		}
		$roundCount = 1;
	  foreach($this->spieltage as $spieltag) {
			echo"\n[Round".$roundCount."]\n";
			echo"D1=".$spieltag->vonString()."\n";
			echo"D2=".$spieltag->bisString()."\n";
	    $x=1;
	    foreach ($spieltag->partien as $partie) {
				echo"TA".$x."=".$partie->heim->nr."\n";
				echo"TB".$x."=".$partie->gast->nr."\n";
				echo"GA".$x."=".$partie->hTore."\n";
				echo"GB".$x."=".$partie->gTore."\n";
				echo"AT".$x."=".$partie->zeit."\n";
				echo"NT".$x."=".$partie->notiz."\n";
    		$x++;
    	}
    	$roundCount++;
    }
	}

} // End Class Liga

//
// Class sektion
//
// Limporter Class Library
// Copyright (C) 2003 by Tim Schumacher
// timme@uni.de /

class sektion {
	var $keyValues;
	var $name;

	function sektion($new_name) {
		$this->name = $new_name;
		$this->keyValues = array();
	}

	function sektionName() {
		return "[".$this->name."]";
	}

	function setKeyValue ($new_key,$new_value) {
		$this->keyValues[$new_key]=$new_value;
	}

	function addKeyValue ($new_key,$new_value) {
		$this->keyValues[$new_key]=$new_value;
	}

	function valueForKey($key) {
		return $this->keyValues[$key];
	}

	function HTMLoutput() {
		echo"<BR>".$this->sektionName();
		foreach ($this->keyValues as $key=>$value) {
			echo"<BR>$key = $value";
		}
	}
}

//
// Class optionsSektion extends sektion
//
// Limporter Class Library
// Copyright (C) 2003 by Tim Schumacher
// timme@uni.de /

class optionsSektion extends sektion {
	var $aLiga;
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
        "ticker"=>0);


	function optionsSektion($aLiga="",$optionDetails="") {
		$this->name = "Options";
		if ($optionDetails <> "") {
            foreach ($optionDetails as $key=>$values) {
                $this->keyValues[$key] = $values;
            }
		}
		if(get_class($aLiga)=="liga") { // Wenn eine Liga angegeben wird, werden entsprechende Keys gleich initialisiert
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