# Team Plan

1. [Systemvoraussetzung](#1-systemvoraussetzung)
2. [Konfiguration](#2-konfiguration)
3. [Einbindung](#3-einbindung)
4. [Download](#4-download)
5. [Versionsverlauf](#5-versionsverlauf)

![TeamPlan-Ansicht](./assets/media/teampl01.png)

Das Addon ermöglicht die Ausgabe des Spielplans einer ausgewählten Mannschaft als PDF-Dokument – direkt über den Link „Spielpläne" im LMO.

---

## 1. Systemvoraussetzung

- Lauffähiger LMO 4
- Installiertes Classlib-Addon von Tim Schumacher (im Addon-Archiv erhältlich), inklusive PDF-Class von [Wayne Munro, R&OS Ltd](http://www.ros.co.nz/pdf) (in der Classlib enthalten)

---

## 2. Konfiguration

Das TeamPlan-Addon wird über die Addonverwaltung des LMO konfiguriert.

### Addonverwaltung

Klicke in der Addonverwaltung auf den Punkt **pdf**. Folgende Parameter stehen zur Verfügung:

| Parameter | Beschreibung |
|---|---|
| `linktarget` | Öffnet das PDF in einem neuen Fenster (z. B. `_blank`) |
| `show_adobe_link` | Hinweis auf den PDF-Reader mit Bild: **0** = aus / **1** = an |
| `homepage` | Zeigt einen Text am Rand an, z. B. deine Homepage-Adresse |
| `anzeige` | Sortierung nach Spieltag / Datum: **0** / **1** |
| `format` | Ausgabeformat A4 Quer- / Hochformat: **0** / **1** |
| `teamfett` | Ausgewählte Mannschaft hervorheben: **0** = aus / **1** = an |
| `teamnamen` | Teamname lang / kurz / mittel: **0** / **1** / **2** |
| `serie` | Hin-/Rückrunde auf 1 Seite / 2 Seiten: **0** / **1** |

---

## 3. Einbindung

### In den LMO einbinden

> Zugriffsrechte (chmod) setzen:
> **Dateien:** `666` – alle `cfg.txt`-Dateien im Verzeichnis `config` und dessen Unterverzeichnissen

Öffne die Datei `lmo-showprogram.php` und füge unter der letzten Zeile

```php
} ?>
```

folgenden Code ein:

```php
<?
// Teamplan ADDON BEGIN
if (file_exists(PATH_TO_ADDONDIR.'/pdf/lmo-showprogram.inc.php'))
    include(PATH_TO_ADDONDIR.'/pdf/lmo-showprogram.inc.php');
// Teamplan ADDON END
?>
```

Nach der Installation erscheint unterhalb des Auswahlfensters „Spielpläne" der neue Link **Spielplan als PDF-Dokument**.

> **Hinweis:** Der Copyrighthinweis mit Versionsinformationen darf **nicht** geändert oder entfernt werden!

---

## 4. Download

- [Teamplan](http://www.liga-manager-online.de/lmo-forum/viewtopic.php?t=5489)

---

## 5. Versionsverlauf

**1.0**
- Spielplanausgabe im PDF-Format

**2.0**
- Sortierung der Ausgabe
- Hervorhebung des ausgewählten Teams
- Teamname und Format wählbar
- Getrennte Ausgabe für Hin- und Rückrunde

---