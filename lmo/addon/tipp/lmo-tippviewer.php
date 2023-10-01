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

require_once(PATH_TO_ADDONDIR . "/tipp/lmo-tipptest.php");
if($tipp_viewertipp == 1 && $viewermode == 1) {
  require_once(PATH_TO_ADDONDIR . "/tipp/lmo-tippcalcpkt.php");
  require_once(PATH_TO_ADDONDIR . "/tipp/lmo-tippaenderbar.php");

  $verz = opendir(substr(PATH_TO_LMO . '/'.$dirliga, 0, -1));
  $dateien = array();
  while ($files = readdir($verz)) {
    if(file_exists(PATH_TO_ADDONDIR . "/tipp/".$tipp_dirtipp.substr($files, 0, -4)."_".$_SESSION['lmotippername'].".tip")) {
      $ftest = 1;
      if($tipp_immeralle != 1) {
        $ftest = 0;
        $ftest1 = "";
        $ftest1 = explode(',', $tipp_ligenzutippen);
        if(isset($ftest1)) {
          for($u = 0; $u < count($ftest1); $u++) {
            if($ftest1[$u] == substr($files, 0, -4)) {
              $ftest = 1;
            }
          }
        }
      }
      if($ftest == 1) {
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

  if(!isset($save)) {
    $save = 0;
  }
  if($save == 1) {
    $start = trim($_POST["xstart"]);
    $now1 = trim($_POST["xnow"]);
    $then1 = trim($_POST["xthen"]);
  } else {
    if(!isset($start)) {
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
    require(PATH_TO_ADDONDIR . "/tipp/lmo-tippopenfileviewer.php");
  }

  if($save == 1) {
    $now = time();
    $start1 = 0;
    $start2 = 0;
    for($i = 0; $i < $anzspiele; $i++) {
      $btip = tippaenderbar($mterm[$i], $datum1[$i], $datum2[$i]);
      if($btip == true) {
        if($tipp_jokertipp == 1 && isset($_POST["xjokerspiel_".$liga[$i]."_".$spieltag[$i]])) {
          $jksp[$i] = trim($_POST["xjokerspiel_".$liga[$i]."_".$spieltag[$i]]);
          if($tipp_jokertippaktiv[$i] > 0 && $tipp_jokertippaktiv[$i] < $now) {
            $jksp[$i] = 0;
          } // jokeranticheat
        }
        if($tipp_tippmodus == 1) {
          $tippa[$i] = trim($_POST["xtippa".$i]);
          if($tippa[$i] == "" || $tippa[$i] < 0) {
            $tippa[$i] = -1;
          } elseif($tippa[$i] == "_") {
            $tippa[$i] = -1;
          } else {
            $tippa[$i] = intval(trim($tippa[$i]));
            if($tippa[$i] == "") {
              $tippa[$i] = "0";
            }
          }
          $tippb[$i] = trim($_POST["xtippb".$i]);
          if($tippb[$i] == "" || $tippb[$i] < 0) {
            $tippb[$i] = -1;
          } elseif($tippb[$i] == "_") {
            $tippb[$i] = -1;
          } else {
            $tippb[$i] = intval(trim($tippb[$i]));
            if($tippb[$i] == "") {
              $tippb[$i] = "0";
            }
          }
        } elseif($tipp_tippmodus == 0) {
          if(!isset($_POST["xtipp".$i])) {
            $_POST["xtipp".$i] = 0;
          }
          if($_POST["xtipp".$i] == 1) {
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
      if($i == ($anzspiele-1) || $liga[$i] != $liga[$i+1]) {
        $tippfile = PATH_TO_ADDONDIR."/tipp/".$tipp_dirtipp.$liga[$i]."_".$_SESSION['lmotippername'].".tip";
        require(PATH_TO_ADDONDIR . "/tipp/lmo-tippsavefileviewer.php");
        $start1 = $i+1;
      }
      if($tipp_akteinsicht == 1 && ($i == ($anzspiele-1) || $spieltag[$i] != $spieltag[$i+1] || $liga[$i] != $liga[$i+1])) {
        $einsichtfile = PATH_TO_ADDONDIR."/tipp/".$tipp_dirtipp."einsicht/".$liga[$i]."_".$spieltag[$i].".ein";
        require(PATH_TO_ADDONDIR . "/tipp/lmo-tippsaveeinsichtviewer.php");
        $start2 = $i+1;
      }
    }
  }

  if($tipp_tippmodus == 1) {
    $tendenz1 = array_pad(array("0"), $anzspiele+1, "0");
    $tendenz0 = array_pad(array("0"), $anzspiele+1, "0");
    $tendenz2 = array_pad(array("0"), $anzspiele+1, "0");
    $toregesa = array_pad(array("0"), $anzspiele+1, "0");
    $toregesb = array_pad(array("0"), $anzspiele+1, "0");
    $anzgetippt = array_pad(array("0"), $anzspiele+1, "0");
    $btip = array_pad(array("false"), $anzspiele+1, "0");
    $start2 = 0;
    for($i = 0; $i < $anzspiele; $i++) {
      if($i == ($anzspiele-1) || $spieltag[$i] != $spieltag[$i+1] || $liga[$i] != $liga[$i+1]) {
        $einsichtfile = PATH_TO_ADDONDIR."/tipp/".$tipp_dirtipp."einsicht/".$liga[$i]."_".$spieltag[$i].".ein";
        require(PATH_TO_ADDONDIR . "/tipp/lmo-tippcalceinsichtviewer.php");
        $start2 = $i+1;
      }
    }
  }

  $addr = $_SERVER['PHP_SELF']."?action=tipp&amp;todo=edit&amp;file=&amp;viewermode=1&amp;start=";
  $breite = 17;
  if($tipp_tippmodus == 1 && $tipp_pfeiltipp == 1) {
    $breite += 2;
  }
  if($tipp_showtendenzabs == 1) {
    $breite += 2;
  }
  if($tipp_showtendenzpro == 1) {
    $breite += 2;
  }
  if($tipp_showdurchschntipp == 1) {
    $breite += 2;
  }
  if($tipp_jokertipp == 1) {
    $breite++;
  }
  $savebutton = 0;
  $viewermode = 1;
  $file='';
  $nw = 0;
?>

<table class="lmoMiddle" cellspacing="0" cellpadding="0" border="0">
  <tr>
    <td align="center"><h1><?php echo $_SESSION['lmotippername'];if($_SESSION['lmotipperverein']!=""){echo " - ".$_SESSION['lmotipperverein'];} ?></h1></td>
  </tr>
  <tr>
    <td align="center"><?php if($tipp_tippBis>0){echo $text['tipp'][87]." ".$tipp_tippBis." ".$text['tipp'][88];} ?></td>
  </tr>
  <tr>
    <td align="center"><?php echo $text['tipp'][258]." ".$now1." ".$text[4]." ".$then1; ?></td>
  </tr>
  <tr>
    <td align="center">
    <form name="lmoedit" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
      <input type="hidden" name="action" value="tipp">
      <input type="hidden" name="todo" value="edit">
      <input type="hidden" name="save" value="1">
      <input type="hidden" name="viewermode" value="1">
      <input type="hidden" name="xstart" value="<?php echo $start; ?>">
      <input type="hidden" name="xnow" value="<?php echo $now; ?>">
      <input type="hidden" name="xthen" value="<?php echo $then; ?>">
      <table class="lmoInner" cellspacing="0" cellpadding="0" border="0"><?php
  if($anzspiele==0){?>
        <tr>
          <td align="center" colspan="<?php echo $breite; ?>"><?php echo getMessage($text['tipp'][262],TRUE); ?></td>
        </tr><?php
  }
  for($i=0;$i<$anzspiele;$i++){
    if($i==0 || $liga[$i]!=$liga[$i-1]){?>
        <tr>
          <th align="left" colspan="<?php echo $breite; ?>"><?php echo $titel[$i]; ?></th>
        </tr><?php
    }
    if($i == 0 || $liga[$i] != $liga[$i-1] || $spieltag[$i] != $spieltag[$i-1]) {
      if($datum1[$i] != "") {
        $datum = explode('.', $datum1[$i]);
        $dum1 = $me[intval($datum[1])]." ".$datum[2];
      } else {
        $dum1 = "";
      }
      if($datum2[$i] != "") {
        $datum = explode('.', $datum2[$i]);
        $dum2 = $me[intval($datum[1])]." ".$datum[2];
      } else {
        $dum2 = "";
      }
      if($lmtype[$i] == 1) {
        if($spieltag[$i] == $anzst[$i]) {
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
        <tr>
          <th align="left" class="nobr" colspan="6"><?php      if($tipp_tippeinsicht == 1) {
        echo "<a href=\"".$_SERVER['PHP_SELF']."?action=tipp&amp;todo=einsicht&amp;file=".$liga[$i].".l98&amp;st=".$spieltag[$i]."\">";
      }
      if($lmtype[$i] == 0) {
        echo $spieltag[$i].". ".$text[2];
      } else {
        echo $j;
      }
      if($tipp_tippeinsicht == 1) {
        echo "</a>";
      }
      if($dats[$i] == 1) {
        if($datum1[$i] != "") {
          echo " ".$text[3]." ".$datum1[$i];
        }
        if($datum2[$i] != "") {
          echo " ".$text[4]." ".$datum2[$i];
        }
      } ?></th><?php      if($tipp_showtendenzabs==1 || $tipp_showtendenzpro==1){ ?>
          <th class="nobr" colspan="<?php if($tipp_showtendenzabs==1 && $tipp_showtendenzpro==1){echo "4";}else{echo "2";} ?>"><?php echo $text['tipp'][188]; /* Tipptendenz absolut */?></th><?php      }
      if($tipp_tippmodus==1){
        if($tipp_showdurchschntipp==1){ ?>
          <th class="nobr" colspan="2"><?php echo "Ø-".$text['tipp'][30]; /* DurchschnittsTipp */?><br><?php
          if($goalfaktor[$i]!=1) {
            echo "(".$text[553+log10($goalfaktor[$i])].")";
          }?></th><?php        }?>
          <th class="nobr" align="center" colspan="<?php if($tipp_pfeiltipp==1){echo "5";}else{echo "3";} ?>">
            <acronym title="<?php echo $text['tipp'][241].":".$text['tipp'][242] ?>"><?php echo $text['tipp'][209]; /* Dein Tipp */?></acronym><br><?php
        if($goalfaktor[$i]!=1) {
          echo "(".$text[553+log10($goalfaktor[$i])].")";
        }?></th><?php
      }
      if($tipp_tippmodus==0){ ?>
          <th class="nobr" align="center"><acronym title="<?php echo $text['tipp'][95] ?>">1</acronym></th><?php        if($hidr[$i]==0){ ?>
          <th class="nobr" align="center"><acronym title="<?php echo $text['tipp'][96] ?>">0</acronym></th><?php        }else{ ?>
          <th>&nbsp;</th><?php        }?>
          <th class="nobr" align="center"><acronym title="<?php echo $text['tipp'][97] ?>">2</acronym></th><?php      }
      if($tipp_jokertipp==1){ ?>
          <th class="nobr" align="center">
            <acronym title="<?php echo $text['tipp'][290] ?>"><?php echo $text['tipp'][289]; ?></acronym>
          </th><?php      }?>
          <th class="nobr" colspan="5" align="center"><?php echo $text['tipp'][31]; /* Ergebnis*/ ?></th>
          <th class="nobr" colspan="2" align="right"><?php echo $text[37]; /* PP */?></th>
          <th>&nbsp;</th>
        </tr><?php
    }
    if($tipp_einsichterst == 2) {
      if($goala[$i] != "_" && $goalb[$i] != "_") {
        $btip1 = false;
      } else {
        $btip1 = true;
      }
    } else {
      $btip1 = false;
    }

    $dum1 = "";
    if($datm[$i] == 1) {
      if($mterm[$i] > 0) {
        $datf = $defdateformat;
        $dum1 = strtr(date($datf, $mterm[$i]), $trans_lang);
      }
    }?>
        <tr>
          <td class="nobr" align="left"><?php echo $dum1; ?></td>
          <td>&nbsp;</td>
          <td class="nobr" align="right"><?php echo $teama[$i] . " " . HTML_smallTeamIcon($file,$teama[$i]," alt=''");?></td>
          <td class="nobr" align="center" width="10">-</td>
          <td class="nobr" align="left">
            <?php
    echo HTML_smallTeamIcon($file,$teamb[$i]," alt=''") . " " . $teamb[$i];
    if($tippa[$i] == "_") {
      $tippa[$i] = "";
    }
    if($tippb[$i] == "_") {
      $tippb[$i] = "";
    }
    if($tippa[$i] == "-1") {
      $tippa[$i] = "";
    }
    if($tippb[$i] == "-1") {
      $tippb[$i] = "";
    }?>

          </td>
          <td class="nobr">&nbsp;</td><?php    if($tipp_showtendenzabs==1){ ?>
          <td align="center" class="nobr">
            <?php      if($btip1 == false) {
        if(!isset($tendenz1[$i])) {
          $tendenz1[$i] = 0;
        }
        if(!isset($tendenz0[$i])) {
          $tendenz0[$i] = 0;
        }
        if(!isset($tendenz2[$i])) {
          $tendenz2[$i] = 0;
        }
        echo $tendenz1[$i]."-".$tendenz0[$i]."-".$tendenz2[$i];
      }?>

          </td>
          <td class="nobr">&nbsp;</td><?php    }
    if($tipp_showtendenzpro==1){ ?>
          <td align="center" class="nobr">
            <?php      if($btip1 == false) {
        if(!isset($anzgetippt[$i])) {
          $anzgetippt[$i] = 0;
        }
        if($anzgetippt[$i] > 0) {
          if(!isset($tendenz1[$i])) {
            $tendenz1[$i] = 0;
          }
          if(!isset($tendenz0[$i])) {
            $tendenz0[$i] = 0;
          }
          if(!isset($tendenz2[$i])) {
            $tendenz2[$i] = 0;
          }
          echo number_format(($tendenz1[$i]/$anzgetippt[$i] * 100), 0, ".", ",")."%-".number_format(($tendenz0[$i]/$anzgetippt[$i] * 100), 0, ".", ",")."%-".number_format(($tendenz2[$i]/$anzgetippt[$i] * 100), 0, ".", ",")."%";
        } else {
          echo "&nbsp;";
        }
      }?>

          </td>
          <td>&nbsp;</td><?php    }
    $plus = 1;
    $btip = tippaenderbar($mterm[$i], $datum1[$i], $datum2[$i]);
    if($btip == true) {
       $savebutton = 1;
    }
    if($tipp_tippmodus == 1) {
      if($tipp_showdurchschntipp == 1) {?>
          <td align="center" class="nobr">
            <?php        if($btip1 == false) {
          if(!isset($anzgetippt[$i])) {
            $anzgetippt[$i] = 0;
          }
          if($anzgetippt[$i] > 0) {
            if(!isset($toregesa[$i])) {
              $toregesa[$i] = 0;
            }
            if(!isset($toregesb[$i])) {
              $toregesb[$i] = 0;
            }
            if($toregesa[$i] < 10 && $toregesb[$i] < 10) {
              $nachkomma = 1;
            } else {
              $nachkomma = 0;
            }
            echo number_format(($toregesa[$i]/$anzgetippt[$i]), $nachkomma, ".", ",").":".number_format(($toregesb[$i]/$anzgetippt[$i]), $nachkomma, ".", ",");
          } else {
            echo "&nbsp;";
          }
        }?>

          </td>
          <td>&nbsp;</td><?php      }
      if($btip==true){ ?>
          <td class="nobr" align="right">
              <input class="lmo-formular-input" type="text" name="xtippa<?php echo $i; ?>" size="4" maxlength="4" value="<?php echo $tippa[$i]; ?>" onKeyDown="lmotorclk('a','<?php echo $i; ?>',event.keyCode)">
          </td><?php        if($tipp_pfeiltipp==1){ ?>
          <td class="nobr" align="center">
            <table cellpadding="0" cellspacing="0" border="0">
              <tr>
                <td>
                  <script type="text/javascript">document.write('<a href="#" onclick="lmotorauf(\'a\',\'<?php echo $i; ?>\',1);return false;" title="<?php echo $text['tipp'][243]; ?>" onMouseOver="lmoimg(\'<?php echo $i; ?>a\',img1)" onMouseOut="lmoimg(\'<?php echo $i; ?>a\',img0)"><img src="<?php echo URL_TO_IMGDIR?>/lmo-admin0.gif" name="ximg<?php echo $i; ?>a" width="7" height="7" border="0"><\/a>')</script>
                </td>
              </tr>
              <tr>
                <td>
                  <script type="text/javascript">document.write('<a href="#" onclick="lmotorauf(\'a\',\'<?php echo $i; ?>\',-1);return false;" title="<?php echo $text['tipp'][243]; ?>" onMouseOver="lmoimg(\'<?php echo $i; ?>b\',img3)" onMouseOut="lmoimg(\'<?php echo $i; ?>b\',img2)"><img src="<?php echo URL_TO_IMGDIR?>/lmo-admin2.gif" name="ximg<?php echo $i; ?>b" width="7" height="7" border="0"><\/a>')</script>
                </td>
              </tr>
            </table>
          </td><?php
        }
      } else {
        if($tipp_pfeiltipp==1){ ?>
          <td class="nobr">&nbsp;</td><?php        }?>
          <td class="nobr" align="right"><?php echo $tippa[$i]; ?></td><?php
      }?>
          <td class="nobr" width="2">:</td><?php      if($btip==true){?>
          <td class="nobr" align="right">
              <input class="lmo-formular-input" type="text" name="xtippb<?php echo $i; ?>" size="4" maxlength="4" value="<?php echo $tippb[$i]; ?>" onKeyDown="lmotorclk('b','<?php echo $i; ?>',event.keyCode)">
          </td><?php        if($tipp_pfeiltipp==1){ ?>
          <td class="nobr" align="center">
            <table cellpadding="0" cellspacing="0" border="0">
              <tr>
                <td>
                  <script type="text/javascript">document.write('<a href="#" onclick="lmotorauf(\'b\',\'<?php echo $i; ?>\',1);return false;" title="<?php echo $text['tipp'][244]; ?>" onMouseOver="lmoimg(\'<?php echo $i; ?>f\',img1)" onMouseOut="lmoimg(\'<?php echo $i; ?>f\',img0)"><img src="<?php echo URL_TO_IMGDIR?>/lmo-admin0.gif" name="ximg<?php echo $i; ?>f" width="7" height="7" border="0"><\/a>')</script>
                </td>
              </tr>
              <tr>
                <td>
                  <script type="text/javascript">document.write('<a href="#" onclick="lmotorauf(\'b\',\'<?php echo $i; ?>\',-1);return false;" title="<?php echo $text['tipp'][244]; ?>" onMouseOver="lmoimg(\'<?php echo $i; ?>d\',img3)" onMouseOut="lmoimg(\'<?php echo $i; ?>d\',img2)"><img src="<?php echo URL_TO_IMGDIR?>/lmo-admin2.gif" name="ximg<?php echo $i; ?>d" width="7" height="7" border="0"><\/a>')</script>
                </td>
              </tr>
            </table>
          </td><?php        }
      } else {?>
          <td class="nobr"><?php echo $tippb[$i]; ?></td><?php        if($tipp_pfeiltipp==1){ ?>
          <td class="nobr">&nbsp;</td><?php        }
      }
    } /* ende ($tipp_tippmodus==1) */
    if($tipp_tippmodus == 0) {
      $tipp = -1;
      if($tippa[$i] == "" || $tippb[$i] == "") {
        $tipp = -1;
      } elseif($tippa[$i] > $tippb[$i]) {
        $tipp = 1;
      } elseif($tippa[$i] == $tippb[$i]) {
        $tipp = 0;
      } elseif($tippa[$i] < $tippb[$i]) {
        $tipp = 2;
      }?>
          <td class="nobr" align="center">
              <input type="radio" name="xtipp<?php echo $i; ?>" value="1" <?php if($tipp==1){echo " checked";} if($btip==false){echo " disabled";} ?>>
          </td><?php      if($hidr[$i]==0){ ?>
          <td class="nobr" align="center">
              <input type="radio" name="xtipp<?php echo $i; ?>" value="3" <?php if($tipp==0){echo " checked";} if($btip==false){echo " disabled";} ?>>
          </td><?php      } else { ?>
          <td class="nobr">&nbsp;</td><?php      }?>
          <td class="nobr" align="center">
              <input type="radio" name="xtipp<?php echo $i; ?>" value="2" <?php if($tipp==2){echo " checked";} if($btip==false){echo " disabled";} ?>>
          </td><?php    } // ende ($tipp_tippmodus==0)
    if($tipp_jokertipp == 1) {
      if($tipp_jokertippaktiv[$i] > 0 && $tipp_jokertippaktiv[$i] < time()) {
        $btip = false;
      }?>
          <td class="nobr" align="center">
              <input type="radio" name="xjokerspiel_<?php echo $liga[$i]."_".$spieltag[$i]; ?>" value="<?php echo $spiel[$i]; ?>" <?php if($jksp[$i]==$spiel[$i]){echo " checked";} if($btip==false){echo " disabled";} ?>>
          </td><?php    }?>
          <td class="lmoBackMarkierung" align="right"><?php echo applyFactor($goala[$i],$goalfaktor[$i]); ?></td>
          <td class="lmoBackMarkierung">:</td>
          <td class="lmoBackMarkierung" align="left"><?php echo applyFactor($goalb[$i],$goalfaktor[$i]); ?></td>
          <td class="lmoBackMarkierung"></td>
          <td class="lmoBackMarkierung"><?php echo $mspez[$i]; ?></td>
          <td>&nbsp;</td>
          <td class="nobr" align="right"><strong><?php    if($tipp_jokertipp == 1 && $jksp[$i] == $spiel[$i]) {
      $jkspfaktor = $tipp_jokertippmulti;
    } else {
      $jkspfaktor = 1;
    }
    $punktespiel = -1;
    if($tippa[$i] != "" && $tippb[$i] != "" && $goala[$i] != "_" && $goalb[$i] != "_") {
      $punktespiel = tipppunkte($tippa[$i], $tippb[$i], $goala[$i], $goalb[$i], $msieg[$i], $mspez[$i], $text[0], $text[1], $jkspfaktor, $mtipp[$i]);
    }
    if($punktespiel == -1) {
      echo "-";
    } elseif($punktespiel == -2) {
      echo $text['tipp'][230];
      $nw = 1;
    } else {
      if($tipp_tippmodus == 1) {
        echo $punktespiel;
      } else {
        if($punktespiel > 0) {
          echo "<img src='".URL_TO_IMGDIR."/right.gif' border='0' alt=''>";
          if($punktespiel > 1) {
            echo "+".($punktespiel-1);
          }
        } else {
          echo "<img src='".URL_TO_IMGDIR."/wrong.gif' border='0' alt=''>";
        }
      }
    }    ?></strong>
          </td>
          <td class="nobr" align="left"><?php        /** Mannschaftsicons finden
         */
        $lmo_teamaicon="";
        $lmo_teambicon="";
        if($urlb[$i]==1 || $mnote[$i]!="" || $msieg[$i]>0){
          $lmo_teamaicon=HTML_smallTeamIcon($file,$teama[$i]," alt=''")." ";
          $lmo_teambicon=HTML_smallTeamIcon($file,$teamb[$i]," alt=''")." ";
        }
        /** Spielbericht verlinken
         */
        if($urlb[$i]==1){
          if($mberi[$i]!=""){
            $lmo_spielbericht=$lmo_teamaicon."<strong>".$teama[$i]."</strong> - ".$lmo_teambicon."<strong>".$teamb[$i]."</strong><br><br>";
            echo "<a href='".$mberi[$i]."'  target='_blank' title='".$text[270]."'><img src='".URL_TO_IMGDIR."/lmo-st1.gif' width='10' height='12' border='0' alt=''><span class='popup'>".$lmo_spielbericht.nl2br($text[270])."</span></a>";
          }else{
            echo "&nbsp;&nbsp;&nbsp;";
          }
        }
        /** Notizen anzeigen
         *
         */
        if($mnote[$i]!="" || $msieg[$i]>0 || $mtipp[$i] > 0) {
          $lmo_spielnotiz=$lmo_teamaicon."<strong>".$teama[$i]."</strong> - ".$lmo_teambicon."<strong>".$teamb[$i]."</strong> ".applyFactor($goala[$i],$goalfaktor[$i]).":".applyFactor($goalb[$i],$goalfaktor[$i]);
          //Beidseitiges Ergebnis
          if($msieg[$i]==3) {
            $lmo_spielnotiz.=" / ".applyFactor($goalb[$i],$goalfaktor[$i]).":".applyFactor($goala[$i],$goalfaktor[$i]);
          }

            $lmo_spielnotiz.=" ".$mspez[$i];

          //Grüner Tisch: Heimteam siegt
          if($msieg[$i]==1) {
            $lmo_spielnotiz.="\n\n<strong>".$text[219].":</strong>\n".$teama[$i]." ".$text[211];
          }
          //Grüner Tisch: Gastteam siegt
          if($msieg[$i]==2) {
            $lmo_spielnotiz.="\n\n<strong>".$text[219].":</strong>\n".addslashes($teamb[$i]." ".$text[211]);
          }
          //Beidseitiges Ergebnis
          if($msieg[$i]==3) {
            $lmo_spielnotiz.="\n\n<strong>".$text[219].":</strong>\n".addslashes($text[212]);
          }
          //Allgemeine Notiz
          if($mnote[$i]!="") {
            $lmo_spielnotiz.="\n\n<strong>".$text[22].":</strong>\n".$mnote[$i];
          }
          //Notiz zum Tippspiel
          if($mtipp[$i] == 1) {
            $lmo_spielnotiz.="\n\n".$text['tipp'][231];
          }
          echo "<a href='#' onclick=\"alert('".addcslashes('',htmlentities(strip_tags($lmo_spielnotiz)))."');window.focus();return false;\"><span class='popup'>".nl2br($lmo_spielnotiz)."</span><img src='".URL_TO_IMGDIR."/lmo-st2.gif' width='10' height='12' border='0' alt=''></a>";
          $lmo_spielnotiz="";
        } else {
          echo "&nbsp;";
        }
        ?></td>
        </tr><?php  }?>
        <tr>
          <td colspan="<?php echo $breite; ?>" align="right"><?php if($savebutton==1){ ?>
              <input title="<?php echo $text[114] ?>" class="lmo-formular-button" type="submit" name="best" value="<?php echo $text['tipp'][8]; ?>"><?php  }?>
          </td>
        </tr>
      </table>
    </form>
    </td>
  </tr>
  <tr>
    <td>
      <table width="100%" cellspacing="0" cellpadding="0" border="0">
        <tr>
          <td align="left"><a href="<?php echo $addr.($start-$tipp_viewertage)?>" title="<?php echo $tipp_viewertage." ".$text['tipp'][257]?>"><?php echo $text[5]?></a></td>
          <td align="right"><a href="<?php echo $addr.($start+$tipp_viewertage)?>" title="<?php echo $tipp_viewertage." ".$text['tipp'][256]?>"><?php echo $text[7]?></a></td>
        </tr>
      </table>
    </td>
  </tr>
</table><?php }
$einsichtfile="";
$tippfile="";
?>
