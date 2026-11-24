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
  * Gemeinsame Funktionen des Designeditors (lmo-admindesign.php) und der
  * Live-Vorschau (lmo-designcss.php): Feldliste, Standardwerte, Pruefung der
  * Eingaben, Sprachtexte, Liga-Auswahl und die klickbaren Bereiche der Vorschau.
  */

/** Standardwerte (entsprechen install/config/cfg.txt, damit der Designeditor
  * auch nach dem Loeschen des install-Ordners "Standardwerte" anbieten kann). */
function lmo_design_defaults()
{
    return [
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
    ];
}

/** Namen aller Designvariablen (ohne Praefix "lmo_") */
function lmo_design_keys()
{
    return array_keys(lmo_design_defaults());
}

/** Variablen, die als Haekchen ("underline" oder leer) gespeichert werden */
function lmo_design_is_flag($key)
{
    return substr($key, -10) === 'underline1';
}

/** Prueft einen Wert anhand des Variablentyps. Gibt true zurueck, wenn er
  * bedenkenlos in die cfg.txt und in das Stylesheet geschrieben werden darf. */
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

/** Uebernimmt gueltige Werte aus $src (z.B. $_POST, Feldnamen mit $prefix) in die
  * globalen Variablen $lmo_<name>. Ungueltige oder fehlende Werte bleiben unveraendert.
  * Die Unterstreichen-Haekchen werden immer ausgewertet (nicht angehakt = leer). */
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

/** Alle Ligadateien (.l98) unterhalb des Ligaverzeichnisses als Liste
  * "relativer Pfad" => Anzeigename (Pfad ohne Endung). */
function lmo_design_leagues()
{
    global $dirliga;
    $base = PATH_TO_LMO . '/' . (isset($dirliga) && $dirliga != '' ? $dirliga : 'ligen/');
    $base = rtrim($base, '/\\') . '/';
    $list = [];
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

/** Aufbau des Editors: Reiter => Ueberschrift und Zeilen.
  * Zeilentypen: h = Zwischenueberschrift, c = Farben (Liste von Variablen),
  * t = Textfeld (Variable, Laenge, Breite), f = Haekchen */
function lmo_design_groups()
{
    global $text;
    $bgfg = '<acronym title="' . $text[425] . '">' . $text[424] . '</acronym>,&nbsp;<acronym title="' . $text[433] . '">' . $text[442] . '</acronym>';
    $bg = '<acronym title="' . $text[425] . '">' . $text[424] . '</acronym>';
    $fg = '<acronym title="' . $text[433] . '">' . $text[442] . '</acronym>';
    $border = '<acronym title="' . $text[427] . '">' . $text[426] . '</acronym>';
    $font = '<acronym title="' . $text[429] . '">' . $text[428] . '</acronym>';
    $size = $text[430];
    $g = [];
    foreach (['main' => 423, 'middle' => 436] as $p => $title) {
        $g[$p] = ['title' => $text[$title], 'rows' => [
            ['h', $text[536]],
            ['c', [$p . '_background1', $p . '_color1'], $bgfg],
            ['t', $p . '_border1', 25, 25, $border],
            ['t', $p . '_fontfamily1', 50, 25, $font],
            ['t', $p . '_fontsize1', 6, 6, $size],
            ['h', $text[537]],
            ['c', [$p . '_background2', $p . '_color2'], $bgfg],
            ['t', $p . '_fontfamily2', 50, 25, $font],
            ['t', $p . '_fontsize2', 6, 6, $size],
            ['h', $text[539] . ' (' . $text[536] . ')'],
            ['c', [$p . '_background4', $p . '_color4'], $bgfg],
            ['t', $p . '_border4', 25, 25, $border],
            ['h', $text[539] . ' (' . $text[541] . ')'],
            ['c', [$p . '_background5', $p . '_color5'], $bgfg],
            ['t', $p . '_border5', 25, 25, $border],
            ['h', $text[540] . ' (' . $text[536] . ')'],
            ['c', [$p . '_background6', $p . '_color6'], $bgfg],
            ['t', $p . '_border6', 25, 25, $border],
            ['h', $text[540] . ' (' . $text[541] . ')'],
            ['c', [$p . '_background7', $p . '_color7'], $bgfg],
            ['t', $p . '_border7', 25, 25, $border],
        ]];
    }
    $g['inner'] = ['title' => $text[441], 'rows' => [
        ['c', ['inner_background1', 'inner_color1'], $bgfg],
        ['c', ['inner_background2', 'inner_color2'], '<acronym title="' . $text[443] . '">' . $text[503] . '</acronym>: ' . $bgfg],
        ['c', ['inner_background3', 'inner_color3'], '<acronym title="' . $text[445] . '">' . $text[541] . '</acronym>: ' . $bgfg],
        ['t', 'inner_border1', 25, 25, $border],
        ['t', 'inner_fontfamily1', 50, 25, $font],
        ['t', 'inner_fontsize1', 6, 6, '<acronym title="' . $text[438] . '">' . $text[437] . '</acronym>'],
    ]];
    $rows = [];
    foreach ([1 => 451, 2 => 452, 3 => 453, 4 => 454, 5 => 455, 6 => 456, 7 => 457, 8 => 458] as $i => $t) {
        $rows[] = ['c', ['tabelle_background' . $i, 'tabelle_color' . $i], $text[$t]];
    }
    $g['tabelle'] = ['title' => $text[16], 'rows' => $rows];
    $g['turnier'] = ['title' => $text[459], 'rows' => [
        ['c', ['turnier_background1', 'turnier_color1'], $text[460]],
        ['c', ['turnier_background2', 'turnier_color2'], $text[461]],
    ]];
    $g['misc'] = ['title' => $text[236], 'rows' => [
        ['h', $text[14] . ' / ' . $text[464]],
        ['c', ['kreuzkal_background1'], $text[503] . ': ' . $bg],
        ['c', ['kreuzkal_background2'], $text[463] . ': ' . $bg],
        ['c', ['kreuzkal_color1'], $text[466] . ': ' . $fg],
        ['t', 'kreuz_fontsize1', 6, 6, '<acronym title="' . $text[438] . '">' . $text[14] . ': ' . $text[437] . '</acronym>'],
        ['h', $text[133]],
        ['c', ['fieber_color1'], $text[281] . ' 1: ' . $fg],
        ['c', ['fieber_color2'], $text[281] . ' 2: ' . $fg],
        ['h', $text[538]],
        ['t', 'footer_fontsize1', 6, 6, '<acronym title="' . $text[435] . '">' . $text[430] . '</acronym>'],
        ['h', $text[563]],
        ['f', 'main_underline1', $text[423]],
        ['f', 'middle_underline1', $text[436]],
        ['f', 'inner_underline1', $text[441]],
    ]];
    $g['formular'] = ['title' => $text[462], 'rows' => [
        ['c', ['formular_background1', 'formular_color1'], $text[448] . ': ' . $bgfg],
        ['t', 'formular_border1', 25, 25, $text[448] . ': ' . $border],
        ['c', ['formular_background2', 'formular_color2'], $text[449] . ': ' . $bgfg],
        ['t', 'formular_border2', 25, 25, $text[449] . ': ' . $border],
    ]];
    return $g;
}

/** Klickbare Bereiche der Vorschau. Reihenfolge = Prioritaet (innen vor aussen).
  * [CSS-Selektor, Reiter, Feld das fokussiert wird, Beschriftung] */
function lmo_design_hotspots()
{
    global $text;
    $h = [];
    $names = [1 => 451, 2 => 452, 3 => 453, 4 => 454, 5 => 455, 6 => 456, 7 => 457, 8 => 458];
    $cls = [1 => 'Meister', 2 => 'Cleague', 3 => 'Cleaguequali', 4 => 'Uefa', 5 => 'Relegation', 6 => 'Absteiger', 7 => 'Heimbilanz', 8 => 'Gastbilanz'];
    foreach ($cls as $i => $c) {
        $h[] = ['.lmoTabelle' . $c, 'tabelle', 'tabelle_background' . $i, $text[16] . ': ' . $text[$names[$i]]];
    }
    $h[] = ['.lmoTurnierSieger', 'turnier', 'turnier_background1', $text[459] . ': ' . $text[460]];
    $h[] = ['.lmoTurnierVerlierer', 'turnier', 'turnier_background2', $text[459] . ': ' . $text[461]];
    $h[] = ['.lmo-formular-button', 'formular', 'formular_background2', $text[462] . ': ' . $text[449]];
    $h[] = ['.lmo-formular-input', 'formular', 'formular_background1', $text[462] . ': ' . $text[448]];
    $h[] = ['.lmoFrontMarkierung', 'misc', 'kreuzkal_color1', $text[236] . ': ' . $text[466]];
    $h[] = ['.lmoBackMarkierung', 'misc', 'kreuzkal_background1', $text[236] . ': ' . $text[503]];
    $h[] = ['.lmoLeer', 'misc', 'kreuzkal_background2', $text[236] . ': ' . $text[463]];
    $h[] = ['.lmoKreuz td, .lmoKreuz th, .lmoKalender td, .lmoKalender th', 'misc', 'kreuzkal_background2', $text[236] . ': ' . $text[14]];
    $h[] = ['.lmoInner th, .lmoInner caption, .lmoInner .lmoFooter', 'inner', 'inner_background2', $text[441] . ': ' . $text[503]];
    $h[] = ['.lmoInner a', 'inner', 'inner_background3', $text[441] . ': ' . $text[541]];
    $h[] = ['.lmoInner', 'inner', 'inner_background1', $text[441]];
    foreach (['middle' => 436, 'main' => 423] as $p => $t) {
        $q = '.lmo' . ucfirst($p);
        $h[] = [$q . ' h1', $p, $p . '_background2', $text[$t] . ': ' . $text[537]];
        $h[] = [$q . ' .lmoSubmenu a', $p, $p . '_background7', $text[$t] . ': ' . $text[540] . ' (' . $text[541] . ')'];
        $h[] = [$q . ' .lmoSubmenu', $p, $p . '_background6', $text[$t] . ': ' . $text[540]];
        $h[] = [$q . ' .lmoMenu a', $p, $p . '_background5', $text[$t] . ': ' . $text[539] . ' (' . $text[541] . ')'];
        $h[] = [$q . ' .lmoMenu', $p, $p . '_background4', $text[$t] . ': ' . $text[539]];
        $h[] = [$q, $p, $p . '_background1', $text[$t]];
    }
    return $h;
}
