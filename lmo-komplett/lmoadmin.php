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
$lmouserok=0;
session_start();
session_register("lmouserok","lmousername","lmouserpass","lmouserfile");
if(isset($HTTP_SESSION_VARS["lmouserok"])){$lmouserok=$HTTP_SESSION_VARS["lmouserok"];}
if(isset($HTTP_SESSION_VARS["lmousername"])){$lmousername=$HTTP_SESSION_VARS["lmousername"];}
if(isset($HTTP_SESSION_VARS["lmouserpass"])){$lmouserpass=$HTTP_SESSION_VARS["lmouserpass"];}
if(isset($HTTP_SESSION_VARS["lmouserfile"])){$lmouserfile=$HTTP_SESSION_VARS["lmouserfile"];}
if(!isset($todo)){$todo="";}
if($todo=="logout"){
  $lmouserok="0";
  $lmouserpass="";
  }
ob_start();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
					"http://www.w3.org/TR/html4/loose.dtd">
<html lang="de">
<head>
<title>LMO Admin</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" >
<link rel=stylesheet type="text/css" href="lmo-style.css">
</head>
<body>
<center>

<?PHP
$action="admin";
$array = array("");
require("lmo-langload.php");
require("lmo-adminauth.php");
setlocale (LC_TIME, "de_DE");
if($lmouserok>0){
  require("lmo-cfgload.php");
  require("lmo-tippcfgload.php");
  require("lmo-adminmain.php");
  }
?>

</center>
</body>
</html>
<?PHP
ob_end_flush();
?>