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
  * Gespeicherte Designs des Designeditors (config/design/<name>.json):
  * auflisten, speichern, laden, loeschen. Nur Voll-Admin, nur POST, mit Sitzungs-Token.
  */

require_once(__DIR__ . '/init.php');
require_once(__DIR__ . '/lmo-designlib.php');

header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-store');

function lmo_design_reply($data, $code = 200)
{
    http_response_code($code);
    echo json_encode($data);
    exit();
}

if (!isset($_SESSION['lmouserok']) || $_SESSION['lmouserok'] != 2 || $_SERVER['REQUEST_METHOD'] !== 'POST') {
    lmo_design_reply(['ok' => false, 'error' => 'forbidden'], 403);
}
if (empty($_SESSION['lmo_de_token']) || !isset($_POST['token']) || !is_string($_POST['token']) || !hash_equals($_SESSION['lmo_de_token'], $_POST['token'])) {
    lmo_design_reply(['ok' => false, 'error' => 'token'], 403);
}

$dir = PATH_TO_CONFIGDIR . '/design';
$op = isset($_POST['op']) && is_string($_POST['op']) ? $_POST['op'] : '';
$name = isset($_POST['name']) && is_string($_POST['name']) ? trim($_POST['name']) : '';
// Dateiname = bereinigter Name (nur Buchstaben, Ziffern, _ und -)
$slug = preg_replace('/[^A-Za-z0-9_-]+/', '_', $name);

function lmo_design_list($dir)
{
    $list = [];
    foreach ((array)glob($dir . '/*.json') as $f) {
        $d = json_decode((string)@file_get_contents($f), true);
        if (is_array($d) && isset($d['name']) && is_string($d['name'])) {
            $list[] = ['id' => basename($f, '.json'), 'name' => $d['name']];
        }
    }
    usort($list, function ($a, $b) { return strcasecmp($a['name'], $b['name']); });
    return $list;
}

if ($op === 'list') {
    lmo_design_reply(['ok' => true, 'list' => lmo_design_list($dir)]);
}

if (preg_match('/^[A-Za-z0-9 _-]{1,40}$/', $name) !== 1 || trim($slug, '_') === '') {
    lmo_design_reply(['ok' => false, 'error' => 'name'], 400);
}
$file = $dir . '/' . $slug . '.json';

if ($op === 'save') {
    if (is_file($file) && empty($_POST['overwrite'])) {
        lmo_design_reply(['ok' => false, 'error' => 'exists']);
    }
    $values = [];
    foreach (lmo_design_keys() as $k) {
        $v = isset($_POST['xlmo_' . $k]) ? $_POST['xlmo_' . $k] : null;
        if (lmo_design_is_flag($k)) {
            $values[$k] = $v !== null ? 'underline' : '';
        } elseif ($v !== null && lmo_design_valid($k, $v)) {
            $values[$k] = $v;
        }
    }
    if (!is_dir($dir) && !@mkdir($dir, 0777, true)) {
        lmo_design_reply(['ok' => false, 'error' => 'write']);
    }
    $json = json_encode(['lmo_design' => 1, 'name' => $name, 'values' => $values], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    if (@file_put_contents($file, $json, LOCK_EX) === false) {
        lmo_design_reply(['ok' => false, 'error' => 'write']);
    }
    lmo_design_reply(['ok' => true, 'list' => lmo_design_list($dir), 'id' => $slug]);
}

if ($op === 'load' || $op === 'delete') {
    if (!is_file($file)) {
        lmo_design_reply(['ok' => false, 'error' => 'notfound'], 404);
    }
    if ($op === 'delete') {
        $ok = @unlink($file);
        lmo_design_reply(['ok' => $ok, 'error' => $ok ? '' : 'write', 'list' => lmo_design_list($dir)]);
    }
    $d = json_decode((string)file_get_contents($file), true);
    $values = [];
    if (is_array($d) && isset($d['values']) && is_array($d['values'])) {
        foreach ($d['values'] as $k => $v) {
            if (in_array($k, lmo_design_keys(), true) && (lmo_design_is_flag($k) ? ($v === 'underline' || $v === '') : lmo_design_valid($k, $v))) {
                $values[$k] = $v;
            }
        }
    }
    lmo_design_reply(['ok' => true, 'values' => $values, 'name' => $name]);
}

lmo_design_reply(['ok' => false, 'error' => 'op'], 400);
