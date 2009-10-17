<?PHP
/**
 *
 * Funktionen ClassLib
 *
 * @author    Tim Schumacher <webobjects@gmx.net>
 * @package classLib
 * @access public
 * @version $Id$
 */


function const_array($constant) {
  $array = explode(",",$constant);
  return $array;
};



/**
 * Strafen
 *
 * Wird von calcTable verwende
 *
 * SP Straf-/Bonuspunkte links
 * SM Straf-/Bonuspunkte rechts (nur wenn es Minuspunkte gibt)
 * TOR1 Straf-/Bonustore links
 * TOR2 Straf-/Bonustore rechts
 * STDA ab wann zählt Strafe/Bonus
 *
 * @author    Tim Schumacher <webobjects@gmx.net>
 * @package classLib
 * @access privat
 */
function strafen(&$team,$spTag,$minusPkte) {
  $stda = isset($team["team"]->keyValues["STDA"]) ? $team["team"]->keyValues["STDA"] : 0;
  if ($stda==$spTag  or ($stda==0 and $spTag==1)) {
    if ($minusPkte==FALSE) {
      $team["pPkt"] += isset($team["team"]->keyValues["SP"])   ? -$team["team"]->keyValues["SP"]       : 0;
      $team["mPkt"] += isset($team["team"]->keyValues["SM"])   ? -$team["team"]->keyValues["SM"]       : 0;
      $team["pTor"] += isset($team["team"]->keyValues["TOR1"]) ? -$team["team"]->keyValues["TOR1"]     : 0;
      $team["mTor"] += isset($team["team"]->keyValues["TOR2"]) ? abs($team["team"]->keyValues["TOR2"]) : 0;
    }
    else {
      $team["mPkt"] += isset($team["team"]->keyValues["SM"])   ? $team["team"]->keyValues["SM"]   : 0;
      $team["mTor"] += isset($team["team"]->keyValues["TOR2"]) ? $team["team"]->keyValues["TOR2"] : 0;
    }
  }
}


/**
 * Gibt ein multidim Array zurück, das die sortierten partien enthält,
 * Aufbau array[0..n](
 * 			'date'  [timestamp des Spieldatums]
 *  		'spTag'  [integer],
 * 			'spieltag' [Object spieltag]
 *   		'partie' [Object partie] )
 *
 * Beispiel:
 * $sortedGames = gamesSorted ($liga,false);
 * echo "&gth;pre>";
 * print_r($sortedGames);
 * echo "&gth;/pre>";
 *
 * @access public
 * @return Array
 */
function &gamesSorted ($liga,$roundSort=true) {
  $games = array();
  foreach ($liga->spieltage as $spieltag) {
    foreach ($spieltag->partien as $partie) {
      $sort_1[] = $partie->zeit;
      $sort_2[] = $spieltag->nr;
      $games[]= array(
      'date' => $partie->zeit,
      'spTag' => $spieltag->nr,
      'spieltag' => $spieltag,
      'partie' => $partie,
      );
    }
  }
  if($roundSort) {
    array_multisort($sort_2, SORT_ASC,
    $sort_1, SORT_ASC,$games);
  }
  else {
    array_multisort($sort_1,SORT_ASC,$games);
  }
  return $games;
}

/**
 * Gibt ein multidim Array zurück, das die sortierten partien einer bestimmten mannschaft enthält,
 * Aufbau array[0..n](
 * 			'spieltag' [Object spieltag]
 *   		'partie' [Object partie] )
 *
 * Beispiel:
 * $sortedGames = gamesSorted ($liga,false);
 * echo "&gth;pre>";
 * print_r($sortedGames);
 * echo "&gth;/pre>";
 *
 * @access public
 * @return Array
 */
function &gamesSortedForTeam ($liga,$team=null,$roundSort=true, $sortDir = SORT_ASC) {
  if(!is_object($team)) {  // Wurde nix angegeben wird das fav. Team verwendet
    $team = $liga->teamForNumber($liga->options->keyValues['favTeam']);
  }

  $games = array();
  foreach ($liga->spieltage as $spieltag) {
    foreach ($spieltag->partien as $partie) {
      if ($partie->heim == $team or $partie->gast == $team) {
        //	    	  echo "".$partie->datumString()." ".$partie->heim->name." vs ".$partie->gast->name;
        $sort_1[] = $partie->zeit;
        $sort_2[] = $spieltag->nr;
        $games[]= array(
        'date' => $partie->zeit,
        'spTag' => $spieltag->nr,
        'spieltag' => $spieltag,
        'partie' => $partie,
        );
      }
    }
  }
  if($roundSort) {
    array_multisort($sort_2, $sortDir,
    $sort_1, $sortDir,$games);
  }
  else {
    array_multisort($sort_1,$sortDir,$games);
  }
  unset($games['date']); // wurde nur zum sortieren benötigt
  unset($games['spTag']);// wurde nur zum sortieren benötigt
  return $games;
}


// Wird noch von der Function loadFile der Class Liga benoetigt
function getIniData($key,&$array,$defaultV="") {
  if(array_key_exists($key,$array))
  $result = $array[$key];
  else
  $result = $defaultV;
  return $result;
}


function newStyle($url,$cssURL) {
  $found = preg_match("/style=/i",$url);
  if ($found) {
    $pattern = "/style=(.*)/i"; // /style=.*(&?|$)/isU
    $cssURL = "style=".$cssURL;
    $url = preg_replace($pattern, $cssURL, $url);
  }
  else
  $url .= "&style=".$cssURL;

  return $url;
}

function sisURL($url,$alt='view1',$neu='view2') {
  $alt = "/$alt/isU";
  $url = preg_replace($alt, $neu, $url);
  return $url;
}


/**
 * get the text before the last occurence of the character
 * example: strBeforChar("fussballbl2004.l98",".") returns "fussballbl2004"
 *
 * @param string $str
 * @param char $char
 * @return string
 */
function strBeforChar($str,$char) {
  return substr($str,0,strrpos($str, $char));
}

/**
 * get the text behind the last occurence of the character
 * example: strBeforChar("fussballbl2004.l98",".") returns "l98"
 *
 * @param string $str
 * @param char $char
 * @return string
 */
function strAfterChar($str,$char) {
  return substr($str,strrpos($str, $char)+1);
}

/**
 *
 * @param string $needle
 * @param string $haystack
 * @param integer $insensitive 0/1
 * @return boolean
 */
function in_string($needle, $haystack, $insensitive = 0) {
  if ($insensitive) {
    return (false !== stristr($haystack, $needle)) ? true : false;
  } else {
    return (false !== strpos($haystack, $needle))  ? true : false;
  }
}

/**
 * Vorhandene Ligen in einem Verzeichnis werden in
 * ein Array geschrieben
 *
 * @param string $dirName
 * @param array $dataArray
 * @return boolean
 */
function readLigaDir($dirName,&$dataArray) {
  $exists = file_exists($dirName);
  if($exists) {
    $dir = dir($dirName);
    while($data=$dir->read()){
      $ext = strtolower( strAfterChar($data,"."));
      if($ext == 'l98') {
        $name = trim(substr($data,0,strrpos($data, $ext)-1));
        $dataArray[] = array('path'=>$dir->path,
                             'src'=>$data,
                             'fileName'=>$name
                            );
      }
    }
    $dir->close();
  }
  return $exists;
}

/**
 * unscharfe Teamsuche
 *
 * @param array $teamNamesArray
 * @param string $search
 * @return array
 */
function findTeamName(&$teamNamesArray,$search) {

  $results = array();
  $expr = "/\s+[IXVivx]*[0-9]*\s*$|\s+\(.*\)$/i";
  if (is_array($teamNamesArray) ) {
    $match = strtolower(preg_replace($expr,"",$search));
    foreach($teamNamesArray as $teamName) {
      $match_with = strtolower(preg_replace($expr,"",$teamName));
      if ($match_with == $match) {
        $results[] = $teamName;
        break;
      }
    }
  }
  return $results;
}

?>