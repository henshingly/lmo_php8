<?PHP
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
  if(!isset($xfile)){$xfile="";}
  if(!isset($xtitel)){$xtitel="";}
  if(!isset($xtype)){$xtype="";}
  if(!isset($xprogram)){$xprogram=0;}
  if($newpage==0){
    if($xfile==""){$xfile="noname";}
    if($xtitel==""){$xtitel="No Name";}
    if($xtype==""){$xtype="0";}
    }
  if($newpage==1){
    if(file_exists($dirliga.$xfile.".l98")){
      echo "<font color=\"#ff0000\">".$text[280]."</font>";
      $newpage=0;
      }
    }
  if($newpage==2){
    if($xtype==0){
      if($xprogram==""){$xprogram="none";}
      }
    else{
      $xanzst=strlen(decbin($xteams-1));
      $xmodus = array_pad($array,7,"1");
      }
    }
  if($newpage==3){
    if($xtype==0){
      if($xprogram!="none"){
        $yteama=array_pad($array,$xanzst,"");
        $yteamb=array_pad($array,$xanzst,"");
        for($i=0;$i<$xanzst;$i++){
          $yteama[$i]=array_pad($array,$xanzsp,"");
          $yteamb[$i]=array_pad($array,$xanzsp,"");
          }
        if($xprogram=="random"){
          require("lmo-adminrndprogram.php");
          }
        else{
          require("lmo-adminopenprogram.php");
          }
        }
      }
    $titel=$xtitel;
    $lmtype=$xtype;
    $anzteams=$xteams;
    if($xtype==0){
      $anzst=$xanzst;
      $anzsp=$xanzsp;
      }
    else{
      $modus = array_pad($array,7,"1");
      $anzst=strlen(decbin($anzteams-1));
      $anzsp=$anzteams;
      }
    $st="1";
    $spez=$lmtype;
    if($xtype==0){
      $pns="3";
      $pnu="1";
      $pnn="0";
      $hidr="0";
      $kurve="1";
      $kreuz="1";
      $onrun="0";
      $kegel="0";
      $minus="1";
      $direkt="0";
      $champ="1";
      $anzcl="1";
      $anzck="1";
      $anzuc="3";
      $anzar="0";
      $anzab="3";
      }
    else{
      $klfin="0";
      }
    $hands="0";
    $datc="1";
    $dats="1";
    $datm="1";
    $datf="%d.%m. %H:%M";
    $urlt="1";
    $urlb="1";
    $favteam="0";
    $selteam="0";
    if($xtype==0){
      $stat1="0";
      $stat2="0";
      }
    $nticker="0";
    for($i=1;$i<=$anzteams;$i++){
      $teams[$i]=$text[281]." ".$i;
      $teamk[$i]=$text[282].$i;
      if($lmtype==0){$strafp[$i]="0";}
      $teamu[$i]="";
      $teamn[$i]="";
      }
    for($i=1;$i<=$anzst;$i++){
      $datum1[$i-1]="";
      $datum2[$i-1]="";
      if($lmtype==0){
        for($j=1;$j<=$anzsp;$j++){
          if($xprogram=="none"){
            $teama[$i-1][$j-1]="0";
            $teamb[$i-1][$j-1]="0";
            }
          else{
            $teama[$i-1][$j-1]=$yteama[$i-1][$j-1];
            $teamb[$i-1][$j-1]=$yteamb[$i-1][$j-1];
            }
          $goala[$i-1][$j-1]="-1";
          $goalb[$i-1][$j-1]="-1";
          $mnote[$i-1][$j-1]="";
          $mberi[$i-1][$j-1]="";
          $mterm[$i-1][$j-1]="";
          }
        }
      else{
        $modus[$i-1]=$HTTP_POST_VARS["xmod".$i];
        $anzsp=$anzsp/2;
        for($j=1;$j<=$anzsp;$j++){
          $teama[$i-1][$j-1]="0";
          $teamb[$i-1][$j-1]="0";
          for($n=1;$n<=$modus[$i-1];$n++){
            $goala[$i-1][$j-1][$n-1]="-1";
            $goalb[$i-1][$j-1][$n-1]="-1";
            $mnote[$i-1][$j-1][$n-1]="";
            $mspez[$i-1][$j-1][$n-1]="_";
            $mberi[$i-1][$j-1][$n-1]="";
            $mterm[$i-1][$j-1][$n-1]="";
            }
          }
        }
      }
    $file=$dirliga.$xfile.".l98";
    require("lmo-savefile.php");
    }
?>

<table class="lmosta" cellspacing="0" cellpadding="0" border="0">
  <tr>
    <td class="lmost1" align="center"><?PHP echo $text[243]; ?></td>
  </tr>
  <tr><td align="center" class="lmost3"><table class="lmostb" cellspacing="0" cellpadding="0" border="0">

<?PHP if($newpage<3){ ?>
  <form name="lmoedit" action="<?PHP echo $PHP_SELF; ?>" method="post">
  
  <input type="hidden" name="action" value="admin">
  <input type="hidden" name="todo" value="new">
  <input type="hidden" name="newpage" value="<?PHP echo ($newpage+1); ?>">
<?PHP if($newpage>0){ ?>
  <input type="hidden" name="xfile" value="<?PHP echo $xfile; ?>">
  <input type="hidden" name="xtitel" value="<?PHP echo $xtitel; ?>">
  <input type="hidden" name="xtype" value="<?PHP echo $xtype; ?>">
<?PHP } ?>
<?PHP if($newpage>1){ ?>
  <input type="hidden" name="xteams" value="<?PHP echo $xteams; ?>">
  <input type="hidden" name="xanzst" value="<?PHP echo $xanzst; ?>">
  <input type="hidden" name="xanzsp" value="<?PHP echo $xanzsp; ?>">
<?PHP }} ?>
  <tr>
    <td class="lmost4" colspan="3"><nobr><?PHP echo $text[246]." ".($newpage+1)." ".$text[259]." 4"; ?></nobr></td>
  </tr>

<?PHP if($newpage==0){ ?>
  <tr>
    <td class="lmost5" width="20">&nbsp;</td>
    <td class="lmost5" align="right"><nobr><acronym title="<?PHP echo $text[245]; ?>"><?PHP echo $text[244]; ?></acronym></nobr></td>
    <td class="lmost5"><nobr><acronym title="<?PHP echo $text[245]; ?>"><?PHP echo $dirliga; ?><input class="lmoadminein" type="text" name="xfile" size="28" maxlength="28" value="<?PHP echo $xfile; ?>" onChange="lmofilename()">.l98</acronym></nobr></td>
  </tr>
  <tr>
    <td class="lmost5" width="20">&nbsp;</td>
    <td class="lmost5" align="right"><nobr><acronym title="<?PHP echo $text[118] ?>"><?PHP echo $text[113]; ?></acronym></nobr></td>
    <td class="lmost5"><acronym title="<?PHP echo $text[118] ?>"><input class="lmoadminein" type="text" name="xtitel" size="40" maxlength="60" value="<?PHP echo $xtitel; ?>" onChange="lmotitelname()"></acronym></td>
  </tr>
  <tr>
    <td class="lmost5" width="20">&nbsp;</td>
    <td class="lmost5" align="right"><nobr><acronym title="<?PHP echo $text[175] ?>"><?PHP echo $text[174]; ?></acronym></nobr></td>
    <td class="lmost5"><acronym title="<?PHP echo $text[175] ?>"><select class="lmoadminein" name="xtype" onChange="dolmoedit()"><?PHP echo "<option value=\"0\""; if($xtype==0){echo " selected";} echo ">".$text[176]."</option>"; echo "<option value=\"1\""; if($xtype==1){echo " selected";} echo ">".$text[177]."</option>"; ?></select></acronym></td>
  </tr>
<?PHP } ?>

<?PHP
  if($newpage==1){
    if($xtype==0){
?>
  <tr>
    <td class="lmost5" width="20">&nbsp;</td>
    <td class="lmost5" align="right"><nobr><acronym title="<?PHP echo $text[272] ?>"><?PHP echo $text[271]; ?></acronym></nobr></td>
    <td class="lmost5"><acronym title="<?PHP echo $text[272] ?>"><table cellpadding="0" cellspacing="0" border="0"><tr>
      <td class="lmost5" align="right"><input class="lmoadminein" type="text" name="xteams" size="2" maxlength="2" value="18" onChange="lmoteamauf('xteams',0)" onKeyDown="lmoteamclk('xteams',event.keyCode)"></td>
      <td class="lmost5" align="center"><table cellpadding="0" cellspacing="0" border="0"><tr><td><a href="javascript:lmoteamauf('xteams',1);" title="<?PHP echo $text[273]; ?>" onMouseOver="lmoimg('ta',img1)" onMouseOut="lmoimg('ta',img0)"><img src="lmo-admin0.gif" name="ximgta" width="7" height="7" border="0"></a></td></tr><tr><td><a href="javascript:lmoteamauf('xteams',-1);" title="<?PHP echo $text[273]; ?>" onMouseOver="lmoimg('tb',img3)" onMouseOut="lmoimg('tb',img2)"><img src="lmo-admin2.gif" name="ximgtb" width="7" height="7" border="0"></a></td></tr></table></td>
    </tr></table></acronym></td>
  </tr>
  <tr>
    <td class="lmost5" width="20">&nbsp;</td>
    <td class="lmost5" align="right"><nobr><acronym title="<?PHP echo $text[275] ?>"><?PHP echo $text[274]; ?></acronym></nobr></td>
    <td class="lmost5"><acronym title="<?PHP echo $text[275] ?>"><table cellpadding="0" cellspacing="0" border="0"><tr>
      <td class="lmost5" align="right"><input class="lmoadminein" type="text" name="xanzst" size="3" maxlength="3" value="34" onChange="lmoanzstauf('xanzst',0)" onKeyDown="lmoanzstclk('xanzst',event.keyCode)"></td>
      <td class="lmost5" align="center"><table cellpadding="0" cellspacing="0" border="0"><tr><td><a href="javascript:lmoanzstauf('xanzst',1);" title="<?PHP echo $text[276]; ?>" onMouseOver="lmoimg('sa',img1)" onMouseOut="lmoimg('sa',img0)"><img src="lmo-admin0.gif" name="ximgsa" width="7" height="7" border="0"></a></td></tr><tr><td><a href="javascript:lmoanzstauf('xanzst',-1);" title="<?PHP echo $text[276]; ?>" onMouseOver="lmoimg('sb',img3)" onMouseOut="lmoimg('sb',img2)"><img src="lmo-admin2.gif" name="ximgsb" width="7" height="7" border="0"></a></td></tr></table></td>
    </tr></table></acronym></td>
  </tr>
  <tr>
    <td class="lmost5" width="20">&nbsp;</td>
    <td class="lmost5" align="right"><nobr><acronym title="<?PHP echo $text[278] ?>"><?PHP echo $text[277]; ?></acronym></nobr></td>
    <td class="lmost5"><acronym title="<?PHP echo $text[278] ?>"><table cellpadding="0" cellspacing="0" border="0"><tr>
      <td class="lmost5" align="right"><input class="lmoadminein" type="text" name="xanzsp" size="2" maxlength="2" value="9" onChange="lmoanzspauf('xanzsp',0)" onKeyDown="lmoanzspclk('xanzsp',event.keyCode)"></td>
      <td class="lmost5" align="center"><table cellpadding="0" cellspacing="0" border="0"><tr><td><a href="javascript:lmoanzspauf('xanzsp',1);" title="<?PHP echo $text[279]; ?>" onMouseOver="lmoimg('pa',img1)" onMouseOut="lmoimg('pa',img0)"><img src="lmo-admin0.gif" name="ximgpa" width="7" height="7" border="0"></a></td></tr><tr><td><a href="javascript:lmoanzspauf('xanzsp',-1);" title="<?PHP echo $text[279]; ?>" onMouseOver="lmoimg('pb',img3)" onMouseOut="lmoimg('pb',img2)"><img src="lmo-admin2.gif" name="ximgpb" width="7" height="7" border="0"></a></td></tr></table></td>
    </tr></table></acronym></td>
  </tr>
<?PHP }else{ ?>
  <tr>
    <td class="lmost5" width="20">&nbsp;</td>
    <td class="lmost5" align="right"><nobr><acronym title="<?PHP echo $text[272] ?>"><?PHP echo $text[271]; ?></acronym></nobr></td>
    <td class="lmost5"><acronym title="<?PHP echo $text[272] ?>">
      <select class="lmoadminein" name="xteams" onChange="dolmoedit()"><?PHP if($xteams==""){$xteams=16;}for($i=2;$i<129;$i=$i*2){echo "<option value=\"".$i."\""; if($xteams==$i){echo " selected";} echo ">".$i."</option>";} ?></select>
    </acronym></td>
  </tr>
  <tr>
    <td class="lmost5" width="20">&nbsp;</td>
    <td class="lmost5">&nbsp;</td>
    <td class="lmost5"></nobr><acronym title="<?PHP echo $text[272] ?>"><?PHP echo $text[350] ?></acronym></nobr></td>
  </tr>
<?PHP }} ?>

<?PHP
  if($newpage==2){
    if($xtype==0){
?>
  <tr>
    <td class="lmost5" width="20">&nbsp;</td>
    <td class="lmost5" align="right" valign="top"><nobr><acronym title="<?PHP echo $text[285] ?>"><?PHP echo $text[284]; ?></acronym></nobr></td>
    <td class="lmost5"><nobr><acronym title="<?PHP echo $text[285] ?>">
      <input type="radio" name="xprogram" value="none"<?PHP if($xprogram=="none"){echo " checked";} ?> onChange="dolmoedit()"><?PHP echo $text[286]; ?><br><br>
      <?PHP echo $text[287]; ?>:<br><?PHP $ftype=".l98"; require("lmo-adminnewdir.php"); ?><br>
      <?PHP if(($xanzsp==floor($xteams/2)) && ($xanzst==floor($xteams*($xteams-1)/$xanzsp))){ ?><input type="radio" name="xprogram" value="random"<?PHP if($xprogram=="random"){echo " checked";} ?> onChange="dolmoedit()"><?PHP echo $text[288]; ?><?PHP } ?>
    </acronym></nobr></td>
  </tr>
<?PHP
    }
  else{
    for($i=1;$i<=$xanzst;$i++){
?>
  <tr>
    <td class="lmost5" width="20">&nbsp;</td>
    <td class="lmost5" align="right"><nobr><acronym title="<?PHP echo $text[352] ?>"><?PHP echo $text[351]." ".$i; ?></acronym></nobr></td>
    <td class="lmost5"><acronym title="<?PHP echo $text[352] ?>"><select class="lmoadminein" name="xmod<?PHP echo $i; ?>" onChange="dolmoedit()">
<?PHP
echo "<option value=\"1\"";if($xmodus[$i-1]==1){echo " selected";}echo ">".$text[353]."</option>";
echo "<option value=\"2\"";if($xmodus[$i-1]==2){echo " selected";}echo ">".$text[354]."</option>";
echo "<option value=\"3\"";if($xmodus[$i-1]==3){echo " selected";}echo ">".$text[355]."</option>";
echo "<option value=\"5\"";if($xmodus[$i-1]==5){echo " selected";}echo ">".$text[356]."</option>";
echo "<option value=\"7\"";if($xmodus[$i-1]==7){echo " selected";}echo ">".$text[357]."</option>";
?>
    </select></acronym></td>
  </tr>
<?PHP }}} ?>

<?PHP if($newpage<3){ ?>
  <tr>
    <td class="lmost4" colspan="2">
      <a href="<?PHP echo $PHP_SELF; ?>" onclick="return siklmolink(this.href);" title="<?PHP echo $text[248]; ?>"><?PHP echo $text[247]; ?></a>
    </td>
<?PHP if($newpage<2){ ?>
    <td class="lmost4" align="right">
      <acronym title="<?PHP echo $text[261]; ?>"><input class="lmoadminbut" type="submit" name="best" value="<?PHP echo $text[260]; ?>"></acronym>
    </td>
<?PHP }else{ ?>
    <td class="lmost4" align="right">
      <acronym title="<?PHP echo $text[290]; ?>"><input class="lmoadminbut" type="submit" name="best" value="<?PHP echo $text[289]; ?>"></acronym>
    </td>
<?PHP } ?>
  </tr>
  </form>
<?PHP } ?>

<?PHP if($newpage==3){ ?>
  <tr>
    <td class="lmost5" width="20">&nbsp;</td>
    <td class="lmost5" colspan="2"><nobr>&nbsp;<br><?PHP echo $text[291]; ?><br>&nbsp;</nobr></td>
  </tr>
  <tr>
    <td class="lmost4" colspan="3" align="right"><nobr>
          <a href="<?PHP echo $PHP_SELF."?action=admin&amp;todo=edit&amp;st=-2&amp;file=".$file; ?>" title="<?PHP echo $text[293]; ?>"><?PHP echo $text[292]; ?></a>
    </nobr></td>
  </tr>
<?PHP } ?>

  </table></td></tr>
</table>