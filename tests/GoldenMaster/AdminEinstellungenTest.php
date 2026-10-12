<?php

namespace Lmo\Tests\GoldenMaster;

use Lmo\Tests\GoldenMaster\Support\AdminClient;
use Lmo\Tests\GoldenMaster\Support\AssertsSnapshots;
use Lmo\Tests\GoldenMaster\Support\Fixture;
use Lmo\Tests\GoldenMaster\Support\Transcript;
use PHPUnit\Framework\TestCase;

/**
 * Einstellungen einer Liga im Adminbereich (lmo-adminbasic.php, st=-1): jeder Reiter (show=0
 * Grunddaten, 2 Anzeige, 3 Punkte, 4 Tabelle) speichert seine Felder. Festgehalten wird, was
 * danach in der Ligadatei steht und was die Seite anzeigt.
 *
 * Die Felder werden direkt gesendet (nicht ueber das Formular), damit auch nicht angekreuzte
 * Kaestchen und fehlende Felder vorkommen.
 */
final class AdminEinstellungenTest extends TestCase
{
    use AssertsSnapshots;

    private const POKAL = <<<'L98'
[Options]
Title=Liga Manager Online 4
Name=Einstellungspokal
Type=1
Teams=4
KlFin=0

[Teams]
1=Alpha
2=Beta
3=Gamma
4=Delta

[Round1]
D1=16.03.2025
D2=
MO=1
TA1=1
TB1=2
GA11=3
GB11=1
TA2=3
TB2=4
GA21=-1
GB21=-1

L98;

    /** @param array<string, string> $felder */
    private static function speichere(AdminClient $c, string $datei, int $reiter, array $felder): string
    {
        return $c->post('lmoadmin.php', '', [
            'action' => 'admin', 'todo' => 'edit', 'file' => $datei, 'st' => '-1', 'show' => (string) $reiter, 'save' => '1',
        ] + $felder);
    }

    public function testJederReiterEinerLiga(): void
    {
        $c = Fixture::loggedInClient();
        $c->resetChanges();
        $t = new Transcript();
        $liga = 'golden/basic.l98';

        $t->add('Grunddaten', self::speichere($c, $liga, 0, [
            'xtitel' => " Liga O'Neill & Söhne ", 'xgoalfaktor' => '2', 'xpointsfaktor' => 'abc', 'xfavteam' => '3', 'xselteam' => '2',
            'xstat1' => '4', 'xstat2' => '4', 'xnamepkt' => 'Zähler', 'xnametor' => 'Körbe',
        ]), $c->changes());
        $t->add('Grunddaten: leerer Name, Bezeichnungen wie vorgegeben', self::speichere($c, $liga, 0, [
            'xtitel' => '', 'xnamepkt' => 'Pkt.', 'xnametor' => 'Tore', 'xstat1' => '0', 'xstat2' => '5',
        ]), $c->changes());
        $t->add('Anzeige: alles an, eigenes Datumsformat', self::speichere($c, $liga, 2, [
            'xenablegamesort' => 'on', 'xdatm' => 'on', 'xdatfselect' => '1', 'xdatf' => 'd.m.y', 'xdats' => 'on', 'xplan' => 'on',
            'xergebnis' => 'on', 'xmittore' => 'on', 'xdatc' => 'on', 'xonrun' => '1', 'xkurve' => 'on', 'xkreuz' => 'on',
            'xtabelle' => 'on', 'xligastats' => 'on', 'xurlt' => 'on', 'xurlb' => 'on',
        ]), $c->changes());
        $t->add('Anzeige: alles aus', self::speichere($c, $liga, 2, ['xdatf2' => 'j.n.Y', 'xdatc' => 'on']), $c->changes());
        $t->add('Punkte: Minuspunkte, Verlaengerung, Handicap', self::speichere($c, $liga, 3, [
            'xminus' => 'on', 'xspez' => 'on', 'xhands' => 'on', 'xdirekt' => 'on',
            'xpns' => ' 2 ', 'xpnu' => '1', 'xpnn' => '0', 'xpxs' => '2', 'xpxu' => '1', 'xpxn' => '1', 'xpps' => '2', 'xppu' => '0', 'xppn' => '1',
        ]), $c->changes());
        $t->add('Punkte: alles aus, Kegeln', self::speichere($c, $liga, 3, ['xkegel' => 'on', 'xhidr' => 'on', 'xpns' => '3']), $c->changes());
        $t->add('Tabelle', self::speichere($c, $liga, 4, [
            'xeinhinrueck' => 'on', 'xchamp' => 'on', 'xanzcl' => '2', 'xanzck' => '1', 'xanzuc' => '0', 'xanzar' => '1', 'xanzab' => ' 2',
        ]), $c->changes());
        $t->add('Tabelle: alles aus', self::speichere($c, $liga, 4, []), $c->changes());
        foreach ([0, 2, 3, 4] as $reiter) {
            $t->add('Reiter ' . $reiter . ' danach', $c->get('lmoadmin.php', 'action=admin&todo=edit&file=' . $liga . '&st=-1&show=' . $reiter), $c->changes());
        }

        $this->assertMatchesSnapshot('admin-einstellungen', 'liga', $t->text());
    }

    public function testReiterEinesPokals(): void
    {
        $c = Fixture::loggedInClient();
        file_put_contents($c->instance()->ligenDir() . '/einstellpokal.l98', self::POKAL);
        $c->instance()->freezeLeagueTimes();
        $c->resetChanges();
        $t = new Transcript();
        $liga = 'einstellpokal.l98';

        $t->add('Grunddaten', self::speichere($c, $liga, 0, [
            'xtitel' => 'Pokal neu', 'xfavteam' => '1', 'xselteam' => '0', 'xplayoffmode' => '2', 'xstat1' => '3', 'xnamepkt' => 'egal',
        ]), $c->changes());
        $t->add('Anzeige: Spiel um Platz 3, Playdown', self::speichere($c, $liga, 2, [
            'xklfin' => 'on', 'xplaydown' => 'on', 'xplayoffmode' => '1', 'xdats' => 'on', 'xergebnis' => 'on', 'xplan' => 'on', 'xkurve' => 'on',
        ]), $c->changes());
        $t->add('Punkte gibt es im Pokal nicht', self::speichere($c, $liga, 3, ['xminus' => 'on', 'xpns' => '9']), $c->changes());
        $t->add('Tabelle gibt es im Pokal nicht', self::speichere($c, $liga, 4, ['xchamp' => 'on', 'xanzcl' => '9']), $c->changes());
        foreach ([0, 2] as $reiter) {
            $t->add('Reiter ' . $reiter . ' danach', $c->get('lmoadmin.php', 'action=admin&todo=edit&file=' . $liga . '&st=-1&show=' . $reiter), $c->changes());
        }

        $this->assertMatchesSnapshot('admin-einstellungen', 'pokal', $t->text());
    }
}
