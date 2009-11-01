<card id="day" title="<?php echo $st?>. Spieltag"><?php 
//Anzeige Spieltag
if ($file!="") {
  $st_next=$st+1;
  $st_before=$st-1;?>
  <p><?php 
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
      <input type="text" size="2" name="anzheim<?php echo $i; ?>" maxlength="2" value="<?php echo $heim_tore?>"/>:<input type="text" size="2" name="anzgast<?php echo $i; ?>" maxlength="2" value="<?php echo $gast_tore?>"/></p><p><?php 
    }
  }?>
    </p>
    <p align="center"><?php 
  if($st>1){?>
    <a href="<?php echo $_SERVER['PHP_SELF']?>?wap_file=<?php echo $file?>&amp;op=day&amp;st=<?php echo $st_before?>">«</a>&#160;|<?php 
  }?>
    <anchor>Speichern
	    <go href="<?php echo $_SERVER['PHP_SELF']?>" method="post"><?php 
  for($i=0;$i<$anzsp;$i++){ 
    if(($teama[$st-1][$i]>0) && ($teamb[$st-1][$i]>0)){?>
				<postfield name="st" value="<?php echo $st?>"/>
        <postfield name="op" value="save"/>
        <postfield name="wap_file" value="<?php echo $file?>"/>
        <postfield name="heim<?php echo $i?>" value="$(anzheim<?php echo $i?>)"/>
				<postfield name="gast<?php echo $i?>" value="$(anzgast<?php echo $i?>)"/>
        <postfield name="<?php echo session_name();?>" value="<?php echo session_id(); ?>"/><?php 
	  }
  }?>	</go> 
    </anchor><?php 
  if($st<$anzst){?>
    |&#160;<a href="<?php echo $_SERVER['PHP_SELF']?>?wap_file=<?php echo $file?>&amp;op=day&amp;st=<?php echo $st_next?>">»</a>&#160;<?php 
  }?>
  </p>
  <p><a href="<?php echo $_SERVER['PHP_SELF']."?wap_file=$file";?>&amp;op=table&amp;st=<?php echo $st?>"><?php echo $text[16];?></a> | <a href="<?php echo $_SERVER['PHP_SELF']."?wap_file=$file";?>&amp;op=help&amp;st=<?php echo $st; ?>"><?php echo $text[20];?></a></p><?php 
}?>
  <p><small><a href="<?php echo $_SERVER['PHP_SELF']?>">Home</a></small></p>
</card>