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
  
  
require_once(PATH_TO_LMO."/lmo-admintest.php");
if ($file != "") {
  $save=isset($_POST['save'])?$_POST['save']:0;
  
  $tabdat="_";
  $ftest0 = 1;
  $liga = substr($file, 0, -4);
   
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
  function gewinn ($gst, $gsp, $gmod, $m1, $m2) {
    $erg = 0;
    if ($gmod == 1) {
      if ($m1[0] > $m2[0]) {
        $erg = 1;
      } elseif($m1[0] < $m2[0]) {
        $erg = 2;
      }
    } elseif($gmod == 2) {
      if (($m1[0]+$m1[1]) > ($m2[0]+$m2[1])) {
        $erg = 1;
      } elseif(($m1[0]+$m1[1]) < ($m2[0]+$m2[1])) {
        $erg = 2;
      } else {
        if ($m2[0] > $m1[1]) {
          $erg = 2;
        } elseif($m2[0] < $m1[1]) {
          $erg = 1;
        }
      }
    } else {
      $erg1 = 0;
      $erg2 = 0;
      for($k = 0; $k < $gmod; $k++) {
        if (($m1[$k] != "_") && ($m2[$k] != "_")) {
          if ($m1[$k] > $m2[$k]) {
            $erg1++;
          } elseif($m1[$k] < $m2[$k]) {
            $erg2++;
          }
        }
      }
      if ($erg1 > ($gmod/2)) {
        $erg = 1;
      } elseif($erg2 > ($gmod/2)) {
        $erg = 2;
      }
    }
    return $erg;
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
          $datum1[$st-1] = strftime("%d.%m.%Y", $dummy);
        } else {
          $datum1[$st-1] = "";
        }
      }
      $datum2[$st-1] = isset($_POST["xdatum2"])?trim($_POST["xdatum2"]):'';
      if ($datum2[$st-1] != "") {
        $datum = explode('.', $datum2[$st-1]);
        $dummy = strtotime($datum[0]." ".$me[intval($datum[1])]." ".$datum[2]);
        if ($dummy > -1) {
          $datum2[$st-1] = strftime("%d.%m.%Y", $dummy);
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
        $datum1[$st-1] = strftime("%d.%m.%Y", min($lmo_spieltermine));
      }
      if (empty($datum2[$st-1])) {
        $datum2[$st-1] = strftime("%d.%m.%Y", max($lmo_spieltermine));
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
  if ($lmtype != 0) {
    if ($st > 1) {
      $teamt = array_pad(array("0"), 129, "0");
      for($i = 0; $i < ($st-1); $i++) {
        for($j = 0; $j < (($anzteams/2)+1); $j++) {
          $m1 = array($goala[$i][$j][0], $goala[$i][$j][1], $goala[$i][$j][2], $goala[$i][$j][3], $goala[$i][$j][4], $goala[$i][$j][5], $goala[$i][$j][6]);
          $m2 = array($goalb[$i][$j][0], $goalb[$i][$j][1], $goalb[$i][$j][2], $goalb[$i][$j][3], $goalb[$i][$j][4], $goalb[$i][$j][5], $goalb[$i][$j][6]);
          $m = call_user_func('gewinn', $i, $j, $modus[$i], $m1, $m2);
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
  $breite = 18-$lmtype;
  if ($spez == 1) {
    $breite = $breite+1+(-1)*(0-$lmtype);
  }
   
  include(PATH_TO_LMO."/lmo-adminsubnavi.php");?>

<table class="lmoMiddle" cellspacing="0" cellpadding="0" border="0">
  <tr>
    <td align="center"><h1><?=$titel?></h1></td>
  </tr>
  <tr>
    <td align="center"><?include (PATH_TO_LMO."/lmo-spieltagsmenu.php");?></td>
  </tr>
  <tr>
    <td align="center">
      <form name="lmoedit" action="<?=$_SERVER['PHP_SELF']; ?>" method="post" onSubmit="return chklmopass()">
        <input type="hidden" name="action" value="admin">
        <input type="hidden" name="todo" value="edit">
        <input type="hidden" name="save" value="1">
        <input type="hidden" name="file" value="<?=$file; ?>">
        <input type="hidden" name="st" value="<?=$st; ?>">
        <table class="lmoInner" cellspacing="0" cellpadding="0" border="0">
          <tr>
            <th class="nobr" align="left" colspan="<?=$breite-10; ?>"><?
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
              <acronym title="<?=$text[105] ?>"> <?=$text[3]?></acronym> <input class="lmo-formular-input" type="text" name="xdatum1" tabindex="1" size="10" maxlength="10" value="<?=$datum1[$st-1]; ?>" onChange="dolmoedit()"> <script type="text/javascript">document.write('<a href="#" onclick="opencal(\'xdatum1\',\'<?=$dum1; ?>\')" title="<?=$text[139]; ?>" onMouseOver="lmoimg(\'d1\',img5)" onMouseOut="lmoimg(\'d1\',img4)"><img src="<?=URL_TO_IMGDIR?>/lmo-admin4.gif" name="ximgd1" width="12" height="11" border="0"></a>');</script>
              <acronym title="<?=$text[106] ?>"> <?=$text[4]?></acronym> <input class="lmo-formular-input" type="text" name="xdatum2" tabindex="2" size="10" maxlength="10" value="<?=$datum2[$st-1]; ?>" onChange="dolmoedit()"> <script type="text/javascript">document.write('<a href="#" onclick="opencal(\'xdatum2\',\'<?=$dum2; ?>\')" title="<?=$text[139]; ?>" onMouseOver="lmoimg(\'d2\',img5)" onMouseOut="lmoimg(\'d2\',img4)"><img src="<?=URL_TO_IMGDIR?>/lmo-admin4.gif" name="ximgd2" width="12" height="11" border="0"></a>');</script><? 
  }?>
            </th><?
  if ($goalfaktor!=1) {?>
            <th class="nobr" colspan="<?=$breite-13; ?>"><?if ($goalfaktor!=1) {echo "(".$text[553+log10($goalfaktor)].")";}?></th><?
  } else {?>
            <th colspan="<?=$breite-13; ?>">&nbsp;</th><? 
  }
  if($lmtype==0){ ?>
            <th class="nobr"><acronym title="<?=$text[213] ?>"><img src="<?=URL_TO_IMGDIR;?>/paragraph.gif" width="17" height="17" alt="<?=$text[217]; ?>"></acronym></th><? 
  }?>
            <th class="nobr"><acronym title="<?=$text[112] ?>"><img src="<?=URL_TO_IMGDIR;?>/notiz.gif" width="17" height="17" alt="<?=$text[218]; ?>"></acronym></th>
            <th class="nobr"><acronym title="<?=$text[263] ?>"><img src="<?=URL_TO_IMGDIR;?>/spielbericht.gif" width="17" height="17" alt="<?=$text[262]; ?>"></acronym></th><? 
  if($_SESSION['lmouserok']==2 && $ftest0==1){ ?>
            <th class="nobr"><acronym title="<?=$text['tipp'][57] ?>"><?=$text['tipp'][57]; ?></acronym></th><? 
  }?>
          </tr><?
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
          <tr><?
      if ($mterm[$st-1][$i] > 0) {
        $dum1 = strftime("%d.%m.%Y", $mterm[$st-1][$i]);
        $dum2 = strftime("%H:%M", $mterm[$st-1][$i]);
        $dum3 = $me[intval(strftime("%m", $mterm[$st-1][$i]))]." ".strftime("%Y", $mterm[$st-1][$i]);
      } else {
        $dum1 = "";
        $dum2 = "";
        $dum3 = "";
      }?>
            <td class="nobr"><input title="<?=$text[122] ?>" class="lmo-formular-input" type="text" name="xatdat<?=$i; ?>" tabindex="<?=$i;?>3" size="10" maxlength="10" value="<?=$dum1; ?>" onChange="dolmoedit()" ondblclick="fillAll(this);"><script type="text/javascript">document.write('<a href="#" onclick="opencal(\'xatdat<?=$i; ?>\',\'<?=$dum3; ?>\')" title="<?=$text[139]; ?>" onMouseOver="lmoimg(\'<?=$i; ?>c\',img5)" onMouseOut="lmoimg(\'<?=$i; ?>c\',img4)"><img src="<?=URL_TO_IMGDIR?>/lmo-admin4.gif" name="ximg<?=$i; ?>c" width="12" height="11" border="0"><\/a>');</script></td>
            <td><input title="<?=$text[123] ?>" class="lmo-formular-input" type="text" name="xattim<?=$i; ?>" tabindex="<?=$i;?>4" size="5" maxlength="5" value="<?=$dum2; ?>" onChange="dolmoedit()" ondblclick="fillAll(this);"></td>
            <td width="2">&nbsp;</td>
            <td class="nobr" align="right"><? 
      if($_SESSION['lmouserok']==2 || $_SESSION['lmouserokerweitert']==1){ ?>
              <select class="lmo-formular-input" name="xteama<?=$i; ?>" onChange="dolmoedit()" tabindex="<?=$i;?>5"><?
        for($y = 0; $y <= $anzteams; $y++) {?>
                <option value="<?=$y?>"<?if ($y == $teama[$st-1][$i]) {echo " selected";}?>><?=$teams[$y]?></option><?
        }?>
              </select><? 
      } else { 
        echo $teams[$teama[$st-1][$i]];
      }?>
            </td>
            <td align="center" width="10">-</td>
            <td class="nobr"><?
      if($_SESSION['lmouserok']==2 || $_SESSION['lmouserokerweitert']==1){ ?>
              <select class="lmo-formular-input" name="xteamb<?=$i; ?>" onChange="dolmoedit()" title="<?=$text[108] ?>" tabindex="<?=$i;?>6"><?
        for($y = 0; $y <= $anzteams; $y++) {?>
                <option value="<?=$y?>"<?if ($y == $teamb[$st-1][$i]) {echo " selected";}?>><?=$teams[$y]?></option><?
        }?>
              </select><?
      } else {
        echo $teams[$teamb[$st-1][$i]];
      }
      if($goala[$st-1][$i]=="-1"){
        $goala[$st-1][$i]="_";
      }
      if($goalb[$st-1][$i]=="-1"){
        $goalb[$st-1][$i]="_";
      }?>
            </td>
            <td width="2">&nbsp;</td>
            <td class="lmoBackMarkierung" align="right"><input title="<?=$text[109] ?>" class="lmo-formular-input" type="text" name="xgoala<?=$i; ?>" tabindex="<?=$i;?>7" size="2" maxlength="4" value="<?=$goala[$st-1][$i]; ?>" onChange="lmotorgte('a','<?=$i; ?>')" onKeyDown="lmotorclk('a','<?=$i; ?>',event.keyCode)"></td>
            <td class="lmoBackMarkierung nobr" align="center">
              <table cellpadding="0" cellspacing="0" border="0">
                <tr>
                  <td><script type="text/javascript">document.write('<a href="#" onclick="lmotorauf(\'a\',\'<?=$i; ?>\',1);return false;" title="<?=$text[120]; ?>" onMouseOver="lmoimg(\'<?=$i; ?>a\',img1)" onMouseOut="lmoimg(\'<?=$i; ?>a\',img0)"><img src="<?=URL_TO_IMGDIR?>/lmo-admin0.gif" name="ximg<?=$i; ?>a" width="7" height="7" border="0"><\/a>')</script></td>
                </tr>
                <tr>
                  <td><script type="text/javascript">document.write('<a href="#" onclick="lmotorauf(\'a\',\'<?=$i; ?>\',-1);return false;" title="<?=$text[120]; ?>" onMouseOver="lmoimg(\'<?=$i; ?>b\',img3)" onMouseOut="lmoimg(\'<?=$i; ?>b\',img2)"><img src="<?=URL_TO_IMGDIR?>/lmo-admin2.gif" name="ximg<?=$i; ?>b" width="7" height="7" border="0"><\/a>')</script></td>
                </tr>
              </table>
            </td>
            <td class="lmoBackMarkierung" align="center" width="8">:</td>
            <td class="lmoBackMarkierung" align="right"><input title="<?=$text[110] ?>" class="lmo-formular-input" type="text" name="xgoalb<?=$i; ?>" tabindex="<?=$i;?>8" size="2" maxlength="4" value="<?=$goalb[$st-1][$i]; ?>" onChange="lmotorgte('b','<?=$i; ?>')" onKeyDown="lmotorclk('b','<?=$i; ?>',event.keyCode)"></td>
            <td class="lmoBackMarkierung" align="center">
              <table cellpadding="0" cellspacing="0" border="0">
                <tr>
                  <td valign="bottom"><script type="text/javascript">document.write('<a href="#" onclick="lmotorauf(\'b\',\'<?=$i; ?>\',1);return false;" title="<?=$text[121]; ?>" onMouseOver="lmoimg(\'<?=$i; ?>f\',img1)" onMouseOut="lmoimg(\'<?=$i; ?>f\',img0)"><img src="<?=URL_TO_IMGDIR?>/lmo-admin0.gif" name="ximg<?=$i; ?>f" width="7" height="7" border="0"><\/a>')</script></td>
                </tr>
                <tr>
                  <td valign="top"><script type="text/javascript">document.write('<a href="#" onclick="lmotorauf(\'b\',\'<?=$i; ?>\',-1);return false;" title="<?=$text[121]; ?>" onMouseOver="lmoimg(\'<?=$i; ?>d\',img3)" onMouseOut="lmoimg(\'<?=$i; ?>d\',img2)"><img src="<?=URL_TO_IMGDIR?>/lmo-admin2.gif" name="ximg<?=$i; ?>d" width="7" height="7" border="0"><\/a>')</script></td>
                </tr>
              </table>
            </td><? 
      if($spez==1){?>
            <td width="2">&nbsp;</td>
            <td>
              <select class="lmo-formular-input" name="xmspez<?=$i; ?>" onChange="dolmoedit()" tabindex="<?=$i;?>9" >
                <option<?if($mspez[$st-1][$i]=="&nbsp;"){echo " selected";}?>>_</option>
                <option<?if($mspez[$st-1][$i]==$text[0]){echo " selected";}?>><?=$text[0]?></option>
                <option<?if($mspez[$st-1][$i]==$text[1]){echo " selected";}?>><?=$text[1]?></option>
              </select>
            </td><? 
      }?>
            <td width="2">&nbsp;</td>
            <td align="center">
              <select id="gT<?=$i?>" class="lmo-formular-input" name="xmsieg<?=$i; ?>" onChange="dolmoedit()" tabindex="<?=$i;?>10" >
                <option value="0"<?if($msieg[$st-1][$i]==0){echo " selected";}?>>_</option>
                <option value="1"<?if($msieg[$st-1][$i]==1){echo " selected";}?>><?=$text[214]?></option>
                <option value="2"<?if($msieg[$st-1][$i]==2){echo " selected";}?>><?=$text[215]?></option>
                <option value="3"<?if($msieg[$st-1][$i]==3){echo " selected";}?>><?=$text[216]?></option>
              </select><?
      if($msieg[$st-1][$i]==0) {?>
              <script type="text/javascript">document.getElementById('gT<?=$i?>').style.display='none';document.write('<a href="#" onClick="this.style.display=\'none\';document.getElementById(\'gT<?=$i?>\').style.display=\'inline\';return false;">+</a>');</script><?
      }?>
            </td>
            <td align="center">
              <input id="n<?=$i?>" class="lmo-formular-input" type="text" name="xmnote<?=$i; ?>" tabindex="<?=$i;?>11" size="16" maxlength="255" value="<?=htmlentities($mnote[$st-1][$i]); ?>" onChange="dolmoedit()"><?
      if (trim($mnote[$st-1][$i]) == '') {?>
              <script type="text/javascript">document.getElementById('n<?=$i?>').style.display='none';document.write('<a href="#" onClick="this.style.display=\'none\';document.getElementById(\'n<?=$i?>\').style.display=\'inline\';return false;">+</a>');</script><?
      }?>
            </td>
            <td align="center"><input id="s<?=$i?>" class="lmo-formular-input" type="text" name="xmberi<?=$i; ?>" size="16" maxlength="255" value="<?=htmlentities($mberi[$st-1][$i]); ?>" onChange="dolmoedit()"><?
      if (trim($mberi[$st-1][$i]) == '') {?>
              <script type="text/javascript">document.getElementById('s<?=$i?>').style.display='none';document.write('<a href="#" onClick="this.style.display=\'none\';document.getElementById(\'s<?=$i?>\').style.display=\'inline\';return false;">+</a>');</script><?
      }?>
            </td><? 
      /*Tippspiel-Addon*/
      if($_SESSION['lmouserok']==2 && $ftest0==1){ ?>
            <td>
              <select class="lmo-formular-input" name="xmtipp<?=$i; ?>" onChange="dolmoedit()" tabindex="<?=$i;?>12" >
                <option value="0"<?if($mtipp[$st-1][$i]<1){echo " selected";}?>>_</option>
                <option value="1"<?if($mtipp[$st-1][$i]==1){echo " selected";}?>><?=$text['tipp'][199]?></option>
              </select>
            </td><? 
      }?>
          </tr><?
    } else { 
      /*Pokalmodus*/
      for($n=0;$n<$modus[$st-1];$n++){
        if(($klfin==1) && ($st==$anzst)){ ?>
          <tr>
            <td class="nobr" colspan=<?=$breite; ?>><? if($i==1){echo "&nbsp;<br>";} echo $text[419+$i]; ?></td>
          </tr><? 
        }?>
          <tr><?
        if ($mterm[$st-1][$i][$n] > 0) {
          $dum1 = strftime("%d.%m.%Y", $mterm[$st-1][$i][$n]);
          $dum2 = strftime("%H:%M", $mterm[$st-1][$i][$n]);
          $dum3 = $me[intval(strftime("%m", $mterm[$st-1][$i][$n]))]." ".strftime("%Y", $mterm[$st-1][$i][$n]);
        } else {
          $dum1 = "";
          $dum2 = "";
          $dum3 = "";
        }?>
            <td class="nobr"><input title="<?=$text[122] ?>" class="lmo-formular-input" type="text" name="xatdat<?=$i.$n; ?>" size="10" maxlength="10" value="<?=$dum1; ?>" onChange="dolmoedit()"><script type="text/javascript">document.write('<a href="#" onclick="opencal(\'xatdat<?=$i.$n; ?>\',\'<?=$dum3; ?>\')" title="<?=$text[139]; ?>" onMouseOver="lmoimg(\'<?=$i.$n; ?>c\',img5)" onMouseOut="lmoimg(\'<?=$i.$n; ?>c\',img4)"><img src="<?=URL_TO_IMGDIR?>/lmo-admin4.gif" name="ximg<?=$i.$n; ?>c" width="12" height="11" border="0"><\/a>');</script></td>
            <td><input title="<?=$text[123] ?>" class="lmo-formular-input" type="text" name="xattim<?=$i.$n; ?>" tabindex="<?=$i.$n;?>3" size="5" maxlength="5" value="<?=$dum2; ?>" onChange="dolmoedit()"></td>
            <td width="2">&nbsp;</td><? 

          if($n==0){ ?>
            <td class="nobr" align="right"><? 
          if($_SESSION['lmouserok']==2 || $_SESSION['lmouserokerweitert']==1){?>
              <select class="lmo-formular-input" name="xteama<?=$i; ?>" onChange="dolmoedit()" title="<?=$text[107] ?>" tabindex="<?=$i.$n;?>4"><?
            
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
              </select><? 
          } else { 
            echo $teams[$teama[$st-1][$i]];
          }?>
            </td>
            <td align="center" width="10">-</td>
            <td class="nobr"><? 
          if($_SESSION['lmouserok']==2 || $_SESSION['lmouserokerweitert']==1){?>
              <select class="lmo-formular-input" name="xteamb<?=$i; ?>" onChange="dolmoedit()" title="<?=$text[108] ?>" tabindex="<?=$i.$n;?>5"><?
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
              </select><? 
          } else {
            echo $teams[$teamb[$st-1][$i]];
          }?>
            </td><? 
        } else {?>
            <td colspan="3">&nbsp;</td><?
        }
        if ($goala[$st-1][$i][$n] == "-1") {
          $goala[$st-1][$i][$n] = "_";
        }
        if ($goalb[$st-1][$i][$n] == "-1") {
          $goalb[$st-1][$i][$n] = "_";
        }?>
            <td width="2">&nbsp;</td>
            <td class="lmoBackMarkierung" align="right"><input title="<?=$text[109] ?>" class="lmo-formular-input" type="text" name="xgoala<?=$i.$n; ?>" tabindex="<?=$i.$n;?>6" size="4" maxlength="4" value="<?=$goala[$st-1][$i][$n]; ?>" onChange="lmotorgte('a','<?=$i.$n; ?>')" onKeyDown="lmotorclk('a','<?=$i.$n; ?>',event.keyCode)"></td>
            <td class="lmoBackMarkierung" align="center">
              <table cellpadding="0" cellspacing="0" border="0">
                <tr>
                  <td><script type="text/javascript">document.write('<a href="#" onclick="lmotorauf(\'a\',\'<?=$i.$n; ?>\',1);return false;" title="<?=$text[120]; ?>" onMouseOver="lmoimg(\'<?=$i.$n; ?>a\',img1)" onMouseOut="lmoimg(\'<?=$i.$n; ?>a\',img0)"><img src="<?=URL_TO_IMGDIR?>/lmo-admin0.gif" name="ximg<?=$i.$n; ?>a" width="7" height="7" border="0"><\/a>')</script></td>
                </tr>
                <tr>
                  <td><script type="text/javascript">document.write('<a href="#" onclick="lmotorauf(\'a\',\'<?=$i.$n; ?>\',-1);return false;" title="<?=$text[120]; ?>" onMouseOver="lmoimg(\'<?=$i.$n; ?>b\',img3)" onMouseOut="lmoimg(\'<?=$i.$n; ?>b\',img2)"><img src="<?=URL_TO_IMGDIR?>/lmo-admin2.gif" name="ximg<?=$i.$n; ?>b" width="7" height="7" border="0"><\/a>')</script></td>
                </tr>
              </table>
            </td>
            <td class="lmoBackMarkierung" align="center" width="8">:</td>
            <td class="lmoBackMarkierung" align="right"><input title="<?=$text[110] ?>" class="lmo-formular-input" type="text" name="xgoalb<?=$i.$n; ?>" tabindex="<?=$i.$n;?>7" size="4" maxlength="4" value="<?=$goalb[$st-1][$i][$n]; ?>" onChange="lmotorgte('b','<?=$i.$n; ?>')" onKeyDown="lmotorclk('b','<?=$i.$n; ?>',event.keyCode)"></td>
            <td class="lmoBackMarkierung" align="center">
              <table cellpadding="0" cellspacing="0" border="0">
                <tr>
                  <td><script type="text/javascript">document.write('<a href="#" onclick="lmotorauf(\'b\',\'<?=$i.$n; ?>\',1);return false;" title="<?=$text[121]; ?>" onMouseOver="lmoimg(\'<?=$i.$n; ?>f\',img1)" onMouseOut="lmoimg(\'<?=$i.$n; ?>f\',img0)"><img src="<?=URL_TO_IMGDIR?>/lmo-admin0.gif" name="ximg<?=$i.$n; ?>f" width="7" height="7" border="0"><\/a>')</script></td>
                </tr>
                <tr>
                  <td><script type="text/javascript">document.write('<a href="#" onclick="lmotorauf(\'b\',\'<?=$i.$n; ?>\',-1);return false;" title="<?=$text[121]; ?>" onMouseOver="lmoimg(\'<?=$i.$n; ?>d\',img3)" onMouseOut="lmoimg(\'<?=$i.$n; ?>d\',img2)"><img src="<?=URL_TO_IMGDIR?>/lmo-admin2.gif" name="ximg<?=$i.$n; ?>d" width="7" height="7" border="0"><\/a>')</script></td>
                </tr>
              </table>
            </td>
            <td class="lmoBackMarkierung" width="2">&nbsp;</td>
            <td class="lmoBackMarkierung">
              <select class="lmo-formular-input" name="xmspez<?=$i.$n; ?>" onChange="dolmoedit()" title="<?=$text[111] ?>" tabindex="<?=$i.$n;?>8">
                <option<?if($mspez[$st-1][$i][$n]=="&nbsp;"){echo " selected";}?>>_</option>
                <option<?if($mspez[$st-1][$i][$n]==$text[0]){echo " selected";}?>><?=$text[0]?></option>
                <option<?if($mspez[$st-1][$i][$n]==$text[1]){echo " selected";}?>><?=$text[1]?></option>
              </select>
            </td>
            <td width="2">&nbsp;</td>
            <td><input class="lmo-formular-input" type="text" name="xmnote<?=$i.$n; ?>" tabindex="<?=$i.$n;?>9" size="16" value="<?=htmlentities($mnote[$st-1][$i][$n]); ?>" onChange="dolmoedit()"></td>
            <td><input class="lmo-formular-input" type="text" name="xmberi<?=$i.$n; ?>" tabindex="<?=$i.$n;?>10" size="16" value="<?=htmlentities($mberi[$st-1][$i][$n]); ?>" onChange="dolmoedit()"></td><? 
        /**Tippspiuel-Addon*/
        if($_SESSION['lmouserok']==2 && $ftest0==1){ ?>
            <td>
              <select class="lmo-formular-input" name="xmtipp<?=$i.$n; ?>" onChange="dolmoedit()" title="<?=$text['tipp'][57] ?>" tabindex="<?=$i.$n;?>11">
                <option value="0"<?if($mtipp[$st-1][$i][$n]<1){echo " selected";}?>>_</option>
                <option value="1"<?if($mtipp[$st-1][$i][$n]==1){echo " selected";}?>><?=$text['tipp'][199]?></option>
              </select>
            </td><? 
        }?>
          </tr><? 
      }
      if(($modus[$st-1]>1) && ($i<$anzsp-1)){ ?>
          <tr>
            <td colspan="<?=$breite; ?>">&nbsp;</td>
          </tr><? 
      }
    }
  }?>
          <tr>
            <th class="nobr" colspan="<?=$breite; ?>" align="center"><?=$text[206]; ?></th>
          </tr>
          <tr>
            <td class="nobr" colspan="<?=$breite; ?>" align="center">
              <acronym title="<?=$text[192] ?>"><?=$text[191]; ?></acronym>
              <select class="lmo-formular-input" name="xstx" onChange="dolmoedit()" tabindex="<?=$i.$n;?>12"><?
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
            </td>
          </tr>
          <tr>
            <td colspan="<?=$breite; ?>" align="center">
              <acronym title="<?=$text[208] ?>"><?=$text[207]; ?></acronym> 
              <select class="lmo-formular-input" name="xnticker" onChange="dolmoedit()">
                <option value="1"<?if($nticker==1){echo " selected";}?>><?=$text[181]?></option>
                <option value="0"<?if($nticker==0){echo " selected";}?>><?=$text[182]?></option>
              </select>
            </td>
          </tr>
          <tr>
            <td colspan="<?=$breite; ?>" align="center">
              <acronym title="<?=$text[210] ?>">Tickertext: </acronym><textarea class="lmo-formular-input" name="xnlines" cols="50" rows="4" onChange="dolmoedit()"><? if(count($nlines)>0){foreach($nlines as $y){echo $y."\n";}} ?></textarea>
            </td>
          </tr>
          <tr>
            <th colspan="<?=$breite; ?>" align="center">
              <input title="<?=$text[114] ?>" class="lmo-formular-button" type="submit" name="best" value="<?=$text[103]; ?>">
            </th>
          </tr>
        </table>
      </form>
    </td>
  </tr>
</table><? 
}?>