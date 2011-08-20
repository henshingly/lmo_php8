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
  
  

?>
<table class="lmoMiddle" cellspacing="0" cellpadding="0" border="0">
   <?php /*<tr>
    <td align="right">
<?php include(PATH_TO_LMO."/lmo-ligensortierung.php");?></td>
  </tr>*/?>
  <tr>
    <td align="left"><?php 
include(PATH_TO_LMO."/lmo-dirlist.php");?>
    </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="left"><?php 
if ($archivlink==1) {
  $subdir=str_replace(array('../','./'),array('',''),$subdir);
  $dirs = get_dir($dirliga.$subdir);
  natcasesort($dirs);
  if (!empty($subdir) && substr($subdir,-1)!='/') $subdir.='/';
 
  $output='';
  foreach($dirs as $dir) {
    $descr=@implode("",file($dirliga.$subdir.$dir."/dir-descr.txt"));
    $output.=  "<tr><td><a href='".$_SERVER['PHP_SELF']."?subdir=".$subdir.$dir."/'>".$dir."</a></td>";
    if ($descr!="") {
      $output.= "<td><small>".htmlentities($descr)."</small></td>";
    }
    $output.="</tr>";
  }
  
  if ($output!='') {?>
      <table class='lmoInner' cellspacing="0" width="99%">
        <tr>
          <th colspan="2"><?php echo $text[509];?></th>
        </tr>
        <?php echo $output?>
      </table><?php 
  }
  if (strpos($subdir,'/')!==FALSE) {?>
      <p><a href="<?php echo $_SERVER['PHP_SELF']?>?subdir=<?php echo dirname($subdir).'/'?>"><?php echo $text[5];?> <?php echo $text[562];?></a></p><?php 
  }
}?>
    </td>
  </tr>
  <?php /*<tr>
    <td align="right">
<?php include(PATH_TO_LMO."/lmo-ligensortierung.php");?></td>
  </tr>*/?>
</table><?php