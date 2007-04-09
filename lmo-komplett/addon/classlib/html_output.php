<?php
//
// +----------------------------------------------------------------------+
// |Liga Manager Online						                                        |
// +----------------------------------------------------------------------+
// | Copyright (c) 2004-2007                     													|
// |                                                                      |
// | http://www.liga-manager-online.de                                    |
// |                                                                      |
// | Copyright (c) 2006 LMO Group					                                |
// +----------------------------------------------------------------------+
// | This program is free software; you can redistribute it and/or        |
// | modify it under the terms of the GNU General Public License as       |
// | published by the Free Software Foundation; either version 2 of       |
// | the License, or (at your option) any later version.									|
// |																																			|
// | This program is distributed in the hope that it will be useful,			|
// | but WITHOUT ANY WARRANTY; without even the implied warranty of				|
// | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU			|
// | General Public License for more details.															|
// |																																			|
// | REMOVING OR CHANGING THE COPYRIGHT NOTICES IS NOT ALLOWED!           |
// +----------------------------------------------------------------------+
//
/**
 	* @author  Tim Schumacher <webobjects@gmx.net>
 	* @package classLib
 	* @access 	public
 	* @version $Id$
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
/**
 * Returns HTML image code for a small team icon
 *
 * @param        string     $team       Long name of the team
 * @param        string     $alternative_text      If image not found return this instead
 * @return       string     HTML image-Code for the small team icon
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
 * Returns HTML image code for a big team icon
 *
 * @param        string     $team       Long name of the team
 * @param        string     $alternative_text      If image not found return this instead
 * @return       string     HTML image-Code for the big team icon
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
 * Returns HTML image code for a big liga icon
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
 * Returns HTML image code for a small liga icon
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
	* Spielerbilder
	*
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
?>