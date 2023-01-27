<?php
/** Liga Manager Online 4
  *
  * http://lmo.sourceforge.net/
  *
  * This program is free software; you can redisdiv class="row pb-2"ibute it and/or
  * modify it under the terms of the GNU General Public License as
  * published by the Free Software Foundation; either version 2 of
  * the License, or (at your option) any later version.
  *
  * This program is disdiv class="row pb-2"ibuted in the hope that it will be useful,
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

<div class="container">
  <div class="row pb-2">
    <div class="col d-flex justify-content-center"><h1><?php echo $text['tipp'][33] ?></h1></div>
  </div>
  <div class="row pb-2">
    <div class="col-3 text-end">
      <div class="container">
        <div class="row pb-2"><div class="col-auto text-end"><?php if ($show==0) {echo $text['tipp'][91]; ?><?php }else{?><a href="<?php echo $_SERVER['PHP_SELF']."?action=admin&amp;todo=tippoptions&amp;show=0";?>"><?php echo $text['tipp'][91]; ?></a><?php }?></div></div>
        <div class="row pb-2"><div class="col-auto text-end"><?php if ($show==1) {echo $text[220]; ?><?php }else{?><a href="<?php echo $_SERVER['PHP_SELF']."?action=admin&amp;todo=tippoptions&amp;show=1";?>"><?php echo $text[220]; ?></a><?php }?></div></div>
        <div class="row pb-2"><div class="col-auto text-end"><?php if ($show==2) {echo $text['tipp'][32]; ?><?php }else{?><a href="<?php echo $_SERVER['PHP_SELF']."?action=admin&amp;todo=tippoptions&amp;show=2";?>"><?php echo $text['tipp'][32]; ?></a><?php }?></div></div>
        <div class="row pb-2"><div class="col-auto text-end"><?php if ($show==3) {echo $text['tipp'][240]; ?><?php }else{?><a href="<?php echo $_SERVER['PHP_SELF']."?action=admin&amp;todo=tippoptions&amp;show=3";?>"><?php echo $text['tipp'][240]; ?></a><?php }?></div></div>
        <div class="row pb-2"><div class="col-auto text-end"><?php if ($show==4) {echo $text['tipp'][214]; ?><?php }else{?><a href="<?php echo $_SERVER['PHP_SELF']."?action=admin&amp;todo=tippoptions&amp;show=4";?>"><?php echo $text['tipp'][214]; ?></a><?php }?></div></div>
        <div class="row pb-2"><div class="col-auto text-end"><?php if ($show==5) {echo $text['tipp'][239]; ?><?php }else{?><a href="<?php echo $_SERVER['PHP_SELF']."?action=admin&amp;todo=tippoptions&amp;show=5";?>"><?php echo $text['tipp'][239]; ?></a><?php }?></div></div>
        <div class="row pb-2"><div class="col-auto text-end"><?php if ($show==6) {echo $text['tipp'][246]; ?><?php }else{?><a href="<?php echo $_SERVER['PHP_SELF']."?action=admin&amp;todo=tippoptions&amp;show=6";?>"><?php echo $text['tipp'][246]; ?></a><?php }?></div></div>
        <div class="row pb-2"><div class="col-auto text-end"><?php if ($show==7) {echo $text['tipp'][157]; ?><?php }else{?><a href="<?php echo $_SERVER['PHP_SELF']."?action=admin&amp;todo=tippoptions&amp;show=7";?>"><?php echo $text['tipp'][157]; ?></a><?php }?></div></div>
        <div class="row pb-2"><div class="col-auto text-end"><?php if ($show==8) {echo $text['tipp'][172]; ?><?php }else{?><a href="<?php echo $_SERVER['PHP_SELF']."?action=admin&amp;todo=tippoptions&amp;show=8";?>"><?php echo $text['tipp'][172]; ?></a><?php }?></div></div>
        <div class="row pb-2"><div class="col-auto text-end"><?php if ($show==9) {echo $text['tipp'][247]; ?><?php }else{?><a href="<?php echo $_SERVER['PHP_SELF']."?action=admin&amp;todo=tippoptions&amp;show=9";?>"><?php echo $text['tipp'][247]; ?></a><?php }?></div></div>
        <div class="row pb-2"><div class="col-auto text-end"><?php if ($show==10) {echo $text['tipp'][274]; ?><?php }else{?><a href="<?php echo $_SERVER['PHP_SELF']."?action=admin&amp;todo=tippoptions&amp;show=10";?>"><?php echo $text['tipp'][274]; ?></a><?php }?></div></div>
        <div class="row pb-2"><div class="col-auto text-end"><?php if ($show==11) {echo $text['tipp'][163]; ?><?php }else{?><a href="<?php echo $_SERVER['PHP_SELF']."?action=admin&amp;todo=tippoptions&amp;show=11";?>"><?php echo $text['tipp'][163]; ?></a><?php }?></div></div>
        <div class="row pb-2"><div class="col-auto text-end"><?php if ($show==12) {echo $text['tipp'][103]; ?><?php }else{?><a href="<?php echo $_SERVER['PHP_SELF']."?action=admin&amp;todo=tippoptions&amp;show=12";?>"><?php echo $text['tipp'][103]; ?></a><?php }?></div></div>
      </div>
    </div>
    <div class="col">
      <form name="lmoedit" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" onSubmit="return chklmopass()" class="row">
        <input type="hidden" name="action" value="admin">
        <input type="hidden" name="todo" value="tippoptions">
        <input type="hidden" name="save" value="1">
        <div class="container"><?php
  if ($show==0) {?>
          <div class="row pb-2">
            <div class="col-4 text-end"><?php echo $text['tipp'][91]; ?></div>
            <div class="col-2 text-start">
              <select class="form-select" name="xtippmodus" onChange="moduschange()">
                <option value="1"<?php if($tipp_tippmodus==1){echo " selected";}?>><?php echo $text['tipp'][92]?></option>
                <option value="0"<?php if($tipp_tippmodus==0){echo " selected";}?>><?php echo $text['tipp'][93]?></option>
              </select>
            </div>
          </div><?php  } elseif ($show==1) {?>
          <div class="row pb-2">
            <div class="col-4 text-end"><?php echo $text['tipp'][39]; ?></div>
            <div class="col-2 text-start"><input class="form-control" type="text" name="xdirtipp" size="20" maxlength="80" value="<?php echo $tipp_dirtipp; ?>" onChange="dolmoedit()"></div>
          </div><?php  } elseif ($show==2) {?>
          <div class="row pb-2">
            <div class="col-4 text-end"><?php echo $text['tipp'][34]; ?></div>
            <div class="col-1 text-start"><input class="form-control" type="text" name="xrergebnis" size="5" maxlength="5" value="<?php echo $tipp_rergebnis; ?>" onChange="dolmoedit()"<?php if($tipp_tippmodus==0){echo " disabled";} ?>>&nbsp;<?php echo $text['tipp'][38]; ?></div>
          </div>
          <div class="row pb-2">
            <div class="col-4 text-end"><?php echo $text['tipp'][35]; ?></div>
            <div class="col-1 text-start"><input class="form-control" type="text" name="xrtendenzdiff" size="5" maxlength="5" value="<?php echo $tipp_rtendenzdiff; ?>" onChange="dolmoedit()"<?php if($tipp_tippmodus==0){echo " disabled";} ?>>&nbsp;<?php echo $text['tipp'][38]; ?></div>
          </div>
          <div class="row pb-2">
            <div class="col-4 text-end"><?php echo $text['tipp'][36]; ?></div>
            <div class="col-1 text-start"><input class="form-control" type="text" name="xrtendenz" size="5" maxlength="5" value="<?php echo $tipp_rtendenz; ?>" onChange="dolmoedit()"<?php if($tipp_tippmodus==0){echo " disabled";} ?>>&nbsp;<?php echo $text['tipp'][38]; ?></div>
          </div>
          <div class="row pb-2">
            <div class="col-4 text-end"><?php echo $text['tipp'][37]; ?></div>
            <div class="col-1 text-start"><input class="form-control" type="text" name="xrtor" size="5" maxlength="5" value="<?php echo $tipp_rtor; ?>" onChange="dolmoedit()"<?php if($tipp_tippmodus==0){echo " disabled";} ?>>&nbsp;<?php echo $text['tipp'][38]; ?></div>
          </div>
          <div class="row pb-2">
            <div class="col-4 text-end"><?php echo $text['tipp'][189]; ?></div>
            <div class="col-6 text-start">
              <select class="form-select" name="xrtendenztor" onChange="dolmoedit()"<?php if($tipp_tippmodus==0){echo " disabled";}?>>
                <option value="1"<?php if($tipp_rtendenztor==1){echo " selected";}?>><?php echo $text['tipp'][190]?></option>
                <option value="0"<?php if($tipp_rtendenztor==0){echo " selected";}?>><?php echo $text['tipp'][191]?></option>
              </select>
            </div>
          </div>
          <div class="row pb-2">
            <div class="col-4 text-end"><?php echo $text['tipp'][193]; ?></div>
            <div class="col-6 text-start">
              <select class="form-select" name="xrtendenzremis" onChange="dolmoedit()"<?php if($tipp_tippmodus==0){echo " disabled";}?>>
                <option value="1"<?php if($tipp_rtendenzremis==1){echo " selected";}?>><?php echo $text['tipp'][194]?></option>
                <option value="0"<?php if($tipp_rtendenzremis==0){echo " selected";}?>><?php echo $text['tipp'][195]?></option>
              </select>
            </div>
          </div>
          <div class="row pb-2">
            <div class="col-4 text-end"><?php echo $text['tipp'][192]; ?></div>
            <div class="col-1 text-start"><input class="form-control" type="text" name="xrremis" size="5" maxlength="5" value="<?php echo $tipp_rremis; ?>" onChange="dolmoedit()">&nbsp;<?php echo $text['tipp'][38]; ?></div>
          </div>
          <div class="row pb-2">
            <div class="col-4 text-end"><?php echo $text['tipp'][152]; ?></div>
            <div class="col-1 text-start"><input type="checkbox" class="form-check-input" name="xentscheidungnv" onClick="dolmoedit()"<?php if($tipp_entscheidungnv==1){echo " checked";}?>></div>
          </div>
          <div class="row pb-2">
            <div class="col-4 text-end"><?php echo $text['tipp'][153]; ?></div>
            <div class="col-1 text-start"><input type="checkbox" class="form-check-input" name="xentscheidungie" onClick="dolmoedit()"<?php if($tipp_entscheidungie==1){echo " checked";}?>></div>
          </div>
          <div class="row pb-2">
            <div class="col-4 text-end"><?php echo $text['tipp'][196]; ?></div>
            <div class="col-6 text-start">
              <select class="form-select" name="xgtpunkte" onChange="dolmoedit()">
                <option value="0"<?php if($tipp_gtpunkte==0){echo " selected";}?>><?php echo $text['tipp'][197]?></option>
                <option value="1"<?php if($tipp_gtpunkte==1){echo " selected";}?>><?php echo $text['tipp'][198]?></option>
                <option value="2"<?php if($tipp_gtpunkte==2){echo " selected";}?>><?php echo $text['tipp'][199]?></option>
              </select>
            </div>
          </div><?php  } elseif ($show==3) {?>
          <div class="row pb-2">
            <div class="col-4 text-end"><?php echo $text['tipp'][157]; ?></div>
            <div class="col-1 text-start"><input type="checkbox" class="form-check-input" name="xtippeinsicht" onClick="dolmoedit()"<?php if($tipp_tippeinsicht==1){echo " checked";}?>></div>
          </div>
          <div class="row pb-2">
            <div class="col-4 text-end"><?php echo $text['tipp'][172]; ?></div>
            <div class="col-1 text-start"><input type="checkbox" class="form-check-input" name="xtipptabelle1" onClick="dolmoedit()"<?php if($tipp_tipptabelle1==1){echo " checked";}?>></div>
          </div>
          <div class="row pb-2">
            <div class="col-4 text-end"><?php echo $text[133]; ?></div>
            <div class="col-1 text-start"><input type="checkbox" class="form-check-input" name="xtippfieber" onClick="dolmoedit()"<?php if($tipp_tippfieber==1){echo " checked";}?>></div>
          </div>
          <div class="row pb-2">
            <div class="col-4 text-end"><?php echo $text['tipp'][56]; ?></div>
            <div class="col-1 text-start"><input type="checkbox" class="form-check-input" name="xgesamt" onClick="dolmoedit()"<?php if($tipp_gesamt==1){echo " checked";}?>></select>
            </div>
          </div>
          <div class="row pb-2">
            <div class="col-4 text-end"><?php echo $text['tipp'][187]; ?></div>
            <div class="col-1 text-start"><input type="checkbox" class="form-check-input" name="xregeln" onClick="regelnchange()"<?php if($tipp_regeln==1){echo " checked";}?>></div>
          </div>
          <div class="row pb-2">
            <div class="col-4 text-end"><?php echo $text['tipp'][186]; ?></div>
            <div class="col-2 text-start"><input class="form-control" type="text" name="xregelnlink" size="30" maxlength="256" value="<?php echo $tipp_regelnlink; ?>" onChange="dolmoedit()"<?php if($tipp_regeln==0){echo " disabled";}?>></div>
          </div>
          <div class="row pb-2">
            <div class="col-4 text-end"><?php echo $text['tipp'][200]; ?></div>
            <div class="col-2 text-start">
              <input type="checkbox" class="form-check-input" name="xshownick" value="1" <?php if($tipp_shownick==1){echo "checked";} ?> onClick="dolmoedit()"> <?php echo $text['tipp'][23]; ?><br />
              <input type="checkbox" class="form-check-input" name="xshowname" value="1" <?php if($tipp_showname==1){echo "checked";} ?> onClick="dolmoedit()"> <?php echo $text['tipp'][134]; ?><br />
              <input type="checkbox" class="form-check-input" name="xshowemail" value="1" <?php if($tipp_showemail==1){echo "checked";} ?> onClick="dolmoedit()"> <?php echo $text['tipp'][219]; ?>
            </div>
          </div><?php  } elseif ($show==4) {?>
          <div class="row pb-2">
            <div class="col-4 text-end"><?php echo $text['tipp'][87]; ?></div>
            <div class="col-3 text-start"><input class="form-control" type="text" name="xtippbis" size="5" maxlength="5" value="<?php echo $tipp_tippBis; ?>" onChange="dolmoedit()"><?php echo " ".$text['tipp'][88]; ?></div>
          </div>
          <div class="row pb-2">
            <div class="col-4 text-end"><?php echo $text['tipp'][248]; ?></div>
            <div class="col-6 text-start">
              <select class="form-select" name="xtippohne" onChange="dolmoedit()">
                <option value="1"<?php if($tipp_tippohne==1){echo " selected";}?>><?php echo $text['tipp'][249]?></option>
                <option value="0"<?php if($tipp_tippohne==0){echo " selected";}?>><?php echo $text['tipp'][250]?></option>
              </select>
            </div>
          </div>
          <div class="row pb-2">
            <div class="col-4 text-end"><?php echo $text['tipp'][100]; ?></div>
            <div class="col-4 text-start">
              <select class="form-select" name="xtipperteam" onChange="dolmoedit()">
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
            </div>
          </div>
          <div class="row pb-2">
            <div class="col-4 text-end"><?php echo $text['tipp'][154]; ?></div>
            <div class="col-2 text-start">
              <select class="form-select" name="ximvorraus" onChange="dolmoedit()">
                <option value="0"<?php if($tipp_imvorraus==0){echo " selected";}?>>0</option>
                <option value="1"<?php if($tipp_imvorraus==1){echo " selected";}?>>1</option>
                <option value="2"<?php if($tipp_imvorraus==2){echo " selected";}?>>2</option>
                <option value="3"<?php if($tipp_imvorraus==3){echo " selected";}?>>3</option>
                <option value="4"<?php if($tipp_imvorraus==4){echo " selected";}?>>4</option>
                <option value="5"<?php if($tipp_imvorraus==5){echo " selected";}?>>5</option>
                <option value="-1"<?php if($tipp_imvorraus==-1){echo " selected";}?>><?php echo $text['tipp'][102]?></option>
              </select>
            </div>
          </div>
          <div class="row pb-2">
            <div class="col-4 text-end"><?php echo $text['tipp'][288]; ?></div>
            <div class="col-6 text-start"><input type="checkbox" class="form-check-input" name="xjokertipp" onClick="jokerchange()"<?php if($tipp_jokertipp==1){echo " checked";}?>></div>
          </div>
          <div class="row pb-2">
            <div class="col-4 text-end"><?php echo $text['tipp'][291]; ?></div>
            <div class="col-2 text-start">
              <select class="form-select" name="xjokertippmulti" onChange="dolmoedit()"<?php if($tipp_jokertipp==0){echo " disabled";}?>>
                <option value="1.5"<?php if($tipp_jokertippmulti=="1.5"){echo " selected";}?>>1.5</option>
                <option value="2"<?php if($tipp_jokertippmulti=="2"){echo " selected";}?>>2</option>
                <option value="2.5"<?php if($tipp_jokertippmulti=="2.5"){echo " selected";}?>>2.5</option>
                <option value="3"<?php if($tipp_jokertippmulti=="3"){echo " selected";}?>>3</option>
              </select>
            </div>
          </div><?php  } elseif ($show==5) {?>
          <div class="row pb-2">
            <div class="col-4 text-end"><?php echo $text['tipp'][132]; ?></div>
            <div class="col-1 text-start"><input type="checkbox" class="form-check-input" name="xadresse" onClick="dolmoedit()"<?php if($tipp_adresse==1){echo " checked";}?>></div>
          </div>
          <div class="row pb-2">
            <div class="col-4 text-end"><?php echo $text['tipp'][286]; ?></div>
            <div class="col-1 text-start"><input type="checkbox" class="form-check-input" name="xrealname" onClick="dolmoedit()"<?php if($tipp_realname==1){echo " checked";}?>></div>
          </div>
          <div class="row pb-2">
            <div class="col-4 text-end"><?php echo $text['tipp'][299]; ?></div>
            <div class="col-1 text-start"><input type="checkbox" class="form-check-input" name="xfreischaltcode" onClick="dolmoedit()"<?php if($tipp_freischaltcode==1){echo " checked";}?>></div>
          </div>
          <div class="row pb-2">
            <div class="col-4 text-end"><?php echo $text['tipp'][146]; ?></div>
            <div class="col-1 text-start"><input type="checkbox" class="form-check-input" name="xfreischaltung" onClick="dolmoedit()"<?php if($tipp_freischaltung==1){echo " checked";}?>></div>
          </div>
          <div class="row pb-2">
            <div class="col-4 text-end"><?php echo $text['tipp'][293]; ?></div>
            <div class="col-1 text-start"><input type="checkbox" class="form-check-input" name="xmailbeianmeldung" onClick="dolmoedit()"<?php if($tipp_mailbeianmeldung==1){echo " checked";}?>></div>
          </div><?php  } elseif ($show==6) {?>
          <div class="row pb-2">
            <div class="col-4 text-end"><?php echo $text['tipp'][245]." ".$text['tipp'][294]; ?></div>
            <div class="col-1 text-start"><input type="checkbox" class="form-check-input" name="xpfeiltipp" onClick="dolmoedit()"<?php if($tipp_pfeiltipp==1){echo " checked";}?><?php if($tipp_tippmodus==0){echo " disabled";}?>></div>
          </div>
          <div class="row pb-2">
            <div class="col-4 text-end"><?php echo $text['tipp'][188]." ".$text['tipp'][212]." ".$text['tipp'][294]; ?></div>
            <div class="col-1 text-start"><input type="checkbox" class="form-check-input" name="xshowtendenzabs" value="1" <?php if($tipp_showtendenzabs==1){echo "checked";} ?> onClick="dolmoedit()"></div>
          </div>
          <div class="row pb-2">
            <div class="col-4 text-end"><?php echo $text['tipp'][188]." ".$text['tipp'][211]." ".$text['tipp'][294]; ?></div>
            <div class="col-1 text-start"><input type="checkbox" class="form-check-input" name="xshowtendenzpro" value="1" <?php if($tipp_showtendenzpro==1){echo "checked";} ?> onClick="dolmoedit()"></div>
          </div>
          <div class="row pb-2">
            <div class="col-4 text-end"><?php echo $text['tipp'][213]." ".$text['tipp'][294]; ?></div>
            <div class="col-1 text-start"><input type="checkbox" class="form-check-input" name="xshowdurchschntipp" value="1" <?php if($tipp_showdurchschntipp==1){echo "checked";} ?> onClick="dolmoedit()"<?php if($tipp_tippmodus==0){echo " disabled";} ?>></div>
          </div>
          <div class="row pb-2">
            <div class="col-4 text-end"><?php echo $text['tipp'][259]; ?></div>
            <div class="col-1 text-start"><input type="checkbox" class="form-check-input" name="xsttipp" onClick="viewerchange();"<?php if($tipp_sttipp==1){echo " checked";}?>></div>
          </div>
          <div class="row pb-2">
            <div class="col-4 text-end"><?php echo $text['tipp'][253]; ?></div>
            <div class="col-1 text-start"><input type="checkbox" class="form-check-input" name="xviewertipp" onClick="viewerchange();"<?php if($tipp_viewertipp==1){echo " checked";}?>></div>
          </div>
          <div class="row pb-2">
            <div class="col-4 text-end"><?php echo $text['tipp'][254]; ?></div>
            <div class="col-1 text-start"><input class="form-control" type="text" name="xviewertage" size="2" maxlength="2" value="<?php echo $tipp_viewertage; ?>" onChange="dolmoedit()"<?php if($tipp_viewertipp==0){echo " disabled";} ?>><?php echo $text['tipp'][171]; ?></div>
          </div>
          <div class="row pb-2">
            <div class="col-4 text-end"><?php echo $text['tipp'][161]; ?></div>
            <div class="col-1 text-start"><input type="checkbox" class="form-check-input" name="xakteinsicht" onClick="dolmoedit()"<?php if($tipp_akteinsicht==1){echo " checked";}?>></div>
          </div><?php  } elseif ($show==7) {?>
          <div class="row pb-2">
            <div class="col-4 text-end"><?php echo $text['tipp'][160]; ?></div>
            <div class="col-2 text-start">
              <select class="form-select" name="xeinsichterst" onChange="dolmoedit()">
                <option value="0"<?php if($tipp_einsichterst==0){echo " selected";}?>><?php echo $text['tipp'][215]?></option>
                <option value="1"<?php if($tipp_einsichterst==1){echo " selected";}?>><?php echo $text['tipp'][216]?></option>
                <option value="2"<?php if($tipp_einsichterst==2){echo " selected";}?>><?php echo $text['tipp'][217]?></option>
              </select>
            </div>
          </div>
          <div class="row pb-2">
            <div class="col-4 text-end"><?php echo $text['tipp'][204]; ?></div>
            <div class="col-2 text-start"><input class="form-control" type="text" name="xanzseite" size="5" maxlength="5" value="<?php echo $tipp_anzseite; ?>" onChange="dolmoedit()"></div>
          </div><?php  } elseif ($show==8) {?>
          <div class="row pb-2">
            <div class="col-4 text-end"><?php echo $text['tipp'][183]; ?></div>
            <div class="col-1 text-start"><input type="checkbox" class="form-check-input" name="xtipptabelle" onClick="dolmoedit()"<?php if($tipp_tipptabelle==1){echo " checked";}?>></div>
          </div>
          <div class="row pb-2">
            <div class="col-4 text-end"><?php echo $text['tipp'][260]; ?></div>
            <div class="col-1 text-start"><input type="checkbox" class="form-check-input" name="xwertverein" onClick="dolmoedit()"<?php if($tipp_wertverein==1){echo " checked";}?>></div>
          </div><?php  } elseif ($show==9) {?>
          <div class="row pb-2">
            <div class="col-4 text-end"><?php echo $text['tipp'][302]; ?></div>
            <div class="col-1 text-start"><input type="checkbox" class="form-check-input" name="xnurgesamt" onClick="dolmoedit()"<?php if($tipp_nurgesamt==1){echo " checked";}?><?php if($tipp_gesamt==0){echo " disabled";}?>></div>
          </div>
          <div class="row pb-2">
            <div class="col-4 text-end"><?php echo $text['tipp'][204]; ?></div>
            <div class="col-2 text-start"><input class="form-control" type="text" name="xanzseite1" size="5" maxlength="5" value="<?php echo $tipp_anzseite1; ?>" onChange="dolmoedit()"></div>
          </div>
          <div class="row pb-2">
            <div class="col-4 text-end"><?php echo $text['tipp'][251]; ?></div>
            <div class="col-4 text-start"><input type="checkbox" class="form-check-input" name="xshowzus" onClick="dolmoedit()"<?php if($tipp_showzus==1){echo " checked";}?>>&nbsp;<?php echo $text['tipp'][282]; ?></div>
          </div>
          <div class="row pb-2">
            <div class="col-4 text-end"><?php echo $text['tipp'][272]; ?></div>
            <div class="col-1 text-start"><input type="checkbox" class="form-check-input" name="xshowstsiege" onClick="dolmoedit()"<?php if($tipp_showstsiege==1){echo " checked";}?>></div>
          </div><?php  } elseif ($show==10) {?>
          <div class="row pb-2">
            <div class="col-4 text-end"><?php echo $text['tipp'][275]." 1"; ?></div>
            <div class="col-4 text-start">
              <select class="form-select" name="xkrit1" onChange="dolmoedit()">
                <option value="-1"<?php if($tipp_krit1==-1){echo " selected";}?>><?php echo $text['tipp'][281]?></option>
                <option value="0"<?php if($tipp_krit1==0){echo " selected";}?>><?php echo $text['tipp'][276]?></option>
                <option value="1"<?php if($tipp_krit1==1){echo " selected";}?>><?php echo $text['tipp'][277]?></option>
                <option value="2"<?php if($tipp_krit1==2){echo " selected";}?>><?php echo $text['tipp'][278]?></option>
                <option value="3"<?php if($tipp_krit1==3){echo " selected";}?>><?php echo $text['tipp'][279]?></option>
                <option value="4"<?php if($tipp_krit1==4){echo " selected";}?>><?php echo $text['tipp'][280]?></option>
                <option value="5"<?php if($tipp_krit1==5){echo " selected";}?>><?php echo $text['tipp'][227]?></option>
                <option value="6"<?php if($tipp_krit1==6){echo " selected";}?>><?php echo $text['tipp'][271]?></option>
              </select>
            </div>
          </div>
          <div class="row pb-2">
            <div class="col-4 text-end"><?php echo $text['tipp'][275]." 2"; ?></div>
            <div class="col-4 text-start">
              <select class="form-select" name="xkrit2" onChange="dolmoedit()">
                <option value="-1"<?php if($tipp_krit2==-1){echo " selected";}?>><?php echo $text['tipp'][281]?></option>
                <option value="0"<?php if($tipp_krit2==0){echo " selected";}?>><?php echo $text['tipp'][276]?></option>
                <option value="1"<?php if($tipp_krit2==1){echo " selected";}?>><?php echo $text['tipp'][277]?></option>
                <option value="2"<?php if($tipp_krit2==2){echo " selected";}?>><?php echo $text['tipp'][278]?></option>
                <option value="3"<?php if($tipp_krit2==3){echo " selected";}?>><?php echo $text['tipp'][279]?></option>
                <option value="4"<?php if($tipp_krit2==4){echo " selected";}?>><?php echo $text['tipp'][280]?></option>
                <option value="5"<?php if($tipp_krit2==5){echo " selected";}?>><?php echo $text['tipp'][227]?></option>
                <option value="6"<?php if($tipp_krit2==6){echo " selected";}?>><?php echo $text['tipp'][271]?></option>
              </select>
            </div>
          </div>
          <div class="row pb-2">
            <div class="col-4 text-end"><?php echo $text['tipp'][275]." 3"; ?></div>
            <div class="col-4 text-start">
              <select class="form-select" name="xkrit3" onChange="dolmoedit()">
                <option value="-1"<?php if($tipp_krit3==-1){echo " selected";}?>><?php echo $text['tipp'][281]?></option>
                <option value="0"<?php if($tipp_krit3==0){echo " selected";}?>><?php echo $text['tipp'][276]?></option>
                <option value="1"<?php if($tipp_krit3==1){echo " selected";}?>><?php echo $text['tipp'][277]?></option>
                <option value="2"<?php if($tipp_krit3==2){echo " selected";}?>><?php echo $text['tipp'][278]?></option>
                <option value="3"<?php if($tipp_krit3==3){echo " selected";}?>><?php echo $text['tipp'][279]?></option>
                <option value="4"<?php if($tipp_krit3==4){echo " selected";}?>><?php echo $text['tipp'][280]?></option>
                <option value="5"<?php if($tipp_krit3==5){echo " selected";}?>><?php echo $text['tipp'][227]?></option>
                <option value="6"<?php if($tipp_krit3==6){echo " selected";}?>><?php echo $text['tipp'][271]?></option>
              </select>
            </div>
          </div><?php  } elseif ($show==11) {?>
          <div class="row pb-2">
            <div class="col-4 text-end"><?php echo $text['tipp'][81]; ?></div>
            <div class="col-1 text-start"><input type="checkbox" class="form-check-input" name="xaktauswert" onClick="dolmoedit()"<?php if($tipp_aktauswert==1){echo " checked";}?>></div>
          </div>
          <div class="row pb-2">
            <div class="col-4 text-end"><?php echo $text['tipp'][180]; ?></div>
            <div class="col-1 text-start"><input type="checkbox" class="form-check-input" name="xaktauswertges" onClick="dolmoedit()"<?php if($tipp_aktauswertges==1){echo " checked";}?>></div>
          </div><?php  } elseif ($show==12) {?>
          <div class="row pb-2">
            <div class="col-4 text-end"><?php echo $text['tipp'][104]; ?></div>
            <div class="col-2 text-start"><input type="checkbox" class="form-check-input" name="ximmeralle" onClick="immerallechange()"<?php if($tipp_immeralle==1){echo " checked";}?>></div>
          </div>
          <div class="row pb-2">
            <div class="col-auto"><?php
                echo$text['tipp'][105];?>
            </div>
          </div>
          <div class="row pb-2">
            <div class="col-4 text-start"><?php
                $ftype=".l98";
                require(PATH_TO_ADDONDIR."/tipp/lmo-tippnewdir.php");?>
            </div>
          </div><?php  }?>
          <div class="row pb-2">
            <div class="col-auto">
              <input type="hidden" name="show" value="<?php echo $show?>">
              <input class="btn btn-primary"  type="submit" name="best" value="<?php echo $text[188]; ?>">
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>