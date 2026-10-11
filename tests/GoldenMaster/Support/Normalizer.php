<?php

namespace Lmo\Tests\GoldenMaster\Support;

/**
 * Macht Ausgaben vergleichbar: entfernt Laufzeit-Zufaelliges (Session-IDs,
 * Temp-Pfade, Zufallsfarben) und vereinheitlicht Whitespace.
 *
 * Die Whitespace-Normalisierung ist Absicht: Beim Umstellen auf Twig aendern
 * sich Einrueckung und Zeilenumbrueche, nicht aber die Struktur. Verglichen wird
 * deshalb eine kanonische Form mit einem Tag pro Zeile.
 */
final class Normalizer
{
    public static function html(string $html, string $instancePath, string $query = ''): string
    {
        $html = str_replace($instancePath, '{LMO_PATH}', $html);
        $html = str_replace("\r\n", "\n", $html);

        // Stack-Traces von PHP-Fehlern nennen die Hilfsskripte der Tests samt Zeilennummer
        // (z. B. ".../bin/http.php(57)"). Aendert sich ein Hilfsskript, verschiebt sich die Zeile.
        $html = preg_replace('#\S*/tests/GoldenMaster/bin/(\w+\.php)\(\d+\)#', '{HARNESS}/$1(N)', $html);
        // Dasselbe fuer die aufrufenden LMO-Dateien im Stack-Trace ("#0 {LMO_PATH}/lmoadmin.php(69)"):
        // neue Zeilen oberhalb des Aufrufs sind keine Verhaltensaenderung. Die Fehlerstelle selbst
        // ("... on line 235") bleibt im Vergleich.
        $html = preg_replace('#(\#\d+ \{LMO_PATH\}/[\w./-]+\.php)\(\d+\)#', '$1(N)', $html);
        // Notices nennen das Hilfsskript ohne Zeilen-Klammer ("started from /app/tests/GoldenMaster/bin/
        // http.php on line 50"); der Checkout-Pfad unterscheidet sich zwischen Docker und GitHub.
        $html = preg_replace('#\S*/tests/GoldenMaster/bin/(\w+\.php) on line \d+#', '{HARNESS}/$1 on line N', $html);

        // PHP nennt den include_path in "Failed opening required"-Meldungen. Er haengt von der
        // Umgebung ab (Composer-PEAR-Pfade, /usr/local/lib/php im Docker-Image, /usr/share/php auf GitHub).
        $html = preg_replace("/\\(include_path='[^']*'\\)/", "(include_path='{INCLUDE_PATH}')", $html);

        // Info-Seite: Die Version nennt Composer (Git-Tag); im Checkout ist es je nach Branch "dev".
        $html = preg_replace('#( - Vers\. )[^<\s]+#', '$1{LMO_VERSION}', $html);

        // Session-ID in Links und Formularen (session.use_trans_sid)
        $html = preg_replace('/PHPSESSID=[A-Za-z0-9,-]+/', 'PHPSESSID={SID}', $html);
        $html = preg_replace('/(name="PHPSESSID"\s+value=")[^"]*(")/', '$1{SID}$2', $html);

        // Fieberkurve: Teamfarben sind zufaellig (mt_rand ohne Seed)
        if (strpos($query, 'action=graph') !== false) {
            $html = preg_replace('/\b\d{1,3},\d{1,3},\d{1,3},1\b/', '{RGBA}', $html);
        }

        return self::sortLangSelector(self::canonical($html));
    }

    /**
     * Sprachauswahl in der Fusszeile (getLangSelector) sortieren: Die Reihenfolge kommt aus
     * readdir() und haengt damit vom Dateisystem ab (Docker-Volume vs. GitHub-Runner).
     * Erwartet die kanonische Form; ein Eintrag ist entweder ein Link (3 Zeilen) oder das
     * Bild der aktuellen Sprache (1 Zeile), sortiert wird nach dem Sprachnamen. Folgt der
     * Bearbeiten-Link (" >> "), haengt dessen ">>" ohne Zeilenumbruch am letzten Eintrag.
     */
    public static function sortLangSelector(string $html): string
    {
        $entry = static fn (string $end): string => '(?:<a href="[^"\n]*lmouserlang=[^"\n]*" title="[^"\n]*">\n<img [^\n]*>\n</a>'
            . $end . '|<img src="[^"\n]*\.selected\.svg"[^\n]*?>' . $end . ')';
        return preg_replace_callback('~(?:' . $entry('(?:\n|(?=>>))') . '){2,}~', static function (array $m) use ($entry): string {
            // Im ausgeschnittenen Block fehlt das folgende ">>", der letzte Eintrag endet dort am Textende.
            preg_match_all('~' . $entry('(?:\n|$)') . '~', $m[0], $parts);
            $tail = str_ends_with($m[0], "\n") ? "\n" : '';
            $items = array_map(static fn (string $i): string => rtrim($i, "\n"), $parts[0]);
            usort($items, static function (string $a, string $b): int {
                preg_match('/title="([^"]*)"/', $a, $ta);
                preg_match('/title="([^"]*)"/', $b, $tb);
                return strcmp($ta[1], $tb[1]);
            });
            return implode("\n", $items) . $tail;
        }, $html);
    }

    /**
     * Admin-Seiten: wie html(), zusaetzlich wird die Laufzeitanzeige in der Fusszeile
     * ("<Text>: 0.0123 sek.") durch einen Platzhalter ersetzt.
     */
    public static function admin(string $html, string $instancePath, string $query = ''): string
    {
        $html = preg_replace('/(<td class="lmoFooter" align="right">[^<]*?: )\d+\.\d{4}( )/', '$1{ZEIT}$2', $html);
        // "Letztes Update der Liga: <Datum Uhrzeit>" zeigt die Aenderungszeit der Ligadatei. Nach einem
        // Speichern ist das die echte Uhrzeit (die Dateizeit unterliegt nicht der festen Testuhr).
        $html = preg_replace(
            '/(<td class="lmoFooter" valign="bottom" align="right">[^<]*?&nbsp;)\d{2}\.\d{2}\.\d{4} \d{2}:\d{2}(<br>)/',
            '$1{STAND}$2',
            $html
        );
        return self::html($html, $instancePath, $query);
    }

    /** Whitespace zusammenfassen, ein Tag pro Zeile. */
    public static function canonical(string $html): string
    {
        $html = preg_replace('/[ \t\r\n]+/', ' ', $html);
        $html = preg_replace('/>\s*</', ">\n<", $html);
        $html = preg_replace('/\s+>/', '>', $html);
        return trim($html) . "\n";
    }
}
