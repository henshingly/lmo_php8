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

?>
<table class="lmoSubmenu" width="99%" cellspacing="0" cellpadding="0" border="0">
  <tr>
    <td align="center"><?php
if ($todo!='tipp') {?>
      <a href='<?php echo $tipp_addr_auswertung?>' onclick="return chklmolink();" title="<?php echo $text['tipp'][63]?>"><?php echo $text['tipp'][63]?></a><?php
} else {
  echo $text['tipp'][63];
}?> </td>
    <td align="center"><?php
if($_SESSION['lmouserok']==2){
  if ($todo!='tippemail') {?>
      <a href='<?php echo $tipp_addr_email?>' onClick="return chklmolink();" title="<?php echo $text['tipp'][165]?>"><?php echo $text['tipp'][165]?></a><?php
  } else {
    echo $text['tipp'][165];
  }?>
    </td>
    <td align="center"><?php
  if ($todo!='tippuser' && $todo!='tippuseredit') {?>
      <a href='<?php echo $tipp_addr_user?>' onClick="return chklmolink();" title="<?php echo $text['tipp'][114]?>"><?php echo $text['tipp'][114]?></a><?php
  } else {
    echo $text['tipp'][114];
  }?>
    </td>
    <td align="center"><?php
  if ($todo!='tippoptions') {?>
      <a href='<?php echo $tipp_addr_optionen?>' onClick="return chklmolink();" title="<?php echo $text['tipp'][55]?>"><?php echo $text[86]?></a><?php
  } else {
    echo $text[86];
  }?>
    </td><?php
}?>
  </tr>
</table>