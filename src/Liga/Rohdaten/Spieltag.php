<?php

namespace Lmo\Liga\Rohdaten;

/**
 * Ein Spieltag (im Pokal: eine Runde), wie er in der Ligadatei im Abschnitt [RoundN] steht.
 */
final class Spieltag
{
    /**
     * Werte des Spieltags in der Reihenfolge der Datei: D1/D2 (erster und letzter Tag), HS
     * (Handicap-Reihenfolge), im Pokal MO (Spiele je Paarung) und alles, was sich keiner Partie
     * zuordnen laesst.
     *
     * @var array<string, string>
     */
    public array $werte = [];

    /**
     * @var array<int, Partie> Nummer der Partie (ab 1) => Partie
     */
    public array $partien = [];
}
