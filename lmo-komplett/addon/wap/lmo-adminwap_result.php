<card id="day" title="<?=$st?>. Spieltag"><?
//Anzeige Spieltag
if ($file!="") {
  $st_next=$st+1;
  $st_before=$st-1;?>
  <p><?
  for ($i=0; $i<$anzsp; $i++) {
    if (($teama[$st-1][$i]>0) && ($teamb[$st-1][$i]>0)) {
      if (($favteam>0) && ($favteam==$teama[$st-1][$i])) {
        echo "<b>";
      }
      $teamname=$teamk[$teama[$st-1][$i]];
      $teamname=($teamname);
      echo $teamname;
      if (($favteam>0) && ($favteam==$teama[$st-1][$i])) {
        echo "</b>";
      }
      
      echo "-";
      
      if (($favteam>0) && ($favteam==$teamb[$st-1][$i])) {
        echo "<b>";
      }
      $teamname=$teamk[$teamb[$st-1][$i]];
      $teamname=($teamname);
      echo $teamname;
      if (($favteam>0) && ($favteam==$teamb[$st-1][$i])) {
        echo "</b>";
      }
      
      $heim_tore=$goala[$st-1][$i];
      $gast_tore=$goalb[$st-1][$i];
      
      if (($heim_tore=="_" || $heim_tore==-1) && ($gast_tore=="_" || $gast_tore==-1)) {
        $heim_tore='';
        $gast_tore='';
      }?>
      <input type="text" size="2" name="anzheim<?=$i; ?>" maxlength="2" value="<?=$heim_tore?>"/>:<input type="text" size="2" name="anzgast<?=$i; ?>" maxlength="2" value="<?=$gast_tore?>"/></p><p><?
    }
  }?>
    </p>
    <p align="center"><?
  if($st>1){?>
    <a href="<?=$_SERVER['PHP_SELF']?>?wap_file=<?=$file?>&amp;op=day&amp;st=<?=$st_before?>">«</a>&#160;|<?
  }?>
    <anchor>Speichern
	    <go href="<?=$_SERVER['PHP_SELF']?>" method="post"><?
  for($i=0;$i<$anzsp;$i++){ 
    if(($teama[$st-1][$i]>0) && ($teamb[$st-1][$i]>0)){?>
				<postfield name="st" value="<?=$st?>"/>
        <postfield name="op" value="save"/>
        <postfield name="wap_file" value="<?=$file?>"/>
        <postfield name="heim<?=$i?>" value="$(anzheim<?=$i?>)"/>
				<postfield name="gast<?=$i?>" value="$(anzgast<?=$i?>)"/>
        <postfield name="<?=session_name();?>" value="<?=session_id(); ?>"/><?
	  }
  }?>	</go> 
    </anchor><?
  if($st<$anzst){?>
    |&#160;<a href="<?=$_SERVER['PHP_SELF']?>?wap_file=<?=$file?>&amp;op=day&amp;st=<?=$st_next?>">»</a>&#160;<?
  }?>
  </p>
  <p><a href="<?=$_SERVER['PHP_SELF']."?wap_file=$file";?>&amp;op=table&amp;st=<?=$st?>"><?=$text[16];?></a> | <a href="<?=$_SERVER['PHP_SELF']."?wap_file=$file";?>&amp;op=help&amp;st=<?=$st; ?>"><?=$text[20];?></a></p><?
}?>
  <p><small><a href="<?=$_SERVER['PHP_SELF']?>">Home</a></small></p>
</card>