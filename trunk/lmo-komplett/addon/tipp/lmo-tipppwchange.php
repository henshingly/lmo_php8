<?
// 
// LigaManager Online 3.02
// Copyright (C) 1997-2002 by Frank Hollwitz
// webmaster@hollwitz.de / http://php.hollwitz.de
// 
// Tippspiel-AddOn 1.20
// Copyright (C) 2002 by Frank Albrecht
// fkalbrecht@web.de
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
require_once(PATH_TO_ADDONDIR."/tipp/lmo-tipptest.php");
if (($action == "tipp") && ($todo == "pwchange")) {
  if (!isset($xtipperpass)) {
    $xtipperpass = "";
  }
  if (!isset($xtipperpassneu)) {
    $xtipperpassneu = "";
  }
  if (!isset($xtipperpassneuw)) {
    $xtipperpassneuw = "";
  }
  $users = array("");
  $pswfile = PATH_TO_ADDONDIR."/tipp/".$tipp_tippauthtxt;
  $datei = fopen($pswfile, "rb");
  while (!feof($datei)) {
    $zeile = fgets($datei, 1000);
    $zeile = trim(chop($zeile));
    if ($zeile != "") {
      if ($zeile != "") {
        array_push($users, $zeile);
      }
    }
  }
  fclose($datei);
  $gef = 0;
  for($i = 1; $i < count($users) && $gef == 0; $i++) {
    $dummb = split("[|]", $users[$i]);
    if ($lmotippername == $dummb[0]) {
      // Nick gefunden
      $gef = 1;
      $save = $i;
    }
  }
  if ($gef == 0) {
    exit;
  }
   
  if ($newpage != 1) {
    if ($dummb[5] == "") {
      $xtippervereinradio = 0;
    } else {
      $xtippervereinradio = 1;
      $xtippervereinalt = $dummb[5];
    }
  }
   
  if ($newpage == 1) {
    $xtipperpass = trim($xtipperpass);
    if ($xtipperpass != $dummb[1]) {
      $newpage = 0;
      echo "<p class='error'>".$text['tipp'][42]."</p><br>";
    }
  }
   
  if ($newpage == 1) {
    $xtipperpassneu = trim($xtipperpassneu);
    if ($xtipperpassneu == "") {
      $newpage = 0;
      echo "<p class='error'>".$text['tipp'][69]."</p><br>";
    } elseif(strlen($xtipperpassneu) < 3) {
      $newpage = 0;
      echo "<p class='error'>".$text['tipp'][73]."</p><br>";
    }
    $xtipperpassneuw = trim($xtipperpassneuw);
    if ($xtipperpassneuw != $xtipperpassneu) {
      $newpage = 0;
      echo "<p class='error'>".$text['tipp'][70]."</p><br>";
    }
  }
   
  if ($newpage == 1) {
    $users[$save] = $dummb[0]."|".$xtipperpassneu."|".$dummb[2]."|".$dummb[3]."|".$dummb[4]."|".$dummb[5]."|".$dummb[6]."|".$dummb[7]."|".$dummb[8]."|".$dummb[9]."|".$dummb[10]."|EOL";
    require(PATH_TO_ADDONDIR."/tipp/lmo-tippsaveauth.php");
  } // end ($newpage==1)
?>
<table class="lmoMiddle" width="100%" cellspacing="0" cellpadding="0" border="0">
  <tr>
    <td align="center" class="active"><?=$lmotippername;if($lmotipperverein!=""){echo " - ".$lmotipperverein;} ?></td>
  </tr>
  <tr>
    <td align="center" class="active"><?=$text['tipp'][107]; ?></td>
  </tr>
  <tr>
    <td align="center"><? 
  if($newpage!=1){ ?>
      <form name="lmotippedit" action="<?=$_SERVER['PHP_SELF']; ?>" method="post">
        <input type="hidden" name="action" value="tipp">
        <input type="hidden" name="todo" value="pwchange">
        <input type="hidden" name="newpage" value="1">
        <table class="lmoInner" cellspacing="0" cellpadding="0" border="0">
          <tr>
            <td class="lmost5" width="20">&nbsp;</td>
            <td class="lmost5" align="right"><?=" ".$text['tipp'][140]; ?></td>
            <td class="lmost5"><input class="lmo-formular-input" type="password" name="xtipperpass" size="16" maxlength="32" value="<?=$xtipperpass; ?>"></td>
          </tr>
          <tr>
            <td class="lmost5" width="20">&nbsp;</td>
            <td class="lmost5" align="right"><?=" ".$text['tipp'][139]; ?></td>
            <td class="lmost5"><input class="lmo-formular-input" type="password" name="xtipperpassneu" size="16" maxlength="32" value="<?=$xtipperpassneu; ?>"></td>
          </tr>
          <tr>
            <td class="lmost5" width="20">&nbsp;</td>
            <td class="lmost5" align="right"><?=" ".$text['tipp'][139]." ".$text['tipp'][19]; ?></td>
            <td class="lmost5"><input class="lmo-formular-input" type="password" name="xtipperpassneuw" size="16" maxlength="32" value="<?=$xtipperpassneuw; ?>"></td>
          </tr>
          <tr>
            <td class="lmost4" colspan="3" align="right">
              <input class="lmo-formular-button" type="submit" name="xtippersub" value="<?=$text[329]; ?>">
            </td>
          </tr>
        </table>
      </form><? 
  }
  if($newpage==1){ /* erfolgreich */?>
      <table class="lmoInner" cellspacing="0" cellpadding="0" border="0">
        <tr>
          <td class="lmost5" align="center"><?=$text['tipp'][121]; ?></td>
        </tr>
        <tr>
          <td class="lmost4" align="right"><a href="<?=$_SERVER['PHP_SELF']."?action=tipp&amp;todo=" ?>"><?=$text[5]." ".$text['tipp'][1]; ?></a></td>
        </tr>
      </table><? 
  }?>
    </td>
  </tr>
</table><? 
} 
$file=""; ?>