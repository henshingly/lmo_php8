<?
/** Liga Manager Online 4
  *
  * http://lmo.sourceforge.net/
  *
  * This program is free software; you can redistribute it and/or
  * modify it under the terms of the GNU General Public License as
  * published by the Free Software Foundation; either version 2 of
  * the License, or (at your option) any later version.
  * 
  * This program is distributed in the hope that it will be useful,
  * but WITHOUT ANY WARRANTY; without even the implied warranty of
  * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
  * General Public License for more details.
  *
  * REMOVING OR CHANGING THE COPYRIGHT NOTICES IS NOT ALLOWED!
  *
  */
  
  
session_start();
require(dirname(__FILE__)."/init.php");
if (!isset($_SESSION["lmouserok"]))$_SESSION["lmouserok"]==0;

$action=isset($_GET['action'])? $_GET['action']:'';
$todo=isset($_GET['todo'])  ? $_GET['todo']    :'';
$down=isset($_GET['down'])  ? $_GET['down']    :0;
$madr=isset($_GET['madr'])  ? $_GET['madr']    :'';
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
					"http://www.w3.org/TR/html4/loose.dtd">
<html lang="de">
<head>
<title>LMO Admin</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" >
<link rel="stylesheet" type="text/css" href="<?=URL_TO_LMO?>/lmo-style.php">
</head>
<body>
<div class="lmoMain">
<?
if (($action == "admin") && ($todo == "email") && (($_SESSION["lmouserok"] == 1) || ($_SESSION["lmouserok"] == 2))) {
  if (($down != 0) && ($madr != "")) {
    $array = array();
    $ftype = ".l98";
    $verz = opendir(substr($dirliga, 0, -1));
    $dummy = array();
    while ($files = readdir($verz)) {
      if (strtolower(substr($files, -4)) == $ftype) {
        array_push($dummy, $files);
      }
    }
    closedir($verz);
    sort($dummy);
    if ($down > 0) {
      if ($dummy[$down-1] != "" && check_hilfsadmin($dummy[$down-1])) {
        require(PATH_TO_LMO."/lmo-adminmimezip.php");
        $zipfile = new zipfile();
        $filedata = fread(fopen($dirliga.$dummy[$down-1], "rb"), filesize($dirliga.$dummy[$down-1]));
        $zipfile->add_file($filedata, $dummy[$down-1]);
        $mail = new mime_mail();
        $mail->from = $aadr;
        $mail->to = $madr;
        $mail->subject = $text[341];
        $mail->body = $text[342]."\n\n--------------------------------------------------\nSender: ".$_SERVER['REMOTE_ADDR']." (".$_SERVER['HTTP_USER_AGENT'].")\n";
        $mail->add_attachment($zipfile->file(), "lmo_".substr($dummy[$down-1], 0, -4).".zip", "application/octet-stream");
        if ($mail->send() === TRUE) {
          echo getMessage($text[348]);
        }else{
          echo getMessage($text[550],TRUE);
        }?>
  <p><script type="text/javascript">document.write('<a href="#" onclick="self.close();"><?=$text[347]?><\/a>');</script></p><?
      }
    }elseif($down==-1){
      if(count($dummy)>0){
        require(PATH_TO_LMO."/lmo-adminmimezip.php");
        $zipfile = new zipfile();
        for($i=0;$i<count($dummy);$i++){
          if (check_hilfsadmin($dummy[$i])) {
            $filedata = fread(fopen($dirliga.$dummy[$i], "rb"), filesize($dirliga.$dummy[$i]));
            $zipfile -> add_file($filedata, $dummy[$i]);
          }
        }
        $mail = new mime_mail();
        $mail->from = $aadr;
        $mail->to = $madr;
        $mail->subject = $text[341];
        $mail->body = $text[342]."\n\n--------------------------------------------------\nSender: ".$_SERVER['REMOTE_ADDR']." (".$_SERVER['HTTP_USER_AGENT'].")\n";
        $mail->add_attachment($zipfile -> file(), "lmo_".substr($dummy[$down-1],0,-4).".zip", "application/octet-stream");
        if ($mail->send()===TRUE){
          echo getMessage($text[348]);
        }else{
          echo getMessage($text[550],TRUE);
        }?>
  <p><script type="text/javascript">document.write('<a href="#" onclick="self.close();"><?=$text[347]?><\/a>');</script></p><?
      }
    }
  }else{?>
  <form action="<?=$_SERVER['PHP_SELF']?>">
    <label>Mailadresse: <input name="madr" type="text" class="lmo-formular-input" size="25" maxlength="128"></label>
    <input type="hidden" name="action" value="admin">
    <input type="hidden" name="todo" value="email">
    <input type="hidden" name="down" value="<?=$down?>">
    <input type="submit" value="Senden">
  </form>
  <p><script type="text/javascript">document.write('<a href="#" onclick="self.close();"><?=$text[347]?><\/a>');</script></p><?
  }
}?>
</body>
</html>