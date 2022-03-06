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
if($file!="" && ($_SESSION['lmouserok']==2 || $_SESSION['lmouserokerweitert']==1)){
  require_once(PATH_TO_LMO."/lmo-openfile.php");
  if(isset ($save) && $save==1){
    for($i=0;$i<$anzst;$i++){
      for($j=$anzsp;$j<40;$j++){
        $teama[$i][$j]=0;
        $teamb[$i][$j]=0;
        $goala[$i][$j]=-1;
        $goalb[$i][$j]=-1;
        $msieg[$i][$j]=0;
        $mterm[$i][$j]="";
        $mnote[$i][$j]="";
        $mberi[$i][$j]="";
        $mspez[$i][$j]="_";
        }
      }
    for($i=$anzst;$i<116;$i++){
      for($j=0;$j<40;$j++){
        $teama[$i][$j]=0;
        $teamb[$i][$j]=0;
        $goala[$i][$j]=-1;
        $goalb[$i][$j]=-1;
        $msieg[$i][$j]=0;
        $mterm[$i][$j]="";
        $mnote[$i][$j]="";
        $mberi[$i][$j]="";
        $mspez[$i][$j]="_";
        }
      }
    $anzst=trim($_POST["xanzst"]);
    $anzsp=trim($_POST["xanzsp"]);
    if($stx>$anzst){$stx=$anzst;}
    require(PATH_TO_LMO."/lmo-savefile.php");
    }
  $addr=$_SERVER['PHP_SELF']."?action=admin&amp;todo=edit&amp;file=".$file."&amp;st=";
  $addb=$_SERVER['PHP_SELF']."?action=admin&amp;todo=tabs&amp;file=".$file."&amp;st=";
?>
<div class="container">
 <div class="row p-3">
   <div class="col"><?php  include(PATH_TO_LMO."/lmo-adminsubnavi.php"); ?></div>
  </div>
  <div class="row">
    <div class="col">
      <form name="lmoedit" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" onSubmit="return chklmopass()">
        <input type="hidden" name="action" value="admin">
        <input type="hidden" name="todo" value="edit">
        <input type="hidden" name="save" value="1">
        <input type="hidden" name="file" value="<?php echo $file; ?>">
        <input type="hidden" name="st" value="<?php echo $st; ?>">
        <div class="container">
          <div class="row">
            <div class="col"><strong><?php echo $text[340]; ?></strong></div>
          </tr>
          <div class="row">
            <div class="col"><?php echo getMessage($text[561],TRUE);?></div>
          </tr>
          <div class="row">
            <div class="col-5 text-end"><acronym title="<?php echo $text[275] ?>"><?php echo $text[274]; ?></acronym></div>
            <div class="col-5 text-start"><input class="custom-control" type="number" style="width: 50px;" name="xanzst" size="3" maxlength="3" value="<?php echo $anzst?>"></div>
          </div>
          <div class="row">
            <div class="col-5 text-end"><acronym title="<?php echo $text[278] ?>"><?php echo $text[277]; ?></acronym></div>
            <div class="col-5 text-start"><input class="custom-control" type="number" style="width: 50px;" name="xanzsp" size="2" maxlength="2" value="<?php echo $anzsp?>"></div>
          </div>
          <div class="row pt-3">
            <div class="col">
              <input title="<?php echo $text[114] ?>" class="btn btn-primary btn-sm" type="submit" name="best" value="<?php echo $text[188]; ?>">
            </div>
          </div>
          <div class="row pt-2">
            <div class="col">
              <a href="<?php echo $addr?>-1"><?php echo $text[544] ?></a>
            </div>
          </div>
        </table>
      </form>
    </div>
  </div>
</div><?php 
}?>