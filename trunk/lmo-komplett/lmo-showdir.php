<?PHP
//
// LigaManager Online 3.02
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

?>
<table class="lmostb" width="100%" cellspacing="0" cellpadding="0" border="0">
   <tr>
    <td class="lmost5" align="right"><?include(PATH_TO_LMO."/lmo-ligensortierung.php");?></td>
  </tr>
  <tr>
    <td class="lmost5" align="left"><?
if(isset($_REQUEST["archiv"]) && $_REQUEST["archiv"]!=""){
  if (substr($ArchivDir,-1)!='/') $ArchivDir.='/';
  if ($_REQUEST["archiv"]!="dir") {
    $dirliga=$ArchivDir.$_REQUEST["archiv"].'/';
    include(PATH_TO_LMO."/lmo-dirlist.php");
  }else{?>
      <ul><?
    $dirs = get_dirs($ArchivDir);
    $count=0;
    foreach($dirs as $dir) {
      $count++;
      $output=@implode("",file("{$ArchivDir}{$dir}/dir-descr.txt"));?>
        <li><a href="<?=$_SERVER['PHP_SELF']?>?archiv=<?=$dir?>"><?$output==""?print($dir):print($output);?></a></li><?
    }
    if ($count==0) {?>
        <li><?=$text[223]?></li><?
    }?>
      </ul><?
  }
}else{
  include(PATH_TO_LMO."/lmo-dirlist.php");
}?>
    </td>
  </tr>
  <tr>
    <td class="lmost5" align="right"><?include(PATH_TO_LMO."/lmo-ligensortierung.php");?></td>
  </tr>
</table><?