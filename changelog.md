# Liga Manager Online (classic design) Change Log (german)
__Alle wesentlichen Änderungen am PHP Script des LMO werden in dieser Datei dokumentiert.__

## [Unveröffentlicht] - YYYY-MM-DD

_Hier schreiben wir Changelog Hinweise der nächsten Version._

### Added
* Tippspiel: Neue Admin-Funktion "Tipps nachtragen" (nur Voll-Admin). Unter Tippspiel → "Tipps nachtragen" wählt der Admin Liga und Tipper und kann dessen Tipps auch nach Spielbeginn oder Spielende eintragen oder ändern (Zeitsperre nur für den Admin aufgehoben). Gilt für alle Ligaarten (Liga, KO/Turnier), beide Tippmodi (Ergebnis, Tendenz) und Joker-Tipps. Danach muss die Auswertung erneut durchgeführt werden. Jeder Nachtrag wird in `config/tipp/nachtrag.php` protokolliert und im Adminmenü angezeigt. Sprachtexte (Schlüssel 306–317) in `lang/tipp/` (14 Sprachen).
* E-Mail-Versand über SMTP: Neuer Bereich "E-Mail-Versand" in den Optionen (nur Voll-Admin) mit Server, Port, Verschlüsselung (keine/STARTTLS/SSL), Benutzername, Passwort und Absenderadresse sowie einem Button "Testmail senden". Das Passwort wird verschlüsselt in `config/smtp/` gespeichert, bei Aufruf über HTTP erscheint ein Hinweis. Sprachdateien in `lang/smtp/` (14 Sprachen).
* PHPMailer 7.2.0 für alle E-Mails des LMO (Ligen per Mail, Tippspiel-Anmeldung, Freischaltung, Newsletter, Reminder, Passwort-Mail). Ist SMTP eingestellt und schlägt der Versand fehl, wird als Rückfall PHP mail() verwendet.
* Neuer Designeditor: alle Bereiche als Reiter in einem Formular, klickbare Live-Vorschau mit einer echten Liga (Ansicht und Breite wählbar), Farbschemata (9 Hauptfarben, Dunkel-Variante, eigene Farbe mit Palette und Hex-Eingabe), Kontrastwarnung, gespeicherte Designs (`config/design/`), Export/Import als JSON, Standardwerte und Verwerfen. Sprachdateien in `lang/design/` (14 Sprachen).

### Changed
* Installer: Am Ende der Installation/Updateinstallation kann der Ordner `install/` per Button gelöscht werden (Fallback `chmod 0`). Der alte Hinweis "Delete install folder or set its chmod to 000!" im Adminbereich entfällt, der Button "Update-Installation starten" ist in allen 14 Sprachen vorhanden.
* Designeditor: Texte nutzen jetzt die LMO-Sprachverwaltung (`$text['design'][n]`) mit englischem Fallback statt einer eigenen Funktion.
* Hilfe "Einstiegsinformationen": Kapitel "3 Installation" und "4 Updateinstallation" getrennt, Hinweise zu Zugriffsrechten und zum Löschen des Installationsordners ergänzt.
* Addon Tippspiel: alle Dateien in `addon/tipp/*.php` nach PSR-12 umformatiert (4 Leerzeichen, kurze Array-Syntax, einfache Anführungszeichen); `array_pad($array, …)` → `array_pad([], …)`.
* Adminbereich: Liegt nach einem Update per FTP noch der Ordner `install/`, erscheint unter der Warnung für den Voll-Admin der Button "Start update installation", der `install/install.php` startet.
* Installer (`install/install.php`) ohne FTP: PHP legt Verzeichnisse und alle `cfg.txt`-Dateien selbst aus den Vorlagen in `install/` an (Ausgangswerte), erkennt Updates (Hinweis in Schritt 0, Pfad und URL aus der vorhandenen `init-parameters.php` vorbelegt), ergänzt dabei nur fehlende Einstellungen und versucht fehlende Schreibrechte per `chmod` zu setzen. Prüfprotokoll mit "Erneut prüfen". `includes/FTP.php` und `includes/Socket.php` entfallen.
* Tipperdaten werden in `addon/tipp/lmo-tipperauth.php` statt `lmo-tippauth.txt` gespeichert (mit Schutzzeile gegen direkten Aufruf). Bestehende Daten werden beim ersten Aufruf automatisch übernommen, die alte Datei wird nach erfolgreichem Schreiben gelöscht. (Idee: [babbisch](https://github.com/babbisch/LMO_PHP8))
* `lmo-style.php` und `lmo-style-nc.php` laden die `init.php` mit `require_once` (Voraussetzung für die Live-Vorschau).
* Mindestanforderung des Webservers ist jetzt PHP 8.2 (`composer.json`, Installer, README und Hilfe angepasst), da einige Funktionen im LMO erst ab dieser Version laufen.
* Hilfe: Installation (Rechte), Installation (neue Verzeichnisse/Rechte), Optionen (E-Mail-Versand, Designeditor), Dateifunktionen, Tippspiel (Mailversand, Platzhalter `[pass]`, Tipperdatei) überarbeitet.
* Seitenquelltextausgabe der beiden Datein lmo-savehtml.php und lmo-savehtml1.php verbessert. Außerdem den Tabellen der beiden Seiten runde Ecken verpasst.

### Deprecated


### Removed
* Nicht mehr benötigt: `includes/FTP.php`, `includes/Socket.php`, `install/addon/tipp/lmo-tippauth.txt`, die Grafiken `*_manual_copy.png` (`img/`, `install/img/`) und `help/media/manual_copy.png`.

### Fixed
* Tippspiel, Fieberkurven (`lmo-tippcalcgraph.php`): undefinierte Variable `$anztipper` und `$tippernick` führte zu PHP-Warnungen.

### Security
* "Tipps nachtragen" ist nur für den Voll-Admin erreichbar, Speichern nur mit Sitzungs-Token (CSRF-Schutz), Liga-Dateiname und Nickname werden geprüft, die simulierte Tipper-Anmeldung wird nach der Anfrage zurückgesetzt. Das Protokoll liegt als PHP-Datei mit `exit`-Schutzzeile vor.
* Der Installer ist nach der Installation gesperrt (nur in der laufenden Installation oder für den angemeldeten Voll-Admin erreichbar); Pfad und URL werden geprüft und beim Schreiben von `config/init-parameters.php` korrekt maskiert.
* Die Werte des Designeditors werden beim Speichern serverseitig geprüft (Farben, Rand, Schriftart, Schriftgröße). Ungültige Eingaben werden ignoriert und können die `cfg.txt` bzw. das Stylesheet nicht mehr beschädigen.
* Die Tipperdatei ist als PHP-Datei mit `exit`-Schutzzeile angelegt und kann nicht mehr im Klartext über den Browser abgerufen werden.
* Die Schnittstellen der Live-Vorschau (`lmo-designcss.php`, `lmo-designstore.php`) antworten nur dem angemeldeten Voll-Admin und nur auf POST, `lmo-designstore.php` zusätzlich mit Sitzungs-Token.
* Cross Site Scripting/XSS Lücke geschlossen


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
* Prediction game: New admin function "Enter tips retroactively" (full admin only). Under Prediction game → "Enter tips retroactively" the admin selects a league and a tipper and can enter or change that tipper's tips even after the matches have started or ended (time limit lifted for the admin only). Works for all league types (league, KO/tournament), both tip modes (result, tendency) and joker tips. The evaluation must be run again afterwards. Every entry is logged in `config/tipp/nachtrag.php` and shown in the admin menu. Language texts (keys 306–317) in `lang/tipp/` (14 languages).
* Sending emails via SMTP: New ‘Email Sending’ section in the options (full admin only) with server, port, encryption (none/STARTTLS/SSL), username, password and sender address, as well as a ‘Send test email’ button. The password is stored in encrypted form in `config/smtp/`; a message appears when accessed via HTTP. Language files in `lang/smtp/` (14 languages).
* PHPMailer 7.2.0 for all LMO emails (leagues via email, prediction game registration, account activation, newsletters, reminders, password reset emails). If SMTP is configured and sending fails, PHP’s `mail()` function is used as a fallback.
* New design editor: all sections as tabs within a single form, clickable live preview using a real league (view and width selectable), colour schemes (9 main colours, dark mode, custom colours via palette and hex input), contrast warning, saved designs (`config/design/`), export/import as JSON, default values and ‘Discard’ option. Language files in `lang/design/` (14 languages).

### Changed
* Installer: At the end of the installation/update the `install/` folder can be deleted with a button (fallback `chmod 0`). The old notice "Delete install folder or set its chmod to 000!" in the admin area is gone; the "Start update installation" button is available in all 14 languages.
* Design editor: texts now use the LMO language handling (`$text['design'][n]`) with English fallback instead of a separate function.
* Help "Introduction": chapters "3 Installation" and "4 Update installation" separated; notes on permissions and on deleting the install folder added.
* Prediction game addon: all files in `addon/tipp/*.php` reformatted to PSR-12 (4 spaces, short array syntax, single quotes); `array_pad($array, …)` → `array_pad([], …)`.
* Admin area: If the `install/` folder remains after an update via FTP, the button “Start update installation” appears beneath the warning for full admins, which launches `install/install.php`.
* Installer (`install/install.php`) without FTP: PHP creates directories and all `cfg.txt` files itself from the templates in `install/` (default values), detects updates (note in step 0; path and URL pre-populated from the existing `init-parameters.php`), only adds missing settings and attempts to set missing write permissions via `chmod`. Verification log with “Check again”. `includes/FTP.php` and `includes/Socket.php` are no longer required.
* Tipper data is stored in `addon/tipp/lmo-tipperauth.php` instead of `lmo-tippauth.txt` (with a protection line to prevent direct access). Existing data is automatically imported on the first run; the old file is deleted once the write operation is successful. (Idea: [babbisch](https://github.com/babbisch/LMO_PHP8))
* `lmo-style.php` and `lmo-style-nc.php` load `init.php` using `require_once` (a prerequisite for the live preview).
* The minimum web server requirement is now PHP 8.2 (`composer.json`, installer, README and help documentation updated), as some functions in LMO only work from this version onwards.
* Help: Installation (permissions), Installation (new directories/permissions), Options (email sending, design editor), file functions, prediction game (email sending, `[pass]` placeholder, predictor file) have been revised.
* Improved output of the source code for the two files `lmo-savehtml.php` and `lmo-savehtml1.php`. Rounded corners have also been added to the tables on both pages.

### Deprecated


### Removed
* No longer needed: `includes/FTP.php`, `includes/Socket.php`, `install/addon/tipp/lmo-tippauth.txt`, the images `*_manual_copy.png` (`img/`, `install/img/`) and `help/media/manual_copy.png`.

### Fixed
* Prediction game, fever curves (`lmo-tippcalcgraph.php`): undefined variables `$anztipper` and `$tippernick` caused PHP warnings.

### Security
* "Enter tips retroactively" is only available to the full admin; saving requires a session token (CSRF protection), league file name and nickname are validated, and the simulated tipper login is reset after the request. The log is a PHP file with an `exit` protection line.
* The installer is locked after installation (accessible only within the current installation or to the logged-in full admin); the path and URL are checked and correctly masked when writing to `config/init-parameters.php`.
* The design editor’s values are checked on the server side when saved (colours, margins, font, font size). Invalid entries are ignored and can no longer corrupt `cfg.txt` or the stylesheet.
* The tipper file is created as a PHP file with an `exit` protection line and can no longer be accessed in plain text via the browser.
* The live preview interfaces (`lmo-designcss.php`, `lmo-designstore.php`) only respond to logged-in full administrators and only to POST requests; `lmo-designstore.php` additionally requires a session token.
* Cross-site scripting (XSS) vulnerability patched


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
