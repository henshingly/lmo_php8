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
  *
  */
if (!defined('PATH_TO_LMO')) {
    exit;  // kein Direktaufruf: diese Datei wird nur ueber LMO eingebunden
}

/**
 * Diese Datei wird eingebunden und erwartet:
 *
 * @var \Lmo\Liga\Rohdaten\Liga $lmo_liga Rohdaten der geladenen Liga (lmo-openfile.php)
 * @var array<int|string, mixed> $text Sprachtexte
 * @var string $file Ligadatei relativ zum Ligenordner, leer wenn keine geladen ist
 * @var int|string $st gewaehlter Spieltag
 * @var array<int|string, mixed> $array leeres Array als Vorlage fuer array_pad()
 *
 * Einstellungen:
 * @var int|string $tabpkt Einstellung aus cfg.txt
 *
 * Weitere Variablen des einbindenden Codes:
 * @var mixed $tabtype
 */


require_once(PATH_TO_LMO."/lmo-admintest.php");
if ($file != "") {

  require_once(PATH_TO_LMO."/lmo-openfile.php");
  $lmo_einstellungen = $lmo_liga->einstellungen();
  $lmo_mannschaften = $lmo_einstellungen->mannschaften();
  $breite = 16;
  if (!$lmo_einstellungen->ohneUnentschieden()) {
    $breite = $breite-1;
  }
  if ($lmo_einstellungen->mitMinuspunkten()) {
    $dummy = "colspan=\"3\" style=\"text-align:center\"";
    $breite = $breite+2;
  } else {
    $dummy = "style=\"text-align:right\"";
  }
  $endtab = $st;
  $tabdat = "";
  // die Tabelle bis zum gewaehlten Spieltag, in der errechneten Reihenfolge (ohne Korrektur)
  if (!isset($tabtype)) {
    $tabtype = 0;
  }
  $lmo_tabelle = \Lmo\Liga\Tabelle::fuerAnsicht($lmo_liga, (int)$tabtype, (int)$st);
  $addt2 = $_SERVER['PHP_SELF']."?action=table&amp;file=".$file."&amp;tabtype=".$tabtype."&amp;endtab=";
  if (!isset($save)) {
    $save = 0;
  }
  if ($save == 1) {
    $xa = "";
    $xb = "";
    $xc = 0;
    for ($i = 1; $i <= $lmo_mannschaften; $i++) {
      if ($i < 10) {
        $xa = $xa."0";
      }
      $xa = $xa.$i;
      $xb = $xb.sprintf("%02s",trim($_POST["xplatz".$i]));
      if ($i == trim($_POST["xplatz".$i])) {
        $xc++;
      }
    }
    // je Platz zwei Ziffern; steht jede Mannschaft auf ihrem Platz, gibt es keine Korrektur
    $lmo_liga->spieltag((int)$st)->setzeTabellenkorrektur($xc == $lmo_mannschaften ? '0' : $xb);
    require(PATH_TO_LMO."/lmo-saveliga.php");
  }

  $lmo_korrektur = $lmo_liga->spieltage[(int)$st]->werte['HS'] ?? '0';
  $handt = array_pad($array, $lmo_mannschaften+2, "");
  for ($i = 0; $i < $lmo_mannschaften; $i++) {
    if ($lmo_korrektur != 0) {
      $handt[$i+1] = intval(substr($lmo_korrektur, $i * 2, 2));
    } else {
      $handt[$i+1] = $i+1;
    }
  }
  $addr = $_SERVER['PHP_SELF']."?action=admin&amp;todo=edit&amp;file=".$file."&amp;st=";
  $addb = $_SERVER['PHP_SELF']."?action=admin&amp;todo=tabs&amp;file=".$file."&amp;st=";
  $breite = 16;
  if ($lmo_einstellungen->mitVerlaengerung()) {
    $breite = $breite+2;
  }
  include(PATH_TO_LMO."/lmo-adminsubnavi.php");?>

<table class="lmoMiddle" cellspacing="0" cellpadding="0" border="0">
  <tr>
    <td align="center"><h1><?php echo $lmo_einstellungen->name()?></h1></td>
  </tr>
  <tr>
    <td align="center"><?php include (PATH_TO_LMO."/lmo-spieltagsmenu.php");?></td>
  </tr>
  <tr>
    <td align="center">
      <form name="lmoedit" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post" onSubmit="return chklmopas2(<?php echo $lmo_mannschaften;?>)">
        <input type="hidden" name="action" value="admin">
        <input type="hidden" name="todo" value="tabs">
        <input type="hidden" name="save" value="1">
        <input type="hidden" name="file" value="<?php echo $file;?>">
        <input type="hidden" name="st" value="<?php echo $st;?>">
        <table class="lmoInner" cellspacing="0" cellpadding="0" border="0">
          <tr>
            <th style="text-align:left" colspan="4"><?php echo $st.". ".$text[2];?></th>
            <th style="text-align:left" width="2">&nbsp;</th>
            <th style="text-align:center"><acronym title="<?php echo $text[63];?>"><?php echo $text[33];?></acronym></th>
            <th style="text-align:center"><acronym title="<?php echo $text[199];?>"><?php echo $text[34];?></acronym></th><?php
  if (!$lmo_einstellungen->ohneUnentschieden()) {?>
            <th style="text-align:center"><acronym title="<?php echo $text[200];?>"><?php echo $text[35];?></acronym></th><?php
  }?>
            <th style="text-align:center"><acronym title="<?php echo $text[201];?>"><?php echo $text[36];?></acronym></th><?php
  if ($tabpkt==0) {?>
            <th>&nbsp;</th>
            <th <?php echo $dummy?>><?php echo $text[37]?></th><?php
  }?>
            <th style="text-align:"left" width="2">&nbsp;</th>
            <th style="text-align:"left" colspan="3" align="center"><?php echo $text[38];?></th>
            <th align="right"><?php echo $text[39];?></th><?php
  if ($tabpkt==1) {?>
            <th>&nbsp;</th>
            <th <?php echo $dummy?>><?php echo $text[37]?></th><?php
  }?>
          </tr><?php
  $j = 1;
  for ($x = 1; $x <= $lmo_mannschaften; $x++) {
    $i = $lmo_tabelle->reihenfolge[$x-1];
    $lmo_zeile = $lmo_tabelle->zeilen[$i];
    $lmo_mannschaft = $lmo_liga->mannschaften[$i] ?? new \Lmo\Liga\Rohdaten\Mannschaft();
    $lmo_name = $lmo_mannschaft->anzeigename();
    $lmo_strafp = $lmo_mannschaft->werte['SP'] ?? '0';
    $lmo_strafm = $lmo_mannschaft->werte['SM'] ?? '0';
    $lmo_tor1 = $lmo_mannschaft->werte['TOR1'] ?? '0';
    $lmo_tor2 = $lmo_mannschaft->werte['TOR2'] ?? '0';
    $lmo_strafdat = $lmo_mannschaft->werte['STDA'] ?? '0';
    $lmo_notiz = $lmo_mannschaft->werte['NOT'] ?? '';
    if ($i == $lmo_einstellungen->lieblingsmannschaft()) {
      $dummy = "<strong>";
      $dumm2 = "</strong>";
    } else {
      $dummy = "";
      $dumm2 = "";
    }?>
          <tr>
            <td align="right">
              <select title="<?php echo $text[414] ?>" class="lmo-formular-input" name="xplatz<?php echo $x;?>" onChange="dolmoedi2(<?php echo $lmo_mannschaften;?>,'xplatz<?php echo $x;?>')"><?php
    for ($y=1;$y<=$lmo_mannschaften;$y++) {?>
                <option value="<?php echo $y?>" <?php if ($y==$handt[$x]) {echo " selected";}?>><?php echo $y?></option>
                <?php
    }?>
              </select>
            </td>
            <td class="nobr"><?php echo $dummy.$lmo_name.$dumm2;?></td>
            <td>&nbsp;</td>
            <td><?php
    if ($lmo_notiz!="" || $lmo_strafp!=0 || $lmo_strafm!=0 || $lmo_tor1!=0 || $lmo_tor2!=0) {
      $lmo_tabellennotiz=getSmallImage($lmo_name);

      /** Notizen anzeigen
       *
       * Achtung: Da beim Speichern Strafpunkte/-tore positiv sind und Bonuspunkte negativ (altes System des LMO)
       * muss mit -1 multipliziert werden, um die Punkte/Tore richtig anzuzeigen
       */

      $lmo_tabellennotiz.=" <strong>".$lmo_name."</strong>";
      //Straf-/Bonuspunkte
      if ($lmo_strafp!=0 || $lmo_strafm!=0) {
        $lmo_tabellennotiz.="\n\n<strong>".$text[128].":</strong> ";
        //Punkte
        $lmo_tabellennotiz.=$lmo_strafp<0?"+".((-1)*applyFactor($lmo_strafp,$lmo_einstellungen->punktfaktor())):((-1)*applyFactor($lmo_strafp,$lmo_einstellungen->punktfaktor()));
        //Minuspunkte
        if ($lmo_einstellungen->mitMinuspunkten()) {
          $lmo_tabellennotiz.=":".($lmo_strafm<0?"+".((-1)*applyFactor($lmo_strafm,$lmo_einstellungen->punktfaktor())):((-1)*applyFactor($lmo_strafm,$lmo_einstellungen->punktfaktor())));
        }
        //Ab ST
        if ($lmo_strafdat!=0) $lmo_tabellennotiz.=" ({$text[524]} {$text[145]} {$lmo_strafdat})";
      }
      //Straf-/Bonustore
      if ($lmo_tor1!=0 || $lmo_tor2!=0) {
        $lmo_tabellennotiz.="\n<strong>".$text[522].":</strong> ";
        //Tore
        $lmo_tabellennotiz.=$lmo_tor1<0?"+".((-1)*applyFactor($lmo_tor1,$lmo_einstellungen->torfaktor())).":":((-1)*applyFactor($lmo_tor1,$lmo_einstellungen->torfaktor())).":";
        //Gegentore
        $lmo_tabellennotiz.=$lmo_tor2<0?"+".((-1)*applyFactor($lmo_tor2,$lmo_einstellungen->torfaktor())):((-1)*applyFactor($lmo_tor2,$lmo_einstellungen->torfaktor()));
        //Ab ST
        if ($lmo_strafdat!=0) $lmo_tabellennotiz.=" ({$text[524]} {$text[145]} {$lmo_strafdat})";
      }
      //Teamnotizen
      if ($lmo_notiz!="") {
        $lmo_tabellennotiz.="\n\n<strong>".$text[22].":</strong>\n".$lmo_notiz;
      }?>
        <a href='#' onclick="alert('<?php echo addcslashes('',htmlentities(strip_tags($lmo_tabellennotiz)))?>');window.focus();return false;"><img src='<?php echo URL_TO_IMGDIR."/lmo-st2.svg"?>' height='15' border='0' alt=''><span class='popup'><?php echo nl2br($lmo_tabellennotiz)?></span></a><?php
      $lmo_tabellennotiz="";
    } else {
      echo "&nbsp;";
    }?>
            </td>
            <td>&nbsp;</td>
            <td align="right"><?php echo $dummy.$lmo_zeile->spiele.$dumm2;?></td>
            <td align="right"><?php echo $dummy.$lmo_zeile->siege.$dumm2;?></td><?php
    if (!$lmo_einstellungen->ohneUnentschieden()) {?>
            <td align="right"><?php echo $dummy.$lmo_zeile->unentschieden.$dumm2;?></td><?php
    }?>
            <td align="right"><?php echo $dummy.$lmo_zeile->niederlagen.$dumm2;?></td><?php
    if ($tabpkt == 0) {?>
            <td width="2">&nbsp;</td>
            <td align="right"><strong><?php echo applyFactor($lmo_zeile->punkte,$lmo_einstellungen->punktfaktor())?></strong></td><?php
      if ($lmo_einstellungen->mitMinuspunkten()) {?>
            <td align="center" width="4"><strong>:</strong></td>
            <td><strong><?php echo applyFactor($lmo_zeile->minuspunkte,$lmo_einstellungen->punktfaktor())?></strong></td><?php
      }
    }?>
            <td>&nbsp;</td>
            <td align="right"><?php echo $dummy.applyFactor($lmo_zeile->tore,$lmo_einstellungen->torfaktor()).$dumm2; ?></td>
            <td align="center" width="4"><?php echo $dummy; ?>:<?php echo $dumm2; ?></td>
            <td><?php echo $dummy.applyFactor($lmo_zeile->gegentore,$lmo_einstellungen->torfaktor()).$dumm2; ?></td>
            <td align="right"><?php echo $dummy.applyFactor($lmo_zeile->tordifferenz(),$lmo_einstellungen->torfaktor()).$dumm2; ?></td><?php
    if ($tabpkt==1) {?>
            <td width="2">&nbsp;</td>
            <td align="right"><strong><?php echo applyFactor($lmo_zeile->punkte,$lmo_einstellungen->punktfaktor())?></strong></td><?php
      if ($lmo_einstellungen->mitMinuspunkten()) {?>
            <td align="center" width="4"><strong>:</strong></td>
            <td><strong><?php echo applyFactor($lmo_zeile->minuspunkte,$lmo_einstellungen->punktfaktor())?></strong></td><?php
      }
    }?>
          </tr><?php
  }?>
          <tr>
            <th style="text-align:center" colspan="<?php echo $breite;?>">
              <input title="<?php echo $text[114] ?>" class="lmo-formular-button" type="submit" name="best" value="<?php echo $text[415];?>">
            </td>
          </tr>
        </table>
      </form>
    </td>
  </tr>
</table><?php
}?>
