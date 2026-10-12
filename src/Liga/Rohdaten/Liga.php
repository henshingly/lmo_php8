<?php

namespace Lmo\Liga\Rohdaten;

use Lmo\Liga\Einstellungen;
use Lmo\Liga\LigaDatei;
use Lmo\Liga\Paarung;
use Lmo\Liga\Spiel;

/**
 * Der Inhalt einer Ligadatei (.l98) als Rohdaten: was in der Datei steht, geordnet nach
 * Einstellungen, News, Mannschaften und Spieltagen, aber ohne jede Aufbereitung fuer die Anzeige.
 *
 * Grundsaetze:
 *  - Laden und Speichern sind ein Paar: lies() und schreibe(), ausEintraegen() und abschnitte().
 *    Was geladen wurde, wird unveraendert wieder geschrieben; unbekannte Schluessel und
 *    Abschnitte bleiben erhalten.
 *  - Werte bleiben, wie sie in der Datei stehen (Text). Nichts wird ergaenzt, umgerechnet oder
 *    aufgefuellt: keine Vorgabewerte, keine abgeleiteten Namen, keine Felder fester Groesse.
 *  - Ein mit new angelegtes Objekt ist eine gueltige leere Liga und laesst sich speichern.
 *
 * Wie die Liga angezeigt wird, ist nicht Sache dieser Klasse.
 */
final class Liga
{
    /** Abschnitte mit einem Wert je Mannschaft: Abschnitt => Eigenschaft von Mannschaft */
    private const NAMEN = ['Teams' => 'name', 'Teamm' => 'mittel', 'Teamk' => 'kurz'];

    /**
     * Abschnitt [Options] in der Reihenfolge der Datei, z. B. Name, Type (0 = Liga, 1 = Pokal), Teams.
     *
     * @var array<string, string>
     */
    public array $optionen = [];

    /**
     * Abschnitt [News] in der Reihenfolge der Datei: NC (Anzahl) und die Zeilen N0, N1 ...
     *
     * @var array<string, string>
     */
    public array $news = [];

    /**
     * @var array<int, Mannschaft> Nummer der Mannschaft (ab 1) => Mannschaft
     */
    public array $mannschaften = [];

    /**
     * @var array<int, Spieltag> Nummer des Spieltags (ab 1) => Spieltag
     */
    public array $spieltage = [];

    /**
     * Abschnitte, die diese Klasse nicht kennt, in der Reihenfolge der Datei.
     *
     * @var list<array{string, list<array{string, string}>}> je Abschnitt: Name, dann Schluessel und Wert je Zeile
     */
    public array $weitereAbschnitte = [];

    /** Pokal (KO-Modus) oder Liga, nach der Einstellung Type. Ohne Angabe: Liga. */
    public function istPokal(): bool
    {
        return ($this->optionen['Type'] ?? 0) != 0;
    }

    /** Liest eine Ligadatei. Eine fehlende oder nicht lesbare Datei ergibt eine leere Liga. */
    public static function lies(string $pfad): self
    {
        return self::ausEintraegen(LigaDatei::lies($pfad));
    }

    /**
     * Ordnet die Eintraege einer Ligadatei.
     *
     * @param list<array{string, string, string}> $eintraege Ergebnis von LigaDatei::zerlege(): Abschnitt, Schluessel, Wert
     */
    public static function ausEintraegen(array $eintraege): self
    {
        $liga = new self();
        // der Typ entscheidet, wie die Schluessel der Partien zu lesen sind
        foreach ($eintraege as [$abschnitt, $schluessel, $wert]) {
            if ($abschnitt === 'Options') {
                $liga->optionen[$schluessel] = $wert;
            }
        }
        $pokal = $liga->istPokal();
        $weitere = [];
        foreach ($eintraege as [$abschnitt, $schluessel, $wert]) {
            // Zeilen vor dem ersten Abschnitt gehoeren zu nichts und werden nicht uebernommen
            if ($abschnitt === 'Options' || $abschnitt === '') {
                continue;
            }
            if ($abschnitt === 'News') {
                $liga->news[$schluessel] = $wert;
            } elseif (isset(self::NAMEN[$abschnitt]) && self::istNummer($schluessel)) {
                $liga->mannschaft((int) $schluessel)->{self::NAMEN[$abschnitt]} = $wert;
            } elseif (preg_match('/^Team(\d+)$/', $abschnitt, $treffer) && self::istNummer($treffer[1])) {
                $liga->mannschaft((int) $treffer[1])->werte[$schluessel] = $wert;
            } elseif (preg_match('/^Round(\d+)$/', $abschnitt, $treffer) && self::istNummer($treffer[1])) {
                self::setzeSpieltagswert($liga->spieltag((int) $treffer[1]), $schluessel, $wert, $pokal);
            } else {
                $weitere[$abschnitt][] = [$schluessel, $wert];
            }
        }
        foreach ($weitere as $abschnitt => $zeilen) {
            $liga->weitereAbschnitte[] = [(string) $abschnitt, $zeilen];
        }

        return $liga;
    }

    /**
     * Die ganze Datei in der Reihenfolge, in der der LMO sie schreibt: [Options], [News], [Teams],
     * [Teamm], [Teamk], je Mannschaft [TeamN], je Spieltag [RoundN], danach die unbekannten
     * Abschnitte. Gegenstueck zu ausEintraegen().
     *
     * @return list<array{string, list<array{string, string}>}> je Abschnitt: Name, dann Schluessel und Wert je Zeile
     */
    public function abschnitte(): array
    {
        $abschnitte = [['Options', self::zeilen($this->optionen)], ['News', self::zeilen($this->news)]];
        foreach (self::NAMEN as $abschnitt => $eigenschaft) {
            $zeilen = [];
            foreach ($this->mannschaften as $nr => $mannschaft) {
                if ($mannschaft->$eigenschaft !== null) {
                    $zeilen[] = [(string) $nr, $mannschaft->$eigenschaft];
                }
            }
            $abschnitte[] = [$abschnitt, $zeilen];
        }
        foreach ($this->mannschaften as $nr => $mannschaft) {
            if ($mannschaft->werte !== []) {
                $abschnitte[] = ['Team' . $nr, self::zeilen($mannschaft->werte)];
            }
        }
        $pokal = $this->istPokal();
        foreach ($this->spieltage as $nr => $spieltag) {
            $zeilen = self::zeilen($spieltag->werte);
            foreach ($spieltag->partien as $partieNr => $partie) {
                if ($partie->heim !== null) {
                    $zeilen[] = ['TA' . $partieNr, $partie->heim];
                }
                if ($partie->gast !== null) {
                    $zeilen[] = ['TB' . $partieNr, $partie->gast];
                }
                foreach ($partie->spiele as $spielNr => $werte) {
                    foreach ($werte as $art => $wert) {
                        $zeilen[] = [$art . $partieNr . ($pokal ? $spielNr : ''), $wert];
                    }
                }
            }
            $abschnitte[] = ['Round' . $nr, $zeilen];
        }

        return array_merge($abschnitte, $this->weitereAbschnitte);
    }

    /** Die Datei als Text. */
    public function alsText(): string
    {
        return LigaDatei::alsText($this->abschnitte());
    }

    /** Schreibt die Ligadatei. Gegenstueck zu lies(). */
    public function schreibe(string $pfad): bool
    {
        return LigaDatei::schreibe($pfad, $this->abschnitte());
    }

    /** Die Mannschaft mit dieser Nummer; sie wird angelegt, wenn es sie noch nicht gibt. */
    public function mannschaft(int $nr): Mannschaft
    {
        return $this->mannschaften[$nr] ??= new Mannschaft();
    }

    /** Der Spieltag mit dieser Nummer; er wird angelegt, wenn es ihn noch nicht gibt. */
    public function spieltag(int $nr): Spieltag
    {
        return $this->spieltage[$nr] ??= new Spieltag();
    }

    /**
     * Aendert eine Einstellung der Liga ([Options]), z. B. setzeEinstellung('Rounds', 34).
     * Gelesen werden die Einstellungen ueber einstellungen().
     *
     * @param string $schluessel ein Schluessel, den der LMO kennt (Einstellungen::schluessel())
     * @param int|string $wert
     * @throws \InvalidArgumentException bei einem unbekannten Schluessel (Tippfehler)
     */
    public function setzeEinstellung(string $schluessel, $wert): void
    {
        if (!in_array($schluessel, Einstellungen::schluessel(), true)) {
            throw new \InvalidArgumentException('Unbekannte Einstellung: ' . $schluessel);
        }
        $this->optionen[$schluessel] = (string) $wert;
    }

    /**
     * Ersetzt die Newszeilen der Liga ([News]): NC nennt die Anzahl, N0, N1 ... die Zeilen.
     *
     * @param list<string> $zeilen
     */
    public function setzeNews(array $zeilen): void
    {
        $this->news = ['NC' => (string) count($zeilen)];
        $nr = 0;
        foreach ($zeilen as $zeile) {
            $this->news['N' . $nr++] = $zeile;
        }
    }

    /**
     * Legt hinter der letzten eine neue Mannschaft an und zaehlt die Anzahl der Mannschaften hoch.
     * Spieltage und Partien bleiben, wie sie sind.
     *
     * @return int Nummer der neuen Mannschaft
     */
    public function neueMannschaft(string $name): int
    {
        $nr = $this->einstellungen()->mannschaften() + 1;
        $mannschaft = new Mannschaft();
        $mannschaft->name = $name;
        $this->mannschaften[$nr] = $mannschaft;
        $this->optionen['Teams'] = (string) $nr;

        return $nr;
    }

    /**
     * Nimmt eine Mannschaft aus der Liga:
     *  - ihre Partien fallen weg; die uebrigen des Spieltags ruecken auf, hinten kommen leere dazu
     *  - die Mannschaften hinter ihr bekommen die naechstkleinere Nummer, mit allem, was zu ihnen
     *    gehoert; die Partien, die Lieblingsmannschaft, die vorgewaehlte Mannschaft und die
     *    Auswahl der Fieberkurve folgen den neuen Nummern
     *  - die Anzahl der Mannschaften sinkt um eins; Spieltage und Partien je Spieltag bleiben
     *
     * Eine Nummer, die es nicht gibt, aendert nichts.
     */
    public function entferneMannschaft(int $nr): void
    {
        $e = $this->einstellungen();
        $anzahl = $e->mannschaften();
        if ($nr < 1 || $nr > $anzahl) {
            return;
        }
        for ($st = 1; $st <= $e->spieltage(); $st++) {
            $spieltag = $this->spieltage[$st] ?? null;
            if ($spieltag === null) {
                continue;
            }
            $partien = $e->partienImSpieltag($st);
            // Plaetze des Spieltags der Reihe nach; null: steht nicht in der Datei
            $bleiben = [];
            for ($p = 1; $p <= $partien; $p++) {
                $partie = $spieltag->partien[$p] ?? null;
                if ($partie !== null && ((int) $partie->heim === $nr || (int) $partie->gast === $nr)) {
                    continue;
                }
                $bleiben[] = $partie;
            }
            for ($p = 1; $p <= $partien; $p++) {
                $partie = $p <= count($bleiben) ? $bleiben[$p - 1] : Partie::leer();
                if ($partie === null) {
                    unset($spieltag->partien[$p]);
                    continue;
                }
                foreach (['heim', 'gast'] as $seite) {
                    if ((int) $partie->$seite > $nr) {
                        $partie->$seite = (string) ((int) $partie->$seite - 1);
                    }
                }
                $spieltag->partien[$p] = $partie;
            }
            ksort($spieltag->partien);
        }
        // Fieberkurve: faellt die erste Mannschaft weg, rueckt die zweite an ihre Stelle
        if ((int) ($this->optionen['kurve1'] ?? 0) === $nr) {
            $this->optionen['kurve1'] = $this->optionen['kurve2'] ?? '0';
            $this->optionen['kurve2'] = '0';
        }
        foreach (['favTeam', 'selTeam', 'kurve1', 'kurve2'] as $schluessel) {
            $gewaehlt = (int) ($this->optionen[$schluessel] ?? 0);
            if ($gewaehlt === $nr) {
                $this->optionen[$schluessel] = '0';
            } elseif ($gewaehlt > $nr) {
                $this->optionen[$schluessel] = (string) ($gewaehlt - 1);
            }
        }
        for ($i = $nr; $i < $anzahl; $i++) {
            $this->mannschaften[$i] = $this->mannschaften[$i + 1] ?? new Mannschaft();
        }
        unset($this->mannschaften[$anzahl]);
        ksort($this->mannschaften);
        $this->optionen['Teams'] = (string) ($anzahl - 1);
    }

    /**
     * Die Einstellungen mit ihren Vorgabewerten, so wie der LMO mit ihnen arbeitet.
     * $optionen selbst bleibt, wie es in der Datei steht.
     */
    public function einstellungen(): Einstellungen
    {
        return new Einstellungen($this);
    }

    /**
     * Alle Mannschaften der Liga zum Durchlaufen: Nummer 1 bis zur Anzahl der Mannschaften laut
     * Einstellungen, in dieser Reihenfolge. $mannschaften selbst enthaelt nur, was in der Datei
     * steht, in deren Reihenfolge; eine Mannschaft, die dort fehlt, kommt hier als leere
     * Mannschaft (und wird dabei nicht angelegt).
     *
     *   foreach ($liga->alleMannschaften() as $nr => $mannschaft) { ... }
     *
     * @return \Generator<int, Mannschaft>
     */
    public function alleMannschaften(): \Generator
    {
        $anzahl = $this->einstellungen()->mannschaften();
        for ($nr = 1; $nr <= $anzahl; $nr++) {
            yield $nr => $this->mannschaften[$nr] ?? new Mannschaft();
        }
    }

    /**
     * Die Spiele eines Spieltags zum Anzeigen (Lmo\Liga\Spiel), Partie 1 bis zur Anzahl der Partien
     * dieses Spieltags laut Einstellungen; im Pokal je Paarung so viele Spiele, wie der Modus der
     * Runde (MO) vorsieht. Eine Partie, die in der Datei fehlt, kommt als nicht angesetztes Spiel.
     * Jedes Spiel traegt seinen Spieltag, seine Partie und seine Nummer in der Paarung.
     *
     *   foreach ($liga->spiele(3) as $spiel) { ... }
     *
     * @param int $spieltag Nummer des Spieltags bzw. der Runde, ab 1
     * @return \Generator<int, Spiel>
     */
    public function spiele(int $spieltag): \Generator
    {
        $partien = $this->einstellungen()->partienImSpieltag($spieltag);
        $jePaarung = Paarung::spieleJePaarung($this, $spieltag);
        for ($partie = 1; $partie <= $partien; $partie++) {
            for ($nr = 1; $nr <= $jePaarung; $nr++) {
                yield Spiel::ausRohdaten($this, $spieltag, $partie, $nr);
            }
        }
    }

    /**
     * Die Paarungen einer Runde zum Anzeigen (Lmo\Liga\Paarung), Nummer 1 bis zur Anzahl der
     * Paarungen dieser Runde laut Einstellungen. Jede traegt ihre Spiele (im Pokal so viele, wie
     * der Modus der Runde vorsieht) und weiss, wer gewonnen hat. Eine Paarung, die in der Datei
     * fehlt, kommt ohne Mannschaften.
     *
     *   foreach ($liga->paarungen(1) as $paarung) { ... }
     *
     * @param int $runde Nummer der Runde bzw. des Spieltags, ab 1
     * @return \Generator<int, Paarung>
     */
    public function paarungen(int $runde): \Generator
    {
        $anzahl = $this->einstellungen()->partienImSpieltag($runde);
        $spiele = Paarung::spieleJePaarung($this, $runde);
        for ($nr = 1; $nr <= $anzahl; $nr++) {
            yield Paarung::ausRohdaten($this, $runde, $nr, $spiele);
        }
    }

    /**
     * Alle Spiele der Liga zum Anzeigen, Spieltag 1 bis zur Anzahl der Spieltage laut
     * Einstellungen, je Spieltag wie spiele().
     *
     *   foreach ($liga->alleSpiele() as $spiel) { ... }
     *
     * @return \Generator<int, Spiel>
     */
    public function alleSpiele(): \Generator
    {
        $spieltage = $this->einstellungen()->spieltage();
        for ($spieltag = 1; $spieltag <= $spieltage; $spieltag++) {
            foreach ($this->spiele($spieltag) as $spiel) {
                yield $spiel;
            }
        }
    }

    /**
     * Der Name zum Anzeigen fuer die Nummer einer Mannschaft, wie sie in einer Partie steht
     * (Mannschaft::anzeigename()). Gibt es die Mannschaft nicht: ''.
     *
     * @param int|string $nr
     */
    public function mannschaftsname($nr): string
    {
        return isset($this->mannschaften[$nr]) ? $this->mannschaften[$nr]->anzeigename() : '';
    }

    /**
     * Ordnet eine Zeile aus [RoundN] dem Spieltag oder einer seiner Partien zu.
     *
     * Der Schluessel einer Partie endet auf ihre Nummer (TA3, GA3). Im Pokal folgt bei allen
     * Schluesseln ausser TA/TB noch die Nummer des Spiels als letzte Ziffer (GA31 = Paarung 3,
     * Spiel 1; GA101 = Paarung 10, Spiel 1). D1 und D2 gehoeren trotz ihrer Ziffer zum Spieltag.
     */
    private static function setzeSpieltagswert(Spieltag $spieltag, string $schluessel, string $wert, bool $pokal): void
    {
        if ($schluessel === 'D1' || $schluessel === 'D2' || !preg_match('/^([A-Za-z]+)(\d+)$/', $schluessel, $treffer)) {
            $spieltag->werte[$schluessel] = $wert;

            return;
        }
        [, $art, $ziffern] = $treffer;
        $seite = $art === 'TA' || $art === 'TB';
        $partie = $ziffern;
        $spiel = '1';
        if ($pokal && !$seite) {
            $partie = substr($ziffern, 0, -1);
            $spiel = substr($ziffern, -1);
        }
        // nur was sich beim Schreiben wieder genauso ergibt, ist eine Partie; alles andere bleibt beim Spieltag
        if (!self::istNummer($partie) || !self::istNummer($spiel)) {
            $spieltag->werte[$schluessel] = $wert;

            return;
        }
        $ziel = $spieltag->partien[(int) $partie] ??= new Partie();
        if ($art === 'TA') {
            $ziel->heim = $wert;
        } elseif ($art === 'TB') {
            $ziel->gast = $wert;
        } else {
            $ziel->spiele[(int) $spiel][$art] = $wert;
        }
    }

    /** Eine Nummer ab 1 ohne fuehrende Null: nur sie ergibt beim Schreiben wieder denselben Schluessel. */
    private static function istNummer(string $text): bool
    {
        return preg_match('/^[1-9]\d*$/', $text) === 1;
    }

    /**
     * @param array<int|string, string> $werte
     * @return list<array{string, string}>
     */
    private static function zeilen(array $werte): array
    {
        $zeilen = [];
        foreach ($werte as $schluessel => $wert) {
            $zeilen[] = [(string) $schluessel, $wert];
        }

        return $zeilen;
    }
}
