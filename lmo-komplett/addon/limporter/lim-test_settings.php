<?
if (isset($HTTP_GET_VARS)) {
   reset ($HTTP_GET_VARS);
   foreach ($HTTP_GET_VARS as $k=>$v) {${"lim_$k"} = $v;}
}
require_once(dirname(__FILE__).'/../../init.php');
require_once("lim_ini.php");
require_once("lim-classes.php");
require_once("lim-functions.php");
require_once("classes/ini/cIniFileReader.inc");
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
<td style='font-size=10pt;background-color=#EEEEEE;border-right-style:solid;border-left-style:solid;border-top-style:solid;border-bottom-style:solid;border-width:1px;border-color:#000000'; align='center'><B>Limporter Settings Control</B><small><BR><? echo LIM_VERSIONS;?></small></td>
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
	<td width='300'><? echo LIM_VERSION;?></td>
</tr>
<tr>
	<td>&nbsp</td>
	<td>Installed in</td>
	<td>=</td>
	<td><small><? echo $Path;?></small></td>
</tr>
<tr>
	<td>&nbsp</td>
	<td>Import Directory</td>
	<td>=</td>
	<td>
	<?
	if ($erg = fileperms($impPath)) {
    $octalperms = sprintf("%o",$erg);
    $perms=(substr($octalperms,2));
		echo $limporter_importDir."/ ($perms)";
	}
	else
		echo "WARNING can't read permissions".$impPath;
	?>
	</td>
<tr>
	<td>&nbsp</td>
	<td>HTM-Import TempFile</td>
	<td>=</td>
	<td>
	<?
	if ($erg = fileperms($impPath."/importsrc.htm")) {
    $octalperms = sprintf("%o",$erg);
    $perms=(substr($octalperms,3));
		echo "importsrc.htm  ($perms)";
	}
	else
		echo "WARNING can't read permissions".$impPath;
	?>
	</td>

</tr>
<tr>
	<td>&nbsp</td>
	<td>CSV-Import TempFile</td>
	<td>=</td>
	<td>
	<?
	if ($erg = fileperms($impPath."/importsrc.csv")) {
    $octalperms = sprintf("%o",$erg);
    $perms=(substr($octalperms,3));
		echo "importsrc.csv  ($perms)";
	}
	else
		echo "WARNING can't read permissions".$impPath;
	?>
	</td>

</tr>
<tr>
	<td>&nbsp</td>
	<td>CSV-Import Fileextension</td>
	<td>=</td>
	<td><small><? echo $limporter_csvExtension;?></small></td>
</tr>

<?
if (isset($lim_format_exp)) {
?>
<tr>
	<td colspan=4>&nbsp</td>
</tr>

<tr>
	<td colspan=4 style='font-size=10pt;background-color=#FFFFFF;border-bottom-style:solid;border-top-style:solid;border-width:1px;border-color:#000000'>&nbsp;<b>Format  Expressions</b></td>
</tr>


<?
	foreach($lim_format_exp as $k=>$v) {
?>
<tr>
	<td>&nbsp</td>
	<td><? echo $k;?></td>
	<td>=</td>
	<td><small><? echo $v;?></small></td>
</tr>
<?
	}
}?>
<?
if (isset($lim_colums)) {
?>
<tr>
	<td colspan=4>&nbsp</td>
</tr>
<tr>
	<td colspan=4 style='font-size=10pt;background-color=#FFFFFF;border-bottom-style:solid;border-top-style:solid;border-width:1px;border-color:#000000'>&nbsp;<b>Import Fields</b></td>
</tr>

<?
	foreach($lim_colums as $k=>$v) {
?>
<tr>
	<td>&nbsp</td>
	<td><? echo $k;?></td>
	<td>=</td>
	<td><small><? echo implode(',',$v);?></small></td>
</tr>
<?
	}
?>
<tr>
	<td colspan=4>&nbsp;</td>
</tr>
<? }
if (!isset($lim_ligen)) $lim_ligen = 0;
if (!isset($lim_file)) $lim_file = "";
if ($lim_ligen <> 0 or $lim_file<>""){?><tr><td colspan=4 style='font-size=10pt;background-color=#FFFFFF;border-bottom-style:solid;border-top-style:solid;border-width:1px;border-color:#000000'>&nbsp;<b>Imported Leagues</b></td></tr>
<? $dir = opendir($impPath);
while($files=readdir($dir)){
if(strtolower(substr($files,-4))==".lim"){$datei = $impPath."/".$files;
if ($datei) {
?>
<tr>
	<td>&nbsp;</td>
	<td>File Name</td>
	<td>=</td>
	<td>
<? echo "<a href='".$_SERVER['PHP_SELF']."?file=$files'>$files</a>";
if ($erg = fileperms($impPath."/".$files)) {
$octalperms = sprintf("%o",$erg);
$perms=(substr($octalperms,3));
echo " ($perms)";}?></td>
<?
if ($files == $lim_file) {
$ini = new IniFileReader($datei);
$keys = $ini->keys('LIMPORTER');
foreach ($keys as $key) {
?>
<tr>
	<td>&nbsp</td>
	<td><? echo $key;?></td>
	<td>=</td>
	<td>
<?
$value = $ini->getIniFile('LIMPORTER', $key, "");
if ($key == 'URL') {
	$details = parse_url($value);
	if (array_key_exists ('host',$details)) {
		$host = $details['host'];
		echo "<a target='_new' href='".$value."'>$host</a>";
	}
	else echo "Local File";
}
else
	echo $value;

?>
</td>
</tr>
<? }}?>
<tr><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td><td>&nbsp</td></tr>
<? }}}} ?>
</table>
</td>
<tr>
<td style='font-size=10pt;background-color=#EEEEEE;border-left-style:solid;border-right-style:solid;border-top-style:solid;border-bottom-style:solid;border-width:1px;border-color:#000000'; align='center'>&nbsp;
<a href='<? echo URL_TO_LMO.'/lmo.php';?>'>Back to LMO</a></small></td></tr>
</table>
</BODY>
</HTML>