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
isset($_POST['save'])?$save=$_POST['save']:$save=0;
isset($_REQUEST['show'])?$show=$_REQUEST['show']:$show=0;
if($save==1){
  // Es werden alle Addon-Konfigurationen dargestellt als Texteingabe behandelt
  // und anschliessend abgespeichert - Es erfolgen keine Pr�fungen auf Variablentyp und -wert
  foreach($cfgarray as $addon_name => $addon_cfg) {    //Alle Addons abklappern
    if (is_array($addon_cfg)) {                 //Addon gefunden 
      foreach ($addon_cfg as $cfg_name => $cfg_value) {
        if (isset($_POST["x$cfg_name"])) ${$addon_name."_".$cfg_name}=trim($_POST["x$cfg_name"]);    //Alle Post-vars mit x davor werden abgefragt und als Variable mit Pr�fix gespeichert
      }
    }
  }
  require(PATH_TO_LMO."/lmo-savecfg.php");
  require(PATH_TO_LMO."/lmo-cfgload.php");
}?>
<nav>
  <ul class="nav nav-pills justify-content-center">
    <li class="nav-item" role="presentation"><a href="<?php echo $addr_options?>" class="nav-link" title="<?php echo $text[320]?>"><?php echo $text[319]?></a></li>
    <li class="nav-item" role="presentation"><a href="#" class="nav-link active"><?php echo $text[497]?></a></li>
    <li class="nav-item" role="presentation"><a href="<?php echo $addr_design?>" class="nav-link" title="<?php echo $text[422]?>"><?php echo $text[421]?></a></li>
    <li class="nav-item" role="presentation"><a href="<?php echo $addr_user?>" class="nav-link" title="<?php echo $text[318]?>"><?php echo $text[317]?></a></li>
  </ul>
</nav>
<div class="container">
  <div class="row">
    <div class="col"><?php echo getMessage($text[571],TRUE);?></div>
  </div>
  <div class="row">
    <div class="col"><h1><?php echo $text[498]?></h1></div>
  </div>
  <div class="row align-items-top">
    <div class="col-2 text-end">
      <div class="container"><?php 
$testshow=0;
foreach($cfgarray as $addon_name => $addon_cfg) {
  if (is_array($addon_cfg)) {?>
          <div class="row">
            <div class="col-1 text-end"<?php if ($show==$testshow) {?> class="active"><?php echo $addon_name;?><?php }else{?> class="lmost4"><a href="<?php echo $_SERVER['PHP_SELF']."?action=admin&amp;todo=addons&amp;show=".$testshow;?>"><?php echo $addon_name;?></a><?php }?></div><?php 
    $testshow++;
    ?>
          </div><?php
  }
}?>
      </div>
    </div>
    <div class="col-8">
      <form name="lmoedit" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post" onSubmit="return chklmopass()">
        <input type="hidden" name="action" value="admin">
        <input type="hidden" name="todo" value="addons">
        <input type="hidden" name="save" value="1">
        <input type="hidden" name="file" value="<?php echo $file;?>">
        <input type="hidden" name="show" value="<?php echo $show;?>">
        <div class="container">
          <div class="row align-items-center"><?php 
$testshow=0;
foreach($cfgarray as $addon_name => $addon_cfg) {    //Alle Addons abklappern
  if (is_array($addon_cfg)) {
    if ($show==$testshow) {                      //Addon gefunden
      foreach ($addon_cfg as $cfg_name => $cfg_value) {   //Alle Konfigwerte des Addon
        ?>
            <div class="col-4 text-end"><?php echo $cfg_name?></div>
            <div class="col-7 text-start"><input class="cuastom-control" type="text" name="x<?php echo $cfg_name?>" size="30" value="<?php echo $cfg_value;?>" onChange="dolmoedit()"></div><?php 
      }
    }
    $testshow++;
  }
}?>
          </div>
          <div class="row">
            <div class="col text-center">
              <input title="<?php echo $text[114]?>" class="btn btn-primary btn-sm" type="submit" name="best" value="<?php echo $text[188];?>">
            </div>
          </div>
        </div
      </form>
    </div>
  </div>
</div>