<? 
if ($minus == 2) {
  $dummy = " colspan=\"3\" align=\"center\"";
} else {
  $dummy = " align=\"right\"";
}
$breite = 11;
if ($minus == 2) {
  $breite = $breite+2;
}
if($tabonres==2){
  $gesamtbreite=3*$breite+11;
}else{
  $gesamtbreite=$breite+11;
}?>

<table class="lmoInner" cellspacing="0" cellpadding="0" border="0">
  <caption><?
if($tabtype!="0"){?><a href="<?=$addt1."0"?>" title="<?=$text[27]?>"><?=$text[40]?></a><?}else{echo $text[40];}?>&nbsp;<?
if($tabonres!=2){
  if($tabtype!="1"){?><a href="<?=$addt1."1"?>" title="<?=$text[28]?>"><?=$text[41]?></a><?}else{echo $text[41];}?>&nbsp;<?
  if($tabtype!="2"){?><a href="<?=$addt1."2"?>" title="<?=$text[29]?>"><?=$text[42]?></a><?}else{echo $text[42];}?>&nbsp;<?
}
if ($einhinrueck==1) {
  if($tabtype!="4"){?><a href="<?=$addt1."4"?>" title="<?=$text[4003]?>"><?=$text[4003]?></a><?}else{echo $text[4003];}?>&nbsp;<?
  if($tabtype!="3"){?><a href="<?=$addt1."3"?>" title="<?=$text[4002]?>"><?=$text[4002]?></a><?}else{echo $text[4002];}
}?>
  </caption><?
/*Inklusive Heim & Auswärts*/
if($tabonres==2){?>
  <tr>
    <th align="left" colspan="7"><?=$st.". ".$text[2];?>&nbsp;</th>
    <th colspan="<?=$breite; ?>">&nbsp;</th>
    <th width="2">&nbsp;</th>
    <th align="left" colspan="<?=$breite; ?>"><?=$text[41]; ?></th>
    <th width="2">&nbsp;</th>
    <th align="left" colspan="<?=$breite; ?>"><?=$text[42]; ?></th>
  </tr><? 
}?>
  <tr>
    <th align="left" colspan="7"><?if($tabonres!=2){echo $st.". ".$text[2];}?>&nbsp;</th>
    <th align="right"><?=$text[33]; ?></th>
    <th align="right"><?=$text[34]; ?></th><?  
if($hidr!=1){?>
    <th align="right"><?=$text[35]; ?></th><?
}?>
    <th align="right"><?=$text[36]; ?></th><?  
if($tabpkt==0){?>
    <th width="2">&nbsp;</th>
    <th <?=$dummy?>><?=$text[37]?></th><? 
}?>
    <th width="2">&nbsp;</th>
    <th colspan="3" align="center"><?=$text[38]; ?></th>
    <th align="right"><?=$text[39]; ?></th><?
if($tabpkt==1){?>
    <th width="2">&nbsp;</th>
    <th <?=$dummy?>><?=$text[37]?></th><? 
}
if($tabonres==2){?>
    <th width="2">&nbsp;</th>
    <th align="right"><?=$text[33]; ?></th>
    <th align="right"><?=$text[34]; ?></th><?
  if($hidr!=1){?>
    <th align="right"><?=$text[35]?></th><? 
  } ?>
    <th align="right"><?=$text[36]; ?></th><?  
  if($tabpkt==0){?>
    <th width="2">&nbsp;</th>
    <th <?=$dummy?>><?=$text[37]?></th><? 
  } ?>
    <th width="2">&nbsp;</th>
    <th colspan="3" align="center"><?=$text[38]; ?></th>
    <th align="right"><?=$text[39]; ?></th><?  
  if($tabpkt==1){?>
    <th width="2">&nbsp;</th>
    <th <?=$dummy?>><?=$text[37]?></th><? 
  }?>
    <th width="2">&nbsp;</th>
    <th align="right"><?=$text[33]; ?></th>
    <th align="right"><?=$text[34]; ?></th><?  
  if($hidr!=1){?>
    <th align="right"><?=$text[35]?></th><? 
  }?>
    <th align="right"><?=$text[36]; ?></th><?  
  if($tabpkt==0){?>
    <th width="2">&nbsp;</th>
    <th<?=$dummy?>><?=$text[37]?></th><? 
  }?>
    <th width="2">&nbsp;</th>
    <th colspan="3" align="center"><?=$text[38]; ?></th>
    <th align="right"><?=$text[39]; ?></th><?  
  if($tabpkt==1){?>
    <th width="2">&nbsp;</th>
    <th <?=$dummy?>><?=$text[37]?></th><? 
  }
}?>
  </tr><?
   
$j = 1;
for($x = 1; $x <= $anzteams; $x++) {
  $i = intval(substr($tab0[$x-1], 34));
  if ($i == $favteam) {
    $dummy = "<strong>";
    $dumm2 = "</strong>";
  } else {
    $dummy = "";
    $dumm2 = "";
  }
  $lmo_tabelle_class = "lmost5";
  if ($tabtype == 0) {
    if (($x == 1) && ($champ != 0)) {
      $lmo_tabelle_class = "lmoTabelleMeister";
      $j = 2;
    }
    if (($x >= $j) && ($x < $j+$anzcl) && ($anzcl > 0)) {
      $lmo_tabelle_class = "lmoTabelleCleague";
    }
    if (($x >= $j+$anzcl) && ($x < $j+$anzcl+$anzck) && ($anzck > 0)) {
      $lmo_tabelle_class = "lmoTabelleCleaguequali";
    }
    if (($x >= $j+$anzcl+$anzck) && ($x < $j+$anzcl+$anzck+$anzuc) && ($anzuc > 0)) {
      $lmo_tabelle_class = "lmoTabelleUefa";
    }
    if (($x <= $anzteams-$anzab) && ($x > $anzteams-$anzab-$anzar) && ($anzar > 0)) {
      $lmo_tabelle_class = "lmoTabelleRelegation";
    }
    if (($x <= $anzteams) && ($x > $anzteams-$anzab) && ($anzab > 0)) {
      $lmo_tabelle_class = "lmoTabelleAbsteiger";
    }
    
  }?>
  <tr>
    <td class="<?=$lmo_tabelle_class; ?>" align="right"><?=$dummy.$x.$dumm2; ?></td><? 
  $y = 0;
  if ($endtab > 1) {
    if ($platz0[$i] < $platz1[$i]) {
      $y = 1;
    } elseif($platz0[$i] > $platz1[$i]) {
      $y = 2;
    }
  }?>
    <td class="<?=$lmo_tabelle_class?>"><img src='<?=URL_TO_IMGDIR."/lmo-tab".$y.".gif";?>' width="9" height="9" border="0" alt=''></td>
    <td class="<?=$lmo_tabelle_class?>" align="center"><?
  if (file_exists(PATH_TO_IMGDIR."/teams/small/".$teams[$i].".gif")) {
    $imgdata=getimagesize(PATH_TO_IMGDIR."/teams/small/".$teams[$i].".gif");?>
      <img border="0" src="<?=URL_TO_IMGDIR."/teams/small/".rawurlencode($teams[$i])?>.gif" <?=$imgdata[3]?> alt=""><?
  }?>
    </td>
    <td class="<?=$lmo_tabelle_class; ?> nobr" align="left"><? 
  echo $dummy.$teams[$i].$dumm2;
  if (($teamu[$i] != "") && ($urlt == 1)) {?>
        <a href="<?=$teamu[$i]?>" target="_blank" title="<?=$text[46]?>">»</a><?
  }?>
  
    </td>
    <td class="<?=$lmo_tabelle_class; ?>" width="2">&nbsp;</td>
    <td class="<?=$lmo_tabelle_class; ?>"><? 
    
  if ($teamn[$i]!="" || $strafp[$i]!=0 || $strafm[$i]!=0 || $torkorrektur1[$i]!=0 || $torkorrektur2[$i]!=0) {
    if (file_exists(PATH_TO_IMGDIR."/teams/small/".$teams[$i].".gif")) {
      $imgdata=getimagesize(PATH_TO_IMGDIR."/teams/small/".$teams[$i].".gif");
      $lmo_tabellennotiz="<img border='0' src='".URL_TO_IMGDIR."/teams/small/".rawurlencode($teams[$i]).".gif' {$imgdata[3]} alt=''>";
    }
    
    /** Notizen anzeigen
     *
     * Achtung: Da beim Speichern Strafpunkte/-tore positiv sind und Bonuspunkte negativ (altes System des LMO)
     * muss mit -1 multipliziert werden, um die Punkte/Tore richtig anzuzeigen
     */
    
    $lmo_tabellennotiz.=" <strong>".$teams[$i]."</strong>";
    //Straf-/Bonuspunkte
    if ($strafp[$i]!=0 || $strafm[$i]!=0) {
      $lmo_tabellennotiz.="\n\n<strong>".$text[128].":</strong> ";
      //Punkte
      $lmo_tabellennotiz.=$strafp[$i]<0?"+".((-1)*$strafp[$i]):((-1)*$strafp[$i]);
      //Minuspunkte
      if ($minus==2) {
        $lmo_tabellennotiz.=":".$strafm[$i]<0?"+".((-1)*$strafm[$i]):((-1)*$strafm[$i]);
      }
      //Ab ST
      if ($strafdat[$i]!=0) $lmo_tabellennotiz.=" ({$text[524]} {$text[145]} {$strafdat[$i]})";
    }
    //Straf-/Bonustore
    if ($torkorrektur1[$i]!=0 || $torkorrektur2[$i]!=0) {
      $lmo_tabellennotiz.="\n<strong>".$text[522].":</strong> ";
      //Tore
      $lmo_tabellennotiz.=$torkorrektur1[$i]<0?"+".((-1)*$torkorrektur1[$i]).":":((-1)*$torkorrektur1[$i].":");
      //Gegentore
      $lmo_tabellennotiz.=$torkorrektur2[$i]<0?"+".((-1)*$torkorrektur2[$i]):((-1)*$torkorrektur2[$i]);
      //Ab ST
      if ($strafdat[$i]!=0) $lmo_tabellennotiz.=" ({$text[524]} {$text[145]} {$strafdat[$i]})";
    }
    //Teamnotizen
    if ($teamn[$i]!="") {
      $lmo_tabellennotiz.="\n\n<strong>".$text[22].":</strong> ".$teamn[$i];
    }?>
      <a href='#' onclick="alert('<?=mysql_escape_string(strip_tags($lmo_tabellennotiz))?>');window.focus();return false;"><img src='<?=URL_TO_IMGDIR."/lmo-st2.gif"?>' width='10' height='12' border='0' alt=''><span class='popup'><!--[if IE]><table><tr><td style=\"width: 25em\"><![endif]--><?=nl2br($lmo_tabellennotiz)?><!--[if IE]></td></tr></table><![endif]--></span></a><?
    $lmo_tabellennotiz="";
  } else {
    echo "&nbsp;";
  }?>
    </td>
    <td class="<?=$lmo_tabelle_class; ?>" width="2">&nbsp;</td>
    <td class="<?=$lmo_tabelle_class; ?>" align="right"><?=$dummy.$spiele[$i].$dumm2; ?></td>
    <td class="<?=$lmo_tabelle_class; ?>" align="right"><?=$dummy.$siege[$i].$dumm2; ?></td><?
  if($hidr!=1){ ?>
    <td class="<?=$lmo_tabelle_class; ?>" align="right"><?=$dummy.$unent[$i].$dumm2; ?></td><? 
  } ?>
    <td class="<?=$lmo_tabelle_class; ?>" align="right"><?=$dummy.$nieder[$i].$dumm2; ?></td><? 
  if ($tabpkt == 0) {?>
    <td class="<?=$lmo_tabelle_class?>" width="2">&nbsp;</td>
    <td class="<?=$lmo_tabelle_class?>" align="right"><strong><?=$punkte[$i]?></strong></td><?
    if ($minus == 2) {?>
    <td class="<?=$lmo_tabelle_class?>" align="center" width="4"><strong>:</strong></td>
    <td class="<?=$lmo_tabelle_class?>"><strong><?=$negativ[$i]?></strong></td><?
    }
  }?>
      
    <td class="<?=$lmo_tabelle_class; ?>" width="2">&nbsp;</td>
    <td class="<?=$lmo_tabelle_class; ?>" align="right"><?=$dummy.$etore[$i].$dumm2; ?></td>
    <td class="<?=$lmo_tabelle_class; ?>" align="center" width="4"><?=$dummy; ?>:<?=$dumm2; ?></td>
    <td class="<?=$lmo_tabelle_class; ?>"><?=$dummy.$atore[$i].$dumm2; ?></td>
    <td class="<?=$lmo_tabelle_class; ?>" align="right"><?=$dummy.$dtore[$i].$dumm2; ?></td><? 
  if($tabpkt==1){?>
    <td class="<?=$lmo_tabelle_class?>" width="2">&nbsp;</td>
    <td class="<?=$lmo_tabelle_class?>" align="right"><strong><?=$punkte[$i]?></strong></td><?
    if($minus==2){?>
    <td class=" <?=$lmo_tabelle_class?>" align="center" width="4"><strong>:</strong></td>
    <td class=" <?=$lmo_tabelle_class?>"><strong><?=$negativ[$i]?></strong></td><?
    }
  }
  if($tabonres==2){
    $lmo_tabelle_class="lmoTabelleHeimbilanz";?>
    <td class="<?=$lmo_tabelle_class; ?>" width="2">&nbsp;</td>
    <td class="<?=$lmo_tabelle_class; ?>" align="right"><?=$dummy.$hspiele[$i].$dumm2; ?></td>
    <td class="<?=$lmo_tabelle_class; ?>" align="right"><?=$dummy.$hsiege[$i].$dumm2; ?></td>
    <td class="<?=$lmo_tabelle_class; ?>" align="right"><?=$dummy.$hunent[$i].$dumm2; ?></td>
    <td class="<?=$lmo_tabelle_class; ?>" align="right"><?=$dummy.$hnieder[$i].$dumm2; ?></td><? 
    if($tabpkt==0){?>
    <td class="<?=$lmo_tabelle_class?>" width="2">&nbsp;</td><td class="<?=$lmo_tabelle_class?>" align="right"><strong><?=$hpunkte[$i]?></strong></td><?
      if($minus==2){?>
    <td class="<?=$lmo_tabelle_class?>" align="center" width="4"><strong>:</strong></td>
    <td class="<?=$lmo_tabelle_class?>"><strong><?=$hnegativ[$i]?></strong></td><?
      }
    }?>
    <td class="<?=$lmo_tabelle_class; ?>" width="2">&nbsp;</td>
    <td class="<?=$lmo_tabelle_class; ?>" align="right"><?=$dummy.$hetore[$i].$dumm2; ?></td>
    <td class="<?=$lmo_tabelle_class; ?>" align="center" width="4"><?=$dummy; ?>:<?=$dumm2; ?></td>
    <td class="<?=$lmo_tabelle_class; ?>"><?=$dummy.$hatore[$i].$dumm2; ?></td>
    <td class="<?=$lmo_tabelle_class; ?>" align="right"><?=$dummy.$hdtore[$i].$dumm2; ?></td><? 
    if($tabpkt==1){?>
    <td class="<?=$lmo_tabelle_class?>" width="2">&nbsp;</td><td class="<?=$lmo_tabelle_class?>" align="right"><strong><?=$hpunkte[$i]?></strong></td><?
      if($minus==2){?>
    <td class="<?=$lmo_tabelle_class?>" align="center" width="4"><strong>:</strong></td>
    <td class="<?=$lmo_tabelle_class?>"><strong><?=$hnegativ[$i]?></strong></td><?
      }
    }
    $lmo_tabelle_class="lmoTabelleGastbilanz";?>
    <td class="<?=$lmo_tabelle_class; ?>" width="2">&nbsp;</td>
    <td class="<?=$lmo_tabelle_class; ?>" align="right"><?=$dummy.$aspiele[$i].$dumm2; ?></td>
    <td class="<?=$lmo_tabelle_class; ?>" align="right"><?=$dummy.$asiege[$i].$dumm2; ?></td>
    <td class="<?=$lmo_tabelle_class; ?>" align="right"><?=$dummy.$aunent[$i].$dumm2; ?></td>
    <td class="<?=$lmo_tabelle_class; ?>" align="right"><?=$dummy.$anieder[$i].$dumm2; ?></td><? 
    if($tabpkt==0){?>
    <td class="<?=$lmo_tabelle_class?>" width="2">&nbsp;</td><td class="<?=$lmo_tabelle_class?>" align="right"><strong><?=$apunkte[$i]?></strong></td><?
      if($minus==2){?>
    <td class="<?=$lmo_tabelle_class?>" align="center" width="4"><strong>:</strong></td>
    <td class="<?=$lmo_tabelle_class?>"><strong><?=$anegativ[$i]?></strong></td><?
      }
    }?>
    <td class="<?=$lmo_tabelle_class; ?>" width="2">&nbsp;</td>
    <td class="<?=$lmo_tabelle_class; ?>" align="right"><?=$dummy.$aetore[$i].$dumm2; ?></td>
    <td class="<?=$lmo_tabelle_class; ?>" align="center" width="4"><?=$dummy; ?>:<?=$dumm2; ?></td>
    <td class="<?=$lmo_tabelle_class; ?>"><?=$dummy.$aatore[$i].$dumm2; ?></td>
    <td class="<?=$lmo_tabelle_class; ?>" align="right"><?=$dummy.$adtore[$i].$dumm2; ?></td><? 
    if($tabpkt==1){?>
    <td class="<?=$lmo_tabelle_class?>" width="2">&nbsp;</td><td class="<?=$lmo_tabelle_class?>" align="right"><strong><?=$apunkte[$i]?></strong></td><?
      if($minus==2){?>
    <td class="<?=$lmo_tabelle_class?>" align="center" width="4"><strong>:</strong></td>
    <td class="<?=$lmo_tabelle_class?>"><strong><?=$anegativ[$i]?></strong></td><?
      }
    }
  }  /*tabonres==2*/?>
  </tr><?
}/*for*/?>
  <tr>  
    <td class="lmoFooter" align="center" width="100%" colspan="<?=$gesamtbreite?>"><?  

if ($einzutoretab == 1) {
  $strs = ".l98";
  $stre = ".l98.php";
  $str = basename($file);
  $file16 = str_replace($strs, $stre, $str);
  $temp11 = basename($diroutput);
  if (file_exists("$temp11/$file16")) {
    require("$temp11/$file16");
     
    echo $text[4000].$text[38].": ".$gzutore."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"." ".$text[38]."&nbsp;".$text[4001].": ".$gdstore;
     
  }
}?>
    </td>
  </tr>
</table>