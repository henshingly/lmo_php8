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

$ligaDaten->titel="";
$ligaDaten->ergebnis=$ligaDaten->mittore=$ligastats1=$ligaDaten->kreuz=$ligaDaten->plan=$ligaDaten->kurve=1;
$ligaDaten->datc=$ligaDaten->nticker=$ligaDaten->lmtype=0;
if (!empty($file) && file_exists(PATH_TO_LMO.'/'.$dirliga.$file) && check_hilfsadmin($file)){
  if (substr($file,-4)==".l98"){
    $daten=array();
    $array=array();
    $sekt="";
    $datei = file(PATH_TO_LMO.'/'.$dirliga.$file);
    if ($datei) {
      $stand=date($defdateformat,filemtime(PATH_TO_LMO.'/'.$dirliga.$file));
      $ligaDaten->lmtype=0;
      for ($tt=0;$tt<count($datei);$tt++) {
        $zeile=&$datei[$tt];
        $zeile=trim($zeile);
        if ((substr($zeile,0,1)=="[") && (substr($zeile,-1)=="]")){
          $sekt=trim(substr($zeile,1,-1));
        } elseif ((str_contains($zeile, '=')) && (substr($zeile, 0, 1) != ';')) {
        //elseif ((strpos($zeile,"=")!==false) && (substr($zeile,0,1)!=";")){
          $conf=explode("=",$zeile,2);
          $schl=trim($conf[0]);
          $wert=trim($conf[1]);
          if ($sekt=="Options"){
            switch ($schl) {
              case "Title":        $ligaDaten->lmvers=$wert;break;
              case "Name":         $ligaDaten->titel=stripslashes($wert);break;
              case "Type":         $ligaDaten->lmtype=stripslashes($wert);break;
              case "Teams":        $ligaDaten->anzteams=$wert;break;
              case "Actual":       if (!isset($st))$st=$wert;$ligaDaten->stx=$wert;break;
              case "DatC":         $ligaDaten->datc=$wert;break;
              case "DatS":         $ligaDaten->dats=$wert;break;
              case "DatM":         $ligaDaten->datm=$wert;break;
              case "DatF":         $ligaDaten->datf=$wert;break;
              case "urlT":         $ligaDaten->urlt=$wert;break;
              case "urlB":         $ligaDaten->urlb=$wert;break;
              case "stats":        $stats=$wert;break;
              case "Plan":         $ligaDaten->plan=$wert;break;
              case "Ergebnis":     $ligaDaten->ergebnis=$wert;break;
              case "mittore":      $ligaDaten->mittore=$wert;break;
              case "favTeam":      $ligaDaten->favteam=$wert;break;
              case "selTeam":      if (!isset($ligaDaten->selteam))$ligaDaten->selteam=$wert;break;
              case "ticker":       $ligaDaten->nticker=$wert;break;
              case "goalfaktor":   $ligaDaten->goalfaktor=$wert;break;
              case "pointsfaktor": $ligaDaten->pointsfaktor=$wert;break;
              case "enableGameSort":$ligaDaten->enablegamesort=$wert;break;
            }
            if ($ligaDaten->lmtype==0){
              switch ($schl) {
                case "Rounds":            $ligaDaten->anzst=$wert;break;
                case "Matches":           $ligaDaten->anzsp=$wert;break;
                case "Kegel":             $ligaDaten->kegel=$wert;break;
                case "HandS":             $ligaDaten->hands=$wert;break;
                case "Graph":             $ligaDaten->kurve=$wert;break;
                case "Kreuz":             $ligaDaten->kreuz=$wert;break;
                case "Tabelle":           $ligaDaten->tabelle=$wert;break;
                case "Ligastats":         $ligaDaten->ligastats=$wert;break;
                case "PointsForWin":      $ligaDaten->pns=$wert;break;
                case "PointsForDraw":     $ligaDaten->pnu=$wert;break;
                case "PointsForLost":     $ligaDaten->pnn=$wert;break;
                case "MinusPoints":       $ligaDaten->minus=$wert;break;
                case "Direct":            $ligaDaten->direkt=$wert;break;
                case "Spez":              $ligaDaten->spez=$wert;break;
                case "HideDraw":          $ligaDaten->hidr=$wert;break;
                case "OnRun":             $ligaDaten->onrun=$wert;break;
                case "XtraS":             $ligaDaten->pxs=$wert;break;
                case "XtraU":             $ligaDaten->pxu=$wert;break;
                case "XtraV":             $ligaDaten->pxn=$wert;break;
                case "SpezS":             $ligaDaten->pps=$wert;break;
                case "SpezU":             $ligaDaten->ppu=$wert;break;
                case "SpezV":             $ligaDaten->ppn=$wert;break;
                case "Champ":             $ligaDaten->champ=$wert;break;
                case "CL":                $ligaDaten->anzcl=$wert;break;
                case "CK":                $ligaDaten->anzck=$wert;break;
                case "UC":                $ligaDaten->anzuc=$wert;break;
                case "AR":                $ligaDaten->anzar=$wert;break;
                case "AB":                $ligaDaten->anzab=$wert;break;
                case "namePkt":           $ligaDaten->namepkt=$wert;break;
                case "nameTor":           $ligaDaten->nametor=$wert;break;
                case "tableHinRueck":     $ligaDaten->einhinrueck=$wert;break;
                case "tableHeimAusw":     $ligaDaten->einheimausw=$wert;break;
                case "kurve1":            if (!isset($ligaDaten->stat1))$ligaDaten->stat1=$wert;break;
                case "kurve2":            if (!isset($ligaDaten->stat2))$ligaDaten->stat2=$wert;break;
              }
            } else {
              if ($schl=="KlFin"){         $ligaDaten->klfin=$wert;}
              if ($schl=="playdown"){      $ligaDaten->playdown=$wert;}
              if ($schl=="playoffmode"){   $ligaDaten->playoffmode=$wert;}
            }
          }
          $daten[]="$sekt|$schl|$wert|EOL";
        }
      }

      if (!isset($st)){                         $st=1;}
      if (!isset($ligaDaten->stx)){                        $ligaDaten->stx=1;}
      if (!isset($ligaDaten->ergebnis)){                   $ligaDaten->ergebnis=1;}
      if (!isset($ligaDaten->plan)){                       $ligaDaten->plan=1;}
      if (!isset($ligaDaten->mittore)){                    $ligaDaten->mittore=1;}
      if (!isset($ligaDaten->favteam)){                    $ligaDaten->favteam=0;}
      if (!isset($ligaDaten->selteam)){                    $ligaDaten->selteam=0;}
      if (!isset($ligaDaten->stat1)){                      $ligaDaten->stat1=0;}
      if (!isset($ligaDaten->stat2)){                      $ligaDaten->stat2=0;}
      if (($ligaDaten->stat1>0) && ($ligaDaten->stat1==$ligaDaten->stat2)){      $ligaDaten->stat2=0;}
      if (($ligaDaten->stat1==0) && ($ligaDaten->stat2>0)){           $ligaDaten->stat1=$ligaDaten->stat2;$ligaDaten->stat2=0;}
      if (!isset($ligaDaten->lmvers)){                     $ligaDaten->lmvers="k.A.";}
      if (!isset($ligaDaten->titel)){                      $ligaDaten->titel="No Name";}
      if (!isset($ligaDaten->dats)){                       $ligaDaten->dats=1;}
      if (!isset($ligaDaten->datm)){                       $ligaDaten->datm=0;}
      if (!isset($ligaDaten->datc)){                       if ((isset($ligaDaten->dats)) || (isset($ligaDaten->datm))){$ligaDaten->datc=1;} else {$ligaDaten->datc=0;}}
      if ((!isset($ligaDaten->dats)) || (!isset($ligaDaten->datm))){  $ligaDaten->datc=0;}
      if (!isset($ligaDaten->datf)){                       $ligaDaten->datf=$defdateformat;}
      if (!isset($ligaDaten->urlt)){                       $ligaDaten->urlt=1;}
      if (!isset($ligaDaten->urlb)){                       $ligaDaten->urlb=0;}
      if (!isset($stats)){                      $stats=0;}
      if (!isset($ligaDaten->goalfaktor) || $ligaDaten->goalfaktor=="")    { $ligaDaten->goalfaktor=1;}
      if (!isset($ligaDaten->pointsfaktor) || $ligaDaten->pointsfaktor==""){ $ligaDaten->pointsfaktor=1;}
      if (!isset($ligaDaten->enablegamesort)){             $ligaDaten->enablegamesort=1;}
      if ($ligaDaten->lmtype==0){
        if (!isset($ligaDaten->kurve)){                    $ligaDaten->kurve=1;}
        if (!isset($ligaDaten->kreuz)){                    $ligaDaten->kreuz=1;}
        if (!isset($ligaDaten->tabelle)){                  $ligaDaten->tabelle=1;}
        if (!isset($ligaDaten->ligastats)){                $ligaDaten->ligastats=1;}
        if (!isset($ligaDaten->anzteams)){                 $ligaDaten->anzteams=18;}
        if (!isset($ligaDaten->anzsp)){                    $ligaDaten->anzsp=floor($ligaDaten->anzteams/2);}
        if (!isset($ligaDaten->anzst)){                    $ligaDaten->anzst=floor($ligaDaten->anzteams*($ligaDaten->anzteams-1)/$ligaDaten->anzsp);}
        if (!isset($ligaDaten->hands)){                    $ligaDaten->hands=0;}
        if (!isset($ligaDaten->hidr)){                     $ligaDaten->hidr=0;}
        if (!isset($ligaDaten->onrun)){                    $ligaDaten->onrun=0;}
        if (!isset($ligaDaten->kegel)){                    $ligaDaten->kegel=0;}
        if (!isset($ligaDaten->minus)){                    $ligaDaten->minus=1;}
        if (!isset($ligaDaten->pns)){                      $ligaDaten->pns=3;}
        if (!isset($ligaDaten->pnu)){                      $ligaDaten->pnu=1;}
        if (!isset($ligaDaten->pnn)){                      $ligaDaten->pnn=0;}
        if (!isset($ligaDaten->pxs)){                      $ligaDaten->pxs=0;}
        if (!isset($ligaDaten->pxu)){                      $ligaDaten->pxu=0;}
        if (!isset($ligaDaten->pxn)){                      $ligaDaten->pxn=0;}
        if (!isset($ligaDaten->pps)){                      $ligaDaten->pps=0;}
        if (!isset($ligaDaten->ppu)){                      $ligaDaten->ppu=0;}
        if (!isset($ligaDaten->ppn)){                      $ligaDaten->ppn=0;}
        if (!isset($ligaDaten->champ)){                    $ligaDaten->champ=1;}
        if (!isset($ligaDaten->anzcl)){                    $ligaDaten->anzcl=1;}
        if (!isset($ligaDaten->anzck)){                    $ligaDaten->anzck=2;}
        if (!isset($ligaDaten->anzuc)){                    $ligaDaten->anzuc=2;}
        if (!isset($ligaDaten->anzar)){                    $ligaDaten->anzar=0;}
        if (!isset($ligaDaten->anzab)){                    $ligaDaten->anzab=3;}
        if (!isset($ligaDaten->namepkt)){                  $ligaDaten->namepkt="";}
        if (!isset($ligaDaten->nametor)){                  $ligaDaten->nametor="";}
        if ($ligaDaten->namepkt!=""){                      $text[37]=$ligaDaten->namepkt;}
        else {                                  $ligaDaten->namepkt=$text[37];}
        if ($ligaDaten->nametor!=""){                      $text[38]=$ligaDaten->nametor;}
        else {                                  $ligaDaten->nametor=$text[38];}
        if (!isset($ligaDaten->einhinrueck)){              $ligaDaten->einhinrueck=1;}
        if (!isset($ligaDaten->einheimausw)){              $ligaDaten->einheimausw=1;}
      } else {
        if (!isset($ligaDaten->anzteams)){                 $ligaDaten->anzteams    = 16;}
        if (!isset($ligaDaten->klfin)){                    $ligaDaten->klfin       = 0;}
        if (empty($ligaDaten->playdown)){                  $ligaDaten->playdown    = 0;}
        if (empty($ligaDaten->playoffmode)){               $ligaDaten->playoffmode = 0;}
        $ligaDaten->anzsp=floor($ligaDaten->anzteams/2);
        $ligaDaten->anzst=strlen(decbin($ligaDaten->anzteams-1));
        $ligaDaten->spez=1;
        $ligaDaten->hands=0;
      }
      $ligaDaten->teams = array_pad($array,$ligaDaten->anzteams+2,"");
      $ligaDaten->teamm = array_pad($array,$ligaDaten->anzteams+2,"");
      $ligaDaten->teamk = array_pad($array,$ligaDaten->anzteams+2,"");
      $ligaDaten->teamu = array_pad($array,$ligaDaten->anzteams+2,"");
      $ligaDaten->teamn = array_pad($array,$ligaDaten->anzteams+2,"");
      if (!isset($ligaDaten->nticker)){$ligaDaten->nticker=0;}
      if ($ligaDaten->nticker==1){
        $ligaDaten->nlines = array();
      }
      if ($ligaDaten->lmtype==0){
        $ligaDaten->strafp = array_pad(array("0"),116,"0");
        $ligaDaten->strafm = array_pad(array("0"),116,"0");
        $ligaDaten->torkorrektur1 = array_pad(array("0"),116,"0"); // Hack-Straftore
        $ligaDaten->torkorrektur2 = array_pad(array("0"),116,"0"); // Hack-Straftore
        $ligaDaten->strafdat      = array_pad(array("0"),116,"0"); // Hack-Straftore
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
      $ligaDaten->teams[0]="___";
      $ligaDaten->teamm[0]="___";
      $ligaDaten->teamk[0]="___";//$a=mictime();
      for ($i=1;$i<=count($daten);$i++){
        $dum=explode("|",$daten[$i-1]);
        //if ($nticker==1){
        if (($dum[0]=="News") && ($dum[1]!="NC")){$ligaDaten->nlines[]=stripslashes($dum[2]);}
        //}

        if ($dum[0]=="Teams"){$ligaDaten->teams[$dum[1]]=stripslashes($dum[2]);}
        if ($dum[0]=="Teamm"){$ligaDaten->teamm[$dum[1]]=stripslashes($dum[2]);}
        if ($dum[0]=="Teamk"){$ligaDaten->teamk[$dum[1]]=stripslashes($dum[2]);}
        $op1=substr($dum[0],0,4);
        $op2=substr($dum[0],0,5);
        $op3=((int)substr($dum[0],5)-1);
        $op4=((int)substr($dum[1],2)-1);
        $op5=substr($dum[0],4);
        $op6=((int)substr($dum[1],2,-1)-1);
        $op7=((int)substr($dum[1],-1)-1);
        $op8=substr($dum[1],0,2);

        if ($op1=="Team" && $dum[0]!="Teams" && $dum[0]!="Teamk" && $dum[0]!="Teamm") {
          if ($ligaDaten->lmtype==0){
            switch ($dum[1]) {
              case "SP":$ligaDaten->strafp[$op5]=$dum[2];break;
              case "SM":$ligaDaten->strafm[$op5]=$dum[2];break;
              case "TOR1":$ligaDaten->torkorrektur1[$op5]=$dum[2];break; // Hack-Straftore
              case "TOR2":$ligaDaten->torkorrektur2[$op5]=$dum[2];break; // Hack-Straftore
              case "STDA":$ligaDaten->strafdat[$op5]=$dum[2];break;      // Hack-Straftore
            }
          }
          if ($dum[1]=="URL"){$ligaDaten->teamu[$op5]=$dum[2];}
          if ($dum[1]=="NOT"){$ligaDaten->teamn[$op5]=$dum[2];}
        }

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
      for ($j=0;$j<=$ligaDaten->anzteams;$j++){
        if ($ligaDaten->teamm[$j]==""){
          //search longest name part an take this as middle name
          $parts = preg_split("%[ |/]%",$ligaDaten->teams[$j]);
          foreach ($parts as $part) {
            if (strlen($part) >= strlen($ligaDaten->teamm[$j]) ) {
              $ligaDaten->teamm[$j] = trim(substr($part, 0, 12));
            }
          }
        }
        if ($ligaDaten->teamk[$j]==""){
          $ligaDaten->teamk[$j] = trim(substr($ligaDaten->teams[$j],0,5));
        }
      }
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