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
<div class="container-fluid">
  <div class="text-center"><h1><?php echo $text[77]." ".$text[54]; ?></h1></div>
</div>
<div class="container-fluid p-3">
  <div class="row">
    <div class="col-4 offset-4">
      <form name="lmoedit" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" role="form" class="row g-3">
        <input type="hidden" name="action" value="admin">
        <div class="col-12"><?php echo $text[305]; ?></div>
        <div class="col-6">
           <input class="form-control" type="text" name="xusername" placeholder="<?php echo $text[306]; ?>" value="<?php echo $_SESSION['lmousername']; ?>">
        </div>
        <div class="col-6">
           <input class="form-control" type="password" name="xuserpass" placeholder="<?php echo $text[308]; ?>" value="<?php echo $_SESSION['lmouserpass']; ?>">
        </div>
        <div class="col-6 text-start">
           <input title="<?php echo $text[311] ?>" class="btn btn-primary btn-sm" type="submit" name="xusersub" value="<?php echo $text[310]; ?>">
        </div>
        <div class="col-6 text-end">
           <a class="btn btn-secondary btn-sm" href="<?php echo URL_TO_LMO?>/lmo.php" title="<?php echo $text[470]; ?>"><?php echo $text[469]; ?></a>
        </div>
      </form>
    </div>
  </div>
  <div class="row">
    <div class="col">
      <p><?php echo $text[54]."<br>Copyright ".$text[55]; ?></p>
      <p>LigaManager Online comes with ABSOLUTELY NO WARRANTY.</p>
      <p> This is free software, and you are welcome to redistribute it under certain conditions.</p>
      <p>Read <a href="<?php echo URL_TO_LMO?>/gpl.txt" target="_blank" title="GPL - GNU General Public License">this</a> for details.</p>
    </div>
  </div>
</div><?php
  }
}?>