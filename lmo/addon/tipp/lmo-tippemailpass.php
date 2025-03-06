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


require_once(PATH_TO_ADDONDIR . "/tipp/lmo-tipptest.php");
require_once(PATH_TO_LMO . "/includes/PHPMailer.php");

if (isset($xtippername2)) {
  $dumma = array();
  $pswfile = PATH_TO_ADDONDIR . "/tipp/" . $tipp_tippauthtxt;

  $dumma = file($pswfile);
  $mail = new PHPMailer(TRUE);
  $mail->isMail();
  $mail->CharSet = "UTF-8";
  $mail->Subject = $text['tipp'][79] . " (" . $_SERVER["HTTP_HOST"] . ")";
  $mail->setFrom($aadr, $text['tipp'][92]);

  for ($i = 0; $i < count($dumma) && $_SESSION["lmotipperok"] == -5; $i ++) {
    $dummb = explode('|', $dumma[$i]);
    if ($xtippername2 == $dummb[0] || ($xtippername2 == $dummb[4] && str_contains($dummb[4], '@'))) {
    //if ($xtippername2 == $dummb[0] || ($xtippername2 == $dummb[4] && strpos($dummb[4], "@") != FALSE)) {
      // User gefunden
      $_SESSION['lmotippername'] = $dummb[0];
      $_SESSION["lmotipperok"] = 0;
      $emailbody = $text['tipp'][297] . " " . $dummb[0] . "\n\n" . $text['tipp'][77] . "\n\n" . $text['tipp'][23] . ": " . $dummb[0] . "\n" . $text[308] . ": " . $dummb[1] . "\n\n" . str_replace(array('\n', '[url]'), array("\n", $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . "?action=tipp&xtippername=" . $dummb[0] . "&xtipperpass=" . $dummb[1]), $text['tipp'][255]);
      $mail->Body = $emailbody;
      $mail->addAddress($dummb[4]);
      if ($mail->send()) {
        echo $text['tipp'][78] . "<br>";
      } else {
        echo $text['tipp'][80] . " Details: {$mail->ErrorInfo}<br>";
      }
      $xtippername2 = "";
    }
  }
  if ($_SESSION["lmotipperok"] == -5) {
    $_SESSION["lmotipperok"] = -3;
  } // Benutzer nicht gefunden
} else {
  $_SESSION["lmotipperok"] = 0;
} // kein Name angegeben
?>