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
        $sort_pPkt = $sort_spiele = array();
        foreach($tableArray as $table) {
            $sort_pPkt[] = $table['pPkt'];
            $sort_spiele[] = $table['spiele'];
        }
        // Sortierung PlusPkt / Anzahl Spiele
        array_multisort($sort_pPkt, SORT_DESC, $sort_spiele, SORT_ASC, $tableArray, SORT_DESC);
        // Direkter Vergleich bei gleichen Punkten und gleicher Anzahl Spiele
        $tableArray = $this->sortTiedGroups($tableArray, array('pPkt', 'spiele'));
        for ($i = 0; $i < count($tableArray); $i++) { // Position setzen
            $tableArray[$i]['pos'] = $i + 1;
        }
        return $tableArray;
    }

    /**
    * Vergleich im direkten Vergleich: Punkte, Anzahl Spiele, Tordifferenz (wie sortDirectTable)
    *
    * @access protected
    * @return integer
    */
    function compareDirect($a, $b) {
        return array($b['pPkt'], $a['spiele'], $b['dTor']) <=> array($a['pPkt'], $b['spiele'], $a['dTor']);
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
        $sort_pPkt = $sort_spiele = $sort_dTor = array();
        foreach($tableArray as $table) {
            $sort_pPkt[] = $table['pPkt'];
            $sort_spiele[] = $table['spiele'];
            $sort_dTor[] = $table['dTor'];
        }
        array_multisort($sort_pPkt, SORT_DESC, $sort_spiele, SORT_ASC, $sort_dTor, SORT_DESC, $tableArray, SORT_DESC);
        for ($i = 0; $i < count($tableArray); $i++) { // Position setzen
            $tableArray[$i]['pos'] = $i + 1;
        }
        return $tableArray;
    }

}  // END CLass HandballLiga

?>