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
  
  if(!isset($save)){$save=0;}

  if($save==2){require(PATH_TO_LMO."/lmo-tippsavewert.php");}
  if($save==4){require(PATH_TO_LMO."/lmo-tippsavewertgesamt.php");}
  if($save==3){require(PATH_TO_LMO."/lmo-tippsaveeinsicht.php");}
  
  $addu=$_SERVER['PHP_SELF']."?action=admin&amp;todo=tippuser";
  $adde=$_SERVER['PHP_SELF']."?action=admin&amp;todo=tippemail";
  $addo=$_SERVER['PHP_SELF']."?action=admin&amp;todo=tippoptions";
?>

<table class="lmosta" cellspacing="0" cellpadding="0" border="0">
  <tr>
    <td class="lmost1" align="center"><?PHP echo $text[2063] ?></td>
  </tr>
  <tr><td align="center" class="lmost3"><table class="lmostb" cellspacing="0" cellpadding="0" border="0">
  <tr>
    <td class="lmost4" colspan="3"><nobr><?PHP echo $text[2064]; ?></nobr></td>
  </tr>
 <?PHP $ftype=".l98"; $iptype="auswert"; require(PATH_TO_LMO."/lmo-tippnewdir.php"); ?>
<?PHP if($gesamt==1){ ?>
  <tr>
      <td class="lmost5" width="20">&nbsp;</td>
      <td class="lmost5"><strong><?PHP echo $text[2056]; ?></strong></td>
   <td class="lmost5" align="right">
    <form name="lmoedit" action="<?PHP echo $_SERVER['PHP_SELF']; ?>" method="post">
    <input type="hidden" name="action" value="admin">
    <input type="hidden" name="todo" value="tipp">
    <input type="hidden" name="save" value="4">
    <input class="lmoadminbut" type="submit" name="best" value="<?PHP echo $text[2236]; ?>">
    </form>
      </td>
     </tr>
<?PHP } ?>

  <tr>
    <td class="lmost4" colspan="3"><nobr><?PHP echo $text[2155]; ?></nobr></td>
  </tr>
 <?PHP $ftype=".l98"; $iptype="einsicht"; require(PATH_TO_LMO."/lmo-tippnewdir.php"); ?>
  </table></td>
  <tr>
    <td><table width="100%" cellspacing="0" cellpadding="0" border="0"><tr>
<?PHP 
  echo "<td class=\"lmost1\" align=\"center\">".$text[2063]."</td>";
if($_SESSION['lmouserok']==2){
  echo "<td class=\"lmost2\" align=\"center\"><a href='$adde' onclick=\"return chklmolink(this.href);\" title=\"".$text[2165]."\">".$text[2165]."</a></td>";
  echo "<td class=\"lmost2\" align=\"center\"><a href='$addu' onclick=\"return chklmolink(this.href);\" title=\"".$text[2114]."\">".$text[2114]."</a></td>";
  echo "<td class=\"lmost2\" align=\"center\"><a href='$addo' onclick=\"return chklmolink(this.href);\" title=\"".$text[2055]."\">".$text[86]."</a></td>";
  }
?>
    </tr></table></td>
  </tr>
</table>