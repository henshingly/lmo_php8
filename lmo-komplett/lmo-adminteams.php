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
if(($file!="") && ($_SESSION['lmouserok']==2)){
  require_once(PATH_TO_LMO."/lmo-openfile.php");
  if(!isset($team)){$team="";}
  if(!isset($save)){$save=0;}
  if($save==1){
    for($i=1;$i<=$anzteams;$i++){
      if($_POST["xteams".$i]!=""){$teams[$i]=$_POST["xteams".$i];}
      $teamk[$i]=$_POST["xteamk".$i];
      if($teamk[$i]==""){$teamk[$i]=substr($teams[$i],0,5);}
      $teamu[$i]=$_POST["xteamu".$i];
      $teamn[$i]=$_POST["xteamn".$i];
      if($lmtype==0){
        $strafp[$i]=intval($_POST["xstrafp".$i]);
        if($minus==2){$strafm[$i]=intval($_POST["xstrafm".$i]);}
        $torkorrektur1[$i]=intval($HTTP_POST_VARS["xtorkorrektur1".$i]); // Hack-Straftore
		    $torkorrektur2[$i]=intval($HTTP_POST_VARS["xtorkorrektur2".$i]); // Hack-Straftore
		    $strafdat[$i]=intval($HTTP_POST_VARS["xstrafdat".$i]); // Hack-Straftore
      }
    }
    require(PATH_TO_LMO."/lmo-savefile.php");
  }
  elseif($team!=""){
    if($team>1){
      if($anzteams>4){
        for($i=0;$i<$anzst;$i++){
          for($j=0;$j<$anzsp;$j++){
            if(($teama[$i][$j]==$team) || ($teamb[$i][$j]==$team)){
              $teama[$i][$j]=0;
              $teamb[$i][$j]=0;
              $goala[$i][$j]=-1;
              $goalb[$i][$j]=-1;
              $msieg[$i][$j]=0;
              $mterm[$i][$j]="";
              $mnote[$i][$j]="";
              $mberi[$i][$j]="";
              if($spez==1){$mspez[$i][$j]="_";}
              }
            }
          for($j=$anzsp-2;$j>=0;$j--){
            if(($teama[$i][$j]==0) && ($teamb[$i][$j]==0) && ($goala[$i][$j]==-1) && ($goalb[$i][$j]==-1)){
              for($k=$j+1;$k<$anzsp;$k++){
                $teama[$i][$k-1]=$teama[$i][$k];
                $teamb[$i][$k-1]=$teamb[$i][$k];
                $goala[$i][$k-1]=$goala[$i][$k];
                $goalb[$i][$k-1]=$goalb[$i][$k];
                $msieg[$i][$k-1]=$msieg[$i][$k];
                $mterm[$i][$k-1]=$mterm[$i][$k];
                $mnote[$i][$k-1]=$mnote[$i][$k];
                $mberi[$i][$k-1]=$mberi[$i][$k];
                if($spez==1){$mspez[$i][$k-1]=$mspez[$i][$k];}
                }
              $teama[$i][$anzsp-1]=0;
              $teamb[$i][$anzsp-1]=0;
              $goala[$i][$anzsp-1]=-1;
              $goalb[$i][$anzsp-1]=-1;
              $msieg[$i][$anzsp-1]=0;
              $mterm[$i][$anzsp-1]="";
              $mnote[$i][$anzsp-1]="";
              $mberi[$i][$anzsp-1]="";
              if($spez==1){$mspez[$i][$anzsp-1]="_";}
              }
            }
          for($j=0;$j<$anzsp;$j++){
            if($teama[$i][$j]>$team){$teama[$i][$j]--;}
            if($teamb[$i][$j]>$team){$teamb[$i][$j]--;}
            }
          }
        if($favteam==$team){$favteam=0;}
        elseif($favteam>$team){$favteam--;}
        if($selteam==$team){$selteam=0;}
        elseif($selteam>$team){$selteam--;}
        if($stat1==$team){$stat1=$stat2;$stat2=$team;}
        elseif($stat1>$team){$stat1--;}
        if($stat2==$team){$stat2=0;}
        elseif($stat2>$team){$stat2--;}
        for($i=$team+1;$i<=$anzteams;$i++){
          $teams[$i-1]=$teams[$i];
          $teamk[$i-1]=$teamk[$i];
          $teamu[$i-1]=$teamu[$i];
          $teamn[$i-1]=$teamn[$i];
          $strafp[$i-1]=$strafp[$i];
          if($minus==2){$strafm[$i-1]=$strafm[$i];}
          }
        $teams[$anzteams]="";
        $teamk[$anzteams]="";
        $teamu[$anzteams]="";
        $teamn[$anzteams]="";
        $strafp[$anzteams]=0;
        if($minus==2){$strafm[$anzteams]=0;}
        $anzteams--;
        require(PATH_TO_LMO."/lmo-savefile.php");
        }
      }
    elseif($team==-1){
      if($anzteams<40){
        $anzteams++;
        $teams[$anzteams]="Neue Mannschaft";
        $teamk[$anzteams]="Mneu";
        $teamu[$anzteams]="";
        $teamn[$anzteams]="";
        $strafp[$anzteams]=0;
        if($minus==2){$strafm[$anzteams]=0;}
        require(PATH_TO_LMO."/lmo-savefile.php");
        }
      }
    }
  if($lmtype==0){$breite=7;}else{$breite=5;}
  $addr=$_SERVER['PHP_SELF']."?action=admin&amp;todo=edit&amp;file=".$file."&amp;st=";
  $addb=$_SERVER['PHP_SELF']."?action=admin&amp;todo=tabs&amp;file=".$file."&amp;st=";
  $addz=$_SERVER['PHP_SELF']."?action=admin&amp;todo=edit&amp;file=".$file."&amp;st=-2&amp;team=";
?>

<table class="lmosta" cellspacing="0" cellpadding="0" border="0">
  <tr>
    <td align="center"><table cellspacing="0" cellpadding="0" border="0"><tr>
<?PHP
  for($i=1;$i<=$anzst;$i++){
    echo "<td align=\"right\" ";
    if($i<>$st){
      echo "class=\"lmost0\"><a href='$addr$i' onclick=\"return chklmolink(this.href);\" title=\"".$text[9]."\">".$i."</a>";
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
?>
    <tr></table></td>
  </tr>
  <tr><td align="center" class="lmost3"><table class="lmostb" cellspacing="0" cellpadding="0" border="0">

  <form name="lmoedit" action="<?PHP echo $_SERVER['PHP_SELF']; ?>" method="post" onSubmit="return chklmopass()">
  
  <input type="hidden" name="action" value="admin">
  <input type="hidden" name="todo" value="edit">
  <input type="hidden" name="save" value="1">
  <input type="hidden" name="file" value="<?PHP echo $file; ?>">
  <input type="hidden" name="st" value="<?PHP echo $st; ?>">

  <tr>
    <td class="lmost4"><?PHP echo $text[127]; ?></td>
    <td class="lmost4" width="2">&nbsp;</td>
<?PHP if($lmtype==0){ ?>
    <td class="lmost4" align="center"><?PHP echo $text[128]; ?></td>
    <td class="lmost4" width="2">&nbsp;</td>
<?PHP } ?>
<!-- Hack-Straftore Beginn -->
<?PHP if($lmtype==0){ ?> 
    <td class="lmost4" align="center"><?PHP echo $text[522]; ?></td>
    <td class="lmost4" width="2">&nbsp;</td>
<?PHP } ?>
<?PHP if($lmtype==0){ ?>
    <td class="lmost4" align="center"><?PHP echo $text[524]; ?></td>
    <td class="lmost4" width="2">&nbsp;</td>
<?PHP } ?>
<!-- Hack-Straftore Ende -->	
<?PHP if($lmtype==0){ ?>
    <td class="lmost4"><?PHP echo $text[404]; ?></td>
    <td class="lmost4" width="2">&nbsp;</td>
<?PHP } ?>
    <td class="lmost4"><?PHP echo $text[129]; ?></td>
<?PHP if($lmtype==0){ ?>
    <td class="lmost5" width="2">&nbsp;</td>
    <td class="lmost5"><nobr>
<?PHP
  if($team!=""){echo "<a href='$addr-3' onclick=\"return chklmolink(this.href);\" title=\"".$text[339]."\">".$text[338]."</a>";}
    else{echo "&nbsp;";}
?>
    </nobr></td>
<?PHP } ?>
  </tr>
<?PHP for($i=1;$i<=$anzteams;$i++){ ?>
  <tr>
    <td class="lmost5"><nobr>
      <acronym title="<?PHP echo $text[125] ?>"><input class="lmoadminein" type="text" name="xteams<?PHP echo $i; ?>" size="32" maxlength="32" value="<?PHP echo htmlspecialchars($teams[$i]); ?>" onChange="dolmoedit()"></acronym>
      <acronym title="<?PHP echo $text[126] ?>"><input class="lmoadminein" type="text" name="xteamk<?PHP echo $i; ?>" size="5" maxlength="5" value="<?PHP echo $teamk[$i]; ?>" onChange="dolmoedit()"></acronym>
    </nobr></td>
    <td class="lmost5" width="2">&nbsp;</td>
<?PHP if($lmtype==0){ ?>
    <td class="lmost5" align="center"><nobr>
      <acronym title="<?PHP echo $text[131] ?>">
      <input class="lmoadminein" type="text" name="xstrafp<?PHP echo $i; ?>" size="4" maxlength="4" value="<?PHP echo $strafp[$i]; ?>" onChange="dolmoedit()">
<?PHP if($minus==2){ ?>
      : <input class="lmoadminein" type="text" name="xstrafm<?PHP echo $i; ?>" size="4" maxlength="4" value="<?PHP echo $strafm[$i]; ?>" onChange="dolmoedit()">
<?PHP } ?>
      </acronym>
    </nobr></td>
    <td class="lmost5" width="2">&nbsp;</td>
<!-- Hack-Straftore Beginn -->
	<td class="lmost5" align="center"><nobr>
	<acronym title="<?PHP echo $text[521] ?>">
      <input class="lmoadminein" type="text" name="xtorkorrektur1<?PHP echo $i; ?>" size="4" maxlength="4" value="<?PHP echo $torkorrektur1[$i]; ?>" onChange="dolmoedit()">
      : <input class="lmoadminein" type="text" name="xtorkorrektur2<?PHP echo $i; ?>" size="4" maxlength="4" value="<?PHP echo $torkorrektur2[$i]; ?>" onChange="dolmoedit()">
      </acronym>
    </nobr></td>
    <td class="lmost5" width="2">&nbsp;</td>
	<td class="lmost5" align="center"><nobr>
	<acronym title="<?PHP echo $text[523] ?>">
      <input class="lmoadminein" type="text" name="xstrafdat<?PHP echo $i; ?>" size="2" maxlength="2" value="<?PHP echo $strafdat[$i]; ?>" onChange="dolmoedit()">
      </acronym>
    </nobr></td>
    <td class="lmost5" width="2">&nbsp;</td>
<!-- Hack-Straftore Ende -->	
<?PHP } ?>
<?PHP if($lmtype==0){ ?>
    <td class="lmost5"><nobr>
      <acronym title="<?PHP echo $text[405] ?>"><input class="lmoadminein" type="text" name="xteamn<?PHP echo $i; ?>" size="30" maxlength="255" value="<?PHP echo $teamn[$i]; ?>" onChange="dolmoedit()"></acronym>
    </nobr></td>
    <td class="lmost5" width="2">&nbsp;</td>
<?PHP } ?>
    <td class="lmost5"><nobr>
      <acronym title="<?PHP echo $text[130] ?>"><input class="lmoadminein" type="text" name="xteamu<?PHP echo $i; ?>" size="30" maxlength="128" value="<?PHP echo $teamu[$i]; ?>" onChange="dolmoedit()"></acronym>
    </nobr></td>
<?PHP if($lmtype==0){ ?>
    <td class="lmost5" width="2">&nbsp;</td>
    <td class="lmost5"><nobr><a href='<?PHP echo $addz.$i; ?>' onclick="return dteamlmolink(this.href,'<?PHP echo $teams[$i]; ?>');" title="<?PHP echo $text[334]; ?>"><?PHP echo $text[333]; ?></a></nobr></td>
<?PHP } ?>
  </tr>
<?PHP } ?>
  <tr>
    <td class="lmost4" colspan="<?PHP echo $breite; ?>" align="right">
      <acronym title="<?PHP echo $text[114] ?>"><input class="lmoadminbut" type="submit" name="best" value="<?PHP echo $text[132]; ?>"></acronym>
    </td>
<?PHP if($lmtype==0){ ?>
    <td class="lmost5" width="2">&nbsp;</td>
    <td class="lmost5"><nobr><a href='<?PHP echo $addz; ?>-1' onclick="return ateamlmolink(this.href);" title="<?PHP echo $text[337]; ?>"><?PHP echo $text[336]; ?></a></nobr></td>
<?PHP } ?>
  </form>

  </table></td></tr>

  <tr>
    <td><table width="100%" cellspacing="0" cellpadding="0" border="0"><tr>
<?PHP 
  if($st!=-1){echo "<td class=\"lmost2\" align=\"center\"><a href='$addr-1' onclick=\"return chklmolink(this.href);\" title=\"".$text[100]."\">".$text[99]."</a></td>";}
    else{echo "<td class=\"lmost1\" align=\"center\">".$text[99]."</td>";}
  if($hands==1){if($todo!="tabs"){echo "<td class=\"lmost2\" align=\"center\"><a href='$addb$stx' onclick=\"return chklmolink(this.href);\" title=\"".$text[409]."\">".$text[410]."</a></td>";}
    else{echo "<td class=\"lmost1\" align=\"center\">".$text[410]."</td>";}}
  if($st!=-2){echo "<td class=\"lmost2\" align=\"center\"><a href='$addr-2' onclick=\"return chklmolink(this.href);\" title=\"".$text[102]."\">".$text[101]."</a></td>";}
    else{echo "<td class=\"lmost1\" align=\"center\">".$text[101]."</td>";}
?>
    </tr></table></td>
  </tr>

</table>

<?PHP } ?>