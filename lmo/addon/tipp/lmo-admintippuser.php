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
  
  
$tipper_sort=	isset($_REQUEST['tipper_sort'])	? $_REQUEST['tipper_sort'] : '';
$del=	        isset($_REQUEST['del'])	        ? $_REQUEST['del']         : '';

require_once(PATH_TO_LMO."/lmo-admintest.php");
if ($_SESSION["lmouserok"] == 2) {

  $pswfile = PATH_TO_ADDONDIR."/tipp/".$tipp_tippauthtxt;
  
  $users = file($pswfile);
  array_unshift($users,'');

  if($del != "") {
    $gef = 0;
    for($i = 1; $i < count($users) && $gef == 0; $i++) {
      $dummb = explode('|', $users[$i]);
      if ($del == $dummb[0]) {
        // Nick gefunden
        $gef = 1;
        $del = $i;
      }
    }
    if ($gef == 1) {
      $userf3 = explode('|', $users[$del]);
      $verz = opendir(substr(PATH_TO_ADDONDIR."/tipp/".$tipp_dirtipp, 0, -1));
      $dummy = array();
      while ($files = readdir($verz)) {
        if (substr($files, -4-strlen($userf3[0])) == $userf3[0].".tip") {
          array_push($dummy, $files);
        }
      }
      closedir($verz);
      $anztippfiles = count($dummy);
      for($k = 0; $k < $anztippfiles; $k++) {
        @unlink(PATH_TO_ADDONDIR."/tipp/".$tipp_dirtipp.$dummy[$k]); // Tipps löschen
      }
       
      for($i = $del+1; $i < count($users); $i++) {
        $users[$i-1] = $users[$i];
      }
      array_pop($users); // die letzte Zeile abgeschnitten
      require(PATH_TO_ADDONDIR."/tipp/lmo-tippsaveauth.php");
    }
  }
  include(PATH_TO_ADDONDIR."/tipp/lmo-admintippmenu.php");
  ?>
  
<table class="lmoMiddle" cellspacing="0" cellpadding="0" border="0">
  <tr>
    <td align="center"><h1><?=$text['tipp'][114] ?></h1></td>
  </tr>
  <tr>
    <td align="center">
      <script type="text/javascript" src="<?=URL_TO_LMO?>/js/sortable/sortabletable.js"></script>
      <script type="text/javascript" src="<?=URL_TO_LMO?>/js/sortable/limSortFunctions.js"></script>
      <table id="tipper" class="lmoInner" cellspacing="0" cellpadding="0" border="0">
	<?
  if (count($users) > 1) {
    $tipper_sort_direction=isset($_GET['tipper_sort_direction'])?$_GET['tipper_sort_direction']:"asc";
    if (!isset($_GET['tipper_sort'])) {
      $tipper_sort = "id";
    }
     
    $adds = $_SERVER['PHP_SELF']."?action=admin&amp;todo=tippuser&amp;tipper_sort=";
    $added = $_SERVER['PHP_SELF']."?action=admin&amp;todo=tippuseredit&amp;nick=";
    $addd = $_SERVER['PHP_SELF']."?action=admin&amp;todo=tippuser&amp;tipper_sort=".$tipper_sort."&amp;del=";?>
      <thead>  
        <tr>
          <th class="nobr" align="right"></th>
          <th class="nobr" align="right">
            <script type="text/javascript">document.write('#');</script>
            <noscript>
              <a href="<?=$adds?>id&amp;tipper_sort_direction=asc" title="<?=$text[527].' '.$text[526]?>" onClick="return chklmolink();"><img src="<?=URL_TO_IMGDIR?>/upsimple.png" width="7" height="7" border="0" alt="&and;"></a>
              #
              <a href="<?=$adds?>id&amp;tipper_sort_direction=desc" title="<?=$text[528].' '.$text[526]?>" onClick="return chklmolink();"><img src="<?=URL_TO_IMGDIR?>/downsimple.png" width="7" height="7" border="0" alt="&or;"></a>
            </noscript>
          </th>
          <th align="left" class="nobr">
            <script type="text/javascript">document.write('<?=$text['tipp'][23]?>');</script>
            <noscript>
              <a href="<?=$adds?>nick&amp;tipper_sort_direction=asc" title="<?=$text[527].' '.$text[526]?>" onClick="return chklmolink();"><img src="<?=URL_TO_IMGDIR?>/upsimple.png" width="7" height="7" border="0" alt="&and;"></a>
              <?=$text['tipp'][23]?>
              <a href="<?=$adds?>nick&amp;tipper_sort_direction=desc" title="<?=$text[528].' '.$text[526]?>" onClick="return chklmolink();"><img src="<?=URL_TO_IMGDIR?>/downsimple.png" width="7" height="7" border="0" alt="&or;"></a>
            </noscript>
          </th>
          <th align="left" class="nobr">
            <script type="text/javascript">document.write('<?=$text['tipp'][134]?>');</script>
            <noscript>
              <a href="<?=$adds?>name&amp;tipper_sort_direction=asc" title="<?=$text[527].' '.$text[526]?>" onClick="return chklmolink();"><img src="<?=URL_TO_IMGDIR?>/upsimple.png" width="7" height="7" border="0" alt="&and;"></a>
              <?=$text['tipp'][134]?>
              <a href="<?=$adds;?>name&amp;tipper_sort_direction=desc" title="<?=$text[528].' '.$text[526]?>" onClick="return chklmolink();"><img src="<?=URL_TO_IMGDIR?>/downsimple.png" width="7" height="7" border="0" alt="&or;"></a>
            </noscript>
          </th>
          <th align="left" class="nobr">
            <script type="text/javascript">document.write('<?=$text['tipp'][27]?>');</script>
            <noscript>
              <a href="<?=$adds?>team&amp;tipper_sort_direction=asc" title="<?=$text[527].' '.$text[526]?>" onClick="return chklmolink();"><img src="<?=URL_TO_IMGDIR?>/upsimple.png" width="7" height="7" border="0" alt="&and;"></a>
              <?=$text['tipp'][27]?>
              <a href="<?=$adds;?>team&amp;tipper_sort_direction=desc" title="<?=$text[528].' '.$text[526]?>" onClick="return chklmolink();"><img src="<?=URL_TO_IMGDIR?>/downsimple.png" width="7" height="7" border="0" alt="&or;"></a>
            </noscript>
          </th>
          <th align="left" class="nobr">
            <script type="text/javascript">document.write('<?=$text['tipp'][270]?>');</script>
            <noscript>
              <a href="<?=$adds?>ltipp&amp;tipper_sort_direction=asc" title="<?=$text[527].' '.$text[526]?>" onClick="return chklmolink();"><img src="<?=URL_TO_IMGDIR?>/upsimple.png" width="7" height="7" border="0" alt="&and;"></a>
              <?=$text['tipp'][270]?>
              <a href="<?=$adds;?>ltipp&amp;tipper_sort_direction=desc" title="<?=$text[528].' '.$text[526]?>" onClick="return chklmolink();"><img src="<?=URL_TO_IMGDIR?>/downsimple.png" width="7" height="7" border="0" alt="&or;"></a>
            </noscript>
          </th>
          <th>&nbsp;</th>
          <th>&nbsp;</th>
        </tr>
      </thead><?
    $tab0 = array();
    $anztipper = count($users);
    $id = array_pad($array, $anztipper, "");
    $nick = array_pad($array, $anztipper, "");
    $pass = array_pad($array, $anztipper, "");
    $name = array_pad($array, $anztipper, "");
    $email = array_pad($array, $anztipper, "");
    $team = array_pad($array, $anztipper, "");
    $ltipp = array_pad($array, $anztipper, "");
    $freig = array_pad($array, $anztipper, "");
    for($i = 1; $i < $anztipper; $i++) {
      $userd = explode('|', $users[$i]);
      $id[$i] = $i;
      $nick[$i] = $userd[0];
      $pass[$i] = $userd[1];
      $name[$i] = substr($userd[3], strpos($userd[3], " ")+1)." ".substr($userd[3], 0, strpos($userd[3], " "));
      $email[$i] = $userd[4];
      $team[$i] = $userd[5];
      $ltipp[$i] = 0;
      $freig[$i] = $userd[2];
      $verz = opendir(substr(PATH_TO_ADDONDIR."/tipp/".$tipp_dirtipp, 0, -1));
      if ($verz) {
        while ($files = readdir($verz)) {
          if (substr($files, -5-strlen($userd[0])) == "_".$userd[0].".tip") {
            if (filemtime(PATH_TO_ADDONDIR."/tipp/".$tipp_dirtipp.$files) > $ltipp[$i]) {
              $ltipp[$i] = filemtime(PATH_TO_ADDONDIR."/tipp/".$tipp_dirtipp.$files);
            }
          }
        }
        $tab0[$i]['id']=$id[$i];
        $tab0[$i]['nick']=$nick[$i];
        $tab0[$i]['name']=$name[$i];
        $tab0[$i]['email']=$email[$i];
        $tab0[$i]['team']=$team[$i];
        $tab0[$i]['ltipp']=$ltipp[$i];
        $tab0[$i]['freig']=$freig[$i];
        closedir($verz);
      }
    }

    
    usort($tab0, 'cmp');
    if($tipper_sort_direction=='desc') $tab0=array_reverse($tab0);?> 
        <tbody><?
    for($x = 0; $x < $anztipper-1; $x++) {?>
        <tr>
          <td align="left"><?
      if ($tab0[$x]['freig']!="5"){?>
            <img src="<?=URL_TO_IMGDIR?>/wrong.gif" border="0" width="12" height="12" alt="+"><?
      } else {?>
            <img src="<?=URL_TO_IMGDIR?>/right.gif" border="0" width="12" height="12" alt="-"><?
      }?> </td>
          <td align="right"><?=$tab0[$x]['id']; ?></td>
          <td align="left"><?
      if ($tab0[$x]['email']!=""){?>
            <a href="mailto:<?=$tab0[$x]['email']; ?>"><?=$tab0[$x]['nick']; ?></a><?
      } else {
        echo $tab0[$x]['nick'];
      }?> </td>
          <td align="left"><?=$tab0[$x]['name']; ?></td>
          <td align="left"><?=$tab0[$x]['team']; ?></td>
          <td align="left"><? if($tab0[$x]['ltipp']>0){echo date("d.m.Y H:i",$tab0[$x]['ltipp']);} ?></td>    
          <td align="left"><a href='<?=$added.$tab0[$x]['nick']?>' onClick="return chklmolink();"><?=$text['tipp'][98]?></a></td>
          <td align="left"><a href='<?=$addd.$tab0[$x]['nick']?>' onClick="return confirm('<?=$text[499]?>');"><img src="<?=URL_TO_IMGDIR?>/delete.gif" border="0" width="11" height="13" alt="<?=$text[82]?>"></a></td><?
    }?>
        </tr><?
  } ?>
        </tbody>
      </table>
      <script type="text/javascript">
          var tipperTable = new SortableTable(document.getElementById("tipper"),["None","Number","CaseInsensitiveString","CaseInsensitiveString","CaseInsensitiveString", "GermanDateTime","None","None"]);
          tipperTable.sort(1);
       </script>
    </td>
  </tr>
  <tr>
    <th class="lmoMenu" align="center">
      <a href="<?=$_SERVER['PHP_SELF']; ?>?action=admin&amp;todo=tippuseredit&amp;save=-1"><?=$text['tipp'][136]; ?></a></th>
    </th>
  </tr>
</table><? 
}
function cmp ($a1, $a2) {
  global $tipper_sort;
  if (is_numeric($a1[$tipper_sort]) && is_numeric($a2[$tipper_sort])) {  //Numerischer Vergleich
    if ($a2[$tipper_sort]==$a1[$tipper_sort]) return 0;
    return ($a1[$tipper_sort]>$a2[$tipper_sort]) ? 1 : -1;
  }else{ //Stringvergleich
    $a1[$tipper_sort]=strtr($a1[$tipper_sort],"¥µÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝßàáâãäåæçèéêëìíîïðñòóôõöøùúûüýÿ","YuAAAAAAACEEEEIIIIDNOOOOOOUUUUYsaaaaaaaceeeeiiiionoooooouuuuyy");
  	$a2[$tipper_sort]=strtr($a2[$tipper_sort],"¥µÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝßàáâãäåæçèéêëìíîïðñòóôõöøùúûüýÿ","YuAAAAAAACEEEEIIIIDNOOOOOOUUUUYsaaaaaaaceeeeiiiionoooooouuuuyy");
  	return  strnatcasecmp($a1[$tipper_sort],$a2[$tipper_sort]);
  }
}

?>