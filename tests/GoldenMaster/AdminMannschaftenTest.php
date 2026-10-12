<?php

namespace Lmo\Tests\GoldenMaster;

use Lmo\Tests\GoldenMaster\Support\AdminClient;
use Lmo\Tests\GoldenMaster\Support\AssertsSnapshots;
use Lmo\Tests\GoldenMaster\Support\Fixture;
use Lmo\Tests\GoldenMaster\Support\Transcript;
use PHPUnit\Framework\TestCase;

/**
 * Mannschaften im Adminbereich (lmo-adminteams.php, st=-2): Daten speichern, eine Mannschaft
 * loeschen (team=<Nummer>: ihre Spiele fallen weg, die uebrigen ruecken auf, die Nummern dahinter
 * sinken) und eine anlegen (team=-1). Festgehalten wird, was danach in der Ligadatei steht.
 */
final class AdminMannschaftenTest extends TestCase
{
    use AssertsSnapshots;

    private const POKAL = <<<'L98'
[Options]
Title=Liga Manager Online 4
Name=Mannschaftspokal
Type=1
Teams=8
KlFin=0
favTeam=5
selTeam=3

[Teams]
1=Alpha
2=Beta
3=Gamma
4=Delta
5=Epsilon
6=Zeta
7=Eta
8=Theta

[Team3]
URL=http://example.org/gamma
NOT=Notiz Gamma

[Team5]
NOT=Notiz Epsilon

[Round1]
D1=16.03.2025
D2=18.03.2025
MO=2
TA1=1
TB1=2
GA11=3
GB11=1
AT11=1742135400
GA12=0
GB12=0
TA2=3
TB2=4
GA21=2
GB21=1
NT21=Notiz zum Spiel
TA3=5
TB3=6
GA31=1
GB31=1
SP31=1
TA4=7
TB4=8
GA41=-1
GB41=-1

[Round2]
D1=01.04.2025
D2=
MO=1
TA1=1
TB1=3
GA11=-1
GB11=-1
TA2=5
TB2=0

L98;

    private static function seite(string $datei, string $zusatz = ''): string
    {
        return 'action=admin&todo=edit&file=' . $datei . '&st=-2' . $zusatz;
    }

    private static function ablauf(AdminClient $c, string $datei, Transcript $t): void
    {
        $t->add($datei . ': Mannschaft 3 loeschen', $c->get('lmoadmin.php', self::seite($datei, '&team=3')), $c->changes());
        $t->add($datei . ': letzte Mannschaft loeschen', $c->get('lmoadmin.php', self::seite($datei, '&team=7')), $c->changes());
        $t->add($datei . ': Mannschaft anlegen', $c->get('lmoadmin.php', self::seite($datei, '&team=-1')), $c->changes());
        $t->add($datei . ': Nummer, die es nicht gibt', $c->get('lmoadmin.php', self::seite($datei, '&team=99')), $c->changes());
    }

    public function testSpeichern(): void
    {
        $c = Fixture::loggedInClient();
        $c->resetChanges();
        $t = new Transcript();
        $felder = ['action' => 'admin', 'todo' => 'edit', 'file' => 'golden/penalties.l98', 'st' => '-2', 'save' => '1'];
        for ($i = 1; $i <= 8; $i++) {
            $felder += ['xteams' . $i => 'Verein ' . $i, 'xteamm' . $i => '', 'xteamk' . $i => '', 'xteamu' . $i => '', 'xteamn' . $i => '',
                'xstrafp' . $i => '0', 'xstrafm' . $i => '0', 'xtorkorrektur1' . $i => '0', 'xtorkorrektur2' . $i => '0', 'xstrafdat' . $i => '0'];
        }
        $felder = array_merge($felder, [
            // leerer Name bleibt der alte; Mittel- und Kurzname werden abgeleitet
            'xteams1' => '', 'xteamm1' => '', 'xteamk1' => '',
            // kein Apostroph im Namen: die Statistikdatei (lmo-zustat.php) maskiert ihn erst ab PHP 8.1,
            // ihre Groesse in den Dateiaenderungen haengt sonst von der PHP-Version ab
            'xteams2' => ' SV Oneill/Nord Hinterwalden ', 'xteamm2' => '', 'xteamk2' => '',
            'xteams3' => 'FC Drei', 'xteamm3' => 'Dreier', 'xteamk3' => ' D3 ', 'xteamu3' => ' http://example.org/drei ', 'xteamn3' => ' Notiz & mehr ',
            // Strafen: im Formular positiv = Bonus, in der Datei mit umgekehrtem Vorzeichen
            'xstrafp4' => '3', 'xstrafm4' => '-2', 'xtorkorrektur14' => '-4', 'xtorkorrektur24' => 'abc', 'xstrafdat4' => '7',
        ]);

        $t->add('Mannschaften speichern', $c->post('lmoadmin.php', '', $felder), $c->changes());
        $t->add('Seite danach', $c->get('lmoadmin.php', self::seite('golden/penalties.l98')), $c->changes());

        $this->assertMatchesSnapshot('admin-mannschaften', 'speichern', $t->text());
    }

    public function testLoeschenUndAnlegenInLigen(): void
    {
        $c = Fixture::loggedInClient();
        $c->resetChanges();
        $t = new Transcript();

        self::ablauf($c, 'golden/basic.l98', $t);
        self::ablauf($c, 'golden/penalties.l98', $t);
        self::ablauf($c, 'golden/special.l98', $t);
        $t->add('oeffentlicher Spielplan danach', $c->get('lmo.php', 'file=golden/special.l98&action=program'), $c->changes());

        $this->assertMatchesSnapshot('admin-mannschaften', 'ligen', $t->text());
    }

    public function testLoeschenUndAnlegenImPokal(): void
    {
        $c = Fixture::loggedInClient();
        file_put_contents($c->instance()->ligenDir() . '/mannschaftspokal.l98', self::POKAL);
        $c->instance()->freezeLeagueTimes();
        $c->resetChanges();
        $t = new Transcript();

        self::ablauf($c, 'mannschaftspokal.l98', $t);

        $this->assertMatchesSnapshot('admin-mannschaften', 'pokal', $t->text());
    }
}
