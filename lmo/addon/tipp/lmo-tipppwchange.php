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

$xtipperpass=isset($_REQUEST['xtipperpass'])?$_REQUEST['xtipperpass']:'';
$xtipperpassneu=isset($_REQUEST['xtipperpassneu'])?$_REQUEST['xtipperpassneu']:'';
$xtipperpassneuw=isset($_REQUEST['xtipperpassneuw'])?$_REQUEST['xtipperpassneuw']:'';
$newpage=isset($_REQUEST['newpage'])?1:0;

require_once(PATH_TO_ADDONDIR."/tipp/lmo-tipptest.php");
if (($action == "tipp") && ($todo == "pwchange")) {

  $users = array("");
  $pswfile = PATH_TO_ADDONDIR."/tipp/".$tipp_tippauthtxt;
  $datei = fopen($pswfile, "rb");
  while ($datei && !feof($datei)) {
    $zeile = fgets($datei, 1000);
    $zeile = trim($zeile);
    if ($zeile != "") {
      if ($zeile != "") {
        array_push($users, $zeile);
      }
    }
  }
  fclose($datei);
  
  $gef = 0;
  for($i = 1; $i < count($users) && $gef == 0; $i++) {
    $dummb = explode('|', $users[$i]);
    if ($_SESSION['lmotippername'] == $dummb[0]) {
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
      echo getMessage($text['tipp'][42],TRUE);
    }
  }
   
  if ($newpage == 1) {
    $xtipperpassneu = trim($xtipperpassneu);
    if ($xtipperpassneu == "") {
      $newpage = 0;
      echo getMessage($text['tipp'][69],TRUE);
    } elseif(strlen($xtipperpassneu) < 3) {
      $newpage = 0;
      echo getMessage($text['tipp'][73],TRUE);
    }
    $xtipperpassneuw = trim($xtipperpassneuw);
    if ($xtipperpassneuw != $xtipperpassneu) {
      $newpage = 0;
      echo getMessage($text['tipp'][70],TRUE);
    }
  }
   
  if ($newpage == 1) {
    $users[$save] = $dummb[0]."|".$xtipperpassneu."|".$dummb[2]."|".$dummb[3]."|".$dummb[4]."|".$dummb[5]."|".$dummb[6]."|".$dummb[7]."|".$dummb[8]."|".$dummb[9]."|".$dummb[10]."|EOL";
    require(PATH_TO_ADDONDIR."/tipp/lmo-tippsaveauth.php");
  } // end ($newpage==1)
?>
<table class="lmoInner" cellspacing="0" cellpadding="0" border="0">
  <caption><?=$_SESSION['lmotippername'];if($_SESSION['lmotipperverein']!=""){echo " - ".$_SESSION['lmotipperverein'];} ?></caption>
  <tr>
    <th align="center"><?=$text['tipp'][107]; ?></th>
  </tr><? 
  if($newpage!=1){ ?>
  <tr>
    <td align="center">
      <form name="lmotippedit" action="<?=$_SERVER['PHP_SELF']; ?>" method="post">
        <input type="hidden" name="action" value="tipp">
        <input type="hidden" name="todo" value="pwchange">
        <input type="hidden" name="newpage" value="1">
        <table class="lmoInner" cellspacing="0" cellpadding="0" border="0">
          <tr>
            <td width="20">&nbsp;</td>
            <td class="nobr" align="right"><?=" ".$text['tipp'][140]; ?> &nbsp;</td>
            <td class="nobr"><input class="lmo-formular-input" type="password" name="xtipperpass" size="16" maxlength="32" value="<?=$xtipperpass; ?>"></td>
          </tr>
          <tr>
            <td width="20">&nbsp;</td>
            <td class="nobr" align="right"><?=" ".$text['tipp'][139]; ?> &nbsp;</td>
            <td class="nobr"><input class="lmo-formular-input" type="password" name="xtipperpassneu" size="16" maxlength="32" value="<?=$xtipperpassneu; ?>"></td>
          </tr>
          <tr>
            <td width="20">&nbsp;</td>
            <td class="nobr" align="right"><?=" ".$text['tipp'][139]." ".$text['tipp'][19]; ?> &nbsp;</td>
            <td class="nobr"><input class="lmo-formular-input" type="password" name="xtipperpassneuw" size="16" maxlength="32" value="<?=$xtipperpassneuw; ?>"></td>
          </tr>
          <tr>
            <td class="lmost4" colspan="3" align="right">
              <input class="lmo-formular-button" type="submit" name="xtippersub" value="<?=$text[329]; ?>">
            </td>
          </tr>
        </table>
      </form>
    </td>
  </tr><? 
  }
  if($newpage==1){ /* erfolgreich */?>
  <tr>
    <td align="center"><?php echo getMessage($text['tipp'][121]); ?></td>
  </tr>
  <tr>
    <td class="lmoFooter" align="right"><a href="<?=$_SERVER['PHP_SELF']."?action=tipp&amp;todo=" ?>"><?=$text[5]." ".$text['tipp'][1]; ?></a></td>
  </tr><? 
  }?>
</table><? 
} 
$file=""; ?>