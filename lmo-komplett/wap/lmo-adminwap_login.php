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

if (!isset($wap_file))$file="";?>
<card id="login" title="Login">
  <p align="center"><b>LMO-Wapadmin</b></p>
  <p>
  	Login: <input type="text" name="lmousername" value="" emptyok="false"/>
  	<br/>
  	Pass: &nbsp;<input type="password" name="lmouserpass" value="" emptyok="false"/>
  	<br/>
  	<small><anchor>
  		Einloggen
  		<go href="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
  			<postfield name="xusername" value="$(lmousername)"/>
  			<postfield name="xuserpass" value="$(lmouserpass)"/>
        <postfield name="op" value="liga"/>
  		</go> 
  	</anchor></small>
  </p>
</card>