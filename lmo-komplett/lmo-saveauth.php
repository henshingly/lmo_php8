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
    $datei = fopen($pswfile,"wb");
if (!$datei) {
    echo "<font color=\"#ff0000\">".$text[283]."</font>";
    exit;
}else{
    echo "<font color=\"#008800\">".$text[138]."</font>";
}
    flock($datei,2);
    for($i=1;$i<count($users);$i++){
      fputs($datei,$users[$i]."\n");
      }
    flock($datei,3);
    fclose($datei);

  clearstatcache();

  $users = array("");
  $datei = fopen($pswfile,"rb");
  while (!feof($datei)) {
    $zeile = fgets($datei,1000);
    $zeile=trim(chop($zeile));
    if($zeile!=""){
      if($zeile!=""){array_push($users,$zeile);}
      }
    }

    $datei = fopen($psw1file,"wb");
    flock($datei,2);
    for($i=1;$i<count($userf);$i++){
      if($save>0){
        $u1 = split("[|]",$userf[$i]);
        $u2 = split("[|]",$userf1);
        if((isset($u1)) && (isset($u2))){
          if($u1[0]==$u2[0]){$userf[$i]=$u2[2]."|".$u2[1]."|EOL";}
          }
        fputs($datei,$userf[$i]."\n");
        }
      elseif($del>0){
        $u1 = split("[|]",$userf[$i]);
        if(u1!=$userf1){fputs($datei,$userf[$i]."\n");}
        }
      else{
        fputs($datei,$userf[$i]."\n");
        }
      }
    if($save==-1){fputs($datei,$userf1."\n");}
    flock($datei,3);
    fclose($datei);

  $userf = array("");
  $datei = fopen($psw1file,"rb");
  while (!feof($datei)) {
    $zeile = fgets($datei,1000);
    $zeile=trim(chop($zeile));
    if($zeile!=""){
      if($zeile!=""){array_push($userf,$zeile);}
      }
    }
}
?>