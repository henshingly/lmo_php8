<?
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
  */
  
  

if(!isset($nw)){
  $nw=0;
}
?>
  <tr>
    <td class="lmoFooter" colspan="3"  align="left">
      <table width="100%" cellspacing="0" cellpadding="0" border="0">
        <tr>
          <td valign="top"><? 
  if ($todo == "wert") {
    echo "<strong>".$text['tipp'][89].":</strong><br>"; /// Zeichenerklaerung
    if ($wertung == "team") {
      echo $text['tipp'][119].": ".$text['tipp'][120]."&nbsp;&nbsp;&nbsp;<br>"; // AT
      echo $text['tipp'][119]."Ø: ".$text['tipp'][208]."&nbsp;&nbsp;&nbsp;<br>"; // AT
    }
    echo $text['tipp'][123].": ".$text['tipp'][117]."&nbsp;&nbsp;&nbsp;<br>"; // SG
    if ($tipp_showstsiege == 1) {
      echo $text['tipp'][90].": ".$text['tipp'][271]."&nbsp;&nbsp;&nbsp;<br>";
    } // GS
    echo $text['tipp'][123];
    if ($tipp_tippmodus == 1) {
      echo "Ø: ".$text['tipp'][124];
    } else {
      echo "%: ".$text['tipp'][125];
    }
     echo "&nbsp;&nbsp;&nbsp;<br>";
    if ($tipp_tippmodus == 1) {
      echo $text[37].": ".$text['tipp'][116];
    } else {
      echo $text['tipp'][122].": ".$text['tipp'][118];
    }
    echo "&nbsp;&nbsp;&nbsp;<br>"; // PP
  }
  if ($todo == "wert" || $todo == "edit" || $todo == "einsicht") {
    if ($tipp_tippmodus == 1) {
      echo "<strong>".$text['tipp'][108].":</strong><br>"; // Punkteverteilung
      if ($tipp_rergebnis > 0) {
        echo $text['tipp'][221].": ".$text['tipp'][34].": ".$tipp_rergebnis." ".$text['tipp'][38]."&nbsp;&nbsp;&nbsp;<br>";
      }
      if ($tipp_rtendenzdiff > $tipp_rtendenz) {
        echo $text['tipp'][222].": ".$text['tipp'][35].": ".$tipp_rtendenzdiff." ".$text['tipp'][38]."&nbsp;&nbsp;&nbsp;<br>";
      }
      if ($tipp_rtendenz > 0) {
        echo $text['tipp'][223].": ".$text['tipp'][36].": ".$tipp_rtendenz." ".$text['tipp'][38]."&nbsp;&nbsp;&nbsp;<br>";
      }
      if ($tipp_rtor > 0) {
        echo $text['tipp'][224].": ".$text['tipp'][37].": ".$tipp_rtor." ".$text['tipp'][38]."&nbsp;&nbsp;&nbsp;<br>";
      }
    }
    if ($tipp_rremis > 0) {
      echo $text['tipp'][225].": ".$text['tipp'][192].": ".$tipp_rremis." ".$text['tipp'][38]."&nbsp;&nbsp;&nbsp;<br>";
    }
    if ($tipp_jokertipp == 1 && $todo == "einsicht") {
      echo getMessage($text['tipp'][287],TRUE).": ".$text['tipp'][289]."&nbsp;&nbsp;&nbsp;<br>";
    }
    if ($tipp_jokertipp == 1 && $todo == "wert") {
      echo $text['tipp'][226].": ".$text['tipp'][227]."&nbsp;&nbsp;&nbsp;<br>";
    }
    if ($tipp_jokertipp == 1 && $todo == "edit") {
      echo $text['tipp'][291].": ".$tipp_jokertippmulti."&nbsp;&nbsp;&nbsp;<br>";
    }
    if ($nw == 1) {
      echo $text['tipp'][230]." ".$text['tipp'][231]."&nbsp;&nbsp;&nbsp;<br>";
    }
  }?>
          </td>
          <td align="right" valign="bottom" rowspan="2"><? if(!isset($auswertfile)){$auswertfile="";}
  if (!isset($tippfile)) {
    $tippfile = "";
  }
  if (!isset($einsichtfile)) {
    $einsichtfile = "";
  }
  if ($auswertfile == "") {
    $auswertfile = $einsichtfile;
  }
  if ($auswertfile != "" && file_exists($auswertfile)) {
    $auswertstand = date("d.m.Y H:i", filemtime($auswertfile)); // Stand der *.aus-Datei
    echo $text['tipp'][83].": ".$auswertstand."<br>";
  }
  if ($tippfile != "" && $all != 1 && ($todo != "tabelle" || $nick != "") && file_exists($tippfile)) {
    $tippstand = date("d.m.Y H:i", filemtime($tippfile)); // Stand der *_user.tip-Datei
    echo $text['tipp'][86].": ".$tippstand."<br>";
  }
  if ($file != "" && $all != 1 && isset($stand) && $stand != "") {
    echo $text[406].": ".$stand."<br>";
  } // Stand der *.l98-Datei
  if ($calctime == 1) {
    echo $text[471].": ".number_format((getmicrotime()-$startzeit), 4, ".", ",")." sek.<br>";
  }
  echo $text[54];?> - <? echo $text[55]; ?> <br><?
  echo $text['tipp'][84]; ?> - <? echo $text['tipp'][85]; ?>
          </td>
        </tr>
        <tr>
          <td valign="bottom"><?
  if ($file != "" && $lmtype == 0 && $all != 1) {
    echo "<a href=\"".$_SERVER['PHP_SELF']."?file=".$file."&amp;action=table\">".$text[5]." ".$text['tipp'][99]."</a>&nbsp;&nbsp;&nbsp;<br>";
  }
  if ($todo != "" && $todo != "logout") {
    echo "<a href=\"".$_SERVER['PHP_SELF']."?action=tipp"."\">".$text[5]." ".$text['tipp'][1]."</a>&nbsp;&nbsp;&nbsp;";
  }
  if ($todo == "" || $todo == "logout") {
    if ($backlink == 1) {
      echo "<a href=\"".$_SERVER['PHP_SELF']."\">".$text[391]."</a>&nbsp;&nbsp;&nbsp;";
    }
  }?>
          </td>
        </tr>
      </table>
    </td>
  </tr>