<?php
/** Liga Manager Online 4
  *
  * http://www.liga-manager-online.org/lmo
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

/*
 * E-Mail-Versand (PHP mail() oder SMTP über PHPMailer)
 *
 * Die Einstellungen werden im Adminmenü (Optionen -> Grundeinstellungen) gepflegt und liegen in
 *   config/smtp/cfg.php   (Einstellungen, das Passwort nur verschlüsselt)
 *   config/smtp/key.php   (zufälliger Schlüssel, wird beim ersten Speichern erzeugt)
 * Beide Dateien beginnen mit einer PHP-Exit-Zeile und sind zusätzlich per .htaccess gesperrt.
 */

if (!defined('PATH_TO_LMO')) {
    die();
}

require_once PATH_TO_LMO . '/includes/Exception.php';
require_once PATH_TO_LMO . '/includes/PHPMailer.php';
require_once PATH_TO_LMO . '/includes/SMTP.php';

if (!defined('LMO_SMTP_GUARD')) {
    define('LMO_SMTP_GUARD', '<?php exit(); ?>');
}
if (!defined('LMO_SMTP_TIMEOUT')) {
    define('LMO_SMTP_TIMEOUT', 15);   // Sekunden bis zum Abbruch einer SMTP-Verbindung
}

/** Verzeichnis der Einstellungsdateien */
function lmo_smtp_dir()
{
    return PATH_TO_CONFIGDIR . '/smtp';
}

/** Standardwerte */
function lmo_smtp_defaults()
{
    return array(
        'mode'     => 'mail',   // 'mail' = PHP mail(), 'smtp' = SMTP-Server
        'host'     => '',
        'port'     => 587,
        'secure'   => 'tls',    // 'tls' = STARTTLS, 'ssl' = SMTPS, '' = keine
        'username' => '',
        'from'     => '',       // optional; leer = E-Mail des Webmasters
        'password' => '',       // nur im Speicher, auf der Platte verschlüsselt
    );
}

/* ----------------------------------------------------------------------
 *  Ver-/Entschlüsselung (Schlüssel liegt in config/smtp/key.php)
 * -------------------------------------------------------------------- */

/** Liest den Schlüssel (32 Byte); mit $create wird er bei Bedarf erzeugt. */
function lmo_smtp_key($create = false)
{
    $file = lmo_smtp_dir() . '/key.php';
    if (is_file($file)) {
        foreach (file($file) as $line) {
            $line = trim($line);
            if ($line !== '' && strpos($line, '<?php') !== 0) {
                $key = base64_decode($line, true);
                if ($key !== false && strlen($key) === 32) {
                    return $key;
                }
            }
        }
    }
    if (!$create) {
        return false;
    }
    if (!is_dir(lmo_smtp_dir()) && !@mkdir(lmo_smtp_dir(), 0755, true)) {
        return false;
    }
    lmo_smtp_protect_dir();
    $key = random_bytes(32);
    if (@file_put_contents($file, LMO_SMTP_GUARD . "\n" . base64_encode($key) . "\n", LOCK_EX) === false) {
        return false;
    }
    @chmod($file, 0600);
    return $key;
}

/** Legt eine .htaccess an, die den Ordner für den Webserver sperrt. */
function lmo_smtp_protect_dir()
{
    $ht = lmo_smtp_dir() . '/.htaccess';
    if (!is_file($ht)) {
        @file_put_contents($ht, "<IfModule mod_authz_core.c>\n    Require all denied\n</IfModule>\n<IfModule !mod_authz_core.c>\n    Order allow,deny\n    Deny from all\n</IfModule>\n");
    }
}

/** Verschlüsselt einen Text; liefert 's1:...' (libsodium) oder 'o1:...' (OpenSSL), '' bei leerem Text. */
function lmo_smtp_encrypt($plain)
{
    if ($plain === '') {
        return '';
    }
    $key = lmo_smtp_key(true);
    if ($key === false) {
        return false;
    }
    if (function_exists('sodium_crypto_secretbox')) {
        $nonce = random_bytes(SODIUM_CRYPTO_SECRETBOX_NONCEBYTES);
        return 's1:' . base64_encode($nonce . sodium_crypto_secretbox($plain, $nonce, $key));
    }
    if (function_exists('openssl_encrypt')) {
        $iv = random_bytes(12);
        $tag = '';
        $cipher = openssl_encrypt($plain, 'aes-256-gcm', $key, OPENSSL_RAW_DATA, $iv, $tag);
        if ($cipher === false) {
            return false;
        }
        return 'o1:' . base64_encode($iv . $tag . $cipher);
    }
    return false;
}

/** Entschlüsselt; liefert false bei Fehler (falscher Schlüssel, beschädigte Daten). */
function lmo_smtp_decrypt($stored)
{
    if ($stored === '') {
        return '';
    }
    $key = lmo_smtp_key(false);
    if ($key === false || strlen($stored) < 4) {
        return false;
    }
    $type = substr($stored, 0, 3);
    $raw = base64_decode(substr($stored, 3), true);
    if ($raw === false) {
        return false;
    }
    if ($type === 's1:' && function_exists('sodium_crypto_secretbox_open')) {
        $n = SODIUM_CRYPTO_SECRETBOX_NONCEBYTES;
        if (strlen($raw) <= $n) {
            return false;
        }
        return sodium_crypto_secretbox_open(substr($raw, $n), substr($raw, 0, $n), $key);
    }
    if ($type === 'o1:' && function_exists('openssl_decrypt')) {
        if (strlen($raw) <= 28) {
            return false;
        }
        return openssl_decrypt(substr($raw, 28), 'aes-256-gcm', $key, OPENSSL_RAW_DATA, substr($raw, 0, 12), substr($raw, 12, 16));
    }
    return false;
}

/* ----------------------------------------------------------------------
 *  Einstellungen laden / prüfen / speichern
 * -------------------------------------------------------------------- */

/**
 * Lädt die Einstellungen (inkl. entschlüsseltem Passwort).
 * $settings['password_error'] ist true, wenn ein gespeichertes Passwort nicht entschlüsselt werden konnte.
 */
function lmo_smtp_load($reload = false)
{
    static $cache = null;
    if ($cache !== null && !$reload) {
        return $cache;
    }
    $s = lmo_smtp_defaults();
    $s['password_error'] = false;
    $s['password_set'] = false;
    $file = lmo_smtp_dir() . '/cfg.php';
    $encrypted = '';
    if (is_file($file)) {
        foreach (file($file) as $line) {
            $line = trim($line);
            if ($line === '' || strpos($line, '<?php') === 0 || strpos($line, '=') === false) {
                continue;
            }
            list($k, $v) = explode('=', $line, 2);
            if ($k === 'password') {
                $encrypted = $v;
            } elseif (array_key_exists($k, $s) && $k !== 'password') {
                $s[$k] = $v;
            }
        }
    }
    $s['port'] = (int) $s['port'];
    if ($encrypted !== '') {
        $s['password_set'] = true;
        $plain = lmo_smtp_decrypt($encrypted);
        if ($plain === false) {
            $s['password_error'] = true;
        } else {
            $s['password'] = $plain;
        }
    }
    $cache = $s;
    return $s;
}

/**
 * Prüft/bereinigt Eingaben. Liefert array($settings, $errors); $errors enthält Fehlerschlüssel
 * ('host', 'port', 'from', 'username'), die im Formular als Meldung ausgegeben werden.
 */
function lmo_smtp_sanitize($in)
{
    $s = lmo_smtp_defaults();
    $errors = array();
    $s['mode'] = (isset($in['mode']) && $in['mode'] === 'smtp') ? 'smtp' : 'mail';
    $s['host'] = isset($in['host']) ? trim($in['host']) : '';
    $s['port'] = isset($in['port']) ? (int) $in['port'] : 587;
    $secure = isset($in['secure']) ? strtolower(trim($in['secure'])) : 'tls';
    $s['secure'] = in_array($secure, array('tls', 'ssl'), true) ? $secure : '';
    $s['username'] = isset($in['username']) ? str_replace(array("\r", "\n", "\0"), '', trim($in['username'])) : '';
    $s['from'] = isset($in['from']) ? trim($in['from']) : '';
    $s['password'] = isset($in['password']) ? (string) $in['password'] : '';

    if ($s['mode'] === 'smtp') {
        if (!preg_match('/^[A-Za-z0-9._\-\[\]:]{1,255}$/', $s['host'])) {
            $errors[] = 'host';
        }
        if ($s['port'] < 1 || $s['port'] > 65535) {
            $errors[] = 'port';
        }
    }
    if ($s['from'] !== '' && !filter_var($s['from'], FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'from';
    }
    if (strpbrk($s['password'], "\r\n\0") !== false) {
        $errors[] = 'password';
    }
    return array($s, $errors);
}

/**
 * Speichert die Einstellungen. Ist $newPassword leer, bleibt ein vorhandenes Passwort erhalten,
 * es sei denn $clearPassword ist gesetzt. Liefert true oder false (Datei/Verschlüsselung nicht möglich).
 */
function lmo_smtp_save($s, $newPassword = '', $clearPassword = false)
{
    $old = lmo_smtp_load(true);
    if ($clearPassword) {
        $plain = '';
    } elseif ($newPassword !== '') {
        $plain = $newPassword;
    } else {
        $plain = $old['password'];
        if ($old['password_error']) {
            return false;
        }
    }
    $enc = lmo_smtp_encrypt($plain);
    if ($enc === false) {
        return false;
    }
    if (!is_dir(lmo_smtp_dir()) && !@mkdir(lmo_smtp_dir(), 0755, true)) {
        return false;
    }
    lmo_smtp_protect_dir();
    $data = LMO_SMTP_GUARD . "\n"
          . 'mode=' . $s['mode'] . "\n"
          . 'host=' . $s['host'] . "\n"
          . 'port=' . (int) $s['port'] . "\n"
          . 'secure=' . $s['secure'] . "\n"
          . 'username=' . $s['username'] . "\n"
          . 'from=' . $s['from'] . "\n"
          . 'password=' . $enc . "\n";
    $file = lmo_smtp_dir() . '/cfg.php';
    $ok = @file_put_contents($file, $data, LOCK_EX) === strlen($data);
    if ($ok) {
        @chmod($file, 0600);
        lmo_smtp_load(true);
    }
    return $ok;
}

/** Ist die Seite per HTTPS aufgerufen (auch hinter Proxy)? */
function lmo_is_https()
{
    if (!empty($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) !== 'off') {
        return true;
    }
    if (isset($_SERVER['SERVER_PORT']) && (int) $_SERVER['SERVER_PORT'] === 443) {
        return true;
    }
    return isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && strtolower($_SERVER['HTTP_X_FORWARDED_PROTO']) === 'https';
}

/* ----------------------------------------------------------------------
 *  Mailversand
 * -------------------------------------------------------------------- */

/** Ist SMTP aktiv und ausreichend konfiguriert? */
function lmo_smtp_configured($s = null)
{
    if ($s === null) {
        $s = lmo_smtp_load();
    }
    return $s['mode'] === 'smtp' && $s['host'] !== '';
}

/**
 * Erzeugt ein vorkonfiguriertes PHPMailer-Objekt (UTF-8, base64, Absender, SMTP bzw. mail()).
 * Es werden keine Exceptions geworfen: send() liefert true/false, die Meldung steht in $mail->ErrorInfo.
 *
 * @param string     $fromName  Anzeigename des Absenders
 * @param array|null $s         Einstellungen (Standard: gespeicherte)
 * @return \PHPMailer\PHPMailer\PHPMailer
 */
function lmo_mail_create($fromName = '', $s = null)
{
    global $aadr;
    if ($s === null) {
        $s = lmo_smtp_load();
    }

    $mail = new \PHPMailer\PHPMailer\PHPMailer(false);
    $mail->CharSet = 'UTF-8';
    $mail->Encoding = 'base64';

    $from = trim((string) $s['from']);
    if ($from === '') {
        $from = $aadr;
    }

    if (lmo_smtp_configured($s)) {
        $mail->isSMTP();
        $mail->Host = $s['host'];
        $mail->Port = (int) $s['port'];
        if ($s['secure'] === 'ssl') {
            $mail->SMTPSecure = \PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_SMTPS;
        } elseif ($s['secure'] === 'tls') {
            $mail->SMTPSecure = \PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
        } else {
            $mail->SMTPSecure = '';
            $mail->SMTPAutoTLS = false;
        }
        if ($s['username'] !== '') {
            $mail->SMTPAuth = true;
            $mail->Username = $s['username'];
            $mail->Password = $s['password'];
        } else {
            $mail->SMTPAuth = false;
        }
        $mail->Timeout = (int) LMO_SMTP_TIMEOUT;
    } else {
        $mail->isMail();
    }

    $mail->setFrom($from, $fromName);
    return $mail;
}

/**
 * Versendet $mail. Schlägt der SMTP-Versand fehl, wird einmal mit mail() wiederholt
 * (Empfänger, Anhänge und Text bleiben erhalten). Bei einem Fehler enthält $mail->ErrorInfo die Meldung(en).
 *
 * @return bool
 */
function lmo_mail_send($mail)
{
    if ($mail->send()) {
        return true;
    }
    if ($mail->Mailer === 'smtp') {
        $smtpError = $mail->ErrorInfo;
        $mail->smtpClose();
        $mail->isMail();
        if ($mail->send()) {
            return true;
        }
        $mail->ErrorInfo = 'SMTP: ' . $smtpError . ' | mail(): ' . $mail->ErrorInfo;
    }
    return false;
}

/**
 * Sendet eine Testmail über SMTP (ohne mail()-Rückfall), damit Fehler der SMTP-Einstellungen sichtbar werden.
 * Liefert array(bool $ok, string $meldung).
 */
function lmo_smtp_test($s, $to)
{
    if (!filter_var($to, FILTER_VALIDATE_EMAIL)) {
        return array(false, 'Invalid address: ' . $to);
    }
    $mail = lmo_mail_create('LMO', $s);
    $mail->addAddress($to);
    $mail->Subject = 'LMO SMTP-Test';
    $mail->Body = 'Dies ist eine Testnachricht des Liga Manager Online (' . (isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '') . ").\nThis is a test message from Liga Manager Online.";
    $ok = $mail->send();
    $msg = $ok ? ($mail->Mailer === 'smtp' ? 'SMTP' : 'mail()') : $mail->ErrorInfo;
    return array($ok, $msg);
}

/** Stellt sicher, dass die Texte für das SMTP-Formular vorhanden sind (sonst Englisch). */
function lmo_smtp_lang()
{
    global $text;
    if (empty($text['smtp']) && function_exists('read_langfile')) {
        read_langfile($text, PATH_TO_LANGDIR . '/smtp/lang-English.txt', 'smtp');
    }
}
