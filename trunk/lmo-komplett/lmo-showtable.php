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
  if(!isset($tabtype)){$tabtype=0;}
  if(($endtab>1) && ($tabtype==0 or $tabtype==3 or $tabtype==4) && ($tabdat!="")){
    $endtab--;
    require(PATH_TO_LMO."/lmo-calctable.php");
	
    $platz1 = array("");
    $platz1 = array_pad($array,$anzteams+1,"");
    for($x=0;$x<$anzteams;$x++){$x3=intval(substr($tab0[$x],34));$platz1[$x3]=$x+1;}
    $endtab++;
    }
  
  require(PATH_TO_LMO."/lmo-calctable.php");
  
  $platz0 = array("");
  $platz0 = array_pad($array,$anzteams+1,"");
  for($x=0;$x<$anzteams;$x++){$x3=intval(substr($tab0[$x],34));$platz0[$x3]=$x+1;}
  if($tabdat==""){$addt1=$PHP_SELF."?action=table&amp;file=".$file."&amp;tabtype=";}else{$addt1=$PHP_SELF."?action=table&amp;file=".$file."&amp;endtab=".$endtab."&amp;tabtype=";}
  $addt2=$PHP_SELF."?action=table&amp;file=".$file."&amp;tabtype=".$tabtype."&amp;endtab=";
?>

<table class="lmosta" cellspacing="0" cellpadding="0" border="0">
  <tr>
    <td align="center"><? include(PATH_TO_LMO."/lmo-spieltagsmenu.php")?></td>
  </tr>
  <tr>
    <td align="center">
      <table cellspacing="0" cellpadding="0" border="0">
        <tr><?
  for($i=0;$i<3;$i++){?>
          <td <?
    if($i<>$tabtype){?>
              class="lmost0"><a href="<?=$addt1.$i?>" title="<?=$text[27+$i]?>"><?=$text[40+$i]?></a><?
    }else{?>
              class="lmost1"><?=$text[40+$i]?><?
    }?>&nbsp;
          </td><?
    }
    if ($einhinrueck==1) {?>
           <td <?
      $i++;
      if($i<>$tabtype){?>
               class="lmost0"><a href="<?=$_SERVER['PHP_SELF']."?action=table&amp;file=".$file."&amp;tabtype=".$i?>" title="<?=$text[4003]?>"><?=$text[4003]?></a><?
      }else{?>
               class="lmost1"><?=$text[4003]?><?
      }?>&nbsp;
           </td>
           <td <?
      $i--;
      if($i<>$tabtype){?>
                   class="lmost0"><a href="<?=$_SERVER['PHP_SELF']."?action=table&amp;file=".$file."&amp;tabtype=".$i?>" title="<?=$text[4002]?>"><?=$text[4002]?></a><?
      }else{?>
                   class="lmost1"><?=$text[4002]?><?
      }?>&nbsp;
           </td><?
    }
    if($minus==2){$dummy=" colspan=\"3\" align=\"center\"";}else{$dummy=" align=\"right\"";}?>
         <tr>
       </table>
     </td>
   </tr>
   <tr>
     <td align="center" class="lmost3">
       <table class="lmostb" cellspacing="0" cellpadding="0" border="0">
         <tr>
           <td class="lmost4" colspan="5"><?=$tabdat?>&nbsp;</td>
           <td class="lmost4" align="right"><?=$text[33]?></td>
           <td class="lmost4" align="right"><?=$text[34]?></td>
           <? if($hidr!=1){ ?>
           <td class="lmost4" align="right"><?=$text[35]?></td><?
           }?>
           <td class="lmost4" align="right"><?=$text[36]; ?></td>
           <? if($tabpkt==0){?>
           <td class="lmost4" <?=$dummy?>>&nbsp;<?=$text[37]?></td><?
           }?>
           <td class="lmost4" colspan="3" align="center"><?=$text[38]; ?></td>
           <td class="lmost4" align="right"><?=$text[39]; ?></td>
           <? if($tabpkt==1){ echo"<td class=\"lmost4\"".$dummy.">&nbsp;".$text[37]."</td>"; } ?>
         </tr><?
    $j=1;
    for($x=1;$x<=$anzteams;$x++){
      $i=intval(substr($tab0[$x-1],34));
      if($i==$favteam){$dummy="<b>";$dumm2="</b>";}else{$dummy="";$dumm2="";}
      $dumm1="lmost5";
      if(($x==1) && ($champ!=0)){$dumm1="lmotab1";$j=2;}
      if(($x>=$j) && ($x<$j+$anzcl) && ($anzcl>0)){$dumm1="lmotab2";}
      if(($x>=$j+$anzcl) && ($x<$j+$anzcl+$anzck) && ($anzck>0)){$dumm1="lmotab3";}
      if(($x>=$j+$anzcl+$anzck) && ($x<$j+$anzcl+$anzck+$anzuc) && ($anzuc>0)){$dumm1="lmotab4";}
      if(($x<=$anzteams) && ($x>$anzteams-$anzab) && ($anzab>0)){$dumm1="lmotab5";}
      if(($x<=$anzteams-$anzab) && ($x>$anzteams-$anzab-$anzar) && ($anzar>0)){$dumm1="lmotab8";}?>
         <tr>
           <td class="<?=$dumm1?>" align="right"><?=$dummy.$x.$dumm2?></td><?
      $y=0;
      if(($endtab>1) && ($tabtype==0 || $tabtype==3 || $tabtype==4) && ($tabdat!="")){
        if($platz0[$i]<$platz1[$i]){$y=1;}
        elseif($platz0[$i]>$platz1[$i]){$y=2;}
      }
      if($tabdat!=""){
        echo "<td class=\"".$dumm1."\"";
        if($tabtype==0 or $tabtype==3 or $tabtype==4){echo "><img src='img/lmo-tab".$y.".gif' width='9' height='9' border='0'>";}else{echo " width=\"2\">&nbsp;";}
        echo "</td>";
      }else{
        echo "<td class=\"".$dumm1."\"></td>";
      }?>
           <td class="<?=$dumm1?>" align="center"><?
      if (file_exists(PATH_TO_IMGDIR."/teams/small/".$teams[$i].".gif")) {
        $imgdata=getimagesize(PATH_TO_IMGDIR."/teams/small/".$teams[$i].".gif");
             ?><img border="0" src="<?=URL_TO_IMGDIR."/teams/small/".rawurlencode($teams[$i])?>.gif" <?=$imgdata[3]?> alt=""><?
      }
        ?></td>
           <td class="<?=$dumm1?>"><?
      if(($teamu[$i]!="") && ($urlt==1)){echo "<a href=\"".$teamu[$i]."\" target=\"_blank\" title=\"".$text[46]."\">";}
      echo $dummy.$teams[$i].$dumm2;
      if(($teamu[$i]!="") && ($urlt==1)){echo "</a>";}?>
           </td>
           <td class="<?=$dumm1?>"><?
      if(($teamn[$i]!="") || (($strafp[$i]!=0) || ($strafm[$i]!=0))){
        $dum27=addslashes($teams[$i]);
        if(($strafp[$i]!=0) || ($strafm[$i]!=0)){
          $dum27=$dum27."\\n\\n".$text[128].": ".$strafp[$i];
          if($minus==2){$dum27=$dum27.":".$strafm[$i];}
        }
        if($teamn[$i]!=""){$dum27=$dum27."\\n\\n".$text[22].":\\n".$teamn[$i];}
        echo "<a href='#' onclick=\"alert('$dum27');\"><img src='img/lmo-st2.gif' width='10' height='12' border='0'><span class='popup'>{$dum27}</span></a>&nbsp;";
      }else{
        echo "&nbsp;&nbsp;";
      }?>
           </td>
           <td class="<?=$dumm1; ?>" align="right"><?=$dummy.$spiele[$i].$dumm2?>&nbsp;</td>
           <td class="<?=$dumm1; ?>" align="right"><?=$dummy.$siege[$i].$dumm2; ?></td><? 
      if($hidr!=1){ ?>
           <td class="<?=$dumm1; ?>" align="right"><?=$dummy.$unent[$i].$dumm2; ?></td><?
      }?>
           <td class="<?=$dumm1; ?>" align="right"><?=$dummy.$nieder[$i].$dumm2; ?></td><?
      if($tabpkt==0){?>
           <td class="<?=$dumm1?>" align="right">&nbsp;<strong><?=$punkte[$i]?></strong></td><?
        if($minus==2){?>
           <td class="<?=$dumm1?>" align="center"><strong>:</strong></td>
           <td class="<?=$dumm1?>" align="left"><strong><?=$negativ[$i]?></strong></td><?
        }
      }?>
           <td class="<?=$dumm1; ?>" align="right">&nbsp;<?=$dummy.$etore[$i].$dumm2; ?></td>
           <td class="<?=$dumm1; ?>" align="center"><?=$dummy?>:<?=$dumm2?></td>
           <td class="<?=$dumm1; ?>"><?=$dummy.$atore[$i].$dumm2; ?></td>
           <td class="<?=$dumm1; ?>" align="right"><?=$dummy.$dtore[$i].$dumm2; ?></td><?
      if($tabpkt==1){?>
           <td class="<?=$dumm1?>" align="right"><strong><?=$punkte[$i]?></strong>&nbsp;</td><?
        if($minus==2){?>
           <td class="<?=$dumm1?>" align="center"><strong>:</strong></td>
           <td class="<?=$dumm1?>"><strong><?=$negativ[$i]?></strong></td><?
        }
      }?>
         </tr><?
    }?>
       </table>
     </td>
   </tr>
   <tr>  
     <td class="lmomain2" align="center"><? 
    if ($einzutoretab==1) {
      $strs=".l98";
      $stre=".l98.php";
      $str=basename($file);
      $file16=str_replace($strs,$stre,$str);
      $temp11=basename($diroutput);
      if (file_exists("$temp11/$file16")) {
        require("$temp11/$file16");
        if ($tabtype==0 && $endtab==$anzst) {
          echo $text[38].": ".$gzutore."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"." ".$text[38]."&nbsp;".$text[4001].": ".$gdstore;
        }
        if ($tabtype==1 && $endtab==$anzst) {
          echo $text[4010].": ".$gheimtore."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"." ".$text[4010].$text[4001].": ".$dsheimtore;
        }
        if ($tabtype==2 && $endtab==$anzst) {
          echo $text[4011].": ".$ggasttore."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"." ".$text[4011].$text[4001].": ".$dsgasttore;
        }
        
      }
    }?>
    </td>
  </tr><? 
    if($tabdat!=""){ ?>
  <tr>
    <td>
      <table width="100%" cellspacing="0" cellpadding="0" border="0">
        <tr><? 
      $st0=$endtab-1;if($endtab>1){echo "<td class=\"lmost2\" align=\"left\"><a href=\"".$addt2.$st0."\" title=\"".$text[43]."\">".$text[5]."</a></td>";}
      $st0=$endtab+1;if($endtab<$anzst){echo "<td align=\"right\" class=\"lmost2\"><a href=\"".$addt2.$st0."\" title=\"".$text[44]."\">".$text[7]."</a></td>";} ?>
        </tr>
      </table>
	  </td>
  </tr><? 
  } ?>
</table><?
}?>