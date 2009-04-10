<?
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


if(!empty($file) && check_hilfsadmin($file)){
  $me=array("0","January","February","March","April","May","June","July","August","September","October","November","December");
  if(substr($file,-4)==".l98"){
    $daten=array();
    $array=array();
    $sekt="";
    $datei = file(PATH_TO_LMO.'/'.$dirliga.$file);
    if ($datei) {
      $stand=strftime($defdateformat,filemtime(PATH_TO_LMO.'/'.$dirliga.$file));
      $lmtype=0;
      for($tt=0;$tt<count($datei);$tt++) {
        $zeile=&$datei[$tt];
        $zeile=trim($zeile);
        if((substr($zeile,0,1)=="[") && (substr($zeile,-1)=="]")){
          $sekt=trim(substr($zeile,1,-1));
        }elseif((strpos($zeile,"=")!==false) && (substr($zeile,0,1)!=";")){
          $conf=explode("=",$zeile,2);
          $schl=trim($conf[0]);
          $wert=trim($conf[1]);
          if($sekt=="Options"){
            switch ($schl) {
              case "Title":        $lmvers=$wert;break;
              case "Name":         $titel=stripslashes($wert);break;
              case "Type":         $lmtype=stripslashes($wert);break;
              case "Teams":        $anzteams=$wert;break;
              case "Actual":       if(!isset($st))$st=$wert;$stx=$wert;break;
              case "DatC":         $datc=$wert;break;
              case "DatS":         $dats=$wert;break;
              case "DatM":         $datm=$wert;break;
              case "DatF":         $datf=$wert;break;
              case "urlT":         $urlt=$wert;break;
              case "urlB":         $urlb=$wert;break;
              case "Plan":         $plan=$wert;break;
              case "Ergebnis":     $ergebnis=$wert;break;
              case "mittore":      $mittore=$wert;break;
              case "favTeam":      $favteam=$wert;break;
              case "selTeam":      if(!isset($selteam))$selteam=$wert;break;
              case "ticker":       $nticker=$wert;break;
              case "goalfaktor":   $goalfaktor=$wert;break;
              case "pointsfaktor": $pointsfaktor=$wert;break;
              case "enableGameSort":$enablegamesort=$wert;break;
            }
            if($lmtype==0){
              switch ($schl) {
                case "Rounds":            $anzst=$wert;break;
                case "Matches":           $anzsp=$wert;break;
                case "Kegel":             $kegel=$wert;break;
                case "HandS":             $hands=$wert;break;
                case "Graph":             $kurve=$wert;break;
                case "Kreuz":             $kreuz=$wert;break;
                case "Tabelle":           $tabelle=$wert;break;
                case "Ligastats":         $ligastats=$wert;break;
                case "PointsForWin":      $pns=$wert;break;
                case "PointsForDraw":     $pnu=$wert;break;
                case "PointsForLost":     $pnn=$wert;break;
                case "MinusPoints":       $minus=$wert;break;
                case "Direct":            $direkt=$wert;break;
                case "Spez":              $spez=$wert;break;
                case "HideDraw":          $hidr=$wert;break;
                case "OnRun":             $onrun=$wert;break;
                case "XtraS":             $pxs=$wert;break;
                case "XtraU":             $pxu=$wert;break;
                case "XtraV":             $pxn=$wert;break;
                case "SpezS":             $pps=$wert;break;
                case "SpezU":             $ppu=$wert;break;
                case "SpezV":             $ppn=$wert;break;
                case "Champ":             $champ=$wert;break;
                case "CL":                $anzcl=$wert;break;
                case "CK":                $anzck=$wert;break;
                case "UC":                $anzuc=$wert;break;
                case "AR":                $anzar=$wert;break;
                case "AB":                $anzab=$wert;break;
                case "namePkt":           $namepkt=$wert;break;
                case "nameTor":           $nametor=$wert;break;
                case "tableHinRueck":     $einhinrueck=$wert;break;
                case "tableHeimAusw":     $einheimausw=$wert;break;
                case "kurve1":            if(!isset($stat1))$stat1=$wert;break;
                case "kurve2":            if(!isset($stat2))$stat2=$wert;break;
              }
            }else{
              if($schl=="KlFin"){         $klfin=$wert;}
              if($schl=="playdown"){      $playdown=$wert;}
            }
          }
          $daten[]="$sekt|$schl|$wert|EOL";
        }
      }

      if(!isset($st)){                         $st=1;}
      if(!isset($stx)){                        $stx=1;}
      if(!isset($ergebnis)){                   $ergebnis=1;}
      if(!isset($plan)){                       $plan=1;}
      if(!isset($mittore)){                    $mittore=1;}
      if(!isset($favteam)){                    $favteam=0;}
      if(!isset($selteam)){                    $selteam=0;}
      if(!isset($stat1)){                      $stat1=0;}
      if(!isset($stat2)){                      $stat2=0;}
      if(($stat1>0) && ($stat1==$stat2)){      $stat2=0;}
      if(($stat1==0) && ($stat2>0)){           $stat1=$stat2;$stat2=0;}
      if(!isset($lmvers)){                     $lmvers="k.A.";}
      if(!isset($titel)){                      $titel="No Name";}
      if(!isset($dats)){                       $dats=1;}
      if(!isset($datm)){                       $datm=0;}
      if(!isset($datc)){                       if((isset($dats)) || (isset($datm))){$datc=1;}else{$datc=0;}}
      if((!isset($dats)) || (!isset($datm))){  $datc=0;}
      if(!isset($datf)){                       $datf=$defdateformat;}
      if(!isset($urlt)){                       $urlt=1;}
      if(!isset($urlb)){                       $urlb=0;}
      if(!isset($goalfaktor) || $goalfaktor=="")    { $goalfaktor=1;}
      if(!isset($pointsfaktor) || $pointsfaktor==""){ $pointsfaktor=1;}
      if(!isset($enablegamesort)){             $enablegamesort=1;}
      if($lmtype==0){
        if(!isset($kurve)){                    $kurve=1;}
        if(!isset($kreuz)){                    $kreuz=1;}
        if(!isset($tabelle)){                  $tabelle=1;}
        if(!isset($ligastats)){                $ligastats=1;}
        if(!isset($anzteams)){                 $anzteams=18;}
        if(!isset($anzsp)){                    $anzsp=floor($anzteams/2);}
        if(!isset($anzst)){                    $anzst=floor($anzteams*($anzteams-1)/$anzsp);}
        if(!isset($hands)){                    $hands=0;}
        if(!isset($hidr)){                     $hidr=0;}
        if(!isset($onrun)){                    $onrun=0;}
        if(!isset($kegel)){                    $kegel=0;}
        if(!isset($minus)){                    $minus=1;}
        if(!isset($pns)){                      $pns=3;}
        if(!isset($pnu)){                      $pnu=1;}
        if(!isset($pnn)){                      $pnn=0;}
        if(!isset($pxs)){                      $pxs=0;}
        if(!isset($pxu)){                      $pxu=0;}
        if(!isset($pxn)){                      $pxn=0;}
        if(!isset($pps)){                      $pps=0;}
        if(!isset($ppu)){                      $ppu=0;}
        if(!isset($ppn)){                      $ppn=0;}
        if(!isset($champ)){                    $champ=1;}
        if(!isset($anzcl)){                    $anzcl=1;}
        if(!isset($anzck)){                    $anzck=2;}
        if(!isset($anzuc)){                    $anzuc=2;}
        if(!isset($anzar)){                    $anzar=0;}
        if(!isset($anzab)){                    $anzab=3;}
        if(!isset($namepkt)){                  $namepkt="";}
        if(!isset($nametor)){                  $nametor="";}
        if($namepkt!=""){                      $text[37]=$namepkt;}
        else{                                  $namepkt=$text[37];}
        if($nametor!=""){                      $text[38]=$nametor;}
        else{                                  $nametor=$text[38];}
        if(!isset($einhinrueck)){              $einhinrueck=1;}
        if(!isset($einheimausw)){              $einheimausw=1;}
      }else{
        if(!isset($anzteams)){                 $anzteams=16;}
        if(!isset($klfin)){                    $klfin=0;}
        if(empty($playdown)){                  $playdown=0;}
        $anzsp=floor($anzteams/2);
        $anzst=strlen(decbin($anzteams-1));
        $spez=1;
        $hands=0;
      }
      $teams = array_pad($array,$anzteams+2,"");
      $teamm = array_pad($array,$anzteams+2,"");
      $teamk = array_pad($array,$anzteams+2,"");
      $teamu = array_pad($array,$anzteams+2,"");
      $teamn = array_pad($array,$anzteams+2,"");
      if(!isset($nticker)){$nticker=0;}
      if($nticker==1){
        $nlines = array();
      }
      if($lmtype==0){
        $strafp = array_pad(array("0"),116,"0");
        $strafm = array_pad(array("0"),116,"0");
        $torkorrektur1 = array_pad(array("0"),116,"0"); // Hack-Straftore
        $torkorrektur2 = array_pad(array("0"),116,"0"); // Hack-Straftore
        $strafdat      = array_pad(array("0"),116,"0"); // Hack-Straftore
        $handp = array_pad(array("0"),116,"0");
        $datum1 = array_pad($array,116,"");
        $datum2 = array_pad($array,116,"");
        $teama = array_pad($array,116,"");
        $teamb = array_pad($array,116,"");
        $goala = array_pad($array,116,"");
        $goalb = array_pad($array,116,"");
        $mspez = array_pad($array,116,"");
        $mberi = array_pad($array,116,"");
        $mtipp = array_pad($array,116,"");
        $mnote = array_pad($array,116,"");
        $msieg = array_pad($array,116,"");
        $mterm = array_pad($array,116,"");
        for($i=0;$i<116;$i++){
          $teama[$i] = array_pad(array("0"),40,"0");
          $teamb[$i] = array_pad(array("0"),40,"0");
          $goala[$i] = array_pad(array("_"),40,"_");
          $goalb[$i] = array_pad(array("_"),40,"_");
          $mspez[$i] = array_pad($array,40,"");
          $mnote[$i] = array_pad($array,40,"");
          $mberi[$i] = array_pad($array,40,"");
          $mtipp[$i] = array_pad($array,40,"");
          $msieg[$i] = array_pad(array("0"),40,"0");
          $mterm[$i] = array_pad(array("0"),40,"0");
        }
      }else{
        $datum1 = array_pad($array,7,"");
        $datum2 = array_pad($array,7,"");
        $modus = array_pad(array("1"),7,"1");
        $teama = array_pad($array,7,"");
        $teamb = array_pad($array,7,"");
        $goala = array_pad($array,7,"");
        $goalb = array_pad($array,7,"");
        $mspez = array_pad($array,7,"");
        $mberi = array_pad($array,7,"");
        $mtipp = array_pad($array,7,"");
        $mnote = array_pad($array,7,"");
        $mterm = array_pad($array,7,"");
        for($i=0;$i<7;$i++){
          $teama[$i] = array_pad(array("0"),64,"0");
          $teamb[$i] = array_pad(array("0"),64,"0");
          $goala[$i] = array_pad($array,64,"");
          $goalb[$i] = array_pad($array,64,"");
          $mspez[$i] = array_pad($array,64,"");
          $mnote[$i] = array_pad($array,64,"");
          $mberi[$i] = array_pad($array,64,"");
          $mtipp[$i] = array_pad($array,64,"");
          $mterm[$i] = array_pad($array,64,"");
          for($j=0;$j<64;$j++){
            $goala[$i][$j] = array_pad(array("_"),7,"_");
            $goalb[$i][$j] = array_pad(array("_"),7,"_");
            $mspez[$i][$j] = array_pad($array,7,"");
            $mnote[$i][$j] = array_pad($array,7,"");
            $mberi[$i][$j] = array_pad($array,7,"");
            $mtipp[$i][$j] = array_pad($array,7,"");
            $mterm[$i][$j] = array_pad(array("0"),7,"0");
          }
        }
      }
      $teams[0]="___";
      $teamm[0]="___";
      $teamk[0]="___";//$a=mictime();
      for($i=1;$i<=count($daten);$i++){
        $dum=explode("|",$daten[$i-1]);
        //if($nticker==1){
        if(($dum[0]=="News") && ($dum[1]!="NC")){$nlines[]=stripslashes($dum[2]);}
        //}

        if($dum[0]=="Teams"){$teams[$dum[1]]=stripslashes($dum[2]);}
        if($dum[0]=="Teamm"){$teamm[$dum[1]]=stripslashes($dum[2]);}
        if($dum[0]=="Teamk"){$teamk[$dum[1]]=stripslashes($dum[2]);}
        $op1=substr($dum[0],0,4);
        $op2=substr($dum[0],0,5);
        $op3=substr($dum[0],5)-1;
        $op4=substr($dum[1],2)-1;
        $op5=substr($dum[0],4);
        $op6=substr($dum[1],2,-1)-1;
        $op7=substr($dum[1],-1)-1;
        $op8=substr($dum[1],0,2);

        if($op1=="Team" && $dum[0]!="Teams" && $dum[0]!="Teamk" && $dum[0]!="Teamm") {
          if($lmtype==0){
            switch ($dum[1]) {
              case "SP":$strafp[$op5]=$dum[2];break;
              case "SM":$strafm[$op5]=$dum[2];break;
              case "TOR1":$torkorrektur1[$op5]=$dum[2];break; // Hack-Straftore
              case "TOR2":$torkorrektur2[$op5]=$dum[2];break; // Hack-Straftore
              case "STDA":$strafdat[$op5]=$dum[2];break;      // Hack-Straftore
            }
          }
          if($dum[1]=="URL"){$teamu[$op5]=$dum[2];}
          if($dum[1]=="NOT"){$teamn[$op5]=$dum[2];}
        }

        if(!isset($lmo_only_st) || ($lmo_only_st==true && $op3==$st-1)){ // nur der benötigte Spieltag wird eingelesen

        if($op2=="Round") {
          switch($dum[1]) {
            case "HS":$handp[$op3]=$dum[2];break;
            case "D1":$datum1[$op3]=$dum[2];break;
            case "D2":$datum2[$op3]=$dum[2];break;
          }
          switch ($op8) {
            case "TA":$teama[$op3][$op4]=$dum[2];break;
            case "TB":$teamb[$op3][$op4]=$dum[2];break;
          }
          if($lmtype==0) {
            switch ($op8) {
              case "GA":
              $goala[$op3][$op4]=$dum[2];
              if($goala[$op3][$op4]==""){$goala[$op3][$op4]=-1;}
              elseif($goala[$op3][$op4]=="-1"){$goala[$op3][$op4]="_";}
              elseif($goala[$op3][$op4]=="-2"){$msieg[$op3][$op4]=1;$goala[$op3][$op4]="0";}
              break;
              case "GB":
              $goalb[$op3][$op4]=$dum[2];
              if($goalb[$op3][$op4]==""){$goalb[$op3][$op4]=-1;}
              elseif($goalb[$op3][$op4]=="-1"){$goalb[$op3][$op4]="_";}
              elseif($goalb[$op3][$op4]=="-2"){$msieg[$op3][$op4]=2;$goalb[$op3][$op4]="0";}
              break;
              case "SP":
              if($spez==1){
                $mspez[$op3][$op4]=$dum[2];
                if($mspez[$op3][$op4]==0){$mspez[$op3][$op4]="&nbsp;";}
                elseif($mspez[$op3][$op4]==2){$mspez[$op3][$op4]=$text[0];}
                elseif($mspez[$op3][$op4]==1){$mspez[$op3][$op4]=$text[1];}
              }
              break;
              case "ET":
              if ($dum[2]==3){$msieg[$op3][$op4]=3;}
              break;
              case "NT":$mnote[$op3][$op4]=$dum[2];break;
              case "BE":$mberi[$op3][$op4]=$dum[2];break;
              case "TI":$mtipp[$op3][$op4]=$dum[2];break;
              case "AT":$mterm[$op3][$op4]=$dum[2];break;
            }
          } else {
            if($dum[1]=="MO"){$modus[$op3]=$dum[2];}
            switch ($op8) {
              case "GA":
              $goala[$op3][$op6][$op7]=$dum[2];
              if($goala[$op3][$op6][$op7]==""){$goala[$op3][$op6][$op7]=-1;}
              elseif($goala[$op3][$op6][$op7]=="-1"){$goala[$op3][$op6][$op7]="_";}
              break;
              case "GB":
              $goalb[$op3][$op6][$op7]=$dum[2];
              if($goalb[$op3][$op6][$op7]==""){$goalb[$op3][$op6][$op7]=-1;}
              elseif($goalb[$op3][$op6][$op7]=="-1"){$goalb[$op3][$op6][$op7]="_";}
              break;
              case "SP":
              $mspez[$op3][$op6][$op7]=$dum[2];
              if($mspez[$op3][$op6][$op7]==0){$mspez[$op3][$op6][$op7]="&nbsp;";}
              elseif($mspez[$op3][$op6][$op7]==2){$mspez[$op3][$op6][$op7]=$text[0];}
              elseif($mspez[$op3][$op6][$op7]==1){$mspez[$op3][$op6][$op7]=$text[1];}
              break;
              case "NT":$mnote[$op3][$op6][$op7]=$dum[2];break;
              case "BE":$mberi[$op3][$op6][$op7]=$dum[2];break;
              case "TI":$mtipp[$op3][$op6][$op7]=$dum[2];break;
              case "AT":$mterm[$op3][$op6][$op7]=$dum[2];break;
            }
          }
        }
        if(!isset($handp[$op3])){$handp[$op3]="0";}
        }
      }
      if(!empty($datum1[$op3])){
        $dat=explode(".",$datum1[$op3]);
        if (checkdate($dat[1],$dat[0],$dat[2])) {
          $datum1[$op3]=strftime("%d.%m.%Y",mktime(0,0,0,$dat[1],$dat[0],$dat[2]));
        } else {
          $datum1[$op3]="";
        }
        /*$dummy=strtotime(substr($datum1[$op3],0,2)." ".$me[intval(substr($datum1[$op3],3,2))]." ".substr($datum1[$op3],6,4));
        if($dummy>-1){$datum1[$op3]=strftime("%d.%m.%Y",$dummy);}else{$datum1[$op3]="";}*/
      }
      if(!empty($datum2[$op3])){
        $dat=explode(".",$datum2[$op3]);
        if (checkdate($dat[1],$dat[0],$dat[2])) {
          $datum2[$op3]=strftime("%d.%m.%Y",mktime(0,0,0,$dat[1],$dat[0],$dat[2]));
        } else {
          $datum2[$op3]="";
        }
        /*$dummy=strtotime(substr($datum2[$op3],0,2)." ".$me[intval(substr($datum2[$op3],3,2))]." ".substr($datum2[$op3],6,4));
        if($dummy>-1){$datum2[$op3]=strftime("%d.%m.%Y",$dummy);}else{$datum2[$op3]="";}*/
      }
      for($j=0;$j<=$anzteams;$j++){
        if($teamm[$j]==""){
          //search longest name part an take this as middle name
          $parts = preg_split("%[ |/]%",$teams[$j]);
          foreach ($parts as $part) {
            if (strlen($part) >= strlen($teamm[$j]) ) {
              $teamm[$j] = trim(substr($part, 0, 12));
            }
          }
        }
        if($teamk[$j]==""){
          $teamk[$j] = trim(substr($teams[$j],0,5));
        }
      }
      //echo "<br>".((mictime()-$a)*1000)." µS ".$dum[1];
    } else {
      echo getMessage($text[224],TRUE);
    }
  }
}
?>