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
  if($action=="tipp"){require_once(PATH_TO_LMO."/lmo-tipptest.php");}
  elseif($action=="admin"){require_once(PATH_TO_LMO."/lmo-admintest.php");}

  $datei = fopen($pswfile,"wb");
  if(!$datei) {
    echo "<font color=\"#ff0000\">".$text[283]."</font>";
    exit;
    }
  else{
    echo "<font color=\"#008800\">".$text[138]."</font>";
    }
  flock($datei,2);
  for($i=1;$i<count($users);$i++){
    fputs($datei,$users[$i]."\n");
    }
  flock($datei,3);
  fclose($datei);
  clearstatcache();
?>