# TopTipper

1. [Systemvoraussetzung](#1-systemvoraussetzung)
2. [Dateien erklärt](#2-dateien-erklaert)
3. [Download](#3-download)

![TopTipper-Ansicht](./assets/media/toptipper.png)

Das TopTipper-Addon zeigt den aktuellen Tabellenstand des Tippspiels kompakt und übersichtlich an.

---

## 1. Systemvoraussetzung

- Lauffähiger LMO 4 ab Beta 3 mit aktiviertem Tippspiel

---

## 2. Dateien erklärt

Der Download enthält 4 Dateien.

**`toptipper.php`**
Liegt im Ordner `addon/tipp/`.

**`kal.tip`**
Liegt im Ordner `config/tipp/`. Das ist die Konfigurationsdatei – du kannst sie umbenennen, solange die Endung `*.tip` erhalten bleibt und der neue Name beim Einbinden berücksichtigt wird.

Inhalt der Datei:

```
[config]
modus=1              // Modus auf 1 lassen, kann man vielleicht noch gebrauchen
anzahl_tipper=10     // Anzahl der Tipper in der Anzeige
all=0                // 0 oder 1: 0 zeigt das file, 1 gesamt
file=erg_dfb.l98     // deine Liga
template=standard    // Template-Name ohne die Endung *.tpl.php
```

**`standard.tpl.php`**
Liegt im Ordner `template/tipp/`. Das Template kannst du frei gestalten. Verfügbare Platzhalter:

| Platzhalter | Bedeutung |
|---|---|
| `<!--Link-->` | Link zum Tippspiel |
| `<!--Lmo-->` | Link zum LMO |
| `<!--Platz-->` | Platzierung der Tipper |
| `<!--Name-->` | Name der Tipper |
| `<!--Punkte-->` | Punkte der Tipper |

**`tipp.php`**
Liegt direkt im Root-Verzeichnis deines LMO. Dient zum Einbinden des Skripts – passe den Inhalt entsprechend an.

Beispiel:

```php
<?php
$multi="kal";  // Deine angepasste Datei kal.tip wird eingebunden.
require(dirname(__FILE__) . '/init.php');
include(PATH_TO_ADDONDIR . "/tipp/toptipper.php");
?>
```

---

## 3. Download

- [TopTipper](https://www.liga-manager-online.org/forum/viewtopic.php?t=94)

> Eine ausführliche Installationsanleitung liegt jeder Version bei.

---

© 2026 [Liga Manager Online](https://www.liga-manager-online.org/lmo/)
