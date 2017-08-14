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
  * $Id$
  */

function check_hilfsadmin($datei) {
  $hilfsadmin_berechtigung=FALSE;
  if (isset($_SESSION['lmouserok']) && $_SESSION['lmouserok']==1){
    $hilfsadmin_ligen = explode(',',$_SESSION['lmouserfile']);
    if(isset($hilfsadmin_ligen)){
      foreach ($hilfsadmin_ligen as $hilfsadmin_liga) {
        if($hilfsadmin_liga.".l98"==basename($datei)){
          $hilfsadmin_berechtigung=TRUE;
        }
      }
    }
  } else {
    $hilfsadmin_berechtigung=TRUE;
  }
  return $hilfsadmin_berechtigung;
}


function applyFactor ($value, $factor) {
  if (is_numeric($value) && $value!=0) {
    return ($value/$factor);
  }
  return $value;
}

function magicQuotesRemove(&$array) {
  if(!get_magic_quotes_gpc())
  return;
  foreach($array as $key => $elem) {
    if(is_array($elem))
    magicQuotesRemove($elem);
    else
    $array[$key] = stripslashes($elem);
  }
}

function get_dir($verz) {
  $ret = array();
  if (substr($verz,-1)!='/') $verz.='/';

  $handle = opendir(PATH_TO_LMO."/".$verz);
  if ($handle) {
    while ($file = readdir ($handle)) {
      if ($file != "." && $file != "..") {
        if (is_dir(PATH_TO_LMO."/".$verz.$file)) {
          $ret[] = $file;
        }
      }
    }
    closedir($handle);
  }
  return $ret;
}

function filterZero($a) {
  return (!empty($a));
}


/**
 * Returns HTML imgage code for a small team icon
 *
 * @param        string     $team       Long name of the team
 * @param        string     $alternative_text      If image not found return this instead
 * @return       string     HTML image-Code for the small team icon
 */
//Umstellung Classlib kann später mal weg
function getSmallImage($team,$alternative_text='') {
  $team=str_replace("/","",$team);
  if (!file_exists(PATH_TO_IMGDIR."/teams/small/".$team.".gif")) {
    $team=preg_replace("/[^a-zA-Z0-9]/",'',$team);
  }
  if (!file_exists(PATH_TO_IMGDIR."/teams/small/".$team.".gif")) {
    return $alternative_text;
  } else {
    $imgdata=getimagesize(PATH_TO_IMGDIR."/teams/small/".$team.".gif");
    return ("<img border='0' src='".URL_TO_IMGDIR."/teams/small/".rawurlencode($team).".gif' {$imgdata[3]} alt=''> ");
  }
}

/**
 * Returns a formatted (error) Message
 *
 * @param        string     $message       Message to return
 * @param        bool       $error         Default FALSE, Is this an error message?
 * @return       string     Formatted (error) message
 */
function getMessage($message,$error=FALSE) {
  if ($error) {
    return '<p class="error"><img src="'.URL_TO_IMGDIR.'/wrong.gif" border="0" width="12" height="12" alt=""> '.$message.'</p>';
  }else {
    return '<p class="message"><img src="'.URL_TO_IMGDIR.'/right.gif" border="0" width="12" height="12" alt=""> '.$message.'</p>';
  }
}

function getLangSelector() {
  $output_sprachauswahl ='';

  $handle=opendir (PATH_TO_LANGDIR);
  while (false!==($f=readdir($handle))) {
    if (preg_match("/^lang-?(.*)?\.txt$/",$f,$lang)>0) {
      if ($lang[1]=="") return '';
      if ($lang[1]!=$_SESSION['lmouserlang']) {
        $imgfile=URL_TO_IMGDIR.'/'.$lang[1].".gif";
        $output_sprachauswahl.="<a href='{$_SERVER['PHP_SELF']}?".htmlentities(preg_replace("/&?lmouserlang=.+?\b/","",$_SERVER['QUERY_STRING']))."&amp;lmouserlang={$lang[1]}' title='{$lang[1]}'><img src='{$imgfile}' border='1' title='{$lang[1]}' alt='{$lang[1]}'></a> ";
      } else {
        $imgfile=URL_TO_IMGDIR.'/'.$lang[1].".selected.gif";
        $output_sprachauswahl.="<img title='{$lang[1]}' src='{$imgfile}' border='1' alt='{$lang[1]}'> ";
      }
    }
  }
  closedir($handle);
  if (isset($_SESSION['lmouserok']) && $_SESSION['lmouserok']=='2') {
    $output_sprachauswahl .= "&nbsp<a href='".URL_TO_LMO."/lang/translate.php'> » ".$GLOBALS['text'][573]."</a>";
  }
  return $output_sprachauswahl;
}

function get_timezones() {
  //load avail timezones
  if (function_exists('timezone_identifiers_list')) {
    $zones = array_reverse(timezone_identifiers_list());

    foreach ($zones as $zone)
    {
      $zone = explode('/', $zone); // 0 => Continent, 1 => City

      // Only use "friendly" continent names
      if ($zone[0] == 'Africa' ||
          $zone[0] == 'America' ||
          $zone[0] == 'Antarctica' ||
          $zone[0] == 'Arctic' ||
          $zone[0] == 'Asia' ||
          $zone[0] == 'Atlantic' ||
          $zone[0] == 'Australia' ||
          $zone[0] == 'Europe' ||
          $zone[0] == 'Indian' ||
          $zone[0] == 'Pacific')
      {
        if (isset($zone[1]) != '')
        {
          $locations[$zone[0]][$zone[0]. '/' . $zone[1]] = str_replace('_', ' ', $zone[1]); // Creates array(DateTimeZone => 'Friendly name')
        }
      }
    }
  } else {
    return array();
  }
  return array_reverse($locations);
}

/**
 * Replace function is_a()
 *
 * @category    PHP
 * @package     PHP_Compat
 * @link        http://php.net/function.is_a
 * @author      Aidan Lister <aidan@php.net>
 * @version     $Revision$
 * @since       PHP 4.2.0
 * @require     PHP 4.0.0 (user_error) (is_subclass_of)
 */
if (!function_exists('is_a')) {
  function is_a($object, $class)
  {
    if (!is_object($object)) {
      return false;
    }

    if (get_class($object) == strtolower($class)) {
      return true;
    } else {
      return is_subclass_of($object, $class);
    }
  }
}
?>
