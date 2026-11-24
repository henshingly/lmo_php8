# Minitabellen

1. [Besturingsparameters](#1-besturingsparameters)
2. [Opnemen](#2-opnemen)
3. [Templates](#3-templates)

![Gebruikersweergave](./assets/media/minitabs01.png)

De LMO maakt het mogelijk standen of delen van standen op externe pagina's te tonen. Zo kun je bijvoorbeeld op je startpagina een compacte versie van de actuele stand opnemen. Welke details worden getoond en hoe de stand eruitziet, kun je via [templates](#3-templates) vrij vormgeven.

---

## 1. Besturingsparameters

Net als bij de ticker zijn er bij de minitabellen verschillende besturingsparameters.

| Parameter | Betekenis |
|---|---|
| `mini_liga` | Bestandsnaam van de competitie (met de extensie `.l98`) |
| `mini_platz` | Rond welke plaats moet het uitsnede worden gecentreerd? Leeg laten voor de favoriete ploeg. |
| `mini_ueber` | Hoeveel teams boven het gekozen team tonen? |
| `mini_unter` | Hoeveel teams onder het gekozen team tonen? |
| `mini_template` | Naam van het template (zonder bestandsextensie). Zonder opgave wordt `standard` gebruikt. |

---

## 2. Opnemen

Er zijn twee manieren om minitabellen op te nemen. De eerste heeft de voorkeur; de tweede is alleen bedoeld voor servers zonder PHP-ondersteuning of `.html`-bestanden.

### Opnemen via include

De parameters worden rechtstreeks als PHP-variabelen ingesteld, *binnen een PHP-blok* (open het zo nodig met `<?php`):

```php
$mini_liga="liga1.l98";
$mini_ueber=3;          // 3 teams boven het favoriete team
$mini_unter=2;          // 2 teams onder het favoriete team
$mini_template="all";   // template "all.tpl.php" gebruiken
```

Let op het `$` voor de parameternaam, de aanhalingstekens rond tekenreeksen en de afsluitende puntkomma. Alleen de competitienaam is verplicht. Neem daarna de minitabel op:

```php
include("PadNaarLMO/addon/mini/lmo-minitab.php");
```

`PadNaarLMO` is het absolute of relatieve pad naar de LMO-map.

> **Let op:** Gebruik nooit een URL, geen `include("http://www.../minitab.php");`, want dat werkt niet! Geef altijd een **bestandspad** op.

### Opnemen via iframe

Alleen als de include-methode niet werkt. Iframes hebben nadelen (browsercompatibiliteit, ergonomie). De parameters maken deel uit van de bron-URL:

```html
<iframe src="URLNaarLMO/addon/mini/lmo-minitab.php?mini_liga=liga1.l98&mini_ueber=3&mini_unter=2&mini_template=all"
  style="border:0" width="breedte" height="hoogte" scrolling="no"></iframe>
```

`URLNaarLMO` is het webadres van je LMO. Met `breedte` en `hoogte` moet je experimenteren. De eerste parameter wordt met `?` gescheiden, volgende met `&`.

---

## 3. Templates

Net als bij de LMO zelf kun je de structuur en vormgeving van de minitabellen vrij aanpassen. De templates staan in de submap `mini` van de map `template`. Zonder besturingsparameters wordt `standard.tpl.php` gebruikt. Je kunt willekeurig veel templates (extensie `.tpl.php`) aanmaken.

De volgende plaatshouders zijn beschikbaar:

| Plaatshouder | Betekenis |
|---|---|
| `<!--Link-->` | Link naar de volledige stand in de LMO |
| `<!-- BEGIN Inhalt -->` | Begin van het blok dat voor elk team wordt herhaald. **Let op de spaties voor BEGIN en na Inhalt!** |
| `<!-- END Inhalt -->` | Einde van het herhaalblok. **Let op de spaties voor END en na Inhalt!** |
| `<!--Style-->` | Activeert de markering van kampioen, degradanten enz. volgens de competitie-instelling |
| `<!--Team-->` | Korte naam van het team |
| `<!--TeamLang-->` | Volledige naam van het team |
| `<!--TeamMittel-->` | Middellange naam van het team |
| `<!--TeamBild-->` | Teamicoon (indien aanwezig) |
| `<!--Teamnotiz-->` | Notitie van het team |
| `<!--Spiele-->` | Aantal wedstrijden |
| `<!--Punkte-->` | Punten; bij minpunten in de vorm **+P:-P** |
| `<!--PlusTore-->` | Gescoorde doelpunten |
| `<!--MinusTore-->` | Tegendoelpunten |
| `<!--Tordifferenz-->` | Doelsaldo |
| `<!--Siege-->` | Aantal overwinningen |
| `<!--Unentschieden-->` | Aantal gelijke spelen |
| `<!--Niederlagen-->` | Aantal nederlagen |

Pas de HTML-code naar believen aan, maar zorg voor correcte HTML/CSS. In het template `all.tpl.php` vind je alle plaatshouders als voorbeeld.
