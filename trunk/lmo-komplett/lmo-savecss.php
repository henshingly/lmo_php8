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
if($_SESSION['lmouserok']==2){
  $css_root = fopen("lmo-style.txt","rb");
  $css_target = fopen("lmo-style.css","wb");
  if ($css_target) {
    echo "<font color=\"#008800\">".$text[138]."</font>";
    flock($css_target,LOCK_EX);
  while (!feof($css_root)) {
    $zeile = fgets($css_root,1000);
    $zeile=chop($zeile);
    if($zeile!=""){
      $zeile=str_replace("\$tababack",$_POST["xtababack"],$zeile);
      $zeile=str_replace("\$tabacolo",$_POST["xtabacolo"],$zeile);
      $zeile=str_replace("\$tababord",$_POST["xtababord"],$zeile);
      $zeile=str_replace("\$tabafont",$_POST["xtabafont"],$zeile);
      $zeile=str_replace("\$tabasize",$_POST["xtabasize"],$zeile);
      $zeile=str_replace("\$tabatite",$_POST["xtabatite"],$zeile);
      $zeile=str_replace("\$tabaupda",$_POST["xtabaupda"],$zeile);
      $zeile=str_replace("\$tabacoti",$_POST["xtabacoti"],$zeile);
      $zeile=str_replace("\$tabbback",$_POST["xtabbback"],$zeile);
      $zeile=str_replace("\$tabbcolo",$_POST["xtabbcolo"],$zeile);
      $zeile=str_replace("\$tabbbord",$_POST["xtabbbord"],$zeile);
      $zeile=str_replace("\$tabbfont",$_POST["xtabbfont"],$zeile);
      $zeile=str_replace("\$tabbsize",$_POST["xtabbsize"],$zeile);
      $zeile=str_replace("\$tabcback",$_POST["xtabcback"],$zeile);
      $zeile=str_replace("\$tabcgrey",$_POST["xtabcgrey"],$zeile);
      $zeile=str_replace("\$tabccolo",$_POST["xtabccolo"],$zeile);
      $zeile=str_replace("\$tabcbord",$_POST["xtabcbord"],$zeile);
      $zeile=str_replace("\$tabcfont",$_POST["xtabcfont"],$zeile);
      $zeile=str_replace("\$tabcsize",$_POST["xtabcsize"],$zeile);
      $zeile=str_replace("\$tabclin1",$_POST["xtabclin1"],$zeile);
      $zeile=str_replace("\$tabclin2",$_POST["xtabclin2"],$zeile);
      $zeile=str_replace("\$tabftab1",$_POST["xtabftab1"],$zeile);
      $zeile=str_replace("\$tabftab2",$_POST["xtabftab2"],$zeile);
      $zeile=str_replace("\$tabftab3",$_POST["xtabftab3"],$zeile);
      $zeile=str_replace("\$tabftab4",$_POST["xtabftab4"],$zeile);
      $zeile=str_replace("\$tabftab5",$_POST["xtabftab5"],$zeile);
      $zeile=str_replace("\$tabftab6",$_POST["xtabftab6"],$zeile);
      $zeile=str_replace("\$tabftab7",$_POST["xtabftab7"],$zeile);
      $zeile=str_replace("\$tabftab8",$_POST["xtabftab8"],$zeile);
      $zeile=str_replace("\$tabftur1",$_POST["xtabftur1"],$zeile);
      $zeile=str_replace("\$tabftur2",$_POST["xtabftur2"],$zeile);
      $zeile=str_replace("\$tabftur3",$_POST["xtabftur3"],$zeile);
      $zeile=str_replace("\$tabftur4",$_POST["xtabftur4"],$zeile);
      $zeile=str_replace("\$tabhback",$_POST["xtabhback"],$zeile);
      $zeile=str_replace("\$tabwcolo",$_POST["xtabwcolo"],$zeile);
      $zeile=str_replace("\$tabtback",$_POST["xtabtback"],$zeile);
      $zeile=str_replace("\$tabtcolo",$_POST["xtabtcolo"],$zeile);
      $zeile=str_replace("\$tabtfont",$_POST["xtabtfont"],$zeile);
      $zeile=str_replace("\$tabtsize",$_POST["xtabtsize"],$zeile);
      $zeile=str_replace("\$tabeback",$_POST["xtabeback"],$zeile);
      $zeile=str_replace("\$tabecolo",$_POST["xtabecolo"],$zeile);
      $zeile=str_replace("\$tabkback",$_POST["xtabkback"],$zeile);
      $zeile=str_replace("\$tabkcolo",$_POST["xtabkcolo"],$zeile);
      fputs($css_target,$zeile."\n");
    }
  }
  }else{
    echo "<font color=\"#ff0000\">".$text[283]."</font>";
  }
  @flock($css_target,LOCK_UN);
  @fclose($css_target);
  @fclose($css_root);
  clearstatcache();
  
  //NN4-Datei schreiben
  $css_root = fopen("lmo-style-nc.txt","rb");
  $css_target = fopen("lmo-style-nc.css","wb");
  if ($css_target) {
    echo "<font color=\"#008800\">".$text[138]."</font>";
    flock($css_target,LOCK_EX);
  while (!feof($css_root)) {
    $zeile = fgets($css_root,1000);
    $zeile=chop($zeile);
    if($zeile!=""){
      $zeile=str_replace("\$tababack",$_POST["xtababack"],$zeile);
      $zeile=str_replace("\$tabacolo",$_POST["xtabacolo"],$zeile);
      $zeile=str_replace("\$tababord",$_POST["xtababord"],$zeile);
      $zeile=str_replace("\$tabafont",$_POST["xtabafont"],$zeile);
      $zeile=str_replace("\$tabasize",$_POST["xtabasize"],$zeile);
      $zeile=str_replace("\$tabatite",$_POST["xtabatite"],$zeile);
      $zeile=str_replace("\$tabaupda",$_POST["xtabaupda"],$zeile);
      $zeile=str_replace("\$tabacoti",$_POST["xtabacoti"],$zeile);
      $zeile=str_replace("\$tabbback",$_POST["xtabbback"],$zeile);
      $zeile=str_replace("\$tabbcolo",$_POST["xtabbcolo"],$zeile);
      $zeile=str_replace("\$tabbbord",$_POST["xtabbbord"],$zeile);
      $zeile=str_replace("\$tabbfont",$_POST["xtabbfont"],$zeile);
      $zeile=str_replace("\$tabbsize",$_POST["xtabbsize"],$zeile);
      $zeile=str_replace("\$tabcback",$_POST["xtabcback"],$zeile);
      $zeile=str_replace("\$tabcgrey",$_POST["xtabcgrey"],$zeile);
      $zeile=str_replace("\$tabccolo",$_POST["xtabccolo"],$zeile);
      $zeile=str_replace("\$tabcbord",$_POST["xtabcbord"],$zeile);
      $zeile=str_replace("\$tabcfont",$_POST["xtabcfont"],$zeile);
      $zeile=str_replace("\$tabcsize",$_POST["xtabcsize"],$zeile);
      $zeile=str_replace("\$tabclin1",$_POST["xtabclin1"],$zeile);
      $zeile=str_replace("\$tabclin2",$_POST["xtabclin2"],$zeile);
      $zeile=str_replace("\$tabftab1",$_POST["xtabftab1"],$zeile);
      $zeile=str_replace("\$tabftab2",$_POST["xtabftab2"],$zeile);
      $zeile=str_replace("\$tabftab3",$_POST["xtabftab3"],$zeile);
      $zeile=str_replace("\$tabftab4",$_POST["xtabftab4"],$zeile);
      $zeile=str_replace("\$tabftab5",$_POST["xtabftab5"],$zeile);
      $zeile=str_replace("\$tabftab6",$_POST["xtabftab6"],$zeile);
      $zeile=str_replace("\$tabftab7",$_POST["xtabftab7"],$zeile);
      $zeile=str_replace("\$tabftab8",$_POST["xtabftab8"],$zeile);
      $zeile=str_replace("\$tabftur1",$_POST["xtabftur1"],$zeile);
      $zeile=str_replace("\$tabftur2",$_POST["xtabftur2"],$zeile);
      $zeile=str_replace("\$tabftur3",$_POST["xtabftur3"],$zeile);
      $zeile=str_replace("\$tabftur4",$_POST["xtabftur4"],$zeile);
      $zeile=str_replace("\$tabhback",$_POST["xtabhback"],$zeile);
      $zeile=str_replace("\$tabwcolo",$_POST["xtabwcolo"],$zeile);
      $zeile=str_replace("\$tabtback",$_POST["xtabtback"],$zeile);
      $zeile=str_replace("\$tabtcolo",$_POST["xtabtcolo"],$zeile);
      $zeile=str_replace("\$tabtfont",$_POST["xtabtfont"],$zeile);
      $zeile=str_replace("\$tabtsize",$_POST["xtabtsize"],$zeile);
      $zeile=str_replace("\$tabeback",$_POST["xtabeback"],$zeile);
      $zeile=str_replace("\$tabecolo",$_POST["xtabecolo"],$zeile);
      $zeile=str_replace("\$tabkback",$_POST["xtabkback"],$zeile);
      $zeile=str_replace("\$tabkcolo",$_POST["xtabkcolo"],$zeile);
      fputs($css_target,$zeile."\n");
    }
  }
  }else{
    echo "<font color=\"#ff0000\">".$text[283]."</font>";
  }
  @flock($css_target,LOCK_UN);
  @fclose($css_target);
  @fclose($css_root);
  clearstatcache();
}
?>