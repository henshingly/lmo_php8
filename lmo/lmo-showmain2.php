<?php
/** Liga Manager Online 4
  *
  * http://lmo.sourceforge.net/
  *
  * This program is free software; you can redistribute it and/or
  * modify it under the terms of the GNU General Public License as
  * published by the Free Software Foundation; either version 2 of
  * the License, or (at your option) any later version.
  *
  * This program is distributed in the hope that it will be useful,
  * but WITHOUT ANY WARRANTY; without even the implied warranty of
  * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
  * General Public License for more details.
  *
  * REMOVING OR CHANGING THE COPYRIGHT NOTICES IS NOT ALLOWED!
  *
  */
if (!defined('PATH_TO_LMO')) {
    exit;  // kein Direktaufruf: diese Datei wird nur ueber LMO eingebunden
}

/**
 * Diese Datei wird eingebunden und erwartet:
 *
 * @var \Lmo\Liga\LigaDaten $ligaDaten Daten der geladenen Liga (lmo-ligadaten.php)
 * @var array<int|string, mixed> $text Sprachtexte
 * @var string $file Ligadatei relativ zum Ligenordner, leer wenn keine geladen ist
 * @var int|string $st gewaehlter Spieltag
 * @var string $action gewaehlte Seite (Aufrufparameter)
 * @var string $diroutput Ordner fuer erzeugte Dateien (Konfiguration)
 *
 * Einstellungen:
 * @var int|string $backlink Einstellung aus cfg.txt
 * @var int|string $calctime Einstellung aus cfg.txt
 * @var int|string $einsavehtml Einstellung aus cfg.txt
 * @var int|string $einspieler Einstellung aus cfg.txt
 * @var int|string $einsprachwahl Einstellung aus cfg.txt
 * @var int|string $eintippspiel Einstellung aus cfg.txt
 * @var int|string $tabonres Einstellung aus cfg.txt
 * @var int|string $tipp_immeralle Einstellung aus tipp/cfg.txt
 * @var int|string $tipp_ligenzutippen Einstellung aus tipp/cfg.txt
 *
 * Weitere Variablen des einbindenden Codes:
 * @var mixed $spieler_ligalink
 * @var mixed $startzeit
 *
 * Werden auch in dieser Datei gesetzt, aber nicht auf jedem Weg (koennen von aussen kommen):
 * @var mixed $ste
 */



$addm = $_SERVER['PHP_SELF'] . '?file=' . $file . '&amp;action=';
// Einstellungen der geladenen Liga mit Vorgabewerten (Lmo\Liga\Einstellungen). Ohne geladene Liga die einer
// leeren Liga; eingebundene Seiten und das Tippspiel fuehren ihre eigenen, deshalb ein eigener Name.
$lmo_main_e = (new \Lmo\Liga\Rohdaten\Liga())->einstellungen();
if ($file != '') {
    require(PATH_TO_LMO . '/lmo-openfile.php');
    if ($file != '' && isset($lmo_liga)) {
        $lmo_main_e = $lmo_liga->einstellungen();
    }
    if ($file != '') {
        if (empty($_GET['endtab'])) {
            $endtab = $lmo_main_e->spieltage();
            $ste = $st;
            $tabdat = '';
        } else {
            $endtab = $_GET['endtab'];
            $tabdat = $endtab . '. ' . $text[2];
            $ste = $endtab;
        }
        if (!empty($_GET['st'])) {
            $tabdat = $st . '. ' . $text[2];
        }
        if (empty($_REQUEST['action']) && $action == '') {
            switch ($lmo_main_e->laufendeTabelle()) {
                case '0': $action = 'results';break;
                case '1': $action = 'table';break;
                case '2': $action = 'program';break;
                case '3': $action = 'cross';break;
                case '4': $action = 'graph';break;
                case '5': $action = 'stats';break;
                case '6': $action = 'cal';break;
                case '7': $action=  'spieler';break;
            }
        }
    }
}

// Alle Teile für die Startansicht
$output_titel = '';
$output_html_lang = '';
$output_sprachauswahl = '';
$output_kalender = '';
$output_ergebnisse = '';
$output_tabelle = '';
$output_spielplan = '';
$output_kreuztabelle = '';
$output_fieberkurve = '';
$output_ligastatistik = '';
$output_spielerstatistik = '';
$output_info = '';
$output_hauptteil = '';
$output_ligenuebersicht = '';
$output_savehtml = '';
$output_letzteauswertung = '';
$output_berechnungszeit = '';
$output_stylesheet = '';
$output_javascript = '';
$p1 = '';

if (!defined('LMO_TEMPLATE')) define('LMO_TEMPLATE', 'lmo-standard.tpl.php');

// Wenn ein Template der Form [liganame].tpl.php existiert, wird dieses benutzt. Das ermöglicht
// die Nutzung verschiedener Templates für unterschiedliche Ligen
$template = new LMO_Template(PATH_TO_TEMPLATEDIR);
if (file_exists(PATH_TO_TEMPLATEDIR . '/' . basename($file) . '.tpl.php')) {
    $template->loadTemplatefile(basename($file) . '.tpl.php');
} else {
    $template->loadTemplatefile(LMO_TEMPLATE);
}

// Titel
if ($file != '') {
    $output_titel .= $lmo_main_e->name();
} else {
    $output_titel .= $action == 'tipp' ? $text['tipp'][0] : $text[53];
}

// Output <html lang=""> with ISO language codes in Template
$output_html_lang .= $text[798];

// Stylesheet
$output_stylesheet .= '  <link type="text/css" rel="stylesheet" href="' . URL_TO_LMO . '/lmo-style-nc.php">
  <style type="text/css">@import url("' . URL_TO_LMO . '/lmo-style.php");</style>';

// Javascript
$output_javascript .= '<!-- Dieser Container dient als das schwebende Fenster -->
<div id="globalLMOTooltip" class="lmo-smart-tooltip"></div>

<script>
// Das Tooltip-Element referenzieren
const sportTooltip = document.getElementById("globalLMOTooltip");

function showLMOTooltip(element) {
  // Text aus dem data-info Attribut auslesen
  const infoText = element.getAttribute("data-info");
  if (!infoText) return;

  // Inhalt in das Fenster schreiben und sichtbar machen
  sportTooltip.innerHTML = infoText;
  sportTooltip.style.visibility = "visible";
  sportTooltip.style.opacity = "1";

  // Position des SVG-Icons auf dem Bildschirm ermitteln
  const rect = element.getBoundingClientRect();
  const winW = window.innerWidth;
  const winH = window.innerHeight;

  // Standard-Position: Direkt unter dem Icon (8px Abstand)
  let top = rect.bottom + window.scrollY + 8;
  let left = rect.left + window.scrollX;

  // Fixed Koordinaten
  sportTooltip.style.position = "fixed";
  top = rect.bottom + 8;
  left = rect.left;

  // AUTO-KORREKTUR: Unten
  if (top + sportTooltip.offsetHeight > winH) {
    // Über dem Icon anzeigen
    top = rect.top - sportTooltip.offsetHeight - 8;
  }

  // AUTO-KORREKTUR: Rechts
  if (left + sportTooltip.offsetWidth > winW) {
    // Nach links verschieben, mit 15px Sicherheitsabstand zum Rand
    left = winW - sportTooltip.offsetWidth - 15;
  }

  // Falls das Icon ganz links am Rand ist, Mindestabstand einhalten
  if (left < 10) left = 10;

  // Positionswerte zuweisen
  sportTooltip.style.top = top + "px";
  sportTooltip.style.left = left + "px";
}

function hideLMOTooltip() {
  // Fenster wieder ausblenden
  sportTooltip.style.visibility = "hidden";
  sportTooltip.style.opacity = "0";
}
</script>';

// Sprachauswahl
if ($einsprachwahl == 1) {
    $output_sprachauswahl = getLangSelector();
}

ob_start();
if ($file != '') {
    if (!$lmo_main_e->istPokal()) { // Für normale Ligen

        // Kalenderlink
        if ($lmo_main_e->mitKalender()) {
            $output_kalender .= $action != 'cal' ? '<a href="' . $addm . 'cal&amp;st=' . $st . '" title="' . $text[141] . '">' . $text[140] . '</a>' : $text[140];
            $output_kalender .= '&nbsp;&nbsp;';
        }
        // Ergebnis/Tabelle
        if ($tabonres == 0) {
            if ($lmo_main_e->mitErgebnissen()) {
                $output_ergebnisse .= $action != 'results' ? '<a href="' . $addm . 'results&amp;st=' . $ste . '" title="' . $text[11] . '">' . $text[10] . '</a>' : $text[10];
                $output_ergebnisse .= '&nbsp;&nbsp;';
            }
            if ($lmo_main_e->mitTabelle()) {
                $output_tabelle .= $action != 'table' ? '<a href="' . $addm . 'table" title="' . $text[17] . '">' . $text[16] . '</a>' : $text[16];
                $output_tabelle .= '&nbsp;&nbsp;';
            }
            // Kombinierte Ansicht
        } else {
            if ($lmo_main_e->mitErgebnissen()) {
                $output_ergebnisse .= $action != 'results' && $action != 'table' ? '<a href="' . $addm . 'results" title="' . $text[104] . '">' . $text[10] . '/' . $text[16] . '</a>' : $text[10] . '/' . $text[16];
                $output_ergebnisse .= '&nbsp;&nbsp;';
            }
        }

        // Kreuztabelle
        if ($lmo_main_e->mitKreuztabelle()) {
            $output_kreuztabelle .= $action != 'cross' ? '<a href="' . $addm . 'cross" title="' . $text[15] . '">' . $text[14] . '</a>' : $text[14];
            $output_kreuztabelle .= '&nbsp;&nbsp;';
        }
        // Spielplan
        if ($lmo_main_e->mitSpielplan()) {
            $output_spielplan .= $action != 'program' ? '<a href="' . $addm . 'program" title="' . $text[13] . '">' . $text[12] . '</a>' : $text[12];
            $output_spielplan .= '&nbsp;&nbsp;';
        }
        // Fieberkurve
        if ($lmo_main_e->mitFieberkurve()) {
            $output_fieberkurve .= $action != 'graph' ? '<a href="' . $addm . 'graph" title="' . $text[134] . '">' . $text[133] . '</a>' : $text[133];
            $output_fieberkurve .= '&nbsp;&nbsp;';
        }
        // Ligastatistiken
        if ($lmo_main_e->mitLigastatistik()) {
            $output_ligastatistik .= $action != 'stats' ? '<a href="' . $addm . 'stats&amp;stat1=' . $ligaDaten->stat1 . '&amp;stat2=' . $ligaDaten->stat2 . '" title="' . $text[19] . '">' . $text[18] . '</a>' : $text[18];
            $output_ligastatistik .= '&nbsp;&nbsp;';
        }
    } else { // Für Pokalligen

        // Kalenderlink
        if ($lmo_main_e->mitKalender()) {
            $output_kalender .= $action != 'cal' ? '<a href="' . $addm . 'cal&amp;st=' . $st . '" title="' . $text[141] . '">' . $text[140] . '</a>' : $text[140];
            $output_kalender .= '&nbsp;&nbsp;';
        }
        // Ergebnisse
        if ($lmo_main_e->mitErgebnissen()) {
            $output_ergebnisse .= $action != 'results' ? '<a href="' . $addm . 'results&amp;st=' . $ste . '" title="' . $text[11] . '">' . $text[10] . '</a>' : $text[10];
            $output_ergebnisse .= '&nbsp;&nbsp;';
        }
        // Spielplan
        if ($lmo_main_e->mitSpielplan()) {
            $output_spielplan .= $action != 'program' ? '<a href="' . $addm . 'program" title="' . $text[13] . '">' . $text[12] . '</a>' : $text[12];
            $output_spielplan .= '&nbsp;&nbsp;';
        }
    }
    $output_info .= $action != 'info' ? '<a href="' . $addm . 'info" title="' . $text[21] . '">' . $text[20] . '</a>' : $text[20];

    $druck = 0;

    if ($action != 'tipp') {
        if (!$lmo_main_e->istPokal()) {
            // Normale Liga
            switch($action) {
                case 'cal': if ($lmo_main_e->mitKalender()) {require(PATH_TO_LMO . '/lmo-cal.php');}break;
                case 'results': if ($lmo_main_e->mitErgebnissen()) {$druck = 1;require(PATH_TO_LMO . '/lmo-showrestab.php');}break;
                case 'table': if ($lmo_main_e->mitTabelle()) {$druck = 1;require(PATH_TO_LMO . '/lmo-showrestab.php');}break;
                case 'cross': if ($lmo_main_e->mitKreuztabelle()) {require(PATH_TO_LMO . '/lmo-showcross.php');}break;
                case 'program': if ($lmo_main_e->mitSpielplan()) {require(PATH_TO_LMO . '/lmo-showprogram.php');}break;
                case 'graph': if ($lmo_main_e->mitFieberkurve()) {require(PATH_TO_LMO . '/lmo-showgraph.php');}break;
                case 'stats': if ($lmo_main_e->mitLigastatistik()) {require(PATH_TO_LMO . '/lmo-showstats.php');}break;
                case '': /*Auswahlseite*/break;
            }
        } else {
            // Pokal Liga
            switch($action) {
                case 'cal': if ($lmo_main_e->mitKalender()) {require(PATH_TO_LMO . '/lmo-kocal.php');}break;
                case 'results': if ($lmo_main_e->mitErgebnissen()) {require(PATH_TO_LMO . '/lmo-showkoresults.php');}break;
                case 'program': if ($lmo_main_e->mitSpielplan()) {require(PATH_TO_LMO . '/lmo-showkoprogram.php');}break;
            }
        }
        // Spieler-Addon
        if ($action == 'spieler') {
            if ($lmo_main_e->mitToren()) {
                require(PATH_TO_ADDONDIR .'/spieler/lmo-statshow.php');
            }
        }
        // Spieler-Addon
    }
    if ($action == 'info') {require(PATH_TO_LMO . '/lmo-showinfo.php');}
    $p0 = 'p1';
    $$p0 = c(1).c(0);
} elseif ($backlink == 1 && $action != 'tipp') {require(PATH_TO_LMO . '/lmo-showdir.php');}

if ($action == 'tipp' && $eintippspiel == 1) {require(PATH_TO_ADDONDIR . '/tipp/lmo-tippstart.php');}
$output_hauptteil .= ob_get_contents();
ob_end_clean();

if ($file != '' && isset($stand)) {
    // Letzte Auswertung
    $output_letzteauswertung .= $text[406] . ':&nbsp;' . $stand;

    // SaveHTML
    if ($einsavehtml == 1) {
        ob_start();?>

        <table width="100%" cellspacing="0" cellpadding="0" border="0">
          <tr>
<?php
        if (!$lmo_main_e->istPokal() && isset($druck) && $druck == 1) {
            include(PATH_TO_LMO . '/lmo-savehtml.php');
            include(PATH_TO_LMO . '/lmo-savehtml1.php');
        }?>
            <td align="center"><?php
        if (!$lmo_main_e->istPokal() && isset($druck) && $druck == 1 && file_exists(PATH_TO_LMO . '/' . $diroutput . basename($file) . '-st.html')) {echo '<a href="' . URL_TO_LMO . '/' . $diroutput . basename($file) . '-st.html" title="' . $text[477] . '">' . $text[478] . '</a>&nbsp;';}?>
            </td>
            <td align="center"><?php
        if (!$lmo_main_e->istPokal() && isset($druck) && $druck == 1 && file_exists(PATH_TO_LMO . '/' . $diroutput . basename($file) . '-sp.html')) {echo '<a href="' . URL_TO_LMO . '/' . $diroutput . basename($file) . '-sp.html" title="' . $text[479] . '">' . $text[480] . '</a>&nbsp;';}?>
            </td>
          </tr>
        </table><?php
        $output_savehtml .= ob_get_contents();
        ob_end_clean();
    }
    // PDF-Addon
    if (file_exists(PATH_TO_ADDONDIR . '/pdf/lmo-showmain2.inc.php')) include(PATH_TO_ADDONDIR . '/pdf/lmo-showmain2.inc.php');
    // PDF-Addon
}

// Ligenübersicht
if ($backlink == 1 && ($file != '' || $action == 'tipp')) {
    if (basename($file) == $file) {
        $output_ligenuebersicht .= '<a href="' . $_SERVER['PHP_SELF'] . '" title="' . $text[392] . '">' . $text[391] . '</a>&nbsp;&nbsp;&nbsp;';
    } else {
        $output_ligenuebersicht .= '<a href="' . $_SERVER['PHP_SELF'] . '?subdir=' . dirname($file) . '/" title="' . $text[392] . '">' . $text[391] . '</a>&nbsp;&nbsp;&nbsp;';
    }
}

// Berechnungszeit
if ($calctime == 1) {
    $output_berechnungszeit .= $text[471] . ': ' . number_format((getmicrotime() - $startzeit), 4, '.', ',') . ' ' . $text[799] . '.<br>';
}

// Spieler-Addon
if ($file != '' && $einspieler == 1 && $lmo_main_e->mitToren()) {
    include(PATH_TO_ADDONDIR . '/spieler/lmo-statloadconfig.php');
    $output_spielerstatistik .= $action != 'spieler' ? '<a href="' . $addm . 'spieler" title="' . $text['spieler'][12] . '">' . $spieler_ligalink . '</a>' : $spieler_ligalink;
    $output_spielerstatistik .= '&nbsp;&nbsp;';
}

// Ticker-Addon
$output_newsticker = '';
if ($file != '' && $lmo_main_e->mitNewsticker()) {
    ob_start();
    $tickerligen = $file;
    include(PATH_TO_ADDONDIR . '/ticker/ticker.php');
    $output_newsticker .= ob_get_contents();
    ob_end_clean();
}

// Tippspiel-Addon
$output_tippspiel = '';
if ($eintippspiel == 1) {
    if ($tipp_immeralle == 1 || str_contains($tipp_ligenzutippen, substr(basename($file), 0, -4))) {
        $output_tippspiel .= $action != 'tipp' ? '<a <a href="' . $addm . 'tipp" title="' . $text['tipp'][0] . '">' . $text['tipp'][0] : $text['tipp'][0];
    }
}
d($template->toString());
// Tippspiel-Addon

// Template ausgeben
$template->setVariable('Ligenuebersicht', $output_ligenuebersicht);
$template->setVariable('Berechnungszeit', $output_berechnungszeit);
$template->setVariable('LetzteAuswertung', $output_letzteauswertung);
$template->setVariable('Savehtml', $output_savehtml);
$template->setVariable('Hauptteil', $output_hauptteil);
$template->setVariable('Tabelle', $output_tabelle);
$template->setVariable('Kreuztabelle', $output_kreuztabelle);
$template->setVariable('Fieberkurve', $output_fieberkurve);
$template->setVariable('Spielerstatistik', $output_spielerstatistik);
$template->setVariable('Ligastatistik', $output_ligastatistik);
$template->setVariable('Kalender', $output_kalender);
$template->setVariable('Ergebnisse', $output_ergebnisse);
$template->setVariable('Spielplan', $output_spielplan);
$template->setVariable('Info', $output_info);
$template->setVariable('HTML_LANG', $output_html_lang);
$template->setVariable('Infolink', $p1);
$template->setVariable('Sprachauswahl', $output_sprachauswahl);
$template->setVariable('Titel', $output_titel);
$template->setVariable('Stylesheet', $output_stylesheet);
$template->setVariable('Javascript', $output_javascript);
$template->setVariable('Newsticker', $output_newsticker);  // Ticker-Addon
$template->setVariable('Tippspiel', $output_tippspiel);    // Tippspiel-Addon
$template->show();

?>
