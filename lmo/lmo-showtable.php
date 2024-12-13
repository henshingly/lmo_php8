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
  *
  */

if ($minus == 2) {
  $dummy = " colspan=\"3\" align=\"center\"";
} else {
  $dummy = " align=\"right\"";
}
$breite = 11;
if ($minus == 2) {
  $breite = $breite+2;
}
if ($tabonres == 2) {
  $gesamtbreite = 3 * $breite + 11;
} else {
  $gesamtbreite = $breite + 11;
}
?>

<table class="lmoInner" cellspacing="0" cellpadding="0" border="0">
  <caption><?php
if ($einhinrueck==1 || $einheimausw==1) {
  if ($tabtype!=0) {?><a href="<?php echo $addt1."0" ?>" title="<?php echo $text[27]; ?>"><?php echo $text[16]; ?></a><?php } else {echo $text[16];}?>&nbsp;<?php
  if ($tabonres!=2 && $einheimausw==1) {
    if ($tabtype!=1) {?><a href="<?php echo $addt1."1" ?>" title="<?php echo $text[28]; ?>"><?php echo $text[41]; ?></a><?php } else {echo $text[41];}?>&nbsp;<?php
    if ($tabtype!=2) {?><a href="<?php echo $addt1."2" ?>" title="<?php echo $text[29]; ?>"><?php echo $text[42]; ?></a><?php } else {echo $text[42];}?>&nbsp;<?php
  }
  if ($einhinrueck==1) {
    if ($tabtype!=4) {?><a href="<?php echo $addt1."4"?>" title="<?php echo $text[4003]; ?>"><?php echo $text[4003]; ?></a><?php } else {echo $text[4003];}?>&nbsp;<?php
    if ($tabtype!=3) {?><a href="<?php echo $addt1."3"?>" title="<?php echo $text[4002]; ?>"><?php echo $text[4002]; ?></a><?php } else {echo $text[4002];}
  }
}?>
  </caption><?php
/*Inklusive Heim & Auswärts*/
if ($tabonres==2) {?>
  <tr>
    <th style="text-align:left" colspan="7"><?php echo $tabdat; ?>&nbsp;</th>
    <th colspan="<?php echo $breite; ?>">&nbsp;</th>
    <th style="width:2px;">&nbsp;</th>
    <th style="text-align:left" colspan="<?php echo $breite; ?>"><?php echo $text[41]; ?></th>
    <th style="width:2px;">&nbsp;</th>
    <th style="text-align:left" colspan="<?php echo $breite; ?>"><?php echo $text[42]; ?></th>
  </tr><?php
}?>
  <tr>
    <th style="text-align:left" colspan="7"><?php if ($tabonres!=2) {echo $tabdat;}?>&nbsp;</th>
    <th style="text-align:center"><acronym title="<?php echo $text[63];?>"><?php echo $text[33];?></acronym></th>
    <th style="text-align:center"><acronym title="<?php echo $text[199];?>"><?php echo $text[34];?></acronym></th>
<?php
if ($hidr!=1) {?>
    <th style="text-align:right"><acronym title="<?php echo $text[200];?>"><?php echo $text[35];?></acronym></th>
<?php
}?>
    <th style="text-align:enter"><acronym title="<?php echo $text[201];?>"><?php echo $text[36];?></acronym></th>
<?php
if ($tabpkt==0) {?>
    <th style="width:2px;">&nbsp;</th>
    <th <?php echo $dummy ?>><?php echo $text[37]; ?></th><?php
}?>
    <th style="width:2px;">&nbsp;</th>
    <th style="text-align:center" colspan="3"><?php echo $text[38]; ?></th>
    <th style="text-align:right"><?php echo $text[39]; ?></th><?php
if ($tabpkt==1) {?>
    <th style="width:2px;">&nbsp;</th>
    <th <?php echo $dummy?>><?php echo $text[37]; ?></th><?php
}
if ($tabonres==2) {?>
    <th style="width:2px;">&nbsp;</th>
    <th style="text-align:right"><acronym title="<?php echo $text[63];?>"><?php echo $text[33];?></acronym></th>
    <th style="text-align:right"><acronym title="<?php echo $text[199];?>"><?php echo $text[34];?></acronym></th><?php
  if ($hidr!=1) {?>
    <th style="text-align:right"><acronym title="<?php echo $text[200];?>"><?php echo $text[35];?></acronym></th><?php
  } ?>
    <th style="text-align:right"><acronym title="<?php echo $text[201];?>"><?php echo $text[36];?></acronym></th><?php
  if ($tabpkt==0) {?>
    <th style="width:2px;">&nbsp;</th>
    <th <?php echo $dummy?>><?php echo $text[37]; ?></th><?php
  } ?>
    <th style="width:2px;">&nbsp;</th>
    <th colspan="3" align="center"><?php echo $text[38]; ?></th>
    <th style="text-align:right"><?php echo $text[39]; ?></th><?php
  if ($tabpkt==1) {?>
    <th style="width:2px;">&nbsp;</th>
    <th <?php echo $dummy?>><?php echo $text[37]; ?></th><?php
  }?>
    <th style="width:2px;">&nbsp;</th>
    <th style="text-align:right"><acronym title="<?php echo $text[63];?>"><?php echo $text[33];?></acronym></th>
    <th style="text-align:right"><acronym title="<?php echo $text[199];?>"><?php echo $text[34];?></acronym></th><?php
  if ($hidr!=1) {?>
    <th style="text-align:right"><acronym title="<?php echo $text[200];?>"><?php echo $text[35];?></acronym></th><?php
  }?>
    <th style="text-align:right"><acronym title="<?php echo $text[201];?>"><?php echo $text[36];?></acronym></th><?php
  if ($tabpkt==0) {?>
    <th style="width:2px;">&nbsp;</th>
    <th <?php echo $dummy?>><?php echo $text[37]?></th><?php
  }?>
    <th style="width:2px;">&nbsp;</th>
    <th colspan="3" align="center"><?php echo $text[38]; ?></th>
    <th style="text-align:right"><?php echo $text[39]; ?></th><?php
  if ($tabpkt==1) {?>
    <th style="width:2px;">&nbsp;</th>
    <th <?php echo $dummy?>><?php echo $text[37]; ?></th><?php
  }
}?>

  </tr>
<?php
$j = 1;
for ($x = 1; $x <= $anzteams; $x++) {
  $i = intval(substr($tab0[$x-1], 34));
  if ($i == $favteam) {
    $dummy = "<strong>";
    $dumm2 = "</strong>";
  } else {
    $dummy = "";
    $dumm2 = "";
  }
  $lmo_tabelle_class = "nobr";
  if ($tabtype == 0) {
    if (($x == 1) && ($champ != 0)) {
      $lmo_tabelle_class = "lmoTabelleMeister nobr";
      $j = 2;
    }
    if (($x >= $j) && ($x < $j+$anzcl) && ($anzcl > 0)) {
      $lmo_tabelle_class = "lmoTabelleCleague nobr";
    }
    if (($x >= $j+$anzcl) && ($x < $j+$anzcl+$anzck) && ($anzck > 0)) {
      $lmo_tabelle_class = "lmoTabelleCleaguequali nobr";
    }
    if (($x >= $j+$anzcl+$anzck) && ($x < $j+$anzcl+$anzck+$anzuc) && ($anzuc > 0)) {
      $lmo_tabelle_class = "lmoTabelleUefa nobr";
    }
    if (($x <= $anzteams-$anzab) && ($x > $anzteams-$anzab-$anzar) && ($anzar > 0)) {
      $lmo_tabelle_class = "lmoTabelleRelegation nobr";
    }
    if (($x <= $anzteams) && ($x > $anzteams-$anzab) && ($anzab > 0)) {
      $lmo_tabelle_class = "lmoTabelleAbsteiger nobr";
    }

  }?>
  <tr>
    <td class="<?php echo $lmo_tabelle_class; ?>" align="right"><?php echo $dummy.$x.$dumm2; ?></td>
<?php
  $y = 0;
  if ($endtab > 1 && isset($platz0[$i])) {
    if ($platz0[$i] < $platz1[$i]) {
      $y = 1;
    } elseif ($platz0[$i] > $platz1[$i]) {
      $y = 2;
    }
  }?>
    <td class="<?php echo $lmo_tabelle_class ?>"><img src='<?php echo URL_TO_IMGDIR."/lmo-tab".$y.".gif"; ?>' width="9" height="9" border="0" alt='' /></td>
    <td class="<?php echo $lmo_tabelle_class ?>" align="center"><?php echo HTML_smallTeamIcon($file,$teams[$i]," alt=''"); ?></td>
    <td class="<?php echo $lmo_tabelle_class ?>" align="left"><?php
  echo $dummy.$teams[$i].$dumm2;
  if (($teamu[$i] != "") && ($urlt == 1)) {?>
        <a href="<?php echo $teamu[$i]; ?>" target="_blank"><img border="0" title="<?php echo $text[46]; ?>" width="11" src="<?php echo URL_TO_IMGDIR."/url.png";?>" alt="<?php echo $text[564]?>" /></a><?php
  }?></td>
    <td class="<?php echo $lmo_tabelle_class; ?>" style="width:2px;">&nbsp;</td>
    <td class="<?php echo $lmo_tabelle_class; ?>"><?php

  if ($teamn[$i]!="" || $strafp[$i]!=0 || $strafm[$i]!=0 || $torkorrektur1[$i]!=0 || $torkorrektur2[$i]!=0) {
    $lmo_tabellennotiz=HTML_smallTeamIcon($file,$teams[$i]," alt=''");

    /** Notizen anzeigen
     *
     * Achtung: Da beim Speichern Strafpunkte/-tore positiv sind und Bonuspunkte negativ (altes System des LMO)
     * muss mit -1 multipliziert werden, um die Punkte/Tore richtig anzuzeigen
     */

    $lmo_tabellennotiz.=" <strong>".$teams[$i]."</strong>";
    //Straf-/Bonuspunkte
    if ($strafp[$i]!=0 || $strafm[$i]!=0) {
      $lmo_tabellennotiz.="\n\n<strong>".$text[128].":</strong>\n";
      //Punkte
      $lmo_tabellennotiz.=$strafp[$i]<0?"+".((-1)*applyFactor($strafp[$i],$pointsfaktor)):((-1)*applyFactor($strafp[$i],$pointsfaktor));
      //Minuspunkte
      if ($minus==2) {
        $lmo_tabellennotiz.=":".($strafm[$i]<0?"+".((-1)*applyFactor($strafm[$i],$pointsfaktor)):((-1)*applyFactor($strafm[$i],$pointsfaktor)));
      }
      //Ab ST
      if ($strafdat[$i]!=0) $lmo_tabellennotiz.=" ({$text[524]} {$text[2]} {$strafdat[$i]})";
    }
    //Straf-/Bonustore
    if ($torkorrektur1[$i]!=0 || $torkorrektur2[$i]!=0) {
      $lmo_tabellennotiz.="\n<strong>".$text[522].":</strong>\n";
      //Tore
      $lmo_tabellennotiz.=$torkorrektur1[$i]<0?"+".((-1)*applyFactor($torkorrektur1[$i],$goalfaktor)).":":((-1)*applyFactor($torkorrektur1[$i],$goalfaktor)).":";
      //Gegentore
      $lmo_tabellennotiz.=$torkorrektur2[$i]<0?"+".((-1)*applyFactor($torkorrektur2[$i],$goalfaktor)):((-1)*applyFactor($torkorrektur2[$i],$goalfaktor));
      //Ab ST
      if ($strafdat[$i]!=0) $lmo_tabellennotiz.=" ({$text[524]} {$text[2]} {$strafdat[$i]})";
    }
    //Teamnotizen
    if ($teamn[$i]!="") {
      $lmo_tabellennotiz.="\n\n<strong>".$text[22].":</strong>\n".$teamn[$i];
    }?>
      <a href='#' onclick="alert('<?php echo addcslashes('',htmlentities(strip_tags($lmo_tabellennotiz)))?>');window.focus();return FALSE;"><img src='<?php echo URL_TO_IMGDIR."/lmo-st2.svg"?>' height='15' border='0' alt='' /><span class='popup'><?php echo nl2br($lmo_tabellennotiz)?></span></a><?php
    $lmo_tabellennotiz="";
  } else {
    echo "&nbsp;";
  }?></td>
    <td class="<?php echo $lmo_tabelle_class; ?>" style="width:2px;">&nbsp;</td>
    <td class="<?php echo $lmo_tabelle_class; ?>" align="right"><?php echo $dummy.$spiele[$i].$dumm2; ?></td>
    <td class="<?php echo $lmo_tabelle_class; ?>" align="right"><?php echo $dummy.$siege[$i].$dumm2; ?></td><?php
  if ($hidr!=1) {?>
    <td class="<?php echo $lmo_tabelle_class; ?>" align="right"><?php echo $dummy.$unent[$i].$dumm2; ?></td><?php
  } ?>
    <td class="<?php echo $lmo_tabelle_class; ?>" align="right"><?php echo $dummy.$nieder[$i].$dumm2; ?></td><?php
  if ($tabpkt == 0) {?>
    <td class="<?php echo $lmo_tabelle_class; ?>" style="width:2px;">&nbsp;</td>
    <td class="<?php echo $lmo_tabelle_class; ?>" align="right"><strong><?php echo applyFactor($punkte[$i],$pointsfaktor)?></strong></td><?php
    if ($minus == 2) {?>
    <td class="<?php echo $lmo_tabelle_class?>" align="center" style="width:4px;"><strong>:</strong></td>
    <td class="<?php echo $lmo_tabelle_class?>"><strong><?php echo applyFactor($negativ[$i],$pointsfaktor)?></strong></td><?php
    }
  }?>
    <td class="<?php echo $lmo_tabelle_class; ?>" style="width:2px;">&nbsp;</td>
    <td class="<?php echo $lmo_tabelle_class; ?>" align="right"><?php echo $dummy.applyFactor($etore[$i],$goalfaktor).$dumm2; ?></td>
    <td class="<?php echo $lmo_tabelle_class; ?>" align="center" style="width:4px;"><?php echo $dummy; ?>:<?php echo $dumm2; ?></td>
    <td class="<?php echo $lmo_tabelle_class; ?>"><?php echo $dummy.applyFactor($atore[$i],$goalfaktor).$dumm2; ?></td>
    <td class="<?php echo $lmo_tabelle_class; ?>" align="right"><?php echo $dummy.applyFactor($dtore[$i],$goalfaktor).$dumm2; ?></td>
<?php
  if ($tabpkt==1) {?>
    <td class="<?php echo $lmo_tabelle_class; ?>" style="width:2px;">&nbsp;</td>
    <td class="<?php echo $lmo_tabelle_class; ?>" align="right"><strong><?php echo applyFactor($punkte[$i],$pointsfaktor)?></strong></td>
<?php
    if ($minus==2) {?>
    <td class="<?php echo $lmo_tabelle_class; ?>" align="center" style="width:4px;"><strong>:</strong></td>
    <td class="<?php echo $lmo_tabelle_class; ?>"><strong><?php echo applyFactor($negativ[$i],$pointsfaktor)?></strong></td>
<?php
    }
  }
  if ($tabonres==2) {
    $lmo_tabelle_class="lmoTabelleHeimbilanz";?>
    <td class="<?php echo $lmo_tabelle_class; ?>" style="width:2px;">&nbsp;</td>
    <td class="<?php echo $lmo_tabelle_class; ?>" align="right"><?php echo $dummy.$hspiele[$i].$dumm2; ?></td>
    <td class="<?php echo $lmo_tabelle_class; ?>" align="right"><?php echo $dummy.$hsiege[$i].$dumm2; ?></td>
    <td class="<?php echo $lmo_tabelle_class; ?>" align="right"><?php echo $dummy.$hunent[$i].$dumm2; ?></td>
    <td class="<?php echo $lmo_tabelle_class; ?>" align="right"><?php echo $dummy.$hnieder[$i].$dumm2; ?></td><?php
    if ($tabpkt==0) {?>
    <td class="<?php echo $lmo_tabelle_class; ?>" style="width:2px;">&nbsp;</td>
    <td class="<?php echo $lmo_tabelle_class; ?>" align="right"><strong><?php echo applyFactor($hpunkte[$i],$pointsfaktor)?></strong></td><?php
      if ($minus==2) {?>
    <td class="<?php echo $lmo_tabelle_class; ?>" align="center" style="width:4px;"><strong>:</strong></td>
    <td class="<?php echo $lmo_tabelle_class; ?>"><strong><?php echo applyFactor($hnegativ[$i],$pointsfaktor)?></strong></td><?php
      }
    }?>
    <td class="<?php echo $lmo_tabelle_class; ?>" style="width:2px;">&nbsp;</td>
    <td class="<?php echo $lmo_tabelle_class; ?>" align="right"><?php echo $dummy.applyFactor($hetore[$i],$goalfaktor).$dumm2; ?></td>
    <td class="<?php echo $lmo_tabelle_class; ?>" align="center" style="width:4px;"><?php echo $dummy; ?>:<?php echo $dumm2; ?></td>
    <td class="<?php echo $lmo_tabelle_class; ?>"><?php echo $dummy.applyFactor($hatore[$i],$goalfaktor).$dumm2; ?></td>
    <td class="<?php echo $lmo_tabelle_class; ?>" align="right"><?php echo $dummy.applyFactor($hdtore[$i],$goalfaktor).$dumm2; ?></td><?php
    if ($tabpkt==1) {?>
    <td class="<?php echo $lmo_tabelle_class; ?>" style="width:2px;">&nbsp;</td>
    <td class="<?php echo $lmo_tabelle_class; ?>" align="right"><strong><?php echo applyFactor($hpunkte[$i],$pointsfaktor)?></strong></td><?php
      if ($minus==2) {?>
    <td class="<?php echo $lmo_tabelle_class; ?>" align="center" style="width:4px;"><strong>:</strong></td>
    <td class="<?php echo $lmo_tabelle_class; ?>"><strong><?php echo applyFactor($hnegativ[$i],$pointsfaktor)?></strong></td><?php
      }
    }
    $lmo_tabelle_class="lmoTabelleGastbilanz";?>
    <td class="<?php echo $lmo_tabelle_class; ?>" style="width:2px;">&nbsp;</td>
    <td class="<?php echo $lmo_tabelle_class; ?>" align="right"><?php echo $dummy.$aspiele[$i].$dumm2; ?></td>
    <td class="<?php echo $lmo_tabelle_class; ?>" align="right"><?php echo $dummy.$asiege[$i].$dumm2; ?></td>
    <td class="<?php echo $lmo_tabelle_class; ?>" align="right"><?php echo $dummy.$aunent[$i].$dumm2; ?></td>
    <td class="<?php echo $lmo_tabelle_class; ?>" align="right"><?php echo $dummy.$anieder[$i].$dumm2; ?></td><?php
    if ($tabpkt==0) {?>
    <td class="<?php echo $lmo_tabelle_class; ?>" style="width:2px;">&nbsp;</td>
    <td class="<?php echo $lmo_tabelle_class; ?>" align="right"><strong><?php echo applyFactor($apunkte[$i],$pointsfaktor)?></strong></td><?php
      if ($minus==2) {?>
    <td class="<?php echo $lmo_tabelle_class; ?>" align="center" style="width:4px;"><strong>:</strong></td>
    <td class="<?php echo $lmo_tabelle_class; ?>"><strong><?php echo applyFactor($anegativ[$i],$pointsfaktor)?></strong></td><?php
      }
    }?>
    <td class="<?php echo $lmo_tabelle_class; ?>" style="width:2px;">&nbsp;</td>
    <td class="<?php echo $lmo_tabelle_class; ?>" align="right"><?php echo $dummy.applyFactor($aetore[$i],$goalfaktor).$dumm2; ?></td>
    <td class="<?php echo $lmo_tabelle_class; ?>" align="center" style="width:4px;"><?php echo $dummy; ?>:<?php echo $dumm2; ?></td>
    <td class="<?php echo $lmo_tabelle_class; ?>"><?php echo $dummy.applyFactor($aatore[$i],$goalfaktor).$dumm2; ?></td>
    <td class="<?php echo $lmo_tabelle_class; ?>" align="right"><?php echo $dummy.applyFactor($adtore[$i],$goalfaktor).$dumm2; ?></td><?php
    if ($tabpkt==1) {?>
    <td class="<?php echo $lmo_tabelle_class; ?>" style="width:2px;">&nbsp;</td>
    <td class="<?php echo $lmo_tabelle_class; ?>" align="right"><strong><?php echo applyFactor($apunkte[$i],$pointsfaktor)?></strong></td><?php
      if ($minus==2) {?>
    <td class="<?php echo $lmo_tabelle_class; ?>" align="center" style="width:4px;"><strong>:</strong></td>
    <td class="<?php echo $lmo_tabelle_class; ?>"><strong><?php echo applyFactor($anegativ[$i],$pointsfaktor)?></strong></td><?php
      }
    }
  }  /*tabonres==2*/?>

  </tr>
<?php
}/*for*/?>
  <tr>
    <td class="lmoFooter" align="center" colspan="<?php echo $gesamtbreite?>">&nbsp;<?php
if ($einzutoretab == 1) {
  $zustat_file = str_replace(".l98", ".l98.php",  basename($file));
  $zustat_dir = basename($diroutput);
  if (file_exists(PATH_TO_LMO.'/'.$zustat_dir."/".$zustat_file)) {
    require(PATH_TO_LMO.'/'.$zustat_dir."/".$zustat_file);
    echo $text[4000].$text[38].": ".applyFactor($gzutore,$goalfaktor)."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"." ".$text[38]."&nbsp;".$text[4001].": ".applyFactor($gdstore,$goalfaktor);
  }
}?>
    </td>
  </tr>
</table>
