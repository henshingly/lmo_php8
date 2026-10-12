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
 * @var string $defdateformat Datumsformat in date()-Schreibweise (Konfiguration)
 *
 * Einstellungen:
 * @var int|string $einspieler Einstellung aus cfg.txt
 * @var int|string $tabonres Einstellung aus cfg.txt
 *
 * Weitere Variablen des einbindenden Codes:
 * @var mixed $orgpkt
 * @var mixed $orgtor
 * @var mixed $trans_lang
 */

require_once(PATH_TO_LMO . '/lmo-admintest.php');
if ($file != '') {
    require_once(PATH_TO_LMO . '/lmo-openfile.php');
    // $lmo_opt: die Einstellungen der Liga mit ihren Vorgabewerten, Schluessel wie in [Options]. Die
    // Seite aendert sie hier; beim Speichern kommt, was sich geaendert hat, in die Rohdaten.
    $lmo_opt = $lmo_liga->einstellungen()->alle();
    $lmo_opt['DatF'] = $lmo_opt['DatF'] ?? $defdateformat;
    $lmo_opt_geladen = $lmo_opt;
    $lmo_mannschaften = $lmo_liga->einstellungen()->mannschaften();
    // Namen der Mannschaften fuer die Auswahllisten, davor "___" fuer keine
    $lmo_namen = array('___');
    foreach ($lmo_liga->alleMannschaften() as $lmo_nr => $lmo_mannschaft) {
        $lmo_namen[$lmo_nr] = $lmo_mannschaft->anzeigename();
    }
    $show = isset($_REQUEST['show']) ? $_REQUEST['show'] : 0;
    $save = isset($_POST['save']) ? $_POST['save'] : 0;
    if ($save == 1) {
        switch ($show) {
            case 0:
                if ($_SESSION['lmouserok'] == 2 || $_SESSION['lmouserokerweitert'] == 1) {
                    $lmo_opt['Name'] = isset($_POST['xtitel']) ? trim($_POST['xtitel']) : $lmo_opt['Name'];
                    if ($lmo_opt['Name'] == '') {
                        $lmo_opt['Name'] = 'No Name';
                    }
                    $lmo_opt['goalfaktor'] = isset($_POST['xgoalfaktor']) && is_numeric($_POST['xgoalfaktor']) ? $_POST['xgoalfaktor'] : $lmo_opt['goalfaktor'];
                    $lmo_opt['pointsfaktor'] = isset($_POST['xpointsfaktor']) && is_numeric($_POST['xpointsfaktor']) ? $_POST['xpointsfaktor'] : $lmo_opt['pointsfaktor'];
                }
                $lmo_opt['favTeam'] = isset($_POST['xfavteam']) ? trim($_POST['xfavteam']) : $lmo_opt['favTeam'];
                $lmo_opt['selTeam'] = isset($_POST['xselteam']) ? trim($_POST['xselteam']) : $lmo_opt['selTeam'];
                if ($lmo_opt['Type'] == 1) {
                    $lmo_opt['playoffmode'] = isset($_POST['xplayoffmode']) && is_numeric($_POST['xplayoffmode']) ? $_POST['xplayoffmode'] : $lmo_opt['playoffmode'];
                }
                if ($lmo_opt['Type'] == 0) {
                    $lmo_opt['kurve1'] = isset($_POST['xstat1']) ? trim($_POST['xstat1']) : $lmo_opt['kurve1'];
                    $lmo_opt['kurve2'] = isset($_POST['xstat2']) ? trim($_POST['xstat2']) : $lmo_opt['kurve2'];
                    $lmo_opt['namePkt'] = isset($_POST['xnamepkt']) ? trim($_POST['xnamepkt']) : $lmo_opt['namePkt'];
                    if ($lmo_opt['namePkt'] == $orgpkt) {
                        $lmo_opt['namePkt'] = '';
                    }
                    $lmo_opt['nameTor'] = isset($_POST['xnametor']) ? trim($_POST['xnametor']) : $lmo_opt['nameTor'];
                    if ($lmo_opt['nameTor'] == $orgtor) {
                        $lmo_opt['nameTor'] = '';
                    }
                }
            break;
            case 2:
                if ($_SESSION['lmouserok'] == 2 || $_SESSION['lmouserokerweitert'] == 1) {
                    $lmo_opt['enableGameSort'] = isset($_POST['xenablegamesort']) ? 1 : 0;
                    $lmo_opt['DatM'] = isset($_POST['xdatm']) ? 1 : 0;
                    if (!empty($_POST['xdatfselect'])) {
                        $lmo_opt['DatF'] = isset($_POST['xdatf']) ? $_POST['xdatf'] : $defdateformat;
                    }
                    else {
                        $lmo_opt['DatF'] = isset($_POST['xdatf2']) ? $_POST['xdatf2'] : $lmo_opt['DatF'];
                    }
                    $lmo_opt['DatS'] = isset($_POST['xdats']) ? 1 : 0;
                    $lmo_opt['Plan'] = isset($_POST['xplan']) ? 1 : 0;
                    $lmo_opt['Ergebnis'] = isset($_POST['xergebnis']) ? 1 : 0;
                    if ($einspieler == 1) {
                        $lmo_opt['mittore'] = isset($_POST['xmittore']) ? 1 : 0;
                    }
                    $lmo_opt['DatC'] = isset($_POST['xdatc']) ? 1 : 0;
                    if (($lmo_opt['DatS'] == 0) && ($lmo_opt['DatM'] == 0)) {
                        $lmo_opt['DatC'] = 0;
                    }
                    if ($lmo_opt['Type'] == 0) {
                        $lmo_opt['OnRun'] = isset($_POST['xonrun']) ? $_POST['xonrun'] : $lmo_opt['OnRun'];
                        $lmo_opt['Graph'] = isset($_POST['xkurve']) ? 1 : 0;
                        $lmo_opt['Kreuz'] = isset($_POST['xkreuz']) ? 1 : 0;
                        if ($tabonres == 0) {
                            $lmo_opt['Tabelle'] = isset($_POST['xtabelle']) ? 1 : 0;
                        }
                        $lmo_opt['Ligastats'] = isset($_POST['xligastats']) ? 1 : 0;
                    }
                    else {
                        $lmo_opt['KlFin'] = isset($_POST['xklfin']) ? 1 : 0;
                        $lmo_opt['playdown'] = isset($_POST['xplaydown']) ? 1 : 0;
                        $lmo_opt['playoffmode'] = isset($_POST['xplayoffmode']) ? $_POST['xplayoffmode'] : $lmo_opt['playoffmode'];
                    }
                    $lmo_opt['urlT'] = isset($_POST['xurlt']) ? 1 : 0;
                    $lmo_opt['urlB'] = isset($_POST['xurlb']) ? 1 : 0;
                }
            break;
            case 3:
                if (($_SESSION['lmouserok'] == 2  || $_SESSION['lmouserokerweitert'] == 1) && $lmo_opt['Type'] == 0) {
                    $lmo_opt['MinusPoints'] = isset($_POST['xminus']) ? 2 : 1;
                    $lmo_opt['Spez'] = isset($_POST['xspez']) ? 1 : 0;
                    $lmo_opt['HideDraw'] = isset($_POST['xhidr']) ? 1 : 0;
                    $lmo_opt['Direct'] = isset($_POST['xdirekt']) ? 1 : 0;
                    $lmo_opt['Kegel'] = isset($_POST['xkegel']) ? 1 : 0;
                    $lmo_opt['HandS'] = isset($_POST['xhands']) ? 1 : 0;

                    $lmo_opt['PointsForWin'] = isset($_POST['xpns']) ? trim($_POST['xpns']) : $lmo_opt['PointsForWin'];
                    $lmo_opt['PointsForDraw'] = isset($_POST['xpnu']) ? trim($_POST['xpnu']) : $lmo_opt['PointsForDraw'];
                    $lmo_opt['PointsForLost'] = isset($_POST['xpnn']) ? trim($_POST['xpnn']) : $lmo_opt['PointsForLost'];
                    $lmo_opt['XtraS'] = isset($_POST['xpxs']) ? trim($_POST['xpxs']) : $lmo_opt['XtraS'];
                    $lmo_opt['XtraU'] = isset($_POST['xpxu']) ? trim($_POST['xpxu']) : $lmo_opt['XtraU'];
                    $lmo_opt['XtraV'] = isset($_POST['xpxn']) ? trim($_POST['xpxn']) : $lmo_opt['XtraV'];
                    $lmo_opt['SpezS'] = isset($_POST['xpps']) ? trim($_POST['xpps']) : $lmo_opt['SpezS'];
                    $lmo_opt['SpezU'] = isset($_POST['xppu']) ? trim($_POST['xppu']) : $lmo_opt['SpezU'];
                    $lmo_opt['SpezV'] = isset($_POST['xppn']) ? trim($_POST['xppn']) : $lmo_opt['SpezV'];
                }
            break;
            case 4:
                if (($_SESSION['lmouserok'] == 2  || $_SESSION['lmouserokerweitert'] == 1) && $lmo_opt['Type'] == 0) {
                    $lmo_opt['tableHinRueck'] = isset($_POST['xeinhinrueck']) ? 1 : 0;
                    $lmo_opt['tableHeimAusw'] = isset($_POST['xeinheimausw']) ? 1 : 0;
                    $lmo_opt['Champ'] = isset($_POST['xchamp']) ? 1 : 0;
                    $lmo_opt['CL'] = isset($_POST['xanzcl']) ? trim($_POST['xanzcl']) : $lmo_opt['CL'];
                    $lmo_opt['CK'] = isset($_POST['xanzck']) ? trim($_POST['xanzck']) : $lmo_opt['CK'];
                    $lmo_opt['UC'] = isset($_POST['xanzuc']) ? trim($_POST['xanzuc']) : $lmo_opt['UC'];
                    $lmo_opt['AR'] = isset($_POST['xanzar']) ? trim($_POST['xanzar']) : $lmo_opt['AR'];
                    $lmo_opt['AB'] = isset($_POST['xanzab']) ? trim($_POST['xanzab']) : $lmo_opt['AB'];
                }
            break;
        }
        foreach ($lmo_opt as $lmo_schluessel => $lmo_wert) {
            if ($lmo_wert !== $lmo_opt_geladen[$lmo_schluessel]) {
                $lmo_liga->setzeEinstellung($lmo_schluessel, (string)$lmo_wert);
            }
        }
        require(PATH_TO_LMO . '/lmo-saveliga.php');
    }
    $addr = $_SERVER['PHP_SELF'] . '?action=admin&amp;todo=edit&amp;file=' . $file . '&amp;st=';
    $addb = $_SERVER['PHP_SELF'] . '?action=admin&amp;todo=tabs&amp;file=' . $file . '&amp;st=';

    include(PATH_TO_LMO . '/lmo-adminsubnavi.php');
?>
            <table class="lmoMiddle" cellspacing="0" cellpadding="0" border="0">
              <tr>
                <td align="center" colspan="2"><h1><?php echo $lmo_opt['Name']?></h1></td>
              </tr>
              <tr>
                <td valign="top">
                  <table class="lmoMenu" cellspacing="0" cellpadding="0" border="0">
                    <tr><td align="right"><?php if ($show == 0) {echo $text[183];} else { ?><a onclick="return chklmolink();" href="<?php echo $_SERVER['PHP_SELF'] . '?action=admin&amp;todo=edit&amp;show=0&amp;file=' . $file . '&amp;st=-1'; ?>"><?php echo $text[183]; ?></a><?php }?></td></tr><?php
    if ($_SESSION['lmouserok'] == 2 || $_SESSION['lmouserokerweitert'] == 1) { ?>
                    <tr><td align="right"><?php if ($show == 2) {echo $text[250];} else { ?><a onclick="return chklmolink();" href="<?php echo $_SERVER['PHP_SELF'] . '?action=admin&amp;todo=edit&amp;show=2&amp;file=' . $file . '&amp;st=-1'; ?>"><?php echo $text[250]; ?></a><?php }?></td></tr><?php
        if ($lmo_opt['Type'] == 0) { ?>
                    <tr><td align="right"><?php if ($show == 3) {echo $text[178];} else { ?><a onclick="return chklmolink();" href="<?php echo $_SERVER['PHP_SELF'] . '?action=admin&amp;todo=edit&amp;show=3&amp;file=' . $file . '&amp;st=-1'; ?>"><?php echo $text[178]; ?></a><?php }?></td></tr>
                    <tr><td align="right"><?php if ($show == 4) {echo $text[16];} else { ?><a onclick="return chklmolink();" href="<?php echo $_SERVER['PHP_SELF'] . '?action=admin&amp;todo=edit&amp;show=4&amp;file=' . $file . '&amp;st=-1'; ?>"><?php echo $text[16]; ?></a><?php }?></td></tr>
                    <tr><td align="right"><a href='<?php echo "$addr-3"; ?>' onclick="return chklmolink();" title="<?php echo $text[339]; ?>"><?php echo $text[338]; ?></a></td></tr><?php
        }
    }?>
                  </table>
                </td>
                <td align="center" valign="top">
                  <form name="lmoedit" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" onSubmit="return chklmopass()">
                    <input type="hidden" name="action" value="admin">
                    <input type="hidden" name="todo" value="edit">
                    <input type="hidden" name="save" value="1">
                    <input type="hidden" name="show" value="<?php echo $show; ?>">
                    <input type="hidden" name="file" value="<?php echo $file; ?>">
                    <input type="hidden" name="st" value="<?php echo $st; ?>">
                    <table class="lmoInner" cellspacing="0" cellpadding="0" border="0">
<?php
    if ($show == 0) {
        if ($_SESSION['lmouserok'] == 2 || $_SESSION['lmouserokerweitert'] == 1) { ?>
                      <tr>
                        <td class="nobr" align="right"><input class="lmo-formular-input" type="text" name="xtitel" size="40" maxlength="60" value="<?php echo $lmo_opt['Name']; ?>" onChange="dolmoedit()"></td>
                        <td class="nobr" align="left"><acronym title="<?php echo $text[118]; ?>"><?php echo $text[113]; ?></acronym></td>
                      </tr>
<?php
            if ($lmo_opt['Type'] == 0) { ?>
                      <tr>
                        <td class="nobr" align="right"><input class="lmo-formular-input" type="text" name="xnamepkt" size="7" maxlength="60" value="<?php if ($lmo_opt['namePkt'] == '') {echo $text[37];} else {echo $lmo_opt['namePkt'];} ?>" onChange="dolmoedit()"></td>
                        <td class="nobr" align="left"><acronym title="<?php echo $text[66]; ?>"><?php echo $text[65] . ' ' . $text[37]; ?></acronym></td>
                      </tr>
                      <tr>
                        <td class="nobr" align="right"><input class="lmo-formular-input" type="text" name="xnametor" size="7" maxlength="60" value="<?php if ($lmo_opt['nameTor'] == '') {echo $text[38];} else {echo $lmo_opt['nameTor'];} ?>" onChange="dolmoedit()"></td>
                        <td class="nobr" align="left"><acronym title="<?php echo $text[66]; ?>"><?php echo $text[65] . ' ' . $text[38]; ?></acronym></td>
                      </tr>
<?php
            }?>
                      <tr>
                        <td class="nobr" align="right">
                          <select class="lmo-formular-input" name="xpointsfaktor" size="1" onChange="dolmoedit()">
                            <option value="1"<?php if ($lmo_opt['pointsfaktor'] == 1) echo ' selected'; ?>><?php echo $text[553]; ?></option>
                            <option value="10"<?php if ($lmo_opt['pointsfaktor'] == 10) echo ' selected'; ?>><?php echo $text[554]; ?></option>
                            <option value="100"<?php if ($lmo_opt['pointsfaktor'] == 100) echo ' selected'; ?>><?php echo $text[555]; ?></option>
                            <option value="1000"<?php if ($lmo_opt['pointsfaktor'] == 1000) echo ' selected'; ?>><?php echo $text[556]; ?></option>
                          </select>
                        </td>
                        <td class="nobr" align="left"><acronym title="<?php echo $text[558]; ?>"><?php echo $text[557]; ?> <?php echo $text[37]; ?></acronym></td>
                      </tr>
                      <tr>
                        <td class="nobr" align="right">
                          <select class="lmo-formular-input" name="xgoalfaktor" size="1" onChange="dolmoedit()">
                            <option value="1"<?php if ($lmo_opt['goalfaktor'] == 1) echo ' selected'; ?>><?php echo $text[553]; ?></option>
                            <option value="10"<?php if ($lmo_opt['goalfaktor'] == 10) echo ' selected'; ?>><?php echo $text[554]; ?></option>
                            <option value="100"<?php if ($lmo_opt['goalfaktor'] == 100) echo ' selected'; ?>><?php echo $text[555]; ?></option>
                            <option value="1000"<?php if ($lmo_opt['goalfaktor'] == 1000) echo ' selected'; ?>><?php echo $text[556]; ?></option>
                          </select>
                        </td>
                        <td class="nobr" align="left"><acronym title="<?php echo $text[558]; ?>"><?php echo $text[557]; ?> <?php echo $text[38]; ?></acronym></td>
                      </tr>
<?php
        }?>
                      <tr>
                        <td class="nobr" align="right">
                          <select class="lmo-formular-input" name="xfavteam" onChange="dolmoedit()">
<?php
        for ($y = 0; $y <= $lmo_mannschaften; $y++) { ?>
                            <option value="<?php echo $y; ?>"<?php if ($y == $lmo_opt['favTeam']) {echo ' selected';}?>><?php echo $lmo_namen[$y]; ?></option>
<?php
        }?>
                          </select>
                        </td>
                        <td class="nobr" align="left"><acronym title="<?php echo $text[190]; ?>"><?php echo $text[189]; ?></acronym></td>
                      </tr>
                      <tr>
                        <td class="nobr" align="right">
                          <select class="lmo-formular-input" name="xselteam" onChange="dolmoedit()">
<?php
        for ($y = 0; $y <= $lmo_mannschaften; $y++) { ?>
                            <option value="<?php echo $y; ?>"<?php if ($y == $lmo_opt['selTeam']) {echo ' selected';}?>><?php echo $lmo_namen[$y]; ?></option>
<?php
        }?>
                          </select>
                        </td>
                        <td class="nobr" align="left"><acronym title="<?php echo $text[195]; ?>"><?php echo $text[194]; ?></acronym></td>
                      </tr>
<?php
        if ($lmo_opt['Type'] == 0) { ?>
                      <tr>
                        <td class="nobr" align="right">
                          <select class="lmo-formular-input" name="xstat1" onChange="dolmoedit()">
<?php
            for ($y = 0; $y <= $lmo_mannschaften; $y++) { ?>
                            <option value="<?php echo $y; ?>"<?php if ($y == $lmo_opt['kurve1']) {echo ' selected';}?>><?php echo $lmo_namen[$y]; ?></option>
<?php
            }?>
                          </select>
                        </td>
                        <td class="nobr" align="left" rowspan="2"><acronym title="<?php echo $text[197]; ?>"><?php echo $text[196]; ?></acronym></td>
                      </tr>
                      <tr>
                        <td class="nobr" align="right"><select class="lmo-formular-input" name="xstat2" onChange="dolmoedit()">
<?php
            for ($y = 0; $y <= $lmo_mannschaften;$y++) { ?>
                            <option value="<?php echo $y; ?>"<?php if ($y == $lmo_opt['kurve2']) {echo ' selected';}?>><?php echo $lmo_namen[$y]; ?></option>
<?php
            }?>
                          </select>
                        </td>
                      </tr>
<?php
        }
    }
    elseif ($show == 2) {
        if ($_SESSION['lmouserok'] == 2 || $_SESSION['lmouserokerweitert'] == 1) { ?>
                      <tr>
                        <td class="nobr" align="right"><acronym title="<?php echo $text[570]; ?>"><?php echo $text[569]; ?></acronym></td>
                        <td class="nobr" align="left"><input type="checkbox" class="lmo-formular-input" name="xenablegamesort" onChange="dolmoedit()"<?php if ($lmo_opt['enableGameSort'] == 1) {echo ' checked';}?>></td>
                      </tr>
<?php
            if ($lmo_opt['Type'] == 1) { ?>
                      <tr>
                        <td class="nobr" align="right"><acronym title="<?php echo $text[418]; ?>"><?php echo $text[417]; ?></acronym></td>
                        <td class="nobr" align="left"><input type="checkbox" class="lmo-formular-input" name="xklfin" onChange="dolmoedit()"<?php if ($lmo_opt['KlFin'] == 1) {echo ' checked';}?>></td>
                      </tr>
                      <tr>
                        <td class="nobr" align="right"><acronym title="<?php echo $text[552]; ?>"><?php echo $text[551]; ?></acronym></td>
                        <td class="nobr" align="left"><input type="checkbox" class="lmo-formular-input" name="xplaydown" onChange="dolmoedit()"<?php if ($lmo_opt['playdown'] == 1) {echo ' checked';}?>></td>
                      </tr>
<?php
            }
            if ($lmo_opt['Type'] == 0) { ?>
                      <tr>
                        <td class="nobr" align="right"><acronym title="<?php echo $text[400]; ?>"><?php echo $text[399]; ?></acronym>&nbsp;</td>
                        <td class="nobr" align="left">
                          <select class="lmo-formular-input" name="xonrun" onChange="dolmoedit()">
                            <option value="0"<?php if ($lmo_opt['Ergebnis'] == '0') {echo ' disabled';} elseif ($lmo_opt['OnRun'] == 0) {echo ' selected';}?>><?php echo $text[10]; ?></option>
                            <option value="1"<?php if ($lmo_opt['Tabelle'] == '0') {echo ' disabled';} elseif ($lmo_opt['OnRun'] == 1) {echo ' selected';}?>><?php echo $text[16]; ?></option>
                            <option value="2"<?php if ($lmo_opt['Plan'] == '0') {echo ' disabled';} elseif ($lmo_opt['OnRun'] == 2) {echo ' selected';}?>><?php echo $text[12]; ?></option>
                            <option value="3"<?php if ($lmo_opt['Kreuz'] == '0') {echo ' disabled';} elseif ($lmo_opt['OnRun'] == 3) {echo ' selected';}?>><?php echo $text[14]; ?></option>
                            <option value="4"<?php if ($lmo_opt['Graph'] == '0') {echo ' disabled';} elseif ($lmo_opt['OnRun'] == 4) {echo ' selected';}?>><?php echo $text[133]; ?></option>
                            <option value="5"<?php if ($lmo_opt['Ligastats'] == '0') {echo ' disabled';} elseif ($lmo_opt['OnRun'] == 5) {echo ' selected';}?>><?php echo $text[18]; ?></option>
                            <option value="6"<?php if ($lmo_opt['DatS'] == '0') {echo ' disabled';} elseif ($lmo_opt['OnRun'] == 6) {echo ' selected';}?>><?php echo $text[140]; ?></option>
                            <option value="7"<?php if ($lmo_opt['mittore'] == '0') {echo ' disabled';} elseif ($lmo_opt['OnRun'] == 7) {echo ' selected';}?>><?php echo $text[485]; ?></option>
                          </select>
                        </td>
                      </tr>
<?php
            }?>
                      <tr>
                        <td class="nobr" align="right"><acronym title="<?php echo $text[254]; ?>"><?php echo $text[253]; ?></acronym>&nbsp;</td>
                        <td class="nobr" align="left"><input type="checkbox" class="lmo-formular-input" name="xdatm" onChange="dolmoedit()"<?php if ($lmo_opt['DatM'] == 1) {echo ' checked';}?>></td>
                      </tr>
                      <tr>
                        <td class="nobr" rowspan="2" align="right"><acronym title="<?php echo $text[256]; ?>"><?php echo $text[257]; ?></acronym>&nbsp;</td>
                        <td class="nobr" align="left">
                          <input type="radio" name="xdatfselect" value="1" checked>
                          <select class="lmo-formular-input" name="xdatf" onChange="dolmoedit();document.getElementsByName('xdatfselect')[0].checked=true;">
<?php
            $dummf = array('d.m. H:i', 'd.m.Y H:i', 'D., d.m. H:i', 'l, d.m. H:i', 'D., d.m.Y H:i', 'l, d.m.Y H:i'); ?>
                            <option value="">__</option><?php
            for ($y = 0; $y < count($dummf); $y++) { ?>
                            <option value="<?php echo $dummf[$y]; ?>"<?php if ($lmo_opt['DatF'] == $dummf[$y]) {echo ' selected';}?>><?php echo strtr(date($dummf[$y], time()), $trans_lang); ?></option>
<?php
            }?>
                          </select>
                        </td>
                      </tr>
                      <tr>
                        <td class="nobr" align="left">
                          <input type="radio" name="xdatfselect" value=""<?php if (!in_array($lmo_opt['DatF'],$dummf)) echo ' checked'; ?>>
                          <input type="text" class="lmo-formular-input" name="xdatf2" onChange="dolmoedit();document.getElementsByName('xdatf')[1].checked=true;" value="<?php echo $lmo_opt['DatF']?>">
                          <a href="https://www.php.net/manual/de/datetime.format.php">
                            <span class="popup">
                              <strong>&nbsp;<?php echo $text[545];?></strong><br>
                              &nbsp;&nbsp;D = <?php echo strtr(date('D', time()), $trans_lang); ?><br>
                              &nbsp;&nbsp;l = <?php echo strtr(date('l', time()), $trans_lang); ?><br>
                              <strong>&nbsp;<?php echo $text[546]; ?></strong><br>
                              &nbsp;&nbsp;d = <?php echo strtr(date('d', time()), $trans_lang); ?><br>
                              &nbsp;&nbsp;j = <?php echo strtr(date('j', time()), $trans_lang); ?><br>
                              <strong>&nbsp;<?php echo $text[547]; ?></strong><br>
                              &nbsp;&nbsp;m = <?php echo strtr(date('m', time()), $trans_lang); ?><br>
                              &nbsp;&nbsp;M = <?php echo strtr(date('M', time()), $trans_lang); ?><br>
                              &nbsp;&nbsp;F = <?php echo strtr(date('F', time()), $trans_lang); ?><br>
                              <strong>&nbsp;<?php echo $text[548]; ?></strong><br>
                              &nbsp;&nbsp;y = <?php echo strtr(date('y', time()), $trans_lang); ?><br>
                              &nbsp;&nbsp;Y = <?php echo strtr(date('Y', time()), $trans_lang); ?><br>
                              <strong>&nbsp;<?php echo $text[549]; ?></strong><br>
                              &nbsp;&nbsp;H = <?php echo strtr(date('H', time()), $trans_lang); ?><br>
                              &nbsp;&nbsp;i = <?php echo strtr(date('i', time()), $trans_lang); ?><br>
                              &nbsp;&nbsp;A = <?php echo strtr(date('A', time()), $trans_lang); ?><br>
                            </span>
                          ?</a>
                        </td>
                      </tr>
                      <tr>
                        <td class="nobr" align="right"><acronym title="<?php echo $text[252]; ?>"><?php echo $text[251]; ?></acronym>&nbsp;<input type="checkbox" class="lmo-formular-input" name="xdats" onChange="dolmoedit()"<?php if ($lmo_opt['DatS'] == 1) {echo ' checked';}?>>&nbsp;</td>
                        <td>&nbsp;</td>
                      </tr>
                      <tr>
<?php
            if ($lmo_opt['Type'] == 0 && $tabonres == 0) { ?>
                        <td class="nobr" align="right"><acronym title="<?php echo $text[512]; ?>"><?php echo $text[10]; ?></acronym>&nbsp;<input type="checkbox" class="lmo-formular-input" name="xergebnis" onChange="dolmoedit()"<?php if ($lmo_opt['Ergebnis'] == 1) {echo ' checked';}?>>&nbsp;</td>
                        <td class="nobr" align="left">&nbsp;<input type="checkbox" class="lmo-formular-input" name="xtabelle" onChange="dolmoedit()"<?php if ($lmo_opt['Tabelle'] == 1) {echo ' checked';}?>>&nbsp;<acronym title="<?php echo $text[513]; ?>"><?php echo $text[16]; ?></acronym></td><?php
            }
            if ($lmo_opt['Type'] == 1) { ?>
                        <td class="nobr" align="right"><acronym title="<?php echo $text[512]; ?>"><?php echo $text[10]; ?></acronym>&nbsp;<input type="checkbox" class="lmo-formular-input" name="xergebnis" onChange="dolmoedit()"<?php if ($lmo_opt['Ergebnis'] == 1) {echo ' checked';}?>>&nbsp;</td>
                        <td></td>
<?php
            }
            if ($lmo_opt['Type'] == 0 && $tabonres >= 1) { ?>
                        <td class="nobr" align="right"><acronym title="<?php echo $text[512]; ?>"><?php echo $text[10] . '/' . $text[16]; ?></acronym>&nbsp;<input type="checkbox" class="lmo-formular-input" name="xergebnis" onChange="dolmoedit()"<?php if ($lmo_opt['Ergebnis'] == 1) {echo ' checked';}?>>&nbsp;</td>
                        <td></td>
<?php
            }?>
                      </tr>
                      <tr>
                        <td class="nobr" align="right"><acronym title="<?php echo $text[256]; ?>"><?php echo $text[255]; ?></acronym>&nbsp;<input type="checkbox" class="lmo-formular-input" name="xdatc" onChange="dolmoedit()"<?php if ($lmo_opt['DatC'] == 1) {echo ' checked';}?>>&nbsp;</td>
                        <td class="nobr" align="left">&nbsp;<input type="checkbox" class="lmo-formular-input" name="xplan" onChange="dolmoedit()"<?php if ($lmo_opt['Plan'] == 1) {echo ' checked';}?>>&nbsp;<acronym title="<?php echo $text[511]; ?>"><?php echo $text[12]; ?></acronym></td>
                      </tr>
<?php
            if ($lmo_opt['Type'] == 0) { ?>
                      <tr>
                        <td class="nobr" align="right"><acronym title="<?php echo $text[468]; ?>"><?php echo $text[467]; ?></acronym>&nbsp;<input type="checkbox" class="lmo-formular-input" name="xkreuz" onChange="dolmoedit()"<?php if ($lmo_opt['Kreuz'] == 1) {echo ' checked';}?>>&nbsp;</td>
                        <td class="nobr" align="left">&nbsp;<input type="checkbox" class="lmo-formular-input" name="xkurve" onChange="dolmoedit()"<?php if ($lmo_opt['Graph'] == 1) {echo ' checked';}?>>&nbsp;<acronym title="<?php echo $text[238]; ?>"><?php echo $text[237]; ?></acronym></td>
                      </tr>
<?php
            }?>
                      <tr>
<?php
            if ($einspieler == 1) { ?>
                        <td class="nobr" align="right"><acronym title="<?php echo $text['spieler'][19]; ?>"><?php echo $text['spieler'][18]; ?></acronym>&nbsp;<input type="checkbox" class="lmo-formular-input" name="xmittore" onChange="dolmoedit()"<?php if ($lmo_opt['mittore'] == 1) {echo ' checked';}?>>&nbsp;</td><?php
            }
            else { ?>
                        <td></td>
<?php
            }
            if ($lmo_opt['Type'] == 0) { ?>
                        <td class="nobr" align="left">&nbsp;<input type="checkbox" class="lmo-formular-input" name="xligastats" onChange="dolmoedit()"<?php if ($lmo_opt['Ligastats'] == 1) {echo ' checked';}?>>&nbsp;<acronym title="<?php echo $text[514]; ?>"><?php echo $text[18]; ?></acronym></td><?php
            }
            else { ?>
                        <td></td>
<?php
            }?>
                      </tr>
                      <tr>
                        <th align="left" colspan="2"><?php echo $text[264]; ?></th>
                      </tr>
                      <tr>
                        <td class="nobr" align="right"><input type="checkbox" class="lmo-formular-input" name="xurlt" onChange="dolmoedit()"<?php if ($lmo_opt['urlT'] == 1) {echo ' checked';}?>></td>
                        <td class="nobr" align="left"><acronym title="<?php echo $text[268]; ?>"><?php echo $text[267]; ?></acronym></td>
                      </tr>
                      <tr>
                        <td class="nobr" align="right"><input type="checkbox" class="lmo-formular-input" name="xurlb" onChange="dolmoedit()"<?php if ($lmo_opt['urlB'] == 1) {echo ' checked';}?>></td>
                        <td class="nobr" align="left"><acronym title="<?php echo $text[266]; ?>"><?php echo $text[265]; ?></acronym></td>
                      </tr>
<?php
        }
        if ($lmo_opt['Type'] == 1) { ?>
                      <tr>
                        <th align="left" colspan="2"><?php echo $text[800]; ?></th>
                      </tr>
                      <tr>
                        <td class="nobr" align="center" colspan="2"></td>
                      </tr>
                      <tr>
                        <th align="center"><?php echo $text[355]; ?></th>
                        <td class="nobr" align="center" rowspan="3"></td>
                      </tr>
                      <tr>
                        <td class="nobr" align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<acronym title="<?php echo $text[802]; ?>"><?php echo $text[801]; ?></acronym><hr></td>
                      </tr>
                      <tr>
                        <th align="center"><?php echo $text[356]; ?></th>
                      </tr>
                      <tr>
                        <td class="nobr" align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<acronym title="<?php echo $text[802]; ?>"><?php echo $text[801]; ?></acronym></td>
                        <th align="center"><?php echo $text[809]; ?></th>
                      </tr>
                      <tr>
                        <td class="nobr" align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<acronym title="<?php echo $text[804]; ?>"><?php echo $text[803]; ?></acronym><hr></td>
                        <td class="nobr" valign="top" align="center" rowspan="5">
                          <select class="form-select" name="xplayoffmode" onChange="dolmoedit()">
                            <option value="0"<?php if ($lmo_opt['playoffmode'] == 0) echo ' selected'; ?>><?php echo $text[801]; ?></option>
                            <option value="1"<?php if ($lmo_opt['playoffmode'] == 1) echo ' selected'; ?>><?php echo $text[803]; ?></option>
                            <option value="2"<?php if ($lmo_opt['playoffmode'] == 2) echo ' selected'; ?>><?php echo $text[805]; ?></option>
                            <option value="3"<?php if ($lmo_opt['playoffmode'] == 3) echo ' selected'; ?>><?php echo $text[807]; ?></option>
                          </select></td>
                      </tr>
                      <tr>
                        <th align="center"><?php echo $text[357]; ?></th>
                      </tr>
                      <tr>
                        <td class="nobr" align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<acronym title="<?php echo $text[802]; ?>"><?php echo $text[801]; ?></acronym></td>
                      </tr>
                      <tr>
                        <td class="nobr" align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<acronym title="<?php echo $text[806]; ?>"><?php echo $text[805]; ?></acronym></td>
                      </tr>
                      <tr>
                        <td class="nobr" align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<acronym title="<?php echo $text[808]; ?>"><?php echo $text[807]; ?></acronym></td>
                      </tr>
<?php
        }
    }
    elseif ($show == 3) {
        if (($_SESSION['lmouserok'] == 2  || $_SESSION['lmouserokerweitert'] == 1) && $lmo_opt['Type'] == 0) { ?>
                      <tr>
                        <td class="nobr" align="right"><input type="checkbox" class="lmo-formular-input" name="xminus" onChange="dolmoedit()"<?php if ($lmo_opt['MinusPoints'] == 2) {echo ' checked';}?>>&nbsp;</td>
                        <td class="nobr" align="left">&nbsp;<acronym title="<?php echo $text[180]; ?>"><?php echo $text[179]; ?></acronym></td>
                      </tr>
                      <tr>
                        <td class="nobr" align="right"><input type="checkbox" class="lmo-formular-input" name="xspez" onChange="dolmoedit()"<?php if ($lmo_opt['Spez'] == 1) {echo ' checked';}?>>&nbsp;</td>
                        <td class="nobr" align="left">&nbsp;<acronym title="<?php echo $text[185]; ?>"><?php echo $text[184]; ?></acronym></td>
                      </tr>
                      <tr>
                        <td class="nobr" align="right"><input type="checkbox" class="lmo-formular-input" name="xhidr" onChange="dolmoedit()"<?php if ($lmo_opt['HideDraw'] == 1) {echo ' checked';}?>>&nbsp;</td>
                        <td class="nobr" align="left">&nbsp;<acronym title="<?php echo $text[242]; ?>"><?php echo $text[241]; ?></acronym></td>
                      </tr>
                      <tr>
                        <td class="nobr" align="right"><input type="checkbox" class="lmo-formular-input" name="xdirekt" onChange="dolmoedit()"<?php if ($lmo_opt['Direct'] == 1) {echo ' checked';}?>>&nbsp;</td>
                        <td class="nobr" align="left">&nbsp;<acronym title="<?php echo $text[187]; ?>"><?php echo $text[186]; ?></acronym></td>
                      </tr>
                      <tr>
                        <td class="nobr" align="right"><input type="checkbox" class="lmo-formular-input" name="xkegel" onChange="dolmoedit()"<?php if ($lmo_opt['Kegel'] == 1) {echo ' checked';}?>>&nbsp;</td>
                        <td class="nobr" align="left">&nbsp;<acronym title="<?php echo $text[396]; ?>"><?php echo $text[395]; ?></acronym></td>
                      </tr>
                      <tr>
                        <td class="nobr" align="right"><input type="checkbox" class="lmo-formular-input" name="xhands" onChange="dolmoedit()"<?php if ($lmo_opt['HandS'] == 1) {echo ' checked';}?>>&nbsp;</td>
                        <td class="nobr" align="left">&nbsp;<acronym title="<?php echo $text[408]; ?>"><?php echo $text[407]; ?></acronym></td>
                      </tr>
                      <tr>
                        <th align="left" colspan="2"><?php echo $text[198]; ?></th>
                      </tr>
                      <tr>
                        <td class="nobr" colspan="2" align="left">
                          <table cellspacing="0" cellpadding="0" border="0">
                            <tr>
                              <td class="nobr" align="left">&nbsp;</td>
                              <th class="nobr" align="center">&nbsp;<acronym title="<?php echo $text[199]; ?>"><?php echo $text[34]; ?></acronym>&nbsp;</th>
                              <th class="nobr" align="center">&nbsp;<acronym title="<?php echo $text[200]; ?>"><?php echo $text[35]; ?></acronym>&nbsp;</th>
                              <th class="nobr" align="center">&nbsp;<acronym title="<?php echo $text[201]; ?>"><?php echo $text[36]; ?></acronym>&nbsp;</th>
                            </tr>
                            <tr>
                              <td class="nobr" align="right"><?php echo $text[202]; ?>&nbsp;</td>
                              <td class="nobr" align="center"><input class="lmo-formular-input" name="xpns" size="2" onChange="dolmoedit()" value=<?php echo $lmo_opt['PointsForWin']; ?>></td>
                              <td class="nobr" align="center"><input class="lmo-formular-input" name="xpnu" size="2" onChange="dolmoedit()" value=<?php echo $lmo_opt['PointsForDraw']; ?>></td>
                              <td class="nobr" align="center"><input class="lmo-formular-input" name="xpnn" size="2" onChange="dolmoedit()" value=<?php echo $lmo_opt['PointsForLost']; ?>></td>
                            </tr>
                            <tr>
                              <td class="nobr" align="right"><?php echo $text[203]; ?>&nbsp;</td>
                              <td class="nobr" align="center"><input class="lmo-formular-input" name="xpxs" size="2" onChange="dolmoedit()" value=<?php echo $lmo_opt['XtraS']; ?>></td>
                              <td class="nobr" align="center"><input class="lmo-formular-input" name="xpxu" size="2" onChange="dolmoedit()" value=<?php echo $lmo_opt['XtraU']; ?>></td>
                              <td class="nobr" align="center"><input class="lmo-formular-input" name="xpxn" size="2" onChange="dolmoedit()" value=<?php echo $lmo_opt['XtraV']; ?>></td>
                            </tr>
                            <tr>
                              <td class="nobr" align="right"><?php echo $text[204]; ?>&nbsp;</td>
                              <td class="nobr" align="center"><input class="lmo-formular-input" name="xpps" size="2" onChange="dolmoedit()" value=<?php echo $lmo_opt['SpezS']; ?>></td>
                              <td class="nobr" align="center"><input class="lmo-formular-input" name="xppu" size="2" onChange="dolmoedit()" value=<?php echo $lmo_opt['SpezU']; ?>></td>
                              <td class="nobr" align="center"><input class="lmo-formular-input" name="xppn" size="2" onChange="dolmoedit()" value=<?php echo $lmo_opt['SpezV']; ?>></td>
                            </tr>
                          </table>
                        </td>
                      </tr>
<?php
        }
    }
    elseif ($show == 4) {
        if ($_SESSION['lmouserok'] == 2 || $_SESSION['lmouserokerweitert'] == 1) { ?>
                      <tr>
                        <th align="left" colspan="2"><?php echo $text[264]; ?></th>
                      </tr>
                       <tr>
                        <td class="nobr" align="right">&nbsp;<input type="checkbox" class="lmo-formular-input" name="xeinhinrueck" onChange="dolmoedit()"<?php if ($lmo_opt['tableHinRueck'] == 1) {echo ' checked';}?>>&nbsp;</td>
                        <td align="left">&nbsp;<acronym title="<?php echo $text[494]; ?>"><?php echo $text[493]; ?></acronym></td>
                      </tr>
                       <tr>
                        <td class="nobr" align="right">&nbsp;<input type="checkbox" class="lmo-formular-input" name="xeinheimausw" onChange="dolmoedit()"<?php if ($lmo_opt['tableHeimAusw'] == 1) {echo ' checked';}?>>&nbsp;</td>
                        <td align="left">&nbsp;<acronym title="<?php echo $text[566]; ?>"><?php echo $text[565]; ?></acronym></td>
                      </tr>
                      <tr>
                        <th align="left" colspan="2"><?php echo $text[378]; ?></th>
                      </tr>
                      <tr>
                        <td class="nobr" align="right">&nbsp;<input type="checkbox" class="lmo-formular-input" name="xchamp" onChange="dolmoedit()"<?php if ($lmo_opt['Champ'] == 1) {echo ' checked';}?>>&nbsp;</td>
                        <td class="lmoTabelleMeister" align="left">&nbsp;<acronym title="<?php echo $text[380]; ?>"><?php echo $text[379]; ?></acronym></td>
                      </tr>
                      <tr>
                        <td class="nobr" align="right">
                          <select class="lmo-formular-input" name="xanzcl" onChange="dolmoedit()">
<?php
            for ($i = 0; $i < 9; $i++) { ?>
                            <option value="<?php echo $i; ?>"<?php if ($lmo_opt['CL'] == $i) {echo ' selected';}?>><?php echo $i; ?></option>
<?php
            }?>
                          </select>&nbsp;
                        </td>
                        <td class="lmoTabelleCleague" align="left"><acronym title="<?php echo $text[382]; ?>"><?php echo $text[381]; ?></acronym></td>
                      </tr>
                      <tr>
                        <td class="nobr" align="right">
                          <select class="lmo-formular-input" name="xanzck" onChange="dolmoedit()">
<?php
            for ($i = 0; $i < 5; $i++) { ?>
                            <option value="<?php echo $i; ?>"<?php if ($lmo_opt['CK'] == $i) {echo ' selected';}?>><?php echo $i; ?></option>
<?php
            }?>
                          </select>&nbsp;
                        </td>
                        <td class="lmoTabelleCleaguequali" align="left">&nbsp;<acronym title="<?php echo $text[384]; ?>"><?php echo $text[383]; ?></acronym>
                      </tr>
                      <tr>
                        <td class="nobr" align="right">
                          <select class="lmo-formular-input" name="xanzuc" onChange="dolmoedit()">
<?php
            for ($i = 0; $i <= $lmo_mannschaften; $i++) { ?>
                            <option value="<?php echo $i; ?>"<?php if ($lmo_opt['UC'] == $i) {echo ' selected';}?>><?php echo $i; ?></option>
<?php
            }?>
                          </select>&nbsp;
                        </td>
                        <td class="lmoTabelleUefa" align="left">&nbsp;<acronym title="<?php echo $text[386]; ?>"><?php echo $text[385]; ?></acronym></td>
                      </tr>
                      <tr>
                        <td class="nobr" align="right">
                          <select class="lmo-formular-input" name="xanzar" onChange="dolmoedit()">
<?php
            for ($i = 0; $i <= $lmo_mannschaften; $i++) { ?>
                            <option value="<?php echo $i; ?>"<?php if ($lmo_opt['AR'] == $i) {echo ' selected';}?>><?php echo $i; ?></option>
<?php
            }?>
                          </select>&nbsp;
                        </td>
                        <td class="lmoTabelleRelegation" align="left">&nbsp;<acronym title="<?php echo $text[394]; ?>"><?php echo $text[393]; ?></acronym></td>
                      </tr>
                      <tr>
                        <td class="nobr" align="right">
                          <select class="lmo-formular-input" name="xanzab" onChange="dolmoedit()">
<?php
            for ($i = 0; $i <= $lmo_mannschaften; $i++) { ?>
                            <option value="<?php echo $i; ?>"<?php if ($lmo_opt['AB'] == $i) {echo ' selected';}?>><?php echo $i; ?></option>
<?php
            }?>
                          </select>&nbsp;
                        </td>
                        <td class="lmoTabelleAbsteiger" align="left">&nbsp;<acronym title="<?php echo $text[388]; ?>"><?php echo $text[387]; ?></acronym></td>
                      </tr>
<?php
        }
    }?>
                      <tr>
                        <td class="nobr" align="center" colspan="2" width="100%">
                          <input title="<?php echo $text[114]; ?>" class="lmo-formular-button" type="submit" name="best" value="<?php echo $text[188]; ?>">
                        </td>
                      </tr>
                    </table>
                  </form>
                </td>
              </tr>
            </table>
<?php
}
?>