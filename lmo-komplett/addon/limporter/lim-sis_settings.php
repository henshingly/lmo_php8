<?
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
if(!isset($xlrow)) {$xlrow=null;}
if(!isset($xoffset) or $xoffset<1){$xoffset=1;}
$offset = $xoffset - 1;
if(!isset($datarows) or ($datarows < 1) ){$datarows=10;}
if(isset($ximporturl)){

	$row = 0;
	$dataArray = buildFieldArray($ximporturl);
	$rows = array();
	$num = 0;
	$col = 0;
	foreach ($dataArray as $dataRow) {
		if ($row >= $offset) {
			$data = split("#",$dataRow);
		   	$rows[] = $data;
		    $num = count($data);
			if ($num>$col) $col = $num;
		}
		if ($xlrow>0 and $row > ($xlrow-2)) break;
		$row++;
	}
	for ($x=0;$x < count($rows);$x++) {
        $tmp = $rows[$x];
        $rows[$x] = array_pad($tmp,$col,"");
	}
}

?>
    <tr>
      <td class ="lmost5" colspan=3>&nbsp;</td>
    </tr>
    <tr>
      <td class="lmost5" width="20">&nbsp;</td>
      <td class ="active" colspan=2 align="left">HTML - Importeinstellungen</td>
    </tr>
    <tr>
      <td class="lmost5" width="20">&nbsp;</td>
      <td align="right">
&nbsp;Datenquelle: </td>
	  <td class="lmost5" align="left"><a href='<? echo $ximporturl;?>' target="_blank">Quelle zeigen</a></td>
  	</tr>
    <tr>
      <td class="lmost5" width="20">&nbsp;</td>
      <td align="right">
Spielplandaten&nbsp;</td>
      <td class="lmost5" align="left">Import von Zeile&nbsp;<input class="lmo-formular-input" type="text" name="xoffset" size="3" maxlength="3" value=<? echo $xoffset; ?>>&nbsp;-&nbsp;<input class="lmo-formular-input" type="text" name="xlrow" size="3" maxlength="3" value=<? echo $xlrow; ?>>&nbsp;</td>
    </tr>
    <tr>
      <td class="lmost5" width="20">&nbsp;</td>
      <td align="right">
</td>
      <td class="lmost5" align="left"><input class="lmo-formular-input" type="checkbox" name="header" <? if($header==1){echo " checked";} ?> value="1">&nbsp;1.&nbsp;Datenzeile&nbsp;enth&auml;lt&nbsp;Spaltentitel</td>
    </tr>
    <tr>
      <td class="lmost5" width="20">&nbsp;</td>
      <td align="right"></td>
      <td >&nbsp;</td>
    </tr>

    <tr>
      <td class="lmost5" width="20">&nbsp;</td>
      <td align="right" class ="lmost5">* Heimmannschaft&nbsp;</td>
      <td class ="lmost5" align="left">
		<?
 		colSelection("cols[HEIM][]",$cols['HEIM'][0],$rows[0],$header);
 		formatSelection("cols[HEIM][]",$cols['HEIM'][1],$limporter_formatKeys,$limporter_formatValues,$limporter_delimiter);
 		?>
      </td>
    </tr>
    <tr>
      <td class="lmost5" width="20">&nbsp;</td>
      <td align="right" class ="lmost5">* Gastmannschaft&nbsp;</td>
      <td class ="lmost5" align="left">
		<?
 		colSelection("cols[GAST][]",$cols['GAST'][0],$rows[0],$header);
 		formatSelection("cols[GAST][]",$cols['GAST'][1],$limporter_formatKeys,$limporter_formatValues,$limporter_delimiter);
 		?>
      </td>
    </tr>
    <tr>
      <td class="lmost5" width="20">&nbsp;</td>
      <td align="right" class ="lmost5">* Spieldatum&nbsp;</td>
      <td class ="lmost5" align="left">
		<?
 		colSelection("cols[DATUM][]",$cols['DATUM'][0],$rows[0],$header);
 		formatSelection("cols[DATUM][]",$cols['DATUM'][1],$limporter_formatKeys,$limporter_formatValues,$limporter_delimiter);
 		?>
      </td>
    </tr>
    <tr>
      <td class="lmost5" width="20">&nbsp;</td>
      <td align="right" class ="lmost5">Anpfiffzeit&nbsp;</td>
      <td class ="lmost5" align="left">
		<?
 		colSelection("cols[ZEIT][]",$cols['ZEIT'][0],$rows[0],$header);
 		formatSelection("cols[ZEIT][]",$cols['ZEIT'][1],$limporter_formatKeys,$limporter_formatValues,$limporter_delimiter);
 		?>
      </td>
    </tr>
    <tr>
      <td class="lmost5" width="20">&nbsp;</td>
      <td align="right" class ="lmost5">Tore Heim&nbsp;</td>
      <td class ="lmost5" align="left">
		<?
 		colSelection("cols[THEIM][]",$cols['THEIM'][0],$rows[0],$header);
 		formatSelection("cols[THEIM][]",$cols['THEIM'][1],$limporter_formatKeys,$limporter_formatValues,$limporter_delimiter);
 		?>
      </td>
    </tr>
    <tr>
      <td class="lmost5" width="20">&nbsp;</td>
      <td align="right" class ="lmost5">Tore Gast&nbsp;</td>
      <td class ="lmost5" align="left">
		<?
 		colSelection("cols[TGAST][]",$cols['TGAST'][0],$rows[0],$header);
 		formatSelection("cols[TGAST][]",$cols['TGAST'][1],$limporter_formatKeys,$limporter_formatValues,$limporter_delimiter);
		?>

      </td>
    </tr>
    <tr>
      <td class="lmost5" width="20">&nbsp;</td>
      <td align="right" class ="lmost5">Spielnummer&nbsp;</td>
      <td class ="lmost5" align="left">
		<?
 		colSelection("cols[NR][]",$cols['NR'][0],$rows[0],$header);
 		formatSelection("cols[NR][]",$cols['NR'][1],$limporter_formatKeys,$limporter_formatValues,$limporter_delimiter);
		?>
      </td>
    </tr>
    <tr>
      <td class="lmost5" width="20">&nbsp;</td>
      <td align="right" class ="lmost5">Notiz&nbsp;</td>
      <td class ="lmost5" align="left">
		<?
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
      <td align="left" colspan=2 class="lmost5"><input class="lmo-formular-button" type="submit" name="vorschau" value="Vorschau">&nbsp;&nbsp;nicht verwendete Spalten ausblenden&nbsp;<input class="lmo-formular-input" type="checkbox" name="showall" <? if($showall==1){echo " checked";} ?> value="1">
    </tr>
    <tr>
      <td colspan=3 class="lmost5">
<?
$prev="addon/limporter/lim-sis_preview.php?file=".$ximporturl."&pv=".$pv."&hd=".$header."&ch=".$csvchar."&all=".$showall."&dr=".$datarows;
$prev = $prev."&xoffset=".$xoffset."&xlrow=".$xlrow."&c_nr=".$cols['NR'][0]."&c_h=".$cols['HEIM'][0]."&c_g=".$cols['GAST'][0]."&c_th=".$cols['THEIM'][0];
$prev = $prev."&c_tg=".$cols['TGAST'][0]."&c_d=".$cols['DATUM'][0]."&c_z=".$cols['ZEIT'][0]."&c_n=".$cols['NOTIZ'][0];
$prev = $prev."&f_nr=".$cols['NR'][1]."&f_h=".$cols['HEIM'][1]."&f_g=".$cols['GAST'][1]."&f_th=".$cols['THEIM'][1];
$prev = $prev."&f_tg=".$cols['TGAST'][1]."&f_d=".$cols['DATUM'][1]."&f_z=".$cols['ZEIT'][1]."&f_n=".$cols['NOTIZ'][1];
echo "<iframe src=\"".$prev."\" width=\"100%\" height=\"200\"></iframe>";
?>
      </td>
    </tr>