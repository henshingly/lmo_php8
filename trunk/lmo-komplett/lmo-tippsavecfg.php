<?PHP
// 
// LigaManager Online 3.02
// Copyright (C) 1997-2002 by Frank Hollwitz
// webmaster@hollwitz.de / http://php.hollwitz.de
// 
// Tippspiel-AddOn 1.20
// Copyright (C) 2002 by Frank Albrecht
// fkalbrecht@web.de
// 
// Jocker-Hack 001
// Copyright (C) 2002 by Ufuk Altinkaynak
// ufuk.a@arcor.de
// 
// This program is free software; you can redistribute it and/or
// modify it under the terms of the GNU General Public License as
// published by the Free Software Foundation; either version 2 of
// the License, or (at your option) any later version.
// 
// This program is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
// General Public License for more details.
// 
// You should have received a copy of the GNU General Public License
// along with this program; if not, write to the Free Software
// Foundation, Inc., 675 Mass Ave, Cambridge, MA 02139, USA.
// 
require_once(PATH_TO_LMO."/lmo-admintest.php");
    $datei = fopen($tippcfgfile,"wb");
if (!$datei) {
    echo "<font color=\"#ff0000\">".$text[283]."</font>";
    exit;
}elseif($todo!="tippemail"){
    echo "<font color=\"#008800\">".$text[138]."</font>";
}
    flock($datei,2);
    fputs($datei,"TippDir=".$dirtipp."\n");

    fputs($datei,"ShowNick=".$shownick."\n");
    fputs($datei,"ShowName=".$showname."\n");
    fputs($datei,"ShowEmail=".$showemail."\n");

    fputs($datei,"Tippspiel=".$tippspiel."\n");
    fputs($datei,"Regeln=".$regeln."\n");
    fputs($datei,"RegelnLink=".$regelnlink."\n");
    fputs($datei,"Adresse=".$adresse."\n");
    fputs($datei,"RealName=".$realname."\n");
    fputs($datei,"Gesamt=".$gesamt."\n");
    fputs($datei,"Freischaltung=".$freischaltung."\n");
    fputs($datei,"EntscheidungnV=".$entscheidungnv."\n");
    fputs($datei,"EntscheidungiE=".$entscheidungie."\n");
    fputs($datei,"EinsichtenErstNachSchluss=".$einsichterst."\n");
    fputs($datei,"WertVerein=".$wertverein."\n");
    fputs($datei,"AktAuswert=".$aktauswert."\n");
    fputs($datei,"AktAuswertGes=".$aktauswertges."\n");
    fputs($datei,"AktEinsicht=".$akteinsicht."\n");
    fputs($datei,"TippTabelle=".$tipptabelle."\n");
    fputs($datei,"TippTabelle1=".$tipptabelle1."\n");
    fputs($datei,"TippEinsicht=".$tippeinsicht."\n");
    fputs($datei,"TippFieber=".$tippfieber."\n");
    fputs($datei,"TippBis=".$tippbis."\n");
    fputs($datei,"TippOhne=".$tippohne."\n");
    fputs($datei,"TipperTeam=".$tipperimteam."\n");
    fputs($datei,"imVorraus=".$imvorraus."\n");
    fputs($datei,"PfeilTipp=".$pfeiltipp."\n");
    fputs($datei,"StTipp=".$sttipp."\n");
    fputs($datei,"ViewerTipp=".$viewertipp."\n");
    fputs($datei,"ViewerTage=".$viewertage."\n");
    fputs($datei,"TippModus=".$tippmodus."\n");
    fputs($datei,"rErgebnis=".$rergebnis."\n");
    fputs($datei,"rTendenzDiff=".$rtendenzdiff."\n");
    fputs($datei,"rTendenz=".$rtendenz."\n");
    fputs($datei,"rTor=".$rtor."\n");
    fputs($datei,"rTendenzTor=".$rtendenztor."\n");
    fputs($datei,"rTendenzRemis=".$rtendenzremis."\n");
    fputs($datei,"rRemis=".$rremis."\n");
    fputs($datei,"AnzahlSeite=".$anzseite."\n");
    fputs($datei,"AnzahlSeite1=".$anzseite1."\n");
    fputs($datei,"GTPunkte=".$gtpunkte."\n");
    fputs($datei,"ImmerAlle=".$immeralle."\n");
    fputs($datei,"LigenZuTippen=".$ligenzutippen."\n");
    fputs($datei,"TextReminder1=".$textreminder1."\n");
    fputs($datei,"ShowTendenzAbsolut=".$showtendenzabs."\n");
    fputs($datei,"ShowTendenzProzent=".$showtendenzpro."\n");
    fputs($datei,"ShowDurchnittstipp=".$showdurchschntipp."\n");
    fputs($datei,"ShowZusammensetzung=".$showzus."\n");
    fputs($datei,"ShowStSiege=".$showstsiege."\n");
    fputs($datei,"Krit1=".$krit1."\n");
    fputs($datei,"Krit2=".$krit2."\n");
    fputs($datei,"Krit3=".$krit3."\n");
    fputs($datei,"JokerTipp=".$jokertipp."\n");    
    fputs($datei,"JokerTippMulti=".$jokertippmulti."\n");

    flock($datei,3);
    fclose($datei);

  clearstatcache();
?>