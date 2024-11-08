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
require_once(PATH_TO_LMO . '/includes/PHPMailer.php');

$mail = new PHPMailer(true);
$tipp_mailtext = str_replace(array('\n', '[nick]', '[pass]', '[url]'), array("\n", $xtippernick, $xtipperpass,  $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . "?action=tipp&xtippername=" . $xtippernick . "&xtipperpass=" . $xtipperpass), $text['tipp'][298]);

$mail->isMail();
$mail->CharSet = "UTF-8";
$mail->Subject $text['tipp'][77] . ' (' . $_SERVER['HTTP_HOST'] . ')';
$mail->setFrom($aadr, $text['tipp'][92]);

$mail->Body = $tipp_mailtext;
$mail->addAddress($xtipperemail, $xtippernick);
if ($mail->send()) {
  echo getMessage($text['tipp'][78]);
} else {
  echo getMessage($text['tipp'][80]  . " Details: {$mail->ErrorInfo}", true);
}
?>