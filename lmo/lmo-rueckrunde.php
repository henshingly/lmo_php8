<?php
	require_once(dirname(__FILE__).'/init.php');
	require_once(PATH_TO_ADDONDIR."/classlib/ini.php");
	
	if(isset($file) && $file != "")
	{
		$liga = new Liga();
		if($liga->loadFile(PATH_TO_LMO.'/'.$dirliga.$file))
		{
			completeSchedule($liga);			
			$liga->writeFile(PATH_TO_LMO.'/'.$dirliga.$file);
			echo getMessage($text[3002]);
		}
	}
	
	function completeSchedule($liga)
	{
		$rounds = $liga->options->keyValues["Rounds"];
		
		if($rounds % 2 == 0)
		{
			$gamesPerDay = $liga->options->keyValues['Matches'];
			$daysPerRound = $rounds/2;
			
			for($i = 0; $i < $rounds/2; $i++)
			{
				if(isset($liga->spieltage[$i + $daysPerRound]))
				{
					$liga->spieltage[$i + $daysPerRound]->partien = array();
				}
				else
				{				
					$spieltag = new Spieltag($i + $daysPerRound + 1, "", "");
					$liga->addSpieltag($spieltag);
				}
				
				foreach($liga->spieltage[$i]->partien AS $p)
				{
					$partie = new Partie($p->spNr, NULL, NULL, $p->gast, $p->heim, -1, -1, NULL, NULL, NULL, NULL);
					$liga->spieltage[$i + $daysPerRound]->addPartie($partie);					
				}
			}
		}
		else echo getMessage($text[3001], true);;		
	}
?>