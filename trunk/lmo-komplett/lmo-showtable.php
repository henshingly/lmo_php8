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
}
?>

<table class="lmostb" cellspacing="0" cellpadding="0" border="0">
  <tr>
    <td align="center" colspan="<?=$gesamtbreite?>">
      <table>
        <tr><?
for($i=0;$i<3;$i++){?>
          <td <?
  if($i<>$tabtype){?>
            class="lmost0"><a href="<?=$addt1.$i?>" title="<?=$text[27+$i]?>"><?=$text[40+$i]?></a><?
  }else{?>
            class="lmost1"><?=$text[40+$i]?><?
  }?>&nbsp;
          </td><?
}
if ($einhinrueck==1) {?>
          <td <?
  $i++;
  if($i<>$tabtype){?>
             class="lmost0"><a href="<?=$_SERVER['PHP_SELF']."?action=table&amp;file=".$file."&amp;tabtype=".$i?>" title="<?=$text[4003]?>"><?=$text[4003]?></a><?
  }else{?>
             class="lmost1"><?=$text[4003]?><?
  }?>&nbsp;
          </td>
          <td <?
  $i--;
  if($i<>$tabtype){?>
                 class="lmost0"><a href="<?=$_SERVER['PHP_SELF']."?action=table&amp;file=".$file."&amp;tabtype=".$i?>" title="<?=$text[4002]?>"><?=$text[4002]?></a><?
  }else{?>
                 class="lmost1"><?=$text[4002]?><?
  }?>&nbsp;
          </td><?
}?>
        </tr>
      </table>
    </td>
  </tr><?

/*Inklusive Heim & Auswärts*/
if($tabonres==2){?>
  <tr>
    <td class="lmost4" colspan="7"><?=$st.". ".$text[2];?>&nbsp;</td>
    <td class="lmost4" colspan="<?=$breite; ?>">&nbsp;</td>
    <td class="lmost4" width="2">&nbsp;</td>
    <td class="lmost4" colspan="<?=$breite; ?>"><?=$text[41]; ?></td>
    <td class="lmost4" width="2">&nbsp;</td>
    <td class="lmost4" colspan="<?=$breite; ?>"><?=$text[42]; ?></td>
  </tr><? 
}?>
  <tr>
    <td class="lmost4" colspan="7"><?if($tabonres!=2){echo $st.". ".$text[2];}?>&nbsp;</td>
    <td class="lmost4" align="right"><?=$text[33]; ?></td>
    <td class="lmost4" align="right"><?=$text[34]; ?></td><?  
if($hidr!=1){?>
    <td class="lmost4" align="right"><?=$text[35]; ?></td><?
}?>
    <td class="lmost4" align="right"><?=$text[36]; ?></td><?  
if($tabpkt==0){?>
    <td class="lmost4" width="2">&nbsp;</td>
    <td class="lmost4" <?=$dummy?>><?=$text[37]?></td><? 
}?>
    <td class="lmost4" width="2">&nbsp;</td>
    <td class="lmost4" colspan="3" align="center"><?=$text[38]; ?></td>
    <td class="lmost4" align="right"><?=$text[39]; ?></td><?
if($tabpkt==1){?>
    <td class="lmost4" width="2">&nbsp;</td>
    <td class="lmost4" <?=$dummy?>><?=$text[37]?></td><? 
}
if($tabonres==2){?>
    <td class="lmost4" width="2">&nbsp;</td>
    <td class="lmost4" align="right"><?=$text[33]; ?></td>
    <td class="lmost4" align="right"><?=$text[34]; ?></td><?
  if($hidr!=1){?>
    <td class="lmost4" align="right"><?=$text[35]?></td><? 
  } ?>
    <td class="lmost4" align="right"><?=$text[36]; ?></td><?  
  if($tabpkt==0){?>
    <td class="lmost4" width="2">&nbsp;</td>
    <td class="lmost4" <?=$dummy?>><?=$text[37]?></td><? 
  } ?>
    <td class="lmost4" width="2">&nbsp;</td>
    <td class="lmost4" colspan="3" align="center"><?=$text[38]; ?></td>
    <td class="lmost4" align="right"><?=$text[39]; ?></td><?  
  if($tabpkt==1){?>
    <td class="lmost4" width="2">&nbsp;</td>
    <td class="lmost4" <?=$dummy?>><?=$text[37]?></td><? 
  }?>
    <td class="lmost4" width="2">&nbsp;</td>
    <td class="lmost4" align="right"><?=$text[33]; ?></td>
    <td class="lmost4" align="right"><?=$text[34]; ?></td><?  
  if($hidr!=1){?>
    <td class="lmost4" align="right"><?=$text[35]?></td><? 
  }?>
    <td class="lmost4" align="right"><?=$text[36]; ?></td><?  
  if($tabpkt==0){?>
    <td class="lmost4" width="2">&nbsp;</td>
    <td class="lmost4" <?=$dummy?>><?=$text[37]?></td><? 
  }?>
    <td class="lmost4" width="2">&nbsp;</td>
    <td class="lmost4" colspan="3" align="center"><?=$text[38]; ?></td>
    <td class="lmost4" align="right"><?=$text[39]; ?></td><?  
  if($tabpkt==1){?>
    <td class="lmost4" width="2">&nbsp;</td>
    <td class="lmost4" <?=$dummy?>><?=$text[37]?></td><? 
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
  $dumm1 = "lmost5";
  if ($tabtype == 0) {
    if (($x == 1) && ($champ != 0)) {
      $dumm1 = "lmotab1";
      $j = 2;
    }
    if (($x >= $j) && ($x < $j+$anzcl) && ($anzcl > 0)) {
      $dumm1 = "lmotab2";
    }
    if (($x >= $j+$anzcl) && ($x < $j+$anzcl+$anzck) && ($anzck > 0)) {
      $dumm1 = "lmotab3";
    }
    if (($x >= $j+$anzcl+$anzck) && ($x < $j+$anzcl+$anzck+$anzuc) && ($anzuc > 0)) {
      $dumm1 = "lmotab4";
    }
    if (($x <= $anzteams) && ($x > $anzteams-$anzab) && ($anzab > 0)) {
      $dumm1 = "lmotab5";
    }
    if (($x <= $anzteams-$anzab) && ($x > $anzteams-$anzab-$anzar) && ($anzar > 0)) {
      $dumm1 = "lmotab8";
    }
  }?>
  <tr>
    <td class="<?=$dumm1; ?>" align="right"><?=$dummy.$x.$dumm2; ?></td><? 
  $y = 0;
  if ($endtab > 1) {
    if ($platz0[$i] < $platz1[$i]) {
      $y = 1;
    } elseif($platz0[$i] > $platz1[$i]) {
      $y = 2;
    }
  }?>
    <td class="<?=$dumm1?>"><img src='<?=URL_TO_IMGDIR."/lmo-tab".$y.".gif";?>' width="9" height="9" border="0" alt=''></td>
    <td class="<?=$dumm1?>" align="center"><?
  if (file_exists(PATH_TO_IMGDIR."/teams/small/".$teams[$i].".gif")) {
    $imgdata=getimagesize(PATH_TO_IMGDIR."/teams/small/".$teams[$i].".gif");?>
      <img border="0" src="<?=URL_TO_IMGDIR."/teams/small/".rawurlencode($teams[$i])?>.gif" <?=$imgdata[3]?> alt=""><?
  }?>
    </td>
    <td class="<?=$dumm1; ?>" align="left">
      <nobr><? 
  if (($teamu[$i] != "") && ($urlt == 1)) {?>
        <a href="<?=$teamu[$i]?>" target="_blank" title="<?=$text[46]?>"><?
  }
  echo $dummy.$teams[$i].$dumm2;
  if (($teamu[$i] != "") && ($urlt == 1)) {?>
        </a><?
  }?>
      </nobr>
    </td>
    <td class="<?=$dumm1; ?>" width="2">&nbsp;</td>
    <td class="<?=$dumm1; ?>"><? 
    
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
      <a href='#' onclick="alert('<?=mysql_escape_string(strip_tags($lmo_tabellennotiz))?>');window.focus();return false;"><img src='<?=URL_TO_IMGDIR."/lmo-st2.gif"?>' width='10' height='12' border='0' alt=''><span class='popup'><!--[if IE]><table><tr><td style=\"width: 25em\"><![endif]--><?=nl2br($lmo_tabellennotiz)?><!--[if IE]></table><![endif]--></span></a><?
  } else {
    echo "&nbsp;";
  }?>
    </td>
    <td class="<?=$dumm1; ?>" width="2">&nbsp;</td>
    <td class="<?=$dumm1; ?>" align="right"><?=$dummy.$spiele[$i].$dumm2; ?></td>
    <td class="<?=$dumm1; ?>" align="right"><?=$dummy.$siege[$i].$dumm2; ?></td><?
  if($hidr!=1){ ?>
    <td class="<?=$dumm1; ?>" align="right"><?=$dummy.$unent[$i].$dumm2; ?></td><? 
  } ?>
    <td class="<?=$dumm1; ?>" align="right"><?=$dummy.$nieder[$i].$dumm2; ?></td><? 
  if ($tabpkt == 0) {?>
    <td class="<?=$dumm1?>" width="2">&nbsp;</td>
    <td class="<?=$dumm1?>" align="right"><strong><?=$punkte[$i]?></strong></td><?
    if ($minus == 2) {?>
    <td class="<?=$dumm1?>" align="center" width="4"><strong>:</strong></td>
    <td class="<?=$dumm1?>"><strong><?=$negativ[$i]?></strong></td><?
    }
  }?>
      
    <td class="<?=$dumm1; ?>" width="2">&nbsp;</td>
    <td class="<?=$dumm1; ?>" align="right"><?=$dummy.$etore[$i].$dumm2; ?></td>
    <td class="<?=$dumm1; ?>" align="center" width="4"><?=$dummy; ?>:<?=$dumm2; ?></td>
    <td class="<?=$dumm1; ?>"><?=$dummy.$atore[$i].$dumm2; ?></td>
    <td class="<?=$dumm1; ?>" align="right"><?=$dummy.$dtore[$i].$dumm2; ?></td><? 
  if($tabpkt==1){?>
    <td class="<?=$dumm1?>" width="2">&nbsp;</td>
    <td class="<?=$dumm1?>" align="right"><strong><?=$punkte[$i]?></strong></td><?
    if($minus==2){?>
    <td class=" <?=$dumm1?>" align="center" width="4"><strong>:</strong></td>
    <td class=" <?=$dumm1?>"><strong><?=$negativ[$i]?></strong></td><?
    }
  }
  if($tabonres==2){
    $dumm1="lmotab6";?>
    <td class="<?=$dumm1; ?>" width="2">&nbsp;</td>
    <td class="<?=$dumm1; ?>" align="right"><?=$dummy.$hspiele[$i].$dumm2; ?></td>
    <td class="<?=$dumm1; ?>" align="right"><?=$dummy.$hsiege[$i].$dumm2; ?></td>
    <td class="<?=$dumm1; ?>" align="right"><?=$dummy.$hunent[$i].$dumm2; ?></td>
    <td class="<?=$dumm1; ?>" align="right"><?=$dummy.$hnieder[$i].$dumm2; ?></td><? 
    if($tabpkt==0){?>
    <td class="<?=$dumm1?>" width="2">&nbsp;</td><td class="<?=$dumm1?>" align="right"><strong><?=$hpunkte[$i]?></strong></td><?
      if($minus==2){?>
    <td class="<?=$dumm1?>" align="center" width="4"><strong>:</strong></td>
    <td class="<?=$dumm1?>"><strong><?=$hnegativ[$i]?></strong></td><?
      }
    }?>
    <td class="<?=$dumm1; ?>" width="2">&nbsp;</td>
    <td class="<?=$dumm1; ?>" align="right"><?=$dummy.$hetore[$i].$dumm2; ?></td>
    <td class="<?=$dumm1; ?>" align="center" width="4"><?=$dummy; ?>:<?=$dumm2; ?></td>
    <td class="<?=$dumm1; ?>"><?=$dummy.$hatore[$i].$dumm2; ?></td>
    <td class="<?=$dumm1; ?>" align="right"><?=$dummy.$hdtore[$i].$dumm2; ?></td><? 
    if($tabpkt==1){?>
    <td class="<?=$dumm1?>" width="2">&nbsp;</td><td class="<?=$dumm1?>" align="right"><strong><?=$hpunkte[$i]?></strong></td><?
      if($minus==2){?>
    <td class="<?=$dumm1?>" align="center" width="4"><strong>:</strong></td>
    <td class="<?=$dumm1?>"><strong><?=$hnegativ[$i]?></strong></td><?
      }
    }
    $dumm1="lmotab7";?>
    <td class="<?=$dumm1; ?>" width="2">&nbsp;</td>
    <td class="<?=$dumm1; ?>" align="right"><?=$dummy.$aspiele[$i].$dumm2; ?></td>
    <td class="<?=$dumm1; ?>" align="right"><?=$dummy.$asiege[$i].$dumm2; ?></td>
    <td class="<?=$dumm1; ?>" align="right"><?=$dummy.$aunent[$i].$dumm2; ?></td>
    <td class="<?=$dumm1; ?>" align="right"><?=$dummy.$anieder[$i].$dumm2; ?></td><? 
    if($tabpkt==0){?>
    <td class="<?=$dumm1?>" width="2">&nbsp;</td><td class="<?=$dumm1?>" align="right"><strong><?=$apunkte[$i]?></strong></td><?
      if($minus==2){?>
    <td class="<?=$dumm1?>" align="center" width="4"><strong>:</strong></td>
    <td class="<?=$dumm1?>"><strong><?=$anegativ[$i]?></strong></td><?
      }
    }?>
    <td class="<?=$dumm1; ?>" width="2">&nbsp;</td>
    <td class="<?=$dumm1; ?>" align="right"><?=$dummy.$aetore[$i].$dumm2; ?></td>
    <td class="<?=$dumm1; ?>" align="center" width="4"><?=$dummy; ?>:<?=$dumm2; ?></td>
    <td class="<?=$dumm1; ?>"><?=$dummy.$aatore[$i].$dumm2; ?></td>
    <td class="<?=$dumm1; ?>" align="right"><?=$dummy.$adtore[$i].$dumm2; ?></td><? 
    if($tabpkt==1){?>
    <td class="<?=$dumm1?>" width="2">&nbsp;</td><td class="<?=$dumm1?>" align="right"><strong><?=$apunkte[$i]?></strong></td><?
      if($minus==2){?>
    <td class="<?=$dumm1?>" align="center" width="4"><strong>:</strong></td>
    <td class="<?=$dumm1?>"><strong><?=$anegativ[$i]?></strong></td><?
      }
    }
  }  /*tabonres==2*/?>
  </tr><?
}/*for*/?>
  <tr>  
    <td class="lmomain2" align="center" width="100%" colspan="<?=$gesamtbreite?>"><?  

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