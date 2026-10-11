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
 * Was die Werte bedeuten, weiss diese Klasse nicht; das ist Sache von LigaDaten und der classlib.
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
}
