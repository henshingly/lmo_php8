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
if($ftype!=""){
  if(!isset($iptype)){$iptype="";}
  if(!isset($lmotipperok)){$lmotipperok=0;}
  if(!isset($liga)){$liga="";}
   
  $verz=opendir(substr($dirliga,0,-1));
  $dummy=array("");
  while($files=readdir($verz)){
    if(strtolower(substr($files,-4))==$ftype){array_push($dummy,$files);}
    }
  closedir($verz);
  array_shift($dummy);
  sort($dummy);
  $tt0="";
  $tt1="";
  $i=0;
  $j=0;
  if(!isset($lmouserok)){$lmouserok=0;}
  for($k=0;$k<count($dummy);$k++){
    $files=$dummy[$k];
    if($lmouserok!=1){$ftest=1;}
    elseif($lmouserok==1){
      $ftest=0;
      $ftest1 = split("[,]",$lmouserfile);
      if(isset($ftest1)){
        for($u=0;$u<count($ftest1);$u++){
          if($ftest1[$u].".l98"==$files){$ftest=1;}
          }
        }
      }
    if($ftest==1){
      $sekt="";
      $t0="";
      $t1="";
      $t4="";
      $t2=$text[2];
      $datei = fopen($dirliga.$files,"rb");
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
          if($schl=="Rounds"){$anzst=$wert;}
          if($schl=="Type"){
            if($wert=="1"){$t2=$text[370];}
            }
          if(($t0!="") && ($t1!="") && ($t4!=""))break;
          }
        }
      fclose($datei);
      if($t0==""){$j++;$t0="Unbenannte Liga ".$j;}
      if($t2==$text[370]){
        $anzst=strlen(decbin($t4-1));
        }
      
      $ftest=0;
      $ftest1="";
      $ftest1=split("[,]",$ligenzutippen);
      if(isset($ftest1)){
        for($u=0;$u<count($ftest1);$u++){
  
          if($ftest1[$u]==substr($files,0,-4)){$ftest=1;}
          }
        }

      if(($action!="tipp" && $todo!="tipp") || $ftest==1 || $immeralle==1){
        if($todo!="delligen" || (($ftest==1 || $immeralle==1) && file_exists($dirtipp.substr($files,0,-4)."_".$lmotippername.".tip")==true)){
        if($todo!="newligen" || (($ftest==1 || $immeralle==1) && file_exists($dirtipp.substr($files,0,-4)."_".$lmotippername.".tip")==false)){
          if($todo!="newtipper" || $ftest==1 || $immeralle==1){
          if($todo!="tippemail" || $ftest==1 || $immeralle==1){
          if($todo!="tippuseredit" || $ftest==1 || $immeralle==1){
            $i++;
            if($lmotipperok>0 || $action=="admin" || $todo=="newtipper"){
              if($iptype=="reminder"){ ?>
              <tr><td class="lmost5">
                <input type="radio" name="liganr" value="<?PHP echo $i; ?>" id="<?PHP echo $i+3; ?>" <?PHP if(($liga=="" && $i==1) || $liga==$files){echo "checked";} ?> onClick="if(emailart[2].checked==false)changetextarea(1);emailart[2].checked=true;">
                <label for="<?PHP echo $i+3; ?>"><?PHP echo $t0; ?></label></td>
                <input type="hidden" name="liga1[]" value="<?PHP echo $files; ?>">
              <td class="lmost5">
              <select class="lmoadminein" name="st1[]" onChange="if(emailart[2].checked==false)changetextarea(1);emailart[2].checked=true;liganr[<?PHP echo $i-1; ?>].checked=true;">
            <?PHP
              if($liga==$files){
                if($st>0){$t1=$st;}
                }
              echo "<option value=\"0\"";if($t1==0){echo " selected";}echo ">"; // alle Spieltage
              if($t2==$text[2]){echo $text[728];}else{echo $text[729];}
              echo "</option>";
              
              for($y=1;$y<=$anzst;$y++){
                echo "<option value=\"".$y."\"";
                  if($y==$t1){echo " selected";}
                  echo ">";
                  if($t2==$text[2]){
                    echo $y.". ".$text[2];
                    }
                  else{
                    $t5=strlen(decbin($t4-1));
                    if($y==$t5){echo $text[374];}
                    elseif($y==$t5-1){echo $text[373];}
                    elseif($y==$t5-2){echo $text[372];}
                    elseif($y==$t5-3){echo $text[371];}
                    elseif($y==$t5-4){echo $text[370];}
                    else{echo $y.". ".$t2;}
                    }
                  echo "</option>";
                }
            ?>
                </select>
                </td>
                </tr>
<?PHP           }
              if($iptype=="einsicht" || $iptype=="auswert"){
?>
  <tr>
      <td class="lmost5" width="20">&nbsp;</td>
      <td class="lmost5">
<?PHP echo $t0; ?>
</td>
<td class="lmost5" align="right">
  <form name="lmoedit" action="<?PHP echo $PHP_SELF; ?>" method="post">
  <input type="hidden" name="action" value="admin">
  <input type="hidden" name="todo" value="tipp">
  <input type="hidden" name="save" value="<?PHP if($iptype=="einsicht"){echo "3";}else{echo "2";} ?>">
  <input type="hidden" name="liga" value="<?PHP echo substr($files,0,-4); ?>">
  <select class="lmoadminein" name="st">
<?PHP
  if($liga==substr($files,0,-4) && (($save==2 && $iptype=="auswert") || ($save==3 && $iptype=="einsicht"))){
    if($st>=0){$t1=$st;}
    }

  if($iptype=="auswert"){
    echo "<option value=\"0\"";if($t1==0){echo " selected";}echo ">"; // alle Spieltage
    if($t2==$text[2]){echo $text[728];}else{echo $text[729];}
    echo "</option>";
    }

  for($y=1;$y<=$anzst;$y++){
    echo "<option value=\"".$y."\"";if($y==$t1){echo " selected";}echo ">";
    if($t2==$text[2]){ // Spieltage
      echo $y.". ".$text[2];
      }
    else{ // Runden
      $t5=strlen(decbin($t4-1));
      if($y==$t5){echo $text[374];}
      elseif($y==$t5-1){echo $text[373];}
      elseif($y==$t5-2){echo $text[372];}
      elseif($y==$t5-3){echo $text[371];}
      elseif($y==$t5-4){echo $text[370];}
      else{echo $y.". ".$t2;}
      }
    echo "</option>";
    }
?>
    </select>
    <?PHP echo $text[664]; //Tipper
    $start1=1;
    if($liga==substr($files,0,-4) && (($save==2 && $iptype=="auswert") || ($save==3 && $iptype=="einsicht"))){
    	if(isset($start)){$start1=$start;}
    	}
    ?> 
    <input class="lmoadminein" type="text" name="start" size="2" maxlength="4" value="<?PHP echo $start1; ?>">
    <?PHP echo $text[4]; //bis
    $verz1=opendir($dirtipp);
    $dummy1=array("");
    while($tipfiles=readdir($verz1)){
      if(strtolower(substr($tipfiles,0,strlen(substr($files,0,-4))))==strtolower(substr($files,0,-4)) && strtolower(substr($tipfiles,-4))==".tip"){array_push($dummy1,$tipfiles);}
      }
    closedir($verz1);
    array_shift($dummy1);
    $ende1=count($dummy1);
    if($liga==substr($files,0,-4) && (($save==2 && $iptype=="auswert") || ($save==3 && $iptype=="einsicht"))){
    	if(isset($ende)){$ende1=$ende;}
    	}
    ?> 
    <input class="lmoadminein" type="text" name="ende" size="2" maxlength="4" value="<?PHP echo $ende1; ?>">
    <input class="lmoadminbut" type="submit" name="best" value="<?PHP if($iptype=="einsicht"){echo $text[656];}else{echo $text[558];}  ?>">
    </form>
      </td>
     </tr>
<?PHP
         }
       elseif($iptype!="reminder"){
        $checked=0;
        if(($todo=="newtipper" || $todo=="tippuseredit") && $xtipperligen!=""){
          $checked=0;
          foreach($xtipperligen as $key => $value){
            if(substr($files,0,-4)==$value){$checked=1;}
            }
          }
        elseif($todo=="newtipper"){$checked=1;}
?>
<input type="checkbox" name="xtipperligen[]" value="<?PHP echo substr($files,0,-4) ?>"
<?PHP
if(($todo=="newtipper" || $todo=="tippuseredit") && $checked==1){echo "checked";}
elseif($todo=="tippuseredit" && file_exists($dirtipp.substr($files,0,-4)."_".$nick.".tip")==true){echo "checked";}

if($todo=="tippoptions" && ($ftest==1 || $immeralle==1)){echo "checked";}
if($todo=="tippoptions"){echo " onClick=\"dolmoedit()\"";}
if($todo=="tippoptions" && $immeralle==1){echo " disabled";} ?>>
<?PHP echo $t0 ?><br>

<?PHP
                 }
              }
            $tt1.=$dummy[$k]."|";
            $tt0.=$t0."|";
            }
            }
          }
          }
        }
        }
      }
    }
  if($i==0){echo "<li>[".$text[223]."]</li>";}
  }      
?>