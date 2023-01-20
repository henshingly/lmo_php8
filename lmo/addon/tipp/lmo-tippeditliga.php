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
<div class="row"><?php 
if ($tipp_einsichterst==2) {
  if ($goala[$st-1][$i]!="_" && $goalb[$st-1][$i]!="_") {
    $btip1=false;
  } else {
    $btip1=true;
  }
} else {
  $btip1=false;
}

if ($datm==1) {
  if ($mterm[$st-1][$i]>0) {
    $dum1=date($datf, $mterm[$st-1][$i]);
  } else {
    $dum1="";
  }?>
  <div class="col-2"><?php echo $dum1; ?></div><?php }?>
  <div class="col-4"><?php 
  if (($favteam>0) && ($favteam==$teama[$st-1][$i])) {
    echo "<strong>";
  }
  echo $teams[$teama[$st-1][$i]];
  if (($favteam>0) && ($favteam==$teama[$st-1][$i])) {
    echo "</strong>";
}?>&nbsp;-&nbsp;<?php 
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
  </div>
  <?php if($tipp_showtendenzabs==1){ ?>
  <div class="col-1"><?php if ($btip1==false) {
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
  </div><?php }
if($tipp_showtendenzpro==1){ ?>
  <div class="col-1"><?php if ($btip1==false) {
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
    } else {
      echo "&nbsp;";
    }
  }?>
  </div><?php }
if ($btip[$i]==true) {
  $savebutton=1;
}

/**ERGEBNISMODUS*/
if ($tipp_tippmodus==1) {
  if ($tipp_showdurchschntipp==1) {?>
    <div class="col-1"><?php    if ($btip1==false) {
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
      } else {
        echo "&nbsp;";
      }
    }?>
  </div><?php  }
  if($btip[$i]==true){ ?>
  <div class="col-1">
    <input class="form-control" type="text" name="xtippa<?php echo $i; ?>" size="2" maxlength="4" value="<?php echo $goaltippa[$i]; ?>">
  </div><?php
  }else{ ?>
  <div class="col-1"><?php echo $goaltippa[$i]; ?></td><?php  }?>
  <div class="col-1">:</div><?php if($btip[$i]==true){ ?>
  <div class="col-1">
    <input class="form-control" type="text" name="xtippb<?php echo $i; ?>" size="2" maxlength="4" value="<?php echo $goaltippb[$i]; ?>">
  </div><?php
  }else{ ?>
  <div class="col-1"><?php echo $goaltippb[$i]; ?></div><?php
  }
} /* ende ($tipp_tippmodus==1) */

/**TENEDENZMODUS*/
if($tipp_tippmodus==0){
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
  <div class="col-1">
    <input type="radio" class="form-check-input" name="xtipp<?php echo $i; ?>" value="1" <?php if($tipp==1){echo " checked";} if($btip[$i]==false){echo " disabled";} ?>>
  <?php if($hidr==0){ ?>
    <input type="radio" class="form-check-input" name="xtipp<?php echo $i; ?>" value="3" <?php if($tipp==0){echo " checked";} if($btip[$i]==false){echo " disabled";} ?>>
  <?php  }?>
    <input type="radio" class="form-check-input" name="xtipp<?php echo $i; ?>" value="2" <?php if($tipp==2){echo " checked";} if($btip[$i]==false){echo " disabled";} ?>>
  </div><?php } /* ende ($tipp_tippmodus==0) */

/**BEIDE*/
if ($tipp_jokertipp==1){ ?>
  <div class="col-1"><input type="radio" class="form-check-input" name="xjokerspiel" value="<?php echo $i+1; ?>" <?php if($jksp==$i+1){echo " checked";} if ($btip[$i]==false){echo " disabled";}elseif($tipp_jokertippaktiv==false){echo " disabled";} ?>></div><?php } ?>                                                                                                                   
  <div class="col-1"><?php echo applyFactor($goala[$st-1][$i],$goalfaktor); ?>:<?php echo applyFactor($goalb[$st-1][$i],$goalfaktor); ?></div>
  <div class="col-1">
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
  </div>
</div>
