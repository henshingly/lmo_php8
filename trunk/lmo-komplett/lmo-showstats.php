<?PHP
// 
// LigaManager Online 3.02b
// Copyright (C) 1997-2002 by Frank Hollwitz
// webmaster@hollwitz.de / http://php.hollwitz.de
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
if($file!=""){
  $adds=$PHP_SELF."?action=stats&amp;file=".$file."&amp;stat1=";
  $addr=$PHP_SELF."?action=results&amp;file=".$file."&amp;st=";
?>

<table class="lmosta" cellspacing="0" cellpadding="0" border="0">
  <tr>
    <td valign="top" align="center"><table cellspacing="0" cellpadding="0" border="0">
<?PHP
  for($i=1;$i<=$anzteams;$i++){
    echo "<tr><td align=\"center\" ";
    if($i<>$stat1){
      echo "class=\"lmost0\"><a href=\"".$adds.$i."&amp;stat2=".$stat2."\" title=\"".$text[57]." ".$teams[$i]."\">".$teamk[$i]."</a>";
      }
    else{
      echo "class=\"lmost1\">".$teamk[$i];
      }
    echo "</td></tr>";
    }
?>
    </table></td>
    <td valign="top" align="center" class="lmost3"><table class="lmostb" cellspacing="0" cellpadding="0" border="0">

<?PHP
  if($stat1==0){
    echo "<tr><td align=\"center\" class=\"lmost5\">&nbsp;<br>".$text[24]."<br>&nbsp;</td></tr>";
    }
  else{
    $endtab=$anzst;
    require("lmo-calctable.php");
    $platz0 = array("");
    $platz0 = array_pad($array,$anzteams+1,"");
    for($x=0;$x<$anzteams;$x++){$platz0[intval(substr($tab0[$x],34))]=$x+1;}
?>
      <tr>
        <td valign="top" align="right" class="lmost4"><?PHP echo $teams[$stat1]; ?></td>
        <td valign="top" align="center" class="lmost4">&nbsp;</td>
        <?PHP if($stat2>0){ ?><td valign="top" class="lmost4"><?PHP echo $teams[$stat2]; ?></td><?PHP } ?>
      </tr>
<?PHP if($stat2>0){$dummy=" align=\"center\"";}else{$dummy="";} ?>
<?PHP
  $serie1="&nbsp;";
  if($ser1[$stat1]>0){$serie1=$ser1[$stat1]." ".$text[474]."<br>".$ser2[$stat1]." ".$text[75];}
  elseif($ser3[$stat1]>0){$serie1=$ser3[$stat1]." ".$text[475]."<br>".$ser4[$stat1]." ".$text[76];}
  elseif($ser2[$stat1]>=$ser4[$stat1]){$serie1=$ser2[$stat1]." ".$text[75];}
  else{$serie1=$ser4[$stat1]." ".$text[76];}
if($stat2>0){
  $chg1="k.A.";
  $chg2="k.A.";
  if(($spiele[$stat1])&&($spiele[$stat2])){
$a=(100*$siege[$stat1]/$spiele[$stat1])+(100*$nieder[$stat2]/$spiele[$stat2]);
$b=(100*$siege[$stat2]/$spiele[$stat2])+(100*$nieder[$stat1]/$spiele[$stat1]);
$c=($etore[$stat1]/$spiele[$stat1])+($atore[$stat2]/$spiele[$stat2]);
$d=($etore[$stat2]/$spiele[$stat2])+($atore[$stat1]/$spiele[$stat1]);
}

  $e=$a+$b;
  $f=$c+$d;
  if(($e>0) && ($f>0)){
    $a=round(10000*$a/$e);
    $b=round(10000*$b/$e);
    $c=round(10000*$c/$f);
    $d=round(10000*$d/$f);
    $chg1=number_format((($a+$c)/200),2,",",".");
    $chg2=number_format((($b+$d)/200),2,",",".");
    }
  $serie2="&nbsp;";
  if($ser1[$stat2]>0){$serie2=$ser1[$stat2]." ".$text[474]."<br>".$ser2[$stat2]." ".$text[75];}
  elseif($ser3[$stat2]>0){$serie2=$ser3[$stat2]." ".$text[475]."<br>".$ser4[$stat2]." ".$text[76];}
  elseif($ser2[$stat2]>=$ser4[$stat2]){$serie2=$ser2[$stat2]." ".$text[75];}
  else{$serie2=$ser4[$stat2]." ".$text[76];}
?>
      <tr>
        <td valign="top" align="right" class="lmost5"><?PHP echo $chg1; ?>%</td>
        <td valign="top" class="lmost4"<?PHP echo $dummy; ?>><?PHP echo $text[60]; ?></td>
        <td valign="top" class="lmost5"><?PHP echo $chg2; ?>%</td>
      </tr>
<?PHP } ?>
      <tr>
        <td valign="top" align="right" class="lmost5"><?PHP echo $platz0[$stat1]; ?></td>
        <td valign="top" class="lmost4"<?PHP echo $dummy; ?>><?PHP echo $text[61]; ?></td>
        <?PHP if($stat2>0){ ?><td valign="top" class="lmost5"><?PHP echo $platz0[$stat2]; ?></td><?PHP } ?>
      </tr>
      <tr>
        <td valign="top" align="right" class="lmost5"><?PHP echo $punkte[$stat1]; if($minus==2){":".$negativ[$stat1];} ?></td>
        <td valign="top" class="lmost4"<?PHP echo $dummy; ?>><?PHP echo $text[37]; ?></td>
        <?PHP if($stat2>0){ ?><td valign="top" class="lmost5"><?PHP echo $punkte[$stat2]; if($minus==2){":".$negativ[$stat2];} ?></td><?PHP } ?>
      </tr>
      <tr>
        <td valign="top" align="right" class="lmost5"><?PHP echo $spiele[$stat1]; ?></td>
        <td valign="top" class="lmost4"<?PHP echo $dummy; ?>><?PHP echo $text[63]; ?></td>
        <?PHP if($stat2>0){ ?><td valign="top" class="lmost5"><?PHP echo $spiele[$stat2]; ?></td><?PHP } ?>
      </tr>
      <tr>
        <td valign="top" align="right" class="lmost5"><?PHP if($spiele[$stat1]){echo number_format($punkte[$stat1]/$spiele[$stat1],2,",","."); if($minus==2){":".number_format($negativ[$stat1]/$spiele[$stat1],2,",",".");}} ?></td>

        <td valign="top" class="lmost4"<?PHP echo $dummy; ?>><?PHP echo $text[37].$text[64]; ?></td>
        <?PHP if($stat2>0){if($spiele[$stat2]){ ?><td valign="top" class="lmost5"><?PHP echo number_format($punkte[$stat2]/$spiele[$stat2],2,",","."); if($minus==2){":".number_format($negativ[$stat2]/$spiele[$stat2],2,",",".");}} ?></td><?PHP } ?>

      </tr>
      <tr>
        <td valign="top" align="right" class="lmost5"><?PHP echo $etore[$stat1].":".$atore[$stat1]; ?></td>
        <td valign="top" class="lmost4"<?PHP echo $dummy; ?>><?PHP echo $text[38]; ?></td>
        <?PHP if($stat2>0){ ?><td valign="top" class="lmost5"><?PHP echo $etore[$stat2].":".$atore[$stat2]; ?></td><?PHP } ?>
      </tr>
      <tr>
        <td valign="top" align="right" class="lmost5"><?PHP if($spiele[$stat1]){ echo number_format($etore[$stat1]/$spiele[$stat1],2,",",".").":".number_format($atore[$stat1]/$spiele[$stat1],2,",",".");} ?></td>
        <td valign="top" class="lmost4"<?PHP echo $dummy; ?>><?PHP echo $text[38].$text[64]; ?></td>
        <?PHP if($stat2>0){ ?><td valign="top" class="lmost5"><?PHP if($spiele[$stat2]){ echo number_format($etore[$stat2]/$spiele[$stat2],2,",",".").":".number_format($atore[$stat2]/$spiele[$stat2],2,",",".");} ?></td><?PHP } ?>
      </tr>
      <tr>
        <td valign="top" align="right" class="lmost5"><?PHP if($spiele[$stat1]){echo $siege[$stat1]." (".number_format($siege[$stat1]*100/$spiele[$stat1],2,",",".")."%)";} ?></td>
        <td valign="top" class="lmost4"<?PHP echo $dummy; ?>><?PHP echo $text[67]; ?></td>
        <?PHP if($stat2>0){ ?><td valign="top" class="lmost5"><?PHP if($spiele[$stat2]){echo $siege[$stat2]." (".number_format($siege[$stat2]*100/$spiele[$stat2],2,",",".")."%)";} ?></td><?PHP } ?>
      </tr>
      <tr>
        <td valign="top" align="right" class="lmost5"><?PHP echo $maxs0[$stat1]; ?></td>
        <td valign="top" class="lmost4"<?PHP echo $dummy; ?>><?PHP echo $text[68]; ?></td>
        <?PHP if($stat2>0){ ?><td valign="top" class="lmost5"><?PHP echo $maxs0[$stat2]; ?></td><?PHP } ?>
      </tr>
      <tr>
        <td valign="top" align="right" class="lmost5"><?PHP if($spiele[$stat1]){echo $nieder[$stat1]." (".number_format($nieder[$stat1]*100/$spiele[$stat1],2,",",".")."%)";} ?></td>
        <td valign="top" class="lmost4"<?PHP echo $dummy; ?>><?PHP echo $text[69]; ?></td>
        <?PHP if($stat2>0){ ?><td valign="top" class="lmost5"><?PHP if($spiele[$stat2]){echo $nieder[$stat2]." (".number_format($nieder[$stat2]*100/$spiele[$stat2],2,",",".")."%)";} ?></td><?PHP } ?>
      </tr>
      <tr>
        <td valign="top" align="right" class="lmost5"><?PHP echo $maxn0[$stat1]; ?></td>
        <td valign="top" class="lmost4"<?PHP echo $dummy; ?>><?PHP echo $text[70]; ?></td>
        <?PHP if($stat2>0){ ?><td valign="top" class="lmost5"><?PHP echo $maxn0[$stat2]; ?></td><?PHP } ?>
      </tr>
      <tr>
        <td valign="top" align="right" class="lmost5"><?PHP echo $serie1; ?></td>
        <td valign="top" class="lmost4"<?PHP echo $dummy; ?>><?PHP echo $text[71]; ?></td>
        <?PHP if($stat2>0){ ?><td valign="top" class="lmost5"><?PHP echo $serie2; ?></td><?PHP } ?>
      </tr>
<?PHP
    }
?>
    </table></td>
    <td valign="top" align="center"><table cellspacing="0" cellpadding="0" border="0">
<?PHP
  for($j=0;$j<=$anzteams;$j++){
    $i=$j+1;
    if($i>$anzteams){$i=0;}
    if($i==0){$dummy=$text[59];}else{$dummy=$text[58]." ".$teams[$i];}
    echo "<tr><td align=\"center\" ";
    if($i<>$stat2){
      echo "class=\"lmost0\"><a href=\"".$adds.$stat1."&amp;stat2=".$i."\" title=\"".$dummy."\">".$teamk[$i]."</a>";
      }
    else{
      echo "class=\"lmost1\">".$teamk[$i];
      }
    echo "</td></tr>";
    }
?>
    </table></td>
  </tr>
</table>


<!-- * LMO-Zustat-Addon-Beginn	- Autor: Bernd Hoyer - eMail: info@salzland-info.de -->
<table class="lmostc" width="100%" cellspacing="0" cellpadding="0" border="0">

<?PHP
require("lmo-zustat-config.php");
if ($einzustats==1) {  
$strs=".l98";
$stre=".l98.php";
$str=basename($file);
$file16=str_replace($strs,$stre,$str);
$temp11=basename($zustatdir);
if (file_exists("$temp11/$file16")){
require("$temp11/$file16");

echo "<br>"."<tr><td class=\"lmost1\" align=\"center\"> ".$text[1509]."</td></tr>";?>

<table class="lmosta" width="100%" align="center" cellspacing="0" cellpadding="0" border="0">
<?PHP
echo "<tr><td class=\"lmost5\"  align=\"right\">";
echo "&nbsp;".$text[1500].$text[38].":"."&nbsp;&nbsp;&nbsp;&nbsp;"."</td>"."<td class=\"lmost5\"  align=\"left\">".$gzutore."&nbsp;"."</td>"."<td class=\"lmost5\"  align=\"left\">".$text[38]."&nbsp;".$text[1501].":"."&nbsp;&nbsp;".$gdstore."&nbsp;"."</td></tr>";
echo "<tr><td class=\"lmost5\"  align=\"right\">";
echo "&nbsp;".$text[1510].$text[38].":"."&nbsp;&nbsp;&nbsp;&nbsp;"."</td>"."<td class=\"lmost5\"  align=\"left\">".$gheimtore."&nbsp;"."</td>"."<td class=\"lmost5\"  align=\"left\">".$text[38]."&nbsp;".$text[1501].":"."&nbsp;&nbsp;".$dsheimtore."&nbsp;"."</td></tr>";
echo "<tr><td class=\"lmost5\"  align=\"right\">";
echo "&nbsp;".$text[1511].$text[38].":"."&nbsp;&nbsp;&nbsp;&nbsp;"."</td>"."<td class=\"lmost5\"  align=\"left\">".$ggasttore."&nbsp;"."</td>"."<td class=\"lmost5\"  align=\"left\">".$text[38]."&nbsp;".$text[1501].":"."&nbsp;&nbsp;".$dsgasttore."&nbsp;"."</td></tr>";
echo "<tr><td class=\"lmost5\"  align=\"right\">";
echo "&nbsp;".$text[1506].":"."&nbsp;&nbsp;&nbsp;&nbsp;"."</td>"."<td class=\"lmost5\"  align=\"left\">".$gzusieg1."&nbsp;"."</td>"."<td class=\"lmost5\"  align=\"left\">"."</td></tr>";
echo "<tr><td class=\"lmost5\" align=\"right\">";
echo "&nbsp;".$text[1507].":"."&nbsp;&nbsp;&nbsp;&nbsp;"."</td>"."<td class=\"lmost5\"  align=\"left\">".$gzusieg2."&nbsp;"."</td>"."<td class=\"lmost5\"  align=\"left\">"."</td></tr>";
echo "<tr><td class=\"lmost5\"  align=\"right\">";
echo "&nbsp;".$text[1508].":"."&nbsp;&nbsp;&nbsp;&nbsp;"."</td>"."<td class=\"lmost5\"  align=\"left\">".$gzuunent."&nbsp;"."</td>"."<td class=\"lmost5\"  align=\"left\">"."</td></tr>";
echo "<tr><td class=\"lmost5\"  align=\"right\">";
echo "&nbsp;".$text[1512].":"."&nbsp;&nbsp;&nbsp;&nbsp;"."</td>"."<td class=\"lmost5\"  align=\"left\">".$gbeide."&nbsp;"."</td>"."<td class=\"lmost5\"  align=\"left\">"."</td></tr>";
echo "<tr><td class=\"lmost5\"  align=\"right\">";
echo "&nbsp;".$text[1513].":"."&nbsp;&nbsp;&nbsp;&nbsp;"."</td>"."<td class=\"lmost5\"  align=\"left\">".$hheimsieg." - ".$hgastsieg."</td>"."<td class=\"lmost5\"  align=\"left\">".$hheimsiegtor.":".$hgastsiegtor."&nbsp;(".$text[1514]."&nbsp;".$spieltagflag.")&nbsp;"."</td></tr>";
if ($hheimsiegtor1>0) {
echo "<tr><td class=\"lmost5\"  align=\"right\">";
echo "&nbsp;"."&nbsp;&nbsp;&nbsp;&nbsp;"."</td>"."<td class=\"lmost5\"  align=\"left\">".$hheimsieg1." - ".$hgastsieg1."</td>"."<td class=\"lmost5\"  align=\"left\">".$hheimsiegtor1.":".$hgastsiegtor1."&nbsp;(".$text[1514]."&nbsp;".$spieltagflag1.")&nbsp;"."</td></tr>";
	if ($counteranz>2) {
	$counteranz0=$counteranz-2;
	echo "<tr><td class=\"lmost5\"  align=\"right\">";
	echo "&nbsp;"."&nbsp;&nbsp;&nbsp;&nbsp;"."</td>"."<td class=\"lmost5\"  align=\"left\">".$text[1515]."&nbsp;".$counteranz0."&nbsp;".$text[1516]."</td>"."<td class=\"lmost5\"  align=\"left\">"."</td></tr>";
	}
}
echo "<tr><td class=\"lmost5\"  align=\"right\">";
echo "&nbsp;".$text[1517].":"."&nbsp;&nbsp;&nbsp;&nbsp;"."</td>"."<td class=\"lmost5\"  align=\"left\">".$aheimsieg." - ".$agastsieg."</td>"."<td class=\"lmost5\"  align=\"left\">".$aheimsiegtor.":".$agastsiegtor."&nbsp;(".$text[1514]."&nbsp;".$spieltagflag2.")&nbsp;"."</td></tr>";
if ($agastsiegtor1>0) {
echo "<tr><td class=\"lmost5\"  align=\"right\">";
echo "&nbsp;"."&nbsp;&nbsp;&nbsp;&nbsp;"."</td>"."<td class=\"lmost5\"  align=\"left\">".$aheimsieg1." - ".$agastsieg1."</td>"."<td class=\"lmost5\"  align=\"left\">".$aheimsiegtor1.":".$agastsiegtor1."&nbsp;(".$text[1514]."&nbsp;".$spieltagflag3.")&nbsp;"."</td></tr>";
	if ($counteranz1>2) {
	$counteranz4=$counteranz1-2;
	echo "<tr><td class=\"lmost5\"  align=\"right\">";
	echo "&nbsp;"."&nbsp;&nbsp;&nbsp;&nbsp;"."</td>"."<td class=\"lmost5\"  align=\"left\">".$text[1515]."&nbsp;".$counteranz4."&nbsp;".$text[1516]."</td>"."<td class=\"lmost5\"  align=\"left\">"."</td></tr>";
	}
}
echo "<tr><td class=\"lmost5\"  align=\"right\">";
echo "&nbsp;".$text[1518]."&nbsp;".$text[38].":"."&nbsp;&nbsp;&nbsp;&nbsp;"."</td>"."<td class=\"lmost5\"  align=\"left\">".$htorreichm1." - ".$htorreichm2."</td>"."<td class=\"lmost5\"  align=\"left\">".$htorreicht1.":".$htorreicht2."&nbsp;(".$text[1514]."&nbsp;".$spieltagflag4.")&nbsp;"."</td></tr>";
if ($spieltagflag5<>0) {
echo "<tr><td class=\"lmost5\"  align=\"right\">";
echo "&nbsp;"."&nbsp;&nbsp;&nbsp;&nbsp;"."</td>"."<td class=\"lmost5\"  align=\"left\">".$htorreichm3." - ".$htorreichm4."</td>"."<td class=\"lmost5\"  align=\"left\">".$htorreicht3.":".$htorreicht4."&nbsp;(".$text[1514]."&nbsp;".$spieltagflag5.")&nbsp;"."</td></tr>";
	if ($counteranz5>2) {
	$counteranz6=$counteranz5-2;
	echo "<tr><td class=\"lmost5\"  align=\"right\">";
	echo "&nbsp;"."&nbsp;&nbsp;&nbsp;&nbsp;"."</td>"."<td class=\"lmost5\"  align=\"left\">".$text[1515]."&nbsp;".$counteranz6."&nbsp;".$text[1519]."</td>"."<td class=\"lmost5\"  align=\"left\">"."</td></tr>";
	}
}
}
} ?>
</table>
<!-- * LMO-Zustat-Addon-ENDE	- Autor: Bernd Hoyer - eMail: info@salzland-info.de -->


<?PHP } ?>
