<?
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
isset($_POST['save'])?$save=$_POST['save']:$save=0;
isset($_REQUEST['show'])?$show=$_REQUEST['show']:$show=0;
if($save==1){
  
  switch ($show) {
    case 0:
      $dirliga=trim($_POST["xdirliga"]);
      if($dirliga==""){$dirliga="./";}
      $dirliga=str_replace("\\",'/',$dirliga);                // (Falschen) Backslash -> Slash
      if(substr($dirliga,-1)!='/') $dirliga.='/';            // Slash ergänzen falls nicht vorhanden
      
      $deflang=trim($_POST["xdeflang"]);
      
      //Zeitformat kontrollieren
      $deftime=trim($_POST["xdeftime"]);
      if($deftime==""){$deftime="15:30";}
      $datum_tmp = explode(':',$deftime);
      $deftime=strftime("%H:%M", mktime($datum_tmp[0],$datum_tmp[1]));
      
      $aadr=trim($_POST["xadr"]);
      
      break;
    case 1:
      $tabpkt=trim($_POST["xtabpkt"]);
      $tabonres=trim($_POST["xtabonres"]);
      break;
    case 2:
      $backlink=isset($_POST["xbacklink"])?1:0;
      $archivlink=isset($_POST["xarchivlink"])?1:0;
      $calctime=isset($_POST["xcalctime"])?1:0;
      $einsavehtml=isset($_POST["xeinsavehtml"])?1:0;
      $einspieler=isset($_POST["xeinspieler"])?1:0;
      $eintippspiel=isset($_POST["xeintippspiel"])?1:0;
      $einspielfrei=isset($_POST["xeinspielfrei"])?1:0;
      $einzutore=isset($_POST["xeinzutore"])?1:0;
      $einzutoretab=isset($_POST["xeinzutoretab"])?1:0;
      $einhinrueck=isset($_POST["xeinhinrueck"])?1:0;
      $einzustats=isset($_POST["xeinzustats"])?1:0;
      break;
  }
  require(PATH_TO_LMO."/lmo-savecfg.php");
}?>
<table class="lmosta" cellspacing="0" cellpadding="0" border="0" >
  <tr>
    <td class="lmost1" align="center" colspan="2"><?=$text[225]?></td>
  </tr>
  <tr>
    <td valign="top">
      <table cellspacing="0" cellpadding="0" border="0">
        <tr><td align="right"<?if ($show==0) {?> class="lmost1"><?=$text[99];?><?}else{?> class="lmost4"><a href="<?=$_SERVER['PHP_SELF']."?action=admin&todo=options&amp;show=0";?>"><?=$text[99];?></a><?}?></td></tr>
        <tr><td align="right"<?if ($show==1) {?> class="lmost1"><?=$text[226];?><?}else{?> class="lmost4"><a href="<?=$_SERVER['PHP_SELF']."?action=admin&todo=options&amp;show=1";?>"><?=$text[226];?></a><?}?></td></tr>
        <tr><td align="right"<?if ($show==2) {?> class="lmost1"><?=$text[250];?><?}else{?> class="lmost4"><a href="<?=$_SERVER['PHP_SELF']."?action=admin&todo=options&amp;show=2";?>"><?=$text[250];?></a><?}?></td></tr>
      </table>
    </td>
    <td align="left" valign="top" class="lmost3">
      <form name="lmoedit" action="<?=$_SERVER['PHP_SELF'];?>" method="post" onSubmit="return chklmopass()">
        <input type="hidden" name="action" value="admin">
        <input type="hidden" name="todo" value="options">
        <input type="hidden" name="save" value="1">
        <input type="hidden" name="file" value="<?=$file;?>">
        <input type="hidden" name="show" value="<?=$show;?>">
        <table class="lmostb" cellspacing="0" cellpadding="0" border="0"><?
if ($show==0) {?>          
          <tr>
            <td class="lmost5" align="right"><acronym title="<?=$text[506]?>"><?=$text[505];?></acronym></td>
            <td class="lmost5" colspan="4">
              <select class="lmoadminein" name="xdeflang" onchange="dolmoedit()"><?
              $handle=opendir ('.');
              while (false!==($f=readdir($handle))) {
                if (preg_match("/^lang-?(.*)?\.txt$/",$f,$lang)>0) {?>
                <option<?if ($lang[1]==$deflang) echo " selected";?>><?=$lang[1];?></option><?
                } 
              }
              closedir($handle); 
              ?>
              </select></td>
          </tr>
          <tr>
            <td class="lmost5" align="right"><acronym title="<?=$text[222]?>"><?=$text[221];?></acronym></td>
            <td class="lmost5" colspan="4"><input class="lmoadminein" type="text" name="xdirliga" size="20" maxlength="80" value="<?=$dirliga;?>" onChange="dolmoedit()"></td>
          </tr>
          <tr>
            <td class="lmost5" align="right"><acronym title="<?=$text[240]?>"><?=$text[239];?></acronym></td>
            <td class="lmost5" colspan="4"><input class="lmoadminein" type="text" name="xdeftime" size="5" maxlength="5" value="<?=$deftime;?>" onChange="dolmoedit()"></td>
          </tr>
          <tr>
            <td class="lmost5" align="right"><acronym title="<?=$text[344]?>"><?=$text[343];?></acronym></td>
            <td class="lmost5" colspan="4"><input class="lmoadminein" type="text" name="xadr" size="40" maxlength="128" value="<?=$aadr;?>" onChange="dolmoedit()"></td>
          </tr><?
}elseif ($show==1) {?>          
          <tr>
            <td class="lmost5" align="right"><acronym title="<?=$text[228]?>"><?=$text[227];?></acronym></td>
            <td class="lmost5" colspan="4">
              <select class="lmoadminein" name="xtabpkt" onChange="dolmoedit()">
                <option value="0"<?if($tabpkt==0){echo " selected";}?>><?=$text[229]?></option>
                <option value="1"<?if($tabpkt==1){echo " selected";}?>><?=$text[230]?></option>
              </select>
            </td>
          </tr>
          <tr>
            <td class="lmost5" align="right"><acronym title="<?=$text[232]?>"><?=$text[231]?></acronym></td>
            <td class="lmost5" colspan="4">
              <select class="lmoadminein" name="xtabonres" onChange="dolmoedit()">
                <option value="0"<?if($tabonres==0){echo " selected";}?>><?=$text[233]?></option>
                <option value="1"<?if($tabonres==1){echo " selected";}?>><?=$text[234]?></option>
                <option value="2"<?if($tabonres==2){echo " selected";}?>><?=$text[235]?></option>
              </select>
            </td>
          </tr><?
}elseif ($show==2) {?>          
          <tr>
            <td class="lmost5" align="right"><acronym title="<?=$text[390]?>"><?=$text[389];?></acronym></td>
            <td class="lmost5"><input type="checkbox" class="lmoadminein" name="xbacklink" onChange="dolmoedit()"<?if($backlink==1){echo " checked";}?>></td>
            <td class="lmost5" width="15%">&nbsp;</td>
            <td class="lmost5" align="right"><input type="checkbox" class="lmoadminein" name="xarchivlink" onChange="dolmoedit()"<?if($archivlink==1){echo " checked";}?>></td>
            <td class="lmost5"><acronym title="<?=$text[510]?>"><?=$text[509];?></acronym></td>
          </tr>
          <tr>
            <td class="lmost5" align="right"><acronym title="<?=$text[473]?>"><?=$text[472];?></acronym></td>
            <td class="lmost5"><input type="checkbox" class="lmoadminein" name="xcalctime" onChange="dolmoedit()"<?if($calctime==1){echo " checked";}?>></td>
            <td class="lmost5">&nbsp;</td>
            <td class="lmost5" align="right"><input type="checkbox" class="lmoadminein" name="xeinsavehtml" onChange="dolmoedit()"<?if($einsavehtml==1){echo " checked";}?>></td>
            <td class="lmost5"><acronym title="<?=$text[484]?>"><?=$text[483];?></acronym></td>
          </tr>
          <tr>
            <td class="lmost5" align="right"><acronym title="<?=$text[494]?>"><?=$text[493];?></acronym></td>
            <td class="lmost5"><input type="checkbox" class="lmoadminein" name="xeinhinrueck" onChange="dolmoedit()"<?if($einhinrueck==1){echo " checked";}?>></td>
            <td class="lmost5">&nbsp;</td>
            <td class="lmost5" align="right"><input type="checkbox" class="lmoadminein" name="xeinzustats" onChange="dolmoedit()"<?if($einzustats==1){echo " checked";}?>></td>
            <td class="lmost5"><acronym title="<?=$text[496]?>"><?=$text[495];?></acronym></td>
          </tr>
          <tr>
            <td class="lmost5" align="right"><acronym title="<?=$text[486]?>"><?=$text[485];?></acronym></td>
            <td class="lmost5"><input type="checkbox" class="lmoadminein" name="xeinspieler" onChange="dolmoedit()"<?if($einspieler==1){echo " checked";}?>></td>
            <td class="lmost5">&nbsp;</td>
            <td class="lmost5" align="right"><input type="checkbox" class="lmoadminein" name="xeintippspiel" onChange="dolmoedit()"<?if($eintippspiel==1){echo " checked";}?>></td>
            <td class="lmost5"><acronym title="<?=$text[488]?>"><?=$text[487];?></acronym></td>
          </tr>
          <tr>
            <td class="lmost5" rowspan="2" align="right"><acronym title="<?=$text[490]?>"><?=$text[489];?></acronym></td>
            <td class="lmost5" colspan="4"><input type="checkbox" class="lmoadminein" name="xeinzutoretab" onChange="dolmoedit()"<?if($einzutoretab==1){echo " checked";}?>>&nbsp;<?=$text[491]?>
          </tr>
          <tr>
            <td class="lmost5" colspan="4">
              <input type="checkbox" class="lmoadminein" name="xeinzutore" onChange="dolmoedit()"<?if($einzutore==1){echo " checked";}?>>&nbsp;<?=$text[492]?>
            </td>
          </tr><?
}?>          
          <tr>
            <td class="lmost5" colspan="6" align="center">
              <acronym title="<?=$text[114]?>"><input class="lmoadminbut" type="submit" name="best" value="<?=$text[188];?>"></acronym>
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
          <td class="lmost1" align="center"><?=$text[319]?></td>
          <td class="lmost2" align="center"><a href="<?=$addr_addons?>" onclick="return chklmolink('<?=$addr_addons?>');" title="<?=$text[498]?>"><?=$text[497]?></a></td>
          <td class="lmost2" align="center"><a href="<?=$addr_design?>" onclick="return chklmolink('<?=$addr_design?>');" title="<?=$text[422]?>"><?=$text[421]?></a></td>
          <td class="lmost2" align="center"><a href="<?=$addr_user?>" onclick="return chklmolink('<?=$addr_user?>');" title="<?=$text[318]?>"><?=$text[317]?></a></td>
        </tr>
      </table>
    </td>
  </tr>
</table>