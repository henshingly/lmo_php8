<?
// 
// LigaManager Online 3.02b
// Copyright (C) 1997-2002 by Frank Hollwitz
// webmaster@hollwitz.de / http://php.hollwitz.de
// 
// This program is free software; you can redistribute it and/or
// modify it under the terms of the GNU General Public License as
// published by the Free Software Foundation; either version 2 of
// the License, or (at your option) any later version.
// 
// This program is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
// General Public License for more details.
// 
// You should have received a copy of the GNU General Public License
// along with this program; if not, write to the Free Software
// Foundation, Inc., 675 Mass Ave, Cambridge, MA 02139, USA.
// 
if($file!=""){
  $adds=$_SERVER['PHP_SELF']."?action=stats&amp;file=".$file."&amp;stat1=";
  $addr=$_SERVER['PHP_SELF']."?action=results&amp;file=".$file."&amp;st=";
?>

<table class="lmosta" cellspacing="0" cellpadding="0" border="0">
  <tr>
    <td valign="top" align="center"><table cellspacing="0" cellpadding="0" border="0">
<?
  for($i=1;$i<=$anzteams;$i++){
    echo "<tr><td align=\"center\" ";
    if($i<>$stat1){
      echo "class=\"lmost0\"><a href=\"".$adds.$i."&amp;stat2=".$stat2."\" title=\"".$text[57]." ".$teams[$i]."\">".$teamk[$i]."</a>";
      }
    else{
      echo "class=\"lmost1\">".$teamk[$i];
      }
    echo "</td></tr>";
    }
?>
    </table></td>
    <td valign="top" align="center" class="lmost3"><table class="lmostb" cellspacing="0" cellpadding="0" border="0">

<?
  if($stat1==0){
    echo "<tr><td align=\"center\" class=\"lmost5\">&nbsp;<br>".$text[24]."<br>&nbsp;</td></tr>";
    }
  else{
    $endtab=$anzst;
    require(PATH_TO_LMO."/lmo-calctable.php");
    $platz0 = array("");
    $platz0 = array_pad($array,$anzteams+1,"");
    for($x=0;$x<$anzteams;$x++){$platz0[intval(substr($tab0[$x],34))]=$x+1;}
?>
      <tr>
        <td valign="top" align="right" class="lmost4"><?= $teams[$stat1]; ?></td>
        <td valign="top" align="center" class="lmost4">&nbsp;</td>
        <? if($stat2>0){ ?><td valign="top" class="lmost4"><?= $teams[$stat2]; ?></td><? } ?>
      </tr>
<? if($stat2>0){$dummy=" align='center'";}else{$dummy="align='left'";} ?>
<?
  $serie1="&nbsp;";
if ($ser1[$stat1]>0) {
  $serie1=$ser1[$stat1]." ".$text[474]."<br>".$ser2[$stat1]." ".$text[75];
} else if ($ser3[$stat1]>0) {
  $serie1=$ser3[$stat1]." ".$text[475]."<br>".$ser4[$stat1]." ".$text[76];
} else if ($ser2[$stat1]>=$ser4[$stat1]) {
  $serie1=$ser2[$stat1]." ".$text[75];
} else {
  $serie1=$ser4[$stat1]." ".$text[76];
}
if ($stat2>0) {
  $chg1="k.A.";
  $chg2="k.A.";
  if (!empty($spiele[$stat1])&&!empty($spiele[$stat2])) {
    $ax=(100*$siege[$stat1]/$spiele[$stat1])+(100*$nieder[$stat2]/$spiele[$stat2]);
    $bx=(100*$siege[$stat2]/$spiele[$stat2])+(100*$nieder[$stat1]/$spiele[$stat1]);
    $cx=($etore[$stat1]/$spiele[$stat1])+($atore[$stat2]/$spiele[$stat2]);
    $dx=($etore[$stat2]/$spiele[$stat2])+($atore[$stat1]/$spiele[$stat1]);
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
  if ($ser1[$stat2]>0) {
    $serie2=$ser1[$stat2]." ".$text[474]."<br>".$ser2[$stat2]." ".$text[75];
  } else if ($ser3[$stat2]>0) {
    $serie2=$ser3[$stat2]." ".$text[475]."<br>".$ser4[$stat2]." ".$text[76];
  } else if ($ser2[$stat2]>=$ser4[$stat2]) {
    $serie2=$ser2[$stat2]." ".$text[75];
  } else {
    $serie2=$ser4[$stat2]." ".$text[76];
  }
  

?>
      <tr>
        <td valign="top" align="right" class="lmost5"><?= $chg1; ?>%</td>
        <td valign="top" class="lmost4"<?= $dummy; ?>><?= $text[60]; ?></td>
        <td valign="top" align="left" class="lmost5"><?= $chg2; ?>%</td>
      </tr>
<? } ?>
      <tr>
        <td valign="top" align="right" class="lmost5"><?= $platz0[$stat1]; ?></td>
        <td valign="top" class="lmost4"<?= $dummy; ?>><?= $text[61]; ?></td>
        <? if($stat2>0){ ?><td valign="top" align="left" class="lmost5"><?= $platz0[$stat2]; ?></td><? } ?>
      </tr>
      <tr>
        <td valign="top" align="right" class="lmost5"><?= $punkte[$stat1]; if($minus==2){":".$negativ[$stat1];} ?></td>
        <td valign="top" class="lmost4"<?= $dummy; ?>><?= $text[37]; ?></td>
        <? if($stat2>0){ ?><td valign="top" align="left" class="lmost5"><?= $punkte[$stat2]; if($minus==2){":".$negativ[$stat2];} ?></td><? } ?>
      </tr>
      <tr>
        <td valign="top" align="right" class="lmost5"><?= $spiele[$stat1]; ?></td>
        <td valign="top" class="lmost4"<?= $dummy; ?>><?= $text[63]; ?></td>
        <? if($stat2>0){ ?><td valign="top" align="left" class="lmost5"><?= $spiele[$stat2]; ?></td><? } ?>
      </tr>
      <tr>
        <td valign="top" align="right" class="lmost5"><? if($spiele[$stat1]){echo number_format($punkte[$stat1]/$spiele[$stat1],2,",","."); if($minus==2){":".number_format($negativ[$stat1]/$spiele[$stat1],2,",",".");}} ?></td>

        <td valign="top" class="lmost4"<?= $dummy; ?>><?= $text[37].$text[64]; ?></td>
        <? if($stat2>0){if($spiele[$stat2]){ ?><td valign="top" align="left" class="lmost5"><? echo number_format($punkte[$stat2]/$spiele[$stat2],2,",","."); if($minus==2){":".number_format($negativ[$stat2]/$spiele[$stat2],2,",",".");}} ?></td><? } ?>

      </tr>
      <tr>
        <td valign="top" align="right" class="lmost5"><?= $etore[$stat1].":".$atore[$stat1]; ?></td>
        <td valign="top" class="lmost4"<?= $dummy; ?>><?= $text[38]; ?></td>
        <? if($stat2>0){ ?><td valign="top" align="left" class="lmost5"><?= $etore[$stat2].":".$atore[$stat2]; ?></td><? } ?>
      </tr>
      <tr>
        <td valign="top" align="right" class="lmost5"><? if($spiele[$stat1]){ echo number_format($etore[$stat1]/$spiele[$stat1],2,",",".").":".number_format($atore[$stat1]/$spiele[$stat1],2,",",".");} ?></td>
        <td valign="top" class="lmost4"<?= $dummy; ?>><?= $text[38].$text[64]; ?></td>
        <? if($stat2>0){ ?><td valign="top" align="left" class="lmost5"><? if($spiele[$stat2]){ echo number_format($etore[$stat2]/$spiele[$stat2],2,",",".").":".number_format($atore[$stat2]/$spiele[$stat2],2,",",".");} ?></td><? } ?>
      </tr>
      <tr>
        <td valign="top" align="right" class="lmost5"><? if($spiele[$stat1]){echo $siege[$stat1]." (".number_format($siege[$stat1]*100/$spiele[$stat1],2,",",".")."%)";} ?></td>
        <td valign="top" class="lmost4"<?= $dummy; ?>><?= $text[67]; ?></td>
        <? if($stat2>0){ ?><td valign="top" align="left" class="lmost5"><? if($spiele[$stat2]){echo $siege[$stat2]." (".number_format($siege[$stat2]*100/$spiele[$stat2],2,",",".")."%)";} ?></td><? } ?>
      </tr>
      <tr>
        <td valign="top" align="right" class="lmost5"><?= $maxs0[$stat1]; ?></td>
        <td valign="top" class="lmost4"<?= $dummy; ?>><?= $text[68]; ?></td>
        <? if($stat2>0){ ?><td valign="top" align="left" class="lmost5"><?= $maxs0[$stat2]; ?></td><? } ?>
      </tr>
      <tr>
        <td valign="top" align="right" class="lmost5"><? if($spiele[$stat1]){echo $nieder[$stat1]." (".number_format($nieder[$stat1]*100/$spiele[$stat1],2,",",".")."%)";} ?></td>
        <td valign="top" class="lmost4"<?= $dummy; ?>><?= $text[69]; ?></td>
        <? if($stat2>0){ ?><td valign="top" align="left" class="lmost5"><? if($spiele[$stat2]){echo $nieder[$stat2]." (".number_format($nieder[$stat2]*100/$spiele[$stat2],2,",",".")."%)";} ?></td><? } ?>
      </tr>
      <tr>
        <td valign="top" align="right" class="lmost5"><?= $maxn0[$stat1]; ?></td>
        <td valign="top" class="lmost4"<?= $dummy; ?>><?= $text[70]; ?></td>
        <? if($stat2>0){ ?><td valign="top" align="left" class="lmost5"><?= $maxn0[$stat2]; ?></td><? } ?>
      </tr>
      <tr>
        <td valign="top" align="right" class="lmost5"><?= $serie1; ?></td>
        <td valign="top" class="lmost4"<?= $dummy; ?>><?= $text[71]; ?></td>
        <? if($stat2>0){ ?><td valign="top" align="left" class="lmost5"><?= $serie2; ?></td><? } ?>
      </tr>
<?
    }
?>
    </table></td>
    <td valign="top" align="center"><table cellspacing="0" cellpadding="0" border="0">
<?
  for($j=0;$j<=$anzteams;$j++){
    $i=$j+1;
    if($i>$anzteams){$i=0;}
    if($i==0){$dummy=$text[59];}else{$dummy=$text[58]." ".$teams[$i];}
    echo "<tr><td align=\"center\" ";
    if($i<>$stat2){
      echo "class=\"lmost0\"><a href=\"".$adds.$stat1."&amp;stat2=".$i."\" title=\"".$dummy."\">".$teamk[$i]."</a>";
      }
    else{
      echo "class=\"lmost1\">".$teamk[$i];
      }
    echo "</td></tr>";
    }
?>
    </table>
  </td>
</tr>
</table>
<?
if ($einzustats==1) {  
  $strs=".l98";
  $stre=".l98.php";
  $str=basename($file);
  $file16=str_replace($strs,$stre,$str);
  $temp11=basename($diroutput);
  if (file_exists("$temp11/$file16")){
    require(PATH_TO_LMO."/$temp11/$file16");?>
<table>
<tr>
    <td class="lmost1" align="center"><?=$text[4009]?></td>
  </tr>
<tr>
  <td>
<table class="lmosta" align="center" cellspacing="0" cellpadding="0" border="0">
  
  <tr>
    <td colspan="5">&nbsp;</td>
  </tr>
  <tr>
    <td class="lmost4" align="right"><?=$text[63]?> </td>
    <td colspan="4" align="center">
      <table width="100%" cellspacing="0" cellpadding="0" border="0">
        <tr>
          <td class="lmost4" align="center"> <?=$text[516]?> </td>
          <td class="lmost4" align="center"> <?=$text[4006]?> </td>
          <td class="lmost4" align="center"> <?=$text[4007]?> </td>
          <td class="lmost4" align="center"> <?=$text[4008]?> </td>
        </tr>
        <tr>
          <td class="lmost5" align="center"> <?=$ggesamt=$gzusieg1+$gzusieg2+$gzuunent+$gbeide;?></td>
          <td class="lmost5" align="center"> <?=$gzusieg1?><?if ($ggesamt>0) {$v=round($gzusieg1/$ggesamt*100);echo " ($v%)";}?> </td>
          <td class="lmost5" align="center"> <?=$gzusieg2?><?if ($ggesamt>0) {$v=round($gzusieg2/$ggesamt*100);echo " ($v%)";}?> </td>
          <td class="lmost5" align="center"> <?=$gzuunent?><?if ($ggesamt>0) {$v=round($gzuunent/$ggesamt*100);echo " ($v%)";}?> </td>
        </tr>
      </table>
    </td>
  </tr><?
    if ($gbeide>0) {?>
  <tr>
    <td class="lmost4" align="right"><?=$text[4012]?></td>
    <td class="lmost5" colspan="2" align="center"><?=$gbeide?><?if ($ggesamt>0) {$v=round($gbeide/$ggesamt*100);echo " ($v%)";}?></td>
  </tr><?
    }?>
  <tr>
    <td colspan="5">&nbsp;</td>
  </tr>
  <tr>
    <td class="lmost4" align="right"><?=$text[38]?> </td>
    <td colspan="4" align="center">
      <table width="100%" cellspacing="0" cellpadding="0" border="0">
        <tr>
          <td class="lmost4" align="center"></td>
          <td class="lmost4" align="center"> <?=$text[516]?> </td>
          <td class="lmost4" align="center"> <?=$text[4010]?> </td>
          <td class="lmost4" align="center"> <?=$text[4011]?> </td>
        </tr>
        <tr>
          <td class="lmost5"></td>
          <td class="lmost5" align="center"> <?=$gzutore?> </td>
          <td class="lmost5" align="center"> <?=$gheimtore?><?if ($gdstore>0) {$v=round($dsheimtore/$gdstore*100);echo " ($v%)";}?> </td>
          <td class="lmost5" align="center"> <?=$ggasttore?><?if ($gdstore>0) {echo " (".(100-$v)."%)";}?> </td>
        </tr>
        <tr>
          <td class="lmost5" align="center"> <?=$text[517]?> </td>
          <td class="lmost5" align="center"> <?=$gdstore?> </td>
          <td class="lmost5" align="center"> <?=$dsheimtore?> </td>
          <td class="lmost5" align="center"> <?=$dsgasttore?> </td>
        </tr>
      </table>
    </td>
  </tr>
  <tr>
    <td colspan="5">&nbsp;</td>
  </tr>   
  <tr>
    <td class="lmost4" align="right"><?=$text[4013]?></td>
    <td class="lmost5" align="right"><?=$hheimsieg?></td>
    <td class="lmost5">-</td>
    <td class="lmost5" align="left"><?=$hgastsieg?></td>
    <td class="lmost5" align="left"><?=$hheimsiegtor?>:<?=$hgastsiegtor?> (<?=$spieltagflag?>.<?=$text[4014]?>)</td>
  </tr><?
    if ($hheimsiegtor1>0) {?>
  <tr>
    <td class="lmost4"></td>
    <td class="lmost5" align="right"><?=$hheimsieg1?></td>
    <td class="lmost5">-</td>
    <td class="lmost5" align="left"><?=$hgastsieg1?></td>
    <td class="lmost5" align="left"><?=$hheimsiegtor1?>:<?=$hgastsiegtor1?> (<?=$text[4014]?>.<?=$spieltagflag1?>)</td>
  </tr><?
	    if ($counteranz>2) {
	      $counteranz0=$counteranz-2;?>
	<tr>
    <td class="lmost4"></td>
    <td class="lmost5" colspan="4" align="right"><small><?=$text[4015]?> <?=$counteranz0?> <?=$text[4016]?></small></td>
  </tr><?
	    }
    }?>
  <tr>
    <td colspan="5">&nbsp;</td>
  </tr>
  <tr>
    <td class="lmost4" align="right"><?=$text[4017]?></td>
    <td class="lmost5" align="right"><?=$aheimsieg?></td>
    <td class="lmost5">-</td>
    <td class="lmost5" align="left"><?=$agastsieg?></td>
    <td class="lmost5" align="left"><?=$aheimsiegtor?>:<?=$agastsiegtor?> (<?=$spieltagflag2?>.<?=$text[4014]?>)</td>
  </tr>  <?
    if ($agastsiegtor1>0) {?>
  <tr>
    <td class="lmost4"></td>
    <td class="lmost5" align="right"><?=$aheimsieg1?></td>
    <td class="lmost5">-</td>
    <td class="lmost5" align="left"><?=$agastsieg1?></td>
    <td class="lmost5" align="left"><?=$aheimsiegtor1?>:<?=$agastsiegtor1?>  (<?=$spieltagflag3?>.<?=$text[4014]?>)</td>
  </tr><?
	    if ($counteranz1>2) {
	      $counteranz4=$counteranz1-2;?>
  <tr> 
    <td class="lmost4"></td>
    <td class="lmost5" colspan="4" align="right"><small><?=$text[4015]?> <?=$counteranz4?> <?=$text[4016]?></small></td>
  </tr><?
	    }
    }?>
  <tr>
    <td colspan="5">&nbsp;</td>
  </tr>
    <tr>
      <td class="lmost4" align="right"><?=$text[4018]?>  <?=$text[38]?></td>
      <td class="lmost5" align="right"><?=$htorreichm1?></td>
      <td class="lmost5">-</td>
      <td class="lmost5" align="left"><?=$htorreichm2?></td>
      <td class="lmost5" align="left"><?=$htorreicht1?>:<?=$htorreicht2?>  (<?=$spieltagflag4?>.<?=$text[4014]?>)</td>
    </tr><?
    if ($spieltagflag5<>0) {?>
    <tr>
      <td class="lmost4"></td>
      <td class="lmost5" align="right"><?=$htorreichm3?></td>
      <td class="lmost5">-</td>
      <td class="lmost5" align="left"><?=$htorreichm4?></td>
      <td class="lmost5" align="left"><?=$htorreicht3?>:<?=$htorreicht4?>  (<?=$spieltagflag5?>.<?=$text[4014]?>)</td>
    </tr><?
	    if ($counteranz5>2) {
	      $counteranz6=$counteranz5-2;?>
	  <tr>
       <td class="lmost4">  </td>
       <td class="lmost5" colspan="4" align="right"><small><?=$text[4015]?> <?=$counteranz6?> <?=$text[4019]?></small></td>
     </tr><?
    	}
    }?>
    <tr>
      <td colspan="5">&nbsp;</td>
    </tr>
  </table>
  </td>
</tr>
</table><?
  } //if (file_exists)
} //if (zustats)
?>
 
<? } ?>