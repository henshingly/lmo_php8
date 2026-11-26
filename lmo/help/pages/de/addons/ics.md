# ICS-Kalender

1. [Überblick](#1-ueberblick)
2. [ICS-Seite aufrufen](#2-ics-seite-aufrufen)
3. [Download oder Abo?](#3-download-oder-abo)
4. [Abo in Kalender-Apps einrichten](#4-abo-in-kalender-apps-einrichten)
5. [Häufige Fragen](#5-haeufige-fragen)

Mit dem ICS-Addon können Besucher den Spielplan einer Mannschaft in ihren eigenen Kalender übernehmen (Google Kalender, Apple Kalender, Outlook, Thunderbird und viele mehr). Neue Spielzeiten und Verlegungen aktualisieren sich im Kalender von selbst, wenn der Kalender **abonniert** wird.

> **Hinweis:** Das ICS-Addon ist nicht im LMO-Paket enthalten, sondern ein **separater Download**: [Letztes Release auf GitHub](https://github.com/henshingly/ics-calendar/releases/latest). Entpacke es in dein LMO-Verzeichnis (es legt `addon/ics/`, `lang/ics/` und `config/ics/` an).

---

## 1. Überblick

| Datei | Zweck |
|---|---|
| `addon/ics/lmo-ics.php` | die ICS-Seite: Liga wählen, Team wählen, Datei erzeugen |
| `lang/ics/lang-<Sprache>.txt` | Texte in 14 Sprachen |
| `config/ics/cfg.txt` | Einstellungen (Spieldauer, Erinnerung, URL im Termin, Vereinsnamen kürzen) |

Auf der Seite stellst du Team, die URL im Kalendereintrag, die Spieldauer (in Minuten) und eine Erinnerung vor Spielbeginn ein. Danach erscheinen der **Download-Link** und der **Abo-Link**.

---

## 2. ICS-Seite aufrufen

* **Aus der Tabelle:** Ist in den Grundeinstellungen der Liga unter *Anzeigen/Darstellung → Verlinkungen* der Punkt **ICS-Kalender verlinken** aktiv, erscheint hinter jedem Team ein kleines Kalender-Symbol. Ein Klick öffnet die ICS-Seite für genau dieses Team.
* **Direkt:** `addon/ics/lmo-ics.php` aufrufen und Liga und Team wählen.

---

## 3. Download oder Abo?

| | Download (`.ics`-Datei) | Abo (`webcal://`) |
|---|---|---|
| Wirkung | einmaliger Import der heutigen Spielzeiten | Kalender bleibt mit dem LMO verbunden |
| Änderungen im LMO | kommen **nicht** an | werden automatisch übernommen |
| Geeignet für | einmalige Übernahme, Geräte ohne Abo-Funktion | normalerweise die bessere Wahl |

Der Abo-Link beginnt mit `webcal://`. Das ist nur eine andere Schreibweise für `https://`: Bei Programmen, die `webcal://` nicht kennen, ersetze am Anfang `webcal://` durch `https://` (oder `http://`, falls die Seite kein HTTPS nutzt).

---

## 4. Abo in Kalender-Apps einrichten

Kopiere zuerst den Abo-Link von der ICS-Seite. Auf Smartphones genügt oft ein Tipp auf den Link; die Kalender-App fragt dann, ob du den Kalender abonnieren möchtest.

### Google Kalender (Computer)

1. Öffne [calendar.google.com](https://calendar.google.com).
2. Klicke links bei **Weitere Kalender** auf **+** und wähle **Per URL**.
3. Füge den Link ein, wobei `webcal://` durch `https://` ersetzt wird.
4. Klicke auf **Kalender hinzufügen**.

Der Kalender erscheint danach auch in der Google-Kalender-App auf Android-Geräten mit demselben Konto. Google aktualisiert abonnierte Kalender nur selten, Änderungen können bis zu einem Tag dauern.

### Apple Kalender (iPhone und iPad)

1. **Einstellungen → Kalender → Accounts → Account hinzufügen → Andere → Kalenderabo hinzufügen**.
2. Link einfügen und auf **Weiter** und **Sichern** tippen.

Alternativ auf den `webcal://`-Link tippen und **Abonnieren** wählen.

### Apple Kalender (Mac)

1. In der App Kalender: **Ablage → Neues Kalenderabonnement**.
2. Link einfügen, auf **Abonnieren** klicken.
3. Name und Aktualisierungsintervall (z. B. stündlich oder täglich) einstellen.

### Microsoft Outlook (Windows, klassisch)

1. **Datei → Kontoeinstellungen → Kontoeinstellungen**.
2. Reiter **Internetkalender → Neu**.
3. Link einfügen, **Hinzufügen** und Namen vergeben.

### Outlook im Web und neues Outlook

1. **Kalender → Kalender hinzufügen → Aus dem Internet abonnieren**.
2. Link einfügen (bei Bedarf `https://` statt `webcal://`), Namen vergeben, **Importieren**.

Die Aktualisierung kann einige Stunden dauern.

### Mozilla Thunderbird

1. Zur Kalender-Ansicht wechseln, dann **Neuer Kalender** (Plus-Symbol bei „Kalender“).
2. **Im Netzwerk** wählen und **Weiter**.
3. Format **iCalendar (ICS)** wählen, den Link in das Feld **Adresse** einfügen, **Weiter** und Namen vergeben.
4. Mit Rechtsklick auf den Kalender → **Eigenschaften** lässt sich das Aktualisierungsintervall (z. B. alle 30 Minuten) einstellen.

### Android ohne Google-Konto (und Samsung Kalender)

Viele Android-Kalender können keine Abos hinzufügen. Die kostenlose App **ICSx⁵** (aus F-Droid oder dem Play Store) abonniert ICS-Links und stellt sie dem Kalender des Geräts zur Verfügung: App öffnen, **+** tippen, Link einfügen, Abo speichern.

### Weitere Programme

Nextcloud, GMX, web.de, IONOS und viele andere Dienste kennen eine Funktion wie *Kalender abonnieren*, *Kalender per URL hinzufügen* oder *Internetkalender*. Dort wird der Link eingetragen, im Zweifel mit `https://` am Anfang.

---

## 5. Häufige Fragen

**Der Kalender zeigt neue Spielzeiten erst spät an.**
Das bestimmt die Kalender-App, nicht der LMO. Google und Outlook im Web aktualisieren selten, Apple und Thunderbird lassen sich häufiger einstellen.

**Ich sehe keine Spiele.**
Der Kalender enthält nur Spiele mit eingetragenem Termin. Die Seite zeigt unter der Liste, wie viele Spiele ohne Termin fehlen.

**Die Uhrzeiten sind verschoben.**
Die Zeiten werden mit der im LMO eingestellten Zeitzone berechnet und in UTC an den Kalender übergeben. Prüfe die Zeitzone in den LMO-Optionen und die des Kalenders.

**Das Abo funktioniert nicht.**
Der Link muss von außen erreichbar sein (kein Passwortschutz, kein reiner Intranet-Server). Teste ihn im Browser mit `https://` statt `webcal://`: Es sollte eine `.ics`-Datei heruntergeladen werden.

**Ich möchte die Spieldauer oder Erinnerung ändern.**
Auf der ICS-Seite die Werte ändern und **ICS-Datei erstellen** wählen. Der Abo-Link enthält diese Einstellungen. Für ein bestehendes Abo muss der neue Link einmal neu abonniert werden.
