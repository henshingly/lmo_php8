<?PHP
/**
 *
 * Funktionen ClassLib
 *
 * @author    Tim Schumacher <webobjects@gmx.net>
 * @package classLib
 * @access public
 *
 */

/**
 *  const_array()
 *
 * @access public
 * @param constant string
 * @return array
 */
function const_array($constant) {
  $array = explode(",",$constant);
  return $array;
};

/**
 *  newStyle()
 *
 * @access public
 * @param url string
 * @param cssURL string
 * @return string
 */
function newStyle($url,$cssURL) {
  $found = preg_match("/style=/i",$url);
  if ($found) {
    $pattern = "/style=(.*)/i"; // /style=.*(&?|$)/isU
    $cssURL = "style=".$cssURL;
    $url = preg_replace($pattern, $cssURL, $url);
	} else $url .= "&style=".$cssURL;
  return $url;
}

/**
 *  sisURL()
 *
 * @access public
 * @param url string
 * @param alt string
 * @param neu string
 * @return string
*/
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
 * @param boolean $insensitive
 * @return boolean
 */
function in_string($needle, $haystack, $insensitive = false) {
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
  if ($exists) {
    $dir = dir($dirName);
    while($data=$dir->read()){
      $ext = strtolower( strAfterChar($data,"."));
      if ($ext == 'l98') {
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
	$expr = "/\s+|\d+|\W/i";
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