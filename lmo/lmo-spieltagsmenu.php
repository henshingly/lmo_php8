<?php
if (!defined('PATH_TO_LMO')) {
    exit;  // kein Direktaufruf: diese Datei wird nur ueber LMO eingebunden
}

/**
 * Diese Datei wird eingebunden und erwartet:
 *
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
if (isset($ligaDaten->anzst)) {
    for ($i = 1; $i <= $ligaDaten->anzst; $i++) {
        if ($ligaDaten->lmtype == 1) {
            if ($i == $ligaDaten->anzst) {
                $j = $text[364];
                $k = $text[365];
            }
            elseif ($i == $ligaDaten->anzst - 1) {
                $j = $text[362];
                $k = $text[363];
            }
            elseif ($i == $ligaDaten->anzst - 2) {
                $j = $text[360];
                $k = $text[361];
            }
            elseif ($i == $ligaDaten->anzst - 3) {
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
        if (($ligaDaten->anzst > 47) && (($ligaDaten->anzst % 4) == 0)) {
            if (($i == $ligaDaten->anzst / 4) || ($i == $ligaDaten->anzst / 2) || ($i == $ligaDaten->anzst / 4 * 3)) {?>
              </tr>
              <tr>
<?php
            }
        }
        elseif (($ligaDaten->anzst > 35)) {
            if (($i == ceil($ligaDaten->anzst / 3)) || ($i == ceil($ligaDaten->anzst / 3 * 2))) {?>
              </tr>
              <tr>
<?php
            }
        }
        elseif (($ligaDaten->anzst > 23)) {
            if ($i == ceil($ligaDaten->anzst / 2)) {?>
              </tr>
              <tr>
<?php
            }
        }
    }
}?>
              </tr>
            </table>
