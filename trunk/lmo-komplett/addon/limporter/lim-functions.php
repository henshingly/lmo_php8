<?PHP
//
// Limporter Functions Version 0.1
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

function colSelection($elementName,$elementValue,&$rows,$header) {
	if (!isset($elementValue)) {$elementValue=-1;}
	echo "<select class=\"lmo-formular-input\" name=\"".$elementName."\">\n";
	echo "<option value=-1";
	if($elementValue==-1){echo " selected";}
	echo ">ignorieren</option>\n";
    for ($sp = 0;$sp < count($rows);$sp++) {
        echo "<option value=$sp";
        if($elementValue==$sp){echo " selected";}
        if ($header==1 and $rows[$sp]!=""){echo ">".($rows[$sp])."</option>\n";}
        else echo ">Spalte ".($sp+1)."</option>\n"; // für die Anzeige fangen wir bei 1 an.
    }
	echo "</select>\n";

}


function formatSelection($elementName,$elementValue,$keyString,$valueString,$delimiter) {
	if (!isset($elementValue)) {$elementValue=0;}
	$values = split($delimiter,$valueString);
	$keys = split($delimiter,$keyString);
	if (count($keys) != count($values)) {
		echo "key/values ungleich!<BR>bitte Einstellungen überprüfen" ;
		echo "<input type=\"hidden\" name=\"".$elementName."\" value=0>\n";
	}
	else {
		echo "<select class=\"lmo-formular-input\" name=\"".$elementName."\">\n";
			echo "<option value=0";if($elementValue==0){echo " selected";}echo ">gesamter Zelleninhalt</option>\n";
		for ($x=1;$x<=count($keys);$x++) {
			echo "<option value=$x";if($elementValue==$x){echo " selected";}echo ">".$keys[$x-1]."</option>\n";
		}
		echo "</select>\n";
	}
}

function necho ($myString) {
	echo $myString."<BR>\n";
}

function teamKurz($teamName) {
	return substr($teamName,0,5);
}


function extractText($content) {
// extractText($content)
// Source from PHP Manual Chapter preg_replace
//
// $document should contain an HTML document.
// This will remove HTML tags, javascript sections
// and white space. It will also convert some
// common HTML entities to their text equivalent.

    $search = array ("'<script[^>]*?>.*?</script>'si",  // Strip out javascript
                     "'<[\/\!]*?[^<>]*?>'si",           // Strip out html tags
                     "'([\r\n])[\s]+'",                 // Strip out white space
                     "'&(quot|#34);'i",                 // Replace html entities
                     "'&(amp|#38);'i",
                     "'&(lt|#60);'i",
                     "'&(gt|#62);'i",
                     "'&(nbsp|#160);'i",
                     "'&(iexcl|#161);'i",
                     "'&(cent|#162);'i",
                     "'&(pound|#163);'i",
                     "'&(copy|#169);'i",
                     "'&#(\d+);'e");                    // evaluate as php

    $replace = array ("",
                      "",
                      "\\1",
                      "\"",
                      "&",
                      "<",
                      ">",
                      " ",
                      chr(161),
                      chr(162),
                      chr(163),
                      chr(169),
                      "chr(\\1)");
	$result = preg_replace ($search,$replace,$content);
	return $result;
}

function isDetailsRow($content,$newRowCheck) {
	$result = FALSE;
	$array1 = preg_split("/[ |:]/",$content);
	$array2 = preg_split("/[ |:]/",$newRowCheck);
	if (count($array1)!=count($array2)) $result = TRUE;
	return $result;
}

function buildFieldArray($url) {

// file_get_contents (PHP 4 >= 4.3.0)


if (!function_exists("file_get_contents")) {
  function file_get_contents($filename, $use_include_path = 0) {
    $data = ""; // just to be safe. Dunno, if this is really needed
    $file = @fopen($filename, "rb", $use_include_path);
    if ($file) {
      while (!feof($file)) $data .= fread($file, 1024);
      fclose($file);
    }
    return $data;
  }
}

	$rowCount =-1;
	$newRowCheck = "";
	$urlContent = file_get_contents($url);
    $arr = preg_split("/<\/t[d|h]/si",$urlContent);
    for ($i=0; $i<count($arr); $i++){
      	$content = stristr($arr[$i],"<td");
      	$trEnd = stristr($arr[$i],"<tr");

        if ($content==FALSE) {
        	$content = stristr($arr[$i],"<th");
        }
//      colspan finden
		preg_match("/.*<t[d|h].*colspan=.?(\d+).*>/i",$content,$colspan);
    	if (isset($colspan[1])) {
    		$colspanCount = $colspan[1];
		}
		else $colspanCount = 0;

        if ($content!="") {
           $pos=0;
           for ($x=0;$x<strlen($content);$x++)
                if ((!$pos)&&(substr($content,$x,1)==">")) $pos=$x;
           if ($pos) $content=substr($content,$pos+1);
           $content = trim(extractText($content));

      	// Ok neue Zeile gefunden, jetzt schauen ob es eine Folgezeile
      	// oder eine neue Partie ist

      		if ($trEnd!=FALSE and (isDetailsRow($content,$newRowCheck)==FALSE or $rowCount < 1)) {
      			$rowCount++;
				$rows[$rowCount]=$content;
				$newRowCheck = $content;
      		}
      		else {
      	   		$rows[$rowCount].="#".$content;
      	    }
		//entsprechend des gefundenen colspan zusätzliche zellen einfügen
            for ($z=1;$z<$colspanCount;$z++) {
            	if ($content!="" and $rowCount == 0 ) $rows[$rowCount].="#".$content.$z; // Nur in der erste Zeile
            	else $rows[$rowCount].="#";
            }
        }
    }
   	return $rows;
}


function buildCSVArray($url,$csvchar=";",$offset=0) {
	$handle = fopen ($url,"r");
	$rows = array();
	$row=0;
	while ($data = fgetcsv ($handle, 1000, $csvchar)) {
		if($row >= $offset) {
			$rows[] = $data;
		}
		$row++;
	}
	fclose ($handle);
	return $rows;
}


function extractV($value,$exPr) {

	$result = $value;
	if ($exPr!="0") { // Formatierung erforderlich
		preg_match($exPr,$value,$results);
		if (isset($results[1]))
			$result=trim($results[1]);
	}
	return $result;
}


function buildLigaFromCSVArray(&$liga,&$array,$header,&$cols,$fValues,$fDelimiter) {
	$lastDate = 0;
    $spTagNr = -1;
    $i=0;
    $fValues = "0".$fDelimiter.$fValues; // workarround
    $regExp = split($fDelimiter,$fValues);

	if ($header == 1) $i=1; // Sind splatentitel in der ersten csv-Zeile dann diese überspringen
	while ($i<(count($array))):
      // Heim und Gast ermitteln
      $newTeam[0] = extractV($array[$i][$cols['HEIM'][0]],$regExp[$cols['HEIM'][1]]);
      $newTeam[1] = extractV($array[$i][$cols['GAST'][0]],$regExp[$cols['GAST'][1]]);

      // Jeweils für Heim und Gast ermitteln ob schon vorhanden
      for ($x=0; $x<=1; $x++) {
          if(!in_array($newTeam[$x],$liga->teamNames())) {
              $liga->addTeam( new team($newTeam[$x],teamKurz($newTeam[$x]),$liga->teamCount()+1)); // TemKurzbez 6 Buchstaben
          }
      }
      // Unix Time für Datum und Anpfiffzeit
      $datum = split("\.|-|\/",extractV($array[$i][$cols['DATUM'][0]],$regExp[$cols['DATUM'][1]]));
      $zeit =split(":|,|\.|-",extractV($array[$i][$cols['ZEIT'][0]],$regExp[$cols['ZEIT'][1]]));
      if (count($datum)==3)
      	$spieldatum = mktime(0,0,0,(int)$datum[1],(int)$datum[0],(int)$datum[2]);
      else
      	$spieldatum = null;      

      if (count($datum)==3 and count($zeit)==2)
	      $spielzeit = mktime((int)$zeit[0],(int)$zeit[1],0,(int)$datum[1],(int)$datum[0],(int)$datum[2]);
			else
			  $spielzeit = null;
      // Partien erstellen
      $theim = extractV($array[$i][$cols['THEIM'][0]],$regExp[$cols['THEIM'][1]]);
      $tgast = extractV($array[$i][$cols['TGAST'][0]],$regExp[$cols['TGAST'][1]]);
      $nr = extractV($array[$i][$cols['NR'][0]],$regExp[$cols['NR'][1]]);
      $partie = & new partie($nr,$spieldatum,$spielzeit,"",$liga->teamForName($newTeam[0]),$liga->teamForName($newTeam[1]),$theim,$tgast,"","") ;

      $liga->addPartie($partie);

      // Spieltage erstellen
      if ($lastDate == 0 or ($partie->datum - $lastDate)/86400 > 1) {
          $spTagNr ++;
          $mySpieltag = & new spieltag($spTagNr+1,$partie->datum,$partie->datum);
          $mySpieltag->addPartie($partie);
          $liga->addSpieltag($mySpieltag);
          $liga->aktSpTag = $spTagNr; // Das stimmt noch nicht
      }
      else if (($partie->datum - $lastDate)/86400 == 0 ) {
          $mySpieltag->addPartie($partie);
      }
      else if (($partie->datum - $lastDate)/86400 == 1) {
          $mySpieltag->bis = $partie->datum;
          $mySpieltag->addPartie($partie);
      }
      $lastDate = $partie->datum;
			$i++;
	endwhile;
	return TRUE;
	}

?>