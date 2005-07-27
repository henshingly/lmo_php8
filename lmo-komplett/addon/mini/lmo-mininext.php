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
  *
  * lmo-mininext for LigaManager Online
  *  Copyright (C) 2005 by Tim Schumacher/LMO-Group
  * timme@webobjekts.de / joker@liga-manager-online.de
  * 
  *  Version 2.0.2
  *  systemvoraussetzung: LMO ab RC1/classlib ab 2.7
  *
  * History:
  * 1.0: initial Release
  * 1.1: Multilanguagefähig
  *      ins mini*-Addon eingefügt
  *      Bugfixes
  *      Template entrümpelt
  *      Anzeige der Greedy-Ergebnisse überarbeitet
  * 2.0: korrekte Anzeige Auswärts-/Heimpartien
  *      zusätzlicher Block "Vorheriges Spiel"
  * 2.0.1 Datumsformat wieder gekürzt
  * 2.0.2 Bug beim include (Mannschaften wurden nicht erkannt) beseitigt
  * 2.1.0 Konfigurationsdatei für Konfigurationsparameter (änderbar im Adminbereich)
  *       Template jetzt auch änderbar (über GET oder vorher definiert)
  *       Archivdurchsuchung abschaltbar
  *       Doppelrunden (also mehr als 1 Hin-/Rückrunde) werden erkannt
  *      
  *
  * Dieses Script zeigt die kommende Partie einer Mannschaft in einem kleinen 
  * Block an, der relativ einfach in jede bestehende Seite eingebunden werden 
  * kann. Als Vorlage diente die Lösung auf www.hsg-nordhorn.de (Oben rechts 
  * auf der Startseite).
  * Neben der Anzeige der kommenden Partie, wird im anzugebenen Archivordner 
  * nach bereits vorhandenen Begegnungen der Mannschaften gesucht und absteigend 
  * sortiert nach Datum angezeigt.
  * 
  * Konfigurationsparameter (in der Addonverwaltung)
  *
  *   mininext_withArchiv: Archivordner durchsuchen 1/0
  *
  *   mininext_unGreedy: unscharfe Suche - findet z.B. auch THW KIEL 6 wenn team_b = THW KIEL 3 ist. 1/0
  *
  *   mininext_barWidth: Breite des farbigen Balken in Pixeln
  *
  *   mininext_standardTemplate: Standardtemplate, wenn keins übergeben wurde
  *
  *
  * URL-Parameter:
  * 
  *   file: Dateiname der Liga
  * 
  *   folder: Archivordner, der durchsucht werden soll. Es ist sinvoll, die 
  *           alten Ligadateien nicht direkt in den Archivordner abzulegen, 
  *           sondern jeweils für jede Liga einen eigenen unterordner im 
  *           Archivverzeichnis anzulegen.
  *   a:      Nummer der Mannschaft A, für die der Block erstellt werden 
  *           soll. Dieser Parameter ist nur dann erforderlich, wenn im 
  *           LigaFile keine Lieblingsmannschaft angegeben wurde.
  *   b:      Nummer des Gegners von a: bzw der Lieblingsmannschaft. Dieser 
  *           Parameter ist für die Anzeige der nächsten Partie nicht erforderlich, 
  *           da die nächste Partie automatisch ermittelt wird. Wer aber eine 
  *           spezielle Paarung angezeigt haben möchte kann hier b angeben.
  *   mininext_template: Template, dass benutzt werden soll
  * 
  * 
  * Beispiel: 1.Bundesliga Fussball 2004 / 2005
  *   file = 1bundesliga2004.l98
  *      die alten Ligafiles der 1. Bundesliga befinden sich im ordner 
  *      <lmo_root>/ligen/archiv/dbl also 
  *   folder=archiv/dbl
  * 
  *   Einbindung über IFrame:
  *     <iframe src="<url_to_lmo>/addon/mini/lmo-mininext.php?file=1bundesliga2004.l98&folder=archiv/dbl"><url_to_lmo>/addon/mini/lmo-mininext.php?file=1bundesliga2004.l98&folder=archiv/dbl</iframe>
  *     (die Parameter a und b bei Bedarf mit &amp;a=<integer>&amp;b=<integer> anhängen
  * 
  *   Einbindung über include:
  *     $file = "1bundesliga2004.l98";
  *     $folder = "archiv/dbl";
  *     (auch hier bei Bedarf a und/oder b angeben: $a = <integer>;$b = <integer>; )
  *     include ("<pfad_zum_lmo>/addon/mini/lmo-mininext.php");
  * 
  * Installation:
  * lmo-mininext.php ins Verzeichnis <lmo_root>/addon/mini/ kopieren.
  * mininext.tpl.php ins Verzeichnis <lmo_root>/template/mini/ kopieren
  * *lang.txt-dateien ins Verzeichnis <lmo_root>/lang/mini/ kopieren
  * 
  * 
  * Hinweis:
  * Es ist nicht gestattet den Hinweis auf den Autor zu entfernen!
  * Eigene Templates müssen den Hinweis auf Autor des Scripts enthalten.
  *
  * bekannte Probleme:
  * Sind die Spielzeiten der Partien nicht angegeben, erfolgt die Ausgabe der 
  * Archivpartien unsortiert.
  */

require(dirname(__FILE__).'/../../init.php');
require_once(PATH_TO_ADDONDIR."/classlib/ini.php");

$template_folder = PATH_TO_TEMPLATEDIR.'/mini/';

$mininext_standardTemplate = isset($cfgarray['mini']['mininext_standardTemplate'])?$cfgarray['mini']['mininext_standardTemplate']:"mininext.tpl.php";		// Templatefile
//aus Sicherheitsgründen werden .. gelöscht - somit sind nur templates innerhalb des Templatepfads möglich
$mininext_template = isset($_GET['mininext_template'])
                     ? str_replace('..','',$_GET['mininext_template'])
                     : (isset($mininext_template)
                        ? str_replace('..','',$mininext_template)
                        : $mininext_standardTemplate
                       );

//4-stufiges Fallback für diese Variablen
//1.GET-Parameter->2.Variable vorhanden (include)->3.Configwert->4. Standardwert

//Nicht dokumentierte Steuerparameter für Fortgeschrittene
$mininext_withArchiv = isset($_GET['mininext_withArchiv'])
                            ? ($_GET['mininext_withArchiv']=='1'?1:0)
                            : ( isset($mininext_withArchiv) 
                                ? ($mininext_withArchiv=='1'?1:0)
                                : (isset($cfgarray['mini']['mininext_withArchiv'])
                                   ? $cfgarray['mini']['mininext_withArchiv']
                                   : 1
                                  )
                              );
$mininext_unGreedy = isset($_GET['mininext_unGreedy'])
                     ? ($_GET['mininext_unGreedy']=='1'?1:0)
                     : ( isset($mininext_unGreedy)
                         ? ($mininext_withArchiv=='1'?1:0)
                         :  (isset($cfgarray['mini']['mininext_unGreedy'])
                             ? $cfgarray['mini']['mininext_unGreedy']
                             : 1
                            )
                       );
$mininext_barWidth = isset($_GET['mininext_barWidth']) && is_numeric($_GET['mininext_barWidth'])
                     ? $_GET['mininext_barWidth']
                     : ( isset($mininext_barWidth) && is_numeric($mininext_barWidth)
                         ? $mininext_barWidth
                         : (isset($cfgarray['mini']['mininext_barWidth'])
                             ? $cfgarray['mini']['mininext_barWidth']
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


//Falls IFRAME - komplettes HTML-Dokument
if (basename($_SERVER['PHP_SELF'])=="lmo-mininext.php") {?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
					"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>lmo-nextgame</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" >
<style type="text/css">
  html,body {margin:0;padding:0;background:#FFFFFF;}
</style>
</head>
<body><?
}

$template = new HTML_Template_IT($template_folder); // verzeichnis
$template->loadTemplatefile($mininext_template);
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
    $template->setVariable("ligaDatum","Stand: ".$liga->ligaDatumAsString("%x"));
    //
    $template->setVariable("copy",str_replace('CLASSLIB_VERSION',CLASSLIB_VERSION,$text['mini'][0]));
    $template->setVariable("imgHomeSmall",HTML_smallTeamIcon($file,$partie->heim," alt=''"));
    $template->setVariable("imgHomeBig",HTML_bigTeamIcon($file,$partie->heim,"alt=''"));
    $template->setVariable("imgGuestSmall",HTML_smallTeamIcon($file,$partie->gast,"alt=''"));
    $template->setVariable("imgGuestBig",HTML_bigTeamIcon($file,$partie->gast,"alt=''"));

    $template->setVariable("homeName",$partie->heim->name);
    $template->setVariable("guestName",$partie->gast->name);

    //Vorherige Partie
    if (isset($lastPartie)) {
      $template->setCurrentBlock("previous");
      $template->setVariable("previous_gameDate",$lastPartie->datumString());
      $template->setVariable("previous_gameTime",$lastPartie->zeitString());
      $template->setVariable("previous_imgHomeSmall",HTML_smallTeamIcon($file,$lastPartie->heim," alt=''"));
      $template->setVariable("previous_imgHomeBig",HTML_bigTeamIcon($file,$lastPartie->heim,"alt=''"));
      $template->setVariable("previous_imgGuestSmall",HTML_smallTeamIcon($file,$lastPartie->gast,"alt=''"));
      $template->setVariable("previous_imgGuestBig",HTML_bigTeamIcon($file,$lastPartie->gast,"alt=''"));

      $template->setVariable("previous_homeName",$lastPartie->heim->name);
      $template->setVariable("previous_guestName",$lastPartie->gast->name);

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
          $archivPaarungen[] = array('time'=>$spiel->zeit, 'where'=>'h', 'partie'=>$spiel, 'match'=>NULL);
        } else {
          $archivPaarungen[] = array('time'=>$spiel->zeit, 'where'=>'a', 'partie'=>$spiel, 'match'=>NULL);
        }
      }
    }

    // Archivfolder lesen

    if ($mininext_withArchiv==1 && readLigaDir(PATH_TO_LMO.'/'.$dirliga.$archivFolder,$dataArray) == FALSE ) {
      echo getMessage($text['mini'][6]." ".PATH_TO_LMO.'/'.$dirliga.$archivFolder,TRUE);
    }

    foreach ($dataArray as $ligaFile) {
      $newLiga = new liga();
      if($newLiga->loadFile($ligaFile['path'].$ligaFile['src'] ) == TRUE) {

        $teamNames = $newLiga->teamNames();
        $newTeam_a = $newLiga->teamForName($team_a->name);
        $seachNames = $mininext_unGreedy == 1 ? findTeamName($teamNames,$team_b->name):NULL; // ungreedy Searching
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
                $archivPaarungen[] = array('time'=>$spiel->zeit, 'where'=>'h', 'partie'=>$spiel, 'match'=>NULL);
              } else {
                $archivPaarungen[] = array('time'=>$spiel->zeit, 'where'=>'a', 'partie'=>$spiel, 'match'=>NULL);
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
      if ($paarung['where']=='h' && $valuate == 1) {
        $template->setVariable("class","win");
        $template->setVariable("hTore",$paarung['partie']->hToreString());
        $template->setVariable("gTore",$paarung['partie']->gToreString());
        $winCount++;
      } elseif ($paarung['where']=='a' && $valuate == 2) {
        $template->setVariable("class","win");
        $template->setVariable("hTore",$paarung['partie']->gToreString());
        $template->setVariable("gTore",$paarung['partie']->hToreString());
        $winCount++;
      } elseif ($paarung['where']=='h' && $valuate == 2) {
        $template->setVariable("class","lost");
        $template->setVariable("hTore",$paarung['partie']->hToreString());
        $template->setVariable("gTore",$paarung['partie']->gToreString());
        $lostCount++;
      } elseif ($paarung['where']=='a' && $valuate == 1) {
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

    $w = intval( $mininext_barWidth * $winCount / ($spAnzahl+.1) );
    $d = intval( $mininext_barWidth * $drawCount / ($spAnzahl+.1) );
    $l = intval( $mininext_barWidth * $lostCount / ($spAnzahl+.1) );

    $template->setCurrentBlock("main");
    $template->setVariable("matchesTxt",$text['mini'][4]);
    $template->setVariable("winCount",$winCount);
    $template->setVariable("drawCount",$drawCount);
    $template->setVariable("lostCount",$lostCount);
    $template->setVariable("matchCount",count($archivPaarungen));
    $template->setVariable("winWidth", $w );
    $template->setVariable("drawWidth", $d );
    $template->setVariable("lostWidth",$l );
    $template->setVariable("winTxt","S");
    $template->setVariable("drawTxt","U");
    $template->setVariable("lostTxt","N");
  }
  $template->show(); // koennte man doch auch zum caching speichern ? über ->get() o.ä.

} // if file
else echo getMessage($text['mini'][5],TRUE);
//Falls IFRAME - komplettes HTML-Dokument
if (basename($_SERVER['PHP_SELF'])=="lmo-mininext.php") {?>
</body>
</html><?
}?>