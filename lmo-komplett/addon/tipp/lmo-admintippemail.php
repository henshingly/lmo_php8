<?
// 
// LigaManager Online 3.02
// Copyright (C) 1997-2002 by Frank Hollwitz
// webmaster@hollwitz.de / http://php.hollwitz.de
// 
// Tippspiel-AddOn 1.20
// Copyright (C) 2002 by Frank Albrecht
// fkalbrecht@web.de
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
require_once(PATH_TO_LMO."/lmo-admintest.php");
if (!isset($emailart)) {
  $emailart = -1;
}
if (!isset($save)) {
  $save = 0;
}
if (!isset($message)) {
  $message = "";
}
if (!isset($betreff) || $betreff == "") {
  $betreff = $text['tipp'][0];
}
if (!isset($betreff1)) {
  $betreff1 = "";
}
if (!isset($tipp_textreminder1)) {
  $tipp_textreminder1 = "";
}
if (!isset($liganr)) {
  $liganr = -1;
}
 
if ($save == 1) {
  if ($emailart == 1) {
    if ($liganr == 0) {
      $st = 0;
      $liga = "viewer";
    } else {
      $st = $st1[$liganr-1];
      $liga = $liga1[$liganr-1];
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

<table class="lmosta" cellspacing="0" cellpadding="0" border="0">
  <tr>
    <td class="lmost1" align="center"><?=$text['tipp'][165] ?></td>
  </tr>
  <tr>
    <td align="center" class="lmost3">
      <form name="lmoedit" action="<?=$_SERVER['PHP_SELF']; ?>" method="post">
        <input type="hidden" name="action" value="admin">
        <input type="hidden" name="todo" value="tippemail">
        <input type="hidden" name="save" value="1">
        <input type="hidden" name="textreminder1" value="<? if($tipp_textreminder1==""){$tipp_textreminder1=$text['tipp'][174];}echo $tipp_textreminder1; ?>">
        <table class="lmostb" cellspacing="0" cellpadding="0" border="0">
  
          <tr>
            <td class="lmost5" width="20">&nbsp;</td>
            <td class="lmost5" colspan="3"><input type="radio" name="emailart" value="0" <? if($emailart==0){echo "checked";} ?> onClick="changetextarea(0)"><?=$text['tipp'][166]; ?></td>
          </tr>
          <tr>
            <td class="lmost5" width="20">&nbsp;</td>
            <td class="lmost5"><input type="radio" name="emailart" value="2" <? if($emailart==2){echo "checked";} ?> onClick="changetextarea(2)"><?=$text['tipp'][168]; ?></td>
            <td class="lmost5" colspan="2">
              <select name="adressat" onChange="emailart[1].checked=true;changetextarea(2);">
                <option value=""><?=$text['tipp'][51]?></option><?
                require(PATH_TO_ADDONDIR."/tipp/lmo-tippselectemail.php");?>
              </select>
            </td>
          </tr>
          <tr>
            <td class="lmost5" width="20">&nbsp;</td>
            <td class="lmost5" valign="top">
              <input type="radio" name="emailart" value="1" <? if($emailart==1){echo "checked";} ?> onClick="changetextarea(1)"><?=$text['tipp'][167]; ?>
            </td>
            <td class="lmost5" colspan="2">
              <table cellspacing="0" cellpadding="0" border="0"><?
$ftype=".l98";
$iptype="reminder";
require(PATH_TO_ADDONDIR."/tipp/lmo-tippnewdir.php");
if($i>0){?>
                <tr>
                  <td class="lmost5" colspan="2">
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
            <td class="lmost5" width="20">&nbsp;</td>
            <td class="lmost5" colspan="2">
              <?=$text['tipp'][164];?> 
              <input class="lmoadminein" type="text" name="start" size="2" maxlength="4" value="<?=$start1; ?>">
              <?=$text[4];?>
              <input class="lmoadminein" type="text" name="ende" size="2" maxlength="4" value="<?=$ende1; ?>">
              <?=$text['tipp'][170]; if(!isset($tage)){$tage=4;}?>
              <input class="lmoadminein" type="text" name="tage" size="2" maxlength="2" value="<?=$tage; ?>" onFocus="emailart[2].checked=true;changetextarea(1);"><?=" ".$text['tipp'][171];?>
            </td>
          </tr>          
          <tr>
            <td class="lmost5" colspan="4"><hr></td>
          </tr><?
if ($save == 1) {
  if (isset($betreff)) {
    $betreff1 = $betreff;
  }
}?>
          <tr>
            <td class="lmost5" width="20">&nbsp;</td>
            <td class="lmost5" colspan="3">
              <?=$text['tipp'][265];?>
              <input class="lmoadminein" type="text" name="betreff" id="betreff" size="20" maxlength="40" value="<?=$betreff1; ?>">
            </td>
          </tr>
          <tr>
            <td class="lmost5" width="20">&nbsp;</td>
            <td class="lmost5" colspan="3">
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
            <td class="lmost5" colspan="4" align="right"><input class="lmoadminbut" type="submit" name="best" value="<?=$text['tipp'][169]; ?>"></td>
          </tr>
          <tr>
            <td class="lmost4" width="20">&nbsp;</td>
            <td class="lmost4" colspan="1" valign="top" align="right"><?=$text['tipp'][178]; ?></td>
            <td class="lmost4" colspan="2"><?=$text['tipp'][179]; ?></td>
            </td>
          </tr>
        </table>
      </form>
    </td>
  <tr>
    <td>
      <table width="100%" cellspacing="0" cellpadding="0" border="0">
        <tr>
          <td class="lmost2" align="center"><a href='<?=$_SERVER['PHP_SELF']."?action=admin&amp;todo=tippemail"?>' onClick="return chklmolink(this.href);" title="<?=$text['tipp'][63]?>"><?=$text['tipp'][63]?></a></td><?
if($_SESSION['lmouserok']==2){?>
          <td class="lmost1" align="center"><?=$text['tipp'][165]?></td>
          <td class="lmost2" align="center"><a href='<?=$_SERVER['PHP_SELF']."?action=admin&amp;todo=tippuser"?>' onClick="return chklmolink(this.href);" title="<?=$text['tipp'][114]?>"><?=$text['tipp'][114]?></a></td>
          <td class="lmost2" align="center"><a href='<?=$_SERVER['PHP_SELF']."?action=admin&amp;todo=tippoptions"?>' onClick="return chklmolink(this.href);" title="<?=$text['tipp'][55]?>"><?=$text[86]?></a></td><?
}?>
        </tr>
      </table>
    </td>
  </tr>
</table>