<?php
echo("<card id=\"save\" title=\"Speicherung\">\n");
echo("<p>\n");

########################### Abspeichern der Ergebnisse #########################################################

	require_once("ini.fct");
	
	$result = FALSE;
	
	for($i=0;$i<$anzsp;$i++)
	{ 
		$spielid=$i+1;
		
		if(($teama[$st-1][$i]>0) && ($teamb[$st-1][$i]>0))
		{ 
                         // Einlesen der Tore der Heimmannschaften
			$Tmp = ReadIniValue($file, "Round".$st, "GA".$spielid);       
                         // wurde noch kein Ergebnis eingetragen, dann steht dort -1
		   if ($Tmp == "-1")
		   {
				$heimtore = "heim".$i;
				$gasttore = "gast".$i;
				
				$heim_goal=${$heimtore};
				$gast_goal=${$gasttore};

				if ($heim_goal!="" && $gast_goal!="")
				{
					                   // darf eingetragen werden
			      $result1 = WriteIniValue($file, "Round".$st, "GA".$spielid, $heim_goal); 
			      $result2 = WriteIniValue($file, "Round".$st, "GB".$spielid, $gast_goal);
			      $result3 = WriteIniValue($file, "Options", "Actual", $st);
					$result = $result1 && $result2 && $result3;  
				}#  Ende if (${$heimtore}!="" && ${$gasttore}!="")
			 } # Ende if ($Tmp == "-1")
		} # Ende if(($teama[$st-1][$i]>0) && ($teamb[$st-1][$i]>0))
	} # Ende for($i=0;$i<$anzsp;$i++)
	
	if ($result)
		echo "Speicherung erfolgreich";
	else
		echo "Speicherung fehlgeschlagen";
	?>
	<br/>
	<a href="<?php echo $addi.$file; ?>&amp;op=day">zur&#xFC;ck</a>
<?php
################################################################################################################
?>