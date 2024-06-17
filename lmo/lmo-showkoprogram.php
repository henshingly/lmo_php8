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
  $selteam=!empty($_GET['selteam'])?$_GET['selteam']:$selteam;
  $urlta=$urltb="";
?>
<div class="container">
  <div class="row">
    <div class="col-1"><?php 
  for($i = 1; $i <= floor($anzteams/2); $i++) {
    if($i!=$selteam){?>
      <a href="<?php echo $addp.$i?>" data-bs-toggle='tooltip' data-bs-placement='top' title="<?php echo $text[23]." ".$teams[$i]?>">
          <?php echo HTML_smallTeamIcon($file,$teams[$i]," width='24' style='vertical-align: middle;' title='$teams[$i]'", " alt='$teamk[$i]'");?>
      </a>
    <?php
    } else {
      echo HTML_smallTeamIcon($file,$teams[$i]," width='24' style='vertical-align: middle;' title='$teams[$i]'", " alt='$teamk[$i]'");
    }
    echo "<br>"; 
  }?>
    </div>
    <div class="col-10">
      <div class="container" id="koprogram"><?php 
  if ($selteam == 0) {
    echo "<div class='row justify-content-center'><div class='col text-center'><br/>".$text[24]."<br/></div></div>";
  } else {
    for($j = 0; $j < $anzst; $j++) {
      for($i = 0; $i < (($anzteams/2)+1); $i++) {
        if (($selteam == $teama[$j][$i]) || ($selteam == $teamb[$j][$i])) {?>
        <div class="row justify-content-center"><?php 
          if ($j == $anzst-1) {
            $l = $text[364];
          } elseif($j == $anzst-2) {
            $l = $text[362];
          } elseif($j == $anzst-3) {
            $l = $text[360];
          } elseif($j == $anzst-4) {
            $l = $text[358];
          } else {
            $l = $j+1;
          }?>
          <div class="col-1"><a href="<?php echo $addr.($j+1); ?>" title="<?php echo $text[377]; ?>"><?php echo $l; ?></a></div><?php
          $m1 = array($goala[$j][$i][0], $goala[$j][$i][1], $goala[$j][$i][2], $goala[$j][$i][3], $goala[$j][$i][4], $goala[$j][$i][5], $goala[$j][$i][6]);
          $m2 = array($goalb[$j][$i][0], $goalb[$j][$i][1], $goalb[$j][$i][2], $goalb[$j][$i][3], $goalb[$j][$i][4], $goalb[$j][$i][5], $goalb[$j][$i][6]);
          $m = gewinn($j, $i, $modus[$j], $m1, $m2);
          $heim1 = $heim2 = $gast1 = $gast2 = "";
          if ($selteam == $teama[$j][$i]) {
            $heim1 = "<strong>";
          }
          //echo $teams[$teama[$j][$i]];
          if ($selteam == $teama[$j][$i]) {
            $heim2 = "</strong>";
          }
          if (($teamu[$teama[$j][$i]] != "") && ($urlt == 1)) {
            $urlta = " <a href=\"".$teamu[$teama[$j][$i]]."\" target=\"_blank\" title=\"".$text[46]."\"><i class=\"bi bi-house\" alt='".$text[564]."' title=\"".$text[46]."\"></i></a>";
          }
          if ($selteam == $teamb[$j][$i]) {
            $gast1 = "<strong>";
          }
          //echo $teams[$teamb[$j][$i]];
          if ($selteam == $teamb[$j][$i]) {
            $gast2 = "</strong>";
          }
          if (($teamu[$teamb[$j][$i]] != "") && ($urlt == 1)) {
            $urltb = " <a href=\"".$teamu[$teamb[$j][$i]]."\" target=\"_blank\" title=\"".$text[46]."\"><i class=\"bi bi-house\" alt='".$text[564]."' title=\"".$text[46]."\"></i></a>";
          }
          if ($m == 1) {
            echo "<div class='col-3 text-success text-end d-none d-lg-block'>";
          } elseif ($m==2) {
            echo "<div class='col-3 text-danger text-end d-none d-lg-block'>";
          } else {
            echo "<div class='col-3 text-end d-none d-lg-block'>";
          }
          echo HTML_smallTeamIcon($file,$teams[$teama[$j][$i]]," width='24' title='$teams[$teama[$j][$i]]'"," alt='$teamk[$teama[$j][$i]]'")."&nbsp;";
          echo $heim1.$teams[$teama[$j][$i]].$heim2.$urlta;
          echo " </div>";
          echo " <div class='col-md-auto'>-</div>";
          if ($m == 1) {
            echo "<div class='col-3 text-success text-end d-lg-none'>";
          } elseif ($m==2) {
            echo "<div class='col-3 text-danger text-end d-lg-none'>";
          } else {
            echo "<div class='col-3 text-end d-lg-none'>";
          }
          echo HTML_smallTeamIcon($file,$teams[$teama[$j][$i]]," width='24' title='$teams[$teama[$j][$i]]'"," alt='$teamk[$teama[$j][$i]]'")."&nbsp;";
          echo $heim1.$teamk[$teama[$j][$i]].$heim2.$urlta;
          echo " </div>";
          if ($m == 2) {
            echo "<div class='col-3 text-success d-none d-lg-block'>";
          } elseif($m==1) {
            echo "<div class='col-3 text-danger d-none d-lg-block'>";
          } else {
            echo "<div class='col-3 d-none d-lg-block'>";
          }
          echo HTML_smallTeamIcon($file,$teams[$teamb[$j][$i]]," width='24' title='$teams[$teamb[$j][$i]]'"," alt='$teamk[$teamb[$j][$i]]'")."&nbsp;";
          echo $gast1.$teams[$teamb[$j][$i]].$gast2.$urltb;
          echo " </div>";
          if ($m == 2) {
            echo "<div class='col-3 text-success d-lg-none'>";
          } elseif($m==1) {
            echo "<div class='col-3 text-danger d-lg-none'>";
          } else {
            echo "<div class='col-3 d-lg-none'>";
          }
          echo HTML_smallTeamIcon($file,$teams[$teamb[$j][$i]]," width='24' title='$teams[$teamb[$j][$i]]'"," alt='$teamk[$teamb[$j][$i]]'")."&nbsp;";
          echo $gast1.$teamk[$teamb[$j][$i]].$gast2.$urltb;
          echo " </div>";
          for($n = 0; $n < $modus[$j]; $n++) {
            if ($datm == 1) {
              if ($mterm[$j][$i][$n] > 0) {
                $dumn1 = "<acronym title=\"".datefmt_format($fmt, $mterm[$j][$i][$n])."\">";
                $dumn2 = "</acronym>";
              } else {
                $dumn1 = "";
                $dumn2 = "";
              }
            }
          echo "<div class='col-2'>".applyFactor($goala[$j][$i][$n],$goalfaktor); ?> : <?php echo applyFactor($goalb[$j][$i][$n],$goalfaktor); ?> <?php echo $mspez[$j][$i][$n]; ?><?php
          if ($anzst-$j == 1) echo "</div><div class='col-2'>";
           /** Mannschaftsicons finden
             */
            $lmo_teamaicon="";
            $lmo_teambicon="";
            if($urlb==1 || $mnote[$j][$i][$n]!=""){
              $lmo_teamaicon=HTML_smallTeamIcon($file,$teams[$teama[$j][$i]]," width='24' style='vertical-align: middle;' title='$teama[$i]'", " alt='$teama[$i]'");
              $lmo_teambicon=HTML_smallTeamIcon($file,$teams[$teamb[$j][$i]]," width='24' style='vertical-align: middle;' title='$teamb[$i]'", " alt='$teamb[$i]'");
            }
            /** Spielbericht verlinken
             */
            if($urlb==1){
              if($mberi[$j][$i][$n]!=""){
                $lmo_spielbericht=$lmo_teamaicon."<strong>".$teams[$teama[$j][$i]]."</strong> - ".$lmo_teambicon."<strong>".$teams[$teamb[$j][$i]]."</strong><br><br>";
                echo " <a href='".$mberi[$j][$i][$n]."' target='_blank'><i class='bi bi-box-arrow-up-right text-warning' style='font-size: 1.3rem;'></i></a> ";
              }else{
                echo "&nbsp;&nbsp;&nbsp;";
              }
            }
            /** Notizen anzeigen
             *
             */
            if ($mnote[$j][$i][$n]!="") {
              $lmo_spielnotiz=$lmo_teamaicon."<strong>".$teams[$teama[$j][$i]]."</strong> - ".$lmo_teambicon."<strong>".$teams[$teamb[$j][$i]]."</strong> ".applyFactor($goala[$j][$i][$n],$goalfaktor).":".applyFactor($goalb[$j][$i][$n],$goalfaktor);
              //Allgemeine Notiz
              $lmo_spielnotiz="<strong>".$text[22].":</strong><br>".$mnote[$j][$i][$n];
              echo "<a data-bs-toggle='tooltip' data-bs-placement='right' data-bs-html='true' title='".$lmo_spielnotiz."'> <i class='bi bi-info-circle-fill text-info' style='font-size: 1.3rem;'></i></a>";
              $lmo_spielnotiz="";
            } else {
              echo "&nbsp;";
            }?>
          </div><?php          }?>
        </div><?php        }
      }
    }
  }?>
      </div>
    </div>
    <div class="col-1 text-start"><?php 
  for($i = ceil($anzteams/2)+1; $i <= $anzteams; $i++) {
    if($i!=$selteam){?>
            <a href="<?php echo $addp.$i?>" title="<?php echo $text[23]." ".$teams[$i]?>">
                <?php echo HTML_smallTeamIcon($file,$teams[$i]," width='24' style='vertical-align: middle;' title='$teams[$i]'", " alt='$teams[$i]'")?>
            </a>
            <?php
    } else {
      echo HTML_smallTeamIcon($file,$teams[$i]," width='24' style='vertical-align: middle;' alt='$teams[$i]'"," alt='$teams[$i]'");
    } 
    echo "<br>";
  }?>
  </div>
</div><?php 
}?>
