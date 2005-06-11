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
  
  
require(dirname(__FILE__)."/init.php");  

$pgtext1=$text[135];
$pgtext2=$text[136];

$pgst=isset($_GET['pgst'])?$_GET['pgst']:1;
$pgteams=isset($_GET['pgteams'])?$_GET['pgteams']:1;
$pgteam1=isset($_GET['pgteam1'])?$_GET['pgteam1']:'';
$pgteam2=isset($_GET['pgteam2'])?$_GET['pgteam2']:'';
$pgplatz1=isset($_GET['pgplatz1'])?$_GET['pgplatz1']:1;
$pgplatz2=isset($_GET['pgplatz2'])?$_GET['pgplatz2']:'';
$pganz=isset($_GET['pganz'])?$_GET['pganz']:1;

$pgch=isset($_GET['pgch'])?$_GET['pgch']:0;
$pgcl=isset($_GET['pgcl'])?$_GET['pgcl']:0;
$pgck=isset($_GET['pgck'])?$_GET['pgck']:0;
$pguc=isset($_GET['pguc'])?$_GET['pguc']:0;
$pgar=isset($_GET['pgar'])?$_GET['pgar']:0;
$pgab=isset($_GET['pgab'])?$_GET['pgab']:0;


$lmo_faktorhorizontal=round(21-$pgst/4);
$lmo_faktorvertikal=round(17-$pgteams/4);

$hoch = (($pgteams+1) * $lmo_faktorvertikal)+47;
$breit = (($pgst+1) * $lmo_faktorhorizontal)+35;
$vergleich = imagefontwidth(3) * strlen(stripslashes($pgteam1))+3;
if ($pganz == 2) {
  $vergleich += imagefontwidth(3) * strlen(stripslashes($pgteam2))+4;
}
if ($breit < $vergleich) {
  $breit = $vergleich;
}
$image = imagecreate($breit, $hoch);
imageinterlace($image, 0);

$color = isset($lmo_inner_background1)?get_color($lmo_inner_background1):array(255, 255, 255);
$farbe_body = imagecolorallocate($image, $color[0], $color[1], $color[2]);  //Hintergrund

$luminanz=0.3*$color[0] + 0.59*$color[1] + 0.11*$color[2];
$color = $luminanz > 127?array(($color[0]+190-$luminanz),($color[1]+190-$luminanz),($color[2]+190-$luminanz)):array(($color[0]+127-$luminanz),($color[1]+127-$luminanz),($color[2]+127-$luminanz));

$farbe_b = imagecolorallocate($image, $color[0], $color[1], $color[2]);  //Gitter

$color = isset($lmo_inner_color1)?get_color($lmo_inner_color1):array(0, 0, 0);
$farbe_a = imagecolorallocate($image, $color[0], $color[1], $color[2]);  //Schrift

$color = isset($lmo_fieber_color1)?get_color($lmo_fieber_color1):array(0, 0, 255);
$farbe_c = imagecolorallocate($image, $color[0], $color[1], $color[2]);  //Linie1 & Mannschaft1

$color = isset($lmo_fieber_color2)?get_color($lmo_fieber_color2):array(255, 0, 0);
$farbe_d = imagecolorallocate($image, $color[0], $color[1], $color[2]);  //Linie2 & Mannschaft2

$color = isset($lmo_tabelle_background1)?get_color($lmo_tabelle_background1):array(237, 244, 156);
$farbe_e = imagecolorallocate($image, $color[0], $color[1], $color[2]);  //Meister

$color = isset($lmo_tabelle_background2)?get_color($lmo_tabelle_background2):array(204, 205, 254);
$farbe_f = imagecolorallocate($image, $color[0], $color[1], $color[2]);  //Champleague

$color = isset($lmo_tabelle_background3)?get_color($lmo_tabelle_background3):array(166, 238, 237);
$farbe_g = imagecolorallocate($image, $color[0], $color[1], $color[2]);  //Champquali

$color = isset($lmo_tabelle_background4)?get_color($lmo_tabelle_background4):array(192, 255, 192);
$farbe_h = imagecolorallocate($image, $color[0], $color[1], $color[2]);  //UEFA

$color = isset($lmo_tabelle_background6)?get_color($lmo_tabelle_background6):array(255, 187, 208);
$farbe_i = imagecolorallocate($image, $color[0], $color[1], $color[2]);  //Abstieg

$color = isset($lmo_tabelle_background5)?get_color($lmo_tabelle_background5):array(255, 208, 239);
$farbe_j = imagecolorallocate($image, $color[0], $color[1], $color[2]);  //Abstiegsrelegation

imagestring($image, 2, 28, 28+(($pgteams+1) * $lmo_faktorvertikal), $pgtext1, $farbe_a);  //untere Beschriftung (SPIELTAGE)
imagestringup($image, 2, 4, $hoch-28, $pgtext2, $farbe_a);                                //seitliche Beschriftung (PLATZIERUNG)

//Spieltagsbeschriftung vertikal
for($i = 1; $i <= $pgteams; $i++) {
  $j = strval($i);
  if ($i < 10) {
    $j = "0".$j;
  }
  imagestring($image, 1, 18, 30-$lmo_faktorvertikal+$i*$lmo_faktorvertikal, $j, $farbe_a); //links
  imagestring($image, 1, 32-$lmo_faktorhorizontal+($pgst+1)*$lmo_faktorhorizontal, 30-$lmo_faktorvertikal+$i*$lmo_faktorvertikal, $j, $farbe_a); //rechts
}

//Spieltagsbeschriftung horizontal
for($i = 1; $i <= $pgst; $i++) {
  $j = strval($i);
  if ($i < 10) {
    $j = "0".$j;
  }
  imagestring($image, 1, 31-$lmo_faktorhorizontal+$i*$lmo_faktorhorizontal, 18, $j, $farbe_a); //horizontale Spieltagsbeschriftung oben (im, offsetLeft+i*faktor, offsetTop, STNr, farbe)
  imagestring($image, 1, 31-$lmo_faktorhorizontal+$i*$lmo_faktorhorizontal, 30-$lmo_faktorvertikal+(($pgteams+1) * $lmo_faktorvertikal), $j, $farbe_a);  //horizontale Spieltagsbeschriftung unten
}

//Kästchen
for($i = 0; $i < $pgteams; $i++) {
  imagerectangle($image, 29, 28+$i*$lmo_faktorvertikal, (29-$lmo_faktorhorizontal)+(($pgst+1) * $lmo_faktorhorizontal), 28+$lmo_faktorvertikal+($i*$lmo_faktorvertikal), $farbe_b); //horizontal
}
for($i = 0; $i < $pgst; $i++) {
  imagerectangle($image, 29+$i*$lmo_faktorhorizontal, 28, (29+$lmo_faktorhorizontal)+$i*$lmo_faktorhorizontal, 28-$lmo_faktorvertikal+(($pgteams+1)*$lmo_faktorvertikal), $farbe_b); //vertikal
}

$j = 1;
for($i = 1; $i <= $pgteams; $i++) {
  if (($i == 1) && ($pgch != 0)) {
    $j = 2;
    for($k = 1; $k <= $pgst; $k++) {
      imagefill($image, 28+($k * $lmo_faktorhorizontal), 20+($i * $lmo_faktorvertikal), $farbe_e);
    }
  }
  if (($i >= $j) && ($i < $j+$pgcl) && ($pgcl > 0)) {
    for($k = 1; $k <= $pgst; $k++) {
      imagefill($image, 28+($k * $lmo_faktorhorizontal), 20+($i * $lmo_faktorvertikal), $farbe_f);
    }
  }
  if (($i >= $j+$pgcl) && ($i < $j+$pgcl+$pgck) && ($pgck > 0)) {
    for($k = 1; $k <= $pgst; $k++) {
      imagefill($image, 28+($k * $lmo_faktorhorizontal), 20+($i * $lmo_faktorvertikal), $farbe_g);
    }
  }
  if (($i >= $j+$pgcl+$pgck) && ($i < $j+$pgcl+$pgck+$pguc) && ($pguc > 0)) {
    for($k = 1; $k <= $pgst; $k++) {
      imagefill($image, 28+($k * $lmo_faktorhorizontal), 20+($i * $lmo_faktorvertikal), $farbe_h);
    }
  }
  if (($i <= $pgteams) && ($i > $pgteams-$pgab) && ($pgab > 0)) {
    for($k = 1; $k <= $pgst; $k++) {
      imagefill($image, 28+($k * $lmo_faktorhorizontal), 20+($i * $lmo_faktorvertikal), $farbe_i);
    }
  }
  if (($i <= $pgteams-$pgab) && ($i > $pgteams-$pgab-$pgar) && ($pgar > 0)) {
    for($k = 1; $k <= $pgst; $k++) {
      imagefill($image, 28+($k * $lmo_faktorhorizontal), 20+($i * $lmo_faktorvertikal), $farbe_j);
    }
  }
}

imagestring($image, 3, 3, 1, rawurldecode(stripslashes($pgteam1)), $farbe_c);  //Mannschaftsname1
if ($pganz == 2) {
  imagestring($image, 3, $breit-imagefontwidth(3) * strlen(stripslashes($pgteam2))-2, 1, rawurldecode(stripslashes($pgteam2)), $farbe_d); //Mannschaftsname2
}
$linie = explode(',', $pgplatz1);
if ($pganz == 2) {
  $lini2 = explode(',', $pgplatz2);
}
for($i = 1; $i < $pgst; $i++) {
  if ($linie[$i] > 0 && $linie[$i-1] > 0) {
    imageline($image, 30-$lmo_faktorhorizontal/2+($i * $lmo_faktorhorizontal), 29-$lmo_faktorvertikal/2+($linie[$i-1] * $lmo_faktorvertikal), 30-$lmo_faktorhorizontal/2+(($i+1) * $lmo_faktorhorizontal), 29-$lmo_faktorvertikal/2+($linie[$i] * $lmo_faktorvertikal), $farbe_c);
    imageline($image, 29-$lmo_faktorhorizontal/2+($i * $lmo_faktorhorizontal), 29-$lmo_faktorvertikal/2+($linie[$i-1] * $lmo_faktorvertikal), 29-$lmo_faktorhorizontal/2+(($i+1) * $lmo_faktorhorizontal), 29-$lmo_faktorvertikal/2+($linie[$i] * $lmo_faktorvertikal), $farbe_c);
    imageline($image, 30-$lmo_faktorhorizontal/2+($i * $lmo_faktorhorizontal), 30-$lmo_faktorvertikal/2+($linie[$i-1] * $lmo_faktorvertikal), 30-$lmo_faktorhorizontal/2+(($i+1) * $lmo_faktorhorizontal), 30-$lmo_faktorvertikal/2+($linie[$i] * $lmo_faktorvertikal), $farbe_c);
    imageline($image, 29-$lmo_faktorhorizontal/2+($i * $lmo_faktorhorizontal), 30-$lmo_faktorvertikal/2+($linie[$i-1] * $lmo_faktorvertikal), 29-$lmo_faktorhorizontal/2+(($i+1) * $lmo_faktorhorizontal), 30-$lmo_faktorvertikal/2+($linie[$i] * $lmo_faktorvertikal), $farbe_c);
  }
  if ($pganz == 2) {
    if ($lini2[$i] > 0 && $lini2[$i-1] > 0) {
      imageline($image, 30-$lmo_faktorhorizontal/2+($i * $lmo_faktorhorizontal), 29-$lmo_faktorvertikal/2+($lini2[$i-1] * $lmo_faktorvertikal), 30-$lmo_faktorhorizontal/2+(($i+1) * $lmo_faktorhorizontal), 29-$lmo_faktorvertikal/2+($lini2[$i] * $lmo_faktorvertikal), $farbe_d);
      imageline($image, 29-$lmo_faktorhorizontal/2+($i * $lmo_faktorhorizontal), 29-$lmo_faktorvertikal/2+($lini2[$i-1] * $lmo_faktorvertikal), 29-$lmo_faktorhorizontal/2+(($i+1) * $lmo_faktorhorizontal), 29-$lmo_faktorvertikal/2+($lini2[$i] * $lmo_faktorvertikal), $farbe_d);
      imageline($image, 30-$lmo_faktorhorizontal/2+($i * $lmo_faktorhorizontal), 30-$lmo_faktorvertikal/2+($lini2[$i-1] * $lmo_faktorvertikal), 30-$lmo_faktorhorizontal/2+(($i+1) * $lmo_faktorhorizontal), 30-$lmo_faktorvertikal/2+($lini2[$i] * $lmo_faktorvertikal), $farbe_d);
      imageline($image, 29-$lmo_faktorhorizontal/2+($i * $lmo_faktorhorizontal), 30-$lmo_faktorvertikal/2+($lini2[$i-1] * $lmo_faktorvertikal), 29-$lmo_faktorhorizontal/2+(($i+1) * $lmo_faktorhorizontal), 30-$lmo_faktorvertikal/2+($lini2[$i] * $lmo_faktorvertikal), $farbe_d);
    }
  }
}

header("Content-Type: image/png");
imagepng($image);
 
function get_color(&$styleclass) {
  if (strlen($styleclass) == 4) {
    return(array(hexdec(substr($styleclass, 1, 1).substr($styleclass, 1, 1)), hexdec(substr($styleclass, 2, 1).substr($styleclass, 2, 1)), hexdec(substr($styleclass, 3, 1).substr($styleclass, 3, 1))));
  } elseif (strlen($styleclass) == 7) {
    return(array(hexdec(substr($styleclass, 1, 2)), hexdec(substr($styleclass, 3, 2)), hexdec(substr($styleclass, 5, 2))));
  }
  return false;
}

?>