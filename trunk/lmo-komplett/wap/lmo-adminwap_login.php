<?php
/*
---------------------------------------------------------------
Datei: lmo-adminwap_login.php
Version: 1.2
Datum: 22.08.2003
Autor: Lord_Helmchen
Release by bastard (Adminpage)
---------------------------------------------------------------
Hier werden Login und Password abgefragt
*/
if (!isset($file))$file="";
echo("<card id=\"login\" title=\"Login\">\n");
echo("<p align='center'><b>LMO-Wapadmin</b></p>\n");
echo("<p>\n");
?>
	Login: <input type="text" name="wap_username" value="" emptyok="false"/>
	<br/>
	Passwort: <input type="password" name="wap_userpass" value="" emptyok="false"/>
	<br/>
	<anchor>
		<small>Einloggen</small>
		<go href="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
			<postfield name="wap_username" value="$(wap_username)"/>
			<postfield name="wap_userpass" value="$(wap_userpass)"/>
      <postfield name="op" value="liga"/>
		</go> 
	</anchor>