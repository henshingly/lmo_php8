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
  if($save==1){
    $dirliga=trim($HTTP_POST_VARS["xdirliga"]);
    if($dirliga==""){$dirliga="./";}
    $dummy=$dirliga;$dirliga=str_replace("\\","/",$dummy);
    if(substr($dirliga,-1)!="/"){$dirliga=$dirliga."/";}
    $tabpkt=trim($HTTP_POST_VARS["xtabpkt"]);
    $tabonres=trim($HTTP_POST_VARS["xtabonres"]);
    $backlink=trim($HTTP_POST_VARS["xbacklink"]);
    $calctime=trim($HTTP_POST_VARS["xcalctime"]);
    $deftime=trim($HTTP_POST_VARS["xdeftime"]);
    if($deftime==""){$deftime="15:30";}
    $datu2 = split("[:]",$deftime);
    $deftime=strftime("%H:%M", mktime($datu2[0],$datu2[1]));
    $aadr=trim($HTTP_POST_VARS["xadr"]);
    require("lmo-savecfg.php");
    }
  $addu=$PHP_SELF."?action=admin&amp;todo=user";
  $addf=$PHP_SELF."?action=admin&amp;todo=design";
?>

<table class="lmosta" cellspacing="0" cellpadding="0" border="0">
  <tr>
    <td class="lmost1" align="center"><?PHP echo $text[225] ?></td>
  </tr>
  <tr><td align="center" class="lmost3"><table class="lmostb" cellspacing="0" cellpadding="0" border="0">

  <form name="lmoedit" action="<?PHP echo $PHP_SELF; ?>" method="post" onSubmit="return chklmopass()">
  
  <input type="hidden" name="action" value="admin">
  <input type="hidden" name="todo" value="options">
  <input type="hidden" name="save" value="1">
  <input type="hidden" name="file" value="<?PHP echo $file; ?>">
  <tr>
    <td class="lmost4" colspan="3"><nobr><?PHP echo $text[220]; ?></nobr></td>
  </tr>
  <tr>
    <td class="lmost5" width="20">&nbsp;</td>
    <td class="lmost5" align="right"><nobr><acronym title="<?PHP echo $text[222] ?>"><?PHP echo $text[221]; ?></acronym></nobr></td>
    <td class="lmost5"><acronym title="<?PHP echo $text[222] ?>"><input class="lmoadminein" type="text" name="xdirliga" size="40" maxlength="80" value="<?PHP echo $dirliga; ?>" onChange="dolmoedit()"></acronym></td>
  </tr>
  <tr>
    <td class="lmost4" colspan="3"><nobr><?PHP echo $text[226]; ?></nobr></td>
  </tr>
  <tr>
    <td class="lmost5" width="20">&nbsp;</td>
    <td class="lmost5" align="right"><nobr><acronym title="<?PHP echo $text[228] ?>"><?PHP echo $text[227]; ?></acronym></nobr></td>
    <td class="lmost5"><acronym title="<?PHP echo $text[228] ?>">
      <select class="lmoadminein" name="xtabpkt" onChange="dolmoedit()">
      <?PHP
        echo "<option value=\"0\"";
          if($tabpkt==0){echo " selected";}
          echo ">".$text[229]."</option>";
        echo "<option value=\"1\"";
          if($tabpkt==1){echo " selected";}
          echo ">".$text[230]."</option>";
      ?>
      </select>
    </acronym></td>
  </tr>
  <tr>
    <td class="lmost5" width="20">&nbsp;</td>
    <td class="lmost5" align="right"><nobr><acronym title="<?PHP echo $text[232] ?>"><?PHP echo $text[231]; ?></acronym></nobr></td>
    <td class="lmost5"><acronym title="<?PHP echo $text[232] ?>">
      <select class="lmoadminein" name="xtabonres" onChange="dolmoedit()">
      <?PHP
        echo "<option value=\"0\"";
          if($tabonres==0){echo " selected";}
          echo ">".$text[233]."</option>";
        echo "<option value=\"1\"";
          if($tabonres==1){echo " selected";}
          echo ">".$text[234]."</option>";
        echo "<option value=\"2\"";
          if($tabonres==2){echo " selected";}
          echo ">".$text[235]."</option>";
      ?>
      </select>
    </acronym></td>
  </tr>
  <tr>
    <td class="lmost4" colspan="3"><nobr><?PHP echo $text[236]; ?></nobr></td>
  </tr>
  <tr>
    <td class="lmost5" width="20">&nbsp;</td>
    <td class="lmost5" align="right"><nobr><acronym title="<?PHP echo $text[390] ?>"><?PHP echo $text[389]; ?></acronym></nobr></td>
    <td class="lmost5"><acronym title="<?PHP echo $text[390] ?>">
      <select class="lmoadminein" name="xbacklink" onChange="dolmoedit()">
      <?PHP
        echo "<option value=\"1\"";
          if($backlink==1){echo " selected";}
          echo ">".$text[181]."</option>";
        echo "<option value=\"0\"";
          if($backlink==0){echo " selected";}
          echo ">".$text[182]."</option>";
      ?>
      </select>
    </acronym></td>
  </tr>
  <tr>
    <td class="lmost5" width="20">&nbsp;</td>
    <td class="lmost5" align="right"><nobr><acronym title="<?PHP echo $text[473] ?>"><?PHP echo $text[472]; ?></acronym></nobr></td>
    <td class="lmost5"><acronym title="<?PHP echo $text[473] ?>">
      <select class="lmoadminein" name="xcalctime" onChange="dolmoedit()">
      <?PHP
        echo "<option value=\"1\"";
          if($calctime==1){echo " selected";}
          echo ">".$text[181]."</option>";
        echo "<option value=\"0\"";
          if($calctime==0){echo " selected";}
          echo ">".$text[182]."</option>";
      ?>
      </select>
    </acronym></td>
  </tr>
  <tr>
    <td class="lmost5" width="20">&nbsp;</td>
    <td class="lmost5" align="right"><nobr><acronym title="<?PHP echo $text[240] ?>"><?PHP echo $text[239]; ?></acronym></nobr></td>
    <td class="lmost5"><acronym title="<?PHP echo $text[240] ?>"><input class="lmoadminein" type="text" name="xdeftime" size="5" maxlength="5" value="<?PHP echo $deftime; ?>" onChange="dolmoedit()"></acronym></td>
  </tr>
  <tr>
    <td class="lmost5" width="20">&nbsp;</td>
    <td class="lmost5" align="right"><nobr><acronym title="<?PHP echo $text[344] ?>"><?PHP echo $text[343]; ?></acronym></nobr></td>
    <td class="lmost5"><acronym title="<?PHP echo $text[344] ?>"><input class="lmoadminein" type="text" name="xadr" size="40" maxlength="128" value="<?PHP echo $aadr; ?>" onChange="dolmoedit()"></acronym></td>
  </tr>

  <tr><td class="lmost4" colspan="3" align="right">
      <acronym title="<?PHP echo $text[114] ?>"><input class="lmoadminbut" type="submit" name="best" value="<?PHP echo $text[188]; ?>"></acronym>
  </td></tr>
  </form>

  </table></td></tr>
  <tr>
    <td><table width="100%" cellspacing="0" cellpadding="0" border="0"><tr>
<?PHP 
  echo "<td class=\"lmost1\" align=\"center\">".$text[319]."</td>";
  echo "<td class=\"lmost2\" align=\"center\"><a href=\"javascript:chklmolink('".$addf."');\" title=\"".$text[422]."\">".$text[421]."</a></td>";
  echo "<td class=\"lmost2\" align=\"center\"><a href=\"javascript:chklmolink('".$addu."');\" title=\"".$text[318]."\">".$text[317]."</a></td>";
?>
    </tr></table></td>
  </tr>
</table>
