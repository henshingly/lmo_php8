<?PHP
// 
// LigaManager Online 3.02a
// Copyright (C) 1997-2002 by Frank Hollwitz
// webmaster@hollwitz.de / http://php.hollwitz.de
// 
// Tippspiel-AddOn 1.20
// Copyright (C) 2002 by Frank Albrecht
// fkalbrecht@web.de
// 
// This program is free software; you can redistribute it and/or
// modify it under the terms of the GNU General Public License as
// published by the Free Software Foundation; either version 2 of
// the License, or (at your option) any later version.
// 
// This program is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
// General Public License for more details.
// 
// You should have received a copy of the GNU General Public License
// along with this program; if not, write to the Free Software
// Foundation, Inc., 675 Mass Ave, Cambridge, MA 02139, USA.
// 
define('LMO_AUTH', 1);
define('PATH_TO_LMO', $_SERVER['DOCUMENT_ROOT'].'/tmp/lmo-komplett/lmo');
define('PATH_TO_ADDON_DIR', $_SERVER['DOCUMENT_ROOT'].'/tmp/lmo-komplett/lmo/addon');
session_start();
if(!isset($_SESSION["lmouserok"])){$_SESSION["lmouserok"]=0;}
if(!isset($_SESSION["lmousername"])){$_SESSION["lmousername"]="";}
if(!isset($_SESSION["lmouserpass"])){$_SESSION["lmouserpass"]="";}
if(!isset($_SESSION["lmouserfile"])){$_SESSION["lmouserfile"]="";}
if(isset($_GET["lmouserlang"])){$_SESSION["lmouserlang"]=$_GET["lmouserlang"];}
isset($_REQUEST['todo'])?$todo=$_REQUEST['todo']:$todo="";
if($todo=="logout"){
  $_SESSION['lmouserok']=0;
  $_SESSION['lmouserpass']="";
  }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
					"http://www.w3.org/TR/html4/loose.dtd">
<html lang="de">
<head>
<title>LMO Admin</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" >
<script type="text/javascript">
<!--
 if (document.layers && window.captureEvents) { document.write('<link rel="stylesheet" href="lmo-style-nc.css" type="text/css">'); }
  else { document.write('<link rel="stylesheet" href="lmo-style.css" type="text/css">'); }
//-->
</script>
<noscript>
<link rel="stylesheet" href="lmo-style.css" type="text/css">
</noscript>
</head>
<body>
<center>
<?PHP
$action="admin";
$array = array();
setlocale (LC_TIME, "de_DE");
require(PATH_TO_LMO."/lmo-cfgload.php");

if (isset($_POST["xdeflang"]) && $deflang!=trim($_POST["xdeflang"])) {
  $_SESSION['lmouserlang']=trim($_POST["xdeflang"]);
}
if(isset($_SESSION["lmouserlang"])){$lmouserlang=$_SESSION["lmouserlang"];}else{$lmouserlang=$deflang;}
require(PATH_TO_LMO."/lmo-langload.php");
require(PATH_TO_LMO."/lmo-adminauth.php");

if(isset($_SESSION['lmouserok']) && $_SESSION['lmouserok']>0){
  require(PATH_TO_LMO."/lmo-adminmain.php");
}
?>
</center>
</body>
</html>