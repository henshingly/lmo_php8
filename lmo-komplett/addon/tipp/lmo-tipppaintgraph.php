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
  
  

require_once(dirname(__FILE__).'/../../init.php');

if ($max < 1) {
  $max = 10;
  $min = 1;
} else {
  $min = $max;
}
 
if ($kmodus < 4) {
  $linie = explode(',', $pgplatz1);
  for($i = 0; $i < count($linie)-1; $i++) {
    if (strlen($linie[$i]) > 0) {
      if ($linie[$i] < $min) {
        $min = $linie[$i];
      }
    }
  }
  if ($pganz == 2) {
    $lini2 = explode(',', $pgplatz2);
    for($i = 0; $i < count($lini2)-1; $i++) {
      if (strlen($lini2[$i]) > 0) {
        if ($lini2[$i] < $min) {
          $min = $lini2[$i];
        }
      }
    }
  }
}
if ($kmodus > 2) {
  $liniea = explode(',', $pgplatz1a);
  for($i = 0; $i < count($liniea)-1; $i++) {
    if (strlen($liniea[$i]) > 0) {
      if ($liniea[$i] < $min) {
        $min = $liniea[$i];
      }
    }
  }
  if ($pganz == 2) {
    $lini2a = explode(',', $pgplatz2a);
    for($i = 0; $i < count($lini2a)-1; $i++) {
      if (strlen($lini2a[$i]) > 0) {
        if ($lini2a[$i] < $min) {
          $min = $lini2a[$i];
        }
      }
    }
  }
}
 
if ($kmodus < 4) {
  for($i = 0; $i < count($linie)-1; $i++) {
    if (strlen($linie[$i]) > 0) {
      if ($kmodus == 1) {
        $linie[$i] = $max-$linie[$i];
      } else {
        $linie[$i] -= $min;
      }
    }
  }
  if ($pganz == 2) {
    for($i = 0; $i < count($lini2)-1; $i++) {
      if (strlen($lini2[$i]) > 0) {
        if ($kmodus == 1) {
          $lini2[$i] = $max-$lini2[$i];
        } else {
          $lini2[$i] -= $min;
        }
      }
    }
  }
}
if ($kmodus > 2) {
  for($i = 0; $i < count($liniea)-1; $i++) {
    if (strlen($liniea[$i]) > 0) {
      $liniea[$i] -= $min;
    }
  }
  if ($pganz == 2) {
    for($i = 0; $i < count($lini2a)-1; $i++) {
      if (strlen($lini2a[$i]) > 0) {
        $lini2a[$i] -= $min;
      }
    }
  }
}
 
if (($max-$min) > 0) {
  $khoch = round(240/($max-$min));
} else {
  $khoch = 12;
}
 
if ($khoch > 12) {
  $khoch = 12;
}
if ($khoch < 1) {
  $khoch = 1;
} elseif(($max-$min) < 21) {
  $khoch = 12;
}
 
$hoch = (($max-$min+1) * $khoch+12)+47;
$breit = (($pgst+1) * 12)+35;
$image = imagecreate($breit, $hoch);

$color = isset($lmo_inner_background1)?get_color($lmo_inner_background1):array(255, 255, 255);
$farbe_body = imagecolorallocate($image, $color[0], $color[1], $color[2]);  //Hintergrund

$luminanz=0.3*$color[0] + 0.59*$color[1] + 0.11*$color[2];
$color = $luminanz > 127?array(($color[0]+190-$luminanz),($color[1]+190-$luminanz),($color[2]+190-$luminanz)):array(($color[0]+127-$luminanz),($color[1]+127-$luminanz),($color[2]+127-$luminanz));

$farbe_b = imagecolorallocate($image, $color[0], $color[1], $color[2]);  //Gitter

$color = isset($lmo_inner_color1)?get_color($lmo_inner_color1):array(0, 0, 0);
$farbe_a = imagecolorallocate($image, $color[0], $color[1], $color[2]);  //Schrift


$farbe_c = imagecolorallocate($image, 0, 0, 255); // blau
$farbe_c1 = imagecolorallocate($image, 0, 0, 128);
$farbe_d = imagecolorallocate($image, 255, 0, 0); // rot
$farbe_d1 = imagecolorallocate($image, 128, 0, 0);


if ($kmodus > 1) {
  $color = isset($lmo_tabelle_background1)?get_color($lmo_tabelle_background1):array(237, 244, 156);
  $farbe_e = imagecolorallocate($image, $color[0], $color[1], $color[2]);  //Meister
  
  $color = isset($lmo_tabelle_background2)?get_color($lmo_tabelle_background2):array(204, 205, 254);
  $farbe_f = imagecolorallocate($image, $color[0], $color[1], $color[2]);  //Champleague
  
  $color = isset($lmo_tabelle_background3)?get_color($lmo_tabelle_background3):array(166, 238, 237);
  $farbe_g = imagecolorallocate($image, $color[0], $color[1], $color[2]);  //Champquali
}

imagestring($image, 2, 28, 28+(($max-$min+1) * $khoch+12), $pgtext1, $farbe_a);
imagestringup($image, 2, 4, $hoch-28, $pgtext2, $farbe_a);

for($i = $min; $i <= $max; $i++) {
  $j = strval($i);
  if ($kmodus == 1) {
    $j = $max-$j+$min;
  }
  if ($j < 10) {
    $j = "0".$j;
  }
  if (($i-$min)%(13-$khoch) == 0) {
    imagestring($image, 1, 18, 24+($khoch/2)+(($i-$min) * $khoch), $j, $farbe_a);
    imagestring($image, 1, 20+(($pgst+1) * 12), 24+($khoch/2)+(($i-$min) * $khoch), $j, $farbe_a);
  }
}
 
for($i = 1; $i <= $pgst; $i++) {
  $j = strval($i);
  if ($i < 10) {
    $j = "0".$j;
  }
  imagestring($image, 1, 19+($i * 12), 18, $j, $farbe_a);
  imagestring($image, 1, 19+($i * 12), 18+(($max-$min+1) * $khoch+12), $j, $farbe_a);
}
for($i = $min; $i <= $max; $i++) {
  imagerectangle($image, 29, 28+(($i-$min) * $khoch), 17+(($pgst+1) * 12), 28+$khoch+(($i-$min) * $khoch), $farbe_b);
}
for($i = 0; $i < $pgst; $i++) {
  imagerectangle($image, 29+($i * 12), 28, 41+($i * 12), 16+(($max-$min+1) * $khoch+12), $farbe_b);
}
$j = 1;
if ($kmodus > 1 && $khoch > 1) {
  for($i = $min; $i <= $max; $i++) {
    if ($i == 1) {
      for($k = 1; $k <= $pgst; $k++) {
        imagefill($image, 20+($k * 12), 29+(($i-$min) * $khoch), $farbe_e);
      }
    }
    if ($i == 2) {
      for($k = 1; $k <= $pgst; $k++) {
        imagefill($image, 20+($k * 12), 29+(($i-$min) * $khoch), $farbe_f);
      }
    }
    if ($i == 3) {
      for($k = 1; $k <= $pgst; $k++) {
        imagefill($image, 20+($k * 12), 29+(($i-$min) * $khoch), $farbe_g);
      }
    }
  }
}
imagestring($image, 3, 3, 1, stripslashes($pgteam1), $farbe_c);
if ($pganz == 2) {
  imagestring($image, 3, $breit-imagefontwidth(3) * strlen(stripslashes($pgteam2))-2, 1, stripslashes($pgteam2), $farbe_d);
}
for($i = 1; $i < $pgst; $i++) {
  if ($kmodus < 4) {
    if (strlen($linie[$i]) > 0 && strlen($linie[$i-1]) > 0) {
      imageline($image, 24+($i * 12), 28+$khoch/2+($linie[$i-1] * $khoch), 24+(($i+1) * 12), 28+$khoch/2+($linie[$i] * $khoch), $farbe_c);
      imageline($image, 23+($i * 12), 28+$khoch/2+($linie[$i-1] * $khoch), 23+(($i+1) * 12), 28+$khoch/2+($linie[$i] * $khoch), $farbe_c);
      imageline($image, 24+($i * 12), 29+$khoch/2+($linie[$i-1] * $khoch), 24+(($i+1) * 12), 29+$khoch/2+($linie[$i] * $khoch), $farbe_c);
      imageline($image, 23+($i * 12), 29+$khoch/2+($linie[$i-1] * $khoch), 23+(($i+1) * 12), 29+$khoch/2+($linie[$i] * $khoch), $farbe_c);
    }
  }
  if ($kmodus > 2) {
    if (strlen($liniea[$i]) > 0 && strlen($liniea[$i-1]) > 0) {
      imageline($image, 24+($i * 12), 28+$khoch/2+($liniea[$i-1] * $khoch), 24+(($i+1) * 12), 28+$khoch/2+($liniea[$i] * $khoch), $farbe_c1);
      imageline($image, 23+($i * 12), 28+$khoch/2+($liniea[$i-1] * $khoch), 23+(($i+1) * 12), 28+$khoch/2+($liniea[$i] * $khoch), $farbe_c1);
      imageline($image, 24+($i * 12), 29+$khoch/2+($liniea[$i-1] * $khoch), 24+(($i+1) * 12), 29+$khoch/2+($liniea[$i] * $khoch), $farbe_c1);
      imageline($image, 23+($i * 12), 29+$khoch/2+($liniea[$i-1] * $khoch), 23+(($i+1) * 12), 29+$khoch/2+($liniea[$i] * $khoch), $farbe_c1);
    }
  }
  if ($pganz == 2) {
    if ($kmodus < 4) {
      if (strlen($lini2[$i]) > 0 && strlen($lini2[$i-1]) > 0) {
        imageline($image, 24+($i * 12), 28+$khoch/2+($lini2[$i-1] * $khoch), 24+(($i+1) * 12), 28+$khoch/2+($lini2[$i] * $khoch), $farbe_d);
        imageline($image, 23+($i * 12), 28+$khoch/2+($lini2[$i-1] * $khoch), 23+(($i+1) * 12), 28+$khoch/2+($lini2[$i] * $khoch), $farbe_d);
        imageline($image, 24+($i * 12), 29+$khoch/2+($lini2[$i-1] * $khoch), 24+(($i+1) * 12), 29+$khoch/2+($lini2[$i] * $khoch), $farbe_d);
        imageline($image, 23+($i * 12), 29+$khoch/2+($lini2[$i-1] * $khoch), 23+(($i+1) * 12), 29+$khoch/2+($lini2[$i] * $khoch), $farbe_d);
      }
    }
    if ($kmodus > 2) {
      if (strlen($lini2a[$i]) > 0 && strlen($lini2a[$i-1]) > 0) {
        imageline($image, 24+($i * 12), 28+$khoch/2+($lini2a[$i-1] * $khoch), 24+(($i+1) * 12), 28+$khoch/2+($lini2a[$i] * $khoch), $farbe_d1);
        imageline($image, 23+($i * 12), 28+$khoch/2+($lini2a[$i-1] * $khoch), 23+(($i+1) * 12), 28+$khoch/2+($lini2a[$i] * $khoch), $farbe_d1);
        imageline($image, 24+($i * 12), 29+$khoch/2+($lini2a[$i-1] * $khoch), 24+(($i+1) * 12), 29+$khoch/2+($lini2a[$i] * $khoch), $farbe_d1);
        imageline($image, 23+($i * 12), 29+$khoch/2+($lini2a[$i-1] * $khoch), 23+(($i+1) * 12), 29+$khoch/2+($lini2a[$i] * $khoch), $farbe_d1);
      }
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