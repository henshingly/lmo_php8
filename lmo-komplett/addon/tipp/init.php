<?
if (session_id()=="") session_start();
if (!defined('PATH_TO_LMO'))        define('PATH_TO_LMO', $_SERVER['DOCUMENT_ROOT'].'/tmp/lmo-komplett/lmo');
if (!defined('PATH_TO_ADDONDIR'))  define('PATH_TO_ADDONDIR', $_SERVER['DOCUMENT_ROOT'].'/tmp/lmo-komplett/lmo/addon');
if (!defined('URL_TO_LMO'))         define('URL_TO_LMO', 'http://localhost/tmp/lmo-komplett/lmo');
if (!defined('URL_TO_ADDONDIR'))    define('URL_TO_ADDONDIR', URL_TO_LMO.'/addon');
if (!defined('URL_TO_IMGDIR'))      define('URL_TO_IMGDIR', URL_TO_LMO.'/img');


require_once(PATH_TO_LMO."/lmo-cfgload.php");
if(isset($_REQUEST["lmouserlang"])){$_SESSION["lmouserlang"]=$_REQUEST["lmouserlang"];}
if(isset($_SESSION["lmouserlang"])){$lmouserlang=$_SESSION["lmouserlang"];}else{$lmouserlang=$deflang;}
require_once(PATH_TO_LMO."/lmo-langload.php");

?>