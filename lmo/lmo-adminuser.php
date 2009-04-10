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
if ($_SESSION['lmouserok']==2) {
  
  
  
  isset($_GET['del'])?$del=$_GET['del']:$del=-1;
  isset($_POST['save'])?$save=$_POST['save']:$save=-2;
  isset($_REQUEST['show'])?$show=$_REQUEST['show']:$show=-1;
  
  require(PATH_TO_LMO."/lmo-loadauth.php");
 
  if ($save>=0) {
    if(isset($_POST["xadmin_name".$save]) && isset($_POST["xadmin_pass".$save]) && isset($_POST["xadmin_rang".$save])) {
      $lmo_admin_data[$save]=array(trim($_POST["xadmin_name".$save]),trim($_POST["xadmin_pass".$save]),trim($_POST["xadmin_rang".$save]));
      $lmo_helfer_ligen_neu=array();
      if (trim($_POST["xadmin_rang".$save])==1) {  //Hilfsadmin -> Ligen herausfinden
        $lmo_helfer_ligen=isset($_POST["xhelfer_ligen".$save]) && count($_POST["xhelfer_ligen".$save])>0?$_POST["xhelfer_ligen".$save]:array();
        if (count($lmo_helfer_ligen)>0) {  
          for ($u=0; $u<count($lmo_helfer_ligen); $u++) {  //Alle Ligen durchgehen
            $l=strlen($lmo_helfer_ligen[$u])-4;
            if (substr($lmo_helfer_ligen[$u],-4)==".l98") {
              $lmo_helfer_ligen[$u]=substr($lmo_helfer_ligen[$u],0,$l);  //l98-Endung entfernen
            }
            while (strrchr($lmo_helfer_ligen[$u],"/")!==false) {
              $lmo_helfer_ligen[$u]=strrchr($lmo_helfer_ligen[$u],"/");
              $l=strlen($lmo_helfer_ligen[$u])-1;
              $lmo_helfer_ligen[$u]=substr($lmo_helfer_ligen[$u],1,$l);
            }
            if (file_exists($dirliga.$lmo_helfer_ligen[$u].".l98")===true) {  //Datei existiert
              $lmo_helfer_ligen_neu[]=$lmo_helfer_ligen[$u];
            }
          }
        }
      }  //Ende Hilfsadmin
      $lmo_admin_data[$save][3]=implode(',',$lmo_helfer_ligen_neu); //Ligen hinzufügen
      //Erweiterter Hilfsadmin
      if (trim($_POST["xadmin_rang".$save])==1 && isset($_POST["xadmin_erweitert".$save])) {
        $lmo_admin_data[$save][4]="1";
      } else {
        $lmo_admin_data[$save][4]="0";
      }
      
    }
    $main_admin=array_shift($lmo_admin_data);
    usort($lmo_admin_data,"sort_admin");
    array_unshift($lmo_admin_data,$main_admin);
    require(PATH_TO_LMO."/lmo-saveauth.php");
    require(PATH_TO_LMO."/lmo-loadauth.php");
  }elseif ($del>=0) {  //User löschen
    $lmo_admin_data[$del]='';
    require(PATH_TO_LMO."/lmo-saveauth.php");
    require(PATH_TO_LMO."/lmo-loadauth.php");
  }elseif ($save==-1) {  //Neuen User anlegen
    foreach ($lmo_admin_data as $admin ) {
      if (trim($_POST["xadmin_name"])==$admin[0]) {
        $admin_dupe=1;
        break;
      }
    }
    if (empty($admin_dupe) && !empty($_POST["xadmin_name"]) && !empty($_POST["xadmin_pass"])){
      $lmo_admin_data[]=array(trim($_POST["xadmin_name"]),trim($_POST["xadmin_pass"]),1,'','');  //Neue User sind zunächst immer Hilfsadmins ohne Ligen
      require(PATH_TO_LMO."/lmo-saveauth.php");
      require(PATH_TO_LMO."/lmo-loadauth.php");
      $show=count($lmo_admin_data)-1;
    } else {
      echo getMessage($text[567],TRUE);
      $show=-1;
    }
  } 
?>
<table class="lmoSubmenu" width="100%" cellspacing="0" cellpadding="0" border="0">
  <tr>
    <td align="center"><a href="<?=$addr_options?>" onclick="return chklmolink();" title="<?=$text[320]?>"><?=$text[319]?></a></td>
    <td align="center"><a href="<?=$addr_addons?>" onclick="return chklmolink();" title="<?=$text[498]?>"><?=$text[497]?></a></td>
    <td align="center"><a href="<?=$addr_design?>" onclick="return chklmolink();" title="<?=$text[422]?>"><?=$text[421]?></a></td>
    <td align="center"><?=$text[317]?></td>
  </tr>
</table>
<table class="lmoMiddle" cellspacing="0" cellpadding="0" border="0">
  <tr>
    <td align="center" colspan="2"><h1><?=$text[321]?></h1></td>
  </tr>
  <tr>
    <td valign="top">
      <table class="lmoMenu" cellspacing="0" cellpadding="0" border="0"><?
  $testshow=0;
  foreach($lmo_admin_data as $lmo_admin) {
    $show_admin_name=$lmo_admin[2]==2?"<em>".$lmo_admin[0]."</em>":$lmo_admin[0];?>
         <tr>
           <td align="right"><?
    if ($show==$testshow) {
      echo $show_admin_name;
    } else {?>
             <a href="<?=$_SERVER['PHP_SELF']."?action=admin&amp;todo=user&amp;show=".$testshow;?>"><?=$show_admin_name;?></a><?
    }    ?></td>
         </tr><?
    $testshow++;
  }?>
       </table>
    </td>
    <td align="center" valign="top">
      <form name="lmoedit<?=$show?>" action="<?=$_SERVER['PHP_SELF']?>" method="post">
        <input type="hidden" name="action" value="admin">
        <input type="hidden" name="todo" value="user">
        <input type="hidden" name="save" value="<?=$show?>">
        <table class="lmoInner" cellspacing="0" cellpadding="0" border="0"><?
  $testshow=0;
  foreach($lmo_admin_data as $lmo_admin) {
    if ($show==-1 && $testshow==0) {?>
          <tr>
            <td align="center">&nbsp;<br><?=$text[318]?><br>&nbsp;</td>
          </tr><?
    }
    if ($show==$testshow) {?> 
          <tr>
            <td align="right"><?=$text[322]?></td>
            <td align="left" colspan="2"><input class="lmo-formular-input" type="text" name="xadmin_name<?=$testshow?>" size="16" maxlength="32" value="<?=$lmo_admin[0]?>"></td>
          </tr>
          <tr>
            <td align="right"><?=$text[323]?></td>
            <td align="left" colspan="2"><input class="lmo-formular-input" type="text" name="xadmin_pass<?=$show?>" size="16" maxlength="32" value="<?=$lmo_admin[1]?>"></td>
          </tr>
          <tr>
            <td align="right" rowspan="2"><?=$text[324]?></td>
            <td align="left" colspan="2"><input onClick="document.lmoedit<?=$show?>.xadmin_erweitert<?=$show?>.disabled=true" class="lmo-formular-input" type="radio" name="xadmin_rang<?=$show?>" value="2" <?if ($lmo_admin[2]==2) echo " checked";?>><?=$text[326]?></td>
          </tr>
          <tr>
            <td align="left" colspan="2"><input onClick="document.lmoedit<?=$show?>.xadmin_erweitert<?=$show?>.disabled=false" class="lmo-formular-input" type="radio" name="xadmin_rang<?=$show?>" value="1" <?if ($lmo_admin[2]==1) echo " checked";?>><?=$text[325]?></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left"><input class="lmo-formular-input" type="checkbox" name="xadmin_erweitert<?=$show?>" <?if (isset($lmo_admin[4]) && $lmo_admin[4]==1) echo " checked";?> <?if ($lmo_admin[2]==2) echo " disabled";?>><acronym title="<?=$text[560]?>"><?=$text[559]?></acronym></td>
          </tr><?
      if($lmo_admin[2]==1){?>
          <tr>
            <th colspan="3"><acronym title="<?=$text[398]?>"><?=$text[397]?></acronym></th>
          </tr><?
        $helfer_ligen=explode(',',$lmo_admin_data[$testshow][3]);
        $handle=opendir(PATH_TO_LMO.'/'.$dirliga);
        while ($file=readdir($handle)) {
          require(PATH_TO_LMO."/lmo-openfilename.php");
          if (substr($file,-4)==".l98") {
            $ligenname=substr($file,0,-4);?>
          <tr>
            <td align="left" class="lmost5" colspan="3"><input class="lmo-formular-input" type="checkbox" name="xhelfer_ligen<?=$show?>[]" value="<?=$ligenname?>"<?if (in_array($ligenname,$helfer_ligen)) echo " checked"?>><?= $titel?></td>
          </tr><?
          }
        }
      }?>
          <tr>
            <td>&nbsp;</td>
            <td align="center"><acronym title="<?=$text[327]?>"><input class="lmo-formular-button" type="submit" value="<?=$text[329]?>"></acronym></th><?
      if ($testshow!=0){?>      
            <td align="right">
              <a href="<?=$_SERVER['PHP_SELF']?>?action=admin&amp;todo=user&amp;del=<?=$show?>" onclick="return confirm('<?=$text[499]?>');"><img border="0" width="11" heigth="13" src="<?=URL_TO_IMGDIR?>/delete.gif" alt="<?=$text[330]?>" title="<?=$text[328]?>"></a>
            </td><?
      }?>
          </tr><? 
    }//if $show=$testshow
    $testshow++;
  }//foreach
  ?>
        </table>
      </form>
    </td>
  </tr>
  <tr>
    <th colspan="2"><h1><?=$text[331]?></h1></th>
  </tr>
  <tr>
    <td align="center" colspan="2">
      <form name="lmoeditx" action="<?=$_SERVER['PHP_SELF']?>" method="post">
        <input type="hidden" name="action" value="admin">
        <input type="hidden" name="todo" value="user">
        <input type="hidden" name="save" value="-1">
        <input type="hidden" name="show" value="<?=count($lmo_admin_data)?>">
        <table class="lmoInner" cellspacing="0" cellpadding="0" border="0">
          <tr>
            <td align="right"><input class="lmo-formular-input" type="text" name="xadmin_name" size="16" maxlength="32" value="NeuerUser"></td>
            <td align="left"><input class="lmo-formular-input" type="text" name="xadmin_pass" size="16" maxlength="32" value="<?=substr(md5(uniqid(rand())),0,rand(8,16));?>"></td>
            <td align="right"><input class="lmo-formular-button" type="submit" value="<?=$text[329]?>" title="<?=$text[327]?>"></td>
          </tr>
        </table>
      </form>
    </td>
  </tr>
</table><?
}

//Sortierfunktion für die Admins
  function sort_admin ($admin_a, $admin_b) {
    return strnatcasecmp($admin_a[0], $admin_b[0]);
  }?>