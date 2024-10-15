<?php 
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
require(__DIR__."/init.php");
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
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" >
<link rel="stylesheet" type="text/css" href="<?php echo URL_TO_LMO?>/lmo-style.php">
</head>
<body>
<div class="lmoMain">
<?php 
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
    $temp = $diroutput."ligen.zip";
    require(PATH_TO_LMO."/includes/PHPMailer.php");
    if ($down > 0) {
      if ($dummy[$down-1] != "" && check_hilfsadmin($dummy[$down-1])) {
        $zipfile = new ZipArchive;
        $zipfile->open($temp, ZipArchive::CREATE);
        $zipfile->addFile(PATH_TO_LMO."/".$dirliga.$dummy[$down-1], $dummy[$down-1]);
        $zipfile->close();
        $mail = new PHPMailer(true);
        $mail->isMail();
        $mail->setFrom($aadr);
        $mail->addAddress($madr);
        $mail->Subject = $text[341];
        $mail->Body = $text[342];
        $mail->addAttachment($temp, $dummy[$down-1].".zip");
        if ($mail->send()) {
          echo getMessage($text[348]);
          $mail->ClearAllRecipients(); 
          $mail->ClearReplyTos();
        } else {
          $mail->ErrorInfo();
          $mail->ClearAllRecipients(); 
          $mail->ClearReplyTos();
        }?>
  <p><script type="text/javascript">document.write('<a href="#" onclick="self.close();"><?php echo $text[347]?><\/a>');</script></p><?php 
      }
    } elseif($down==-1) {
      if (count($dummy)>0) {
        $zipfile = new ZipArchive;
        $zipfile->open($temp, ZipArchive::CREATE);
        for($i=0;$i<count($dummy);$i++){
          if (check_hilfsadmin($dummy[$i])) {
            $zipfile->addFile(PATH_TO_LMO."/".$dirliga.$dummy[$i], $dummy[$i]);
          }
        }
        $zipfile->close();
        $mail = new PHPMailer(true);
        $mail->isMail();
        $mail->setFrom($aadr);
        $mail->addAddress($madr);
        $mail->Subject = $text[341];
        $mail->Body = $text[342];
        $mail->addAttachment($temp);
        if ($mail->send()) {
          echo getMessage($text[348]);
          $mail->ClearAllRecipients(); 
          $mail->ClearReplyTos();
        } else {
          $mail->ErrorInfo();
          $mail->ClearAllRecipients(); 
          $mail->ClearReplyTos();
        }?>
  <p><script type="text/javascript">document.write('<a href="#" onclick="self.close();"><?php echo $text[347]?><\/a>');</script></p><?php 
      }
    }
    unlink($temp);
  } else {?>
  <form action="<?php echo $_SERVER['PHP_SELF']?>">
    <label>Mailadresse: <input name="madr" type="text" class="lmo-formular-input" size="25" maxlength="128"></label>
    <input type="hidden" name="action" value="admin">
    <input type="hidden" name="todo" value="email">
    <input type="hidden" name="down" value="<?php echo $down?>">
    <input type="submit" value="Senden">
  </form>
  <p><script type="text/javascript">document.write('<a href="#" onclick="self.close();"><?php echo $text[347]?><\/a>');</script></p><?php 
  }
}?>
</body>
</html>
