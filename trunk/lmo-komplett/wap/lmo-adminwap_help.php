<?php
echo("<card id=\"help\" title=\"Hilfe\">\n");
echo("<p><small>");

for($j=0;$j<$anzteams;$j++){
	$j1=$j+1;
  $teamk[$j1]=str_replace("ä","&#xE4;",$teamk[$j1]);
	$teamk[$j1]=str_replace("Ä","&#xC4;",$teamk[$j1]);
	$teamk[$j1]=str_replace("ö","&#xF6;",$teamk[$j1]);
	$teamk[$j1]=str_replace("Ö","&#xD6;",$teamk[$j1]);
	$teamk[$j1]=str_replace("ü","&#xFC;",$teamk[$j1]);
	$teamk[$j1]=str_replace("Ü","&#xDC;",$teamk[$j1]);
	$teamk[$j1]=str_replace("ß","&#xDF;",$teamk[$j1]);
	
	$teams[$j1]=str_replace("ä","&#xE4;",$teams[$j1]);
	$teams[$j1]=str_replace("Ä","&#xC4;",$teams[$j1]);
	$teams[$j1]=str_replace("ö","&#xF6;",$teams[$j1]);
	$teams[$j1]=str_replace("Ö","&#xD6;",$teams[$j1]);
	$teams[$j1]=str_replace("ü","&#xFC;",$teams[$j1]);
	$teams[$j1]=str_replace("Ü","&#xDC;",$teams[$j1]);
	$teams[$j1]=str_replace("ß","&#xDF;",$teams[$j1]);
	echo "<b>".$teamk[$j1]."</b>=<br/>".$teams[$j1]."<br/>---<br/>\n";
}?>
</small><br/><a href='<?=$_SERVER['PHP_SELF']."?wap_file=$file"?>&amp;op=nav'>zurück</a>