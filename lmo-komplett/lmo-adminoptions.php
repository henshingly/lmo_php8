<?
/** Liga Manager Online 4
  *
  * http://lmo.sourceforge.net/
  *
  * This program is free software; you can redistribute it and/or
  * modify it under the terms of the GNU General Public License as
  * published by the Free Software Foundation; either version 2 of
  * the License, or (at your option) any later version.
  * 
  * This program is distributed in the hope that it will be useful,
  * but WITHOUT ANY WARRANTY; without even the implied warranty of
  * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
  * General Public License for more details.
  *
  * REMOVING OR CHANGING THE COPYRIGHT NOTICES IS NOT ALLOWED!
  *
  */
  
  

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
      $ArchivDir=$dirliga.'archiv/';
      
      $deflang=isset($_POST["xdeflang"])?trim($_POST["xdeflang"]):$deflang;
      
      //Zeitformat kontrollieren
      $deftime=isset($_POST["xdeftime"])?$_POST["xdeftime"]:"15:30";
      $datum_tmp = explode(':',$deftime);
      $deftime=strftime("%H:%M", mktime($datum_tmp[0],$datum_tmp[1]));
      
      if (!empty($_POST["xdefdateselect"])) {
        $defdateformat=isset($_POST["xdefdateformat"])?$_POST["xdefdateformat"]:$defdateformat;
      } else {
        $defdateformat=isset($_POST["xdefdateformat2"])?$_POST["xdefdateformat2"]:$defdateformat;
      }
      $aadr=isset($_POST["xadr"])?$_POST["xadr"]:'';
      
      $liga_sort=isset($_POST["xliga_sort"])?$_POST["xliga_sort"]:'liga_name';
      $liga_sort_direction=isset($_POST["xliga_sort_direction"])?$_POST["xliga_sort_direction"]:'asc';
      
      break;
    case 1:
      $tabpkt=isset($_POST["xtabpkt"])?trim($_POST["xtabpkt"]):$tabpkt;
      $tabonres=isset($_POST["xtabonres"])?trim($_POST["xtabonres"]):$tabonres;
      break;
    case 2:
      $backlink=isset($_POST["xbacklink"])?1:0;
      $archivlink=isset($_POST["xarchivlink"])?1:0;
      $calctime=isset($_POST["xcalctime"])?1:0;
      $einsavehtml=isset($_POST["xeinsavehtml"])?1:0;
      $einsprachwahl=isset($_POST["xeinsprachwahl"])?1:0;
      $einspieler=isset($_POST["xeinspieler"])?1:0;
      $eintippspiel=isset($_POST["xeintippspiel"])?1:0;
      $einspielfrei=isset($_POST["xeinspielfrei"])?1:0;
      $einzutore=isset($_POST["xeinzutore"])?1:0;
      $einzutoretab=isset($_POST["xeinzutoretab"])?1:0;
      ///$einhinrueck=isset($_POST["xeinhinrueck"])?1:0;
      $einzustats=isset($_POST["xeinzustats"])?1:0;
      break;
  }
  require(PATH_TO_LMO."/lmo-savecfg.php");
  require(PATH_TO_LMO."/init.php");
}?>

<table width="100%" class="lmoSubmenu" cellspacing="0" cellpadding="0" border="0">
  <tr>
    <td align="center"><?=$text[319]?></td>
    <td align="center"><a href="<?=$addr_addons?>" onclick="return chklmolink();" title="<?=$text[498]?>"><?=$text[497]?></a></td>
    <td align="center"><a href="<?=$addr_design?>" onclick="return chklmolink();" title="<?=$text[422]?>"><?=$text[421]?></a></td>
    <td align="center"><a href="<?=$addr_user?>" onclick="return chklmolink();" title="<?=$text[318]?>"><?=$text[317]?></a></td>
  </tr>
</table>
<table class="lmoMiddle" cellspacing="0" cellpadding="0" border="0" >
  <tr>
    <td align="center" colspan="2"><h1><?=$text[225]?></h1></td>
  </tr>
  <tr>
    <td valign="top">
      <table class="lmoMenu" cellspacing="0" cellpadding="0" border="0">
        <tr><td align="right"><?if ($show==0) {echo $text[99];?><?}else{?> <a href="<?=$_SERVER['PHP_SELF']."?action=admin&amp;todo=options&amp;show=0";?>"><?=$text[99];?></a><?}?></td></tr>
        <tr><td align="right"><?if ($show==1) {echo $text[226];?><?}else{?> <a href="<?=$_SERVER['PHP_SELF']."?action=admin&amp;todo=options&amp;show=1";?>"><?=$text[226];?></a><?}?></td></tr>
        <tr><td align="right"><?if ($show==2) {echo $text[250];?><?}else{?> <a href="<?=$_SERVER['PHP_SELF']."?action=admin&amp;todo=options&amp;show=2";?>"><?=$text[250];?></a><?}?></td></tr>
      </table>
    </td>
    <td align="left" valign="top">
      <form name="lmoedit" action="<?=$_SERVER['PHP_SELF'];?>" method="post" onSubmit="return chklmopass()">
        <input type="hidden" name="action" value="admin">
        <input type="hidden" name="todo" value="options">
        <input type="hidden" name="save" value="1">
        <input type="hidden" name="file" value="<?=$file;?>">
        <input type="hidden" name="show" value="<?=$show;?>">
        <table class="lmoInner" cellspacing="0" cellpadding="0" border="0"><?
if ($show==0) {?>          
          <tr>
            <td class="nobr" align="right"><acronym title="<?=$text[506]?>"><?=$text[505];?></acronym></td>
            <td class="nobr" colspan="4">
              <select class="lmo-formular-input" name="xdeflang" onchange="dolmoedit()"><?
              $handle=opendir (PATH_TO_LANGDIR);
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
            <td class="nobr" align="right"><acronym title="<?=$text[222]?>"><?=$text[221];?></acronym></td>
            <td class="nobr" colspan="4"><input class="lmo-formular-input" type="text" name="xdirliga" size="20" maxlength="80" value="<?=$dirliga;?>" onChange="dolmoedit()"></td>
          </tr>
          <tr>
            <td class="nobr" align="right"><acronym title="<?=$text[240]?>"><?=$text[239];?></acronym></td>
            <td class="nobr" colspan="4"><input class="lmo-formular-input" type="text" name="xdeftime" size="5" maxlength="5" value="<?=$deftime;?>" onChange="dolmoedit()"></td>
          </tr><tr>
            <td class="nobr" rowspan="2" align="right"><acronym title="<? echo $text[256] ?>"><? echo $text[257]; ?></acronym>&nbsp;</td>
            <td class="nobr" align="left">
              <input type="radio" name="xdefdateselect" value="1" checked>
              <select class="lmo-formular-input" name="xdefdateformat" onChange="dolmoedit();document.getElementsByName('xdefdateselect')[0].checked=true;"><?
      $dummf=array("%d.%m. %H:%M","%x %H:%M","%a.%d.%m. %H:%M","%A, %d.%m. %H:%M","%a.%x %H:%M","%A, %x %H:%M");?>
                <option value="">__</option><?
      for($y=0;$y<count($dummf);$y++){?>
                <option value="<?=$dummf[$y]?>"<?if($defdateformat==$dummf[$y]){echo " selected";}?>><?=strftime($dummf[$y])?></option><?
      }?>
              </select>
            </td>
          </tr>
          <tr>
            <td class="nobr" align="left">
              <input type="radio" name="xdefdateselect" value=""<?if (!in_array($defdateformat,$dummf)) echo " checked";?>>
              <input type="text" class="lmo-formular-input" name="xdefdateformat2" onChange="dolmoedit();document.getElementsByName('xdefdateselect')[1].checked=true;" value="<?=$defdateformat?>">
              <a href="http://php.net/strftime">
                <span class="popup">
                  <strong><?=$text[545];?></strong><br>
                  %a = <?=strftime("%a")?><br>
                  %A = <?=strftime("%A")?><br>
                  <strong><?=$text[546];?></strong><br>
                  %d = <?=strftime("%d")?><br>
                  %e = <?=strftime("%e")?><br>
                  <strong><?=$text[547];?></strong><br>
                  %m = <?=strftime("%m")?><br>
                  %b = <?=strftime("%b")?><br>
                  %B = <?=strftime("%B")?><br>
                  <strong><?=$text[548];?></strong><br>
                  %y = <?=strftime("%y")?><br>
                  %Y = <?=strftime("%Y")?><br><br>
                  %x = <?=strftime("%x")?><br>
                  <strong><?=$text[549];?></strong><br>
                  %H = <?=strftime("%H")?><br>
                  %M = <?=strftime("%M")?><br>
                  %R = <?=strftime("%R")?><br>
                  %p = <?=strftime("%p")?><br>
                </span>
              ?</a>
            </td>
          </tr>
          <tr>
            <td class="nobr" align="right"><acronym title="<?=$text[344]?>"><?=$text[343];?></acronym></td>
            <td class="nobr" colspan="4"><input class="lmo-formular-input" type="text" name="xadr" size="40" maxlength="128" value="<?=$aadr;?>" onChange="dolmoedit()"></td>
          </tr>
          <tr>
            <td class="nobr" align="right" rowspan="2"><acronym title="<?=$text[532]?>"><?=$text[533];?></acronym></td>
            <td class="nobr" colspan="2" rowspan="2">
              <select class="lmo-formular-input" name="xliga_sort" onChange="dolmoedit()">
                <option value="liga_name"<?if ($liga_sort=="liga_name") echo " selected";?>><?=$text[529]?></option>
                <option value="file_date"<?if ($liga_sort=="file_date") echo " selected";?>><?=$text[530]?></option>
                <option value="file_name"<?if ($liga_sort=="file_name") echo " selected";?>><?=$text[531]?></option>
              </select>
            </td>
            <td class="nobr" colspan="2"><input type="radio" name="xliga_sort_direction" onClick="dolmoedit()" value="asc"<?if ($liga_sort_direction=="asc") echo " checked";?>> <?=$text[527]?></td>
          </tr>
          <tr>
            <td class="nobr" colspan="2"><input type="radio" name="xliga_sort_direction" onClick="dolmoedit()" value="desc"<?if ($liga_sort_direction=="desc") echo " checked";?>><?=$text[528]?></td>
          </tr><?
}elseif ($show==1) {?>          
          <tr>
            <td class="nobr" align="right"><acronym title="<?=$text[228]?>"><?=$text[227];?></acronym></td>
            <td class="nobr" colspan="4">
              <select class="lmo-formular-input" name="xtabpkt" onChange="dolmoedit()">
                <option value="0"<?if($tabpkt==0){echo " selected";}?>><?=$text[229]?></option>
                <option value="1"<?if($tabpkt==1){echo " selected";}?>><?=$text[230]?></option>
              </select>
            </td>
          </tr>
          <tr>
            <td class="nobr" align="right"><acronym title="<?=$text[232]?>"><?=$text[231]?></acronym></td>
            <td class="nobr" colspan="4">
              <select class="lmo-formular-input" name="xtabonres" onChange="dolmoedit()">
                <option value="0"<?if($tabonres==0){echo " selected";}?>><?=$text[233]?></option>
                <option value="1"<?if($tabonres==1){echo " selected";}?>><?=$text[234]?></option>
                <option value="2"<?if($tabonres==2){echo " selected";}?>><?=$text[235]?></option>
              </select>
            </td>
          </tr><?
}elseif ($show==2) {?>          
          <tr>
            <td class="nobr" align="right"><acronym title="<?=$text[390]?>"><?=$text[389];?></acronym></td>
            <td class="nobr"><input type="checkbox" class="lmo-formular-input" name="xbacklink" onChange="dolmoedit()"<?if($backlink==1){echo " checked";}?>></td>
            <td class="nobr" width="15%">&nbsp;</td>
            <td class="nobr" align="right"><input type="checkbox" class="lmo-formular-input" name="xarchivlink" onChange="dolmoedit()"<?if($archivlink==1){echo " checked";}?>></td>
            <td class="nobr"><acronym title="<?=$text[510]?>"><?=$text[509];?></acronym></td>
          </tr>
          <tr>
            <td class="nobr" align="right"><acronym title="<?=$text[473]?>"><?=$text[472];?></acronym></td>
            <td class="nobr"><input type="checkbox" class="lmo-formular-input" name="xcalctime" onChange="dolmoedit()"<?if($calctime==1){echo " checked";}?>></td>
            <td>&nbsp;</td>
            <td class="nobr" align="right"><input type="checkbox" class="lmo-formular-input" name="xeinsavehtml" onChange="dolmoedit()"<?if($einsavehtml==1){echo " checked";}?>></td>
            <td class="nobr"><acronym title="<?=$text[484]?>"><?=$text[483];?></acronym></td>
          </tr>
          <tr>
            <?/*<td class="nobr" align="right"><acronym title="<?=$text[494]?>"><?=$text[493];?></acronym></td>
            <td class="nobr"><input type="checkbox" class="lmo-formular-input" name="xeinhinrueck" onChange="dolmoedit()"<?if($einhinrueck==1){echo " checked";}?>></td>*/?>
            <td class="nobr" align="right"><acronym title="<?=$text[486]?>"><?=$text[485];?></acronym></td>
            <td class="nobr"><input type="checkbox" class="lmo-formular-input" name="xeinspieler" onChange="dolmoedit()"<?if($einspieler==1){echo " checked";}?>></td>
            <td>&nbsp;</td>
            <td class="nobr" align="right"><input type="checkbox" class="lmo-formular-input" name="xeinzustats" onChange="dolmoedit()"<?if($einzustats==1){echo " checked";}?>></td>
            <td class="nobr"><acronym title="<?=$text[496]?>"><?=$text[495];?></acronym></td>
          </tr>
          <tr>
            <td class="nobr" align="right"><acronym title="<?=$text[535]?>"><?=$text[534];?></acronym></td>
            <td class="nobr"><input type="checkbox" class="lmo-formular-input" name="xeinspielfrei" onChange="dolmoedit()"<?if($einspielfrei==1){echo " checked";}?>></td>
            <td>&nbsp;</td>
            <td class="nobr" align="right"><input type="checkbox" class="lmo-formular-input" name="xeintippspiel" onChange="dolmoedit()"<?if($eintippspiel==1){echo " checked";}?>></td>
            <td class="nobr"><acronym title="<?=$text[488]?>"><?=$text[487];?></acronym></td>
          </tr>
          <tr>
            <td colspan="3">&nbsp;</td>
            <td class="nobr" align="right"><input type="checkbox" class="lmo-formular-input" name="xeinsprachwahl" onChange="dolmoedit()"<?if($einsprachwahl==1){echo " checked";}?>></td>
            <td class="nobr"><acronym title="<? echo $text[520] ?>"><? echo $text[519]; ?></acronym></td>
          </tr>
          <tr>
            <td class="nobr" rowspan="2" align="right"><acronym title="<?=$text[490]?>"><?=$text[489];?></acronym></td>
            <td class="nobr" colspan="4"><input type="checkbox" class="lmo-formular-input" name="xeinzutoretab" onChange="dolmoedit()"<?if($einzutoretab==1){echo " checked";}?>>&nbsp;<?=$text[491]?>
          </tr>
          <tr>
            <td class="nobr" colspan="4">
              <input type="checkbox" class="lmo-formular-input" name="xeinzutore" onChange="dolmoedit()"<?if($einzutore==1){echo " checked";}?>>&nbsp;<?=$text[492]?>
            </td>
          </tr><?
}?>          
          <tr>
            <td class="nobr" colspan="6" align="center">
              <input title="<?=$text[114]?>" class="lmo-formular-button" type="submit" name="best" value="<?=$text[188];?>">
            </td>
          </tr>
        </table>
      </form>
    </td>
  </tr>
</table>