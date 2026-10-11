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
 * @var array<int|string, mixed> $text Sprachtexte
 * @var string $file Ligadatei relativ zum Ligenordner, leer wenn keine geladen ist
 * @var int|string $st gewaehlter Spieltag
 * @var string $dirliga Ligenordner relativ zum LMO (Konfiguration)
 * @var string $diroutput Ordner fuer erzeugte Dateien (Konfiguration)
 *
 * Einstellungen:
 * @var int|string $einzustats Einstellung aus cfg.txt
 * @var int|string $einzutore Einstellung aus cfg.txt
 * @var int|string $einzutoretab Einstellung aus cfg.txt
 */


require_once(PATH_TO_LMO."/lmo-admintest.php");
if (($_SESSION['lmouserok']==2)||($_SESSION['lmouserok']==1)) {
  if ($file!="") {
    if (substr($file,-4)==".l98") {
      /*if ($einsavehtml==1) {
        include(PATH_TO_LMO."/lmo-savehtml.php");
        include(PATH_TO_LMO."/lmo-savehtml1.php");
      }*/
      if ($einzutore==1 || $einzutoretab==1 || $einzustats==1) {
        include(PATH_TO_LMO."/lmo-zustat.php");
      }

      $datei = fopen(PATH_TO_LMO.'/'.$dirliga.$file,"wb");

      if ($datei) {
        echo getMessage($text[138]);
        flock($datei,LOCK_EX);
        fputs($datei,"[Options]\n");
        fputs($datei,"Title=".$text[54]."\n");
        fputs($datei,"Name=".$ligaDaten->titel."\n");
        fputs($datei,"Type=".$ligaDaten->lmtype."\n");
        fputs($datei,"Teams=".$ligaDaten->anzteams."\n");
        fputs($datei,"goalfaktor=".$ligaDaten->goalfaktor."\n");
        fputs($datei,"pointsfaktor=".$ligaDaten->pointsfaktor."\n");
        fputs($datei,"enableGameSort=".$ligaDaten->enablegamesort."\n");
        if ($ligaDaten->lmtype==0) {
          fputs($datei,"Rounds=".$ligaDaten->anzst."\n");
          fputs($datei,"Matches=".$ligaDaten->anzsp."\n");
        }
        if ($st>0) {
          fputs($datei,"Actual=".$st."\n");
        }
        else {
          fputs($datei,"Actual=".$ligaDaten->stx."\n");
        }
        if ($ligaDaten->lmtype==0) {
          fputs($datei,"Kegel=".$ligaDaten->kegel."\n");
          fputs($datei,"HandS=".$ligaDaten->hands."\n");
          fputs($datei,"PointsForWin=".$ligaDaten->pns."\n");
          fputs($datei,"PointsForDraw=".$ligaDaten->pnu."\n");
          fputs($datei,"PointsForLost=".$ligaDaten->pnn."\n");
          fputs($datei,"Spez=".$ligaDaten->spez."\n");
          fputs($datei,"HideDraw=".$ligaDaten->hidr."\n");
          fputs($datei,"OnRun=".$ligaDaten->onrun."\n");
          if ($ligaDaten->spez==1) {
            fputs($datei,"XtraS=".$ligaDaten->pxs."\n");
            fputs($datei,"XtraU=".$ligaDaten->pxu."\n");
            fputs($datei,"XtraV=".$ligaDaten->pxn."\n");
            fputs($datei,"SpezS=".$ligaDaten->pps."\n");
            fputs($datei,"SpezU=".$ligaDaten->ppu."\n");
            fputs($datei,"SpezV=".$ligaDaten->ppn."\n");
          }
          fputs($datei,"MinusPoints=".$ligaDaten->minus."\n");
          fputs($datei,"Direct=".$ligaDaten->direkt."\n");
          fputs($datei,"Champ=".$ligaDaten->champ."\n");
          fputs($datei,"CL=".$ligaDaten->anzcl."\n");
          fputs($datei,"CK=".$ligaDaten->anzck."\n");
          fputs($datei,"UC=".$ligaDaten->anzuc."\n");
          fputs($datei,"AR=".$ligaDaten->anzar."\n");
          fputs($datei,"AB=".$ligaDaten->anzab."\n");
          if (isset($ligaDaten->namepkt)) {
            fputs($datei,"namePkt=".$ligaDaten->namepkt."\n");
          }
          if (isset($ligaDaten->nametor)) {
            fputs($datei,"nameTor=".$ligaDaten->nametor."\n");
          }
          fputs($datei,"tableHinRueck=".$ligaDaten->einhinrueck."\n");
          fputs($datei,"tableHeimAusw=".$ligaDaten->einheimausw."\n");
        }
        else {
          fputs($datei,"KlFin=".$ligaDaten->klfin."\n");
          fputs($datei,"playdown=".$ligaDaten->playdown."\n");
          fputs($datei,"playoffmode=".$ligaDaten->playoffmode."\n");
        }
        fputs($datei,"DatC=".$ligaDaten->datc."\n");
        fputs($datei,"DatS=".$ligaDaten->dats."\n");
        fputs($datei,"DatM=".$ligaDaten->datm."\n");
        fputs($datei,"DatF=".$ligaDaten->datf."\n");
        fputs($datei,"urlT=".$ligaDaten->urlt."\n");
        fputs($datei,"urlB=".$ligaDaten->urlb."\n");
        fputs($datei,"Plan=".$ligaDaten->plan."\n");
        fputs($datei,"Ergebnis=".$ligaDaten->ergebnis."\n");
        fputs($datei,"mittore=".$ligaDaten->mittore."\n");
        fputs($datei,"favTeam=".$ligaDaten->favteam."\n");
        fputs($datei,"selTeam=".$ligaDaten->selteam."\n");
        fputs($datei,"ticker=".$ligaDaten->nticker."\n");

        if ($ligaDaten->lmtype==0) {
          fputs($datei,"Graph=".$ligaDaten->kurve."\n");
          fputs($datei,"Kreuz=".$ligaDaten->kreuz."\n");
          fputs($datei,"Tabelle=".$ligaDaten->tabelle."\n");
          fputs($datei,"Ligastats=".$ligaDaten->ligastats."\n");
          fputs($datei,"kurve1=".$ligaDaten->stat1."\n");
          fputs($datei,"kurve2=".$ligaDaten->stat2."\n");
        }
        //if ($nticker==1) {
          fputs($datei,"\n[News]\n");
          if (isset($ligaDaten->nlines)) {
            fputs($datei,"NC=".count($ligaDaten->nlines)."\n");
            for ($i=0; $i<count($ligaDaten->nlines); $i++) {
              fputs($datei,"N".$i."=".$ligaDaten->nlines[$i]."\n");
            }
          }
        //}
        fputs($datei,"\n[Teams]\n");
        for ($i=1; $i<=$ligaDaten->anzteams; $i++) {
          fputs($datei,$i."=".$ligaDaten->teams[$i]."\n");
        }
        fputs($datei,"\n[Teamm]\n");
        for ($i=1; $i<=$ligaDaten->anzteams; $i++) {
          fputs($datei,$i."=".$ligaDaten->teamm[$i]."\n");
        }
        fputs($datei,"\n[Teamk]\n");
        for ($i=1; $i<=$ligaDaten->anzteams; $i++) {
          fputs($datei,$i."=".$ligaDaten->teamk[$i]."\n");
        }
        for ($i=1; $i<=$ligaDaten->anzteams; $i++) {
          fputs($datei,"\n[Team".$i."]\n");
          if ($ligaDaten->lmtype==0) {
            fputs($datei,"SP=".$ligaDaten->strafp[$i]."\n");
            if ($ligaDaten->minus==2) {
              fputs($datei,"SM=".$ligaDaten->strafm[$i]."\n");
            }
            fputs($datei,"TOR1=".$ligaDaten->torkorrektur1[$i]."\n"); // Hack-Straftore
            fputs($datei,"TOR2=".$ligaDaten->torkorrektur2[$i]."\n"); // Hack-Straftore
            fputs($datei,"STDA=".$ligaDaten->strafdat[$i]."\n");      // Hack-Straftore
          }
          fputs($datei,"URL=".$ligaDaten->teamu[$i]."\n");
          fputs($datei,"NOT=".$ligaDaten->teamn[$i]."\n");
        }
        if ($ligaDaten->lmtype!=0) {
          $ligaDaten->anzsp=$ligaDaten->anzteams;
        }
        for ($i=1; $i<=$ligaDaten->anzst; $i++) {
          fputs($datei,"\n[Round".$i."]\n");
          if ($ligaDaten->hands==1) {
            fputs($datei,"HS=".$ligaDaten->handp[$i-1]."\n");
          }
          fputs($datei,"D1=".$ligaDaten->datum1[$i-1]."\n");
          fputs($datei,"D2=".$ligaDaten->datum2[$i-1]."\n");
          if ($ligaDaten->lmtype!=0) {
            fputs($datei,"MO=".$ligaDaten->modus[$i-1]."\n");
            if ($ligaDaten->anzteams==24) {
              switch ($i) {
                case 1:
                case 2:
                  $ligaDaten->anzsp=16;
                  break;
                case 3:
                  $ligaDaten->anzsp=8;
                  break;
                case 4:
                  $ligaDaten->anzsp=4;
                  break;
                case 5:
                  $ligaDaten->anzsp=2;
                  break;
              }
            }
            $ligaDaten->anzsp=$ligaDaten->anzsp/2;
            if (($ligaDaten->klfin==1) && ($i==$ligaDaten->anzst)) {
              $ligaDaten->anzsp=$ligaDaten->anzsp+1;
            }
          }
          for ($j=1; $j<=$ligaDaten->anzsp; $j++) {
            if (!isset($ligaDaten->msieg[$i-1][$j-1])) {
              $ligaDaten->msieg[$i-1][$j-1]=0;
            }
            fputs($datei,"TA".$j."=".$ligaDaten->teama[$i-1][$j-1]."\n");
            fputs($datei,"TB".$j."=".$ligaDaten->teamb[$i-1][$j-1]."\n");
            if ($ligaDaten->lmtype==0) {
              if ($ligaDaten->goala[$i-1][$j-1]=="_") {
                fputs($datei,"GA".$j."=-1\n");
              }
              elseif ($ligaDaten->msieg[$i-1][$j-1]==1) {
                fputs($datei,"GA".$j."=-2\n");
              }
              else {
                fputs($datei,"GA".$j."=".$ligaDaten->goala[$i-1][$j-1]."\n");
              }
              if ($ligaDaten->goalb[$i-1][$j-1]=="_") {
                fputs($datei,"GB".$j."=-1\n");
              }
              elseif ($ligaDaten->msieg[$i-1][$j-1]==2) {
                fputs($datei,"GB".$j."=-2\n");
              }
              else {
                fputs($datei,"GB".$j."=".$ligaDaten->goalb[$i-1][$j-1]."\n");
              }
              if ($ligaDaten->msieg[$i-1][$j-1]==3) {
                fputs($datei,"ET".$j."=3\n");
              }
              if ($ligaDaten->spez==1) {
                if ($ligaDaten->mspez[$i-1][$j-1]=="_") {
                  fputs($datei,"SP".$j."=0\n");
                }
                elseif ($ligaDaten->mspez[$i-1][$j-1]==$text[0]) {
                  fputs($datei,"SP".$j."=2\n");
                }
                elseif ($ligaDaten->mspez[$i-1][$j-1]==$text[1]) {
                  fputs($datei,"SP".$j."=1\n");
                }
              }
              fputs($datei,"NT".$j."=".$ligaDaten->mnote[$i-1][$j-1]."\n");
              fputs($datei,"BE".$j."=".$ligaDaten->mberi[$i-1][$j-1]."\n");
              fputs($datei,"TI".$j."=".$ligaDaten->mtipp[$i-1][$j-1]."\n");
              fputs($datei,"AT".$j."=".$ligaDaten->mterm[$i-1][$j-1]."\n");
            }
            else {
              for ($n=1; $n<=$ligaDaten->modus[$i-1]; $n++) {
                if ($ligaDaten->goala[$i-1][$j-1][$n-1]=="_") {
                  fputs($datei,"GA".$j.$n."=-1\n");
                }
                else {
                  fputs($datei,"GA".$j.$n."=".$ligaDaten->goala[$i-1][$j-1][$n-1]."\n");
                }
                if ($ligaDaten->goalb[$i-1][$j-1][$n-1]=="_") {
                  fputs($datei,"GB".$j.$n."=-1\n");
                }
                else {
                  fputs($datei,"GB".$j.$n."=".$ligaDaten->goalb[$i-1][$j-1][$n-1]."\n");
                }
                if ($ligaDaten->mspez[$i-1][$j-1][$n-1]=="_") {
                  fputs($datei,"SP".$j.$n."=0\n");
                }
                elseif ($ligaDaten->mspez[$i-1][$j-1][$n-1]==$text[0]) {
                  fputs($datei,"SP".$j.$n."=2\n");
                }
                elseif ($ligaDaten->mspez[$i-1][$j-1][$n-1]==$text[1]) {
                  fputs($datei,"SP".$j.$n."=1\n");
                }
                fputs($datei,"NT".$j.$n."=".$ligaDaten->mnote[$i-1][$j-1][$n-1]."\n");
                fputs($datei,"BE".$j.$n."=".$ligaDaten->mberi[$i-1][$j-1][$n-1]."\n");
                fputs($datei,"TI".$j.$n."=".$ligaDaten->mtipp[$i-1][$j-1][$n-1]."\n");
                fputs($datei,"AT".$j.$n."=".$ligaDaten->mterm[$i-1][$j-1][$n-1]."\n");
              }
            }
          }
        }
        flock($datei,LOCK_UN);
        if (file_exists(PATH_TO_LMO.'/'.$diroutput.'/viewer_'.substr($file,0,-4).'_count.txt')) {
          unlink(PATH_TO_LMO.'/'.$diroutput.'/viewer_'.substr($file,0,-4).'_count.txt');
        }
        fclose($datei);
      }
      else {
        echo getMessage($text[283],true);
      }
      clearstatcache();
    }
  }
}

?>