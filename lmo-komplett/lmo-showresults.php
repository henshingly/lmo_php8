<?
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
  $addp=$_SERVER['PHP_SELF']."?action=program&amp;file=".$file."&amp;selteam=";
  $addr=$_SERVER['PHP_SELF']."?action=results&amp;file=".$file."&amp;st=";
  $breite=10;
  if($spez==1){$breite=$breite+2;}
  if($datm==1){$breite=$breite+1;}
?>

<table class="lmosta" cellspacing="0" cellpadding="0" border="0">
  <tr>
    <td align="center"><? include(PATH_TO_LMO."/lmo-spieltagsmenu.php")?></td>
  </tr>
  <tr><td align="center" class="lmost3"><table class="lmostb" cellspacing="0" cellpadding="0" border="0"><tr>
    <td class="lmost4" colspan="<? echo $breite; ?>"><? echo $st; ?>. <? echo $text[2]; ?>
<?if($dats==1){  
    if($datum1[$st-1]!=""){echo " ".$text[3]." ".$datum1[$st-1];} 
    if($datum2[$st-1]!=""){echo " ".$text[4]." ".$datum2[$st-1];} 
  }?>
    </td>
  </tr>

<?PHP
$datsort= $mterm[$st-1];
asort($datsort);
reset($datsort);
while (list ($key, $val) = each ($datsort)) {
$i=$key;
if(($teama[$st-1][$i]>0) && ($teamb[$st-1][$i]>0)){ ?>
  <tr>

<?  if($datm==1){
  if($mterm[$st-1][$i]>0){$dum1=strftime($datf, $mterm[$st-1][$i]);}else{$dum1="";}
?>
    <td class="lmost5"><nobr><? echo $dum1; ?></nobr></td>
<? } ?>

    <td class="lmost5" width="2">&nbsp;</td>
    <td class="lmost5" align="right"><nobr>

<?
  echo "<a href=\"".$addp.$teama[$st-1][$i]."\" title=\"".$text[269]."\">";
  if(($favteam>0) && ($favteam==$teama[$st-1][$i])){echo "<b>";}
  echo $teams[$teama[$st-1][$i]];
  if(($favteam>0) && ($favteam==$teama[$st-1][$i])){echo "</b>";}
  echo "</a>";
?>

    </nobr></td>
    <td class="lmost5" align="center" width="10">-</td>
    <td class="lmost5"><nobr>

<?
  echo "<a href=\"".$addp.$teamb[$st-1][$i]."\" title=\"".$text[269]."\">";
  if (($favteam>0) && ($favteam==$teamb[$st-1][$i])){echo "<b>";}
  echo $teams[$teamb[$st-1][$i]];
  if (($favteam>0) && ($favteam==$teamb[$st-1][$i])){echo "</b>";}
  echo "</a>";
?>

    </nobr></td>
    <td class="lmost5" width="2">&nbsp;</td>
    <td class="lmost5" align="right"><? echo $goala[$st-1][$i]; ?></td>
    <td class="lmost5" align="center" width="8">:</td>
    <td class="lmost5"><? print_r( $goalb[$st-1][$i]); ?></td>
  <? if($spez==1){ ?>
    <td class="lmost5" width="2">&nbsp;</td>
    <td class="lmost5"><? echo $mspez[$st-1][$i]; ?></td>
  <? } ?>
    <td class="lmost5" width="2">&nbsp;</td>
    <td class="lmost5">

<?
  if($urlb==1){
    if($mberi[$st-1][$i]!=""){echo "<a href=\"".$mberi[$st-1][$i]."\" target=\"_blank\" title=\"".$text[270]."\"><img src='img/lmo-st1.gif' width=\"10\" height=\"12\" border=\"0\"></a>";}else{echo "&nbsp;";}
    }
  if(($mnote[$st-1][$i]!="") || ($msieg[$st-1][$i]>0)){
    $dummy=addslashes($teams[$teama[$st-1][$i]]." - ".$teams[$teamb[$st-1][$i]]." ".$goala[$st-1][$i].":".$goalb[$st-1][$i]);
    if($msieg[$st-1][$i]==3){$dummy=$dummy." / ".$goalb[$st-1][$i].":".$goala[$st-1][$i];}
    if($spez==1){$dummy=$dummy." ".$mspez[$st-1][$i];}
    if($msieg[$st-1][$i]==1){$dummy=$dummy."\\n\\n".$text[219].":\\n".addslashes($teams[$teama[$st-1][$i]]." ".$text[211]);}
    if($msieg[$st-1][$i]==2){$dummy=$dummy."\\n\\n".$text[219].":\\n".addslashes($teams[$teamb[$st-1][$i]]." ".$text[211]);}
    if($msieg[$st-1][$i]==3){$dummy=$dummy."\\n\\n".$text[219].":\\n".addslashes($text[212]);}
    if($mnote[$st-1][$i]!=""){$dummy=$dummy."\\n\\n".$text[22].":\\n".$mnote[$st-1][$i];}
    echo "<a href=\"javascript:alert('".$dummy."');\" title=\"".str_replace("\\n","&#10;",$dummy)."\"><img src='img/lmo-st2.gif' width=\"10\" height=\"12\" border=\"0\"></a>";
    }
  else{
    echo "&nbsp;";
    }
?>

    </td>
  </tr>

		
  
<? 
// * Spielfrei-Hack-Beginn1	- Autor: Bernd Hoyer - eMail: info@salzland-info.de
	if (($anzteams-($anzst/2+1))!=0){
	$spielfreia[$i]=$teama[$st-1][$i];
	$spielfreib[$i]=$teamb[$st-1][$i];
	}
// * Spielfrei-Hack-Ende1- Autor: Bernd Hoyer - eMail: info@salzland-info.de 	
}}

 ?>

  </table></td></tr>
  <tr>
    <td><table width="100%" cellspacing="0" cellpadding="0" border="0"><tr>
<? $st0=$st-1;if($st>1){echo "<td class=\"lmost2\"><a href=\"".$addr.$st0."\" title=\"".$text[6]."\">".$text[5]."</a></td>";} ?>
<? $st0=$st+1;if($st<$anzst){echo "<td align=\"right\" class=\"lmost2\"><a href=\"".$addr.$st0."\" title=\"".$text[8]."\">".$text[7]."</a></td>";} ?>
    </tr></table></td>
  </tr>
<tr>  
<td class="lmomain2" align="center">

<?
if ($einzutore==1) {  
$strs=".l98";
$stre=".l98.php";
$str=basename($file);
$file16=str_replace($strs,$stre,$str);
$temp11=basename($diroutput);
if (file_exists("$temp11/$file16")){
require("$temp11/$file16");

echo $text[4000].$text[38].": ".$zutore[$st]."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"." ".$text[38]."&nbsp;".$text[4001].": ".$dstore[$st];

}
} ?>
</td>
</tr>
<tr>  
<td class="lmost2" align="center">

<? } 
if ($einspielfrei==1) { 
if (($anzteams-($anzst/2+1))!=0){
	$spielfreic=array_merge($spielfreia,$spielfreib);
	$hoy5=1;
	for ($hoy8=1;$hoy8<$anzteams+1;$hoy8++) {
		if (in_array($hoy8,$spielfreic)) {
		}
		else {
			if ($hoy5==1) {echo $text[4004].": ";}
			else {echo "";}
			echo "<a href=\"".$addp.$teams[$hoy8[$hoy8]].$hoy8."\" title=\"".$text[269]."\">";
			echo "&nbsp;".$teams[$hoy8]."&nbsp;&nbsp;";
			echo "</a>";
			$hoy5=$hoy5+1;
		}
	}
}
}

?>
</td> 
</tr>
</table>