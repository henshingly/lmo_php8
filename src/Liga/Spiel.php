<?php

namespace Lmo\Liga;

/**
 * Ein Spiel zum Anzeigen: was die Seiten des LMO von einer Partie zeigen, abgeleitet aus den
 * Rohdaten. In der Liga hat jede Partie ein Spiel, im Pokal eine Paarung so viele, wie der Modus
 * der Runde vorsieht.
 *
 * Die Klasse liest nur; die Rohdaten bleiben, wie sie in der Datei stehen. Fehlt eine Partie oder
 * ein Wert, gelten die Werte eines nicht angesetzten Spiels (keine Mannschaft, nicht gespielt).
 *
 *   $spiel = Spiel::ausRohdaten($liga, 3, 1);   // Spieltag 3, Partie 1
 *   echo $liga->mannschaftsname($spiel->heim), ' ', $spiel->toreHeim, ':', $spiel->toreGast;
 */
final class Spiel
{
    /** Nummer des Spieltags (im Pokal: der Runde), ab 1 */
    public int $spieltag;

    /** Nummer der Partie (im Pokal: der Paarung) im Spieltag, ab 1 */
    public int $partie;

    /** Nummer des Spiels der Paarung, ab 1; in der Liga immer 1 */
    public int $nr;

    /** Nummer der Heimmannschaft, '0' = keine */
    public string $heim = '0';

    /** Nummer der Gastmannschaft, '0' = keine */
    public string $gast = '0';

    /**
     * Tore der Heimmannschaft: eine Zahl als Text, "_" = nicht gespielt, -1 = in der Datei leer.
     * Bei einer Wertung am gruenen Tisch gegen diese Seite (Liga) "0".
     *
     * @var int|string
     */
    public $toreHeim = '_';

    /** @var int|string Tore der Gastmannschaft, wie $toreHeim */
    public $toreGast = '_';

    /** Wertung am gruenen Tisch (nur Liga): 0 = keine, 1 = fuer Heim, 2 = fuer Gast, 3 = gegen beide */
    public int $wertung = 0;

    /**
     * Zusatz zum Ergebnis, wie er in der Datei steht: 1 = im Elfmeterschiessen, 2 = nach
     * Verlaengerung, 0 = keiner; null = steht nicht in der Datei oder die Liga fuehrt keinen
     * Zusatz (Spez). Zum Anzeigen: zusatzText().
     */
    public ?string $zusatz = null;

    /** Notiz zum Spiel */
    public string $notiz = '';

    /** Link zum Spielbericht */
    public string $bericht = '';

    /** TI aus der Datei: '1' = das Spiel wird im Tippspiel nicht gewertet */
    public string $tipp = '';

    /** Anstoss als Unix-Zeitstempel, '0' = keiner; in der Datei steht er als Text */
    public string $anstoss = '0';

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
        $spiel->heim = $roh->heim ?? '0';
        $spiel->gast = $roh->gast ?? '0';
        foreach ($roh->spiele[$nr] ?? [] as $art => $wert) {
            switch ($art) {
                case 'GA':
                case 'GB':
                    $tore = $wert == '' ? -1 : ($wert == '-1' ? '_' : $wert);
                    if (!$pokal && $wert == '-2') {
                        $spiel->wertung = $art === 'GA' ? 1 : 2;
                        $tore = '0';
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
                    if ($pokal || ($liga->optionen['Spez'] ?? null) == 1) {
                        $spiel->zusatz = $wert;
                    }
                    break;
                case 'NT':
                    $spiel->notiz = $wert;
                    break;
                case 'BE':
                    $spiel->bericht = $wert;
                    break;
                case 'TI':
                    $spiel->tipp = $wert;
                    break;
                case 'AT':
                    $spiel->anstoss = $wert;
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
        if ($this->zusatz == 0) {
            return '&nbsp;';
        }
        if ($this->zusatz == 2) {
            return $nachVerlaengerung;
        }

        return $this->zusatz == 1 ? $imElfmeterschiessen : $this->zusatz;
    }
}
