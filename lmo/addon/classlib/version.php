<?php
require_once(__DIR__ . '/../../init.php');
require_once('ini.php');
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
      <td style='font-size=10pt;background-color=#EEEEEE;border-right-style:solid;border-left-style:solid;border-top-style:solid;border-bottom-style:solid;border-width:1px;border-color:#000000'; align='center'><B>Version Control</B><BR>
      <small><?PHP echo CLASSLIB_VERSION;?></small>
      </td>
    </tr>
    <tr>
      <td style='font-size=10pt;background-color=#FFFFFF;border-left-style:solid;border-right-style:solid;border-width:1px;border-color:#000000'; align='left'>
        <table border= '0' cellspacing='0' align='center'>
        <tr>
          <td align='center' colspan=4 style='font-size=10pt;background-color=#FFFFFF;border-bottom-style:solid;border-width:1px;border-color:#000000'><b>Settings</b></td>
        </tr>
        <tr>
          <td>&nbsp</td>
          <td align='right'>Installed Version&nbsp;</td>
          <td>=&nbsp;</td>
          <td><?PHP echo CLASSLIB_INFO;?>&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp</td>
          <td align='right'>Installed in&nbsp;</td>
          <td>=&nbsp;</td>
          <td><?PHP echo $Path;?>&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp</td>
          <td align='right'>PHP&nbsp;</td>
          <td>=&nbsp;</td>
          <td><?PHP echo phpversion();?>&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp</td>
          <td align='right'>LMO Version&nbsp;</td>
          <td>=&nbsp;</td>
          <td><?PHP echo LMO_VERSION;?>&nbsp;</td>
        </tr>
        <tr>
        <tr>
          <td colspan=4 style='font-size=10pt;background-color=#FFFFFF;border-bottom-style:solid;border-width:1px;border-color:#000000'>&nbsp;</td>
        </tr>
        </table>
      </td>
    </tr>
  </table>
</BODY>
</HTML>
