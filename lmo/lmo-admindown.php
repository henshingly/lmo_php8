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
if(($action=="admin") && ($todo=="download")){?>

<div class="container-fluid">
  <div class="row justify-content-center">
    <div class="col"><h1><?php echo $text[316];?></h1></div>
    <div class="col"><h1><?php echo $text[345];?></h1></div>
  </div>
  <div class="row justify-content-center">
    <div class="col">
      <div class="container-fluid">
        <div class="row justify-content-center">
          <div class="col"><?php 
  $ftype=".l98"; 
  require(PATH_TO_LMO."/lmo-admindowndir.php"); ?>
          </div>
        </div>
      </div>
    </div>
    <div class="col">
      <div class="container-fluid">
        <div class="row justify-content-center">
          <div class="col"><?php  $ftype=".l98"; 
  require(PATH_TO_LMO."/lmo-adminmimedir.php"); ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div><?php 
}?>