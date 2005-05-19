<?php
require_once(dirname(__FILE__).'/../../init.php');
require_once("ini.php");
$Path = PATH_TO_ADDONDIR;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<HTML>
<HEAD>
<Title>Version</Title>
</HEAD>
<BODY>
<p align='center' style='font-family:Verdana,arial,helvetica;font-size:10pt'>
<table border= '0' cellspacing='0' align='center'>
<tr>
<td style='font-size=10pt;background-color=#EEEEEE;border-right-style:solid;border-left-style:solid;border-top-style:solid;border-bottom-style:solid;border-width:1px;border-color:#000000'; align='center'><B>Version Control</B><small><BR>
<?PHP echo VERSlON;?></small></td>
</td>
</tR>
<tr>
<td style='font-size=10pt;background-color=#FFFFFF;border-left-style:solid;border-right-style:solid;border-width:1px;border-color:#000000'; align='left'>
<table border= '0' cellspacing='0' align='center'>
<tr>
  <td colspan=4 style='font-size=10pt;background-color=#FFFFFF;border-bottom-style:solid;border-width:1px;border-color:#000000'>&nbsp;<b>Settings</b></td>
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
  <td>&nbsp</td>
  <td>&nbsp</td>
  <td>&nbsp</td>
</tr>
<tr>
  <td colspan=4 style='font-size=10pt;background-color=#FFFFFF;border-bottom-style:solid;border-width:1px;border-color:#000000'>&nbsp;</td>
</tr>
</table>
</BODY>
</HTML>