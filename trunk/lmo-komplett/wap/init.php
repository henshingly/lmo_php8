<?
if (session_id()=="") session_start();
$x=explode('/',$_SERVER['PATH_TRANSLATED']);
define('PATH_TO_LMO', $_SERVER['DOCUMENT_ROOT'].'/tmp/lmo-komplett/lmo');
define('PATH_TO_ADDON_DIR', $_SERVER['DOCUMENT_ROOT'].'/tmp/lmo-komplett/lmo/addon');
define('ADDON_NAME',$x[count($x)-2]);                                    
define('PATH_TO_ADDON', PATH_TO_ADDON_DIR.'/'.ADDON_NAME);


include(PATH_TO_LMO."/lmo-cfgload.php");
include(PATH_TO_LMO."/lmo-langload.php");

?>