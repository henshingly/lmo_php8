<?php

namespace Lmo\Liga;

/**
 * Die Einstellungen einer Liga (Abschnitt [Options]) so, wie der LMO mit ihnen arbeitet: Was die
 * Datei nicht nennt, bekommt seinen Vorgabewert, und was sich aus anderen Angaben ergibt (Anzahl
 * der Spieltage und Partien), wird berechnet.
 *
 * Die Klasse liest nur; die Rohdaten bleiben, wie sie in der Datei stehen. Gespeichert wird
 * weiterhin ueber Rohdaten\Liga.
 *
 * Je Einstellung gibt es eine Methode mit festem Typ: Schalter (in der Datei 0 oder 1) sind bool,
 * Anzahlen, Punkte und Nummern int, Namen string. wert() liefert daneben den Wert, wie er in der
 * Datei steht, auch fuer Schluessel, die der LMO nicht kennt.
 *
 *   $einstellungen = Rohdaten\Liga::lies($pfad)->einstellungen();
 *   $einstellungen->mannschaften();      // int
 *   $einstellungen->mitVerlaengerung();  // bool
 */
final class Einstellungen
{
    private const IMMER = 'immer';
    private const LIGA = 'liga';
    private const POKAL = 'pokal';

    /**
     * Schluessel => [gilt fuer, Vorgabewert].
     *
     * "gilt fuer": Einstellungen einer Liga (Type=0) gibt es in einem Pokal nicht und umgekehrt;
     * sie ergeben dort null. Vorgabewert null: keiner, oder er haengt von anderen Werten ab
     * (siehe wert()).
     *
     * @var array<string, array{string, int|string|null}>
     */
    private const VORGABEN = [
        'Title' => [self::IMMER, 'k.A.'],
        'Name' => [self::IMMER, ''],
        'Type' => [self::IMMER, 0],
        'Teams' => [self::IMMER, null],
        'goalfaktor' => [self::IMMER, 1],
        'pointsfaktor' => [self::IMMER, 1],
        'enableGameSort' => [self::IMMER, 1],
        'Rounds' => [self::LIGA, null],
        'Matches' => [self::LIGA, null],
        'Actual' => [self::IMMER, 1],
        'Kegel' => [self::LIGA, 0],
        'HandS' => [self::LIGA, 0],
        'PointsForWin' => [self::LIGA, 3],
        'PointsForDraw' => [self::LIGA, 1],
        'PointsForLost' => [self::LIGA, 0],
        'Spez' => [self::LIGA, null],
        'HideDraw' => [self::LIGA, 0],
        'OnRun' => [self::LIGA, 0],
        'XtraS' => [self::LIGA, 0],
        'XtraU' => [self::LIGA, 0],
        'XtraV' => [self::LIGA, 0],
        'SpezS' => [self::LIGA, 0],
        'SpezU' => [self::LIGA, 0],
        'SpezV' => [self::LIGA, 0],
        'MinusPoints' => [self::LIGA, 1],
        'Direct' => [self::LIGA, null],
        'Champ' => [self::LIGA, 1],
        'CL' => [self::LIGA, 1],
        'CK' => [self::LIGA, 2],
        'UC' => [self::LIGA, 2],
        'AR' => [self::LIGA, 0],
        'AB' => [self::LIGA, 3],
        'namePkt' => [self::LIGA, ''],
        'nameTor' => [self::LIGA, ''],
        'tableHinRueck' => [self::LIGA, 1],
        'tableHeimAusw' => [self::LIGA, 1],
        'KlFin' => [self::POKAL, 0],
        'playdown' => [self::POKAL, 0],
        'playoffmode' => [self::POKAL, 0],
        'DatC' => [self::IMMER, 0],
        'DatS' => [self::IMMER, 1],
        'DatM' => [self::IMMER, 0],
        'DatF' => [self::IMMER, null],
        'urlT' => [self::IMMER, 1],
        'urlB' => [self::IMMER, 0],
        'Plan' => [self::IMMER, 1],
        'Ergebnis' => [self::IMMER, 1],
        'mittore' => [self::IMMER, 1],
        'favTeam' => [self::IMMER, 0],
        'selTeam' => [self::IMMER, 0],
        'ticker' => [self::IMMER, 0],
        'Graph' => [self::LIGA, 1],
        'Kreuz' => [self::LIGA, 1],
        'Tabelle' => [self::LIGA, 1],
        'Ligastats' => [self::LIGA, 1],
        'kurve1' => [self::LIGA, 0],
        'kurve2' => [self::LIGA, 0],
    ];

    /** Gelten nur in der Liga, haben im Pokal aber einen festen Wert, mit dem der LMO rechnet */
    private const IM_POKAL_FEST = ['Spez' => 1, 'HandS' => 0, 'Graph' => 1, 'Kreuz' => 1];

    private Rohdaten\Liga $liga;

    public function __construct(Rohdaten\Liga $liga)
    {
        $this->liga = $liga;
    }

    /** @return list<string> alle Schluessel, die der LMO kennt, in der Reihenfolge der Datei */
    public static function schluessel(): array
    {
        return array_keys(self::VORGABEN);
    }

    public function istPokal(): bool
    {
        return $this->liga->istPokal();
    }

    /**
     * Der Wert einer Einstellung: aus der Datei, sonst der Vorgabewert.
     *
     * Werte aus der Datei sind Text, Vorgabewerte Zahlen. Besonderheiten:
     *  - Name und Type stehen mit Schraegstrichen in der Datei (O\'Neill) und kommen ohne zurueck.
     *    Ohne Angabe ist der Name leer und der Typ 0 (Liga).
     *  - Teams: ohne Angabe 18 (Liga) bzw. 16 (Pokal).
     *  - Matches, Rounds: in der Liga ohne Angabe aus der Anzahl der Mannschaften (jeder gegen
     *    jeden, Hin- und Rueckrunde); im Pokal immer berechnet.
     *  - goalfaktor, pointsfaktor: ein leerer Wert zaehlt als fehlend.
     *  - kurve1, kurve2 (Fieberkurve): zweimal dieselbe Mannschaft oder nur die zweite gewaehlt ->
     *    sie wird als erste gefuehrt.
     *  - DatF (Datumsformat): ohne Angabe null; dann gilt das Format der Installation.
     *  - Ein Schluessel, den der LMO nicht kennt, kommt zurueck, wie er in der Datei steht.
     *
     * @return int|float|string|null null: gilt fuer diesen Typ (Liga/Pokal) nicht oder ist nicht gesetzt
     */
    public function wert(string $schluessel)
    {
        if (!isset(self::VORGABEN[$schluessel])) {
            return $this->liga->optionen[$schluessel] ?? null;
        }
        $pokal = $this->istPokal();
        switch ($schluessel) {
            case 'Name':
                return stripslashes($this->liga->optionen['Name'] ?? '');
            case 'Type':
                return isset($this->liga->optionen['Type']) ? stripslashes($this->liga->optionen['Type']) : 0;
            case 'Teams':
                return $this->liga->optionen['Teams'] ?? ($pokal ? 16 : 18);
            case 'Matches':
                return $pokal ? $this->partienAusMannschaften() : ($this->liga->optionen['Matches'] ?? $this->partienAusMannschaften());
            case 'Rounds':
                return $this->berechneSpieltage();
            case 'goalfaktor':
            case 'pointsfaktor':
                return ($this->liga->optionen[$schluessel] ?? '') === '' ? 1 : $this->liga->optionen[$schluessel];
            case 'kurve1':
            case 'kurve2':
                return $this->fieberkurve()[$schluessel === 'kurve1' ? 0 : 1];
            case 'playdown':
            case 'playoffmode':
                return !$pokal ? null : (empty($this->liga->optionen[$schluessel]) ? 0 : $this->liga->optionen[$schluessel]);
        }
        if ($pokal && isset(self::IM_POKAL_FEST[$schluessel])) {
            return self::IM_POKAL_FEST[$schluessel];
        }

        return $this->ausDatei($schluessel);
    }

    // --- Allgemein

    /** Name der Liga, ohne die Schraegstriche der Datei */
    public function name(): string
    {
        return $this->text('Name');
    }

    /** Title: Name und Version des Programms, das die Datei geschrieben hat; ohne Angabe "k.A." */
    public function programmversion(): string
    {
        return $this->text('Title');
    }

    /** Teams: Anzahl der Mannschaften; ohne Angabe 18 (Liga) bzw. 16 (Pokal) */
    public function mannschaften(): int
    {
        return $this->zahl('Teams');
    }

    /** Rounds: Anzahl der Spieltage, im Pokal der Runden; ohne Angabe aus der Anzahl der Mannschaften */
    public function spieltage(): int
    {
        return $this->zahl('Rounds');
    }

    /** Matches: Partien je Spieltag, im Pokal Paarungen der ersten Runde; ohne Angabe aus der Anzahl der Mannschaften */
    public function partienJeSpieltag(): int
    {
        return $this->zahl('Matches');
    }

    /** Actual: der aktuelle Spieltag laut Datei; ohne Angabe 1 */
    public function aktuellerSpieltag(): int
    {
        return $this->zahl('Actual');
    }

    /** favTeam: Nummer der Lieblingsmannschaft, 0 = keine */
    public function lieblingsmannschaft(): int
    {
        return $this->zahl('favTeam');
    }

    /** selTeam: Nummer der Mannschaft, deren Spielplan zuerst gezeigt wird, 0 = keine */
    public function vorgewaehlteMannschaft(): int
    {
        return $this->zahl('selTeam');
    }

    // --- Wertung (nur Liga; im Pokal 0 bzw. false)

    /** PointsForWin; ohne Angabe 3 */
    public function punkteFuerSieg(): int
    {
        return $this->zahl('PointsForWin');
    }

    /** PointsForDraw; ohne Angabe 1 */
    public function punkteFuerUnentschieden(): int
    {
        return $this->zahl('PointsForDraw');
    }

    /** PointsForLost; ohne Angabe 0 */
    public function punkteFuerNiederlage(): int
    {
        return $this->zahl('PointsForLost');
    }

    /** XtraS */
    public function punkteFuerSiegNachVerlaengerung(): int
    {
        return $this->zahl('XtraS');
    }

    /** XtraU */
    public function punkteFuerUnentschiedenNachVerlaengerung(): int
    {
        return $this->zahl('XtraU');
    }

    /** XtraV */
    public function punkteFuerNiederlageNachVerlaengerung(): int
    {
        return $this->zahl('XtraV');
    }

    /** SpezS */
    public function punkteFuerSiegImElfmeterschiessen(): int
    {
        return $this->zahl('SpezS');
    }

    /** SpezU */
    public function punkteFuerUnentschiedenImElfmeterschiessen(): int
    {
        return $this->zahl('SpezU');
    }

    /** SpezV */
    public function punkteFuerNiederlageImElfmeterschiessen(): int
    {
        return $this->zahl('SpezV');
    }

    /** Spez: Verlaengerung und Elfmeterschiessen sind moeglich; ein Spiel zeigt dann seinen Zusatz (n.V., i.E.). Im Pokal immer */
    public function mitVerlaengerung(): bool
    {
        return $this->schalter('Spez');
    }

    /** Direct: bei Punktgleichheit zaehlt der direkte Vergleich */
    public function mitDirektemVergleich(): bool
    {
        return $this->schalter('Direct');
    }

    /** HandS: je Spieltag eine Handicap-Reihenfolge */
    public function mitHandicap(): bool
    {
        return $this->schalter('HandS');
    }

    /** Kegel: Kegel-Wertung */
    public function istKegelliga(): bool
    {
        return $this->schalter('Kegel');
    }

    /** HideDraw: Unentschieden werden nicht angezeigt (und koennen nicht getippt werden) */
    public function ohneUnentschieden(): bool
    {
        return $this->schalter('HideDraw');
    }

    /** OnRun: Einstellung der Tabelle des laufenden Spieltags, 0 = aus */
    public function laufendeTabelle(): int
    {
        return $this->zahl('OnRun');
    }

    // --- Tabelle (nur Liga)

    /** Champ: der erste Platz ist als Meister markiert */
    public function mitMeister(): bool
    {
        return $this->schalter('Champ');
    }

    /** CL: Plaetze Champions League */
    public function plaetzeChampionsLeague(): int
    {
        return $this->zahl('CL');
    }

    /** CK: Plaetze Champions-League-Qualifikation */
    public function plaetzeClQualifikation(): int
    {
        return $this->zahl('CK');
    }

    /** UC: Plaetze UEFA-Cup */
    public function plaetzeUefaCup(): int
    {
        return $this->zahl('UC');
    }

    /** AR: Relegationsplaetze */
    public function plaetzeRelegation(): int
    {
        return $this->zahl('AR');
    }

    /** AB: Abstiegsplaetze */
    public function plaetzeAbstieg(): int
    {
        return $this->zahl('AB');
    }

    /** namePkt: eigene Bezeichnung fuer Punkte, '' = die des Sprachtexts */
    public function bezeichnungPunkte(): string
    {
        return $this->text('namePkt');
    }

    /** nameTor: eigene Bezeichnung fuer Tore, '' = die des Sprachtexts */
    public function bezeichnungTore(): string
    {
        return $this->text('nameTor');
    }

    /** tableHinRueck: Hin- und Rueckrundentabelle anbieten */
    public function mitHinRueckrundentabelle(): bool
    {
        return $this->schalter('tableHinRueck');
    }

    /** tableHeimAusw: Heim- und Auswaertstabelle anbieten */
    public function mitHeimAuswaertstabelle(): bool
    {
        return $this->schalter('tableHeimAusw');
    }

    /** kurve1: erste Mannschaft der Fieberkurve, 0 = keine */
    public function fieberkurveErste(): int
    {
        return $this->zahl('kurve1');
    }

    /** kurve2: zweite Mannschaft der Fieberkurve, 0 = keine */
    public function fieberkurveZweite(): int
    {
        return $this->zahl('kurve2');
    }

    // --- Pokal (in der Liga 0 bzw. false)

    /** KlFin: Spiel um Platz 3 */
    public function mitSpielUmPlatz3(): bool
    {
        return $this->schalter('KlFin');
    }

    /** playdown */
    public function mitPlaydown(): bool
    {
        return $this->schalter('playdown');
    }

    /** playoffmode: 0 = keiner */
    public function playoffModus(): int
    {
        return $this->zahl('playoffmode');
    }

    // --- Anzeige

    /** goalfaktor: Teiler fuer die Anzeige der Tore (1, 10, 100) */
    public function torfaktor(): int
    {
        return $this->zahl('goalfaktor');
    }

    /** pointsfaktor: Teiler fuer die Anzeige der Punkte (1, 10, 100) */
    public function punktfaktor(): int
    {
        return $this->zahl('pointsfaktor');
    }

    /** enableGameSort: Partien eines Spieltags nach Anstoss sortiert zeigen */
    public function sortiertNachAnstoss(): bool
    {
        return $this->schalter('enableGameSort');
    }

    /** DatC: Kalender anbieten */
    public function mitKalender(): bool
    {
        return $this->schalter('DatC');
    }

    /** DatS: Datum des Spieltags anzeigen */
    public function mitSpieltagsdatum(): bool
    {
        return $this->schalter('DatS');
    }

    /** DatM: Anstosszeit der Spiele anzeigen */
    public function mitAnstosszeit(): bool
    {
        return $this->schalter('DatM');
    }

    /** urlT: Homepages der Mannschaften verlinken */
    public function mitMannschaftslinks(): bool
    {
        return $this->schalter('urlT');
    }

    /** urlB: Spielberichte verlinken */
    public function mitSpielberichten(): bool
    {
        return $this->schalter('urlB');
    }

    /** Plan: Spielplan der Mannschaften anbieten */
    public function mitSpielplan(): bool
    {
        return $this->schalter('Plan');
    }

    /** Ergebnis: Ergebnisse anbieten */
    public function mitErgebnissen(): bool
    {
        return $this->schalter('Ergebnis');
    }

    /** mittore: Tabelle mit Toren */
    public function mitToren(): bool
    {
        return $this->schalter('mittore');
    }

    /** ticker: Newsticker an */
    public function mitNewsticker(): bool
    {
        return $this->schalter('ticker');
    }

    /** Graph: Fieberkurve anbieten */
    public function mitFieberkurve(): bool
    {
        return $this->schalter('Graph');
    }

    /** Kreuz: Kreuztabelle anbieten */
    public function mitKreuztabelle(): bool
    {
        return $this->schalter('Kreuz');
    }

    /** Tabelle: Tabelle anbieten */
    public function mitTabelle(): bool
    {
        return $this->schalter('Tabelle');
    }

    /** Ligastats: Ligastatistik anbieten */
    public function mitLigastatistik(): bool
    {
        return $this->schalter('Ligastats');
    }

    /**
     * MinusPoints: fuehrt die Liga neben den Pluspunkten auch Minuspunkte (in der Datei 2)?
     * Ohne Angabe und im Pokal nicht.
     */
    public function mitMinuspunkten(): bool
    {
        return $this->wert('MinusPoints') == 2;
    }

    /**
     * DatF: Datumsformat der Liga in date()-Schreibweise.
     *
     * @param string $vorgabe Format der Installation (Einstellung defdateformat); es gilt, wenn die Liga keines nennt
     */
    public function datumsformat(string $vorgabe): string
    {
        return (string) ($this->wert('DatF') ?? $vorgabe);
    }

    /** Ein Schalter ist an, wenn in der Datei 1 steht (bzw. der Vorgabewert 1 ist). */
    private function schalter(string $schluessel): bool
    {
        return $this->wert($schluessel) == 1;
    }

    /** Eine Zahl; fehlt sie fuer diesen Typ (Liga/Pokal) oder ist sie unlesbar: 0. */
    private function zahl(string $schluessel): int
    {
        $wert = $this->wert($schluessel);

        return is_numeric($wert) ? (int) $wert : 0;
    }

    private function text(string $schluessel): string
    {
        return (string) $this->wert($schluessel);
    }

    /**
     * @return array<string, int|float|string|null> alle Einstellungen, die der LMO kennt: Schluessel => wert()
     */
    public function alle(): array
    {
        $alle = [];
        foreach (self::schluessel() as $schluessel) {
            $alle[$schluessel] = $this->wert($schluessel);
        }

        return $alle;
    }

    /**
     * Wert aus der Datei oder Vorgabewert; null, wenn der Schluessel fuer diesen Typ nicht gilt.
     *
     * @return int|string|null
     */
    private function ausDatei(string $schluessel)
    {
        [$gilt, $vorgabe] = self::VORGABEN[$schluessel];
        if ($gilt !== self::IMMER && $gilt !== ($this->istPokal() ? self::POKAL : self::LIGA)) {
            return null;
        }

        return $this->liga->optionen[$schluessel] ?? $vorgabe;
    }

    /** Anzahl der Mannschaften als Zahl; eine unlesbare Angabe zaehlt als 0 */
    private function anzahlAlsZahl(): float
    {
        $teams = $this->wert('Teams');

        return is_numeric($teams) ? (float) $teams : 0.0;
    }

    private function partienAusMannschaften(): float
    {
        return floor($this->anzahlAlsZahl() / 2);
    }

    /**
     * @return int|float|string
     */
    private function berechneSpieltage()
    {
        $teams = $this->anzahlAlsZahl();
        if ($this->istPokal()) {
            return strlen(decbin((int) ($teams - 1)));
        }
        if (isset($this->liga->optionen['Rounds'])) {
            return $this->liga->optionen['Rounds'];
        }
        $partien = $this->wert('Matches');
        $partien = is_numeric($partien) ? (float) $partien : 0.0;

        return $partien == 0 ? 0.0 : floor($teams * ($teams - 1) / $partien);
    }

    /**
     * @return array{int|string, int|string} erste und zweite Mannschaft der Fieberkurve
     */
    private function fieberkurve(): array
    {
        // die Auswahl gibt es nur in der Liga; im Pokal ist keine Mannschaft gewaehlt
        $erste = $this->istPokal() ? 0 : ($this->liga->optionen['kurve1'] ?? 0);
        $zweite = $this->istPokal() ? 0 : ($this->liga->optionen['kurve2'] ?? 0);
        if ($erste > 0 && $erste == $zweite) {
            $zweite = 0;
        }
        if ($erste == 0 && $zweite > 0) {
            $erste = $zweite;
            $zweite = 0;
        }

        return [$erste, $zweite];
    }
}
