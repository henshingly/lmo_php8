# JSON-API en competitieweergave

1. [Overzicht](#1-overzicht)
2. [JSON-API](#2-json-api)
3. [Competitieweergave](#3-competitieweergave)

De API-uitbreiding maakt de gegevens van je competities bruikbaar voor andere sites en programma's: als (alleen-lezen) **JSON-interface** en als kant-en-klare, **op de server gegenereerde competitieweergave** met wisselbare ontwerpen. Beide gebruiken dezelfde rekenlogica als de gewone LMO-interface; er is geen tweede, apart onderhouden berekening.

> **Opmerking:** De API-uitbreiding zit niet in het LMO-pakket, maar is een **aparte download**. Pak haar uit in je LMO-map (ze maakt `addon/api/` en `template/api/` aan).

---

## 1. Overzicht

| Bestand | Doel |
|---|---|
| `addon/api/lmo-api.php` | JSON-interface (alleen lezen) |
| `addon/api/init-api.php` | Lichte initialisatie van de interface (zonder sessie) |
| `template/api/lmo-liga.php` | Complete competitieweergave in één bestand, met ontwerpen (thema's) |
| `template/api/themes/` | Ontwerpen `karten` en `stadium` |

---

## 2. JSON-API

Aanroep: `addon/api/lmo-api.php?file=XXX.l98&resource=...`

De interface is **alleen-lezen**, vereist geen aanmelding, plaatst geen cookies en staat aanvragen vanaf andere domeinen toe (CORS). Antwoorden worden 60 seconden gecachet.

| Parameter | Betekenis |
|---|---|
| `file` | Bestandsnaam van de competitie met extensie `.l98` (verplicht, zonder submappen) |
| `resource` | Gewenste bron (zie hieronder), standaard `info` |
| `st` | Speeldag, alleen voor `results` |
| `team` | Teamnummer als filter, alleen voor `program` |
| `team1`, `team2` | Teamnummers, alleen voor `h2h` |
| `lang` | Taal, bijv. `Englisch` (naam van het LMO-taalbestand); anders de standaardtaal |

| Bron | Inhoud |
|---|---|
| `info` | Metagegevens van de competitie |
| `table` | Stand (incl. sportspecifieke extra velden) |
| `results` | Uitslagen van een speeldag |
| `program` | Speelschema, optioneel voor één team |
| `cross` | Kruistabel (alle wedstrijden als matrix) |
| `graph` | Verloop van de ranglijstpositie per speeldag (vormcurve) |
| `h2h` | Onderlinge duels van twee teams |

Voorbeeld:

```
addon/api/lmo-api.php?file=1l_2024-25.l98&resource=table
```

---

## 3. Competitieweergave

Aanroep: `template/api/lmo-liga.php?file=XXX.l98&view=...&theme=...`

**Live voorbeeld:** [https://www.liga-manager-online.org/test/lmo_git/template/api/lmo-liga.php](https://www.liga-manager-online.org/test/lmo_git/template/api/lmo-liga.php)

Dit bestand vervangt de afzonderlijke HTML-pagina's en genereert de weergave direct op de server. De competitie mag in een submap staan (bijv. `file=dfb/04er-liga.l98`). Zonder `file` toont het een aanklikbare keuze van alle competities en submappen.

| Parameter | Betekenis |
|---|---|
| `file` | Competitie, evt. met submap |
| `dir` | Submap waarvan de competities worden getoond |
| `view` | `uebersicht` (standaard), `tabelle`, `ergebnisse`, `spielplan`, `kreuztabelle`, `fieberkurve`, `direkte-duelle` |
| `theme` | Ontwerp: `karten` of `stadium` |
| `st`, `team`, `team1`, `team2` | zoals bij de JSON-API |
| `lang` | Taal |

**Eigen ontwerp:** Maak in `template/api/themes/` een nieuwe map met een `theme.php` (opbouw als `stadium/theme.php`; bovenaan staat welke variabelen beschikbaar zijn). Optioneel geeft een `meta.php` de weergavenaam voor de ontwerpkiezer.
