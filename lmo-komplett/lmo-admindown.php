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
require_once("lmo-admintest.php");
if(($action=="admin") && ($todo=="download")){
?>
  <table class="lmosta" width="100%" cellspacing="0" cellpadding="0" border="0"><tr>
  <td align="center" class="lmost1"><?PHP echo $text[316]; ?></td>
  <td align="center" class="lmost1"><?PHP echo $text[345]; ?></td>
  </tr><tr>
  <td align="center" valign="top" class="lmost3"><table class="lmostb" cellspacing="0" cellpadding="0" border="0"><tr><td class="lmost5">
    <?PHP $ftype=".l98"; require("lmo-admindowndir.php"); ?>
  </td></tr></table></td>
  <td align="center" valign="top" class="lmost3"><table class="lmostb" cellspacing="0" cellpadding="0" border="0"><tr><td class="lmost5">
    <?PHP $ftype=".l98"; require("lmo-adminmimedir.php"); ?>
  </td></tr></table></td>
  </tr></table>
<?PHP
  }
?>
