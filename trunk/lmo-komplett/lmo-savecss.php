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
require_once(PATH_TO_LMO."/lmo-admintest.php");
if ($_SESSION['lmouserok']==2) {
  $css_root = fopen(PATH_TO_LMO."/lmo-style.txt","rb");
  $css_target = fopen(PATH_TO_LMO."/lmo-style.css","wb");
  if ($css_target) {
    echo "<font color=\"#008800\">".$text[138]."</font></br>";
    flock($css_target,LOCK_EX);
    while (!feof($css_root)) {
      $zeile = fgets($css_root,1000);
      $zeile=chop($zeile);
      if ($zeile!="") {
        if (isset($_POST["xtababack"]) $zeile=str_replace("$tababack",$_POST["xtababack"],$zeile);
        if (isset($_POST["xtabacolo"]) $zeile=str_replace("$tabacolo",$_POST["xtabacolo"],$zeile);
        if (isset($_POST["xtababord"]) $zeile=str_replace("$tababord",$_POST["xtababord"],$zeile);
        if (isset($_POST["xtabafont"]) $zeile=str_replace("$tabafont",$_POST["xtabafont"],$zeile);
        if (isset($_POST["xtabasize"]) $zeile=str_replace("$tabasize",$_POST["xtabasize"],$zeile);
        if (isset($_POST["xtabatite"]) $zeile=str_replace("$tabatite",$_POST["xtabatite"],$zeile);
        if (isset($_POST["xtabaupda"]) $zeile=str_replace("$tabaupda",$_POST["xtabaupda"],$zeile);
        if (isset($_POST["xtabacoti"]) $zeile=str_replace("$tabacoti",$_POST["xtabacoti"],$zeile);
        if (isset($_POST["xtabbback"]) $zeile=str_replace("$tabbback",$_POST["xtabbback"],$zeile);
        if (isset($_POST["xtabbcolo"]) $zeile=str_replace("$tabbcolo",$_POST["xtabbcolo"],$zeile);
        if (isset($_POST["xtabbbord"]) $zeile=str_replace("$tabbbord",$_POST["xtabbbord"],$zeile);
        if (isset($_POST["xtabbfont"]) $zeile=str_replace("$tabbfont",$_POST["xtabbfont"],$zeile);
        if (isset($_POST["xtabbsize"]) $zeile=str_replace("$tabbsize",$_POST["xtabbsize"],$zeile);
        if (isset($_POST["xtabcback"]) $zeile=str_replace("$tabcback",$_POST["xtabcback"],$zeile);
        if (isset($_POST["xtabcgrey"]) $zeile=str_replace("$tabcgrey",$_POST["xtabcgrey"],$zeile);
        if (isset($_POST["xtabccolo"]) $zeile=str_replace("$tabccolo",$_POST["xtabccolo"],$zeile);
        if (isset($_POST["xtabcbord"]) $zeile=str_replace("$tabcbord",$_POST["xtabcbord"],$zeile);
        if (isset($_POST["xtabcfont"]) $zeile=str_replace("$tabcfont",$_POST["xtabcfont"],$zeile);
        if (isset($_POST["xtabcsize"]) $zeile=str_replace("$tabcsize",$_POST["xtabcsize"],$zeile);
        if (isset($_POST["xtabclin1"]) $zeile=str_replace("$tabclin1",$_POST["xtabclin1"],$zeile);
        if (isset($_POST["xtabclin2"]) $zeile=str_replace("$tabclin2",$_POST["xtabclin2"],$zeile);
        if (isset($_POST["xtabftab1"]) $zeile=str_replace("$tabftab1",$_POST["xtabftab1"],$zeile);
        if (isset($_POST["xtabftab2"]) $zeile=str_replace("$tabftab2",$_POST["xtabftab2"],$zeile);
        if (isset($_POST["xtabftab3"]) $zeile=str_replace("$tabftab3",$_POST["xtabftab3"],$zeile);
        if (isset($_POST["xtabftab4"]) $zeile=str_replace("$tabftab4",$_POST["xtabftab4"],$zeile);
        if (isset($_POST["xtabftab5"]) $zeile=str_replace("$tabftab5",$_POST["xtabftab5"],$zeile);
        if (isset($_POST["xtabftab6"]) $zeile=str_replace("$tabftab6",$_POST["xtabftab6"],$zeile);
        if (isset($_POST["xtabftab7"]) $zeile=str_replace("$tabftab7",$_POST["xtabftab7"],$zeile);
        if (isset($_POST["xtabftab8"]) $zeile=str_replace("$tabftab8",$_POST["xtabftab8"],$zeile);
        if (isset($_POST["xtabftur1"]) $zeile=str_replace("$tabftur1",$_POST["xtabftur1"],$zeile);
        if (isset($_POST["xtabftur2"]) $zeile=str_replace("$tabftur2",$_POST["xtabftur2"],$zeile);
        if (isset($_POST["xtabftur3"]) $zeile=str_replace("$tabftur3",$_POST["xtabftur3"],$zeile);
        if (isset($_POST["xtabftur4"]) $zeile=str_replace("$tabftur4",$_POST["xtabftur4"],$zeile);
        if (isset($_POST["xtabhback"]) $zeile=str_replace("$tabhback",$_POST["xtabhback"],$zeile);
        if (isset($_POST["xtabwcolo"]) $zeile=str_replace("$tabwcolo",$_POST["xtabwcolo"],$zeile);
        if (isset($_POST["xtabtback"]) $zeile=str_replace("$tabtback",$_POST["xtabtback"],$zeile);
        if (isset($_POST["xtabtcolo"]) $zeile=str_replace("$tabtcolo",$_POST["xtabtcolo"],$zeile);
        if (isset($_POST["xtabtfont"]) $zeile=str_replace("$tabtfont",$_POST["xtabtfont"],$zeile);
        if (isset($_POST["xtabtsize"]) $zeile=str_replace("$tabtsize",$_POST["xtabtsize"],$zeile);
        if (isset($_POST["xtabeback"]) $zeile=str_replace("$tabeback",$_POST["xtabeback"],$zeile);
        if (isset($_POST["xtabecolo"]) $zeile=str_replace("$tabecolo",$_POST["xtabecolo"],$zeile);
        if (isset($_POST["xtabkback"]) $zeile=str_replace("$tabkback",$_POST["xtabkback"],$zeile);
        if (isset($_POST["xtabkcolo"]) $zeile=str_replace("$tabkcolo",$_POST["xtabkcolo"],$zeile);
        fputs($css_target,$zeile."\n");
      }
    }
  } else {
    echo "<font color=\"#ff0000\">".$text[283]."</font>";
  }
  @flock($css_target,LOCK_UN);
  @fclose($css_target);
  @fclose($css_root);
  clearstatcache();
  
  //NN4-Datei schreiben
  $css_root = fopen(PATH_TO_LMO."/lmo-style-nc.txt","rb");
  $css_target = fopen(PATH_TO_LMO."/lmo-style-nc.css","wb");
  if ($css_target) {
    echo "<font color=\"#008800\">".$text[138]."</font>";
    flock($css_target,LOCK_EX);
    while (!feof($css_root)) {
      $zeile = fgets($css_root,1000);
      $zeile=chop($zeile);
      if ($zeile!="") {
        if (isset($_POST["xtababack"]) $zeile=str_replace("$tababack",$_POST["xtababack"],$zeile);
        if (isset($_POST["xtabacolo"]) $zeile=str_replace("$tabacolo",$_POST["xtabacolo"],$zeile);
        if (isset($_POST["xtababord"]) $zeile=str_replace("$tababord",$_POST["xtababord"],$zeile);
        if (isset($_POST["xtabafont"]) $zeile=str_replace("$tabafont",$_POST["xtabafont"],$zeile);
        if (isset($_POST["xtabasize"]) $zeile=str_replace("$tabasize",$_POST["xtabasize"],$zeile);
        if (isset($_POST["xtabatite"]) $zeile=str_replace("$tabatite",$_POST["xtabatite"],$zeile);
        if (isset($_POST["xtabaupda"]) $zeile=str_replace("$tabaupda",$_POST["xtabaupda"],$zeile);
        if (isset($_POST["xtabacoti"]) $zeile=str_replace("$tabacoti",$_POST["xtabacoti"],$zeile);
        if (isset($_POST["xtabbback"]) $zeile=str_replace("$tabbback",$_POST["xtabbback"],$zeile);
        if (isset($_POST["xtabbcolo"]) $zeile=str_replace("$tabbcolo",$_POST["xtabbcolo"],$zeile);
        if (isset($_POST["xtabbbord"]) $zeile=str_replace("$tabbbord",$_POST["xtabbbord"],$zeile);
        if (isset($_POST["xtabbfont"]) $zeile=str_replace("$tabbfont",$_POST["xtabbfont"],$zeile);
        if (isset($_POST["xtabbsize"]) $zeile=str_replace("$tabbsize",$_POST["xtabbsize"],$zeile);
        if (isset($_POST["xtabcback"]) $zeile=str_replace("$tabcback",$_POST["xtabcback"],$zeile);
        if (isset($_POST["xtabcgrey"]) $zeile=str_replace("$tabcgrey",$_POST["xtabcgrey"],$zeile);
        if (isset($_POST["xtabccolo"]) $zeile=str_replace("$tabccolo",$_POST["xtabccolo"],$zeile);
        if (isset($_POST["xtabcbord"]) $zeile=str_replace("$tabcbord",$_POST["xtabcbord"],$zeile);
        if (isset($_POST["xtabcfont"]) $zeile=str_replace("$tabcfont",$_POST["xtabcfont"],$zeile);
        if (isset($_POST["xtabcsize"]) $zeile=str_replace("$tabcsize",$_POST["xtabcsize"],$zeile);
        if (isset($_POST["xtabclin1"]) $zeile=str_replace("$tabclin1",$_POST["xtabclin1"],$zeile);
        if (isset($_POST["xtabclin2"]) $zeile=str_replace("$tabclin2",$_POST["xtabclin2"],$zeile);
        if (isset($_POST["xtabftab1"]) $zeile=str_replace("$tabftab1",$_POST["xtabftab1"],$zeile);
        if (isset($_POST["xtabftab2"]) $zeile=str_replace("$tabftab2",$_POST["xtabftab2"],$zeile);
        if (isset($_POST["xtabftab3"]) $zeile=str_replace("$tabftab3",$_POST["xtabftab3"],$zeile);
        if (isset($_POST["xtabftab4"]) $zeile=str_replace("$tabftab4",$_POST["xtabftab4"],$zeile);
        if (isset($_POST["xtabftab5"]) $zeile=str_replace("$tabftab5",$_POST["xtabftab5"],$zeile);
        if (isset($_POST["xtabftab6"]) $zeile=str_replace("$tabftab6",$_POST["xtabftab6"],$zeile);
        if (isset($_POST["xtabftab7"]) $zeile=str_replace("$tabftab7",$_POST["xtabftab7"],$zeile);
        if (isset($_POST["xtabftab8"]) $zeile=str_replace("$tabftab8",$_POST["xtabftab8"],$zeile);
        if (isset($_POST["xtabftur1"]) $zeile=str_replace("$tabftur1",$_POST["xtabftur1"],$zeile);
        if (isset($_POST["xtabftur2"]) $zeile=str_replace("$tabftur2",$_POST["xtabftur2"],$zeile);
        if (isset($_POST["xtabftur3"]) $zeile=str_replace("$tabftur3",$_POST["xtabftur3"],$zeile);
        if (isset($_POST["xtabftur4"]) $zeile=str_replace("$tabftur4",$_POST["xtabftur4"],$zeile);
        if (isset($_POST["xtabhback"]) $zeile=str_replace("$tabhback",$_POST["xtabhback"],$zeile);
        if (isset($_POST["xtabwcolo"]) $zeile=str_replace("$tabwcolo",$_POST["xtabwcolo"],$zeile);
        if (isset($_POST["xtabtback"]) $zeile=str_replace("$tabtback",$_POST["xtabtback"],$zeile);
        if (isset($_POST["xtabtcolo"]) $zeile=str_replace("$tabtcolo",$_POST["xtabtcolo"],$zeile);
        if (isset($_POST["xtabtfont"]) $zeile=str_replace("$tabtfont",$_POST["xtabtfont"],$zeile);
        if (isset($_POST["xtabtsize"]) $zeile=str_replace("$tabtsize",$_POST["xtabtsize"],$zeile);
        if (isset($_POST["xtabeback"]) $zeile=str_replace("$tabeback",$_POST["xtabeback"],$zeile);
        if (isset($_POST["xtabecolo"]) $zeile=str_replace("$tabecolo",$_POST["xtabecolo"],$zeile);
        if (isset($_POST["xtabkback"]) $zeile=str_replace("$tabkback",$_POST["xtabkback"],$zeile);
        if (isset($_POST["xtabkcolo"]) $zeile=str_replace("$tabkcolo",$_POST["xtabkcolo"],$zeile);
        fputs($css_target,$zeile."\n");
      }
    }
  } else {
    echo "<font color=\"#ff0000\">".$text[283]."</font>";
  }
  @flock($css_target,LOCK_UN);
  @fclose($css_target);
  @fclose($css_root);
  clearstatcache();
}
?>