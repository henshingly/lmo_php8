<?
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


if(($_SESSION['lmouserok']==2)||($_SESSION['lmouserok']==1)){

if($st>0){$actual=$anzst;}else{$actual=$stx;}
if($lmtype==0){
	for($i1=0;$i1<$anzsp;$i1++){
		if ($goala[$actual-1][$i1]=="-1") $goala[$actual-1][$i1]="_";
		if ($goalb[$actual-1][$i1]=="-1") $goalb[$actual-1][$i1]="_";
	}
	$endtab=$actual;
	include(PATH_TO_LMO."/lmo-calctable.php");
	for($i1=0;$i1<$anzsp;$i1++){
		if ($goala[$endtab-1][$i1]=="_") $goala[$endtab-1][$i1]="-1";
		if ($goalb[$endtab-1][$i1]=="_") $goalb[$endtab-1][$i1]="-1";
	}
}
if($lmtype==0){
	isset($tab0) ? $table1=$tab0 : $table1=$tab1;
	if (isset($table1)) {
		ob_start();
		$wmlfile= fopen($diroutput.basename($file)."-sp.html","wb");?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
					"http://www.w3.org/TR/html4/loose.dtd">
<html lang="de">
<head>
  <title><?=$titel?></title>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" >
  <style type="text/css">
   body {background:#fff; color:#000; font: sans-serif 10pt;padding:auto;}
   caption, p, h1 {margin: 3pt auto; text-align:center;}
   table {margin:auto; max-width:200mm;}
   #tabelle{border:1pt solid #000;}
   table table {border:1pt solid #000; margin:20pt 0 2pt; width:100%;}
   td {padding: 0;}
   th {border-bottom: 1px solid #000;}
   h1 {font:14pt bolder;}
   caption {font-weight:bolder;}
  </style>
</head>
<body>
  
  <h1><?=$titel?></h1>
  <table>
    <tr>
      <td><?
		for ($y1=1;$y1<$anzst+1;$y1++) {
      $datumanz=$y1-1;?>
	<table>
  <caption><?=$y1?>. Spieltag - <?=$datum1[$datumanz]?> bis <?=$datum2[$datumanz]?></caption><?
    
		  for($i1=0;$i1<$anzsp;$i1++){ if(($teama[$y1-1][$i1]>0) && ($teamb[$y1-1][$i1]>0)) {
			
  			$heimteam=$teams[$teama[$y1-1][$i1]];
  			$gastteam=$teams[$teamb[$y1-1][$i1]];
  			$heimtore=$goala[$y1-1][$i1];
  			$gasttore=$goalb[$y1-1][$i1];
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
       <td><?=$dum1?>&nbsp;</td>
       <td align="right"><?=$heimteam?></td>
       <td>-</td>
       <td><?=$gastteam?>&nbsp;</td>
       <td align="right"><?=$heimtore?></td>
       <td>:</td>
       <td align="left"><?=$gasttore?>&nbsp;</td>
     </tr><?
		  }		
		  $actual=$actual+1;
		}?>
	</table>
  <?
    if (($anzteams-($anzst/2+1))!=0){
			$spielfreicc=array_merge($spielfreiaa,$spielfreibb);
			unset($spielfreiaa);
			unset($spielfreibb);
			$i=1;	
			for ($j=1;$j<$anzteams+1;$j++) {
			if (!in_array($j,$spielfreicc)) {
			  if ($i==1) {?>
				<p>Spielfrei: <?
        }?><?=$teams[$j]?>&nbsp;<?
			  $i++;
		  }
		}?>
	</p><?
		unset($spielfreicc);
	}
 }
  $datumanz=$actual-1;?>
  </td>
  </tr>
</table>
	<table id="tabelle">
    <caption>Aktueller Tabellenstand</caption>
 		<tr>
       <th>Pl&nbsp;</th>
       <th>Team&nbsp;</th>
       <th>Spiele&nbsp;</th>
       <th>Pkt.</th>
       <th>&nbsp;</th>
       <th><?=$nametor?>&nbsp;</th>
       <th align="right" >&nbsp;&nbsp;Diff.</th>
     </tr><?
    for ($i1=0;$i1<$anzteams;$i1++){
			$platz=$i1+1;
			$i4=(int)substr($table1[$i1],35,7);
			$teamname=$teams[$i4];
			$pluspunkte=$punkte[$i4];
			$minuspunkte=$negativ[$i4];
			$kegelnholz=$dtore[$i4];
			$plustore=$etore[$i4];
			$minustore=$atore[$i4];
			$torverhaeltnis=$dtore[$i4];
			$spieleteam=$spiele[$i4];?>
						
		<tr>
       <td align="right"><?=$platz?>&nbsp;</td>
       <td><?=$teamname?>&nbsp;</td>
       <td align="right"><?=$spieleteam?>&nbsp;</td>
       <td align="right"><?=$pluspunkte?>
 	   <?if ($minus==2) {
      ?>:</td>
        <td align="left"><?=$minuspunkte?>&nbsp;<?
 			}else{?>
 			 </td>
        <td align="left">&nbsp;<?
 			}?>
 			 <td align="right"><?="$plustore:$minustore"?>&nbsp;</td>
        <td align="right">&nbsp;&nbsp;<?=$torverhaeltnis?></td>
 		 </tr><?
		}?>
  </table>
</body>
</html><?}
    fwrite($wmlfile,ob_get_contents());
    ob_end_clean();
		fclose($wmlfile);
	
}}
?>