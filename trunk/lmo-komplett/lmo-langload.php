<?PHP
// 
// LigaManager Online 3.02b
// Copyright (C) 1997-2002 by Frank Hollwitz
// webmaster@hollwitz.de / http://php.hollwitz.de
// 
// LigaManager Online
// Edited by: Rene Marth
// 28.08.2003
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

// Langdateien laden (zuerst Standarddatei, wenn vorhanden werden die alten Werte 
// von der neuen Sprache überschrieben (So werden auch unvollständige Übersetzungen 
// akzeptiert)
$dumdat=array("lang.txt","lang-{$lmouserlang}.txt");

$dumma = array("");
$text=array("");
for ($i=0;$i<count($dumdat);$i++) {
	if ($datei = @fopen($dumdat[$i],"r")) {
		while (!feof($datei)) {
		  $zeile = fgets($datei,1000);
		  $zeile=chop($zeile);
		  if($zeile!=""){array_push($dumma,$zeile);}
		  }
		fclose($datei);
		array_shift($dumma);
		for($j=0;$j<count($dumma);$j++){
		  $schl=intval(trim(substr($dumma[$j],0,strpos($dumma[$j],"="))));
	  	$wert=trim(substr($dumma[$j],strpos($dumma[$j],"=")+1));
	  	$text[$schl]=$wert;
	  }
	}
}
$orgpkt=$text[37];
$orgtor=$text[38];
?>