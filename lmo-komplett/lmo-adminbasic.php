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
require_once(PATH_TO_LMO."/lmo-admintest.php");
if($file!=""){
  require(PATH_TO_LMO."/lmo-openfile.php");
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
      $minus=trim($_POST["xminus"]);
      $spez=trim($_POST["xspez"]);
      $hidr=trim($_POST["xhidr"]);
      $onrun=trim($_POST["xonrun"]);
      $direkt=trim($_POST["xdirekt"]);
      $kegel=trim($_POST["xkegel"]);
      $hands=trim($_POST["xhands"]);
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
      $kurve=trim($_POST["xkurve"]);
      $kreuz=trim($_POST["xkreuz"]);
      }
    else{
      $klfin=trim($_POST["xklfin"]);
      }
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
    <td align="center"><table cellspacing="0" cellpadding="0" border="0"><tr>
<?PHP
  for($i=1;$i<=$anzst;$i++){
    echo "<td align=\"right\" ";
    if($i<>$st){
      echo "class=\"lmost0\"><a href='$addr$i' onclick=\"return chklmolink(this.href);\" title=\"".$text[9]."\">".$i."</a>";
      }
    else{
      echo "class=\"lmost1\">".$i;
      }
    echo "&nbsp;</td>";
    if(($anzst>49) && (($anzst%4)==0)){
      if(($i==$anzst/4) || ($i==$anzst/2) || ($i==$anzst/4*3)){echo "</tr><tr>";}
      }
    elseif(($anzst>38) && (($anzst%3)==0)){
      if(($i==$anzst/3) || ($i==$anzst/3*2)){echo "</tr><tr>";}
      }
    elseif(($anzst>29) && (($anzst%2)==0)){
      if($i==$anzst/2){echo "</tr><tr>";}
      }
    }
?>
    <tr></table></td>
  </tr>
  <tr><td align="center" class="lmost3"><table class="lmostb" cellspacing="0" cellpadding="0" border="0">

  <form name="lmoedit" action="<?PHP echo $_SERVER['PHP_SELF']; ?>" method="post" onSubmit="return chklmopass()">
  
  <input type="hidden" name="action" value="admin">
  <input type="hidden" name="todo" value="edit">
  <input type="hidden" name="save" value="1">
  <input type="hidden" name="file" value="<?PHP echo $file; ?>">
  <input type="hidden" name="st" value="<?PHP echo $st; ?>">
<?PHP if($_SESSION['lmouserok']==2){ ?>
  <tr>
    <td class="lmost4" colspan="3"><nobr><?PHP echo $text[183]; ?></nobr></td>
  </tr>
  <tr>
    <td class="lmost5" width="20">&nbsp;</td>
    <td class="lmost5" align="right"><nobr><acronym title="<?PHP echo $text[118] ?>"><?PHP echo $text[113]; ?></acronym></nobr></td>
    <td class="lmost5"><acronym title="<?PHP echo $text[118] ?>"><input class="lmoadminein" type="text" name="xtitel" size="40" maxlength="60" value="<?PHP echo $titel; ?>" onChange="dolmoedit()"></acronym></td>
  </tr>
<?PHP } ?>
  <tr>
    <td class="lmost4" colspan="3"><nobr><?PHP echo $text[264]; ?></nobr></td>
  </tr>
<?PHP if($_SESSION['lmouserok']==2){ ?>
  <tr>
    <td class="lmost5" width="20">&nbsp;</td>
    <td class="lmost5" align="right"><nobr><acronym title="<?PHP echo $text[268] ?>"><?PHP echo $text[267]; ?></acronym></nobr></td>
    <td class="lmost5"><acronym title="<?PHP echo $text[268] ?>">
      <select class="lmoadminein" name="xurlt" onChange="dolmoedit()">
      <?PHP
        echo "<option value=\"1\"";
          if($urlt==1){echo " selected";}
          echo ">".$text[181]."</option>";
        echo "<option value=\"0\"";
          if($urlt==0){echo " selected";}
          echo ">".$text[182]."</option>";
      ?>
      </select>
    </acronym></td>
  </tr>
<?PHP } ?>
  <tr>
    <td class="lmost5" width="20">&nbsp;</td>
    <td class="lmost5" align="right"><nobr><acronym title="<?PHP echo $text[266] ?>"><?PHP echo $text[265]; ?></acronym></nobr></td>
    <td class="lmost5"><acronym title="<?PHP echo $text[266] ?>">
      <select class="lmoadminein" name="xurlb" onChange="dolmoedit()">
      <?PHP
        echo "<option value=\"1\"";
          if($urlb==1){echo " selected";}
          echo ">".$text[181]."</option>";
        echo "<option value=\"0\"";
          if($urlb==0){echo " selected";}
          echo ">".$text[182]."</option>";
      ?>
      </select>
    </acronym></td>
  </tr>
<?PHP if($_SESSION['lmouserok']==2){ ?>
  <tr>
    <td class="lmost4" colspan="3"><nobr><?PHP echo $text[250]; ?></nobr></td>
  </tr>
<?PHP if($lmtype==1){ ?>
  <tr>
    <td class="lmost5" width="20">&nbsp;</td>
    <td class="lmost5" align="right"><nobr><acronym title="<?PHP echo $text[418] ?>"><?PHP echo $text[417]; ?></acronym></nobr></td>
    <td class="lmost5"><acronym title="<?PHP echo $text[418] ?>">
      <select class="lmoadminein" name="xklfin" onChange="dolmoedit()">
      <?PHP
        echo "<option value=\"1\"";
          if($klfin==1){echo " selected";}
          echo ">".$text[181]."</option>";
        echo "<option value=\"0\"";
          if($klfin==0){echo " selected";}
          echo ">".$text[182]."</option>";
      ?>
      </select>
    </acronym></td>
  </tr>
<?PHP } ?>
<?PHP if($lmtype==0){ ?>
  <tr>
    <td class="lmost5" width="20">&nbsp;</td>
    <td class="lmost5" align="right"><nobr><acronym title="<?PHP echo $text[400] ?>"><?PHP echo $text[399]; ?></acronym></nobr></td>
    <td class="lmost5"><acronym title="<?PHP echo $text[400] ?>">
      <select class="lmoadminein" name="xonrun" onChange="dolmoedit()">
      <?PHP
        echo "<option value=\"0\"";
          if($onrun==0){echo " selected";}
          echo ">".$text[10]."</option>";
        echo "<option value=\"1\"";
          if($onrun==1){echo " selected";}
          echo ">".$text[16]."</option>";
      ?>
      </select>
    </acronym></td>
  </tr>
<?PHP } ?>
  <tr>
    <td class="lmost5" width="20">&nbsp;</td>
    <td class="lmost5" align="right"><nobr><acronym title="<?PHP echo $text[252] ?>"><?PHP echo $text[251]; ?></acronym></nobr></td>
    <td class="lmost5"><acronym title="<?PHP echo $text[252] ?>">
      <select class="lmoadminein" name="xdats" onChange="dolmoedit()">
      <?PHP
        echo "<option value=\"1\"";
          if($dats==1){echo " selected";}
          echo ">".$text[181]."</option>";
        echo "<option value=\"0\"";
          if($dats==0){echo " selected";}
          echo ">".$text[182]."</option>";
      ?>
      </select>
    </acronym></td>
  </tr>
  <tr>
    <td class="lmost5" width="20">&nbsp;</td>
    <td class="lmost5" align="right"><nobr><acronym title="<?PHP echo $text[254] ?>"><?PHP echo $text[253]; ?></acronym></nobr></td>
    <td class="lmost5"><acronym title="<?PHP echo $text[254] ?>">
      <select class="lmoadminein" name="xdatm" onChange="dolmoedit()">
      <?PHP
        echo "<option value=\"1\"";
          if($datm==1){echo " selected";}
          echo ">".$text[181]."</option>";
        echo "<option value=\"0\"";
          if($datm==0){echo " selected";}
          echo ">".$text[182]."</option>";
      ?>
      </select>
    </acronym></td>
  </tr>
  <tr>
    <td class="lmost5" width="20">&nbsp;</td>
    <td class="lmost5" align="right"><nobr><acronym title="<?PHP echo $text[256] ?>"><?PHP echo $text[257]; ?></acronym></nobr></td>
    <td class="lmost5"><acronym title="<?PHP echo $text[258] ?>">
      <select class="lmoadminein" name="xdatf" onChange="dolmoedit()">
      <?PHP
        $dummf=array("%d.%m. %H:%M","%d.%m.%Y %H:%M","%a.%d.%m. %H:%M","%A, %d.%m. %H:%M","%a.%d.%m.%Y %H:%M","%A, %d.%m.%Y %H:%M");
        for($y=0;$y<count($dummf);$y++){
          echo "<option value=\"$dummf[$y]\"";
          if($datf==$dummf[$y]){echo " selected";}
          echo ">".strftime($dummf[$y])."</option>";
          }
      ?>
      </select>
    </acronym></td>
  </tr>
  <tr>
    <td class="lmost5" width="20">&nbsp;</td>
    <td class="lmost5" align="right"><nobr><acronym title="<?PHP echo $text[256] ?>"><?PHP echo $text[255]; ?></acronym></nobr></td>
    <td class="lmost5"><acronym title="<?PHP echo $text[256] ?>">
      <select class="lmoadminein" name="xdatc" onChange="dolmoedit()">
      <?PHP
        echo "<option value=\"1\"";
          if($datc==1){echo " selected";}
          echo ">".$text[181]."</option>";
        echo "<option value=\"0\"";
          if($datc==0){echo " selected";}
          echo ">".$text[182]."</option>";
      ?>
      </select>
    </acronym></td>
  </tr>
<?PHP if($lmtype==0){ ?>
  <tr>
    <td class="lmost5" width="20">&nbsp;</td>
    <td class="lmost5" align="right"><nobr><acronym title="<?PHP echo $text[468] ?>"><?PHP echo $text[467]; ?></acronym></nobr></td>
    <td class="lmost5"><acronym title="<?PHP echo $text[468] ?>">
      <select class="lmoadminein" name="xkreuz" onChange="dolmoedit()">
      <?PHP
        echo "<option value=\"1\"";
          if($kreuz==1){echo " selected";}
          echo ">".$text[181]."</option>";
        echo "<option value=\"0\"";
          if($kreuz==0){echo " selected";}
          echo ">".$text[182]."</option>";
      ?>
      </select>
    </acronym></td>
  </tr>
  <tr>
    <td class="lmost5" width="20">&nbsp;</td>
    <td class="lmost5" align="right"><nobr><acronym title="<?PHP echo $text[238] ?>"><?PHP echo $text[237]; ?></acronym></nobr></td>
    <td class="lmost5"><acronym title="<?PHP echo $text[238] ?>">
      <select class="lmoadminein" name="xkurve" onChange="dolmoedit()">
      <?PHP
        echo "<option value=\"1\"";
          if($kurve==1){echo " selected";}
          echo ">".$text[181]."</option>";
        echo "<option value=\"0\"";
          if($kurve==0){echo " selected";}
          echo ">".$text[182]."</option>";
      ?>
      </select>
    </acronym></td>
  </tr>
<?PHP } ?>
<?PHP } ?>
  <tr>
    <td class="lmost4" colspan="3"><nobr><?PHP echo $text[193]; ?></nobr></td>
  </tr>
  <tr>
    <td class="lmost5" width="20">&nbsp;</td>
    <td class="lmost5" align="right"><nobr><acronym title="<?PHP echo $text[190] ?>"><?PHP echo $text[189]; ?></acronym></nobr></td>
    <td class="lmost5"><acronym title="<?PHP echo $text[190] ?>">
      <select class="lmoadminein" name="xfavteam" onChange="dolmoedit()">
      <?PHP
        for($y=0;$y<=$anzteams;$y++){
          echo "<option value=\"".$y."\"";
          if($y==$favteam){echo " selected";}
          echo ">".$teams[$y]."</option>";
          }
      ?>
      </select>
    </acronym></td>
  </tr>
  <tr>
    <td class="lmost5" width="20">&nbsp;</td>
    <td class="lmost5" align="right"><nobr><acronym title="<?PHP echo $text[195] ?>"><?PHP echo $text[194]; ?></acronym></nobr></td>
    <td class="lmost5"><acronym title="<?PHP echo $text[195] ?>">
      <select class="lmoadminein" name="xselteam" onChange="dolmoedit()">
      <?PHP
        for($y=0;$y<=$anzteams;$y++){
          echo "<option value=\"".$y."\"";
          if($y==$selteam){echo " selected";}
          echo ">".$teams[$y]."</option>";
          }
      ?>
      </select>
    </acronym></td>
  </tr>
<?PHP if($lmtype==0){ ?>
  <tr>
    <td class="lmost5" width="20">&nbsp;</td>
    <td class="lmost5" align="right"><nobr><acronym title="<?PHP echo $text[197] ?>"><?PHP echo $text[196]; ?></acronym></nobr></td>
    <td class="lmost5"><nobr><acronym title="<?PHP echo $text[197] ?>">
      <select class="lmoadminein" name="xstat1" onChange="dolmoedit()">
      <?PHP
        for($y=0;$y<=$anzteams;$y++){
          echo "<option value=\"".$y."\"";
          if($y==$stat1){echo " selected";}
          echo ">".$teams[$y]."</option>";
          }
      ?>
      </select>
      <select class="lmoadminein" name="xstat2" onChange="dolmoedit()">
      <?PHP
        for($y=0;$y<=$anzteams;$y++){
          echo "<option value=\"".$y."\"";
          if($y==$stat2){echo " selected";}
          echo ">".$teams[$y]."</option>";
          }
      ?>
      </select>
    </acronym></nobr></td>
  </tr>
<?PHP if($_SESSION['lmouserok']==2){ ?>
  <tr>
    <td class="lmost4" colspan="3"><nobr><?PHP echo $text[62]; ?></nobr></td>
  </tr>
  <tr>
    <td class="lmost5" width="20">&nbsp;</td>
    <td class="lmost5" align="right"><nobr><acronym title="<?PHP echo $text[66] ?>"><?PHP echo $text[65]." ".$text[37]; ?></acronym></nobr></td>
    <td class="lmost5"><acronym title="<?PHP echo $text[66] ?>"><input class="lmoadminein" type="text" name="xnamepkt" size="40" maxlength="60" value="<?PHP if($namepkt==""){echo $text[37];}else{echo $namepkt;} ?>" onChange="dolmoedit()"></acronym></td>
  </tr>
  <tr>
    <td class="lmost5" width="20">&nbsp;</td>
    <td class="lmost5" align="right"><nobr><acronym title="<?PHP echo $text[66] ?>"><?PHP echo $text[65]." ".$text[38]; ?></acronym></nobr></td>
    <td class="lmost5"><acronym title="<?PHP echo $text[66] ?>"><input class="lmoadminein" type="text" name="xnametor" size="40" maxlength="60" value="<?PHP if($nametor==""){echo $text[38];}else{echo $nametor;} ?>" onChange="dolmoedit()"></acronym></td>
  </tr>
  <tr>
    <td class="lmost4" colspan="3"><nobr><?PHP echo $text[178]; ?></nobr></td>
  </tr>
  <tr>
    <td class="lmost5" width="20">&nbsp;</td>
    <td class="lmost5" align="right"><nobr><acronym title="<?PHP echo $text[180] ?>"><?PHP echo $text[179]; ?></acronym></nobr></td>
    <td class="lmost5"><acronym title="<?PHP echo $text[180] ?>">
      <select class="lmoadminein" name="xminus" onChange="dolmoedit()">
      <?PHP
        echo "<option value=\"2\"";
          if($minus==2){echo " selected";}
          echo ">".$text[181]."</option>";
        echo "<option value=\"1\"";
          if($minus==1){echo " selected";}
          echo ">".$text[182]."</option>";
      ?>
      </select>
    </acronym></td>
  </tr>
  <tr>
    <td class="lmost5" width="20">&nbsp;</td>
    <td class="lmost5" align="right"><nobr><acronym title="<?PHP echo $text[185] ?>"><?PHP echo $text[184]; ?></acronym></nobr></td>
    <td class="lmost5"><acronym title="<?PHP echo $text[185] ?>">
      <select class="lmoadminein" name="xspez" onChange="dolmoedit()">
      <?PHP
        echo "<option value=\"1\"";
          if($spez==1){echo " selected";}
          echo ">".$text[181]."</option>";
        echo "<option value=\"0\"";
          if($spez==0){echo " selected";}
          echo ">".$text[182]."</option>";
      ?>
      </select>
    </acronym></td>
  </tr>
  <tr>
    <td class="lmost5" width="20">&nbsp;</td>
    <td class="lmost5" align="right"><nobr><acronym title="<?PHP echo $text[242] ?>"><?PHP echo $text[241]; ?></acronym></nobr></td>
    <td class="lmost5"><acronym title="<?PHP echo $text[242] ?>">
      <select class="lmoadminein" name="xhidr" onChange="dolmoedit()">
      <?PHP
        echo "<option value=\"1\"";
          if($hidr==1){echo " selected";}
          echo ">".$text[181]."</option>";
        echo "<option value=\"0\"";
          if($hidr==0){echo " selected";}
          echo ">".$text[182]."</option>";
      ?>
      </select>
    </acronym></td>
  </tr>
  <tr>
    <td class="lmost5" width="20">&nbsp;</td>
    <td class="lmost5" align="right"><nobr><acronym title="<?PHP echo $text[187] ?>"><?PHP echo $text[186]; ?></acronym></nobr></td>
    <td class="lmost5"><acronym title="<?PHP echo $text[187] ?>">
      <select class="lmoadminein" name="xdirekt" onChange="dolmoedit()">
      <?PHP
        echo "<option value=\"1\"";
          if($direkt==1){echo " selected";}
          echo ">".$text[181]."</option>";
        echo "<option value=\"0\"";
          if($direkt==0){echo " selected";}
          echo ">".$text[182]."</option>";
      ?>
      </select>
    </acronym></td>
  </tr>
  <tr>
    <td class="lmost5" width="20">&nbsp;</td>
    <td class="lmost5" align="right"><nobr><acronym title="<?PHP echo $text[396] ?>"><?PHP echo $text[395]; ?></acronym></nobr></td>
    <td class="lmost5"><acronym title="<?PHP echo $text[396] ?>">
      <select class="lmoadminein" name="xkegel" onChange="dolmoedit()">
      <?PHP
        echo "<option value=\"1\"";
          if($kegel==1){echo " selected";}
          echo ">".$text[181]."</option>";
        echo "<option value=\"0\"";
          if($kegel==0){echo " selected";}
          echo ">".$text[182]."</option>";
      ?>
      </select>
    </acronym></td>
  </tr>
  <tr>
    <td class="lmost5" width="20">&nbsp;</td>
    <td class="lmost5" align="right"><nobr><acronym title="<?PHP echo $text[408] ?>"><?PHP echo $text[407]; ?></acronym></nobr></td>
    <td class="lmost5"><acronym title="<?PHP echo $text[408] ?>">
      <select class="lmoadminein" name="xhands" onChange="dolmoedit()">
      <?PHP
        echo "<option value=\"1\"";
          if($hands==1){echo " selected";}
          echo ">".$text[181]."</option>";
        echo "<option value=\"0\"";
          if($hands==0){echo " selected";}
          echo ">".$text[182]."</option>";
      ?>
      </select>
    </acronym></td>
  </tr>
  <tr>
    <td class="lmost4" colspan="3"><nobr><?PHP echo $text[378]; ?></nobr></td>
  </tr>
  <tr>
    <td class="lmost5" width="20">&nbsp;</td>
    <td class="lmost5" align="right"><nobr><acronym title="<?PHP echo $text[380] ?>"><?PHP echo $text[379]; ?></acronym></nobr></td>
    <td class="lmost5"><acronym title="<?PHP echo $text[380] ?>">
      <select class="lmoadminein" name="xchamp" onChange="dolmoedit()">
      <?PHP
        echo "<option value=\"1\"";
          if($champ==1){echo " selected";}
          echo ">".$text[181]."</option>";
        echo "<option value=\"0\"";
          if($champ==0){echo " selected";}
          echo ">".$text[182]."</option>";
      ?>
      </select>
    </acronym></td>
  </tr>
  <tr>
    <td class="lmost5" width="20">&nbsp;</td>
    <td class="lmost5" align="right"><nobr><acronym title="<?PHP echo $text[382] ?>"><?PHP echo $text[381]; ?></acronym></nobr></td>
    <td class="lmost5"><acronym title="<?PHP echo $text[382] ?>">
      <select class="lmoadminein" name="xanzcl" onChange="dolmoedit()">
      <?PHP
        for($i=0;$i<5;$i++){
          echo "<option value=\"".$i."\"";
            if($anzcl==$i){echo " selected";}
            echo ">".$i."</option>";
          }
      ?>
      </select>
    </acronym></td>
  </tr>
  <tr>
    <td class="lmost5" width="20">&nbsp;</td>
    <td class="lmost5" align="right"><nobr><acronym title="<?PHP echo $text[384] ?>"><?PHP echo $text[383]; ?></acronym></nobr></td>
    <td class="lmost5"><acronym title="<?PHP echo $text[384] ?>">
      <select class="lmoadminein" name="xanzck" onChange="dolmoedit()">
      <?PHP
        for($i=0;$i<5;$i++){
          echo "<option value=\"".$i."\"";
            if($anzck==$i){echo " selected";}
            echo ">".$i."</option>";
          }
      ?>
      </select>
    </acronym></td>
  </tr>
  <tr>
    <td class="lmost5" width="20">&nbsp;</td>
    <td class="lmost5" align="right"><nobr><acronym title="<?PHP echo $text[386] ?>"><?PHP echo $text[385]; ?></acronym></nobr></td>
    <td class="lmost5"><acronym title="<?PHP echo $text[386] ?>">
      <select class="lmoadminein" name="xanzuc" onChange="dolmoedit()">
      <?PHP
        for($i=0;$i<=$anzteams;$i++){
          echo "<option value=\"".$i."\"";
            if($anzuc==$i){echo " selected";}
            echo ">".$i."</option>";
          }
      ?>
      </select>
    </acronym></td>
  </tr>
  <tr>
    <td class="lmost5" width="20">&nbsp;</td>
    <td class="lmost5" align="right"><nobr><acronym title="<?PHP echo $text[394] ?>"><?PHP echo $text[393]; ?></acronym></nobr></td>
    <td class="lmost5"><acronym title="<?PHP echo $text[394] ?>">
      <select class="lmoadminein" name="xanzar" onChange="dolmoedit()">
      <?PHP
        for($i=0;$i<=$anzteams;$i++){
          echo "<option value=\"".$i."\"";
            if($anzar==$i){echo " selected";}
            echo ">".$i."</option>";
          }
      ?>
      </select>
    </acronym></td>
  </tr>
  <tr>
    <td class="lmost5" width="20">&nbsp;</td>
    <td class="lmost5" align="right"><nobr><acronym title="<?PHP echo $text[388] ?>"><?PHP echo $text[387]; ?></acronym></nobr></td>
    <td class="lmost5"><acronym title="<?PHP echo $text[388] ?>">
      <select class="lmoadminein" name="xanzab" onChange="dolmoedit()">
      <?PHP
        for($i=0;$i<=$anzteams;$i++){
          echo "<option value=\"".$i."\"";
            if($anzab==$i){echo " selected";}
            echo ">".$i."</option>";
          }
      ?>
      </select>
    </acronym></td>
  </tr>
  <tr>
    <td class="lmost4" colspan="3"><nobr><?PHP echo $text[198]; ?></nobr></td>
  </tr>
  <tr>
    <td class="lmost5" width="20">&nbsp;</td>
    <td class="lmost5" colspan="2"><acronym title="<?PHP echo $text[205] ?>"><table cellspacing="0" cellpadding="0" border="0">
      <tr>
        <td class="lmost5">&nbsp;</td>
        <td class="lmost5" align="center"><nobr><?PHP echo $text[199]; ?></nobr></td>
        <td class="lmost5" align="center"><nobr><?PHP echo $text[200]; ?></nobr></td>
        <td class="lmost5" align="center"><nobr><?PHP echo $text[201]; ?></nobr></td>
      </tr>
      <tr>
        <td class="lmost5" align="right"><nobr><?PHP echo $text[202]; ?></nobr></td>
        <td class="lmost5" align="center"><select class="lmoadminein" name="xpns" onChange="dolmoedit()"><?PHP for($y=3;$y>=0;$y--){echo "<option";if($y==$pns){echo " selected";}echo ">".$y."</option>";} ?></select></td>
        <td class="lmost5" align="center"><select class="lmoadminein" name="xpnu" onChange="dolmoedit()"><?PHP for($y=3;$y>=0;$y--){echo "<option";if($y==$pnu){echo " selected";}echo ">".$y."</option>";} ?></select></td>
        <td class="lmost5" align="center"><select class="lmoadminein" name="xpnn" onChange="dolmoedit()"><?PHP for($y=3;$y>=0;$y--){echo "<option";if($y==$pnn){echo " selected";}echo ">".$y."</option>";} ?></select></td>
      </tr>
      <tr>
        <td class="lmost5" align="right"><nobr><?PHP echo $text[203]; ?></nobr></td>
        <td class="lmost5" align="center"><select class="lmoadminein" name="xpxs" onChange="dolmoedit()"><?PHP for($y=3;$y>=0;$y--){echo "<option";if($y==$pxs){echo " selected";}echo ">".$y."</option>";} ?></select></td>
        <td class="lmost5" align="center"><select class="lmoadminein" name="xpxu" onChange="dolmoedit()"><?PHP for($y=3;$y>=0;$y--){echo "<option";if($y==$pxu){echo " selected";}echo ">".$y."</option>";} ?></select></td>
        <td class="lmost5" align="center"><select class="lmoadminein" name="xpxn" onChange="dolmoedit()"><?PHP for($y=3;$y>=0;$y--){echo "<option";if($y==$pxn){echo " selected";}echo ">".$y."</option>";} ?></select></td>
      </tr>
      <tr>
        <td class="lmost5" align="right"><nobr><?PHP echo $text[204]; ?></nobr></td>
        <td class="lmost5" align="center"><select class="lmoadminein" name="xpps" onChange="dolmoedit()"><?PHP for($y=3;$y>=0;$y--){echo "<option";if($y==$pps){echo " selected";}echo ">".$y."</option>";} ?></select></td>
        <td class="lmost5" align="center"><select class="lmoadminein" name="xppu" onChange="dolmoedit()"><?PHP for($y=3;$y>=0;$y--){echo "<option";if($y==$ppu){echo " selected";}echo ">".$y."</option>";} ?></select></td>
        <td class="lmost5" align="center"><select class="lmoadminein" name="xppn" onChange="dolmoedit()"><?PHP for($y=3;$y>=0;$y--){echo "<option";if($y==$ppn){echo " selected";}echo ">".$y."</option>";} ?></select></td>
      </tr>
    </table></acronym></td>
  </tr>
<?PHP }} ?>
  <tr>
    <td class="lmost4" colspan="2">
<?PHP if(($_SESSION['lmouserok']==2) && ($lmtype==0)){echo "<a href='$addr-3' onclick=\"return chklmolink(this.href);\" title=\"".$text[339]."\">".$text[338]."</a>";}else{echo "&nbsp;";} ?>
    </td>
    <td class="lmost4" align="right">
      <acronym title="<?PHP echo $text[114] ?>"><input class="lmoadminbut" type="submit" name="best" value="<?PHP echo $text[188]; ?>"></acronym>
    </td>
  </tr>
  </form>

  </table></td></tr>
  <tr>
    <td><table width="100%" cellspacing="0" cellpadding="0" border="0"><tr>
<?PHP 
  if($st!=-1){echo "<td class=\"lmost2\" align=\"center\"><a href='$addr-1' onclick=\"return chklmolink(this.href);\" title=\"".$text[100]."\">".$text[99]."</a></td>";}
    else{echo "<td class=\"lmost1\" align=\"center\">".$text[99]."</td>";}
  if($hands==1){if($todo!="tabs"){echo "<td class=\"lmost2\" align=\"center\"><a href='$addb$stx' onclick=\"return chklmolink(this.href);\" title=\"".$text[409]."\">".$text[410]."</a></td>";}
    else{echo "<td class=\"lmost1\" align=\"center\">".$text[410]."</td>";}}
if($_SESSION['lmouserok']==2){
  if($st!=-2){echo "<td class=\"lmost2\" align=\"center\"><a href='$addr-2' onclick=\"return chklmolink(this.href);\" title=\"".$text[102]."\">".$text[101]."</a></td>";}
    else{echo "<td class=\"lmost1\" align=\"center\">".$text[101]."</td>";}
  }
?>
    </tr></table></td>
  </tr>
</table>

<?PHP } ?>