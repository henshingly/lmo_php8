# Voorspellingsspel (Tippspiel)

1. [Berekening](#1-berekening)
2. [Nieuwsbrief/Herinnering](#2-nieuwsbrief-herinnering)
3. [Gebruikersbeheer](#3-gebruikersbeheer)
4. [Voorspellingen achteraf invoeren](#4-voorspellingen-achteraf-invoeren)
5. [Back-upbeheer](#5-back-upbeheer)
6. [Opties](#6-opties)

![Overzicht van voorspellingen](./assets/media/tippspiel01.png)

In de LMO 4 zit een uitgebreid en flexibel voorspellingsspel, gebaseerd op de voorspellingsspel-add-on voor LMO 3 van Frank Albrecht.

---

## 1. Berekening

Hier laat je de te voorspellen competities berekenen, d.w.z. elke voorspeller krijgt de behaalde punten bijgeschreven. Je kunt elke competitie en elke speeldag afzonderlijk berekenen, of alle speeldagen van een competitie in één keer.

Worden meerdere competities voorspeld, dan kun je hier ook het **algemeen klassement** bijwerken.

Hier maak en ververs je ook de **voorspellingsoverzichten**, waarmee je medespelers kunnen zien hoe de anderen hebben voorspeld. Afhankelijk van de [instelling in de opties](#6-opties) wordt het overzicht pas vrijgegeven nadat de speeldag is afgelopen.

---

## 2. Nieuwsbrief/Herinnering

Hier kun je je voorspellers verschillende berichten sturen: een **nieuwsbrief aan iedereen**, **persoonlijke mails** aan afzonderlijke spelers of een **herinnering** die eraan herinnert voorspellingen in te vullen.

Alle mails van het voorspellingsspel (ook aanmeldingsbevestiging, activering en wachtwoordmail) worden verstuurd met de verzendmethode die je in de [globale opties](#options/e-mailverzending-smtp) hebt ingesteld (PHP `mail()` of SMTP). Komen mails niet aan, stel daar dan een SMTP-server in en controleer hem met de testmail.

Bij het versturen van mail zijn de volgende plaatshouders beschikbaar:

| Plaatshouder | Betekenis |
|---|---|
| `[nick]` | Bijnaam van de voorspeller |
| `[pass]` | Link om het wachtwoord opnieuw in te stellen. Wachtwoorden worden alleen als hash opgeslagen en kunnen niet in leesbare tekst worden verstuurd. Via de link stelt de voorspeller een nieuw wachtwoord in. |
| `[name]` | Echte naam van de voorspeller |
| `[spiele]` | Alleen in de herinnering: toont alle openstaande wedstrijden in de opgegeven periode |

---

## 3. Gebruikersbeheer

Hier beheer je de deelnemers van het voorspellingsspel: je kunt **nieuwe voorspellers aanmaken**, **voorspellers bewerken** en **voorspellers verwijderen**. Per voorspeller kunnen de volgende gegevens worden gewijzigd:

**Persoonlijke gegevens**
Wachtwoord, naam, adres, e-mail; geblokkeerd/geactiveerd.

**Mailabonnementen**
Moet de voorspeller de nieuwsbrief of de herinnering ontvangen?

**Team**
In welk team speelt de voorspeller? (alleen bij ingeschakelde teamoptie)

**Geabonneerde competities**
Welke competities kan de voorspeller voorspellen?

---

## 4. Voorspellingen achteraf invoeren

Alleen de **volledige beheerder** kan voor een voorspeller voorspellingen ook na het begin of einde van een wedstrijd invoeren of wijzigen, bijvoorbeeld als iemand zijn voorspellingen niet op tijd kon invullen.

1. Kies in het beheer van het voorspellingsspel **Voorspellingen achteraf invoeren**.
2. Kies de competitie. Alle voorspellers die een voorspellingsbestand voor deze competitie hebben, worden getoond.
3. Klik bij de gewenste voorspeller op **Voorspellingen bewerken**. De normale invoer van de voorspeller opent, een rode melding toont de beheerdersmodus.
4. Kies de speeldag, voer de voorspellingen in en sla op.
5. Voer daarna de [berekening](#1-berekening) opnieuw uit.

Dit werkt voor alle competitietypen (competitie, toernooi/KO) en alle voorspelmodi (uitslag, tendens, ook met joker). De tijdsblokkade is alleen voor de beheerder in deze modus opgeheven; voorspellers zelf kunnen nog steeds alleen binnen de voorspeltermijn voorspellen.

**Logboek:** Elke latere invoer wordt vastgelegd in `config/tipp/nachtrag.php` (datum, beheerder, voorspeller, competitie, speeldag). Je ziet de vermeldingen ook rechtstreeks in het beheermenu van het voorspellingsspel onder *Voorspellingen achteraf invoeren*.

---

## 5. Back-upbeheer

Alleen de **volledige beheerder** kan back-ups van het voorspellingsspel maken en herstellen. Een back-up bevat de **voorspellingenmap** (voorspellingen, beoordelingen, voorspellingsoverzichten, clubranglijst), het **bestand met de gegevens van de voorspellers** (`addon/tipp/lmo-tipperauth.php`) en de **puntenregels** (`config/tipp/cfg.txt`) als ZIP-bestand. Welke map de voorspellingenmap is, staat in de opties onder *Paden* (standaard `addon/tipp/tipps/`). Het back-upbeheer gebruikt altijd die instelling.

**Back-up maken**

1. Kies in het beheer van het voorspellingsspel **Back-upbeheer**.
2. Klik op **Back-up maken**. De back-up verschijnt direct in de lijst met datum, type, aantal bestanden en grootte.
3. Met **Downloaden** sla je het ZIP-bestand op je computer op, met **Verwijderen** verwijder je het van de server.

De back-ups staan in de beveiligde map `config/tipp/backup/` en kunnen alleen via het back-upbeheer worden gedownload. Het ZIP-bestand bevat `tippordner/`, `tipperdatei/`, `punkteregeln/`, een `info.txt` en een `manifest.json` met controlesommen.

**Automatische back-up**

Onder *Instellingen* kun je instellen dat vóór elke berekening in het beheer automatisch een back-up (type *Automatisch*) wordt gemaakt, en hoeveel automatische back-ups worden bewaard (0 = alles). Oudere automatische back-ups worden dan verwijderd, handmatige nooit. De automatische berekening bij het invoeren van uitslagen start geen back-up.

**Back-up herstellen**

1. Klik in de lijst bij de gewenste back-up op **Herstellen**. De back-up wordt volledig gecontroleerd (opbouw, bestandsnamen, controlesommen).
2. Kies wat en hoe je wilt herstellen (voorspellingenmap, voorspellersbestand, puntenregels):
   - **Aanvullen en overschrijven (aanbevolen):** bestanden die niet in de back-up staan, blijven behouden.
   - **Exact als in de back-up:** voorspellings-, beoordelings-, inzage- en clubbestanden die niet in de back-up staan, worden verwijderd.
3. Het voorbeeld toont hoeveel bestanden nieuw, overschreven, ongewijzigd of verwijderd zijn.
4. Typ ter bevestiging het woord **HERSTELLEN** en klik op **Herstellen**.

Vóór het overschrijven maakt het back-upbeheer automatisch een back-up van de huidige toestand (type *Vóór herstel*). Lukt dat niet, of is de back-up beschadigd, dan wordt niets gewijzigd. Zo kun je een herstel ook ongedaan maken. Bestanden worden eerst geschreven en gecontroleerd en daarna verwisseld.

**Back-up uploaden:** op een nieuwe server kun je een gedownload ZIP-bestand weer uploaden. Het wordt volledig gecontroleerd voordat het wordt overgenomen; andere bestanden worden geweigerd.

Alle acties (maken, downloaden, verwijderen, uploaden, herstellen) staan in het **logboek** onderaan de pagina. Onder *Instellingen* stel je in na hoeveel dagen logboekregels automatisch worden verwijderd (0 = nooit). Met **Logboek wissen** verwijder je het hele logboek.

**Belangrijk:** het voorspellersbestand bevat toegangsgegevens en e-mailadressen. Behandel gedownloade back-ups vertrouwelijk. PHP heeft de extensie **Zip** en schrijfrechten voor `config/tipp/` en de voorspellingenmap nodig. Ontbreekt iets, dan meldt het back-upbeheer dat. Bij Nginx werkt de `.htaccess` in de back-upmap niet, blokkeer `config/` daar in de serverconfiguratie.

---

## 6. Opties

Dit is het uitgebreidste en belangrijkste gedeelte van het voorspellingsspel. Stel de opties bij voorkeur één keer volledig in vóór de start en wijzig ze tijdens het lopende spel niet meer ingrijpend.

**Voorspelmodus**
Kies of een exacte uitslag of alleen de tendens (winst/gelijk/verlies) wordt voorspeld.

**Paden**
Hier staat het pad waar het voorspellingsspel zijn gegevens opslaat. De standaard is `/tipps`; wijzig dat niet zonder goede reden. De toegangsgegevens van de voorspellers (bijnamen, wachtwoordhashes, adressen) staan in `addon/tipp/lmo-tipperauth.php`. Het bestand begint met een beveiligingsregel (`<?php exit; ?>`) die je niet mag verwijderen, en heeft schrijfrechten (666) nodig.

**Puntenverdeling**
Hier stel je de puntentoekenning in. Afhankelijk van de voorspelmodus zijn er verschillende opties; in de tendensmodus zijn er logischerwijs minder instellingen.

**Weergave**
Alle hier geactiveerde onderdelen verschijnen in de navigatiebalk van het voorspellingsspel.

**Regels**
Stel de **voorspeltermijn** in, bepaal **maximale teamgroottes** en hoeveel **dagen vooruit** er mag worden voorspeld. Ook kun je de **jokervoorspelling** activeren: daarmee kunnen voorspellers per speeldag één wedstrijd kiezen waarin een voorspelling meer punten oplevert. De **vermenigvuldigingsfactor** stel je hier in.

**Aanmelding**
Bepaal welke **gegevens** bij de aanmelding verplicht zijn, of er een **e-mailverificatie** plaatsvindt, of je een **melding** krijgt bij nieuwe aanmeldingen en of nieuwe voorspellers eerst door jou moeten worden **geactiveerd**.

**Voorspellen**
Stel het uiterlijk van het invullen van voorspellingen in. In de uitslagmodus kun je **pijlknoppen** tonen (zoals in de uitslageneditor). Om voorspellers houvast te geven, kun je **voorspelde tendensen** en **gemiddelde voorspellingen** tonen.

> Er zijn twee varianten voor het invullen: **per competitie** (per competitie en speeldag) of **per datum** (alle wedstrijden van meerdere competities in een periode). *Schakel je beide varianten uit, dan is voorspellen niet mogelijk.*

Je kunt ook instellen of de voorspellingsoverzichten bij het invullen **automatisch worden ververst**.

**Voorspellingsoverzicht**
Kies wanneer het voorspellingsoverzicht wordt getoond: direct na invoer, na de voorspeltermijn of pas na invoer van de uitslag. Ook bepaal je hoeveel voorspellers per pagina worden getoond.

**Voorspellingstabel**
Het voorspellingsspel berekent uit de ingevulde voorspellingen een tabel voor elke deelnemer. Je kunt een tabel van alle voorspellers of een tabel op basis van ingebrachte punten publiceren.

**Standentabellen**
Stel de weergave van de stand in: alleen het algemeen klassement of daarnaast afzonderlijke klassementen per competitie. Ook bepaal je welke persoonlijke gegevens (echte naam, bijnaam, e-mailadres) zichtbaar zijn en hoe gedetailleerd de puntenopbouw wordt getoond.

**Wat telt bij gelijke stand?**
Hier stel je zogenaamde tiebreakers in: bij voorspellers met gelijk aantal punten worden tot drie verdere criteria in aflopende prioriteit gebruikt.

**Extra berekeningen**
> Bepaal wat bij het invoeren van competitieuitslagen extra automatisch wordt berekend. Activeer je dit, dan is handmatig bijwerken niet meer nodig; bij heel veel deelnemers kunnen echter looptijdproblemen optreden, omdat deze stap veel rekenkracht vraagt.

**Voorspelbare competities**
Geef hier aan welke competities kunnen worden gespeeld, alle of alleen geselecteerde. *Alleen vrijgegeven competities kunnen door voorspellers worden afgesloten (geabonneerd).*
