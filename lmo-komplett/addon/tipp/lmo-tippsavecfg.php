<?PHP
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
  
  
require_once(PATH_TO_LMO."/lmo-admintest.php");
$datei = fopen(PATH_TO_ADDONDIR."/tipp/cfg.txt", "wb");
if (!$datei) {
  echo "<p class='error'>".$text[283]."</p>";
  exit;
} elseif($todo != "tippemail") {
  echo "<p class='message'>".$text[138]."</p>";
}
flock($datei, 2);
fputs($datei, "TippDir=".PATH_TO_ADDONDIR."/tipp/".$tipp_dirtipp."\n");
 
fputs($datei, "ShowNick=".$tipp_shownick."\n");
fputs($datei, "ShowName=".$tipp_showname."\n");
fputs($datei, "ShowEmail=".$tipp_showemail."\n");
 
fputs($datei, "Tippspiel=".$tipp_tippspiel."\n");
fputs($datei, "Regeln=".$tipp_regeln."\n");
fputs($datei, "RegelnLink=".$tipp_regelnlink."\n");
fputs($datei, "Adresse=".$tipp_adresse."\n");
fputs($datei, "RealName=".$tipp_realname."\n");
fputs($datei, "Gesamt=".$tipp_gesamt."\n");
fputs($datei, "Freischaltung=".$tipp_freischaltung."\n");
fputs($datei, "EntscheidungnV=".$tipp_entscheidungnv."\n");
fputs($datei, "EntscheidungiE=".$tipp_entscheidungie."\n");
fputs($datei, "EinsichtenErstNachSchluss=".$tipp_einsichterst."\n");
fputs($datei, "WertVerein=".$tipp_wertverein."\n");
fputs($datei, "AktAuswert=".$tipp_aktauswert."\n");
fputs($datei, "AktAuswertGes=".$tipp_aktauswertges."\n");
fputs($datei, "AktEinsicht=".$tipp_tippeinsicht."\n");
fputs($datei, "TippTabelle=".$tipp_tipptabelle."\n");
fputs($datei, "TippTabelle1=".$tipp_tipptabelle1."\n");
fputs($datei, "TippEinsicht=".$tipp_tippeinsicht."\n");
fputs($datei, "TippFieber=".$tipp_tippfieber."\n");
fputs($datei, "TippBis=".$tipp_tippBis."\n");
fputs($datei, "TippOhne=".$tipp_tippohne."\n");
fputs($datei, "TipperTeam=".$tipp_tipperimteam."\n");
fputs($datei, "imVorraus=".$tipp_imvorraus."\n");
fputs($datei, "PfeilTipp=".$tipp_pfeiltipp."\n");
fputs($datei, "StTipp=".$tipp_sttipp."\n");
fputs($datei, "ViewerTipp=".$tipp_viewertipp."\n");
fputs($datei, "ViewerTage=".$tipp_viewertage."\n");
fputs($datei, "TippModus=".$tipp_tippmodus."\n");
fputs($datei, "rErgebnis=".$tipp_rergebnis."\n");
fputs($datei, "rTendenzDiff=".$tipp_rtendenzdiff."\n");
fputs($datei, "rTendenz=".$tipp_rtendenz."\n");
fputs($datei, "rTor=".$tipp_rtor."\n");
fputs($datei, "rTendenzTor=".$tipp_rtendenztor."\n");
fputs($datei, "rTendenzRemis=".$tipp_rtendenzremis."\n");
fputs($datei, "rRemis=".$tipp_rremis."\n");
fputs($datei, "AnzahlSeite=".$tipp_anzseite."\n");
fputs($datei, "AnzahlSeite1=".$tipp_anzseite1."\n");
fputs($datei, "GTPunkte=".$tipp_gtpunkte."\n");
fputs($datei, "ImmerAlle=".$tipp_immeralle."\n");
fputs($datei, "LigenZuTippen=".$tipp_ligenzutippen."\n");
fputs($datei, "TextReminder1=".$tipp_textreminder1."\n");
fputs($datei, "ShowTendenzAbsolut=".$tipp_showtendenzabs."\n");
fputs($datei, "ShowTendenzProzent=".$tipp_showtendenzpro."\n");
fputs($datei, "ShowDurchnittstipp=".$tipp_showdurchschntipp."\n");
fputs($datei, "ShowZusammensetzung=".$tipp_showzus."\n");
fputs($datei, "ShowStSiege=".$tipp_showstsiege."\n");
fputs($datei, "Krit1=".$tipp_krit1."\n");
fputs($datei, "Krit2=".$tipp_krit2."\n");
fputs($datei, "Krit3=".$tipp_krit3."\n");
fputs($datei, "JokerTipp=".$tipp_jokertipp."\n");
fputs($datei, "JokerTippMulti=".$tipp_jokertippmulti."\n");
 
flock($datei, 3);
fclose($datei);
 
clearstatcache();

?>