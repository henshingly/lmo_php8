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
$show=isset($_REQUEST['show'])?$_REQUEST['show']:0;
$save=isset($_POST['save'])?$_POST['save']:0;
if($save==1){
  require(PATH_TO_ADDONDIR."/tipp/lmo-admintippgetoptions.php");
  require(PATH_TO_LMO."/lmo-savecfg.php");
}
include_once(PATH_TO_ADDONDIR."/tipp/lmo-admintippjavascript.php");
include(PATH_TO_ADDONDIR."/tipp/lmo-admintippmenu.php");
?>

<table class="lmoMiddle" cellspacing="0" cellpadding="0" border="0">
  <tr>
    <td align="center" colspan="2"><h1><?php echo $text['tipp'][33] ?></h1></td>
  </tr>
  <tr>
    <td valign="top">
      <table class="lmoMenu" cellspacing="0" cellpadding="0" border="0">
        <tr><td align="right"><?php if ($show==0) {echo $text['tipp'][91]; ?><?php }else{?><a href="<?php echo $_SERVER['PHP_SELF']."?action=admin&amp;todo=tippoptions&amp;show=0";?>"><?php echo $text['tipp'][91]; ?></a><?php }?></td></tr>
        <tr><td align="right"><?php if ($show==1) {echo $text[220]; ?><?php }else{?><a href="<?php echo $_SERVER['PHP_SELF']."?action=admin&amp;todo=tippoptions&amp;show=1";?>"><?php echo $text[220]; ?></a><?php }?></td></tr>
        <tr><td align="right"><?php if ($show==2) {echo $text['tipp'][32]; ?><?php }else{?><a href="<?php echo $_SERVER['PHP_SELF']."?action=admin&amp;todo=tippoptions&amp;show=2";?>"><?php echo $text['tipp'][32]; ?></a><?php }?></td></tr>
        <tr><td align="right"><?php if ($show==3) {echo $text['tipp'][240]; ?><?php }else{?><a href="<?php echo $_SERVER['PHP_SELF']."?action=admin&amp;todo=tippoptions&amp;show=3";?>"><?php echo $text['tipp'][240]; ?></a><?php }?></td></tr>
        <tr><td align="right"><?php if ($show==4) {echo $text['tipp'][214]; ?><?php }else{?><a href="<?php echo $_SERVER['PHP_SELF']."?action=admin&amp;todo=tippoptions&amp;show=4";?>"><?php echo $text['tipp'][214]; ?></a><?php }?></td></tr>
        <tr><td align="right"><?php if ($show==5) {echo $text['tipp'][239]; ?><?php }else{?><a href="<?php echo $_SERVER['PHP_SELF']."?action=admin&amp;todo=tippoptions&amp;show=5";?>"><?php echo $text['tipp'][239]; ?></a><?php }?></td></tr>
        <tr><td align="right"><?php if ($show==6) {echo $text['tipp'][246]; ?><?php }else{?><a href="<?php echo $_SERVER['PHP_SELF']."?action=admin&amp;todo=tippoptions&amp;show=6";?>"><?php echo $text['tipp'][246]; ?></a><?php }?></td></tr>
        <tr><td align="right"><?php if ($show==7) {echo $text['tipp'][157]; ?><?php }else{?><a href="<?php echo $_SERVER['PHP_SELF']."?action=admin&amp;todo=tippoptions&amp;show=7";?>"><?php echo $text['tipp'][157]; ?></a><?php }?></td></tr>
        <tr><td align="right"><?php if ($show==8) {echo $text['tipp'][172]; ?><?php }else{?><a href="<?php echo $_SERVER['PHP_SELF']."?action=admin&amp;todo=tippoptions&amp;show=8";?>"><?php echo $text['tipp'][172]; ?></a><?php }?></td></tr>
        <tr><td align="right"><?php if ($show==9) {echo $text['tipp'][247]; ?><?php }else{?><a href="<?php echo $_SERVER['PHP_SELF']."?action=admin&amp;todo=tippoptions&amp;show=9";?>"><?php echo $text['tipp'][247]; ?></a><?php }?></td></tr>
        <tr><td align="right"><?php if ($show==10) {echo $text['tipp'][274]; ?><?php }else{?><a href="<?php echo $_SERVER['PHP_SELF']."?action=admin&amp;todo=tippoptions&amp;show=10";?>"><?php echo $text['tipp'][274]; ?></a><?php }?></td></tr>
        <tr><td align="right"><?php if ($show==11) {echo $text['tipp'][163]; ?><?php }else{?><a href="<?php echo $_SERVER['PHP_SELF']."?action=admin&amp;todo=tippoptions&amp;show=11";?>"><?php echo $text['tipp'][163]; ?></a><?php }?></td></tr>
        <tr><td align="right"><?php if ($show==12) {echo $text['tipp'][103]; ?><?php }else{?><a href="<?php echo $_SERVER['PHP_SELF']."?action=admin&amp;todo=tippoptions&amp;show=12";?>"><?php echo $text['tipp'][103]; ?></a><?php }?></td></tr>
      </table>
    </td>
    <td align="center" valign="top">
      <form name="lmoedit" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" onSubmit="return chklmopass()">
        <input type="hidden" name="action" value="admin">
        <input type="hidden" name="todo" value="tippoptions">
        <input type="hidden" name="save" value="1">
        <table class="lmoInner" cellspacing="0" cellpadding="0" border="0"><?php
  if ($show==0) {?>
          <tr>
            <td width="20">&nbsp;</td>
            <td align="right"><?php echo $text['tipp'][91]; ?></td>
            <td align="left">
              <select name="xtippmodus" onChange="moduschange()">
                <option value="1"<?php if($tipp_tippmodus==1){echo " selected";}?>><?php echo $text['tipp'][92]?></option>
                <option value="0"<?php if($tipp_tippmodus==0){echo " selected";}?>><?php echo $text['tipp'][93]?></option>
              </select>
            </td>
          </tr><?php  }elseif ($show==1) {?>
          <tr>
            <td width="20">&nbsp;</td>
            <td align="right"><?php echo $text['tipp'][39]; ?></td>
            <td align="left"><input class="lmo-formular-input" type="text" name="xdirtipp" size="20" maxlength="80" value="<?php echo $tipp_dirtipp; ?>" onChange="dolmoedit()"></td>
          </tr><?php  }elseif ($show==2) {?>
          <tr>
            <td width="20">&nbsp;</td>
            <td align="right"><?php echo $text['tipp'][34]; ?></td>
            <td align="left"><input class="lmo-formular-input" type="text" name="xrergebnis" size="5" maxlength="5" value="<?php echo $tipp_rergebnis; ?>" onChange="dolmoedit()"<?php if($tipp_tippmodus==0){echo " disabled";} ?>>&nbsp;<?php echo $text['tipp'][38]; ?></td>
          </tr>
          <tr>
            <td width="20">&nbsp;</td>
            <td align="right"><?php echo $text['tipp'][35]; ?></td>
            <td align="left"><input class="lmo-formular-input" type="text" name="xrtendenzdiff" size="5" maxlength="5" value="<?php echo $tipp_rtendenzdiff; ?>" onChange="dolmoedit()"<?php if($tipp_tippmodus==0){echo " disabled";} ?>>&nbsp;<?php echo $text['tipp'][38]; ?></td>
          </tr>
          <tr>
            <td width="20">&nbsp;</td>
            <td align="right"><?php echo $text['tipp'][36]; ?></td>
            <td align="left"><input class="lmo-formular-input" type="text" name="xrtendenz" size="5" maxlength="5" value="<?php echo $tipp_rtendenz; ?>" onChange="dolmoedit()"<?php if($tipp_tippmodus==0){echo " disabled";} ?>>&nbsp;<?php echo $text['tipp'][38]; ?></td>
          </tr>
          <tr>
            <td width="20">&nbsp;</td>
            <td align="right"><?php echo $text['tipp'][37]; ?></td>
            <td align="left"><input class="lmo-formular-input" type="text" name="xrtor" size="5" maxlength="5" value="<?php echo $tipp_rtor; ?>" onChange="dolmoedit()"<?php if($tipp_tippmodus==0){echo " disabled";} ?>>&nbsp;<?php echo $text['tipp'][38]; ?></td>
          </tr>
          <tr>
            <td width="20">&nbsp;</td>
            <td align="right"><?php echo $text['tipp'][189]; ?></td>
            <td align="left">
              <select name="xrtendenztor" onChange="dolmoedit()"<?php if($tipp_tippmodus==0){echo " disabled";}?>>
                <option value="1"<?php if($tipp_rtendenztor==1){echo " selected";}?>><?php echo $text['tipp'][190]?></option>
                <option value="0"<?php if($tipp_rtendenztor==0){echo " selected";}?>><?php echo $text['tipp'][191]?></option>
              </select>
            </td>
          </tr>
          <tr>
            <td width="20">&nbsp;</td>
            <td align="right"><?php echo $text['tipp'][193]; ?></td>
            <td align="left">
              <select name="xrtendenzremis" onChange="dolmoedit()"<?php if($tipp_tippmodus==0){echo " disabled";}?>>
                <option value="1"<?php if($tipp_rtendenzremis==1){echo " selected";}?>><?php echo $text['tipp'][194]?></option>
                <option value="0"<?php if($tipp_rtendenzremis==0){echo " selected";}?>><?php echo $text['tipp'][195]?></option>
              </select>
            </td>
          </tr>
          <tr>
            <td width="20">&nbsp;</td>
            <td align="right"><?php echo $text['tipp'][192]; ?></td>
            <td align="left"><input class="lmo-formular-input" type="text" name="xrremis" size="5" maxlength="5" value="<?php echo $tipp_rremis; ?>" onChange="dolmoedit()">&nbsp;<?php echo $text['tipp'][38]; ?></td>
          </tr>
          <tr>
            <td width="20">&nbsp;</td>
            <td align="right"><?php echo $text['tipp'][152]; ?></td>
            <td align="left"><input type="checkbox" name="xentscheidungnv" onClick="dolmoedit()"<?php if($tipp_entscheidungnv==1){echo " checked";}?>></td>
          </tr>
          <tr>
            <td width="20">&nbsp;</td>
            <td align="right"><?php echo $text['tipp'][153]; ?></td>
            <td align="left"><input type="checkbox" name="xentscheidungie" onClick="dolmoedit()"<?php if($tipp_entscheidungie==1){echo " checked";}?>></td>
          </tr>
          <tr>
            <td width="20">&nbsp;</td>
            <td align="right"><?php echo $text['tipp'][196]; ?></td>
            <td align="left">
              <select name="xgtpunkte" onChange="dolmoedit()">
                <option value="0"<?php if($tipp_gtpunkte==0){echo " selected";}?>><?php echo $text['tipp'][197]?></option>
                <option value="1"<?php if($tipp_gtpunkte==1){echo " selected";}?>><?php echo $text['tipp'][198]?></option>
                <option value="2"<?php if($tipp_gtpunkte==2){echo " selected";}?>><?php echo $text['tipp'][199]?></option>
              </select>
            </td>
          </tr><?php  }elseif ($show==3) {?>
          <tr>
            <td width="20">&nbsp;</td>
            <td align="right"><?php echo $text['tipp'][157]; ?></td>
            <td align="left"><input type="checkbox" name="xtippeinsicht" onClick="dolmoedit()"<?php if($tipp_tippeinsicht==1){echo " checked";}?>></td>
          </tr>
          <tr>
            <td width="20">&nbsp;</td>
            <td align="right"><?php echo $text['tipp'][172]; ?></td>
            <td align="left"><input type="checkbox" name="xtipptabelle1" onClick="dolmoedit()"<?php if($tipp_tipptabelle1==1){echo " checked";}?>></td>
          </tr>
          <tr>
            <td width="20">&nbsp;</td>
            <td align="right"><?php echo $text[133]; ?></td>
            <td align="left"><input type="checkbox" name="xtippfieber" onClick="dolmoedit()"<?php if($tipp_tippfieber==1){echo " checked";}?>></td>
          </tr>
          <tr>
            <td width="20">&nbsp;</td>
            <td align="right"><?php echo $text['tipp'][56]; ?></td>
            <td align="left"><input type="checkbox" name="xgesamt" onClick="dolmoedit()"<?php if($tipp_gesamt==1){echo " checked";}?>></select>
            </td>
          </tr>
          <tr>
            <td width="20">&nbsp;</td>
            <td align="right"><?php echo $text['tipp'][187]; ?></td>
            <td align="left"><input type="checkbox" name="xregeln" onClick="regelnchange()"<?php if($tipp_regeln==1){echo " checked";}?>></td>
          </tr>
          <tr>
            <td width="20">&nbsp;</td>
            <td align="right"><?php echo $text['tipp'][186]; ?></td>
            <td align="left"><input class="lmo-formular-input" type="text" name="xregelnlink" size="30" maxlength="256" value="<?php echo $tipp_regelnlink; ?>" onChange="dolmoedit()"<?php if($tipp_regeln==0){echo " disabled";}?>></td>
          </tr>
          <tr>
            <td width="20">&nbsp;</td>
            <td align="right"><?php echo $text['tipp'][200]; ?></td>
            <td align="left">
            <input type="checkbox" name="xshownick" value="1" <?php if($tipp_shownick==1){echo "checked";} ?> onClick="dolmoedit()"><?php echo $text['tipp'][23]; ?>
            <input type="checkbox" name="xshowname" value="1" <?php if($tipp_showname==1){echo "checked";} ?> onClick="dolmoedit()"><?php echo $text['tipp'][134]; ?>
            <input type="checkbox" name="xshowemail" value="1" <?php if($tipp_showemail==1){echo "checked";} ?> onClick="dolmoedit()"><?php echo $text['tipp'][219]; ?>
            </td>
          </tr><?php  }elseif ($show==4) {?>
          <tr>
            <td width="20">&nbsp;</td>
            <td align="right"><?php echo $text['tipp'][87]; ?></td>
            <td align="left"><input class="lmo-formular-input" type="text" name="xtippbis" size="5" maxlength="5" value="<?php echo $tipp_tippBis; ?>" onChange="dolmoedit()"><?php echo " ".$text['tipp'][88]; ?></td>
          </tr>
          <tr>
            <td width="20">&nbsp;</td>
            <td align="right"><?php echo $text['tipp'][248]; ?></td>
            <td align="left">
              <select name="xtippohne" onChange="dolmoedit()">
                <option value="1"<?php if($tipp_tippohne==1){echo " selected";}?>><?php echo $text['tipp'][249]?></option>
                <option value="0"<?php if($tipp_tippohne==0){echo " selected";}?>><?php echo $text['tipp'][250]?></option>
              </select>
            </td>
          </tr>
          <tr>
            <td width="20">&nbsp;</td>
            <td align="right"><?php echo $text['tipp'][100]; ?></td>
            <td align="left">
              <select name="xtipperteam" onChange="dolmoedit()">
                <option value="-1"<?php if($tipp_tipperimteam==-1){echo " selected";}?>><?php echo $text['tipp'][101]?></option>
                <option value="2"<?php if($tipp_tipperimteam==2){echo " selected";}?>>2</option>
                <option value="3"<?php if($tipp_tipperimteam==3){echo " selected";}?>>3</option>
                <option value="5"<?php if($tipp_tipperimteam==5){echo " selected";}?>>5</option>
                <option value="10"<?php if($tipp_tipperimteam==10){echo " selected";}?>>10</option>
                <option value="20"<?php if($tipp_tipperimteam==20){echo " selected";}?>>20</option>
                <option value="30"<?php if($tipp_tipperimteam==30){echo " selected";}?>>30</option>
                <option value="50"<?php if($tipp_tipperimteam==50){echo " selected";}?>>50</option>
                <option value="100"<?php if($tipp_tipperimteam==100){echo " selected";}?>>100</option>
                <option value="0"<?php if($tipp_tipperimteam==0){echo " selected";}?>><?php echo $text['tipp'][102]?></option>
              </select>
            </td>
          </tr>
          <tr>
            <td width="20">&nbsp;</td>
            <td align="right"><?php echo $text['tipp'][154]; ?></td>
            <td align="left">
              <select name="ximvorraus" onChange="dolmoedit()">
                <option value="0"<?php if($tipp_imvorraus==0){echo " selected";}?>>0</option>
                <option value="1"<?php if($tipp_imvorraus==1){echo " selected";}?>>1</option>
                <option value="2"<?php if($tipp_imvorraus==2){echo " selected";}?>>2</option>
                <option value="3"<?php if($tipp_imvorraus==3){echo " selected";}?>>3</option>
                <option value="4"<?php if($tipp_imvorraus==4){echo " selected";}?>>4</option>
                <option value="5"<?php if($tipp_imvorraus==5){echo " selected";}?>>5</option>
                <option value="-1"<?php if($tipp_imvorraus==-1){echo " selected";}?>><?php echo $text['tipp'][102]?></option>
              </select>
            </td>
          </tr>
          <tr>
            <td width="20">&nbsp;</td>
            <td align="right"><?php echo $text['tipp'][288]; ?></td>
            <td align="left"><input type="checkbox" name="xjokertipp" onClick="jokerchange()"<?php if($tipp_jokertipp==1){echo " checked";}?>></td>
          </tr>
          <tr>
            <td width="20">&nbsp;</td>
            <td align="right"><?php echo $text['tipp'][291]; ?></td>
            <td align="left">
              <select name="xjokertippmulti" onChange="dolmoedit()"<?php if($tipp_jokertipp==0){echo " disabled";}?>>
                <option value="1.5"<?php if($tipp_jokertippmulti=="1.5"){echo " selected";}?>>1.5</option>
                <option value="2"<?php if($tipp_jokertippmulti=="2"){echo " selected";}?>>2</option>
                <option value="2.5"<?php if($tipp_jokertippmulti=="2.5"){echo " selected";}?>>2.5</option>
                <option value="3"<?php if($tipp_jokertippmulti=="3"){echo " selected";}?>>3</option>
            </td>
          </tr><?php  }elseif ($show==5) {?>
          <tr>
            <td width="20">&nbsp;</td>
            <td align="right"><?php echo $text['tipp'][132]; ?></td>
            <td align="left"><input type="checkbox" name="xadresse" onClick="dolmoedit()"<?php if($tipp_adresse==1){echo " checked";}?>></td>
          </tr>
          <tr>
            <td width="20">&nbsp;</td>
            <td align="right"><?php echo $text['tipp'][286]; ?></td>
            <td align="left"><input type="checkbox" name="xrealname" onClick="dolmoedit()"<?php if($tipp_realname==1){echo " checked";}?>></td>
          </tr>
          <tr>
            <td width="20">&nbsp;</td>
            <td align="right"><?php echo $text['tipp'][299]; ?></td>
            <td align="left"><input type="checkbox" name="xfreischaltcode" onClick="dolmoedit()"<?php if($tipp_freischaltcode==1){echo " checked";}?>></td>
          </tr>
          <tr>
            <td width="20">&nbsp;</td>
            <td align="right"><?php echo $text['tipp'][146]; ?></td>
            <td align="left"><input type="checkbox" name="xfreischaltung" onClick="dolmoedit()"<?php if($tipp_freischaltung==1){echo " checked";}?>></td>
          </tr>
          <tr>
            <td width="20">&nbsp;</td>
            <td align="right"><?php echo $text['tipp'][293]; ?></td>
            <td align="left"><input type="checkbox" name="xmailbeianmeldung" onClick="dolmoedit()"<?php if($tipp_mailbeianmeldung==1){echo " checked";}?>></td>
          </tr><?php  }elseif ($show==6) {?>
          <tr>
            <td width="20">&nbsp;</td>
            <td align="right"><?php echo $text['tipp'][245]." ".$text['tipp'][294]; ?></td>
            <td align="left"><input type="checkbox" name="xpfeiltipp" onClick="dolmoedit()"<?php if($tipp_pfeiltipp==1){echo " checked";}?><?php if($tipp_tippmodus==0){echo " disabled";}?>></td>
          </tr>
          <tr>
            <td width="20">&nbsp;</td>
            <td align="right"><?php echo $text['tipp'][188]." ".$text['tipp'][212]." ".$text['tipp'][294]; ?></td>
            <td align="left"><input type="checkbox" name="xshowtendenzabs" value="1" <?php if($tipp_showtendenzabs==1){echo "checked";} ?> onClick="dolmoedit()"></td>
          </tr>
          <tr>
            <td width="20">&nbsp;</td>
            <td align="right"><?php echo $text['tipp'][188]." ".$text['tipp'][211]." ".$text['tipp'][294]; ?></td>
            <td align="left"><input type="checkbox" name="xshowtendenzpro" value="1" <?php if($tipp_showtendenzpro==1){echo "checked";} ?> onClick="dolmoedit()"></td>
          </tr>
          <tr>
            <td width="20">&nbsp;</td>
            <td align="right"><?php echo $text['tipp'][213]." ".$text['tipp'][294]; ?></td>
            <td align="left"><input type="checkbox" name="xshowdurchschntipp" value="1" <?php if($tipp_showdurchschntipp==1){echo "checked";} ?> onClick="dolmoedit()"<?php if($tipp_tippmodus==0){echo " disabled";} ?>></td>
          </tr>
          <tr>
            <td width="20">&nbsp;</td>
            <td align="right"><?php echo $text['tipp'][259]; ?></td>
            <td align="left"><input type="checkbox" name="xsttipp" onClick="viewerchange();"<?php if($tipp_sttipp==1){echo " checked";}?>></td>
          </tr>
          <tr>
            <td width="20">&nbsp;</td>
            <td align="right"><?php echo $text['tipp'][253]; ?></td>
            <td align="left"><input type="checkbox" name="xviewertipp" onClick="viewerchange();"<?php if($tipp_viewertipp==1){echo " checked";}?>></td>
          </tr>
          <tr>
            <td width="20">&nbsp;</td>
            <td align="right"><?php echo $text['tipp'][254]; ?></td>
            <td align="left"><input class="lmo-formular-input" type="text" name="xviewertage" size="2" maxlength="2" value="<?php echo $tipp_viewertage; ?>" onChange="dolmoedit()"<?php if($tipp_viewertipp==0){echo " disabled";} ?>>&nbsp;<?php echo $text['tipp'][171]; ?></td>
          </tr>
          <tr>
            <td width="20">&nbsp;</td>
            <td align="right"><?php echo $text['tipp'][161]; ?></td>
            <td align="left"><input type="checkbox" name="xakteinsicht" onClick="dolmoedit()"<?php if($tipp_akteinsicht==1){echo " checked";}?>></td>
          </tr><?php  }elseif ($show==7) {?>
          <tr>
            <td width="20">&nbsp;</td>
            <td align="right"><?php echo $text['tipp'][160]; ?></td>
            <td align="left">
              <select name="xeinsichterst" onChange="dolmoedit()">
                <option value="0"<?php if($tipp_einsichterst==0){echo " selected";}?>><?php echo $text['tipp'][215]?></option>
                <option value="1"<?php if($tipp_einsichterst==1){echo " selected";}?>><?php echo $text['tipp'][216]?></option>
                <option value="2"<?php if($tipp_einsichterst==2){echo " selected";}?>><?php echo $text['tipp'][217]?></option>
              </select>
            </td>
          </tr>
          <tr>
            <td width="20">&nbsp;</td>
            <td align="right"><?php echo $text['tipp'][204]; ?></td>
            <td align="left"><input class="lmo-formular-input" type="text" name="xanzseite" size="5" maxlength="5" value="<?php echo $tipp_anzseite; ?>" onChange="dolmoedit()"></td>
          </tr><?php  }elseif ($show==8) {?>
          <tr>
            <td width="20">&nbsp;</td>
            <td align="right"><?php echo $text['tipp'][183]; ?></td>
            <td align="left"><input type="checkbox" name="xtipptabelle" onClick="dolmoedit()"<?php if($tipp_tipptabelle==1){echo " checked";}?>></td>
          </tr>
          <tr>
            <td width="20">&nbsp;</td>
            <td align="right"><?php echo $text['tipp'][260]; ?></td>
            <td align="left"><input type="checkbox" name="xwertverein" onClick="dolmoedit()"<?php if($tipp_wertverein==1){echo " checked";}?>></td>
          </tr><?php  }elseif ($show==9) {?>
          <tr>
            <td width="20">&nbsp;</td>
            <td align="right"><?php echo $text['tipp'][302]; ?></td>
            <td align="left"><input type="checkbox" name="xnurgesamt" onClick="dolmoedit()"<?php if($tipp_nurgesamt==1){echo " checked";}?><?php if($tipp_gesamt==0){echo " disabled";}?>></td>
          </tr>
          <tr>
            <td width="20">&nbsp;</td>
            <td align="right"><?php echo $text['tipp'][204]; ?></td>
            <td align="left"><input class="lmo-formular-input" type="text" name="xanzseite1" size="5" maxlength="5" value="<?php echo $tipp_anzseite1; ?>" onChange="dolmoedit()"></td>
          </tr>
          <tr>
            <td width="20">&nbsp;</td>
            <td align="right"><?php echo $text['tipp'][251]; ?></td>
            <td align="left"><input type="checkbox" name="xshowzus" onClick="dolmoedit()"<?php if($tipp_showzus==1){echo " checked";}?>><?php echo $text['tipp'][282]; ?></td>
          </tr>
          <tr>
            <td width="20">&nbsp;</td>
            <td align="right"><?php echo $text['tipp'][272]; ?></td>
            <td align="left"><input type="checkbox" name="xshowstsiege" onClick="dolmoedit()"<?php if($tipp_showstsiege==1){echo " checked";}?>></td>
          </tr><?php  }elseif ($show==10) {?>
          <tr>
            <td width="20">&nbsp;</td>
            <td align="right"><?php echo $text['tipp'][275]." 1"; ?></td>
            <td align="left">
              <select name="xkrit1" onChange="dolmoedit()">
                <option value="-1"<?php if($tipp_krit1==-1){echo " selected";}?>><?php echo $text['tipp'][281]?></option>
                <option value="0"<?php if($tipp_krit1==0){echo " selected";}?>><?php echo $text['tipp'][276]?></option>
                <option value="1"<?php if($tipp_krit1==1){echo " selected";}?>><?php echo $text['tipp'][277]?></option>
                <option value="2"<?php if($tipp_krit1==2){echo " selected";}?>><?php echo $text['tipp'][278]?></option>
                <option value="3"<?php if($tipp_krit1==3){echo " selected";}?>><?php echo $text['tipp'][279]?></option>
                <option value="4"<?php if($tipp_krit1==4){echo " selected";}?>><?php echo $text['tipp'][280]?></option>
                <option value="5"<?php if($tipp_krit1==5){echo " selected";}?>><?php echo $text['tipp'][227]?></option>
                <option value="6"<?php if($tipp_krit1==6){echo " selected";}?>><?php echo $text['tipp'][271]?></option>
              </select>
            </td>
          </tr>
          <tr>
            <td width="20">&nbsp;</td>
            <td align="right"><?php echo $text['tipp'][275]." 2"; ?></td>
            <td align="left">
              <select name="xkrit2" onChange="dolmoedit()">
                <option value="-1"<?php if($tipp_krit2==-1){echo " selected";}?>><?php echo $text['tipp'][281]?></option>
                <option value="0"<?php if($tipp_krit2==0){echo " selected";}?>><?php echo $text['tipp'][276]?></option>
                <option value="1"<?php if($tipp_krit2==1){echo " selected";}?>><?php echo $text['tipp'][277]?></option>
                <option value="2"<?php if($tipp_krit2==2){echo " selected";}?>><?php echo $text['tipp'][278]?></option>
                <option value="3"<?php if($tipp_krit2==3){echo " selected";}?>><?php echo $text['tipp'][279]?></option>
                <option value="4"<?php if($tipp_krit2==4){echo " selected";}?>><?php echo $text['tipp'][280]?></option>
                <option value="5"<?php if($tipp_krit2==5){echo " selected";}?>><?php echo $text['tipp'][227]?></option>
                <option value="6"<?php if($tipp_krit2==6){echo " selected";}?>><?php echo $text['tipp'][271]?></option>
              </select>
            </td>
          </tr>
          <tr>
            <td width="20">&nbsp;</td>
            <td align="right"><?php echo $text['tipp'][275]." 3"; ?></td>
            <td align="left">
              <select name="xkrit3" onChange="dolmoedit()">
                <option value="-1"<?php if($tipp_krit3==-1){echo " selected";}?>><?php echo $text['tipp'][281]?></option>
                <option value="0"<?php if($tipp_krit3==0){echo " selected";}?>><?php echo $text['tipp'][276]?></option>
                <option value="1"<?php if($tipp_krit3==1){echo " selected";}?>><?php echo $text['tipp'][277]?></option>
                <option value="2"<?php if($tipp_krit3==2){echo " selected";}?>><?php echo $text['tipp'][278]?></option>
                <option value="3"<?php if($tipp_krit3==3){echo " selected";}?>><?php echo $text['tipp'][279]?></option>
                <option value="4"<?php if($tipp_krit3==4){echo " selected";}?>><?php echo $text['tipp'][280]?></option>
                <option value="5"<?php if($tipp_krit3==5){echo " selected";}?>><?php echo $text['tipp'][227]?></option>
                <option value="6"<?php if($tipp_krit3==6){echo " selected";}?>><?php echo $text['tipp'][271]?></option>
              </select>
            </td>
          </tr><?php  }elseif ($show==11) {?>
          <tr>
            <td width="20">&nbsp;</td>
            <td align="right"><?php echo $text['tipp'][81]; ?></td>
            <td align="left"><input type="checkbox" name="xaktauswert" onClick="dolmoedit()"<?php if($tipp_aktauswert==1){echo " checked";}?>></td>
          </tr>
          <tr>
            <td width="20">&nbsp;</td>
            <td align="right"><?php echo $text['tipp'][180]; ?></td>
            <td align="left"><input type="checkbox" name="xaktauswertges" onClick="dolmoedit()"<?php if($tipp_aktauswertges==1){echo " checked";}?>></td>
          </tr><?php  }elseif ($show==12) {?>
          <tr>
            <td width="20">&nbsp;</td>
            <td align="right"><?php echo $text['tipp'][104]; ?></td>
            <td align="left"><input type="checkbox" name="ximmeralle" onClick="immerallechange()"<?php if($tipp_immeralle==1){echo " checked";}?>></td>
          </tr>
          <tr>
            <td width="20" rowspan="2">&nbsp;</td>
            <th align="left" colspan="2"><?php
                echo$text['tipp'][105];?>
            </th>
          </tr>
          <tr>
            <td align="left" colspan="2"><?php
                $ftype=".l98";
                require(PATH_TO_ADDONDIR."/tipp/lmo-tippnewdir.php");?>
            </td>
          </tr><?php  }?>
          <tr>
            <td class="lmost4" colspan="3" align="right">
              <input type="hidden" name="show" value="<?php echo $show?>">
              <input class="lmo-formular-button" type="submit" name="best" value="<?php echo $text[188]; ?>">
            </td>
          </tr>
        </table>
      </form>
    </td>
  </tr>
</table>