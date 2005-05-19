<?PHP
//
// Limporter Functions
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

function left ($str, $howManyCharsFromLeft)
{
  return substr ($str, 0, $howManyCharsFromLeft);
}

function right ($str, $howManyCharsFromRight)
{
  $strLen = strlen ($str);
  return substr ($str, $strLen - $howManyCharsFromRight, $strLen);
}

function necho ($myString) {
  echo $myString."<BR>\n";
}

// Funktion zum testen der ImportURL
// Handelt es sich um eine Frame Seite,
// werden die extrahiert Framelinks zurückgegeben
// mögl. Erweiterungen: z.B. meta refresh links oder javascript onLoad Events ermitteln
function getLinks ($html) {
	$links = array();
	$pattern = '/<frame\s+.*src=[\"|\'](.*)[\"|\'].*>/isU';
	preg_match_all($pattern, $html, $frames);
	if (isset($frames[1]))
		$links = $frames[1];

	return $links;
}

function phpLinkCheck($url, $r = FALSE)
{
  /*  Purpose: Check HTTP Links
   *  Usage:   $var = phpLinkCheck(absoluteURI)
   *           $var["Status-Code"] will return the HTTP status code
   *           (e.g. 200 or 404). In case of a 3xx code (redirection)
   *           $var["Location-Status-Code"] will contain the status
   *           code of the new loaction.
   *           See print_r($var) for the complete result
   *
   *  Author:  Johannes Froemter <j-f@gmx.net>
   *  Date:    2001-04-14
   *  Version: 0.1 (currently requires PHP4)
   */

  $url = trim($url);
  if (!preg_match("=://=", $url)) $url = "http://$url";
  $url = parse_url($url);
  if (strtolower($url["scheme"]) != "http") return FALSE;

  if (!isset($url["port"])) $url["port"] = 80;
  if (!isset($url["path"])) $url["path"] = "/";

  $fp = fsockopen($url["host"], $url["port"], $errno, $errstr, 30);

  if (!$fp) return FALSE;
  else
  {
    $head = "";
    $httpRequest = "HEAD ". $url["path"] ." HTTP/1.1\r\n"
                  ."Host: ". $url["host"] ."\r\n"
                  ."Connection: close\r\n\r\n";
    fputs($fp, $httpRequest);
    while(!feof($fp)) $head .= fgets($fp, 1024);
    fclose($fp);

    preg_match("=^(HTTP/\d+\.\d+) (\d{3}) ([^\r\n]*)=", $head, $matches);
    $http["Status-Line"] = $matches[0];
    $http["HTTP-Version"] = $matches[1];
    $http["Status-Code"] = $matches[2];
    $http["Reason-Phrase"] = $matches[3];

    if ($r) return $http["Status-Code"];

    $rclass = array("Informational", "Success",
                    "Redirection", "Client Error",
                    "Server Error");
    $http["Response-Class"] = $rclass[$http["Status-Code"][0] - 1];

    preg_match_all("=^(.+): ([^\r\n]*)=m", $head, $matches, PREG_SET_ORDER);
    foreach($matches as $line) $http[$line[1]] = $line[2];

    if ($http["Status-Code"][0] == 3)
      $http["Location-Status-Code"] = phpLinkCheck($http["Location"], TRUE);

    return $http;
  }
}

function buildFieldArrayDFB($url,$detailsRowCheck = 0) {

  function skipRow($rowContent) {
    $result = TRUE;
    if($rowContent=="") $result = TRUE;
    elseif(preg_match("/^\d\d\d/",$rowContent)) $result = FALSE; // reihe enthält spielpaarung
    return $result;
  }

  function buildFieldArrayRekursion($url, $rowCount, $newRowCheck, $rows, &$mannschaften) {

    $urlContent = getFileContent($url);

    //Spieltags-Nr. suchen, bei Spieltagen mit nur verlegten Spielen gibt es keine
    if (preg_match("/<OPTION SELECTED VALUE.{40,65}\d+\. Spieltag/",$urlContent,$ergebnis)) {
       preg_match("/\d{1,3}\. Spieltag/", $ergebnis[0], $ergebnis);
       preg_match("/\d{1,3}/", $ergebnis[0], $ergebnis);
       $spieltagsnr = $ergebnis[0];
    } else $spieltagsnr = "?&?!";

    //Link auf den nächsten Spieltag suchen
    if (preg_match("/dbc.{60,100}n.chster/", $urlContent, $ergebnis)) {
      preg_match("/dbc.+,1/", $ergebnis[0], $neue_url_temp);
      $temp = explode('/', $neue_url_temp[0]);
      $temp2 = explode(',', $temp[10]);
      if ($temp2[0] == $temp2[1]) $neue_url=''; //letzter Spieltag erreicht
      else $neue_url="http://fussball.sport1.de/".$neue_url_temp[0];
    } else {
       echo "<font color=\"red\"><b>Fehler</b>: Konnte Link zum nächsten Spieltag nicht finden. Korrekte URL angegeben?</font>";
       exit;
    }

    $arr = preg_split("/<\/t[d|h]/si",$urlContent);

    for ($i=0; $i<count($arr); $i++){
      $content = stristr($arr[$i],"<td");
      $trEnd = stristr($arr[$i],"<tr");

      if ($content==FALSE) {
        $content = stristr($arr[$i],"<th");
      }
      // colspan finden
      preg_match("/.*<t[d|h].*colspan=.?(\d+).*>/i",$content,$colspan);
      if (isset($colspan[1])) {
        $colspanCount = $colspan[1];
      }
      else {
        $colspanCount = 0;
      }

      if ($content!="") {
         $pos=0;
         for ($x=0;$x<strlen($content);$x++)
              if ((!$pos)&&(substr($content,$x,1)==">")) $pos=$x;
         if ($pos) $content=substr($content,$pos+1);
         $content = trim(extractText($content));

        if (preg_match("/\d\d\.\d\d\.\d\d\d\d/",$content,$ergebnis)) $spieldatum  = $ergebnis[0]; //sucht das spieldatum

        if (preg_match("/\d+:\d+/",$content,$ergebnis)) $content  = $ergebnis[0]; //löscht das * hinter dem ergebnis


        // Ok neue Zeile gefunden, jetzt schauen ob es eine Folgezeile
        // oder eine neue Partie ist

         if ($trEnd!=FALSE and ($detailsRowCheck == 0 or isDetailsRow($content,$newRowCheck)==FALSE or $rowCount < 1)) {
             // Wenn die aktuelle Zeile komplett leer ist,dh nur # enthält,
             // dann wird sie mit neuen Daten überschrieben
             if ($rowCount < 0 or skipRow($rows[$rowCount])==FALSE) {
             //Mannschaften zählen
             $zeile = split('#', $rows[$rowCount]);
             if (!in_array($zeile[3], $mannschaften)) //wenn mannschaftsname noch nicht vorgekommen ist
               if ($mannschaften[0]=='') $mannschaften[0]=$zeile[3];
               else array_push($mannschaften, $zeile[3]);
             if (!in_array($zeile[4], $mannschaften)) //Auswärts muss auch überprüft werden. "Spielfrei" ist z.B. eine reine Auswärtsmannschaft
               if ($mannschaften[0]=='') $mannschaften[0]=$zeile[4];
               else array_push($mannschaften, $zeile[4]);
             $rowCount++;
            }
            $rows[$rowCount]=$content."#$spieldatum#$spieltagsnr";
            if ($content != "")
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

    if ($neue_url != "") { //solange letzter Spieltag noch nicht erreicht
      $rows = buildFieldArrayRekursion($neue_url, $rowCount, $newRowCheck, $rows, $mannschaften); //nächsten Spieltag aufrufen
    }

    return $rows;
  }

  $mannschaften = array();
  $rows=buildFieldArrayRekursion($url, -1, "", array(), $mannschaften);
  //print_r($rows);
  array_pop($rows); //Aus einem mir nicht ganz klaren Grund enthält der letzte Key des Arrays "Datenmüll". Der wird hiermit gelöscht.

  //Jetzt werden den verlegten Spielen die richtigen Spieltagsnummer zugewiesen. Wird über Spielnr. gemacht.

  $anz_mannschaften = count($mannschaften);
  if ($anz_mannschaften % 2 != 0) echo "<font color=\"red\">Fehler! Ungerade Anzahl von Mannschaften. Spieltagszuordnung kann durcheinander geraten.</font><br>\n";

  //Welche Spielnummern gehören zu welchem Spieltag?
  //print_r($rows);
  //Die bekannten Spielnummern dem Spieltag zuordnen
  for ($i=0; $i<count($rows); $i++) {
    $zeile = split('#', $rows[$i]);
    $zeile[0] = preg_replace("/^0{1,2}/",'',$zeile[0]);  //führende Spieltags-Nullen entfernen
    if ($zeile[2]!='?&?!') {
      $spielnr = $zeile[0];
      //echo $zeile[0].$spielnr."\n";
      $spieltagnr = $zeile[2];
      //echo $spieltagnr."\n";
      $spieltage[$spielnr] = $spieltagnr;
      //Spielnr./Tag-Zuordnung für die vorhergehenden Spielnr. ebenfalls eintragen
      for ($k=$spielnr-1; (($k>$spielnr-($anz_mannschaften/2)) and ($k>=0)); $k--) {
         //echo "k: $k\n"; echo "spielnr: $spielnr\n"; echo ($k / ($anz_mannschaften / 2))."\n"; echo ($spielnr / ($anz_mannschaften / 2))."\n\n";
         if (ceil($k / ($anz_mannschaften / 2)) == ceil($spielnr / ($anz_mannschaften / 2))) {
            $spieltage[$k] = $spieltage[$spielnr];
         }
      }
      //Für die nachfolgenden Spiele ebenfalls
      for ($k=$spielnr+1; (($k < $spielnr+($anz_mannschaften/2)) and ($k<=count($rows))); $k++) {
         //echo "k: $k\n"; echo "spielnr: $spielnr\n"; echo ceil($k / ($anz_mannschaften / 2))."\n"; echo ceil(($spielnr / ($anz_mannschaften / 2)))."\n\n";
         if (ceil($k / ($anz_mannschaften / 2)) == ceil($spielnr / ($anz_mannschaften / 2))) {
            $spieltage[$k] = $spieltage[$spielnr];
         }
      }
    }
  }

  //Den unbekannten Spielen die Spieltagnr zuweisen und neuen Array erstellen
  $rows_bereinigt = array();
  for ($i=0; $i<count($rows); $i++) {
    $zeile = split('#', $rows[$i]);
    $zeile[0] = preg_replace("/^0{1,2}/",'',$zeile[0]);  //führende Spieltags-Nullen entfernen
    if (($zeile[2]=='?&?!') && ($zeile[6]=='')) { //zeile[6]!='', wenn Spiel ein Verlegungsdatum eingetragen hat
       $zeile[2]=$spieltage[$zeile[0]];
       //Stellt den Spieltag an den Anfang
       $temp = $zeile[0];
       $zeile[0] = $zeile[2];
       $zeile[2] = $temp;
       $neue_zeile = implode('#',$zeile);
       array_push($rows_bereinigt, $neue_zeile);
    } else if ($zeile[6]=='') { //bei Spielen ohne Verlegungsdatum
       //Stellt den Spieltag an den Anfang
       $temp = $zeile[0];
       $zeile[0] = $zeile[2];
       $zeile[2] = $temp;
       $neue_zeile = implode('#',$zeile);
       array_push($rows_bereinigt, $neue_zeile);
    }
  }

  //Sortierung des Arrays nach dem Spieltag. Ist nötig, weil der Limporter ansonsten nicht richtig importiert
  natsort($rows_bereinigt);


  //Die unbekannten Spiele einem Spieltag zuordnen
  /*for ($i=0; $i<count($rows); $i++) {
    $zeile = split('#', $rows[$i]);
    if ($zeile[1]=='?&?!') {
      $spielnr = $zeile[0];
      if (ceil(($spielnr-1) / $anz_mannschaften / 2) == ceil(($spielnr) / $anz_mannschaften / 2)) {
         $zeile2 = split('#', $rows[$i-1]);
        $spieltage[$spielnr] = $zeile2[1];
      } else

    $max_spieltage = ($anz_mannschaften - 1)*2;
    for (
}  */

  //print_r($spieltage);
  //print_r($rows_bereinigt);
  //print_r($mannschaften);
  //print  $anzahl_mannschaften;
  //Jetzt müssen die verlegten Spiele korrigiert werden
  /*$verlegungen = array();
  $rows_bereinigt = array();
  //Suche dafür alle Spiele, die ein Verlegungsdatum haben
  for ($i=0; $i<count($rows); $i++) {
    if (preg_match("/[^#]#$/", $rows[$i], $ergebnis)) { //verlegte Spiele haben genau ein # am Ende des Datensatzes
      //extrahiere Spiel-Nr. und Spieltags-Nr.
      $ergebnis = split('#', $rows[$i]);
      $verlegungen[$ergebnis[0]] = $ergebnis[2]; //verlegungen[i]=k: i: Spiel-Nr, k: Spieltags-Nr.
    } else array_push($rows_bereinigt, $rows[$i]);
  }
  //Nun müssen den verlegten Spielen die ursprünglichen Spieltags-Nr. wieder hinzugefügt werden
    $spiele_ohne_datum = 0;  //<- noch nicht verö.
  for ($i=0; $i<count($rows_bereinigt); $i++) {
    if (strpos($rows_bereinigt[$i], '?&?!')) {
      $ergebnis = split('#', $rows_bereinigt[$i]);
      //**noch nicht veröffentlichte Änderung start
      if ($verlegungen[$ergebnis[0]] == '') {
        $ergebnis[2] = 1;
        $spiele_ohne_datum++;
      } else
        $ergebnis[2] = $verlegungen[$ergebnis[0]];
      //**noch nicht veröffentlichte Änderung ende
      $rows_bereinigt[$i] = implode('#', $ergebnis);
    }
  }
  if ($spiele_ohne_datum > 0) echo "Zu $spiele_ohne_datum Spiel(en) konnte kein Spieltag gefunden werden.<br>Die Spiele wurden dem 1. Spieltag zugewiesen (außer Sie haben \"Aktualisieren\" gewählt).<br>Bitte manuell korrigieren."; //<- noch nicht verö.*/

  return $rows_bereinigt;
}

function teamKurz($teamName) {
  return substr($teamName,0,5);
}

function colSelection($elementName,$elementValue,&$rows,$header) {
  if (!isset($elementValue)) {$elementValue=-1;}
  echo "<select class=\"lmo-formular-input\" name=\"".$elementName."\">\n";
  echo "<option value=-1";
  if($elementValue==-1){echo " selected";}
  if($elementName=="cols[NR][0]")
    echo ">automatisch</option>\n";
  else
    echo ">ignorieren</option>\n";
    for ($sp = 0;$sp < count($rows);$sp++) {
        echo "<option value=$sp";
        if($elementValue==$sp){echo " selected";}
        if ($header==1 and $rows[$sp]!=""){echo ">".($rows[$sp])."</option>\n";}
        else echo ">Spalte ".($sp+1)."</option>\n"; // für die Anzeige fangen wir bei 1 an.
    }
  echo "</select>\n";

}


function formatSelection($elementName,$elementValue,$formatArray) {
  if (!isset($elementValue)) {$elementValue=0;}
  $values = array_values($formatArray);
  $keys = array_keys($formatArray);
  echo "<select class=\"lmo-formular-input\" name=\"".$elementName."\">\n";
    echo "<option value=0";if($elementValue==0){echo " selected";}echo ">gesamter Zelleninhalt</option>\n";
  for ($x=1;$x<=count($keys);$x++) {
    echo "<option value=$x";if($elementValue==$x){echo " selected";}echo ">".$keys[$x-1]."</option>\n";
  }
  echo "</select>\n";
}


function getParserFiles($dirPath,$importTyp,$noSelectionString='') {
  $settingNamesArray = array();
  $dir = opendir($dirPath);
  if ($importTyp==1) $matchTyp='csv';
  else $matchTyp='html';
  while($files=readdir($dir)){
    if(strtolower(substr($files,-4))==".lim") {
      $datei = $dirPath."/".$files;
      $ini = new IniFileReader($datei);
      if (strtolower($ini->getIniFile('LIMPORTER','IMPORTTYP','')) == $matchTyp) {
        $def = substr($files,0,35);
        $name = $ini->getIniFile('LIMPORTER','TITLE',$def);
        if (($art=$ini->getIniFile('LIMPORTER','ART',0))<>0) {
          $settingNamesArray[]=array($name.' ('.$files.')',$files,1);
        }
        else {
          $settingNamesArray[]=array($name.' ('.$files.')',$files,-1);
        }
      }
    }
  }
  if (count($settingNamesArray)>0) {
    $sepArray = array(array(str_repeat("-",20),' ',0));
    $settingNamesArray = array_merge(array(array($noSelectionString,null,-2)),$sepArray,$settingNamesArray);
  }
  else {
    $settingNamesArray = array(array($noSelectionString,null,-2));
  }

  foreach ($settingNamesArray as $key => $row) {
    $sort1[$key] = $row[2];
    $sort2[$key] = $row[0];
  }
  array_multisort($sort1, SORT_DESC,$sort2, SORT_ASC, $settingNamesArray);
return $settingNamesArray;
}

function settingsLink($settings) {
	$link = '';
	foreach ($settings as $key=>$value) {
		$link .= '&c_'.$key.'='.$value[0]."_".$value[1];  // 0 Spaltennummer 1 Formatierung
	}
	return $link;
}

function treeStrukt ($liga) {
  $s = "";
   $s .= "['".$liga->name."',null,";
  $optionen = $liga->options->keyValues;
  $s .= "['Optionen',null,";
  foreach ($optionen as $key=>$value) {
    $s .= "['".$key." = ".$value."',null],";
  }
  $s .= "],";
  $s .= "['Mannschaften',null,";
  foreach ($liga->teams as $team) {
    $s .= "['".addslashes($team->name)."',null,";
    $s .= "['Kurzbez: ".addslashes($team->kurz)."',null],";
    foreach ($team->keyValues as $key=>$value) {
      $s .= "['".$key.": ".addslashes($value)."',null],";
    }
    $s .= "],";
  }
  $s .= "],";
  $s .= "['Spieltage',null,";
  foreach ($liga->spieltage as $spieltag) {
    if ($spieltag->vonBisString() != "") {
      $s .= "['".$spieltag->nr.". Spieltag vom ".$spieltag->vonBisString();
    }
     else {
      $s .= "['".$spieltag->nr.". Spieltag";
     }

      $s .= "','lmo.php?file=".$liga->fileName."&st=".$spieltag->nr."',";
    foreach ($spieltag->partien as $partie) {
      $s .= "['".addslashes($partie->heim->name)." vs. ".addslashes($partie->gast->name)."',null,";
      $s .= "['Datum: ".$partie->datumString()." ".$partie->zeitString()." Uhr',null],";
      if($partie->hTore > -1 ) $s .= "['Ergebnis: ".$partie->hTore." : ".$partie->gTore."',null],";
      if(isset($partie->notiz)) $s .= "['Notiz: ".addslashes($partie->notiz)."',null],";
      $s .= "],";
    }
    $s .= "],";
  }
  $s .= "],]";
  return $s;
}

function jsLigaTree($liga) {
  $s = "[".treeStrukt($liga).",]";
  return $s;
}

function jsLigenTree($ligen,$treeName="") {
    if(!isset($treeName) or $treeName=="" )
      $treeName = "Sportligen";
    $s = "[['".$treeName."',null,";
    foreach($ligen as $liga) {
      $s .= treeStrukt($liga).",";
    }
    $s .= "],]";

return $s;
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
// Unicode der umlaute Ã–
                     "'Ã¼'",
                     "'Ã¤'",
                     "'Ã¶'",
                     "'ÃŸ'",
                     "'Ã–'",
                     "'Ãœ'",
                     "'&#(\d+);'e");                    // evaluate as php
// white space komplett entfernen !! "\\1"
    $replace = array ("",
                      "",
                      "",
                      "\"",
                      "&",
                      "<",
                      ">",
                      " ",
                      chr(161),
                      chr(162),
                      chr(163),
                      chr(169),
                      "ü",
                      "ä",
                      "ö",
                      "ß",
                      "Ö",
                      "Ü",
                      "chr(\\1)");
  $result = preg_replace ($search,$replace,$content);
  return $result;
}


function getFileContent($filename, $use_include_path = 0) {
  // function file_get_contents gibts erst ab PHP V. 4.3.0
  // wenns die also nicht gibt, bauen wir die selber
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
  return file_get_contents($filename);
}

function buildFieldArray($url,$detailsRowCheck = 0) {

  function isDetailsRow($content,$newRowCheck) {
  $debug = 0;
  $result = FALSE;
  $ergeb1 = "";
  $ergeb2 = "";

  if ($debug == 1) echo "<BR>[$content][$newRowCheck]";

  if ($content=="" or $newRowCheck=="") $result = TRUE;
  else {
    $array1 = preg_split("/[ |:]/",$content);
    $array2 = preg_split("/[ |:]/",$newRowCheck);

    if(isset($array1[0]))
      $ergeb1 = $array1[0];

    if(isset($array2[0]))
      $ergeb2 = $array2[0];

    if (count($array1)!=count($array2)) $result = TRUE;
    else if (strlen($ergeb1) != strlen($ergeb2)) $result = TRUE;
  }

  return $result;
  }

  function skipRow($rowContent) {
    $result = TRUE;
    if($rowContent=="") $result = TRUE;
    elseif(preg_match("/.*[^#]/",$rowContent)) $result = FALSE; // reihe enthält daten
  return $result;
  }

  $rowCount =-1;
  $newRowCheck = "";
  $rows = array();
  $urlContent = getFileContent($url);
  $arr = preg_split("/<\/t[d|h]/si",$urlContent);
  for ($i=0; $i<count($arr); $i++){
    $content = stristr($arr[$i],"<td");
    $trEnd = stristr($arr[$i],"<tr");

    if ($content==FALSE) {
      $content = stristr($arr[$i],"<th");
    }
    // colspan finden
    preg_match("/.*<t[d|h].*colspan=.?(\d+).*>/i",$content,$colspan);
    if (isset($colspan[1])) {
      $colspanCount = $colspan[1];
    }
    else {
      $colspanCount = 0;
    }

    if ($content!="") {
       $pos=0;
       for ($x=0;$x<strlen($content);$x++)
            if ((!$pos)&&(substr($content,$x,1)==">")) $pos=$x;
       if ($pos) $content=substr($content,$pos+1);
       $content = trim(extractText($content));

      // Ok neue Zeile gefunden, jetzt schauen ob es eine Folgezeile
      // oder eine neue Partie ist

       if ($trEnd!=FALSE and ($detailsRowCheck == 0 or isDetailsRow($content,$newRowCheck)==FALSE or $rowCount < 1)) {
           // Wenn die aktuelle Zeile komplett leer ist,dh nur # enthält,
           // dann wird sie mit neuen Daten überschrieben
           if ($rowCount < 0 or skipRow($rows[$rowCount])==FALSE) {
            $rowCount++;
          }
          $rows[$rowCount]=$content;
          if ($content != "")
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


function extractValue(&$regExp,&$array,&$cols,$colKey,$defaultValue=null) {
  $val_index = $cols[$colKey][0];// Spaltennummer des Attributs (ignorieren = -1)
  $exp_index = $cols[$colKey][1];
  $value = $defaultValue;
  $exPr = $regExp[$exp_index];
  if($val_index > -1) { // ok Colum wurde ausgewählt
    // New isset($array[$val_index])
    if(isset($array[$val_index])and $exPr!="0") { // Formatierung erforderlich
      $value = trim($array[$val_index]);
      $value = trim($value,"\x7f..\xff\x0..\x1f"); //trim any nongraphical non-ASCII character:
      preg_match($exPr,$value,$results);
      if (isset($results[1]))
        $value=trim($results[1]);
      else { // kein match also default verwenden
        $value = $defaultValue;
      }
    }
    // Formatierung nicht erforderlich (ganze Zelle wenn nicht leer)
    elseif (isset($array[$val_index]) and $array[$val_index] != "") {
    // New isset($array[$val_index])
      $value = trim($array[$val_index]);
      $value = trim($value,"\x7f..\xff\x0..\x1f"); //trim any nongraphical non-ASCII character:
      }
  }
  else {
    $value = $defaultValue;
  }
  return $value;
}


function buildLigaFromDataArray(&$liga,&$array,$header,&$cols,&$formatArray) {
  $i=0;
  $spTagNr = 0; // Der erste Spieltag ist 1
  $aktSpTag = 1;
  $regExp = array_merge( array('0'),array_values($formatArray));
  setLocale (LC_TIME,"ge");

  // Wurde eine Spalte für Spieltage selektiert, werden diese nicht automatisch erzeugt
  $autoRounds = !(isset($cols['NR'][0]) and $cols['NR'][0] > -1);
  $calcRounds = (isset($cols['SPNR'][0]) and $cols['SPNR'][0] > -1);

  if ($header == 1) $i=1; // Sind spaltentitel in der ersten Zeile dann diese überspringen
  // Anzahl Teams bestimmen
  $tempArray = array();
  $newArray = array();
  while ($i<(count($array))):
    // Sortierung vorbereiten
    $newArray[]=$array[$i];
    $spnrArray[]= extractValue($regExp,$array[$i],$cols,'SPNR',"0");
    $stnrArray[]= extractValue($regExp,$array[$i],$cols,'NR',"0");
    $datumArray[]= extractValue($regExp,$array[$i],$cols,'DATUM',"0");
    $zeitArray[]= extractValue($regExp,$array[$i],$cols,'ZEIT',"0");
    $newTeam[0] = extractValue($regExp,$array[$i],$cols,'HEIM',"TEAMNAME");
    $newTeam[1] = extractValue($regExp,$array[$i],$cols,'GAST',"TEAMNAME");
    // Jeweils für Heim und Gast ermitteln ob schon vorhanden
    for ($x=0; $x<=1; $x++) {
      if(!in_array($newTeam[$x],$tempArray)) {
          $tempArray[] = $newTeam[$x];
      }
    }
    $i++;
  endwhile;
  array_multisort($spnrArray, SORT_ASC, $stnrArray, SORT_ASC,
                                 $datumArray, SORT_ASC,$zeitArray, SORT_ASC,$newArray);


  $array = &$newArray;
  $header = 0; // Spaltentitel wurde ja rausgeschmissen;
  $spCount = (int)(count($tempArray)/2);

  if ($header == 1) $i=1; else $i=0; // Sind spaltentitel in der ersten Zeile dann diese überspringen
  while ($i<(count($array))):
    // Heim und Gast ermitteln
    $newTeam[0] = extractValue($regExp,$array[$i],$cols,'HEIM',"TEAMNAME");
    $newTeam[1] = extractValue($regExp,$array[$i],$cols,'GAST',"TEAMNAME");

    // Jeweils für Heim und Gast ermitteln ob schon vorhanden
    for ($x=0; $x<=1; $x++) {
      if(!in_array($newTeam[$x],$liga->teamNames())) {
        $liga->addTeam(new team($newTeam[$x],teamKurz($newTeam[$x]),$liga->teamCount()+1));
      }
    }
    $isUnixDate=TRUE;
    // Unix Time für Datum und Anpfiffzeit
    $datum = split("\.|-|\/",extractValue($regExp,$array[$i],$cols,'DATUM',''));//"01.01.2001"
    // Hier sollte noch die LMO Standardzeit eingetragen werden
    $zeit =split(":|,|\.|-",extractValue($regExp,$array[$i],$cols,'ZEIT',''));//"12:00"

    if(count($datum)!=3) {
      $isUnixDate = FALSE;
      $spieldatum = '';
    }
    else {
      $spieldatum = mktime(0,0,0,(int)$datum[1],(int)$datum[0],(int)$datum[2]);
    }

    if((count($zeit)!=2 and count($datum)!=3) or (count($zeit)==2 and count($datum)!=3)) { // or
      $isUnixDate = FALSE;
      $spielzeit = '';
    }
    else if(count($zeit)!=2 and count($datum)==3) { // Wenn keine Zeit angegeben standardzeit verwenden
      $zeit = preg_split('/:/','15:00');//$deftime
      $spielzeit = mktime((int)$zeit[0],(int)$zeit[1],0,
               (int)$datum[1],(int)$datum[0],(int)$datum[2]);
    }
    else {
      $spielzeit = mktime((int)$zeit[0],(int)$zeit[1],0,
               (int)$datum[1],(int)$datum[0],(int)$datum[2]);
    }

    $theim = extractValue($regExp,$array[$i],$cols,'THEIM',-1);
    $tgast = extractValue($regExp,$array[$i],$cols,'TGAST',-1);
    $pheim = extractValue($regExp,$array[$i],$cols,'PHEIM');
    $pgast = extractValue($regExp,$array[$i],$cols,'PGAST');
    $nr = extractValue($regExp,$array[$i],$cols,'NR');
    $notiz = extractValue($regExp,$array[$i],$cols,'NOTIZ');
    if ($theim < 0 or $tgast < 0) {
        $theim = -1;
        $tgast = -1;
    }
    // Spielwertung für Ergebnis 0:0 ermitteln
    elseif($theim == 0 and $tgast == 0) {
        if($pheim > 0 and $pgast == 0) {$theim = -2;}
        if($pheim == 0 and $pgast > 0) {$tgast = -2;}
        if($pheim == 0 and $pgast == 0) {
          $theim = -1;
          $tgast = -1;
        }
    }
    // Partien erstellen
    $partie = & new partie($nr,$spielzeit,$notiz,$liga->teamForName($newTeam[0]),
                    $liga->teamForName($newTeam[1]),$theim,$tgast,"","");

  if ($autoRounds==FALSE) { // Spieltage anhand der Spalte mit Spieltagen erstellen
    if(isset($liga->spieltage[$nr-1])) {
      $liga->spieltage[$nr-1]->partien[]=$partie;
    }
    else {
      $mySpieltag = & new spieltag($nr,NULL,NULL);//$spieldatum,$spieldatum
      $mySpieltag->partien[]=$partie;
      $liga->spieltage[]=&$mySpieltag;
    }
    $liga->partien[] = &$partie; // Wird zusätzlich angelegt um direkt alle Partien zu erhalten
  }

	else if ($calcRounds==TRUE) { //  Spieltage berechnen: Partien je Spieltag = (int) teamanzahl / 2
    if(isset($mySpieltag) and $mySpieltag->partienCount()<$spCount) {
      $mySpieltag->partien[]=$partie;
    }
    else {
      $mySpieltag = & new spieltag($nr,NULL,NULL); //$spieldatum,$spieldatum
      $mySpieltag->partien[]=$partie;
      $liga->spieltage[]=&$mySpieltag;
    }
    $liga->partien[] = &$partie; // Wird zusätzlich angelegt um direkt alle Partien zu erhalten
	}
  else {   // Spieltage anhand des Datums automatisch erstellen
      if(!isset($lastDate))
          $dayDiv = 356; // Zum Start auf jeden Fall spieltag anlegen
      elseif ($isUnixDate==TRUE) {
        $dayDiv = (abs($spieldatum - $lastDate)/86400); // (int)
      }
      else {
        $dayDiv = 1; // es konnte kein Datum ermittelt werden also keinen neuen Spieltag
      }
      // Partien an aufeinanderfolgenden Tagen ergeben einen Spieltag
      if ($dayDiv < 2) {
        $mySpieltag->bis = $spieldatum;
        $mySpieltag->partien[] = $partie;
      }
      else { // ok Neuen Spieltag erstellen
        $spTagNr ++;
        $mySpieltag = & new spieltag($spTagNr,$spieldatum,$spieldatum);
        $mySpieltag->partien[] = $partie;
        $liga->spieltage[] = &$mySpieltag;
      }
      $liga->partien[] = &$partie; // Wird zusätzlich angelegt um direkt alle Partien zu erhalten
    }

    if($theim + $tgast > -1) { // aktueller Spieltag muss min. ein Ergebnis enthalten
        $aktSpTag = $spTagNr;
    }
    $lastDate = $spieldatum;
    $i++;
  endwhile;

// Das muss noch verbessert werden, sonst wird bei einem vorgezogenen Spiel bereits der
// aktuelle Spieltag verändert
  $liga->aktSpTag = $aktSpTag;
return TRUE;
}

function editRounds(&$aLiga) {

    echo"<p align='center' style='font-family:Verdana,arial,helvetica;font-size:10pt'>\n";
    echo"<table border= '0' cellspacing='0' align='center'>\n";
    foreach ($aLiga->spieltage as $spTag) {
        echo"<tr><td colspan=9 style='font-size=10pt;background-color=#EEEEEE;border-top-style:solid;border-bottom-style:solid;border-width:1px;border-color:#000000';><strong>".$spTag->nr.". Spieltag - ".$spTag->vonBisString()."</strong></td></tr>\n";
        $pcount = 1;
        foreach ($spTag->partien as $partie) {
            $hTore = $partie->hTore;
            $gTore = $partie->gTore;
            if($hTore == -1 and $gTore == -1) {
      $hTore = "__";
      $gTore = "__";
            }

    echo"<tr><td style='font-size=10pt;'>".$partie->datumString()." ".$partie->zeitString()."</td><td style='font-size=10pt;'>".$partie->heim->name."</td><td>-</td>";
    echo"<td style='font-size=10pt;'>".$partie->gast->name."</td><td align='right' style='font-size=10pt;'>".$hTore."</td><td style='font-size=10pt;'>:</td>";
    echo"<td align='center' style='font-size=10pt;'>".$gTore."</td><td style='font-size=10pt;'></td>\n";

    echo "<td><select class=\"lmoadminein\" name=\"sp_".$spTag->nr."_".$pcount."\">\n";
    for ($sp = 1;$sp <= $aLiga->spieltageCount();$sp++) {
      echo "<option value=$sp";
      if($spTag->nr==$sp){echo " selected";}
      echo ">".$sp.".Spieltag</option>";
    }
    echo "</select></td>\n";
    echo"</tr>\n";
    $pcount++;
        }
    }
    echo"</table></p>\n";
}

function writeLimSettings($fileName,$settings,$message=0) {
//echo "FILE=$fileName";
  $datei = fopen($fileName,"w");
  if (!$datei) {
    echo "<font color=\"#ff0000\">Can't open File (function writeLimSettings($fileName) )</font>";
    exit;
  }else if ($datei and $message==1){
    echo "<font color=\"#008800\">Writing File $fileName (".$datei.")</font>";
  }
  flock($datei,2);
  fputs($datei,"[".$settings->name."]\n");
  foreach($settings->keyValues as $key=>$value) {
    fputs($datei,"$key=$value\n");
  }
  flock($datei,3);
  fclose($datei);
}



?>