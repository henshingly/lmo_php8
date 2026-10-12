<?php

namespace Lmo\Liga;

use Lmo\Liga\Rohdaten\Liga;
use Lmo\Liga\Rohdaten\Mannschaft;
use Lmo\Liga\Rohdaten\Partie;
use Lmo\Liga\Rohdaten\Spieltag;

/**
 * Die vollstaendige Form einer Liga, wie der LMO sie in die Datei schreibt.
 *
 * Die Rohdaten (Rohdaten\Liga) enthalten nur, was in der Datei steht. Beim Speichern schreibt der
 * LMO dagegen immer alles: jede Einstellung mit ihrem Wert, jede Mannschaft mit Kurz- und
 * Mittelnamen, jeden Spieltag mit allen Partien und deren Werten. von() ergaenzt die Rohdaten
 * dazu und laesst weg, was nicht mehr zur Liga gehoert (Mannschaften, Spieltage und Partien
 * jenseits der eingestellten Anzahl, Einstellungen des anderen Typs).
 *
 * Erhalten bleibt, was der LMO nicht kennt: unbekannte Einstellungen und Abschnitte, unbekannte
 * Schluessel einer Mannschaft, eines Spieltags und eines Spiels.
 */
final class Normalform
{
    /** [TeamN]: Schluessel => [nur in der Liga?, Wert ohne Eintrag], in der Reihenfolge der Datei */
    private const MANNSCHAFTSWERTE = [
        'SP' => [true, '0'],
        'SM' => [true, '0'],
        'TOR1' => [true, '0'],
        'TOR2' => [true, '0'],
        'STDA' => [true, '0'],
        'URL' => [false, ''],
        'NOT' => [false, ''],
    ];

    /** Werte eines Spiels, die unveraendert uebernommen werden: Schluessel => Wert ohne Eintrag */
    private const SPIELWERTE = ['NT' => '', 'BE' => '', 'TI' => '', 'AT' => '0'];

    /** Was von() bei einem Spiel selbst schreibt; alles andere ist unbekannt und bleibt erhalten */
    private const BEKANNT_IM_SPIEL = ['GA', 'GB', 'ET', 'SP', 'NT', 'BE', 'TI', 'AT'];

    /**
     * @param string $programm Name des LMO (Sprachtext 54); er steht als Title in der Datei
     * @param int|string|null $aktuellerSpieltag Wert fuer Actual
     * @param string $datumsformat Datumsformat der Installation; es steht in der Datei, wenn die Liga keines hat
     */
    public static function von(Liga $liga, string $programm, $aktuellerSpieltag, string $datumsformat): Liga
    {
        $e = $liga->einstellungen();
        $pokal = $e->istPokal();
        $neu = new Liga();

        $neu->optionen = $e->zumSpeichern($programm, $aktuellerSpieltag, $datumsformat);
        foreach ($liga->optionen as $schluessel => $wert) {
            if (!in_array($schluessel, Einstellungen::schluessel(), true)) {
                $neu->optionen[$schluessel] = $wert;
            }
        }

        $neu->news = self::news($liga, $e);

        $minuspunkte = $e->mitMinuspunkten();
        for ($nr = 1; $nr <= $e->mannschaften(); $nr++) {
            $neu->mannschaften[$nr] = self::mannschaft($liga->mannschaften[$nr] ?? new Mannschaft(), $pokal, $minuspunkte);
        }

        $letzter = $liga->weitereAbschnitte === [] ? array_key_last($liga->spieltage) : null;
        for ($nr = 1; $nr <= $e->spieltage(); $nr++) {
            $neu->spieltage[$nr] = self::spieltag($liga->spieltage[$nr] ?? new Spieltag(), $e, $nr, $nr === $letzter);
        }

        $neu->weitereAbschnitte = $liga->weitereAbschnitte;

        return $neu;
    }

    /**
     * [News]: die Anzahl (NC) und die Zeilen N0, N1 ... ohne die Schraegstriche der Datei. Ohne
     * Zeilen bleibt der Abschnitt leer, bei eingeschaltetem Newsticker steht NC=0.
     *
     * @return array<string, string>
     */
    private static function news(Liga $liga, Einstellungen $e): array
    {
        $zeilen = [];
        foreach ($liga->news as $schluessel => $wert) {
            if ($schluessel != 'NC') {
                $zeilen[] = stripslashes($wert);
            }
        }
        if ($zeilen === [] && !$e->mitNewsticker()) {
            return [];
        }
        $news = ['NC' => (string) count($zeilen)];
        foreach ($zeilen as $i => $zeile) {
            $news['N' . $i] = $zeile;
        }

        return $news;
    }

    /**
     * Name, Kurz- und Mittelname ohne die Schraegstriche der Datei, fehlende abgeleitet; dazu die
     * Werte aus [TeamN]: Strafen und Torkorrekturen nur in der Liga, Strafminuspunkte (SM) nur,
     * wenn die Liga Minuspunkte fuehrt.
     */
    private static function mannschaft(Mannschaft $alt, bool $pokal, bool $minuspunkte): Mannschaft
    {
        $neu = new Mannschaft();
        $neu->name = $alt->anzeigename();
        $neu->mittel = $alt->mittelname();
        $neu->kurz = $alt->kurzname();
        foreach (self::MANNSCHAFTSWERTE as $schluessel => [$nurLiga, $vorgabe]) {
            if (($nurLiga && $pokal) || ($schluessel === 'SM' && !$minuspunkte)) {
                continue;
            }
            $neu->werte[$schluessel] = $alt->werte[$schluessel] ?? $vorgabe;
        }
        foreach ($alt->werte as $schluessel => $wert) {
            if (!isset(self::MANNSCHAFTSWERTE[$schluessel])) {
                $neu->werte[$schluessel] = $wert;
            }
        }

        return $neu;
    }

    /**
     * @param bool $datumBereinigen D1 und D2 in die Form TT.MM.JJJJ bringen; ein Tag, den es nicht
     *                              gibt, wird geleert. Der LMO macht das nur beim letzten Spieltag der Datei.
     */
    private static function spieltag(Spieltag $alt, Einstellungen $e, int $nr, bool $datumBereinigen): Spieltag
    {
        $pokal = $e->istPokal();
        $neu = new Spieltag();
        if (!$pokal && $e->mitHandicap()) {
            $neu->werte['HS'] = $alt->werte['HS'] ?? '0';
        }
        foreach (['D1', 'D2'] as $schluessel) {
            $datum = $alt->werte[$schluessel] ?? '';
            if ($datumBereinigen && !empty($datum)) {
                $zeit = Spieltag::zeitAusDatum($datum);
                $datum = $zeit === null ? '' : date('d.m.Y', $zeit);
            }
            $neu->werte[$schluessel] = $datum;
        }
        $spiele = 1;
        if ($pokal) {
            $neu->werte['MO'] = $alt->werte['MO'] ?? '1';
            $spiele = (int) $neu->werte['MO'];
        }
        foreach ($alt->werte as $schluessel => $wert) {
            if (!in_array($schluessel, ['HS', 'D1', 'D2', 'MO'], true)) {
                $neu->werte[$schluessel] = $wert;
            }
        }
        $mitZusatz = $pokal || $e->mitVerlaengerung();
        for ($partie = 1; $partie <= $e->partienImSpieltag($nr); $partie++) {
            $neu->partien[$partie] = self::partie($alt->partien[$partie] ?? new Partie(), $pokal, $spiele, $mitZusatz);
        }

        return $neu;
    }

    private static function partie(Partie $alt, bool $pokal, int $spiele, bool $mitZusatz): Partie
    {
        $neu = new Partie();
        $neu->heim = $alt->heim ?? '0';
        $neu->gast = $alt->gast ?? '0';
        for ($nr = 1; $nr <= $spiele; $nr++) {
            $neu->spiele[$nr] = self::spiel($alt->spiele[$nr] ?? [], $pokal, $mitZusatz);
        }

        return $neu;
    }

    /**
     * Ein Spiel: Tore (-1 = nicht gespielt), in der Liga die Wertung am gruenen Tisch (-2 auf der
     * Seite, gegen die gewertet wird, bzw. ET=3 gegen beide), der Zusatz und die uebrigen Werte.
     *
     * @param array<string, string> $alt
     * @return array<string, string>
     */
    private static function spiel(array $alt, bool $pokal, bool $mitZusatz): array
    {
        // Wertung in der Reihenfolge der Datei: die letzte Angabe gilt
        $wertung = 0;
        if (!$pokal) {
            foreach ($alt as $schluessel => $wert) {
                if (($schluessel === 'GA' || $schluessel === 'GB') && $wert == '-2') {
                    $wertung = $schluessel === 'GA' ? 1 : 2;
                } elseif ($schluessel === 'ET' && $wert == 3) {
                    $wertung = 3;
                }
            }
        }
        $neu = [
            'GA' => self::tore($alt['GA'] ?? '-1', $pokal, $wertung === 1),
            'GB' => self::tore($alt['GB'] ?? '-1', $pokal, $wertung === 2),
        ];
        if ($wertung === 3) {
            $neu['ET'] = '3';
        }
        if ($mitZusatz && isset($alt['SP'])) {
            $zusatz = self::zusatz($alt['SP']);
            if ($zusatz !== null) {
                $neu['SP'] = $zusatz;
            }
        }
        foreach (self::SPIELWERTE as $schluessel => $vorgabe) {
            $neu[$schluessel] = $alt[$schluessel] ?? $vorgabe;
        }
        foreach ($alt as $schluessel => $wert) {
            if (!in_array($schluessel, self::BEKANNT_IM_SPIEL, true)) {
                $neu[$schluessel] = $wert;
            }
        }

        return $neu;
    }

    /** Tore: leer und "_" heissen nicht gespielt (-1); in der Liga steht -2 nur bei der Wertung gegen diese Seite. */
    private static function tore(string $wert, bool $pokal, bool $wertung): string
    {
        if ($wert === '' || $wert == '-1' || $wert == '_') {
            return '-1';
        }
        if ($pokal) {
            return $wert;
        }
        if ($wertung) {
            return '-2';
        }

        return $wert == '-2' ? '0' : $wert;
    }

    /** Zusatz SP: 1 (im Elfmeterschiessen), 2 (nach Verlaengerung) und "_" (0); alles andere steht nicht in der Datei. */
    private static function zusatz(string $wert): ?string
    {
        if ($wert == '_') {
            return '0';
        }
        if ($wert == 2) {
            return '2';
        }

        return $wert == 1 ? '1' : null;
    }
}
