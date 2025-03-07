<?php
/**
 * Updatefunktion für Addons
 *
 * @param string $fileName
 */
function updateAddons($fileName) {
    include PATH_TO_LMO . '/init.php';
    //Importieren der Konfigurations-Variablen. Alternativ müssten alle gebrauchten Variabeln hier als global deklariert werden
    include PATH_TO_LMO . '/lmo-cfgload.php';
    //Die restlichen nötigen Variabeln fürs Tippspiel als global deklarieren
    global $text;
    global $punkte1;
    global $punkte2;
    global $punkte3;
    global $punkte4;
    global $punkte5;
    global $punkte6;

    //Falls diese Datei geändert wird, empfiehlt es sich, alle Fehler
    //anzeigen zu lassen, um evtl. nicht gesetzte Variablen frühzeitig zu erkennen
    //error_reporting(E_ALL);
    $liga = basename($fileName, '.l98');
    $file = $liga . '.l98';
    $action = 'admin';
    $array = array();
    //Liga-Datei öffnen
    include PATH_TO_LMO . '/lmo-openfile.php';

    // SAVEHTML
    //HTML-Ausgabe erstellen
    if ($einsavehtml == 1) {
        include(PATH_TO_LMO . '/lmo-savehtml.php');
        include(PATH_TO_LMO . '/lmo-savehtml1.php');
    }
    // SAVEHTML

    // ZUSTAT
    //Statistiken aktualisieren
    if ($einzutore == 1 || $einzutoretab == 1 || $einzustats == 1) {
        include PATH_TO_LMO . '/lmo-zustat.php';
    }
    // ZUSTAT

    // ADDON: TIPPSPIEL
    //Ermittelt, ob die Liga getippt werden darf
    $ftest0 = 1;
    if ($tipp_immeralle == 0) {
        $ftest0 = 0;
        $ftest1 = '';
        $ftest1 = explode(',', $tipp_ligenzutippen);
        if (isset($ftest1)) {
            for ($u = 0; $u < count($ftest1); $u++) {
                if ($ftest1[$u] == $liga) {
                    $ftest0 = 1;
                }
            }
        }
    }
    // Neu-Auswertung des Tippspiels
    if ($ftest0 == 1) {       // Liga darf getippt werden
        $st = 0;              // alle Spieltage auswerten
        $todo = 'tipp';
        if ($tipp_aktauswert == 1) {
            require(PATH_TO_ADDONDIR . '/tipp/lmo-tippsavewert.php');
        }
        if ($tipp_aktauswertges == 1) {
            require(PATH_TO_ADDONDIR . '/tipp/lmo-tippsavewertgesamt.php');
        }
    }
    // ADDON: TIPPSPIEL
}
?>