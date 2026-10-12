<?php

namespace Lmo\Tests\GoldenMaster\Support;

use RuntimeException;

/**
 * Erzeugt Testligen mit gespielten Partien und den Sonderfaellen, die die
 * mitgelieferten Beispielligen nicht abdecken (alle 9 haben noch keine Ergebnisse).
 *
 * Grundlage ist jeweils eine mitgelieferte "Schluessel"-Liga (ligen/dfb/NNer-liga.l98).
 * Es werden nur Werte vorhandener Schluessel ersetzt bzw. fehlende Schluessel
 * ergaenzt, damit das Dateiformat nicht nachgebaut werden muss. Die Ergebnisse
 * kommen aus einem festen Seed und sind auf jeder PHP-Version identisch.
 */
final class LeagueFactory
{
    public const SEED = 20250315;

    /**
     * @return array<string,array<string,mixed>> Name => Szenario
     */
    public static function scenarios(): array
    {
        return [
            'basic' => [
                'teams' => 8, 'played' => 0.6, 'maxGoals' => 4,
                'options' => ['MinusPoints' => 1, 'Direct' => 0],
            ],
            'minus2_direct' => [
                'teams' => 8, 'played' => 1.0, 'maxGoals' => 2,
                'options' => ['MinusPoints' => 2, 'Direct' => 1],
            ],
            'kegel' => [
                'teams' => 6, 'played' => 0.8, 'maxGoals' => 9,
                'options' => ['Kegel' => 1, 'MinusPoints' => 1],
            ],
            'penalties' => [
                'teams' => 8, 'played' => 0.9, 'maxGoals' => 3,
                'options' => ['MinusPoints' => 2, 'Direct' => 1],
                'teamKeys' => [
                    1 => ['SP' => 3, 'SM' => 0, 'STDA' => 0],
                    2 => ['SP' => -2, 'SM' => -1, 'TOR1' => 3, 'TOR2' => 1, 'STDA' => 5],
                    3 => ['SP' => 6, 'SM' => 6, 'TOR1' => -2, 'TOR2' => 4, 'STDA' => 9],
                    4 => ['TOR1' => 2, 'TOR2' => 0, 'STDA' => 3],
                ],
            ],
            'special' => [
                'teams' => 6, 'played' => 0.9, 'maxGoals' => 3,
                'options' => [
                    'Spez' => 1, 'XtraS' => 2, 'XtraU' => 1, 'XtraV' => 1,
                    'SpezS' => 2, 'SpezU' => 2, 'SpezV' => 1,
                ],
                'special' => true,
            ],
            'handicap' => [
                'teams' => 6, 'played' => 0.7, 'maxGoals' => 3,
                'options' => ['HandS' => 1, 'Actual' => 3],
                'handicap' => true,
            ],
            'wertung' => [
                'teams' => 8, 'played' => 0.8, 'maxGoals' => 3,
                'options' => ['MinusPoints' => 2],
                'wertung' => true,
            ],
            // Direkter Vergleich (Lmo\Liga\Tabelle) mit Kegelwertung, Sonderpunkten, Wertung und Handicap.
            // Wenige Tore und viele Unentschieden erzeugen Punktgleichheit; nur Tabellenseiten werden geprueft.
            'direct_kegel' => [
                'teams' => 8, 'played' => 1.0, 'maxGoals' => 1, 'pages' => 'table',
                'options' => ['Kegel' => 1, 'Direct' => 1, 'MinusPoints' => 2],
            ],
            'direct_special' => [
                'teams' => 6, 'played' => 1.0, 'maxGoals' => 1, 'pages' => 'table',
                'options' => [
                    'Direct' => 1, 'MinusPoints' => 2, 'Spez' => 1,
                    'XtraS' => 2, 'XtraU' => 1, 'XtraV' => 1, 'SpezS' => 2, 'SpezU' => 2, 'SpezV' => 1,
                ],
                'special' => true,
            ],
            'direct_wertung' => [
                'teams' => 8, 'played' => 1.0, 'maxGoals' => 1, 'pages' => 'table',
                'options' => ['Direct' => 1, 'MinusPoints' => 2],
                'wertung' => true,
            ],
            // Wie direct_wertung, aber mit sehr vielen Wertungsspielen (jedes zweite bis dritte Spiel),
            // damit auch die Gastsicht einer Heim-Wertung im direkten Vergleich vorkommt.
            'direct_wertung_many' => [
                'teams' => 8, 'played' => 1.0, 'maxGoals' => 1, 'pages' => 'table', 'kindRange' => 4,
                'options' => ['Direct' => 1, 'MinusPoints' => 2],
                'wertung' => true,
            ],
            'direct_handicap' => [
                'teams' => 6, 'played' => 0.8, 'maxGoals' => 1, 'pages' => 'table',
                'options' => ['Direct' => 1, 'HandS' => 1, 'Actual' => 4],
                'handicap' => true,
            ],
            // Anzeigeoptionen der Tabelle: Favoritenteam (fett), Vereins-URL, Teamnotiz im Tooltip.
            'viewopts' => [
                'teams' => 6, 'played' => 0.8, 'maxGoals' => 3, 'pages' => 'table',
                'options' => ['favTeam' => 3, 'urlT' => 1, 'MinusPoints' => 2],
                'teamKeys' => [
                    2 => ['URL' => 'http://example.org/team2'],
                    3 => ['NOT' => 'Aufsteiger & Pokalsieger'],
                    4 => ['URL' => 'https://example.org/team4?a=1&b=2', 'NOT' => 'Zweite Notiz'],
                    5 => ['SP' => 2, 'SM' => 1, 'STDA' => 4, 'NOT' => 'Strafe und Notiz'],
                ],
            ],
            'rankzones' => [
                'teams' => 10, 'played' => 0.9, 'maxGoals' => 4,
                'options' => ['Champ' => 1, 'CL' => 2, 'CK' => 1, 'UC' => 1, 'AR' => 1, 'AB' => 2, 'HideDraw' => 1],
            ],
        ];
    }

    /** Welche Seiten je Szenario geprueft werden: "full" (Standard) oder "table" (nur Tabelle). */
    public static function pageMode(string $name): string
    {
        return self::scenarios()[$name]['pages'] ?? 'full';
    }

    /** Liga-Datei (relativ zu ligen/) => Anzahl Spieltage, fuer die Seitenmatrix. */
    public static function files(): array
    {
        $files = [];
        foreach (self::scenarios() as $name => $s) {
            $files['golden/' . $name . '.l98'] = 2 * ($s['teams'] - 1);
        }
        return $files;
    }

    public static function writeAll(string $sourceLmoDir, string $targetDir): void
    {
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }
        foreach (self::scenarios() as $name => $scenario) {
            $template = sprintf('%s/ligen/dfb/%02der-liga.l98', $sourceLmoDir, $scenario['teams']);
            if (!is_file($template)) {
                throw new RuntimeException("Vorlage fehlt: $template");
            }
            file_put_contents(
                $targetDir . '/' . $name . '.l98',
                self::build($name, $scenario, (string)file_get_contents($template))
            );
        }
    }

    private static function build(string $name, array $scenario, string $content): string
    {
        $eol = strpos($content, "\r\n") !== false ? "\r\n" : "\n";
        $lines = preg_split('/\r\n|\n|\r/', $content);

        $teams = $scenario['teams'];
        $rounds = 2 * ($teams - 1);
        $matches = intdiv($teams, 2);
        $results = self::results($name, $scenario, $rounds, $matches);

        $options = ['Name' => $name] + ($scenario['options'] ?? []);
        $section = '';
        /** @var array<int|string, bool> $seen */
        $seen = [];
        $out = [];

        $flush = static function (string $closing) use (&$out, &$seen, &$options, $scenario): void {
            // Fehlende Schluessel am Ende der Sektion nachtragen.
            if ($closing === 'Options') {
                foreach ($options as $key => $value) {
                    if (!isset($seen[$key])) {
                        $out[] = $key . '=' . $value;
                    }
                }
            } elseif (preg_match('/^Team(\d+)$/', $closing, $m)) {
                foreach (($scenario['teamKeys'][(int)$m[1]] ?? []) as $key => $value) {
                    if (!isset($seen[$key])) {
                        $out[] = $key . '=' . $value;
                    }
                }
            }
            $seen = [];
        };

        foreach ($lines as $line) {
            if (preg_match('/^\[(.+)\]$/', $line, $m)) {
                $flush($section);
                $section = $m[1];
                $out[] = $line;
                if (preg_match('/^Round(\d+)$/', $section, $r)) {
                    foreach (self::roundExtras($scenario, (int)$r[1], $matches, $results) as $extra) {
                        $out[] = $extra;
                    }
                }
                continue;
            }

            if ($section !== '' && strpos($line, '=') !== false) {
                [$key, $value] = explode('=', $line, 2);
                $seen[$key] = true;

                if ($section === 'Options' && array_key_exists($key, $options)) {
                    $value = (string)$options[$key];
                } elseif (preg_match('/^Team(\d+)$/', $section, $t)
                    && isset($scenario['teamKeys'][(int)$t[1]][$key])) {
                    $value = (string)$scenario['teamKeys'][(int)$t[1]][$key];
                } elseif (preg_match('/^Round(\d+)$/', $section, $r)
                    && preg_match('/^(GA|GB)(\d+)$/', $key, $g)) {
                    $entry = $results[(int)$r[1]][(int)$g[2]] ?? null;
                    if ($entry !== null) {
                        $value = $entry[$g[1]];
                    }
                }
                $out[] = $key . '=' . $value;
                continue;
            }

            $out[] = $line;
        }
        $flush($section);

        return implode($eol, $out);
    }

    /**
     * Ergebnisse je Spieltag und Spiel (1-basiert). Nicht gespielte Spiele fehlen.
     *
     * @return array<int,array<int,array<string,string>>>
     */
    private static function results(string $name, array $scenario, int $rounds, int $matches): array
    {
        mt_srand(self::SEED + (int)sprintf('%u', crc32($name)) % 1000003);
        $results = [];
        for ($round = 1; $round <= $rounds; $round++) {
            for ($match = 1; $match <= $matches; $match++) {
                $played = (mt_rand(0, 999) / 1000) < $scenario['played'];
                $homeGoals = mt_rand(0, $scenario['maxGoals']);
                $awayGoals = mt_rand(0, $scenario['maxGoals']);
                $kind = mt_rand(0, $scenario['kindRange'] ?? 11);
                $special = mt_rand(0, 2);
                if (!$played) {
                    continue;
                }
                $entry = ['GA' => (string)$homeGoals, 'GB' => (string)$awayGoals];
                if (!empty($scenario['wertung'])) {
                    // -2 = Spiel am gruenen Tisch gewertet, ET=3 = nur Tore, ohne Wertung
                    if ($kind === 0) {
                        $entry = ['GA' => '-2', 'GB' => '0'];
                    } elseif ($kind === 1) {
                        $entry = ['GA' => '0', 'GB' => '-2'];
                    } elseif ($kind === 2) {
                        $entry['ET'] = '3';
                    }
                }
                if (!empty($scenario['special'])) {
                    $entry['SP'] = (string)$special;
                }
                $results[$round][$match] = $entry;
            }
        }
        return $results;
    }

    /**
     * Zusaetzliche Zeilen direkt hinter [RoundN]: Handicap-Reihenfolge, Sonderwertung, Zusatzmarker.
     *
     * @return string[]
     */
    private static function roundExtras(array $scenario, int $round, int $matches, array $results): array
    {
        $extra = [];
        if (!empty($scenario['handicap'])) {
            $ranks = range(1, $scenario['teams']);
            // deterministische, spieltagsabhaengige Reihenfolge
            for ($i = 0; $i < $round % $scenario['teams']; $i++) {
                $ranks[] = array_shift($ranks);
            }
            $extra[] = 'HS=' . implode('', array_map(static function ($rank) {
                return sprintf('%02d', $rank);
            }, $ranks));
        }
        for ($match = 1; $match <= $matches; $match++) {
            $entry = $results[$round][$match] ?? null;
            if ($entry === null) {
                continue;
            }
            if (isset($entry['SP'])) {
                $extra[] = 'SP' . $match . '=' . $entry['SP'];
            }
            if (isset($entry['ET'])) {
                $extra[] = 'ET' . $match . '=' . $entry['ET'];
            }
        }
        return $extra;
    }
}
