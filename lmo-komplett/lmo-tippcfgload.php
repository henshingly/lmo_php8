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
$tippcfgfile="lmo-tippcfg.txt";
$tippauthtxt="lmo-tippauth.txt";
$datei = fopen($tippcfgfile,"rb");
while (!feof($datei)) {
  $zeile = fgets($datei,1000);
  $zeile=chop($zeile);
  if($zeile!=""){
    $schl=trim(substr($zeile,0,strpos($zeile,"=")));
    $wert=trim(substr($zeile,strpos($zeile,"=")+1));

    if($schl=="TippDir"){$dirtipp=$wert;}

    elseif($schl=="ShowNick"){$shownick=$wert;}
    elseif($schl=="ShowName"){$showname=$wert;}
    elseif($schl=="ShowEmail"){$showemail=$wert;}

    elseif($schl=="Tippspiel"){$tippspiel=$wert;}
    elseif($schl=="Regeln"){$regeln=$wert;}
    elseif($schl=="RegelnLink"){$regelnlink=$wert;}
    elseif($schl=="Freischaltung"){$freischaltung=$wert;}
    elseif($schl=="EntscheidungnV"){$entscheidungnv=$wert;}
    elseif($schl=="EntscheidungiE"){$entscheidungie=$wert;}
    elseif($schl=="EinsichtenErstNachSchluss"){$einsichterst=$wert;}
    elseif($schl=="WertVerein"){$wertverein=$wert;}
    elseif($schl=="AktAuswert"){$aktauswert=$wert;}
    elseif($schl=="AktAuswertGes"){$aktauswertges=$wert;}
    elseif($schl=="AktEinsicht"){$akteinsicht=$wert;}
    elseif($schl=="TippTabelle"){$tipptabelle=$wert;}
    elseif($schl=="TippTabelle1"){$tipptabelle1=$wert;}
    elseif($schl=="TippEinsicht"){$tippeinsicht=$wert;}
    elseif($schl=="TippFieber"){$tippfieber=$wert;}
    elseif($schl=="Adresse"){$adresse=$wert;}
    elseif($schl=="RealName"){$realname=$wert;}
    elseif($schl=="Gesamt"){$gesamt=$wert;}
    elseif($schl=="TippBis"){$tippbis=$wert;}
    elseif($schl=="TippOhne"){$tippohne=$wert;}
    elseif($schl=="TipperTeam"){$tipperimteam=$wert;}
    elseif($schl=="imVorraus"){$imvorraus=$wert;}
    elseif($schl=="PfeilTipp"){$pfeiltipp=$wert;}
    elseif($schl=="StTipp"){$sttipp=$wert;}
    elseif($schl=="ViewerTipp"){$viewertipp=$wert;}
    elseif($schl=="ViewerTage"){$viewertage=$wert;}
    elseif($schl=="TippModus"){$tippmodus=$wert;}
    elseif($schl=="rErgebnis"){$rergebnis=$wert;}
    elseif($schl=="rTendenzDiff"){$rtendenzdiff=$wert;}
    elseif($schl=="rTendenz"){$rtendenz=$wert;}
    elseif($schl=="rTor"){$rtor=$wert;}
    elseif($schl=="rRemis"){$rremis=$wert;}
    elseif($schl=="rTendenzTor"){$rtendenztor=$wert;}
    elseif($schl=="rTendenzRemis"){$rtendenzremis=$wert;}
    elseif($schl=="AnzahlSeite"){$anzseite=$wert;}
    elseif($schl=="AnzahlSeite1"){$anzseite1=$wert;}
    elseif($schl=="GTPunkte"){$gtpunkte=$wert;}
    elseif($schl=="ImmerAlle"){$immeralle=$wert;}
    elseif($schl=="LigenZuTippen"){$ligenzutippen=$wert;}
    elseif($schl=="TextReminder1"){$textreminder1=$wert;}
    elseif($schl=="ShowTendenzAbsolut"){$showtendenzabs=$wert;}
    elseif($schl=="ShowTendenzProzent"){$showtendenzpro=$wert;}
    elseif($schl=="ShowDurchnittstipp"){$showdurchschntipp=$wert;}
    elseif($schl=="ShowZusammensetzung"){$showzus=$wert;}
    elseif($schl=="ShowStSiege"){$showstsiege=$wert;}
    elseif($schl=="Krit1"){$krit1=$wert;}
    elseif($schl=="Krit2"){$krit2=$wert;}
    elseif($schl=="Krit3"){$krit3=$wert;}
    elseif($schl=="JokerTipp"){$jokertipp=$wert;}
    elseif($schl=="JokerTippMulti"){$jokertippmulti=$wert;}
    }
  }
fclose($datei);
clearstatcache();
?>