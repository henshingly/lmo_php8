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
 *
 */

/**
 * Returns HTML-Code for an icon
 *
 *
 * @since 2.8
 * @param string $img_name
 * @param string $img_type (teams, liga, spieler)
 * @param string $img_size (small, middle, big)
 * @param string $html HTML-Params
 * @param string $alternative_text
 */
function HTML_icon($img_name,$img_type,$img_size='small',$html="",$alternative_text="") {
  $subFolder = "/".$img_type."/".$img_size."/";
  foreach( const_array( CLASSLIB_IMG_TYPES ) as $extension) {
    if ($imgHTML = findImage($img_name,$subFolder,$extension,$html,$alternative_text) ) {
      break;
    }
  }
  if ($imgHTML == "") {
      $imgHTML = substr($html, 6, strrpos($html, "'") - 6);
  }
  return $imgHTML;
}

/**
 * Returns HTML code for a small team logo (if  available in img/teams/small)
 * Deprecated! Use HTML_icon() instead
 *
 * @deprecated
 * @param string $ligaFile
 * @param string $team
 * @param string $html
 * @param string $alternative_text
 * @return string
 */
function HTML_smallTeamIcon($ligaFile,$team,$htmlParameter="",$alternative_text="") {
  return HTML_icon($team,'teams','small',$htmlParameter,$alternative_text);
}

/**
 * Returns HTML code for a big team logo (if  available in img/teams/big)
 * Deprecated! Use HTML_icon() instead
 *
 * @deprecated
 * @param string $ligaFile
 * @param string $team
 * @param string $html
 * @param string $alternative_text
 * @return string
 */
function HTML_bigTeamIcon($ligaFile,$team,$htmlParameter="",$alternative_text="") {
  return HTML_icon($team,'teams','big',$htmlParameter,$alternative_text);
    }

/**
 * Returns HTML code for a small league logo (if  available in img/liga/small)
 * Deprecated! Use HTML_icon() instead
 *
 * @deprecated
 * @param string $ligaFile
 * @param string $html
 * @param string $alternative_text
 * @return string
 */
function HTML_smallLigaIcon($ligaFile,$htmlParameter="",$alternative_text="") {
  $fileName = strBeforChar(basename($ligaFile),'.');
  return HTML_icon($fileName,'liga','small',$htmlParameter,$alternative_text);
    }

/**
 * Returns HTML code for a big league logo (if  available in img/liga/big)
 * Deprecated! Use HTML_icon() instead
 *
 * @deprecated
 * @param string $ligaFile
 * @param string $html
 * @param string $alternative_text
 * @return string
 */
function HTML_bigLigaIcon($ligaFile,$htmlParameter="",$alternative_text="") {
  $fileName = strBeforChar(basename($ligaFile),'.');
  return HTML_icon($fileName,'liga','big',$htmlParameter,$alternative_text);
    }


/**
 * Returns HTML code for a small players icon (if available in img/spieler/small)
 * Deprecated! Use HTML_icon() instead
 *
 * @deprecated
 * @param string $ligaFile
 * @param string $liganame
 * @param string $htmlParameter
 * @return string
 */

function HTML_smallSpielerIcon($spieler,$htmlParameter="",$alternative_text="") {
  return HTML_icon($spieler,'spieler','small',$htmlParameter,$alternative_text);
    }

/**
 * Returns HTML code for a big players icon (if available in img/spieler/big)
 * Deprecated! Use HTML_icon() instead
 *
 * @deprecated
 * @param string $ligaFile
 * @param string $liganame
 * @param string $htmlParameter
 * @return string
 */
function HTML_bigSpielerIcon($spieler,$htmlParameter="",$alternative_text="") {
  return HTML_icon($spieler,'spieler','big',$htmlParameter,$alternative_text);
    }

/**
 * Heuristic search for an image
 *
 * @param string $key
 * @param string $path
 * @param string $imgType
 * @param string $htmlParameter
 * @param string $alternative_text
 * @return string
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
