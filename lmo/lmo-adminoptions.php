<?php
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
if ($save==1){

  switch ($show) {
    case 0:
      $dirliga=trim($_POST["xdirliga"]);
      if ($dirliga==""){$dirliga="./";}
      $dirliga=str_replace("\\",'/',$dirliga);                // (Falschen) Backslash -> Slash
      if (substr($dirliga,-1)!='/') $dirliga.='/';            // Slash ergänzen falls nicht vorhanden
      $ArchivDir=$dirliga.'archiv/';

      $deflang=isset($_POST["xdeflang"])?trim($_POST["xdeflang"]):$deflang;

      //Zeitformat kontrollieren
      $deftime=isset($_POST["xdeftime"])?$_POST["xdeftime"]:"15:30";
      $datum_tmp = explode(':',$deftime);
      $deftime=date("H:i", mktime($datum_tmp[0],$datum_tmp[1]));

      if (!empty($_POST["xdefdateselect"])) {
        $defdateformat=isset($_POST["xdefdateformat"])?$_POST["xdefdateformat"]:$defdateformat;
      } else {
        $defdateformat=isset($_POST["xdefdateformat2"])?$_POST["xdefdateformat2"]:$defdateformat;
      }
      $timezone=isset($_POST["xtimezone"])?$_POST["xtimezone"]:"";
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
    <td align="center"><?php echo $text[319]?></td>
    <td align="center"><a href="<?php echo $addr_addons?>" onclick="return chklmolink();" title="<?php echo $text[498]?>"><?php echo $text[497]?></a></td>
    <td align="center"><a href="<?php echo $addr_design?>" onclick="return chklmolink();" title="<?php echo $text[422]?>"><?php echo $text[421]?></a></td>
    <td align="center"><a href="<?php echo $addr_user?>" onclick="return chklmolink();" title="<?php echo $text[318]?>"><?php echo $text[317]?></a></td>
  </tr>
</table>
<table class="lmoMiddle" cellspacing="0" cellpadding="0" border="0" >
  <tr>
    <td align="center" colspan="2"><h1><?php echo $text[225]?></h1></td>
  </tr>
  <tr>
    <td valign="top">
      <table class="lmoMenu" cellspacing="0" cellpadding="0" border="0">
        <tr><td align="right"><?php if ($show==0) {echo $text[99];?><?php } else {?> <a href="<?php echo $_SERVER['PHP_SELF']."?action=admin&amp;todo=options&amp;show=0";?>"><?php echo $text[99];?></a><?php }?></td></tr>
        <tr><td align="right"><?php if ($show==1) {echo $text[226];?><?php } else {?> <a href="<?php echo $_SERVER['PHP_SELF']."?action=admin&amp;todo=options&amp;show=1";?>"><?php echo $text[226];?></a><?php }?></td></tr>
        <tr><td align="right"><?php if ($show==2) {echo $text[250];?><?php } else {?> <a href="<?php echo $_SERVER['PHP_SELF']."?action=admin&amp;todo=options&amp;show=2";?>"><?php echo $text[250];?></a><?php }?></td></tr>
      </table>
    </td>
    <td align="left" valign="top">
      <form name="lmoedit" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post" onSubmit="return chklmopass()">
        <input type="hidden" name="action" value="admin">
        <input type="hidden" name="todo" value="options">
        <input type="hidden" name="save" value="1">
        <input type="hidden" name="file" value="<?php echo $file;?>">
        <input type="hidden" name="show" value="<?php echo $show;?>">
        <table class="lmoInner" cellspacing="0" cellpadding="0" border="0"><?php
if ($show==0) {?>
          <tr>
            <td class="nobr" align="right"><acronym title="<?php echo $text[506]?>"><?php echo $text[505];?></acronym></td>
            <td class="nobr" colspan="4">
              <select class="lmo-formular-input" name="xdeflang" onchange="dolmoedit()"><?php
              $handle=opendir (PATH_TO_LANGDIR);
              while (FALSE!==($f=readdir($handle))) {
                if (preg_match("/^lang-?(.*)?\.txt$/",$f,$lang)>0) {?>
                <option<?php if ($lang[1]==$deflang) echo " selected";?>><?php echo $lang[1];?></option><?php
                }
              }
              closedir($handle);
              ?>
              </select>&nbsp;<?php echo "<img src='".URL_TO_IMGDIR.'/'.$deflang.".svg' height='16'>";?></td>
          </tr><?php
  if (version_compare(PHP_VERSION, '5.1.0') >= 0) { ?>
          <tr>
            <td class="nobr" align="right"><acronym title="<?php echo $text[575]?>"><?php echo $text[574];?></acronym></td>
            <td class="nobr" colspan="4">
              <select class="lmo-formular-input" name="xtimezone" onchange="dolmoedit()"><?php
              $timezones = get_timezones();
              foreach ($timezones as $continent=>$zones) {?>
                <optgroup label="<?php echo $continent;?>"><?php
                foreach ($zones as $zone_value=>$zone_name) {?>
                  <option value="<?php echo $zone_value;?>" <?php if ($zone_value==$timezone) echo "selected";?>><?php echo $zone_name;?></option><?php
                }
              ?></optgroup><?php
              }?>
              </select></td>
          </tr><?php
  }?>
          <tr>
            <td class="nobr" align="right"><acronym title="<?php echo $text[222]?>"><?php echo $text[221];?></acronym></td>
            <td class="nobr" colspan="4"><input class="lmo-formular-input" type="text" name="xdirliga" size="20" maxlength="80" value="<?php echo $dirliga;?>" onChange="dolmoedit()"></td>
          </tr>
          <tr>
            <td class="nobr" align="right"><acronym title="<?php echo $text[240]?>"><?php echo $text[239];?></acronym></td>
            <td class="nobr" colspan="4"><input class="lmo-formular-input" type="text" name="xdeftime" size="5" maxlength="5" value="<?php echo $deftime;?>" onChange="dolmoedit()"></td>
          </tr><tr>
            <td class="nobr" rowspan="2" align="right"><acronym title="<?php echo $text[256] ?>"><?php echo $text[257]; ?></acronym>&nbsp;</td>
            <td class="nobr" align="left">
              <input type="radio" name="xdefdateselect" value="1" checked>
              <select class="lmo-formular-input" name="xdefdateformat" onChange="dolmoedit();document.getElementsByName('xdefdateselect')[0].checked=TRUE;"><?php
      $dummf=array("d.m. H:i", "d.m.Y H:i", "D., d.m. H:i", "l, d.m. H:i", "D., d.m.Y H:i", "l, d.m.Y H:i");?>
                <option value="">__</option><?php
      for ($y=0;$y<count($dummf);$y++){?>
                <option value="<?php echo $dummf[$y]?>"<?php if ($defdateformat==$dummf[$y]){echo " selected";}?>><?php echo date($dummf[$y], time())?></option><?php
      }?>
              </select>
            </td>
          </tr>
          <tr>
            <td class="nobr" align="left">
              <input type="radio" name="xdefdateselect" value=""<?php if (!in_array($defdateformat,$dummf)) echo " checked";?>>
              <input type="text" class="lmo-formular-input" name="xdefdateformat2" onChange="dolmoedit();document.getElementsByName('xdefdateselect')[1].checked=TRUE;" value="<?php echo $defdateformat?>">
              <a href="https://www.php.net/manual/de/datetime.format.php">
                <span class="popup">
                  <strong><?php echo $text[545];?></strong><br>
                  D = <?php echo date("D", time());?><br>
                  l = <?php echo date("l", time());?><br>
                  <strong><?php echo $text[546];?></strong><br>
                  d = <?php echo date("d", time());?><br>
                  j = <?php echo date("j", time());?><br>
                  <strong><?php echo $text[547];?></strong><br>
                  m = <?php echo date("m", time());?><br>
                  M = <?php echo date("M", time());?><br>
                  F = <?php echo date("F", time());?><br>
                  <strong><?php echo $text[548];?></strong><br>
                  y = <?php echo date("y", time());?><br>
                  Y = <?php echo date("Y", time());?><br>
                  <strong><?php echo $text[549];?></strong><br>
                  H = <?php echo date("H", time());?><br>
                  i = <?php echo date("i", time());?><br>
                  A = <?php echo date("A", time());?><br>
                </span>
              ?</a>
            </td>
          </tr>
          <tr>
            <td class="nobr" align="right"><acronym title="<?php echo $text[344]?>"><?php echo $text[343];?></acronym></td>
            <td class="nobr" colspan="4"><input class="lmo-formular-input" type="text" name="xadr" size="40" maxlength="128" value="<?php echo $aadr;?>" onChange="dolmoedit()"></td>
          </tr>
          <tr>
            <td class="nobr" align="right" rowspan="2"><acronym title="<?php echo $text[532]?>"><?php echo $text[533];?></acronym></td>
            <td class="nobr" colspan="2" rowspan="2">
              <select class="lmo-formular-input" name="xliga_sort" onChange="dolmoedit()">
                <option value="liga_name"<?php if ($liga_sort=="liga_name") echo " selected";?>><?php echo $text[529]?></option>
                <option value="file_date"<?php if ($liga_sort=="file_date") echo " selected";?>><?php echo $text[530]?></option>
                <option value="file_name"<?php if ($liga_sort=="file_name") echo " selected";?>><?php echo $text[531]?></option>
              </select>
            </td>
            <td class="nobr" colspan="2"><input type="radio" name="xliga_sort_direction" onClick="dolmoedit()" value="asc"<?php if ($liga_sort_direction=="asc") echo " checked";?>> <?php echo $text[527]?></td>
          </tr>
          <tr>
            <td class="nobr" colspan="2"><input type="radio" name="xliga_sort_direction" onClick="dolmoedit()" value="desc"<?php if ($liga_sort_direction=="desc") echo " checked";?>><?php echo $text[528]?></td>
          </tr><?php
} elseif ($show==1) {?>
          <tr>
            <td class="nobr" align="right"><acronym title="<?php echo $text[228]?>"><?php echo $text[227];?></acronym></td>
            <td class="nobr" colspan="4">
              <select class="lmo-formular-input" name="xtabpkt" onChange="dolmoedit()">
                <option value="0"<?php if ($tabpkt==0){echo " selected";}?>><?php echo $text[229]?></option>
                <option value="1"<?php if ($tabpkt==1){echo " selected";}?>><?php echo $text[230]?></option>
              </select>
            </td>
          </tr>
          <tr>
            <td class="nobr" align="right"><acronym title="<?php echo $text[232]?>"><?php echo $text[231]?></acronym></td>
            <td class="nobr" colspan="4">
              <select class="lmo-formular-input" name="xtabonres" onChange="dolmoedit()">
                <option value="0"<?php if ($tabonres==0){echo " selected";}?>><?php echo $text[233]?></option>
                <option value="1"<?php if ($tabonres==1){echo " selected";}?>><?php echo $text[234]?></option>
                <option value="2"<?php if ($tabonres==2){echo " selected";}?>><?php echo $text[235]?></option>
              </select>
            </td>
          </tr><?php
} elseif ($show==2) {?>
          <tr>
            <td class="nobr" align="right"><acronym title="<?php echo $text[390]?>"><?php echo $text[389];?></acronym></td>
            <td class="nobr"><input type="checkbox" class="lmo-formular-input" name="xbacklink" onChange="dolmoedit()"<?php if ($backlink==1){echo " checked";}?>></td>
            <td class="nobr" width="15%">&nbsp;</td>
            <td class="nobr" align="right"><input type="checkbox" class="lmo-formular-input" name="xarchivlink" onChange="dolmoedit()"<?php if ($archivlink==1){echo " checked";}?>></td>
            <td class="nobr"><acronym title="<?php echo $text[510]?>"><?php echo $text[509];?></acronym></td>
          </tr>
          <tr>
            <td class="nobr" align="right"><acronym title="<?php echo $text[473]?>"><?php echo $text[472];?></acronym></td>
            <td class="nobr"><input type="checkbox" class="lmo-formular-input" name="xcalctime" onChange="dolmoedit()"<?php if ($calctime==1){echo " checked";}?>></td>
            <td>&nbsp;</td>
            <td class="nobr" align="right"><input type="checkbox" class="lmo-formular-input" name="xeinsavehtml" onChange="dolmoedit()"<?php if ($einsavehtml==1){echo " checked";}?>></td>
            <td class="nobr"><acronym title="<?php echo $text[484]?>"><?php echo $text[483];?></acronym></td>
          </tr>
          <tr>
            <?php /*<td class="nobr" align="right"><acronym title="<?php echo $text[494]?>"><?php echo $text[493];?></acronym></td>
            <td class="nobr"><input type="checkbox" class="lmo-formular-input" name="xeinhinrueck" onChange="dolmoedit()"<?php if ($einhinrueck==1){echo " checked";}?>></td>*/?>
            <td class="nobr" align="right"><acronym title="<?php echo $text[486]?>"><?php echo $text[485];?></acronym></td>
            <td class="nobr"><input type="checkbox" class="lmo-formular-input" name="xeinspieler" onChange="dolmoedit()"<?php if ($einspieler==1){echo " checked";}?>></td>
            <td>&nbsp;</td>
            <td class="nobr" align="right"><input type="checkbox" class="lmo-formular-input" name="xeinzustats" onChange="dolmoedit()"<?php if ($einzustats==1){echo " checked";}?>></td>
            <td class="nobr"><acronym title="<?php echo $text[496]?>"><?php echo $text[495];?></acronym></td>
          </tr>
          <tr>
            <td class="nobr" align="right"><acronym title="<?php echo $text[535]?>"><?php echo $text[534];?></acronym></td>
            <td class="nobr"><input type="checkbox" class="lmo-formular-input" name="xeinspielfrei" onChange="dolmoedit()"<?php if ($einspielfrei==1){echo " checked";}?>></td>
            <td>&nbsp;</td>
            <td class="nobr" align="right"><input type="checkbox" class="lmo-formular-input" name="xeintippspiel" onChange="dolmoedit()"<?php if ($eintippspiel==1){echo " checked";}?>></td>
            <td class="nobr"><acronym title="<?php echo $text[488]?>"><?php echo $text[487];?></acronym></td>
          </tr>
          <tr>
            <td colspan="3">&nbsp;</td>
            <td class="nobr" align="right"><input type="checkbox" class="lmo-formular-input" name="xeinsprachwahl" onChange="dolmoedit()"<?php if ($einsprachwahl==1){echo " checked";}?>></td>
            <td class="nobr"><acronym title="<?php echo $text[520] ?>"><?php echo $text[519]; ?></acronym></td>
          </tr>
          <tr>
            <td class="nobr" rowspan="2" align="right"><acronym title="<?php echo $text[490]?>"><?php echo $text[489];?></acronym></td>
            <td class="nobr" colspan="4"><input type="checkbox" class="lmo-formular-input" name="xeinzutoretab" onChange="dolmoedit()"<?php if ($einzutoretab==1){echo " checked";}?>>&nbsp;<?php echo $text[491]?>
          </tr>
          <tr>
            <td class="nobr" colspan="4">
              <input type="checkbox" class="lmo-formular-input" name="xeinzutore" onChange="dolmoedit()"<?php if ($einzutore==1){echo " checked";}?>>&nbsp;<?php echo $text[492]?>
            </td>
          </tr><?php
}?>
          <tr>
            <td class="nobr" colspan="6" align="center">
              <input title="<?php echo $text[114]?>" class="lmo-formular-button" type="submit" name="best" value="<?php echo $text[188];?>">
            </td>
          </tr>
        </table>
      </form>
    </td>
  </tr>
</table>