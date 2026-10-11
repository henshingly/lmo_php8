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
  *
  */
if (!defined('PATH_TO_LMO')) {
    exit;  // kein Direktaufruf: diese Datei wird nur ueber LMO eingebunden
}

require_once(PATH_TO_LMO . '/lmo-admintest.php');
if (($xprogram != '') && ($xprogram != 'none') && ($xprogram != 'random')) {
    if (substr($xprogram, -4) == '.l98') {
        // Paarungen der Vorlage aus den Rohdaten der Ligadatei (Lmo\Liga\Rohdaten\Liga)
        foreach (\Lmo\Liga\Rohdaten\Liga::lies($xprogram)->spieltage as $lmo_spieltag_nr => $lmo_spieltag) {
            foreach ($lmo_spieltag->partien as $lmo_partie_nr => $lmo_partie) {
                if ($lmo_partie->heim !== null) {
                    $yteama[$lmo_spieltag_nr - 1][$lmo_partie_nr - 1] = $lmo_partie->heim;
                }
                if ($lmo_partie->gast !== null) {
                    $yteamb[$lmo_spieltag_nr - 1][$lmo_partie_nr - 1] = $lmo_partie->gast;
                }
            }
        }
    }
}
?>