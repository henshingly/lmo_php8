<?
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
  require_once(PATH_TO_ADDONDIR.'/limporter/lim_ini.php');
  require_once(PATH_TO_ADDONDIR.'/limporter/lim-functions.php');
  require_once(PATH_TO_ADDONDIR.'/limporter/lim-classes.php');
  require_once(PATH_TO_ADDONDIR.'/limporter/classes/ini/cIniFileReader.inc');

/*
	if (isset($HTTP_POST_VARS)) {
		reset ($HTTP_POST_VARS);
   	foreach ($HTTP_POST_VARS as $k=>$v) {
	 		echo "<BR>$k = $v";
		}
	}
*/
  if(isset($vorschau)){
  	$imppage--;  // Vorschaubutton wurde gedrückt
  	$pv=1;
  }
  else $pv=0;
  if(!isset($xfile)){$xfile="";}
  if(!isset($xtitel)){$xtitel="";}
  if(!isset($xtype)){$xtype="";}
  if(!isset($ximporturl)){$ximporturl="";}
  if(!isset($ximportFile)){$ximportFile="";}
  if(!isset($ximporttype)){$ximporttype=0;}
  if(!isset($xprogram)){$xprogram=0;}
  if(!isset($xparserFile)){$xparserFile="";}
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

    if(!isset($cols)){
    	$cols = $lim_colums;
	 	}

		if(isset($xparserFile) and $xparserFile<>'') {
			$ini = new IniFileReader(PATH_TO_ADDONDIR."/limporter/".$limporter_importDir."/".$xparserFile);
			$header = $ini->getIniFile('LIMPORTER','ISHEADER',0);
			$xdetailsCheck = $ini->getIniFile('LIMPORTER','DETAILS',0);
			$xoffset = $ini->getIniFile('LIMPORTER','FIRSTROW',1) + $header;
			$xlrow = $ini->getIniFile('LIMPORTER','LASTROW','');

			foreach (array_keys($cols) as $key) {
				$cols[$key][0] = $ini->getIniFile('LIMPORTER',$key.'_COLUMN',-1);
				$cols[$key][1] = $ini->getIniFile('LIMPORTER',$key.'_FORMAT',0);
			}
			$xparserFile = '';
		}

    // Aus Performacegründen wird eine lokale Kopie der Importquelle erstellt

    $fileContent = getFileContent($ximporturl);
    if ($ximporttype == 0) $fileName="importsrc.htm";
    else $fileName="importsrc.csv";

    if ($fileContent == "") {
      echo "<font color=\"#ff0000\">Seite konnte nicht gefunden werden</font>";
      $imppage=1;
    }
    else {
      $file = fopen(PATH_TO_ADDONDIR."/limporter/".$limporter_importDir."/".$fileName,'w+');
      if ($file) {
        if(fwrite($file,$fileContent)) {
          $ximportFile = $fileName;
        }
        else {
          echo "<font color=\"#ff0000\">Kann temporäre Datei nicht erstellen.<BR>Schreibrechte in ".$limporter_importDir." prüfen!</font>";
          $imppage=1;
        }
        fclose($file);
      }
      else {
          echo "<font color=\"#ff0000\">Kann temporäre Datei nicht öffnen.<BR>Schreibrechte in ".$limporter_importDir." prüfen!</font>";
        $imppage=1;
      }
    }
  }
  if($imppage==3){ // import and Save

  	if(!isset($xdetailsCheck)){$xdetailsCheck=0;}
  	if(!isset($header)){$header=0;}
  	if(!isset($xoffset) or $xoffset<1){$xoffset=1;}
    $offset = $xoffset - 1;
    $src = PATH_TO_ADDONDIR."/limporter/".$limporter_importDir."/".$ximportFile;
    // HTML Import
    $file=$dirliga.$xfile.".l98";
    $limFile =  PATH_TO_ADDONDIR."/limporter/".$limporter_importDir."/".$xfile.".lim";
    if ($ximporttype == 0) {
      $row = 0;
      $array = array();
      $num = 0;
      $col = 0;
      $dataArray = buildFieldArray($src,$xdetailsCheck);//$ximportFile
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
      buildLigaFromDataArray($liga,$array,$header,$cols,$lim_format_exp);
      // Importparameter speichern
      $limSettings = new Sektion('LIMPORTER');
      $limSettings->setKeyValue("VERSION",LIM_VERSION);
      $limSettings->setKeyValue("TITLE",$liga->name);
      $limSettings->setKeyValue("IMPORTTYP","HTML");
      $limSettings->setKeyValue("URL",$ximporturl);
      $limSettings->setKeyValue("DETAILS",$xdetailsCheck);
      $limSettings->setKeyValue("FIRSTROW",$offset);
      $limSettings->setKeyValue("LASTROW",$xlrow);
      $limSettings->setKeyValue("ISHEADER",$header);

      foreach($cols as $colum=>$value) {
      	$limSettings->setKeyValue($colum."_COLUMN",$value[0]);
        $limSettings->setKeyValue($colum."_FORMAT",$value[1]);
      }
  		writeLimSettings($limFile,$limSettings);
      $myOptions = new optionsSektion($liga);
      $liga->options=&$myOptions;
      $liga->writeFile($file);
    }
    // CSV Import
    else if ($ximporttype == 1) {
      $array =  buildCSVArray($src,$csvchar,$offset);//$ximportFile
      $liga = new liga($xtitel,"kurz");
      buildLigaFromDataArray($liga,$array,$header,$cols,$lim_format_exp);

  		// Importparameter speichern
  		$limSettings = new Sektion('LIMPORTER');
      $limSettings->setKeyValue("VERSION",LIM_VERSION);
      $limSettings->setKeyValue("TITLE",$liga->name);
      $limSettings->setKeyValue("IMPORTTYP","CSV");
      $limSettings->setKeyValue("URL",$ximporturl);
      $limSettings->setKeyValue("DETAILS",$xdetailsCheck);
      $limSettings->setKeyValue("FIRSTROW",$offset);
      $limSettings->setKeyValue("LASTROW",$xlrow);
      $limSettings->setKeyValue("ISHEADER",$header);

      foreach($cols as $colum=>$value) {
      	$limSettings->setKeyValue($colum."_COLUMN",$value[0]);
        $limSettings->setKeyValue($colum."_FORMAT",$value[1]);
      }
  		writeLimSettings($limFile,$limSettings);

      $myOptions = new optionsSektion($liga);
      $liga->options=&$myOptions;
      $liga->writeFile($file);
    }
  } // end if($imppage==3)
?>

<? include(PATH_TO_ADDONDIR."/limporter/lim-javascript.php");?>


<table class="lmoMiddle" cellspacing="0" cellpadding="0" border="0">
  <tr>
    <td align="center"><h1><? echo "Neue Liga importieren";/* $text[243];*/ ?></h1></td>
  </tr>
  <tr><td align="center" class="lmost3">

<? if($imppage<1){ ?>
  <form onSubmit="return checkHinweis();" name="lmoedit" action="<? echo $PHP_SELF; ?>" method="post">
<? }
	else if ($imppage<3){ ?>
  <form  onSubmit="return checkSettings();" name="lmoedit" action="<? echo $PHP_SELF; ?>" method="post">
<? }	?>

<? if($imppage<3){ ?>
  <input type="hidden" name="action" value="admin">
  <input type="hidden" name="todo" value="import">
  <input type="hidden" name="imppage" value="<? echo ($imppage+1); ?>">
<? if($imppage>0){ ?>
  <input type="hidden" name="xfile" value="<? echo $xfile; ?>">
  <input type="hidden" name="xtitel" value="<? echo $xtitel; ?>">
  <input type="hidden" name="ximporttype" value="<? echo $ximporttype; ?>">
<? } ?>
<? if($imppage>1){ ?>
  <input type="hidden" name="ximporturl" value="<? echo $ximporturl; ?>">
  <input type="hidden" name="ximportFile" value="<? echo $ximportFile; ?>">
<? }} ?>
  <table class="lmoInner" cellspacing="0" cellpadding="0" border="0">
  <tr>
    <td class="lmost4" colspan="3"><nobr><? echo $text[246]." ".($imppage+1)." ".$text[259]." 4"; ?></nobr></td>
  </tr>

<? if($imppage==0){ ?>

  <tr>
    <td class="lmost5" width="20">&nbsp;</td>
    <td class="lmost5" colspan=2 align="left"><B>Bitte beachten Sie folgende Hinweise:</B>
	  	<table class="lmoInner" cellspacing="3" cellpadding="0" border="0">
	  		<tr>
    			<td class="lmost5" width=350>
    			 <div>Die Verwendung dieses Addons ist ausschließlich für den privaten Gebrauch gestattet. Ligen, die mit diesem Modul erstellt worden sind, dürfen <strong>nicht</strong> für kommerzielle Zwecke jeglicher Form verwendet werden !</div>
    			Die Inhalte der importierten Dokumente sind möglicherweise urheberrechtlich geschützt. Bitte vergewissern Sie sich, ob die Verwendung der Daten für den privaten Gebrauch gestattet ist. Dieses Modul wurde nur für Schulungszwecken entwickelt, der Autor lehnt jegliche Haftung bei Missbrauch ab.
		    	</td>
		    </tr>
		  </table>
  </tr>
  <tr>
    <td class="lmost5" width="20">&nbsp;</td>
    <td class="lmost5" colspan="2" align="left"><input class="lmo-formular-input" type="checkbox" name="hw"> Nutzungsbedingungen akzeptieren</td>
  </tr>
  <tr>
    <td class="lmost5" width="20">&nbsp;</td>
    <td>&nbsp</td>
&nbsp;</td>
    <td class="lmost5" align="left">&nbsp;</td>
  </tr>
  <tr>
    <td class="lmost5" width="20">&nbsp;</td>
    <td class="lmost5" colspan="2"><nobr><? echo "Allgemeine Ligainformationen" ?></nobr></td>
  </tr>
  <tr>
    <td class="lmost5" width="20">&nbsp;</td>
    <td align="right">
<nobr><acronym title="<? echo $text[245]; ?>"><? echo $text[244]; ?></acronym></nobr></td>
    <td class="lmost5" align="left"><nobr><acronym title="<? echo $text[245]; ?>"><? echo $dirliga; ?><input class="lmo-formular-input" type="text" name="xfile" size="28" maxlength="28" value="<? echo $xfile; ?>" onChange="lmofilename()">.l98</acronym></nobr></td>
  </tr>
  <tr>
    <td class="lmost5" width="20">&nbsp;</td>
    <td align="right">
<nobr><acronym title="<? echo $text[118] ?>"><? echo $text[113]; ?></acronym></nobr></td>
    <td>&nbsp</td>
<acronym title="<? echo $text[118] ?>"><input class="lmo-formular-input" type="text" name="xtitel" size="40" maxlength="60" value="<? echo $xtitel; ?>" onChange="lmotitelname()"></acronym></td>
  </tr>
    <tr>
    <td class="lmost5" width="20">&nbsp;</td>
    <td align="right">
<nobr><acronym title="<? echo $text[175] ?>"><? echo $text[174]; ?></acronym></nobr></td>
    <td class="lmost5" align="left"><acronym title="<? echo $text[175] ?>"><select class="lmo-formular-input" name="xtype" onChange="alert('Sorry, KO Turniere werden z.Zt. noch nicht unterstützt.');this.form.xtype.value=0;dolmoedit()"><? echo "<option value=\"0\""; if($xtype==0){echo " selected";} echo ">".$text[176]."</option>";
echo "<option value=\"1\""; if($xtype==1){$xtype=0;echo " selected";} echo ">".$text[177]."</option>";
      ?>
     </select></acronym></td>
  </tr>

<?
	include(PATH_TO_ADDONDIR."/limporter/lim-typ_select.php");
 }

  if($imppage==1){
 		include(PATH_TO_ADDONDIR."/limporter/lim-file_select.php");
?>
    <tr>
    <td class="lmost5" colspan="3"><nobr>&nbsp;</nobr></td>
  </tr>
<?
}
  if($imppage==2){
  	if ($ximporttype == 0) {
			include(PATH_TO_ADDONDIR."/limporter/lim-htm_settings.php");
		} // csv Import
		else if ($ximporttype == 1) {
	 		include(PATH_TO_ADDONDIR."/limporter/lim-csv_settings.php");
		}
  }
?>
  <tr>
    <td class="lmost5" colspan="3" align="center"><? echo LIM_VERSIONS ; ?></td>
  </tr>

<? if($imppage<3){ ?>
  <tr>
    <td class="lmost4" colspan="2">
      <a href="<? echo $_SERVER['PHP_SELF']; ?>" onclick="return siklmolink(this.href);" title="<? echo $text[248]; ?>"><? echo $text[247]; ?></a>

    </td>
<? if($imppage<2){ ?>
    <td class="lmost4" align="right">
      <acronym title="<? echo $text[261]; ?>"><input class="lmo-formular-button" type="submit" name="best" value="<? echo $text[260]; ?>"></acronym>
    </td>
<? }else{ ?>
    <td class="lmost4" align="right">
      <acronym title="<? echo $text[290]; ?>"><input onClick="nextButtonClicked=1;"  class="lmo-formular-button" type="submit" name="best" value="<? echo $text[289]; ?>"></acronym>
    </td>
<? } ?>
  </tr>
  </form>
<? } ?>

<? if($imppage==3){ ?>
  <tr>
    <td class="lmost5" width="20">&nbsp;</td>
    <td class="lmost5" colspan="2"><nobr>&nbsp;<br><? echo $text[291]; ?><br>&nbsp;</nobr></td>
  </tr>
<? include(PATH_TO_ADDONDIR."/limporter/lim-filecontent.php");?>
  <tr>
    <td class="lmost4" colspan="3" align="right"><nobr>
          <a href="<? echo $_SERVER['PHP_SELF']."?action=admin&amp;todo=edit&amp;st=-1&amp;file=".$file; ?>" title="<? echo $text[293]; ?>"><? echo "Liga Optionen bearbeiten"; ?></a>
    </nobr></td>
  </tr>
<? } ?>

  </table>
  </td>
  </tr>
</table>