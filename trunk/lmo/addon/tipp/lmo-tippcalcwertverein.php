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
  
  
if(file_exists($auswertfile)){
  $datei = fopen($auswertfile,"rb");
  $anzteams=0;

  if($datei!=false){
    $tippdaten=array("");
    $sekt="";
    while (!feof($datei)) {
      $zeile = fgets($datei,1000);
      $zeile=chop($zeile);
      $zeile=trim($zeile);
      if((substr($zeile,0,1)=="[") && (substr($zeile,-1)=="]")){
        $sekt=trim(substr($zeile,1,-1));
        array_push($tippdaten,$sekt."|||EOL");
        $anzteams++;
      }elseif((strpos($zeile,"=")!=false) && (substr($zeile,0,1)!=";")){
        $schl=trim(substr($zeile,0,strpos($zeile,"=")));
        $wert=trim(substr($zeile,strpos($zeile,"=")+1));
        array_push($tippdaten,$sekt."|".$schl."|".$wert."|EOL");
      }
    }
    fclose($datei);
  }  
  array_shift($tippdaten);

  if($m==0){
    $team = array_pad($array,$anzteams+1,"0");
    $spielegetippt = array_pad($array,$anzteams+1,"0");
    $tipppunktegesamt = array_pad($array,$anzteams+1,"0");
  
    for($i=1;$i<=$anzteams;$i++){
      $team[$i]=$i;
    }
    if($endtab<1){
      $endtab=$anzst;
    }
  }

  for($i=1;$i<=count($tippdaten);$i++){
    $dum=explode('|',$tippdaten[$i-1]);
    $op1=$dum[0];               // Nick
    $op3=substr($dum[1],2)-1;   // Spieltagsnummer
    $op4=substr($dum[1],0,2);   // TP
    if($op3<$endtab){
      if($op4=="SG"){$spielegetippt[$op1]+=$dum[2];}
      elseif($op4=="TP"){$tipppunktegesamt[$op1]+=$dum[2];}
    }
  }

  if($m==($anztipper-1)){
    $tab0 = array("");
    for($a=1;$a<=$anzteams;$a++){
      if($tipppunktegesamt[$a]==""){$tipppunktegesamt[$a]=0;}
      if($spielegetippt[$a]==""){$spielegetippt[$a]=0;}
      $quote=0;
      if($spielegetippt[$a]!=0){
        if($tipp_tippmodus==1){
          $quote=number_format($tipppunktegesamt[$a]/$spielegetippt[$a],2,".",",");
        }
        if($tipp_tippmodus==0){
          $quote=number_format($tipppunktegesamt[$a]/$spielegetippt[$a]*100,2,".",",");
        }
        $quote*=100;
      }
      array_push($tab0,(50000000+$quote).(50000000+$tipppunktegesamt[$a]).(50000000-$a).(50000000+$a));
    }
    array_shift($tab0);
    rsort($tab0,SORT_STRING);
  }
}else{?>
  <?php echo getMessage($text['tipp'][17],TRUE);?><?
}
?>