<?
if (session_id()=="") session_start();
@ini_set("session.use_trans_sid","1");
if (!defined('PATH_TO_LMO'))        define('PATH_TO_LMO', $_SERVER['DOCUMENT_ROOT'].'/tmp/lmo-komplett/lmo');
if (!defined('PATH_TO_ADDONDIR'))   define('PATH_TO_ADDONDIR', $_SERVER['DOCUMENT_ROOT'].'/tmp/lmo-komplett/lmo/addon');
if (!defined('PATH_TO_TEMPLATEDIR'))define('PATH_TO_TEMPLATEDIR', $_SERVER['DOCUMENT_ROOT'].'/tmp/lmo-komplett/lmo/template');
if (!defined('URL_TO_LMO'))         define('URL_TO_LMO', 'http://localhost/tmp/lmo-komplett/lmo');
if (!defined('URL_TO_TEMPLATEDIR')) define('URL_TO_TEMPLATEDIR', URL_TO_LMO.'/template');
if (!defined('URL_TO_ADDONDIR'))    define('URL_TO_ADDONDIR', URL_TO_LMO.'/addon');
if (!defined('URL_TO_IMGDIR'))      define('URL_TO_IMGDIR', URL_TO_LMO.'/img');

require_once(PATH_TO_LMO."/lbtemplate.class.php");
require_once(PATH_TO_LMO."/lmo-cfgload.php");
if(isset($_REQUEST["lmouserlang"])){$_SESSION["lmouserlang"]=$_REQUEST["lmouserlang"];}
if(isset($_SESSION["lmouserlang"])){$lmouserlang=$_SESSION["lmouserlang"];}else{$lmouserlang=$deflang;}
require_once(PATH_TO_LMO."/lmo-langload.php");

?>