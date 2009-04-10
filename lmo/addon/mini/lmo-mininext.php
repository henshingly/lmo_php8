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
  * Version 2.1.2 
  *
  * $Id$
  */

require(dirname(__FILE__).'/../../init.php');
require_once(PATH_TO_ADDONDIR."/classlib/ini.php");

$template_folder = PATH_TO_TEMPLATEDIR.'/mini/';

$mini_standardTemplate = isset($cfgarray['mini']['standardTemplate'])?$cfgarray['mini']['standardTemplate']:"mininext.tpl.php";		// Templatefile
//aus Sicherheitsgründen werden .. gelöscht - somit sind nur templates innerhalb des Templatepfads möglich
$mini_template = isset($_GET['mini_template'])
                     ? str_replace('..','',$_GET['mini_template'])
                     : (isset($mini_template)
                        ? str_replace('..','',$mini_template)
                        : $mini_standardTemplate
                       );

//4-stufiges Fallback für diese Variablen
//1.GET-Parameter->2.Variable vorhanden (include)->3.Configwert->4. Standardwert

//Nicht dokumentierte Steuerparameter für Fortgeschrittene
$mini_withArchiv = isset($_GET['mini_withArchiv'])
                            ? ($_GET['mini_withArchiv']=='1'?1:0)
                            : ( isset($mini_withArchiv) 
                                ? ($mini_withArchiv=='1'?1:0)
                                : (isset($cfgarray['mini']['withArchiv'])
                                   ? $cfgarray['mini']['withArchiv']
                                   : 1
                                  )
                              );
$mini_unGreedy = isset($_GET['mini_unGreedy'])
                     ? ($_GET['mini_unGreedy']=='1'?1:0)
                     : ( isset($mini_unGreedy)
                         ? ($mini_withArchiv=='1'?1:0)
                         :  (isset($cfgarray['mini']['unGreedy'])
                             ? $cfgarray['mini']['unGreedy']
                             : 1
                            )
                       );
$mini_barWidth = isset($_GET['mini_barWidth']) && is_numeric($_GET['mini_barWidth'])
                     ? $_GET['mini_barWidth']
                     : ( isset($mini_barWidth) && is_numeric($mini_barWidth)
                         ? $mini_barWidth
                         : (isset($cfgarray['mini']['barWidth'])
                             ? $cfgarray['mini']['barWidth']
                             : 120
                            )
                       );

$file = isset($_GET['file'])?$_GET['file']:isset($file)?$file:NULL;
$archivFolder = isset($_GET['folder'])?$_GET['folder']:isset($folder)?$folder:basename($ArchivDir);// Default

if (substr($archivFolder,-1) != '/') {
  $archivFolder .= '/';
}

if (strpos($archivFolder,'../')!==false) {
  exit();
}

$a = isset($_GET['a'])?$_GET['a']:isset($a)?$a:NULL; // nr vom team a (wenn nicht angegeben wird favTeam verwendet)
$b = isset($_GET['b'])?$_GET['b']:isset($b)?$b:NULL; // nr vom team b (wenn nicht angegeben wird nächster Gegner von a verw.)

$mini_cache_refresh = isset($mini_cache_refresh)?$mini_cache_refresh:0;

//generate cache-file-id
$multi = md5($file.$archivFolder.$mini_template.$a.$b);

// Load the cache-counter-file for viewers simple cache mechanism
$mini_cache_counter_filename = PATH_TO_LMO.'/'.$diroutput.'mini_'.$multi.'_count.txt';
$mini_cache_counter = 0; //counter for cache hits
if (!file_exists($mini_cache_counter_filename)) {
  touch($mini_cache_counter_filename);
}
$mini_cache_counter_file = fopen($mini_cache_counter_filename,"rb");
$mini_cache_counter = intval(trim(fgets($mini_cache_counter_file)));
fclose($mini_cache_counter_file);

if ($mini_cache_counter==0 || $mini_cache_counter > $mini_cache_refresh) {
  //not cached or cache limit reached -> generate new view
  
  //Falls IFRAME - komplettes HTML-Dokument
  if (basename($_SERVER['PHP_SELF'])=="lmo-mininext.php") {?>
  <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
  					"http://www.w3.org/TR/html4/loose.dtd">
  <html>
  <head>
  <title>lmo-nextgame</title>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" >
  <style type="text/css">
    html,body {margin:0;padding:0;background:transparent;}
  </style>
  </head>
  <body><?php
  }
  
  $template = new HTML_Template_IT($template_folder); // verzeichnis
  //$tpl = new LMO_HTML_Template_IT($tpl_folder); // verzeichnis
  $template->loadTemplatefile($mini_template);
  $team_a = NULL;
  $team_b = NULL;
  $partie = NULL;
  $lastPartie = NULL;
  $liga = new liga();
  if ($file && $liga->loadFile(PATH_TO_LMO.'/'.$dirliga.$file) == TRUE) {
    if (!is_null($a)) {
      $team_a = $liga->teamForNumber($a);
    } elseif (is_null($team_a = $liga->teamForNumber($liga->options->keyValues['favTeam']))) {
      echo getMessage($text['mini'][8],TRUE);
      exit;
    }
  
    if (is_null( $team_b = $liga->teamForNumber($b)) ) {
      // Wir ermitteln den nächsten gegner von a wenn b nicht angegeben ist
      $sortedGames = gamesSortedForTeam ($liga,$team_a,false); // Nur nach der Zeit sortieren unabh. vom spieltag
      $now = time();
      $showLastGame = true;
      foreach ($sortedGames as $game) {
        if ( $now < $game['partie']->zeit ) { // letztes Spiel finden
        $partie = $game['partie'];
        $template->setVariable("gameTxt",$text['mini'][1]); // Es gibt ein zukünftiges Spiel
        $template->setVariable("gameNote",$partie->notiz);
        break; // gegner gefunden
        }
        $lastPartie = $game['partie'];
      }
      if (!isset($partie) ) { // Keine weitere Partie gefunden, daher letzte Partie anzeigen (Saison beendet)
        $partie = $lastPartie;
        unset($lastPartie);
        $showLastGame = FALSE;
        $template->setVariable("gameTxt",$text['mini'][2]);
      } else {
        $showLastGame = TRUE;
      }
  
      if($partie->heim == $team_a) {
        $team_b = $partie->gast;
      }
      else {
        $team_b = $partie->heim;
      }
  
    } else { // a und b wurden angegeben also ergebnis dieser Partie anzeigen
      $partie = $liga->partieForTeams($team_a,$team_b);
      $template->setVariable("gameTxt",$text['mini'][3]);
    }
  
    if (isset($partie) ) {
  
      $template->setVariable("gameDate",$partie->datumString());
      $template->setVariable("gameTime",$partie->zeitString());
      $template->setVariable("ligaDatum",$text['mini'][14].": ".$liga->ligaDatumAsString("%x"));
       
       $now = time();
       $gameDateTime = $partie->zeit;
       $days = floor(($gameDateTime-$now)/86400);
       $rest = ($gameDateTime-$now) - ($days*86400);
       $hours = floor($rest/3600);
       $rest = $rest - ($hours*3600);
       $minutes = floor($rest/60);
       $rest = $rest - ($minutes*60);
      $template->setVariable("countDown",$text['mini'][15].": ".$days.", ".$text['mini'][16].": ".$hours.", ".$text['mini'][17].": ".$minutes); 

      $template->setVariable("copy",str_replace('CLASSLIB_VERSION',CLASSLIB_VERSION,$text['mini'][0]));
      $template->setVariable("imgHomeSmall",HTML_smallTeamIcon($file,$partie->heim->name," alt=''"));
      $template->setVariable("imgHomeBig",HTML_bigTeamIcon($file,$partie->heim->name,"alt=''"));
      $template->setVariable("imgGuestSmall",HTML_smallTeamIcon($file,$partie->gast->name,"alt=''"));
      $template->setVariable("imgGuestBig",HTML_bigTeamIcon($file,$partie->gast->name,"alt=''"));
  
      $template->setVariable("homeName",$partie->heim->name);
      $template->setVariable("guestName",$partie->gast->name);
      $template->setVariable("homeNameMiddle",$partie->heim->mittel);
      $template->setVariable("guestNameMiddle",$partie->gast->mittel);
      $template->setVariable("homeNameShort",$partie->heim->kurz);
      $template->setVariable("guestNameShort",$partie->gast->kurz);
  
      //Vorherige Partie
      if (isset($lastPartie)) {
        $template->setCurrentBlock("previous");
        $template->setVariable("previous_gameDate",$lastPartie->datumString());
        $template->setVariable("previous_gameTime",$lastPartie->zeitString());
        $template->setVariable("previous_imgHomeSmall",HTML_smallTeamIcon($file,$lastPartie->heim->name," alt=''"));
        $template->setVariable("previous_imgHomeBig",HTML_bigTeamIcon($file,$lastPartie->heim->name,"alt=''"));
        $template->setVariable("previous_imgGuestSmall",HTML_smallTeamIcon($file,$lastPartie->gast->name,"alt=''"));
        $template->setVariable("previous_imgGuestBig",HTML_bigTeamIcon($file,$lastPartie->gast->name,"alt=''"));
  
        $template->setVariable("previous_homeName",$lastPartie->heim->name);
        $template->setVariable("previous_guestName",$lastPartie->gast->name);
        $template->setVariable("previous_homeNameMiddle",$lastPartie->heim->mittel);
        $template->setVariable("previous_guestNameMiddle",$lastPartie->gast->mittel);
        $template->setVariable("previous_homeNameShort",$lastPartie->heim->kurz);
        $template->setVariable("previous_guestNameShort",$lastPartie->gast->kurz);
  
        $template->setVariable("previous_hTore",$lastPartie->hToreString());
        $template->setVariable("previous_gTore",$lastPartie->gToreString());
        $template->setVariable("previous_gameTxt",$text['mini'][7]);
        $template->parseCurrentBlock();
      }
  
      $dataArray = array();
      $archivPaarungen = array();
      $archivSortDummy = array();
      // Partien der aktuellen Liga ermitteln
  
      $spiele = $liga->allPartieForTeams($team_a,$team_b,TRUE);
      foreach($spiele as $spiel) {
        if($spiel->hTore != -1 && $spiel->gTore != -1) {
          $archivSortDummy[] = $spiel->zeit;
          if ($spiel->heim == $team_a) {
            $archivPaarungen[] = array('time'=>$spiel->zeit, 'where'=>$text['mini'][13], 'partie'=>$spiel, 'match'=>NULL);
          } else {
            $archivPaarungen[] = array('time'=>$spiel->zeit, 'where'=>$text['mini'][12], 'partie'=>$spiel, 'match'=>NULL);
          }
        }
      }
  
      // Archivfolder lesen
  
      if ($mini_withArchiv==1 && readLigaDir(PATH_TO_LMO.'/'.$dirliga.$archivFolder,$dataArray) == FALSE ) {
        echo getMessage($text['mini'][6]." ".PATH_TO_LMO.'/'.$dirliga.$archivFolder,TRUE);
      }
  
      foreach ($dataArray as $ligaFile) {
        $newLiga = new liga();
        if($newLiga->loadFile($ligaFile['path'].$ligaFile['src'] ) == TRUE) {
  
          $teamNames = $newLiga->teamNames();
          $newTeam_a = $newLiga->teamForName($team_a->name);
          $seachNames = $mini_unGreedy == 1 ? findTeamName($teamNames,$team_b->name):NULL; // ungreedy Searching
          if (isset($seachNames) && count($seachNames) == 1 ) {
            $newTeam_b = $newLiga->teamForName($seachNames[0]);// ungreedy Searching war erfolgreich
            $match = $seachNames[0];
          }
          else {
            $newTeam_b = $newLiga->teamForName($team_b->name);// Searching war zu ungenau (mehr als ein result)
            $match = NULL;
          }
          if (!is_null($newTeam_a) && !is_null($newTeam_b) ){
            $spiele = $newLiga->allPartieForTeams($newTeam_a,$newTeam_b,TRUE);
            foreach($spiele as $spiel) {
              if($spiel->hTore != -1 && $spiel->gTore != -1) {
                $archivSortDummy[] = $spiel->zeit;
                if ($spiel->heim == $newTeam_a) {
                  $archivPaarungen[] = array('time'=>$spiel->zeit, 'where'=>$text['mini'][13], 'partie'=>$spiel, 'match'=>$match);
                } else {
                  $archivPaarungen[] = array('time'=>$spiel->zeit, 'where'=>$text['mini'][12], 'partie'=>$spiel, 'match'=>$match);
                }
              }
            }
  
          }
        }
        unset($newLiga);
        //        if (count($archivPaarungen) > 10) break; // max Anzahl von Archivbegegnungen
      }
      array_multisort($archivSortDummy,SORT_DESC,$archivPaarungen);
  
      $spAnzahl = count($archivPaarungen);
  
      $template->setCurrentBlock("matches"); // innerer Block mit den Partien
  
      $lostCount = $drawCount = $winCount = 0;
  
      foreach ($archivPaarungen as $paarung) {
        $template->setVariable("date",$paarung['partie']->datumString());
        $template->setVariable("hTore",$paarung['partie']->hToreString());
        $template->setVariable("gTore",$paarung['partie']->gToreString());
        $template->setVariable("where",$paarung['where']);
        if (isset($paarung['match']) && strtolower($paarung['match']) != strtolower($team_b->name) ) {
          //echo "<br>Vergleich: ".strtolower($paarung['match'])." = ".strtolower($team_b->name);
          $template->setVariable("matchingName","<acronym title='".$paarung['match']."'>*</acronym>");
        }
        $valuate = $paarung['partie']->valuateGame();
        if ($paarung['where']==$text['mini'][13] && $valuate == 1) {
          $template->setVariable("class","win");
          $template->setVariable("hTore",$paarung['partie']->hToreString());
          $template->setVariable("gTore",$paarung['partie']->gToreString());
          $winCount++;
        } elseif ($paarung['where']==$text['mini'][12] && $valuate == 2) {
          $template->setVariable("class","win");
          $template->setVariable("hTore",$paarung['partie']->gToreString());
          $template->setVariable("gTore",$paarung['partie']->hToreString());
          $winCount++;
        } elseif ($paarung['where']==$text['mini'][13] && $valuate == 2) {
          $template->setVariable("class","lost");
          $template->setVariable("hTore",$paarung['partie']->hToreString());
          $template->setVariable("gTore",$paarung['partie']->gToreString());
          $lostCount++;
        } elseif ($paarung['where']==$text['mini'][12] && $valuate == 1) {
          $template->setVariable("class","lost");
          $template->setVariable("hTore",$paarung['partie']->gToreString());
          $template->setVariable("gTore",$paarung['partie']->hToreString());
          $lostCount++;
        } elseif ($valuate == 0) {
          $template->setVariable("class","draw");
          $template->setVariable("hTore",$paarung['partie']->hToreString());
          $template->setVariable("gTore",$paarung['partie']->gToreString());
          $drawCount++;
        } else {
          $template->setVariable("class","noResult");
        }
        $template->parseCurrentBlock();
      }
  
      $w = intval( $mini_barWidth * $winCount / ($spAnzahl+.1) );
      $d = intval( $mini_barWidth * $drawCount / ($spAnzahl+.1) );
      $l = intval( $mini_barWidth * $lostCount / ($spAnzahl+.1) );
  
      $template->setCurrentBlock("main");
      $template->setVariable("matchesTxt",$text['mini'][4]);
      $template->setVariable("winCount",$winCount);
      $template->setVariable("drawCount",$drawCount);
      $template->setVariable("lostCount",$lostCount);
      $template->setVariable("matchCount",count($archivPaarungen));
      $template->setVariable("winWidth", $w );
      $template->setVariable("drawWidth", $d );
      $template->setVariable("lostWidth",$l );
      $template->setVariable("winTxt",$text['mini'][9]);
      $template->setVariable("drawTxt",$text['mini'][10]);
      $template->setVariable("lostTxt",$text['mini'][11]);
    }
    $mini_output = $template->get();
  
    //save cache file
    if ($mini_cache_file = fopen(PATH_TO_LMO.'/'.$diroutput.'mini_'.$multi.'.txt',"wb")) {
     fwrite($mini_cache_file,$mini_output);
     fclose($mini_cache_file);
    }
    //reset cache counter
    $mini_cache_counter_file = fopen(PATH_TO_LMO.'/'.$diroutput.'mini_'.$multi.'_count.txt',"wb");
    fwrite($mini_cache_counter_file,"1");
    fclose($mini_cache_counter_file);
    
    echo $mini_output;
  
  } // if file
  else echo getMessage($text['mini'][5],TRUE);
  //Falls IFRAME - komplettes HTML-Dokument
  if (basename($_SERVER['PHP_SELF'])=="lmo-mininext.php") {?>
  </body>
  </html><?php
  }
} else {
  //get cache
  if ($mini_cache_file = fopen(PATH_TO_LMO.'/'.$diroutput.'mini_'.$multi.'.txt',"rb")) {
   fpassthru($mini_cache_file);
   fclose($mini_cache_file);
  }
  //increment cache counter
  
  $mini_cache_counter_file = fopen(PATH_TO_LMO.'/'.$diroutput.'mini_'.$multi.'_count.txt',"wb");
  fwrite($mini_cache_counter_file,++$mini_cache_counter);
  fclose($mini_cache_counter_file);
}?>