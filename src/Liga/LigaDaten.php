<?php

namespace Lmo\Liga;

/**
 * Bruecke zwischen den Rohdaten einer Ligadatei (Rohdaten\Liga) und dem alten Code des LMO.
 *
 * Der alte Code arbeitet mit einzelnen Variablen ($titel, $anzteams, $goala ...), die fuer die
 * Anzeige aufbereitet sind: Felder fester Groesse, "_" fuer nicht gespielt, Anzeigetexte statt
 * Zahlen, Vorgabewerte fuer alles, was die Datei nicht nennt. Diese Klasse erzeugt beim Laden
 * diese Werte aus den Rohdaten (lies()) und rechnet sie beim Speichern zurueck
 * (abschnitteZumSpeichern()). lmo-ligadaten.php bindet jede oeffentliche Eigenschaft an die
 * gleichnamige Variable: beide sind dieselbe Stelle im Speicher.
 *
 * Die Namen sind bewusst die der alten Variablen. null heisst: fuer diesen Ligatyp nicht belegt.
 *
 * Neuer Code, der die Liga nicht anzeigen, sondern lesen oder aendern will, nimmt die Rohdaten.
 */
class LigaDaten
{
    /**
     * Die zuletzt gelesenen bzw. gespeicherten Rohdaten. Aus ihnen bleiben beim Speichern die
     * Einstellungen und Abschnitte erhalten, die der LMO nicht kennt.
     */
    private ?Rohdaten\Liga $rohdaten = null;

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

    /** Abschnitte mit einem Wert je Mannschaft (Schluessel = Nummer der Mannschaft): Abschnitt => Feld */
    private const MANNSCHAFTSLISTEN = ['Teams' => 'teams', 'Teamm' => 'teamm', 'Teamk' => 'teamk'];

    /**
     * Abschnitte [Team1] ... [TeamN]: Schluessel => [Feld, gilt fuer], in der Reihenfolge der Datei.
     * Strafen und Torkorrekturen gibt es nur in einer Liga; dort ist "0" der Wert ohne Eintrag.
     *
     * @var array<string, array{string, string}>
     */
    private const MANNSCHAFTSWERTE = [
        'SP' => ['strafp', self::LIGA],
        'SM' => ['strafm', self::LIGA],
        'TOR1' => ['torkorrektur1', self::LIGA],
        'TOR2' => ['torkorrektur2', self::LIGA],
        'STDA' => ['strafdat', self::LIGA],
        'URL' => ['teamu', self::IMMER],
        'NOT' => ['teamn', self::IMMER],
    ];

    /** So viele Plaetze haben die Felder je Mannschaft mit Strafen und Torkorrekturen immer */
    private const PLAETZE_JE_MANNSCHAFT = 116;

    /** Liga: so viele Spieltage und Partien je Spieltag haben die Felder immer */
    private const LIGA_SPIELTAGE = 116;
    private const LIGA_PARTIEN = 40;

    /** Pokal: so viele Runden, Paarungen je Runde und Spiele je Paarung haben die Felder immer */
    private const POKAL_RUNDEN = 7;
    private const POKAL_PAARUNGEN = 64;
    private const POKAL_SPIELE = 7;

    /** Partie: Schluessel ohne Nummer (NT1 -> NT) => Feld, fuer Werte, die unveraendert uebernommen werden */
    private const PARTIEWERTE = ['NT' => 'mnote', 'BE' => 'mberi', 'TI' => 'mtipp', 'AT' => 'mterm'];

    /** Was auch eine Liga ohne [Options] braucht: siehe ergaenzeGrunddaten() */
    private const GRUNDDATEN = ['stx', 'lmvers', 'titel', 'dats', 'datm', 'datc'];

    /** Kommen auch aus dem Seitenaufruf: die Datei setzt sie nur, wenn sie noch fehlen */
    private const NUR_WENN_LEER = ['selteam', 'stat1', 'stat2'];

    /** Punkte fuer Verlaengerung und Elfmeterschiessen: stehen nur in der Datei, wenn Spez=1 */
    private const NUR_MIT_SPEZ = ['pxs', 'pxu', 'pxn', 'pps', 'ppu', 'ppn'];

    /** Eigene Bezeichnungen fuer Punkte und Tore: stehen nur in der Datei, wenn sie gesetzt sind */
    private const NUR_WENN_GESETZT = ['namepkt', 'nametor'];

    /**
     * Leert vor dem Lesen einer Datei alle Felder, damit nichts von der zuvor geladenen Liga
     * uebrig bleibt, und setzt die Startwerte. Stehen bleiben nur die drei Felder, die auch aus
     * dem Seitenaufruf kommen (gewaehlte Mannschaft, Auswahl der Fieberkurve).
     */
    public function setzeStartwerte(): void
    {
        foreach (self::felder() as $feld) {
            if (!in_array($feld, self::NUR_WENN_LEER, true)) {
                $this->$feld = null;
            }
        }
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
     * Ergaenzt, was der alte Code immer voraussetzt: Name, Version, aktueller Spieltag,
     * Datumsanzeige und die Groesse des Spielplans. Teil von ergaenzeVorgabewerte().
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

    /**
     * Legt vor dem Lesen der Mannschaften die Felder in voller Groesse an: ein Platz je Mannschaft,
     * dazu Platz 0 (Platzhalter "___" bei den Namen) und ein Platz dahinter. Der alte Code greift
     * ohne Pruefung auf diese Plaetze zu. Braucht die Anzahl der Mannschaften, also erst nach
     * ergaenzeVorgabewerte() bzw. ergaenzeGrunddaten().
     *
     * Im Pokal bleiben Strafen und Torkorrekturen unberuehrt.
     */
    public function bereiteMannschaftenVor(): void
    {
        /** @var int|float|numeric-string $teams */
        $teams = $this->anzteams;
        $plaetze = max(0, (int) ($teams + 2));
        foreach (['teams', 'teamm', 'teamk', 'teamu', 'teamn'] as $feld) {
            $this->$feld = $plaetze > 0 ? array_fill(0, $plaetze, '') : [];
        }
        if ($this->art() === self::LIGA) {
            foreach (self::MANNSCHAFTSWERTE as [$feld, $gilt]) {
                if ($gilt === self::LIGA) {
                    $this->$feld = array_fill(0, self::PLAETZE_JE_MANNSCHAFT, '0');
                }
            }
        }
        $this->teams[0] = $this->teamm[0] = $this->teamk[0] = '___';
    }

    /**
     * Uebernimmt eine Zeile aus [Teams], [Teamm], [Teamk] oder [Team1] ... [TeamN].
     * Zeilen aus anderen Abschnitten und unbekannte Schluessel werden uebergangen.
     */
    public function setzeMannschaftswert(string $abschnitt, string $schluessel, string $wert): void
    {
        if (isset(self::MANNSCHAFTSLISTEN[$abschnitt])) {
            // Namen stehen mit Schraegstrichen vor Anfuehrungszeichen in der Datei
            $this->{self::MANNSCHAFTSLISTEN[$abschnitt]}[$schluessel] = stripslashes($wert);

            return;
        }
        if (substr($abschnitt, 0, 4) !== 'Team' || !isset(self::MANNSCHAFTSWERTE[$schluessel])) {
            return;
        }
        [$feld, $gilt] = self::MANNSCHAFTSWERTE[$schluessel];
        if ($gilt === self::IMMER || $gilt === $this->art()) {
            $this->{$feld}[substr($abschnitt, 4)] = $wert;
        }
    }

    /**
     * Leitet nach dem Lesen fehlende Kurz- und Mittelnamen aus dem Namen ab: der Mittelname ist
     * das laengste Wort (bei gleicher Laenge das letzte), hoechstens 12 Zeichen; der Kurzname
     * sind die ersten 5 Zeichen.
     */
    public function ergaenzeMannschaftsnamen(): void
    {
        for ($nr = 0; $nr <= $this->anzteams; $nr++) {
            $name = (string) ($this->teams[$nr] ?? '');
            if (($this->teamm[$nr] ?? '') == '') {
                $this->teamm[$nr] = '';
                foreach (preg_split('%[ |/]%', $name) ?: [] as $wort) {
                    if (strlen($wort) >= strlen($this->teamm[$nr])) {
                        $this->teamm[$nr] = trim(substr($wort, 0, 12));
                    }
                }
            }
            if (($this->teamk[$nr] ?? '') == '') {
                $this->teamk[$nr] = trim(substr($name, 0, 5));
            }
        }
    }

    /**
     * Die Abschnitte der Mannschaften, wie sie in die Datei geschrieben werden: [Teams], [Teamm],
     * [Teamk] und je Mannschaft [TeamN]. Strafminuspunkte (SM) stehen nur in der Datei, wenn die
     * Liga Minuspunkte fuehrt (MinusPoints=2).
     *
     * @return list<array{string, list<array{string, string}>}> je Abschnitt: Name, dann Schluessel und Wert je Zeile
     */
    public function mannschaftenZumSpeichern(): array
    {
        $anzahl = (int) $this->anzteams;
        $abschnitte = [];
        foreach (self::MANNSCHAFTSLISTEN as $abschnitt => $feld) {
            $zeilen = [];
            for ($nr = 1; $nr <= $anzahl; $nr++) {
                $zeilen[] = [(string) $nr, (string) ($this->{$feld}[$nr] ?? '')];
            }
            $abschnitte[] = [$abschnitt, $zeilen];
        }
        for ($nr = 1; $nr <= $anzahl; $nr++) {
            $zeilen = [];
            foreach (self::MANNSCHAFTSWERTE as $schluessel => [$feld, $gilt]) {
                if ($gilt !== self::IMMER && $gilt !== $this->art()) {
                    continue;
                }
                if ($schluessel === 'SM' && $this->minus != 2) {
                    continue;
                }
                $zeilen[] = [$schluessel, (string) ($this->{$feld}[$nr] ?? '')];
            }
            $abschnitte[] = ['Team' . $nr, $zeilen];
        }

        return $abschnitte;
    }

    /**
     * Bei eingeschaltetem Newsticker beginnen die Zeilen leer; sonst bleiben sie, wie sie sind,
     * und setzeNewszeile() haengt an.
     */
    public function bereiteNewsVor(): void
    {
        if (!isset($this->nticker)) {
            $this->nticker = 0;
        }
        if ($this->nticker == 1) {
            $this->nlines = [];
        }
    }

    /** Uebernimmt eine Zeile aus [News]; NC (Anzahl der Zeilen) wird uebergangen. */
    public function setzeNewszeile(string $abschnitt, string $schluessel, string $wert): void
    {
        if ($abschnitt === 'News' && $schluessel != 'NC') {
            $this->nlines[] = stripslashes($wert);
        }
    }

    /**
     * Legt vor dem Lesen der Spieltage die Felder in voller Groesse an; der alte Code greift ohne
     * Pruefung darauf zu.
     *
     * Liga: 116 Spieltage mit je 40 Partien. Pokal: 7 Runden mit je 64 Paarungen, und fuer Tore,
     * Zusatz, Notiz, Bericht, Tipp und Anstoss je Paarung 7 Spiele (Hin-/Rueckspiel ...).
     * Tore beginnen mit "_" (nicht gespielt), Mannschaften und Anstoss mit "0".
     * Wertung (msieg) und Handicap (handp) gibt es nur in der Liga.
     */
    public function bereiteSpieltageVor(): void
    {
        if ($this->art() === self::LIGA) {
            $jePartie = static fn (string $wert): array => array_fill(0, self::LIGA_SPIELTAGE, array_fill(0, self::LIGA_PARTIEN, $wert));
            $this->handp = array_fill(0, self::LIGA_SPIELTAGE, '0');
            $this->datum1 = $this->datum2 = array_fill(0, self::LIGA_SPIELTAGE, '');
            $this->teama = $this->teamb = $jePartie('0');
            $this->goala = $this->goalb = $jePartie('_');
            $this->mspez = $this->mberi = $this->mtipp = $this->mnote = $jePartie('');
            $this->msieg = $this->mterm = $jePartie('0');

            return;
        }
        $jeSpiel = static fn (string $wert): array => array_fill(
            0,
            self::POKAL_RUNDEN,
            array_fill(0, self::POKAL_PAARUNGEN, array_fill(0, self::POKAL_SPIELE, $wert))
        );
        $this->datum1 = $this->datum2 = array_fill(0, self::POKAL_RUNDEN, '');
        $this->modus = array_fill(0, self::POKAL_RUNDEN, '1');
        $this->teama = $this->teamb = array_fill(0, self::POKAL_RUNDEN, array_fill(0, self::POKAL_PAARUNGEN, '0'));
        $this->goala = $this->goalb = $jeSpiel('_');
        $this->mspez = $this->mberi = $this->mtipp = $this->mnote = $jeSpiel('');
        $this->mterm = $jeSpiel('0');
    }

    /**
     * Index des Spieltags, den lmo-openfile.php aus dem Namen eines Abschnitts liest:
     * "Round3" -> 2. Fuer andere Abschnitte ergibt das meist -1.
     */
    public static function spieltagsIndex(string $abschnitt): int
    {
        return (int) substr($abschnitt, 5) - 1;
    }

    /**
     * Uebernimmt eine Zeile der Datei, soweit sie zu einem Spieltag gehoert ([Round1] ...).
     *
     * Spieltag: HS (Handicap), D1/D2 (Datum), im Pokal MO (Spiele je Paarung).
     * Partie: der Schluessel endet auf die Nummer der Partie (TA3, GA3); im Pokal auf Paarung und
     * Spiel (GA31 = Paarung 3, Spiel 1).
     *
     * Aus der Datei wird fuer die Anzeige umgerechnet:
     *  - Tore: -1 -> "_" (nicht gespielt), leer -> -1; in der Liga -2 -> 0 Tore und Wertung am
     *    gruenen Tisch fuer Heim (GA) bzw. Gast (GB); ET=3 -> Wertung gegen beide
     *  - Zusatz SP: 0 -> "&nbsp;", 2 und 1 -> die uebergebenen Anzeigetexte. In der Liga nur mit Spez=1.
     *
     * Zeilen aus anderen Abschnitten werden uebergangen.
     *
     * @param string $anzeigeSp2 Anzeigetext fuer SP=2 (Sprachtext 0)
     * @param string $anzeigeSp1 Anzeigetext fuer SP=1 (Sprachtext 1)
     */
    public function setzeSpieltagswert(string $abschnitt, string $schluessel, string $wert, string $anzeigeSp2, string $anzeigeSp1): void
    {
        $st = self::spieltagsIndex($abschnitt);
        if (substr($abschnitt, 0, 5) === 'Round') {
            $art = substr($schluessel, 0, 2);
            if ($schluessel == 'HS') {
                $this->handp[$st] = $wert;
            } elseif ($schluessel == 'D1') {
                $this->datum1[$st] = $wert;
            } elseif ($schluessel == 'D2') {
                $this->datum2[$st] = $wert;
            }
            $partie = (int) substr($schluessel, 2) - 1;
            if ($art === 'TA') {
                $this->teama[$st][$partie] = $wert;
            } elseif ($art === 'TB') {
                $this->teamb[$st][$partie] = $wert;
            }

            if ($this->art() === self::LIGA) {
                if ($art === 'GA' || $art === 'GB') {
                    $tore = self::toreFuerAnzeige($wert);
                    if ($wert == '-2') {
                        $this->msieg[$st][$partie] = $art === 'GA' ? 1 : 2;
                        $tore = '0';
                    }
                    if ($art === 'GA') {
                        $this->goala[$st][$partie] = $tore;
                    } else {
                        $this->goalb[$st][$partie] = $tore;
                    }
                } elseif ($art === 'SP') {
                    if ($this->spez == 1) {
                        $this->mspez[$st][$partie] = self::zusatzFuerAnzeige($wert, $anzeigeSp2, $anzeigeSp1);
                    }
                } elseif ($art === 'ET') {
                    if ($wert == 3) {
                        $this->msieg[$st][$partie] = 3;
                    }
                } elseif (isset(self::PARTIEWERTE[$art])) {
                    $this->{self::PARTIEWERTE[$art]}[$st][$partie] = $wert;
                }
            } else {
                if ($schluessel == 'MO') {
                    $this->modus[$st] = $wert;
                }
                $paarung = (int) substr($schluessel, 2, -1) - 1;
                $spiel = (int) substr($schluessel, -1) - 1;
                if ($art === 'GA') {
                    $this->goala[$st][$paarung][$spiel] = self::toreFuerAnzeige($wert);
                } elseif ($art === 'GB') {
                    $this->goalb[$st][$paarung][$spiel] = self::toreFuerAnzeige($wert);
                } elseif ($art === 'SP') {
                    $this->mspez[$st][$paarung][$spiel] = self::zusatzFuerAnzeige($wert, $anzeigeSp2, $anzeigeSp1);
                } elseif (isset(self::PARTIEWERTE[$art])) {
                    $this->{self::PARTIEWERTE[$art]}[$st][$paarung][$spiel] = $wert;
                }
            }
            // ein Spieltag ohne Handicap in der Datei bekommt "0"
            if (!isset($this->handp[$st])) {
                $this->handp[$st] = '0';
            }
        }
    }

    /**
     * Bringt das Datum eines Spieltags (D1 und D2) in die Form TT.MM.JJJJ; ein unlesbares Datum
     * wird geleert. lmo-openfile.php ruft das nur fuer den Spieltag der letzten Zeile der Datei auf.
     */
    public function bereinigeSpieltagsdatum(int $spieltag): void
    {
        foreach (['datum1', 'datum2'] as $feld) {
            if (empty($this->{$feld}[$spieltag])) {
                continue;
            }
            $zeit = self::datumAlsZeit((string) $this->{$feld}[$spieltag]);
            $this->{$feld}[$spieltag] = $zeit === false ? '' : date('d.m.Y', $zeit);
        }
    }

    /**
     * Das Datum eines Spieltags aus der Datei (T.M.JJJJ) als Zeitstempel, 0 Uhr.
     *
     * @return int|false false, wenn es leer ist oder es den Tag nicht gibt
     */
    public static function datumAlsZeit(string $datum)
    {
        return Rohdaten\Spieltag::zeitAusDatum($datum) ?? false;
    }

    /**
     * Tore aus der Datei fuer die Anzeige: -1 -> "_" (nicht gespielt), leer -> -1.
     *
     * @return int|string
     */
    private static function toreFuerAnzeige(string $wert)
    {
        if ($wert == '') {
            return -1;
        }

        return $wert == '-1' ? '_' : $wert;
    }

    /** Zusatz SP aus der Datei fuer die Anzeige: 0 -> "&nbsp;", 2 und 1 -> Anzeigetext. */
    private static function zusatzFuerAnzeige(string $wert, string $anzeigeSp2, string $anzeigeSp1): string
    {
        if ($wert == 0) {
            return '&nbsp;';
        }
        if ($wert == 2) {
            return $anzeigeSp2;
        }

        return $wert == 1 ? $anzeigeSp1 : $wert;
    }

    /**
     * Der Abschnitt [News], wie er in die Datei geschrieben wird: die Anzahl (NC) und die Zeilen
     * N0, N1 ... Ohne Newszeilen bleibt der Abschnitt leer.
     *
     * @return list<array{string, string}> Schluessel und Wert je Zeile
     */
    public function newsZumSpeichern(): array
    {
        if (!isset($this->nlines)) {
            return [];
        }
        $anzahl = count($this->nlines);
        $zeilen = [['NC', (string) $anzahl]];
        for ($i = 0; $i < $anzahl; $i++) {
            $zeilen[] = ['N' . $i, (string) ($this->nlines[$i] ?? '')];
        }

        return $zeilen;
    }

    /**
     * Die Abschnitte [Round1] ..., wie sie in die Datei geschrieben werden. Die Umrechnung fuer die
     * Anzeige (setzeSpieltagswert()) wird dabei zurueckgenommen: "_" -> -1, Wertung am gruenen
     * Tisch -> -2 bzw. ET=3, Anzeigetext des Zusatzes -> 2 bzw. 1.
     *
     * Liga: je Spieltag so viele Partien wie Matches. Pokal: die Zahl der Paarungen halbiert sich
     * von Runde zu Runde (bei 24 Mannschaften 8, 8, 4, 2, 1), mit Spiel um Platz 3 hat die
     * letzte Runde eine Paarung mehr; je Paarung so viele Spiele wie der Modus der Runde.
     *
     * Wie der bisherige Code veraendert das Speichern die Liga: Im Pokal steht anzsp danach auf
     * der Zahl der Paarungen der letzten Runde, und fehlende Wertungen (msieg) sind mit 0 belegt.
     *
     * @param string $anzeigeSp2 Anzeigetext fuer SP=2 (Sprachtext 0)
     * @param string $anzeigeSp1 Anzeigetext fuer SP=1 (Sprachtext 1)
     * @return list<array{string, list<array{string, string}>}> je Abschnitt: Name, dann Schluessel und Wert je Zeile
     */
    public function spieltageZumSpeichern(string $anzeigeSp2, string $anzeigeSp1): array
    {
        $pokal = $this->art() === self::POKAL;
        if ($pokal) {
            $this->anzsp = $this->anzteams;
        }
        $abschnitte = [];
        for ($st = 1; $st <= $this->anzst; $st++) {
            $s = $st - 1;
            $zeilen = [];
            if ($this->hands == 1) {
                $zeilen[] = ['HS', (string) ($this->handp[$s] ?? '')];
            }
            $zeilen[] = ['D1', (string) ($this->datum1[$s] ?? '')];
            $zeilen[] = ['D2', (string) ($this->datum2[$s] ?? '')];
            if ($pokal) {
                $zeilen[] = ['MO', (string) ($this->modus[$s] ?? '')];
                if ($this->anzteams == 24 && $st <= 5) {
                    $this->anzsp = [16, 16, 8, 4, 2][$s];
                }
                /** @var int|float|numeric-string $paarungen */
                $paarungen = $this->anzsp;
                $this->anzsp = $paarungen / 2;
                if ($this->klfin == 1 && $st == $this->anzst) {
                    $this->anzsp = $this->anzsp + 1;
                }
            }
            for ($nr = 1; $nr <= $this->anzsp; $nr++) {
                $p = $nr - 1;
                if (!isset($this->msieg[$s][$p])) {
                    $this->msieg[$s][$p] = 0;
                }
                $zeilen[] = ['TA' . $nr, (string) ($this->teama[$s][$p] ?? '')];
                $zeilen[] = ['TB' . $nr, (string) ($this->teamb[$s][$p] ?? '')];
                if (!$pokal) {
                    $wertung = $this->msieg[$s][$p];
                    $zeilen[] = ['GA' . $nr, self::toreFuerDatei($this->goala[$s][$p] ?? '', $wertung == 1)];
                    $zeilen[] = ['GB' . $nr, self::toreFuerDatei($this->goalb[$s][$p] ?? '', $wertung == 2)];
                    if ($wertung == 3) {
                        $zeilen[] = ['ET' . $nr, '3'];
                    }
                    if ($this->spez == 1) {
                        $zusatz = self::zusatzFuerDatei($this->mspez[$s][$p] ?? '', $anzeigeSp2, $anzeigeSp1);
                        if ($zusatz !== null) {
                            $zeilen[] = ['SP' . $nr, $zusatz];
                        }
                    }
                    foreach (self::PARTIEWERTE as $schluessel => $feld) {
                        $zeilen[] = [$schluessel . $nr, (string) ($this->{$feld}[$s][$p] ?? '')];
                    }
                    continue;
                }
                $spiele = $this->modus[$s] ?? 0;
                for ($spiel = 1; $spiel <= $spiele; $spiel++) {
                    $n = $spiel - 1;
                    $zeilen[] = ['GA' . $nr . $spiel, self::toreFuerDatei($this->goala[$s][$p][$n] ?? '', false)];
                    $zeilen[] = ['GB' . $nr . $spiel, self::toreFuerDatei($this->goalb[$s][$p][$n] ?? '', false)];
                    $zusatz = self::zusatzFuerDatei($this->mspez[$s][$p][$n] ?? '', $anzeigeSp2, $anzeigeSp1);
                    if ($zusatz !== null) {
                        $zeilen[] = ['SP' . $nr . $spiel, $zusatz];
                    }
                    foreach (self::PARTIEWERTE as $schluessel => $feld) {
                        $zeilen[] = [$schluessel . $nr . $spiel, (string) ($this->{$feld}[$s][$p][$n] ?? '')];
                    }
                }
            }
            $abschnitte[] = ['Round' . $st, $zeilen];
        }

        return $abschnitte;
    }

    /**
     * Rechnet die aufbereiteten Felder zurueck in Rohdaten: Gegenstueck zu liesRohdaten().
     * Parameter wie optionenZumSpeichern() und spieltageZumSpeichern().
     *
     * Aus den zuletzt gelesenen Rohdaten bleiben erhalten: Einstellungen in [Options], die der LMO
     * nicht kennt, und unbekannte Abschnitte. Unbekannte Schluessel einer Mannschaft oder Partie
     * gehen dagegen verloren: Der alte Code verschiebt Mannschaften und Partien in seinen Feldern,
     * und wohin ein unbekannter Wert dabei gehoert, laesst sich nicht nachvollziehen.
     *
     * @param int|string|null $aktuellerSpieltag
     */
    public function alsRohdaten(string $programm, $aktuellerSpieltag, string $anzeigeSp2, string $anzeigeSp1): Rohdaten\Liga
    {
        $neu = Rohdaten\Liga::ausEintraegen(LigaDatei::eintraege(array_merge(
            [['Options', $this->optionenZumSpeichern($programm, $aktuellerSpieltag)], ['News', $this->newsZumSpeichern()]],
            $this->mannschaftenZumSpeichern(),
            $this->spieltageZumSpeichern($anzeigeSp2, $anzeigeSp1)
        )));
        if ($this->rohdaten !== null) {
            foreach ($this->rohdaten->optionen as $schluessel => $wert) {
                if (!isset(self::OPTIONEN[$schluessel])) {
                    $neu->optionen[$schluessel] = $wert;
                }
            }
            $neu->weitereAbschnitte = $this->rohdaten->weitereAbschnitte;
        }

        return $this->rohdaten = $neu;
    }

    /**
     * Die ganze Ligadatei in der Reihenfolge, in der sie geschrieben wird: [Options], [News],
     * die Mannschaften, die Spieltage, unbekannte Abschnitte. Parameter wie alsRohdaten().
     *
     * @param int|string|null $aktuellerSpieltag
     * @return list<array{string, list<array{string, string}>}> je Abschnitt: Name, dann Schluessel und Wert je Zeile
     */
    public function abschnitteZumSpeichern(string $programm, $aktuellerSpieltag, string $anzeigeSp2, string $anzeigeSp1): array
    {
        return $this->alsRohdaten($programm, $aktuellerSpieltag, $anzeigeSp2, $anzeigeSp1)->abschnitte();
    }

    /**
     * Tore fuer die Datei: "_" (nicht gespielt) -> -1, mit Wertung am gruenen Tisch -> -2.
     *
     * @param mixed $tore
     */
    private static function toreFuerDatei($tore, bool $wertung): string
    {
        if ($tore == '_') {
            return '-1';
        }
        /** @var int|float|string|null $tore */
        return $wertung ? '-2' : (string) $tore;
    }

    /**
     * Zusatz SP fuer die Datei: "_" -> 0, die Anzeigetexte -> 2 bzw. 1. Alles andere (auch der
     * leere Zusatz "&nbsp;") wird nicht geschrieben: null.
     *
     * @param mixed $zusatz
     */
    private static function zusatzFuerDatei($zusatz, string $anzeigeSp2, string $anzeigeSp1): ?string
    {
        if ($zusatz == '_') {
            return '0';
        }
        if ($zusatz == $anzeigeSp2) {
            return '2';
        }

        return $zusatz == $anzeigeSp1 ? '1' : null;
    }

    /**
     * Uebernimmt aus den Eintraegen einer Ligadatei den Abschnitt [Options].
     *
     * @param iterable<array{string, string, string}> $eintraege Ergebnis von LigaDatei::zerlege()
     */
    public function setzeOptionen(iterable $eintraege): void
    {
        foreach ($eintraege as [$abschnitt, $schluessel, $wert]) {
            if ($abschnitt === 'Options') {
                $this->setzeOption($schluessel, $wert);
            }
        }
    }

    /**
     * Liest eine ganze Ligadatei ueber ihre Rohdaten: [Options] mit Vorgabewerten, News,
     * Mannschaften, Spieltage und Partien. Vorher setzeStartwerte() aufrufen.
     * Gelesen wird immer alles; eine leere Liste ergibt eine leere Liga mit allen Vorgabewerten.
     *
     * @param list<array{string, string, string}> $eintraege Ergebnis von LigaDatei::zerlege() bzw. lies()
     * @param string $datumsformat Datumsformat der Installation (Einstellung defdateformat)
     * @param string $anzeigeSp2 Anzeigetext fuer SP=2 (Sprachtext 0)
     * @param string $anzeigeSp1 Anzeigetext fuer SP=1 (Sprachtext 1)
     */
    public function lies(array $eintraege, string $datumsformat, string $anzeigeSp2, string $anzeigeSp1): void
    {
        $this->liesRohdaten(Rohdaten\Liga::ausEintraegen($eintraege), $datumsformat, $anzeigeSp2, $anzeigeSp1);
    }

    /**
     * Erzeugt aus den Rohdaten einer Liga die aufbereiteten Felder fuer den alten Code.
     * Parameter wie lies(). Vorher setzeStartwerte() aufrufen.
     */
    public function liesRohdaten(Rohdaten\Liga $rohdaten, string $datumsformat, string $anzeigeSp2, string $anzeigeSp1): void
    {
        $this->rohdaten = $rohdaten;
        $eintraege = LigaDatei::eintraege($rohdaten->abschnitte());

        $this->setzeOptionen($eintraege);
        $this->ergaenzeVorgabewerte($datumsformat);
        $this->bereiteMannschaftenVor();
        $this->bereiteNewsVor();
        $this->bereiteSpieltageVor();

        $spieltag = null;
        foreach ($eintraege as [$abschnitt, $schluessel, $wert]) {
            $this->setzeNewszeile($abschnitt, $schluessel, $wert);
            $this->setzeMannschaftswert($abschnitt, $schluessel, $wert);
            $spieltag = self::spieltagsIndex($abschnitt);
            $this->setzeSpieltagswert($abschnitt, $schluessel, $wert, $anzeigeSp2, $anzeigeSp1);
        }
        // nur der Spieltag, zu dem die letzte Zeile gehoert (wie bisher; in der Reihenfolge der
        // Rohdaten ist das der letzte Spieltag, wenn kein unbekannter Abschnitt folgt)
        if ($spieltag !== null) {
            $this->bereinigeSpieltagsdatum($spieltag);
        }
        $this->ergaenzeMannschaftsnamen();
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
     * Namen aller aufbereiteten Felder (der oeffentlichen Eigenschaften); zugleich die Namen der
     * Variablen, die lmo-ligadaten.php anbindet.
     *
     * @return string[]
     */
    public static function felder(): array
    {
        static $felder = null;
        if ($felder === null) {
            $felder = [];
            foreach ((new \ReflectionClass(self::class))->getProperties(\ReflectionProperty::IS_PUBLIC) as $eigenschaft) {
                $felder[] = $eigenschaft->getName();
            }
        }

        return $felder;
    }
}
