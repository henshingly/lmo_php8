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
 * @var string $dirliga Ligenordner relativ zum LMO (Konfiguration)
 * @var string $defdateformat Datumsformat in date()-Schreibweise (Konfiguration)
 *
 * Werden auch in dieser Datei gesetzt, aber nicht auf jedem Weg (koennen von aussen kommen):
 * @var mixed $op3
 */

// $ligaDaten bereitstellen (auch wenn dieser Lader innerhalb einer Funktion laeuft)
require(PATH_TO_LMO . '/lmo-ligadaten.php');

$ligaDaten->setzeStartwerte();
$ligastats1=1;
if (!empty($file) && file_exists(PATH_TO_LMO.'/'.$dirliga.$file) && check_hilfsadmin($file)){
  if (substr($file,-4)==".l98"){
    $daten=array();
    $array=array();
    $sekt="";
    $datei = file(PATH_TO_LMO.'/'.$dirliga.$file);
    if ($datei) {
      $stand=date($defdateformat,filemtime(PATH_TO_LMO.'/'.$dirliga.$file));
      $ligaDaten->lmtype=0;
      // Abschnitte, Schluessel und Werte liest Lmo\Liga\LigaDatei; hier folgt nur ihre Bedeutung
      foreach (\Lmo\Liga\LigaDatei::zerlege($datei) as list($sekt, $schl, $wert)) {
          if ($sekt=="Options"){
            // $st und $stats gehoeren nicht zur Liga: gewaehlter Spieltag (auch Aufrufparameter), Statistik-Schalter
            if ($schl=="Actual" && !isset($st)){ $st=$wert;}
            if ($schl=="stats"){ $stats=$wert;}
            // alle anderen Schluessel: Tabelle OPTIONEN in Lmo\Liga\LigaDaten
            $ligaDaten->setzeOption($schl,$wert);
          }
          $daten[]="$sekt|$schl|$wert|EOL";
      }

      if (!isset($st)){                         $st=1;}
      if (!isset($stats)){                      $stats=0;}
      // alles, was die Datei nicht nennt (Lmo\Liga\LigaDaten)
      $ligaDaten->ergaenzeVorgabewerte($defdateformat);
      if ($ligaDaten->lmtype==0){
        // eigene Bezeichnung fuer Punkte/Tore gilt auch fuer die Sprachtexte, sonst umgekehrt
        if ($ligaDaten->namepkt!=""){                      $text[37]=$ligaDaten->namepkt;}
        else {                                  $ligaDaten->namepkt=$text[37];}
        if ($ligaDaten->nametor!=""){                      $text[38]=$ligaDaten->nametor;}
        else {                                  $ligaDaten->nametor=$text[38];}
      }
      // Felder der Mannschaften in voller Groesse, Platz 0 = "___" (Lmo\Liga\LigaDaten)
      $ligaDaten->bereiteMannschaftenVor();
      if (!isset($ligaDaten->nticker)){$ligaDaten->nticker=0;}
      if ($ligaDaten->nticker==1){
        $ligaDaten->nlines = array();
      }
      if ($ligaDaten->lmtype==0){
        $ligaDaten->handp = array_pad(array("0"),116,"0");
        $ligaDaten->datum1 = array_pad($array,116,"");
        $ligaDaten->datum2 = array_pad($array,116,"");
        $ligaDaten->teama = array_pad($array,116,"");
        $ligaDaten->teamb = array_pad($array,116,"");
        $ligaDaten->goala = array_pad($array,116,"");
        $ligaDaten->goalb = array_pad($array,116,"");
        $ligaDaten->mspez = array_pad($array,116,"");
        $ligaDaten->mberi = array_pad($array,116,"");
        $ligaDaten->mtipp = array_pad($array,116,"");
        $ligaDaten->mnote = array_pad($array,116,"");
        $ligaDaten->msieg = array_pad($array,116,"");
        $ligaDaten->mterm = array_pad($array,116,"");
        for ($i=0;$i<116;$i++){
          $ligaDaten->teama[$i] = array_pad(array("0"),40,"0");
          $ligaDaten->teamb[$i] = array_pad(array("0"),40,"0");
          $ligaDaten->goala[$i] = array_pad(array("_"),40,"_");
          $ligaDaten->goalb[$i] = array_pad(array("_"),40,"_");
          $ligaDaten->mspez[$i] = array_pad($array,40,"");
          $ligaDaten->mnote[$i] = array_pad($array,40,"");
          $ligaDaten->mberi[$i] = array_pad($array,40,"");
          $ligaDaten->mtipp[$i] = array_pad($array,40,"");
          $ligaDaten->msieg[$i] = array_pad(array("0"),40,"0");
          $ligaDaten->mterm[$i] = array_pad(array("0"),40,"0");
        }
      } else {
        $ligaDaten->datum1 = array_pad($array,7,"");
        $ligaDaten->datum2 = array_pad($array,7,"");
        $ligaDaten->modus = array_pad(array("1"),7,"1");
        $ligaDaten->teama = array_pad($array,7,"");
        $ligaDaten->teamb = array_pad($array,7,"");
        $ligaDaten->goala = array_pad($array,7,"");
        $ligaDaten->goalb = array_pad($array,7,"");
        $ligaDaten->mspez = array_pad($array,7,"");
        $ligaDaten->mberi = array_pad($array,7,"");
        $ligaDaten->mtipp = array_pad($array,7,"");
        $ligaDaten->mnote = array_pad($array,7,"");
        $ligaDaten->mterm = array_pad($array,7,"");
        for ($i=0;$i<7;$i++){
          $ligaDaten->teama[$i] = array_pad(array("0"),64,"0");
          $ligaDaten->teamb[$i] = array_pad(array("0"),64,"0");
          $ligaDaten->goala[$i] = array_pad($array,64,"");
          $ligaDaten->goalb[$i] = array_pad($array,64,"");
          $ligaDaten->mspez[$i] = array_pad($array,64,"");
          $ligaDaten->mnote[$i] = array_pad($array,64,"");
          $ligaDaten->mberi[$i] = array_pad($array,64,"");
          $ligaDaten->mtipp[$i] = array_pad($array,64,"");
          $ligaDaten->mterm[$i] = array_pad($array,64,"");
          for ($j=0;$j<64;$j++){
            $ligaDaten->goala[$i][$j] = array_pad(array("_"),7,"_");
            $ligaDaten->goalb[$i][$j] = array_pad(array("_"),7,"_");
            $ligaDaten->mspez[$i][$j] = array_pad($array,7,"");
            $ligaDaten->mnote[$i][$j] = array_pad($array,7,"");
            $ligaDaten->mberi[$i][$j] = array_pad($array,7,"");
            $ligaDaten->mtipp[$i][$j] = array_pad($array,7,"");
            $ligaDaten->mterm[$i][$j] = array_pad(array("0"),7,"0");
          }
        }
      }
      for ($i=1;$i<=count($daten);$i++){
        $dum=explode("|",$daten[$i-1]);
        //if ($nticker==1){
        if (($dum[0]=="News") && ($dum[1]!="NC")){$ligaDaten->nlines[]=stripslashes($dum[2]);}
        //}

        // [Teams], [Teamm], [Teamk] und [Team1] ... [TeamN]
        $ligaDaten->setzeMannschaftswert($dum[0],$dum[1],$dum[2]);
        $op1=substr($dum[0],0,4);
        $op2=substr($dum[0],0,5);
        $op3=((int)substr($dum[0],5)-1);
        $op4=((int)substr($dum[1],2)-1);
        $op5=substr($dum[0],4);
        $op6=((int)substr($dum[1],2,-1)-1);
        $op7=((int)substr($dum[1],-1)-1);
        $op8=substr($dum[1],0,2);


        if (!isset($lmo_only_st) || ($lmo_only_st==true && $op3==$st-1)){ // nur der benötigte Spieltag wird eingelesen

        if ($op2=="Round") {
          switch($dum[1]) {
            case "HS":$ligaDaten->handp[$op3]=$dum[2];break;
            case "D1":$ligaDaten->datum1[$op3]=$dum[2];break;
            case "D2":$ligaDaten->datum2[$op3]=$dum[2];break;
          }
          switch ($op8) {
            case "TA":$ligaDaten->teama[$op3][$op4]=$dum[2];break;
            case "TB":$ligaDaten->teamb[$op3][$op4]=$dum[2];break;
          }
          if ($ligaDaten->lmtype==0) {
            switch ($op8) {
              case "GA":
                $ligaDaten->goala[$op3][$op4]=$dum[2];
                if ($ligaDaten->goala[$op3][$op4]==""){$ligaDaten->goala[$op3][$op4]=-1;}
                elseif ($ligaDaten->goala[$op3][$op4]=="-1"){$ligaDaten->goala[$op3][$op4]="_";}
                elseif ($ligaDaten->goala[$op3][$op4]=="-2"){$ligaDaten->msieg[$op3][$op4]=1;$ligaDaten->goala[$op3][$op4]="0";}
              break;
              case "GB":
                $ligaDaten->goalb[$op3][$op4]=$dum[2];
                if ($ligaDaten->goalb[$op3][$op4]==""){$ligaDaten->goalb[$op3][$op4]=-1;}
                elseif ($ligaDaten->goalb[$op3][$op4]=="-1"){$ligaDaten->goalb[$op3][$op4]="_";}
                elseif ($ligaDaten->goalb[$op3][$op4]=="-2"){$ligaDaten->msieg[$op3][$op4]=2;$ligaDaten->goalb[$op3][$op4]="0";}
              break;
              case "SP":
                if ($ligaDaten->spez==1){
                  $ligaDaten->mspez[$op3][$op4]=$dum[2];
                  if ($ligaDaten->mspez[$op3][$op4]==0){$ligaDaten->mspez[$op3][$op4]="&nbsp;";}
                  elseif ($ligaDaten->mspez[$op3][$op4]==2){$ligaDaten->mspez[$op3][$op4]=$text[0];}
                  elseif ($ligaDaten->mspez[$op3][$op4]==1){$ligaDaten->mspez[$op3][$op4]=$text[1];}
                }
              break;
              case "ET":
                if ($dum[2]==3){$ligaDaten->msieg[$op3][$op4]=3;}
              break;
              case "NT":$ligaDaten->mnote[$op3][$op4]=$dum[2];break;
              case "BE":$ligaDaten->mberi[$op3][$op4]=$dum[2];break;
              case "TI":$ligaDaten->mtipp[$op3][$op4]=$dum[2];break;
              case "AT":$ligaDaten->mterm[$op3][$op4]=$dum[2];break;
            }
          } else {
            if ($dum[1]=="MO"){$ligaDaten->modus[$op3]=$dum[2];}
            switch ($op8) {
              case "GA":
                $ligaDaten->goala[$op3][$op6][$op7]=$dum[2];
                if ($ligaDaten->goala[$op3][$op6][$op7]==""){$ligaDaten->goala[$op3][$op6][$op7]=-1;}
                elseif ($ligaDaten->goala[$op3][$op6][$op7]=="-1"){$ligaDaten->goala[$op3][$op6][$op7]="_";}
              break;
              case "GB":
                $ligaDaten->goalb[$op3][$op6][$op7]=$dum[2];
                if ($ligaDaten->goalb[$op3][$op6][$op7]==""){$ligaDaten->goalb[$op3][$op6][$op7]=-1;}
                elseif ($ligaDaten->goalb[$op3][$op6][$op7]=="-1"){$ligaDaten->goalb[$op3][$op6][$op7]="_";}
              break;
              case "SP":
                $ligaDaten->mspez[$op3][$op6][$op7]=$dum[2];
                if ($ligaDaten->mspez[$op3][$op6][$op7]==0){$ligaDaten->mspez[$op3][$op6][$op7]="&nbsp;";}
                elseif ($ligaDaten->mspez[$op3][$op6][$op7]==2){$ligaDaten->mspez[$op3][$op6][$op7]=$text[0];}
                elseif ($ligaDaten->mspez[$op3][$op6][$op7]==1){$ligaDaten->mspez[$op3][$op6][$op7]=$text[1];}
              break;
              case "NT":$ligaDaten->mnote[$op3][$op6][$op7]=$dum[2];break;
              case "BE":$ligaDaten->mberi[$op3][$op6][$op7]=$dum[2];break;
              case "TI":$ligaDaten->mtipp[$op3][$op6][$op7]=$dum[2];break;
              case "AT":$ligaDaten->mterm[$op3][$op6][$op7]=$dum[2];break;
            }
          }
        }
        if (!isset($ligaDaten->handp[$op3])){$ligaDaten->handp[$op3]="0";}
        }
      }
      if (!empty($ligaDaten->datum1[$op3])){
        $dat=explode(".",$ligaDaten->datum1[$op3]);
        if (checkdate($dat[1],$dat[0],$dat[2])) {
          $ligaDaten->datum1[$op3]=date("d.m.Y",mktime(0,0,0,$dat[1],$dat[0],$dat[2]));
        } else {
          $ligaDaten->datum1[$op3]="";
        }
      }
      if (!empty($ligaDaten->datum2[$op3])){
        $dat=explode(".",$ligaDaten->datum2[$op3]);
        if (checkdate($dat[1],$dat[0],$dat[2])) {
          $ligaDaten->datum2[$op3]=date("d.m.Y",mktime(0,0,0,$dat[1],$dat[0],$dat[2]));
        } else {
          $ligaDaten->datum2[$op3]="";
        }
      }
      // fehlende Kurz- und Mittelnamen aus dem Namen ableiten
      $ligaDaten->ergaenzeMannschaftsnamen();
    } else {
      echo getMessage($text[224],true);
    }
  }
} else {
  // Datei existiert nicht, ist kein gültiges Ligaformat oder keine Berechtigung (check_hilfsadmin): $file zurücksetzen, damit die
  // aufrufenden Skripte (z.B. lmo-showmain2.php) korrekt in den "kein File gewählt"-Zustand fallen, statt mit undefinierten
  // Variablen ($st, $anzst, $ligastats, $spez, $msieg, ...) fortzufahren.
  if (!empty($file)) {
    echo getMessage($text[224],true);
  }
  $file = '';
}
?>