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
require_once(PATH_TO_ADDONDIR."/limporter/lim-functions.php");
require_once(PATH_TO_ADDONDIR."/limporter/lim-classes.php");

if(!isset($cols)){
	$cols = array (
        'HEIM'=> array(-1,-1),
        'GAST'=> array(-1,-1),
        'THEIM'=> array(-1,-1),
        'TGAST'=> array(-1,-1),
        'DATUM'=> array(-1,-1),
        'ZEIT'=> array(-1,-1),
        'NR'=> array(-1,-1),
        'NOTIZ'=> array(-1,-1)
	);
}

if(!isset($header)){$header="0";}
if(!isset($showall)){$showall="0";}
if(!isset($csvchar)){$csvchar=";";}
if(!isset($xoffset) or $xoffset<1){$xoffset=1;}
$offset = $xoffset - 1;
if(!isset($datarows) or ($datarows < 1) ){$datarows=10;}
if(isset($ximporturl)){
	$row = 0;
	$handle = fopen ($ximporturl,"r");
	$rows = array();
	$num = 0;
	$col = 0;
	while ($data = fgetcsv ($handle, 1000, $csvchar)) {
		if ($row >= $offset) {
		   	$rows[] = $data;
		    $num = count ($data);
			if ($num>$col) $col = $num;
		}
		$row++;
	}
	fclose ($handle);
	if ($datarows >= count($rows)) $datarows = count($rows);
	}
?>
    <tr>
      <td class ="lmost5" colspan=3>&nbsp;</td>
    </tr>
    <tr>
      <td class="lmost5" width="20">&nbsp;</td>
      <td class ="lmost1" colspan=2 align="left">CSV - Importeinstellungen</td>
    </tr>
    <tr>
    <td class="lmost5" colspan="3">&nbsp;So sieht der zu importierende Spielplan aus: <a href='<?PHP echo $ximporturl;?>' target="_blank">URL zeigen</a></td>
  </tr>
    <tr>
      <td class="lmost5" width="20">&nbsp;</td>
      <td align="left"></td>
      <td class ="lmost5">&nbsp;</td>
    </tr>
    <tr>
      <td class="lmost5" width="20">&nbsp;</td>
      <td class="lmost5" align="right">CSV-Trennzeichen&nbsp;</td>
      <td class="lmost5" align="left"><input class="lmoadminein" type="text" name="csvchar" size="2" maxlength="1" value=<?PHP echo $csvchar; ?>>&nbsp;</td>
    </tr>
    <tr>
      <td class="lmost5" width="20">&nbsp;</td>
      <td class="lmost5" align="right">Spielplandaten&nbsp;</td>
      <td class="lmost5" align="left">beginnen ab Zeile&nbsp;<input class="lmoadminein" type="text" name="xoffset" size="2" maxlength="1" value=<?PHP echo $xoffset; ?>>&nbsp;</td>
    </tr>
    <tr>
      <td class="lmost5" width="20">&nbsp;</td>
      <td class="lmost5" align="right">1. Datenzeile enth&auml;lt&nbsp;</td>
      <td class="lmost5" align="left">Spaltentitel&nbsp;<input class="lmoadminein" type="checkbox" name="header" <?PHP if($header==1){echo " checked";} ?> value="1"></td>
    </tr>
    <tr>
      <td class="lmost5" width="20">&nbsp;</td>
      <td align="right"></td>
      <td ></td>
    </tr>

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
    <tr>
      <td class="lmost5" width="20">&nbsp;</td>
      <td align="right" class ="lmost5"></td>
      <td align="left" class ="lmost5">&nbsp;</td>
    </tr>
    <tr>
      <td class="lmost5" width="20">&nbsp;</td>
      <td align="left" colspan=2 class="lmost5"><input class="lmoadminbut" type="submit" name="vorschau" value="CSV-Vorschau">&nbsp;
        Vorschau mit
        <input class="lmoadminein" type="text" name="datarows" size="3" maxlength="3" value=<?PHP echo $datarows; ?>>
        Zeilen.</td>
    </tr>
    <tr>
      <td class="lmost5" width="20">&nbsp;</td>
      <td align="left" class ="lmost5" colspan=2>
      <input class="lmoadminein" type="checkbox" name="showall" <?PHP if($showall==1){echo " checked";} ?> value="1">&nbsp;nicht verwendete Spalten
        ausblenden&nbsp;</td>
    </tr>
    <tr>
      <td class="lmost5" colspan=3>
<?PHP
$prev="addon/limporter/lim-csv_preview.php?file=".$ximporturl."&pv=".$pv."&hd=".$header."&ch=".$csvchar."&all=".$showall;
$prev = $prev."&dr=".$datarows."&xoffset=".$xoffset."&c_nr=".$cols['NR'][0]."&c_h=".$cols['HEIM'][0]."&c_g=".$cols['GAST'][0]."&c_th=".$cols['THEIM'][0];
$prev = $prev."&c_tg=".$cols['TGAST'][0]."&c_d=".$cols['DATUM'][0]."&c_z=".$cols['ZEIT'][0]."&c_n=".$cols['NOTIZ'][0];
$prev = $prev."&f_nr=".$cols['NR'][1]."&f_h=".$cols['HEIM'][1]."&f_g=".$cols['GAST'][1]."&f_th=".$cols['THEIM'][1];
$prev = $prev."&f_tg=".$cols['TGAST'][1]."&f_d=".$cols['DATUM'][1]."&f_z=".$cols['ZEIT'][1]."&f_n=".$cols['NOTIZ'][1];
echo "<iframe src=\"".$prev."\" width=\"100%\" height=\"200\"></iframe>";
?>
      </td>
    </tr>