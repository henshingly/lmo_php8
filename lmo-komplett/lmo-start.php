<?
/** Liga Manager Online 4
  *
  * http://lmo.sourceforge.net/
  *
  * This program is free software; you can redistribute it and/or
  * modify it under the terms of the GNU General Public License as
  * published by the Free Software Foundation; either version 2 of
  * the License, or (at your option) any later version.
  * 
  * This program is distributed in the hope that it will be useful,
  * but WITHOUT ANY WARRANTY; without even the implied warranty of
  * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
  * General Public License for more details.
  *
  * REMOVING OR CHANGING THE COPYRIGHT NOTICES IS NOT ALLOWED!
  *
  */

if (!function_exists("getmicrotime")) {
  function getmicrotime(){
    list($usec, $sec) = explode(" ",microtime());
    return ((float)$usec + (float)$sec);
  }
}
$startzeit = getmicrotime();
require(dirname(__FILE__)."/init.php");

if((isset($_REQUEST["action"]) && $_REQUEST["action"]=="tipp") && session_id()=="") {
  session_start();
}

$array = array();
$ftype=".l98";
if (isset($_REQUEST['st'])) {$st=$_REQUEST['st'];}
if(!isset($_REQUEST["action"])){
  $_REQUEST["action"]="";
  $action="";
}else{
  $action=$_REQUEST["action"];
}
if (!isset($file)) {
  if(!isset($_REQUEST["file"])){
    $_REQUEST["file"]="";
    $file="";
  }else{
    $file=$_REQUEST["file"];
  }
}
$subdir=isset($_REQUEST["subdir"])?$_REQUEST["subdir"]:'';

if($_REQUEST["action"]=="admin"){
  $_REQUEST["action"]="";
  $action="";
}

include(PATH_TO_LMO."/lmo-showmain2.php");

?>