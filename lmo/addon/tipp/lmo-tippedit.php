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
 * @var int|string $st gewaehlter Spieltag
 * @var array<int|string, mixed> $array leeres Array als Vorlage fuer array_pad()
 *
 * Einstellungen:
 * @var int|string $tipp_akteinsicht Einstellung aus tipp/cfg.txt
 * @var int|string $tipp_imvorraus Einstellung aus tipp/cfg.txt
 * @var int|string $tipp_jokertipp Einstellung aus tipp/cfg.txt
 * @var int|string $tipp_pfeiltipp Einstellung aus tipp/cfg.txt
 * @var int|string $tipp_showdurchschntipp Einstellung aus tipp/cfg.txt
 * @var int|string $tipp_showtendenzabs Einstellung aus tipp/cfg.txt
 * @var int|string $tipp_showtendenzpro Einstellung aus tipp/cfg.txt
 * @var int|string $tipp_tippBis Einstellung aus tipp/cfg.txt
 * @var int|string $tipp_tippmodus Einstellung aus tipp/cfg.txt
 *
 * Weitere Variablen des einbindenden Codes:
 * @var array<int|string, mixed> $me
 *
 * Werden auch in dieser Datei gesetzt, aber nicht auf jedem Weg (koennen von aussen kommen):
 * @var mixed $j
 * @var mixed $jksp
 */


//require_once(PATH_TO_ADDONDIR."/tipp/lmo-tipptest.php");
if ($file!="") {
    $tipp_showzus=0;
    require_once(PATH_TO_ADDONDIR."/tipp/lmo-tippcalcpkt.php");
    require_once(PATH_TO_ADDONDIR."/tipp/lmo-tippaenderbar.php");
    if (!isset($ligaDaten->nlines)) {
        $ligaDaten->nlines=array();
    }

    require(PATH_TO_ADDONDIR."/tipp/lmo-tippopenfile.php");

    // Einstellungen, Spieltag und Paarungen aus den Rohdaten der Liga (Lmo\Liga\Rohdaten\Liga)
    $lmo_einstellungen = $lmo_liga->einstellungen();
    $lmo_tipp_pokal = $lmo_einstellungen->istPokal();
    $lmo_tipp_runden = $lmo_einstellungen->spieltage();
    $lmo_tipp_spieltag = $lmo_liga->spieltage[(int)$st] ?? new \Lmo\Liga\Rohdaten\Spieltag();
    $lmo_tipp_datum1 = $lmo_tipp_spieltag->ersterTagText();
    $lmo_tipp_datum2 = $lmo_tipp_spieltag->letzterTagText();
    // Spiele je Paarung: in der Liga eines, im Pokal nach dem Modus der Runde
    $lmo_tipp_modus = \Lmo\Liga\Paarung::spieleJePaarung($lmo_liga, (int)$st);
    // Paarungen dieser Runde, gezaehlt wie bisher im Tippspiel: in der Liga die Partien je Spieltag,
    // im Pokal die Zahl der Mannschaften je Runde halbiert, im Finale mit Spiel um Platz 3 eine mehr
    $lmo_tipp_anzsp = $lmo_einstellungen->partienJeSpieltag();
    if ($lmo_tipp_pokal) {
        $lmo_tipp_anzsp = $lmo_einstellungen->mannschaften();
        for ($i=0; $i<$st; $i++) {
            $lmo_tipp_anzsp = $lmo_tipp_anzsp/2;
        }
        if ($lmo_einstellungen->mitSpielUmPlatz3() && ($st==$lmo_tipp_runden)) {
            $lmo_tipp_anzsp = $lmo_tipp_anzsp+1;
        }
    }
    // die Paarungen zum Anzeigen (Lmo\Liga\Paarung) unter demselben Index $i wie die Tipps
    $lmo_tipp_paarungen = array();
    for ($i=0; $i<$lmo_tipp_anzsp; $i++) {
        $lmo_tipp_paarungen[$i] = \Lmo\Liga\Paarung::ausRohdaten($lmo_liga, (int)$st, $i+1, $lmo_tipp_modus);
    }

    if (!isset($_POST['save'])) {
        $save=0;
    } else {
        $save=1;
    }
    if ($save==1) {
        if ($tipp_jokertipp==1) {
        $jksp=isset($_POST["xjokerspiel"])?trim($_POST["xjokerspiel"]):"";
        }
        for ($i=0; $i<$lmo_tipp_anzsp; $i++) {
            if (!$lmo_tipp_pokal) {
                $plus=0;
                $btip=tippaenderbar((int)$lmo_tipp_paarungen[$i]->spiele[0]->anstoss,$lmo_tipp_datum1,$lmo_tipp_datum2);
                if ($btip==true) {
                    if ($tipp_tippmodus==1) {
                        $goaltippa[$i]=trim($_POST["xtippa".$i]);
                        $goaltippb[$i]=trim($_POST["xtippb".$i]);

                        if ($goaltippa[$i]=="" || $goaltippa[$i]<0 || $goaltippa[$i]=="_") {
                            $goaltippa[$i]=-1;
                            $goaltippb[$i]=-1;
                        } else {
                            $goaltippa[$i]=intval(trim($goaltippa[$i]));
                            if ($goaltippa[$i]=="") {
                                $goaltippa[$i]="0";
                            }
                        }

                        if ($goaltippb[$i]=="" || $goaltippb[$i]<0 || $goaltippb[$i]=="_") {
                            $goaltippa[$i]=-1;
                            $goaltippb[$i]=-1;
                        } else {
                            $goaltippb[$i]=intval(trim($goaltippb[$i]));
                            if ($goaltippb[$i]=="") {
                                $goaltippb[$i]="0";
                            }
                        }
                    } elseif ($tipp_tippmodus==0) {
                        if (!isset($_POST["xtipp".$i])) {
                            $_POST["xtipp".$i]=0;
                        }
                        if ($_POST["xtipp".$i]==1) {
                            $goaltippa[$i]="1";
                            $goaltippb[$i]="0";
                        } elseif ($_POST["xtipp".$i]==2) {
                            $goaltippa[$i]="0";
                            $goaltippb[$i]="1";
                        } elseif ($_POST["xtipp".$i]==3) {
                            $goaltippa[$i]="0";
                            $goaltippb[$i]="0";
                        } else {
                            $goaltippa[$i]="-1";
                            $goaltippb[$i]="-1";
                        }
                    }
                }
            } else {
                for ($n=0; $n<$lmo_tipp_modus; $n++) {
                    $plus=0;
                    $btip=tippaenderbar((int)$lmo_tipp_paarungen[$i]->spiele[$n]->anstoss,$lmo_tipp_datum1,$lmo_tipp_datum2);
                    if ($btip==true) {
                        if ($tipp_tippmodus==1) {
                            $goaltippa[$i][$n]=trim($_POST["xtippa".$i.$n]);
                            $goaltippb[$i][$n]=trim($_POST["xtippb".$i.$n]);

                            if ($goaltippa[$i][$n]=="" || $goaltippa[$i][$n]<0 || $goaltippa[$i][$n]=="_") {
                                $goaltippa[$i][$n]=-1;
                                $goaltippb[$i][$n]=-1;
                            } else {
                                $goaltippa[$i][$n]=intval(trim($goaltippa[$i][$n]));
                                if ($goaltippa[$i][$n]=="") {
                                    $goaltippa[$i][$n]="0";
                                }
                            }
                            if ($goaltippb[$i][$n]=="" || $goaltippb[$i][$n]<0 || $goaltippb[$i][$n]=="_") {
                                $goaltippa[$i][$n]=-1;
                                $goaltippb[$i][$n]=-1;
                            } else {
                                $goaltippb[$i][$n]=intval(trim($goaltippb[$i][$n]));
                                if ($goaltippb[$i][$n]=="") {
                                    $goaltippb[$i][$n]="0";
                                }
                            }
                        } elseif ($tipp_tippmodus==0) {
                            if (!isset($_POST["xtipp".$i.$n])) {
                                $_POST["xtipp".$i.$n]=0;
                            }
                            if ($_POST["xtipp".$i.$n]==1) {
                                $goaltippa[$i][$n]="1";
                                $goaltippb[$i][$n]="0";
                            } elseif ($_POST["xtipp".$i.$n]==2) {
                                $goaltippa[$i][$n]="0";
                                $goaltippb[$i][$n]="1";
                            } elseif ($_POST["xtipp".$i.$n]==3) {
                                $goaltippa[$i][$n]="0";
                                $goaltippb[$i][$n]="0";
                            } else {
                                $goaltippa[$i][$n]="-1";
                                $goaltippb[$i][$n]="-1";
                            }
                        }
                    }
                }
            }
        }
        if ($tipp_jokertipp==1) {
            require(PATH_TO_ADDONDIR."/tipp/lmo-tippjokeranticheat.php");
        }
        require(PATH_TO_ADDONDIR."/tipp/lmo-tippsavefile.php");
        if ($tipp_akteinsicht==1) {
            require(PATH_TO_ADDONDIR."/tipp/lmo-tippsaveeinsicht1.php");
        }
    }
    $addr=$_SERVER['PHP_SELF']."?action=tipp&amp;todo=edit&amp;file=".$file."&amp;st=";
    $addb=$_SERVER['PHP_SELF']."?action=tipp&amp;todo=tabs&amp;file=".$file."&amp;st=";
    $breite=17;
    if ($lmo_einstellungen->mitVerlaengerung()) {
        $breite+=2;
    }
    if ($tipp_showtendenzabs==1) {
        $breite+=2;
    }
    if ($tipp_showtendenzpro==1) {
        $breite+=2;
    }
    if ($tipp_showdurchschntipp==1) {
        $breite+=2;
    }
    if ($lmo_einstellungen->mitAnstosszeit()) {
        $breite++;
    }
    //  if ($lmtype==1 && $modus[$st-1]!=2){$hidr=1;} // bei KO-Turnier außer bei Hin- und Rückspiel keinen Remistipp zulassen
    if ($lmo_einstellungen->ohneUnentschieden()) {
        $breite--;
    }
    if ($tipp_tippmodus==0) {
        $breite-=2;
    }
    $savebutton=0;
    if ($tipp_showtendenzabs==1 || $tipp_showtendenzpro==1 || ($tipp_showdurchschntipp==1 && $tipp_tippmodus==1)) {
        require_once(PATH_TO_ADDONDIR."/tipp/lmo-tippcalceinsicht.php");
    }
?>
<table class="lmoInner" cellspacing="0" cellpadding="0" border="0">
  <caption><?php echo $_SESSION['lmotippername'];if ($_SESSION['lmotipperverein']!=""){echo " - ".$_SESSION['lmotipperverein'];} ?></caption>
  <tr>
    <td align="center"><?php include(PATH_TO_LMO."/lmo-spieltagsmenu.php");?></td>
  </tr>
  <tr>
    <td align="center">
      <form name="lmoedit" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <input type="hidden" name="action" value="tipp">
        <input type="hidden" name="todo" value="edit">
        <input type="hidden" name="save" value="1">
        <input type="hidden" name="file" value="<?php echo $file; ?>">
        <input type="hidden" name="st" value="<?php echo $st; ?>">
        <table class="lmoInner" cellspacing="0" cellpadding="0" border="0">
          <tr><?php
    if ($lmo_tipp_datum1!="") {
        $datum = explode('.',$lmo_tipp_datum1);
        $dum1=$me[intval($datum[1])]." ".$datum[2];
    } else {
        $dum1="";
    }
    if ($lmo_tipp_datum2!="") {
        $datum = explode('.',$lmo_tipp_datum2);
        $dum2=$me[intval($datum[1])]." ".$datum[2];
    } else {
        $dum2="";
    }
    if ($lmo_tipp_pokal) {
        if ($st==$lmo_tipp_runden) {
            $j=$text[374];
        } elseif ($st==$lmo_tipp_runden-1) {
            $j=$text[373];
        } elseif ($st==$lmo_tipp_runden-2) {
            $j=$text[372];
        } elseif ($st==$lmo_tipp_runden-3) {
            $j=$text[371];
        } else {
            $j=$st.". ".$text[370];
        }
    }?>
            <th class="nobr" align="left" colspan="<?php echo (int)$lmo_einstellungen->mitAnstosszeit()+5; ?>"><?php
    if (!$lmo_tipp_pokal) {
        echo $st.". ".$text[2];
    } else {
        echo $j;
    }
    if ($lmo_einstellungen->mitSpieltagsdatum()) {
        if ($lmo_tipp_datum1!="") {
            echo " ".$text[3]." ".$lmo_tipp_datum1;
        }
        if ($lmo_tipp_datum2!="") {
            echo " ".$text[4]." ".$lmo_tipp_datum2;
        }
    }?>
            </th><?php
    if ($tipp_showtendenzabs==1 || $tipp_showtendenzpro==1){ ?>
            <th class="nobr" align="center" colspan="<?php if ($tipp_showtendenzabs==1 && $tipp_showtendenzpro==1){echo "4";} else {echo "2";} ?>">
<?php
        echo $text['tipp'][188]; /* Tipptendenz absolut */?>
            </th>
<?php
    }
    //ERGEBNISMODUS
    if ($tipp_tippmodus==1){
        if ($tipp_showdurchschntipp==1){ ?>
            <th class="nobr" align="center" colspan="2">
            <?php echo "Ø-".$text['tipp'][30]; /* DurchschnittsTipp*/ ?>
            </th><?php
        } ?>
            <th class="nobr" align="center" colspan="<?php if ($tipp_pfeiltipp==1){echo "5";} else {echo "3";} ?>">
              <acronym title="<?php echo $text['tipp'][241].":".$text['tipp'][242] ?>"><?php echo $text['tipp'][209]; /* Dein Tipp */?></acronym><br><?php
        if ($lmo_einstellungen->torfaktor() > 0 && $lmo_einstellungen->torfaktor() != 1) {
            echo "(".$text[553+log10($lmo_einstellungen->torfaktor())].")";
        }?>
            </th><?php
    }

    //TENDENZMODUS
    if ($tipp_tippmodus==0){ ?>
            <th class="nobr" align="center"><acronym title="<?php echo $text['tipp'][95] ?>">1</acronym></th><?php
        if (!$lmo_einstellungen->ohneUnentschieden()){ ?>
            <th class="nobr" align="center"><acronym title="<?php echo $text['tipp'][96] ?>">0</acronym></th><?php
        }?>
            <th class="nobr" align="center"><acronym title="<?php echo $text['tipp'][97] ?>">2</acronym></th><?php
    }
    //BEIDE
    if ($tipp_jokertipp==1){ ?>
            <th class="nobr" align="center"><acronym title="<?php echo $text['tipp'][290] ?>"><?php echo $text['tipp'][289]; ?></acronym></th><?php
    } ?>
            <th class="nobr" colspan="3" align="center"><?php echo $text['tipp'][31]; /* Ergebnis */?></th><?php
    if ($lmo_einstellungen->mitVerlaengerung()){?>
            <th colspan="2">&nbsp;</th><?php
    }?>
            <th class="nobr" colspan="2" align="right"><?php echo $text[37]; ?></th>
            <th>&nbsp;</th>
          </tr><?php
    $punktespieltag=0;
    $nw=0;
    $tipp_jokertippaktiv=true;
    $plus=1;
    if (!$lmo_tipp_pokal) {
        $btip = array_pad($array,$lmo_tipp_anzsp+1,"false");
        for ($i=0; $i<$lmo_tipp_anzsp; $i++) {
            $btip[$i]=tippaenderbar((int)$lmo_tipp_paarungen[$i]->spiele[0]->anstoss,$lmo_tipp_datum1,$lmo_tipp_datum2);
            if ($tipp_jokertipp==1 && $jksp==($i+1) && $btip[$i]==false) {
                $tipp_jokertippaktiv=false;
            }
        }
    } else {
        $btip = array_pad($array,$lmo_tipp_anzsp+1,"");
        for ($i=0; $i<$lmo_tipp_anzsp; $i++) {
            $btip[$i] = array_pad(array("false"),$lmo_tipp_modus+1,"false");
            for ($n=0; $n<$lmo_tipp_modus; $n++) {
                $btip[$i][$n]=tippaenderbar((int)$lmo_tipp_paarungen[$i]->spiele[$n]->anstoss,$lmo_tipp_datum1,$lmo_tipp_datum2);
                if ($tipp_jokertipp==1 && $jksp==($i+1).($n+1) && $btip[$i][$n]==false) {
                    $tipp_jokertippaktiv=false;
                }
            }
        }
    }

    for ($i=0; $i<$lmo_tipp_anzsp; $i++) {
        if ($lmo_tipp_paarungen[$i]->heim>0 && $lmo_tipp_paarungen[$i]->gast>0) {
            if (!$lmo_tipp_pokal) {
                require(PATH_TO_ADDONDIR."/tipp/lmo-tippeditliga.php");
            } else {
                require(PATH_TO_ADDONDIR."/tipp/lmo-tippeditko.php");
            }
        }
    }?>
          <tr>
            <td colspan="<?php echo (int)$lmo_einstellungen->mitAnstosszeit()*2+10-(int)$lmo_einstellungen->ohneUnentschieden(); ?>" align="right"><?php
    if ($tipp_imvorraus>=0 && $st>($lmo_einstellungen->aktuellerSpieltag()+$tipp_imvorraus)){
        echo $text['tipp'][177];
    }
    if ($savebutton==1){ ?>
              <input class="lmo-formular-button" type="submit" title="<?php echo $text[114] ?>" name="best" value="<?php echo $text['tipp'][8]; ?>"<?php if ($tipp_imvorraus>=0 && $st>($lmo_einstellungen->aktuellerSpieltag()+$tipp_imvorraus)){echo " disabled";} ?>><?php  } else {
        echo "&nbsp;";
    }?>
            </td>
            <td class="lmoFrontMarkierung" colspan="<?php echo $breite-(int)$lmo_einstellungen->mitAnstosszeit()-9; ?>" align="right"><?php
    echo $text[37]." ";
    if (!$lmo_tipp_pokal){
        echo $text[2];
    } else {
        echo $j;
    }
    echo ": ".$punktespieltag;?>
            </td>
          </tr>
          <tr>
            <td class="lmoFooter" colspan="<?php echo $breite; ?>" align="center"><?php if ($tipp_tippBis>0){echo $text['tipp'][87]." ".$tipp_tippBis." ".$text['tipp'][88];} ?></td>
          </tr>
        </table>
      </form>
    </td>
  </tr>
</table>
<table width="100%" cellspacing="0" cellpadding="0" border="0">
  <tr><?php
    $st0 = $st-1;
    if ($st > 1) {?>
    <td align='left'>&nbsp;<a href="<?php echo $addr.$st0?>" title="<?php echo $text[6]?>"><?php echo $text[5]?> <?php echo $text[6]?></a>&nbsp;</td><?php
    }
    $st0 = $st+1;
    if ($st < $lmo_tipp_runden) {?>
    <td align="right">&nbsp;<a href="<?php echo $addr.$st0?>" title="<?php echo $text[8]?>"><?php echo $text[8]?> <?php echo $text[7]?></a>&nbsp;</td><?php
    }?>
  </tr>
</table><?php
}
?>