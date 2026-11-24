# Minitabellen

1. [Steuerparameter](#1-steuerparameter)
2. [Einbindung](#2-einbindung)
3. [Templates](#3-templates)

![Useransicht](./assets/media/minitabs01.png)

Der LMO bietet die Möglichkeit, Tabellen oder Tabellenausschnitte auf externen Seiten anzuzeigen. So kannst du z. B. auf deiner Startseite eine kompakte Version der aktuellen Tabelle einbinden. Welche Details angezeigt werden und wie die Tabelle aussieht, lässt sich über [Templates](#3-templates) frei gestalten.

---

## 1. Steuerparameter

Ähnlich wie beim Ticker gibt es auch bei den Minitabellen verschiedene Steuerparameter.

| Parameter | Bedeutung |
|---|---|
| `mini_liga` | Dateiname der Liga (mit Endung `.l98`) |
| `mini_platz` | Um welchen Tabellenplatz herum soll der Ausschnitt zentriert sein? Leer lassen für die Lieblingsmannschaft. |
| `mini_ueber` | Wie viele Mannschaften über der ausgewählten anzeigen? |
| `mini_unter` | Wie viele Mannschaften unter der ausgewählten anzeigen? |
| `mini_template` | Name des Templates (ohne Dateiendung). Ohne Angabe wird `standard` verwendet. |

---

## 2. Einbindung

Es gibt zwei Wege, Minitabellen einzubinden. Der erste ist zu bevorzugen; der zweite ist nur für Server ohne PHP-Unterstützung oder `.html`-Dateien gedacht.

### Einbinden per include

Die Parameter werden direkt als PHP-Variablen gesetzt – *innerhalb eines PHP-Blocks* (ggf. mit `<?php` öffnen):

```php
$mini_liga="liga1.l98";
$mini_ueber=3;          // 3 Mannschaften über dem Lieblingsteam
$mini_unter=2;          // 2 Mannschaften unter dem Lieblingsteam
$mini_template="all";   // Template "all.tpl.php" verwenden
```

Beachte das `$` vor dem Parameternamen, Anführungszeichen um Strings und das schließende Semikolon. Nur der Liganame ist Pflicht. Danach bindest du die Minitabelle ein:

```php
include("PfadZumLMO/addon/mini/lmo-minitab.php");
```

`PfadZumLMO` ist der absolute oder relative Pfad zum LMO-Verzeichnis.

> **Achtung:** Verwende niemals eine URL – kein `include("http://www.../minitab.php");` – das funktioniert nicht! Immer einen **Dateipfad** angeben.

### Einbinden per IFrame

Nur wenn die include-Methode nicht funktioniert. IFrames haben Nachteile (Browser-Kompatibilität, Ergonomie). Die Parameter sind Teil der Source-URL:

```html
<iframe src="URLZumLMO/addon/mini/lmo-minitab.php?mini_liga=liga1.l98&mini_ueber=3&mini_unter=2&mini_template=all"
  frameborder="0" marginwidth="0" marginheight="0"
  width="Breite" height="Höhe" scrolling="no"></iframe>
```

`URLZumLMO` ist die Webadresse deines LMO. Bei `Breite` und `Höhe` musst du leider experimentieren. Der erste Parameter wird mit `?` abgetrennt, weitere mit `&`.

---

## 3. Templates

Ähnlich wie beim LMO kannst du auch die Minitabellen in Struktur und Design frei anpassen. Die Templates liegen im Unterverzeichnis `mini` des Ordners `template`. Ohne Steuerparameter wird `standard.tpl.php` verwendet. Du kannst beliebig viele Templates (Endung `.tpl.php`) anlegen.

Folgende Platzhalter stehen zur Verfügung:

| Platzhalter | Bedeutung |
|---|---|
| `<!--Link-->` | Link zur vollständigen Tabelle im LMO |
| `<!-- BEGIN Inhalt -->` | Beginn des Blocks, der für jede Mannschaft wiederholt wird. **Leerzeichen vor BEGIN und nach Inhalt beachten!** |
| `<!-- END Inhalt -->` | Ende des Wiederholungsblocks. **Leerzeichen vor END und nach Inhalt beachten!** |
| `<!--Style-->` | Aktiviert die Hervorhebung von Meister, Absteigern etc. gemäß Ligaeinstellung |
| `<!--Team-->` | Kurzname der Mannschaft |
| `<!--TeamLang-->` | Vollständiger Name der Mannschaft |
| `<!--TeamMittel-->` | Mittellanger Name der Mannschaft |
| `<!--TeamBild-->` | Teamicon (falls vorhanden) |
| `<!--Teamnotiz-->` | Notiz der Mannschaft |
| `<!--Spiele-->` | Anzahl der Spiele |
| `<!--Punkte-->` | Punkte; bei Negativpunkten in der Form **+P:-P** |
| `<!--PlusTore-->` | Geschossene Tore |
| `<!--MinusTore-->` | Gegentore |
| `<!--Tordifferenz-->` | Tordifferenz |
| `<!--Siege-->` | Anzahl der Siege |
| `<!--Unentschieden-->` | Anzahl der Unentschieden |
| `<!--Niederlagen-->` | Anzahl der Niederlagen |

Passe den HTML-Code nach Belieben an – achte auf korrektes HTML/CSS. Im Template `all.tpl.php` findest du alle Platzhalter als Anschauungsbeispiel.

---