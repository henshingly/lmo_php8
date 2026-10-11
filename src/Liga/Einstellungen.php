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
 *   $einstellungen = Rohdaten\Liga::lies($pfad)->einstellungen();
 *   $einstellungen->wert('Teams');
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
                return $this->spieltage();
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
    private function mannschaften(): float
    {
        $teams = $this->wert('Teams');

        return is_numeric($teams) ? (float) $teams : 0.0;
    }

    private function partienAusMannschaften(): float
    {
        return floor($this->mannschaften() / 2);
    }

    /**
     * @return int|float|string
     */
    private function spieltage()
    {
        $teams = $this->mannschaften();
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
