<?PHP
//
// Limporter Class Library Version 0.1
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
    <td class="lmost5" align="right"><nobr><acronym title="<?PHP echo $text[175] ?>"><?PHP echo "Datenformat"; ?></acronym></nobr></td>
    <td class="lmost5" align="left"><acronym title="<?PHP echo $text[175] ?>"><select class="lmo-formular-input" name="ximporttype" onChange="dolmoedit()"><?PHP echo "<option value=\"0\""; if($ximporttype==0){echo " selected";} echo ">"."HTML Tabelle (SIS-Handball)"."</option>"; echo "<option value=\"1\""; if($ximporttype==1){echo " selected";} echo ">"."CSV-Datei (Trennzeichen separiert)"."</option>"; ?></select></acronym></td>
  </tr>

<?PHP

?>