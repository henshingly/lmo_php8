<?

require_once(PATH_TO_LMO."/lmo-admintest.php");
$show=isset($_REQUEST['show'])?$_REQUEST['show']:0;
$save=isset($_POST['save'])?$_POST['save']:0;
$config=isset($_REQUEST['config'])?$_REQUEST['config']:'';
if($save==1){
  require(PATH_TO_ADDONDIR."/viewer/lmo-adminviewergetoptions.php");
  require(PATH_TO_ADDONDIR."/viewer/lmo-adminviewersavecfg.php");
}

if ($config!='') {
  $viewer_config=parse_ini_file(PATH_TO_CONFIGDIR."/viewer/".$config."-cfg.txt");
  extract($viewer_config,EXTR_PREFIX_ALL,'viewer');
}

$add=$_SERVER['PHP_SELF']."?action=admin&amp;todo=vieweroptions&amp;config=$config&amp;show=";

?>

<table class="lmoMiddle" cellspacing="0" cellpadding="0" border="0">
  <tr>
    <td align="center" colspan="2"><h1><? echo $text['viewer'][28] ?></h1></td>
  </tr>
  <tr>
    <td valign="top">
      <table class="lmoMenu" cellspacing="0" cellpadding="0" border="0">
        <tr><td align="right"><?if ($show==0) {echo $text['viewer'][8]; ?><?}else{?><a onclick="return chklmolink()" href="<?=$add?>0"><?=$text['viewer'][8]; ?></a><?}?></td></tr><?
  $i=1;
  while(isset(${"viewer_liga$i"})) {?>
        <tr><td align="right"><?if ($show==$i) {echo ${"viewer_liga$i"} ?><?}else{?><a onclick="return chklmolink()" href="<?=$add.$i;?>"><?=${"viewer_liga$i"}?></a><?}?></td></tr><?
      $i++;
  }?>
        <tr><td align="right"><?if ($show==$i+1) {echo $text['viewer'][29]; ?><?}else{?><a onclick="return chklmolink()" href="<?=$add.($i+1)?>"><?=$text['viewer'][29]; ?></a><?}?></td></tr>
      </table>
    </td>
    <td align="center" valign="top">
      <form name="lmoedit" action="<? echo $_SERVER['PHP_SELF']; ?>" method="post" onSubmit="return chklmopass()">
        <input type="hidden" name="action" value="admin">
        <input type="hidden" name="todo" value="vieweroptions">
        <input type="hidden" name="config" value="<?=$config?>">
        <input type="hidden" name="save" value="1">
        <table class="lmoInner" cellspacing="0" cellpadding="0" border="0"><?
  if ($show==0) {?>
          <tr>
            <td width="20">&nbsp;</td>
            <td class="nobr" align="right"><? echo $text['viewer'][10]; ?></td>
            <td class="nobr" align="left"><input class="lmo-formular-input" type="text" name="xviewer_tage_plus" size="2" maxlength="4" value="<? echo $viewer_tage_plus; ?>" onChange="dolmoedit()"> <? echo $text['viewer'][9]; ?></td>
          </tr>
          <tr>
            <td width="20">&nbsp;</td>
            <td class="nobr" align="right"><? echo $text['viewer'][11]; ?></td>
            <td class="nobr" align="left"><input class="lmo-formular-input" type="text" name="xviewer_tage_minus" size="2" maxlength="4" value="<? echo $viewer_tage_minus; ?>" onChange="dolmoedit()"> <? echo $text['viewer'][9]; ?></td>
          </tr>
          <tr>
            <td width="20">&nbsp;</td>
            <td class="nobr" align="right"><? echo $text['viewer'][18]; ?></td>
            <td class="nobr" align="center">
              <table class="lmoInner">
                <tr>
                  <th></th>
                  <th><? echo $text['viewer'][19]; ?></th>
                  <th><? echo $text['viewer'][12]; ?></th>
                  <th><? echo $text['viewer'][16]; ?></th>
                </tr>
                <tr>
                  <th><? echo $text['viewer'][13]; ?></th>
                  <td class="nobr" align="center"><input class="lmo-formular-input" type="checkbox" name="xviewer_tabellen_verlinken" onClick="dolmoedit()" <?if($viewer_tabellen_verlinken==1){echo " checked";}?>></td>
                  <td class="nobr" align="center"><input class="lmo-formular-input" type="checkbox" name="xviewer_tabellen_neues_fenster" onClick="dolmoedit()" <?if($viewer_tabellen_neues_fenster==1){echo " checked";}?>></td>
                  <td class="nobr" align="center"><input class="lmo-formular-input" type="text" name="xviewer_tabellen_bild" size="10" value="<? echo $viewer_tabellen_bild; ?>" onChange="dolmoedit()"></td>
                </tr>
                <tr>
                  <th><? echo $text['viewer'][14]; ?></th>
                  <td class="nobr" align="center"><input class="lmo-formular-input" type="checkbox" name="xviewer_spielberichte_verlinken" onClick="dolmoedit()" <?if($viewer_spielberichte_verlinken==1){echo " checked";}?>></td>
                  <td class="nobr" align="center"><input class="lmo-formular-input" type="checkbox" name="xviewer_spielberichte_neues_fenster" onClick="dolmoedit()" <?if($viewer_spielberichte_neues_fenster==1){echo " checked";}?>></td>
                  <td class="nobr" align="center"><input class="lmo-formular-input" type="text" name="xviewer_spielberichte_bild" size="10" value="<? echo $viewer_spielberichte_bild; ?>" onChange="dolmoedit()"></td>
                </tr>
                <tr>
                  <th><? echo $text['viewer'][17]; ?></th>
                  <td class="nobr" align="center"><input class="lmo-formular-input" type="checkbox" name="xviewer_notizen_verlinken" onClick="dolmoedit()" <?if($viewer_notizen_verlinken==1){echo " checked";}?>></td>
                  <td class="lmoLeer" align="center">&nbsp;</td>
                  <td class="nobr" align="center"><input class="lmo-formular-input" type="text" name="xviewer_notizen_bild" size="10" value="<? echo $viewer_notizen_bild; ?>" onChange="dolmoedit()"></td>
                </tr>
                <tr>
                  <th><? echo $text['viewer'][15]; ?></th>
                  <td class="nobr" align="center"><input class="lmo-formular-input" type="checkbox" name="xviewer_homepages_verlinken" onClick="dolmoedit()" <?if($viewer_homepages_verlinken==1){echo " checked";}?>></td>
                  <td class="nobr" align="center"><input class="lmo-formular-input" type="checkbox" name="xviewer_homepages_neues_fenster" onClick="dolmoedit()" <?if($viewer_homepages_neues_fenster==1){echo " checked";}?>></td>
                  <td class="lmoLeer" align="center">&nbsp;</td>
                </tr>
              </table>
            </td>
          </tr>
          <tr>
            <td width="20">&nbsp;</td>
            <td align="right"><? echo $text['viewer'][22]; ?></td>
            <td align="left">
              <input class="lmo-formular-input" type="text" name="xviewer_datumsformat" value="<?=$viewer_datumsformat?>" onChange="dolmoedit()">
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
                </span>
              ?</a>
            </td>
          </tr>
          <tr>
            <td width="20">&nbsp;</td>
            <td align="right"><? echo $text['viewer'][23]; ?></td>
            <td align="left">
              <input class="lmo-formular-input" type="text" name="xviewer_uhrformat" value="<?=$viewer_uhrformat?>" onChange="dolmoedit()">
              <a href="http://php.net/strftime">
                <span class="popup">
                  <strong><?=$text[549];?></strong><br>
                  %H = <?=strftime("%H")?><br>
                  %M = <?=strftime("%M")?><br>
                  %R = <?=strftime("%R")?><br>
                  %p = <?=strftime("%p")?><br>
                </span>
              ?</a>
              </select>
            </td>
          </tr>
          <tr>
            <td width="20">&nbsp;</td>
            <td class="nobr" align="right"><? echo $text['viewer'][24]; ?></td>
            <td class="nobr" align="left"><input class="lmo-formular-input" type="checkbox" name="xviewer_heute_hervorheben" onClick="dolmoedit()" <?if($viewer_heute_hervorheben==1){echo " checked";}?>></td>
          </tr>
          <tr>
            <td width="20">&nbsp;</td>
            <td class="nobr" align="right"><? echo $text['viewer'][25]; ?></td>
            <td class="nobr" align="left"><input class="lmo-formular-input" type="checkbox" name="xviewer_datum_als_spalte" onClick="dolmoedit()" <?if($viewer_datum_als_spalte==1){echo " checked";}?>></td>
          </tr>
          <tr>
            <td width="20">&nbsp;</td>
            <td class="nobr" align="right"><? echo $text['viewer'][27]; ?></td>
            <td class="nobr" align="left"><input class="lmo-formular-input" type="checkbox" name="xviewer_keine_tore_anzeigen" onClick="dolmoedit()" <?if($viewer_keine_tore_anzeigen==1){echo " checked";}?>></td>
          </tr>
          <tr>
            <td width="20">&nbsp;</td>
            <td align="right"><? echo $text['viewer'][26]; ?></td>
            <td align="left">
              <select name="viewer_template" onChange="dolmoedit()"><?
                $viewer_templatedir=opendir(PATH_TO_TEMPLATEDIR."/viewer");
                while(false!==($template= readdir($viewer_templatedir))) {
                  if (preg_match('/^(.*)-haupt.tpl.php/',$template,$found)!=0) {?>
                 <option<?if($viewer_template == $found[0]) {echo " selected";}?>><?=$found[1]?></option><?
                  }
                }?>
              </select>
            </td>

          
          
          
          <? 
  }elseif ($show==1) {?>
          <? 
  }?>
          <tr>
            <td class="lmost4" colspan="3" align="right">
              <input type="hidden" name="show" value="<?=$show?>">
              <input class="lmo-formular-button" type="submit" name="best" value="<? echo $text[188]; ?>">
            </td>
          </tr>
        </table>
      </form>
    </td>
  </tr>
</table>