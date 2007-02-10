<?php
/**
 * Importiert Ligen von fussball.de zur Weiterverarbeitung im Limporter
 * 
 * Diese Funktion muss mit der URL zu einem beliebigen Spieltag der Liga
 * aufgerufen werden. Beim Import wird erst Spieltag für Spieltag ausgelesen,
 * um festzustellen, welche Spielnummern zu welchen Spieltagen gehören.
 * Anschließend und beim Update wird der Staffelspielplan ausgelesen.
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

  function buildFieldArrayRekursion($url, &$spieltag, $basispfad, $verband) {
    $urlContent = getFileContent($url);

    //Spieltags-Nr. suchen
    if (preg_match("/<option value=\"([0-9]+)\" selected=\"selected\">/", $urlContent, $ergebnis)) {
       $spieltagsnr = $ergebnis[1];
    }

    //URL des nächsten Spieltages bestimmen
   	if (preg_match("/letzterSpieltag=([0-9]+)/", $urlContent, $ergebnis)) { //bestimme den letzten Spieltag der Liga
   		$letzterSpieltag = $ergebnis[1];
   	} else {
			echo "<font color=\"red\"><b>Last round not found. URL: $url</font>";
			exit;
	}    		
   	if ($letzterSpieltag > $spieltagsnr)
   		$neue_url = "http://www.fussball.de/fussball/servlet/content/$verband?next=$basispfad&tag=".($spieltagsnr+1);
   	else
   		$neue_url = '';

    //Für Debug-Zwecke diese beiden Zeilen wieder entkommentieren:
    //echo $neue_url."<br>\n";
    //echo memory_get_usage() . "\n";
    	
    //Gehe Seiteninhalt Zeile für Zeile durch und bestimme die Spielnummern, die zu einem Spieltag gehören
    $arr = preg_split("/<\/t[d|h]/si",$urlContent);
    for ($i=0; $i<count($arr); $i++){
      //Wenn bei der Zeile "verlegte Spiele ausserhalb des Spieltages/" angekommen, breche diesen Spieltag ab
      if (preg_match("/Verlegte Spiele au.{1,7}erhalb des Spieltags/", $arr[$i]))
      	$i = count($arr);
      //Ansonsten suche die Spielnummern
      if (preg_match("/<td class=\"ed_col1\">([0-9]{3})/", $arr[$i], $ergebnis)) {
      	$spielnummer = $ergebnis[1];
      	$spieltag[$spielnummer] = $spieltagsnr;
      }
    }
    
    //urlContent wird nicht mehr gebraucht und wird zur Speicherreduzierung frei gegeben
    unset($urlContent);
    unset($arr);    

    if ($neue_url != "") { //solange letzter Spieltag noch nicht erreicht
      buildFieldArrayRekursion($neue_url, $spieltag, $basispfad, $verband); //nächsten Spieltag aufrufen
    }
	}
	
	//Bestimme den Basispfad
	$urlContent = getFileContent($url);
	if (preg_match("/Basispfad='(.+)'/", $urlContent, $ergebnis)) {
		$basispfad = $ergebnis[1];
	} else {
		echo "<font color=\"red\"><b>".$text['limporter'][23]."</b> ".$text['limporter'][110]." $url</font>";
		exit;
	}

	//Bestimme den Landesverband. Suche in der aktuellen URL bzw. in der URL, die in importsrc.htm gespeichert ist
	if ( (preg_match("/content\/([0-9]+)\?/", $urlContent, $ergebnis)) || (preg_match("/content\/([0-9]+)\?/", $url, $ergebnis)) ) {
		$verband = $ergebnis[1];
	} else {
		echo "<font color=\"red\"><b>".$text['limporter'][23]."</b> ".$text['limporter'][110]." $url</font>";
		exit;
	}	
	
  $spieltag = array();
  //Baue Array Spieltag -> Spielnummer auf (nur nötig beim erstmaligen Import)
  if ($mode<>'update')
  	buildFieldArrayRekursion("http://www.fussball.de/fussball/servlet/content/$verband?next=$basispfad&tag=1", $spieltag, $basispfad, $verband);
  //Lese Staffelspielplan ein
  $urlContent = getFileContent("http://www.fussball.de/fussball/servlet/content/$verband?next=$basispfad&tag=50003");
  //Überprüfen, ob überhaupt Daten im Staffelspielplan enthalten sind
  if (!preg_match("/<td class=\"ed_col1\">/", $urlContent)) {
		echo "<font color=\"red\"><b>".$text['limporter'][23]."</b> ".$text['limporter'][111]."</font>";
		exit;
	}	
  //Gehe Seiteninhalt Zeile für Zeile durch
	$arr = preg_split("/<\/tr/si",$urlContent);
	$rows = array();	
	$spieleOhneSpieltag = 0;
	for ($i=0; $i<count($arr); $i++) {
		//Suche das Datum
		if (preg_match("/, (\d\d\.\d\d\.\d\d\d\d)/",$arr[$i],$ergebnis))
			$datum = $ergebnis[1];
		//Suche die Spielpaarungen heraus
		if (preg_match("/<td class=\"ed_col1\">(.*)<\/td><td class=\"ed_col2\">(.*)<\/td><td class=\"ed_col3\">(.*)<\/td><td class=\"ed_col4\">(.*)<\/td><td class=\"ed_col5\">(.*)<\/td><td class=\"ed_col6\">(.*)<\/td>/", $arr[$i], $ergebnis)) {
			if (($ergebnis[2] != 'SPIELFREI') && ($ergebnis[3] != 'SPIELFREI') && ($ergebnis[5] == '&nbsp;')) { //Wenn die Paarung Spielfrei enthält oder ein Verlegungsdatum enthält, dann überspringen
				//Wenn zu der Spielnummer kein Spieltag gefunden wurde, dann setze das Spiel auf den ersten Spieltag
				if ($spieltag[$ergebnis[1]] == '') {
					$spieleOhneSpieltag++;
					$spieltag[$ergebnis[1]] = 1;
				}
				//Entferne mehrfache Leerzeichen aus den Mannschaftsnamen
				$ergebnis[2] = preg_replace("/ +/", " ", $ergebnis[2]);
				$ergebnis[3] = preg_replace("/ +/", " ", $ergebnis[3]);
				//Suche besondere Ereignisse
				//Wenn hier Änderungen vorgenommen werden, bitte auch das Update des Notiz-Feldes in der lim-adminupdate.php anpassen
				if ($ergebnis[6] == 'Ausf.')
					$notiz = $text['limporter'][112];
				elseif ($ergebnis[6] == 'Annu.')
					$notiz = $text['limporter'][113];
				elseif ($ergebnis[6] == 'Abg.')
					$notiz = $text['limporter'][114];
				elseif ($ergebnis[6] == 'Abbr.')
					$notiz = $text['limporter'][115];
				else
					$notiz = ' ';							
				//Baue Array für die Weiterverarbeitung im Limporter
				$begegnung = utf8_decode($spieltag[$ergebnis[1]] . "#" . $datum . "#" . $ergebnis[1] . "#" . $ergebnis[2] . "#" . $ergebnis[3] . "#" . $ergebnis[4] . "#". $notiz . "#" . $ergebnis[6]); 
				array_push($rows, $begegnung);
			}
		}
	}

	if (($mode<>"update") && ($spieleOhneSpieltag>0)) {
		echo "<font>".$text['limporter'][117]." $spieleOhneSpieltag ".$text['limporter'][118]."</font><br>\n";
	}

  return $rows;
}
?>