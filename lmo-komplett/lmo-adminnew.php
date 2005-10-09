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
$xfile=isset($_POST['xfile'])?$_POST['xfile']:"";
$xtitel=isset($_POST['xtitel'])?$_POST['xtitel']:"";
$xtype=isset($_POST['xtype'])?$_POST['xtype']:"";
$xprogram=isset($_POST['xprogram'])?$_POST['xprogram']:0;
$newpage=isset($_POST['newpage'])?$_POST['newpage']:0;
$xanzst=isset($_POST['xanzst'])?$_POST['xanzst']:0;
$xanzsp=isset($_POST['xanzsp'])?$_POST['xanzsp']:0;
$xteams=isset($_POST['xteams'])?$_POST['xteams']:0;

if ($newpage == 0) {
  if ($xfile == "") {
    $xfile = "noname";
  }
  if ($xtitel == "") {
    $xtitel = "No Name";
  }
  if ($xtype == "") {
    $xtype = "0";
  }
}
if ($newpage == 1) {
  if (file_exists($dirliga.$xfile.".l98")) {
    echo getMessage($text[280],TRUE);
    $newpage = 0;
  }
}
if ($newpage == 2) {
  if ($xtype == 0) {
    if ($xprogram == "") {
      $xprogram = "none";
    }
  } else {
    $xanzst = strlen(decbin($xteams-1));
    $xmodus = array_pad($array, 7, "1");
  }
}
if ($newpage == 3) {
  if ($xtype == 0) {
    if ($xprogram != "none") {
      $yteama = array_pad($array, $xanzst, "");
      $yteamb = array_pad($array, $xanzst, "");
      for($i = 0; $i < $xanzst; $i++) {
        $yteama[$i] = array_pad($array, $xanzsp, "");
        $yteamb[$i] = array_pad($array, $xanzsp, "");
      }
      if ($xprogram == "random") {
        require(PATH_TO_LMO."/lmo-adminrndprogram.php");
      } else {
        require(PATH_TO_LMO."/lmo-adminopenprogram.php");
      }
    }
  }
  $titel = $xtitel;
  $lmtype = $xtype;
  $anzteams = $xteams;
  if ($xtype == 0) {
    $anzst = $xanzst;
    $anzsp = $xanzsp;
  } else {
    $modus = array_pad($array, 7, "1");
    $anzst = strlen(decbin($anzteams-1));
    $anzsp = $anzteams;
  }
  $st = "1";
  $spez = $lmtype;
  if ($xtype == 0) {
    $pns = "3";
    $pnu = "1";
    $pnn = "0";
    $hidr = "0";
    $kegel = "0";
    $tabelle = "1";
    $ligastats= "1";
    $kurve = "1";
    $kreuz = "1";
    $onrun = "0";
    $kegel = "0";
    $minus = "1";
    $direkt = "0";
    $champ = "1";
    $anzcl = "1";
    $anzck = "1";
    $anzuc = "3";
    $anzar = "0";
    $anzab = "3";
    $einhinrueck = "1";
    $einheimausw = "1";
  } else {
    $klfin = "0";
    $playdown = "0";
  }
  $hands = "0";
  $ergebnis = "1";
  $plan ="1";
  $datc = "1";
  $dats = "1";
  $datm = "1";
  $datf = $defdateformat;
  $enablegamesort = '1';
  $urlt = "1";
  $urlb = "1";
  $favteam = "0";
  $selteam = "0";
  $mittore = "1";
  $goalfaktor = "1";
  $pointsfaktor = "1";
  if ($xtype == 0) {
    $stat1 = "0";
    $stat2 = "0";
  }
  $nticker = "0";
  for($i = 1; $i <= $anzteams; $i++) {
    $teams[$i] = $text[281]." ".$i;
    $teamk[$i] = $text[282].$i;
    $teamm[$i] = '';
    if ($lmtype == 0) {
      $strafp[$i] = "0";
      $strafdat[$i] = "0";
      $torkorrektur1[$i] = "0";
      $torkorrektur2[$i] = "0";
    }
    $teamu[$i] = "";
    $teamn[$i] = "";
  }
  for($i = 1; $i <= $anzst; $i++) {
    $datum1[$i-1] = "";
    $datum2[$i-1] = "";
    if ($lmtype == 0) {
      for($j = 1; $j <= $anzsp; $j++) {
        if ($xprogram == "none") {
          $teama[$i-1][$j-1] = "0";
          $teamb[$i-1][$j-1] = "0";
        } else {
          $teama[$i-1][$j-1] = $yteama[$i-1][$j-1];
          $teamb[$i-1][$j-1] = $yteamb[$i-1][$j-1];
        }
        $goala[$i-1][$j-1] = "-1";
        $goalb[$i-1][$j-1] = "-1";
        $mnote[$i-1][$j-1] = "";
        $mberi[$i-1][$j-1] = "";
        $mterm[$i-1][$j-1] = "";
        $mtipp[$i-1][$j-1] = "";
        $msieg[$i-1][$j-1] = "";
      }
    } else {
      $modus[$i-1] = isset($_POST["xmod".$i])?$_POST["xmod".$i]:"1";
      $anzsp = $anzsp/2;
      for($j = 1; $j <= $anzsp; $j++) {
        $teama[$i-1][$j-1] = "0";
        $teamb[$i-1][$j-1] = "0";
        for($n = 1; $n <= $modus[$i-1]; $n++) {
          $goala[$i-1][$j-1][$n-1] = "-1";
          $goalb[$i-1][$j-1][$n-1] = "-1";
          $mnote[$i-1][$j-1][$n-1] = "";
          $mspez[$i-1][$j-1][$n-1] = "_";
          $mberi[$i-1][$j-1][$n-1] = "";
          $mterm[$i-1][$j-1][$n-1] = "";
          $mtipp[$i-1][$j-1][$n-1] = "";
          $msieg[$i-1][$j-1][$n-1] = "";
        }
      }
    }
  }
  $file = $xfile.".l98";
  require(PATH_TO_LMO."/lmo-savefile.php");
}?>
<table class="lmoMiddle" cellspacing="0" cellpadding="0" border="0">
  <tr>
    <td align="center"><h1><?= $text[243]; ?></h1></td>
  </tr>
  <tr>
    <td align="center"><?
if($newpage<3){ ?>
      <form name="lmoedit" action="<?= $_SERVER['PHP_SELF']; ?>" method="post">
        <input type="hidden" name="action" value="admin">
        <input type="hidden" name="todo" value="new">
        <input type="hidden" name="newpage" value="<?=($newpage+1); ?>"><?
  if($newpage>0){ ?>
        <input type="hidden" name="xfile" value="<?= $xfile; ?>">
        <input type="hidden" name="xtitel" value="<?= $xtitel; ?>">
        <input type="hidden" name="xtype" value="<?= $xtype; ?>"><?
  }
  if($newpage>1){ ?>
        <input type="hidden" name="xteams" value="<?= $xteams; ?>">
        <input type="hidden" name="xanzst" value="<?= $xanzst; ?>">
        <input type="hidden" name="xanzsp" value="<?= $xanzsp; ?>"><?
  }
}?>
        <table class="lmoInner" cellspacing="0" cellpadding="0" border="0">
          <tr>
            <th class="nobr" align="left" colspan="3"><?= $text[246]." ".($newpage+1)." ".$text[259]." 4"; ?></th>
          </tr><?
if($newpage==0){ ?>
          <tr>
            <td width="20">&nbsp;</td>
            <td class="nobr" align="right"><acronym title="<?= $text[245]; ?>"><?= $text[244]; ?></acronym></td>
            <td class="nobr" align="left"><acronym title="<?= $text[245]; ?>"><?= $dirliga; ?><input class="lmo-formular-input" type="text" name="xfile" size="28" maxlength="28" value="<?= $xfile; ?>" onChange="lmofilename()">.l98</acronym></td>
          </tr>
          <tr>
            <td width="20">&nbsp;</td>
            <td class="nobr" align="right"><acronym title="<?= $text[118] ?>"><?= $text[113]; ?></acronym></td>
            <td class="nobr" align="left"><acronym title="<?= $text[118] ?>"><input class="lmo-formular-input" type="text" name="xtitel" size="40" maxlength="60" value="<?= $xtitel; ?>" onChange="lmotitelname()"></acronym></td>
          </tr>
          <tr>
            <td width="20">&nbsp;</td>
            <td class="nobr" align="right"><acronym title="<?= $text[175] ?>"><?= $text[174]; ?></acronym></td>
            <td class="nobr" align="left"><acronym title="<?= $text[175] ?>"><select class="lmo-formular-input" name="xtype" onChange="dolmoedit()"><?= "<option value=\"0\""; if($xtype==0){echo " selected";} echo ">".$text[176]."</option>"; echo "<option value=\"1\""; if($xtype==1){echo " selected";} echo ">".$text[177]."</option>"; ?></select></acronym></td>
          </tr><?
}
if($newpage==1){
  if($xtype==0){?>
          <tr>
            <td width="20">&nbsp;</td>
            <td class="nobr" align="right"><acronym title="<?= $text[272] ?>"><?= $text[271]; ?></acronym></td>
            <td class="nobr" align="left">
              <table cellpadding="0" cellspacing="0" border="0">
                <tr>
                  <td class="nobr" align="right">
                    <input class="lmo-formular-input" type="text" name="xteams" size="2" maxlength="2" value="18" onChange="lmoteamauf('xteams',0)" onKeyDown="lmoteamclk('xteams',event.keyCode)">
                  </td>
                  <td class="nobr" align="center">
                    <table cellpadding="0" cellspacing="0" border="0">
                      <tr>
                        <td>
                          <script type="text/javascript">document.write('<a href="#" onclick="lmoteamauf(\'xteams\',1);" title="<?= $text[273]; ?>" onMouseOver="lmoimg(\'ta\',img1)" onMouseOut="lmoimg(\'ta\',img0)"><img src="<?=URL_TO_IMGDIR?>/lmo-admin0.gif" name="ximgta" width="7" height="7" border="0"><\/a>')</script>
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <script type="text/javascript">document.write('<a href="#" onclick="lmoteamauf(\'xteams\',-1);" title="<?= $text[273]; ?>" onMouseOver="lmoimg(\'tb\',img3)" onMouseOut="lmoimg(\'tb\',img2)"><img src="<?=URL_TO_IMGDIR?>/lmo-admin2.gif" name="ximgtb" width="7" height="7" border="0"><\/a>')</script>
                        </td>
                      </tr>
                    </table>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
          <tr>
            <td width="20">&nbsp;</td>
            <td class="nobr" align="right"><acronym title="<?= $text[275] ?>"><?= $text[274]; ?></acronym></td>
            <td class="nobr" align="left">
              <table cellpadding="0" cellspacing="0" border="0">
                <tr>
                  <td class="nobr" align="right">
                    <input class="lmo-formular-input" type="text" name="xanzst" size="3" maxlength="3" value="34" onChange="lmoanzstauf('xanzst',0)" onKeyDown="lmoanzstclk('xanzst',event.keyCode)">
                  </td>
                  <td class="nobr" align="center">
                    <table cellpadding="0" cellspacing="0" border="0">
                      <tr>
                        <td>
                          <script type="text/javascript">document.write('<a href="#" onclick="lmoanzstauf(\'xanzst\',1);" title="<?= $text[276]; ?>" onMouseOver="lmoimg(\'sa\',img1)" onMouseOut="lmoimg(\'sa\',img0)"><img src="<?=URL_TO_IMGDIR?>/lmo-admin0.gif" name="ximgsa" width="7" height="7" border="0"><\/a>')</script>
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <script type="text/javascript">document.write('<a href="#" onclick="lmoanzstauf(\'xanzst\',-1);" title="<?= $text[276]; ?>" onMouseOver="lmoimg(\'sb\',img3)" onMouseOut="lmoimg(\'sb\',img2)"><img src="<?=URL_TO_IMGDIR?>/lmo-admin2.gif" name="ximgsb" width="7" height="7" border="0"><\/a>')</script>
                        </td>
                      </tr>
                    </table>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
          <tr>
            <td width="20">&nbsp;</td>
            <td class="nobr" align="right"><acronym title="<?= $text[278] ?>"><?= $text[277]; ?></acronym></td>
            <td class="nobr" align="left">
              <table cellpadding="0" cellspacing="0" border="0">
                <tr>
                  <td class="nobr" align="right">
                    <input class="lmo-formular-input" type="text" name="xanzsp" size="2" maxlength="2" value="9" onChange="lmoanzspauf('xanzsp',0)" onKeyDown="lmoanzspclk('xanzsp',event.keyCode)">
                  </td>
                  <td class="nobr" align="center">
                    <table cellpadding="0" cellspacing="0" border="0">
                      <tr>
                        <td>
                          <script type="text/javascript">document.write('<a href="#" onclick="lmoanzspauf(\'xanzsp\',1);" title="<?= $text[279]; ?>" onMouseOver="lmoimg(\'pa\',img1)" onMouseOut="lmoimg(\'pa\',img0)"><img src="<?=URL_TO_IMGDIR?>/lmo-admin0.gif" name="ximgpa" width="7" height="7" border="0"><\/a>')</script>
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <script type="text/javascript">document.write('<a href="#" onclick="lmoanzspauf(\'xanzsp\',-1);" title="<?= $text[279]; ?>" onMouseOver="lmoimg(\'pb\',img3)" onMouseOut="lmoimg(\'pb\',img2)"><img src="<?=URL_TO_IMGDIR?>/lmo-admin2.gif" name="ximgpb" width="7" height="7" border="0"><\/a>')</script>
                        </td>
                      </tr>
                    </table>
                  </td>
                </tr>
              </table>
            </td>
          </tr><?
  }else{ ?>
          <tr>
            <td width="20">&nbsp;</td>
            <td class="nobr" align="right"><acronym title="<?= $text[272] ?>"><?= $text[271]; ?></acronym></td>
            <td class="nobr" align="left">
              <select class="lmo-formular-input" name="xteams" onChange="dolmoedit()"><? if($xteams==""){$xteams=16;}for($i=2;$i<129;$i=$i*2){echo "<option value=\"".$i."\""; if($xteams==$i){echo " selected";} echo ">".$i."</option>";} ?></select>
            </td>
          </tr>
          <tr>
            <td width="20">&nbsp;</td>
            <td class="nobr">&nbsp;</td>
            <td class="nobr"><?= $text[350] ?></td>
          </tr><?
  }
}
if($newpage==2){
  if($xtype==0){?>
          <tr>
            <td width="20">&nbsp;</td>
            <td class="nobr" align="right" valign="top"><acronym title="<?= $text[285] ?>"><?= $text[284]; ?></acronym></td>
            <td class="nobr" align="left">
              <input type="radio" name="xprogram" value="none"<? if($xprogram=="none"){echo " checked";} ?> onChange="dolmoedit()"><?= $text[286]; ?><br><br>
              <?= $text[287]; ?>:<br><?
    $ftype=".l98";
    require(PATH_TO_LMO."/lmo-adminnewdir.php"); ?><br><?
    
    // Änderungen s.janke@tu-bs.de - Beginn
    if ($xteams>=4) {
      $soll_anzsp = floor($xteams/2);
      $soll_anzst = floor($xteams*($xteams-1)/$soll_anzsp);
      // Prüfe: 1. Stimmt die Anzahl der Spiele pro Spieltag?
      //             2. Ist die Spieltaganzahl gleich Hin- und Rückrunde oder nur Hinrunde?
      if(($xanzsp==$soll_anzsp) && (($xanzst==$soll_anzst) || ($xanzst==$soll_anzst/2))){ ?>
              <input type="radio" name="xprogram" value="random"<? if($xprogram=="random"){echo " checked";} ?> onChange="dolmoedit()"><?= $text[288];
      }
    }
    // Änderungen s.janke@tu-bs.de - Ende
    
    ?>
            </td>
          </tr><?
  } else {
    for($i=1;$i<=$xanzst;$i++){?>
          <tr>
            <td width="20">&nbsp;</td>
            <td class="nobr" align="right"><acronym title="<?= $text[352] ?>"><?= $text[351]." ".$i; ?></acronym></td>
            <td class="nobr" align="left">
              <select class="lmo-formular-input" name="xmod<?= $i; ?>" onChange="dolmoedit()">
                <option value="1"<?if($xmodus[$i-1]==1){echo " selected";}?>><?=$text[353]?></option>
                <option value="2"<?if($xmodus[$i-1]==2){echo " selected";}?>><?=$text[354]?></option>
                <option value="3"<?if($xmodus[$i-1]==3){echo " selected";}?>><?=$text[355]?></option>
                <option value="5"<?if($xmodus[$i-1]==5){echo " selected";}?>><?=$text[356]?></option>
                <option value="7"<?if($xmodus[$i-1]==7){echo " selected";}?>><?=$text[357]?></option>
              </select>
            </td>
          </tr><?
    }
  }
}
if($newpage<3){ ?>
          <tr>
            <td class="lmoFooter" align="left" colspan="2">
              <a href="<?= $_SERVER['PHP_SELF']; ?>" onclick="return siklmolink(this.href);" title="<?= $text[248]; ?>"><?= $text[247]; ?></a>
            </td><?
  if($newpage<2){ ?>
            <td align="right">
              <input title="<?= $text[261]; ?>" class="lmo-formular-button" type="submit" name="best" value="<?= $text[260]; ?>">
            </td><?
  } else {?>
            <td align="right">
              <input title="<?= $text[290]; ?>" class="lmo-formular-button" type="submit" name="best" value="<?= $text[289]; ?>">
            </td><?
  }?>
          </tr><?
}
if($newpage==3){ ?>
          <tr>
            <td width="20">&nbsp;</td>
            <td class="nobr" align="left" colspan="2">&nbsp;<br><?= $text[291]; ?><br>&nbsp;</td>
          </tr>
          <tr>
            <td class="lmoFooter" colspan="3" align="left">
              <a href="<?= $_SERVER['PHP_SELF']."?action=admin&amp;todo=edit&amp;st=-2&amp;file=".$file; ?>" title="<?= $text[293]; ?>"><?= $text[292]; ?></a>
            </td>
          </tr><?
} ?>
        </table>
      </form>
    </td>
  </tr>
</table>