<?php

namespace Lmo\Tests\GoldenMaster;

use Lmo\Tests\GoldenMaster\Support\Normalizer;
use PHPUnit\Framework\TestCase;

/**
 * Sprachauswahl (getLangSelector) kommt in readdir()-Reihenfolge, die vom Dateisystem abhaengt.
 * Der Normalizer muss daraus eine feste Reihenfolge machen.
 */
final class NormalizerTest extends TestCase
{
    private static function link(string $lang): string
    {
        return '<a href="/lmo/lmo.php?action=table&amp;lmouserlang=' . $lang . '" title="' . $lang . '">'
            . '<img src="http://lmo.test/lmo/img/' . $lang . '.svg" height="16" style="margin-right:1mm" title="'
            . $lang . '" alt="' . $lang . '"></a>';
    }

    private static function selected(string $lang): string
    {
        return '<img src="http://lmo.test/lmo/img/' . $lang . '.selected.svg" height="16" border="0" title="'
            . $lang . '" alt="' . $lang . '">';
    }

    private static function footer(string $entries): string
    {
        return '<td class="lmoFooter" colspan="2" align="left">' . $entries
            . ' >> <a href="/lmo/lang/lmo-admintranslate.php" class="lmo-lang-edit" title="x"></a></td>';
    }

    public function testLanguageOrderDoesNotDependOnDirectoryOrder(): void
    {
        $a = Normalizer::html(self::footer(self::link('Magyar') . self::selected('English') . self::link('Bosanski')), '/tmp/x');
        $b = Normalizer::html(self::footer(self::link('Bosanski') . self::link('Magyar') . self::selected('English')), '/tmp/x');

        self::assertSame($a, $b);
        preg_match_all('~lmouserlang=(\w+)"|img/(\w+)\.selected\.svg~', $a, $m);
        $order = array_map(static fn (string $x, string $y): string => $x . $y, $m[1], $m[2]);
        self::assertSame(['Bosanski', 'English', 'Magyar'], $order);
        // Bearbeiten-Link bleibt hinter der Sprachauswahl (kanonisch haengt sein ">>" am letzten Eintrag)
        self::assertMatchesRegularExpression('~Magyar">\n</a>>>\n<a href="[^"]*lmo-admintranslate~', $a);
    }

    public function testSortingIsIdempotentOnCanonicalForm(): void
    {
        $once = Normalizer::html(self::footer(self::link('Romanian') . self::link('Deutsch') . self::selected('English')), '/tmp/x');

        self::assertSame($once, Normalizer::sortLangSelector($once));
    }

    public function testOtherContentIsUntouched(): void
    {
        $html = "<p>\n<a href=\"/x?a=1\" title=\"Zeta\">\n<img src=\"z.svg\">\n</a>\n<a href=\"/x?a=2\" title=\"Alpha\">\n<img src=\"a.svg\">\n</a>\n</p>\n";

        self::assertSame($html, Normalizer::sortLangSelector($html));
    }

    public function testHarnessPathInNoticeDoesNotDependOnCheckout(): void
    {
        $notice = static fn (string $root): string => '<!-- STDERR Notice: session_start(): Ignoring session_start() because a session is already active (started from '
            . $root . '/tests/GoldenMaster/bin/http.php on line 50) in /tmp/x/lmo-admindownload.php on line 21 -->';

        $docker = Normalizer::html($notice('/app'), '/tmp/x');

        self::assertSame($docker, Normalizer::html($notice('/home/runner/work/lmo_php8/lmo_php8'), '/tmp/x'));
        self::assertStringContainsString('(started from {HARNESS}/http.php on line N)', $docker);
        // die Fehlerstelle in der LMO-Datei bleibt erhalten
        self::assertStringContainsString('{LMO_PATH}/lmo-admindownload.php on line 21', $docker);
    }

    public function testVersionDoesNotDependOnTheCheckout(): void
    {
        $info = static fn (string $version): string => '<h1>Liga Manager Online 4 - Vers. ' . $version . '</h1>';

        $tagged = Normalizer::html($info('4.2.1'), '/tmp/x');

        self::assertSame($tagged, Normalizer::html($info('dev'), '/tmp/x'));
        self::assertStringContainsString('Vers. {LMO_VERSION}</h1>', $tagged);
    }

    public function testIncludePathDoesNotDependOnEnvironment(): void
    {
        $error = static fn (string $path): string => "<p>Failed opening required 'x.php' (include_path='" . $path . "') in /tmp/x/a.php</p>";

        $docker = Normalizer::html($error('.:/usr/local/lib/php'), '/tmp/x');

        self::assertSame($docker, Normalizer::html($error('/app/lmo/vendor/pear/pear:.:/usr/share/php'), '/tmp/x'));
        self::assertStringContainsString("(include_path='{INCLUDE_PATH}')", $docker);
    }
}
