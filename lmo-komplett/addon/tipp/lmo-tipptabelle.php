<?
// 
// LigaManager Online 3.02
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
if ($file!="" && $tipp_tipptabelle1==1) {
  if ($endtab==0) {
    $endtab=$anzst;
    $tabdat="";
  } else {
    $tabdat=$endtab.". ".$text[2];
  }
  if (!isset($tabtype)) {
    $tabtype=0;
  }
  if (!isset($nick)) {
    $nick=$lmotippername;
  }
  if ($tipp_einsichterst==1) {
    require_once(PATH_TO_ADDONDIR."/tipp/lmo-tippaenderbar.php");
  }
  if ($file!="") {
    if ($nick!="") {
      $m=0;
      $tippfile=PATH_TO_ADDONDIR."/tipp/".$tipp_dirtipp.substr($file,strrpos($file,"/")+1,-4)."_".$nick.".tip";
      require(PATH_TO_ADDONDIR."/tipp/lmo-tippopenfileall.php");
      $anztipper=1;
      if (($endtab>1) && ($tabtype==0) && ($tabdat!="")) {
        $endtab--;
        require(PATH_TO_ADDONDIR."/tipp/lmo-tippcalctable.php");
        $endtab++;
        $platz1 = array("");
        $platz1 = array_pad($array,$anzteams+1,"");
        for ($x=0; $x<$anzteams; $x++) {
          $x3=intval(substr($tab0[$x],42));
          $platz1[$x3]=$x+1;
        }
      }
      require(PATH_TO_ADDONDIR."/tipp/lmo-tippcalctable.php");
    } else if ($tipp_tipptabelle==1) {
      // alle Tipper
      $tabdat="";
      $verz=opendir(PATH_TO_ADDONDIR."/tipp/".$tipp_dirtipp);
      $dummy=array("");
      $liga=substr($file, strrpos($file,"/")+1, -4);
      while ($files=readdir($verz)) {
        if (strtolower(substr($files,0,strrpos($files,"_")))==strtolower($liga) && strtolower(substr($files,-4))==".tip") {
          array_push($dummy,$files);
        }
      }
      closedir($verz);
      array_shift($dummy);
      $anztipper=count($dummy);
      for ($m=0; $m<$anztipper; $m++) {
        $nick=substr($dummy[$m],strrpos($dummy[$m],"_")+1,-4);
        $tippfile=PATH_TO_ADDONDIR."/tipp/".$tipp_dirtipp.substr($file,strrpos($file,"/")+1,-4)."_".$nick.".tip";
        require(PATH_TO_ADDONDIR."/tipp/lmo-tippopenfileall.php");
        require(PATH_TO_ADDONDIR."/tipp/lmo-tippcalctable.php");
      }
      $nick="";
    }
  }
  $platz0 = array("");
  $platz0 = array_pad($array,$anzteams+1,"");
  for ($x=0; $x<$anzteams; $x++) {
    $x3=intval(substr($tab0[$x],42));
    $platz0[$x3]=$x+1;
  }
  if ($tabdat=="") {
    $addt1=$_SERVER['PHP_SELF']."?action=tipp&amp;todo=tabelle&amp;file=".$file."nick=".$nick."&amp;tabtype=";
  } else {
    $addt1=$_SERVER['PHP_SELF']."?action=tipp&amp;todo=tabelle&amp;file=".$file."&amp;endtab=".$endtab."&amp;nick=".$nick."&amp;tabtype=";
  }
  $addt2=$_SERVER['PHP_SELF']."?action=tipp&amp;todo=tabelle&amp;file=".$file."&amp;tabtype=".$tabtype."&amp;nick=".$nick."&amp;endtab=";
  $addt=$_SERVER['PHP_SELF']."?action=tipp&amp;todo=tabelle&amp;file=".$file."&amp;endtab=&amp;nick=";
  
?>
<table class="lmosta" cellspacing="0" cellpadding="0" border="0">
  <tr>
  <td align="center" class="lmost1"><? 
  if($_SESSION["lmotipperok"]==5){
    echo $lmotippername;
    if($lmotipperverein!=""){
      echo " - ".$lmotipperverein;
    }
  }else{
    echo $text['tipp'][158];
  }?>
  </td>
  </tr><? 
  if($nick!=""){ ?>
  <tr>
  <td align="center">
    <table cellspacing="0" cellpadding="0" border="0">
    <tr><?
  $hoy1=1;
  //  if ($tabtype==3){$hoy1=($anzst/2+1);}
  if ($tabtype<>3 and $tabtype<>4) {
    echo "<td align=\"right\" valign=\"top\" class=\"lmost1\" colspan=\"3\" rowspan=\"4\">";
    if ($lmtype==1) {
      echo $text[370];
    } else {
      echo $text[2];
    }
    echo ":";
    echo "&nbsp;</td>";
    for ($i=$hoy1; $i<=$anzst; $i++) {
      echo "<td align=\"right\" ";
      if (($i!=$endtab) || (($i==$endtab) && ($tabdat==""))) {
        echo "class=\"lmost0\"><a href=\"".$addt2.$i."\" title=\"".$text[9]."\">".$i."</a>";
      } else {
        echo "class=\"lmost1\">".$i;
      }
      echo "&nbsp;</td>";
      if (($anzst>49) && (($anzst%4)==0)) {
        if (($i==$anzst/4) || ($i==$anzst/2) || ($i==$anzst/4*3)) {
          echo "</tr><tr>";
        }
      } else if (($anzst>38) && (($anzst%3)==0)) {
        if (($i==$anzst/3) || ($i==$anzst/3*2)) {
          echo "</tr><tr>";
        }
      } else if (($anzst>25) && (($anzst%2)==0)) {
        if ($i==$anzst/2) {
          echo "</tr><tr>";
        }
      }
    }
  }?>
    </tr>
    </table>
  </td>
  </tr><? 
  } /* ende if($nick!="") */?>
  <tr>
  <td class="lmost4" align="center"><? 
  if($nick==$lmotippername && $nick!=""){
  echo $text['tipp'][173];
  }elseif($nick!=""){
  echo $text['tipp'][181]." ".$nick;
  }else{
  echo $text['tipp'][184];
  } ?>
  </td>
  </tr><? 
  if($nick!=""){ ?>
  <tr>
  <td align="center">
    <table style="margin:auto;" cellspacing="0" cellpadding="0" border="0">
    <tr><?
  for ($i=0; $i<3; $i++) {
    echo "<td ";
    if ($i<>$tabtype) {
    echo "class=\"lmost0\"><a href=\"".$addt1.$i."\" title=\"".$text[27+$i]."\">".$text[40+$i]."</a>";
    } else {
    echo "class=\"lmost1\">".$text[40+$i];
    }
    echo "&nbsp;</td>";
  }
  echo "<td ";
  $i=$i+1;
  
  if ($i<>$tabtype && $einhinrueck==1) {
    echo "class=\"lmost0\"><a href=\"".$addt1.$i."\" title=\"".$text[4002]."\">".$text[4002]."</a>";
  } else if ($einhinrueck==1) {
    echo "class=\"lmost1\">".$text[4002];
  }
  echo "&nbsp;</td>";
  
  echo "<td ";
  $i=$i-1;
  if ($i<>$tabtype && $einhinrueck==1) {
    echo "class=\"lmost0\"><a href=\"".$addt1.$i."\" title=\"".$text[4003]."\">".$text[4003]."</a>";
  } else if ($einhinrueck==1) {
    echo "class=\"lmost1\">".$text[4003];
  }
  echo "&nbsp;</td>";?>
    <tr>
    </table>
  </td>
  </tr><? 
  } /* ende if($nick!="")*/
  if($minus==2){
  $dummy=" colspan=\"3\" align=\"center\"";
  }else{
  $dummy=" align=\"right\"";
  }?>
  <tr>
  <td align="center" class="lmost3">
    <table class="lmostb" cellspacing="0" cellpadding="0" border="0">
    <tr>
      <td class="lmost4" colspan="5"><?=$tabdat; ?></td>
      <td class="lmost4" width="2">&nbsp;</td>
      <td class="lmost4" align="right"><?=$text[33]; ?></td>
      <td class="lmost4" align="right"><?=$text[34]; ?></td><? 
   if($hidr!=1){?>
      <td class="lmost4" align="right"><?=$text[35];?></td><?
   }?>
      <td class="lmost4" align="right"><?=$text[36]; ?></td><? 
   if($tabpkt==0){?>
      <td class="lmost4" width="2">&nbsp;</td>
      <td class="lmost4" <?=$dummy?>><?=$text[37]?></td><?
   }
   if($tipp_tippmodus==1){ ?>
      <td class="lmost4" width="2">&nbsp;</td>
      <td class="lmost4" colspan="3" align="center"><?=$text[38]; ?></td>
      <td class="lmost4" align="right"><?=$text[39]; ?></td><? 
   }
   if($tabpkt==1){ ?>
      <td class="lmost4" width="2">&nbsp;</td>
      <td class="lmost4" <?=$dummy?>><?=$text[37]?></td><?
   }?>
      <td class="lmost4" align="right"><?=$text[37]."/".$text[33]; ?></td>
    </tr><?
  $j=1;
  for ($x=1; $x<=$anzteams; $x++) {
    $i=intval(substr($tab0[$x-1],42));
    if ($i==$favteam) {
    $dummy="<strong>";
    $dumm2="</strong>";
    } else {
    $dummy="";
    $dumm2="";
    }
    $dumm1="lmost5";
    if ($tabtype==0) {
    if (($x==1) && ($champ!=0)) {
      $dumm1="lmotab1";
      $j=2;
    }
    if (($x>=$j) && ($x<$j+$anzcl) && ($anzcl>0)) {
      $dumm1="lmotab2";
    }
    if (($x>=$j+$anzcl) && ($x<$j+$anzcl+$anzck) && ($anzck>0)) {
      $dumm1="lmotab3";
    }
    if (($x>=$j+$anzcl+$anzck) && ($x<$j+$anzcl+$anzck+$anzuc) && ($anzuc>0)) {
      $dumm1="lmotab4";
    }
    if (($x<=$anzteams) && ($x>$anzteams-$anzab) && ($anzab>0)) {
      $dumm1="lmotab5";
    }
    if (($x<=$anzteams-$anzab) && ($x>$anzteams-$anzab-$anzar) && ($anzar>0)) {
      $dumm1="lmotab8";
    }
    }?>
    <tr>
      <td class="<?=$dumm1; ?>" align="right"><?=$dummy.$x.$dumm2; ?></td><?
    $y=0;
    if (($endtab>1) && ($tabtype==0) && ($tabdat!="")) {
    if ($platz0[$i]<$platz1[$i]) {
      $y=1;
    } else if ($platz0[$i]>$platz1[$i]) {
      $y=2;
    }
    }
    if ($tabdat!="") {
    echo "<td class=\"".$dumm1."\"";
    if ($tabtype==0) {
      echo "><img src='lmo-tab".$y.".gif' width=\"9\" height=\"9\" border=\"0\">";
    } else {
      echo " width=\"2\">&nbsp;";
    }
    echo "</td>";
    } else {
    echo "<td class=\"".$dumm1."\">&nbsp;</td>";
    }?>
      <td class="<?=$dumm1; ?>">
      <nobr><?
    if (($teamu[$i]!="") && ($urlt==1)) {
    echo "<a href=\"".$teamu[$i]."\" target=\"_blank\" title=\"".$text[46]."\">";
    }
    echo $dummy.$teams[$i].$dumm2;
    if (($teamu[$i]!="") && ($urlt==1)) {
    echo "</a>";
    }?>
      </nobr>
      </td>
      <td class="<?=$dumm1; ?>" width="2">&nbsp;</td>
      <td class="<?=$dumm1; ?>"><?
    if (($teamn[$i]!="") || (($strafp[$i]!=0) || ($strafm[$i]!=0))) {
    $dum27=addslashes($teams[$i]);
    if (($strafp[$i]!=0) || ($strafm[$i]!=0)) {
      $dum27=$dum27."\\n\\n".$text[128].": ".$strafp[$i];
      if ($minus==2) {
      $dum27=$dum27.":".$strafm[$i];
      }
    }
    if ($teamn[$i]!="") {
      $dum27=$dum27."\\n\\n".$text[22].":\\n".$teamn[$i];
    }
    echo "<a href='' onClick=\"javascript:alert('".$dum27."');\" title=\"".str_replace("\\n","&#10;",$dum27)."\"><img src='".URL_TO_IMGDIR."/lmo-st2.gif' width=\"10\" height=\"12\" border=\"0\" alt=''></a>";
    } else {
    echo "&nbsp;";}?>
      </td>
      <td class="<?=$dumm1; ?>" width="2">&nbsp;</td>
      <td class="<?=$dumm1; ?>" align="right"><?=$dummy.$spiele[$i].$dumm2; ?></td>
      <td class="<?=$dumm1; ?>" align="right"><?=$dummy.$siege[$i].$dumm2; ?></td><? 
    if($hidr!=1){ ?>
      <td class="<?=$dumm1; ?>" align="right"><?=$dummy.$unent[$i].$dumm2; ?></td><? 
    }?>
      <td class="<?=$dumm1; ?>" align="right"><?=$dummy.$nieder[$i].$dumm2; ?></td><?
    if ($tabpkt==0) {
      echo "<td class=\"".$dumm1."\" width=\"2\">&nbsp;</td><td class=\"".$dumm1."\" align=\"right\">".$punkte[$i]."</td>";
      if ($minus==2) {
      echo "<td class=\"".$dumm1."\" align=\"center\" width=\"4\">".":"."</td>";
      echo "<td class=\"".$dumm1."\">".$negativ[$i]."</td>";
      }
    }
    if ($tipp_tippmodus==1) {?>
      <td class="<?=$dumm1; ?>" width="2">&nbsp;</td>
      <td class="<?=$dumm1; ?>" align="right"><?=$dummy.$etore[$i].$dumm2; ?></td>
      <td class="<?=$dumm1; ?>" align="center" width="4"><?=$dummy; ?>:<?=$dumm2; ?></td>
      <td class="<?=$dumm1; ?>"><?=$dummy.$atore[$i].$dumm2; ?></td>
      <td class="<?=$dumm1; ?>" align="right"><?=$dummy.$dtore[$i].$dumm2; ?></td><?
    }
    if ($tabpkt==1) {
      echo "<td class=\"".$dumm1."\" width=\"2\">&nbsp;</td><td class=\"".$dumm1."\" align=\"right\">".$punkte[$i]."</td>";
      if ($minus==2) {
      echo "<td class=\"".$dumm1."\" align=\"center\" width=\"4\">".":"."</td>";
      echo "<td class=\"".$dumm1."\">".$negativ[$i]."</td>";
      }
    }?>
      <td class="<?=$dumm1; ?>" align="right"><strong><?=$dummy.number_format($quote[$i]/100,2,".",",").$dumm2; ?></strong></td>
    </tr><? 
    }?>
    </table>
  </td>
  </tr><? 
    if($tipp_wertverein==1 && $tabtype==0){ ?>
  <tr>
  <td><?="&nbsp;" ?></td>
  </tr>
  <tr>
  <td class="lmost4" align="center"><?=$text['tipp'][261]; ?></td>
  </tr><?
      $st=$endtab;
      if ($nick!="") {
        $m=0;
        $auswertfile=PATH_TO_ADDONDIR."/tipp/".$tipp_dirtipp."auswert/vereine/".substr($file, strrpos($file,"/")+1, -4)."_".$nick.".ver";
        if (($endtab>1) && ($tabtype==0) && ($tabdat!="")) {
          $endtab--;
          require(PATH_TO_ADDONDIR."/tipp/lmo-tippcalcwertverein.php");
          
          $platz1 = array("");
          $platz1 = array_pad($array,$anzteams+1,"");
          for ($x=0; $x<$anzteams; $x++) {
            $x3=intval(substr($tab0[$x],25));
            $platz1[$x3]=$x+1;
          }
          $endtab++;
        }
        require(PATH_TO_ADDONDIR."/tipp/lmo-tippcalcwertverein.php");
      } elseif ($tipp_tipptabelle==1) {      // alle Tipper
        $tabdat="";
        $verz=opendir(PATH_TO_ADDONDIR."/tipp/".$tipp_dirtipp."auswert/vereine/");
        $dummy=array("");
        $liga=substr($file, strrpos($file,"/")+1, -4);
        while ($files=readdir($verz)) {
          if (strtolower(substr($files,0,strrpos($files,"_")))==strtolower($liga) && strtolower(substr($files,-4))==".ver") {
            array_push($dummy,$files);
          }
        }
        closedir($verz);
        array_shift($dummy);
        $anztipper=count($dummy);
        for ($m=0; $m<$anztipper; $m++) {
          $nick=substr($dummy[$m],strrpos($dummy[$m],"_")+1,-4);
          $auswertfile=PATH_TO_ADDONDIR."/tipp/".$tipp_dirtipp."auswert/vereine/".substr($file,strrpos($file,"/")+1,-4)."_".$nick.".ver";
          require(PATH_TO_ADDONDIR."/tipp/lmo-tippcalcwertverein.php");
        }
        $nick="";
      }
      
      $platz0 = array("");
      if (!isset($anzteams)) {
        $anzteams=0;
      }
      $platz0 = array_pad($array,$anzteams+1,"");
      for ($x=0; $x<$anzteams; $x++) {
        $x3=intval(substr($tab0[$x],25));
        $platz0[$x3]=$x+1;
      }?>
  <tr>
    <td align="center" class="lmost3">
      <table class="lmostb" cellspacing="0" cellpadding="0" border="0">
        <tr>
          <td class="lmost4" colspan="3"><?
    $dummy=" align=\"right\"";
    echo $tabdat;?>
          </td>
          <td class="lmost4" width="2">&nbsp;</td>
          <td class="lmost4"<?=$dummy; ?>><?=$text[33]; /* Spiele getippt*/ ?></td>
          <td class="lmost4" width="2">&nbsp;</td>
          <td class="lmost4"<?=$dummy; ?>><?if($tipp_tippmodus==1){echo $text[37];}else{echo $text['tipp'][122];}?></td>
          <td class="lmost4" width="2">&nbsp;</td>
          <td class="lmost4"<?=$dummy; ?>><strong><?if($tipp_tippmodus==1){echo $text[37]."/".$text[33];}else{echo $text['tipp'][123]."%";}?></strong></td>
        </tr><?
    $j=1;
    $spv=-1;
    $ppv=-1;
    for ($x=1; $x<=$anzteams; $x++) {
      if (!isset($team)) break;
      $i=intval(substr($tab0[$x-1],25));
      if ($team[$i]==$favteam) {
        // favteam
        $dummy="<strong>";
        $dumm2="</strong>";
      } else {
        $dummy="";
        $dumm2="";
      }
      $dumm1="lmost5";?>
        <tr>
          <td class="<?=$dumm1; ?>" align="right"><?=$dummy.$x.$dumm2;?></td><?
      $y=0;
      if (($endtab>1) && ($tabdat!="") && $tipppunktegesamt[intval(substr($tab0[0],25))]>0) {
        if ($platz0[$i]<$platz1[$i]) {
          $y=1;
        } else if ($platz0[$i]>$platz1[$i]) {
          $y=2;
        }
      }
      if ($tabdat!="") {
        echo "<td class=\"".$dumm1."\"";
        echo "><img src='lmo-tab".$y.".gif' width=\"9\" height=\"9\" border=\"0\">";
        echo "</td>";
      } else {
        echo "<td class=\"".$dumm1."\">&nbsp;</td>";
      }?>
          <td class="<?=$dumm1; ?>"><?=$dummy.$teams[$team[$i]].$dumm2; ?></td>
          <td class="<?=$dumm1; ?>" width="2">&nbsp;</td>
          <td class="<?=$dumm1; ?>" align="right"><?=$dummy.$spielegetippt[$i].$dumm2;?></td>
          <td class="<?=$dumm1; ?>" width="2">&nbsp;</td>
          <td class="<?=$dumm1; ?>" align="right"><?=$dummy.$tipppunktegesamt[$i].$dumm2;?></td><?
      $quote=0;
      if($spielegetippt[$i]!=0){
        if($tipp_tippmodus==1){
          $quote=number_format($tipppunktegesamt[$i]/$spielegetippt[$i],2,".",",");
        }
        if($tipp_tippmodus==0){
          $quote=number_format($tipppunktegesamt[$i]/$spielegetippt[$i]*100,2,".",",");
        }
      }?>
          <td class="<?=$dumm1?>" width="2">&nbsp;</td>
          <td class="<?=$dumm1?>" align="right"><?=$dummy?><strong><?=$quote?></strong><?=$dumm2?></td><?
      $spv=$spielegetippt[$i]; // merken
      $ppv=$tipppunktegesamt[$i];?>
        </tr><?
    } /* ende for($x=1;$x<=$anzteams;$x++)*/?>
      </table>
    </td>
  </tr><?
  }
  if($tabdat!=""){ ?>
  <tr>
    <td>
      <table width="100%" cellspacing="0" cellpadding="0" border="0">
        <tr><? 
    $st0=$endtab-1;
    if ($endtab>1) {
      echo "<td class=\"lmost2\"><a href=\"".$addt2.$st0."\" title=\"".$text[43]."\">".$text[5]."</a></td>";
    }
    $st0=$endtab+1;
    if ($endtab<$anzst) {
      echo "<td align=\"right\" class=\"lmost2\"><a href=\"".$addt2.$st0."\" title=\"".$text[44]."\">".$text[7]."</a></td>";
    }?>  
        </tr>
      </table>
    </td>
  </tr><? 
  }?>
  <tr>
    <td class="lmocross4" align="center"><? 
  if ($nick!=$lmotippername && $lmotippername!="") {
    echo "<a href=\"".$addt.$lmotippername."\" title=\"".$text['tipp'][173]."\">".$text['tipp'][182]."</a>";
  }
  echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
  if ($nick!="" && $tipp_tipptabelle==1) {
    echo "<a href=\"".$addt."\" title=\"".$text['tipp'][184]."\">".$text['tipp'][183]."</a>";
  }?>
    </td>
  </tr>
</table><?
} ?>