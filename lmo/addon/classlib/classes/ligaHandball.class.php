<?php
/**
 *
 * Bildet eine Handballliga als Objekt ab
 *
 * @package   classLib
 * @since classlib V2.7
 * @version  liga.class.php,v 2.7 2005/10/12 13:34:43
*/
class ligaHandball extends liga {

  //const Ligatype = "Handball";

  /**
   * Sortiert die errechnete Tabelle und gibt diese als Array zurück
   *  (§43 DHB) : Pkt - (Anzahl Spiele) - Direkter Vergleich(Pkt/Differenz Tore)
   *    Absatz 2 ist außer Acht gelassen worden
   *
   * @access protected
   * @param  array $tableArray Die zu sortierende Tabelle
   * @return array
   */
  function sortTable($tableArray) {
    foreach($tableArray as $table) {
      $sort_pPkt[] = $table["pPkt"];
      $sort_spiele[] = $table["spiele"];
    }
    // Sortierung PlusPkt / Anzahl Spiele
    array_multisort($sort_pPkt,SORT_DESC, $sort_spiele,SORT_ASC, $tableArray,SORT_DESC);
    // BEGIN Direkter Vergleich
    $subteams = array();
    $pPkt = 0;
    $spiele = 0;
    for ($position = 0; $position < count($tableArray); $position++) {
      if($pPkt == $tableArray[$position]["pPkt"] && $spiele == $tableArray[$position]["spiele"]) {
        $subteams[$tableArray[$position]["team"]->nr] = $tableArray[$position]["team"];
      } else {
        if(count($subteams)>1) {
          $tmp_table = $this->calcTableforTeams($subteams);
          $tmp_tablearray = $tableArray;
          $nextpos = $position - count($tmp_table) ;
          for ($b = 0; $b < count($tmp_table); $b++) {
            for($f = $nextpos; $f < $position; $f++) {
              if($tmp_tablearray[$f]["team"]===$tmp_table[$b]["team"]) {
                $tableArray[$nextpos+$b] = $tmp_tablearray[$f];
              }
            }
          }
        }  // END if(count($subteams)>1)
        $subteams = array();
        $pPkt = $tableArray[$position]["pPkt"];
        $spiele = $tableArray[$position]["spiele"];
        $subteams[$tableArray[$position]["team"]->nr] = $tableArray[$position]["team"];
      }
    }  // END for ($abc = 0; $abc < count($tableArray); $abc++)
    // END Direkter Vergleich
    for ($i= 0;$i<count($tableArray);$i++) { // Position setzen
      $tableArray[$i]["pos"]=$i+1;
    }
    return $tableArray;
  }

  /**
   * Sortiert die errechnete Tabelle bei Direktem Vergleich und gibt diese als Array zurück
   *   Sortierung PlusPkt / Anzahl Spiele / Differenz Tore
   *
   * @access protected
   * @param  array $tableArray Die zu sortierende Tabelle
   * @return array
   */
  function sortDirectTable($tableArray) {
    foreach($tableArray as $table) {
      $sort_pPkt[] = $table["pPkt"];
      $sort_spiele[] = $table["spiele"];
      $sort_dTor[] = $table["dTor"];
    }
    array_multisort($sort_pPkt,SORT_DESC, $sort_spiele,SORT_ASC, $sort_dTor,SORT_DESC, $tableArray,SORT_DESC);
    for ($i= 0;$i<count($tableArray);$i++) { // Position setzen
      $tableArray[$i]["pos"]=$i+1;
    }
    return $tableArray;
  }

}  // END CLass HandballLiga

?>