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
$addi=$_SERVER["PHP_SELF"]."?file=";


if($GLOBALS["ftype"]!=""){
  $verz=opendir(substr($GLOBALS["dirliga"],0,-1));
  $dummy=array("");

  while($files=readdir($verz)){
    if(strtolower(substr($files,-4))==$GLOBALS["ftype"])
      {array_push($dummy,$files); }
    }
  closedir($verz);
  array_shift($dummy);
  sort($dummy);
  $i=0;
  $j=0;

//  echo"<ul>";

  for($k=0;$k<count($dummy);$k++){
    $files=$dummy[$k];
    $sekt="";
    $t0="";
    $t1="";
    $t4="";
    $t2=$GLOBALS["text"][2];
    $datei = fopen($GLOBALS["dirliga"].$files,"r");
    while (!feof($datei)) {
      $zeile = fgets($datei,1000);
      $zeile=chop($zeile);
      $zeile=trim($zeile);
      if((substr($zeile,0,1)=="[") && (substr($zeile,-1)=="]")){
        $sekt=substr($zeile,1,-1);
        }
      elseif((strpos($zeile,"=")!=false) && (substr($zeile,0,1)!=";") && ($sekt=="Options")){
        $schl=substr($zeile,0,strpos($zeile,"="));
        $wert=substr($zeile,strpos($zeile,"=")+1);
        if($schl=="Name"){$t0=$wert;}
        if($schl=="Actual"){$t1=$wert;}
        if($schl=="Teams"){$t4=$wert;}
        if($schl=="Type"){
          if($wert=="1"){$t2=$GLOBALS["text"][370];}
          }
        if(($t0!="") && ($t1!="") && ($t4!=""))break;
        }
      }
    fclose($datei);
    $i++;
    if($t0==""){$j++;$t0="Unbenannte Liga ".$j;}
    if($t1!=""){
      if($t2==$GLOBALS["text"][2]){
        $t3=" / ".$t1.". ".$t2;
        }
      else{
        $t5=strlen(decbin($t4-1));
        if($t1==$t5-1){$t3=" / ".$GLOBALS["text"][373];}
        elseif($t1==$t5-2){$t3=" / ".$GLOBALS["text"][372];}
        elseif($t1==$t5-3){$t3=" / ".$GLOBALS["text"][371];}
        elseif($t1==$t5-4){$t3=" / ".$GLOBALS["text"][370];}
        else{$t3=" / ".$t1.". ".$t2;}
        }
      }
    else{$t3="";}
    echo "<li><a href=\"".$addi.$GLOBALS["dirliga"].$files."\">".$t0."<br><small>".gmdate("d.m.Y H:i",filectime($GLOBALS["dirliga"].$files)).$t3."</small></a></li>";
    }
  if($i==0){echo "<li>[".$GLOBALS["text"][223]."]</li>";}
  }
?>