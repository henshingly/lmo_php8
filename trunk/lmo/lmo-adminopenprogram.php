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
  
  
require_once(PATH_TO_LMO."/lmo-admintest.php");
if(($xprogram!="") && ($xprogram!="none") && ($xprogram!="random")){
  if(substr($xprogram,-4)==".l98"){
    $daten=array("");
    $sekt="";
    $datei = fopen($xprogram,"rb");
    while (!feof($datei)) {
      $zeile = fgets($datei,1000);
      $zeile=chop($zeile);
      $zeile=trim($zeile);
      if((substr($zeile,0,1)=="[") && (substr($zeile,-1)=="]")){
        $sekt=trim(substr($zeile,1,-1));
        }
      elseif((strpos($zeile,"=")!=false) && (substr($zeile,0,1)!=";")){
        $schl=trim(substr($zeile,0,strpos($zeile,"=")));
        $wert=trim(substr($zeile,strpos($zeile,"=")+1));
        array_push($daten,$sekt."|".$schl."|".$wert."|EOL");
        }
      }
    fclose($datei);
    array_shift($daten);
    for($i=1;$i<=count($daten);$i++){
      $dum=explode('|',$daten[$i-1]);
      if((substr($dum[0],0,5)=="Round") && (substr($dum[1],0,2)=="TA")){$yteama[substr($dum[0],5)-1][substr($dum[1],2)-1]=$dum[2];}
      if((substr($dum[0],0,5)=="Round") && (substr($dum[1],0,2)=="TB")){$yteamb[substr($dum[0],5)-1][substr($dum[1],2)-1]=$dum[2];}
      }
    }
  }
?>