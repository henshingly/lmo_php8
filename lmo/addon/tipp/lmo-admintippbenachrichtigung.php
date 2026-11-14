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

require_once(PATH_TO_ADDONDIR . '/tipp/lmo-tipptest.php');
require_once(PATH_TO_LMO . '/lmo-smtp.php');

$mail = lmo_mail_create($text['tipp'][92]);
$tipp_mailtext = str_replace(array('\n', '[nick]'), array("\n", $xtippernick), $text['tipp'][303]);

$mail->Subject = $text['tipp'][13] . ' (' . $_SERVER['HTTP_HOST'] . ')';

$mail->Body = $tipp_mailtext;
$mail->addAddress($aadr, $text['tipp'][92]);
if (!lmo_mail_send($mail)) {
    echo $mail->ErrorInfo;
}
?>