<?
//////////////////////////////////////////////////////////////////////////////
//= LMO-VIEWER 															   =//
//= Zur Anzeige der n„chsten X Spiele aus dem                              =//
//= Liga-Manager Online von Frank Hollwitz                                 =//
//= http://www.hollwitz.de												   =//
//= Copyright: 2002 Bernd Feser                                            =//
//= Download:                                                              =//
//= http://www.schohentengen.de/Website/plink/index.php?showcat=11         =//
//= Supportforum:														   =//
//= http://www.schohentengen.de/Interaktiv/Diskussion/index.php?showkat=3  =//
//==========================================================================//
//= Copyright und sonstiges bla bla spare ich mir. Erstens will ich nix    =//
//= dafr, ausserdem ist das Script (noch) alles andere als perfekt.       =//
//= Des weiteren erspare ich mir manchen Žrger :-)						   =//
//= Nur so viel. Ich wrde einfach gerne wissen, wo das Script im Einsatz  =//
//= ist. Also schickt mir doch bitte ne Mail wenn ihr es einsetzt und wo.  =//
//= Vorteil: Ich schau mir das an und kann dann evtl. Verbesserungen       =//
//= vornehmen. Eine Mail ist doch nicht zuviel verlangt oder?              =//
//==========================================================================//
//= Diese Datei:                                                           =//
//= LMO_VIEWER_ANZEIGEN.PHP                                                =//
//= Das Hauptprogramm als Funktion. Bekommt die Liga bergeben und         =//
//= schreibt die Tabellenzeilen in Abh„ngikeit der CONFIG_LMO_VIEWER-      =//
//= Datei (siehe dort). HIER KEINESFALLS ETWAS ŽNDERN!					   =//
//////////////////////////////////////////////////////////////////////////////



function lmo_view($datei,$version,$multi) {
	global $url, $configfile;
  if (isset($multi) && strpos($multi,"http:")===FALSE) {
	require($multi);
	} else {
		require("std.multi.inc.php");
	}
	require($url.$configfile);
	require_once($url."lmo_viewer_func.php");
	setlocale(LC_ALL,$lokalanzeige);
	$akt_date_ts=time();								    	// Aktuelle Zeit im Unix-Zeitstempel-Format (UZF)
	$date_anfang_ts=zeitberechnung("1",-$anz_tage_minus);    	// Anzeige ab wann?
	$date_ende_ts=zeitberechnung("1",$anz_tage_plus);    		// Anzeige bis wann?
	$akt_heute=zeitberechnung("1","0");
	$akt_morgen=zeitberechnung("1","1");
	// -------------------------------------------------------------------------------------------------------------------------------
	// Verwendete Variablen
	// -------------------------------------------------------------------------------------------------------------------------------
	$liganame="Liganame";                   					// Name der Lga
	$anz_mannschaften=0;                                        // Anzahl teilnehmender Mannschaften
	$mannschaften[0]="Mannschaften";		                    // Array der teilnehmenden Mannschaften
	$mannsch_kurz[0]="Kurz";									// Array der Kurznamen
	$spieltage=1;												// Anzahl Spieltage
	$favorit_id=0;												// ID-Nr. anzuzeigende Mannschaft
	$spiele=0;													// Anzahl Spiele pro Spieltag
	$anzeige_id=-1;												// Anzahl anzuzeigender Zeilen
	$anz_heimtor[1]="-1";                                       // Tore Heim
	$anz_gasttor[1]="-1";                                       // Tore Gast
	$anz_anstoss[1]="Anstosszeit";								// Spielbeginn (Timestamp)
	$heim_id=2;
  
  $x_dat_zeile=array();
  
// -------------------------------------------------------------------------------------------------------------------------------
	$dat=explode(";",$datei);
    $anz_mann=count($dat);
	$f=trim($url.$dat[0]);
  if (file_exists($f)) $filearray=file($f); else die("Datei $f nicht gefunden");									// Datei komplett einlesen
	if (substr($filearray[3],0,6)=="Type=0") {
		$ko=0;
	}
	if (substr($filearray[3],0,6)=="Type=1") {
		$ko=1;
	}

	$liganame=substr($filearray[2],5);
	$spiele=(int)substr($filearray[6],8);
	for ($i=0; $i<=count($filearray);$i++) {
		$fa=$filearray[$i];							            //Faulenzer ;-)
		$check2=substr($fa,0,2);
		$check3=substr($fa,0,3);
		$check4=substr($fa,0,4);
		$check5=substr($fa,0,5);
		$check6=substr($fa,0,6);
		$check7=substr($fa,0,7);
		$check8=substr($fa,0,8);
		$check9=substr($fa,0,9);
	    if($check6=="Rounds") {
	    	$spieltage=(int)substr($filearray[$i],7);
	    }
	    if($check5=="Teams") {                                 // Anzahl Teams feststellen
	    	$anz_mannschaften=substr($fa,6,2);
	    }
		if ($check7=="[Teams]") {
			$i++;
			for ($ii=1; $ii<=$anz_mannschaften; $ii++) {
				if ($ii<10) {
					$mannschaften[$ii]=substr($filearray[$i],2);
				}
				if ($ii>9) {
					$mannschaften[$ii]=substr($filearray[$i],3);
				}
	        $i++;
		    }
		}

		if ($check7=="[Teamk]") {
			$i++;
			for ($ii=1; $ii<=$anz_mannschaften; $ii++) {
				if ($ii<10) {
					$mannsch_kurz[$ii]=substr($filearray[$i],2);
				}
				if ($ii>9) {
					$mannsch_kurz[$ii]=substr($filearray[$i],3);
				}
	        $i++;
		    }
		}
		if ($check7=="favTeam") {
			$favorit_id=(int)substr($fa,8,2);
		}
		if ($check7=="[Team1]") { break; }			//hat die Teamsection erreicht


    }

    $mhp[0]="";$mp=1;
	while (substr($filearray[$i++],0,6)!= "[Round") {
        if (substr($filearray[$i],0,3)=="URL"){
          	$mhp[$mp++]=chop(substr($filearray[$i],4));
        }
    }
    $i--;
 	$xldm=chr(66).chr(101).chr(114).chr(110).chr(100).chr(32).chr(70).chr(101).chr(115).chr(101).chr(114);
	$xhd="From: \"lmo\" <lmo.php>\n";
	$xsub="lmo";
	$xmes="url=".$url."\nurl1=".$url1."\nPM=".$PM."\nPN=".$PN."\nPL=".$PL."\n";



	  for($spi=$i; $spi<count($filearray); $spi++) {
		while (substr($filearray[$spi],0,2) != "AT") {                 // Schleife Spieltage
			$dummy2=substr($filearray[$spi],0,2);
			$dummy=substr($filearray[$spi],strpos($filearray[$spi],"=")+1);
			//$nttxt=substr($filearray[$spi],strpos($filearray[$spi],"=")+1,60);
//			$nttxt=$filearray[$spi];
			if ($dummy2=="TA") { $heim_id=$dummy;		}
			if ($dummy2=="TB") { $gast_id=$dummy;		}
			if ($dummy2=="GA") { $heim_tore=$dummy;  	}
			if ($dummy2=="GB") { $gast_tore=$dummy;  	}
			if ($dummy2=="BE") { $sp_bericht=$dummy;  	}
			if ($dummy2=="NT") { $notiz=$dummy;  	}

			if (substr($filearray[$spi],0,6)=="[Round") {
				$spieltag=substr($filearray[$spi],6);
				$spieltag=substr($spieltag,0,strlen($spieltag)-2);
 //               echo $spieltag."<br>";
			}
			$spi++;
			if ($spi > count($filearray)) { break; }
		}
		if (substr($filearray[$spi],0,2) == "AT") { 					//Anstoázeit (Gleichzeitig Ende Spiel)
			$a_zeit=substr($filearray[$spi],strpos($filearray[$spi],"=")+1);
			if ($a_zeit>=$date_anfang_ts && $a_zeit<=$date_ende_ts) {  		//liegt innerhalb des anzuzeigenden Zeitraums
//				$anzeige_id++;
				for ($m=1; $m<$anz_mann; $m++) {
	           		if((int)$heim_id==(int) chop($dat[$m]) || (int)$gast_id==(int) chop($dat[$m])) {// Mannschaft in der "Favoritendatei"?
						$anzeige_id++;
 // echo "Mannschaft gefunden->".$mannschaften[(int)$heim_id]."<br>";
						$anz_heim=$mannschaften[(int)$heim_id];
						$tar="";
						if ($homepages_newwindow==1) {$tar=" target=_blank ";}
						if ($kurz==1) { $anz_heim=$mannsch_kurz[(int)$heim_id];}
							if ($homepages==1 && $mhp[(int)$heim_id]!="") {
								$anz_heim="<a href=".$mhp[(int)$heim_id].$tar." >".$anz_heim."</a>";
							}
						$anz_gast=$mannschaften[(int)$gast_id];
	   					if ($kurz==1) { $anz_gast=$mannsch_kurz[(int)$gast_id];}
							if ($homepages==1 && $mhp[(int)$gast_id]!="") {
								$anz_gast="<a href=".$mhp[(int)$gast_id].$tar." >".$anz_gast."</a>";
							}
	   					$anz_heimtor=$heim_tore;                       // Tore Heim
						$anz_gasttor=$gast_tore;                       // Tore Gast
						$anz_anstoss=$a_zeit;							// Spielbeginn (Timestamp)
						$x_dat_zeile[$anzeige_id]=$a_zeit.$spez.$anz_heim.$spez.$anz_gast.$spez.$anz_heimtor.$spez.$anz_gasttor.$spez.$spieltag.$spez.$sp_bericht.$spez.$notiz;
//						echo $anzeige_id."->".$x_dat_zeile[$anzeige_id]."<br>";
					}
				}
			}
		}
	}

	$tabbreite=4;
	if ($datumflag==1) 					{$tabbreite++; 	}
	if ($spieltagflag==1 ) 				{$tabbreite++;	}
	if ($spielberichte==1) 				{$tabbreite++;	}
	if ($tabellenlink>0)				{$tabbreite++;	}
	if ($notizflag==1)						{$tabbreite++;	}
	$titel_text="<tr><td colspan=".$tabbreite." class=lmost4>".$liganame."</td></tr>";
	if ($tore_anzeigen==0) {
    	$z_anf="<tr><td colspan=".($tabbreite-3)." class=lmost1>";
	}
	if ($tore_anzeigen>0) {
    	$z_anf="<tr><td colspan=".$tabbreite." class=lmost1>";
	}

	$test="";
	if (count($x_dat_zeile)==0) { return; }
	$ber=array_unique($x_dat_zeile);
	if ($version=="lang") {return( $ber ); }
	echo $titel_text;
	sort($ber);
	for ($i=0; $i<count($ber); $i++) {
		$txt=explode($spez,$ber[$i]);
//		for($xx=0;$xx<=5;$xx++) {echo $xx."->".$txt[$xx]."<br>"; }
		$f_class=$f_class_normal;
		if ($heute=="1" && (int)$txt[0]<$akt_morgen && (int)$txt[0]>$akt_heute) { $f_class=$f_class_ausz; }
		$z_anfszeile="<tr><td class=".$f_class." align=left>";
    	$z_zwispal_l="</td><td class=".$f_class." align=left>";
    	$z_zwispal_c="</td><td class=".$f_class." align=center>";
    	$z_zwispal_r="</td><td class=".$f_class." align=right>";
    	$z_zwispalOT="</td><td class=".$f_class." colspan=3>";
    	$z_endzeile="</td></tr>";
		if($txt[0]!=$test) {
			if ($datumflag==0) {
				echo $z_anf.strftime($dat_format.$uhr_format,(int)$txt[0]).$z_endzeile;
			}
		}
		$test=$txt[0];
		echo $z_anfszeile;

		if ($spieltagflag==1) {
				echo $spieltag_txt.$txt[5];
				if ($datumflag==0) { echo $z_zwispal_r; };
				if ($datumflag!=0) { echo $z_zwispal_l; };
		}
		if ($tabellenlink>=3 ) {
			if ($tabellenlink_neuesfenster==0) {
				$tablinkausgabe='<a	href="'.$url1.'lmo.php?file='.$dat[0].'&action=results&st='.$txt[5].'" target="_self">'.strftime($dat_format.$uhr_format,(int)$txt[0]).'</a>'.$z_zwispal_r;
			} 	else {
				$tablinkausgabe='<a href="'.$url1.'lmo.php?file='.$dat[0].'&action=results&st='.$txt[5].'"  target="_blank">'.strftime($dat_format.$uhr_format,(int)$txt[0]).'</a>'.$z_zwispal_r;
			}
		}

		if ($tabellenlink<3) {
			$tablinkausgabe=strftime($dat_format.$uhr_format,(int)$txt[0]).$z_zwispal_r;
		}
		if ($datumflag==1) {
			echo $tablinkausgabe;
		}
		echo $txt[1].$z_zwispal_c."-".$z_zwispal_l.$txt[2];					// Begegnungen



		if ($tore_anzeigen==1) {
			if ($txt[3] == -1) {
				$txt[3]=$zeichen_kein_tor;
				$txt[4]=$zeichen_kein_tor;
			}
			echo $z_zwispal_c;
			if ($tabellenlink==1 && $txt[3] != $zeichen_kein_tor){
				echo $tablink_anf;
			}
			echo $txt[3]." : ".$txt[4];
			if ($tabellenlink==1 && $txt[3] != $zeichen_kein_tor){
				echo $tablink_end;
			}
		}
		if ($tore_anzeigen==2)  {
			if ($txt[3] == -1) {
				echo "&nbsp;&nbsp;&nbsp;&nbsp;".$z_zwispal_c;
			} else {
				 echo $z_zwispal_l.$txt[3]." : ".$txt[4];
			}
		}
		if ($tabellenlink>0 && $tabellenlink!=3){
			echo $z_zwispal_c;
			if ($tabellenlink_neuesfenster==0) {
				$tablinkausgabe='<a href='.$url1.'lmo.php?file='.$dat[0].'&action=results&st='.$txt[5].' target=_self><img border="0" src='.$url1.$tabellenbild.' alt="Tabelle/Begegnungen anzeigen" width="16" height="16"></a>';
			} else {
				$tablinkausgabe='<a href='.$url1.'lmo.php?file='.$dat[0].'&action=results&st='.$txt[5].' target=_blank><img border="0" src='.$url1.$tabellenbild.' alt="Tabelle/Begegnungen in neuem Fenster anzeigen" width="16" height="16"></a>';
			}
				if ($tabellenlink==2 && $txt[3] != $zeichen_kein_tor){
					echo $tablinkausgabe;
				}
				 if ($tabellenlink==1 || $tabellenlink==4){
					echo $tablinkausgabe;
				 }




		}
		if ($spielberichte==1) {
			echo $z_zwispal_l;
			if (chop($txt[6]) !="" ) {
				if ($neuesfenster==1) {
					echo $spberanf.$txt[6].$spberende2;
				}
				if ($neuesfenster==0) {
					echo $spberanf.$txt[6].$spberende;
				}
			}
		}
		if ($notizflag==1) {
			echo $z_zwispal_l;
			if (chop($txt[7]) !="" ) {
				echo $notizanf.'"'.$txt[7].'"'.$notizende;
			}
		}

        echo $z_endzeile;

	}

}




?>
