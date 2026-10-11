<?php

namespace Lmo\Tests\Unit\Classlib;

/**
 * stats. Grundliga wie in LigaTableTest:
 *   Spieltag 1: A-B 2:0, C-D 2:1
 *   Spieltag 2: B-C 3:1, D-A 0:1
 */
final class StatsTest extends ClasslibTestCase
{
    private \liga $liga;
    private \stats $stats;

    protected function setUp(): void
    {
        $this->liga = self::league(['A', 'B', 'C', 'D'], [
            [[1, 2, 2, 0], [3, 4, 2, 1]],
            [[2, 3, 3, 1], [4, 1, 0, 1]],
        ], ['Rounds' => 2]);
        $this->stats = new \stats($this->liga);
    }

    private function team(string $name): \team
    {
        return $this->liga->teamForName($name);
    }

    private static function paarungen(array $entries): array
    {
        return array_map(static fn (array $e): string => $e['partie']->heim->name . '-' . $e['partie']->gast->name, $entries);
    }

    public function testOnlyLeaguesAreAccepted(): void
    {
        self::assertSame($this->liga, $this->stats->liga);

        $pokal = self::league(['A', 'B'], [], ['Type' => 1]);
        self::assertNull((new \stats($pokal))->liga);

        $keineLiga = new \team('A');
        self::assertNull((new \stats($keineLiga))->liga);
    }

    public function testLigaStats(): void
    {
        $stats = $this->stats->calcLigaStats(2);

        self::assertSame(
            ['spiele' => 4, 'hSiege' => 3, 'u' => 0, 'gSiege' => 1, 'hTore' => 7, 'gTore' => 3],
            array_slice($stats, 0, 6)
        );
        // hoechster Heimsieg: zwei Partien mit +2
        self::assertSame(['A-B', 'B-C'], self::paarungen($stats['maxhS']));
        self::assertSame([1, 2], array_column($stats['maxhS'], 'spieltag'));
        self::assertSame(['D-A'], self::paarungen($stats['maxgS']));
        self::assertSame(['B-C'], self::paarungen($stats['maxTor']));
    }

    public function testLigaStatsUpToRound(): void
    {
        $stats = $this->stats->calcLigaStats(1);

        self::assertSame([2, 2, 4, 1], [$stats['spiele'], $stats['hSiege'], $stats['hTore'], $stats['gTore']]);
    }

    public function testLigaStatsCountOnlyPlayedGames(): void
    {
        $liga = self::league(['A', 'B', 'C', 'D'], [[[1, 2, 1, 0], [3, 4, -1, -1]]]);

        $stats = (new \stats($liga))->calcLigaStats(1);

        self::assertSame(1, $stats['spiele']);
        self::assertSame(['A-B'], self::paarungen($stats['maxTor']));
    }

    public function testSerien(): void
    {
        $teamA = $this->team('A');
        $teamC = $this->team('C');
        $teamD = $this->team('D');
        self::assertSame(['s' => 2, 'n' => 0, 'u' => 0, 'su' => 2, 'nu' => 0], $this->stats->getSerien($teamA));
        self::assertSame(['s' => 0, 'n' => 2, 'u' => 0, 'su' => 0, 'nu' => 2], $this->stats->getSerien($teamD));
        // C: Sieg, dann Niederlage
        self::assertSame(['s' => 0, 'n' => 1, 'u' => 0, 'su' => 0, 'nu' => 1], $this->stats->getSerien($teamC));
    }

    public function testSerienWithDrawsAndGreenTable(): void
    {
        $liga = self::league(['A', 'B'], [[[1, 2, 1, 1]], [[2, 1, 0, 0]], [[1, 2, -2, 0]]]);
        $stats = new \stats($liga);
        $a = $liga->teamForNumber(1);
        $b = $liga->teamForNumber(2);

        self::assertSame(['s' => 1, 'n' => 0, 'u' => 0, 'su' => 3, 'nu' => 0], $stats->getSerien($a));
        self::assertSame(['s' => 0, 'n' => 1, 'u' => 0, 'su' => 0, 'nu' => 3], $stats->getSerien($b));
    }

    public function testMaxResults(): void
    {
        $teamB = $this->team('B');
        $max = $this->stats->getMaxResults($teamB);

        self::assertSame(['B-C'], self::paarungen($max['sH']));
        self::assertSame([], $max['sA']);
        self::assertSame([], $max['nH']);
        self::assertSame(['A-B'], self::paarungen($max['nA']));
        self::assertSame(['B-C'], self::paarungen($max['Tor']));
    }

    public function testStatsForTeam(): void
    {
        $teamB = $this->team('B');
        $stats = $this->stats->calcStatsForTeam($teamB);

        self::assertSame('1.50', $stats['pkts']);
        self::assertSame('3:3', $stats['tore']);
        self::assertSame('1.50:1.50', $stats['tores']);
        self::assertSame('1(50,00%)', $stats['s']);
        self::assertSame('1(50,00%)', $stats['n']);
        self::assertSame(2, $stats['tabelle']['pos']);
        self::assertSame(['s' => 1, 'n' => 0, 'u' => 0, 'su' => 1, 'nu' => 0], $stats['serie']);
        self::assertSame(0, $stats['chance']);
    }

    public function testStatsForTeams(): void
    {
        $teamA = $this->team('A');
        $teamD = $this->team('D');
        [$a, $d] = $this->stats->calcStatsForTeams($teamA, $teamD);

        self::assertSame('3.00', $a['pkts']);
        self::assertSame('0.00', $d['pkts']);
        // Siegquote: A 100 %, D 0 % -> Anteil 10000:0; Torquote: 3:0,5 -> 8571:1429
        self::assertEqualsWithDelta(92.855, (float)str_replace(',', '.', $a['chance']), 0.01);
        self::assertEqualsWithDelta(7.145, (float)str_replace(',', '.', $d['chance']), 0.01);
    }

    public function testVerlauf(): void
    {
        $teamA = $this->team('A');
        $teamB = $this->team('B');
        $teamD = $this->team('D');
        self::assertSame(['A' => [4, 2]], $this->stats->getVerlaufTeam($teamB));
        self::assertSame(['A' => [1, 1], 'B' => [3, 4]], $this->stats->getVerlaufTeams($teamA, $teamD));
    }

    /** @dataProvider serienTexte */
    public function testSerieToHtml(array $serie, string $html): void
    {
        self::assertSame($html, $this->stats->SerieToHTML($serie + ['s' => 0, 'n' => 0, 'u' => 0, 'su' => 0, 'nu' => 0]));
    }

    public static function serienTexte(): array
    {
        return [
            'keine Spiele' => [[], ''],
            'Siege' => [['s' => 2, 'su' => 2], '2 Sieg(e)<br>2 Spiele o. Niederlage'],
            'Niederlagen' => [['n' => 3, 'nu' => 3], '3 Niederlage(n)<br>3 Spiele o. Sieg'],
            'Unentschieden' => [['u' => 1, 'su' => 4, 'nu' => 2], '1 Unentschieden<br>2 Spiele o. Sieg<br>4 Spiele o. Niederlage'],
        ];
    }

    public function testVerlaufOfATeamOutsideTheLeagueIsEmpty(): void
    {
        $fremd = new \team('Fremd', 'FRE', 99);

        self::assertSame([], $this->stats->getVerlaufTeam($fremd));
        self::assertSame([], $this->stats->getVerlaufTeams($fremd, $fremd));
    }

    public function testStatsForTeamsWithoutPlayedGamesKeepChanceZero(): void
    {
        $liga = self::league(['A', 'B'], [[[1, 2, -1, -1]]], ['Rounds' => 1]);
        $a = $liga->teamForName('A');
        $b = $liga->teamForName('B');

        [$statsA, $statsB] = (new \stats($liga))->calcStatsForTeams($a, $b);

        // bleibt auf dem Startwert: ohne Spiele gibt es nichts zu vergleichen
        self::assertSame(0, $statsA['chance']);
        self::assertSame(0, $statsB['chance']);
    }
}
