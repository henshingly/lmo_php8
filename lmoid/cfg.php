<?
/*Config*/

//DB-Config
define('LMOID_DB_SERVER',"");
define('LMOID_DB_USER',"");
define('LMOID_DB_PASS',"");
define('LMOID_DB',"lmo_iconbase");


//Icon path
define('ICON_PATH',$_SERVER['PHP_SELF'].'/icons/');  //Icondir
define('ICON_URL','icons/');  //Icon-URL



define('MAXIMUM_ICONS_PER_ZIP',40);  //Maximalanzahl Icons/Zip-Datei
define('MAXIMUM_SEARCH_RESULTS',500);  //Maximalanzahl Suchergebnisse



define('DEFAULT_COUNTRY','Deutschland');  //Standardland bei neuen Vereinen

/*Language*/
define('SEARCH','Suche');
define('TEAM','Mannschaft');

define("VERSION","v0.0.1&alpha;");
?>