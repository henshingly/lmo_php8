<?
echo("<card id=\"auswahl\" title=\"Auswahl\">\n");
   
if ($lmtype == 0) {
  echo("<p align='center'>\n");
  echo("<a href=\"".$_SERVER['PHP_SELF'].'?wap_file='.$file."&amp;op=day&amp;st=$st\">".$text[10]."</a><br/>\n");
  echo("<a href=\"".$_SERVER['PHP_SELF'].'?wap_file='.$file."&amp;op=table&amp;st=$st\">".$text[16]."</a><br/>\n");
  echo("<a href=\"".$_SERVER['PHP_SELF'].'?wap_file='.$file."&amp;op=help&amp;st=$st\">".$text[20]."</a>\n");
}
//Ausgabe Pokal
else
  {
  echo("<p>\n");
  $anzsp = $anzteams;
  for($i = 0; $i < $st; $i++) {
    $anzsp = $anzsp/2;
  }
  if (($klfin == 1) && ($st == $anzst)) {
    $anzsp = $anzsp+1;
  }
  function gewinn ($gst, $gsp, $gmod, $m1, $m2) {
    $erg = 0;
    if ($gmod == 1) {
      if ($m1[0] > $m2[0]) {
        $erg = 1;
      } elseif($m1[0] < $m2[0]) {
        $erg = 2;
      }
    } elseif($gmod == 2) {
      if (($m1[0]+$m1[1]) > ($m2[0]+$m2[1])) {
        $erg = 1;
      } elseif(($m1[0]+$m1[1]) < ($m2[0]+$m2[1])) {
        $erg = 2;
      } else {
        if ($m2[0] > $m1[1]) {
          $erg = 1;
        } elseif($m2[0] < $m1[1]) {
          $erg = 2;
        }
      }
    } else {
      $erg1 = 0;
      $erg2 = 0;
      for($k = 0; $k < $gmod; $k++) {
        if (($m1[$k] != "_") && ($m2[$k] != "_")) {
          if ($m1[$k] > $m2[$k]) {
            $erg1++;
          } elseif($m1[$k] < $m2[$k]) {
            $erg2++;
          }
        }
      }
      if ($erg1 > ($gmod/2)) {
        $erg = 1;
      } elseif($erg2 > ($gmod/2)) {
        $erg = 2;
      }
    }
    return $erg;
  }
   
  for($i = 1; $i <= $anzst; $i++) {
     
    if ($i == $anzst) {
      $j = $text[364];
      $k = $text[365];
    } elseif($i == $anzst-1) {
      $j = $text[362];
    } elseif($i == $anzst-2) {
      $j = $text[360];
    } elseif($i == $anzst-3) {
      $j = $text[358];
    } else {
      $j = $i;
      $k = $text[366];
    }
    if ($i <> $st) {
      echo "<a href='".$_SERVER['PHP_SELF'].'?wap_file='.$file."&amp;op=nav&amp;st=".$i."'>".$j."</a>";
    } else {
      echo $j;
    }
    echo "&#160;";
  }
  if ($st == $anzst) {
    $j = $text[374];
  } elseif($st == $anzst-1) {
    $j = $text[373];
  } elseif($st == $anzst-2) {
    $j = $text[372];
  } elseif($st == $anzst-3) {
    $j = $text[371];
  } else {
    $j = $st.". ".$text[370];
  }
   
  echo "<br/>";
  //echo $j;
  if ($dats == 1) {
    if ($datum1[$st-1] != "") {
      echo "<small>(".$datum1[$st-1];
    }
    if ($datum2[$st-1] != "") {
      echo "-".$datum2[$st-1].")</small>";
    }
  }
  echo "<br/>\n";
  for($i = 0; $i < $anzsp; $i++) {
    for($n = 0; $n < $modus[$st-1]; $n++) {
       
      if (($klfin == 1) && ($st == $anzst)) {
        if ($i == 1) {
          echo "<br/>\n";
        }
         echo $text[419+$i];
      }
       
      if ($datm == 1) {
        if ($mterm[$st-1][$i][$n] > 0) {
          $dum1 = strftime($datf, $mterm[$st-1][$i][$n]);
        } else {
          $dum1 = "";
        }
        echo "<small>$dum1</small>";
      }
       
      if ($n == 0) {
        $m1 = array($goala[$st-1][$i][0], $goala[$st-1][$i][1], $goala[$st-1][$i][2], $goala[$st-1][$i][3], $goala[$st-1][$i][4], $goala[$st-1][$i][5], $goala[$st-1][$i][6]);
        $m2 = array($goalb[$st-1][$i][0], $goalb[$st-1][$i][1], $goalb[$st-1][$i][2], $goalb[$st-1][$i][3], $goalb[$st-1][$i][4], $goalb[$st-1][$i][5], $goalb[$st-1][$i][6]);
        $m = call_user_func('gewinn', $st-1, $i, $modus[$st-1], $m1, $m2);
        if (($klfin == 1) && ($st == $anzst)) {
          if ($i == 0) {
            if ($m == 1) {
              echo "<br/>\n";
            } elseif($m == 2) {
              echo "<br/>\n";
            } else {
              echo "<br/>\n";
            }
          } elseif($i == 1) {
            if ($m == 1) {
              echo "<br/>\n";
            } else {
              echo "<br/>\n";
            }
          }
        } else {
          if ($m == 1) {
            echo "<br/>\n";
          } else {
            echo "<br/>\n";
          }
        }
         
        if (($favteam > 0) && ($favteam == $teama[$st-1][$i])) {
          echo "<b>";
        }
        $teamname = $teamk[$teama[$st-1][$i]];
        $teamname = ($teamname);
        echo $teamname;
        if (($favteam > 0) && ($favteam == $teama[$st-1][$i])) {
          echo "</b>";
        }
         
         
        if (($klfin == 1) && ($st == $anzst)) {
          if ($i == 0) {
            if ($m == 2) {
              echo "test3";
            } elseif($m == 1) {
              echo "test4";
            } else {
              echo "test5";
            }
          } elseif($i == 1) {
            if ($m == 2) {
              echo "test6";
            } else {
              echo "test7";
            }
          }
        } else {
          if ($m == 2) {
            echo "&#160;-&#160;";
          } else {
            echo "&#160;-&#160;";
          }
        }
        if (($favteam > 0) && ($favteam == $teamb[$st-1][$i])) {
          echo "<b>";
        }
        $teamname = $teamk[$teamb[$st-1][$i]];
        $teamname = ($teamname);
        echo $teamname;
        if (($favteam > 0) && ($favteam == $teamb[$st-1][$i])) {
          echo "</b>";
        }
         
      } else {
         echo "&#160;";
      }
      echo "&#160;";
      echo applyFactor($goala[$st-1][$i][$n], $goalfaktor);
      echo "&#160;-&#160;";
      echo applyFactor($goalb[$st-1][$i][$n], $goalfaktor);
       
      echo $mspez[$st-1][$i][$n];
      echo "<br/>\n";
    }
  }
  echo("<a href='".$_SERVER['PHP_SELF'].'?wap_file='.$file."&amp;op=help&amp;st=$st'>".$text[20]."</a>\n");
}
//Ausgabe Pokal Ende
 
echo("<br/><small><a href=\"".$_SERVER['PHP_SELF']."\">Home</a></small>\n");
echo("</p>\n");
echo("</card>\n");?>