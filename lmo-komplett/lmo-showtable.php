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
  if(!isset($tabtype)){$tabtype=0;}
  if(($endtab>1) && ($tabtype==0 or $tabtype==3 or $tabtype==4) && ($tabdat!="")){
    $endtab--;
    require("lmo-calctable.php");
	
    $platz1 = array("");
    $platz1 = array_pad($array,$anzteams+1,"");
    for($x=0;$x<$anzteams;$x++){$x3=intval(substr($tab0[$x],34));$platz1[$x3]=$x+1;}
    $endtab++;
    }
  
  require("lmo-calctable.php");
  
  $platz0 = array("");
  $platz0 = array_pad($array,$anzteams+1,"");
  for($x=0;$x<$anzteams;$x++){$x3=intval(substr($tab0[$x],34));$platz0[$x3]=$x+1;}
  if($tabdat==""){$addt1=$PHP_SELF."?action=table&amp;file=".$file."&amp;tabtype=";}else{$addt1=$PHP_SELF."?action=table&amp;file=".$file."&amp;endtab=".$endtab."&amp;tabtype=";}
  $addt2=$PHP_SELF."?action=table&amp;file=".$file."&amp;tabtype=".$tabtype."&amp;endtab=";
?>

<table class="lmosta" cellspacing="0" cellpadding="0" border="0">
  <tr>
    <td align="center"><table cellspacing="0" cellpadding="0" border="0"><tr>
<?PHP
  $hoy1=1;
//  if ($tabtype==3){$hoy1=($anzst/2+1);}
  if ($tabtype<>3 and $tabtype<>4) {
  for($i=$hoy1;$i<=$anzst;$i++){
    echo "<td align=\"right\" ";
    if(($i!=$endtab) || (($i==$endtab) && ($tabdat==""))){
      echo "class=\"lmost0\"><a href=\"".$addt2.$i."\" title=\"".$text[45]."\">".$i."</a>";
      }
    else{
      echo "class=\"lmost1\">".$i;
      }
    echo "&nbsp;</td>";
    if(($anzst>49) && (($anzst%4)==0)){
      if(($i==$anzst/4) || ($i==$anzst/2) || ($i==$anzst/4*3)){echo "</tr><tr>";}
      }
    elseif(($anzst>38) && (($anzst%3)==0)){
      if(($i==$anzst/3) || ($i==$anzst/3*2)){echo "</tr><tr>";}
      }
    elseif(($anzst>29) && (($anzst%2)==0)){
      if($i==$anzst/2){echo "</tr><tr>";}
      }
    }
 }
?>
    <tr></table></td>
  </tr>
  <tr>
    <td align="center"><table cellspacing="0" cellpadding="0" border="0"><tr>
<?PHP
  for($i=0;$i<3;$i++){
    echo "<td ";
    if($i<>$tabtype){
      echo "class=\"lmost0\"><a href=\"".$addt1.$i."\" title=\"".$text[27+$i]."\">".$text[40+$i]."</a>";
      }
    else{
      echo "class=\"lmost1\">".$text[40+$i];
      }
    echo "&nbsp;</td>";
    }
 if ($einhinrueck==1) {
  echo "<td ";
  $i=$i+1;
  $addt1=$PHP_SELF."?action=table&amp;file=".$file."&amp;tabtype=";
  if($i<>$tabtype){
  echo "class=\"lmost0\"><a href=\"".$addt1.$i."\" title=\"".$text[1503]."\">".$text[1503]."</a>";
  	}
  else{
      echo "class=\"lmost1\">".$text[1503];
  	}	
  echo "&nbsp;</td>";
  
  echo "<td ";
  $i=$i-1;
  $addt1=$PHP_SELF."?action=table&amp;file=".$file."&amp;tabtype=";
  if($i<>$tabtype){
  echo "class=\"lmost0\"><a href=\"".$addt1.$i."\" title=\"".$text[1502]."\">".$text[1502]."</a>";
  	}
  else{
      echo "class=\"lmost1\">".$text[1502];
  	}
  echo "&nbsp;</td>";
  }
  if($minus==2){$dummy=" colspan=\"3\" align=\"center\"";}else{$dummy=" align=\"right\"";}
?>
    <tr></table></td>
  </tr>
  <tr><td align="center" class="lmost3"><table class="lmostb" cellspacing="0" cellpadding="0" border="0">
  <tr>
    <td class="lmost4" colspan="5"><?PHP echo $tabdat; ?></td>
    <td class="lmost4" width="2">&nbsp;</td>
    <td class="lmost4" align="right"><?PHP echo $text[33]; ?></td>
    <td class="lmost4" align="right"><?PHP echo $text[34]; ?></td>
    <?PHP if($hidr!=1){ echo"<td class=\"lmost4\" align=\"right\">".$text[35]."</td>"; } ?>
    <td class="lmost4" align="right"><?PHP echo $text[36]; ?></td>
    <?PHP if($tabpkt==0){ echo"<td class=\"lmost4\" width=\"2\">&nbsp;</td><td class=\"lmost4\"".$dummy.">".$text[37]."</td>"; } ?>
    <td class="lmost4" width="2">&nbsp;</td>
    <td class="lmost4" colspan="3" align="center"><?PHP echo $text[38]; ?></td>
    <td class="lmost4" align="right"><?PHP echo $text[39]; ?></td>
    <?PHP if($tabpkt==1){ echo"<td class=\"lmost4\" width=\"2\">&nbsp;</td><td class=\"lmost4\"".$dummy.">".$text[37]."</td>"; } ?>
  </tr>

<?PHP
  $j=1;
  for($x=1;$x<=$anzteams;$x++){
    $i=intval(substr($tab0[$x-1],34));
    if($i==$favteam){$dummy="<b>";$dumm2="</b>";}else{$dummy="";$dumm2="";}
    $dumm1="lmost5";
    if($tabtype==0 or $tabtype==3 or $tabtype==4){
      if(($x==1) && ($champ!=0)){$dumm1="lmotab1";$j=2;}
      if(($x>=$j) && ($x<$j+$anzcl) && ($anzcl>0)){$dumm1="lmotab2";}
      if(($x>=$j+$anzcl) && ($x<$j+$anzcl+$anzck) && ($anzck>0)){$dumm1="lmotab3";}
      if(($x>=$j+$anzcl+$anzck) && ($x<$j+$anzcl+$anzck+$anzuc) && ($anzuc>0)){$dumm1="lmotab4";}
      if(($x<=$anzteams) && ($x>$anzteams-$anzab) && ($anzab>0)){$dumm1="lmotab5";}
      if(($x<=$anzteams-$anzab) && ($x>$anzteams-$anzab-$anzar) && ($anzar>0)){$dumm1="lmotab8";}
      }
?>
  <tr>
    <td class="<?PHP echo $dumm1; ?>" align="right"><?PHP echo $dummy.$x.$dumm2; ?></td>
<?PHP
  $y=0;
  if(($endtab>1) && ($tabtype==0 or $tabtype==3 or $tabtype==4) && ($tabdat!="")){
    if($platz0[$i]<$platz1[$i]){$y=1;}
    elseif($platz0[$i]>$platz1[$i]){$y=2;}
    }
  if($tabdat!=""){
    echo "<td class=\"".$dumm1."\"";
    if($tabtype==0 or $tabtype==3 or $tabtype==4){echo "><img src=\"lmo-tab".$y.".gif\" width=\"9\" height=\"9\" border=\"0\">";}else{echo " width=\"2\">&nbsp;";}
    echo "</td>";
    }
  else{
    echo "<td class=\"".$dumm1."\">&nbsp;</td>";
    }
?>
    <td class="<?PHP echo $dumm1; ?>"><nobr>
<?PHP
  if(($teamu[$i]!="") && ($urlt==1)){echo "<a href=\"".$teamu[$i]."\" target=\"_blank\" title=\"".$text[46]."\">";}
  echo $dummy.$teams[$i].$dumm2;
  if(($teamu[$i]!="") && ($urlt==1)){echo "</a>";}
?>
    </nobr></td>
    <td class="<?PHP echo $dumm1; ?>" width="2">&nbsp;</td>
    <td class="<?PHP echo $dumm1; ?>">

<?PHP
  if(($teamn[$i]!="") || (($strafp[$i]!=0) || ($strafm[$i]!=0))){
    $dum27=addslashes($teams[$i]);
    if(($strafp[$i]!=0) || ($strafm[$i]!=0)){
      $dum27=$dum27."\\n\\n".$text[128].": ".$strafp[$i];
      if($minus==2){$dum27=$dum27.":".$strafm[$i];}
      }
    if($teamn[$i]!=""){$dum27=$dum27."\\n\\n".$text[22].":\\n".$teamn[$i];}
    echo "<a href=\"javascript:alert('".$dum27."');\" title=\"".str_replace("\\n","&#10;",$dum27)."\"><img src=\"lmo-st2.gif\" width=\"16\" height=\"16\" border=\"0\"></a>";
    }
  else{
    echo "&nbsp;";
    }
?>
    </td>
    <td class="<?PHP echo $dumm1; ?>" width="2">&nbsp;</td>
    <td class="<?PHP echo $dumm1; ?>" align="right"><?PHP echo $dummy.$spiele[$i].$dumm2; ?></td>
    <td class="<?PHP echo $dumm1; ?>" align="right"><?PHP echo $dummy.$siege[$i].$dumm2; ?></td>
<?PHP if($hidr!=1){ ?>
    <td class="<?PHP echo $dumm1; ?>" align="right"><?PHP echo $dummy.$unent[$i].$dumm2; ?></td>
<?PHP } ?>
    <td class="<?PHP echo $dumm1; ?>" align="right"><?PHP echo $dummy.$nieder[$i].$dumm2; ?></td>
<?PHP
    if($tabpkt==0){
      echo "<td class=\"".$dumm1."\" width=\"2\">&nbsp;</td><td class=\"".$dumm1."\" align=\"right\"><b>".$punkte[$i]."</b></td>";
      if($minus==2){
        echo "<td class=\"".$dumm1."\" align=\"center\" width=\"4\"><b>".":"."</b></td>";
        echo "<td class=\"".$dumm1."\"><b>".$negativ[$i]."</b></td>";
        }
      }
?>
    <td class="<?PHP echo $dumm1; ?>" width="2">&nbsp;</td>
    <td class="<?PHP echo $dumm1; ?>" align="right"><?PHP echo $dummy.$etore[$i].$dumm2; ?></td>
    <td class="<?PHP echo $dumm1; ?>" align="center" width="4"><?PHP echo $dummy; ?>:<?PHP echo $dumm2; ?></td>
    <td class="<?PHP echo $dumm1; ?>"><?PHP echo $dummy.$atore[$i].$dumm2; ?></td>
    <td class="<?PHP echo $dumm1; ?>" align="right"><?PHP echo $dummy.$dtore[$i].$dumm2; ?></td>
<?PHP
    if($tabpkt==1){
      echo "<td class=\"".$dumm1."\" width=\"2\">&nbsp;</td><td class=\"".$dumm1."\" align=\"right\"><b>".$punkte[$i]."</b></td>";
      if($minus==2){
        echo "<td class=\"".$dumm1."\" align=\"center\" width=\"4\"><b>".":"."</b></td>";
        echo "<td class=\"".$dumm1."\"><b>".$negativ[$i]."</b></td>";
        }
      }
?>
  </tr>
<?PHP } ?>

  </table>
  
<!-- * LMO-Zustat-Addon-Beginn	- Autor: Bernd Hoyer - eMail: info@salzland-info.de  -->
<tr>  
<td class="lmomain2" align="center">
<?PHP 
if ($einzutoretab==1) {
$strs=".l98";
$stre=".l98.php";
$str=basename($file);
$file16=str_replace($strs,$stre,$str);
$temp11=basename($zustatdir);
if (file_exists("$temp11/$file16")){
require("$temp11/$file16");

	if ($tabtype==0 && $endtab==$anzst) {
	echo $text[1500].$text[38].": ".$gzutore."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"." ".$text[38]."&nbsp;".$text[1501].": ".$gdstore;
	}
	if ($tabtype==1 && $endtab==$anzst) {
	echo $text[1510].$text[38].": ".$gheimtore."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"." ".$text[38]."&nbsp;".$text[1501].": ".$dsheimtore;
	}
	if ($tabtype==2 && $endtab==$anzst) {
	echo $text[1511].$text[38].": ".$ggasttore."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"." ".$text[38]."&nbsp;".$text[1501].": ".$dsgasttore;
	}

} 
}?>
</td>
</tr>
<!-- * LMO-Zustat-Addon-ENDE	- Autor: Bernd Hoyer - eMail: info@salzland-info.de -->	  
  
  </td></tr>
<?PHP if($tabdat!=""){ ?>
  <tr>
    <td><table width="100%" cellspacing="0" cellpadding="0" border="0"><tr>
<?PHP $st0=$endtab-1;if($endtab>1){echo "<td class=\"lmost2\"><a href=\"".$addt2.$st0."\" title=\"".$text[43]."\">".$text[5]."</a></td>";} ?>
<?PHP $st0=$endtab+1;if($endtab<$anzst){echo "<td align=\"right\" class=\"lmost2\"><a href=\"".$addt2.$st0."\" title=\"".$text[44]."\">".$text[7]."</a></td>";} ?>
    </tr></table>
	</td>
  </tr>
<?PHP } ?>
</table>

<?PHP } ?>
