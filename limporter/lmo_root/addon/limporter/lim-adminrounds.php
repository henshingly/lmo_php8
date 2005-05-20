<?PHP
//
// Limporter Addon for LigaManager Online
// Copyright (C) 2003 by Tim Schumacher
// timme@uni.de /
//
// LigaManager Online 3.02b
// Copyright (C) 1997-2002 by Frank Hollwitz
// webmaster@hollwitz.de / http://php.hollwitz.de
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

require_once(PATH_TO_ADDONDIR."/limporter/ini.php");

if(($file!="") && ($_SESSION['lmouserok']==2)){
  if(!isset($team)){$team="";}
  if(!isset($save)){$save=0;}
  $addr=$_SERVER['PHP_SELF']."?action=admin&amp;todo=edit&amp;file=".$file."&amp;st=";
  $addb=$_SERVER['PHP_SELF']."?action=admin&amp;todo=tabs&amp;file=".$file."&amp;st=";
  $addz=$_SERVER['PHP_SELF']."?action=admin&amp;todo=edit&amp;file=".$file."&amp;st=-2&amp;team=";
  $meldung = '';
  $rowMarker = array();
   include(PATH_TO_LMO."/lmo-adminsubnavi.php");
?>
<a name="top"></a>
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
        <input type="hidden" name="st" value="<? echo $st; ?>">
<?PHP

  $liga1 = new liga();
  if ($liga1->loadFile(PATH_TO_LMO."/".$dirliga.$file)==false)
    echo $text['limporter'][99];

   if (isset($HTTP_POST_VARS)) {
   reset ($HTTP_POST_VARS);
   $changesFound = False;
   foreach ($HTTP_POST_VARS as $k=>$v) {
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
          $meldung = $text['limporter'][100]." ".$aPartie->heim->name." - ".$aPartie->gast->name." ".$text['limporter'][101]." $alteSpielTagNr. ".$text['limporter'][102]." $neueSpielTagNr. ".$text['limporter'][103].".<BR>";
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
?>
        <?php echo "<font color=\"#008800\">".$meldung."</font>"; ?>
        <table border= '0' cellspacing='0' align='center' class="lmoInner">
        <?php foreach ($liga->spieltage as $spTag) { ?>
        <tr>
          <th width=15 class="nobr">&nbsp;</th>
          <th colspan=6 class="nobr" align='left'>
            <strong><?=$spTag->nr.". ".$text['limporter'][65]."&nbsp;&nbsp;".$spTag->vonBisString()."</strong> / ".$spTag->partienCount()." ".$text['limporter'][104] ; ?>
          </th>
          <th colspan=3 class="nobr" align='right'><a href="#top">up</a>&nbsp;/&nbsp;<a href="#bottom">down</a></th>
        </tr>

<?PHP
    $pcount = 1;
    $teamArray = array();
    foreach ($spTag->partien as $partie) {
      $hTore = $partie->hTore;
      $gTore = $partie->gTore;
      if($hTore == -1 and $gTore == -1) {
        $hTore = "__";
        $gTore = "__";
      }
      else if ($hTore < -1 or $gTore < -1) {
        $hTore = 0;
        $gTore = 0;
      }
      $teamArray[] = $partie->heim->nr;
      $teamArray[] = $partie->gast->nr;

      $str1 = "";
      $str2 = "";
      if (in_array($partie->heim->nr.'-'.$partie->gast->nr,$rowMarker)) {$str1 = "<STRONG>";$str2 = "</STRONG>";}

?>
        <tr>
          <td class="lmost5">&nbsp;</td>
          <td class="lmost5"><?=$str1.$partie->datumString()." ".$partie->zeitString().$str2; ?></td>
          <td class="lmost5"><?=$str1.$partie->heim->name.$str2; ?></td>
          <td class="lmost5">-</td>
          <td class="lmost5"><?=$str1.$partie->gast->name.$str2; ?></td>
          <td class="lmost5" align='right' ><?=$str1.$hTore.$str2; ?></td>
          <td class="lmost5">:</td>
          <td class="lmost5" align='center'><?=$str1.$gTore.$str2; ?></td>
          <td class="lmost5"></td>
          <td class="lmost5">
<?PHP
      echo "<select class=\"lmo-formular-input\" onChange=\"dolmoedit()\" name=\"sp_";
      echo $spTag->nr."_".$partie->heim->nr."_".$partie->gast->nr."\">\n";
      for ($sp = 1;$sp <= $liga->spieltageCount();$sp++) {
        echo "<option value=$sp";
        if($spTag->nr==$sp){echo " selected";}
        echo ">".$sp.". ".$text['limporter'][65]."</option>";
      }
      echo "</select>"
?>
          </td>
        </tr>
<?PHP
      $pcount++;
    }
    if ($liga->options->valueForKey("Type") == 0 ) {
    foreach ($liga->teams as $team) {
      if (!in_array($team->nr,$teamArray)) {
?>
        <tr>
          <td class="lmost5">&nbsp</td>
          <td class="lmost5">&nbsp;</td>
          <td class="lmost5">&nbsp;</td>
          <td class="lmost5">&nbsp;</td>
          <td class="lmost5"><?=$team->name; ?></td>
          <td class="lmost5" align='right' colspan=3><?PHP echo $text['limporter'][105]; ?></td>
        </tr>
<?php
      } // if
    }   // foreach ($liga->teams as $team)
    }
  // teamnummern die an einem spieltag antreten. für eine js-Funktion, die verhindert
  // das ein team mehrmals an einem spieltag antreten muss js-funktion muss noch gebaut werden
  echo "<input type='hidden' name='sptext_".$spTag->nr."' value='".implode(",",$teamArray)."'>";
  }      // foreach ($spTag->partien as $partie)

?>
  <tr>
    <td class="lmost5" colspan="10" align="center"><?PHP echo VERSlON ; ?></td>
  </tr>


        <tr>
            <th colspan=10 align="middle"><a name="bottom">&nbsp;</a>
              <acronym title="<? echo $text[114] ?>"><input class="lmo-formular-button" type="submit" name="spPlan" value="<? echo $text['limporter'][106]; ?>"></acronym>
            </th>
          </tr>
        </table>
        </td>
        </tr>
        </table>
      </form>
    </td>
  </tr>

<?}?>