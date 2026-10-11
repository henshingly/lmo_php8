<?php

namespace Lmo\Tests\Unit\Liga;

use Lmo\Liga\LigaDaten;
use PHPUnit\Framework\TestCase;

/**
 * LigaDaten buendelt die Werte, die lmo-openfile.php aus einer Ligadatei liest.
 */
class LigaDatenTest extends TestCase
{
    public function testFelderAreTheNamesOfTheOldVariables(): void
    {
        $felder = LigaDaten::felder();

        foreach (['titel', 'lmtype', 'anzteams', 'anzst', 'pns', 'teams', 'teamk', 'goala', 'goalb', 'mterm', 'playoffmode'] as $name) {
            self::assertContains($name, $felder);
        }
        self::assertSame($felder, array_unique($felder));
        // kommen (auch) aus dem Seitenaufruf und gehoeren nicht zur Datei
        self::assertNotContains('st', $felder);
        self::assertNotContains('file', $felder);
    }

    public function testNothingIsSetBeforeAFileIsLoaded(): void
    {
        self::assertSame([], array_filter(get_object_vars(new LigaDaten()), static fn ($value): bool => $value !== null));
    }

    /**
     * Laedt eine echte Ligadatei mit dem unveraenderten Lader und prueft, dass Variable und
     * Eigenschaft dieselbe Stelle sind.
     *
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function testLoaderBindsTheOldVariablesToTheObject(): void
    {
        require __DIR__ . '/fixtures/load.php';
        /**
         * Der Lader legt seine Variablen hier im Test an:
         *
         * @var LigaDaten $ligaDaten
         * @var string $titel
         * @var mixed $anzteams
         * @var array<int|string, string> $teams
         * @var array<int, array<int, mixed>> $goala
         * @var mixed $klfin
         */
        self::assertInstanceOf(LigaDaten::class, $ligaDaten);
        self::assertSame('1. Bundesliga 2024/25', $titel);
        self::assertSame($titel, $ligaDaten->titel);
        self::assertSame('18', $ligaDaten->anzteams);
        self::assertSame($teams, $ligaDaten->teams);
        self::assertSame($goala, $ligaDaten->goala);
        self::assertCount(20, $ligaDaten->teams, '18 Mannschaften, Platzhalter 0 und ein Leerfeld');

        // Aendern ueber das Objekt wirkt auf die alte Variable ...
        $ligaDaten->titel = 'Neuer Name';
        $ligaDaten->teams[1] = 'Umbenannt';
        self::assertSame('Neuer Name', $titel);
        self::assertSame('Umbenannt', $teams[1]);

        // ... und umgekehrt, auch wenn alter Code ein ganzes Array neu zuweist
        $anzteams = 4;
        $goala = [[1, 2]];
        self::assertSame(4, $ligaDaten->anzteams);
        self::assertSame([[1, 2]], $ligaDaten->goala);

        // nur fuer Pokal belegt: bleibt fuer eine Liga leer, ohne dass isset() sich aendert
        self::assertNull($ligaDaten->klfin);
        self::assertFalse(isset($klfin));
    }
}
