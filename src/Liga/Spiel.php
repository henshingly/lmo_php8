<?php

namespace Lmo\Liga;

/**
 * Ein Spiel zum Anzeigen: was die Seiten des LMO von einer Partie zeigen, abgeleitet aus den
 * Rohdaten und mit festen Typen. In der Liga hat jede Partie ein Spiel, im Pokal eine Paarung so
 * viele, wie der Modus der Runde vorsieht.
 *
 * Die Klasse liest nur; die Rohdaten bleiben, wie sie in der Datei stehen. Fehlt eine Partie oder
 * ein Wert, gelten die Werte eines nicht angesetzten Spiels (keine Mannschaft, nicht gespielt).
 *
 *   foreach ($liga->spiele(3) as $spiel) {
 *       echo $liga->mannschaftsname($spiel->heim), ' ', $spiel->toreHeimText(), ':', $spiel->toreGastText();
 *   }
 */
final class Spiel
{
    /** Nummer des Spieltags (im Pokal: der Runde), ab 1 */
    public int $spieltag;

    /** Nummer der Partie (im Pokal: der Paarung) im Spieltag, ab 1 */
    public int $partie;

    /** Nummer des Spiels der Paarung, ab 1; in der Liga immer 1 */
    public int $nr;

    /** Nummer der Heimmannschaft, 0 = keine */
    public int $heim = 0;

    /** Nummer der Gastmannschaft, 0 = keine */
    public int $gast = 0;

    /**
     * Tore der Heimmannschaft; null = nicht gespielt. Bei einer Wertung am gruenen Tisch gegen
     * diese Seite (Liga) 0. Zum Anzeigen: toreHeimText().
     */
    public ?int $toreHeim = null;

    /** Tore der Gastmannschaft, wie $toreHeim */
    public ?int $toreGast = null;

    /** Wertung am gruenen Tisch (nur Liga): 0 = keine, 1 = fuer Heim, 2 = fuer Gast, 3 = gegen beide */
    public int $wertung = 0;

    /**
     * Zusatz zum Ergebnis: 0 = ausdruecklich keiner, 1 = im Elfmeterschiessen, 2 = nach
     * Verlaengerung; null = steht nicht in der Datei oder die Liga fuehrt keinen Zusatz (Spez).
     * Zum Anzeigen: zusatzText().
     */
    public ?int $zusatz = null;

    /** Notiz zum Spiel */
    public string $notiz = '';

    /** Link zum Spielbericht */
    public string $bericht = '';

    /** TI=1 in der Datei: das Spiel wird im Tippspiel nicht gewertet */
    public bool $ohneTippwertung = false;

    /**
     * Anstoss als Unix-Zeitstempel; null = keiner festgelegt (in der Datei 0, leer, unlesbar
     * oder gar nicht genannt).
     */
    public ?int $anstoss = null;

    private function __construct(int $spieltag, int $partie, int $nr)
    {
        $this->spieltag = $spieltag;
        $this->partie = $partie;
        $this->nr = $nr;
    }

    /**
     * Das Spiel einer Partie aus den Rohdaten der Liga.
     *
     * @param int $nr Spiel der Paarung im Pokal (1 = Hinspiel ...); in der Liga 1
     */
    public static function ausRohdaten(Rohdaten\Liga $liga, int $spieltag, int $partie, int $nr = 1): self
    {
        $spiel = new self($spieltag, $partie, $nr);
        $roh = $liga->spieltage[$spieltag]->partien[$partie] ?? null;
        if ($roh === null) {
            return $spiel;
        }
        $pokal = $liga->istPokal();
        $spiel->heim = self::zahl($roh->heim) ?? 0;
        $spiel->gast = self::zahl($roh->gast) ?? 0;
        foreach ($roh->spiele[$nr] ?? [] as $art => $wert) {
            switch ($art) {
                case 'GA':
                case 'GB':
                    // -1 heisst in der Datei "nicht gespielt", ebenso eine leere oder unlesbare Angabe
                    $tore = self::zahl($wert);
                    if ($tore === -1) {
                        $tore = null;
                    }
                    if (!$pokal && $tore === -2) {
                        $spiel->wertung = $art === 'GA' ? 1 : 2;
                        $tore = 0;
                    }
                    if ($art === 'GA') {
                        $spiel->toreHeim = $tore;
                    } else {
                        $spiel->toreGast = $tore;
                    }
                    break;
                case 'ET':
                    if (!$pokal && $wert == 3) {
                        $spiel->wertung = 3;
                    }
                    break;
                case 'SP':
                    // in der Liga nur, wenn sie Verlaengerung und Elfmeterschiessen fuehrt
                    if ($pokal || $liga->einstellungen()->mitVerlaengerung()) {
                        $spiel->zusatz = self::zahl($wert);
                    }
                    break;
                case 'NT':
                    $spiel->notiz = $wert;
                    break;
                case 'BE':
                    $spiel->bericht = $wert;
                    break;
                case 'TI':
                    $spiel->ohneTippwertung = $wert == 1;
                    break;
                case 'AT':
                    $anstoss = self::zahl($wert);
                    $spiel->anstoss = $anstoss !== null && $anstoss > 0 ? $anstoss : null;
                    break;
            }
        }

        return $spiel;
    }

    /** Ist das Spiel angesetzt, steht also eine Heimmannschaft fest? */
    public function hatMannschaften(): bool
    {
        return $this->heim > 0;
    }

    /** Liegt ein Ergebnis vor? */
    public function istGespielt(): bool
    {
        return $this->toreHeim !== null && $this->toreGast !== null;
    }

    /**
     * Tore der Heimmannschaft als Anzeigetext: "_" fuer nicht gespielt, sonst die Tore geteilt
     * durch den Torfaktor der Liga.
     *
     * @param int $torfaktor Einstellungen::torfaktor(); 1 = Tore wie eingegeben
     */
    public function toreHeimText(int $torfaktor = 1): string
    {
        return self::toreText($this->toreHeim, $torfaktor);
    }

    /** Tore der Gastmannschaft als Anzeigetext, wie toreHeimText() */
    public function toreGastText(int $torfaktor = 1): string
    {
        return self::toreText($this->toreGast, $torfaktor);
    }

    /**
     * Der Zusatz zum Ergebnis als Anzeigetext.
     *
     * @param string $nachVerlaengerung Text fuer "nach Verlaengerung" (Sprachtext 0)
     * @param string $imElfmeterschiessen Text fuer "im Elfmeterschiessen" (Sprachtext 1)
     * @return string '' ohne Angabe, "&nbsp;" fuer "kein Zusatz"
     */
    public function zusatzText(string $nachVerlaengerung, string $imElfmeterschiessen): string
    {
        if ($this->zusatz === null) {
            return '';
        }
        if ($this->zusatz === 0) {
            return '&nbsp;';
        }
        if ($this->zusatz === 2) {
            return $nachVerlaengerung;
        }

        return $this->zusatz === 1 ? $imElfmeterschiessen : (string) $this->zusatz;
    }

    private static function toreText(?int $tore, int $torfaktor): string
    {
        if ($tore === null) {
            return '_';
        }

        return (string) ($tore !== 0 && $torfaktor !== 0 ? $tore / $torfaktor : $tore);
    }

    /** Eine ganze Zahl aus der Datei; null, wenn dort keine steht */
    private static function zahl(?string $wert): ?int
    {
        return $wert !== null && is_numeric($wert) ? (int) $wert : null;
    }
}
