<?
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
  require_once("../init.php");
  
  if(!isset($save)){$save=0;}

  if($save==2){require(PATH_TO_ADDONDIR."/tipp/lmo-tippsavewert.php");}
  if($save==4){require(PATH_TO_ADDONDIR."/tipp/lmo-tippsavewertgesamt.php");}
  if($save==3){require(PATH_TO_ADDONDIR."/tipp/lmo-tippsaveeinsicht.php");}
  
  $addu=$_SERVER['PHP_SELF']."?action=admin&amp;todo=tippuser";
  $adde=$_SERVER['PHP_SELF']."?action=admin&amp;todo=tippemail";
  $addo=$_SERVER['PHP_SELF']."?action=admin&amp;todo=tippoptions";
?>

<table class="lmosta" cellspacing="0" cellpadding="0" border="0">
  <tr>
    <td class="lmost1" align="center"><? echo $text['tipp'][63] ?></td>
  </tr>
  <tr>
    <td align="center" class="lmost3">
      <table class="lmostb" cellspacing="0" cellpadding="0" border="0">
        <tr>
          <td class="lmost4" colspan="3"><nobr><? echo $text['tipp'][64]; ?></nobr></td>
        </tr>
 <? $ftype=".l98"; $iptype="auswert"; require(PATH_TO_ADDONDIR."/tipp/lmo-tippnewdir.php"); ?>
<? if($tipp_gesamt==1){ ?>
  <tr>
      <td class="lmost5" width="20">&nbsp;</td>
      <td class="lmost5"><strong><? echo $text['tipp'][56]; ?></strong></td>
   <td class="lmost5" align="right">
    <form name="lmoedit" action="<? echo $_SERVER['PHP_SELF']; ?>" method="post">
    <input type="hidden" name="action" value="admin">
    <input type="hidden" name="todo" value="tipp">
    <input type="hidden" name="save" value="4">
    <input class="lmoadminbut" type="submit" name="best" value="<? echo $text['tipp'][236]; ?>">
    </form>
      </td>
     </tr>
<? } ?>

  <tr>
    <td class="lmost4" colspan="3"><nobr><? echo $text['tipp'][155]; ?></nobr></td>
  </tr>
 <? $ftype=".l98"; $iptype="einsicht"; require(PATH_TO_ADDONDIR."/tipp/lmo-tippnewdir.php"); ?>
  </table></td>
  <tr>
    <td><table width="100%" cellspacing="0" cellpadding="0" border="0"><tr>
<? 
  echo "<td class=\"lmost1\" align=\"center\">".$text['tipp'][63]."</td>";
if($_SESSION['lmouserok']==2){
  echo "<td class=\"lmost2\" align=\"center\"><a href='$adde' onclick=\"return chklmolink(this.href);\" title=\"".$text['tipp'][165]."\">".$text['tipp'][165]."</a></td>";
  echo "<td class=\"lmost2\" align=\"center\"><a href='$addu' onclick=\"return chklmolink(this.href);\" title=\"".$text['tipp'][114]."\">".$text['tipp'][114]."</a></td>";
  echo "<td class=\"lmost2\" align=\"center\"><a href='$addo' onclick=\"return chklmolink(this.href);\" title=\"".$text['tipp'][55]."\">".$text[86]."</a></td>";
  }
?>
    </tr></table></td>
  </tr>
</table>