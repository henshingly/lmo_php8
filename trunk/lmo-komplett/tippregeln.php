<!DOCTYPE HTML PUBLIC "-//SoftQuad Software//DTD HoTMetaL PRO 6.0::19990601::extensions to HTML 4.0//EN" "hmpro6.dtd">
<html>
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
require("lmo-langload.php");
require("lmo-tippcfgload.php");
?>
<head>
<style TYPE="text/css">
<!--
a:link {text-decoration: none; color: #0000ff;}
a:visited {text-decoration: none; color: #8800ff;}
a:active {text-decoration: overline underline; color: #ff0088;}
a:hover {text-decoration: overline underline; color: #ff0088;}
LI { padding: 0px 0px 0px 0px; margin-bottom: 3px; }
body, td { background: #ffffff; color: #000000; font-family: Arial, Helvetica, Sans-Serif; font-size: 9pt; }
.t1 { margin-top: 10px; margin-bottom: 4px; font-size: 11pt; font-weight: bold; text-align: left; }
.t3 { margin-left: 40px; margin-bottom: 4px; font-size: 9pt; font-weight: normal; text-align: justify; }
.t4 { margin-bottom: 4px; font-size: 10pt; font-weight: normal; text-align: right; }
//-->
  </style>
<title>Spielregeln - Salzland-Info-Tippspiel</title>
</head>

<body>

<a href="javascript:history.back()">zur&uuml;ck zum Tippspiel</a>
<center>
</PRE>
<h3>Spielregeln - Tippspiel<font SIZE="2"><br>
<font SIZE="2">für <?PHP echo $text[54];?></font><font SIZE="2"> <?PHP echo $text[55];?><br>
<font SIZE="2">inkl. <?PHP echo $text[2084]." ".$text[2085];?></font><br>
<font SIZE="1">Spielregeln by <a href="http://www.salzland-info.de/" target="_blank">Salzland-info.de</a></font><br>
</font></h3>
</center>
<p>Die Teilnahme am Tippspiel ist für jeden <strong>kostenlos</strong>. Nach einer Anmeldung 
zum Tippspiel hat der Tipper die Möglichkeit, eine <strong><u>oder</u></strong> mehrere Tippspiele 
zu abonnieren.</p>
<h3>I. Verfahren zum Abonnieren und Spielen einzelner Ligen</h3>
<p><strong><u>Anmelden und Verwalten</u></strong></p>
<ol>
  <li>Im Login-Bereich auf &quot;<strong>anmelden</strong>&quot; klicken .</li>
  <li>Alle Anmeldedaten eintragen und auswählen, welche Liga Sie abonnieren möchten.<br>
  <strong>Hinweis</strong>: Weitere Ligen können Sie jederzeit nach der Erstanmeldung unter 
  Ihrem Usernamen nachträglich abonnieren!</li>
  <li>Nach der Anmeldung sind Sie eingeloggt bzw. Sie können sich jetzt jederzeit 
  mit Ihrem Nickname einloggen.</li>
  <li>Im User-Bereich des Tippspiels können Sie:
  <ul>
    <li>Eine abonnierte <strong>Liga tippen</strong></li>
    <li><strong>Punktstände anschauen</strong></li>
    <li><strong>Ihre Daten ändern</strong></li>
    <li><strong>andere bzw. neue Ligen in Ihren Tippschein aufnehmen </strong></li>
    <li><strong>Passwort ändern </strong></li>
    <li><strong>Tipp-Account löschen</strong> (<strong>Achtung</strong>: Alle abonnierten Tippspiele 
    Ihres Nicknames werden gelöscht!)</li>
    <li><strong>Aus dem Tippspiel ausloggen </strong></li>
  </ul>
  </li>
</ol>
<p><strong><u>Liga tippen</u></strong></p>
<ol>
  <li>Nach dem Einloggen im Tippspielbereich eine abonnierte Liga zum Tippen auswählen.</li>
  <li>Im Ansetzungsbereich können Sie nun Ihre Tipps für die einzelnen Spieltage 
  abgeben.</li>
  <li>Nach Eingabe der Tipps <strong>eines Spieltages</strong> klicken Sie auf - <strong>Tipps 
  speichern</strong><br>
  Sie können jetzt auf einen anderen Spieltag wechseln und weitere Tipps abgeben.</li>
</ol>
<p><u>Hinweise zur Tippabgabe:</u></p>
<ul>
  <li>Die Tippzeit läuft für jedes Spiel einzeln ab. </li>
  <li>Ablauf der Tippzeit ist jeweils <?PHP echo $tippbis;?> Minuten vor Anpfiff.</li>
  <li>Sollten <strong>ohne</strong> unsere Kenntnis einzelne Spiele vorgezogen werden, bitten 
  wir das zu entschuldigen.<br>
  Wir versuchen jedoch immer <strong>vor</strong> einem Spieltag alle veränderten Anstoßzeiten 
  zu aktualisieren.</li>
</ul>
<h3>II. Spielwertung und Ligawertung</h3>
<p><strong><u>Die Spielwertung (Punktverteilung)</u></strong></p>
<ul>
  <li>Ergebnis richtig: <strong><?PHP echo $rergebnis;?> Punkte</strong></li>
  <li>nur Tendenz und Tordifferenz richtig: <strong><?PHP echo $rtendenzdiff;?> Punkte</strong></li>
  <li>nur Tendenz richtig: <strong><?PHP echo $rtendenz;?> Punkte</strong></li>
  <li>nur eine Toranzahl richtig: <strong><?PHP echo $rtor;?> Punkt</strong></li>
</ul>
<p><strong><u>Die Liga- und Spieltagswertung</u></strong></p>
<ul>
  <li>Die Gesamtligawertung erhalten Sie, wenn Sie in der Tippspiel-Übersicht eine 
  abonnierte Liga unter dem Punkt: <strong>Punktestände anschauen</strong> auswählen.</li>
  <li>Sie erreichen die Gesamtligawertung auch, wenn Sie im Tippbereich auf - <strong>
  Ligawertung</strong> wechseln</li>
  <li>Die erzielten Punkte Ihrer <strong>einzelnen</strong> Spiele können Sie einsehen, wenn 
  Sie im Tippbereich einer Liga einen <strong>absolvierten Spieltag</strong> aufrufen.</li>
  <li><strong>Gesamtsieger</strong> ist, wer nach einer Spielsaison die meisten Punkte auf 
  seinem Spielkonto verbuchen kann.</li>
  <li>Zusätzlich können unter <strong>Tippeinsicht</strong> die Tipps der Mitspieler eingesehen 
  werden</li>
  <li>Die <strong>Tipp-Tabelle</strong> ist eine Zusatzanzeige, also eine Tabelle erzeugt 
  nach Ihren abgegebenen Tipps</li>
</ul>
<p><u>Hinweise zum Zeitpunkt der Tippauswertung:</u></p>
<p>Die technische Auswertung der Spieltipps erfolgt in der Regel nach jedem absolvierten 
Spieltag.<br>
Bitte beachten Sie, dass sich aus organisatorischen Gründen die Tippauswertung auch 
einmal um <strong>1 bis 2 Tage</strong> verzögern kann.</p>
<h3>III. Haftungsausschluß</h3>
<p>Das <strong>Tippspiel</strong> findet wie  unter Ausschluss des Rechtsweges statt. 
Für etwaige Übertragungsfehler
und sonstige technische Schwierigkeiten ist der Veranstalter in keiner Weise verantwortlich 
zu machen. Mit der Anmeldung
zum Spiel akzeptieren Sie die Bedingungen. Dieses Spiel dient dem reinen Unterhaltungszweck. 
Wer hackt, verfälscht, oder sich
mehrmals unter verschiedenen Namen anmeldet, wird mit Spielsperre bestraft. Der 
Rechtsweg ist ausgeschlossen.</p>
<a href="javascript:history.back()">zur&uuml;ck zum Tippspiel</a>

</body>

</html>