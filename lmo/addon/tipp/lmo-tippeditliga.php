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
  ?>
<tr><?php
if ($tipp_einsichterst==2) {
  if ($goala[$st-1][$i]!="_" && $goalb[$st-1][$i]!="_") {
    $btip1=FALSE;
  } else {
    $btip1=TRUE;
  }
} else {
  $btip1=FALSE;
}

if ($datm==1) {
  if ($mterm[$st-1][$i]>0) {
    $dum1=strtr(date($datf, $mterm[$st-1][$i]), $trans_lang);
  } else {
    $dum1="";
  }?>
  <td class="nobr" align="left"><?php echo $dum1; ?></td><?php }?>
  <td>&nbsp;</td>
  <td class="nobr" align="right"><?php
  if (($favteam>0) && ($favteam==$teama[$st-1][$i])) {
    echo "<strong>";
  }
  echo $teams[$teama[$st-1][$i]];
  if (($favteam>0) && ($favteam==$teama[$st-1][$i])) {
    echo "</strong>";
}?>
  </td>
  <td align="center" width="10">-</td>
  <td class="nobr" align="left"><?php
  if (($favteam>0) && ($favteam==$teamb[$st-1][$i])) {
    echo "<strong>";
  }
  echo $teams[$teamb[$st-1][$i]];
  if (($favteam>0) && ($favteam==$teamb[$st-1][$i])) {
    echo "</strong>";
  }

  if ($goaltippa[$i]=="_") {
    $goaltippa[$i]="";
  }
  if ($goaltippb[$i]=="_") {
    $goaltippb[$i]="";
  }
  if ($goaltippa[$i]=="-1") {
    $goaltippa[$i]="";
  }
  if ($goaltippb[$i]=="-1") {
    $goaltippb[$i]="";
}?>
  </td>
  <td>&nbsp;</td><?php if ($tipp_showtendenzabs==1){ ?>
  <td align="center" class="nobr"><?php if ($btip1==FALSE) {
    if (!isset($tendenz1[$i])) {
      $tendenz1[$i]=0;
    }
    if (!isset($tendenz0[$i])) {
      $tendenz0[$i]=0;
    }
    if (!isset($tendenz2[$i])) {
      $tendenz2[$i]=0;
    }
    echo $tendenz1[$i]."-".$tendenz0[$i]."-".$tendenz2[$i];
  }?>
  </td>
  <td>&nbsp;</td><?php }
if ($tipp_showtendenzpro==1){ ?>
  <td align="center" class="nobr"><?php if ($btip1==FALSE) {
    if (!isset($anzgetippt[$i])) {
      $anzgetippt[$i]=0;
    }
    if ($anzgetippt[$i]>0) {
      if (!isset($tendenz1[$i])) {
        $tendenz1[$i]=0;
      }
      if (!isset($tendenz0[$i])) {
        $tendenz0[$i]=0;
      }
      if (!isset($tendenz2[$i])) {
        $tendenz2[$i]=0;
      }
      echo number_format(($tendenz1[$i]/$anzgetippt[$i]*100),0,".",",")."%-".number_format(($tendenz0[$i]/$anzgetippt[$i]*100),0,".",",")."%-".number_format(($tendenz2[$i]/$anzgetippt[$i]*100),0,".",",")."%";
    } else {
      echo "&nbsp;";
    }
  }?>
  </td>
  <td>&nbsp;</td><?php }
if ($btip[$i]==TRUE) {
  $savebutton=1;
}

/**ERGEBNISMODUS*/
if ($tipp_tippmodus==1) {
  if ($tipp_showdurchschntipp==1) {?>
    <td align="center" class="nobr"><?php    if ($btip1==FALSE) {
      if (!isset($anzgetippt[$i])) {
        $anzgetippt[$i]=0;
      }
      if ($anzgetippt[$i]>0) {
        if (!isset($toregesa[$i])) {
          $toregesa[$i]=0;
        }
        if (!isset($toregesb[$i])) {
          $toregesb[$i]=0;
        }
        if ($toregesa[$i]<10 && $toregesb[$i]<10) {
          $nachkomma=1;
        } else {
          $nachkomma=0;
        }
        echo number_format((applyFactor($toregesa[$i],$goalfaktor)/$anzgetippt[$i]),$nachkomma,".",",").":".number_format((applyFactor($toregesb[$i],$goalfaktor)/$anzgetippt[$i]),$nachkomma,".",",");
      } else {
        echo "&nbsp;";
      }
    }?>
  </td>
  <td>&nbsp;</td><?php  }
  if ($btip[$i]==TRUE){ ?>
  <td align="right">
    <input class="lmo-formular-input" type="text" name="xtippa<?php echo $i; ?>" size="2" maxlength="4" value="<?php echo $goaltippa[$i]; ?>" onKeyDown="lmotorclk('a','<?php echo $i; ?>',event.keyCode)">
  </td><?php    if ($tipp_pfeiltipp==1){ ?>
  <td align="center">
    <table cellpadding="0" cellspacing="0" border="0">
      <tr>
        <td>
          <script type="text/javascript">document.write('<a href="#" onclick="lmotorauf(\'a\',\'<?php echo $i; ?>\',1);return FALSE;" title="<?php echo $text['tipp'][243]; ?>" onMouseOver="lmoimg(\'<?php echo $i; ?>a\',img1)" onMouseOut="lmoimg(\'<?php echo $i; ?>a\',img0)"><img src="<?php echo URL_TO_IMGDIR?>/lmo-admin0.gif" name="ximg<?php echo $i; ?>a" width="7" height="7" border="0"><\/a>')</script>
        </td>
      </tr>
      <tr>
        <td>
          <script type="text/javascript">document.write('<a href="#" onclick="lmotorauf(\'a\',\'<?php echo $i; ?>\',-1);return FALSE;" title="<?php echo $text['tipp'][243]; ?>" onMouseOver="lmoimg(\'<?php echo $i; ?>b\',img3)" onMouseOut="lmoimg(\'<?php echo $i; ?>b\',img2)"><img src="<?php echo URL_TO_IMGDIR?>/lmo-admin2.gif" name="ximg<?php echo $i; ?>b" width="7" height="7" border="0"><\/a>')</script>
        </td>
      </tr>
    </table>
  </td><?php    }
  } else {
    if ($tipp_pfeiltipp==1){ ?>
  <td>&nbsp;</td><?php    }?>
  <td align="right"><?php echo $goaltippa[$i]; ?></td><?php  }?>
  <td align="center">:</td><?php if ($btip[$i]==TRUE){ ?>
  <td align="right">
    <input class="lmo-formular-input" type="text" name="xtippb<?php echo $i; ?>" size="2" maxlength="4" value="<?php echo $goaltippb[$i]; ?>" onKeyDown="lmotorclk('b','<?php echo $i; ?>',event.keyCode)">
  </td><?php    if ($tipp_pfeiltipp==1){ ?>
  <td align="center">
    <table cellpadding="0" cellspacing="0" border="0">
      <tr>
        <td>
          <script type="text/javascript">document.write('<a href="#" onclick="lmotorauf(\'b\',\'<?php echo $i; ?>\',1);return FALSE;" title="<?php echo $text['tipp'][244]; ?>" onMouseOver="lmoimg(\'<?php echo $i; ?>f\',img1)" onMouseOut="lmoimg(\'<?php echo $i; ?>f\',img0)"><img src="<?php echo URL_TO_IMGDIR?>/lmo-admin0.gif" name="ximg<?php echo $i; ?>f" width="7" height="7" border="0"><\/a>')</script>
        </td>
      </tr>
      <tr>
        <td>
          <script type="text/javascript">document.write('<a href="#" onclick="lmotorauf(\'b\',\'<?php echo $i; ?>\',-1);return FALSE;" title="<?php echo $text['tipp'][244]; ?>" onMouseOver="lmoimg(\'<?php echo $i; ?>d\',img3)" onMouseOut="lmoimg(\'<?php echo $i; ?>d\',img2)"><img src="<?php echo URL_TO_IMGDIR?>/lmo-admin2.gif" name="ximg<?php echo $i; ?>d" width="7" height="7" border="0"><\/a>')</script>
        </td>
      </tr>
    </table>
  </td><?php    }
  } else { ?>
  <td align="left"><?php echo $goaltippb[$i]; ?></td><?php    if ($tipp_pfeiltipp==1){ ?>
  <td>&nbsp;</td><?php    }
  }
} /* ende ($tipp_tippmodus==1) */

/**TENEDENZMODUS*/
if ($tipp_tippmodus==0){
  $tipp=-1;
  if ($goaltippa[$i]=="" || $goaltippb[$i]=="") {
    $tipp=-1;
  } else if ($goaltippa[$i]>$goaltippb[$i]) {
    $tipp=1;
  } else if ($goaltippa[$i]==$goaltippb[$i]) {
    $tipp=0;
  } else if ($goaltippa[$i]<$goaltippb[$i]) {
    $tipp=2;
  }?>
  <td align="center">
    <input type="radio" name="xtipp<?php echo $i; ?>" value="1" <?php if ($tipp==1){echo " checked";} if ($btip[$i]==FALSE){echo " disabled";} ?>>
  </td><?php if ($hidr==0){ ?>
  <td align="center">
    <input type="radio" name="xtipp<?php echo $i; ?>" value="3" <?php if ($tipp==0){echo " checked";} if ($btip[$i]==FALSE){echo " disabled";} ?>>
  </td><?php  }?>
  <td align="center">
    <input type="radio" name="xtipp<?php echo $i; ?>" value="2" <?php if ($tipp==2){echo " checked";} if ($btip[$i]==FALSE){echo " disabled";} ?>>
  </td><?php } /* ende ($tipp_tippmodus==0) */

/**BEIDE*/
if ($tipp_jokertipp==1){ ?>
  <td align="center"><input type="radio" name="xjokerspiel" value="<?php echo $i+1; ?>" <?php if ($jksp==$i+1){echo " checked";} if ($btip[$i]==FALSE){echo " disabled";} elseif ($tipp_jokertippaktiv==FALSE){echo " disabled";} ?>></td><?php } ?>
  <td class="lmoBackMarkierung" align="right"><?php echo applyFactor($goala[$st-1][$i],$goalfaktor); ?></td>
  <td class="lmoBackMarkierung" align="center">:</td>
  <td class="lmoBackMarkierung" align="left"><?php echo applyFactor($goalb[$st-1][$i],$goalfaktor); ?></td><?php if ($spez==1){ ?>
  <td class="lmoBackMarkierung">&nbsp;</td>
  <td class="lmoBackMarkierung" align="left"><?php echo $mspez[$st-1][$i]; ?></td><?php } ?>
  <td width="2">&nbsp;</td>
  <td class="nobr" align="right">
    <strong><?php    if ($tipp_jokertipp==1 && $jksp==$i+1) {
      $jkspfaktor=$tipp_jokertippmulti;
    } else {
      $jkspfaktor=1;
    }
    $punktespiel=-1;
    if ($goaltippa[$i]!="" && $goaltippb[$i]!="" && $goala[$st-1][$i]!="_" && $goalb[$st-1][$i]!="_") {
      $punktespiel=tipppunkte($goaltippa[$i], $goaltippb[$i], $goala[$st-1][$i], $goalb[$st-1][$i], $msieg[$st-1][$i], $mspez[$st-1][$i], $text[0], $text[1], $jkspfaktor, $mtipp[$st-1][$i]);
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
          echo "<img src='".URL_TO_IMGDIR."/right.svg' height='20' border='0' alt='&#9786;'>";
          if ($punktespiel>1) {
            echo "+".($punktespiel-1);
          }
        } else {
          echo "<img src='".URL_TO_IMGDIR."/wrong.scg' height='20' border='0' alt='&#9785;'>";
        }
      }
    }
    if ($punktespiel>0) {
      $punktespieltag+=$punktespiel;
}?>
    </strong>
  </td>
  <td class="nobr" align="left"><?php  /** Mannschaftsicons finden
 */
  $lmo_teamaicon="";
  $lmo_teambicon="";
  if ($urlb==1 || $mnote[$st-1][$i]!="" || $msieg[$st-1][$i]>0){
    $lmo_teamaicon=HTML_smallTeamIcon($file,$teams[$teama[$st-1][$i]]," alt=''")." ";
    $lmo_teambicon=HTML_smallTeamIcon($file,$teams[$teamb[$st-1][$i]]," alt=''")." ";
  }
  /** Spielbericht verlinken */
  if ($urlb==1){
    if ($mberi[$st-1][$i]!=""){
      $lmo_spielbericht=$lmo_teamaicon."<strong>".$teams[$teama[$st-1][$i]]."</strong> - ".$lmo_teambicon."<strong>".$teams[$teamb[$st-1][$i]]."</strong><br><br>";
      echo "&nbsp;<a href='".$mberi[$st-1][$i]."'  target='_blank' title='".$text[270]."'><img src='".URL_TO_IMGDIR."/lmo-st1.svg' height='15' border='0' alt=''><span class='popup'>".$lmo_spielbericht.nl2br($text[270])."</span></a>";
    } else {
      echo "&nbsp;&nbsp;&nbsp;";
    }
  }
  /** Notizen anzeigen
 *
 */
  if ($mnote[$st-1][$i]!="" || $msieg[$st-1][$i]>0 || $mtipp[$st-1][$i] > 0) {
    $lmo_spielnotiz=$lmo_teamaicon."<strong>".$teams[$teama[$st-1][$i]]."</strong> - ".$lmo_teambicon."<strong>".$teams[$teamb[$st-1][$i]]."</strong> ".applyFactor($goala[$st-1][$i],$goalfaktor).":".applyFactor($goalb[$st-1][$i],$goalfaktor);
    //Beidseitiges Ergebnis
    if ($msieg[$st-1][$i]==3) {
      $lmo_spielnotiz.=" / ".applyFactor($goalb[$st-1][$i],$goalfaktor).":".applyFactor($goala[$st-1][$i],$goalfaktor);
    }
    if ($spez==1) {
      $lmo_spielnotiz.=" ".$mspez[$st-1][$i];
    }
    //Grüner Tisch: Heimteam siegt
    if ($msieg[$st-1][$i]==1) {
      $lmo_spielnotiz.="\n\n<strong>".$text[219].":</strong>\n".$teams[$teama[$st-1][$i]]." ".$text[211];
    }
    //Grüner Tisch: Gastteam siegt
    if ($msieg[$st-1][$i]==2) {
      $lmo_spielnotiz.="\n\n<strong>".$text[219].":</strong>\n".addslashes($teams[$teamb[$st-1][$i]]." ".$text[211]);
    }
    //Beidseitiges Ergebnis
    if ($msieg[$st-1][$i]==3) {
      $lmo_spielnotiz.="\n\n<strong>".$text[219].":</strong>\n".addslashes($text[212]);
    }
    //Allgemeine Notiz
    if ($mnote[$st-1][$i]!="") {
      $lmo_spielnotiz.="\n\n<strong>".$text[22].":</strong>\n".$mnote[$st-1][$i];
    }
    //Notiz zum Tippspiel
    if ($mtipp[$st-1][$i] == 1) {
      $lmo_spielnotiz.="\n\n".$text['tipp'][231];
    }
    echo "<a href='#' onclick=\"alert('".addcslashes('',htmlentities(strip_tags($lmo_spielnotiz)))."');window.focus();return FALSE;\"><span class='popup'>".nl2br($lmo_spielnotiz)."</span><img src='".URL_TO_IMGDIR."/lmo-st2.svg' height='15' border='0' alt=''></a>";
    $lmo_spielnotiz="";
  } else {
    echo "&nbsp;";
  }
?></td>
</tr>
