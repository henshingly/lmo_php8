# Optionen

1. [Globale Optionen](#1-globale-optionen)
2. [Die Addonverwaltung](#2-die-addonverwaltung)
3. [Der Designeditor](#3-der-designeditor)
4. [Die Userverwaltung](#4-die-userverwaltung)
5. [Das Ligenarchiv](#5-das-ligenarchiv)

---

## 1. Globale Optionen

Über den Menübefehl **Optionen** gelangst du in den Optionsbereich. Hier legst du die globalen Skripteinstellungen fest. Hilfs-Admins haben hier keinen Zutritt.

**Grundeinstellungen:** Standardsprache, Ligenverzeichnis, Standard-Anstoßzeit, Format der Anstoßtermine, E-Mail des Webmasters, E-Mail-Versand (PHP `mail()` oder SMTP) und die Reihenfolge der Ligasortierung in der Ligenauswahl.

**Tabellenoptionen:** Position der Punktespalte und Art der Tabellendarstellung.

**Anzeigen/Darstellung:** Hier legst du fest, welche Bestandteile des LMO angezeigt werden.

### E-Mail-Versand (SMTP)

Alle E-Mails des LMO (Ligen per E-Mail senden, im Tippspiel Anmeldung, Freischaltung, Passwort-Mails, Newsletter und Tippreminder) laufen über die Einstellungen im Bereich **E-Mail-Versand**. Du findest ihn in den Grundeinstellungen direkt unter der E-Mail des Webmasters. Nur der Voll-Administrator sieht und ändert diese Einstellungen.

| Einstellung | Bedeutung |
|---|---|
| Versandart | **PHP mail()** ist die Voreinstellung und funktioniert, wenn dein Server selbst Mails versenden darf. Kommen Mails nicht an oder landen im Spam, wähle **SMTP-Server**. Schlägt SMTP fehl, versucht der LMO die Mail als Rückfall noch einmal mit `mail()`. |
| Server, Port, Verschlüsselung | Die Daten bekommst du von deinem Mailprovider. Üblich sind STARTTLS mit Port 587 oder SSL/TLS mit Port 465. *keine (unverschlüsselt)* nur in Ausnahmefällen wählen. |
| Benutzername, Passwort | Zugangsdaten des Postfachs, meist die E-Mail-Adresse. Das Passwort wird nach dem Speichern nie wieder angezeigt. Lass das Feld leer, um es unverändert zu lassen, oder lösche es über das Häkchen. Am besten nutzt du ein eigenes Postfach nur für den Versand. |
| Absenderadresse | Optional. Ist das Feld leer, wird die E-Mail des Webmasters verwendet. Viele Anbieter erlauben nur Absender, die zum SMTP-Konto passen. |
| Testmail senden | Sendet mit den aktuell eingetragenen (auch ungespeicherten) Werten eine Testmail an die E-Mail des Webmasters, die dafür gespeichert sein muss. Die Testmail geht nur über SMTP, ohne Rückfall auf `mail()`, damit Fehler sichtbar werden. Das Ergebnis erscheint neben dem Button. |

**Wo wird das Passwort gespeichert?** Verschlüsselt in `config/smtp/cfg.php`, der Schlüssel liegt in `config/smtp/key.php`. Beide Dateien sind per Schutzzeile gegen direkten Aufruf gesichert. Der Schlüssel liegt allerdings auf demselben Server: Die Verschlüsselung schützt davor, dass die Konfigurationsdatei versehentlich lesbar wird (z.B. in einem Backup), aber nicht vor jemandem mit Zugriff auf das gesamte Serververzeichnis. Rufe den Adminbereich möglichst nur über HTTPS auf. Bei einer Verbindung über HTTP zeigt der LMO einen Hinweis.

---

## 2. Die Addonverwaltung

Die Addonverwaltung steuert die Addons, die den LMO um zusätzliche Funktionen erweitern. Sie ist für versierte Benutzer gedacht. Ändere hier nur Werte, wenn das jeweilige Addon keine eigene Konfigurationsoberfläche hat.

Wähle im Auswahlmenü das Addon und ändere die Konfigurationsvariablen direkt. Es findet **keine Prüfung der Eingaben** statt, falsche Angaben können den LMO im schlimmsten Fall unbrauchbar machen.

---

## 3. Der Designeditor

Mit dem Designeditor passt du Farben und Schriften an deine Homepage an. Du findest ihn unter **Optionen → Designeditor**. Er steht nur dem Voll-Administrator zur Verfügung. Links stellst du die Werte ein, rechts siehst du sofort, wie eine deiner Ligen damit aussieht. Erst mit **Änderungen speichern** wird etwas übernommen.

### Aufbau des Editors

Die Einstellungen sind in Reiter gegliedert. Alle Reiter gehören zu **einem** Formular: Eingaben bleiben beim Wechsel zwischen den Reitern erhalten, ein Klick auf *Änderungen speichern* sichert alles.

| Reiter | Inhalt |
|---|---|
| Äußerer Rahmen | Seitenhintergrund, Grundschrift, Überschrift, Haupt- und Untermenü des äußeren Bereichs |
| Mittlerer Rahmen | Bereich um die jeweilige Anzeige mit eigener Überschrift sowie Haupt- und Untermenü |
| Innerer Rahmen | Tabellen: normale Zellen, Hervorhebungen (z.B. Tabellenköpfe) und Links |
| Tabelle | Farben der Tabellenplätze (Meister, Champions League, Euroleague, Relegation, Absteiger) sowie Heim- und Auswärtstabelle |
| Turnierbereich | Farben für Sieger und Verlierer in Turnierplänen (K.-o.-Runden) |
| Sonstige Optionen | Kreuztabelle, Kalender, Wochenenden, Fieberkurven, Schriftgrößen, Unterstreichen von Links |
| Formulare | Eingabefelder und Buttons |

### Die Live-Vorschau

Rechts siehst du eine echte Liga deiner Installation (es muss mindestens eine Liga angelegt sein). Jede Änderung wird sofort angezeigt, auch ohne Speichern. Über die Auswahlfelder oberhalb wählst du

- die **Liga**, mit der du testest,
- die **Ansicht** (Tabelle, Ergebnisse, Spielpläne, Kreuztabelle, Kalender) und
- die **Breite** (Desktop, Tablet, Smartphone). Das LMO-Layout passt sich nicht automatisch an die Bildschirmbreite an, die schmale Vorschau kann daher seitlich scrollen.

**Anklicken statt suchen:** Fährst du in der Vorschau mit der Maus über einen Bereich, wird er orange umrandet und benannt (z.B. „Mittlerer Rahmen: Hauptmenü“). Ein Klick öffnet den passenden Reiter und markiert das Feld. Links in der Vorschau werden dabei nicht ausgelöst.

### Farben und Schriften einstellen

Jede Farbe legst du auf zwei Wegen fest: per Eingabe als Hex-Code (`#1b6b2f`, kurz `#0a0`) oder englischem Farbnamen (`red`), oder per Klick auf das Farbfeld, das den Farbwähler deines Browsers öffnet.

Bei vielen Feldern gehören zwei Farben zusammen: zuerst die Hintergrund-, dann die Schriftfarbe. Ein leeres Feld setzt keine Farbe, der Browser nimmt dann seinen Standard. Daneben gibt es Randangaben (z.B. `1px solid #000000`), die Schriftart (z.B. `Verdana, sans-serif`) und die Schriftgröße (z.B. `13px` oder `94%`).

> **Kontrastwarnung:** Sind Hintergrund- und Schriftfarbe zu ähnlich, markiert der Editor die Zeile und den Reiter mit einem Warnsymbol ⚠. Empfohlen ist ein Kontrast von mindestens 4,5 zu 1. Die Warnung ist nur ein Hinweis, du kannst trotzdem speichern.

**Prüfung der Eingaben:** Beim Speichern werden alle Werte geprüft. Ungültige Angaben werden ignoriert, der bisherige Wert bleibt erhalten. Das Stylesheet kann so nicht durch Tippfehler beschädigt werden.

### Farbschemata

Über dem Formular wählst du ein **Farbschema** (Standard, Rasengrün, Rot, Himmelblau, Orange, Anthrazit, Lila, Türkis, Bordeaux). Ein Klick stellt Rahmen, Menüs, Kreuztabelle und Formulare in einem Zug auf die gewählte Hauptfarbe um.

- **Dunkel:** verwendet die dunkle Variante des Schemas.
- **Eigene Farbe:** öffnet eine Palette mit 108 Farben. Dort wählst du eine Farbe, nimmst per Browser-Farbwähler jede beliebige oder gibst einen Hex-Code ein (Eingabe mit Enter bestätigen).
- **Standard** stellt die ursprünglichen LMO-Farben wieder her.

Die Farben von Tabelle (Meister, Auf-/Absteiger) und Turnierbereich ändert ein Schema bewusst nicht, weil sie eine feste Bedeutung tragen. Danach kannst du jede Farbe von Hand nachbessern. Auch ein Schema gilt erst nach *Änderungen speichern*.

### Gespeicherte Designs

Unter dem Formular verwaltest du eigene Designs auf dem Server, z.B. ein Sommer- und ein Winterdesign.

- **Speichern unter …** legt die aktuellen Werte unter einem frei wählbaren Namen ab (Buchstaben, Ziffern, Leerzeichen, `-` und `_`). Existiert der Name schon, wirst du vor dem Überschreiben gefragt.
- **Laden** übernimmt das gewählte Design ins Formular und in die Vorschau. Für Besucher sichtbar wird es erst nach *Änderungen speichern*.
- **Löschen** entfernt das gewählte Design.

Die Designs liegen als Textdateien in `config/design/`. Der Ordner `config` muss dafür beschreibbar sein, der Unterordner wird bei Bedarf automatisch angelegt.

### Export und Import

**Exportieren** lädt das aktuelle Design (auch mit ungespeicherten Änderungen) als Datei `lmo-design-JJJJMMTT.json` herunter, **Importieren** lädt eine solche Datei ins Formular. So sicherst du ein Design, überträgst es auf eine andere Installation oder tauschst es mit anderen LMO-Betreibern. Beim Import werden nur bekannte Felder mit gültigen Werten übernommen.

Zwei Hilfsfunktionen gibt es außerdem: **Standardwerte** setzt alle Felder auf die ursprünglichen Werte zurück (nach Rückfrage), **Änderungen verwerfen** macht alles seit dem letzten Speichern rückgängig.

### Eigene Ergänzungen mit style.css

Reicht dir der Designeditor nicht, bearbeite die Datei `template/style.css`. Ihre CSS-Angaben werden automatisch geladen, überschreiben die Einstellungen des Designeditors und sind auch in der Live-Vorschau sichtbar. Alle Einstellungen des Editors liegen in `config/cfg.txt` (Variablen `lmo_…`) und werden beim Aufruf in ein Stylesheet umgesetzt.

---

## 4. Die Userverwaltung

Die Userverwaltung erreichst du über **Optionen → Userverwaltung**. Zuerst siehst du alle eingerichteten Admins und Hilfs-Admins. Zum Ändern wählst du den Account aus, änderst die Angaben und klickst auf **Speichern**. **Löschen** entfernt einen Account unwiderruflich.

Bei Hilfs-Admins legst du zusätzlich unter **Freigegebene Ligen** fest, auf welche Ligen sie Zugriff haben.

Einen neuen Account legst du im Bereich **Neuen Admin hinzufügen** an. Die Felder sind vorbelegt, das Passwort ist ein Zufallspasswort, das du übernehmen kannst. Weise dem neuen Administrator danach seine Rechte zu.

### Hilfs-Admins

Hilfs-Admins tragen Ergebnisse ein, haben aber keinen Zugang zu den empfindlichen Ligaeinstellungen oder zu den globalen Optionen. Praktisch, wenn Helfer die aktuellen Ergebnisse für dich eintragen.

### Erweiterte Hilfs-Admins

Reichen die Rechte eines Hilfs-Admins nicht, kannst du sie erweitern. Ein erweiterter Hilfs-Admin ist ein vollwertiger Administrator, aber nur für seine Ligen:

- Er kann die ihm zugewiesenen Ligen komplett verwalten.
- Er hat keinen Zugriff auf die globalen Optionen.

---

## 5. Das Ligenarchiv

Abgelaufene Ligen kannst du im integrierten Archiv ablegen, ohne dass die Ligenauswahl zu lang wird. Lege dazu im Ordner `ligen/` ein Verzeichnis mit aussagekräftigem Namen an (z.B. `Bundesliga`) und verschiebe die Ligen hinein. Verzeichnisse lassen sich beliebig verschachteln.

Ist die entsprechende Einstellung in den globalen Optionen aktiv, sehen deine Besucher das Archiv mit einem Link für jedes Unterverzeichnis. Für eine Beschreibung legst du in einem Verzeichnis die Textdatei `dir-descr.txt` an (z.B. „Alle Bundesligen von 1963 bis 2000“). Nach dem Klick auf den Verzeichnislink wählen die Besucher die Ligen wie gewohnt aus. Archivierte Ligen kannst du im Adminbereich weiterhin bearbeiten.
