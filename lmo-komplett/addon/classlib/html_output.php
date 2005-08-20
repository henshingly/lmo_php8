<?PHP
//
/**
 * LMO Class Library
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
 * @author  Tim Schumacher <webobjects@gmx.net>
 * @package classLib
 * @access 	public
 * @version $Id$
 */

function HTML_smallTeamIcon($ligaFile,$team,$htmlParameter="") {

	$generated = FALSE;
	$img_path = PATH_TO_IMGDIR."/teamicons/small/";
  if (file_exists($img_path)) { // Teamicon addon Verzeichnisstruktur
  	$ligaDirName = strBeforChar($ligaFile,".");
    $img_path .= $ligaDirName."_";
    if(is_object($team) and get_class($team) == "team" ) {
      $img_path .= $team->nr;
    }
    elseif (is_string($team) ){ // Schaut in das team Verzeichnis nach
      $img_path = PATH_TO_IMGDIR."/teams/small/".$team; // PATH TO IMG (ohne extension)
    }
    else $img_path .= $team;
    foreach( const_array( CLASSLIB_IMG_TYPES ) as $extension) {
      if ($generated = HTML_image($img_path.$extension,$htmlParameter) ) {
        break;
      }
    }
	}
	// Letzt Chance im alten Verzeichnis schauen
	// Wird zukünftig warscheinlich entfallen
  if (!$generated ) {
    foreach( const_array( CLASSLIB_IMG_TYPES ) as $extension) {
			$img_path = PATH_TO_IMGDIR."/teams/small/".strtr($team->name,array("/"=>"")); // PATH TO IMG (ohne extension), Teamnamen ohne /
      if ($generated = HTML_image($img_path.$extension,$htmlParameter) ) {
        break;
      }
    }
  }

	return $generated;
}

function HTML_bigTeamIcon($ligaFile,$team,$htmlParameter="") {
	$generated = FALSE;
	$img_path = PATH_TO_IMGDIR."/teamicons/big/";
  if (file_exists($img_path)) { // Teamicon addon Verzeichnisstruktur
  	$ligaDirName = strBeforChar($ligaFile,".");
    $img_path .= $ligaDirName."_";
    if(is_object($team) and get_class($team) == "team" ) {
      $img_path .= $team->nr;
    }
    elseif (is_string($team) ){ // Schaut im team Verzeichnis nach (standard imgage verzeichnisstruktur)
      $img_path = PATH_TO_IMGDIR."/teams/big/".$team; // PATH TO IMG (ohne extension)
    }
    else $img_path .= $team;

    foreach( const_array( CLASSLIB_IMG_TYPES ) as $extension) {
      if ($generated = HTML_image($img_path.$extension,$htmlParameter) ) {
        break;
      }
    }
	}
	// Letzt Chance im alten Verzeichnis schauen

  if (!$generated ) {
    foreach( const_array( CLASSLIB_IMG_TYPES ) as $extension) {
			$img_path = PATH_TO_IMGDIR."/teams/big/".strtr($team->name,array("/"=>""));// PATH TO IMG (ohne extension), Teamnamen ohne /
      if ($generated = HTML_image($img_path.$extension,$htmlParameter) ) {
        break;
      }
    }
  }
	return $generated;
}

function HTML_image($src,$htmlParameter="") { // ACHTUNG: $src IST DER PFAD NICHT DIE URL
	$html = "";

  if (!file_exists($src)) {
    //Apache2-Fallback
    $src=dirname($src)."/".preg_replace("/[^a-zA-Z0-9\.]/",'',basename($src));
  }
  if (file_exists($src)) {
    $img_size = @getimagesize($src);
    $fullUrl = str_replace(PATH_TO_LMO,URL_TO_LMO,$src);
    $url = strBeforChar($fullUrl,"/");
    $file  = strAfterChar($fullUrl,"/");
		$html = "<img src=\"".$url."/".rawurlencode($file)."\" ".$img_size[3]." $htmlParameter>";
/*
    echo "<br>SOURCE =".$src;
    echo "<br>URL =".$fullUrl;
    echo "<br>file = ".$file;
    echo "<br>file rawurlencode = ".rawurlencode($file);
    echo $html;
*/

  }
	return $html;
}
?>