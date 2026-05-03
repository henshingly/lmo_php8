<?php
/** Translationtool for the
  * Clone of the Liga Managers Online 4
  *
  * Copyright (c) 2026 Dietmar Kersting
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
// Strikte Session-Validierung
if (!isset($_SESSION['lmouserok']) || $_SESSION['lmouserok'] !== 2) {
    http_response_code(403);
    die('<html><head><meta charset="UTF-8"><title>Access denied</title></head><body style="font-family: Arial; padding: 20px;"><h2>❌ Access denied</h2><p>Admin access required. <a href="../lmoadmin.php">→ to the admin page</a></p></body></html>');
}

header('Content-Type: text/html; charset=utf-8');
mb_internal_encoding('UTF-8');

$baseDir = __DIR__;  // Jetzt ist __DIR__ das /lang Verzeichnis
$from_lang = 'Deutsch'; // Wähle die Basissprache aus
$errorMsg = '';
$successMsg = '';

// Struktur mit Error Handling abrufen
function getStructure($dir)
{
    $result = ['main' => []];
    $addons = [];

    $mainFiles = glob($dir . '/lang-*.txt');
    if ($mainFiles !== false) {
        $result['main'] = array_map('basename', $mainFiles);
    }

    // scandir() auf false prüfen
    $items = @scandir($dir);
    if ($items === false) {
        return $result;
    }

    foreach ($items as $item) {
        if ($item === '.' || $item === '..') {
            continue;
        }
        $path = $dir . '/' . $item;
        if (is_dir($path) && !is_link($path)) { // Symlinks prüfen
            $addons[] = $item;
        }
    }

    foreach ($addons as $addon) {
        $result[$addon] = $result['main'];
    }

    return $result;
}

$structure = getStructure($baseDir);

// Validierung aller POST-Parameter
$type = $_POST['type'] ?? 'main';
$lang = $_POST['lang'] ?? 'lang-English.txt';
$search = trim($_POST['search'] ?? '');
$save = isset($_POST['save']);
$data = ($save) ? ($_POST['t'] ?? []) : [];

// Type gegen erlaubte Werte validieren (Path Traversal Prevention)
if (!isset($structure[$type])) {
    http_response_code(400);
    die('Invalid type parameter');
}

// Lang gegen erlaubte Werte validieren
$allowedLangs = $structure[$type] ?? [];
if (!in_array($lang, $allowedLangs, true)) {
    http_response_code(400);
    die('Invalid lang parameter');
}

$dir = ($type === 'main') ? $baseDir : $baseDir . '/' . $type;
$baseFile = $dir . '/lang-' . $from_lang . '.txt';
$targetFile = $dir . '/' . $lang;

// Pfade validieren (keine .. erlaubt)
if (strpos(realpath($dir) ? : '', realpath($baseDir) ? : '') !== 0) {
    http_response_code(403);
    die('Invalid directory path');
}

// Erstelle die Zieldatei, falls sie noch nicht existiert.
if (!file_exists($targetFile) && file_exists($baseFile)) {
    if (!copy($baseFile, $targetFile)) {
        $errorMsg = 'Error copying the base file.';
    } else {
        @chmod($targetFile, 0666);
    }
}

// Robuste Lang-Datei Laden mit Error Handling
function loadLang($file)
{
    $out = [];

    if (!file_exists($file) || !is_readable($file)) {
        return $out;
    }

    $lines = @file($file, FILE_IGNORE_NEW_LINES);
    if ($lines === false) {
        return $out;
    }

    foreach ($lines as $line) {
        if (empty($line) || !str_contains($line, '=')) {
            continue;
        }

        [$k, $v] = explode('=', $line, 2);
        $k = (int)$k;

        if ($k >= 0) {
            $out[$k] = $v;
        }
    }

    return $out;
}

$base_lang = loadLang($baseFile);
$target_lang = loadLang($targetFile);

// Save mit ordentlichem Error Handling
if ($save && !empty($base_lang)) {
    $fp = @fopen($targetFile, 'w');

    if ($fp === false) {
        $errorMsg = 'Error: File could not be opened for saving.';
    } else {
        try {
            foreach ($base_lang as $key => $val) {
                $v = isset($data[$key]) ? (string)$data[$key] : $val;

                // String-Input validieren
                $v = str_replace(["\r\n", "\r", "\n"], '\n', $v);
                $v = preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]/u', '', $v); // Nur druckbare Zeichen

                if (fwrite($fp, $key . '=' . $v . "\n") === false) {
                    throw new Exception('Error writing to file.');
                }
            }
            fclose($fp);
            @chmod($targetFile, 0666);
            $successMsg = 'Translation saved successfully!';
            $target_lang = loadLang($targetFile);
        } catch (Exception $e) {
            $errorMsg = 'Error saving: ' . htmlspecialchars($e->getMessage());
            @fclose($fp);
        }
    }
}

// Status + Fortschritt
$total = count($base_lang);
$done = 0;

// getStatus Funktion mit besserer Logik
function getStatus($base_lang, $cur)
{
    $base_langTrim = trim($base_lang);
    $curTrim = trim($cur);

    if ($curTrim === '') {
        return 'empty';
    }
    if ($curTrim === $base_langTrim) {
        return 'same';
    }
    if (strlen($curTrim) < strlen($base_langTrim) * 0.3) {
        return 'warning';
    }

    return 'done';
}

foreach ($base_lang as $k => $v) {
    $cur = $target_lang[$k] ?? '';
    if (getStatus($v, $cur) === 'done') {
        $done++;
    }
}

$percent = $total ? round(($done / $total) * 100) : 0;
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LMO Translation Tool</title>

    <style>
        body { margin: 0; font-family: system-ui; background: #f4f6fb; }
        .header { position: sticky; top: 0; background: white; padding: 10px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); z-index: 100; }
        .alert { padding: 12px; margin: 10px; border-radius: 6px; }
        .alert.error { background: #fee; border-left: 4px solid #c33; color: #c33; }
        .alert.success { background: #efe; border-left: 4px solid #3c3; color: #3c3; }
        .progress { height: 10px; background: #ddd; border-radius: 5px; overflow: hidden; margin-top: 5px; }
        .bar { height: 100%; background: #4caf50; width: <?php echo $percent; ?>%; transition: width 0.3s; }
        .controls { display: flex; gap: 10px; margin-top: 10px; flex-wrap: wrap; }
        input, select { padding: 8px; border-radius: 6px; border: 1px solid #ccc; font-size: 14px; }
        input:focus, select:focus { outline: none; border-color: #4caf50; box-shadow: 0 0 5px rgba(76,175,80,0.3); }
        .container { padding: 10px; padding-bottom: 100px; }
        .card { background: white; padding: 12px; margin-bottom: 10px; border-radius: 10px; border-left: 5px solid #ccc; }
        .card.empty { border-left: 18px solid #e74c3c; background: #fff5f5; }
        .card.same { border-left: 18px solid #f39c12; background: linear-gradient(to right, rgba(243,156,18,0.1), #fff); }
        .card.done { border-left: 18px solid #4caf50; background: linear-gradient(to right, rgba(76,175,80,0.1), #fff); }
        .card.warning { border-left: 18px solid #e67e22; background: #fff8f0; }
        .card.info { background: linear-gradient(to right, rgba(0,51,255,0.1), #fff); border: 1px solid #e3e8f3; }
        .key { font-weight: bold; font-size: 13px; color: #666; font-family: monospace; }
        .source { font-weight: 600; margin: 8px 0 5px 0; white-space: pre-wrap; line-height: 1.5; word-break: break-word; }
        textarea, input[type="text"] { width: 100%; box-sizing: border-box; padding: 8px; font-size: 14px; }
        .savebar { position: fixed; bottom: 0; width: 100%; background: white; padding: 10px; box-shadow: 0 -2px 8px rgba(0,0,0,0.15); border-top: 1px solid #e0e0e0; }
        .savebar button { width: 100%; padding: 15px; background: linear-gradient(135deg, #4caf50, #45a049); color: white; border: none; border-radius: 6px; font-size: 16px; font-weight: bold; cursor: pointer; transition: transform 0.1s; }
        .savebar button:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(76,175,80,0.4); }
        .savebar button:active { transform: translateY(0); }
    </style>

    <script>
        function filterList() {
            const q = document.getElementById('search').value.toLowerCase().trim();
            const cards = document.querySelectorAll('.card:not(.info)');
            let visibleCount = 0;

            cards.forEach(c => {
                const text = c.innerText.toLowerCase();
                const isVisible = q === '' || text.includes(q);
                c.style.display = isVisible ? '' : 'none';
                if (isVisible) visibleCount++;
            });

            // Optional: Zeige Count
            console.log(`Entries found: ${visibleCount}`);
        }
    </script>
</head>
<body>
    <form method="post" action="">
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
    if ($k === 'main') continue;
    // htmlspecialchars() verwenden
    $selected = ($type === $k) ? ' selected' : '';
    echo '                    <option value="' . htmlspecialchars($k) . '"' . $selected . '>Addon: ' . htmlspecialchars($k) . '</option>' . "\n";
} ?>
                </select>
                <select name="lang" onchange="this.form.submit()">
<?php
foreach ($structure[$type] ?? [] as $lf) {
    $name = str_replace(['lang-', '.txt'], '', $lf);
    $selected = ($lang === $lf) ? ' selected' : '';
    echo '                    <option value="' . htmlspecialchars($lf) . '"' . $selected . '>' . htmlspecialchars($name) . '</option>' . "\n";
} ?>
                </select>
                <input type="text" id="search" placeholder="🔍 Search..." onkeyup="filterList()">
            </div>

<?php
if (!empty($errorMsg)) { ?>
                <div class="alert error"><?php echo htmlspecialchars($errorMsg); ?></div>
<?php
}
if (!empty($successMsg)) { ?>
                <div class="alert success"><?php echo htmlspecialchars($successMsg); ?></div>
<?php
} ?>
        </div>

        <div class="container">
<?php
if (empty($base_lang)) { ?>
            <div class="card info">
                <p>⚠️ No translations found. Please check the file structure.</p>
            </div>
<?php
} else {
    foreach ($base_lang as $key => $val) {
        $cur = $data[$key] ?? ($target_lang[$key] ?? $val);
        $cur = str_replace('\n', "\n", $cur);
        $status = getStatus($val, $cur);

        // Server-seitige Suche (nicht nur Client)
        if (!empty($search)) {
            $searchPos = mb_stripos($val . $cur, $search, 0, 'UTF-8');
            if ($searchPos === false) {
                continue;
            }
        } ?>
            <div class="card <?php echo htmlspecialchars($status); ?>">
                <div class="key">PHP-Variable:<?php
        if ($type === 'main') {
            echo ' $text[' . (int)$key . ']';
        } else {
            echo ' $text[\'' . htmlspecialchars($type) . '\'][' . (int)$key . ']';
        } ?></div>
                <div class="source"><?php echo htmlspecialchars($val, ENT_QUOTES, 'UTF-8'); ?></div>
<?php
        if (strpos($val, '\n') !== false || strlen($val) > 80) { ?>
                <textarea name="t[<?php echo (int)$key; ?>]" rows="4"><?php echo htmlspecialchars($cur, ENT_QUOTES, 'UTF-8'); ?></textarea>
<?php
        } else { ?>
                <input type="text" name="t[<?php echo (int)$key; ?>]" value="<?php echo htmlspecialchars($cur, ENT_QUOTES, 'UTF-8'); ?>">
<?php
        } ?>
            </div>

<?php
    } ?>
            <div class="card info">
                <div class="key">
                    Translationtool for LMO – Copyright © 2026 Dietmar Kersting<br>
                    → <a href="../lmoadmin.php">to the Admin Panel of your LMO</a><br>
                    → <a href="https://www.liga-manager-online.org/">to the Homepage of the LMO Clone</a>
                </div>
            </div>

<?php
} ?>
        </div>

        <div class="savebar">
            <button type="submit" name="save" value="1">💾 Save</button>
        </div>

    </form>
</body>
</html>