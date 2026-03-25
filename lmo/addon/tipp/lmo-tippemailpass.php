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
require_once(PATH_TO_LMO . '/includes/PHPMailer.php');

if (isset($xtippername2)) {
    $pswfile = PATH_TO_ADDONDIR . '/tipp/' . $tipp_tippauthtxt;
    $lines = file($pswfile);
    $userFound = false;

    foreach ($lines as $key => $line) {
        $data = explode('|', $line);

        // Prüfe Benutzername (Index 0) oder E-Mail (Index 4)
        if ($xtippername2 == $data[0] || ($xtippername2 == $data[4] && str_contains($data[4], '@'))) {

            // 1. Neues temporäres Passwort generieren (8 Zeichen)
            $newPassword = bin2hex(random_bytes(4)); 

            // 2. Besten verfügbaren Algorithmus wählen
            $bestAlgo = defined('PASSWORD_ARGON2ID') ? PASSWORD_ARGON2ID : PASSWORD_BCRYPT;
            $newHash = password_hash($newPassword, $bestAlgo);

            // 3. Den alten Wert (Index 1) mit dem neuen Hash überschreiben
            $data[1] = $newHash;
            $lines[$key] = implode('|', $data);
            
            $userFound = true;
            $recipientEmail = trim($data[4]);
            $tipperName = $data[0];
            break;
        }
    }

    if ($userFound) {
        // 4. Datei mit dem neuen Hash zurückschreiben
        file_put_contents($pswfile, implode('', $lines), LOCK_EX);

        // 5. E-Mail versenden
        try {
            $mail = new PHPMailer(true);
            $mail->isMail();
            $mail->CharSet = 'UTF-8';
            $mail->Encoding = 'base64';
            $mail->Subject = $text['tipp'][79] . ' (' . $_SERVER['HTTP_HOST'] . ')';
            $mail->setFrom($aadr, $text['tipp'][92]);
            $mail->addAddress($recipientEmail);

            $loginUrl = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . '?action=tipp';

            $emailbody = $text['tipp'][297] . ' ' . $tipperName . ",\n\n" .
                         $text['tipp'][77] . "\n\n" .
                         $text['tipp'][23] . ': ' . $tipperName . "\n" .
                         $text[308] . ': ' . $newPassword . "\n\n" .
                         $text['tipp'][255] . ': ' . $loginUrl;

            $mail->Body = $emailbody;
            $mail->send();
            echo getMessage($text['tipp'][78]); // Erfolgsmeldung
            $_SESSION['lmotipperok'] = 0;
        } catch (Exception $e) {
            echo $text['tipp'][80] . " Details: {$mail->ErrorInfo}<br>";
        }
    } else {
        $_SESSION['lmotipperok'] = -3; // Benutzer nicht gefunden
    }
} else {
    $_SESSION['lmotipperok'] = 0;
}
?>