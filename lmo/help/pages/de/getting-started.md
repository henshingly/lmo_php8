# Erste Schritte

1. [Einleitung](#1-einleitung)
2. [Systemvoraussetzungen](#2-systemvoraussetzungen)
3. [Installation](#3-installation)
4. [Zugriffsrechte bei Problemen](#4-zugriffsrechte-bei-problemen)
5. [Update-Installation](#5-update-installation)
6. [Login/Logout](#6-login-logout)
7. [Rechtliches](#7-rechtliches)

---

## 1. Einleitung

Willkommen beim Liga Manager Online! Mit diesem Skript bietest du deinen Besuchern einen Ergebnisdienst für deine Lieblingsligen an. Die gesamte Verwaltung läuft direkt auf dem Server: Du trägst nur die Ergebnisse ein, und deine Besucher sehen sofort die aktuellen Tabellen, Statistiken und Spielpläne.

Der Adminbereich ist über `lmoadmin.php` erreichbar. Leg dir am besten ein Lesezeichen dafür an, denn im Besucherbereich gibt es aus Sicherheitsgründen keinen Link dorthin. Deine Besucher starten den LMO über die Datei `lmo.php`. Wie du ihn in deine Homepage einbindest, steht unter [Anpassung](#customization/4-einbinden-des-lmo-in-vorhandene-homepages).

Zu jedem Link gibt es einen Tooltip, weitere Erklärungen zur Bedienung sind deshalb meist nicht nötig.

---

## 2. Systemvoraussetzungen

- **Webserver:** Apache, Nginx oder ein anderer Webserver mit PHP (Linux oder Windows)
- **PHP:** Version **8.2 oder höher**
- **Datenbank:** nicht nötig, der LMO speichert alles in Dateien (Flatfiles)
- **PHP-Erweiterungen:** `mbstring`, `session` und `json` (bei fast jedem Hoster vorinstalliert). Optional: **Zip** für den Download aller Ligen und Zip-Anhänge im Mailversand, **OpenSSL** für den E-Mail-Versand über SMTP mit Verschlüsselung (TLS/SSL). Die Fieberkurven (Liga und Tippspiel) werden im Browser gezeichnet und brauchen keine GD-Bibliothek.
- **Schreibrechte:** PHP muss in die Verzeichnisse für Ligen, Konfiguration und Ausgaben schreiben dürfen. Der Installer prüft das und setzt die Rechte, wenn möglich.
- **Browser:** ein aktueller Browser mit aktiviertem JavaScript

> **Hinweis für Apache 2:** Entferne aus den Dateinamen der Teamicons alle Sonderzeichen. Erlaubt sind nur Buchstaben und Zahlen.

---

## 3. Installation

Die Einrichtung läuft komplett im Browser, du brauchst dafür keine FTP-Zugangsdaten einzutragen.

1. Entpacke das ZIP-Archiv und lade den **gesamten Inhalt** unter Beibehaltung der Verzeichnisstruktur auf deinen Server.
2. Rufe den LMO im Browser auf, z.B. `https://www.deine-seite.de/lmo/lmoadmin.php`. **Die Installation startet automatisch** und richtet Pfade, Konfiguration und Zugriffsdaten ein.
3. Nach erfolgreicher Installation erscheint der Button **Installationsordner jetzt löschen**. Klicke ihn an, damit der Ordner `install` nicht auf dem Server liegen bleibt.
4. Melde dich an und ändere sofort das Passwort (siehe [Login/Logout](#6-login-logout)).

Normalerweise ist der LMO danach fertig eingerichtet. Wenn die Installation abbricht, prüfe zuerst die [Zugriffsrechte](#4-zugriffsrechte-bei-problemen).

### Manuelle Installation

> **Nur nötig, wenn die automatische Installation nicht funktioniert.**

1. Kopiere den Inhalt des Ordners `install` in dein LMO-Verzeichnis und lösche danach die Datei `install/install.php`.
2. Lege die Datei `config/init-parameters.php` an (oder öffne sie) und trage die beiden Pfade ein:

   ```php
   <?php
   $lmo_dateipfad = '/absoluter/pfad/zum/lmo'; // Dateipfad zum LMO
   $lmo_url = 'https://www.deine-seite.de/lmo'; // absolute URL zum LMO
   ```

   Falls du beides nicht kennst, frag deinen Provider.
3. Setze die Zugriffsrechte wie im nächsten Abschnitt beschrieben.

---

## 4. Zugriffsrechte bei Problemen

Der LMO muss in einige Ordner und Dateien schreiben dürfen. Meldet er, dass etwas nicht beschreibbar ist, setze die Rechte (chmod) wie folgt:

![Zugriffsrechte setzen (chmod)](./assets/media/manual_chmod.png)

**Verzeichnisse (777):**

- `ligen` und alle Unterverzeichnisse
- `output`
- `config` und die Unterverzeichnisse `config/viewer` und `config/smtp`
- `addon/spieler/stats`
- `addon/tipp/tipps` und alle Unterverzeichnisse

**Dateien (666):**

- `config/lmo-auth.php`
- `addon/tipp/lmo-tipperauth.php`
- `config/smtp/cfg.php` und `config/smtp/key.php` (sofern vorhanden)
- alle `cfg.txt`-Dateien im Verzeichnis `config` und dessen Unterverzeichnissen
- alle Ligen im Verzeichnis `ligen` und dessen Unterverzeichnissen
- alle Dateien in `output`, `addon/spieler/stats` und `addon/tipp/tipps` (sofern vorhanden)

---

## 5. Update-Installation

Beim Update einer vorhandenen Installation werden deine Konfigurationsdateien und Ligen nicht überschrieben.

1. Sichere vorher dein gesamtes LMO-Verzeichnis (mindestens `ligen`, `config` und `addon/tipp/tipps`).
2. Kopiere die neuen Dateien über die vorhandenen. Eigene Anpassungen (z.B. in `template/` oder `img/teams/`) bleiben erhalten, sofern du dieselben Dateien nicht ersetzt.
3. Rufe den Adminbereich auf. Der LMO meldet **Update erkannt**. Klicke auf **Update-Installation starten**.
4. Das Update passt die Konfiguration an. Dabei werden unter anderem die Passwörter der Tipper im Tippspiel auf eine sichere (gehashte) Speicherung umgestellt.
5. Lösche danach über den Button **Installationsordner jetzt löschen** den Ordner `install`.

> **Hinweis:** Falls der Ordner `config/smtp` nicht beschreibbar ist, weist dich der LMO darauf hin. Der E-Mail-Versand über SMTP lässt sich dann erst nach dem Setzen der Rechte speichern.

---

## 6. Login/Logout

Beim Aufruf von `lmoadmin.php` erscheint die Anmeldemaske. Nach einer Neuinstallation sind der Benutzername `admin` und das Passwort `lmo` (kleines L, M, O) voreingestellt. **Ändere das Passwort so schnell wie möglich** unter [Optionen → Userverwaltung](#options/4-die-userverwaltung), damit kein Unbefugter Zugriff bekommt.

Wenn du eingeloggt bist, findest du im Menü den Eintrag **Logout**. Nutze ihn am Ende jeder Sitzung.

---

## 7. Rechtliches

> Dieses Skript wird unter den Bestimmungen der [GPL](https://www.gnu.org/licenses/gpl.txt) ([deutsche Übersetzung](https://www.gnu.de/documents/gpl.de.html)) veröffentlicht. Das bedeutet: Du darfst das Skript nutzen, weitergeben und verändern, eine Garantie wird jedoch nicht gewährt. **Copyrighthinweise müssen in jedem Fall erhalten bleiben und dürfen weder entfernt noch geändert werden.**

Obwohl die Software sorgfältig entwickelt wurde, kann keine Haftung für Fehler oder Schäden übernommen werden, die durch die Nutzung entstehen.
