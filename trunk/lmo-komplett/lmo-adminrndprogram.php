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
  
  
require_once(PATH_TO_LMO."/lmo-admintest.php");

$plan = array_pad($array, 41, "");
for($i = 1; $i < 41; $i++) {
  $plan[$i] = array_pad($array, 41, "");
  for($j = 1; $j < 41; $j++) {
    if ($i == $j) {
      $plan[$i][$j] = "-1";
    } else {
      $plan[$i][$j] = "0";
    }
  }
}
$j = $xteams;
if (($xteams%2) == 1) {
  $j++;
}
for($a = 1; $a <= $j; $a++) {
  $b = $a;
  if ($a == 1) {
    $b--;
  }
  for($i = 1; $i <= $j; $i++) {
    if ($plan[$i][$a] != "-1") {
      $plan[$i][$a] = $b;
      $b++;
      if ($b >= $j) {
        $b = 1;
      }
    } else {
      if ($i > 1) {
        $b++;
      }
    }
  }
}
$a = 2;
$b = 1;
for($i = 2; $i < $j; $i++) {
  if (($plan[$a][$b]+1) < $j) {
    $plan[$i][$j] = $plan[$a][$b]+1;
  } else {
    $plan[$i][$j] = 1;
  }
  $plan[$j][$i] = $plan[$i][$j];
  $a++;
  $b++;
}
for($a = 1; $a < $j; $a++) {
  for($b = $a+1; $b <= $j; $b++) {
    if ((($a+$b)%2) == 0) {
      $plan[$a][$b] = $plan[$b][$a]+$j-1;
    } else {
      $plan[$b][$a] = $plan[$a][$b]+$j-1;
    }
  }
}
for($a = 1; $a <= $xteams; $a++) {
  for($b = 1; $b <= $xteams; $b++) {
    if ($plan[$a][$b] > 0) {
      $l = 0;
      for($i = 1; $i <= $xanzsp; $i++) {
        if (!isset($yteama[$plan[$a][$b]-1][$i-1])) {
          $yteama[$plan[$a][$b]-1][$i-1] = 0;
        }
        if (($yteama[$plan[$a][$b]-1][$i-1] == 0) && ($l == 0)) {
          $yteama[$plan[$a][$b]-1][$i-1] = $a;
          $yteamb[$plan[$a][$b]-1][$i-1] = $b;
          $l = 1;
        }
      }
    }
  }
}


?>