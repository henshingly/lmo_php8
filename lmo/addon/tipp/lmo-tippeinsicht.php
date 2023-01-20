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
  
  

if ($file != "" && $todo == "einsicht" && $tipp_tippeinsicht == 1) {
  $tipp_showzus = 0;
  require_once(PATH_TO_ADDONDIR."/tipp/lmo-tippcalcpkt.php");
  require_once(PATH_TO_ADDONDIR."/tipp/lmo-tippaenderbar.php");
  if (!isset($st) || $st == "" || $st == 0) {
    $st = $stx;
  }
  require(PATH_TO_ADDONDIR."/tipp/lmo-tippcalceinsicht.php");
   
  if (!isset($tipp_anzseite)) {
    $tipp_anzseite = 20;
  }
  if (!isset($anztipper)) {
    $anztipper = 0;
  }
  if (!isset($von)) {
    $von = 0;
  }
  if (!isset($start)) {
    $start = 0;
  }
  if ($start >= $anztipper) {
    $start = 0;
  }
  if ($tipp_anzseite < 1) {
    $tipp_anzseite = 20;
  }?>

<div class="container">
  <?php if($tipp_einsichterst>=1){ ?>
  <div class="row">
    <div class="col"><?php echo $text['tipp'][220]." ".$text['tipp'][215+$tipp_einsichterst]; ?></div>
  </div><?php  }?>
  <div class="row">
    <div class="col"><?php 
  $addr = $_SERVER['PHP_SELF']."?action=tipp&amp;todo=einsicht&amp;file=".$file."&amp;start=".$start."&amp;st=";
  $addt = $_SERVER['PHP_SELF']."?action=tipp&amp;todo=tabelle&amp;file=".$file."&amp;endtab=&amp;nick=";
  $addt3 = $_SERVER['PHP_SELF']."?action=tipp&amp;todo=einsicht&amp;file=".$file."&amp;st=".$st."&amp;start=";
   include(PATH_TO_LMO."/lmo-spieltagsmenu.php");?>
        
    </div>
  </div><?php  $tipp_anzseiten=$anztipper/$tipp_anzseite;
  if($tipp_anzseiten>1){?> 
  <div class="row">
    <div class="col">
      <table class="table table-striped">
        <tr><?php 
    echo "<td align=\"right\" valign=\"top\" rowspan=\"".(floor($tipp_anzseiten/10)+1)."\">".$text['tipp'][164]."&nbsp;</td>";
    for($i = 0; $i < $tipp_anzseiten; $i++) {
      $von = $i * $tipp_anzseite;
      $bis = ($i+1) * $tipp_anzseite-1;
      if ($bis >= $anztipper) {
        $bis = $anztipper-1;
      }
      if ($von != $start) {
        echo "<td align='center'><a href=\"".$addt3.$von."\">";
      } else {
        echo "<td align='center'>";
      }
      $k1 = strtolower(substr($tippernick[intval(substr($tab0[$von], -6))], 0, 3));
      $k2 = strtolower(substr($tippernick[intval(substr($tab0[$bis], -6))], 0, 3));
      echo $k1."-".$k2;
      if ($von != $start) {
        echo "</a>";
      }
      echo "</td>";
      if (($i+1)%10 == 0) {
        echo "</tr><tr>";
      }
    }?>
        </tr>
      </table>
    </div>
  </div><?php  } /* ende if($tipp_anzseiten>1) */?>
  <div class="row">
    <div class="col">
      <table class="table table-hover" ><?php  $tab1 = array("");
  $nw = 0;
  $ende = $start+$tipp_anzseite;
  if ($ende > $anztipper) {
    $ende = $anztipper;
  }
  if (!isset($tab0)) {
    $tab0 = array("");
  }
  //if($anztipper<1){exit;}
  for($l = $start-1; $l <= ($ende+1); $l++) {
    if ($l >= $start && $l < $ende) {
      $k = intval(substr($tab0[$l], -6));
    }
    if ($lmtype == 0) {
      $anzmodus = 1;
    } else {
      $anzmodus = $modus[$st-1];
    }?>
        <tr>
          <th scope="col"><?php 
    if ($l >= $start && $l < $ende) {
      if ($tipp_showname == 1) {
        echo $tippername[$k];
      }
      if ($tipp_shownick == 1) {
        if ($tipp_showname == 1) {
          echo " (";
        }
        echo $tippernick[$k];
        if ($tipp_showname == 1) {
          echo ")";
        }
      }
    } /* Nickname links*/
    elseif($l == $ende && $anztipper > 0) {
      echo $text['tipp'][188];
    } /* Tipptendenz*/
    elseif($l == ($ende+1) && $anztipper > 0 && $tipp_tippmodus == 1) {
      echo "Ø-".$text['tipp'][30];
    } /* Durchschnittstipp */?>
          </th><?php 
    $punktetipper = 0;
    for($i = 0; $i < $anzsp; $i++) {
      if ($teama[$st-1][$i] > 0 && $teamb[$st-1][$i] > 0) {
        for($n = 0; $n < $anzmodus; $n++) {
          if ($l == $start) {
            if ($tipp_einsichterst == 1) {
              $plus = 0;
              if ($lmtype == 0) {
                $btip[$i] = tippaenderbar($mterm[$st-1][$i], $datum1[$st-1], $datum2[$st-1]);
              } else {
                $btip[$i][$n] = tippaenderbar($mterm[$st-1][$i][$n], $datum1[$st-1], $datum2[$st-1]);
              }
            } elseif($tipp_einsichterst == 2) {
              if ($lmtype != 0) {
                if ($goala[$st-1][$i][$n] != "_" && $goalb[$st-1][$i][$n] != "_") {
                  $btip[$i][$n] = false;
                } else {
                  $btip[$i][$n] = true;
                }
              } else {
                if ($goala[$st-1][$i] != "_" && $goalb[$st-1][$i] != "_") {
                  $btip[$i] = false;
                } else {
                  $btip[$i] = true;
                }
              }
            } else {
              // Tipps immer anzeigen
              if ($lmtype != 0) {
                $btip[$i][$n] = false;
              } else {
                $btip[$i] = false;
              }
            }
          }
          if ($l == ($start-1) || $l == ($ende+1)) {?>
          <th scope="col"><?php            if ($n == 0) {
              echo $teamk[$teama[$st-1][$i]];
            }
            echo "<br>";
            if ($lmtype != 0) {
              if ($mtipp[$st-1][$i][$n] == 1) {
                echo "<acronym title='".$text['tipp'][231]."'><del>";
              }
              echo applyFactor($goala[$st-1][$i][$n],$goalfaktor).":".applyFactor($goalb[$st-1][$i][$n],$goalfaktor);
              if ($mtipp[$st-1][$i][$n] == 1) {
                echo '</del></acronym>';
                $nw = 1;
              }
            } else {
              if ($mtipp[$st-1][$i] == 1) {
                echo "<acronym title='".$text['tipp'][231]."'><del>";
              }
              echo applyFactor($goala[$st-1][$i],$goalfaktor).":".applyFactor($goalb[$st-1][$i],$goalfaktor);
              if ($mtipp[$st-1][$i] == 1) {
                echo '</del></acronym>';
                $nw = 1;
              }
            }
            echo "<br>";
            if ($n == 0) {
              echo $teamk[$teamb[$st-1][$i]];
            }?>              
          </th><?php 
          } elseif($l<$ende) {
            if(($lmtype==0 && $btip[$i]==true) || ($lmtype!=0 && $btip[$i][$n]==true)){ ?>
          <td><?php 
            }else{
            if ($lmtype != 0) {
              if ($tippa[$k][$i][$n] == -1) {
                $tippa[$k][$i][$n] = "_";
              }
              if ($tippb[$k][$i][$n] == -1) {
                $tippb[$k][$i][$n] = "_";
              }
            } else {
              if ($tippa[$k][$i] == -1) {
                $tippa[$k][$i] = "_";
              }
              if ($tippb[$k][$i] == -1) {
                $tippb[$k][$i] = "_";
              }
            }
            $punktespiel = -1;
            if ($lmtype != 0) {
              if ($tippa[$k][$i][$n] != "_") {
                if ($tipp_jokertipp == 1 && $jksp2[$k] == ($i+1).($n+1)) {
                  $jkspfaktor = $tipp_jokertippmulti;
                } else {
                  $jkspfaktor = 1;
                }
                if ($goala[$st-1][$i][$n] != "_") {
                  $punktespiel = tipppunkte($tippa[$k][$i][$n], $tippb[$k][$i][$n], $goala[$st-1][$i][$n], $goalb[$st-1][$i][$n], 0, $mspez[$st-1][$i][$n], $text[0], $text[1], $jkspfaktor, $mtipp[$st-1][$i][$n]);
                }
              } else {
                $jkspfaktor = 1;
              }
            } else {
              if ($tippa[$k][$i] != "_") {
                if ($tipp_jokertipp == 1 && $jksp2[$k] == $i+1) {
                  $jkspfaktor = $tipp_jokertippmulti;
                } else {
                  $jkspfaktor = 1;
                }
                if ($goala[$st-1][$i] != "_") {
                  $punktespiel = tipppunkte($tippa[$k][$i], $tippb[$k][$i], $goala[$st-1][$i], $goalb[$st-1][$i], $msieg[$st-1][$i], $mspez[$st-1][$i], $text[0], $text[1], $jkspfaktor, $mtipp[$st-1][$i]);
                }
              } else {
                $jkspfaktor = 1;
              }
            }
            if ($tipp_tippmodus == 1) {
              // Ergebnis-Tippmodus
              if ($punktespiel > $tipp_rtor * $jkspfaktor) {?>
          <td><?php 
              } else{ ?>
          <td><?php 
              }
              $dummy1 = "";
              $dummy2 = "";
              $dummy3 = "";
              $dummy4 = "";
              if ($punktespiel == $tipp_rergebnis * $jkspfaktor || $punktespiel == ($tipp_rergebnis+$tipp_rremis) * $jkspfaktor) {
                $dummy1 = "<strong>";
                $dummy4 = "</strong>";
              } elseif($punktespiel == $tipp_rtendenzdiff * $jkspfaktor || $punktespiel == ($tipp_rtendenzdiff+$tipp_rremis) * $jkspfaktor) {
                $dummy2 = "<strong>";
                $dummy3 = "</strong>";
              }
              if ($jkspfaktor > 1) {
                echo "<em>";
              }
              if ($lmtype != 0) {
                if ($tipp_rtor > 0 && ($punktespiel == $tipp_rtor * $jkspfaktor || $punktespiel == ($tipp_rtendenz+$tipp_rtor) * $jkspfaktor)) {
                  if ($goala[$st-1][$i][$n] == $tippa[$k][$i][$n]) {
                    $dummy1 = "<strong>";
                    $dummy2 = "</strong>";
                  } elseif($goalb[$st-1][$i][$n] == $tippb[$k][$i][$n]) {
                    $dummy3 = "<strong>";
                    $dummy4 = "</strong>";
                  }
                }
                echo $dummy1.$tippa[$k][$i][$n].$dummy2.":".$dummy3.$tippb[$k][$i][$n].$dummy4;
              } else {
                if ($tipp_rtor > 0 && ($punktespiel == $tipp_rtor * $jkspfaktor || $punktespiel == ($tipp_rtendenz+$tipp_rtor) * $jkspfaktor)) {
                  if ($goala[$st-1][$i] == $tippa[$k][$i]) {
                    $dummy1 = "<strong>";
                    $dummy2 = "</strong>";
                  } elseif($goalb[$st-1][$i] == $tippb[$k][$i]) {
                    $dummy3 = "<strong>";
                    $dummy4 = "</strong>";
                  }
                }
                echo $dummy1.$tippa[$k][$i].$dummy2.":".$dummy3.$tippb[$k][$i].$dummy4;
              }
              if ($jkspfaktor > 1) {
                echo "</em>";
              }

              if ($punktespiel >= 0) {
                echo " <small>".$punktespiel."</small>";
              } else {
                echo "&nbsp;";
              }
              
            } else {
                // Tendenz-Modus
                if ($punktespiel > 0) {?>
          <td><?php 
                } else {?>
          <td><?php 
                }
                if ($jkspfaktor > 1) {
                  echo "<p>";
                }
                if ($lmtype != 0) {
                  if ($tippa[$k][$i][$n] == "_" || $tippb[$k][$i][$n] == "_") {
                    echo "_";
                  } elseif($tippa[$k][$i][$n] == $tippb[$k][$i][$n]) {
                    echo "0";
                  } elseif($tippa[$k][$i][$n] > $tippb[$k][$i][$n]) {
                    echo "1";
                  } elseif($tippa[$k][$i][$n] < $tippb[$k][$i][$n]) {
                    echo "2";
                  }
                } else {
                  if ($tippa[$k][$i] == "_" || $tippb[$k][$i] == "_") {
                    echo "_";
                  } elseif($tippa[$k][$i] == $tippb[$k][$i]) {
                    echo "0";
                  } elseif($tippa[$k][$i] > $tippb[$k][$i]) {
                    echo "1";
                  } elseif($tippa[$k][$i] < $tippb[$k][$i]) {
                    echo "2";
                  }
                }
                if ($jkspfaktor > 1) {
                  echo "</p>";
                }
              }
              if ($punktespiel > 0) {
                $punktetipper += $punktespiel;
              }
            }?>
          </td><?php 
          } elseif($l==$ende){?>
          <td><?php            if($anztipper>0){
              if($lmtype==0 && $btip[$i]==false){
                echo $tendenz1[$i]."-".$tendenz0[$i]."-".$tendenz2[$i];
              } elseif($lmtype!=0 && $btip[$i][$n]==false){
                echo $tendenz1[$i][$n]."-".$tendenz0[$i][$n]."-".$tendenz2[$i][$n];
              }
            }?>
          </td><?php 
          } elseif($l==($ende+1)){?>
          <td scope="col"><?php            if ($anztipper > 0 && $tipp_tippmodus == 1) {
              if ($lmtype == 0 && $btip[$i] == false) {
                if ($anzgetippt[$i] > 0) {
                  if ($toregesa[$i] < 10 && $toregesb[$i] < 10) {
                    $nachkomma = 1;
                  } else {
                    $nachkomma = 0;
                  }
                  echo number_format(($toregesa[$i]/$anzgetippt[$i]), $nachkomma, ".", ",").":".number_format(($toregesb[$i]/$anzgetippt[$i]), $nachkomma, ".", ",");
                }
              } elseif($lmtype != 0 && $btip[$i][$n] == false) {
                if ($anzgetippt[$i][$n] > 0) {
                  if ($toregesa[$i][$n] < 10 && $toregesb[$i][$n] < 10) {
                    $nachkomma = 1;
                  } else {
                    $nachkomma = 0;
                  }
                  echo number_format(($toregesa[$i][$n]/$anzgetippt[$i][$n]), $nachkomma, ".", ",").":".number_format(($toregesb[$i][$n]/$anzgetippt[$i][$n]), $nachkomma, ".", ",");
                }
              }
            }?>
          </td><?php 
          }
        } // ende for($n=0;$n<$anzmodus;$n++)
      }
    } /* ende for($i=0;$i<$anzsp;$i++) */
    
    if($l>=$start && $l<$ende){?>
          <td><?php echo $punktetipper?></td><?php 
    } elseif ($l==$start-1) {?>
          <th valign="bottom"><?php echo $text[37];?></th><?php 
    } elseif ($l==$ende+1) {?>
          <th valign="top"><?php echo $text[37];?></th><?php 
    } else {?>
          <td></td><?php 
    }?>
        </tr><?php 
  } /* ende for($l=$start-1;$l<=$ende;$l++) */?>
      </table>
    </div>
  </div><?php if($tipp_anzseiten>1 && $tipp_anzseiten<11){?> 
  <div class="row">
    <div clas="col">
      <table class="table table-hover">
        <tr><?php 
    echo "<td align=\"right\" valign=\"top\" rowspan=\"".(floor($tipp_anzseiten/10)+1)."\">".$text['tipp'][164]."&nbsp;</td>";
    for($i = 0; $i < $tipp_anzseiten; $i++) {
      $von = $i * $tipp_anzseite;
      $bis = ($i+1) * $tipp_anzseite-1;
      if ($bis >= $anztipper) {
        $bis = $anztipper-1;
      }
      if ($von != $start) {
        echo "<td class='nobr'><a href=\"".$addt3.$von."\">";
      } else {
        echo "<td class=\"nobr\">";
      }
      $k1 = strtolower(substr($tippernick[intval(substr($tab0[$von], -6))], 0, 3));
      $k2 = strtolower(substr($tippernick[intval(substr($tab0[$bis], -6))], 0, 3));
      echo $k1."-".$k2;
      if ($von != $start) {
        echo "</a>";
      }
      echo "&nbsp;</td>";
      if (($i+1)%10 == 0) {
        echo "</tr><tr>";
      }
    }?>
        </tr>
      </table>
    </div>
  </div>
<?php } /* ende if($tipp_anzseiten>1) */?>
</div>
<?php 
} /* ende if(($file!="") && ($todo=="einsicht"))*/?>