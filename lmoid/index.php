<?
session_start();
require("cfg.php");
$_SESSION['ok']=true;?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN"
   "http://www.w3.org/TR/html4/frameset.dtd">
<HTML>
<HEAD>
<TITLE>LMO IconDB <?=VERSION?> - Liga Manager Online Icon Database</TITLE>
</HEAD>
<FRAMESET cols="70%,30%">
  <FRAME name="main" src="main.php">
  <FRAME name="result" src="result.php">
</FRAMESET>
<noframes>
  <h1>LMO Icon Database</h1>
  <a href="main.php" target="main">Open the Selection Window</a>
  <a href="result.php" target="result">Open the File Window</a>
</noframes>
</HTML>