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
if (($action == "admin") && ($todo == "delete") && ($_SESSION['lmouserok'] == 2)) {
  $adda = $_SERVER['PHP_SELF']."?action=admin&amp;todo=";
  if (!isset($del)) {
    $del = 0;
  }
  if ($del == 1) {
    if (@unlink($dfile)) {
      echo getMessage($dfile." ".$text[297]);
    } else {
      echo getMessage($dfile." ".$text[298],TRUE);
    }
  }?>
<table class="lmoMiddle" width="99%" cellspacing="0" cellpadding="0" border="0">
  <tr>
    <td align="center"><h1><?=$text[295]; ?></h1></td>
  </tr>
  <tr>
    <td align="center">
      <table class="lmoInner" cellspacing="0" cellpadding="0" border="0">
        <tr>
          <td class="nobr" align="left"><? 
  $ftype=".l98"; 
  require(PATH_TO_LMO."/lmo-admindeldir.php"); ?>
          </nobr></td>
        </tr>
      </table>
    </td>
  </tr>
</table><?
}?>