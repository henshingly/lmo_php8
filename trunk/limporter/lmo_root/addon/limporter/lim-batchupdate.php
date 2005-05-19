<?PHP
//
// Limporter Addon for LigaManager Online
// Copyright (C) 2003 by Tim Schumacher
// timme@uni.de /
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
  require_once(PATH_TO_ADDONDIR.'/limporter/ini.php');
  require_once(PATH_TO_ADDONDIR.'/classlib/classes/ini/cIniFileReader.inc');
  include(PATH_TO_ADDONDIR."/limporter/lim-javascript.php");

  $hw = isset($_POST['hw'])?$_POST['hw']:0;
  $imppage = isset($_POST['imppage'])?$_POST['imppage']:0;
//  $ximportFile = isset($_POST['ximportFile'])?$_POST['ximportFile']:"";
//  $ximporttype = isset($_POST['ximporttype'])?$_POST['ximporttype']:0;
//  $xparserFile = isset($_POST['xparserFile'])?$_POST['xparserFile']:"";

  $addr = $_SERVER['PHP_SELF']."?action=admin&amp;todo=edit&amp;file=".$file."&amp;st=";
  $addb = $_SERVER['PHP_SELF']."?action=admin&amp;todo=tabs&amp;file=".$file."&amp;st=";

  if(isset($_POST['vorschau'])){
    $imppage--;  // Vorschaubutton wurde gedrückt
    $pv=1;
  }
  else $pv=0;

  if(!isset($xtype)){$xtype="";}
  if(!isset($ximporturl)){$ximporturl="";}
  if(!isset($ximportFile)){$ximportFile="";}
  if(!isset($ximporttype)){$ximporttype=0;}
  if(!isset($xparserFile)){$xparserFile=ereg_replace('.l98','.lim',$file);
    }

  if($imppage==0){
    if (file_exists(PATH_TO_ADDONDIR."/limporter/".$limporter_importDir."/".$xparserFile)) {
      $ini = new IniFileReader(PATH_TO_ADDONDIR."/limporter/".$limporter_importDir."/".$xparserFile);
      // $ximporttype lesen
      $ximporttype = ($ini->getIniFile('LIMPORTER','IMPORTTYP','')=='CSV')?1:0;
//      echo "impage=$imppage parserfile=$xparserFile imptyp=$ximporttype";
    }
    $file=isset($_GET['file'])?$_GET['file']:"";
    }
  else
    $file = isset($_POST['file'])?$_POST['file']:"";

  if($imppage==1){
      if (file_exists(PATH_TO_ADDONDIR."/limporter/".$limporter_importDir."/".$xparserFile)) {
        $ini = new IniFileReader(PATH_TO_ADDONDIR."/limporter/".$limporter_importDir."/".$xparserFile);
        // importURL lesen
        $ximporturl = $ini->getIniFile('LIMPORTER','URL','');
      }
    if($hw<>1) {
        $hw = 0;
        $imppage=0;
        echo "<font color=\"#ff0000\">Sie m&uuml;ssen die Nutzungsbedingungen akzeptieren um fortzufahren !</font>";
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
    if (($ximporttype == 0) || ($ximporttype == 2)) $tmpSourceName="importsrc.htm"; else $tmpSourceName="importsrc.csv";

    if ($fileContent == "") {
      echo "<font color=\"#ff0000\">".$text['limporter'][4]."</font>";
      $imppage=1;
    }
    else {
      $tmpSource = fopen(PATH_TO_ADDONDIR."/limporter/".$limporter_importDir."/".$tmpSourceName,'w+');
      if ($tmpSource) {
        if(fwrite($tmpSource,$fileContent)) {
          $ximportFile = $tmpSourceName;
        }
        else {
          echo "<font color=\"#ff0000\">".$text['limporter'][5].$limporter_importDir."</font>";
          $imppage=1;
        }
        fclose($tmpSource);
      }
      else {
          echo "<font color=\"#ff0000\">".$text['limporter'][6].$limporter_importDir."</font>";
        $imppage=1;
      }
    }
  }
  if($imppage==3){ // upDate and Save
    if(!isset($xdetailsCheck)){$xdetailsCheck=0;}
    if(!isset($header)){$header=0;}
    if(!isset($xoffset) or $xoffset<1){$xoffset=1;}
    $offset = $xoffset - 1;
    $src = PATH_TO_ADDONDIR."/limporter/".$limporter_importDir."/".$ximportFile;
    $liga = new liga();
    $upDateLiga = new liga();
    $partieArray = Array();
    $array = Array();
    $upDateFound = 0;
    $limFile =  PATH_TO_ADDONDIR."/limporter/".$limporter_importDir."/".$file;
    $limFile = ereg_replace('.l98','.lim',$limFile);
    $limSettings = new Sektion('LIMPORTER');
    $limSettings->setKeyValue("VERSION",VERSION);

    if ($ximporttype == 0) {     // HTML Import
      $num = 0;
      $col = 0;
      $row = 0;
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
      $limSettings->setKeyValue("IMPORTTYP","HTML");
    }
        else  if ($ximporttype == 2) {     // DFB Import
      $num = 0;
      $col = 0;
      $row = 0;
      $dataArray = buildFieldArrayDFB($src,$xdetailsCheck);//$ximportFile
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
      $limSettings->setKeyValue("IMPORTTYP","HTML");
    }

    else if ($ximporttype == 1) { // CSV Import
      $array =  buildCSVArray($src,$csvchar,$offset);//$ximportFile
      $limSettings->setKeyValue("IMPORTTYP","CSV");
    }
    buildLigaFromDataArray($liga,$array,$header,$cols,$lim_format_exp);

  if ($upDateLiga->loadFile(PATH_TO_LMO."/".$dirliga.$file)==FALSE) {
    echo "<font color=\"#ff0000\">Fehler beim Laden der Liga ($file)</font>";
    $imppage--;
  }
  else {
    $upDateLiga->writeFile(PATH_TO_LMO."/".$dirliga.$file.'.bak');
    for ($sp=0;$sp < count($upDateLiga->spieltage);$sp++) {
      for ($p=0;$p < count($upDateLiga->spieltage[$sp]->partien);$p++) {
        $upDateHTore = $upDateLiga->spieltage[$sp]->partien[$p]->hTore;
        $upDateGTore = $upDateLiga->spieltage[$sp]->partien[$p]->gTore;
        $upDateZeit = $upDateLiga->spieltage[$sp]->partien[$p]->zeit;
        $upDateNotiz = $upDateLiga->spieltage[$sp]->partien[$p]->notiz;
//        echo "<BR>-".$upDateNotiz;
        $heimName = $upDateLiga->spieltage[$sp]->partien[$p]->heim->name;
        $gastName = $upDateLiga->spieltage[$sp]->partien[$p]->gast->name;
        $zeit = $upDateLiga->spieltage[$sp]->partien[$p]->zeit;
        $partie = $liga->partieForTeamNames($heimName,$gastName);
        if (isset($partie)
        and ($upDateHTore <> $partie->hTore or $upDateGTore <> $partie->gTore)
        and ($partie->hTore <> -1 or $partie->gTore <> -1)
         ){ // Ergebnisse
          $upDateFound = 1;
          if ($upDateHTore <> $partie->hTore) {
              $upDateLiga->spieltage[$sp]->partien[$p]->hTore = $partie->hTore;
          }
          if ($upDateGTore <> $partie->gTore) {
              $upDateLiga->spieltage[$sp]->partien[$p]->gTore = $partie->gTore;
          }
          $txt = "<td>&nbsp;".$upDateLiga->spieltage[$sp]->nr.".Spieltag&nbsp;</td>";
          $txt .= "<td>&nbsp;";
          $txt .= $upDateLiga->spieltage[$sp]->partien[$p]->heim->name."&nbsp;</td>";
          $txt .= "<td>&nbsp;";
          $txt .= $upDateLiga->spieltage[$sp]->partien[$p]->gast->name."&nbsp;</td>";
          $txt .= "<td align='center'>&nbsp;";
          $txt .= $upDateLiga->spieltage[$sp]->partien[$p]->hTore." - ";
          $txt .= $upDateLiga->spieltage[$sp]->partien[$p]->gTore."&nbsp;</td>";
          $partieArray[] = "<tr>".$txt."</tr>";
        }
        if (isset($partie) and $partie->zeit<> '' and ($upDateZeit <> $partie->zeit) ){  // Spieldatum
          $upDateFound = 1;
          $upDateLiga->spieltage[$sp]->partien[$p]->zeit = $partie->zeit;
          $txt = "<td>&nbsp;".$upDateLiga->spieltage[$sp]->nr.".Spieltag&nbsp;</td>";
          $txt .= "<td>&nbsp;";
          $txt .= $upDateLiga->spieltage[$sp]->partien[$p]->heim->name."&nbsp;</td>";
          $txt .= "<td>&nbsp;";
          $txt .= $upDateLiga->spieltage[$sp]->partien[$p]->gast->name."&nbsp;</td>";
          $txt .= "<td align='center'>&nbsp;";
          $txt .= $upDateLiga->spieltage[$sp]->partien[$p]-> datumString()."&nbsp;";
          $txt .= $upDateLiga->spieltage[$sp]->partien[$p]-> zeitString()."&nbsp;</td>";
          $partieArray[] = "<tr>".$txt."</tr>";
        }
        if (isset($partie) and $partie->notiz <> '' and ($upDateNotiz <> $partie->notiz) ){  // Spielnotiz and $upDateNotiz <> ''
          $upDateFound = 1;
          $upDateLiga->spieltage[$sp]->partien[$p]->notiz = $partie->notiz;
          $txt = "<td>&nbsp;".$upDateLiga->spieltage[$sp]->nr.".Spieltag&nbsp;</td>";
          $txt .= "<td>&nbsp;";
          $txt .= $upDateLiga->spieltage[$sp]->partien[$p]->heim->name."&nbsp;</td>";
          $txt .= "<td>&nbsp;";
          $txt .= $upDateLiga->spieltage[$sp]->partien[$p]->gast->name."&nbsp;</td>";
          $txt .= "<td align='center'>&nbsp;";
          $txt .= $upDateLiga->spieltage[$sp]->partien[$p]->notiz."&nbsp;</td>";
          $partieArray[] = "<tr>".$txt."</tr>";
        }

      } //for
    } //for
  }

  if ($upDateFound==1)
    $upDateLiga->writeFile($dirliga.$file);

//  limsettings speichern

    $limSettings->setKeyValue("URL",$ximporturl);
    $limSettings->setKeyValue("TITLE",$upDateLiga->name);
    $limSettings->setKeyValue("DETAILS",$xdetailsCheck);
    $limSettings->setKeyValue("FIRSTROW",$offset);
    $limSettings->setKeyValue("LASTROW",$xlrow);
    $limSettings->setKeyValue("ISHEADER",$header);

    foreach($cols as $colum=>$value) {
        $limSettings->setKeyValue($colum."_COLUMN",$value[0]);
        $limSettings->setKeyValue($colum."_FORMAT",$value[1]);
    }
    writeLimSettings($limFile,$limSettings);
  } // end if($imppage==3)


include(PATH_TO_LMO."/lmo-adminsubnavi.php");
?>
<table class="lmoMiddle" cellspacing="0" cellpadding="0" border="0">
  <tr>
    <td align="center"><h1><?PHP echo $text['limporter'][17];?></h1></td>
  </tr>
  <tr><td align="center" class="lmost3">
<?PHP if($imppage<1){ ?>
  <form onSubmit="return checkHinweis();" name="lmoedit" action="<?PHP echo $PHP_SELF; ?>" method="post">
<?PHP }
  else if ($imppage<3){ ?>
  <form  onSubmit="return checkSettings();" name="lmoedit" action="<?PHP echo $PHP_SELF; ?>" method="post">
<?PHP }

if($imppage<3){ ?>
  <input type="hidden" name="action" value="admin">
  <input type="hidden" name="todo" value="edit">
  <input type="hidden" name="imppage" value="<?PHP echo ($imppage+1); ?>">
  <input type="hidden" name="st" value="-9">
  <input type="hidden" name="file" value="<?PHP echo $file; ?>">
<?PHP if($imppage>0){ ?>
  <input type="hidden" name="ximporttype" value="<?PHP echo $ximporttype; ?>">
  <input type="hidden" name="xparserFile" value="<?PHP echo $xparserFile; ?>">
<?PHP } ?>
<?PHP if($imppage>1){ ?>
  <input type="hidden" name="ximporturl" value="<?PHP echo $ximporturl; ?>">
  <input type="hidden" name="ximportFile" value="<?PHP echo $ximportFile; ?>">
<?PHP }} ?>
  <table class="lmoInner" cellspacing="0" cellpadding="0" border="0">
  <tr>
    <td class="lmost4" colspan="3"><b><nobr><?PHP echo $text[246]." ".($imppage+1)." ".$text[259]." 4"; ?></nobr><b></td>
  </tr>
<?PHP if($imppage==0){ ?>
  <tr>
    <td class="lmost5" width="20">&nbsp;</td>
    <td class="lmost5" colspan=2 align="left"><B>Bitte beachten Sie folgende Hinweise:</B>
      <table class="lmoInner" cellspacing="3" cellpadding="0" border="0">
        <tr>
          <td class="lmost5" width=350><?=$text['limporter'][8]?>
          </td>
        </tr>
      </table>
  </tr>
  <tr>
    <td class="lmost5" width="20">&nbsp;</td>
    <td class="lmost5" colspan="2" align="left">
      <input class="lmo-formular-input" type="checkbox" name="hw" <?PHP if($hw==1) {echo " checked";} ?> value='1'> Nutzungsbedingungen akzeptieren</td>
  </tr>
  <tr>
    <td class="lmost5" width="20">&nbsp;</td>
    <td class="lmost5">&nbsp;</td>
    <td class="lmost5" align="left">&nbsp;</td>
  </tr>
  <tr>
    <td class="lmost5" width="20">&nbsp;</td>
    <td class="lmost5" colspan="2"><nobr><?PHP echo $text['limporter'][18] ?></nobr></td>
  </tr>
  <tr>
    <td class="lmost5" width="20">&nbsp;</td>
    <td class="lmost5" align="right"><nobr><?PHP echo $text[244]; ?>:</nobr></td>
    <td class="lmost5" align="left"><nobr><b><?PHP echo $file; ?></b></nobr></td>
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
      $fileName=$tmpSourceName;
      include(PATH_TO_ADDONDIR."/limporter/lim-htm_settings.php");
    } // csv Import
    else if ($ximporttype == 2) {
      $fileName=$tmpSourceName;
      include(PATH_TO_ADDONDIR."/limporter/lim-dfb_settings.php");
    }
    else if ($ximporttype == 1) {
      $fileName=$tmpSourceName;
       include(PATH_TO_ADDONDIR."/limporter/lim-csv_settings.php");
    }
  }
?>
  <tr>
    <td class="lmost5" colspan="3" align="center"><?PHP echo VERSlON ; ?></td>
  </tr>
<?php
  if($imppage<3){ ?>
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
      <acronym title="<?PHP echo $text[290]; ?>"><input onClick="nextButtonClicked=1;"  class="lmo-formular-button" type="submit" name="best" value="<?PHP echo $text[289]; ?>"></acronym>
    </td>
<?PHP } ?>
  </tr>
  </form>
<?PHP } ?>
<?PHP if($imppage==3){
  include(PATH_TO_ADDONDIR."/limporter/lim-updateresult.php");?>
  <tr>
    <td class="lmost4" colspan="3" align="right"><nobr>
          <a href="<?PHP echo $_SERVER['PHP_SELF']."?action=admin&amp;todo=edit&amp;file=".$file; ?>" title="<?PHP echo $text[293]; ?>"><?PHP echo "Liga Optionen bearbeiten"; ?></a>
    </nobr></td>
  </tr>
<?PHP } ?>
  </table>
  </td>
  </tr>
</table>