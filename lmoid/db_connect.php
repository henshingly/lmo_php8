<?
mysql_connect(LMOID_DB_SERVER,LMOID_DB_USER,LMOID_DB_PASS); //Verbindung zur Datenbank
mysql_select_db (LMOID_DB); //Datenbank auswählen
echo mysql_error();
?>