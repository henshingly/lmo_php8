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
      document.getElementById("message").value="<?=$text['tipp'][295]?>";
      document.getElementById("betreff").value="<?=$text['tipp'][296]?>";
    }
    if(x==1){
      document.getElementById("message").value=document.getElementsByName("textreminder1")[0].value;
      document.getElementById("betreff").value="<?=$text['tipp'][167]?>";
    }
    if(x==2){
      document.getElementById("message").value="<?=$text['tipp'][297]?>";
      document.getElementById("betreff").value="<?=$text['tipp'][0]?>";
    }
  }
}
</script>
<?
include(PATH_TO_ADDONDIR."/tipp/lmo-admintippmenu.php");
?>

<table class="lmoMiddle" cellspacing="0" cellpadding="0" border="0">
  <tr>
    <th align="center"><h1><?=$text['tipp'][165] ?></h1></th>
  </tr>
  <tr>
    <td align="left">
      <form name="lmoedit" action="<?=$_SERVER['PHP_SELF']; ?>" method="post">
        <input type="hidden" name="action" value="admin">
        <input type="hidden" name="todo" value="tippemail">
        <input type="hidden" name="save" value="1">
        <input type="hidden" name="textreminder1" value="<? if($tipp_textreminder1==""){$tipp_textreminder1=$text['tipp'][174];}echo $tipp_textreminder1; ?>">
        <table class="lmoInner" cellspacing="0" cellpadding="0" border="0">
          <tr>
            <td width="20">&nbsp;</td>
            <td colspan="3" align="left"><input type="radio" name="emailart" value="0" <? if($emailart==0){echo "checked";} ?> onClick="changetextarea(0)"><?=$text['tipp'][166]; ?></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left"><input type="radio" name="emailart" value="2" <? if($emailart==2){echo "checked";} ?> onClick="changetextarea(2)"><?=$text['tipp'][168]; ?></td>
            <td colspan="2" align="left">
              <select name="adressat" onChange="emailart[1].checked=true;changetextarea(2);">
                <option value=""><?=$text['tipp'][51]?></option><?
                require(PATH_TO_ADDONDIR."/tipp/lmo-tippselectemail.php");?>
              </select>
            </td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td valign="top" align="left">
              <input type="radio" name="emailart" value="1" <? if($emailart==1){echo "checked";} ?> onClick="changetextarea(1)"><?=$text['tipp'][167]; ?>
            </td>
            <td colspan="2">
              <table cellspacing="0" cellpadding="0" border="0"><?
$ftype=".l98";
$iptype="reminder";
require(PATH_TO_ADDONDIR."/tipp/lmo-tippnewdir.php");
if($i>0){?>
                <tr>
                  <td colspan="2" align="left">
                    <input type="radio" name="liganr" value="0" <? if($liganr==0){echo "checked";} ?> onClick="if(emailart[2].checked==false)changetextarea(1);emailart[2].checked=true;"><strong><?=$text['tipp'][263]?></strong>
                  </td>
                </tr><?
} ?>
              </table>
            </td>
          </tr><?
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
          <tr>
            <td colspan="2">&nbsp;</td>
            <td align="left">
              <?=$text['tipp'][164];?> 
              <input class="lmo-formular-input" type="text" name="start" size="2" maxlength="4" value="<?=$start1; ?>">
              <?=$text[4];?>
              <input class="lmo-formular-input" type="text" name="ende" size="2" maxlength="4" value="<?=$ende1; ?>">
              <?=$text['tipp'][170];?>
              <input class="lmo-formular-input" type="text" name="tage" size="2" maxlength="2" value="<?=$tage; ?>" onFocus="emailart[2].checked=true;changetextarea(1);"><?=" ".$text['tipp'][171];?>
            </td>
          </tr>          
          <tr>
            <th colspan="4">&nbsp;</th>
          </tr><?
if ($save == 1) {
  if (isset($betreff)) {
    $betreff1 = $betreff;
  }
}?>
          <tr>
            <td>&nbsp;</td>
            <td colspan="3" align="left">
              <?=$text['tipp'][265];?>
              <input class="lmo-formular-input" type="text" name="betreff" id="betreff" size="20" maxlength="40" value="<?=$betreff1; ?>">
            </td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" colspan="3">
              <textarea id="message" name="message" rows="10" cols="60"><? 
                if ($emailart == 1) {
                  echo $tipp_textreminder1;
                } elseif($message != "") {
                  echo $message;
                } else {
                  echo $text['tipp'][295];
                }?>
              </textarea>
            </td>
          </tr>
          <tr>
            <td colspan="4" align="right"><input class="lmo-formular-button" type="submit" name="best" value="<?=$text['tipp'][169]; ?>"></td>
          </tr>
          <tr>
            <td class="lmoFooter" width="20">&nbsp;</td>
            <td class="lmoFooter" valign="top" align="right"><?=$text['tipp'][178]; ?></td>
            <td class="lmoFooter" colspan="2" align="left"><?=$text['tipp'][179]; ?></td>
            </td>
          </tr>
        </table>
      </form>
    </td>
  </tr>
</table>