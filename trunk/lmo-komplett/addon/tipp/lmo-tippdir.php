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
  
  
$addi=$_SERVER['PHP_SELF']."?action=tipp&amp;todo=edit&amp;file=";
if ($ftype!="") {
  $verz=opendir(substr(PATH_TO_ADDONDIR."/tipp/".$tipp_dirtipp,0,-1));
  $dummy=array();
  while ($files=readdir($verz)) {
    if (substr($files,-5-strlen($_SESSION['lmotippername']))=="_".$_SESSION['lmotippername'].$ftype) {
      array_push($dummy,$files);
    }
  }
  closedir($verz);
  sort($dummy);
  
  $i=0;
  $j=0;
  $tt0="";
  $tt1="";
  echo"<ul>";
  for ($k=0; $k<count($dummy); $k++) {
    $dummy[$k]=substr($dummy[$k],0,-5-strlen($_SESSION['lmotippername'])).".l98";
    $sekt="";
    $t0="";
    $t1="";
    $t4="";
    $t2=$text[2];
    if (file_exists(PATH_TO_LMO."/".$dirliga.$dummy[$k])) {
      $datei = fopen(PATH_TO_LMO."/".$dirliga.$dummy[$k],"rb");
      if ($datei) {
        while (!feof($datei)) {
          $zeile = fgets($datei,10000);
          $zeile=trim($zeile);
          
          if ((substr($zeile,0,1)=="[") && (substr($zeile,-1)=="]")) {
            $sekt=substr($zeile,1,-1);
          } else if ((strpos($zeile,"=")!=false) && (substr($zeile,0,1)!=";") && ($sekt=="Options")) {
            $schl=substr($zeile,0,strpos($zeile,"="));
            $wert=substr($zeile,strpos($zeile,"=")+1);
            if ($schl=="Name") {
              $t0=$wert;
            }
            if ($schl=="Actual") {
              $t1=$wert;
            }
            if ($schl=="Teams") {
              $t4=$wert;
            }
            if ($schl=="Type") {
              if ($wert=="1") {
                $t2=$text[370];
              }
            }
            if (($t0!="") && ($t1!="") && ($t4!="")) {
              break;
            }
          }
        }
        fclose($datei);
      }
      if ($t0=="") {
        $j++;
        $t0=$text[507].$j;
      }
      if ($t1!="") {
        if ($t2==$text[2]) {
          $t3=" / ".$t1.". ".$t2;
        } else {
          $t5=strlen(decbin($t4-1));
          if ($t1==$t5) {
            $t3=" / ".$text[374];
          } else if ($t1==$t5-1) {
            $t3=" / ".$text[373];
          } else if ($t1==$t5-2) {
            $t3=" / ".$text[372];
          } else if ($t1==$t5-3) {
            $t3=" / ".$text[371];
          } else if ($t1==$t5-4) {
            $t3=" / ".$text[370];
          } else {
            $t3=" / ".$t1.". ".$t2;
          }
        }
      } else {
        $t3="";
      }
      
      $ftest=0;
      $ftest1="";
      $ftest1=explode(',',$tipp_ligenzutippen);
      if (isset($ftest1)) {
        for ($u=0; $u<count($ftest1); $u++) {
          
          if ($ftest1[$u]==substr($dummy[$k],0,-4)) {
            $ftest=1;
          }
        }
      }
      
      if ($ftest==1 || $tipp_immeralle==1) {
        $i++;
        if ($tipp_sttipp!=-1) {
          $tippfile=PATH_TO_ADDONDIR."/tipp/".$tipp_dirtipp.substr($dummy[$k],0,-4)."_".str_replace(" ","_",$_SESSION['lmotippername']).".tip";
          echo "<li><a href='".$addi.$dummy[$k]."'>".$t0."</a>";
          if (file_exists($tippfile)) {
            echo "<br><small>".$text['tipp'][138]." ".strftime($defdateformat,filemtime($tippfile)).$t3."</small>";
          }
          echo "</li>";
        }
        $tt1.=$dummy[$k]."|";
        $tt0.=$t0."|";
        
      }
    }
  }
  if ($i==0) {
    echo "<li>[".$text['tipp'][22]."]</li>";
  } else {
    if ($tipp_viewertipp==1) {
      echo "<li><a href='".$addi."&amp;viewermode=1'><strong>".$text['tipp'][252]." ".$tipp_viewertage." ".$text['tipp'][171]."</strong></a></li>";
    }
  }
  echo"</ul>";
}
$tippfile="";
clearstatcache();
?>