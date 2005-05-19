<?php
require_once(dirname(__FILE__).'/../../init.php');
require_once(PATH_TO_ADDONDIR."/limporter/ini.php");
require_once(PATH_TO_ADDONDIR."/classlib/classes.php");
require_once(PATH_TO_ADDONDIR."/classlib/functions.php");
require_once(PATH_TO_ADDONDIR."/classlib/classes/ini/cIniFileReader.inc");
require_once(PATH_TO_ADDONDIR."/limporter/lim-functions.php");

if (isset($HTTP_GET_VARS)) {
   reset ($HTTP_GET_VARS);
   foreach ($HTTP_GET_VARS as $k=>$v) {${"lim_$k"} = $v;}
}
$Path = PATH_TO_ADDONDIR."/limporter/";
$impPath = $Path.$limporter_importDir;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<HTML>
<HEAD>
<Title>Limporter Settings Control</Title>
</HEAD>
<BODY>
<p align='center' style='font-family:Verdana,arial,helvetica;font-size:10pt'>
<table border= '0' cellspacing='0' align='center'>
<tr>
<td style='font-size=10pt;background-color=#EEEEEE;border-right-style:solid;border-left-style:solid;border-top-style:solid;border-bottom-style:solid;border-width:1px;border-color:#000000'; align='center'><B>Limporter Settings Control</B><small><BR><?PHP echo VERSlON;?></small></td>
</td>
</tR>
<tr>
<td style='font-size=10pt;background-color=#FFFFFF;border-left-style:solid;border-right-style:solid;border-width:1px;border-color:#000000'; align='left'>
<table border= '0' cellspacing='0' align='center'>
<tr>
  <td colspan=4 style='font-size=10pt;background-color=#FFFFFF;border-bottom-style:solid;border-width:1px;border-color:#000000'>&nbsp;<b>Limporter Settings</b></td>
</tr>
<tr>
  <td width='30'>&nbsp</td>
  <td width='200'>Installed Version</td>
  <td width='30'>=</td>
  <td width='300'><?PHP echo VERSION;?></td>
</tr>
<tr>
  <td>&nbsp</td>
  <td>Installed in</td>
  <td>=</td>
  <td><small><?PHP echo $Path;?></small></td>
</tr>
<tr>
  <td>&nbsp</td>
  <td>Import Directory</td>
  <td>=</td>
  <td>
  <?PHP
  if (file_exists($impPath)) {
    if ($erg = fileperms($impPath)) {
      $octalperms = sprintf("%o",$erg);
      $perms=(substr($octalperms,2));
      echo $limporter_importDir."/ ($perms)";
    }
    else
      echo "WARNING, can't read permissions for ".$impPath;
  }
  else
    echo "WARNING, no importDir specified Path value=".$impPath;

  ?>
  </td>
<tr>
  <td>&nbsp</td>
  <td>HTM-Import TempFile</td>
  <td>=</td>
  <td>
  <?PHP
  if (file_exists($impPath."/importsrc.htm")) {
    if ($erg = fileperms($impPath."/importsrc.htm")) {
      $octalperms = sprintf("%o",$erg);
      $perms=(substr($octalperms,3));
      echo "importsrc.htm  ($perms)";
    }
    else
      echo "WARNING, can't read permissions".$impPath;
  }
  else
    echo "WARNING, no importsrc.htm found";


  ?>
  </td>

</tr>
<tr>
  <td>&nbsp</td>
  <td>CSV-Import TempFile</td>
  <td>=</td>
  <td>
  <?PHP
  if (file_exists($impPath."/importsrc.csv")) {
    if ($erg = fileperms($impPath."/importsrc.csv")) {
      $octalperms = sprintf("%o",$erg);
      $perms=(substr($octalperms,3));
      echo "importsrc.csv  ($perms)";
    }
    else
      echo "WARNING can't read permissions".$impPath;
  }
  else
    echo "WARNING, no importsrc.csv found";
  ?>
  </td>

</tr>
<tr>
  <td>&nbsp</td>
  <td>CSV-Import Fileextension</td>
  <td>=</td>
  <td><small><?PHP echo $limporter_csvExtension;?></small></td>
</tr>

<?PHP
if (isset($lim_format_exp)) {
?>
<tr>
  <td colspan=4>&nbsp</td>
</tr>

<tr>
  <td colspan=4 style='font-size=10pt;background-color=#FFFFFF;border-bottom-style:solid;border-top-style:solid;border-width:1px;border-color:#000000'>&nbsp;<b>Format  Expressions</b></td>
</tr>


<?PHP
  foreach($lim_format_exp as $k=>$v) {
?>
<tr>
  <td>&nbsp</td>
  <td><?PHP echo $k;?></td>
  <td>=</td>
  <td><small><?PHP echo $v;?></small></td>
</tr>
<?PHP
  }
}?>
<?PHP
if (isset($lim_colums)) {
?>
<tr>
  <td colspan=4>&nbsp</td>
</tr>
<tr>
  <td colspan=4 style='font-size=10pt;background-color=#FFFFFF;border-bottom-style:solid;border-top-style:solid;border-width:1px;border-color:#000000'>&nbsp;<b>Import Fields</b></td>
</tr>

<?PHP
  foreach($lim_colums as $k=>$v) {
?>
<tr>
  <td>&nbsp</td>
  <td><?PHP echo $k;?></td>
  <td>=</td>
  <td><small><?PHP echo implode(',',$v);?></small></td>
</tr>
<?PHP
  }
?>
<tr>
  <td colspan=4>&nbsp;</td>
</tr>
<?PHP }
if (!isset($lim_ligen)) $lim_ligen = 0;
if (!isset($lim_file)) $lim_file = "";
if ($lim_ligen <> 0 or $lim_file<>""){?><tr><td colspan=4 style='font-size=10pt;background-color=#FFFFFF;border-bottom-style:solid;border-top-style:solid;border-width:1px;border-color:#000000'>&nbsp;<b>Imported Leagues</b></td></tr>
<?php $dir = opendir($impPath);
while($files=readdir($dir)){
if(strtolower(substr($files,-4))==".lim"){$datei = $impPath."/".$files;
if ($datei) {
?>
<tr>
  <td>&nbsp;</td>
  <td>File Name</td>
  <td>=</td>
  <td>
<?PHP echo "<a href='".$_SERVER['PHP_SELF']."?file=$files'>$files</a>";
if ($erg = fileperms($impPath."/".$files)) {
$octalperms = sprintf("%o",$erg);
$perms=(substr($octalperms,3));
echo "<small> (".date("d.m.Y H:i",filemtime($impPath."/".$files)).")($perms)</small>";}?></td>
<?PHP
if ($files == $lim_file) {
$ini = new IniFileReader($datei);
$keys = $ini->keys('LIMPORTER');
foreach ($keys as $key) {
?>
<tr>
  <td>&nbsp</td>
  <td><small><?PHP echo $key;?></small></td>
  <td><small>=</small></td>
  <td><small>
<?PHP
$value = $ini->getIniFile('LIMPORTER', $key, "");
if ($key == 'URL') {
  $details = parse_url($value);
  if (array_key_exists ('host',$details)) {
    $host = $details['host'];
    echo "<a target='_new' href='".$value."'>$host</a>";
  }
  else echo "<a target='_new' href='".$value."'>local file</a>";
}
else
  echo $value;
?>
</small></td></tr>
<?PHP } /* limfile keyValues */?>
<tr>
  <td colspan=4 style='font-size=10pt;background-color=#FFFFFF;border-bottom-style:solid;border-top-style:solid;border-width:1px;border-color:#000000'>&nbsp;<b>Liga Details</b></td>
</tr>
<?PHP
// Details ausgeben
$path = PATH_TO_LMO."/".$dirliga;
$ligaFile = ereg_replace('\.lim','.l98',$files);
if(file_exists($path.$ligaFile) ) {
      $stand = date("d.m.Y H:i",filemtime($path.$ligaFile));
    	echo "<tr><td colspan=4><small>Ligadatum: $stand<small></td></tr>";
      $datei = fopen($path.$ligaFile,"rb");
  while (!feof($datei)) {
    $zeile = fgets($datei,1000);
    $zeile = chop($zeile);
    $zeile = trim($zeile);
    echo "<tr><td colspan=4><small>$zeile<small></td></tr>";
	}
	fclose($datei);

}
else echo "<tr><td colspan=4>$ligaFile not found</td></tr>";


}?>
<tr><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td></tr>
<?PHP }}}} ?>
</table>
</td>
<tr>
<td style='font-size=10pt;background-color=#EEEEEE;border-left-style:solid;border-right-style:solid;border-top-style:solid;border-bottom-style:solid;border-width:1px;border-color:#000000'; align='center'>&nbsp;
<a href='<?PHP echo URL_TO_LMO.'/lmo.php';?>'>Back to LMO</a></small></td></tr>
</table>
</BODY>
</HTML>