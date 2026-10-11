<?php

namespace Lmo\Liga;

/**
 * Die Tabelle einer Liga, gerechnet aus den Spielen der Rohdaten.
 *
 *   $tabelle = Tabelle::berechne($liga);                       // Gesamttabelle bis zum letzten Spieltag
 *   $tabelle = Tabelle::berechne($liga, Tabelle::HEIM, 1, 17);  // Heimtabelle der Spieltage 1 bis 17
 *   foreach ($tabelle->reihenfolge as $platz => $nr) {
 *       $zeile = $tabelle->zeilen[$nr];
 *   }
 *
 * Gewertet wird jedes gespielte Spiel der gewaehlten Spieltage:
 *  - Punkte nach den Einstellungen der Liga; fuer Spiele nach Verlaengerung oder im
 *    Elfmeterschiessen gelten deren eigene Punkte, wenn die Liga sie fuehrt.
 *  - Wertung am gruenen Tisch: fuer Heim (1) oder Gast (2) gilt die Seite als Sieger, was auch
 *    immer an Toren eingetragen ist. Bei einer Wertung gegen beide (3) zaehlt das eingetragene
 *    Ergebnis fuer beide Mannschaften aus Sicht der Heimmannschaft.
 *  - Strafpunkte und Torkorrekturen einer Mannschaft zaehlen ab ihrem Stichtag (STDA), sobald die
 *    Tabelle und die Saison diesen Spieltag erreicht haben; in Heim- und Auswaertstabelle nie, in
 *    Hin- und Rueckrundentabelle nur, wenn der Stichtag in dieser Haelfte liegt.
 *
 * Reihenfolge: Punkte, weniger Minuspunkte, Tordifferenz, erzielte Tore (Kegelliga: erst Tore,
 * dann Differenz), zuletzt die hoehere Mannschaftsnummer. Mit direktem Vergleich entscheidet unter
 * Mannschaften mit gleichen Punkten und Minuspunkten zuerst die Tabelle ihrer Spiele gegeneinander.
 */
final class Tabelle
{
    public const GESAMT = 0;
    public const HEIM = 1;
    public const AUSWAERTS = 2;
    public const RUECKRUNDE = 3;
    public const HINRUNDE = 4;

    /** @var array<int, Tabellenzeile> Nummer der Mannschaft => ihre Zeile, fuer jede Mannschaft der Liga */
    public array $zeilen = [];

    /** @var list<int> Nummern der Mannschaften vom ersten zum letzten Platz */
    public array $reihenfolge = [];

    /** Erster Spieltag, der in diese Tabelle eingeht */
    public int $von = 1;

    /** Letzter Spieltag, der in diese Tabelle eingeht */
    public int $bis = 0;

    /** Letzter Spieltag, von dem ein Spiel in diese Tabelle eingegangen ist; 0 = keiner */
    public int $letzterGewerteterSpieltag = 0;

    /**
     * Direkte Vergleiche, in der Reihenfolge der Tabelle: je Gruppe punktgleicher Mannschaften
     * ihre Nummern (vom letzten zum ersten der Gruppe vor dem Vergleich), die Zahl der gewerteten
     * Spiele gegeneinander (je Spiel und beteiligter Mannschaft eins) und die Zeilen der Tabelle
     * dieser Spiele. Ohne direkten Vergleich leer.
     *
     * @var list<array{mannschaften: list<int>, wertungen: int, zeilen: array<int, Tabellenzeile>, reihenfolge: list<int>}>
     */
    public array $direkteVergleiche = [];

    private Rohdaten\Liga $liga;
    private Einstellungen $einstellungen;
    private int $art;

    /** @var list<Spiel> die gespielten Spiele der gewaehlten Spieltage in der Reihenfolge des Spielplans */
    private array $spiele = [];

    private function __construct(Rohdaten\Liga $liga, int $art)
    {
        $this->liga = $liga;
        $this->einstellungen = $liga->einstellungen();
        $this->art = $art;
    }

    /**
     * Rechnet die Tabelle.
     *
     * @param int $art GESAMT, HEIM, AUSWAERTS, RUECKRUNDE oder HINRUNDE. Die Art bestimmt, welche Seite
     *                 eines Spiels zaehlt und wie Strafen gelten; die Spieltage waehlen $von und $bis.
     * @param int $von erster Spieltag, ab 1
     * @param int|null $bis letzter Spieltag; null = der letzte der Liga
     */
    public static function berechne(Rohdaten\Liga $liga, int $art = self::GESAMT, int $von = 1, ?int $bis = null): self
    {
        $tabelle = new self($liga, $art);
        $e = $tabelle->einstellungen;
        $bis ??= $e->spieltage();
        $tabelle->von = $von;
        $tabelle->bis = $bis;
        $anzahl = $e->mannschaften();
        for ($nr = 1; $nr <= $anzahl; $nr++) {
            $tabelle->zeilen[$nr] = new Tabellenzeile($nr);
        }

        // letzter Spieltag der Saison mit einem Ergebnis: vorher greift keine Strafe
        $saisonstand = 0;
        $spieltage = $e->spieltage();
        for ($spieltag = 1; $spieltag <= $spieltage; $spieltag++) {
            foreach ($liga->spiele($spieltag) as $spiel) {
                if (!$spiel->istGespielt()) {
                    continue;
                }
                $saisonstand = $spieltag;
                if ($spieltag >= $von && $spieltag <= $bis) {
                    $tabelle->spiele[] = $spiel;
                }
            }
        }

        foreach ($tabelle->spiele as $spiel) {
            if ($tabelle->werte($spiel, $tabelle->zeilen)) {
                $tabelle->letzterGewerteterSpieltag = max($tabelle->letzterGewerteterSpieltag, $spiel->spieltag);
            }
        }
        $tabelle->rechneStrafenEin(min($bis, $saisonstand));
        $tabelle->reihenfolge = $tabelle->sortiere($tabelle->zeilen);
        if ($e->mitDirektemVergleich()) {
            $tabelle->vergleicheDirekt();
        }

        return $tabelle;
    }

    /**
     * Die Tabelle, wie die Seiten des LMO sie waehlen: eine Art bis zu einem Spieltag. Die
     * Rueckrundentabelle beginnt nach der Saisonhaelfte, die Hinrundentabelle endet dort, was auch
     * immer als $bis angegeben ist.
     *
     * @param int $art GESAMT, HEIM, AUSWAERTS, RUECKRUNDE oder HINRUNDE
     * @param int $bis Spieltag, bis zu dem gerechnet wird
     * @param int $einschraenkung RUECKRUNDE oder HINRUNDE schraenkt eine Heim- oder Auswaertstabelle auf diese
     *                            Saisonhaelfte ein (fuer die Heim- und Auswaertsbilanz neben der Hin- oder Rueckrundentabelle)
     */
    public static function fuerAnsicht(Rohdaten\Liga $liga, int $art, int $bis, int $einschraenkung = self::GESAMT): self
    {
        $e = $liga->einstellungen();
        $haelfte = intdiv($e->spieltage(), 2);
        $von = 1;
        if ($e->mannschaften() >= 1) {
            if ($art === self::RUECKRUNDE || $einschraenkung === self::RUECKRUNDE) {
                $von = $haelfte + 1;
            }
            if ($art === self::HINRUNDE || $einschraenkung === self::HINRUNDE) {
                $bis = $haelfte;
            }
        }

        return self::berechne($liga, $art, $von, $bis);
    }

    /** Platz einer Mannschaft in dieser Tabelle, ab 1; null, wenn sie nicht in der Tabelle steht */
    public function platz(int $mannschaft): ?int
    {
        $platz = array_search($mannschaft, $this->reihenfolge, true);

        return $platz === false ? null : $platz + 1;
    }

    /**
     * Die Reihenfolge nach der Handicap-Angabe eines Spieltags (HS): je zwei Ziffern nennen der
     * Reihe nach fuer den ersten, zweiten ... Platz der Tabelle den Platz, auf dem die Mannschaft
     * gefuehrt wird. Ohne Angabe (leer oder 0) bleibt die Reihenfolge der Tabelle.
     *
     * @param string $handicap Wert HS des Spieltags, z. B. "030102"
     * @return list<int> Nummern der Mannschaften vom ersten zum letzten Platz
     */
    public function reihenfolgeNachHandicap(string $handicap): array
    {
        if ($handicap === '' || $handicap == 0) {
            return $this->reihenfolge;
        }
        $schluessel = [];
        foreach ($this->reihenfolge as $platz => $nr) {
            // bei gleicher Angabe steht, wer in der Tabelle weiter hinten liegt, zuerst (wie bisher)
            $schluessel[$nr] = [(int) substr($handicap, $platz * 2, 2), -$platz];
        }
        $nummern = $this->reihenfolge;
        usort($nummern, static fn (int $a, int $b): int => $schluessel[$a] <=> $schluessel[$b]);

        return $nummern;
    }

    /**
     * Traegt ein gespieltes Spiel bei den beteiligten Mannschaften ein, soweit sie in $zeilen
     * stehen und die Art der Tabelle ihre Seite zaehlt.
     *
     * @param array<int, Tabellenzeile> $zeilen
     * @return bool ob das Spiel fuer mindestens eine Mannschaft gezaehlt hat
     */
    private function werte(Spiel $spiel, array $zeilen): bool
    {
        $toreHeim = $spiel->toreHeim;
        $toreGast = $spiel->toreGast;
        if ($toreHeim === null || $toreGast === null) {
            return false;
        }
        $e = $this->einstellungen;
        $punkte = [$e->punkteFuerSieg(), $e->punkteFuerUnentschieden(), $e->punkteFuerNiederlage()];
        if ($spiel->zusatz === 2) {
            $punkte = [$e->punkteFuerSiegNachVerlaengerung(), $e->punkteFuerUnentschiedenNachVerlaengerung(), $e->punkteFuerNiederlageNachVerlaengerung()];
        } elseif ($spiel->zusatz === 1) {
            $punkte = [$e->punkteFuerSiegImElfmeterschiessen(), $e->punkteFuerUnentschiedenImElfmeterschiessen(), $e->punkteFuerNiederlageImElfmeterschiessen()];
        }
        $minus = $e->mitMinuspunkten();
        // Ausgang aus Sicht der Heimmannschaft: 1 = Sieg, 0 = Unentschieden, -1 = Niederlage
        $nachToren = $toreHeim <=> $toreGast;
        $heim = $spiel->wertung === 1 ? 1 : ($spiel->wertung === 2 ? -1 : $nachToren);
        $gezaehlt = false;

        if ($this->art !== self::AUSWAERTS && isset($zeilen[$spiel->heim])) {
            $zeilen[$spiel->heim]->werte($heim, $toreHeim, $toreGast, $punkte, $minus, $spiel, true);
            $gezaehlt = true;
        }
        if ($this->art !== self::HEIM && isset($zeilen[$spiel->gast]) && $spiel->gast !== $spiel->heim) {
            if ($spiel->wertung === 3) {
                // gegen beide: auch der Gast bekommt das Ergebnis aus Sicht der Heimmannschaft
                $zeilen[$spiel->gast]->werte($nachToren, $toreHeim, $toreGast, $punkte, $minus, $spiel, true);
            } else {
                $zeilen[$spiel->gast]->werte(-$heim, $toreGast, $toreHeim, $punkte, $minus, $spiel, false);
            }
            $gezaehlt = true;
        }

        return $gezaehlt;
    }

    /**
     * Zieht Strafpunkte und Torkorrekturen ab, deren Stichtag erreicht ist.
     *
     * @param int $stand der Spieltag, bis zu dem Tabelle und Saison gekommen sind
     */
    private function rechneStrafenEin(int $stand): void
    {
        if ($this->art === self::HEIM || $this->art === self::AUSWAERTS) {
            return;
        }
        $haelfte = intdiv($this->einstellungen->spieltage(), 2);
        foreach ($this->zeilen as $nr => $zeile) {
            $werte = isset($this->liga->mannschaften[$nr]) ? $this->liga->mannschaften[$nr]->werte : [];
            $stichtag = self::zahl($werte['STDA'] ?? '0');
            if ($stand < $stichtag
                || ($this->art === self::RUECKRUNDE && $stichtag <= $haelfte)
                || ($this->art === self::HINRUNDE && $stichtag > $haelfte)) {
                continue;
            }
            $zeile->tore -= self::zahl($werte['TOR1'] ?? '0');
            $zeile->gegentore -= self::zahl($werte['TOR2'] ?? '0');
            $zeile->punkte -= self::zahl($werte['SP'] ?? '0');
            if ($this->einstellungen->mitMinuspunkten()) {
                $zeile->minuspunkte -= self::zahl($werte['SM'] ?? '0');
            }
        }
    }

    /**
     * Die Mannschaften nach Punkten, Minuspunkten, Tordifferenz und Toren, vom ersten zum letzten.
     *
     * @param array<int, Tabellenzeile> $zeilen
     * @return list<int>
     */
    private function sortiere(array $zeilen): array
    {
        $kegel = $this->einstellungen->istKegelliga();
        $schluessel = static function (Tabellenzeile $z) use ($kegel): array {
            return $kegel
                ? [$z->punkte, -$z->minuspunkte, $z->tore, $z->tordifferenz(), $z->mannschaft]
                : [$z->punkte, -$z->minuspunkte, $z->tordifferenz(), $z->tore, $z->mannschaft];
        };
        $nummern = array_keys($zeilen);
        usort($nummern, static fn (int $a, int $b): int => $schluessel($zeilen[$b]) <=> $schluessel($zeilen[$a]));

        return $nummern;
    }

    /**
     * Ordnet Mannschaften mit gleichen Punkten und Minuspunkten nach der Tabelle ihrer Spiele
     * gegeneinander. Haben sie noch nicht gegeneinander gespielt, bleibt ihre Reihenfolge.
     */
    private function vergleicheDirekt(): void
    {
        $gruppen = [];
        foreach ($this->reihenfolge as $nr) {
            $zeile = $this->zeilen[$nr];
            $ende = count($gruppen) - 1;
            if ($ende >= 0 && $gruppen[$ende]['punkte'] === [$zeile->punkte, $zeile->minuspunkte]) {
                $gruppen[$ende]['mannschaften'][] = $nr;
            } else {
                $gruppen[] = ['punkte' => [$zeile->punkte, $zeile->minuspunkte], 'mannschaften' => [$nr]];
            }
        }

        $reihenfolge = [];
        foreach ($gruppen as $gruppe) {
            $mannschaften = $gruppe['mannschaften'];
            if (count($mannschaften) < 2) {
                $reihenfolge[] = $mannschaften[0];
                continue;
            }
            // Tabelle nur aus den Spielen dieser Mannschaften gegeneinander, ohne Strafen
            $zeilen = [];
            foreach ($mannschaften as $nr) {
                $zeilen[$nr] = new Tabellenzeile($nr);
            }
            foreach ($this->spiele as $spiel) {
                if (isset($zeilen[$spiel->heim], $zeilen[$spiel->gast])) {
                    $this->werte($spiel, $zeilen);
                }
            }
            $wertungen = 0;
            foreach ($zeilen as $zeile) {
                $wertungen += $zeile->spiele;
            }
            // bei Gleichstand auch im direkten Vergleich bleibt die bisherige Reihenfolge
            $platz = array_flip($mannschaften);
            $kegel = $this->einstellungen->istKegelliga();
            $schluessel = static function (Tabellenzeile $z) use ($kegel, $platz): array {
                return $kegel
                    ? [$z->punkte, -$z->minuspunkte, $z->tore, $z->tordifferenz(), -$platz[$z->mannschaft]]
                    : [$z->punkte, -$z->minuspunkte, $z->tordifferenz(), $z->tore, -$platz[$z->mannschaft]];
            };
            $neu = $mannschaften;
            usort($neu, static fn (int $a, int $b): int => $schluessel($zeilen[$b]) <=> $schluessel($zeilen[$a]));

            $this->direkteVergleiche[] = [
                'mannschaften' => array_reverse($mannschaften),
                'wertungen' => $wertungen,
                'zeilen' => $zeilen,
                'reihenfolge' => $neu,
            ];
            foreach ($wertungen > 0 ? $neu : $mannschaften as $nr) {
                $reihenfolge[] = $nr;
            }
        }
        $this->reihenfolge = $reihenfolge;
    }

    /** Eine ganze Zahl aus der Datei; eine leere oder unlesbare Angabe zaehlt als 0 */
    private static function zahl(string $wert): int
    {
        return is_numeric($wert) ? (int) $wert : 0;
    }
}
