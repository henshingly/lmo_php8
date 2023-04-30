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

$save               = isset($_POST['save'])               ? $_POST['save']               : 0;
$message            = isset($_POST['message'])            ? $_POST['message']            : '';
$betreff            = !empty($_POST['betreff'])           ? $_POST['betreff']            : $text['tipp'][0];
$betreff1           = isset($_POST['betreff1'])           ? $_POST['betreff1']           : '';
$tipp_textreminder1 = isset($_POST['tipp_textreminder1']) ? $_POST['tipp_textreminder1'] : 0;
$liganr             = isset($_POST['liganr'])             ? $_POST['liganr']             : -1;
$emailart           = isset($_POST['emailart'])           ? $_POST['emailart']           : -1;
$adressat           = isset($_POST['adressat'])           ? $_POST['adressat']           : '';
$start              = isset($_POST['start'])              ? $_POST['start']              : 0;
$ende               = isset($_POST['ende'])               ? $_POST['ende']               : 0;
$tage               = isset($_POST['tage'])               ? $_POST['tage']               : 4;
$liga1              = isset($_POST['liga1'])              ? $_POST['liga1']              : array();
$st1                = isset($_POST['st1'])                ? $_POST['st1']                : array();

if ($save == 1) {
  if ($emailart == 1) {
    if ($liganr == 0) {
      $st = 0;
      $file='';
      $viewermode = 1;
    } else {
      $st = $st1[$liganr-1];
      $liga = $liga1[$liganr-1];
      $viewermode = 0;
    }
  }
  require(PATH_TO_ADDONDIR."/tipp/lmo-tippemail.php");
}

?>
<script type="text/javascript">
function changetextarea(x){
  if (document.getElementById) {
    if(x==0){
      document.getElementById("message").value="<?php echo $text['tipp'][295]?>";
      document.getElementById("betreff").value="<?php echo $text['tipp'][296]?>";
    }
    if(x==1){
      document.getElementById("message").value="<?php echo $text['tipp'][174]?>"
      document.getElementById("betreff").value="<?php echo $text['tipp'][167]?>";
    }
    if(x==2){
      document.getElementById("message").value="<?php echo $text['tipp'][297]?>";
      document.getElementById("betreff").value="<?php echo $text['tipp'][0]?>";
    }
  }
}
</script>
<?php 
include(PATH_TO_ADDONDIR."/tipp/lmo-admintippmenu.php");
?>

<form name="lmoedit" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
  <input type="hidden" name="action" value="admin">
  <input type="hidden" name="todo" value="tippemail">
  <input type="hidden" name="save" value="1">
  <input type="hidden" name="textreminder1" value="<?php if($tipp_textreminder1==""){$tipp_textreminder1=$text['tipp'][174];}echo $tipp_textreminder1; ?>">
  <div class="container">
    <div class="row p-1">
      <div class="col d-flex justify-content-center"><h1><?php echo $text['tipp'][165] ?></h1></div>
    </div>
    <div class="row p-1">
      <div class="col-3 text-end"><input type="radio" class="form-check-input" name="emailart" value="0" <?php if($emailart==0){echo "checked";} ?> onClick="changetextarea(0)">&nbsp;<?php echo $text['tipp'][166]; ?></div>
    </div>
    <div class="row p-1">
      <div class="col-3 text-end"><input type="radio" class="form-check-input" name="emailart" value="2" <?php if($emailart==2){echo "checked";} ?> onClick="changetextarea(2)">&nbsp;<?php echo $text['tipp'][168]; ?></div>
      <div class="col-3 text-start">
        <select class="form-select" name="adressat" onChange="emailart[1].checked=true;changetextarea(2);">
          <option value=""><?php echo $text['tipp'][51]?></option><?php 
                require(PATH_TO_ADDONDIR."/tipp/lmo-tippselectemail.php");?>
        </select>
       </div>
     </div>
     <div class="row p-1">
       <div class="col-3 text-end"><input type="radio" class="form-check-input" name="emailart" value="1" <?php if($emailart==1){echo "checked";} ?> onClick="changetextarea(1)">&nbsp;<?php echo $text['tipp'][167]; ?></div>
       <div class="col-5 text-start">
         <div class="container"><?php 
$ftype=".l98";
$iptype="reminder";
require(PATH_TO_ADDONDIR."/tipp/lmo-tippnewdir.php");
if($i>0){?>
                <div class="row">
                  <div class="col">
                    <input type="radio" class="form-check-input" name="liganr" value="0" <?php if($liganr==0){echo "checked";} ?> onClick="if(emailart[2].checked==false)changetextarea(1);emailart[2].checked=true;">&nbsp;<strong><?php echo $text['tipp'][263]?></strong>
                  </div>
                </div><?php 
} ?>
              </div>
            </div>
          </div><?php 
$start1=1;
$ende1=count($dumma);
if ($save == 1) {
  if (isset($start)) {
    $start1 = $start;
  }
  if(isset($ende)) {
    $ende1=$ende;
  }
}?>
          <div class="row p-1">
            <div class="col-auto offset-2"><?php echo $text['tipp'][164];?></div>
            <div class="col-auto"><input class="form-control" type="text" name="start" size="2" maxlength="4" value="<?php echo $start1; ?>"></div>
            <div class="col-auto"><?php echo $text[4];?></div>
            <div class="col-auto"><input class="form-control" type="text" name="ende" size="2" maxlength="4" value="<?php echo $ende1; ?>"></div>
            <div class="col-auto"><?php echo $text['tipp'][170];?></div>
            <div class="col-auto"><input class="form-control" type="text" name="tage" size="2" maxlength="2" value="<?php echo $tage; ?>" onFocus="emailart[2].checked=true;changetextarea(1);"></div>
            <div class="col-auto"><?php echo " ".$text['tipp'][171];?></div>
          </div><?php 
if ($save == 1) {
  if (isset($betreff)) {
    $betreff1 = $betreff;
  }
}?>
          <div class="row p-1">
            <div class="col-5 offset-3">
              <input class="form-control" type="text" name="betreff" id="betreff" size="20" maxlength="40" placeholder="<?php echo $text['tipp'][265];?>" value="<?php echo $betreff1; ?>">
            </div>
          </div>
          <div class="row p-1">
            <div class="col-5 offset-3">
              <textarea  class="form-control"id="message" name="message" rows="10" cols="60"><?php                if ($emailart == 1) {
                  echo $tipp_textreminder1;
                } elseif($message != "") {
                  echo $message;
                } else {
                  echo $text['tipp'][295];
                }?>
              </textarea>
            </div>
          </div>
          <div class="row p-1">
            <div class="col"><input class="btn btn-success" type="submit" name="best" value="<?php echo $text['tipp'][169]; ?>"></td>
          </div>
          <div class="row p-1">
            <div class="col-1 offset-4"><?php echo $text['tipp'][178]; ?></div>
            <div class="col-3 text-start"><?php echo $text['tipp'][179]; ?></div>
          </div>
        </div>
      </div>
    </div>
  </form>