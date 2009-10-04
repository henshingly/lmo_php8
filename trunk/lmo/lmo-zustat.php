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

    $zustatoutput .= "<?php\n";
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

    $serie = array();
    $team_serie = array();
    $serie_gewonnen = array();
    $max_serie_gewonnen = array();
    $serie_ungeschlagen = array();
    $serie_unentschieden = array();
    $serie_sieglos = array();
    $serie_verloren = array();


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

            $serien_array[$heimteam][$y1-1] = $hsieg>0?1:($hsieg<0?-1:0);
            $serien_array[$gastteam][$y1-1] = $hsieg<0?1:($hsieg>0?-1:0);


            //Serien gewonnen
            if ($serien_array[$heimteam][$y1-1]>0) {
              if (isset($serie[$heimteam]['gewonnen']) && isset($serien_array[$heimteam][$y1-2]) && $serien_array[$heimteam][$y1-2]>0) {
                $serie[$heimteam]['gewonnen']++;
              } else {
                $serie[$heimteam]['gewonnen'] = 1;
              }
            } else {
              $serie[$heimteam]['gewonnen'] = 0;
            }
            $serie[$heimteam]['max_gewonnen']['count'] = !isset($serie[$heimteam]['max_gewonnen']['count'])?0:$serie[$heimteam]['max_gewonnen']['count'];
            if (isset($serie[$heimteam]['gewonnen']) && $serie[$heimteam]['gewonnen']>=$serie[$heimteam]['max_gewonnen']['count']) {
              //neues maximum setzen
              $serie[$heimteam]['max_gewonnen']['count'] = $serie[$heimteam]['gewonnen'];
              $serie[$heimteam]['max_gewonnen']['st'] = $y1-($serie[$heimteam]['max_gewonnen']['count']-1)."-".$y1;
            }
            if ($serien_array[$gastteam][$y1-1]>0) {
              if (isset($serie[$gastteam]['gewonnen']) && isset($serien_array[$gastteam][$y1-2]) && $serien_array[$gastteam][$y1-2]>0) {
                $serie[$gastteam]['gewonnen']++;
              } else {
                $serie[$gastteam]['gewonnen'] = 1;
              }
            } else {
              $serie[$gastteam]['gewonnen'] = 0;
            }
            $serie[$gastteam]['max_gewonnen']['count'] = !isset($serie[$gastteam]['max_gewonnen']['count'])?0:$serie[$gastteam]['max_gewonnen']['count'];
            if (isset($serie[$gastteam]['gewonnen']) && $serie[$gastteam]['gewonnen']>=$serie[$gastteam]['max_gewonnen']['count']) {
              //neues maximum setzen
              $serie[$gastteam]['max_gewonnen']['count'] = $serie[$gastteam]['gewonnen'];
              $serie[$gastteam]['max_gewonnen']['st'] = $y1-($serie[$gastteam]['max_gewonnen']['count']-1)."-".$y1;
            }
            //Serien ungeschlagen
            if ($serien_array[$heimteam][$y1-1]>=0) {
              if (isset($serie[$heimteam]['ungeschlagen']) && isset($serien_array[$heimteam][$y1-2]) && $serien_array[$heimteam][$y1-2]>=0) {
                $serie[$heimteam]['ungeschlagen']++;
              } else {
                $serie[$heimteam]['ungeschlagen'] = 1;
              }
            } else {
              $serie[$heimteam]['ungeschlagen'] = 0;
            }
            $serie[$heimteam]['max_ungeschlagen']['count'] = !isset($serie[$heimteam]['max_ungeschlagen']['count'])?0:$serie[$heimteam]['max_ungeschlagen']['count'];
            if (isset($serie[$heimteam]['ungeschlagen']) && $serie[$heimteam]['ungeschlagen']>=$serie[$heimteam]['max_ungeschlagen']['count']) {
              //neues maximum setzen
              $serie[$heimteam]['max_ungeschlagen']['count'] = $serie[$heimteam]['ungeschlagen'];
              $serie[$heimteam]['max_ungeschlagen']['st'] = $y1-($serie[$heimteam]['max_ungeschlagen']['count']-1)."-".$y1;
            }
            if ($serien_array[$gastteam][$y1-1]>=0) {
              if (isset($serie[$gastteam]['ungeschlagen']) && isset($serien_array[$gastteam][$y1-2]) && $serien_array[$gastteam][$y1-2]>=0) {
                $serie[$gastteam]['ungeschlagen']++;
              } else {
                $serie[$gastteam]['ungeschlagen'] = 1;
              }
            } else {
              $serie[$gastteam]['ungeschlagen'] = 0;
            }
            $serie[$gastteam]['max_ungeschlagen']['count'] = !isset($serie[$gastteam]['max_ungeschlagen']['count'])?0:$serie[$gastteam]['max_ungeschlagen']['count'];
            if (isset($serie[$gastteam]['ungeschlagen']) && $serie[$gastteam]['ungeschlagen']>=$serie[$gastteam]['max_ungeschlagen']['count']) {
              //neues maximum setzen
              $serie[$gastteam]['max_ungeschlagen']['count'] = $serie[$gastteam]['ungeschlagen'];
              $serie[$gastteam]['max_ungeschlagen']['st'] = $y1-($serie[$gastteam]['max_ungeschlagen']['count']-1)."-".$y1;
            }
            //Serien unentschieden
            if ($serien_array[$heimteam][$y1-1]==0) {
              if (isset($serie[$heimteam]['unentschieden']) && isset($serien_array[$heimteam][$y1-2]) && $serien_array[$heimteam][$y1-2]==0) {
                $serie[$heimteam]['unentschieden']++;
              } else {
                $serie[$heimteam]['unentschieden'] = 1;
              }
            } else {
              $serie[$heimteam]['unentschieden'] = 0;
            }
            $serie[$heimteam]['max_unentschieden']['count'] = !isset($serie[$heimteam]['max_unentschieden']['count'])?0:$serie[$heimteam]['max_unentschieden']['count'];
            if (isset($serie[$heimteam]['unentschieden']) && $serie[$heimteam]['unentschieden']>=$serie[$heimteam]['max_unentschieden']['count']) {
              //neues maximum setzen
              $serie[$heimteam]['max_unentschieden']['count'] = $serie[$heimteam]['unentschieden'];
              $serie[$heimteam]['max_unentschieden']['st'] = $y1-($serie[$heimteam]['max_unentschieden']['count']-1)."-".$y1;
            }
            if ($serien_array[$gastteam][$y1-1]==0) {
              if (isset($serie[$gastteam]['unentschieden']) && isset($serien_array[$gastteam][$y1-2]) && $serien_array[$gastteam][$y1-2]==0) {
                $serie[$gastteam]['unentschieden']++;
              } else {
                $serie[$gastteam]['unentschieden'] = 1;
              }
            } else {
              $serie[$gastteam]['unentschieden'] = 0;
            }
            $serie[$gastteam]['max_unentschieden']['count'] = !isset($serie[$gastteam]['max_unentschieden']['count'])?0:$serie[$gastteam]['max_unentschieden']['count'];
            if (isset($serie[$gastteam]['unentschieden']) && $serie[$gastteam]['unentschieden']>=$serie[$gastteam]['max_unentschieden']['count']) {
              //neues maximum setzen
              $serie[$gastteam]['max_unentschieden']['count'] = $serie[$gastteam]['unentschieden'];
              $serie[$gastteam]['max_unentschieden']['st'] = $y1-($serie[$gastteam]['max_unentschieden']['count']-1)."-".$y1;
            }
            //Serien sieglos
            if ($serien_array[$heimteam][$y1-1]<=0) {
              if (isset($serie[$heimteam]['sieglos']) && isset($serien_array[$heimteam][$y1-2]) && $serien_array[$heimteam][$y1-2]<=0) {
                $serie[$heimteam]['sieglos']++;
              } else {
                $serie[$heimteam]['sieglos'] = 1;
              }
            } else {
              $serie[$heimteam]['sieglos'] = 0;
            }
            $serie[$heimteam]['max_sieglos']['count'] = !isset($serie[$heimteam]['max_sieglos']['count'])?0:$serie[$heimteam]['max_sieglos']['count'];
            if (isset($serie[$heimteam]['sieglos']) && $serie[$heimteam]['sieglos']>=$serie[$heimteam]['max_sieglos']['count']) {
              //neues maximum setzen
              $serie[$heimteam]['max_sieglos']['count'] = $serie[$heimteam]['sieglos'];
              $serie[$heimteam]['max_sieglos']['st'] = $y1-($serie[$heimteam]['max_sieglos']['count']-1)."-".$y1;
            }
            if ($serien_array[$gastteam][$y1-1]<=0) {
              if (isset($serie[$gastteam]['sieglos']) && isset($serien_array[$gastteam][$y1-2]) && $serien_array[$gastteam][$y1-2]<=0) {
                $serie[$gastteam]['sieglos']++;
              } else {
                $serie[$gastteam]['sieglos'] = 1;
              }
            } else {
              $serie[$gastteam]['sieglos'] = 0;
            }
            $serie[$gastteam]['max_sieglos']['count'] = !isset($serie[$gastteam]['max_sieglos']['count'])?0:$serie[$gastteam]['max_sieglos']['count'];
            if (isset($serie[$gastteam]['sieglos']) && $serie[$gastteam]['sieglos']>=$serie[$gastteam]['max_sieglos']['count']) {
              //neues maximum setzen
              $serie[$gastteam]['max_sieglos']['count'] = $serie[$gastteam]['sieglos'];
              $serie[$gastteam]['max_sieglos']['st'] = $y1-($serie[$gastteam]['max_sieglos']['count']-1)."-".$y1;
            }
            //Serien verloren
            if ($serien_array[$heimteam][$y1-1]<0) {
              if (isset($serie[$heimteam]['verloren']) && isset($serien_array[$heimteam][$y1-2]) && $serien_array[$heimteam][$y1-2]<0) {
                $serie[$heimteam]['verloren']++;
              } else {
                $serie[$heimteam]['verloren'] = 1;
              }
            } else {
              $serie[$heimteam]['verloren'] = 0;
            }
            $serie[$heimteam]['max_verloren']['count'] = !isset($serie[$heimteam]['max_verloren']['count'])?0:$serie[$heimteam]['max_verloren']['count'];
            if (isset($serie[$heimteam]['verloren']) && $serie[$heimteam]['verloren']>=$serie[$heimteam]['max_verloren']['count']) {
              //neues maximum setzen
              $serie[$heimteam]['max_verloren']['count'] = $serie[$heimteam]['verloren'];
              $serie[$heimteam]['max_verloren']['st'] = $y1-($serie[$heimteam]['max_verloren']['count']-1)."-".$y1;
            }
            if ($serien_array[$gastteam][$y1-1]<0) {
              if (isset($serie[$gastteam]['verloren']) && isset($serien_array[$gastteam][$y1-2]) && $serien_array[$gastteam][$y1-2]<0) {
                $serie[$gastteam]['verloren']++;
              } else {
                $serie[$gastteam]['verloren'] = 1;
              }
            } else {
              $serie[$gastteam]['verloren'] = 0;
            }
            $serie[$gastteam]['max_verloren']['count'] = !isset($serie[$gastteam]['max_verloren']['count'])?0:$serie[$gastteam]['max_verloren']['count'];
            if (isset($serie[$gastteam]['verloren']) && $serie[$gastteam]['verloren']>=$serie[$gastteam]['max_verloren']['count']) {
              //neues maximum setzen
              $serie[$gastteam]['max_verloren']['count'] = $serie[$gastteam]['verloren'];
              $serie[$gastteam]['max_verloren']['st'] = $y1-($serie[$gastteam]['max_verloren']['count']-1)."-".$y1;
            }



            if ($hheimsiegtor == $heimtore && $hgastsiegtor == $gasttore) {
              $hheimsieg1 = $heimteam;
              $hgastsieg1 = $gastteam;
              $hheimsiegtor1 = $heimtore;
              $hgastsiegtor1 = $gasttore;
              $spieltagflag1 = $y1;
            }

            if (($hsieg > 0 && $hsieg > $hsieg1) || ($hsieg > 0 && $hsieg == $hsieg1 && $hgastsiegtor < $gasttore && $hheimsiegtor < $heimtore)) {
              $hheimsieg = $heimteam;
              $hgastsieg = $gastteam;
              $hheimsiegtor = $heimtore;
              $hgastsiegtor = $gasttore;
              $spieltagflag = $y1;
              $hsieg1 = $hsieg;
            }
            // Höchster-Sieg checken-Ende

            // Höchster-Auswärtssieg checken-Anfang
            $asieg = $gasttore-$heimtore;
            if ($aheimsiegtor == $heimtore && $agastsiegtor == $gasttore) {
              $aheimsieg1 = $heimteam;
              $agastsieg1 = $gastteam;
              $aheimsiegtor1 = $heimtore;
              $agastsiegtor1 = $gasttore;
              $spieltagflag3 = $y1;
            }

            if (($asieg > 0 && $asieg > $asieg1) || ($asieg > 0 && $asieg == $asieg1 && $agastsiegtor < $gasttore && $aheimsiegtor < $heimtore)) {
              $aheimsieg = $heimteam;
              $agastsieg = $gastteam;
              $aheimsiegtor = $heimtore;
              $agastsiegtor = $gasttore;
              $spieltagflag2 = $y1;
              $asieg1 = $asieg;
            }

            // Höchster-Auswärtssieg checken-Ende

            // Torreichste Begegnung checken-Anfang
            $htorreich = $heimtore+$gasttore;
            if ($htorreich1 == $htorreich) {
              $htorreichm3 = $heimteam;
              $htorreichm4 = $gastteam;
              $htorreicht3 = $heimtore;
              $htorreicht4 = $gasttore;
              $spieltagflag5 = $y1;
              $htorreich2 = $htorreicht3+$htorreicht4;

            }

            if ($htorreich > 0 && $htorreich > $htorreich1) {
              $htorreichm1 = $heimteam;
              $htorreichm2 = $gastteam;
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

      $zustatoutput .= '$zutore['.$y1.']='.$sptore1.";\n"; // Tore pro Spieltag


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
      $zustatoutput .= '$dstore['.$y1.']='.$dstore.";\n";
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

    //Serienauswertung
    $akt_gewonnen = 0; $team_akt_gewonnen = array();
    $akt_ungeschlagen = 0; $team_akt_ungeschlagen = array();
    $akt_unentschieden = 0; $team_akt_unentschieden = array();
    $akt_sieglos = 0; $team_akt_sieglos = array();
    $akt_verloren = 0; $team_akt_verloren = array();

    $max_gewonnen = 0; $team_max_gewonnen = array();
    $max_ungeschlagen = 0; $team_max_ungeschlagen = array();
    $max_unentschieden = 0; $team_max_unentschieden = array();
    $max_sieglos = 0; $team_max_sieglos = array();
    $max_verloren = 0; $team_max_verloren = array();

    foreach ($serie as $team=>$team_serien) {
    	if ($team_serien['gewonnen']>$akt_gewonnen) {
        $akt_gewonnen = $team_serien['gewonnen'];
        $team_akt_gewonnen = array();
        $team_akt_gewonnen[] = $team;
    	} elseif ($team_serien['gewonnen']==$akt_gewonnen && $akt_gewonnen>0){
    	  $team_akt_gewonnen[] = $team;
    	}
    	if ($team_serien['ungeschlagen']>$akt_ungeschlagen) {
        $akt_ungeschlagen = $team_serien['ungeschlagen'];
        $team_akt_ungeschlagen = array();
        $team_akt_ungeschlagen[] = $team;
    	} elseif ($team_serien['ungeschlagen']==$akt_ungeschlagen && $akt_ungeschlagen>0){
    	  $team_akt_ungeschlagen[] = $team;
    	}
    	if ($team_serien['unentschieden']>$akt_unentschieden) {
        $akt_unentschieden = $team_serien['unentschieden'];
        $team_akt_unentschieden = array();
        $team_akt_unentschieden[] = $team;
    	} elseif ($team_serien['unentschieden']==$akt_unentschieden && $akt_unentschieden>0){
    	  $team_akt_unentschieden[] = $team;
    	}
    	if ($team_serien['sieglos']>$akt_sieglos) {
        $akt_sieglos = $team_serien['sieglos'];
        $team_akt_sieglos = array();
        $team_akt_sieglos[] = $team;
    	} elseif ($team_serien['sieglos']==$akt_sieglos && $akt_sieglos>0){
    	  $team_akt_sieglos[] = $team;
    	}
    	if ($team_serien['verloren']>$akt_verloren) {
        $akt_verloren = $team_serien['verloren'];
        $team_akt_verloren = array();
        $team_akt_verloren[] = $team;
    	} elseif ($team_serien['verloren']==$akt_verloren && $akt_verloren>0){
    	  $team_akt_verloren[] = $team;
    	}
    	if ($team_serien['max_gewonnen']['count']>$max_gewonnen) {
        $max_gewonnen = $team_serien['max_gewonnen']['count'];
        $team_max_gewonnen = array();
        $team_max_gewonnen[] = $team." (".$team_serien['max_gewonnen']['st'].".".$text[145].")";
    	} elseif ($team_serien['max_gewonnen']['count']==$max_gewonnen && $max_gewonnen>0){
    	  $team_max_gewonnen[] = $team." (".$team_serien['max_gewonnen']['st'].".".$text[145].")";
    	}
    	if ($team_serien['max_ungeschlagen']['count']>$max_ungeschlagen) {
        $max_ungeschlagen = $team_serien['max_ungeschlagen']['count'];
        $team_max_ungeschlagen = array();
        $team_max_ungeschlagen[] = $team." (".$team_serien['max_ungeschlagen']['st'].".".$text[145].")";
    	} elseif ($team_serien['max_ungeschlagen']['count']==$max_ungeschlagen && $max_ungeschlagen>0){
    	  $team_max_ungeschlagen[] = $team." (".$team_serien['max_ungeschlagen']['st'].".".$text[145].")";
    	}
    	if ($team_serien['max_unentschieden']['count']>$max_unentschieden) {
        $max_unentschieden = $team_serien['max_unentschieden']['count'];
        $team_max_unentschieden = array();
        $team_max_unentschieden[] = $team." (".$team_serien['max_unentschieden']['st'].".".$text[145].")";
    	} elseif ($team_serien['max_unentschieden']['count']==$max_unentschieden && $max_unentschieden>0){
    	  $team_max_unentschieden[] = $team." (".$team_serien['max_unentschieden']['st'].".".$text[145].")";
    	}
    	if ($team_serien['max_sieglos']['count']>$max_sieglos) {
        $max_sieglos = $team_serien['max_sieglos']['count'];
        $team_max_sieglos = array();
        $team_max_sieglos[] = $team." (".$team_serien['max_sieglos']['st'].".".$text[145].")";
    	} elseif ($team_serien['max_sieglos']['count']==$max_sieglos && $max_sieglos>0){
    	  $team_max_sieglos[] = $team." (".$team_serien['max_sieglos']['st'].".".$text[145].")";
    	}
    	if ($team_serien['max_verloren']['count']>$max_verloren) {
        $max_verloren = $team_serien['max_verloren']['count'];
        $team_max_verloren = array();
        $team_max_verloren[] = $team." (".$team_serien['max_verloren']['st'].".".$text[145].")";
    	} elseif ($team_serien['max_verloren']['count']==$max_verloren && $max_verloren>0){
    	  $team_max_verloren[] = $team." (".$team_serien['max_verloren']['st'].".".$text[145].")";
    	}
    }
    //Serien Ende

		// Ausgabe der Daten - Anfang
		$zustatoutput.='$gzutore='.$gzutore.";\n"; 								// Gesamttore der Saison
		$zustatoutput.='$gdstore='.$gdstore.";\n"; 								// Gesamt-Durchschnitt Tore pro Spiel
		$zustatoutput.='$gzusieg1='.$gzusieg1.";\n"; 							// Gesamtheimsiege
		$zustatoutput.='$gzusieg2='.$gzusieg2.";\n"; 							// Gesamtauswärtssiege
		$zustatoutput.='$gzuunent='.$gzuunent.";\n"; 							// Gesamtunenetschieden
		$zustatoutput.='$gbeide='.$gbeide.";\n"; 								// Gesamt beidseitiges Ergebnis
		$zustatoutput.='$gheimtore='.$gheimtore.";\n"; 							// Gesamt-Heimtore
		$zustatoutput.='$ggasttore='.$ggasttore.";\n"; 							// Gesamt-Auswärtstore
		$zustatoutput.='$dsheimtore='.$dsheimtore.";\n"; 						// Gesamt-Durchschnitt Tore pro Heimspiel
		$zustatoutput.='$dsgasttore='.$dsgasttore.";\n"; 						// Gesamt-Durchschnitt Tore pro Auswärtsspiel
		$zustatoutput.='$hheimsieg="'.htmlspecialchars($hheimsieg)."\";\n";		// Heimmannschaft1 - höchster Heimsieg
		$zustatoutput.='$hgastsieg="'.htmlspecialchars($hgastsieg)."\";\n";		// Gastmannschaft1 - höchster Heimsieg
		$zustatoutput.='$hheimsiegtor="'.$hheimsiegtor."\";\n";						// Tore Heimmannschaft1
		$zustatoutput.='$hgastsiegtor="'.$hgastsiegtor."\";\n";						// Tore Gastmannschaft1
		$zustatoutput.='$spieltagflag='.$spieltagflag.";\n";						// Spieltag des Sieges Paarung1
		$zustatoutput.='$hheimsieg1="'.htmlspecialchars($hheimsieg1)."\";\n";	// Heimmannschaft2 - höchster Heimsieg
		$zustatoutput.='$hgastsieg1="'.htmlspecialchars($hgastsieg1)."\";\n";	// Gastmannschaft2 - höchster Heimsieg
		$zustatoutput.='$hheimsiegtor1="'.$hheimsiegtor1."\";\n";					// Tore Heimmannschaft2
		$zustatoutput.='$hgastsiegtor1="'.$hgastsiegtor1."\";\n";					// Tore Gastmannschaft2
		$zustatoutput.='$spieltagflag1='.$spieltagflag1.";\n";					// Spieltag des Sieges Paarung2
		$zustatoutput.='$counteranz='.$counteranz.";\n";							// Anzahl höchster Heimsiege
		$zustatoutput.='$aheimsieg="'.htmlspecialchars($aheimsieg)."\";\n";		// Heimmannschaft1 - höchster Auswärtssieg
		$zustatoutput.='$agastsieg="'.htmlspecialchars($agastsieg)."\";\n";		// Gastmannschaft1 - höchster Auswärtssieg
		$zustatoutput.='$aheimsiegtor="'.$aheimsiegtor."\";\n";						// Tore Heimmannschaft1
		$zustatoutput.='$agastsiegtor="'.$agastsiegtor."\";\n";						// Tore Gastmannschaft1
		$zustatoutput.='$spieltagflag2='.$spieltagflag2.";\n";					// Spieltag des Sieges Paarung1
		$zustatoutput.='$aheimsieg1="'.htmlspecialchars($aheimsieg1)."\";\n";	// Heimmannschaft2 - höchster Auswärtssieg
		$zustatoutput.='$agastsieg1="'.htmlspecialchars($agastsieg1)."\";\n";	// Gastmannschaft2 - höchster Auswärtssieg
		$zustatoutput.='$aheimsiegtor1="'.$aheimsiegtor1."\";\n";					// Tore Heimmannschaft2
		$zustatoutput.='$agastsiegtor1="'.$agastsiegtor1."\";\n";					// Tore Gastmannschaft2
		$zustatoutput.='$spieltagflag3='.$spieltagflag3.";\n";					// Spieltag des Sieges Paarung2
		$zustatoutput.='$counteranz1='.$counteranz1.";\n";						// Anzahl höchster Auswärtssiege
		$zustatoutput.='$htorreichm1="'.htmlspecialchars($htorreichm1)."\";\n"; 	// Heimmannschaft1 - Torreichstes Spiel1
		$zustatoutput.='$htorreichm2="'.htmlspecialchars($htorreichm2)."\";\n"; 	// Gastmannschaft1 - Torreichstes Spiel1
		$zustatoutput.='$htorreicht1="'.$htorreicht1."\";\n";						// Tore Heimmannschaft1
		$zustatoutput.='$htorreicht2="'.$htorreicht2."\";\n";						// Tore Gastmannschaft1
		$zustatoutput.='$spieltagflag4='.$spieltagflag4.";\n";					// Spieltag des Sieges Paarung1
		$zustatoutput.='$htorreichm3="'.htmlspecialchars($htorreichm3)."\";\n"; 	// Heimmannschaft2 - Torreichstes Spiel2
		$zustatoutput.='$htorreichm4="'.htmlspecialchars($htorreichm4)."\";\n"; 	// Gastmannschaft2 - Torreichstes Spiel2
		$zustatoutput.='$htorreicht3="'.$htorreicht3."\";\n";						// Tore Heimmannschaft2
		$zustatoutput.='$htorreicht4="'.$htorreicht4."\";\n";						// Tore Gastmannschaft2
		$zustatoutput.='$spieltagflag5='.$spieltagflag5.";\n";					// Spieltag des Sieges Paarung2
		$zustatoutput.='$counteranz5='.$counteranz5.";\n";						// Anzahl höchster Treffer
		$zustatoutput.='$akt_gewonnen='.$akt_gewonnen.";\n";						//Aktuelle Serie gewonnen
		$zustatoutput.='$team_akt_gewonnen="'.htmlspecialchars(implode("\n",$team_akt_gewonnen))."\";\n";					//Aktuelle Serie gewonnen Team
		$zustatoutput.='$akt_ungeschlagen='.$akt_ungeschlagen.";\n";						//Aktuelle Serie ungeschlagen
		$zustatoutput.='$team_akt_ungeschlagen="'.htmlspecialchars(implode("\n",$team_akt_ungeschlagen))."\";\n";					//Aktuelle Serie ungeschlagen Team
		$zustatoutput.='$akt_unentschieden='.$akt_unentschieden.";\n";						//Aktuelle Serie unentschieden
		$zustatoutput.='$team_akt_unentschieden="'.htmlspecialchars(implode("\n",$team_akt_unentschieden))."\";\n";						//Aktuelle Serie unentschieden Team
		$zustatoutput.='$akt_sieglos='.$akt_sieglos.";\n";						//Aktuelle Serie sieglos
		$zustatoutput.='$team_akt_sieglos="'.htmlspecialchars(implode("\n",$team_akt_sieglos))."\";\n";					//Aktuelle Serie sieglos Team
		$zustatoutput.='$akt_verloren='.$akt_verloren.";\n";						//Aktuelle Serie verloren
		$zustatoutput.='$team_akt_verloren="'.htmlspecialchars(implode("\n",$team_akt_verloren))."\";\n";					//Aktuelle Serie verloren Team
		$zustatoutput.='$max_gewonnen='.$max_gewonnen.";\n";						//Längste Serie gewonnen
		$zustatoutput.='$team_max_gewonnen="'.htmlspecialchars(implode("\n",$team_max_gewonnen))."\";\n";					//Längste Serie gewonnen Team
		$zustatoutput.='$max_ungeschlagen='.$max_ungeschlagen.";\n";						//Längste Serie ungeschlagen
		$zustatoutput.='$team_max_ungeschlagen="'.htmlspecialchars(implode("\n",$team_max_ungeschlagen))."\";\n";					//Längste Serie ungeschlagen Team
		$zustatoutput.='$max_unentschieden='.$max_unentschieden.";\n";						//Längste Serie unentschieden
		$zustatoutput.='$team_max_unentschieden="'.htmlspecialchars(implode("\n",$team_max_unentschieden))."\";\n";					//Längste Serie unentschieden Team
		$zustatoutput.='$max_sieglos='.$max_sieglos.";\n";						//Längste Serie sieglos
		$zustatoutput.='$team_max_sieglos="'.htmlspecialchars(implode("\n",$team_max_sieglos))."\";\n";				//Längste Serie sieglos Team
		$zustatoutput.='$max_verloren='.$max_verloren.";\n";						//Längste Serie verloren
		$zustatoutput.='$team_max_verloren="'.htmlspecialchars(implode("\n",$team_max_verloren))."\";\n";						//Längste Serie verloren Team
		$zustatoutput.='?>';
		// Ausgabe der Daten - Ende

		fwrite($zustatfile,$zustatoutput);
		$zustatoutput="";
		fclose($zustatfile);
  }
}
?>