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
require_once(PATH_TO_ADDONDIR."/tipp/lmo-tipptest.php");
if(($action=="tipp") && ($todo=="")){
  $adda=$_SERVER['PHP_SELF']."?action=tipp&amp;todo=";
  $addw=$_SERVER['PHP_SELF']."?action=tipp&amp;todo=wert&amp;file=";
?>
<table class="lmosta" width="100%" cellspacing="0" cellpadding="0" border="0">
  <tr>
    <td align="center" class="lmost1">
        <?=$lmotippername;?><?if($lmotipperverein!=""){echo " - ".$lmotipperverein;} ?><br>
        <?=$text['tipp'][237]; ?>
    </td>
  </tr>
  <tr>
    <td align="center" class="lmost3">
      <table class="lmostb" cellspacing="0" cellpadding="0" border="0">
        <tr><td class="lmost4"><?=$text['tipp'][3]; ?>:</td></tr>
        <tr><td class="lmost5"><? $ftype=".tip"; require(PATH_TO_ADDONDIR."/tipp/lmo-tippdir.php"); ?></td></tr>
        <tr><td class="lmost4"><nobr><?=$text['tipp'][4]; ?></nobr></td></tr>
        <tr><td class="lmost5">
          <nobr>
            <ul><?
  $dummy =  split("[|]",$tt1);
  $ftest2 = split("[|]",$tt0);
  if(isset($dummy) && isset($ftest2)){
    for($u=0;$u<count($dummy);$u++){
      if($dummy[$u]!="" && $ftest2[$u]!=""){
        $dummy[$u]=substr($dummy[$u],0,-4);
        $auswertfile=PATH_TO_ADDONDIR."/tipp/".$tipp_dirtipp."auswert/".$dummy[$u].".aus";?>
              <li class="lmoadminli">
                <a href="<?=$addw.$dirliga.$dummy[$u].".l98"; ?>"><?=$ftest2[$u];if(file_exists($auswertfile)){echo "<br><small>".$text['tipp'][83].": ".date("d.m.Y H:i",filemtime($auswertfile))."</small>";}echo "</a>"; ?>
              </li><?
      }
    }
  }
  if($tipp_gesamt==1 && $u>2){
    $auswertfile=PATH_TO_ADDONDIR."/tipp/".$tipp_dirtipp."auswert/gesamt.aus";?>
              <li class="lmoadminli">
                <a href="<?=$addw."&amp;all=1"; ?>"><strong><?=$text['tipp'][25];if(file_exists($auswertfile)){echo "<br><small>".$text['tipp'][83].": ".date("d.m.Y H:i",filemtime($auswertfile))."</small>";} ?> <strong></a>
              </li><?
  }
  $auswertfile="";?>
            </ul>
          </td>
        </tr>
        <tr><td class="lmost4"><nobr><?=$text['tipp'][145]; ?>:</nobr></td></tr>
        <tr>
          <td class="lmost5">
            <nobr>
              <ul>
                <li class="lmoadminli"><?="<a href='".$adda."newligen'>".$text['tipp'][5]."</a>"; ?></li>
                <li class="lmoadminli"><?="<a href='".$adda."delligen'>".$text['tipp'][266]."</a>"; ?></li>
                <li class="lmoadminli"><?="<a href='".$adda."daten'>".$text['tipp'][106];if($tipp_tipperimteam>=0){echo " / ".$text['tipp'][2];}echo "</a>"; ?></li>
                <li class="lmoadminli"><?="<a href='".$adda."pwchange'>".$text['tipp'][107]."</a>"; ?></li>
                <li class="lmoadminli"><?="<a href='".$adda."delaccount'>".$text['tipp'][6]."</a>"; ?></li>
                <li class="lmoadminli"><?="<a href='".$adda."logout'>".$text['tipp'][7]."</a>"; ?></li>
              </ul>
            </nobr>
          </td>
        </tr>
      </table>
    </td>
  </tr>
</table><?
}?>