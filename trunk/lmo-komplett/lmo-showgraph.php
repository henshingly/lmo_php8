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
if(($file!="") && ($kurve==1)){
  $addg=$PHP_SELF."?action=graph&amp;file=".$file."&amp;stat1=";
?>

<table class="lmosta" cellspacing="0" cellpadding="0" border="0">
  <tr>
    <td valign="top" align="center"><table cellspacing="0" cellpadding="0" border="0">
<?PHP
  for($i=1;$i<=$anzteams;$i++){
    echo "<tr><td align=\"center\" ";
    if($i<>$stat1){
      echo "class=\"lmost0\"><a href=\"".$addg.$i."&amp;stat2=".$stat2."\" title=\"".$text[57]." ".$teams[$i]."\">".$teamk[$i]."</a>";
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
    $tabtype=0;
    require("lmo-calcgraph.php");
    $dummy="lmo-paintgraph.php?pganz=";
    if($stat2>0){$dummy=$dummy."2";}else{$dummy=$dummy."1";}
    $dummy=$dummy."&amp;pgteam1=".htmlentities($teams[$stat1]);
    if($stat2>0){$dummy=$dummy."&amp;pgteam2=".htmlentities($teams[$stat2]);}
    $dummy=$dummy."&amp;pgteams=".$anzteams;
    $dummy=$dummy."&amp;pgst=".$anzst;
    $dummy=$dummy."&amp;pgch=".$champ;
    $dummy=$dummy."&amp;pgcl=".$anzcl;
    $dummy=$dummy."&amp;pgck=".$anzck;
    $dummy=$dummy."&amp;pguc=".$anzuc;
    $dummy=$dummy."&amp;pgar=".$anzar;
    $dummy=$dummy."&amp;pgab=".$anzab;
    $dummy=$dummy."&amp;pgplatz1=";
    for($j=0;$j<$anzst;$j++){$dummy=$dummy.$platz[$stat1][$j].",";}
    $dummy=$dummy."0";
    if($stat2>0){
      $dummy=$dummy."&amp;pgplatz2=";
      for($j=0;$j<$anzst;$j++){$dummy=$dummy.$platz[$stat2][$j].",";}
      $dummy=$dummy."0";
      }
    $dummy=$dummy."&amp;pgtext1=".$text[135];
    $dummy=$dummy."&amp;pgtext2=".$text[136];
?>
<tr><td class="lmost5" colspan="3"><img src="<?PHP echo $dummy; ?>" border="0"></td></tr>
<?PHP } ?>

  </table></td>
    <td valign="top" align="center"><table cellspacing="0" cellpadding="0" border="0">
<?PHP
  for($j=0;$j<=$anzteams;$j++){
    $i=$j+1;
    if($i>$anzteams){$i=0;}
    if($i==0){$dummy=$text[59];}else{$dummy=$text[58]." ".$teams[$i];}
    echo "<tr><td align=\"center\" ";
    if($i<>$stat2){
      echo "class=\"lmost0\"><a href=\"".$addg.$stat1."&amp;stat2=".$i."\" title=\"".$dummy."\">".$teamk[$i]."</a>";
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

<?PHP } ?>
