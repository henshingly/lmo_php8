<?php
echo("<card id=\"tab\" title=\"Tabelle\">\n");
echo("<p>\n");

if($st>0){$actual=$st;}else{$actual=$stx;}
if($lmtype==0){
	for($i1=0;$i1<$anzsp;$i1++){
		if ($goala[$actual-1][$i1]=="-1") $goala[$actual-1][$i1]="_";
		if ($goalb[$actual-1][$i1]=="-1") $goalb[$actual-1][$i1]="_";
	}
	$endtab=$anzst;
	$action="";
  include(PATH_TO_LMO."/lmo-calctable.php");
	for($i1=0;$i1<$anzsp;$i1++){
		if ($goala[$endtab-1][$i1]=="_") $goala[$endtab-1][$i1]="-1";
		if ($goalb[$endtab-1][$i1]=="_") $goalb[$endtab-1][$i1]="-1";
	}
}
if($lmtype==0){
	isset($tab0) ? $table1=$tab0 : $table1=$tab1;
	if (isset($table1)) {
		
		
		$datumanz=$actual;
		echo $datumanz.".&nbsp;".$text[2];
		$wmloutput="<table title=\"tabelle\" columns=\"4\" align=\"LLCR\">\n<tr><td><b>Pl.</b></td><td><b>Team</b></td><td><b>P+</b></td><td><b>+/-</b></td></tr>\n";
		
		for ($i1=0;$i1<$anzteams;$i1++){
			$platz=$i1+1;
			$i4=(int)substr($table1[$i1],35,6);
			$teamname=$teamk[$i4];
			$teamname=str_replace("ä","&#xE4;",$teamname);
			$teamname=str_replace("Ä","&#xC4;",$teamname);
			$teamname=str_replace("ö","&#xF6;",$teamname);
			$teamname=str_replace("Ö","&#xD6;",$teamname);
			$teamname=str_replace("ü","&#xFC;",$teamname);
			$teamname=str_replace("Ü","&#xDC;",$teamname);
			$teamname=str_replace("ß","&#xDF;",$teamname);
			$pluspunkte=$punkte[$i4];
			$minuspunkte=$negativ[$i4];
			$kegelnholz=$dtore[$i4];
			$torverhaeltnis=$dtore[$i4];
			
			
			$wmloutput.="<tr><td>$platz.&nbsp;</td><td>$teamname&nbsp;</td><td>$pluspunkte";
			if ($torverhaeltnis>0) $torverhaeltnis = "+".$torverhaeltnis;
			$wmloutput.="</td><td>$torverhaeltnis</td>";
			
			$wmloutput.="</tr>\n";
		}
		$wmloutput.="</table>\n";
		
		echo $wmloutput;

	}
}?>
<br/><a href="<?=$_SERVER['PHP_SELF']."?wap_file=$file";?>&amp;op=day&amp;st=<?=$st?>"><?=$text[10];?></a> | <a href="<?=$_SERVER['PHP_SELF']."?wap_file=$file";?>&amp;op=help&amp;st=<?php echo $st; ?>"><?=$text[20];?></a><?
echo("<br/><a href='{$_SERVER['PHP_SELF']}'><small>Home</small></a>");
?>