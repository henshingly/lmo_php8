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

    /**
     * Erster Tag des Spieltags (D1) als Zeitstempel, 0 Uhr.
     *
     * @return int|null null, wenn er fehlt oder es den Tag nicht gibt (31.02.)
     */
    public function ersterTag(): ?int
    {
        return self::zeitAusDatum($this->werte['D1'] ?? '');
    }

    /**
     * Letzter Tag des Spieltags (D2) als Zeitstempel, 0 Uhr.
     *
     * @return int|null null, wenn er fehlt oder es den Tag nicht gibt
     */
    public function letzterTag(): ?int
    {
        return self::zeitAusDatum($this->werte['D2'] ?? '');
    }

    /** Erster Tag des Spieltags zum Anzeigen (TT.MM.JJJJ); '' wenn er fehlt oder es den Tag nicht gibt */
    public function ersterTagText(): string
    {
        $zeit = $this->ersterTag();

        return $zeit === null ? '' : date('d.m.Y', $zeit);
    }

    /** Letzter Tag des Spieltags zum Anzeigen (TT.MM.JJJJ); '' wenn er fehlt oder es den Tag nicht gibt */
    public function letzterTagText(): string
    {
        $zeit = $this->letzterTag();

        return $zeit === null ? '' : date('d.m.Y', $zeit);
    }

    /**
     * Ein Datum, wie es in der Ligadatei steht (T.M.JJJJ), als Zeitstempel, 0 Uhr.
     *
     * @return int|null null, wenn es leer ist oder es den Tag nicht gibt
     */
    public static function zeitAusDatum(string $datum): ?int
    {
        $teile = explode('.', $datum);
        $gueltig = count($teile) === 3 && is_numeric($teile[0]) && is_numeric($teile[1]) && is_numeric($teile[2])
            && checkdate((int) $teile[1], (int) $teile[0], (int) $teile[2]);
        $zeit = $gueltig ? mktime(0, 0, 0, (int) $teile[1], (int) $teile[0], (int) $teile[2]) : false;

        return $zeit === false ? null : $zeit;
    }

    /** Die Partie mit dieser Nummer; sie wird angelegt, wenn es sie noch nicht gibt. */
    public function partie(int $nr): Partie
    {
        return $this->partien[$nr] ??= new Partie();
    }

    /** Setzt den ersten Tag des Spieltags (D1), TT.MM.JJJJ oder leer. */
    public function setzeErstenTag(string $datum): void
    {
        $this->werte['D1'] = $datum;
    }

    /** Setzt den letzten Tag des Spieltags (D2), TT.MM.JJJJ oder leer. */
    public function setzeLetztenTag(string $datum): void
    {
        $this->werte['D2'] = $datum;
    }

    /**
     * Setzt die Tabellenkorrektur des Spieltags (HS): je zwei Ziffern nennen der Reihe nach fuer den
     * ersten, zweiten ... Platz der Tabelle den Platz, auf dem die Mannschaft gefuehrt wird.
     * Leer oder "0" = keine Korrektur.
     */
    public function setzeTabellenkorrektur(string $plaetze): void
    {
        $this->werte['HS'] = $plaetze === '' ? '0' : $plaetze;
    }

    /** Setzt im Pokal, wie viele Spiele eine Paarung der Runde hat (MO). */
    public function setzeSpieleJePaarung(int $spiele): void
    {
        $this->werte['MO'] = (string) $spiele;
    }
}
