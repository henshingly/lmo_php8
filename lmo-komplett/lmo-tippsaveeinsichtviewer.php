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
require_once(PATH_TO_LMO."/lmo-tipptest.php");
if($einsichtfile!=""){
  //if(decoct(fileperms($einsichtfile))!=100777){chmod ($einsichtfile, 0777);}
  if(substr($einsichtfile,-4)==".ein"){
    $daten = array("");
    if(file_exists($einsichtfile)){
      $datei = fopen($einsichtfile,"rb");
      while (!feof($datei)) {
        $zeile = fgets($datei,1000);
        $zeile=trim(chop($zeile));
        if($zeile!=""){array_push($daten,$zeile);}
        }
      fclose($datei);
      }

    $datei = fopen($einsichtfile,"wb");
    if (!$datei) {
      echo "<font color=\"#ff0000\">".$text[283]."</font>";
      exit;
      }
    flock($datei,2);

    $nick="";
    $nick1=0;
    $nick2=-1;
    for($l=0;$l<count($daten);$l++){
      if((substr($daten[$l],0,1)=="[") && (substr($daten[$l],-1)=="]")){
        $nick=substr($daten[$l],1,-1);
        if($nick==$lmotippername){$nick1=$l;$nick2=$l;}
        }
      if($nick!=$lmotippername){ //////////// nur die unveränderten Tipps werden zurückgeschrieben
        fputs($datei,$daten[$l]."\n");
        }
      elseif($daten[$l]!=""){$nick2=$l;}
      }

    for($l=$nick1;$l<=$nick2;$l++){ // am Ende getippte dazu schreiben
      if(substr($daten[$l],0,1)=="["){
        fputs($datei,$daten[$l]."\n");
        $jksave=0;
        for($k=$start2;$k<=$i;$k++){ // getippte dazu schreiben
          if($jksave==0){
            if($jksp[$k]>0){
              fputs($datei,"@".$jksp[$k]."@\n");
              $jksave=1;
              }
            elseif(substr($daten[$l+1],0,1)=="@"){
              $l++;
              fputs($datei,$daten[$l]."\n");
              $jksave=1;
              }
            }
          if($tippa[$k]=="_"){fputs($datei,"GA".$spiel[$k]."=-1\n");}
            elseif($tippa[$k]==""){fputs($datei,"GA".$spiel[$k]."=-1\n");}
            else{fputs($datei,"GA".$spiel[$k]."=".$tippa[$k]."\n");}
          if($tippb[$k]=="_"){fputs($datei,"GB".$spiel[$k]."=-1\n");}
            elseif($tippb[$k]==""){fputs($datei,"GB".$spiel[$k]."=-1\n");}
            else{fputs($datei,"GB".$spiel[$k]."=".$tippb[$k]."\n");}
          }
        }
      elseif($daten[$l]!="" && substr($daten[$l],0,1)!="@"){
        for($k=$start2;$k<=$i;$k++){
          $sp=substr($daten[$l],2,strpos($daten[$l],"=")-2);
          if($sp==$spiel[$k]){
            break; // nicht zurückschreiben
            }
          }
        if($k==($i+1)){fputs($datei,$daten[$l]."\n");}
        }
      }

    if($nick2==-1){ // keine bisherigen Tipps vom Tipper
      fputs($datei,"[".$lmotippername."]"."\n");
      if($jksp[$start2]>0){fputs($datei,"@".$jksp[$start2]."@\n");}
      for($k=$start2;$k<=$i;$k++){ // getippte dazu schreiben
        if($tippa[$k]=="_"){fputs($datei,"GA".$spiel[$k]."=-1\n");}
          elseif($tippa[$k]==""){fputs($datei,"GA".$spiel[$k]."=-1\n");}
          else{fputs($datei,"GA".$spiel[$k]."=".$tippa[$k]."\n");}
        if($tippb[$k]=="_"){fputs($datei,"GB".$spiel[$k]."=-1\n");}
          elseif($tippb[$k]==""){fputs($datei,"GB".$spiel[$k]."=-1\n");}
          else{fputs($datei,"GB".$spiel[$k]."=".$tippb[$k]."\n");}
        }
      }
    
    flock($datei,3);
    fclose($datei);
    }

  clearstatcache();
  }
?>