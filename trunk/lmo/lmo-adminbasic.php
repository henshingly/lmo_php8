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
if($file!=""){
  require_once(PATH_TO_LMO."/lmo-openfile.php");
  $show=isset($_REQUEST['show'])?$_REQUEST['show']:0;
  $save=isset($_POST['save'])?$_POST['save']:0;
  if($save==1){
    switch ($show) {
      case 0:
        if($_SESSION['lmouserok']==2 || $_SESSION['lmouserokerweitert']==1){
          $titel=isset($_POST["xtitel"])?trim($_POST["xtitel"]):$titel;
          if($titel==""){$titel="No Name";}
          $goalfaktor=isset($_POST["xgoalfaktor"]) && is_numeric($_POST["xgoalfaktor"])?$_POST["xgoalfaktor"]:$goalfaktor;
          $pointsfaktor=isset($_POST["xpointsfaktor"]) && is_numeric($_POST["xpointsfaktor"])?$_POST["xpointsfaktor"]:$pointsfaktor;
        }
        $favteam=isset($_POST["xfavteam"])?trim($_POST["xfavteam"]):$favteam;
        $selteam=isset($_POST["xselteam"])?trim($_POST["xselteam"]):$selteam;
        if($lmtype==0){
          $stat1=isset($_POST["xstat1"])?trim($_POST["xstat1"]):$stat1;
          $stat2=isset($_POST["xstat2"])?trim($_POST["xstat2"]):$stat2;
          $namepkt=isset($_POST["xnamepkt"])?trim($_POST["xnamepkt"]):$namepkt;
          if($namepkt==$orgpkt){$namepkt="";}
          $nametor=isset($_POST["xnametor"])?trim($_POST["xnametor"]):$nametor;
          if($nametor==$orgtor){$nametor="";}
        }
        break;
      case 2:
        if($_SESSION['lmouserok']==2 || $_SESSION['lmouserokerweitert']==1){
          $enablegamesort=isset($_POST["xenablegamesort"])?1:0;
          $datm=isset($_POST["xdatm"])?1:0;
          if (!empty($_POST["xdatfselect"])) {
            $datf=isset($_POST["xdatf"])?$_POST["xdatf"]:$defdateformat;
          } else {
            $datf=isset($_POST["xdatf2"])?$_POST["xdatf2"]:$datf;
          }
          $dats=isset($_POST["xdats"])?1:0;
          $plan=isset($_POST["xplan"])?1:0;
          $ergebnis=isset($_POST["xergebnis"])?1:0;
          if($einspieler==1){
            $mittore=isset($_POST["xmittore"])?1:0;
          }
          $datc=isset($_POST["xdatc"])?1:0;
          if(($dats==0) && ($datm==0)){$datc=0;}
          if($lmtype==0){
            $onrun=isset($_POST["xonrun"])?$_POST["xonrun"]:$onrun;
            $kurve=isset($_POST["xkurve"])?1:0;
            $kreuz=isset($_POST["xkreuz"])?1:0;     
            if ($tabonres==0) { 
              $tabelle=isset($_POST["xtabelle"])?1:0;
            }
            $ligastats=isset($_POST["xligastats"])?1:0;
          }else{
            $klfin=isset($_POST["xklfin"])?1:0;
            $playdown=isset($_POST["xplaydown"])?1:0;
          }
          
          $urlt=isset($_POST["xurlt"])?1:0;
          $urlb=isset($_POST["xurlb"])?1:0;
        }
        break;
      case 3:
        if(($_SESSION['lmouserok']==2  || $_SESSION['lmouserokerweitert']==1) && $lmtype==0){
          $minus=isset($_POST["xminus"])?2:1;
          $spez=isset($_POST["xspez"])?1:0;
          $hidr=isset($_POST["xhidr"])?1:0;
          $direkt=isset($_POST["xdirekt"])?1:0;
          $kegel=isset($_POST["xkegel"])?1:0;
          $hands=isset($_POST["xhands"])?1:0;
          
          $pns=isset($_POST["xpns"])?trim($_POST["xpns"]):$pns;
          $pnu=isset($_POST["xpnu"])?trim($_POST["xpnu"]):$pnu;
          $pnn=isset($_POST["xpnn"])?trim($_POST["xpnn"]):$pnn;
          $pxs=isset($_POST["xpxs"])?trim($_POST["xpxs"]):$pxs;
          $pxu=isset($_POST["xpxu"])?trim($_POST["xpxu"]):$pxu;
          $pxn=isset($_POST["xpxn"])?trim($_POST["xpxn"]):$pxn;
          $pps=isset($_POST["xpps"])?trim($_POST["xpps"]):$pps;
          $ppu=isset($_POST["xppu"])?trim($_POST["xppu"]):$ppu;
          $ppn=isset($_POST["xppn"])?trim($_POST["xppn"]):$ppn;
        }
        break;
      case 4:
        if(($_SESSION['lmouserok']==2  || $_SESSION['lmouserokerweitert']==1) && $lmtype==0){
          $einhinrueck=isset($_POST["xeinhinrueck"])?1:0;
          $einheimausw=isset($_POST["xeinheimausw"])?1:0;
          $champ=isset($_POST["xchamp"])?1:0;
          $anzcl=isset($_POST["xanzcl"])?trim($_POST["xanzcl"]):$anzcl;
          $anzck=isset($_POST["xanzck"])?trim($_POST["xanzck"]):$anzck;
          $anzuc=isset($_POST["xanzuc"])?trim($_POST["xanzuc"]):$anzuc;
          $anzar=isset($_POST["xanzar"])?trim($_POST["xanzar"]):$anzar;
          $anzab=isset($_POST["xanzab"])?trim($_POST["xanzab"]):$anzab;
        }
        break;
      
    }
    require(PATH_TO_LMO."/lmo-savefile.php");
  }
  $addr=$_SERVER['PHP_SELF']."?action=admin&amp;todo=edit&amp;file=".$file."&amp;st=";
  $addb=$_SERVER['PHP_SELF']."?action=admin&amp;todo=tabs&amp;file=".$file."&amp;st=";

include(PATH_TO_LMO."/lmo-adminsubnavi.php"); 
?>

<table class="lmoMiddle" cellspacing="0" cellpadding="0" border="0">
  <tr>
    <td align="center" colspan="2"><h1><?=$titel?></h1></td>
  </tr>
  <tr>
    <td valign="top">
      <table class="lmoMenu" cellspacing="0" cellpadding="0" border="0">
        <tr><td align="right"><?if ($show==0) {echo $text[183];}else{?><a onclick="return chklmolink();" href="<?=$_SERVER['PHP_SELF']."?action=admin&amp;todo=edit&amp;show=0&amp;file=$file&amp;st=-1";?>"><?=$text[183];?></a><?}?></td></tr><?
  if ($_SESSION['lmouserok']==2 || $_SESSION['lmouserokerweitert']==1) {?>
        <tr><td align="right"><?if ($show==2) {echo $text[250];}else{?><a onclick="return chklmolink();" href="<?=$_SERVER['PHP_SELF']."?action=admin&amp;todo=edit&amp;show=2&amp;file=$file&amp;st=-1";?>"><?=$text[250];?></a><?}?></td></tr><?
    if ($lmtype==0){?>  
        <tr><td align="right"><?if ($show==3) {echo $text[178];}else{?><a onclick="return chklmolink();" href="<?=$_SERVER['PHP_SELF']."?action=admin&amp;todo=edit&amp;show=3&amp;file=$file&amp;st=-1";?>"><?=$text[178];?></a><?}?></td></tr>
        <tr><td align="right"><?if ($show==4) {echo $text[40];}else{?><a onclick="return chklmolink();" href="<?=$_SERVER['PHP_SELF']."?action=admin&amp;todo=edit&amp;show=4&amp;file=$file&amp;st=-1";?>"><?=$text[40];?></a><?}?></td></tr>
        <tr><td align="right"><a href='<?="$addr-3"?>' onclick="return chklmolink();" title="<?=$text[339]?>"><?=$text[338]?></a></td></tr><?
    }
  }?>
      </table>
    </td>
    <td align="center" valign="top">
      <form name="lmoedit" action="<?=$_SERVER['PHP_SELF'];?>" method="post" onSubmit="return chklmopass()">
        <input type="hidden" name="action" value="admin">
        <input type="hidden" name="todo" value="edit">
        <input type="hidden" name="save" value="1">
        <input type="hidden" name="show" value="<?=$show?>">
        <input type="hidden" name="file" value="<?=$file; ?>">
        <input type="hidden" name="st" value="<?=$st; ?>">
        <table class="lmoInner" cellspacing="0" cellpadding="0" border="0"><?
  if ($show==0) {
    if($_SESSION['lmouserok']==2 || $_SESSION['lmouserokerweitert']==1){ ?>
          <tr>
            <td class="nobr" align="right"><input class="lmo-formular-input" type="text" name="xtitel" size="40" maxlength="60" value="<?=$titel; ?>" onChange="dolmoedit()"></td>
            <td class="nobr" align="left"><acronym title="<?=$text[118];?>"><?=$text[113];?></acronym></td>
          </tr><? 
      if($lmtype==0){ ?>
          <tr>
            <td class="nobr" align="right"><input class="lmo-formular-input" type="text" name="xnamepkt" size="7" maxlength="60" value="<? if($namepkt==""){echo $text[37];}else{echo $namepkt;} ?>" onChange="dolmoedit()"></td>
            <td class="nobr" align="left"><acronym title="<?=$text[66];?>"><?=$text[65]." ".$text[37];?></acronym></td>
          </tr>
          <tr>
            <td class="nobr" align="right"><input class="lmo-formular-input" type="text" name="xnametor" size="7" maxlength="60" value="<? if($nametor==""){echo $text[38];}else{echo $nametor;} ?>" onChange="dolmoedit()"></td>
            <td class="nobr" align="left"><acronym title="<?=$text[66];?>"><?=$text[65]." ".$text[38];?></acronym></td>
          </tr><?
      }?>
          <tr>
            <td class="nobr" align="right">
              <select class="lmo-formular-input" name="xpointsfaktor" size="1" onChange="dolmoedit()">
                <option value="1"<?if ($pointsfaktor==1) echo " selected";?>><?=$text[553]?></option>
                <option value="10"<?if ($pointsfaktor==10) echo " selected";?>><?=$text[554]?></option>
                <option value="100"<?if ($pointsfaktor==100) echo " selected";?>><?=$text[555]?></option>
                <option value="1000"<?if ($pointsfaktor==1000) echo " selected";?>><?=$text[556]?></option>
              </select>
            </td>
            <td class="nobr" align="left"><acronym title="<?=$text[558];?>"><?=$text[557];?> <?=$text[37];?></acronym></td>
          </tr>
          <tr>
            <td class="nobr" align="right">
              <select class="lmo-formular-input" name="xgoalfaktor" size="1" onChange="dolmoedit()">
                <option value="1"<?if ($goalfaktor==1) echo " selected";?>><?=$text[553]?></option>
                <option value="10"<?if ($goalfaktor==10) echo " selected";?>><?=$text[554]?></option>
                <option value="100"<?if ($goalfaktor==100) echo " selected";?>><?=$text[555]?></option>
                <option value="1000"<?if ($goalfaktor==1000) echo " selected";?>><?=$text[556]?></option>
              </select>
            </td>
            <td class="nobr" align="left"><acronym title="<?=$text[558];?>"><?=$text[557];?> <?=$text[38];?></acronym></td>
          </tr><?
    }?>
          <tr>
            <td class="nobr" align="right">
              <select class="lmo-formular-input" name="xfavteam" onChange="dolmoedit()"><?
    for($y=0;$y<=$anzteams;$y++){?>
                <option value="<?=$y?>"<?if($y==$favteam){echo " selected";}?>><?=$teams[$y]?></option><?
    }?>
              </select>
            </td>
            <td class="nobr" align="left"><acronym title="<?=$text[190];?>"><?=$text[189];?></acronym></td>
          </tr>
          <tr>
            <td class="nobr" align="right">
              <select class="lmo-formular-input" name="xselteam" onChange="dolmoedit()"><?
    for($y=0;$y<=$anzteams;$y++){?>
                <option value="<?=$y?>"<?if($y==$selteam){echo " selected";}?>><?=$teams[$y]?></option><?
    }?>
              </select>
            </td>
            <td class="nobr" align="left"><acronym title="<?=$text[195];?>"><?=$text[194];?></acronym></td>
          </tr><? 
    if($lmtype==0){ ?>
          <tr>
            <td class="nobr" align="right">
              <select class="lmo-formular-input" name="xstat1" onChange="dolmoedit()"><?
      for($y=0;$y<=$anzteams;$y++){?>
                <option value="<?=$y?>"<?if($y==$stat1){echo " selected";}?>><?=$teams[$y]?></option><?
      }?>
              </select>
            </td>
            <td class="nobr" align="left" rowspan="2"><acronym title="<?=$text[197];?>"><?=$text[196];?></acronym></td>
          </tr>
          <tr>
            <td class="nobr" align="right"><select class="lmo-formular-input" name="xstat2" onChange="dolmoedit()"><?
      for($y=0;$y<=$anzteams;$y++){?>
                <option value="<?=$y?>"<?if($y==$stat2){echo " selected";}?>><?=$teams[$y]?></option><?
      }?>
              </select>
            </td>
            
          </tr><? 
    }
  }elseif ($show==2) {
    if($_SESSION['lmouserok']==2 || $_SESSION['lmouserokerweitert']==1){ ?>
          <tr>
            <td class="nobr" align="right"><acronym title="<?=$text[570];?>"><?=$text[569];?></acronym></td>
            <td class="nobr" align="left"><input type="checkbox" class="lmo-formular-input" name="xenablegamesort" onChange="dolmoedit()"<?if($enablegamesort==1){echo " checked";}?>></td>
          </tr><?
      if($lmtype==1){ ?>
          <tr>
            <td class="nobr" align="right"><acronym title="<?=$text[418];?>"><?=$text[417];?></acronym></td>
            <td class="nobr" align="left"><input type="checkbox" class="lmo-formular-input" name="xklfin" onChange="dolmoedit()"<?if($klfin==1){echo " checked";}?>></td>
          </tr>
          <tr>
            <td class="nobr" align="right"><acronym title="<?=$text[552];?>"><?=$text[551];?></acronym></td>
            <td class="nobr" align="left"><input type="checkbox" class="lmo-formular-input" name="xplaydown" onChange="dolmoedit()"<?if($playdown==1){echo " checked";}?>></td>
          </tr><? 
      }
      if($lmtype==0){ ?>
          <tr>
            <td class="nobr" align="right"><acronym title="<?=$text[400];?>"><?=$text[399];?></acronym>&nbsp;</td>
            <td class="nobr" align="left">
              <select class="lmo-formular-input" name="xonrun" onChange="dolmoedit()">
                <option value="0"<?if ($ergebnis == '0')  {echo " disabled";}elseif($onrun==0){echo " selected";}?>><?=$text[10]?></option>
                <option value="1"<?if ($tabelle == '0')   {echo " disabled";}elseif($onrun==1){echo " selected";}?>><?=$text[16]?></option>
                <option value="2"<?if ($plan == '0')      {echo " disabled";}elseif($onrun==2){echo " selected";}?>><?=$text[12]?></option>
                <option value="3"<?if ($kreuz == '0')     {echo " disabled";}elseif($onrun==3){echo " selected";}?>><?=$text[14]?></option>
                <option value="4"<?if ($kurve == '0')     {echo " disabled";}elseif($onrun==4){echo " selected";}?>><?=$text[133]?></option>
                <option value="5"<?if ($ligastats == '0') {echo " disabled";}elseif($onrun==5){echo " selected";}?>><?=$text[18]?></option>
                <option value="6"<?if ($dats == '0')      {echo " disabled";}elseif($onrun==6){echo " selected";}?>><?=$text[140]?></option>
                <option value="7"<?if ($mittore == '0')   {echo " disabled";}elseif($onrun==7){echo " selected";}?>><?=$text[485]?></option>
              </select>
            </td>
          </tr><? 
      }?> 
          <tr>
            <td class="nobr" align="right"><acronym title="<?=$text[254];?>"><?=$text[253];?></acronym>&nbsp;</td>
            <td class="nobr" align="left"><input type="checkbox" class="lmo-formular-input" name="xdatm" onChange="dolmoedit()"<?if($datm==1){echo " checked";}?>></td>
          </tr>
          <tr>
            <td class="nobr" rowspan="2" align="right"><acronym title="<?=$text[256];?>"><?=$text[257];?></acronym>&nbsp;</td>
            <td class="nobr" align="left">
              <input type="radio" name="xdatfselect" value="1" checked>
              <select class="lmo-formular-input" name="xdatf" onChange="dolmoedit();document.getElementsByName('xdatfselect')[0].checked=true;"><?
      $dummf=array("%d.%m. %H:%M","%d.%m.%Y %H:%M","%a. %d.%m. %H:%M","%A, %d.%m. %H:%M","%a. %d.%m.%Y %H:%M","%A, %d.%m.%Y %H:%M");?>
                <option value="">__</option><?
      for($y=0;$y<count($dummf);$y++){?>
                <option value="<?=$dummf[$y]?>"<?if($datf==$dummf[$y]){echo " selected";}?>><?=strftime($dummf[$y])?></option><?
      }?>
              </select>
            </td>
          </tr>
          <tr>
            <td class="nobr" align="left">
              <input type="radio" name="xdatfselect" value=""<?if (!in_array($datf,$dummf)) echo " checked";?>>
              <input type="text" class="lmo-formular-input" name="xdatf2" onChange="dolmoedit();document.getElementsByName('xdatf')[1].checked=true;" value="<?=$datf?>">
              <a href="http://php.net/strftime">
                <span class="popup">
                  <strong><?=$text[545];?></strong><br>
                  %a = <?=strftime("%a")?><br>
                  %A = <?=strftime("%A")?><br>
                  <strong><?=$text[546];?></strong><br>
                  %d = <?=strftime("%d")?><br>
                  %e = <?=strftime("%e")?><br>
                  <strong><?=$text[547];?></strong><br>
                  %m = <?=strftime("%m")?><br>
                  %b = <?=strftime("%b")?><br>
                  %B = <?=strftime("%B")?><br>
                  <strong><?=$text[548];?></strong><br>
                  %y = <?=strftime("%y")?><br>
                  %Y = <?=strftime("%Y")?><br><br>
                  %x = <?=strftime("%x")?><br>
                  <strong><?=$text[549];?></strong><br>
                  %H = <?=strftime("%H")?><br>
                  %M = <?=strftime("%M")?><br>
                  %R = <?=strftime("%R")?><br>
                  %r = <?=strftime("%r")?><br>
                </span>
              ?</a>
            </td>
          </tr>
          <tr>
            <td class="nobr" align="right"><acronym title="<?=$text[252];?>"><?=$text[251];?></acronym>&nbsp;<input type="checkbox" class="lmo-formular-input" name="xdats" onChange="dolmoedit()"<?if($dats==1){echo " checked";}?>>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr><?
      if($lmtype==0 && $tabonres==0){ ?>
            <td class="nobr" align="right"><acronym title="<?=$text[512];?>"><?=$text[10];?></acronym>&nbsp;<input type="checkbox" class="lmo-formular-input" name="xergebnis" onChange="dolmoedit()"<?if($ergebnis==1){echo " checked";}?>>&nbsp;</td>
            <td class="nobr" align="left">&nbsp;<input type="checkbox" class="lmo-formular-input" name="xtabelle" onChange="dolmoedit()"<?if($tabelle==1){echo " checked";}?>>&nbsp;<acronym title="<?=$text[513];?>"><?=$text[16];?></acronym></td><?
      }
      if($lmtype==1){ ?>
            <td class="nobr" align="right"><acronym title="<?=$text[512];?>"><?=$text[10];?></acronym>&nbsp;<input type="checkbox" class="lmo-formular-input" name="xergebnis" onChange="dolmoedit()"<?if($ergebnis==1){echo " checked";}?>>&nbsp;</td>
            <td></td><?
      }
      if($lmtype==0 && $tabonres>=1){ ?>
            <td class="nobr" align="right"><acronym title="<?=$text[512];?>"><?=$text[10].'/'.$text[16];?></acronym>&nbsp;<input type="checkbox" class="lmo-formular-input" name="xergebnis" onChange="dolmoedit()"<?if($ergebnis==1){echo " checked";}?>>&nbsp;</td>
            <td></td><?
      }?>
          </tr>
          <tr>
            <td class="nobr" align="right"><acronym title="<?=$text[256];?>"><?=$text[255];?></acronym>&nbsp;<input type="checkbox" class="lmo-formular-input" name="xdatc" onChange="dolmoedit()"<?if($datc==1){echo " checked";}?>>&nbsp;</td>
            <td class="nobr" align="left">&nbsp;<input type="checkbox" class="lmo-formular-input" name="xplan" onChange="dolmoedit()"<?if($plan==1){echo " checked";}?>>&nbsp;<acronym title="<?=$text[511];?>"><?=$text[12];?></acronym></td>
          </tr><? 
      if($lmtype==0){ ?>
          <tr>
            <td class="nobr" align="right"><acronym title="<?=$text[468];?>"><?=$text[467];?></acronym>&nbsp;<input type="checkbox" class="lmo-formular-input" name="xkreuz" onChange="dolmoedit()"<?if($kreuz==1){echo " checked";}?>>&nbsp;</td>
            <td class="nobr" align="left">&nbsp;<input type="checkbox" class="lmo-formular-input" name="xkurve" onChange="dolmoedit()"<?if($kurve==1){echo " checked";}?>>&nbsp;<acronym title="<?=$text[238];?>"><?=$text[237];?></acronym></td>
          </tr><?
      }?>
          <tr><?
      if($einspieler==1){?>
            <td class="nobr" align="right"><acronym title="<?=$text['spieler'][19];?>"><?=$text['spieler'][18];?></acronym>&nbsp;<input type="checkbox" class="lmo-formular-input" name="xmittore" onChange="dolmoedit()"<?if($mittore==1){echo " checked";}?>>&nbsp;</td><?
      }else{?>
            <td></td><?
      }
      if($lmtype==0){ ?>
            <td class="nobr" align="left">&nbsp;<input type="checkbox" class="lmo-formular-input" name="xligastats" onChange="dolmoedit()"<?if($ligastats==1){echo " checked";}?>>&nbsp;<acronym title="<?=$text[514];?>"><?=$text[18];?></acronym></td><?
      }else{?>
            <td></td><?
      }?>
          </tr>
          <tr>
            <th align="left" colspan="2"><?=$text[264];?></th>
          </tr>
          <tr>
            <td class="nobr" align="right"><input type="checkbox" class="lmo-formular-input" name="xurlt" onChange="dolmoedit()"<?if($urlt==1){echo " checked";}?>></td>
            <td class="nobr" align="left"><acronym title="<?=$text[268];?>"><?=$text[267];?></acronym></td>
          </tr>
          <tr>
            <td class="nobr" align="right"><input type="checkbox" class="lmo-formular-input" name="xurlb" onChange="dolmoedit()"<?if($urlb==1){echo " checked";}?>></td>
            <td class="nobr" align="left"><acronym title="<?=$text[266];?>"><?=$text[265];?></acronym></td>
          </tr><? 
    }
  }elseif ($show==3) {
    if(($_SESSION['lmouserok']==2  || $_SESSION['lmouserokerweitert']==1) && $lmtype==0){ ?>
          <tr>
            <td class="nobr" align="right"><input type="checkbox" class="lmo-formular-input" name="xminus" onChange="dolmoedit()"<?if($minus==2){echo " checked";}?>>&nbsp;</td>
            <td class="nobr" align="left">&nbsp;<acronym title="<?=$text[180];?>"><?=$text[179];?></acronym></td>
          </tr>
          <tr>
            <td class="nobr" align="right"><input type="checkbox" class="lmo-formular-input" name="xspez" onChange="dolmoedit()"<?if($spez==1){echo " checked";}?>>&nbsp;</td>
            <td class="nobr" align="left">&nbsp;<acronym title="<?=$text[185];?>"><?=$text[184];?></acronym></td>
          </tr>
          <tr>
            <td class="nobr" align="right"><input type="checkbox" class="lmo-formular-input" name="xhidr" onChange="dolmoedit()"<?if($hidr==1){echo " checked";}?>>&nbsp;</td>
            <td class="nobr" align="left">&nbsp;<acronym title="<?=$text[242];?>"><?=$text[241];?></acronym></td>
          </tr>
          <tr>
            <td class="nobr" align="right"><input type="checkbox" class="lmo-formular-input" name="xdirekt" onChange="dolmoedit()"<?if($direkt==1){echo " checked";}?>>&nbsp;</td>
            <td class="nobr" align="left">&nbsp;<acronym title="<?=$text[187];?>"><?=$text[186];?></acronym></td>
          </tr>
          <tr>
            <td class="nobr" align="right"><input type="checkbox" class="lmo-formular-input" name="xkegel" onChange="dolmoedit()"<?if($kegel==1){echo " checked";}?>>&nbsp;</td>
            <td class="nobr" align="left">&nbsp;<acronym title="<?=$text[396];?>"><?=$text[395];?></acronym></td>
          </tr>
          <tr>
            <td class="nobr" align="right"><input type="checkbox" class="lmo-formular-input" name="xhands" onChange="dolmoedit()"<?if($hands==1){echo " checked";}?>>&nbsp;</td>
            <td class="nobr" align="left">&nbsp;<acronym title="<?=$text[408];?>"><?=$text[407];?></acronym></td>
          </tr>
          <tr>
            <th align="left" colspan="2"><?=$text[198];?></th>
          </tr>
          <tr>
            <td class="nobr" colspan="2" align="left">
              <table cellspacing="0" cellpadding="0" border="0">
                <tr>
                  <td class="nobr" align="left">&nbsp;</td>
                  <th class="nobr" align="center">&nbsp;<acronym title="<?=$text[199];?>"><?=$text[34];?></acronym>&nbsp;</th>
                  <th class="nobr" align="center">&nbsp;<acronym title="<?=$text[200];?>"><?=$text[35];?></acronym>&nbsp;</th>
                  <th class="nobr" align="center">&nbsp;<acronym title="<?=$text[201];?>"><?=$text[36];?></acronym>&nbsp;</th>
                </tr>
                <tr>
                  <td class="nobr" align="right"><?=$text[202];?>&nbsp;</td>
                  <td class="nobr" align="center"><input class="lmo-formular-input" name="xpns" size="2" onChange="dolmoedit()" value=<?=$pns?>></td>
                  <td class="nobr" align="center"><input class="lmo-formular-input" name="xpnu" size="2" onChange="dolmoedit()" value=<?=$pnu?>></td>
                  <td class="nobr" align="center"><input class="lmo-formular-input" name="xpnn" size="2" onChange="dolmoedit()" value=<?=$pnn?>></td>
                </tr>
                <tr>
                  <td class="nobr" align="right"><?=$text[203];?>&nbsp;</td>
                  <td class="nobr" align="center"><input class="lmo-formular-input" name="xpxs" size="2" onChange="dolmoedit()" value=<?=$pxs?>></td>
                  <td class="nobr" align="center"><input class="lmo-formular-input" name="xpxu" size="2" onChange="dolmoedit()" value=<?=$pxu?>></td>
                  <td class="nobr" align="center"><input class="lmo-formular-input" name="xpxn" size="2" onChange="dolmoedit()" value=<?=$pxn?>></td>
                </tr>
                <tr>
                  <td class="nobr" align="right"><?=$text[204];?>&nbsp;</td>
                  <td class="nobr" align="center"><input class="lmo-formular-input" name="xpps" size="2" onChange="dolmoedit()" value=<?=$pps?>></td>
                  <td class="nobr" align="center"><input class="lmo-formular-input" name="xppu" size="2" onChange="dolmoedit()" value=<?=$ppu?>></td>
                  <td class="nobr" align="center"><input class="lmo-formular-input" name="xppn" size="2" onChange="dolmoedit()" value=<?=$ppn?>></td>
                </tr>
              </table>
            </td>
          </tr><? 
    }
  }elseif ($show==4) {
    if($_SESSION['lmouserok']==2 || $_SESSION['lmouserokerweitert']==1){ ?>
          <tr>
            <th align="left" colspan="2"><?=$text[264];?></th>
          </tr>
           <tr>
            <td class="nobr" align="right">&nbsp;<input type="checkbox" class="lmo-formular-input" name="xeinhinrueck" onChange="dolmoedit()"<?if($einhinrueck==1){echo " checked";}?>>&nbsp;</td>
            <td align="left">&nbsp;<acronym title="<?=$text[494];?>"><?=$text[493];?></acronym></td>
          </tr>
           <tr>
            <td class="nobr" align="right">&nbsp;<input type="checkbox" class="lmo-formular-input" name="xeinheimausw" onChange="dolmoedit()"<?if($einheimausw==1){echo " checked";}?>>&nbsp;</td>
            <td align="left">&nbsp;<acronym title="<?=$text[566];?>"><?=$text[565];?></acronym></td>
          </tr>
          <tr>
            <th align="left" colspan="2"><?=$text[378];?></th>
          </tr>
          <tr>
            <td class="nobr" align="right">&nbsp;<input type="checkbox" class="lmo-formular-input" name="xchamp" onChange="dolmoedit()"<?if($champ==1){echo " checked";}?>>&nbsp;</td>
            <td class="lmoTabelleMeister" align="left">&nbsp;<acronym title="<?=$text[380];?>"><?=$text[379];?></acronym></td>
          </tr>
          <tr>
            <td class="nobr" align="right"><select class="lmo-formular-input" name="xanzcl" onChange="dolmoedit()"><?
      for($i=0;$i<5;$i++){?>
                <option value="<?=$i?>"<?if($anzcl==$i){echo " selected";}?>><?=$i?></option><?
      }?>
              </select>&nbsp;
            </td>
            <td class="lmoTabelleCleague" align="left"><acronym title="<?=$text[382];?>"><?=$text[381];?></acronym></td>
          </tr>
          <tr>
            <td class="nobr" align="right">
              <select class="lmo-formular-input" name="xanzck" onChange="dolmoedit()"><?
      for($i=0;$i<5;$i++){?>
                <option value="<?=$i?>"<?if($anzck==$i){echo " selected";}?>><?=$i?></option><?
      }?>
              </select>&nbsp;
            </td>
            <td class="lmoTabelleCleaguequali" align="left">&nbsp;<acronym title="<?=$text[384];?>"><?=$text[383];?></acronym>
          </tr>
          <tr>
            <td class="nobr" align="right">
              <select class="lmo-formular-input" name="xanzuc" onChange="dolmoedit()"><?
      for($i=0;$i<=$anzteams;$i++){?>
                <option value="<?=$i?>"<?if($anzuc==$i){echo " selected";}?>><?=$i?></option><?
      }?>
              </select>&nbsp;
            </td>
            <td class="lmoTabelleUefa" align="left">&nbsp;<acronym title="<?=$text[386];?>"><?=$text[385];?></acronym></td>
          </tr>
          <tr>
            <td class="nobr" align="right">
              <select class="lmo-formular-input" name="xanzar" onChange="dolmoedit()"><?
      for($i=0;$i<=$anzteams;$i++){?>
                <option value="<?=$i?>"<?if($anzar==$i){echo " selected";}?>><?=$i?></option><?
      }?>
              </select>&nbsp;
            </td>
            <td class="lmoTabelleRelegation" align="left">&nbsp;<acronym title="<?=$text[394];?>"><?=$text[393];?></acronym></td>
          </tr>
          <tr>
            <td class="nobr" align="right">
              <select class="lmo-formular-input" name="xanzab" onChange="dolmoedit()"><?
      for($i=0;$i<=$anzteams;$i++){?>
                <option value="<?=$i?>"<?if($anzab==$i){echo " selected";}?>><?=$i?></option><?
      }?>
              </select>&nbsp;
            </td>
            <td class="lmoTabelleAbsteiger" align="left">&nbsp;<acronym title="<?=$text[388];?>"><?=$text[387];?></acronym></td>
          </tr><? 
    }
  }?>
          <tr>
            <td class="nobr" align="center" colspan="2" width="100%">
              <input title="<?=$text[114];?>" class="lmo-formular-button" type="submit" name="best" value="<?=$text[188];?>">
            </td>
          </tr>
        </table>
      </form>
    </td>
  </tr>
</table><?
}?>