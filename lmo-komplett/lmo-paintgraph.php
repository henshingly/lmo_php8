<?PHP
// 
// LigaManager Online 3.02b
// Copyright (C) 1997-2002 by Frank Hollwitz
// webmaster@hollwitz.de / http://php.hollwitz.de
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
  $hoch=(($pgteams+1)*12)+47;
  $breit=(($pgst+1)*12)+35;
  $vergleich = imagefontwidth(3)*strlen(stripslashes($pgteam1))+3;
  if ($pganz==2) {
    $vergleich += imagefontwidth(3)*strlen(stripslashes($pgteam2))+4;
  }
  if ($breit<$vergleich) {
    $breit=$vergleich;
  }
  $image = imagecreate($breit,$hoch);
  imageinterlace($image,1);
  $farbe_body=imagecolorallocate($image,255,255,255);
  $farbe_a=imagecolorallocate($image,0,0,0);
  $farbe_b=imagecolorallocate($image,192,192,192);
  $farbe_c=imagecolorallocate($image,0,0,255);
  $farbe_d=imagecolorallocate($image,255,0,0);
  $farbe_e=imagecolorallocate($image,237,244,156);
  $farbe_f=imagecolorallocate($image,204,205,254);
  $farbe_g=imagecolorallocate($image,166,238,237);
  $farbe_h=imagecolorallocate($image,192,255,192);
  $farbe_i=imagecolorallocate($image,255,187,208);
  $farbe_j=imagecolorallocate($image,255,208,239);
  imagestring($image,2,28,28+(($pgteams+1)*12), $pgtext1, $farbe_a);
  imagestringup($image,2,4,$hoch-28, $pgtext2, $farbe_a);
  for($i=1;$i<=$pgteams;$i++){
    $j=strval($i);
    if($i<10){$j="0".$j;}
    imagestring($image,1,18,18+($i*12), $j, $farbe_a);
    imagestring($image,1,20+(($pgst+1)*12),18+($i*12), $j, $farbe_a);
    }
  for($i=1;$i<=$pgst;$i++){
    $j=strval($i);
    if($i<10){$j="0".$j;}
    imagestring($image,1,19+($i*12),18, $j, $farbe_a);
    imagestring($image,1,19+($i*12),18+(($pgteams+1)*12), $j, $farbe_a);
    }
  for($i=0;$i<$pgteams;$i++){imagerectangle($image,29,28+($i*12),17+(($pgst+1)*12),40+($i*12),$farbe_b);}
  for($i=0;$i<$pgst;$i++){imagerectangle($image,29+($i*12),28,41+($i*12),16+(($pgteams+1)*12),$farbe_b);}
  $j=1;
  for($i=1;$i<=$pgteams;$i++){
    if(($i==1) && ($pgch!=0)){$j=2;for($k=1;$k<=$pgst;$k++){imagefill($image,20+($k*12),20+($i*12),$farbe_e);}}
    if(($i>=$j) && ($i<$j+$pgcl) && ($pgcl>0)){for($k=1;$k<=$pgst;$k++){imagefill($image,20+($k*12),20+($i*12),$farbe_f);}}
    if(($i>=$j+$pgcl) && ($i<$j+$pgcl+$pgck) && ($pgck>0)){for($k=1;$k<=$pgst;$k++){imagefill($image,20+($k*12),20+($i*12),$farbe_g);}}
    if(($i>=$j+$pgcl+$pgck) && ($i<$j+$pgcl+$pgck+$pguc) && ($pguc>0)){for($k=1;$k<=$pgst;$k++){imagefill($image,20+($k*12),20+($i*12),$farbe_h);}}
    if(($i<=$pgteams) && ($i>$pgteams-$pgab) && ($pgab>0)){for($k=1;$k<=$pgst;$k++){imagefill($image,20+($k*12),20+($i*12),$farbe_i);}}
    if(($i<=$pgteams-$pgab) && ($i>$pgteams-$pgab-$pgar) && ($pgar>0)){for($k=1;$k<=$pgst;$k++){imagefill($image,20+($k*12),20+($i*12),$farbe_j);}}
    }
  imagestring($image,3,3,1, stripslashes($pgteam1), $farbe_c);
  if($pganz==2){
    imagestring($image,3,$breit-imagefontwidth(3)*strlen(stripslashes($pgteam2))-2,1, stripslashes($pgteam2), $farbe_d);
    }
  $linie = split("[,]",$pgplatz1);
  if($pganz==2){$lini2 = split("[,]",$pgplatz2);}
  for($i=1;$i<$pgst;$i++){
    if($linie[$i]>0){
      imageline($image,24+($i*12),22+($linie[$i-1]*12),24+(($i+1)*12),22+($linie[$i]*12),$farbe_c);
      imageline($image,23+($i*12),22+($linie[$i-1]*12),23+(($i+1)*12),22+($linie[$i]*12),$farbe_c);
      imageline($image,24+($i*12),23+($linie[$i-1]*12),24+(($i+1)*12),23+($linie[$i]*12),$farbe_c);
      imageline($image,23+($i*12),23+($linie[$i-1]*12),23+(($i+1)*12),23+($linie[$i]*12),$farbe_c);
      }
    if($pganz==2){
      if($lini2[$i]>0){
        imageline($image,24+($i*12),22+($lini2[$i-1]*12),24+(($i+1)*12),22+($lini2[$i]*12),$farbe_d);
        imageline($image,23+($i*12),22+($lini2[$i-1]*12),23+(($i+1)*12),22+($lini2[$i]*12),$farbe_d);
        imageline($image,24+($i*12),23+($lini2[$i-1]*12),24+(($i+1)*12),23+($lini2[$i]*12),$farbe_d);
        imageline($image,23+($i*12),23+($lini2[$i-1]*12),23+(($i+1)*12),23+($lini2[$i]*12),$farbe_d);
        }
      }
    }
  header("Content-Type: image/png");
  imagepng($image);
?>
