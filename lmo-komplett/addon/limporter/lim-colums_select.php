<?
//
// Limporter
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
?>
    <tr>
      <td class="lmost5" width="20">&nbsp;</td>
      <td align="right" class ="lmost5">* Heimmannschaft&nbsp;</td>
      <td class ="lmost5" align="left">
		<?
 		colSelection("cols[HEIM][0]",$cols['HEIM'][0],$rows[0],$header);
 		formatSelection("cols[HEIM][1]",$cols['HEIM'][1],$lim_format_exp);
 		?>
      </td>
    </tr>
    <tr>
      <td class="lmost5" width="20">&nbsp;</td>
      <td align="right" class ="lmost5">* Gastmannschaft&nbsp;</td>
      <td class ="lmost5" align="left">
		<?
 		colSelection("cols[GAST][0]",$cols['GAST'][0],$rows[0],$header);
 		formatSelection("cols[GAST][1]",$cols['GAST'][1],$lim_format_exp);
 		?>
      </td>
    </tr>
    <tr>
      <td class="lmost5" width="20">&nbsp;</td>
      <td align="right" class ="lmost5">Spielnummer&nbsp;</td>
      <td class ="lmost5" align="left">
		<?
 		colSelection("cols[NR][0]",$cols['NR'][0],$rows[0],$header);
 		formatSelection("cols[NR][1]",$cols['NR'][1],$lim_format_exp);
		?>
      </td>
    </tr>
    <tr>
      <td class="lmost5" width="20">&nbsp;</td>
      <td align="right" class ="lmost5">Spieldatum&nbsp;</td>
      <td class ="lmost5" align="left">
		<?
 		colSelection("cols[DATUM][0]",$cols['DATUM'][0],$rows[0],$header);
 		formatSelection("cols[DATUM][1]",$cols['DATUM'][1],$lim_format_exp);
 		?>
      </td>
    </tr>
    <tr>
      <td class="lmost5" width="20">&nbsp;</td>
      <td align="right" class ="lmost5">Anpfiffzeit&nbsp;</td>
      <td class ="lmost5" align="left">
		<?
 		colSelection("cols[ZEIT][0]",$cols['ZEIT'][0],$rows[0],$header);
 		formatSelection("cols[ZEIT][1]",$cols['ZEIT'][1],$lim_format_exp);
 		?>
      </td>
    </tr>
    <tr>
      <td class="lmost5" width="20">&nbsp;</td>
      <td align="right" class ="lmost5">Tore Heim&nbsp;</td>
      <td class ="lmost5" align="left">
		<?
 		colSelection("cols[THEIM][0]",$cols['THEIM'][0],$rows[0],$header);
 		formatSelection("cols[THEIM][1]",$cols['THEIM'][1],$lim_format_exp);
 		?>
      </td>
    </tr>
    <tr>
      <td class="lmost5" width="20">&nbsp;</td>
      <td align="right" class ="lmost5">Tore Gast&nbsp;</td>
      <td class ="lmost5" align="left">
		<?
 		colSelection("cols[TGAST][0]",$cols['TGAST'][0],$rows[0],$header);
 		formatSelection("cols[TGAST][1]",$cols['TGAST'][1],$lim_format_exp);
		?>
      </td>
    </tr>
    <tr>
      <td class="lmost5" width="20">&nbsp;</td>
      <td align="right" class ="lmost5">Punkte Heim&nbsp;</td>
      <td class ="lmost5" align="left">
		<?
 		colSelection("cols[PHEIM][0]",$cols['PHEIM'][0],$rows[0],$header);
 		formatSelection("cols[PHEIM][1]",$cols['PHEIM'][1],$lim_format_exp);
 		?>
      </td>
    </tr>
    <tr>
      <td class="lmost5" width="20">&nbsp;</td>
      <td align="right" class ="lmost5">Punkte Gast&nbsp;</td>
      <td class ="lmost5" align="left">
		<?
 		colSelection("cols[PGAST][0]",$cols['PGAST'][0],$rows[0],$header);
 		formatSelection("cols[PGAST][1]",$cols['PGAST'][1],$lim_format_exp);
		?>
      </td>
    </tr>
    <tr>
      <td class="lmost5" width="20">&nbsp;</td>
      <td align="right" class ="lmost5">Notiz&nbsp;</td>
      <td class ="lmost5" align="left">
		<?
 		colSelection("cols[NOTIZ][0]",$cols['NOTIZ'][0],$rows[0],$header);
 		formatSelection("cols[NOTIZ][1]",$cols['NOTIZ'][1],$lim_format_exp);
		?>
      </td>
    </tr>