<?PHP
// 
// LigaManager Online 3.02
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
require_once("lmo-tipptest.php");

session_register("lmotipperok","lmotippername","lmotipperpass","lmotipperverein");
if(!isset($HTTP_SESSION_VARS["lmotipperok"])){$HTTP_SESSION_VARS["lmotipperok"]="0";}
if(isset($HTTP_SESSION_VARS["lmotipperok"])){$lmotipperok=$HTTP_SESSION_VARS["lmotipperok"];}
if(isset($HTTP_SESSION_VARS["lmotippername"])){$lmotippername=$HTTP_SESSION_VARS["lmotippername"];}
if(isset($HTTP_SESSION_VARS["lmotipperpass"])){$lmotipperpass=$HTTP_SESSION_VARS["lmotipperpass"];}
if(isset($HTTP_SESSION_VARS["lmotipperverein"])){$lmotipperverein=$HTTP_SESSION_VARS["lmotipperverein"];}
if(!isset($todo)){$todo="";}
if(!isset($liga)){$liga="";}
if(!isset($file)){$file="";}
if(!isset($wert)){$wert="";}
if(!isset($all)){$all="";}
if($all=="yes"){$all=1;}
if(!isset($teamintern)){$teamintern="";}
if(!isset($endtab)){$endtab=0;}
if(!isset($tippeinsicht)){$tippeinsicht=1;}
if(!isset($jokertippmulti)){$jokertippmulti=2;}
if($todo=="logout"){
  $HTTP_SESSION_VARS["lmotipperok"]=0;
  $lmotipperpass="";
  $lmotipperverein="";
  }
if($todo=="newtipper"){
  $HTTP_SESSION_VARS["lmotipperok"]=-4;
  }
if($todo=="getpass"){
  $HTTP_SESSION_VARS["lmotipperok"]=-5;
  }
$action="tipp";
require("lmo-tippauth.php");
setlocale (LC_TIME, "de_DE");
if($HTTP_SESSION_VARS["lmotipperok"]>0){
  require("lmo-tippmain.php");
  }
if($HTTP_SESSION_VARS["lmotipperok"]==-4){
  require("lmo-tippernew.php");
  }
?>