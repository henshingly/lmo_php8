<?php
/** Liga Manager Online 4
  *
  * http://lmo.sourceforge.net/
  *
  * This program is free software; you can redistribute it and/or
  * modify it under the terms of the GNU General Public License as
  * published by the Free Software Foundation; either version 2 of
  * the License, or (at your option) any later version.
  *
  * This program is distributed in the hope that it will be useful,
  * but WITHOUT ANY WARRANTY; without even the implied warranty of
  * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
  * General Public License for more details.
  *
  * REMOVING OR CHANGING THE COPYRIGHT NOTICES IS NOT ALLOWED!
  *
  *
  */


if ($file!="" && $tipp_tipptabelle1==1) {
  $endtab = $st;
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
    $nick=$_SESSION['lmotippername'];
  }
  if ($tipp_einsichterst==1) {
    require_once(PATH_TO_ADDONDIR."/tipp/lmo-tippaenderbar.php");
  }
  if ($file!="") {
    if ($nick!="") {
      $m=0;
      $tippfile=PATH_TO_ADDONDIR."/tipp/".$tipp_dirtipp.substr($file,0,-4)."_".$nick.".tip";
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
      $dummy=array();
      $liga=substr($file, 0, -4);
      while ($files=readdir($verz)) {
        if (strtolower(substr($files,0,strrpos($files,"_")))==strtolower($liga) && strtolower(substr($files,-4))==".tip") {
          array_push($dummy,$files);
        }
      }
      closedir($verz);
      $anztipper=count($dummy);
      for ($m=0; $m<$anztipper; $m++) {
        $nick=substr(substr($dummy[$m],strrpos($dummy[$m],"_")+1),0,-4);
        //echo $nick;
        $tippfile=PATH_TO_ADDONDIR."/tipp/".$tipp_dirtipp.$liga."_".$nick.".tip";
        require(PATH_TO_ADDONDIR."/tipp/lmo-tippopenfileall.php");
        require(PATH_TO_ADDONDIR."/tipp/lmo-tippcalctable.php");
      }
      $nick="";
      //Keine Tipper
      if ($m == 0) {
        echo getMessage($text['tipp'][17],TRUE);
      }
    }
  }
  $platz0 = array("");
  $platz0 = array_pad($array,$anzteams+1,"");
  for ($x=0; $x<$anzteams; $x++) {
    $x3=intval(substr($tab0[$x],42));
    $platz0[$x3]=$x+1;
  }
  if ($tabdat=="") {
    $addt1=$_SERVER['PHP_SELF']."?action=tipp&amp;todo=tabelle&amp;file=".$file."&ampnick=".$nick."&amp;tabtype=";
  } else {
    $addt1=$_SERVER['PHP_SELF']."?action=tipp&amp;todo=tabelle&amp;file=".$file."&amp;endtab=".$endtab."&amp;nick=".$nick."&amp;tabtype=";
  }
  $addr=$_SERVER['PHP_SELF']."?action=tipp&amp;todo=tabelle&amp;file=".$file."&amp;tabtype=".$tabtype."&amp;nick=".$nick."&amp;st=";
  $addt=$_SERVER['PHP_SELF']."?action=tipp&amp;todo=tabelle&amp;file=".$file."&amp;endtab=&amp;nick=";
  if($minus==2){
    $dummy=" colspan=\"3\" align=\"center\"";
  } else {
    $dummy=" align=\"right\"";
  }

?>
<table class="lmoInner" cellspacing="0" cellpadding="0" border="0"><?php 
  if($nick!=""){ ?>
  <caption><?php if($_SESSION["lmotipperok"]==5){echo $_SESSION['lmotippername'];if($_SESSION['lmotipperverein']!=""){echo " - ".$_SESSION['lmotipperverein'];}}else{echo $text['tipp'][158];}?></caption><?php 
    $hoy1=1;
    //  if ($tabtype==3){$hoy1=($anzst/2+1);}
    if ($tabtype!=3 && $tabtype!=4) {?>
  <tr>
    <td align="center"><?php include(PATH_TO_LMO."/lmo-spieltagsmenu.php");?></td>
  </tr><?php 
    }
  } /* ende if($nick!="") */?>
  <tr>
    <th class="nobr" align="center"><?php if($nick==$_SESSION['lmotippername'] && $nick!=""){echo $text['tipp'][173];}elseif ($nick!=""){echo $text['tipp'][181]." ".$nick;}else{echo $text['tipp'][184];} ?></th>
  </tr>
  <tr>
    <td align="center">
      <table class="lmoInner" cellspacing="0" cellpadding="0" border="0"><?php 
  if($nick!=""){ ?>
        <caption><?php 
    if($tabtype!="0"){?><a href="<?php echo $addt1."0"?>" title="<?php echo $text[27]?>"><?php echo $text[40]?></a><?php }else{echo $text[40];}?>&nbsp;<?php 
    if($tabtype!="1"){?><a href="<?php echo $addt1."1"?>" title="<?php echo $text[28]?>"><?php echo $text[41]?></a><?php }else{echo $text[41];}?>&nbsp;<?php 
    if($tabtype!="2"){?><a href="<?php echo $addt1."2"?>" title="<?php echo $text[29]?>"><?php echo $text[42]?></a><?php }else{echo $text[42];}?>&nbsp;<?php 
    if ($einhinrueck==1) {
      if($tabtype!="4"){?><a href="<?php echo $addt1."4"?>" title="<?php echo $text[4003]?>"><?php echo $text[4003]?></a><?php }else{echo $text[4003];}?>&nbsp;<?php 
      if($tabtype!="3"){?><a href="<?php echo $addt1."3"?>" title="<?php echo $text[4002]?>"><?php echo $text[4002]?></a><?php }else{echo $text[4002];}
    }?>
        </caption><?php 
  } /* ende if($nick!="")*/?>
        <tr>
          <th align="left" colspan="6"> <?php echo $tabdat; ?> &nbsp;</th>
          <th>&nbsp;</th>
          <th class="nobr" align="right"> <?php echo $text[33]; ?> &nbsp;</th>
          <th class="nobr" align="right"> <?php echo $text[34]; ?> &nbsp;</th><?php 
   if($hidr!=1){?>
          <th class="nobr" align="right"> <?php echo $text[35];?> &nbsp;</th><?php 
   }?>
          <th class="nobr" align="right"> <?php echo $text[36]; ?> &nbsp;</th><?php 
   if($tabpkt==0){?>
          <th>&nbsp;</th>
          <th class="nobr" <?php echo $dummy?>> <?php echo $text[37]?> &nbsp;</th><?php 
   }
   if($tipp_tippmodus==1){ ?>
          <th>&nbsp;</th>
          <th class="nobr" colspan="3" align="center"> <?php echo $text[38]; ?> </th>
          <th class="nobr" align="right"> <?php echo $text[39]; ?> </th><?php 
   }
   if($tabpkt==1){ ?>
          <th>&nbsp;</th>
          <th class="nobr" <?php echo $dummy?>><?php echo $text[37]?> </th><?php 
   }?>
          <th class="nobr" align="right"><?php echo $text[37]."/".$text[33]; ?></th>
        </tr><?php 
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
    $lmo_tabelle_class="nobr";
    if ($tabtype==0) {
      if (($x==1) && ($champ!=0)) {
        $lmo_tabelle_class="lmoTabelleMeister nobr";
        $j=2;
      }
      if (($x>=$j) && ($x<$j+$anzcl) && ($anzcl>0)) {
        $lmo_tabelle_class="lmoTabelleCleague nobr";
      }
      if (($x>=$j+$anzcl) && ($x<$j+$anzcl+$anzck) && ($anzck>0)) {
        $lmo_tabelle_class="lmoTabelleCleaguequali nobr";
      }
      if (($x>=$j+$anzcl+$anzck) && ($x<$j+$anzcl+$anzck+$anzuc) && ($anzuc>0)) {
        $lmo_tabelle_class="lmoTabelleUefa nobr";
      }
      if (($x<=$anzteams) && ($x>$anzteams-$anzab) && ($anzab>0)) {
        $lmo_tabelle_class="lmoTabelleAbsteiger nobr";
      }
      if (($x<=$anzteams-$anzab) && ($x>$anzteams-$anzab-$anzar) && ($anzar>0)) {
        $lmo_tabelle_class="lmoTabelleRelegation nobr";
      }
    }?>
        <tr>
          <td class="<?php echo $lmo_tabelle_class; ?> nobr" align="right"> <?php echo $dummy.$x.$dumm2; ?> </td><?php 
    $y=0;
    if (($endtab>1) && ($tabtype==0) && ($tabdat!="")) {
      if ($platz0[$i]<$platz1[$i]) {
        $y=1;
      } else if ($platz0[$i]>$platz1[$i]) {
        $y=2;
      }
    }
    if ($tabdat!="") {
      echo "<td class=\"".$lmo_tabelle_class."\"";
      if ($tabtype==0) {
        echo "><img src='".URL_TO_IMGDIR."/lmo-tab".$y.".gif' width=\"9\" height=\"9\" border=\"0\" alt=''>";
      } else {
        echo " width=\"2\">&nbsp;";
      }
      echo "</td>";
    } else {
      echo "<td class=\"".$lmo_tabelle_class."\">&nbsp;</td>";
    }?>
          <td class="<?php echo $lmo_tabelle_class?>" align="center"><?php echo HTML_smallTeamIcon($file,$teams[$i]," alt=''"); ?>&nbsp;</td>
          <td class="<?php echo $lmo_tabelle_class; ?> nobr" align="left"> <?php 
    echo $dummy.$teams[$i].$dumm2;
    if (($teamu[$i]!="") && ($urlt==1)) {
      echo " <a href=\"".$teamu[$i]."\" target=\"_blank\" title=\"".$text[46]."\"><img border='0' width='11' src='".URL_TO_IMGDIR."/url.png' alt='".$text[564]."' title=\"".$text[46]."\"></a> ";
    }?>
          </td>
          <td class="<?php echo $lmo_tabelle_class; ?>">&nbsp;</td>
          <td class="<?php echo $lmo_tabelle_class; ?>" align="center"><?php 

    if ($teamn[$i]!="" || $strafp[$i]!=0 || $strafm[$i]!=0 || $torkorrektur1[$i]!=0 || $torkorrektur2[$i]!=0) {
      $lmo_tabellennotiz=HTML_smallTeamIcon($file,$teams[$i]," alt=''");          

      /** Notizen anzeigen
       *
       * Achtung: Da beim Speichern Strafpunkte/-tore positiv sind und Bonuspunkte negativ (altes System des LMO)
       * muss mit -1 multipliziert werden, um die Punkte/Tore richtig anzuzeigen
       */

      $lmo_tabellennotiz.=" <strong>".$teams[$i]."</strong>";
      //Straf-/Bonuspunkte
      if ($strafp[$i]!=0 || $strafm[$i]!=0) {
        $lmo_tabellennotiz.="\n\n<strong>".$text[128].":</strong>\n";
        //Punkte
        $lmo_tabellennotiz.=$strafp[$i]<0?"+".((-1)*applyFactor($strafp[$i],$pointsfaktor)):((-1)*applyFactor($strafp[$i],$pointsfaktor));
        //Minuspunkte
        if ($minus==2) {
          $lmo_tabellennotiz.=":".($strafm[$i]<0?"+".((-1)*applyFactor($strafm[$i],$pointsfaktor)):((-1)*applyFactor($strafm[$i],$pointsfaktor)));
        }
        //Ab ST
        if ($strafdat[$i]!=0) $lmo_tabellennotiz.=" ({$text[524]} {$text[2]} {$strafdat[$i]})";
      }
      //Straf-/Bonustore
      if ($torkorrektur1[$i]!=0 || $torkorrektur2[$i]!=0) {
        $lmo_tabellennotiz.="\n<strong>".$text[522].":</strong>\n";
        //Tore
        $lmo_tabellennotiz.=$torkorrektur1[$i]<0?"+".((-1)*applyFactor($torkorrektur1[$i],$goalfaktor)).":":((-1)*applyFactor($torkorrektur1[$i],$goalfaktor)).":";
        //Gegentore
        $lmo_tabellennotiz.=$torkorrektur2[$i]<0?"+".((-1)*applyFactor($torkorrektur2[$i],$goalfaktor)):((-1)*applyFactor($torkorrektur2[$i],$goalfaktor));
        //Ab ST
        if ($strafdat[$i]!=0) $lmo_tabellennotiz.=" ({$text[524]} {$text[2]} {$strafdat[$i]})";
      }
      //Teamnotizen
      if ($teamn[$i]!="") {
        $lmo_tabellennotiz.="\n\n<strong>".$text[22].":</strong>\n".$teamn[$i];
      }?>
        <a href='#' onclick="alert('<?php echo addcslashes('',htmlentities(strip_tags($lmo_tabellennotiz)))?>');window.focus();return false;"><img src='<?php echo URL_TO_IMGDIR."/lmo-st2.gif"?>' width='10' height='12' border='0' alt=''><span class='popup'><?php echo nl2br($lmo_tabellennotiz)?></span></a><?php 
      $lmo_tabellennotiz="";
    } else {
      echo "&nbsp;";
    }?>
          </td>
          <td class="<?php echo $lmo_tabelle_class; ?>" width="2">&nbsp;</td>
          <td class="<?php echo $lmo_tabelle_class; ?>" align="right"> <?php echo $dummy.$spiele[$i].$dumm2; ?> &nbsp;</td>
          <td class="<?php echo $lmo_tabelle_class; ?>" align="right"> <?php echo $dummy.$siege[$i].$dumm2; ?> &nbsp;</td><?php 
    if($hidr!=1){ ?>
          <td class="<?php echo $lmo_tabelle_class; ?>" align="right"> <?php echo $dummy.$unent[$i].$dumm2; ?> &nbsp;</td><?php 
    }?>
          <td class="<?php echo $lmo_tabelle_class; ?>" align="right"> <?php echo $dummy.$nieder[$i].$dumm2; ?> &nbsp;</td><?php 
    if ($tabpkt==0) {
      echo "<td class=\"".$lmo_tabelle_class."\" width=\"2\">&nbsp;</td><td class=\"".$lmo_tabelle_class."\" align=\"right\">".applyFactor($punkte[$i],$pointsfaktor)."</td>";
      if ($minus==2) {
      echo "<td class=\"".$lmo_tabelle_class."\" align=\"center\" width=\"4\">".":"."</td>";
      echo "<td class=\"".$lmo_tabelle_class."\">".applyFactor($negativ[$i],$pointsfaktor)."</td>";
      }
    }
    if ($tipp_tippmodus==1) {?>
          <td class="<?php echo $lmo_tabelle_class; ?>" width="2">&nbsp;</td>
          <td class="<?php echo $lmo_tabelle_class; ?>" align="right"><?php echo $dummy.applyFactor($etore[$i],$goalfaktor).$dumm2; ?></td>
          <td class="<?php echo $lmo_tabelle_class; ?>" align="center" width="4"><?php echo $dummy; ?>:<?php echo $dumm2; ?></td>
          <td class="<?php echo $lmo_tabelle_class; ?>"><?php echo $dummy.applyFactor($atore[$i],$goalfaktor).$dumm2; ?></td>
          <td class="<?php echo $lmo_tabelle_class; ?>" align="right"><?php echo $dummy.applyFactor($dtore[$i],$goalfaktor).$dumm2; ?></td><?php 
    }
    if ($tabpkt==1) {
      echo "<td class=\"".$lmo_tabelle_class."\" width=\"2\">&nbsp;</td><td class=\"".$lmo_tabelle_class."\" align=\"right\">".applyFactor($punkte[$i],$pointsfaktor)."</td>";
      if ($minus==2) {
      echo "<td class=\"".$lmo_tabelle_class."\" align=\"center\" width=\"4\">".":"."</td>";
      echo "<td class=\"".$lmo_tabelle_class."\">".applyFactor($negativ[$i],$pointsfaktor)."</td>";
      }
    }?>
          <td class="<?php echo $lmo_tabelle_class; ?>" align="right"><strong><?php echo $dummy.number_format($quote[$i]/100,2,".",",").$dumm2; ?></strong></td>
        </tr><?php 
    }?>
      </table>
    </td>
  </tr>
</table>
<?php 
  }
  if($tabdat!=""){ ?>

      <table width="100%" cellspacing="0" cellpadding="0" border="0">
        <tr><?php 
   $st0 = $st-1;
   if ($st > 1) {?>
          <td align="left">&nbsp;<a href="<?php echo $addr.$st0?>" title="<?php echo $text[6]?>"><?php echo $text[5]?> <?php echo $text[6]?></a>&nbsp;</td><?php 
   }
   $st0 = $st+1;
   if ($st < $anzst) {?>
          <td align="right">&nbsp;<a href="<?php echo $addr.$st0?>" title="<?php echo $text[8]?>"><?php echo $text[8]?> <?php echo $text[7]?></a>&nbsp;</td><?php 
   }?>
        </tr>
      </table>

<?php 
  }
  if($tipp_wertverein==1 && $tabtype==0){ ?>
<p>&nbsp;</p>
<table class="lmoInner" cellspacing="0" cellpadding="0" border="0">
  <tr>
    <th align="center"><?php echo $text['tipp'][261]; ?></th>
  </tr><?php 
      $st=$endtab;
      if ($nick!="") {
        $m=0;
        $auswertfile=PATH_TO_ADDONDIR."/tipp/".$tipp_dirtipp."auswert/vereine/".substr($file, 0, -4)."_".$nick.".ver";
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
        $dummy=array();
        $liga=substr($file, 0, -4);
        while ($files=readdir($verz)) {
          if (strtolower(substr($files,0,strrpos($files,"_")))==strtolower($liga) && strtolower(substr($files,-4))==".ver") {
            array_push($dummy,$files);
          }
        }
        closedir($verz);
        $anztipper=count($dummy);
        for ($m=0; $m<$anztipper; $m++) {
          $nick=substr(substr($dummy[$m],strrpos($dummy[$m],"_")+1),0,-4);
          $auswertfile=PATH_TO_ADDONDIR."/tipp/".$tipp_dirtipp."auswert/vereine/".substr($file,0,-4)."_".$nick.".ver";
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
    <td align="center">
      <table class="lmoInner" cellspacing="0" cellpadding="0" border="0">
        <tr>
          <th colspan="3"><?php $dummy=" align=\"right\"";echo $tabdat;?></th>
          <th width="2">&nbsp;</th>
          <th class="nobr" <?php echo $dummy; ?>><?php echo $text[33]; /* Spiele getippt*/ ?></th>
          <th width="2">&nbsp;</th>
          <th class="nobr" <?php echo $dummy; ?>><?php if($tipp_tippmodus==1){echo $text[37];}else{echo $text['tipp'][122];}?></th>
          <th width="2">&nbsp;</th>
          <th class="nobr" <?php echo $dummy; ?>><strong><?php if($tipp_tippmodus==1){echo $text[37]."/".$text[33];}else{echo $text['tipp'][123]."%";}?></strong></th>
        </tr><?php 
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
      $lmo_tabelle_class="nobr";?>
        <tr>
          <td class="<?php echo $lmo_tabelle_class; ?>" align="right"><?php echo $dummy.$x.$dumm2;?>&nbsp;</td><?php 
      $y=0;
      if (($endtab>1) && ($tabdat!="") && $tipppunktegesamt[intval(substr($tab0[0],25))]>0) {
        if ($platz0[$i]<$platz1[$i]) {
          $y=1;
        } else if ($platz0[$i]>$platz1[$i]) {
          $y=2;
        }
      }
      if ($tabdat!="") {
        echo "<td class=\"".$lmo_tabelle_class."\"";
        echo "><img src='".URL_TO_IMGDIR."/lmo-tab".$y.".gif' width=\"9\" height=\"9\" border=\"0\" alt=''>&nbsp;";
        echo "</td>";
      } else {
        echo "<td class=\"".$lmo_tabelle_class."\">&nbsp;</td>";
      }?>
          <td class="<?php echo $lmo_tabelle_class; ?>" align="left"><?php echo $dummy.$teams[$team[$i]].$dumm2; ?></td>
          <td class="<?php echo $lmo_tabelle_class; ?>">&nbsp;</td>
          <td class="<?php echo $lmo_tabelle_class; ?>" align="right"><?php echo $dummy.$spielegetippt[$i].$dumm2;?></td>
          <td class="<?php echo $lmo_tabelle_class; ?>">&nbsp;</td>
          <td class="<?php echo $lmo_tabelle_class; ?>" align="right"><?php echo $dummy.$tipppunktegesamt[$i].$dumm2;?></td><?php 
      $quote=0;
      if($spielegetippt[$i]!=0){
        if($tipp_tippmodus==1){
          $quote=number_format($tipppunktegesamt[$i]/$spielegetippt[$i],2,".",",");
        }
        if($tipp_tippmodus==0){
          $quote=number_format($tipppunktegesamt[$i]/$spielegetippt[$i]*100,2,".",",");
        }
      }?>
          <td class="<?php echo $lmo_tabelle_class?>" width="2">&nbsp;</td>
          <td class="<?php echo $lmo_tabelle_class?>" align="right"><?php echo $dummy?><strong><?php echo $quote?></strong><?php echo $dumm2?></td><?php 
      $spv=$spielegetippt[$i]; // merken
      $ppv=$tipppunktegesamt[$i];?>
        </tr><?php 
    } /* ende for($x=1;$x<=$anzteams;$x++)*/?>
      </table>
    </td>
  </tr>
  <tr>
    <td class="lmoFooter" align="center"><?php 
  if ($nick!=$_SESSION['lmotippername'] && $_SESSION['lmotippername']!="") {
    echo "<a href=\"".$addt.$_SESSION['lmotippername']."\" title=\"".$text['tipp'][173]."\">".$text['tipp'][182]."</a>";
  }
  echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
  if ($nick!="" && $tipp_tipptabelle==1) {
    echo "<a href=\"".$addt."\" title=\"".$text['tipp'][184]."\">".$text['tipp'][183]."</a>";
  }?>
    </td>
  </tr>
</table><?php 
}?>
