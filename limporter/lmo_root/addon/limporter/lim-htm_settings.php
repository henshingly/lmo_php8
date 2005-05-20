<?PHP
//
// Limporter Version 1.0
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

if(!isset($header)){$header="0";}
if(!isset($xdetailsCheck)){$xdetailsCheck=0;}
if(!isset($showall)){$showall="0";}
if(!isset($csvchar)){$csvchar=";";}
if(!isset($xlrow)) {$xlrow=null;}
if(!isset($xoffset) or $xoffset<1){$xoffset=1;}
$offset = $xoffset - 1;
if(!isset($datarows) or ($datarows < 1) ){$datarows=10;}
if(isset($ximporturl)){
	$imporUrlLink = $ximporturl;
	$urlArray = parse_url ( $imporUrlLink);
//	$imporUrlLink =isset($urlArray["host"])?$ximporturl:URL_TO_LMO."/".$dirliga;
	if (isset($urlArray["host"])) {
		$imporUrlLink = $ximporturl;
		}
	else {
		$urlArray = explode($dirliga,$ximporturl);
		$imporUrlLink = URL_TO_LMO."/".$dirliga.$urlArray[1];
	}
	$row = 0;
	$dataArray = buildFieldArray($ximporturl,$xdetailsCheck);
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
      <td class="lmost5" width="20">&nbsp;</td>
      <td class ="lmost5" colspan=2 align="left"><?PHP echo $text['limporter'][59]; ?></td>
    </tr>
    <tr>
      <td class="lmost5" width="20">&nbsp;</td>
      <td class="lmost5" align="right">&nbsp;</td>
      <td class="lmost5" align="left"><?PHP echo $text['limporter'][51]; ?>&nbsp;<input class="lmo-formular-input" type="text" name="xoffset" size="3" maxlength="3" value=<?PHP echo $xoffset; ?>>&nbsp;-&nbsp;<input class="lmo-formular-input" type="text" name="xlrow" size="3" maxlength="3" value=<?PHP echo $xlrow; ?>>&nbsp;<a href='<?PHP echo $imporUrlLink;?>' target="_blank"><?PHP echo $text['limporter'][52] ?></a></td>
    </tr>
    <tr>
      <td class="lmost5" width="20">&nbsp;</td>
      <td class="lmost5" align="right"></td>
      <td class="lmost5" align="left"><input class="lmo-formular-input" type="checkbox" name="header" <?PHP if($header==1){echo " checked";} ?> value="1">&nbsp;<?PHP echo $text['limporter'][53]; ?></td>
    </tr>
    <tr>
      <td class="lmost5" width="20">&nbsp;</td>
      <td class="lmost5" align="right"></td>
      <td class="lmost5" align="left"><input class="lmo-formular-input" type="checkbox" name="xdetailsCheck" <?PHP if($xdetailsCheck==1){echo " checked";} ?> value="1">&nbsp;<?PHP echo $text['limporter'][54]; ?></td>
    </tr>
		<?PHP include(PATH_TO_ADDONDIR."/limporter/lim-colums_select.php");?>
    <tr>
      <td class="lmost5" width="20">&nbsp;</td>
      <td align="left" colspan=2 class="lmost5"><input class="lmo-formular-button" type="submit" name="vorschau" value="<?PHP echo $text['limporter'][57]; ?>">&nbsp;&nbsp;<?PHP echo $text['limporter'][55]; ?>&nbsp;<input class="lmo-formular-input" type="checkbox" name="showall" <?PHP if($showall==1){echo " checked";} ?> value="1">
    </tr>
    <tr>
      <td colspan=3 class="lmost5">
<?PHP
$prev="addon/limporter/lim-htm_preview.php?file="
		.$limporter_importDir."/".$fileName
		."&pv=".$pv."&hd=".$header."&cdetails=".$xdetailsCheck."&ch=".$csvchar
		."&all=".$showall."&dr=".$datarows;
$prev = $prev."&xoffset=".$xoffset."&xlrow=".$xlrow.settingsLink($cols);
echo "<iframe src=\"".$prev."\" width=\"750\" height=\"250\"></iframe>";
?>
      </td>
    </tr>