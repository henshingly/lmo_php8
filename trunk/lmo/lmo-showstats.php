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
  * $Id$
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
      <table class="lmoMenu" cellspacing="0" cellpadding="0" border="0"><?php
  for($i=1;$i<=$anzteams;$i++){?>
        <tr>
          <td align="right">
            <acronym title="<?php echo $text[57]." ".$teams[$i]?>"><?php
    if($i!=$show_stat1){?>
            <a href="<?php echo $adds.$i?>&amp;stat2=<?php echo $show_stat2?>"><?php echo $teamk[$i]; ?></a><?php
    } else {
      echo $teamk[$i];
    }     ?></acronym>
          </td>
          <td><?php echo HTML_smallTeamIcon($file,$teams[$i]," alt=''"); ?>&nbsp;</td>
        </tr><?php
  }?>
      </table>
    </td>
    <td valign="top" align="center">
      <table class="lmoInner" cellspacing="0" cellpadding="0" border="0"><?php
  if($show_stat1==0){?>
        <tr>
          <td align="center">&nbsp;<br /><?php echo $text[24]; ?><br />&nbsp;</td>
        </tr><?php
  } else {
    $endtab = $anzst;
    require(PATH_TO_LMO."/lmo-calctable.php");
    $platz0 = array("");
    $platz0 = array_pad($array, $anzteams+1, "");
    for($x = 0; $x < $anzteams; $x++) {
      $platz0[intval(substr($tab0[$x], 34))] = $x+1;
    }?>
        <tr>
          <th align="right"><?php echo $teams[$show_stat1];?></th>
          <th align="center"><?php
      echo HTML_smallTeamIcon($file,$teams[$show_stat1]," alt=''")."&nbsp;";
      if($show_stat2>0 && $show_stat1!=$show_stat2){
        echo "&nbsp;".HTML_smallTeamIcon($file,$teams[$show_stat2]," alt=''");
      }?>
          </th><?php
      if($show_stat2>0 && $show_stat1!=$show_stat2){ ?>
          <th align="left"><?php echo $teams[$show_stat2];?></th><?php
      }?>
        </tr>
<?php
  $serie1="&nbsp;";
  if ($ser1[$show_stat1]>0) {
    $serie1=$ser1[$show_stat1]." ".$text[474]."<br />".$ser2[$show_stat1]." ".$text[75];
  } elseif ($ser3[$show_stat1]>0) {
    $serie1=$ser3[$show_stat1]." ".$text[475]."<br />".$ser4[$show_stat1]." ".$text[76];
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
      $serie2=$ser1[$show_stat2]." ".$text[474]."<br />".$ser2[$show_stat2]." ".$text[75];
    } else if ($ser3[$show_stat2]>0) {
      $serie2=$ser3[$show_stat2]." ".$text[475]."<br />".$ser4[$show_stat2]." ".$text[76];
    } else if ($ser2[$show_stat2]>=$ser4[$show_stat2]) {
      $serie2=$ser2[$show_stat2]." ".$text[75];
    } else {
      $serie2=$ser4[$show_stat2]." ".$text[76];
    }


?>
        <tr>
          <td align="right"><?php echo $chg1; ?>%</td>
          <th align="center"><?php echo $text[60]; ?></th>
          <td align="left"><?php echo $chg2; ?>%</td>
        </tr>
<?php } ?>
        <tr>
          <td align="right"><?php echo $platz0[$show_stat1];?></td>
          <th><?php echo $text[61];?></th>
          <?php if($show_stat2>0 && $show_stat1!=$show_stat2){ ?><td align="left"><?php echo $platz0[$show_stat2];?></td><?php } ?>
        </tr>
        <tr>
          <td align="right"><?php echo applyFactor($punkte[$show_stat1],$pointsfaktor); if($minus==2){":".applyFactor($negativ[$show_stat1],$pointsfaktor);} ?></td>
          <th><?php echo $text[37]; ?></th>
          <?php if($show_stat2>0 && $show_stat1!=$show_stat2){ ?><td align="left"><?php echo applyFactor($punkte[$show_stat2],$pointsfaktor); if($minus==2){":".applyFactor($negativ[$show_stat2],$pointsfaktor);} ?></td><?php } ?>
        </tr>
        <tr>
          <td align="right"><?php echo $spiele[$show_stat1];?></td>
          <th><?php echo $text[63]; ?></th>
          <?php if($show_stat2>0 && $show_stat1!=$show_stat2){ ?><td align="left"><?php echo $spiele[$show_stat2];?></td><?php } ?>
        </tr>
        <tr>
          <td align="right"><?php if($spiele[$show_stat1]){echo applyFactor(number_format($punkte[$show_stat1]/$spiele[$show_stat1],2),$pointsfaktor); if($minus==2){":".applyFactor(number_format($negativ[$show_stat1]/$spiele[$show_stat1],2),$pointsfaktor);}} ?></td>
          <th><?php echo $text[37].$text[64]; ?></th>
          <?php if($show_stat2>0 && $show_stat1!=$show_stat2){if($spiele[$show_stat2]){ ?><td align="left"><?php echo applyFactor(number_format($punkte[$show_stat2]/$spiele[$show_stat2],2),$pointsfaktor); if($minus==2){":".applyFactor(number_format($negativ[$show_stat2]/$spiele[$show_stat2],2),$pointsfaktor);}} ?></td><?php } ?>
        </tr>
        <tr>
          <td align="right"><?php echo applyFactor($etore[$show_stat1],$goalfaktor).":".applyFactor($atore[$show_stat1],$goalfaktor); ?></td>
          <th><?php echo $text[38]; ?></th>
          <?php if($show_stat2>0 && $show_stat1!=$show_stat2){ ?><td align="left"><?php echo applyFactor($etore[$show_stat2],$goalfaktor).":".applyFactor($atore[$show_stat2],$goalfaktor); ?></td><?php } ?>
        </tr>
        <tr>
          <td align="right"><?php if($spiele[$show_stat1]){ echo number_format(applyFactor($etore[$show_stat1],$goalfaktor)/$spiele[$show_stat1],2).":".number_format(applyFactor($atore[$show_stat1],$goalfaktor)/$spiele[$show_stat1],2);} ?></td>
          <th><?php echo $text[38].$text[64]; ?></th>
          <?php if($show_stat2>0 && $show_stat1!=$show_stat2){ ?><td align="left"><?php if($spiele[$show_stat2]){ echo number_format(applyFactor($etore[$show_stat2],$goalfaktor)/$spiele[$show_stat2],2).":".number_format(applyFactor($atore[$show_stat2],$goalfaktor)/$spiele[$show_stat2],2);} ?></td><?php } ?>
        </tr>
        <tr>
          <td align="right"><?php if($spiele[$show_stat1]){echo $siege[$show_stat1]." (".number_format($siege[$show_stat1]*100/$spiele[$show_stat1],2,",",".")."%)";} ?></td>
          <th><?php echo $text[67]; ?></th>
          <?php if($show_stat2>0 && $show_stat1!=$show_stat2){ ?><td align="left"><?php if($spiele[$show_stat2]){echo $siege[$show_stat2]." (".number_format($siege[$show_stat2]*100/$spiele[$show_stat2],2,",",".")."%)";} ?></td><?php } ?>
        </tr>
        <tr>
          <td align="right"><?php echo $maxs0[$show_stat1]; ?></td>
          <th valign="top"><?php echo $text[68]; ?></th>
          <?php if($show_stat2>0 && $show_stat1!=$show_stat2){ ?><td align="left"><?php echo $maxs0[$show_stat2] ?></td><?php } ?>
        </tr>
        <tr>
          <td align="right"><?php if($spiele[$show_stat1]){echo $nieder[$show_stat1]." (".number_format($nieder[$show_stat1]*100/$spiele[$show_stat1],2,",",".")."%)";} ?></td>
          <th><?php echo $text[69]; ?></th>
          <?php if($show_stat2>0 && $show_stat1!=$show_stat2){ ?><td align="left"><?php if($spiele[$show_stat2]){echo $nieder[$show_stat2]." (".number_format($nieder[$show_stat2]*100/$spiele[$show_stat2],2,",",".")."%)";} ?></td><?php } ?>
        </tr>
        <tr>
          <td align="right"><?php echo $maxn0[$show_stat1]; ?></td>
          <th valign="top"><?php echo $text[70]; ?></th>
          <?php if($show_stat2>0 && $show_stat1!=$show_stat2){ ?><td align="left"><?php echo $maxn0[$show_stat2]; ?></td><?php } ?>
        </tr>
        <tr>
          <td align="right"><?php echo $serie1; ?></td>
          <th valign="top"><?php echo $text[71]; ?></th>
          <?php if($show_stat2>0 && $show_stat1!=$show_stat2){ ?><td align="left"><?php echo $serie2; ?></td><?php } ?>
        </tr>

<?php
/** ClassLib Statistik Erweiterung begin */
//require_once(PATH_TO_ADDONDIR."/classlib/ini.php");
$file = isset($file)?$file:NULL;
$liga = new liga();

// Existiert bereits ein Objekt der Liga (z.B. durch ein anderes Addin), wird dieses verwendet
// Dadurch wird das erneute Laden des Files vermieden. Performance !!!!
$ligaLoaded = FALSE;
if ($file && (!isset($liga) || !is_object($liga) || $liga->fileName != $file)) {
	$liga = new liga();
	$ligaLoaded = $liga->loadFile(PATH_TO_LMO.'/'.$dirliga.$file);
}

if ($ligaLoaded	and $show_stat1 > 0 and $show_stat1 <= $liga->teamCount()) {
	$table = $liga->calcTable($liga->spieltageCount());
	$team_a = new team();
	$team_a = $liga->teamForNumber($show_stat1);
	$rstPrgMinus_a = 0;
	$rstPrgMinus_b = 0;
	$rstPrgPlus_a = 0;
	$rstPrgPlus_b = 0;
	$faktor = $liga->teamCount();
	$sortedGames_a = array();
	$sortedGames_b = array();
	$sortedGames_a = gamesSortedForTeam ($liga,$team_a,false);
	echo "<!-- OUTPUT Restprogramm START-->";
	echo "<tr><td align=\"right\" valign=\"top\">";
	foreach ($sortedGames_a as $game_a) {
		$result = $game_a['partie']->valuateGame();
		$pos = 1;
		if ( $result == -1 ) {
			// aktuelle Tabellenposition ermitteln
			if ($game_a['partie']->heim == $team_a)
				$gegner_a = &$game_a['partie']->gast;
			else
				$gegner_a = &$game_a['partie']->heim;

			foreach ( $table as $position ) {
				if ($position['team'] == $gegner_a) break;
				$pos ++;
			}
			$rstPrgPlus_a += $position["pPkt"];
			$rstPrgMinus_a += $position["mPkt"];

			if ($game_a['partie']->heim == $team_a)
				echo $text[73]."&nbsp;".$gegner_a->name;
			else
				echo $text[74]."&nbsp;".$gegner_a->name;
			echo "&nbsp;(".$pos.".)";
			echo "<br />";
		}
	}
	$rstPrg_a = $rstPrgPlus_a - $rstPrgMinus_a;
	echo "</td><th valign=\"top\">$text[4020]</th>";
	echo "<td align=\"left\" valign=\"top\">";
	if ($show_stat1 <> $show_stat2 and $show_stat2 > 0 and $show_stat2 <= $liga->teamCount() ) {
		$team_b = new team();
		$team_b = $liga->teamForNumber($show_stat2);
		$sortedGames_b = gamesSortedForTeam ($liga,$team_b,false);

		foreach ($sortedGames_b as $game_b) {
			$result = $game_b['partie']->valuateGame();
			$pos = 1;
			if ( $result == -1) {
				// aktuelle Tabellenposition ermitteln
				if ($game_b['partie']->heim == $team_b)
					$gegner_b = &$game_b['partie']->gast;
				else
					$gegner_b = &$game_b['partie']->heim;

				foreach ( $table as $position ) {
					if ($position['team'] == $gegner_b) break;
					$pos ++;
				}
				$rstPrgPlus_b += $position["pPkt"];
				$rstPrgMinus_b += $position["mPkt"];

				echo "(".$pos.".)&nbsp;";
				if ($game_b['partie']->heim == $team_b)
					echo $gegner_b->name."&nbsp;".$text[73];
				else
					echo $gegner_b->name."&nbsp;".$text[74];
				echo "<br />";
			}
		}
//		echo "</td></tr>";
		$rstPrg_b = $rstPrgPlus_b - $rstPrgMinus_b;
		if (($rstPrgPlus_a - $rstPrgMinus_a) < ($rstPrgPlus_b - $rstPrgMinus_b) ) {
			$text_a = $text[4025];
			$text_b = $text[4026];
		}
		else if (($rstPrgPlus_a - $rstPrgMinus_a) > ($rstPrgPlus_b - $rstPrgMinus_b) ) {
			$text_a = $text[4026];
			$text_b = $text[4025];
		}
		else {
			$text_a = $text_b = $text[4024];
		}

	}
	echo "</td></tr>";

	if (isset($team_b) and is_object($team_b) ) {
		echo "<tr><th colspan=\"3\">$text[4021]</th></tr>";
		echo "<tr><td align=\"right\">";
		echo $rstPrgPlus_a.":".$rstPrgMinus_a." (".($rstPrg_a>0?"+".$rstPrg_a:$rstPrg_a).")";
		echo "</td><th valign=\"top\">$text[4022]</th>";
		echo "<td align=\"left\">";
		echo $rstPrgPlus_b.":".$rstPrgMinus_b." (".($rstPrg_b>0?"+".$rstPrg_b:$rstPrg_b).")";
		echo "</td></tr>";
		echo "<tr><td align=\"right\">".$text_a."</td><th valign=\"top\">$text[4023]</th><td align=\"left\">".$text_b."</td></tr>";
	}
	echo "<!-- OUTPUT Restprogramm ENDE-->";
 } // loadFile
/** ClassLib Statistik Erweiterung end */
    }
?>
      </table>
    </td>
    <td valign="top" align="center">
      <table class="lmoMenu" cellspacing="0" cellpadding="0" border="0"><?php
  for($i=1;$i<=$anzteams;$i++){?>
        <tr>
          <td><?php echo HTML_smallTeamIcon($file,$teams[$i]," alt=''"); ?>&nbsp;</td>
          <td align="left">
            <acronym title="<?php echo $text[57]." ".$teams[$i]?>"><?php
    if($i!=$show_stat2){
               ?><a href="<?php echo $adds.$show_stat1?>&amp;stat2=<?php echo $i?>"><?php echo $teamk[$i]?></a><?php
    } else {
      echo $teamk[$i];
    }
          ?></acronym>
          </td>
        </tr><?php
  }?>
      </table>
    </td>
  </tr>
</table><?php
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
    <td align="center" colspan="5"><h1><?php echo $text[4009]?></h1></td>
  </tr>
  <tr>
    <td align="center">
      <table class="lmoInner" cellspacing="0" cellpadding="0" border="0">
        <tr>
          <th colspan="4" align="center"><?php echo $text[63]?> </th>
        </tr>
        <tr>
          <td align="right"><?php echo $text[516]; ?></td>
          <td align="right"><?php echo $text[4006]; ?></td>
          <td align="center"><?php echo $text[4008]; ?></td>
          <td align="left"><?php echo $text[4007]; ?></td>
        </tr>
        <tr>
          <td align="right"> <strong><?php echo $ggesamt=$gzusieg1+$gzusieg2+$gzuunent+$gbeide;?></strong></td>
          <td align="right"> <strong><?php echo $gzusieg1?></strong><?php if ($ggesamt>0) {$v=round($gzusieg1/$ggesamt*100);echo " ($v%)";}?> </td>
          <td align="center"> <strong><?php echo $gzuunent?></strong><?php if ($ggesamt>0) {$v=round($gzuunent/$ggesamt*100);echo " ($v%)";}?> </td>
          <td align="left"> <strong><?php echo $gzusieg2?></strong><?php if ($ggesamt>0) {$v=round($gzusieg2/$ggesamt*100);echo " ($v%)";}?> </td>
        </tr><?php
    if ($gbeide>0) {?>
        <tr>
          <td align="right" colspan="2"><?php echo $text[4012];?></td>
          <td colspan="2" align="center"><strong><?php echo $gbeide?></strong><?php if ($ggesamt>0) {$v=round($gbeide/$ggesamt*100);echo " ($v%)";}?></td>
        </tr><?php
    }?>
        <tr>
          <th colspan="4" align="center"><?php echo $text[38]?> </th>
        </tr>
        <tr>
          <td align="right"><?php echo $text[516]?> </td>
          <td align="right"><?php echo $text[41]."-".$text[38]?> </td>
          <td>&nbsp;</td>
          <td align="left"><?php echo $text[42]."-".$text[38]?> </td>
        </tr>
        <tr>
          <td align="right"> <strong><?php echo applyFactor($gzutore,$goalfaktor);?></strong> (<?php echo $text[517]?><?php echo applyFactor($gdstore,$goalfaktor)?>) </td>
          <td align="right"> <strong><?php echo applyFactor($gheimtore,$goalfaktor);?></strong><?php if ($gdstore>0) {$v=round($dsheimtore/$gdstore*100);echo " ($v% ".$text[517].applyFactor($dsheimtore,$goalfaktor).")";}?> </td>
          <td>&nbsp;</td>
          <td align="left"> <strong><?php echo applyFactor($ggasttore,$goalfaktor);?></strong><?php if ($gdstore>0) {echo " (".(100-$v)."% ".$text[517].applyFactor($dsgasttore,$goalfaktor).")";}?> </td>
        </tr><?php
    if ($hheimsiegtor>0) {?>
        <tr>
          <th colspan="4" align="center"><?php echo $text[4013]?></th>
        </tr><tr>
          <td align="right"><?php echo $hheimsieg?> - </td>
          <td align="left"><?php echo $hgastsieg?></td>
          <td colspan="2" align="left"><?php echo applyFactor($hheimsiegtor,$goalfaktor)?>:<?php echo applyFactor($hgastsiegtor,$goalfaktor)?> (<?php echo $spieltagflag?>.<?php echo $text[4014]?>)</td>
        </tr><?php
      if ($hheimsiegtor1>0) {?>
        <tr>
          <td align="right"><?php echo $hheimsieg1?> - </td>
          <td align="left"><?php echo $hgastsieg1?></td>
          <td colspan="2" align="left"><?php echo applyFactor($hheimsiegtor1,$goalfaktor)?>:<?php echo applyFactor($hgastsiegtor1,$goalfaktor)?> (<?php echo $spieltagflag1?>.<?php echo $text[4014]?>)</td>
        </tr><?php
  	    if ($counteranz>2) {
  	      $counteranz0=$counteranz-2;?>
      	<tr>
          <td>&nbsp;</td>
          <td colspan="3" align="right"><small><?php echo $text[4015]?><?php echo $counteranz0?><?php echo $text[4016]?></small></td>
        </tr><?php
  	    }
      }
    }
    if ($agastsiegtor>0) {?>
        <tr>
          <th colspan="4" align="center"><?php echo $text[4017]?></th>
        </tr>
        <tr>
          <td align="right"><?php echo $aheimsieg?> - </td>
          <td align="left"><?php echo $agastsieg?></td>
          <td colspan="2" align="left"><?php echo applyFactor($aheimsiegtor,$goalfaktor)?>:<?php echo applyFactor($agastsiegtor,$goalfaktor)?> (<?php echo $spieltagflag2?>.<?php echo $text[4014]?>)</td>
        </tr>  <?php
      if ($agastsiegtor1>0) {?>
        <tr>
          <td align="right"><?php echo $aheimsieg1?> - </td>
          <td align="left"><?php echo $agastsieg1?></td>
          <td colspan="2" align="left"><?php echo applyFactor($aheimsiegtor1,$goalfaktor)?>:<?php echo applyFactor($agastsiegtor1,$goalfaktor)?>  (<?php echo $spieltagflag3?>.<?php echo $text[4014]?>)</td>
        </tr><?php
  	    if ($counteranz1>2) {
  	      $counteranz4=$counteranz1-2;?>
        <tr>
          <td>&nbsp;</td>
          <td colspan="3" align="right"><small><?php echo $text[4015]?><?php echo $counteranz4?><?php echo $text[4016]?></small></td>
        </tr><?php
  	    }
      }
    }
    if ($spieltagflag4>0) {?>
        <tr>
          <th colspan="4" align="center"><?php echo $text[4018]?><?php echo $text[38]?></th>
        </tr>
        <tr>
          <td align="right"><?php echo $htorreichm1?> - </td>
          <td align="left"><?php echo $htorreichm2?></td>
          <td colspan="2" align="left"><?php echo applyFactor($htorreicht1,$goalfaktor)?>:<?php echo applyFactor($htorreicht2,$goalfaktor)?>  (<?php echo $spieltagflag4?>.<?php echo $text[4014]?>)</td>
        </tr><?php
      if ($spieltagflag5>0) {?>
        <tr>
          <td align="right"><?php echo $htorreichm3?> - </td>
          <td align="left"><?php echo $htorreichm4?></td>
          <td colspan="2" align="left"><?php echo applyFactor($htorreicht3,$goalfaktor)?>:<?php echo applyFactor($htorreicht4,$goalfaktor)?>  (<?php echo $spieltagflag5?>.<?php echo $text[4014]?>)</td>
        </tr><?php
  	    if ($counteranz5>2) {
  	      $counteranz6=$counteranz5-2;?>
    	  <tr>
           <td>&nbsp;</td>
           <td colspan="3" align="right"><small><?php echo $text[4015]?> <?php echo $counteranz6?> <?php echo $text[4019]?></small></td>
         </tr><?php
      	}
      }
    }
    if (isset($akt_gewonnen)) {?>
        <tr>
          <th colspan="4" align="center"><?php echo $text[574]?></th>
        </tr>
        <tr>
          <td colspan="4">
            <table width="100%" cellpadding="3" cellspacing="0">
              <tr>
                <th>&nbsp;</th>
                <th colspan="2"><?php echo $text[580]?></th>
                <th colspan="2"><?php echo $text[581]?></th>
              </tr>
              <tr>
                <th><?php echo $text[575]?></th>
                <td align="right" class="lmoTabelleMeister"><strong><?php echo $akt_gewonnen?></strong>&nbsp;</td>
                <td class="lmoTabelleMeister"><?php echo nl2br($team_akt_gewonnen)?></td>
                <td align="right" class="lmoTabelleMeister"><strong><?php echo $max_gewonnen?></strong>&nbsp;</td>
                <td class="lmoTabelleMeister"><?php echo nl2br($team_max_gewonnen)?></td>
              </tr>
              <tr>
                <th><?php echo $text[576]?></th>
                <td align="right" class="lmoTabelleUefa"><strong><?php echo $akt_ungeschlagen?></strong>&nbsp;</td>
                <td class="lmoTabelleUefa"><?php echo nl2br($team_akt_ungeschlagen)?></td>
                <td align="right" class="lmoTabelleUefa"><strong><?php echo $max_ungeschlagen?></strong>&nbsp;</td>
                <td class="lmoTabelleUefa"><?php echo nl2br($team_max_ungeschlagen)?></td>
              </tr>
              <tr>
                <th><?php echo $text[577]?></th>
                <td align="right"><strong><?php echo $akt_unentschieden?></strong>&nbsp;</td>
                <td><?php echo nl2br($team_akt_unentschieden)?></td>
                <td align="right"><strong><?php echo $max_unentschieden?></strong>&nbsp;</td>
                <td><?php echo nl2br($team_max_unentschieden)?></td>
              </tr>
              <tr>
                <th><?php echo $text[578]?></th>
                <td align="right" class="lmoTabelleRelegation"><strong><?php echo $akt_sieglos?></strong>&nbsp;</td>
                <td class="lmoTabelleRelegation"><?php echo nl2br($team_akt_sieglos)?></td>
                <td align="right" class="lmoTabelleRelegation"><strong><?php echo $max_sieglos?></strong>&nbsp;</td>
                <td class="lmoTabelleRelegation"><?php echo nl2br($team_max_sieglos)?></td>
              </tr>
              <tr>
                <th><?php echo $text[579]?></th>
                <td align="right" class="lmoTabelleAbsteiger"><strong><?php echo $akt_verloren?></strong>&nbsp;</td>
                <td class="lmoTabelleAbsteiger"><?php echo nl2br($team_akt_verloren)?></td>
                <td align="right" class="lmoTabelleAbsteiger"><strong><?php echo $max_verloren?></strong>&nbsp;</td>
                <td class="lmoTabelleAbsteiger"><?php echo nl2br($team_max_verloren)?></td>
              </tr>
            </table>
          </td>
        </tr><?
    }?>
      </table>
    </td>
  </tr>
</table><?php
  } //if (file_exists)
} //if (zustats)
?>
<?php } ?>