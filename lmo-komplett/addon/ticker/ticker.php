<? 
require_once(dirname(__FILE__).'/../../init.php');

// Durch Get bestimmter Parameter (für IFRAME)
$ticker_tickerart=      isset($_GET['tickerart'])?            urldecode($_GET['tickerart']):      $ticker_tickerart;  
$ticker_ligen=          isset($_GET['tickerligen'])?          urldecode($_GET['tickerligen']):    $ticker_standard_ligen; 
$ticker_tickertitel=    isset($_GET['tickertitel'])?          urldecode($_GET['tickertitel']):    $ticker_tickertitel; 
$ticker_notizanzeigen=  isset($_GET['tickernotizen'])?        urldecode($_GET['tickernotizen']):  $ticker_notizanzeigen; 
$ticker_color=          isset($_GET['tickercolor'])?          urldecode($_GET['tickercolor']):          $ticker_color;
$ticker_background=     isset($_GET['tickerbackground'])?     urldecode($_GET['tickerbackground']):     $ticker_background;
$ticker_breite=         isset($_GET['tickerbreite'])?         urldecode($_GET['tickerbreite']):         $ticker_breite;
$ticker_geschwindigkeit=isset($_GET['tickergeschwindigkeit'])?urldecode($_GET['tickergeschwindigkeit']):$ticker_geschwindigkeit;

// Durch gesetzte $tickerart bestimmter Parameter (für include/require)
$ticker_tickerart=      isset($tickerart)?            $tickerart:      $ticker_tickerart;  
$ticker_ligen=          isset($tickerligen)?          $tickerligen:    $ticker_standard_ligen; 
$ticker_tickertitel=    isset($tickertitel)?          $tickertitel:    $ticker_tickertitel; 
$ticker_notizanzeigen= isset($tickernotizen)?        $notizanzeigen: $ticker_notizanzeigen; 
$ticker_color=          isset($tickercolor)?          $color:          $ticker_color;
$ticker_background=     isset($tickerbackground)?     $background:     $ticker_background;
$ticker_breite=         isset($tickerbreite)?         $breite:         $ticker_breite;
$ticker_geschwindigkeit=isset($tickergeschwindigkeit)?$geschwindigkeit:$ticker_geschwindigkeit;

$ticker_text="";
$versionticker="LMO-Ticker 1.03 ";
$array = array();  
$msieg=0;
$mnote="";
$dummy1="";
$dummy2="";
$dummy3="";
$dummy4="";

//Falls IFRAME - komplettes HTML-Dokument
if (basename($_SERVER['PHP_SELF'])=="ticker.php") {?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
					"http://www.w3.org/TR/html4/loose.dtd">
<html lang="de">
<head>
<title><?=$versionticker?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" >
</head>
<body><?
}?>
  <div align="center"><?
if ($ticker_tickertitel==1) { ?>
    <p style="padding:0;margin:0 auto;"><?=$text['ticker'][0]?></p><? 
}?>
    <script type="text/javascript"><?
if (!isset($file)) {
  $file="";
}
$file2=$file;

$ticker_array=explode(",",$ticker_ligen);
foreach($ticker_array as $file){
  $file=$dirliga.$file;

  require(PATH_TO_LMO."/lmo-openfile.php");

  if ($ticker_tickerart==2){
    $hilf="";
    $trenner=" +++ ";
    
    if (isset($nlines)) {
      for($i=0;$i<count($nlines);$i++){
        $hilf.=$nlines[$i].$trenner;
      }
    }else{
      $hilf.=$text['ticker'][4].$trenner;
    }
    $ticker_text.=$hilf;
  }else{ 
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
            $hilf=$hilf.$teams[$teama[$stx-1][$i]]."-".$teams[$teamb[$stx-1][$i]]." ".$goala[$stx-1][$i].":".$goalb[$stx-1][$i].$mspezhilf.$dummy1.$dummy2.$dummy3.$dummy4." +++ ";
          }
        }
      }  //for
    }else{
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
              $hilf1=$hilf1.$teams[$teama[$stx-1][$i]]."-".$teams[$teamb[$stx-1][$i]]." ".$goala[$stx-1][$i][$n].":".$goalb[$stx-1][$i][$n].$mspezhilf.$dummy4." +++ ";
            }
          }
        }
      }
    }
    $ticker_text.=" +++ $titel ($stx{$text['ticker'][1]}): $hilf $hilf1";
  }
} //foreach
$file=$file2;?>
  var msg1="<?=$ticker_text?>";
  var laenge=msg1.length;
  var timerID = null;
  var timerRunning = false;
  var id,pause=0,position=0;
  function marquee(){
    var i,k,msg=msg1;
    k=(<?=$ticker_breite?>/msg.length)+1;
    for(i=0;i<=k;i++) msg+=""+msg;
    document.marqueeform1.marquee.value=msg.substring(position,position+120);
    if(position++==laenge) position=0;
    id=setTimeout("marquee()",1000/<?=$ticker_geschwindigkeit+0.1?>);
    }
  function action(){
    if(!pause) {
      clearTimeout(id);
      pause=1;
      }
    else{
      marquee();
      pause=0;
    }
  }
  if (laenge>0) {
    document.write('<form name="marqueeform1" style="margin:0 auto;"><input style="background:#<?=$ticker_background?>;color:#<?=$ticker_color?>" type="text" name="marquee" SIZE="<?=$ticker_breite?>" readonly></form>');
    document.close();
    marquee();
  }
    </script>
    <noscript>
    <marquee style='background:#<?=$ticker_background?>;color:#<?=$ticker_color?>;width:<?=$ticker_breite?>ex'><?=$ticker_text?></marquee>
    </noscript>
  </div><?
//Falls IFRAME - komplettes HTML-Dokument
if (basename($_SERVER['PHP_SELF'])=="ticker.php") {?>
</body>
</html><?
}?>