<?
// 
// LigaManager Online 3.02
// Copyright (C) 1997-2002 by Frank Hollwitz
// webmaster@hollwitz.de / http://php.hollwitz.de
// 
// Spielerstatistik-Addon 1.1
// Copyright (C) 2002 by Rene Marth
// marth@tsvschlieben.de / http://www.tsvschlieben.de
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
//Datei auslesen
$filename=array_pop(explode("/",$file));
$configfile="stats/".substr($filename,0,strlen($filename)-4).".cfg";
$filename="stats/".substr($filename,0,strlen($filename)-4).".stat";

//Standard
	$picswidth="15px"; 			//Größe der Spielerfotos
	$displayperpage=10;     //Anzahl der pro Seite ausgegebenen Ergebnisse
	$displayperpageadmin=0;     //Anzahl der pro Seite ausgegebenen Ergebnisse
	$nonamesort=0;			    //Blendet Möglichkeit aus, nach Namen zu sortieren
	$displayzeros=1; 				//1=Nullwerte einblenden; 0=Nullwerte filtern
	$defaultsort=0;					//Spaltennummer, nach der als Erstes im Userbereich sortiert wird (von links nach rechts, Beginn bei 0)
	$adminsort=0;						//Spaltennummer, nach der als Erstes im Adminbereich sortiert wird (von links nach rechts, Beginn bei 0)
	$allowauxadmin=1;				//Erlaubt den Hilfsadmins Zugriff auf die Statistik
	$allowauxadmins=1;				//Erlaubt den Hilfsadmins Zugriff auf Erstellen von Spalten
	$ligalink=$text["811"];					//Text des Spielerlinks
	
if ($config=@file($configfile)) {
	for ($i=0;$i<count($config);$i++){
		$row=explode("=",$config[$i],2);
		switch ($row[0]) {
			case $text[3020]:$picswidth=$row[1];break;
			case $text[3021]:$defaultsort=(int)$row[1];break;
			case $text[3022]:$displayperpage=(int)$row[1];break;
			case $text[3042]:$displayperpageadmin=(int)$row[1];break;
			case $text[3023]:$displayzeros=(int)$row[1];break;
			case $text[3024]:$nonamesort=(int)$row[1];break;
			case $text[3031]:$allowauxadmin=(int)$row[1];break;
			case $text[3046]:$allowauxadmins=(int)$row[1];break;
			case $text[3040]:$adminsort=$row[1];break;
			case $text[3041]:$ligalink=$row[1];break;
		}
	}
}
?>
