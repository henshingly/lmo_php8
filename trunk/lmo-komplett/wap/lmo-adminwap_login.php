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
	Login: <input type="text" name="var_login" value="" emptyok="false"/>
	<br/>
	Passwort: <input type="password" name="var_pwd" value="" emptyok="false"/>
	<br/>
	<anchor>
		<small>Einloggen</small>
		<go href="<?php echo $addi; ?>" method="post">
			<postfield name="login" value="$(var_login)"/>
			<postfield name="pwd" value="$(var_pwd)"/>
      <postfield name="op" value="liga"/>
      <postfield name="check" value="1"/>
		</go> 
	</anchor>