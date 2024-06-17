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
  
  
if ($file != "") {
  $addp = $_SERVER['PHP_SELF']."?action=program&amp;file=".$file."&amp;selteam=";
  $addr = $_SERVER['PHP_SELF']."?action=results&amp;file=".$file."&amp;st=";
  $anzsp = $anzteams;
  for($i = 0; $i < $st; $i++) {
    $anzsp = $anzsp/2;
  }
  if (($klfin == 1) && ($st == $anzst)) {
    $anzsp = $anzsp+1;
  } ?>

<div class="container">
  <div class="row!">
    <div class="col text-center"><?php include(PATH_TO_LMO."/lmo-spieltagsmenu.php");?></div>
  </div>
  <div class="row">
    <div class="col text-start">
      <strong><?php
  if ($st == $anzst) {
    $j = $text[374];
  } elseif($st == $anzst-1) {
    $j = $text[373];
  } elseif($st == $anzst-2) {
    $j = $text[372];
  } elseif($st == $anzst-3) {
    $j = $text[371];
  } else {
    $j = $st.". ".$text[370];
  }
  
  echo $j;
  if ($dats == 1) {
    if ($datum1[$st-1] != "") {
      echo " ".$text[3]." ".$datum1[$st-1];
    }
    if ($datum2[$st-1] != "") {
      echo " ".$text[4]." ".$datum2[$st-1];
    }
  }?>
      </strong>
    </div>
  </div><?php
  $datsort = $mterm[$st-1];
  asort($datsort);
  reset($datsort);
  //while (list ($key, $val) = each ($datsort)) { //Deprecated: The each() function ...
  foreach($datsort as $key => $val) {
    $i = $key;
    $heim1 = $heim2 = $gast1 = $gast2 = "";
    if (($teama[$st-1][$i] > 0) && ($teamb[$st-1][$i] > 0)) {
      for($n = 0; $n < $modus[$st-1]; $n++) {?>
      <div class="row p-1"><?php
        if(($klfin==1) && ($st==$anzst)){ ?>
          <div class="col-2 text-end"><?php echo $text[419+$i]; ?></div><?php
        }
        if($datm==1){
          if($mterm[$st-1][$i][$n]>0){
            //$dum1 = date($datf, $mterm[$st-1][$i][$n]);
            $dum1 = datefmt_format($fmt, $mterm[$st-1][$i][$n]);
            $dum2 = date("d.m", $mterm[$st-1][$i][$n]);
          } else {
            $dum1=$dum2="";
          }?>
          <div class="col-2 text-end d-none d-lg-block"><?php echo $dum1; ?></div>
          <div class="col-2 text-end d-lg-none"><?php echo $dum2; ?></div><?php
        }
        if ($n == 0) {
          $m1 = array($goala[$st-1][$i][0], $goala[$st-1][$i][1], $goala[$st-1][$i][2], $goala[$st-1][$i][3], $goala[$st-1][$i][4], $goala[$st-1][$i][5], $goala[$st-1][$i][6]);
          $m2 = array($goalb[$st-1][$i][0], $goalb[$st-1][$i][1], $goalb[$st-1][$i][2], $goalb[$st-1][$i][3], $goalb[$st-1][$i][4], $goalb[$st-1][$i][5], $goalb[$st-1][$i][6]);
          $m = gewinn($st-1, $i, $modus[$st-1], $m1, $m2);
          if ($m == 1) {
            $color = "text-success";
          } elseif ($m == 2) {
            $color = "text-danger";
          } else {
            $color = "";
          }
          if ($plan == 1) {
            $heim1 = "<a href='".$addp.$teama[$st-1][$i]."' class='".$color."' data-bs-toggle='tooltip' data-bs-placement='top' title='".$text[269]."'>";
          }
          if (($favteam > 0) && ($favteam == $teama[$st-1][$i])) {
            $heim1 .= "<strong>";
          }
          if (($favteam > 0) && ($favteam == $teama[$st-1][$i])) {
            $heim2 = "</strong>";
          }
          if ($plan == 1) {
            $heim2 .= "</a>";
          }?>
          <div class="col-3 text-end d-none d-lg-block <?php echo $color; ?>"><?php
          echo $heim1.$teams[$teama[$st-1][$i]].$heim2;
          echo "&nbsp;".HTML_smallTeamIcon($file,$teams[$teama[$st-1][$i]]," width='24' title='$teams[$teama[$st-1][$i]]'"," alt='$teams[$teama[$st-1][$i]]'")."&nbsp;";?>
          </div>
          <div class="col-2 text-end d-lg-none <?php echo $color; ?>"><?php
          echo $heim1.$teamk[$teama[$st-1][$i]].$heim2;?>
          </div>
          <?php
          if ($m == 2) {
            $color = "text-success";
          } elseif ($m == 1) {
            $color = "text-danger";
          } else {
            $color = "";
          }
          if ($plan==1) {
            $gast1 = "<a href='".$addp.$teamb[$st-1][$i]."' class='".$color."' data-bs-toggle='tooltip' data-bs-placement='top' title='".$text[269]."'>";
          }
          if (($favteam > 0) && ($favteam == $teamb[$st-1][$i])) {
            $gast1 .= "<strong>";
          }
          if (($favteam > 0) && ($favteam == $teamb[$st-1][$i])) {
            $gast2 = "</strong>";
          }
          if ($plan==1) {
            $gast2 .= "</a>";
          }?>
          <div class="col-3 text-start d-none d-lg-block <?php echo $color; ?>"><?php
          echo "&nbsp;".HTML_smallTeamIcon($file,$teams[$teamb[$st-1][$i]]," width='24' title='$teams[$teamb[$st-1][$i]]'"," alt='$teams[$teamb[$st-1][$i]]'")."&nbsp;";
          echo $gast1.$teams[$teamb[$st-1][$i]].$gast2;?>
          </div>
          <div class="col-2 text-start d-lg-none <?php echo $color; ?>"><?php
          echo $gast1.$teamk[$teamb[$st-1][$i]].$gast2;?>
          </div><?php
        } else { ?>
          <div class="col-6 d-none d-lg-block"></div>
          <div class="col-6 d-lg-none"></div><?php
        }?>
          <div class="col-1 d-none d-lg-block"><?php echo applyFactor($goala[$st-1][$i][$n],$goalfaktor); ?> : <?php echo applyFactor($goalb[$st-1][$i][$n],$goalfaktor);?> <?php echo $mspez[$st-1][$i][$n]; ?></div>
          <div class="col-3 d-lg-none"><?php echo applyFactor($goala[$st-1][$i][$n],$goalfaktor); ?> : <?php echo applyFactor($goalb[$st-1][$i][$n],$goalfaktor);?> <?php echo $mspez[$st-1][$i][$n]; ?></div>
          <div class="col-1 text-start"><?php
        /** Mannschaftsicons finden
         */
        $lmo_teamaicon="";
        $lmo_teambicon="";
        if($urlb==1 || $mnote[$st-1][$i][$n]!=""){
          $lmo_teamaicon=HTML_smallTeamIcon($file,$teams[$teama[$st-1][$i]]," width='24' title='$teams[$teama[$st-1][$i]]'"," alt='$teams[$teama[$st-1][$i]]'");
          $lmo_teambicon=HTML_smallTeamIcon($file,$teams[$teamb[$st-1][$i]]," width='24' title='$teams[$teamb[$st-1][$i]]'"," alt='$teams[$teamb[$st-1][$i]]'");
        }
        /** Spielbericht verlinken
         */
        if($urlb==1){
          if($mberi[$st-1][$i][$n]!=""){
            $lmo_spielbericht=$lmo_teamaicon."<strong>".$teams[$teama[$st-1][$i]]."</strong> - ".$lmo_teambicon."<strong>".$teams[$teamb[$st-1][$i]]."</strong><br><br>";
            echo " <a href='".$mberi[$st-1][$i][$n]."' target='_blank' title='".$text[270]."'><i class='bi bi-box-arrow-up-right text-warning' style='font-size: 1.3rem;'></i></a>";
          }else{
            echo "&nbsp;";
          }
        }
        /** Notizen anzeigen
         *
         */
        if ($mnote[$st-1][$i][$n]!="") {
          //Allgemeine Notiz
          $lmo_spielnotiz="<strong>".$text[22].":</strong>\n".$mnote[$st-1][$i][$n];
          echo "<a data-bs-toggle='tooltip' data-bs-placement='right' data-bs-html='true' title='".$lmo_spielnotiz."'> <i class='bi bi-info-circle-fill text-info' style='font-size: 1.3rem;'></i></a>";
          $lmo_spielnotiz="";
        } else {
          echo "&nbsp;";
        }?>
          </div>
        </div><?php
      }
    }
  }?>
  <div class="row">
    <div class="col-2 text-start"><?php
   $st0 = $st-1;
   if ($st > 1) {?>
       <a href="<?php echo $addr.$st0?>" data-bs-toggle='tooltip' data-bs-placement='top' title="<?php echo $text[6]?>"><?php echo $text[5]?> <?php echo $text[6]?></a><?php
   } ?>
     </div>
     <div class="col-2 offset-5 text-end"><?php
   $st0 = $st+1;
   if ($st < $anzst) {?>
       <a href="<?php echo $addr.$st0?>" data-bs-toggle='tooltip' data-bs-placement='top' title="<?php echo $text[8]?>"><?php echo $text[8]?> <?php echo $text[7]?></a><?php
   }?>
    </div>
  </div>
</div><?php
} 
