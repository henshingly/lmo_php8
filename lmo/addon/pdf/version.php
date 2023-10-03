<?php
/** This file is part of Pdf Addon for LMO 4.
  * Copyright (C) 2017 by Dietmar Kersting
  *
  * MINITABLE Addon for LigaManager Online (pdf-tabelle.php and pdf-spielplan.php)
  * Copyright (C) 2003 by Tim Schumacher
  * timme@uni.de /
  *
  * Pdf Addon for LMO 4 für Spielplan (pdf-spielplan.php)
  * Copyright (C)  by Torsten Hofmann V 2.0
  *
  * Pdf Addon für LMO 4 is free software: you can redistribute it and/or modify
  * it under the terms of the GNU General Public License as published by
  * the Free Software Foundation, either version 3 of the License, or
  * (at your option) any later version.
  *
  * Pdf Addon für LMO 4 is distributed in the hope that it will be useful,
  * but WITHOUT ANY WARRANTY; without even the implied warranty of
  * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  * GNU General Public License for more details.
  *
  * You should have received a copy of the GNU General Public License
  * along with Pdf Addon für LMO 4.  If not, see <http://www.gnu.org/licenses/>.
  *
  * REMOVING OR CHANGING THE COPYRIGHT NOTICES IS NOT ALLOWED!
  *
  * Diese Datei ist Teil des PDF Addon für LMO 4.
  *
  * Pdf Addon für LMO 4 ist Freie Software: Sie können es unter den Bedingungen
  * der GNU General Public License, wie von der Free Software Foundation,
  * Version 3 der Lizenz oder (nach Ihrer Wahl) jeder späteren
  * veröffentlichten Version, weiterverbreiten und/oder modifizieren.
  *
  * Pdf Addon für LMO 4 wird in der Hoffnung, dass es nützlich sein wird, aber
  * OHNE JEDE GEWÄHRLEISTUNG, bereitgestellt; sogar ohne die implizite
  * Gewährleistung der MARKTFÄHIGKEIT oder EIGNUNG FÜR EINEN BESTIMMTEN ZWECK.
  * Siehe die GNU General Public License für weitere Details.
  *
  * Sie sollten eine Kopie der GNU General Public License zusammen mit diesem
  * Pdf Addon für LMO 4 erhalten haben. Wenn nicht, siehe <http://www.gnu.org/licenses/>.
  *
  * DAS ENTFERNEN ODER DIE ÄNDERUNG DER COPYRIGHT-HINWEISE IST NICHT ERLAUBT!
**/


require_once(dirname(__FILE__).'/../../init.php');
require_once("ini.php");
$Path = PATH_TO_ADDONDIR;
$Path_pdf = PATH_TO_ADDONDIR."/classlib/classes/pdf";
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<HTML>
<HEAD>
<Title>PDF-Version</Title>
</HEAD>
<BODY>
  <p align='center' style='font-family:Verdana,arial,helvetica;font-size:10pt'>
  <table border= '0' cellspacing='0' align='center'>
    <tr>
      <td style='font-size=10pt;background-color=#EEEEEE;border-right-style:solid;border-left-style:solid;border-top-style:solid;border-bottom-style:solid;border-width:1px;border-color:#000000'; align='center'>Version Control<BR><B><?PHP echo VERSlON;?></B></td>
    </tr>
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
          <td colspan=4 style='font-size=10pt;background-color=#FFFFFF;border-bottom-style:solid;border-width:1px;border-color:#000000'>&nbsp;</td>
        </tr>
        </table>
      </td>
    </tr>
  </table>
  <br>
  <table border= '0' cellspacing='0' align='center'>
    <tr>
      <td style='font-size=10pt;background-color=#EEEEEE;border-right-style:solid;border-left-style:solid;border-top-style:solid;border-bottom-style:solid;border-width:1px;border-color:#000000'; align='center'>Version Control<BR><B><?PHP echo TEAM_PLAN." ".VERSlONA;?></B></td>
    </tr>
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
          <td width='300'><?PHP echo VERSIONA;?></td>
        </tr>
        <tr>
          <td>&nbsp</td>
          <td>Installed in</td>
          <td>=</td>
          <td><small><?PHP echo $Path;?></small></td>
        </tr>
        <tr>
          <td colspan=4 style='font-size=10pt;background-color=#FFFFFF;border-bottom-style:solid;border-width:1px;border-color:#000000'>&nbsp;</td>
        </tr>
        </table>
      </td>
    </tr>
  </table>
  <br>
  <table border= '0' cellspacing='0' align='center'>
    <tr>
      <td style='font-size=10pt;background-color=#EEEEEE;border-right-style:solid;border-left-style:solid;border-top-style:solid;border-bottom-style:solid;border-width:1px;border-color:#000000'; align='center'>Version Control<BR><B><?PHP echo ADDON_NAMEPDF;?></B></td>
    </tr>
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
          <td width='300'><?PHP echo VERSIONPDF;?></td>
        </tr>
        <tr>
          <td>&nbsp</td>
          <td>Installed in</td>
          <td>=</td>
          <td><small><?PHP echo $Path_pdf;?></small></td>
        </tr>
        <tr>
          <td colspan=4 style='font-size=10pt;background-color=#FFFFFF;border-bottom-style:solid;border-width:1px;border-color:#000000'>&nbsp;</td>
        </tr>
        </table>
      </td>
    </tr>
  </table>
</BODY>
</HTML>
