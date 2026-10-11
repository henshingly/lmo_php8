# Liga Manager Online (classic design) Change Log (german)
__Alle wesentlichen Änderungen am PHP Script des LMO werden in dieser Datei dokumentiert.__  

## [Unveröffentlicht] - YYYY-MM-DD

_Hier schreiben wir Changelog Hinweise der nächsten Version._  

### Added  
- `Lmo\Liga\Rohdaten\Liga` (mit `Mannschaft`, `Spieltag`, `Partie`): hält den Inhalt einer Ligadatei so, wie er in der Datei steht, und lädt und speichert ihn als Paar. Nichts wird für die Anzeige umgerechnet, ergänzt oder aufgefüllt; unbekannte Schlüssel und Abschnitte bleiben erhalten. Der Kern des LMO lädt und speichert jede Liga darüber.
- `Lmo\Liga\Einstellungen`: die Einstellungen einer Liga (`[Options]`) mit ihren Vorgabewerten und den berechneten Größen (Spieltage, Partien), ohne die Rohdaten zu ändern – `Rohdaten\Liga::lies($pfad)->einstellungen()->wert('Teams')`. Dazu an den Rohdaten `Mannschaft::anzeigename()`, `Liga::mannschaftsname()` sowie `Spieltag::ersterTag()` und `letzterTag()`. Damit können Seiten direkt auf den Rohdaten arbeiten; die beiden Tippspiel-Lader tun das bereits.


### Changed  
- Die Classlib liest und schreibt Ligadateien über dieselbe Klasse wie der Kern (`Lmo\Liga\Rohdaten\Liga`). Von der Classlib geschriebene Dateien haben dadurch die Abschnittsfolge des Kerns und enthalten immer `[News]`, `[Teamm]` und `[Teamk]`; die Werte sind dieselben. Ob eine Datei Liga oder Pokal ist, entscheidet jetzt auch in der Classlib der Typ der Datei, nicht mehr der Modus der einzelnen Runde.
- Die Ligalisten (Ligaübersicht, Admin: Öffnen, Löschen, Download, neue Liga, Viewer-Optionen; Tippspiel) lesen Name, Typ und Größe einer Liga über `Lmo\Liga\LigaDatei::liesAbschnitt()` statt über neun eigene Leseschleifen. Leerzeichen um Schlüssel und Wert werden dabei wie beim Laden der Liga entfernt; eine nicht lesbare Datei bricht die Liste nicht mehr ab.
- Die Spielplanvorlage beim Anlegen einer Liga (»aus Datei übernehmen«) sowie die Tippübersicht und die Erinnerungsmail des Tippspiels lesen Ligadateien über `Lmo\Liga\Rohdaten\Liga` bzw. `Lmo\Liga\LigaDatei` statt über eigene Leseschleifen. Damit liest außer der Classlib und dem Kern niemand mehr eine Ligadatei selbst.
- Eine Ligadatei wird immer komplett gelesen. Die beiden kleinen Lader des Tippspiels (`lmo-openfilename.php`, `lmo-openfiledat.php`) und der Schalter `$lmo_only_st` lasen bisher nur einzelne Schlüssel bzw. einen Spieltag und hinterließen eine halb gefüllte Liga; jetzt liefern alle Lader dasselbe. Nur die Ligalisten lesen weiterhin allein den Abschnitt `[Options]`. Sichtbar: Eine Liga ohne Namen heißt im Tippspiel nicht mehr »No Name«, sondern hat wie überall sonst keinen Namen. In der Erinnerungsmail für einen Spieltag wird dessen Datum wie im Hauptlader geprüft: `1.9.2024` wird zu `01.09.2024` (bisher leer), ein Datum, das es nicht gibt (`31.02.2025`), wird geleert (bisher auf den 03.03. umgerechnet).
- Die beiden abgespeckten Lader `lmo-openfilename.php` und `lmo-openfiledat.php` benutzen denselben Leser und dieselbe Zuordnung der Schlüssel wie der Hauptlader.
- Die ganze Ligadatei wird über `Lmo\Liga\LigaDaten` geschrieben; `lmo-savefile.php` enthält nur noch das Öffnen, Sperren und Schreiben der Zeilen. Die geschriebene Datei ist unverändert.
- News, Spieltage und Partien liest `Lmo\Liga\LigaDaten`; der Lader `lmo-openfile.php` enthält nur noch den Ablauf. Die gelesenen Werte sind unverändert.
- Auch die Abschnitte der Mannschaften (`[Teams]`, `[Teamk]`, `[Teamm]`, `[Team1]` …) werden über `Lmo\Liga\LigaDaten` gelesen und gespeichert, einschließlich der abgeleiteten Kurz- und Mittelnamen. Gelesene Werte und geschriebene Datei sind unverändert.
- Welcher Schlüssel des Abschnitts `[Options]` zu welchem Wert der Liga gehört, für Liga oder Pokal gilt und welchen Vorgabewert hat, steht jetzt in einer Tabelle in `Lmo\Liga\LigaDaten`. Der Lader `lmo-openfile.php` und das Speichern in `lmo-savefile.php` benutzen beide diese Tabelle; die geschriebene Datei ist unverändert.
- Das Format der Ligadatei (Abschnitte, Schlüssel, Werte) liest jetzt eine gemeinsame Klasse (`Lmo\Liga\LigaDatei`), die der Lader `lmo-openfile.php` und die Classlib benutzen.
- Die Vorgabewerte einer Liga (Punkte je Sieg, Anzahl der Spieltage, Datumsformat …) stehen jetzt in `Lmo\Liga\LigaDaten` statt als rund 60 Einzelzeilen im Lader `lmo-openfile.php`. Am Verhalten ändert sich nichts.
- Die Werte einer Ligadatei liegen zusätzlich gebündelt in einem Objekt (`Lmo\Liga\LigaDaten`, Variable `$ligaDaten`). Die bisherigen einzelnen Variablen (`$titel`, `$teams`, `$goala` …) bleiben gültig und zeigen auf dieselben Werte. Der gesamte LMO liest und schreibt die Liga jetzt über das Objekt (62 Dateien); an der Ausgabe ändert sich nichts. Eigene Erweiterungen, die die alten Variablen benutzen, funktionieren unverändert.
- 62 alte Dateien nennen am Dateianfang, welche Variablen sie erwarten. PHPStan prüft damit 33 von ihnen auf Stufe 6 und 31 auf Stufe 1 statt auf Stufe 0.


### Deprecated  


### Removed  


### Fixed  
- Classlib, Pokal: Stand in der Datei ein Wert eines Spiels (z. B. die Notiz des Hinspiels) hinter den Toren des nächsten Spiels, wurde er dem falschen Spiel zugeordnet. Sieht der Modus einer Runde mehr Spiele vor, als die Datei nennt, bricht das Laden nicht mehr ab.
- Einstellungen in `[Options]`, die der LMO nicht kennt (auch `stats`), und ganze unbekannte Abschnitte einer Ligadatei gingen beim Speichern im Admin-Bereich verloren. Sie bleiben jetzt erhalten.
- Werden in einem Aufruf mehrere Ligen nacheinander geladen, blieben Werte der vorigen Liga stehen, die die nächste Datei nicht nennt (z. B. Strafpunkte einer Liga beim anschließenden Laden eines Pokals). Vor jedem Laden werden jetzt alle Werte geleert.
- Ein senkrechter Strich (`|`) in einer Notiz, einem Mannschaftsnamen, einer Adresse oder einer Newszeile schnitt beim Laden alles dahinter ab.
- Tippspiel: Derselbe Fehler in der Tippübersicht und der Erinnerungsmail – ein `|` im Mannschaftsnamen oder in der Notiz schnitt den Rest ab.
- Tippspiel, Tippübersicht und Erinnerungsmail: Die Werte eines Spiels hingen von der Reihenfolge der Zeilen in der Ligadatei ab. Fehlte einem Spiel eine Angabe (Notiz, Tore, Mannschaft), galt die des vorigen Spiels weiter; im Pokal konnten die Tore des Rückspiels beim Hinspiel landen. Jetzt hat jedes Spiel seine eigenen Werte, und was eine Liga nicht nennt, bekommt den Vorgabewert statt des Werts der zuvor gelesenen Liga.
- Tippspiel, Tippabgabe für einen Liga-Spieltag: Der Link zum Spielbericht und der Hinweis »Spiel wird für Tippspiel nicht gewertet« in der Notiz fehlten, und die Seite warf PHP-Warnungen (`Undefined variable $n`), sobald Spielberichte eingeschaltet waren.
- Ein unlesbares Datum im letzten Spieltag einer Ligadatei (z. B. `D1=ab.cd.efgh`) ließ das Laden der Liga abbrechen; es wird jetzt geleert.
- Classlib (Addons mini, viewer, ticker): Eine eckige Klammer in einem Liganamen, Mannschaftsnamen oder einer Notiz schnitt den Rest des Abschnitts ab (Name gekürzt, Mannschaft oder Zusatz „n. V.“ fehlten). Kommentarzeilen mit `;` am Anfang wurden als Schlüssel gelesen.
- Tippspiel und Benutzerverwaltung: Fehlte einer Ligadatei die Anzahl der Spieltage (`Rounds`), brach der abgespeckte Lader `lmo-openfilename.php` mit „Division by zero“ ab. Beide abgespeckten Lader ergänzen fehlende Angaben jetzt wie der Hauptlader.


### Security  


***
## [4.3.2] - 2026-10-11

_Hier hätten wir die Changelogs für 4.3.2._  

### Changed  
* PHPStan prüft die Klassen und Funktionen der Classlib und die Tests jetzt auf Stufe 5.  
* Classlib: Die Typangaben in den Kommentaren stimmen mit dem Verhalten überein (z. B. `team|null` statt `object` bei den Suchfunktionen, `$` vor den Parameternamen). Am Code selbst ändert sich dadurch nichts.  

### Fixed  
* Classlib: Ein unlesbares Spieltagsdatum in der Ligadatei (z. B. `D1=ab.cd.efgh` oder `D1=23.08.`) ließ das Laden der Liga mit einem Fehler abbrechen; es gilt jetzt als fehlend.  
* Classlib: Das Sortieren einer Tabelle ohne Zeilen (`sortTable()`, `sortDirectTable()`) brach mit einem Fehler ab; `getVerlaufTeam()` und `getVerlaufTeams()` liefern für ein Team außerhalb der Liga ein leeres Array statt einer PHP-Warnung.  


***
## [4.3.1] - 2026-10-11

_Hier hätten wir die Changelogs für 4.3.1._  

### Added  
* Statische Analyse mit PHPStan (`composer phpstan` bzw. `docker compose run --rm phpstan`, auch in der GitHub-Action): gesamter Code auf Stufe 0, neuer Code auf Stufe 8.  

### Fixed  
* Update-Prüfung: Erlaubt der Server keine Abfragen nach außen (`allow_url_fopen` aus), wird nichts mehr versucht und keine Merkdatei geschrieben; eine beschädigte Merkdatei wird ignoriert.  
* `lmo-install` findet den Autoloader auch beim direkten Aufruf im Git-Checkout (`vendor/` neben `lmo/`).  
* Kalender im Admin-Bereich: Im Mai erschien im Kopf die Abkürzung statt des ausgeschriebenen Monatsnamens.  


***
## [4.3.0] - 2026-10-11

_Hier hätten wir die Changelogs für 4.3.0._  

### Added  
* Installation per Composer: `composer require lmo/lmo_php8`, danach richtet `vendor/bin/lmo-install` den LMO im Ordner `lmo` ein. `composer update` aktualisiert ihn dort automatisch; Einstellungen, Ligen und Tipps bleiben erhalten (siehe README).  

### Changed  
* Nur noch eine `composer.json` (im Hauptordner). Lizenz und PHP-Mindestversion liest der LMO jetzt aus `lmo/version.json`; die alte `lmo/composer.json` kann nach einem Update gelöscht werden.  
* Die Versionsnummer kommt aus dem Git-Tag des Composer-Pakets und steht in keiner Datei mehr. Ohne getaggte Version (Git-Checkout) zeigt der LMO `dev`.  
* Die Suche nach einer neuen Version fragt Packagist statt der Prüfdatei auf vest-sport.de: nur noch im Admin-Bereich für den Hauptadmin und höchstens einmal am Tag, nicht mehr bei jedem Seitenaufruf.  
* `pear/html_template_it` in der stabilen Version 1.3.3 statt `dev-master`.  
* Die Update-Seite im Admin-Bereich nennt bei einer neuen Version `composer update` statt eines Download-Links; der Link zur Ankündigung im Forum entfällt.  

### Removed  
* Installation per FTP-Upload des Ordners `lmo`: Der LMO wird nur noch per Composer installiert. Bestehende Installationen lassen sich mit `lmo-install` übernehmen (siehe README).  

### Security  
* Die Composer-Abhängigkeiten liegen nicht mehr im LMO-Ordner (bisher `lmo/vendor`); `lmo-install` sperrt den Ordner `vendor` per `.htaccess`.  


***
## [4.2.1] - 2026-10-10

_Hier hätten wir die Changelogs für 4.2.1._  

### Added  
* Automatische Tests für „Rückrundenspielplan erstellen“ und das Verschieben von Partien im Admin-Bereich.  
* Automatische Tests für das Addon „mini“: Die Minitabelle muss dieselbe Tabelle zeigen wie die Haupttabelle.  
* Automatische Tests für die Addons „viewer“ (Ansicht speichern, Spiele nach Datum und Spieltag, Cache) und „ticker“ (Lauftext mit Wertungen, News).  
* Automatische Tests für das Addon „spieler“ (Spielerstatistik): Spieler und Spalten verwalten, Formelspalten, öffentliche Seite und Druckansicht.  
* Automatische Tests für den Mailversand (Liga per E-Mail, Passwort vergessen im Tippspiel).  
* Automatische Tests für Ticker, Viewer und Mini-Spielplan über mehrere Ligen.  

### Changed  
* PHPMailer wird jetzt über Composer installiert (`phpmailer/phpmailer` 7.1) statt als veränderte Kopie in `lmo/includes`.  
* Entwicklungsumgebung (Docker): lokales Postfach für alle Mails von LMO, Übersichtsseite der Addons mit zwei Beispielligen, Doku in `docker/README.md`.  
* GitHub Action: Die Tests laufen mit PHP 8.0, 8.3, 8.4 und 8.5.  
* PHP 8.5 wird unterstützt (README: PHP 8.0 bis 8.5).  

### Deprecated  

### Removed  
* Reste des PDF-Addons (PDF-Erzeuger der Anleitung unter `help/`, auskommentierte Einbindung) und die unbenutzte Datei `lmo-paintgraph.php`. Das separat erhältliche PDF-Addon lässt sich weiterhin einbinden.  

### Fixed  
* „Rückrundenspielplan erstellen“ bei einer Liga mit ungerader Anzahl Spieltage: Die Fehlermeldung erschien nicht, und die Liga wurde trotzdem neu gespeichert und als erfolgreich gemeldet. Jetzt erscheint die Meldung, gespeichert wird nichts.  
* Minitabelle: Der Aufruf mit den mitgelieferten Standardeinstellungen brach unter PHP 8 mit einem Fehler ab (leere Werte für „Plätze darüber/darunter“). Ohne Liga erscheint jetzt die Meldung „Liga nicht gefunden“ ohne PHP-Warnung.  
* Minitabelle: Am ersten Spieltag wurde eine Tendenz angezeigt, obwohl es keinen Vorspieltag gibt. Jetzt ist sie dort für alle Mannschaften 0.  
* Ticker: Der Hinweis „… bekam den Sieg zugesprochen“ stand nach einem gewerteten Spiel auch bei allen folgenden Spielen des Spieltags.  
* Ticker: Breite und Geschwindigkeit ließen sich beim Einbinden nicht übergeben; die Einstellung „Notizen anzeigen“ wirkte bei Pokal-Ligen nicht.  
* Ticker mit mehreren Ligen: Die Spiele der ersten Liga standen bei jeder weiteren Liga noch einmal. Eine fehlende Liga in der Liste zeigte die Spiele der vorigen statt der Meldung „keine passenden Ligen gefunden“.  
* Mini-Spielplan: PHP-Warnung, wenn die beiden Mannschaften in einer Liga nie aufeinandertreffen. Bei den früheren Begegnungen aus dem Archiv konnte die falsche Mannschaft erscheinen, wenn sich zwei Namen nur in Ziffern unterscheiden (z.B. „TSV Muster“ und „TSV Muster 2“).  
* Viewer: PHP-Warnung beim ersten Aufruf einer Ansicht (Cache-Datei noch nicht vorhanden); im Admin-Formular eine PHP-Warnung, wenn das Ligenverzeichnis nicht `ligen/` heißt.  
* classlib: Werte einer Partie (z.B. Verlängerung, beidseitiges Ergebnis) werden im Ligamodus auch gelesen, wenn sie in der Ligadatei vor den Mannschaften der Partie stehen. Minitabelle und Statistik zeigten für solche Dateien andere Punkte als die Haupttabelle.  
* classlib: Bei völligem Gleichstand (gleiche Punkte und Tore) war die Reihenfolge zufällig. Jetzt steht wie in der Haupttabelle die Mannschaft mit der höheren Nummer vorn.  
* classlib: Die Handicap-Reihenfolge (Option „HandS“) wird jetzt wie in der Haupttabelle auf die Gesamttabelle angewendet. Minitabelle und Statistik zeigten bei solchen Ligen bisher andere Plätze.  
* Spielerstatistik: Eine ungültige Formel erzeugte PHP-Warnungen statt des Fehlertexts, eine unvollständige Formel (z.B. `Tore/`) brach die Admin-Seite ab; außerdem erschienen Reste der Formel als Debug-Ausgabe in der Seite.  
* Spielerstatistik: Die öffentliche Seite und die Druckansicht brachen bei einem nicht-numerischen Seitenanfang ab und warnten bei einer unbekannten Sortierspalte; die Druckansicht warnte, wenn es zur Liga keine Statistik gibt.  
* Mailversand: Ein fehlgeschlagener Versand (Liga per E-Mail; Tippspiel: Rundmail, Freischaltung, Benachrichtigung) endete mit einem Fatal Error statt einer Meldung; bei der Rundmail brach schon eine ungültige Adresse den ganzen Lauf ab.  
* Tippspiel: Links in Mails waren fehlerhaft, wenn der Webserver `REQUEST_SCHEME` nicht liefert, und konnten die Parameter der aktuellen Anfrage enthalten.  
* „Liga per E-Mail“ ohne die PHP-Erweiterung `zip` brach mit einem Fehler ab; jetzt erscheint eine Meldung.  
* „Alle Ligen herunterladen“ brach ohne die PHP-Erweiterung `zip` ebenfalls ab; jetzt erscheint eine Meldung. Das Archiv entsteht im Ausgabeordner statt im Programmverzeichnis.  
* Spielerstatistik: Das Löschen einer Spalte, die es nicht gibt, erzeugte eine PHP-Warnung.  
* Zufallsspielplan: Beim Mischen der Mannschaften wurde gelegentlich neben die Liste gegriffen (bei 6 Mannschaften in etwa jedem siebten Aufruf); im erzeugten Spielplan fehlte dann eine Mannschaft.  
* Admin-Bereich ohne Anmeldung: Die Sprachauswahl erzeugte je Sprache eine PHP-Warnung.  
* Admin-Bereich: Der Aufruf der PDF-Optionen ohne installiertes PDF-Addon endete mit einem Fatal Error.  
* Liga aus einer Vorlage mit mehr Mannschaften anlegen: PHP-Warnungen beim Erzeugen der Statistikdatei; Partien mit Mannschaften, die es in der Liga nicht gibt, wurden mitgezählt.  
* Admin-Bereich: Rief ein Hilfsadmin ohne erweiterte Rechte die Mannschaftsverwaltung auf, erschien der Ergebnis-Editor für einen Spieltag, den es nicht gibt (PHP-Warnungen, unbrauchbares Formular). Jetzt öffnet sich der aktuelle Spieltag.  

### Security  
* Spielerstatistik: Die Parameter für Sortierung, Seite und Mannschaft wurden unmaskiert in die Seite geschrieben (Cross-Site-Scripting).  
* Dateien, die LMO nur einbindet (131 Dateien in `lmo/` und den Addons), beenden sich bei direktem Aufruf im Browser sofort. Bisher liefen sie ohne Konfiguration und Rechteprüfung los und gaben Warnungen, Seitenbruchstücke und teils Fehlermeldungen mit Dateipfaden aus.  


***
## [4.2.0] - 2026-10-10

_Hier hätten wir die Changelogs für 4.2.0._  

### Added  
* Ersteinrichtung ohne Installer: Beim ersten Aufruf wird die Konfiguration aus `config-default/` angelegt, das erste Admin-Konto wird über ein Formular erstellt (Texte dafür in allen Sprachen).  
* Sprachauswahl im Fuß des Admin-Bereichs.  
* Automatische Tests (PHPUnit, Docker, GitHub Action), siehe TESTING.md: Golden-Master-Tests für öffentliche Seiten und Admin-Bereich, Unit-Tests für die classlib, Tabellenvergleich mit 75 echten Ligen (OpenLigaDB, Abschlusstabellen aus Wikipedia) und 10 konstruierten Ligen.  
* classlib: Spieltage merken sich weitere Werte der Ligadatei (`spieltag::setParameter()` / `getParameter()`), z.B. die Handicap-Reihenfolge.  

### Changed  
* Die Mindestanforderung des Webservers beträgt jetzt PHP 8.0 (bisher 7.4). Der Admin-Bereich weist bei älteren PHP-Versionen darauf hin.  
* Seitenquelltextausgabe der beiden Datein lmo-savehtml.php und lmo-savehtml1.php verbessert. Außerdem den Tabellen der beiden Seiten runde Ecken verpasst.  
* Template-System über Composer (`pear/html_template_it`, neue Klasse `LMO_Template`) statt der mitgelieferten Dateien IT.php und ITX.php.  
* Addon-Reiter, Viewer-Vorlagen und Ligalisten im Admin-Bereich erscheinen in fester (alphabetischer) Reihenfolge statt in der des Dateisystems.  
* Wertung „beidseitiges Ergebnis“: Das Ergebnis zählt für beide Mannschaften vollständig aus Sicht der Heimmannschaft (Sieg/Unentschieden/Niederlage, Punkte, Minuspunkte). Bisher wurden nur Spiel und Tore gezählt.  
* Straf-/Bonuspunkte und -tore „ab Spieltag X“ zählen erst, wenn Spieltag X Ergebnisse hat. Bisher wurden sie in der Gesamttabelle sofort eingerechnet.  
* Die classlib rechnet Tabellen jetzt wie die Haupttabelle (direkter Vergleich, Strafen, beidseitiges Ergebnis). Minitabelle und Statistik zeigen damit dieselbe Tabelle.  

### Deprecated  


### Removed  
* Installer (`install/`) entfernt, ebenso die nicht mehr benötigten PEAR-Dateien für FTP, Socket und Cache.  

### Fixed  
* Direkter Vergleich: Gleichstand wurde nur an der letzten Ziffer der Punkte erkannt (59 und 49 Punkte galten als gleich).  
* Direkter Vergleich mit zehn und mehr punktgleichen Teams und Minuspunkten: Das beste Team stand am Ende der Gruppe.  
* classlib: Spielende (n.V./i.E.) wurde aus der Ligadatei nicht gelesen und ging beim Speichern verloren.  
* classlib, direkter Vergleich: Gleichstand am Tabellenende wurde nicht ausgewertet, ein zugesprochener Auswärtssieg falsch gebucht, und es wurden immer alle Spiele der Saison gewertet statt nur die der angezeigten Tabelle (Spieltag, Heim/Auswärts).  
* classlib, Strafen: Strafe entfiel, wenn die Mannschaft am Spieltag des Strafbeginns spielfrei war; Bonus-Gegentore wurden mit falschem Vorzeichen verrechnet; Strafen zählten auch in Heim- und Auswärtstabelle.  
* classlib, Speichern (`writeFile()`, genutzt von „Rückrunde erzeugen“ und „Spieltage verschieben“): Handicap-Reihenfolge, Titel und aktueller Spieltag gingen verloren; ein zweites Speichern im selben Aufruf brach ab; Ligen in Unterordnern wurden danach nicht gefunden (HTML-Export und Statistik ohne Daten).  
* classlib, Statistik: Es wurden auch nicht gespielte Partien gezählt; die Serienanzeige überschrieb ihren eigenen Text.  
* classlib: `ligaFussball::sortTable()` lief unter PHP 8 nur mit Warnungen, `liga::factory()` war nicht aufrufbar, `aktuellerSpieltag()` lieferte den folgenden Spieltag, `strAfterChar()`, `readLigaDir()` (Endung `.L98`) und `HTML_icon()` (Suche nach .jpg/.png mit Alternativtext) korrigiert.  

### Security  
* Cross Site Scripting/XSS Lücke geschlossen   
* `lmo-rueckrunde.php` ließ sich ohne Anmeldung direkt aufrufen und schrieb dann die angegebene Ligadatei neu. Jetzt nur noch für angemeldete Admins.  
* Tippspiel: Neue Passwörter werden mit Argon2id bzw. bcrypt gespeichert.  


***
## [4.1.4] - 2024-10-20

_Hier hätten wir die Changelogs für 4.1.4._  

### Added  
* Grundeinstellung des LMO's geändert. Die Mindestanforderung des Webservers beträgt PHP 7.4.xxx - besser wäre einer größer 8.0.0  
* Erstellung eines KO-Turniers mit 24 Teams möglich (neuer UEFA Modus Champions League, Europa League)  
* Erstellung eines Rückrundenspielplans in einer Liga hinzugefügt (thx [DwB](https://github.com/babbisch) and [webfalter](https://github.com/webfalter) for help)  
* Playoff Modus kann nun bei KO-Turnieren besser dargestellt und eingestellt werden ([Preview](https://www.vest-sport.de/forum/viewtopic.php?p=833#p833)).  


### Changed  
* Pop-Up Kalender im Admin Backend auf Mehrsprachig geändert (war vorher fest auf deutsch)  
* TabSprünge bei Eingabe von Daten in KO-Turnieren nach Hinweis von DwB optimiert. 
* Verwendung von [PHPMailer()](https://github.com/PHPMailer/PHPMailer) anstelle von [mail()](https://www.php.net/manual/de/function.mail.php)  
* Sprachdateien aktualisiert (doppelte entfernt bzw. in neue Bezeichnung geändert)  
* Die Flaggen der Sprachauswahl geändert (GIF -> SVG)  
* Ticker Addon nun mit JQuery-Plugin anstelle von eigenem JS >>by [DwB](https://github.com/babbisch)  


### Deprecated  
* utf8_decode() entfernt (mit PHP 8.2.xx deprecated) stattdessen iconv()  



### Removed  
* alte Dateien des Addons Limporter entfernt  


### Fixed  
* Fehler in der Ligastatistik [gefixt](https://github.com/henshingly/lmo_php8/issues/18). Thx DwB
* null-Zugriff vermeiden [#9](https://github.com/henshingly/lmo_php8/pull/9) (thx tombrain)  
* Vermeinden von outOfIndex-Zugriff in liga.class mit Handsortierung [#10](https://github.com/henshingly/lmo_php8/pull/10) (thx tombrain)  
* Message für Tipp-Reminder wird als 0 vorbelegt. [#12](https://github.com/henshingly/lmo_php8/pull/12)  
* PHP-Warnings im Addon Tippspiel [#13](https://github.com/henshingly/lmo_php8/issues/13) >>thx [DwB](https://github.com/babbisch)  
* Fehler, wenn Passwörter Sonderzeichen wie '@!$' enthalten und diese dann in cfg-Dateien gespeichert werden (z.B. in einem FTP Zugang eines Addons). >>thx [DwB](https://github.com/babbisch)  
* diverse Fehler im Addon Tippspiel gefixt (Dank an alle Helfer)


### Security  


***
## [4.1.2] - 2023-10-26

_Hier hätten wir die Changelogs für 4.1.2.  
Wenn ich Sie mir alle gemerkt hätte, deswegen nur ein Auszug_  

### Added  

### Changed  
* Wechselnde Ausgabe der Heimmannschaft in Best-of-3-, Best-of-5- oder Best-of-7-Playoff-Spielen.  
* Bosnische und kroatische Sprachdateien hinzugefügt (thx franjo)  

### Deprecated  

### Removed  

### Fixed  
* Sprachdateien aktualisiert bzw. geändert
* weitere Fehler im Addon Tippspiel gefixt (leider immer noch nicht fehlerfrei)  
* [Fix](https://www.vest-sport.de/forum/viewtopic.php?p=779): Fehler beim erstellen einer NICHT STANDARD Liga  

### Security 


***
***
# League Manager Online (classic design) Change Log (english)  
__All significant changes to the LMO PHP script are documented in this file.__  

## [Unreleased] - YYYY-MM-DD

_Here we write changelog notes for the next version._  

### Added  
- `Lmo\Liga\Rohdaten\Liga` (with `Mannschaft`, `Spieltag`, `Partie`): holds the content of a league file exactly as it is in the file and loads and saves it as a pair. Nothing is converted for display, added or padded; unknown keys and sections are kept. The core of LMO loads and saves every league through it.
- `Lmo\Liga\Einstellungen`: the settings of a league (`[Options]`) with their defaults and the computed sizes (rounds, matches), without changing the raw data – `Rohdaten\Liga::lies($pfad)->einstellungen()->wert('Teams')`. In addition `Mannschaft::anzeigename()`, `Liga::mannschaftsname()` as well as `Spieltag::ersterTag()` and `letzterTag()` on the raw data. Pages can thereby work directly on the raw data; the two loaders of the prediction game already do.


### Changed  
- The classlib reads and writes league files through the same class as the core (`Lmo\Liga\Rohdaten\Liga`). Files written by the classlib thereby have the section order of the core and always contain `[News]`, `[Teamm]` and `[Teamk]`; the values are the same. Whether a file is a league or a cup is now decided by the file type in the classlib too, no longer by the mode of the single round.
- The league lists (league overview, admin: open, delete, download, new league, viewer options; prediction game) read name, type and size of a league through `Lmo\Liga\LigaDatei::liesAbschnitt()` instead of nine reading loops of their own. Blanks around key and value are removed as when loading the league; an unreadable file no longer aborts the list.
- The schedule template when creating a league ("take over from file") as well as the prediction overview and the reminder mail of the prediction game read league files through `Lmo\Liga\Rohdaten\Liga` or `Lmo\Liga\LigaDatei` instead of reading loops of their own. Apart from the classlib and the core, nothing reads a league file by itself any more.
- A league file is always read completely. The two small loaders of the prediction game (`lmo-openfilename.php`, `lmo-openfiledat.php`) and the switch `$lmo_only_st` used to read only single keys or one round and left a half-filled league; now all loaders deliver the same. Only the league lists still read just the `[Options]` section. Visible: a league without a name is no longer called "No Name" in the prediction game but has no name, as everywhere else. In the reminder mail for one round its date is checked as in the main loader: `1.9.2024` becomes `01.09.2024` (empty before), a date that does not exist (`31.02.2025`) is cleared (converted to 03.03. before).
- The two reduced loaders `lmo-openfilename.php` and `lmo-openfiledat.php` use the same reader and the same key mapping as the main loader.
- The whole league file is written through `Lmo\Liga\LigaDaten`; `lmo-savefile.php` only contains opening, locking and writing the lines. The written file is unchanged.
- News, rounds and matches are read by `Lmo\Liga\LigaDaten`; the loader `lmo-openfile.php` only contains the sequence. The values read are unchanged.
- The team sections (`[Teams]`, `[Teamk]`, `[Teamm]`, `[Team1]` …) are now read and saved through `Lmo\Liga\LigaDaten` as well, including the derived short and medium names. Values read and the written file are unchanged.
- Which key of the `[Options]` section belongs to which league value, applies to league or cup and has which default now is kept in one table in `Lmo\Liga\LigaDaten`. The loader `lmo-openfile.php` and saving in `lmo-savefile.php` both use this table; the written file is unchanged.
- The format of the league file (sections, keys, values) is now read by one shared class (`Lmo\Liga\LigaDatei`) that the loader `lmo-openfile.php` and the classlib use.
- The default values of a league (points per win, number of rounds, date format …) now live in `Lmo\Liga\LigaDaten` instead of about 60 single lines in the loader `lmo-openfile.php`. The behaviour does not change.
- The values of a league file are additionally bundled in an object (`Lmo\Liga\LigaDaten`, variable `$ligaDaten`). The existing single variables (`$titel`, `$teams`, `$goala` …) stay valid and point to the same values. All of LMO now reads and writes the league through the object (62 files); the output does not change. Own extensions that use the old variables keep working unchanged.
- 62 old files state at the top which variables they expect. PHPStan thereby checks 33 of them on level 6 and 31 on level 1 instead of level 0.


### Deprecated  


### Removed  


### Fixed  
- Classlib, cup: if a value of a game (e.g. the note of the first leg) stood in the file after the goals of the next game, it was assigned to the wrong game. If the mode of a round expects more games than the file contains, loading no longer aborts.
- Settings in `[Options]` that LMO does not know (including `stats`) and whole unknown sections of a league file were lost when saving in the admin area. They are now kept.
- When several leagues are loaded in one request, values of the previous league remained that the next file does not mention (e.g. penalty points of a league when a cup is loaded afterwards). All values are now cleared before each load.
- A vertical bar (`|`) in a note, a team name, an address or a news line cut off everything after it when loading.
- Prediction game: the same bug in the prediction overview and the reminder mail – a `|` in a team name or a note cut off the rest.
- Prediction game, prediction overview and reminder mail: the values of a game depended on the order of the lines in the league file. If a game lacked a value (note, goals, team), the one of the previous game stayed in effect; in a cup the goals of the second leg could end up at the first leg. Now every game has its own values, and what a league does not state gets the default instead of the value of the league read before.
- Prediction game, entering predictions for a league round: the link to the match report and the hint that a game does not count for the prediction game were missing, and the page raised PHP warnings (`Undefined variable $n`) as soon as match reports were switched on.
- An unreadable date in the last round of a league file (e.g. `D1=ab.cd.efgh`) aborted loading the league; it is now cleared.
- Classlib (addons mini, viewer, ticker): a square bracket in a league name, team name or note cut off the rest of the section (name shortened, team or the "a.e.t." marker missing). Comment lines starting with `;` were read as keys.
- Tip game and user administration: if a league file lacked the number of rounds (`Rounds`), the reduced loader `lmo-openfilename.php` aborted with "Division by zero". Both reduced loaders now fill in missing values like the main loader.


### Security  


***
## [4.3.2] - 2026-10-11

_Here we had the changelogs for 4.3.2._  

### Changed  
* PHPStan now checks the classes and functions of the classlib and the tests on level 5.  
* Classlib: the types in the comments match the behaviour (e.g. `team|null` instead of `object` for the lookup functions, `$` in front of parameter names). The code itself does not change.  

### Fixed  
* Classlib: an unreadable round date in the league file (e.g. `D1=ab.cd.efgh` or `D1=23.08.`) aborted loading the league with an error; it now counts as missing.  
* Classlib: sorting a table without rows (`sortTable()`, `sortDirectTable()`) aborted with an error; `getVerlaufTeam()` and `getVerlaufTeams()` return an empty array for a team outside the league instead of a PHP warning.  


***
## [4.3.1] - 2026-10-11

_Here we had the changelogs for 4.3.1._  

### Added  
* Static analysis with PHPStan (`composer phpstan` or `docker compose run --rm phpstan`, also in the GitHub action): all code on level 0, new code on level 8.  

### Fixed  
* Update check: if the server does not allow outgoing requests (`allow_url_fopen` off), nothing is tried and no cache file is written; a damaged cache file is ignored.  
* `lmo-install` also finds the autoloader when called directly in a Git checkout (`vendor/` next to `lmo/`).  
* Calendar in the admin area: in May the header showed the abbreviation instead of the full month name.  


***
## [4.3.0] - 2026-10-11

_Here we had the changelogs for 4.3.0._  

### Added  
* Installation with Composer: `composer require lmo/lmo_php8`, then `vendor/bin/lmo-install` sets LMO up in the folder `lmo`. `composer update` keeps it up to date automatically; settings, leagues and tips are kept (see README).  

### Changed  
* Only one `composer.json` is left (in the main folder). LMO now reads license and minimum PHP version from `lmo/version.json`; the old `lmo/composer.json` can be deleted after an update.  
* The version number comes from the Git tag of the Composer package and is no longer kept in a file. Without a tagged version (Git checkout) LMO shows `dev`.  
* The search for a new version asks Packagist instead of the check file on vest-sport.de: only in the admin area for the main admin and at most once a day, no longer on every page request.  
* `pear/html_template_it` in the stable version 1.3.3 instead of `dev-master`.  
* The update page in the admin area names `composer update` for a new version instead of a download link; the link to the forum announcement is gone.  

### Removed  
* Installation by uploading the `lmo` folder via FTP: LMO is now installed with Composer only. Existing installations can be taken over with `lmo-install` (see README).  

### Security  
* The Composer dependencies are no longer inside the LMO folder (previously `lmo/vendor`); `lmo-install` blocks the `vendor` folder with an `.htaccess`.  


***
## [4.2.1] - 2026-10-10

_Here we had the changelogs for 4.2.1._  

### Added  
* Automated tests for "create second half of season" and for moving matches in the admin area.  
* Automated tests for the "mini" addon: the mini table must show the same table as the main table.  
* Automated tests for the addons "viewer" (saving a view, matches by date and by match day, cache) and "ticker" (ticker text with ratings, news).  
* Automated tests for the "spieler" addon (player statistics): managing players and columns, formula columns, public page and print view.  
* Automated tests for sending mail (league by e-mail, forgotten password in the betting game).  
* Automated tests for ticker, viewer and mini schedule across several leagues.  

### Changed  
* PHPMailer is now installed via Composer (`phpmailer/phpmailer` 7.1) instead of the modified copy in `lmo/includes`.  
* Development environment (Docker): local mailbox for all mails sent by LMO, overview page of the addons with two sample leagues, documentation in `docker/README.md`.  
* GitHub Action: the tests run with PHP 8.0, 8.3, 8.4 and 8.5.  
* PHP 8.5 is supported (README: PHP 8.0 to 8.5).  

### Deprecated  

### Removed  
* Remains of the PDF addon (PDF generator of the manual under `help/`, commented-out includes) and the unused file `lmo-paintgraph.php`. The separately available PDF addon can still be plugged in.  

### Fixed  
* "Create second half of season" for a league with an odd number of match days: the error message was not shown, and the league was saved again anyway and reported as successful. Now the message is shown and nothing is saved.  
* Mini table: the call with the shipped default settings aborted with an error under PHP 8 (empty values for "places above/below"). Without a league the message "league not found" is now shown without a PHP warning.  
* Mini table: on the first match day a trend was shown although there is no previous match day. Now it is 0 for all teams there.  
* Ticker: after a match decided by ruling, the note "… was awarded the win" also appeared on all following matches of the match day.  
* Ticker: width and speed could not be passed when including the ticker; the setting "show notes" had no effect for cup leagues.  
* Ticker with several leagues: the matches of the first league were repeated for every further league. A missing league in the list showed the matches of the previous one instead of the message "no matching leagues found".  
* Mini schedule: PHP warning when the two teams never meet in a league. For previous meetings from the archive the wrong team could appear when two names differ only in digits (e.g. "TSV Muster" and "TSV Muster 2").  
* Viewer: PHP warning on the first call of a view (cache file not yet present); a PHP warning in the admin form when the league directory is not named `ligen/`.  
* classlib: values of a match (e.g. extra time, result for both sides) are now also read in league mode when they precede the teams of the match in the league file. For such files the mini table and the statistics showed different points than the main table.  
* classlib: with a complete tie (same points and goals) the order was arbitrary. Now, as in the main table, the team with the higher number comes first.  
* classlib: the handicap order (option "HandS") is now applied to the overall table as in the main table. Until now the mini table and the statistics showed different places for such leagues.  
* Player statistics: an invalid formula produced PHP warnings instead of the error text, an incomplete formula (e.g. `Tore/`) aborted the admin page; in addition, remains of the formula appeared in the page as debug output.  
* Player statistics: the public page and the print view aborted on a non-numeric page start and warned on an unknown sort column; the print view warned when there are no statistics for the league.  
* Sending mail: a failed dispatch (league by e-mail; betting game: circular mail, activation, notification) ended with a fatal error instead of a message; with the circular mail a single invalid address aborted the whole run.  
* Betting game: links in mails were broken when the web server does not provide `REQUEST_SCHEME`, and could contain the parameters of the current request.  
* "League by e-mail" without the PHP extension `zip` aborted with an error; now a message is shown.  
* "Download all leagues" also aborted without the PHP extension `zip`; now a message is shown. The archive is created in the output folder instead of the program directory.  
* Player statistics: deleting a column that does not exist produced a PHP warning.  
* Random schedule: shuffling the teams occasionally accessed an entry outside the list (with 6 teams in about every seventh call); the generated schedule then lacked a team.  
* Admin area without login: the language selection produced a PHP warning per language.  
* Admin area: calling the PDF options without the PDF addon installed ended with a fatal error.  
* Creating a league from a template with more teams: PHP warnings while generating the statistics file; matches with teams that do not exist in the league were counted.  
* Admin area: when a helper admin without extended rights opened the team administration, the result editor appeared for a match day that does not exist (PHP warnings, unusable form). Now the current match day opens.  

### Security  
* Player statistics: the parameters for sorting, page and team were written into the page unescaped (cross-site scripting).  
* Files that LMO only includes (131 files in `lmo/` and the addons) now exit immediately when called directly in the browser. Until now they started without configuration and permission check and printed warnings, page fragments and in some cases error messages with file paths.  


***
## [4.2.0] - 2026-10-10

_Here we had the changelogs for 4.2.0._  

### Added  
* First-time setup without the installer: on the first request the configuration is created from `config-default/`, and the first admin account is created through a form (texts available in all languages).  
* Language selection in the footer of the admin area.  
* Automated tests (PHPUnit, Docker, GitHub Action), see TESTING.md: golden master tests for public pages and the admin area, unit tests for the classlib, table comparison against 75 real leagues (OpenLigaDB, final tables from Wikipedia) and 10 constructed leagues.  
* classlib: match days keep additional values of the league file (`spieltag::setParameter()` / `getParameter()`), e.g. the handicap order.  

### Changed  
* The minimum requirement for the web server is now PHP 8.0 (previously 7.4). The admin area shows a notice on older PHP versions.  
* Improved the page source output of lmo-savehtml.php and lmo-savehtml1.php; the tables on both pages now have rounded corners.  
* Template system via Composer (`pear/html_template_it`, new class `LMO_Template`) instead of the bundled files IT.php and ITX.php.  
* Addon tabs, viewer templates and league lists in the admin area appear in a fixed (alphabetical) order instead of the file system order.  
* Rating "result for both sides": the result counts completely for both teams from the home team's point of view (win/draw/loss, points, minus points). Previously only the match and the goals were counted.  
* Penalty/bonus points and goals "from match day X" only count once match day X has results. Previously they were included in the overall table immediately.  
* The classlib now calculates tables like the main table (head-to-head comparison, penalties, result for both sides). The mini table and the statistics therefore show the same table.  

### Deprecated  


### Removed  
* Removed the installer (`install/`) and the PEAR files for FTP, socket and cache that are no longer needed.  

### Fixed  
* Head-to-head comparison: a tie was detected by the last digit of the points only (59 and 49 points were treated as equal).  
* Head-to-head comparison with ten or more tied teams and minus points: the best team was placed last in its group.  
* classlib: the end of a match (after extra time / penalties) was not read from the league file and was lost when saving.  
* classlib, head-to-head comparison: ties at the bottom of the table were not evaluated, an awarded away win was booked incorrectly, and all matches of the season were counted instead of only those of the displayed table (match day, home/away).  
* classlib, penalties: a penalty was dropped if the team had no match on the match day the penalty starts; bonus goals against were applied with the wrong sign; penalties also counted in the home and away tables.  
* classlib, saving (`writeFile()`, used by "create second half of season" and "move match days"): handicap order, title and current match day were lost; a second save in the same request aborted; leagues in subfolders were not found afterwards (HTML export and statistics without data).  
* classlib, statistics: unplayed matches were counted as well; the streak output overwrote its own text.  
* classlib: `ligaFussball::sortTable()` only ran with warnings under PHP 8, `liga::factory()` could not be called, `aktuellerSpieltag()` returned the following match day; fixed `strAfterChar()`, `readLigaDir()` (extension `.L98`) and `HTML_icon()` (search for .jpg/.png with alternative text).  

### Security  
* Closed a cross site scripting (XSS) vulnerability.  
* `lmo-rueckrunde.php` could be called directly without login and then rewrote the given league file. Now restricted to logged-in admins.  
* Prediction game: new passwords are stored with Argon2id or bcrypt.  


***
## [4.1.4] - 2024-10-20

_Here we had the changelogs for 4.1.4._  

### Added  
* Basic setting of the LMO changed. The minimum requirement of the web server is PHP 7.4.xxx - one higher than 8.0.0 would be better  
* Creation of a knockout tournament with 24 teams possible (new UEFA mode Champions League, Europa League)  
* Added creation of a second half game plan in a league (thx [DwB](https://github.com/babbisch) and [webfalter](https://github.com/webfalter) for help)  
* Playoff mode can now be displayed and set better in knockout tournaments ([Preview](https://www.vest-sport.de/forum/viewtopic.php?p=833#p833)).  


### Changed  
* Pop-up calendar in the admin backend changed to multilingual (was previously fixed in German)  
* Optimized tab jumps when entering data in knockout tournaments following advice from DwB.  
* Using [PHPMailer()](https://github.com/PHPMailer/PHPMailer) instead of [mail()](https://www.php.net/manual/de/function.mail.php)  
* Language files updated (duplicate ones removed or changed to new name)  
* Changed the language selection flags (GIF -> SVG)  
* Ticker addon now with JQuery plugin instead of its own JS >>by [DwB](https://github.com/babbisch)


### Deprecated  
* utf8_decode() removed (with PHP 8.2.xx deprecated) iconv() instead  


### Removed  
* Removed old files from the Limporter addon  


### Fixed  
* Bug in league statistics [fixed](https://github.com/henshingly/lmo_php8/issues/18). Thx DwB  
* avoid null access [#9](https://github.com/henshingly/lmo_php8/pull/9) (thx tombrain)  
* Avoid outOfIndex access in liga.class with hand sorting [#10](https://github.com/henshingly/lmo_php8/pull/10) (thx tombrain)  
* Message for tip reminder is preset as 0. [#12](https://github.com/henshingly/lmo_php8/pull/12)  
* PHP warnings in the addon betting game [#13](https://github.com/henshingly/lmo_php8/issues/13) >>thx [DwB](https://github.com/babbisch)  
* Error when passwords contain special characters like '@!$' and these are then saved in cfg files (e.g. in an FTP access of an addon). >>thx [DwB](https://github.com/babbisch)  
* various errors in the addon betting game fixed (thanks to all helpers)  


### Security  


***
## [4.1.2] - 2023-10-26

_Here we have the changelogs for 4.1.2.  
If only I had remembered them all. So just an excerpt from it._  

### Added  


### Changed  
* Alternating edition of the home team in best-of-3, best-of-5 or best-of-7 playoff games.  
* Added Bosnian and Croatian language files (thx franjo)  


### Deprecated  


### Removed  


### Fixed  
* Language files updated or changed  
* further errors fixed in the addon betting game (unfortunately still not error-free)  
* [Fix](https://www.vest-sport.de/forum/viewtopic.php?p=779): Error when creating a NON-STANDARD league  


### Security  
