<card id="help" title="Hilfe">
  <p>
    <small><?php 
for($j=0;$j<$anzteams;$j++){
	$j1=$j+1;
  $teamk[$j1]=($teamk[$j1]);  	$teams[$j1]=($teams[$j1]);
	  ?><b><?php echo $teamk[$j1]?></b>=<?php echo $teams[$j1]?><br/>---<br/><?php 
}?> </small>
  </p>
  <p><a href='<?php echo $_SERVER['PHP_SELF']."?wap_file=$file"?>&amp;op=nav'>zurück</a></p>
</card>