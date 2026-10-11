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
}
