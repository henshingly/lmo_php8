<?php
echo("<card id=\"day\" title=\"$st.Spieltag\">\n");

//Anzeige Spieltag
if($file!=""){?>
  <table colums="2" align="LC"><?
  $st_next=$st+1;
  $st_before=$st-1;

  for($i=0;$i<$anzsp;$i++){ if(($teama[$st-1][$i]>0) && ($teamb[$st-1][$i]>0)){ 
    echo "<tr><td>";
    if(($favteam>0) && ($favteam==$teama[$st-1][$i])){echo "<b>";}
    $teamname=$teamk[$teama[$st-1][$i]];
    $teamname=str_replace("ä","&#xE4;",$teamname);
  	$teamname=str_replace("Ä","&#xC4;",$teamname);
  	$teamname=str_replace("ö","&#xF6;",$teamname);
  	$teamname=str_replace("Ö","&#xD6;",$teamname);
  	$teamname=str_replace("ü","&#xFC;",$teamname);
  	$teamname=str_replace("Ü","&#xDC;",$teamname);
  	$teamname=str_replace("ß","&#xDF;",$teamname);
  	echo $teamname;
    if(($favteam>0) && ($favteam==$teama[$st-1][$i])){echo "</b>";}
  
  	echo "-";
  
    if (($favteam>0) && ($favteam==$teamb[$st-1][$i])){echo "<b>";}
    $teamname=$teamk[$teamb[$st-1][$i]];
    $teamname=str_replace("ä","&#xE4;",$teamname);
  	$teamname=str_replace("Ä","&#xC4;",$teamname);
  	$teamname=str_replace("ö","&#xF6;",$teamname);
  	$teamname=str_replace("Ö","&#xD6;",$teamname);
  	$teamname=str_replace("ü","&#xFC;",$teamname);
  	$teamname=str_replace("Ü","&#xDC;",$teamname);
  	$teamname=str_replace("ß","&#xDF;",$teamname);
  	echo $teamname;
    if (($favteam>0) && ($favteam==$teamb[$st-1][$i])){echo "</b>";}
  	
  	$heim_tore=$goala[$st-1][$i];
  	$gast_tore=$goalb[$st-1][$i];
  	
  	if ($heim_tore=="_" && $gast_tore=="_"){
      echo "</td><td>";?>
  <input type="text" size="1" name="anzheim<?php echo $i; ?>" maxlength="2" value=""/>:<input type="text" size="1" name="anzgast<?php echo $i; ?>" maxlength="2" value=""/><?
    }else{
      echo "</td><td>".$heim_tore.":".$gast_tore;
    } # Ende if ($heim_tore!="_" && $gast_tore!="_")
  echo "</td></tr>";
  }
  
}
echo "</table><p>";
if($st>1){
  		echo "<a href=\"".$_SERVER['PHP_SELF']."?wap_file=$file"."&amp;op=day&amp;st=".$st_before."\">«</a>&nbsp;\n";
	}?>
  <anchor>
	Speichern
	<go href="<?php echo $_SERVER['PHP_SELF']."?wap_file=$file"; ?>&amp;op=save&amp;st=<?php echo $st; ?>" method="post">
		<?php
		for($i=0;$i<$anzsp;$i++)
		{ 
			if(($teama[$st-1][$i]>0) && ($teamb[$st-1][$i]>0))
			{ 
		?>
				<postfield name="heim<?php echo $i; ?>" value="$(anzheim<?php echo $i; ?>)"/>
				<postfield name="gast<?php echo $i; ?>" value="$(anzgast<?php echo $i; ?>)"/>
        <postfield name="<?=session_name();?>" value="<?php echo session_id(); ?>"/>
		<?php
			}
		}
		?>
	</go> 
</anchor><?
  if($st<$anzst){
  	echo "<a href=\"".$_SERVER['PHP_SELF']."?wap_file=$file&amp;op=day&amp;st=".$st_next."\">»</a>\n";
  }
  echo "<br/>";	?>
<br/><a href="<?=$_SERVER['PHP_SELF']."?wap_file=$file";?>&amp;op=table&amp;st=<?=$st?>"><?=$text[16];?></a> | <a href="<?=$_SERVER['PHP_SELF']."?wap_file=$file";?>&amp;op=help&amp;st=<?php echo $st; ?>"><?=$text[20];?></a><?
} 
echo("<br/><a href='{$_SERVER['PHP_SELF']}'><small>Home</small></a>");
// Anzeige Spieltag Ende
?>