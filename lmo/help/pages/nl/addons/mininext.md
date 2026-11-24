# Mininext

1. [Configuratie](#1-configuratie)
2. [Opnemen](#2-opnemen)
3. [Templates](#3-templates)

![Mininext-schermafbeelding](./assets/media/mininext.png)

Het Mininext-script toont de komende wedstrijd van een team in een compact blok dat eenvoudig in elke bestaande pagina is op te nemen. Daarnaast worden eerdere ontmoetingen van de betrokken teams uit het archief getoond, aflopend op datum.

---

## 1. Configuratie

De Mininext-add-on wordt via het add-onbeheer van de LMO geconfigureerd. Voor elke afzonderlijke opname kunnen extra parameters worden meegegeven.

### Add-onbeheer

Klik in het add-onbeheer op het item **mini**. De volgende basisparameters zijn instelbaar:

| Parameter | Betekenis |
|---|---|
| `mininext_withArchiv` | Archief doorzoeken aan/uit |
| `mininext_unGreedy` | Vage zoekopdracht aan/uit; voegt gelijkluidende teamnamen samen |
| `mininext_barWidth` | Breedte van de balk voor W/G/V |
| `mininext_standardTemplate` | Standaardtemplate als er geen wordt meegegeven |

### Parameters

Via URL (iframe) of als include-variabelen kun je de volgende waarden meegeven:

| Parameter | Betekenis |
|---|---|
| `file` | Bestandsnaam van de competitie, bijv. `bundesliga.l98` |
| `folder` | Archiefmap voor het zoeken naar eerdere wedstrijden. Tip: maak per competitie een eigen submap in plaats van alles direct in de archiefmap te zetten. |
| `a` | Nummer van team A. Alleen nodig als in het competitiebestand geen favoriete ploeg is ingesteld. |
| `b` | Nummer van de tegenstander. Niet nodig voor de volgende wedstrijd, alleen als een bepaalde ontmoeting moet worden getoond. |
| `mininext_template` | Te gebruiken template. Zonder opgave: standaardtemplate. |

---

## 2. Opnemen

Er zijn twee manieren. De eerste heeft de voorkeur; de tweede is alleen bedoeld voor servers zonder PHP-ondersteuning of `.html`-bestanden.

### Opnemen via include

Stel de parameters rechtstreeks in als PHP-variabelen, *binnen een PHP-blok* (open het zo nodig met `<?php`):

```php
$file="liga1.l98";
$folder="archiv/Eerste_Team";
```

Let op het `$` voor de naam, de aanhalingstekens rond tekenreeksen en de puntkomma aan het eind. Alleen de competitienaam is verplicht. Neem daarna de add-on op:

```php
include("PadNaarLMO/addon/mini/lmo-mininext.php");
```

`PadNaarLMO` is het absolute of relatieve pad naar de LMO-map.

> **Let op:** Gebruik nooit een URL, geen `include("http://www.../lmo-mininext.php");`! Geef altijd een **bestandspad** op.

> **Opmerking:** Gebruik je op je pagina geen sessies, voeg dan `<?php session_start(); ?>` toe als allereerste regel van het bestand.

### Opnemen via iframe

Alleen als de include-methode niet werkt. De parameters maken deel uit van de bron-URL:

```html
<iframe src="URLNaarLMO/addon/mini/lmo-mininext.php?file=liga1.l98&folder=archiv/Eerste_Team"
  style="border:0" width="breedte" height="hoogte" scrolling="no"></iframe>
```

`URLNaarLMO` is het webadres van je LMO. Met `breedte` en `hoogte` moet je experimenteren. De eerste parameter wordt met `?` gescheiden, volgende met `&`.

---

## 3. Templates

Net als bij de LMO kun je ook structuur en vormgeving van Mininext aanpassen. De templates staan in de submap `mini` van de map `template`. Standaard is `mininext.tpl.php` (te wijzigen in het add-onbeheer). Je kunt willekeurig veel templates (extensie `.tpl.php`) aanmaken.

### De komende wedstrijd

| Plaatshouder | Betekenis |
|---|---|
| `<!--gameTxt-->` | Kop |
| `<!--gameDate-->` | Datum van de komende wedstrijd |
| `<!--gameTime-->` | Tijd van de komende wedstrijd |
| `<!--countDown-->` | Aftelling tot de volgende wedstrijd |
| `<!--homeName-->` | Naam van het thuisteam |
| `<!--homeNameMiddle-->` | Middellange naam van het thuisteam |
| `<!--homeNameShort-->` | Korte naam van het thuisteam |
| `<!--homeTore-->` | Doelpunten van het thuisteam (sinds LMO 4.0.2) |
| `<!--imgHomeBig-->` | Groot icoon van het thuisteam |
| `<!--imgHomeSmall-->` | Klein icoon van het thuisteam |
| `<!--guestName-->` | Naam van het uitteam |
| `<!--guestNameMiddle-->` | Middellange naam van het uitteam |
| `<!--guestNameShort-->` | Korte naam van het uitteam |
| `<!--guestTore-->` | Doelpunten van het uitteam (sinds LMO 4.0.2) |
| `<!--imgGuestBig-->` | Groot icoon van het uitteam |
| `<!--imgGuestSmall-->` | Klein icoon van het uitteam |
| `<!--gameNote-->` | Wedstrijdnotitie |
| `<!--ligaDatum-->` | Datum van de laatste wijziging in de competitie |
| `<!--copy-->` | Copyrightvermelding, **mag niet worden gewijzigd of verwijderd!** |

### Eerdere ontmoetingen

**Buiten `<!-- BEGIN/END matches -->`:**

| Plaatshouder | Betekenis |
|---|---|
| `<!--matchesText-->` | Kop voor eerdere wedstrijden |
| `<!--winCount-->` / `<!--drawCount-->` / `<!--lostCount-->` | Aantal thuisoverwinningen / gelijke spelen / uitoverwinningen |
| `<!--winTxt-->` / `<!--drawTxt-->` / `<!--lostTxt-->` | Labels voor winst/gelijk/verlies (bijv. W, G, V) |
| `<!--winWidth-->` / `<!--drawWidth-->` / `<!--lostWidth-->` | Balkbreedte voor winst/gelijk/verlies |
| `<!-- BEGIN matches -->` | Begin van het herhaalblok. **Let op de spaties voor BEGIN en na matches!** |
| `<!-- END matches -->` | Einde van het herhaalblok. **Let op de spaties voor END en na matches!** |

**Alleen binnen `<!-- BEGIN/END matches -->`:**

| Plaatshouder | Betekenis |
|---|---|
| `<!--class-->` | Kleurmarkering van de wedstrijd |
| `<!--date-->` | Datum van de wedstrijd |
| `<!--time-->` | Tijd van de wedstrijd |
| `<!--hTore-->` | Thuisdoelpunten |
| `<!--gTore-->` | Uitdoelpunten |
| `<!--where-->` | Thuis- of uitwedstrijd |
| `<!--matchingName-->` | Bij actieve vage zoekopdracht: gevonden teamnaam |

### De vorige wedstrijd

| Plaatshouder | Betekenis |
|---|---|
| `<!--previous_gameTxt-->` | Kop |
| `<!--previous_gameDate-->` | Datum van de vorige wedstrijd |
| `<!--previous_gameTime-->` | Tijd van de vorige wedstrijd |
| `<!--previous_homeName-->` | Naam van het thuisteam |
| `<!--previous_homeNameMiddle-->` | Middellange naam van het thuisteam |
| `<!--previous_homeNameShort-->` | Korte naam van het thuisteam |
| `<!--previous_imgHomeBig-->` | Groot icoon van het thuisteam |
| `<!--previous_imgHomeSmall-->` | Klein icoon van het thuisteam |
| `<!--previous_guestName-->` | Naam van het uitteam |
| `<!--previous_guestNameMiddle-->` | Middellange naam van het uitteam |
| `<!--previous_guestNameShort-->` | Korte naam van het uitteam |
| `<!--previous_imgGuestBig-->` | Groot icoon van het uitteam |
| `<!--previous_imgGuestSmall-->` | Klein icoon van het uitteam |

Pas de HTML-code vrij aan, maar zorg voor correcte HTML/CSS.
