<?
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
$show=isset($_REQUEST['show'])?$_REQUEST['show']:0;
$save=isset($_POST['save'])?$_POST['save']:0;
if($save==1){
  require(PATH_TO_ADDONDIR."/tipp/lmo-admintippgetoptions.php");
  require(PATH_TO_LMO."/lmo-savecfg.php");
}
$adda=$_SERVER['PHP_SELF']."?action=admin&amp;todo=tipp";
$addu=$_SERVER['PHP_SELF']."?action=admin&amp;todo=tippuser";
$adde=$_SERVER['PHP_SELF']."?action=admin&amp;todo=tippemail";

include_once(PATH_TO_ADDONDIR."/tipp/lmo-admintippjavascript.php");
include_once(PATH_TO_LMO."/lmo-adminjavascript.php");
?>


<table class="lmosta" cellspacing="0" cellpadding="0" border="0">
  <tr>
    <td class="lmost1" align="center"><? echo $text['tipp'][33] ?></td>
  </tr>
  <tr>
    <td valign="top">
      <table cellspacing="0" cellpadding="0" border="0">
        <tr><td align="right"<?if ($show==0) {?> class="lmost1"><?=$text['tipp'][91]; ?><?}else{?> class="lmost4"><a href="<?=$_SERVER['PHP_SELF']."?action=admin&todo=edit&amp;show=0&amp;file=$file&amp;st=-1";?>"><?=$text['tipp'][91]; ?></a><?}?></td></tr>
        <tr><td align="right"<?if ($show==1) {?> class="lmost1"><?=$text[220]; ?><?}else{?> class="lmost4"><a href="<?=$_SERVER['PHP_SELF']."?action=admin&todo=edit&amp;show=0&amp;file=$file&amp;st=-1";?>"><?=$text[220]; ?></a><?}?></td></tr>
        <tr><td align="right"<?if ($show==2) {?> class="lmost1"><?=$text['tipp'][32]; ?><?}else{?> class="lmost4"><a href="<?=$_SERVER['PHP_SELF']."?action=admin&todo=edit&amp;show=0&amp;file=$file&amp;st=-1";?>"><?=$text['tipp'][32]; ?></a><?}?></td></tr>
        <tr><td align="right"<?if ($show==3) {?> class="lmost1"><?=$text['tipp'][240]; ?><?}else{?> class="lmost4"><a href="<?=$_SERVER['PHP_SELF']."?action=admin&todo=edit&amp;show=0&amp;file=$file&amp;st=-1";?>"><?=$text['tipp'][240]; ?></a><?}?></td></tr>
        <tr><td align="right"<?if ($show==4) {?> class="lmost1"><?=$text['tipp'][214]; ?><?}else{?> class="lmost4"><a href="<?=$_SERVER['PHP_SELF']."?action=admin&todo=edit&amp;show=0&amp;file=$file&amp;st=-1";?>"><?=$text['tipp'][214]; ?></a><?}?></td></tr>
        <tr><td align="right"<?if ($show==5) {?> class="lmost1"><?=$text['tipp'][239]; ?><?}else{?> class="lmost4"><a href="<?=$_SERVER['PHP_SELF']."?action=admin&todo=edit&amp;show=0&amp;file=$file&amp;st=-1";?>"><?=$text['tipp'][239]; ?></a><?}?></td></tr>
        <tr><td align="right"<?if ($show==6) {?> class="lmost1"><?=$text['tipp'][246]; ?><?}else{?> class="lmost4"><a href="<?=$_SERVER['PHP_SELF']."?action=admin&todo=edit&amp;show=0&amp;file=$file&amp;st=-1";?>"><?=$text['tipp'][246]; ?></a><?}?></td></tr>
        <tr><td align="right"<?if ($show==7) {?> class="lmost1"><?=$text['tipp'][157]; ?><?}else{?> class="lmost4"><a href="<?=$_SERVER['PHP_SELF']."?action=admin&todo=edit&amp;show=0&amp;file=$file&amp;st=-1";?>"><?=$text['tipp'][157]; ?></a><?}?></td></tr>
        <tr><td align="right"<?if ($show==8) {?> class="lmost1"><?=$text['tipp'][172]; ?><?}else{?> class="lmost4"><a href="<?=$_SERVER['PHP_SELF']."?action=admin&todo=edit&amp;show=0&amp;file=$file&amp;st=-1";?>"><?=$text['tipp'][172]; ?></a><?}?></td></tr>
        <tr><td align="right"<?if ($show==9) {?> class="lmost1"><?=$text['tipp'][247]; ?><?}else{?> class="lmost4"><a href="<?=$_SERVER['PHP_SELF']."?action=admin&todo=edit&amp;show=0&amp;file=$file&amp;st=-1";?>"><?=$text['tipp'][247]; ?></a><?}?></td></tr>
        <tr><td align="right"<?if ($show==10) {?> class="lmost1"><?=$text['tipp'][274]; ?><?}else{?> class="lmost4"><a href="<?=$_SERVER['PHP_SELF']."?action=admin&todo=edit&amp;show=0&amp;file=$file&amp;st=-1";?>"><?=$text['tipp'][274]; ?></a><?}?></td></tr>
        <tr><td align="right"<?if ($show==11) {?> class="lmost1"><?=$text['tipp'][163]; ?><?}else{?> class="lmost4"><a href="<?=$_SERVER['PHP_SELF']."?action=admin&todo=edit&amp;show=0&amp;file=$file&amp;st=-1";?>"><?=$text['tipp'][163]; ?></a><?}?></td></tr>
        <tr><td align="right"<?if ($show==12) {?> class="lmost1"><?=$text['tipp'][103]; ?><?}else{?> class="lmost4"><a href="<?=$_SERVER['PHP_SELF']."?action=admin&todo=edit&amp;show=0&amp;file=$file&amp;st=-1";?>"><?=$text['tipp'][103]; ?></a><?}?></td></tr>
      </table>
    </td>
    <td align="center" valign="top" class="lmost3">
      <form name="lmoedit" action="<? echo $_SERVER['PHP_SELF']; ?>" method="post" onSubmit="return chklmopass()">
        <input type="hidden" name="action" value="admin">
        <input type="hidden" name="todo" value="tippoptions">
        <input type="hidden" name="save" value="1">
        <table class="lmostb" cellspacing="0" cellpadding="0" border="0"><?
  if ($show==0) {?>
          <tr>
            <td class="lmost5" width="20">&nbsp;</td>
            <td class="lmost5" align="right"><? echo $text['tipp'][91]; ?></td>
            <td class="lmost5">
              <select name="xtippmodus" onChange="moduschange()">
                <option value="1"<?if($tipp_tippmodus==1){echo " selected";}?>><?=$text['tipp'][92]?></option>
                <option value="0"<?if($tipp_tippmodus==0){echo " selected";}?>><?=$text['tipp'][93]?></option>
              </select>
            </td>
          </tr><? 
  }elseif ($show==1) {?>
          <tr>
            <td class="lmost5" width="20">&nbsp;</td>
            <td class="lmost5" align="right"><? echo $text['tipp'][39]; ?></td>
            <td class="lmost5"><input class="lmoadminein" type="text" name="xdirtipp" size="20" maxlength="80" value="<? echo $tipp_dirtipp; ?>" onChange="dolmoedit()"></td>
          </tr><? 
  }elseif ($show==2) {?>
          <tr>
            <td class="lmost5" width="20">&nbsp;</td>
            <td class="lmost5" align="right"><? echo $text['tipp'][34]; ?></td>
            <td class="lmost5"><input class="lmoadminein" type="text" name="xrergebnis" size="5" maxlength="5" value="<? echo $tipp_rergebnis; ?>" onChange="dolmoedit()"<? if($tipp_tippmodus==0){echo " disabled";} ?>>&nbsp;<? echo $text['tipp'][38]; ?></td>
          </tr>
          <tr>
            <td class="lmost5" width="20">&nbsp;</td>
            <td class="lmost5" align="right"><? echo $text['tipp'][35]; ?></td>
            <td class="lmost5"><input class="lmoadminein" type="text" name="xrtendenzdiff" size="5" maxlength="5" value="<? echo $tipp_rtendenzdiff; ?>" onChange="dolmoedit()"<? if($tipp_tippmodus==0){echo " disabled";} ?>>&nbsp;<? echo $text['tipp'][38]; ?></td>
          </tr>
          <tr>
            <td class="lmost5" width="20">&nbsp;</td>
            <td class="lmost5" align="right"><? echo $text['tipp'][36]; ?></td>
            <td class="lmost5"><input class="lmoadminein" type="text" name="xrtendenz" size="5" maxlength="5" value="<? echo $tipp_rtendenz; ?>" onChange="dolmoedit()"<? if($tipp_tippmodus==0){echo " disabled";} ?>>&nbsp;<? echo $text['tipp'][38]; ?></td>
          </tr>
          <tr>
            <td class="lmost5" width="20">&nbsp;</td>
            <td class="lmost5" align="right"><? echo $text['tipp'][37]; ?></td>
            <td class="lmost5"><input class="lmoadminein" type="text" name="xrtor" size="5" maxlength="5" value="<? echo $tipp_rtor; ?>" onChange="dolmoedit()"<? if($tipp_tippmodus==0){echo " disabled";} ?>>&nbsp;<? echo $text['tipp'][38]; ?></td>
          </tr>
          <tr>
            <td class="lmost5" width="20">&nbsp;</td>
            <td class="lmost5" align="right"><? echo $text['tipp'][189]; ?></td>
            <td class="lmost5">
              <select name="xrtendenztor" onChange="dolmoedit()"<? if($tipp_tippmodus==0){echo " disabled";}?>>
                <option value="1"<?if($tipp_rtendenztor==1){echo " selected";}?>><?=$text['tipp'][190]?></option>
                <option value="0"<?if($tipp_rtendenztor==0){echo " selected";}?>><?=$text['tipp'][191]?></option>
              </select>
            </td>
          </tr>
          <tr>
            <td class="lmost5" width="20">&nbsp;</td>
            <td class="lmost5" align="right"><? echo $text['tipp'][193]; ?></td>
            <td class="lmost5">
              <select name="xrtendenzremis" onChange="dolmoedit()"<? if($tipp_tippmodus==0){echo " disabled";}?>>
                <option value="1"<?if($tipp_rtendenzremis==1){echo " selected";}?>><?=$text['tipp'][194]?></option>
                <option value="0"<?if($tipp_rtendenzremis==0){echo " selected";}?>><?=$text['tipp'][195]?></option>
              </select>
            </td>
          </tr>
          <tr>
            <td class="lmost5" width="20">&nbsp;</td>
            <td class="lmost5" align="right"><? echo $text['tipp'][192]; ?></td>
            <td class="lmost5"><input class="lmoadminein" type="text" name="xrremis" size="5" maxlength="5" value="<? echo $tipp_rremis; ?>" onChange="dolmoedit()">&nbsp;<? echo $text['tipp'][38]; ?></td>
          </tr>
          <tr>
            <td class="lmost5" width="20">&nbsp;</td>
            <td class="lmost5" align="right"><? echo $text['tipp'][152]; ?></td>
            <td class="lmost5"><input type="checkbox" name="xentscheidungnv" onClick="dolmoedit()"<?if($tipp_entscheidungnv==1){echo " checked";}?>></td>
          </tr>
          <tr>
            <td class="lmost5" width="20">&nbsp;</td>
            <td class="lmost5" align="right"><? echo $text['tipp'][153]; ?></td>
            <td class="lmost5"><input type="checkbox" name="xentscheidungie" onClick="dolmoedit()"<?if($tipp_entscheidungie==1){echo " checked";}?>></td>
          </tr>
          <tr>
            <td class="lmost5" width="20">&nbsp;</td>
            <td class="lmost5" align="right"><? echo $text['tipp'][196]; ?></td>
            <td class="lmost5">
              <select name="xgtpunkte" onChange="dolmoedit()">
                <option value="0"<?if($tipp_gtpunkte==0){echo " selected";}?>><?=$text['tipp'][197]?></option>
                <option value="1"<?if($tipp_gtpunkte==1){echo " selected";}?>><?=$text['tipp'][198]?></option>
                <option value="2"<?if($tipp_gtpunkte==2){echo " selected";}?>><?=$text['tipp'][199]?></option>
              </select>
            </td>
          </tr><? 
  }elseif ($show==3) {?>
          <tr>
            <td class="lmost5" width="20">&nbsp;</td>
            <td class="lmost5" align="right"><? echo $text['tipp'][157]; ?></td>
            <td class="lmost5"><input type="checkbox" name="xtippeinsicht" onClick="dolmoedit()"<?if($tipp_tippeinsicht==1){echo " checked";}?>></td>
          </tr>
          <tr>
            <td class="lmost5" width="20">&nbsp;</td>
            <td class="lmost5" align="right"><? echo $text['tipp'][172]; ?></td>
            <td class="lmost5"><input type="checkbox" name="xtipptabelle1" onClick="dolmoedit()"<?if($tipp_tippeinsicht==1){echo " checked";}?>></td>
          </tr>
          <tr>
            <td class="lmost5" width="20">&nbsp;</td>
            <td class="lmost5" align="right"><? echo $text[133]; ?></td>
            <td class="lmost5"><input type="checkbox" name="xtippfieber" onClick="dolmoedit()"<?if($tipp_tippeinsicht==1){echo " checked";}?>></td>
          </tr>
          <tr>
            <td class="lmost5" width="20">&nbsp;</td>
            <td class="lmost5" align="right"><? echo $text['tipp'][56]; ?></td>
            <td class="lmost5"><input type="checkbox" name="xgesamt" onClick="dolmoedit()"<?if($tipp_tippeinsicht==1){echo " checked";}?>></select>
            </td>
          </tr>
          <tr>
            <td class="lmost5" width="20">&nbsp;</td>
            <td class="lmost5" align="right"><? echo $text['tipp'][187]; ?></td>
            <td class="lmost5"><input type="checkbox" name="xregeln" onClick="regelnchange()"<?if($tipp_regeln==1){echo " checked";}?>></td>
          </tr>
          <tr>
            <td class="lmost5" width="20">&nbsp;</td>
            <td class="lmost5" align="right"><? echo $text['tipp'][186]; ?></td>
            <td class="lmost5"><input class="lmoadminein" type="text" name="xregelnlink" size="30" maxlength="256" value="<? echo $tipp_regelnlink; ?>" onChange="dolmoedit()"<? if($tipp_regeln==0){echo " disabled";}?>></td>
          </tr><? 
  }elseif ($show==4) {?>
          <tr>
            <td class="lmost5" width="20">&nbsp;</td>
            <td class="lmost5" align="right"><? echo $text['tipp'][87]; ?></td>
            <td class="lmost5"><input class="lmoadminein" type="text" name="xtippbis" size="5" maxlength="5" value="<? echo $tipp_tippBis; ?>" onChange="dolmoedit()"><? echo " ".$text['tipp'][88]; ?></td>
          </tr>
          <tr>
            <td class="lmost5" width="20">&nbsp;</td>
            <td class="lmost5" align="right"><? echo $text['tipp'][248]; ?></td>
            <td class="lmost5">
              <select name="xtippohne" onChange="dolmoedit()">
                <option value="1"<?if($tipp_tippohne==1){echo " selected";}?>><?=$text['tipp'][249]?></option>
                <option value="0"<?if($tipp_tippohne==0){echo " selected";}?>><?=$text['tipp'][250]?></option>
              </select>
            </td>
          </tr>
          <tr>
            <td class="lmost5" width="20">&nbsp;</td>
            <td class="lmost5" align="right"><? echo $text['tipp'][100]; ?></td>
            <td class="lmost5">
              <select name="xtipperteam" onChange="dolmoedit()">
                <option value="-1"<?if($tipp_tipperimteam==-1){echo " selected";}?>><?=$text['tipp'][101]?></option>
                <option value="2"<?if($tipp_tipperimteam==2){echo " selected";}?>>2</option>
                <option value="3"<?if($tipp_tipperimteam==3){echo " selected";}?>>3</option>
                <option value="5"<?if($tipp_tipperimteam==5){echo " selected";}?>>5</option>
                <option value="10"<?if($tipp_tipperimteam==10){echo " selected";}?>>10</option>
                <option value="20"<?if($tipp_tipperimteam==20){echo " selected";}?>>20</option>
                <option value="30"<?if($tipp_tipperimteam==30){echo " selected";}?>>30</option>
                <option value="50"<?if($tipp_tipperimteam==50){echo " selected";}?>>50</option>
                <option value="100"<?if($tipp_tipperimteam==100){echo " selected";}?>>100</option>
                <option value="0"<?if($tipp_tipperimteam==0){echo " selected";}?>><?=$text['tipp'][102]?></option>
              </select>
            </td>
          </tr>
          <tr>
            <td class="lmost5" width="20">&nbsp;</td>
            <td class="lmost5" align="right"><? echo $text['tipp'][154]; ?></td>
            <td class="lmost5">
              <select name="ximvorraus" onChange="dolmoedit()">
                <option value="0"<?if($tipp_imvorraus==0){echo " selected";}?>>0</option>
                <option value="1"<?if($tipp_imvorraus==1){echo " selected";}?>>1</option>
                <option value="2"<?if($tipp_imvorraus==2){echo " selected";}?>>2</option>
                <option value="3"<?if($tipp_imvorraus==3){echo " selected";}?>>3</option>
                <option value="4"<?if($tipp_imvorraus==4){echo " selected";}?>>4</option>
                <option value="5"<?if($tipp_imvorraus==5){echo " selected";}?>>5</option>
                <option value="-1"<?if($tipp_imvorraus==-1){echo " selected";}?>><?=$text['tipp'][102]?></option>
              </select>
            </td>
          </tr>
          <tr>
            <td class="lmost5" width="20">&nbsp;</td>
            <td class="lmost5" align="right"><? echo $text['tipp'][288]; ?></td>
            <td class="lmost5"><input type="checkbox" name="xjokertipp" onClick="jokerchange()"<?if($tipp_jokertipp==1){echo " checked";}?>></td>
          </tr>
          <tr>
            <td class="lmost5" width="20">&nbsp;</td>
            <td class="lmost5" align="right"><? echo $text['tipp'][291]; ?></td>
            <td class="lmost5">
              <select name="xjokertippmulti" onChange="dolmoedit()"<? if($tipp_jokertipp==0){echo " disabled";}?>>      
                <option value="1.5"<?if($tipp_jokertippmulti=="1.5"){echo " selected";}?>>1.5</option>
                <option value="2"<?if($tipp_jokertippmulti=="2"){echo " selected";}?>>2</option>
                <option value="2.5"<?if($tipp_jokertippmulti=="2.5"){echo " selected";}?>>2.5</option>
                <option value="3"<?if($tipp_jokertippmulti=="3"){echo " selected";}?>>3</option>
            </td>
          </tr><? 
  }elseif ($show==5) {?>
          <tr>
            <td class="lmost5" width="20">&nbsp;</td>
            <td class="lmost5" align="right"><? echo $text['tipp'][132]; ?></td>
            <td class="lmost5"><input type="checkbox" name="xadresse" onClick="dolmoedit()"<?if($tipp_adresse==1){echo " checked";}?>></td>
          </tr>
          <tr>
            <td class="lmost5" width="20">&nbsp;</td>
            <td class="lmost5" align="right"><? echo $text['tipp'][286]; ?></td>
            <td class="lmost5"><input type="checkbox" name="xrealname" onClick="dolmoedit()"<?if($tipp_realname==1){echo " checked";}?>></td>
          </tr>
          <tr>
            <td class="lmost5" width="20">&nbsp;</td>
            <td class="lmost5" align="right"><? echo $text['tipp'][146]; ?></td>
            <td class="lmost5"><input type="checkbox" name="xfreischaltung" onClick="dolmoedit()"<?if($tipp_freischaltung==1){echo " checked";}?>></td>
          </tr>
          <tr>
            <td class="lmost5" width="20">&nbsp;</td>
            <td class="lmost5" align="right"><? echo $text['tipp'][293]; ?></td>
            <td class="lmost5"><input type="checkbox" name="xmailbeianmeldung" onClick="dolmoedit()"<?if($tipp_mailbeianmeldung==1){echo " checked";}?>></td>
          </tr><? 
  }elseif ($show==6) {?>
          <tr>
            <td class="lmost5" width="20">&nbsp;</td>
            <td class="lmost5" align="right"><? echo $text['tipp'][245]." ".$text['tipp'][294]; ?></td>
            <td class="lmost5"><input type="checkbox" name="xpfeiltipp" onClick="dolmoedit()"<?if($tipp_pfeiltipp==1){echo " checked";}?><? if($tipp_tippmodus==0){echo " disabled";}?>></td>
          </tr>
          <tr>
            <td class="lmost5" width="20">&nbsp;</td>
            <td class="lmost5" align="right"><? echo $text['tipp'][188]." ".$text['tipp'][212]." ".$text['tipp'][294]; ?></td>
            <td class="lmost5"><input type="checkbox" name="xshowtendenzabs" value="1" <? if($tipp_showtendenzabs==1){echo "checked";} ?> onClick="dolmoedit()"></td>
          </tr>
          <tr>
            <td class="lmost5" width="20">&nbsp;</td>
            <td class="lmost5" align="right"><? echo $text['tipp'][188]." ".$text['tipp'][211]." ".$text['tipp'][294]; ?></td>
            <td class="lmost5"><input type="checkbox" name="xshowtendenzpro" value="1" <? if($tipp_showtendenzpro==1){echo "checked";} ?> onClick="dolmoedit()"></td>
          </tr>
          <tr>
            <td class="lmost5" width="20">&nbsp;</td>
            <td class="lmost5" align="right"><? echo $text['tipp'][213]." ".$text['tipp'][294]; ?></td>
            <td class="lmost5"><input type="checkbox" name="xshowdurchschntipp" value="1" <? if($tipp_showdurchschntipp==1){echo "checked";} ?> onClick="dolmoedit()"<? if($tipp_tippmodus==0){echo " disabled";} ?>></td>
          </tr>
          <tr>
            <td class="lmost5" width="20">&nbsp;</td>
            <td class="lmost5" align="right"><? echo $text['tipp'][259]; ?></td>
            <td class="lmost5"><input type="checkbox" name="xsttipp" onClick="dolmoedit()"<?if($tipp_sttipp==1){echo " checked";}?>></td>
          </tr>
          <tr>
            <td class="lmost5" width="20">&nbsp;</td>
            <td class="lmost5" align="right"><? echo $text['tipp'][253]; ?></td>
            <td class="lmost5"><input type="checkbox" name="xviewertipp" onClick="viewerchange()"<?if($tipp_viewertipp==1){echo " checked";}?>></td>
          </tr>
          <tr>
            <td class="lmost5" width="20">&nbsp;</td>
            <td class="lmost5" align="right"><? echo $text['tipp'][254]; ?></td>
            <td class="lmost5"><input class="lmoadminein" type="text" name="xviewertage" size="2" maxlength="2" value="<? echo $tipp_viewertage; ?>" onChange="dolmoedit()"<? if($tipp_viewertipp==0){echo " disabled";} ?>>&nbsp;<? echo $text['tipp'][171]; ?></td>
          </tr>
          <tr>
            <td class="lmost5" width="20">&nbsp;</td>
            <td class="lmost5" align="right"><? echo $text['tipp'][161]; ?></td>
            <td class="lmost5"><input type="checkbox" name="xakteinsicht" onClick="dolmoedit()"<?if($tipp_akteinsicht==1){echo " checked";}?>></td>
          </tr><? 
  }elseif ($show==7) {?>
          <tr>
            <td class="lmost5" width="20">&nbsp;</td>
            <td class="lmost5" align="right"><? echo $text['tipp'][160]; ?></td>
            <td class="lmost5">
              <select name="xeinsichterst" onChange="dolmoedit()">
                <option value="0"<?if($tipp_einsichterst==0){echo " selected";}?>><?=$text['tipp'][215]?></option>
                <option value="1"<?if($tipp_einsichterst==1){echo " selected";}?>><?=$text['tipp'][216]?></option>
                <option value="2"<?if($tipp_einsichterst==2){echo " selected";}?>><?=$text['tipp'][217]?></option>
              </select>
            </td>
          </tr>
          <tr>
            <td class="lmost5" width="20">&nbsp;</td>
            <td class="lmost5" align="right"><? echo $text['tipp'][204]; ?></td>
            <td class="lmost5"><input class="lmoadminein" type="text" name="xanzseite" size="5" maxlength="5" value="<? echo $tipp_anzseite; ?>" onChange="dolmoedit()"></td>
          </tr><? 
  }elseif ($show==8) {?>
          <tr>
            <td class="lmost5" width="20">&nbsp;</td>
            <td class="lmost5" align="right"><? echo $text['tipp'][183]; ?></td>
            <td class="lmost5"><input type="checkbox" name="xtipptabelle" onClick="dolmoedit()"<?if($tipp_tipptabelle==1){echo " checked";}?>></td>
          </tr>
          <tr>
            <td class="lmost5" width="20">&nbsp;</td>
            <td class="lmost5" align="right"><? echo $text['tipp'][260]; ?></td>
            <td class="lmost5"><input type="checkbox" name="xwertverein" onClick="dolmoedit()"<?if($tipp_wertverein==1){echo " checked";}?>></td>
          </tr><? 
  }elseif ($show==9) {?>
          <tr>
            <td class="lmost5" width="20">&nbsp;</td>
            <td class="lmost5" align="right"><? echo $text['tipp'][200]; ?></td>
            <td class="lmost5">
            <input type="checkbox" name="xshownick" value="1" <? if($tipp_shownick==1){echo "checked";} ?> onClick="dolmoedit()"><? echo $text['tipp'][23]; ?>
            <input type="checkbox" name="xshowname" value="1" <? if($tipp_showname==1){echo "checked";} ?> onClick="dolmoedit()"><? echo $text['tipp'][134]; ?>
            <input type="checkbox" name="xshowemail" value="1" <? if($tipp_showemail==1){echo "checked";} ?> onClick="dolmoedit()"><? echo $text['tipp'][219]; ?>
            </td>
          </tr>
          <tr>
            <td class="lmost5" width="20">&nbsp;</td>
            <td class="lmost5" align="right"><? echo $text['tipp'][204]; ?></td>
            <td class="lmost5"><input class="lmoadminein" type="text" name="xanzseite1" size="5" maxlength="5" value="<? echo $tipp_anzseite1; ?>" onChange="dolmoedit()"></td>
          </tr>
          <tr>
            <td class="lmost5" width="20">&nbsp;</td>
            <td class="lmost5" align="right"><? echo $text['tipp'][251]; ?></td>
            <td class="lmost5"><input type="checkbox" name="xshowzus" onClick="dolmoedit()"<?if($tipp_showzus==1){echo " checked";}?>><? echo $text['tipp'][282]; ?></td>
          </tr>
          <tr>
            <td class="lmost5" width="20">&nbsp;</td>
            <td class="lmost5" align="right"><? echo $text['tipp'][272]; ?></td>
            <td class="lmost5"><input type="checkbox" name="xshowstsiege" onClick="dolmoedit()"<?if($tipp_showstsiege==1){echo " checked";}?>></td>
          </tr><? 
  }elseif ($show==10) {?>
          <tr>
            <td class="lmost5" width="20">&nbsp;</td>
            <td class="lmost5" align="right"><? echo $text['tipp'][275]." 1"; ?></td>
            <td class="lmost5">
              <select name="xkrit1" onChange="dolmoedit()">
                <option value="-1"<?if($tipp_krit1==-1){echo " selected";}?>><?=$text['tipp'][281]?></option>
                <option value="0"<?if($tipp_krit1==0){echo " selected";}?>><?=$text['tipp'][276]?></option>
                <option value="1"<?if($tipp_krit1==1){echo " selected";}?>><?=$text['tipp'][277]?></option>
                <option value="2"<?if($tipp_krit1==2){echo " selected";}?>><?=$text['tipp'][278]?></option>
                <option value="3"<?if($tipp_krit1==3){echo " selected";}?>><?=$text['tipp'][289]?></option>
                <option value="4"<?if($tipp_krit1==4){echo " selected";}?>><?=$text['tipp'][280]?></option>
                <option value="5"<?if($tipp_krit1==5){echo " selected";}?>><?=$text['tipp'][227]?></option>
                <option value="6"<?if($tipp_krit1==6){echo " selected";}?>><?=$text['tipp'][271]?></option>
              </select>
            </td>
          </tr>
          <tr>
            <td class="lmost5" width="20">&nbsp;</td>
            <td class="lmost5" align="right"><? echo $text['tipp'][275]." 2"; ?></td>
            <td class="lmost5">
              <select name="xkrit2" onChange="dolmoedit()">
                <option value="-1"<?if($tipp_krit2==-1){echo " selected";}?>><?=$text['tipp'][281]?></option>
                <option value="0"<?if($tipp_krit2==0){echo " selected";}?>><?=$text['tipp'][276]?></option>
                <option value="1"<?if($tipp_krit2==1){echo " selected";}?>><?=$text['tipp'][277]?></option>
                <option value="2"<?if($tipp_krit2==2){echo " selected";}?>><?=$text['tipp'][278]?></option>
                <option value="3"<?if($tipp_krit2==3){echo " selected";}?>><?=$text['tipp'][289]?></option>
                <option value="4"<?if($tipp_krit2==4){echo " selected";}?>><?=$text['tipp'][280]?></option>
                <option value="5"<?if($tipp_krit2==5){echo " selected";}?>><?=$text['tipp'][227]?></option>
                <option value="6"<?if($tipp_krit2==6){echo " selected";}?>><?=$text['tipp'][271]?></option>
              </select>
            </td>
          </tr>
          <tr>
            <td class="lmost5" width="20">&nbsp;</td>
            <td class="lmost5" align="right"><? echo $text['tipp'][275]." 3"; ?></td>
            <td class="lmost5">
              <select name="xkrit3" onChange="dolmoedit()">
                <option value="-1"<?if($tipp_krit3==-1){echo " selected";}?>><?=$text['tipp'][281]?></option>
                <option value="0"<?if($tipp_krit3==0){echo " selected";}?>><?=$text['tipp'][276]?></option>
                <option value="1"<?if($tipp_krit3==1){echo " selected";}?>><?=$text['tipp'][277]?></option>
                <option value="2"<?if($tipp_krit3==2){echo " selected";}?>><?=$text['tipp'][278]?></option>
                <option value="3"<?if($tipp_krit3==3){echo " selected";}?>><?=$text['tipp'][289]?></option>
                <option value="4"<?if($tipp_krit3==4){echo " selected";}?>><?=$text['tipp'][280]?></option>
                <option value="5"<?if($tipp_krit3==5){echo " selected";}?>><?=$text['tipp'][227]?></option>
                <option value="6"<?if($tipp_krit3==6){echo " selected";}?>><?=$text['tipp'][271]?></option>
              </select>
            </td>
          </tr><? 
  }elseif ($show==11) {?>
          <tr>
            <td class="lmost5" width="20">&nbsp;</td>
            <td class="lmost5" align="right"><? echo $text['tipp'][81]; ?></td>
            <td class="lmost5"><input type="checkbox" name="xaktauswert" onClick="dolmoedit()"<?if($tipp_aktauswert==1){echo " checked";}?>></td>
          </tr>
          <tr>
            <td class="lmost5" width="20">&nbsp;</td>
            <td class="lmost5" align="right"><? echo $text['tipp'][180]; ?></td>
            <td class="lmost5"><input type="checkbox" name="xaktauswertges" onClick="dolmoedit()"<?if($tipp_aktauswertges==1){echo " checked";}?>></td>
          </tr><? 
  }elseif ($show==12) {?>
          <tr>
            <td class="lmost5" width="20">&nbsp;</td>
            <td class="lmost5" align="right"><? echo $text['tipp'][104]; ?></td>
            <td class="lmost5"><input type="checkbox" name="ximmeralle" onClick="immerallechange()"<?if($tipp_immeralle==1){echo " checked";}?>></td>
          </tr>
          <tr>
            <td class="lmost5" width="20">&nbsp;</td>
            <td class="lmost5" align="left" colspan="2"><?
                echo$text['tipp'][105]."<br>";
                $ftype=".l98"; 
                require(PATH_TO_ADDONDIR."/tipp/lmo-tippnewdir.php");?>
            </td>
          </tr><? 
  }?>
          <tr>
            <td class="lmost4" colspan="3" align="right">
              <input class="lmoadminbut" type="submit" name="best" value="<? echo $text[188]; ?>">
            </td>
          </tr>
        </table>
      </form>
    </td>
  </tr>
  <tr>
    <td colspan="2">
      <table width="100%" cellspacing="0" cellpadding="0" border="0">
        <tr>
          <td class="lmost2" align="center"><a href='<?=$adda?>' onclick="return chklmolink(this.href);" title="<?=$text['tipp'][63]?>"><?=$text['tipp'][63]?></a></td>
          <td class="lmost2" align="center"><a href='<?=$adde?>' onclick="return chklmolink(this.href);" title="<?=$text['tipp'][165]?>"><?=$text['tipp'][165]?></a></td>
          <td class="lmost2" align="center"><a href='<?=$addu?>' onclick="return chklmolink(this.href);" title="<?=$text['tipp'][114]?>"><?=$text['tipp'][114]?></a></td>
          <td class="lmost1" align="center"><?=$text[86]?></td>
        </tr>
      </table>
    </td>
  </tr>
</table>
<script type="text/javascript">blendall();</script>