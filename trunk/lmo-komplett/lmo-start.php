<?
//
// LigaManager Online 3.02
// Copyright (C) 1997-2002 by Frank Hollwitz
// webmaster@hollwitz.de / http://php.hollwitz.de
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
// Erweiterung für Archiv Funktion durch Georg Strey
function getmicrotime(){
  list($usec, $sec) = explode(" ",microtime());
  return ((float)$usec + (float)$sec);
}
$startzeit = getmicrotime();
require("init.php");

if((isset($_REQUEST["action"]) && $_REQUEST["action"]=="tipp") && session_id()=="") {
  session_start();
}

$array = array();
$ftype=".l98";

require_once(PATH_TO_LMO."/lmo-archiv.php");

if(!isset($_REQUEST["action"])){$_REQUEST["action"]="";$action="";}else{$action=$_REQUEST["action"];}
if(!isset($_REQUEST["file"])){$_REQUEST["file"]="";$file="";}else{$file=$_REQUEST["file"];}
if(!isset($_REQUEST["archiv"])){$_REQUEST["archiv"]="";$archiv="";}else{$archiv=$_REQUEST["archiv"];}

if($_REQUEST["action"]=="admin"){$_REQUEST["action"]="";$action="";}

include(PATH_TO_LMO."/lmo-showmain2.php");

?>