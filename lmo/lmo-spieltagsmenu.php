<?php
if (!defined('PATH_TO_LMO')) {
    exit;  // kein Direktaufruf: diese Datei wird nur ueber LMO eingebunden
}

/**
 * Diese Datei wird eingebunden und erwartet:
 *
 * @var \Lmo\Liga\Rohdaten\Liga|null $lmo_liga Rohdaten der geladenen Liga; fehlt, wenn keine geladen ist
 * @var array<int|string, mixed> $text Sprachtexte
 * @var int|string $st gewaehlter Spieltag
 *
 * Weitere Variablen des einbindenden Codes:
 * @var mixed $addb
 * @var mixed $addr
 */
?>            <table class="lmoSubmenu" cellspacing="0" cellpadding="0" border="0">
              <tr>
<?php
if (isset($lmo_liga)) {
    // Spieltage der Liga, im Pokal die Runden
    $lmo_menu_spieltage = $lmo_liga->einstellungen()->spieltage();
    $lmo_menu_pokal = $lmo_liga->einstellungen()->istPokal();
    for ($i = 1; $i <= $lmo_menu_spieltage; $i++) {
        if ($lmo_menu_pokal) {
            if ($i == $lmo_menu_spieltage) {
                $j = $text[364];
                $k = $text[365];
            }
            elseif ($i == $lmo_menu_spieltage - 1) {
                $j = $text[362];
                $k = $text[363];
            }
            elseif ($i == $lmo_menu_spieltage - 2) {
                $j = $text[360];
                $k = $text[361];
            }
            elseif ($i == $lmo_menu_spieltage - 3) {
                $j = $text[358];
                $k = $text[359];
            }
            else {
                $j = $i;
                $k = $text[366];
            }
        }
        else {
            $j = sprintf("%02d", $i);
            $k = $text[9]; }?>
                <td align='center'><?php

        if ($i != $st || empty($tabdat)) {
            if (isset($todo) && $todo == "tabs") {
                echo '<a href="' . $addb . $i . '" title="' . $k . '">' . $j . '</a>';
            }
            else {
                if($i == $st) {
                    echo $j;
                }
                else {
                    echo '<a href="' . $addr . $i . '" title="' . $k . '">' . $j . '</a>';
                }
            }
        }
        else {
            echo $j;
        }?>&nbsp;</td>
<?php
        if (($lmo_menu_spieltage > 47) && (($lmo_menu_spieltage % 4) == 0)) {
            if (($i == $lmo_menu_spieltage / 4) || ($i == $lmo_menu_spieltage / 2) || ($i == $lmo_menu_spieltage / 4 * 3)) {?>
              </tr>
              <tr>
<?php
            }
        }
        elseif (($lmo_menu_spieltage > 35)) {
            if (($i == ceil($lmo_menu_spieltage / 3)) || ($i == ceil($lmo_menu_spieltage / 3 * 2))) {?>
              </tr>
              <tr>
<?php
            }
        }
        elseif (($lmo_menu_spieltage > 23)) {
            if ($i == ceil($lmo_menu_spieltage / 2)) {?>
              </tr>
              <tr>
<?php
            }
        }
    }
}?>
              </tr>
            </table>
