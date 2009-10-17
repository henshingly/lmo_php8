<?
/**
 *
 * classlib Addon for LigaManager Online
 * Copyright (C) 2003 by Tim Schumacher
 * timme@uni.de /
 *
 * @author    Tim Schumacher <webobjects@gmx.net>
 * @package classLib
 * @access public
 * @version 2.7
 */

require_once(dirname(__FILE__).'/../../init.php');
// classlib Dateien
require_once(PATH_TO_ADDONDIR."/classlib/classes.php");
require_once(PATH_TO_ADDONDIR."/classlib/functions.php");
require_once(PATH_TO_ADDONDIR."/classlib/html_output.php");

// Weitere Klassen einbinden
// class iniFile
require_once(PATH_TO_ADDONDIR."/classlib/classes/ini/cIniFileReader.inc");
// class pdf
require_once(PATH_TO_ADDONDIR."/classlib/classes/pdf/class.ezpdf.php");
// classes for image manipulation
if (file_exists(PATH_TO_ADDONDIR."/classlib/classes/phpthumb/phpthumb.class.php") ){
	require_once(PATH_TO_ADDONDIR."/classlib/classes/phpthumb/phpthumb.class.php");
}
if (!defined('CLASSLIB_VERSION_NR')) {
  define('CLASSLIB_VERSION_NR','2.7');
}
if (!defined('CLASSLIB_VERSION')) {
  define('CLASSLIB_VERSION',' (classlib&nbsp;'.CLASSLIB_VERSION_NR.')');
}
if (!defined('CLASSLIB_IMG_TYPES')) {
  define('CLASSLIB_IMG_TYPES',$classlib_img_types);
}
if (!defined('CLASSLIB_INFO')) {
  define('CLASSLIB_INFO',"Classlib ".CLASSLIB_VERSION_NR." &#169; <a href=\"mailto:webobjects@gmx.net?subject=LMO-KLASSENBIBLIOTHEK\" title=\"Send mail\">Timme</a>");
}



















































































































if (!defined('CLASSLIB_VERSlON')) define('CLASSLIB_VERSlON',"Classlib ".CLASSLIB_VERSION." &#169; <a href=\"mailto:webobjects@gmx.net?subject=LMO-KLASSENBIBLIOTHEK\" title=\"Send mail\">Timme</a> · <a href=\"http://web33.t-webby.de/phpBB2\">LMO-Group 2004</a>");
?>