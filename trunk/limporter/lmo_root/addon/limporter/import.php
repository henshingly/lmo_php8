<?PHP
//
// Limporter Addon for LigaManager Online
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
  require_once(PATH_TO_ADDONDIR.'/classlib/classes/ini/cIniFileReader.inc');
  $src = isset($_GET['src'])?$_GET['src']:'';
  $d = isset($_GET['d'])?$_GET['d']:0;
  $debug = $d;
  $csvChar =';';
  $spieltagRow = array('TAG'=>NULL,
                   'DATUM'=>NULL,
                   'STNR'=>NULL,
                   'SCHLUESSELTAG'=>NULL);

  
  function findFooter($row,$csvChar,$match='STAFFELSPIELPLAN') {
    $result = FALSE;
    if (ereg($match,$row)) {
      $result = TRUE;
    }
    return $result;
  }
  function findSpieltag($row,$csvChar,$match='Spieltag') {
    $result = FALSE;
    if (ereg($match,$row)) {
      $data = preg_split('/'.$csvChar.'/',$row);
      $stNr = preg_split('/\./',$data[2]);
      $result = array('TAG'=>$data[0],
                   'DATUM'=>$data[1],
                   'STNR'=>$stNr[0],
                   'SCHLUESSELTAG'=>$data[3]);
    }
    return $result;
  }
  function findEmtyRow($row,$csvChar,$match='') {
    $result = FALSE;
    if (preg_replace('/'.$csvChar.'/','',$row)=='') 
      $result = TRUE;
    return $result;
  }
  function findNoDataRow($row,$csvChar,$match='') {
    $result = FALSE;
    if (preg_match('/'.$csvChar.'/',$row)==FALSE) 
      $result = TRUE;
    return $result;
  }        

  $now = time();
  $date = getDate($now);
  $year =$date["year"];
  $lastDate = '01.01.'.$year;
  $i=0;
  $spTag = 0;
  $dat1 = 0;
  $err = FALSE;
  $skip = FALSE;
  if(file_exists(PATH_TO_LMO."/".$dirliga.$src) and $src <> '') {
    $stand= date("d.m.Y H:i",filemtime(PATH_TO_LMO."/".$dirliga.$src));
    $datei = fopen(PATH_TO_LMO."/".$dirliga.$src,"rb");
    $data = array();
    while (!feof($datei)) {
      $zeile = fgets($datei,1000);
      $zeile = chop($zeile);
      $zeile = trim($zeile);
      $zeile = preg_replace("/\s{2,}/",$csvChar,$zeile);
      $data[] = $zeile;
    }
    fclose($datei);
  }
  else {
    $err = TRUE;
  }
  
if ($debug<>0 or $err) {
// text/comma-separated-values
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
          "http://www.w3.org/TR/html4/loose.dtd">
<html lang="de">
<head>
<title>Spielplan Biegemaschine</title>
</head>
<body>
<?PHP
}
if (!$err and $debug==0)
   header("Content-type: text/comma-separated-values");


if ($err) {
  echo "FEHLER: Datei nicht gefunden";
}
else {
   foreach ($data as $row) {
   if($debug<>0) echo "<BR><font color=cccccc>$i:</font>";
   if ($spieltagRow=findSpieltag($row,$csvChar)) {
     if($debug<>0) echo"<font color=ff0000>$row</font>";
    $aktSpielTag = $spieltagRow['STNR'];
    $spDatum =  $spieltagRow['DATUM'];
   }
   elseif (findEmtyRow($row,$csvChar)) {
     if($debug<>0) echo"<font color=cccccc>skip empty row</font>";
     
   }
   elseif (findNoDataRow($row,$csvChar)) {
     if($debug<>0) echo"<font color=cccccc>no&nbsp;datarow:$row</font>";
   }
   elseif (findFooter($row,$csvChar) or $skip) {
     if($debug<>0) echo"<font color=cccccc>skip footer rows:$row</font>";
     $skip = TRUE;
   }
   else { 
    $spDatumString = $spDatum.$year;
    if($lastDate <> 0) {
      $datArray = preg_split('/\./',$spDatumString);
      $dat1 = mktime(0,0,0,(int)$datArray[1],(int)$datArray[0],(int)$datArray[2]);
    }
    if ($dat1 < $lastDate and $lastDate<>0) $year++;
    $lastDate = $dat1;
    echo $aktSpielTag.$csvChar.$spDatum.$year.$csvChar.$row;
    echo"\n";
    }
   $i++;
  }
}
if ($err or $debug<>0) {
?></body></html>
<?PHP
}