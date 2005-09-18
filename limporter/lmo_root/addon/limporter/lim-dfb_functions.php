<?php
/**
 * Importiert Ligen von fussball.de zur Weiterverarbeitung im Limporter
 * 
 * Diese Funktion muss mit dem Link zum ersten Spieltag der Liga, die man
 * importieren möchte, aufgerufen werden. Die weiteren Spieltage werden
 * vom Script aufgerufen, indem der Link "nächster" gesucht wird. Über den Link
 * "x. Spieltag" könnten ansonsten verlegte Spiele übersprungen werden.
 * Die Funktion liefert ein Array mit den Spieltagsdaten zurück, wie es vom
 * Limporter erwartet wird.
 * 
 * DIESE FUNKTION DARF NICHT FÜR KOMMERZIELLE ZWECKE BENUTZT WERDEN!
 * 
 * @param string $url Link zum ersten Spieltag der Liga
 * @param string $mode Wenn 'update', dann werden keine Warnungen ausgegeben
 * @return array Array zur Weiterverarbeitung im Limporter
 * @author Lars Dürkop
 * @version $Id$
 */

function buildFieldArrayDFB($url,$detailsRowCheck = 0, $mode) {
  global $text;

  function skipRow($rowContent) {
    $result = TRUE;
    if($rowContent=="") $result = TRUE;
    elseif(preg_match("/^\d\d\d/",$rowContent)) $result = FALSE; // reihe enthält spielpaarung
    return $result;
  }

  //Die direkten Spieltags-Links bestimmen //->nicht besuchte Spieltage bestimmen ->diese extra aufrufen und Spieltagsnummern setzen
  $urlContent = getFileContent($url);
  preg_match("/<OPTION VALUE=\"null\">.+OPTION> /", $urlContent,$ergebnis);
  preg_match_all("/<OPTION .{0,9}VALUE=\"\/dbc.{40,70}OPTION>/", $ergebnis[0], $ergebnis);
  for ($i=0; $i<count($ergebnis[0]); $i++) {
    //Link extrahieren
    preg_match("/\/.*,\d{1,3}/", $ergebnis[0][$i], $temp);
    $linkZumSpieltag[$i+1] = "http://fussball.sport1.de".$temp[0];
    $spieltagBesucht[$i+1] = FALSE;
  }
  unset($urlContent);
  
  function buildFieldArrayRekursion($url, $rowCount, $newRowCheck, $rows, &$mannschaften, &$linkZumSpieltag, &$spieltagBesucht, &$spieltagHatSpiele, $durchlauf, $anzAufrufSelberSpieltag, $fehlerhafteURLs, $mode) {
    global $text;
    global $detailsRowCheck;
    $urlContent = getFileContent($url);

    //Spieltags-Nr. suchen, bei Spieltagen mit nur verlegten Spielen gibt es keine
    if (preg_match("/<OPTION SELECTED VALUE.{40,65}\d+\. Spieltag/",$urlContent,$ergebnis)) {
       preg_match("/\d{1,3}\. Spieltag/", $ergebnis[0], $ergebnis);
       preg_match("/\d{1,3}/", $ergebnis[0], $ergebnis);
       $spieltagsnr = $ergebnis[0];
       $spieltagBesucht[$ergebnis[0]] = TRUE;
       $spieltagHatSpiele[$ergebnis[0]] = FALSE; //Init. Wird auf TRUE gesetzt, wenn dem Spieltag ein Spiel zugewiesen wurde
    } else $spieltagsnr = "?&?!";

    //Link auf den nächsten Spieltag suchen
    if (($durchlauf == TRUE) && ($anzAufrufSelberSpieltag < 4)) { //entweder ist das Script schon beim expliziten Spieltagsaufruf oder es wurde 4mal hintereinander derselbe Spieltag aufgerufen (passiert bei Saisonende oder bei Fehler beim 'nächster'-Durchlauf)
      if (//preg_match("/dbc.{60,100}n.chster/", $urlContent, $ergebnis) == 1 ||
          //preg_match("/dbc.{30,45}\/beg\/[0-9]+,[0-9]+,[0-9]+,1'/", $urlContent, $ergebnis) == 1)
          preg_match("/[0-9]{1,2}\/.{20,45}\/beg\/[0-9]+,[0-9]+,[0-9]+,1'/", $urlContent, $ergebnis) == 1) { //'nächster'-Link extrahieren. Dabei beide Varianten ausprobieren, die fussball.de bereits genutzt hat.
        //preg_match("/dbc.+,1/", $ergebnis[0], $neue_url_temp);
        preg_match("/[0-9]{1,2}\/.{20,45}\/beg\/[0-9]+,[0-9]+,[0-9]+,1/", $ergebnis[0], $ergebnis);
	$neue_url_temp = array();
	$neue_url_temp[0]="dbc/".$ergebnis[0];
	$neue_url="http://fussball.sport1.de/".$neue_url_temp[0];
	//Bestimmt das Datum aus der neuen URL
	$temp = explode('/', $neue_url_temp[0]);
        $temp2 = explode(',', $temp[10]);
        $neue_url_datum = $temp2[2];
        //echo "$neue_url_datum<br>";
        $neue_url_datum = mktime(0,0,0,$neue_url_datum[4].$neue_url_datum[5],$neue_url_datum[6].$neue_url_datum[7],$neue_url_datum[0].$neue_url_datum[1].$neue_url_datum[2].$neue_url_datum[3]);
        
	//Bestimmt das Datum aus der alten URL
	preg_match("/dbc.+,1/", $url, $neue_url_temp);
        $temp = explode('/', $neue_url_temp[0]);
        $temp2 = explode(',', $temp[10]);
        $alte_url_datum = $temp2[2];
        //echo "$alte_url_datum<br><br>";
        $alte_url_datum = mktime(0,0,0,$alte_url_datum[4].$alte_url_datum[5],$alte_url_datum[6].$alte_url_datum[7],$alte_url_datum[0].$alte_url_datum[1].$alte_url_datum[2].$alte_url_datum[3]);
    
        if (($neue_url_datum <= $alte_url_datum) || (in_array($neue_url, $fehlerhafteURLs))) { //es wurde 2mal hintereinander derselbe Spieltag aufgerufen
		  $fehlerhafteURLs[] = $neue_url;
		  $urlDatum = $alte_url_datum;
 		  $urlDatum += 259200; //drei Tage weiter
		  $urlDatum = date('Ymd', $urlDatum);
		  $temp2[2] = $urlDatum;
		  $temp[10] = implode(',', $temp2);
		  $neue_url_temp[0] = implode('/', $temp);
		  $neue_url="http://fussball.sport1.de/".$neue_url_temp[0];
		  $anzAufrufSelberSpieltag++;
        } else $anzAufrufSelberSpieltag = 0;	
      } else {
         echo "<font color=\"red\"><b>".$text['limporter'][23]."</b> ".$text['limporter'][110]." $url</font>";
         exit;
      }
    } else $neue_url='';
    //Für Debug-Zwecke diese beiden Zeilen wieder entkommentieren:
    echo $neue_url."<br>\n";
    echo memory_get_usage() . "\n";	
    $arr = preg_split("/<\/t[d|h]/si",$urlContent);
    $spieldatum = '';
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

        if (preg_match("/\d\d\.\d\d\.\d\d\d\d/",$content,$ergebnis)) {
          $spieldatum  = $ergebnis[0]; //sucht das spieldatum
        } 

        if (preg_match("/(\d+:\d+)(( |\&nbsp;)([a-zA-Z])){0,1}/",$content,$ergebnis)) { // filtert die Ergebnis-Zelle
          $contentTemp  = $ergebnis[1]; //das Ergebnis ohne Zusätze
	  if ($ergebnis[4] == 't' || $ergebnis[4] == 'T') { //$ergebnis[3] beinhaltet den Ergebnis-Zusatz (* oder u,v,w,...)
	    $zeile = split('#', $rows[$rowCount]);
	    $rows[$rowCount] = '';  //Falls das Spiel ein Testspiel ist, lösche die aktuelle Zeile
            if ($mode<>"update") echo "<font>".$text['limporter'][111]." ".$zeile[3]." - ".$zeile[4]." ".$text['limporter'][120]."<br>\n";
          }
	  if ($ergebnis[4] == 'u' || $ergebnis[4] == 'U' ||
	      $ergebnis[4] == 'v' || $ergebnis[4] == 'V' ||
	      $ergebnis[4] == 'w' || $ergebnis[4] == 'W') {  //Könnte sein, dass in diesen Fällen hinter dem Ergebnis eine andere Spielwertung steht
	        if (preg_match("/(\d+:\d+)(( |\&nbsp;)([a-zA-Z]))( |\&nbsp;)(\d+:\d+)/",$content,$ergebnis)) {
	          $contentTemp = $ergebnis[6];  //Übernehme das 2. Ergebnis	
	        }
	  }  
	$content = $contentTemp;
	}

        // Ok neue Zeile gefunden, jetzt schauen ob es eine Folgezeile
        // oder eine neue Partie ist

         if ($trEnd!=FALSE && ($detailsRowCheck == 0 || isDetailsRow($content,$newRowCheck)==FALSE || $rowCount < 1)) {
             // Wenn die aktuelle Zeile komplett leer ist,dh nur # enthält,
             // dann wird sie mit neuen Daten überschrieben
             if ($rowCount < 0 || skipRow($rows[$rowCount])==FALSE) {
             //Mannschaften zählen
             $zeile = split('#', $rows[$rowCount]);
             if (!in_array($zeile[3], $mannschaften)) //wenn mannschaftsname noch nicht vorgekommen ist
               if ($mannschaften[0]=='') $mannschaften[0]=$zeile[3];
               else array_push($mannschaften, $zeile[3]);
             if (!in_array($zeile[4], $mannschaften)) //Auswärts muss auch überprüft werden. "Spielfrei" ist z.B. eine reine Auswärtsmannschaft
               if ($mannschaften[0]=='') $mannschaften[0]=$zeile[4];
               else array_push($mannschaften, $zeile[4]);
             /*if ($durchlauf == FALSE) {
               $zeile[6] = '00:00'; //Beim Extra-Aufruf des Spieltages wird ein Verlegungs-Datum eingetragen, damit das Spiel am Ende nicht doppelt berücksichtigt wird  
               $rows[$rowCount] = implode("#", $zeile);
             }*/
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
            if ($content!="" && $rowCount == 0 ) $rows[$rowCount].="#".$content.$z; // Nur in der erste Zeile
            else $rows[$rowCount].="#";
          }
      }
    }
    
    //urlContent wird nicht mehr gebraucht und wird zur Speicherreduzierung frei gegeben
    unset($urlContent);
    unset($content);    
      
    if ($neue_url != "") { //solange letzter Spieltag noch nicht erreicht
      $rows = buildFieldArrayRekursion($neue_url, $rowCount, $newRowCheck, $rows, $mannschaften, $linkZumSpieltag, $spieltagBesucht, $spieltagHatSpiele, TRUE, $anzAufrufSelberSpieltag, $fehlerhafteURLs, $mode); //nächsten Spieltag aufrufen
    }
    else { //letzter Spieltag erreicht. Nun noch nachschauen, ob auch alle Spieltage besucht worden. (Sind zwei Spieltage nur 2 Tage voneinander entfernt, werden sie beim 'nächster'-Durchlauf von fussball.de zusammengefasst)
	  $i = array_search(FALSE, $spieltagBesucht);
	  if ($i === FALSE){
	  }
	  else {
	  	$spieltagBesucht[$i] = TRUE; //Falls der Benutzer mehr Spieltage angibt als existieren, werden die überzähligen Spieltage oben nicht als besucht markiert und es würde ohne die Zeile zur Endlosschleife kommen.
	  	$neue_url = $linkZumSpieltag[$i];
	  	$rows = buildFieldArrayRekursion($neue_url, $rowCount, $newRowCheck, $rows, $mannschaften, $linkZumSpieltag, $spieltagBesucht, $spieltagHatSpiele, FALSE, 0, array(), $mode); //nächsten Spieltag aufrufen
	  }
    }
    return $rows;
  }

  $mannschaften = array();
  $spieltagHatSpiele = array();
  $rows = buildFieldArrayRekursion($url, -1, "", array(), $mannschaften, $linkZumSpieltag, $spieltagBesucht, $spieltagHatSpiele, TRUE, 0, array(), $mode);
  array_pop($rows); //Aus einem mir nicht ganz klaren Grund enthält der letzte Key des Arrays "Datenmüll". Der wird hiermit gelöscht.
  
  //Zumindest der letzte Spieltag wird mehrfach beim Einlesen aufgerufen. Daher die mehrfachen Einträge entfernen
  $temp = array_unique($rows);
  $rows = array_values($temp); 

  //Jetzt werden den verlegten Spielen die richtigen Spieltagsnummer zugewiesen. Wird über Spielnr. gemacht.
  $spielnrEingefuegt = array();
  $anz_mannschaften = count($mannschaften);
  if (($anz_mannschaften % 2 != 0) && ($mode!="update")) echo "<font>Hinweis: Ungerade Anzahl von Mannschaften (incl. 'SPIELFREI'). Spieltagszuordnung könnte durcheinander geraten.</font><br>\n";

  //Welche Spielnummern gehören zu welchem Spieltag?
  //Die bekannten Spielnummern dem Spieltag zuordnen
  for ($i=0; $i<count($rows); $i++) {
    $zeile = split('#', $rows[$i]);
    $zeile[0] = preg_replace("/^0{1,2}/",'',$zeile[0]);  //führende Spieltags-Nullen entfernen
    if (($zeile[2]!='?&?!') && (!isset($spieltageExplizitGesetzt[$zeile[0]]) || $spieltageExplizitGesetzt[$zeile[0]] !== TRUE)) { //letztere Bedingung, damit Spiele, die an zwei Spieltagen angesetzt sind (auch sowas gibts...), beim zweiten Mal übersprungen werden 
      $spielnr = $zeile[0];
      $spieltagnr = $zeile[2];
      $spieltage[$spielnr] = $spieltagnr;
      $spieltageExplizitGesetzt[$spielnr] = TRUE; //Soll heißen, dass der Spieltag aus fussball.de ausgelesen wurde und somit korrekt ist
      //Spielnr./Tag-Zuordnung für die vorhergehenden Spielnr. ebenfalls eintragen, falls noch nicht geschehen. Für Spiele ohne Spieltag wird dieser also 'geraten' 
      for ($k=$spielnr-1; (($k>$spielnr-($anz_mannschaften/2)) && ($k>=0)); $k--) {
           //echo "k: $k\n"; echo "ceil($k / ($anz_mannschaften / 2)\n";
           //echo "ceil($spielnr / ($anz_mannschaften / 2)\n";
         if ((ceil($k / ($anz_mannschaften / 2)) == ceil($spielnr / ($anz_mannschaften / 2))) && (!isset($spieltageExplizitGesetzt[$k]) || $spieltageExplizitGesetzt[$k]!==TRUE)) {
            $spieltage[$k] = $spieltage[$spielnr];
            $spieltageExplizitGesetzt[$k] = FALSE;
         }
      }
      //Für die nachfolgenden Spiele ebenfalls
      for ($k=$spielnr+1; (($k < $spielnr+($anz_mannschaften/2)) && ($k<=count($rows))); $k++) {
         if ((ceil($k / ($anz_mannschaften / 2)) == ceil($spielnr / ($anz_mannschaften / 2))) && (!isset($spieltageExplizitGesetzt[$k]) || $spieltageExplizitGesetzt[$k]!==TRUE)) {
            $spieltage[$k] = $spieltage[$spielnr];
            $spieltageExplizitGesetzt[$k] = FALSE;
         }
      }
    } elseif (($zeile[2]!='?&?!') && ($spieltageExplizitGesetzt[$zeile[0]] == TRUE) && ($spieltage[$zeile[0]] <> $zeile[2])) {
        if ($mode<>"update") echo "<font>".$text['limporter'][111]." ".$zeile[3]." - ".$zeile[4]." ".$text['limporter'][112]." ".$spieltage[$zeile[0]].". ".$text['limporter'][113]." ".$zeile[2].$text['limporter'][114]."<br>\n";	
    }
  }

  //Den unbekannten Spielen die Spieltagnr zuweisen und neues Array erstellen
  $spieleOhneSpieltag = 0;
  $rows_bereinigt = array();
  for ($i=0; $i<count($rows); $i++) {
    $zeile = split('#', $rows[$i]);
    $zeile[0] = preg_replace("/^0{1,2}/",'',$zeile[0]);  //führende Spieltags-Nullen entfernen
    if (($zeile[6]=='') && ($zeile[3]<>'SPIELFREI') && ($zeile[4]<>'SPIELFREI') && ($zeile[3]<>'9999999999999999') && ($zeile[4]<>'9999999999999999') && (!isset($spielnrEingefuegt[$zeile[0]]))) { //zeile[6]!='', wenn Spiel ein Verlegungsdatum eingetragen hat
      if ($zeile[2]=='?&?!') { //bei Spielen mit unbekannter Spieltagszuordnung
         $zeile[2]=$spieltage[$zeile[0]];
         if ($zeile[2]=='') { //Kein Spieltag gefunden
         	$spieleOhneSpieltag++;
         	$zeile[2]=1; //Dem 1. Spieltag zuweisen
         	$spieltageExplizitGesetzt[$zeile[0]] = FALSE;
         }
         $spieltagHatSpiele[$zeile[2]] = TRUE;
         $spielnrEingefuegt[$zeile[0]] = TRUE; //wenn die URL manuell bestimmt wird, kann es vorkommen, dass ein Spiel zweimal ohne Verlegungsdatum auftaucht 
         //Stellt den Spieltag an den Anfang
         $temp = $zeile[0];
         $zeile[0] = $zeile[2];
         $zeile[2] = $temp;
         $neue_zeile = implode('#',$zeile);
         array_push($rows_bereinigt, $neue_zeile);
      } else {
         if (($spieltage[$zeile[0]] <> $zeile[2]) && ($spieltageExplizitGesetzt[$zeile[0]] = TRUE)) { //Wenn ein Spiel an mehreren Spieltagen angesetzt ist, dann nehme den Ersten (ist meistens richtig)
		   //if ($mode<>"update") echo "<font>Hinweis: Die Partie ".$zeile[3]." gegen ".$zeile[4]." ist gleichzeitig am ".$spieltage[$zeile[0]].". und ".$zeile[2].". Spieltag angesetzt. Sie wurde dem Ersteren zugeordnet.<br>\n";
           $zeile[2] = $spieltage[$zeile[0]];
         }
         $spieltagHatSpiele[$zeile[2]] = TRUE;
         $spielnrEingefuegt[$zeile[0]] = TRUE; //wenn die URL manuell bestimmt wird, kann es vorkommen, dass ein Spiel zweimal ohne Verlegungsdatum auftaucht 
         //Stellt den Spieltag an den Anfang
         $temp = $zeile[0];
         $zeile[0] = $zeile[2];
         $zeile[2] = $temp;
         $neue_zeile = implode('#',$zeile);
         array_push($rows_bereinigt, $neue_zeile);
      }
    }
  }
  
  if ($mode<>"update") {
    while (($i = array_search(FALSE, $spieltagHatSpiele)) && (!$i===FALSE)) {
      array_push($rows_bereinigt, "$i#01.01.1980#1#Dummy-Spiel#Dummy-Spiel###");
  	  $spieltagHatSpiele[$i] = TRUE;
  	  echo "<font>".$text['limporter'][115]." $i".$text['limporter'][116]."</font><br>\n";
    }
  }
  
  //Sortierung des Arrays nach dem Spieltag. Ist nötig, weil der Limporter ansonsten nicht richtig importiert
  natsort($rows_bereinigt);

  if (($mode<>"update") && ($spieleOhneSpieltag>0)) {
  	echo "<font>".$text['limporter'][117]." $spieleOhneSpieltag ".$text['limporter'][118]."</font><br>\n";
  }
  
  return $rows_bereinigt;
}
?>