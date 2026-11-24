# TopTipper

1. [Systeemeisen](#1-systeemeisen)
2. [Bestanden uitgelegd](#2-bestanden-uitgelegd)
3. [Download](#3-download)

![Weergave van TopTipper](./assets/media/toptipper.png)

De TopTipper-add-on toont de actuele stand van het voorspellingsspel compact en overzichtelijk.

---

## 1. Systeemeisen

- Een werkende LMO 4 vanaf Beta 3 met geactiveerd voorspellingsspel

---

## 2. Bestanden uitgelegd

De download bevat 4 bestanden.

**`toptipper.php`**
Staat in de map `addon/tipp/`.

**`kal.tip`**
Staat in de map `config/tipp/`. Dit is het configuratiebestand. Je kunt het hernoemen zolang de extensie `*.tip` behouden blijft en met de nieuwe naam rekening wordt gehouden bij het opnemen.

Inhoud van het bestand:

```
[config]
modus=1              // modus op 1 laten, kan nog van pas komen
anzahl_tipper=10     // aantal voorspellers in de weergave
all=0                // 0 of 1: 0 toont het bestand, 1 totaal
file=erg_dfb.l98     // jouw competitie
template=standard    // templatenaam zonder de extensie *.tpl.php
```

**`standard.tpl.php`**
Staat in de map `template/tipp/`. Je kunt het template vrij vormgeven. Beschikbare plaatshouders:

| Plaatshouder | Betekenis |
|---|---|
| `<!--Link-->` | Link naar het voorspellingsspel |
| `<!--Lmo-->` | Link naar de LMO |
| `<!--Platz-->` | Plaats van de voorspellers |
| `<!--Name-->` | Naam van de voorspellers |
| `<!--Punkte-->` | Punten van de voorspellers |

**`tipp.php`**
Staat direct in de hoofdmap van je LMO. Het dient om het script op te nemen; pas de inhoud dienovereenkomstig aan.

Voorbeeld:

```php
<?php
$multi="kal";  // Je aangepaste bestand kal.tip wordt opgenomen.
require(dirname(__FILE__) . '/init.php');
include(PATH_TO_ADDONDIR . "/tipp/toptipper.php");
?>
```

---

## 3. Download

- [TopTipper](https://www.liga-manager-online.org/forum/viewtopic.php?t=94)

> Bij elke versie hoort een uitgebreide installatiehandleiding.
