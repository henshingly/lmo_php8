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
isset($_POST['save'])?$save=$_POST['save']:$save=0;
isset($_REQUEST['show'])?$show=$_REQUEST['show']:$show=0;
if($save==1){
  // Es werden alle Addon-Konfigurationen dargestellt als Texteingabe behandelt
  // und anschliessend abgespeichert - Es erfolgen keine Prüfungen auf Variablentyp und -wert
  foreach($cfgarray as $addon_name => $addon_cfg) {    //Alle Addons abklappern
    if (is_array($addon_cfg)) {                 //Addon gefunden 
      foreach ($addon_cfg as $cfg_name => $cfg_value) {
        if (isset($_POST["x$cfg_name"])) ${$addon_name."_".$cfg_name}=trim($_POST["x$cfg_name"]);    //Alle Post-vars mit x davor werden abgefragt und als Variable mit Präfix gespeichert
      }
    }
  }
  require(PATH_TO_LMO."/lmo-savecfg.php");
  require(PATH_TO_LMO."/lmo-cfgload.php");
}?>
<table class="lmoSubmenu" width="100%" cellspacing="0" cellpadding="0" border="0">
  <tr>
    <td align="center"><a href="<?=$addr_options?>" onclick="return chklmolink();" title="<?=$text[320]?>"><?=$text[319]?></a></td>
    <td align="center"><?=$text[497]?></td>
    <td align="center"><a href="<?=$addr_design?>" onclick="return chklmolink();" title="<?=$text[422]?>"><?=$text[421]?></a></td>
    <td align="center"><a href="<?=$addr_user?>" onclick="return chklmolink();" title="<?=$text[318]?>"><?=$text[317]?></a></td>
  </tr>
</table>
<table class="lmoMiddle" cellspacing="0" cellpadding="0" border="0">
  <tr>
    <td align="center" colspan="2"><?php echo getMessage($text[571],TRUE);?></td>
  </tr>
  <tr>
    <td align="center" colspan="2"><h1><?=$text[498]?></h1></td>
  </tr>
  <tr>
    <td valign="top">
      <table class="lmoMenu" cellspacing="0" cellpadding="0" border="0"><?
$testshow=0;
foreach($cfgarray as $addon_name => $addon_cfg) {
  if (is_array($addon_cfg)) {?>
        <tr><td align="right"<?if ($show==$testshow) {?> class="active"><?=$addon_name;?><?}else{?> class="lmost4"><a href="<?=$_SERVER['PHP_SELF']."?action=admin&amp;todo=addons&amp;show=".$testshow;?>"><?=$addon_name;?></a><?}?></td></tr><?
    $testshow++;
  }
}?>
      </table>
    </td>
    <td align="left" valign="top">
      <form name="lmoedit" action="<?=$_SERVER['PHP_SELF'];?>" method="post" onSubmit="return chklmopass()">
        <input type="hidden" name="action" value="admin">
        <input type="hidden" name="todo" value="addons">
        <input type="hidden" name="save" value="1">
        <input type="hidden" name="file" value="<?=$file;?>">
        <input type="hidden" name="show" value="<?=$show;?>">
        <table class="lmoInner" cellspacing="0" cellpadding="0" border="0"><?
$testshow=0;
foreach($cfgarray as $addon_name => $addon_cfg) {    //Alle Addons abklappern
  if (is_array($addon_cfg)) {
    if ($show==$testshow) {                      //Addon gefunden
      foreach ($addon_cfg as $cfg_name => $cfg_value) {   //Alle Konfigwerte des Addon
        ?><tr>
            <td class="lmost5" width="20">&nbsp;</td>
            <td align="right">
<?=$cfg_name?></td>
            <td align="left"><input class="lmo-formular-input" type="text" name="x<?=$cfg_name?>" size="30" value="<?=$cfg_value;?>" onChange="dolmoedit()"></td>
          </tr><?
      }
    }
    $testshow++;
  }
}?>
          <tr>
            <td class="lmost5" colspan="3" align="center">
              <input title="<?=$text[114]?>" class="lmo-formular-button" type="submit" name="best" value="<?=$text[188];?>">
            </td>
          </tr>
        </table
      </form>
    </td>
  </tr>
</table>