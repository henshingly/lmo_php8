<?
require(dirname(__FILE__).'/init-parameters.php');

if (isset($_GET['debug']) || isset($_SESSION['debug'])) {
    $_SESSION['debug']=TRUE;
    @error_reporting(E_ALL);
    @ini_set('display_errors','1');
}

if (session_id()=="") session_start();
@ini_set("arg_separator.output","&amp;");
if (!defined('PATH_TO_LMO'))        define('PATH_TO_LMO',         $lmo_dateipfad);
if (!defined('PATH_TO_ADDONDIR'))   define('PATH_TO_ADDONDIR',    PATH_TO_LMO.'/addon');
if (!defined('PATH_TO_TEMPLATEDIR'))define('PATH_TO_TEMPLATEDIR', PATH_TO_LMO.'/template');
if (!defined('PATH_TO_IMGDIR'))     define('PATH_TO_IMGDIR',      PATH_TO_LMO.'/img');
if (!defined('PATH_TO_LANGDIR'))    define('PATH_TO_LANGDIR',     PATH_TO_LMO.'/lang');
if (!defined('PATH_TO_CONFIGDIR'))  define('PATH_TO_CONFIGDIR',   PATH_TO_LMO.'/config');
if (!defined('PATH_TO_JSDIR'))      define('PATH_TO_JSDIR',       PATH_TO_LMO.'/js');

if (!defined('URL_TO_LMO'))         define('URL_TO_LMO',          $lmo_url);
if (!defined('URL_TO_ADDONDIR'))    define('URL_TO_ADDONDIR',     URL_TO_LMO.'/addon');
if (!defined('URL_TO_TEMPLATEDIR')) define('URL_TO_TEMPLATEDIR',  URL_TO_LMO.'/template');
if (!defined('URL_TO_IMGDIR'))      define('URL_TO_IMGDIR',       URL_TO_LMO.'/img');
if (!defined('URL_TO_LANGDIR'))     define('URL_TO_LANGDIR',      URL_TO_LMO.'/lang');
if (!defined('URL_TO_CONFIGDIR'))   define('URL_TO_CONFIGDIR',    URL_TO_LMO.'/config');
if (!defined('URL_TO_JSDIR'))       define('URL_TO_JSDIR',        URL_TO_LMO.'/js');

require_once(PATH_TO_LMO."/lbtemplate.class.php");
require_once(PATH_TO_LMO."/lmo-cfgload.php");
if(isset($_REQUEST["lmouserlang"])){$_SESSION["lmouserlang"]=$_REQUEST["lmouserlang"];}
if(isset($_SESSION["lmouserlang"])){$lmouserlang=$_SESSION["lmouserlang"];}else{$lmouserlang=$deflang;}
require_once(PATH_TO_LMO."/lmo-langload.php");

if (!function_exists('check_hilfsadmin')) {
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
}
if (!function_exists('applyFactor')) {
  function applyFactor ($value, $factor) {
    if (is_numeric($value)) {
      return ($value/$factor);
    }
    return $value;
  }
}

if (!function_exists('magicQuotesRemove')) {
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
}
//Remove Magic Quotes if necessary
magicQuotesRemove($_GET);
magicQuotesRemove($_POST);
magicQuotesRemove($_COOKIE);
?>