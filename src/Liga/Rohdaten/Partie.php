<?php

namespace Lmo\Liga\Rohdaten;

/**
 * Eine Partie eines Spieltags (im Pokal: eine Paarung), wie sie in der Ligadatei steht.
 *
 * Heim und Gast sind die Nummern der Mannschaften (TA, TB). Die uebrigen Werte gehoeren zu einem
 * Spiel: in der Liga gibt es genau eines (Nummer 1), im Pokal so viele, wie der Modus der Runde
 * vorsieht (Hin- und Rueckspiel ...). null heisst: steht nicht in der Datei.
 */
final class Partie
{
    public ?string $heim = null;
    public ?string $gast = null;

    /**
     * Je Spiel die Werte in der Reihenfolge der Datei, unveraendert:
     * GA/GB (Tore; -1 = nicht gespielt, in der Liga -2 = Wertung am gruenen Tisch gegen diese Seite),
     * ET (3 = Wertung gegen beide), SP (0 = ohne, 1 = im Elfmeterschiessen, 2 = nach Verlaengerung),
     * NT (Notiz), BE (Spielbericht), TI (Tipp), AT (Anstoss als Unix-Zeitstempel) und Unbekanntes.
     *
     * @var array<int, array<string, string>> Nummer des Spiels (ab 1) => Schluessel ohne Nummer => Wert
     */
    public array $spiele = [];

    /**
     * Ein leerer Platz im Spielplan, so wie der LMO ihn nach dem Loeschen einer Partie schreibt:
     * keine Mannschaften, nicht gespielt, kein Anstoss. Der Zusatz "_" steht fuer "kein Zusatz"
     * und kommt nur in die Datei, wenn die Liga Verlaengerung und Elfmeterschiessen fuehrt.
     */
    public static function leer(): self
    {
        $partie = new self();
        $partie->heim = '0';
        $partie->gast = '0';
        $partie->spiele[1] = ['GA' => '-1', 'GB' => '-1', 'SP' => '_', 'NT' => '', 'BE' => '', 'TI' => '', 'AT' => ''];

        return $partie;
    }
}
