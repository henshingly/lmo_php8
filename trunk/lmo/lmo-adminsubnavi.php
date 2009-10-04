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
  * $Id$
  */
?>
<table class="lmoSubmenu" width="100%" cellspacing="0" cellpadding="0" border="0">
  <tr><?
if($st<0 || $todo!="edit"){?>
    <td align="center"><a href='<?=$addr?>1' onClick="return chklmolink();" title="<?=$text[411]?>"><?=$text[412]?></a></td><?
}else{?>
    <td align="center"><?=$text[412]?></td><?
}
if ($einspieler==1) {
  if ($st!=-4) {?>
      <td align="center"><a href='<?=$addr?>-4' onClick="return chklmolink();" title="<?=$text['spieler'][1]?>"><?=$text['spieler'][18]?></a></td><?
  }else{?>
      <td align="center"><?=$text['spieler'][18]?></td><?
  }
}

if($st!=-1){?>
    <td align="center"><a href='<?=$addr?>-1' onClick="return chklmolink();" title="<?=$text[100]?>"><?=$text[99]?></a></td><?
}else{?>
    <td align="center"><?=$text[99]?></td><?
}

if($hands==1){
  if($todo!="tabs"){?>
    <td align="center"><a href='<?=$addb.$stx?>' onClick="return chklmolink();" title="<?=$text[409]?>"><?=$text[410]?></a></td><?
  }else{?>
    <td align="center"><?=$text[410]?></td><?
  }
}

if($_SESSION['lmouserok']==2 || $_SESSION['lmouserokerweitert']==1){
  if($st!=-2){?>
    <td align="center"><a href='<?=$addr?>-2' onClick="return chklmolink();" title="<?=$text[102]?>"><?=$text[101]?></a></td><?
  }else{?>
    <td align="center"><?=$text[101]?></td><?
  }
}

if($st!=-10){?>
    <td align="center">
      <a href='<?=$addr?>-10' onclick="return chklmolink(this.href);" title="<?=$text[5002]?>"><?=$text[5001]?></a>
    </td><?
}else{?>
    <td align="center"><?=$text[5001]?></td><?
}?>
  </tr>
</table>