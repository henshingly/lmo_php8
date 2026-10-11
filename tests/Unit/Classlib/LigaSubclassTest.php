<?php

namespace Lmo\Tests\Unit\Classlib;

/**
 * ligaFussball, ligaHandball und liga::factory().
 *
 * Bei Gleichstand ohne Entscheidung sortiert array_multisort() nach dem Teamnamen absteigend
 * (B vor A). Die Szenarien lassen deshalb A das direkte Duell gewinnen: Steht A vorn, hat der
 * direkte Vergleich entschieden.
 */
final class LigaSubclassTest extends ClasslibTestCase
{
    public function testFootballTableWithoutTies(): void
    {
        $liga = self::league(['A', 'B', 'C', 'D'], [
            [[1, 2, 2, 0], [3, 4, 2, 1]],
            [[2, 3, 3, 1], [4, 1, 0, 1]],
        ], [], 'ligaFussball');

        $table = $liga->calcTable(2);

        self::assertSame(['A', 'B', 'C', 'D'], self::order($table));
        self::assertSame([1, 2, 3, 4], array_column($table, 'pos'));
    }

    /**
     * A und B: 3 Punkte, 2 Spiele, 1:1 Tore. A gewann das direkte Duell.
     *   Spieltag 1: A-B 1:0, C-D 2:2
     *   Spieltag 2: C-A 1:0, B-D 1:0
     */
    public function testFootballDirectComparison(): void
    {
        $liga = self::league(['A', 'B', 'C', 'D'], [
            [[1, 2, 1, 0], [3, 4, 2, 2]],
            [[3, 1, 1, 0], [2, 4, 1, 0]],
        ], [], 'ligaFussball');

        self::assertSame(['C', 'A', 'B', 'D'], self::order($liga->calcTable(2)));
    }

    /**
     * Handball (§43 DHB): Punkte, Spiele, dann direkter Vergleich vor der Tordifferenz.
     *   Spieltag 1: A-B 1:0, C-D 0:0
     *   Spieltag 2: A-C 0:5, B-D 1:0
     * A und B je 2 Punkte (2-1-0), C 3, D 1. B hat die bessere Tordifferenz.
     */
    public function testHandballDirectComparisonAtTop(): void
    {
        $liga = self::league(['A', 'B', 'C', 'D'], [
            [[1, 2, 1, 0], [3, 4, 0, 0]],
            [[1, 3, 0, 5], [2, 4, 1, 0]],
        ], ['PointsForWin' => 2], 'ligaHandball');

        self::assertSame(['C', 'A', 'B', 'D'], self::order($liga->calcTable(2)));
    }

    /**
     * A und B punktgleich am Tabellenende, A gewann das direkte Duell.
     *   Spieltag 1: A-B 1:0, C-D 2:2
     *   Spieltag 2: B-C 1:0, A-D 0:5
     *   Spieltag 3: C-A 4:0, D-B 3:0
     */
    public function testHandballDirectComparisonAtBottom(): void
    {
        $liga = self::league(['A', 'B', 'C', 'D'], [
            [[1, 2, 1, 0], [3, 4, 2, 2]],
            [[2, 3, 1, 0], [1, 4, 0, 5]],
            [[3, 1, 4, 0], [4, 2, 3, 0]],
        ], [], 'ligaHandball');

        self::assertSame(['D', 'C', 'A', 'B'], self::order($liga->calcTable(3)));
    }

    public function testHandballDirectTableSortsByGoalDifference(): void
    {
        $liga = new \ligaHandball();
        $rows = [
            ['team' => new \team('A'), 'pPkt' => 2, 'spiele' => 2, 'dTor' => -1],
            ['team' => new \team('B'), 'pPkt' => 2, 'spiele' => 2, 'dTor' => 3],
            ['team' => new \team('C'), 'pPkt' => 4, 'spiele' => 2, 'dTor' => -5],
        ];

        $sorted = $liga->sortDirectTable($rows);

        self::assertSame(['C', 'B', 'A'], self::order($sorted));
        self::assertSame([1, 2, 3], array_column($sorted, 'pos'));
    }

    public function testFactoryCreatesClassFromLeagueType(): void
    {
        $file = $this->leagueFile("[Options]\nName=Handball\nLigaType=Handball\n\n[Teams]\n1=A\n");

        self::assertInstanceOf(\ligaHandball::class, \liga::factory($file));
    }

    public function testFactoryWithoutLeagueType(): void
    {
        $file = $this->leagueFile("[Options]\nName=Liga\n\n[Teams]\n1=A\n");

        $liga = \liga::factory($file);

        self::assertSame(\liga::class, get_class($liga));
    }

    public function testFactoryWithMissingFile(): void
    {
        self::assertNull(\liga::factory(sys_get_temp_dir() . '/lmo-gibt-es-nicht-' . uniqid() . '.l98'));
    }

    /** @return array<string, array{string}> */
    public static function leagueClasses(): array
    {
        return ['liga' => ['liga'], 'ligaFussball' => ['ligaFussball'], 'ligaHandball' => ['ligaHandball']];
    }

    /**
     * Eine Tabelle ohne Zeilen (Liga ohne Teams) bleibt leer; vorher fehlten die Sortierspalten.
     *
     * @dataProvider leagueClasses
     */
    public function testSortingAnEmptyTable(string $class): void
    {
        $liga = self::league([], [], [], $class);

        self::assertSame([], $liga->sortTable([]));
    }

    public function testHandballSortingAnEmptyDirectTable(): void
    {
        /** @var \ligaHandball $liga */
        $liga = self::league([], [], [], 'ligaHandball');

        self::assertSame([], $liga->sortDirectTable([]));
    }

    /** LigaType steht im Abschnitt [Options]; eine gleichnamige Zeile woanders zaehlt nicht. */
    public function testFactoryReadsTheLeagueTypeFromOptionsOnly(): void
    {
        $file = $this->leagueFile("[Options]\nName=Liga\n\n[Eigenes]\nLigaType=Handball\n\n[Teams]\n1=A\n");

        self::assertSame(\liga::class, get_class(\liga::factory($file)));
    }

    public function testFactoryWithUnknownLeagueType(): void
    {
        $file = $this->leagueFile("[Options]\nLigaType=Gibtesnicht\n");

        self::assertSame(\liga::class, get_class(\liga::factory($file)));
    }
}
