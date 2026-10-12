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

    /**
     * Der Rekord als Anzeigetext, je Spiel eine Zeile (getrennt mit <br>):
     * "3:0 gegen Mannschaft (H)". Ohne Spiel "&nbsp;".
     *
     * @param int $torfaktor Einstellungen::torfaktor()
     * @param string $gegen Wort zwischen Ergebnis und Gegner (Sprachtext 72)
     * @param string $daheim Zusatz fuer ein Spiel, das aus Sicht der Heimmannschaft gewertet wurde (Sprachtext 73)
     * @param string $auswaerts Zusatz fuer ein Auswaertsspiel (Sprachtext 74)
     * @param string $ohneGegner Name, wenn der Gegner nicht feststeht
     */
    public function alsText(int $torfaktor, string $gegen, string $daheim, string $auswaerts, string $ohneGegner = '___'): string
    {
        $zeilen = $this->beginntLeer || $this->spiele === [] ? ['&nbsp;'] : [];
        foreach ($this->spiele as [$spiel, $heimsicht]) {
            if ($heimsicht) {
                $gegner = $spiel->gast > 0 ? $spiel->gastMannschaft()->anzeigename() : $ohneGegner;
                $zeilen[] = $spiel->toreHeimText($torfaktor) . ':' . $spiel->toreGastText($torfaktor) . ' ' . $gegen . ' ' . $gegner . ' ' . $daheim;
            } else {
                $gegner = $spiel->heim > 0 ? $spiel->heimMannschaft()->anzeigename() : $ohneGegner;
                $zeilen[] = $spiel->toreGastText($torfaktor) . ':' . $spiel->toreHeimText($torfaktor) . ' ' . $gegen . ' ' . $gegner . ' ' . $auswaerts;
            }
        }

        return implode('<br>', $zeilen);
    }
}
