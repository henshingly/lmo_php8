<?
require_once("init.php");

/*header("Content-type: text/vnd.wap.wml");                // Sag dem Browser, dass jetzt WML kommt
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Ein Datum der Vergangenheit um nicht gecached zu werden
header("Last-Modified: " . gmdate("D, d M Y H:i:s"). " GMT"); 
header("Cache-Control: no-cache, must-revalidate"); 
header("Pragma: no-cache"); 
echo("<?xml version=\"1.0\"?>\n");
echo("<!DOCTYPE wml PUBLIC \"-//WAPFORUM//DTD WML 1.1//EN\" \"http://www.wapforum.org/DTD/wml_1.1.xml\">\n");
echo("<wml>\n");*/

if (isset($_POST['wap_username'])) $_SESSION['wap_username']=$_POST['wap_username']; else $_SESSION['wap_username']="";
if (isset($_POST['wap_userpass'])) $_SESSION['wap_userpass']=$_POST['wap_userpass']; else $_SESSION['wap_userpass']="";

require_once(PATH_TO_ADDONDIR."/wap/lmo-adminwap_auth.php");

$array = array();
if (isset($_REQUEST['wap_file'])) $file=$_REQUEST['wap_file'];

require_once(PATH_TO_LMO.'/lmo-openfile.php');





if(isset($_SESSION['wap_userok']) && $_SESSION['wap_userok']>0) {
  if (!isset($_REQUEST['op'])) $_REQUEST['op']="";
	switch($_REQUEST['op']) {
	    case "exit":
        $_SESSION=array();
        session_destroy();
        setcookie(session_name(),"","0","/");
        include (PATH_TO_ADDONDIR."/wap/lmo-adminwap_login.php");
		    break;
		  case "nav":
		    include (PATH_TO_ADDONDIR."/wap/lmo-adminwap_nav.php");
		    break;
		  case "day":
		    include (PATH_TO_ADDONDIR."/wap/lmo-adminwap_result.php");
		    break;
			case "table":
		    include (PATH_TO_ADDONDIR."/wap/lmo-adminwap_table.php");
		    break;
			case "help":
		    include (PATH_TO_ADDONDIR."/wap/lmo-adminwap_help.php");
		    break;
			case "save":
		    include (PATH_TO_ADDONDIR."/wap/lmo-adminwap_save.php");
		    break;
		  default:
		    include (PATH_TO_ADDONDIR."/wap/lmo-adminwap_liga.php");
		    break;
	} # Ende switch($op)
}else { # Ende	if(check_auth($login, $pwd, basename($file)))
	require(PATH_TO_ADDONDIR."/wap/lmo-adminwap_login.php");
}
echo("</p>\n");
echo("</card>\n");
echo("</wml>\n");
?>