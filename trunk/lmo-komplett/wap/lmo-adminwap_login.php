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

if (!isset($wap_file))$file="";
echo("<card id=\"login\" title=\"Login\">\n");
echo("<p align='center'><b>LMO-Wapadmin</b></p>\n");
echo("<p>\n");
?>
	Login: <input type="text" name="lmousername" value="" emptyok="false"/>
	<br/>
	Passwort: <input type="password" name="lmouserpass" value="" emptyok="false"/>
	<br/>
	<anchor>
		<small>Einloggen</small>
		<go href="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
			<postfield name="xusername" value="$(lmousername)"/>
			<postfield name="xuserpass" value="$(lmouserpass)"/>
      <postfield name="op" value="liga"/>
		</go> 
	</anchor>