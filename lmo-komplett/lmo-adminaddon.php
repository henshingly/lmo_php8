<?PHP
// 
// LigaManager Online 3.02b
// Copyright (C) 1997-2002 by Frank Hollwitz
// webmaster@hollwitz.de / http://php.hollwitz.de
// 
// LigaManager Online
// Edited by: Rene Marth
// 29.08.2003
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

require_once(PATH_TO_LMO."/lmo-admintest.php");
  isset($_POST['save'])?$save=$_POST['save']:$save=0;
  if($save==1){
    // Es werden alle Addon-Konfigurationen dargestellt als Texteingabe behandelt
    // und anschliessend abgespeichert - Es erfolgen keine Prüfungen auf Variablentyp und -wert
    foreach($cfgarray as $addon_name => $addon_cfg) {    //Alle Addons abklappern
      echo "$$$$$$$$";
      if (is_array($addon_cfg)) {                 //Addon gefunden
        
        foreach ($addon_cfg as $cfg_name => $cfg_value) {
          ${$addon_name."_".$cfg_name}=trim($_POST["x$cfg_name"]);    //Alle Post-vars mit x davor werden abgefragt und als Variable mit Präfix gespeichert
        }
      }
    }
    require(PATH_TO_LMO."/lmo-savecfg.php");
    require(PATH_TO_LMO."/lmo-cfgload.php");
  }?>
<table class="lmosta" cellspacing="0" cellpadding="0" border="0">
  <tr>
    <td class="lmost1" align="center"><?=$text[498]?></td>
  </tr>
  <tr>
    <td align="center" class="lmost3">
      <form name="lmoedit" action="<?=$_SERVER['PHP_SELF'];?>" method="post" onSubmit="return chklmopass()">
        <input type="hidden" name="action" value="admin">
        <input type="hidden" name="todo" value="addons">
        <input type="hidden" name="save" value="1">
        <input type="hidden" name="file" value="<?=$file;?>">
        <table class="lmostb" cellspacing="0" cellpadding="0" border="0"><?
  foreach($cfgarray as $addon_name => $addon_cfg) {    //Alle Addons abklappern
    if (is_array($addon_cfg)) {                      //Addon gefunden
        ?><tr>
            <td class="lmost4" colspan="3"><?=$addon_name;?></td>
          </tr><?
      foreach ($addon_cfg as $cfg_name => $cfg_value) {   //Alle Konfigwerte des Addon
        ?><tr>
            <td class="lmost5" width="20">&nbsp;</td>
            <td class="lmost5" align="right"><?=$cfg_name?></td>
            <td class="lmost5"><input class="lmoadminein" type="text" name="x<?=$cfg_name?>" size="30" value="<?=$cfg_value;?>" onChange="dolmoedit()"></td>
          </tr><?
      }
    }
  }?>
          <tr>
            <td class="lmost4" colspan="3" align="right">
              <acronym title="<?=$text[114]?>"><input class="lmoadminbut" type="submit" name="best" value="<?=$text[188];?>"></acronym>
            </td>
          </tr>
        </table
      </form>
    </td>
  </tr>
  <tr>
    <td>
      <table width="100%" cellspacing="0" cellpadding="0" border="0">
        <tr>
          <td class="lmost2" align="center"><a href="<?=$addr_options?>" onclick="return chklmolink('<?=$addr_options?>');" title="<?=$text[320]?>"><?=$text[319]?></a></td>
          <td class="lmost2" align="center"><?=$text[497]?></td>
          <td class="lmost2" align="center"><a href="<?=$addr_design?>" onclick="return chklmolink('<?=$addr_design?>');" title="<?=$text[422]?>"><?=$text[421]?></a></td>
          <td class="lmost2" align="center"><a href="<?=$addr_user?>" onclick="return chklmolink('<?=$addr_user?>');" title="<?=$text[318]?>"><?=$text[317]?></a></td>
        </tr>
      </table>
    </td>
  </tr>
</table>