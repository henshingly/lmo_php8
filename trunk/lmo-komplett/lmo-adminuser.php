<?
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
require_once("lmo-admintest.php");
if($HTTP_SESSION_VARS['lmouserok']==2){
  $users = array("");
  $userf = array("");
  if(!isset($HTTP_GET_VARS['del'])){$del=0;}
  if(!isset($HTTP_POST_VARS['save'])){$save=0;}
  $pswfile="lmo-auth.txt";
  $psw1file="lmo-access.txt";
  $datei = fopen($pswfile,"rb");
  while (!feof($datei)) {
    $zeile = fgets($datei,1000);
    $zeile=trim(chop($zeile));
    if($zeile!=""){
      if($zeile!=""){array_push($users,$zeile);}
      }
    }
  fclose($datei);
  $datei = fopen($psw1file,"rb");
  while (!feof($datei)) {
    $zeile = fgets($datei,1000);
    $zeile=trim(chop($zeile));
    if($zeile!=""){
      if($zeile!=""){array_push($userf,$zeile);}
      }
    }
  fclose($datei);
  $userf1="";
  if($save>0){
    $users[$save]=trim($HTTP_POST_VARS["xname".$save])."|".trim($HTTP_POST_VARS["xpass".$save])."|".trim($HTTP_POST_VARS["xzugr".$save])."|EOL";
    if(trim($HTTP_POST_VARS["xzugr".$save])==1){
      $userh1=split("[,]",trim($HTTP_POST_VARS["xfiles".$save]));
      $userh="";
      if(count($userh1)>0){
        for($u=0;$u<count($userh1);$u++){
          $l=strlen($userh1[$u])-4;
          if(substr($userh1[$u],-4)==".l98"){$userh1[$u]=substr($userh1[$u],0,$l);}
          while(strrchr($userh1[$u],"/")!=false){
            $userh1[$u]=strrchr($userh1[$u],"/");
            $l=strlen($userh1[$u])-1;
            $userh1[$u]=substr($userh1[$u],1,$l);
            }
          if(file_exists($dirliga.$userh1[$u].".l98")==true){
            if($userh!=""){$userh=$userh.",";}
            $userh=$userh.$userh1[$u];
            }
          }
        }
      $userf1=trim($HTTP_POST_VARS["oldu"])."|".$userh."|".trim($HTTP_POST_VARS["xname".$save])."|EOL";
      }
    require("lmo-saveauth.php");
    }
  elseif($save==-1){
    array_push($users,trim($HTTP_POST_VARS["xnamex"])."|".trim($HTTP_POST_VARS["xpassx"])."|".trim($HTTP_POST_VARS["xzugrx"])."|EOL");
    if(trim($HTTP_POST_VARS["xzugrx"])==1){
      $userf1=trim($HTTP_POST_VARS["xnamex"])."||EOL";
      }
    require("lmo-saveauth.php");
    }
  elseif($del>0){
    for($i=$del+1;$i<count($users);$i++){
      $users[$i-1]=$users[$i];
      }
    $userf2=array_pop($users);
    $userf3=split("[|]",$userf2);
    $userf1=$userf3[0];
    require("lmo-saveauth.php");
    }
?>

<table class="lmosta" cellspacing="0" cellpadding="0" border="0">
  <tr>
    <td class="lmost1" align="center"><?=$text[321]?></td>
  </tr><? 
  if(count($users)>1){
    for($i=1;$i<count($users);$i++){
      $userd = split("[|]",$users[$i]);
      $userg="";
      
      if($userd[2]==1){
        for($j=1;$j<count($userf);$j++){
          $usere = split("[|]",$userf[$j]);
          if($userd[0]==$usere[0]){$userg=$usere[1];}
        }
      }?>
  <tr>
    <td align="center" class="lmost3">
      <form name="lmoedit<?=$i?>" action="<?=$PHP_SELF?>" method="post">
        <input type="hidden" name="action" value="admin">
        <input type="hidden" name="todo" value="user">
        <input type="hidden" name="save" value="<?=$i?>">
        <input type="hidden" name="oldu" value="<?=$userd[0]?>">
        <table class="lmostb" cellspacing="0" cellpadding="0" border="0"><?
      if ($i==1) {?>
          <tr>
            <td class="lmost4"><?=$text[322]?></td>
            <td class="lmost4"><?=$text[323]?></td>
            <td class="lmost4"><?=$text[324]?></td>
            <td colspan="2"class="lmost4">&nbsp;</td>
          </tr><?
      }?>    
          <tr>
            <td class="lmost5"><input class="lmoadminein" type="text" name="xname<?=$i?>" size="16" maxlength="32" value="<?=$userd[0]?>"></td>
            <td class="lmost5"><input class="lmoadminein" type="text" name="xpass<?=$i?>" size="16" maxlength="32" value="<?=$userd[1]?>"></td>
            <td class="lmost5">
              <select class="lmoadminein" name="xzugr<?=$i?>">
                <option value="1"<?if($userd[2]==1){echo " selected";}?>><?=$text[325]?></option>
                <option value="2"<?if($userd[2]==2){echo " selected";}?>><?=$text[326]?></option>
              </select>
            </td>
            <td class="lmost5"><acronym title="<?=$text[327]?>"><input class="lmoadminbut" type="submit" name="best<?=$i?>" value="<?=$text[329]?>"></acronym></td>
            <td>
              <a href="<?=$PHP_SELF?>?action=admin&amp;todo=user&amp;del=<?=$i?>" onclick="return confirm('<?=$text[499]?>');"><img border="0" width="11" heigth="13" src="delete.gif" alt="<?=$text[330]?>" title="<?=$text[328]?>"></a>
            </td>
          </tr><?
      if($userd[2]==1){?>
          <tr>
            <td class="lmost8" colspan="3"><acronym title="<?=$text[398]?>"><?=$text[397]?>: <input class="lmoadminein" type="text" name="xfiles<?=$i?>" size="40" maxlength="256" value="<?=$userg?>"></acronym></td>
          </tr><?
      }?>
        </table>
      </form>
    </td>
  </tr><? 
      if($i==count($users)-1){?>
  <tr>
    <td class="lmost5" colspan="4">&nbsp;</td>
  </tr><?     
      }//if
    }//for
  }//if
  ?>
  <tr>
    <td class="lmost4" colspan="4"><?=$text[331]?></td>
  </tr>
  <tr>
    <td>
      <form name="lmoeditx" action="<?=$PHP_SELF?>" method="post">
        <input type="hidden" name="action" value="admin">
        <input type="hidden" name="todo" value="user">
        <input type="hidden" name="save" value="-1">
        <table class="lmostb" cellspacing="0" cellpadding="0" border="0">
          <tr>
            <td class="lmost5"><input class="lmoadminein" type="text" name="xnamex" size="16" maxlength="32" value="NeuerUser"></td>
            <td class="lmost5"><input class="lmoadminein" type="text" name="xpassx" size="16" maxlength="32" value="<? require("lmo-adminuserpass.php")?>"></td>
            <td class="lmost5">
              <select class="lmoadminein" name="xzugrx">
                <option value="1" selected><?=$text[325]?></option>
                <option value="2"><?=$text[326]?></option>
              </select>
            </td>
            <td class="lmost5"><acronym title="<?=$text[327]?>"><input class="lmoadminbut" type="submit" name="bestx" value="<?=$text[329]?>"></acronym></td>
          </tr>
        </table>
      </form>
    </td>
  </tr>
  <tr>
    <td>
      <table width="100%" cellspacing="0" cellpadding="0" border="0">
        <tr>
          <td class="lmost2" align="center"><a href="<?=$addr_options?>" onclick="return chklmolink('<?=$addr_options?>');" title="<?=$text[320]?>"><?=$text[319]?></a></td>
          <td class="lmost2" align="center"><a href="<?=$addr_addons?>" onclick="return chklmolink('<?=$addr_addons?>');" title="<?=$text[498]?>"><?=$text[497]?></a></td>
          <td class="lmost2" align="center"><a href="<?=$addr_design?>" onclick="return chklmolink('<?=$addr_design?>');" title="<?=$text[422]?>"><?=$text[421]?></a></td>
          <td class="lmost2" align="center"><?=$text[317]?></td>
        </tr>
      </table>
    </td>
  </tr>
</table>
<? }?>