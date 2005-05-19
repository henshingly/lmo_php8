<?PHP
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
	<td colspan=3>
	<table border=0>
    <tr>
      <td align="right" class ="lmost5">Spieltag&nbsp;</td>
      <td class ="lmost5" align="left">
			<?PHP colSelection("cols[NR][0]",$cols['NR'][0],$rows[0],$header);?>
			</td><td class ="lmost5" align="left">
      <?PHP formatSelection("cols[NR][1]",$cols['NR'][1],$lim_format_exp); ?>
      </td>
      <td class="lmost5" width="5">&nbsp;</td>
      <td align="right" class ="lmost5">Spielnummer&nbsp;</td>
      <td class ="lmost5" align="left">
      <?PHP colSelection("cols[SPNR][0]",$cols['SPNR'][0],$rows[0],$header);?>
			</td><td class ="lmost5" align="left">
      <?PHP formatSelection("cols[SPNR][1]",$cols['SPNR'][1],$lim_format_exp); ?>
      </td>
    </tr>
    <tr>
      <td align="right" class ="lmost5">Spieldatum&nbsp;</td>
      <td class ="lmost5" align="left">
			<?PHP colSelection("cols[DATUM][0]",$cols['DATUM'][0],$rows[0],$header);?>
			</td><td class ="lmost5" align="left">
			<?PHP formatSelection("cols[DATUM][1]",$cols['DATUM'][1],$lim_format_exp);?>
      </td>
      <td class="lmost5" width="5">&nbsp;</td>
      <td align="right" class ="lmost5">Anpfiffzeit&nbsp;</td>
      <td class ="lmost5" align="left">
			<?PHP colSelection("cols[ZEIT][0]",$cols['ZEIT'][0],$rows[0],$header);?>
			</td><td class ="lmost5" align="left">
			<?PHP formatSelection("cols[ZEIT][1]",$cols['ZEIT'][1],$lim_format_exp);?>
      </td>
    </tr>
    <tr>
      <td align="right" class ="lmost5">* Heimmannschaft&nbsp;</td>
      <td class ="lmost5" align="left">
			<?PHP colSelection("cols[HEIM][0]",$cols['HEIM'][0],$rows[0],$header);?>
			</td><td class ="lmost5" align="left">
			<?PHP formatSelection("cols[HEIM][1]",$cols['HEIM'][1],$lim_format_exp);?>
      </td><td class="lmost5" width="5">&nbsp;</td>
      <td align="right" class ="lmost5">* Gastmannschaft&nbsp;</td>
      <td class ="lmost5" align="left">
			<?PHP colSelection("cols[GAST][0]",$cols['GAST'][0],$rows[0],$header);?>
			</td><td class ="lmost5" align="left">
			<?PHP formatSelection("cols[GAST][1]",$cols['GAST'][1],$lim_format_exp); ?>
      </td>
    </tr>
    <tr>
      <td align="right" class ="lmost5">Tore Heim&nbsp;</td>
      <td class ="lmost5" align="left">
			<?PHP colSelection("cols[THEIM][0]",$cols['THEIM'][0],$rows[0],$header);?>
			</td><td class ="lmost5" align="left">
			<?PHP formatSelection("cols[THEIM][1]",$cols['THEIM'][1],$lim_format_exp);?>
      </td>
      <td class="lmost5" width="5">&nbsp;</td>
      <td align="right" class ="lmost5">Tore Gast&nbsp;</td>
      <td class ="lmost5" align="left">
      <?PHP colSelection("cols[TGAST][0]",$cols['TGAST'][0],$rows[0],$header);?>
			</td><td class ="lmost5" align="left">
			<?PHP formatSelection("cols[TGAST][1]",$cols['TGAST'][1],$lim_format_exp);?>
      </td>
    </tr>
    <tr>
      <td align="right" class ="lmost5">Punkte Heim&nbsp;</td>
      <td class ="lmost5" align="left">
			<?PHP colSelection("cols[PHEIM][0]",$cols['PHEIM'][0],$rows[0],$header);?>
			</td><td class ="lmost5" align="left">
			<?PHP formatSelection("cols[PHEIM][1]",$cols['PHEIM'][1],$lim_format_exp);?>
      </td>
      <td class="lmost5" width="5">&nbsp;</td>
      <td align="right" class ="lmost5">Punkte Gast&nbsp;</td>
      <td class ="lmost5" align="left">
			<?PHP colSelection("cols[PGAST][0]",$cols['PGAST'][0],$rows[0],$header);?>
			</td><td class ="lmost5" align="left">
			<?PHP formatSelection("cols[PGAST][1]",$cols['PGAST'][1],$lim_format_exp);?>
      </td>
    </tr>
    <tr>
      <td align="right" class ="lmost5">Notiz&nbsp;</td>
      <td class ="lmost5" align="left">
			<?PHP colSelection("cols[NOTIZ][0]",$cols['NOTIZ'][0],$rows[0],$header);?>
			</td><td class ="lmost5" align="left">
			<?PHP formatSelection("cols[NOTIZ][1]",$cols['NOTIZ'][1],$lim_format_exp);?>
      </td>
      <td class="lmost5" width="5">&nbsp;</td>
      <td align="right" class ="lmost5">&nbsp;</td>
      <td class ="lmost5" align="left">&nbsp;</td>
      <td class ="lmost5" align="left">&nbsp;</td>
    </tr>
    </table>
  </td>
</tr>