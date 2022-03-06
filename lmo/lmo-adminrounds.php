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
<div class="container">
 <div class="row">
   <div class="col"><?php include(PATH_TO_LMO."/lmo-adminsubnavi.php"); ?></div>
  </div>
  <div class="row pt-3">
    <div class="col"><h1><?php echo $titel?></h1></div>
  </div>
  <div clas?="row">
    <div class="col">
      <form name="lmoedit" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" onSubmit="return chklmopass()">
        <input type="hidden" name="action" value="admin">
        <input type="hidden" name="todo" value="edit">
        <input type="hidden" name="save" value="1">
        <input type="hidden" name="file" value="<?php echo $file; ?>">
        <input type="hidden" name="st" value="<?php echo $st; ?>"><?php

  $liga1 = new liga();
  if ($liga1->loadFile(PATH_TO_LMO."/".$dirliga.$file)==false)
  echo $text[224];

  if (isset($_POST)) {
    reset ($_POST);
    $changesFound = False;
    foreach ($_POST as $k=>$v) {
      $array = preg_split('/_/',$k);
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
      <div class="container"><?php
  foreach ($liga->spieltage as $spTag) { ?>
        <div class="row p-3">
          <div class="col-10 text-start">
            <strong><?php echo $spTag->nr.". ".$text[2]."&nbsp;&nbsp;".$spTag->vonBisString()."</strong> / ".$spTag->partienCount()." ".$text[5003] ; ?>
          </div>
          <div class="col-2 test-end">
				<a href="#top"><?php echo $text[5011]; ?></a>&nbsp;/&nbsp;<a href="#bottom"><?php echo $text[5012]; ?></a></div>
        </div><?php
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
        <div class="row">
          <div class="col-2"><?php echo $str1.$partie->datumString()." ".$partie->zeitString().$str2; ?></div>
          <div class="col-3"><?php echo $str1.$partie->heim->name.$str2; ?></div>
          <div class="col-1"> vs. </div>
          <div class="col-3"><?php echo $str1.$partie->gast->name.$str2; ?></div>
          <div class="col-1"><?php echo $str1.$hTore.$str2; ?> : <?php echo $str1.$gTore.$str2; ?></div>
          <div class="col-1">
            <select class="custom-select" onChange="dolmoedit()" name="sp_<?php
      echo $spTag->nr."_".$partie->heim->nr."_".$partie->gast->nr.'" data-width="auto">';
      for ($sp = 1;$sp <= $liga->spieltageCount();$sp++) {
        echo "<option value='$sp'";
        if($spTag->nr==$sp){echo " selected";}
        echo ">".$sp.". ".$text[2]."</option>";
      }?>
            </select>
          </div>
        </div><?php
      $pcount++;
    }
    if ($liga->options->valueForKey("Type") == 0 ) {
      foreach ($liga->teams as $team) {
        if (!in_array($team->nr,$teamArray)) {?>
        <div class="row">
          <div class="col-4"><?php echo $team->name; ?></div>
          <div class="col-2"><?php echo $text[5008]; ?></div>
        </div><?php
        } // if
      }   // foreach ($liga->teams as $team)
    }
    // teamnummern die an einem spieltag antreten. f&#65533;r eine js-Funktion, die verhindert
    // das ein team mehrmals an einem spieltag antreten muss js-funktion muss noch gebaut werden
    //  echo "<input type='hidden' name='sptext_".$spTag->nr."' value='".implode(",",$teamArray)."'>";
  }      // foreach ($spTag->partien as $partie)
?>
        <div class="row p-3">
            <div class="col">
              <acronym title="<?php echo $text[114] ?>"><input class="btn btn-primary btn-sm" type="submit" name="spPlan" value="<?php echo $text[5009]; ?>"></acronym>
            </div>
        </div>
      </form>
      <a name="bottom"></a>
    </div>
  </div>
</div><?php
}?>