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
  require("init.php");
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
  $farbe_a=imagecolorallocate($image,0,0,0);  //Schrift
  $farbe_b=imagecolorallocate($image,192,192,192);  //Gitter
  $farbe_c=imagecolorallocate($image,0,0,255);  //Linie1 & Mannschaft1
  $farbe_d=imagecolorallocate($image,255,0,0);  //Linie2 & Mannschaft2
  isset($tabftab1)?$color=get_color($tabftab1): $color=array(237,244,156);
  $farbe_e=imagecolorallocate($image,$color[0],$color[1],$color[2]);  //Meister
  isset($tabftab2)?$color=get_color($tabftab2): $color=array(204,205,254);
  $farbe_f=imagecolorallocate($image,$color[0],$color[1],$color[2]);  //Champleague
  isset($tabftab3)?$color=get_color($tabftab3): $color=array(166,238,237);
  $farbe_g=imagecolorallocate($image,$color[0],$color[1],$color[2]);  //Champquali
  isset($tabftab4)?$color=get_color($tabftab4): $color=array(192,255,192);
  $farbe_h=imagecolorallocate($image,$color[0],$color[1],$color[2]);  //UEFA
  isset($tabftab6)?$color=get_color($tabftab6): $color=array(255,187,208);
  $farbe_i=imagecolorallocate($image,$color[0],$color[1],$color[2]);  //Abstieg
  isset($tabftab5)?$color=get_color($tabftab5): $color=array(255,208,239);
  $farbe_j=imagecolorallocate($image,$color[0],$color[1],$color[2]);  //Abstiegsrelegation
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
  $linie = explode(',',$pgplatz1);
  if($pganz==2){$lini2 = explode(',',$pgplatz2);}
  for($i=1;$i<$pgst;$i++){
    if($linie[$i]>0 && $linie[$i-1]>0){
      imageline($image,24+($i*12),22+($linie[$i-1]*12),24+(($i+1)*12),22+($linie[$i]*12),$farbe_c);
      imageline($image,23+($i*12),22+($linie[$i-1]*12),23+(($i+1)*12),22+($linie[$i]*12),$farbe_c);
      imageline($image,24+($i*12),23+($linie[$i-1]*12),24+(($i+1)*12),23+($linie[$i]*12),$farbe_c);
      imageline($image,23+($i*12),23+($linie[$i-1]*12),23+(($i+1)*12),23+($linie[$i]*12),$farbe_c);
      }
    if($pganz==2){
      if($lini2[$i]>0 && $lini2[$i-1]>0){
        imageline($image,24+($i*12),22+($lini2[$i-1]*12),24+(($i+1)*12),22+($lini2[$i]*12),$farbe_d);
        imageline($image,23+($i*12),22+($lini2[$i-1]*12),23+(($i+1)*12),22+($lini2[$i]*12),$farbe_d);
        imageline($image,24+($i*12),23+($lini2[$i-1]*12),24+(($i+1)*12),23+($lini2[$i]*12),$farbe_d);
        imageline($image,23+($i*12),23+($lini2[$i-1]*12),23+(($i+1)*12),23+($lini2[$i]*12),$farbe_d);
        }
      }
    }
  header("Content-Type: image/png");
  imagepng($image);
  
  function get_color(&$styleclass) {
    if (strlen($styleclass)==4) {
      return(array(hexdec(substr($styleclass,1,1).substr($styleclass,1,1)),hexdec(substr($styleclass,2,1).substr($styleclass,2,1)),hexdec(substr($styleclass,3,1).substr($styleclass,3,1))));
    }elseif (strlen($styleclass)==7) {
      return(array(hexdec(substr($styleclass,1,2)),hexdec(substr($styleclass,3,2)),hexdec(substr($styleclass,5,2))));
    }
    return false;
  }
?>