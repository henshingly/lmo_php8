<?php
/** Liga Manager Online 4
  *
  * http://lmo.sourceforge.net/
  *
  * This program is free software; you can redistribute it and/or
  * modify it under the terms of the GNU General Public License as
  * published by the Free Software Foundation; either version 2 of
  * the License, or (at your option) any later version.
  * 
  * This program is distributed in the hope that it will be useful,
  * but WITHOUT ANY WARRANTY; without even the implied warranty of
  * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
  * General Public License for more details.
  *
  * REMOVING OR CHANGING THE COPYRIGHT NOTICES IS NOT ALLOWED!
  *
  */
  
  
if($file!=""){
  $show_stat1=isset($_GET['stat1'])?$_GET['stat1']:$stat1;
  $show_stat2=isset($_GET['stat2'])?$_GET['stat2']:$stat2;
  if ($show_stat1==0 && $show_stat2!=0) {
    $show_stat1=$show_stat2;
    $show_stat2=0;
  }
  $adds=$_SERVER['PHP_SELF']."?action=stats&amp;file=".$file."&amp;stat1=";
  $addr=$_SERVER['PHP_SELF']."?action=results&amp;file=".$file."&amp;st=";
?>

<script type="text/javascript">
/* <![CDATA[ */
$(function() {
	/** This code runs when everything has been loaded on the page */
	/* Inline sparklines take their values from the contents of the tag */
	 /* Use 'html' instead of an array of values to pass options to a sparkline with data in the tag */
	$('.tristate').sparkline('html', {type: 'tristate',posBarColor:'#0C0',zeroBarColor:'#999',negBarColor:'#f44'} );
	//$('.pie').sparkline('html', {type: 'pie',sliceColors:['#0C0','#999','#f44']} );
});
/* ]]> */
</script>

<div class="container">
  <div class="row">
    <div class="col">&nbsp;</div>
  </div>
  <div class="row">
    <div class="col-1 text-right">
      <?php
  for($i=1;$i<=$anzteams;$i++){
    if($i!=$show_stat1){?>
            <p><a href="<?php echo $adds.$i?>&amp;stat2=<?php echo $show_stat2?>" title="<?php echo $text[57]." ".$teams[$i]?>"><?php echo $teamk[$i]." ".HTML_smallTeamIcon($file,$teams[$i]," style='vertical-align: middle;'"); ?></a></p><?php
    } else {
      echo "<p>".$teamk[$i]." ".HTML_smallTeamIcon($file,$teams[$i])."</p>";
    }
  }?>
    </div>
    <div class="col-10">
      <div class="container"><?php
  if($show_stat1==0){?>
        <div class="row">
          <div class="col text-center"><br/><?php echo $text[24]?></div>
        </div><?php
  } else {
    $endtab = $anzst;
    require(PATH_TO_LMO."/lmo-calctable.php");
    $platz0 = array("");
    $platz0 = array_pad($array, $anzteams+1, "");
    for($x = 0; $x < $anzteams; $x++) {
      $platz0[intval(substr($tab0[$x], 34))] = $x+1;
    }?>
        <div class="row">
          <div class="col-3 offset-2 text-right"><strong><?php echo $teams[$show_stat1];?></strong></div>
          <div class="col-4 text-center"><?php
       echo HTML_smallTeamIcon($file,$teams[$show_stat1]," style='vertical-align: middle;'")."&nbsp;";
      if($show_stat2>0 && $show_stat1!=$show_stat2){
        echo "&nbsp;".HTML_smallTeamIcon($file,$teams[$show_stat2]," style='vertical-align: middle;'");
      }?>
          </div><?php 
      if($show_stat2>0 && $show_stat1!=$show_stat2){ ?>
          <div class="col-3"><strong><?php echo $teams[$show_stat2];?></strong></div><?php 
      }?>
        </div>
<?php
  $serie1="&nbsp;";
  if ($ser1[$show_stat1]>0) {
    $serie1=$ser1[$show_stat1]." ".$text[474]."<br>".$ser2[$show_stat1]." ".$text[75];
  } elseif ($ser3[$show_stat1]>0) {
    $serie1=$ser3[$show_stat1]." ".$text[475]."<br>".$ser4[$show_stat1]." ".$text[76];
  } elseif ($ser2[$show_stat1]>=$ser4[$show_stat1]) {
    $serie1=$ser2[$show_stat1]." ".$text[75];
  } else {
    $serie1=$ser4[$show_stat1]." ".$text[76];
  }
  if ($show_stat2>0 && $show_stat1!=$show_stat2) {
    $chg1="k.A.";
    $chg2="k.A.";
    if (!empty($spiele[$show_stat1])&&!empty($spiele[$show_stat2])) {
      $ax=(100*$siege[$show_stat1]/$spiele[$show_stat1])+(100*$nieder[$show_stat2]/$spiele[$show_stat2]);
      $bx=(100*$siege[$show_stat2]/$spiele[$show_stat2])+(100*$nieder[$show_stat1]/$spiele[$show_stat1]);
      $cx=($etore[$show_stat1]/$spiele[$show_stat1])+($atore[$show_stat2]/$spiele[$show_stat2]);
      $dx=($etore[$show_stat2]/$spiele[$show_stat2])+($atore[$show_stat1]/$spiele[$show_stat1]);
      $ex=$ax+$bx;
      $fx=$cx+$dx;
    }
    if (isset($ex) && ($ex>0) && isset($fx) &&($fx>0)) {
      $ax=round(10000*$ax/$ex);
      $bx=round(10000*$bx/$ex);
      $cx=round(10000*$cx/$fx);
      $dx=round(10000*$dx/$fx);
      $chg1=number_format((($ax+$cx)/200),2,",",".")."%";
      $chg2=number_format((($bx+$dx)/200),2,",",".")."%";
    }
    $serie2="&nbsp;";
    if ($ser1[$show_stat2]>0) {
      $serie2=$ser1[$show_stat2]." ".$text[474]."<br>".$ser2[$show_stat2]." ".$text[75];
    } else if ($ser3[$show_stat2]>0) {
      $serie2=$ser3[$show_stat2]." ".$text[475]."<br>".$ser4[$show_stat2]." ".$text[76];
    } else if ($ser2[$show_stat2]>=$ser4[$show_stat2]) {
      $serie2=$ser2[$show_stat2]." ".$text[75];
    } else {
      $serie2=$ser4[$show_stat2]." ".$text[76];
    }
  

?>
        <div class="row">
          <div class="col-3 offset-2 text-right"><?php echo  $chg1; ?></div>
          <div class="col-4 text-center"><strong><?php echo  $text[60]; ?></strong></div>
          <div class="col-3"><?php echo  $chg2; ?></div>
        </div>
<?php } ?>
        <div class="row">
          <div class="col-3 offset-2 text-right"><?php echo $platz0[$show_stat1];?></div>
          <div class="col-4 text-center"><strong><?php echo $text[61];?></strong></div>
          <?php if($show_stat2>0 && $show_stat1!=$show_stat2){ ?><div class="col-3"><?php echo $platz0[$show_stat2];?></div><?php } ?>
        </div>
        <div class="row">
          <div class="col-3 offset-2 text-right"><?php echo applyFactor($punkte[$show_stat1],$pointsfaktor); if($minus==2){":".applyFactor($negativ[$show_stat1],$pointsfaktor);} ?></div>
          <div class="col-4 text-center"><strong><?php echo  $text[37]; ?></strong></div>
          <?php if($show_stat2>0 && $show_stat1!=$show_stat2){ ?><div class="col-3"><?php echo applyFactor($punkte[$show_stat2],$pointsfaktor); if($minus==2){":".applyFactor($negativ[$show_stat2],$pointsfaktor);} ?></div><?php } ?>
        </div>
        <div class="row">
          <div class="col-3 offset-2 text-right"><?php echo $spiele[$show_stat1];?></div>
          <div class="col-4 text-center"><strong><?php echo  $text[63]; ?></strong></div>
          <?php if($show_stat2>0 && $show_stat1!=$show_stat2){ ?><div class="col-3"><?php echo $spiele[$show_stat2];?></div><?php } ?>
        </div>
        <div class="row">
          <div class="col-3 offset-2 text-right"><?php if($spiele[$show_stat1]){echo applyFactor(number_format($punkte[$show_stat1]/$spiele[$show_stat1],2),$pointsfaktor); if($minus==2){":".applyFactor(number_format($negativ[$show_stat1]/$spiele[$show_stat1],2),$pointsfaktor);}} ?></div>
          <div class="col-4 text-center"><strong><?php echo  $text[37].$text[64]; ?></strong></div>
          <?php if($show_stat2>0 && $show_stat1!=$show_stat2){if($spiele[$show_stat2]){ ?><div class="col-3"><?php echo applyFactor(number_format($punkte[$show_stat2]/$spiele[$show_stat2],2),$pointsfaktor); if($minus==2){":".applyFactor(number_format($negativ[$show_stat2]/$spiele[$show_stat2],2),$pointsfaktor);} ?></div><?php }} ?>
        </div>
        <div class="row">
          <div class="col-3 offset-2 text-right"><?php echo  applyFactor($etore[$show_stat1],$goalfaktor).":".applyFactor($atore[$show_stat1],$goalfaktor); ?></div>
          <div class="col-4 text-center"><strong><?php echo  $text[38]; ?></strong></div>
          <?php if($show_stat2>0 && $show_stat1!=$show_stat2){ ?><div class="col-3"><?php echo  applyFactor($etore[$show_stat2],$goalfaktor).":".applyFactor($atore[$show_stat2],$goalfaktor); ?></div><?php } ?>
        </div>
        <div class="row">
          <div class="col-3 offset-2 text-right"><?php if($spiele[$show_stat1]){ echo number_format(applyFactor($etore[$show_stat1],$goalfaktor)/$spiele[$show_stat1],2).":".number_format(applyFactor($atore[$show_stat1],$goalfaktor)/$spiele[$show_stat1],2);} ?></div>
          <div class="col-4 text-center"><strong><?php echo  $text[38].$text[64]; ?></strong></div>
          <?php if($show_stat2>0 && $show_stat1!=$show_stat2){ ?><div class="col-3"><?php if($spiele[$show_stat2]){ echo number_format(applyFactor($etore[$show_stat2],$goalfaktor)/$spiele[$show_stat2],2).":".number_format(applyFactor($atore[$show_stat2],$goalfaktor)/$spiele[$show_stat2],2);} ?></div><?php } ?>
        </div>
        <div class="row">
          <div class="col-3 offset-2 text-right"><?php if($spiele[$show_stat1]){echo $siege[$show_stat1]." (".number_format($siege[$show_stat1]*100/$spiele[$show_stat1],2,",",".")."%)";} ?></div>
          <div class="col-4 text-center"><strong><?php echo  $text[67]; ?></strong></div>
          <?php if($show_stat2>0 && $show_stat1!=$show_stat2){ ?><div class="col-3"><?php if($spiele[$show_stat2]){echo $siege[$show_stat2]." (".number_format($siege[$show_stat2]*100/$spiele[$show_stat2],2,",",".")."%)";} ?></div><?php } ?>
        </div>
        <div class="row">
          <div class="col-3 offset-2 text-right"><?php echo  $maxs0[$show_stat1]; ?></div>
          <div class="col-4 text-center"><strong><?php echo  $text[68]; ?></strong></div>
          <?php if($show_stat2>0 && $show_stat1!=$show_stat2){ ?><div class="col-3"><?php echo  $maxs0[$show_stat2] ?></div><?php } ?>
        </div>
        <div class="row">
          <div class="col-3 offset-2 text-right"><?php if($spiele[$show_stat1]){echo $nieder[$show_stat1]." (".number_format($nieder[$show_stat1]*100/$spiele[$show_stat1],2,",",".")."%)";} ?></div>
          <div class="col-4 text-center"><strong><?php echo  $text[69]; ?></strong></div>
          <?php if($show_stat2>0 && $show_stat1!=$show_stat2){ ?><div class="col-3"><?php if($spiele[$show_stat2]){echo $nieder[$show_stat2]." (".number_format($nieder[$show_stat2]*100/$spiele[$show_stat2],2,",",".")."%)";} ?></div><?php } ?>
        </div>
        <div class="row">
          <div class="col-3 offset-2 text-right"><?php echo  $maxn0[$show_stat1]; ?></div>
          <div class="col-4 text-center"><strong><?php echo  $text[70]; ?></strong></div>
          <?php if($show_stat2>0 && $show_stat1!=$show_stat2){ ?><div class="col-3"><?php echo  $maxn0[$show_stat2]; ?></div><?php } ?>
        </div>
        <div class="row">
          <div class="col-3 offset-2 text-right"><?php echo  $serie1; ?></div>
          <div class="col-4 text-center"><strong><?php echo  $text[71]; ?></strong></div>
          <?php if($show_stat2>0 && $show_stat1!=$show_stat2){ ?><div class="col-3"><?php echo  $serie2; ?></div><?php } ?>
        </div>
      </div>
    </div>
    <div class="col-1">
      <?php
  for($i=1;$i<=$anzteams;$i++){
    if($i!=$show_stat2){
               ?><p><a href="<?php echo $adds.$show_stat1?>&amp;stat2=<?php echo $i?>" title="<?php echo $text[58]." ".$teams[$i]?>"><?php echo HTML_smallTeamIcon($file,$teams[$i])." ".$teamk[$i]?></a></p><?php
    } else {
      echo "<p>".HTML_smallTeamIcon($file,$teams[$i])." ".$teamk[$i]."</p>";
    }
  }?>
    </div>
  </div>
</div><?php
  if ($einzustats == 1) {
    $strs = ".l98";
    $stre = ".l98.php";
    $str = basename($file);
    $file16 = str_replace($strs, $stre, $str);
    $temp11 = basename($diroutput);
    if (file_exists(PATH_TO_LMO."/$temp11/$file16")) {
      require(PATH_TO_LMO."/$temp11/$file16");?>
<div class="container">
  <div class="row">
    <div class="col text-center"><h2><?php echo $text[4009]?></h2></div>
  </div>
  <div class="row">
    <div class="col-3"><strong><?php echo $text[63]?></strong></div>
    <div class="col-2"><?php echo $text[516]?></div>
	<div class="col-2"><?php echo $text[4006]?></div>
	<div class="col-2"><?php echo $text[4008]?></div>
	<div class="col-2"><?php echo $text[4007]?></div>
  </div>
  <div class="row">
    <div class="col-3">&nbsp;</div>
	<div class="col-2"><strong><?php echo $ggesamt=$gzusieg1+$gzusieg2+$gzuunent+$gbeide;?></strong></div>
	<div class="col-2"><strong><?php echo $gzusieg1?></strong><?php if ($ggesamt>0) {$v=round($gzusieg1/$ggesamt*100);echo " ($v%)";}?></div>
	<div class="col-2"><strong><?php echo $gzuunent?></strong><?php if ($ggesamt>0) {$v=round($gzuunent/$ggesamt*100);echo " ($v%)";}?></div>
	<div class="col-2"><strong><?php echo $gzusieg2?></strong><?php if ($ggesamt>0) {$v=round($gzusieg2/$ggesamt*100);echo " ($v%)";}?></div>
  </div>
    <?php
    if ($gbeide>0) {?>
   <div class="row">
     <div class="col-3"><?php echo $text[4012]?></div>
     <div class="col-2 offset-4"><strong><?php echo $gbeide?></strong><?php if ($ggesamt>0) {$v=round($gbeide/$ggesamt*100);echo " ($v%)";}?></div>
   </div><?php
    }?>
   <div class="row">
     <div class="col">&nbsp;</div>
   </div>
   <div class="row">
     <div class="col-3"><strong><?php echo $text[38]?></strong></div>
     <div class="col-2"><?php echo $text[516]?></div>
     <div class="col-4"><?php echo $text[41]."-".$text[38]?></div>
     <div class="col-3"><?php echo $text[42]."-".$text[38]?></div>
   </div>
   <div class="row">
     <div class="col-3">&nbsp;</div>
     <div class="col-2"><strong><?php echo applyFactor($gzutore,$goalfaktor);?></strong>(<?php echo $text[517]?><?php echo applyFactor($gdstore,$goalfaktor)?>)</div>
     <div class="col-4"><strong><?php echo applyFactor($gheimtore,$goalfaktor);?></strong><?php if ($gdstore>0) {$v=round($dsheimtore/$gdstore*100);echo " ($v% ".$text[517].applyFactor($dsheimtore,$goalfaktor).")";}?></div>
     <div class="col-3"><strong><?php echo applyFactor($ggasttore,$goalfaktor);?></strong><?php if ($gdstore>0) {echo " (".(100-$v)."% ".$text[517].applyFactor($dsgasttore,$goalfaktor).")";}?></div>
   </div>
    <?php
    if ($hheimsiegtor>0) {?>
   <div class="row">
     <div class="col">&nbsp;</div>
   </div>
	<div class="row">
     <div class="col-3"><strong><?php echo $text[4013]?></strong></div>
	 <div class="col-6"><?php echo $hheimsieg?> - <?php echo $hgastsieg?></div>
     <div class="col-2"><?php echo applyFactor($hheimsiegtor,$goalfaktor)?>:<?php echo applyFactor($hgastsiegtor,$goalfaktor)?> (<?php echo $spieltagflag?>.<?php echo $text[4014]?>)</div>
   </div><?php
      if ($hheimsiegtor1>0) {?>
   <div class="row">
     <div class="col">&nbsp;</div>
   </div>
   <div class="row">
     <div class="col-6 offset-3"><?php echo $hheimsieg1?> - <?php echo $hgastsieg1?></div>
     <div class="col-2"><?php echo applyFactor($hheimsiegtor1,$goalfaktor)?>:<?php echo applyFactor($hgastsiegtor1,$goalfaktor)?> (<?php echo $spieltagflag1?>.<?php echo $text[4014]?>)</div>
   </div><?php
  	    if ($counteranz>2) {
  	      $counteranz0=$counteranz-2;?>
   <div class="row">
     <div class="col"><small><?php echo $text[4015]?> <?php echo $counteranz0?> <?php echo $text[4016]?></small></div>
   </div><?php
  	    }
      }
    }
    if ($agastsiegtor>0) {?>
   <div class="row">
     <div class="col">&nbsp;</div>
   </div>
	<div class="row">
     <div class="col-3"><strong><?php echo $text[4017]?></strong></div>
     <div class="col-6"><?php echo $aheimsieg?> - <?php echo $agastsieg?></div>
     <div class="col-2"><?php echo applyFactor($aheimsiegtor,$goalfaktor)?>:<?php echo applyFactor($agastsiegtor,$goalfaktor)?> (<?php echo $spieltagflag2?>.<?php echo $text[4014]?>)</div>
   </div>  <?php
      if ($agastsiegtor1>0) {?>
   <div class="row">
     <div class="col">&nbsp;</div>
   </div>
   <div class="row">
     <div class="col-6 offset-3"><?php echo $aheimsieg1?> - </div>
     <div class="col-2"><?php echo applyFactor($aheimsiegtor1,$goalfaktor)?>:<?php echo applyFactor($agastsiegtor1,$goalfaktor)?>  (<?php echo $spieltagflag3?>.<?php echo $text[4014]?>)</div>
   </div><?php
  	    if ($counteranz1>2) {
  	      $counteranz4=$counteranz1-2;?>
   <div class="row">
     <div class="col"><small><?php echo $text[4015]?> <?php echo $counteranz4?> <?php echo $text[4016]?></small></div>
   </div><?php
  	    }
      }
    }
    if ($spieltagflag4>0) {?>
   <div class="row">
     <div class="col-3"><strong><?php echo $text[4018]?> <?php echo $text[38]?></strong></div>
     <div class="col-6"><?php echo $htorreichm1?> - <?php echo $htorreichm2?></div>
     <div class="col-2"><?php echo applyFactor($htorreicht1,$goalfaktor)?>:<?php echo applyFactor($htorreicht2,$goalfaktor)?>  (<?php echo $spieltagflag4?>.<?php echo $text[4014]?>)</div>
   </div><?php
      if ($spieltagflag5>0) {?>
   <div class="row">
     <div class="col-6 offset-3"><?php echo $htorreichm3?> - <?php echo $htorreichm4?></div>
     <div class="col-2"><?php echo applyFactor($htorreicht3,$goalfaktor)?>:<?php echo applyFactor($htorreicht4,$goalfaktor)?>  (<?php echo $spieltagflag5?>.<?php echo $text[4014]?>)</div>
   </div><?php
  	    if ($counteranz5>2) {
  	      $counteranz6=$counteranz5-2;?>
   <div class="row">
     <div class="col"><small><?php echo $text[4015]?> <?php echo $counteranz6?> <?php echo $text[4019]?></small></div>
   </div><?php
      	}
      }
    }
    if (isset($akt_gewonnen)) {?>
   <div class="row">
     <div class="col"><strong><?php echo $text[574]?></strong></div>
   </div>
   <div class="row">
     <div class="col-2">&nbsp;</div>
	 <div class="col-4 text-center"><strong><?php echo $text[580]?></strong></div>
	 <div class="col-4 text-center"><strong><?php echo $text[581]?></strong></div>
   </div>
   <div class="row">
     <div class="col-2"><strong><?php echo $text[575]?></strong></div>
	 <div class="col-1 text-right"><strong><?php echo $akt_gewonnen?></strong></div>
	 <div class="col-3"><?php echo nl2br($team_akt_gewonnen)?></div>
	 <div class="col-1 text-right"><strong><?php echo $max_gewonnen?></strong></div>
	 <div class="col-4"><?php echo nl2br($team_max_gewonnen)?></div>
   </div>  
   <div class="row">
     <div class="col-2"><strong><?php echo $text[576]?></strong></div>
	 <div class="col-1 text-right"><strong><?php echo $akt_ungeschlagen?></strong></div>
	 <div class="col-3"><?php echo nl2br($team_akt_ungeschlagen)?></div>
	 <div class="col-1 text-right"><strong><?php echo $max_ungeschlagen?></strong></div>
	 <div class="col-4"><?php echo nl2br($team_max_ungeschlagen)?></div>
   </div>
   <div class="row">
     <div class="col-2"><strong><?php echo $text[577]?></strong></div>
	 <div class="col-1 text-right"><strong><?php echo $akt_unentschieden?></strong></div>
	 <div class="col-3"><?php echo nl2br($team_akt_unentschieden)?></div>
	 <div class="col-1 text-right"><strong><?php echo $max_unentschieden?></strong></div>
	 <div class="col-4"><?php echo nl2br($team_max_unentschieden)?></div>
   </div>
   <div class="row">
     <div class="col-2"><strong><?php echo $text[578]?></strong></div>
	 <div class="col-1 text-right"><strong><?php echo $akt_sieglos?></strong></div>
	 <div class="col-3"><?php echo nl2br($team_akt_sieglos)?></div>
	 <div class="col-1 text-right"><strong><?php echo $max_sieglos?></strong></div>
	 <div class="col-4"><?php echo nl2br($team_max_sieglos)?></div>
   </div>
   <div class="row">
     <div class="col-2"><strong><?php echo $text[579]?></strong></div>
	 <div class="col-1 text-right"><strong><?php echo $akt_verloren?></strong></div>
	 <div class="col-3"><?php echo nl2br($team_akt_verloren)?></div>
	 <div class="col-1 text-right"><strong><?php echo $max_verloren?></strong></div>
	 <div class="col-4"><?php echo nl2br($team_max_verloren)?></div>
   </div>
   <?php

    }?>
  </div>
<?php
    } //if (file_exists)
  } //if (einzustats = 1)
} // $show_stat1 != 0
?>
 
<?php } ?>