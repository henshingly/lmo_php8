<?
//
// Limporter Addon for LigaManager Online
// Copyright (C) 2003 by Tim Schumacher
// timme@uni.de /
//
// LigaManager Online 3.02b
// Copyright (C) 1997-2002 by Frank Hollwitz
// webmaster@hollwitz.de / http://php.hollwitz.de
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

if (!defined('LIM_VERSION')) define('LIM_VERSION','1.1');

// ARRAY mit reguläre Ausdruecken, um nur bestimmte Teile aus einer Zelle zu extrahieren.
// Dieses kann GERNE erweitert werden. Bitte schickt getestete Expressions an timme@uni.de,
// damit diese in zukünftige Version eingebaut werden können.
//
// Aufbau:  Beschreibung, die in der Auswahlliste erscheint => Regulärer Ausdruck
//
// Der Reguläre Ausdruck wird auf die PHP- Function preg_match($exPr,$value,$results) angewendet.
// Der gewünschte Teil wird in $results[1] erwartet und weiterverarbeitet.
// Daher ist bei der Definition eines neuen Regulären Ausdrucks darauf zu achten,
// das das Ergebnis tatsächlich in $results[1] steht. Ansonsten wird der extrahierte Wert nicht erkannt
//
// Auf folgender Internetseite, können RegExp. getestet werden:
// http://myfluffydog.com/programming/php/scripts/regexp.php

if (!isset($lim_format_exp)) {
	$lim_format_exp = array (
		'TORE HEIM (xx : __)'		=> '/(\d+):/',
		'TORE GAST (__ : xx)'		=> '/:(\d+)/',
		'führ.Sondz. entf. (- xx)'	=> '/\W*(.*)/',
		'Datum (tt.mm.jjjj)'		=> '/(\d{1,2}\W{1}\d{1,2}\W{1}\d{2,4})/',
		'Zeit  (hh:mm)'				=> '/(\d{1,2}:\d{1,2})/'
		);
};

// Eine neue Liga wird mit folgenden Einstellungen angelegt
if (!isset($lim_ligaOptions)) {
	$lim_ligaOptions = array (
        "Title"=> "Limporter LMO Addon",
        "Name"=> "Liga Name",
        "Type"=> 0,
        "Teams"=> 0,
        "vonTab"=> 0,
        "bisTab"=> 0,
        "Rounds"=> 0,
        "Matches"=> 0,
        "Actual"=> 0,
        "Kegel"=>	0,
        "HandS"=>	0,
        "PointsForWin"=>	2,
        "PointsForDraw"=>	1,
        "PointsForLost"=>	0,
        "Spez"=> 0,
        "HideDraw"=>0,
        "OnRun"=> 0,
        "MinusPoints"=>2,
        "Direct"=> 0,
        "Champ"=> 1,
        "CL"=> 0,
        "CK"=> 0,
        "UC"=> 0,
        "AR"=> 0,
        "AB"=> 2,
        "namePkt"=>	"Pkt.",
        "nameTor"=>	"Tore",
        "DatC"=> 1,
        "DatS"=> 1,
        "DatM"=> 1,
        "DatF"=> "%a.%d.%m. %H:%M",
        "urlT"=> 1,
        "urlB"=> 0,
        "Graph"=>	1,
        "Kreuz"=>	1,
        "favTeam"=>	0,
        "selTeam"=>	0,
        "kurve1"=> 0,
        "kurve2"=> 0,
        "ticker"=> 0);
};

// Limporter Colums
if (!isset($lim_colums)) {
	$lim_colums = array (
  	'HEIM'=> 		array(-1,-1),
    'GAST'=> 		array(-1,-1),
    'THEIM'=> 	array(-1,-1),
    'TGAST'=> 	array(-1,-1),
    'PHEIM'=> 	array(-1,-1),
    'PGAST'=> 	array(-1,-1),
    'DATUM'=> 	array(-1,-1),
    'ZEIT'=> 		array(-1,-1),
    'NR'=> 			array(-1,-1),
    'NOTIZ'=> 	array(-1,-1)
    );
};

?>





















































































































<?
if (!defined('LIM_VERSIONS')) define('LIM_VERSIONS',"Limporter Version ".LIM_VERSION." Addon for LMO 3.99<BR>Copyright &#169; 03/04 <a href=\"mailto:timme@uni.de?subject=Limporter\" title=\"Send mail\">Tim Schumacher</a>");
?>