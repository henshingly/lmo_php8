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

require_once(PATH_TO_LMO . '/lmo-admintest.php');
isset($_REQUEST['show']) ? $show = $_REQUEST['show'] : $show = 0;
if (isset($_POST['save']) && $_POST['save'] == 1) {
    if ($show == 0) {
        $lmo_main_background1 = isset($_POST['xlmo_main_background1']) ? $_POST['xlmo_main_background1'] : $lmo_main_background1;
        $lmo_main_background2 = isset($_POST['xlmo_main_background2']) ? $_POST['xlmo_main_background2'] : $lmo_main_background2;
        $lmo_main_background4 = isset($_POST['xlmo_main_background4']) ? $_POST['xlmo_main_background4'] : $lmo_main_background4;
        $lmo_main_background5 = isset($_POST['xlmo_main_background5']) ? $_POST['xlmo_main_background5'] : $lmo_main_background5;
        $lmo_main_background6 = isset($_POST['xlmo_main_background6']) ? $_POST['xlmo_main_background6'] : $lmo_main_background6;
        $lmo_main_background7 = isset($_POST['xlmo_main_background7']) ? $_POST['xlmo_main_background7'] : $lmo_main_background7;

        $lmo_main_color1 = isset($_POST['xlmo_main_color1']) ? $_POST['xlmo_main_color1'] : $lmo_main_color1;
        $lmo_main_color2 = isset($_POST['xlmo_main_color2']) ? $_POST['xlmo_main_color2'] : $lmo_main_color2;
        $lmo_main_color4 = isset($_POST['xlmo_main_color4']) ? $_POST['xlmo_main_color4'] : $lmo_main_color4;
        $lmo_main_color5 = isset($_POST['xlmo_main_color5']) ? $_POST['xlmo_main_color5'] : $lmo_main_color5;
        $lmo_main_color6 = isset($_POST['xlmo_main_color6']) ? $_POST['xlmo_main_color6'] : $lmo_main_color6;
        $lmo_main_color7 = isset($_POST['xlmo_main_color7']) ? $_POST['xlmo_main_color7'] : $lmo_main_color7;

        $lmo_main_border1 = isset($_POST['xlmo_main_border1']) ? $_POST['xlmo_main_border1'] : $lmo_main_border1;
        $lmo_main_border4 = isset($_POST['xlmo_main_border4']) ? $_POST['xlmo_main_border4'] : $lmo_main_border4;
        $lmo_main_border5 = isset($_POST['xlmo_main_border5']) ? $_POST['xlmo_main_border5'] : $lmo_main_border5;
        $lmo_main_border6 = isset($_POST['xlmo_main_border6']) ? $_POST['xlmo_main_border6'] : $lmo_main_border6;
        $lmo_main_border7 = isset($_POST['xlmo_main_border7']) ? $_POST['xlmo_main_border7'] : $lmo_main_border7;

        $lmo_main_fontfamily1 = isset($_POST['xlmo_main_fontfamily1']) ? $_POST['xlmo_main_fontfamily1'] : $lmo_main_fontfamily1;
        $lmo_main_fontfamily2 = isset($_POST['xlmo_main_fontfamily2']) ? $_POST['xlmo_main_fontfamily2'] : $lmo_main_fontfamily2;

        $lmo_main_fontsize1 = isset($_POST['xlmo_main_fontsize1']) ? $_POST['xlmo_main_fontsize1'] : $lmo_main_fontsize1;
        $lmo_main_fontsize2 = isset($_POST['xlmo_main_fontsize2']) ? $_POST['xlmo_main_fontsize2'] : $lmo_main_fontsize2;
    }
    elseif ($show == 1) {
        $lmo_middle_background1 = isset($_POST['xlmo_middle_background1']) ? $_POST['xlmo_middle_background1'] : $lmo_middle_background1;
        $lmo_middle_background2 = isset($_POST['xlmo_middle_background2']) ? $_POST['xlmo_middle_background2'] : $lmo_middle_background2;
        $lmo_middle_background4 = isset($_POST['xlmo_middle_background4']) ? $_POST['xlmo_middle_background4'] : $lmo_middle_background4;
        $lmo_middle_background5 = isset($_POST['xlmo_middle_background5']) ? $_POST['xlmo_middle_background5'] : $lmo_middle_background5;
        $lmo_middle_background6 = isset($_POST['xlmo_middle_background6']) ? $_POST['xlmo_middle_background6'] : $lmo_middle_background6;
        $lmo_middle_background7 = isset($_POST['xlmo_middle_background7']) ? $_POST['xlmo_middle_background7'] : $lmo_middle_background7;

        $lmo_middle_color1 = isset($_POST['xlmo_middle_color1']) ? $_POST['xlmo_middle_color1'] : $lmo_middle_color1;
        $lmo_middle_color2 = isset($_POST['xlmo_middle_color2']) ? $_POST['xlmo_middle_color2'] : $lmo_middle_color2;
        $lmo_middle_color4 = isset($_POST['xlmo_middle_color4']) ? $_POST['xlmo_middle_color4'] : $lmo_middle_color4;
        $lmo_middle_color5 = isset($_POST['xlmo_middle_color5']) ? $_POST['xlmo_middle_color5'] : $lmo_middle_color5;
        $lmo_middle_color6 = isset($_POST['xlmo_middle_color6']) ? $_POST['xlmo_middle_color6'] : $lmo_middle_color6;
        $lmo_middle_color7 = isset($_POST['xlmo_middle_color7']) ? $_POST['xlmo_middle_color7'] : $lmo_middle_color7;

        $lmo_middle_border1 = isset($_POST['xlmo_middle_border1']) ? $_POST['xlmo_middle_border1'] : $lmo_middle_border1;
        $lmo_middle_border4 = isset($_POST['xlmo_middle_border4']) ? $_POST['xlmo_middle_border4'] : $lmo_middle_border4;
        $lmo_middle_border5 = isset($_POST['xlmo_middle_border5']) ? $_POST['xlmo_middle_border5'] : $lmo_middle_border5;
        $lmo_middle_border6 = isset($_POST['xlmo_middle_border6']) ? $_POST['xlmo_middle_border6'] : $lmo_middle_border6;
        $lmo_middle_border7 = isset($_POST['xlmo_middle_border7']) ? $_POST['xlmo_middle_border7'] : $lmo_middle_border7;

        $lmo_middle_fontfamily1 = isset($_POST['xlmo_middle_fontfamily1']) ? $_POST['xlmo_middle_fontfamily1'] : $lmo_middle_fontfamily1;
        $lmo_middle_fontfamily2 = isset($_POST['xlmo_middle_fontfamily2']) ? $_POST['xlmo_middle_fontfamily2'] : $lmo_middle_fontfamily2;

        $lmo_middle_fontsize1 = isset($_POST['xlmo_middle_fontsize1']) ? $_POST['xlmo_middle_fontsize1'] : $lmo_middle_fontsize1;
        $lmo_middle_fontsize2 = isset($_POST['xlmo_middle_fontsize2']) ?    $_POST['xlmo_middle_fontsize2'] : $lmo_middle_fontsize2;
    }
    elseif ($show == 2) {
        $lmo_inner_background1 = isset($_POST['xlmo_inner_background1']) ? $_POST['xlmo_inner_background1'] : $lmo_inner_background1;
        $lmo_inner_background2 = isset($_POST['xlmo_inner_background2']) ? $_POST['xlmo_inner_background2'] : $lmo_inner_background2;
        $lmo_inner_background3 = isset($_POST['xlmo_inner_background3']) ? $_POST['xlmo_inner_background3'] : $lmo_inner_background3;
        $lmo_inner_color1 = isset($_POST['xlmo_inner_color1']) ? $_POST['xlmo_inner_color1'] : $lmo_inner_color1;
        $lmo_inner_color2 = isset($_POST['xlmo_inner_color2']) ? $_POST['xlmo_inner_color2'] : $lmo_inner_color2;
        $lmo_inner_color3 = isset($_POST['xlmo_inner_color3']) ? $_POST['xlmo_inner_color3'] : $lmo_inner_color3;

        $lmo_inner_border1 = isset($_POST['xlmo_inner_border1']) ? $_POST['xlmo_inner_border1'] : $lmo_inner_border1;
        $lmo_inner_fontfamily1 = isset($_POST['xlmo_inner_fontfamily1']) ? $_POST['xlmo_inner_fontfamily1'] : $lmo_inner_fontfamily1;
        $lmo_inner_fontsize1 = isset($_POST['xlmo_inner_fontsize1']) ? $_POST['xlmo_inner_fontsize1'] : $lmo_inner_fontsize1;
    }
    elseif ($show == 3) {
        $lmo_tabelle_background1 = isset($_POST['xlmo_tabelle_background1']) ? $_POST['xlmo_tabelle_background1'] : $lmo_tabelle_background1;
        $lmo_tabelle_background2 = isset($_POST['xlmo_tabelle_background2']) ? $_POST['xlmo_tabelle_background2'] : $lmo_tabelle_background2;
        $lmo_tabelle_background3 = isset($_POST['xlmo_tabelle_background3']) ? $_POST['xlmo_tabelle_background3'] : $lmo_tabelle_background3;
        $lmo_tabelle_background4 = isset($_POST['xlmo_tabelle_background4']) ? $_POST['xlmo_tabelle_background4'] : $lmo_tabelle_background4;
        $lmo_tabelle_background5 = isset($_POST['xlmo_tabelle_background5']) ? $_POST['xlmo_tabelle_background5'] : $lmo_tabelle_background5;
        $lmo_tabelle_background6 = isset($_POST['xlmo_tabelle_background6']) ? $_POST['xlmo_tabelle_background6'] : $lmo_tabelle_background6;
        $lmo_tabelle_background7 = isset($_POST['xlmo_tabelle_background7']) ? $_POST['xlmo_tabelle_background7'] : $lmo_tabelle_background7;
        $lmo_tabelle_background8 = isset($_POST['xlmo_tabelle_background8']) ? $_POST['xlmo_tabelle_background8'] : $lmo_tabelle_background8;
        $lmo_tabelle_color1 = isset($_POST['xlmo_tabelle_color1']) ? $_POST['xlmo_tabelle_color1'] : $lmo_tabelle_color1;
        $lmo_tabelle_color2 = isset($_POST['xlmo_tabelle_color2']) ? $_POST['xlmo_tabelle_color2'] : $lmo_tabelle_color2;
        $lmo_tabelle_color3 = isset($_POST['xlmo_tabelle_color3']) ? $_POST['xlmo_tabelle_color3'] : $lmo_tabelle_color3;
        $lmo_tabelle_color4 = isset($_POST['xlmo_tabelle_color4']) ? $_POST['xlmo_tabelle_color4'] : $lmo_tabelle_color4;
        $lmo_tabelle_color5 = isset($_POST['xlmo_tabelle_color5']) ? $_POST['xlmo_tabelle_color5'] : $lmo_tabelle_color5;
        $lmo_tabelle_color6 = isset($_POST['xlmo_tabelle_color6']) ? $_POST['xlmo_tabelle_color6'] : $lmo_tabelle_color6;
        $lmo_tabelle_color7 = isset($_POST['xlmo_tabelle_color7']) ? $_POST['xlmo_tabelle_color7'] : $lmo_tabelle_color7;
        $lmo_tabelle_color8 = isset($_POST['xlmo_tabelle_color8']) ? $_POST['xlmo_tabelle_color8'] : $lmo_tabelle_color8;
    }
    elseif ($show == 4) {
        $lmo_turnier_background1 = isset($_POST['xlmo_turnier_background1']) ? $_POST['xlmo_turnier_background1'] : $lmo_turnier_background1;
        $lmo_turnier_background2 = isset($_POST['xlmo_turnier_background2']) ? $_POST['xlmo_turnier_background2'] : $lmo_turnier_background2;
        $lmo_turnier_color1 = isset($_POST['xlmo_turnier_color1']) ? $_POST['xlmo_turnier_color1'] : $lmo_turnier_color1;
        $lmo_turnier_color2 = isset($_POST['xlmo_turnier_color2']) ? $_POST['xlmo_turnier_color2'] : $lmo_turnier_color2;
    }
    elseif ($show == 5) {
        $lmo_kreuz_fontsize1 = isset($_POST['xlmo_kreuz_fontsize1']) ? $_POST['xlmo_kreuz_fontsize1'] : $lmo_kreuz_fontsize1;
        $lmo_kreuzkal_background2=isset($_POST['xlmo_kreuzkal_background2']) ?$_POST['xlmo_kreuzkal_background2'] : $lmo_kreuzkal_background2;

        $lmo_fieber_color1 = isset($_POST['xlmo_fieber_color1']) ? $_POST['xlmo_fieber_color1'] : $lmo_fieber_color1;
        $lmo_fieber_color2 = isset($_POST['xlmo_fieber_color2']) ? $_POST['xlmo_fieber_color2'] : $lmo_fieber_color2;

        $lmo_footer_fontsize1 = isset($_POST['xlmo_footer_fontsize1']) ? $_POST['xlmo_footer_fontsize1'] : $lmo_footer_fontsize1;
        $lmo_kreuzkal_background1=isset($_POST['xlmo_kreuzkal_background1']) ? $_POST['xlmo_kreuzkal_background1'] : $lmo_kreuzkal_background1;
        $lmo_kreuzkal_color1 = isset($_POST['xlmo_kreuzkal_color1']) ? $_POST['xlmo_kreuzkal_color1'] : $lmo_kreuzkal_color1;

        $lmo_main_underline1 = isset($_POST['xlmo_main_underline1']) ? 'underline' : '';
        $lmo_middle_underline1 = isset($_POST['xlmo_middle_underline1']) ? 'underline' : '';
        $lmo_inner_underline1 = isset($_POST['xlmo_inner_underline1']) ? 'underline' : '';
    }
    elseif ($show == 6) {
        $lmo_formular_background1=isset($_POST['xlmo_formular_background1']) ? $_POST['xlmo_formular_background1'] : $lmo_formular_background1;
        $lmo_formular_background2=isset($_POST['xlmo_formular_background2']) ? $_POST['xlmo_formular_background2'] : $lmo_formular_background2;
        $lmo_formular_color1 = isset($_POST['xlmo_formular_color1']) ? $_POST['xlmo_formular_color1'] : $lmo_formular_color1;
        $lmo_formular_color2 = isset($_POST['xlmo_formular_color2']) ? $_POST['xlmo_formular_color2'] : $lmo_formular_color2;
        $lmo_formular_border1 = isset($_POST['xlmo_formular_border1']) ? $_POST['xlmo_formular_border1'] : $lmo_formular_border1;
        $lmo_formular_border2 = isset($_POST['xlmo_formular_border2']) ? $_POST['xlmo_formular_border2'] : $lmo_formular_border2;
    }
    require(PATH_TO_LMO . '/lmo-savecfg.php');
}

?>
      <script src="<?php echo URL_TO_JSDIR; ?>/colorpicker.js" type="text/javascript"></script>
      <table class="lmoSubmenu" width="100%" cellspacing="0" cellpadding="0" border="0">
        <tr>
          <td align="center"><a href="<?php echo $addr_options; ?>" onclick="return chklmolink();" title="<?php echo $text[320]; ?>"><?php echo $text[319]; ?></a></td>
          <td align="center"><a href="<?php echo $addr_addons; ?>" onclick="return chklmolink();" title="<?php echo $text[498]; ?>"><?php echo $text[497]; ?></a></td>
          <td align="center"><?php echo $text[421]; ?></td>
          <td align="center"><a href="<?php echo $addr_user; ?>" onclick="return chklmolink();" title="<?php echo $text[318]; ?>"><?php echo $text[317]; ?></a></td>
        </tr>
      </table>
      <table class="lmoMiddle" cellspacing="0" cellpadding="0" border="0">
        <tr>
          <td align="center" colspan="2"><h1><?php echo $text[432]; ?></h1></td>
        </tr>
        <tr>
          <td valign="top" align="left">
            <table class="lmoMenu" cellspacing="0" cellpadding="0" border="0">
              <tr><td align="right"><?php if ($show == 0) {echo $text[423]; ?><?php } else {?><a href="<?php echo $_SERVER['PHP_SELF'] . "?action=admin&amp;todo=design&amp;show=0";?>"><?php echo $text[423]; ?></a><?php }?></td></tr>
              <tr><td align="right"><?php if ($show == 1) {echo $text[436]; ?><?php } else {?><a href="<?php echo $_SERVER['PHP_SELF'] . "?action=admin&amp;todo=design&amp;show=1";?>"><?php echo $text[436]; ?></a><?php }?></td></tr>
              <tr><td align="right"><?php if ($show == 2) {echo $text[441]; ?><?php } else {?><a href="<?php echo $_SERVER['PHP_SELF'] . "?action=admin&amp;todo=design&amp;show=2";?>"><?php echo $text[441]; ?></a><?php }?></td></tr>
              <tr><td align="right"><?php if ($show == 3) {echo $text[16]; ?><?php } else {?><a href="<?php echo $_SERVER['PHP_SELF'] . "?action=admin&amp;todo=design&amp;show=3";?>"><?php echo $text[16]; ?></a><?php }?></td></tr>
              <tr><td align="right"><?php if ($show == 4) {echo $text[459]; ?><?php } else {?><a href="<?php echo $_SERVER['PHP_SELF'] . "?action=admin&amp;todo=design&amp;show=4";?>"><?php echo $text[459]; ?></a><?php }?></td></tr>
              <tr><td align="right"><?php if ($show == 5) {echo $text[236]; ?><?php } else {?><a href="<?php echo $_SERVER['PHP_SELF'] . "?action=admin&amp;todo=design&amp;show=5";?>"><?php echo $text[236]; ?></a><?php }?></td></tr>
              <tr><td align="right"><?php if ($show == 6) {echo $text[462]; ?><?php } else {?><a href="<?php echo $_SERVER['PHP_SELF'] . "?action=admin&amp;todo=design&amp;show=6";?>"><?php echo $text[462]; ?></a><?php }?></td></tr>
            </table>
          </td>
          <td align="left" valign="top">
            <form name="lmoedit" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" onSubmit="return chklmopass()">
              <input type="hidden" name="action" value="admin">
              <input type="hidden" name="todo" value="design">
              <input type="hidden" name="save" value="1">
              <input type="hidden" name="show" value="<?php echo $show; ?>">
              <table class="lmoInner" cellspacing="0" cellpadding="0" border="0">
<?php
if ($show == 0) {?>
                <tr>
                  <th colspan="3"><?php echo $text[536]; ?></th>
                </tr>
                <tr>
                  <td width="20">&nbsp;</td>
                  <td align="right">
                    <input class="lmo-formular-input" type="text" name="xlmo_main_background1" id="lmo_main_background1input" size="7" maxlength="7" value="<?php echo $lmo_main_background1; ?>" onChange="dolmoedit();relateColor('lmo_main_background1', this.value);"><script type="text/javascript">makePicker('lmo_main_background1');</script>&nbsp;
                    <input class="lmo-formular-input" type="text" name="xlmo_main_color1" id="lmo_main_color1input" size="7" maxlength="7" value="<?php echo $lmo_main_color1; ?>" onChange="dolmoedit();relateColor('lmo_main_color1', this.value);"><script type="text/javascript">makePicker('lmo_main_color1');</script>
                  </td>
                  <td><acronym title="<?php echo $text[425]; ?>"><?php echo $text[424]; ?></acronym>,&nbsp;<acronym title="<?php echo $text[433]; ?>"><?php echo $text[442]; ?></acronym></td>
                </tr>
                <tr>
                  <td width="20">&nbsp;</td>
                  <td align="right"><input class="lmo-formular-input" type="text" name="xlmo_main_border1" size="25" maxlength="25" value="<?php echo $lmo_main_border1; ?>" onChange="dolmoedit()"></td>
                  <td><acronym title="<?php echo $text[427]; ?>"><?php echo $text[426]; ?></acronym></td>
                </tr>
                <tr>
                  <td width="20">&nbsp;</td>
                  <td align="right"><input class="lmo-formular-input" type="text" name="xlmo_main_fontfamily1" size="25" maxlength="50" value="<?php echo $lmo_main_fontfamily1; ?>" onChange="dolmoedit()"></td>
                  <td><acronym title="<?php echo $text[429]; ?>"><?php echo $text[428]; ?></acronym></td>
                </tr>
                <tr>
                  <td width="20">&nbsp;</td>
                  <td align="right"><input class="lmo-formular-input" type="text" name="xlmo_main_fontsize1" size="6" maxlength="6" value="<?php echo $lmo_main_fontsize1; ?>" onChange="dolmoedit()"></td>
                  <td><?php echo $text[430]; ?></td>
                </tr>
                <tr>
                  <th colspan="3"><?php echo $text[537]; ?></th>
                </tr>
                <tr>
                  <td width="20">&nbsp;</td>
                  <td class="nobr" align="right">
                    <input class="lmo-formular-input" type="text" name="xlmo_main_background2" id="lmo_main_background2input" size="7" maxlength="7" value="<?php echo $lmo_main_background2; ?>" onChange="dolmoedit();relateColor('lmo_main_background2', this.value);"><script type="text/javascript">makePicker('lmo_main_background2');</script>
                    <input class="lmo-formular-input" type="text" name="xlmo_main_color2" id="lmo_main_color2input" size="7" maxlength="7" value="<?php echo $lmo_main_color2; ?>" onChange="dolmoedit();relateColor('lmo_main_color2', this.value);"><script type="text/javascript">makePicker('lmo_main_color2');</script>
                  </td>
                  <td><acronym title="<?php echo $text[425]; ?>"><?php echo $text[424]; ?></acronym>,&nbsp;<acronym title="<?php echo $text[433]; ?>"><?php echo $text[442]; ?></acronym></td>
                </tr>
                <tr>
                  <td width="20">&nbsp;</td>
                  <td align="right"><input class="lmo-formular-input" type="text" name="xlmo_main_fontfamily2" size="25" maxlength="50" value="<?php echo $lmo_main_fontfamily2; ?>" onChange="dolmoedit()"></td>
                  <td><acronym title="<?php echo $text[429]; ?>"><?php echo $text[428]; ?></acronym></td>
                </tr>
                <tr>
                  <td width="20">&nbsp;</td>
                  <td align="right"><input class="lmo-formular-input" type="text" name="xlmo_main_fontsize2" size="6" maxlength="6" value="<?php echo $lmo_main_fontsize2; ?>" onChange="dolmoedit()"></td>
                  <td><?php echo $text[430]; ?></td>
                </tr>
                <tr>
                  <th colspan="3"><?php echo $text[539]; ?> (<?php echo $text[536]; ?>)</th>
                </tr>
                <tr>
                  <td width="20">&nbsp;</td>
                  <td align="right">
                    <input class="lmo-formular-input" type="text" name="xlmo_main_background4" id="lmo_main_background4input" size="7" maxlength="7" value="<?php echo $lmo_main_background4; ?>" onChange="dolmoedit();relateColor('lmo_main_background4', this.value);"><script type="text/javascript">makePicker('lmo_main_background4');</script>&nbsp;
                    <input class="lmo-formular-input" type="text" name="xlmo_main_color4" id="lmo_main_color4input" size="7" maxlength="7" value="<?php echo $lmo_main_color4; ?>" onChange="dolmoedit();relateColor('lmo_main_color4', this.value);"><script type="text/javascript">makePicker('lmo_main_color4');</script>
                  </td>
                  <td><acronym title="<?php echo $text[425]; ?>"><?php echo $text[424]; ?></acronym>,&nbsp;<acronym title="<?php echo $text[433]; ?>"><?php echo $text[442]; ?></acronym></td>
                </tr>
                <tr>
                  <td width="20">&nbsp;</td>
                  <td align="right"><input class="lmo-formular-input" type="text" name="xlmo_main_border4" size="25" maxlength="25" value="<?php echo $lmo_main_border4; ?>" onChange="dolmoedit()"></td>
                  <td><acronym title="<?php echo $text[427]; ?>"><?php echo $text[426]; ?></acronym></td>
                </tr>
                <tr>
                  <th colspan="3"><?php echo $text[539]; ?> (<?php echo $text[541]; ?>)</th>
                </tr>
                <tr>
                  <td width="20">&nbsp;</td>
                  <td align="right">
                    <input class="lmo-formular-input" type="text" name="xlmo_main_background5" id="lmo_main_background5input" size="7" maxlength="7" value="<?php echo $lmo_main_background5; ?>" onChange="dolmoedit();relateColor('lmo_main_background5', this.value);"><script type="text/javascript">makePicker('lmo_main_background5');</script>&nbsp;
                    <input class="lmo-formular-input" type="text" name="xlmo_main_color5" id="lmo_main_color5input" size="7" maxlength="7" value="<?php echo $lmo_main_color5; ?>" onChange="dolmoedit();relateColor('lmo_main_color5', this.value);"><script type="text/javascript">makePicker('lmo_main_color5');</script>
                  </td>
                  <td><acronym title="<?php echo $text[425]; ?>"><?php echo $text[424]; ?></acronym>,&nbsp;<acronym title="<?php echo $text[433]; ?>"><?php echo $text[442]; ?></acronym></td>
                </tr>
                <tr>
                  <td width="20">&nbsp;</td>
                  <td align="right"><input class="lmo-formular-input" type="text" name="xlmo_main_border5" size="25" maxlength="25" value="<?php echo $lmo_main_border5; ?>" onChange="dolmoedit()"></td>
                  <td><acronym title="<?php echo $text[427]; ?>"><?php echo $text[426]; ?></acronym></td>
                </tr>
                <tr>
                  <th colspan="3"><?php echo $text[540]; ?> (<?php echo $text[536]; ?>)</th>
                </tr>
                <tr>
                  <td width="20">&nbsp;</td>
                  <td align="right">
                    <input class="lmo-formular-input" type="text" name="xlmo_main_background6" id="lmo_main_background6input" size="7" maxlength="7" value="<?php echo $lmo_main_background6; ?>" onChange="dolmoedit();relateColor('lmo_main_background6', this.value);"><script type="text/javascript">makePicker('lmo_main_background6');</script>&nbsp;
                    <input class="lmo-formular-input" type="text" name="xlmo_main_color6" id="lmo_main_color6input" size="7" maxlength="7" value="<?php echo $lmo_main_color6; ?>" onChange="dolmoedit();relateColor('lmo_main_color6', this.value);"><script type="text/javascript">makePicker('lmo_main_color6');</script>
                  </td>
                  <td><acronym title="<?php echo $text[425]; ?>"><?php echo $text[424]; ?></acronym>,&nbsp;<acronym title="<?php echo $text[433]; ?>"><?php echo $text[442]; ?></acronym></td>
                </tr>
                <tr>
                  <td width="20">&nbsp;</td>
                  <td align="right"><input class="lmo-formular-input" type="text" name="xlmo_main_border6" size="25" maxlength="25" value="<?php echo $lmo_main_border6; ?>" onChange="dolmoedit()"></td>
                  <td><acronym title="<?php echo $text[427]; ?>"><?php echo $text[426]; ?></acronym></td>
                </tr>
                <tr>
                  <th colspan="3"><?php echo $text[540]; ?> (<?php echo $text[541]; ?>)</th>
                </tr>
                <tr>
                  <td width="20">&nbsp;</td>
                  <td align="right">
                    <input class="lmo-formular-input" type="text" name="xlmo_main_background7" id="lmo_main_background7input" size="7" maxlength="7" value="<?php echo $lmo_main_background7; ?>" onChange="dolmoedit();relateColor('lmo_main_background7', this.value);"><script type="text/javascript">makePicker('lmo_main_background7');</script>&nbsp;
                    <input class="lmo-formular-input" type="text" name="xlmo_main_color7" id="lmo_main_color7input" size="7" maxlength="7" value="<?php echo $lmo_main_color7; ?>" onChange="dolmoedit();relateColor('lmo_main_color7', this.value);"><script type="text/javascript">makePicker('lmo_main_color7');</script>
                  </td>
                  <td><acronym title="<?php echo $text[425]; ?>"><?php echo $text[424]; ?></acronym>,&nbsp;<acronym title="<?php echo $text[433]; ?>"><?php echo $text[442]; ?></acronym></td>
                </tr>
                <tr>
                  <td width="20">&nbsp;</td>
                  <td align="right"><input class="lmo-formular-input" type="text" name="xlmo_main_border7" size="25" maxlength="25" value="<?php echo $lmo_main_border7; ?>" onChange="dolmoedit()"></td>
                  <td><acronym title="<?php echo $text[427]; ?>"><?php echo $text[426]; ?></acronym></td>
                </tr>
<?php
} elseif ($show == 1) {?>
                <tr>
                  <th colspan="3"><?php echo $text[536]; ?></th>
                </tr>
                <tr>
                  <td width="20">&nbsp;</td>
                  <td align="right">
                    <input class="lmo-formular-input" type="text" name="xlmo_middle_background1" id="lmo_middle_background1input" size="7" maxlength="7" value="<?php echo $lmo_middle_background1; ?>" onChange="dolmoedit();relateColor('lmo_middle_background1', this.value);"><script type="text/javascript">makePicker('lmo_middle_background1');</script>&nbsp;
                    <input class="lmo-formular-input" type="text" name="xlmo_middle_color1" id="lmo_middle_color1input" size="7" maxlength="7" value="<?php echo $lmo_middle_color1; ?>" onChange="dolmoedit();relateColor('lmo_middle_color1', this.value);"><script type="text/javascript">makePicker('lmo_middle_color1');</script>
                  </td>
                  <td><acronym title="<?php echo $text[425]; ?>"><?php echo $text[424]; ?></acronym>,&nbsp;<acronym title="<?php echo $text[433]; ?>"><?php echo $text[442]; ?></acronym></td>
                </tr>
                <tr>
                  <td width="20">&nbsp;</td>
                  <td align="right"><input class="lmo-formular-input" type="text" name="xlmo_middle_border1" size="25" maxlength="25" value="<?php echo $lmo_middle_border1; ?>" onChange="dolmoedit()"></td>
                  <td><acronym title="<?php echo $text[427]; ?>"><?php echo $text[426]; ?></acronym></td>
                </tr>
                <tr>
                  <td width="20">&nbsp;</td>
                  <td align="right"><input class="lmo-formular-input" type="text" name="xlmo_middle_fontfamily1" size="25" maxlength="50" value="<?php echo $lmo_middle_fontfamily1; ?>" onChange="dolmoedit()"></td>
                  <td><acronym title="<?php echo $text[429]; ?>"><?php echo $text[428]; ?></acronym></td>
                </tr>
                <tr>
                  <td width="20">&nbsp;</td>
                  <td align="right"><input class="lmo-formular-input" type="text" name="xlmo_middle_fontsize1" size="6" maxlength="6" value="<?php echo $lmo_middle_fontsize1; ?>" onChange="dolmoedit()"></td>
                  <td><?php echo $text[430]; ?></td>
                </tr>
                <tr>
                  <th colspan="3"><?php echo $text[537]; ?></th>
                </tr>
                <tr>
                  <td width="20">&nbsp;</td>
                  <td class="nobr" align="right">
                    <input class="lmo-formular-input" type="text" name="xlmo_middle_background2" id="lmo_middle_background2input" size="7" maxlength="7" value="<?php echo $lmo_middle_background2; ?>" onChange="dolmoedit();relateColor('lmo_middle_background2', this.value);"><script type="text/javascript">makePicker('lmo_middle_background2');</script>
                    <input class="lmo-formular-input" type="text" name="xlmo_middle_color2" id="lmo_middle_color2input" size="7" maxlength="7" value="<?php echo $lmo_middle_color2; ?>" onChange="dolmoedit();relateColor('lmo_middle_color2', this.value);"><script type="text/javascript">makePicker('lmo_middle_color2');</script>
                  </td>
                  <td><acronym title="<?php echo $text[425]; ?>"><?php echo $text[424]; ?></acronym>,&nbsp;<acronym title="<?php echo $text[433]; ?>"><?php echo $text[442]; ?></acronym></td>
                </tr>
                <tr>
                  <td width="20">&nbsp;</td>
                  <td align="right"><input class="lmo-formular-input" type="text" name="xlmo_middle_fontfamily2" size="25" maxlength="50" value="<?php echo $lmo_middle_fontfamily2; ?>" onChange="dolmoedit()"></td>
                  <td><acronym title="<?php echo $text[429]; ?>"><?php echo $text[428]; ?></acronym></td>
                </tr>
                <tr>
                  <td width="20">&nbsp;</td>
                  <td align="right"><input class="lmo-formular-input" type="text" name="xlmo_middle_fontsize2" size="6" maxlength="6" value="<?php echo $lmo_middle_fontsize2; ?>" onChange="dolmoedit()"></td>
                  <td><?php echo $text[430]; ?></td>
                </tr>
                <tr>
                  <th colspan="3"><?php echo $text[539]; ?> (<?php echo $text[536]; ?>)</th>
                </tr>
                <tr>
                  <td width="20">&nbsp;</td>
                  <td align="right">
                    <input class="lmo-formular-input" type="text" name="xlmo_middle_background4" id="lmo_middle_background4input" size="7" maxlength="7" value="<?php echo $lmo_middle_background4; ?>" onChange="dolmoedit();relateColor('lmo_middle_background4', this.value);"><script type="text/javascript">makePicker('lmo_middle_background4');</script>&nbsp;
                    <input class="lmo-formular-input" type="text" name="xlmo_middle_color4" id="lmo_middle_color4input" size="7" maxlength="7" value="<?php echo $lmo_middle_color4; ?>" onChange="dolmoedit();relateColor('lmo_middle_color4', this.value);"><script type="text/javascript">makePicker('lmo_middle_color4');</script>
                  </td>
                  <td><acronym title="<?php echo $text[425]; ?>"><?php echo $text[424]; ?></acronym>,&nbsp;<acronym title="<?php echo $text[433]; ?>"><?php echo $text[442]; ?></acronym></td>
                </tr>
                <tr>
                  <td width="20">&nbsp;</td>
                  <td align="right"><input class="lmo-formular-input" type="text" name="xlmo_middle_border4" size="25" maxlength="25" value="<?php echo $lmo_middle_border4; ?>" onChange="dolmoedit()"></td>
                  <td><acronym title="<?php echo $text[427]; ?>"><?php echo $text[426]; ?></acronym></td>
                </tr>
                <tr>
                  <th colspan="3"><?php echo $text[539]; ?> (<?php echo $text[541]; ?>)</th>
                </tr>
                <tr>
                  <td width="20">&nbsp;</td>
                  <td align="right">
                    <input class="lmo-formular-input" type="text" name="xlmo_middle_background5" id="lmo_middle_background5input" size="7" maxlength="7" value="<?php echo $lmo_middle_background5; ?>" onChange="dolmoedit();relateColor('lmo_middle_background5', this.value);"><script type="text/javascript">makePicker('lmo_middle_background5');</script>&nbsp;
                    <input class="lmo-formular-input" type="text" name="xlmo_middle_color5" id="lmo_middle_color5input" size="7" maxlength="7" value="<?php echo $lmo_middle_color5; ?>" onChange="dolmoedit();relateColor('lmo_middle_color5', this.value);"><script type="text/javascript">makePicker('lmo_middle_color5');</script>
                  </td>
                  <td><acronym title="<?php echo $text[425]; ?>"><?php echo $text[424]; ?></acronym>,&nbsp;<acronym title="<?php echo $text[433]; ?>"><?php echo $text[442]; ?></acronym></td>
                </tr>
                <tr>
                  <td width="20">&nbsp;</td>
                  <td align="right"><input class="lmo-formular-input" type="text" name="xlmo_middle_border5" size="25" maxlength="25" value="<?php echo $lmo_middle_border5; ?>" onChange="dolmoedit()"></td>
                  <td><acronym title="<?php echo $text[427]; ?>"><?php echo $text[426]; ?></acronym></td>
                </tr>
                <tr>
                  <th colspan="3"><?php echo $text[540]; ?> (<?php echo $text[536]; ?>)</th>
                </tr>
                <tr>
                  <td width="20">&nbsp;</td>
                  <td align="right">
                    <input class="lmo-formular-input" type="text" name="xlmo_middle_background6" id="lmo_middle_background6input" size="7" maxlength="7" value="<?php echo $lmo_middle_background6; ?>" onChange="dolmoedit();relateColor('lmo_middle_background6', this.value);"><script type="text/javascript">makePicker('lmo_middle_background6');</script>&nbsp;
                    <input class="lmo-formular-input" type="text" name="xlmo_middle_color6" id="lmo_middle_color6input" size="7" maxlength="7" value="<?php echo $lmo_middle_color6; ?>" onChange="dolmoedit();relateColor('lmo_middle_color6', this.value);"><script type="text/javascript">makePicker('lmo_middle_color6');</script>
                  </td>
                  <td><acronym title="<?php echo $text[425]; ?>"><?php echo $text[424]; ?></acronym>,&nbsp;<acronym title="<?php echo $text[433]; ?>"><?php echo $text[442]; ?></acronym></td>
                </tr>
                <tr>
                  <td width="20">&nbsp;</td>
                  <td align="right"><input class="lmo-formular-input" type="text" name="xlmo_middle_border6" size="25" maxlength="25" value="<?php echo $lmo_middle_border6; ?>" onChange="dolmoedit()"></td>
                  <td><acronym title="<?php echo $text[427]; ?>"><?php echo $text[426]; ?></acronym></td>
                </tr>
                <tr>
                  <th colspan="3"><?php echo $text[540]; ?> (<?php echo $text[541]; ?>)</th>
                </tr>
                <tr>
                  <td width="20">&nbsp;</td>
                  <td align="right">
                    <input class="lmo-formular-input" type="text" name="xlmo_middle_background7" id="lmo_middle_background7input" size="7" maxlength="7" value="<?php echo $lmo_middle_background7; ?>" onChange="dolmoedit();relateColor('lmo_middle_background7', this.value);"><script type="text/javascript">makePicker('lmo_middle_background7');</script>&nbsp;
                    <input class="lmo-formular-input" type="text" name="xlmo_middle_color7" id="lmo_middle_color7input" size="7" maxlength="7" value="<?php echo $lmo_middle_color7; ?>" onChange="dolmoedit();relateColor('lmo_middle_color7', this.value);"><script type="text/javascript">makePicker('lmo_middle_color7');</script>
                  </td>
                  <td><acronym title="<?php echo $text[425]; ?>"><?php echo $text[424]; ?></acronym>,&nbsp;<acronym title="<?php echo $text[433]; ?>"><?php echo $text[442]; ?></acronym></td>
                </tr>
                <tr>
                  <td width="20">&nbsp;</td>
                  <td align="right"><input class="lmo-formular-input" type="text" name="xlmo_middle_border7" size="25" maxlength="25" value="<?php echo $lmo_middle_border7; ?>" onChange="dolmoedit()"></td>
                  <td><acronym title="<?php echo $text[427]; ?>"><?php echo $text[426]; ?></acronym></td>
                </tr>
<?php
} elseif ($show == 2) {?>
                <tr>
                  <td width="20">&nbsp;</td>
                  <td class="nobr" align="right">
                    <input class="lmo-formular-input" type="text" name="xlmo_inner_background1" id="lmo_inner_background1input" size="7" maxlength="7" value="<?php echo $lmo_inner_background1; ?>" onChange="dolmoedit();relateColor('lmo_inner_background1', this.value);"><script type="text/javascript">makePicker('lmo_inner_background1');</script>&nbsp;
                    <input class="lmo-formular-input" type="text" name="xlmo_inner_color1" id="lmo_inner_color1input" size="7" maxlength="7" value="<?php echo $lmo_inner_color1; ?>" onChange="dolmoedit();relateColor('lmo_inner_color1', this.value);"><script type="text/javascript">makePicker('lmo_inner_color1');</script>
                  </td>
                  <td><acronym title="<?php echo $text[425]; ?>"><?php echo $text[424]; ?></acronym>,&nbsp;<acronym title="<?php echo $text[433]; ?>"><?php echo $text[442]; ?></acronym></td>
                </tr>
                <tr>
                  <td width="20">&nbsp;</td>
                  <td class="nobr" align="right">
                    <input class="lmo-formular-input" type="text" name="xlmo_inner_background2" id="lmo_inner_background2input" size="7" maxlength="7" value="<?php echo $lmo_inner_background2; ?>" onChange="dolmoedit();relateColor('lmo_inner_background2', this.value);"><script type="text/javascript">makePicker('lmo_inner_background2');</script>&nbsp;
                    <input class="lmo-formular-input" type="text" name="xlmo_inner_color2" id="lmo_inner_color2input" size="7" maxlength="7" value="<?php echo $lmo_inner_color2; ?>" onChange="dolmoedit();relateColor('lmo_inner_color2', this.value);"><script type="text/javascript">makePicker('lmo_inner_color2');</script>
                  </td>
                  <td>&nbsp;<acronym title="<?php echo $text[443]; ?>"><?php echo $text[503]; ?></acronym>: <acronym title="<?php echo $text[425]; ?>"><?php echo $text[424]; ?></acronym>,&nbsp;<acronym title="<?php echo $text[433]; ?>"><?php echo $text[442]; ?></acronym></td>
                </tr>
                <tr>
                  <td width="20">&nbsp;</td>
                  <td class="nobr" align="right">
                    <input class="lmo-formular-input" type="text" name="xlmo_inner_background3" id="lmo_inner_background3input" size="7" maxlength="7" value="<?php echo $lmo_inner_background3; ?>" onChange="dolmoedit();relateColor('lmo_inner_background3', this.value);"><script type="text/javascript">makePicker('lmo_inner_background3');</script>&nbsp;
                    <input class="lmo-formular-input" type="text" name="xlmo_inner_color3" id="lmo_inner_color3input" size="7" maxlength="7" value="<?php echo $lmo_inner_color3; ?>" onChange="dolmoedit();relateColor('lmo_inner_color3', this.value);"><script type="text/javascript">makePicker('lmo_inner_color3');</script>
                  </td>
                  <td>&nbsp;<acronym title="<?php echo $text[445]; ?>"><?php echo $text[541]; ?></acronym>: <acronym title="<?php echo $text[425]; ?>"><?php echo $text[424]; ?></acronym>,&nbsp;<acronym title="<?php echo $text[433]; ?>"><?php echo $text[442]; ?></acronym></td>
                </tr>
                <tr>
                  <td width="20">&nbsp;</td>
                  <td align="right"><input class="lmo-formular-input" type="text" name="xlmo_inner_border1" size="25" maxlength="25" value="<?php echo $lmo_inner_border1; ?>" onChange="dolmoedit()"></td>
                  <td><acronym title="<?php echo $text[427]; ?>"><?php echo $text[426]; ?></acronym></td>
                </tr>
                <tr>
                  <td width="20">&nbsp;</td>
                  <td align="right"><input class="lmo-formular-input" type="text" name="xlmo_inner_fontfamily1" size="25" maxlength="50" value="<?php echo $lmo_inner_fontfamily1; ?>" onChange="dolmoedit()"></td>
                  <td><acronym title="<?php echo $text[429]; ?>"><?php echo $text[428]; ?></acronym></td>
                </tr>
                <tr>
                  <td width="20">&nbsp;</td>
                  <td align="right"><input class="lmo-formular-input" type="text" name="xlmo_inner_fontsize1" size="6" maxlength="6" value="<?php echo $lmo_inner_fontsize1; ?>" onChange="dolmoedit()"></td>
                  <td><acronym title="<?php echo $text[438]; ?>"><?php echo $text[437]; ?></acronym></td>
                </tr>
<?php
} elseif ($show == 3) {?>
                <tr>
                  <td width="20">&nbsp;</td>
                  <td class="nobr" align="right">
                    <input class="lmo-formular-input" type="text" name="xlmo_tabelle_background1" id="lmo_tabelle_background1input" size="7" maxlength="7" value="<?php echo $lmo_tabelle_background1; ?>" onChange="dolmoedit();relateColor('lmo_tabelle_background1', this.value);"><script type="text/javascript">makePicker('lmo_tabelle_background1');</script>
                    <input class="lmo-formular-input" type="text" name="xlmo_tabelle_color1" id="lmo_tabelle_color1input" size="7" maxlength="7" value="<?php echo $lmo_tabelle_color1; ?>" onChange="dolmoedit();relateColor('lmo_tabelle_color1', this.value);"><script type="text/javascript">makePicker('lmo_tabelle_color1');</script>
                  </td>
                  <td><acronym title="<?php echo $text[425]; ?>"><?php echo $text[451]; ?></acronym></td>
                </tr>
                <tr>
                  <td width="20">&nbsp;</td>
                  <td class="nobr" align="right">
                    <input class="lmo-formular-input" type="text" name="xlmo_tabelle_background2" id="lmo_tabelle_background2input" size="7" maxlength="7" value="<?php echo $lmo_tabelle_background2; ?>" onChange="dolmoedit();relateColor('lmo_tabelle_background2', this.value);"><script type="text/javascript">makePicker('lmo_tabelle_background2');</script>
                    <input class="lmo-formular-input" type="text" name="xlmo_tabelle_color2" id="lmo_tabelle_color2input" size="7" maxlength="7" value="<?php echo $lmo_tabelle_color2; ?>" onChange="dolmoedit();relateColor('lmo_tabelle_color2', this.value);"><script type="text/javascript">makePicker('lmo_tabelle_color2');</script>
                  </td>
                  <td><acronym title="<?php echo $text[425]; ?>"><?php echo $text[452]; ?></acronym></td>
                </tr>
                <tr>
                  <td width="20">&nbsp;</td>
                  <td class="nobr" align="right">
                    <input class="lmo-formular-input" type="text" name="xlmo_tabelle_background3" id="lmo_tabelle_background3input" size="7" maxlength="7" value="<?php echo $lmo_tabelle_background3; ?>" onChange="dolmoedit();relateColor('lmo_tabelle_background3', this.value);"><script type="text/javascript">makePicker('lmo_tabelle_background3');</script>
                    <input class="lmo-formular-input" type="text" name="xlmo_tabelle_color3" id="lmo_tabelle_color3input" size="7" maxlength="7" value="<?php echo $lmo_tabelle_color3; ?>" onChange="dolmoedit();relateColor('lmo_tabelle_color3', this.value);"><script type="text/javascript">makePicker('lmo_tabelle_color3');</script>
                  </td>
                  <td><acronym title="<?php echo $text[425]; ?>"><?php echo $text[453]; ?></acronym></td>
                </tr>
                <tr>
                  <td width="20">&nbsp;</td>
                  <td class="nobr" align="right">
                    <input class="lmo-formular-input" type="text" name="xlmo_tabelle_background4" id="lmo_tabelle_background4input" size="7" maxlength="7" value="<?php echo $lmo_tabelle_background4; ?>" onChange="dolmoedit();relateColor('lmo_tabelle_background4', this.value);"><script type="text/javascript">makePicker('lmo_tabelle_background4');</script>
                    <input class="lmo-formular-input" type="text" name="xlmo_tabelle_color4" id="lmo_tabelle_color4input" size="7" maxlength="7" value="<?php echo $lmo_tabelle_color4; ?>" onChange="dolmoedit();relateColor('lmo_tabelle_color4', this.value);"><script type="text/javascript">makePicker('lmo_tabelle_color4');</script>
                  </td>
                  <td><acronym title="<?php echo $text[425]; ?>"><?php echo $text[454]; ?></acronym></td>
                </tr>
                <tr>
                  <td width="20">&nbsp;</td>
                  <td class="nobr" align="right">
                    <input class="lmo-formular-input" type="text" name="xlmo_tabelle_background5" id="lmo_tabelle_background5input" size="7" maxlength="7" value="<?php echo $lmo_tabelle_background5; ?>" onChange="dolmoedit();relateColor('lmo_tabelle_background5', this.value);"><script type="text/javascript">makePicker('lmo_tabelle_background5');</script>
                    <input class="lmo-formular-input" type="text" name="xlmo_tabelle_color5" id="lmo_tabelle_color5input" size="7" maxlength="7" value="<?php echo $lmo_tabelle_color5; ?>" onChange="dolmoedit();relateColor('lmo_tabelle_color5', this.value);"><script type="text/javascript">makePicker('lmo_tabelle_color5');</script>
                  </td>
                  <td><acronym title="<?php echo $text[425]; ?>"><?php echo $text[455]; ?></acronym></td>
                </tr>
                <tr>
                  <td width="20">&nbsp;</td>
                  <td class="nobr" align="right">
                    <input class="lmo-formular-input" type="text" name="xlmo_tabelle_background6" id="lmo_tabelle_background6input" size="7" maxlength="7" value="<?php echo $lmo_tabelle_background6; ?>" onChange="dolmoedit();relateColor('lmo_tabelle_background6', this.value);"><script type="text/javascript">makePicker('lmo_tabelle_background6');</script>
                    <input class="lmo-formular-input" type="text" name="xlmo_tabelle_color6" id="lmo_tabelle_color6input" size="7" maxlength="7" value="<?php echo $lmo_tabelle_color6; ?>" onChange="dolmoedit();relateColor('lmo_tabelle_color6', this.value);"><script type="text/javascript">makePicker('lmo_tabelle_color6');</script>
                  </td>
                  <td><acronym title="<?php echo $text[425]; ?>"><?php echo $text[456]; ?></acronym></td>
                </tr>
                <tr>
                  <td width="20">&nbsp;</td>
                  <td class="nobr" align="right">
                    <input class="lmo-formular-input" type="text" name="xlmo_tabelle_background7" id="lmo_tabelle_background7input" size="7" maxlength="7" value="<?php echo $lmo_tabelle_background7; ?>" onChange="dolmoedit();relateColor('lmo_tabelle_background7', this.value);"><script type="text/javascript">makePicker('lmo_tabelle_background7');</script>
                    <input class="lmo-formular-input" type="text" name="xlmo_tabelle_color7" id="lmo_tabelle_color7input" size="7" maxlength="7" value="<?php echo $lmo_tabelle_color7; ?>" onChange="dolmoedit();relateColor('lmo_tabelle_color7', this.value);"><script type="text/javascript">makePicker('lmo_tabelle_color7');</script>
                  </td>
                  <td><acronym title="<?php echo $text[425]; ?>"><?php echo $text[457]; ?></acronym></td>
                </tr>
                <tr>
                  <td width="20">&nbsp;</td>
                  <td class="nobr" align="right">
                    <input class="lmo-formular-input" type="text" name="xlmo_tabelle_background8" id="lmo_tabelle_background8input" size="7" maxlength="7" value="<?php echo $lmo_tabelle_background8; ?>" onChange="dolmoedit();relateColor('lmo_tabelle_background8', this.value);"><script type="text/javascript">makePicker('lmo_tabelle_background8');</script>
                    <input class="lmo-formular-input" type="text" name="xlmo_tabelle_color8" id="lmo_tabelle_color8input" size="7" maxlength="7" value="<?php echo $lmo_tabelle_color8; ?>" onChange="dolmoedit();relateColor('lmo_tabelle_color8', this.value);"><script type="text/javascript">makePicker('lmo_tabelle_color8');</script>
                  </td>
                  <td><acronym title="<?php echo $text[425]; ?>"><?php echo $text[458]; ?></acronym></td>
                </tr>
<?php
} elseif ($show == 4) {?>
                <tr>
                  <td width="20">&nbsp;</td>
                  <td class="nobr" align="right">
                    <input class="lmo-formular-input" type="text" name="xlmo_turnier_background1" id="lmo_turnier_background1input" size="7" maxlength="7" value="<?php echo $lmo_turnier_background1; ?>" onChange="dolmoedit();relateColor('lmo_turnier_background1', this.value);"><script type="text/javascript">makePicker('lmo_turnier_background1');</script>
                    <input class="lmo-formular-input" type="text" name="xlmo_turnier_color1" id="lmo_turnier_color1input" size="7" maxlength="7" value="<?php echo $lmo_turnier_color1; ?>" onChange="dolmoedit();relateColor('lmo_turnier_color1', this.value);"><script type="text/javascript">makePicker('lmo_turnier_color1');</script>
                  </td>
                  <td><acronym title="<?php echo $text[425]; ?>"><?php echo $text[460]; ?></acronym></td>
                </tr>
                <tr>
                  <td width="20">&nbsp;</td>
                  <td class="nobr" align="right">
                    <input class="lmo-formular-input" type="text" name="xlmo_turnier_background2" id="lmo_turnier_background2input" size="7" maxlength="7" value="<?php echo $lmo_turnier_background2; ?>" onChange="dolmoedit();relateColor('lmo_turnier_background2', this.value);"><script type="text/javascript">makePicker('lmo_turnier_background2');</script>
                    <input class="lmo-formular-input" type="text" name="xlmo_turnier_color2" id="lmo_turnier_color2input" size="7" maxlength="7" value="<?php echo $lmo_turnier_color2; ?>" onChange="dolmoedit();relateColor('lmo_turnier_color2', this.value);"><script type="text/javascript">makePicker('lmo_turnier_color2');</script>
                  </td>
                  <td><acronym title="<?php echo $text[425]; ?>"><?php echo $text[461]; ?></acronym></td>
                </tr>
<?php
} elseif ($show == 5) {?>
                <tr>
                  <td width="20">&nbsp;</td>
                  <td align="right"><input class="lmo-formular-input" type="text" name="xlmo_kreuzkal_background1" id="lmo_kreuzkal_background1input" size="7" maxlength="7" value="<?php echo $lmo_kreuzkal_background1; ?>" onChange="dolmoedit();relateColor('lmo_kreuzkal_background1', this.value);"><script type="text/javascript">makePicker('lmo_kreuzkal_background1');</script></td>
                  <td><?php echo $text[503]; ?>: <acronym title="<?php echo $text[425]; ?>"><?php echo $text[424]; ?></acronym></td>
                </tr>
                <tr>
                  <td width="20">&nbsp;</td>
                  <td align="right">
                    <input class="lmo-formular-input" type="text" name="xlmo_kreuzkal_background2" id="lmo_kreuzkal_background2input" size="7" maxlength="7" value="<?php echo $lmo_kreuzkal_background2; ?>" onChange="dolmoedit();relateColor('lmo_kreuzkal_background2', this.value);"><script type="text/javascript">makePicker('lmo_kreuzkal_background2');</script>
                  </td>
                  <td><?php echo $text[463]; ?>: <acronym title="<?php echo $text[425]; ?>"><?php echo $text[424]; ?></acronym></td>
                </tr>
                <tr>
                  <th colspan="3"><?php echo $text[133]; ?></th>
                </tr>
                <tr>
                  <td width="20">&nbsp;</td>
                  <td align="right"><input class="lmo-formular-input" type="text" name="xlmo_fieber_color1" id="lmo_fieber_color1input" size="7" maxlength="7" value="<?php echo $lmo_fieber_color1; ?>" onChange="dolmoedit();relateColor('lmo_fieber_color1', this.value);"><script type="text/javascript">makePicker('lmo_fieber_color1');</script></td>
                  <td><acronym title="<?php echo $text[433]; ?>"><?php echo $text[281]; ?> 1</acronym></td>
                </tr>
                <tr>
                  <td width="20">&nbsp;</td>
                  <td align="right">
                    <input class="lmo-formular-input" type="text" name="xlmo_fieber_color2" id="lmo_fieber_color2input" size="7" maxlength="7" value="<?php echo $lmo_fieber_color2; ?>" onChange="dolmoedit();relateColor('lmo_fieber_color2', this.value);"><script type="text/javascript">makePicker('lmo_fieber_color2');</script>
                  </td>
                  <td><acronym title="<?php echo $text[433]; ?>"><?php echo $text[281]; ?> 2</acronym></td>
                </tr>
                <tr>
                  <th colspan="3"><?php echo $text[464]; ?></th>
                </tr>
                <tr>
                  <td width="20">&nbsp;</td>
                  <td align="right"><input class="lmo-formular-input" type="text" name="xlmo_kreuzkal_color1" id="lmo_kreuzkal_color1input" size="7" maxlength="7" value="<?php echo $lmo_kreuzkal_color1; ?>" onChange="dolmoedit();relateColor('lmo_kreuzkal_color1', this.value);"><script type="text/javascript">makePicker('lmo_kreuzkal_color1');</script></td>
                  <td><acronym title="<?php echo $text[433]; ?>"><?php echo $text[466]; ?></acronym></td>
                </tr>
                <tr>
                  <th colspan="3"><?php echo $text[14]; ?></th>
                </tr>
                <tr>
                  <td width="20">&nbsp;</td>
                  <td align="right"><input class="lmo-formular-input" type="text" name="xlmo_kreuz_fontsize1" size="6" maxlength="6" value="<?php echo $lmo_kreuz_fontsize1; ?>" onChange="dolmoedit()"></td>
                  <td><acronym title="<?php echo $text[438]; ?>"><?php echo $text[437]; ?></acronym></td>
                </tr>
                <tr>
                  <th colspan="3"><?php echo $text[538]; ?></th>
                </tr>
                <tr>
                  <td width="20">&nbsp;</td>
                  <td align="right"><input class="lmo-formular-input" type="text" name="xlmo_footer_fontsize1" size="6" maxlength="6" value="<?php echo $lmo_footer_fontsize1; ?>" onChange="dolmoedit()"></td>
                  <td><acronym title="<?php echo $text[435]; ?>"><?php echo $text[430]; ?></acronym></td>
                </tr>
                <tr>
                  <th colspan="3"><?php echo $text[563]; ?></th>
                </tr>
                <tr>
                  <td width="20">&nbsp;</td>
                  <td align="right"><input class="lmo-formular-input" type="checkbox" name="xlmo_main_underline1"<?php if ($lmo_main_underline1=='underline') echo ' checked';?> onClick="dolmoedit()"></td>
                  <td><?php echo $text[423]; ?></td>
                </tr>
                <tr>
                  <td width="20">&nbsp;</td>
                  <td align="right"><input class="lmo-formular-input" type="checkbox" name="xlmo_middle_underline1"<?php if ($lmo_middle_underline1=='underline') echo ' checked';?> onClick="dolmoedit()"></td>
                  <td><?php echo $text[436]; ?></td>
                </tr>
                <tr>
                  <td width="20">&nbsp;</td>
                  <td align="right"><input class="lmo-formular-input" type="checkbox" name="xlmo_inner_underline1"<?php if ($lmo_inner_underline1=='underline') echo ' checked';?> onClick="dolmoedit()"></td>
                  <td><?php echo $text[441]; ?></td>
                </tr>
<?php
} elseif ($show == 6) {?>
                <tr>
                  <td width="20">&nbsp;</td>
                  <td class="nobr" align="right">
                    <input class="lmo-formular-input" type="text" name="xlmo_formular_background1" id="lmo_formular_background1input" size="7" maxlength="7" value="<?php echo $lmo_formular_background1; ?>" onChange="dolmoedit();relateColor('lmo_formular_background1', this.value);"><script type="text/javascript">makePicker('lmo_formular_background1');</script>&nbsp;
                    <input class="lmo-formular-input" type="text" name="xlmo_formular_color1" id="lmo_formular_color1input" size="7" maxlength="7" value="<?php echo $lmo_formular_color1; ?>" onChange="dolmoedit();relateColor('lmo_formular_color1', this.value);"><script type="text/javascript">makePicker('lmo_formular_color1');</script>
                  </td>
                  <td><?php echo $text[448]; ?>: <acronym title="<?php echo $text[425]; ?>"><?php echo $text[424]; ?></acronym>,&nbsp;<acronym title="<?php echo $text[433]; ?>"><?php echo $text[442]; ?></acronym></td>
                </tr>
                <tr>
                  <td width="20">&nbsp;</td>
                  <td align="right">
                    <input class="lmo-formular-input" type="text" name="xlmo_formular_border1" size="25" maxlength="25" value="<?php echo $lmo_formular_border1; ?>" onChange="dolmoedit();">
                  </td>
                  <td><?php echo $text[448]; ?>: <acronym title="<?php echo $text[427]; ?>"><?php echo $text[426]; ?></acronym></td>
                </tr>
                <tr>
                  <td width="20">&nbsp;</td>
                  <td class="nobr" align="right">
                    <input class="lmo-formular-input" type="text" name="xlmo_formular_background2" id="lmo_formular_background2input" size="7" maxlength="7" value="<?php echo $lmo_formular_background2; ?>" onChange="dolmoedit();relateColor('lmo_formular_background2', this.value);"><script type="text/javascript">makePicker('lmo_formular_background2');</script>&nbsp;
                    <input class="lmo-formular-input" type="text" name="xlmo_formular_color2" id="lmo_formular_color2input" size="7" maxlength="7" value="<?php echo $lmo_formular_color2; ?>" onChange="dolmoedit();relateColor('lmo_formular_color2', this.value);"><script type="text/javascript">makePicker('lmo_formular_color2');</script>
                  </td>
                  <td><?php echo $text[449]; ?>: <acronym title="<?php echo $text[425]; ?>"><?php echo $text[424]; ?></acronym>,&nbsp;<acronym title="<?php echo $text[433]; ?>"><?php echo $text[442]; ?></acronym></td>
                </tr>
                <tr>
                  <td width="20">&nbsp;</td>
                  <td align="right">
                    <input class="lmo-formular-input" type="text" name="xlmo_formular_border2" size="25" maxlength="25" value="<?php echo $lmo_formular_border2; ?>" onChange="dolmoedit();">
                  </td>
                  <td><?php echo $text[449]; ?>: <acronym title="<?php echo $text[427]; ?>"><?php echo $text[426]; ?></acronym></td>
                </tr>
<?php
}?>
                <tr>
                  <td colspan="3" align="center">
                    <input title="<?php echo $text[114]; ?>" class="lmo-formular-button" type="submit" name="best" value="<?php echo $text[188]; ?>">
                  </td>
                </tr>
              </table>
            </form>
          </td>
        </tr>
      </table>