<?
if (!isset($wap_file))$file="";?>
<card id="login" title="Login">
  <p align="center"><b>LMO-Wapadmin</b></p>
  <p>
  	Login: <input type="text" name="lmousername" value="" emptyok="false"/>
  	<br/>
  	Pass: &#160;<input type="password" name="lmouserpass" value="" emptyok="false"/>
  	<br/>
  	<small><anchor>
  		Einloggen
  		<go href="<? echo $_SERVER['PHP_SELF']; ?>" method="post">
  			<postfield name="xusername" value="$(lmousername)"/>
  			<postfield name="xuserpass" value="$(lmouserpass)"/>
        <postfield name="op" value="liga"/>
  		</go> 
  	</anchor></small>
  </p>
</card>