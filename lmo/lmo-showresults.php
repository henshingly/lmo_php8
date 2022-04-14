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

echo "<div class='text-center'><strong>".$st.". ".$text[2];
if($dats==1){ 
  if($datum1[$st-1]!=""){
    echo " ".$text[3]." ".$datum1[$st-1];
  }
  if($datum2[$st-1]!=""){
    echo " ".$text[4]." ".$datum2[$st-1];
  }
}?>
</strong></div>
<div class="container-fluid"><?php 
// Wenn Spieltermine angegeben und Sortierung eingeschaltet, dann nach Datum sortieren
$datsort = $mterm[$st-1];
if($enablegamesort == '1' && filterZero($mterm[$st-1])) { 
  $datsort = $mterm[$st-1];
  asort($datsort);
  reset($datsort);
}
$spielfreia=$spielfreib=array();
$heim1=$heim2=$gast1=$gast2="";
foreach ($datsort as $key => $val) {
  $i = $key;
  if (($teama[$st-1][$i] > 0) && ($teamb[$st-1][$i] > 0)) {?>
  <div class="row"><?php 
    if ($datm == 1) {
      if ($mterm[$st-1][$i] > 0) {
        $dum1 = date($datf, $mterm[$st-1][$i]);
        $dum2 = date("d.m.y", $mterm[$st-1][$i]);
      } else {
        $dum1 = $dum2 = "";
      }?>
    <div class="col-2 text-end d-none d-lg-block"><?php echo $dum1; ?></div>
    <div class="col-2 text-end d-lg-none"><?php echo $dum2; ?></div><?php   
    }

    /* Spielfrei-Hack-Beginn1*/
  	//if (($anzteams-($anzst/2+1))==0){
    	$spielfreia[$i]=$teama[$st-1][$i];
    	$spielfreib[$i]=$teamb[$st-1][$i];
  	//}
    /* Spielfrei-Hack-Ende1*/ 
    if ($plan == "1") {
      $heim1 = "<a href=\"".$addp.$teama[$st-1][$i]."\" title=\"".$text[269]."\">";
    }
    if (($favteam > 0) && ($favteam == $teama[$st-1][$i])) {
      $heim1 .= "<strong>";
    }
    if (($favteam > 0) && ($favteam == $teama[$st-1][$i])) {
      $heim2 =  "</strong>";
    }
    if ($plan == "1") {
      $heim2 .= "</a>";
    }
    ?>
    <div class="col-3 text-end d-none d-lg-block">
    <?php 
    echo $heim1.$teams[$teama[$st-1][$i]].$heim2;
    //echo "&nbsp;".HTML_smallTeamIcon($file,$teams[$teama[$st-1][$i]]," style='vertical-align: middle;'"," alt=''");             
    ?>
    </div>
    <div class="col-2 text-end d-lg-none">
    <?php 
    echo $heim1.$teamk[$teama[$st-1][$i]].$heim2;
    //echo "&nbsp;".HTML_smallTeamIcon($file,$teams[$teama[$st-1][$i]]," alt='' style='vertical-align: middle;'");             
    ?>
    </div>
    <?php 
    if ($plan == "1") {
      $gast1 = "<a href=\"".$addp.$teamb[$st-1][$i]."\" title=\"".$text[269]."\">";
    }
    if (($favteam > 0) && ($favteam == $teamb[$st-1][$i])) {
      $gast1 .= "<strong>";
    }
    if (($favteam > 0) && ($favteam == $teamb[$st-1][$i])) {
      $gast2 = "</strong>";
    }
    if ($plan == "1") {
      $gast2 .= "</a>";
    }
    ?>
    <div class="col-3 text-start d-none d-lg-block">-&nbsp;
    <?php
    //echo HTML_smallTeamIcon($file,$teams[$teamb[$st-1][$i]]," alt='' style='vertical-align: middle;'")."&nbsp;";
    echo $gast1.$teams[$teamb[$st-1][$i]].$gast2;
    ?>
    </div>
    <div class="col-3 text-start d-lg-none">-&nbsp;
    <?php 
    //echo HTML_smallTeamIcon($file,$teams[$teamb[$st-1][$i]]," alt='' style='vertical-align: middle;'")."&nbsp;";
    echo $gast1.$teamk[$teamb[$st-1][$i]].$gast2;
    ?>  
    </div>  
    <div class="col-2 col-sm-auto"><?php echo applyFactor($goala[$st-1][$i],$goalfaktor); ?> : <?php echo applyFactor($goalb[$st-1][$i],$goalfaktor); ?></div>
    <?php   
    if($spez==1) {?>
    <?php echo $mspez[$st-1][$i]; ?><?php 
    }?>
    <div class="col-2"><?php    
    /** Mannschaftsicons finden
     */
    $lmo_teamaicon="";
    $lmo_teambicon="";
    if($urlb==1 || $mnote[$st-1][$i]!="" || $msieg[$st-1][$i]>0){
      $lmo_teamaicon=HTML_smallTeamIcon($file,$teams[$teama[$st-1][$i]]," style='vertical-align: middle;'"," alt=''");
      $lmo_teambicon=HTML_smallTeamIcon($file,$teams[$teamb[$st-1][$i]]," style='vertical-align: middle;'"," alt=''");
    }
    /** Spielbericht verlinken
     */
    if($urlb==1){
      if($mberi[$st-1][$i]!=""){
        $lmo_spielbericht=$lmo_teamaicon."<strong>".$teams[$teama[$st-1][$i]]."</strong> &ndash; ".$lmo_teambicon."<strong>".$teams[$teamb[$st-1][$i]]."</strong><br /><br />";
        echo " <a href='".$mberi[$st-1][$i]."' target='_blank' title='".nl2br($text[270])."'><i class='far fa-book fa-lg text-success'></i></a>";
      }else{
        echo " <img src='".URL_TO_IMGDIR."/blank.png' width='19' height='1' border='0' alt=''>";
      }
    }
    /** Notizen anzeigen
     * 
     */
    if ($mnote[$st-1][$i]!="" || $msieg[$st-1][$i]>0) {
 
      //$lmo_spielnotiz=$lmo_teamaicon."<strong>".$teams[$teama[$st-1][$i]]."</strong> - ".$lmo_teambicon."<strong>".$teams[$teamb[$st-1][$i]]."</strong> ".applyFactor($goala[$st-1][$i],$goalfaktor).":".applyFactor($goalb[$st-1][$i],$goalfaktor);
      //Beidseitiges Ergebnis
/*
      if ($msieg[$st-1][$i]==3) {
        $lmo_spielnotiz.=" / ".applyFactor($goalb[$st-1][$i],$goalfaktor).":".applyFactor($goala[$st-1][$i],$goalfaktor)."\n\n";
      }
*/
      if ($spez==1) {
        $lmo_spielnotiz.=" ".$mspez[$st-1][$i];
      }
      //Grüner Tisch: Heimteam siegt
      if ($msieg[$st-1][$i]==1) {
        $lmo_spielnotiz.=$text[219].": ".$teams[$teama[$st-1][$i]]." ".$text[211];
      }
      //Grüner Tisch: Gastteam siegt
      if ($msieg[$st-1][$i]==2) {
        $lmo_spielnotiz.=$text[219].": ".addslashes($teams[$teamb[$st-1][$i]]." ".$text[211]);
      }
      //Beidseitiges Ergebnis
      if ($msieg[$st-1][$i]==3) {
        $lmo_spielnotiz.=$text[219].": ".addslashes($text[212]);
      }
      //Allgemeine Notiz
      if ($mnote[$st-1][$i]!="") {
        $lmo_spielnotiz.=$text[22].": ".$mnote[$st-1][$i];
      }
      echo " <a href='#' onclick=\"alert('".htmlentities(strip_tags($lmo_spielnotiz))."');window.focus();return false;\" title='".nl2br($lmo_spielnotiz)."'><i class='far fa-comment'></i></a>";
      $lmo_spielnotiz="";
    } else {
      echo " <img src='".URL_TO_IMGDIR."/blank.png' width='1' height='1' border='0' alt=''>";
    }
    ?></div>
  </div><?php  }
}

if ($einzutore == 1) {?>
  <div class="row">  
    <div class="col text-center">&nbsp;<?php 
  $zustat_file = str_replace(".l98", ".l98.php",  basename($file));
  $zustat_dir = basename($diroutput);
  if (file_exists(PATH_TO_LMO.'/'.$zustat_dir."/".$zustat_file)) {
    require(PATH_TO_LMO.'/'.$zustat_dir."/".$zustat_file);
    echo $text[38].": ".applyFactor($zutore[$st],$goalfaktor)."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"." ".$text[38].$text[4001].": ".applyFactor($dstore[$st],$goalfaktor);
  }?>
    </div>
  </div><?php 
}
  
if ($einspielfrei == 1) {?>
  <div class="row">  
    <div class="col text-start"><?php 
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
      
    echo "&nbsp;".HTML_smallTeamIcon($file,$teams[$hoy8],""," alt=''");
      }
    }
  ?></div> 
  </div><?php 
}?>
</div>