<? 
if (basename($_SERVER['PHP_SELF'])==basename(__FILE__)) {
  if (!defined('LMO_TEMPLATE')) {
    define("LMO_TEMPLATE","lmo-standard-komplett.tpl.php");
  }
} else { //includet
  if (!defined('LMO_TEMPLATE')) {
    define("LMO_TEMPLATE","lmo-standard.tpl.php");
  }
}
require(dirname(__FILE__)."/lmo-start.php");?>