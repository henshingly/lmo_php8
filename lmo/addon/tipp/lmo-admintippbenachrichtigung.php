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

require_once (PATH_TO_ADDONDIR . '/tipp/lmo-tipptest.php');
require_once (PATH_TO_LMO . '/includes/PHPMailer.php');
$mail = new PHPMailer(true);
$tipp_mailtext = str_replace(array('\n', '[nick]'), array("\n", $xtippernick), $text['tipp'][303]);

$mail->isMail();
$mail->Subject = iconv('UTF-8', ' ISO-8859-1', $text['tipp'][13] . ' (' . $_SERVER['HTTP_HOST'] . ')');
$mail->setFrom($aadr, $text['tipp'][92]);

$mail->Body = iconv('UTF-8', ' ISO-8859-1', $tipp_mailtext);
$mail->addAddress($aadr);
if (!$mail->send()) {
    echo $mail->ErrorInfo;
}
?>