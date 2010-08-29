<?php
/**
 *
 * Bildet eine Fussball Liga als Objekt ab
 *
 * @package   classLib
 * @since classlib V2.7
 * @version  liga.class.php,v 2.7 2005/10/12 13:34:43
 */
class ligaFussball extends liga {

  /**
   * Sortiert die errechnete Tabelle und gibt diese als Array zurück
   *   - Pkt - (Anzahl Spiele) - Differenz Tore - geschossene Tore -
   *     - das Gesamtergebnis aus Hin- und Rückspiel im direkten Vergleich
   *     - die Anzahl der auswärts erzielten Tore im direkten Vergleich
   *     - die Anzahl aller auswärts erzielten Tore
   *
   * @access protected
   * @param  array $tableArray Die zu sortierende Tabelle
   * @return array
   */
  function sortTable($tableArray) {
    foreach($tableArray as $table) {
      $sort_pPkt[] = $table["pPkt"];
      $sort_spiele[] = $table["spiele"];
      $sort_dTor[] = $table["dTor"];
      $sort_pTor[] = $table["pTor"];
    }
    // ASC = auf-, DESC = absteigend
    array_multisort($sort_pPkt,SORT_DESC, $sort_spiele,SORT_ASC, $sort_dTor,SORT_DESC, $sort_pTor,SORT_DESC, $tableArray,SORT_DESC);
    for ($i=0; $i < count($tableArray);$i++) {
      if ($i > 200) {
        die("Fehler im Script");
      }
      if ( $sort_pPkt[$i] == $sort_pPkt[$i+1] && $sort_spiele[$i] == $sort_spiele[$i+1]
        && $sort_dTor[$i] == $sort_dTor[$i+1] && $sort_pTor[$i] == $sort_pTor[$i+1]) {
        // Partien für den Direkten Vergleich suchen.
        $allParties = $this->allPartieForTeams($tableArray[$i]['team'],$tableArray[$i+1]['team'],true);
        foreach ($allParties as $partie) {
          $tore[$partie->heim->nr] += $partie->hTore > -1? $partie->hTore:0;
          $tore[$partie->gast->nr] += $partie->gTore>-1? $partie->gTore:0;
          $gastTore[$partie->gast->nr] = $partie->gTore>-1? $partie->gTore:0;
        }
        // das Gesamtergebnis aus Hin- und Rückspiel im direkten Vergleich
        if ($tore[$tableArray[$i]['team']->nr] == $tore[$tableArray[$i+1]['team']->nr]) {
          // die Anzahl der auswärts erzielten Tore im direkten Vergleich
          if ( $gastTore[$tableArray[$i]['team']->nr] == $gastTore[$tableArray[$i+1]['team']->nr] ) {
            unset ($tore);
            // die Anzahl aller auswärts erzielten Tore
            foreach ($this->spieltage as $spieltag) {
              foreach ($spieltag->partien as $partie) {
                $tore[$partie->gast->nr] += $partie->gTore>-1? $partie->gTore:0;
              }
            }
          } else {
            $tore[$tableArray[$i]['team']->nr] = $gastTore[$tableArray[$i]['team']->nr];
            $tore[$tableArray[$i+1]['team']->nr] = $gastTore[$tableArray[$i+1]['team']->nr];
          }
        }
        // Auswertung des Direkten Vergleichs
        if ($tore[$tableArray[$i]['team']->nr] < $tore[$tableArray[$i+1]['team']->nr]) {
          $newTable[$i] = $tableArray[$i+1];
          $newTable[$i+1] = $tableArray[$i];
          $newTable[$i]['pos'] = ++$i;
        } else {
          $newTable[$i] = $tableArray[$i];
        }
      } else {  // END if ($sort_pPkt[$i] == $sort...
        $newTable[$i] = $tableArray[$i];
      }
      $newTable[$i]['pos'] = $i+1;
    }
    return $newTable;
  } // END function sortTable

  function sortDirectTable($tableArray) {
    echo "function sortDirectTable($tableArray) {";
    return false;
  }

} // END class FussballLiga

?>