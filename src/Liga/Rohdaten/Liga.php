<?php

namespace Lmo\Liga\Rohdaten;

use Lmo\Liga\Einstellungen;
use Lmo\Liga\LigaDatei;

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
     * Die Einstellungen mit ihren Vorgabewerten, so wie der LMO mit ihnen arbeitet.
     * $optionen selbst bleibt, wie es in der Datei steht.
     */
    public function einstellungen(): Einstellungen
    {
        return new Einstellungen($this);
    }

    /**
     * Der Name einer Mannschaft zum Anzeigen. In der Datei steht er mit Schraegstrichen (O\'Neill),
     * hier kommt er ohne zurueck. Gibt es die Mannschaft nicht oder hat sie keinen Namen: ''.
     *
     * @param int|string $nr Nummer der Mannschaft, wie sie in einer Partie steht
     */
    public function mannschaftsname($nr): string
    {
        return stripslashes($this->mannschaften[$nr]->name ?? '');
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
