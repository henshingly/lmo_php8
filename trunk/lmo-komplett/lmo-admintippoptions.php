<?PHP
// 
// LigaManager Online 3.02
// Copyright (C) 1997-2002 by Frank Hollwitz
// webmaster@hollwitz.de / http://php.hollwitz.de
// 
// Tippspiel-AddOn 1.20
// Copyright (C) 2002 by Frank Albrecht
// fkalbrecht@web.de
// 
// Jocker-Hack 001
// Copyright (C) 2002 by Ufuk Altinkaynak
// ufuk.a@arcor.de
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
  
  if(!isset($save)){$save=0;}
  if($save==1){
    if(!isset($_POST["xshownick"])){$_POST["xshownick"]="";}
    if(!isset($_POST["xshowname"])){$_POST["xshowname"]="";}
    if(!isset($_POST["xshowemail"])){$_POST["xshowemail"]="";}
    if(!isset($_POST["xshowtendenzabs"])){$_POST["xshowtendenzabs"]="";}
    if(!isset($_POST["xshowtendenzpro"])){$_POST["xshowtendenzpro"]="";}
    if(!isset($_POST["xshowdurchschntipp"])){$_POST["xshowdurchschntipp"]="";}
    $tippmodus=trim($_POST["xtippmodus"]);

    if($tippmodus==1){
      $rergebnis=trim($_POST["xrergebnis"]);
      if($rergebnis==""){$rergebnis=0;}
      else{
        $rergebnis=intval(trim($rergebnis));
        if($rergebnis=="" || $rergebnis<0){$rergebnis="0";}
        }
      $rtendenzdiff=trim($_POST["xrtendenzdiff"]);
      if($rtendenzdiff==""){$rtendenzdiff=0;}
      else{
        $rtendenzdiff=intval(trim($rtendenzdiff));
        if($rtendenzdiff=="" || $rtendenzdiff<0){$rtendenzdiff="0";}
        }
      if($rergebnis<$rtendenzdiff){$rergebnis=$rtendenzdiff;}
      
      $rtendenz=trim($_POST["xrtendenz"]);
      if($rtendenz==""){$rtendenz=0;}
      else{
        $rtendenz=intval(trim($rtendenz));
        if($rtendenz=="" || $rtendenz<0){$rtendenz=0;}
        }
      if($rtendenzdiff<$rtendenz){$rtendenzdiff=$rtendenz;}

      $rtor=trim($_POST["xrtor"]);
      if($rtor==""){$rtor=0;}
      else{
        $rtor=intval(trim($rtor));
        if($rtor=="" || $rtor<0){$rtor=0;}
        }
      $rtendenztor=trim($_POST["xrtendenztor"]);
      $rtendenzremis=trim($_POST["xrtendenzremis"]);
      $pfeiltipp=trim($_POST["xpfeiltipp"]);
      $sttipp=trim($_POST["xsttipp"]);
      $viewertipp=trim($_POST["xviewertipp"]);
      if($viewertipp==1){
        $viewertage=trim($_POST["xviewertage"]);
        if($viewertage==""){$viewertage=8;}
        else{
          $viewertage=intval(trim($viewertage));
          if($viewertage=="" || $viewertage<0){$viewertage=8;}
          }
        }
      $showdurchschntipp=trim($_POST["xshowdurchschntipp"]);
      if($showdurchschntipp!=1){$showdurchschntipp=0;}
    }

    $tipptabelle1=trim($_POST["xtipptabelle1"]);
    $tipptabelle=trim($_POST["xtipptabelle"]);
    $showzus=trim($_POST["xshowzus"]);
    $showstsiege=trim($_POST["xshowstsiege"]);
    $krit1=trim($_POST["xkrit1"]);
    $krit2=trim($_POST["xkrit2"]);
    $krit3=trim($_POST["xkrit3"]);
    $dirtipp=trim($_POST["xdirtipp"]);
    if($dirtipp==""){$dirtipp="tipps/";}
    $dummy=$dirtipp;
    $dirtipp=str_replace("\\","/",$dummy);
    if(substr($dirtipp,-1)!="/"){$dirtipp=$dirtipp."/";}
    if($dirtipp=="/"){$dirtipp="tipps/";}

    $shownick=trim($_POST["xshownick"]);
    if($shownick!=1){$shownick=0;}
    $showname=trim($_POST["xshowname"]);
    if($showname!=1){$showname=0;}
    $showemail=trim($_POST["xshowemail"]);
    if($showemail!=1){$showemail=0;}
    if($showname==0 && $showemail==0){$shownick=1;}

    $showtendenzabs=trim($_POST["xshowtendenzabs"]);
    if($showtendenzabs!=1){$showtendenzabs=0;}
    $showtendenzpro=trim($_POST["xshowtendenzpro"]);
    if($showtendenzpro!=1){$showtendenzpro=0;}

    $tippspiel=trim($_POST["xtippspiel"]);
    $regeln=trim($_POST["xregeln"]);
    if($regeln==1){
      $regelnlink=trim($_POST["xregelnlink"]);
      }
    $freischaltung=trim($_POST["xfreischaltung"]);
    $entscheidungnv=trim($_POST["xentscheidungnv"]);
    $entscheidungie=trim($_POST["xentscheidungie"]);
    $einsichterst=trim($_POST["xeinsichterst"]);

    $rremis=trim($_POST["xrremis"]);
    if($rremis==""){$rremis=0;}
    else{
      $rremis=intval(trim($rremis));
      if($rremis=="" || $rremis<0){$rremis=0;}
      }
    $gtpunkte=trim($_POST["xgtpunkte"]);

    $anzseite=trim($_POST["xanzseite"]);
    if($anzseite==""){$anzseite=0;}
    else{
      $anzseite=intval(trim($anzseite));
      if($anzseite=="" || $anzseite<0){$anzseite=0;}
      }
    $anzseite1=trim($_POST["xanzseite1"]);
    if($anzseite1==""){$anzseite1=0;}
    else{
      $anzseite1=intval(trim($anzseite1));
      if($anzseite1=="" || $anzseite1<0){$anzseite1=0;}
      }
    $tippeinsicht=trim($_POST["xtippeinsicht"]);
    $tippfieber=trim($_POST["xtippfieber"]);

    $wertverein=trim($_POST["xwertverein"]);
    $aktauswert=trim($_POST["xaktauswert"]);
    $aktauswertges=trim($_POST["xaktauswertges"]);
    $akteinsicht=trim($_POST["xakteinsicht"]);
    if($showtendenzabs==1 || $showtendenzpro==1 || ($showdurchschntipp==1 && $tippmodus==1)){$akteinsicht=1;}

    $adresse=trim($_POST["xadresse"]);
    $realname=trim($_POST["xrealname"]);
    $gesamt=trim($_POST["xgesamt"]);
    $tippohne=trim($_POST["xtippohne"]);
    $tippbis=trim($_POST["xtippbis"]);
    if($tippbis==""){$tippbis=0;}
    else{
      $tippbis=intval(trim($tippbis));
      if($tippbis==""){$tippbis=0;}
      }
    $tipperimteam=trim($_POST["xtipperteam"]);
    $imvorraus=trim($_POST["ximvorraus"]);
    $jokertipp=trim($_POST["xjokertipp"]);
    if($jokertipp==1){
      $jokertippmulti=trim($_POST["xjokertippmulti"]);
      }
    $immeralle=trim($_POST["ximmeralle"]);
    $ligenzutippen="";
    if($immeralle!=1){
      $immeralle=0;
      if($_POST["xtipperligen"]!=""){
        foreach($_POST["xtipperligen"] as $key => $value){
          $ligenzutippen.=$value.",";
          }
        }
      $ligenzutippen=trim(substr($ligenzutippen,0,-1));
      }
    require(PATH_TO_LMO."/lmo-tippsavecfg.php");
    }
  $adda=$_SERVER['PHP_SELF']."?action=admin&amp;todo=tipp";
  $addu=$_SERVER['PHP_SELF']."?action=admin&amp;todo=tippuser";
  $adde=$_SERVER['PHP_SELF']."?action=admin&amp;todo=tippemail";
?>
<script language="JavaScript">
<!---
function immerallechange(){
  lmotest=false;
  for(i=0;i<document.getElementsByName("xtipperligen[]").length;i++){
    if(document.getElementsByName("ximmeralle")[0].value==0){
      document.getElementsByName("xtipperligen[]")[i].disabled=false;
      }
    else{
      document.getElementsByName("xtipperligen[]")[i].disabled=true;
      }
    }
  }
function moduschange(){
  lmotest=false;
  if(document.getElementsByName("xtippmodus")[0].value==1){
    document.getElementsByName("xrergebnis")[0].disabled=false;
    document.getElementsByName("xrtendenzdiff")[0].disabled=false;
    document.getElementsByName("xrtendenz")[0].disabled=false;
    document.getElementsByName("xrtor")[0].disabled=false;
    document.getElementsByName("xrtendenztor")[0].disabled=false;
    document.getElementsByName("xrtendenzremis")[0].disabled=false;
    document.getElementsByName("xshowdurchschntipp")[0].disabled=false;
    document.getElementsByName("xpfeiltipp")[0].disabled=false;
    }
  else{
    document.getElementsByName("xrergebnis")[0].disabled=true;
    document.getElementsByName("xrtendenzdiff")[0].disabled=true;
    document.getElementsByName("xrtendenz")[0].disabled=true;
    document.getElementsByName("xrtor")[0].disabled=true;
    document.getElementsByName("xrtendenztor")[0].disabled=true;
    document.getElementsByName("xrtendenzremis")[0].disabled=true;
    document.getElementsByName("xshowdurchschntipp")[0].disabled=true;
    document.getElementsByName("xpfeiltipp")[0].disabled=true;
    }
  }

function regelnchange(){
  lmotest=false;
  if(document.getElementsByName("xregeln")[0].value==1){
    document.getElementsByName("xregelnlink")[0].disabled=false;
    }
  else{
    document.getElementsByName("xregelnlink")[0].disabled=true;
    }
  }

function jokerchange(){
lmotest=false;
  if(document.getElementsByName("xjokertipp")[0].value==1){
    document.getElementsByName("xjokertippmulti")[0].disabled=false;   
    }
  else{
    document.getElementsByName("xjokertippmulti")[0].disabled=true;    
    }
  }

function viewerchange(){
lmotest=false;
  if(document.getElementsByName("xviewertipp")[0].value==1){
    document.getElementsByName("xviewertage")[0].disabled=false;   
    }
  else{
    document.getElementsByName("xviewertage")[0].disabled=true;    
    }
  }	  
// --->
</script>

<table class="lmosta" cellspacing="0" cellpadding="0" border="0">
  <tr>
    <td class="lmost1" align="center"><?PHP echo $text[2033] ?></td>
  </tr>
  <tr><td align="center" class="lmost3"><table class="lmostb" cellspacing="0" cellpadding="0" border="0">
  <form name="lmoedit" action="<?PHP echo $_SERVER['PHP_SELF']; ?>" method="post" onSubmit="return chklmopass()">
  <input type="hidden" name="action" value="admin">
  <input type="hidden" name="todo" value="tippoptions">
  <input type="hidden" name="save" value="1">
  <tr>
    <td class="lmost4" colspan="3"><nobr><?PHP echo $text[2091]; ?></nobr></td>
  </tr>
  <tr>
    <td class="lmost5" width="20">&nbsp;</td>
    <td class="lmost5" align="right"><nobr><?PHP echo $text[2091]; ?></nobr></td>
    <td class="lmost5">
      <select name="xtippmodus" onChange="moduschange()">
      <?PHP
        echo "<option value=\"1\"";
          if($tippmodus==1){echo " selected";}
          echo ">".$text[2092]."</option>";
        echo "<option value=\"0\"";
          if($tippmodus==0){echo " selected";}
          echo ">".$text[2093]."</option>";
      ?>
      </select>
    </td>
  </tr>
  <tr>
    <td class="lmost4" colspan="3"><nobr><?PHP echo $text[2032]; ?></nobr></td>
  </tr>
  <tr>
    <td class="lmost5" width="20">&nbsp;</td>
    <td class="lmost5" align="right"><nobr><?PHP echo $text[2034]; ?></nobr></td>
    <td class="lmost5"><input class="lmoadminein" type="text" name="xrergebnis" size="10" maxlength="5" value="<?PHP echo $rergebnis; ?>" onChange="dolmoedit()"<?PHP if($tippmodus==0){echo " disabled";} ?>>&nbsp;<?PHP echo $text[2038]; ?></td>
  </tr>
  <tr>
    <td class="lmost5" width="20">&nbsp;</td>
    <td class="lmost5" align="right"><nobr><?PHP echo $text[2035]; ?></nobr></td>
    <td class="lmost5"><input class="lmoadminein" type="text" name="xrtendenzdiff" size="10" maxlength="5" value="<?PHP echo $rtendenzdiff; ?>" onChange="dolmoedit()"<?PHP if($tippmodus==0){echo " disabled";} ?>>&nbsp;<?PHP echo $text[2038]; ?></td>
  </tr>
  <tr>
    <td class="lmost5" width="20">&nbsp;</td>
    <td class="lmost5" align="right"><nobr><?PHP echo $text[2036]; ?></nobr></td>
    <td class="lmost5"><input class="lmoadminein" type="text" name="xrtendenz" size="10" maxlength="5" value="<?PHP echo $rtendenz; ?>" onChange="dolmoedit()"<?PHP if($tippmodus==0){echo " disabled";} ?>>&nbsp;<?PHP echo $text[2038]; ?></td>
  </tr>
  <tr>
    <td class="lmost5" width="20">&nbsp;</td>
    <td class="lmost5" align="right"><nobr><?PHP echo $text[2037]; ?></nobr></td>
    <td class="lmost5"><input class="lmoadminein" type="text" name="xrtor" size="10" maxlength="5" value="<?PHP echo $rtor; ?>" onChange="dolmoedit()"<?PHP if($tippmodus==0){echo " disabled";} ?>>&nbsp;<?PHP echo $text[2038]; ?></td>
  </tr>
  <tr>
    <td class="lmost5" width="20">&nbsp;</td>
    <td class="lmost5" align="right"><nobr><?PHP echo $text[2189]; ?></nobr></td>
    <td class="lmost5">
      <select name="xrtendenztor" onChange="dolmoedit()"<?PHP if($tippmodus==0){echo " disabled";}?>>
      <?PHP
        echo "<option value=\"1\"";
          if($rtendenztor==1){echo " selected";}
          echo ">".$text[2190]."</option>";
        echo "<option value=\"0\"";
          if($rtendenztor==0){echo " selected";}
          echo ">".$text[2191]."</option>";
      ?>
      </select>
    </td>
  </tr>
  <tr>
    <td class="lmost5" width="20">&nbsp;</td>
    <td class="lmost5" align="right"><nobr><?PHP echo $text[2193]; ?></nobr></td>
    <td class="lmost5">
      <select name="xrtendenzremis" onChange="dolmoedit()"<?PHP if($tippmodus==0){echo " disabled";}?>>
      <?PHP
        echo "<option value=\"1\"";
          if($rtendenzremis==1){echo " selected";}
          echo ">".$text[2194]."</option>";
        echo "<option value=\"0\"";
          if($rtendenzremis==0){echo " selected";}
          echo ">".$text[2195]."</option>";
      ?>
      </select>
    </td>
  </tr>
  <tr>
    <td class="lmost5" width="20">&nbsp;</td>
    <td class="lmost5" align="right"><nobr><?PHP echo $text[2192]; ?></nobr></td>
    <td class="lmost5"><input class="lmoadminein" type="text" name="xrremis" size="10" maxlength="5" value="<?PHP echo $rremis; ?>" onChange="dolmoedit()">&nbsp;<?PHP echo $text[2038]; ?></td>
  </tr>
  <tr>
    <td class="lmost4" colspan="3"><nobr><?PHP echo $text[2240]; ?></nobr></td>
  </tr>
  <tr>
    <td class="lmost5" width="20">&nbsp;</td>
    <td class="lmost5" align="right"><nobr><?PHP echo $text[2157]; ?></nobr></td>
    <td class="lmost5">
      <select name="xtippeinsicht" onChange="dolmoedit()">
      <?PHP
        echo "<option value=\"1\"";
          if($tippeinsicht==1){echo " selected";}
          echo ">".$text[181]."</option>";
        echo "<option value=\"0\"";
          if($tippeinsicht==0){echo " selected";}
          echo ">".$text[182]."</option>";
      ?>
      </select>
    </td>
  </tr>
  <tr>
    <td class="lmost5" width="20">&nbsp;</td>
    <td class="lmost5" align="right"><nobr><?PHP echo $text[2172]; ?></nobr></td>
    <td class="lmost5">
      <select name="xtipptabelle1" onChange="dolmoedit()">
      <?PHP
        echo "<option value=\"1\"";
          if($tipptabelle1==1){echo " selected";}
          echo ">".$text[181]."</option>";
        echo "<option value=\"0\"";
          if($tipptabelle1==0){echo " selected";}
          echo ">".$text[182]."</option>";
      ?>
      </select>
    </td>
  </tr>
  <tr>
    <td class="lmost5" width="20">&nbsp;</td>
    <td class="lmost5" align="right"><nobr><?PHP echo $text[133]; ?></nobr></td>
    <td class="lmost5">
      <select name="xtippfieber" onChange="dolmoedit()">
      <?PHP
        echo "<option value=\"1\"";
          if($tippfieber==1){echo " selected";}
          echo ">".$text[181]."</option>";
        echo "<option value=\"0\"";
          if($tippfieber==0){echo " selected";}
          echo ">".$text[182]."</option>";
      ?>
      </select>
    </td>
  </tr>
  <tr>
    <td class="lmost5" width="20">&nbsp;</td>
    <td class="lmost5" align="right"><nobr><?PHP echo $text[2056]; ?></nobr></td>
    <td class="lmost5">
      <select name="xgesamt" onChange="dolmoedit()">
      <?PHP
        echo "<option value=\"1\"";
          if($gesamt==1){echo " selected";}
          echo ">".$text[181]."</option>";
        echo "<option value=\"0\"";
          if($gesamt==0){echo " selected";}
          echo ">".$text[182]."</option>";
      ?>
      </select>
    </td>
  </tr>
  <tr>
    <td class="lmost4" colspan="3"><nobr><?PHP echo $text[2214]; ?></nobr></td>
  </tr>
  <tr>
    <td class="lmost5" width="20">&nbsp;</td>
    <td class="lmost5" align="right"><nobr><?PHP echo $text[2087]; ?></nobr></td>
    <td class="lmost5"><input class="lmoadminein" type="text" name="xtippbis" size="10" maxlength="5" value="<?PHP echo $tippbis; ?>" onChange="dolmoedit()"><nobr><?PHP echo " ".$text[2088]; ?></nobr></td>
  </tr>
  <tr>
    <td class="lmost5" width="20">&nbsp;</td>
    <td class="lmost5" align="right"><nobr><?PHP echo $text[2248]; ?></nobr></td>
    <td class="lmost5">
      <select name="xtippohne" onChange="dolmoedit()">
      <?PHP
        echo "<option value=\"1\"";
          if($tippohne==1){echo " selected";}
          echo ">".$text[2249]."</option>";
        echo "<option value=\"0\"";
          if($tippohne==0){echo " selected";}
          echo ">".$text[2250]."</option>";
      ?>
      </select>
    </td>
  </tr>
  <tr>
    <td class="lmost5" width="20">&nbsp;</td>
    <td class="lmost5" align="right"><nobr><?PHP echo $text[2100]; ?></nobr></td>
    <td class="lmost5">
      <select name="xtipperteam" onChange="dolmoedit()">
      <?PHP
        echo "<option value=\"-1\"";
          if($tipperimteam==-1){echo " selected";}
          echo ">".$text[2101]."</option>";
        echo "<option value=\"2\"";
          if($tipperimteam==2){echo " selected";}
          echo ">2</option>";
        echo "<option value=\"3\"";
          if($tipperimteam==3){echo " selected";}
          echo ">3</option>";
        echo "<option value=\"5\"";
          if($tipperimteam==5){echo " selected";}
          echo ">5</option>";
        echo "<option value=\"10\"";
          if($tipperimteam==10){echo " selected";}
          echo ">10</option>";
        echo "<option value=\"20\"";
          if($tipperimteam==20){echo " selected";}
          echo ">20</option>";
        echo "<option value=\"30\"";
          if($tipperimteam==30){echo " selected";}
          echo ">30</option>";
        echo "<option value=\"50\"";
          if($tipperimteam==50){echo " selected";}
          echo ">50</option>";
        echo "<option value=\"100\"";
          if($tipperimteam==100){echo " selected";}
          echo ">100</option>";
        echo "<option value=\"0\"";
          if($tipperimteam==0){echo " selected";}
          echo ">".$text[2102]."</option>";
      ?>
      </select>
    </td>
  </tr>
  <tr>
    <td class="lmost5" width="20">&nbsp;</td>
    <td class="lmost5" align="right"><nobr><?PHP echo $text[2154]; ?></nobr></td>
    <td class="lmost5">
      <select name="ximvorraus" onChange="dolmoedit()">
      <?PHP
        echo "<option value=\"0\"";
          if($imvorraus==0){echo " selected";}
          echo ">0</option>";
        echo "<option value=\"1\"";
          if($imvorraus==1){echo " selected";}
          echo ">1</option>";
        echo "<option value=\"2\"";
          if($imvorraus==2){echo " selected";}
          echo ">2</option>";
        echo "<option value=\"3\"";
          if($imvorraus==3){echo " selected";}
          echo ">3</option>";
        echo "<option value=\"4\"";
          if($imvorraus==4){echo " selected";}
          echo ">4</option>";
        echo "<option value=\"5\"";
          if($imvorraus==5){echo " selected";}
          echo ">5</option>";
        echo "<option value=\"-1\"";
          if($imvorraus==-1){echo " selected";}
          echo ">".$text[2102]."</option>";
      ?>
      </select>
    </td>
  </tr>
  <tr>
    <td class="lmost5" width="20">&nbsp;</td>
    <td class="lmost5" align="right"><nobr><?PHP echo $text[2152]; ?></nobr></td>
    <td class="lmost5">
      <select name="xentscheidungnv" onChange="dolmoedit()">
      <?PHP
        echo "<option value=\"1\"";
          if($entscheidungnv==1){echo " selected";}
          echo ">".$text[181]."</option>";
        echo "<option value=\"0\"";
          if($entscheidungnv==0){echo " selected";}
          echo ">".$text[182]."</option>";
      ?>
      </select>
    </td>
  </tr>
  <tr>
    <td class="lmost5" width="20">&nbsp;</td>
    <td class="lmost5" align="right"><nobr><?PHP echo $text[2153]; ?></nobr></td>
    <td class="lmost5">
      <select name="xentscheidungie" onChange="dolmoedit()">
      <?PHP
        echo "<option value=\"1\"";
          if($entscheidungie==1){echo " selected";}
          echo ">".$text[181]."</option>";
        echo "<option value=\"0\"";
          if($entscheidungie==0){echo " selected";}
          echo ">".$text[182]."</option>";
      ?>
      </select>
    </td>
  </tr>
  <tr>
    <td class="lmost5" width="20">&nbsp;</td>
    <td class="lmost5" align="right"><nobr><?PHP echo $text[2196]; ?></nobr></td>
    <td class="lmost5">
      <select name="xgtpunkte" onChange="dolmoedit()">
      <?PHP
        echo "<option value=\"0\"";
          if($gtpunkte==0){echo " selected";}
          echo ">".$text[2197]."</option>";
        echo "<option value=\"1\"";
          if($gtpunkte==1){echo " selected";}
          echo ">".$text[2198]."</option>";
        echo "<option value=\"2\"";
          if($gtpunkte==2){echo " selected";}
          echo ">".$text[2199]."</option>";
      ?>
      </select>
    </td>
  </tr>
  <tr>
    <td class="lmost4" colspan="3"><nobr><?PHP echo $text[2289]; ?></nobr></td>
  </tr>
<tr>
    <td class="lmost5" width="20">&nbsp;</td>
    <td class="lmost5" align="right"><nobr><?PHP echo $text[2288]; ?></nobr></td>
    <td class="lmost5">
      <select name="xjokertipp" onChange="jokerchange()">
      <?PHP
        echo "<option value=\"1\"";
          if($jokertipp==1){echo " selected";}
          echo ">".$text[181]."</option>";
        echo "<option value=\"0\"";
          if($jokertipp==0){echo " selected";}
          echo ">".$text[182]."</option>";
      ?>
      </select>
    </td>
  </tr>
  <tr>
    <td class="lmost5" width="20">&nbsp;</td>
    <td class="lmost5" align="right"><nobr><?PHP echo $text[2291]; ?></nobr></td>
    <td class="lmost5">
      <select name="xjokertippmulti" onChange="dolmoedit()"<?PHP if($jokertipp==0){echo " disabled";}?>>      
      <?PHP
        echo "<option value=\"1.5\"";
          if($jokertippmulti=="1.5"){echo " selected";}
          echo ">1.5</option>";
        echo "<option value=\"2\"";
          if($jokertippmulti=="2"){echo " selected";}
          echo ">2</option>";
        echo "<option value=\"2.5\"";
          if($jokertippmulti=="2.5"){echo " selected";}
          echo ">2.5</option>";
        echo "<option value=\"3\"";
          if($jokertippmulti=="3"){echo " selected";}
          echo ">3</option>";        
      ?>
      </select>
    </td>
  </tr>  
  <tr>
    <td class="lmost4" colspan="3"><nobr><?PHP echo $text[220]; ?></nobr></td>
  </tr>
  <tr>
    <td class="lmost5" width="20">&nbsp;</td>
    <td class="lmost5" align="right"><nobr><?PHP echo $text[2039]; ?></nobr></td>
    <td class="lmost5"><input class="lmoadminein" type="text" name="xdirtipp" size="40" maxlength="80" value="<?PHP echo $dirtipp; ?>" onChange="dolmoedit()"></td>
  </tr>
  <tr>
    <td class="lmost4" colspan="3"><nobr><?PHP echo $text[2238]; ?></nobr></td>
  </tr>
  <tr>
    <td class="lmost5" width="20">&nbsp;</td>
    <td class="lmost5" align="right"><nobr><?PHP echo $text[2040]; ?></nobr></td>
    <td class="lmost5">
      <select name="xtippspiel" onChange="dolmoedit()">
      <?PHP
        echo "<option value=\"1\"";
          if($tippspiel==1){echo " selected";}
          echo ">".$text[181]."</option>";
        echo "<option value=\"0\"";
          if($tippspiel==0){echo " selected";}
          echo ">".$text[182]."</option>";
      ?>
      </select>
    </td>
  </tr>
  <tr>
    <td class="lmost5" width="20">&nbsp;</td>
    <td class="lmost5" align="right"><nobr><?PHP echo $text[2187]; ?></nobr></td>
    <td class="lmost5">
      <select name="xregeln" onChange="regelnchange()">
      <?PHP
        echo "<option value=\"1\"";
          if($regeln==1){echo " selected";}
          echo ">".$text[181]."</option>";
        echo "<option value=\"0\"";
          if($regeln==0){echo " selected";}
          echo ">".$text[182]."</option>";
      ?>
      </select>
    </td>
  </tr>
  <tr>
    <td class="lmost5" width="20">&nbsp;</td>
    <td class="lmost5" align="right"><nobr><?PHP echo $text[2186]; ?></nobr></td>
    <td class="lmost5"><input class="lmoadminein" type="text" name="xregelnlink" size="30" maxlength="256" value="<?PHP echo $regelnlink; ?>" onChange="dolmoedit()"<?PHP if($regeln==0){echo " disabled";}?>></td>
  </tr>
  <tr>
    <td class="lmost4" colspan="3"><nobr><?PHP echo $text[2239]; ?></nobr></td>
  </tr>
  <tr>
    <td class="lmost5" width="20">&nbsp;</td>
    <td class="lmost5" align="right"><nobr><?PHP echo $text[2132]; ?></nobr></td>
    <td class="lmost5">
      <select name="xadresse" onChange="dolmoedit()">
      <?PHP
        echo "<option value=\"1\"";
          if($adresse==1){echo " selected";}
          echo ">".$text[181]."</option>";
        echo "<option value=\"0\"";
          if($adresse==0){echo " selected";}
          echo ">".$text[182]."</option>";
      ?>
      </select>
    </td>
  </tr>
  <tr>
    <td class="lmost5" width="20">&nbsp;</td>
    <td class="lmost5" align="right"><nobr><?PHP echo $text[2286]; ?></nobr></td>
    <td class="lmost5">
      <select name="xrealname" onChange="dolmoedit()">
      <?PHP
        echo "<option value=\"1\"";
          if($realname!=-1){echo " selected";}
          echo ">".$text[181]."</option>";
        echo "<option value=\"-1\"";
          if($realname==-1){echo " selected";}
          echo ">".$text[182]."</option>";
      ?>
      </select>
    </td>
  </tr>
  <tr>
    <td class="lmost5" width="20">&nbsp;</td>
    <td class="lmost5" align="right"><nobr><?PHP echo $text[2146]; ?></nobr></td>
    <td class="lmost5">
      <select name="xfreischaltung" onChange="dolmoedit()">
      <?PHP
        echo "<option value=\"1\"";
          if($freischaltung==1){echo " selected";}
          echo ">".$text[181]."</option>";
        echo "<option value=\"0\"";
          if($freischaltung==0){echo " selected";}
          echo ">".$text[182]."</option>";
      ?>
      </select>
    </td>
  </tr>
  <tr>
    <td class="lmost4" colspan="3"><nobr><?PHP echo $text[2246]; ?></nobr></td>
  </tr>
  <tr>
    <td class="lmost5" width="20">&nbsp;</td>
    <td class="lmost5" align="right"><nobr><?PHP echo $text[2245]; ?></nobr></td>
    <td class="lmost5">
      <select name="xpfeiltipp" onChange="dolmoedit()"<?PHP if($tippmodus==0){echo " disabled";}?>>
      <?PHP
        echo "<option value=\"1\"";
          if($pfeiltipp==1){echo " selected";}
          echo ">".$text[181]."</option>";
        echo "<option value=\"0\"";
          if($pfeiltipp==0){echo " selected";}
          echo ">".$text[182]."</option>";
      ?>
      </select>
    </td>
  </tr>
  <tr>
    <td class="lmost5" width="20">&nbsp;</td>
    <td class="lmost5" align="right"><nobr><?PHP echo $text[2259]; ?></nobr></td>
    <td class="lmost5">
      <select name="xsttipp" onChange="dolmoedit()">
      <?PHP
        echo "<option value=\"1\"";
          if($sttipp!=-1){echo " selected";}
          echo ">".$text[181]."</option>";
        echo "<option value=\"-1\"";
          if($sttipp==-1){echo " selected";}
          echo ">".$text[182]."</option>";
      ?>
      </select>
    </td>
  </tr>
  <tr>
    <td class="lmost5" width="20">&nbsp;</td>
    <td class="lmost5" align="right"><nobr><?PHP echo $text[2253]; ?></nobr></td>
    <td class="lmost5">
      <select name="xviewertipp" onChange="viewerchange()">
      <?PHP
        echo "<option value=\"1\"";
          if($viewertipp==1){echo " selected";}
          echo ">".$text[181]."</option>";
        echo "<option value=\"0\"";
          if($viewertipp==0){echo " selected";}
          echo ">".$text[182]."</option>";
      ?>
      </select>
    </td>
  </tr>
  <tr>
    <td class="lmost5" width="20">&nbsp;</td>
    <td class="lmost5" align="right"><nobr><?PHP echo $text[2254]; ?></nobr></td>
    <td class="lmost5"><input class="lmoadminein" type="text" name="xviewertage" size="5" maxlength="2" value="<?PHP echo $viewertage; ?>" onChange="dolmoedit()"<?PHP if($viewertipp==0){echo " disabled";} ?>>&nbsp;<?PHP echo $text[2171]; ?></td>
  </tr>
  <tr>
    <td class="lmost5" width="20">&nbsp;</td>
    <td class="lmost5" align="right"><nobr><?PHP echo $text[2161]; ?></nobr></td>
    <td class="lmost5">
      <select name="xakteinsicht" onChange="dolmoedit()">
      <?PHP
        echo "<option value=\"1\"";
          if($akteinsicht==1){echo " selected";}
          echo ">".$text[181]."</option>";
        echo "<option value=\"0\"";
          if($akteinsicht==0){echo " selected";}
          echo ">".$text[182]."</option>";
      ?>
      </select>
    </td>
  </tr>
  <tr>
    <td class="lmost4" colspan="3"><nobr><?PHP echo $text[2210]; ?></nobr></td>
  </tr>
  <tr>
    <td class="lmost5" width="20">&nbsp;</td>
    <td class="lmost5" colspan="2"><nobr>
    <input type="checkbox" name="xshowtendenzabs" value="1" <?PHP if($showtendenzabs==1){echo "checked";} ?> onClick="dolmoedit()"><?PHP echo $text[2188]." ".$text[2212]; ?>
    <input type="checkbox" name="xshowtendenzpro" value="1" <?PHP if($showtendenzpro==1){echo "checked";} ?> onClick="dolmoedit()"><?PHP echo $text[2188]." ".$text[2211]; ?>
    <input type="checkbox" name="xshowdurchschntipp" value="1" <?PHP if($showdurchschntipp==1){echo "checked";} ?> onClick="dolmoedit()"<?PHP if($tippmodus==0){echo " disabled";} ?>><?PHP echo $text[2213]; ?>
    </nobr></td>
  </tr>
  <tr>
    <td class="lmost4" colspan="3"><nobr><?PHP echo $text[2157]; ?></nobr></td>
  </tr>
  <tr>
    <td class="lmost5" width="20">&nbsp;</td>
    <td class="lmost5" align="right"><nobr><?PHP echo $text[2160]; ?></nobr></td>
    <td class="lmost5">
      <select name="xeinsichterst" onChange="dolmoedit()">
      <?PHP
        echo "<option value=\"0\"";
          if($einsichterst==0){echo " selected";}
          echo ">".$text[2215]."</option>";
        echo "<option value=\"1\"";
          if($einsichterst==1){echo " selected";}
          echo ">".$text[2216]."</option>";
        echo "<option value=\"2\"";
          if($einsichterst==2){echo " selected";}
          echo ">".$text[2217]."</option>";
      ?>
      </select>
    </td>
  </tr>
  <tr>
    <td class="lmost5" width="20">&nbsp;</td>
    <td class="lmost5" align="right"><nobr><?PHP echo $text[2204]; ?></nobr></td>
    <td class="lmost5"><input class="lmoadminein" type="text" name="xanzseite" size="10" maxlength="5" value="<?PHP echo $anzseite; ?>" onChange="dolmoedit()"></td>
  </tr>
  <tr>
    <td class="lmost4" colspan="3"><nobr><?PHP echo $text[2172]; ?></nobr></td>
  </tr>
  <tr>
    <td class="lmost5" width="20">&nbsp;</td>
    <td class="lmost5" align="right"><nobr><?PHP echo $text[2183]; ?></nobr></td>
    <td class="lmost5">
      <select name="xtipptabelle" onChange="dolmoedit()">
      <?PHP
        echo "<option value=\"1\"";
          if($tipptabelle==1){echo " selected";}
          echo ">".$text[181]."</option>";
        echo "<option value=\"0\"";
          if($tipptabelle==0){echo " selected";}
          echo ">".$text[182]."</option>";
      ?>
      </select>
    </td>
  </tr>
  <tr>
    <td class="lmost5" width="20">&nbsp;</td>
    <td class="lmost5" align="right"><nobr><?PHP echo $text[2260]; ?></nobr></td>
    <td class="lmost5">
      <select name="xwertverein" onChange="dolmoedit()">
      <?PHP
        echo "<option value=\"1\"";
          if($wertverein==1){echo " selected";}
          echo ">".$text[181]."</option>";
        echo "<option value=\"0\"";
          if($wertverein==0){echo " selected";}
          echo ">".$text[182]."</option>";
      ?>
      </select><?PHP echo $text[2282]; ?>
    </td>
  </tr>
  <tr>
    <td class="lmost4" colspan="3"><nobr><?PHP echo $text[2247]; ?></nobr></td>
  </tr>
  <tr>
    <td class="lmost5" width="20">&nbsp;</td>
    <td class="lmost5" align="right"><nobr><?PHP echo $text[2200]; ?></nobr></td>
    <td class="lmost5"><nobr>
    <input type="checkbox" name="xshownick" value="1" <?PHP if($shownick==1){echo "checked";} ?> onClick="dolmoedit()"><?PHP echo $text[2023]; ?>
    <input type="checkbox" name="xshowname" value="1" <?PHP if($showname==1){echo "checked";} ?> onClick="dolmoedit()"><?PHP echo $text[2134]; ?>
    <input type="checkbox" name="xshowemail" value="1" <?PHP if($showemail==1){echo "checked";} ?> onClick="dolmoedit()"><?PHP echo "E-mail"; ?>
    </nobr></td>
  </tr>
  <tr>
    <td class="lmost5" width="20">&nbsp;</td>
    <td class="lmost5" align="right"><nobr><?PHP echo $text[2204]; ?></nobr></td>
    <td class="lmost5"><input class="lmoadminein" type="text" name="xanzseite1" size="10" maxlength="5" value="<?PHP echo $anzseite1; ?>" onChange="dolmoedit()"></td>
  </tr>
  <tr>
    <td class="lmost5" width="20">&nbsp;</td>
    <td class="lmost5" align="right"><nobr><?PHP echo $text[2251]; ?></nobr></td>
    <td class="lmost5">
      <select name="xshowzus" onChange="dolmoedit()">
      <?PHP
        echo "<option value=\"1\"";
          if($showzus==1){echo " selected";}
          echo ">".$text[181]."</option>";
        echo "<option value=\"0\"";
          if($showzus==0){echo " selected";}
          echo ">".$text[182]."</option>";
      ?>
      </select><?PHP echo $text[2282]; ?>
    </td>
  </tr>
  <tr>
    <td class="lmost5" width="20">&nbsp;</td>
    <td class="lmost5" align="right"><nobr><?PHP echo $text[2272]; ?></nobr></td>
    <td class="lmost5">
      <select name="xshowstsiege" onChange="dolmoedit()">
      <?PHP
        echo "<option value=\"1\"";
          if($showstsiege==1){echo " selected";}
          echo ">".$text[181]."</option>";
        echo "<option value=\"0\"";
          if($showstsiege==0){echo " selected";}
          echo ">".$text[182]."</option>";
      ?>
      </select>
    </td>
  </tr>
  <tr>
    <td class="lmost4" colspan="3"><nobr><?PHP echo $text[2274]; ?></nobr></td>
  </tr>
  <tr>
    <td class="lmost5" width="20">&nbsp;</td>
    <td class="lmost5" align="right"><nobr><?PHP echo $text[2275]." 1"; ?></nobr></td>
    <td class="lmost5">
      <select name="xkrit1" onChange="dolmoedit()">
      <?PHP
        echo "<option value=\"-1\"";
          if($krit1==-1){echo " selected";}
          echo ">".$text[2281]."</option>";
        echo "<option value=\"0\"";
          if($krit1==0){echo " selected";}
          echo ">".$text[2276]."</option>";
        echo "<option value=\"1\"";
          if($krit1==1){echo " selected";}
          echo ">".$text[2277]."</option>";
        echo "<option value=\"2\"";
          if($krit1==2){echo " selected";}
          echo ">".$text[2278]."</option>";
        echo "<option value=\"3\"";
          if($krit1==3){echo " selected";}
          echo ">".$text[2279]."</option>";
        echo "<option value=\"4\"";
          if($krit1==4){echo " selected";}
          echo ">".$text[2280]."</option>";
        echo "<option value=\"5\"";
          if($krit1==5){echo " selected";}
          echo ">".$text[2227]."</option>";
        echo "<option value=\"6\"";
          if($krit1==6){echo " selected";}
          echo ">".$text[2271]."</option>";
      ?>
      </select>
    </td>
  </tr>
  <tr>
    <td class="lmost5" width="20">&nbsp;</td>
    <td class="lmost5" align="right"><nobr><?PHP echo $text[2275]." 2"; ?></nobr></td>
    <td class="lmost5">
      <select name="xkrit2" onChange="dolmoedit()">
      <?PHP
        echo "<option value=\"-1\"";
          if($krit2==-1){echo " selected";}
          echo ">".$text[2281]."</option>";
        echo "<option value=\"0\"";
          if($krit2==0){echo " selected";}
          echo ">".$text[2276]."</option>";
        echo "<option value=\"1\"";
          if($krit2==1){echo " selected";}
          echo ">".$text[2277]."</option>";
        echo "<option value=\"2\"";
          if($krit2==2){echo " selected";}
          echo ">".$text[2278]."</option>";
        echo "<option value=\"3\"";
          if($krit2==3){echo " selected";}
          echo ">".$text[2279]."</option>";
        echo "<option value=\"4\"";
          if($krit2==4){echo " selected";}
          echo ">".$text[2280]."</option>";
        echo "<option value=\"5\"";
          if($krit2==5){echo " selected";}
          echo ">".$text[2227]."</option>";
        echo "<option value=\"6\"";
          if($krit2==6){echo " selected";}
          echo ">".$text[2271]."</option>";
      ?>
      </select>
    </td>
  </tr>
  <tr>
    <td class="lmost5" width="20">&nbsp;</td>
    <td class="lmost5" align="right"><nobr><?PHP echo $text[2275]." 3"; ?></nobr></td>
    <td class="lmost5">
      <select name="xkrit3" onChange="dolmoedit()">
      <?PHP
        echo "<option value=\"-1\"";
          if($krit3==-1){echo " selected";}
          echo ">".$text[2281]."</option>";
        echo "<option value=\"0\"";
          if($krit3==0){echo " selected";}
          echo ">".$text[2276]."</option>";
        echo "<option value=\"1\"";
          if($krit3==1){echo " selected";}
          echo ">".$text[2277]."</option>";
        echo "<option value=\"2\"";
          if($krit3==2){echo " selected";}
          echo ">".$text[2278]."</option>";
        echo "<option value=\"3\"";
          if($krit3==3){echo " selected";}
          echo ">".$text[2279]."</option>";
        echo "<option value=\"4\"";
          if($krit3==4){echo " selected";}
          echo ">".$text[2280]."</option>";
        echo "<option value=\"5\"";
          if($krit3==5){echo " selected";}
          echo ">".$text[2227]."</option>";
        echo "<option value=\"6\"";
          if($krit3==6){echo " selected";}
          echo ">".$text[2271]."</option>";
      ?>
      </select>
    </td>
  </tr>
  <tr>
    <td class="lmost4" colspan="3"><nobr><?PHP echo $text[2163]; ?></nobr></td>
  </tr>
  <tr>
    <td class="lmost5" width="20">&nbsp;</td>
    <td class="lmost5" align="right"><nobr><?PHP echo $text[2081]; ?></nobr></td>
    <td class="lmost5">
      <select name="xaktauswert" onChange="dolmoedit()">
      <?PHP
        echo "<option value=\"1\"";
          if($aktauswert==1){echo " selected";}
          echo ">".$text[181]."</option>";
        echo "<option value=\"0\"";
          if($aktauswert==0){echo " selected";}
          echo ">".$text[182]."</option>";
      ?>
      </select>
    </td>
  </tr>
  <tr>
    <td class="lmost5" width="20">&nbsp;</td>
    <td class="lmost5" align="right"><nobr><?PHP echo $text[2180]; ?></nobr></td>
    <td class="lmost5">
      <select name="xaktauswertges" onChange="dolmoedit()">
      <?PHP
        echo "<option value=\"1\"";
          if($aktauswertges==1){echo " selected";}
          echo ">".$text[181]."</option>";
        echo "<option value=\"0\"";
          if($aktauswertges==0){echo " selected";}
          echo ">".$text[182]."</option>";
      ?>
      </select>
    </td>
  </tr>
  <tr>
    <td class="lmost4" colspan="3"><nobr><?PHP echo $text[2103]; ?></nobr></td>
  </tr>
  <tr>
    <td class="lmost5" width="20">&nbsp;</td>
    <td class="lmost5" align="right"><nobr><?PHP echo $text[2104]; ?></nobr></td>
    <td class="lmost5">
      <select name="ximmeralle" onChange="immerallechange()">
      <?PHP
        echo "<option value=\"1\"";
          if($immeralle==1){echo " selected";}
          echo ">".$text[181]."</option>";
        echo "<option value=\"0\"";
          if($immeralle==0){echo " selected";}
          echo ">".$text[182]."</option>";
      ?>
      </select>
    </td>
  </tr>
  <tr>
  <tr>
      <td class="lmost5" width="20">&nbsp;</td>
      <td class="lmost5" align="left" colspan="2">
<?PHP
 echo $text[2105]."<br>";
 $ftype=".l98"; require(PATH_TO_LMO."/lmo-tippnewdir.php"); 
?></td>
 </tr>
  <tr><td class="lmost4" colspan="3" align="right">
      <input class="lmoadminbut" type="submit" name="best" value="<?PHP echo $text[188]; ?>">
  </td></tr>
  </form>
  </table></td></tr>
  <tr>
    <td><table width="100%" cellspacing="0" cellpadding="0" border="0"><tr>
<?PHP 
  echo "<td class=\"lmost2\" align=\"center\"><a href='$adda' onclick=\"return chklmolink(this.href);\" title=\"".$text[2063]."\">".$text[2063]."</a></td>";
  echo "<td class=\"lmost2\" align=\"center\"><a href='$adde' onclick=\"return chklmolink(this.href);\" title=\"".$text[2165]."\">".$text[2165]."</a></td>";
  echo "<td class=\"lmost2\" align=\"center\"><a href='$addu' onclick=\"return chklmolink(this.href);\" title=\"".$text[2114]."\">".$text[2114]."</a></td>";
  echo "<td class=\"lmost1\" align=\"center\">".$text[86]."</td>";
?>
    </tr></table></td>
  </tr>
</table>