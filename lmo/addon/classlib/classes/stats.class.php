<?php

/**
 * Klasse zur Berechnung von Statistiken
 *
 * Changes:
 * 04.11.2005 Marcus Schug  adding SerieToHTML Methode.
 *
 * @author Marcus Schug <lmo@marcus.schug.info>
 * @package classlib
 * @version $Id$
 */
class stats {

  /**
   * Referenz auf das Ligaobject
   *
   * @var Object  Typ liga
   */
  var $liga;

  function __construct(&$ligaObject) {
    if ( is_a($ligaObject, "liga") || is_subclass_of($ligaObject, "liga") ) {
      if($ligaObject->options->keyValues['Type']>=1){
        return null;
      }
      $this->liga = $ligaObject ;
    }
    else{
      return null;
    }
  }

  /**
   * Berechnet den Die Statistik für einen Spieltag und gibt
   * ein Array zurück:
   *    $statsArray["spiele"]     gespielte Partien
   *    $statsArray["hSiege"]     Anzahl Heimpiege
   *    $statsArray["u"]          Anzahl Unendschieden
   *    $statsArray["gSiege"]     Anzahl Auswärtssiege
   *    $statsArray["hTore"]      Erzielte Tore
   *    $statsArray["gTore"]      Erzielte Tore Auswärts
   *    $statsArray["maxhS"][]    object(partie) höchter Heimsieg der Saison
   *    $statsArray["maxgS"][]    object(partie) höchste Auswärtssieg der Saison
   *    $statsArray["maxTor"][]   object(partie) meiste Tore der Saison
   *
   * @access public
   * @param integer spTag Spieltag für den die Statistik berechnet werden soll.
   * @return array Statistik des Angegebenen Spieltages
   */
  function calcLigaStats($spTag=1) {
    $actual = $this->liga->options->keyValues['Actual'];
    $spTag = ($spTag<1)?$actual:$spTag;
    $spTagCount = 1;
    $statsArray = array ("hSiege"=> 0,
                         "u"=> 0,
                         "gSiege"=> 0,
                         "hTore"=> 0,
                         "gTore"=> 0,
                         "maxhS"=> array(),
                         "maxgS"=> array(),
                         "maxTor"=> array());
    foreach ($this->liga->spieltage as $spieltag) {
      foreach ($spieltag->partien as $partie) {
        $statsArray["spiele"]++;
        if ($partie->hTore>-1) {
          $statsArray["hTore"] += $partie->hTore;
        }
        if ($partie->gTore>-1) {
          // Tore für Gast hinzufügen
          $statsArray["gTore"] += $partie->gTore;
        }
        $diff = 0;
        if ($partie->hTore>-1 and $partie->gTore > -1) { // Ein normales Ergebnis?
          if ($partie->gTore == $partie->hTore) { // Unendschieden
            $statsArray["u"]++;
          }
          elseif ($partie->gTore > $partie->hTore) { // Gast hat gewonnen
            $statsArray["gSiege"]++;
            $diff = $partie->gTore - $partie->hTore;
          }
          elseif ($partie->gTore < $partie->hTore) { // Heim hat gewonnen
            $statsArray["hSiege"]++;
          }
          else { // nur während der Entwicklung
            echo "Fehler in Punkteermittlung (Normales Ergebnis)";
            echo $partie->showDetailsHTML();
          }
        }
        else if ($partie->hTore==-2) { // O:0 Tore Heim gewinnt
          $statsArray["hSiege"]++;
        }
        else if ($partie->gTore==-2) { // O:0 Tore Gast gewinnt
          $statsArray["gSiege"]++;
        }
        $next_index = count($statsArray["maxhS"]);
        if(count($statsArray["maxhS"]) < 1){
          $statsArray["maxhS"][0]["spieltag"]=$spieltag->nr;
          $statsArray["maxhS"][0]["partie"]=$partie;
        } elseif (($statsArray["maxhS"][0]["partie"]->hTore - $statsArray["maxhS"][0]["partie"]->gTore) < ($partie->hTore - $partie->gTore)){
          unset($statsArray["maxhS"]);
          $statsArray["maxhS"][0]["spieltag"]=$spieltag->nr;
          $statsArray["maxhS"][0]["partie"]=$partie;
        } elseif (($statsArray["maxhS"][0]["partie"]->hTore - $statsArray["maxhS"][0]["partie"]->gTore) == ($partie->hTore - $partie->gTore)){
          $statsArray["maxhS"][$next_index]["spieltag"]=$spieltag->nr;
          $statsArray["maxhS"][$next_index]["partie"]=$partie;
        }
        $next_index = count($statsArray["maxgS"]);
        if(count($statsArray["maxgS"]) < 1 ){
          $statsArray["maxgS"][0]["spieltag"]=$spieltag->nr;
          $statsArray["maxgS"][0]["partie"]=$partie;
        } elseif (($statsArray["maxgS"][0]["partie"]->gTore - $statsArray["maxgS"][0]["partie"]->hTore) < ($partie->gTore - $partie->hTore)){
          unset($statsArray["maxgS"]);
          $statsArray["maxgS"][0]["spieltag"]=$spieltag->nr;
          $statsArray["maxgS"][0]["partie"]=$partie;
        } elseif (($statsArray["maxgS"][0]["partie"]->gTore - $statsArray["maxgS"][0]["partie"]->hTore) == ($partie->gTore - $partie->hTore)){
          $statsArray["maxgS"][$next_index]["spieltag"]=$spieltag->nr;
          $statsArray["maxgS"][$next_index]["partie"]=$partie;
        }
        $next_index = count($statsArray["maxTor"]);
        if(count($statsArray["maxTor"]) < 1){
          $statsArray["maxTor"][0]["spieltag"]=$spieltag->nr;
          $statsArray["maxTor"][0]["partie"]=$partie;
        } elseif (($statsArray["maxTor"][0]["partie"]->hTore + $statsArray["maxTor"][0]["partie"]->gTore) < ($partie->hTore + $partie->gTore)){
          unset($statsArray["maxTor"]);
          $statsArray["maxTor"][0]["spieltag"]=$spieltag->nr;
          $statsArray["maxTor"][0]["partie"]=$partie;
        } elseif (($statsArray["maxTor"][0]["partie"]->hTore + $statsArray["maxTor"][0]["partie"]->gTore) == ($partie->hTore + $partie->gTore)){
          $statsArray["maxTor"][$next_index]["spieltag"]=$spieltag->nr;
          $statsArray["maxTor"][$next_index]["partie"]=$partie;
        }
      } // foreach Partien
      if($spTagCount<$spTag) $spTagCount++; else break;
    } // foreach Spieltage

    return $statsArray;
  }

  /**
   * Berechnung der Statistik für ein Team
   *
   * Das Rückgabearray hat die Form
   *                 $statsArray["pkts"]           1.5 Pkt./Spiel
   *                 $statsArray["tore"]           191:177 Tore
   *                 $statsArray["tores"]          31.83:29.50 Tore/Spiel
   *                 $statsArray["s"]              4 (66,67%) Siege
   *                 $statsArray["n"]              1 (16,67%) Niederlagen
   *                 $statsArray["chance"]         wird erst beim Vergleich gefüllt
   *                 $statsArray["serie"]          Resultat von getSerien
   *                 $statsArray["max"]            Resultat von getMaxResults
   *                 $statsArray["tabelle"]        Tabellenzeile des Teams
   *
   * @author <a href="mailto:lmo@marcus.schug.info">Marcus Schug</a>
   * @param teamObject $teama Referenz auf ein TeamObject A
   * @param teamObject $teamb Referenz auf ein TeamObject B
   * @return array Statistik der beiden teams analog calcStatsForTeam
   */
  function calcStatsForTeam(&$team) {
    $statsArray = array ("pkts"=> 0,
                         "tore"=> 0,
                         "tores"=> 0,
                         "s"=> 0,
                         "n"=> 0,
                         "chance"=>0,
                         "serie" => array(),
                         "max"=> array(),
                         "tabelle"=>array());
    $tableArray = $this->liga->calcTable($this->liga->options->keyValues['Rounds'],"all",TRUE);
    foreach($tableArray as $zeile){
      if($zeile["team"] == $team){
        $statsArray["pkts"] = ($zeile["spiele"]==0)?0:number_format(round($zeile["pPkt"]/$zeile["spiele"],2),2,".","");
        $statsArray["tore"] = $zeile["pTor"].":".$zeile["mTor"];
        $pTorS = ($zeile["spiele"]==0)?0:number_format(round($zeile["pTor"]/$zeile["spiele"],2),2,".","");
        $mTorS = ($zeile["spiele"]==0)?0:number_format(round($zeile["mTor"]/$zeile["spiele"],2),2,".","");
        $statsArray["tores"] = $pTorS.":".$mTorS;
        $sPro = ($zeile["spiele"]==0)?"0,00":number_format(round($zeile["s"]*100/$zeile["spiele"],2),2,",","");
        $nPro = ($zeile["spiele"]==0)?"0,00":number_format(round($zeile["n"]*100/$zeile["spiele"],2),2,",","");
        $statsArray["s"] = $zeile["s"]."(".$sPro."%)";
        $statsArray["n"] = $zeile["n"]."(".$nPro ."%)";
        $statsArray["tabelle"] = $zeile;
        break;
      }
    }
    $statsArray["max"] = $this->getMaxResults($team);
    $statsArray["serie"] = $this->getSerien($team);
    return $statsArray;
  }

  /**
   * Berechnung für den Statistikvergleich zweier Teams
   *
   * @param teamObject $teama Referenz auf ein TeamObject A
   * @param teamObject $teamb Referenz auf ein TeamObject B
   * @return array Statistik der beiden teams analog calcStatsForTeam
   */
  function calcStatsForTeams(&$teama, &$teamb) {
    $statsArrayA = $this->calcStatsForTeam($teama);
    $statsArrayB = $this->calcStatsForTeam($teamb);
    if (!empty($statsArrayA["tabelle"]["spiele"])&&!empty($statsArrayB["tabelle"]["spiele"])) {
      $ax=(100*$statsArrayA["tabelle"]["s"]/$statsArrayA["tabelle"]["spiele"])+(100*$statsArrayB["tabelle"]["n"]/$statsArrayB["tabelle"]["spiele"]);
      $bx=(100*$statsArrayB["tabelle"]["s"]/$statsArrayB["tabelle"]["spiele"])+(100*$statsArrayA["tabelle"]["n"]/$statsArrayA["tabelle"]["spiele"]);
      $cx=($statsArrayA["tabelle"]["pTor"]/$statsArrayA["tabelle"]["spiele"])+($statsArrayB["tabelle"]["mTor"]/$statsArrayB["tabelle"]["spiele"]);
      $dx=($statsArrayB["tabelle"]["pTor"]/$statsArrayB["tabelle"]["spiele"])+($statsArrayA["tabelle"]["mTor"]/$statsArrayA["tabelle"]["spiele"]);
      $ex=$ax+$bx;
      $fx=$cx+$dx;
    }
    if (isset($ex) && ($ex>0) && isset($fx) &&($fx>0)) {
      $ax=round(10000*$ax/$ex);
      $bx=round(10000*$bx/$ex);
      $cx=round(10000*$cx/$fx);
      $dx=round(10000*$dx/$fx);
      $statsArrayA["chance"]=number_format((($ax+$cx)/200),2,",",".");
      $statsArrayB["chance"]=number_format((($bx+$dx)/200),2,",",".");
    }
    $resultArray[] = $statsArrayA;
    $resultArray[] = $statsArrayB;
    return $resultArray;
  }

  /**
   * Berechnung der Serien für ein Team
   *
   * @access public
   * @param teamObject $team Referenz auf ein TeamObject
   * @return array SerienArray, array(s,n,u,su,nu)
   */
  function getSerien(&$team){
    //Berechnung höchster Sieg/ höchste Niederlage
    $serienArray = array ("s"=> 0,
                          "n"=> 0,
                          "u"=> 0,
                          "su"=> 0,
                          "nu"=> 0);
    $games = $this->liga->gamesSortedForTeam($team);
    foreach($games as $result){
      $partie = $result["partie"];
      if ($partie->hTore>-1 and $partie->gTore>-1) { // Ein normales Ergebnis?
        if ($partie->gTore > $partie->hTore) { // Gast hat gewonnen
          if($partie->heim == $team){ //Niederlage
            $serienArray["s"] = 0;
            $serienArray["n"] ++;
            $serienArray["u"] = 0;
            $serienArray["su"] = 0;
            $serienArray["nu"] ++;
          } elseif ($partie->gast == $team){ // Sieg
            $serienArray["s"] ++;
            $serienArray["n"] = 0;
            $serienArray["u"] = 0;
            $serienArray["su"] ++;
            $serienArray["nu"] = 0;
          }
        } elseif ($partie->gTore < $partie->hTore) { // Heim hat gewonnen
          if($partie->heim == $team){ //Sieg
            $serienArray["s"] ++;
            $serienArray["n"] = 0;
            $serienArray["u"] = 0;
            $serienArray["su"] ++;
            $serienArray["nu"] = 0;
          } elseif ($partie->gast == $team){ //Niederlage
            $serienArray["s"] = 0;
            $serienArray["n"] ++;
            $serienArray["u"] = 0;
            $serienArray["su"] = 0;
            $serienArray["nu"] ++;
          }
        }elseif ($partie->gTore == $partie->hTore) { //Unentschieden
          $serienArray["s"] = 0;
          $serienArray["n"] = 0;
          $serienArray["u"]  ++;
          $serienArray["su"] ++;
          $serienArray["nu"] ++;
        }
      }
      else if ($partie->hTore==-2) { // O:0 Tore Heim gewinnt
        if($partie->heim == $team){
          $serienArray["s"] ++;
          $serienArray["n"] = 0;
          $serienArray["u"] = 0;
          $serienArray["su"] ++;
          $serienArray["nu"] = 0;
        } else {
          $serienArray["s"] = 0;
          $serienArray["n"] ++;
          $serienArray["u"] = 0;
          $serienArray["su"] = 0;
          $serienArray["nu"] ++;
        }
      }
      else if ($partie->gTore==-2) { // O:0 Tore Gast gewinnt
        if($partie->gast == $team){
          $serienArray["s"] ++;
          $serienArray["n"] = 0;
          $serienArray["u"] = 0;
          $serienArray["su"] ++;
          $serienArray["nu"] = 0;
        } else {
          $serienArray["s"] = 0;
          $serienArray["n"] ++;
          $serienArray["u"] = 0;
          $serienArray["su"] = 0;
          $serienArray["nu"] ++;
        }
      }
    }
    return $serienArray;
  }

  /**
   * Gibt die Maximalwerte für Siege (heim, auswärts), Niederlagen heim, auswärts)
   * und meiste Tore zurück
   *
   * Das Rückgabearray hat die Form
   *                 $maxArray["sH"][n]["partie"] mit der Referenz auf eine Partie
   *                 $maxArray["sA"][n]["partie"] mit der Referenz auf eine Partie
   *                 $maxArray["nH"][n]["partie"] mit der Referenz auf eine Partie
   *                 $maxArray["nA"][n]["partie"] mit der Referenz auf eine Partie
   *                 $maxArray["Tor"][n]["partie"] mit der Referenz auf eine Partie
   *
   * @access public
   * @param teamObject $team Referenz auf ein TeamObject
   * @return array MaxArray, array(sH,sA,nH,nA,Tor)
   */
  function getMaxResults(&$team){
    $maxArray = array ("sH"=> array(),
                       "sA"=> array(),
                       "nH"=> array(),
                       "nA"=> array(),
                       "Tor"=> array());
    $games = $this->liga->gamesSortedForTeam($team);
    foreach($games as $result){
      $partie = $result["partie"];
      if ($partie->hTore>-1 and $partie->gTore>-1) { // Ein normales Ergebnis?
        if ($partie->gTore > $partie->hTore) { // Gast hat gewonnen
          if($partie->heim == $team){ //Niederlage
            $next_index = count($maxArray["nH"]);
            if(count($maxArray["nH"]) < 1){
              $maxArray["nH"][0]["partie"]=$partie;
            } elseif (($maxArray["nH"][0]["partie"]->gTore - $maxArray["nH"][0]["partie"]->hTore) < ($partie->gTore - $partie->hTore)){
              unset($maxArray["nH"]);
              $maxArray["nH"][0]["partie"]=$partie;
            } elseif (($maxArray["nH"][0]["partie"]->gTore - $maxArray["nH"][0]["partie"]->hTore) == ($partie->gTore - $partie->hTore)){
              $maxArray["nH"][$next_index]["partie"]=$partie;
            }
          } elseif ($partie->gast == $team){ // Sieg
            $next_index = count($maxArray["sA"]);
            if(count($maxArray["sA"]) < 1){
              $maxArray["sA"][0]["partie"]=$partie;
            } elseif (($maxArray["sA"][0]["partie"]->gTore - $maxArray["sA"][0]["partie"]->hTore) < ($partie->gTore - $partie->hTore)){
              unset($maxArray["sA"]);
              $maxArray["sA"][0]["partie"]=$partie;
            } elseif (($maxArray["sA"][0]["partie"]->gTore - $maxArray["sA"][0]["partie"]->hTore) == ($partie->gTore - $partie->hTore)){
              $maxArray["sA"][$next_index]["partie"]=$partie;
            }
          }
        } elseif ($partie->gTore < $partie->hTore) { // Heim hat gewonnen
          if($partie->heim == $team){ //Sieg
            $next_index = count($maxArray["sH"]);
            if(count($maxArray["sH"]) < 1){
              $maxArray["sH"][0]["partie"]=$partie;
            } elseif (($maxArray["sH"][0]["partie"]->hTore - $maxArray["sH"][0]["partie"]->gTore) < ($partie->hTore - $partie->gTore)){
              unset($maxArray["sH"]);
              $maxArray["sH"][0]["partie"]=$partie;
            } elseif (($maxArray["sH"][0]["partie"]->hTore - $maxArray["sH"][0]["partie"]->gTore) == ($partie->hTore - $partie->gTore)){
              $maxArray["sH"][$next_index]["partie"]=$partie;
            }
          } elseif ($partie->gast == $team){ //Niederlage
            $next_index = count($maxArray["nA"]);
            if(count($maxArray["nA"]) < 1){
              $maxArray["nA"][0]["partie"]=$partie;
            } elseif (($maxArray["nA"][0]["partie"]->hTore - $maxArray["nA"][0]["partie"]->gTore) < ($partie->hTore - $partie->gTore)){
              unset($maxArray["nA"]);
              $maxArray["nA"][0]["partie"]=$partie;
            } elseif (($maxArray["nA"][0]["partie"]->hTore - $maxArray["nA"][0]["partie"]->gTore) == ($partie->hTore - $partie->gTore)){
              $maxArray["nA"][$next_index]["partie"]=$partie;
            }
          }

        }
        $next_index = count($maxArray["Tor"]);
        if(count($maxArray["Tor"]) < 1){
          $maxArray["Tor"][0]["partie"]=$partie;
        } elseif (($maxArray["Tor"][0]["partie"]->gTore + $maxArray["Tor"][0]["partie"]->hTore) < ($partie->gTore + $partie->hTore)){
          unset($maxArray["Tor"]);
          $maxArray["Tor"][0]["partie"]=$partie;
        } elseif (($maxArray["Tor"]["0"]["partie"]->gTore + $maxArray["Tor"][0]["partie"]->hTore) == ($partie->gTore + $partie->hTore)){
          $maxArray["Tor"][$next_index]["partie"]=$partie;
        }
      }
    }
    return $maxArray;
  }

  /**
   * Berechnung des Saisonverlaufs für ein Team
   *
   * @param teamObject $teama Referenz auf ein TeamObject A
   * @return array Saisonverlauf des Teams
   */
  function getVerlaufTeam(&$team) {
    $tableArray = $this->liga->calcTable($this->liga->options->keyValues['Rounds'],"all",TRUE);
    foreach($tableArray as $zeile){
      if($zeile["team"] == $team){
        $positionen["A"] = $zeile["possp"];
        break;
      }
    }
    return $positionen;
  }

  /**
   * Berechnung des Saisonverlaufs für zwei Teams
   *
   * @param teamObject $teama Referenz auf ein TeamObject A
   * @param teamObject $teamb Referenz auf ein TeamObject B
   * @return array Saisonverlauf der Teams
   */
  function getVerlaufTeams(&$teama, &$teamb) {
    $tableArray = $this->liga->calcTable($this->liga->options->keyValues['Rounds'],"all",TRUE);
    foreach($tableArray as $zeile){
      if($zeile["team"] == $teama){
        $positionen["A"] = $zeile["possp"];
      } elseif ($zeile["team"] == $teamb){
        $positionen["B"] = $zeile["possp"];
      }
    }
    return $positionen;
  }

  /**
   * Ausgabe der Serie als HTML
   *
   * @author Marcus Schug <lmo@marcus.schug.info>
   * @param array Array mit Serien analog Rückgabewert von getSerien(()
   * @return string Serie als HTML
   */
  function SerieToHTML($serienArray){
    $output = '';
    $serie = FALSE;
    if($serienArray['s']>0){
      $output = $serienArray['s'].' Sieg(e)';
    }
    elseif($serienArray['u']>0){
      $output = $serienArray['u'].' Unentschieden';
    }
    elseif($serienArray['n']>0){
      $output = $serienArray['n'].' Niederlage(n)';
    }
    if($serienArray['nu']>0){
      if( $output != '') $output .='<br>';
      $output .= $serienArray['nu'].' Spiele o. Sieg';
    }
    if($serienArray['su']>0){
      if($output != '') $output .='<br>';
      $output = $serienArray['su'].' Spiele o. Niederlage';
    }
    return $output;
  }  // END SerieToHTML()

} // END class Stats
?>
