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
if ($_POST["liga"] != "" && $_POST["st"] != "") {
  $start=isset($_POST['start'])?$_POST['start']:0;
  $ende=isset($_POST['ende'])?$_POST['ende']:$anztipper;
  $verz = opendir(PATH_TO_ADDONDIR."/tipp/".$tipp_dirtipp);
  $dummy = array();
  while ($files = readdir($verz)) {
    if (strtolower(substr($files, -4)) == ".tip" && strtolower(substr($files, 0, strlen($liga))) == strtolower($liga)) {
      array_push($dummy, $files);
    }
  }
   
  $anztipper = count($dummy);
  $einsichtfile = PATH_TO_ADDONDIR."/tipp/".$tipp_dirtipp."einsicht/".$liga."_".$st.".ein";
  $datenalt = array("");
  $nick = "";
   
  if ($st > 0 && file_exists($einsichtfile)) {
    $datei = fopen($einsichtfile, "rb");
    while (!feof($datei)) {
      $zeile = fgets($datei, 1000);
      $zeile = trim(chop($zeile));
      if ($zeile != "") {
        if ((substr($zeile, 0, 1) == "[") && (substr($zeile, -1) == "]")) {
          $nick = substr($zeile, 1, -1);
          if (!file_exists(PATH_TO_ADDONDIR."/tipp/".$tipp_dirtipp.$liga."_".$nick.".tip")) {
            $nick = "";
          }
        }
         
        if ($nick != "") {
          array_push($datenalt, $zeile);
        }
      }
    }
    fclose($datei);
  }
   
  $file = $dirliga.$liga.".l98";
  if (file_exists($file)) {
    $einsichtdatei = fopen($einsichtfile, "wb");
    if (!$einsichtdatei) {
      echo getMessage($text['tipp'][157]." ".$einsichtfile.$text[283],TRUE);
      exit;
    }
    flock($einsichtdatei, 2);
    echo getMessage($text['tipp'][157]." ".$liga." ".$text['tipp'][65]);
     
    for($k = 0; $k < $anztipper; $k++) {
      // durchlaufe alle Tipper
      $tippernick = substr($dummy[$k], strrpos($dummy[$k], "_")+1, -4);
      if ($k >= $start-1 && $k <= $ende-1) {
        $tippfile = PATH_TO_ADDONDIR."/tipp/".$tipp_dirtipp.$dummy[$k];
        fputs($einsichtdatei, "\n[".$tippernick."]\n");
         
        if (!file_exists($tippfile))
        echo getMessage($text['tipp'][17],TRUE);
        else
          {
          $datei = fopen($tippfile, "rb");
          if ($datei != false) {
            $tippdaten = array();
            $sekt = "";
            $jkwert = "";
            while (!feof($datei)) {
              $zeile = fgets($datei, 1000);
              $zeile = trim($zeile);
              if ((substr($zeile, 0, 1) == "@") && (substr($zeile, -1) == "@")) {
                $jkwert = trim(substr($zeile, 1, -1));
              } elseif((substr($zeile, 0, 1) == "[") && (substr($zeile, -1) == "]")) {
                $sekt = trim(substr($zeile, 1, -1));
              } elseif((strpos($zeile, "=") != false) && (substr($zeile, 0, 1) != ";")) {
                $schl = trim(substr($zeile, 0, strpos($zeile, "=")));
                $wert = trim(substr($zeile, strpos($zeile, "=")+1));
                array_push($tippdaten, $sekt."|".$schl."|".$wert."|".$jkwert."|EOL");
              }
            }
            fclose($datei);
          }

          $jkspgrpw = 0;
          for($i = 1; $i <= count($tippdaten); $i++) {
            $dum = explode('|', $tippdaten[$i-1]);
            $op2 = substr($dum[0], 0, 5);            // Round
            $op3 = substr($dum[0], 5);            // Spieltagsnummer
            $op8 = substr($dum[1], 0, 2);
            $jksp = $dum[3];
            if ($st == $op3) {
              if ($tipp_jokertipp == 1 && $jkspgrpw != $op3) {
                fputs($einsichtdatei, "@".$jksp."@\n");
                $jkspgrpw = $op3;
              }
              if (($op2 == "Round") && ($op8 == "GB" || $op8 == "GA")) {
                fputs($einsichtdatei, $dum[1]."=".$dum[2]."\n");
              }
            }
          }
        }
      } // ende if($k>=$start-1 && $k<=$ende-1)
      else
        {
        $nick = "";
        for($i = 0; $i < count($datenalt); $i++) {
          $zeile = $datenalt[$i];
          if ($zeile != "") {
            if ((substr($zeile, 0, 1) == "[") && (substr($zeile, -1) == "]")) {
              $nick = substr($zeile, 1, -1);
            }
            if ($nick == $tippernick) {
              fputs($einsichtdatei, $datenalt[$i]."\n");
            }
          }
        } // ende for($i=0;$i<count($datenalt);$i++)
      } // ende else
    } // ende for($k=0;$k<$anztipper;$k++)
    flock($einsichtdatei, 3);
    fclose($einsichtdatei);
  } // ende if(file_exists($file))
  closedir($verz);
}
clearstatcache();
$file = "";

?>