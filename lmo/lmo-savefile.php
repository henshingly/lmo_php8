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
        // Schluessel, Reihenfolge und Bedingungen: Tabelle OPTIONEN in Lmo\Liga\LigaDaten
        foreach ($ligaDaten->optionenZumSpeichern($text[54], $st>0 ? $st : $ligaDaten->stx) as list($schl, $wert)) {
          fputs($datei,$schl."=".$wert."\n");
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
        // [Teams], [Teamm], [Teamk] und [Team1] ... [TeamN]: Lmo\Liga\LigaDaten
        foreach ($ligaDaten->mannschaftenZumSpeichern() as list($abschnitt, $zeilen)) {
          fputs($datei,"\n[".$abschnitt."]\n");
          foreach ($zeilen as list($schl, $wert)) {
            fputs($datei,$schl."=".$wert."\n");
          }
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