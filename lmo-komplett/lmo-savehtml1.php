<?
/**
 * lmo-savehtml1.php: HTML-Ausgabe von Tabelle, aktuellem Spieltag und folgenden Spieltag
 * In der Datei lmo-savefile.php muss über der Zeile
 *  $datei = fopen($file,"w");
 *
 * folgende Zeile hinzugefügt werden:
 *
 *  include("lmo-savehtml1.php");	
 *
 * 
 * Autor: Bernd Hoyer, basierend auf dem LMO3.02
 * Verbesserungen, Bugs etc. bitte nur in das Forum bei Hollwitz.net
 * 
 */

/*
 * Gib hier bitte ein, in welchem Verzeichnis, die HTML-Dateien gespeichert werden sollen.
 * Achte darauf, daß das der Systempfad (und nicht die URL) des Verzeichnisses sein muß!
 * Achte auch darauf, daß das Verzeichnis die Zugriffsrechte (chmod) 777 haben muß!
 */
$wmldir="output/";
/*
 * Ab hier bitte nichts mehr ändern!
 *
 */
/*
 * Spieltag als html-Datei ausgeben: Die Datei ist im Ligenverzeichnis und hat den Namen der l98-Datei plus "-st.html"
 *   
 */
if(($HTTP_SESSION_VARS['lmouserok']==2)||($HTTP_SESSION_VARS['lmouserok']==1)){
if($st>0){$actual=$anzst;}else{$actual=$stx;}
if($lmtype==0){
	for($i1=0;$i1<$anzsp;$i1++){
		if ($goala[$actual-1][$i1]=="-1") $goala[$actual-1][$i1]="_";
		if ($goalb[$actual-1][$i1]=="-1") $goalb[$actual-1][$i1]="_";
	}
	$endtab=$actual;
	include("lmo-calctable.php");
	for($i1=0;$i1<$anzsp;$i1++){
		if ($goala[$endtab-1][$i1]=="_") $goala[$endtab-1][$i1]="-1";
		if ($goalb[$endtab-1][$i1]=="_") $goalb[$endtab-1][$i1]="-1";
	}
}
if($lmtype==0){
	isset($tab0) ? $table1=$tab0 : $table1=$tab1;
	if (isset($table1)) {
		$wmlfile= @fopen($wmldir.basename($file)."-sp.html","w");
		$wmloutput="<BODY BGCOLOR=\"#FFFFFF\"><BR>\n";
		$wmloutput.="<html><p align=\"center\" STYLE=\"font-family:Verdana,arial,helvetica;font-size:12pt\"><strong>$titel</strong><br></p>\n";
		
		$wmloutput.="<table CELLSPACING=\"0\" title=\"Spiele\" columns=\"4\" align=\"center\">\n";
		$wmloutput.="<tr><td>\n";
		for ($y1=1;$y1<$anzst+1;$y1++) {
		$wmloutput.="<tr><td>\n";
		$datumanz=$y1-1;
		
		$wmloutput.="<p align=\"center\" STYLE=\"font-family:Verdana,arial,helvetica;font-size:10pt\"><strong>$y1. Spieltag - $datum1[$datumanz] bis $datum2[$datumanz]</strong>\n<table CELLSPACING=\"0\" title=\"spieltag\" align=\"center\">\n";
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
					
			$wmloutput.="<tr><td>$dum1&nbsp;</td><td>$heimteam</td><td>-</td><td>$gastteam&nbsp;</td><td align=\"right\">$heimtore</td><td>:</td><td align=\"right\">$gasttore&nbsp;</td></tr>\n";
		}		
		$actual=$actual+1;
		}
		$wmloutput.="</table></p>\n";
		
		if (($anzteams-($anzst/2+1))!=0){
			$spielfreicc=array_merge($spielfreiaa,$spielfreibb);
			unset($spielfreiaa);
			unset($spielfreibb);
			$wmloutput.="<table CELLSPACING=\"0\" STYLE=\"border-top: 0px black solid; border-right: 0px black solid; border-bottom: 0px black solid; border-left: 0px black solid\" title=\"Spielfrei\" align=\"center\">\n";
			$hoy7=1;	
			for ($hoy10=1;$hoy10<$anzteams+1;$hoy10++) {
			if (in_array($hoy10,$spielfreicc)) {
			}
			else {
				if ($hoy7==1) {
				$wmloutput.="<tr><td><p STYLE=\"font-family:Verdana,arial,helvetica;font-size:10pt\" align=\"center\">Spielfrei: <br>\n";
				}
				else {$wmloutput.="&nbsp;\n";}
				$wmloutput.="$teams[$hoy10]&nbsp;\n";
				$hoy7=$hoy7+1;
			}
			}
			unset($spielfreicc);
			$wmloutput.="</p></td></tr></table>\n";
		}
		
		$wmloutput.="<p>&nbsp;</p>\n";
		$wmloutput.="</td></tr>\n";
		}
		$wmloutput.="</td></tr>\n";
		
		$wmloutput.="<tr><td>\n";
		$wmloutput.="<p>&nbsp;</p>\n";
		$wmloutput.="<p align=\"center\" STYLE=\"font-family:Verdana,arial,helvetica;font-size:10pt\"><strong>Aktueller Tabellenstand</strong><br><br>\n";
		$datumanz=$actual-1;
		$wmloutput.="<table CELLSPACING=\"0\" STYLE=\"border-top: 1px black solid; border-right: 1px black solid; border-bottom: 1px black solid; border-left: 1px black solid\" title=\"tabelle\" align=\"center\">\n";
		$wmloutput.="<tr><td STYLE=\"border-bottom: 1px black solid\">Pl&nbsp;</td><td STYLE=\"border-bottom: 1px black solid\">Team&nbsp;</td><td align=\"center\" STYLE=\"border-bottom: 1px black solid\">Spiele&nbsp;</td><td STYLE=\"border-bottom: 1px black solid\" align=\"center\">Pkt.</td><td STYLE=\"border-bottom: 1px black solid\">&nbsp;</td><td STYLE=\"border-bottom: 1px black solid\" align=\"center\">$nametor&nbsp;</td><td align=\"right\" STYLE=\"border-bottom: 1px black solid\">&nbsp;&nbsp;Diff.&nbsp;</td></tr>\n";
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
			$spieleteam=$spiele[$i4];
						
			$wmloutput.="<tr><td align=\"right\">$platz&nbsp;</td><td>$teamname&nbsp;</td><td align=\"right\">$spieleteam&nbsp;</td><td align=\"right\">$pluspunkte";
			if ($minus==2) {
				$wmloutput.=":</td><td align=\"left\">$minuspunkte&nbsp;";
			}
			if ($minus<>2) {
				$wmloutput.="</td><td align=\"left\">&nbsp;";
			}
			
			$wmloutput.="<td align=\"right\">$plustore:$minustore&nbsp;</td><td align=\"right\">&nbsp;&nbsp;$torverhaeltnis</td>";
			
			$wmloutput.="</tr>\n";
		}
		
		$wmloutput.="</table></p>\n";
		$wmloutput.="<p>&nbsp;</p>\n";
		$wmloutput.="</td></tr>\n";

		$wmloutput.="<tr>\n";
		$wmloutput.="<td><br><p STYLE=\"font-family:Verdana,arial,helvetica;font-size:8pt\" align=\"center\"><a href=\"http://www.salzland-info.de\">LMO-SaveHTML 1.26 © 2002 by Bernd Hoyer</a></p></td>\n";
		$wmloutput.="</tr>\n";
		$wmloutput.="</table></BODY></html>\n";
		fwrite($wmlfile,$wmloutput);
		$wmloutput="";
		fclose($wmlfile);
	}
}
}
?>