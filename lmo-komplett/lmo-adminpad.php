<?PHP
// 
// LigaManager Online 3.02
// Copyright (C) 1997-2002 by Frank Hollwitz
// webmaster@hollwitz.de / http://php.hollwitz.de
// 
// Tippspiel-AddOn 1.20
// Copyright (C) 2002 by Frank Albrecht
// fkalbrecht@web.de
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
if(($action=="admin") && ($todo=="")){
  $adda=$_SERVER['PHP_SELF']."?action=admin&amp;todo=";
?>
  <table class="lmosta" width="100%" cellspacing="0" cellpadding="0" border="0"><tr><td align="center" class="lmost1">
  <?PHP echo $text[92]; ?>
  </td></tr><tr><td align="center" class="lmost3">
  <table class="lmostb" cellspacing="0" cellpadding="0" border="0"><tr><td class="lmost5"><nobr>
    <ul>
<?PHP if($_SESSION["lmouserok"]==2){ ?>
      <li class="lmoadminli"><?PHP echo "<a href=\"".$adda."new&amp;".SID."\">".$text[93]."</a>"; ?></li>
<?PHP } ?>
      <li class="lmoadminli"><?PHP echo $text[94]; ?>:<?PHP $ftype=".l98"; require(PATH_TO_LMO."/lmo-admindir.php"); ?></li>
<?PHP if($_SESSION['lmouserok']==2){ ?>
      <li class="lmoadminli"><?PHP echo "<a href=\"".$adda."delete&amp;".SID."\">".$text[95]."</a>"; ?></li>
      <li class="lmoadminli"><?PHP echo "<a href=\"".$adda."upload&amp;".SID."\">".$text[96]."</a>"; ?></li>
<?PHP } ?>
      <li class="lmoadminli"><?PHP echo "<a href=\"".$adda."download&amp;".SID."\">".$text[349]."</a>"; ?></li>
<?PHP if($_SESSION['lmouserok']==2){ ?>
      <li class="lmoadminli"><?PHP echo "<a href=\"".$adda."options&amp;".SID."\">".$text[97]."</a>"; ?></li>
      <li class="lmoadminli"><?PHP echo "<a href=\"".$adda."tipp&amp;".SID."\">".$text['tipp'][115]."</a>"; ?></li>
<?PHP } ?>
      <li class="lmoadminli"><?PHP echo "<a href=\"".$adda."logout&amp;".SID."\">".$text[98]."</a>"; ?></li>
    </ul>
  </nobr></td></tr></table>
  </td></tr></table>

<?PHP
  }
?>