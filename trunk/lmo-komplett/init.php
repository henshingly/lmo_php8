<?
// Dies ist der Dateipfad zum LMO-Verzeichnis ausgehend von deinem Rootverzeichnis (ohne abschliessenden '/'!)
$lmo_dateipfad="/tmp/lmo-komplett/lmo";
// Dies ist die absolute URL zum LMO-Verzeichnis (ohne abschliessenden '/'!)
$lmo_url='http://localhost/tmp/lmo-komplett/lmo';


if (session_id()=="") session_start();
@ini_set("session.use_trans_sid","1");
@ini_set("arg_separator.output","&amp;");
if (!defined('PATH_TO_LMO'))        define('PATH_TO_LMO',         $_SERVER['DOCUMENT_ROOT'].$lmo_dateipfad);
if (!defined('PATH_TO_ADDONDIR'))   define('PATH_TO_ADDONDIR',    PATH_TO_LMO.'/addon');
if (!defined('PATH_TO_TEMPLATEDIR'))define('PATH_TO_TEMPLATEDIR', PATH_TO_LMO.'/template');
if (!defined('PATH_TO_IMGDIR'))     define('PATH_TO_IMGDIR',      PATH_TO_LMO.'/img');
if (!defined('PATH_TO_LANGDIR'))    define('PATH_TO_LANGDIR',     PATH_TO_LMO.'/lang');
if (!defined('PATH_TO_CONFIGDIR'))  define('PATH_TO_CONFIGDIR',   PATH_TO_LMO.'/config');
if (!defined('URL_TO_LMO'))         define('URL_TO_LMO',          $lmo_url);
if (!defined('URL_TO_ADDONDIR'))    define('URL_TO_ADDONDIR',     URL_TO_LMO.'/addon');
if (!defined('URL_TO_TEMPLATEDIR')) define('URL_TO_TEMPLATEDIR',  URL_TO_LMO.'/template');
if (!defined('URL_TO_IMGDIR'))      define('URL_TO_IMGDIR',       URL_TO_LMO.'/img');
if (!defined('URL_TO_LANGDIR'))     define('URL_TO_LANGDIR',      URL_TO_LMO.'/lang');
if (!defined('URL_TO_CONFIGDIR'))   define('URL_TO_CONFIGDIR',    URL_TO_LMO.'/config');

require_once(PATH_TO_LMO."/lbtemplate.class.php");
require_once(PATH_TO_LMO."/lmo-cfgload.php");
if(isset($_REQUEST["lmouserlang"])){$_SESSION["lmouserlang"]=$_REQUEST["lmouserlang"];}
if(isset($_SESSION["lmouserlang"])){$lmouserlang=$_SESSION["lmouserlang"];}else{$lmouserlang=$deflang;}
require_once(PATH_TO_LMO."/lmo-langload.php");

?>