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
  
  
require_once(PATH_TO_ADDONDIR."/tipp/lmo-tipptest.php");
if (($action == "tipp") && ($todo == "delaccount")) {
  if (!isset($xtipperpass)) {
    $xtipperpass = "";
  }
  $users = array("");
  $pswfile = PATH_TO_ADDONDIR."/tipp/".$tipp_tippauthtxt;
  
  $users = file($pswfile);
  array_unshift($users,'');
  
  $gef = 0;
  for($i = 1; $i < count($users) && $gef == 0; $i++) {
    $dummb = explode('|', $users[$i]);
    if ($_SESSION['lmotippername'] == $dummb[0]) {
      // Nick gefunden
      $gef = 1;
      $del = $i;
    }
  }
  if ($gef == 0) {
    exit;
  }
   
  if ($newpage == 1) {
    $xtipperpass = trim($xtipperpass);
    if ($xtipperpass != $dummb[1]) {
      $newpage = 0;
      echo getMessage($text['tipp'][42],TRUE);
    }
  }
   
  if ($newpage == 1) {
    $userf3 = explode('|', $users[$del]);
    $verz = opendir(substr(PATH_TO_ADDONDIR."/tipp/".$tipp_dirtipp, 0, -1));
    $dummy = array("");
    while ($files = readdir($verz)) {
      if (substr($files, -5-strlen($userf3[0])) == "_".$userf3[0].".tip") {
        array_push($dummy, $files);
      }
    }
    closedir($verz);
    array_shift($dummy);
    $anztippfiles = count($dummy);
    for($k = 0; $k < $anztippfiles; $k++) {
      @unlink(PATH_TO_ADDONDIR."/tipp/".$tipp_dirtipp.$dummy[$k]); // Tipps löschen
    }
     
    for($i = $del+1; $i < count($users); $i++) {
      $users[$i-1] = $users[$i];
    }
    array_pop($users); // die letzte Zeile abgeschnitten
    require(PATH_TO_ADDONDIR."/tipp/lmo-tippsaveauth.php");
     
    $_SESSION["lmotipperok"] = 0;
    $lmotipperpass = "";
    $_SESSION['lmotipperverein'] = "";
  } // end ($newpage==1)

?>
  <div class="container">
    <div class="row">
      <div class="col offset-4"><?php echo $text['tipp'][6]; ?></div>
    </div>
    <div class="row p-3">
      <?php if($newpage!=1){ ?>
      <div class="col-2 offset-4">
        <form name="lmotippedit" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" onSubmit="return confirm('');" class="form-inline">
          <input type="hidden" name="action" value="tipp">
          <input type="hidden" name="todo" value="delaccount">
          <input type="hidden" name="newpage" value="1">
          <input class="form-control" type="password" name="xtipperpass" size="16" maxlength="32" value="<?php echo $xtipperpass; ?>" placeholder="<?php echo $text['tipp'][69]; ?>">
          <br />
          <input class="btn btn-sm btn-danger" type="submit" name="xtippersub" value="<?php echo $text[82]; ?>">
        </form>
      </div><?php  }
  if($newpage==1){ /* erfolgreich*/?>
      <div class="col offset-4"><?php echo getMessage($text['tipp'][121]); ?></div>
    </div>
    <div class="row">
      <div class="col offset-4"><a href="<?php echo $_SERVER['PHP_SELF']."?action=tipp&amp"; ?>">=> <?php echo $text['tipp'][141]; ?></a></div>
    </div><?php  }?>
  </div><?php } 
$file="";
?>