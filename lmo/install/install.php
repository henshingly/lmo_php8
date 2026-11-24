<?php
/* Liga Manager Online 4
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
if (file_exists('../composer.json')) {
    $string_json = file_get_contents('../composer.json', false);
}
if (file_exists('./composer.json')) {
    $string_json = file_get_contents('./composer.json', false);
}
$json_a = json_decode($string_json, true, 4);
$lmo_version_search = ['<', '>', '='];
$min_php_version = str_replace($lmo_version_search, '', $json_a['require']['php']);
$error = '';

$_SESSION['userlang'] = isset($_GET['userlang']) ? $_GET['userlang'] : (isset($_SESSION['userlang']) ? $_SESSION['userlang'] : 'DE');
if (!in_array($_SESSION['userlang'], ['DE', 'EN', 'FR', 'ES'], true)) {
    $_SESSION['userlang'] = 'DE';
}
$userlang = $_SESSION['userlang'];

// Verzeichnisse (777) und Dateien (666), die PHP beschreiben können muss
$filelist = [
    777 => ['ligen', 'output', 'config', 'ligen/dfb', 'config/viewer', 'config/smtp', 'addon/tipp/tipps', 'addon/tipp/tipps/auswert', 'addon/tipp/tipps/einsicht', 'addon/tipp/tipps/auswert/vereine', 'addon/spieler/stats'],
    666 => ['config/cfg.txt', 'config/lmo-auth.php', 'config/tipp/cfg.txt', 'config/spieler/cfg.txt', 'config/ticker/cfg.txt', 'config/mini/cfg.txt', 'config/classlib/cfg.txt', 'config/smtp/cfg.php', 'config/smtp/key.php', 'addon/tipp/lmo-tipperauth.php', 'ligen/*.l98']
];
$lang = [
    'DE' => [
        'HEADER' => 'Installation des Liga Manager Online 4',
        'PROCEED' => 'Weiter',
        'SUCCESS' => 'Erfolg',
        'ERROR' => 'Fehler',
        'CHECK_AGAIN' => 'Neu prüfen',
        'PHP_ERROR_1' => 'Zur Installation dieses LMO´s ist ein Webserver mit PHP <b>[MIN_PHP]</b> oder höher erforderlich.<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Ihr Webserver unterstützt dies derzeit nicht, ihre PHP Version ist: <b>[IS_PHP]</b>',
        'ERROR_WRONG_PATH' => 'Der Pfad ist nicht korrekt!',
        'ERROR_CONFIRM' => 'Es sind noch Fehler vorhanden! Der LMO wird NICHT funktionieren. Trotzdem fortfahren?',

        'STEP0' => 'Systemprüfung und Einrichtung',
        'STEP0_DESCRIPTION' => 'Der Installer legt die benötigten Verzeichnisse und Konfigurationsdateien (<code>cfg.txt</code> usw.) selbst an, füllt sie mit den Ausgangswerten und versucht, die nötigen Dateirechte (CHMOD) zu setzen. Eine FTP-Verbindung ist dafür nicht erforderlich. Vorhandene Einstellungen werden nicht überschrieben, fehlende Einstellungen werden bei einem Update lediglich ergänzt.',
        'MODE_UPDATE' => 'Update erkannt: Es sind bereits Einstellungen vorhanden. Vorhandene Dateien bleiben erhalten, es werden nur fehlende Dateien und Einstellungen ergänzt.',
        'MODE_NEW' => 'Neuinstallation: Alle Verzeichnisse und Konfigurationsdateien werden mit den Ausgangswerten neu angelegt.',
        'START' => 'Einrichtung starten',
        'ERROR_INSTALLED' => 'Der LMO ist bereits installiert, der Installer ist deshalb gesperrt. Bitte löschen Sie den Ordner <code>install</code> vom Server oder geben Sie dem Ordner chmod 000.',
        'ERROR_PATH_INVALID' => 'Der Pfad ist ungültig. Dort muss sich die Datei <code>init.php</code> des LMO befinden.',
        'ERROR_URL_INVALID' => 'Die URL ist ungültig. Beispiel: http://www.beispiel.de/lmo',

        'STEP2' => 'Verzeichnisse und Dateien',
        'STEP2_DESCRIPTION' => 'Ergebnis der Einrichtung. Alle Einträge sollten grün sein.',
        'ST_CREATED' => 'angelegt',
        'ST_MERGED' => 'ergänzt',
        'ST_CHMOD' => 'Rechte gesetzt',
        'ST_OK' => 'vorhanden',
        'RECHECK' => 'Erneut prüfen',
        'STEP2_MANUAL' => '<p><strong>Rote Einträge:</strong> PHP darf dort auf Ihrem Server nicht schreiben. Setzen Sie die angegebenen Rechte (CHMOD) einmalig mit Ihrem FTP-Programm und klicken Sie danach auf <em>Erneut prüfen</em>.</p>
            <p><img src="img/DE_manual_chmod.png" alt="Setzen der Rechte mittels FTP-Programm" width="427"></p>',

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
        'STEP4_TEXT2' => 'Falls Fehler aufgetreten sind, wiederholen Sie die Installation oder legen Sie die Datei <code>config/init-parameters.php</code> mit einem Texteditor selbst an (siehe Hilfe) und vergeben Sie die Schreibrechte mit einem FTP-Programm.',
        'CLEAN_BUTTON' => 'Installationsordner jetzt löschen',
        'CLEAN_OK' => 'Der Ordner <code>install</code> wurde gelöscht. Der LMO ist einsatzbereit.',
        'CLEAN_CHMOD' => 'Der Ordner <code>install</code> konnte nicht gelöscht werden und wurde stattdessen mit chmod 000 gesperrt. Löschen Sie ihn bei Gelegenheit per FTP.',
        'CLEAN_FAIL' => 'Der Ordner <code>install</code> konnte nicht gelöscht werden. Bitte löschen Sie ihn selbst per FTP oder Dateimanager.',
        'STEP4_TEXT3' => 'Bitte löschen Sie jetzt unbedingt den Ordner <code>install</code> vom Server oder geben Sie dem Ordner chmod 000.',
        'STEP4_TEXT4' => '<ul class="attention">
            <li><strong>Link zum <acronym title="Liga Manager Online">LMO</acronym>:</strong> <a href="%s">%s</a></li>
            <li><strong>Link zum Adminbereich:</strong> <a href="%s">%s</a> <small>(Standardlogin ist <kbd>admin</kbd> / <kbd>lmo</kbd>)</small></li>
            <li><strong>Link zur Benutzeranleitung:</strong> <a href="%s">%s</a></li>
            </ul>',
        'STEP4_TEXT5' => '<a href="https://paypal.me/LMOforum/"><input type="image" src="img/SpendiermirnenKaffee.svg"></a>',
        'STEP4_TEXT6' => 'Viel Spaß!',
    ],

    'EN' => [
        'HEADER' => 'Installation of Liga Manager Online 4',
        'PROCEED' => 'Proceed',
        'SUCCESS' => 'Success',
        'ERROR' => 'Error',
        'PHP_ERROR_1' => 'To install this LMO, a web server with PHP <b>[MIN_PHP]</b> or higher is required.<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Your web server does not currently support this, your PHP version is: <b>[IS_PHP]</b>',
        'CHECK_AGAIN' => 'Test again',
        'ERROR_WRONG_PATH' => 'Incorrect path!',
        'ERROR_CONFIRM' => 'There are still errors left! Proceed?',

        'STEP0' => 'System check and setup',
        'STEP0_DESCRIPTION' => 'The installer creates the required directories and configuration files (<code>cfg.txt</code> etc.) itself, fills them with the default values and tries to set the necessary file permissions (CHMOD). No FTP connection is needed. Existing settings are never overwritten; when updating, only missing settings are added.',
        'MODE_UPDATE' => 'Update detected: settings already exist. Existing files are kept; only missing files and settings are added.',
        'MODE_NEW' => 'New installation: all directories and configuration files will be created with the default values.',
        'START' => 'Start setup',
        'ERROR_INSTALLED' => 'The LMO is already installed, so the installer is locked. Please delete the folder <code>install</code> from the server or chmod it to 000.',
        'ERROR_PATH_INVALID' => 'The path is invalid. The file <code>init.php</code> of the LMO must be located there.',
        'ERROR_URL_INVALID' => 'The URL is invalid. Example: http://www.example.com/lmo',

        'STEP2' => 'Directories and files',
        'STEP2_DESCRIPTION' => 'Result of the setup. All entries should be green.',
        'ST_CREATED' => 'created',
        'ST_MERGED' => 'completed',
        'ST_CHMOD' => 'permissions set',
        'ST_OK' => 'present',
        'RECHECK' => 'Check again',
        'STEP2_MANUAL' => '<p><strong>Red entries:</strong> PHP is not allowed to write there on your server. Set the listed permissions (CHMOD) once with your FTP program and then click <em>Check again</em>.</p>
            <p><img src="img/EN_manual_chmod.png" alt="Setting the permissions with an FTP program" width="427"></p>',

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
        'STEP4_TEXT2' => 'If errors occurred, repeat the installation or create the file <code>config/init-parameters.php</code> yourself with a text editor (see help) and set the write permissions with an FTP program.',
        'CLEAN_BUTTON' => 'Delete installation folder now',
        'CLEAN_OK' => 'The folder <code>install</code> has been deleted. LMO is ready to use.',
        'CLEAN_CHMOD' => 'The folder <code>install</code> could not be deleted and was locked with chmod 000 instead. Please delete it via FTP when convenient.',
        'CLEAN_FAIL' => 'The folder <code>install</code> could not be deleted. Please delete it yourself via FTP or your file manager.',
        'STEP4_TEXT3' => 'Please delete the folder <code>install</code> or chmod it to 000.',
        'STEP4_TEXT4' => '<ul class="attention">
            <li><strong>Link to <acronym title="Liga Manager Online">LMO</acronym>:</strong> <a href="%s">%s</a></li>
            <li><strong>Link to admin area:</strong> <a href="%s">%s</a> <small>(Login is <kbd>admin</kbd> / <kbd>lmo</kbd>)</small></li>
            <li><strong>Link to Help:</strong> <a href="%s">%s</a></li>
            </ul>',
        'STEP4_TEXT5' => '<a href="https://paypal.me/LMOforum/"><input type="image" src="img/Spendacoffee.svg"></a>',
        'STEP4_TEXT6' => 'Have fun!',
    ],

    'FR' => [
        'HEADER' => 'Installation du Liga Manager Online 4',
        'PROCEED' => 'Continuer',
        'SUCCESS' => 'Succès',
        'ERROR' => 'Erreur',
        'PHP_ERROR_1' => 'Pour installer ce LMO, un serveur Web avec PHP <b>[MIN_PHP]</b> ou supérieur est requis.<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Votre serveur Web ne le prend pas actuellement en charge, votre version PHP est : <b>[IS_PHP]</b>',
        'CHECK_AGAIN' => 'Vérifier de nouveau',
        'ERROR_WRONG_PATH' => 'Le chemin n\'est pas correct!',
        'ERROR_CONFIRM' => 'Il y a encore des erreurs! Désirez-vous quand même continuer?',

        'STEP0' => 'Vérification du système et configuration',
        'STEP0_DESCRIPTION' => 'Le programme d\'installation crée lui-même les répertoires et les fichiers de configuration nécessaires (<code>cfg.txt</code>, etc.), les remplit avec les valeurs par défaut et essaie de définir les droits d\'accès (CHMOD) requis. Aucune connexion FTP n\'est nécessaire. Les réglages existants ne sont jamais écrasés ; lors d\'une mise à jour, seuls les réglages manquants sont ajoutés.',
        'MODE_UPDATE' => 'Mise à jour détectée : des réglages existent déjà. Les fichiers existants sont conservés ; seuls les fichiers et réglages manquants sont ajoutés.',
        'MODE_NEW' => 'Nouvelle installation : tous les répertoires et fichiers de configuration seront créés avec les valeurs par défaut.',
        'START' => 'Lancer la configuration',
        'ERROR_INSTALLED' => 'Le LMO est déjà installé, le programme d\'installation est donc verrouillé. Veuillez supprimer le dossier <code>install</code> du serveur ou lui donner chmod 000.',
        'ERROR_PATH_INVALID' => 'Le chemin n\'est pas valide. Le fichier <code>init.php</code> du LMO doit s\'y trouver.',
        'ERROR_URL_INVALID' => 'L\'adresse URL n\'est pas valide. Exemple : http://www.exemple.fr/lmo',

        'STEP2' => 'Répertoires et fichiers',
        'STEP2_DESCRIPTION' => 'Résultat de la configuration. Toutes les entrées devraient être vertes.',
        'ST_CREATED' => 'créé',
        'ST_MERGED' => 'complété',
        'ST_CHMOD' => 'droits définis',
        'ST_OK' => 'présent',
        'RECHECK' => 'Vérifier à nouveau',
        'STEP2_MANUAL' => '<p><strong>Entrées rouges :</strong> PHP n\'a pas le droit d\'écrire à cet endroit sur votre serveur. Définissez une seule fois les droits indiqués (CHMOD) avec votre programme FTP, puis cliquez sur <em>Vérifier à nouveau</em>.</p>
            <p><img src="img/FR_manual_chmod.png" alt="Définir les droits avec un programme FTP" width="427"></p>',

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
        'STEP4_TEXT2' => 'Si des erreurs sont survenues, répétez l\'installation ou créez vous-même le fichier <code>config/init-parameters.php</code> avec un éditeur de texte (voir l\'aide) et définissez les droits d\'écriture avec un programme FTP.',
        'CLEAN_BUTTON' => 'Supprimer maintenant le répertoire d\'installation',
        'CLEAN_OK' => 'Le répertoire <code>install</code> a été supprimé. LMO est prêt à l\'emploi.',
        'CLEAN_CHMOD' => 'Le répertoire <code>install</code> n\'a pas pu être supprimé et a été verrouillé avec chmod 000. Supprimez-le par FTP dès que possible.',
        'CLEAN_FAIL' => 'Le répertoire <code>install</code> n\'a pas pu être supprimé. Veuillez le supprimer vous-même par FTP ou avec le gestionnaire de fichiers.',
        'STEP4_TEXT3' => 'Veuillez supprimer à tout prix le répertoire <code>install</code> de votre serveur ou bien lui donner les droits d\accès chmod 000.',
        'STEP4_TEXT4' => '<ul class="attention">
            <li><strong>Le <acronym title="Liga Manager Online">LMO</acronym>:</strong> <code><a href="%s">%s</a></code>
            <li><strong>Le secteur d\'administration:</strong> <code><a href="%s">%s</a></code> (L\'indentifiant par défaut est <kbd>admin</kbd>/<kbd>lmo</kbd>)
            <li><strong>Description d\'utlisation:</strong> <code><a href="%s">%s</a></code>
            </ul>',
        'STEP4_TEXT5' => '<a href="https://paypal.me/LMOforum/"><input type="image" src="img/Distribueuncafe.svg"></a>',
        'STEP4_TEXT6' => 'Bon courage!',
    ],

    'ES' => [
        'HEADER' => 'Installación de Liga Manager Online 4',
        'PROCEED' => 'Proceder',
        'SUCCESS' => 'Exitoso',
        'ERROR' => 'Error',
        'PHP_ERROR_1' => 'Para instalar este LMO, se requiere un servidor web con PHP <b>[MIN_PHP]</b> o superior.<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Su servidor web no lo admite actualmente, su versión de PHP es: <b>[IS_PHP]</b>',
        'CHECK_AGAIN' => 'Intenta otra vez',
        'ERROR_WRONG_PATH' => 'Directorio incorrecto!',
        'ERROR_CONFIRM' => 'Aun hay errores! Continuar?',

        'STEP0' => 'Comprobación del sistema y configuración',
        'STEP0_DESCRIPTION' => 'El instalador crea por sí mismo los directorios y archivos de configuración necesarios (<code>cfg.txt</code>, etc.), los rellena con los valores predeterminados e intenta establecer los permisos de archivo (CHMOD) necesarios. No se necesita conexión FTP. Los ajustes existentes nunca se sobrescriben; en una actualización solo se añaden los ajustes que faltan.',
        'MODE_UPDATE' => 'Actualización detectada: ya existen ajustes. Los archivos existentes se conservan; solo se añaden los archivos y ajustes que faltan.',
        'MODE_NEW' => 'Instalación nueva: todos los directorios y archivos de configuración se crearán con los valores predeterminados.',
        'START' => 'Iniciar la configuración',
        'ERROR_INSTALLED' => 'LMO ya está instalado, por lo que el instalador está bloqueado. Elimine la carpeta <code>install</code> del servidor o asígnele chmod 000.',
        'ERROR_PATH_INVALID' => 'La ruta no es válida. Allí debe encontrarse el archivo <code>init.php</code> de LMO.',
        'ERROR_URL_INVALID' => 'La URL no es válida. Ejemplo: http://www.ejemplo.es/lmo',

        'STEP2' => 'Directorios y archivos',
        'STEP2_DESCRIPTION' => 'Resultado de la configuración. Todas las entradas deberían estar en verde.',
        'ST_CREATED' => 'creado',
        'ST_MERGED' => 'completado',
        'ST_CHMOD' => 'permisos establecidos',
        'ST_OK' => 'existente',
        'RECHECK' => 'Comprobar de nuevo',
        'STEP2_MANUAL' => '<p><strong>Entradas en rojo:</strong> PHP no puede escribir allí en su servidor. Establezca una sola vez los permisos indicados (CHMOD) con su programa FTP y haga clic después en <em>Comprobar de nuevo</em>.</p>
            <p><img src="img/ES_manual_chmod.png" alt="Establecer los permisos con un programa FTP" width="427"></p>',

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
        'STEP4_TEXT2' => 'Si se han producido errores, repita la instalación o cree usted mismo el archivo <code>config/init-parameters.php</code> con un editor de texto (consulte la ayuda) y establezca los permisos de escritura con un programa FTP.',
        'CLEAN_BUTTON' => 'Eliminar ahora la carpeta de instalación',
        'CLEAN_OK' => 'La carpeta <code>install</code> se ha eliminado. LMO está listo para usarse.',
        'CLEAN_CHMOD' => 'No se pudo eliminar la carpeta <code>install</code>; se bloqueó con chmod 000. Elimínela por FTP cuando pueda.',
        'CLEAN_FAIL' => 'No se pudo eliminar la carpeta <code>install</code>. Elimínela usted mismo por FTP o con el administrador de archivos.',
        'STEP4_TEXT3' => 'Por favor elimine el archivo <code>install.php</code> o cambie los permisos chmod a 000.',
        'STEP4_TEXT4' => '<ul class="attention">
            <li><strong>Enlace a <acronym title="Liga Manager Online">LMO</acronym>:</strong> <a href="%s">%s</a></li>
            <li><strong>Enlace al área de administración:</strong> <a href="%s">%s</a> <small>(El login por defecto es <kbd>admin</kbd> / <kbd>lmo</kbd>)</small></li>
            <li><strong>Enlace a la guía del usuario:</strong> <a href="%s">%s</a></li>
            </ul>',
        'STEP4_TEXT5' => '<a href="https://paypal.me/LMOforum/"><input type="image" src="img/Tomaruncafe.svg"></a>',
        'STEP4_TEXT6' => 'Disfrútalo!',
    ]
];
/*    End of config area */

if (!empty($_GET['debug']) || !empty($_SESSION['debug'])) {
    $_SESSION['debug'] = true;
    @error_reporting(E_ALL);
    @ini_set('display_errors', 'On');
} else {
    @error_reporting(E_ERROR | E_PARSE);
    @ini_set('display_errors', 'Off');
}

$lmo_dir = dirname(__DIR__);
$lmo_dir_slash = str_replace('\\', '/', $lmo_dir);

/**
 * Kopiert die Vorlagen aus install/config und install/addon an ihren Platz im LMO-Verzeichnis, ohne FTP.
 * - fehlende Dateien werden aus der Vorlage angelegt (cfg.txt = Ausgangswerte),
 * - bei vorhandenen cfg.txt werden nur fehlende Einstellungen am Ende ergänzt (nichts wird überschrieben).
 * Rückgabe: array('relativer/pfad' => 'created'|'merged'|'ok'|'error')
 */
function lmo_install_templates($lmo_dir, $install_dir)
{
    $result = [];
    $skip = ['addon/tipp/lmo-tippauth.txt'];   // alte Tipperdatei, nicht mehr verwendet
    foreach (['config', 'addon'] as $top) {
        if (!is_dir($install_dir . '/' . $top)) {
            continue;
        }
        $it = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($install_dir . '/' . $top, FilesystemIterator::SKIP_DOTS));
        foreach ($it as $f) {
            if (!$f->isFile()) {
                continue;
            }
            $rel = str_replace('\\', '/', substr($f->getPathname(), strlen($install_dir) + 1));
            if (in_array($rel, $skip, true)) {
                continue;
            }
            $target = $lmo_dir . '/' . $rel;
            if (!file_exists($target)) {
                if (!is_dir(dirname($target)) && !@mkdir(dirname($target), 0777, true)) {
                    $result[$rel] = 'error';
                    continue;
                }
                if ($rel === 'config/lmo-auth.php' && is_file($lmo_dir . '/lmo-auth.txt')) {
                    // alte Admin-Datei (LMO 3) in die neue, geschützte Datei übernehmen
                    $content = '<?php exit(); ?>' . "\n" . implode("\n", array_map('rtrim', file($lmo_dir . '/lmo-auth.txt'))) . "\n";
                    $ok = @file_put_contents($target, $content, LOCK_EX) !== false;
                } else {
                    $ok = @copy($f->getPathname(), $target);
                }
                if ($ok) {
                    @chmod($target, 0666);
                }
                $result[$rel] = $ok ? 'created' : 'error';
            } elseif (basename($rel) === 'cfg.txt') {
                $result[$rel] = lmo_install_merge_cfg($f->getPathname(), $target);
            }
        }
    }
    return $result;
}

/** Ergänzt in $target alle Einstellungen aus der Vorlage $template, die dort noch fehlen. */
function lmo_install_merge_cfg($template, $target)
{
    $have = [];
    $old = @file_get_contents($target);
    if ($old === false) {
        return 'error';
    }
    foreach (preg_split('/\r\n|\r|\n/', $old) as $line) {
        if (preg_match('/^\s*([A-Za-z0-9_]+)\s*=/', $line, $m)) {
            $have[$m[1]] = true;
        }
    }
    $add = '';
    foreach (preg_split('/\r\n|\r|\n/', (string)@file_get_contents($template)) as $line) {
        if (preg_match('/^\s*([A-Za-z0-9_]+)\s*=/', $line, $m) && !isset($have[$m[1]])) {
            $add .= $line . "\n";
        }
    }
    if ($add === '') {
        return 'ok';
    }
    if ($old !== '' && substr($old, -1) !== "\n") {
        $add = "\n" . $add;
    }
    if (!is_writable($target)) {
        @chmod($target, 0666);
    }
    return @file_put_contents($target, $add, FILE_APPEND | LOCK_EX) !== false ? 'merged' : 'error';
}

/** Legt Verzeichnisse an und versucht, fehlende Schreibrechte zu setzen. Liefert die Liste fürs Prüfprotokoll. */
function lmo_install_prepare($lmo_dir, $filelist)
{
    $states = lmo_install_templates($lmo_dir, __DIR__);
    $rows = [];
    foreach ($filelist as $mode => $entries) {
        foreach ($entries as $entry) {
            if (strpos($entry, '*') !== false) {
                $files = glob($lmo_dir . '/' . $entry);
                $files = $files ? $files : [];
                $files = array_map(function ($p) use ($lmo_dir) { return substr($p, strlen($lmo_dir) + 1); }, $files);
            } else {
                $files = [$entry];
            }
            foreach ($files as $rel) {
                $path = $lmo_dir . '/' . $rel;
                $state = isset($states[$rel]) ? $states[$rel] : 'ok';
                if ($mode == 777 && !is_dir($path)) {
                    if (@mkdir($path, 0777, true)) {
                        @chmod($path, 0777);
                        $state = 'created';
                    }
                }
                if (file_exists($path) && !is_writable($path)) {
                    if (@chmod($path, $mode == 777 ? 0777 : 0666)) {
                        clearstatcache();
                        $state = is_writable($path) ? 'chmod' : 'error';
                    } else {
                        $state = 'error';
                    }
                }
                $rows[] = [$rel, $mode, file_exists($path) && is_writable($path) ? $state : 'error'];
            }
        }
    }
    return $rows;
}

/** Löscht den Ordner install (rekursiv). Rückgabe: 'deleted' | 'chmod' | 'failed' */
function lmo_install_remove_self($dir)
{
    $real = realpath($dir);
    if ($real === false || basename($real) !== 'install' || !is_file($real . '/install.php') || !is_file(dirname($real) . '/init.php')) {
        return 'failed';
    }
    @chmod($real, 0777);
    $it = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($real, FilesystemIterator::SKIP_DOTS), RecursiveIteratorIterator::CHILD_FIRST);
    foreach ($it as $f) {
        if ($f->isDir() && !$f->isLink()) {
            @chmod($f->getPathname(), 0777);
            @rmdir($f->getPathname());
        } else {
            @unlink($f->getPathname());
        }
    }
    if (@rmdir($real)) {
        return 'deleted';
    }
    return @chmod($real, 0) ? 'chmod' : 'failed';
}

$lmo_install_step = isset($_REQUEST['lmo_install_step']) ? (int)$_REQUEST['lmo_install_step'] : 0;
if (isset($_POST['check'])) {
    $lmo_install_step = 3;
}

$patherror = $urlerror = $installerror = '';
$rows = [];

// Sperre: Ist der LMO schon installiert, darf der Installer nur noch in der laufenden Installation (gleiche Sitzung)
// oder durch den eingeloggten Voll-Admin (Update) benutzt werden. Sonst könnte jeder per POST die Pfade überschreiben.
$installed = is_file($lmo_dir . '/config/init-parameters.php');
$is_admin = isset($_SESSION['lmouserok']) && $_SESSION['lmouserok'] == 2;
$cleanup_ok = isset($_POST['lmo_cleanup'], $_SESSION['lmo_cleanup_token']) && is_string($_POST['lmo_cleanup'])
    && hash_equals($_SESSION['lmo_cleanup_token'], $_POST['lmo_cleanup']);
if ($installed && empty($_SESSION['lmo_install_run']) && !$is_admin && !$cleanup_ok) {
    http_response_code(403);
    echo '<!DOCTYPE html><html><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>' . $lang[$userlang]['HEADER'] . '</title></head><body><h1>' . $lang[$userlang]['HEADER'] . '</h1><p style="color:#a00">' . $lang[$userlang]['ERROR_INSTALLED'] . '</p></body></html>';
    exit();
}
if ($cleanup_ok) {
    unset($_SESSION['lmo_cleanup_token']);
    $cleanup_result = lmo_install_remove_self(__DIR__);
    $lmo_install_step = 5;
} else {
    $_SESSION['lmo_install_run'] = true;
}

// Determine HTTP / HTTPS
if (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' or (isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == 443)) {
    $protocol = 'https:';
} else {
    $protocol = 'http:';
}

$path = $lmo_dir_slash;
if (strpos(dirname($_SERVER['SCRIPT_NAME']), '/install') !== false) {
    $url = $protocol . '//' . $_SERVER['HTTP_HOST'] . dirname(dirname($_SERVER['SCRIPT_NAME']));
} else {
    $url = $protocol . '//' . $_SERVER['HTTP_HOST'] . dirname(($_SERVER['SCRIPT_NAME']));
}
$url = rtrim(str_replace('\\', '/', $url), '/');

// Vorhandene Einstellungen (Update): Pfad und URL aus config/init-parameters.php vorbelegen
$is_update = $installed || is_file($lmo_dir . '/config/cfg.txt') || is_file($lmo_dir . '/lmo-auth.txt');
if ($installed) {
    $ini = (string)@file_get_contents($lmo_dir . '/config/init-parameters.php');
    if (preg_match('/\$lmo_dateipfad\s*=\s*([\'"])(.*?)\1\s*;/', $ini, $m) && $m[2] !== '' && is_file($m[2] . '/init.php')) {
        $path = rtrim(str_replace('\\', '/', $m[2]), '/');
    }
    if (preg_match('/\$lmo_url\s*=\s*([\'"])(https?:\/\/[^\'"\s]+)\1\s*;/i', $ini, $m)) {
        $url = rtrim($m[2], '/');
    }
}

if ($lmo_install_step == 1) {
    // Verzeichnisse und Konfigurationsdateien anlegen, Rechte prüfen/setzen
    $rows = lmo_install_prepare($lmo_dir, $filelist);
    $lmo_install_step = 2;
}

if ($lmo_install_step == 3 || ($lmo_install_step == 4 && isset($_POST['path']))) {
    $was_step4 = ($lmo_install_step == 4);
    $path = isset($_POST['path']) ? rtrim(str_replace('\\', '/', trim($_POST['path'])), '/') : $path;
    $url = isset($_POST['url']) ? rtrim(trim($_POST['url']), '/') : $url;

    $_SESSION['url1'] = $url;

    $path_ok = $path !== '' && preg_match('/^[^\x00-\x1f\'"]+$/', $path) === 1 && is_file($path . '/init.php');
    $url_ok = preg_match('/^https?:\/\/[^\s\'"<>]+$/i', $url) === 1 && filter_var($url, FILTER_VALIDATE_URL) !== false;
    if (!$path_ok) {
        $installerror .= '<p class="error"><img src="img/wrong.svg" border="0" height="20" alt="' . $lang[$userlang]['ERROR'] . '"> ' . $lang[$userlang]['ERROR_PATH_INVALID'] . '</p>';
    } elseif (!$url_ok) {
        $installerror .= '<p class="error"><img src="img/wrong.svg" border="0" height="20" alt="' . $lang[$userlang]['ERROR'] . '"> ' . $lang[$userlang]['ERROR_URL_INVALID'] . '</p>';
    } else {
        $filename = $path . '/config/init-parameters.php';
        $somecontent = "<?php \n\t\$lmo_dateipfad=" . var_export($path, true) . "; //Dateipfad zum LMO\n\t\$lmo_url=" . var_export($url, true) . "; //abolute URL zum LMO\n?>";
        if (@file_put_contents($filename, $somecontent, LOCK_EX) === false) {
            $installerror .= '<p class="error"><img src="img/wrong.svg" border="0" height="20" alt="' . $lang[$userlang]['ERROR'] . '"> ' . $lang[$userlang]['STEP3_ERROR_INI_FILE_NOT_WRITEABLE'] . '</p>';
        } else {
            @chmod($filename, 0666);
            $installerror .= '<p><em><img src="img/right.svg" border="0" height="20" alt="' . $lang[$userlang]['SUCCESS'] . '"> ' . $lang[$userlang]['STEP3_SUCCESS_INI_FILE'] . '</em></p>';
        }
    }
    if ($was_step4) {
        $lmo_install_step = (strpos($installerror, 'class="error"') !== false) ? 3 : 4;
    }
}

?>
<!DOCTYPE html>
<html lang="<?php echo $userlang;?>">
    <head>
        <title><?php echo $lang[$userlang]['HEADER'];?></title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
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

                /* Darstellung auf kleinen Bildschirmen */
                * {box-sizing:border-box;}
                table {width:100%;}
                input[type=text] {width:100%;max-width:40em;}
                dd {margin:0.5em 1em;overflow-wrap:anywhere;}
                .foot {overflow:hidden;}
                .foot > div:last-child {clear:both;}

                /*CSS3-values*/
                dl, .error {-moz-border-radius:8px;-webkit-border-radius:8px;border-radius:8px;}
            }
        </style>
    </head>
    <body>
    <h1><?php echo $lang[$userlang]['HEADER'];?></h1><?php

if ($lmo_install_step == 0) {
    $php_ok = !version_compare(PHP_VERSION, $min_php_version, '<');?>
    <h2><?php echo $lang[$userlang]['STEP0'];?></h2>
    <table>
        <tr>
            <td><?php echo $lang[$userlang]['STEP0_DESCRIPTION'];?></td>
        </tr>
        <tr>
            <td><p><em><?php echo $lang[$userlang][$is_update ? 'MODE_UPDATE' : 'MODE_NEW'];?></em></p></td>
        </tr>
        <tr>
            <td>
                <dl>
                    <dt>PHP &ge; <?php echo $min_php_version; ?></dt>
                    <dd><?php
    if ($php_ok) {
        echo '<img src="img/right.svg" border="0" height="20" alt="' . $lang[$userlang]['SUCCESS'] . '"> PHP: ' . PHP_VERSION;
    } else {
        echo '<img src="img/wrong.svg" border="0" height="20" alt="' . $lang[$userlang]['ERROR'] . '"> ' . str_replace(['[MIN_PHP]', '[IS_PHP]'], [$min_php_version, PHP_VERSION], $lang[$userlang]['PHP_ERROR_1']);
    }?></dd>
<?php if ($php_ok) { ?>
                    <dt>
                        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post">
                            <input type="hidden" name="lmo_install_step" value="1">
                            <input type="submit" value="<?php echo $lang[$userlang]['START'];?>">
                        </form>
                    </dt>
<?php } ?>
                </dl>
            </td>
        </tr>
    </table><?php
}

if ($lmo_install_step == 2) {
    $error = 0;
    $labels = ['created' => $lang[$userlang]['ST_CREATED'], 'merged' => $lang[$userlang]['ST_MERGED'], 'chmod' => $lang[$userlang]['ST_CHMOD'], 'ok' => $lang[$userlang]['ST_OK'], 'error' => ''];?>
    <h2><?php echo $lang[$userlang]['STEP2'];?></h2>
    <table>
        <tr>
            <td><?php echo $lang[$userlang]['STEP2_DESCRIPTION'];?></td>
        </tr>
        <tr>
            <td>
                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post" onSubmit="return check();">
                    <dl><?php
    $last = 0;
    foreach ($rows as $row) {
        list($rel, $mode, $state) = $row;
        if ($mode != $last) {
            echo '<dt>chmod ' . $mode . '</dt>';
            $last = $mode;
        }
        if ($state == 'error') {
            $error++;
            echo "\n                        <dd><img src='img/wrong.svg' border='0' height='20' alt='" . $lang[$userlang]['ERROR'] . "'> " . htmlspecialchars($rel) . ' <small>(' . $mode . ')</small></dd>';
        } else {
            echo "\n                        <dd><img src='img/right.svg' border='0' height='20' alt='" . $lang[$userlang]['SUCCESS'] . "'> " . htmlspecialchars($rel) . ' <small>(' . $mode . ($state != 'ok' ? ', ' . $labels[$state] : '') . ')</small></dd>';
        }
    }
    if ($error > 0) {
        echo '<dt>' . $lang[$userlang]['ERROR'] . '</dt><dd>' . $lang[$userlang]['STEP2_MANUAL'] . '</dd>';
    }?>

                        <dt>
                            <input type="hidden" name="lmo_install_step" value="3">
                            <input type="submit" value="<?php echo $lang[$userlang]['PROCEED'];?>">
                            <button type="submit" name="lmo_install_step" value="1" onclick="this.form.onsubmit=null;"><?php echo $lang[$userlang]['RECHECK'];?></button>
                        </dt>
                    </dl>
                </form>
                <script type="text/javascript">
                function check() {
                    if (<?php echo (int)$error?> > 0) {
                        return confirm("<?php echo $lang[$userlang]['ERROR_CONFIRM'];?>");
                    }
                    return true;
                }
                </script>
            </td>
        </tr>
    </table><?php
}

if ($lmo_install_step == 3) {?>
    <h2><?php echo $lang[$userlang]['STEP3'];?></h2>
    <table>
        <tr>
            <td>
                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post">
                    <dl>
                        <dt><?php echo $lang[$userlang]['STEP3_PATH'];?></dt>
                        <dd>
                            <a href="#" onclick="document.getElementsByName('path')[0].value='<?php echo addslashes($lmo_dir_slash);?>';return false;"><em>[Auto]</em></a>
                            <input name="path" type="text" size="55" value="<?php echo htmlspecialchars($path)?>"> <?php echo $lang[$userlang]['STEP3_PATH_EXAMPLE'];?>
                        </dd>
                        <dd><?php
                            if (is_file($path . '/init.php')) {
                                echo '<img src="img/right.svg" border="0" height="20" alt="' . $lang[$userlang]['SUCCESS'] . '"> ' . $lang[$userlang]['STEP3_PATH_CORRECT'];
                            } else {
                                echo '<img src="img/wrong.svg" border="0" height="20" alt="' . $lang[$userlang]['ERROR'] . '"> ' . $lang[$userlang]['STEP3_PATH_WRONG'];
                            }?>
                        </dd>
                        <dt><?php echo $lang[$userlang]['STEP3_URL'];?></dt>
                        <dd>
                            <a href="#" onclick="document.getElementsByName('url')[0].value='<?php echo addslashes($url)?>';return false;"><em>[Auto]</em></a>
                            <input name="url" type="text" size="55" value="<?php echo htmlspecialchars($url)?>"> <?php echo $lang[$userlang]['STEP3_URL_EXAMPLE'];?>
                        </dd>
                        <dd><?php
                            echo '<img src="' . htmlspecialchars($url) . '/img/right.svg" border="0" height="20" alt="' . $lang[$userlang]['ERROR'] . '"> ' . $lang[$userlang]['STEP3_URL_CORRECT'];
    ?>
                        </dd>
                        <dd><?php echo $installerror; ?></dd>
                        <dt>
                            <input type="hidden" name="lmo_install_step" value="4">
                            <input type="submit" name="check" value="<?php echo $lang[$userlang]['CHECK_AGAIN'];?>">
                            <input type="submit" value="<?php echo $lang[$userlang]['PROCEED'];?>">
                        </dt>
                    </dl>
                </form>
            </td>
        </tr>
    </table><?php
}

if ($lmo_install_step == 4) {
    // Installation abgeschlossen: ab jetzt ist der Installer für fremde Aufrufe gesperrt
    unset($_SESSION['lmo_install_run']);
    $_SESSION['lmo_cleanup_token'] = bin2hex(random_bytes(16));
    $u = isset($_SESSION['url1']) ? htmlspecialchars($_SESSION['url1']) : '';?>
    <h2><?php echo $lang[$userlang]['STEP4'];?></h2>
    <dl>
        <dt><?php echo $lang[$userlang]['STEP4_TEXT1'];?></dt>
        <dd><?php echo $lang[$userlang]['STEP4_TEXT2'];?></dd>
        <dd class="error"><?php echo $lang[$userlang]['STEP4_TEXT3'];?>
            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post" style="margin-top:0.5em">
                <input type="hidden" name="lmo_cleanup" value="<?php echo htmlspecialchars($_SESSION['lmo_cleanup_token']);?>">
                <input type="submit" value="<?php echo $lang[$userlang]['CLEAN_BUTTON'];?>">
            </form></dd>
        <dd><?php echo sprintf($lang[$userlang]['STEP4_TEXT4'], $u . '/lmo.php', $u . '/lmo.php', $u . '/lmoadmin.php', $u . '/lmoadmin.php', $u . '/help/index.html', $u . '/help/Deutsch/index.html'); ?></dd>
        <dd class="error"><?php echo $lang[$userlang]['STEP4_TEXT5'];?></dd>
        <dt><?php echo $lang[$userlang]['STEP4_TEXT6'];?></dt>
    </dl><?php
}?>

<?php
if ($lmo_install_step == 5) {
    $keys = ['deleted' => 'CLEAN_OK', 'chmod' => 'CLEAN_CHMOD', 'failed' => 'CLEAN_FAIL'];?>
    <h2><?php echo $lang[$userlang]['STEP4'];?></h2>
    <p class="<?php echo $cleanup_result == 'deleted' ? '' : 'error';?>"><?php echo $lang[$userlang][$keys[$cleanup_result]];?></p>
    <p><a href="<?php echo htmlspecialchars(isset($_SESSION['url1']) ? $_SESSION['url1'] : '..');?>/lmoadmin.php">lmoadmin.php</a></p><?php
}?>

    <div class="foot">

    <div class="w3cbutton3">
        <a href="http://validator.w3.org/check/referer"><span class="w3c">W3C</span>
        <span class="spec">HTML 5</span></a></div>
        <div class="w3cbutton3">
        <a href=" http://jigsaw.w3.org/css-validator/check/referer"><span class="w3c">W3C</span>
        <span class="spec">CSS 2.1</span></a></div>
        <div class="flag">
        <a href="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>?userlang=FR"><img src="<?php echo htmlspecialchars($url);?>/img/Francais.svg" title="Francais" alt="FR" height="14"></a>
        </div>
        <div class="flag">
        <a href="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>?userlang=EN"><img src="<?php echo htmlspecialchars($url);?>/img/English.svg" title="English" alt="EN" height="14"></a>
        </div>
        <div class="flag">
        <a href="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>?userlang=ES"><img src="<?php echo htmlspecialchars($url);?>/img/Espanol.svg" title="Espanol" alt="ES" height="14"></a>
        </div>
        <div class="flag">
        <a href="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>?userlang=DE"><img src="<?php echo htmlspecialchars($url);?>/img/Deutsch.svg" title="Deutsch" alt="DE" height="14"></a>
        </div>
        <div class="w3cbutton3">
        <a href="<?php echo $_SERVER['PHP_SELF'];?>"><span class="w3c">RE</span>
        <span class="spec">START</span></a></div>
         © René Marth/<a href="https://www.liga-manager-online.de/">LMO Group</a>
    </div>
    </body>
</html>
