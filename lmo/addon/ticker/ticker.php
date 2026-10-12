<?php
/* Liga Manager Online 4
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
 *
*/

require_once(__DIR__ . '/../../init.php');

/**
 * Diese Datei wird direkt aufgerufen; init.php stellt bereit:
 *
 * @var array<int|string, mixed> $text Sprachtexte
 * @var string $dirliga Ligenordner relativ zum LMO (Konfiguration)
 *
 * Einstellungen:
 * @var int|string $ticker_standard_ligen Einstellung aus ticker/cfg.txt
 *
 * Werden auch in dieser Datei gesetzt, aber nicht auf jedem Weg (koennen von aussen kommen):
 * @var mixed $ticker_breite
 * @var mixed $ticker_geschwindigkeit
 * @var mixed $ticker_notizanzeigen
 * @var mixed $ticker_tickerart
 * @var mixed $ticker_tickertitel
 */

// Durch gesetzte $tickerart bestimmter Parameter (für include/require)
$ticker_tickerart = isset($tickerart) ? $tickerart : $ticker_tickerart;
$ticker_ligen = isset($tickerligen) ? $tickerligen : $ticker_standard_ligen;
$ticker_tickertitel = isset($tickertitel) ? $tickertitel : $ticker_tickertitel;
$ticker_notizanzeigen = isset($tickernotizen) ? $tickernotizen : $ticker_notizanzeigen;
$ticker_breite = isset($tickerbreite) ? $tickerbreite : $ticker_breite;
$ticker_geschwindigkeit = isset($tickergeschwindigkeit) ? $tickergeschwindigkeit : $ticker_geschwindigkeit;

$trenner = ' +++ ';
$array = array();
$hilf = $hilf1 = '';
$ticker_text = $dummy1 = $dummy2 = $dummy3 = $dummy4 = '';
?>

          <script type="text/javascript" src="<?php echo URL_TO_LMO; ?>/js/jquery.min.js"></script>
          <script type="text/javascript" src="<?php echo URL_TO_LMO;?>/js/jquery.marquee.min.js"></script>
          <script type="text/javascript">
            $(function(){$('.marquee').marquee();});
          </script>
          <div align="center">
<?php
if ($ticker_tickertitel == 1) { ?>
            <p><?php echo $text['ticker'][0];?></p><?php
}
if (!isset($file)) {
    $file = '';
}
$file2 = $file;
$ticker_array = explode(",", $ticker_ligen);

foreach($ticker_array as $file) {
    // je Liga neu beginnen: sonst stehen die Spiele der vorigen Ligen noch einmal bei der naechsten
    $hilf = $hilf1 = '';
    // Die Liga wird als Rohdaten gelesen (Lmo\Liga\Rohdaten\Liga); die Liga der Seite in $lmo_liga bleibt unberuehrt.
    $lmo_ticker_pfad = PATH_TO_LMO . '/' . $dirliga . $file;
    if (!empty($file) && file_exists($lmo_ticker_pfad) && check_hilfsadmin($file)) {
        $lmo_ticker_liga = substr($file, -4) == '.l98' ? \Lmo\Liga\Rohdaten\Liga::lies($lmo_ticker_pfad) : new \Lmo\Liga\Rohdaten\Liga();
        $lmo_ticker_e = $lmo_ticker_liga->einstellungen();
        // der aktuelle Spieltag der Liga
        $lmo_ticker_st = $lmo_ticker_e->aktuellerSpieltag();
        if($ticker_tickerart == 2) {
            // Zeilen des Newstickers aus [News]; NC ist nur deren Anzahl
            foreach ($lmo_ticker_liga->news as $lmo_schl => $lmo_zeile) {
                if ($lmo_schl != 'NC' && strlen(stripslashes($lmo_zeile)) > 0) {
                    $hilf .= $trenner . stripslashes($lmo_zeile);
                }
            }
            $ticker_text .= $hilf;
        }
        else {
            // die Paarungen des Spieltags und ihre Spiele (Lmo\Liga\Paarung, Lmo\Liga\Spiel); in der Liga je eines
            foreach ($lmo_ticker_liga->paarungen($lmo_ticker_st) as $lmo_paarung) {
                if (!(($lmo_paarung->heim > 0) && ($lmo_paarung->gast > 0))) {
                    continue;
                }
                $lmo_heim = $lmo_paarung->heimMannschaft()->anzeigename();
                $lmo_gast = $lmo_paarung->gastMannschaft()->anzeigename();
                $lmo_favteam = $lmo_ticker_e->lieblingsmannschaft();
                foreach ($lmo_paarung->spiele as $lmo_spiel) {
                    $lmo_zusatz = $lmo_spiel->zusatzText($text[0], $text[1]);
                    if ($lmo_zusatz == '&nbsp;') {
                        $mspezhilf = '';
                    }
                    else {
                        $mspezhilf = ' ' . $lmo_zusatz;
                    }
                    if (!($lmo_favteam == $lmo_paarung->heim || $lmo_favteam == $lmo_paarung->gast || $ticker_tickerart == 1)) {
                        continue;
                    }
                    $lmo_ergebnis = $lmo_heim . " - " . $lmo_gast . " " . $lmo_spiel->toreHeimText($lmo_ticker_e->torfaktor()) . ":" . $lmo_spiel->toreGastText($lmo_ticker_e->torfaktor()) . $mspezhilf;
                    if (!$lmo_ticker_e->istPokal()) {
                        if ($lmo_spiel->wertung == 1) {
                            $dummy1 = $text['ticker'][2] . ':' . addslashes($lmo_heim . ' ' . $text[211]);
                        }
                        else {
                            $dummy1 = '';
                        }
                        if ($lmo_spiel->wertung == 2) {
                            $dummy2 = $text['ticker'][2] . ':' . addslashes($lmo_gast . ' ' . $text[211]);
                        }
                        else {
                            $dummy2 = '';
                        }
                        if ($lmo_spiel->wertung == 3) {
                            $dummy3 = $text['ticker'][2] . ':' . addslashes($text['ticker'][3]);
                        }
                        else {
                            $dummy3 = '';
                        }
                        if ($lmo_spiel->notiz != '' && $ticker_notizanzeigen == 1) {
                            $dummy4 = ' Notiz' . ': ' . $lmo_spiel->notiz;
                        }
                        else {
                            $dummy4 = '';
                        }
                        $hilf = $hilf . $lmo_ergebnis . $dummy1 . $dummy2 . $dummy3 . $dummy4 . $trenner;
                    }
                    else {
                        if ($lmo_spiel->notiz != '' && $ticker_notizanzeigen == 1) {
                            $dummy4 = ' ' . $text[22] . ': ' . $lmo_spiel->notiz;
                        }
                        else {
                            $dummy4 = '';
                        }
                        $hilf1 = $hilf1 . $lmo_ergebnis . $dummy4 . $trenner;
                    }
                }
            }
        }
        $ticker_text .= " $trenner {$lmo_ticker_e->name()} ({$lmo_ticker_st}{$text['ticker'][1]}): $hilf $hilf1";
    }
    else {
        // anhaengen statt ersetzen: eine fehlende Liga loescht nicht den Text der anderen
        $ticker_text .= $text[224] . $trenner;
    }
} //foreach
$ticker_formnumber = 't' . substr(md5(microtime()), 3, 4);
$file = $file2;
?>

            <div data-duration="<?php echo $ticker_geschwindigkeit;?>" class="marquee" style="width: <?php echo $ticker_breite;?>em; overflow: hidden; background-color: var(--bs-secondary-bg-subtle);"><?php echo $ticker_text;?></div>
          </div>
        