<?
// 
// LigaManager Online 3.02b
// Copyright (C) 1997-2002 by Frank Hollwitz
// webmaster@hollwitz.de / http://php.hollwitz.de
// 
// LigaManager Online
// Edited by: Rene Marth
// 29.08.2003
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
    $lmo_admin_data[]=array(trim($_POST["xadmin_name"]),trim($_POST["xadmin_pass"]),1,'');  //Neue User sind zunächst immer Hilfsadmins ohne Ligen
    require(PATH_TO_LMO."/lmo-saveauth.php");
    require(PATH_TO_LMO."/lmo-loadauth.php");
  } 
?>
<table class="lmosta" cellspacing="0" cellpadding="0" border="0">
  <tr>
    <td class="lmost1" align="center" colspan="2"><?=$text[321]?></td>
  </tr>
  <tr>
    <td valign="top">
      <table cellspacing="0" cellpadding="0" border="0"><?
  $testshow=0;
  foreach($lmo_admin_data as $lmo_admin) {
    $show_admin_name=$lmo_admin[2]==2?"<em>".$lmo_admin[0]."</em>":$lmo_admin[0];?>
         <tr><td<?if ($show==$testshow) {?> class="lmost1"><?=$show_admin_name;?><?}else{?> class="lmost0"><a href="<?=$_SERVER['PHP_SELF']."?action=admin&todo=user&amp;show=".$testshow;?>"><?=$show_admin_name;?></a><?}?></td></tr><?
    $testshow++;
  }?>
       </table>
    </td>
    <td align="center" valign="top" class="lmost3">
      <form name="lmoedit<?=$show?>" action="<?=$_SERVER['PHP_SELF']?>" method="post">
        <input type="hidden" name="action" value="admin">
        <input type="hidden" name="todo" value="user">
        <input type="hidden" name="save" value="<?=$show?>">
        <table class="lmostb" cellspacing="0" cellpadding="0" border="0"><?
  $testshow=0;
  foreach($lmo_admin_data as $lmo_admin) {
    if ($show==-1) {?>
          <tr>
            <td class="lmost4"><?$testshow==0?print($text[318]):print("&nbsp;")?></td>
          </tr><?
    }
    if ($show==$testshow) {?> 
          <tr>
            <td class="lmost4"><?=$text[322]?></td>
            <td class="lmost5" colspan="2"><input class="lmoadminein" type="text" name="xadmin_name<?=$testshow?>" size="16" maxlength="32" value="<?=$lmo_admin[0]?>"></td>
          </tr>
          <tr>
            <td class="lmost4"><?=$text[323]?></td>
            <td class="lmost5" colspan="2"><input class="lmoadminein" type="text" name="xadmin_pass<?=$show?>" size="16" maxlength="32" value="<?=$lmo_admin[1]?>"></td>
          </tr>
          <tr>
            <td class="lmost4" rowspan="2"><?=$text[324]?></td>
            <td class="lmost5" colspan="2"><input class="lmoadminein" type="radio" name="xadmin_rang<?=$show?>" value="2" <?if ($lmo_admin[2]==2) echo " checked";?>><?=$text[326]?></td>
          </tr>
          <tr>
            <td class="lmost5" colspan="2"><input class="lmoadminein" type="radio" name="xadmin_rang<?=$show?>" value="1" <?if ($lmo_admin[2]==1) echo " checked";?>><?=$text[325]?></td>
          </tr><?
      if($lmo_admin[2]==1){?>
          <tr>
            <td class="lmost4" colspan="3"><acronym title="<?=$text[398]?>"><?=$text[397]?></acronym></td>
          </tr><?
        $helfer_ligen=explode(',',$lmo_admin_data[$testshow][3]);
        $handle=opendir(PATH_TO_LMO.'/'.$dirliga);
        while ($lig=readdir($handle)) {
          if (substr($lig,-4)==".l98") {
            $ligenname=substr($lig,0,-4);?>
          <tr>
            <td class="lmost5" colspan="3"><input class="lmoadminein" type="checkbox" name="xhelfer_ligen<?=$show?>[]" size="50" value="<?=$ligenname?>"<?if (in_array($ligenname,$helfer_ligen)) echo " checked"?>><?= $ligenname?></td>
          </tr><?
          }
        }
      }?>
          <tr>
            <td class="lmost5" colspan="2" align="right"><acronym title="<?=$text[327]?>"><input class="lmoadminbut" type="submit" value="<?=$text[329]?>"></acronym></td>
            <td class="lmost5" align="right">
              <a href="<?=$_SERVER['PHP_SELF']?>?action=admin&amp;todo=user&amp;del=<?=$show?>" onclick="return confirm('<?=$text[499]?>');"><img border="0" width="11" heigth="13" src="img/delete.gif" alt="<?=$text[330]?>" title="<?=$text[328]?>"></a>
            </td>
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
    <td class="lmost4" colspan="4" colspan="2"><?=$text[331]?></td>
  </tr>
  <tr>
    <td colspan="2">
      <form name="lmoeditx" action="<?=$_SERVER['PHP_SELF']?>" method="post">
        <input type="hidden" name="action" value="admin">
        <input type="hidden" name="todo" value="user">
        <input type="hidden" name="save" value="-1">
        <input type="hidden" name="show" value="<?=$show+1?>">
        <table class="lmostb" cellspacing="0" cellpadding="0" border="0">
          <tr>
            <td class="lmost5"><input class="lmoadminein" type="text" name="xadmin_name" size="16" maxlength="32" value="NeuerUser"></td>
            <td class="lmost5"><input class="lmoadminein" type="text" name="xadmin_pass" size="16" maxlength="32" value="<?=substr(md5(uniqid(rand())),0,rand(8,16));?>"></td>
            <td class="lmost5"><acronym title="<?=$text[327]?>"><input class="lmoadminbut" type="submit" value="<?=$text[329]?>"></acronym></td>
          </tr>
        </table>
      </form>
    </td>
  </tr>
  <tr>
    <td colspan="2">
      <table width="100%" cellspacing="0" cellpadding="0" border="0">
        <tr>
          <td class="lmost2" align="center"><a href="<?=$addr_options?>" onclick="return chklmolink('<?=$addr_options?>');" title="<?=$text[320]?>"><?=$text[319]?></a></td>
          <td class="lmost2" align="center"><a href="<?=$addr_addons?>" onclick="return chklmolink('<?=$addr_addons?>');" title="<?=$text[498]?>"><?=$text[497]?></a></td>
          <td class="lmost2" align="center"><a href="<?=$addr_design?>" onclick="return chklmolink('<?=$addr_design?>');" title="<?=$text[422]?>"><?=$text[421]?></a></td>
          <td class="lmost1" align="center"><?=$text[317]?></td>
        </tr>
      </table>
    </td>
  </tr>
</table><?
}

//Sortierfunktion für die Admins
  function sort_admin ($admin_a, $admin_b) {
    return strnatcasecmp($admin_a[0], $admin_b[0]);
  }?>