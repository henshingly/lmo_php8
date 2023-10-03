<?php 
/**
 * lmo-savehtml.php: HTML-Ausgabe von Tabelle, aktuellem Spieltag und folgenden Spieltag
 * In der Datei lmo-savefile.php muss über der Zeile
 *  $datei = fopen($file,"w");
 *
 * folgende Zeile hinzugefügt werden:
 *
 *  include(PATH_TO_LMO."/lmo-savehtml.php");
 *
 *
 * Autor: Bernd Hoyer, basierend auf dem LMO3.02
 * Verbesserungen, Bugs etc. bitte nur in das Forum bei Hollwitz.net
 *
 */


if($st>0){$actual=$st;}else{$actual=$stx;}
if($lmtype==0){
  for($i1=0;$i1<$anzsp;$i1++){
    if ($goala[$actual-1][$i1]=="-1") $goala[$actual-1][$i1]="_";
    if ($goalb[$actual-1][$i1]=="-1") $goalb[$actual-1][$i1]="_";
  }
  $endtab=$actual;
  include_once(PATH_TO_LMO."/lmo-calctable.php");

  for($i1=0;$i1<$anzsp;$i1++){
    if ($goala[$actual-1][$i1]=="_") $goala[$actual-1][$i1]="-1";
    if ($goalb[$actual-1][$i1]=="_") $goalb[$actual-1][$i1]="-1";
  }
}
$actual=$st;
$datumanz=$actual-1;
if($lmtype==0 && $st>0){
  isset($tab0) ? $table1=$tab0 : $table1=$tab1;
  if (isset($table1)) {
    $wmlfile= fopen(PATH_TO_LMO.'/'.$diroutput.basename($file)."-st.html","wb");
    ob_start();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
  <title><?php echo $titel?></title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" >
  <style type="text/css">
    body {background:#fff; color:#000; font: 10pt sans-serif;}
    caption, p, h1 {margin: 3pt auto; text-align:center;}
    table {border:1pt solid #000;margin: 2pt auto;}
    td {padding: 0;white-space:nowrap;}
    th {border-bottom: 1px solid #000;}
    h1 {font:14pt bolder;}
    caption {margin-top:10pt;font-weight:bolder;white-space:nowrap;}
    @media print {
      a {display:none;}
    }
  </style>
</head>
<body>
  <script type="text/javascript">document.write('<small><a href="#" onClick="history.back();return false;"><?php echo $text[562]?><\/a><\/small>');</script>

  <h1><?php echo $titel?></h1><?php
  $z=array_filter($teama[$st-1],"filterZero");
  if (!empty($z)) {?>
  <table>
    <caption><?php echo $actual?>. <?php echo $text[2]?> <?php if ($datum1[$datumanz]!='') { echo ' - '.$datum1[$datumanz].' '.$text[4].' '.$datum2[$datumanz];}?></caption><?php
    $datsort= $mterm[$st-1];
    asort($datsort);
    reset($datsort);
    //while (list ($key, $val) = each ($datsort)) { //Deprecated: The each() function ...
    foreach($datsort as $key => $val) {
      $i1=$key;
      if(($teama[$st-1][$i1]>0) && ($teamb[$st-1][$i1]>0)){
        $heimteam=$teams[$teama[$actual-1][$i1]];
        $gastteam=$teams[$teamb[$actual-1][$i1]];
        $heimtore=applyFactor($goala[$actual-1][$i1],$goalfaktor);
        $gasttore=applyFactor($goalb[$actual-1][$i1],$goalfaktor);
        if ($gasttore<0) $gasttore="_";
        if ($heimtore<0) $heimtore="_";
        if (($anzteams-($anzst/2+1))!=0){
          $spielfreiaa[$i1]=$teama[$actual-1][$i1];
          $spielfreibb[$i1]=$teamb[$actual-1][$i1];
        }
        if($mterm[$actual-1][$i1]>0){
          $dum1=datefmt_format($fmt, $mterm[$actual-1][$i1]);
        } else {
          $dum1="";
        } // Anstosszeit einblenden
      ?>
      <tr>
        <td><?php echo $dum1?></td>
        <td align="right"><?php echo $heimteam?></td><td><?php echo HTML_icon($heimteam, 'teams');?></td>
        <td>-</td>
        <td><?php echo HTML_icon($gastteam, 'teams');?></td><td><?php echo $gastteam?></td>
        <td align="right"><?php echo $heimtore?></td>
        <td>:</td>
        <td align="left"><?php echo $gasttore?></td><?php
        if ($msieg[$actual-1][$i1]==3){ ?>
        <td width="2">/</td>
        <td align="right"><?php echo $gasttore?></td>
        <td align="center" width="8">:</td>
        <td align="left"><?php echo $heimtore?></td><?php
        }?>
      </tr><?php
      }
    }?>
    </table><?php

    if (($anzteams-($anzst/2+1))!=0){
      $spielfreicc=array_merge($spielfreiaa,$spielfreibb);
      $i=1;
      for ($j=1;$j<$anzteams+1;$j++) {
        if (!in_array($j,$spielfreicc)) {
          if ($i==1) {?>
      <p><small><?php echo $text[4004]?>: <?php
          }
          echo $teams[$j]?><?php
          $i++;
        }
      }?>
      </small></p><?php
    }
  }//if empty?>
  <table>
    <caption><?php echo $text[16]?> - <?php echo $actual?>. <?php echo $text[2]?></caption>
    <tr>
      <th></th>
      <th></th>
      <th></th>
      <th><?php echo $text[33]?></th>
      <th><?php echo $namepkt?></th>
      <th></th>
      <th><?php echo $nametor?></th>
      <th align="right" ><?php echo $text[39]?></th>
    </tr><?php

    for ($i1=0;$i1<$anzteams;$i1++){
      $platz=$i1+1;
      $i4=(int)substr($table1[$i1],35,7);
      $teamname=$teams[$i4];
      $pluspunkte=applyFactor($punkte[$i4],$pointsfaktor);
      $minuspunkte=applyFactor($negativ[$i4],$pointsfaktor);
      $kegelnholz=applyFactor($dtore[$i4],$goalfaktor);
      $plustore=applyFactor($etore[$i4],$goalfaktor);
      $minustore=applyFactor($atore[$i4],$goalfaktor);
      $torverhaeltnis=applyFactor($dtore[$i4],$goalfaktor);
      $spieleteam=$spiele[$i4];?>

    <tr>
      <td align="right"><?php echo $platz?></td>
      <td><?php echo HTML_icon($teamname, 'teams');?></td>
      <td><?php echo $teamname?></td>
      <td align="right"><?php echo $spieleteam?></td>
      <td align="right"><?php echo $pluspunkte?>
     <?php if ($minus==2) {
     ?>:</td>
       <td align="left"><?php echo $minuspunkte?><?php
      }else{?>
       </td>
       <td align="left"><?php
      }?>
       <td align="right"><?php echo "$plustore:$minustore"?></td>
       <td align="right"><?php echo $torverhaeltnis?></td>
     </tr><?php
    }?>
   </table>
   <p><small><?php echo $text[576];?></small></p><?php 
    if ($actual==$anzst){?>
    <p><strong><?php echo $text[568]?></strong></p><?php
    }else{
      $z=array_filter($teama[$st-1],"filterZero");
      if (!empty($z)) {?>
  <table>
    <caption><?php echo $actual+1?>. <?php echo $text[2]?><?php if ($datum1[$actual]!='') { echo ' - '.$datum1[$actual].' '.$text[4].' '.$datum2[$actual];}?></caption><?php
        $datsort= $mterm[$actual];
        asort($datsort);
        reset($datsort);
        //while (list ($key, $val) = each ($datsort)) { //Deprecated: The each() function ...
        foreach($datsort as $key => $val) {
          $i1=$key;
          if(($teama[$st][$i1]>0) && ($teamb[$st][$i1]>0)){
            $heimteam=$teams[$teama[$actual][$i1]];
            $gastteam=$teams[$teamb[$actual][$i1]];
            $heimtore=applyFactor($goala[$actual][$i1],$goalfaktor);
            $gasttore=applyFactor($goalb[$actual][$i1],$goalfaktor);
            if ($gasttore<0) $gasttore="_";
            if ($heimtore<0) $heimtore="_";
            if (($anzteams-($anzst/2+1))!=0){
              $spielfreiaa[$i1]=$teama[$actual][$i1];
              $spielfreibb[$i1]=$teamb[$actual][$i1];
            }
            if($mterm[$actual][$i1]>0){
              $dum1=date($datf, $mterm[$actual][$i1]);
            } else {
              $dum1="";
            } // Anstosszeit einblenden
    ?>
    <tr>
      <td><?php echo $dum1?></td>
      <td align="right"><?php echo $heimteam?></td><td><?php echo HTML_icon($heimteam, 'teams');?></td>
      <td>-</td>
      <td><?php echo HTML_icon($gastteam, 'teams');?></td><td><?php echo $gastteam?></td>
      <td align="right"><?php echo $heimtore?></td>
      <td>:</td>
      <td align="left"><?php echo $gasttore?></td><?php
            if ($msieg[$actual][$i1]==3){ ?>
        <td width="2">/</td>
        <td align="right"><?php echo $gasttore?></td>
        <td align="center" width="8">:</td>
        <td align="left"><?php echo $heimtore?></td><?php
            }?>
    </tr><?php
          }
        }?>
  </table><?php
        if (($anzteams-($anzst/2+1))!=0){
          $spielfreicc=array_merge($spielfreiaa,$spielfreibb);
          $i=1;
          for ($j=1;$j<$anzteams+1;$j++) {
            if (!in_array($j,$spielfreicc)) {
              if ($i==1) {?>
           <p><small><?php echo $text[4004]?>: <?php
              }
              echo $teams[$j]?><?php
              $i++;
            }
          }?>
  </small></p><?php
        }
      }//if empty
    }?>
  </center>  <script type="text/javascript">document.write('<small><a href="#" onClick="history.back();return false;"><?php echo $text[562]?><\/a><\/small>');</script>
</body>
</html><?php
    fwrite($wmlfile,ob_get_contents());
    ob_end_clean();
    fclose($wmlfile);
  }
}

?>