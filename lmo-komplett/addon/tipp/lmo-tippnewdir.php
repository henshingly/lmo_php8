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
  
  
if ($ftype != "") {
  if (!isset($iptype)) {
    $iptype = "";
  }
  if (!isset($_SESSION['lmotipperok'])) {
    $_SESSION['lmotipperok'] = 0;
  }
  if (!isset($liga)) {
    $liga = "";
  }
   
  $verz = opendir(substr(PATH_TO_LMO.'/'.$dirliga, 0, -1));
  $dummy = array("");
  while ($files = readdir($verz)) {
    if (strtolower(substr($files, -4)) == $ftype) {
      array_push($dummy, $files);
    }
  }
  closedir($verz);
  array_shift($dummy);
  sort($dummy);
  $tt0 = "";
  $tt1 = "";
  $i = 0;
  $j = 0;
  if (!isset($_SESSION["lmouserok"])) {
    $_SESSION["lmouserok"] = 0;
  }
  for($k = 0; $k < count($dummy); $k++) {
    $files = $dummy[$k];
    if ($_SESSION['lmouserok'] != 1) {
      $ftest = 1;
    } elseif($_SESSION['lmouserok'] == 1) {
      $ftest = 0;
      $ftest1 = explode(',', $_SESSION['lmouserfile']);
      if (isset($ftest1)) {
        for($u = 0; $u < count($ftest1); $u++) {
          if ($ftest1[$u].".l98" == $files) {
            $ftest = 1;
          }
        }
      }
    }
    if ($ftest == 1) {
      $sekt = "";
      $t0 = "";
      $t1 = "";
      $t4 = "";
      $t2 = $text[2];
      $datei = fopen(PATH_TO_LMO.'/'.$dirliga.$files, "rb");
      while (!feof($datei)) {
        $zeile = fgets($datei, 1000);
        $zeile = trim($zeile);
        if ((substr($zeile, 0, 1) == "[") && (substr($zeile, -1) == "]")) {
          $sekt = substr($zeile, 1, -1);
        } elseif((strpos($zeile, "=") != false) && (substr($zeile, 0, 1) != ";") && ($sekt == "Options")) {
          $schl = substr($zeile, 0, strpos($zeile, "="));
          $wert = substr($zeile, strpos($zeile, "=")+1);
          if ($schl == "Name") {
            $t0 = $wert;
          }
          if ($schl == "Actual") {
            $t1 = $wert;
          }
          if ($schl == "Teams") {
            $t4 = $wert;
          }
          if ($schl == "Rounds") {
            $anzst = $wert;
          }
          if ($schl == "Type") {
            if ($wert == "1") {
              $t2 = $text[370];
            }
          }
          if (($t0 != "") && ($t1 != "") && ($t4 != ""))break;
        }
      }
      fclose($datei);
      if ($t0 == "") {
        $j++;
        $t0 = $text[507].$j;
      }
      if ($t2 == $text[370]) {
        $anzst = strlen(decbin($t4-1));
      }
       
      $ftest = 0;
      $ftest1 = "";
      $ftest1 = explode(',', $tipp_ligenzutippen);
      if (isset($ftest1)) {
        for($u = 0; $u < count($ftest1); $u++) {
           
          if ($ftest1[$u] == substr($files, 0, -4)) {
            $ftest = 1;
          }
        }
      }
       
      if (($action != "tipp" && $todo != "tipp") || $ftest == 1 || $tipp_immeralle == 1) {
        if ($todo != "delligen" || (($ftest == 1 || $tipp_immeralle == 1) && file_exists(PATH_TO_ADDONDIR."/tipp/".$tipp_dirtipp.substr($files, 0, -4)."_".$_SESSION['lmotippername'].".tip") == true)) {
          if ($todo != "newligen" || (($ftest == 1 || $tipp_immeralle == 1) && file_exists(PATH_TO_ADDONDIR."/tipp/".$tipp_dirtipp.substr($files, 0, -4)."_".$_SESSION['lmotippername'].".tip") == false)) {
            if ($todo != "newtipper" || $ftest == 1 || $tipp_immeralle == 1) {
              if ($todo != "tippemail" || $ftest == 1 || $tipp_immeralle == 1) {
                if ($todo != "tippuseredit" || $ftest == 1 || $tipp_immeralle == 1) {
                  $i++;
                  if ($_SESSION['lmotipperok'] > 0 || $action == "admin" || $todo == "newtipper") {
                    if ($iptype == "reminder") {?>

  <tr>
    <td class="nobr">
        <input type="hidden" name="liga1[]" value="<? echo $files; ?>">
        <input type="radio" name="liganr" value="<? echo $i; ?>" <? if(($liga=="" && $i==1) || $liga==$files){echo "checked";} ?> onClick="if(emailart[2].checked==false)changetextarea(1);emailart[2].checked=true;"><? echo $t0; ?>
    </td>
    <td class="nobr">
      <select class="lmo-formular-input" name="st1[]" onChange="if(emailart[2].checked==false)changetextarea(1);emailart[2].checked=true;liganr[<? echo $i-1; ?>].checked=true;"><?
                      if ($liga == $files) {
                        if ($st > 0) {
                          $t1 = $st;
                        }
                      }
                      echo "<option value=\"0\"";
                      if ($t1 == 0) {
                        echo " selected";
                      }
                      echo ">"; // alle Spieltage
                      if ($t2 == $text[2]) {
                        echo $text['tipp'][228];
                      } else {
                        echo $text['tipp'][229];
                      }
                      echo "</option>";
                       
                      for($y = 1; $y <= $anzst; $y++) {
                        echo "<option value=\"".$y."\"";
                        if ($y == $t1) {
                          echo " selected";
                        }
                        echo ">";
                        if ($t2 == $text[2]) {
                          echo $y.". ".$text[2];
                        } else {
                          $t5 = strlen(decbin($t4-1));
                          if ($y == $t5) {
                            echo $text[374];
                          } elseif($y == $t5-1) {
                            echo $text[373];
                          } elseif($y == $t5-2) {
                            echo $text[372];
                          } elseif($y == $t5-3) {
                            echo $text[371];
                          } elseif($y == $t5-4) {
                            echo $text[370];
                          } else {
                            echo $y.". ".$t2;
                          }
                        }
                        echo "</option>";
                      }?>
      </select>
    </td>
  </tr><?
                    }
                    if($iptype=="einsicht" || $iptype=="auswert"){?>
  <tr>
    <td width="20">&nbsp;</td>
    <td class="nobr" align="left"><? echo $t0; ?></td>
    <td class="nobr" align="right">
      <form name="lmoedit" action="<? echo $_SERVER['PHP_SELF']; ?>" method="post">
        <input type="hidden" name="action" value="admin">
        <input type="hidden" name="todo" value="tipp">
        <input type="hidden" name="save" value="<? if($iptype=="einsicht"){echo "3";}else{echo "2";} ?>">
        <input type="hidden" name="liga" value="<? echo substr($files,0,-4); ?>">
        <select class="lmo-formular-input" name="st"><?
                      if ($liga == substr($files, 0, -4) && (($save == 2 && $iptype == "auswert") || ($save == 3 && $iptype == "einsicht"))) {
                        if ($st >= 0) {
                          $t1 = $st;
                        }
                      }
                       
                      if ($iptype == "auswert") {
                        if ($t2 == $text[2]) {
                          echo "<option value=\"0\"";
                          if ($t1 == 0) {
                            echo " selected";
                          }
                          echo ">"; // alle Spieltage
                        
                          echo $text['tipp'][228];
                          echo "</option>";
                        }
                        //TODO - alle Runden auswerten
                        /*echo "<option value=\"0\"";
                        if ($t1 == 0) {
                          echo " selected";
                        }
                        echo ">"; // alle Spieltage
                        if ($t2 == $text[2]) {
                          echo $text['tipp'][228];
                        } else {
                          echo $text['tipp'][229];
                        }
                        echo "</option>";*/
                      }
                       
                      for($y = 1; $y <= $anzst; $y++) {
                        echo "<option value=\"".$y."\"";
                        if ($y == $t1) {
                          echo " selected";
                        }
                        echo ">";
                        if ($t2 == $text[2]) {
                          // Spieltage
                          echo $y.". ".$text[2];
                        } else {
                          // Runden
                          $t5 = strlen(decbin($t4-1));
                          if ($y == $t5) {
                            echo $text[374];
                          } elseif($y == $t5-1) {
                            echo $text[373];
                          } elseif($y == $t5-2) {
                            echo $text[372];
                          } elseif($y == $t5-3) {
                            echo $text[371];                          
                          } else {
                            echo $y.". ".$t2;
                          }
                        }
                        echo "</option>";
                      }?>
          </select><? 
                      echo $text['tipp'][164]; //Tipper
                      $start1=1;
                      if ($liga == substr($files, 0, -4) && (($save == 2 && $iptype == "auswert") || ($save == 3 && $iptype == "einsicht"))) {
                        if (isset($start)) {
                          $start1 = $start;
                        }
                      }?> 
          <input class="lmo-formular-input" type="text" name="start" size="2" maxlength="4" value="<? echo $start1; ?>"><? 
                      echo $text[4]; //bis
                      $dummy1=array();
                      $verz1 = opendir(substr(PATH_TO_ADDONDIR."/tipp/".$tipp_dirtipp, 0, -1));
                       while ($tipfiles = readdir($verz1)) {
                        if (strtolower(substr($tipfiles, 0, strlen(substr($files, 0, -4)))) == strtolower(substr($files, 0, -4)) && strtolower(substr($tipfiles, -4)) == ".tip") {
                          array_push($dummy1, $tipfiles);
                        }
                      }
                      closedir($verz1);
                      $ende1 = count($dummy1);
                      if ($liga == substr($files, 0, -4) && (($save == 2 && $iptype == "auswert") || ($save == 3 && $iptype == "einsicht"))) {
                        if (isset($ende)) {
                          $ende1 = $ende;
                        }
                      }?> 
          <input class="lmo-formular-input" type="text" name="ende" size="2" maxlength="4" value="<? echo $ende1; ?>">
          <input class="lmo-formular-button" type="submit" name="best" value="<? if($iptype=="einsicht"){echo $text['tipp'][156];}else{echo $text['tipp'][58];}  ?>">
        </form>
    </td>
  </tr>
<?
                    }elseif($iptype!="reminder"){
                      $checked = 0;
                      if (($todo == "newtipper" || $todo == "tippuseredit") && $xtipperligen != "") {
                        $checked = 0;
                        foreach($xtipperligen as $key => $value) {
                          if (substr($files, 0, -4) == $value) {
                            $checked = 1;
                          }
                        }
                      } elseif($todo == "newtipper") {
                        $checked = 1;
                      }?>
<input type="checkbox" name="xtipperligen[]" value="<? echo substr($files,0,-4) ?>"<?
                      if (($todo == "newtipper" || $todo == "tippuseredit") && $checked == 1) {
                        echo "checked";
                      } elseif($todo == "tippuseredit" && file_exists(PATH_TO_ADDONDIR."/tipp/".$tipp_dirtipp.substr($files, 0, -4)."_".$nick.".tip") == true) {
                        echo "checked";
                      }
                       
                      if ($todo == "tippoptions" && ($ftest == 1 || $tipp_immeralle == 1)) {
                        echo "checked";
                      }
                      if ($todo == "tippoptions") {
                        echo " onClick=\"dolmoedit()\"";
                      }
                      if ($todo == "tippoptions" && $tipp_immeralle == 1) {
                        echo " disabled";
                      }?>><? echo $t0 ?><br><?
                    }
                  }
                  $tt1.=$dummy[$k]."|";
                  $tt0.=$t0."|";
                }
              }
            }
          }
        }
      }
    }
  }
  if($i==0){
    echo "<li>[".$text[223]."]</li>";
  }
}      
?>