# Tippspiel

1. [Auswertung](#1-auswertung)
2. [Newsletter/Reminder](#2-newsletter-reminder)
3. [Userverwaltung](#3-userverwaltung)
4. [Tipps nachtragen](#4-tipps-nachtragen)
5. [Sicherungsmanager](#5-sicherungsmanager)
6. [Optionen](#6-optionen)

![Tippeinsicht](./assets/media/tippspiel01.png)

Im LMO 4 ist ein umfangreiches und flexibles Tippspiel integriert – basierend auf dem Tippspiel-Addon für den LMO 3 von Frank Albrecht.

---

## 1. Auswertung

Hier wertest du die tippbaren Ligen aus, d. h. jedem Tipper werden seine erzielten Punkte gutgeschrieben. Du kannst jede Liga und jeden Spieltag einzeln auswerten oder alle Spieltage einer Liga auf einmal.

Falls mehrere Ligen getippt werden, kannst du hier auch die **Gesamtwertung** aktualisieren.

Außerdem erstellst und aktualisierst du hier die **Tippeinsichten** – damit können deine Mitspieler sehen, wie die anderen getippt haben. Je nach [Einstellung in den Optionen](#6-optionen) wird die Einsicht erst nach Ablauf des Spieltags freigegeben.

---

## 2. Newsletter/Reminder

Hier kannst du deinen Tippern verschiedene Nachrichten schicken: einen **Newsletter an alle**, **persönliche Mails** an einzelne Mitspieler oder einen **Tippreminder**, der an die Tippabgabe erinnert.

Alle Mails des Tippspiels (auch Anmeldebestätigung, Freischaltung und Passwort-Mail) werden mit der Versandart verschickt, die du in den [globalen Optionen](#options/e-mail-versand-smtp) eingestellt hast (PHP `mail()` oder SMTP). Kommen Mails nicht an, richte dort einen SMTP-Server ein und prüfe ihn mit der Testmail.

Beim Mailversand stehen folgende Platzhalter zur Verfügung:

| Platzhalter | Bedeutung |
|---|---|
| `[nick]` | Nickname des Tippers |
| `[pass]` | Link zum Zurücksetzen des Passworts. Passwörter werden nur als Hash gespeichert und können nicht im Klartext verschickt werden. Über den Link vergibt der Tipper ein neues Passwort. |
| `[name]` | Echter Name des Tippers |
| `[spiele]` | Nur im Tippreminder: listet alle offenen Spiele im angegebenen Zeitraum auf |

---

## 3. Userverwaltung

Hier verwaltest du die Teilnehmer des Tippspiels – du kannst **neue Tipper anlegen**, **Tipper bearbeiten** und **Tipper löschen**. Für jeden Tipper sind folgende Details änderbar:

**Persönliche Daten**
Passwort, Name, Adresse, E-Mail; Sperr-/Freischaltstatus (gesperrt oder freigeschaltet).

**Mailabonnements**
Soll der Tipper den Newsletter oder den Reminder erhalten?

**Team**
In welchem Team spielt der Tipper? (nur bei aktivierter Teamoption)

**Abonnierte Ligen**
Welche Ligen kann der Tipper betippen?

---

## 4. Tipps nachtragen

Nur der **Voll-Admin** kann für einen Tipper Tipps auch nach Spielbeginn oder Spielende eintragen oder ändern, zum Beispiel wenn jemand seine Tipps nicht rechtzeitig abgeben konnte.

1. Im Tippspiel-Admin den Punkt **Tipps nachtragen** wählen.
2. Die Liga auswählen. Angezeigt werden alle Tipper, die für diese Liga eine Tippdatei besitzen.
3. Beim gewünschten Tipper auf **Tipps bearbeiten** klicken. Es öffnet sich die normale Tipp-Eingabe des Tippers, ein roter Hinweis zeigt den Admin-Modus an.
4. Spieltag wählen, Tipps eintragen und speichern.
5. Anschließend die [Auswertung](#1-auswertung) erneut durchführen.

Das funktioniert für alle Ligaarten (Liga, Turnier/KO) und alle Tippmodi (Ergebnis, Tendenz, auch mit Joker). Die Zeitsperre ist nur für den Admin in diesem Modus aufgehoben, Tipper selbst können weiterhin nur innerhalb der Tippfrist tippen.

**Protokoll:** Jeder Nachtrag wird in `config/tipp/nachtrag.php` festgehalten (Datum, Admin, Tipper, Liga, Spieltag). Die Einträge siehst du auch direkt im Tippspiel-Adminmenü unter *Tipps nachtragen*.

---

## 5. Sicherungsmanager

Nur der **Voll-Admin** kann Sicherungen des Tippspiels erstellen und wiederherstellen. Gesichert werden der **Tippordner** (Tipps, Auswertungen, Tippeinsichten, Vereinswertung), die **Datei mit den Daten der Tipper** (`addon/tipp/lmo-tipperauth.php`) und die **Punkteregeln** (`config/tipp/cfg.txt`) als ZIP-Datei. Welcher Ordner der Tippordner ist, steht in den Optionen unter *Pfade* (Standard `addon/tipp/tipps/`). Der Sicherungsmanager verwendet immer diese Einstellung.

**Sicherung erstellen**

1. Im Tippspiel-Admin den Punkt **Sicherungsmanager** wählen.
2. Auf **Sicherung erstellen** klicken. Die Sicherung erscheint sofort in der Liste mit Datum, Typ, Dateianzahl und Größe.
3. Mit **Herunterladen** speicherst du die ZIP-Datei auf deinem Rechner, mit **Löschen** entfernst du sie vom Server.

Die Sicherungen liegen im geschützten Ordner `config/tipp/backup/` und können nur über den Sicherungsmanager heruntergeladen werden. In der ZIP-Datei liegen `tippordner/`, `tipperdatei/`, `punkteregeln/`, eine `info.txt` und eine `manifest.json` mit Prüfsummen.

**Automatische Sicherung**

Unter *Einstellungen* kannst du festlegen, dass vor jeder Auswertung im Adminbereich automatisch eine Sicherung (Typ *Automatisch*) erstellt wird, und wie viele automatische Sicherungen aufbewahrt werden (0 = alle). Ältere automatische Sicherungen werden dann gelöscht, manuelle Sicherungen nie. Die automatische Auswertung bei der Ergebniseingabe löst keine Sicherung aus.

**Sicherung wiederherstellen**

1. In der Liste bei der gewünschten Sicherung auf **Wiederherstellen** klicken. Die Sicherung wird vollständig geprüft (Aufbau, Dateinamen, Prüfsummen).
2. Auswählen, was wiederhergestellt werden soll (Tippordner, Tipperdatei, Punkteregeln) und wie:
   - **Ergänzen und überschreiben (empfohlen):** Dateien, die nicht in der Sicherung stehen, bleiben erhalten.
   - **Exakt wie in der Sicherung:** Tipp-, Auswertungs-, Einsichts- und Vereinsdateien, die nicht in der Sicherung stehen, werden gelöscht.
3. Die Vorschau zeigt, wie viele Dateien neu, überschrieben, unverändert oder gelöscht werden.
4. Zur Bestätigung das Wort **WIEDERHERSTELLEN** eingeben und auf **Wiederherstellen** klicken.

Vor dem Überschreiben erstellt der Sicherungsmanager automatisch eine Sicherung des aktuellen Zustands (Typ *Vor Wiederherstellung*). Gelingt das nicht, oder ist die Sicherung beschädigt, wird nichts verändert. So lässt sich auch eine Wiederherstellung rückgängig machen. Dateien werden erst geschrieben und geprüft und dann ausgetauscht.

**Sicherung hochladen:** Auf einem neuen Server kannst du eine heruntergeladene ZIP-Datei wieder hochladen. Sie wird vor der Übernahme vollständig geprüft, andere Dateien werden abgelehnt.

Alle Aktionen (Erstellen, Herunterladen, Löschen, Hochladen, Wiederherstellen) stehen im **Protokoll** am Ende der Seite. Unter *Einstellungen* legst du fest, nach wie vielen Tagen Protokolleinträge automatisch gelöscht werden (0 = nie). Mit **Protokoll löschen** entfernst du das gesamte Protokoll.

**Wichtig:** Die Tipperdatei enthält Zugangsdaten und E-Mail-Adressen. Behandle heruntergeladene Sicherungen vertraulich. PHP braucht die Erweiterung **Zip** und Schreibrechte für `config/tipp/` und den Tippordner. Fehlt etwas davon, meldet der Sicherungsmanager das. Bei Nginx schützt die `.htaccess` im Sicherungsordner nicht, sperre `config/` dort in der Serverkonfiguration.

---

## 6. Optionen

Das ist der umfangreichste und wichtigste Bereich des Tippspiels. Richte die Optionen am besten einmalig vor dem Start vollständig ein und ändere sie während des laufenden Spiels möglichst nicht mehr wesentlich.

**Tippmodus**
Wähle, ob ein genaues Ergebnis oder nur die Tendenz (Sieg/Unentschieden/Niederlage) getippt wird.

**Pfade**
Hier steht der Pfad, in dem das Tippspiel seine Daten ablegt. Standard ist `/tipps`, das solltest du nicht ohne triftigen Grund ändern. Die Zugangsdaten der Tipper (Nicknamen, Passwort-Hashes, Adressen) liegen in `addon/tipp/lmo-tipperauth.php`. Die Datei beginnt mit einer Schutzzeile (`<?php exit; ?>`), die du nicht entfernen darfst, und braucht Schreibrechte (666).

**Punkteverteilung**
Hier konfigurierst du die Punktevergabe. Je nach Tippmodus stehen unterschiedliche Optionen zur Verfügung – im Tendenzmodus gibt es naturgemäß weniger Einstellungsmöglichkeiten.

**Anzeigen**
Alle hier aktivierten Punkte erscheinen in der Navigationsleiste des Tippspiels.

**Regeltechnisches**
Lege den **Tippabgabeschluss** fest, bestimme **maximale Teamgrößen** und wie viele **Tage im Voraus** getippt werden darf. Außerdem kannst du den **Jokertipp** aktivieren – Tipper können damit pro Spieltag ein Spiel auswählen, bei dem ein Tipp mehr Punkte bringt. Den **Multiplikationsfaktor** legst du hier fest.

**Anmeldung**
Bestimme, welche **Angaben** bei der Anmeldung erforderlich sind, ob eine **Mail-Verifizierung** stattfindet, ob du bei Neuanmeldungen eine **Benachrichtigung** bekommst und ob neue Tipper erst von dir **freigeschaltet** werden müssen.

**Tippabgabe**
Konfiguriere das Aussehen der Tippabgabe. Im Ergebnismodus kannst du **Pfeilbuttons** anzeigen (wie im Ergebniseditor). Um den Tippern eine Orientierung zu geben, kannst du **getippte Tendenzen** und **Durchschnittstipps** einblenden.

> Es gibt zwei Varianten der Tippabgabe: **ligenweise** (pro Liga und Spieltag) oder **datumsweise** (alle Spiele mehrerer Ligen in einem Zeitraum). *Wenn du beide Varianten deaktivierst, ist keine Tippabgabe möglich.*

Außerdem kannst du festlegen, ob bei der Tippabgabe eine **automatische Aktualisierung der Tippeinsichten** erfolgen soll.

**Tippeinsicht**
Wähle, wann die Tippeinsicht angezeigt wird: sofort nach Eingabe, nach Tippabgabeschluss oder erst nach Ergebniseingabe. Außerdem bestimmst du, wie viele Tipper pro Seite angezeigt werden.

**Tipp-Tabelle**
Das Tippspiel berechnet anhand der abgegebenen Tipps eine Tabelle für jeden Teilnehmer. Du kannst eine Tabelle aller Tipper oder eine nach eingebrachten Punkten veröffentlichen.

**Punktestandtabellen**
Konfiguriere die Punktestandsanzeige: nur Gesamtwertung oder zusätzlich Einzelwertungen pro Liga. Außerdem legst du fest, welche persönlichen Daten (Realname, Nickname, Mailadresse) sichtbar sind und wie detailliert die Punktaufschlüsselung erscheint.

**Was zählt bei Punktgleichheit?**
Hier setzt du sogenannte Tie-Breaker: Bei punktgleichen Tippern werden bis zu drei weitere Kriterien in absteigender Priorität herangezogen.

**Zusätzliche Auswertungen**
> Lege fest, was bei der Eingabe der Ligaergebnisse zusätzlich automatisch ausgewertet wird. Wenn du das aktivierst, entfällt die manuelle Aktualisierung – bei sehr vielen Teilnehmern kann es jedoch zu Laufzeitproblemen kommen, da dieser Schritt rechenintensiv ist.

**Tippbare Ligen**
Gib hier frei, welche Ligen bespielt werden können – entweder alle oder nur ausgewählte. *Nur freigegebene Ligen können von Tippern abonniert werden.*

---

© 2026 [Liga Manager Online](https://www.liga-manager-online.org/lmo/)
