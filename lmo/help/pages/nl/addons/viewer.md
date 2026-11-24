# Viewer

1. [Templates](#1-templates)

![Gebruikersweergave](./assets/media/viewer01.png)

De Viewer is een add-on voor LMO 4. Hij toont de wedstrijden van willekeurige en willekeurig veel teams van de afgelopen/komende XX dagen vanaf de huidige datum, competitieoverstijgend. Hoewel hij grotendeels in het beheergedeelte wordt ingesteld, is de Viewer een zelfstandig script dat je overal op je website kunt opnemen. Via [templates](#1-templates) is de uitvoer vrij vorm te geven.

---

## 1. Templates

Net als bij de LMO kun je structuur en vormgeving van de Viewer vrij aanpassen. De templates staan in de map `template/viewer`, waar je ook voorbeelden vindt.

### Globale variabelen

| Plaatshouder | Betekenis |
|---|---|
| `<!--Titelzeile-->` | Ingestelde titelregel |
| `<!--VERSION-->` | Copyrightvermelding met versie-informatie, **mag niet worden gewijzigd of verwijderd!** |

### Competitieblok

| Plaatshouder | Betekenis |
|---|---|
| `<!-- BEGIN Liga -->` / `<!-- END Liga -->` | Inhoudsblok van een competitie. **Let op de spaties voor BEGIN en na Liga!** |

De volgende plaatshouders zijn alleen binnen `<!-- BEGIN/END Liga -->` zinvol:

| Plaatshouder | Betekenis |
|---|---|
| `<!--Ligadatum-->` | Opslagdatum van de competitie |
| `<!--Liganame-->` | Naam van de competitie |
| `<!--ErgebnisLink-->` | Link naar het uitslagenoverzicht van de competitie |
| `<!--Anfangsspieltag-->` / `<!--Endespieltag-->` | Eerste en laatste getoonde speeldag (alleen bij weergave per speeldag) |
| `<!--Spieltageminus-->` / `<!--Spieltageplus-->` | Aantal speeldagen dat achteruit/vooruit wordt getoond (alleen bij weergave per speeldag) |
| `<!--Anfangsdatum-->` / `<!--Enddatum-->` | Aantal dagen dat achteruit/vooruit wordt getoond (alleen bij weergave per datum) |

### Speeldagblok

| Plaatshouder | Betekenis |
|---|---|
| `<!-- BEGIN Spieltag -->` / `<!-- END Spieltag -->` | Inhoudsblok van één speeldag (alleen bij weergave per speeldag). **Let op de spaties voor BEGIN en na Spieltag!** |

De volgende plaatshouders zijn alleen binnen `<!-- BEGIN/END Spieltag -->` zinvol:

| Plaatshouder | Betekenis |
|---|---|
| `<!--AktSpieltag-->` | Deze speeldag |
| `<!--AktSpieltagLink-->` | Link naar het uitslagenoverzicht van deze speeldag |

### Inhoudsblok (wedstrijd)

| Plaatshouder | Betekenis |
|---|---|
| `<!-- BEGIN Inhalt -->` / `<!-- END Inhalt -->` | Inhoudsblok van één wedstrijd. **Let op de spaties voor BEGIN en na Inhalt!** |

De volgende plaatshouders zijn alleen binnen `<!-- BEGIN/END Inhalt -->` zinvol:

| Plaatshouder | Betekenis |
|---|---|
| `<!--Heim-->` / `<!--Gast-->` | Teamnamen in de ingestelde lengte |
| `<!--HeimLang-->` / `<!--GastLang-->` | Lange teamnaam |
| `<!--HeimMittel-->` / `<!--GastMittel-->` | Middellange teamnaam |
| `<!--HeimKurz-->` / `<!--GastKurz-->` | Korte teamnaam |
| `<!--ToreHeim-->` / `<!--ToreGast-->` | Doelpunten van de teams (apart) |
| `<!--Tore-->` | Wedstrijduitslag als `x:y` |
| `<!--Datum-->` | Wedstrijddatum |
| `<!--Uhrzeit-->` | Aanvangstijd |
| `<!--Spieltag-->` | Speeldag van de wedstrijd |
| `<!--Iconheim-->` / `<!--Icongast-->` | Teamiconen (klein) |
| `<!--IconMiddleheim-->` / `<!--IconMiddlegast-->` | Teamiconen (middel) |
| `<!--IconBigheim-->` / `<!--IconBiggast-->` | Teamiconen (groot) |
| `<!--IconBigheimalt-->` / `<!--IconBiggastalt-->` | Teamiconen (groot, alternatief) |
| `<!--Notiz-->` | Wedstrijdnotitie |
| `<!--Tabellenlink-->` | Link naar de stand |
| `<!--Spieltaglink-->` | Link naar de uitslagenweergave van de speeldag |
| `<!--Spielbericht-->` | Link naar het wedstrijdverslag |
| `<!--Zeilenklasse-->` | Markering van de datum van vandaag (`vRow` normaal, `vRowHighlight` vandaag) |
| `<!--Ligadatum-->` | Opslagdatum van de competitie |
| `<!--Liganame-->` | Naam van de competitie |
