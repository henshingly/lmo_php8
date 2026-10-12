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

    /** Setzt die beiden Mannschaften (TA, TB); 0 = keine. */
    public function setzeMannschaften(int $heim, int $gast): void
    {
        $this->heim = (string) $heim;
        $this->gast = (string) $gast;
    }

    /**
     * Traegt das Ergebnis eines Spiels ein.
     *
     * @param int|null $toreHeim null = nicht gespielt (in der Datei -1)
     * @param int|null $toreGast null = nicht gespielt
     * @param int|null $wertung Wertung am gruenen Tisch (nur Liga): 0 = keine, 1 = fuer Heim, 2 = fuer Gast,
     *                          3 = gegen beide. In der Datei steht dafuer -2 bei den Toren der Seite, fuer die
     *                          gewertet wird, bzw. ET=3. null (Pokal) laesst die Wertung unberuehrt.
     * @param int $spiel Nummer des Spiels der Paarung; in der Liga gibt es nur das erste
     */
    public function setzeErgebnis(?int $toreHeim, ?int $toreGast, ?int $wertung = null, int $spiel = 1): void
    {
        $this->spiele[$spiel]['GA'] = $wertung === 1 ? '-2' : (string) ($toreHeim ?? -1);
        $this->spiele[$spiel]['GB'] = $wertung === 2 ? '-2' : (string) ($toreGast ?? -1);
        if ($wertung !== null) {
            unset($this->spiele[$spiel]['ET']);
            if ($wertung === 3) {
                $this->spiele[$spiel]['ET'] = '3';
            }
        }
    }

    /**
     * Setzt den Zusatz zum Ergebnis.
     *
     * @param int|null $zusatz 0 = ausdruecklich keiner, 1 = im Elfmeterschiessen, 2 = nach Verlaengerung;
     *                         null = keine Angabe (SP steht dann nicht in der Datei)
     */
    public function setzeZusatz(?int $zusatz, int $spiel = 1): void
    {
        unset($this->spiele[$spiel]['SP']);
        if ($zusatz === 0) {
            // "kein Zusatz" fuehrt der LMO als "_"; beim Speichern wird daraus SP=0
            $this->spiele[$spiel]['SP'] = '_';
        } elseif ($zusatz === 1 || $zusatz === 2) {
            $this->spiele[$spiel]['SP'] = (string) $zusatz;
        }
    }

    /** Setzt den Anstoss (AT) als Unix-Zeitstempel; null = kein Anstoss. */
    public function setzeAnstoss(?int $zeit, int $spiel = 1): void
    {
        $this->spiele[$spiel]['AT'] = $zeit === null ? '' : (string) $zeit;
    }

    /** Setzt die Notiz zum Spiel (NT). */
    public function setzeNotiz(string $notiz, int $spiel = 1): void
    {
        $this->spiele[$spiel]['NT'] = $notiz;
    }

    /** Setzt den Link zum Spielbericht (BE). */
    public function setzeBericht(string $bericht, int $spiel = 1): void
    {
        $this->spiele[$spiel]['BE'] = $bericht;
    }

    /** Nimmt das Spiel aus der Wertung des Tippspiels (TI=1) oder wieder hinein (TI=0). */
    public function setzeOhneTippwertung(bool $ohne, int $spiel = 1): void
    {
        $this->spiele[$spiel]['TI'] = $ohne ? '1' : '0';
    }
}
