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
if(($action=="admin") && ($todo=="open")){
  $adda=$_SERVER['PHP_SELF']."?action=admin&amp;todo=";
?>
<table class="lmosta" cellspacing="10" cellpadding="10" border="0">
  <tr>
    <td align="center" class="lmost1"><?=$text[294]?></td>
  </tr>
  <tr>
    <td align="center" class="lmost3">
      <table class="lmostb" cellspacing="0" cellpadding="0" border="0">
        <tr>
          <td class="lmost5" align="right">
            <small>
              <a href="<?=$_SERVER['PHP_SELF']?>?action=admin&amp;todo=open&amp;liga_sort=liga_name&amp;liga_sort_direction=asc" title="<?=$text[527].' '.$text[525].' '.$text[529].' '.$text[526]?>"><img src="<?=URL_TO_IMGDIR?>/lmo-admin0.gif" width="7" height="7" border="0" alt="<?=$text[529].' '.$text[527]?>"></a> <?=$text[529]?>
              <a href="<?=$_SERVER['PHP_SELF']?>?action=admin&amp;todo=open&amp;liga_sort=liga_name&amp;liga_sort_direction=desc" title="<?=$text[528].' '.$text[525].' '.$text[529].' '.$text[526]?>"><img src="<?=URL_TO_IMGDIR?>/lmo-admin2.gif" width="7" height="7" border="0" alt="<?=$text[529].' '.$text[528]?>"></a> |
              <a href="<?=$_SERVER['PHP_SELF']?>?action=admin&amp;todo=open&amp;liga_sort=file_name&amp;liga_sort_direction=asc" title="<?=$text[527].' '.$text[525].' '.$text[531].' '.$text[526]?>"><img src="<?=URL_TO_IMGDIR?>/lmo-admin1.gif" width="7" height="7" border="0" alt="<?=$text[531].' '.$text[527]?>"></a> <?=$text[531]?>
              <a href="<?=$_SERVER['PHP_SELF']?>?action=admin&amp;todo=open&amp;liga_sort=file_name&amp;liga_sort_direction=desc" title="<?=$text[528].' '.$text[525].' '.$text[531].' '.$text[526]?>"><img src="<?=URL_TO_IMGDIR?>/lmo-admin3.gif" width="7" height="7" border="0" alt="<?=$text[531].' '.$text[528]?>"></a> |
              <a href="<?=$_SERVER['PHP_SELF']?>?action=admin&amp;todo=open&amp;liga_sort=file_date&amp;liga_sort_direction=asc" title="<?=$text[527].' '.$text[525].' '.$text[530].' '.$text[526]?>"><img src="<?=URL_TO_IMGDIR?>/lmo-admin7.gif" width="7" height="7" border="0" alt="<?=$text[530].' '.$text[527]?>"></a> <?=$text[530]?>
              <a href="<?=$_SERVER['PHP_SELF']?>?action=admin&amp;todo=open&amp;liga_sort=file_date&amp;liga_sort_direction=desc" title="<?=$text[528].' '.$text[525].' '.$text[530].' '.$text[526]?>"><img src="<?=URL_TO_IMGDIR?>/lmo-admin6.gif" width="7" height="7" border="0" alt="<?=$text[530].' '.$text[528]?>"></a>
            </small>
          </td>
        </tr>
        <tr>
          <td class="lmost5" align="left"><? require(PATH_TO_LMO."/lmo-admindir.php"); ?></td>
        </tr>
        <tr>
          <td class="lmost5" align="right">
            <small>
              <a href="<?=$_SERVER['PHP_SELF']?>?action=admin&amp;todo=open&amp;liga_sort=liga_name&amp;liga_sort_direction=asc" title="<?=$text[527].' '.$text[525].' '.$text[529].' '.$text[526]?>"><img src="<?=URL_TO_IMGDIR?>/lmo-admin0.gif" width="7" height="7" border="0" alt="<?=$text[529].' '.$text[527]?>"></a> <?=$text[529]?>
              <a href="<?=$_SERVER['PHP_SELF']?>?action=admin&amp;todo=open&amp;liga_sort=liga_name&amp;liga_sort_direction=desc" title="<?=$text[528].' '.$text[525].' '.$text[529].' '.$text[526]?>"><img src="<?=URL_TO_IMGDIR?>/lmo-admin2.gif" width="7" height="7" border="0" alt="<?=$text[529].' '.$text[528]?>"></a> |
              <a href="<?=$_SERVER['PHP_SELF']?>?action=admin&amp;todo=open&amp;liga_sort=file_name&amp;liga_sort_direction=asc" title="<?=$text[527].' '.$text[525].' '.$text[531].' '.$text[526]?>"><img src="<?=URL_TO_IMGDIR?>/lmo-admin1.gif" width="7" height="7" border="0" alt="<?=$text[531].' '.$text[527]?>"></a> <?=$text[531]?>
              <a href="<?=$_SERVER['PHP_SELF']?>?action=admin&amp;todo=open&amp;liga_sort=file_name&amp;liga_sort_direction=desc" title="<?=$text[528].' '.$text[525].' '.$text[531].' '.$text[526]?>"><img src="<?=URL_TO_IMGDIR?>/lmo-admin3.gif" width="7" height="7" border="0" alt="<?=$text[531].' '.$text[528]?>"></a> |
              <a href="<?=$_SERVER['PHP_SELF']?>?action=admin&amp;todo=open&amp;liga_sort=file_date&amp;liga_sort_direction=asc" title="<?=$text[527].' '.$text[525].' '.$text[530].' '.$text[526]?>"><img src="<?=URL_TO_IMGDIR?>/lmo-admin7.gif" width="7" height="7" border="0" alt="<?=$text[530].' '.$text[527]?>"></a> <?=$text[530]?>
              <a href="<?=$_SERVER['PHP_SELF']?>?action=admin&amp;todo=open&amp;liga_sort=file_date&amp;liga_sort_direction=desc" title="<?=$text[528].' '.$text[525].' '.$text[530].' '.$text[526]?>"><img src="<?=URL_TO_IMGDIR?>/lmo-admin6.gif" width="7" height="7" border="0" alt="<?=$text[530].' '.$text[528]?>"></a>
            </small>
          </td>
        </tr>
      </table>
    </td>
  </tr>
</table><?
}?>