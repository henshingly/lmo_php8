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
$addi=$PHP_SELF."?action=tipp&amp;todo=edit&amp;file=";
if($ftype!=""){
  $verz=opendir(substr($dirtipp,0,-1));
  $dummy=array("");
  while($files=readdir($verz)){
    if(substr($files,-5-strlen($lmotippername))=="_".$lmotippername.$ftype){array_push($dummy,$files);}
    }
  closedir($verz);
  array_shift($dummy);
  sort($dummy);
  $i=0;
  $j=0;
  $tt0="";
  $tt1="";
  echo"<ul>";
  for($k=0;$k<count($dummy);$k++){
    $dummy[$k]=substr($dummy[$k],0,-5-strlen($lmotippername)).".l98";
    $sekt="";
    $t0="";
    $t1="";
    $t4="";
    $t2=$text[2];
    if(file_exists($dirliga.$dummy[$k])){
      $datei = fopen($dirliga.$dummy[$k],"rb");
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
            if($wert=="1"){$t2=$text[370];}
            }
          if(($t0!="") && ($t1!="") && ($t4!=""))break;
          }
        }
      fclose($datei);
      if($t0==""){$j++;$t0="Unbenannte Liga ".$j;}
      if($t1!=""){
        if($t2==$text[2]){
          $t3=" / ".$t1.". ".$t2;
          }
        else{
          $t5=strlen(decbin($t4-1));
          if($t1==$t5){$t3=" / ".$text[374];}
          elseif($t1==$t5-1){$t3=" / ".$text[373];}
          elseif($t1==$t5-2){$t3=" / ".$text[372];}
          elseif($t1==$t5-3){$t3=" / ".$text[371];}
          elseif($t1==$t5-4){$t3=" / ".$text[370];}
          else{$t3=" / ".$t1.". ".$t2;}
          }
        }
      else{$t3="";}
  
      $ftest=0;
      $ftest1="";
      $ftest1=split("[,]",$ligenzutippen);
      if(isset($ftest1)){
        for($u=0;$u<count($ftest1);$u++){
  
          if($ftest1[$u]==substr($dummy[$k],0,-4)){$ftest=1;}
          }
        }
  
      if($ftest==1 || $immeralle==1){
        $i++;
        if($sttipp!=-1){
          $tippfile=$dirtipp.substr($dummy[$k],0,-4)."_".str_replace(" ","_",$lmotippername).".tip";
          echo "<li><a href=\"".$addi.$dirliga.$dummy[$k]."&amp;PHPSESSID=".$PHPSESSID."\">".$t0;if(file_exists($tippfile)){echo "<br><small>".$text[2138]." ".date("d.m.Y H:i",filectime($tippfile)).$t3."</small>";} echo "</a></li>";
          }
        $tt1.=$dummy[$k]."|";
        $tt0.=$t0."|";
        
        }
      }
    }
  if($i==0){echo "<li>[".$text[2022]."]</li>";}
  else{
    if($viewertipp==1){
      echo "<li><a href=\"".$addi."viewer&amp;PHPSESSID=".$PHPSESSID."\"><b>".$text[2252]." ".$viewertage." ".$text[2171]."</b></a></li>";
      }
    }
  echo"</ul>";
  }
  $tippfile="";
  clearstatcache();
?>