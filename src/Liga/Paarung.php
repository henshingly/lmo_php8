<?php

namespace Lmo\Liga;

/**
 * Eine Paarung zum Anzeigen: zwei Mannschaften und ihre Spiele gegeneinander in einer Runde. Im
 * Pokal hat eine Paarung so viele Spiele, wie der Modus der Runde vorsieht (Hin- und Rueckspiel,
 * Best of 3 ...), und einen Sieger, der weiterkommt. In der Liga besteht sie aus einem Spiel.
 *
 * Die Klasse liest nur; die Rohdaten bleiben, wie sie in der Datei stehen.
 *
 *   foreach ($liga->paarungen(1) as $paarung) {
 *       echo $paarung->heimMannschaft()->anzeigename(), ' - ', $paarung->gastMannschaft()->anzeigename();
 *       foreach ($paarung->spiele as $spiel) { ... }
 *   }
 */
final class Paarung
{
    /** Nummer der Runde (in der Liga: des Spieltags), ab 1 */
    public int $runde;

    /** Nummer der Paarung in der Runde, ab 1 */
    public int $nr;

    /** Nummer der Heimmannschaft (des ersten Spiels), 0 = keine. Die Mannschaft selbst: heimMannschaft() */
    public int $heim = 0;

    /** Nummer der Gastmannschaft, 0 = keine. Die Mannschaft selbst: gastMannschaft() */
    public int $gast = 0;

    /**
     * Die Spiele der Paarung in ihrer Reihenfolge, so viele wie der Modus der Runde vorsieht;
     * ein Spiel, das in der Datei fehlt, ist dabei als nicht gespielt enthalten.
     *
     * @var list<Spiel>
     */
    public array $spiele = [];

    /** Die Liga, aus der die Paarung stammt; daraus kommen die Mannschaften */
    private Rohdaten\Liga $liga;

    private function __construct(Rohdaten\Liga $liga, int $runde, int $nr)
    {
        $this->liga = $liga;
        $this->runde = $runde;
        $this->nr = $nr;
    }

    /**
     * Die Paarung einer Runde aus den Rohdaten der Liga.
     *
     * @param int $spiele Spiele je Paarung nach dem Modus der Runde; null = aus den Rohdaten (MO, in der Liga 1)
     */
    public static function ausRohdaten(Rohdaten\Liga $liga, int $runde, int $nr, ?int $spiele = null): self
    {
        $paarung = new self($liga, $runde, $nr);
        $spiele ??= self::spieleJePaarung($liga, $runde);
        for ($spielNr = 1; $spielNr <= $spiele; $spielNr++) {
            $paarung->spiele[] = Spiel::ausRohdaten($liga, $runde, $nr, $spielNr);
        }
        $roh = $liga->spieltage[$runde]->partien[$nr] ?? null;
        if ($roh !== null) {
            $paarung->heim = $roh->heim !== null && is_numeric($roh->heim) ? (int) $roh->heim : 0;
            $paarung->gast = $roh->gast !== null && is_numeric($roh->gast) ? (int) $roh->gast : 0;
        }

        return $paarung;
    }

    /**
     * Spiele je Paarung in dieser Runde: in der Liga 1, im Pokal der Modus der Runde (MO); ohne
     * oder mit unlesbarer Angabe 1.
     */
    public static function spieleJePaarung(Rohdaten\Liga $liga, int $runde): int
    {
        if (!$liga->istPokal()) {
            return 1;
        }
        $modus = $liga->spieltage[$runde]->werte['MO'] ?? 1;

        return is_numeric($modus) ? max(0, (int) $modus) : 1;
    }

    /** Die Heimmannschaft aus den Rohdaten der Liga; steht keine fest, eine leere Mannschaft */
    public function heimMannschaft(): Rohdaten\Mannschaft
    {
        return $this->liga->mannschaften[$this->heim] ?? new Rohdaten\Mannschaft();
    }

    /** Die Gastmannschaft, wie heimMannschaft() */
    public function gastMannschaft(): Rohdaten\Mannschaft
    {
        return $this->liga->mannschaften[$this->gast] ?? new Rohdaten\Mannschaft();
    }

    /**
     * Wer die Paarung gewonnen hat, nach den bisher gespielten Spielen.
     *
     *  - ein Spiel: wer mehr Tore hat
     *  - zwei Spiele (Hin- und Rueckspiel): sobald das Rueckspiel gespielt ist, wer in beiden
     *    zusammen mehr Tore hat; bei Gleichstand, wer im Rueckspiel mehr Tore hat
     *  - mehr Spiele (Best of 3, 5, 7): wer mehr als die Haelfte der Spiele gewonnen hat
     *
     * @return int 1 = Heim, 2 = Gast, 0 = noch nicht entschieden
     */
    public function sieger(): int
    {
        // je gespieltem Spiel: Tore Heim, Tore Gast; null = nicht gespielt
        $ergebnisse = [];
        foreach ($this->spiele as $spiel) {
            $ergebnisse[] = $spiel->toreHeim !== null && $spiel->toreGast !== null ? [$spiel->toreHeim, $spiel->toreGast] : null;
        }
        $anzahl = count($ergebnisse);
        if ($anzahl === 1) {
            return $ergebnisse[0] === null ? 0 : self::vergleich($ergebnisse[0][0], $ergebnisse[0][1]);
        }
        if ($anzahl === 2) {
            [$hin, $rueck] = $ergebnisse;
            if ($hin === null || $rueck === null) {
                return 0;
            }
            $gesamt = self::vergleich($hin[0] + $rueck[0], $hin[1] + $rueck[1]);

            return $gesamt !== 0 ? $gesamt : self::vergleich($rueck[0], $rueck[1]);
        }
        $siege = [0, 0, 0];
        foreach ($ergebnisse as $ergebnis) {
            if ($ergebnis !== null) {
                $siege[self::vergleich($ergebnis[0], $ergebnis[1])]++;
            }
        }
        if ($siege[1] > $anzahl / 2) {
            return 1;
        }

        return $siege[2] > $anzahl / 2 ? 2 : 0;
    }

    /** @return int 1 = der erste Wert ist groesser, 2 = der zweite, 0 = gleich */
    private static function vergleich(int $heim, int $gast): int
    {
        return $heim > $gast ? 1 : ($heim < $gast ? 2 : 0);
    }
}
