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
if(($action=="admin") && ($todo=="email") && (($HTTP_SESSION_VARS["lmouserok"]==1) || ($HTTP_SESSION_VARS["lmouserok"]==2))){
  if(($down!=0) && ($madr!="")){
    $array = array("");
    require("lmo-cfgload.php");
    require("lmo-langload.php");
    $ftype=".l98";
    $verz=opendir(substr($dirliga,0,-1));
    $dummy=array("");
    while($files=readdir($verz)){
      if(strtolower(substr($files,-4))==$ftype){array_push($dummy,$files);}
      }
    closedir($verz);
    array_shift($dummy);
    sort($dummy);
    if($down>0){
      if($dummy[$down-1]!=""){
        require("lmo-adminmimezip.php");
        $zipfile = new zipfile();
        $filedata = fread(fopen($dirliga.$dummy[$down-1], "rb"), filesize($dirliga.$dummy[$down-1]));   
        $zipfile -> add_file($filedata, $dummy[$down-1]);   
        $mail = new mime_mail();
        $mail->from = $aadr;
        $mail->to = $madr;
        $mail->subject = $text[341];
        $mail->body = $text[342]."\n\n--------------------------------------------------\nSender: ".$REMOTE_ADDR." (".$HTTP_USER_AGENT.")\n";
        $mail->add_attachment($zipfile -> file(), "lmo_".substr($dummy[$down-1],0,-4).".zip", "application/octet-stream");
        $mail->send();
        echo "<link rel=stylesheet type=\"text/css\" href=\"lmo-style.css\"><center>&nbsp;<br><span class=\"lmofett\">".$text[348]."</span><br><br><form><input class=\"lmoadminbut\" type=\"button\" value=\"".$text[347]."\" onClick=\"self.close();\"></form></center>";
        }
      }
    elseif($down==-1){
      if(count($dummy)>0){
        require("lmo-adminmimezip.php");
        $zipfile = new zipfile();
        for($i=0;$i<count($dummy);$i++){
          $filedata = fread(fopen($dirliga.$dummy[$i], "rb"), filesize($dirliga.$dummy[$i]));
          $zipfile -> add_file($filedata, $dummy[$i]);
          }
        $mail = new mime_mail();
        $mail->from = $aadr;
        $mail->to = $madr;
        $mail->subject = $text[341];
        $mail->body = $text[342]."\n\n--------------------------------------------------\nSender: ".$REMOTE_ADDR." (".$HTTP_USER_AGENT.")\n";
        $mail->add_attachment($zipfile -> file(), "lmo_".substr($dummy[$down-1],0,-4).".zip", "application/octet-stream");
        $mail->send();
        echo "<link rel=stylesheet type=\"text/css\" href=\"lmo-style.css\"><center>&nbsp;<br><span class=\"lmofett\">".$text[348]."</span><br><br><form><input class=\"lmoadminbut\" type=\"button\" value=\"".$text[347]."\" onClick=\"self.close();\"></form></center>";
        }
      }
    }
  }
?>