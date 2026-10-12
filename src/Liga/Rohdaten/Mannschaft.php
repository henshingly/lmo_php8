<?php

namespace Lmo\Liga\Rohdaten;

/**
 * Eine Mannschaft, wie sie in der Ligadatei steht: Name ([Teams]), Kurzname ([Teamk]),
 * Mittelname ([Teamm]) und die Werte ihres Abschnitts [TeamN].
 *
 * null heisst: steht nicht in der Datei. Die Eigenschaften bleiben, wie sie in der Datei stehen;
 * zum Anzeigen gibt es anzeigename(), kurzname() und mittelname(), die einen fehlenden Kurz- oder
 * Mittelnamen aus dem Namen bilden.
 */
final class Mannschaft
{
    public ?string $name = null;
    public ?string $kurz = null;
    public ?string $mittel = null;

    /**
     * Abschnitt [TeamN] in der Reihenfolge der Datei: SP/SM (Strafpunkte plus/minus), TOR1/TOR2
     * (Torkorrektur), STDA (Spieltag, ab dem die Strafe gilt), URL, NOT (Notiz) und Unbekanntes.
     *
     * @var array<string, string>
     */
    public array $werte = [];

    /**
     * Der Name zum Anzeigen. In der Datei steht er mit Schraegstrichen (O\'Neill), hier kommt er
     * ohne zurueck; ohne Namen ''. $name selbst bleibt, wie es in der Datei steht.
     */
    public function anzeigename(): string
    {
        return stripslashes($this->name ?? '');
    }

    /**
     * Der Kurzname zum Anzeigen: der aus der Datei, sonst die ersten 5 Zeichen des Namens.
     */
    public function kurzname(): string
    {
        $kurz = stripslashes($this->kurz ?? '');

        return $kurz != '' ? $kurz : trim(substr($this->anzeigename(), 0, 5));
    }

    /**
     * Der Mittelname zum Anzeigen: der aus der Datei, sonst das laengste Wort des Namens (bei
     * gleicher Laenge das letzte), hoechstens 12 Zeichen. Woerter trennen Leerzeichen, "|" und "/".
     */
    public function mittelname(): string
    {
        $mittel = stripslashes($this->mittel ?? '');
        if ($mittel != '') {
            return $mittel;
        }
        foreach (preg_split('%[ |/]%', $this->anzeigename()) ?: [] as $wort) {
            if (strlen($wort) >= strlen($mittel)) {
                $mittel = trim(substr($wort, 0, 12));
            }
        }

        return $mittel;
    }

    /** Setzt die Adresse der Mannschaft im Netz (URL). */
    public function setzeUrl(string $url): void
    {
        $this->werte['URL'] = $url;
    }

    /** Setzt die Notiz zur Mannschaft (NOT). */
    public function setzeNotiz(string $notiz): void
    {
        $this->werte['NOT'] = $notiz;
    }

    /**
     * Setzt die Strafpunkte (SP): Sie werden von den Pluspunkten abgezogen; ein negativer Wert ist
     * ein Bonus.
     */
    public function setzeStrafpunkte(int $punkte): void
    {
        $this->werte['SP'] = (string) $punkte;
    }

    /** Setzt die Strafe bei den Minuspunkten (SM), fuer Ligen mit Minuspunkten; Vorzeichen wie bei setzeStrafpunkte(). */
    public function setzeStrafminuspunkte(int $punkte): void
    {
        $this->werte['SM'] = (string) $punkte;
    }

    /** Setzt die Torkorrektur (TOR1 Tore, TOR2 Gegentore): Sie wird abgezogen; negativ = Bonus. */
    public function setzeTorkorrektur(int $tore, int $gegentore): void
    {
        $this->werte['TOR1'] = (string) $tore;
        $this->werte['TOR2'] = (string) $gegentore;
    }

    /** Setzt den Spieltag, ab dem Strafe und Torkorrektur gelten (STDA); 0 = von Anfang an. */
    public function setzeStrafeAbSpieltag(int $spieltag): void
    {
        $this->werte['STDA'] = (string) $spieltag;
    }
}
