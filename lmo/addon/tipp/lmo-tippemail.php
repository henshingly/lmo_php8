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
require_once(PATH_TO_ADDONDIR."/tipp/lmo-tippaenderbar.php");

if ($message != "") {
  $dumma = array();
  $pswfile = PATH_TO_ADDONDIR."/tipp/".$tipp_tippauthtxt;

  $dumma = file($pswfile);
  
  $subject = $betreff;
  $header = "From: ".$text['tipp'][0]." <".$aadr.">";
  $para5 = "-f $aadr";
  $anzemail = 0;
  $anztipper = count($dumma);
  if (!isset($start)) {
    $start = 1;
  }
  if (!isset($ende)) {
    $ende = $anztipper;
  }
   
  if ($emailart == 0) {
    for($tippernr = $start-1; $tippernr < $ende; $tippernr++) {
      $dummb = explode('|', $dumma[$tippernr]);
      if ($dummb[9] != -1) {
        $textmessage = $message;
        $textmessage = str_replace("[nick]", $dummb[0], $textmessage);
        $textmessage = str_replace("[pass]", $dummb[1], $textmessage);
        $textmessage = str_replace("[name]", $dummb[3], $textmessage);
        if (function_exists('ini_get') && @ini_get('safe_mode')=="0") {
          $sent=mail($dummb[4], $subject, $textmessage, $header, $para5);
        } else {
          $sent=mail($dummb[4], $subject, $textmessage, $header);
        }
        if ($sent) {
          $anzemail++;
        } else {
          echo getMessage($text['tipp'][176],TRUE);
        }
      }
    }
    echo getMessage($anzemail." ".$text['tipp'][175]);
  }
   
   
  elseif($emailart == 1) {
    $tipp_textreminder1 = str_replace(array("\r\n","\n","\r"), array("&#10;","&#10;","&#10;") , $message);
    require(PATH_TO_LMO."/lmo-savecfg.php");
    $now = strtotime("now");
    $then = strtotime("+".$tage." day");
     
    if ($viewermode == 1) {
      $verz = opendir(substr($dirliga, 0, -1));
      $dateien = array();
      while ($files = readdir($verz)) {
        $ftest = 1;
        if ($tipp_immeralle != 1) {
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
        }
        if ($ftest == 1) {
          array_push($dateien, $files);
        }
      }
      closedir($verz);
      sort($dateien);
       
      $anzligen = count($dateien);
       
      $teams = array_pad($array, 65, "");
      $teams[0] = "___";
      $liga = array();
      $titel = array();
      $lmtype = array();
      $anzst = array();
      $spieltag = array();
      $modus = array();
      $spiel = array();
      $teama = array();
      $teamb = array();
      $zeit = array();
       
      $anzspiele = 0;
       
      for($lnr = 0; $lnr < $anzligen; $lnr++) {
        $file = $dirliga.$dateien[$lnr];
        require(PATH_TO_ADDONDIR."/tipp/lmo-tippemailviewer.php");
      }
       
      $goaltipp = array_pad(array("_"), $anzspiele+1, "_");
       
      for($tippernr = $start-1; $tippernr < $ende; $tippernr++) {
        $dummb = explode('|', $dumma[$tippernr]);
        if ($dummb[10] != -1 && $dummb[4] != "") {
          for($i = 0; $i < $anzspiele; $i++) {
            $goaltipp[$i] = "_";
          }
          $textmessage = $message;
          $lliga = "";
          $lspieltag = "";
          $spiele = "";
          for($i = 0; $i < $anzspiele; $i++) {
            if ($i == 0 || $liga[$i] != $liga[$i-1]) {
              $tippfile = PATH_TO_ADDONDIR."/tipp/".$tipp_dirtipp.$liga[$i]."_".$dummb[0].".tip";
              if (file_exists($tippfile)) {
                require(PATH_TO_ADDONDIR."/tipp/lmo-tippemailviewer1.php");
                $ktipp = 1;
              } else {
                $ktipp = 0;
              }
            }
            if ($ktipp == 1) {
              if ($goaltipp[$i] == "_") {
                if ($lliga != $liga[$i]) {
                  $spiele = $spiele."\n".$titel[$i].":\n";
                }
                if ($lspieltag != $spieltag[$i] || $lliga != $liga[$i]) {
                  if ($lmtype[$i] == 0) {
                    $spiele = $spiele.$spieltag[$i].".".$text[2].":\n";
                  } else {
                    if ($spieltag[$i] == $anzst[$i]) {
                      $j = $text[374];
                    } elseif($spieltag[$i] == $anzst[$i]-1) {
                      $j = $text[373];
                    } elseif($spieltag[$i] == $anzst[$i]-2) {
                      $j = $text[372];
                    } elseif($spieltag[$i] == $anzst[$i]-3) {
                      $j = $text[371];
                    } else {
                      $j = $spieltag[$i].". ".$text[370];
                    }
                    $spiele = $spiele.$j.":\n";
                  }
                }
                $spiele = $spiele.$teama[$i]." - ".$teamb[$i]." (".$text['tipp'][87]." ".$zeit[$i].")\n";
                $lliga = $liga[$i];
                $lspieltag = $spieltag[$i];
              }
            }
          }
          if ($spiele != "") {
            $textmessage = str_replace("[nick]", $dummb[0], $textmessage);
            $textmessage = str_replace("[pass]", $dummb[1], $textmessage);
            $textmessage = str_replace("[name]", $dummb[3], $textmessage);
            $textmessage = str_replace("[spiele]", $spiele, $textmessage);
            if (function_exists('ini_get') && @ini_get('safe_mode')=="0") {
              $sent=mail($dummb[4], $subject, $textmessage, $header, $para5);
            } else {
              $sent=mail($dummb[4], $subject, $textmessage, $header);
            }
            if ($sent) {
              $anzemail++;
            } else {
              echo getMessage($text['tipp'][176],TRUE);
            }
          }
        }
      }
    } elseif($liga != "" && $tage > 0 && $st >= 0) {
      $file = $liga;
      if ($st > 0) {
        require(PATH_TO_LMO."/lmo-openfiledat.php");
      } elseif($st == 0) {
        require(PATH_TO_LMO."/lmo-openfile.php");
      }
       
      for($tippernr = $start-1; $tippernr < $ende; $tippernr++) {
        $dummb = explode('|', $dumma[$tippernr]);
        if ($dummb[10] != -1 && $dummb[4] != "") {
          $textmessage = $message;
          $tippfile = PATH_TO_ADDONDIR."/tipp/".$tipp_dirtipp.substr($file, 0, -4)."_".$dummb[0].".tip";
          $spiele = "";
          if (file_exists($tippfile)) {
            if ($st > 0) {
              require(PATH_TO_ADDONDIR."/tipp/lmo-tippopenfile.php");
              $st0 = $st-1;
              $anzst1 = $st;
            } elseif($st == 0) {
              require(PATH_TO_ADDONDIR."/tipp/lmo-tippopenfileall.php");
              $st0 = 0;
              $anzst1 = $anzst;
            }
            for(; $st0 <= $anzst1; $st0++) {
              if ($tipp_imvorraus < 0 || $st0 <= ($stx+$tipp_imvorraus)) {
                if ($lmtype == 0) {
                  for($dd = 0; $dd < $anzsp; $dd++) {
                    $zeit = zeit($mterm[$st0][$dd], $datum1[$st0], $datum2[$st0]);
                    if ($now < $zeit && $then > $zeit) {
                      if ((($st == 0 && $goaltippa[$st0][$dd] == "_") || ($st > 0 && $goaltippa[$dd] == "_")) && $teama[$st0][$dd] > 0) {
                        $spiele = $spiele.$teams[$teama[$st0][$dd]]." - ".$teams[$teamb[$st0][$dd]]." (".$text['tipp'][87]." ".strftime("%A, %d.%m.%Y %R", $zeit).")\n";
                      }
                    }
                  }
                } elseif($lmtype != 0) {
                  for($dd = 0; $dd < $anzsp; $dd++) {
                    for($ddd = 0; $ddd < $modus[$st0]; $ddd++) {
                      $zeit = zeit($mterm[$st0][$dd][$ddd], $datum1[$st0], $datum2[$st0]);
                      if ($now < $zeit && $then > $zeit) {
                        if ((($st == 0 && $goaltippa[$st0][$dd][$ddd] == "_") || ($st > 0 && $goaltippa[$dd][$ddd] == "_")) && $teama[$st0][$dd] > 0) {
                          $spiele = $spiele.$teams[$teama[$st0][$dd]]." - ".$teams[$teamb[$st0][$dd]]." (".$text['tipp'][87]." ".strftime("%A, %d.%m.%Y %R", $zeit).")\n";
                        }
                      }
                    }
                  }
                }
              }
            } // ende for($spieltag=1;$spieltag<=$anzst;$spieltag++)
             
            if ($spiele != "") {
              $textmessage = str_replace("[nick]", $dummb[0], $textmessage);
              $textmessage = str_replace("[pass]", $dummb[1], $textmessage);
              $textmessage = str_replace("[name]", $dummb[3], $textmessage);
              $textmessage = str_replace("[spiele]", $spiele, $textmessage);
              if (function_exists('ini_get') && @ini_get('safe_mode')=="0") {
                $sent=mail($dummb[4], $subject, $textmessage, $header, $para5);
              } else {
                $sent=mail($dummb[4], $subject, $textmessage, $header);
              }
              if ($sent) {
                $anzemail++;
              } else {
                echo getMessage($text['tipp'][176],TRUE);
              }
            }
          }
        } // ende if($dummb[10]!=-1)
      } // ende for($tippernr=0;$tippernr<$anztipper;$tippernr++)
    }
    echo getMessage($anzemail." ".$text['tipp'][175]);
  } // ende if($emailart==1)
   
  elseif($emailart == 2 && $adressat != "") {
    $dummb = explode('|', $dumma[0]);
    for($i = 0; $i < $anztipper && $adressat != $dummb[0]; $i++) {
      $dummb = explode('|', $dumma[$i]);
    }
    $textmessage = $message;
    $textmessage = str_replace("[nick]", $dummb[0], $textmessage);
    $textmessage = str_replace("[pass]", $dummb[1], $textmessage);
    $textmessage = str_replace("[name]", $dummb[3], $textmessage);
    if (function_exists('ini_get') && @ini_get('safe_mode')=="0") {
      $sent=mail($dummb[4], $subject, $textmessage, $header, $para5);
    } else {
      $sent=mail($dummb[4], $subject, $textmessage, $header);
    }
    if ($sent) {
      echo getMessage('1 '.$text['tipp'][175]);
    } else {
      echo getMessage($text['tipp'][176],TRUE);
    }
  }
}

?>