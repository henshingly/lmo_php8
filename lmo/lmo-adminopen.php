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
$subdir=isset($_REQUEST["subdir"])?$_REQUEST["subdir"]:'';
if(($action=="admin") && ($todo=="open")){
  $adda=$_SERVER['PHP_SELF']."?action=admin&amp;todo=";
?>
<div class="container-fluid">
  <div class="row">
    <div class="col"><h1><?php echo $text[294]?></h1></div>
  </div>
  <div class="row">
    <div class="col"><?php require(PATH_TO_LMO."/lmo-dirlist.php"); ?></div>
  </div>
  <div class="row">
    <div class="col"><?php
  $subdir=str_replace(array('../','./'),array('',''),$subdir);
  $dirs = get_dir($dirliga.$subdir);
  natcasesort($dirs);
  if (!empty($subdir) && substr($subdir,-1)!='/') $subdir.='/';

  $output='';
  foreach($dirs as $dir) {
    $descr=@implode("",file($dirliga.$subdir.$dir."/dir-descr.txt"));
    $output.=  "<div class='row'><div class='col-1'>&nbsp;</div><div class='col-4 text-start'><a href='".$adda."open&amp;subdir=".$subdir.$dir."/'>".$dir."</a></div>";
    if ($descr!="") {
      $output.= "<div class='col-2 text-start'><small>".$descr."</small></div>";
    }
    $output.="</div>";
  }

  if ($output!='') {?>
      <div class="container">
        <div class="row">
		  <div class="col-1">&nbsp;</div>
          <div class="col-4 text-start"><?php echo $text[509];?></div>
        </div>
        <?php echo $output?>
      </div><?php
  }
  if (strpos($subdir,'/')!==FALSE) {?>
      <p class="text-end"><a href="<?php echo $adda?>open&amp;subdir=<?php echo dirname($subdir).'/'?>"><?php echo $text[5];?> <?php echo $text[562];?></a></p><?php
  }
  ?></div>
  </div>
</div>
<?php
}?>