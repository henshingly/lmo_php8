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

for ($n=0;$n<$modus[$st-1];$n++){
  if (($klfin==1) && ($st==$anzst)){ ?>
  <tr>
    <th class="nobr" colspan=<?php echo $breite; ?> align="left"><?php
    if ($i==1){
      echo "&nbsp;<br>";
    }
    echo $text[419+$i]; ?>
    </th>
  </tr><?php  }?>
  <tr><?php
  if ($tipp_einsichterst==2) {
    if ($goala[$st-1][$i][$n]!="_" && $goalb[$st-1][$i][$n]!="_") {
      $btip1=FALSE;
    } else {
      $btip1=TRUE;
    }
  } else {
    $btip1=FALSE;
  }

  if ($datm==1) {
    if ($mterm[$st-1][$i][$n]>0) {
      $dum1=strtr(date($datf, $mterm[$st-1][$i][$n]), $trans_lang);
    } else {
      $dum1="";
    }?>
    <td class="nobr" align="left"><?php echo $dum1; ?></td><?php  }?>
    <td>&nbsp;</td><?php if ($n==0) {
    $m1=array($goala[$st-1][$i][0],$goala[$st-1][$i][1],$goala[$st-1][$i][2],$goala[$st-1][$i][3],$goala[$st-1][$i][4],$goala[$st-1][$i][5],$goala[$st-1][$i][6]);
    $m2=array($goalb[$st-1][$i][0],$goalb[$st-1][$i][1],$goalb[$st-1][$i][2],$goalb[$st-1][$i][3],$goalb[$st-1][$i][4],$goalb[$st-1][$i][5],$goalb[$st-1][$i][6]);
    $m = gewinn($i, $j, $modus[$st-1], $m1, $m2);

    if ($m==1) {
      echo "<td class=\"lmoTurnierSieger nobr\" align=\"right\">";
    } elseif ($m==2) {
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
    <td align="center" width="10">-</td><?php
    if ($m==1) {
      echo "<td class=\"lmoTurnierVerlierer nobr\" align=\"left\">";
    } elseif ($m==2) {
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
  } else { ?>
    <td colspan="3">&nbsp;</td><?php
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
    <td>&nbsp;</td><?php
  if ($tipp_showtendenzabs==1){ ?>
    <td align="center" class="nobr"><?php    if ($btip1==FALSE) {
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
    <td>&nbsp;</td><?php  }
  if ($tipp_showtendenzpro==1){ ?>
    <td align="center" class="nobr"><?php    if ($btip1==FALSE) {
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
    <td>&nbsp;</td><?php  }
  if ($btip[$i][$n]==TRUE){
    $savebutton=1;
  }

/**ERGEBNISMODUS*/
  if ($tipp_tippmodus==1){
    if ($tipp_showdurchschntipp==1){?>
      <td align="center" class="nobr"><?php      if ($btip1==FALSE) {
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
    <td>&nbsp;</td><?php    }
    if ($btip[$i][$n]==TRUE){ ?>
    <td align="right">
      <input class="lmo-formular-input" type="text" name="xtippa<?php echo $i.$n; ?>" size="4" maxlength="4" value="<?php echo $goaltippa[$i][$n]; ?>" onKeyDown="lmotorclk('a','<?php echo $i.$n; ?>',event.keyCode)">
    </td><?php      if ($tipp_pfeiltipp==1){ ?>
    <td align="center">
      <table cellpadding="0" cellspacing="0" border="0">
        <tr>
          <td>
            <script type="text/javascript">document.write('<a href="#" onclick="lmotorauf(\'a\',\'<?php echo $i.$n; ?>\',1);return FALSE;" title="<?php echo $text['tipp'][243]; ?>" onMouseOver="lmoimg(\'<?php echo $i.$n; ?>a\',img1)" onMouseOut="lmoimg(\'<?php echo $i.$n; ?>a\',img0)"><img src="<?php echo URL_TO_IMGDIR?>/lmo-admin0.gif" name="ximg<?php echo $i.$n; ?>a" width="7" height="7" border="0"><\/a>')</script>
          </td>
        </tr>
        <tr>
          <td>
            <script type="text/javascript">document.write('<a href="#" onclick="lmotorauf(\'a\',\'<?php echo $i.$n; ?>\',-1);return FALSE;" title="<?php echo $text['tipp'][243]; ?>" onMouseOver="lmoimg(\'<?php echo $i.$n; ?>b\',img3)" onMouseOut="lmoimg(\'<?php echo $i.$n; ?>b\',img2)"><img src="<?php echo URL_TO_IMGDIR?>/lmo-admin2.gif" name="ximg<?php echo $i.$n; ?>b" width="7" height="7" border="0"><\/a>')</script>
          </td>
        </tr>
      </table>
    </td><?php      }
    } else {
      if ($tipp_pfeiltipp==1){ ?>
    <td>&nbsp;</td><?php      }?>
    <td align="right"><?php echo $goaltippa[$i][$n]; ?></td><?php    } ?>
    <td>:</td><?php    if ($btip[$i][$n]==TRUE){ ?>
    <td align="right">
      <input class="lmo-formular-input" type="text" name="xtippb<?php echo $i.$n; ?>" size="4" maxlength="4" value="<?php echo $goaltippb[$i][$n]; ?>" onKeyDown="lmotorclk('b','<?php echo $i.$n; ?>',event.keyCode)">
    </td><?php      if ($tipp_pfeiltipp==1){ ?>
    <td align="center">
      <table cellpadding="0" cellspacing="0" border="0">
        <tr>
          <td>
            <script type="text/javascript">document.write('<a href="#" onclick="lmotorauf(\'b\',\'<?php echo $i.$n; ?>\',1);return FALSE;" title="<?php echo $text['tipp'][244]; ?>" onMouseOver="lmoimg(\'<?php echo $i.$n; ?>f\',img1)" onMouseOut="lmoimg(\'<?php echo $i.$n; ?>f\',img0)"><img src="<?php echo URL_TO_IMGDIR?>/lmo-admin0.gif" name="ximg<?php echo $i.$n; ?>f" width="7" height="7" border="0"><\/a>')</script>
          </td>
        </tr>
        <tr>
          <td>
            <script type="text/javascript">document.write('<a href="#" onclick="lmotorauf(\'b\',\'<?php echo $i.$n; ?>\',-1);return FALSE;" title="<?php echo $text['tipp'][244]; ?>" onMouseOver="lmoimg(\'<?php echo $i.$n; ?>d\',img3)" onMouseOut="lmoimg(\'<?php echo $i.$n; ?>d\',img2)"><img src="<?php echo URL_TO_IMGDIR?>/lmo-admin2.gif" name="ximg<?php echo $i.$n; ?>d" width="7" height="7" border="0"><\/a>')</script>
          </td>
        </tr>
      </table>
    </td><?php      }
    } else {?>
    <td align="left"><?php echo $goaltippb[$i][$n]; ?></td><?php      if ($tipp_pfeiltipp==1){ ?>
    <td>&nbsp;</td><?php      }
    }
  } /* ende $tipp_tippmodus==1 */

/**TENDENZMODUS*/
  if ($tipp_tippmodus==0) {
    if ($goaltippa[$i][$n]=="" || $goaltippb[$i][$n]=="") {
      $tipp=-1;
    } elseif ($goaltippa[$i][$n]>$goaltippb[$i][$n]) {
      $tipp=1;
    } elseif ($goaltippa[$i][$n]==$goaltippb[$i][$n]) {
      $tipp=0;
    } elseif ($goaltippa[$i][$n]<$goaltippb[$i][$n]) {
      $tipp=2;
    }?>
    <td align="right">
      <input type="radio" name="xtipp<?php echo $i.$n; ?>" value="1" <?php if ($tipp==1){echo " checked";} if ($btip[$i][$n]==FALSE){echo " disabled";} ?>>
    </td><?php    if ($hidr==0){ ?>
    <td align="center">
      <input type="radio" name="xtipp<?php echo $i.$n; ?>" value="3" <?php if ($tipp==0){echo " checked";} if ($btip[$i][$n]==FALSE){echo " disabled";} ?>>
    </td><?php    }?>
    <td align="right">
      <input type="radio" name="xtipp<?php echo $i.$n; ?>" value="2" <?php if ($tipp==2){echo " checked";} if ($btip[$i][$n]==FALSE){echo " disabled";} ?>>
    </td><?php  } /* ende ($tipp_tippmodus==0) */

/**BEIDE*/
  if ($tipp_jokertipp==1){ ?>
    <td align="center"><input type="radio" name="xjokerspiel" value="<?php echo ($i+1).($n+1); ?>" <?php if ($jksp==($i+1).($n+1)){echo " checked";} if ($btip[$i][$n]==FALSE){echo " disabled";} elseif ($tipp_jokertippaktiv==FALSE){echo " disabled";} ?>></td><?php  }?>
    <td class="lmoBackMarkierung" align="right"><?php echo $goala[$st-1][$i][$n]; ?></td>
    <td class="lmoBackMarkierung" align="center">:</td>
    <td class="lmoBackMarkierung" align="left"><?php echo $goalb[$st-1][$i][$n]; ?></td>
    <td class="lmoBackMarkierung" align="left"><?php echo $mspez[$st-1][$i][$n]; ?></td>
    <td width="2">&nbsp;</td>
    <td class="nobr" align="right">
      <strong><?php if ($tipp_jokertipp==1 && $jksp==($i+1).($n+1)) {
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
  } elseif ($punktespiel==-2) {
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
    <td><?php
  /** Mannschaftsicons finden
   */
  $lmo_teamaicon="";
  $lmo_teambicon="";
  if ($urlb==1 || $mnote[$st-1][$i][$n]!=""){
    $lmo_teamaicon=HTML_smallTeamIcon($file,$teams[$teama[$st-1][$i]]," alt=''")." ";
    $lmo_teambicon=HTML_smallTeamIcon($file,$teams[$teamb[$st-1][$i]]," alt=''")." ";
  }
  /** Spielbericht verlinken
   */
  if ($urlb==1){
    if ($mberi[$st-1][$i][$n]!=""){
      $lmo_spielbericht=$lmo_teamaicon."<strong>".$teams[$teama[$st-1][$i]]."</strong> - ".$lmo_teambicon."<strong>".$teams[$teamb[$st-1][$i]]."</strong><br><br>";
      echo "<a href='".$mberi[$st-1][$i][$n]."'  target='_blank' title='".$text[270]."'><img src='".URL_TO_IMGDIR."/lmo-st1.svg' height='15' border='0' alt=''><span class='popup'>".$lmo_spielbericht.nl2br($text[270])."</span></a>";
    } else {
      echo "&nbsp;&nbsp;&nbsp;";
    }
  }
  /** Notizen anzeigen
   *
   */
  if ($mnote[$st-1][$i][$n]!="" || $mtipp[$st-1][$i][$n] > 0) {

    $lmo_spielnotiz=$lmo_teamaicon."<strong>".$teams[$teama[$st-1][$i]]."</strong> - ".$lmo_teambicon."<strong>".$teams[$teamb[$st-1][$i]]."</strong> ".$goala[$st-1][$i][$n].":".$goalb[$st-1][$i][$n];

    //Allgemeine Notiz
    if ($mnote[$st-1][$i][$n]!="") {
      $lmo_spielnotiz.="\n\n<strong>".$text[22].":</strong>\n".$mnote[$st-1][$i][$n];
    }

    //Notiz zum Tippspiel
    if ($mtipp[$st-1][$i][$n] == 1) {
      $lmo_spielnotiz.="\n\n".$text['tipp'][231];
    }
    echo "<a href='#' onclick=\"alert('".addcslashes('',htmlentities(strip_tags($lmo_spielnotiz)))."');window.focus();return FALSE;\"><span class='popup'>".nl2br($lmo_spielnotiz)."</span><img src='".URL_TO_IMGDIR."/lmo-st2.svg' height='15' border='0' alt=''></a>";
    $lmo_spielnotiz="";
  } else {
    echo "&nbsp;";
  }?>
    </td>
  </tr><?php }
if (($modus[$st-1]>1) && ($i<$anzsp-1)){ ?>
  <tr>
    <td colspan="<?php echo $breite; ?>">&nbsp;</td>
  </tr><?php }
