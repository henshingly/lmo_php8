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
require_once("lmo-admintest.php");
if(($action=="admin") && ($todo=="upload") && ($_SESSION['lmouserok']==2)){
  $adda=$PHP_SELF."?action=admin&amp;todo=";
  if(!isset($upl)){$upl=0;}
  if(($upl==1) && ($userfile!="")){
    $i=0;
    $ufile=$dirliga.$userfile_name;
    while(file_exists($ufile)){
      $i++;
      if($i>0){$ufile=$dirliga.$userfile_name."_".$i;}else{$ufile=$dirliga.$userfile_name;}
      }
    if(move_uploaded_file($userfile,$ufile)){echo "<font color=\"#008800\">".$text[303].":<br>".$ufile."</font>";}else{echo "<font color=\"#ff0000\">".$text[304]."</font>";}
    }
?>
  <table class="lmosta" width="100%" cellspacing="0" cellpadding="0" border="0"><tr><td align="center" class="lmost1">
  <?PHP echo $text[299]; ?>
  </td></tr><tr><td align="center" class="lmost3">
  <table width="100%" class="lmostb" cellspacing="0" cellpadding="0" border="0"><tr><td class="lmost5" align="center">
  <acronym title="<?PHP echo $text[302] ?>"><nobr>
<FORM ENCTYPE="multipart/form-data" ACTION="<?PHP echo $PHP_SELF; ?>" METHOD="post">

<input type="hidden" name="action" value="admin">
<input type="hidden" name="todo" value="upload">
<input type="hidden" name="upl" value="1">
<INPUT TYPE="hidden" name="MAX_FILE_SIZE" value="32000">
<?PHP echo $text[300]; ?>:<br>
<INPUT NAME="userfile" TYPE="file"><br>
<INPUT TYPE="submit" VALUE="<?PHP echo $text[301]; ?>">
</FORM>
  </acronym></nobr>
  </td></tr></table>
  </td></tr></table>

<?PHP
  }
?>
