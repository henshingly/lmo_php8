<?php

function check_auth ($lmousername, $lmouserpass, $liga)
{
	global $lmo_auth_verz;
	$flag=FALSE;
	$result=FALSE;
	
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
		if(($lmousername==$dummb[0]) && ($lmouserpass==$dummb[1])){
			$lmouserok=$dummb[2];
			if($lmouserok==1){
				$datei = fopen($psw1file,"rb");
				if (!$datei) die ("<b>Error</b>");
        while (!feof($datei)) {
					$zeile = fgets($datei,1000);
					$zeile=chop($zeile);
					if($zeile!=""){
						$dummb1 = split("[|]",$zeile);
						if($lmousername==$dummb1[0]){
							if (!empty($liga))
							{
								$flag=TRUE;
								$lmouserfile=$dummb1[1];
							}
							else
								$result=TRUE;
						}
					} # Ende if($zeile!=""){
         
				 } # Ende while (!feof($datei))
        
				fclose($datei);
				array_shift($dumma);
			} # Ende if($lmouserok==1){
			elseif($lmouserok==2){
				$result=TRUE;
			}
			//$result=TRUE;
		} # Ende if(($lmousername==$dummb[0])){
	} # Ende for 
	
	
	if ($flag)
	{
		$ftest1 = split("[,]",$lmouserfile);
	   if(isset($ftest1)){
	   	for($u=0;$u<count($ftest1);$u++){
	      	if($ftest1[$u]==$liga){
					$result=TRUE;
				}
	      } # for($u=0;$u<count($ftest1);$u++){
	   } # Ende if(isset($ftest1)){
	} # Ende if (!$result)
	return $result;
} # Ende function
?>