<?php

namespace Lmo\Liga;

/**
 * Alle Daten einer Ligadatei (.l98) an einem Ort.
 *
 * lmo-openfile.php liest die Datei noch in einzelne Variablen ($titel, $anzteams, $goala ...)
 * und bindet sie danach an dieses Objekt: Variable und Eigenschaft sind dieselbe Stelle im
 * Speicher. Alter Code arbeitet deshalb unveraendert weiter, neuer Code schreibt
 * $ligaDaten->titel. Die Namen sind bewusst die der alten Variablen, damit sich Dateien
 * mechanisch umstellen lassen.
 *
 * Werte kommen als Text aus der Datei; fehlt ein Schluessel, setzt lmo-openfile.php den
 * Standardwert (meist eine Zahl). null heisst: fuer diesen Ligatyp nicht belegt.
 *
 * Ziel: Laden, Speichern und Standardwerte wandern Schritt fuer Schritt hierher bzw. zur
 * classlib (Klasse liga), die dieselbe Datei schon als Objektbaum abbildet.
 */
class LigaDaten
{
    // ---- Sektion [Options]: fuer jede Liga ----

    /** @var int|string|null Title: Version des LMO, der die Datei geschrieben hat */
    public $lmvers = null;
    /** @var string|null Name: Name der Liga */
    public $titel = null;
    /** @var int|string|null Type: 0 = Liga, 1 = Pokal (KO-Modus) */
    public $lmtype = null;
    /** @var int|string|null Teams: Anzahl der Mannschaften */
    public $anzteams = null;
    /** @var int|string|null Actual: aktueller Spieltag laut Datei */
    public $stx = null;
    /** @var int|string|null DatC: Datumsangaben anzeigen */
    public $datc = null;
    /** @var int|string|null DatS: Spieltagsdatum anzeigen */
    public $dats = null;
    /** @var int|string|null DatM: Anstosszeit anzeigen */
    public $datm = null;
    /** @var string|null DatF: Datumsformat in date()-Schreibweise */
    public $datf = null;
    /** @var int|string|null urlT: Links zu den Mannschaften */
    public $urlt = null;
    /** @var int|string|null urlB: Links zu den Spielberichten */
    public $urlb = null;
    /** @var int|string|null Plan: Spielplan anzeigen */
    public $plan = null;
    /** @var int|string|null Ergebnis: Ergebnisse anzeigen */
    public $ergebnis = null;
    /** @var int|string|null mittore: mit Toren */
    public $mittore = null;
    /** @var int|string|null favTeam: Nummer der Lieblingsmannschaft */
    public $favteam = null;
    /** @var int|string|null selTeam: vorgewaehlte Mannschaft */
    public $selteam = null;
    /** @var int|string|null ticker: Newsticker an */
    public $nticker = null;
    /** @var int|float|string|null goalfaktor: Faktor fuer die Anzeige der Tore */
    public $goalfaktor = null;
    /** @var int|float|string|null pointsfaktor: Faktor fuer die Anzeige der Punkte */
    public $pointsfaktor = null;
    /** @var int|string|null enableGameSort: Partien nach Anstoss sortieren */
    public $enablegamesort = null;

    // ---- Sektion [Options]: nur Liga (Type=0); bei Pokal berechnet ----

    /** @var int|float|string|null Rounds: Anzahl der Spieltage */
    public $anzst = null;
    /** @var int|float|string|null Matches: Partien je Spieltag */
    public $anzsp = null;
    /** @var int|string|null Kegel: Kegel-Wertung */
    public $kegel = null;
    /** @var int|string|null HandS: Handicap-Reihenfolge */
    public $hands = null;
    /** @var int|string|null Graph: Fieberkurve anzeigen */
    public $kurve = null;
    /** @var int|string|null Kreuz: Kreuztabelle anzeigen */
    public $kreuz = null;
    /** @var int|string|null Tabelle: Tabelle anzeigen */
    public $tabelle = null;
    /** @var int|string|null Ligastats: Ligastatistik anzeigen */
    public $ligastats = null;
    /** @var int|string|null PointsForWin */
    public $pns = null;
    /** @var int|string|null PointsForDraw */
    public $pnu = null;
    /** @var int|string|null PointsForLost */
    public $pnn = null;
    /** @var int|string|null MinusPoints: 1 = nur Pluspunkte, 2 = Plus- und Minuspunkte */
    public $minus = null;
    /** @var int|string|null Direct: direkter Vergleich */
    public $direkt = null;
    /** @var int|string|null Spez: Verlaengerung / Elfmeterschiessen moeglich */
    public $spez = null;
    /** @var int|string|null HideDraw: Unentschieden ausblenden */
    public $hidr = null;
    /** @var int|string|null OnRun: Tabelle des laufenden Spieltags */
    public $onrun = null;
    /** @var int|string|null XtraS: Punkte fuer Sieg nach Verlaengerung */
    public $pxs = null;
    /** @var int|string|null XtraU */
    public $pxu = null;
    /** @var int|string|null XtraV */
    public $pxn = null;
    /** @var int|string|null SpezS: Punkte fuer Sieg im Elfmeterschiessen */
    public $pps = null;
    /** @var int|string|null SpezU */
    public $ppu = null;
    /** @var int|string|null SpezV */
    public $ppn = null;
    /** @var int|string|null Champ: Plaetze "Meister" */
    public $champ = null;
    /** @var int|string|null CL: Plaetze Champions League */
    public $anzcl = null;
    /** @var int|string|null CK: Plaetze CL-Qualifikation */
    public $anzck = null;
    /** @var int|string|null UC: Plaetze UEFA-Cup */
    public $anzuc = null;
    /** @var int|string|null AR: Relegationsplaetze */
    public $anzar = null;
    /** @var int|string|null AB: Abstiegsplaetze */
    public $anzab = null;
    /** @var string|null namePkt: Bezeichnung fuer Punkte */
    public $namepkt = null;
    /** @var string|null nameTor: Bezeichnung fuer Tore */
    public $nametor = null;
    /** @var int|string|null tableHinRueck: Hin-/Rueckrundentabelle anzeigen */
    public $einhinrueck = null;
    /** @var int|string|null tableHeimAusw: Heim-/Auswaertstabelle anzeigen */
    public $einheimausw = null;
    /** @var int|string|null kurve1: erste Mannschaft der Fieberkurve */
    public $stat1 = null;
    /** @var int|string|null kurve2: zweite Mannschaft der Fieberkurve */
    public $stat2 = null;

    // ---- Sektion [Options]: nur Pokal (Type=1) ----

    /** @var int|string|null KlFin: Spiel um Platz 3 */
    public $klfin = null;
    /** @var int|string|null playdown */
    public $playdown = null;
    /** @var int|string|null playoffmode */
    public $playoffmode = null;

    // ---- Sektion [News] ----

    /** @var array<int, string>|null Zeilen des Newstickers */
    public $nlines = null;

    // ---- Mannschaften: Index = Nummer der Mannschaft, 0 = Platzhalter "___" ----

    /** @var array<int|string, string>|null Teams: Namen */
    public $teams = null;
    /** @var array<int|string, string>|null Teamm: mittellange Namen */
    public $teamm = null;
    /** @var array<int|string, string>|null Teamk: Kurznamen */
    public $teamk = null;
    /** @var array<int|string, string>|null TeamN/SP: Strafpunkte (plus) */
    public $strafp = null;
    /** @var array<int|string, string>|null TeamN/SM: Strafpunkte (minus) */
    public $strafm = null;
    /** @var array<int|string, string>|null TeamN/TOR1: Torkorrektur erzielte Tore */
    public $torkorrektur1 = null;
    /** @var array<int|string, string>|null TeamN/TOR2: Torkorrektur Gegentore */
    public $torkorrektur2 = null;
    /** @var array<int|string, string>|null TeamN/STDA: Spieltag, ab dem die Strafe gilt */
    public $strafdat = null;
    /** @var array<int|string, string>|null TeamN/URL: Homepage */
    public $teamu = null;
    /** @var array<int|string, string>|null TeamN/NOT: Notiz */
    public $teamn = null;

    // ---- Spieltage: Index = Spieltag - 1 ----

    /** @var array<int, string>|null RoundN/HS: Handicap-Reihenfolge */
    public $handp = null;
    /** @var array<int, string>|null RoundN/D1: erster Tag des Spieltags (TT.MM.JJJJ) */
    public $datum1 = null;
    /** @var array<int, string>|null RoundN/D2: letzter Tag des Spieltags */
    public $datum2 = null;
    /** @var array<int, string>|null RoundN/MO: Modus der Runde (nur Pokal) */
    public $modus = null;

    // ---- Partien: [Spieltag - 1][Partie - 1], im Pokal zusaetzlich [Spiel - 1] ----

    /** @var array<int, array<int, mixed>>|null TA: Nummer der Heimmannschaft */
    public $teama = null;
    /** @var array<int, array<int, mixed>>|null TB: Nummer der Gastmannschaft */
    public $teamb = null;
    /** @var array<int, array<int, mixed>>|null GA: Tore Heim, "_" = noch nicht gespielt */
    public $goala = null;
    /** @var array<int, array<int, mixed>>|null GB: Tore Gast */
    public $goalb = null;
    /** @var array<int, array<int, mixed>>|null SP: Zusatz n.V. / i.E. als Anzeigetext */
    public $mspez = null;
    /** @var array<int, array<int, mixed>>|null Wertung am gruenen Tisch: 1 = Heim, 2 = Gast, 3 = beide verlieren (nur Liga) */
    public $msieg = null;
    /** @var array<int, array<int, mixed>>|null NT: Notiz zur Partie */
    public $mnote = null;
    /** @var array<int, array<int, mixed>>|null BE: Link zum Spielbericht */
    public $mberi = null;
    /** @var array<int, array<int, mixed>>|null TI: Tipp */
    public $mtipp = null;
    /** @var array<int, array<int, mixed>>|null AT: Anstoss als Unix-Zeitstempel */
    public $mterm = null;

    private const IMMER = 'immer';
    private const LIGA = 'liga';
    private const POKAL = 'pokal';

    /**
     * Abschnitt [Options] der Ligadatei: Schluessel => [Feld, gilt fuer, Vorgabewert].
     *
     * Die Reihenfolge ist die, in der die Datei geschrieben wird (optionenZumSpeichern()).
     * "gilt fuer": Schluessel einer Liga (Type=0) werden in einem Pokal uebergangen und umgekehrt.
     * Vorgabewert null: keiner, oder er haengt von anderen Werten ab und steht deshalb in
     * ergaenzeGrunddaten() bzw. ergaenzeVorgabewerte().
     *
     * @var array<string, array{string, string, int|string|null}>
     */
    private const OPTIONEN = [
        'Title' => ['lmvers', self::IMMER, 'k.A.'],
        'Name' => ['titel', self::IMMER, 'No Name'],
        'Type' => ['lmtype', self::IMMER, null],
        'Teams' => ['anzteams', self::IMMER, null],
        'goalfaktor' => ['goalfaktor', self::IMMER, 1],
        'pointsfaktor' => ['pointsfaktor', self::IMMER, 1],
        'enableGameSort' => ['enablegamesort', self::IMMER, 1],
        'Rounds' => ['anzst', self::LIGA, null],
        'Matches' => ['anzsp', self::LIGA, null],
        'Actual' => ['stx', self::IMMER, 1],
        'Kegel' => ['kegel', self::LIGA, 0],
        'HandS' => ['hands', self::LIGA, 0],
        'PointsForWin' => ['pns', self::LIGA, 3],
        'PointsForDraw' => ['pnu', self::LIGA, 1],
        'PointsForLost' => ['pnn', self::LIGA, 0],
        'Spez' => ['spez', self::LIGA, null],
        'HideDraw' => ['hidr', self::LIGA, 0],
        'OnRun' => ['onrun', self::LIGA, 0],
        'XtraS' => ['pxs', self::LIGA, 0],
        'XtraU' => ['pxu', self::LIGA, 0],
        'XtraV' => ['pxn', self::LIGA, 0],
        'SpezS' => ['pps', self::LIGA, 0],
        'SpezU' => ['ppu', self::LIGA, 0],
        'SpezV' => ['ppn', self::LIGA, 0],
        'MinusPoints' => ['minus', self::LIGA, 1],
        'Direct' => ['direkt', self::LIGA, null],
        'Champ' => ['champ', self::LIGA, 1],
        'CL' => ['anzcl', self::LIGA, 1],
        'CK' => ['anzck', self::LIGA, 2],
        'UC' => ['anzuc', self::LIGA, 2],
        'AR' => ['anzar', self::LIGA, 0],
        'AB' => ['anzab', self::LIGA, 3],
        'namePkt' => ['namepkt', self::LIGA, ''],
        'nameTor' => ['nametor', self::LIGA, ''],
        'tableHinRueck' => ['einhinrueck', self::LIGA, 1],
        'tableHeimAusw' => ['einheimausw', self::LIGA, 1],
        'KlFin' => ['klfin', self::POKAL, 0],
        'playdown' => ['playdown', self::POKAL, null],
        'playoffmode' => ['playoffmode', self::POKAL, null],
        'DatC' => ['datc', self::IMMER, 1],
        'DatS' => ['dats', self::IMMER, 1],
        'DatM' => ['datm', self::IMMER, 0],
        'DatF' => ['datf', self::IMMER, null],
        'urlT' => ['urlt', self::IMMER, 1],
        'urlB' => ['urlb', self::IMMER, 0],
        'Plan' => ['plan', self::IMMER, 1],
        'Ergebnis' => ['ergebnis', self::IMMER, 1],
        'mittore' => ['mittore', self::IMMER, 1],
        'favTeam' => ['favteam', self::IMMER, 0],
        'selTeam' => ['selteam', self::IMMER, 0],
        'ticker' => ['nticker', self::IMMER, null],
        'Graph' => ['kurve', self::LIGA, 1],
        'Kreuz' => ['kreuz', self::LIGA, 1],
        'Tabelle' => ['tabelle', self::LIGA, 1],
        'Ligastats' => ['ligastats', self::LIGA, 1],
        'kurve1' => ['stat1', self::LIGA, null],
        'kurve2' => ['stat2', self::LIGA, null],
    ];

    /** Was jeder Lader braucht, auch die abgespeckten: siehe ergaenzeGrunddaten() */
    private const GRUNDDATEN = ['stx', 'lmvers', 'titel', 'dats', 'datm', 'datc'];

    /** Kommen auch aus dem Seitenaufruf: die Datei setzt sie nur, wenn sie noch fehlen */
    private const NUR_WENN_LEER = ['selteam', 'stat1', 'stat2'];

    /** Punkte fuer Verlaengerung und Elfmeterschiessen: stehen nur in der Datei, wenn Spez=1 */
    private const NUR_MIT_SPEZ = ['pxs', 'pxu', 'pxn', 'pps', 'ppu', 'ppn'];

    /** Eigene Bezeichnungen fuer Punkte und Tore: stehen nur in der Datei, wenn sie gesetzt sind */
    private const NUR_WENN_GESETZT = ['namepkt', 'nametor'];

    /**
     * Setzt vor dem Lesen einer Datei die Werte zurueck, die nicht von der zuvor geladenen Liga
     * uebrig bleiben duerfen. Alle anderen Felder behalten ihren Wert, bis die Datei oder
     * ergaenzeVorgabewerte() sie setzt.
     */
    public function setzeStartwerte(): void
    {
        $this->titel = '';
        $this->ergebnis = $this->mittore = $this->kreuz = $this->plan = $this->kurve = 1;
        $this->datc = $this->nticker = $this->lmtype = 0;
    }

    /**
     * Uebernimmt eine Zeile "Schluessel=Wert" aus dem Abschnitt [Options].
     * Unbekannte Schluessel und solche, die fuer den Typ (Liga/Pokal) nicht gelten, werden
     * uebergangen. Der Typ ist der bis hierher gelesene: Type steht in der Datei vor den
     * Schluesseln, die von ihm abhaengen.
     */
    public function setzeOption(string $schluessel, string $wert): void
    {
        if (!isset(self::OPTIONEN[$schluessel])) {
            return;
        }
        [$feld, $gilt] = self::OPTIONEN[$schluessel];
        if ($gilt !== self::IMMER && $gilt !== $this->art()) {
            return;
        }
        if (in_array($feld, self::NUR_WENN_LEER, true) && isset($this->$feld)) {
            return;
        }
        $this->$feld = $schluessel === 'Name' || $schluessel === 'Type' ? stripslashes($wert) : $wert;
    }

    /**
     * Ergaenzt, was jeder Lader braucht, auch die abgespeckten (lmo-openfilename.php,
     * lmo-openfiledat.php), die nur wenige Schluessel lesen: Name, Version, aktueller Spieltag,
     * Datumsanzeige und die Groesse des Spielplans.
     *
     * Liga (Type=0): fehlende Anzahl der Partien und Spieltage ergibt sich aus der Anzahl der
     * Mannschaften (jeder gegen jeden, Hin- und Rueckrunde). Pokal: Partien und Runden werden
     * immer aus der Anzahl der Mannschaften berechnet.
     */
    public function ergaenzeGrunddaten(): void
    {
        $this->setzeVorgaben(self::GRUNDDATEN);

        if ($this->art() === self::LIGA) {
            if (!isset($this->anzteams)) {
                $this->anzteams = 18;
            }
            /** @var int|float|numeric-string $teams */
            $teams = $this->anzteams;
            if (!isset($this->anzsp)) {
                $this->anzsp = floor($teams / 2);
            }
            if (!isset($this->anzst)) {
                /** @var int|float|numeric-string $partien */
                $partien = $this->anzsp;
                $this->anzst = floor($teams * ($teams - 1) / $partien);
            }
        } else {
            if (!isset($this->anzteams)) {
                $this->anzteams = 16;
            }
            /** @var int|float|numeric-string $teams */
            $teams = $this->anzteams;
            $this->anzsp = floor($teams / 2);
            $this->anzst = strlen(decbin((int) ($teams - 1)));
        }
    }

    /**
     * Ergaenzt nach dem Lesen der Sektion [Options] alles, was die Datei nicht nennt.
     * Werte aus der Datei bleiben unangetastet. Im Pokal ist Verlaengerung/Elfmeterschiessen immer an.
     *
     * @param string $datumsformat Datumsformat der Installation (Einstellung defdateformat)
     */
    public function ergaenzeVorgabewerte(string $datumsformat): void
    {
        $this->ergaenzeGrunddaten();
        $this->setzeVorgaben(null);

        // Fieberkurve: zweimal dieselbe Mannschaft oder nur die zweite gewaehlt -> als erste fuehren
        if (!isset($this->stat1)) {
            $this->stat1 = 0;
        }
        if (!isset($this->stat2)) {
            $this->stat2 = 0;
        }
        if ($this->stat1 > 0 && $this->stat1 == $this->stat2) {
            $this->stat2 = 0;
        }
        if ($this->stat1 == 0 && $this->stat2 > 0) {
            $this->stat1 = $this->stat2;
            $this->stat2 = 0;
        }
        if (!isset($this->datf)) {
            $this->datf = $datumsformat;
        }
        // ein leerer Faktor zaehlt als fehlend
        if ($this->goalfaktor == '') {
            $this->goalfaktor = 1;
        }
        if ($this->pointsfaktor == '') {
            $this->pointsfaktor = 1;
        }

        if ($this->art() === self::POKAL) {
            if (empty($this->playdown)) {
                $this->playdown = 0;
            }
            if (empty($this->playoffmode)) {
                $this->playoffmode = 0;
            }
            $this->spez = 1;
            $this->hands = 0;
        }
    }

    /**
     * Der Abschnitt [Options], wie er in die Datei geschrieben wird: nur die Schluessel, die fuer
     * den Typ (Liga/Pokal) gelten, in der Reihenfolge der Tabelle OPTIONEN.
     *
     * @param string $programm Name des LMO (Sprachtext 54); er steht als Title in der Datei, nicht die
     *                         Version, mit der die Datei zuletzt gelesen wurde
     * @param int|string|null $aktuellerSpieltag Wert fuer Actual: der gewaehlte Spieltag, sonst der aus der Datei
     * @return list<array{string, string}> Schluessel und Wert je Zeile
     */
    public function optionenZumSpeichern(string $programm, $aktuellerSpieltag): array
    {
        $zeilen = [];
        foreach (self::OPTIONEN as $schluessel => [$feld, $gilt]) {
            if ($gilt !== self::IMMER && $gilt !== $this->art()) {
                continue;
            }
            if (in_array($feld, self::NUR_MIT_SPEZ, true) && $this->spez != 1) {
                continue;
            }
            if (in_array($feld, self::NUR_WENN_GESETZT, true) && !isset($this->$feld)) {
                continue;
            }
            if ($schluessel === 'Title') {
                $wert = $programm;
            } elseif ($schluessel === 'Actual') {
                $wert = $aktuellerSpieltag;
            } else {
                $wert = $this->$feld;
            }
            /** @var int|float|string|null $wert */
            $zeilen[] = [$schluessel, (string) $wert];
        }

        return $zeilen;
    }

    /** Liga oder Pokal, nach dem bisher bekannten Typ */
    private function art(): string
    {
        return $this->lmtype == 0 ? self::LIGA : self::POKAL;
    }

    /**
     * Setzt die Vorgabewerte der Tabelle OPTIONEN fuer alle Felder, die noch leer sind.
     *
     * @param string[]|null $nurFelder nur diese Felder, null = alle
     */
    private function setzeVorgaben(?array $nurFelder): void
    {
        foreach (self::OPTIONEN as [$feld, $gilt, $vorgabe]) {
            if ($vorgabe === null || ($gilt !== self::IMMER && $gilt !== $this->art())) {
                continue;
            }
            if ($nurFelder !== null && !in_array($feld, $nurFelder, true)) {
                continue;
            }
            if (!isset($this->$feld)) {
                $this->$feld = $vorgabe;
            }
        }
    }

    /**
     * Namen aller Felder; zugleich die Namen der Variablen, die lmo-openfile.php anbindet.
     *
     * @return string[]
     */
    public static function felder(): array
    {
        return array_keys(get_class_vars(self::class));
    }
}
