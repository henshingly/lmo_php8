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
for($n=0;$n<$modus[$st-1];$n++){
  if(($klfin==1) && ($st==$anzst)){ ?>
  <div class="row">
    <div class="col"><?php 
    if($i==1){
      echo "<br>";
    }
    echo $text[419+$i]; ?>
    </div>
  </div><?php  }?>
  <div class="row"><?php 
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
      $dum1=datefmt_format($fmt, $mterm[$st-1][$i][$n]);
    } else {
      $dum1="";
    }?>
    <div class="col-2"><?php echo $dum1; ?></div><?php  }?>
    <?php if ($n==0) {
    $m1=array($goala[$st-1][$i][0],$goala[$st-1][$i][1],$goala[$st-1][$i][2],$goala[$st-1][$i][3],$goala[$st-1][$i][4],$goala[$st-1][$i][5],$goala[$st-1][$i][6]);
    $m2=array($goalb[$st-1][$i][0],$goalb[$st-1][$i][1],$goalb[$st-1][$i][2],$goalb[$st-1][$i][3],$goalb[$st-1][$i][4],$goalb[$st-1][$i][5],$goalb[$st-1][$i][6]);
    $m=gewinn($st-1,$i,$modus[$st-1],$m1,$m2);
    
    if ($m==1) {
      echo "<div class=\"col-2 text-success\">";
    } else if ($m==2) {
      echo "<div class=\"col-2 text-danger\">";
    } else {
      echo "<div class=\"col-2\">";
    }
    
    if (($favteam>0) && ($favteam==$teama[$st-1][$i])) {
      echo "<strong>";
    }
    echo $teams[$teama[$st-1][$i]];
    if (($favteam>0) && ($favteam==$teama[$st-1][$i])) {
      echo '</strong>';
    }
    echo "</div>"; 
    if ($m==1) {
      echo "<div class=\"col-2 text-danger\">";
    } else if ($m==2) {
      echo "<div class=\"col-2 text-success\">";
    } else {
      echo "<div class=\"col-2\">";
    }
    if (($favteam>0) && ($favteam==$teamb[$st-1][$i])) {
      echo "<strong>";
    }
    echo $teams[$teamb[$st-1][$i]];
    if (($favteam>0) && ($favteam==$teamb[$st-1][$i])) {
      echo "</strong>";
    }
    echo "</div>";
  } else { ?>
    <div class="col-4"></div><?php 
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
  } 
  if($btip[$i][$n]==true){
    $savebutton=1;
  }

/**ERGEBNISMODUS*/
  if($tipp_tippmodus==1){
    $read="";
    if($btip[$i]==false)
       $read="disabled"; ?>
  <div class="col-2">
    <input class="custom-control" type="text" name="xtippa<?php echo $i; ?>" style="width:4rem" maxlength="4" value="<?php echo $goaltippa[$i][$n]; ?>" <?php echo $read; ?>> : <input class="custom-control" type="text" name="xtippb<?php echo $i; ?>" style="width:4rem" maxlength="4" value="<?php echo $goaltippb[$i][$n]; ?>" <?php echo $read; ?>>
  </div><?php
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
    <div class="col-1">
      <input type="radio" class="form-check-input" name="xtipp<?php echo $i.$n; ?>" value="1" <?php if($tipp==1){echo " checked";} if($btip[$i][$n]==false){echo " disabled";} ?>>
    <?php if($hidr==0){ ?>
      <input type="radio" class="form-check-input" name="xtipp<?php echo $i.$n; ?>" value="3" <?php if($tipp==0){echo " checked";} if($btip[$i][$n]==false){echo " disabled";} ?>>
    <?php } ?>
      <input type="radio" class="form-check-input" name="xtipp<?php echo $i.$n; ?>" value="2" <?php if($tipp==2){echo " checked";} if($btip[$i][$n]==false){echo " disabled";} ?>>
    </div><?php  } /* ende ($tipp_tippmodus==0) */

/**BEIDE*/
  if ($tipp_jokertipp==1){ ?>
    <div class="col-1"><input type="radio" name="xjokerspiel" value="<?php echo ($i+1).($n+1); ?>" <?php if($jksp==($i+1).($n+1)){echo " checked";} if($btip[$i][$n]==false){echo " disabled";}elseif($tipp_jokertippaktiv==false){echo " disabled";} ?>></div><?php  }?>                                                                                                                   
    <div class="col-1"><?php echo $goala[$st-1][$i][$n]; ?>:<?php echo $goalb[$st-1][$i][$n]; ?><?php echo $mspez[$st-1][$i][$n]; ?></div>
    <div class="col-1">
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
  } else if ($punktespiel==-2) {
    echo $text['tipp'][230];
    $nw=1;
  } else {
    if ($tipp_tippmodus==1) {
      echo $punktespiel;
    } else {
      if ($punktespiel>0) {
        echo "<i class='bi ci-check text-success'></i>";
        if ($punktespiel>1) {
          echo "+".($punktespiel-1);
        }
      } else {
        echo "<i class='bi bi-x text-danger'></i>";
      }
    }
  }
  if ($punktespiel>0) {
    $punktespieltag+=$punktespiel;
  }?>
      </strong>
    </div>
  </div><?php }
