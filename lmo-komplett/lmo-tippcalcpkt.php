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
// Jocker-Hack 001
// Copyright (C) 2002 by Ufuk Altinkaynak
// ufuk.a@arcor.de
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
function tipppunkte($gta0, $gtb0, $ga0, $gb0, $msieg, $msp, $text0, $text1, $jkspfaktor0, $mtipp){// wieviel Punkte gibts für den Tipp
 
  global $tippmodus;
  global $entscheidungnv;
  global $entscheidungie;
  global $rergebnis;
  global $rtendenzdiff;
  global $rtendenz;
  global $rtor;
  global $rtendenztor;
  global $rtendenzremis;
  global $rremis;
  global $gtpunkte;
  global $showzus;

  if($showzus==1){
    if($tippmodus==1){
      global $punkte1;
      global $punkte2;
      global $punkte3;
      global $punkte4;
      }
    global $punkte5;
    global $punkte6;
    }

  if($mtipp==1){$punktespiel=-2;} // Spiel nicht werten
  elseif($tippmodus==1){ // Ergebnis-Tippmodus
    if($msieg==0){
      if($msp==$text0 && $entscheidungnv==1){
      	if($gtb0==$gta0){
      	  if($rtendenzremis==1){
      	    $punktespiel=$rtendenz;
      	    if($showzus==1){$punkte3++;}
      	    }
      	  else{
      	    $punktespiel=$rtendenzdiff;
      	    if($showzus==1){$punkte2++;}
      	    }
      	  }
      	else{$punktespiel=0;}
      	}
      elseif($msp==$text1 && $entscheidungie==1){
      	if($gtb0==$gta0){
      	  if($rtendenzremis==1){
      	    $punktespiel=$rtendenz;
      	    if($showzus==1){$punkte3++;}
      	    }
      	  else{
      	    $punktespiel=$rtendenzdiff;
      	    if($showzus==1){$punkte2++;}
      	    }
      	  }
      	else{$punktespiel=0;}
      	}
      elseif($gta0==$ga0 && $gtb0==$gb0){
      	$punktespiel=$rergebnis;
      	if($showzus==1){$punkte1++;}
      	}
      elseif($ga0==$gb0 && $gta0==$gtb0 && $rtendenzremis==1){ // richtiger 0-Tipp
      	$punktespiel=$rtendenz;
      	if($showzus==1){$punkte3++;}
      	}
      elseif($gtb0-$gta0==$gb0-$ga0){
      	$punktespiel=$rtendenzdiff;
      	if($showzus==1){$punkte2++;}
      	} // richtige Tendenz und Tordiff
      elseif(($gtb0>$gta0 && $gb0>$ga0) || ($gtb0<$gta0 && $gb0<$ga0)){
      	$punktespiel=$rtendenz;
      	if($showzus==1){$punkte3++;}
      	if($rtendenztor==1 && ($gta0==$ga0 || $gtb0==$gb0)){
      	  $punktespiel+=$rtor;
      	  if($showzus==1){$punkte4++;}
      	  }
      	}
      elseif($gta0==$ga0 || $gtb0==$gb0){
      	$punktespiel=$rtor;
      	if($showzus==1){$punkte4++;}
      	}
      else{$punktespiel=0;}
      }
    elseif($gtpunkte==2 && ($msieg==1 || $msieg==2 || $msieg==3)){ // GT-Entscheidung nicht werten
      $punktespiel=-1;
      }
    elseif($msieg==1){ // GT-Entscheidung
      if($gtb0-$gta0<0){
      	if($gtpunkte==1){
      	  $punktespiel=$rtendenz;
      	  if($showzus==1){$punkte3++;}
      	  }
      	else{
      	  $punktespiel=$rtendenzdiff;
      	  if($showzus==1){$punkte2++;}
      	  }
      	}
      else{$punktespiel=0;}
      }
    elseif($msieg==2){ // GT-Entscheidung
      if($gtb0-$gta0>0){
      	if($gtpunkte==1){
      	  $punktespiel=$rtendenz;
      	  if($showzus==1){$punkte3++;}
      	  }
      	else{
      	  $punktespiel=$rtendenzdiff;
      	  if($showzus==1){$punkte2++;}
      	  }
      	}
      else{$punktespiel=0;}
      }
    elseif($msieg==3){ // GT-Entscheidung beidseitiges Erg.
      if($gtb0-$gta0==0){
      	if($gtpunkte==1){
      	  $punktespiel=$rtendenz;
      	  if($showzus==1){$punkte3++;}
      	  }
      	else{
      	  $punktespiel=$rtendenzdiff;
      	  if($showzus==1){$punkte2++;}
      	  }
      	}
      else{$punktespiel=0;}
      }
    else {$punktespiel=-1;} // Ergebnis noch nicht eingetragen
    }
  elseif($tippmodus==0){ // Tendenz-Tippmodus
    if($msieg==0){
      if($msp==$text0 && $entscheidungnv==1){ if($gtb0==$gta0){$punktespiel=1;}else{$punktespiel=0;} }
      elseif($msp==$text1 && $entscheidungie==1){ if($gtb0==$gta0){$punktespiel=1;}else{$punktespiel=0;} }
      elseif(($gtb0>$gta0 && $gb0>$ga0) || ($gtb0<$gta0 && $gb0<$ga0) || ($gtb0==$gta0 && $gb0==$ga0)){ $punktespiel=1; }
      else {$punktespiel=0;}
      }
    elseif($gtpunkte==2 && ($msieg==1 || $msieg==2 || $msieg==3)){ // GT-Entscheidung nicht werten
      $punktespiel=-1;
      }
    elseif($msieg==1){ // GT-Entscheidung
      if($gtb0-$gta0<0){ $punktespiel=1; }
      else{$punktespiel=0;}
      }
    elseif($msieg==2){ // GT-Entscheidung
      if($gtb0-$gta0>0){ $punktespiel=1; }
      else{$punktespiel=0;}
      }
    elseif($msieg==3){ // GT-Entscheidung beidseitiges Erg.
      if($gtb0-$gta0==0){ $punktespiel=1; }
      else{$punktespiel=0;}
      }
    else {$punktespiel=-1;}
    }
  if($rremis>0 && $punktespiel>0 && $gtb0==$gta0  && $gb0==$ga0){
    $punktespiel+=$rremis;
    if($showzus==1){$punkte5++;}
    }
  if($jkspfaktor0>1 && $punktespiel>0){
    if($showzus==1){$punkte6+=$punktespiel*$jkspfaktor0-$punktespiel;}
    $punktespiel*=$jkspfaktor0;
    }

//  echo $gta0.$gtb0.$ga0.$gb0."->".$punktespiel."<br>";
  return $punktespiel;
  }
?>
