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
  $addk=$_SERVER['PHP_SELF']."?action=cal&amp;file=".$file."&amp;cal=";
  $addr=$_SERVER['PHP_SELF']."?action=results&amp;file=".$file."&amp;st=";
  $me=array("0","January","February","March","April","May","June","July","August","September","October","November","December");
  $mb=strftime("%m%Y",strtotime("now"));
  if(isset($cal)){
    if(strlen($cal)>4){
      $dum1=strtotime("1 ".$me[intval(substr($cal,0,2))]." ".substr($cal,2)." -1 month");
      $dum2=strtotime("1 ".$me[intval(substr($cal,0,2))]." ".substr($cal,2));
      $dum3=strtotime("1 ".$me[intval(substr($cal,0,2))]." ".substr($cal,2)." +1 month");
      }
    else{
      $dum1=strtotime("1 ".$me[1]." ".substr($cal,2)." -1 year");
      $dum2=strtotime("1 ".$me[1]." ".substr($cal,2));
      $dum3=strtotime("1 ".$me[1]." ".substr($cal,2)." +1 year");
      }
    }
  else{
    if($datum1[$st-1]!=""){
      $datum = split("[.]",$datum1[$st-1]);
      $dum1=strtotime($datum[0]." ".$me[intval($datum[1])]." ".$datum[2]." -1 month");
      $dum2=strtotime($datum[0]." ".$me[intval($datum[1])]." ".$datum[2]);
      $dum3=strtotime($datum[0]." ".$me[intval($datum[1])]." ".$datum[2]." +1 month");
      }
    elseif($datum2[$st-1]!=""){
      $datum = split("[.]",$datum2[$st-1]);
      $dum1=strtotime($datum[0]." ".$me[intval($datum[1])]." ".$datum[2]." -1 month");
      $dum2=strtotime($datum[0]." ".$me[intval($datum[1])]." ".$datum[2]);
      $dum3=strtotime($datum[0]." ".$me[intval($datum[1])]." ".$datum[2]." +1 month");
      }
    else{
      $dum0=array("");
      for($i=0;$i<$anzsp;$i++){for($n=0;$n<$modus[$st-1];$n++){if($mterm[$st-1][$i][$n]>0){array_push($dum0,$mterm[$st-1][$i][$n]);}}}
      if(count($dum0)>1){
        array_shift($dum0);
        array_sort($dum0);
        $datum = split("[.]",$dum0[0]);
        $dum1=strtotime($datum[0]." ".$me[intval($datum[1])]." ".$datum[2]." -1 month");
        $dum2=strtotime($datum[0]." ".$me[intval($datum[1])]." ".$datum[2]);
        $dum3=strtotime($datum[0]." ".$me[intval($datum[1])]." ".$datum[2]." +1 month");
        }
      else{
        $dum1=strtotime("-1 month");
        $dum2=strtotime("now");
        $dum3=strtotime("+1 month");
        }
      }
    }
  if($dum2!=-1){
    if(!isset($cal)){$cal=strftime("%m%Y",$dum2);}
    if(strlen($cal)>4){
      $ma=strftime("%m%Y",$dum1);
      $mc=strftime("%m%Y",$dum3);
      $md=strftime("%B %Y",$dum2);
      $ml=strftime("%Y",$dum2);
      $mj=" ".$me[intval(strftime("%m",$dum2))]." ".strftime("%Y",$dum2);
      $dat1=getdate(strtotime("1".$mj));
      $erster=$dat1['wday'];
      }
    else{
      $ma=strftime("%Y",$dum1);
      $mc=strftime("%Y",$dum3);
      $md=strftime("%Y",$dum2);
      $mj=" ".strftime("%Y",$dum2);
      }
    }
  if(strlen($cal)>4){
    $dum0=array("");
    $dum1=array("");
    $dum2=array("");
    $dum0=array_pad($array,32,"");
    $dum1=array_pad($array,32,"");
    $dum2=array_pad($array,32,"");
    for($j=0;$j<$anzst;$j++){
      $anzsp=$anzteams/2;
      if($j==$anzst-1){$text2=$text[364];$text1=$text[374];}
      elseif($j==$anzst-2){$text2=$text[362];$text1=$text[373];}
      elseif($j==$anzst-3){$text2=$text[360];$text1=$text[372];}
      elseif($j==$anzst-4){$text2=$text[358];$text1=$text[371];}
      else{$text1=($j+1).". ".$text[370];$text2=($j+1).". ".$text[376];}
      $datum = split("[.]",$datum1[$j]);
      $dum3=strtotime($datum[0]." ".$me[intval($datum[1])]." ".$datum[2]);
      $datum = split("[.]",$datum2[$j]);
      $dum4=strtotime($datum[0]." ".$me[intval($datum[1])]." ".$datum[2]);
      for($i=0;$i<$anzsp;$i++){
        for($n=0;$n<$modus[$j];$n++){
          if($mterm[$j][$i][$n]>0){
            if(strftime("%B %Y",$mterm[$j][$i][$n])==$md){
              $a=intval(strftime("%d",$mterm[$j][$i][$n]));
              if(($teama[$j][$i]!=0) && ($teamb[$j][$i]!=0)){
                if($dum0[$a]!=""){$dum0[$a]=$dum0[$a].", &#10;";}else{$dum0[$a]=$text1.": &#10;";}
                $dum0[$a]=$dum0[$a].$teams[$teama[$j][$i]]." - ".$teams[$teamb[$j][$i]];
                if($modus[$j]>1){$dum0[$a]=$dum0[$a]." &#10;(".($n+1).". ".$text[375].")";}
                }
              }
            }
          }
        }
      if($dum3<0){$dum3=$dum4;}
      if($dum4<0){$dum4=$dum3;}
      if($dum3>0){
        if((strftime("%B %Y",$dum3)==$md) && (strftime("%B %Y",$dum4)==$md)){
          for($a=intval(strftime("%d",$dum3));$a<=intval(strftime("%d",$dum4));$a++){
            $c=split("[|]",$dum1[$a]);
            array_unshift($c,"0");
            if(array_search(($j+1),$c)==0){
              if($dum1[$a]!=""){$dum1[$a]=$dum1[$a]."|";}
              $dum1[$a]=$dum1[$a].($j+1);
              if($dum2[$a]!=""){$dum2[$a]=$dum2[$a]."<br>";}
              if($dum0[$a]==""){$dum0[$a]=$text1." &#10;(".$text[155].")";}
              $dum2[$a]=$dum2[$a]."&nbsp;&nbsp;<a href=\"".$addr.($j+1)."\" title=\"".$dum0[$a]."\">".$text2."</a>";
              }
            }
          }
        elseif(strftime("%B %Y",$dum3)==$md){
          $a=intval(strftime("%d",$dum3));
          $c=split("[|]",$dum1[$a]);
          array_unshift($c,"0");
          if(array_search(($j+1),$c)==0){
            if($dum1[$a]!=""){$dum1[$a]=$dum1[$a]."|";}
            $dum1[$a]=$dum1[$a].($j+1);
            if($dum2[$a]!=""){$dum2[$a]=$dum2[$a]."<br>";}
            $dum2[$a]=$dum2[$a]."&nbsp;&nbsp;<a href=\"".$addr.($j+1)."\" title=\"".$dum0[$a]."\">".$text2."</a>";
            }
          }
        elseif(strftime("%B %Y",$dum4)==$md){
          $a=intval(strftime("%d",$dum4));
          $c=split("[|]",$dum1[$a]);
          array_unshift($c,"0");
          if(array_search(($j+1),$c)==0){
            if($dum1[$a]!=""){$dum1[$a]=$dum1[$a]."|";}
            $dum1[$a]=$dum1[$a].($j+1);
            if($dum2[$a]!=""){$dum2[$a]=$dum2[$a]."<br>";}
            $dum2[$a]=$dum2[$a]."&nbsp;&nbsp;<a href=\"".$addr.($j+1)."\" title=\"".$dum0[$a]."\">".$text2."</a>";
            }
          }
        }
      for($i=0;$i<$anzsp;$i++){
        for($n=0;$n<$modus[$j];$n++){
          if($mterm[$j][$i][$n]>0){
            if(strftime("%B %Y",$mterm[$j][$i][$n])==$md){
              $a=intval(strftime("%d",$mterm[$j][$i][$n]));
              $c=split("[|]",$dum1[$a]);
              array_unshift($c,"0");
              if(array_search(($j+1),$c)==0){
                if($dum1[$a]!=""){$dum1[$a]=$dum1[$a]."|";}
                $dum1[$a]=$dum1[$a].($j+1);
                if($dum2[$a]!=""){$dum2[$a]=$dum2[$a]."<br>";}
                $dum2[$a]=$dum2[$a]."&nbsp;&nbsp;<a href=\"".$addr.($j+1)."\" title=\"".$dum0[$a]."\">".$text2."</a>";
                }
              }
            }
          }
        }
      }
    }
  else{
    $dum1=array("");
    $dum2=array("");
    $dum1=array_pad($array,13,"");
    $dum2=array_pad($array,13,"");
    for($j=0;$j<$anzst;$j++){
      $anzsp=$anzteams/2;
      if($j==$anzst-1){$text2=$text[364];$text1=$text[374];}
      elseif($j==$anzst-2){$text2=$text[362];$text1=$text[373];}
      elseif($j==$anzst-3){$text2=$text[360];$text1=$text[372];}
      elseif($j==$anzst-4){$text2=$text[358];$text1=$text[371];}
      else{$text1=($j+1).". ".$text[370];$text2=($j+1).". ".$text[376];}
      $datum = split("[.]",$datum1[$j]);
      $dum3=strtotime($datum[0]." ".$me[intval($datum[1])]." ".$datum[2]);
      $datum = split("[.]",$datum2[$j]);
      $dum4=strtotime($datum[0]." ".$me[intval($datum[1])]." ".$datum[2]);
      if($dum3<0){$dum3=$dum4;}
      if($dum4<0){$dum4=$dum3;}
      if($dum3>0){
        if((strftime("%Y",$dum3)==$md) && (strftime("%Y",$dum4)==$md)){
          for($a=intval(strftime("%m",$dum3));$a<=intval(strftime("%m",$dum4));$a++){
            $c=split("[|]",$dum1[$a]);
            array_unshift($c,"0");
            if(array_search(($j+1),$c)==0){
              if($dum1[$a]!=""){$dum1[$a]=$dum1[$a]."|";}
              $dum1[$a]=$dum1[$a].($j+1);
              if($dum2[$a]!=""){$dum2[$a]=$dum2[$a]."<br>";}
              $dum2[$a]=$dum2[$a]."&nbsp;&nbsp;<a href=\"".$addr.($j+1)."\" title=\"".$text1."\">".$text2."</a>";
              }
            }
          }
        elseif(strftime("%Y",$dum3)==$md){
          $a=intval(strftime("%m",$dum3));
          $c=split("[|]",$dum1[$a]);
          array_unshift($c,"0");
          if(array_search(($j+1),$c)==0){
            if($dum1[$a]!=""){$dum1[$a]=$dum1[$a]."|";}
            $dum1[$a]=$dum1[$a].($j+1);
            if($dum2[$a]!=""){$dum2[$a]=$dum2[$a]."<br>";}
            $dum2[$a]=$dum2[$a]."&nbsp;&nbsp;<a href=\"".$addr.($j+1)."\" title=\"".$text1."\">".$text2."</a>";
            }
          }
        elseif(strftime("%Y",$dum4)==$md){
          $a=intval(strftime("%m",$dum4));
          $c=split("[|]",$dum1[$a]);
          array_unshift($c,"0");
          if(array_search(($j+1),$c)==0){
            if($dum1[$a]!=""){$dum1[$a]=$dum1[$a]."|";}
            $dum1[$a]=$dum1[$a].($j+1);
            if($dum2[$a]!=""){$dum2[$a]=$dum2[$a]."<br>";}
            $dum2[$a]=$dum2[$a]."&nbsp;&nbsp;<a href=\"".$addr.($j+1)."\" title=\"".$text1."\">".$text2."</a>";
            }
          }
        }
      for($i=0;$i<$anzsp;$i++){
        for($n=0;$n<$modus[$j];$n++){
          if($mterm[$j][$i][$n]>0){
            if(strftime("%Y",$mterm[$j][$i][$n])==$md){
              $a=intval(strftime("%m",$mterm[$j][$i][$n]));
              $c=split("[|]",$dum1[$a]);
              array_unshift($c,"0");
              if(array_search(($j+1),$c)==0){
                if($dum1[$a]!=""){$dum1[$a]=$dum1[$a]."|";}
                $dum1[$a]=$dum1[$a].($j+1);
                if($dum2[$a]!=""){$dum2[$a]=$dum2[$a]."<br>";}
                $dum2[$a]=$dum2[$a]."&nbsp;&nbsp;<a href=\"".$addr.($j+1)."\" title=\"".$text1."\">".$text2."</a>";
                }
              }
            }
          }
        }
      }
    }
?>
<table class="lmosta" cellspacing="0" cellpadding="0" border="0">
<?PHP if(strlen($cal)>4){ ?>
  <tr>
    <td align="center"><table width="100%" cellspacing="0" cellpadding="0" border="0"><tr>
      <td class="lmost0a"><a href="<?PHP echo $addk.$ma; ?>" title="<?PHP echo $text[142]; ?>"><?PHP echo $text[5]; ?></a></td>
      <td align="center" class="lmost0a"><a href="<?PHP echo $addk.$ml; ?>" title="<?PHP echo $text[173]; ?>"><?PHP echo $md; ?></a></td>
      <td align="right" class="lmost0a"><a href="<?PHP echo $addk.$mb; ?>" title="<?PHP echo $text[143]; ?>"><?PHP echo $text[154]; ?></a>&nbsp;&nbsp;<a href="<?PHP echo $addk.$mc; ?>" title="<?PHP echo $text[144]; ?>"><?PHP echo $text[7]; ?></a></td>
    <tr></table></td>
  </tr>
  <tr><td align="center" class="lmost3"><table class="lmostb" cellspacing="0" cellpadding="0" border="0"><tr>
    <td width="60" class="lmost4" align="center"><?PHP echo $text[147]; ?></td>
    <td width="60" class="lmost4" align="center"><?PHP echo $text[148]; ?></td>
    <td width="60" class="lmost4" align="center"><?PHP echo $text[149]; ?></td>
    <td width="60" class="lmost4" align="center"><?PHP echo $text[150]; ?></td>
    <td width="60" class="lmost4" align="center"><?PHP echo $text[151]; ?></td>
    <td width="60" class="lmost4" align="center"><?PHP echo $text[152]; ?></td>
    <td width="60" class="lmost4" align="center"><?PHP echo $text[153]; ?></td>
  </tr>
<?PHP
$dat0 = getdate(time());
if($erster!=1){
  if($erster==0){$erster=7;}
  echo "<tr>";
  for($i=0;$i<$erster-1;$i++){echo "<td class=\"lmocalni\">&nbsp;</td>";}
  }
for($i=1;$i<=31;$i++){
  $dat4 = getdate(strtotime($i.$mj));
  $heute=$dat4['wday'];
  if($heute==0){$heute=7;}
  if($dat1['mon']==$dat4['mon']){
    $stil="lmocalat";
    $dum6=$dat0['mday'].".".$dat0['mon'].".".$dat0['year'];
    $dum7=$dat4['mday'].".".$dat4['mon'].".".$dat4['year'];
    if($dum6==$dum7){
      if(($heute==6) || ($heute==7)){$stil="lmocalhe";}else{$stil="lmocalht";}
      }
      else{
      if(($heute==6) || ($heute==7)){$stil="lmocalwe";}else{$stil="lmocalat";}
      }
    if ($i<=9){$k="0";}else{$k="";}
    if($heute==1){echo "<tr>";}
    echo "<td width=\"60\" height=\"50\" valign=\"top\" class=\"".$stil."\">".$i;
    if($dum2[$i]!=""){echo "<br>".$dum2[$i];}
    echo "</td>";
    if($heute==7){echo "</tr>";}
    $j=$heute;
    }
  }
if ($j!=7){
  for ($i=0;$i<7-$j;$i++){echo "<td class=\"lmocalni\">&nbsp;</td>";}
  echo "</tr>";
  }
}
else{
?>
  <tr>
    <td align="center"><table width="100%" cellspacing="0" cellpadding="0" border="0"><tr>
      <td class="lmost0a"><a href="<?PHP echo $addk.$ma; ?>" title="<?PHP echo $text[157]; ?>"><?PHP echo $text[5]; ?></a></td>
      <td align="center" class="lmost1"><?PHP echo $text[156]." ".$md; ?></td>
      <td align="right" class="lmost0a"><a href="<?PHP echo $addk.$mb; ?>" title="<?PHP echo $text[158]; ?>"><?PHP echo $text[154]; ?></a>&nbsp;&nbsp;<a href="<?PHP echo $addk.$mc; ?>" title="<?PHP echo $text[159]; ?>"><?PHP echo $text[7]; ?></a></td>
    <tr></table></td>
  </tr>
  <tr><td align="center" class="lmost3"><table class="lmostb" cellspacing="0" cellpadding="0" border="0">
<?PHP
$dat0 = getdate(time());
for($i=1;$i<=12;$i++){
  if(($i==1) || ($i==7)){echo "<tr>";}
  echo "<td width=\"70\" height=\"150\" valign=\"top\" class=\"lmocalat\">";
  if ($i<=9){$k="0";}else{$k="";}
  echo "<a href=\"".$addk.$k.$i.$md."\" title=\"".$text[172]."\"><b>".$text[159+$i]."</b></a>";
  if($dum2[$i]!=""){echo "<br>".$dum2[$i];}
  echo "</td>";
  if(($i==6) || ($i==12)){echo "</tr>";}
  }
}
?>
  </table></td></tr>
</table>

<?PHP } ?>
