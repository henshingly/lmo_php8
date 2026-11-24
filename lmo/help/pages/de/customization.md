# Anpassung des LMO

1. [Teamicons](#1-teamicons)
2. [Eigene CSS-Definitionen](#2-eigene-css-definitionen)
3. [Templates](#3-templates)
4. [Einbinden des LMO in vorhandene Homepages](#4-einbinden-des-lmo-in-vorhandene-homepages)

Neben dem [Designeditor](#options/3-der-designeditor) kannst du den LMO über Teamicons, eigenes CSS und ein einfaches Templatesystem an deine Homepage anpassen.

---

## 1. Teamicons

Mit kleinen Vereinswappen wertest du den LMO optisch auf. Der LMO findet die Dateien automatisch:

- Kopiere die Icons in `img/teams/small/`.
- Der Dateiname muss dem Namen der Mannschaft entsprechen (auch Punkte oder Leerzeichen). Nur das Zeichen `/` ist nicht erlaubt, lass es im Dateinamen einfach weg.
- Einige Addons zeigen vergrößerte Icons an. Diese legst du in `img/teams/big/` ab.
- Erlaubt sind die Formate PNG, GIF und JPG.

> **Apache 2:** Entferne aus den Dateinamen alle Sonderzeichen, erlaubt sind nur Buchstaben und Zahlen.

---

## 2. Eigene CSS-Definitionen

Reichen dir die Einstellungen des Designeditors nicht, bearbeite die Datei `template/style.css`. Sie wird automatisch geladen und überschreibt den Designeditor. Mit einem Texteditor bearbeiten, bei Bedarf mit dem [W3C-CSS-Validator](https://jigsaw.w3.org/css-validator/) prüfen.

---

## 3. Templates

Ein Template ist eine HTML-Datei, die durch HTML-Kommentare der Form `<!--Name-->` ergänzt wird. Der LMO ersetzt jeden Kommentar durch den entsprechenden Teil seiner Ausgabe. Mit der Lage der Kommentare bestimmst du, wo etwas erscheint. Lässt du einen Kommentar weg, entfällt der Teil. Du kannst auch mehrere Templates für denselben LMO verwenden.

Die Templates liegen im Ordner `template/` (`lmo-standard-komplett.tpl.php` und `lmo-standard.tpl.php`). Für Addons gibt es weitere Templates, z.B. in `template/mini/` und `template/viewer/`.

| Kommentar | Inhalt |
|---|---|
| `<!--Titel-->` | Titeltext des LMO |
| `<!--Stylesheet-->` | Das Stylesheet |
| `<!--Newsticker-->` | Der integrierte Newsticker |
| `<!--Kalender-->` | Navigationslink zum Kalender |
| `<!--Ergebnisse-->` | Navigationslink zu den Ergebnissen |
| `<!--Tabelle-->` | Navigationslink zur Tabelle |
| `<!--Spielplan-->` | Navigationslink zum Spielplan |
| `<!--Kreuztabelle-->` | Navigationslink zur Kreuztabelle |
| `<!--Fieberkurve-->` | Navigationslink zur Fieberkurve |
| `<!--Ligastatistik-->` | Navigationslink zur Ligastatistik |
| `<!--Spielerstatistik-->` | Navigationslink zur Spielerstatistik |
| `<!--Tippspiel-->` | Navigationslink zum Tippspiel |
| `<!--Info-->` | Navigationslink zur Infoseite, **bitte nicht entfernen** |
| `<!--Hauptteil-->` | Hauptteil des LMO |
| `<!--Savehtml-->` | Links für die Druckversionen unter Ergebnissen bzw. Tabelle |
| `<!--Sprachauswahl-->` | Sprachauswahl |
| `<!--Ligenuebersicht-->` | Link zur Ligenübersicht |
| `<!--LetzteAuswertung-->` | Datum der letzten Auswertung der gewählten Liga |
| `<!--Berechnungszeit-->` | Berechnungszeit |
| `<!--Infolink-->` | Copyrighthinweis, **darf nicht entfernt werden** (siehe [Rechtliches](#getting-started/7-rechtliches)) |

Achte darauf, dass korrektes HTML entsteht. Mit dem [W3C-HTML-Validator](https://validator.w3.org/) kannst du das prüfen.

Je nach Einbindung brauchst du eines von zwei Templates: ein **komplettes HTML-Dokument** für den direkten Aufruf oder ein Template mit **nur dem HTML-Teil** für die Einbindung per `include`.

---

## 4. Einbinden des LMO in vorhandene Homepages

Du kannst den LMO direkt aufrufen oder per `include` in deine Seiten einbinden.

### Direkter Aufruf

Rufe den LMO über `lmo.php` auf. Welches Template verwendet wird, steht in dieser Datei. Standard ist `lmo-standard-komplett.tpl.php`, ein komplettes HTML-Dokument.

Der direkte Aufruf eignet sich auch für ein **IFrame**:

```html
<iframe src="URL-zum-LMO/lmo.php" width="Breite" height="Höhe" style="border:0"></iframe>
```

Breite und Höhe musst du leider ausprobieren, das ist einer der Nachteile von IFrames.

Über Parameter in der URL startest du direkt in einer bestimmten Ansicht, z.B. `lmo.php?file=liga.l98` für den Start mit einer Liga.

Für ein zweites Template kopierst du `lmo.php`, benennst sie um (z.B. `lmoneu.php`) und änderst darin den Template-Aufruf. Du erreichst den „neuen“ LMO dann unter `lmoneu.php`.

### Include

Bequemer ist die Einbindung per `include` in eine bestehende PHP-Seite:

```php
<?php include("PfadZumLMO/lmo.php"); ?>
```

Dabei musst du Folgendes beachten:

- **`PfadZumLMO` ist ein Dateipfad, keine URL.** `include("http://www.meineseite.de/lmo/lmo.php");` funktioniert nicht.
- Eine Liga, die statt der Ligenübersicht sofort geöffnet wird, gibst du **vor** dem include an: `$file = "NameDerLiga.l98";`
- Geladen wird standardmäßig `lmo-standard.tpl.php` (ohne „komplett“). Das ist kein vollständiges HTML-Dokument, die übrigen Teile kommen aus deiner Seite.
- Ganz oben in deiner Seite (allererste Zeile) muss stehen:

  ```php
  <?php if (session_id() == "") session_start(); ?>
  ```

- Verwendet deine Seite noch keinen `<!DOCTYPE html>`, ergänze ihn. Gib außerdem im `<head>` den Zeichensatz an: `<meta charset="utf-8">`
- Binde im `<head>` das LMO-Stylesheet ein:

  ```html
  <link rel="stylesheet" href="PfadZumLMO/lmo-style-nc.php">
  <style>@import url('PfadZumLMO/lmo-style.php');</style>
  ```

Mit derselben Methode kannst du mehrere Templates verwenden.
