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
  * Gemeinsame Funktionen des Designeditors (lmo-admindesign.php) und der Live-Vorschau (lmo-designcss.php): Feldliste,
  * Standardwerte, Prüfung der Eingaben, Sprachtexte, Liga-Auswahl und die klickbaren Bereiche der Vorschau.
  */

/** Standardwerte (entsprechen install/config/cfg.txt, damit der Designeditor auch nach dem Löschen des install-Ordners "Standardwerte" anbieten kann). */
function lmo_design_defaults()
{
    return array(
        'main_background1' => '#dde0fF',
        'main_color1' => '#000',
        'main_border1' => '1px solid #000',
        'main_fontfamily1' => 'sans-serif',
        'main_fontsize1' => '13px',
        'main_background2' => '',
        'main_color2' => '#009',
        'main_fontfamily2' => 'Trebuchet MS,sans-serif',
        'main_fontsize2' => '115%',
        'main_background4' => '#009',
        'main_color4' => '#eee',
        'main_border4' => '',
        'main_background5' => '#009',
        'main_color5' => '#eee',
        'main_border5' => '',
        'main_background6' => '#eee',
        'main_color6' => '#009',
        'main_border6' => '',
        'main_background7' => '#eee',
        'main_color7' => '#009',
        'main_border7' => '',
        'middle_background1' => '#fff',
        'middle_color1' => '#000',
        'middle_border1' => '1px solid #000',
        'middle_fontfamily1' => 'sans-serif',
        'middle_fontsize1' => '94%',
        'middle_background2' => '#009',
        'middle_color2' => '#fff',
        'middle_fontfamily2' => 'Trebuchet MS,sans-serif',
        'middle_fontsize2' => '115%',
        'middle_background4' => '#009',
        'middle_color4' => '#fff',
        'middle_border4' => '',
        'middle_background5' => '#009',
        'middle_color5' => '#fff',
        'middle_border5' => '',
        'middle_background6' => '#fff',
        'middle_color6' => '#009',
        'middle_border6' => '',
        'middle_background7' => '#fff',
        'middle_color7' => '#009',
        'middle_border7' => '',
        'inner_background1' => '#f5f5ff',
        'inner_color1' => '#000',
        'inner_background2' => '#009',
        'inner_color2' => '#fff',
        'inner_background3' => '',
        'inner_color3' => '',
        'inner_border1' => '1px solid #003',
        'inner_fontfamily1' => 'sans-serif',
        'inner_fontsize1' => '98%',
        'tabelle_background1' => '#0c0',
        'tabelle_color1' => '#000',
        'tabelle_background2' => '#6e6',
        'tabelle_color2' => '#000',
        'tabelle_background3' => '#afa',
        'tabelle_color3' => '#000',
        'tabelle_background4' => '#cfc',
        'tabelle_color4' => '#000',
        'tabelle_background5' => '#fcb',
        'tabelle_color5' => '#000',
        'tabelle_background6' => '#e65',
        'tabelle_color6' => '#000',
        'tabelle_background7' => '#ccc',
        'tabelle_color7' => '#000',
        'tabelle_background8' => '#eee',
        'tabelle_color8' => '#000',
        'turnier_background1' => '#cfc',
        'turnier_color1' => '#000',
        'turnier_background2' => '#fcb',
        'turnier_color2' => '#000',
        'kreuzkal_background1' => '#ddf',
        'kreuzkal_background2' => '#eee',
        'fieber_color1' => '#900',
        'fieber_color2' => '#00C',
        'kreuzkal_color1' => '#d00',
        'kreuz_fontsize1' => '80%',
        'footer_fontsize1' => '80%',
        'main_underline1' => '',
        'middle_underline1' => '',
        'inner_underline1' => 'underline',
        'formular_background1' => '#eee',
        'formular_color1' => '#000',
        'formular_border1' => '2px inset #eee',
        'formular_background2' => '#eee',
        'formular_color2' => '#006',
        'formular_border2' => '2px outset #eee',
    );
}

/** Namen aller Designvariablen (ohne Präfix "lmo_") */
function lmo_design_keys()
{
    return array_keys(lmo_design_defaults());
}

/** Variablen, die als Häkchen ("underline" oder leer) gespeichert werden */
function lmo_design_is_flag($key)
{
    return substr($key, -10) === 'underline1';
}

/** Prüft einen Wert anhand des Variablentyps. Gibt true zurück, wenn er bedenkenlos in die cfg.txt und in das Stylesheet geschrieben werden darf. */
function lmo_design_valid($key, $value)
{
    if (!is_string($value) || strlen($value) > 60) {
        return false;
    }
    if (preg_match('/_(background|color|fontfamily|fontsize|border)[0-9]+$/', $key, $m) !== 1) {
        return false;
    }
    switch ($m[1]) {
        case 'background':
        case 'color':
            return preg_match('/^(#[0-9a-fA-F]{3,8}|[a-zA-Z]{3,20})?$/', $value) === 1;
        case 'border':
            return preg_match('/^[0-9a-zA-Z#%.,() -]{0,40}$/', $value) === 1;
        case 'fontfamily':
            return preg_match('/^[0-9a-zA-Z ,\'-]{0,60}$/', $value) === 1;
        case 'fontsize':
            return preg_match('/^([0-9]{1,3}(\.[0-9]{1,2})?(px|pt|pc|em|rem|ex|%|cm|mm|in)?)?$/', $value) === 1;
    }
    return false;
}

/** Übernimmt gültige Werte aus $src (z.B. $_POST, Feldnamen mit $prefix) in die globalen Variablen $lmo_<name>.
  * Ungültige oder fehlende Werte bleiben unverändert. Die Unterstreichen-Häkchen werden immer ausgewertet (nicht angehakt = leer). */
function lmo_design_apply($src, $prefix = 'xlmo_')
{
    foreach (lmo_design_keys() as $key) {
        if (lmo_design_is_flag($key)) {
            $GLOBALS['lmo_' . $key] = isset($src[$prefix . $key]) ? 'underline' : '';
        } elseif (isset($src[$prefix . $key]) && lmo_design_valid($key, $src[$prefix . $key])) {
            $GLOBALS['lmo_' . $key] = $src[$prefix . $key];
        }
    }
}

/** Alle Ligadateien (.l98) unterhalb des Ligaverzeichnisses als Liste "relativer Pfad" => Anzeigename (Pfad ohne Endung). */
function lmo_design_leagues()
{
    global $dirliga;
    $base = PATH_TO_LMO . '/' . (isset($dirliga) && $dirliga != '' ? $dirliga : 'ligen/');
    $base = rtrim($base, '/\\') . '/';
    $list = array();
    if (!is_dir($base)) {
        return $list;
    }
    try {
        $it = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($base, FilesystemIterator::SKIP_DOTS));
        foreach ($it as $f) {
            if ($f->isFile() && strtolower($f->getExtension()) === 'l98') {
                $rel = str_replace('\\', '/', substr($f->getPathname(), strlen($base)));
                $list[$rel] = substr($rel, 0, -4);
            }
        }
    } catch (Exception $e) {
        return $list;
    }
    natcasesort($list);
    return $list;
}

/** Aufbau des Editors: Reiter => Überschrift und Zeilen.
  * Zeilentypen: h = Zwischenüberschrift, c = Farben (Liste von Variablen), t = Textfeld (Variable, Länge, Breite), f = Häkchen */
function lmo_design_groups()
{
    global $text;
    $bgfg = '<acronym title="' . $text[425] . '">' . $text[424] . '</acronym>,&nbsp;<acronym title="' . $text[433] . '">' . $text[442] . '</acronym>';
    $bg = '<acronym title="' . $text[425] . '">' . $text[424] . '</acronym>';
    $fg = '<acronym title="' . $text[433] . '">' . $text[442] . '</acronym>';
    $border = '<acronym title="' . $text[427] . '">' . $text[426] . '</acronym>';
    $font = '<acronym title="' . $text[429] . '">' . $text[428] . '</acronym>';
    $size = $text[430];
    $g = array();
    foreach (array('main' => 423, 'middle' => 436) as $p => $title) {
        $g[$p] = array('title' => $text[$title], 'rows' => array(
            array('h', $text[536]),
            array('c', array($p . '_background1', $p . '_color1'), $bgfg),
            array('t', $p . '_border1', 25, 25, $border),
            array('t', $p . '_fontfamily1', 50, 25, $font),
            array('t', $p . '_fontsize1', 6, 6, $size),
            array('h', $text[537]),
            array('c', array($p . '_background2', $p . '_color2'), $bgfg),
            array('t', $p . '_fontfamily2', 50, 25, $font),
            array('t', $p . '_fontsize2', 6, 6, $size),
            array('h', $text[539] . ' (' . $text[536] . ')'),
            array('c', array($p . '_background4', $p . '_color4'), $bgfg),
            array('t', $p . '_border4', 25, 25, $border),
            array('h', $text[539] . ' (' . $text[541] . ')'),
            array('c', array($p . '_background5', $p . '_color5'), $bgfg),
            array('t', $p . '_border5', 25, 25, $border),
            array('h', $text[540] . ' (' . $text[536] . ')'),
            array('c', array($p . '_background6', $p . '_color6'), $bgfg),
            array('t', $p . '_border6', 25, 25, $border),
            array('h', $text[540] . ' (' . $text[541] . ')'),
            array('c', array($p . '_background7', $p . '_color7'), $bgfg),
            array('t', $p . '_border7', 25, 25, $border),
        ));
    }
    $g['inner'] = array('title' => $text[441], 'rows' => array(
        array('c', array('inner_background1', 'inner_color1'), $bgfg),
        array('c', array('inner_background2', 'inner_color2'), '<acronym title="' . $text[443] . '">' . $text[503] . '</acronym>: ' . $bgfg),
        array('c', array('inner_background3', 'inner_color3'), '<acronym title="' . $text[445] . '">' . $text[541] . '</acronym>: ' . $bgfg),
        array('t', 'inner_border1', 25, 25, $border),
        array('t', 'inner_fontfamily1', 50, 25, $font),
        array('t', 'inner_fontsize1', 6, 6, '<acronym title="' . $text[438] . '">' . $text[437] . '</acronym>'),
    ));
    $rows = array();
    foreach (array(1 => 451, 2 => 452, 3 => 453, 4 => 454, 5 => 455, 6 => 456, 7 => 457, 8 => 458) as $i => $t) {
        $rows[] = array('c', array('tabelle_background' . $i, 'tabelle_color' . $i), $text[$t]);
    }
    $g['tabelle'] = array('title' => $text[16], 'rows' => $rows);
    $g['turnier'] = array('title' => $text[459], 'rows' => array(
        array('c', array('turnier_background1', 'turnier_color1'), $text[460]),
        array('c', array('turnier_background2', 'turnier_color2'), $text[461]),
    ));
    $g['misc'] = array('title' => $text[236], 'rows' => array(
        array('h', $text[14] . ' / ' . $text[464]),
        array('c', array('kreuzkal_background1'), $text[503] . ': ' . $bg),
        array('c', array('kreuzkal_background2'), $text[463] . ': ' . $bg),
        array('c', array('kreuzkal_color1'), $text[466] . ': ' . $fg),
        array('t', 'kreuz_fontsize1', 6, 6, '<acronym title="' . $text[438] . '">' . $text[14] . ': ' . $text[437] . '</acronym>'),
        array('h', $text[133]),
        array('c', array('fieber_color1'), $text[281] . ' 1: ' . $fg),
        array('c', array('fieber_color2'), $text[281] . ' 2: ' . $fg),
        array('h', $text[538]),
        array('t', 'footer_fontsize1', 6, 6, '<acronym title="' . $text[435] . '">' . $text[430] . '</acronym>'),
        array('h', $text[563]),
        array('f', 'main_underline1', $text[423]),
        array('f', 'middle_underline1', $text[436]),
        array('f', 'inner_underline1', $text[441]),
    ));
    $g['formular'] = array('title' => $text[462], 'rows' => array(
        array('c', array('formular_background1', 'formular_color1'), $text[448] . ': ' . $bgfg),
        array('t', 'formular_border1', 25, 25, $text[448] . ': ' . $border),
        array('c', array('formular_background2', 'formular_color2'), $text[449] . ': ' . $bgfg),
        array('t', 'formular_border2', 25, 25, $text[449] . ': ' . $border),
    ));
    return $g;
}

/** Klickbare Bereiche der Vorschau. Reihenfolge = Priorität (innen vor aussen).
  * [CSS-Selektor, Reiter, Feld das fokussiert wird, Beschriftung] */
function lmo_design_hotspots()
{
    global $text;
    $h = array();
    $names = array(1 => 451, 2 => 452, 3 => 453, 4 => 454, 5 => 455, 6 => 456, 7 => 457, 8 => 458);
    $cls = array(1 => 'Meister', 2 => 'Cleague', 3 => 'Cleaguequali', 4 => 'Uefa', 5 => 'Relegation', 6 => 'Absteiger', 7 => 'Heimbilanz', 8 => 'Gastbilanz');
    foreach ($cls as $i => $c) {
        $h[] = array('.lmoTabelle' . $c, 'tabelle', 'tabelle_background' . $i, $text[16] . ': ' . $text[$names[$i]]);
    }
    $h[] = array('.lmoTurnierSieger', 'turnier', 'turnier_background1', $text[459] . ': ' . $text[460]);
    $h[] = array('.lmoTurnierVerlierer', 'turnier', 'turnier_background2', $text[459] . ': ' . $text[461]);
    $h[] = array('.lmo-formular-button', 'formular', 'formular_background2', $text[462] . ': ' . $text[449]);
    $h[] = array('.lmo-formular-input', 'formular', 'formular_background1', $text[462] . ': ' . $text[448]);
    $h[] = array('.lmoFrontMarkierung', 'misc', 'kreuzkal_color1', $text[236] . ': ' . $text[466]);
    $h[] = array('.lmoBackMarkierung', 'misc', 'kreuzkal_background1', $text[236] . ': ' . $text[503]);
    $h[] = array('.lmoLeer', 'misc', 'kreuzkal_background2', $text[236] . ': ' . $text[463]);
    $h[] = array('.lmoKreuz td, .lmoKreuz th, .lmoKalender td, .lmoKalender th', 'misc', 'kreuzkal_background2', $text[236] . ': ' . $text[14]);
    $h[] = array('.lmoInner th, .lmoInner caption, .lmoInner .lmoFooter', 'inner', 'inner_background2', $text[441] . ': ' . $text[503]);
    $h[] = array('.lmoInner a', 'inner', 'inner_background3', $text[441] . ': ' . $text[541]);
    $h[] = array('.lmoInner', 'inner', 'inner_background1', $text[441]);
    foreach (array('middle' => 436, 'main' => 423) as $p => $t) {
        $q = '.lmo' . ucfirst($p);
        $h[] = array($q . ' h1', $p, $p . '_background2', $text[$t] . ': ' . $text[537]);
        $h[] = array($q . ' .lmoSubmenu a', $p, $p . '_background7', $text[$t] . ': ' . $text[540] . ' (' . $text[541] . ')');
        $h[] = array($q . ' .lmoSubmenu', $p, $p . '_background6', $text[$t] . ': ' . $text[540]);
        $h[] = array($q . ' .lmoMenu a', $p, $p . '_background5', $text[$t] . ': ' . $text[539] . ' (' . $text[541] . ')');
        $h[] = array($q . ' .lmoMenu', $p, $p . '_background4', $text[$t] . ': ' . $text[539]);
        $h[] = array($q, $p, $p . '_background1', $text[$t]);
    }
    return $h;
}
