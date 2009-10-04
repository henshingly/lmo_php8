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
  * $Id$
  */

if(($file!="") && ($_SESSION['lmouserok']==2)){
  if(!isset($team)){$team="";}
  if(!isset($save)){$save=0;}
  $addr=$_SERVER['PHP_SELF']."?action=admin&amp;todo=edit&amp;file=".$file."&amp;st=";
  $addb=$_SERVER['PHP_SELF']."?action=admin&amp;todo=tabs&amp;file=".$file."&amp;st=";
  $addz=$_SERVER['PHP_SELF']."?action=admin&amp;todo=edit&amp;file=".$file."&amp;st=-2&amp;team=";
  $meldung = '';
  $rowMarker = array();
?>
<a name="top"></a>
<table class="lmoSubmenu" width="100%" cellpadding="0" cellspacing="0">
 <tr>
   <td align="left"><? include(PATH_TO_LMO."/lmo-adminsubnavi.php"); ?></td>
  </tr>
</table>
<table class="lmoMiddle" cellspacing="0" cellpadding="0" border="0">
  <tr>
    <td align="center"><h1><?=$titel?></h1></td>
  </tr>
  <tr>
    <td align="center">
      <form name="lmoedit" action="<? echo $_SERVER['PHP_SELF']; ?>" method="post" onSubmit="return chklmopass()">
        <input type="hidden" name="action" value="admin">
        <input type="hidden" name="todo" value="edit">
        <input type="hidden" name="save" value="1">
        <input type="hidden" name="file" value="<? echo $file; ?>">
        <input type="hidden" name="st" value="<? echo $st; ?>"><?php

  $liga1 = new liga();
  if ($liga1->loadFile(PATH_TO_LMO."/".$dirliga.$file)==false)
  echo $text[224];

  if (isset($_POST)) {
    reset ($_POST);
    $changesFound = False;
    foreach ($_POST as $k=>$v) {
      $array = split('_',$k);
      if (isset($array) and count($array)==4 and ($array[0] == 'sp') and ($array[1] != $v)) {
        $alteSpielTagNr = $array[1];
        $neueSpielTagNr = $v;
        $heimNr = $array[2];
        $gastNr = $array[3];
        $aSpielTag =$liga1->spieltagForNumber($alteSpielTagNr);
        $newSpielTag =$liga1->spieltagForNumber($neueSpielTagNr);

        $heim = $liga1->teamForNumber($heimNr);
        $gast = $liga1->teamForNumber($gastNr);

        $aPartie = $liga1->partieForTeams($heim,$gast);
        if($aSpielTag->removePartie($aPartie)) {
          $changesFound = True;
          $newSpielTag->addPartie($aPartie);
          $liga1->spieltage[$neueSpielTagNr-1] = $newSpielTag;
          $liga1->spieltage=array_values($liga1->spieltage); // Index neu erstellen
          $liga1->spieltage[$alteSpielTagNr-1] = $aSpielTag;
          $liga1->spieltage=array_values($liga1->spieltage); // Index neu erstellen
          $meldung = $text[5007]." ".$aPartie->heim->name." - ".$aPartie->gast->name." ".$text[5004]." ".$alteSpielTagNr.". ".$text[5005]." $neueSpielTagNr.".$text[5010]." ".$text[5006].".<BR>";
          $rowMarker[] = $heimNr.'-'.$gastNr;
        }
      }
    } // foreach

    if ($changesFound == True) {
      $liga1->writeFile(PATH_TO_LMO."/".$dirliga.$file,0,0);
    }
  }
  $liga = new liga();
  $liga->loadFile(PATH_TO_LMO."/".$dirliga.$file);
  echo getMessage($meldung); ?>
      <table class="lmoInner" cellspacing="0" cellpadding="0" border="0"><?php
  foreach ($liga->spieltage as $spTag) { ?>
        <tr>
          <th width="15" class="nobr">&nbsp;</th>
          <th colspan="6" class="nobr" align="left">
            <strong><?=$spTag->nr.". ".$text[2]."&nbsp;&nbsp;".$spTag->vonBisString()."</strong> / ".$spTag->partienCount()." ".$text[5003] ; ?>
          </th>
          <th colspan="3" class="nobr" align="right">
				<a href="#top"><?php echo $text[5011]; ?></a>&nbsp;/&nbsp;<a href="#bottom"><?php echo $text[5012]; ?></a></th>
        </tr><?php
    $pcount = 1;
    $teamArray = array();
    foreach ($spTag->partien as $partie) {
      $hTore = $partie->hTore;
      $gTore = $partie->gTore;
      if($hTore == -1 and $gTore == -1) {
        $hTore = "__";
        $gTore = "__";
      } elseif ($hTore < -1 or $gTore < -1) {
        $hTore = 0;
        $gTore = 0;
      }
      $teamArray[] = $partie->heim->nr;
      $teamArray[] = $partie->gast->nr;

      $str1 = "";
      $str2 = "";
      if (in_array($partie->heim->nr.'-'.$partie->gast->nr,$rowMarker)) {
        $str1 = "<strong>";$str2 = "</strong>";
      }?>
        <tr>
          <td>&nbsp;</td>
          <td><?=$str1.$partie->datumString()." ".$partie->zeitString().$str2; ?></td>
          <td><?=$str1.$partie->heim->name.$str2; ?></td>
          <td>-</td>
          <td><?=$str1.$partie->gast->name.$str2; ?></td>
          <td align='right' ><?=$str1.$hTore.$str2; ?></td>
          <td>:</td>
          <td align='center'><?=$str1.$gTore.$str2; ?></td>
          <td></td>
          <td>
            <select class="lmo-formular-input" onChange="dolmoedit()" name="sp_<?php
      echo $spTag->nr."_".$partie->heim->nr."_".$partie->gast->nr.'">';
      for ($sp = 1;$sp <= $liga->spieltageCount();$sp++) {
        echo "<option value=$sp";
        if($spTag->nr==$sp){echo " selected";}
        echo ">".$sp.". ".$text[2]."</option>";
      }?>
            </select>
          </td>
        </tr><?php
      $pcount++;
    }
    if ($liga->options->valueForKey("Type") == 0 ) {
      foreach ($liga->teams as $team) {
        if (!in_array($team->nr,$teamArray)) {?>
        <tr>
          <td>&nbsp</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td><?=$team->name; ?></td>
          <td align='right' colspan=3><?php echo $text[5008]; ?></td>
        </tr><?php
        } // if
      }   // foreach ($liga->teams as $team)
    }
    // teamnummern die an einem spieltag antreten. für eine js-Funktion, die verhindert
    // das ein team mehrmals an einem spieltag antreten muss js-funktion muss noch gebaut werden
    //  echo "<input type='hidden' name='sptext_".$spTag->nr."' value='".implode(",",$teamArray)."'>";
  }      // foreach ($spTag->partien as $partie)
?>
        <tr>
            <th class="nobr" colspan="10">
              <acronym title="<? echo $text[114] ?>"><input class="lmo-formular-button" type="submit" name="spPlan" value="<? echo $text[5009]; ?>"></acronym>
            </th>
        </tr>
        </table>
      </form>
      <a name="bottom"></a>
    </td>
  </tr>
</table><?
}?>