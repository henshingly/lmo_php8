<?
require_once(dirname(__FILE__).'/../../init.php');
if (!isset($_REQUEST['st'])) $_REQUEST['st']="1";
if (!isset($_REQUEST['op'])) $_REQUEST['op']="";
if (isset($_REQUEST['wap_file'])) $file=$_REQUEST['wap_file'];
$array=array();
require(PATH_TO_LMO.'/lmo-openfile.php');
$begin=isset($_REQUEST['begin'])?$_REQUEST['begin']:0;
header("Content-type: text/vnd.wap.wml");                // Sag dem Browser, dass jetzt WML kommt
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Ein Datum der Vergangenheit um nicht gecached zu werden
header("Last-Modified: " . date("D, d M Y H:i:s"). " GMT"); 
header("Cache-Control: no-cache, must-revalidate"); 
header("Pragma: no-cache"); 
echo('<?xml version="1.0" encoding="iso-8859-1"?>');?>
<!DOCTYPE wml PUBLIC "-//WAPFORUM//DTD WML 1.1//EN" "http://www.wapforum.org/DTD/wml_1.1.xml">
<wml><?
switch($_REQUEST['op']) {

    case "nav":
    require(PATH_TO_ADDONDIR.'/wap/lmo-wap_nav.php');
    break;
    
    case "day":
    require(PATH_TO_ADDONDIR.'/wap/lmo-wap_result.php');
    break;
    
	case "table":
    require(PATH_TO_ADDONDIR.'/wap/lmo-wap_table.php');
    break;
	
	case "help":
    require(PATH_TO_ADDONDIR.'/wap/lmo-adminwap_help.php');
    break;
	
  default:
    require(PATH_TO_ADDONDIR.'/wap/lmo-wap_liga.php');
    break;

}
echo("</wml>\n");