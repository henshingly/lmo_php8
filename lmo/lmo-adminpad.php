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
if(($action=="admin") && ($todo=="")){
  $adda=$_SERVER['PHP_SELF']."?action=admin&amp;todo=";?>
<table class="lmoMiddle" cellspacing="0" cellpadding="0" border="0">
  <tr>
    <td align="center"><h1><?=$text[92];?></h1></td>
  </tr>
  <tr>
    <td align="center">
      <table class="lmoInner" cellspacing="0" cellpadding="0" border="0">
        <tr>
          <td class="lmost5" align="left">
            <ul><? 
  if($_SESSION["lmouserok"]==2){ ?>
              <li ><?="<a href='".$adda."new'>".$text[93]."</a>";?></li><?
  }?>
              <li ><?=$text[94];?>:<? $ftype=".l98"; require(PATH_TO_LMO."/lmo-dirlist.php");?></li><? 
  if($_SESSION['lmouserok']==2){ ?>
              <li><?="<a href='".$adda."delete'>".$text[95]."</a>"; ?></li>
              <li class="lmoadminli"><?="<a href='".$adda."upload'>".$text[96]."</a>"; ?></li><? 
  }?>
              <li class="lmoadminli"><?="<a href='".$adda."download'>".$text[349]."</a>"; ?></li><? 
  if($_SESSION['lmouserok']==2){ ?>
              <li class="lmoadminli"><?="<a href='".$adda."options'>".$text[97]."</a>"; ?></li><?
    if ($eintippspiel) {?>
              <li class="lmoadminli"><?="<a href='".$adda."tipp'>".$text['tipp'][115]."</a>"; ?></li><? 
    }
  }?>
              <li class="lmoadminli"><?="<a href='".$adda."logout'>".$text[98]."</a>"; ?></li>
            </ul>
          </td>
        </tr>
      </table>
    </td>
  </tr>
</table><?
}?>