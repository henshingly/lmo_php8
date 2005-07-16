<?
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
if (($action=="admin") && ($todo=="upload") && ($_SESSION['lmouserok']==2)) {
  $adda=$_SERVER['PHP_SELF']."?action=admin&amp;todo=";
  if (isset($_POST['upl']) && isset($_FILES['userfile'])) {
    $tempfilename = $_FILES['userfile']['tmp_name'];
    $namefilename = $_FILES['userfile']['name']; 
    $i=0;
    $ufile=$dirliga.$namefilename;
    while (file_exists($ufile)) {
      $i++;
      if ($i>0) {
        $ufile=$dirliga.$i."_".$namefilename;
      } 
    }
    if (move_uploaded_file($tempfilename,$ufile)) {
      echo getMessage($text[303].":<br>".$ufile);
    } else {
      echo getMessage($text[304],TRUE);
    }
    @chmod($ufile,0644);
  }?>
<table class="lmoMiddle" width="99%" cellspacing="0" cellpadding="0" border="0">
  <tr>
    <td align="center"><h1><?=$text[299];?></h1></td>
  </tr>
  <tr>
    <td align="center">
      <form enctype="multipart/form-data" action="<?=$_SERVER['PHP_SELF']; ?>" method="post">
        <table class="lmoInner" cellspacing="0" cellpadding="0" border="0">
          <tr>
            <td align="center"><acronym title="<?=$text[302] ?>"><?=$text[300]; ?>:</acronym></td>
          </tr>
          <tr>
            <td align="center">              
              <input type="hidden" name="action" value="admin">
              <input type="hidden" name="todo" value="upload">
              <input type="hidden" name="upl" value="1">
              <input type="file" name="userfile">
            </td>
          </tr>
          <tr><td align="center"><input type="submit" value="<?=$text[301]; ?>"></td></tr>
        </table>
      </form>
    </td>
  </tr>
</table><?
}?>