<? 
if (basename($_SERVER['PHP_SELF'])==basename(__FILE__)) {
  define("LMO_TEMPLATE","lmo-standard-komplett.tpl.php");
} else { //includet
  define("LMO_TEMPLATE","lmo-standard.tpl.php");
}
require("lmo-start.php");?>