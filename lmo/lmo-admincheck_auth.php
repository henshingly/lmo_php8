<?php
/** Anfang der Änderung durch Dietmar Kersting (henshingly(ät)vest-sport.de)
  * Funktion für Silent Upgrade Passwörter 15.02.2026
  */


// Die Passwort Upgrade Funktion am Anfang der Datei
function loginAndUpgrade($inputUser, $inputPass, $db_file)
{
    if (!file_exists($db_file)) return false;

    $lines = file($db_file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $bestAlgo = defined('PASSWORD_ARGON2ID') ? PASSWORD_ARGON2ID : PASSWORD_BCRYPT;
    $updated = false;
    $loginSuccess = false;

    foreach ($lines as $index => $line) {
        if (strpos($line, '<?php') !== false) continue; // Schutzzeile überspringen

        $fields = explode('|', $line);
        if (count($fields) < 2) continue;

        $storedUser = $fields[0];
        $storedHash = $fields[1];

        if ($storedUser === $inputUser) {
            // Prüfung: Argon2/BCrypt ODER Klartext
            if (password_verify($inputPass, $storedHash) || $inputPass === $storedHash) {
                $loginSuccess = true;

                // Upgrade nur, wenn der Hash noch nicht dem aktuellen Standard entspricht
                if (password_needs_rehash($storedHash, $bestAlgo) || !password_get_info($storedHash)['algo']) {
                    $fields[1] = password_hash($inputPass, $bestAlgo);
                    $lines[$index] = implode('|', $fields);
                    $updated = true;
                }
            }
            break;
        }
    }

    if ($updated) {
        file_put_contents($db_file, implode(PHP_EOL, $lines) . PHP_EOL, LOCK_EX);
    }
    return $loginSuccess;
}
/** Ende der Änderung durch Dietmar Kersting (henshingly(ät)vest-sport.de)
  * Funktion für Silent Upgrade Passwörter 15.02.2026
  */

// Bestehende Session-Initialisierung
if (!isset($_SESSION['lmousername'])) { $_SESSION['lmousername'] = ''; }
if (!isset($_SESSION['lmouserpass'])) { $_SESSION['lmouserpass'] = ''; }
if (!isset($_SESSION['lmouserfile'])) { $_SESSION['lmouserfile'] = ''; }
if (!isset($_SESSION['lmouserokerweitert'])) { $_SESSION['lmouserokerweitert'] = 0; }

// Login-Logik
if (!isset($_SESSION['lmouserok']) || $_SESSION['lmouserok'] == 0) {
    if (isset($_POST['xusername'])) {
        $_SESSION['lmousername'] = $_POST['xusername'];
        $_SESSION['lmouserpass'] = $_POST['xuserpass'];

        $lmo_auth_file = PATH_TO_CONFIGDIR . '/lmo-auth.php';

        // Prüfung und automatisches Upgrade ausführen
        if (loginAndUpgrade($_SESSION['lmousername'], $_SESSION['lmouserpass'], $lmo_auth_file)) {

            // Daten frisch laden (damit $lmo_admin_data die neuen Hashes hat)
            require (PATH_TO_LMO . '/lmo-loadauth.php');

            foreach ($lmo_admin_data as $lmo_admin) {
                if ($_SESSION['lmousername'] == $lmo_admin[0]) {
                    $_SESSION['lmouserok'] = $lmo_admin[2];
                    if ($_SESSION['lmouserok'] == 1) {
                        $_SESSION['lmouserfile'] = isset($lmo_admin[3]) ? $lmo_admin[3] : '';
                        $_SESSION['lmouserokerweitert'] = isset($lmo_admin[4]) ? $lmo_admin[4] : 0;
                    }
                    break;
                }
            }
        }
    }
}
?>
