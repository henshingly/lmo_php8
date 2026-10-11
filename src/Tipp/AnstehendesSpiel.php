<?php

namespace Lmo\Tipp;

/**
 * Ein Spiel, das in den naechsten Tagen ansteht, fertig zum Anzeigen: fuer die Tippuebersicht ueber
 * alle Ligen eines Tippers und fuer die Erinnerungsmail. Jedes Spiel traegt, was die Anzeige von
 * seiner Liga wissen muss, weil in einer Liste Spiele aus mehreren Ligen stehen.
 *
 * Gefuellt wird es von lmo-tippopenfileviewer.php bzw. lmo-tippemailviewer.php aus den Rohdaten
 * der Liga (Lmo\Liga\Rohdaten\Liga); die Erinnerungsmail braucht nur einen Teil der Werte.
 */
final class AnstehendesSpiel
{
    // --- die Liga

    /** Name der Liga */
    public string $titel = '';

    /** @var int|string Type: 0 = Liga, sonst Pokal */
    public $typ = 0;

    /** Anzahl der Runden, wie sie sich im Pokal aus der Anzahl der Mannschaften ergibt (fuer "Finale", "Halbfinale" ...) */
    public int $runden = 0;

    /** HideDraw: Unentschieden kann nicht getippt werden */
    public bool $ohneUnentschieden = false;

    /** DatS: Datum des Spieltags anzeigen */
    public bool $mitSpieltagsdatum = true;

    /** DatM: Anstosszeit anzeigen */
    public bool $mitAnstosszeit = false;

    /** urlB: Spielberichte verlinken */
    public bool $mitSpielbericht = false;

    /** Spez: Zusatz (n.V., i.E.) anzeigen; im Pokal immer */
    public bool $mitZusatz = false;

    /** goalfaktor: Teiler fuer die Anzeige der Tore */
    public int $torfaktor = 1;

    // --- der Spieltag

    /** @var int|string Spiele je Paarung: in der Liga 1, im Pokal der Modus der Runde */
    public $spieleJePaarung = 1;

    /** Erster Tag des Spieltags als TT.MM.JJJJ, sonst '' */
    public string $ersterTag = '';

    /** Letzter Tag des Spieltags als TT.MM.JJJJ, sonst '' */
    public string $letzterTag = '';

    // --- das Spiel

    /** Name der Heimmannschaft; die Lieblingsmannschaft der Liga ist in der Tippuebersicht mit <strong> hervorgehoben */
    public string $heim = '';

    /** Name der Gastmannschaft, wie $heim */
    public string $gast = '';

    /** @var int|string Tore der Heimmannschaft, "_" = nicht gespielt */
    public $toreHeim = '_';

    /** @var int|string Tore der Gastmannschaft, "_" = nicht gespielt */
    public $toreGast = '_';

    /** @var int|string Zusatz zum Ergebnis als Anzeigetext (n.V., i.E.), "&nbsp;" = keiner */
    public $zusatz = '&nbsp;';

    /** @var int|string 0 = keine, 1 = am gruenen Tisch fuer Heim, 2 = fuer Gast, 3 = gegen beide */
    public $wertung = 0;

    /** Notiz zum Spiel, mit Schraegstrichen fuer die Ausgabe in JavaScript */
    public string $notiz = '';

    /** Link zum Spielbericht, wie $notiz */
    public string $bericht = '';

    /** @var int|string TI: 1 = das Spiel wird im Tippspiel nicht gewertet */
    public $ohneTippwertung = 0;

    /** @var int|string Anstoss als Unix-Zeitstempel, 0 oder '' = keiner */
    public $anstoss = 0;
}
