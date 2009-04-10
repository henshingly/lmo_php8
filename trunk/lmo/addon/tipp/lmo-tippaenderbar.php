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
  
  
// Tipp noch änderbar oder nicht

function tippaenderbar($mterm0, $datum1, $datum2) {
  global $plus; // eine Minute Sicherheitsabstand zwischen Seitenaufruf und abspeichern
  global $tipp_imvorraus;
  global $st;
  global $stx;
  global $tipp_tippBis;
  global $tipp_tippohne;
  global $deftime;
   
  if ($tipp_imvorraus >= 0 && $st > ($stx+$tipp_imvorraus)) {
    $btip = false;
  } else {
    $btip = false;
    $now = strtotime("+".$tipp_tippBis+$plus." minute");
    if ($mterm0 > 0) {
      if ($now < $mterm0) {
        $btip = true;
      }
    } else {
      if ($datum1 != "") {
        if ($tipp_tippohne == 1 && $deftime > 0) {
          $datum1a = mktime(substr($deftime, 0, 2), substr($deftime, 3, 2), 0, substr($datum1, 3, 2), substr($datum1, 0, 2), substr($datum1, -4));
        } else {
          $datum1a = mktime(0, 0, 0, substr($datum1, 3, 2), substr($datum1, 0, 2), substr($datum1, -4));
        }
         
        if ($now < $datum1a) {
          $btip = true;
        }
      } elseif($datum2 != "") {
        if ($tipp_tippohne == 1 && $deftime > 0) {
          $datum1a = mktime(substr($deftime, 0, 2), substr($deftime, 3, 2), 0, substr($datum2, 3, 2), substr($datum2, 0, 2), substr($datum2, -4));
        } else {
          $datum1a = mktime(0, 0, 0, substr($datum2, 3, 2), substr($datum2, 0, 2), substr($datum2, -4));
        }
         
        if ($now < $datum1a) {
          $btip = true;
        }
      }
    }
  }
  return $btip;
}
 
function zeit($mterm0, $datum1, $datum2) {
  global $tipp_tippohne;
  global $deftime;
  global $tipp_tippBis;
   
  if ($mterm0 > 0) {
    $zeit = $mterm0;
  } elseif($datum1 != "") {
    if ($tipp_tippohne == 1 && $deftime > 0) {
      $zeit = mktime(substr($deftime, 0, 2), substr($deftime, 3, 2), 0, substr($datum1, 3, 2), substr($datum1, 0, 2), substr($datum1, -4));
    } else {
      $zeit = mktime(0, 0, 0, substr($datum1, 3, 2), substr($datum1, 0, 2), substr($datum1, -4));
    }
  } elseif($datum2 != "") {
    if ($tipp_tippohne == 1 && $deftime > 0) {
      $zeit = mktime(substr($deftime, 0, 2), substr($deftime, 3, 2), 0, substr($datum2, 3, 2), substr($datum2, 0, 2), substr($datum2, -4));
    } else {
      $zeit = mktime(0, 0, 0, substr($datum2, 3, 2), substr($datum2, 0, 2), substr($datum2, -4));
    }
  } else {
    $zeit = "";
  }
   
  if ($zeit != "") {
    $zeit -= $tipp_tippBis * 60;
  }
  return $zeit;
}
?>