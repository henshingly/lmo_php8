<?php
/** Liga Manager Online 4
  *
  * https://www.liga-manager-online.org/lmo/
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
require_once(PATH_TO_LMO . '/lmo-designlib.php');

// Texte des Designeditors: lang/design/lang-<Sprache>.txt wird vom Kern nach $text['design'] geladen.
// Fehlt die Datei der Sprache oder einzelne Schlüssel, werden sie mit der englischen Fassung aufgefüllt.
$de_en = array();
read_langfile($de_en, PATH_TO_LANGDIR . '/design/lang-English.txt');
foreach ($de_en as $de_k => $de_v) {
    if (!isset($text['design'][$de_k]) || $text['design'][$de_k] === '') {
        $text['design'][$de_k] = $de_v;
    }
}
unset($de_en, $de_k, $de_v);
$show = isset($_REQUEST['show']) ? (int)$_REQUEST['show'] : 0;
$groups = lmo_design_groups();
$gkeys = array_keys($groups);
if ($show < 0 || $show >= count($gkeys)) {
    $show = 0;
}

if (isset($_POST['save']) && $_POST['save'] == 1) {
    // alle Reiter stehen in einem Formular; ungültige Werte werden ignoriert (siehe lmo-designlib.php)
    lmo_design_apply($_POST, 'xlmo_');
    require(PATH_TO_LMO . '/lmo-savecfg.php');
}

if (empty($_SESSION['lmo_de_token'])) {
    $_SESSION['lmo_de_token'] = bin2hex(random_bytes(16));
}

// Daten für das JavaScript des Editors
$de_values = array();
foreach (lmo_design_keys() as $k) {
    $de_values[$k] = ${'lmo_' . $k};
}
$de_hot = array();
foreach (lmo_design_hotspots() as $h) {
    $de_hot[] = array('sel' => $h[0], 'group' => $h[1], 'field' => $h[2], 'label' => $h[3]);
}
$de_cfg = array(
    'groups'   => $gkeys,
    'defaults' => lmo_design_defaults(),
    'hotspots' => $de_hot,
    'css'      => 'lmo-designcss.php',
    'store'    => 'lmo-designstore.php',
    'token'    => $_SESSION['lmo_de_token'],
    'msg'      => array(
        'export_bad'   => $text['design'][13],
        'imported'     => $text['design'][14],
        'defaults'     => $text['design'][15],
        'confirm_def'  => $text['design'][18],
        'confirm_disc' => $text['design'][19],
        'css_error'    => $text['design'][20],
        'loading'      => $text['design'][7],
        'ready'        => '',
        'scheme_done'  => $text['design'][29],
        'contrast'     => $text['design'][40],
        'ask_name'     => $text['design'][45],
        'saved'        => $text['design'][46],
        'loaded'       => $text['design'][47],
        'deleted'      => $text['design'][48],
        'overwrite'    => $text['design'][49],
        'confirm_del'  => $text['design'][50],
        'store_fail'   => $text['design'][51],
        'bad_name'     => $text['design'][55],
        'none'         => $text['design'][56],
    ),
    'schemes'  => array(
        array('id' => 'std',     'name' => $text['design'][30], 'color' => '#000099'),
        array('id' => 'green',   'name' => $text['design'][31], 'color' => '#1b6b2f'),
        array('id' => 'red',     'name' => $text['design'][32], 'color' => '#a01020'),
        array('id' => 'blue',    'name' => $text['design'][33], 'color' => '#0b5fa5'),
        array('id' => 'orange',  'name' => $text['design'][34], 'color' => '#c25b00'),
        array('id' => 'grey',    'name' => $text['design'][35], 'color' => '#333333'),
        array('id' => 'purple',  'name' => $text['design'][36], 'color' => '#5b2a86'),
        array('id' => 'teal',    'name' => $text['design'][37], 'color' => '#007c80'),
        array('id' => 'wine',    'name' => $text['design'][38], 'color' => '#6d1030'),
    ),
);
$de_leagues = lmo_design_leagues();
$de_views = array('table' => $text[16], 'results' => $text[10], 'program' => $text[12], 'cross' => $text[14], 'cal' => $text[140]);
$de_self = $_SERVER['PHP_SELF'] . '?action=admin&amp;todo=design&amp;show=';
?>
      <style type="text/css">
        .lmo-de { display: flex; gap: 14px; align-items: flex-start; text-align: left; }
        .lmo-de-form { flex: 0 0 470px; max-width: 470px; }
        .lmo-de-preview { flex: 1 1 560px; min-width: 460px; position: sticky; top: 6px; }
        .lmo-de-schemes { margin: 0 0 8px 0; display: flex; flex-wrap: wrap; gap: 6px; align-items: center; }
        .lmo-de-pop { position: relative; }
        .lmo-de-palette { position: absolute; z-index: 50; top: 100%; left: 0; margin-top: 4px; padding: 8px; background: #fff; color: #000; border: 1px solid #666; box-shadow: 0 3px 10px rgba(0,0,0,.35); width: 262px; }
        .lmo-de-palette[hidden] { display: none; }
        #lmo-de-swatches { display: grid; grid-template-columns: repeat(12, 1fr); gap: 2px; }
        #lmo-de-swatches button { height: 18px; padding: 0; border: 1px solid rgba(0,0,0,.25); cursor: pointer; }
        #lmo-de-swatches button:hover, #lmo-de-swatches button.lmo-de-on { outline: 2px solid #f60; outline-offset: 1px; }
        .lmo-de-palrow { display: flex; gap: 6px; align-items: center; margin-top: 8px; }
        .lmo-de-chip { width: 28px; height: 22px; padding: 0; border: 2px solid #888; cursor: pointer; }
        .lmo-de-chip.lmo-de-on { border-color: #f60; }
        .lmo-de-tabs { margin: 0 0 6px 0; display: flex; flex-wrap: wrap; gap: 3px; }
        .lmo-de-tabs a { padding: 3px 8px; border: 1px solid currentColor; text-decoration: none; white-space: nowrap; }
        .lmo-de-tabs a.lmo-de-on { font-weight: bold; text-decoration: underline; }
        .lmo-de-group { display: none; }
        .lmo-de-group.lmo-de-on { display: block; }
        .lmo-de-group table { width: 100%; }
        .lmo-de-group td, .lmo-de-group th { padding: 2px 4px; }
        .lmo-de-color { display: inline-flex; align-items: center; gap: 2px; }
        .lmo-de-pick { width: 26px; height: 22px; padding: 0; border: 1px solid #888; background: none; cursor: pointer; vertical-align: middle; }
        .lmo-de-pick.lmo-de-empty { opacity: .35; }
        .lmo-de-flash td { outline: 2px solid #f60; outline-offset: -2px; }
        .lmo-de-bar { margin: 8px 0 0 0; display: flex; flex-wrap: wrap; gap: 6px; align-items: center; }
        .lmo-de-msg { min-height: 1.3em; margin: 4px 0; font-size: 90%; }
        .lmo-de-tool { display: flex; flex-wrap: wrap; gap: 8px; align-items: center; margin: 0 0 6px 0; }
        .lmo-de-tool select { max-width: 260px; }
        .lmo-de-tabs a.lmo-de-warntab::after { content: " \26A0"; color: #d60; }
        .lmo-de-lowc td:last-child::after { content: " \26A0"; color: #d60; }
        .lmo-de-frame { margin: 0 auto; width: 100%; height: 76vh; min-height: 520px; border: 1px solid #888; background: #fff; display: block; }
        .lmo-de-hint { font-size: 90%; opacity: .85; margin: 4px 0 0 0; }
        @media (max-width: 1180px) {
          .lmo-de { flex-direction: column; }
          .lmo-de-form { flex: 1 1 auto; max-width: none; width: 100%; }
          .lmo-de-preview { position: static; width: 100%; min-width: 0; }
        }
      </style>
      <script type="text/javascript">window.LMO_DESIGN = <?php echo json_encode($de_cfg, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT); ?>;</script>
      <script src="<?php echo URL_TO_JSDIR; ?>/designeditor.js" type="text/javascript"></script>
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
          <td align="center"><h1><?php echo $text[432]; ?></h1></td>
        </tr>
        <tr>
          <td align="left" valign="top">
            <div class="lmo-de">
              <div class="lmo-de-form">
                <div class="lmo-de-schemes" id="lmo-de-schemes">
                  <strong><?php echo $text['design'][25]; ?></strong>
                  <span id="lmo-de-chips"></span>
                  <label title="<?php echo $text['design'][27]; ?>"><input type="checkbox" id="lmo-de-dark"> <?php echo $text['design'][26]; ?></label>
                  <span class="lmo-de-pop">
                    <input class="lmo-formular-button" type="button" id="lmo-de-custombtn" value="<?php echo $text['design'][39]; ?> &#9662;" title="<?php echo $text['design'][28]; ?>">
                    <input class="lmo-formular-input" type="text" id="lmo-de-hex" size="8" maxlength="7" placeholder="#rrggbb" title="<?php echo $text['design'][59]; ?>">
                    <div class="lmo-de-palette" id="lmo-de-palette" hidden>
                      <div id="lmo-de-swatches"></div>
                      <div class="lmo-de-palrow">
                        <input type="color" id="lmo-de-custom" value="#000099" class="lmo-de-pick" title="<?php echo $text['design'][58]; ?>">
                      </div>
                    </div>
                  </span>
                </div>
                <div class="lmo-de-tabs">
<?php
foreach ($gkeys as $i => $gk) { ?>
                  <a href="<?php echo $de_self . $i; ?>" data-group="<?php echo $gk; ?>"<?php if ($i == $show) echo ' class="lmo-de-on"'; ?>><?php echo $groups[$gk]['title']; ?></a>
<?php 
} ?>
                </div>
                <form name="lmoedit" id="lmo-de-form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" onSubmit="return chklmopass()">
                  <input type="hidden" name="action" value="admin">
                  <input type="hidden" name="todo" value="design">
                  <input type="hidden" name="save" value="1">
                  <input type="hidden" name="show" id="lmo-de-show" value="<?php echo $show; ?>">
<?php
foreach ($gkeys as $i => $gk) { ?>
                  <div class="lmo-de-group<?php if ($i == $show) echo ' lmo-de-on'; ?>" data-group="<?php echo $gk; ?>">
                    <table class="lmoInner" cellspacing="0" cellpadding="0" border="0">
<?php
    foreach ($groups[$gk]['rows'] as $row) {
        if ($row[0] == 'h') { ?>
                      <tr>
                        <th colspan="3"><?php echo $row[1]; ?></th>
                      </tr>
<?php
        } elseif ($row[0] == 'c') { ?>
                      <tr id="de-row-<?php echo $row[1][0]; ?>">
                        <td width="20">&nbsp;</td>
                        <td class="nobr" align="right">
<?php
            foreach ($row[1] as $k) { ?>
                          <span class="lmo-de-color"><input class="lmo-formular-input" type="text" name="xlmo_<?php echo $k; ?>" id="de_<?php echo $k; ?>" size="7" maxlength="9" value="<?php echo htmlspecialchars(${'lmo_' . $k}); ?>" onChange="dolmoedit();"><input class="lmo-de-pick" type="color" data-for="de_<?php echo $k; ?>" tabindex="-1" value="#000000"></span>
<?php
            } ?>
                        </td>
                        <td><?php echo $row[2]; ?></td>
                      </tr>
<?php
        } elseif ($row[0] == 't') { ?>
                      <tr id="de-row-<?php echo $row[1]; ?>">
                        <td width="20">&nbsp;</td>
                        <td align="right"><input class="lmo-formular-input" type="text" name="xlmo_<?php echo $row[1]; ?>" id="de_<?php echo $row[1]; ?>" size="<?php echo $row[3]; ?>" maxlength="<?php echo $row[2]; ?>" value="<?php echo htmlspecialchars(${'lmo_' . $row[1]}); ?>" onChange="dolmoedit();"></td>
                        <td><?php echo $row[4]; ?></td>
                      </tr>
<?php
        } elseif ($row[0] == 'f') { ?>
                      <tr id="de-row-<?php echo $row[1]; ?>">
                        <td width="20">&nbsp;</td>
                        <td align="right"><input class="lmo-formular-input" type="checkbox" name="xlmo_<?php echo $row[1]; ?>" id="de_<?php echo $row[1]; ?>"<?php if (${'lmo_' . $row[1]} == 'underline') echo ' checked'; ?> onClick="dolmoedit();"></td>
                        <td><?php echo $row[2]; ?></td>
                      </tr>
<?php
        }
    } ?>
                    </table>
                  </div>
<?php
} ?>
                  <div class="lmo-de-msg" id="lmo-de-msg" aria-live="polite"></div>
                  <div class="lmo-de-bar">
                    <input title="<?php echo $text[114]; ?>" class="lmo-formular-button" type="submit" name="best" value="<?php echo $text[188]; ?>">
                    <input class="lmo-formular-button" type="button" id="lmo-de-discard" value="<?php echo $text['design'][10]; ?>" title="<?php echo $text['design'][11]; ?>">
                    <input class="lmo-formular-button" type="button" id="lmo-de-default" value="<?php echo $text['design'][12]; ?>" title="<?php echo $text['design'][16]; ?>">
                    <input class="lmo-formular-button" type="button" id="lmo-de-export" value="<?php echo $text['design'][21]; ?>" title="<?php echo $text['design'][22]; ?>">
                    <input class="lmo-formular-button" type="button" id="lmo-de-import" value="<?php echo $text['design'][23]; ?>" title="<?php echo $text['design'][24]; ?>">
                    <input type="file" id="lmo-de-file" accept=".json,application/json" style="display:none">
                  </div>
                  <div class="lmo-de-bar">
                    <label><?php echo $text['design'][41]; ?>
                      <select id="lmo-de-saved"></select>
                    </label>
                    <input class="lmo-formular-button" type="button" id="lmo-de-load" value="<?php echo $text['design'][42]; ?>">
                    <input class="lmo-formular-button" type="button" id="lmo-de-savenew" value="<?php echo $text['design'][43]; ?>">
                    <input class="lmo-formular-button" type="button" id="lmo-de-del" value="<?php echo $text['design'][44]; ?>">
                  </div>
                </form>
              </div>
              <div class="lmo-de-preview">
                <div class="lmo-de-tool">
                  <strong><?php echo $text['design'][0]; ?></strong>
<?php
if (count($de_leagues) > 0) { ?>
                  <label><?php echo $text['design'][1]; ?>
                    <select id="lmo-de-league">
<?php
    foreach ($de_leagues as $rel => $name) { ?>
                      <option value="<?php echo htmlspecialchars($rel); ?>"><?php echo htmlspecialchars($name); ?></option>
<?php
    } ?>
                    </select>
                  </label>
                  <label><?php echo $text['design'][2]; ?>
                    <select id="lmo-de-view">
<?php
    foreach ($de_views as $v => $name) { ?>
                      <option value="<?php echo $v; ?>"><?php echo $name; ?></option>
<?php
    } ?>
                    </select>
                  </label>
                  <label><?php echo $text['design'][52]; ?>
                    <select id="lmo-de-width">
                      <option value="100%"><?php echo $text['design'][53]; ?></option>
                      <option value="768px"><?php echo $text['design'][54]; ?></option>
                      <option value="390px"><?php echo $text['design'][57]; ?></option>
                    </select>
                  </label>
<?php
} ?>
                </div>
<?php
if (count($de_leagues) > 0) { ?>
                <iframe class="lmo-de-frame" id="lmo-de-frame" title="<?php echo $text['design'][0]; ?>" src="about:blank"></iframe>
                <p class="lmo-de-hint"><?php echo $text['design'][8]; ?></p>
<?php
} else { ?>
                <p><?php echo $text['design'][17]; ?></p>
<?php
} ?>
              </div>
            </div>
          </td>
        </tr>
      </table>
