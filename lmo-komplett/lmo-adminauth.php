<?PHP
// 
// LigaManager Online 3.02b
// Copyright (C) 1997-2002 by Frank Hollwitz
// webmaster@hollwitz.de / http://php.hollwitz.de
// 
// This program is free software; you can redistribute it and/or
// modify it under the terms of the GNU General Public License as
// published by the Free Software Foundation; either version 2 of
// the License, or (at your option) any later version.
// 
// This program is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
// General Public License for more details.
// 
// You should have received a copy of the GNU General Public License
// along with this program; if not, write to the Free Software
// Foundation, Inc., 675 Mass Ave, Cambridge, MA 02139, USA.
// 
require_once(PATH_TO_LMO."/lmo-admintest.php");
if($action=="admin"){
  require(PATH_TO_LMO."/lmo-admincheck_auth.php");
  if(!isset($_SESSION['lmouserok']) || $_SESSION['lmouserok']==0){
?>

<table class="lmomaina" cellspacing="0" cellpadding="0" border="0">
  <tr>
    <td class="lmomain0" colspan="3" align="center"><nobr>
      <?PHP echo $text[77]." ".$text[54]; ?>
    </nobr></td>
  </tr><tr>
    <td class="lmomain1" colspan="3" align="center">

  <form name="lmoedit" action="<?PHP echo $_SERVER['PHP_SELF']; ?>" method="post">
  
  <input type="hidden" name="action" value="admin">
  <table class="lmosta" width="100%" cellspacing="0" cellpadding="0" border="0"><tr><td align="center" class="lmost1">
  <?PHP echo $text[305]; ?>
  </td></tr><tr><td align="center" class="lmost3">
  <table width="100%" class="lmostb" cellspacing="0" cellpadding="0" border="0">
    <tr>
      <td class="lmost5" align="right"><acronym title="<?PHP echo $text[307] ?>"><?PHP echo " ".$text[306]; ?></acronym></td>
      <td class="lmost5"><acronym title="<?PHP echo $text[307] ?>"><input class="lmoadminein" type="text" name="xusername" size="16" maxlength="32" value="<?PHP echo $_SESSION['lmousername']; ?>"></acronym></a>
    </tr>
    <tr>
      <td class="lmost5" align="right"><acronym title="<?PHP echo $text[309] ?>"><?PHP echo " ".$text[308]; ?></acronym></td>
      <td class="lmost5"><acronym title="<?PHP echo $text[309] ?>"><input class="lmoadminein" type="password" name="xuserpass" size="16" maxlength="32" value="<?PHP echo $_SESSION['lmouserpass']; ?>"></acronym></a>
    </tr>
    <tr>
      <td class="lmost5">&nbsp;</td>
      <td class="lmost5"><acronym title="<?PHP echo $text[311] ?>"><input class="lmoadminbut" type="submit" name="xusersub" value="<?PHP echo $text[310]; ?>"></acronym></td>
    </tr>
  </table>
  </td></tr><tr><td align="center" class="lmost2">
  <a href="lmo.php" title="<?PHP echo $text[470]; ?>"><?PHP echo $text[469]; ?></a>
  </td></tr></table>
  </form>

    </td>
  </tr><tr>
    <td class="lmomain1" colspan="3" align="center"><nobr>&nbsp;<br>
      <?PHP echo $text[54]."<br>Copyright ".$text[55]; ?><br>
      LigaManager Online comes with ABSOLUTELY NO WARRANTY.<br>
      This is free software, and you are welcome to redistribute<br>
      it under certain conditions. Read <a href="gpl.txt" target="_blank" title="GPL - Gnu General Public License">this</a> for details.<br>
    </nobr></td>
  </tr>
</table>

<?PHP
    }
  }
?>