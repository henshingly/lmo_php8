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
// Tipp noch änderbar oder nicht
function tippaenderbar($mterm0,$datum1,$datum2){
  global $plus; // eine Minute Sicherheitsabstand zwischen Seitenaufruf und abspeichern
  global $imvorraus;
  global $st;
  global $stx;
  global $tippbis;
  global $tippohne;
  global $deftime;

  if($imvorraus>=0 && $st>($stx+$imvorraus)){
    $btip=false;
    }
  else{
    $btip=false;
    $now=strtotime("+".$tippbis+$plus." minute");
    if($mterm0>0){
      if($now<$mterm0){$btip=true;}
      }
    else{
      if($datum1!=""){
        if($tippohne==1 && $deftime>0){$datum1a=mktime(substr($deftime,0,2), substr($deftime,3,2), 0, substr($datum1,3,2), substr($datum1,0,2), substr($datum1,-4));}
        else{$datum1a=mktime(0, 0, 0, substr($datum1,3,2), substr($datum1,0,2), substr($datum1,-4));}
        
        if($now<$datum1a){$btip=true;}
        }
      elseif($datum2!=""){
        if($tippohne==1 && $deftime>0){$datum1a=mktime(substr($deftime,0,2), substr($deftime,3,2), 0, substr($datum2,3,2), substr($datum2,0,2), substr($datum2,-4));}
        else{$datum1a=mktime(0, 0, 0, substr($datum2,3,2), substr($datum2,0,2), substr($datum2,-4));}
        
        if($now<$datum1a){$btip=true;}
        }
      }
    }
  return $btip;
  } 

function zeit($mterm0,$datum1,$datum2){
  global $tippohne;
  global $deftime;
  global $tippbis;

  if($mterm0>0){$zeit=$mterm0;}
  elseif($datum1!=""){
    if($tippohne==1 && $deftime>0){$zeit=mktime(substr($deftime,0,2), substr($deftime,3,2), 0, substr($datum1,3,2), substr($datum1,0,2), substr($datum1,-4));}
    else{$zeit=mktime(0, 0, 0, substr($datum1,3,2), substr($datum1,0,2), substr($datum1,-4));}
    }
  elseif($datum2!=""){
    if($tippohne==1 && $deftime>0){$zeit=mktime(substr($deftime,0,2), substr($deftime,3,2), 0, substr($datum2,3,2), substr($datum2,0,2), substr($datum2,-4));}
    else{$zeit=mktime(0, 0, 0, substr($datum2,3,2), substr($datum2,0,2), substr($datum2,-4));}
    }
  else{$zeit="";}
  
  if($zeit!=""){$zeit-=$tippbis*60;}
  return $zeit;
  } 
?>
