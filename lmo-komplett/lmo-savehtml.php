<?
/**
 * lmo-savehtml.php: HTML-Ausgabe von Tabelle, aktuellem Spieltag und folgenden Spieltag
 * In der Datei lmo-savefile.php muss über der Zeile
 *  $datei = fopen($file,"w");
 *
 * folgende Zeile hinzugefügt werden:
 *
 *  include("lmo-savehtml.php");	
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
if($st>0){$actual=$st;}else{$actual=$stx;}
if($lmtype==0){
	for($i1=0;$i1<$anzsp;$i1++){
		if ($goala[$actual-1][$i1]=="-1") $goala[$actual-1][$i1]="_";
		if ($goalb[$actual-1][$i1]=="-1") $goalb[$actual-1][$i1]="_";
	}
	$endtab=$actual;
	include("lmo-calctable.php");
	for($i1=0;$i1<$anzsp;$i1++){
		if ($goala[$actual-1][$i1]=="_") $goala[$actual-1][$i1]="-1";
		if ($goalb[$actual-1][$i1]=="_") $goalb[$actual-1][$i1]="-1";
	}
}
$actual=$st;
if($lmtype==0){
	isset($tab0) ? $table1=$tab0 : $table1=$tab1;
	if (isset($table1)) {
		$wmlfile= @fopen($wmldir.basename($file)."-st.html","wb");
		$wmloutput="<BODY BGCOLOR=\"#FFFFFF\"><BR>\n";
		$wmloutput.="<html><p align=\"center\" STYLE=\"font-family:Verdana,arial,helvetica;font-size:12pt\"><strong>$titel</strong><br></p>\n";
		$wmloutput.="<table CELLSPACING=\"0\" title=\"Spiele\" align=\"center\">\n";
		$wmloutput.="<tr><td align=\"center\">\n";
		$datumanz=$actual-1;
		$wmloutput.="<p STYLE=\"font-family:Verdana,arial,helvetica;font-size:10pt\"><strong>$actual. Spieltag - $datum1[$datumanz] bis $datum2[$datumanz]</strong><br><br>\n";
		$wmloutput.="<table CELLSPACING=\"0\" STYLE=\"border-top: 1px black solid; border-right: 1px black solid; border-bottom: 1px black solid; border-left: 1px black solid\" title=\"Spiele\" align=\"center\">\n";
		for($i1=0;$i1<$anzsp;$i1++){ if(($teama[$actual-1][$i1]>0) && ($teamb[$actual-1][$i1]>0)) {
			
			$heimteam=$teams[$teama[$actual-1][$i1]];
			$gastteam=$teams[$teamb[$actual-1][$i1]];
			$heimtore=$goala[$actual-1][$i1];
			$gasttore=$goalb[$actual-1][$i1];
			if ($gasttore<0) $gasttore="_";
			if ($heimtore<0) $heimtore="_";
			
			// * Spielfrei-Hack-Beginn1	- Autor: Bernd Hoyer - eMail: info@salzland-info.de
			if (($anzteams-($anzst/2+1))!=0){
			$spielfreiaa[$i1]=$teama[$actual-1][$i1];
			$spielfreibb[$i1]=$teamb[$actual-1][$i1];
			}
			// * Spielfrei-Hack-Ende1- Autor: Bernd Hoyer - eMail: info@salzland-info.de 	
			if($mterm[$actual-1][$i1]>0){$dum1=strftime($datf, $mterm[$actual-1][$i1]);}else{$dum1="";} // Anstosszeit einblenden
					
			$wmloutput.="<td><tr><td>$dum1&nbsp;</td><td>$heimteam</td><td>-</td><td>$gastteam&nbsp;</td><td align=\"right\">$heimtore</td><td>:</td><td align=\"left\">$gasttore&nbsp;</td></tr>\n";
		}
		}
		
		
		$wmloutput.="</table></p>\n";
		
		if (($anzteams-($anzst/2+1))!=0){
			$spielfreicc=array_merge($spielfreiaa,$spielfreibb);
			$wmloutput.="<table CELLSPACING=\"0\" STYLE=\"border-top: 0px black solid; border-right: 0px black solid; border-bottom: 0px black solid; border-left: 0px black solid\" title=\"Spielfrei\" align=\"center\">\n";
			$hoy6=1;			
			for ($hoy9=1;$hoy9<$anzteams+1;$hoy9++) {
			if (in_array($hoy9,$spielfreicc)) {
			}
			else {
				if ($hoy6==1) {
				$wmloutput.="<tr><td><p STYLE=\"font-family:Verdana,arial,helvetica;font-size:10pt\" align=\"center\">Spielfrei: <br>\n";
				}
				else {$wmloutput.="&nbsp;\n";}
				$wmloutput.="$teams[$hoy9]&nbsp;\n";
				$hoy6=$hoy6+1;
			}
			}
			$wmloutput.="</p></td></tr></table>\n";
		}
		
		$wmloutput.="</td></tr>\n";
		
		$wmloutput.="<tr><td align=\"center\">\n";
		$wmloutput.="<p>&nbsp;</p>\n";
		$wmloutput.="<p STYLE=\"font-family:Verdana,arial,helvetica;font-size:10pt\"><strong>Tabelle - $actual. Spieltag</strong><br><br>\n";
		$datumanz=$actual-1;
		$wmloutput.="<table CELLSPACING=\"0\" STYLE=\"border-top: 1px black solid; border-right: 1px black solid; border-bottom: 1px black solid; border-left: 1px black solid\" title=\"tabelle\" align=\"center\">\n";
		$wmloutput.="<tr><td STYLE=\"border-bottom: 1px black solid\">Pl&nbsp;</td><td STYLE=\"border-bottom: 1px black solid\">Team&nbsp;</td><td align=\"center\" STYLE=\"border-bottom: 1px black solid\">Spiele&nbsp;</td><td STYLE=\"border-bottom: 1px black solid\" align=\"center\">Pkt.</td><td STYLE=\"border-bottom: 1px black solid\">&nbsp;</td><td STYLE=\"border-bottom: 1px black solid\" align=\"center\">$nametor&nbsp;</td><td align=\"right\" STYLE=\"border-bottom: 1px black solid\">&nbsp;&nbsp;Diff.</td></tr>\n";
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
		$wmloutput.="</td></tr>\n";
		$wmloutput.="<tr>\n";
		$wmloutput.="<td><br><p STYLE=\"font-family:Verdana,arial,helvetica;font-size:8pt\" align=\"center\">Hinweis: Tabellenstand ohne vorgezogene Spiele!</p><br></td>\n";
		$wmloutput.="</tr>\n";

if ($actual==$anzst){		
		$wmloutput.="<tr><td align=\"center\">\n";
		$wmloutput.="<p STYLE=\"font-family:Verdana,arial,helvetica;font-size:10pt\"><strong>Saison-Ende!</strong>\n<table title=\"spieltag\" align=\"center\">\n";
		
		$wmloutput.="</table>\n</p>";
		$wmloutput.="</td></tr>\n";
		
}else{
		$wmloutput.="<tr><td align=\"center\">\n";
		$actual=$actual+1;
		$datumanz=$actual-1;
		$wmloutput.="<p STYLE=\"font-family:Verdana,arial,helvetica;font-size:10pt\"><strong>$actual. Spieltag - $datum1[$datumanz] bis $datum2[$datumanz]</strong><br><br>\n";
		$wmloutput.="<table CELLSPACING=\"0\" STYLE=\"border-top: 1px black solid; border-right: 1px black solid; border-bottom: 1px black solid; border-left: 1px black solid\" title=\"Spieltag\" align=\"center\">\n";
		for($i1=0;$i1<$anzsp;$i1++){ if(($teama[$actual-1][$i1]>0) && ($teamb[$actual-1][$i1]>0)) {
			
			$heimteam=$teams[$teama[$actual-1][$i1]];
			$gastteam=$teams[$teamb[$actual-1][$i1]];
			$heimtore=$goala[$actual-1][$i1];
			$gasttore=$goalb[$actual-1][$i1];
			if ($gasttore<0) $gasttore="_";
			if ($heimtore<0) $heimtore="_";
			
			 // * Spielfrei-Hack-Beginn1	- Autor: Bernd Hoyer - eMail: info@salzland-info.de
			if (($anzteams-($anzst/2+1))!=0){
			$spielfreiaa[$i1]=$teama[$actual-1][$i1];
			$spielfreibb[$i1]=$teamb[$actual-1][$i1];
			}
			// * Spielfrei-Hack-Ende1- Autor: Bernd Hoyer - eMail: info@salzland-info.de 	
			if($mterm[$actual-1][$i1]>0){$dum1=strftime($datf, $mterm[$actual-1][$i1]);}else{$dum1="&nbsp;";} // Anstosszeit einblenden
					
			$wmloutput.="<tr><td>$dum1&nbsp;</td><td>$heimteam</td><td>-</td><td>$gastteam&nbsp;</td><td align=\"right\">$heimtore</td><td>:</td><td align=\"left\">$gasttore&nbsp;</td></tr>\n";
		}
		}
		$wmloutput.="</table></p>\n";

		if (($anzteams-($anzst/2+1))!=0){
			$spielfreicc=array_merge($spielfreiaa,$spielfreibb);
			$wmloutput.="<table CELLSPACING=\"0\" STYLE=\"border-top: 0px black solid; border-right: 0px black solid; border-bottom: 0px black solid; border-left: 0px black solid\" title=\"Spielfrei\" align=\"center\">\n";
			$hoy6=1;			
			for ($hoy9=1;$hoy9<$anzteams+1;$hoy9++) {
			if (in_array($hoy9,$spielfreicc)) {
			}
			else {
				if ($hoy6==1) {
				$wmloutput.="<tr><td><p STYLE=\"font-family:Verdana,arial,helvetica;font-size:10pt\" align=\"center\">Spielfrei: <br>\n";
				}
				else {$wmloutput.="&nbsp;\n";}
				$wmloutput.="$teams[$hoy9]&nbsp;\n";
				$hoy6=$hoy6+1;
			}
			}
			$wmloutput.="</p></td></tr></table>\n";
		}

}		
				
		
		
		
		
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
?>