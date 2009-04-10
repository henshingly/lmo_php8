<?
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
  

require_once(PATH_TO_ADDONDIR."/tipp/lmo-tipptest.php");
$tipp_mailtext = str_replace(array('\n','[nick]','[pass]','[url]'),array("\n",$xtippernick,$xtipperpass,"http://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']."?action=tipp&xtippername=".$xtippernick."&xtipperpass=".$xtipperpass),$text['tipp'][298]);
if (function_exists('ini_get') && @ini_get('safe_mode')=="0") {
  $sent=mail($xtipperemail,$text['tipp'][77],$tipp_mailtext,"From:".$text['tipp'][0]." <".$aadr.">","-f ".$aadr);
} else {
  $sent=mail($xtipperemail,$text['tipp'][77],$tipp_mailtext,"From:".$text['tipp'][0]." <".$aadr.">");
}
if ($sent) {
  echo getMessage($text['tipp'][78]);
} else {
  echo getMessage($text['tipp'][80],TRUE);
}
?>