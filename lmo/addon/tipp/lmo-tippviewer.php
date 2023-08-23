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
  
  
require_once(PATH_TO_ADDONDIR."/tipp/lmo-tipptest.php");
if ($tipp_viewertipp == 1 && $viewermode == 1) {
  require_once(PATH_TO_ADDONDIR."/tipp/lmo-tippcalcpkt.php");
  require_once(PATH_TO_ADDONDIR."/tipp/lmo-tippaenderbar.php");
   
  $verz = opendir(substr(PATH_TO_LMO.'/'.$dirliga, 0, -1));
  $dateien = array();
  while ($files = readdir($verz)) {
    if (file_exists(PATH_TO_ADDONDIR."/tipp/".$tipp_dirtipp.substr($files, 0, -4)."_".$_SESSION['lmotippername'].".tip")) {
      $ftest = 1;
      if ($tipp_immeralle != 1) {
        $ftest = 0;
        $ftest1 = "";
        $ftest1 = explode(',', $tipp_ligenzutippen);
        if (isset($ftest1)) {
          for($u = 0; $u < count($ftest1); $u++) {
            if ($ftest1[$u] == substr($files, 0, -4)) {
              $ftest = 1;
            }
          }
        }
      }
      if ($ftest == 1) {
        array_push($dateien, $files);
      }
    }
  }
  closedir($verz);
  sort($dateien);
   
  $anzligen = count($dateien);
   
  $teams = array_pad($array, 65, "");
  $teams[0] = "___";
  $liga = array();
  $titel = array();
  $lmtype = array();
  $anzst = array();
  $hidr = array();
  $dats = array();
  $datm = array();
  $spieltag = array();
  $modus = array();
  $datum1 = array();
  $datum2 = array();
  $spiel = array();
  $teama = array();
  $teamb = array();
  $goala = array();
  $goalb = array();
  $goalfaktor = array();
  $mspez = array();
  $mtipp = array();
  $mnote = array();
  $urlb = array();
  $mberi = array();
  $msieg = array();
  $mterm = array();
  $tippa = array();
  $tippb = array();
  $jksp = array();
  $tipp_jokertippaktiv = array();
   
  $anzspiele = 0;
   
  if (!isset($save)) {
    $save = 0;
  }
  if ($save == 1) {
    $start = trim($_POST["xstart"]);
    $now1 = trim($_POST["xnow"]);
    $then1 = trim($_POST["xthen"]);
  } else {
    if (!isset($start)) {
      $start = 0;
    }
    $now1 = strtotime("+".$start." day");
    $then1 = strtotime("+".($start+$tipp_viewertage)." day");
  }
   
  $now1 = date("d.m.Y", $now1);
  $now = mktime(0, 0, 0, substr($now1, 3, 2), substr($now1, 0, 2), substr($now1, -4));
  $then = date("d.m.Y", $then1);
  $then = mktime(0, 0, 0, substr($then, 3, 2), substr($then, 0, 2), substr($then, -4));
  $then1 = date("d.m.Y", ($then-1));
   
  for($liganr = 0; $liganr < $anzligen; $liganr++) {
    $file = $dateien[$liganr];
    $tippfile = PATH_TO_ADDONDIR."/tipp/".$tipp_dirtipp.substr($dateien[$liganr], 0, -4)."_".$_SESSION['lmotippername'].".tip";
    require(PATH_TO_ADDONDIR."/tipp/lmo-tippopenfileviewer.php");
  }
    
  if ($save == 1) {
    $now = time();
    $start1 = 0;
    $start2 = 0;
    for($i = 0; $i < $anzspiele; $i++) {
      $btip = tippaenderbar($mterm[$i], $datum1[$i], $datum2[$i]);
      if ($btip == true) {
        if ($tipp_jokertipp == 1 && isset($_POST["xjokerspiel_".$liga[$i]."_".$spieltag[$i]])) {
          $jksp[$i] = trim($_POST["xjokerspiel_".$liga[$i]."_".$spieltag[$i]]);
          if ($tipp_jokertippaktiv[$i] > 0 && $tipp_jokertippaktiv[$i] < $now) {
            $jksp[$i] = 0;
          } // jokeranticheat
        }
        if ($tipp_tippmodus == 1) {
          $tippa[$i] = trim($_POST["xtippa".$i]);
          if ($tippa[$i] == "" || $tippa[$i] < 0) {
            $tippa[$i] = -1;
          } elseif($tippa[$i] == "_") {
            $tippa[$i] = -1;
          } else {
            $tippa[$i] = intval(trim($tippa[$i]));
            if ($tippa[$i] == "") {
              $tippa[$i] = "0";
            }
          }
          $tippb[$i] = trim($_POST["xtippb".$i]);
          if ($tippb[$i] == "" || $tippb[$i] < 0) {
            $tippb[$i] = -1;
          } elseif($tippb[$i] == "_") {
            $tippb[$i] = -1;
          } else {
            $tippb[$i] = intval(trim($tippb[$i]));
            if ($tippb[$i] == "") {
              $tippb[$i] = "0";
            }
          }
        } elseif($tipp_tippmodus == 0) {
          if (!isset($_POST["xtipp".$i])) {
            $_POST["xtipp".$i] = 0;
          }
          if ($_POST["xtipp".$i] == 1) {
            $tippa[$i] = "1";
            $tippb[$i] = "0";
          } elseif($_POST["xtipp".$i] == 2) {
            $tippa[$i] = "0";
            $tippb[$i] = "1";
          } elseif($_POST["xtipp".$i] == 3) {
            $tippa[$i] = "0";
            $tippb[$i] = "0";
          } else {
            $tippa[$i] = "-1";
            $tippb[$i] = "-1";
          }
        }
      }
      if ($i == ($anzspiele-1) || $liga[$i] != $liga[$i+1]) {
        $tippfile = PATH_TO_ADDONDIR."/tipp/".$tipp_dirtipp.$liga[$i]."_".$_SESSION['lmotippername'].".tip";
        require(PATH_TO_ADDONDIR."/tipp/lmo-tippsavefileviewer.php");
        $start1 = $i+1;
      }
      if ($tipp_akteinsicht == 1 && ($i == ($anzspiele-1) || $spieltag[$i] != $spieltag[$i+1] || $liga[$i] != $liga[$i+1])) {
        $einsichtfile = PATH_TO_ADDONDIR."/tipp/".$tipp_dirtipp."einsicht/".$liga[$i]."_".$spieltag[$i].".ein";
        require(PATH_TO_ADDONDIR."/tipp/lmo-tippsaveeinsichtviewer.php");
        $start2 = $i+1;
      }
    }
  }
   
  if ($tipp_tippmodus == 1) {
    $tendenz1 = array_pad(array("0"), $anzspiele+1, "0");
    $tendenz0 = array_pad(array("0"), $anzspiele+1, "0");
    $tendenz2 = array_pad(array("0"), $anzspiele+1, "0");
    $toregesa = array_pad(array("0"), $anzspiele+1, "0");
    $toregesb = array_pad(array("0"), $anzspiele+1, "0");
    $anzgetippt = array_pad(array("0"), $anzspiele+1, "0");
    $btip = array_pad(array("false"), $anzspiele+1, "0");
    $start2 = 0;
    for($i = 0; $i < $anzspiele; $i++) {
      if ($i == ($anzspiele-1) || $spieltag[$i] != $spieltag[$i+1] || $liga[$i] != $liga[$i+1]) {
        $einsichtfile = PATH_TO_ADDONDIR."/tipp/".$tipp_dirtipp."einsicht/".$liga[$i]."_".$spieltag[$i].".ein";
        require(PATH_TO_ADDONDIR."/tipp/lmo-tippcalceinsichtviewer.php");
        $start2 = $i+1;
      }
    }
  }
   
  $addr = $_SERVER['PHP_SELF']."?action=tipp&amp;todo=edit&amp;file=&amp;viewermode=1&amp;start=";
  $savebutton = 0;
  $viewermode = 1;
  $file='';
  $nw = 0;
?>

<div class="container">
  <div class="row">
    <div class="col offset-5"><h1><?php echo $_SESSION['lmotippername'];if($_SESSION['lmotipperverein']!=""){echo " - ".$_SESSION['lmotipperverein'];} ?></h1></div>
  </div>
  <div class="row">
    <div class="col offset-4"><?php if($tipp_tippBis>0){echo $text['tipp'][87]." ".$tipp_tippBis." ".$text['tipp'][88];} ?></div>
  </div>
  <div class="row">
    <div class="col offset-4"><?php echo $text['tipp'][258]." ".$now1." ".$text[4]." ".$then1; ?></div>
  </div>
  <div class="row">
    <div class="col">
    <form name="lmoedit" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="form-inline">
      <input type="hidden" name="action" value="tipp">
      <input type="hidden" name="todo" value="edit">
      <input type="hidden" name="save" value="1">
      <input type="hidden" name="viewermode" value="1">
      <input type="hidden" name="xstart" value="<?php echo $start; ?>">
      <input type="hidden" name="xnow" value="<?php echo $now; ?>">
      <input type="hidden" name="xthen" value="<?php echo $then; ?>">
      <div class="container!"><?php 
  if($anzspiele==0){?>
        <div class="row">
          <div class="col"><?php echo getMessage($text['tipp'][262],TRUE); ?></div>
        </div><?php 
  }
  for($i=0;$i<$anzspiele;$i++){
    if($i==0 || $liga[$i]!=$liga[$i-1]){?>
        <div class="row">
          <div class="col"><?php echo $titel[$i]; ?></div>
        </div><?php 
    }
    if ($i == 0 || $liga[$i] != $liga[$i-1] || $spieltag[$i] != $spieltag[$i-1]) {
      if ($datum1[$i] != "") {
        $datum = explode('.', $datum1[$i]);
        $dum1 = $me[intval($datum[1])]." ".$datum[2];
      } else {
        $dum1 = "";
      }
      if ($datum2[$i] != "") {
        $datum = explode('.', $datum2[$i]);
        $dum2 = $me[intval($datum[1])]." ".$datum[2];
      } else {
        $dum2 = "";
      }
      if ($lmtype[$i] == 1) {
        if ($spieltag[$i] == $anzst[$i]) {
          $j = $text[374];
        } elseif($spieltag[$i] == $anzst[$i]-1) {
          $j = $text[373];
        } elseif($spieltag[$i] == $anzst[$i]-2) {
          $j = $text[372];
        } elseif($spieltag[$i] == $anzst[$i]-3) {
          $j = $text[371];
        } else {
          $j = $spieltag[$i].". ".$text[370];
        }
      }?>
        <div class="row pt-3">
          <div class="col-8"><?php      if ($tipp_tippeinsicht == 1) {
        echo "<strong><a href=\"".$_SERVER['PHP_SELF']."?action=tipp&amp;todo=einsicht&amp;file=".$liga[$i].".l98&amp;st=".$spieltag[$i]."\">";
      }
      if ($lmtype[$i] == 0) {
        echo $spieltag[$i].". ".$text[2];
      } else {
        echo $j;
      }
      if ($tipp_tippeinsicht == 1) {
        echo "</a></strong>";
      }
      if ($dats[$i] == 1) {
        if ($datum1[$i] != "") {
          echo " ".$text[3]." ".$datum1[$i];
        }
        if ($datum2[$i] != "") {
          echo " ".$text[4]." ".$datum2[$i];
        }
      } ?></div><?php
      if($tipp_tippmodus==1){ 
        ?>
          <div class="col-1">
            <acronym title="<?php echo $text['tipp'][241].":".$text['tipp'][242] ?>"><?php echo $text['tipp'][209]; /* Dein Tipp */?></acronym><br><?php 
        if ($goalfaktor[$i]!=1) {
          echo "(".$text[553+log10($goalfaktor[$i])].")";
        }?></div><?php 
      }
      if($tipp_tippmodus==0){ ?>
          <div class="col-1">
            <acronym title="<?php echo $text['tipp'][95] ?>">1</acronym>&nbsp;<?php        if($hidr[$i]==0){ ?>
            <acronym title="<?php echo $text['tipp'][96] ?>">0</acronym>&nbsp;<?php        }else{ ?>
            &nbsp;<?php        }?>
            <acronym title="<?php echo $text['tipp'][97] ?>">2</acronym>
          </div><?php      }
      if ($tipp_jokertipp==1){ ?>
          <div class="col-1">
            <acronym title="<?php echo $text['tipp'][290] ?>"><?php echo $text['tipp'][289]; ?></acronym>
          </div><?php      }?>
          <div class="col-1"><?php echo $text['tipp'][31]; /* Ergebnis*/ ?></div>
          <div class="col-1"><?php echo $text[37]; /* PP */?></div>
        </div><?php 
    }
    if ($tipp_einsichterst == 2) {
      if ($goala[$i] != "_" && $goalb[$i] != "_") {
        $btip1 = false;
      } else {
        $btip1 = true;
      }
    } else {
      $btip1 = false;
    }
    
    $dum1 = ""; 
    if ($datm[$i] == 1) {
      if ($mterm[$i] > 0) {
        $dum1 = datefmt_format($fmt, $mterm[$i]);
      } 
    }?>
        <div class="row">
          <div class="col-2"><?php echo $dum1; ?></div>
          <div class="col-3 text-end"><?php echo $teama[$i];?></div>
          <div class="col-3"> - 
            <?php 
    echo $teamb[$i];
    if ($tippa[$i] == "_") {
      $tippa[$i] = "";
    }
    if ($tippb[$i] == "_") {
      $tippb[$i] = "";
    }
    if ($tippa[$i] == "-1") {
      $tippa[$i] = "";
    }
    if ($tippb[$i] == "-1") {
      $tippb[$i] = "";
    }?>
            
          </div><?php
    $plus = 1;
    $btip = tippaenderbar($mterm[$i], $datum1[$i], $datum2[$i]);
    if ($btip == true) {
       $savebutton = 1;
    }
    if ($tipp_tippmodus == 1) {
      if($btip==true){ ?>
          <div class="col-1">
              <input class="custom-control" style="width:2.2rem;" name="xtippa<?php echo $i; ?>" value="<?php echo $tippa[$i]; ?>"> : <input class="custom-control" style="width:2.2rem;" name="xtippb<?php echo $i; ?>" value="<?php echo $tippb[$i]; ?>">
          </div><?php 
      } else { ?>
          <div class="col-1">
            <?php echo $tippa[$i]; ?> : <?php echo $tippb[$i]; ?>
          </div><?php 
      }
    } /* ende ($tipp_tippmodus==1) */
    if ($tipp_tippmodus == 0) {
      $tipp = -1;
      if ($tippa[$i] == "" || $tippb[$i] == "") {
        $tipp = -1;
      } elseif($tippa[$i] > $tippb[$i]) {
        $tipp = 1;
      } elseif($tippa[$i] == $tippb[$i]) {
        $tipp = 0;
      } elseif($tippa[$i] < $tippb[$i]) {
        $tipp = 2;
      }?>
          <div class="col-1">
            <input type="radio" class="form-check-input" name="xtipp<?php echo $i; ?>" value="1" <?php if($tipp==1){echo " checked";} if($btip==false){echo " disabled";} ?>>
            <?php      if($hidr[$i]==0){ ?>
            <input type="radio" class="form-check-input" name="xtipp<?php echo $i; ?>" value="3" <?php if($tipp==0){echo " checked";} if($btip==false){echo " disabled";} ?>>
          <?php      }?>
            <input type="radio" class="form-check-input" name="xtipp<?php echo $i; ?>" value="2" <?php if($tipp==2){echo " checked";} if($btip==false){echo " disabled";} ?>>
          </div><?php    } // ende ($tipp_tippmodus==0) 
    if ($tipp_jokertipp == 1) {
      if ($tipp_jokertippaktiv[$i] > 0 && $tipp_jokertippaktiv[$i] < time()) {
        $btip = false;
      }?>
          <div class="col-1">
              <input type="radio" class="form-check-input" name="xjokerspiel_<?php echo $liga[$i]."_".$spieltag[$i]; ?>" value="<?php echo $spiel[$i]; ?>" <?php if($jksp[$i]==$spiel[$i]){echo " checked";} if($btip==false){echo " disabled";} ?>>
          </div><?php    }?>                                                                                                                   
          <div class="col-1">
            <?php echo applyFactor($goala[$i],$goalfaktor[$i]); ?> : <?php echo applyFactor($goalb[$i],$goalfaktor[$i]); ?>
          </div>
          <div class="col-1"><?php    if ($tipp_jokertipp == 1 && $jksp[$i] == $spiel[$i]) {
      $jkspfaktor = $tipp_jokertippmulti;
    } else {
      $jkspfaktor = 1;
    }
    $punktespiel = -1;
    if ($tippa[$i] != "" && $tippb[$i] != "" && $goala[$i] != "_" && $goalb[$i] != "_") {
      $punktespiel = tipppunkte($tippa[$i], $tippb[$i], $goala[$i], $goalb[$i], $msieg[$i], $mspez[$i], $text[0], $text[1], $jkspfaktor, $mtipp[$i]);
    }
    if ($punktespiel == -1) {
      echo "-";
    } elseif($punktespiel == -2) {
      echo $text['tipp'][230];
      $nw = 1;
    } else {
      if ($tipp_tippmodus == 1) {
        echo $punktespiel;
      } else {
        if ($punktespiel > 0) {
          echo "<img src='".URL_TO_IMGDIR."/right.gif' border='0' alt=''>";
          if ($punktespiel > 1) {
            echo "+".($punktespiel-1);
          }
        } else {
          echo "<img src='".URL_TO_IMGDIR."/wrong.gif' border='0' alt=''>";
        }
      }
    }    ?>
          </div>
        </div><?php  }?>
        <div class="row pt-3">
          <div class="col"><?php if($savebutton==1){ ?>
              <input title="<?php echo $text[114] ?>" class="btn btn-primary" type="submit" name="best" value="<?php echo $text['tipp'][8]; ?>"><?php  }?>
          </div>
        </div>
      </div>
    </form>
    </div>
  </div>
  <div class="row pt-2">
    <div class="col-6">
      <a href="<?php echo $addr.($start-$tipp_viewertage)?>"><?php echo $text[5]." ".$tipp_viewertage." ".$text['tipp'][257]?></a>
    </div>
    <div class="col-6 text-end">
      <a href="<?php echo $addr.($start+$tipp_viewertage)?>"><?php echo $tipp_viewertage." ".$text['tipp'][256]." ". $text[7]?></a>
    </div>
  </div>
</div><?php }
$einsichtfile="";
$tippfile="";
?>
