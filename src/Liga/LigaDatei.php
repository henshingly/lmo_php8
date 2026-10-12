<?php

namespace Lmo\Liga;

/**
 * Liest das Format einer Ligadatei (.l98): Abschnitte in eckigen Klammern, darunter
 * Zeilen "Schluessel=Wert".
 *
 *   [Options]
 *   Name=1. Bundesliga
 *   ;eine Zeile mit Semikolon am Anfang ist ein Kommentar
 *   [Round1]
 *   TA1=3
 *
 * Gelesen wird zeilenweise: Ein Abschnitt beginnt nur mit einer Zeile, die als Ganzes in
 * eckigen Klammern steht. Eckige Klammern und weitere "=" in einem Wert gehoeren zum Wert.
 * Geschrieben wird mit einer Leerzeile zwischen den Abschnitten und Zeilenende LF.
 * Was die Werte bedeuten, weiss diese Klasse nicht; das ist Sache von Rohdaten\Liga.
 */
final class LigaDatei
{
    /**
     * Zerlegt die Zeilen einer Ligadatei.
     *
     * @param iterable<string> $zeilen Zeilen mit oder ohne Zeilenende
     * @return list<array{string, string, string}> je Zeile "Schluessel=Wert": Abschnitt, Schluessel, Wert
     *         in der Reihenfolge der Datei; Zeilen vor dem ersten Abschnitt haben den Abschnitt ''
     */
    public static function zerlege(iterable $zeilen): array
    {
        $eintraege = [];
        $abschnitt = '';
        foreach ($zeilen as $zeile) {
            $zeile = trim($zeile);
            if (substr($zeile, 0, 1) === '[' && substr($zeile, -1) === ']') {
                $abschnitt = trim(substr($zeile, 1, -1));
            } elseif (strpos($zeile, '=') !== false && substr($zeile, 0, 1) !== ';') {
                [$schluessel, $wert] = explode('=', $zeile, 2);
                $eintraege[] = [$abschnitt, trim($schluessel), trim($wert)];
            }
        }

        return $eintraege;
    }

    /**
     * Liest eine Ligadatei. Eine fehlende oder nicht lesbare Datei ergibt eine leere Liste.
     *
     * @return list<array{string, string, string}> wie zerlege()
     */
    public static function lies(string $pfad): array
    {
        $zeilen = is_file($pfad) ? @file($pfad) : false;

        return $zeilen === false ? [] : self::zerlege($zeilen);
    }

    /**
     * Liest nur einen Abschnitt einer Ligadatei, z. B. [Options] fuer eine Liste aller Ligen.
     * Die Datei wird nur bis zum Ende dieses Abschnitts gelesen; steht er mehrfach in der Datei,
     * zaehlt der erste. Eine fehlende oder nicht lesbare Datei ergibt ein leeres Array.
     *
     * @return array<string, string> Schluessel => Wert; bei doppelten Schluesseln gilt der letzte
     */
    public static function liesAbschnitt(string $pfad, string $abschnitt): array
    {
        $datei = is_file($pfad) ? @fopen($pfad, 'rb') : false;
        if ($datei === false) {
            return [];
        }
        $werte = [];
        $aktuell = null;
        while (($zeile = fgets($datei)) !== false) {
            $zeile = trim($zeile);
            if (substr($zeile, 0, 1) === '[' && substr($zeile, -1) === ']') {
                if ($aktuell === $abschnitt) {
                    break;
                }
                $aktuell = trim(substr($zeile, 1, -1));
            } elseif ($aktuell === $abschnitt && strpos($zeile, '=') !== false && substr($zeile, 0, 1) !== ';') {
                [$schluessel, $wert] = explode('=', $zeile, 2);
                $werte[trim($schluessel)] = trim($wert);
            }
        }
        fclose($datei);

        return $werte;
    }

    /**
     * Fasst aufeinanderfolgende Eintraege desselben Abschnitts zusammen.
     *
     * @param list<array{string, string, string}> $eintraege Ergebnis von zerlege()
     * @return list<array{string, list<string>, list<string>}> je Abschnitt: Name, Schluessel, Werte.
     *         Steht ein Abschnitt mehrfach in der Datei, erscheint er mehrfach.
     */
    public static function abschnitte(array $eintraege): array
    {
        $abschnitte = [];
        $name = null;
        $schluessel = $werte = [];
        foreach ($eintraege as [$abschnitt, $einSchluessel, $wert]) {
            if ($name !== null && $name !== $abschnitt) {
                $abschnitte[] = [$name, $schluessel, $werte];
                $schluessel = $werte = [];
            }
            $name = $abschnitt;
            $schluessel[] = $einSchluessel;
            $werte[] = $wert;
        }
        if ($name !== null) {
            $abschnitte[] = [$name, $schluessel, $werte];
        }

        return $abschnitte;
    }

    /**
     * Die Zeilen der Abschnitte als flache Liste, wie zerlege() sie liefert.
     *
     * @param iterable<array{string, iterable<array{string, string}>}> $abschnitte je Abschnitt: Name, dann Schluessel und Wert je Zeile
     * @return list<array{string, string, string}> Abschnitt, Schluessel, Wert
     */
    public static function eintraege(iterable $abschnitte): array
    {
        $eintraege = [];
        foreach ($abschnitte as [$abschnitt, $zeilen]) {
            foreach ($zeilen as [$schluessel, $wert]) {
                $eintraege[] = [$abschnitt, $schluessel, $wert];
            }
        }

        return $eintraege;
    }

    /**
     * Die Abschnitte als Text einer Ligadatei. Gegenstueck zu zerlege(); ein Abschnitt ohne Zeilen
     * besteht nur aus seiner Kopfzeile.
     *
     * @param iterable<array{string, iterable<array{string, string}>}> $abschnitte je Abschnitt: Name, dann Schluessel und Wert je Zeile
     */
    public static function alsText(iterable $abschnitte): string
    {
        $text = '';
        foreach ($abschnitte as [$abschnitt, $zeilen]) {
            $text .= ($text === '' ? '' : "\n") . '[' . $abschnitt . "]\n";
            foreach ($zeilen as [$schluessel, $wert]) {
                $text .= $schluessel . '=' . $wert . "\n";
            }
        }

        return $text;
    }

    /**
     * Schreibt eine Ligadatei; waehrenddessen ist sie fuer andere gesperrt. Gegenstueck zu lies().
     *
     * @param iterable<array{string, iterable<array{string, string}>}> $abschnitte wie alsText()
     * @return bool false, wenn sich die Datei nicht schreiben laesst
     */
    public static function schreibe(string $pfad, iterable $abschnitte): bool
    {
        $datei = @fopen($pfad, 'wb');
        if ($datei === false) {
            return false;
        }
        flock($datei, LOCK_EX);
        $geschrieben = fwrite($datei, self::alsText($abschnitte)) !== false;
        fflush($datei);
        flock($datei, LOCK_UN);
        fclose($datei);

        return $geschrieben;
    }
}
