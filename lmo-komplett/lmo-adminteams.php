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
  if($lmtype==0){$breite=4;}else{$breite=2;}
  $addr=$_SERVER['PHP_SELF']."?action=admin&amp;todo=edit&amp;file=".$file."&amp;st=";
  $addb=$_SERVER['PHP_SELF']."?action=admin&amp;todo=tabs&amp;file=".$file."&amp;st=";
  $addz=$_SERVER['PHP_SELF']."?action=admin&amp;todo=edit&amp;file=".$file."&amp;st=-2&amp;team=";
?>

<table class="lmosta" cellspacing="0" cellpadding="0" border="0">
  <tr>
    <td align="center" class="lmost3">
      <form name="lmoedit" action="<? echo $_SERVER['PHP_SELF']; ?>" method="post" onSubmit="return chklmopass()">
        <input type="hidden" name="action" value="admin">
        <input type="hidden" name="todo" value="edit">
        <input type="hidden" name="save" value="1">
        <input type="hidden" name="file" value="<? echo $file; ?>">
        <input type="hidden" name="st" value="<? echo $st; ?>">
        <table class="lmostb" cellspacing="0" cellpadding="0" border="0">
          <tr>
            <td class="lmost4"><acronym title="<? echo $text[125].", ".$text[126] ?>"><? echo $text[127]; ?></acronym>&nbsp;</td>
<? if($lmtype==0){ ?>
            <td class="lmost4" align="center"><acronym title="<? echo $text[131] ?>"><? echo $text[128]; ?></acronym>&nbsp;</td>
<? } ?>
<!-- Hack-Straftore Beginn -->
<? if($lmtype==0){ ?> 
            <td class="lmost4" align="center"><acronym title="<? echo $text[521] ?>"><? echo $text[522]; ?></acronym>&nbsp;</td>
<? } ?>
<? if($lmtype==0){ ?>
            <td class="lmost4" align="center"><acronym title="<? echo $text[523] ?>"><? echo $text[524]; ?></acronym>&nbsp;</td>
<? } ?>
<!-- Hack-Straftore Ende -->	
<? if($lmtype==0){ ?>
            <td class="lmost4"><acronym title="<? echo $text[405] ?>"><? echo $text[404]; ?></acronym>&nbsp;</td>
<? } ?>
            <td class="lmost4"><acronym title="<? echo $text[130] ?>"><? echo $text[129]; ?></acronym></td>
          </tr>
<? for($i=1;$i<=$anzteams;$i++){ ?>
          <tr>
            <td class="lmost5">
              <nobr>
                <input class="lmoadminein" type="text" name="xteams<? echo $i; ?>" size="32" maxlength="32" value="<? echo htmlspecialchars($teams[$i]); ?>" onChange="dolmoedit()">
                <input class="lmoadminein" type="text" name="xteamk<? echo $i; ?>" size="5" maxlength="5" value="<? echo $teamk[$i]; ?>" onChange="dolmoedit()">
              </nobr>&nbsp;
            </td>
<?   if($lmtype==0){ ?>
            <td class="lmost5" align="center">
              <nobr>
                <input class="lmoadminein" type="text" name="xstrafp<? echo $i; ?>" size="2" maxlength="4" value="<? echo $strafp[$i]; ?>" onChange="dolmoedit()">
<?     if($minus==2){ ?>
              : <input class="lmoadminein" type="text" name="xstrafm<? echo $i; ?>" size="2" maxlength="4" value="<? echo $strafm[$i]; ?>" onChange="dolmoedit()">
<?     } ?>
              </nobr>&nbsp;
            </td>
<!-- Hack-Straftore Beginn -->
  	        <td class="lmost5" align="center">
              <nobr>
                <input class="lmoadminein" type="text" name="xtorkorrektur1<? echo $i; ?>" size="2" maxlength="4" value="<? echo $torkorrektur1[$i]; ?>" onChange="dolmoedit()">
              : <input class="lmoadminein" type="text" name="xtorkorrektur2<? echo $i; ?>" size="2" maxlength="4" value="<? echo $torkorrektur2[$i]; ?>" onChange="dolmoedit()">
              </nobr>&nbsp;
            </td>
  	        <td class="lmost5" align="center">
              <nobr>
                <input class="lmoadminein" type="text" name="xstrafdat<? echo $i; ?>" size="2" maxlength="2" value="<? echo $strafdat[$i]; ?>" onChange="dolmoedit()">
              </nobr>&nbsp;
            </td>
<!-- Hack-Straftore Ende -->	
<?   } ?>
<?   if($lmtype==0){ ?>
            <td class="lmost5">            
              <input class="lmoadminein" type="text" name="xteamn<? echo $i; ?>" size="30" maxlength="255" value="<? echo $teamn[$i]; ?>" onChange="dolmoedit()">
            </td>
<?   } ?>
            <td class="lmost5">
              <input class="lmoadminein" type="text" name="xteamu<? echo $i; ?>" size="30" maxlength="128" value="<? echo $teamu[$i]; ?>" onChange="dolmoedit()">
            </td>
<?   if($lmtype==0){ ?>
            <td class="lmost5">
              <a href='<? echo $addz.$i; ?>' onclick="return dteamlmolink(this.href,'<? echo $teams[$i]; ?>');" title="<? echo $text[334]; ?>">
                <img src="<?=URL_TO_IMGDIR."/delete.gif"?>" width="11" height="13" alt="<?$text[333];?>" border="0">
              </a>
            </td>
<?   } ?>
          </tr>
<? } ?>
          <tr>
            <td class="lmost4" colspan="<? echo $breite; ?>" align="right">
              <acronym title="<? echo $text[114] ?>"><input class="lmoadminbut" type="submit" name="best" value="<? echo $text[132]; ?>"></acronym>
            </td>
<? if($lmtype==0){ ?>
            <td class="lmost5">
              <a href='<? echo $addz; ?>-1' onclick="return ateamlmolink(this.href);" title="<? echo $text[337]; ?>"><? echo $text[336]; ?></a>
            </td>
<? } ?>
          </tr>
        </table>
      </form>
    </td>
  </tr>
<? if($lmtype==0){ 
     if($team!=""){?>
  <tr>
    <td class="lmost5">
      <a href="<?=$addr?>-3" onclick="return chklmolink(this.href);" title="<?=$text[339]?>"><?=$text[338]?></a>
    </td>
  </tr>
<?   }
   } ?>
  <tr>
    <td><? include(PATH_TO_LMO."/lmo-adminnaviunten.php"); ?></td>
  </tr>
</table>
<?}?>