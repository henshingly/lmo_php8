<? 
// 
// LigaManager Online 3.02b
// Copyright (C) 1997-2002 by Frank Hollwitz
// webmaster@hollwitz.de / http://php.hollwitz.de
// 
// This program is free software; you can redistribute it and/or
// modify it under the terms of the GNU General Public License as
// published by the Free Software Foundation; either version 2 of
// the License, or (at your option) any later version.
// 
// This program is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
// General Public License for more details.
// 
// You should have received a copy of the GNU General Public License
// along with this program; if not, write to the Free Software
// Foundation, Inc., 675 Mass Ave, Cambridge, MA 02139, USA.
// 
if (isset($file) && $file != "") {
  $tabtype=isset($_GET['tabtype'])?$_GET['tabtype']:0;
  $newtabtype=0;
  $endtab = $st;
  $addp = $_SERVER['PHP_SELF']."?action=program&amp;file=".$file."&amp;selteam=";
  $addr = $_SERVER['PHP_SELF']."?action=$action&amp;file=".$file."&amp;st=";
  $breite = 10;
  if ($spez == 1) {
    $breite = $breite+2;
  }
  if ($datm == 1) {
    $breite = $breite+1;
  }
  if ($endtab > 1) {
    $endtab--;
    require(PATH_TO_LMO."/lmo-calctable.php");
    $platz1 = array("");
    $platz1 = array_pad($array, $anzteams+1, "");
    for($x = 0; $x < $anzteams; $x++) {
      $platz1[intval(substr($tab0[$x], 34))] = $x+1;
    }
    $endtab++;
  }
  if ($tabonres == 2) {
    $newtabtype = $tabtype;
    $tabtype = 1;
    require(PATH_TO_LMO."/lmo-calctable.php");
    $hplatz = array("");
    $hplatz = array_pad($array, $anzteams+1, "");
    for($x = 0; $x < $anzteams; $x++) {
      $hplatz[intval(substr($tab0[$x], 34))] = $x+1;
    }
    $hspiele = $spiele;
    $hsiege = $siege;
    $hunent = $unent;
    $hnieder = $nieder;
    $hpunkte = $punkte;
    $hnegativ = $negativ;
    $hetore = $etore;
    $hatore = $atore;
    $hdtore = $dtore;
    $tabtype = 2;
    require(PATH_TO_LMO."/lmo-calctable.php");
    $aplatz = array("");
    $aplatz = array_pad($array, $anzteams+1, "");
    for($x = 0; $x < $anzteams; $x++) {
      $aplatz[intval(substr($tab0[$x], 34))] = $x+1;
    }
    $aspiele = $spiele;
    $asiege = $siege;
    $aunent = $unent;
    $anieder = $nieder;
    $apunkte = $punkte;
    $anegativ = $negativ;
    $aetore = $etore;
    $aatore = $atore;
    $adtore = $dtore;
    $tabtype=$newtabtype;
  }
  require(PATH_TO_LMO."/lmo-calctable.php");
  $platz0 = array("");
  $platz0 = array_pad($array, $anzteams+1, "");
  for($x = 0; $x < $anzteams; $x++) {
    $platz0[intval(substr($tab0[$x], 34))] = $x+1;
  }
  if ($tabdat == "") {
    $addt1 = $_SERVER['PHP_SELF']."?action=$action&amp;file=".$file."&amp;tabtype=";
  } else {
    $addt1 = $_SERVER['PHP_SELF']."?action=$action&amp;file=".$file."&amp;endtab=".$endtab."&amp;tabtype=";
  }
  $addt2 = $_SERVER['PHP_SELF']."?action=$action&amp;file=".$file."&amp;tabtype=".$tabtype."&amp;endtab=";

?>

<table class="lmoMiddle" cellspacing="0" cellpadding="0" border="0"><?

  /** Spieltagsauswahl*/?>
  <tr>
    <td align="center"><? include(PATH_TO_LMO."/lmo-spieltagsmenu.php")?></td>
  </tr><?
  
  /** Ergebnisse*/
  if ($tabonres >= 1 || $action=="results") {?>
  <tr>
    <td align="center"><? include(PATH_TO_LMO."/lmo-showresults.php")?></td>
  </tr><?
  }
  
  /** Vor und Zurück-Pfeile*/?>
  <tr>
    <td>
      <table width="100%" cellspacing="0" cellpadding="0" border="0">
        <tr><?  
   $st0 = $st-1;
   if ($st > 1) {?>
          <td align='left'>&nbsp;<a href="<?=$addr.$st0?>" title="<?=$text[6]?>"><?=$text[5]?></a>&nbsp;</td><?
   }
   $st0 = $st+1;
   if ($st < $anzst) {?>
          <td align="right">&nbsp;<a href="<?=$addr.$st0?>" title="<?=$text[8]?>"><?=$text[7]?></a>&nbsp;</td><?
   }?>
        </tr>
      </table>
    </td>
  </tr><?
  
  /** Tabelle*/
  if ($tabonres >= 1 || $action=="table") {?>
  <tr>
    <td align="center"><? include(PATH_TO_LMO."/lmo-showtable.php")?></td>
  </tr><?
  }?>

</table><?
}?>