<card id="tab" title="Tabelle">
 <p>
<?
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
		echo $datumanz.".&#160;".$text[2];
		$wmloutput="<table title=\"tabelle\" columns=\"4\" align=\"LLCR\">\n<tr><td><b>Pl.</b></td><td><b>Team</b></td><td><b>P+</b></td><td><b>+/-</b></td></tr>\n";
		
		for ($i1=0;$i1<$anzteams;$i1++){
			$platz=$i1+1;
			$i4=(int)substr($table1[$i1],35,6);
			$teamname=$teamk[$i4];
			$teamname=($teamname);
			$pluspunkte=$punkte[$i4];
			$minuspunkte=$negativ[$i4];
			$kegelnholz=applyFactor($dtore[$i4],$goalfaktor);
			$torverhaeltnis=applyFactor($dtore[$i4],$goalfaktor);
			
			
			$wmloutput.="<tr><td>$platz.&#160;</td><td>$teamname&#160;</td><td>$pluspunkte";
			if ($torverhaeltnis>0) $torverhaeltnis = "+".$torverhaeltnis;
			$wmloutput.="</td><td>$torverhaeltnis</td>";
			
			$wmloutput.="</tr>\n";
		}
		$wmloutput.="</table>\n";
		
		echo $wmloutput;

	}
}?>
<br/><a href="<?=$_SERVER['PHP_SELF']."?wap_file=$file";?>&amp;op=day&amp;st=<?=$st?>"><?=$text[10];?></a> | <a href="<?=$_SERVER['PHP_SELF']."?wap_file=$file";?>&amp;op=help&amp;st=<? echo $st; ?>"><?=$text[20];?></a><?
echo("<br/><small><a href='{$_SERVER['PHP_SELF']}'>Home</a></small></p></card>");
?>