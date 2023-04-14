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
  */
  
//$endtab        = isset($_REQUEST['endtab'])        ? $_REQUEST['endtab']                : ''; 
if ($endtab == 0) {
  if (isset($anzst)) {
    $endtab = $anzst;
  }
  $tabdat = "";
} else {
  $tabdat = $endtab.". ".$text[2];
}
$all        = isset($_REQUEST['all'])        ? $_REQUEST['all']                : 0;
//  if($stwertmodus=="bis" ){$endtab=$anzst;}
if ($all == 1) {
  $endtab = 0;
  $tabdat = "";
  $anzst = 0;
} else {
  $st = $endtab;
}
$wertung        = isset($_REQUEST['wertung'])        ? $_REQUEST['wertung']                : 'einzel';
$gewicht        = isset($_REQUEST['gewicht'])        ? $_REQUEST['gewicht']                : 'absolut';
$stwertmodus    = isset($_REQUEST['stwertmodus'])    ? $_REQUEST['stwertmodus']            : 'bis';
//$tipp_anzseite1 = isset($_REQUEST['tipp_anzseite1']) ? intval($_REQUEST['tipp_anzseite1']) : $tipp_anzseite1;
$von            = isset($_REQUEST['von'])            ? intval($_REQUEST['von'])            : 1;
$start          = isset($_REQUEST['start'])          ? intval($_REQUEST['start'])          : 1;
$eigpos         = isset($_REQUEST['eigpos'])         ? intval($_REQUEST['eigpos'])         : 1;
$wertung = isset($_REQUEST['wertung']) ? $_REQUEST['wertung'] : "einzel";

if (($tabdat != "" && $stwertmodus == "nur") || $all == 1) {
  $tipp_showstsiege = 0;
}

if ($tipp_anzseite1 < 1) {
  $tipp_anzseite1 = 40;
}

if ($endtab > 1 && $tabdat != "" && $stwertmodus != "nur") {
  $endtab--;
  if ($wertung == "einzel" || $wertung == "intern") {
    require(PATH_TO_ADDONDIR."/tipp/lmo-tippcalcwert.php");
  } else {
    require(PATH_TO_ADDONDIR."/tipp/lmo-tippcalcwertteam.php");
  }
  if ($wertung == "team") {
    $anztipper = $teamsanzahl;
  }
  $platz1 = array("");
  $platz1 = array_pad($array, $anztipper+1, "");
  for($x = 0; $x < $anztipper; $x++) {
    $x3 = intval(substr($tab0[$x], -7));
    $platz1[$x3] = $x+1;
  }
  $endtab++;
}
if ($wertung == "einzel" || $wertung == "intern") {
  require(PATH_TO_ADDONDIR."/tipp/lmo-tippcalcwert.php");
} else {
  require(PATH_TO_ADDONDIR."/tipp/lmo-tippcalcwertteam.php");
}
 
if ($wertung == "team" && isset($teamsanzahl)) {
  $anztipper = $teamsanzahl;
}
$platz0 = array("");
if (!isset($anztipper)) {
  $anztipper = 0;
}
$platz0 = array_pad($array, $anztipper+1, "");
for($x = 0; $x < $anztipper; $x++) {
  $x3 = intval(substr($tab0[$x], -7));
  $platz0[$x3] = $x+1;
}

if ($tabdat == "") {
  $addt1 = $_SERVER['PHP_SELF']."?action=tipp&amp;todo=wert&amp;all=".$all."&amp;file=".$file."&amp;gewicht=".$gewicht."&amp;wertung=";
} else {
  $addt1 = $_SERVER['PHP_SELF']."?action=tipp&amp;todo=wert&amp;stwertmodus=".$stwertmodus."&amp;file=".$file."&amp;gewicht=".$gewicht."&amp;endtab=".$endtab."&amp;wertung=";
}
$addr = $_SERVER['PHP_SELF']."?action=tipp&amp;todo=wert&amp;stwertmodus=".$stwertmodus."&amp;gewicht=".$gewicht."&amp;all=".$all."&amp;file=".$file."&amp;wertung=".$wertung."&amp;teamintern=".str_replace(" ", "%20", $teamintern)."&amp;endtab=";
if ($tabdat == "") {
  $addt3 = $_SERVER['PHP_SELF']."?action=tipp&amp;todo=wert&amp;stwertmodus=".$stwertmodus."&amp;gewicht=".$gewicht."&amp;all=".$all."&amp;file=".$file."&amp;wertung=".$wertung."&amp;teamintern=".str_replace(" ", "%20", $teamintern)."&amp;start=";
} else {
  $addt3 = $_SERVER['PHP_SELF']."?action=tipp&amp;todo=wert&amp;stwertmodus=".$stwertmodus."&amp;gewicht=".$gewicht."&amp;all=".$all."&amp;file=".$file."&amp;wertung=".$wertung."&amp;teamintern=".str_replace(" ", "%20", $teamintern)."&amp;endtab=".$endtab."&amp;start=";
}
$addt4 = $_SERVER['PHP_SELF']."?action=tipp&amp;todo=wert&amp;gewicht=".$gewicht."&amp;file=".$file."&amp;endtab=".$endtab."&amp;wertung=".$wertung."&amp;teamintern=".str_replace(" ", "%20", $teamintern)."&amp;stwertmodus=";
if ($tabdat == "") {
  $addt5 = $_SERVER['PHP_SELF']."?action=tipp&amp;todo=wert&amp;all=".$all."&amp;file=".$file."&amp;wertung=".$wertung."&amp;teamintern=".str_replace(" ", "%20", $teamintern)."&amp;gewicht=";
} else {
  $addt5 = $_SERVER['PHP_SELF']."?action=tipp&amp;todo=wert&amp;stwertmodus=".$stwertmodus."&amp;file=".$file."&amp;endtab=".$endtab."&amp;wertung=".$wertung."&amp;teamintern=".str_replace(" ", "%20", $teamintern)."&amp;gewicht=";
}
?>
<div class="container">
  <div class="row">
    <div class="col"><?php include(PATH_TO_LMO."/lmo-spieltagsmenu.php");?></div>
  </div>
  <?php if($tipp_tipperimteam>=0){?>
  <div class="row">
    <div class="col-2"><?php
  if ($wertung == "einzel") {
    echo $text['tipp'][61];
  } else {
    echo "<a href=\"".$addt1."einzel\" title=\"".$text['tipp'][59]."\">".$text['tipp'][61]."</a>";
  }?>
    </div>
    <div class="col-2"><?php
  if ($wertung == "team") {
    echo $text['tipp'][62];
  } else {
    echo "<a href=\"".$addt1."team\" title=\"".$text['tipp'][60]."\">".$text['tipp'][62]."</a>";
  }?>
    </div><?php
  if ($_SESSION['lmotipperverein'] != "" || $wertung == "intern") {?>
     <div class="col-2"><?php
    if ($wertung == "intern") {
      echo $text['tipp'][144];
    } else {
      echo "<a href=\"".$addt1."intern&amp;teamintern=".rawurlencode($_SESSION['lmotipperverein'])."\" title=\"".$text['tipp'][144]."\">".$text['tipp'][144]."</a>";
    }?>
     </div><?php
  }?>
   </div><?php } ?>
   <div class="row">
     <div class="col">
     </div>
   </div>
</div>

<table class="table" id="1">
<?php
$dummy = "";
?>
  <tr>
    <td>
      <table class="table" id="4"><?php
if($all==0){ ?>
        <caption><?php
  if ($stwertmodus == "nur") {
    echo $text['tipp'][202];
  } else {
    echo "<a href=\"".$addt4."nur\" title=\"".$text['tipp'][202]."\">".$text['tipp'][202]."</a>";
  }
  echo " ";
  if ($stwertmodus == "bis") {
    echo $text['tipp'][203];
  } else {
    echo "<a href=\"".$addt4."bis\" title=\"".$text['tipp'][203]."\">".$text['tipp'][203]."</a>";
  }?>
</caption><?php
}?>
        <tr>
          <th colspan="3"> <?php
if (isset($lmtype) && $lmtype == 1 && $tabdat != "") {
  if ($st == $anzst) {
    $j = $text[374];
  } elseif($st == $anzst-1) {
    $j = $text[373];
  } elseif($st == $anzst-2) {
    $j = $text[372];
  } elseif($st == $anzst-3) {
    $j = $text[371];
  } else {
    $j = $st.". ".$text[370];
  }
  echo $j;
} else {
  echo $tabdat;
}?>       </th><?php
if( $wertung=="einzel"  || $wertung=="intern"){
  if( $tipp_tipperimteam>=0){?>
          <th> <?php echo $text['tipp'][27]; /* Team */?> </th><?php
  }
} else { /* Teamwertung*/?>
          <th><acronym title="<?php echo $text['tipp'][120]?>"><?php echo $text['tipp'][26]; /* Anzahl Tipper*/ ?></acronym></th>
          <th><acronym title="<?php echo $text['tipp'][208]?>"><?php echo $text['tipp'][26]."Ø"; /* Anzahl Tipper Durchschnitt*/ ?></acronym></th><?php }?>
          <th <?php echo $dummy; ?>><acronym title="<?php echo $text['tipp'][117]?>"><?php if($gewicht!="spiele"){
  echo "<a href=\"".$addt5."spiele\">";
}
echo $text['tipp'][123]; // Spiele getippt
if($gewicht!="spiele"){
  echo "</a>";
}         ?></acronym>
          </th><?php
if($tipp_showzus==1){
  if($tipp_tippmodus==1){
    if($tipp_rergebnis>0){ ?>
          <th><acronym title="<?php echo $text['tipp'][34].": ".$tipp_rergebnis." ".$text['tipp'][38]?>"><?php echo $text['tipp'][221]; /* RE */?></acronym></th><?php    }
    if($tipp_rtendenzdiff>$tipp_rtendenz){ ?>
          <th><acronym title="<?php echo $text['tipp'][35].": ".$tipp_rtendenzdiff." ".$text['tipp'][38]?>"><?php echo $text['tipp'][222]; /* RTD */?></acronym></th><?php    }
    if($tipp_rtendenz>0){ ?>
          <th><acronym title="<?php echo $text['tipp'][36].": ".$tipp_rtendenz." ".$text['tipp'][38]?>"><?php echo $text['tipp'][223]; /* RT */?></acronym></th><?php    }
    if($tipp_rtor>0){ ?>
          <th><acronym title="<?php echo $text['tipp'][37].": ".$tipp_rtor." ".$text['tipp'][38]?>"><?php echo $text['tipp'][224]; /* RG */?></acronym></th><?php    }
  } // ende if($tipp_tippmodus==1) 
  if($tipp_rremis>0){ ?>
          <th><acronym title="<?php echo $text['tipp'][192].": ".$tipp_rremis." ".$text['tipp'][38]?>"><?php echo $text['tipp'][225]; /* UB */?></acronym></th><?php  }
  if($tipp_jokertipp==1){ ?>
          <th><acronym title="<?php echo $text['tipp'][227]?>"><?php echo $text['tipp'][226]; /* JP */?></acronym></th><?php  }
} // ende if($tipp_showzus==1) 
if($tipp_showstsiege==1){ ?>
          <th><acronym title="<?php echo $text['tipp'][271]?>"><?php echo $text['tipp'][90]; /* GS */?></acronym></th><?php }?>
          <th <?php echo $dummy; ?>><acronym title="<?php if ($tipp_tippmodus == 1) { echo $text['tipp'][124];} else { echo $text['tipp'][125]."%";}?>"><?php if ($gewicht != "relativ") {
  echo "<a href=\"".$addt5."relativ\">";
}
if ($tipp_tippmodus == 1) {
  echo $text['tipp'][123]."Ø";
} else {
  echo $text['tipp'][123]."%";
}
if ($gewicht != "relativ") {
  echo "</a>";
}         ?></acronym>
          </th>
          <th <?php echo $dummy; ?>><acronym title="<?php echo $text['tipp'][118]?>"><?php if ($gewicht != "absolut") {
  echo "<a href=\"".$addt5."absolut\" title=\"".$text['tipp'][149]."\">";
}
if ($tipp_tippmodus == 1) {
  echo $text[37];
} else {
  echo $text['tipp'][122];
}
if ($gewicht != "absolut") {
  echo "</a>";
}       ?></acronym></th>
        </tr><?php
$eigplatz = $anztipper+2;
$j = 1;
$ende = $start+$tipp_anzseite1-1;
if ($ende > $anztipper) {
  $ende = $anztipper;
}
if (!isset($lx)) {
  $lx = 1;
}
if (!isset($lax)) {
  $lax = 0;
}
if ($anztipper > 0) {
  $laeng = strlen($tab0[0]);
}
for($x = 1; $x <= $anztipper; $x++) {
  $i = intval(substr($tab0[$x-1], -7));
  if (($x >= $start && $x <= $ende) /*|| $i == $eigpos*/) {
     
    $poswechs = 1;
    if ($x > 1) {
      for($k = 0; $k <= $laeng-24; $k += 8) {
        if (intval(substr($tab0[$x-1], $k+1, 7)) != intval(substr($tab0[$x-2], $k+1, 7))) {
          break;
        }
        if ($k == $laeng-24) {
          $poswechs = 0;
        }
      }
    }
    if ($x == 1 || $poswechs == 1) {
      $lx = $x;
    }
     
    if ($wertung != "intern" || $teamintern == $tipperteam[$i]) {
      if ($lx == $x) {
        $lax = $x;
      }
      if ($i == $eigpos) {
        $eigplatz = $x;
      }
      if (($x == $start && $eigplatz < $x-1) || ($x == $eigplatz && $x > $ende+1)) {?>
        <tr>
          <td>...</td>
        </tr><?php
      }

      if ((($wertung == "einzel" || $wertung == "intern") && $_SESSION['lmotippername'] == $tippernick[$i]) || ($wertung == "team" && $_SESSION['lmotipperverein'] == $team[$i])) {
        $dummy = "<strong>";
        $dumm2 = "</strong>";
      } else {
        $dummy = "";
        $dumm2 = "";
      }
       
      if ($wertung == "team" || $tippernick[$i] != "") {?>
        <tr>
          <td><?php
        if ($lax == $x) {
          echo $x;
        } elseif($wertung == "intern" && $lax != $lx) {
          echo $lx;
          $lax = $lx;
        } else {
          echo "";
      }?>
          </td><?php
      $y = 0;
      if (($endtab > 1) && ($tabdat != "") && $tipppunktegesamt[intval(substr($tab0[0], -7))] > 0 && $stwertmodus != "nur") {
        if ($platz0[$i] < $platz1[$i]) {
          $y = 1;
        } elseif($platz0[$i] > $platz1[$i]) {
          $y = 2;
        }
      }
      if ($tabdat != "" && $stwertmodus != "nur") {
        echo "<td><img src='".URL_TO_IMGDIR."/lmo-tab".$y.".gif' width=\"9\" height=\"9\" border=\"0\" alt=''></td>";
      } else {
        echo "<td></td>";
      }
      
      if( $wertung=="einzel" || $wertung=="intern"){?>
          <td><?php
        echo $dummy;
        if ($tipp_showname == 1) {
          if ($tipp_showemail == 1 && !empty($tipperemail[$i])) {
            echo "<a href='mailto:".$tipperemail[$i]."'>";
          }
          echo $tippername[$i];
          if ($tipp_showemail == 1 && !empty($tipperemail[$i])) {
            echo "</a>";
          }
        }
        if ($tipp_shownick == 1 || ($tipp_showemail == 0 && $tipp_showname == 0)) {
          if ($tipp_showname == 1) {
            echo " (";
          }
          if ($tipp_showname == 0 && $tipp_showemail == 1) {
            echo "<a href='mailto:".$tipperemail[$i]."'>";
          }
          echo $tippernick[$i];
          if ($tipp_showname == 0 && $tipp_showemail == 1) {
            echo "</a>";
          }
          if ($tipp_showname == 1) {
            echo ")";
          }
        } elseif($tipp_showemail == 1 && $tipp_showname == 0) {
          echo "<a href='mailto:".$tipperemail[$i]."'>".$tipperemail[$i]."</a>";
        }
        echo $dumm2;?>
          </td><?php
      } else {?>
          <td><?php if($wertung!="intern" && $team[$i]!=" "){echo "<a href=\"".$addt1."intern&amp;teamintern=".str_replace(" ","%20",$team[$i])."\" title=\"".$text['tipp'][144]."\">";} echo $dummy.$team[$i].$dumm2; if($wertung!="intern" && $team[$i]!=" "){echo "</a>";} ?></td><?php
      }

      if ($tipp_tipperimteam >= 0) {
        if ($wertung == "einzel" || $wertung == "intern") {
          if ($tipperteam[$i] == "") {
            $tipperteam[$i] = "";
          }?>
          
          <td><?php if($wertung!="intern" && $tipperteam[$i]!=""){echo "<a href=\"".$addt1."intern&amp;teamintern=".str_replace(" ","%20",$tipperteam[$i])."\" title=\"".$text['tipp'][144]."\">";} echo $dummy.$tipperteam[$i].$dumm2; if($wertung!="intern" && $tipperteam[$i]!=""){echo "</a>";} ?></td><?php
        } else {?>
          
          <td><?php echo $dummy.$tipp_tipperimteam[$i].$dumm2; ?> </td>
          
          <td><?php echo $dummy.number_format($tipppunktegesamt[$i]/$tipp_tipperimteam[$i],2,".",",").$dumm2; ?></td><?php
        }
      }
      echo "<td>";
      if ($gewicht == "spiele") {
        echo "<strong>";
      } else {
        echo $dummy;
      }
      echo $spielegetipptgesamt[$i];
      if ($gewicht == "spiele") {
        echo "</strong>";
      } else {
        echo $dumm2;
      }
      echo "</td>";
       
      if ($tipp_showzus == 1) {
        if ($tipp_tippmodus == 1) {
          
          if ($tipp_rergebnis > 0) {
            if ($punkte1gesamt[$i] == "") {
              $punkte1gesamt[$i] = "";
            }?>
          
          <td><?php echo $dummy.$punkte1gesamt[$i].$dumm2; ?></td><?php          }
          
          if ($tipp_rtendenzdiff > $tipp_rtendenz) {
            if ($punkte2gesamt[$i] == "") {
              $punkte2gesamt[$i] = "";
            }?>
          
          <td><?php echo $dummy.$punkte2gesamt[$i].$dumm2; ?></td><?php          } else {
            $punkte3gesamt[$i]+=$punkte2gesamt[$i];
          }
          
          if($tipp_rtendenz>0){
            if($punkte3gesamt[$i]==""){
              $punkte3gesamt[$i]="";
            }?>
          
          <td><?php echo $dummy.$punkte3gesamt[$i].$dumm2; ?></td><?php          }
          
          if($tipp_rtor>0){
            if($punkte4gesamt[$i]==""){
              $punkte4gesamt[$i]="";
            }?>
          
          <td><?php echo $dummy.$punkte4gesamt[$i].$dumm2; ?></td><?php          }
        } // ende if($tipp_tippmodus==1)
        
        if($tipp_rremis>0){
          if($punkte5gesamt[$i]==""){
            $punkte5gesamt[$i]="";
          }?>
          
          <td><?php echo $dummy.$punkte5gesamt[$i].$dumm2; ?></td><?php        }
        
        if($tipp_jokertipp==1){
          if($punkte6gesamt[$i]==""){
            $punkte6gesamt[$i]="";
          }?>
          
          <td><?php echo $dummy.$punkte6gesamt[$i].$dumm2; ?></td><?php        }
      } // ende if($tipp_showzus==1)
      
      if($tipp_showstsiege==1){
        if($stsiege[$i]==""){
          $stsiege[$i]="";
        }?>
          
          <td><?php echo $dummy.$stsiege[$i].$dumm2; ?></td><?php      }
      
      $quotegesamt[$i] = number_format($quotegesamt[$i]/100, 2, ".", ",");
      echo "<td>";
      if ($gewicht == "relativ") {
        echo "<strong>";
      } else {
        echo $dummy;
      }
      echo $quotegesamt[$i];
      if ($gewicht == "relativ") {
        echo "</strong>";
      } else {
        echo $dumm2;
      }
      echo "</td>";
       
      echo "<td>";
      if ($gewicht == "absolut") {
        echo "<strong>";
      } else {
        echo $dummy;
      }
      echo $tipppunktegesamt[$i];
      if ($gewicht == "absolut") {
        echo "</strong>";
      } else {
        echo $dumm2;
      }
      echo "</td>";
      } /* ende if($wertung!="intern" || $teamintern==$tipperteam[$i])*/
    } /* ende   if($wertung=="team" || $tippernick[$i]!="")*/
  } /* ende   if(($x>=$start && $x<=$ende) || $i==$eigpos)*/
} /* ende for($x=1;$x<=$anztipper;$x++)*/?>
        </tr>
      </table>
    </td>
  </tr><?php if(isset($tipp_anzseiten) && $tipp_anzseiten>1){ ?> 
  <tr>
    <td>
      <table class="table" id="5">
        <tr><?php
  echo "<td>".$text['tipp'][205]."</td>";
  for($i = 0; $i < $tipp_anzseiten; $i++) {
    $von = ($i * $tipp_anzseite1)+1;
    $bis = ($i+1) * $tipp_anzseite1;
    if ($bis > $anztipper) {
      $bis = $anztipper;
    }
    if ($von != $start) {
      echo "<td><a href=\"".$addt3.$von."\">";
    } else {
      echo "<td>";
    }
    echo $von."-".$bis;
    if ($von != $start) {
      echo "</a>";
    }
    echo "</td>";
  }?>
        </tr>
      </table>
    </td>
  </tr><?php } // ende if($tipp_anzseiten>1) ?>
</table><?php
if($tabdat!=""){ ?>
   <div class="row"><?php
  $st0 = $endtab-1;
  if ($endtab > 1) {?>
      <div class="col-2 text-start"><a href="<?php echo $addr.$st0?>" title="<?php echo $text[43]?>"><?php echo $text[5]?> <?php echo $text[6]?></a></div><?php
  }
  $st0 = $endtab+1;
  if ($endtab < $anzst) {?>
      <div class="col-2 offset-10 text-end"><a href="<?php echo $addr.$st0?>" title="<?php echo $text[44]?>"><?php echo $text[8]?> <?php echo $text[7]?></a></div><?php
  }?>
  </div>
<?php }?>