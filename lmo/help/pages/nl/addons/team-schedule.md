# Teamschema

1. [Systeemeisen](#1-systeemeisen)
2. [Configuratie](#2-configuratie)
3. [Opnemen](#3-opnemen)
4. [Download](#4-download)
5. [Versiegeschiedenis](#5-versiegeschiedenis)

![Weergave van het teamschema](./assets/media/teampl01.png)

De add-on maakt het mogelijk het speelschema van een gekozen team als PDF-document uit te voeren, rechtstreeks via de link „Speelschema's" in de LMO.

---

## 1. Systeemeisen

- Een werkende LMO 4
- Geïnstalleerde Classlib-add-on van Tim Schumacher (verkrijgbaar in het add-onarchief), inclusief de PDF-class van [Wayne Munro, R&OS Ltd](http://www.ros.co.nz/pdf) (in de Classlib opgenomen)

---

## 2. Configuratie

De Teamschema-add-on wordt via het add-onbeheer van de LMO geconfigureerd.

### Add-onbeheer

Klik in het add-onbeheer op het item **pdf**. De volgende parameters zijn beschikbaar:

| Parameter | Beschrijving |
|---|---|
| `linktarget` | Opent de PDF in een nieuw venster (bijv. `_blank`) |
| `show_adobe_link` | Verwijzing naar de PDF-lezer met afbeelding: **0** = uit / **1** = aan |
| `homepage` | Toont een tekst in de marge, bijv. je homepageadres |
| `anzeige` | Sortering op speeldag / datum: **0** / **1** |
| `format` | Uitvoerformaat A4 liggend / staand: **0** / **1** |
| `teamfett` | Gekozen team markeren: **0** = uit / **1** = aan |
| `teamnamen` | Teamnaam lang / kort / middel: **0** / **1** / **2** |
| `serie` | Heen-/terugronde op 1 pagina / 2 pagina's: **0** / **1** |

---

## 3. Opnemen

### In de LMO opnemen

> Stel de toegangsrechten (chmod) in:
> **Bestanden:** `666` voor alle `cfg.txt`-bestanden in de map `config` en de submappen

Open het bestand `lmo-showprogram.php` en voeg onder de laatste regel (`} ?>`) de volgende code in:

```php
<?
// Teamplan ADDON BEGIN
if (file_exists(PATH_TO_ADDONDIR.'/pdf/lmo-showprogram.inc.php'))
    include(PATH_TO_ADDONDIR.'/pdf/lmo-showprogram.inc.php');
// Teamplan ADDON END
?>
```

Na de installatie verschijnt onder het keuzevenster „Speelschema's" de nieuwe link **Speelschema als PDF-document**.

> **Opmerking:** De copyrightvermelding met versie-informatie mag **niet** worden gewijzigd of verwijderd!

---

## 4. Download

- [Teamschema](http://www.liga-manager-online.de/lmo-forum/viewtopic.php?t=5489)

---

## 5. Versiegeschiedenis

**1.0**

- Speelschema-uitvoer in PDF-formaat

**2.0**

- Sortering van de uitvoer
- Markering van het gekozen team
- Teamnaam en formaat te kiezen
- Aparte uitvoer voor heen- en terugronde
