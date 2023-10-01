<?php
/* Liga Manager Online 4
 *
 * http://lmo.sourceforge.net/
 *-ä#ü+ä#ü++ü-öööööööööööööööööööööööö
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

foreach ($fav_team[$i] as $akt_team) {
    if (isset($multi_cfgarray['modus']) && $multi_cfgarray['modus'] == 1) {
        $spieltag = $mySpieltag->nr;
    }
    $mhp_link_s=$mgp_link_s=$mhp_link_e=$mgp_link_e="";
    if (($akt_team == $partie->heim->nr) || ($akt_team == $partie->gast->nr)) {

        //Anfang Relevante Daten
        $goalfaktor = $liga->options->keyValues['goalfaktor'];
        $template->setVariable("Liganame", $liga->name);
        $template->setVariable("Ligadatum", $liga->ligaDatumAsString());
        $template->setVariable("Spieltag", $multi_cfgarray['spieltagtext'] . " " . $spieltag);
        $template->setVariable("Datum", $partie->datumString('-', $multi_cfgarray['datumsformat']));
        $template->setVariable("Uhrzeit", $partie->zeitString('-', $multi_cfgarray['uhrzeitformat']));
        $template->setVariable("Tore", $partie->hToreString($multi_cfgarray['tordummy'], $goalfaktor) . " : " . $partie->gToreString($multi_cfgarray['tordummy'], $goalfaktor) . ' ' . $partie->spielEndeString($text));
        //Heim & Gasttore einzeln
        $template->setVariable("ToreHeim", $partie->hToreString($multi_cfgarray['tordummy']));
        $template->setVariable("ToreGast", $partie->gToreString($multi_cfgarray['tordummy']));
        //Ende Relevante Daten

        //Neu TeamIcons Heim fuer Bild alt /Anpassung Apache2
        $Heim=$partie->heim->name;
        $Gast=$partie->gast->name;
        $template->setVariable("Iconheim", HTML_icon($Heim, 'teams', 'small'));
        $template->setVariable("Icongast", HTML_icon($Gast, 'teams', 'small'));
        $template->setVariable("IconMiddleheim", HTML_icon($Heim, 'teams', 'middle'));
        $template->setVariable("IconMiddlegast", HTML_icon($Gast, 'teams', 'middle'));
        $template->setVariable("IconBigheim", HTML_icon($Heim, 'teams', 'big'));
        $template->setVariable("IconBiggast", HTML_icon($Gast, 'teams', 'big'));
        //Ende TeamIcons

        $mhp_link_s = "";
        $mhp_link_e = "";
        $mgp_link_s = "";
        $mgp_link_e = "";
        //HP verlinken
        if (isset($multi_cfgarray['mannschaftshomepages_verlinken']) && $multi_cfgarray['mannschaftshomepages_verlinken']==1) {
            if ($partie->heim->keyValues["URL"] != "") {
            $mhp_link_s = '<a href="'.$partie->heim->keyValues["URL"].'" target="_blank">';
            $mhp_link_e = '</a>';
            }
            if ($partie->gast->keyValues["URL"] != "") {
            $mgp_link_s = '<a href="'.$partie->gast->keyValues["URL"].'" target="_blank">';
            $mgp_link_e = '</a>';
            }
        }//Ende HP verlinken

        //Favteam hervorheben
        if (isset($multi_cfgarray['favteam_highlight']) && $multi_cfgarray['favteam_highlight'] == 1) {
            if ($partie->heim->nr == $liga->options->keyValues['favTeam']) {
                $mhp_link_s = '<strong>' . $mhp_link_s;
                $mhp_link_e .= '</strong>';
            }
            if ($partie->gast->nr == $liga->options->keyValues['favTeam']) {
                $mgp_link_s = '<strong>' . $mgp_link_s;
                $mgp_link_e .= '</strong>';
            }
        }  //Ende Favteam hervorheben

        //Trotz Konfigwert auch andere Variablen zur Verfügung stellen
        $template->setVariable("HeimKurz", $partie->heim->kurz);
        $template->setVariable("GastKurz", $partie->gast->kurz);
        $template->setVariable("HeimMittel" ,$partie->heim->mittel);
        $template->setVariable("GastMittel", $partie->gast->mittel);
        $template->setVariable("HeimLang", $partie->heim->name);
        $template->setVariable("GastLang", $partie->gast->name);
        //Neu wegen Auswahl Mittellanger Teamnamen
        if ($multi_cfgarray['mannschaftsnamen'] == 2) {
            $template->setVariable("Heim", $mhp_link_s . $partie->heim->mittel . $mhp_link_e);
            $template->setVariable("Gast", $mgp_link_s . $partie->gast->mittel . $mgp_link_e);
        } elseif ($multi_cfgarray['mannschaftsnamen'] == 1) {
            $template->setVariable("Heim", $mhp_link_s . $partie->heim->kurz . $mhp_link_e);
            $template->setVariable("Gast", $mgp_link_s . $partie->gast->kurz . $mgp_link_e);
        } else {
            $template->setVariable("Heim", $mhp_link_s . $partie->heim->name . $mhp_link_e);
            $template->setVariable("Gast", $mgp_link_s . $partie->gast->name . $mgp_link_e);
        }  //Ende Mannschaftsnamen

        //Anfang Notitz
        if (trim($partie->notiz) != "") {
            $icon = URL_TO_IMGDIR . "/viewer/" . $multi_cfgarray['notizsymbol'];
            $ntext = '<a href="#" title="' . $partie->notiz . '" onclick="alert(\'' . $text[22] . ': ' . $partie->notiz . '\');window.focus();return false;"><img src="' . $icon . '" border="0" alt=""></a>';
            $template->setVariable("Notiz", $ntext);
        }//Ende Notiz

        //Anfang Tabelle verlinken
        $table_link = URL_TO_LMO . '/lmo.php?file=' . $fav_liga[$i] . "&amp;action=table&amp;st=" . $spieltag;
        if ($multi_cfgarray['tabelle_verlinken'] == '1') {
            $tlink = "<a href='" . $table_link . "' target='_blank' title='" . $text['viewer'][35] . " (" . $text['viewer'][33] . ")'><img src='" . URL_TO_IMGDIR . "/viewer/" . $multi_cfgarray['tabellensymbol'] . "' border='0' alt='#'></a>";
        } else {
            $tlink = "<a href='" . $table_link . "' title='" . $text['viewer'][35] . " (" . $text['viewer'][34] . ")'><img src='" . URL_TO_IMGDIR . "/viewer/" . $multi_cfgarray['tabellensymbol'] . "' border='0' alt='#'></a>";
        }
        $template->setVariable("Tabellenlink", $tlink);
        //Ende Tabelle

        //Anfang Spieltag verlinken
        //Im Unterschied zu den anderen Links wird nur die URL gesetzt, nicht der komplette Link
        //Rest wird über das Template gesteuert
        $spieltag_link = URL_TO_LMO . '/lmo.php?file=' . $fav_liga[$i] . "&amp;action=results&amp;st=" . $spieltag;
        $template->setVariable("SpieltagLink", $spieltag_link);
        //Ende Spieltag

        //Anfang Spielbericht
        $SpBer_link = $partie->reportUrl;
        if ($SpBer_link != "") {
            if ($multi_cfgarray['spielberichte_neues_fenster'] == '1' ) {
                $tlink = "<a href='" . $SpBer_link . "' target='_blank' title='" . $text['viewer'][38] . " (" . $text['viewer'][33] . ")'><img src='" . URL_TO_IMGDIR . "/viewer/" . $multi_cfgarray['spielberichtesymbol'] . "' border='0' alt='§'></a>";
            } else {
                $tlink = "<a href='" . $SpBer_link . "' title='" . $text['viewer'][38] . " (" . $text['viewer'][34] . ")'><img src='" . URL_TO_IMGDIR . "/viewer/" . $multi_cfgarray['spielberichtesymbol'] . "' border='0' alt='§'></a>";
            }
            $template->setVariable("Spielbericht", $tlink);
        }//Ende Spielbericht

        //Anfang Spiele Heute hervorheben
        if ($multi_cfgarray['heute_highlight'] == 1) {
            if ($partie->zeit > zeitberechnung("2", -1) && $partie->zeit < zeitberechnung("2", 0)) {
                $template->setvariable("Zeilenklasse", "vRowHighlight");
            } else {
                $template->setvariable("Zeilenklasse", "vRow");
            }
        }  //Ende Spiele Heute hervorheben
    }
}
$template->parseCurrentBlock();
?>
