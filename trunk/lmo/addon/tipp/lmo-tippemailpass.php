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
  
  
require_once(PATH_TO_ADDONDIR."/tipp/lmo-tipptest.php");
if (isset($xtippername2)) {
  $dumma = array();
  $pswfile = PATH_TO_ADDONDIR."/tipp/".$tipp_tippauthtxt;
  
  $dumma = file($pswfile);
  
  for($i = 0; $i < count($dumma) && $_SESSION["lmotipperok"] == -5; $i++) {
    $dummb = explode('|', $dumma[$i]);
    if ($xtippername2 == $dummb[0] || ($xtippername2 == $dummb[4] && strpos($dummb[4], "@") != false)) {
      // User gefunden
      $_SESSION['lmotippername'] = $dummb[0];
      $_SESSION["lmotipperok"] = 0;
      $emailbody = "Hallo ".$dummb[0]."\n\n".$text['tipp'][77]."\n".$text['tipp'][23].": ".$dummb[0]."\n".$text[308].": ".$dummb[1];
      $header = "From:$aadr\n";
      //      $header .= "Reply-To: $aadr\n";
      //      $header .= "Bcc: $aadr\n";
      //      $header .= "X-Mailer: PHP/" . phpversion(). "\n";
      //      $header .= "X-Sender-IP: $REMOTE_ADDR\n";
      //      $header .= "Content-Type: text/plain";
      if (function_exists('ini_get') && @ini_get('safe_mode')=="0") {
        $para5 = "-f $aadr";
        if (mail($dummb[4], $text['tipp'][79], $emailbody, $header, $para5)) {
          echo $text['tipp'][78]."<br>";
          $xtippername2 = "";
        } else {
          echo $text['tipp'][80]." ".$aadr;
        }
      } else {
        if (mail($dummb[4], $text['tipp'][79], $emailbody, $header)) {
          echo $text['tipp'][78]."<br>";
          $xtippername2 = "";
        } else {
          echo $text['tipp'][80]." ".$aadr;
        }
      }
    }
  }
  if ($_SESSION["lmotipperok"] == -5) {
    $_SESSION["lmotipperok"] = -3;
  } // Benutzer nicht gefunden
} else {
  $_SESSION["lmotipperok"] = 0;
} // kein Name angegeben
?>