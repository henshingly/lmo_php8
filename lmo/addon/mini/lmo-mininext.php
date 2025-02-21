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
  */

require_once(__DIR__ . '/../../init.php');
require_once(PATH_TO_ADDONDIR . '/classlib/ini.php');

$template_folder = PATH_TO_TEMPLATEDIR . '/mini/';

$mini_standardTemplate = isset($cfgarray['mini']['standardTemplate']) ? $cfgarray['mini']['standardTemplate'] : 'mininext.tpl.php';  // Templatefile
//for security reasons .. will be deleted - so only templates within the template path are possible

$mini_template = isset($_GET['mini_template'])
    ? str_replace('..', '', $_GET['mini_template'])
    : (isset($mini_template)
        ? str_replace('..', '', $mini_template)
        : $mini_standardTemplate);

/*
4-level fallback for these variables
->1. GET parameters
->2. Variable available (include)
->3. Config value
->4. Default value
*/

// Undocumented control parameters for advanced users
$mini_withArchiv = isset($_GET['mini_withArchiv'])
    ? ($_GET['mini_withArchiv'] == '1' ? 1 : 0)
    : (isset($mini_withArchiv)
        ? ($mini_withArchiv == '1' ? 1 : 0)
        : (isset($cfgarray['mini']['withArchiv'])
            ? $cfgarray['mini']['withArchiv']
            : 1));

$mini_unGreedy = isset($_GET['mini_unGreedy'])
    ? ($_GET['mini_unGreedy'] == '1' ? 1 : 0)
    : (isset($mini_unGreedy)
        ? ($mini_unGreedy == '1' ? 1 : 0)
        : (isset($cfgarray['mini']['unGreedy'])
            ? $cfgarray['mini']['unGreedy']
            : 1));

$mini_barWidth = isset($_GET['mini_barWidth']) && is_numeric($_GET['mini_barWidth'])
    ? $_GET['mini_barWidth']
    : (isset($mini_barWidth) && is_numeric($mini_barWidth)
        ? $mini_barWidth
        : (isset($cfgarray['mini']['barWidth'])
            ? $cfgarray['mini']['barWidth']
            : 120));

$file = isset($_GET['file']) ? $_GET['file'] : (isset($file) ? $file : NULL);
$archivFolder = isset($_GET['folder']) ? $_GET['folder'] : (isset($folder) ? $folder : basename($ArchivDir));  // Default

if (substr($archivFolder, -1) != '/') {
    $archivFolder .= '/';
}

if (strpos($archivFolder, '../') !== false) {
    exit();
}

$a = isset($_GET['a']) ? $_GET['a'] : (isset($a) ? $a : NULL);  // No. of Team 'a' (if not specified, favTeam is used)
$b = isset($_GET['b']) ? $_GET['b'] : (isset($b) ? $b : NULL);  // No. of Team 'b' (if not specified, next opponent of Team 'a' is used)

$mini_cache_refresh = isset($mini_cache_refresh) ? $mini_cache_refresh : 0;

//generate cache-file-id
$multi = md5($file . $archivFolder . $mini_template . $a . $b);

// Load the cache-counter-file for viewers simple cache mechanism
$mini_cache_filename = PATH_TO_LMO . '/' . $diroutput . 'mini_' . $multi . '.txt';
$mini_cache_counter_filename = PATH_TO_LMO . '/' . $diroutput . 'mini_' . $multi . '_count.txt';
$mini_cache_counter = 0;  //counter for cache hits

if (!file_exists($mini_cache_counter_filename)) {
    touch($mini_cache_counter_filename);
}
$mini_cache_counter_file = fopen($mini_cache_counter_filename, 'rb');
$mini_cache_counter = intval(trim(fgets($mini_cache_counter_file)));
fclose($mini_cache_counter_file);

if (!file_exists($mini_cache_filename) ||
    filemtime(PATH_TO_LMO . '/' . $dirliga . $file) > filemtime($mini_cache_filename)||
    $mini_cache_counter == 0 ||
    $mini_cache_counter > $mini_cache_refresh) {  // not cached or cache limit reached->generate new view

    //If IFRAME - complete HTML document
    if (basename($_SERVER['PHP_SELF']) == 'lmo-mininext.php') {?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
  <title>LMO Nextgame</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" >
  <style type="text/css">
    html,body {margin:0;padding:0;background:transparent;}
  </style>
</head>
<body><?php
    }

    $template = new HTML_Template_IT($template_folder);  // folder
    $template->loadTemplatefile($mini_template);
    $team_a = NULL;
    $team_b = NULL;
    $partie = NULL;
    $lastPartie = NULL;
    $liga = new liga();
    $showLastGame = true;
    if ($file && $liga->loadFile(PATH_TO_LMO . '/' . $dirliga . $file) == true) {
        if (!is_NULL($a)) {
            $team_a = $liga->teamForNumber($a);
        }
        elseif (is_NULL($team_a = $liga->teamForNumber($liga->options->keyValues['favTeam']))) {
            echo getMessage($text['mini'][8], true);
            exit;
        }

        if (is_NULL($team_b = $liga->teamForNumber($b))) {
            // We determine the nearest opponent of team 'a' if team 'b' is not specified
            $sortedGames = $liga->gamesSortedForTeam($team_a, false);  // Only sort by time regardless of game day
            $now = time();
            $showLastGame = true;
            foreach ($sortedGames as $game) {
                if ($now < $game['partie']->zeit) {  // find the last game
                    $partie = $game['partie'];
                    $template->setVariable('gameTxt', $text['mini'][1]);  // There is a future game
                    $template->setVariable('gameNote', $partie->notiz);
                    break;  // found an opponent
                }
                $lastPartie = $game['partie'];
            }
            if (!isset($partie)) {  // No more games found, so show last game (season ended)
                $partie = $lastPartie;
                unset($lastPartie);
                $showLastGame = false;
                $template->setVariable('gameTxt', $text['mini'][2]);
            }
            else {
                $showLastGame = true;
            }

            if ($partie->heim == $team_a) {
                $team_b = $partie->gast;
            }
            else {
                $team_b = $partie->heim;
            }
        }
        else {  // Team 'a' and 'b' were specified so show the result of this game
            $partie = $liga->partieForTeams($team_a, $team_b);
            $template->setVariable('gameTxt', $text['mini'][3]);
        }

        if (isset($partie)) {
            $template->setVariable('gameDate', $partie->datumString());
            $template->setVariable('gameTime', $partie->zeitString());
            $template->setVariable('ligaDatum', $text['mini'][14] . ': ' . $liga->ligaDatumAsString('d.m.Y'));

            $now = time();
            $gameDateTime = $partie->zeit;
            $days = floor(($gameDateTime - $now) / 86400);
            $rest = ($gameDateTime - $now) - ($days * 86400);
            $hours = floor($rest / 3600);
            $rest = $rest - ($hours * 3600);
            $minutes = floor($rest / 60);
            $rest = $rest - ($minutes * 60);
            $template->setVariable('countDown', $text['mini'][15] . ': ' . $days . ', ' . $text['mini'][16] . ': ' . $hours . ', ' . $text['mini'][17] . ': ' . $minutes);

            $template->setVariable('copy', str_replace('CLASSLIB_VERSION', CLASSLIB_VERSION, $text['mini'][0]));
            $template->setVariable('imgHomeSmall', HTML_icon($partie->heim->name, 'teams', 'small'));
            $template->setVariable('imgHomeMiddle', HTML_icon($partie->heim->name, 'teams', 'middle'));
            $template->setVariable('imgHomeBig', HTML_icon($partie->heim->name, 'teams', 'big'));
            $template->setVariable('imgGuestSmall', HTML_icon($partie->gast->name, 'teams', 'small'));
            $template->setVariable('imgGuestMiddle', HTML_icon($partie->gast->name, 'teams', 'middle'));
            $template->setVariable('imgGuestBig', HTML_icon($partie->gast->name, 'teams', 'big'));

            $template->setVariable('homeName', $partie->heim->name);
            $template->setVariable('guestName', $partie->gast->name);
            $template->setVariable('homeNameMiddle', $partie->heim->mittel);
            $template->setVariable('guestNameMiddle', $partie->gast->mittel);
            $template->setVariable('homeNameShort', $partie->heim->kurz);
            $template->setVariable('guestNameShort', $partie->gast->kurz);

            if (!$showLastGame) {
                $template->setVariable('homeTore', $partie->hToreString());
                $template->setVariable('guestTore', $partie->gToreString());
            }

            // previous game
            if (isset($lastPartie)) {
                $template->setCurrentBlock('previous');
                $template->setVariable('previous_gameDate', $lastPartie->datumString());
                $template->setVariable('previous_gameTime', $lastPartie->zeitString());
                $template->setVariable('previous_gameNote', $lastPartie->notiz);
                $template->setVariable('previous_imgHomeSmall', HTML_icon($lastPartie->heim->name, 'teams', 'small'));
                $template->setVariable('previous_imgHomeMiddle', HTML_icon($lastPartie->heim->name, 'teams', 'middle'));
                $template->setVariable('previous_imgHomeBig', HTML_icon($lastPartie->heim->name, 'teams', 'big'));
                $template->setVariable('previous_imgGuestSmall', HTML_icon($lastPartie->gast->name, 'teams', 'small'));
                $template->setVariable('previous_imgGuestMiddle', HTML_icon($lastPartie->gast->name, 'teams', 'middle'));
                $template->setVariable('previous_imgGuestBig', HTML_icon($lastPartie->gast->name, 'teams', 'big'));

                $template->setVariable('previous_homeName', $lastPartie->heim->name);
                $template->setVariable('previous_guestName', $lastPartie->gast->name);
                $template->setVariable('previous_homeNameMiddle', $lastPartie->heim->mittel);
                $template->setVariable('previous_guestNameMiddle', $lastPartie->gast->mittel);
                $template->setVariable('previous_homeNameShort', $lastPartie->heim->kurz);
                $template->setVariable('previous_guestNameShort', $lastPartie->gast->kurz);

                $template->setVariable('previous_hTore', $lastPartie->hToreString());
                $template->setVariable('previous_gTore', $lastPartie->gToreString());
                $template->setVariable('previous_gameTxt', $text['mini'][7]);
                $template->parseCurrentBlock();
            }

            $dataArray = array();
            $archivPaarungen = array();
            $archivSortDummy = array();
            // determine games of the current league

            $spiele = $liga->allPartieForTeams($team_a, $team_b, true);
            foreach($spiele as $spiel) {
                if ($spiel->hTore != -1 && $spiel->gTore != -1) {
                    $archivSortDummy[] = $spiel->zeit;
                    if ($spiel->heim == $team_a) {
                        $archivPaarungen[] = array('time' => $spiel->zeit, 'where' => $text['mini'][13], 'partie' => $spiel, 'match' => NULL);
                    }
                    else {
                        $archivPaarungen[] = array('time' => $spiel->zeit, 'where' => $text['mini'][12], 'partie' => $spiel, 'match' => NULL);
                    }
                }
            }

            // Read archive folder

            if ($mini_withArchiv == 1 && readLigaDir(PATH_TO_LMO . '/' . $dirliga . $archivFolder, $dataArray) == false) {
                echo getMessage($text['mini'][6].' '.PATH_TO_LMO . '/' . $dirliga . $archivFolder, true);
            }

            foreach ($dataArray as $ligaFile) {
                if ($ligaFile['path'] . $ligaFile['src'] != PATH_TO_LMO . '/' . $dirliga . $file) {
                    $newLiga = new liga();
                    if ($newLiga->loadFile($ligaFile['path'] . $ligaFile['src']) == true) {

                        $teamNames = $newLiga->teamNames();
                        $newTeam_a = $newLiga->teamForName($team_a->name);
                        $seachNames = $mini_unGreedy == 1 ? findTeamName($teamNames, $team_b->name) : NULL;  // ungreedy Searching
                        if (isset($seachNames) && count($seachNames) == 1) {
                            $newTeam_b = $newLiga->teamForName($seachNames[0]);// Ungreedy Searching was successful
                            $match = $seachNames[0];
                        }
                        else {
                            $newTeam_b = $newLiga->teamForName($team_b->name);// Searching was too imprecise (more than one result)
                            $match = NULL;
                        }
                        if (!is_NULL($newTeam_a) && !is_NULL($newTeam_b)) {
                            $spiele = $newLiga->allPartieForTeams($newTeam_a, $newTeam_b, true);
                            foreach($spiele as $spiel) {
                                if ($spiel->hTore != -1 && $spiel->gTore != -1) {
                                    $archivSortDummy[] = $spiel->zeit;
                                    if ($spiel->heim == $newTeam_a) {
                                        $archivPaarungen[] = array('time' => $spiel->zeit, 'where' => $text['mini'][13], 'partie' => $spiel, 'match' => $match);
                                    }
                                    else {
                                        $archivPaarungen[] = array('time' => $spiel->zeit, 'where' => $text['mini'][12], 'partie' => $spiel, 'match' => $match);
                                    }
                                }
                            }
                        }
                    }
                }
                unset($newLiga);
            }
            array_multisort($archivSortDummy, SORT_DESC, $archivPaarungen);

            $spAnzahl = count($archivPaarungen);

            $template->setCurrentBlock('matches');  // inner block with the matches

            $lostCount = $drawCount = $winCount = 0;

            foreach ($archivPaarungen as $paarung) {
                $template->setVariable('date', $paarung['partie']->datumString());
                $template->setVariable('hTore', $paarung['partie']->hToreString());
                $template->setVariable('gTore', $paarung['partie']->gToreString());
                $template->setVariable('where', $paarung['where']);
                if (isset($paarung['match']) && strtolower($paarung['match']) != strtolower($team_b->name)) {
                    $template->setVariable('matchingName', '<acronym title="' . $paarung['match'] . '">*</acronym>');
                }
                $valuate = $paarung['partie']->valuateGame();
                if ($paarung['where'] == $text['mini'][13] && $valuate == 1) {
                    $template->setVariable('class', 'win');
                    $template->setVariable('hTore', $paarung['partie']->hToreString());
                    $template->setVariable('gTore', $paarung['partie']->gToreString());
                    $winCount++;
                }
                elseif ($paarung['where'] == $text['mini'][12] && $valuate == 2) {
                    $template->setVariable('class', 'win');
                    $template->setVariable('hTore', $paarung['partie']->gToreString());
                    $template->setVariable('gTore', $paarung['partie']->hToreString());
                    $winCount++;
                }
                elseif ($paarung['where'] == $text['mini'][13] && $valuate == 2) {
                    $template->setVariable('class', 'lost');
                    $template->setVariable('hTore', $paarung['partie']->hToreString());
                    $template->setVariable('gTore', $paarung['partie']->gToreString());
                    $lostCount++;
                }
                elseif ($paarung['where'] == $text['mini'][12] && $valuate == 1) {
                    $template->setVariable('class', 'lost');
                    $template->setVariable('hTore', $paarung['partie']->gToreString());
                    $template->setVariable('gTore', $paarung['partie']->hToreString());
                    $lostCount++;
                }
                elseif ($valuate == 0) {
                    $template->setVariable('class', 'draw');
                    $template->setVariable('hTore', $paarung['partie']->hToreString());
                    $template->setVariable('gTore', $paarung['partie']->gToreString());
                    $drawCount++;
                }
                else {
                    $template->setVariable('class', 'noResult');
                }
                $template->parseCurrentBlock();
            }

            $w = intval($mini_barWidth * $winCount / ($spAnzahl + .1));
            $d = intval($mini_barWidth * $drawCount / ($spAnzahl + .1));
            $l = intval($mini_barWidth * $lostCount / ($spAnzahl + .1));

            $template->setCurrentBlock('main');
            $template->setVariable('matchesTxt', $text['mini'][4]);
            $template->setVariable('winCount', $winCount);
            $template->setVariable('drawCount', $drawCount);
            $template->setVariable('lostCount', $lostCount);
            $template->setVariable('matchCount', count($archivPaarungen));
            $template->setVariable('winWidth', $w);
            $template->setVariable('drawWidth', $d);
            $template->setVariable('lostWidth', $l);
            $template->setVariable('winTxt', $text['mini'][9]);
            $template->setVariable('drawTxt', $text['mini'][10]);
            $template->setVariable('lostTxt', $text['mini'][11]);
        }
        $mini_output = $template->get();

        //save cache file
        if ($mini_cache_file = fopen(PATH_TO_LMO . '/' . $diroutput . 'mini_' . $multi . '.txt', 'wb')) {
            fwrite($mini_cache_file, $mini_output);
            fclose($mini_cache_file);
        }
        //reset cache counter
        $mini_cache_counter_file = fopen(PATH_TO_LMO . '/' . $diroutput . 'mini_' . $multi . '_count.txt', 'wb');
        fwrite($mini_cache_counter_file, '1');
        fclose($mini_cache_counter_file);

        echo $mini_output;
    } // if file
    else echo getMessage($text['mini'][5], true);
    // If IFRAME - complete HTML document
    if (basename($_SERVER['PHP_SELF']) == 'lmo-mininext.php') {?>
</body>
</html><?php
    }
}
else {
  //get cache
    if ($mini_cache_file = fopen($mini_cache_filename)) {
        fpassthru($mini_cache_file);
        fclose($mini_cache_file);
    }
    //increment cache counter

    $mini_cache_counter_file = fopen(PATH_TO_LMO . '/' . $diroutput . 'mini_' . $multi . '_count.txt', 'wb');
    fwrite($mini_cache_counter_file, ++ $mini_cache_counter);
    fclose($mini_cache_counter_file);
}
