# Golden-Master-Tests (PHPUnit + Docker)

Ziel: Das Verhalten des **unveränderten** Codes festhalten, bevor refaktoriert wird, und nach jedem
Schritt prüfen, dass sich nichts geändert hat. Die Tests brauchen keinen Webserver und keinen
Installer: Jede Anfrage läuft in einem eigenen PHP-Prozess gegen eine frische Kopie der App.

**Stand:** Das Gerüst läuft in Docker. Die Snapshots sind am unveränderten Original aufgezeichnet,
die Erweiterungen (v1 bis v16) sind unten in der Reihenfolge ihrer Entstehung beschrieben.

## Was geprüft wird
| Test | Prüft |
|---|---|
| `PagesTest` | HTML der öffentlichen Seiten: Ligenübersicht, Tabelle (alle Typen, Teil-Spieltage, Heim/Auswärts, Punktespalten), Ergebnisse, Spielplan, Kreuztabelle, Statistik, Fieberkurve, Kalender, Info, Sprachen |
| `CalculationTest` | `lmo-calctable.php` (inkl. direktem Vergleich): Sortierschlüssel und alle Bilanzspalten je Liga, 5 Tabellentypen, mehrere Spieltage, Hin-/Rückrunden-Kombinationen, Admin-Ansicht |
| `FirstRunTest` | **Neues Verhalten, kein Golden Master:** Ersteinrichtung ohne Installer (`lmo-setup.php`): Konfiguration wird aus `config-default/` angelegt, vorhandene bleibt, neue Optionen nach einem Update werden ergänzt (nur wenn sich `config-default/` geändert hat), `init-parameters.php` hat Vorrang, Fehlermeldungen, Admin-Konto per Formular (Hash, Validierung, kein zweites Setup, Sitzung endet ohne Konto), Installer und FTP-Code sind entfernt |
| `UrlDetectionTest` | **Neues Verhalten, kein Golden Master:** `lmo_detect_url()` – Unterordner, Addon-Skripte, Alias, Einbindung von außen, HTTPS/Proxy, Port, Kommandozeile |

Die 9 mitgelieferten Ligen haben **keine einzige gespielte Partie**. Deshalb erzeugt
`LeagueFactory` 8 Testligen mit festem Seed: normale Liga, Minuspunkte + direkter Vergleich,
Kegelwertung, Strafpunkte/-tore ab Spieltag, Sonderwertung (n.V./i.E.), Handicap-Reihenfolge,
Wertung am grünen Tisch, Platzmarkierungen (Meister, Champions League, Abstieg).

## Ablauf

```bash
# 1. Unveränderten Originalstand bereitstellen (ZIP von GitHub, NICHT den refaktorierten Stand)
unzip lmo_php8-master.zip -d .original          # ergibt .original/lmo_php8-master/lmo/...

# 2. Snapshots am Original aufzeichnen (einmalig, danach ins Git einchecken)
#    Spaeter hinzugekommene Faelle: GOLDEN_MODE=record-missing legt nur FEHLENDE Snapshots an und
#    vergleicht vorhandene (sicherer als "record", das alles ueberschreibt).
ORIGINAL_DIR=./.original/lmo_php8-master LMO_SOURCE=/original GOLDEN_MODE=record \
  docker compose run --rm tests

# 3. Gegen den aktuellen Arbeitsstand prüfen (nach jedem Refactoring-Schritt)
docker compose run --rm tests

# Nur eine Gruppe oder ein Fall:
docker compose run --rm tests --filter CalculationTest
docker compose run --rm tests --filter 'PagesTest.*action=table'

# Andere PHP-Version (README nennt 8.0 bis 8.5)
PHP_VERSION=8.0 docker compose run --rm tests
```

Ohne Docker: `composer install && php vendor/bin/phpunit` (PHP ≥ 8.0, optional `faketime`).

**Wichtig:** Snapshots nur am unveränderten Original aufzeichnen und nur dann neu aufzeichnen, wenn
eine Abweichung geprüft und gewollt ist. Eine Abweichung ist zunächst ein Befund, kein Grund
zum Aktualisieren.

## Statische Analyse mit PHPStan

```bash
docker compose run --rm phpstan      # im Docker
composer phpstan                     # ohne Docker
```

Es laufen fuenf Pruefungen nacheinander:

| Konfiguration | Stufe | Umfang |
|---|---|---|
| `phpstan.neon.dist` | 0 | gesamter Code (`lmo/`, `src/`, `bin/`, `tests/`): unbekannte Klassen, Funktionen und Methoden |
| `phpstan-classlib.neon.dist` | 5 | Klassen und Funktionen der Classlib (`lmo/addon/classlib`): zusaetzlich nicht gesetzte Variablen, Typangaben in den Kommentaren, Rueckgabetypen und Parametertypen bei Aufrufen |
| `phpstan-liga.neon.dist` | 6 | alte Dateien, die die Liga nur noch ueber `Lmo\Liga\LigaDaten` lesen (Kreuztabelle, Tabelle, Ergebnisse, Spielplan) |
| `phpstan-tests.neon.dist` | 5 | Tests ohne die Hilfsskripte in `tests/GoldenMaster/bin`: falsche Parametertypen, unmoegliche Vergleiche |
| `phpstan-strict.neon.dist` | 8 | neuer, typisierter Code (`src/`, `bin/lmo-install`, `lmo/lmo-version.php`) |

Ab Stufe 1 meldet PHPStan die globalen Variablen des alten Codes, die eine Datei setzt und eine
andere per `require` benutzt (rund 9500 Stellen). Deshalb bleibt der alte Code auf Stufe 0. Die
Classlib besteht aus Klassen und steht deshalb auf Stufe 5; ab Stufe 6 verlangt PHPStan Typen an
jedem Parameter und Rueckgabewert. Wird
eine Datei typisiert und von globalen Variablen befreit, kommt sie in `phpstan-strict.neon.dist`.

Auf Stufe 0 ist der gesamte Code ohne Meldung; eine Baseline gibt es deshalb nicht. Die einzige
Ausnahme steht mit Begruendung in `phpstan.neon.dist` (`ignoreErrors`).

Geprueft wird fuer PHP 8.0 bis 8.5 (`phpVersion` in der Konfiguration), unabhaengig davon, mit
welcher PHP-Version PHPStan selbst laeuft.

## So werden Abweichungen angezeigt
- HTML wird normalisiert (Session-IDs, Temp-Pfade, Zufallsfarben der Fieberkurve entfernt,
  Whitespace zusammengefasst, ein Tag pro Zeile). Dadurch stören Einrückungsänderungen durch
  Twig nicht, Strukturänderungen aber schon.
- Numerische Strings und Zahlen gelten in `CalculationTest` als gleich (`"0"` = `0`), weil das
  Original `array_pad(..., "0")` benutzt.
- PHP-Warnungen und -Notices erscheinen als `<!-- STDERR ... -->` im Snapshot. Neue Warnungen
  nach einem Refactoring führen also ebenfalls zu einer Abweichung.

## Bekannte Grenzen
- **Nicht abgedeckt:** Admin-Bereich (Speichern in `.l98`), KO-Ligen (`Type` ungleich 0), Tippspiel,
  Spielerstatistik, `savehtml`, Mailversand, erzeugte Grafiken (`lmo-gif`). Der Schreibpfad ist der
  nächste Baustein: Admin-Aktionen mit Sitzung nachspielen und die geschriebene Datei vergleichen.
- **Zeit:** `faketime` setzt die Uhr auf 2025-03-15 12:00 (läuft danach weiter). Ohne `faketime`
  hängen die Kalenderseiten vom Tagesdatum ab. Die Berechnungszeit ist in der Testinstanz abgeschaltet.
- **GET überschreibt Konfiguration:** `init.php` extrahiert `$_GET` nach dem Laden von `cfg.txt`
  in den globalen Scope. Die Tests nutzen das für `tabonres=2` und `tabpkt=0`. Es ist zugleich
  ein Sicherheitsproblem des Originals (jede Konfigurationsvariable lässt sich per URL setzen).
- Die Kalenderseite (`action=cal`) hängt von Optionen der Liga ab und kann leer sein; das ist dann
  Teil des Golden Masters.

## Coverage-Messung: welcher Code wird vom Golden Master nie ausgeführt?

Misst mit Xdebug (nur in den Kindprozessen aktiv), welche Zeilen von `lmo/` während aller Tests laufen (jeder Kindprozess schreibt
seine Abdeckung, am Ende wird zusammengeführt). Damit wird "deckt der Golden Master alles ab" zu
einer Zahl je Datei.

```powershell
docker compose build tests          # einmalig, installiert Xdebug im Image
$env:GOLDEN_COVERAGE = "1"
docker compose run --rm tests
Remove-Item Env:GOLDEN_COVERAGE
```

Ergebnis auf der Konsole (Zusammenfassung je Bereich + Kerndateien, schlechteste zuerst) und in
`coverage/`: `report.txt` (alle Dateien), `report.csv` (für Excel, Trennzeichen `;`) und
`uncovered.txt` (nicht ausgeführte Zeilenbereiche je Datei).

Bedeutung: "ausgeführt" heißt, die Zeile lief mindestens einmal. Es heißt nicht, dass eine
Änderung dort auffallen würde. Ein Fehler in einer Zeile, deren Ergebnis nirgends in der Ausgabe
landet, bleibt unbemerkt. Die Zahl ist eine Untergrenze für Lücken, kein Beweis für Sicherheit.
Bei nie geladenen Dateien ist die Zeilenzahl geschätzt (`~`).

### Bekanntes Problem: pcov stuerzt ab
Mit pcov endeten die Kindprozesse mit Exit-Code 139 (Segmentation fault), Coverage-Daten wurden nie
geschrieben. Deshalb nutzt die Messung Xdebug. Die Coverage-Messung laeuft ohne `faketime`;
zeitabhaengige Seiten (Kalender) koennen im Coverage-Lauf vom Snapshot abweichen. Das ist hier
unerheblich, der Report wird trotzdem erzeugt. Mit `GOLDEN_NO_FAKETIME=1` laesst sich `faketime`
auch ausserhalb der Messung abschalten.

Achtung PowerShell: `$env:GOLDEN_COVERAGE` bleibt in der Sitzung gesetzt, bis es mit
`Remove-Item Env:GOLDEN_COVERAGE` entfernt wird. Die erste Ausgabezeile des Laufs zeigt
`Coverage: 1` oder `Coverage: 0`.

Tipp: `docker compose run --rm tests --stop-on-failure` bricht nach dem ersten Fehler ab und
vermeidet seitenlange Ausgaben.

### Hermetische Tests: kein Netzwerkzugriff
Nur der Admin-Bereich fragt nach einer neueren Version (`lmo-adminmain.php`, `lmo_update_info()` in
`lmo-version.php`): bei Packagist, hoechstens einmal am Tag, und nur wenn eine getaggte Version
installiert ist. Im Checkout ist die Version `dev`, es wird also nie gefragt. Die Testprozesse
laufen zusaetzlich mit `allow_url_fopen=0`.

Die Versionsnummer selbst kommt aus dem Git-Tag (Composer) und steht in keiner Datei. Auf der
Info-Seite ersetzt der Normalizer sie durch `{LMO_VERSION}`; ein neuer Tag aendert keine Snapshots.

### Snapshot-Modi
| `GOLDEN_MODE` | Verhalten |
|---|---|
| (leer) | Vergleichen. Fehlender Snapshot = Fehler |
| `record-missing` | Fehlende Snapshots anlegen, vorhandene vergleichen. Standard fuer neue Testfaelle |
| `record` | **Alle** Snapshots neu schreiben. Nur am unveraenderten Original und nur bewusst |

Neue Szenarien (`direct_kegel`, `direct_special`, `direct_wertung`, `direct_handicap`) pruefen den
direkten Vergleich mit Kegelwertung, Sonderpunkten, Wertung am gruenen Tisch und Handicap; sie
testen nur Tabellenseiten und die Berechnung (`pages => table`).

### Szenarien nach Coverage-Auswertung (v7)
Lücken des ersten Coverage-Laufs und was sie schließt:
| Lücke (Original) | Ursache | Szenario |
|---|---|---|
| `lmo-calctable1.php` 68-76 | Sonderpunkte im direkten Vergleich | `direct_special` |
| `lmo-calctable1.php` 84-93, 121-130 | Wertung am grünen Tisch im direkten Vergleich | `direct_wertung` |
| `lmo-calctable1.php` 163 | Kegelwertung im direkten Vergleich | `direct_kegel` |
| `lmo-showtable.php` 144-145, 188, 229-230 | Favorit, Vereins-URL, Teamnotiz | `viewopts` |
| `lmo-showstats.php` 59-296 | Statistik-Vergleich braucht `stat1`/`stat2` | Seiten `action=stats&stat1=...` |
| `lmo-calctable.php` 100-102, 117-119, 185-187, 202-204 | nach Analyse nicht erreichbar (siehe unten) | keines |
| `lmo-calctable*.php` 23, 26 | Standardwerte, wenn `$tabtype`/`$newtabtype` fehlen | keines |

Die vier Blöcke in `lmo-calctable.php` aktualisieren den "höchsten Sieg" bzw. die "höchste
Niederlage" aus einem Ergebnis, das per Wertung entschieden wurde. Beim Einlesen setzt `lmo-openfile.php`
dafür ein Tor auf `0`. Dann kann die Tordifferenz den Startwert 0 nie übertreffen, die Bedingung
ist nie wahr. Das ist eine Herleitung aus dem Code, kein Beweis durch Test.

### v8: letzte kleine Lücken
| Lücke | Szenario/Seite |
|---|---|
| `lmo-calctable1.php` 127-130 (Gastteam verliert durch Heim-Wertung im direkten Vergleich) | `direct_wertung_many` (viele Wertungsspiele) |
| `lmo-showstats.php` 26-27 (`stat2` ohne `stat1`) | Seite `action=stats&stat1=0&stat2=2` |

Nicht abgedeckt bleiben bewusst: die vier Wertungsblöcke in `lmo-calctable.php` (nicht erreichbar, s. o.)
und die Standardwerte in Zeile 23/26 (`$tabtype` ist im Webablauf immer gesetzt).

## Admin-Bereich (v9)

Neu: `bin/http.php` fuehrt beliebige GET/POST-Anfragen gegen jeden Einstiegspunkt aus, auf Wunsch
innerhalb einer Sitzung (`AdminClient` merkt sich die Sitzungs-ID zwischen den Schritten).
`StateTracker` meldet nach jedem Schritt, welche Dateien neu, geaendert oder geloescht sind (als
Unified Diff). Kennwort-Hashes (Zufalls-Salt) und die Laufzeit in der Fusszeile werden normalisiert.

| Test | Prueft |
|---|---|
| `AdminViewsTest` | ca. 60 lesende Admin-Ansichten als Hauptadmin (Startseite, Neu, Oeffnen, Loeschen, Upload, Download, Optionen, Addons, Design, Benutzer, Update, Tippspiel-Seiten, Viewer; je Liga Bearbeiten/Grunddaten/Mannschaften/Anzahl/Spieltage/Tabellenkorrektur). Der Snapshot enthaelt auch Dateien, die der Seitenaufruf veraendert hat (normalerweise keine) |
| `AdminLoginTest` | Anmeldung (falsch/richtig), Abmelden, Kennwort-Upgrade auf Hash, Hilfsadmin und erweiterter Hilfsadmin (erlaubte und gesperrte Seiten) |
| `StyleTest` | `lmo-style.php`, `lmo-style-nc.php` |

Pruefen, ob das Admin-Geruest funktioniert (nach dem ersten `record-missing`-Lauf):
```powershell
# darf keinen Treffer liefern: sonst wurde die Sitzung nicht uebernommen und alle Seiten zeigen das Anmeldeformular
Select-String -Path tests\GoldenMaster\__snapshots__\admin-views\*.txt -Pattern 'name="xusername"' -List | Measure-Object
# Anmeldeablauf ansehen
Get-Content tests\GoldenMaster\__snapshots__\admin-flows\login_logout-*.txt | Select-String "^===|GEAENDERT|NEU |HASH"
```

Noch **nicht** enthalten: schreibende Admin-Aktionen (Ergebnisse speichern, Mannschaften, Grunddaten,
Optionen, Benutzer, neue Liga, Loeschen, Upload). Die kommen als naechster Baustein.

## Schreibende Admin-Aktionen (v10)

`FormSubmitter` liest ein Formular wie ein Browser aus (Standardwerte, Auswahl, Haken) und `AdminClient`
schickt es mit gezielten Abweichungen ab. `Fixture::loggedInClient()` liefert je Test eine frische, angemeldete
Instanz; jedes Szenario ist von den anderen unabhaengig.

| Test | Prueft |
|---|---|
| `AdminWriteTest` | Ergebnisse/Termine/Notizen speichern, Grunddaten, Mannschaften inkl. Straf- und Torkorrektur, Anzahl Spieltage, Tabellenkorrektur, Optionen, Design, Benutzer anlegen/bearbeiten/loeschen, Liga loeschen, Liga neu anlegen (4 Schritte) |
| `AdminRoundtripTest` | jedes Formular unveraendert abschicken (Optionen, Addons, Design, Benutzer, Viewer, Tippspiel, je Liga Ergebnisse/Grunddaten/Mannschaften/Anzahl/Spieltage/Tabellenkorrektur) |
| `AdminAuthProbeTest` | Sicherheitsprobe: Admin-Bereich und direkt aufrufbare Include-Dateien ohne Anmeldung |

Protokollformat eines Schritts: `=== Titel ===`, gesendete Felder, Antwort, `--- Dateiaenderungen ---` (Diff).
Steht dort `KEIN FORMULAR GEFUNDEN` oder `LEERES FORMULAR`, hat der Test das Formular nicht gefunden
(falsche Annahme, nicht Verhalten der Anwendung).

Fixture-Aenderung gegenueber v9: `Instance` legt jetzt auch an, was der Installer anlegen laesst
(`addon/tipp/lmo-tippauth.txt`, Tipp- und Spieler-Verzeichnisse). Ohne diese Datei bricht
`todo=tippuser` mit einem Fatal Error ab. Dadurch aendern sich einige Snapshots unter
`admin-views` (`*todo=tipp*`); sie muessen neu aufgezeichnet werden.

Nicht abgedeckt: Datei-Upload (`todo=upload`), Download als Datei (`lmo-admindownload.php` mit gueltiger Sitzung),
Zufallsspielplan (`xprogram=random`, nicht reproduzierbar), JavaScript im Browser.

### Normalisierung von Stack-Traces (v11)
PHP-Fehlermeldungen im Snapshot enthalten einen Stack-Trace mit den Hilfsskripten der Tests
(`.../bin/http.php(57)`). Wird ein Hilfsskript geaendert, verschiebt sich die Zeilennummer und der
Snapshot wird rot, obwohl sich die Anwendung nicht geaendert hat. Der Normalizer ersetzt diese
Angaben durch `{HARNESS}/http.php(N)`. Snapshots, die einen Stack-Trace enthalten, einmal neu aufzeichnen
(betrifft bisher `todo=pdfoptions` und `todo=tippuser`).

### Uhrzeit nach dem Speichern (v12)
`faketime` setzt nur die Uhr, nicht die Dateizeit: Eine vom Admin gespeicherte Ligadatei hat die echte Zeit.
Die oeffentlichen Seiten zeigen sie als "Letztes Update der Liga". In Admin-Protokollen ersetzt der Normalizer
diese Angabe durch `{STAND}`. Betroffene Snapshots (`admin-write`: results, basic_data, teams,
table_correction, create_league) muessen einmal neu aufgezeichnet werden.
Tipp: Nach dem Aufzeichnen zwei Vergleichslaeufe mit mindestens einer Minute Abstand starten,
sonst bleiben Zeitabhaengigkeiten unbemerkt.

### Coverage-Report: Admin getrennt ausgewiesen (v13)
Der Bereichsbericht zeigt jetzt "Kern: oeffentlich" und "Kern: Admin" getrennt (vorher ein
gemeinsames "Kern (lmo/*.php)"), damit sichtbar ist, wie weit der Admin-Bereich abgedeckt ist,
ohne ihn mit den oeffentlichen Seiten zu vermischen. report.csv/uncovered.txt unveraendert.

## Verbleibende Kern-Luecken geschlossen (v14)

Nach der getrennten Admin-/oeffentlich-Auswertung (v13) wurden die uebrig gebliebenen 0%-Dateien
im Kern einzeln geprueft:

| Datei | Befund | Massnahme |
|---|---|---|
| `index.php` | reiner Redirect auf `lmo.php` | `CoreGapsTest::testIndexRedirectsToLmoPhp` |
| `lmo-adminopenprogram.php` | Spielplan "aus Datei uebernehmen"; `$xprogram` wird ungeprueft an `fopen()` uebergeben (nur Suffix `.l98` verlangt) - eigener, kleiner Befund zum Pfad-Handling, siehe Klassenkommentar in `CoreGapsTest.php` | `CoreGapsTest::testCreateLeagueFromTemplate` |
| `lmo-adminrndprogram.php` | erzeugt einen echten Zufallsspielplan (nicht deterministisch) | `RandomScheduleSmokeTest`: kein Golden-Master-Vergleich, sondern Plausibilitaetspruefung (jedes Team pro Spieltag genau einmal) + Pruefung auf PHP-Fehler |
| `lmo-admindir.php` | **toter Code** - keine einzige Referenz im gesamten Repository (auch nicht in Addons) | bewusst nicht getestet, bleibt bei 0% |
| `lmo-paintgraph.php` | war toter Code ohne Referenz und ist in 4.2.1 entfernt (die Fieberkurve zeichnet der Browser mit Chart.js; das Tippspiel-Addon hat eine eigene Datei `lmo-tipppaintgraph.php`) | entfaellt |
| `lmo-adminuserpass.php`, `lmo-openfiledat.php` | nur vom Tippspiel-Addon genutzt (Zufallspasswort bei neuem Tipper bzw. E-Mail-Versand mit Spieltagsbezug) | zurueckgestellt, gehoert zum separaten Block "Tippspiel-Addon" (aktuell 4% Abdeckung, 64 Dateien) |

KO-Ligen (`Type=1`: `lmo-showkoprogram.php`, `lmo-showkoresults.php`, Teile von `lmo-adminnew.php`)
sind bewusst **nicht** Teil dieser Runde: Das ist ein eigener, groesserer Baustein (eigene
Fixture-Struktur mit Turniermodus/Spieltagsmodi, eigene Admin-Formularfelder), vergleichbar im
Umfang mit dem Tippspiel-Addon. Die einzige reale Liga im Repo (`1l_2024-25.l98`) ist `Type=0`.

## Dritter Befund: Spielplan-Bug in lmo-adminrndprogram.php (v15)

`RandomScheduleSmokeTest` deckte beim ersten echten Lauf einen eigenstaendigen Fehler im
unveraenderten Original auf (unabhaengig von extract() und dem xprogram-Pfadproblem):

**Fisher-Yates-Shuffle mit Off-by-One** (~Zeile 160): `$j = @mt_rand(0, $i+1);` statt
`mt_rand(0, $i)`. Beim ersten Schleifendurchlauf (`$i` = Teamzahl-1) liegt die Obergrenze um 1 zu
hoch; mit Wahrscheinlichkeit 1/(Teamzahl+1) wird ein Index ausserhalb des Arrays gezogen. Das
erzeugt nicht nur eine "Undefined array key"-Warnung, sondern laesst eine Teamposition auf `NULL`
stehen - der erzeugte Zufallsspielplan verliert ein Team. Bei 6 Teams: ca. 14% der Aufrufe.

**Behoben in 4.2.1:** `mt_rand(0, $i+1)` ist durch `mt_rand(0, $i)` ersetzt. Der Test toleriert die
Warnung nicht mehr. Weil der Fehler nur manchmal auftrat, erzeugt er 30 Zufallsspielplaene und prueft
bei jedem, dass an jedem Spieltag alle Mannschaften genau einmal spielen und keine PHP-Meldung
erscheint.

## KO-Ligen / Pokalmodus (v16)

Eigenes Datenformat (`Type=1`): Ergebnisfelder sind "Spiel+Durchgang"-kodiert (z. B. `GA00` =
Spiel 1, 1. Durchgang), Team-Zuordnung je Runde erfolgt manuell durch den Admin (kein
automatisches Nachruecken der Sieger). Modus je Runde: 1=Einzelspiel, 2=Hin-/Rueckspiel,
3/5/7=Best-of-3/5/7 (steuert, wie viele "Durchgaenge" pro Spiel moeglich sind).

`KoLeagueTest` erzeugt die Liga ueber den echten Admin-Assistenten (`todo=new&xtype=1`) statt als
Fixture-Datei nachzubauen - das Dateiformat ist komplex genug, dass der "richtige" Weg ueber die
Anwendung selbst zuverlaessiger ist. Abgedeckt: 4er-Turnierbaum (Halbfinale + Finale),
Einzelspiel-Modus (Standard), oeffentliche Seiten (`action=program&selteam=N`,
`action=results&st=N`, `action=cal`), Admin-Bearbeitung und ein Roundtrip (unveraendert speichern).

NICHT abgedeckt (eigener, groesserer Block): Hin-/Rueckspiel und Best-of-3/5/7 (Modus 2/3/5/7),
Playoffmode-Varianten (2-2-1 usw., siehe `$playoffmode` in `lmo-adminedit.php`/
`lmo-showkoresults.php`), Spielerstatistik-Addon fuer KO, Tippspiel-Addon fuer KO
(`lmo-tippeditko.php` und Verwandte), groessere Turnierbaeume (8/16/24/32+ Teams).
