<?php
/*
---------------------------------------------------------------
Datei: lmo-adminwap.php
Datum: 18.08.2003
Autor: Lord_Helmchen
Release by bastard (Adminpage)
---------------------------------------------------------------
*/
session_start();
header("Content-type: text/vnd.wap.wml");                // Sag dem Browser, dass jetzt WML kommt
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Ein Datum der Vergangenheit um nicht gecached zu werden
header("Last-Modified: " . gmdate("D, d M Y H:i:s"). " GMT"); 
header("Cache-Control: no-cache, must-revalidate"); 
header("Pragma: no-cache"); 
echo("<?xml version=\"1.0\"?>\n");
echo("<!DOCTYPE wml PUBLIC \"-//WAPFORUM//DTD WML 1.1//EN\" \"http://www.wapforum.org/DTD/wml_1.1.xml\">\n");
echo("<wml>\n");

require_once("lmo-cfgload.php");
require_once("lmo-adminwap_conf.php");
require_once("lmo-langload.php");
require_once("lmo-adminwap_auth.php");
//$lmoAuth = new CLMOAuth;

$array = array("");
require_once("lmo-openfile.php");


$addi=$PHP_SELF."?file=";
$home=$PHP_SELF;

if (isset($_POST['login']))
  $login=$_POST['login'];
elseif (isset($_SESSION['login']))
  $login=$_SESSION['login'];
else $login='';

isset($_POST['pwd'])   ?$pwd=$_POST['pwd']     :$pwd='';
isset($_REQUEST['file'])?$file=$_REQUEST['file']:$file='';

if (isset ($_REQUEST['check']) && $_REQUEST['check']==1) $pwd = $lmo_md5 ? md5($pwd) : $pwd;

if(!isset($_SESSION['userok']) || $_SESSION['userok']===FALSE) {
  if (check_auth($login, $pwd, basename($file, $ftype))===TRUE) {$_SESSION['userok']=TRUE;$_SESSION['login']=$login;}
}
if(isset($_SESSION['userok']) && $_SESSION['userok']===TRUE) {
  if (!isset($_REQUEST['op'])) $_REQUEST['op']="";
	switch($_REQUEST['op']) {
	    case "exit":
        $_SESSION=array();
        session_destroy();
        setcookie(session_name(),"","0","/");
        include ("lmo-adminwap_login.php");
		    break;
		  case "nav":
		    include ("lmo-adminwap_nav.php");
		    break;
		  case "day":
		    include ("lmo-adminwap_result.php");
		    break;
			case "table":
		    include ("lmo-adminwap_table.php");
		    break;
			case "help":
		    include ("lmo-adminwap_help.php");
		    break;
			case "save":
		    include ("lmo-adminwap_save.php");
		    break;
		  default:
		    include ("lmo-adminwap_liga.php");
		    break;
	} # Ende switch($op)
}else { # Ende	if(check_auth($login, $pwd, basename($file)))
	require("lmo-adminwap_login.php");
}
echo("</p>\n");
echo("</card>\n");
echo("</wml>\n");
?>