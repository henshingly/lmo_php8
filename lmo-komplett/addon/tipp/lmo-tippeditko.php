<?
for($n=0;$n<$modus[$st-1];$n++){
  if(($klfin==1) && ($st==$anzst)){ ?>
  <tr>
    <th class="nobr" colspan=<?=$breite; ?> align="left"><?
    if($i==1){
      echo "&nbsp;<br>";
    }
    echo $text[419+$i]; ?>
    </th>
  </tr><? 
  }?>
  <tr><?
  if ($tipp_einsichterst==2) {
    if ($goala[$st-1][$i][$n]!="_" && $goalb[$st-1][$i][$n]!="_") {
      $btip1=false;
    } else {
      $btip1=true;
    }
  } else {
    $btip1=false;
  }
  
  if ($datm==1) {
    if ($mterm[$st-1][$i][$n]>0) {
      $dum1=strftime($datf, $mterm[$st-1][$i][$n]);
    } else {
      $dum1="";
    }?>
    <td class="nobr" align="left"><?=$dum1; ?></td><? 
  }?>
    <td>&nbsp;</td><? 
  if ($n==0) {
    $m1=array($goala[$st-1][$i][0],$goala[$st-1][$i][1],$goala[$st-1][$i][2],$goala[$st-1][$i][3],$goala[$st-1][$i][4],$goala[$st-1][$i][5],$goala[$st-1][$i][6]);
    $m2=array($goalb[$st-1][$i][0],$goalb[$st-1][$i][1],$goalb[$st-1][$i][2],$goalb[$st-1][$i][3],$goalb[$st-1][$i][4],$goalb[$st-1][$i][5],$goalb[$st-1][$i][6]);
    $m=gewinn($i,$modus[$st-1],$m1,$m2);
    
    if ($m==1) {
      echo "<td class=\"lmoTurnierSieger nobr\" align=\"right\">";
    } else if ($m==2) {
      echo "<td class=\"lmoTurnierVerlierer nobr\" align=\"right\">";
    } else {
      echo "<td class=\"nobr\" align=\"right\">";
    }
    
    if (($favteam>0) && ($favteam==$teama[$st-1][$i])) {
      echo "<strong>";
    }
    echo $teams[$teama[$st-1][$i]];
    if (($favteam>0) && ($favteam==$teama[$st-1][$i])) {
      echo '</strong>';
    }
    echo '</td>';?>
    <td align="center" width="10">-</td><?
    if ($m==1) {
      echo "<td class=\"lmoTurnierVerlierer nobr\" align=\"left\">";
    } else if ($m==2) {
      echo "<td class=\"lmoTurnierSieger nobr\" align=\"left\">";
    } else {
      echo "<td class=\"nobr\" align=\"left\">";
    }
    if (($favteam>0) && ($favteam==$teamb[$st-1][$i])) {
      echo "<strong>";
    }
    echo $teams[$teamb[$st-1][$i]];
    if (($favteam>0) && ($favteam==$teamb[$st-1][$i])) {
      echo "</strong>";
    }
    echo '</td>';
  }else{ ?>
    <td colspan="3">&nbsp;</td><?
  }
  if ($goaltippa[$i][$n]=="_") {
    $goaltippa[$i][$n]="";
  }
  if ($goaltippb[$i][$n]=="_") {
    $goaltippb[$i][$n]="";
  }
  if ($goaltippa[$i][$n]=="-1") {
    $goaltippa[$i][$n]="";
  }
  if ($goaltippb[$i][$n]=="-1") {
    $goaltippb[$i][$n]="";
  }?>
    <td>&nbsp;</td><?
  if($tipp_showtendenzabs==1){ ?>
    <td align="center" class="nobr"><? 
    if ($btip1==false) {
      if (!isset($tendenz1[$i][$n])) {
        $tendenz1[$i][$n]=0;
      }
      if (!isset($tendenz0[$i][$n])) {
        $tendenz0[$i][$n]=0;
      }
      if (!isset($tendenz2[$i][$n])) {
        $tendenz2[$i][$n]=0;
      }
      echo $tendenz1[$i][$n]."-".$tendenz0[$i][$n]."-".$tendenz2[$i][$n];
    }?>
    </td>
    <td>&nbsp;</td><? 
  }
  if($tipp_showtendenzpro==1){ ?>
    <td align="center" class="nobr"><? 
    if ($btip1==false) {
      if (!isset($anzgetippt[$i][$n])) {
        $anzgetippt[$i][$n]=0;
      }
      if ($anzgetippt[$i][$n]>0) {
        if (!isset($tendenz1[$i][$n])) {
          $tendenz1[$i][$n]=0;
        }
        if (!isset($tendenz0[$i][$n])) {
          $tendenz0[$i][$n]=0;
        }
        if (!isset($tendenz2[$i][$n])) {
          $tendenz2[$i][$n]=0;
        }
        echo number_format(($tendenz1[$i][$n]/$anzgetippt[$i][$n]*100),0,".",",")."%-".number_format(($tendenz0[$i][$n]/$anzgetippt[$i][$n]*100),0,".",",")."%-".number_format(($tendenz2[$i][$n]/$anzgetippt[$i][$n]*100),0,".",",")."%";
      } else {
        echo "&nbsp;";
      }
    }?>
    </td>
    <td>&nbsp;</td><? 
  }
  if($btip[$i][$n]==true){
    $savebutton=1;
  }

/**ERGEBNISMODUS*/
  if($tipp_tippmodus==1){
    if($tipp_showdurchschntipp==1){?>
      <td align="center" class="nobr"><? 
      if ($btip1==false) {
        if (!isset($anzgetippt[$i][$n])) {
          $anzgetippt[$i][$n]=0;
        }
        if ($anzgetippt[$i][$n]>0) {
          if (!isset($toregesa[$i][$n])) {
            $toregesa[$i][$n]=0;
          }
          if (!isset($toregesb[$i][$n])) {
            $toregesb[$i][$n]=0;
          }
          if ($toregesa[$i][$n]<10 && $toregesb[$i][$n]<10) {
            $nachkomma=1;
          } else {
            $nachkomma=0;
          }
          echo number_format(($toregesa[$i][$n]/$anzgetippt[$i][$n]),$nachkomma,".",",").":".number_format(($toregesb[$i][$n]/$anzgetippt[$i][$n]),$nachkomma,".",",");
        } else {
          echo "&nbsp;";
        }
      }?>
    </td>
    <td>&nbsp;</td><? 
    }
    if($btip[$i][$n]==true){ ?>
    <td align="right">
      <input class="lmo-formular-input" type="text" name="xtippa<?=$i.$n; ?>" size="4" maxlength="4" value="<?=$goaltippa[$i][$n]; ?>" onKeyDown="lmotorclk('a','<?=$i.$n; ?>',event.keyCode)">
    </td><? 
      if($tipp_pfeiltipp==1){ ?>
    <td align="center">
      <table cellpadding="0" cellspacing="0" border="0">
        <tr>
          <td>
            <script type="text/javascript">document.write('<a href="#" onclick="lmotorauf(\'a\',\'<?=$i.$n; ?>\',1);return false;" title="<?=$text['tipp'][243]; ?>" onMouseOver="lmoimg(\'<?=$i.$n; ?>a\',img1)" onMouseOut="lmoimg(\'<?=$i.$n; ?>a\',img0)"><img src="<?=URL_TO_IMGDIR?>/lmo-admin0.gif" name="ximg<?=$i.$n; ?>a" width="7" height="7" border="0"><\/a>')</script>
          </td>
        </tr>
        <tr>
          <td>
            <script type="text/javascript">document.write('<a href="#" onclick="lmotorauf(\'a\',\'<?=$i.$n; ?>\',-1);return false;" title="<?=$text['tipp'][243]; ?>" onMouseOver="lmoimg(\'<?=$i.$n; ?>b\',img3)" onMouseOut="lmoimg(\'<?=$i.$n; ?>b\',img2)"><img src="<?=URL_TO_IMGDIR?>/lmo-admin2.gif" name="ximg<?=$i.$n; ?>b" width="7" height="7" border="0"><\/a>')</script>
          </td>
        </tr>
      </table>
    </td><? 
      }
    }else{
      if($tipp_pfeiltipp==1){ ?>
    <td>&nbsp;</td><? 
      }?>
    <td align="right"><?=$goaltippa[$i][$n]; ?></td><? 
    } ?>
    <td>:</td><? 
    if($btip[$i][$n]==true){ ?>
    <td align="right">
      <input class="lmo-formular-input" type="text" name="xtippb<?=$i.$n; ?>" size="4" maxlength="4" value="<?=$goaltippb[$i][$n]; ?>" onKeyDown="lmotorclk('b','<?=$i.$n; ?>',event.keyCode)">
    </td><? 
      if($tipp_pfeiltipp==1){ ?>
    <td align="center">
      <table cellpadding="0" cellspacing="0" border="0">
        <tr>
          <td>
            <script type="text/javascript">document.write('<a href="#" onclick="lmotorauf(\'b\',\'<?=$i.$n; ?>\',1);return false;" title="<?=$text['tipp'][244]; ?>" onMouseOver="lmoimg(\'<?=$i.$n; ?>f\',img1)" onMouseOut="lmoimg(\'<?=$i.$n; ?>f\',img0)"><img src="<?=URL_TO_IMGDIR?>/lmo-admin0.gif" name="ximg<?=$i.$n; ?>f" width="7" height="7" border="0"><\/a>')</script>
          </td>
        </tr>
        <tr>
          <td>
            <script type="text/javascript">document.write('<a href="#" onclick="lmotorauf(\'b\',\'<?=$i.$n; ?>\',-1);return false;" title="<?=$text['tipp'][244]; ?>" onMouseOver="lmoimg(\'<?=$i.$n; ?>d\',img3)" onMouseOut="lmoimg(\'<?=$i.$n; ?>d\',img2)"><img src="<?=URL_TO_IMGDIR?>/lmo-admin2.gif" name="ximg<?=$i.$n; ?>d" width="7" height="7" border="0"><\/a>')</script>
          </td>
        </tr>
      </table>
    </td><? 
      }
    }else{?>
    <td align="left"><?=$goaltippb[$i][$n]; ?></td><? 
      if($tipp_pfeiltipp==1){ ?>
    <td>&nbsp;</td><? 
      }
    }
  } /* ende $tipp_tippmodus==1 */

/**TENDENZMODUS*/
  if ($tipp_tippmodus==0) {
    if ($goaltippa[$i][$n]=="" || $goaltippb[$i][$n]=="") {
      $tipp=-1;
    } else if ($goaltippa[$i][$n]>$goaltippb[$i][$n]) {
      $tipp=1;
    } else if ($goaltippa[$i][$n]==$goaltippb[$i][$n]) {
      $tipp=0;
    } else if ($goaltippa[$i][$n]<$goaltippb[$i][$n]) {
      $tipp=2;
    }?>
    <td align="right">
      <input type="radio" name="xtipp<?=$i.$n; ?>" value="1" <? if($tipp==1){echo " checked";} if($btip[$i][$n]==false){echo " disabled";} ?>>
    </td><? 
    if($hidr==0){ ?>
    <td align="center">
      <input type="radio" name="xtipp<?=$i.$n; ?>" value="3" <? if($tipp==0){echo " checked";} if($btip[$i][$n]==false){echo " disabled";} ?>>
    </td><? 
    }?>
    <td align="right">
      <input type="radio" name="xtipp<?=$i.$n; ?>" value="2" <? if($tipp==2){echo " checked";} if($btip[$i][$n]==false){echo " disabled";} ?>>
    </td><? 
  } /* ende ($tipp_tippmodus==0) */

/**BEIDE*/
  if ($tipp_jokertipp==1){ ?>
    <td align="center"><input type="radio" name="xjokerspiel" value="<?=($i+1).($n+1); ?>" <? if($jksp==($i+1).($n+1)){echo " checked";} if($btip[$i][$n]==false){echo " disabled";}elseif($tipp_jokertippaktiv==false){echo " disabled";} ?>></td><? 
  }?>                                                                                                                   
    <td class="lmoBackMarkierung" align="right"><?=$goala[$st-1][$i][$n]; ?></td>
    <td class="lmoBackMarkierung" align="center">:</td>
    <td class="lmoBackMarkierung" align="left"><?=$goalb[$st-1][$i][$n]; ?></td>
    <td class="lmoBackMarkierung" align="left"><?=$mspez[$st-1][$i][$n]; ?></td>
    <td width="2">&nbsp;</td>
    <td class="nobr" align="right">
      <strong><? 
  if ($tipp_jokertipp==1 && $jksp==($i+1).($n+1)) {
    $jkspfaktor=$tipp_jokertippmulti;
  } else {
    $jkspfaktor=1;
  }
  $punktespiel=-1;
  if ($goaltippa[$i][$n]!="" && $goaltippb[$i][$n]!="" && $goala[$st-1][$i][$n]!="_" && $goalb[$st-1][$i][$n]!="_") {
    $punktespiel=tipppunkte($goaltippa[$i][$n], $goaltippb[$i][$n], $goala[$st-1][$i][$n], $goalb[$st-1][$i][$n], 0, $mspez[$st-1][$i][$n], $text[0], $text[1], $jkspfaktor, $mtipp[$st-1][$i][$n]);
  }
  if ($punktespiel==-1) {
    echo "-";
  } else if ($punktespiel==-2) {
    echo $text['tipp'][230];
    $nw=1;
  } else {
    if ($tipp_tippmodus==1) {
      echo $punktespiel;
    } else {
      if ($punktespiel>0) {
        echo "<img src='".URL_TO_IMGDIR."/right.gif' width='12' height='12' border='0' alt='&#9786;'>";
        if ($punktespiel>1) {
          echo "+".($punktespiel-1);
        }
      } else {
        echo "<img src='".URL_TO_IMGDIR."/wrong.gif' width='12' height='12' border='0' alt='&#9785;'>";
      }
    }
  }
  if ($punktespiel>0) {
    $punktespieltag+=$punktespiel;
  }?>
      </strong>
    </td>
    <td>&nbsp;</td>
    <td><?
  /** Mannschaftsicons finden
   */
  $lmo_teamaicon="";
  $lmo_teambicon="";
  if($urlb==1 || $mnote[$st-1][$i][$n]!=""){
    $lmo_teamaicon=getSmallImage($teams[$teama[$st-1][$i]])." ";
    $lmo_teambicon=getSmallImage($teams[$teamb[$st-1][$i]])." ";
  }
  /** Spielbericht verlinken
   */
  if($urlb==1){
    if($mberi[$st-1][$i][$n]!=""){
      $lmo_spielbericht=$lmo_teamaicon."<strong>".$teams[$teama[$st-1][$i]]."</strong> - ".$lmo_teambicon."<strong>".$teams[$teamb[$st-1][$i]]."</strong><br><br>";
      echo "<a href='".$mberi[$st-1][$i][$n]."'  target='_blank' title='".$text[270]."'><img src='".URL_TO_IMGDIR."/lmo-st1.gif' width='10' height='12' border='0' alt=''><span class='popup'>".$lmo_spielbericht.nl2br($text[270])."</span></a>";
    }else{
      echo "&nbsp;&nbsp;&nbsp;";
    }
  }
  /** Notizen anzeigen
   *
   */
  if ($mnote[$st-1][$i][$n]!="" || $mtipp[$st-1][$i][$n] > 0) {

    $lmo_spielnotiz=$lmo_teamaicon."<strong>".$teams[$teama[$st-1][$i]]."</strong> - ".$lmo_teambicon."<strong>".$teams[$teamb[$st-1][$i]]."</strong> ".$goala[$st-1][$i][$n].":".$goalb[$st-1][$i][$n];
    //Allgemeine Notiz
    
    $lmo_spielnotiz.="\n\n<strong>".$text[22].":</strong> ".$mnote[$st-1][$i][$n];
    
    if ($mtipp[$st-1][$i][$n] == 1) {
      $lmo_spielnotiz.="\n\n".$text['tipp'][231];
    }
    echo "<a href='#' onclick=\"alert('".mysql_escape_string(htmlentities(strip_tags($lmo_spielnotiz)))."');window.focus();return false;\"><span class='popup'>".nl2br($lmo_spielnotiz)."</span><img src='".URL_TO_IMGDIR."/lmo-st2.gif' width='10' height='12' border='0' alt=''></a>";
    $lmo_spielnotiz="";
  } else {
    echo "&nbsp;";
  }?>
    </td>
  </tr><? 
}
if(($modus[$st-1]>1) && ($i<$anzsp-1)){ ?>
  <tr>
    <td colspan="<?=$breite; ?>">&nbsp;</td>
  </tr><? 
}