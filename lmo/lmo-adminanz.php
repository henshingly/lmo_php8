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
 */

require_once(PATH_TO_LMO . '/lmo-admintest.php');
if ($file != '' && ($_SESSION['lmouserok'] == 2 || $_SESSION['lmouserokerweitert'] == 1)) {
    require_once(PATH_TO_LMO . '/lmo-openfile.php');
    if (isset ($save) && $save == 1) {
        // Was bisher hinter der letzten Partie oder dem letzten Spieltag lag, beginnt leer
        $lmo_einstellungen = $lmo_liga->einstellungen();
        $lmo_anz_spieltage = $lmo_einstellungen->spieltage();
        $lmo_anz_partien = $lmo_einstellungen->partienJeSpieltag();
        for ($i = 1; $i <= 116; $i++) {
            for ($j = $i <= $lmo_anz_spieltage ? $lmo_anz_partien + 1 : 1; $j <= 40; $j++) {
                $lmo_liga->spieltag($i)->partien[$j] = \Lmo\Liga\Rohdaten\Partie::leer();
            }
        }
        $lmo_anz_neu = trim($_POST['xanzst']);
        $lmo_liga->setzeEinstellung('Rounds', $lmo_anz_neu);
        $lmo_liga->setzeEinstellung('Matches', trim($_POST['xanzsp']));
        // der aktuelle Spieltag liegt hoechstens auf dem letzten
        if ($lmo_einstellungen->aktuellerSpieltag() > $lmo_anz_neu) {
            $lmo_liga->setzeEinstellung('Actual', $lmo_anz_neu);
        }
        require(PATH_TO_LMO . '/lmo-saveliga.php');
    }
    $addr = $_SERVER['PHP_SELF'] . '?action=admin&amp;todo=edit&amp;file=' . $file . '&amp;st=';
    $addb = $_SERVER['PHP_SELF'] . '?action=admin&amp;todo=tabs&amp;file=' . $file . '&amp;st=';
?>
      <table class="lmoSubmenu" width="100%" cellpadding="0" cellspacing="0">
        <tr>
          <td align="left">
<?php include(PATH_TO_LMO . '/lmo-adminsubnavi.php'); ?>
          </td>
        </tr>
      </table>
      <table class="lmoMiddle" cellspacing="0" cellpadding="0" border="0">
        <tr>
          <td align="center">
            <form name="lmoedit" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" onSubmit="return chklmopass()">
              <input type="hidden" name="action" value="admin">
              <input type="hidden" name="todo" value="edit">
              <input type="hidden" name="save" value="1">
              <input type="hidden" name="file" value="<?php echo $file; ?>">
              <input type="hidden" name="st" value="<?php echo $st; ?>">
              <table class="lmoInner" cellspacing="0" cellpadding="0" border="0">
                <tr>
                  <th class="nobr" align="left" colspan="4"><?php echo $text[340]; ?></th>
                </tr>
                <tr>
                  <td class="nobr" align="center" colspan="4"><?php echo getMessage($text[561], true); ?></td>
                </tr>
                <tr>
                  <td width="20">&nbsp;</td>
                  <td align="right"><acronym title="<?php echo $text[275]; ?>"><?php echo $text[274]; ?></acronym></td>
                  <td align="right"><input class="lmo-formular-input" type="text" name="xanzst" size="3" maxlength="3" value="<?php echo $lmo_liga->einstellungen()->wert('Rounds'); ?>" onChange="lmoanzstauf('xanzst',0)" onKeyDown="lmoanzstclk('xanzst',event.keyCode)"></td>
                  <td align="center">
                    <table cellpadding="0" cellspacing="0" border="0">
                      <tr>
                        <td><script type="text/javascript">document.write('<a href="#" onclick="lmoanzstauf(\'xanzst\',1);" title="<?php echo $text[276]; ?>" onMouseOver="lmoimg(\'sa\',img1)" onMouseOut="lmoimg(\'sa\',img0)"><img src="<?php echo URL_TO_IMGDIR; ?>/lmo-admin0.gif" name="ximgsa" width="7" height="7" border="0"><\/a>')</script></td>
                      </tr>
                      <tr>
                        <td><script type="text/javascript">document.write('<a href="#" onclick="lmoanzstauf(\'xanzst\',-1);" title="<?php echo $text[276]; ?>" onMouseOver="lmoimg(\'sb\',img3)" onMouseOut="lmoimg(\'sb\',img2)"><img src="<?php echo URL_TO_IMGDIR; ?>/lmo-admin2.gif" name="ximgsb" width="7" height="7" border="0"><\/a>')</script></td>
                      </tr>
                    </table>
                  </td>
                </tr>
                <tr>
                  <td width="20">&nbsp;</td>
                  <td align="right"><acronym title="<?php echo $text[278]; ?>"><?php echo $text[277]; ?></acronym></td>
                  <td align="right"><input class="lmo-formular-input" type="text" name="xanzsp" size="2" maxlength="2" value="<?php echo $lmo_liga->einstellungen()->wert('Matches'); ?>" onChange="lmoanzspauf('xanzsp',0)" onKeyDown="lmoanzspclk('xanzsp',event.keyCode)"></td>
                  <td align="center">
                    <table cellpadding="0" cellspacing="0" border="0">
                      <tr>
                        <td><script type="text/javascript">document.write('<a href="#" onclick="lmoanzspauf(\'xanzsp\',1);" title="<?php echo $text[279]; ?>" onMouseOver="lmoimg(\'pa\',img1)" onMouseOut="lmoimg(\'pa\',img0)"><img src="<?php echo URL_TO_IMGDIR; ?>/lmo-admin0.gif" name="ximgpa" width="7" height="7" border="0"><\/a>')</script></td>
                      </tr>
                      <tr>
                        <td><script type="text/javascript">document.write('<a href="#" onclick="lmoanzspauf(\'xanzsp\',-1);" title="<?php echo $text[279]; ?>" onMouseOver="lmoimg(\'pb\',img3)" onMouseOut="lmoimg(\'pb\',img2)"><img src="<?php echo URL_TO_IMGDIR; ?>/lmo-admin2.gif" name="ximgpb" width="7" height="7" border="0"><\/a>')</script></td>
                      </tr>
                    </table>
                  </td>
                </tr>
                <tr>
                  <td colspan="4" align="right">
                    <input title="<?php echo $text[114]; ?>" class="lmo-formular-button" type="submit" name="best" value="<?php echo $text[188]; ?>">
                  </td>
                </tr>
                <tr>
                  <td colspan="4" class="lmoFooter" align="left">
                    <a href="<?php echo $addr; ?>-1"><?php echo $text[544]; ?></a>
                  </td>
                </tr>
              </table>
            </form>
          </td>
        </tr>
      </table><?php
}
?>