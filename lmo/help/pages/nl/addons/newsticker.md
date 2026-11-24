# Nieuwsticker

1. [Besturingsparameters](#1-besturingsparameters)
2. [Opnemen](#2-opnemen)

![Gebruikersweergave](./assets/media/ticker01.png)

In de LMO zit een flexibele nieuwsticker die uitslagen en notities als ruimtebesparende lopende tekst toont. In de [uitslageneditor](#edit-league/3-de-uitslageneditor) kun je de ticker voor elke competitie apart in- of uitschakelen. Hij verschijnt dan in het gebruikersgedeelte boven de betreffende competitie. Je kunt hem ook overal op je homepage opnemen en zelfs zo instellen dat meerdere competities in één ticker worden samengevoegd.

---

## 1. Besturingsparameters

Met deze parameters stuur je het gedrag van de ticker. In het [add-onbeheer](#options/2-add-onbeheer) kun je de standaardwaarden wijzigen; ze gelden voor de tickers boven de competities en voor elke ticker die geen eigen besturingsparameters meekrijgt.

| Parameter | Waarde | Betekenis |
|---|---|---|
| `standard_ligen` | bestandsna(a)m(en) | Bestandsnamen met de extensie `.l98`; meerdere competities scheiden met komma's |
| `tickerart` | `1` | Uitslagenticker |
| | `2` | Tickertekst van de LMO |
| | `3` | Uitslagenticker, alleen favoriete team |
| `tickertitel` | `0` | Tickerkop verbergen |
| | `1` | Tickerkop tonen |
| `notizanzeigen` | `0` | Wedstrijdnotities verbergen |
| | `1` | Wedstrijdnotities tonen |
| `breite` | getal | Breedte van de ticker (in aantal letters) |
| `geschwindigkeit` | getal | Scrollsnelheid van de ticker |

---

## 2. Opnemen

Er zijn twee manieren om de nieuwsticker op te nemen. De eerste heeft de voorkeur; de tweede is alleen bedoeld voor servers zonder PHP-ondersteuning (als de LMO op een externe server draait) of als je een `.html`-bestand gebruikt (dat meestal niet door PHP wordt verwerkt).

### Opnemen via include

De parameters worden rechtstreeks als PHP-variabelen ingesteld. Schrijf ze achter elkaar *binnen een PHP-blok* (open het zo nodig met `<?php`):

```php
$tickerart="1";
$tickerligen="liga1.l98,liga2.l98";
```

Let op het `$` voor de parameternaam, de aanhalingstekens rond tekenreeksen en de afsluitende puntkomma. Je hoeft alleen de parameters op te geven die van de standaardinstellingen afwijken. Neem daarna de ticker op:

```php
include("PadNaarLMO/addon/ticker/ticker.php");
```

`PadNaarLMO` is het absolute of relatieve pad naar de LMO-map.

> **Let op:** Gebruik nooit een URL, dus geen `include("http://www.../ticker.php");`, want dat werkt niet! Geef altijd een **bestandspad** op.

### Opnemen via iframe

Gebruik deze methode alleen als de include-variant om welke reden dan ook niet werkt. Iframes worden niet door alle browsers ondersteund en hebben ook ergonomische nadelen. Hier maken de parameters deel uit van de bron-URL:

```html
<iframe src="URLNaarLMO/addon/ticker/ticker.php?tickerart=1&tickerligen=liga1.l98,liga2.l98"
  style="border:0" width="breedte" height="hoogte" scrolling="no"></iframe>
```

`URLNaarLMO` is het webadres van je LMO. Met `breedte` en `hoogte` moet je helaas een beetje experimenteren. De eerste parameter wordt met `?` gescheiden, alle volgende met `&`.
