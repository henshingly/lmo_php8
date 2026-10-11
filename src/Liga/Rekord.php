<?php

namespace Lmo\Liga;

/**
 * Hoechster Sieg oder hoechste Niederlage einer Mannschaft: das Ergebnis und alle Spiele, in denen
 * es erreicht wurde.
 */
final class Rekord
{
    /** Eigene Tore im Rekordspiel; 0, solange es keines gibt */
    public int $tore = 0;

    /** Gegentore im Rekordspiel */
    public int $gegentore = 0;

    /**
     * Die Spiele mit diesem Ergebnis in der Reihenfolge des Spielplans: je das Spiel und ob die
     * Mannschaft darin aus Sicht der Heimmannschaft gewertet wurde.
     *
     * @var list<array{Spiel, bool}>
     */
    public array $spiele = [];

    /**
     * Wurde ein Spiel mit 0:0 Toren (Wertung am gruenen Tisch) eingetragen, bevor es ein Spiel mit
     * Toren gab? Der LMO zeigt dann vor diesen Spielen eine leere Zeile; das bleibt so.
     */
    public bool $beginntLeer = false;

    /**
     * Prueft ein gewertetes Spiel gegen den bisherigen Rekord.
     *
     * @param int $richtung 1 = hoechster Sieg (groesser ist besser), -1 = hoechste Niederlage
     */
    public function pruefe(int $tore, int $gegentore, Spiel $spiel, bool $heimsicht, int $richtung): void
    {
        $differenz = ($tore - $gegentore) * $richtung;
        $bisher = ($this->tore - $this->gegentore) * $richtung;
        if ($differenz > $bisher || ($differenz === $bisher && $tore * $richtung > $this->tore * $richtung)) {
            $this->tore = $tore;
            $this->gegentore = $gegentore;
            $this->spiele = [[$spiel, $heimsicht]];
            $this->beginntLeer = false;
        } elseif ($differenz === $bisher && $tore === $this->tore) {
            if ($this->spiele === []) {
                $this->beginntLeer = true;
            }
            $this->spiele[] = [$spiel, $heimsicht];
        }
    }
}
