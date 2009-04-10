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
  ?>
<table class="lmoInner" cellspacing="0" cellpadding="0" border="0">
  <tr>
    <th colspan="<?=$breite; ?>" align="left">
    	<?php
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
// Wenn Spieltermine angegeben und Sortierung eingeschaltet, dann nach Datum sortieren
$datsort = $mterm[$st-1];
if($enablegamesort == '1' && filterZero($mterm[$st-1])) { 
  $datsort = $mterm[$st-1];
  asort($datsort);
  reset($datsort);
}
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
 
    if ($plan == "1") {
      echo "<a href=\"".$addp.$teama[$st-1][$i]."\" title=\"".$text[269]."\">";
    }
    if (($favteam > 0) && ($favteam == $teama[$st-1][$i])) {
      echo "<strong>";
    }
    echo $teams[$teama[$st-1][$i]];
    if (($favteam > 0) && ($favteam == $teama[$st-1][$i])) {
      echo "</strong>";
    }
    if ($plan == "1") {
      echo "</a>";
    }
    echo "&nbsp;".HTML_smallTeamIcon($file,$teams[$teama[$st-1][$i]]," alt=''");             
    ?>
    </td>
    <td align="center" width="10">-</td>
    <td class="nobr" align="left"><?
    echo HTML_smallTeamIcon($file,$teams[$teamb[$st-1][$i]]," alt=''")."&nbsp;";
    if ($plan == "1") {
      echo "<a href=\"".$addp.$teamb[$st-1][$i]."\" title=\"".$text[269]."\">";
    }
    if (($favteam > 0) && ($favteam == $teamb[$st-1][$i])) {
      echo "<strong>";
    }
    echo $teams[$teamb[$st-1][$i]];
    if (($favteam > 0) && ($favteam == $teamb[$st-1][$i])) {
      echo "</strong>";
    }
    if ($plan == "1") {
      echo "</a>";
    }
      ?>
    </td>
    <td width="2">&nbsp;</td>
    <td align="right"><?=applyFactor($goala[$st-1][$i],$goalfaktor); ?></td>
    <td align="center" width="8">:</td>
    <td align="left"><?=applyFactor($goalb[$st-1][$i],$goalfaktor); ?></td><?  
    if($spez==1) {?>
    <td width="2">&nbsp;</td>
    <td><?=$mspez[$st-1][$i]; ?></td><?
    }
    if ($msieg[$st-1][$i]==3){ ?>
    <td width="2">/</td>
    <td align="right"><?=applyFactor($goalb[$st-1][$i],$goalfaktor); ?></td>
    <td align="center" width="8">:</td>
    <td align="left"><?=applyFactor($goala[$st-1][$i],$goalfaktor); ?></td><?  
    }?>
    <td width="2">&nbsp;</td>
    <td class="nobr" align="left"><? 
    
    /** Mannschaftsicons finden
     */
    $lmo_teamaicon="";
    $lmo_teambicon="";
    if($urlb==1 || $mnote[$st-1][$i]!="" || $msieg[$st-1][$i]>0){
      $lmo_teamaicon=HTML_smallTeamIcon($file,$teams[$teama[$st-1][$i]]," alt=''");
      $lmo_teambicon=HTML_smallTeamIcon($file,$teams[$teamb[$st-1][$i]]," alt=''");
    }
    /** Spielbericht verlinken
     */
    if($urlb==1){
      if($mberi[$st-1][$i]!=""){
        $lmo_spielbericht=$lmo_teamaicon."<strong>".$teams[$teama[$st-1][$i]]."</strong> &ndash; ".$lmo_teambicon."<strong>".$teams[$teamb[$st-1][$i]]."</strong><br><br>";
        echo " <a href='".$mberi[$st-1][$i]."'  target='_blank'><img src='".URL_TO_IMGDIR."/lmo-st1.gif' width='10' height='12' border='0' alt=''><span class='popup'>".$lmo_spielbericht.nl2br($text[270])."</span></a>";
      }else{
        echo "&nbsp;&nbsp;&nbsp;";
      }
    }
    /** Notizen anzeigen
     *
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
      //Grüner Tisch: Heimteam siegt
      if ($msieg[$st-1][$i]==1) {
        $lmo_spielnotiz.="\n\n<strong>".$text[219].":</strong> ".$teams[$teama[$st-1][$i]]." ".$text[211];
      }
      //Grüner Tisch: Gastteam siegt
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
      echo " <a href='#' onclick=\"alert('".mysql_escape_string(htmlentities(strip_tags($lmo_spielnotiz)))."');window.focus();return false;\"><span class='popup'>".nl2br($lmo_spielnotiz)."</span><img src='".URL_TO_IMGDIR."/lmo-st2.gif' width='10' height='12' border='0' alt=''></a>";
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
  $zustat_file = str_replace(".l98", ".l98.php",  basename($file));
  $zustat_dir = basename($diroutput);
  if (file_exists(PATH_TO_LMO.'/'.$zustat_dir."/".$zustat_file)) {
    require(PATH_TO_LMO.'/'.$zustat_dir."/".$zustat_file);
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
      if (!in_array($hoy8, $spielfreic)) {
        if ($hoy5 == 1) {
          echo $text[4004].": ";
        }
        $hoy5++;

     if ($plan == "1") {
      echo "<a href=\"".$addp.$hoy8."\" title=\"".$text[269]."\">";
    }
     if (($favteam > 0) && ($favteam == $hoy8)) {
      echo "<strong>";
    }
    echo $teams[$hoy8];
     if (($favteam > 0) && ($favteam == $hoy8)) {
      echo "</strong>";
    }
    if ($plan == "1") {
      echo "</a>";
    }
      
    echo "&nbsp;".HTML_smallTeamIcon($file,$teams[$hoy8]," alt=''");
      }
    }
  ?></td> 
  </tr><?
}?>
</table>