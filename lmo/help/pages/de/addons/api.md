# JSON-API und Liga-Ansicht

1. [Überblick](#1-ueberblick)
2. [JSON-API](#2-json-api)
3. [Liga-Ansicht](#3-liga-ansicht)

Die API-Erweiterung macht die Daten deiner Ligen für andere Seiten und Programme nutzbar: als **JSON-Schnittstelle** (nur lesend) und als fertige, **serverseitig erzeugte Liga-Ansicht** mit wechselbaren Designs. Beide nutzen dieselbe Rechenlogik wie die normale LMO-Oberfläche, es gibt keine zweite, parallel gepflegte Berechnung.

> **Hinweis:** Die API-Erweiterung ist nicht im LMO-Paket enthalten, sondern ein **separater Download**. Entpacke sie in dein LMO-Verzeichnis (sie legt `addon/api/` und `template/api/` an).

---

## 1. Überblick

| Datei | Zweck |
|---|---|
| `addon/api/lmo-api.php` | JSON-Schnittstelle (nur lesend) |
| `addon/api/init-api.php` | Schlanke Initialisierung der Schnittstelle (ohne Session) |
| `template/api/lmo-liga.php` | Komplette Liga-Ansicht in einer Datei, mit Designs (Themes) |
| `template/api/themes/` | Designs `karten` und `stadium` |

---

## 2. JSON-API

Aufruf: `addon/api/lmo-api.php?file=XXX.l98&resource=...`

Die Schnittstelle ist **nur lesend**, braucht keine Anmeldung, setzt keine Cookies und erlaubt Abrufe von anderen Domains (CORS). Antworten werden 60 Sekunden zwischengespeichert.

| Parameter | Bedeutung |
|---|---|
| `file` | Dateiname der Liga mit Endung `.l98` (Pflicht, ohne Unterordner) |
| `resource` | Gewünschte Ressource (siehe unten), Standard `info` |
| `st` | Spieltag, nur für `results` |
| `team` | Teamnummer als Filter, nur für `program` |
| `team1`, `team2` | Teamnummern, nur für `h2h` |
| `lang` | Sprache, z. B. `Englisch` (Name der LMO-Sprachdatei); sonst die Standardsprache |

| Ressource | Inhalt |
|---|---|
| `info` | Liga-Metadaten |
| `table` | Tabelle (inkl. sportartspezifischer Zusatzfelder) |
| `results` | Ergebnisse eines Spieltags |
| `program` | Spielplan, optional für ein Team |
| `cross` | Kreuztabelle (alle Begegnungen als Matrix) |
| `graph` | Tabellenplatz-Verlauf je Spieltag (Fieberkurve) |
| `h2h` | Direkte Duelle zweier Teams |

Beispiel:

```
addon/api/lmo-api.php?file=1l_2024-25.l98&resource=table
```

---

## 3. Liga-Ansicht

Aufruf: `template/api/lmo-liga.php?file=XXX.l98&view=...&theme=...`

**Live-Beispiel:** [https://www.liga-manager-online.org/test/lmo_git/template/api/lmo-liga.php](https://www.liga-manager-online.org/test/lmo_git/template/api/lmo-liga.php)

Diese Datei ersetzt die einzelnen HTML-Seiten und erzeugt die Ansicht direkt auf dem Server. Die Liga kann auch in einem Unterordner liegen (z. B. `file=dfb/04er-liga.l98`). Ohne `file` zeigt sie eine Auswahl aller Ligen und Unterordner zum Anklicken.

| Parameter | Bedeutung |
|---|---|
| `file` | Liga, ggf. mit Unterordner |
| `dir` | Unterordner, dessen Ligen aufgelistet werden sollen |
| `view` | `uebersicht` (Standard), `tabelle`, `ergebnisse`, `spielplan`, `kreuztabelle`, `fieberkurve`, `direkte-duelle` |
| `theme` | Design: `karten` oder `stadium` |
| `st`, `team`, `team1`, `team2` | wie bei der JSON-API |
| `lang` | Sprache |

**Eigenes Design:** Lege unter `template/api/themes/` einen neuen Ordner mit einer `theme.php` an (Aufbau wie `stadium/theme.php`, dort steht am Anfang, welche Variablen zur Verfügung stehen). Optional gibt eine `meta.php` den Anzeigenamen für den Design-Umschalter an.
