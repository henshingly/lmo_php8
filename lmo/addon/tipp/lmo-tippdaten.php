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
if (($action == "tipp") && ($todo == "daten")) {
  
  $newpage            = isset($_POST['newpage'])            ? trim($_POST['newpage'])            : 0;
  $xtippervorname     = isset($_POST['xtippervorname'])     ? trim($_POST['xtippervorname'])     : "";
  $xtippernachname    = isset($_POST['xtippernachname'])    ? trim($_POST['xtippernachname'])    : "";
  $xtipperemail       = isset($_POST['xtipperemail'])       ? trim($_POST['xtipperemail'])       : "";
  $xtipperstrasse     = isset($_POST['xtipperstrasse'])     ? trim($_POST['xtipperstrasse'])     : "";
  $xtipperplz         = isset($_POST['xtipperplz'])         ? trim($_POST['xtipperplz'])         : "";
  $xtipperort         = isset($_POST['xtipperort'])         ? trim($_POST['xtipperort'])         : "";
  $xtippervereinradio = isset($_POST['xtippervereinradio']) ? trim($_POST['xtippervereinradio']) : 0;
  $xtippervereinalt   = isset($_POST['xtippervereinalt'])   ? trim($_POST['xtippervereinalt'])   : "";
  $xtippervereinneu   = isset($_POST['xtippervereinneu'])   ? trim($_POST['xtippervereinneu'])   : "";
  $xtipperligen       = isset($_POST['xtipperligen'])       ? $_POST['xtipperligen']             : array();
  $xnews              = isset($_POST['xnews'])              ? '1'                                : '-1';
  $xremind            = isset($_POST['xremind'])            ? '1'                                : '-1';

  if ($tipp_freischaltcode==1) {
    isset($_POST['xtipperemail2'])?        $xtipperemail2=trim($_POST['xtipperemail2']):          $xtipperemail2="";
  } else {
    $xtipperemail2=$xtipperemail;
  }
  
  $users = array("");
  $pswfile = PATH_TO_ADDONDIR."/tipp/".$tipp_tippauthtxt;
  
  $users = file($pswfile);
  array_unshift($users,'');
  
  $tipp_tipper_gefunden = 0;
  $xtippernick="";
  for($i = 1; $i < count($users) && $tipp_tipper_gefunden == 0; $i++) {
    $tipp_tipper_daten = explode('|', $users[$i]);
    if ($_SESSION['lmotippername'] == $tipp_tipper_daten[0]) {
      // Nick gefunden
      $tipp_tipper_gefunden = 1;
      $xtippernick=$tipp_tipper_daten[0];
      $save = $i;
    }
  }
  if ($tipp_tipper_gefunden == 0) {
    exit;
  }

  if ($newpage != 1) {
    if ($tipp_tipper_daten[5] == "") {
      $xtippervereinradio = 0;
    } else {
      $xtippervereinradio = 1;
      $xtippervereinalt = $tipp_tipper_daten[5];
    }
  }
  if ($newpage == 1) {
    if ($tipp_realname != 0) {
      if ($xtippervorname == "") {
        $newpage = 0;
        echo getMessage($text['tipp'][66],TRUE);
      }
      if ($xtippernachname == "") {
        $newpage = 0;
        echo getMessage($text['tipp'][67],TRUE);
      }
      if (strpos($xtippernachname, " ") != false || strpos($xtippervorname, " ") > -1) {
        $newpage = 0;
        echo getMessage($text['tipp'][109],TRUE);
      }
    }
    if ($tipp_adresse == 1) {
      if ($xtipperstrasse == "") {
        $newpage = 0;
        echo getMessage($text['tipp'][129],TRUE);
      }
      if ($xtipperplz == "") {
        $newpage = 0;
        echo getMessage($text['tipp'][130],TRUE);
      }
      if ($xtipperort == "") {
        $newpage = 0;
        echo getMessage($text['tipp'][131],TRUE);
      }
    }
    if ($xtipperemail=="" || strpos($xtipperemail, " ")>0 || strpos($xtipperemail, "@")<1 || $xtipperemail!= $xtipperemail2) {
      $newpage = 0;
      echo getMessage($text['tipp'][68],TRUE);
    }
    if ($xtippervereinradio == 1) {
      if ($xtippervereinalt == "") {
        $newpage = 0;
        echo getMessage($text['tipp'][71],TRUE);
      } else {
        require(PATH_TO_ADDONDIR."/tipp/lmo-tippcheckteam.php");
      }
    }
    if ($xtippervereinradio == 2) {
      $xtippervereinneu = trim($xtippervereinneu);
      if ($xtippervereinneu == "") {
        $newpage = 0;
        echo getMessage($text['tipp'][72],TRUE);
      } else {
        require(PATH_TO_ADDONDIR."/tipp/lmo-tippcheckteam.php");
      }
    }
    $xtipperpass=$tipp_tipper_daten[1];
    if ($tipp_freischaltcode!=1 && $xtipperemail!=$tipp_tipper_daten[4]) {
      $tipp_tipper_daten[1]=substr(md5(uniqid(rand())),0,rand(8,16));
      $xtipperpass=$tipp_tipper_daten[1];
    }
  }
   
  if ($newpage == 1) {
    if ($xtippervereinradio == 1) {
      $_SESSION['lmotipperverein'] = $xtippervereinalt;
    } elseif($xtippervereinradio == 2) {
      $_SESSION['lmotipperverein'] = $xtippervereinneu;
    } else {
      $_SESSION['lmotipperverein'] = "";
    }
    $users[$save] = $tipp_tipper_daten[0]."|".$tipp_tipper_daten[1]."|".$tipp_tipper_daten[2]."|";
    if ($tipp_realname != -1) {
      $users[$save] = $users[$save].$xtippervorname." ".$xtippernachname;
    }
    $users[$save] = $users[$save]."|".$xtipperemail."|".$_SESSION['lmotipperverein'];
    if ($tipp_adresse == 1) {
      $users[$save] .= "|".$xtipperstrasse."|".$xtipperplz."|".$xtipperort;
    } else {
      $users[$save] .= "|".$tipp_tipper_daten[6]."|".$tipp_tipper_daten[7]."|".$tipp_tipper_daten[8];
    }
    $users[$save] .= "|";
    if ($xnews == 1) {
      $users[$save] .= "1";
    } else {
      $users[$save] .= "-1";
    }
    $users[$save] .= "|";
    if ($xremind == 1) {
      $users[$save] .= "1";
    } else {
      $users[$save] .= "-1";
    }
    $users[$save] .= "|EOL";
    require(PATH_TO_ADDONDIR."/tipp/lmo-tippsaveauth.php");
    /**Freischaltcode versenden*/
    if ($tipp_freischaltcode!=1 && $xtipperemail!=$tipp_tipper_daten[4]) {
      include(PATH_TO_ADDONDIR."/tipp/lmo-admintippfreischaltung.php");
    }
    
  } // end ($newpage==1)
?>
<div class="container">
<?php 
  if($newpage!=1){ ?>
  <div class="row">
    <div class="col offset-4">
      <form name="lmotippedit" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="form-inline">
        <input type="hidden" name="action" value="tipp">
        <input type="hidden" name="todo" value="daten">
        <input type="hidden" name="newpage" value="1">
        <div class="container"><?php 
    if($tipp_realname!=0){ ?>
          <div class="row">
            <div class="col-2 text-end"><?php echo " ".$text['tipp'][14]; ?></div>
            <div class="col-4"><input class="form-control" type="text" name="xtippervorname" size="25" maxlength="32" value="<?php echo substr($tipp_tipper_daten[3],0,strpos($tipp_tipper_daten[3]," ")); ?>"></div>
          </div>
          <div class="row">
            <div class="col-2 text-end"><?php echo " ".$text['tipp'][15]; ?></div>
            <div class="col-4"><input class="form-control" type="text" name="xtippernachname" size="25" maxlength="32" value="<?php echo substr($tipp_tipper_daten[3],strpos($tipp_tipper_daten[3]," ")+1); ?>"></div>
          </div>
<?php   }
    if($tipp_adresse==1){ ?>
          <div class="row">
            <div class="col-2 text-end"><?php echo " ".$text['tipp'][126]; ?></div>
            <div class="col-4"><input class="form-control" type="text" name="xtipperstrasse" size="25" maxlength="32" value="<?php echo $tipp_tipper_daten[6]; ?>"></div>
          </div>
          <div class="row">
            <div class="col-2 text-end"><?php echo " ".$text['tipp'][127]; ?> &nbsp;</div>
            <div class="col-4"><input class="form-control" type="text" name="xtipperplz" size="7" maxlength="5" value="<?php echo $tipp_tipper_daten[7]; ?>"></div>
          </div>
          <div class="row">
            <div class="col-2 text-end"><?php echo " ".$text['tipp'][128]; ?> &nbsp;</div>
            <div class="col-4"><input class="form-control" type="text" name="xtipperort" size="25" maxlength="32" value="<?php echo $tipp_tipper_daten[8]; ?>"></div>
          </div>
<?php   } ?>
          <div class="row">
            <div class="col-2 text-end"><?php echo " ".$text['tipp'][16]; ?> &nbsp;</div>
            <div class="col-4"><input class="form-control" type="text" name="xtipperemail" size="25" maxlength="64" value="<?php echo $tipp_tipper_daten[4]; ?>"></div>
          </div><?php 
    if ($tipp_freischaltcode==1) {?>
          <div class="row">
            <div class="col-2 text-end"><acronym title="<?php echo $text['tipp'][300]?>"><?php echo " ".$text['tipp'][16]." ".$text['tipp'][19]; ?></acronym></div>
            <div class="col-4"><input class="form-control" type="text" name="xtipperemail2" size="25" maxlength="64" value="<?php echo $tipp_tipper_daten[4]; ?>"></div>
          </div><?php 
    } ?>
          <div class="row">
            <div class="col"><?php echo $text['tipp'][207]; ?></th>
          </div>
          <div class="row">
            <div class="col">
            <input type="checkbox" class="form-check-input" name="xnews" value="1" <?php if($tipp_tipper_daten[9]!=-1){echo "checked";} ?>>&nbsp;<?php echo $text['tipp'][206] ?><br>
            <input type="checkbox" class="form-check-input" name="xremind" value="1" <?php if($tipp_tipper_daten[10]!=-1){echo "checked";} ?>>&nbsp;<?php echo $text['tipp'][167] ?>
            </div>
          </div><?php   
    if($tipp_tipperimteam>=0){ ?>
          <div class="row">
            <div class="col"><?php echo $text['tipp'][47]; ?></th>
          </div>
          <div class="row">
            <div class="col"><input type="radio" class="form-check-input" name="xtippervereinradio" value="0" <?php if($xtippervereinradio==0){echo "checked";} ?>> <?php echo $text['tipp'][50]; ?></div>
          </div>
          <div class="row"r>
            <div class="col-4"><input type="radio" class="form-check-input" name="xtippervereinradio" value="1" <?php if($xtippervereinradio==1){echo "checked";} ?>> <?php echo $text['tipp'][48]; ?></div>
            <div class="col--auto">
              <select class="form-select" name="xtippervereinalt" onChange="xtippervereinradio[1].checked=true">
      <?php 
      echo "<option value='' "; if($xtippervereinalt==""){echo "selected";} echo ">".$text['tipp'][51]."</option>";
      require(PATH_TO_ADDONDIR."/tipp/lmo-tippnewteams.php");
      ?>
              </select>
            </div>
          </div>
          <div class="row">
            <div class="col-2 text-end"><input type="radio" class="form-check-input" name="xtippervereinradio" value="2" <?php if($xtippervereinradio==2){echo "checked";} ?>><?php echo $text['tipp'][49]; ?></div>
            <div class="col-4"><input class="form-control" type="text" name="xtippervereinneu" size="25" maxlength="32" value="<?php echo $xtippervereinneu; ?>" onFocus="xtippervereinradio[2].checked=true"></div>
          </div><?php 
    }
    if($tipp_tipper_gefunden==1){ ?>
          <div class="row pt-3">
            <div class="col">
              <input class="btn btn-sm btn-primary" type="submit" name="xtippersub" value="<?php echo $text[329]; ?>">
            </div>
          </div>
<?php   } ?>
        </table>
      </form>
    </div>
  </div><?php 
  } else { /* Anmeldung erfolgreich */?>
  <div class="row">
    <div class="col offset-4"><?php echo getMessage($text['tipp'][121]); ?></div>
  </div>
  <div class="row">
    <div class="col"><a href="<?php echo $_SERVER['PHP_SELF']."?action=tipp&amp;todo=" ?>"><?php echo $text[5]." ".$text['tipp'][1]; ?></a></div>
  </div><?php 
  }?>
</table><?php 
} 
$file=""; ?>