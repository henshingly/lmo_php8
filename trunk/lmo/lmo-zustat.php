<?
/** Liga Manager Online 4
  *
  * http://lmo.sourceforge.net/
  *
  * This program is free software; you can redistribute it and/or
  * modify it under the terms of the GNU General Public License as
  * published by the Free Software Foundation; either version 2 of
  * the License, || (at your option) any later version.
  * 
  * This program is distributed in the hope that it will be useful,
  * but WITHOUT ANY WARRANTY; without even the implied warranty of
  * MERCHANTABILITY || FITNESS FOR A PARTICULAR PURPOSE. See the GNU
  * General Public License for more details.
  *
  * REMOVING || CHANGING THE COPYRIGHT NOTICES IS NOT ALLOWED!
  *
  */
  
  
$zustatoutput = '';
if ($_SESSION['lmouserok'] > 0) {
  if ($lmtype == 0 && $zustatfile = fopen(PATH_TO_LMO.'/'.$diroutput.basename($file).".php", "wb+")) {
        
    $zustatoutput .= '<? ';
    $gzutore = 0;
    $gzuanzsp = 0;
    $gzusieg1 = 0;
    $gzusieg2 = 0;
    $gzuunent = 0;
    $gheimtore = 0;
    $ggasttore = 0;
    $gbeide = 0;
    $hsieg = 0;
    $asieg = 0;
    $hsieg1 = 0;
    $asieg1 = 0;
    $counteranz = 0;
    $counteranz1 = 0;
    $counteranz5 = 0;
     
    $hheimsieg = 0;
    $hgastsieg = 0;
    $hheimsiegtor = 0;
    $hgastsiegtor = 0;
    $spieltagflag = 0;
    $hheimsieg1 = 0;
    $hgastsieg1 = 0;
    $hheimsiegtor1 = 0;
    $hgastsiegtor1 = 0;
    $spieltagflag1 = 0;
    $aheimsieg = 0;
    $agastsieg = 0;
    $aheimsiegtor = 0;
    $agastsiegtor = 0;
    $spieltagflag2 = 0;
    $aheimsieg1 = 0;
    $agastsieg1 = 0;
    $aheimsiegtor1 = 0;
    $agastsiegtor1 = 0;
    $spieltagflag3 = 0;
     
    $htorreich = 0;
    $htorreich1 = 0;
    $htorreich2 = 0;
    $htorreichm1 = 0;
    $htorreichm2 = 0;
    $htorreicht1 = 0;
    $htorreicht2 = 0;
    $htorreichm3 = 0;
    $htorreichm4 = 0;
    $htorreicht3 = 0;
    $htorreicht4 = 0;
    $spieltagflag4 = 0;
    $spieltagflag5 = 0;
     
     
    for ($y1 = 1; $y1 < $anzst+1; $y1++) {
      $sptore1 = 0;
      $sptore = 0;
      $zuanzsp = 0;
      $dstore = 0;
      $zusieg1 = 0;
      $zusieg2 = 0;
      $zuunent1 = 0;
       
      for($i1 = 0; $i1 < $anzsp; $i1++) {
        if (($teama[$y1-1][$i1] > 0) && ($teamb[$y1-1][$i1] > 0)) {
           
          $heimteam = $teams[$teama[$y1-1][$i1]];
          $gastteam = $teams[$teamb[$y1-1][$i1]];
           
          // Abfrage Grüne-Tisch-Entscheidung-Anfang
          if ($goala[$y1-1][$i1] == "-1") $goala[$y1-1][$i1] = "_";
          if (isset($msieg)) {
            if ($msieg[$y1-1][$i1] == "1") {
              $zusieg1 = $zusieg1+1;
              $zuunent1 = $zuunent1-1;
            }
            if ($msieg[$y1-1][$i1] == "2") {
              $zusieg2 = $zusieg2+1;
              $zuunent1 = $zuunent1-1;
            }
            if ($msieg[$y1-1][$i1] == "3") {
              $gbeide = $gbeide+1;
              if ($goala[$y1-1][$i1] > $goalb[$y1-1][$i1]) {
                $sptore1 = $sptore1+$goala[$y1-1][$i1];
                $zusieg2 = $zusieg2+1;
                $ggasttore = $ggasttore+$goala[$y1-1][$i1];
              }
              if ($goala[$y1-1][$i1] < $goalb[$y1-1][$i1]) {
                $sptore1 = $sptore1+$goalb[$y1-1][$i1];
                $zusieg2 = $zusieg2-1;
                $gheimtore = $gheimtore+$goalb[$y1-1][$i1];
              }
            }
          }
           
          // Abfrage Grüne-Tisch-Entscheidung-Ende
          if ($goalb[$y1-1][$i1] == "-1") $goalb[$y1-1][$i1] = "_";
           
          $heimtore = $goala[$y1-1][$i1];
          $gasttore = $goalb[$y1-1][$i1];
          if ($heimtore!='_' &&  $gasttore!='_') {
            // Höchster-Sieg checken-Anfang
            $hsieg = $heimtore-$gasttore;
            if ($hheimsiegtor == $heimtore && $hgastsiegtor == $gasttore) {
              $hheimsieg1 = $teams[$teama[$y1-1][$i1]];
              $hgastsieg1 = $teams[$teamb[$y1-1][$i1]];
              $hheimsiegtor1 = $heimtore;
              $hgastsiegtor1 = $gasttore;
              $spieltagflag1 = $y1;
            }
             
            if (($hsieg > 0 && $hsieg > $hsieg1) || ($hsieg > 0 && $hsieg == $hsieg1 && $hgastsiegtor < $gasttore && $hheimsiegtor < $heimtore)) {
              $hheimsieg = $teams[$teama[$y1-1][$i1]];
              $hgastsieg = $teams[$teamb[$y1-1][$i1]];
              $hheimsiegtor = $heimtore;
              $hgastsiegtor = $gasttore;
              $spieltagflag = $y1;
              $hsieg1 = $hsieg;
            }
            // Höchster-Sieg checken-Ende
             
            // Höchster-Auswärtssieg checken-Anfang
            $asieg = $gasttore-$heimtore;
            if ($aheimsiegtor == $heimtore && $agastsiegtor == $gasttore) {
              $aheimsieg1 = $teams[$teama[$y1-1][$i1]];
              $agastsieg1 = $teams[$teamb[$y1-1][$i1]];
              $aheimsiegtor1 = $heimtore;
              $agastsiegtor1 = $gasttore;
              $spieltagflag3 = $y1;
            }
             
            if (($asieg > 0 && $asieg > $asieg1) || ($asieg > 0 && $asieg == $asieg1 && $agastsiegtor < $gasttore && $aheimsiegtor < $heimtore)) {
              $aheimsieg = $teams[$teama[$y1-1][$i1]];
              $agastsieg = $teams[$teamb[$y1-1][$i1]];
              $aheimsiegtor = $heimtore;
              $agastsiegtor = $gasttore;
              $spieltagflag2 = $y1;
              $asieg1 = $asieg;
            }
             
            // Höchster-Auswärtssieg checken-Ende
             
            // Torreichste Begegnung checken-Anfang
            $htorreich = $heimtore+$gasttore;
            if ($htorreich1 == $htorreich) {
              $htorreichm3 = $teams[$teama[$y1-1][$i1]];
              $htorreichm4 = $teams[$teamb[$y1-1][$i1]];
              $htorreicht3 = $heimtore;
              $htorreicht4 = $gasttore;
              $spieltagflag5 = $y1;
              $htorreich2 = $htorreicht3+$htorreicht4;
               
            }
             
            if ($htorreich > 0 && $htorreich > $htorreich1) {
              $htorreichm1 = $teams[$teama[$y1-1][$i1]];
              $htorreichm2 = $teams[$teamb[$y1-1][$i1]];
              $htorreicht1 = $heimtore;
              $htorreicht2 = $gasttore;
              $spieltagflag4 = $y1;
              $htorreich1 = $htorreich;
               
            }
            // Torreichste Begegnung checken-Ende
             
            // Anzahl und Art Spiele checken - Anfang
            $sptore = $heimtore+$gasttore;
            $gheimtore = $gheimtore+$heimtore;
            $ggasttore = $ggasttore+$gasttore;
            $sptore1 = $sptore+$sptore1;
            if ($goala[$y1-1][$i1] != "_") {
              $zuanzsp = $zuanzsp+1;
              if ($heimtore > $gasttore) $zusieg1 = $zusieg1+1;
              if ($heimtore < $gasttore) $zusieg2 = $zusieg2+1;
              if ($heimtore == $gasttore) $zuunent1 = $zuunent1+1;
            }
          }
        }
      }
      $gzutore = $gzutore+$sptore1;
      $gzuanzsp = $gzuanzsp+$zuanzsp;
      $gzusieg1 = $gzusieg1+$zusieg1;
      $gzusieg2 = $gzusieg2+$zusieg2;
      $gzuunent = $gzuunent+$zuunent1;
      // Anzahl und Art Spiele checken - Ende
       
      $zustatoutput .= '$zutore['.$y1.']='.$sptore1.';'; // Tore pro Spieltag
       
       
      if ($zuanzsp > 0) {
        $dstore = round($sptore1/$zuanzsp, 2);
      } else {
        $dstore = 0;
      }
       
      if ($gzuanzsp > 0) {
        $gdstore = round($gzutore/$gzuanzsp, 2);
        $dsheimtore = round($gheimtore/$gzuanzsp, 2);
        $dsgasttore = round($ggasttore/$gzuanzsp, 2);
      } else {
        $gdstore = 0;
        $dsheimtore = 0;
        $dsgasttore = 0;
      }
      $zustatoutput .= '$dstore['.$y1.']='.$dstore.';';
      // Durchschnitt Tore pro Spiel
    }
     
    // Höchster Sieg-Reset - Anfang
    if ($hheimsiegtor != $hheimsiegtor1 || $hgastsiegtor != $hgastsiegtor1) {
      $hheimsieg1 = 0;
      $hgastsieg1 = 0;
      $hheimsiegtor1 = 0;
      $hgastsiegtor1 = 0;
      $spieltagflag1 = 0;
    }
    if ($aheimsiegtor != $aheimsiegtor1 || $agastsiegtor != $agastsiegtor1) {
      $aheimsieg1 = 0;
      $agastsieg1 = 0;
      $aheimsiegtor1 = 0;
      $agastsiegtor1 = 0;
      $spieltagflag3 = 0;
    }
    if ($htorreicht1 == 0 && $htorreicht2 == 0) {
      $htorreichm1 = 0;
      $htorreichm2 = 0;
      $htorreicht1 = 0;
      $htorreicht2 = 0;
      $spieltagflag4 = 0;
      $htorreichm3 = 0;
      $htorreichm4 = 0;
      $htorreicht3 = 0;
      $htorreicht4 = 0;
      $spieltagflag5 = 0;
    }
    if ($htorreich1 <> $htorreich2) {
      $htorreichm3 = 0;
      $htorreichm4 = 0;
      $htorreicht3 = 0;
      $htorreicht4 = 0;
      $spieltagflag5 = 0;
    }
     
    // Höchster Sieg-Reset - Ende
     
    // Anzahl gleicher gewonnener Spiele und torreichstes Spiel- Anfang
    for ($y1 = 1; $y1 < $anzst+1; $y1++) {
      for($i1 = 0; $i1 < $anzsp; $i1++) {
        if ($goala[$y1-1][$i1] == $hheimsiegtor && $goala[$y1-1][$i1] == $hheimsiegtor1 && $goalb[$y1-1][$i1] == $hgastsiegtor && $goalb[$y1-1][$i1] == $hgastsiegtor1) {
          $counteranz = $counteranz+1;
        }
         
        if ($goala[$y1-1][$i1] == $aheimsiegtor && $goala[$y1-1][$i1] == $aheimsiegtor1 && $goalb[$y1-1][$i1] == $agastsiegtor && $goalb[$y1-1][$i1] == $agastsiegtor1) {
          $counteranz1 = $counteranz1+1;
        }
        $setztemp1 = $htorreicht1+$htorreicht2;
        $setztemp2 = $goala[$y1-1][$i1]+$goalb[$y1-1][$i1];
        if ($setztemp1 == $setztemp2) {
          $counteranz5 = $counteranz5+1;
        }
      }
    }

    // Anzahl gleicher gewonnener Spiele und torreichstes Spiel- Ende
      		
    		
		// Ausgabe der Daten - Anfang
		$zustatoutput.='$gzutore='.$gzutore.';'; 								// Gesamttore der Saison
		$zustatoutput.='$gdstore='.$gdstore.';'; 								// Gesamt-Durchschnitt Tore pro Spiel
		$zustatoutput.='$gzusieg1='.$gzusieg1.';'; 							// Gesamtheimsiege
		$zustatoutput.='$gzusieg2='.$gzusieg2.';'; 							// Gesamtauswärtssiege
		$zustatoutput.='$gzuunent='.$gzuunent.';'; 							// Gesamtunenetschieden
		$zustatoutput.='$gbeide='.$gbeide.';'; 								// Gesamt beidseitiges Ergebnis
		$zustatoutput.='$gheimtore='.$gheimtore.';'; 							// Gesamt-Heimtore
		$zustatoutput.='$ggasttore='.$ggasttore.';'; 							// Gesamt-Auswärtstore
		$zustatoutput.='$dsheimtore='.$dsheimtore.';'; 						// Gesamt-Durchschnitt Tore pro Heimspiel
		$zustatoutput.='$dsgasttore='.$dsgasttore.';'; 						// Gesamt-Durchschnitt Tore pro Auswärtsspiel
		$zustatoutput.='$hheimsieg="'.$hheimsieg.'";';		// Heimmannschaft1 - höchster Heimsieg
		$zustatoutput.='$hgastsieg="'.$hgastsieg.'";';		// Gastmannschaft1 - höchster Heimsieg
		$zustatoutput.='$hheimsiegtor="'.$hheimsiegtor.'";';						// Tore Heimmannschaft1
		$zustatoutput.='$hgastsiegtor="'.$hgastsiegtor.'";';						// Tore Gastmannschaft1
		$zustatoutput.='$spieltagflag='.$spieltagflag.';';						// Spieltag des Sieges Paarung1
		$zustatoutput.='$hheimsieg1="'.$hheimsieg1.'";';	// Heimmannschaft2 - höchster Heimsieg
		$zustatoutput.='$hgastsieg1="'.$hgastsieg1.'";';	// Gastmannschaft2 - höchster Heimsieg
		$zustatoutput.='$hheimsiegtor1="'.$hheimsiegtor1.'";';					// Tore Heimmannschaft2
		$zustatoutput.='$hgastsiegtor1="'.$hgastsiegtor1.'";';					// Tore Gastmannschaft2
		$zustatoutput.='$spieltagflag1='.$spieltagflag1.';';					// Spieltag des Sieges Paarung2
		$zustatoutput.='$counteranz='.$counteranz.';';							// Anzahl höchster Heimsiege
		$zustatoutput.='$aheimsieg="'.$aheimsieg.'";';		// Heimmannschaft1 - höchster Auswärtssieg
		$zustatoutput.='$agastsieg="'.$agastsieg.'";';		// Gastmannschaft1 - höchster Auswärtssieg
		$zustatoutput.='$aheimsiegtor="'.$aheimsiegtor.'";';						// Tore Heimmannschaft1
		$zustatoutput.='$agastsiegtor="'.$agastsiegtor.'";';						// Tore Gastmannschaft1
		$zustatoutput.='$spieltagflag2='.$spieltagflag2.';';					// Spieltag des Sieges Paarung1
		$zustatoutput.='$aheimsieg1="'.$aheimsieg1.'";';	// Heimmannschaft2 - höchster Auswärtssieg
		$zustatoutput.='$agastsieg1="'.$agastsieg1.'";';	// Gastmannschaft2 - höchster Auswärtssieg
		$zustatoutput.='$aheimsiegtor1="'.$aheimsiegtor1.'";';					// Tore Heimmannschaft2
		$zustatoutput.='$agastsiegtor1="'.$agastsiegtor1.'";';					// Tore Gastmannschaft2
		$zustatoutput.='$spieltagflag3='.$spieltagflag3.';';					// Spieltag des Sieges Paarung2
		$zustatoutput.='$counteranz1='.$counteranz1.';';						// Anzahl höchster Auswärtssiege
		$zustatoutput.='$htorreichm1="'.$htorreichm1.'";'; 	// Heimmannschaft1 - Torreichstes Spiel1
		$zustatoutput.='$htorreichm2="'.$htorreichm2.'";'; 	// Gastmannschaft1 - Torreichstes Spiel1
		$zustatoutput.='$htorreicht1="'.$htorreicht1.'";';						// Tore Heimmannschaft1
		$zustatoutput.='$htorreicht2="'.$htorreicht2.'";';						// Tore Gastmannschaft1
		$zustatoutput.='$spieltagflag4='.$spieltagflag4.';';					// Spieltag des Sieges Paarung1
		$zustatoutput.='$htorreichm3="'.$htorreichm3.'";'; 	// Heimmannschaft2 - Torreichstes Spiel2
		$zustatoutput.='$htorreichm4="'.$htorreichm4.'";'; 	// Gastmannschaft2 - Torreichstes Spiel2
		$zustatoutput.='$htorreicht3="'.$htorreicht3.'";';						// Tore Heimmannschaft2
		$zustatoutput.='$htorreicht4="'.$htorreicht4.'";';						// Tore Gastmannschaft2
		$zustatoutput.='$spieltagflag5='.$spieltagflag5.';';					// Spieltag des Sieges Paarung2
		$zustatoutput.='$counteranz5='.$counteranz5.';';						// Anzahl höchster Treffer
		$zustatoutput.='?>';
		// Ausgabe der Daten - Ende
		
		fwrite($zustatfile,$zustatoutput);
		$zustatoutput="";
		fclose($zustatfile);
  }
}
?>