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
  if(!isset($HTTP_POST_VARS['save'])){
    $save=0;
  }elseif($HTTP_POST_VARS['save']==1){
    require("lmo-savecss.php");
  }
  require("lmo-cssload.php");?>
<table class="lmosta" cellspacing="0" cellpadding="0" border="0">
  <tr>
    <td class="lmost1" align="center"><?=$text[432] ?></td>
  </tr>
  <tr>
    <td align="center" class="lmost3">
      <form name="lmoedit" action="<?=$PHP_SELF?>" method="post" onSubmit="return chklmopass()">
        <input type="hidden" name="action" value="admin">
        <input type="hidden" name="todo" value="design">
        <input type="hidden" name="save" value="1">
        <table class="lmostb" cellspacing="0" cellpadding="0" border="0">
          <tr>
            <td class="lmost4" colspan="3"><?=$text[423]?></td>
          </tr>
          <tr>
            <td class="lmost5" width="20">&nbsp;</td>
            <td class="lmost5" align="right"><acronym title="<?=$text[425] ?>"><?=$text[424]?></acronym>,&nbsp;<acronym title="<?=$text[433] ?>"><?=$text[442]?></acronym></td>
            <td class="lmost5"><input class="lmoadminein" type="text" name="xtababack" size="7" maxlength="7" value="<?=$stylearr["TABLE.lmomaina"]["background"]?>" onChange="dolmoedit()">&nbsp;<input class="lmoadminein" type="text" name="xtabacolo" size="7" maxlength="7" value="<?=$stylearr["TD.lmomain1"]["color"]?>" onChange="dolmoedit()"></td>
          </tr>
          <tr>
            <td class="lmost5" width="20">&nbsp;</td>
            <td class="lmost5" align="right"><acronym title="<?=$text[427] ?>"><?=$text[426]?></acronym></td>
            <td class="lmost5"><input class="lmoadminein" type="text" name="xtababord" size="25" maxlength="25" value="<?=$stylearr["TABLE.lmomaina"]["border"]?>" onChange="dolmoedit()"></td>
          </tr>
          <tr>
            <td class="lmost5" width="20">&nbsp;</td>
            <td class="lmost5" align="right"><acronym title="<?=$text[429] ?>"><?=$text[428]?></acronym></td>
            <td class="lmost5"><input class="lmoadminein" type="text" name="xtabafont" size="50" maxlength="50" value="<?=$stylearr["TD.lmomain1"]["font-family"]?>" onChange="dolmoedit()"></td>
          </tr>
          <tr>
            <td class="lmost5" width="20">&nbsp;</td>
            <td class="lmost5" align="right"><?=$text[430]?>&nbsp;<acronym title="<?=$text[431] ?>"><?=$text[500]?></acronym>,&nbsp;<acronym title="<?=$text[434] ?>"><?=$text[501]?></acronym>,&nbsp;<acronym title="<?=$text[435] ?>"><?=$text[502]?></acronym></td>
            <td class="lmost5"><acronym title="<?=$text[431] ?>"><input class="lmoadminein" type="text" name="xtabasize" size="6" maxlength="6" value="<?=$stylearr["TD.lmomain1"]["font-size"]?>" onChange="dolmoedit()"></acronym>&nbsp;<acronym title="<?=$text[434] ?>"><input class="lmoadminein" type="text" name="xtabatite" size="6" maxlength="6" value="<?=$stylearr["TD.lmomain0"]["font-size"]?>" onChange="dolmoedit()"></acronym>&nbsp;<acronym title="<?=$text[435] ?>"><input class="lmoadminein" type="text" name="xtabaupda" size="6" maxlength="6" value="<?=$stylearr["TD.lmomain2"]["font-size"]?>" onChange="dolmoedit()"></acronym></td>
          </tr>
  <tr>
    <td class="lmost5" width="20">&nbsp;</td>
    <td class="lmost5" align="right"><acronym title="<?=$text[440] ?>"><?=$text[439]?></acronym></td>
    <td class="lmost5"><acronym title="<?=$text[440] ?>"><input class="lmoadminein" type="text" name="xtabacoti" size="7" maxlength="7" value="<?=$stylearr["TD.lmomain0"]["color"]?>" onChange="dolmoedit()"></acronym></td>
  </tr>
  <tr>
    <td class="lmost4" colspan="3"><?=$text[436]?></td>
  </tr>
  <tr>
    <td class="lmost5" width="20">&nbsp;</td>
    <td class="lmost5" align="right"><acronym title="<?=$text[425] ?>"><?=$text[424]?></acronym></td>
    <td class="lmost5"><acronym title="<?=$text[425] ?>"><input class="lmoadminein" type="text" name="xtabbback" size="7" maxlength="7" value="<?=$stylearr["TABLE.lmosta"]["background"]?>" onChange="dolmoedit()"></acronym>&nbsp;<acronym title="<?=$text[433] ?>"><input class="lmoadminein" type="text" name="xtabbcolo" size="7" maxlength="7" value="<?=$stylearr["TD.lmost1"]["color"]?>" onChange="dolmoedit()"></acronym></td>
  </tr>
  <tr>
    <td class="lmost5" width="20">&nbsp;</td>
    <td class="lmost5" align="right"><acronym title="<?=$text[427] ?>"><?=$text[426]?></acronym></td>
    <td class="lmost5"><acronym title="<?=$text[427] ?>"><input class="lmoadminein" type="text" name="xtabbbord" size="25" maxlength="25" value="<?=$stylearr["TABLE.lmosta"]["border"]?>" onChange="dolmoedit()"></acronym></td>
  </tr>
  <tr>
    <td class="lmost5" width="20">&nbsp;</td>
    <td class="lmost5" align="right"><acronym title="<?=$text[429] ?>"><?=$text[428]?></acronym></td>
    <td class="lmost5"><acronym title="<?=$text[429] ?>"><input class="lmoadminein" type="text" name="xtabbfont" size="50" maxlength="50" value="<?=$stylearr["TD.lmost1"]["font-family"]?>" onChange="dolmoedit()"></acronym></td>
  </tr>
  <tr>
    <td class="lmost5" width="20">&nbsp;</td>
    <td class="lmost5" align="right"><acronym title="<?=$text[438] ?>"><?=$text[437]?></acronym></td>
    <td class="lmost5"><acronym title="<?=$text[438] ?>"><input class="lmoadminein" type="text" name="xtabbsize" size="6" maxlength="6" value="<?=$stylearr["TD.lmost1"]["font-size"]?>" onChange="dolmoedit()"></acronym></td>
  </tr>
  <tr>
    <td class="lmost4" colspan="3"><?=$text[441]?></td>
  </tr>
  <tr>
    <td class="lmost5" width="20">&nbsp;</td>
    <td class="lmost5" align="right"><acronym title="<?=$text[425] ?>"><?=$text[442]?></acronym></td>
    <td class="lmost5"><acronym title="<?=$text[425] ?>"><input class="lmoadminein" type="text" name="xtabcback" size="7" maxlength="7" value="<?=$stylearr["TABLE.lmostb"]["background"]?>" onChange="dolmoedit()"></acronym>&nbsp;<acronym title="<?=$text[443] ?>"><input class="lmoadminein" type="text" name="xtabcgrey" size="7" maxlength="7" value="<?=$stylearr["TD.lmost4"]["background"]?>" onChange="dolmoedit()"></acronym>&nbsp;<acronym title="<?=$text[433] ?>"><input class="lmoadminein" type="text" name="xtabccolo" size="7" maxlength="7" value="<?=$stylearr["TD.lmost5"]["color"]?>" onChange="dolmoedit()"></acronym></td>
  </tr>
  <tr>
    <td class="lmost5" width="20">&nbsp;</td>
    <td class="lmost5" align="right"><acronym title="<?=$text[427] ?>"><?=$text[426]?></acronym></td>
    <td class="lmost5"><acronym title="<?=$text[427] ?>"><input class="lmoadminein" type="text" name="xtabcbord" size="25" maxlength="25" value="<?=$stylearr["TABLE.lmostb"]["border"]?>" onChange="dolmoedit()"></acronym></td>
  </tr>
  <tr>
    <td class="lmost5" width="20">&nbsp;</td>
    <td class="lmost5" align="right"><acronym title="<?=$text[429] ?>"><?=$text[428]?></acronym></td>
    <td class="lmost5"><acronym title="<?=$text[429] ?>"><input class="lmoadminein" type="text" name="xtabcfont" size="50" maxlength="50" value="<?=$stylearr["TD.lmost5"]["font-family"]?>" onChange="dolmoedit()"></acronym></td>
  </tr>
  <tr>
    <td class="lmost5" width="20">&nbsp;</td>
    <td class="lmost5" align="right"><acronym title="<?=$text[438] ?>"><?=$text[437]?></acronym></td>
    <td class="lmost5"><acronym title="<?=$text[438] ?>"><input class="lmoadminein" type="text" name="xtabcsize" size="6" maxlength="6" value="<?=$stylearr["TD.lmost5"]["font-size"]?>" onChange="dolmoedit()"></acronym></td>
  </tr>
  <tr>
    <td class="lmost5" width="20">&nbsp;</td>
    <td class="lmost5" align="right"><acronym title="<?=$text[445] ?>"><?=$text[444]?></acronym></td>
    <td class="lmost5"><acronym title="<?=$text[445] ?>"><input class="lmoadminein" type="text" name="xtabclin1" size="7" maxlength="7" value="<?=$stylearr["TD.lmost5 a:link"]["color"]?>" onChange="dolmoedit()"></acronym>&nbsp;<acronym title="<?=$text[446] ?>"><input class="lmoadminein" type="text" name="xtabclin2" size="7" maxlength="7" value="<?=$stylearr["TD.lmost5 a:hover"]["color"]?>" onChange="dolmoedit()"></acronym></td>
  </tr>
  <tr>
    <td class="lmost8" colspan="3"><?=$text[450]?></td>
  </tr>
  <tr>
    <td class="lmost5" width="20">&nbsp;</td>
    <td class="lmost5" align="right"><acronym title="<?=$text[425] ?>"><?=$text[451]?></acronym></td>
    <td class="lmost5"><acronym title="<?=$text[425] ?>"><input class="lmoadminein" type="text" name="xtabftab1" size="7" maxlength="7" value="<?=$stylearr["TD.lmotab1"]["background"]?>" onChange="dolmoedit()"></acronym></td>
  </tr>
  <tr>
    <td class="lmost5" width="20">&nbsp;</td>
    <td class="lmost5" align="right"><acronym title="<?=$text[425] ?>"><?=$text[452]?></acronym></td>
    <td class="lmost5"><acronym title="<?=$text[425] ?>"><input class="lmoadminein" type="text" name="xtabftab2" size="7" maxlength="7" value="<?=$stylearr["TD.lmotab2"]["background"]?>" onChange="dolmoedit()"></acronym></td>
  </tr>
  <tr>
    <td class="lmost5" width="20">&nbsp;</td>
    <td class="lmost5" align="right"><acronym title="<?=$text[425] ?>"><?=$text[453]?></acronym></td>
    <td class="lmost5"><acronym title="<?=$text[425] ?>"><input class="lmoadminein" type="text" name="xtabftab3" size="7" maxlength="7" value="<?=$stylearr["TD.lmotab3"]["background"]?>" onChange="dolmoedit()"></acronym></td>
  </tr>
  <tr>
    <td class="lmost5" width="20">&nbsp;</td>
    <td class="lmost5" align="right"><acronym title="<?=$text[425] ?>"><?=$text[454]?></acronym></td>
    <td class="lmost5"><acronym title="<?=$text[425] ?>"><input class="lmoadminein" type="text" name="xtabftab4" size="7" maxlength="7" value="<?=$stylearr["TD.lmotab4"]["background"]?>" onChange="dolmoedit()"></acronym></td>
  </tr>
  <tr>
    <td class="lmost5" width="20">&nbsp;</td>
    <td class="lmost5" align="right"><acronym title="<?=$text[425] ?>"><?=$text[455]?></acronym></td>
    <td class="lmost5"><acronym title="<?=$text[425] ?>"><input class="lmoadminein" type="text" name="xtabftab5" size="7" maxlength="7" value="<?=$stylearr["TD.lmotab8"]["background"]?>" onChange="dolmoedit()"></acronym></td>
  </tr>
  <tr>
    <td class="lmost5" width="20">&nbsp;</td>
    <td class="lmost5" align="right"><acronym title="<?=$text[425] ?>"><?=$text[456]?></acronym></td>
    <td class="lmost5"><acronym title="<?=$text[425] ?>"><input class="lmoadminein" type="text" name="xtabftab6" size="7" maxlength="7" value="<?=$stylearr["TD.lmotab5"]["background"]?>" onChange="dolmoedit()"></acronym></td>
  </tr>
  <tr>
    <td class="lmost5" width="20">&nbsp;</td>
    <td class="lmost5" align="right"><acronym title="<?=$text[425] ?>"><?=$text[457]?></acronym></td>
    <td class="lmost5"><acronym title="<?=$text[425] ?>"><input class="lmoadminein" type="text" name="xtabftab7" size="7" maxlength="7" value="<?=$stylearr["TD.lmotab6"]["background"]?>" onChange="dolmoedit()"></acronym></td>
  </tr>
  <tr>
    <td class="lmost5" width="20">&nbsp;</td>
    <td class="lmost5" align="right"><acronym title="<?=$text[425] ?>"><?=$text[458]?></acronym></td>
    <td class="lmost5"><acronym title="<?=$text[425] ?>"><input class="lmoadminein" type="text" name="xtabftab8" size="7" maxlength="7" value="<?=$stylearr["TD.lmotab7"]["background"]?>" onChange="dolmoedit()"></acronym></td>
  </tr>
  <tr>
    <td class="lmost8" colspan="3"><?=$text[459]?></td>
  </tr>
  <tr>
    <td class="lmost5" width="20">&nbsp;</td>
    <td class="lmost5" align="right"><acronym title="<?=$text[425] ?>"><?=$text[460]?></acronym></td>
    <td class="lmost5"><acronym title="<?=$text[425] ?>"><input class="lmoadminein" type="text" name="xtabftur1" size="7" maxlength="7" value="<?=$stylearr["TD.lmost7"]["background"]?>" onChange="dolmoedit()"></acronym></td>
  </tr>
  <tr>
    <td class="lmost5" width="20">&nbsp;</td>
    <td class="lmost5" align="right"><acronym title="<?=$text[425] ?>"><?=$text[461]?></acronym></td>
    <td class="lmost5"><acronym title="<?=$text[425] ?>"><input class="lmoadminein" type="text" name="xtabftur2" size="7" maxlength="7" value="<?=$stylearr["TD.lmost9a"]["background"]?>" onChange="dolmoedit()"></acronym></td>
  </tr>
  <tr>
    <td class="lmost5" width="20">&nbsp;</td>
    <td class="lmost5" align="right"><acronym title="<?=$text[425] ?>"><?=$text[462]?></acronym></td>
    <td class="lmost5"><acronym title="<?=$text[425] ?>"><input class="lmoadminein" type="text" name="xtabftur3" size="7" maxlength="7" value="<?=$stylearr["TD.lmost9b"]["background"]?>" onChange="dolmoedit()"></acronym></td>
  </tr>
  <tr>
    <td class="lmost5" width="20">&nbsp;</td>
    <td class="lmost5" align="right"><acronym title="<?=$text[425] ?>"><?=$text[463]?></acronym></td>
    <td class="lmost5"><acronym title="<?=$text[425] ?>"><input class="lmoadminein" type="text" name="xtabftur4" size="7" maxlength="7" value="<?=$stylearr["TD.lmost9c"]["background"]?>" onChange="dolmoedit()"></acronym></td>
  </tr>
  <tr>
    <td class="lmost8" colspan="3"><?=$text[464]?></td>
  </tr>
  <tr>
    <td class="lmost5" width="20">&nbsp;</td>
    <td class="lmost5" align="right"><acronym title="<?=$text[425] ?>"><?=$text[465]?></acronym></td>
    <td class="lmost5"><acronym title="<?=$text[425] ?>"><input class="lmoadminein" type="text" name="xtabhback" size="7" maxlength="7" value="<?=$stylearr["TD.lmocalht"]["background"]?>" onChange="dolmoedit()"></acronym></td>
  </tr>
  <tr>
    <td class="lmost5" width="20">&nbsp;</td>
    <td class="lmost5" align="right"><acronym title="<?=$text[433] ?>"><?=$text[466]?></acronym></td>
    <td class="lmost5"><acronym title="<?=$text[433] ?>"><input class="lmoadminein" type="text" name="xtabwcolo" size="7" maxlength="7" value="<?=$stylearr["TD.lmocalwe"]["color"]?>" onChange="dolmoedit()"></acronym></td>
  </tr>
  <tr>
    <td class="lmost8" colspan="3"><?=$text[447]?></td>
  </tr>
  <tr>
    <td class="lmost5" width="20">&nbsp;</td>
    <td class="lmost5" align="right"><acronym title="<?=$text[425] ?>"><?=$text[424]?></acronym></td>
    <td class="lmost5"><acronym title="<?=$text[425] ?>"><input class="lmoadminein" type="text" name="xtabtback" size="7" maxlength="7" value="<?=$stylearr["INPUT.lmotickerein"]["background"]?>" onChange="dolmoedit()"></acronym>&nbsp;<acronym title="<?=$text[433] ?>"><input class="lmoadminein" type="text" name="xtabtcolo" size="7" maxlength="7" value="<?=$stylearr["INPUT.lmotickerein"]["color"]?>" onChange="dolmoedit()"></acronym></td>
  </tr>
  <tr>
    <td class="lmost5" width="20">&nbsp;</td>
    <td class="lmost5" align="right"><acronym title="<?=$text[429] ?>"><?=$text[428]?></acronym></td>
    <td class="lmost5"><acronym title="<?=$text[429] ?>"><input class="lmoadminein" type="text" name="xtabtfont" size="50" maxlength="50" value="<?=$stylearr["INPUT.lmotickerein"]["font-family"]?>" onChange="dolmoedit()"></acronym></td>
  </tr>
  <tr>
    <td class="lmost5" width="20">&nbsp;</td>
    <td class="lmost5" align="right"><acronym title="<?=$text[438] ?>"><?=$text[437]?></acronym></td>
    <td class="lmost5"><acronym title="<?=$text[438] ?>"><input class="lmoadminein" type="text" name="xtabtsize" size="6" maxlength="6" value="<?=$stylearr["INPUT.lmotickerein"]["font-size"]?>" onChange="dolmoedit()"></acronym></td>
  </tr>
  <tr>
    <td class="lmost8" colspan="3"><?=$text[448]?></td>
  </tr>
  <tr>
    <td class="lmost5" width="20">&nbsp;</td>
    <td class="lmost5" align="right"><acronym title="<?=$text[425] ?>"><?=$text[424]?></acronym></td>
    <td class="lmost5"><acronym title="<?=$text[425] ?>"><input class="lmoadminein" type="text" name="xtabeback" size="7" maxlength="7" value="<?=$stylearr["INPUT.lmoadminein"]["background"]?>" onChange="dolmoedit()"></acronym>&nbsp;<acronym title="<?=$text[433] ?>"><input class="lmoadminein" type="text" name="xtabecolo" size="7" maxlength="7" value="<?=$stylearr["INPUT.lmoadminein"]["color"]?>" onChange="dolmoedit()"></acronym></td>
  </tr>
  <tr>
    <td class="lmost8" colspan="3"><?=$text[449]?></td>
  </tr>
  <tr>
    <td class="lmost5" width="20">&nbsp;</td>
    <td class="lmost5" align="right"><acronym title="<?=$text[425] ?>"><?=$text[424]?></acronym></td>
    <td class="lmost5"><acronym title="<?=$text[425] ?>"><input class="lmoadminein" type="text" name="xtabkback" size="7" maxlength="7" value="<?=$stylearr["INPUT.lmoadminbut"]["background"]?>" onChange="dolmoedit()"></acronym>&nbsp;<acronym title="<?=$text[433] ?>"><input class="lmoadminein" type="text" name="xtabkcolo" size="7" maxlength="7" value="<?=$stylearr["INPUT.lmoadminbut"]["color"]?>" onChange="dolmoedit()"></acronym></td>
  </tr>
  <tr><td class="lmost4" colspan="3" align="right">
      <acronym title="<?=$text[114] ?>"><input class="lmoadminbut" type="submit" name="best" value="<?=$text[188]?>"></acronym>
  </td></tr>
  </form>
  </table></td></tr>
  <tr>
    <td>
      <table width="100%" cellspacing="0" cellpadding="0" border="0">
        <tr>
          <td class="lmost2" align="center"><a href="<?=$addr_options?>" onclick="return chklmolink('<?=$addr_options?>');" title="<?=$text[320]?>"><?=$text[319]?></a></td>
          <td class="lmost2" align="center"><a href="<?=$addr_addons?>" onclick="return chklmolink('<?=$addr_addons?>');" title="<?=$text[498]?>"><?=$text[497]?></a></td>
          <td class="lmost2" align="center"><?=$text[421]?></td>
          <td class="lmost2" align="center"><a href="<?=$addr_user?>" onclick="return chklmolink('<?=$addr_user?>');" title="<?=$text[318]?>"><?=$text[317]?></a></td>
        </tr>
      </table>
    </td>
  </tr></table></td>
  </tr>
</table>