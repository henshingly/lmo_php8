<?PHP
//
// Limporter Version 0.1
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

require_once(dirname(__FILE__).'/../../init.php');
require_once(PATH_TO_ADDONDIR.'/limporter/lim_ini.php');
require_once(PATH_TO_ADDONDIR.'/limporter/lim-functions.php');

?>
    <tr>
      <td class="lmost5" width="20">&nbsp;</td>
      <td align="right" class ="lmost5">* Heimmannschaft&nbsp;</td>
      <td class ="lmost5" align="left">
		<?PHP
 		colSelection("cols[HEIM][]",$cols['HEIM'][0],$rows[0],$header);
 		formatSelection("cols[HEIM][]",$cols['HEIM'][1],$limporter_formatKeys,$limporter_formatValues,$limporter_delimiter);
 		?>
      </td>
    </tr>
    <tr>
      <td class="lmost5" width="20">&nbsp;</td>
      <td align="right" class ="lmost5">* Gastmannschaft&nbsp;</td>
      <td class ="lmost5" align="left">
		<?PHP
 		colSelection("cols[GAST][]",$cols['GAST'][0],$rows[0],$header);
 		formatSelection("cols[GAST][]",$cols['GAST'][1],$limporter_formatKeys,$limporter_formatValues,$limporter_delimiter);
 		?>
      </td>
    </tr>
    <tr>
      <td class="lmost5" width="20">&nbsp;</td>
      <td align="right" class ="lmost5">* Spieldatum&nbsp;</td>
      <td class ="lmost5" align="left">
		<?PHP
 		colSelection("cols[DATUM][]",$cols['DATUM'][0],$rows[0],$header);
 		formatSelection("cols[DATUM][]",$cols['DATUM'][1],$limporter_formatKeys,$limporter_formatValues,$limporter_delimiter);
 		?>
      </td>
    </tr>
    <tr>
      <td class="lmost5" width="20">&nbsp;</td>
      <td align="right" class ="lmost5">Anpfiffzeit&nbsp;</td>
      <td class ="lmost5" align="left">
		<?PHP
 		colSelection("cols[ZEIT][]",$cols['ZEIT'][0],$rows[0],$header);
 		formatSelection("cols[ZEIT][]",$cols['ZEIT'][1],$limporter_formatKeys,$limporter_formatValues,$limporter_delimiter);
 		?>
      </td>
    </tr>
    <tr>
      <td class="lmost5" width="20">&nbsp;</td>
      <td align="right" class ="lmost5">Tore Heim&nbsp;</td>
      <td class ="lmost5" align="left">
		<?PHP
 		colSelection("cols[THEIM][]",$cols['THEIM'][0],$rows[0],$header);
 		formatSelection("cols[THEIM][]",$cols['THEIM'][1],$limporter_formatKeys,$limporter_formatValues,$limporter_delimiter);
 		?>
      </td>
    </tr>
    <tr>
      <td class="lmost5" width="20">&nbsp;</td>
      <td align="right" class ="lmost5">Tore Gast&nbsp;</td>
      <td class ="lmost5" align="left">
		<?PHP
 		colSelection("cols[TGAST][]",$cols['TGAST'][0],$rows[0],$header);
 		formatSelection("cols[TGAST][]",$cols['TGAST'][1],$limporter_formatKeys,$limporter_formatValues,$limporter_delimiter);
		?>

      </td>
    </tr>
    <tr>
      <td class="lmost5" width="20">&nbsp;</td>
      <td align="right" class ="lmost5">Spielnummer&nbsp;</td>
      <td class ="lmost5" align="left">
		<?PHP
 		colSelection("cols[NR][]",$cols['NR'][0],$rows[0],$header);
 		formatSelection("cols[NR][]",$cols['NR'][1],$limporter_formatKeys,$limporter_formatValues,$limporter_delimiter);
		?>
      </td>
    </tr>
    <tr>
      <td class="lmost5" width="20">&nbsp;</td>
      <td align="right" class ="lmost5">Notiz&nbsp;</td>
      <td class ="lmost5" align="left">
		<?PHP
 		colSelection("cols[NOTIZ][]",$cols['NOTIZ'][0],$rows[0],$header);
 		formatSelection("cols[NOTIZ][]",$cols['NOTIZ'][1],$limporter_formatKeys,$limporter_formatValues,$limporter_delimiter);
		?>
      </td>
    </tr>