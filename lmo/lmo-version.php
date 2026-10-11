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
  */

// Version des LMO: Die installierte kennt Composer (Git-Tag des Pakets), die neueste Packagist.

if (!defined('LMO_PACKAGE')) {
    define('LMO_PACKAGE', 'lmo/lmo_php8');
}
/** Anzeige, wenn keine getaggte Version installiert ist (Entwicklungsstand, Git-Checkout) */
if (!defined('LMO_VERSION_DEV')) {
    define('LMO_VERSION_DEV', 'dev');
}

/**
 * "v4.2.1" -> "4.2.1"; alles ohne Versionsnummer (dev-master, 1.0.0+no-version-set, null) -> "dev".
 */
function lmo_normalize_version(?string $pretty): string
{
    $pretty = ltrim((string)$pretty, 'vV');
    if (!preg_match('/^\d+(\.\d+)+([-.]?(alpha|beta|rc|patch|p)\.?\d*)?$/i', $pretty) || strpos($pretty, '+no-version-set') !== false) {
        return LMO_VERSION_DEV;
    }
    return $pretty;
}

/**
 * Installierte Version laut Composer.
 */
function lmo_installed_version(): string
{
    if (!class_exists('Composer\InstalledVersions')) {
        return LMO_VERSION_DEV;
    }
    try {
        return lmo_normalize_version(\Composer\InstalledVersions::getPrettyVersion(LMO_PACKAGE));
    } catch (\OutOfBoundsException $e) {
        return LMO_VERSION_DEV;
    }
}

/**
 * Neueste stabile Version aus der Paketliste von Packagist (https://repo.packagist.org/p2/<paket>.json).
 * Die Liste ist verkuerzt ("minified": "composer/2.0"): Jeder Eintrag nennt nur, was sich
 * gegenueber dem vorherigen aendert; "__unset" entfernt einen Wert.
 *
 * @param mixed $packagist dekodierte Antwort von Packagist
 * @return array{version: string, time: string, php: string, changelog: string}|null
 *         z. B. ['version' => '4.3.0', 'time' => '2026-11-01', 'php' => '>=8.0', 'changelog' => URL oder '']
 */
function lmo_latest_release($packagist, string $package = LMO_PACKAGE): ?array
{
    $latest = null;
    $entry = array();
    $list = isset($packagist['packages'][$package]) && is_array($packagist['packages'][$package]) ? $packagist['packages'][$package] : array();
    foreach ($list as $diff) {
        foreach ((array)$diff as $key => $value) {
            if ($value === '__unset') {
                unset($entry[$key]);
            } else {
                $entry[$key] = $value;
            }
        }
        $version = isset($entry['version']) ? ltrim((string)$entry['version'], 'vV') : '';
        // nur fertige Versionen, keine alpha/beta/RC
        if (!preg_match('/^\d+(\.\d+)+$/', $version) || ($latest !== null && version_compare($version, $latest['version'], '<='))) {
            continue;
        }
        $source = isset($entry['source']['url']) ? (string)preg_replace('/\.git$/', '', (string)$entry['source']['url']) : '';
        $latest = array(
            'version' => $version,
            'time' => isset($entry['time']) ? substr((string)$entry['time'], 0, 10) : '',
            'php' => isset($entry['require']['php']) ? (string)$entry['require']['php'] : '',
            'changelog' => preg_match('#^https://#', $source) ? $source . '/blob/' . rawurlencode((string)$entry['version']) . '/changelog.md' : '',
        );
    }
    return $latest;
}

/**
 * Fragt Packagist nach der neuesten Version. Das Ergebnis (auch ein Fehlschlag) wird in $cacheFile
 * gemerkt und erst nach $maxAge Sekunden oder mit $force neu geholt.
 *
 * @param callable(string): (string|false)|null $fetch nur fuer Tests: liefert den Inhalt der URL oder false
 * @return array{version: string, time: string, php: string, changelog: string}|null
 *         wie lmo_latest_release(), null wenn nichts bekannt ist
 */
function lmo_update_info(string $cacheFile, bool $force = false, int $maxAge = 86400, ?callable $fetch = null, ?int $now = null): ?array
{
    $now = $now === null ? time() : $now;
    $cache = is_file($cacheFile) ? json_decode((string)@file_get_contents($cacheFile), true) : null;
    $checked = is_array($cache) && isset($cache['checked']) && is_int($cache['checked']) ? $cache['checked'] : null;
    $known = is_array($cache) && isset($cache['latest']) ? lmo_release_from_cache($cache['latest']) : null;
    if ($known === null && isset($cache['latest'])) {
        $checked = null; // beschaedigte Merkdatei: neu fragen
    }
    if (!$force && $checked !== null && $now - $checked < $maxAge && $checked <= $now) {
        return $known;
    }

    $url = 'https://repo.packagist.org/p2/' . LMO_PACKAGE . '.json';
    if ($fetch === null) {
        // Der Server erlaubt keine Abfragen: nichts versuchen und nichts merken.
        if (!ini_get('allow_url_fopen')) {
            return $known;
        }
        $fetch = static function ($url) {
            $context = stream_context_create(array('http' => array('timeout' => 3, 'user_agent' => 'LMO update check')));
            return @file_get_contents($url, false, $context);
        };
    }
    $json = $fetch($url);
    $latest = is_string($json) ? lmo_latest_release(json_decode($json, true)) : null;
    // bei einem Fehlschlag das letzte bekannte Ergebnis behalten
    if ($latest === null) {
        $latest = $known;
    }
    @file_put_contents($cacheFile, json_encode(array('checked' => $now, 'latest' => $latest)));

    return $latest;
}

/**
 * Liest ein gemerktes Ergebnis; alles, was nicht wie eines aussieht, gilt als unbekannt.
 *
 * @param mixed $value
 * @return array{version: string, time: string, php: string, changelog: string}|null
 */
function lmo_release_from_cache($value): ?array
{
    $release = array();
    foreach (array('version', 'time', 'php', 'changelog') as $key) {
        if (!is_array($value) || !isset($value[$key]) || !is_string($value[$key])) {
            return null;
        }
        $release[$key] = $value[$key];
    }
    return $release['version'] === '' ? null : $release;
}

/**
 * Gibt es eine neuere Version als die installierte? Ein Entwicklungsstand wird nie als veraltet gemeldet.
 *
 * @param mixed $latest
 */
function lmo_is_newer($latest, string $installed): bool
{
    return $installed !== LMO_VERSION_DEV && is_string($latest) && $latest !== '' && version_compare($latest, $installed, '>');
}
