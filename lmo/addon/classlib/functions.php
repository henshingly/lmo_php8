<?PHP
//
/**
 * LMO Class Library Version (01/2004)
 *
// This program is free software; you can redistribute it and/or
// modify it under the terms of the GNU General Public License as
// published by the Free Software Foundation; either version 2 of
// the License, or (at your option) any later version.
//
// This program is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
// General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with this program; if not, write to the Free Software
// Foundation, Inc., 675 Mass Ave, Cambridge, MA 02139, USA.
//
 *
 * @author    Tim Schumacher <webobjects@gmx.net>
 * @package classLib
 * @access privat
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
 * <BR>SP Straf-/Bonuspunkte links
 * <BR>SM Straf-/Bonuspunkte rechts (nur wenn es Minuspunkte gibt)
 * <BR>TOR1 Straf-/Bonustore links
 * <BR>TOR2 Straf-/Bonustore rechts
 * <BR>STDA ab wann zählt Strafe/Bonus
 *
 * @author    Tim Schumacher <webobjects@gmx.net>
 * @package classLib
 * @access privat
*/

  function strafen(&$team,$spTag,$minusPkte) {
    $stda = isset($team["team"]->keyValues["STDA"])
    						? $team["team"]->keyValues["STDA"]
    						: 0;
    						
    if ($stda==$spTag  or ($stda==0 and $spTag==1)) {
         if ($minusPkte==FALSE) {
            $team["pPkt"] += isset($team["team"]->keyValues["SP"]) ?
                -$team["team"]->keyValues["SP"] : 0;
						// 1.2.05 neu von platik BEGIN
						$team["mPkt"] += isset($team["team"]->keyValues["SM"]) ?
                -$team["team"]->keyValues["SM"] : 0;
						// 1.2.05 neu von platik END
            $team["pTor"] += isset($team["team"]->keyValues["TOR1"]) ?
                -$team["team"]->keyValues["TOR1"] : 0;
            $team["mTor"] += isset($team["team"]->keyValues["TOR2"]) ?
                abs($team["team"]->keyValues["TOR2"]) : 0;
        }
        else {
            $team["mPkt"] += isset($team["team"]->keyValues["SM"]) ?
                $team["team"]->keyValues["SM"] : 0;
            $team["mTor"] += isset($team["team"]->keyValues["TOR2"]) ?
                $team["team"]->keyValues["TOR2"] : 0;
        }

    }
  }


/**
 * Gibt ein multidim Array zurück, das die sortierten partien enthält,
 * <BR>Aufbau array[0..n](
 * <BR>			'date'  [timestamp des Spieldatums]
 * <BR> 		'spTag'  [integer],
 * <BR>			'spieltag' [Object spieltag]
 * <BR>  		'partie' [Object partie] )
 * <BR>
 * Beispiel:<BR>
 * $sortedGames = gamesSorted ($liga,false);<BR>
 * echo "&gth;pre>";<BR>
 * print_r($sortedGames);<BR>
 * echo "&gth;/pre>";<BR>
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
 * <BR>Aufbau array[0..n](
 * <BR>			'spieltag' [Object spieltag]
 * <BR>  		'partie' [Object partie] )
 * <BR>
 * Beispiel:<BR>
 * $sortedGames = gamesSorted ($liga,false);<BR>
 * echo "&gth;pre>";<BR>
 * print_r($sortedGames);<BR>
 * echo "&gth;/pre>";<BR>
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
//	    	  echo "<br>".$partie->datumString()." ".$partie->heim->name." vs ".$partie->gast->name;
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

// get the text before the last occurence of the character
// example: strBeforChar("fussballbl2004.l98",".") returns "fussballbl2004"

function strBeforChar($str,$char) {
 return substr($str,0,strrpos($str, $char));
}

// get the text behind the last occurence of the character
// example: strBeforChar("fussballbl2004.l98",".") returns "l98"

function strAfterChar($str,$char) {
 return substr($str,strrpos($str, $char)+1);
}

function in_string($needle, $haystack, $insensitive = 0) {
   if ($insensitive) {
       return (false !== stristr($haystack, $needle)) ? true : false;
   } else {
       return (false !== strpos($haystack, $needle))  ? true : false;
   }
}

function readLigaDir($dirName,&$dataArray) {
	$exists = file_exists($dirName);
	if($exists) {
    $dir = dir($dirName);
    while($data=$dir->read()){
      $ext = strtolower( strAfterChar($data,"."));
      if( $ext == 'l98'  ){
        $name = trim(substr($data,0,strrpos($data, $ext)-1));
        $dataArray[] = array(
            'path'=>$dir->path,
            'src'=>$data,
            'fileName'=>$name,
            );
      }
    }
    $dir->close();
    }
	return $exists;
}

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