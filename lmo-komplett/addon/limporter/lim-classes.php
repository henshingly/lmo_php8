<?PHP
//
// Limporter Class Library Version 0.1
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

class Colum {

	function Colum($name,$colNr,$format) {
		$this->name = $name;
		$this->colNr = $colNr;
		$this->format = $format;
	}
}

class Format {

	function Format($name,$expr) {
		$this->name = $name;
		$this->expr = $expr;
	}
}



class team {

	function team($name,$kurz,$nr) {
		$this->name = $name;
		$this->kurz = $kurz;
		$this->nr = $nr;
	}

}

class liga {
	var $count;
	var $teams;
	var $name;
	var $kurz;
	var $aktSpTag;
	var $partien;

 	function liga($name,$kurz) {
		$this->name = $name;
		$this->kurz = $kurz;
//		$this->teams = &$teams;
//		$this->partien = &$partien;
	}

	function teamCount() {

		return count($this->teams);
	}

	function addTeam(&$neuesTeam) {
		$this->teams[] = &$neuesTeam;
	}

	function addSpieltag(&$neuerSpieltag) {
		$this->spieltage[] = &$neuerSpieltag;
	}

	function spielTageCount() {

		return count($this->spieltage);
	}

	function addPartie(&$neuePartie) {
		$this->partien[] = &$neuePartie;
	}

	function partienCount() {

		return count($this->partien);
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
		return nil;
	}

	function teamNames() {
		$teamArray = array();
		foreach((array)$this->teams as $team) {
			$teamArray[] = (string)$team->name;
		}
		return $teamArray;
	}

	function showSpielplan() {

		echo "<BR>Liga = $this->name";
		foreach ($this->partien as $partie) {
			echo "<BR>".$partie->datumString()." ".$partie->heim->name ." - ".$partie->gast->name . " ";
		}
		echo "<BR>";
	}

	function showSpieltage() {

		echo "<BR>SPIELTAGE Liga = $this->name";
		foreach ($this->spieltage as $tag) {
			echo "<BR>".$tag->nr.".Spieltag  ".$tag->vonBisString()."  Anzahlspiele: ".$tag->partienCount();
			foreach ( $tag->partien as $partie) {
				echo "<BR> HEIM: ".$partie->heim->name."  GAST: ".$partie->gast->name." Zeit:$partie->zeit Uhr  Spielort:".$partie->ort;
				echo "<BR>".$partie->hTore." - ".$partie->gTore." Pkt:".$partie->hPunkte." - ".$partie->gPunkte;
			}
		}
	}

} // End Class Liga


class partie {
	var $n_SpNr,$datum,$zeit,$ort,$heim,$gast,$hTore,$gTore,$hPunkte,$gPunkte;


	function partie($n_spNr,$n_datum,$n_zeit,$n_ort,&$n_heim,&$n_gast,$n_htore,$n_gtore,$n_hpunkte,$n_gpunkte) {
		$this->spNr = $n_spNr;
		$this->datum = $n_datum;
		$this->zeit = $n_zeit;
		$this->ort = $n_ort;
		$this->heim = &$n_heim;
		$this->gast = &$n_gast;
		$n_htore > 0 ? $this->hTore = $n_htore : $this->hTore = -1;
		$n_gtore > 0 ? $this->gTore = $n_gtore : $this->gTore = -1;
		$this->hPunkte = $n_hpunkte;
		$this->gPunkte = $n_gpunkte;
	}

	function datumString() {
		return date("d.m.Y",$this->datum);
	}

	function timeString() {
		return date("H:i",$this->zeit);
	}

}

class spieltag {

	var $nr;
	var $von;
	var $bis;
	var $partien;

	function spieltag($new_nr,$new_von,$new_bis) {
		$this->nr = $new_nr;
		$this->von = $new_von;
		$this->bis = $new_bis;

	}

	function partienCount() {

		return count($this->partien);
	}

	function addPartie(&$neuePartie) {
		$this->partien[] = &$neuePartie;
	}

	function showPartien() {
		echo "<BR>Partien am Spieltag = $this->nr";
		foreach ($this->partien as $partie) {
			echo "<BR>".$partie->heim->name." - ".$partie->gast->name." Spielort:".$partie->ort;
			echo "<BR>".$partie->hTore." - ".$partie->gTore." Spielort:".$partie->ort;
		}
		echo "<BR>";
	}

	function vonBisString() {
		return date("d.m.Y",$this->von)." - ".date("d.m.Y",$this->bis);
	}

	function vonString() {
		return date("d.m.Y",$this->von);
	}

	function bisString() {
		return date("d.m.Y",$this->bis);
	}

}

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

	function valueForKey($new_key) {
		return $this->keyValues[$new_key];
	}

	function HTMLoutput() {
		echo"<BR>".$this->sektionName();
		foreach ($this->keyValues as $key=>$value) {
			echo"<BR>$key = $value";
		}
	}
}


class optionsSektion extends sektion {
	var $aLiga;
	var $keyValues = array (
            "Title"=>"LigaMaker Version 0.1",
            "Name"=>"Liganame",
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
            "dataSource"=>"Limporter ImportAddOn for LMO",
            "dataSourceUrl"=>"");


	function optionsSektion($aLiga) {
		$this->name = "Options";
		if(get_class($aLiga)=="liga") { // Wenn eine Liga angegeben wird, werden entsprechende Keys gleich initialisiert
			$this->keyValues['Name'] = $aLiga->name;
			$this->keyValues['Teams'] = $aLiga->teamCount();
			$this->keyValues['Rounds'] = $aLiga->spieltageCount();
			$this->keyValues['Actual'] = $aLiga->aktSpTag;
			// Key "Matches" bestimmen
			foreach ($aLiga->spieltage as $spieltag) {
				if ($spieltag->partienCount() > $this->keyValues['Matches'])
					$this->keyValues['Matches'] = $spieltag->partienCount();
			}
		}
	}
}

class ligafile {

	var $liga;
	var $file;
	var $sektionen;

	function ligafile($new_file,$new_liga,$new_optionsSektion) {
		$this->file = $new_file;

		if(get_class($new_liga)=="liga"){
			$this->liga = $new_liga;
			$this->buildFileContent($new_optionsSektion);
		}
		else echo"<BR><B>WARNUNG: class ligafile()</B> in <B>function ligafile() </B>Es wurde keine Liga Objekt angegeben<BR>";
	}

	function buildFileContent ($optionsSektion) {

		if(get_class($optionsSektion)!="optionssektion") {
			$optionsSektion = new optionsSektion($this->liga);
		}
		$teamSektion = new sektion("Teams");
		$teamKurzSektion = new sektion("Teamk");
		$this->addSektion($optionsSektion);
		$this->addSektion($teamSektion);
		$this->addSektion($teamKurzSektion);

		foreach($this->liga->teams as $team) {
			$teamSektion->addKeyValue($team->nr,$team->name);
			$teamKurzSektion->addKeyValue($team->nr,$team->kurz);
			$teamDetailsSektion = & new sektion("Team".($team->nr));
            $teamDetailsSektion->addKeyValue("Sp",0);
            $teamDetailsSektion->addKeyValue("URL","");
            $teamDetailsSektion->addKeyValue("NOT","");
			$this->addSektion($teamDetailsSektion);
		}

        foreach($this->liga->spieltage as $spieltag) {
            $roundSektion = & new sektion("Round".($spieltag->nr));
            $roundSektion->addKeyValue("D1",$spieltag->vonString());
            $roundSektion->addKeyValue("D2",$spieltag->bisString());
            $x=1;
            foreach ($spieltag->partien as $partie) {
                $roundSektion->addKeyValue("TA".(string)$x,$partie->heim->nr);
                $roundSektion->addKeyValue("TB".(string)$x,$partie->gast->nr);
                $roundSektion->addKeyValue("GA".(string)$x,$partie->hTore);
                $roundSektion->addKeyValue("GB".(string)$x,$partie->gTore);
                $roundSektion->addKeyValue("AT".(string)$x,$partie->zeit);
                $roundSektion->addKeyValue("NT".(string)$x,$partie->ort);

                $x++;
            }
			$this->addSektion($roundSektion);
        }
	}

	function addSektion (&$new_sektion) {
		$this->sektionen[] = &$new_sektion;
	}

	function &sektionForName($sektionName) {
		$count = Count($this->sektionen);
		$i = -1;
		$found=-1;
		$selectedSektion = null;
		while (($i<$count) and ($found<>0)):
			$i++;
			$found = strcmp($this->sektionen[$i]->name,$sektionName);
		endwhile;
		if ($found==0) return $this->sektionen[$i];
		return nil;
	}

	function fileContentHTML() {
		foreach ($this->sektionen as $sektion) $sektion->HTMLoutput();
	}


	function jsLigaTree() {
		echo "[";
		echo "['".$this->liga->name."',null,";
		$optSektion = $this->sektionForName("Options");
		echo "['Optionen',null,";
		foreach ($optSektion->keyValues as $key=>$value) {
			echo "['".$key." = ".$value."',null],";
		}
		echo"],";
		echo "['Mannschaften',null,";
		foreach ($this->liga->teams as $team) {
			echo "['".addslashes($team->name)."',null,";
			echo "['Kurzbez: ".addslashes($team->kurz)."',null],";
			echo"],";
		}
		echo"],";
		echo "['Spielplan',null,";
		foreach ($this->liga->spieltage as $spieltag) {
			echo "['".$spieltag->nr.". Spieltag vom ".$spieltag->vonBisString()."',null,";
            foreach ($spieltag->partien as $partie) {
                echo "['".addslashes($partie->heim->name)." vs. ".addslashes($partie->gast->name)."',null,";
                echo "['Datum: ".$partie->datumString()." ".$partie->timeString()." Uhr',null],";
                if($partie->hTore > -1 ) echo "['Ergebnis: ".$partie->hTore." : ".$partie->gTore."',null],";
                if(isset($partie->notiz)) echo "['Notiz: ".addslashes($partie->notiz)."',null],";
                echo"],";
            }
			echo"],";
		}
		echo"],";

		echo"],";
		echo"]";
		echo"\n"; // Der muß sein !!
	}


	function fileContent() {
		foreach ($this->sektionen as $sektion) {
			echo $sektion->sektionName()."\n";
			foreach ($sektion->keyValues as $key=>$value) {
				echo $key."=".$value."\n";
			}
		}
	}

	function writeFile() {
//		echo "<BR>FILE=".$this->file;
   		$datei = fopen($this->file,"w");
		if (!$datei) {
    		echo "<font color=\"#ff0000\">No Filename found</font>";
    	exit;
		}else{
   			 echo "<font color=\"#008800\">Writing File ".$datei."</font>";
		}
    	flock($datei,2);

		foreach ($this->sektionen as $sektion) {
			fputs($datei,$sektion->sektionName()."\n");
			foreach ($sektion->keyValues as $key=>$value) {
				fputs($datei,"$key=$value\n");
			}
		}

		flock($datei,3);
    	fclose($datei);
	}

} // End class ligafile

?>