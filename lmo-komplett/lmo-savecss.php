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
  $date2 = fopen("lmo-style.txt","rb");
  $datei = fopen("lmo-style.css","wb");
if (!$datei) {
  echo "<font color=\"#ff0000\">".$text[283]."</font>";
  exit;
}else{
  echo "<font color=\"#008800\">".$text[138]."</font>";
}
  flock($datei,2);
while (!feof($date2)) {
  $zeile = fgets($date2,1000);
  $zeile=chop($zeile);
  if($zeile!=""){
    $zeile=str_replace("\$tababack",$HTTP_POST_VARS["xtababack"],$zeile);
    $zeile=str_replace("\$tabacolo",$HTTP_POST_VARS["xtabacolo"],$zeile);
    $zeile=str_replace("\$tababord",$HTTP_POST_VARS["xtababord"],$zeile);
    $zeile=str_replace("\$tabafont",$HTTP_POST_VARS["xtabafont"],$zeile);
    $zeile=str_replace("\$tabasize",$HTTP_POST_VARS["xtabasize"],$zeile);
    $zeile=str_replace("\$tabatite",$HTTP_POST_VARS["xtabatite"],$zeile);
    $zeile=str_replace("\$tabaupda",$HTTP_POST_VARS["xtabaupda"],$zeile);
    $zeile=str_replace("\$tabacoti",$HTTP_POST_VARS["xtabacoti"],$zeile);
    $zeile=str_replace("\$tabbback",$HTTP_POST_VARS["xtabbback"],$zeile);
    $zeile=str_replace("\$tabbcolo",$HTTP_POST_VARS["xtabbcolo"],$zeile);
    $zeile=str_replace("\$tabbbord",$HTTP_POST_VARS["xtabbbord"],$zeile);
    $zeile=str_replace("\$tabbfont",$HTTP_POST_VARS["xtabbfont"],$zeile);
    $zeile=str_replace("\$tabbsize",$HTTP_POST_VARS["xtabbsize"],$zeile);
    $zeile=str_replace("\$tabcback",$HTTP_POST_VARS["xtabcback"],$zeile);
    $zeile=str_replace("\$tabcgrey",$HTTP_POST_VARS["xtabcgrey"],$zeile);
    $zeile=str_replace("\$tabccolo",$HTTP_POST_VARS["xtabccolo"],$zeile);
    $zeile=str_replace("\$tabcbord",$HTTP_POST_VARS["xtabcbord"],$zeile);
    $zeile=str_replace("\$tabcfont",$HTTP_POST_VARS["xtabcfont"],$zeile);
    $zeile=str_replace("\$tabcsize",$HTTP_POST_VARS["xtabcsize"],$zeile);
    $zeile=str_replace("\$tabclin1",$HTTP_POST_VARS["xtabclin1"],$zeile);
    $zeile=str_replace("\$tabclin2",$HTTP_POST_VARS["xtabclin2"],$zeile);
    $zeile=str_replace("\$tabftab1",$HTTP_POST_VARS["xtabftab1"],$zeile);
    $zeile=str_replace("\$tabftab2",$HTTP_POST_VARS["xtabftab2"],$zeile);
    $zeile=str_replace("\$tabftab3",$HTTP_POST_VARS["xtabftab3"],$zeile);
    $zeile=str_replace("\$tabftab4",$HTTP_POST_VARS["xtabftab4"],$zeile);
    $zeile=str_replace("\$tabftab5",$HTTP_POST_VARS["xtabftab5"],$zeile);
    $zeile=str_replace("\$tabftab6",$HTTP_POST_VARS["xtabftab6"],$zeile);
    $zeile=str_replace("\$tabftab7",$HTTP_POST_VARS["xtabftab7"],$zeile);
    $zeile=str_replace("\$tabftab8",$HTTP_POST_VARS["xtabftab8"],$zeile);
    $zeile=str_replace("\$tabftur1",$HTTP_POST_VARS["xtabftur1"],$zeile);
    $zeile=str_replace("\$tabftur2",$HTTP_POST_VARS["xtabftur2"],$zeile);
    $zeile=str_replace("\$tabftur3",$HTTP_POST_VARS["xtabftur3"],$zeile);
    $zeile=str_replace("\$tabftur4",$HTTP_POST_VARS["xtabftur4"],$zeile);
    $zeile=str_replace("\$tabhback",$HTTP_POST_VARS["xtabhback"],$zeile);
    $zeile=str_replace("\$tabwcolo",$HTTP_POST_VARS["xtabwcolo"],$zeile);
    $zeile=str_replace("\$tabtback",$HTTP_POST_VARS["xtabtback"],$zeile);
    $zeile=str_replace("\$tabtcolo",$HTTP_POST_VARS["xtabtcolo"],$zeile);
    $zeile=str_replace("\$tabtfont",$HTTP_POST_VARS["xtabtfont"],$zeile);
    $zeile=str_replace("\$tabtsize",$HTTP_POST_VARS["xtabtsize"],$zeile);
    $zeile=str_replace("\$tabeback",$HTTP_POST_VARS["xtabeback"],$zeile);
    $zeile=str_replace("\$tabecolo",$HTTP_POST_VARS["xtabecolo"],$zeile);
    $zeile=str_replace("\$tabkback",$HTTP_POST_VARS["xtabkback"],$zeile);
    $zeile=str_replace("\$tabkcolo",$HTTP_POST_VARS["xtabkcolo"],$zeile);
    fputs($datei,$zeile."\n");
    }
  }
  flock($datei,3);
  fclose($datei);
  fclose($date2);

  clearstatcache();
}
?>