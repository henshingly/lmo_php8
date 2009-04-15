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
  * @package classLib
  * @access   public
  * @version $Id$
  */


/**
 * Returns HTML code for a small team logo (if  available in img/teams/small)
 *
 * @param String $ligaFile
 * @param String $team
 * @param String $html
 * @param String $alternative_text
 * @return String
 */
function HTML_smallTeamIcon($ligaFile,$team,$html="",$alternative_text="") {
  $subFolder = "/teams/small/";
  foreach( const_array( CLASSLIB_IMG_TYPES ) as $extension) {
    if ($imgHTML = findImage($team,$subFolder,$extension,$html,$alternative_text) ) {
      break;
    }
  }
  return $imgHTML;
}

/**
 * Returns HTML code for a big team logo (if  available in img/teams/big)
 *
 * @param String $ligaFile
 * @param String $team
 * @param String $html
 * @param String $alternative_text
 * @return String
 */
function HTML_bigTeamIcon($ligaFile,$team,$html="",$alternative_text="") {
  $subFolder = "/teams/big/";
  foreach( const_array( CLASSLIB_IMG_TYPES ) as $extension) {
    if ($imgHTML = findImage($team,$subFolder,$extension,$html,$alternative_text) ) {
      break;
    }
  }
  return $imgHTML;
}

/**
 * Returns HTML code for a small league logo (if  available in img/liga/small)
 *
 * @param String $ligaFile
 * @param String $html
 * @param String $alternative_text
 * @return String
 */
function HTML_smallLigaIcon($ligaFile,$html="",$alternative_text="") {
  $fileName = strBeforChar(basename($ligaFile),'.');
  $subFolder = "/liga/small/";
  foreach( const_array( CLASSLIB_IMG_TYPES ) as $extension) {
    if ($imgHTML = findImage($fileName,$subFolder,$extension,$html,$alternative_text) ) {
      break;
    }
  }
  return $imgHTML;
}

/**
 * Returns HTML code for a big league logo (if  available in img/liga/big)
 *
 * @param String $ligaFile
 * @param String $html
 * @param String $alternative_text
 * @return String
 */
function HTML_bigLigaIcon($ligaFile,$html="",$alternative_text="") {
  $fileName = strBeforChar(basename($ligaFile),'.');
  $subFolder = "/liga/big/";
  foreach( const_array( CLASSLIB_IMG_TYPES ) as $extension) {
    if ($imgHTML = findImage($fileName,$subFolder,$extension,$html,$alternative_text) ) {
      break;
    }
  }
  return $imgHTML;
}


/**
 * Returns HTML code for a small players icon (if available in img/spieler/small)
 *
 * @param String $ligaFile
 * @param String $liganame
 * @param String $htmlParameter
 * @return String
 */

function HTML_smallSpielerIcon($ligaFile,$spieler,$alternative_text="") {
  $subFolder = "/spieler/small/";
  foreach( const_array( CLASSLIB_IMG_TYPES ) as $extension) {
    if ($imgHTML = findImage($spieler,$subFolder,$extension,$alternative_text) ) {
      break;
    }
  }
  return $imgHTML;
}

/**
 * Returns HTML code for a big players icon (if available in img/spieler/big)
 *
 * @param String $ligaFile
 * @param String $liganame
 * @param String $htmlParameter
 * @return String
 */
function HTML_bigSpielerIcon($ligaFile,$liganame,$htmlParameter="") {
  $subFolder = "/spieler/big/";
  $alternative_text="";
  foreach( const_array( CLASSLIB_IMG_TYPES ) as $extension) {
    if ($imgHTML = findImage($spieler,$subFolder,$extension,$alternative_text) ) {
      break;
    }
  }
  return $imgHTML;
}

/**
 * Heuristic search for an image
 *
 * @param String $key
 * @param String $path
 * @param String $imgType
 * @param String $htmlParameter
 * @param String $alternative_text
 * @return String
 */
function findImage ($key,$path,$imgType,$htmlParameter="",$alternative_text='') {
  //$key=str_replace("/","",isset($key));
  $key=str_replace("/","",$key);
  if (!file_exists(PATH_TO_IMGDIR.$path.$key.$imgType)) {
    $key=preg_replace("/[^a-zA-Z0-9]/",'',$key);
    // echo $key;
  }
  else {
    $imgdata=getimagesize(PATH_TO_IMGDIR.$path.$key.$imgType);
    return ("<img src='".URL_TO_IMGDIR.$path.rawurlencode($key)."$imgType' {$imgdata[3]} ".$htmlParameter." /> ");
  }

  if (!file_exists(PATH_TO_IMGDIR.$path.$key.$imgType)) {
    $key=preg_replace("/[I(A)0-9]+$/",'',$key);
    // echo $key;
  }
  else {
    $imgdata=getimagesize(PATH_TO_IMGDIR.$path.$key.$imgType);
    return ("<img src='".URL_TO_IMGDIR.$path.rawurlencode($key)."$imgType' {$imgdata[3]} ".$htmlParameter."/> ");
  }

  if (!file_exists(PATH_TO_IMGDIR.$path.$key.$imgType)) {
    return $alternative_text;
  } else {
    $imgdata=getimagesize(PATH_TO_IMGDIR.$path.$key.$imgType);
    return ("<img src='".URL_TO_IMGDIR.$path.rawurlencode($key)."$imgType' {$imgdata[3]} ".$htmlParameter." /> ");
  }
}

?>