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
  
  
require_once(PATH_TO_ADDONDIR."/tipp/lmo-tipptest.php");
if(($action=="tipp") && ($todo=="")){
  $adda=$_SERVER['PHP_SELF']."?action=tipp&amp;todo=";
  $addw=$_SERVER['PHP_SELF']."?action=tipp&amp;todo=wert&amp;file=";
?>

<table class="lmoInner" cellspacing="0" cellpadding="0" border="0">
  <caption><?=$_SESSION['lmotippername'];?><?if($_SESSION['lmotipperverein']!=""){echo " - ".$_SESSION['lmotipperverein'];} ?><br><?=$text['tipp'][237]; ?></caption>
  <tr>
    <th align="left"><?=$text['tipp'][3]; ?>:</th>
  </tr>
  <tr>
    <td align="left"><? $ftype=".tip"; require(PATH_TO_ADDONDIR."/tipp/lmo-tippdir.php"); ?></td>
  </tr>
  <tr>
    <th align="left"><?=$text['tipp'][4]; ?></th>
  </tr>
  <tr>
    <td class="nobr" align="left">
      <ul><?
  $dummy =  explode('|',$tt1);
  $ftest2 = explode('|',$tt0);
  if(isset($dummy) && isset($ftest2)){
    for($u=0;$u<count($dummy);$u++){
      if($dummy[$u]!="" && $ftest2[$u]!=""){
        $dummy[$u]=substr($dummy[$u],0,-4);
        $auswertfile=PATH_TO_ADDONDIR."/tipp/".$tipp_dirtipp."auswert/".$dummy[$u].".aus";
        if ($tipp_nurgesamt==0) {?>
        <li>
          <a href="<?=$addw.$dummy[$u].".l98"; ?>"><?=$ftest2[$u];?></a><?if(file_exists($auswertfile)){echo "<br><small>".$text['tipp'][83].": ".date("d.m.Y H:i",filemtime($auswertfile))."</small>";}?>
        </li><?
        }
      }
    }
  }
  if($tipp_gesamt==1 && ($u>2 || $tipp_nurgesamt==1 && $u==2)){
    $auswertfile=PATH_TO_ADDONDIR."/tipp/".$tipp_dirtipp."auswert/gesamt.aus";?>
        <li>
          <a href="<?=$addw."&amp;all=1"; ?>"><strong><?=$text['tipp'][25];?></strong></a><?if(file_exists($auswertfile)){echo "<br><small>".$text['tipp'][83].": ".date("d.m.Y H:i",filemtime($auswertfile))."</small>";} ?>
        </li><?
  }
  $auswertfile="";?>
      </ul>
    </td>
  </tr>
  <tr>
    <th align="left"><?=$text['tipp'][145]; ?>:</th>
  </tr>
  <tr>
    <td class="nobr" align="left">
      <ul>
        <li class="lmoadminli"><?="<a href='".$adda."newligen'>".$text['tipp'][5]."</a>"; ?></li>
        <li class="lmoadminli"><?="<a href='".$adda."delligen'>".$text['tipp'][266]."</a>"; ?></li>
        <li class="lmoadminli"><?="<a href='".$adda."daten'>".$text['tipp'][106];if($tipp_tipperimteam>=0){echo " / ".$text['tipp'][2];}echo "</a>"; ?></li>
        <li class="lmoadminli"><?="<a href='".$adda."pwchange'>".$text['tipp'][107]."</a>"; ?></li>
        <li class="lmoadminli"><?="<a href='".$adda."delaccount'>".$text['tipp'][6]."</a>"; ?></li>
        <li class="lmoadminli"><?="<a href='".$adda."logout'>".$text['tipp'][7]."</a>"; ?></li>
      </ul>
    </td>
  </tr>
</table><?
}?>