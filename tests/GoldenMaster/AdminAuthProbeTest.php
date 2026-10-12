<?php

namespace Lmo\Tests\GoldenMaster;

use Lmo\Tests\GoldenMaster\Support\AssertsSnapshots;
use Lmo\Tests\GoldenMaster\Support\Fixture;
use Lmo\Tests\GoldenMaster\Support\Transcript;
use PHPUnit\Framework\TestCase;

/**
 * Sicherheitsprobe: wie verhaelt sich der Admin-Bereich ohne Anmeldung?
 *
 * Hintergrund: init.php uebernimmt $_GET, $_POST und $_COOKIE per extract() in den globalen
 * Scope (Nachbau von register_globals). extract() schuetzt nur $this und $GLOBALS, nicht $_SESSION.
 * Ob Sitzungswerte dadurch ueberschreibbar sind, wird hier an einer lokalen Testinstanz geprueft.
 *
 * Der Snapshot haelt den IST-Zustand fest. Wird die Luecke geschlossen, muss er bewusst neu
 * aufgezeichnet werden (und sollte danach eine Anmeldeseite statt Admin-Inhalt zeigen).
 */
final class AdminAuthProbeTest extends TestCase
{
    use AssertsSnapshots;

    public function testAdminAreaWithoutLogin(): void
    {
        $c = Fixture::anonymousClient();
        $t = new Transcript();
        $a = 'action=admin';

        $t->add('ohne Anmeldung: Optionen', $c->get('lmoadmin.php', $a . '&todo=options'), $c->changes());
        $t->add('ohne Anmeldung: Parameter lmouserok', $c->get('lmoadmin.php', $a . '&todo=options&lmouserok=2'), $c->changes());
        $t->add('ohne Anmeldung: Sitzungswert im Parameter', $c->get('lmoadmin.php', $a . '&todo=options&_SESSION[lmouserok]=2'), $c->changes());
        $t->add('falsches Kennwort plus Parameter', $c->post('lmoadmin.php', '', [
            'action' => 'admin', 'xusername' => 'admin', 'xuserpass' => 'falsch', 'lmouserok' => '2',
        ]), $c->changes());
        $t->add('Download ohne Anmeldung', $c->get('lmo-admindownload.php', $a . '&todo=download&down=1'), $c->changes());
        $t->add('Download mit Sitzungswert im Parameter', $c->get('lmo-admindownload.php', $a . '&todo=download&down=1&_SESSION[lmouserok]=2'), $c->changes());

        $this->assertMatchesSnapshot('security-probe', 'admin_without_login', $t->text());
    }

    public function testDirectAccessToIncludeFiles(): void
    {
        $c = Fixture::anonymousClient();
        $t = new Transcript();

        foreach ([
            'lmo-adminmain.php' => 'action=admin',
            'lmo-adminedit.php' => 'action=admin&todo=edit&file=golden/basic.l98&st=1',
            'lmo-saveliga.php' => 'file=golden/basic.l98',
            'lmo-adminmimesend.php' => '',
            'lmo-adminjavascript.php' => '',
            'lmo-admincal.php' => '',
            'lmo-adminrounds.php' => 'file=golden/basic.l98',
            'lmo-adminsubnavi.php' => 'file=golden/basic.l98',
            'lmo-savehtml.php' => 'file=golden/basic.l98',
            'lmo-kocal.php' => '',
            'lmo-rueckrunde.php' => 'file=golden/basic.l98',
            'lmo-dirlist.php' => '',
            'lmo-openfile.php' => 'file=golden/basic.l98',
        ] as $script => $query) {
            $t->add('direkter Aufruf ' . $script, $c->get($script, $query), $c->changes());
        }

        $this->assertMatchesSnapshot('security-probe', 'direct_include_access', $t->text());
    }
}
