<card id="help" title="Hilfe">
  <p>
    <small><?
for($j=0;$j<$anzteams;$j++){
	$j1=$j+1;
  $teamk[$j1]=($teamk[$j1]);	
	$teams[$j1]=($teams[$j1]);
	  ?><b><?=$teamk[$j1]?></b>=<?=$teams[$j1]?><br/>---<br/><?
}?> </small>
  </p>
  <p><a href='<?=$_SERVER['PHP_SELF']."?wap_file=$file"?>&amp;op=nav'>zurück</a></p>
</card>