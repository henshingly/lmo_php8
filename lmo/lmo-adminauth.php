<?php 
/** Liga Manager Online 4
  *
  * http://lmo.sourceforge.net/
  *
  * This program is free software; you can redistribute it and/or
  * modify it under the terms of the GNU General Public License as
  * published by the Free Software Foundation; either version 2 of
  * the License, or (at your option) any later version.
  * 
  * This program is distributed in the hope that it will be useful,
  * but WITHOUT ANY WARRANTY; without even the implied warranty of
  * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
  * General Public License for more details.
  *
  * REMOVING OR CHANGING THE COPYRIGHT NOTICES IS NOT ALLOWED!
  *
  */
  
  
require_once(PATH_TO_LMO."/lmo-admintest.php");
if($action=="admin"){
  require(PATH_TO_LMO."/lmo-admincheck_auth.php");
  if(empty($_SESSION['lmouserok'])){
?>

<table class="lmoMain" cellspacing="0" cellpadding="0" border="0">
  <tr>
    <td colspan="3" align="center"><h1><?php echo $text[77]." ".$text[54]; ?></h1></td>
  </tr>
  <tr>
    <td colspan="3" align="center">
      <form name="lmoedit" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <input type="hidden" name="action" value="admin">
        <table class="lmoMiddle" width="99%" cellspacing="0" cellpadding="0" border="0">
          <tr>
            <td align="center"><h1><?php echo $text[305]; ?></h1></td>
          </tr>
          <tr>
            <td align="center">
              <table class="lmoInner" cellspacing="0" cellpadding="0" border="0">
                <tr>
                  <td align="right"><acronym title="<?php echo $text[307] ?>"><?php echo " ".$text[306]; ?></acronym></td>
                  <td align="left"><input class="lmo-formular-input" type="text" name="xusername" size="16" maxlength="32" value="<?php echo $_SESSION['lmousername']; ?>"></td>
                </tr>
                <tr>
                  <td align="right"><acronym title="<?php echo $text[309] ?>"><?php echo " ".$text[308]; ?></acronym></td>
                  <td align="left"><input class="lmo-formular-input" type="password" name="xuserpass" size="16" maxlength="32" value="<?php echo $_SESSION['lmouserpass']; ?>"></td>
                </tr>
                <tr>
                  <td align="left">&nbsp;</td>
                  <td align="left"><input title="<?php echo $text[311] ?>" class="lmo-formular-button" type="submit" name="xusersub" value="<?php echo $text[310]; ?>"></td>
                </tr>
              </table>
            </td>
          </tr>
          <tr>
            <td align="center" class="lmoMenu"><a href="<?php echo URL_TO_LMO?>/lmo.php" title="<?php echo $text[470]; ?>"><?php echo $text[469]; ?></a></td>
          </tr>
        </table>
      </form>
    </td>
  </tr>
  <tr>
    <td class="lmoFooter" colspan="3" align="center">
      <p><?php echo $text[54]."<br>Copyright ".$text[55]; ?></p>
      <p>LigaManager Online comes with ABSOLUTELY NO WARRANTY.</p>
      <p> This is free software, and you are welcome to redistribute it under certain conditions.</p>
      <p>Read <a href="<?php echo URL_TO_LMO?>/gpl.txt" target="_blank" title="GPL - GNU General Public License">this</a> for details.</p>
    </td>
  </tr>
</table><?php 
  }
}?>