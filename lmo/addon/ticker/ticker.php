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
 * @var \Lmo\Liga\LigaDaten $ligaDaten Daten der geladenen Liga (lmo-ligadaten.php)
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
$ligaDaten->msieg = 0;
$hilf = $hilf1 = '';
$ticker_text = $ligaDaten->mnote = $dummy1 = $dummy2 = $dummy3 = $dummy4 = '';
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
    require(PATH_TO_LMO . '/lmo-openfile.php');
    // lmo-openfile.php laesst bei einer fehlenden Liga die Daten der vorigen stehen
    if (isset($ligaDaten->lmtype) && $file != '' && file_exists(PATH_TO_LMO . '/' . $dirliga . $file)) {
        if($ticker_tickerart == 2) {
            if (isset($ligaDaten->nlines)) {
                for($i = 0; $i < count($ligaDaten->nlines); $i++) {
                    if(strlen($ligaDaten->nlines[$i]) > 0)
                    $hilf .= $trenner . $ligaDaten->nlines[$i];
                }
            }
            $ticker_text .= $hilf;
        }
        else {
            if ($ligaDaten->lmtype == 0) {
                for ($i = 0; $i < $ligaDaten->anzsp; $i++) {
                    if (($ligaDaten->teama[$ligaDaten->stx-1][$i] > 0) && ($ligaDaten->teamb[$ligaDaten->stx-1][$i] > 0) ) {
                        if ($ligaDaten->mspez[$ligaDaten->stx-1][$i] == '&nbsp;') {
                            $mspezhilf = '';
                        }
                        else {
                            $mspezhilf = ' ' . $ligaDaten->mspez[$ligaDaten->stx-1][$i];
                        }
                        if ($ligaDaten->favteam == $ligaDaten->teama[$ligaDaten->stx-1][$i] || $ligaDaten->favteam == $ligaDaten->teamb[$ligaDaten->stx-1][$i] || $ticker_tickerart == 1) {
                            if ($ligaDaten->msieg[$ligaDaten->stx-1][$i] == 1) {
                                $dummy1 = $text['ticker'][2] . ':' . addslashes($ligaDaten->teams[$ligaDaten->teama[$ligaDaten->stx-1][$i]] . ' ' . $text[211]);
                            }
                            else {
                                $dummy1 = '';
                            }
                            if ($ligaDaten->msieg[$ligaDaten->stx-1][$i] == 2) {
                                $dummy2 = $text['ticker'][2] . ':' . addslashes($ligaDaten->teams[$ligaDaten->teamb[$ligaDaten->stx-1][$i]] . ' ' . $text[211]);
                            }
                            else {
                                $dummy2 = '';
                            }
                            if ($ligaDaten->msieg[$ligaDaten->stx-1][$i] == 3) {
                                $dummy3 = $text['ticker'][2] . ':' . addslashes($text['ticker'][3]);
                            }
                            else {
                                $dummy3 = '';
                            }
                            if ($ligaDaten->mnote[$ligaDaten->stx-1][$i] != '' && $ticker_notizanzeigen == 1) {
                                $dummy4 = ' Notiz' . ': ' . $ligaDaten->mnote[$ligaDaten->stx-1][$i];
                            }
                            else {
                                $dummy4 = '';
                            }
                            $hilf = $hilf . $ligaDaten->teams[$ligaDaten->teama[$ligaDaten->stx-1][$i]] . " - " . $ligaDaten->teams[$ligaDaten->teamb[$ligaDaten->stx-1][$i]] . " " . applyFactor($ligaDaten->goala[$ligaDaten->stx-1][$i], $ligaDaten->goalfaktor) . ":" . applyFactor($ligaDaten->goalb[$ligaDaten->stx-1][$i], $ligaDaten->goalfaktor) . $mspezhilf . $dummy1 . $dummy2 . $dummy3 . $dummy4 . $trenner;
                        }
                    }
                }  // for ($i = 0; $i < $anzsp; $i++)
            }
            else {
                for ($i = 0; $i < $ligaDaten->anzsp; $i++) {
                    for ($n = 0; $n < $ligaDaten->modus[$ligaDaten->stx-1]; $n++) {
                        if (($ligaDaten->teama[$ligaDaten->stx-1][$i] > 0) && ($ligaDaten->teamb[$ligaDaten->stx-1][$i] > 0) ) {
                            if ($ligaDaten->mspez[$ligaDaten->stx-1][$i][$n] == '&nbsp;') {
                                $mspezhilf = '';
                            }
                            else {
                                $mspezhilf = ' ' . $ligaDaten->mspez[$ligaDaten->stx-1][$i][$n];
                            }
                            if ($ligaDaten->favteam == $ligaDaten->teama[$ligaDaten->stx-1][$i] || $ligaDaten->favteam == $ligaDaten->teamb[$ligaDaten->stx-1][$i] || $ticker_tickerart == 1) {
                                if ($ligaDaten->mnote[$ligaDaten->stx-1][$i][$n] != '' && $ticker_notizanzeigen == 1) {
                                    $dummy4 = ' ' . $text[22] . ': ' . $ligaDaten->mnote[$ligaDaten->stx-1][$i][$n];
                                }
                                else {
                                    $dummy4 = '';
                                }
                                $hilf1 = $hilf1 . $ligaDaten->teams[$ligaDaten->teama[$ligaDaten->stx-1][$i]] . " - " . $ligaDaten->teams[$ligaDaten->teamb[$ligaDaten->stx-1][$i]] . " " . applyFactor($ligaDaten->goala[$ligaDaten->stx-1][$i][$n], $ligaDaten->goalfaktor) . ":".applyFactor($ligaDaten->goalb[$ligaDaten->stx-1][$i][$n], $ligaDaten->goalfaktor) . $mspezhilf . $dummy4 . $trenner;
                            }
                        }
                    }
                }
            }
        }
        $ticker_text .= " $trenner {$ligaDaten->titel} ({$ligaDaten->stx}{$text['ticker'][1]}): $hilf $hilf1";
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
        