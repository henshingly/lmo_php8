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
require_once(PATH_TO_LMO."/lmo-admintest.php");
if($file!=""){
  require_once(PATH_TO_LMO."/lmo-openfile.php");
  if(!isset($save)){$save=0;}
  if($save==1){
    if($_SESSION['lmouserok']==2){
      $titel=trim($_POST["xtitel"]);
      if($titel==""){$titel="No Name";}
    }
    $favteam=trim($_POST["xfavteam"]);
    $selteam=trim($_POST["xselteam"]);
    if($lmtype==0){
      $stat1=trim($_POST["xstat1"]);
      $stat2=trim($_POST["xstat2"]);
    }
    if($_SESSION['lmouserok']==2){
      if($lmtype==0){
        $minus=isset($_POST["xminus"])?2:1;
        $spez=trim($_POST["xspez"]);
        $hidr=trim($_POST["xhidr"]);
        $onrun=trim($_POST["xonrun"]);
        $direkt=trim($_POST["xdirekt"]);
        $kegel=trim($_POST["xkegel"]);
        $hands=isset($_POST["xhands"])?1:0;
        $pns=trim($_POST["xpns"]);
        $pnu=trim($_POST["xpnu"]);
        $pnn=trim($_POST["xpnn"]);
        $pxs=trim($_POST["xpxs"]);
        $pxu=trim($_POST["xpxu"]);
        $pxn=trim($_POST["xpxn"]);
        $pps=trim($_POST["xpps"]);
        $ppu=trim($_POST["xppu"]);
        $ppn=trim($_POST["xppn"]);
        $champ=trim($_POST["xchamp"]);
        $anzcl=trim($_POST["xanzcl"]);
        $anzck=trim($_POST["xanzck"]);
        $anzuc=trim($_POST["xanzuc"]);
        $anzar=trim($_POST["xanzar"]);
        $anzab=trim($_POST["xanzab"]);
        $namepkt=trim($_POST["xnamepkt"]);
        if($namepkt==$orgpkt){$namepkt="";}
        $nametor=trim($_POST["xnametor"]);
        if($nametor==$orgtor){$nametor="";}
        
        $kurve=isset($_POST["xkurve"])?1:0;
        $kreuz=isset($_POST["xkreuz"])?1:0;     
        $tabelle=isset($_POST["xtabelle"])?1:0;
        $mittore=isset($_POST["xmittore"])?1:0;
        $ligastats=isset($_POST["xligastats"])?1:0;
        }
      else{
        $klfin=trim($_POST["xklfin"]);
        }
      $plan=isset($_POST["xkurve"])?1:0;
      $ergebnis=isset($_POST["xkurve"])?1:0;
      
      $dats=trim($_POST["xdats"]);
      $datm=trim($_POST["xdatm"]);
      $datf=trim($_POST["xdatf"]);
      $datc=trim($_POST["xdatc"]);
      if(($dats==0) && ($datm==0)){$datc=0;}
      $urlt=trim($_POST["xurlt"]);
    }
    $urlb=trim($_POST["xurlb"]);
    require(PATH_TO_LMO."/lmo-savefile.php");
  }
  $addr=$_SERVER['PHP_SELF']."?action=admin&amp;todo=edit&amp;file=".$file."&amp;st=";
  $addb=$_SERVER['PHP_SELF']."?action=admin&amp;todo=tabs&amp;file=".$file."&amp;st=";
?>
<table class="lmosta" cellspacing="0" cellpadding="0" border="0">
  <tr>
    <td align="center">
      <table cellspacing="0" cellpadding="0" border="0">
        <tr><?
  for($i=1;$i<=$anzst;$i++){?>
          <td align="right"<?
    if($i<>$st){?>
              class="lmost0"><a href='<?=$addr.$i?>' onclick="return chklmolink(this.href);" title="<?=$text[9]?>"><?=$i?></a><?
    }else{?>
              class="lmost1"><?=$i?><?
    }?>
           &nbsp;</td><?
    if(($anzst>49) && (($anzst%4)==0)){
      if(($i==$anzst/4) || ($i==$anzst/2) || ($i==$anzst/4*3)){echo "</tr><tr>";}
    }elseif(($anzst>38) && (($anzst%3)==0)){
      if(($i==$anzst/3) || ($i==$anzst/3*2)){echo "</tr><tr>";}
    }elseif(($anzst>29) && (($anzst%2)==0)){
      if($i==$anzst/2){echo "</tr><tr>";}
    }
  }
?>
        <tr>
      </table>
    </td>
  </tr>
  <tr>
    <td align="center" class="lmost3">
      <form name="lmoedit" action="<? echo $_SERVER['PHP_SELF']; ?>" method="post" onSubmit="return chklmopass()">
        <input type="hidden" name="action" value="admin">
        <input type="hidden" name="todo" value="edit">
        <input type="hidden" name="save" value="1">
        <input type="hidden" name="file" value="<? echo $file; ?>">
        <input type="hidden" name="st" value="<? echo $st; ?>">
        <table class="lmostb" cellspacing="0" cellpadding="0" border="0"><?
        if($_SESSION['lmouserok']==2){ ?>
          <tr>
            <td class="lmost4" colspan="5"><? echo $text[183]; ?><script type="text/javascript">document.write('</td><td class="lmost4"><a href="#" onclick="blend(this)"><img border="0" src="img/plus.gif" alt="+" title="Sektion einblenden" width="10" height="10"></a>');</script></td>
          </tr>
          <tbody class="blend_object">
          <tr>
            <td class="lmost5" align="right"><acronym title="<? echo $text[118] ?>"><? echo $text[113]; ?></acronym></td>
            <td class="lmost5" colspan="4"><input class="lmoadminein" type="text" name="xtitel" size="40" maxlength="60" value="<? echo $titel; ?>" onChange="dolmoedit()"></td>
          </tr>
          </tbody><? 
        }?>
          <tr>
            <td class="lmost4" colspan="5"><? echo $text[264]; ?><script type="text/javascript">document.write('</td><td class="lmost4"><a href="#" onclick="blend(this)"><img border="0" src="img/plus.gif" alt="+" title="Sektion einblenden" width="10" height="10"></a>');</script></td>
          </tr><? 
        if($_SESSION['lmouserok']==2){ ?>
          <tbody class="blend_object">
          <tr>
            <td class="lmost5" align="right"><acronym title="<? echo $text[268] ?>"><? echo $text[267]; ?></acronym></td>
            <td class="lmost5"><input type="checkbox" class="lmoadminein" name="xurlt" onChange="dolmoedit()"<?if($urlt==1){echo " checked";}?>></td>
            <td class="lmost5">&nbsp;</td>
            <td class="lmost5" align="right"><input type="checkbox" class="lmoadminein" name="xurlb" onChange="dolmoedit()"<?if($urlb==1){echo " checked";}?>></td>
            <td class="lmost5"><acronym title="<? echo $text[266] ?>"><? echo $text[265]; ?></acronym></td>
          </tr>
          </tbody>
          <tr>
            <td class="lmost4" colspan="5"><? echo $text[250]; ?><script type="text/javascript">document.write('</td><td class="lmost4"><a href="#" onclick="blend(this)"><img border="0" src="img/plus.gif" alt="+" title="Sektion einblenden" width="10" height="10"></a>');</script></td>
          </tr>
          <tbody class="blend_object">
          <tr><?
          if($lmtype==1){ ?>
            <td class="lmost5" align="right"><acronym title="<? echo $text[418] ?>"><? echo $text[417]; ?></acronym></td>
            <td class="lmost5"><input type="checkbox" class="lmoadminein" name="xklfin" onChange="dolmoedit()"<?if($klfin==1){echo " checked";}?>></td>
            <td class="lmost5" colspan="3"></td><? 
          }
          if($lmtype==0){ ?>
            <td class="lmost5" align="right"><acronym title="<? echo $text[400] ?>"><? echo $text[399]; ?></acronym></td>
            <td class="lmost5" colspan="4">
              <select class="lmoadminein" name="xonrun" onChange="dolmoedit()">
                <option value="0"<?if($onrun==0){echo " selected";}?>><?=$text[10]?></option>
                <option value="1"<?if($onrun==1){echo " selected";}?>><?=$text[16]?></option>
              </select>
            </td><? 
          }?>
          </tr>
          <tr>
            <td class="lmost5" align="right"><acronym title="<? echo $text[252] ?>"><? echo $text[251]; ?></acronym></td>
            <td class="lmost5"><input type="checkbox" class="lmoadminein" name="xdats" onChange="dolmoedit()"<?if($dats==1){echo " checked";}?>></td>
            <td class="lmost5">&nbsp;</td>
            <td class="lmost5" align="right"><input type="checkbox" class="lmoadminein" name="xdatm" onChange="dolmoedit()"<?if($datm==1){echo " checked";}?>></td>
            <td class="lmost5"><acronym title="<? echo $text[254] ?>"><? echo $text[253]; ?></acronym></td>
          </tr>
          <tr>
            <td class="lmost5" align="right"><acronym title="<? echo $text[256] ?>"><? echo $text[257]; ?></acronym></td>
            <td class="lmost5" colspan="4">
              <select class="lmoadminein" name="xdatf" onChange="dolmoedit()"><?
          $dummf=array("%d.%m. %H:%M","%d.%m.%Y %H:%M","%a.%d.%m. %H:%M","%A, %d.%m. %H:%M","%a.%d.%m.%Y %H:%M","%A, %d.%m.%Y %H:%M");
          for($y=0;$y<count($dummf);$y++){?>
                <option value="<?=$dummf[$y]?>"<?if($datf==$dummf[$y]){echo " selected";}?>><?=strftime($dummf[$y])?></option><?
          }?>
              </select>
            </td>
          </tr>
          <tr><?
          if($lmtype==0 && $tabonres==0){ ?>
            <td class="lmost5" align="right"><acronym title="<? echo $text[512] ?>"><? echo $text[10]; ?></acronym></td>
            <td class="lmost5"><input type="checkbox" class="lmoadminein" name="xergebnis" onChange="dolmoedit()"<?if($ergebnis==1){echo " checked";}?>></td>
            <td class="lmost5">&nbsp;</td>
            <td class="lmost5" align="right"><input type="checkbox" class="lmoadminein" name="xdatm" onChange="dolmoedit()"<?if($datm==1){echo " checked";}?>></td>
            <td class="lmost5"><acronym title="<? echo $text[513] ?>"><? echo $text[16]; ?></acronym></td><?
          }
          if($lmtype==1){ ?>
            <td class="lmost5" align="right"><acronym title="<? echo $text[512] ?>"><? echo $text[10]; ?></acronym></td>
            <td class="lmost5"><input type="checkbox" class="lmoadminein" name="xergebnis" onChange="dolmoedit()"<?if($ergebnis==1){echo " checked";}?>></td>
            <td class="lmost5" colspan="3"></td><?
          }
          if($tabonres==1){ ?>
            <td class="lmost5" align="right"><acronym title="<? echo $text[512] ?>"><? echo $text[10].'/'.$text[16]; ?></acronym></td>
            <td class="lmost5"><input type="checkbox" class="lmoadminein" name="xergebnis" onChange="dolmoedit()"<?if($ergebnis==1){echo " checked";}?>></td>
            <td class="lmost5" colspan="3"></td><?
          }?>
          </tr>
          <tr>
            <td class="lmost5" align="right"><acronym title="<? echo $text[256] ?>"><? echo $text[255]; ?></acronym></td>
            <td class="lmost5"><input type="checkbox" class="lmoadminein" name="xdatc" onChange="dolmoedit()"<?if($datc==1){echo " checked";}?>></td>
            <td class="lmost5">&nbsp;</td>
            <td class="lmost5" align="right"><input type="checkbox" class="lmoadminein" name="xplan" onChange="dolmoedit()"<?if($plan==1){echo " checked";}?>></td>
            <td class="lmost5"><acronym title="<? echo $text[511] ?>"><? echo $text[12]; ?></acronym></td>
          </tr><? 
          if($lmtype==0){ ?>
          <tr>
            
            <td class="lmost5" align="right"><acronym title="<? echo $text[468] ?>"><? echo $text[467]; ?></acronym></td>
            <td class="lmost5"><input type="checkbox" class="lmoadminein" name="xkreuz" onChange="dolmoedit()"<?if($kreuz==1){echo " checked";}?>></td>
            <td class="lmost5">&nbsp;</td>
            <td class="lmost5" align="right"><input type="checkbox" class="lmoadminein" name="xkurve" onChange="dolmoedit()"<?if($kurve==1){echo " checked";}?>></td>
            <td class="lmost5"><acronym title="<? echo $text[238] ?>"><? echo $text[237]; ?></acronym></td>
          </tr><?
          }?>
          <tr>
            <td class="lmost5" align="right"><acronym title="<? echo $text[3019] ?>"><? echo $text[3018]; ?></acronym></td>
            <td class="lmost5"><input type="checkbox" class="lmoadminein" name="xmittore" onChange="dolmoedit()"<?if($mittore==1){echo " checked";}?>></td><?
          if($lmtype==0){ ?>
            <td class="lmost5">&nbsp;</td>
            <td class="lmost5" align="right"><input type="checkbox" class="lmoadminein" name="xligastats" onChange="dolmoedit()"<?if($ligastats==1){echo " checked";}?>></td>
            <td class="lmost5"><acronym title="<? echo $text[514] ?>"><? echo $text[18]; ?></acronym></td><?
          }else{?>
            <td class="lmost5" colspan="3"></td><?
          }?>
          </tr>
          </tbody><? 
        }?>
          <tr>
            <td class="lmost4" colspan="5"><? echo $text[193]; ?><script type="text/javascript">document.write('</td><td class="lmost4"><a href="#" onclick="blend(this)"><img border="0" src="img/plus.gif" alt="+" title="Sektion einblenden" width="10" height="10"></a>');</script></td>
          </tr>
          <tbody class="blend_object">
          <tr>
            <td class="lmost5" align="right"><acronym title="<? echo $text[190] ?>"><? echo $text[189]; ?></acronym></td>
            <td class="lmost5" colspan="4"><acronym title="<? echo $text[190] ?>">
              <select class="lmoadminein" name="xfavteam" onChange="dolmoedit()"><?
        for($y=0;$y<=$anzteams;$y++){?>
                <option value="<?=$y?>"<?if($y==$favteam){echo " selected";}?>><?=$teams[$y]?></option><?
        }?>
              </select>
            </td>
          </tr>
          <tr>
        
            <td class="lmost5" align="right"><acronym title="<? echo $text[195] ?>"><? echo $text[194]; ?></acronym></td>
            <td class="lmost5" colspan="4"><acronym title="<? echo $text[195] ?>">
              <select class="lmoadminein" name="xselteam" onChange="dolmoedit()"><?
        for($y=0;$y<=$anzteams;$y++){?>
                <option value="<?=$y?>"<?if($y==$selteam){echo " selected";}?>><?=$teams[$y]?></option><?
        }?>
              </select>
            </td>
          </tr><? 
        if($lmtype==0){ ?>
          <tr>
            <td class="lmost5" align="right"><acronym title="<? echo $text[197] ?>"><? echo $text[196]; ?></acronym></td>
            <td class="lmost5" colspan="4">
              <select class="lmoadminein" name="xstat1" onChange="dolmoedit()"><?
          for($y=0;$y<=$anzteams;$y++){?>
                <option value="<?=$y?>"<?if($y==$stat1){echo " selected";}?>><?=$teams[$y]?></option><?
          }?>
              </select><select class="lmoadminein" name="xstat2" onChange="dolmoedit()"><?
          for($y=0;$y<=$anzteams;$y++){?>
                <option value="<?=$y?>"<?if($y==$stat2){echo " selected";}?>><?=$teams[$y]?></option><?
          }?>
              </select>
            </td>
          </tr>
          </tbody><? 
          if($_SESSION['lmouserok']==2){ ?>
          <tr>
            <td class="lmost4" colspan="5"><? echo $text[62]; ?><script type="text/javascript">document.write('</td><td class="lmost4"><a href="#" onclick="blend(this)"><img border="0" src="img/plus.gif" alt="+" title="Sektion einblenden" width="10" height="10"></a>');</script></td>
          </tr>
          <tbody class="blend_object">
          <tr>
            <td class="lmost5" align="right"><acronym title="<? echo $text[66] ?>"><? echo $text[65]." ".$text[37]; ?></acronym></td>
            <td class="lmost5"><input class="lmoadminein" type="text" name="xnamepkt" size="7" maxlength="60" value="<? if($namepkt==""){echo $text[37];}else{echo $namepkt;} ?>" onChange="dolmoedit()"></acronym></td>
            <td class="lmost5" width="5%">&nbsp;</td>
            <td class="lmost5" align="right"><input class="lmoadminein" type="text" name="xnametor" size="7" maxlength="60" value="<? if($nametor==""){echo $text[38];}else{echo $nametor;} ?>" onChange="dolmoedit()"></td>
            <td class="lmost5"><acronym title="<? echo $text[66] ?>"><? echo $text[65]." ".$text[38]; ?></acronym></td>
          </tr>
          </tbody>
          <tr>
            <td class="lmost4" colspan="5"><? echo $text[178]; ?><script type="text/javascript">document.write('</td><td class="lmost4"><a href="#" onclick="blend(this)"><img border="0" src="img/plus.gif" alt="+" title="Sektion einblenden" width="10" height="10"></a>');</script></td>
          </tr>
          <tbody class="blend_object">
          <tr>
            <td class="lmost5" align="right"><acronym title="<? echo $text[180] ?>"><? echo $text[179]; ?></acronym></td>
            <td class="lmost5"><input type="checkbox" class="lmoadminein" name="xminus" onChange="dolmoedit()"<?if($minus==2){echo " checked";}?>></td>
            <td class="lmost5">&nbsp;</td>
            <td class="lmost5" align="right"><input type="checkbox" class="lmoadminein" name="xspez" onChange="dolmoedit()"<?if($spez==1){echo " checked";}?>></td>
            <td class="lmost5"><acronym title="<? echo $text[185] ?>"><? echo $text[184]; ?></acronym></td>
          </tr>
          <tr>
            <td class="lmost5" align="right"><acronym title="<? echo $text[242] ?>"><? echo $text[241]; ?></acronym></td>
            <td class="lmost5"><input type="checkbox" class="lmoadminein" name="xhidr" onChange="dolmoedit()"<?if($hidr==1){echo " checked";}?>></td>
            <td class="lmost5">&nbsp;</td>
            <td class="lmost5" align="right"><input type="checkbox" class="lmoadminein" name="xdirekt" onChange="dolmoedit()"<?if($direkt==1){echo " checked";}?>></td>
            <td class="lmost5"><acronym title="<? echo $text[187] ?>"><? echo $text[186]; ?></acronym></td>
          </tr>
          <tr>
            <td class="lmost5" align="right"><acronym title="<? echo $text[396] ?>"><? echo $text[395]; ?></acronym></td>
            <td class="lmost5"><input type="checkbox" class="lmoadminein" name="xkegel" onChange="dolmoedit()"<?if($kegel==1){echo " checked";}?>></td>
            <td class="lmost5">&nbsp;</td>
            <td class="lmost5" align="right"><input type="checkbox" class="lmoadminein" name="xhands" onChange="dolmoedit()"<?if($hands==1){echo " checked";}?>></td>
            <td class="lmost5"><acronym title="<? echo $text[408] ?>"><? echo $text[407]; ?></acronym></td>
          </tr>
          </tbody>
          <tr>
            <td class="lmost4" colspan="5"><? echo $text[378]; ?><script type="text/javascript">document.write('</td><td class="lmost4"><a href="#" onclick="blend(this)"><img border="0" src="img/plus.gif" alt="+" title="Sektion einblenden" width="10" height="10"></a>');</script></td>
          </tr>
          <tbody class="blend_object">
          <tr>
            <td class="lmost5" align="right"><acronym title="<? echo $text[380] ?>"><? echo $text[379]; ?></acronym></td>
            <td class="lmost5"><input type="checkbox" class="lmoadminein" name="xchamp" onChange="dolmoedit()"<?if($champ==1){echo " checked";}?>></td>
            <td class="lmost5">&nbsp;</td>
            <td class="lmost5" align="right">
              <select class="lmoadminein" name="xanzuc" onChange="dolmoedit()"><?
            for($i=0;$i<=$anzteams;$i++){?>
                <option value="<?=$i?>"<?if($anzuc==$i){echo " selected";}?>><?=$i?></option><?
            }?>
              </select>
            </td>
            <td class="lmost5"><acronym title="<? echo $text[386] ?>"><? echo $text[385]; ?></acronym></td>
          </tr>
          <tr>
            <td class="lmost5" align="right"><acronym title="<? echo $text[382] ?>"><? echo $text[381]; ?></acronym></td>
            <td class="lmost5">
            <select class="lmoadminein" name="xanzcl" onChange="dolmoedit()"><?
            for($i=0;$i<5;$i++){?>
                <option value="<?=$i?>"<?if($anzcl==$i){echo " selected";}?>><?=$i?></option><?
            }?>
              </select>
            </td>
            <td class="lmost5">&nbsp;</td>
            <td class="lmost5" align="right">
              <select class="lmoadminein" name="xanzar" onChange="dolmoedit()"><?
            for($i=0;$i<=$anzteams;$i++){?>
                <option value="<?=$i?>"<?if($anzar==$i){echo " selected";}?>><?=$i?></option><?
            }?>
              </select>
            </td>
            <td class="lmost5"><acronym title="<? echo $text[394] ?>"><? echo $text[393]; ?></acronym></td>
          </tr>
          <tr>
            <td class="lmost5" align="right"><acronym title="<? echo $text[384] ?>"><? echo $text[383]; ?></acronym></td>
            <td class="lmost5">
              <select class="lmoadminein" name="xanzck" onChange="dolmoedit()"><?
            for($i=0;$i<5;$i++){?>
                <option value="<?=$i?>"<?if($anzck==$i){echo " selected";}?>><?=$i?></option><?
            }?>
              </select>
            </td>
            <td class="lmost5">&nbsp;</td>
            <td class="lmost5" align="right">
              <select class="lmoadminein" name="xanzab" onChange="dolmoedit()"><?
            for($i=0;$i<=$anzteams;$i++){?>
                <option value="<?=$i?>"<?if($anzab==$i){echo " selected";}?>><?=$i?></option><?
            }?>
              </select>
            </td>
            <td class="lmost5"><acronym title="<? echo $text[388] ?>"><acronym title="<? echo $text[388] ?>"><? echo $text[387]; ?></acronym></td>
          </tr>
          </tbody>
          <tr>
            <td class="lmost4" colspan="5"><acronym title="<? echo $text[205] ?>"><? echo $text[198]; ?></acronym><script type="text/javascript">document.write('</td><td class="lmost4"><a href="#" onclick="blend(this)"><img border="0" src="img/plus.gif" alt="+" title="Sektion einblenden" width="10" height="10"></a>');</script></td>
          </tr>
          <tbody class="blend_object">
          <tr>
            <td class="lmost5" colspan="5">
              <table cellspacing="0" cellpadding="0" border="0">
                <tr>
                  <td class="lmost5">&nbsp;</td>
                  <td class="lmost5" align="center"><? echo $text[199]; ?></td>
                  <td class="lmost5" align="center"><? echo $text[200]; ?></td>
                  <td class="lmost5" align="center"><? echo $text[201]; ?></td>
                </tr>
                <tr>
                  <td class="lmost5" align="right"><? echo $text[202]; ?></td>
                  <td class="lmost5" align="center"><select class="lmoadminein" name="xpns" onChange="dolmoedit()"><? for($y=3;$y>=0;$y--){echo "<option";if($y==$pns){echo " selected";}echo ">".$y."</option>";} ?></select></td>
                  <td class="lmost5" align="center"><select class="lmoadminein" name="xpnu" onChange="dolmoedit()"><? for($y=3;$y>=0;$y--){echo "<option";if($y==$pnu){echo " selected";}echo ">".$y."</option>";} ?></select></td>
                  <td class="lmost5" align="center"><select class="lmoadminein" name="xpnn" onChange="dolmoedit()"><? for($y=3;$y>=0;$y--){echo "<option";if($y==$pnn){echo " selected";}echo ">".$y."</option>";} ?></select></td>
                </tr>
                <tr>
                  <td class="lmost5" align="right"><? echo $text[203]; ?></td>
                  <td class="lmost5" align="center"><select class="lmoadminein" name="xpxs" onChange="dolmoedit()"><? for($y=3;$y>=0;$y--){echo "<option";if($y==$pxs){echo " selected";}echo ">".$y."</option>";} ?></select></td>
                  <td class="lmost5" align="center"><select class="lmoadminein" name="xpxu" onChange="dolmoedit()"><? for($y=3;$y>=0;$y--){echo "<option";if($y==$pxu){echo " selected";}echo ">".$y."</option>";} ?></select></td>
                  <td class="lmost5" align="center"><select class="lmoadminein" name="xpxn" onChange="dolmoedit()"><? for($y=3;$y>=0;$y--){echo "<option";if($y==$pxn){echo " selected";}echo ">".$y."</option>";} ?></select></td>
                </tr>
                <tr>
                  <td class="lmost5" align="right"><? echo $text[204]; ?></td>
                  <td class="lmost5" align="center"><select class="lmoadminein" name="xpps" onChange="dolmoedit()"><? for($y=3;$y>=0;$y--){echo "<option";if($y==$pps){echo " selected";}echo ">".$y."</option>";} ?></select></td>
                  <td class="lmost5" align="center"><select class="lmoadminein" name="xppu" onChange="dolmoedit()"><? for($y=3;$y>=0;$y--){echo "<option";if($y==$ppu){echo " selected";}echo ">".$y."</option>";} ?></select></td>
                  <td class="lmost5" align="center"><select class="lmoadminein" name="xppn" onChange="dolmoedit()"><? for($y=3;$y>=0;$y--){echo "<option";if($y==$ppn){echo " selected";}echo ">".$y."</option>";} ?></select></td>
                </tr>
              </table>
            </td>
          </tr><? 
          } //lmouserok==2
        }?>
          </tbody><?
        if ($_SESSION['lmouserok']==2 && $lmtype==0){?>  
          <tr>
            <td class="lmost5" colspan="6"><a href='<?="$addr-3"?>' onclick="return chklmolink(this.href);" title="<?=$text[339]?>"><?=$text[338]?></a></td>
          </tr><?
         }?>
          <tr>
            <td class="lmost5" align="center" colspan="5" width="100%">
              <acronym title="<?=$text[114] ?>"><input class="lmoadminbut" type="submit" name="best" value="<?=$text[188]; ?>"></acronym>
            </td>
          </tr>
        </table>
      </form>
    </td>
  </tr>
  <tr>
    <td>
      <table width="100%" cellspacing="0" cellpadding="0" border="0">
        <tr><? 
  if($st!=-1){?>
          <td class="lmost2" align="center">
            <a href='<?="$addr-1"?>' onclick="return chklmolink(this.href);" title="<?=$text[100]?>"><?=$text[99]?></a>
          </td><?
  }else{?>
          <td class="lmost1" align="center"><?=$text[99]?></td><?
  }
  if($hands==1){
    if($todo!="tabs"){?>
          <td class="lmost2" align="center"><a href='<?="$addb$stx"?>' onclick="return chklmolink(this.href);" title="<?=$text[409]?>><?=$text[410]?>"</a></td><?
    }else{?>
          <td class="lmost1" align="center"><?=$text[410]?></td><?
    }
  }
  if($_SESSION['lmouserok']==2){
    if($st!=-2){?>
          <td class="lmost2" align="center"><a href='<?="$addr-2"?>' onclick="return chklmolink(this.href);" title="<?=$text[102]?>"><?=$text[101]?></a></td><?
    }else{?>
          <td class="lmost1" align="center"><?=$text[101]?></td><?
    }
  }?>
        </tr>
      </table>
    </td>
  </tr>
</table>
<script type="text/javascript">blendall();</script><? 
}?>