<?php

namespace Lmo\Tests\Unit\Classlib;

/** liga::loadFile() mit kleinen, von Hand geschriebenen Ligadateien */
final class LigaLoadFileTest extends ClasslibTestCase
{
    private const LIGA = <<<'L98'
[Options]
Title=LMO
Name=Testliga 2024/25
Type=0
Teams=3
Rounds=2
Actual=1
PointsForWin=3
PointsForDraw=1
PointsForLost=0
XtraS=3
XtraU=1
XtraV=0
DatF=d.m.Y H:i
favTeam=2

[Teams]
1=Alpha
2=Beta
3=Gamma

[Teamk]
1=ALP
2=BET
3=GAM

[Teamm]
1=Alpha M
2=Beta M
3=Gamma M

[Team1]
SP=0
URL=http://alpha.example

[Team2]
SP=2
STDA=0

[Team3]
NOT=Gegruendet 1900

[Eigenes]
Foo=Bar

[Round1]
HS=030102
D1=23.08.2024
D2=24.08.2024
TA1=1
TB1=2
GA1=2
GB1=1
SP1=2
NT1=Spielnotiz
BE1=www.bericht.example
TI1=Tor 90.
AT1=1724437800

[Round2]
D1=
D2=31.08.2024
TA1=3
TB1=1
GA1=-1
GB1=-1
SP1=0
NT1=
BE1=
AT1=

L98;

    /** Pokal: ein Spieltag mit Hin- und Rueckspiel (MO=2) */
    private const POKAL = <<<'L98'
[Options]
Name=Pokal
Type=1
Teams=2
Rounds=1

[Teams]
1=Alpha
2=Beta

[Teamk]
1=ALP
2=BET

[Team1]
SP=0

[Team2]
SP=0

[Round1]
D1=01.10.2024
D2=08.10.2024
MO=2
TA1=1
TB1=2
GA11=1
GB11=0
AT11=1727802000
GA12=2
GB12=2
AT12=1728406800

L98;

    private function load(string $content): \liga
    {
        $liga = new \liga();
        self::assertTrue($liga->loadFile($this->leagueFile($content)));
        return $liga;
    }

    public function testMetadata(): void
    {
        $file = $this->leagueFile(self::LIGA);
        touch($file, mktime(10, 0, 0, 3, 1, 2025));
        clearstatcache();
        $liga = new \liga();
        $liga->loadFile($file);

        self::assertSame('Testliga 2024/25', $liga->name);
        self::assertSame($file, $liga->fileName);
        self::assertSame(mktime(10, 0, 0, 3, 1, 2025), $liga->ligaDatum);
    }

    public function testExistingNameIsKept(): void
    {
        $liga = new \liga('Eigener Name');
        $liga->loadFile($this->leagueFile(self::LIGA));

        self::assertSame('Eigener Name', $liga->name);
        self::assertSame('Eigener Name', $liga->options->keyValues['Name']);
    }

    public function testTeams(): void
    {
        $liga = $this->load(self::LIGA);

        self::assertSame(['Alpha', 'Beta', 'Gamma'], $liga->teamNames());
        $alpha = $liga->teamForNumber(1);
        self::assertSame(1, $alpha->nr);
        self::assertSame('ALP', $alpha->kurz);
        self::assertSame('Alpha M', $alpha->mittel);
        self::assertSame('http://alpha.example', $alpha->keyValues['URL']);
        self::assertSame('2', $liga->teamForNumber(2)->keyValues['SP']);
        self::assertSame('Gegruendet 1900', $liga->teamForNumber(3)->keyValues['NOT']);
        // Standardwerte bleiben, wenn die Datei sie nicht nennt
        self::assertSame(0, $liga->teamForNumber(3)->keyValues['SP']);
    }

    public function testRounds(): void
    {
        $liga = $this->load(self::LIGA);

        self::assertSame(2, $liga->spieltageCount());
        $eins = $liga->SpieltagForNumber(1);
        self::assertSame(mktime(0, 0, 0, 8, 23, 2024), $eins->von);
        self::assertSame(mktime(0, 0, 0, 8, 24, 2024), $eins->bis);
        $zwei = $liga->SpieltagForNumber(2);
        self::assertNull($zwei->von);
        self::assertSame('31.08.2024', $zwei->vonBisString());
    }

    public function testMatches(): void
    {
        $liga = $this->load(self::LIGA);

        self::assertSame(2, $liga->partienCount());
        $partie = $liga->SpieltagForNumber(1)->partieForNumber(1);
        self::assertSame($liga->teamForNumber(1), $partie->heim);
        self::assertSame($liga->teamForNumber(2), $partie->gast);
        self::assertEquals(2, $partie->hTore);
        self::assertEquals(1, $partie->gTore);
        self::assertSame('Spielnotiz', $partie->notiz);
        self::assertSame('1724437800', $partie->zeit);
        self::assertSame('23.08.2024', $partie->datumString());
        self::assertSame('www.bericht.example', $partie->getreportUrl(null));
        self::assertSame('Tor 90.', $partie->getParameter('TI'));
        // Liga und Spieltag teilen sich die Partie-Objekte
        self::assertSame($liga->partieForNumber(1), $partie);

        $offen = $liga->SpieltagForNumber(2)->partieForNumber(1);
        self::assertSame(-1, $offen->valuateGame());
        self::assertSame('', $offen->datumString());
    }

    public function testRoundValuesWithoutMatchNumberAreKept(): void
    {
        $liga = $this->load(self::LIGA);

        // HS = Handicap-Reihenfolge, gehoert zum Spieltag und nicht zu einer Partie
        self::assertSame('030102', $liga->SpieltagForNumber(1)->getParameter('HS'));
        self::assertSame([], $liga->SpieltagForNumber(2)->getParameter());
        self::assertSame(1, $liga->SpieltagForNumber(1)->partienCount());
        self::assertSame(['Eigenes' => ['Foo' => 'Bar']], $liga->sections);
    }

    public function testMatchValuesMayPrecedeTheTeams(): void
    {
        // SP1 und ET1 stehen vor TA1: die Nummer im Schluessel bestimmt die Partie, nicht die Reihenfolge
        $content = str_replace("SP1=2\nNT1=Spielnotiz", 'NT1=Spielnotiz', self::LIGA);
        $content = str_replace("[Round1]\nHS=030102\n", "[Round1]\nHS=030102\nSP1=2\nET1=3\nGB1=1\n", $content);
        self::assertStringContainsString("SP1=2\nET1=3\nGB1=1\nD1=23.08.2024", $content);

        $partie = $this->load($content)->SpieltagForNumber(1)->partieForNumber(1);

        self::assertSame(2, $partie->getSpielEnde());
        self::assertSame('3', $partie->getParameter('ET'));
        self::assertSame(['Alpha', 'Beta'], [$partie->heim->name, $partie->gast->name]);
        self::assertEquals([2, 1], [$partie->hTore, $partie->gTore]);
    }

    public function testMatchEndIsRead(): void
    {
        $liga = $this->load(self::LIGA);

        self::assertSame(2, $liga->partieForNumber(1)->getSpielEnde());
        self::assertSame(0, $liga->partieForNumber(2)->getSpielEnde());
    }

    public function testOptionsAndUnknownSections(): void
    {
        $liga = $this->load(self::LIGA);

        self::assertSame('3', $liga->options->keyValues['PointsForWin']);
        self::assertSame('2', $liga->options->keyValues['favTeam']);
        // Standardwert der optionsSektion, in der Datei nicht vorhanden
        self::assertSame(1, $liga->options->keyValues['Graph']);
        self::assertSame(['Eigenes' => ['Foo' => 'Bar']], $liga->sections);
    }

    public function testLoadedLeagueCalculatesTable(): void
    {
        $table = $this->load(self::LIGA)->calcTable(2);

        // Beta hat 2 Strafpunkte
        self::assertSame(['Alpha', 'Gamma', 'Beta'], self::order($table));
        self::assertSame(-2, self::row($table, 'Beta')['pPkt']);
    }

    public function testCupRoundWithTwoLegs(): void
    {
        $liga = $this->load(self::POKAL);

        $runde = $liga->SpieltagForNumber(1);
        self::assertEquals(2, $runde->getModus());
        self::assertSame(2, $runde->partienCount());

        [$hin, $rueck] = $runde->partien;
        self::assertSame(['Alpha', 'Beta', '1', '0', '11'], [$hin->heim->name, $hin->gast->name, $hin->hTore, $hin->gTore, $hin->spNr]);
        // Rueckspiel: Heimrecht getauscht
        self::assertSame(['Beta', 'Alpha', '2', '2', '12'], [$rueck->heim->name, $rueck->gast->name, $rueck->hTore, $rueck->gTore, $rueck->spNr]);
        self::assertSame('08.10.2024', $rueck->datumString());
    }

    public function testInvalidFiles(): void
    {
        $liga = new \liga();

        self::assertFalse($liga->loadFile(''));
        self::assertFalse($liga->loadFile(sys_get_temp_dir() . '/lmo-gibt-es-nicht-' . uniqid() . '.l98'));
        self::assertFalse($liga->loadFile($this->tempDir()));
    }

    /** @return array<string, array{string}> */
    public static function brokenDates(): array
    {
        return [
            'Text' => ['ab.cd.efgh'],
            'unvollstaendig' => ['23.08.'],
            'kein Kalendertag' => ['31.02.2024'],
            'zu viele Teile' => ['1.2.3.4'],
            'ohne Punkte' => ['morgen'],
        ];
    }

    /**
     * Ein unlesbares Spieltagsdatum in der Ligadatei gilt als fehlend; die Liga wird trotzdem geladen.
     *
     * @dataProvider brokenDates
     */
    public function testBrokenRoundDateIsTreatedAsMissing(string $date): void
    {
        $content = str_replace('D1=23.08.2024', 'D1=' . $date, self::LIGA, $count);
        self::assertSame(1, $count);

        $eins = $this->load($content)->SpieltagForNumber(1);

        self::assertNull($eins->von);
        self::assertSame(mktime(0, 0, 0, 8, 24, 2024), $eins->bis);
        self::assertSame(1, $eins->partienCount());
    }
}
