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
  $css_root = file(PATH_TO_LMO."/lmo-style.txt");
  $css_target = file(PATH_TO_LMO."/lmo-style.css");
  for($i=0;$i<count($css_root);$i++) {
    if ($css_root[$i]!="") {
      $css_target[$i]=isset($_POST["xtababack"])?str_replace('$tababack',$_POST["xtababack"],$css_root[$i]):$css_target[$i];
      $css_target[$i]=isset($_POST["xtabacolo"])?str_replace('$tabacolo',$_POST["xtabacolo"],$css_root[$i]):$css_target[$i];
      $css_target[$i]=isset($_POST["xtababord"])?str_replace('$tababord',$_POST["xtababord"],$css_root[$i]):$css_target[$i];
      $css_target[$i]=isset($_POST["xtabafont"])?str_replace('$tabafont',$_POST["xtabafont"],$css_root[$i]):$css_target[$i];
      $css_target[$i]=isset($_POST["xtabasize"])?str_replace('$tabasize',$_POST["xtabasize"],$css_root[$i]):$css_target[$i];
      $css_target[$i]=isset($_POST["xtabatite"])?str_replace('$tabatite',$_POST["xtabatite"],$css_root[$i]):$css_target[$i];
      $css_target[$i]=isset($_POST["xtabaupda"])?str_replace('$tabaupda',$_POST["xtabaupda"],$css_root[$i]):$css_target[$i];
      $css_target[$i]=isset($_POST["xtabacoti"])?str_replace('$tabacoti',$_POST["xtabacoti"],$css_root[$i]):$css_target[$i];
      $css_target[$i]=isset($_POST["xtabbback"])?str_replace('$tabbback',$_POST["xtabbback"],$css_root[$i]):$css_target[$i];
      $css_target[$i]=isset($_POST["xtabbcolo"])?str_replace('$tabbcolo',$_POST["xtabbcolo"],$css_root[$i]):$css_target[$i];
      $css_target[$i]=isset($_POST["xtabbbord"])?str_replace('$tabbbord',$_POST["xtabbbord"],$css_root[$i]):$css_target[$i];
      $css_target[$i]=isset($_POST["xtabbfont"])?str_replace('$tabbfont',$_POST["xtabbfont"],$css_root[$i]):$css_target[$i];
      $css_target[$i]=isset($_POST["xtabbsize"])?str_replace('$tabbsize',$_POST["xtabbsize"],$css_root[$i]):$css_target[$i];
      $css_target[$i]=isset($_POST["xtabcback"])?str_replace('$tabcback',$_POST["xtabcback"],$css_root[$i]):$css_target[$i];
      $css_target[$i]=isset($_POST["xtabcgrey"])?str_replace('$tabcgrey',$_POST["xtabcgrey"],$css_root[$i]):$css_target[$i];
      $css_target[$i]=isset($_POST["xtabccolo"])?str_replace('$tabccolo',$_POST["xtabccolo"],$css_root[$i]):$css_target[$i];
      $css_target[$i]=isset($_POST["xtabcbord"])?str_replace('$tabcbord',$_POST["xtabcbord"],$css_root[$i]):$css_target[$i];
      $css_target[$i]=isset($_POST["xtabcfont"])?str_replace('$tabcfont',$_POST["xtabcfont"],$css_root[$i]):$css_target[$i];
      $css_target[$i]=isset($_POST["xtabcsize"])?str_replace('$tabcsize',$_POST["xtabcsize"],$css_root[$i]):$css_target[$i];
      $css_target[$i]=isset($_POST["xtabclin1"])?str_replace('$tabclin1',$_POST["xtabclin1"],$css_root[$i]):$css_target[$i];
      $css_target[$i]=isset($_POST["xtabclin2"])?str_replace('$tabclin2',$_POST["xtabclin2"],$css_root[$i]):$css_target[$i];
      $css_target[$i]=isset($_POST["xtabftab1"])?str_replace('$tabftab1',$_POST["xtabftab1"],$css_root[$i]):$css_target[$i];
      $css_target[$i]=isset($_POST["xtabftab2"])?str_replace('$tabftab2',$_POST["xtabftab2"],$css_root[$i]):$css_target[$i];
      $css_target[$i]=isset($_POST["xtabftab3"])?str_replace('$tabftab3',$_POST["xtabftab3"],$css_root[$i]):$css_target[$i];
      $css_target[$i]=isset($_POST["xtabftab4"])?str_replace('$tabftab4',$_POST["xtabftab4"],$css_root[$i]):$css_target[$i];
      $css_target[$i]=isset($_POST["xtabftab5"])?str_replace('$tabftab5',$_POST["xtabftab5"],$css_root[$i]):$css_target[$i];
      $css_target[$i]=isset($_POST["xtabftab6"])?str_replace('$tabftab6',$_POST["xtabftab6"],$css_root[$i]):$css_target[$i];
      $css_target[$i]=isset($_POST["xtabftab7"])?str_replace('$tabftab7',$_POST["xtabftab7"],$css_root[$i]):$css_target[$i];
      $css_target[$i]=isset($_POST["xtabftab8"])?str_replace('$tabftab8',$_POST["xtabftab8"],$css_root[$i]):$css_target[$i];
      $css_target[$i]=isset($_POST["xtabftur1"])?str_replace('$tabftur1',$_POST["xtabftur1"],$css_root[$i]):$css_target[$i];
      $css_target[$i]=isset($_POST["xtabftur2"])?str_replace('$tabftur2',$_POST["xtabftur2"],$css_root[$i]):$css_target[$i];
      $css_target[$i]=isset($_POST["xtabftur3"])?str_replace('$tabftur3',$_POST["xtabftur3"],$css_root[$i]):$css_target[$i];
      $css_target[$i]=isset($_POST["xtabftur4"])?str_replace('$tabftur4',$_POST["xtabftur4"],$css_root[$i]):$css_target[$i];
      $css_target[$i]=isset($_POST["xtabhback"])?str_replace('$tabhback',$_POST["xtabhback"],$css_root[$i]):$css_target[$i];
      $css_target[$i]=isset($_POST["xtabwcolo"])?str_replace('$tabwcolo',$_POST["xtabwcolo"],$css_root[$i]):$css_target[$i];
      $css_target[$i]=isset($_POST["xtabtback"])?str_replace('$tabtback',$_POST["xtabtback"],$css_root[$i]):$css_target[$i];
      $css_target[$i]=isset($_POST["xtabtcolo"])?str_replace('$tabtcolo',$_POST["xtabtcolo"],$css_root[$i]):$css_target[$i];
      $css_target[$i]=isset($_POST["xtabtfont"])?str_replace('$tabtfont',$_POST["xtabtfont"],$css_root[$i]):$css_target[$i];
      $css_target[$i]=isset($_POST["xtabtsize"])?str_replace('$tabtsize',$_POST["xtabtsize"],$css_root[$i]):$css_target[$i];
      $css_target[$i]=isset($_POST["xtabeback"])?str_replace('$tabeback',$_POST["xtabeback"],$css_root[$i]):$css_target[$i];
      $css_target[$i]=isset($_POST["xtabecolo"])?str_replace('$tabecolo',$_POST["xtabecolo"],$css_root[$i]):$css_target[$i];
      $css_target[$i]=isset($_POST["xtabkback"])?str_replace('$tabkback',$_POST["xtabkback"],$css_root[$i]):$css_target[$i];
      $css_target[$i]=isset($_POST["xtabkcolo"])?str_replace('$tabkcolo',$_POST["xtabkcolo"],$css_root[$i]):$css_target[$i];
    }
  }
  print_r($css_target);
  if ($write_file=fopen(PATH_TO_LMO."/lmo-style.css","wb")){
    flock($write_file,LOCK_EX);
    foreach($css_target as $css_line) {
      fputs($write_file,$css_line);
    }
    flock($write_file,LOCK_UN);
    echo "<font color=\"#008800\">".$text[138]."</font><br>";
  } else {
    echo "<font color=\"#ff0000\">".$text[283]."</font>";
  }
  clearstatcache();
  
  //NN4-Datei schreiben
    $css_root = file(PATH_TO_LMO."/lmo-style-nc.txt");
  $css_target = file(PATH_TO_LMO."/lmo-style-nc.css");
  for($i=0;$i<count($css_root);$i++) {
    if ($css_root[$i]!="") {
      $css_target[$i]=isset($_POST["xtababack"])?str_replace('$tababack',$_POST["xtababack"],$css_root[$i]):$css_target[$i];
      $css_target[$i]=isset($_POST["xtabacolo"])?str_replace('$tabacolo',$_POST["xtabacolo"],$css_root[$i]):$css_target[$i];
      $css_target[$i]=isset($_POST["xtababord"])?str_replace('$tababord',$_POST["xtababord"],$css_root[$i]):$css_target[$i];
      $css_target[$i]=isset($_POST["xtabafont"])?str_replace('$tabafont',$_POST["xtabafont"],$css_root[$i]):$css_target[$i];
      $css_target[$i]=isset($_POST["xtabasize"])?str_replace('$tabasize',$_POST["xtabasize"],$css_root[$i]):$css_target[$i];
      $css_target[$i]=isset($_POST["xtabatite"])?str_replace('$tabatite',$_POST["xtabatite"],$css_root[$i]):$css_target[$i];
      $css_target[$i]=isset($_POST["xtabaupda"])?str_replace('$tabaupda',$_POST["xtabaupda"],$css_root[$i]):$css_target[$i];
      $css_target[$i]=isset($_POST["xtabacoti"])?str_replace('$tabacoti',$_POST["xtabacoti"],$css_root[$i]):$css_target[$i];
      $css_target[$i]=isset($_POST["xtabbback"])?str_replace('$tabbback',$_POST["xtabbback"],$css_root[$i]):$css_target[$i];
      $css_target[$i]=isset($_POST["xtabbcolo"])?str_replace('$tabbcolo',$_POST["xtabbcolo"],$css_root[$i]):$css_target[$i];
      $css_target[$i]=isset($_POST["xtabbbord"])?str_replace('$tabbbord',$_POST["xtabbbord"],$css_root[$i]):$css_target[$i];
      $css_target[$i]=isset($_POST["xtabbfont"])?str_replace('$tabbfont',$_POST["xtabbfont"],$css_root[$i]):$css_target[$i];
      $css_target[$i]=isset($_POST["xtabbsize"])?str_replace('$tabbsize',$_POST["xtabbsize"],$css_root[$i]):$css_target[$i];
      $css_target[$i]=isset($_POST["xtabcback"])?str_replace('$tabcback',$_POST["xtabcback"],$css_root[$i]):$css_target[$i];
      $css_target[$i]=isset($_POST["xtabcgrey"])?str_replace('$tabcgrey',$_POST["xtabcgrey"],$css_root[$i]):$css_target[$i];
      $css_target[$i]=isset($_POST["xtabccolo"])?str_replace('$tabccolo',$_POST["xtabccolo"],$css_root[$i]):$css_target[$i];
      $css_target[$i]=isset($_POST["xtabcbord"])?str_replace('$tabcbord',$_POST["xtabcbord"],$css_root[$i]):$css_target[$i];
      $css_target[$i]=isset($_POST["xtabcfont"])?str_replace('$tabcfont',$_POST["xtabcfont"],$css_root[$i]):$css_target[$i];
      $css_target[$i]=isset($_POST["xtabcsize"])?str_replace('$tabcsize',$_POST["xtabcsize"],$css_root[$i]):$css_target[$i];
      $css_target[$i]=isset($_POST["xtabclin1"])?str_replace('$tabclin1',$_POST["xtabclin1"],$css_root[$i]):$css_target[$i];
      $css_target[$i]=isset($_POST["xtabclin2"])?str_replace('$tabclin2',$_POST["xtabclin2"],$css_root[$i]):$css_target[$i];
      $css_target[$i]=isset($_POST["xtabftab1"])?str_replace('$tabftab1',$_POST["xtabftab1"],$css_root[$i]):$css_target[$i];
      $css_target[$i]=isset($_POST["xtabftab2"])?str_replace('$tabftab2',$_POST["xtabftab2"],$css_root[$i]):$css_target[$i];
      $css_target[$i]=isset($_POST["xtabftab3"])?str_replace('$tabftab3',$_POST["xtabftab3"],$css_root[$i]):$css_target[$i];
      $css_target[$i]=isset($_POST["xtabftab4"])?str_replace('$tabftab4',$_POST["xtabftab4"],$css_root[$i]):$css_target[$i];
      $css_target[$i]=isset($_POST["xtabftab5"])?str_replace('$tabftab5',$_POST["xtabftab5"],$css_root[$i]):$css_target[$i];
      $css_target[$i]=isset($_POST["xtabftab6"])?str_replace('$tabftab6',$_POST["xtabftab6"],$css_root[$i]):$css_target[$i];
      $css_target[$i]=isset($_POST["xtabftab7"])?str_replace('$tabftab7',$_POST["xtabftab7"],$css_root[$i]):$css_target[$i];
      $css_target[$i]=isset($_POST["xtabftab8"])?str_replace('$tabftab8',$_POST["xtabftab8"],$css_root[$i]):$css_target[$i];
      $css_target[$i]=isset($_POST["xtabftur1"])?str_replace('$tabftur1',$_POST["xtabftur1"],$css_root[$i]):$css_target[$i];
      $css_target[$i]=isset($_POST["xtabftur2"])?str_replace('$tabftur2',$_POST["xtabftur2"],$css_root[$i]):$css_target[$i];
      $css_target[$i]=isset($_POST["xtabftur3"])?str_replace('$tabftur3',$_POST["xtabftur3"],$css_root[$i]):$css_target[$i];
      $css_target[$i]=isset($_POST["xtabftur4"])?str_replace('$tabftur4',$_POST["xtabftur4"],$css_root[$i]):$css_target[$i];
      $css_target[$i]=isset($_POST["xtabhback"])?str_replace('$tabhback',$_POST["xtabhback"],$css_root[$i]):$css_target[$i];
      $css_target[$i]=isset($_POST["xtabwcolo"])?str_replace('$tabwcolo',$_POST["xtabwcolo"],$css_root[$i]):$css_target[$i];
      $css_target[$i]=isset($_POST["xtabtback"])?str_replace('$tabtback',$_POST["xtabtback"],$css_root[$i]):$css_target[$i];
      $css_target[$i]=isset($_POST["xtabtcolo"])?str_replace('$tabtcolo',$_POST["xtabtcolo"],$css_root[$i]):$css_target[$i];
      $css_target[$i]=isset($_POST["xtabtfont"])?str_replace('$tabtfont',$_POST["xtabtfont"],$css_root[$i]):$css_target[$i];
      $css_target[$i]=isset($_POST["xtabtsize"])?str_replace('$tabtsize',$_POST["xtabtsize"],$css_root[$i]):$css_target[$i];
      $css_target[$i]=isset($_POST["xtabeback"])?str_replace('$tabeback',$_POST["xtabeback"],$css_root[$i]):$css_target[$i];
      $css_target[$i]=isset($_POST["xtabecolo"])?str_replace('$tabecolo',$_POST["xtabecolo"],$css_root[$i]):$css_target[$i];
      $css_target[$i]=isset($_POST["xtabkback"])?str_replace('$tabkback',$_POST["xtabkback"],$css_root[$i]):$css_target[$i];
      $css_target[$i]=isset($_POST["xtabkcolo"])?str_replace('$tabkcolo',$_POST["xtabkcolo"],$css_root[$i]):$css_target[$i];
    }
  }
  if ($write_file=fopen(PATH_TO_LMO."/lmo-style-nc.css","wb")){
    flock($write_file,LOCK_EX);
    foreach($css_target as $css_line) {
      fputs($write_file,$css_line);
    }
    flock($write_file,LOCK_UN);
    echo "<font color=\"#008800\">".$text[138]."</font><br>";
  } else {
    echo "<font color=\"#ff0000\">".$text[283]."</font>";
  }
  clearstatcache();
}
?>