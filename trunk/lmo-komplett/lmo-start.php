<?PHP
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

if((isset($_REQUEST["action"]) && $_REQUEST["action"]=="tipp") && session_id()=="") {
  session_start();
}
?>
<script type="text/javascript">
<!--
 NS4 = (document.layers);
 if (NS4) { document.write('<link rel="stylesheet" href="lmo-style-nc.css" type="text/css">'); }
  else { document.write('<link rel="stylesheet" href="lmo-style.css" type="text/css">'); }
//-->
</script>
<noscript>
<link rel="stylesheet" href="lmo-style.css" type="text/css">
</noscript>
<?php
setlocale(LC_TIME, "de_DE");
$array = array();
$ftype=".l98";
require_once("lmo-cfgload.php");
if(isset($_GET["lmouserlang"])){$_SESSION["lmouserlang"]=$_GET["lmouserlang"];}
if(isset($_SESSION["lmouserlang"])){$lmouserlang=$_SESSION["lmouserlang"];}else{$lmouserlang=$deflang;}
require_once("lmo-langload.php");
require_once("lmo-archiv.php");

if(!isset($_REQUEST["action"])){$_REQUEST["action"]="";$action="";}
if(!isset($_REQUEST["file"])){$_REQUEST["file"]="";$file="";}
if(!isset($_REQUEST["archiv"])){$_REQUEST["archiv"]="";$archiv="";}

if($_REQUEST["action"]=="admin"){$_REQUEST["action"]="";$action="";}

include("lmo-showmain.php");
/*
if($_REQUEST["action"]==""){
  if($_REQUEST["file"]=="" || !file_exists($_REQUEST["file"])){
    if(isset($_REQUEST["archiv"])){
      if($_REQUEST["archiv"]=="dir"){
        AuswahlArchiv();
      }else
        {WechselLigaVerzeichnis();}
    }else{
      AuswahlLiga();
    }
  }else{
    require("lmo-openfile.php");
    if($onrun==0){$action="results";}else{$action="table";}
    require("lmo-showmain.php");
  }
}
elseif ($_REQUEST["action"] == "tipp")
{
  define('LMO_TIPPAUTH', 1);
  require("lmo-tippstart.php");
}
else
{
  if(!isset($_REQUEST["file"]) || $_REQUEST["file"]=="")
    {AuswahlLiga();}
  else
  {
    require("lmo-openfile.php");
    require("lmo-showmain.php");
  }
}*/
?>