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
if ($file!="") {
  require_once(PATH_TO_LMO."/lmo-openfile.php");
  $show=isset($_REQUEST['show'])?$_REQUEST['show']:0;
  $save=isset($_POST['save'])?$_POST['save']:0;
  if ($save==1) {
    switch ($show) {
      case 0:
        if ($_SESSION['lmouserok']==2 || $_SESSION['lmouserokerweitert']==1) {
          $titel=isset($_POST["xtitel"])?trim($_POST["xtitel"]):$titel;
          if ($titel=="") {$titel="No Name";}
          $goalfaktor=isset($_POST["xgoalfaktor"]) && is_numeric($_POST["xgoalfaktor"])?$_POST["xgoalfaktor"]:$goalfaktor;
          $pointsfaktor=isset($_POST["xpointsfaktor"]) && is_numeric($_POST["xpointsfaktor"])?$_POST["xpointsfaktor"]:$pointsfaktor;
        }
        $favteam=isset($_POST["xfavteam"])?trim($_POST["xfavteam"]):$favteam;
        $selteam=isset($_POST["xselteam"])?trim($_POST["xselteam"]):$selteam;
        if ($lmtype==1) {
          $playoffmode=isset($_POST["xplayoffmode"]) && is_numeric($_POST["xplayoffmode"])?$_POST["xplayoffmode"]:$playoffmode;
        }
        if ($lmtype==0) {
          $stat1=isset($_POST["xstat1"])?trim($_POST["xstat1"]):$stat1;
          $stat2=isset($_POST["xstat2"])?trim($_POST["xstat2"]):$stat2;
          $namepkt=isset($_POST["xnamepkt"])?trim($_POST["xnamepkt"]):$namepkt;
          if ($namepkt==$orgpkt) {$namepkt="";}
          $nametor=isset($_POST["xnametor"])?trim($_POST["xnametor"]):$nametor;
          if ($nametor==$orgtor) {$nametor="";}
        }
        break;
      case 2:
        if ($_SESSION['lmouserok']==2 || $_SESSION['lmouserokerweitert']==1) {
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
          if ($einspieler==1) {
            $mittore=isset($_POST["xmittore"])?1:0;
          }
          $datc=isset($_POST["xdatc"])?1:0;
          if (($dats==0) && ($datm==0)) {$datc=0;}
          if ($lmtype==0) {
            $onrun=isset($_POST["xonrun"])?$_POST["xonrun"]:$onrun;
            $kurve=isset($_POST["xkurve"])?1:0;
            $kreuz=isset($_POST["xkreuz"])?1:0;
            if ($tabonres==0) {
              $tabelle=isset($_POST["xtabelle"])?1:0;
            }
            $ligastats=isset($_POST["xligastats"])?1:0;
          } else {
            $klfin=isset($_POST["xklfin"])?1:0;
            $playdown=isset($_POST["xplaydown"])?1:0;
            $playoffmode=isset($_POST["xplayoffmode"])?$_POST["xplayoffmode"]:$playoffmode;
          }

          $urlt=isset($_POST["xurlt"])?1:0;
          $urlb=isset($_POST["xurlb"])?1:0;
        }
        break;
      case 3:
        if (($_SESSION['lmouserok']==2  || $_SESSION['lmouserokerweitert']==1) && $lmtype==0) {
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
        if (($_SESSION['lmouserok']==2  || $_SESSION['lmouserokerweitert']==1) && $lmtype==0) {
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
    <td align="center" colspan="2"><h1><?php echo $titel?></h1></td>
  </tr>
  <tr>
    <td valign="top">
      <table class="lmoMenu" cellspacing="0" cellpadding="0" border="0">
        <tr><td align="right"><?php if ($show==0) {echo $text[183];} else {?><a onclick="return chklmolink();" href="<?php echo $_SERVER['PHP_SELF']."?action=admin&amp;todo=edit&amp;show=0&amp;file=$file&amp;st=-1";?>"><?php echo $text[183];?></a><?php }?></td></tr><?php
  if ($_SESSION['lmouserok']==2 || $_SESSION['lmouserokerweitert']==1) {?>
        <tr><td align="right"><?php if ($show==2) {echo $text[250];} else {?><a onclick="return chklmolink();" href="<?php echo $_SERVER['PHP_SELF']."?action=admin&amp;todo=edit&amp;show=2&amp;file=$file&amp;st=-1";?>"><?php echo $text[250];?></a><?php }?></td></tr><?php
    if ($lmtype==0) {?>
        <tr><td align="right"><?php if ($show==3) {echo $text[178];} else {?><a onclick="return chklmolink();" href="<?php echo $_SERVER['PHP_SELF']."?action=admin&amp;todo=edit&amp;show=3&amp;file=$file&amp;st=-1";?>"><?php echo $text[178];?></a><?php }?></td></tr>
        <tr><td align="right"><?php if ($show==4) {echo $text[16];} else {?><a onclick="return chklmolink();" href="<?php echo $_SERVER['PHP_SELF']."?action=admin&amp;todo=edit&amp;show=4&amp;file=$file&amp;st=-1";?>"><?php echo $text[16];?></a><?php }?></td></tr>
        <tr><td align="right"><a href='<?php echo "$addr-3"?>' onclick="return chklmolink();" title="<?php echo $text[339]?>"><?php echo $text[338]?></a></td></tr><?php
    }
  }?>
      </table>
    </td>
    <td align="center" valign="top">
      <form name="lmoedit" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post" onSubmit="return chklmopass()">
        <input type="hidden" name="action" value="admin">
        <input type="hidden" name="todo" value="edit">
        <input type="hidden" name="save" value="1">
        <input type="hidden" name="show" value="<?php echo $show?>">
        <input type="hidden" name="file" value="<?php echo $file; ?>">
        <input type="hidden" name="st" value="<?php echo $st; ?>">
        <table class="lmoInner" cellspacing="0" cellpadding="0" border="0"><?php
  if ($show==0) {
    if ($_SESSION['lmouserok']==2 || $_SESSION['lmouserokerweitert']==1) { ?>
          <tr>
            <td class="nobr" align="right"><input class="lmo-formular-input" type="text" name="xtitel" size="40" maxlength="60" value="<?php echo $titel; ?>" onChange="dolmoedit()"></td>
            <td class="nobr" align="left"><acronym title="<?php echo $text[118];?>"><?php echo $text[113];?></acronym></td>
          </tr>
<?php
      if ($lmtype==0) { ?>
          <tr>
            <td class="nobr" align="right"><input class="lmo-formular-input" type="text" name="xnamepkt" size="7" maxlength="60" value="<?php if ($namepkt=="") {echo $text[37];} else {echo $namepkt;} ?>" onChange="dolmoedit()"></td>
            <td class="nobr" align="left"><acronym title="<?php echo $text[66];?>"><?php echo $text[65]." ".$text[37];?></acronym></td>
          </tr>
          <tr>
            <td class="nobr" align="right"><input class="lmo-formular-input" type="text" name="xnametor" size="7" maxlength="60" value="<?php if ($nametor=="") {echo $text[38];} else {echo $nametor;} ?>" onChange="dolmoedit()"></td>
            <td class="nobr" align="left"><acronym title="<?php echo $text[66];?>"><?php echo $text[65]." ".$text[38];?></acronym></td>
          </tr><?php
      }?>
          <tr>
            <td class="nobr" align="right">
              <select class="lmo-formular-input" name="xpointsfaktor" size="1" onChange="dolmoedit()">
                <option value="1"<?php if ($pointsfaktor==1) echo " selected";?>><?php echo $text[553]?></option>
                <option value="10"<?php if ($pointsfaktor==10) echo " selected";?>><?php echo $text[554]?></option>
                <option value="100"<?php if ($pointsfaktor==100) echo " selected";?>><?php echo $text[555]?></option>
                <option value="1000"<?php if ($pointsfaktor==1000) echo " selected";?>><?php echo $text[556]?></option>
              </select>
            </td>
            <td class="nobr" align="left"><acronym title="<?php echo $text[558];?>"><?php echo $text[557];?> <?php echo $text[37];?></acronym></td>
          </tr>
          <tr>
            <td class="nobr" align="right">
              <select class="lmo-formular-input" name="xgoalfaktor" size="1" onChange="dolmoedit()">
                <option value="1"<?php if ($goalfaktor==1) echo " selected";?>><?php echo $text[553]?></option>
                <option value="10"<?php if ($goalfaktor==10) echo " selected";?>><?php echo $text[554]?></option>
                <option value="100"<?php if ($goalfaktor==100) echo " selected";?>><?php echo $text[555]?></option>
                <option value="1000"<?php if ($goalfaktor==1000) echo " selected";?>><?php echo $text[556]?></option>
              </select>
            </td>
            <td class="nobr" align="left"><acronym title="<?php echo $text[558];?>"><?php echo $text[557];?> <?php echo $text[38];?></acronym></td>
          </tr><?php
    }?>
          <tr>
            <td class="nobr" align="right">
              <select class="lmo-formular-input" name="xfavteam" onChange="dolmoedit()"><?php
    for ($y=0;$y<=$anzteams;$y++) {?>
                <option value="<?php echo $y?>"<?php if ($y==$favteam) {echo " selected";}?>><?php echo $teams[$y]?></option><?php
    }?>
              </select>
            </td>
            <td class="nobr" align="left"><acronym title="<?php echo $text[190];?>"><?php echo $text[189];?></acronym></td>
          </tr>
          <tr>
            <td class="nobr" align="right">
              <select class="lmo-formular-input" name="xselteam" onChange="dolmoedit()"><?php
    for ($y=0;$y<=$anzteams;$y++) {?>
                <option value="<?php echo $y?>"<?php if ($y==$selteam) {echo " selected";}?>><?php echo $teams[$y]?></option><?php
    }?>
              </select>
            </td>
            <td class="nobr" align="left"><acronym title="<?php echo $text[195];?>"><?php echo $text[194];?></acronym></td>
          </tr><?php    if ($lmtype==0) { ?>
          <tr>
            <td class="nobr" align="right">
              <select class="lmo-formular-input" name="xstat1" onChange="dolmoedit()"><?php
      for ($y=0;$y<=$anzteams;$y++) {?>
                <option value="<?php echo $y?>"<?php if ($y==$stat1) {echo " selected";}?>><?php echo $teams[$y]?></option><?php
      }?>
              </select>
            </td>
            <td class="nobr" align="left" rowspan="2"><acronym title="<?php echo $text[197];?>"><?php echo $text[196];?></acronym></td>
          </tr>
          <tr>
            <td class="nobr" align="right"><select class="lmo-formular-input" name="xstat2" onChange="dolmoedit()"><?php
      for ($y=0;$y<=$anzteams;$y++) {?>
                <option value="<?php echo $y?>"<?php if ($y==$stat2) {echo " selected";}?>><?php echo $teams[$y]?></option><?php
      }?>
              </select>
            </td>
          </tr><?php    }
  } elseif ($show==2) {
    if ($_SESSION['lmouserok']==2 || $_SESSION['lmouserokerweitert']==1) { ?>
          <tr>
            <td class="nobr" align="right"><acronym title="<?php echo $text[570];?>"><?php echo $text[569];?></acronym></td>
            <td class="nobr" align="left"><input type="checkbox" class="lmo-formular-input" name="xenablegamesort" onChange="dolmoedit()"<?php if ($enablegamesort==1) {echo " checked";}?>></td>
          </tr><?php
      if ($lmtype==1) { ?>
          <tr>
            <td class="nobr" align="right"><acronym title="<?php echo $text[418];?>"><?php echo $text[417];?></acronym></td>
            <td class="nobr" align="left"><input type="checkbox" class="lmo-formular-input" name="xklfin" onChange="dolmoedit()"<?php if ($klfin==1) {echo " checked";}?>></td>
          </tr>
          <tr>
            <td class="nobr" align="right"><acronym title="<?php echo $text[552];?>"><?php echo $text[551];?></acronym></td>
            <td class="nobr" align="left"><input type="checkbox" class="lmo-formular-input" name="xplaydown" onChange="dolmoedit()"<?php if ($playdown==1) {echo " checked";}?>></td>
          </tr><?php      }
      if ($lmtype==0) { ?>
          <tr>
            <td class="nobr" align="right"><acronym title="<?php echo $text[400];?>"><?php echo $text[399];?></acronym>&nbsp;</td>
            <td class="nobr" align="left">
              <select class="lmo-formular-input" name="xonrun" onChange="dolmoedit()">
                <option value="0"<?php if ($ergebnis == '0')  {echo " disabled";} elseif ($onrun==0) {echo " selected";}?>><?php echo $text[10]?></option>
                <option value="1"<?php if ($tabelle == '0')   {echo " disabled";} elseif ($onrun==1) {echo " selected";}?>><?php echo $text[16]?></option>
                <option value="2"<?php if ($plan == '0')      {echo " disabled";} elseif ($onrun==2) {echo " selected";}?>><?php echo $text[12]?></option>
                <option value="3"<?php if ($kreuz == '0')     {echo " disabled";} elseif ($onrun==3) {echo " selected";}?>><?php echo $text[14]?></option>
                <option value="4"<?php if ($kurve == '0')     {echo " disabled";} elseif ($onrun==4) {echo " selected";}?>><?php echo $text[133]?></option>
                <option value="5"<?php if ($ligastats == '0') {echo " disabled";} elseif ($onrun==5) {echo " selected";}?>><?php echo $text[18]?></option>
                <option value="6"<?php if ($dats == '0')      {echo " disabled";} elseif ($onrun==6) {echo " selected";}?>><?php echo $text[140]?></option>
                <option value="7"<?php if ($mittore == '0')   {echo " disabled";} elseif ($onrun==7) {echo " selected";}?>><?php echo $text[485]?></option>
              </select>
            </td>
          </tr><?php      }?>
          <tr>
            <td class="nobr" align="right"><acronym title="<?php echo $text[254];?>"><?php echo $text[253];?></acronym>&nbsp;</td>
            <td class="nobr" align="left"><input type="checkbox" class="lmo-formular-input" name="xdatm" onChange="dolmoedit()"<?php if ($datm==1) {echo " checked";}?>></td>
          </tr>
          <tr>
            <td class="nobr" rowspan="2" align="right"><acronym title="<?php echo $text[256];?>"><?php echo $text[257];?></acronym>&nbsp;</td>
            <td class="nobr" align="left">
              <input type="radio" name="xdatfselect" value="1" checked>
              <select class="lmo-formular-input" name="xdatf" onChange="dolmoedit();document.getElementsByName('xdatfselect')[0].checked=true;"><?php
      $dummf=array("d.m. H:i", "d.m.Y H:i", "D., d.m. H:i", "l, d.m. H:i", "D., d.m.Y H:i", "l, d.m.Y H:i");?>
                <option value="">__</option><?php
      for ($y=0;$y<count($dummf);$y++) {?>
                <option value="<?php echo $dummf[$y]?>"<?php if ($datf==$dummf[$y]) {echo " selected";}?>><?php echo date($dummf[$y], time())?></option><?php
      }?>
              </select>
            </td>
          </tr>
          <tr>
            <td class="nobr" align="left">
              <input type="radio" name="xdatfselect" value=""<?php if (!in_array($datf,$dummf)) echo " checked";?>>
              <input type="text" class="lmo-formular-input" name="xdatf2" onChange="dolmoedit();document.getElementsByName('xdatf')[1].checked=true;" value="<?php echo $datf?>">
              <a href="https://www.php.net/manual/de/datetime.format.php">
                <span class="popup">
                  <strong><?php echo $text[545];?></strong><br>
                  D = <?php echo date("D", time());?><br>
                  l = <?php echo date("l", time());?><br>
                  <strong><?php echo $text[546];?></strong><br>
                  d = <?php echo date("d", time());?><br>
                  j = <?php echo date("j", time());?><br>
                  <strong><?php echo $text[547];?></strong><br>
                  m = <?php echo date("m", time());?><br>
                  M = <?php echo date("M", time());?><br>
                  F = <?php echo date("F", time());?><br>
                  <strong><?php echo $text[548];?></strong><br>
                  y = <?php echo date("y", time());?><br>
                  Y = <?php echo date("Y", time());?><br>
                  <strong><?php echo $text[549];?></strong><br>
                  H = <?php echo date("H", time());?><br>
                  i = <?php echo date("i", time());?><br>
                  A = <?php echo date("A", time());?><br>
                </span>
              ?</a>
            </td>
          </tr>
          <tr>
            <td class="nobr" align="right"><acronym title="<?php echo $text[252];?>"><?php echo $text[251];?></acronym>&nbsp;<input type="checkbox" class="lmo-formular-input" name="xdats" onChange="dolmoedit()"<?php if ($dats==1) {echo " checked";}?>>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr><?php
      if ($lmtype==0 && $tabonres==0) { ?>
            <td class="nobr" align="right"><acronym title="<?php echo $text[512];?>"><?php echo $text[10];?></acronym>&nbsp;<input type="checkbox" class="lmo-formular-input" name="xergebnis" onChange="dolmoedit()"<?php if ($ergebnis==1) {echo " checked";}?>>&nbsp;</td>
            <td class="nobr" align="left">&nbsp;<input type="checkbox" class="lmo-formular-input" name="xtabelle" onChange="dolmoedit()"<?php if ($tabelle==1) {echo " checked";}?>>&nbsp;<acronym title="<?php echo $text[513];?>"><?php echo $text[16];?></acronym></td><?php
      }
      if ($lmtype==1) { ?>
            <td class="nobr" align="right"><acronym title="<?php echo $text[512];?>"><?php echo $text[10];?></acronym>&nbsp;<input type="checkbox" class="lmo-formular-input" name="xergebnis" onChange="dolmoedit()"<?php if ($ergebnis==1) {echo " checked";}?>>&nbsp;</td>
            <td></td><?php
      }
      if ($lmtype==0 && $tabonres>=1) { ?>
            <td class="nobr" align="right"><acronym title="<?php echo $text[512];?>"><?php echo $text[10].'/'.$text[16];?></acronym>&nbsp;<input type="checkbox" class="lmo-formular-input" name="xergebnis" onChange="dolmoedit()"<?php if ($ergebnis==1) {echo " checked";}?>>&nbsp;</td>
            <td></td><?php
      }?>
          </tr>
          <tr>
            <td class="nobr" align="right"><acronym title="<?php echo $text[256];?>"><?php echo $text[255];?></acronym>&nbsp;<input type="checkbox" class="lmo-formular-input" name="xdatc" onChange="dolmoedit()"<?php if ($datc==1) {echo " checked";}?>>&nbsp;</td>
            <td class="nobr" align="left">&nbsp;<input type="checkbox" class="lmo-formular-input" name="xplan" onChange="dolmoedit()"<?php if ($plan==1) {echo " checked";}?>>&nbsp;<acronym title="<?php echo $text[511];?>"><?php echo $text[12];?></acronym></td>
          </tr><?php      if ($lmtype==0) { ?>
          <tr>
            <td class="nobr" align="right"><acronym title="<?php echo $text[468];?>"><?php echo $text[467];?></acronym>&nbsp;<input type="checkbox" class="lmo-formular-input" name="xkreuz" onChange="dolmoedit()"<?php if ($kreuz==1) {echo " checked";}?>>&nbsp;</td>
            <td class="nobr" align="left">&nbsp;<input type="checkbox" class="lmo-formular-input" name="xkurve" onChange="dolmoedit()"<?php if ($kurve==1) {echo " checked";}?>>&nbsp;<acronym title="<?php echo $text[238];?>"><?php echo $text[237];?></acronym></td>
          </tr><?php
      }?>
          <tr><?php
      if ($einspieler==1) {?>
            <td class="nobr" align="right"><acronym title="<?php echo $text['spieler'][19];?>"><?php echo $text['spieler'][18];?></acronym>&nbsp;<input type="checkbox" class="lmo-formular-input" name="xmittore" onChange="dolmoedit()"<?php if ($mittore==1) {echo " checked";}?>>&nbsp;</td><?php
      } else {?>
            <td></td><?php
      }
      if ($lmtype==0) { ?>
            <td class="nobr" align="left">&nbsp;<input type="checkbox" class="lmo-formular-input" name="xligastats" onChange="dolmoedit()"<?php if ($ligastats==1) {echo " checked";}?>>&nbsp;<acronym title="<?php echo $text[514];?>"><?php echo $text[18];?></acronym></td><?php
      } else {?>
            <td></td><?php
      }?>
          </tr>
          <tr>
            <th align="left" colspan="2"><?php echo $text[264];?></th>
          </tr>
          <tr>
            <td class="nobr" align="right"><input type="checkbox" class="lmo-formular-input" name="xurlt" onChange="dolmoedit()"<?php if ($urlt==1) {echo " checked";}?>></td>
            <td class="nobr" align="left"><acronym title="<?php echo $text[268];?>"><?php echo $text[267];?></acronym></td>
          </tr>
          <tr>
            <td class="nobr" align="right"><input type="checkbox" class="lmo-formular-input" name="xurlb" onChange="dolmoedit()"<?php if ($urlb==1) {echo " checked";}?>></td>
            <td class="nobr" align="left"><acronym title="<?php echo $text[266];?>"><?php echo $text[265];?></acronym></td>
          </tr><?php
    }
    if ($lmtype==1) { ?>
          <tr>
            <th align="left" colspan="2"><?php echo $text[800];?></th>
          </tr>
          <tr>
            <td class="nobr" align="center" colspan="2"></td>
          </tr>
          <tr>
            <th align="center"><?php echo $text[355];?></th>
            <td class="nobr" align="center" rowspan="3"></td>
          </tr>
          <tr>
            <td class="nobr" align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<acronym title="<?php echo $text[802];?>"><?php echo $text[801];?></acronym><hr></td>
          </tr>
          <tr>
            <th align="center"><?php echo $text[356];?></th>
          </tr>
          <tr>
            <td class="nobr" align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<acronym title="<?php echo $text[802];?>"><?php echo $text[801];?></acronym></td>
            <th align="center"><?php echo $text[809];?></th>
          </tr>
          <tr>
            <td class="nobr" align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<acronym title="<?php echo $text[804];?>"><?php echo $text[803];?></acronym><hr></td>
            <td class="nobr" valign="top" align="center" rowspan="5">
              <select class="form-select" name="xplayoffmode" onChange="dolmoedit()">
                <option value="0"<?php if ($playoffmode==0) echo " selected";?>><?php echo $text[801]?></option>
                <option value="1"<?php if ($playoffmode==1) echo " selected";?>><?php echo $text[803]?></option>
                <option value="2"<?php if ($playoffmode==2) echo " selected";?>><?php echo $text[805]?></option>
                <option value="3"<?php if ($playoffmode==3) echo " selected";?>><?php echo $text[807]?></option>
              </select></td>
          </tr>
          <tr>
            <th align="center"><?php echo $text[357];?></th>
          </tr>
          <tr>
            <td class="nobr" align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<acronym title="<?php echo $text[802];?>"><?php echo $text[801];?></acronym></td>
          </tr>
          <tr>
            <td class="nobr" align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<acronym title="<?php echo $text[806];?>"><?php echo $text[805];?></acronym></td>
          </tr>
          <tr>
            <td class="nobr" align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<acronym title="<?php echo $text[808];?>"><?php echo $text[807];?></acronym></td>
          </tr><?php
    }
  } elseif ($show==3) {
    if (($_SESSION['lmouserok']==2  || $_SESSION['lmouserokerweitert']==1) && $lmtype==0) { ?>
          <tr>
            <td class="nobr" align="right"><input type="checkbox" class="lmo-formular-input" name="xminus" onChange="dolmoedit()"<?php if ($minus==2) {echo " checked";}?>>&nbsp;</td>
            <td class="nobr" align="left">&nbsp;<acronym title="<?php echo $text[180];?>"><?php echo $text[179];?></acronym></td>
          </tr>
          <tr>
            <td class="nobr" align="right"><input type="checkbox" class="lmo-formular-input" name="xspez" onChange="dolmoedit()"<?php if ($spez==1) {echo " checked";}?>>&nbsp;</td>
            <td class="nobr" align="left">&nbsp;<acronym title="<?php echo $text[185];?>"><?php echo $text[184];?></acronym></td>
          </tr>
          <tr>
            <td class="nobr" align="right"><input type="checkbox" class="lmo-formular-input" name="xhidr" onChange="dolmoedit()"<?php if ($hidr==1) {echo " checked";}?>>&nbsp;</td>
            <td class="nobr" align="left">&nbsp;<acronym title="<?php echo $text[242];?>"><?php echo $text[241];?></acronym></td>
          </tr>
          <tr>
            <td class="nobr" align="right"><input type="checkbox" class="lmo-formular-input" name="xdirekt" onChange="dolmoedit()"<?php if ($direkt==1) {echo " checked";}?>>&nbsp;</td>
            <td class="nobr" align="left">&nbsp;<acronym title="<?php echo $text[187];?>"><?php echo $text[186];?></acronym></td>
          </tr>
          <tr>
            <td class="nobr" align="right"><input type="checkbox" class="lmo-formular-input" name="xkegel" onChange="dolmoedit()"<?php if ($kegel==1) {echo " checked";}?>>&nbsp;</td>
            <td class="nobr" align="left">&nbsp;<acronym title="<?php echo $text[396];?>"><?php echo $text[395];?></acronym></td>
          </tr>
          <tr>
            <td class="nobr" align="right"><input type="checkbox" class="lmo-formular-input" name="xhands" onChange="dolmoedit()"<?php if ($hands==1) {echo " checked";}?>>&nbsp;</td>
            <td class="nobr" align="left">&nbsp;<acronym title="<?php echo $text[408];?>"><?php echo $text[407];?></acronym></td>
          </tr>
          <tr>
            <th align="left" colspan="2"><?php echo $text[198];?></th>
          </tr>
          <tr>
            <td class="nobr" colspan="2" align="left">
              <table cellspacing="0" cellpadding="0" border="0">
                <tr>
                  <td class="nobr" align="left">&nbsp;</td>
                  <th class="nobr" align="center">&nbsp;<acronym title="<?php echo $text[199];?>"><?php echo $text[34];?></acronym>&nbsp;</th>
                  <th class="nobr" align="center">&nbsp;<acronym title="<?php echo $text[200];?>"><?php echo $text[35];?></acronym>&nbsp;</th>
                  <th class="nobr" align="center">&nbsp;<acronym title="<?php echo $text[201];?>"><?php echo $text[36];?></acronym>&nbsp;</th>
                </tr>
                <tr>
                  <td class="nobr" align="right"><?php echo $text[202];?>&nbsp;</td>
                  <td class="nobr" align="center"><input class="lmo-formular-input" name="xpns" size="2" onChange="dolmoedit()" value=<?php echo $pns?>></td>
                  <td class="nobr" align="center"><input class="lmo-formular-input" name="xpnu" size="2" onChange="dolmoedit()" value=<?php echo $pnu?>></td>
                  <td class="nobr" align="center"><input class="lmo-formular-input" name="xpnn" size="2" onChange="dolmoedit()" value=<?php echo $pnn?>></td>
                </tr>
                <tr>
                  <td class="nobr" align="right"><?php echo $text[203];?>&nbsp;</td>
                  <td class="nobr" align="center"><input class="lmo-formular-input" name="xpxs" size="2" onChange="dolmoedit()" value=<?php echo $pxs?>></td>
                  <td class="nobr" align="center"><input class="lmo-formular-input" name="xpxu" size="2" onChange="dolmoedit()" value=<?php echo $pxu?>></td>
                  <td class="nobr" align="center"><input class="lmo-formular-input" name="xpxn" size="2" onChange="dolmoedit()" value=<?php echo $pxn?>></td>
                </tr>
                <tr>
                  <td class="nobr" align="right"><?php echo $text[204];?>&nbsp;</td>
                  <td class="nobr" align="center"><input class="lmo-formular-input" name="xpps" size="2" onChange="dolmoedit()" value=<?php echo $pps?>></td>
                  <td class="nobr" align="center"><input class="lmo-formular-input" name="xppu" size="2" onChange="dolmoedit()" value=<?php echo $ppu?>></td>
                  <td class="nobr" align="center"><input class="lmo-formular-input" name="xppn" size="2" onChange="dolmoedit()" value=<?php echo $ppn?>></td>
                </tr>
              </table>
            </td>
          </tr><?php    }
  } elseif ($show==4) {
    if ($_SESSION['lmouserok']==2 || $_SESSION['lmouserokerweitert']==1) { ?>
          <tr>
            <th align="left" colspan="2"><?php echo $text[264];?></th>
          </tr>
           <tr>
            <td class="nobr" align="right">&nbsp;<input type="checkbox" class="lmo-formular-input" name="xeinhinrueck" onChange="dolmoedit()"<?php if ($einhinrueck==1) {echo " checked";}?>>&nbsp;</td>
            <td align="left">&nbsp;<acronym title="<?php echo $text[494];?>"><?php echo $text[493];?></acronym></td>
          </tr>
           <tr>
            <td class="nobr" align="right">&nbsp;<input type="checkbox" class="lmo-formular-input" name="xeinheimausw" onChange="dolmoedit()"<?php if ($einheimausw==1) {echo " checked";}?>>&nbsp;</td>
            <td align="left">&nbsp;<acronym title="<?php echo $text[566];?>"><?php echo $text[565];?></acronym></td>
          </tr>
          <tr>
            <th align="left" colspan="2"><?php echo $text[378];?></th>
          </tr>
          <tr>
            <td class="nobr" align="right">&nbsp;<input type="checkbox" class="lmo-formular-input" name="xchamp" onChange="dolmoedit()"<?php if ($champ==1) {echo " checked";}?>>&nbsp;</td>
            <td class="lmoTabelleMeister" align="left">&nbsp;<acronym title="<?php echo $text[380];?>"><?php echo $text[379];?></acronym></td>
          </tr>
          <tr>
            <td class="nobr" align="right"><select class="lmo-formular-input" name="xanzcl" onChange="dolmoedit()"><?php
      for ($i=0;$i<9;$i++) {?>
                <option value="<?php echo $i?>"<?php if ($anzcl==$i) {echo " selected";}?>><?php echo $i?></option><?php
      }?>
              </select>&nbsp;
            </td>
            <td class="lmoTabelleCleague" align="left"><acronym title="<?php echo $text[382];?>"><?php echo $text[381];?></acronym></td>
          </tr>
          <tr>
            <td class="nobr" align="right">
              <select class="lmo-formular-input" name="xanzck" onChange="dolmoedit()"><?php
      for ($i=0;$i<5;$i++) {?>
                <option value="<?php echo $i?>"<?php if ($anzck==$i) {echo " selected";}?>><?php echo $i?></option><?php
      }?>
              </select>&nbsp;
            </td>
            <td class="lmoTabelleCleaguequali" align="left">&nbsp;<acronym title="<?php echo $text[384];?>"><?php echo $text[383];?></acronym>
          </tr>
          <tr>
            <td class="nobr" align="right">
              <select class="lmo-formular-input" name="xanzuc" onChange="dolmoedit()"><?php
      for ($i=0;$i<=$anzteams;$i++) {?>
                <option value="<?php echo $i?>"<?php if ($anzuc==$i) {echo " selected";}?>><?php echo $i?></option><?php
      }?>
              </select>&nbsp;
            </td>
            <td class="lmoTabelleUefa" align="left">&nbsp;<acronym title="<?php echo $text[386];?>"><?php echo $text[385];?></acronym></td>
          </tr>
          <tr>
            <td class="nobr" align="right">
              <select class="lmo-formular-input" name="xanzar" onChange="dolmoedit()"><?php
      for ($i=0;$i<=$anzteams;$i++) {?>
                <option value="<?php echo $i?>"<?php if ($anzar==$i) {echo " selected";}?>><?php echo $i?></option><?php
      }?>
              </select>&nbsp;
            </td>
            <td class="lmoTabelleRelegation" align="left">&nbsp;<acronym title="<?php echo $text[394];?>"><?php echo $text[393];?></acronym></td>
          </tr>
          <tr>
            <td class="nobr" align="right">
              <select class="lmo-formular-input" name="xanzab" onChange="dolmoedit()"><?php
      for ($i=0;$i<=$anzteams;$i++) {?>
                <option value="<?php echo $i?>"<?php if ($anzab==$i) {echo " selected";}?>><?php echo $i?></option><?php
      }?>
              </select>&nbsp;
            </td>
            <td class="lmoTabelleAbsteiger" align="left">&nbsp;<acronym title="<?php echo $text[388];?>"><?php echo $text[387];?></acronym></td>
          </tr><?php    }
  }?>
          <tr>
            <td class="nobr" align="center" colspan="2" width="100%">
              <input title="<?php echo $text[114];?>" class="lmo-formular-button" type="submit" name="best" value="<?php echo $text[188];?>">
            </td>
          </tr>
        </table>
      </form>
    </td>
  </tr>
</table><?php
}?>