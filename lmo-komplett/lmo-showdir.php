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
  
  

?>
<table class="lmoMiddle" cellspacing="0" cellpadding="0" border="0">
   <?/*<tr>
    <td align="right">
<?include(PATH_TO_LMO."/lmo-ligensortierung.php");?></td>
  </tr>*/?>
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
  <?/*<tr>
    <td align="right">
<?include(PATH_TO_LMO."/lmo-ligensortierung.php");?></td>
  </tr>*/?>
</table><?