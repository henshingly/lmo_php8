<?php

// Nur fuer PHPStan: init.php legt diese Konstanten zur Laufzeit an (Pfad und URL der Installation),
// die statische Analyse findet sie dort nicht.
foreach (['LMO' => '', 'ADDONDIR' => '/addon', 'TEMPLATEDIR' => '/template', 'IMGDIR' => '/img',
    'LANGDIR' => '/lang', 'CONFIGDIR' => '/config', 'JSDIR' => '/js'] as $name => $dir) {
    defined('PATH_TO_' . $name) || define('PATH_TO_' . $name, __DIR__ . '/lmo' . $dir);
    defined('URL_TO_' . $name) || define('URL_TO_' . $name, 'http://localhost/lmo' . $dir);
}
