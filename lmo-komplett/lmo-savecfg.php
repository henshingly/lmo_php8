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
require_once("lmo-admintest.php");
if($HTTP_SESSION_VARS['lmouserok']==2){
    $datei = fopen($cfgfile,"wb");
if (!$datei) {
    echo "<font color=\"#ff0000\">".$text[283]."</font>";
    exit;
}else{
    echo "<font color=\"#008800\">".$text[138]."</font>";
}
    flock($datei,2);
    fputs($datei,"LeagueDir=".$dirliga."\n");
    fputs($datei,"PktJustify=".$tabpkt."\n");
    fputs($datei,"TabOnResults=".$tabonres."\n");
    fputs($datei,"BackLink=".$backlink."\n");
    fputs($datei,"CalcTime=".$calctime."\n");
    fputs($datei,"DefaultTime=".$deftime."\n");
    fputs($datei,"AdminMail=".$aadr."\n");
    flock($datei,3);
    fclose($datei);

  clearstatcache();
}
?>