# Mininext

1. [Konfiguration](#1-konfiguration)
2. [Einbindung](#2-einbindung)
3. [Templates](#3-templates)

![Mininext Screenshot](./assets/media/mininext.png)

Das Mininext-Skript zeigt die kommende Partie einer Mannschaft in einem kompakten Block an, der sich leicht in jede bestehende Seite einbinden lässt. Zusätzlich werden frühere Begegnungen der beteiligten Teams aus dem Archiv absteigend nach Datum angezeigt.

---

## 1. Konfiguration

Das Mininext-Addon wird über die Addonverwaltung des LMO konfiguriert. Für jede einzelne Einbindung können zusätzliche Parameter übergeben werden.

### Addonverwaltung

In der Addonverwaltung klickst du auf den Punkt **mini**. Folgende Grundparameter lassen sich steuern:

| Parameter | Bedeutung |
|---|---|
| `mininext_withArchiv` | Archivdurchsuchung an/aus |
| `mininext_unGreedy` | Unscharfe Suche an/aus – fasst ähnlich lautende Mannschaftsnamen zusammen |
| `mininext_barWidth` | Breite des Balkens für S/U/N |
| `mininext_standardTemplate` | Standard-Template, falls keines übergeben wird |

### Parameter

Per URL (IFrame) oder als include-Variable kannst du folgende Werte übergeben:

| Parameter | Bedeutung |
|---|---|
| `file` | Dateiname der Liga, z. B. `bundesliga.l98` |
| `folder` | Archivordner für die Suche nach Vorpartien. Tipp: Lege je Liga einen eigenen Unterordner an statt alles direkt im Archivordner abzulegen. |
| `a` | Nummer von Mannschaft A. Nur nötig, wenn im Ligafile keine Lieblingsmannschaft eingestellt ist. |
| `b` | Nummer des Gegners. Nicht nötig für die nächste Partie – nur wenn eine bestimmte Paarung angezeigt werden soll. |
| `mini_template` | Template, das verwendet werden soll. Ohne Angabe: Standardtemplate. |

---

## 2. Einbindung

Es gibt zwei Wege. Der erste ist zu bevorzugen; der zweite ist nur für Server ohne PHP-Unterstützung oder `.html`-Dateien gedacht.

### Einbinden per include

Parameter direkt als PHP-Variablen setzen – *innerhalb eines PHP-Blocks* (ggf. mit `<?php` öffnen):

```php
$file="liga1.l98";
$folder="archiv/Erste_Mannschaft";
```

Beachte das `$` vor dem Namen, Anführungszeichen um Strings und das Semikolon am Ende. Nur der Liganame ist Pflicht. Danach bindest du das Addon ein:

```php
include("PfadZumLMO/addon/mini/lmo-mininext.php");
```

`PfadZumLMO` ist der absolute oder relative Pfad zum LMO-Verzeichnis.

> **Achtung:** Niemals eine URL verwenden – kein `include("http://www.../lmo-mininext.php");`! Immer einen **Dateipfad** angeben.

> **Hinweis:** Falls du auf deiner Seite keine Sessions verwendest, füge `<?php session_start(); ?>` als allererste Zeile der Datei ein.

### Einbinden per IFrame

Nur wenn die include-Methode nicht funktioniert. Die Parameter sind Teil der Source-URL:

```html
<iframe src="URLZumLMO/addon/mini/lmo-mininext.php?file=liga1.l98&folder=archiv/Erste_Mannschaft"
  frameborder="0" marginwidth="0" marginheight="0"
  width="Breite" height="Höhe" scrolling="no"></iframe>
```

`URLZumLMO` ist die Webadresse deines LMO. Bei `Breite` und `Höhe` musst du experimentieren. Der erste Parameter wird mit `?` abgetrennt, weitere mit `&`.

---

## 3. Templates

Ähnlich wie beim LMO kannst du auch Mininext in Struktur und Design anpassen. Die Templates liegen im Unterverzeichnis `mini` des Ordners `template`. Standard ist `mininext.tpl.php` (änderbar in der Addonverwaltung). Du kannst beliebig viele Templates (Endung `.tpl.php`) anlegen.

### Das kommende Spiel

| Platzhalter | Bedeutung |
|---|---|
| `<!--gameTxt-->` | Überschrift |
| `<!--gameDate-->` | Datum des kommenden Spiels |
| `<!--gameTime-->` | Uhrzeit des kommenden Spiels |
| `<!--countDown-->` | Countdown bis zur nächsten Partie |
| `<!--homeName-->` | Name des Heimteams |
| `<!--homeNameMiddle-->` | Mittellanger Name des Heimteams |
| `<!--homeNameShort-->` | Kurzname des Heimteams |
| `<!--homeTore-->` | Tore des Heimteams (ab LMO 4.0.2) |
| `<!--imgHomeBig-->` | Großes Icon des Heimteams |
| `<!--imgHomeSmall-->` | Kleines Icon des Heimteams |
| `<!--guestName-->` | Name des Gastteams |
| `<!--guestNameMiddle-->` | Mittellanger Name des Gastteams |
| `<!--guestNameShort-->` | Kurzname des Gastteams |
| `<!--guestTore-->` | Tore des Gastteams (ab LMO 4.0.2) |
| `<!--imgGuestBig-->` | Großes Icon des Gastteams |
| `<!--imgGuestSmall-->` | Kleines Icon des Gastteams |
| `<!--gameNote-->` | Spielnotiz |
| `<!--ligaDatum-->` | Datum der letzten Änderung in der Liga |
| `<!--copy-->` | Copyrighthinweis – **darf nicht geändert oder entfernt werden!** |

### Bisherige Begegnungen

**Außerhalb von `<!-- BEGIN/END matches -->`:**

| Platzhalter | Bedeutung |
|---|---|
| `<!--matchesText-->` | Überschrift für bisherige Spiele |
| `<!--winCount-->` / `<!--drawCount-->` / `<!--lostCount-->` | Anzahl Siege Heim / Unentschieden / Siege Gast |
| `<!--winTxt-->` / `<!--drawTxt-->` / `<!--lostTxt-->` | Beschriftung für Siege/Unentschieden/Niederlagen (z. B. S, U, N) |
| `<!--winWidth-->` / `<!--drawWidth-->` / `<!--lostWidth-->` | Balkenbreite für Siege/Unentschieden/Niederlagen |
| `<!-- BEGIN matches -->` | Beginn des Wiederholungsblocks. **Leerzeichen vor BEGIN und nach matches beachten!** |
| `<!-- END matches -->` | Ende des Wiederholungsblocks. **Leerzeichen vor END und nach matches beachten!** |

**Nur innerhalb von `<!-- BEGIN/END matches -->`:**

| Platzhalter | Bedeutung |
|---|---|
| `<!--class-->` | Farbliche Hervorhebung der Partie |
| `<!--date-->` | Datum der Partie |
| `<!--time-->` | Uhrzeit der Partie |
| `<!--hTore-->` | Heimtore |
| `<!--gTore-->` | Gasttore |
| `<!--where-->` | Heim- oder Auswärtsspiel |
| `<!--matchingName-->` | Bei aktiver unscharfer Suche: gefundener Teamname |

### Das vorherige Spiel

| Platzhalter | Bedeutung |
|---|---|
| `<!--previous_gameTxt-->` | Überschrift |
| `<!--previous_gameDate-->` | Datum des vorherigen Spiels |
| `<!--previous_gameTime-->` | Uhrzeit des vorherigen Spiels |
| `<!--previous_homeName-->` | Name des Heimteams |
| `<!--previous_homeNameMiddle-->` | Mittellanger Name des Heimteams |
| `<!--previous_homeNameShort-->` | Kurzname des Heimteams |
| `<!--previous_imgHomeBig-->` | Großes Icon des Heimteams |
| `<!--previous_imgHomeSmall-->` | Kleines Icon des Heimteams |
| `<!--previous_guestName-->` | Name des Gastteams |
| `<!--previous_guestNameMiddle-->` | Mittellanger Name des Gastteams |
| `<!--previous_guestNameShort-->` | Kurzname des Gastteams |
| `<!--previous_imgGuestBig-->` | Großes Icon des Gastteams |
| `<!--previous_imgGuestSmall-->` | Kleines Icon des Gastteams |

Passe den HTML-Code frei an – achte dabei auf korrektes HTML/CSS.

---