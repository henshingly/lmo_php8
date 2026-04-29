<?php
/** Translationtool for the
  * Clone of the Liga Managers Online 4
  *
  * Copyright (c) Dietmar Kersting
  * https://github.com/henshingly/lmo_php8
  *
  * This program is free software: you can redistribute it and/or modify
  * it under the terms of the GNU General Public License as published by
  * the Free Software Foundation, either version 3 of the License, or
  * (at your option) any later version.
  *
  * This program is distributed in the hope that it will be useful,
  * but WITHOUT ANY WARRANTY; without even the implied warranty of
  * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  * GNU General Public License for more details.
  *
  * REMOVING OR CHANGING THE COPYRIGHT NOTICES IS NOT ALLOWED!
  *
  */

session_start();
if (!isset($_SESSION['lmouserok']) || $_SESSION['lmouserok'] != 2) {
    die('No access');
}
header('Content-Type: text/html; charset=utf-8');
mb_internal_encoding('UTF-8');
$baseDir = __DIR__;
$from_lang = 'Deutsch'; // Select the Base Language
function getStructure($dir)
{
    $result = ['main' => []];
    $addons = [];
    $mainFiles = glob($dir . '/lang-*.txt');
    if ($mainFiles) {
        $result['main'] = array_map('basename', $mainFiles);
    }
    foreach (scandir($dir) as $item) {
        if ($item === '.' || $item === '..') continue;
        $path = $dir . '/' . $item;
        if (is_dir($path)) {
            $addons[] = $item;
        }
    }
    foreach ($addons as $addon) {
        $result[$addon] = $result['main'];
    }
    return $result;
}
$structure = getStructure($baseDir);
$type = $_POST['type'] ?? 'main';
$lang = $_POST['lang'] ?? 'lang-English.txt';
$search = $_POST['search'] ?? '';
$save = isset($_POST['save']);
$data = ($save) ? ($_POST['t'] ?? []) : [];
$dir = ($type === 'main') ? $baseDir : $baseDir . '/' . $type;
$baseFile = "$dir/lang-$from_lang.txt";
$targetFile = rtrim($dir, '/') . '/' . $lang;
if (!file_exists($targetFile) && file_exists($baseFile)) {
    copy($baseFile, $targetFile);
    chmod($targetFile, 0666);
}
function loadLang($file)
{
    $out = [];
    if (!file_exists($file)) return $out;
    foreach (file($file) as $line) {
        if (!str_contains($line, '=')) continue;
        [$k, $v] = explode('=', $line, 2);
        $out[(int)$k] = rtrim($v);
    }
    return $out;
}
$base_lang = loadLang($baseFile);
$target_lang = loadLang($targetFile);
// Save
if ($save) {
    $fp = fopen($targetFile, 'w');
    foreach ($base_lang as $key => $val) {
        $v = $data[$key] ?? $val;
        $v = str_replace(["\r\n", "\r", "\n"], '\n', $v);
        fwrite($fp, "$key=$v\n");
    }
    fclose($fp);
    $target_lang = loadLang($targetFile);
}
// Status + progress
$total = count($base_lang);
$done = 0;
function getStatus($base_lang, $cur)
{
    $base_langTrim = trim($base_lang);
    $curTrim = trim($cur);
    if ($curTrim === '') return 'empty';
    if ($curTrim === $base_langTrim) return 'same';
    if (strlen($curTrim) < strlen($base_langTrim) * 0.3) return 'warning';
    return 'done';
}
foreach ($base_lang as $k => $v) {
    $cur = $target_lang[$k] ?? '';
    if (getStatus($v, $cur) === 'done') $done++;
}
$percent = $total ? round(($done / $total) * 100) : 0;
?>
<!DOCTYPE html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>LMO Translation Tool</title>

<style>
body { margin:0; font-family: system-ui; background:#f4f6fb; }
.header { position:sticky; top:0; background:white; padding:10px; box-shadow:0 2px 5px rgba(0,0,0,0.1); }
.progress { height:10px; background:#ddd; border-radius:5px; overflow:hidden; margin-top:5px; }
.bar { height:100%; background:#4caf50; width:<?php echo $percent; ?>%; }
.controls { display:flex; gap:10px; margin-top:10px; flex-wrap:wrap; }
input, select { padding:8px; border-radius:6px; border:1px solid #ccc; }
.container { padding:10px; padding-bottom:80px; }
.card { background:white; padding:10px; margin-bottom:10px; border-radius:10px; border-left:5px solid #ccc; }
.card.empty { border-left: 18px solid #e74c3c; background:#fff5f5; }
.card.same { border-left: 18px solid #e74c3c; background: linear-gradient(to right, rgba(231,76,60,0.32), #fff); }
.card.done { border-left: 18px solid #4caf50; background: linear-gradient(to right, rgba(76,175,80,0.32), #fff); }
.card.info { background: linear-gradient(to right, rgba(0,51,255,0.32), #fff); }
.card.warning { border-left: 18px solid #e67e22; background:#fff8f0; }
.key { font-weight:bold; font-size:14px; color:#888; }
.de { font-weight:bold; margin:5px 0; white-space: pre-wrap; line-height: 1.4; }
textarea, input[type=text] { width:100%; }
.savebar { position:fixed; bottom:0; width:100%; background:white; padding:10px; box-shadow:0 -2px 5px rgba(0,0,0,0.1); }
.savebar button { width: 99%; padding: 15px; background: linear-gradient(135deg, #4caf50, #2ecc71); color: white; border: none; border-radius: 25px; font-size: 16px; box-shadow: 0 4px 10px rgba(76, 175, 80, 0.3); }
</style>

<script>
function filterList() {
    let q = document.getElementById('search').value.toLowerCase().trim();
    document.querySelectorAll('.card').forEach(c => {
        let text = c.innerText.toLowerCase();
        c.style.display = text.includes(q) ? '' : 'none';
    });
}
</script>
</head>
<body>
    <form method="post">
        <div class="header">
            <strong>🌍 Translation Tool (<?php echo $percent; ?>%)</strong>
            <div class="progress">
                <div class="bar"></div>
            </div>
            <div class="controls">
                <select name="type" onchange="this.form.submit()">
                    <option value="main">LMO Main</option>
<?php
foreach ($structure as $k => $v) {
    if($k === 'main')
        continue; ?>
                    <option value="<?php echo $k; ?>"<?php if ($type == $k) echo ' selected'; ?>><?php echo $k; ?></option>
<?php
} ?>
                </select>
                <select name="lang" onchange="this.form.submit()">
<?php
foreach ($structure[$type] ?? [] as $lf) {
    $name = str_replace(['lang-', '.txt'], '', $lf); ?>
                    <option value="<?php echo $lf; ?>"<?php if ($lang == $lf) echo ' selected'; ?>><?php echo $name; ?></option>
<?php
} ?>
                </select>
                <input type="text" id="search" placeholder="🔍 Search..." onkeyup="filterList()">
            </div>
        </div>
        <div class="container">
<?php
foreach ($base_lang as $key => $val) {
    $cur = $data[$key] ?? ($target_lang[$key] ?? $val);
    $cur = str_replace('\n', "\n", $cur);
    $status = getStatus($val, $cur);
    if ($search && mb_stripos($val . $cur, $search, 0, 'UTF-8') === false)
        continue;
?>
            <div class="card <?php echo $status; ?>">
                <div class="key">PHP-Variable:<?php
    if ($type === 'main') {
        echo ' $text[' . $key . ']';
    } else {
        echo ' $text[\'' . $type . '\'][' . $key . ']';
    } ?></div>
                <div class="de"><?php echo htmlspecialchars_decode($val) ?></div>
<?php
    if (strpos($val, '\n') !== false || strlen($val) > 80) { ?>
                <textarea name="t[<?php echo $key; ?>]"><?php echo htmlspecialchars($cur); ?></textarea>
<?php
    } else { ?>
                <input type="text" name="t[<?php echo $key; ?>]" value="<?php echo htmlspecialchars($cur); ?>">
<?php
    } ?>
            </div>
<?php
} ?>
            <div class="card info">
                <div class="key">Translationtool for LMO – Copyright © 2026 Dietmar Kersting<br>>><a href="https://www.liga-manager-online.org/">to the Clone of the LMO</a><<<br>>><a href="../lmoadmin.php">to the Admin Panel of your LMO</a><<</div>
            </div>
        </div>
        <div class="savebar"><button name="save">💾 Save</button></div>
    </form>
</body>
</html>