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
if (!defined('PATH_TO_LMO')) {
    exit;  // kein Direktaufruf: diese Datei wird nur ueber LMO eingebunden
}

/**
 * Diese Datei wird eingebunden und erwartet:
 *
 * @var \Lmo\Liga\LigaDaten $ligaDaten Daten der geladenen Liga (lmo-ligadaten.php)
 * @var \Lmo\Liga\Rohdaten\Liga $lmo_liga Rohdaten der geladenen Liga (lmo-openfile.php)
 * @var array<int|string, mixed> $text Sprachtexte
 * @var string $file Ligadatei relativ zum Ligenordner, leer wenn keine geladen ist
 * @var string $todo gewaehlte Aktion (Aufrufparameter)
 *
 * Einstellungen:
 * @var int|string $tipp_einsichterst Einstellung aus tipp/cfg.txt
 * @var int|string $tipp_jokertipp Einstellung aus tipp/cfg.txt
 * @var int|string $tipp_jokertippmulti Einstellung aus tipp/cfg.txt
 * @var int|string $tipp_rergebnis Einstellung aus tipp/cfg.txt
 * @var int|string $tipp_rremis Einstellung aus tipp/cfg.txt
 * @var int|string $tipp_rtendenz Einstellung aus tipp/cfg.txt
 * @var int|string $tipp_rtendenzdiff Einstellung aus tipp/cfg.txt
 * @var int|string $tipp_rtor Einstellung aus tipp/cfg.txt
 * @var int|string $tipp_showname Einstellung aus tipp/cfg.txt
 * @var int|string $tipp_shownick Einstellung aus tipp/cfg.txt
 * @var int|string $tipp_tippeinsicht Einstellung aus tipp/cfg.txt
 * @var int|string $tipp_tippmodus Einstellung aus tipp/cfg.txt
 * @var int|string $tipp_tipptabelle1 Einstellung aus tipp/cfg.txt
 *
 * Weitere Variablen des einbindenden Codes:
 * @var array<int|string, mixed> $anzgetippt
 * @var array<int|string, mixed> $jksp2
 * @var array<int|string, mixed> $tendenz0
 * @var array<int|string, mixed> $tendenz1
 * @var array<int|string, mixed> $tendenz2
 * @var array<int|string, mixed> $tippername
 * @var array<int|string, mixed> $tippernick
 * @var array<int|string, mixed> $toregesa
 * @var array<int|string, mixed> $toregesb
 *
 * Werden auch in dieser Datei gesetzt, aber nicht auf jedem Weg (koennen von aussen kommen):
 * @var array<int|string, mixed> $btip
 * @var mixed $k
 * @var array<int|string, mixed>|null $tab0
 * @var array<int|string, mixed> $tippa
 * @var array<int|string, mixed> $tippb
 */
  
  

if ($file != "" && $todo == "einsicht" && $tipp_tippeinsicht == 1) {
  $tipp_showzus = 0;
  require_once(PATH_TO_ADDONDIR."/tipp/lmo-tippcalcpkt.php");
  require_once(PATH_TO_ADDONDIR."/tipp/lmo-tippaenderbar.php");
  if (!isset($st) || $st == "" || $st == 0) {
    $st = $lmo_liga->einstellungen()->aktuellerSpieltag();
  }
  require(PATH_TO_ADDONDIR."/tipp/lmo-tippcalceinsicht.php");

  // Einstellungen der Liga und der Spieltag aus Sicht des Tippspiels (Lmo\Tipp\Tipprunde):
  // die Paarungen zum Anzeigen (Lmo\Liga\Paarung) unter demselben Index $i wie die Tipps
  $lmo_einstellungen = $lmo_liga->einstellungen();
  $lmo_tipprunde = \Lmo\Tipp\Tipprunde::fuer($lmo_liga, (int)$st);
  $lmo_tipp_pokal = $lmo_tipprunde->pokal;
  $lmo_tipp_runden = $lmo_tipprunde->runden;
  $lmo_tipp_datum1 = $lmo_tipprunde->ersterTag;
  $lmo_tipp_datum2 = $lmo_tipprunde->letzterTag;
  $lmo_tipp_modus = $lmo_tipprunde->spieleJePaarung;
  $lmo_tipp_anzsp = $lmo_tipprunde->plaetze;
  $lmo_tipp_paarungen = $lmo_tipprunde->paarungen;
   
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

<table class="lmoInner" cellspacing="0" cellpadding="0" border="0">
  <caption><?php if ($_SESSION["lmotipperok"]==5){echo $_SESSION['lmotippername'];if ($_SESSION['lmotipperverein']!=""){echo " - ".$_SESSION['lmotipperverein'];}} else {echo $text['tipp'][158];} ?></caption><?php if ($tipp_einsichterst>=1){ ?>
  <tr>
    <td class="lmoFrontMarkierung"><?php echo $text['tipp'][220]." ".$text['tipp'][215+$tipp_einsichterst]; ?></td>
  </tr><?php  }?>
  <tr>
    <td align="center"><?php 
  $addr = $_SERVER['PHP_SELF']."?action=tipp&amp;todo=einsicht&amp;file=".$file."&amp;start=".$start."&amp;st=";
  $addt = $_SERVER['PHP_SELF']."?action=tipp&amp;todo=tabelle&amp;file=".$file."&amp;endtab=&amp;nick=";
  $addt3 = $_SERVER['PHP_SELF']."?action=tipp&amp;todo=einsicht&amp;file=".$file."&amp;st=".$st."&amp;start=";
   include(PATH_TO_LMO."/lmo-spieltagsmenu.php");?>
        
    </td>
  </tr><?php  $tipp_anzseiten=$anztipper/$tipp_anzseite;
  if ($tipp_anzseiten>1){?> 
  <tr>
    <td align="center">
      <table class="lmoSubmenu" cellspacing="0" cellpadding="0" border="0">
        <tr><?php 
    echo "<td align=\"right\" valign=\"top\" rowspan=\"".(floor($tipp_anzseiten/10)+1)."\">".$text['tipp'][164]."&nbsp;</td>";
    for ($i = 0; $i < $tipp_anzseiten; $i++) {
      $von = $i * $tipp_anzseite;
      $bis = ($i+1) * $tipp_anzseite-1;
      if ($bis >= $anztipper) {
        $bis = $anztipper-1;
      }
      if ($von != $start) {
        echo "<td class='nobr' align='center'><a href=\"".$addt3.$von."\">";
      } else {
        echo "<td align='center' class=\"nobr\">";
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
    </td>
  </tr><?php  } /* ende if ($tipp_anzseiten>1) */?>
  <tr>
    <td class="lmoKreuz" align="center">
      <table class="lmoInner" cellspacing="0" cellpadding="0" border="0"><?php  $tab1 = array("");
  $nw = 0;
  $ende = $start+$tipp_anzseite;
  if ($ende > $anztipper) {
    $ende = $anztipper;
  }
  if (!isset($tab0)) {
    $tab0 = array("");
  }
  //if ($anztipper<1){exit;}
  for ($l = $start-1; $l <= ($ende+2); $l++) {
    if ($l >= $start && $l < $ende) {
      $k = intval(substr($tab0[$l], -6));
    }
    if (!$lmo_tipp_pokal) {
      $anzmodus = 1;
    } else {
      $anzmodus = $lmo_tipp_modus;
    }?>
        <tr>
          <th align="right" class="nobr"><?php 
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
    elseif ($l == $ende && $anztipper > 0) {
      echo $text['tipp'][188];
    } /* Tipptendenz*/
    elseif ($l == ($ende+1) && $anztipper > 0 && $tipp_tippmodus == 1) {
      echo "Ø-".$text['tipp'][30];
    } /* Durchschnittstipp */?>
          </th><?php 
    $punktetipper = 0;
    for ($i = 0; $i < $lmo_tipp_anzsp; $i++) {
      if ($lmo_tipp_paarungen[$i]->heim > 0 && $lmo_tipp_paarungen[$i]->gast > 0) {
        for ($n = 0; $n < $anzmodus; $n++) {
          if ($l == $start) {
            if ($tipp_einsichterst == 1) {
              $plus = 0;
              if (!$lmo_tipp_pokal) {
                $btip[$i] = tippaenderbar((int)$lmo_tipp_paarungen[$i]->spiele[0]->anstoss, $lmo_tipp_datum1, $lmo_tipp_datum2);
              } else {
                $btip[$i][$n] = tippaenderbar((int)$lmo_tipp_paarungen[$i]->spiele[$n]->anstoss, $lmo_tipp_datum1, $lmo_tipp_datum2);
              }
            } elseif ($tipp_einsichterst == 2) {
              if ($lmo_tipp_pokal) {
                if ($lmo_tipp_paarungen[$i]->spiele[$n]->toreHeim !== null && $lmo_tipp_paarungen[$i]->spiele[$n]->toreGast !== null) {
                  $btip[$i][$n] = false;
                } else {
                  $btip[$i][$n] = true;
                }
              } else {
                if ($lmo_tipp_paarungen[$i]->spiele[0]->toreHeim !== null && $lmo_tipp_paarungen[$i]->spiele[0]->toreGast !== null) {
                  $btip[$i] = false;
                } else {
                  $btip[$i] = true;
                }
              }
            } else {
              // Tipps immer anzeigen
              if ($lmo_tipp_pokal) {
                $btip[$i][$n] = false;
              } else {
                $btip[$i] = false;
              }
            }
          }
          if ($l == ($start-1) || $l == ($ende+2)) {?>
          <th align="center" valign="center" class="nobr"><?php            if ($n == 0) {
              echo $lmo_tipp_paarungen[$i]->heimMannschaft()->kurzname()."<br>";
            }
            if ($lmo_tipp_pokal) {
              if ((int)$lmo_tipp_paarungen[$i]->spiele[$n]->ohneTippwertung == 1) {
                echo "<acronym title='".$text['tipp'][231]."'><del>";
              }
              echo $lmo_tipp_paarungen[$i]->spiele[$n]->toreHeimText($lmo_einstellungen->torfaktor()).":".$lmo_tipp_paarungen[$i]->spiele[$n]->toreGastText($lmo_einstellungen->torfaktor());
              if ((int)$lmo_tipp_paarungen[$i]->spiele[$n]->ohneTippwertung == 1) {
                echo '</del></acronym>';
                $nw = 1;
              }
            } else {
              if ((int)$lmo_tipp_paarungen[$i]->spiele[0]->ohneTippwertung == 1) {
                echo "<acronym title='".$text['tipp'][231]."'><del>";
              }
              echo $lmo_tipp_paarungen[$i]->spiele[0]->toreHeimText($lmo_einstellungen->torfaktor()).":".$lmo_tipp_paarungen[$i]->spiele[0]->toreGastText($lmo_einstellungen->torfaktor());
              if ((int)$lmo_tipp_paarungen[$i]->spiele[0]->ohneTippwertung == 1) {
                echo '</del></acronym>';
                $nw = 1;
              }
            }
            if ($n == 0) {
              echo "<br>".$lmo_tipp_paarungen[$i]->gastMannschaft()->kurzname();
            }?>              
          </th><?php 
          } elseif ($l<$ende) {
            if ((!$lmo_tipp_pokal && $btip[$i]==true) || ($lmo_tipp_pokal && $btip[$i][$n]==true)){ ?>
          <td align="center" class="nobr"><?php 
            } else {
            if ($lmo_tipp_pokal) {
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
            if ($lmo_tipp_pokal) {
              if ($tippa[$k][$i][$n] != "_") {
                if ($tipp_jokertipp == 1 && $jksp2[$k] == ($i+1).($n+1)) {
                  $jkspfaktor = $tipp_jokertippmulti;
                } else {
                  $jkspfaktor = 1;
                }
                if ($lmo_tipp_paarungen[$i]->spiele[$n]->toreHeim !== null) {
                  $punktespiel = tipppunkte($tippa[$k][$i][$n], $tippb[$k][$i][$n], $lmo_tipp_paarungen[$i]->spiele[$n]->toreHeimText(), $lmo_tipp_paarungen[$i]->spiele[$n]->toreGastText(), 0, $lmo_tipp_paarungen[$i]->spiele[$n]->zusatzText($text[0], $text[1]), $text[0], $text[1], $jkspfaktor, (int)$lmo_tipp_paarungen[$i]->spiele[$n]->ohneTippwertung);
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
                if ($lmo_tipp_paarungen[$i]->spiele[0]->toreHeim !== null) {
                  $punktespiel = tipppunkte($tippa[$k][$i], $tippb[$k][$i], $lmo_tipp_paarungen[$i]->spiele[0]->toreHeimText(), $lmo_tipp_paarungen[$i]->spiele[0]->toreGastText(), $lmo_tipp_paarungen[$i]->spiele[0]->wertung, $lmo_tipp_paarungen[$i]->spiele[0]->zusatzText($text[0], $text[1]), $text[0], $text[1], $jkspfaktor, (int)$lmo_tipp_paarungen[$i]->spiele[0]->ohneTippwertung);
                }
              } else {
                $jkspfaktor = 1;
              }
            }
            if ($tipp_tippmodus == 1) {
              // Ergebnis-Tippmodus
              if ($punktespiel > $tipp_rtor * $jkspfaktor) {?>
          <td align="center" class="lmoBackMarkierung nobr"><?php 
              } else { ?>
          <td align="center" class="nobr"><?php 
              }
              $dummy1 = "";
              $dummy2 = "";
              $dummy3 = "";
              $dummy4 = "";
              if ($punktespiel == $tipp_rergebnis * $jkspfaktor || $punktespiel == ($tipp_rergebnis+$tipp_rremis) * $jkspfaktor) {
                $dummy1 = "<strong>";
                $dummy4 = "</strong>";
              } elseif ($punktespiel == $tipp_rtendenzdiff * $jkspfaktor || $punktespiel == ($tipp_rtendenzdiff+$tipp_rremis) * $jkspfaktor) {
                $dummy2 = "<strong>";
                $dummy3 = "</strong>";
              }
              if ($jkspfaktor > 1) {
                echo "<em class='lmoFrontMarkierung'>";
              }
              if ($lmo_tipp_pokal) {
                if ($tipp_rtor > 0 && ($punktespiel == $tipp_rtor * $jkspfaktor || $punktespiel == ($tipp_rtendenz+$tipp_rtor) * $jkspfaktor)) {
                  if ($lmo_tipp_paarungen[$i]->spiele[$n]->toreHeimText() == $tippa[$k][$i][$n]) {
                    $dummy1 = "<strong>";
                    $dummy2 = "</strong>";
                  } elseif ($lmo_tipp_paarungen[$i]->spiele[$n]->toreGastText() == $tippb[$k][$i][$n]) {
                    $dummy3 = "<strong>";
                    $dummy4 = "</strong>";
                  }
                }
                echo $dummy1.$tippa[$k][$i][$n].$dummy2.":".$dummy3.$tippb[$k][$i][$n].$dummy4;
              } else {
                if ($tipp_rtor > 0 && ($punktespiel == $tipp_rtor * $jkspfaktor || $punktespiel == ($tipp_rtendenz+$tipp_rtor) * $jkspfaktor)) {
                  if ($lmo_tipp_paarungen[$i]->spiele[0]->toreHeimText() == $tippa[$k][$i]) {
                    $dummy1 = "<strong>";
                    $dummy2 = "</strong>";
                  } elseif ($lmo_tipp_paarungen[$i]->spiele[0]->toreGastText() == $tippb[$k][$i]) {
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
          <td align="center" class="lmoBackMarkierung nobr"><?php 
                } else {?>
          <td align="center" class="nobr"><?php 
                }
                if ($jkspfaktor > 1) {
                  echo "<p class='lmoFrontMarkierung'>";
                }
                if ($lmo_tipp_pokal) {
                  if ($tippa[$k][$i][$n] == "_" || $tippb[$k][$i][$n] == "_") {
                    echo "_";
                  } elseif ($tippa[$k][$i][$n] == $tippb[$k][$i][$n]) {
                    echo "0";
                  } elseif ($tippa[$k][$i][$n] > $tippb[$k][$i][$n]) {
                    echo "1";
                  } elseif ($tippa[$k][$i][$n] < $tippb[$k][$i][$n]) {
                    echo "2";
                  }
                } else {
                  if ($tippa[$k][$i] == "_" || $tippb[$k][$i] == "_") {
                    echo "_";
                  } elseif ($tippa[$k][$i] == $tippb[$k][$i]) {
                    echo "0";
                  } elseif ($tippa[$k][$i] > $tippb[$k][$i]) {
                    echo "1";
                  } elseif ($tippa[$k][$i] < $tippb[$k][$i]) {
                    echo "2";
                  }
                }
                if ($jkspfaktor > 1) {
                  echo "";
                }
              }
              if ($punktespiel > 0) {
                $punktetipper += $punktespiel;
              }
            }?>
          </td><?php 
          } elseif ($l==$ende){?>
          <td align="center" class="lmoLeer nobr"><?php            if ($anztipper>0){
              if (!$lmo_tipp_pokal && $btip[$i]==false){
                echo $tendenz1[$i]."-".$tendenz0[$i]."-".$tendenz2[$i];
              } elseif ($lmo_tipp_pokal && $btip[$i][$n]==false){
                echo $tendenz1[$i][$n]."-".$tendenz0[$i][$n]."-".$tendenz2[$i][$n];
              }
            }?>
          </td><?php 
          } elseif ($l==($ende+1)){?>
          <td align="center" class="lmoLeer nobr"><strong><?php            if ($anztipper > 0 && $tipp_tippmodus == 1) {
              if (!$lmo_tipp_pokal && $btip[$i] == false) {
                if ($anzgetippt[$i] > 0) {
                  if ($toregesa[$i] < 10 && $toregesb[$i] < 10) {
                    $nachkomma = 1;
                  } else {
                    $nachkomma = 0;
                  }
                  echo number_format(($toregesa[$i]/$anzgetippt[$i]), $nachkomma, ".", ",").":".number_format(($toregesb[$i]/$anzgetippt[$i]), $nachkomma, ".", ",");
                }
              } elseif ($lmo_tipp_pokal && $btip[$i][$n] == false) {
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
          </strong></td><?php 
          }
        } // ende for ($n=0;$n<$anzmodus;$n++)
      }
    } /* ende for ($i=0;$i<$anzsp;$i++) */
    
    if ($l>=$start && $l<$ende){?>
          <td class="lmoFrontMarkierung" align="right"><?php echo $punktetipper?></td>
          <td class="nobr" align="left">&nbsp; <?php      if ($tipp_tipptabelle1==1 && $l>=$start && $l<$ende && !$lmo_tipp_pokal){?>
            <a href="<?php echo $addt.rawurlencode($tippernick[$k])?>" title="<?php echo $text['tipp'][181]." ".$tippernick[$k]?>"><img src="<?php echo URL_TO_IMGDIR?>/tabelle.gif" border="0" width="10" height="12" alt="<?php echo $text['tipp'][172]?>"></a><?php 
      }?>
          </td><?php 
    } elseif ($l==$start-1) {?>
          <th valign="bottom"><?php echo $text[37];?></th>
          <th>&nbsp;</th><?php 
    } elseif ($l==$ende+2) {?>
          <th valign="top"><?php echo $text[37];?></th>
          <th>&nbsp;</th><?php 
    } else {?>
          <td class="lmoLeer" colspan="2">&nbsp;</td><?php 
    }?>
        </tr><?php 
  } /* ende for ($l=$start-1;$l<=$ende;$l++) */?>
      </table>
    </td>
  </tr><?php if ($tipp_anzseiten>1 && $tipp_anzseiten<11){?> 
  <tr>
    <td align="center">
      <table class="lmoSubmenu" cellspacing="0" cellpadding="0" border="0">
        <tr><?php 
    echo "<td align=\"right\" valign=\"top\" rowspan=\"".(floor($tipp_anzseiten/10)+1)."\">".$text['tipp'][164]."&nbsp;</td>";
    for ($i = 0; $i < $tipp_anzseiten; $i++) {
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
    </td>
  </tr>
<?php } /* ende if ($tipp_anzseiten>1) */?>
</table>
<?php 
} /* ende if (($file!="") && ($todo=="einsicht"))*/?>