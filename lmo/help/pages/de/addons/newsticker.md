# Newsticker

1. [Steuerparameter](#1-steuerparameter)
2. [Einbindung](#2-einbindung)

![Useransicht](./assets/media/ticker01.png)

Im LMO ist ein flexibler Newsticker integriert, der Ergebnisse und Notizen als platzsparendes Laufband anzeigt. Im [Ergebniseditor](#edit-league/3-der-ergebniseditor) kannst du den Ticker für jede Liga separat ein- oder ausschalten. Er erscheint dann im Userbereich über der jeweiligen Liga. Du kannst ihn aber auch an beliebigen Stellen deiner Homepage einbinden – und sogar so konfigurieren, dass mehrere Ligen in einem Ticker zusammengefasst werden.

---

## 1. Steuerparameter

Mit diesen Parametern steuerst du das Verhalten des Tickers. In der [Addonverwaltung](#options/2-die-addonverwaltung) kannst du die Standardwerte ändern – sie gelten für die Ticker über den Ligen und für jeden Ticker, der keine eigenen Steuerparameter übergeben bekommt.

| Parameter | Wert | Bedeutung |
|---|---|---|
| `standard_ligen` | Dateiname(n) | Dateinamen mit `.l98`-Endung; mehrere Ligen durch Komma trennen |
| `tickerart` | `1` | Ergebnisticker |
| | `2` | Tickertext des LMO |
| | `3` | Ergebnisticker, nur Favoritenteam |
| `tickertitel` | `0` | Tickerüberschrift ausblenden |
| | `1` | Tickerüberschrift anzeigen |
| `notizanzeigen` | `0` | Spielnotizen ausblenden |
| | `1` | Spielnotizen anzeigen |
| `breite` | Zahl | Breite des Tickers (in Buchstabenanzahl) |
| `geschwindigkeit` | Zahl | Scrollgeschwindigkeit des Tickers |

---

## 2. Einbindung

Es gibt zwei Wege, den Newsticker einzubinden. Der erste ist zu bevorzugen; der zweite ist nur für Server ohne PHP-Unterstützung gedacht (wenn der LMO auf einem externen Server läuft) oder wenn du eine `.html`-Datei verwendest (die üblicherweise nicht von PHP verarbeitet wird).

### Einbinden per include

Die Parameter werden direkt als PHP-Variablen gesetzt. Schreibe sie *innerhalb eines PHP-Blocks* (ggf. mit `<?php` öffnen) hintereinander:

```php
$tickerart="1";
$tickerligen="liga1.l98,liga2.l98";
```

Beachte das `$` vor dem Parameternamen, Anführungszeichen um Strings und das schließende Semikolon. Du musst nur die Parameter angeben, die von den Standardeinstellungen abweichen. Danach bindest du den Ticker ein:

```php
include("PfadZumLMO/addon/ticker/ticker.php");
```

`PfadZumLMO` ist der absolute oder relative Pfad zum LMO-Verzeichnis.

> **Achtung:** Verwende niemals eine URL – also kein `include("http://www.../ticker.php");` – das funktioniert nicht! Immer einen **Dateipfad** angeben.

### Einbinden per IFrame

Diese Methode solltest du nur verwenden, wenn die include-Variante aus irgendeinem Grund nicht funktioniert. IFrames werden nicht von allen Browsern unterstützt und haben auch ergonomische Nachteile. Die Parameter sind hier Teil der Source-URL:

```html
<iframe src="URLZumLMO/addon/ticker/ticker.php?tickerart=1&tickerligen=liga1.l98,liga2.l98"
  frameborder="0" marginwidth="0" marginheight="0"
  width="Breite" height="Höhe" scrolling="no"></iframe>
```

`URLZumLMO` ist die Webadresse deines LMO. Bei `Breite` und `Höhe` musst du leider ein bisschen experimentieren. Der erste Parameter wird mit `?` abgetrennt, alle weiteren mit `&`.

---

© 2026 [Liga Manager Online](https://www.liga-manager-online.org/lmo/)
