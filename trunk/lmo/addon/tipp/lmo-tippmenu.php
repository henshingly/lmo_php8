<table class="lmoSubmenu" width="99%" cellspacing="0" cellpadding="0" border="0">
  <tr>
    <td class="nobr" align="left"><?
  if ($todo != "") {
    echo "<a href=\"".$_SERVER['PHP_SELF']."?action=tipp\" title=\"".$text['tipp'][53]."\">".$text['tipp'][52]."</a>";
  } else {
    echo $text['tipp'][52];
  }
  echo "&nbsp;&nbsp;";
  if ($viewermode == 1) {
    echo $text['tipp'][9]."&nbsp;&nbsp;";
  } elseif($file != "") {
    if ($tipp_sttipp != -1) {
      if ($todo != "edit") {
        echo "<a href=\"".$adda."edit&amp;file=".$file."&amp;st=".$st."\" title=\"".$text['tipp'][9]."\">".$text['tipp'][9]."</a>";
      } else {
        echo $text['tipp'][9];
      }
      echo "&nbsp;&nbsp;";
    }
    if ($tipp_tippeinsicht == 1) {
      if ($todo != "einsicht") {
        echo "<a href=\"".$adda."einsicht&amp;file=".$file."&amp;st=".$st."\" title=\"".$text['tipp'][157]."\">".$text['tipp'][157]."</a>";
      } else {
        echo $text['tipp'][157];
      }
      echo "&nbsp;&nbsp;";
    }
    if ($lmtype == 0 && $tipp_tipptabelle1 == 1) {
      if ($todo != "tabelle") {
        echo "<a href=\"".$adda."tabelle&amp;file=".$file."\" title=\"".$text['tipp'][173]."\">".$text['tipp'][172]."</a>";
      } else {
        echo $text['tipp'][172];
      }
      echo "&nbsp;&nbsp;";
    }
    if ($tipp_tippfieber == 1) {
      if ($todo != "fieber") {
        echo "<a href=\"".$adda."fieber&amp;file=".$file."\" title=\"".$text[134]."\">".$text[133]."</a>";
      } else {
        echo $text[133];
      }
      echo "&nbsp;&nbsp;";
    }
    if ($todo != "wert" || $all == 1) {
      echo "<a href=\"".$adda."wert&amp;file=".$file."&amp;endtab=".$endtab."&amp;wertung=einzel\" title=\"".$text['tipp'][54]."\">".$text['tipp'][54]."</a>";
    } else {
      echo $text['tipp'][54];
    }
    echo "&nbsp;&nbsp;";
  }
  /*
  if($tipp_gesamt==1){
    if($todo!="wert" || $all!=1){echo "<a href=\"".$adda."wert&amp;file=".$file."&amp;wertung=einzel&amp;all=1\" title=\"".$text['tipp'][56]."\">".$text['tipp'][56]."</a>";}
    else{echo $text['tipp'][56];}
  }
  echo "&nbsp;&nbsp;";
*/?>
    </td>
    <td width="8">&nbsp;</td>
    <td class="nobr" align="right"><?
  if($tipp_regeln==1){?>
        <a href='<?=URL_TO_ADDONDIR."/tipp/".$tipp_regelnlink?>' target='regeln' onclick='window.open(this.href,this.target,"scrollbars=yes,resizable=yes");return false;'><?=$text['tipp'][185]?></a>&nbsp;&nbsp;<?
  }
  echo "<a href=\"".$adda."logout\">".$text[88]."</a>";
  echo "&nbsp;";?>
    </td>
  </tr>
</table>