<?PHP
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
$cfgfile="lmo-cfg.txt";
$datei = fopen($cfgfile,"rb");
while (!feof($datei)) {
  $zeile = fgets($datei,1000);
  $zeile=chop($zeile);
  if($zeile!=""){
    $schl=trim(substr($zeile,0,strpos($zeile,"=")));
    $wert=trim(substr($zeile,strpos($zeile,"=")+1));
    if($schl=="LeagueDir"){$dirliga=$wert;}
    elseif($schl=="PktJustify"){$tabpkt=$wert;}
    elseif($schl=="TabOnResults"){$tabonres=$wert;}
    elseif($schl=="BackLink"){$backlink=$wert;}
    elseif($schl=="CalcTime"){$calctime=$wert;}
    elseif($schl=="DefaultTime"){$deftime=$wert;}
    elseif($schl=="AdminMail"){$aadr=$wert;}
    }
  }
fclose($datei);
?>