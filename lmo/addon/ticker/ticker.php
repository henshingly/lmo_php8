<?php
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

require_once(__DIR__.'/../../init.php');

// Durch gesetzte $tickerart bestimmter Parameter (für include/require)
$ticker_tickerart=      isset($tickerart)?            $tickerart:      $ticker_tickerart;
$ticker_ligen=          isset($tickerligen)?          $tickerligen:    $ticker_standard_ligen;
$ticker_tickertitel=    isset($tickertitel)?          $tickertitel:    $ticker_tickertitel;
$ticker_notizanzeigen=  isset($tickernotizen)?        $tickernotizen:  $ticker_notizanzeigen;
$ticker_breite=         isset($tickerbreite)?         $breite:         $ticker_breite;
$ticker_geschwindigkeit=isset($tickergeschwindigkeit)?$geschwindigkeit:$ticker_geschwindigkeit;

$trenner=" +++ ";
$array = array();
$msieg=0;
$ticker_text=$mnote=$dummy1=$dummy2=$dummy3=$dummy4="";?>

          <script src="<?php echo URL_TO_LMO; ?>/js/jquery.marquee.min.js"></script>
          <script type="text/javascript">
            $(function(){$('.marquee').marquee();});
          </script>
          <div align="center"><?php
if ($ticker_tickertitel==1) { ?>
    <p><?php echo $text['ticker'][0]?></p><?php }
if (!isset($file)) {
  $file="";
}
$file2=$file;
$ticker_array=explode(",",$ticker_ligen);

foreach($ticker_array as $file){
  require(PATH_TO_LMO."/lmo-openfile.php");
  if (isset($lmtype)) {
    if ($ticker_tickerart==2) {
      $hilf="";
      $hilf1="";
      if (isset($nlines)) {
        for ($i=0;$i<count($nlines);$i++){
          if (strlen($nlines[$i]) > 0)
            $hilf.=$trenner.$nlines[$i];
        }
      }
      $ticker_text.=$hilf;
    } else {
      $hilf="";
      $hilf1="";
      if ($lmtype==0) {
        for ($i=0; $i<$anzsp; $i++) {
          if (($teama[$stx-1][$i]>0) && ($teamb[$stx-1][$i]>0) ) {
               if ($mspez[$stx-1][$i]=="&nbsp;") {
              $mspezhilf="";
            } else {
              $mspezhilf=" ".$mspez[$stx-1][$i];
            }
            if ($favteam==$teama[$stx-1][$i] || $favteam==$teamb[$stx-1][$i] || $ticker_tickerart==1) {
              if ($msieg[$stx-1][$i]==1) {
                $dummy1=$text['ticker'][2].":".addslashes($teams[$teama[$stx-1][$i]]." ".$text[211]);
              } else {
                $dummy1="";
              }
              if ($msieg[$stx-1][$i]==2) {
                $dummy2=$text['ticker'][2].":".addslashes($teams[$teamb[$stx-1][$i]]." ".$text[211]);
              } else {
                $dumm2y="";
              }
              if ($msieg[$stx-1][$i]==3) {
                $dummy3=$text['ticker'][2].":".addslashes($text['ticker'][3]);
              } else {
                $dummy3="";
              }
              if ($mnote[$stx-1][$i]!="" && $ticker_notizanzeigen==1) {
                $dummy4=" Notiz".": ".$mnote[$stx-1][$i];
              } else {
                $dummy4="";
              }
              $hilf=$hilf.$teams[$teama[$stx-1][$i]]." - ".$teams[$teamb[$stx-1][$i]]." ".applyFactor($goala[$stx-1][$i],$goalfaktor).":".applyFactor($goalb[$stx-1][$i],$goalfaktor).$mspezhilf.$dummy1.$dummy2.$dummy3.$dummy4.$trenner;
            }
          }
        }  //for
      } else {
        for ($i=0; $i<$anzsp; $i++) {
          for ($n=0; $n<$modus[$stx-1]; $n++) {
            if (($teama[$stx-1][$i]>0) && ($teamb[$stx-1][$i]>0) ) {
              if ($mspez[$stx-1][$i][$n]=="&nbsp;") {
                $mspezhilf="";
              } else {
                $mspezhilf=" ".$mspez[$stx-1][$i][$n];
              }
              if ($favteam==$teama[$stx-1][$i] || $favteam==$teamb[$stx-1][$i] || $ticker_tickerart==1) {
                if ($mnote[$stx-1][$i][$n]!="" && $notizanzeigen==1) {
                  $dummy4=" Notiz".": ".$mnote[$stx-1][$i][$n];
                } else {
                  $dummy4="";
                }
                $hilf1=$hilf1.$teams[$teama[$stx-1][$i]]." - ".$teams[$teamb[$stx-1][$i]]." ".applyFactor($goala[$stx-1][$i][$n],$goalfaktor).":".applyFactor($goalb[$stx-1][$i][$n],$goalfaktor).$mspezhilf.$dummy4.$trenner;
              }
            }
          }
        }
      }
    }
    $ticker_text.=" $trenner $titel ($stx{$text['ticker'][1]}): $hilf $hilf1";
  } else {
    $ticker_text=$text[224].$trenner;
  }
} //foreach
$ticker_formnumber="t".substr(md5(microtime()),3,4);
$file=$file2;
?>

            <div data-duration="<?php echo $ticker_geschwindigkeit;?>" class="marquee" style="width: <?php echo $ticker_breite;?>em; overflow: hidden; background-color: var(--bs-secondary-bg-subtle);"><?php echo $ticker_text; ?></div>
          </div>