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
  */

require_once(PATH_TO_LMO."/lmo-admintest.php");
if ($file != "") {
  $save=isset($_POST['save'])?$_POST['save']:0;

  $tabdat="_";
  $ftest0 = $tipp_tippspiel;
  $liga = basename(substr($file, 0, -4));

  if ($tipp_immeralle == 0) {
    $ftest0 = 0;
    $ftest1 = "";
    $ftest1 = explode(',', $tipp_ligenzutippen);
    if (isset($ftest1)) {
      for($u = 0; $u < count($ftest1); $u++) {
        if ($ftest1[$u] == $liga) {
          $ftest0 = 1;
        }
      }
    }
  }

  if (!isset($nlines)) {
    $nlines = array();
  }

  require_once(PATH_TO_LMO."/lmo-openfile.php");
  if (!isset($save)) {
    $save = 0;
  }

  if ($save == 1) {
    $me = array("0", "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
    if ($_SESSION["lmouserok"] == 2) {
      $datum1[$st-1] = isset($_POST["xdatum1"])?trim($_POST["xdatum1"]):'';
      if ($datum1[$st-1] != "") {
        $datum = explode('.', $datum1[$st-1]);
        $dummy = strtotime($datum[0]." ".$me[intval($datum[1])]." ".$datum[2]);
        if ($dummy > -1) {
          $datum1[$st-1] = date("d.m.Y", $dummy);
        } else {
          $datum1[$st-1] = "";
        }
      }
      $datum2[$st-1] = isset($_POST["xdatum2"])?trim($_POST["xdatum2"]):'';
      if ($datum2[$st-1] != "") {
        $datum = explode('.', $datum2[$st-1]);
        $dummy = strtotime($datum[0]." ".$me[intval($datum[1])]." ".$datum[2]);
        if ($dummy > -1) {
          $datum2[$st-1] = date("d.m.Y", $dummy);
        } else {
          $datum2[$st-1] = "";
        }
      }
    }
    if ($hands == 1) {
      for($i = $st-1; $i < $anzst; $i++) {
        $handp[$i] = 0;
      }
    }
    if ($lmtype != 0) {
      $anzsp2 = $anzteams;
      for($i = 0; $i < $st; $i++) {
        $anzsp2 = $anzsp2/2;
      }
      if (($klfin == 1) && ($st == $anzst)) {
        $anzsp2 = $anzsp2+1;
      }
    } else {
      $anzsp2 = $anzsp;
    }
    for($i = 0; $i < $anzsp2; $i++) {
      if ($lmtype == 0) {
        $dum1 = isset($_POST["xatdat".$i])?trim($_POST["xatdat".$i]):'';
        $dum2 = isset($_POST["xattim".$i])?trim($_POST["xattim".$i]):'';
        if ($dum1 != "") {
          if ($dum2 == "") {
            $dum2 = $deftime;
          }
          $datu1 = explode('.', $dum1);
          $datu2 = explode(':', $dum2);
          $dummy = strtotime($datu1[0]." ".$me[intval($datu1[1])]." ".$datu1[2]." ".$datu2[0].":".$datu2[1]);
          if ($dummy > -1) {
            $mterm[$st-1][$i] = $dummy;
          } else {
            $mterm[$st-1][$i] = "";
          }
        } else {
          $mterm[$st-1][$i] = "";
        }
      } else {
        for($n = 0; $n < $modus[$st-1]; $n++) {
          $dum1 = isset($_POST["xatdat".$i.$n])?trim($_POST["xatdat".$i.$n]):'';
          $dum2 = isset($_POST["xattim".$i.$n])?trim($_POST["xattim".$i.$n]):'';
          if ($dum1 != "") {
            if ($dum2 == "") {
              $dum2 = $deftime;
            }
            $datu1 = explode('.', $dum1);
            $datu2 = explode(':', $dum2);
            $dummy = strtotime($datu1[0]." ".$me[intval($datu1[1])]." ".$datu1[2]." ".$datu2[0].":".$datu2[1]);
            $mterm[$st-1][$i][$n] = $dummy > -1 ? $dummy : '';
          }
        }
      }
      if ($_SESSION['lmouserok'] == 2 || $_SESSION['lmouserokerweitert'] == 1) {
        $teama[$st-1][$i] = isset($_POST["xteama".$i])?$_POST["xteama".$i]:'';
        $teamb[$st-1][$i] = isset($_POST["xteamb".$i])?$_POST["xteamb".$i]:'';
      }
      if ($lmtype == 0) {
        $goala[$st-1][$i] = isset($_POST["xgoala".$i]) ? trim($_POST["xgoala".$i]) : '';
        if ($goala[$st-1][$i] == "" || $goala[$st-1][$i] == "_") {
          $goala[$st-1][$i] = -1;
        } elseif(strtoupper($goala[$st-1][$i]) == "X") {
          $goala[$st-1][$i] = 0;
          $msieg[$st-1][$i] = 1;
        } else {
          $goala[$st-1][$i] = intval(trim($goala[$st-1][$i]));
          if ($goala[$st-1][$i] == "") {
            $goala[$st-1][$i] = "0";
          }
        }
        $goalb[$st-1][$i] = isset($_POST["xgoalb".$i]) ? trim($_POST["xgoalb".$i]) : '';
        if ($goalb[$st-1][$i] == "" || $goalb[$st-1][$i] == "_") {
          $goalb[$st-1][$i] = -1;
        } elseif(strtoupper($goalb[$st-1][$i]) == "X") {
          $goalb[$st-1][$i] = 0;
          $msieg[$st-1][$i] = 2;
        } else {
          $goalb[$st-1][$i] = intval(trim($goalb[$st-1][$i]));
          if ($goalb[$st-1][$i] == "") {
            $goalb[$st-1][$i] = "0";
          }
        }
        $msieg[$st-1][$i] = $_POST["xmsieg".$i];
        if ($spez == 1) {
          $mspez[$st-1][$i] = $_POST["xmspez".$i];
        }
        $mnote[$st-1][$i] = trim($_POST["xmnote".$i]);
        $mberi[$st-1][$i] = trim($_POST["xmberi".$i]);
        if ($_SESSION['lmouserok'] == 2 && $ftest0 == 1) {
          $mtipp[$st-1][$i] = trim($_POST["xmtipp".$i]);
        }
        if (($st < $anzst) && ($favteam > 0) && ($stat1 == $favteam)) {
          for($y = 0; $y < $anzsp; $y++) {
            if ($teama[$st][$y] == $favteam) {
              $stat2 = $teamb[$st][$y];
            }
            if ($teamb[$st][$y] == $favteam) {
              $stat2 = $teama[$st][$y];
            }
          }
        }
      } else {
        for($n = 0; $n < $modus[$st-1]; $n++) {
          $goala[$st-1][$i][$n] = trim($_POST["xgoala".$i.$n]);
          if ($goala[$st-1][$i][$n] == "") {
            $goala[$st-1][$i][$n] = -1;
          } elseif($goala[$st-1][$i][$n] == "_") {
            $goala[$st-1][$i][$n] = -1;
          } else {
            $goala[$st-1][$i][$n] = intval(trim($goala[$st-1][$i][$n]));
            if ($goala[$st-1][$i][$n] == "") {
              $goala[$st-1][$i][$n] = "0";
            }
          }
          $goalb[$st-1][$i][$n] = trim($_POST["xgoalb".$i.$n]);
          if ($goalb[$st-1][$i][$n] == "") {
            $goalb[$st-1][$i][$n] = -1;
          } elseif($goalb[$st-1][$i][$n] == "_") {
            $goalb[$st-1][$i][$n] = -1;
          } else {
            $goalb[$st-1][$i][$n] = intval(trim($goalb[$st-1][$i][$n]));
            if ($goalb[$st-1][$i][$n] == "") {
              $goalb[$st-1][$i][$n] = "0";
            }
          }
          $mspez[$st-1][$i][$n] = $_POST["xmspez".$i.$n];
          $mnote[$st-1][$i][$n] = trim($_POST["xmnote".$i.$n]);
          $mberi[$st-1][$i][$n] = trim($_POST["xmberi".$i.$n]);
          if ($_SESSION['lmouserok'] == 2 && $ftest0 == 1) {
            $mtipp[$st-1][$i][$n] = trim($_POST["xmtipp".$i.$n]);
          }
        }
        if (($st < $anzst) && ($favteam > 0) && ($stat1 == $favteam)) {
          for($y = 0; $y < $anzsp; $y++) {
            if ($teama[$st][$y] == $favteam) {
              $stat2 = $teamb[$st][$y];
            }
            if ($teamb[$st][$y] == $favteam) {
              $stat2 = $teama[$st][$y];
            }
          }
        }
      }
    }

    /*Spieltagsdatum (falls nicht angegeben) aus Spieldaten extrahieren*/

    function array_values_recursive($ary) {
      $lst = array();
      foreach( array_keys($ary) as $k ){
        $v = $ary[$k];
        if (is_scalar($v)) {
           $lst[] = $v;
        } elseif (is_array($v)) {
           $lst = array_merge( $lst, array_values_recursive($v));
        }
      }
      return $lst;
    }
    $lmo_spieltermine=array_filter(array_values_recursive($mterm[$st-1]),"filterZero");
    if (!empty($lmo_spieltermine)) {
      if (empty($datum1[$st-1])) {
        $datum1[$st-1] = date("d.m.Y", min($lmo_spieltermine));
      }
      if (empty($datum2[$st-1])) {
        $datum2[$st-1] = date("d.m.Y", max($lmo_spieltermine));
      }
    }

    // Tippspiel-Addon
    if ($ftest0 == 1) {
      // Liga darf getippt werden
      if ($tipp_aktauswert == 1) {
        require(PATH_TO_ADDONDIR."/tipp/lmo-tippsavewert.php");
      }
      if ($tipp_aktauswertges == 1) {
        require(PATH_TO_ADDONDIR."/tipp/lmo-tippsavewertgesamt.php");
      }
    }
    // Tippspiel-Addon
    $stz = trim($_POST["xstx"]);
    if ($stz != 0) {
      $stx = $stz;
    } else {
      $stx = $st;
    }
    $stz = $st;
    $st = $stx;
    $nticker = trim($_POST["xnticker"]);
    $nlines = explode("\n", $_POST["xnlines"]);
    if (count($nlines) > 0) {
      for($z = count($nlines)-1; $z >= 0; $z--) {
        $y = array_pop($nlines);
        if ($y != "") {
          array_unshift($nlines, $y);
        }
      }
    }
    require(PATH_TO_LMO."/lmo-savefile.php");
    $st = $stz;
  }
  
  // Rückrunden-Hack
  if($save == 990) require_once("lmo-rueckrunde.php");

  if ($lmtype != 0) {
    if ($st > 1) {
      $teamt = array_pad(array("0"), 129, "0");
      for($i = 0; $i < ($st-1); $i++) {
        for($j = 0; $j < (($anzteams/2)+1); $j++) {
          $m1 = array($goala[$i][$j][0], $goala[$i][$j][1], $goala[$i][$j][2], $goala[$i][$j][3], $goala[$i][$j][4], $goala[$i][$j][5], $goala[$i][$j][6]);
          $m2 = array($goalb[$i][$j][0], $goalb[$i][$j][1], $goalb[$i][$j][2], $goalb[$i][$j][3], $goalb[$i][$j][4], $goalb[$i][$j][5], $goalb[$i][$j][6]);
          $m = gewinn($i, $j, $modus[$i], $m1, $m2);
          if ($m == 1) {
            $teamt[$teamb[$i][$j]] = 1;
          } elseif($m == 2) {
            $teamt[$teama[$i][$j]] = 1;
          }
          if (($klfin == 1) && ($i == $st-2)) {
            if ($m == 1) {
              $teamt[$teamb[$i][$j]] = 2;
            } elseif($m == 2) {
              $teamt[$teama[$i][$j]] = 2;
            }
          }
        }
      }
    }
  }
  $addr = $_SERVER['PHP_SELF']."?action=admin&amp;todo=edit&amp;file=".$file."&amp;st=";
  $addb = $_SERVER['PHP_SELF']."?action=admin&amp;todo=tabs&amp;file=".$file."&amp;st=";

  include(PATH_TO_LMO."/lmo-adminsubnavi.php");?>

<div class="container">
  <div class="row pt-3">
    <div class="col d-flex justify-content-center"><h1><?php echo $titel?></h1></div>
  </div>
  <div class="row p-1">
    <div class="col">
      <?php include (PATH_TO_LMO."/lmo-spieltagsmenu.php");?>
      <?php if ($lmtype == 0) { ?>
	<form  name="lmoedit" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
	  <input type="hidden" name="action" value="admin">
	  <input type="hidden" name="todo" value="edit">
	  <input type="hidden" name="save" value="990">
	  <input type="hidden" name="file" value="<?php echo $file; ?>">
	  <input type="hidden" name="st" value="<?php echo $st; ?>">
	  <input type="submit" name="rueckrundeButton" class="btn btn-primary btn-sm" value="<?php echo $text[3000]; ?>">
	 </form>
      <?php } ?>
    </div>
  </div>
  <div class="row p-1">
    <div class="col">
      <form name="lmoedit" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" onSubmit="return chklmopass()" class="form-inline">
        <input type="hidden" name="action" value="admin">
        <input type="hidden" name="todo" value="edit">
        <input type="hidden" name="save" value="1">
        <input type="hidden" name="file" value="<?php echo $file; ?>">
        <input type="hidden" name="st" value="<?php echo $st; ?>">
        <div class="container">
          <div class="row">
            <div class="col-8 text-start pb-3"><?php
  echo $st.". ".$text[2];
  if ($datum1[$st-1] != "") {
    $datum = explode('.', $datum1[$st-1]);
    $dum1 = $me[intval($datum[1])]." ".$datum[2];
  } else {
    $dum1 = "";
  }
  if ($datum2[$st-1] != "") {
    $datum = explode('.', $datum2[$st-1]);
    $dum2 = $me[intval($datum[1])]." ".$datum[2];
  } else {
    $dum2 = "";
  }
  if($_SESSION['lmouserok']==2 || $_SESSION['lmouserokerweitert']==1){ ?>
               <?php echo $text[3]?> <input class="custom-control" size="6" type="text" name="xdatum1" tabindex="1" maxlength="10" value="<?php echo $datum1[$st-1]; ?>" onChange="dolmoedit()">
               <?php echo $text[4]?> <input class="custom-control" size="6" type="text" name="xdatum2" tabindex="2" maxlength="10" value="<?php echo $datum2[$st-1]; ?>" onChange="dolmoedit()"><?php
  }?>
            </div><?php
  if ($goalfaktor!=1) {?>
            <div class="col-1"><?php if ($goalfaktor!=1) {echo "(".$text[553+log10($goalfaktor)].")";}?></div><?php
  } else {?>
            <div class="col-1">&nbsp;</div><?php
  }?>
            <div class="col-1"><acronym title="<?php echo $text[213] ?>"><i class="bi bi-chat-fill text-success" style="font-size: 1.3rem;"></i></acronym></div>
            <div class="col-1"><acronym title="<?php echo $text[112] ?>"><i class="bi bi-info-circle-fill text-info" style="font-size: 1.3rem;"></i></acronym></div>
            <div class="col-1"><acronym title="<?php echo $text[263] ?>"><i class="bi bi-box-arrow-up-right text-warning" style="font-size: 1.3rem;"></i></acronym></div><?php
  if($_SESSION['lmouserok']==2 && $ftest0==1){ ?>
            <div class="col-1"><?php echo $text['tipp'][57]; ?></div><?php
  }?>
          </div><?php
  if ($lmtype != 0) {
    $anzsp = $anzteams;
    for($i = 0; $i < $st; $i++) {
      $anzsp = $anzsp/2;
    }
    if (($klfin == 1) && ($st == $anzst)) {
      $anzsp = $anzsp+1;
    }
  }
  for($i = 0; $i < $anzsp; $i++) {
    if ($lmtype == 0) {?>
          <div class="row p-1"><?php
      if ($mterm[$st-1][$i] > 0) {
        $dum1 = date("d.m.Y", $mterm[$st-1][$i]);
        $dum2 = date("H:i", $mterm[$st-1][$i]);
        $dum3 = $me[intval(date("m", $mterm[$st-1][$i]))]." ".date("Y", $mterm[$st-1][$i]);
      } else {
        $dum1 = "";
        $dum2 = "";
        $dum3 = "";
      }?>
            <div class="col-2">
              <input title="<?php echo $text[122] ?>" class="custom-control" type="text" name="xatdat<?php echo $i; ?>" tabindex="<?php echo $i;?>3" size="6" maxlength="10" value="<?php echo $dum1; ?>" onChange="dolmoedit()" ondblclick="fillAll(this);">
              <input title="<?php echo $text[123] ?>" class="custom-control" type="text" name="xattim<?php echo $i; ?>" tabindex="<?php echo $i;?>4" size="2" maxlength="5" value="<?php echo $dum2; ?>" onChange="dolmoedit()" ondblclick="fillAll(this);">
            </div>
            <div class="col-2"><?php
      if($_SESSION['lmouserok']==2 || $_SESSION['lmouserokerweitert']==1){ ?>
              <select class="form-select" name="xteama<?php echo $i; ?>" onChange="dolmoedit()" tabindex="<?php echo $i;?>5" data-size="7"><?php
        for($y = 0; $y <= $anzteams; $y++) {?>
                <option value="<?php echo $y?>"<?php if ($y == $teama[$st-1][$i]) {echo " selected";}?>><?php echo $teams[$y]?></option><?php
        }?>
              </select><?php
      } else {
        echo $teams[$teama[$st-1][$i]];
      }?>
            </div>
            <div class="col-1"> vs. </div>
            <div class="col-2"><?php
      if($_SESSION['lmouserok']==2 || $_SESSION['lmouserokerweitert']==1){ ?>
              <select class="form-select" name="xteamb<?php echo $i; ?>" onChange="dolmoedit()" title="<?php echo $text[108] ?>" tabindex="<?php echo $i;?>6" data-size="7"><?php
        for($y = 0; $y <= $anzteams; $y++) {?>
                <option value="<?php echo $y?>"<?php if ($y == $teamb[$st-1][$i]) {echo " selected";}?>><?php echo $teams[$y]?></option><?php
        }?>
              </select><?php
      } else {
        echo $teams[$teamb[$st-1][$i]];
      }
      if($goala[$st-1][$i]=="-1"){
        $goala[$st-1][$i]="_";
      }
      if($goalb[$st-1][$i]=="-1"){
        $goalb[$st-1][$i]="_";
      }?>
            </div>
            <div class="col-2">
              <input title="<?php echo $text[109] ?>" class="custom-control" style="width: 4rem;" type="number" name="xgoala<?php echo $i; ?>" tabindex="<?php echo $i;?>7" min="0" maxlength="4" value="<?php echo $goala[$st-1][$i]; ?>">
              :
              <input title="<?php echo $text[110] ?>" class="custom-control" style="width: 4rem;" type="number" name="xgoalb<?php echo $i; ?>" tabindex="<?php echo $i;?>8" min="0" maxlength="4" value="<?php echo $goalb[$st-1][$i]; ?>">
            </div><?php
      if($spez==1){?>
            <div class="col-1">
              <select class="form-select" name="xmspez<?php echo $i; ?>" onChange="dolmoedit()" tabindex="<?php echo $i;?>9">
                <option<?php if($mspez[$st-1][$i]=="&nbsp;"){echo " selected";}?>>_</option>
                <option<?php if($mspez[$st-1][$i]==$text[0]){echo " selected";}?>><?php echo $text[0]?></option>
                <option<?php if($mspez[$st-1][$i]==$text[1]){echo " selected";}?>><?php echo $text[1]?></option>
              </select>
            </div><?php
      }?>
            <div class="col-1">
              <select class="form-select" id="gT<?php echo $i?>"  name="xmsieg<?php echo $i; ?>" onChange="dolmoedit()" tabindex="<?php echo $i;?>10">
                <option value="0"<?php if($msieg[$st-1][$i]==0){echo " selected";}?>>_</option>
                <option value="1"<?php if($msieg[$st-1][$i]==1){echo " selected";}?>><?php echo $text[214]?></option>
                <option value="2"<?php if($msieg[$st-1][$i]==2){echo " selected";}?>><?php echo $text[215]?></option>
                <option value="3"<?php if($msieg[$st-1][$i]==3){echo " selected";}?>><?php echo $text[216]?></option>
              </select><?php
      if($msieg[$st-1][$i]==0) {?>
              <script type="text/javascript">document.getElementById('gT<?php echo $i?>').style.display='none';document.write('<a href="#" onClick="this.style.display=\'none\';document.getElementById(\'gT<?php echo $i?>\').style.display=\'inline\';return false;">+</a>');</script><?php
      }?>
            </div>
            <div class="col-1">
              <input id="n<?php echo $i?>" class="custom-control" type="text" name="xmnote<?php echo $i; ?>" tabindex="<?php echo $i;?>11" size="16" maxlength="255" value="<?php echo htmlentities($mnote[$st-1][$i]); ?>" onChange="dolmoedit()"><?php
      if (trim($mnote[$st-1][$i]) == '') {?>
              <script type="text/javascript">document.getElementById('n<?php echo $i?>').style.display='none';document.write('<a href="#" onClick="this.style.display=\'none\';document.getElementById(\'n<?php echo $i?>\').style.display=\'inline\';return false;">+</a>');</script><?php
      }?>
            </div>
            <div class="col-1"><input id="s<?php echo $i?>" class="custom-control" type="text" name="xmberi<?php echo $i; ?>" tabindex="<?php echo $i;?>12" size="14" maxlength="255" value="<?php echo htmlentities($mberi[$st-1][$i]); ?>" onChange="dolmoedit()"><?php
      if (trim($mberi[$st-1][$i]) == '') {?>
              <script type="text/javascript">document.getElementById('s<?php echo $i?>').style.display='none';document.write('<a href="#" onClick="this.style.display=\'none\';document.getElementById(\'s<?php echo $i?>\').style.display=\'inline\';return false;">+</a>');</script><?php
      }?>
            </div>
          </div><?php
      /*Tippspiel-Addon*/
      if($_SESSION['lmouserok']==2 && $ftest0==1){ ?>
          <div class="row p-1">
            <div class="col-2 offset-7">
              <select class="form-select" name="xmtipp<?php echo $i; ?>" onChange="dolmoedit()" tabindex="<?php echo $i;?>13">
                <option value="0"<?php if($mtipp[$st-1][$i]<1){echo " selected";}?>>_</option>
                <option value="1"<?php if($mtipp[$st-1][$i]==1){echo " selected";}?>><?php echo $text['tipp'][199]?></option>
              </select>
            </div>
          </div><?php
      }
    } else {
      /*Pokalmodus*/
      for($n=0;$n<$modus[$st-1];$n++){
        if(($klfin==1) && ($st==$anzst)){ ?>
          <div class="row">
            <div class="col"><?php if($i==1){echo "&nbsp;<br>";} echo $text[419+$i]; ?></div>
          </div><?php
        }?>
          <div class="row"><?php
        if ($mterm[$st-1][$i][$n] > 0) {
          $dum1 = date("d.m.Y", $mterm[$st-1][$i][$n]);
          $dum2 = date("H:i", $mterm[$st-1][$i][$n]);
          $dum3 = $me[intval(date("m", $mterm[$st-1][$i][$n]))]." ".date("Y", $mterm[$st-1][$i][$n]);
        } else {
          $dum1 = "";
          $dum2 = "";
          $dum3 = "";
        }?>
            <div class="col-2">
              <input title="<?php echo $text[122] ?>" class="custom-control" type="text" name="xatdat<?php echo $i.$n; ?>" tabindex="<?php echo $i.$n;?>3" size="6" maxlength="10" value="<?php echo $dum1; ?>" onChange="dolmoedit()">
              <input title="<?php echo $text[123] ?>" class="custom-control" type="text" name="xattim<?php echo $i.$n; ?>" tabindex="<?php echo $i.$n;?>4" size="2" maxlength="5" value="<?php echo $dum2; ?>" onChange="dolmoedit()">
            </div>
            <?php

          if($n==0){ ?>
            <div class="col-2"><?php
          if($_SESSION['lmouserok']==2 || $_SESSION['lmouserokerweitert']==1){?>
              <select class="form-select" name="xteama<?php echo $i; ?>" onChange="dolmoedit()" title="<?php echo $text[107] ?>" tabindex="<?php echo $i.$n;?>5"><?php

            if (($klfin == 1) && ($st == $anzst) && ($i == 1)) {
              echo "<option value=\"0\"";
              if ($teama[$st-1][$i] == 0) {
                echo " selected";
              }
              echo ">".$teams[0]."</option>";
              for($y = 1; $y <= $anzteams; $y++) {
                if (($playdown==0 && $teamt[$y] == 2) || $playdown==1) {
                  echo "<option value=\"".$y."\"";
                  if ($y == $teama[$st-1][$i]) {
                    echo " selected";
                  }
                  echo ">".$teams[$y]."</option>";
                }
              }
            } else {
              for($y = 0; $y <= $anzteams; $y++) {
                if (($playdown==0 && $teamt[$y] == 0) || $playdown==1) {
                  echo "<option value=\"".$y."\"";
                  if ($y == $teama[$st-1][$i]) {
                    echo " selected";
                  }
                  echo ">".$teams[$y]."</option>";
                }
              }
            }?>
              </select><?php
          } else {
            echo $teams[$teama[$st-1][$i]];
          }?>
            </div>
            <div class="col-1">vs.</div>
            <div class="col-2"><?php
          if($_SESSION['lmouserok']==2 || $_SESSION['lmouserokerweitert']==1){?>
              <select class="form-select" name="xteamb<?php echo $i; ?>" onChange="dolmoedit()" title="<?php echo $text[108] ?>" tabindex="<?php echo $i.$n;?>6"><?php
            if (($klfin == 1) && ($st == $anzst) && ($i == 1)) {
              echo "<option value=\"0\"";
              if ($teamb[$st-1][$i] == 0) {
                echo " selected";
              }
              echo ">".$teams[0]."</option>";
              for($y = 1; $y <= $anzteams; $y++) {
                if (($playdown==0 && $teamt[$y] == 2) || $playdown==1) {
                  echo "<option value=\"".$y."\"";
                  if ($y == $teamb[$st-1][$i]) {
                    echo " selected";
                  }
                  echo ">".$teams[$y]."</option>";
                }
              }
            } else {
              for($y = 0; $y <= $anzteams; $y++) {
                if (($playdown==0 && $teamt[$y] == 0) || $playdown==1) {
                  echo "<option value=\"".$y."\"";
                  if ($y == $teamb[$st-1][$i]) {
                    echo " selected";
                  }
                  echo ">".$teams[$y]."</option>";
                }
              }
            }?>
              </select><?php
          } else {
            echo $teams[$teamb[$st-1][$i]];
          }?>
            </div><?php
        } else {?>
            <div class="col-5">&nbsp;</div><?php
        }
        if ($goala[$st-1][$i][$n] == "-1") {
          $goala[$st-1][$i][$n] = "_";
        }
        if ($goalb[$st-1][$i][$n] == "-1") {
          $goalb[$st-1][$i][$n] = "_";
        }?>
            <div class="col-2">
              <input title="<?php echo $text[109] ?>" class="custom-control" style="width: 4rem" type="number" name="xgoala<?php echo $i.$n; ?>" tabindex="<?php echo $i.$n;?>7" min="0" smaxlength="4" value="<?php echo $goala[$st-1][$i][$n]; ?>">
              :
              <input title="<?php echo $text[110] ?>" class="custom-control" style="width: 4rem;" type="number" name="xgoalb<?php echo $i.$n; ?>" tabindex="<?php echo $i.$n;?>8" min="0" maxlength="4" value="<?php echo $goalb[$st-1][$i][$n]; ?>">
            </div>
            <div class="col-1">
              <select class="form-select" name="xmspez<?php echo $i.$n; ?>" onChange="dolmoedit()" title="<?php echo $text[111] ?>" tabindex="<?php echo $i.$n;?>9">
                <option<?php if($mspez[$st-1][$i][$n]=="&nbsp;"){echo " selected";}?>>_</option>
                <option<?php if($mspez[$st-1][$i][$n]==$text[0]){echo " selected";}?>><?php echo $text[0]?></option>
                <option<?php if($mspez[$st-1][$i][$n]==$text[1]){echo " selected";}?>><?php echo $text[1]?></option>
              </select>
            </div>
            <div class="col-1">
              <input id="n<?php echo $i.$n?>" class="custom-control" type="text" name="xmnote<?php echo $i.$n; ?>" size="16" maxlength="255" value="<?php echo htmlentities($mnote[$st-1][$i][$n]); ?>" onChange="dolmoedit()" tabindex="<?php echo $i;?>10"><?php
      if (trim($mnote[$st-1][$i][$n]) == '') {?>
              <script type="text/javascript">document.getElementById('n<?php echo $i.$n?>').style.display='none';document.write('<a href="#" onClick="this.style.display=\'none\';document.getElementById(\'n<?php echo $i.$n?>\').style.display=\'inline\';return false;">+</a>');</script><?php
      }?>
            </div>
             <div class="col-1">
              <input id="s<?php echo $i.$n?>" class="custom-control" type="text" name="xmberi<?php echo $i.$n; ?>" size="16" maxlength="255" value="<?php echo htmlentities($mberi[$st-1][$i][$n]); ?>" onChange="dolmoedit()" tabindex="<?php echo $i;?>11"><?php
      if (trim($mberi[$st-1][$i][$n]) == '') {?>
              <script type="text/javascript">document.getElementById('s<?php echo $i.$n?>').style.display='none';document.write('<a href="#" onClick="this.style.display=\'none\';document.getElementById(\'s<?php echo $i.$n?>\').style.display=\'inline\';return false;">+</a>');</script><?php
      }?>
            </div>
        <?php
        /**Tippspiel-Addon*/
        if($_SESSION['lmouserok']==2 && $ftest0==1){ echo $ftest0;?>
            <div class="col-auto">
              <select class="form-select" name="xmtipp<?php echo $i.$n; ?>" onChange="dolmoedit()" title="<?php echo $text['tipp'][57] ?>" tabindex="<?php echo $i.$n;?>12">
                <option value="0"<?php if($mtipp[$st-1][$i][$n]<1){echo " selected";}?>>_</option>
                <option value="1"<?php if($mtipp[$st-1][$i][$n]==1){echo " selected";}?>><?php echo $text['tipp'][199]?></option>
              </select>
            </div><?php
        }?>
          </div><?php
      }
      if(($modus[$st-1]>1) && ($i<$anzsp-1)){ ?>
          <div class="row">
            <div class="col">&nbsp;</div>
          </div><?php
      }
    }
  }?>
          <div class="row p-3">
            <div class="col"><?php echo $text[206]; ?></div>
          </div>
          <div class="row">
            <div class="col-auto offset-4">
              <?php echo $text[191]; ?>
              <select class="form-select" name="xstx" onChange="dolmoedit()" tabindex="<?php echo $i;?>13"><?php
  for($y = 0; $y <= $anzst; $y++) {
    echo "<option value=\"".$y."\"";
    if ($save == 1) {
      if ($y == 0) {
        echo ">".$text[403]."</option>";
      } else {
        if ($y == $stx) {
          echo " selected";
        }
        echo ">".$y.". ".$text[2]."</option>";
      }
    } else {
      if ($y == 0) {
        echo " selected>".$text[403]."</option>";
      } else {
        echo ">".$y.". ".$text[2]."</option>";
      }
    }
  }?>
              </select>
            </div>
            <div class="col-auto">
              <?php echo $text[207]; ?>
              <select class="form-select" name="xnticker" onChange="dolmoedit()">
                <option value="1"<?php if($nticker==1){echo " selected";}?>><?php echo $text[181]?></option>
                <option value="0"<?php if($nticker==0){echo " selected";}?>><?php echo $text[182]?></option>
              </select>
            </div>
          </div>
          <div class="row p-3">
            <div class="col-4 offset-4">
              Tickertext: <textarea class="form-control" name="xnlines" cols="50" rows="4" onChange="dolmoedit()"><?php if(count($nlines)>0){foreach($nlines as $y){echo $y."\n";}} ?></textarea>
            </div>
          </div>
          <div class="row p-3">
            <div class="col">
              <input title="<?php echo $text[114] ?>" class="btn btn-primary btn-sm" type="submit" name="best" value="<?php echo $text[103]; ?>">
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</div><?php
}?>