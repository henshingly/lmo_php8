<?PHP
// 
// LigaManager Online 3.02
// Copyright (C) 1997-2002 by Frank Hollwitz
// webmaster@hollwitz.de / http://php.hollwitz.de
// 
// Tippspiel-AddOn 1.20
// Copyright (C) 2002 by Frank Albrecht
// fkalbrecht@web.de
// 
// This program is free software; you can redistribute it and/or
// modify it under the terms of the GNU General Public License as
// published by the Free Software Foundation; either version 2 of
// the License, or (at your option) any later version.
// 
// This program is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
// General Public License for more details.
// 
// You should have received a copy of the GNU General Public License
// along with this program; if not, write to the Free Software
// Foundation, Inc., 675 Mass Ave, Cambridge, MA 02139, USA.
// 
require_once(PATH_TO_LMO."/lmo-admintest.php");
require_once(PATH_TO_LMO."/lmo-tippaenderbar.php");
if($message!=""){
  $dumma = array("");
  $pswfile=$tippauthtxt;
  $datei = fopen($pswfile,"rb");
  while (!feof($datei)) {
    $zeile = fgets($datei,1000);
    $zeile=chop($zeile);
    if($zeile!=""){array_push($dumma,$zeile);}
    }
  fclose($datei);
  array_shift($dumma);
  $subject=$_POST["betreff"];
  $header="From:$aadr\n";
  $para5="-f $aadr";
  $anzemail=0;
  $anztipper=count($dumma);
  if(!isset($start)){$start=1;}
  if(!isset($ende)){$ende=$anztipper;}

  if($emailart==0){
    for($tippernr=$start-1;$tippernr<$ende;$tippernr++){
      $dummb = split("[|]",$dumma[$tippernr]);
      if($dummb[9]!=-1){
        $textmessage=$message;
        $textmessage=str_replace("[nick]",$dummb[0],$textmessage); 
        $textmessage=str_replace("[pass]",$dummb[1],$textmessage); 
        $textmessage=str_replace("[name]",$dummb[3],$textmessage); 
        if(mail($dummb[4],$subject,$textmessage,$header,$para5)){$anzemail++;}else{echo $text[2176];}
        }
      }
    echo $anzemail." ".$text[2175]."<br>";
    }


  elseif($emailart==1){
    $textreminder1=str_replace("\n","&#10;",$message); 
    require(PATH_TO_LMO."/lmo-tippsavecfg.php");
    $now=strtotime("now");
    $then=strtotime("+".$tage." day");

    if($liga=="viewer"){
      $verz=opendir(substr($dirliga,0,-1));
      $dateien=array("");
      while($files=readdir($verz)){
        $ftest=1;
        if($immeralle!=1){
          $ftest=0;
          $ftest1="";
          $ftest1=split("[,]",$ligenzutippen);
          if(isset($ftest1)){
            for($u=0;$u<count($ftest1);$u++){
              if($ftest1[$u]==substr($files,0,-4)){$ftest=1;}
              }
            }
          }
        if($ftest==1){array_push($dateien,$files);}
        }
      closedir($verz);
      array_shift($dateien);
      sort($dateien);
      
      $anzligen=count($dateien);
    
      $teams=array_pad($array,65,"");
      $teams[0]="___";
      $liga=array("");
      $titel=array("");
      $lmtype=array("");
      $anzst=array("");
      $spieltag=array("");
      $modus=array("");
      $spiel=array("");
      $teama=array("");
      $teamb=array("");
      $zeit=array("");
      
      $anzspiele=0;

      for($lnr=0;$lnr<$anzligen;$lnr++){
        $file=$dirliga.$dateien[$lnr];
        require(PATH_TO_LMO."/lmo-tippemailviewer.php");
        }

      $goaltipp = array_pad(array("_"),$anzspiele+1,"_");

      array_shift($liga);
      array_shift($titel);
      array_shift($lmtype);
      array_shift($anzst);
      array_shift($spieltag);
      array_shift($modus);
      array_shift($spiel);
      array_shift($teama);
      array_shift($teamb);
      array_shift($zeit);
      
      for($tippernr=$start-1;$tippernr<$ende;$tippernr++){
        $dummb = split("[|]",$dumma[$tippernr]);
        if($dummb[10]!=-1 && $dummb[4]!=""){
          for($i=0;$i<$anzspiele;$i++){$goaltipp[$i]="_";}
          $textmessage=$message;
          $lliga="";
          $lspieltag="";
          $spiele="";
          for($i=0;$i<$anzspiele;$i++){
            if($i==0 || $liga[$i]!=$liga[$i-1]){
              $tippfile=$dirtipp.$liga[$i]."_".$dummb[0].".tip";
              if(file_exists($tippfile)){require(PATH_TO_LMO."/lmo-tippemailviewer1.php");$ktipp=1;}else{$ktipp=0;}
              }
            if($ktipp==1){
              if($goaltipp[$i]=="_"){
                if($lspieltag!=$spieltag[$i] && $lliga!=$liga[$i]){$spiele=$spiele."\n".$titel[$i].":\n";}
                if($lspieltag!=$spieltag[$i]){
                  if($lmtype[$i]==0){$spiele=$spiele.$spieltag[$i].".".$text[2].":\n";}
                  else{
                    if($spieltag[$i]==$anzst[$i]){$j=$text[374];}
                    elseif($spieltag[$i]==$anzst[$i]-1){$j=$text[373];}
                    elseif($spieltag[$i]==$anzst[$i]-2){$j=$text[372];}
                    elseif($spieltag[$i]==$anzst[$i]-3){$j=$text[371];}
                    else{$j=$spieltag[$i].". ".$text[370];}
                    $spiele=$spiele.$j.":\n";
                    }
                  }
                $spiele=$spiele.$text[2087]." ".$zeit[$i].": ".$teama[$i]." - ".$teamb[$i]."\n";
                $lliga=$liga[$i];
                $lspieltag=$spieltag[$i];
                }
              }
            }
          if($spiele!=""){
            $textmessage=str_replace("[nick]",$dummb[0],$textmessage); 
            $textmessage=str_replace("[pass]",$dummb[1],$textmessage); 
            $textmessage=str_replace("[name]",$dummb[3],$textmessage); 
            $textmessage=str_replace("[spiele]",$spiele,$textmessage); 
            if(mail($dummb[4],$subject,$textmessage,$header,$para5)){$anzemail++;}else{echo $text[2176];}
            }
          }
        }
      }
    elseif($liga!="" && $tage>0 && $st>=0){
      $file=$dirliga.$liga;
      if($st>0){require(PATH_TO_LMO."/lmo-openfiledat.php");}elseif($st==0){require(PATH_TO_LMO."/lmo-openfile.php");}
  
      for($tippernr=$start-1;$tippernr<$ende;$tippernr++){
        $dummb = split("[|]",$dumma[$tippernr]);
        if($dummb[10]!=-1 && $dummb[4]!=""){
          $textmessage=$message;
          $tippfile=$dirtipp.substr($file,strrpos($file,"/")+1,-4)."_".$dummb[0].".tip";
          $spiele="";
          if(file_exists($tippfile)){
            if($st>0){
              require(PATH_TO_LMO."/lmo-tippopenfile.php");
              $st0=$st-1;
              $anzst1=$st;
              }
            elseif($st==0){
              require(PATH_TO_LMO."/lmo-tippopenfileall.php");
              $st0=0;
              $anzst1=$anzst;
              }
            for(;$st0<=$anzst1;$st0++){
              if($imvorraus<0 || $st0<=($stx+$imvorraus)){
                if($lmtype==0){
                  for($dd=0;$dd<$anzsp;$dd++){
                    $zeit=zeit($mterm[$st0][$dd],$datum1[$st0],$datum2[$st0]);
                    if($now<$zeit && $then>$zeit){
                      if((($st==0 && $goaltippa[$st0][$dd]=="_") || ($st>0 && $goaltippa[$dd]=="_")) && $teama[$st0][$dd]>0){
                        $spiele=$spiele.$teams[$teama[$st0][$dd]]." - ".$teams[$teamb[$st0][$dd]]." (".$text[2087]." ".strftime("%A, %d.%m.%Y %R", $zeit).")\n"; 
                        }
                      }
                    }
                  }
                elseif($lmtype!=0){
                  for($dd=0;$dd<$anzsp;$dd++){
                    for($ddd=0;$ddd<$modus[$st0];$ddd++){
                      $zeit=zeit($mterm[$st0][$dd][$ddd],$datum1[$st0],$datum2[$st0]);
                      if($now<$zeit && $then>$zeit){
                        if((($st==0 && $goaltippa[$st0][$dd][$ddd]=="_") || ($st>0 && $goaltippa[$dd][$ddd]=="_")) && $teama[$st0][$dd]>0){
                          $spiele=$spiele.$teams[$teama[$st0][$dd]]." - ".$teams[$teamb[$st0][$dd]]." (".$text[2087]." ".strftime("%A, %d.%m.%Y %R", $zeit).")\n"; 
                          }
                        }
                      }
                    }
                  }
                }
              } // ende for($spieltag=1;$spieltag<=$anzst;$spieltag++)
            
            if($spiele!=""){
              $textmessage=str_replace("[nick]",$dummb[0],$textmessage); 
              $textmessage=str_replace("[pass]",$dummb[1],$textmessage); 
              $textmessage=str_replace("[name]",$dummb[3],$textmessage); 
              $textmessage=str_replace("[spiele]",$spiele,$textmessage); 
              if(mail($dummb[4],$subject,$textmessage,$header,$para5)){$anzemail++;}else{echo $text[2176];}
              }
            }
          } // ende if($dummb[10]!=-1)
        } // ende for($tippernr=0;$tippernr<$anztipper;$tippernr++)
      }
      echo $anzemail." ".$text[2175]."<br>";
    } // ende if($emailart==1)

  elseif($emailart==2 && $adressat!=""){
    $dummb = split("[|]",$dumma[0]);
    for($i=0;$i<$anztipper && $adressat!=$dummb[0];$i++){$dummb = split("[|]",$dumma[$i]);}
    $message=str_replace("[nick]",$dummb[0],$message); 
    $message=str_replace("[pass]",$dummb[1],$message); 
    $message=str_replace("[name]",$dummb[3],$message); 
    if(mail($dummb[4],$subject,$message,$header,$para5)){echo "1 ".$text[2175]."<br>";}else{echo $text[2176];}
    }
  }
?>