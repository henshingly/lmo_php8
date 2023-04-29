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
<div class="container">
  <div class="row">
    <div class="col"><?php echo $text['tipp'][107]; ?></div>
  </div><?php if($newpage!=1){ ?>
  <div class="row">
    <div class="col offset-2">
      <form name="lmotippedit" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="form-inline">
        <input type="hidden" name="action" value="tipp">
        <input type="hidden" name="todo" value="pwchange">
        <input type="hidden" name="newpage" value="1">
        <div class="container">
          <div class="row p-1">
            <div class="col-4 text-end"><?php echo " ".$text['tipp'][140]; ?> &nbsp;</div>
            <div class="col-auto"><input class="form-control" type="password" name="xtipperpass" size="16" maxlength="32" value="<?php echo $xtipperpass; ?>"></div>
          </div>
          <div class="row p-1">
            <div class="col-4 text-end"><?php echo " ".$text['tipp'][139]; ?> &nbsp;</div>
            <div class="col-auto"><input class="form-control" type="password" name="xtipperpassneu" size="16" maxlength="32" value="<?php echo $xtipperpassneu; ?>"></div>
          </div>
          <div class="row p-1">
            <div class="col-4 text-end"><?php echo " ".$text['tipp'][139]." ".$text['tipp'][19]; ?> &nbsp;</div>
            <div class="col-auto"><input class="form-control" type="password" name="xtipperpassneuw" size="16" maxlength="32" value="<?php echo $xtipperpassneuw; ?>"></div>
          </div>
          <div class="row pt-3">
            <div class="col-4 text-end">
              <input class="btn btn-sm btn-primary" type="submit" name="xtippersub" value="<?php echo $text[329]; ?>">
            </div>
          </div>
        </form>
      </div>
    </div>
  </div><?php  }
  if($newpage==1){ /* erfolgreich */?>
  <div class="row">
    <div class="col offset-4"><?php echo getMessage($text['tipp'][121]); ?></div>
  </div>
  <div class="row">
    <div class="col offset-4"><a href="<?php echo $_SERVER['PHP_SELF']."?action=tipp&amp;todo=" ?>"><?php echo $text[5]." ".$text['tipp'][1]; ?></a></div>
  </div><?php  }?>
</div><?php } 
$file=""; ?>