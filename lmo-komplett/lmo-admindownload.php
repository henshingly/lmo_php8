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
$lmouserok=0;
session_start();
session_register("lmouserok","lmousername","lmouserpass","lmouserfile");
if(isset($HTTP_SESSION_VARS["lmouserok"])){$lmouserok=$HTTP_SESSION_VARS["lmouserok"];}
if(isset($HTTP_SESSION_VARS["lmousername"])){$lmousername=$HTTP_SESSION_VARS["lmousername"];}
if(isset($HTTP_SESSION_VARS["lmouserpass"])){$lmouserpass=$HTTP_SESSION_VARS["lmouserpass"];}
if(isset($HTTP_SESSION_VARS["lmouserfile"])){$lmouserfile=$HTTP_SESSION_VARS["lmouserfile"];}
if(($action=="admin") && ($todo=="download") && (($HTTP_SESSION_VARS["lmouserok"]==1) || ($HTTP_SESSION_VARS["lmouserok"]==2))){
  if($down>0){
    require("lmo-cfgload.php");
    $ftype=".l98";
    $verz=opendir(substr($dirliga,0,-1));
    $dummy=array("");
    while($files=readdir($verz)){
      if(strtolower(substr($files,-4))==$ftype){array_push($dummy,$files);}
      }
    closedir($verz);
    array_shift($dummy);
    sort($dummy);
    if($dummy[$down-1]!=""){
      header("Content-Type: text/lmo3");
      header("Content-Disposition: attachment; filename=\"".$dummy[$down-1]."\"");
      readfile(sprintf("%s/%s", $dirliga, $dummy[$down-1]));
      }
    }
  elseif($down==-1){
    require("lmo-cfgload.php");
    require("lmo-adminmimezip.php");
    $ftype=".l98";
    $verz=opendir(substr($dirliga,0,-1));
    $dummy=array("");
    while($files=readdir($verz)){
      if(strtolower(substr($files,-4))==$ftype){array_push($dummy,$files);}
      }
    closedir($verz);
    array_shift($dummy);
    sort($dummy);
    if(count($dummy)>0){
      $zipfile = new zipfile();
      for($i=0;$i<count($dummy);$i++){
        $filedata = fread(fopen($dirliga.$dummy[$i], "rb"), filesize($dirliga.$dummy[$i]));
        $zipfile -> add_file($filedata, $dummy[$i]);
        }
      header("Content-Type: text/lmo3");
      header("Content-Disposition: attachment; filename=\"ligen.zip\"");
      echo $zipfile -> file();
      }
    }
  }
?>