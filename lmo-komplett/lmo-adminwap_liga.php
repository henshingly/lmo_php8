<?php
echo("<card id=\"index\" title=\"Ligenauswahl\">\n");
echo("<p>\n");

$lmousername=$_SESSION['login'];

$dumma = array("");
$pswfile="./".$lmo_auth_verz."lmo-auth.txt";
$psw1file="./".$lmo_auth_verz."lmo-access.txt";

$datei = fopen($pswfile,"rb");
if (!$datei) die ("<b>Error</b>");
while (!feof($datei)) {
  $zeile = fgets($datei,1000);
  $zeile=chop($zeile);
  if($zeile!=""){array_push($dumma,$zeile);}
}
fclose($datei);
array_shift($dumma);
for($i=0;$i<count($dumma);$i++){
	$dummb = split("[|]",$dumma[$i]);
	//if(($lmousername==$dummb[0]) && ($lmouserpass==$dummb[1])){
	if(($lmousername==$dummb[0])){
		$lmouserok=$dummb[2];
		if($lmouserok==1){
			$datei = fopen($psw1file,"rb");
			if (!$datei) die ("<b>Error</b>");
      while (!feof($datei)) {
				$zeile = fgets($datei,1000);
				$zeile=chop($zeile);
				if($zeile!=""){
					$dummb1 = split("[|]",$zeile);
					if($lmousername==$dummb1[0]){$lmouserfile=$dummb1[1];}
				} # Ende if($zeile!=""){
			} # Ende while (!feof($datei))
			fclose($datei);
			array_shift($dumma);
		} # Ende if($lmouserok==1){
		elseif($lmouserok==2){
			$lmouserfile="";
		}
	} # Ende if(($lmousername==$dummb[0])){
} # Ende for 

if($ftype!=""){
  $verz=opendir(substr($dirliga,0,-1));
  $dummy=array();$dummy2=array();
  $r=0;
  while($files=readdir($verz)){
    if(strtolower(substr($files,-4))==$ftype){
      $dummy2['"'.(filemtime($dirliga.$files)+$r).'"']=$files;
      $r++;
    }
  }
  closedir($verz);
  krsort($dummy2);
  foreach ($dummy2 as $d) $dummy[]=$d;
  $i=0;
  $j=0;
  for($k=0;$k<count($dummy);$k++){
    $files=$dummy[$k];
	 #############
	 if($lmouserok==2){$ftest=1;}
    elseif($lmouserok==1){
      $ftest=0;
      $ftest1 = split("[,]",$lmouserfile);
      if(isset($ftest1)){
        for($u=0;$u<count($ftest1);$u++){
          if($ftest1[$u].$ftype==$files){$ftest=1;}
        }
      }
    }
    if($ftest==1){
    #############
	 $sekt="";
    $t0="";
    $t1="";
    $t4="";
    $t2=$text[2];
    $datei = fopen($dirliga.$files,"rb");
    if (!$datei) die ("<b>Error</b>");
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
    $i++;
    if($t0==""){$j++;$t0="Unbenannte Liga ".$j;}
    if($t1!=""){
      if($t2==$text[2]){
        $t3=" / ".$t1.".".$text[145];
        }
      else{
        $t5=strlen(decbin($t4-1));
        if($t1==$t5-1){$t3=" / ".$text[362];}
		    elseif($t1==$t5){$t3=" / ".$text[364];}
        elseif($t1==$t5-2){$t3=" / ".$text[360];}
        elseif($t1==$t5-3){$t3=" / ".$text[358];}
        elseif($t1==$t5-4){$t3=" / ".$text[376].$t1;}
        else{$t3=" / ".$text[376].$t1;}
        }
      }
    else{$t3="";}
	//Ligenliste laden Ende
	
	$t0=str_replace("ä","&#xE4;",$t0);
	$t0=str_replace("Ä","&#xC4;",$t0);
	$t0=str_replace("ö","&#xF6;",$t0);
	$t0=str_replace("Ö","&#xD6;",$t0);
	$t0=str_replace("ü","&#xFC;",$t0);
	$t0=str_replace("Ü","&#xDC;",$t0);
	$t0=str_replace("ß","&#xDF;",$t0);
	
?>
<small><<?php echo "a href='$addi$dirliga$files&amp;op=nav'>".$t0."</a><br/>".date("d.m.y H:i",filemtime($dirliga.$files)).$t3."</small><br/>\n";  
 }
 }
 if($i==0){echo "".$text[223]."";}
}
?>
<br/>
<a href="<?php echo $home; ?>?op=exit"><small>Logout</small></a>