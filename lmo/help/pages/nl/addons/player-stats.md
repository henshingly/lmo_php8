# Spelersstatistieken

1. [Configuratie](#1-configuratie)

![Gebruikersweergave](./assets/media/spielerstatistik01.png)

Met deze add-on kun je spelersstatistieken voor de Liga Manager Online vastleggen en publiceren. De flexibele configuratie maakt hem bruikbaar voor veel verschillende sporten.

Je kunt drie soorten kolommen aanmaken: **tekst**, **getallen** en **formules**. De volgorde van de kolommen kan helaas achteraf niet meer worden gewijzigd, dus denk goed na voordat je begint. Na het aanmaken van de spelers verschijnt de opstelling eronder, waar je voor elke speler de passende waarden invoert. In formulekolommen kun je met de getalkolommen rekenen (bijv. gemiddeld aantal doelpunten).

**Spelersfoto's opnemen**
Foto's horen in de map `img/spieler/small/`, genoemd naar de betreffende speler. Let op een verstandige bestandsgrootte.

**Spelerslinks opnemen**
Om spelers te koppelen maak je in het beheergedeelte een kolom **„Spielerlink"** (of het equivalent uit `lang/lmo-[taal].txt`) aan. Voor elke speler kan een link worden opgeslagen; ontbreekt die, dan wordt er niet gekoppeld.

**Kolomafbeeldingen opnemen**
In plaats van tekstkoppen kun je ook iconen voor kolommen gebruiken. Sla daarvoor een **GIF**-afbeelding met de kolomnaam op in de map `img/spieler/`. Voorbeelden zijn al aanwezig.

**Statistieken van meerdere clubs met wapens**
Gebruik je **„Verein"** (of het equivalent uit `lmo-[taal].txt`) als kolomkop, dan wordt clubondersteuning geactiveerd: keuzelijst, clubwapens (indien aanwezig) en links naar clubhomepages.

---

## 1. Configuratie

### Bezoekersweergave

| Instelling | Betekenis |
|---|---|
| Weergave per pagina | Aantal getoonde vermeldingen; `0` = geen beperking |
| Voorsortering | Kolom waarop eerst wordt gesorteerd |
| Sortering | Volgorde van de voorsortering |
| Extra sorteerkolom | Toont een aparte sorteerkolom; anders gebeurt het sorteren via de tabelkoppen |
| Per club tonen | Activeert de verdeling per club |
| Nulwaarden tonen | Toont ook lege velden; tekenreeksen worden altijd getoond |

### Beheerweergave

| Instelling | Betekenis |
|---|---|
| Voorsortering beheerder | Kolom waarop eerst wordt gesorteerd |
| Hulpbeheerder | Geeft hulpbeheerders toegang tot de spelersstatistieken |
| Hulpbeheerder (kolommen) | Geeft hulpbeheerders ook toegang tot het kolombeheer |
