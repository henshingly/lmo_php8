<?
// 
// LigaManager Online 3.02a
// Copyright (C) 1997-2002 by Frank Hollwitz
// webmaster@hollwitz.de / http://php.hollwitz.de
// 
// Tippspiel-AddOn 1.20
// Copyright (C) 2002 by Frank Albrecht
// fkalbrecht@web.de
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
  $ftest0=1;
  $liga=substr($file, strrpos($file,"/")+1,-4);

  if($tipp_immeralle==0){
    $ftest0=0;$ftest1="";
    $ftest1=split("[,]",$tipp_ligenzutippen);
    if(isset($ftest1)){
      for($u=0;$u<count($ftest1);$u++){
        if($ftest1[$u]==$liga){$ftest0=1;}
        }
      }
    }

  if(!isset($nlines)){$nlines=array();}
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
  require_once(PATH_TO_LMO."/lmo-openfile.php");
  if(!isset($save)){$save=0;}
  if($save==1){
    $me=array("0","January","February","March","April","May","June","July","August","September","October","November","December");
if($_SESSION["lmouserok"]==2){
    $datum1[$st-1]=trim($_POST["xdatum1"]);
    if($datum1[$st-1]!=""){
      $datum = split("[.]",$datum1[$st-1]);
      $dummy=strtotime($datum[0]." ".$me[intval($datum[1])]." ".$datum[2]);
      if($dummy>-1){$datum1[$st-1]=strftime("%d.%m.%Y",$dummy);}else{$datum1[$st-1]="";}
      }
    $datum2[$st-1]=trim($_POST["xdatum2"]);
    if($datum2[$st-1]!=""){
      $datum = split("[.]",$datum2[$st-1]);
      $dummy=strtotime($datum[0]." ".$me[intval($datum[1])]." ".$datum[2]);
      if($dummy>-1){$datum2[$st-1]=strftime("%d.%m.%Y",$dummy);}else{$datum2[$st-1]="";}
      }
  }
    if($hands==1){for($i=$st-1;$i<$stanz;$i++){$handp[$i]=0;}}
    for($i=0;$i<$anzsp;$i++){
      if($lmtype==0){
        $dum1=trim($_POST["xatdat".$i]);
        $dum2=trim($_POST["xattim".$i]);
        if($dum1!=""){
          if($dum2==""){$dum2=$deftime;}
          $datu1 = split("[.]",$dum1);
          $datu2 = split("[:]",$dum2);
          $dummy=strtotime($datu1[0]." ".$me[intval($datu1[1])]." ".$datu1[2]." ".$datu2[0].":".$datu2[1]);
          if($dummy>-1){$mterm[$st-1][$i]=$dummy;}else{$mterm[$st-1][$i]="";}
          }
        }
      else{
        for($n=0;$n<$modus[$st-1];$n++){
          $dum1=trim($_POST["xatdat".$i.$n]);
          $dum2=trim($_POST["xattim".$i.$n]);
          if($dum1!=""){
            if($dum2==""){$dum2=$deftime;}
            $datu1 = split("[.]",$dum1);
            $datu2 = split("[:]",$dum2);
            $dummy=strtotime($datu1[0]." ".$me[intval($datu1[1])]." ".$datu1[2]." ".$datu2[0].":".$datu2[1]);
            if($dummy>-1){$mterm[$st-1][$i][$n]=$dummy;}else{$mterm[$st-1][$i][$n]="";}
            }
          }
        }
if($_SESSION['lmouserok']==2){
      $teama[$st-1][$i]=$_POST["xteama".$i];
      $teamb[$st-1][$i]=$_POST["xteamb".$i];
  }
      if($lmtype==0){
        $goala[$st-1][$i]=trim($_POST["xgoala".$i]);
          if($goala[$st-1][$i]==""){$goala[$st-1][$i]=-1;}
          elseif($goala[$st-1][$i]=="_"){$goala[$st-1][$i]=-1;}
          elseif(strtoupper($goala[$st-1][$i])=="X"){$goala[$st-1][$i]=0;$msieg[$st-1][$i]=1;}
          else{
            $goala[$st-1][$i]=intval(trim($goala[$st-1][$i]));
            if($goala[$st-1][$i]==""){$goala[$st-1][$i]="0";}
            }
        $goalb[$st-1][$i]=trim($_POST["xgoalb".$i]);
          if($goalb[$st-1][$i]==""){$goalb[$st-1][$i]=-1;}
          elseif($goalb[$st-1][$i]=="_"){$goalb[$st-1][$i]=-1;}
          elseif(strtoupper($goalb[$st-1][$i])=="X"){$goalb[$st-1][$i]=0;$msieg[$st-1][$i]=2;}
          else{
            $goalb[$st-1][$i]=intval(trim($goalb[$st-1][$i]));
            if($goalb[$st-1][$i]==""){$goalb[$st-1][$i]="0";}
            }
        $msieg[$st-1][$i]=$_POST["xmsieg".$i];
        if($spez==1){$mspez[$st-1][$i]=$_POST["xmspez".$i];}
        $mnote[$st-1][$i]=trim($_POST["xmnote".$i]);
        $mberi[$st-1][$i]=trim($_POST["xmberi".$i]);
        if($_SESSION['lmouserok']==2 && $ftest0==1){$mtipp[$st-1][$i]=trim($_POST["xmtipp".$i]);}
        if(($st<$anzst) && ($favteam>0) && ($stat1==$favteam)){
          for($y=0;$y<$anzsp;$y++){
            if($teama[$st][$y]==$favteam){$stat2=$teamb[$st][$y];}
            if($teamb[$st][$y]==$favteam){$stat2=$teama[$st][$y];}
            }
          }
        }
      else{
        for($n=0;$n<$modus[$st-1];$n++){
          $goala[$st-1][$i][$n]=trim($_POST["xgoala".$i.$n]);
            if($goala[$st-1][$i][$n]==""){$goala[$st-1][$i][$n]=-1;}
            elseif($goala[$st-1][$i][$n]=="_"){$goala[$st-1][$i][$n]=-1;}
            else{
              $goala[$st-1][$i][$n]=intval(trim($goala[$st-1][$i][$n]));
              if($goala[$st-1][$i][$n]==""){$goala[$st-1][$i][$n]="0";}
              }
          $goalb[$st-1][$i][$n]=trim($_POST["xgoalb".$i.$n]);
            if($goalb[$st-1][$i][$n]==""){$goalb[$st-1][$i][$n]=-1;}
            elseif($goalb[$st-1][$i][$n]=="_"){$goalb[$st-1][$i][$n]=-1;}
            else{
              $goalb[$st-1][$i][$n]=intval(trim($goalb[$st-1][$i][$n]));
              if($goalb[$st-1][$i][$n]==""){$goalb[$st-1][$i][$n]="0";}
              }
          $mspez[$st-1][$i][$n]=$_POST["xmspez".$i.$n];
          $mnote[$st-1][$i][$n]=trim($_POST["xmnote".$i.$n]);
          $mberi[$st-1][$i][$n]=trim($_POST["xmberi".$i.$n]);
          if($_SESSION['lmouserok']==2 && $ftest0==1){$mtipp[$st-1][$i][$n]=trim($_POST["xmtipp".$i.$n]);}
          }
        if(($st<$anzst) && ($favteam>0) && ($stat1==$favteam)){
          for($y=0;$y<$anzsp;$y++){
            if($teama[$st][$y]==$favteam){$stat2=$teamb[$st][$y];}
            if($teamb[$st][$y]==$favteam){$stat2=$teama[$st][$y];}
            }
          }
        }
      }

    if($ftest0==1){ // Liga darf getippt werden
      if($aktauswert==1){
        require(PATH_TO_ADDON."/lmo-tippsavewert.php");
        }
      if($aktauswertges==1){
        require(PATH_TO_ADDON."/lmo-tippsavewertgesamt.php");
        }
      }
    $stz=trim($_POST["xstx"]);
    if($stz!=0){$stx=$stz;}else{$stx=$st;}
    $stz=$st;
    $st=$stx;
    $nticker=trim($_POST["xnticker"]);
    $nlines=split("[\n]",$_POST["xnlines"]);
    if(count($nlines)>0){for($z=count($nlines)-1;$z>=0;$z--){$y=array_pop($nlines);if($y!=""){array_unshift($nlines,$y);}}}
    if(count($nlines)==0){$nticker=0;}
    require(PATH_TO_LMO."/lmo-savefile.php");
    $st=$stz;
    }
  if($lmtype!=0){
    if($st>1){
      $teamt = array_pad(array("0"),129,"0");
      for($i=0;$i<($st-1);$i++){
        for($j=0;$j<(($anzteams/2)+1);$j++){
          $m1=array($goala[$i][$j][0],$goala[$i][$j][1],$goala[$i][$j][2],$goala[$i][$j][3],$goala[$i][$j][4],$goala[$i][$j][5],$goala[$i][$j][6]);
          $m2=array($goalb[$i][$j][0],$goalb[$i][$j][1],$goalb[$i][$j][2],$goalb[$i][$j][3],$goalb[$i][$j][4],$goalb[$i][$j][5],$goalb[$i][$j][6]);
          $m=call_user_func('gewinn',$i,$j,$modus[$i],$m1,$m2);
          if($m==1){$teamt[$teamb[$i][$j]]=1;}
          elseif($m==2){$teamt[$teama[$i][$j]]=1;}
          if(($klfin==1) && ($i==$st-2)){
            if($m==1){$teamt[$teamb[$i][$j]]=2;}
            elseif($m==2){$teamt[$teama[$i][$j]]=2;}
            }
          }
        }
      }
    }
  $addr=$_SERVER['PHP_SELF']."?action=admin&amp;todo=edit&amp;file=".$file."&amp;st=";
  $addb=$_SERVER['PHP_SELF']."?action=admin&amp;todo=tabs&amp;file=".$file."&amp;st=";
  $breite=17;
  if($spez==1){$breite=$breite+2;}
?>

<table class="lmosta" cellspacing="0" cellpadding="0" border="0">
  <tr>
    <td align="center">
      <table cellspacing="0" cellpadding="0" border="0">
        <tr>
<?
  for($i=1;$i<=$anzst;$i++){
    if($lmtype==1){
      if($i==$anzst){$j=$text[364];$k=$text[365];}
      elseif($i==$anzst-1){$j=$text[362];$k=$text[363];}
      elseif($i==$anzst-2){$j=$text[360];$k=$text[361];}
      elseif($i==$anzst-3){$j=$text[358];$k=$text[359];}
      else{$j=$i;$k=$text[366];}
      }
    else{$j=$i;$k=$text[9];}


    echo "<td align=\"right\" ";
    if($i<>$st){
      echo "class=\"lmost0\"><a href='$addr$i' onclick='return chklmolink(this.href)' title=\"".$k."\">".$j."</a>";
      }
    else{
      echo "class=\"lmost1\">".$j;
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
        <tr>
      </table>
    </td>
  </tr>
  <tr>
    <td align="center" class="lmost3">
      <form name="lmoedit" action="<?=$_SERVER['PHP_SELF']; ?>" method="post" onSubmit="return chklmopass()">
  
        <input type="hidden" name="action" value="admin">
        <input type="hidden" name="todo" value="edit">
        <input type="hidden" name="save" value="1">
        <input type="hidden" name="file" value="<?=$file; ?>">
        <input type="hidden" name="st" value="<?=$st; ?>">
        <table class="lmostb" cellspacing="0" cellpadding="0" border="0">

  
          <tr>
            <td class="lmost4" colspan="<?=$breite-4; ?>"><nobr><?=$st; ?>. <?=$text[2]; ?>
<?
  if($datum1[$st-1]!=""){
    $datum = split("[.]",$datum1[$st-1]);
    $dum1=$me[intval($datum[1])]." ".$datum[2];
    }
  else{
    $dum1="";
    }
  if($datum2[$st-1]!=""){
    $datum = split("[.]",$datum2[$st-1]);
    $dum2=$me[intval($datum[1])]." ".$datum[2];
    }
  else{
    $dum2="";
    }
?>
<? if($_SESSION['lmouserok']==2){ ?>
  <? echo " ".$text[3]." "; ?><acronym title="<?=$text[105] ?>"><input class="lmoadminein" type="text" name="xdatum1" size="10" maxlength="10" value="<?=$datum1[$st-1]; ?>" onChange="dolmoedit()"></acronym><script type="text/javascript">document.write('<a href="#" onclick="opencal(\'xdatum1\',\'<?=$dum1; ?>\')" title="<?=$text[139]; ?>" onMouseOver="lmoimg(\'d1\',img5)" onMouseOut="lmoimg(\'d1\',img4)"><img src="img/lmo-admin4.gif" name="ximgd1" width="14" height="10" border="0"></a>');</script>
  <? echo " ".$text[4]." "; ?><acronym title="<?=$text[106] ?>"><input class="lmoadminein" type="text" name="xdatum2" size="10" maxlength="10" value="<?=$datum2[$st-1]; ?>" onChange="dolmoedit()"></acronym><script type="text/javascript">document.write('<a href="#" onclick="opencal(\'xdatum2\',\'<?=$dum2; ?>\')" title="<?=$text[139]; ?>" onMouseOver="lmoimg(\'d2\',img5)" onMouseOut="lmoimg(\'d2\',img4)"><img src="img/lmo-admin4.gif" name="ximgd2" width="14" height="10" border="0"></a>');</script>
<? } ?>
              </nobr>
            </td>
<? if($lmtype==0){ ?>
            <td class="lmost4" width="2"><nobr><acronym title="<?=$text[213] ?>"><?=$text[217]; ?></acronym></nobr></td>
<? } ?>
            <td class="lmost4" width="2"><nobr><acronym title="<?=$text[112] ?>"><?=$text[218]; ?></acronym></nobr></td>
            <td class="lmost4" width="2"><nobr><acronym title="<?=$text[263] ?>"><?=$text[262]; ?></acronym></nobr></td>
<? if($_SESSION['lmouserok']==2 && $ftest0==1){ ?>
            <td class="lmost4" width="2"><nobr><acronym title="<?=$text['tipp'][57] ?>"><?=$text['tipp'][57]; ?></acronym></nobr></td>
<? } ?>
          </tr>

<?
  if($lmtype!=0){
    $anzsp=$anzteams;
    for($i=0;$i<$st;$i++){$anzsp=$anzsp/2;}
    if(($klfin==1) && ($st==$anzst)){$anzsp=$anzsp+1;}
    }
  for($i=0;$i<$anzsp;$i++){
    if($lmtype==0){
?>
          <tr>
<?
  if($mterm[$st-1][$i]>0){
    $dum1=strftime("%d.%m.%Y", $mterm[$st-1][$i]);
    $dum2=strftime("%H:%M", $mterm[$st-1][$i]);
    $dum3=$me[intval(strftime("%m", $mterm[$st-1][$i]))]." ".strftime("%Y", $mterm[$st-1][$i]);
    }
  else{
    $dum1="";
    $dum2="";
    $dum3="";
    }
?>
           <td class="lmost5"><nobr><acronym title="<?=$text[122] ?>"><input class="lmoadminein" type="text" name="xatdat<?=$i; ?>" size="10" maxlength="10" value="<?=$dum1; ?>" onChange="dolmoedit()"></acronym><script type="text/javascript">document.write('<a href="#" onclick="opencal(\'xatdat<?=$i; ?>\',\'<?=$dum3; ?>\')" title="<?=$text[139]; ?>" onMouseOver="lmoimg(\'<?=$i; ?>c\',img5)" onMouseOut="lmoimg(\'<?=$i; ?>c\',img4)"><img src="img/lmo-admin4.gif" name="ximg<?=$i; ?>c" width="14" height="10" border="0"></a>');</script></nobr></td>
           <td class="lmost5"><acronym title="<?=$text[123] ?>"><input class="lmoadminein" type="text" name="xattim<?=$i; ?>" size="5" maxlength="5" value="<?=$dum2; ?>" onChange="dolmoedit()"></acronym></td>
           <td class="lmost5" width="2">&nbsp;</td>
           <td class="lmost5" align="right"><nobr>

<? if($_SESSION['lmouserok']==2){ ?>
             <acronym title="<?=$text[107] ?>">
             <select class="lmoadminein" name="xteama<?=$i; ?>" onChange="dolmoedit()">
<?
  for($y=0;$y<=$anzteams;$y++){
    echo "<option value=\"".$y."\"";
    if($y==$teama[$st-1][$i]){echo " selected";}
    echo ">".$teams[$y]."</option>";
    }
?>
             </select>
             </acronym>
<? }else{echo $teams[$teama[$st-1][$i]];} ?>

    </nobr></td>
    <td class="lmost5" align="center" width="10">-</td>
    <td class="lmost5"><nobr>

<? if($_SESSION['lmouserok']==2){ ?>
<acronym title="<?=$text[108] ?>">
<select class="lmoadminein" name="xteamb<?=$i; ?>" onChange="dolmoedit()">
<?
  for($y=0;$y<=$anzteams;$y++){
    echo "<option value=\"".$y."\"";
    if($y==$teamb[$st-1][$i]){echo " selected";}
    echo ">".$teams[$y]."</option>";
    }
?>
</select>
</acronym>
<?
    }
  else{
    echo $teams[$teamb[$st-1][$i]];
    }
  if($goala[$st-1][$i]=="-1"){$goala[$st-1][$i]="_";}
  if($goalb[$st-1][$i]=="-1"){$goalb[$st-1][$i]="_";}
?>

    </nobr></td>
    <td class="lmost5" width="2">&nbsp;</td>
    <td class="lmost5" align="right"><acronym title="<?=$text[109] ?>"><input class="lmoadminein" type="text" name="xgoala<?=$i; ?>" size="4" maxlength="4" value="<?=$goala[$st-1][$i]; ?>" onChange="lmotorgte('a','<?=$i; ?>')" onKeyDown="lmotorclk('a','<?=$i; ?>',event.keyCode)"></acronym></td>
    <td class="lmost5" align="center"><table cellpadding="0" cellspacing="0" border="0"><tr><td><script type="text/javascript">document.write('<a href="#" onclick="lmotorauf(\"a\",\"<?=$i; ?>\",1);" title="<?=$text[120]; ?>" onMouseOver="lmoimg(\"<?=$i; ?>a\",img1)" onMouseOut="lmoimg(\"<?=$i; ?>a\",img0)"><img src="img/lmo-admin0.gif" name="ximg<?=$i; ?>a" width="7" height="7" border="0"></a>')</script></td></tr><tr><td><script type="text/javascript">document.write('<a href="#" onclick="lmotorauf(\"a\",\"<?=$i; ?>\",-1);" title="<?=$text[120]; ?>" onMouseOver="lmoimg(\"<?=$i; ?>b\",img3)" onMouseOut="lmoimg(\"<?=$i; ?>b\",img2)"><img src="img/lmo-admin2.gif" name="ximg<?=$i; ?>b" width="7" height="7" border="0"></a>')</script></td></tr></table></td>
    <td class="lmost5" align="center" width="8">:</td>
    <td class="lmost5" align="right"><acronym title="<?=$text[110] ?>"><input class="lmoadminein" type="text" name="xgoalb<?=$i; ?>" size="4" maxlength="4" value="<?=$goalb[$st-1][$i]; ?>" onChange="lmotorgte('b','<?=$i; ?>')" onKeyDown="lmotorclk('b','<?=$i; ?>',event.keyCode)"></acronym></td>
    <td class="lmost5" align="center"><table cellpadding="0" cellspacing="0" border="0"><tr><td><script type="text/javascript">document.write('<a href="#" onclick="lmotorauf(\"b\",\"<?=$i; ?>\",1);" title="<?=$text[121]; ?>" onMouseOver="lmoimg(\"<?=$i; ?>f\",img1)" onMouseOut="lmoimg(\"<?=$i; ?>f\",img0)"><img src="img/lmo-admin0.gif" name="ximg<?=$i; ?>f" width="7" height="7" border="0"></a>')</script></td></tr><tr><td><script type="text/javascript">document.write('<a href="#" onclick="lmotorauf(\"b\",\"<?=$i; ?>\",-1);" title="<?=$text[121]; ?>" onMouseOver="lmoimg(\"<?=$i; ?>d\",img3)" onMouseOut="lmoimg(\"<?=$i; ?>d\",img2)"><img src="img/lmo-admin2.gif" name="ximg<?=$i; ?>d" width="7" height="7" border="0"></a>')</script></td></tr></table></td>
  <? if($spez==1){ ?>
    <td class="lmost5" width="2">&nbsp;</td>
    <td class="lmost5">
<acronym title="<?=$text[111] ?>">
<select class="lmoadminein" name="xmspez<?=$i; ?>" onChange="dolmoedit()">
<?
  echo "<option";
    if($mspez[$st-1][$i]=="&nbsp;"){echo " selected";}
    echo ">_</option>";
  echo "<option";
    if($mspez[$st-1][$i]==$text[0]){echo " selected";}
    echo ">".$text[0]."</option>";
  echo "<option";
    if($mspez[$st-1][$i]==$text[1]){echo " selected";}
    echo ">".$text[1]."</option>";
?>
</select>
</acronym>
    </td>
  <? } ?>
    <td class="lmost5" width="2">&nbsp;</td>
    <td class="lmost5">
<acronym title="<?=$text[213] ?>">
<select class="lmoadminein" name="xmsieg<?=$i; ?>" onChange="dolmoedit()">
<?
  echo "<option value=\"0\"";
    if($msieg[$st-1][$i]==0){echo " selected";}
    echo ">_</option>";
  echo "<option value=\"1\"";
    if($msieg[$st-1][$i]==1){echo " selected";}
    echo ">".$text[214]."</option>";
  echo "<option value=\"2\"";
    if($msieg[$st-1][$i]==2){echo " selected";}
    echo ">".$text[215]."</option>";
  echo "<option value=\"3\"";
    if($msieg[$st-1][$i]==3){echo " selected";}
    echo ">".$text[216]."</option>";
?>
</select>
</acronym>
    </td>
    <td class="lmost5"><acronym title="<?=$text[112] ?>"><input class="lmoadminein" type="text" name="xmnote<?=$i; ?>" size="16" maxlength="255" value="<?=$mnote[$st-1][$i]; ?>" onChange="dolmoedit()"></acronym></td>
    <td class="lmost5"><acronym title="<?=$text[263] ?>"><input class="lmoadminein" type="text" name="xmberi<?=$i; ?>" size="16" maxlength="128" value="<?=$mberi[$st-1][$i]; ?>" onChange="dolmoedit()"></acronym></td>
<? if($_SESSION['lmouserok']==2 && $ftest0==1){ ?>
    <td class="lmost5"><acronym title="<?=$text['tipp'][57] ?>">
    <select class="lmoadminein" name="xmtipp<?=$i; ?>" onChange="dolmoedit()">
<?
  echo "<option value=\"0\"";
    if($mtipp[$st-1][$i]<1){echo " selected";}
    echo ">_</option>";
  echo "<option value=\"1\"";
    if($mtipp[$st-1][$i]==1){echo " selected";}
    echo ">".$text['tipp'][199]."</option>";
?>
</select>
</acronym>
    </td>
<? } ?>

  </tr>
<?
    }
  else{ 
    for($n=0;$n<$modus[$st-1];$n++){
?>
<? if(($klfin==1) && ($st==$anzst)){ ?>
    <tr><td class="lmost8" colspan=<?=$breite; ?>><nobr><? if($i==1){echo "&nbsp;<br>";} echo $text[419+$i]; ?></nobr></td></tr>
<? } ?>
  <tr>
<?
  if($mterm[$st-1][$i][$n]>0){
    $dum1=strftime("%d.%m.%Y", $mterm[$st-1][$i][$n]);
    $dum2=strftime("%H:%M", $mterm[$st-1][$i][$n]);
    $dum3=$me[intval(strftime("%m", $mterm[$st-1][$i][$n]))]." ".strftime("%Y", $mterm[$st-1][$i][$n]);
    }
  else{
    $dum1="";
    $dum2="";
    $dum3="";
    }
?>
    <td class="lmost5"><nobr><acronym title="<?=$text[122] ?>"><input class="lmoadminein" type="text" name="xatdat<?=$i.$n; ?>" size="10" maxlength="10" value="<?=$dum1; ?>" onChange="dolmoedit()"></acronym><script type="text/javascript">document.write('<a href="#" onclick="opencal(\'xatdat<?=$i.$n; ?>\',\'<?=$dum3; ?>\')" title="<?=$text[139]; ?>" onMouseOver="lmoimg(\'<?=$i.$n; ?>c\',img5)" onMouseOut="lmoimg(\'<?=$i.$n; ?>c\',img4)"><img src="img/lmo-admin4.gif" name="ximg<?=$i.$n; ?>c" width="14" height="10" border="0"></a>');</script></nobr></td>
    <td class="lmost5"><acronym title="<?=$text[123] ?>"><input class="lmoadminein" type="text" name="xattim<?=$i.$n; ?>" size="5" maxlength="5" value="<?=$dum2; ?>" onChange="dolmoedit()"></acronym></td>
    <td class="lmost5" width="2">&nbsp;</td>
<? if($n==0){ ?>
    <td class="lmost5" align="right"><nobr>

<? if($_SESSION['lmouserok']==2){ ?>
<acronym title="<?=$text[107] ?>">
<select class="lmoadminein" name="xteama<?=$i; ?>" onChange="dolmoedit()">
<?
  if(($klfin==1) && ($st==$anzst) && ($i==1)){
    echo "<option value=\"0\"";
    if($teama[$st-1][$i]==0){echo " selected";}
    echo ">".$teams[0]."</option>";
    for($y=1;$y<=$anzteams;$y++){
      if($teamt[$y]==2){
        echo "<option value=\"".$y."\"";
        if($y==$teama[$st-1][$i]){echo " selected";}
        echo ">".$teams[$y]."</option>";
        }
      }
    }
  else{
    for($y=0;$y<=$anzteams;$y++){
      if($teamt[$y]==0){
        echo "<option value=\"".$y."\"";
        if($y==$teama[$st-1][$i]){echo " selected";}
        echo ">".$teams[$y]."</option>";
        }
      }
    }
?>
</select>
</acronym>
<? }else{echo $teams[$teama[$st-1][$i]];} ?>

    </nobr></td>
    <td class="lmost5" align="center" width="10">-</td>
    <td class="lmost5"><nobr>

<? if($_SESSION['lmouserok']==2){ ?>
<acronym title="<?=$text[108] ?>">
<select class="lmoadminein" name="xteamb<?=$i; ?>" onChange="dolmoedit()">
<?
  if(($klfin==1) && ($st==$anzst) && ($i==1)){
    echo "<option value=\"0\"";
    if($teamb[$st-1][$i]==0){echo " selected";}
    echo ">".$teams[0]."</option>";
    for($y=1;$y<=$anzteams;$y++){
      if($teamt[$y]==2){
        echo "<option value=\"".$y."\"";
        if($y==$teamb[$st-1][$i]){echo " selected";}
        echo ">".$teams[$y]."</option>";
        }
      }
    }
  else{
    for($y=0;$y<=$anzteams;$y++){
      if($teamt[$y]==0){
        echo "<option value=\"".$y."\"";
        if($y==$teamb[$st-1][$i]){echo " selected";}
        echo ">".$teams[$y]."</option>";
        }
      }
    }
?>
</select>
</acronym>
<? }else{echo $teams[$teamb[$st-1][$i]];} ?>

    </nobr></td>
<? }else{ ?>
    <td class="lmost5" colspan="3">&nbsp;</td>
<?
    }
  if($goala[$st-1][$i][$n]=="-1"){$goala[$st-1][$i][$n]="_";}
  if($goalb[$st-1][$i][$n]=="-1"){$goalb[$st-1][$i][$n]="_";}
?>
    <td class="lmost5" width="2">&nbsp;</td>
    <td class="lmost5" align="right"><acronym title="<?=$text[109] ?>"><input class="lmoadminein" type="text" name="xgoala<?=$i.$n; ?>" size="4" maxlength="4" value="<?=$goala[$st-1][$i][$n]; ?>" onChange="lmotorgte('a','<?=$i.$n; ?>')" onKeyDown="lmotorclk('a','<?=$i.$n; ?>',event.keyCode)"></acronym></td>
    <td class="lmost5" align="center"><table cellpadding="0" cellspacing="0" border="0"><tr><td><script type="text/javascript">document.write('<a href="#" onclick="lmotorauf(\"a\",\"<?=$i.$n; ?>\",1);" title="<?=$text[120]; ?>" onMouseOver="lmoimg(\"<?=$i.$n; ?>a\",img1)" onMouseOut="lmoimg(\"<?=$i.$n; ?>a\",img0)"><img src="img/lmo-admin0.gif" name="ximg<?=$i.$n; ?>a" width="7" height="7" border="0"></a>')</script></td></tr><tr><td><script type="text/javascript">document.write('<a href="#" onclick="lmotorauf(\"a\",\"<?=$i.$n; ?>\",-1);" title="<?=$text[120]; ?>" onMouseOver="lmoimg(\"<?=$i.$n; ?>b\",img3)" onMouseOut="lmoimg(\"<?=$i.$n; ?>b\",img2)"><img src="img/lmo-admin2.gif" name="ximg<?=$i.$n; ?>b" width="7" height="7" border="0"></a>')</script></td></tr></table></td>
    <td class="lmost5" align="center" width="8">:</td>
    <td class="lmost5" align="right"><acronym title="<?=$text[110] ?>"><input class="lmoadminein" type="text" name="xgoalb<?=$i.$n; ?>" size="4" maxlength="4" value="<?=$goalb[$st-1][$i][$n]; ?>" onChange="lmotorgte('b','<?=$i.$n; ?>')" onKeyDown="lmotorclk('b','<?=$i.$n; ?>',event.keyCode)"></acronym></td>
    <td class="lmost5" align="center"><table cellpadding="0" cellspacing="0" border="0"><tr><td><script type="text/javascript">document.write('<a href="#" onclick="lmotorauf(\"b\",\"<?=$i.$n; ?>\",1);" title="<?=$text[121]; ?>" onMouseOver="lmoimg(\"<?=$i.$n; ?>f\",img1)" onMouseOut="lmoimg(\"<?=$i.$n; ?>f\",img0)"><img src="img/lmo-admin0.gif" name="ximg<?=$i.$n; ?>f" width="7" height="7" border="0"></a>')</script></td></tr><tr><td><script type="text/javascript">document.write('<a href="#" onclick="lmotorauf(\"b\",\"<?=$i.$n; ?>\",-1);" title="<?=$text[121]; ?>" onMouseOver="lmoimg(\"<?=$i.$n; ?>d\",img3)" onMouseOut="lmoimg(\"<?=$i.$n; ?>d\",img2)"><img src="img/lmo-admin2.gif" name="ximg<?=$i.$n; ?>d" width="7" height="7" border="0"></a>')</script></td></tr></table></td>
    <td class="lmost5" width="2">&nbsp;</td>
    <td class="lmost5">
<acronym title="<?=$text[111] ?>">
<select class="lmoadminein" name="xmspez<?=$i.$n; ?>" onChange="dolmoedit()">
<?
  echo "<option";
    if($mspez[$st-1][$i][$n]=="&nbsp;"){echo " selected";}
    echo ">_</option>";
  echo "<option";
    if($mspez[$st-1][$i][$n]==$text[0]){echo " selected";}
    echo ">".$text[0]."</option>";
  echo "<option";
    if($mspez[$st-1][$i][$n]==$text[1]){echo " selected";}
    echo ">".$text[1]."</option>";
?>
</select>
</acronym>
    </td>
    <td class="lmost5" width="2">&nbsp;</td>
    <td class="lmost5"><acronym title="<?=$text[112] ?>"><input class="lmoadminein" type="text" name="xmnote<?=$i.$n; ?>" size="16" maxlength="255" value="<?=$mnote[$st-1][$i][$n]; ?>" onChange="dolmoedit()"></acronym></td>
    <td class="lmost5"><acronym title="<?=$text[263] ?>"><input class="lmoadminein" type="text" name="xmberi<?=$i.$n; ?>" size="16" maxlength="128" value="<?=$mberi[$st-1][$i][$n]; ?>" onChange="dolmoedit()"></acronym></td>
<? if($_SESSION['lmouserok']==2 && $ftest0==1){ ?>
    <td class="lmost5"><acronym title="<?=$text['tipp'][57] ?>">
    <select class="lmoadminein" name="xmtipp<?=$i.$n; ?>" onChange="dolmoedit()">
<?
  echo "<option value=\"0\"";
    if($mtipp[$st-1][$i][$n]<1){echo " selected";}
    echo ">_</option>";
  echo "<option value=\"1\"";
    if($mtipp[$st-1][$i][$n]==1){echo " selected";}
    echo ">".$text[199]."</option>";
?>
</select>
</acronym>
    </td>
<? } ?>
  </tr>
<? } ?>
<? if(($modus[$st-1]>1) && ($i<$anzsp-1)){ ?>
  <tr><td class="lmost5" colspan="<?=$breite; ?>">&nbsp;</td></tr>
<? }}} ?>
  <tr>
    <td class="lmost4" colspan="<?=$breite; ?>" align="center"><nobr><?=$text[206]; ?></nobr></td>
  </tr>
  <tr>
    <td class="lmost5" colspan="<?=$breite; ?>" align="center"><nobr><acronym title="<?=$text[192] ?>"><?=$text[191]; ?> <select class="lmoadminein" name="xstx" onChange="dolmoedit()">
<?
  for($y=0;$y<=$anzst;$y++){
    echo "<option value=\"".$y."\"";
    if($save==1){
      if($y==0){echo ">".$text[403]."</option>";}
      else{
        if($y==$stx){echo " selected";}
        echo ">".$y.". ".$text[2]."</option>";
        }
      }
    else{
      if($y==0){echo " selected>".$text[403]."</option>";}
      else{echo ">".$y.". ".$text[2]."</option>";}
      }
    }
?>
    </select></acronym></td>
  </tr>
  <tr>
    <td class="lmost5" colspan="<?=$breite; ?>" align="center">
      <acronym title="<?=$text[208] ?>"><?=$text[207]; ?> <select class="lmoadminein" name="xnticker" onChange="dolmoedit()"><? echo "<option value=\"1\""; if($nticker==1){echo " selected";} echo ">".$text[181]."</option>"; echo "<option value=\"0\""; if($nticker==0){echo " selected";} echo ">".$text[182]."</option>"; ?></select></acronym><br>
      <acronym title="<?=$text[210] ?>"><textarea class="lmoadminein" name="xnlines" cols="50" rows="4" wrap="off" onChange="dolmoedit()"><? if(count($nlines)>0){foreach($nlines as $y){echo $y."\n";}} ?></textarea></acronym>
    </td>
  </tr>
  <tr><td class="lmost4" colspan="<?=$breite; ?>" align="center">
    <acronym title="<?=$text[114] ?>"><input class="lmoadminbut" type="submit" name="best" value="<?=$text[103]; ?>"></acronym>
  </td></tr>
  

  </table></form></td></tr>
  <tr>
    <td><table width="100%" cellspacing="0" cellpadding="0" border="0"><tr>
<? 
  $st0=$st-1;
  if($st>1){echo "<td class=\"lmost2\"><a href='$addr$st0' onclick='return chklmolink(this.href)' title=\"".$text[6]."\">".$text[5]."</a></td>";}
  if($st!=-1){echo "<td class=\"lmost2\" align=\"center\"><a href='$addr-1' onclick='return chklmolink(this.href)' title=\"".$text[100]."\">".$text[99]."</a></td>";}
    else{echo "<td class=\"lmost1\" align=\"center\">".$text[99]."</td>";}
  if($hands==1){if($todo!="tabs"){echo "<td class=\"lmost2\" align=\"center\"><a href='$addb.$stx' onclick='return chklmolink(this.href)' title=\"".$text[409]."\">".$text[410]."</a></td>";}
    else{echo "<td class=\"lmost1\" align=\"center\">".$text[410]."</td>";}}
if($_SESSION['lmouserok']==2){
  if($st!=-2){echo "<td class=\"lmost2\" align=\"center\"><a href='$addr-2' onclick='return chklmolink(this.href)' title=\"".$text[102]."\">".$text[101]."</a></td>";}
    else{echo "<td class=\"lmost1\" align=\"center\">".$text[101]."</td>";}
  }
  $st0=$st+1;
  if($st<$anzst){echo "<td align=\"right\" class=\"lmost2\"><a href='$addr$st0' onclick='return chklmolink(this.href)' title=\"".$text[8]."\">".$text[7]."</a></td>";}
?>
    </tr></table></td>
  </tr>
</table>

<? } ?>