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
require_once("lmo-admintest.php");
if(($file!="") && ($HTTP_SESSION_VARS['lmouserok']==2)){
  require("lmo-openfile.php");
  if($save==1){
    for($i=0;$i<$anzst;$i++){
      for($j=$anzsp;$j<40;$j++){
        $teama[$i][$j]=0;
        $teamb[$i][$j]=0;
        $goala[$i][$j]=-1;
        $goalb[$i][$j]=-1;
        $msieg[$i][$j]=0;
        $mterm[$i][$j]="";
        $mnote[$i][$j]="";
        $mberi[$i][$j]="";
        $mspez[$i][$j]="_";
        }
      }
    for($i=$anzst;$i<116;$i++){
      for($j=0;$j<40;$j++){
        $teama[$i][$j]=0;
        $teamb[$i][$j]=0;
        $goala[$i][$j]=-1;
        $goalb[$i][$j]=-1;
        $msieg[$i][$j]=0;
        $mterm[$i][$j]="";
        $mnote[$i][$j]="";
        $mberi[$i][$j]="";
        $mspez[$i][$j]="_";
        }
      }
    $anzst=trim($HTTP_POST_VARS["xanzst"]);
    $anzsp=trim($HTTP_POST_VARS["xanzsp"]);
    if($stx>$anzst){$stx=$anzst;}
    require("lmo-savefile.php");
    }
  $addr=$PHP_SELF."?action=admin&amp;todo=edit&amp;file=".$file."&amp;st=";
?>

<table class="lmosta" cellspacing="0" cellpadding="0" border="0">
  <tr>
    <td align="center"><table cellspacing="0" cellpadding="0" border="0"><tr>
<?PHP
  for($i=1;$i<=$anzst;$i++){
    echo "<td align=\"right\" ";
    if($i<>$st){
      echo "class=\"lmost0\"><a href=\"javascript:chklmolink('".$addr.$i."');\" title=\"".$text[9]."\">".$i."</a>";
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

  <form name="lmoedit" action="<?PHP echo $PHP_SELF; ?>" method="post" onSubmit="return chklmopass()">
  
  <input type="hidden" name="action" value="admin">
  <input type="hidden" name="todo" value="edit">
  <input type="hidden" name="save" value="1">
  <input type="hidden" name="file" value="<?PHP echo $file; ?>">
  <input type="hidden" name="st" value="<?PHP echo $st; ?>">

  <tr>
    <td class="lmost4" colspan="3"><nobr><?PHP echo $text[340]; ?></nobr></td>
  </tr>
  <tr>
    <td class="lmost5" width="20">&nbsp;</td>
    <td class="lmost5" align="right"><nobr><acronym title="<?PHP echo $text[275] ?>"><?PHP echo $text[274]; ?></acronym></nobr></td>
    <td class="lmost5"><acronym title="<?PHP echo $text[275] ?>"><table cellpadding="0" cellspacing="0" border="0"><tr>
      <td class="lmost5" align="right"><input class="lmoadminein" type="text" name="xanzst" size="3" maxlength="3" value="34" onChange="lmoanzstauf('xanzst',0)" onKeyDown="lmoanzstclk('xanzst',event.keyCode)"></td>
      <td class="lmost5" align="center"><table cellpadding="0" cellspacing="0" border="0"><tr><td><a href="javascript:lmoanzstauf('xanzst',1);" title="<?PHP echo $text[276]; ?>" onMouseOver="lmoimg('sa',img1)" onMouseOut="lmoimg('sa',img0)"><img src="lmo-admin0.gif" name="ximgsa" width="7" height="7" border="0"></a></td></tr><tr><td><a href="javascript:lmoanzstauf('xanzst',-1);" title="<?PHP echo $text[276]; ?>" onMouseOver="lmoimg('sb',img3)" onMouseOut="lmoimg('sb',img2)"><img src="lmo-admin2.gif" name="ximgsb" width="7" height="7" border="0"></a></td></tr></table></td>
    </tr></table></acronym></td>
  </tr>
  <tr>
    <td class="lmost5" width="20">&nbsp;</td>
    <td class="lmost5" align="right"><nobr><acronym title="<?PHP echo $text[278] ?>"><?PHP echo $text[277]; ?></acronym></nobr></td>
    <td class="lmost5"><acronym title="<?PHP echo $text[278] ?>"><table cellpadding="0" cellspacing="0" border="0"><tr>
      <td class="lmost5" align="right"><input class="lmoadminein" type="text" name="xanzsp" size="2" maxlength="2" value="9" onChange="lmoanzspauf('xanzsp',0)" onKeyDown="lmoanzspclk('xanzsp',event.keyCode)"></td>
      <td class="lmost5" align="center"><table cellpadding="0" cellspacing="0" border="0"><tr><td><a href="javascript:lmoanzspauf('xanzsp',1);" title="<?PHP echo $text[279]; ?>" onMouseOver="lmoimg('pa',img1)" onMouseOut="lmoimg('pa',img0)"><img src="lmo-admin0.gif" name="ximgpa" width="7" height="7" border="0"></a></td></tr><tr><td><a href="javascript:lmoanzspauf('xanzsp',-1);" title="<?PHP echo $text[279]; ?>" onMouseOver="lmoimg('pb',img3)" onMouseOut="lmoimg('pb',img2)"><img src="lmo-admin2.gif" name="ximgpb" width="7" height="7" border="0"></a></td></tr></table></td>
    </tr></table></acronym></td>
  </tr>
  <tr>
    <td class="lmost4" colspan="3" align="right">
      <acronym title="<?PHP echo $text[114] ?>"><input class="lmoadminbut" type="submit" name="best" value="<?PHP echo $text[188]; ?>"></acronym>
    </td>
  </tr>
  </form>

  </table></td></tr>

  <tr>
    <td><table width="100%" cellspacing="0" cellpadding="0" border="0"><tr>
<?PHP 
  if($st!=-1){echo "<td class=\"lmost2\" align=\"center\"><a href=\"javascript:chklmolink('".$addr."-1');\" title=\"".$text[100]."\">".$text[99]."</a></td>";}
    else{echo "<td class=\"lmost1\" align=\"center\">".$text[99]."</td>";}
  if($st!=-2){echo "<td class=\"lmost2\" align=\"center\"><a href=\"javascript:chklmolink('".$addr."-2');\" title=\"".$text[102]."\">".$text[101]."</a></td>";}
    else{echo "<td class=\"lmost1\" align=\"center\">".$text[101]."</td>";}
?>
    </tr></table></td>
  </tr>

</table>

<?PHP } ?>
