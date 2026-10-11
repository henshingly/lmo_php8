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
 * @param string $constant durch Komma getrennte Werte
 * @return array
 */
function const_array($constant) {
    $array = explode(',', $constant);
    return $array;
};

/**
 * get the text before the last occurence of the character
 * example: strBeforChar("fussballbl2004.l98",".") returns "fussballbl2004"
 *
 * @param string $str
 * @param string $char
 * @return string
 */
function strBeforChar($str,$char) {
    return substr($str, 0, strrpos($str, $char));
}

/**
 * get the text behind the last occurence of the character
 * example: strBeforChar("fussballbl2004.l98",".") returns "l98"
 *
 * @param string $str
 * @param string $char
 * @return string
 */
function strAfterChar($str,$char) {
    $pos = strrpos($str, $char);
    return $pos === false ? '' : substr($str, $pos + 1);
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
        return str_contains(strtolower($haystack), strtolower($needle));
    } else {
        return str_contains($haystack, $needle);
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
        while($data = $dir->read()){
            $ext = strtolower( strAfterChar($data, '.'));
            if ($ext == 'l98') {
                $name = trim(strBeforChar($data, '.'));
                $dataArray[] = array(
                  'path' => $dir->path,
                  'src' => $data,
                  'fileName' => $name
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
 * @param array|null $teamNamesArray
 * @param string $search
 * @return array
 */
function findTeamName(&$teamNamesArray, $search) {
    $results = array();
    $expr = '/\s+|\d+|\W/i';
    if (is_array($teamNamesArray) ) {
        $match = strtolower(preg_replace($expr, '', $search));
        foreach($teamNamesArray as $teamName) {
            $match_with = strtolower(preg_replace($expr, '', $teamName));
            if ($match_with == $match) {
                // alle Treffer liefern: der Aufrufer erkennt daran eine mehrdeutige Suche
                // (z.B. "TSV Muster" und "TSV Muster 2" unterscheiden sich nur in Ziffern)
                $results[] = $teamName;
            }
        }
    }
    return $results;
}

?>
