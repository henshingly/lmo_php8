<?
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

$regExpArray = split($limporter_delimiter,$limporter_formatValues);
?>
<html>
<head>
<title>LIM HTML-Importer</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<style type="text/css">
<!--
.csvtablebody { font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10px; color: #000000; border: #000000 solid; background-color: #CCCCCC; border-width: 1px 1px 1px 1px; line-height: 12px}
.csvtable { font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10px; color: #000000; border: #000000 solid; background-color: #CCCCCC; border-width: 0px 1px 1px 0px; line-height: 12px}
.csvtableheader { font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10px; color: #000000; border: 1px #000000 solid; background-color: #999999; border-width: 0px 1px 1px 0px; line-height: 12px}
.csvtableheaderrow { font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10px; color: #999999; border: 1px #000000 solid; background-color: #CCCCCC; border-width: 0px 1px 1px 0px; line-height: 12px}
.headerText { font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10px; color: #FFFF00}
.formelement {  font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 9px; color: #FFFF00; background-color: #999999}
.textfeld { font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 9px; color: #000000; background-color: #CCCCCC}

-->
</style>
</head>
<body leftmargin="1" topmargin="1" class="csvtablebody">
<?
if( isset($HTTP_GET_VARS)) {
  	reset ($HTTP_GET_VARS);
  	foreach ($HTTP_GET_VARS as $k=>$elem) {
  		if(!(strpos($k,"c_",0)===false)) $showColum[]=$elem;
//		echo "\n<BR>colums $k =".$elem;
//		${"$k"}=$elem;
	}
}

if(!isset($all)){$all=0;}
if(!isset($hd)){$hd=0;}
if(!isset($ch)){$ch=";";}
if(!isset($pv)){$pv="0";}
if(!isset($dr) or ($dr < 1) ){$dr=10;}
if(!isset($xoffset) or $xoffset<1){$xoffset=1;}
$offset = $xoffset - 1;

if($c_h >-1 and isset($f_h)) $formats["\"".$c_h."\""][] = $f_h;
if($c_g >-1 and isset($f_g)) $formats["\"".$c_g."\""][] = $f_g;
if($c_th >-1 and isset($f_th)) $formats["\"".$c_th."\""][] = $f_th;
if($c_tg >-1 and isset($f_tg)) $formats["\"".$c_tg."\""][] = $f_tg;
if($c_d >-1 and isset($f_d)) $formats["\"".$c_d."\""][] = $f_d;
if($c_n >-1 and isset($f_n)) $formats["\"".$c_n."\""][] = $f_n;
if($c_nr >-1 and isset($f_nr)) $formats["\"".$c_nr."\""][] = $f_nr;
if($c_z >-1 and isset($f_z)) $formats["\"".$c_z."\""][] = $f_z;

$rows = array();
$row = 0;
$num = 0;
$col = 0;

if(isset($file) and ($pv==1)){
	$dataArray = buildFieldArray($file);
	foreach ($dataArray as $dataRow) {
		if ($row >= $offset) {
			$data = split("#",$dataRow);
		   	$rows[] = $data;
		    $num = count($data);
			if ($num>$col) $col = $num;
		}
		if ($xlrow>0 and $row > ($xlrow)-2) break;
		$row++;
	}
	for ($x=0;$x < count($rows);$x++) {
        $tmp = $rows[$x];
        $rows[$x] = array_pad($tmp,$col,"");
	}

?>

<table width="650" border="1" cellspacing="0" cellpadding="1" class="csvtablebody">
  <tr>
  	<td width="48" class="csvtableheader" colspan=2>&nbsp;</td>

<?
 for ($i=0;$i<$col;$i++) {
    echo "<td class=\"csvtableheader\" align=\"center\">";
        $spTitel = "";
        if($c_h==$i)	{$spTitel = $spTitel."&nbsp;<B>HEIMMANNSCHAFT</B>&nbsp;";}
        if($c_g==$i)	{$spTitel = $spTitel."&nbsp;<B>GASTMANNSCHAFT</B>&nbsp;";}
        if($c_th==$i)	{$spTitel = $spTitel."&nbsp;<B>TORE&nbsp;HEIM</B>&nbsp;";}
        if($c_tg==$i)	{$spTitel = $spTitel."&nbsp;<B>TORE&nbsp;GAST</B>&nbsp;";}
        if($c_d==$i)	{$spTitel = $spTitel."&nbsp;<B>DATUM</B>&nbsp;";}
        if($c_z==$i)	{$spTitel = $spTitel."&nbsp;<B>UHRZEIT</B>&nbsp;";}
        if($c_n==$i)	{$spTitel = $spTitel."&nbsp;<B>NOTIZ</B>&nbsp;";}
        if($c_nr==$i)	{$spTitel = $spTitel."&nbsp;<B>SPIELNR</B>&nbsp;";}
        if($spTitel == "") {
        	if($all==1){$spTitel=".";}
        	else {
        		if ($hd==1 and $rows[0][$i]!="") {$spTitel=$rows[0][$i];}
        		else {$spTitel="Spalte&nbsp;".($i+1);} // Für die Anzeige fangen wir bei 1 an
             	}
        }
        echo $spTitel;

	echo "</td>\n";

 } // for SChleife
	echo "</tr>\n";

	$y = 1; // Zeilencounter
	foreach ($rows as $row) {
        if($y != $hd) {
            echo "<tr><td class='csvtableheader' colspan=2 align='center'>z".($y+$offset)."</td>";
            $x = 0;// Spaltencounter;
            foreach ($row as $value) {
                if($y == $hd) echo "<td class='csvtableheaderrow'>";
                else echo "<td class='csvtable'>";

                if ($all==0 or in_array($x,$showColum) ) {
                	echo $value."<BR>";
					if (in_array($x,$showColum)) {
                        $ergebnis="";

                        $format = $formats["\"".$x."\""];
                        if (!isset($format)) $format = array(0);
                        foreach ($format as $expr) {
                            if ($expr > 0) {
                                $myRegEx =$regExpArray[$expr-1];
                                if(preg_match($myRegEx,$value,$array)) {
                                    $ergebnis=$ergebnis." ".$array[1];
                                }
                            }
                            else {
                                 $ergebnis=$ergebnis." ".$value;
                            }
                        }

                        echo "<nobr><B>".$ergebnis."</B></nobr>";
                    }
                }
                echo "&nbsp;</td>\n";
                $x++;
            }
            echo "</tr>\n";
        }
		$y++;
	}
} // isset($file)
else {

	echo "<BR>CSV - IMPORTER <BR>";
	echo "<BR>Make Settings and Press VORSCHAU for preview";
	echo "<BR>Confirm your Settings and PRESS ";


}
?>
</table>
</body>
</html>