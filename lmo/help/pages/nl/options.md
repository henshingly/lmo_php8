# Opties

1. [Globale opties](#1-globale-opties)
2. [Add-onbeheer](#2-add-onbeheer)
3. [De designeditor](#3-de-designeditor)
4. [Gebruikersbeheer](#4-gebruikersbeheer)
5. [Competitiearchief](#5-competitiearchief)

---

## 1. Globale opties

Via de menuopdracht **Opties** kom je in het optiesgedeelte. Hier stel je de globale scriptinstellingen in. Hulpbeheerders hebben hier geen toegang.

**Basisinstellingen:** standaardtaal, competitiemap, standaard aanvangstijd, formaat van de aanvangsdata, e-mailadres van de webmaster, e-mailverzending (PHP `mail()` of SMTP) en de volgorde van de competitiesortering in de competitiekeuze.

**Tabelopties:** positie van de puntenkolom en soort tabelweergave.

**Weergave/Uiterlijk:** hier bepaal je welke onderdelen van de LMO worden getoond.

### E-mailverzending (SMTP)

Alle e-mails van de LMO (competities per e-mail versturen; in het voorspellingsspel aanmelding, activering, wachtwoordmails, nieuwsbrieven en herinneringen) gebruiken de instellingen in het gedeelte **E-mailverzending**. Je vindt het in de basisinstellingen direct onder het e-mailadres van de webmaster. Alleen de volledige beheerder ziet en wijzigt deze instellingen.

| Instelling | Betekenis |
|---|---|
| Verzendmethode | **PHP mail()** is de standaard en werkt als je server zelf mail mag versturen. Komt mail niet aan of belandt hij in de spam, kies dan **SMTP-server**. Mislukt SMTP, dan probeert de LMO de mail als terugval nog eens met `mail()` te versturen. |
| Server, poort, versleuteling | De gegevens krijg je van je mailprovider. Gebruikelijk zijn STARTTLS met poort 587 of SSL/TLS met poort 465. Kies *geen (onversleuteld)* alleen in uitzonderlijke gevallen. |
| Gebruikersnaam, wachtwoord | Inloggegevens van de mailbox, meestal het e-mailadres. Het wachtwoord wordt na het opslaan nooit meer getoond. Laat het veld leeg om het ongewijzigd te laten, of wis het met het vinkje. Gebruik bij voorkeur een aparte mailbox alleen voor verzending. |
| Afzenderadres | Optioneel. Is het veld leeg, dan wordt het e-mailadres van de webmaster gebruikt. Veel aanbieders staan alleen afzenders toe die bij het SMTP-account passen. |
| Testmail versturen | Verstuurt met de actueel ingevoerde (ook niet-opgeslagen) waarden een testmail naar het e-mailadres van de webmaster, dat daarvoor opgeslagen moet zijn. De testmail gaat alleen via SMTP, zonder terugval op `mail()`, zodat fouten zichtbaar worden. Het resultaat verschijnt naast de knop. |

**Waar wordt het wachtwoord opgeslagen?** Versleuteld in `config/smtp/cfg.php`, de sleutel staat in `config/smtp/key.php`. Beide bestanden zijn met een beveiligingsregel tegen directe aanroep beschermd. Let op: de sleutel staat op dezelfde server. De versleuteling beschermt ertegen dat het configuratiebestand per ongeluk leesbaar wordt (bijv. in een back-up), maar niet tegen iemand met toegang tot de hele servermap. Open het beheergedeelte bij voorkeur alleen via HTTPS. Bij een HTTP-verbinding toont de LMO een waarschuwing.

---

## 2. Add-onbeheer

Het add-onbeheer stuurt de add-ons aan die de LMO met extra functies uitbreiden. Het is bedoeld voor ervaren gebruikers. Wijzig hier alleen waarden als de betreffende add-on geen eigen configuratie-interface heeft.

Kies in het keuzemenu de add-on en wijzig de configuratievariabelen rechtstreeks. **De invoer wordt niet gecontroleerd**; verkeerde waarden kunnen de LMO in het ergste geval onbruikbaar maken.

---

## 3. De designeditor

Met de designeditor pas je kleuren en lettertypen aan je homepage aan. Je vindt hem onder **Opties → Designeditor**. Hij is alleen beschikbaar voor de volledige beheerder. Links stel je de waarden in, rechts zie je meteen hoe een van je competities er dan uitziet. Pas na een klik op **Wijzigingen opslaan** wordt iets overgenomen.

### Opbouw van de editor

De instellingen zijn in tabbladen ingedeeld. Alle tabbladen horen bij **één** formulier: je invoer blijft behouden als je tussen tabbladen wisselt, en één klik op *Wijzigingen opslaan* bewaart alles.

| Tabblad | Inhoud |
|---|---|
| Buitenste kader | Paginaachtergrond, basislettertype, kop, hoofd- en submenu van het buitenste gedeelte |
| Middelste kader | Gedeelte rond elke weergave met eigen kop plus hoofd- en submenu |
| Binnenste kader | Tabellen: gewone cellen, accenten (bijv. tabelkoppen) en links |
| Tabel | Kleuren van de tabelposities (kampioen, Champions League, Europa League, nacompetitie, degradant) en thuis-/uittabel |
| Toernooigedeelte | Kleuren voor winnaars en verliezers in toernooischema's (knock-outrondes) |
| Overige opties | Kruistabel, kalender, weekenden, vormcurves, lettergroottes, onderstrepen van links |
| Formulieren | Invoervelden en knoppen |

### Het livevoorbeeld

Rechts zie je een echte competitie van je installatie (er moet minstens één competitie bestaan). Elke wijziging wordt meteen getoond, ook zonder opslaan. Met de keuzevelden erboven kies je

- de **competitie** waarmee je test,
- de **weergave** (tabel, uitslagen, speelschema's, kruistabel, kalender) en
- de **breedte** (desktop, tablet, smartphone). De LMO-opmaak past zich niet automatisch aan de schermbreedte aan, dus het smalle voorbeeld kan zijwaarts scrollen.

**Aanklikken in plaats van zoeken:** beweeg je de muis in het voorbeeld over een gedeelte, dan krijgt het een oranje rand en zijn naam (bijv. „Middelste kader: Hoofdmenu"). Een klik opent het juiste tabblad en markeert het veld. Links in het voorbeeld worden niet uitgevoerd.

### Kleuren en lettertypen instellen

Elke kleur stel je op twee manieren in: door een hexcode (`#1b6b2f`, kort `#0a0`) of een Engelse kleurnaam (`red`) in te typen, of door op het kleurvak te klikken, dat de kleurkiezer van je browser opent.

Bij veel velden horen twee kleuren bij elkaar: eerst de achtergrond-, dan de letterkleur. Een leeg veld stelt geen kleur in en de browser gebruikt zijn standaard. Verder zijn er randwaarden (bijv. `1px solid #000000`), het lettertype (bijv. `Verdana, sans-serif`) en de lettergrootte (bijv. `13px` of `94%`).

> **Contrastwaarschuwing:** Lijken achtergrond- en letterkleur te veel op elkaar, dan markeert de editor de regel en het tabblad met een waarschuwingsteken ⚠. Een contrast van minstens 4,5 op 1 wordt aanbevolen. De waarschuwing is slechts een hint; je kunt gewoon opslaan.

**Invoercontrole:** Bij het opslaan worden alle waarden gecontroleerd. Ongeldige waarden worden genegeerd en de vorige waarde blijft behouden. Zo kunnen typefouten het stylesheet niet beschadigen.

### Kleurenschema's

Boven het formulier kies je een **kleurenschema** (Standaard, Grasgroen, Rood, Hemelsblauw, Oranje, Antraciet, Paars, Turkoois, Bordeaux). Eén klik zet kaders, menu's, kruistabel en formulieren in één keer om naar de gekozen hoofdkleur.

- **Donker:** gebruikt de donkere variant van het schema.
- **Eigen kleur:** opent een palet met 108 kleuren. Daar kies je een kleur, gebruik je de kleurkiezer van de browser voor elke willekeurige kleur, of typ je een hexcode (bevestigen met Enter).
- **Standaard** herstelt de oorspronkelijke LMO-kleuren.

Een schema wijzigt bewust niet de kleuren van de tabel (kampioen, promotie/degradatie) en het toernooigedeelte, omdat die een vaste betekenis hebben. Daarna kun je elke kleur handmatig bijwerken. Ook een schema geldt pas na *Wijzigingen opslaan*.

### Opgeslagen designs

Onder het formulier beheer je eigen designs op de server, bijv. een zomer- en een winterdesign.

- **Opslaan als …** bewaart de actuele waarden onder een naam naar keuze (letters, cijfers, spaties, `-` en `_`). Bestaat de naam al, dan word je gevraagd voor het overschrijven.
- **Laden** neemt het gekozen design over in het formulier en het voorbeeld. Voor bezoekers zichtbaar wordt het pas na *Wijzigingen opslaan*.
- **Verwijderen** verwijdert het gekozen design.

De designs staan als tekstbestanden in `config/design/`. De map `config` moet daarvoor beschrijfbaar zijn; de submap wordt zo nodig automatisch aangemaakt.

### Exporteren en importeren

**Exporteren** downloadt het actuele design (ook met niet-opgeslagen wijzigingen) als bestand `lmo-design-JJJJMMDD.json`, **Importeren** laadt zo'n bestand in het formulier. Zo bewaar je een design, draag je het over naar een andere installatie of deel je het met andere LMO-beheerders. Bij het importeren worden alleen bekende velden met geldige waarden overgenomen.

Er zijn ook twee hulpfuncties: **Standaardwaarden** zet alle velden terug op de oorspronkelijke waarden (na bevestiging), **Wijzigingen verwerpen** maakt alles sinds het laatste opslaan ongedaan.

### Eigen aanvullingen met style.css

Is de designeditor niet genoeg, bewerk dan het bestand `template/style.css`. De CSS-regels daarin worden automatisch geladen, overschrijven de instellingen van de designeditor en zijn ook in het livevoorbeeld zichtbaar. Alle instellingen van de editor staan in `config/cfg.txt` (variabelen `lmo_…`) en worden bij het aanroepen van de LMO in een stylesheet omgezet.

---

## 4. Gebruikersbeheer

Het gebruikersbeheer bereik je via **Opties → Gebruikersbeheer**. Eerst zie je alle ingestelde beheerders en hulpbeheerders. Om er een te wijzigen kies je het account, wijzig je de gegevens en klik je op **Opslaan**. **Verwijderen** verwijdert een account onherroepelijk.

Bij hulpbeheerders stel je bovendien onder **Vrijgegeven competities** in tot welke competities ze toegang hebben.

Een nieuw account maak je aan in het gedeelte **Nieuwe beheerder toevoegen**. De velden zijn voorgevuld en het wachtwoord is een willekeurig wachtwoord dat je kunt overnemen. Wijs de nieuwe beheerder daarna zijn rechten toe.

### Hulpbeheerders

Hulpbeheerders voeren uitslagen in, maar hebben geen toegang tot de gevoelige competitie-instellingen of de globale opties. Handig als helpers de actuele uitslagen voor je invoeren.

### Uitgebreide hulpbeheerders

Zijn de rechten van een hulpbeheerder niet genoeg, dan kun je ze uitbreiden. Een uitgebreide hulpbeheerder is een volwaardige beheerder, maar alleen voor zijn competities:

- Hij kan de aan hem toegewezen competities volledig beheren.
- Hij heeft geen toegang tot de globale opties.

---

## 5. Competitiearchief

Verlopen competities kun je in het geïntegreerde archief bewaren, zonder dat de competitiekeuze te lang wordt. Maak in de map `ligen/` een submap met een duidelijke naam aan (bijv. `Bundesliga`) en verplaats de competities erheen. Mappen kunnen willekeurig diep worden genest.

Is de bijbehorende instelling in de globale opties actief, dan zien je bezoekers het archief met een link voor elke submap. Voor een beschrijving maak je in een map het tekstbestand `dir-descr.txt` aan (bijv. „Alle Bundesliga-seizoenen van 1963 tot 2000"). Na een klik op de maplink kiezen bezoekers de competities zoals gewoonlijk. Gearchiveerde competities kun je in het beheergedeelte nog steeds bewerken.
