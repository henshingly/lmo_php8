<?PHP
//
// Limporter Addon for LigaManager Online
// Copyright (C) 2003 by Tim Schumacher
// timme@uni.de /
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
  require_once(dirname(__FILE__).'/../../init.php');
  require_once(PATH_TO_ADDONDIR."/limporter/lim-functions.php");
  require_once(PATH_TO_ADDONDIR."/limporter/lim-classes.php");

  if(isset($vorschau)){
  	$imppage--;  // Vorschaubutton wurde gedrückt
  	$pv=1;
  }
  else $pv=0;
  if(!isset($xfile)){$xfile="";}
  if(!isset($xtitel)){$xtitel="";}
  if(!isset($xtype)){$xtype="";}
  if(!isset($ximporturl)){$ximporturl="";}
  if(!isset($ximporttype)){$ximporttype=0;}
  if(!isset($xprogram)){$xprogram=0;}
  if($imppage==0){
    if($xfile==""){$xfile="import";}
    if($xtitel==""){$xtitel="Liga Titel";}
    }
  if($imppage==1){
    if(file_exists($dirliga.$xfile.".l98")){
      echo "<font color=\"#ff0000\">".$text[280]."</font>";
      $imppage=0;
      }

    }
  if($imppage==2){


    if($xtype==0){
      if($xprogram==""){$xprogram="none";}
      }
    else{
      $xanzst=strlen(decbin($xteams-1));
      $xmodus = array_pad($array,7,"1");
      }
    }
  if($imppage==3){ // import and Save

  	if(!isset($xoffset) or $xoffset<1){$xoffset=1;}
	$offset = $xoffset - 1;
	// HTML Import
	if ($ximporttype == 0) {
        $file=$dirliga.$xfile.".l98";
        $row = 0;
        $array = array();
        $num = 0;
        $col = 0;
        $dataArray = buildFieldArray($ximporturl);
        foreach ($dataArray as $dataRow) {
            if ($row >= $offset) {
                $data = split("#",$dataRow);
                $array[] = $data;
                $num = count($data);
                if ($num>$col) $col = $num;
            }
            if ($xlrow>0 and $row > ($xlrow-2)) break;
            $row++;
        }
        for ($x=0;$x < count($array);$x++) {
            $tmp = $array[$x];
            $array[$x] = array_pad($tmp,$col,"");
        }
        $liga = new liga($xtitel,"kurz");
		$fValues = $limporter_formatValues;
		$fDelimiter = $limporter_delimiter;
		buildLigaFromCSVArray($liga,$array,$header,$cols,$fValues,$fDelimiter);
        $myOptions = new optionsSektion($liga);
        $myOptions->setKeyValue("dataSource","HTML-Import");
        $lFile = new ligafile($file,$liga,$myOptions);
        $lFile->writeFile();

	}
	// CSV Import
	else if ($ximporttype == 1) {
        $file=$dirliga.$xfile.".l98";
        $array =  buildCSVArray($ximporturl,$csvchar,$offset);
        $liga = new liga($xtitel,"kurz");
		$fValues = $limporter_formatValues;
		$fDelimiter = $limporter_delimiter;
		buildLigaFromCSVArray($liga,$array,$header,$cols,$fValues,$fDelimiter);
        $myOptions = new optionsSektion($liga);
        $myOptions->setKeyValue("dataSource","CSV-Import");
        $lFile = new ligafile($file,$liga,$myOptions);
        $lFile->writeFile();
	}
  } // end if($imppage==3)
?>

<table class="lmoMiddle" cellspacing="0" cellpadding="0" border="0">
  <tr>
    <td class="active" align="center"><?PHP echo "Neue Liga importieren";/* $text[243];*/ ?></td>
  </tr>
  <tr><td align="center"><table class="lmoInner" cellspacing="0" cellpadding="0" border="0">

<?PHP if($imppage<3){ ?>
  <form name="lmoedit" action="<?PHP echo $PHP_SELF; ?>" method="post">
  <input type="hidden" name="action" value="admin">
  <input type="hidden" name="todo" value="import">
  <input type="hidden" name="imppage" value="<?PHP echo ($imppage+1); ?>">
<?PHP if($imppage>0){ ?>
  <input type="hidden" name="xfile" value="<?PHP echo $xfile; ?>">
  <input type="hidden" name="xtitel" value="<?PHP echo $xtitel; ?>">
  <input type="hidden" name="ximporttype" value="<?PHP echo $ximporttype; ?>">
<?PHP } ?>
<?PHP if($imppage>1){ ?>
  <input type="hidden" name="ximporturl" value="<?PHP echo $ximporturl; ?>">
  <input type="hidden" name="xanzst" value="<?PHP echo $xanzst; ?>">
  <input type="hidden" name="xanzsp" value="<?PHP echo $xanzsp; ?>">
<?PHP }} ?>
  <tr>
    <td class="lmost4" colspan="3"><nobr><?PHP echo $text[246]." ".($imppage+1)." ".$text[259]." 4"; ?></nobr></td>
  </tr>

<?PHP if($imppage==0){ ?>
  <tr>
    <td class="lmost5" width="20">&nbsp;</td>
    <td class="lmost5" align="right"><nobr><acronym title="<?PHP echo $text[245]; ?>"><?PHP echo $text[244]; ?></acronym></nobr></td>
    <td class="lmost5"><nobr><acronym title="<?PHP echo $text[245]; ?>"><?PHP echo $dirliga; ?><input class="lmo-formular-input" type="text" name="xfile" size="28" maxlength="28" value="<?PHP echo $xfile; ?>" onChange="lmofilename()">.l98</acronym></nobr></td>
  </tr>
  <tr>
    <td class="lmost5" width="20">&nbsp;</td>
    <td class="lmost5" align="right"><nobr><acronym title="<?PHP echo $text[118] ?>"><?PHP echo $text[113]; ?></acronym></nobr></td>
    <td class="lmost5"><acronym title="<?PHP echo $text[118] ?>"><input class="lmo-formular-input" type="text" name="xtitel" size="40" maxlength="60" value="<?PHP echo $xtitel; ?>" onChange="lmotitelname()"></acronym></td>
  </tr>
    <tr>
    <td class="lmost5" width="20">&nbsp;</td>
    <td class="lmost5" align="right"><nobr><acronym title="<?PHP echo $text[175] ?>"><?PHP echo $text[174]; ?></acronym></nobr></td>
    <td class="lmost5" align="left"><acronym title="<?PHP echo $text[175] ?>"><select class="lmo-formular-input" name="xtype" onChange="alert('Sorry, KO Turniere werden z.Zt. noch nicht unterstützt.');this.form.xtype.value=0;dolmoedit()"><?PHP echo "<option value=\"0\""; if($xtype==0){echo " selected";} echo ">".$text[176]."</option>";
echo "<option value=\"1\""; if($xtype==1){$xtype=0;echo " selected";} echo ">".$text[177]."</option>";
      ?>
     </select></acronym></td>
  </tr>
  <tr>
    <td class="lmost4" colspan="3"><nobr><?PHP echo "Datenformat der Importquelle" ?></nobr></td>
  </tr>

<?PHP
	include(PATH_TO_ADDONDIR."/limporter/lim-typ_select.php");
 }

  if($imppage==1){
 	include(PATH_TO_ADDONDIR."/limporter/lim-file_select.php");
?>
    <tr>
    <td class="lmost5" colspan="3"><nobr>&nbsp;</nobr></td>
  </tr>
<?PHP

}

  if($imppage==2){

  	if ($ximporttype == 0) {

		include(PATH_TO_ADDONDIR."/limporter/lim-sis_settings.php");

	} // csv Import

	else if ($ximporttype == 1) {
	 	include(PATH_TO_ADDONDIR."/limporter/lim-csv_settings.php");
	}

  }
?>
<?PHP if($imppage<3){ ?>
  <tr>
    <td class="lmost4" colspan="2">
      <a href="<?PHP echo $_SERVER['PHP_SELF']; ?>" onclick="return siklmolink(this.href);" title="<?PHP echo $text[248]; ?>"><?PHP echo $text[247]; ?></a>

    </td>
<?PHP if($imppage<2){ ?>
    <td class="lmost4" align="right">
      <acronym title="<?PHP echo $text[261]; ?>"><input class="lmo-formular-button" type="submit" name="best" value="<?PHP echo $text[260]; ?>"></acronym>
    </td>
<?PHP }else{ ?>
    <td class="lmost4" align="right">
      <acronym title="<?PHP echo $text[290]; ?>"><input class="lmo-formular-button" type="submit" name="best" value="<?PHP echo $text[289]; ?>"></acronym>
    </td>
<?PHP } ?>
  </tr>
  </form>
<?PHP } ?>

<?PHP if($imppage==3){ ?>
  <tr>
    <td class="lmost5" width="20">&nbsp;</td>
    <td class="lmost5" colspan="2"><nobr>&nbsp;<br><?PHP echo $text[291]; ?><br>&nbsp;</nobr></td>
  </tr>
<?PHP include(PATH_TO_ADDONDIR."/limporter/lim-filecontent.php");?>
  <tr>
    <td class="lmost4" colspan="3" align="right"><nobr>
          <a href="<?PHP echo $_SERVER['PHP_SELF']."?action=admin&amp;todo=edit&amp;st=-1&amp;file=".$file; ?>" title="<?PHP echo $text[293]; ?>"><?PHP echo "Liga Optionen bearbeiten"; ?></a>
    </nobr></td>
  </tr>
<?PHP } ?>

  </table></td></tr>
</table>