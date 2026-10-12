<?php

namespace Lmo\Tests\GoldenMaster;

use Lmo\Tests\GoldenMaster\Support\AdminClient;
use Lmo\Tests\GoldenMaster\Support\AssertsSnapshots;
use Lmo\Tests\GoldenMaster\Support\Fixture;
use Lmo\Tests\GoldenMaster\Support\Transcript;
use PHPUnit\Framework\TestCase;

/**
 * Erinnerungsmail des Tippspiels fuer eine einzelne Liga (Adminbereich, todo=tippemail mit
 * emailart=1 und gewaehlter Liga -> lmo-tippemail.php mit lmo-tippopenfile.php bzw.
 * lmo-tippopenfileall.php): Jeder Tipper bekommt die anstehenden Spiele, die er noch nicht getippt hat.
 *
 * Die Mails landen ueber bin/sendmail.php als Dateien in der Testinstanz. "Heute" ist der 15.03.2025.
 */
final class TippErinnerungTest extends TestCase
{
    use AssertsSnapshots;

    /** Vier Mannschaften, drei Spieltage: einer vorbei, einer morgen und uebermorgen, einer in fuenf Tagen */
    private const LIGA = <<<'L98'
[Options]
Title=Liga Manager Online 4
Name=Erinnerungsliga
Type=0
Teams=4
Rounds=3
Matches=2
Actual=2

[Teams]
1=Alpha
2=Beta
3=Gamma
4=Delta

[Round1]
D1=08.03.2025
D2=09.03.2025
TA1=1
TB1=2
GA1=2
GB1=1
AT1=1741444200
TA2=3
TB2=4
GA2=0
GB2=0
AT2=1741530600

[Round2]
D1=16.03.2025
D2=17.03.2025
TA1=2
TB1=3
GA1=-1
GB1=-1
AT1=1742135400
TA2=4
TB2=1
GA2=-1
GB2=-1
AT2=1742221800

[Round3]
D1=20.03.2025
D2=
TA1=1
TB1=3
GA1=-1
GB1=-1
AT1=0
TA2=2
TB2=4
GA2=-1
GB2=-1
AT2=1742484600

L98;

    /** Vier Mannschaften: Runde 1 mit Hin- und Rueckspiel morgen und in drei Tagen, das Finale in fuenf Tagen */
    private const POKAL = <<<'L98'
[Options]
Title=Liga Manager Online 4
Name=Erinnerungspokal
Type=1
Teams=4
KlFin=1

[Teams]
1=Alpha
2=Beta
3=Gamma
4=Delta

[Round1]
D1=16.03.2025
D2=18.03.2025
MO=2
TA1=1
TB1=2
GA11=-1
GB11=-1
AT11=1742135400
GA12=-1
GB12=-1
AT12=1742324400
TA2=3
TB2=4
GA21=-1
GB21=-1
AT21=1742135400
GA22=-1
GB22=-1
AT22=1742324400

[Round2]
D1=20.03.2025
D2=
MO=1
TA1=1
TB1=3
GA11=-1
GB11=-1
AT11=1742484600
TA2=2
TB2=4
GA21=-1
GB21=-1
AT21=1742484600

L98;

    private static function client(): AdminClient
    {
        $client = Fixture::loggedInClient();
        $path = $client->instance()->path();
        // Feld 10 (Index 10) ungleich -1: der Tipper will erinnert werden
        file_put_contents($path . '/addon/tipp/lmo-tippauth.txt', "<?php exit; ?>\n"
            . "tester|geheim|5|Tina Test|tester@example.org||||1|1|1|EOL\n"
            . "zweiter|geheim|5|Zoe Zweite|zweite@example.org||||1|1|1|EOL\n"
            . "ohne|geheim|5|Otto Ohne|ohne@example.org||||1|1|1|EOL\n");
        file_put_contents($client->instance()->ligenDir() . '/erinnerliga.l98', self::LIGA);
        file_put_contents($client->instance()->ligenDir() . '/erinnerpokal.l98', self::POKAL);
        $client->instance()->freezeLeagueTimes();
        $tipps = $path . '/addon/tipp/tipps/';
        // "tester" hat schon einiges getippt, "zweiter" noch nichts, "ohne" tippt die Ligen gar nicht
        file_put_contents($tipps . 'erinnerliga_tester.tip', "[Round2]\n@0@\nGA1=1\nGB1=1\nGA2=-1\nGB2=-1\n[Round3]\n@0@\nGA1=2\nGB1=0\n");
        file_put_contents($tipps . 'erinnerliga_zweiter.tip', "[Round1]\n@0@\nGA1=1\nGB1=0\n");
        file_put_contents($tipps . 'erinnerpokal_tester.tip', "[Round1]\n@0@\nGA11=1\nGB11=0\nGA22=2\nGB22=2\n[Round2]\n@0@\nGA21=0\nGB21=1\n");
        file_put_contents($tipps . 'erinnerpokal_zweiter.tip', "[Round1]\n@0@\nGA12=-1\nGB12=-1\n");
        foreach (glob($tipps . '*.tip') ?: [] as $tippdatei) {
            touch($tippdatei, mktime(12, 0, 0, 3, 10, 2025));
        }
        $dir = $client->instance()->mailDir();
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }

        return $client;
    }

    /** Verschickt die Erinnerung und gibt die Mails zurueck: Empfaenger und Text, in fester Reihenfolge. */
    private static function erinnere(AdminClient $client, string $liga, int $spieltag, int $tage): string
    {
        $dir = $client->instance()->mailDir();
        array_map('unlink', glob($dir . '/*') ?: []);
        $client->post('lmoadmin.php', '', [
            'action' => 'admin', 'todo' => 'tippemail', 'save' => '1', 'emailart' => '1', 'liganr' => '1',
            'liga1' => [$liga], 'st1' => [(string) $spieltag], 'tage' => (string) $tage, 'start' => '1', 'ende' => '3',
            'betreff' => 'Erinnerung', 'message' => "Hallo [name] ([nick]), es fehlen:\n[spiele]\nEnde",
        ]);
        $mails = [];
        foreach (glob($dir . '/*.eml') ?: [] as $datei) {
            $mail = str_replace("\r\n", "\n", (string) file_get_contents($datei));
            [$kopf, $text] = explode("\n\n", $mail, 2);
            preg_match('/^To: (.*)$/m', $kopf, $an);
            $roh = base64_decode(trim($text), true);
            $mails[] = 'An: ' . ($an[1] ?? '?') . "\n" . ($roh !== false && $roh !== '' ? $roh : $text);
        }
        sort($mails);

        return $mails ? implode("\n-----\n", $mails) : '(keine Mail)';
    }

    public function testErinnerungFuerEineLiga(): void
    {
        $c = self::client();
        $t = new Transcript();

        $t->add('Liga, Spieltag 2, vier Tage', self::erinnere($c, 'erinnerliga.l98', 2, 4), '');
        $t->add('Liga, Spieltag 2, neun Tage', self::erinnere($c, 'erinnerliga.l98', 2, 9), '');
        $t->add('Liga, Spieltag 3, neun Tage', self::erinnere($c, 'erinnerliga.l98', 3, 9), '');
        $t->add('Liga, alle Spieltage, neun Tage', self::erinnere($c, 'erinnerliga.l98', 0, 9), '');
        $t->add('Liga, alle Spieltage, ein Tag', self::erinnere($c, 'erinnerliga.l98', 0, 1), '');
        $t->add('Pokal, Runde 1, neun Tage', self::erinnere($c, 'erinnerpokal.l98', 1, 9), '');
        $t->add('Pokal, Finale, neun Tage', self::erinnere($c, 'erinnerpokal.l98', 2, 9), '');
        $t->add('Pokal, alle Runden, neun Tage', self::erinnere($c, 'erinnerpokal.l98', 0, 9), '');

        $this->assertMatchesSnapshot('tipp', 'erinnerung', $t->text());
    }
}
