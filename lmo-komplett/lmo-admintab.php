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
require_once(PATH_TO_LMO."/lmo-admintest.php");
if($file!=""){
  
  require_once(PATH_TO_LMO."/lmo-openfile.php");
  $breite=16;
  if($hidr!=1){$breite=$breite-1;}
  if($minus==2){$dummy=" colspan=\"3\" align=\"center\"";$breite=$breite+2;}else{$dummy=" align=\"right\"";}
  $endtab=$st;
  $tabdat="";
  require(PATH_TO_LMO."/lmo-calctable.php");
  $platz0 = array("");
  $platz0 = array_pad($array,$anzteams+1,"");
  for($x=0;$x<$anzteams;$x++){$x3=intval(substr($tab2[$x],34));$platz0[$x3]=$x+1;}
  $addt2=$_SERVER['PHP_SELF']."?action=table&amp;file=".$file."&amp;tabtype=".$tabtype."&amp;endtab=";
  if(!isset($save)){$save=0;}
  if($save==1){
    $xa="";
    $xb="";
    $xc=0;
    for($i=1;$i<=$anzteams;$i++){
      if($i<10){$xa=$xa."0";$xb=$xb."0";}
      $xa=$xa.$i;
      $xb=$xb.trim($_POST["xplatz".$i]);
      if($i==trim($_POST["xplatz".$i])){$xc++;}
      }
    if($xc==$anzteams){$handp[$st-1]=0;}else{$handp[$st-1]=$xb;}
    require(PATH_TO_LMO."/lmo-savefile.php");
    }
  $handt=array_pad($array,$anzteams+2,"");
  for($i=0;$i<$anzteams;$i++){
    if($handp[$st-1]!=0){$handt[$i+1]=intval(substr($handp[$st-1],$i*2,2));}else{$handt[$i+1]=$i+1;}
    }
  $addr=$_SERVER['PHP_SELF']."?action=admin&amp;todo=edit&amp;file=".$file."&amp;st=";
  $addb=$_SERVER['PHP_SELF']."?action=admin&amp;todo=tabs&amp;file=".$file."&amp;st=";
  $breite=16;
  if($spez==1){$breite=$breite+2;}
?>

<table class="lmoMiddle" cellspacing="0" cellpadding="0" border="0">
  <tr>
  <tr>
    <td align="center"><h1><?=$titel?></h1></td>
  </tr>
    <td align="center"><table cellspacing="0" cellpadding="0" border="0"><tr>
<?PHP
  for($i=1;$i<=$anzst;$i++){
    $j=$i;$k=$text[413];
    echo "<td align=\"right\" ";
    if($i<>$st){
      echo "><a href='$addb$i' onclick=\"return chklmolink(this.href);\" title=\"".$k."\">".$j."</a>";
      }
    else{
      echo "class=\"active\">".$j;
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
?>
    <tr></table></td>
  </tr>
  <tr><td align="center"><table class="lmoInner" cellspacing="0" cellpadding="0" border="0">
  <form name="lmoedit" action="<?PHP echo $_SERVER['PHP_SELF']; ?>" method="post" onSubmit="return chklmopas2(<?PHP echo $anzteams; ?>)">
  <input type="hidden" name="action" value="admin">
  <input type="hidden" name="todo" value="tabs">
  <input type="hidden" name="save" value="1">
  <input type="hidden" name="file" value="<?PHP echo $file; ?>">
  <input type="hidden" name="st" value="<?PHP echo $st; ?>">
  <tr>
    <td class="lmost4" colspan="4"><?PHP echo $st.". ".$text[2]; ?></td>
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
    $i=intval(substr($tab2[$x-1],34));
    if($i==$favteam){$dummy="<b>";$dumm2="</b>";}else{$dummy="";$dumm2="";}
    $dumm1="lmost5";
?>
  <tr>
    <td class="<?PHP echo $dumm1; ?>" align="right"><acronym title="<?PHP echo $text[414] ?>"><select class="lmo-formular-input" name="xplatz<?PHP echo $x; ?>" onChange="dolmoedi2(<?PHP echo $anzteams; ?>,'xplatz<?PHP echo $x; ?>')">
<?PHP
  for($y=1;$y<=$anzteams;$y++){
    echo "<option value=\"".$y."\"";
    if($y==$handt[$x]){echo " selected";}
    echo ">".$y."</option>";
    }
?>
    </select></acronym></td>
    <td class="<?PHP echo $dumm1; ?>"><nobr><?PHP echo $dummy.$teams[$i].$dumm2; ?></nobr></td>
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
    echo "<a href=\"javascript:alert('".$dum27."');\" title=\"".str_replace("\\n","&#10;",$dum27)."\"><img src='img/lmo-st2.gif' width=\"10\" height=\"12\" border=\"0\"></a>";
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
  <tr><td class="lmost4" colspan="<?PHP echo $breite; ?>" align="center">
    <acronym title="<?PHP echo $text[114] ?>"><input class="lmo-formular-button" type="submit" name="best" value="<?PHP echo $text[415]; ?>"></acronym>
  </td></tr>
  </form>

  </table></td></tr>
  <tr>
    <td><? include(PATH_TO_LMO."/lmo-adminnaviunten.php"); ?></td>
  </tr>
</table>

<?PHP } ?>