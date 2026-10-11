<?php

namespace Lmo\Liga;

/**
 * Eine Zeile der Tabelle: die Bilanz einer Mannschaft. Gerechnet von Tabelle.
 */
final class Tabellenzeile
{
    /** Nummer der Mannschaft, ab 1 */
    public int $mannschaft;

    public int $spiele = 0;
    public int $siege = 0;
    public int $unentschieden = 0;
    public int $niederlagen = 0;

    /** Pluspunkte, Strafpunkte schon abgezogen */
    public int $punkte = 0;

    /** Minuspunkte; nur gefuehrt, wenn die Liga Minuspunkte hat (Einstellungen::mitMinuspunkten()) */
    public int $minuspunkte = 0;

    /** Erzielte Tore, Torkorrektur schon eingerechnet */
    public int $tore = 0;

    /** Gegentore, Torkorrektur schon eingerechnet */
    public int $gegentore = 0;

    /** Siege in Folge bis zum letzten gewerteten Spiel */
    public int $serieSiege = 0;

    /** Spiele in Folge ohne Niederlage */
    public int $serieUngeschlagen = 0;

    /** Niederlagen in Folge */
    public int $serieNiederlagen = 0;

    /** Spiele in Folge ohne Sieg */
    public int $serieSieglos = 0;

    /** Hoechster Sieg: groesste Tordifferenz, bei gleicher Differenz die meisten eigenen Tore */
    public Rekord $hoechsterSieg;

    /** Hoechste Niederlage: kleinste Tordifferenz, bei gleicher Differenz die wenigsten eigenen Tore */
    public Rekord $hoechsteNiederlage;

    public function __construct(int $mannschaft)
    {
        $this->mannschaft = $mannschaft;
        $this->hoechsterSieg = new Rekord();
        $this->hoechsteNiederlage = new Rekord();
    }

    public function tordifferenz(): int
    {
        return $this->tore - $this->gegentore;
    }

    /**
     * Traegt ein gewertetes Spiel ein.
     *
     * @param int $ausgang 1 = Sieg, 0 = Unentschieden, -1 = Niederlage
     * @param array{int, int, int} $punkte Punkte der Liga fuer Sieg, Unentschieden, Niederlage in diesem Spiel
     * @param bool $mitMinuspunkten fuehrt die Liga Minuspunkte?
     * @param Spiel $spiel das Spiel, fuer hoechsten Sieg und hoechste Niederlage
     * @param bool $heimsicht wurde das Spiel aus Sicht der Heimmannschaft gewertet?
     */
    public function werte(int $ausgang, int $tore, int $gegentore, array $punkte, bool $mitMinuspunkten, Spiel $spiel, bool $heimsicht): void
    {
        [$sieg, $unentschieden, $niederlage] = $punkte;
        $this->spiele++;
        $this->tore += $tore;
        $this->gegentore += $gegentore;
        if ($ausgang > 0) {
            $this->siege++;
            $this->punkte += $sieg;
            $this->minuspunkte += $mitMinuspunkten ? $niederlage : 0;
            $this->serieSiege++;
            $this->serieUngeschlagen++;
            $this->serieNiederlagen = 0;
            $this->serieSieglos = 0;
            $this->hoechsterSieg->pruefe($tore, $gegentore, $spiel, $heimsicht, 1);
        } elseif ($ausgang < 0) {
            $this->niederlagen++;
            $this->punkte += $niederlage;
            $this->minuspunkte += $mitMinuspunkten ? $sieg : 0;
            $this->serieNiederlagen++;
            $this->serieSieglos++;
            $this->serieSiege = 0;
            $this->serieUngeschlagen = 0;
            $this->hoechsteNiederlage->pruefe($tore, $gegentore, $spiel, $heimsicht, -1);
        } else {
            $this->unentschieden++;
            $this->punkte += $unentschieden;
            $this->minuspunkte += $mitMinuspunkten ? $unentschieden : 0;
            $this->serieSiege = 0;
            $this->serieUngeschlagen++;
            $this->serieNiederlagen = 0;
            $this->serieSieglos++;
        }
    }
}
