<?PHP
// 
// LigaManager Online 3.02b
// Copyright (C) 1997-2002 by Frank Hollwitz
// webmaster@hollwitz.de / http://php.hollwitz.de
// 
// LigaManager Online
// Edited by: Rene Marth
// 29.08.2003
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
isset($_REQUEST['show'])?$show=$_REQUEST['show']:$show=0;
if(isset($_POST['save']) && $_POST['save']==1){
  require(PATH_TO_LMO."/lmo-savecss.php");  
}
require(PATH_TO_LMO."/lmo-cssload.php");
?>
<table class="lmosta" cellspacing="0" cellpadding="0" border="0">
  <tr>
    <td class="lmost1" align="center" colspan="2"><?=$text[432] ?></td>
  </tr>
  <tr>
    <td valign="top">
      <table cellspacing="0" cellpadding="0" border="0">
        <tr><td align="right"<?if ($show==0) {?> class="lmost1"><?=$text[423]?><?}else{?> class="lmost4"><a href="<?=$_SERVER['PHP_SELF']."?action=admin&todo=design&amp;show=0";?>"><?=$text[423];?></a><?}?></td></tr>
        <tr><td align="right"<?if ($show==1) {?> class="lmost1"><?=$text[436]?><?}else{?> class="lmost4"><a href="<?=$_SERVER['PHP_SELF']."?action=admin&todo=design&amp;show=1";?>"><?=$text[436];?></a><?}?></td></tr>
        <tr><td align="right"<?if ($show==2) {?> class="lmost1"><?=$text[441]?><?}else{?> class="lmost4"><a href="<?=$_SERVER['PHP_SELF']."?action=admin&todo=design&amp;show=2";?>"><?=$text[441];?></a><?}?></td></tr>
        <tr><td align="right"<?if ($show==3) {?> class="lmost1"><?=$text[450]?><?}else{?> class="lmost4"><a href="<?=$_SERVER['PHP_SELF']."?action=admin&todo=design&amp;show=3";?>"><?=$text[450];?></a><?}?></td></tr>
        <tr><td align="right"<?if ($show==4) {?> class="lmost1"><?=$text[459]?><?}else{?> class="lmost4"><a href="<?=$_SERVER['PHP_SELF']."?action=admin&todo=design&amp;show=4";?>"><?=$text[459];?></a><?}?></td></tr>
        <tr><td align="right"<?if ($show==5) {?> class="lmost1"><?=$text[464]?><?}else{?> class="lmost4"><a href="<?=$_SERVER['PHP_SELF']."?action=admin&todo=design&amp;show=5";?>"><?=$text[464];?></a><?}?></td></tr>
        <tr><td align="right"<?if ($show==6) {?> class="lmost1"><?=$text[447]?><?}else{?> class="lmost4"><a href="<?=$_SERVER['PHP_SELF']."?action=admin&todo=design&amp;show=6";?>"><?=$text[447];?></a><?}?></td></tr>
        <tr><td align="right"<?if ($show==7) {?> class="lmost1"><?=$text[448]?><?}else{?> class="lmost4"><a href="<?=$_SERVER['PHP_SELF']."?action=admin&todo=design&amp;show=7";?>"><?=$text[448];?></a><?}?></td></tr>
        <tr><td align="right"<?if ($show==8) {?> class="lmost1"><?=$text[449]?><?}else{?> class="lmost4"><a href="<?=$_SERVER['PHP_SELF']."?action=admin&todo=design&amp;show=8";?>"><?=$text[449];?></a><?}?></td></tr>
      </table>
    </td>
    <td align="left" valign="top" class="lmost3">
      <form name="lmoedit" action="<?=$_SERVER['PHP_SELF']?>" method="post" onSubmit="return chklmopass()">
        <input type="hidden" name="action" value="admin">
        <input type="hidden" name="todo" value="design">
        <input type="hidden" name="save" value="1">
        <table class="lmostb" cellspacing="0" cellpadding="0" border="0"><?
if ($show==0) {?>          
          <tr>
            <td class="lmost5" width="20">&nbsp;</td>
            <td class="lmost5" align="right"><input class="lmoadminein" type="text" name="xtababack" size="7" maxlength="7" value="<?=$stylearr["TABLE.lmomaina"]["background"]?>" onChange="dolmoedit()">&nbsp;<input class="lmoadminein" type="text" name="xtabacolo" size="7" maxlength="7" value="<?=$stylearr["TD.lmomain1"]["color"]?>" onChange="dolmoedit()"></td>
            <td class="lmost5"><acronym title="<?=$text[425] ?>"><?=$text[424]?></acronym>,&nbsp;<acronym title="<?=$text[433] ?>"><?=$text[442]?></acronym></td>
          </tr>
          <tr>
            <td class="lmost5" width="20">&nbsp;</td>
            <td class="lmost5" align="right"><input class="lmoadminein" type="text" name="xtababord" size="25" maxlength="25" value="<?=$stylearr["TABLE.lmomaina"]["border"]?>" onChange="dolmoedit()"></td>
            <td class="lmost5"><acronym title="<?=$text[427] ?>"><?=$text[426]?></acronym></td>
          </tr>
          <tr>
            <td class="lmost5" width="20">&nbsp;</td>
            <td class="lmost5" align="right"><input class="lmoadminein" type="text" name="xtabafont" size="25" maxlength="50" value="<?=$stylearr["TD.lmomain1"]["font-family"]?>" onChange="dolmoedit()"></td>
            <td class="lmost5"><acronym title="<?=$text[429] ?>"><?=$text[428]?></acronym></td>
          </tr>
          <tr>
            <td class="lmost5" width="20">&nbsp;</td>
            <td class="lmost5" align="right"><input class="lmoadminein" type="text" name="xtabasize" size="6" maxlength="6" value="<?=$stylearr["TD.lmomain1"]["font-size"]?>" onChange="dolmoedit()">&nbsp;<input class="lmoadminein" type="text" name="xtabatite" size="6" maxlength="6" value="<?=$stylearr["TD.lmomain0"]["font-size"]?>" onChange="dolmoedit()">&nbsp;<input class="lmoadminein" type="text" name="xtabaupda" size="6" maxlength="6" value="<?=$stylearr["TD.lmomain2"]["font-size"]?>" onChange="dolmoedit()"></td>
            <td class="lmost5"><?=$text[430]?>&nbsp;<acronym title="<?=$text[431] ?>"><?=$text[500]?></acronym>,&nbsp;<acronym title="<?=$text[434] ?>"><?=$text[501]?></acronym>,&nbsp;<acronym title="<?=$text[435] ?>"><?=$text[502]?></acronym></td>
          </tr>
          <tr>
            <td class="lmost5" width="20">&nbsp;</td>
            <td class="lmost5" align="right"><input class="lmoadminein" type="text" name="xtabacoti" size="7" maxlength="7" value="<?=$stylearr["TD.lmomain0"]["color"]?>" onChange="dolmoedit()"></td>
            <td class="lmost5"><acronym title="<?=$text[440] ?>"><?=$text[439]?></acronym></td>
          </tr><?
}elseif ($show==1) {?>          
          <tr>
            <td class="lmost5" width="20">&nbsp;</td>
            <td class="lmost5" align="right"><input class="lmoadminein" type="text" name="xtabbback" size="7" maxlength="7" value="<?=$stylearr["TABLE.lmosta"]["background"]?>" onChange="dolmoedit()">&nbsp;<input class="lmoadminein" type="text" name="xtabbcolo" size="7" maxlength="7" value="<?=$stylearr["TD.lmost1"]["color"]?>" onChange="dolmoedit()"></td>
            <td class="lmost5"><acronym title="<?=$text[425] ?>"><?=$text[424]?></acronym>,&nbsp;<acronym title="<?=$text[433] ?>"><?=$text[442]?></acronym></td>
          </tr>
          <tr>
            <td class="lmost5" width="20">&nbsp;</td>
            <td class="lmost5" align="right"><input class="lmoadminein" type="text" name="xtabbbord" size="25" maxlength="25" value="<?=$stylearr["TABLE.lmosta"]["border"]?>" onChange="dolmoedit()"></td>
            <td class="lmost5"><acronym title="<?=$text[427] ?>"><?=$text[426]?></acronym></td>
          </tr>
          <tr>
            <td class="lmost5" width="20">&nbsp;</td>
            <td class="lmost5" align="right"><input class="lmoadminein" type="text" name="xtabbfont" size="25" maxlength="50" value="<?=$stylearr["TD.lmost1"]["font-family"]?>" onChange="dolmoedit()"></td>
            <td class="lmost5"><acronym title="<?=$text[429] ?>"><?=$text[428]?></acronym></td>
          </tr>
          <tr>
            <td class="lmost5" width="20">&nbsp;</td>
            <td class="lmost5" align="right"><input class="lmoadminein" type="text" name="xtabbsize" size="6" maxlength="6" value="<?=$stylearr["TD.lmost1"]["font-size"]?>" onChange="dolmoedit()"></td>
            <td class="lmost5"><acronym title="<?=$text[438] ?>"><?=$text[437]?></acronym></td>
          </tr><?
}elseif ($show==2) {?>          
          <tr>
            <td class="lmost5" width="20">&nbsp;</td>
            <td class="lmost5" align="right"><input class="lmoadminein" type="text" name="xtabcback" size="7" maxlength="7" value="<?=$stylearr["TABLE.lmostb"]["background"]?>" onChange="dolmoedit()">&nbsp;<input class="lmoadminein" type="text" name="xtabcgrey" size="7" maxlength="7" value="<?=$stylearr["TD.lmost4"]["background"]?>" onChange="dolmoedit()">&nbsp;<input class="lmoadminein" type="text" name="xtabccolo" size="7" maxlength="7" value="<?=$stylearr["TD.lmost5"]["color"]?>" onChange="dolmoedit()"></td>
            <td class="lmost5"><acronym title="<?=$text[425] ?>"><?=$text[424]?></acronym>,&nbsp;<acronym title="<?=$text[443] ?>"><?=$text[503]?></acronym>,&nbsp;<acronym title="<?=$text[433] ?>"><?=$text[442]?></acronym></td>
          </tr>
          <tr>
            <td class="lmost5" width="20">&nbsp;</td>
            <td class="lmost5" align="right"><input class="lmoadminein" type="text" name="xtabcbord" size="25" maxlength="25" value="<?=$stylearr["TABLE.lmostb"]["border"]?>" onChange="dolmoedit()"></td>
            <td class="lmost5"><acronym title="<?=$text[427] ?>"><?=$text[426]?></acronym></td>
          </tr>
          <tr>
            <td class="lmost5" width="20">&nbsp;</td>
            <td class="lmost5" align="right"><input class="lmoadminein" type="text" name="xtabcfont" size="25" maxlength="50" value="<?=$stylearr["TD.lmost5"]["font-family"]?>" onChange="dolmoedit()"></td>
            <td class="lmost5"><acronym title="<?=$text[429] ?>"><?=$text[428]?></acronym></td>
          </tr>
          <tr>
            <td class="lmost5" width="20">&nbsp;</td>
            <td class="lmost5" align="right"><input class="lmoadminein" type="text" name="xtabcsize" size="6" maxlength="6" value="<?=$stylearr["TD.lmost5"]["font-size"]?>" onChange="dolmoedit()"></td>
            <td class="lmost5"><acronym title="<?=$text[438] ?>"><?=$text[437]?></acronym></td>
          </tr>
          <tr>
            <td class="lmost5" width="20">&nbsp;</td>
            <td class="lmost5" align="right"><input class="lmoadminein" type="text" name="xtabclin1" size="7" maxlength="7" value="<?=$stylearr["TD.lmost5 a:link"]["color"]?>" onChange="dolmoedit()">&nbsp;<input class="lmoadminein" type="text" name="xtabclin2" size="7" maxlength="7" value="<?=$stylearr["TD.lmost5 a:hover"]["color"]?>" onChange="dolmoedit()"></td>
            <td class="lmost5"><acronym title="<?=$text[445] ?>"><?=$text[444]?></acronym></td>
          </tr><?
}elseif ($show==3) {?>          
          <tr>
            <td class="lmost5" width="20">&nbsp;</td>
            <td class="lmost5" align="right"><input class="lmoadminein" type="text" name="xtabftab1" size="7" maxlength="7" value="<?=$stylearr["TD.lmotab1"]["background"]?>" onChange="dolmoedit()"></td>
            <td class="lmost5"><acronym title="<?=$text[425] ?>"><?=$text[451]?></acronym></td>
          </tr>
          <tr>
            <td class="lmost5" width="20">&nbsp;</td>
            <td class="lmost5" align="right"><input class="lmoadminein" type="text" name="xtabftab2" size="7" maxlength="7" value="<?=$stylearr["TD.lmotab2"]["background"]?>" onChange="dolmoedit()"></td>
            <td class="lmost5"><acronym title="<?=$text[425] ?>"><?=$text[452]?></acronym></td>
          </tr>
          <tr>
            <td class="lmost5" width="20">&nbsp;</td>
            <td class="lmost5" align="right"><input class="lmoadminein" type="text" name="xtabftab3" size="7" maxlength="7" value="<?=$stylearr["TD.lmotab3"]["background"]?>" onChange="dolmoedit()"></td>
            <td class="lmost5"><acronym title="<?=$text[425] ?>"><?=$text[453]?></acronym></td>
          </tr>
          <tr>
            <td class="lmost5" width="20">&nbsp;</td>
            <td class="lmost5" align="right"><input class="lmoadminein" type="text" name="xtabftab4" size="7" maxlength="7" value="<?=$stylearr["TD.lmotab4"]["background"]?>" onChange="dolmoedit()"></td>
            <td class="lmost5"><acronym title="<?=$text[425] ?>"><?=$text[454]?></acronym></td>
          </tr>
          <tr>
            <td class="lmost5" width="20">&nbsp;</td>
            <td class="lmost5" align="right"><input class="lmoadminein" type="text" name="xtabftab5" size="7" maxlength="7" value="<?=$stylearr["TD.lmotab8"]["background"]?>" onChange="dolmoedit()"></td>
            <td class="lmost5"><acronym title="<?=$text[425] ?>"><?=$text[455]?></acronym></td>
          </tr>
          <tr>
            <td class="lmost5" width="20">&nbsp;</td>
            <td class="lmost5" align="right"><input class="lmoadminein" type="text" name="xtabftab6" size="7" maxlength="7" value="<?=$stylearr["TD.lmotab5"]["background"]?>" onChange="dolmoedit()"></td>
            <td class="lmost5"><acronym title="<?=$text[425] ?>"><?=$text[456]?></acronym></td>
          </tr>
          <tr>
            <td class="lmost5" width="20">&nbsp;</td>
            <td class="lmost5" align="right"><input class="lmoadminein" type="text" name="xtabftab7" size="7" maxlength="7" value="<?=$stylearr["TD.lmotab6"]["background"]?>" onChange="dolmoedit()"></td>
            <td class="lmost5"><acronym title="<?=$text[425] ?>"><?=$text[457]?></acronym></td>
          </tr>
          <tr>
            <td class="lmost5" width="20">&nbsp;</td>
            <td class="lmost5" align="right"><input class="lmoadminein" type="text" name="xtabftab8" size="7" maxlength="7" value="<?=$stylearr["TD.lmotab7"]["background"]?>" onChange="dolmoedit()"></td>
            <td class="lmost5"><acronym title="<?=$text[425] ?>"><?=$text[458]?></acronym></td>
          </tr><?
}elseif ($show==4) {?>          
          <tr>
            <td class="lmost5" width="20">&nbsp;</td>
            <td class="lmost5" align="right"><input class="lmoadminein" type="text" name="xtabftur1" size="7" maxlength="7" value="<?=$stylearr["TD.lmost7"]["background"]?>" onChange="dolmoedit()"></td>
            <td class="lmost5"><acronym title="<?=$text[425] ?>"><?=$text[460]?></acronym></td>
          </tr>
          <tr>
            <td class="lmost5" width="20">&nbsp;</td>
            <td class="lmost5" align="right"><input class="lmoadminein" type="text" name="xtabftur2" size="7" maxlength="7" value="<?=$stylearr["TD.lmost9a"]["background"]?>" onChange="dolmoedit()"></td>
            <td class="lmost5"><acronym title="<?=$text[425] ?>"><?=$text[461]?></acronym></td>
          </tr>
          <tr>
            <td class="lmost5" width="20">&nbsp;</td>
            <td class="lmost5" align="right"><input class="lmoadminein" type="text" name="xtabftur3" size="7" maxlength="7" value="<?=$stylearr["TD.lmost9b"]["background"]?>" onChange="dolmoedit()"></td>
            <td class="lmost5"><acronym title="<?=$text[425] ?>"><?=$text[462]?></acronym></td>
          </tr>
          <tr>
            <td class="lmost5" width="20">&nbsp;</td>
            <td class="lmost5" align="right"><input class="lmoadminein" type="text" name="xtabftur4" size="7" maxlength="7" value="<?=$stylearr["TD.lmost9c"]["background"]?>" onChange="dolmoedit()"></td>
            <td class="lmost5"><acronym title="<?=$text[425] ?>"><?=$text[463]?></acronym></td>
          </tr><?
}elseif ($show==5) {?>          
          <tr>
            <td class="lmost5" width="20">&nbsp;</td>
            <td class="lmost5" align="right"><input class="lmoadminein" type="text" name="xtabhback" size="7" maxlength="7" value="<?=$stylearr["TD.lmocalht"]["background"]?>" onChange="dolmoedit()"></td>
            <td class="lmost5"><acronym title="<?=$text[425] ?>"><?=$text[465]?></acronym></td>
          </tr>
          <tr>
            <td class="lmost5" width="20">&nbsp;</td>
            <td class="lmost5" align="right"><input class="lmoadminein" type="text" name="xtabwcolo" size="7" maxlength="7" value="<?=$stylearr["TD.lmocalwe"]["color"]?>" onChange="dolmoedit()"></td>
            <td class="lmost5"><acronym title="<?=$text[433] ?>"><?=$text[466]?></acronym></td>
          </tr><?
}elseif ($show==6) {?>          
          <tr>
            <td class="lmost5" width="20">&nbsp;</td>
            <td class="lmost5" align="right"><input class="lmoadminein" type="text" name="xtabtback" size="7" maxlength="7" value="<?=$stylearr["INPUT.lmotickerein"]["background"]?>" onChange="dolmoedit()">&nbsp;<input class="lmoadminein" type="text" name="xtabtcolo" size="7" maxlength="7" value="<?=$stylearr["INPUT.lmotickerein"]["color"]?>" onChange="dolmoedit()"></td>
            <td class="lmost5"><acronym title="<?=$text[425] ?>"><?=$text[424]?></acronym>,&nbsp;<acronym title="<?=$text[433] ?>"><?=$text[442]?></acronym></td>
          </tr>
          <tr>
            <td class="lmost5" width="20">&nbsp;</td>
            <td class="lmost5" align="right"><input class="lmoadminein" type="text" name="xtabtfont" size="25" maxlength="50" value="<?=$stylearr["INPUT.lmotickerein"]["font-family"]?>" onChange="dolmoedit()"></td>
            <td class="lmost5"><acronym title="<?=$text[429] ?>"><?=$text[428]?></acronym></td>
          </tr>
          <tr>
            <td class="lmost5" width="20">&nbsp;</td>
            <td class="lmost5" align="right"><input class="lmoadminein" type="text" name="xtabtsize" size="6" maxlength="6" value="<?=$stylearr["INPUT.lmotickerein"]["font-size"]?>" onChange="dolmoedit()"></td>
            <td class="lmost5"><acronym title="<?=$text[438] ?>"><?=$text[437]?></acronym></td>
          </tr><?
}elseif ($show==7) {?>          
          <tr>
            <td class="lmost5" width="20">&nbsp;</td>
            <td class="lmost5" align="right"><input class="lmoadminein" type="text" name="xtabeback" size="7" maxlength="7" value="<?=$stylearr["INPUT.lmoadminein"]["background"]?>" onChange="dolmoedit()">&nbsp;<input class="lmoadminein" type="text" name="xtabecolo" size="7" maxlength="7" value="<?=$stylearr["INPUT.lmoadminein"]["color"]?>" onChange="dolmoedit()"></td>
            <td class="lmost5"><acronym title="<?=$text[425] ?>"><?=$text[424]?></acronym>,&nbsp;<acronym title="<?=$text[433] ?>"><?=$text[442]?></acronym></td>
          </tr><?
}elseif ($show==8) {?>          
          <tr>
            <td class="lmost5" width="20">&nbsp;</td>
            <td class="lmost5" align="right"><input class="lmoadminein" type="text" name="xtabkback" size="7" maxlength="7" value="<?=$stylearr["INPUT.lmoadminbut"]["background"]?>" onChange="dolmoedit()">&nbsp;<input class="lmoadminein" type="text" name="xtabkcolo" size="7" maxlength="7" value="<?=$stylearr["INPUT.lmoadminbut"]["color"]?>" onChange="dolmoedit()"></td>
            <td class="lmost5"><acronym title="<?=$text[425] ?>"><?=$text[424]?></acronym>,&nbsp;<acronym title="<?=$text[433] ?>"><?=$text[442]?></acronym></td>
          </tr><?
}?>
          <tr>
            <td class="lmost5" colspan="3" align="center">
              <acronym title="<?=$text[114] ?>"><input class="lmoadminbut" type="submit" name="best" value="<?=$text[188]?>"></acronym>
            </td>
          </tr>
        </table>
      </form>
    </td>
  </tr>
  <tr>
    <td colspan="2">
      <table width="100%" cellspacing="0" cellpadding="0" border="0">
        <tr>
          <td class="lmost2" align="center"><a href="<?=$addr_options?>" onclick="return chklmolink('<?=$addr_options?>');" title="<?=$text[320]?>"><?=$text[319]?></a></td>
          <td class="lmost2" align="center"><a href="<?=$addr_addons?>" onclick="return chklmolink('<?=$addr_addons?>');" title="<?=$text[498]?>"><?=$text[497]?></a></td>
          <td class="lmost1" align="center"><?=$text[421]?></td>
          <td class="lmost2" align="center"><a href="<?=$addr_user?>" onclick="return chklmolink('<?=$addr_user?>');" title="<?=$text[318]?>"><?=$text[317]?></a></td>
        </tr>
      </table>
    </td>
  </tr>
</table>