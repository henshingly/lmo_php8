<?PHP
// 
// LigaManager Online 3.02
// Copyright (C) 1997-2002 by Frank Hollwitz
// webmaster@hollwitz.de / http://php.hollwitz.de
// 
// Tippspiel-AddOn 1.20
// Copyright (C) 2002 by Frank Albrecht
// fkalbrecht@web.de
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
require_once(PATH_TO_LMO."/lmo-tipptest.php");
if(isset($xtippername2)){
  $dumma = array("");
  $pswfile=$tippauthtxt;
  $datei = fopen($pswfile,"rb");
  while (!feof($datei)) {
    $zeile = fgets($datei,1000);
    $zeile=chop($zeile);
    if($zeile!=""){array_push($dumma,$zeile);}
    }
  fclose($datei);
  array_shift($dumma);
  for($i=0;$i<count($dumma) && $_SESSION["lmotipperok"]==-5;$i++){
    $dummb = split("[|]",$dumma[$i]);
    if($xtippername2==$dummb[0] || ($xtippername2==$dummb[4] && strpos($dummb[4],"@")!=false)){ // User gefunden
      $lmotippername=$dummb[0];
      $_SESSION["lmotipperok"]=0;
      $emailbody = "Hallo ".$dummb[0]."\n\n".$text[2077]."\n".$text[2023].": ".$dummb[0]."\n".$text[308].": ".$dummb[1]; 
      $header="From:$aadr\n";
//      $header .= "Reply-To: $aadr\n"; 
//      $header .= "Bcc: $aadr\n"; 
//      $header .= "X-Mailer: PHP/" . phpversion(). "\n";          
//      $header .= "X-Sender-IP: $REMOTE_ADDR\n"; 
//      $header .= "Content-Type: text/plain"; 
      $para5="-f $aadr";
      if(mail($dummb[4],$text[2079],$emailbody,$header,$para5)){
        echo $text[2078]."<br>";
        $xtippername2="";
        }
      else{echo $text[2080]." ".$aadr;}
      }
    }
  if($_SESSION["lmotipperok"]==-5){$_SESSION["lmotipperok"]=-3;} // Benutzer nicht gefunden
  }
  else{$_SESSION["lmotipperok"]=0;} // kein Name angegeben

?>