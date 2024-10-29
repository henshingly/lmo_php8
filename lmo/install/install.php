<?php

/**
 * Liga Manager Online 4
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
 *
 */
session_start();
$min_php_version ="7.4.0";
$error = "";

//check if the call is from maindir (lmo.php) or install/install.php directly
if (is_readable('includes/FTP.php')) {
    //check for ftp capabilities
    if (!function_exists("ftp_connect")) {
        if (function_exists("fsockopen")) {
            require_once 'includes/Socket.php';
        } else {
            //not ftp, no sockets -> manual
            $_REQUEST['man']=1;
        }
    }
    require_once 'includes/FTP.php';
} else {
    if (!function_exists("ftp_connect")) {
        if (function_exists("fsockopen")) {
            require_once '../includes/Socket.php';
        } else {
            //not ftp, no sockets -> manual
            $_REQUEST['man']=1;
        }
    }
    require_once '../includes/FTP.php';
}

if (!isset($_SESSION['ftpserver'])) {
    $_SESSION['ftpserver'] = '';
}
if (!isset($_SESSION['ftpuser'])) {
    $_SESSION['ftpuser'] = '';
}
if (!isset($_SESSION['ftppass'])) {
    $_SESSION['ftppass'] = '';
}
$_SESSION['userlang'] = isset($_GET['userlang']) ? $_GET['userlang'] : (isset($_SESSION['userlang']) ? $_SESSION['userlang'] : 'DE');
$userlang = $_SESSION['userlang'];

$filelist = array(
    777 => array('ligen', 'output', 'config', 'ligen/dfb', 'config/viewer', 'addon/tipp/tipps', 'addon/tipp/tipps/auswert', 'addon/tipp/tipps/einsicht', 'addon/tipp/tipps/auswert/vereine', 'addon/spieler/stats'),
    666 => array('config/cfg.txt', 'config/lmo-auth.php', 'config/tipp/cfg.txt', 'config/spieler/cfg.txt', 'config/ticker/cfg.txt', 'config/mini/cfg.txt', 'config/classlib/cfg.txt', 'addon/tipp/lmo-tippauth.txt', 'ligen/*.l98')
);
$lang = array(
    'DE' => array(
        'HEADER' => 'Installation des Liga Manager Online 4',
        'PROCEED' => 'Weiter',
        'SUCCESS' => 'Erfolg',
        'ERROR' => 'Fehler',
        'CHECK_AGAIN' => 'Neu prüfen',
        'PHP_ERROR_1' => 'Für diesen LMO ist ein Webserver mit PHP',
        'PHP_ERROR_2' => 'oder höher erforderlich.<br>Ihr Webserver unterstützt dies derzeit nicht, Ihre PHP-Version ist:',
        'ERROR_WRONG_PATH' => 'Der Pfad ist nicht korrekt!',
        'ERROR_CONFIRM' => 'Es sind noch Fehler vorhanden! Der LMO wird NICHT funktionieren. Trotzdem fortfahren?',

        'STEP0' => 'FTP-Zugangsdaten',
        'STEP0_DESCRIPTION' => 'Um den LMO vollautomatisch zu installieren, ist ein Zugang per FTP notwendig.
            Dazu müssen Sie die Logindaten für Ihren FTP-Zugang angeben. Die Daten werden vom LMO
            nicht gespeichert oder in irgendeiner anderen Weise weiterverwendet. Falls Sie
            manuell installieren möchten gelangen Sie
            <a href="' . $_SERVER['PHP_SELF'].'?lmo_install_step=2&amp;man=1">hier zur manuellen Installation.</a>',
        'STEP0_FTP_SERVER' => 'Geben sie hier die Adresse ihres FTP-Servers ein',
        'STEP0_FTP_SERVER_EXAMPLE' => 'Bsp.: <em><kbd>ftp.beispiel.de</kbd></em>',
        'STEP0_FTP_LOGIN' => 'Geben Sie hier Ihren Usernamen und Ihr Passwort ein',
        'STEP0_FTP_NO_CONNECTION' => 'Keine Verbindung zu "' . $_SESSION['ftpserver'].'" möglich. Korrigieren Sie die Adresse oder <a href="' . $_SERVER['PHP_SELF'].'?lmo_install_step=2&amp;man=1">installieren Sie manuell</a>',
        'STEP0_FTP_NO_LOGIN' => 'Fehler beim Einloggen. Korrigieren Sie die Benutzerdaten oder <a href="' . $_SERVER['PHP_SELF'].'?lmo_install_step=2&amp;man=1">installieren Sie manuell</a>',

        'STEP1' => 'LMO-Verzeichnis auswählen',
        'STEP1_SELECT_FTP_DIR' => 'Wählen Sie das LMO Verzeichnis aus',

        'STEP2' => 'PHP Version überprüfen und Dateirechte setzen (CHMOD)',
        'STEP2_MANUAL' => '<p><strong>Kopieren Sie die beiden Ordner (<code>addon</code> und <code>config</code>) <u>aus dem Ordner</u> <code>install</code> mit einem FTP-Programm über Ihr LMO-Verzeichnis.</strong></p>
            <p><img src="img/manual_copy.png" alt="Kopieren der Dateien mittels FTP-Programm" width="696"></p>
            <p><strong>Setzen Sie danach die benötigten Rechte über ihr FTP-Programm.</strong></p>
            <p><img src="img/manual_chmod.png" alt="Setzen der Rechte mittels FTP-Programm" width="427"></p>
            <p>Aktualisieren Sie diese Seite <a href="#" onclick="location.reload();return false;">[Reload]</a>, um
            zu überprüfen, ob alle Rechte richtig gesetzt sind.<br><a href="' . $_SERVER['PHP_SELF'].'">[Zurück zur automatischen Installation (falls verfügbar)]</a></p>',

        'STEP3' => 'Konfigurationsdatei erstellen',
        'STEP3_PATH' => 'Geben Sie hier den <strong>kompletten Pfad</strong> zum LMO an',
        'STEP3_PATH_EXAMPLE' => 'Bsp.: <em><kbd>/home/www/htdocs/lmo</kbd></em>',
        'STEP3_PATH_CORRECT' => 'Der Pfad ist korrekt!',
        'STEP3_PATH_WRONG' => 'Der Pfad ist nicht korrekt!',
        'STEP3_URL' => 'Geben Sie hier die absolute URL zum LMO an',
        'STEP3_URL_CORRECT' => ' Wenn Sie hier ein Bild sehen, ist die URL richtig!',
        'STEP3_URL_EXAMPLE' => 'Bsp.: <em><kbd>http://www.beispiel.de/lmo</kbd></em>',
        'STEP3_ERROR_INI_FILE_NOT_OPENABLE' => 'Konnte Datei <code>config/init-parameters.php</code> nicht öffnen! Bitte setzen Sie die Rechte auf chmod 666 und <a href="#" onclick="location.reload();return false;">aktualisieren Sie diese Seite</a>, um den Vorgang zu wiederholen.',
        'STEP3_ERROR_INI_FILE_NOT_WRITEABLE' => 'Konnte die Konfiguration nicht speichern. Vergewissern Sie sich, dass die Datei <code>config/init-parameters.php</code> die Rechte 666 besitzt. Bitte setzen Sie die Rechte auf chmod 666 und <a href="#" onclick="location.reload();return false;">aktualisieren Sie diese Seite</a>, um den Vorgang zu wiederholen.',
        'STEP3_SUCCESS_INI_FILE' => 'Die Konfiguration wurde erfolgreich gespeichert',

        'STEP4' => 'Installation erfolgreich',
        'STEP4_TEXT1' => 'Der Liga Manager Online 4 ist installiert worden!',
        'STEP4_TEXT2' => 'Falls Fehler aufgetreten sind, wiederholen sie die Installation oder installieren Sie den LMO manuell, indem Sie
            die Datei <code>config/init-parameters.php</code> mit einem Texteditor anpassen und die Schreibrechte mit einem FTP-Programm
            manuell vergeben.',
        'STEP4_TEXT3' => 'Bitte löschen Sie jetzt unbedingt den Ordner <code>install</code> vom Server oder geben Sie dem Ordner chmod 000.',
        'STEP4_TEXT4' => '<ul class="attention">
            <li><strong>Link zum <acronym title="Liga Manager Online">LMO</acronym>:</strong> <a href="%s">%s</a></li>
            <li><strong>Link zum Adminbereich:</strong> <a href="%s">%s</a> <small>(Standardlogin ist <kbd>admin</kbd> / <kbd>lmo</kbd>)</small></li>
            <li><strong>Link zur Benutzeranleitung:</strong> <a href="%s">%s</a></li>
            </ul>',
        'STEP4_TEXT5' => '<a href="https://paypal.me/LMOforum/"><input type="image" src="img/SpendiermirnenKaffee.svg"></a>',
        'STEP4_TEXT6' => 'Viel Spaß!',
    ),


    'EN'=>array(
        'HEADER' => 'Installation of Liga Manager Online 4',
        'PROCEED' => 'Proceed',
        'SUCCESS' => 'Success',
        'ERROR' => 'Error',
        'PHP_ERROR_1' => 'This LMO requires a web server running PHP ',
        'PHP_ERROR_2' => 'or later.<br>Your web server does not currently support this, your PHP version is:',
        'CHECK_AGAIN' => 'Test again',
        'ERROR_WRONG_PATH' => 'Incorrect path!',
        'ERROR_CONFIRM' => 'There are still errors left! Proceed?',

        'STEP0' => 'FTP login data',
        'STEP0_DESCRIPTION' => 'To install the LMO automaticly you must insert your FTP login data.
            The data will not saved nor published. If you want to install manually use
            <a href="' . $_SERVER['PHP_SELF'].'?lmo_install_step=2&amp;man=1">this link</a>.',
        'STEP0_FTP_SERVER' => 'FTP server address',
        'STEP0_FTP_SERVER_EXAMPLE' => 'e.g.: <em><kbd>ftp.example.com</kbd></em>',
        'STEP0_FTP_LOGIN' => 'Insert your username and password',
        'STEP0_FTP_NO_CONNECTION' => 'Can not establish connection to "' . $_SESSION['ftpserver'].'". Please correct the address of server or <a href="' . $_SERVER['PHP_SELF'].'?lmo_install_step=2&amp;man=1">install manually</a>',
        'STEP0_FTP_NO_LOGIN' => 'Login error. Please correct your user data or <a href="' . $_SERVER['PHP_SELF'].'?lmo_install_step=2&amp;man=1">install manually</a>',

        'STEP1' => 'Select LMO folder',
        'STEP1_SELECT_FTP_DIR' => 'Please select your LMO folder',

        'STEP2' => 'Check PHP version and set file permissions (CHMOD)',
        'STEP2_MANUAL' => '<p><strong>Copy the two folders (<code>addon</code> and <code>config</code>) <u>from the</u> <code>install</code> folder via your LMO using an FTP program</strong></p>
            <p><img src="img/manual_copy.png" alt="Copying files using a FTP tool" width="696"></p>
            <p><strong>Please chmod these file with your FTP tool.</strong></p>
            <p><img src="img/manual_chmod.png" alt="Chmod files using a FTP tool" width="427"></p>
            <p>Press <a href="#" onclick="location.reload();return false;">[Reload]</a> for
            a check.<br><a href="' . $_SERVER['PHP_SELF'].'">[Back to automatic installation (if available)]</a><p>',

        'STEP3' => 'Create configuration file',
        'STEP3_PATH' => 'Please insert the <strong>absolute path</strong> to LMO',
        'STEP3_PATH_EXAMPLE' => 'e.g.: <em><kbd>/home/www/htdocs/lmo</kbd></em>',
        'STEP3_PATH_CORRECT' => 'Path seems to be correct!',
        'STEP3_PATH_WRONG' => 'Path seems to be incorrect!',
        'STEP3_URL' => 'Please insert the <strong>absolute URL</strong> to LMO',
        'STEP3_URL_EXAMPLE' => 'e.g.: http://www.example.com/lmo',
        'STEP3_URL_CORRECT' => ' If you can see a picture in front of this message then the URL is correct!',
        'STEP3_ERROR_INI_FILE_NOT_OPENABLE' => 'Could not open <code>config/init-parameters.php</code>! Please chmod the file with 666 and <a href="#" onclick="location.reload();return false;">[Reload]</a> this page to repeat the check.',
        'STEP3_ERROR_INI_FILE_NOT_WRITEABLE' => 'Could not save configuration! Please make sure that the file <code>config/init-parameters.php</code> has the correct chmod of 666. Please chmod the file with 666 and <a href="#" onclick="location.reload();return false;">[Reload]</a> this page to repeat the check.',
        'STEP3_SUCCESS_INI_FILE' => 'Configuration successfully saved',

        'STEP4' => 'Installation successful',
        'STEP4_TEXT1' => 'Liga Manager Online 4 is successfully installed!',
        'STEP4_TEXT2' => 'If you experienced errors repeat the installation or install manually. To install manually edit the file
            <code>config/init-parameters.php</code> with an common text editor and chmod the files with your FTP tool.',
        'STEP4_TEXT3' => 'Please delete the folder <code>install</code> or chmod it to 000.',
        'STEP4_TEXT4' => '<ul class="attention">
            <li><strong>Link to <acronym title="Liga Manager Online">LMO</acronym>:</strong> <a href="%s">%s</a></li>
            <li><strong>Link to admin area:</strong> <a href="%s">%s</a> <small>(Login is <kbd>admin</kbd> / <kbd>lmo</kbd>)</small></li>
            <li><strong>Link to Help:</strong> <a href="%s">%s</a></li>
            </ul>',
        'STEP4_TEXT5' => '<a href="https://paypal.me/LMOforum/"><input type="image" src="img/Spendacoffee.svg"></a>',
        'STEP4_TEXT6' => 'Have fun!',
    ),


    'FR'=>array(
        'HEADER' => 'Installation du Liga Manager Online 4',
        'PROCEED' => 'Continuer',
        'SUCCESS' => 'Succès',
        'ERROR' => 'Erreur',
        'PHP_ERROR_1' => 'Ce LMO nécessite un serveur Web exécutant PHP',
        'PHP_ERROR_2' => 'ou version ultérieure.<br>Votre serveur Web ne le prend pas en charge actuellement, votre version de PHP est:',
        'CHECK_AGAIN' => 'Vérifier de nouveau',
        'ERROR_WRONG_PATH' => 'Le chemin n\'est pas correct!',
        'ERROR_CONFIRM' => 'Il y a encore des erreurs! Désirez-vous quand même continuer?',

        'STEP0' => 'Données d\'accès FTP',
        'STEP0_DESCRIPTION' => 'Pour pouvoir installer le LMO automatiquement, un accès FTP est nécessaire.
            Pour cela vous devez entrer les données d\'accès de votre serveur FTP. Ces informations ne seront pas sauvegarder ou utiliser pour d\'autres fins dans le LMO.
            Si vous voulez installer manuellement les paramètres vous pouvez le faire
            <a href="' . $_SERVER['PHP_SELF'].'?lmo_install_step=2&amp;man=1">ici pour continuer avec l\'installation manuelle.</a>',
        'STEP0_FTP_SERVER' => 'Veuillez donner l\'adresse de votre serveur FTP',
        'STEP0_FTP_SERVER_EXAMPLE' => 'Ex.: <em><kbd>ftp.exemple.fr</kbd></em>',
        'STEP0_FTP_LOGIN' => 'Veuillez entrer votre identifiant et votre mot de passe',
        'STEP0_FTP_NO_CONNECTION' => 'Aucune connection sur "' . $_SESSION['ftpserver'].'" possible. Veuillez corriger l\'adresse ou bien <a href="' . $_SERVER['PHP_SELF'].'?lmo_install_step=2&amp;man=1">installez-le manuellement</a>',
        'STEP0_FTP_NO_LOGIN' => 'Erreur de connection. Veuillez corriger l\'identifiant ou <a href="' . $_SERVER['PHP_SELF'].'?lmo_install_step=2&amp;man=1">installez-le manuellement</a>',

        'STEP1' => 'Choissisez le répertoire du LMO',
        'STEP1_SELECT_FTP_DIR' => 'Veuillez choissir le répertoire du LMO',

        'STEP2' => 'Vérifiez la version PHP et définir les droits d\'accès des fichiers (CHMOD)',
        'STEP2_MANUAL' => '<p><strong>Copiez les deux dossiers (<code>addon</code> et <code>config</code>) <u>du dossier</u> <code>install</code> via votre LMO à l&apos;aide d&apos;un programme FTP -Répertoire.</strong></p>
            <p><img src="img/manual_copy.png" alt="" width="696"></p>
            <p><strong>Définissez ensuite les droits requis via votre programme FTP.</strong></p>
            <p><img src="img/manual_chmod.png" alt="" width="427"></p>
            <p>Veuillez ensuite actualiser cette page avec un <a href="#" onclick="location.reload();return false;">[Rafraîchir]</a>, pour vérifier , que tout les droits ont été placé correctement.<br><a href="' . $_SERVER['PHP_SELF'].'">[Retourner à l\'installation automatique]</a></p>',

        'STEP3' => 'Création du fichier de configuration',
        'STEP3_PATH' => 'Veuillez entrer ici le <strong>chemin complet</strong> pour accèder au LMO',
        'STEP3_PATH_EXAMPLE' => 'Ex.: <em><kbd>/home/www/htdocs/lmo</kbd></em>',
        'STEP3_PATH_CORRECT' => 'Le chemin est correct!',
        'STEP3_PATH_WRONG' => 'Le chemin est incorrect!',
        'STEP3_URL' => 'Veuillez entrer ici l\'adresse URL pour accèder au LMO',
        'STEP3_URL_CORRECT' => ' Si vous voyez une image, l\'adresse URL est correcte!',
        'STEP3_URL_EXAMPLE' => 'Ex.: <em><kbd>http://www.exemple.fr/lmo</kbd></em>',
        'STEP3_ERROR_INI_FILE_NOT_OPENABLE' => 'Impossible d\'ouvrir le fichier <code>config/init-parameters.php</code>!    Veuillez définir les droits d\'accès sur chmod 666 et actualisez cette page ([F5]), pour répeter cette étape.',
        'STEP3_ERROR_INI_FILE_NOT_WRITEABLE' => 'Veuillez vérifier avant l\'installation que le fichier <code>config/init-parameters.php</code> a bien les droits d\'accès 666. Veuillez définir les droits d\'accès sur chmod 666 et actualisez cette page, pour répeter cette étape.',
        'STEP3_SUCCESS_INI_FILE' => 'La configuration a été sauvegardé avec succès',

        'STEP4' => 'L\'installation a été couronné de succès',
        'STEP4_TEXT1' => 'Le Liga Manager Online 4 a été installé!',
        'STEP4_TEXT2' => 'Si des erreurs apparaissent, veuillez répéter l\'installation ou bien installer le LMO manuellement en adaptant le fichier <code>config/init-parameters.php</code> avec un éditeur de texte et donner les droits d\'accès manuellement avec un programme FTP.',
        'STEP4_TEXT3' => 'Veuillez supprimer à tout prix le répertoire <code>install</code> de votre serveur ou bien lui donner les droits d\accès chmod 000.',
        'STEP4_TEXT4' => '<ul class="attention">
            <li><strong>Le <acronym title="Liga Manager Online">LMO</acronym>:</strong> <code><a href="%s">%s</a></code>
            <li><strong>Le secteur d\'administration:</strong> <code><a href="%s">%s</a></code> (L\'indentifiant par défaut est <kbd>admin</kbd>/<kbd>lmo</kbd>)
            <li><strong>Description d\'utlisation:</strong> <code><a href="%s">%s</a></code>
            </ul>',
        'STEP4_TEXT5' => '<a href="https://paypal.me/LMOforum/"><input type="image" src="img/Distribueuncafe.svg"></a>',
        'STEP4_TEXT6' => 'Bon courage!',
    ),


    'ES'=>array(
        'HEADER' => 'Installación de Liga Manager Online 4',
        'PROCEED' => 'Proceder',
        'SUCCESS' => 'Exitoso',
        'ERROR' => 'Error',
        'PHP_ERROR_1' => 'Este LMO requiere un servidor web que ejecute PHP',
        'PHP_ERROR_2' => 'o posterior.<br>Su servidor web no soporta esto actualmente, su versión de PHP es:',
        'CHECK_AGAIN' => 'Intenta otra vez',
        'ERROR_WRONG_PATH' => 'Directorio incorrecto!',
        'ERROR_CONFIRM' => 'Aun hay errores! Continuar?',

        'STEP0' => 'Datos de conexión FTP',
        'STEP0_DESCRIPTION' => 'Para instalar LMO automaticamente debe insertar sus datos de la conexión FTP. Datos no guardados ni publicados. Si desea instalar manualmente use <a href="' . $_SERVER['PHP_SELF'].'?step=2&amp;man=1">este link</a>.',
        'STEP0_FTP_SERVER' => 'Dirección servidor FTP',
        'STEP0_FTP_SERVER_EXAMPLE' => 'ej.: <em><kbd>ftp.ejemplo.com</kbd></em>',
        'STEP0_FTP_LOGIN' => 'Ingrese su nombre de usuario y contraseña',
        'STEP0_FTP_NO_CONNECTION' => 'No se puede establecer conección a "' . $_SESSION['ftpserver'].'". Por favor corrija la dirección del servidor o <a href="' . $_SERVER['PHP_SELF'].'?step=2&amp;man=1">instale manualmente</a>',
        'STEP0_FTP_NO_LOGIN' => 'Error en conección. Por favor corrija los datos de usuario o <a href="' . $_SERVER['PHP_SELF'].'?step=2&amp;man=1">instale manualmente</a>',

        'STEP1' => 'Seleccione la carpeta de LMO',
        'STEP1_SELECT_FTP_DIR' => 'Seleccione por favor su carpeta de LMO',

        'STEP2' => 'Verifique la versión de PHP y establezca permisos de archivos (CHMOD)',
        'STEP2_MANUAL' => 'Copie las dos carpetas (<code>addon</code> y <code>config</code>) <u>de la carpeta</u> <code>install</code> en su LMO usando un programa FTP.
            <p><img src="img/manual_copy.png" alt="Copiar los archivos usando el programa FTP" width="696"></p>
            <p><strong>Luego configure los derechos requeridos a través de su programa FTP.</strong></p>
            <p><img src="img/manual_chmod.png" alt="Configurar los derechos mediante un programa FTP" width="427"></p>
            <p>Actualiza esta página <a href="#" onclick="location.reload();return false;">[Reload]</a> para
            para comprobar si todos los derechos están configurados correctamente.<br><a href="' . $_SERVER['PHP_SELF'].'">[Volver a la instalación automática (si está disponible)]</a></p>',

        'STEP3' => 'Cree el archivo de configuración',
        'STEP3_PATH' => 'Por favor ingrese el <strong>directorio absoluto</strong> a LMO',
        'STEP3_PATH_EXAMPLE' => 'ej.: <em><kbd>/home/www/htdocs/lmo</kbd></em>',
        'STEP3_PATH_CORRECT' => 'El directorio parece ser correcto!',
        'STEP3_PATH_WRONG' => 'El directorio parece ser incorrecto!',
        'STEP3_URL' => 'Por favor ingrese la <strong>URL absoluta</strong> a LMO',
        'STEP3_URL_EXAMPLE' => 'ej.: http://www.ejemplo.com/lmo',
        'STEP3_URL_CORRECT' => ' Si usted puede ver una imagen delante de este mensaje entonces la URL es correcta!',
        'STEP3_ERROR_INI_FILE_NOT_OPENABLE' => 'No se puede abrir init-parameters.php! Por favor cambie los permisos del archivo a 666 y <a href="#" onclick="location.reload();return false;">[Recargue]</a> esta página para repetir el chequeo.',
        'STEP3_ERROR_INI_FILE_NOT_WRITEABLE' => 'No se puede guardar la configuración! Por favor aseguresé que el archivo <code>init-parameters.php</code> tiene permisos chmod de 666. Por favor cambie los permisos chmod del archivo a 666 y <a href="#" onclick="location.reload();return false;">[Recargue]</a> esta página para repetir el chequeo.',
        'STEP3_SUCCESS_INI_FILE' => 'Configuración guardada con éxito',

        'STEP4' => 'Instalación exitosa',
        'STEP4_TEXT1' => 'Liga Manager Online 4 instalada exitosamente!',
        'STEP4_TEXT2' => 'Si usted experimenta errores repita la instalación o instale manualmente. Para instalar manualmente edite el archivo <code>init-parameters.php</code> con un editor de textos común y cambie los permisos chmod de los archivos con su herramienta FTP.',
        'STEP4_TEXT3' => 'Por favor elimine el archivo <code>install.php</code> o cambie los permisos chmod a 000.',
        'STEP4_TEXT4' => '<ul class="attention">
            <li><strong>Enlace a <acronym title="Liga Manager Online">LMO</acronym>:</strong> <a href="%s">%s</a></li>
            <li><strong>Enlace al área de administración:</strong> <a href="%s">%s</a> <small>(El login por defecto es <kbd>admin</kbd> / <kbd>lmo</kbd>)</small></li>
            <li><strong>Enlace a la guía del usuario:</strong> <a href="%s">%s</a></li>
            </ul>',
        'STEP4_TEXT5' => '<a href="https://paypal.me/LMOforum/"><input type="image" src="img/Tomaruncafe.svg"></a>',
        'STEP4_TEXT6' => 'Disfrútalo!',
    )
);
/*    End of config area */


if (!empty($_GET['debug']) || !empty($_SESSION['debug'])) {
    $_SESSION['debug'] = true;
    @error_reporting(E_ALL);
    @ini_set("display_errors", "On");
} else {
    @error_reporting(E_ERROR | E_PARSE);
    @ini_set("display_errors", "Off");
}
$lmo_install_step = isset($_REQUEST['lmo_install_step']) ? $_REQUEST['lmo_install_step'] : 0;
if (isset($_POST['check'])) $lmo_install_step = 3;
$_SESSION['man'] = !empty($_REQUEST['man']) ? TRUE : FALSE;

$patherror = $urlerror = $installerror = $loginerror = '';

$lmo_dir = dirname(__DIR__);

// Determine HTTP / HTTPS
if (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' or $_SERVER['SERVER_PORT'] == 443) $protocol = 'https:';
else $protocol = 'http:';

$path = str_replace('\\', '/', $lmo_dir);
if (strpos(dirname($_SERVER['SCRIPT_NAME']), "/install") !== FALSE) {
    $url = $protocol . '//' . $_SERVER['HTTP_HOST'] . dirname(dirname($_SERVER['SCRIPT_NAME']));
} else {
    $url = $protocol . '//' . $_SERVER['HTTP_HOST'] . dirname(($_SERVER['SCRIPT_NAME']));
}

if ($lmo_install_step == 1) {
    // Test FTP data

    $ftp = new Net_FTP();
    $_SESSION['ftpserver'] = isset($_POST['ftpserver']) ? trim($_POST['ftpserver']) : (!empty($_SESSION['ftpserver']) ? $_SESSION['ftpserver'] : '');
    $_SESSION['ftpuser'] = isset($_POST['ftpuser']) ? trim($_POST['ftpuser']) : (!empty($_SESSION['ftpuser']) ? $_SESSION['ftpuser'] : '');
    $_SESSION['ftppass'] = isset($_POST['ftppass']) ? trim($_POST['ftppass']) : (!empty($_SESSION['ftppass']) ? $_SESSION['ftppass'] : '');

    if ($ftp->connect($_SESSION['ftpserver'], 21) !== TRUE) {
        $urlerror .= '<p class="error"><img src="img/wrong.gif" border="0" width="12" height="12" alt="' . $lang[$userlang]['ERROR'].'"> ' . $lang[$userlang]['STEP0_FTP_NO_CONNECTION'] . '</p>';
        $lmo_install_step=0;
    } else {
        if ($ftp->login($_SESSION['ftpuser'], $_SESSION['ftppass']) !== TRUE) {
            $ftp->disconnect();
            $loginerror .= '<p class="error"><img src="img/wrong.gif" border="0" width="12" height="12" alt="' . $lang[$userlang]['ERROR'].'"> ' . $lang[$userlang]['STEP0_FTP_NO_LOGIN'] . '</p>';
            $lmo_install_step = 0;
        }
    }

    if ($lmo_install_step != 0) {
        $_SESSION['ftpdir'] = isset($_POST['ftpdir']) ? trim(str_replace("../",'',$_POST['ftpdir'])) : '';
        $ftpdir = $_SESSION['ftpdir'];
        if (empty($_POST['ftpdir'])) {
            // Choose path

            $_SESSION['view'] = isset($_GET['view']) ? trim(str_replace("../",'',$_GET['view'])) : '';
            $filelist = filecollect($ftp, $_SESSION['view']);
        } else {
            // Path selected -> set rights

            $ftp->cd($ftpdir);
            if (PEAR::isError($ftp->size("init.php"))) {
                // Pathtest
                $ftp->cd('..');
                $patherror .= '<p class="error"><img src="img/wrong.gif" border="0" width="12" height="12" alt="' . $lang[$userlang]['ERROR'] . '"> "' . $ftpdir . '": ' . $lang[$userlang]['ERROR_WRONG_PATH'] . '</p>';
                $filelist = filecollect($ftp, $_SESSION['view']);
                $lmo_install_step = 1;
            } else {
                foreach ($filelist as $chmod => $files) {
                    foreach ($files as $file) {
                        if (strpos($file,'*')) {
                            $ligen = $ftp->ls(".", NET_FTP_FILES_ONLY);
                            foreach ($ligen as $liga) {
                                if (substr($liga['name'], -4) == substr($file,-4)){
                                    $ftp->chmod($liga, $chmod);
                                }
                            }
                        } else {
                            // Handle config files
                            if (strpos($file, "cfg.txt") !== FALSE || strpos($file,"auth") !== FALSE) {
                                if (!file_exists($lmo_dir . "/" . $file)) {
                                    if (strpos($file, "lmo-auth.php")!==FALSE && file_exists($lmo_dir . "/lmo-auth.txt")) {
                                        // copy old auth-file into new one
                                        $auth_old = file($lmo_dir . "/lmo-auth.txt");
                                        $auth_file = fopen($lmo_dir . "/" . $file, "wb");
                                        fwrite($auth_file, "<?php exit(); ?>\n");
                                        foreach ($auth_old as $old) {
                                            fwrite($auth_file, $old . "\n");
                                        }
                                        fclose($auth_file);
                                    }
                                    // Copy install/cfg.txt    if cfg.txt not exists
                                    $ftp->put(__DIR__ . "/" . $file, $file);
                                    $ftp->chmod($file, $chmod);
                                } else {
                                    if (strpos($file, "cfg.txt") !== FALSE) {
                                        // Merge config files
                                        // Read config files
                                        $cfg_old = parse_ini_file($lmo_dir . "/" . $file);
                                        $cfg_new = parse_ini_file(__DIR__ . "/" . $file);
                                        // Merge config files
                                        foreach ($cfg_new as $new_key => $new_value) {
                                            if (!array_key_exists($new_key, $cfg_old)) {
                                                $cfg_old[$new_key] = $new_value;
                                            }
                                        }
                                        // Make cfg.txt writable
                                        $ftp->chmod($file, $chmod);
                                        // Write merged configuration
                                        $mergedfile = fopen($lmo_dir . "/" . $file, "wb");
                                        foreach ($cfg_old as $merged_key => $merged_value) {
                                            fwrite($mergedfile, $merged_key . "=" . $merged_value . "\n");
                                        }
                                    }
                                }
                            }
                            $ftp->chmod($file, $chmod);
                        }
                    }
                }
                $lmo_install_step = 2;
            }
        }
        $ftp->disconnect();
    }
}

if ($lmo_install_step == 3) {
    $path = isset($_POST['path']) ? $_POST['path'] : $path;
    $url = isset($_POST['url']) ? $_POST['url'] : $url;

    $path = substr($path, -1) == '/' ? substr($path, 0, -1) : $path;
    $url = substr($url, -1) == '/' ? substr($url, 0, -1) : $url;

    $_SESSION['url1'] = $url;

    $filename = $path . "/config/init-parameters.php";
    $somecontent = "<?php \n\t\$lmo_dateipfad='" . $path . "'; //Dateipfad zum LMO\n\t\$lmo_url='" . $url . "'; //abolute URL zum LMO\n?>";
    // Make sure the file exists and is writable
    if (!$handle = fopen($filename, "wb")) {
        $installerror .= '<p class="error"><img src="../img/wrong.gif" border="0" width="12" height="12" alt="' . $lang[$userlang]['ERROR'] . '"> ' . $lang[$userlang]['STEP3_ERROR_INI_FILE_NOT_OPENABLE'] . '</p>';
    } else {
        if (!fwrite($handle, $somecontent)) {
            $installerror .= '<p class="error"><img src="img/wrong.gif" border="0" width="12" height="12" alt="' . $lang[$userlang]['ERROR'] . '"> ' . $lang[$userlang]['STEP3_ERROR_INI_FILE_NOT_WRITEABLE'] . '</p>';
        } else {
            $installerror .= '<p><em><img src="img/right.gif" border="0" width="12" height="12" alt="' . $lang[$userlang]['SUCCESS'] . '"> ' . $lang[$userlang]['STEP3_SUCCESS_INI_FILE'] . '</em></p>';
        }
        fclose($handle);
    }
}

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="<?php echo $userlang?>">
    <head>
        <title><?php echo $lang[$userlang]['HEADER'];?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" >
        <style type="text/css">
            @media all {
                body         {    max-width:60em;margin: 0.5em auto;padding:0 0.9em;font-size:85%;background-color: #ffffff;color: #000000;font-family:Tahoma, Verdana, sans-serif;border:1px solid #999;-moz-border-radius:8px;}
                acronym    {    cursor:help;border-bottom:1px dotted;}
                table        {    margin:auto;}
                em             {    font-style:normal;font-weight:bold;color:#080;}
                img            {    border:0;}
                ul             {    margin:2em 0;padding:0.2em;font-weight:bold;list-style-type: none;background:#009;border:2px solid #fcfcff;color:#fcfcff;}
                li             {    padding:0;margin:0.5em 0;}
                dd             {    margin: 0.5em 3em;}
                dt             {    padding:0.1em 1em;line-height:135%;font-weight:bold;background-color:#009;color:#fcfcff;}
                ul a,dt a{    color:#fcfcff;}
                dl             {    border:1px solid #aca;background:#e0e7ff;padding:0.4em;}
                strong     {    color:#fa6;}
                h1, h2     {    font-family:"Trebuchet MS", Georgia, sans-serif;}
                h1             {    font-size:135%;text-align:center;}
                h2             {    font-size:115%;}
                p                {    margin:0.3em;}
                .error     {    border:1px solid #d99;background:#ffe7e0;padding:0.4em;}
                .foot        {    text-align:left;margin-top:1em;font-size:85%;}
                .flag { float:right; margin:0.5em; }
                .flag a { display: block;    /*width: 100%;*/}
                .w3cbutton3 {    float:right; margin:0.5em;    border: 1px solid #999;    font-family: helvetica,arial,sans-serif;    font-size: 70%;    font-weight: bold;}
                .w3cbutton3 a {    display: block;    /*width: 100%;*/}
                .w3cbutton3 a:link,
                .w3cbutton3 a:visited,
                .w3cbutton3 a:hover {     background-color: #fc6;    color: #000;    text-decoration: none;}
                .w3cbutton3 span.w3c {    padding: 0 0.4em;    background-color: #fff;    color: #0c479d;}

                /*CSS3-values*/
                dl, .error {-moz-border-radius:8px;-webkit-border-radius:8px;border-radius:8px;}
            }
        </style>
    </head>
    <body>
    <h1><?php echo $lang[$userlang]['HEADER'];?></h1><?php

echo $patherror;
if ($lmo_install_step == 0) {
    if (!$_SESSION['man'] && !isset($_REQUEST['man'])) {
        if (version_compare(PHP_VERSION, $min_php_version, '<')) {?>
    <h2><?php echo $lang[$userlang]['ERROR']?></h2>
    <table width="90%">
        <tr>
            <td class="error"><?php echo "<img src='img/wrong.gif' border='0' width='12' height='12' alt='" . $lang[$userlang]['ERROR'] . "'> " . $lang[$userlang]['PHP_ERROR_1'] . " <b>" . $min_php_version . "</b> " . $lang[$userlang]['PHP_ERROR_2'] . " <b>" . PHP_VERSION . "</b>";
            $error++;
?>
            </td>
        </tr>
    </table>
<?php
        }
?>
    <h2><?php echo $lang[$userlang]['STEP0']?></h2>
    <table width="90%">
        <tr>
            <td>
                 <?php echo $lang[$userlang]['STEP0_DESCRIPTION']?>
            </td>
        </tr>
        <tr>
            <td align="center">
                <form action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
                    <dl>
                        <dt><?php echo $lang[$userlang]['STEP0_FTP_SERVER']?></dt>
                        <dd>
                        <?php echo $urlerror?>
                            <input name="ftpserver" type="text" size="50" value="<?php echo isset($_SESSION['ftpserver']) ? $_SESSION['ftpserver'] : $_SERVER['SERVER_NAME'];?>"> <?php echo $lang[$userlang]['STEP0_FTP_SERVER_EXAMPLE']?>
                        </dd>
                        <dt><?php echo $lang[$userlang]['STEP0_FTP_LOGIN']?></dt>
                        <dd>
                        <?php echo $loginerror?>
                            User:<input name="ftpuser" type="text" size="25" value="<?php echo $_SESSION['ftpuser']?>"> Pass:<input name="ftppass" type="password" size="25" value="">
                            <input type="hidden" name="lmo_install_step" value="1">
                        </dd>
                        <dt>
                            <input type="submit" value="<?php echo $lang[$userlang]['PROCEED']?>" <?php if (version_compare(PHP_VERSION, $min_php_version, '<')) echo " disabled='disabled'"?>>
                        </dt>
                    </dl>
                </form>
            </td>
        </tr>
    </table><?php

    } else {
        $lmo_install_step = 2;
    }
}

if ($lmo_install_step == 1) {?>
    <h2><?php echo $lang[$userlang]['STEP1']?></h2>
    <table width="90%">
        <tr>
            <td>
                <form action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
                    <dl>
                        <dt><?php echo $lang[$userlang]['STEP1_SELECT_FTP_DIR']?></dt><?php
    if ($_SESSION['view'] != '') {
        echo "<dd>&nbsp;<a href='" . $_SERVER['PHP_SELF'] . "?lmo_install_step=1&amp;view=".dirname($_SESSION['view']) . "'>..</a></dd>";
    }
    if (!empty($filelist)) {
        foreach ($filelist as $ftpdir) {
            echo "<dd><input type='radio' value='$ftpdir' name='ftpdir'> <a href='" . $_SERVER['PHP_SELF'] . "?lmo_install_step=1&amp;view=$ftpdir'>" . basename($ftpdir) . "</a></dd>";
        }
    }
?>
                        <dt>
                            <input type="hidden" name="lmo_install_step" value="1">
                            <input type="submit" value="<?php echo $lang[$userlang]['PROCEED']?>">
                        </dt>
                    </dl>
                </form>
            </td>
        </tr>
    </table><?php
}

if ($lmo_install_step == 2) { //Manuell
?>
    <h2><?php echo $lang[$userlang]['STEP2']?></h2>
    <table width="90%"><?php
    if ($_SESSION['man']) {?>
        <tr>
            <td>
                <?php echo $lang[$userlang]['STEP2_MANUAL']?>
            </td>
        </tr><?php
    }?>
        <tr>
            <td>
                <form action="<?php echo $_SERVER['PHP_SELF']?>" method="post" onSubmit="return check();">
                    <dl>
                        <dt>PHP > <?php echo $min_php_version; ?></dt>
                        <dd><?php
    $error=0;
    if (version_compare(PHP_VERSION, $min_php_version, '<')) {
        echo "<img src='img/wrong.gif' border='0' width='12' height='12' alt='" . $lang[$userlang]['ERROR'] . "'> PHP: " . PHP_VERSION;
        $error++;
    } else {
        echo "<img src='img/right.gif' border='0' width='12' height='12' alt='" . $lang[$userlang]['SUCCESS'] . "'> PHP: " . PHP_VERSION;
    }
    foreach ($filelist as $chmod=>$files) {
        echo "<dt>chmod " . ($chmod) . "</dt>";
        foreach ($files as $file) {
            echo "\n                        <dd>";
            if (strpos($file,'*')) {
                $handle = opendir ($lmo_dir . "/" . dirname($file));
                while (false !== ($file2 = readdir($handle))) {
                    if ($file2 != "." && $file2 != ".." && !is_dir($lmo_dir . "/" . dirname($file) . "/$file2")) {
                        if (is_writable($lmo_dir . "/" . dirname($file) . "/$file2")) {
                            echo "<img src='img/right.gif' border='0' width='12' height='12' alt='" . $lang[$userlang]['SUCCESS'] . "'> " . dirname($file) . "/$file2"." <small>(" . ($chmod) . ")</small><dd>";
                        } else {
                            echo "<img src='img/wrong.gif' border='0' width='12' height='12' alt='" . $lang[$userlang]['ERROR'] . "'> " . dirname($file) . "/$file2"." <small>(" . ($chmod) . ")</small><dd>";
                            $error++;
                        }
                    }

                }
            } else {
                if (is_writable($lmo_dir . "/" . $file)) {
                    echo "<img src='img/right.gif' border='0' width='12' height='12' alt='" . $lang[$userlang]['SUCCESS'] . "'> $file <small>(" . ($chmod) . ")</small>";
                } else {
                    echo "<img src='img/wrong.gif' border='0' width='12' height='12' alt='" . $lang[$userlang]['ERROR'] . "'> $file <small>(" . ($chmod) . ")</small>";
                    $error++;
                }
            }
        }
    }?>
                    </dd>
                    <dt>
                        <input type="hidden" name="lmo_install_step" value="3">
                        <input type="submit" value="<?php echo $lang[$userlang]['PROCEED']?>">
                    </dt>
                </dl>
            </form>
                <script type="text/javascript">
                function check() {
                    if (<?php echo $error?> > 0) {
                        return confirm("<?php echo $lang[$userlang]['ERROR_CONFIRM']?>");
                    }
                    return true;
                }
                </script>
        </td>
     </tr>
    </table><?php
}


if ($lmo_install_step == 3) {?>
    <h2><?php echo $lang[$userlang]['STEP3']?></h2>
    <table width="90%">
        <tr>
            <td>
                <form action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
                    <dl>
                        <dt><?php echo $lang[$userlang]['STEP3_PATH']?></dt>
                        <dd>
                        <?php echo $patherror?>
                            <a href="#" onclick="document.getElementsByName('path')[0].value='<?php echo $path;?>';return false;"><em>[Auto]</em></a>
                            <input name="path" type="text" size="55" value="<?php echo $path?>"> <?php echo $lang[$userlang]['STEP3_PATH_EXAMPLE']?>
                        </dd>
                        <dd><?php
                            if (file_exists($path . "/config/init-parameters.php")) {
                                echo "<img src='img/right.gif' border='0' width='12' height='12' alt='" . $lang[$userlang]['SUCCESS'] . "'> " . $lang[$userlang]['STEP3_PATH_CORRECT'];
                            } else {
                                echo "<img src='img/wrong.gif' border='0' width='12' height='12' alt='" . $lang[$userlang]['ERROR'] . "'> " . $lang[$userlang]['STEP3_PATH_WRONG'];
                                $error = 1;
                            }?>
                        </dd>
                        <dt><?php echo $lang[$userlang]['STEP3_URL']?></dt>
                        <dd>
                        <?php echo $urlerror?>
                            <a href="#" onclick="document.getElementsByName('url')[0].value='<?php echo addslashes($url)?>';return false;"><em>[Auto]</em></a>
                            <input name="url" type="text" size="55" value="<?php echo $url?>"> <?php echo $lang[$userlang]['STEP3_URL_EXAMPLE'];?>
                        </dd>
                        <dd><?php
                            echo "<img src='$url/img/right.gif' border='0' width='12' height='12' alt='" . $lang[$userlang]['ERROR'] . "'> " . $lang[$userlang]['STEP3_URL_CORRECT'];
                            ?>
                        </dd>
                        <dt>
                            <input type="hidden" name="lmo_install_step" value="4">
                            <input type="submit" name="check" value="<?php echo $lang[$userlang]['CHECK_AGAIN']?>">
                            <input type="submit" value="<?php echo $lang[$userlang]['PROCEED']?>">
                        </dt>
                    </dl>
                    <script type="text/javascript">
                        function check() {
                            if (<?php echo $error?> > 0) {
                                return confirm("<?php echo $lang[$userlang]['ERROR_CONFIRM']?>");
                            }
                            return true;
                        }
                    </script>
                </form>
            <td>
        <tr>
    </table><?php
}


if ($lmo_install_step == 4) {?>
    <h2><?php echo $lang[$userlang]['STEP4']?></h2>
    <dl>
        <dt><?php echo $lang[$userlang]['STEP4_TEXT1']?></dt>
        <dd><?php echo $lang[$userlang]['STEP4_TEXT2']?></dd>
        <dd class="error"><?php echo $lang[$userlang]['STEP4_TEXT3']?></dd>
        <dd><?php echo sprintf($lang[$userlang]['STEP4_TEXT4'],$_SESSION['url1'] . "/lmo.php",$_SESSION['url1'] . "/lmo.php",$_SESSION['url1'] . "/lmoadmin.php", $_SESSION['url1'] . "/lmoadmin.php", $_SESSION['url1'] . "/help/Deutsch/index.html", $_SESSION['url1'] . "/help/Deutsch/index.html")?></dd>
        <dd class="error"><?php echo $lang[$userlang]['STEP4_TEXT5']?></dd>
        <dt><?php echo $lang[$userlang]['STEP4_TEXT6']?></dt>
    </dl><?php
}?>

    <div class="foot">

    <div class="w3cbutton3">
        <a href="http://validator.w3.org/check/referer"><span class="w3c">W3C</span>
        <span class="spec">HTML 4.01</span></a></div>
        <div class="w3cbutton3">
        <a href=" http://jigsaw.w3.org/css-validator/check/referer"><span class="w3c">W3C</span>
        <span class="spec">CSS 2.1</span></a></div>
        <div class="flag">
        <a href="<?php echo $_SERVER['PHP_SELF'];?>?userlang=FR"><img src="<?php echo $url;?>/img/Francais.svg" title="Francais" alt="FR" height="14"></a>
        </div>
        <div class="flag">
        <a href="<?php echo $_SERVER['PHP_SELF'];?>?userlang=EN"><img src="<?php echo $url;?>/img/English.svg" title="English" alt="EN" height="14"></a>
        </div>
        <div class="flag">
        <a href="<?php echo $_SERVER['PHP_SELF'];?>?userlang=ES"><img src="<?php echo $url;?>/img/Espanol.svg" title="Espanol" alt="ES" height="14"></a>
        </div>
        <div class="flag">
        <a href="<?php echo $_SERVER['PHP_SELF'];?>?userlang=DE"><img src="<?php echo $url;?>/img/Deutsch.svg" title="Deutsch" alt="DE" height="14"></a>
        </div>
        <div class="w3cbutton3">
        <a href="<?php echo $_SERVER['PHP_SELF'];?>"><span class="w3c">RE</span>
        <span class="spec">START</span></a></div>
         © René Marth/<a href="https://www.liga-manager-online.de/">LMO Group</a>
    </div>
    </body>
</html>

<?php

function filecollect(&$ftp, $dir = '.') {
    $ftp->cd($dir);
    $list = $ftp->ls(".", NET_FTP_DIRS_ONLY);
    if ($list === false) echo "LIST FAILS!";
    else {
        foreach ($list as $entry) {
            if ($entry['name'] != '.' && $entry['name'] != '..') {
                $return[] = $dir . "/" . $entry['name'];
            }
        }
    }
    return $return;
}
?>