# Viewer

1. [Templates](#1-templates)

![Useransicht](./assets/media/viewer01.png)

Der Viewer ist ein Addon für den LMO 4. Er stellt die Begegnungen beliebiger und beliebig vieler Teams der vorherigen/nächsten XX Tage ab dem aktuellen Datum dar – und das ligaübergreifend. Obwohl er größtenteils im Adminbereich konfiguriert wird, ist der Viewer ein eigenständiges Skript, das du an beliebiger Stelle deiner Website einbinden kannst. Über [Templates](#1-templates) lässt sich die Ausgabe frei gestalten.

---

## 1. Templates

Ähnlich wie beim LMO kannst du auch den Viewer in Struktur und Design frei anpassen. Die Templates liegen im Verzeichnis `template/viewer` – dort findest du auch Beispiele.

### Globale Variablen

| Platzhalter | Bedeutung |
|---|---|
| `<!--Titelzeile-->` | Konfigurierte Titelzeile |
| `<!--VERSION-->` | Copyrighthinweis mit Versionsinformationen – **darf nicht geändert oder entfernt werden!** |

### Ligenblock

| Platzhalter | Bedeutung |
|---|---|
| `<!-- BEGIN Liga -->` / `<!-- END Liga -->` | Inhaltsblock einer Liga. **Leerzeichen vor BEGIN und nach Liga beachten!** |

Folgende Platzhalter sind nur innerhalb von `<!-- BEGIN/END Liga -->` sinnvoll:

| Platzhalter | Bedeutung |
|---|---|
| `<!--Ligadatum-->` | Speicherdatum der Liga |
| `<!--Liganame-->` | Name der Liga |
| `<!--ErgebnisLink-->` | Link zur Ergebnisübersicht der Liga |
| `<!--Anfangsspieltag-->` / `<!--Endespieltag-->` | Erster und letzter ausgegebener Spieltag (nur bei spieltagsweiser Anzeige) |
| `<!--Spieltageminus-->` / `<!--Spieltageplus-->` | Anzahl der nach hinten/vorn ausgegebenen Spieltage (nur bei spieltagsweiser Anzeige) |
| `<!--Anfangsdatum-->` / `<!--Enddatum-->` | Anzahl der nach hinten/vorn ausgegebenen Tage (nur bei datumsweiser Anzeige) |

### Spieltagsblock

| Platzhalter | Bedeutung |
|---|---|
| `<!-- BEGIN Spieltag -->` / `<!-- END Spieltag -->` | Inhaltsblock eines einzelnen Spieltags (nur bei spieltagsweiser Anzeige). **Leerzeichen vor BEGIN und nach Spieltag beachten!** |

Folgende Platzhalter sind nur innerhalb von `<!-- BEGIN/END Spieltag -->` sinnvoll:

| Platzhalter | Bedeutung |
|---|---|
| `<!--AktSpieltag-->` | Dieser Spieltag |
| `<!--AktSpieltagLink-->` | Link zur Ergebnisübersicht dieses Spieltags |

### Inhaltsblock (Spiel)

| Platzhalter | Bedeutung |
|---|---|
| `<!-- BEGIN Inhalt -->` / `<!-- END Inhalt -->` | Inhaltsblock eines einzelnen Spiels. **Leerzeichen vor BEGIN und nach Inhalt beachten!** |

Folgende Platzhalter sind nur innerhalb von `<!-- BEGIN/END Inhalt -->` sinnvoll:

| Platzhalter | Bedeutung |
|---|---|
| `<!--Heim-->` / `<!--Gast-->` | Teamnamen in der konfigurierten Länge |
| `<!--HeimLang-->` / `<!--GastLang-->` | Langer Teamname |
| `<!--HeimMittel-->` / `<!--GastMittel-->` | Mittellanger Teamname |
| `<!--HeimKurz-->` / `<!--GastKurz-->` | Kurzer Teamname |
| `<!--ToreHeim-->` / `<!--ToreGast-->` | Tore der Teams (einzeln) |
| `<!--Tore-->` | Spielergebnis als `x:y` |
| `<!--Datum-->` | Spieldatum |
| `<!--Uhrzeit-->` | Anstoßzeit |
| `<!--Spieltag-->` | Spieltag des Spiels |
| `<!--Iconheim-->` / `<!--Icongast-->` | Teamicons (klein) |
| `<!--IconMiddleheim-->` / `<!--IconMiddlegast-->` | Teamicons (mittel) |
| `<!--IconBigheim-->` / `<!--IconBiggast-->` | Teamicons (groß) |
| `<!--IconBigheimalt-->` / `<!--IconBiggastalt-->` | Teamicons (groß, alternativ) |
| `<!--Notiz-->` | Spielnotiz |
| `<!--Tabellenlink-->` | Link zur Tabelle |
| `<!--Spieltaglink-->` | Link zur Ergebnisansicht des Spieltags |
| `<!--Spielbericht-->` | Link zum Spielbericht |
| `<!--Zeilenklasse-->` | Hervorhebung des heutigen Datums (`vRow` normal, `vRowHighlight` heute) |
| `<!--Ligadatum-->` | Speicherdatum der Liga |
| `<!--Liganame-->` | Name der Liga |

---

© 2026 [Liga Manager Online](https://www.liga-manager-online.org/lmo/)
