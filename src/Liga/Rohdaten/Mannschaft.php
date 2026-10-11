<?php

namespace Lmo\Liga\Rohdaten;

/**
 * Eine Mannschaft, wie sie in der Ligadatei steht: Name ([Teams]), Kurzname ([Teamk]),
 * Mittelname ([Teamm]) und die Werte ihres Abschnitts [TeamN].
 *
 * null heisst: steht nicht in der Datei. Die Klasse leitet nichts ab; einen fehlenden Kurz- oder
 * Mittelnamen aus dem Namen zu bilden ist Sache dessen, der ihn anzeigen will.
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
}
