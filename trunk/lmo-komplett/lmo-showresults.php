<table class="lmoInner" cellspacing="0" cellpadding="0" border="0">
  <tr>
    <th colspan="<?=$breite; ?>" align="left"><?
echo $st.". ".$text[2];
if($dats==1){ 
  if($datum1[$st-1]!=""){
    echo " ".$text[3]." ".$datum1[$st-1];
  }
  if($datum2[$st-1]!=""){
    echo " ".$text[4]." ".$datum2[$st-1];
  }
}?>
    </th>
  </tr><?
   
$datsort = $mterm[$st-1];
asort($datsort);
reset($datsort);
$spielfreia=array();
$spielfreib=array();
while (list ($key, $val) = each ($datsort)) {
  $i = $key;
  if (($teama[$st-1][$i] > 0) && ($teamb[$st-1][$i] > 0)) {?>
  <tr><?
    if ($datm == 1) {
      if ($mterm[$st-1][$i] > 0) {
        $dum1 = strftime($datf, $mterm[$st-1][$i]);
      } else {
        $dum1 = "";
      }?>
    <td class="nobr"><?=$dum1; ?></td><?  
    }

    /* Spielfrei-Hack-Beginn1*/
  	//if (($anzteams-($anzst/2+1))==0){
    	$spielfreia[$i]=$teama[$st-1][$i];
    	$spielfreib[$i]=$teamb[$st-1][$i];
  	//}
    /* Spielfrei-Hack-Ende1*/ ?>

    <td width="2">&nbsp;</td>
    <td class="nobr" align="right"><?
 
    echo "<a href=\"".$addp.$teama[$st-1][$i]."\" title=\"".$text[269]."\">";
    if (($favteam > 0) && ($favteam == $teama[$st-1][$i])) {
      echo "<strong>";
    }
    echo $teams[$teama[$st-1][$i]];
    if (($favteam > 0) && ($favteam == $teama[$st-1][$i])) {
      echo "</strong>";
    }
    echo "</a>";

    ?>
    </td>
    <td align="center" width="10">-</td>
    <td class="nobr" align="left"><?

    echo "<a href=\"".$addp.$teamb[$st-1][$i]."\" title=\"".$text[269]."\">";
    if (($favteam > 0) && ($favteam == $teamb[$st-1][$i])) {
      echo "<strong>";
    }
    echo $teams[$teamb[$st-1][$i]];
    if (($favteam > 0) && ($favteam == $teamb[$st-1][$i])) {
      echo "</strong>";
    }
    echo "</a>";

      ?>
    </td>
    <td width="2">&nbsp;</td>
    <td align="right"><?=applyFactor($goala[$st-1][$i],$goalfaktor); ?></td>
    <td align="center" width="8">:</td>
    <td align="left"><?=applyFactor($goalb[$st-1][$i],$goalfaktor); ?></td><?  
    if($spez==1){ ?>
    <td width="2">&nbsp;</td>
    <td><?=$mspez[$st-1][$i]; ?></td><?
    }?>
    <td width="2">&nbsp;</td>
    <td class="nobr" align="left"><? 
    
    /** Mannschaftsicons finden
     */
    $lmo_teamaicon="";
    $lmo_teambicon="";
    if($urlb==1 || $mnote[$st-1][$i]!="" || $msieg[$st-1][$i]>0){
      if (file_exists(PATH_TO_IMGDIR."/teams/small/".$teams[$teama[$st-1][$i]].".gif")) {
        $imgdata=getimagesize(PATH_TO_IMGDIR."/teams/small/".$teams[$teama[$st-1][$i]].".gif");
        $lmo_teamaicon="<img border='0' src='".URL_TO_IMGDIR."/teams/small/".rawurlencode($teams[$teama[$st-1][$i]]).".gif' {$imgdata[3]} alt=''> ";
      }
      if (file_exists(PATH_TO_IMGDIR."/teams/small/".$teams[$teamb[$st-1][$i]].".gif")) {
        $imgdata=getimagesize(PATH_TO_IMGDIR."/teams/small/".$teams[$teamb[$st-1][$i]].".gif");
        $lmo_teambicon="<img border='0' src='".URL_TO_IMGDIR."/teams/small/".rawurlencode($teams[$teamb[$st-1][$i]]).".gif' {$imgdata[3]} alt=''> ";
      }
    }
    /** Spielbericht verlinken
     */
    if($urlb==1){
      if($mberi[$st-1][$i]!=""){
        $lmo_spielbericht=$lmo_teamaicon."<strong>".$teams[$teama[$st-1][$i]]."</strong> - ".$lmo_teambicon."<strong>".$teams[$teamb[$st-1][$i]]."</strong><br><br>";
        echo "<a href='".$mberi[$st-1][$i]."'  target='_blank' title='".$text[270]."'><img src='img/lmo-st1.gif' width='10' height='12' border='0' alt=''><span class='popup'><!--[if IE]><table><tr><td style=\"width: 23em\"><![endif]-->".$lmo_spielbericht.nl2br($text[270])."<!--[if IE]></td></tr></table><![endif]--></span></a>";
      }else{
        echo "&nbsp;&nbsp;&nbsp;";
      }
    }
    /** Notizen anzeigen
     *
     * Da IE kein max-width kann, Workaround lt. http://www.bestviewed.de/css/bsp/maxwidth/
     */
    if ($mnote[$st-1][$i]!="" || $msieg[$st-1][$i]>0) {
 
      $lmo_spielnotiz=$lmo_teamaicon."<strong>".$teams[$teama[$st-1][$i]]."</strong> - ".$lmo_teambicon."<strong>".$teams[$teamb[$st-1][$i]]."</strong> ".applyFactor($goala[$st-1][$i],$goalfaktor).":".applyFactor($goalb[$st-1][$i],$goalfaktor);
      //Beidseitiges Ergebnis
      if ($msieg[$st-1][$i]==3) {
        $lmo_spielnotiz.=" / ".applyFactor($goalb[$st-1][$i],$goalfaktor).":".applyFactor($goala[$st-1][$i],$goalfaktor);
      }
      if ($spez==1) {
        $lmo_spielnotiz.=" ".$mspez[$st-1][$i];
      }
      //Gr�ner Tisch: Heimteam siegt
      if ($msieg[$st-1][$i]==1) {
        $lmo_spielnotiz.="\n\n<strong>".$text[219].":</strong> ".$teams[$teama[$st-1][$i]]." ".$text[211];
      }
      //Gr�ner Tisch: Gastteam siegt
      if ($msieg[$st-1][$i]==2) {
        $lmo_spielnotiz.="\n\n<strong>".$text[219].":</strong> ".addslashes($teams[$teamb[$st-1][$i]]." ".$text[211]);
      }
      //Beidseitiges Ergebnis
      if ($msieg[$st-1][$i]==3) {
        $lmo_spielnotiz.="\n\n<strong>".$text[219].":</strong> ".addslashes($text[212]);
      }
      //Allgemeine Notiz
      if ($mnote[$st-1][$i]!="") {
        $lmo_spielnotiz.="\n\n<strong>".$text[22].":</strong> ".$mnote[$st-1][$i];
      }
      echo "<a href='#' onclick=\"alert('".mysql_escape_string(strip_tags($lmo_spielnotiz))."');window.focus();return false;\"><span class='popup'><!--[if IE]><table><tr><td style=\"width: 23em\"><![endif]-->".nl2br($lmo_spielnotiz)."<!--[if IE]></td></tr></table><![endif]--></span><img src='img/lmo-st2.gif' width='10' height='12' border='0' alt=''></a>";
      $lmo_spielnotiz="";
    } else {
      echo "&nbsp;";
    }
    ?></td>
  </tr><? 
  }
}

if ($einzutore == 1) {?>
  <tr>  
    <td class="lmoFooter" align="center" width="100%" colspan="<?=$breite; ?>">&nbsp;<?

  $strs = ".l98";
  $stre = ".l98.php";
  $str = basename($file);
  $file16 = str_replace($strs, $stre, $str);
  $temp11 = basename($diroutput);
  if (file_exists("$temp11/$file16")) {
    require("$temp11/$file16");
     
    echo $text[38].": ".applyFactor($zutore[$st],$goalfaktor)."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"." ".$text[38].$text[4001].": ".applyFactor($dstore[$st],$goalfaktor);
     
  }?>
    </td>
  </tr><?
}
  
if ($einspielfrei == 1) {?>
  <tr>  
    <td align="center" width="100%" colspan="<?=$breite; ?>"><?
  //if (($anzteams-($anzst/2+1)) == 0) {
    $spielfreic = array_merge($spielfreia, $spielfreib);
    $hoy5 = 1;
    for ($hoy8 = 1; $hoy8 < $anzteams+1; $hoy8++) {
      if (in_array($hoy8, $spielfreic)) {
      } else {
        if ($hoy5 == 1) {
          echo $text[4004].": ";
        }
        $hoy5++;?>
        &nbsp;<a href="<?=$addp.$hoy8?>" title="<?=$text[269]?>"><?=$teams[$hoy8]?></a>&nbsp;&nbsp;<?
      }
    }
  //}
  ?></td> 
  </tr><?
}?>
</table>