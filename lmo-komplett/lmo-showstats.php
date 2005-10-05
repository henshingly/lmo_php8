<?
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

<table class="lmoMiddle" cellspacing="0" cellpadding="0" border="0">
  <tr>
    <td valign="top" align="center">
      <table class="lmoMenu" cellspacing="0" cellpadding="0" border="0"><?
  for($i=1;$i<=$anzteams;$i++){?>
        <tr>
          <td align="right">
            <acronym title="<?=$text[57]." ".$teams[$i]?>"><?
    if($i!=$show_stat1){?>
            <a href="<?=$adds.$i?>&amp;stat2=<?=$show_stat2?>"><?=$teamk[$i]?></a><?
    } else {
      echo $teamk[$i];
    }     ?></acronym>
          </td>          
          <td><?=getSmallImage($teams[$i]);?>&nbsp;</td>
        </tr><?
  }?>
      </table>
    </td>
    <td valign="top" align="center">
      <table class="lmoInner" cellspacing="0" cellpadding="0" border="0"><?
  if($show_stat1==0){?>
        <tr>
          <td align="center">&nbsp;<br><?=$text[24]?><br>&nbsp;</td>
        </tr><?
  } else {
    $endtab = $anzst;
    require(PATH_TO_LMO."/lmo-calctable.php");
    $platz0 = array("");
    $platz0 = array_pad($array, $anzteams+1, "");
    for($x = 0; $x < $anzteams; $x++) {
      $platz0[intval(substr($tab0[$x], 34))] = $x+1;
    }?>
        <tr>
          <th align="right"><?=$teams[$show_stat1];?></th>
          <th align="center"><?
      echo getSmallImage($teams[$show_stat1])."&nbsp;";
      if($show_stat2>0 && $show_stat1!=$show_stat2){
        echo "&nbsp;".getSmallImage($teams[$show_stat2]);
      }?>
          </th><? 
      if($show_stat2>0 && $show_stat1!=$show_stat2){ ?>
          <th align="left"><?=$teams[$show_stat2];?></th><? 
      }?>
        </tr>
<?
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
      $chg1=number_format((($ax+$cx)/200),2,",",".");
      $chg2=number_format((($bx+$dx)/200),2,",",".");
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
        <tr>
          <td align="right"><?= $chg1; ?>%</td>
          <th align="center"><?= $text[60]; ?></th>
          <td align="left"><?= $chg2; ?>%</td>
        </tr>
<? } ?>
        <tr>
          <td align="right"><?=$platz0[$show_stat1];?></td>
          <th><?=$text[61];?></th>
          <? if($show_stat2>0 && $show_stat1!=$show_stat2){ ?><td align="left"><?=$platz0[$show_stat2];?></td><? } ?>
        </tr>
        <tr>
          <td align="right"><?=applyFactor($punkte[$show_stat1],$pointsfaktor); if($minus==2){":".applyFactor($negativ[$show_stat1],$pointsfaktor);} ?></td>
          <th><?= $text[37]; ?></th>
          <? if($show_stat2>0 && $show_stat1!=$show_stat2){ ?><td align="left"><?=applyFactor($punkte[$show_stat2],$pointsfaktor); if($minus==2){":".applyFactor($negativ[$show_stat2],$pointsfaktor);} ?></td><? } ?>
        </tr>
        <tr>
          <td align="right"><?=$spiele[$show_stat1];?></td>
          <th><?= $text[63]; ?></th>
          <? if($show_stat2>0 && $show_stat1!=$show_stat2){ ?><td align="left"><?=$spiele[$show_stat2];?></td><? } ?>
        </tr>
        <tr>
          <td align="right"><? if($spiele[$show_stat1]){echo applyFactor(number_format($punkte[$show_stat1]/$spiele[$show_stat1],2),$pointsfaktor); if($minus==2){":".applyFactor(number_format($negativ[$show_stat1]/$spiele[$show_stat1],2),$pointsfaktor);}} ?></td>
          <th><?= $text[37].$text[64]; ?></th>
          <? if($show_stat2>0 && $show_stat1!=$show_stat2){if($spiele[$show_stat2]){ ?><td align="left"><? echo applyFactor(number_format($punkte[$show_stat2]/$spiele[$show_stat2],2),$pointsfaktor); if($minus==2){":".applyFactor(number_format($negativ[$show_stat2]/$spiele[$show_stat2],2),$pointsfaktor);}} ?></td><? } ?>
        </tr>
        <tr>
          <td align="right"><?= applyFactor($etore[$show_stat1],$goalfaktor).":".applyFactor($atore[$show_stat1],$goalfaktor); ?></td>
          <th><?= $text[38]; ?></th>
          <? if($show_stat2>0 && $show_stat1!=$show_stat2){ ?><td align="left"><?= applyFactor($etore[$show_stat2],$goalfaktor).":".applyFactor($atore[$show_stat2],$goalfaktor); ?></td><? } ?>
        </tr>
        <tr>
          <td align="right"><? if($spiele[$show_stat1]){ echo number_format(applyFactor($etore[$show_stat1],$goalfaktor)/$spiele[$show_stat1],2).":".number_format(applyFactor($atore[$show_stat1],$goalfaktor)/$spiele[$show_stat1],2);} ?></td>
          <th><?= $text[38].$text[64]; ?></th>
          <? if($show_stat2>0 && $show_stat1!=$show_stat2){ ?><td align="left"><? if($spiele[$show_stat2]){ echo number_format(applyFactor($etore[$show_stat2],$goalfaktor)/$spiele[$show_stat2],2).":".number_format(applyFactor($atore[$show_stat2],$goalfaktor)/$spiele[$show_stat2],2);} ?></td><? } ?>
        </tr>
        <tr>
          <td align="right"><? if($spiele[$show_stat1]){echo $siege[$show_stat1]." (".number_format($siege[$show_stat1]*100/$spiele[$show_stat1],2,",",".")."%)";} ?></td>
          <th><?= $text[67]; ?></th>
          <? if($show_stat2>0 && $show_stat1!=$show_stat2){ ?><td align="left"><? if($spiele[$show_stat2]){echo $siege[$show_stat2]." (".number_format($siege[$show_stat2]*100/$spiele[$show_stat2],2,",",".")."%)";} ?></td><? } ?>
        </tr>
        <tr>
          <td align="right"><?= $maxs0[$show_stat1]; ?></td>
          <th valign="top"><?= $text[68]; ?></th>
          <? if($show_stat2>0 && $show_stat1!=$show_stat2){ ?><td align="left"><?= $maxs0[$show_stat2] ?></td><? } ?>
        </tr>
        <tr>
          <td align="right"><? if($spiele[$show_stat1]){echo $nieder[$show_stat1]." (".number_format($nieder[$show_stat1]*100/$spiele[$show_stat1],2,",",".")."%)";} ?></td>
          <th><?= $text[69]; ?></th>
          <? if($show_stat2>0 && $show_stat1!=$show_stat2){ ?><td align="left"><? if($spiele[$show_stat2]){echo $nieder[$show_stat2]." (".number_format($nieder[$show_stat2]*100/$spiele[$show_stat2],2,",",".")."%)";} ?></td><? } ?>
        </tr>
        <tr>
          <td align="right"><?= $maxn0[$show_stat1]; ?></td>
          <th valign="top"><?= $text[70]; ?></th>
          <? if($show_stat2>0 && $show_stat1!=$show_stat2){ ?><td align="left"><?= $maxn0[$show_stat2]; ?></td><? } ?>
        </tr>
        <tr>
          <td align="right"><?= $serie1; ?></td>
          <th valign="top"><?= $text[71]; ?></th>
          <? if($show_stat2>0 && $show_stat1!=$show_stat2){ ?><td align="left"><?= $serie2; ?></td><? } ?>
        </tr>
<?
    }
?>
      </table>
    </td>
    <td valign="top" align="center">
      <table class="lmoMenu" cellspacing="0" cellpadding="0" border="0"><?
  for($i=1;$i<=$anzteams;$i++){?>
        <tr>
          <td><?=getSmallImage($teams[$i]);?>&nbsp;</td>
          <td align="left">
            <acronym title="<?=$text[57]." ".$teams[$i]?>"><?
    if($i!=$show_stat2){
               ?><a href="<?=$adds.$show_stat1?>&amp;stat2=<?=$i?>"><?=$teamk[$i]?></a><?
    } else {
      echo $teamk[$i];
    }
          ?></acronym>
          </td>
        </tr><?
  }?>
      </table>
    </td>
  </tr>
</table><?
  if ($einzustats == 1) {
    $strs = ".l98";
    $stre = ".l98.php";
    $str = basename($file);
    $file16 = str_replace($strs, $stre, $str);
    $temp11 = basename($diroutput);
    if (file_exists(PATH_TO_LMO."/$temp11/$file16")) {
      require(PATH_TO_LMO."/$temp11/$file16");?>
<table class="lmoMiddle" cellspacing="0" cellpadding="0" border="0">
  <tr>
    <td align="center" colspan="5"><h1><?=$text[4009]?></h1></td>
  </tr>
  <tr>
    <td align="center">
      <table class="lmoInner" cellspacing="0" cellpadding="0" border="0">
        <tr>
          <th colspan="4" align="center"><?=$text[63]?> </th>
        </tr>
        <tr>
          <td align="right"> <?=$text[516]?> </td>
          <td align="right"> <?=$text[4006]?> </td>
          <td align="center"> <?=$text[4008]?> </td>
          <td align="left"> <?=$text[4007]?> </td>
        </tr>
        <tr>
          <td align="right"> <strong><?=$ggesamt=$gzusieg1+$gzusieg2+$gzuunent+$gbeide;?></strong></td>
          <td align="right"> <strong><?=$gzusieg1?></strong><?if ($ggesamt>0) {$v=round($gzusieg1/$ggesamt*100);echo " ($v%)";}?> </td>
          <td align="center"> <strong><?=$gzuunent?></strong><?if ($ggesamt>0) {$v=round($gzuunent/$ggesamt*100);echo " ($v%)";}?> </td>
          <td align="left"> <strong><?=$gzusieg2?></strong><?if ($ggesamt>0) {$v=round($gzusieg2/$ggesamt*100);echo " ($v%)";}?> </td>
        </tr><?
    if ($gbeide>0) {?>
        <tr>
          <td align="right" colspan="2"><?=$text[4012]?></td>
          <td colspan="2" align="center"><strong><?=$gbeide?></strong><?if ($ggesamt>0) {$v=round($gbeide/$ggesamt*100);echo " ($v%)";}?></td>
        </tr><?
    }?>
        <tr>
          <th colspan="4" align="center"><?=$text[38]?> </th>
        </tr>
        <tr>
          <td align="right"> <?=$text[516]?> </td>
          <td align="right"> <?=$text[41]."-".$text[38]?> </td>
          <td>&nbsp;</td>
          <td align="left"> <?=$text[42]."-".$text[38]?> </td>
        </tr>
        <tr>
          <td align="right"> <strong><?=applyFactor($gzutore,$goalfaktor);?></strong> (<?=$text[517]?><?=applyFactor($gdstore,$goalfaktor)?>) </td>
          <td align="right"> <strong><?=applyFactor($gheimtore,$goalfaktor);?></strong><?if ($gdstore>0) {$v=round($dsheimtore/$gdstore*100);echo " ($v% ".$text[517].applyFactor($dsheimtore,$goalfaktor).")";}?> </td>
          <td>&nbsp;</td>
          <td align="left"> <strong><?=applyFactor($ggasttore,$goalfaktor);?></strong><?if ($gdstore>0) {echo " (".(100-$v)."% ".$text[517].applyFactor($dsgasttore,$goalfaktor).")";}?> </td>
        </tr><?
    if ($hheimsiegtor>0) {?>
        <tr>
          <th colspan="4" align="center"><?=$text[4013]?></th>
        </tr><tr>
          <td align="right"><?=$hheimsieg?> - </td>
          <td align="left"><?=$hgastsieg?></td>
          <td colspan="2" align="left"><?=applyFactor($hheimsiegtor,$goalfaktor)?>:<?=applyFactor($hgastsiegtor,$goalfaktor)?> (<?=$spieltagflag?>.<?=$text[4014]?>)</td>
        </tr><?
      if ($hheimsiegtor1>0) {?>
        <tr>
          <td align="right"><?=$hheimsieg1?> - </td>
          <td align="left"><?=$hgastsieg1?></td>
          <td colspan="2" align="left"><?=applyFactor($hheimsiegtor1,$goalfaktor)?>:<?=applyFactor($hgastsiegtor1,$goalfaktor)?> (<?=$spieltagflag1?>.<?=$text[4014]?>)</td>
        </tr><?
  	    if ($counteranz>2) {
  	      $counteranz0=$counteranz-2;?>
      	<tr>
          <td>&nbsp;</td>
          <td colspan="3" align="right"><small><?=$text[4015]?> <?=$counteranz0?> <?=$text[4016]?></small></td>
        </tr><?
  	    }
      }
    }
    if ($agastsiegtor>0) {?>
        <tr>
          <th colspan="4" align="center"><?=$text[4017]?></th>
        </tr>
        <tr>
          <td align="right"><?=$aheimsieg?> - </td>
          <td align="left"><?=$agastsieg?></td>
          <td colspan="2" align="left"><?=applyFactor($aheimsiegtor,$goalfaktor)?>:<?=applyFactor($agastsiegtor,$goalfaktor)?> (<?=$spieltagflag2?>.<?=$text[4014]?>)</td>
        </tr>  <?
      if ($agastsiegtor1>0) {?>
        <tr>
          <td align="right"><?=$aheimsieg1?> - </td>
          <td align="left"><?=$agastsieg1?></td>
          <td colspan="2" align="left"><?=applyFactor($aheimsiegtor1,$goalfaktor)?>:<?=applyFactor($agastsiegtor1,$goalfaktor)?>  (<?=$spieltagflag3?>.<?=$text[4014]?>)</td>
        </tr><?
  	    if ($counteranz1>2) {
  	      $counteranz4=$counteranz1-2;?>
        <tr> 
          <td>&nbsp;</td>
          <td colspan="3" align="right"><small><?=$text[4015]?> <?=$counteranz4?> <?=$text[4016]?></small></td>
        </tr><?
  	    }
      }
    }
    if ($spieltagflag4>0) {?>
        <tr>
          <th colspan="4" align="center"><?=$text[4018]?>  <?=$text[38]?></th>
        </tr>
        <tr>
          <td align="right"><?=$htorreichm1?> - </td>
          <td align="left"><?=$htorreichm2?></td>
          <td colspan="2" align="left"><?=applyFactor($htorreicht1,$goalfaktor)?>:<?=applyFactor($htorreicht2,$goalfaktor)?>  (<?=$spieltagflag4?>.<?=$text[4014]?>)</td>
        </tr><?
      if ($spieltagflag5>0) {?>
        <tr>
          <td align="right"><?=$htorreichm3?> - </td>
          <td align="left"><?=$htorreichm4?></td>
          <td colspan="2" align="left"><?=applyFactor($htorreicht3,$goalfaktor)?>:<?=applyFactor($htorreicht4,$goalfaktor)?>  (<?=$spieltagflag5?>.<?=$text[4014]?>)</td>
        </tr><?
  	    if ($counteranz5>2) {
  	      $counteranz6=$counteranz5-2;?>
    	  <tr>
           <td>&nbsp;</td>
           <td colspan="3" align="right"><small><?=$text[4015]?> <?=$counteranz6?> <?=$text[4019]?></small></td>
         </tr><?
      	}
      }
    }?>
      </table>
    </td>
  </tr>
</table><?
  } //if (file_exists)
} //if (zustats)
?>
 
<? } ?>