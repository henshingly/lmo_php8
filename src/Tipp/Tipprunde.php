<?php

namespace Lmo\Tipp;

use Lmo\Liga\Paarung;
use Lmo\Liga\Rohdaten\Liga;
use Lmo\Liga\Rohdaten\Spieltag;

/**
 * Ein Spieltag (im Pokal: eine Runde) einer Liga aus Sicht des Tippspiels: die Paarungen, die auf
 * den Seiten zur Tippabgabe und zur Einsicht stehen, unter denselben Nummern wie die Tipps.
 *
 * Die Klasse liest nur; die Rohdaten bleiben, wie sie in der Datei stehen.
 *
 *   $runde = Tipprunde::fuer($liga, 26);
 *   foreach ($runde->paarungen as $i => $paarung) { ... }   // $i ab 0, wie in den Tippdateien
 */
final class Tipprunde
{
    /** Nummer des Spieltags bzw. der Runde, ab 1 */
    public int $nr;

    /** Pokal (KO-Modus) oder Liga */
    public bool $pokal;

    /** Anzahl der Spieltage bzw. Runden der Liga */
    public int $runden;

    /** Erster Tag des Spieltags als TT.MM.JJJJ, sonst '' */
    public string $ersterTag;

    /** Letzter Tag des Spieltags als TT.MM.JJJJ, sonst '' */
    public string $letzterTag;

    /** Spiele je Paarung: in der Liga eines, im Pokal nach dem Modus der Runde */
    public int $spieleJePaarung;

    /**
     * Anzahl der Paarungen, wie das Tippspiel sie zaehlt: in der Liga die Partien je Spieltag, im
     * Pokal die Zahl der Mannschaften je Runde halbiert, im Finale mit Spiel um Platz 3 eine mehr.
     * Bei einer Mannschaftszahl, die keine Zweierpotenz ist, ergibt das im Pokal eine Kommazahl;
     * die Seiten zaehlen dann wie bisher bis zur naechsten ganzen Zahl.
     *
     * @var int|float
     */
    public $plaetze;

    /**
     * Die Paarungen der Runde zum Anzeigen, Index ab 0 (Paarung 1 hat den Index 0), jede mit so
     * vielen Spielen wie $spieleJePaarung.
     *
     * @var list<Paarung>
     */
    public array $paarungen = [];

    private function __construct(int $nr, bool $pokal, int $runden, Spieltag $spieltag, int $spieleJePaarung)
    {
        $this->nr = $nr;
        $this->pokal = $pokal;
        $this->runden = $runden;
        $this->ersterTag = $spieltag->ersterTagText();
        $this->letzterTag = $spieltag->letzterTagText();
        $this->spieleJePaarung = $spieleJePaarung;
        $this->plaetze = 0;
    }

    public static function fuer(Liga $liga, int $nr): self
    {
        $e = $liga->einstellungen();
        $runde = new self(
            $nr,
            $e->istPokal(),
            $e->spieltage(),
            $liga->spieltage[$nr] ?? new Spieltag(),
            Paarung::spieleJePaarung($liga, $nr)
        );
        $plaetze = $e->partienJeSpieltag();
        if ($runde->pokal) {
            $plaetze = $e->mannschaften();
            for ($i = 0; $i < $nr; $i++) {
                $plaetze /= 2;
            }
            if ($e->mitSpielUmPlatz3() && $nr === $runde->runden) {
                $plaetze++;
            }
        }
        $runde->plaetze = $plaetze;
        for ($i = 0; $i < $plaetze; $i++) {
            $runde->paarungen[] = Paarung::ausRohdaten($liga, $nr, $i + 1, $runde->spieleJePaarung);
        }

        return $runde;
    }
}
