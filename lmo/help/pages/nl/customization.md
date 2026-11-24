# De LMO aanpassen

1. [Teamiconen](#1-teamiconen)
2. [Eigen CSS](#2-eigen-css)
3. [Templates](#3-templates)
4. [De LMO in bestaande homepages opnemen](#4-de-lmo-in-bestaande-homepages-opnemen)

Naast de [designeditor](#options/3-de-designeditor) kun je de LMO aanpassen met teamiconen, je eigen CSS en een eenvoudig templatesysteem.

---

## 1. Teamiconen

Met kleine clubwapens geef je de LMO een mooier uiterlijk. De LMO vindt de bestanden automatisch:

- Kopieer de iconen naar `img/teams/small/`.
- De bestandsnaam moet overeenkomen met de teamnaam (ook punten of spaties). Alleen het teken `/` is niet toegestaan; laat het gewoon weg uit de bestandsnaam.
- Sommige add-ons tonen vergrote iconen. Zet die in `img/teams/big/`.
- Toegestane formaten zijn PNG, GIF en JPG.

> **Apache 2:** Verwijder alle speciale tekens uit de bestandsnamen; alleen letters en cijfers zijn toegestaan.

---

## 2. Eigen CSS

Zijn de instellingen van de designeditor niet genoeg, bewerk dan het bestand `template/style.css`. Het wordt automatisch geladen en overschrijft de designeditor. Bewerk het met een teksteditor en controleer het zo nodig met de [W3C CSS-validator](https://jigsaw.w3.org/css-validator/).

---

## 3. Templates

Een template is een HTML-bestand dat is aangevuld met HTML-commentaar van de vorm `<!--Naam-->`. De LMO vervangt elk commentaar door het bijbehorende deel van zijn uitvoer. Met de plaats van het commentaar bepaal je waar iets verschijnt. Laat je een commentaar weg, dan vervalt dat deel. Je kunt ook meerdere templates voor dezelfde LMO gebruiken.

De templates staan in de map `template/` (`lmo-standard-komplett.tpl.php` en `lmo-standard.tpl.php`). Voor add-ons zijn er verdere templates, bijv. in `template/mini/` en `template/viewer/`.

| Commentaar | Inhoud |
|---|---|
| `<!--Titel-->` | Titeltekst van de LMO |
| `<!--Stylesheet-->` | Het stylesheet |
| `<!--Newsticker-->` | De geïntegreerde nieuwsticker |
| `<!--Kalender-->` | Navigatielink naar de kalender |
| `<!--Ergebnisse-->` | Navigatielink naar de uitslagen |
| `<!--Tabelle-->` | Navigatielink naar de stand |
| `<!--Spielplan-->` | Navigatielink naar het speelschema |
| `<!--Kreuztabelle-->` | Navigatielink naar de kruistabel |
| `<!--Fieberkurve-->` | Navigatielink naar de vormcurve |
| `<!--Ligastatistik-->` | Navigatielink naar de competitiestatistieken |
| `<!--Spielerstatistik-->` | Navigatielink naar de spelersstatistieken |
| `<!--Tippspiel-->` | Navigatielink naar het voorspellingsspel |
| `<!--Info-->` | Navigatielink naar de infopagina, **niet verwijderen a.u.b.** |
| `<!--Hauptteil-->` | Hoofddeel van de LMO |
| `<!--Savehtml-->` | Links voor de afdrukversies onder uitslagen resp. stand |
| `<!--Sprachauswahl-->` | Taalkeuze |
| `<!--Ligenuebersicht-->` | Link naar het competitieoverzicht |
| `<!--LetzteAuswertung-->` | Datum van de laatste berekening van de gekozen competitie |
| `<!--Berechnungszeit-->` | Rekentijd |
| `<!--Infolink-->` | Copyrightvermelding, **mag niet worden verwijderd** (zie [Juridische informatie](#getting-started/7-juridische-informatie)) |

Zorg dat er correcte HTML ontstaat. Met de [W3C HTML-validator](https://validator.w3.org/) kun je dat controleren.

Afhankelijk van de manier van opnemen heb je een van twee templates nodig: een **volledig HTML-document** voor rechtstreekse aanroep, of een template met **alleen het HTML-deel** voor opname via `include`.

---

## 4. De LMO in bestaande homepages opnemen

Je kunt de LMO rechtstreeks aanroepen of via `include` in je pagina's opnemen.

### Rechtstreekse aanroep

Roep de LMO aan via `lmo.php`. Welk template wordt gebruikt, staat in dit bestand. Standaard is dat `lmo-standard-komplett.tpl.php`, een volledig HTML-document.

De rechtstreekse aanroep is ook geschikt voor een **iframe**:

```html
<iframe src="URL-naar-LMO/lmo.php" width="breedte" height="hoogte" style="border:0"></iframe>
```

Met breedte en hoogte moet je helaas experimenteren; dat is een van de nadelen van iframes.

Met parameters in de URL start je direct in een bepaalde weergave, bijv. `lmo.php?file=liga.l98` om met een competitie te starten.

Voor een tweede template kopieer je `lmo.php`, hernoem je het (bijv. `lmoneu.php`) en wijzig je daarin de template-aanroep. De „nieuwe" LMO bereik je dan via `lmoneu.php`.

### Include

Handiger is opname via `include` in een bestaande PHP-pagina:

```php
<?php include("PadNaarLMO/lmo.php"); ?>
```

Let daarbij op het volgende:

- **`PadNaarLMO` is een bestandspad, geen URL.** `include("http://www.mijnsite.nl/lmo/lmo.php");` werkt niet.
- Een competitie die direct opent in plaats van het competitieoverzicht geef je **vóór** de include op: `$file = "NaamVanCompetitie.l98";`
- Standaard wordt `lmo-standard.tpl.php` (zonder „komplett") geladen. Het is geen volledig HTML-document; de overige delen komen uit je pagina.
- Helemaal bovenaan je pagina (de allereerste regel) moet staan:

  ```php
  <?php if (session_id() == "") session_start(); ?>
  ```

- Gebruikt je pagina nog geen `<!DOCTYPE html>`, voeg die dan toe. Geef in de `<head>` ook de tekenset op: `<meta charset="utf-8">`
- Neem in de `<head>` het LMO-stylesheet op:

  ```html
  <link rel="stylesheet" href="PadNaarLMO/lmo-style-nc.php">
  <style>@import url('PadNaarLMO/lmo-style.php');</style>
  ```

Met dezelfde methode kun je meerdere templates gebruiken.
