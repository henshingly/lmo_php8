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
  if(!isset($save)){$save=0;}
  require("lmo-cssload.php");
  if($save==1){
    require("lmo-savecss.php");
    require("lmo-cssload.php");
    }
  $adde=$PHP_SELF."?action=admin&amp;todo=options";
  $addu=$PHP_SELF."?action=admin&amp;todo=user";
?>

<table class="lmosta" cellspacing="0" cellpadding="0" border="0">
  <tr>
    <td class="lmost1" align="center"><?PHP echo $text[432] ?></td>
  </tr>
  <tr><td align="center" class="lmost3"><table class="lmostb" cellspacing="0" cellpadding="0" border="0">
  <form name="lmoedit" action="<?PHP echo $PHP_SELF; ?>" method="post" onSubmit="return chklmopass()">
  <input type="hidden" name="action" value="admin">
  <input type="hidden" name="todo" value="design">
  <input type="hidden" name="save" value="1">
  <tr>
    <td class="lmost4" colspan="3"><nobr><?PHP echo $text[423]; ?></nobr></td>
  </tr>
  <tr>
    <td class="lmost5" width="20">&nbsp;</td>
    <td class="lmost5" align="right"><nobr><acronym title="<?PHP echo $text[425] ?>"><?PHP echo $text[424]; ?></acronym></nobr></td>
    <td class="lmost5"><acronym title="<?PHP echo $text[425] ?>"><input class="lmoadminein" type="text" name="xtababack" size="7" maxlength="7" value="<?PHP echo $stylearr["TABLE.lmomaina"]["background"]; ?>" onChange="dolmoedit()"></acronym>&nbsp;<acronym title="<?PHP echo $text[433] ?>"><input class="lmoadminein" type="text" name="xtabacolo" size="7" maxlength="7" value="<?PHP echo $stylearr["TD.lmomain1"]["color"]; ?>" onChange="dolmoedit()"></acronym></td>
  </tr>
  <tr>
    <td class="lmost5" width="20">&nbsp;</td>
    <td class="lmost5" align="right"><nobr><acronym title="<?PHP echo $text[427] ?>"><?PHP echo $text[426]; ?></acronym></nobr></td>
    <td class="lmost5"><acronym title="<?PHP echo $text[427] ?>"><input class="lmoadminein" type="text" name="xtababord" size="25" maxlength="25" value="<?PHP echo $stylearr["TABLE.lmomaina"]["border"]; ?>" onChange="dolmoedit()"></acronym></td>
  </tr>
  <tr>
    <td class="lmost5" width="20">&nbsp;</td>
    <td class="lmost5" align="right"><nobr><acronym title="<?PHP echo $text[429] ?>"><?PHP echo $text[428]; ?></acronym></nobr></td>
    <td class="lmost5"><acronym title="<?PHP echo $text[429] ?>"><input class="lmoadminein" type="text" name="xtabafont" size="50" maxlength="50" value="<?PHP echo $stylearr["TD.lmomain1"]["font-family"]; ?>" onChange="dolmoedit()"></acronym></td>
  </tr>
  <tr>
    <td class="lmost5" width="20">&nbsp;</td>
    <td class="lmost5" align="right"><nobr><acronym title="<?PHP echo $text[431] ?>"><?PHP echo $text[430]; ?></acronym></nobr></td>
    <td class="lmost5"><acronym title="<?PHP echo $text[431] ?>"><input class="lmoadminein" type="text" name="xtabasize" size="6" maxlength="6" value="<?PHP echo $stylearr["TD.lmomain1"]["font-size"]; ?>" onChange="dolmoedit()"></acronym>&nbsp;<acronym title="<?PHP echo $text[434] ?>"><input class="lmoadminein" type="text" name="xtabatite" size="6" maxlength="6" value="<?PHP echo $stylearr["TD.lmomain0"]["font-size"]; ?>" onChange="dolmoedit()"></acronym>&nbsp;<acronym title="<?PHP echo $text[435] ?>"><input class="lmoadminein" type="text" name="xtabaupda" size="6" maxlength="6" value="<?PHP echo $stylearr["TD.lmomain2"]["font-size"]; ?>" onChange="dolmoedit()"></acronym></td>
  </tr>
  <tr>
    <td class="lmost5" width="20">&nbsp;</td>
    <td class="lmost5" align="right"><nobr><acronym title="<?PHP echo $text[440] ?>"><?PHP echo $text[439]; ?></acronym></nobr></td>
    <td class="lmost5"><acronym title="<?PHP echo $text[440] ?>"><input class="lmoadminein" type="text" name="xtabacoti" size="7" maxlength="7" value="<?PHP echo $stylearr["TD.lmomain0"]["color"]; ?>" onChange="dolmoedit()"></acronym></td>
  </tr>
  <tr>
    <td class="lmost4" colspan="3"><nobr><?PHP echo $text[436]; ?></nobr></td>
  </tr>
  <tr>
    <td class="lmost5" width="20">&nbsp;</td>
    <td class="lmost5" align="right"><nobr><acronym title="<?PHP echo $text[425] ?>"><?PHP echo $text[424]; ?></acronym></nobr></td>
    <td class="lmost5"><acronym title="<?PHP echo $text[425] ?>"><input class="lmoadminein" type="text" name="xtabbback" size="7" maxlength="7" value="<?PHP echo $stylearr["TABLE.lmosta"]["background"]; ?>" onChange="dolmoedit()"></acronym>&nbsp;<acronym title="<?PHP echo $text[433] ?>"><input class="lmoadminein" type="text" name="xtabbcolo" size="7" maxlength="7" value="<?PHP echo $stylearr["TD.lmost1"]["color"]; ?>" onChange="dolmoedit()"></acronym></td>
  </tr>
  <tr>
    <td class="lmost5" width="20">&nbsp;</td>
    <td class="lmost5" align="right"><nobr><acronym title="<?PHP echo $text[427] ?>"><?PHP echo $text[426]; ?></acronym></nobr></td>
    <td class="lmost5"><acronym title="<?PHP echo $text[427] ?>"><input class="lmoadminein" type="text" name="xtabbbord" size="25" maxlength="25" value="<?PHP echo $stylearr["TABLE.lmosta"]["border"]; ?>" onChange="dolmoedit()"></acronym></td>
  </tr>
  <tr>
    <td class="lmost5" width="20">&nbsp;</td>
    <td class="lmost5" align="right"><nobr><acronym title="<?PHP echo $text[429] ?>"><?PHP echo $text[428]; ?></acronym></nobr></td>
    <td class="lmost5"><acronym title="<?PHP echo $text[429] ?>"><input class="lmoadminein" type="text" name="xtabbfont" size="50" maxlength="50" value="<?PHP echo $stylearr["TD.lmost1"]["font-family"]; ?>" onChange="dolmoedit()"></acronym></td>
  </tr>
  <tr>
    <td class="lmost5" width="20">&nbsp;</td>
    <td class="lmost5" align="right"><nobr><acronym title="<?PHP echo $text[438] ?>"><?PHP echo $text[437]; ?></acronym></nobr></td>
    <td class="lmost5"><acronym title="<?PHP echo $text[438] ?>"><input class="lmoadminein" type="text" name="xtabbsize" size="6" maxlength="6" value="<?PHP echo $stylearr["TD.lmost1"]["font-size"]; ?>" onChange="dolmoedit()"></acronym></td>
  </tr>
  <tr>
    <td class="lmost4" colspan="3"><nobr><?PHP echo $text[441]; ?></nobr></td>
  </tr>
  <tr>
    <td class="lmost5" width="20">&nbsp;</td>
    <td class="lmost5" align="right"><nobr><acronym title="<?PHP echo $text[425] ?>"><?PHP echo $text[442]; ?></acronym></nobr></td>
    <td class="lmost5"><acronym title="<?PHP echo $text[425] ?>"><input class="lmoadminein" type="text" name="xtabcback" size="7" maxlength="7" value="<?PHP echo $stylearr["TABLE.lmostb"]["background"]; ?>" onChange="dolmoedit()"></acronym>&nbsp;<acronym title="<?PHP echo $text[443] ?>"><input class="lmoadminein" type="text" name="xtabcgrey" size="7" maxlength="7" value="<?PHP echo $stylearr["TD.lmost4"]["background"]; ?>" onChange="dolmoedit()"></acronym>&nbsp;<acronym title="<?PHP echo $text[433] ?>"><input class="lmoadminein" type="text" name="xtabccolo" size="7" maxlength="7" value="<?PHP echo $stylearr["TD.lmost5"]["color"]; ?>" onChange="dolmoedit()"></acronym></td>
  </tr>
  <tr>
    <td class="lmost5" width="20">&nbsp;</td>
    <td class="lmost5" align="right"><nobr><acronym title="<?PHP echo $text[427] ?>"><?PHP echo $text[426]; ?></acronym></nobr></td>
    <td class="lmost5"><acronym title="<?PHP echo $text[427] ?>"><input class="lmoadminein" type="text" name="xtabcbord" size="25" maxlength="25" value="<?PHP echo $stylearr["TABLE.lmostb"]["border"]; ?>" onChange="dolmoedit()"></acronym></td>
  </tr>
  <tr>
    <td class="lmost5" width="20">&nbsp;</td>
    <td class="lmost5" align="right"><nobr><acronym title="<?PHP echo $text[429] ?>"><?PHP echo $text[428]; ?></acronym></nobr></td>
    <td class="lmost5"><acronym title="<?PHP echo $text[429] ?>"><input class="lmoadminein" type="text" name="xtabcfont" size="50" maxlength="50" value="<?PHP echo $stylearr["TD.lmost5"]["font-family"]; ?>" onChange="dolmoedit()"></acronym></td>
  </tr>
  <tr>
    <td class="lmost5" width="20">&nbsp;</td>
    <td class="lmost5" align="right"><nobr><acronym title="<?PHP echo $text[438] ?>"><?PHP echo $text[437]; ?></acronym></nobr></td>
    <td class="lmost5"><acronym title="<?PHP echo $text[438] ?>"><input class="lmoadminein" type="text" name="xtabcsize" size="6" maxlength="6" value="<?PHP echo $stylearr["TD.lmost5"]["font-size"]; ?>" onChange="dolmoedit()"></acronym></td>
  </tr>
  <tr>
    <td class="lmost5" width="20">&nbsp;</td>
    <td class="lmost5" align="right"><nobr><acronym title="<?PHP echo $text[445] ?>"><?PHP echo $text[444]; ?></acronym></nobr></td>
    <td class="lmost5"><acronym title="<?PHP echo $text[445] ?>"><input class="lmoadminein" type="text" name="xtabclin1" size="7" maxlength="7" value="<?PHP echo $stylearr["TD.lmost5 a:link"]["color"]; ?>" onChange="dolmoedit()"></acronym>&nbsp;<acronym title="<?PHP echo $text[446] ?>"><input class="lmoadminein" type="text" name="xtabclin2" size="7" maxlength="7" value="<?PHP echo $stylearr["TD.lmost5 a:hover"]["color"]; ?>" onChange="dolmoedit()"></acronym></td>
  </tr>
  <tr>
    <td class="lmost8" colspan="3"><nobr><?PHP echo $text[450]; ?></nobr></td>
  </tr>
  <tr>
    <td class="lmost5" width="20">&nbsp;</td>
    <td class="lmost5" align="right"><nobr><acronym title="<?PHP echo $text[425] ?>"><?PHP echo $text[451]; ?></acronym></nobr></td>
    <td class="lmost5"><acronym title="<?PHP echo $text[425] ?>"><input class="lmoadminein" type="text" name="xtabftab1" size="7" maxlength="7" value="<?PHP echo $stylearr["TD.lmotab1"]["background"]; ?>" onChange="dolmoedit()"></acronym></td>
  </tr>
  <tr>
    <td class="lmost5" width="20">&nbsp;</td>
    <td class="lmost5" align="right"><nobr><acronym title="<?PHP echo $text[425] ?>"><?PHP echo $text[452]; ?></acronym></nobr></td>
    <td class="lmost5"><acronym title="<?PHP echo $text[425] ?>"><input class="lmoadminein" type="text" name="xtabftab2" size="7" maxlength="7" value="<?PHP echo $stylearr["TD.lmotab2"]["background"]; ?>" onChange="dolmoedit()"></acronym></td>
  </tr>
  <tr>
    <td class="lmost5" width="20">&nbsp;</td>
    <td class="lmost5" align="right"><nobr><acronym title="<?PHP echo $text[425] ?>"><?PHP echo $text[453]; ?></acronym></nobr></td>
    <td class="lmost5"><acronym title="<?PHP echo $text[425] ?>"><input class="lmoadminein" type="text" name="xtabftab3" size="7" maxlength="7" value="<?PHP echo $stylearr["TD.lmotab3"]["background"]; ?>" onChange="dolmoedit()"></acronym></td>
  </tr>
  <tr>
    <td class="lmost5" width="20">&nbsp;</td>
    <td class="lmost5" align="right"><nobr><acronym title="<?PHP echo $text[425] ?>"><?PHP echo $text[454]; ?></acronym></nobr></td>
    <td class="lmost5"><acronym title="<?PHP echo $text[425] ?>"><input class="lmoadminein" type="text" name="xtabftab4" size="7" maxlength="7" value="<?PHP echo $stylearr["TD.lmotab4"]["background"]; ?>" onChange="dolmoedit()"></acronym></td>
  </tr>
  <tr>
    <td class="lmost5" width="20">&nbsp;</td>
    <td class="lmost5" align="right"><nobr><acronym title="<?PHP echo $text[425] ?>"><?PHP echo $text[455]; ?></acronym></nobr></td>
    <td class="lmost5"><acronym title="<?PHP echo $text[425] ?>"><input class="lmoadminein" type="text" name="xtabftab5" size="7" maxlength="7" value="<?PHP echo $stylearr["TD.lmotab8"]["background"]; ?>" onChange="dolmoedit()"></acronym></td>
  </tr>
  <tr>
    <td class="lmost5" width="20">&nbsp;</td>
    <td class="lmost5" align="right"><nobr><acronym title="<?PHP echo $text[425] ?>"><?PHP echo $text[456]; ?></acronym></nobr></td>
    <td class="lmost5"><acronym title="<?PHP echo $text[425] ?>"><input class="lmoadminein" type="text" name="xtabftab6" size="7" maxlength="7" value="<?PHP echo $stylearr["TD.lmotab5"]["background"]; ?>" onChange="dolmoedit()"></acronym></td>
  </tr>
  <tr>
    <td class="lmost5" width="20">&nbsp;</td>
    <td class="lmost5" align="right"><nobr><acronym title="<?PHP echo $text[425] ?>"><?PHP echo $text[457]; ?></acronym></nobr></td>
    <td class="lmost5"><acronym title="<?PHP echo $text[425] ?>"><input class="lmoadminein" type="text" name="xtabftab7" size="7" maxlength="7" value="<?PHP echo $stylearr["TD.lmotab6"]["background"]; ?>" onChange="dolmoedit()"></acronym></td>
  </tr>
  <tr>
    <td class="lmost5" width="20">&nbsp;</td>
    <td class="lmost5" align="right"><nobr><acronym title="<?PHP echo $text[425] ?>"><?PHP echo $text[458]; ?></acronym></nobr></td>
    <td class="lmost5"><acronym title="<?PHP echo $text[425] ?>"><input class="lmoadminein" type="text" name="xtabftab8" size="7" maxlength="7" value="<?PHP echo $stylearr["TD.lmotab7"]["background"]; ?>" onChange="dolmoedit()"></acronym></td>
  </tr>
  <tr>
    <td class="lmost8" colspan="3"><nobr><?PHP echo $text[459]; ?></nobr></td>
  </tr>
  <tr>
    <td class="lmost5" width="20">&nbsp;</td>
    <td class="lmost5" align="right"><nobr><acronym title="<?PHP echo $text[425] ?>"><?PHP echo $text[460]; ?></acronym></nobr></td>
    <td class="lmost5"><acronym title="<?PHP echo $text[425] ?>"><input class="lmoadminein" type="text" name="xtabftur1" size="7" maxlength="7" value="<?PHP echo $stylearr["TD.lmost7"]["background"]; ?>" onChange="dolmoedit()"></acronym></td>
  </tr>
  <tr>
    <td class="lmost5" width="20">&nbsp;</td>
    <td class="lmost5" align="right"><nobr><acronym title="<?PHP echo $text[425] ?>"><?PHP echo $text[461]; ?></acronym></nobr></td>
    <td class="lmost5"><acronym title="<?PHP echo $text[425] ?>"><input class="lmoadminein" type="text" name="xtabftur2" size="7" maxlength="7" value="<?PHP echo $stylearr["TD.lmost9a"]["background"]; ?>" onChange="dolmoedit()"></acronym></td>
  </tr>
  <tr>
    <td class="lmost5" width="20">&nbsp;</td>
    <td class="lmost5" align="right"><nobr><acronym title="<?PHP echo $text[425] ?>"><?PHP echo $text[462]; ?></acronym></nobr></td>
    <td class="lmost5"><acronym title="<?PHP echo $text[425] ?>"><input class="lmoadminein" type="text" name="xtabftur3" size="7" maxlength="7" value="<?PHP echo $stylearr["TD.lmost9b"]["background"]; ?>" onChange="dolmoedit()"></acronym></td>
  </tr>
  <tr>
    <td class="lmost5" width="20">&nbsp;</td>
    <td class="lmost5" align="right"><nobr><acronym title="<?PHP echo $text[425] ?>"><?PHP echo $text[463]; ?></acronym></nobr></td>
    <td class="lmost5"><acronym title="<?PHP echo $text[425] ?>"><input class="lmoadminein" type="text" name="xtabftur4" size="7" maxlength="7" value="<?PHP echo $stylearr["TD.lmost9c"]["background"]; ?>" onChange="dolmoedit()"></acronym></td>
  </tr>
  <tr>
    <td class="lmost8" colspan="3"><nobr><?PHP echo $text[464]; ?></nobr></td>
  </tr>
  <tr>
    <td class="lmost5" width="20">&nbsp;</td>
    <td class="lmost5" align="right"><nobr><acronym title="<?PHP echo $text[425] ?>"><?PHP echo $text[465]; ?></acronym></nobr></td>
    <td class="lmost5"><acronym title="<?PHP echo $text[425] ?>"><input class="lmoadminein" type="text" name="xtabhback" size="7" maxlength="7" value="<?PHP echo $stylearr["TD.lmocalht"]["background"]; ?>" onChange="dolmoedit()"></acronym></td>
  </tr>
  <tr>
    <td class="lmost5" width="20">&nbsp;</td>
    <td class="lmost5" align="right"><nobr><acronym title="<?PHP echo $text[433] ?>"><?PHP echo $text[466]; ?></acronym></nobr></td>
    <td class="lmost5"><acronym title="<?PHP echo $text[433] ?>"><input class="lmoadminein" type="text" name="xtabwcolo" size="7" maxlength="7" value="<?PHP echo $stylearr["TD.lmocalwe"]["color"]; ?>" onChange="dolmoedit()"></acronym></td>
  </tr>
  <tr>
    <td class="lmost8" colspan="3"><nobr><?PHP echo $text[447]; ?></nobr></td>
  </tr>
  <tr>
    <td class="lmost5" width="20">&nbsp;</td>
    <td class="lmost5" align="right"><nobr><acronym title="<?PHP echo $text[425] ?>"><?PHP echo $text[424]; ?></acronym></nobr></td>
    <td class="lmost5"><acronym title="<?PHP echo $text[425] ?>"><input class="lmoadminein" type="text" name="xtabtback" size="7" maxlength="7" value="<?PHP echo $stylearr["INPUT.lmotickerein"]["background"]; ?>" onChange="dolmoedit()"></acronym>&nbsp;<acronym title="<?PHP echo $text[433] ?>"><input class="lmoadminein" type="text" name="xtabtcolo" size="7" maxlength="7" value="<?PHP echo $stylearr["INPUT.lmotickerein"]["color"]; ?>" onChange="dolmoedit()"></acronym></td>
  </tr>
  <tr>
    <td class="lmost5" width="20">&nbsp;</td>
    <td class="lmost5" align="right"><nobr><acronym title="<?PHP echo $text[429] ?>"><?PHP echo $text[428]; ?></acronym></nobr></td>
    <td class="lmost5"><acronym title="<?PHP echo $text[429] ?>"><input class="lmoadminein" type="text" name="xtabtfont" size="50" maxlength="50" value="<?PHP echo $stylearr["INPUT.lmotickerein"]["font-family"]; ?>" onChange="dolmoedit()"></acronym></td>
  </tr>
  <tr>
    <td class="lmost5" width="20">&nbsp;</td>
    <td class="lmost5" align="right"><nobr><acronym title="<?PHP echo $text[438] ?>"><?PHP echo $text[437]; ?></acronym></nobr></td>
    <td class="lmost5"><acronym title="<?PHP echo $text[438] ?>"><input class="lmoadminein" type="text" name="xtabtsize" size="6" maxlength="6" value="<?PHP echo $stylearr["INPUT.lmotickerein"]["font-size"]; ?>" onChange="dolmoedit()"></acronym></td>
  </tr>
  <tr>
    <td class="lmost8" colspan="3"><nobr><?PHP echo $text[448]; ?></nobr></td>
  </tr>
  <tr>
    <td class="lmost5" width="20">&nbsp;</td>
    <td class="lmost5" align="right"><nobr><acronym title="<?PHP echo $text[425] ?>"><?PHP echo $text[424]; ?></acronym></nobr></td>
    <td class="lmost5"><acronym title="<?PHP echo $text[425] ?>"><input class="lmoadminein" type="text" name="xtabeback" size="7" maxlength="7" value="<?PHP echo $stylearr["INPUT.lmoadminein"]["background"]; ?>" onChange="dolmoedit()"></acronym>&nbsp;<acronym title="<?PHP echo $text[433] ?>"><input class="lmoadminein" type="text" name="xtabecolo" size="7" maxlength="7" value="<?PHP echo $stylearr["INPUT.lmoadminein"]["color"]; ?>" onChange="dolmoedit()"></acronym></td>
  </tr>
  <tr>
    <td class="lmost8" colspan="3"><nobr><?PHP echo $text[449]; ?></nobr></td>
  </tr>
  <tr>
    <td class="lmost5" width="20">&nbsp;</td>
    <td class="lmost5" align="right"><nobr><acronym title="<?PHP echo $text[425] ?>"><?PHP echo $text[424]; ?></acronym></nobr></td>
    <td class="lmost5"><acronym title="<?PHP echo $text[425] ?>"><input class="lmoadminein" type="text" name="xtabkback" size="7" maxlength="7" value="<?PHP echo $stylearr["INPUT.lmoadminbut"]["background"]; ?>" onChange="dolmoedit()"></acronym>&nbsp;<acronym title="<?PHP echo $text[433] ?>"><input class="lmoadminein" type="text" name="xtabkcolo" size="7" maxlength="7" value="<?PHP echo $stylearr["INPUT.lmoadminbut"]["color"]; ?>" onChange="dolmoedit()"></acronym></td>
  </tr>
  <tr><td class="lmost4" colspan="3" align="right">
      <acronym title="<?PHP echo $text[114] ?>"><input class="lmoadminbut" type="submit" name="best" value="<?PHP echo $text[188]; ?>"></acronym>
  </td></tr>
  </form>
  </table></td></tr>
  <tr>
    <td><table width="100%" cellspacing="0" cellpadding="0" border="0"><tr>
<?PHP 
  echo "<td class=\"lmost2\" align=\"center\"><a href=\"javascript:chklmolink('".$adde."');\" title=\"".$text[320]."\">".$text[319]."</a></td>";
  echo "<td class=\"lmost1\" align=\"center\">".$text[421]."</td>";
  echo "<td class=\"lmost2\" align=\"center\"><a href=\"javascript:chklmolink('".$addu."');\" title=\"".$text[318]."\">".$text[317]."</a></td>";
?>
    </tr></table></td>
  </tr>
</table>
