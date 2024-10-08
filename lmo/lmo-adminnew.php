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
    $teams[$i] = '';
    $teamk[$i] = '';
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
      if($anzteams==24) {
         switch ($i) {
           case 1:
           case 2:
             $anzsp=16;
             break;
           case 3:
             $anzsp=8;
             break;
           case 4:
             $anzsp=4;
             break;
           case 5:
             $anzsp=2;
             break;
         }
      }
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
<div class="container">
  <div class="row">
    <div class="col d-flex justify-content-center"><h1><?php echo  $text[243]; ?></h1></div>
  </div>
  <div class="row">
    <div class="col"><?php 
if($newpage<3){ ?>
      <form name="lmoedit" action="<?php echo  $_SERVER['PHP_SELF']; ?>" method="post">
        <input type="hidden" name="action" value="admin">
        <input type="hidden" name="todo" value="new">
        <input type="hidden" name="newpage" value="<?php echo ($newpage+1); ?>"><?php 
  if($newpage>0){ ?>
        <input type="hidden" name="xfile" value="<?php echo  $xfile; ?>">
        <input type="hidden" name="xtitel" value="<?php echo  $xtitel; ?>">
        <input type="hidden" name="xtype" value="<?php echo  $xtype; ?>"><?php 
  }
  if($newpage>1){ ?>
        <input type="hidden" name="xteams" value="<?php echo  $xteams; ?>">
        <input type="hidden" name="xanzst" value="<?php echo  $xanzst; ?>">
        <input type="hidden" name="xanzsp" value="<?php echo  $xanzsp; ?>"><?php 
  }
}?>
        <div class="container">
          <div class="row pb-1">
            <div class="col"><?php echo  $text[246]." ".($newpage+1)." ".$text[259]." 4"; ?></div>
          </div><?php 
if($newpage==0){ ?>
          <div class="row pb-1">
            <div class="col text-end"><acronym title="<?php echo  $text[245]; ?>"><?php echo  $text[244]; ?></acronym></div>
            <div class="col text-start"><acronym title="<?php echo  $text[245]; ?>"><?php echo  $dirliga; ?><input class="custom-control" type="text" name="xfile" maxlength="28" value="<?php echo  $xfile; ?>" placeholder="noname">.l98</acronym></div>
          </div>
          <div class="row pb-1">
            <div class="col text-end"><acronym title="<?php echo  $text[118] ?>"><?php echo  $text[113]; ?></acronym></div>
            <div class="col text-start"><acronym title="<?php echo  $text[118] ?>"><input class="custom-control" type="text" name="xtitel" size="26rem" maxlength="60" value="<?php echo  $xtitel; ?>" placeholder="No Name"></acronym></div>
          </div>
          <div class="row pb-1">
            <div class="col text-end"><acronym title="<?php echo  $text[175] ?>"><?php echo  $text[174]; ?></acronym></div>
            <div class="col text-start"><acronym title="<?php echo  $text[175] ?>"><select class="custom-select" name="xtype" onChange="dolmoedit()"><?php echo  "<option value=\"0\""; if($xtype==0){echo " selected";} echo ">".$text[176]."</option>"; echo "<option value=\"1\""; if($xtype==1){echo " selected";} echo ">".$text[177]."</option>"; ?></select></acronym></div>
          </div><?php 
}
if($newpage==1){
  if($xtype==0){?>
          <div class="row pb-1">
            <div class="col text-end"><acronym title="<?php echo  $text[272] ?>"><?php echo  $text[271]; ?></acronym></div>
            <div class="col text-start"><input class="custom-control" type="number" name="xteams" style="width: 4rem;" min="2" maxlength="2" value="18"></div>
          </div>
          <div class="row pb-1">
            <div class="col text-end"><acronym title="<?php echo  $text[275] ?>"><?php echo  $text[274]; ?></acronym></div>
            <div class="col text-start"><input class="custom-control" type="number" name="xanzst" style="width: 4rem;" min="1" maxlength="3" value="34"></div>
          </div>
          <div class="row pb-1">
            <div class="col text-end"><acronym title="<?php echo  $text[278] ?>"><?php echo  $text[277]; ?></acronym></div>
            <div class="col text-start"><input class="custom-control" type="number" name="xanzsp" style="width: 4rem;" min="1" maxlength="2" value="9"></div>
          </div><?php 
  }else{ ?>
          <div class="row pb-1">
            <div class="col text-end"><acronym title="<?php echo  $text[272] ?>"><?php echo  $text[271]; ?></acronym></div>
            <div class="col text-start">
              <select class="custom-select" name="xteams" onChange="dolmoedit()"><?php if($xteams==""){$xteams=16;}for($i=2;$i<129;$i=$i*2){ 
                echo "<option value=\"".$i."\""; if($xteams==$i){echo " selected";} echo ">".$i."</option>"; 
                if ($i==16) echo "<option value='24'>24</option>"; 
              } ?></select>
            </div>
          </div>
          <div class="row pb-1">
            <div class="col text-end"></div>
            <div class="col text-start"><?php echo  $text[350] ?></div>
          </div><?php 
  }
}
if($newpage==2){
  if($xtype==0){?>
          <div class="row pb-1">
            <div class="col text-end"><acronym title="<?php echo  $text[285] ?>"><?php echo  $text[284]; ?></acronym></div>
            <div class="col text-start">
              <input type="radio" class="form-check-input" name="xprogram" value="none"<?php if($xprogram=="none"){echo " checked";} ?> onChange="dolmoedit()"> <?php echo  $text[286]; ?><br><br>
              <?php echo  $text[287]; ?>:<br><?php 
    $ftype=".l98";
    require(PATH_TO_LMO."/lmo-adminnewdir.php"); ?><br><?php 
    
    // Änderungen s.janke@tu-bs.de - Beginn
    if ($xteams>=4) {
      $soll_anzsp = floor($xteams/2);
      $soll_anzst = floor($xteams*($xteams-1)/$soll_anzsp);
      // Prüfe: 1. Stimmt die Anzahl der Spiele pro Spieltag?
      //        2. Ist die Spieltaganzahl gleich Hin- und Rückrunde oder nur Hinrunde?
      if(($xanzsp==$soll_anzsp) && (($xanzst==$soll_anzst) || ($xanzst==$soll_anzst/2))){ ?>
              <input type="radio" class="form-check-input" name="xprogram" value="random"<?php if($xprogram=="random"){echo " checked";} ?> onChange="dolmoedit()"> <?php echo  $text[288];
      }
    }
    // Änderungen s.janke@tu-bs.de - Ende
    
    ?>
            </div>
          </div><?php 
  } else {
    for($i=1;$i<=$xanzst;$i++){?>
          <div class="row">
            <div class="col text-end"><acronym title="<?php echo  $text[352] ?>"><?php echo  $text[351]." ".$i; ?></acronym></div>
            <div class="col text-start">
              <select class="custom-select" name="xmod<?php echo  $i; ?>" onChange="dolmoedit()">
                <option value="1"<?php if($xmodus[$i-1]==1){echo " selected";}?>><?php echo $text[353]?></option>
                <option value="2"<?php if($xmodus[$i-1]==2){echo " selected";}?>><?php echo $text[354]?></option>
                <option value="3"<?php if($xmodus[$i-1]==3){echo " selected";}?>><?php echo $text[355]?></option>
                <option value="5"<?php if($xmodus[$i-1]==5){echo " selected";}?>><?php echo $text[356]?></option>
                <option value="7"<?php if($xmodus[$i-1]==7){echo " selected";}?>><?php echo $text[357]?></option>
              </select>
            </div>
          </div><?php 
    }
  }
}
if($newpage<3){ ?>
          <div class="row p-3">
            <div class="col-2 offset-2">
              <a href="<?php echo  $_SERVER['PHP_SELF']; ?>" class="btn btn-danger btn-sm" onclick="return siklmolink(this.href);" title="<?php echo  $text[248]; ?>"><?php echo  $text[247]; ?></a>
            </div><?php 
  if($newpage<2){ ?>
            <div class="col-4 text-end">
              <input title="<?php echo  $text[261]; ?>" class="btn btn-primary btn-sm" type="submit" name="best" value="<?php echo  $text[260]; ?>">
            </div><?php 
  } else {?>
            <div class="col-4 text-end">
              <input title="<?php echo  $text[290]; ?>" class="btn btn-primary btn-sm" type="submit" name="best" value="<?php echo  $text[289]; ?>">
            </div><?php 
  }?>
          </div><?php 
}
if($newpage==3){ ?>
          <div class="row">
            <div class="col"><?php echo  $text[291]; ?></div>
          </div>
          <div class="row pt-3">
            <div class="col">
              <a href="<?php echo  $_SERVER['PHP_SELF']."?action=admin&amp;todo=edit&amp;st=-2&amp;file=".$file; ?>" class="btn btn-success btn-sm" title="<?php echo  $text[293]; ?>"><?php echo  $text[292]; ?></a>
            </div>
          </div><?php 
} ?>
        </div>
      </form>
    </div>
  </div>
</div>
