<?php

namespace Lmo\Tests\GoldenMaster;

use Lmo\Tests\GoldenMaster\Support\AdminClient;
use Lmo\Tests\GoldenMaster\Support\AssertsSnapshots;
use Lmo\Tests\GoldenMaster\Support\Fixture;
use Lmo\Tests\GoldenMaster\Support\Transcript;
use PHPUnit\Framework\TestCase;

/**
 * Ergebnisse eines Spieltags im Adminbereich (lmo-adminedit.php): die Sonderfaelle der Eingabe,
 * die AdminWriteTest nicht speichert. Festgehalten wird je Schritt nur, was sich in den Dateien
 * aendert (die Seite selbst pruefen AdminWriteTest, AdminRoundtripTest und KoLeagueTest).
 */
final class AdminErgebnisseTest extends TestCase
{
    use AssertsSnapshots;

    private const POKAL = <<<'L98'
[Options]
Title=Liga Manager Online 4
Name=Ergebnispokal
Type=1
Teams=4
KlFin=1

[Teams]
1=Alpha
2=Beta
3=Gamma
4=Delta

[Round1]
D1=
D2=
MO=2
TA1=1
TB1=2
GA11=3
GB11=1
GA12=-1
GB12=-1
TA2=3
TB2=4
GA21=-1
GB21=-1

[Round2]
D1=
D2=
MO=1

L98;

    /** @param array<string, string> $felder */
    private static function speichere(AdminClient $c, Transcript $t, string $titel, string $datei, int $spieltag, string $feld, array $felder): void
    {
        $antwort = $c->submitForm('lmoadmin.php', 'action=admin&todo=edit&file=' . $datei . '&st=' . $spieltag, $feld, $felder);
        // nur die gesendeten Felder, nicht die ganze Seite
        $gesendet = strstr($antwort, "\n### ANTWORT", true);
        $t->add($titel, $gesendet !== false ? $gesendet : substr($antwort, 0, 400), $c->changes());
    }

    public function testEingabenEinerLiga(): void
    {
        $c = Fixture::loggedInClient();
        $c->resetChanges();
        $t = new Transcript();

        // Liga mit Verlaengerung und Elfmeterschiessen (Spez=1), drei Partien je Spieltag
        self::speichere($c, $t, 'Tore: X, Leerzeichen, Text; Zusatz; Wertung', 'golden/special.l98', 2, 'xgoala0', [
            'xgoala0' => 'x', 'xgoalb0' => '2', 'xmspez0' => '_',
            'xgoala1' => ' 3 ', 'xgoalb1' => 'abc', 'xmspez1' => '(n.V.)',
            'xgoala2' => '2', 'xgoalb2' => '1', 'xmspez2' => '(i.E.)', 'xmsieg2' => '1',
        ]);
        self::speichere($c, $t, 'Wertung fuer Gast und gegen beide, nicht gespielt', 'golden/special.l98', 3, 'xgoala0', [
            'xgoala0' => '4', 'xgoalb0' => '0', 'xmsieg0' => '2',
            'xgoala1' => '1', 'xgoalb1' => '1', 'xmsieg1' => '3',
            'xgoala2' => '_', 'xgoalb2' => '', 'xmsieg2' => '1',
        ]);
        self::speichere($c, $t, 'Termine, Datum des Spieltags, Notiz, Bericht, Tipp', 'golden/special.l98', 4, 'xgoala0', [
            'xdatum1' => '1.3.2025', 'xdatum2' => '99.99.2025',
            'xatdat0' => '08.03.2025', 'xattim0' => '', 'xatdat1' => 'quatsch', 'xattim1' => '15:30', 'xatdat2' => '09.03.2025', 'xattim2' => '18:45',
            'xmnote0' => ' Notiz mit | Strich ', 'xmberi0' => ' http://example.org/bericht?a=1&b=2 ', 'xmtipp1' => '1',
        ]);
        self::speichere($c, $t, 'Datum des Spieltags aus den Terminen', 'golden/special.l98', 5, 'xgoala0', [
            'xdatum1' => '', 'xdatum2' => '', 'xatdat0' => '15.03.2025', 'xattim0' => '14:00', 'xatdat2' => '16.03.2025', 'xattim2' => '16:00',
        ]);
        self::speichere($c, $t, 'aktueller Spieltag und News', 'golden/special.l98', 1, 'xgoala0', [
            'xstx' => '7', 'xnticker' => '1', 'xnlines' => 'Erste Zeile\n\nZweite Zeile mit O\'Neill\n',
        ]);
        self::speichere($c, $t, 'Partien neu ansetzen', 'golden/special.l98', 6, 'xgoala0', [
            'xteama0' => '6', 'xteamb0' => '5', 'xteama1' => '0', 'xteamb1' => '0', 'xgoala1' => '', 'xgoalb1' => '',
        ]);

        // Handicap: Speichern setzt die Tabellenkorrektur ab diesem Spieltag zurueck
        self::speichere($c, $t, 'Handicap ab Spieltag 2 zurueckgesetzt', 'golden/handicap.l98', 2, 'xgoala0', []);

        // Lieblingsmannschaft in der Fieberkurve: die zweite Kurve folgt dem naechsten Gegner
        $c->post('lmoadmin.php', '', ['action' => 'admin', 'todo' => 'edit', 'file' => 'golden/basic.l98', 'st' => '-1', 'show' => '0', 'save' => '1',
            'xtitel' => 'Basis', 'xfavteam' => '3', 'xselteam' => '0', 'xstat1' => '3', 'xstat2' => '0']);
        $c->changes();
        self::speichere($c, $t, 'Fieberkurve folgt dem naechsten Gegner der Lieblingsmannschaft', 'golden/basic.l98', 2, 'xgoala0', []);

        $t->add('Seite danach: Spieltag 3 mit Wertungen', $c->get('lmoadmin.php', 'action=admin&todo=edit&file=golden/special.l98&st=3'), $c->changes());
        $t->add('oeffentliche Ergebnisse Spieltag 2', $c->get('lmo.php', 'file=golden/special.l98&action=results&st=2'), $c->changes());

        $this->assertMatchesSnapshot('admin-ergebnisse', 'liga', $t->text());
    }

    public function testEingabenImPokal(): void
    {
        $c = Fixture::loggedInClient();
        file_put_contents($c->instance()->ligenDir() . '/ergebnispokal.l98', self::POKAL);
        $c->instance()->freezeLeagueTimes();
        $c->resetChanges();
        $t = new Transcript();

        self::speichere($c, $t, 'Hin- und Rueckspiel mit Zusatz, Termin und Notiz', 'ergebnispokal.l98', 1, 'xgoala00', [
            'xgoala00' => '2', 'xgoalb00' => '2', 'xgoala01' => ' 1', 'xgoalb01' => 'x', 'xmspez01' => '(n.V.)',
            'xatdat00' => '08.03.2025', 'xattim00' => '', 'xmnote01' => ' Rueckspiel ', 'xmberi00' => 'http://example.org/hin',
            'xgoala10' => '_', 'xgoalb10' => '', 'xgoala11' => '0', 'xgoalb11' => '3', 'xmspez11' => '(i.E.)', 'xmtipp10' => '1',
        ]);
        self::speichere($c, $t, 'Finale und Spiel um Platz 3', 'ergebnispokal.l98', 2, 'xgoala00', [
            'xteama0' => '1', 'xteamb0' => '4', 'xgoala00' => '1', 'xgoalb00' => '0',
            'xteama1' => '2', 'xteamb1' => '3', 'xstx' => '2',
        ]);
        $t->add('Seite danach: Runde 1', $c->get('lmoadmin.php', 'action=admin&todo=edit&file=ergebnispokal.l98&st=1'), $c->changes());

        $this->assertMatchesSnapshot('admin-ergebnisse', 'pokal', $t->text());
    }
}
