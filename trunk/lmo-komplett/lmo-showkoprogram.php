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
  $addp=$PHP_SELF."?action=program&amp;file=".$file."&amp;selteam=";
  $addr=$PHP_SELF."?action=results&amp;file=".$file."&amp;st=";
  function gewinn ($gst,$gsp,$gmod,$m1,$m2){
    $erg=0;
    if($gmod==1){
      if($m1[0]>$m2[0]){$erg=1;}
      elseif($m1[0]<$m2[0]){$erg=2;}
      }
    elseif($gmod==2){
      if(($m1[0]+$m1[1])>($m2[0]+$m2[1])){$erg=1;}
      elseif(($m1[0]+$m1[1])<($m2[0]+$m2[1])){$erg=2;}
      else{
        if($m2[0]>$m1[1]){$erg=2;}
        elseif($m2[0]<$m1[1]){$erg=1;}
        }
      }
    else{
      $erg1=0;
      $erg2=0;
      for($k=0;$k<$gmod;$k++){
        if(($m1[$k]!="_") && ($m2[$k]!="_")){
          if($m1[$k]>$m2[$k]){$erg1++;}
          elseif($m1[$k]<$m2[$k]){$erg2++;}
          }
        }
      if($erg1>($gmod/2)){$erg=1;}
      elseif($erg2>($gmod/2)){$erg=2;}
      }
    return $erg;
    }
?>

<table class="lmosta" cellspacing="0" cellpadding="0" border="0">
  <tr>
    <td valign="top" align="center"><table cellspacing="0" cellpadding="0" border="0">
<?PHP
  for($i=1;$i<=$anzteams;$i++){
    echo "<tr><td align=\"center\" ";
    if($i<>$selteam){
      echo "class=\"lmost0\"><a href=\"".$addp.$i."\" title=\"".$text[23]." ".$teams[$i]."\">".$teamk[$i]."</a>";
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
  if($selteam==0){
    echo "<tr><td align=\"center\" class=\"lmost5\">&nbsp;<br>".$text[24]."<br>&nbsp;</td></tr>";
    }
  else{
    for($j=0;$j<$anzst;$j++){
      for($i=0;$i<(($anzteams/2)+1);$i++){
        if(($selteam==$teama[$j][$i]) || ($selteam==$teamb[$j][$i])){
?>

  <tr>
<?PHP
    if($j==$anzst-1){$l=$text[364];}
    elseif($j==$anzst-2){$l=$text[362];}
    elseif($j==$anzst-3){$l=$text[360];}
    elseif($j==$anzst-4){$l=$text[358];}
    else{$l=$j+1;}
?>
    <td class="lmost5" align="right">&nbsp;<a href="<?PHP echo $addr.($j+1); ?>" title="<?PHP echo $text[377]; ?>"><?PHP echo $l; ?></a>&nbsp;</td>

<?PHP
  $m1=array($goala[$j][$i][0],$goala[$j][$i][1],$goala[$j][$i][2],$goala[$j][$i][3],$goala[$j][$i][4],$goala[$j][$i][5],$goala[$j][$i][6]);
  $m2=array($goalb[$j][$i][0],$goalb[$j][$i][1],$goalb[$j][$i][2],$goalb[$j][$i][3],$goalb[$j][$i][4],$goalb[$j][$i][5],$goalb[$j][$i][6]);
  $m=call_user_func('gewinn',$j,$i,$modus[$j],$m1,$m2);
  if($m==1){echo "<td class=\"lmost7\" align=\"right\"><nobr>";}else{echo "<td class=\"lmost5\" align=\"right\"><nobr>";}
  if ($selteam==$teama[$j][$i]){echo "<b>";}
  if(($teamu[$teama[$j][$i]]!="") && ($urlt==1)){echo "<a href=\"".$teamu[$teama[$j][$i]]."\" target=\"_blank\" title=\"".$text[46]."\">";}
  echo $teams[$teama[$j][$i]];
  if(($teamu[$teama[$j][$i]]!="") && ($urlt==1)){echo "</a>";}
  if ($selteam==$teama[$j][$i]){echo "</b>";}
?>

    </nobr></td>
    <td class="lmost5" align="center" width="10">-</td>

<?PHP
  if($m==2){echo "<td class=\"lmost7\"><nobr>";}else{echo "<td class=\"lmost5\"><nobr>";}
  if ($selteam==$teamb[$j][$i]){echo "<b>";}
  if(($teamu[$teamb[$j][$i]]!="") && ($urlt==1)){echo "<a href=\"".$teamu[$teamb[$j][$i]]."\" target=\"_blank\" title=\"".$text[46]."\">";}
  echo $teams[$teamb[$j][$i]];
  if(($teamu[$teamb[$j][$i]]!="") && ($urlt==1)){echo "</a>";}
  if ($selteam==$teamb[$j][$i]){echo "</b>";}
?>

    </nobr></td>
<?PHP
  for($n=0;$n<$modus[$j];$n++){
    if($datm==1){if($mterm[$j][$i][$n]>0){$dumn1="<acronym title=\"".strftime($datf, $mterm[$j][$i][$n])."\">";$dumn2="</acronym>";}else{$dumn1="";$dumn2="";}}
    if($n==0){echo "<td class=\"lmost5\" width=\"2\">&nbsp;</td>";}else{echo "<td class=\"lmost5\" width=\"8\">|</td>";}
?>
    <td class="lmost5"><?PHP echo $dumn1; ?><?PHP echo $goala[$j][$i][$n]; ?>&nbsp;:&nbsp;<?PHP echo $goalb[$j][$i][$n]; ?>&nbsp;<?PHP echo $mspez[$j][$i][$n]; ?><?PHP echo $dumn2; ?>
<?PHP
  if($urlb==1){
    if($mberi[$j][$i][$n]!=""){echo "<a href=\"".$mberi[$j][$i][$n]."\" target=\"_blank\" title=\"".$text[270]."\"><img src=\"lmo-st1.gif\" width=\"16\" height=\"16\" border=\"0\"></a>";}else{echo "&nbsp;";}
    }
  if($mnote[$j][$i][$n]!=""){
    $dummy=addslashes($teams[$teama[$j][$i][$n]]." - ".$teams[$teamb[$j][$i][$n]]." ".$goala[$j][$i][$n].":".$goalb[$j][$i][$n])." ".$mspez[$j][$i][$n];
    if($mnote[$j][$i][$n]!=""){$dummy=$dummy."\\n\\n".$text[22].":\\n".$mnote[$j][$i][$n];}
    echo "<a href=\"javascript:alert('".$dummy."');\" title=\"".str_replace("\\n","&#10;",$dummy)."\"><img src=\"lmo-st2.gif\" width=\"16\" height=\"16\" border=\"0\"></a>";
    }
  else{
    echo "&nbsp;";
    }
?>
    </td>
<?PHP } ?>
  </tr>
<?PHP }}}} ?>

  </table></td></tr>
</table>

<?PHP } ?>
