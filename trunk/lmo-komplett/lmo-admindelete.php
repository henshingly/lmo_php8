<?PHP
// 
// LigaManager Online 3.02b
// Copyright (C) 1997-2002 by Frank Hollwitz
// webmaster@hollwitz.de / http://php.hollwitz.de
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
if (($action == "admin") && ($todo == "delete") && ($_SESSION['lmouserok'] == 2)) {
  $adda = $_SERVER['PHP_SELF']."?action=admin&amp;todo=";
  if (!isset($del)) {
    $del = 0;
  }
  if ($del == 1) {
    if (@unlink($dfile)) {
      echo "<p class='message'>".$dfile." ".$text[297]."</p>";
    } else {
      echo "<p class='error'>".$dfile." ".$text[298]."</p>";
    }
  }?>
<table class="lmoMiddle" width="100%" cellspacing="0" cellpadding="0" border="0">
  <tr>
    <td align="center"><h1><?=$text[295]; ?></h1></td>
  </tr>
  <tr>
    <td align="center">
      <table class="lmoInner" cellspacing="0" cellpadding="0" border="0">
        <tr>
          <td class="lmost5"><nobr><? 
  $ftype=".l98"; 
  require(PATH_TO_LMO."/lmo-admindeldir.php"); ?>
          </nobr></td>
        </tr>
      </table>
    </td>
  </tr>
</table><?
}?>