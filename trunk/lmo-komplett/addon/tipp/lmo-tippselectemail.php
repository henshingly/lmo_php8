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
  require_once(PATH_TO_LMO."/lmo-admintest.php");
  $dumma = array("");
  $pswfile=PATH_TO_ADDONDIR."/tipp/".$tipp_tippauthtxt;
  $datei = fopen($pswfile,"rb");
  while (!feof($datei)) {
    $zeile = fgets($datei,1000);
    $zeile=chop($zeile);
    if($zeile!=""){array_push($dumma,$zeile);}
    }
  fclose($datei);
  array_shift($dumma);

  sort($dumma,SORT_STRING);
  for($i=0;$i<count($dumma);$i++){
    $dummb = split("[|]",$dumma[$i]);
    echo "<option value=\"".$dummb[0]."\" ";
    echo ">".$dummb[0]." (".$dummb[3]." - ".$dummb[4].")"."</option>";
    }
?>