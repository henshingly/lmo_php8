<?PHP
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
require_once("lmo-admintest.php");
if($file!=""){
  $ftest0=1;
  $liga=substr($file, strrpos($file,"/")+1,-4);

  if($immeralle==0){
    $ftest0=0;$ftest1="";
    $ftest1=split("[,]",$ligenzutippen);
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
  require("lmo-openfile.php");
  if(!isset($save)){$save=0;}
  if($save==1){
    $me=array("0","January","February","March","April","May","June","July","August","September","October","November","December");
if($HTTP_SESSION_VARS["lmouserok"]==2){
    $datum1[$st-1]=trim($HTTP_POST_VARS["xdatum1"]);
    if($datum1[$st-1]!=""){
      $datum = split("[.]",$datum1[$st-1]);
      $dummy=strtotime($datum[0]." ".$me[intval($datum[1])]." ".$datum[2]);
      if($dummy>-1){$datum1[$st-1]=strftime("%d.%m.%Y",$dummy);}else{$datum1[$st-1]="";}
      }
    $datum2[$st-1]=trim($HTTP_POST_VARS["xdatum2"]);
    if($datum2[$st-1]!=""){
      $datum = split("[.]",$datum2[$st-1]);
      $dummy=strtotime($datum[0]." ".$me[intval($datum[1])]." ".$datum[2]);
      if($dummy>-1){$datum2[$st-1]=strftime("%d.%m.%Y",$dummy);}else{$datum2[$st-1]="";}
      }
  }
    if($hands==1){for($i=$st-1;$i<$stanz;$i++){$handp[$i]=0;}}
    for($i=0;$i<$anzsp;$i++){
      if($lmtype==0){
        $dum1=trim($HTTP_POST_VARS["xatdat".$i]);
        $dum2=trim($HTTP_POST_VARS["xattim".$i]);
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
          $dum1=trim($HTTP_POST_VARS["xatdat".$i.$n]);
          $dum2=trim($HTTP_POST_VARS["xattim".$i.$n]);
          if($dum1!=""){
            if($dum2==""){$dum2=$deftime;}
            $datu1 = split("[.]",$dum1);
            $datu2 = split("[:]",$dum2);
            $dummy=strtotime($datu1[0]." ".$me[intval($datu1[1])]." ".$datu1[2]." ".$datu2[0].":".$datu2[1]);
            if($dummy>-1){$mterm[$st-1][$i][$n]=$dummy;}else{$mterm[$st-1][$i][$n]="";}
            }
          }
        }
if($lmouserok==2){
      $teama[$st-1][$i]=$HTTP_POST_VARS["xteama".$i];
      $teamb[$st-1][$i]=$HTTP_POST_VARS["xteamb".$i];
  }
      if($lmtype==0){
        $goala[$st-1][$i]=trim($HTTP_POST_VARS["xgoala".$i]);
          if($goala[$st-1][$i]==""){$goala[$st-1][$i]=-1;}
          elseif($goala[$st-1][$i]=="_"){$goala[$st-1][$i]=-1;}
          elseif(strtoupper($goala[$st-1][$i])=="X"){$goala[$st-1][$i]=0;$msieg[$st-1][$i]=1;}
          else{
            $goala[$st-1][$i]=intval(trim($goala[$st-1][$i]));
            if($goala[$st-1][$i]==""){$goala[$st-1][$i]="0";}
            }
        $goalb[$st-1][$i]=trim($HTTP_POST_VARS["xgoalb".$i]);
          if($goalb[$st-1][$i]==""){$goalb[$st-1][$i]=-1;}
          elseif($goalb[$st-1][$i]=="_"){$goalb[$st-1][$i]=-1;}
          elseif(strtoupper($goalb[$st-1][$i])=="X"){$goalb[$st-1][$i]=0;$msieg[$st-1][$i]=2;}
          else{
            $goalb[$st-1][$i]=intval(trim($goalb[$st-1][$i]));
            if($goalb[$st-1][$i]==""){$goalb[$st-1][$i]="0";}
            }
        $msieg[$st-1][$i]=$HTTP_POST_VARS["xmsieg".$i];
        if($spez==1){$mspez[$st-1][$i]=$HTTP_POST_VARS["xmspez".$i];}
        $mnote[$st-1][$i]=trim($HTTP_POST_VARS["xmnote".$i]);
        $mberi[$st-1][$i]=trim($HTTP_POST_VARS["xmberi".$i]);
        if($lmouserok==2 && $ftest0==1){$mtipp[$st-1][$i]=trim($HTTP_POST_VARS["xmtipp".$i]);}
        if(($st<$anzst) && ($favteam>0) && ($stat1==$favteam)){
          for($y=0;$y<$anzsp;$y++){
            if($teama[$st][$y]==$favteam){$stat2=$teamb[$st][$y];}
            if($teamb[$st][$y]==$favteam){$stat2=$teama[$st][$y];}
            }
          }
        }
      else{
        for($n=0;$n<$modus[$st-1];$n++){
          $goala[$st-1][$i][$n]=trim($HTTP_POST_VARS["xgoala".$i.$n]);
            if($goala[$st-1][$i][$n]==""){$goala[$st-1][$i][$n]=-1;}
            elseif($goala[$st-1][$i][$n]=="_"){$goala[$st-1][$i][$n]=-1;}
            else{
              $goala[$st-1][$i][$n]=intval(trim($goala[$st-1][$i][$n]));
              if($goala[$st-1][$i][$n]==""){$goala[$st-1][$i][$n]="0";}
              }
          $goalb[$st-1][$i][$n]=trim($HTTP_POST_VARS["xgoalb".$i.$n]);
            if($goalb[$st-1][$i][$n]==""){$goalb[$st-1][$i][$n]=-1;}
            elseif($goalb[$st-1][$i][$n]=="_"){$goalb[$st-1][$i][$n]=-1;}
            else{
              $goalb[$st-1][$i][$n]=intval(trim($goalb[$st-1][$i][$n]));
              if($goalb[$st-1][$i][$n]==""){$goalb[$st-1][$i][$n]="0";}
              }
          $mspez[$st-1][$i][$n]=$HTTP_POST_VARS["xmspez".$i.$n];
          $mnote[$st-1][$i][$n]=trim($HTTP_POST_VARS["xmnote".$i.$n]);
          $mberi[$st-1][$i][$n]=trim($HTTP_POST_VARS["xmberi".$i.$n]);
          if($lmouserok==2 && $ftest0==1){$mtipp[$st-1][$i][$n]=trim($HTTP_POST_VARS["xmtipp".$i.$n]);}
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
        require("lmo-tippsavewert.php");
        }
      if($aktauswertges==1){
        require("lmo-tippsavewertgesamt.php");
        }
      }
    $stz=trim($HTTP_POST_VARS["xstx"]);
    if($stz!=0){$stx=$stz;}else{$stx=$st;}
    $stz=$st;
    $st=$stx;
    $nticker=trim($HTTP_POST_VARS["xnticker"]);
    $nlines=split("[\n]",$HTTP_POST_VARS["xnlines"]);
    if(count($nlines)>0){for($z=count($nlines)-1;$z>=0;$z--){$y=array_pop($nlines);if($y!=""){array_unshift($nlines,$y);}}}
    if(count($nlines)==0){$nticker=0;}
    require("lmo-savefile.php");
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
  $addr=$PHP_SELF."?action=admin&amp;todo=edit&amp;file=".$file."&amp;st=";
  $addb=$PHP_SELF."?action=admin&amp;todo=tabs&amp;file=".$file."&amp;st=";
  $breite=17;
  if($spez==1){$breite=$breite+2;}
?>

<table class="lmosta" cellspacing="0" cellpadding="0" border="0">
  <tr>
    <td align="center"><table cellspacing="0" cellpadding="0" border="0"><tr>
<?PHP
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
      echo "class=\"lmost0\"><a href=\"javascript:chklmolink('".$addr.$i."');\" title=\"".$k."\">".$j."</a>";
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
    <td class="lmost4" colspan="<?PHP echo $breite-4; ?>"><nobr><?PHP echo $st; ?>. <?PHP echo $text[2]; ?>
<?PHP
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
<?PHP if($lmouserok==2){ ?>
  <?PHP echo " ".$text[3]." "; ?><acronym title="<?PHP echo $text[105] ?>"><input class="lmoadminein" type="text" name="xdatum1" size="10" maxlength="10" value="<?PHP echo $datum1[$st-1]; ?>" onChange="dolmoedit()"></acronym><a href="javascript:opencal('xdatum1','<?PHP echo $dum1; ?>')" title="<?PHP echo $text[139]; ?>" onMouseOver="lmoimg('d1',img5)" onMouseOut="lmoimg('d1',img4)"><img src="lmo-admin4.gif" name="ximgd1" width="14" height="10" border="0"></a>
  <?PHP echo " ".$text[4]." "; ?><acronym title="<?PHP echo $text[106] ?>"><input class="lmoadminein" type="text" name="xdatum2" size="10" maxlength="10" value="<?PHP echo $datum2[$st-1]; ?>" onChange="dolmoedit()"></acronym><a href="javascript:opencal('xdatum2','<?PHP echo $dum2; ?>')" title="<?PHP echo $text[139]; ?>" onMouseOver="lmoimg('d2',img5)" onMouseOut="lmoimg('d2',img4)"><img src="lmo-admin4.gif" name="ximgd2" width="14" height="10" border="0"></a>
<?PHP } ?>
    </nobr></td>
<?PHP if($lmtype==0){ ?>
    <td class="lmost4" width="2"><nobr><acronym title="<?PHP echo $text[213] ?>"><?PHP echo $text[217]; ?></acronym></nobr></td>
<?PHP } ?>
    <td class="lmost4" width="2"><nobr><acronym title="<?PHP echo $text[112] ?>"><?PHP echo $text[218]; ?></acronym></nobr></td>
    <td class="lmost4" width="2"><nobr><acronym title="<?PHP echo $text[263] ?>"><?PHP echo $text[262]; ?></acronym></nobr></td>
<?PHP if($lmouserok==2 && $ftest0==1){ ?>
    <td class="lmost4" width="2"><nobr><acronym title="<?PHP echo $text[2057] ?>"><?PHP echo $text[2057]; ?></acronym></nobr></td>
<?PHP } ?>
  </tr>

<?PHP
  if($lmtype!=0){
    $anzsp=$anzteams;
    for($i=0;$i<$st;$i++){$anzsp=$anzsp/2;}
    if(($klfin==1) && ($st==$anzst)){$anzsp=$anzsp+1;}
    }
  for($i=0;$i<$anzsp;$i++){
    if($lmtype==0){
?>
  <tr>
<?PHP
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
    <td class="lmost5"><nobr><acronym title="<?PHP echo $text[122] ?>"><input class="lmoadminein" type="text" name="xatdat<?PHP echo $i; ?>" size="10" maxlength="10" value="<?PHP echo $dum1; ?>" onChange="dolmoedit()"></acronym><a href="javascript:opencal('xatdat<?PHP echo $i; ?>','<?PHP echo $dum3; ?>')" title="<?PHP echo $text[139]; ?>" onMouseOver="lmoimg('<?PHP echo $i; ?>c',img5)" onMouseOut="lmoimg('<?PHP echo $i; ?>c',img4)"><img src="lmo-admin4.gif" name="ximg<?PHP echo $i; ?>c" width="14" height="10" border="0"></a></nobr></td>
    <td class="lmost5"><acronym title="<?PHP echo $text[123] ?>"><input class="lmoadminein" type="text" name="xattim<?PHP echo $i; ?>" size="5" maxlength="5" value="<?PHP echo $dum2; ?>" onChange="dolmoedit()"></acronym></td>
    <td class="lmost5" width="2">&nbsp;</td>
    <td class="lmost5" align="right"><nobr>

<?PHP if($lmouserok==2){ ?>
<acronym title="<?PHP echo $text[107] ?>">
<select class="lmoadminein" name="xteama<?PHP echo $i; ?>" onChange="dolmoedit()">
<?PHP
  for($y=0;$y<=$anzteams;$y++){
    echo "<option value=\"".$y."\"";
    if($y==$teama[$st-1][$i]){echo " selected";}
    echo ">".$teams[$y]."</option>";
    }
?>
</select>
</acronym>
<?PHP }else{echo $teams[$teama[$st-1][$i]];} ?>

    </nobr></td>
    <td class="lmost5" align="center" width="10">-</td>
    <td class="lmost5"><nobr>

<?PHP if($lmouserok==2){ ?>
<acronym title="<?PHP echo $text[108] ?>">
<select class="lmoadminein" name="xteamb<?PHP echo $i; ?>" onChange="dolmoedit()">
<?PHP
  for($y=0;$y<=$anzteams;$y++){
    echo "<option value=\"".$y."\"";
    if($y==$teamb[$st-1][$i]){echo " selected";}
    echo ">".$teams[$y]."</option>";
    }
?>
</select>
</acronym>
<?PHP
    }
  else{
    echo $teams[$teamb[$st-1][$i]];
    }
  if($goala[$st-1][$i]=="-1"){$goala[$st-1][$i]="_";}
  if($goalb[$st-1][$i]=="-1"){$goalb[$st-1][$i]="_";}
?>

    </nobr></td>
    <td class="lmost5" width="2">&nbsp;</td>
    <td class="lmost5" align="right"><acronym title="<?PHP echo $text[109] ?>"><input class="lmoadminein" type="text" name="xgoala<?PHP echo $i; ?>" size="4" maxlength="4" value="<?PHP echo $goala[$st-1][$i]; ?>" onChange="lmotorgte('a','<?PHP echo $i; ?>')" onKeyDown="lmotorclk('a','<?PHP echo $i; ?>',event.keyCode)"></acronym></td>
    <td class="lmost5" align="center"><table cellpadding="0" cellspacing="0" border="0"><tr><td><a href="javascript:lmotorauf('a','<?PHP echo $i; ?>',1);" title="<?PHP echo $text[120]; ?>" onMouseOver="lmoimg('<?PHP echo $i; ?>a',img1)" onMouseOut="lmoimg('<?PHP echo $i; ?>a',img0)"><img src="lmo-admin0.gif" name="ximg<?PHP echo $i; ?>a" width="7" height="7" border="0"></a></td></tr><tr><td><a href="javascript:lmotorauf('a','<?PHP echo $i; ?>',-1);" title="<?PHP echo $text[120]; ?>" onMouseOver="lmoimg('<?PHP echo $i; ?>b',img3)" onMouseOut="lmoimg('<?PHP echo $i; ?>b',img2)"><img src="lmo-admin2.gif" name="ximg<?PHP echo $i; ?>b" width="7" height="7" border="0"></a></td></tr></table></td>
    <td class="lmost5" align="center" width="8">:</td>
    <td class="lmost5" align="right"><acronym title="<?PHP echo $text[110] ?>"><input class="lmoadminein" type="text" name="xgoalb<?PHP echo $i; ?>" size="4" maxlength="4" value="<?PHP echo $goalb[$st-1][$i]; ?>" onChange="lmotorgte('b','<?PHP echo $i; ?>')" onKeyDown="lmotorclk('b','<?PHP echo $i; ?>',event.keyCode)"></acronym></td>
    <td class="lmost5" align="center"><table cellpadding="0" cellspacing="0" border="0"><tr><td><a href="javascript:lmotorauf('b','<?PHP echo $i; ?>',1);" title="<?PHP echo $text[121]; ?>" onMouseOver="lmoimg('<?PHP echo $i; ?>f',img1)" onMouseOut="lmoimg('<?PHP echo $i; ?>f',img0)"><img src="lmo-admin0.gif" name="ximg<?PHP echo $i; ?>f" width="7" height="7" border="0"></a></td></tr><tr><td><a href="javascript:lmotorauf('b','<?PHP echo $i; ?>',-1);" title="<?PHP echo $text[121]; ?>" onMouseOver="lmoimg('<?PHP echo $i; ?>d',img3)" onMouseOut="lmoimg('<?PHP echo $i; ?>d',img2)"><img src="lmo-admin2.gif" name="ximg<?PHP echo $i; ?>d" width="7" height="7" border="0"></a></td></tr></table></td>
  <?PHP if($spez==1){ ?>
    <td class="lmost5" width="2">&nbsp;</td>
    <td class="lmost5">
<acronym title="<?PHP echo $text[111] ?>">
<select class="lmoadminein" name="xmspez<?PHP echo $i; ?>" onChange="dolmoedit()">
<?PHP
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
  <?PHP } ?>
    <td class="lmost5" width="2">&nbsp;</td>
    <td class="lmost5">
<acronym title="<?PHP echo $text[213] ?>">
<select class="lmoadminein" name="xmsieg<?PHP echo $i; ?>" onChange="dolmoedit()">
<?PHP
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
    <td class="lmost5"><acronym title="<?PHP echo $text[112] ?>"><input class="lmoadminein" type="text" name="xmnote<?PHP echo $i; ?>" size="16" maxlength="255" value="<?PHP echo $mnote[$st-1][$i]; ?>" onChange="dolmoedit()"></acronym></td>
    <td class="lmost5"><acronym title="<?PHP echo $text[263] ?>"><input class="lmoadminein" type="text" name="xmberi<?PHP echo $i; ?>" size="16" maxlength="128" value="<?PHP echo $mberi[$st-1][$i]; ?>" onChange="dolmoedit()"></acronym></td>
<?PHP if($lmouserok==2 && $ftest0==1){ ?>
    <td class="lmost5"><acronym title="<?PHP echo $text[2057] ?>">
    <select class="lmoadminein" name="xmtipp<?PHP echo $i; ?>" onChange="dolmoedit()">
<?PHP
  echo "<option value=\"0\"";
    if($mtipp[$st-1][$i]<1){echo " selected";}
    echo ">_</option>";
  echo "<option value=\"1\"";
    if($mtipp[$st-1][$i]==1){echo " selected";}
    echo ">".$text[2199]."</option>";
?>
</select>
</acronym>
    </td>
<?PHP } ?>

  </tr>
<?PHP
    }
  else{ 
    for($n=0;$n<$modus[$st-1];$n++){
?>
<?PHP if(($klfin==1) && ($st==$anzst)){ ?>
    <tr><td class="lmost8" colspan=<?PHP echo $breite; ?>><nobr><?PHP if($i==1){echo "&nbsp;<br>";} echo $text[419+$i]; ?></nobr></td></tr>
<?PHP } ?>
  <tr>
<?PHP
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
    <td class="lmost5"><nobr><acronym title="<?PHP echo $text[122] ?>"><input class="lmoadminein" type="text" name="xatdat<?PHP echo $i.$n; ?>" size="10" maxlength="10" value="<?PHP echo $dum1; ?>" onChange="dolmoedit()"></acronym><a href="javascript:opencal('xatdat<?PHP echo $i.$n; ?>','<?PHP echo $dum3; ?>')" title="<?PHP echo $text[139]; ?>" onMouseOver="lmoimg('<?PHP echo $i.$n; ?>c',img5)" onMouseOut="lmoimg('<?PHP echo $i.$n; ?>c',img4)"><img src="lmo-admin4.gif" name="ximg<?PHP echo $i.$n; ?>c" width="14" height="10" border="0"></a></nobr></td>
    <td class="lmost5"><acronym title="<?PHP echo $text[123] ?>"><input class="lmoadminein" type="text" name="xattim<?PHP echo $i.$n; ?>" size="5" maxlength="5" value="<?PHP echo $dum2; ?>" onChange="dolmoedit()"></acronym></td>
    <td class="lmost5" width="2">&nbsp;</td>
<?PHP if($n==0){ ?>
    <td class="lmost5" align="right"><nobr>

<?PHP if($lmouserok==2){ ?>
<acronym title="<?PHP echo $text[107] ?>">
<select class="lmoadminein" name="xteama<?PHP echo $i; ?>" onChange="dolmoedit()">
<?PHP
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
<?PHP }else{echo $teams[$teama[$st-1][$i]];} ?>

    </nobr></td>
    <td class="lmost5" align="center" width="10">-</td>
    <td class="lmost5"><nobr>

<?PHP if($lmouserok==2){ ?>
<acronym title="<?PHP echo $text[108] ?>">
<select class="lmoadminein" name="xteamb<?PHP echo $i; ?>" onChange="dolmoedit()">
<?PHP
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
<?PHP }else{echo $teams[$teamb[$st-1][$i]];} ?>

    </nobr></td>
<?PHP }else{ ?>
    <td class="lmost5" colspan="3">&nbsp;</td>
<?PHP
    }
  if($goala[$st-1][$i][$n]=="-1"){$goala[$st-1][$i][$n]="_";}
  if($goalb[$st-1][$i][$n]=="-1"){$goalb[$st-1][$i][$n]="_";}
?>
    <td class="lmost5" width="2">&nbsp;</td>
    <td class="lmost5" align="right"><acronym title="<?PHP echo $text[109] ?>"><input class="lmoadminein" type="text" name="xgoala<?PHP echo $i.$n; ?>" size="4" maxlength="4" value="<?PHP echo $goala[$st-1][$i][$n]; ?>" onChange="lmotorgte('a','<?PHP echo $i.$n; ?>')" onKeyDown="lmotorclk('a','<?PHP echo $i.$n; ?>',event.keyCode)"></acronym></td>
    <td class="lmost5" align="center"><table cellpadding="0" cellspacing="0" border="0"><tr><td><a href="javascript:lmotorauf('a','<?PHP echo $i.$n; ?>',1);" title="<?PHP echo $text[120]; ?>" onMouseOver="lmoimg('<?PHP echo $i.$n; ?>a',img1)" onMouseOut="lmoimg('<?PHP echo $i.$n; ?>a',img0)"><img src="lmo-admin0.gif" name="ximg<?PHP echo $i.$n; ?>a" width="7" height="7" border="0"></a></td></tr><tr><td><a href="javascript:lmotorauf('a','<?PHP echo $i.$n; ?>',-1);" title="<?PHP echo $text[120]; ?>" onMouseOver="lmoimg('<?PHP echo $i.$n; ?>b',img3)" onMouseOut="lmoimg('<?PHP echo $i.$n; ?>b',img2)"><img src="lmo-admin2.gif" name="ximg<?PHP echo $i.$n; ?>b" width="7" height="7" border="0"></a></td></tr></table></td>
    <td class="lmost5" align="center" width="8">:</td>
    <td class="lmost5" align="right"><acronym title="<?PHP echo $text[110] ?>"><input class="lmoadminein" type="text" name="xgoalb<?PHP echo $i.$n; ?>" size="4" maxlength="4" value="<?PHP echo $goalb[$st-1][$i][$n]; ?>" onChange="lmotorgte('b','<?PHP echo $i.$n; ?>')" onKeyDown="lmotorclk('b','<?PHP echo $i.$n; ?>',event.keyCode)"></acronym></td>
    <td class="lmost5" align="center"><table cellpadding="0" cellspacing="0" border="0"><tr><td><a href="javascript:lmotorauf('b','<?PHP echo $i.$n; ?>',1);" title="<?PHP echo $text[121]; ?>" onMouseOver="lmoimg('<?PHP echo $i.$n; ?>f',img1)" onMouseOut="lmoimg('<?PHP echo $i.$n; ?>f',img0)"><img src="lmo-admin0.gif" name="ximg<?PHP echo $i.$n; ?>f" width="7" height="7" border="0"></a></td></tr><tr><td><a href="javascript:lmotorauf('b','<?PHP echo $i.$n; ?>',-1);" title="<?PHP echo $text[121]; ?>" onMouseOver="lmoimg('<?PHP echo $i.$n; ?>d',img3)" onMouseOut="lmoimg('<?PHP echo $i.$n; ?>d',img2)"><img src="lmo-admin2.gif" name="ximg<?PHP echo $i.$n; ?>d" width="7" height="7" border="0"></a></td></tr></table></td>
    <td class="lmost5" width="2">&nbsp;</td>
    <td class="lmost5">
<acronym title="<?PHP echo $text[111] ?>">
<select class="lmoadminein" name="xmspez<?PHP echo $i.$n; ?>" onChange="dolmoedit()">
<?PHP
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
    <td class="lmost5"><acronym title="<?PHP echo $text[112] ?>"><input class="lmoadminein" type="text" name="xmnote<?PHP echo $i.$n; ?>" size="16" maxlength="255" value="<?PHP echo $mnote[$st-1][$i][$n]; ?>" onChange="dolmoedit()"></acronym></td>
    <td class="lmost5"><acronym title="<?PHP echo $text[263] ?>"><input class="lmoadminein" type="text" name="xmberi<?PHP echo $i.$n; ?>" size="16" maxlength="128" value="<?PHP echo $mberi[$st-1][$i][$n]; ?>" onChange="dolmoedit()"></acronym></td>
<?PHP if($lmouserok==2 && $ftest0==1){ ?>
    <td class="lmost5"><acronym title="<?PHP echo $text[2057] ?>">
    <select class="lmoadminein" name="xmtipp<?PHP echo $i.$n; ?>" onChange="dolmoedit()">
<?PHP
  echo "<option value=\"0\"";
    if($mtipp[$st-1][$i][$n]<1){echo " selected";}
    echo ">_</option>";
  echo "<option value=\"1\"";
    if($mtipp[$st-1][$i][$n]==1){echo " selected";}
    echo ">".$text[2199]."</option>";
?>
</select>
</acronym>
    </td>
<?PHP } ?>
  </tr>
<?PHP } ?>
<?PHP if(($modus[$st-1]>1) && ($i<$anzsp-1)){ ?>
  <tr><td class="lmost5" colspan="<?PHP echo $breite; ?>">&nbsp;</td></tr>
<?PHP }}} ?>
  <tr>
    <td class="lmost4" colspan="<?PHP echo $breite; ?>" align="center"><nobr><?PHP echo $text[206]; ?></nobr></td>
  </tr>
  <tr>
    <td class="lmost5" colspan="<?PHP echo $breite; ?>" align="center"><nobr><acronym title="<?PHP echo $text[192] ?>"><?PHP echo $text[191]; ?> <select class="lmoadminein" name="xstx" onChange="dolmoedit()">
<?PHP
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
    <td class="lmost5" colspan="<?PHP echo $breite; ?>" align="center">
      <acronym title="<?PHP echo $text[208] ?>"><?PHP echo $text[207]; ?> <select class="lmoadminein" name="xnticker" onChange="dolmoedit()"><?PHP echo "<option value=\"1\""; if($nticker==1){echo " selected";} echo ">".$text[181]."</option>"; echo "<option value=\"0\""; if($nticker==0){echo " selected";} echo ">".$text[182]."</option>"; ?></select></acronym><br>
      <acronym title="<?PHP echo $text[210] ?>"><textarea class="lmoadminein" name="xnlines" cols="50" rows="4" wrap="off" onChange="dolmoedit()"><?PHP if(count($nlines)>0){foreach($nlines as $y){echo $y."\n";}} ?></textarea></acronym>
    </td>
  </tr>
  <tr><td class="lmost4" colspan="<?PHP echo $breite; ?>" align="center">
    <acronym title="<?PHP echo $text[114] ?>"><input class="lmoadminbut" type="submit" name="best" value="<?PHP echo $text[103]; ?>"></acronym>
  </td></tr>
  </form>

  </table></td></tr>
  <tr>
    <td><table width="100%" cellspacing="0" cellpadding="0" border="0"><tr>
<?PHP 
  $st0=$st-1;
  if($st>1){echo "<td class=\"lmost2\"><a href=\"javascript:chklmolink('".$addr.$st0."');\" title=\"".$text[6]."\">".$text[5]."</a></td>";}
  if($st!=-1){echo "<td class=\"lmost2\" align=\"center\"><a href=\"javascript:chklmolink('".$addr."-1');\" title=\"".$text[100]."\">".$text[99]."</a></td>";}
    else{echo "<td class=\"lmost1\" align=\"center\">".$text[99]."</td>";}
  if($hands==1){if($todo!="tabs"){echo "<td class=\"lmost2\" align=\"center\"><a href=\"javascript:chklmolink('".$addb.$stx."');\" title=\"".$text[409]."\">".$text[410]."</a></td>";}
    else{echo "<td class=\"lmost1\" align=\"center\">".$text[410]."</td>";}}
if($lmouserok==2){
  if($st!=-2){echo "<td class=\"lmost2\" align=\"center\"><a href=\"javascript:chklmolink('".$addr."-2');\" title=\"".$text[102]."\">".$text[101]."</a></td>";}
    else{echo "<td class=\"lmost1\" align=\"center\">".$text[101]."</td>";}
  }
  $st0=$st+1;
  if($st<$anzst){echo "<td align=\"right\" class=\"lmost2\"><a href=\"javascript:chklmolink('".$addr.$st0."');\" title=\"".$text[8]."\">".$text[7]."</a></td>";}
?>
    </tr></table></td>
  </tr>
</table>

<?PHP } ?>