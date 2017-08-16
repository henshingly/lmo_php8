<?php
/**
 * lmo-savehtml1.php: HTML-Ausgabe von Tabelle, aktuellem Spieltag und folgenden Spieltag
 * In der Datei lmo-savefile.php muss über der Zeile
 *  $datei = fopen($file,"w");
 *
 * folgende Zeile hinzugefügt werden:
 *
 *  include(PATH_TO_LMO."/lmo-savehtml1.php");
 *
 *
 * Autor: Bernd Hoyer, basierend auf dem LMO3.02
 * Verbesserungen, Bugs etc. bitte nur in das Forum bei Hollwitz.net
 *
 */


if($st>0){$actual=$anzst;}else{$actual=$stx;}
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
if($lmtype==0){
	isset($tab0) ? $table1=$tab0 : $table1=$tab1;
  if (isset($table1)) {
    $wmlfile= fopen(PATH_TO_LMO.'/'.$diroutput.basename($file)."-sp.html","wb");
		ob_start();
		?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
					"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
  <title><?php echo $titel?></title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" >
  <style type="text/css">
   body {background:#fff; color:#000; font: 10pt sans-serif;padding:auto;}
   caption, p, h1 {margin: 3pt auto; text-align:center;}
   table {margin:auto; max-width:200mm;}
   #tabelle{border:1pt solid #000;}
   table table {border:1pt solid #000; margin:20pt 0 2pt; width:100%;}
   td {padding: 0; white-space:nowrap;}
   th {border-bottom: 1px solid #000;}
   h1 {font:14pt bolder;}
   caption {font-weight:bolder;white-space:nowrap;}
  </style>
</head>
<body>
  <script type="text/javascript">document.write('<small><a href="#" onClick="history.back();return false;"><?php echo $text[562]?><\/a><\/small>');</script>
  <h1><?php echo $titel?></h1>
  <table>
    <tr>
      <td>
<?php
    for ($y1=1;$y1<$anzst+1;$y1++) {
      $datumanz=$y1-1;
      $z=array_filter($teama[$y1-1],"filterZero");
      if (!empty($z)) {
?>
        <table>
        <caption><?php echo $y1?>.  <?php echo $text[2]?><?php if ($datum1[$datumanz]!='') { echo ' - '.$datum1[$datumanz].' '.$text[4].' '.$datum2[$datumanz];}?></caption>
<?php
        $datsort= $mterm[$y1-1];
        asort($datsort);
        reset($datsort);
        while (list ($key, $val) = each ($datsort)) {
        $i1=$key;
        if(($teama[$y1-1][$i1]>0) && ($teamb[$y1-1][$i1]>0)){
          $heimteam=$teams[$teama[$y1-1][$i1]];
          $gastteam=$teams[$teamb[$y1-1][$i1]];
          $heimtore=applyFactor($goala[$y1-1][$i1],$goalfaktor);
          $gasttore=applyFactor($goalb[$y1-1][$i1],$goalfaktor);
          if ($gasttore<0) $gasttore="_";
          if ($heimtore<0) $heimtore="_";
          // * Spielfrei-Hack-Beginn1	- Autor: Bernd Hoyer - eMail: info@salzland-info.de
          if (($anzteams-($anzst/2+1))!=0){
            $spielfreiaa[$i1]=$teama[$y1-1][$i1];
            $spielfreibb[$i1]=$teamb[$y1-1][$i1];
          }
          // * Spielfrei-Hack-Ende1- Autor: Bernd Hoyer - eMail: info@salzland-info.de
          if($mterm[$y1-1][$i1]>0){$dum1=strftime($datf, $mterm[$y1-1][$i1]);}else{$dum1="";} // Anstosszeit einblenden
?>
          <tr>
            <td><?php echo $dum1?>&nbsp;</td>
            <td align="right"><?php echo $heimteam?></td>
            <td><?php echo HTML_icon($heimteam, 'teams');?></td>
            <td>-</td>
            <td><?php echo HTML_icon($gastteam, 'teams');?></td>
            <td><?php echo $gastteam?>&nbsp;</td>
            <td align="right"><?php echo $heimtore?></td>
            <td>:</td>
            <td align="left"><?php echo $gasttore?></td>
<?php
          if ($msieg[$y1-1][$i1]==3){ 
?>
            <td width="2">/</td>
            <td align="right"><?php echo $gasttore?></td>
            <td align="center" width="8">:</td>
            <td align="left"><?php echo $heimtore?></td>
<?php
          }
?>
          </tr>
<?php
        }
      }
      $actual=$actual+1;
    }
    if (!empty($z)) {
?>
        </table>
<?php
    }
    if (($anzteams-($anzst/2+1))!=0){
      $spielfreicc=array_merge($spielfreiaa,$spielfreibb);
      unset($spielfreiaa);
      unset($spielfreibb);
      $i=1;
      for ($j=1;$j<$anzteams+1;$j++) {
        if (!in_array($j,$spielfreicc)) {
          if ($i==1) {?>
      <p><small><?php echo $text[4004]?>: <?php
          }
          echo $teams[$j]?>&nbsp;&nbsp;<?php
          $i++;
        }
      }
?>
      </small></p>
<?php
      unset($spielfreicc);
    }
  }
  $datumanz=$actual-1;
?>
      </td>
    </tr>
  </table>
  <table id="tabelle">
  <caption><?php echo $text[16]?></caption>
    <tr>
      <th>&nbsp;</th>
      <th>&nbsp;</th>
      <th>&nbsp;</th>
      <th><?php echo $text[33]?></th>
      <th><?php echo $namepkt?></th>
      <th>&nbsp;</th>
      <th><?php echo $nametor?>&nbsp;</th>
      <th align="right" >&nbsp;&nbsp;<?php echo $text[39]?></th>
    </tr>
<?php
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
    $spieleteam=$spiele[$i4];
?>
    <tr>
      <td align="right"><?php echo $platz?>&nbsp;</td>
      <td><?php echo HTML_icon($teamname, 'teams');?>&nbsp;</td>
      <td><?php echo $teamname?>&nbsp;</td>
      <td align="right"><?php echo $spieleteam?>&nbsp;</td>
      <td align="right"><?php echo $pluspunkte?>
<?php
    if ($minus==2) {
      ?>:</td>
      <td align="left"><?php echo $minuspunkte?>&nbsp;<?php
    } else {?>
      </td>
      <td align="left">&nbsp;<?php
    }
?>
      <td align="right"><?php echo "$plustore:$minustore"?>&nbsp;</td>
      <td align="right">&nbsp;&nbsp;<?php echo $torverhaeltnis?></td>
    </tr>
<?php
  }
?>
  </table>
  <script type="text/javascript">document.write('<small><a href="#" onClick="history.back();return false;"><?php echo $text[562]?><\/a><\/small>');</script>
</body>
</html><?php }
    fwrite($wmlfile,ob_get_contents());
    ob_end_clean();
    fclose($wmlfile);
}
?>
