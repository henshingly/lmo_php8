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
if (!function_exists('phpLinkCheck')) {
  function phpLinkCheck($url, $r = FALSE)
  {
    /*  Purpose: Check HTTP Links
     *  Usage:   $var = phpLinkCheck(absoluteURI)
     *           $var["Status-Code"] will return the HTTP status code
     *           (e.g. 200 or 404). In case of a 3xx code (redirection)
     *           $var["Location-Status-Code"] will contain the status
     *           code of the new loaction.
     *           See print_r($var) for the complete result
     *
     *  Author:  Johannes Froemter <j-f@gmx.net>
     *  Date:    2001-04-14
     *  Version: 0.1 (currently requires PHP4)
     */
  
    $url = trim($url);
    if (!preg_match("=://=", $url)) $url = "http://$url";
    $url = @parse_url($url);
    if (strtolower($url["scheme"]) != "http") return FALSE;
  
    if (!isset($url["port"])) $url["port"] = 80;
    if (!isset($url["path"])) $url["path"] = "/";
  
    $fp = fsockopen($url["host"], $url["port"], $errno, $errstr, 30);
  
    if (!$fp) return FALSE;
    else
    {
      $head = "";
      $httpRequest = "HEAD ". $url["path"] ." HTTP/1.1\r\n"
                    ."Host: ". $url["host"] ."\r\n"
                    ."Connection: close\r\n\r\n";
      fputs($fp, $httpRequest);
      while(!feof($fp)) $head .= fgets($fp, 1024);
      fclose($fp);
  
      preg_match("=^(HTTP/\d+\.\d+) (\d{3}) ([^\r\n]*)=", $head, $matches);
      $http["Status-Line"] = $matches[0];
      $http["HTTP-Version"] = $matches[1];
      $http["Status-Code"] = $matches[2];
      $http["Reason-Phrase"] = $matches[3];
  
      if ($r) return $http["Status-Code"];
  
      $rclass = array("Informational", "Success",
                      "Redirection", "Client Error",
                      "Server Error");
      $http["Response-Class"] = $rclass[$http["Status-Code"][0] - 1];
  
      preg_match_all("=^(.+): ([^\r\n]*)=m", $head, $matches, PREG_SET_ORDER);
      foreach($matches as $line) $http[$line[1]] = $line[2];
  
      if ($http["Status-Code"][0] == 3)
        $http["Location-Status-Code"] = phpLinkCheck($http["Location"], TRUE);
  
      return $http;
    }
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
if (!function_exists('magicQuotesRemove')) {
  function mictime() {
     list($usec, $sec) = explode(" ",microtime());
     return ((float)$usec + (float)$sec);
  }
}
//Remove Magic Quotes if necessary
magicQuotesRemove($_GET);
magicQuotesRemove($_POST);
magicQuotesRemove($_COOKIE);
?>