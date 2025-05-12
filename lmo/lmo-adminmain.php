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
function getmicrotime(){
  list($usec, $sec) = explode(" ",microtime());
  return ((float)$usec + (float)$sec);
}
$startzeit = getmicrotime();
if ($action=="admin"){
  $me=array("0","January","February","March","April","May","June","July","August","September","October","November","December");
  $adda=$_SERVER['PHP_SELF']."?action=admin&amp;todo=";
  if (!isset($st)){$sty=0;} else {$sty=$st;}
  if (!isset($newpage)){$newpage=0;}
  $file=isset($_REQUEST['file'])?$_REQUEST['file']:"";
  $subdir = isset($_REQUEST["subdir"]) ? $_REQUEST["subdir"] : dirname($file) . '/';
    if ($subdir == '/'){
        $subdir = '';
    }

  $warning = (int)0;
  if (version_compare(PHP_VERSION, $min_php_version, '<')) echo getMessage("This LMO requires a web server with PHP ".$min_php_version." or higher installed.<br>Your web server does not currently support this because your PHP version is:: <mark>".PHP_VERSION."</mark>", $warning = $warning+1, true);
  if (@file_exists(PATH_TO_LMO."/install/install.php") && @is_readable(PATH_TO_LMO."/install/install.php")) echo getMessage("Delete install folder or set its chmod to 000!", $warning = $warning+1,true);
  if ($_SESSION['lmouserok'] == 2) {
    if ($new_lmo_version > $lmo_version) echo getMessage($text[590]."<br><a href='".$new_lmo_version_link.$new_lmo_version."' target='_blank' class='tooltip-test' title='Current Version'>".$text[591]."</a>", "Update",true);
  }
?>

<script type="text/javascript" src="<?php echo URL_TO_LMO?>/js/admin.js.php"></script>
<table class="lmoMain" cellspacing="0" cellpadding="0" border="0">
  <tr>
    <td colspan='2' align="center"><h1><?php echo $text[77]." ".$text[54];?></h1></td>
  </tr>
  <tr>
    <td class="lmoMenu" align="left"><?php
require_once(PATH_TO_LMO."/lmo-openfile.php");
if ($_SESSION['lmouserok'] == 2) {
  if ($todo != "new") {
    echo "<a href='{$adda}new&amp;newpage={$newpage}' onclick='return chklmolink();' title='{$text[79]}'>{$text[78]}</a>";
  } else {
    echo $text[78];
  }
  echo "&nbsp;";
  if ($todo != "open") {
    echo "<a href='{$adda}open&amp;subdir=".$subdir."' onclick='return chklmolink();' title='{$text[81]}'>{$text[80]}</a>";
  } else {
    echo $text[80];
  }
  echo "&nbsp;";
  if ($todo != "delete") {
    echo "<a href='{$adda}delete' onclick='return chklmolink();' title='{$text[83]}'>{$text[82]}</a>";
  } else {
    echo $text[82];
  }
  echo "&nbsp;";
  if ($file != "") {
    if (($todo != "edit") && ($todo != "tabs")) {
      echo "<a href='{$adda}edit&amp;file={$file}' onclick='return chklmolink();' title='{$text[91]}'>{$text[90]}</a>";
    } else {
      echo $text[90];
    }
    echo "&nbsp;";
  }
  if ($todo != "upload") {
    echo "<a href='{$adda}upload' onclick='return chklmolink();' title='{$text[85]}'>{$text[84]}</a>";
  } else {
    echo $text[84];
  }
  echo "&nbsp;";
  if ($todo != "download") {
    echo "<a href='{$adda}download' onclick='return chklmolink();' title='{$text[315]}'>{$text[314]}</a>";
  } else {
    echo $text[314];
  }
  echo "&nbsp;";
  if (($todo != "options") && ($todo != "addons") && ($todo != "user") && ($todo != "design")) {
    echo "<a href='{$adda}options' onclick='return chklmolink();' title='{$text[87]}'>{$text[86]}</a>";
  } else {
    echo $text[86];
  }
  echo "&nbsp;";
  /*Tippspiel-Addon*/
  if ($eintippspiel == 1) {
    if (($todo != "tipp") && ($todo != "tippemail") && ($todo != "tippuser") && ($todo != "tippuseredit") && ($todo != "tippoptions")) {
      echo "<a href='{$adda}tipp' onclick='return chklmolink();' title='{$text['tipp'][57]}'>{$text['tipp'][0]}</a>";
    } else {
      echo $text['tipp'][0];
    }
  }
  /*Tippspiel-Addon*/
  /*Viewer-Addon*/
  echo "&nbsp;";
  if (($todo!="vieweroptions")){
    echo "<a href='{$adda}vieweroptions' onclick='return chklmolink();' title='{$text['viewer'][21]}'>{$text['viewer'][20]}</a>";
  } else {
    echo $text['viewer'][20];
  }
  /*Viewer-Addon*/
  /*PDF-Addon*/
  if (file_exists(PATH_TO_ADDONDIR.'/pdf/lmo-adminpdfoptions.inc.php')){
    echo "&nbsp;";
    if (($todo!="pdfoptions")){
      echo "<a href='{$adda}pdfoptions' onclick='return chklmolink();' title='{$text['pdf'][201]}'>{$text['pdf'][200]}</a>";
    } else {
      echo $text['pdf'][200];
    }
  }
  /*PDF-Addon*/
  } elseif ($_SESSION['lmouserok'] == 1) {
    if ($todo != "open") {
      echo "<a href='{$adda}open' onclick='return chklmolink();' title='{$text[81]}'>{$text[80]}</a>";
    } else {
      echo $text[80];
    }
    echo "&nbsp;";
    if ($file != "") {
      if (($todo != "edit") && ($todo != "tabs")) {
        echo "<a href='{$adda}edit&amp;file={$file}' onclick='return chklmolink();' title='{$text[91]}'>{$text[90]}</a>";
      } else {
        echo $text[90];
      }
      echo "&nbsp;";
    }
    if ($todo != "download") {
      echo "<a href='{$adda}download' onclick='return chklmolink();' title='{$text[315]}'>{$text[314]}</a>";
    } else {
      echo $text[314];
    }

  }
?>
    </td>
    <td class="lmoMenu" align="right"><?php
  echo "<a href='{$adda}logout' onclick='return chklmolink();' title='{$text[89]}'>{$text[88]}</a>";
  echo "&nbsp;";
  if ($_SESSION['lmouserok']==2){echo "<a href='".URL_TO_LMO."/help/Deutsch/index.html' target='_blank' title='{$text[313]}'>{$text[312]}</a>";} else {echo "<a href='".URL_TO_LMO."/help/Deutsch/index.html' target='_blank' title='{$text[313]}'>{$text[312]}</a>";}?>
     </td>
  </tr>
  <tr>
    <td colspan="2" align="center"><?php
  if ($_SESSION['lmouserok'] == 2) {
    $addr_options = $_SERVER['PHP_SELF']."?action=admin&amp;todo=options";
    $addr_addons = $_SERVER['PHP_SELF']."?action=admin&amp;todo=addons";
    $addr_design = $_SERVER['PHP_SELF']."?action=admin&amp;todo=design";
    $addr_user = $_SERVER['PHP_SELF']."?action=admin&amp;todo=user";
    /*Tippspiel-Addon*/
    $tipp_addr_auswertung = $_SERVER['PHP_SELF']."?action=admin&amp;todo=tipp";
    $tipp_addr_email = $_SERVER['PHP_SELF']."?action=admin&amp;todo=tippemail";
    $tipp_addr_user = $_SERVER['PHP_SELF']."?action=admin&amp;todo=tippuser";
    $tipp_addr_optionen = $_SERVER['PHP_SELF']."?action=admin&amp;todo=tippoptions";
    /*Tippspiel-Addon*/
    /*Viewer-Addon*/
    $viewer_addr_optionen = $_SERVER['PHP_SELF']."?action=admin&amp;todo=vieweroptions";
    /*Viewer-Addon*/
    /*PDF-Addon*/
    $pdf_addr_optionen = $_SERVER['PHP_SELF']."?action=admin&amp;todo=pdfoptions";
    /*PDF-Addon*/
    if ($todo == "new") {
      require(PATH_TO_LMO."/lmo-adminnew.php");
    } elseif ($todo == "open") {
      require(PATH_TO_LMO."/lmo-adminopen.php");
    } elseif ($todo == "delete") {
      require(PATH_TO_LMO."/lmo-admindelete.php");
    } elseif ($todo == "edit") {
      if ($sty == -1) {
        require(PATH_TO_LMO."/lmo-adminbasic.php");
      } elseif ($sty == -2) {
        require(PATH_TO_LMO."/lmo-adminteams.php");
      } elseif ($sty == -3) {
        require(PATH_TO_LMO."/lmo-adminanz.php");
      } elseif ($sty==-10){
        require(PATH_TO_LMO."/lmo-adminrounds.php");
      }
      /*Spielerstatistik-Addon*/
      elseif ($sty == -4 && $einspieler == 1) {
        require(PATH_TO_ADDONDIR."/spieler/lmo-statadmin.php");
      }
      /*Spielerstatistik-Addon*/
      else
        {
        require(PATH_TO_LMO."/lmo-adminedit.php");
      }
    } elseif ($todo == "tabs") {
      require(PATH_TO_LMO."/lmo-admintab.php");
    } elseif ($todo == "upload") {
      require(PATH_TO_LMO."/lmo-adminupload.php");
    } elseif ($todo == "download") {
      require(PATH_TO_LMO."/lmo-admindown.php");
    } elseif ($todo == "options") {
      require(PATH_TO_LMO."/lmo-adminoptions.php");
    } elseif ($todo == "user") {
      require(PATH_TO_LMO."/lmo-adminuser.php");
    } elseif ($todo == "addons") {
      require(PATH_TO_LMO."/lmo-adminaddon.php");
    } elseif ($todo == "design") {
      require(PATH_TO_LMO."/lmo-admindesign.php");
    }
    /*Tippspiel-Addon*/
    elseif ($todo == "tipp") {
      require(PATH_TO_ADDONDIR."/tipp/lmo-admintipp.php");
    } elseif ($todo == "tippemail") {
      require(PATH_TO_ADDONDIR."/tipp/lmo-admintippemail.php");
    } elseif ($todo == "tippuser") {
      require(PATH_TO_ADDONDIR."/tipp/lmo-admintippuser.php");
    } elseif ($todo == "tippuseredit") {
      require(PATH_TO_ADDONDIR."/tipp/lmo-admintippuseredit.php");
    } elseif ($todo == "tippoptions") {
      require(PATH_TO_ADDONDIR."/tipp/lmo-admintippoptions.php");
    }
    /*Tippspiel-Addon*/
    /*Viewer-Addon*/
    elseif ($todo=="vieweroptions"){
      require(PATH_TO_ADDONDIR."/viewer/lmo-adminvieweroptions.php");
    }
    /*Viewer-Addon*/
    /*PDF-Addon*/
    elseif ($todo=="pdfoptions"){
      require(PATH_TO_ADDONDIR."/pdf/lmo-adminpdfoptions.inc.php");
    }
    /*PDF-Addon*/
    elseif ($todo == "") {
      require(PATH_TO_LMO."/lmo-adminpad.php");
    }
  } elseif ($_SESSION['lmouserok'] == 1) {
    if ($todo == "open") {
      require(PATH_TO_LMO."/lmo-adminopen.php");
    } elseif ($todo == "edit") {
      if ($sty == -1) {
        require(PATH_TO_LMO."/lmo-adminbasic.php");
      } elseif ($sty == -2 && $_SESSION['lmouserokerweitert'] == 1) {
        require(PATH_TO_LMO."/lmo-adminteams.php");
      } elseif ($sty == -3 && $_SESSION['lmouserokerweitert'] == 1) {
        require(PATH_TO_LMO."/lmo-adminanz.php");
      } elseif ($sty==-10){
        require(PATH_TO_LMO."/lmo-adminrounds.php");
      }
      /*Spielerstatistik-Addon*/
      elseif ($sty == -4 && $einspieler == 1) {
        require(PATH_TO_ADDONDIR."/spieler/lmo-statadmin.php");
      }
      /*Spielerstatistik-Addon*/
      else
        {
        require(PATH_TO_LMO."/lmo-adminedit.php");
      }
    } elseif ($todo == "tabs") {
      require(PATH_TO_LMO."/lmo-admintab.php");
    } elseif ($todo == "download") {
      require(PATH_TO_LMO."/lmo-admindown.php");
    } elseif ($todo == "") {
      require(PATH_TO_LMO."/lmo-adminpad.php");
    }
  }
?>

    </td>
  </tr>
  <tr>
    <td colspan='2' class="lmoFooter" align="left"><?php
  if ($einsprachwahl==1){
    echo getLangSelector();
  }?>
    </td>
  </tr>
  <tr>
    <td align="left">
      <a href="<?php echo URL_TO_LMO."/lmo.php?file=".$file;?>" target="_blank" title="<?php echo $text[116]?>"><?php echo $text[5]?> <?php echo $text[115]?></a>
    </td>
    <td class="lmoFooter" align="right"><?php echo $text[471].": ".number_format((getmicrotime()-$startzeit),4,".",",")." ".$text[592]."."; ?></td>
  </tr>
</table><?php
}?>