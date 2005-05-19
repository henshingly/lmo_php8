<?PHP
//
// Limporter Version 0.1
// Copyright (C) 2003 by Tim Schumacher
// timme@uni.de /
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

require_once(dirname(__FILE__).'/../../init.php');
require_once(PATH_TO_ADDONDIR.'/limporter/ini.php');
require_once(PATH_TO_ADDONDIR."/limporter/lim-functions.php");
?>
<html>
<head>
<title>LIM CSV-Importer</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<?php 
echo "<link rel='stylesheet' type='text/css' href='".URL_TO_ADDONDIR."/limporter/css/lim.css'>";
?>
</head>
<body leftmargin="1" topmargin="1" class="csvtablebody">
<?PHP
if( isset($HTTP_GET_VARS)) {
  	reset ($HTTP_GET_VARS);
  $colums=$lim_colums;//array();
  foreach ($HTTP_GET_VARS as $k=>$elem) {
    if(!(strpos($k,"c_",0)===false)) {
      $showColum[]=$elem;
      $key = substr($k,2);
      $values=split('_',$elem);
      $colums[$key][0] = $values[0];
      $colums[$key][1] = $values[1];
      $formats[] = null;
    }
	}
	$t = 0;
	foreach ($colums as $colum) {
		$formats[$t] = $colum[1];
		$t++;
	}
}
//foreach ($formats as $value) echo "<BR>value: ".$value;
//foreach ($colums as $colum) echo " <BR>$colum[0] $colum[1]";
if(!isset($all)){$all=0;}
if(!isset($hd)){$hd=0;}
if(!isset($ch)){$ch=";";}
if(!isset($pv)){$pv="0";}
//if(!isset($dr) or ($dr < 1) ){$dr=10;}
if(!isset($xlrow) or $xlrow<1){$xlrow=-1;}
$lrow = $xlrow;
if(!isset($xoffset) or $xoffset<1){$xoffset=1;}
$offset = $xoffset - 1;
$rows = array();
$row = 0;
$num = 0;
$col = 0;

if(isset($file) and ($pv==1)){
	$handle = fopen ($file,"r");
	while ($data = fgetcsv ($handle, 1000, $ch) and (count($rows)<$lrow-1+$hd+$offset or $lrow == -1 )) {
		if ($row >= $offset) {
		   	$rows[] = $data;
		    $num = count ($data);
			if ($num>$col) $col = $num;
		}
		$row++;
	}
	fclose ($handle);
	for ($x=0;$x < count($rows);$x++) {
    $tmp = $rows[$x];
    $rows[$x] = array_pad($tmp,$col,"");
	}

	include(PATH_TO_ADDONDIR."/limporter/lim-preview_table.php");

} // isset($file)
else {
	include(PATH_TO_ADDONDIR."/limporter/lim-preview_howto.php");
}
?>
</body>
</html>